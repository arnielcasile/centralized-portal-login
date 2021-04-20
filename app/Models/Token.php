<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccessToken;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id'];

    public function accessToken()
    {
        return $this->belongsTo(AccessToken::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
    }
}
