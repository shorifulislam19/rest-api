<?php

use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// get api for fetch user
Route::get('/users/{id?}',[UserApiController::class ,'show_user']);

// post api for add user
Route::post('/add_users',[UserApiController::class , 'add_users']);

// post api for multiple user
Route::post('/add_multiple_users',[UserApiController::class , 'add_multiple_users']);

// put api for update_user_details
Route::put('/update_user_details/{id}',[UserApiController::class , 'update_user_details']);

// patch api for update_single_records
Route::patch('/update_single_records/{id}',[UserApiController::class , 'update_single_records']);


// delete api for delete_single_user
Route::delete('/delete_single_user/{id}',[UserApiController::class , 'delete_single_user']);

// delete api for delete_single_user_with_json
Route::delete('/delete_single_user_with_json',[UserApiController::class , 'delete_single_user_with_json']);

// delete api for delete_multiple_user
Route::delete('/delete_multiple_user/{ids}',[UserApiController::class , 'delete_multiple_user']);

// delete api for delete_multiple_user_with_json
Route::delete('/delete_multiple_user_with_json', [UserApiController::class, 'delete_multiple_user_with_json']);

// register_user_using_passport
Route::post('/register_user_using_passport', [UserApiController::class, 'register_user_using_passport']);
Route::post('/login_user_using_passport', [UserApiController::class, 'login_user_using_passport']);