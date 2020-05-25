<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Item;

class ItemController extends Controller
{
    public function all(){
        return Item::all();
    }

    public function getItemDetails($ItemId)
    {
        $item = Item::where('ItemId', $ItemId)->first();
        if ($item) {
            $details = Item::where('Item.ItemId', $ItemId)
                ->select('Item.ItemImage','Item.ItemName AS Name', 'Item.ItemPrice AS Price', 'Item.ItemDescription AS Description')->get();
            $jsonArr = array(
                'status' => true,
                'data' => $details
            );
            return json_encode($jsonArr);
        } else {
            $jsonArr = array(
                'status' => false,
                'data' => 'Item not found'
            );
            return json_encode($jsonArr);
        }
    
    // tambah data

    }public function store(Request $request)
    {
        return Item::create($request->all());
    }

     // ganti data
     public function update($ItemId, Request $request)
     {
          $item = Item::where('Item.ItemId',$ItemId)->update($request->all());
          return $item;
     }
 
     // delete data
 
     public function delete($ItemId, Request $request)
     {
         $item = Item::where('Item.ItemId',$ItemId)->delete($request->all());
         return 204;
     }
}
