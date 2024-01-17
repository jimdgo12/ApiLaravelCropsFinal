<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Fertilizer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FertilizerResource;

class FertilizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fertilizers = Fertilizer::with('crops')->get();
        return FertilizerResource::collection($fertilizers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fertilizer = new Fertilizer($request->all());

        $fertilizer->save();

        $fertilizer->crops()->sync($request->crop_ids);

        return response()->json([
            'message' => 'Los datos del fertilizante han sido registrados',
            'data' => $fertilizer
        ], Response::HTTP_ACCEPTED);//post

    }

    /**
     * Display the specified resource.
     */
    public function show(Fertilizer $fertilizer)
    {
        return new FertilizerResource($fertilizer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fertilizer $fertilizer)
    {
        $fertilizer->update($request->all());

        $fertilizer->crops()->sync($request->crop_ids);

        return response()->json([
            'message' => 'Los datos del fertilizante han sido modificados',
            'data' => $fertilizer
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fertilizer $fertilizer)
    {
        $fertilizer->crops()->detach();

        $fertilizer->delete();

        return response()->json([
            'message' => 'Los datos del fertilizante han sido eliminados'
        ], Response::HTTP_ACCEPTED);
    }
}
