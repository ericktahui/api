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

Route::post('loginsp','Usuario\UsuarioController@loginsp');
Route::post('login','Usuario\UsuarioController@login');
Route::post('registerusuario','Usuario\UsuarioController@registerUsuario');
Route::get('usuariosxnombre/{nombre}','Usuario\UsuarioController@getUsuariosLikeNombre');
Route::get('usuarioxid/{id}','Usuario\UsuarioController@getUsuarioXId');
Route::get('usuarioxcorreo/{email}','Usuario\UsuarioController@getUsuarioXCorreo');
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

