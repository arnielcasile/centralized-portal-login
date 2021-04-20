<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;

    protected $fillable = ['system_access_id','role_id'];

    public function role_access()
    {
        return $this->belongsTo(Role::class); 
    }
}
