<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carpeta;
use App\Models\Archivo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $usuarios = User::all();
        $carpetas = Carpeta::all();
        $archivos = Archivo::all();
        return view('admin.index', compact('usuarios','carpetas','archivos'));
    }
}
