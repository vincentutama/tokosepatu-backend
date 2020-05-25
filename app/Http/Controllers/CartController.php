<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;

class CartController extends Controller
{
    public function all(){
        return Cart::all();
    }

    public function store(Request $request)
     {
         return Cart::create($request->all());
     }

     
    // delete data

    public function delete($CartId, Request $request)
    {
        $cart = Cart::where('Cart.CartId',$CartId)->delete($request->all());
        return 204;
    }

    public function getCartOwner($CustomerId)
    {
        $cart = Cart::where('CustomerId', $CustomerId)->first();
        if ($cart) {
            $content = Cart::where('Cart.CustomerId', $CustomerId)
                ->select('Cart.CustomerId','CartId')->get();
            $jsonArr = array(
                'status' => true,
                'data' => $content
            );
            return json_encode($jsonArr);
        } else {
            $jsonArr = array(
                'status' => false,
                'data' => 'Cart not found'
            );
            return json_encode($jsonArr);
        }

        // return User::where('User.CustomerId', $CustomerId)
        //     ->join('Transaction', 'Transaction.CustomerId', '=', 'User.CustomerId')
        //     ->select('*')->get();
        // return User::where('CustomerId', $CustomerId)->first();
    }
    
    // FUNGSI UNTUK MENDAPATKAN ISI CART DARI CUSTOMER ID

    public function obtainCart($CustomerId)
    {
        $content = Cart::where('CustomerId', $CustomerId)
            ->join('CartItem', 'CartItem.CartId', '=', 'Cart.CartId')
            ->join('Item', 'Item.ItemId', '=', 'CartItem.CartItemId')
            ->select('Cart.CartId','CartItem.CartItemId','CartItem.Quantity','Item.ItemName','Item.ItemPrice','Item.ItemImage')->get();
        
        $jsonArr = array(
            'status' => true,
            'data' => $content
        );
        return json_encode($jsonArr);
    }

}
