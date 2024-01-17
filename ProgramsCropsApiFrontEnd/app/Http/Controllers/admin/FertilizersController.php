<?php

namespace App\Http\Controllers\admin;

use App\Models\Crop;
use App\Models\Fertilizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use PHPUnit\TextUI\Configuration\Php;
use Illuminate\Database\QueryException;

class FertilizersController extends Controller
{
    public function index()
    {
        $url = env('URL_SERVER_API');
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];

        $crop_id = $crops[0]['id'];
        $response = Http::get($url . '/v1/fertilizers/');
        $fertilizers = $response->json()["data"];
        // dd($diseases);
        return view('admin.fertilizer.AdminFertilizerView', ['crops' => $crops, 'fertilizers' => $fertilizers, 'crop_id' => $crop_id]);
    }

    public function getCropFertilizerById($id)
    {
        $url = env('URL_SERVER_API');
        $responseCrop = Http::get($url . '/v1/crops/' . $id);
        $crop = $responseCrop->json()["data"];
        $cropId = $crop ? $crop['id'] : null;

        // Obtén todas las enfermedades
        $responseFertilizers = Http::get($url . '/v1/fertilizers/');
        $allFertilizers = $responseFertilizers->json()["data"] ?? [];

        // Filtra las enfermedades para que solo incluyan las relacionadas con el fertilizante seleccionado
        $filteredFertilizer = array_filter($allFertilizers, function ($fertilizer) use ($id) {
            return in_array($id, array_column($fertilizer['crops'], 'id'));
        });

        // Obtén la lista de cultivos (si es necesario)
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];



        return view('admin.fertilizer.AdminFertilizerView', ['crops' => $crops, 'fertilizers' => $filteredFertilizer, 'crop_id' => $cropId]);
    }


    public function create()
    {
        $url = env('URL_SERVER_API');
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];
        return view('admin.fertilizer.CreateFertilizer', ['crops' => $crops, 'fertilizer' => null]);
    }

    public function graficas()
    {
        $datos = DB::select('select cr.name cultivo, fe.name fertilizante, fe.price from fertilizers fe
        inner join crop_fertilizers cf on fe.id = cf.fertilizer_id
        inner join crops cr on cr.id = cf.fertilizer_id
        where cf.crop_id =2');
        //dd($datos);

        $json = "[";
        foreach ($datos as $obj) {
            $json = $json . "{";
            $json = $json . '"name":"' . $obj->fertilizante . '",';
            $json = $json . '"y":' . $obj->price;
            $json = $json . "},";
        }
        $json = $json . "]";
        $json = str_replace(",]", "]", $json);


        return view('admin.fertilizer.Grafic', ['datas' => $json]);
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([

            'crop_ids' => 'required_without_all',
            'name' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,50',
            'description' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,300',
            'dose' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,150',
            'price' => 'required|integer|between:5,30000',
            'type' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,50',
            'image' => 'required', 'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'

        ]);

        try {

            $imageNameFertilizer = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/fertilizer/'), $imageNameFertilizer);

            $response  =  Http::post(
                $url . '/v1/fertilizers',
                [
                    'name' => $request->name,
                    'description' => $request->description,
                    'dose' => $request->dose,
                    'price' => $request->price,
                    'type' => $request->type,
                    'image' => $imageNameFertilizer
                ]
            );

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['data']['id'])) {
                    $fertilizerId = $responseData['data']['id'];
                    $cropIds = $request->crop_ids;
                    // dd($cropIds);

                    // Asociar la enfermedad a los cultivos seleccionados
                    $responseCrops = Http::post($url . '/api/v1/fertilizers/' . $fertilizerId . '/crops', [
                        'crop_ids' => $cropIds,
                    ]);
                    // dd('Llamada a associateCrops');

                    // dd($responseCrops->json());


                    // info('Trying to associate crops to disease: ' . $url . '/v1/diseases/' . $fertilizerId . '/crops');
                    // info('Respuesta de la creación de enfermedad: ' . json_encode($response->json()));


                    // Verificar si la asociación de cultivos fue exitosa
                    if ($responseCrops->successful()) {
                        // Éxito: los cultivos se asociaron correctamente
                        $message = 'Se creó el fertilizante y se asociaron los cultivos';
                        return redirect()->route('fertilizers.index')->with('success', $message);
                    } else {
                        // Error: los cultivos no se pudieron asociar
                        $errorMessage = $responseCrops->json()['message'] ?? 'Ups.. Error al asociar cultivos al fertilizante';
                        $message = 'Ups.. el fertilizante se creó pero no se pudieron asociar los cultivos: ' . $errorMessage;
                        return redirect()->route('fertilizers.index')->with('error', $message);
                    }
                }
            }

            // Si llegamos a este punto, algo salió mal
            $message = 'Ups.. el fertilizante se creó pero no se pudo obtener el ID';
            return redirect()->route('fertilizers.index')->with('error', $message);
        } catch (\Exception $e) {
            // Manejar excepciones, si es necesario
            $message = 'Error al procesar la solicitud';
            return redirect()->route('fertilizers.index')->with('error', $message);
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

        $responseCrop = Http::get($url . '/v1/crops/');
        $crop = $responseCrop->json()["data"];
        // dd($crop);

        $responseFertilizer = Http::get($url . '/v1/fertilizers/' . $id, ['with' => 'crops']);
        $fertilizerData = json_decode($responseFertilizer->getBody());

        // Asegúrate de que $fertilizerData sea un objeto
        $fertilizer = is_object($fertilizerData) ? $fertilizerData : null;

        // dd($fertilizer);

        return view('admin.fertilizer.EditFertilizer', ['crop' => $crop, 'fertilizer' => $fertilizer]);
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
            $responseGet = Http::get($url . '/v1/fertilizers/' . $id);
            $data = $responseGet->json()["data"];

            // Asegúrate de que se haya encontrado el fertilizante antes de intentar eliminarlo
            if ($data) {
                $responseDelete = Http::delete($url . '/v1/fertilizers/' . $data['id']);

                // Verifica si la eliminación fue exitosa
                if ($responseDelete->successful()) {
                    $message = 'El fertilizan fue eliminado';
                    return redirect()->route('fertilizers.index')->with('success', $message);
                } else {
                    $message = 'ups.. no se pudo eliminar el fertilizante';
                    return redirect()->route('fertilizers.index')->with('error', $message);
                }
            } else {
                $message = 'El fertilizante no pudo ser encontrado';
                return redirect()->route('fertilizers.index')->with('error', $message);
            }
        } catch (\Exception $e) {
            $message = 'Ocurrió un error al intentar eliminar el fertilizante: ' . $e->getMessage();
            return redirect()->route('fertilizers.index')->with('error', $message);
        }
    }
    //___________________________________________________________________________________________________________





    //-------------------------------------------------------------------------------
    //método de muchos a a muchos CropDisease


}
