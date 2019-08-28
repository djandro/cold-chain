<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    public $fillable = ['device_id', 'product_id', 'location_id', 'samples',
                        'delay_time', 'intervals', 'slr', 'limits', 'errors',
                        'alarms', 'comments', 'status', 'user_id', 'start_date', 'end_date', 'file_name'];

    public function record_data(){
        return $this->hasMany(RecordsData::class);
    }

    public function product(){
        return $this->hasOne(Product::class);
    }

    public function location(){
        return $this->hasMany(Location::class);
    }
}
