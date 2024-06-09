<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. relacion uno a muchos para usuario_id un usuario puede tener varias carpetas y una carpeta solo puede pertenecer a un usuario Hasmany - Belong
     */
    public function up(): void
    {
        Schema::create('carpetas', function (Blueprint $table) {
            $table->id();            
            $table->string('nombre');            
            $table->string('color',50)->nullable();            
            $table->unsignedBigInteger('carpeta_padre_id')->nullable() ;           
            $table->unsignedBigInteger('usuario_id');           
            $table->timestamps();

            
            $table->foreign('carpeta_padre_id')
            ->references('id')
            ->on ('carpetas')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('usuario_id')
            ->references('id')
            ->on ('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpetas');
    }
};
