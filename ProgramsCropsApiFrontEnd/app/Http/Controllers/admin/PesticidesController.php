<?php

namespace App\Http\Controllers\admin;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use PHPUnit\TextUI\Configuration\Php;
use Illuminate\Database\QueryException;

class PesticidesController extends Controller
{
    public function index()
    {
        $url = env('URL_SERVER_API');
        $responseCrops = Http::get($url . '/v1/diseases/');
        $diseases = $responseCrops->json()["data"];
        // dd($diseases);

        $disease_id = $diseases[0]['id'];
        $response = Http::get($url . '/v1/pesticides/');
        $pesticides = $response->json()["data"];
        // dd($pesticides);
        //dd($diseases, $pesticides, $disease_id);
        return view('admin.pesticide.AdminPesticideView', ['diseases' => $diseases, 'pesticides' => $pesticides, 'disease_id' => $disease_id]);
    }

    public function getDiseasePesticidaById($id)
    {
        $url = env('URL_SERVER_API');

        // Obtén la enfermedad por ID
        $responseDisease = Http::get($url . '/v1/diseases/' . $id);
        $disease = $responseDisease->json()["data"];

        $diseaseId = $disease['id'];

        // Obtén todos los pesticidas
        $responsePesticides = Http::get($url . '/v1/pesticides/');
        $allPesticides = $responsePesticides->json()["data"];

        // Filtra los pesticidas para que solo incluyan los relacionados con la enfermedad seleccionada
        $filteredPesticides = array_filter($allPesticides, function ($pesticide) use ($id) {
            return in_array($id, array_column($pesticide['diseases'], 'id'));
        });

        // Obtén la lista de enfermedades (si es necesario)
        $responseDiseases = Http::get($url . '/v1/diseases/');
        $diseases = $responseDiseases->json()["data"];

        return view('admin.pesticide.AdminPesticideView', ['diseases' => $diseases, 'pesticides' => $filteredPesticides, 'disease_id' => $diseaseId]);
    }

    public function create()
    {
        $url = env('URL_SERVER_API');
        $responseDisease = Http::get($url . '/v1/diseases/');
        $diseases = $responseDisease->json()["data"];
        return view('admin.pesticide.CreatePesticide', ['diseases' => $diseases, 'pesticide' => null]);
    }



    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'disease_ids' => 'required_without_all',
            'name' => 'required',
            'description' => 'required',
            'activeIngredient' => 'required',
            'price' => 'required',
            'type' => 'required',
            'dose' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            // Mover la imagen a la carpeta de almacenamiento
            $imageNamePesticide = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/pesticide/'), $imageNamePesticide);

