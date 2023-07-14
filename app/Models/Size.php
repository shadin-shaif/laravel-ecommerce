<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    function rel_to_cat(){
        return $this->belongsTo(category::class, 'category_id');
    }
}
