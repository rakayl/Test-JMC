<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GiveRolePermissionSeeder extends Seeder
{
    
    public function run(): void
    {
      
        $role = Role::findByName('admin');
        $role->givePermissionTo('barang_masuk_index');
        $role->givePermissionTo('barang_masuk_create');
        $role->givePermissionTo('barang_masuk_update');
        $role->givePermissionTo('barang_masuk_show');
        $role->givePermissionTo('barang_masuk_delete');
        
        $role->givePermissionTo('kategori_index');
        $role->givePermissionTo('kategori_create');
        $role->givePermissionTo('kategori_update');
        $role->givePermissionTo('kategori_show');
        $role->givePermissionTo('kategori_delete');
        
        $role->givePermissionTo('sub_kategori_index');
        $role->givePermissionTo('sub_kategori_create');
        $role->givePermissionTo('sub_kategori_update');
        $role->givePermissionTo('sub_kategori_show');
        $role->givePermissionTo('sub_kategori_delete');
        
        $role->givePermissionTo('user_index');
        $role->givePermissionTo('user_create');
        $role->givePermissionTo('user_update');
        $role->givePermissionTo('user_show');
        $role->givePermissionTo('user_delete');
        
        //operator
        $role = Role::findByName('operator');
        $role->givePermissionTo('barang_masuk_index');
        $role->givePermissionTo('barang_masuk_create');
        $role->givePermissionTo('barang_masuk_update');
        $role->givePermissionTo('barang_masuk_show');
        $role->givePermissionTo('barang_masuk_delete');
        
    }
}
