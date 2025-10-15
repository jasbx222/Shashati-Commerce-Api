<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $fillable = ['end_time'];
    protected $table='work_times';
}
