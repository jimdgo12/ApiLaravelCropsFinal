<?php

use App\Models\Pesticide;
use App\Models\Fertilizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CropController;
use App\Http\Controllers\Api\V1\SeedController;
use App\Http\Controllers\Api\V1\DiseaseController;
use App\Http\Controllers\Api\V1\PesticideController;
use App\Http\Controllers\Api\V1\FertilizerController;
use App\Http\Controllers\Api\V1\SessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('v1/crops', CropController::class);
Route::apiResource('v1/seeds', SeedController::class);
Route::apiResource('v1/diseases', DiseaseController::class);
Route::apiResource('v1/fertilizers', FertilizerController::class);
Route::apiResource('v1/pesticides', PesticideController::class);


// Route::post('v1/diseases/{id}/crops', '\DiseaseController@getAssociatedCrops')->name('diseases.associatedCrops');


//__________________________________________________________________________________________________________________
Route::post('login',[SessionController::class,'login']);
Route::post('logout',[SessionController::class,'logout'])->middleware('auth:sanctum');
Route::post('register',[SessionController::class,'register']);



