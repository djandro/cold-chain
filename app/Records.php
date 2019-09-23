<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    public $fillable = ['device_id', 'product_id', 'location_id', 'samples',
                        'delay_time', 'intervals', 'slr', 'limits', 'errors',
                        'alarms', 'comments', 'status', 'user_id', 'start_date', 'end_date', 'file_name'];

    public function recordsdata(){
        return $this->hasMany(RecordsData::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function device(){
        return $this->belongsTo(Device::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
