<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryData extends Model
{
    protected $table = 'temporary_data';
    public $timestamps = false;
    public $fillable = ['data'];
}
