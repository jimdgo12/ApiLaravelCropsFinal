<?php

namespace App\Http\Controllers\admin;

use App\Models\Crop;
use App\Models\Seed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;

class SeedController extends Controller
{
    public function index()
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/seeds');
        $seeds = $response->json()["data"];
        return view('admin.seed.AdminSeedView', ['seeds' => $seeds]);
    }


    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/crops');
        $crops = $response->json()["data"];
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/seeds');
        $seed = $response->json()["data"];
        return view('admin.seed.CreateSeed', ['crops' => $crops, 'seed' => null]);
    }


    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'name' => 'required|regex:/^([A-Za-zÑñ\s]*)$/|between:3,50',
            'nameScientific' => 'required',
            'origin' => 'required',
            'morphology' => 'required',
            'type' => 'required',
            'quality' => 'required',
            'spreading' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'


        ]);


        try {

            //Obtener el nombre de la imagen usando la función time()
            //Para generar un nombre aleatorio
            $imageNameSeed = time() . '.' . $request->image->extension();
            //Copiar la imagen al directorio public
            $request->image->move(public_path('storage/seed/'), $imageNameSeed);

            $response = Http::post($url . '/v1/seeds', [
                'name' => $request->name,
                'nameScientific' => $request->nameScientific,
                'origin' => $request->origin,
                'morphology' => $request->morphology,
                'type' => $request->type,
                'quality' => $request->quality,
                'spreading' => $request->spreading,
                'image' => $imageNameSeed,
                'crop_id' => $request->crop_id
            ]);

            $message = 'Se creo una semilla';

            return redirect()->route('seeds.index')->with('success', $message);
        } catch (QueryException $e) {
            $message = 'ups.. la semilla no fue creada';
            return redirect()->route('seeds.index')->with('error', $message);
        }
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Request $request)
    {
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(Request $request, $id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/crops/');
        $crops = $response->json()["data"];
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/seeds/'  . $id);
        $seed = $response->json()["data"];
        // dd($seed);
        return view('admin.seed.EditSeed', ['crops' => $crops, 'seed' => $seed]);
    }

    /**
     * Update the specified resource in storage.
     */




    public function update(Request $request, $seedId)
{
    $url = env('URL_SERVER_API');
    try {
        Log::info('Datos antes de la actualización:', $request->all());

        $responseGetSeed = Http::get($url . '/v1/seeds/' . $seedId);
            $seed = $responseGetSeed->json()["data"];
            // dd($seed);
        $request->validate([
            // Ajusta las reglas de validación según tus necesidades
            'name' => 'required',
            'nameScientific' => 'required',
            'origin' => 'required',
            'morphology' => 'required',
            'type' => 'required',
            'quality' => 'required',
            'spreading' => 'required',
            'image' => 'required',
        ]);


        // Obtén la semilla existente
        $responseGet = Http::get($url . '/v1/seeds/' . $seedId);
        $seed = $responseGet->json()["data"];

        // Verifica los datos de la semilla antes de la actualización
        // dd($request);

        if ($request->hasFile('image')) {

            $imageNameSeed = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/seed'), $imageNameSeed);
            $imageUrl = asset('storage/seed/' . $imageNameSeed);
        } else {

            $imageNameSeed = $seed['image'];
            $imageUrl = asset('storage/seed/' . $imageNameSeed);
        }
        // dd("Datos de la semilla antes de la actualización:", $request->all());


        $response = Http::put($url . '/v1/seeds/' . $seedId, [
            'name' => $request->name,
                'description' => $request->description,
                'nameScientific' => $request->nameScientific,
                'history' => $request->history,
                'phaseFertilizer' => $request->phaseFertilizer,
                'phaseHarvest' => $request->phaseHarvest,
                'spreading' => $request->spreading,
                'image' => $imageNameSeed,
                'crop_id' => $seed['crop']['id'], // Mantén el mismo cultivo
            ]);
        // Log::info('Datos después de la actualización:', $response->json());

            // Log::info('Datos de la solicitud después de la validación:', $request->all());
            // dd("Respuesta de la API después de la actualización:", $response->json());

            if ($response->successful()) {
                return redirect()->route('seeds.index')->with('success', 'La semilla fue actualizada ')->with('imageUrl', $imageUrl);
            } else {
                return redirect()->route('seeds.index')->withErrors(['error' => ' Ups...No se pudo actualizar la semilla']);
            }
        } catch (\Exception $e) {

            $message = 'ups...Hubo un problema al intentar modificar la semilla: ' . $e->getMessage();
            Log::error('Error al procesar la solicitud: ' . $e->getMessage());
            return redirect()->route('seeds.index')->with('error', $message);
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,$id)
    {
        $url = env('URL_SERVER_API');
        try {
            $responseGet = Http::get($url . '/v1/seeds/' . $id);
            $data = $responseGet->json()["data"];

            // Asegúrate de que se haya encontrado el cultivo antes de intentar eliminarlo
            if ($data) {
                $responseDelete = Http::delete($url . '/v1/seeds/' . $data['id']);

                // Verifica si la eliminación fue exitosa
                if ($responseDelete->successful()) {
                    $message = ' La semilla fue eliminada';
                    return redirect()->route('seeds.index')->with('success', $message);
                } else {
                    $message = 'Ups...No se pudo eliminar la semilla';
                    return redirect()->route('seeds.index')->with('error', $message);
                }
            } else {
                $message = 'La semilla no pudo ser encontrada';
                return redirect()->route('seeds.index')->with('error', $message);
            }
        } catch (\Exception $e) {
            $message = 'Ocurrió un error al intentar eliminar la semilla: ' . $e->getMessage();
            return redirect()->route('seeds.index')->with('error', $message);
        }
    }

    // //___________________________________________________________________________________________________________





    // //-------------------------------------------------------------------------------
    // //método de muchos a a muchos CropDisease

}
