<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordsData extends Model
{
    protected $table = 'records_data';
    public $fillable = ['timestamp', 'temperature', 'humidity', 'dew_points', 'battery_voltage', 'is_calculated'];

    public function record(){
        return $this->hasOne(Records::class);
    }
}
