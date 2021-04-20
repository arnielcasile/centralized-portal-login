<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Systems extends Model
{
    use HasFactory, SoftDeletes;

    public function system_access()
    {
        return $this->hasMany(SystemAccess::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contacts::class);
    }

    public function images()
    {
        return $this->hasMany(Images::class);
    }
}
