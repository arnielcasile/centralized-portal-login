<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;

    public function system()
    {
        return $this->belongsTo(Systems::class); 
    }

    public function role()
    {
        return $this->hasMany(RoleAccess::class); 
    }
}
