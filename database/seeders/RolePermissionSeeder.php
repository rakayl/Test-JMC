<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'operator']);
        Permission::create(['name' => 'login']);
        //barang masuk
        Permission::create(['name' => 'barang_masuk_index']);
        Permission::create(['name' => 'barang_masuk_create']);
        Permission::create(['name' => 'barang_masuk_update']);
        Permission::create(['name' => 'barang_masuk_show']);
        Permission::create(['name' => 'barang_masuk_delete']);
        
        //kategori
        Permission::create(['name' => 'kategori_index']);
        Permission::create(['name' => 'kategori_create']);
        Permission::create(['name' => 'kategori_update']);
        Permission::create(['name' => 'kategori_show']);
        Permission::create(['name' => 'kategori_delete']);
        
        //sub kategori
        Permission::create(['name' => 'sub_kategori_index']);
        Permission::create(['name' => 'sub_kategori_create']);
        Permission::create(['name' => 'sub_kategori_update']);
        Permission::create(['name' => 'sub_kategori_show']);
        Permission::create(['name' => 'sub_kategori_delete']);
        
        //user
        Permission::create(['name' => 'user_index']);
        Permission::create(['name' => 'user_create']);
        Permission::create(['name' => 'user_update']);
        Permission::create(['name' => 'user_show']);
        Permission::create(['name' => 'user_delete']);
        
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $operator = User::factory()->create();
        $operator->assignRole('operator');
    }
}
