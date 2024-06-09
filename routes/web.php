<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/', function () { return view('admin'); });

Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios.index')->middleware('auth','can:usuarios.index');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('usuarios.create')->middleware('auth','can:usuarios.create');
Route::post('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'store'])->name('usuarios.store')->middleware('auth','can:usuarios.store');
Route::get('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('usuarios.show')->middleware('auth','can:usuarios.show');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('usuarios.edit')->middleware('auth','can:usuarios.edit');
Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('usuarios.update')->middleware('auth','can:usuarios.update');
Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('usuarios.destroy')->middleware('auth','can:usuarios.destroy');


//Route::get('/registro', [App\Http\Controllers\UsuarioController::class, 'registro'])->name('admin.index');
//Route::post('/registro', [App\Http\Controllers\UsuarioController::class, 'registro_create'])->name('registro');



Route::get('/admin/mi_almacenamiento',[App\Http\Controllers\CarpetaController::class, 'index'])->name('mi_almacenamiento.index')->middleware('auth');
Route::post('/admin/mi_almacenamiento',[App\Http\Controllers\CarpetaController::class, 'store'])->name('mi_almacenamiento.store')->middleware('auth');
Route::get('/admin/mi_almacenamiento/carpeta/{id}',[App\Http\Controllers\CarpetaController::class, 'show'])->name('mi_almacenamiento.carpeta')->middleware('auth');
Route::put('/admin/mi_almacenamiento/{id}', [App\Http\Controllers\CarpetaController::class, 'update'])->name('mi_almacenamiento.update')->middleware('auth');

Route::put('/admin/mi_almacenamiento/carpeta',[App\Http\Controllers\CarpetaController::class, 'update_subcarpeta'])->name('mi_almacenamiento.carpeta.update_subcarpeta')->middleware('auth');
Route::put('/admin/mi_almacenamiento/carpeta/colors',[App\Http\Controllers\CarpetaController::class, 'update_subcarpeta_color'])->name('mi_almacenamiento.carpeta.update_subcarpeta_color')->middleware('auth');
Route::post('/admin/mi_almacenamiento/carpeta/crear_subcarpeta',[App\Http\Controllers\CarpetaController::class, 'crear_subcarpeta'])->name('mi_almacenamiento.carpeta.crear_subcarpeta')->middleware('auth');
Route::put('/admin/mi_almacenamiento', [App\Http\Controllers\CarpetaController::class, 'update_color'])->name('mi_almacenamiento.update_color')->middleware('auth');

//rutas para eliminar las CARPETAS
Route::delete('/admin/mi_almacenamiento/eliminar_carpeta/{id}', [App\Http\Controllers\CarpetaController::class, 'destroy'])->name('carpeta.destroy')->middleware('auth');


//rutas para los ARCHIVOS
Route::post('/admin/mi_almacenamiento/carpeta/upload',[App\Http\Controllers\ArchivoController::class, 'upload'])->name('mi_almacenamiento.archivo.upload')->middleware('auth');


//ruta para eliminar los ARCHIVOS
Route::delete('/admin/archivo/{id}', [App\Http\Controllers\ArchivoController::class, 'eliminar_archivo'])->name('mi_almacenamiento.archivo.eliminar_archivo')->middleware('auth');


//ruta para cambiar los estados de un archivo de forma PRIVATE a PUBLIC
Route::get('/admin/mi_almacenamiento/carpeta',[App\Http\Controllers\ArchivoController::class, 'cambiar_de_privado_a_publico'])->name('mi_almacenamiento.archivo.cambiar.privado.publico')->middleware('auth');


//ruta para cambiar los estados de un archivo de forma PUBLIC a PRIVATE
Route::post('/admin/mi_almacenamiento/carpeta',[App\Http\Controllers\ArchivoController::class, 'cambiar_de_publico_a_privado'])->name('mi_almacenamiento.archivo.cambiar.publico.privado')->middleware('auth');



 
//rutas para mostrar los ARCHIVOS - PRIVATE
Route::get('storage/{carpeta}/{archivo}', function ($carpeta,$archivo) {
   if(Auth::check()) {
    $path=storage_path('app'. DIRECTORY_SEPARATOR. $carpeta . DIRECTORY_SEPARATOR. $archivo); 
    return response()->file($path);

   }else{
      abort(403,'No tienes permiso para acceder a este ARCHIVO');
   }

 
})->name('mostrar.archivos.privados');