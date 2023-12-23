<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Brand extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ["name"];
    protected $hidden = [ 'id', 'created_at', 'updated_at', 'deleted_at'];


    public function medias(){
        return $this->morphToMany(Media::class, 'mediable');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

}
