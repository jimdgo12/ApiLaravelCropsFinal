<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;

class DiseaseController extends Controller
{

    public function associateCrops(Request $request, $id)
    {
        try {
            $url = env('URL_SERVER_API');
            $response = Http::post($url . '/api/v1/diseases/' . $id . '/crops', [
                'crop_ids' => $request->crop_ids,
            ]);

            if ($response->successful()) {
                $message = 'Se asociaron los cultivos a la enfermedad';
                return redirect()->route('diseases.index')->with('success', $message);
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error al asociar cultivos a la enfermedad';
                $message = 'Error: ' . $errorMessage;
                return redirect()->route('diseases.index')->with('error', $message);
            }
        } catch (\Exception $e) {
            // Manejar excepciones del lado del cliente
            $message = 'Error al procesar la solicitud: ' . $e->getMessage();
            return redirect()->route('diseases.index')->with('error', $message);
        }
    }


    public function index()
    {
        $url = env('URL_SERVER_API');
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];

        $crop_id = $crops[0]['id'];
        $response = Http::get($url . '/v1/diseases/');
        $diseases = $response->json()["data"];
        // dd($diseases);

        return view('admin.disease.AdminDiseaseView', ['crops' => $crops, 'diseases' => $diseases, 'crop_id' => $crop_id]);
    }

    public function getCropDiseaseById($id)
    {
        $url = env('URL_SERVER_API');

        // Obtén información del cultivo
        $responseCrop = Http::get($url . '/v1/crops/' . $id);
        $cropData = $responseCrop->json()["data"];
        $cropId = $cropData ? $cropData['id'] : null;

        // Verifica si se obtuvo información del cultivo
        if (!$cropData) {
            // Manejo de caso donde no se encuentra el cultivo
            return abort(404); // o devuelve una vista o mensaje adecuado
        }

        // Obtén todas las enfermedades
        $responseDiseases = Http::get($url . '/v1/diseases/');
        $allDiseases = $responseDiseases->json()["data"] ?? [];

        // Filtra las enfermedades para que solo incluyan las relacionadas con el cultivo seleccionado
        $filteredDiseases = array_filter($allDiseases, function ($disease) use ($id) {
            return in_array($id, array_column($disease['crops'], 'id'));
        });

        // Obtén la lista de cultivos (si es necesario)
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];

        return view('admin.disease.AdminDiseaseView', ['crops' => $crops, 'diseases' => $filteredDiseases, 'crop_id' => $cropId]);
    }




    public function create()
    {
        $url = env('URL_SERVER_API');
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];

        return view('admin.disease.CreateDisease', ['crops' => $crops, 'disease' => null]);
    }


    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');
        // dd($request->all());

        $request->validate([
            'crop_ids' => 'required_without_all',
            'nameCommon' => 'required',
            'nameScientific' => 'required',
            'description' => 'required',
            'diagnosis' => 'required',
            'symptoms' => 'required',
            'transmission' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            // Mover la imagen a la carpeta de almacenamiento
            $imageNameDisease = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/disease/'), $imageNameDisease);

            // Crear la enfermedad directamente en la API
            $response = Http::post($url . '/v1/diseases', [
                'nameCommon' => $request->nameCommon,
                'nameScientific' => $request->nameScientific,
                'description' => $request->description,
                'diagnosis' => $request->diagnosis,
                'symptoms' => $request->symptoms,
                'transmission' => $request->transmission,
                'type' => $request->type,
                'image' => $imageNameDisease,
                'crop_ids' => $request->crop_ids
            ]);

            if ($response->successful()) {
                $message = 'Se creó la enfermedad y se asociaron los cultivos';
                return redirect()->route('diseases.index')->with('success', $message);
            } else {
                $message = 'Error al registrar la enfermedad';
                return redirect()->route('diseases.index')->with('error', $message);
            }
        } catch (\Throwable $e) {
            // Manejar excepciones, si es necesario
            $message = 'Error al procesar la solicitud';
            return redirect()->route('diseases.index')->with('error', $message);
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $responseCrop = Http::get($url . '/v1/crops/');
        $crop = $responseCrop->json()["data"];

        $responseDisease = Http::get($url . '/v1/diseases/' . $id, ['with' => 'crops']);
        $diseaseData = json_decode($responseDisease->getBody());

        // Asegúrate de que $diseaseData sea un objeto
        $disease = is_object($diseaseData) ? $diseaseData : null;

        // dd($disease);

        return view('admin.disease.EditDisease', ['crop' => $crop, 'disease' => $disease]);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'crop_ids' => 'required_without_all',
            'nameCommon' => 'required',
            'nameScientific' => 'required',
            'description' => 'required',
            'diagnosis' => 'required',
            'symptoms' => 'required',
            'transmission' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Obtener la información actual de la enfermedad desde la API
        $responseDisease = Http::get($url . '/v1/diseases/' . $id);
        $diseaseData = $responseDisease->json();

        // Obtener el nombre de la imagen actual
        $currentImageName = $diseaseData['image'];

        // Procesar la nueva imagen
        $imageNameDisease = time() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/disease/'), $imageNameDisease);

        // Actualizar la información de la enfermedad en la API
        $response = Http::put($url . '/v1/diseases/' . $id, [
            'nameCommon' => $request->nameCommon,
            'nameScientific' => $request->nameScientific,
            'description' => $request->description,
            'diagnosis' => $request->diagnosis,
            'symptoms' => $request->symptoms,
            'transmission' => $request->transmission,
            'type' => $request->type,
            'image' => $imageNameDisease,
            // 'crop_id' => $request->crop_id
        ]);

        // Manejar la respuesta de la API y redireccionar en consecuencia
        if ($response->successful()) {
            // Eliminar la imagen anterior si es diferente de la nueva
            if ($currentImageName && $currentImageName !== $imageNameDisease) {
                unlink(public_path('storage/disease/') . $currentImageName);
            }

            $message = 'Se modificó la enfermedad correctamente.';
            return redirect()->route('diseases.index')->with('success', $message);
        } else {
            $message = 'Ups... No se pudo modificar la enfermedad.';
            return redirect()->route('diseases.index')->with('error', $message);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(Request $request, $id)

    {
        $url = env('URL_SERVER_API');
        try {
            $responseGet = Http::get($url . '/v1/diseases/' . $id);
            $data = $responseGet->json()["data"];

            // Asegúrate de que se haya encontrado la enfermedad antes de intentar eliminarla
            if ($data) {
                $responseDelete = Http::delete($url . '/v1/diseases/' . $data['id']);

                // Verifica si la eliminación fue exitosa
                if ($responseDelete->successful()) {
                    $message = 'La enfermedad fue eliminada';
                    return redirect()->route('diseases.index')->with('success', $message);
                } else {
                    $message = 'ups.. no se pudo eliminar la enfermedad';
                    return redirect()->route('diseases.index')->with('error', $message);
                }
            } else {
                $message = 'La enfermedad no pudo ser encontrada';
                return redirect()->route('diseases.index')->with('error', $message);
            }
        } catch (\Exception $e) {
            $message = 'Ocurrió un error al intentar eliminar la enfermedad: ' . $e->getMessage();
            return redirect()->route('diseases.index')->with('error', $message);
        }
    }
}
