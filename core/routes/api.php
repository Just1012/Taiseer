<?php

use App\Http\Controllers\APIs\APIsController;
use App\Http\Controllers\APIs\ShipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/website/status', [APIsController::class,'website_status']);
// Route::get('/topic/maps/{topic_id}/{lang?}', [APIsController::class,'topic_maps']);
// Route::get('/section/{section_id}', 'APIsController@section');
// Route::get('/topics/{section_id}/page/{page_number?}/count/{topics_count?}/{lang?}', [APIsController::class,'topics']);
// Route::get('/getShipment',[ShipmentController::class,'shipment']);
