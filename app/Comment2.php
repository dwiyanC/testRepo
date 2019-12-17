<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment2 extends Model
{
    protected $table = 'item_comments';

    protected $fillable = [
        'comment', 'inventory2_id',
    ];

    public function inventory()
    {
        return $this->belongsTo('App\Inventory2', 'inventory2_id');
    }

    protected $guarded = [];
}
