<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'description',
        'total_price',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'user_id'
    ];

    public function product(){

       return $this->hasMany(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
