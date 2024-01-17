<?php

namespace App\Http\Controllers\admin;


use App\Models\Crop;
use App\Models\Seed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class CropsController extends Controller
{

    public function index(Request $request)
    {
        $url = env('URL_SERVER_API');

        // Obtén la lista de cultivos
        $responseCrops = Http::get($url . '/v1/crops/');
        $crops = $responseCrops->json()["data"];

        return view('admin.crop.AdminCropView', ['crops' => $crops]);

        // // Obtén la lista de enfermedades
        // $responseDiseases = Http::get($url . '/v1/diseases');
        // $diseases = $responseDiseases->json("data");

        // // Obtén el primer cultivo o el que se especifique en la solicitud
        // $crop_id = $request->input('crop_id', isset($crops[0]['id']) ? $crops[0]['id'] : null);

        // return response()->json([
        //     'crops' => $crops,
        //     'diseases' => $diseases,
        //     'crop_id' => $crop_id,
        // ]);
    }
    public function create()
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/seeds');
        $seeds = $response->json("data");
        return view('admin.crop.CreateCrop', ['seeds' => $seeds, 'crop' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $url = env('URL_SERVER_API');

        $request->validate([
            'name' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,50',
            'description' => 'required',
            'nameScientific' => 'required',
            'history' => 'required',
            'phaseFertilizer' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'

        ]);

        try {

            //Obtener el nombre de la imagen usando la función time()
            //Para generar un nombre aleatorio
            $imageNameCrop = time() . '.' . $request->image->extension();
            //Copiar la imagen al directorio public
            $request->image->move(public_path('storage/crop/'), $imageNameCrop);
            //dd($imageNameCrop);

            $response = Http::post($url . '/v1/crops', [

                'name' => $request->name,
                'description' => $request->description,
                'nameScientific' => $request->nameScientific,
                'history' => $request->history,
                'phaseFertilizer' => $request->phaseFertilizer,
                'phaseHarvest' => $request->phaseHarvest,
                'spreading' => $request->spreading,
                'image' => $imageNameCrop,
                'seed_id' => $request->seed_id
            ]);

            $message = 'Se creo el cultivo';

            return redirect()->route('crops.index')->with('success', $message);
        } catch (QueryException $e) {
            $message = 'ups.. el cultivo no fue creado';
            return redirect()->route('crops.index')->with('error', $message);
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

        // Obtener la información de las semillas
        $response = Http::get($url . '/v1/seeds');
        $seeds = $response->json()["data"];

        // Obtener la información del cultivo específico
        $response = Http::get($url . '/v1/crops/' . $id);
        $crop = $response->json()["data"];

        return view('admin.crop.EditCrop', ['seeds' => $seeds, 'crop' => $crop]);
    }




    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        try {
            // Acceder a la información del cultivo desde la API al principio
            $responseGet = Http::get($url . '/v1/crops/' . $id);
            $crop = $responseGet->json()["data"];

            $request->validate([
                'name' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,50',
                'description' => 'required',
                'nameScientific' => 'required',
                'history' => 'required',
                'phaseFertilizer' => 'required',
                'phaseHarvest' => 'required',
                'spreading' => 'required',
                'image' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]);

            // Eliminar la imagen existente si hay una nueva imagen
            if ($request->hasFile('image')) {
                $existingImagePath = public_path('storage/crop/' . $crop['image']);
                if (file_exists($existingImagePath)) {
                    Storage::delete('crop/' . $crop['image']);
                }
            }

            // Mover la nueva imagen
            if ($request->hasFile('image')) {
                $imageNameCrop = time() . '.' . $request->image->extension();
                $request->image->move(public_path('storage/crop'), $imageNameCrop);
                $imageUrl = asset('storage/crop/' . $imageNameCrop);
            } else {
                $imageNameCrop = $crop['image'];
                $imageUrl = asset('storage/crop/' . $imageNameCrop);
            }

            $response = Http::put($url . '/v1/crops/' . $id, [
                'name' => $request->name,
                'description' => $request->description,
                'nameScientific' => $request->nameScientific,
                'history' => $request->history,
                'phaseFertilizer' => $request->phaseFertilizer,
                'phaseHarvest' => $request->phaseHarvest,
                'spreading' => $request->spreading,
                'image' => $imageNameCrop,
                'seed_id' => $request->seed_id,
            ]);

            if ($response->successful()) {
                return redirect()->route('crops.index')->with('success', 'Cultivo actualizado exitosamente')->with('imageUrl', $imageUrl);
            } else {
                return redirect()->route('crops.index')->withErrors(['error' => 'No se pudo actualizar el cultivo']);
            }
        } catch (\Exception $e) {
            $message = 'Hubo un problema al intentar modificar el cultivo: ' . $e->getMessage();
            Log::error($message);
            return redirect()->route('crops.index')->with('error', $message);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $url = env('URL_SERVER_API');
        try {
            $responseGet = Http::get($url . '/v1/crops/' . $id);
            $data = $responseGet->json()["data"];

            // Asegúrate de que se haya encontrado el cultivo antes de intentar eliminarlo
            if ($data) {
                $responseDelete = Http::delete($url . '/v1/crops/' . $data['id']);

                // Verifica si la eliminación fue exitosa
                if ($responseDelete->successful()) {
                    $message = 'El cultivo fue eliminado';
                    return redirect()->route('crops.index')->with('success', $message);
                } else {
                    $message = 'ups.. no se pudo eliminar el cultivo';
                    return redirect()->route('crops.index')->with('error', $message);
                }
            } else {
                $message = 'El cultivo no pudo ser encontrado';
                return redirect()->route('crops.index')->with('error', $message);
            }
        } catch (\Exception $e) {
            $message = 'Ocurrió un error al intentar eliminar el cultivo: ' . $e->getMessage();
            return redirect()->route('crops.index')->with('error', $message);
        }
    }




    //___________________________________________________________________________________________________________





    //-------------------------------------------------------------------------------
    //método de muchos a a muchos CropDisease


}
