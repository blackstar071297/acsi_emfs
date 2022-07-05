<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';

    protected $primaryKey = 'userid';

    protected $fillable = [
        'useruniq',
        'username',
        'userpass',
        'useraccess',
        'deptid',
        'hq',
        'position',
        'emailadd',
        'temppass',
        'verifycode',
        'whdb',
        'whaccess',
        'firstname',
        'lastname',
        'empno',
    ];

}
