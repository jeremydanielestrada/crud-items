<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function item(){
        return $this->belongsTo(Items::class, 'item_id','item_id');
    }


    public function user() {
    return $this->belongsTo(User::class, 'user_id');
}

 protected $fillable = [
    'item_id',
    'user_id',
    'quantity',
    ] ;
}
