<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordsData extends Model
{
    protected $table = 'records_data';
    public $timestamps = false;
    public $fillable = ['timestamp', 'date', 'time', 'records_id', 'temperature', 'humidity', 'dew_points', 'battery_voltage', 'is_calculated', 'location_id'];

    protected $attributes = [
      'is_calculated' => 0
    ];

    public function record(){
        return $this->hasOne(Records::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
