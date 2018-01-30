<?php

Use App\Mail\Welcome;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web Routes for your application. These
| Routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return  redirect('proyectos');
});



Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordC	ontroller@reset');



Route::group(['middleware' => 'auth'], function () {
	Route::resource('proyectos','ProyectoController');
	Route::get('proyectosver/{id}', 'ProyectoController@ver')->name('proyectos.ver');
	Route::resource('usuarios','UsuariosController');
	Route::get('usuariosver/{id}', 'ProyectoController@ver')->name('usuarios.ver');
	Route::get('usuarioseliminar/{userid}', 'UsuariosController@EliminarUsuario')->name('usuarios.eliminar');
	Route::get('usuarioseliminar/{userid}/{projectid}', 'ProyectoController@EliminarUsuarioProject')->name('usuarios.eliminar2');
	Route::get('usuariosactivar/{userid}/{projectid}', 'ProyectoController@ActivarUsuarioProject')->name('usuarios.activar');
	Route::get('usuarioseditar/{id}', 'ProyectoController@editar')->name('usuarios.editar');
	Route::post('usuarioproyecto/{id}', 'ProyectoController@agregarUsuario')->name('usuarios.agregar');
	Route::post('docproy/{proy}/{id}', 'ProyectoController@SubirDocumentoProy')->name('documento.agregarproy');
	Route::post('docplantas/{proy}/{id}', 'ProyectoController@SubirDocumentoPlantas')->name('documento.agregarplantas');
	Route::post('docpisos/{proy}/{id}', 'ProyectoController@SubirDocumentoPisos')->name('documento.agregarpisos');
	Route::post('docsalas/{proy}/{id}', 'ProyectoController@SubirDocumentoSalas')->name('documento.agregarsalas');
	Route::post('crearplanta/{proy}', 'ProyectoController@CrearPlanta')->name('proyecto.crearplanta');
	Route::post('crearplanta/{proy}/{id}', 'ProyectoController@CrearPiso')->name('proyecto.crearpiso');
	Route::post('crearsala/{proy}/{id}', 'ProyectoController@CrearSala')->name('proyecto.crearsala');
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
	Route::post('editarplanta/{proy}/{id}', 'ProyectoController@EditarPlanta')->name('editarplanta');
	Route::post('editarpiso/{proy}/{id}', 'ProyectoController@EditarPiso')->name('editarpiso');
	Route::post('editarsala/{proy}/{id}', 'ProyectoController@EditarSala')->name('editarsala');

	Route::get('eliminarplanta/{idproyecto}/{idplanta}', 'ProyectoController@EliminarPlanta')->name('eliminarplanta');
	Route::get('eliminarpiso/{idproyecto}/{idpiso}', 'ProyectoController@EliminarPiso')->name('eliminarpiso');
	Route::get('eliminarsala/{idproyecto}/{idsala}', 'ProyectoController@EliminarSala')->name('eliminarsala');

	Route::get('copiarplanta/{idproyecto}/{idplanta}', 'ProyectoController@CopiarPlanta')->name('copiarplanta');
	Route::get('copiarpiso/{idproyecto}/{idpiso}', 'ProyectoController@CopiarPiso')->name('copiarPiso');
	Route::get('copiarsala/{idproyecto}/{idsala}', 'ProyectoController@CopiarSala')->name('copiarSala');
	Route::post('subirdoc', 'ProyectoController@subirdoc')->name('subirdoc');

//    Route::get('/link1', function ()    {
//// Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:Route and adminlte:link commands to works correctly.
    #adminlte_Routes
});

Route::post('password/emailpost', 'UsuariosController@postEmail')->name('usuario.postemail');	
Route::get('password/email', 'UsuariosController@getEmail')->name('usuario.getemail');
