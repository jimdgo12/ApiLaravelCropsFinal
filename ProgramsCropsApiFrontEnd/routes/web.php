<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\home\IndexController;

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CropsController;
use App\Http\Controllers\admin\DiseaseController;

use App\Http\Controllers\auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticationSessionController;
use App\Http\Controllers\admin\FertilizersController;
use App\Http\Controllers\admin\PesticidesController;
use App\Http\Controllers\admin\SeedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//================== RUTAS PUBLICAS ========================

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/crop/{id}', [IndexController::class, 'getCropInformation'])->name('informationCrop');
Route::get('/seeds/{id}', [IndexController::class, 'getSeedsInformation'])->name('informationSeeds');
Route::get('/diseases/{id}', [IndexController::class, 'getDiseasesInformation'])->name('informationDiseases');
Route::get('/fertilizers/{id}', [IndexController::class, 'getFertilizersInformation'])->name('informationFertilizers');
Route::get('/pesticides/{crop}/{disease}', [IndexController::class, 'getPesticidesInformation'])->name('informationPesticides');

//================== RUTAS ADMIN ==========================
Route::get('/admin/welcome', [AdminController::class, 'welcome'])->name('WelcomeAdmin');
Route::resource('/admin/crops', CropsController::class);
Route::resource('/admin/seeds', SeedController::class);
Route::resource('/admin/fertilizers', FertilizersController::class);
Route::resource('/admin/diseases', DiseaseController::class);
Route::resource('/admin/pesticides', PesticidesController::class);



// Route::get('/admin/diseases/crop/{id}', [DiseaseController::class, 'getCropDiseaseById']);
Route::get('/admin/diseases/crop/{id}', [DiseaseController::class, 'getCropDiseaseById'])
    ->name('admin.diseases.crop');
Route::get('/admin/fertilizers/crop/{id}', [FertilizersController::class, 'getCropFertilizerById']);
Route::get('/admin/pesticides/disease/{id}', [PesticidesController::class, 'getDiseasePesticidaById']);

// Route::get('/admin/diseases/create/{id}', [DiseaseController::class, 'createDisease'])->name('createDisease');
//  Route::get('/admin/fertilizers/create/{id}', [FertilizersController::class, 'createFertilizer'])->name('createFertilizer');
// Route::get('/admin/pesticides/create/{id}', [PesticidesController::class, 'createPesticide'])->name('createPesticides');

// Route::get('/statistics', [FertilizersController::class, 'graficas'])->name('grafica');



//================= RUTAS DE SESIÓN =======================
Route::get('/login', [AuthenticationSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticationSessionController::class, 'store'])->name('start');
Route::post('/logout', [AuthenticationSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('save');

//crear asociaciones


// Route::post('/v1/diseases/{id}/crops', 'DiseaseController@associateCrops')->name('diseases.associateCrops');
// Route::get('/v1/diseases/{id}/crops', 'DiseaseController@associateCrops')->name('diseases.associateCrops');
// Route::post('/diseases/{id}/crops', 'admin/DiseaseController@associateCrops')->name('diseases.associateCrops');


Route::post('/diseases/{id}/crops', 'admin\DiseaseController@associateCrops')->name('diseases.associateCrops');





// Route::get('/fertilizers/{crop}', [IndexController::class, 'graficas'])->name('viewGrafics');
