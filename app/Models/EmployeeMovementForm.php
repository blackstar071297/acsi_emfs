<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMovementForm extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_no';

    protected $casts = [
        'request_no' => 'string',
        'move_position' => 'boolean',
        'move_job_status' => 'boolean',
        'move_job_level' => 'boolean',
        'move_role' => 'boolean',
        'move_department' => 'boolean',
        'move_cost_center' => 'boolean',
        'move_salary' => 'boolean',
        'move_allowance' => 'boolean',
        'move_immediate_superior' => 'boolean',
        'move_manager' => 'boolean',
        'move_contract' => 'boolean',
        'move_others' => 'boolean',
        'created_at' => 'date:Y-m-d',
        'superior_accept_date' => 'date:m-d-Y',
        'new_superior_accept_date' => 'date:m-d-Y',
        'manager_accept_date' => 'date:m-d-Y',
        'new_manager_accept_date' => 'date:m-d-Y',
        'cable_head_accept_date' => 'date:m-d-Y',
        'employee_accept_date' => 'date:m-d-Y',
        'hr_accept_date' => 'date:m-d-Y',
    ];
    public function getRouteKeyName(){
        return 'request_no';
    }
    public function employee(){
        return $this->hasOne(EmployeeInfo::class,'empno','emp_no');
    }
    public function requestor(){
        return $this->hasOne(EmployeeInfo::class,'empno','request_by');
    }
    public function current_superior(){
        return $this->hasOne(EmployeeInfo::class,'empno','from_immediate_superior');
    }
    public function current_manager(){
        return $this->hasOne(EmployeeInfo::class,'empno','from_manager');
    }
    public function new_superior(){
        return $this->hasOne(EmployeeInfo::class,'empno','to_immediate_superior');
    }
    public function new_manager(){
        return $this->hasOne(EmployeeInfo::class,'empno','to_manager');
    }
    public function account_officer(){
        return $this->hasOne(EmployeeInfo::class,'empno','hr_account_officer');
    }
    public function canceled_by(){
        return $this->hasOne(EmployeeInfo::class,'empno','canceled_by');
    }
    public function records(){
        return $this->hasMany(MovementRecord::class,'request_no','request_no')->latest();
    }
    
    
}
