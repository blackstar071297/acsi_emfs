<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInfo1 extends Model
{
    use HasFactory;
    protected $table = 'emp_comp';

    protected $primaryKey = 'empid';
}
