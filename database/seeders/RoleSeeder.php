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
        // Verificar si el rol ya existe antes de crearlo
        if (!Role::where('name', 'administrator')->exists()) {
            $adminRole = Role::create(['name' => 'administrator']);
        } else {
            $adminRole = Role::where('name', 'administrator')->first();
        }

        if (!Role::where('name', 'regular_user')->exists()) {
            $userRole = Role::create(['name' => 'regular_user']);
        } else {
            $userRole = Role::where('name', 'regular_user')->first();
        }

        // Lista de permisos
        $permissions = [
            'admin.index',
            'usuarios.index',
            'usuarios.create',
            'usuarios.store',
            'usuarios.show',
            'usuarios.edit',
            'usuarios.update',
            'usuarios.destroy',
            'mi_almacenamiento.index',
            'mi_almacenamiento.store',
            'mi_almacenamiento.carpeta',
            'mi_almacenamiento.carpeta.update_subcarpeta',
            'mi_almacenamiento.carpeta.update_subcarpeta_color',
            'mi_almacenamiento.carpeta.crear_subcarpeta',
            'mi_almacenamiento.update',
            'mi_almacenamiento.update_color',
            'carpeta.destroy',
            'mi_almacenamiento.archivo.upload',
            'mi_almacenamiento.archivo.eliminar_archivo',
            'mi_almacenamiento.archivo.cambiar.privado.publico',
            'mi_almacenamiento.archivo.cambiar.publico.privado',
            'mostrar.archivos.privados'
        ];

        // Crear permisos y asignarlos a roles
        foreach ($permissions as $permissionName) {
            if (!Permission::where('name', $permissionName)->exists()) {
                $permission = Permission::create(['name' => $permissionName]);
                if (in_array($permissionName, ['admin.index', 'mi_almacenamiento.index', 'mi_almacenamiento.store', 'mi_almacenamiento.carpeta', 'mi_almacenamiento.carpeta.update_subcarpeta', 'mi_almacenamiento.carpeta.update_subcarpeta_color', 'mi_almacenamiento.carpeta.crear_subcarpeta', 'mi_almacenamiento.update', 'mi_almacenamiento.update_color', 'carpeta.destroy', 'mi_almacenamiento.archivo.upload', 'mi_almacenamiento.archivo.eliminar_archivo', 'mi_almacenamiento.archivo.cambiar.privado.publico', 'mi_almacenamiento.archivo.cambiar.publico.privado', 'mostrar.archivos.privados'])) {
                    $permission->syncRoles([$adminRole, $userRole]);
                } else {
                    $permission->syncRoles([$adminRole]);
                }
            }
        }
    }
}