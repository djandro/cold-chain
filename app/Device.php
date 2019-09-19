<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $fillable = ['name'];

    public function record_data(){
        return $this->hasOne(Records::class);
    }

    public function getCountRecords(){
        //todo getGountRecords
        return 0;
    }
}
