<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class subcategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    function relation_to_category(){
        return $this->belongsTo(category::class, 'category_id');
    }
    protected $guarded=['id'];
}
