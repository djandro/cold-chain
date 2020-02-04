<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $fillable = ['name', 'description', 'storage_t', 'color'];

    public function records(){
        return $this->hasMany(Records::class);
    }

    public function recordsData(){
        return $this->hasMany(RecordsData::class);
    }

    public function getAlertMin(){
        return explode(";", $this->attributes['storage_t'])[0];
    }

    public function getAlertMax(){
        return explode(";", $this->attributes['storage_t'])[1];
    }
}
