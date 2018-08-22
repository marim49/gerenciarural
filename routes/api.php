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
Route::get('teste', function(){
    $user = [
        'name' => 'Admin',
        'email' => 'admin@mail.com',
        'password' => bcrypt('admin')
    ];

    $user = \App\User::create($user);
    return response()->json([
        'status' => 'success',
        'item' => $user
    ]);
});
