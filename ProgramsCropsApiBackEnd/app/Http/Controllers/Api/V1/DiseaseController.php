<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DiseaseResource;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diseases = Disease::with('crops')->get();

        // $diseases = Disease::get();
        return DiseaseResource::collection($diseases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (isset($request->crop_ids) && count($request->crop_ids) != 0) {
            $disease = new Disease($request->all());
            $disease->save();
            $disease->crops()->sync($request->crop_ids);
            return response()->json([
                'message' => 'Los datos de la enfermedad han sido registrados',
                'data' => $disease
            ], Response::HTTP_ACCEPTED);
        }
        else {
            return response()->json([
                'message' => 'Error al registrar la enfermedad: (No hay cultivos asociados)'
            ], Response::HTTP_BAD_REQUEST);
        }


    }


    /**
     * Display the specified resource.
     */
    public function show(Disease $disease)
    {
        $disease->load('pesticides');
        return new DiseaseResource($disease);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disease $disease)
    {
        $disease->update($request->all());

        $disease->crops()->sync($request->crop_ids);

        return response()->json([
            'message' => 'Los datos de la enfermedad han sido modificados',
            'data' => $disease
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disease $disease)
    {
        $disease->crops()->detach();
        $disease->delete();

        return response()->json([
            'message' => 'Los datos de la semilla han sido eliminados'
        ], Response::HTTP_ACCEPTED);
    }
}
