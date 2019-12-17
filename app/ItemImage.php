<?php

namespace App;
use App\Inventory2;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    protected $table = 'item_images';

    protected $fillable = [
        'image_name', 'inventory2_id', 'main_image',
    ];

    public function inventory()
    {
        return $this->belongsTo('App\Inventory2', 'inventory2_id');
    }
}
