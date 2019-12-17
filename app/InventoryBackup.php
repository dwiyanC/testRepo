<?php

namespace App;
use App\Comment2;

use Illuminate\Database\Eloquent\Model;

class InventoryBackup extends Model
{
    protected $table = 'inventories_backup';

    protected $fillable = [
        'unit_name' , 'unit_type', 'unit_no', 'active',
    ];

    // public function comments()
    // {
    //     return $this->hasMany('App\Comment2');
    // }
}
