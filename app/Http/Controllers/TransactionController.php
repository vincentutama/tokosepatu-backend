<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Transaction;

class TransactionController extends Controller
{
    public function all(){
        return Transaction::all();
    }

    public function getTransactionDetails($TransactionId)
    {
        $transaction = Transaction::where('TransactionId', $TransactionId)->first();
        if ($transaction) {
            $content = Transaction::where('Transaction.TransactionId', $TransactionId)
                ->join('User', 'User.CustomerId', '=', 'Transaction.CustomerId')
                ->join('Cart', 'Cart.CartID', '=', 'Transaction.CartId')
                ->select('Transaction.TransactionID', 'Transaction.CustomerId', 'Transaction.TotalPayment', 'Transaction.PaymentOption', 'Transaction.PaymentDetails')->get();
            $jsonArr = array(
                'status' => true,
                'data' => $content
            );
            return json_encode($jsonArr);
        } else {
            $jsonArr = array(
                'status' => false,
                'data' => 'Transaction not found'
            );
            return json_encode($jsonArr);
        }

    }

    // tambah data

    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());
        $jsonArr = array(
            'status' => true,
            'data' => $transaction
        );
        return json_encode($jsonArr);
    }

    // delete data
 
    public function delete($TransactionId, Request $request)
    {
        $transaction = Transaction::where('Transaction.TransactionId',$TransactionId)->delete($request->all());
        return 204;
    }

    // ganti data
    
    public function update($TransactionId, Request $request)
    {
         $transaction = Transaction::where('Transaction.TransactionId',$TransactionId)->update($request->all());
         return $transaction;
    }

}
