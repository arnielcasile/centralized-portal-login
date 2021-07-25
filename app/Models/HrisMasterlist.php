<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HrisMasterlist extends Model
{
    // use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'hrms_emp_masterlist';
    protected $primaryKey = 'emp_pms_id';
}
