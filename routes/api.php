<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/state', 'ApiController@state');
Route::get('/api-version', 'ApiController@apiVersion');
Route::get('/process-info/{name}', 'ApiController@processInfo');
Route::post('/start-process', 'ApiController@startProcess');
Route::get('/process-stdout-log', 'ApiController@processStdoutLog');
