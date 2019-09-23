<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['name', 'description', 'slt', 'storage_t'];

    public function records(){
        return $this->hasMany(Records::class);
    }
}
