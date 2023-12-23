<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Order extends Model
{
    use HasFactory;
    function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    protected $fillable = [
        'order_date',
        'amount',
        'taxes',
        'discount',
        'status',
        'user_id',


    ];

    const STATUS = [
        0 => 'Pending',
        1 => 'Approved',
        2 => 'Canceled',
        3 => 'Rejected',
        4 => 'Shipped',
    ];


    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id')->withPivot('Qty');
    }


//    public function payments(): MorphMany
//    {
//        return $this->morphMany(Payment::class, 'paymentable');
//    }

    public function medias(){
        return $this->morphToMany(Media::class, 'mediable');
    }


    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }


}
