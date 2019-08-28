<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['name', 'description', 'slt', 'storage_t'];

    public function record_data(){
        return $this->hasOne(Records::class);
    }
}
