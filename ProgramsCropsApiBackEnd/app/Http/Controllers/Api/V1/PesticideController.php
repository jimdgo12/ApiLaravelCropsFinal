<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Pesticide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PesticideResource;

class PesticideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesticides = Pesticide::with('diseases')->get();
        return PesticideResource::collection($pesticides);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $pesticide = new Pesticide($request->all());

        $pesticide->save();

        $pesticide->diseases()->sync($request->disease_ids);



        return response()->json([
            'message' => 'Los datos del pesticida han sido registrados',
            'data' => $pesticide
        ], Response::HTTP_ACCEPTED);//post
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesticide $pesticide)
    {
        $pesticide->load('diseases');
        return new PesticideResource($pesticide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesticide $pesticide)
    {
        $pesticide->update($request->all());
        $pesticide->diseases()->sync($request->disease_ids);



        return response()->json([
            'message' => 'Los datos del pesticida han sido modificados',
            'data' => $pesticide
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesticide $pesticide)
    {
        $pesticide->diseases()->detach();
        $pesticide->delete();

        return response()->json([
            'message' => 'Los datos del pesticidas han sido eliminados'
        ], Response::HTTP_ACCEPTED);
    }
}
