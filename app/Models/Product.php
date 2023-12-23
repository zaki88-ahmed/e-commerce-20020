<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ["name", "description", "in_stock", "has_offer", "price", "price_before", "start_date", "end_date", "category_id", "brand_id"];
    protected $hidden = [ 'id', 'created_at', 'updated_at', 'deleted_at'];


    public function medias(){
        return $this->morphToMany(Media::class, 'mediable');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

}
