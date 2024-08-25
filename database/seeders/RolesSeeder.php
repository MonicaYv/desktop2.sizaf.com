<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'id' => 1,
            'name' => 'superadmin',
            'description' => 'super user role has all enable',
            'upload_limit' => 420,
            'file_manage_settings' => 'preview,search,download,new-file,upload,share,edit,delete,move,compress,decompress',
            'user_settings' => 'config_modify,operation',
            'permissionID' => NULL,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Roles::create([
            'id' => 2,
            'name' => 'Team leader',
            'description' => 'Team Manager',
            'upload_limit' => 10,
            'file_manage_settings' => 'file-manage,preview,download',
            'user_settings' => 'move',
            'permissionID' => NULL,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
