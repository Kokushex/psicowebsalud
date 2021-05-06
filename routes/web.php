<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;


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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes(); */

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

//Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	
});


Route::group(['prefix' => 'hr', 'middleware' => 'auth'], function () {

	Route::resource('horario', HorarioController::class)->names([
		'index' => 'indexHorario',
		'create' => 'createHorario',
		'store' => 'storeHorario',
		'edit' => 'editHorario',
		'update' => 'updateHorario',
		'destroy' => 'destroyHorario'

		]);
	//Route::get('horario/', [HorarioController::class, 'indexHorario'])->name('horario.index');

});


Route::get('/servicio', [ServicioController::class, 'indexServicio'])->name('servicio');

Route::get('/roles', [RolesController::class, 'indexRoles'])->name('roles');

Route::get('/agenda', [AgendaController::class, 'indexAgenda'])->name('agenda');

Route::get('/reserva', [ReservaController::class, 'indexReserva'])->name('reserva');

//////////////Registro

Route::get('/auth/rol_register', [RegisterController::class, 'viewRegistroRol'])->name('rol_register');

Route::get('/register', [RegisterController::class, 'viewRegistroPaciente'])->name('register_paciente');

Route::get('/register_psicologo', [RegisterController::class, 'viewRegistroPsicologo'])->name('register_psicologo');

Route::post('/auth/register', [RegisterController::class, 'createUser'])->name('createPaciente');

Route::post('/auth/register_psicologo', [RegisterController::class, 'createUser'])->name('createPsicologo');


