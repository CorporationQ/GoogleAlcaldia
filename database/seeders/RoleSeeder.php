<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //El sistema contemplara 2 tipos de Usuarios
        //El ADMINISTRADOR
        //El USUARIO NORMAL
        $admin = Role::create(['name' => 'admin']);
        $usuario = Role::create(['name' => 'usuario']);

        Permission::create(['name' => 'admin.index'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'usuarios.index'])->syncRoles([$admin]) ;
        Permission::create(['name' => 'usuarios.create'])->syncRoles([$admin]) ;
        Permission::create(['name' => 'usuarios.store'])->syncRoles([$admin]) ;
        Permission::create(['name' => 'usuarios.show'])->syncRoles([$admin]) ;
        Permission::create(['name' => 'usuarios.edit'])->syncRoles([$admin]) ;
        Permission::create(['name' => 'usuarios.update'])->syncRoles([$admin]) ;
        Permission::create(['name' => 'usuarios.destroy'])->syncRoles([$admin]) ;


        Permission::create(['name' => 'mi_almacenamiento.index'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.store'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.carpeta'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.carpeta.update_subcarpeta'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.carpeta.update_subcarpeta_color'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.carpeta.crear_subcarpeta'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.update'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.update_color'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'carpeta.destroy'])->syncRoles([$admin,$usuario]) ;



        Permission::create(['name' => 'mi_almacenamiento.archivo.upload'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.archivo.eliminar_archivo'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.archivo.cambiar.privado.publico'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mi_almacenamiento.archivo.cambiar.publico.privado'])->syncRoles([$admin,$usuario]) ;
        Permission::create(['name' => 'mostrar.archivos.privados'])->syncRoles([$admin,$usuario]) ;




    }
}
