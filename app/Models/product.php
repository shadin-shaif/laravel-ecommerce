<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_category(){
        return $this->belongsTo(category::class,'category_id');
    }
    function rel_to_inventory(){
        return $this->hasMany(inventory::class,'product_id');
    }

}
