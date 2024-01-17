<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CropResource;


class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crop = Crop::get();
        return CropResource::collection($crop);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $crop = new Crop(
            [
                "name" => $request->input('name'),
                "description" => $request->input('description'),
                "nameScientific" => $request->input('nameScientific'),
                "history" => $request->input('history'),
                "phaseFertilizer" => $request->input('phaseFertilizer'),
                "phaseHarvest" => $request->input('phaseHarvest'),
                "spreading" => $request->input('spreading'),
                "image" => $request->input('image')
            ]
        );

        $crop->save();

        return response()->json([
            'message' => 'Los datos del cultivo han sido registrados',
            'data' => $crop
        ], Response::HTTP_ACCEPTED);//post

    }

    /**
     * Display the specified resource.
     */
    public function show(Crop $crop)
    {
        // $crop->load('diseases');
        return new CropResource($crop);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crop $crop)
    {
        $crop->update($request->all());

        return response()->json([
            'message' => 'Los datos del cultivo han sido modificados',
            'data' => $crop
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crop $crop)
    {
        $crop->delete();

        return response()->json([
            'message' => 'Los datos del cultivo han sido eliminados'
        ], Response::HTTP_ACCEPTED);
    }
}
