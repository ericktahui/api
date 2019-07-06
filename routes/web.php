<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Para añadir Rutas adicionales a un recurso RESTful debemos agregarlas "ANTES"  de las rutas del propio recurso */
//Route::get('usuario/popular/{$id}','Usuario\UsuarioController@showUsuarioPopular');



Route::get('/', function () {
    return view('welcome');
});