            // Crear el pesticida directamente en la API
            $response = Http::post($url . '/v1/pesticides', [
                'name' => $request->name,
                'description' => $request->description,
                'activeIngredient' => $request->activeIngredient,
                'price' => $request->price,
                'type' => $request->type,
                'dose' => $request->dose,
                'image' => $imageNamePesticide,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['data']['id'])) {
                    $pesticideId = $responseData['data']['id'];

                    $diseaseIds = $request->disease_ids;

                    // Asociar el pesticida a las enfermedades seleccionadas
                    $responseDiseases = Http::post($url . '/v1/pesticides/' . $pesticideId . '/diseases', [
                        'disease_ids' => $diseaseIds,
                    ]);

                    // Verificar si la asociación de enfermedades fue exitosa
                    if ($responseDiseases->successful()) {
                        // Éxito: las enfermedades se asociaron correctamente
                        $message = 'Se creó el pesticida y se asociaron las enfermedades';
                        return redirect()->route('pesticides.index')->with('success', $message);
                    } else {
                        // Error: las enfermedades no se pudieron asociar
                        $errorMessage = $responseDiseases->json()['message'] ?? 'Ups.. Error al asociar enfermedades al pesticida';
                        $message = 'Ups.. el pesticida se creó pero no se pudieron asociar las enfermedades: ' . $errorMessage;
                        return redirect()->route('pesticides.index')->with('error', $message);
                    }
                }
            }

            // Si llegamos a este punto, algo salió mal
            $message = 'Ups.. el pesticida se creó pero no se pudo obtener el ID';
            return redirect()->route('pesticides.index')->with('error', $message);
        } catch (QueryException $e) {
            // Manejar excepciones, si es necesario
            $message = 'Error al procesar la solicitud';
            return redirect()->route('pesticides.index')->with('error', $message);
        }
    }






    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $responseDisease = Http::get($url . '/v1/diseases/');
        $diseases = $responseDisease->json()["data"];

        $responseDisease = Http::get($url . '/v1/pesticides/' . $id, ['with' => 'diseases']);
        $pesticideData = json_decode($responseDisease->getBody());

        // Asegúrate de que $pesticideData sea un objeto
        $pesticide = is_object($pesticideData) ? $pesticideData : null;


        return view('admin.pesticide.EditPesticide', ['diseases' => $diseases, 'pesticide' => $pesticide]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $url = env('URL_SERVER_API');

    $request->validate([
        'disease_ids' => 'required_without_all',
        'name' => 'required',
        'description' => 'required',
        'activeIngredient' => 'required',
        'price' => 'required',
        'type' => 'required',
        'dose' => 'required',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // Obtener la información actual del pesticida desde la API
    $responsePesticide = Http::get($url . '/v1/pesticides/' . $id);
    $pesticideData = $responsePesticide->json();

    // Obtener el nombre de la imagen actual
    $currentImageName = isset($pesticideData['image']) ? $pesticideData['image'] : null;

    // Procesar la nueva imagen si se proporciona
    $imageNamePesticide = $currentImageName;

    if ($request->hasFile('image')) {
        $imageNamePesticide = time() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/pesticide/'), $imageNamePesticide);
    }

    // Actualizar la información del pesticida en la API
    $response = Http::put($url . '/v1/pesticides/' . $id, [
        'name' => $request->name,
        'description' => $request->description,
        'activeIngredient' => $request->activeIngredient,
        'price' => $request->price,
        'type' => $request->type,
        'dose' => $request->dose,
        'image' => $imageNamePesticide,
        'disease_ids' => $request->disease_ids
    ]);

    // Manejar la respuesta de la API y redireccionar en consecuencia
    if ($response->successful()) {
        // Eliminar la imagen anterior si es diferente de la nueva
        if ($currentImageName && $currentImageName !== $imageNamePesticide) {
            unlink(public_path('storage/pesticide/') . $currentImageName);
        }

        $message = 'Se modificó el pesticida correctamente.';
        return redirect()->route('pesticides.index')->with('success', $message);
    } else {
        $message = 'Ups... No se pudo modificar el pesticida.';
        return redirect()->route('pesticides.index')->with('error', $message);
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)

    {
        $url = env('URL_SERVER_API');
        try {
            $responseGet = Http::get($url . '/v1/pesticides/' . $id);
            $data = $responseGet->json()["data"];


            if ($data) {
                $responseDelete = Http::delete($url . '/v1/pesticides/' . $data['id']);

                // Verifica si la eliminación fue exitosa
                if ($responseDelete->successful()) {
                    $message = 'El plaguicida  fue eliminado';
                    return redirect()->route('pesticides.index')->with('success', $message);
                } else {
                    $message = 'ups.. no se pudo eliminar el plaguicida';
                    return redirect()->route('pesticides.index')->with('error', $message);
                }
            } else {
                $message = 'El plaguicida no pudo ser encontrado';
                return redirect()->route('pesticides.index')->with('error', $message);
            }
        } catch (\Exception $e) {
            $message = 'Ocurrió un error al intentar eliminar el plaguicida: ' . $e->getMessage();
            return redirect()->route('pesticides.index')->with('error', $message);
        }
    }




    //-------------------------------------------------------------------------------
    //método de muchos a a muchos CropDisease


}
