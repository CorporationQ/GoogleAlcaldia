<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'carpeta_padre_id', 'usuario_id', 'google_drive_folder_id'];

    public function carpetasHijas(){
        return $this->hasMany(Carpeta::class,'carpeta_padre_id');
    }

    public function archivos(){
        return $this->hasMany(Archivo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
