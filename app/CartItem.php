<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cartitem';
    protected $fillable = ['CartId', 'CartItemId', 'Quantity'];
}
