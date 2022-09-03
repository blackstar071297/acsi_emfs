<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInfo extends Model
{
    use HasFactory;
    protected $table = 'emp_info';

    protected $primaryKey = 'empid';
    public $timestamps = false;
    
    public function info1(){
        return $this->hasOne(EmployeeInfo1::class,'empid','empid');
    }
}
