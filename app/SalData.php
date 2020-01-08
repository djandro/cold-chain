<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalData extends Model
{
    protected $table = 'sal_data';
    public $timestamps = false;
    public $fillable = ['temperature', 'sl'];
}
