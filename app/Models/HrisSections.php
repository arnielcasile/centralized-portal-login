<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisSections extends Model
{
    use HasFactory;

    protected $connection = 'hris';
    protected $table = 'pms_employee_section';
}
