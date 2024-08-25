<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'upload_limit',
        'file_manage_settings',
        'user_settings',
        'permissionID',
    ];
    
    public function user()
    {
        return $this->hasMany(Roles::class);
    }
}
