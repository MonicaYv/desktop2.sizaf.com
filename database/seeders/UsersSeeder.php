<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$12$V/TDExAf67MRH5dwiFi5aOSPO6Z6i.3uTj/bwuYfVkLQ.Yt.v4PIi', //12345678
            'remember_token' => NULL,
            'created_at' => now(),
            'updated_at' => now(),
            'roleID' => 1,
            'phone' => NULL,
            'nickName' => NULL,
            'avatar' => NULL,
            'status' => 1,
            'lastLogin' => NULL,
            'sex' => NULL,
            'ip_address' => NULL,
            'sizeMax' => 250,
            'sizeUse' => 250,
            'groupID' => 3,
            'is_facedata' => 0,
            'is_support_face' => 0,
            'last_seen' => 0
        ]);
    }
}
