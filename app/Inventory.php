<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'unit_name' , 'unit_type', 'unit_no',
    ];
    public $timestamps = false;
}
