<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacts extends Model
{
    use HasFactory;

    public function system()
    {
        return $this->belongsTo(Systems::class); 
    }

    public function user_empid()
    {
        return $this->belongsTo(User::class); 
    }
}
