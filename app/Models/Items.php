<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
      //The table associated with the model

    protected $table = 'items';

    //The primary key associated with the table
    protected $primaryKey = 'item_id';



    //The attributes that are mass assignable
    protected $fillable = [
        'item_name',
        'image_path',
        'price',
        'description',
        'user_id',
    ] ;
}
