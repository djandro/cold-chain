<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $fillable = ['name', 'description', 'storage_t'];

    public function record_data(){
        return $this->hasMany(Records::class);
    }
}
