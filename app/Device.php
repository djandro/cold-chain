<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $fillable = ['name'];

    public function records(){
        return $this->hasMany(Records::class);
    }

    public function getCountRecords(){
        //todo getCountRecords
        return 0;
    }
}
