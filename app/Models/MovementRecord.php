<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementRecord extends Model
{
    use HasFactory;
    public $primaryKey = 'movement_record_id';
    public function status(){
        return $this->hasOne(Status::class,'status_id','status_id');
    }
}
