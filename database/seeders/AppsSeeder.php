<?php

namespace Database\Seeders;

use App\Models\App;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppsSeeder extends Seeder
{
    public function run(): void
    {
        App::create([
            'id' => 2,
            'name' => 'Recycle Bin',
            'icon' => 'bin.svg',
            'app_function' => NULL,
            'link' => 'filemanager',
            'type' => 'folder',
            'desktop_display' => 1,
            'filemanager_display' => 1,
            'path' => 'RecycleBin',
            'parentpath' => '/',
            'sort_order' => 2,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 3,
            'name' => 'Gallery',
            'icon' => 'album.svg',
            'app_function' => NULL,
            'link' => 'filemanager',
            'type' => 'folder',
            'desktop_display' => 1,
            'filemanager_display' => 1,
            'path' => 'Gallery',
            'parentpath' => NULL,
            'sort_order' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 4,
            'name' => 'LightApp',
            'icon' => 'lightapp.svg',
            'app_function' => 'add_app',
            'link' => 'lightapp',
            'type' => 'route',
            'desktop_display' => 1,
            'filemanager_display' => 0,
            'path' => NULL,
            'parentpath' => NULL,
            'sort_order' => 3,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 6,
            'name' => 'Setting',
            'icon' => 'setting.svg',
            'app_function' => NULL,
            'link' => 'useradmin',
            'type' => 'route',
            'desktop_display' => 1,
            'filemanager_display' => 0,
            'path' => NULL,
            'parentpath' => NULL,
            'sort_order' => 4,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 7,
            'name' => 'Filmanager',
            'icon' => 'filemanager.svg',
            'app_function' => NULL,
            'link' => 'filemanager',
            'type' => 'route',
            'desktop_display' => 0,
            'filemanager_display' => 0,
            'path' => NULL,
            'parentpath' => NULL,
            'sort_order' => 4,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 8,
            'name' => 'Desktop',
            'icon' => 'desktop.svg',
            'app_function' => NULL,
            'link' => 'filemanager',
            'type' => 'folder',
            'desktop_display' => 0,
            'filemanager_display' => 1,
            'path' => 'Desktop',
            'parentpath' => '/',
            'sort_order' => 2,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 9,
            'name' => 'Document',
            'icon' => 'document.svg',
            'app_function' => NULL,
            'link' => 'filemanager',
            'type' => 'folder',
            'desktop_display' => 0,
            'filemanager_display' => 1,
            'path' => 'Document',
            'parentpath' => '/',
            'sort_order' => 2,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 10,
            'name' => 'Download',
            'icon' => 'download.svg',
            'app_function' => NULL,
            'link' => 'filemanager',
            'type' => 'folder',
            'desktop_display' => 0,
            'filemanager_display' => 1,
            'path' => 'Download',
            'parentpath' => '/',
            'sort_order' => 2,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        App::create([
            'id' => 11,
            'name' => 'DotsViewer',
            'icon' => 'defaultapp.svg',
            'app_function' => NULL,
            'link' => 'dotsviewer',
            'type' => 'route',
            'desktop_display' => 0,
            'filemanager_display' => 0,
            'path' => '',
            'parentpath' => '',
            'sort_order' => 2,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
