<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $primaryKey = 'tsiempno';
    protected $table = 'tsitoacsi';

    protected $fillable = [
        'tsiempno',
        'acsiempno',
        'isenable'
    ];
}
