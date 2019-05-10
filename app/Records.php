<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    public $fillable = ['device_id', 'product_id', 'location_id', 'samples', 'delay_time', 'intervals', 'slr', 'limits', 'errors', 'alarms', 'comments', 'status'];

    public function record_data(){
        return $this->hasMany(RecordsData::class);
    }
}
