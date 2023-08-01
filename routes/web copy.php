<?php

use App\Http\Livewire\PDFMain;
use App\Http\Livewire\Buscador;
use App\Http\Livewire\UserMain;
use App\Http\Livewire\CursoMain;
use App\Http\Livewire\AlumnoMain;
use App\Http\Livewire\EmpresaMain;
use App\Http\Livewire\ProgramaMain;
use App\Http\Livewire\CalendarioMain;
use App\Http\Livewire\CotizacionMain;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\InscripicionMain;
use App\Http\Livewire\ListaCertificadosMain;
//use App\Http\Livewire\ConsultaCertificadoMain;

use App\Http\Controllers\certificadosController;

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
Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/alumnos', AlumnoMain::class)->name('alumnos');
    Route::get('/empresas', EmpresaMain::class)->name('empresas');
    Route::get('/cursos', CursoMain::class)->name('cursos');
    Route::get('/calendarios', CalendarioMain::class)->name('calendarios');
    Route::get('/inscripciones', InscripicionMain::class)->name('inscripciones');
    Route::get('/programas', ProgramaMain::class)->name('programas');
    Route::get('/cotizaciones', CotizacionMain::class)->name('cotizaciones');
    Route::get('/users', UserMain::class)->name('users');

    Route::get('/lista_certificados', ListaCertificadosMain::class)->name('lista_certificados');
    
    
    
});

Route::get('/consultaCertificado/{id}', [certificadosController::class, 'index']);

Route::get('/buscador', Buscador::class)->name('buscador')->middleware('auth');
Route::get('/pdf', PDFMain::class)->name('pdf');

Route::get('/dashboard', function(){
    return redirect('/lista_certificados');
});

Route::get('/', function () {
    return redirect('/lista_certificados');
});



/*Route::get('/register', function(){
    return redirect('/lista_certificados');
});*/


