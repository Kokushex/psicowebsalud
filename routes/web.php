<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\PsicologoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebPayRestController;
use Illuminate\Support\Facades\Auth;


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
	//carga la vista
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	//Este actualiza
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);

	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons');
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});


Route::get('/servicio', [ServicioController::class, 'indexServicio'])->name('servicio');

Route::get('/roles', [RolesController::class, 'indexRoles'])->name('roles');

Route::get('/agenda', [AgendaController::class, 'indexAgenda'])->name('agenda');

Route::get('/reserva', [ReservaController::class, 'indexReserva'])->name('reserva');

/////////////////////////////////////////////////////////REGISTRO/////////////////////////////////////////////////////////////////////////////////////

Route::get('/auth/rol_register', [RegisterController::class, 'viewRegistroRol'])->name('rol_register');

Route::get('/register', [RegisterController::class, 'viewRegistroPaciente'])->name('register_paciente');

Route::get('/register_psicologo', [RegisterController::class, 'viewRegistroPsicologo'])->name('register_psicologo');

Route::post('/auth/register', [RegisterController::class, 'createUser'])->name('createPaciente');

Route::post('/auth/register_psicologo', [RegisterController::class, 'createUser'])->name('createPsicologo');

///////////////////////////////////////////////////////////////////////////LOGIN//////////////////////////////////////////////////////////////////////

Route::get('/login_paciente', [LoginController::class, 'index_login'])->name('login_paciente');

Route::get('/login_psicologo', [LoginController::class, 'index_login'])->name('login_psicologo');

Route::post('/login/{tipo}', [LoginController::class, 'logear'])->name('logear');

//Restablecer Contraseña

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.update'); //request

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('auth/passwords/reset/{token}/{email}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset']);

////////////////////////////////////////////////////////////////////////PERFIL////////////////////////////////////////////////////////////////////////////////////////

Route::post('/profile', [ProfileController::class, 'update'])->name('perfilUpdate');
Route::post('/profile/registrarDatosPersonales', [ProfileController::class, 'registrarDatosPersonales'])->name('registrarDP');
Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('perfilActualizarPass');
Route::post('/profile/updatePaciente', [ProfileController::class, 'updatePaciente'])->name('perfilUpdatePaciente');
Route::post('/profile/updatePsicologo', [ProfileController::class, 'updatePsicologo'])->name('perfilUpdatePsicologo');


////////////////////////////////////////////////////////////////////SERVICIO//////////////////////////////////////////////////////////////////////////////////

Route::get('datatable/servicio', [ServicioController::class, 'datos'])->name('servicios.datatable_servicios');
Route::post('servicios/agregar', [ServicioController::class, 'guardarServicio'])->name('servicios.crear_servicio');
Route::post('/servicios/servicioDuplicado', [ServicioController::class, 'buscarServicioDuplicado'])->name('servicios.buscar_servicio_duplicado');
Route::put('/servicios/editar', [ServicioController::class, 'editarServicio'])->name('servicios.editar_servicio');
Route::post('servicios/detallesServicios',[ServicioController::class, 'detalleServicio'])->name('servicios.detalle_servicio');
Route::post('servicios/cambiarEstado', [ServicioController::class, 'cambiarEstadoServicio'])->name('servicios.cambiar_estado_servicio');
Route::get('/servicios/cargarDatosSelect2', [ServicioController::class, 'cargarDatosSelect2'])->name('servicios.mostrar_informacion_servicio');
Route::post('/servicios/rellenarModalAgregar', [ServicioController::class, 'rellenarModalAgregar'])->name('servicios.rellenar_modal_agregar');

//////////////////////////////Horario

Route::get('/horario', [HorarioController::class, 'indexHorario'])->name('horario');

//Route::get('horario/dashboardHorario', [HorarioController::class, 'index'])->name('dashboardHorario');
Route::get('datatable/horario', [HorarioController::class, 'datos'])->name('datatableHorario');
Route::post('horario/dashboardHorario', [HorarioController::class, 'create'])->name('crearHorario');
Route::post('horario/cambiarHorarioAjax', [HorarioController::class, 'cambiarEstadoHorario'])->name('cambiarEstadoHorario');
Route::put('horario/dashboardHorario', [HorarioController::class, 'edit'])->name('editarHorario');

////////////////////////////////////////////////////////////////////RESERVA//////////////////////////////////////////////////////////////////////////////////////


//Route::get('reserva/list', [PsicologoController::class, 'filtroPrincipal'])->name('psicologo.list');
Route::get('/reserva/list', [PsicologoController::class, 'index'])->name('reserva.list');
Route::get('/profile/{id}', [ProfileController::class, 'getProfile'])->name('busqueda');
//Route::get('/profile/{id}', 'ProfileController@getProfile')->name('profile');

Route::post('/busqueda/create', [ReservaController::class, 'store'])->name('reserva.create');

//////////////////////////////AJAX RESERVA////////////////////////////////////////////
Route::post('/obtenerDiasDisponibles', [ReservaController::class, 'obtenerDiasDisponibles']);
Route::get('buscarRut', [ReservaController::class, 'buscarRut']);
Route::get('getDetailsServicio', [ReservaController::class, 'getDetallesServicioModal']);
Route::get('/getPrecioModalidad', [ReservaController::class, 'getPrecioModalidad']);
Route::post('/obtenerHorasDisponibles', [ReservaController::class, 'obtenerHorasDisponibles']);
Route::get('/horarioPaciente', [ReservaController::class, 'horarioPaciente']);
Route::get('comprobacionDiaHabilitado', [ReservaController::class, 'comprobacionDiaHabilitado'] );
Route::get('comprobacionYaTomadas', [ReservaController::class, 'comprobacionReservasTomadas']);
//Route::get('/comprobacionYaTomadas', 'ReservaController@comprobacionReservasTomadas');

Route::get('/getCentro', [ReservaController::class, 'getCentroServicio']);

  //  Route::get('/getCentroServicio', 'ReservaController@getCentroServicio');

//////////////////////////////////////PAGO////////////////////////////////////////////////////
Route::get('/checkout', [WebPayRestController::class, 'createdTransaction'])->name('pasarela.checkout');
Route::get('/return', [WebPayRestController::class, 'commitedTransaction'])->name('return');
Route::get('ordencompra/{ordencompra}', [PagoController::class, 'mostrarDetalle'])->name('pago.ordenCompra');
//Route::get('ordencompra/{ordencompra}', 'PagoController@mostrarDetalle')->name('pasarela.ordenCompra');




