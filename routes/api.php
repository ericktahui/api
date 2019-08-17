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






/* Para añadir Rutas adicionales a un recurso RESTful debemos agregarlas "ANTES"  de las rutas del propio recurso */



Route::post('downuser','Usuario\UsuarioController@downuser');
Route::post('updatepassword','Usuario\UsuarioController@updatepassword');
Route::post('deleteuser','Usuario\UsuarioController@deleteuser');
Route::post('registeruser','Usuario\UsuarioController@registeruser');


Route::post('loginsp','Usuario\UsuarioController@loginsp');
Route::post('login','Usuario\UsuarioController@login');

Route::post('userslikename','Usuario\UsuarioController@userslikename');

Route::get('userxid/{id}/{token}','Usuario\UsuarioController@userxid');
Route::get('userxemail/{email}/{token}','Usuario\UsuarioController@userxemail');

//Pruebas iniciales laravel
Route::get('popular/{id}','Usuario\UsuarioController@getUsuarioPopular');
Route::resource('usuario','Usuario\UsuarioController');


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


//Route::resource('usuario','Usuario\UsuarioController',['only'=>['index','show']] );
//['except'	=>	['create',	'store',	'update',	'destroy']]);
//['only'=>['index','show']] );

