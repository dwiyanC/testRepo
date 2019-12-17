<?php

namespace App;
use App\Comment2;
use App\ItemImage;

use Illuminate\Database\Eloquent\Model;

class Inventory2 extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'unit_name' , 'unit_type', 'unit_no',
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment2');
    }

    public function images(){
        return $this->hasMany('App\ItemImage')->where('main_image',false);
    }

    public function mainImage(){
        return $this->hasOne('App\ItemImage')->where('main_image', true);
    }
}
