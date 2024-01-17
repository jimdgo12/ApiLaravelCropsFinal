<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Seed;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SeedResource;

class SeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seeds = Seed::get();
        return SeedResource::collection($seeds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seed = new Seed();
        $seed->name = $request->input('name');
        $seed->nameScientific = $request->input('nameScientific');
        $seed->origin = $request->input('origin');
        $seed->morphology = $request->input('morphology');
        $seed->type = $request->input('type');
        $seed->quality = $request->input('quality');
        $seed->spreading = $request->input('spreading');
        $seed->image = $request->input('image');
        $seed->crop_id = $request->input('crop_id');

        $seed->save();

        return response()->json([
            'message' => 'Los datos de la semilla han sido registrados',
            'data' => $seed
        ], Response::HTTP_ACCEPTED);//post
    }

    /**
     * Display the specified resource.
     */
    public function show(Seed $seed)
    {
        return new SeedResource($seed);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seed $seed)
    {
        $seed->update($request->all());

        return response()->json([
            'message' => 'Los datos de la semilla han sido modificados',
            'data' => $seed
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seed $seed)
    {
        $seed->delete();

        return response()->json([
            'message' => 'Los datos de la semilla han sido eliminados'
        ], Response::HTTP_ACCEPTED);
    }
}
