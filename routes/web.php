<?php

use App\Http\Controllers\Api\CargoController;
use App\Http\Controllers\backend\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\homeController;
use App\Http\Controllers\Frontend\uitgebreidzoekenController;
use App\Http\Controllers\Frontend\overonsController;
use App\Http\Controllers\Frontend\zoekenController;
use App\Http\Controllers\Frontend\detailsController;


//backend controllers
use App\Http\Controllers\backend\ModelController;
use App\Http\Controllers\backend\TestController;
use App\Http\Middleware\BasicAuthenticate;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [homeController::class, 'index']);
Route::get('uitgebreidzoeken', [uitgebreidzoekenController::class, 'index']);
Route::get('overons', [overonsController::class, 'index']);
Route::get('zoeken', [zoekenController::class, 'index']);
Route::get('details', [detailsController::class, 'index']);



//backend routes 
Route::get('aanbod', [ModelController::class, 'display'])->name('aanbod');
Route::get('aanbodapi', [ModelController::class, 'json'])->name('aanbodapi');
Route::post('zoeken', [ModelController::class, 'search'])->name('zoeken');
Route::get('posttest', [ModelController::class, 'showPostFormPage'])->name('post-form-page');
Route::get('homemodels', [homeController::class, 'display']);
Route::get('detailsapi', [detailsController::class, 'show'])->name('detailsapi');
Route::get('images', [ImageController::class, 'getImage'])->name('images');

Route::post('webhook/endpoint', [CargoController::class, 'handleCar'])->middleware(BasicAuthenticate::class);


Route::get('test', [TestController::class, 'index']);
