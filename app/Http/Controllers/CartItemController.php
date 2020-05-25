<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CartItem;
use App\Cart;

class CartItemController extends Controller
{
    public function all(){
        return CartItem::all();
    }

    public function addItem(Request $request){

        $CustomerId = $request->input('CustomerId');
        $case = Cart::where('Cart.CustomerId',$CustomerId)->select('CartId')->first();

        if(!$case){
            $newCartEntry = array(
                'CustomerId' => $CustomerId,
            );
            Cart::create($newCartEntry->all());
        }
            $workingCartId = Cart::where('Cart.CustomerId', $CustomerId)->select('CartId')->first();
            $newCartItemEntry = array(
                'CartId' => $workingCartId->CartId,
                'CartItemId' => $request->input('CartItemId'),
                'Quantity' => $request->input('Quantity')
            );
            CartItem::create($newCartItemEntry);
            $jsonArr = array(
                'status' => true,
                'data' => $newCartItemEntry
            );

            return json_encode($jsonArr);

    }

    // ADD ITEM TO CART VIA BODY

    public function store(Request $request){
        $cartitem = CartItem::create($request->all());
        
        $jsonArr = array(
            'status' => true,
            'data' => $cartitem
        );
        return json_encode($jsonArr);
    }

    // delete one particular item from one particular cart of one particular user

    public function delete(Request $request)
    {   
        $CustomerId = $request->input('CustomerId');
        $itemdelete = $request->input('CartItemId');
        $case1 = Cart::where('Cart.CustomerId', $CustomerId)->select('CartId')->first(); // get cartid from cust id
        $case2 = CartItem::where('CartItem.CartId', $case1->CartId)
            ->where('CartItem.CartItemId', $itemdelete)
            ->delete();
                
        $jsonArr = array(
            'status' => true,
            'data' => $case2

        );
        return json_encode($jsonArr);
    }

    // DELETE ALL

    public function deleteall(Request $request)
    {   
        $CustomerId = $request->input('CustomerId');
        $case1 = Cart::where('Cart.CustomerId', $CustomerId)->select('CartId')->first(); // get cartid from cust id
        $case2 = CartItem::where('CartItem.CartId', $case1->CartId)->delete();

        
        $jsonArr = array(
            'status' => true,
            'item deleted' =>$case2

        );
        return json_encode($jsonArr);
    }

    // CHANGE QUANTITY OF AN ITEM

    public function update(Request $request)
    {   
        $CustomerId = $request->input('CustomerId');
        $itemupdate = $request->input('CartItemId');
        $quantity = array(
            'Quantity' => $request->input('Quantity')
        );
        $case1 = Cart::where('Cart.CustomerId', $CustomerId)->select('CartId')->first(); // get cartid from cust id
        $case2 = CartItem::where('CartItem.CartId', $case1->CartId)
            ->where('CartItem.CartItemId', $itemupdate)
            ->update($quantity);

        $jsonArr = array(
            'status' => true,
            'data' => $case2
        );

        return json_encode($jsonArr);
    }

    public function getCartContent($CartItemId)
    {
        $cartitem = CartItem::where('CartItemId', $CartItemId)->first();
        if ($cartitem) {
            $content = CartItem::where('CartItem.CartItemId', $CartItemId)
                ->join('Cart', 'Cart.CartId', '=', 'CartItem.CartId')
                ->join('Item', 'Item.ItemId', '=', 'CartItem.CartItemId')
                ->select('CartItem.CartItemId AS ID-Barang', 'CartItem.Quantity AS JUMLAH','CartItem.CartId')->get();
            $jsonArr = array(
                'status' => true,
                'data' => $content
            );
            return json_encode($jsonArr);
        } else {
            $jsonArr = array(
                'status' => false,
                'data' => 'Cart item not found'
            );
            return json_encode($jsonArr);
        }

    }
    
}