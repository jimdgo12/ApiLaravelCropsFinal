<?php

namespace App\Http\Controllers\home;
use App\Utils;
use App\Models\Crop;
use App\Models\Seed;
use App\Models\Disease;
use App\Models\Fertilizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    public function index()
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/crops/');

        $crops = $response->json()["data"];
        // dd($response, $crops);
        return view('home.Index', ['crops' => $crops]);
    }

    public function getCropInformation($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/crops/' . $id);
        $crop = $response->json()["data"];
        // echo $variable;
        //var_dump($crop);
        return view('home.InformationCrop', ['crop' => $crop]);
    }

    public function getSeedsInformation($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/crops/' .$id);
        $crop = $response->json()["data"];

        //dd($crop);
        $response = Http::get($url . '/v1/seeds/');
        $seeds = $response->json()["data"];
        $seeds = $crop["seeds"];
        // dd($seeds);
        $seeds = array_chunk($seeds, 3);
        // dd($seeds);


        return view('home.InformationSeeds', ['crop' => $crop, 'seeds' => $seeds]);
    }



    public function getDiseasesInformation($id)
{
    $url = env('URL_SERVER_API');


    $Response = Http::get($url . '/v1/crops/' . $id);
    $crop = $Response->json()["data"];
    

    // Obtener todas las enfermedades
    $Response = Http::get($url . '/v1/diseases');
    $allDiseases = $Response->json()["data"];

    // Filtrar las enfermedades relacionadas al cultivo específico
    $relatedDiseases = collect($allDiseases)->filter(function ($disease) use ($id) {
        return collect($disease['crops'])->pluck('id')->contains($id);
    })->all();

    return view('home.InformationDiseases', ['crop' => $crop, 'diseases' => $relatedDiseases]);
}




public function getPesticidesInformation($cropId, $diseaseId)
{
    $url = env('URL_SERVER_API');

    // Obtener información del cultivo
    $cropResponse = Http::get($url . '/v1/crops/' . $cropId);
    $crop = $cropResponse->json()["data"];

    // Obtener información de la enfermedad específica
    $diseaseResponse = Http::get($url . '/v1/diseases/' . $diseaseId);
    $disease = $diseaseResponse->json()["data"];

    // Obtener todos los pesticidas
    $pesticidesResponse = Http::get($url . '/v1/pesticides');
    $allPesticides = $pesticidesResponse->json()["data"];

    // Filtrar los pesticidas que pertenecen a la enfermedad específica
    $relatedPesticides = collect($allPesticides)->filter(function ($pesticide) use ($diseaseId) {
        return collect($pesticide['diseases'])->pluck('id')->contains($diseaseId);
    })->all();

    return view('home.InformationPesticides', ['crop' => $crop, 'disease' => $disease, 'pesticides' => $relatedPesticides]);
}

    public function getFertilizersInformation($id)
    {
        $url = env('URL_SERVER_API');
    $responseCrop = Http::get($url . '/v1/crops/' . $id);
    $crop = $responseCrop->json()["data"];
    //dd($crop);
    $response = Http::get($url . '/v1/fertilizers/');
    $allFertilizers = $response->json()["data"];

    // Filtrar las enfermedades relacionadas al cultivo específico
    $relatedFertilizers = collect($allFertilizers)->filter(function ($fertilizer) use ($id) {
        return collect($fertilizer['crops'])->pluck('id')->contains($id);
    })->all();

    // dd($fertilizers);
        return view('home.InformationFertilizer', ['crop' => $crop, 'fertilizers' => $relatedFertilizers]);
    }
}
