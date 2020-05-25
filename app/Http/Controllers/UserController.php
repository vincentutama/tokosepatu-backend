<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cookie;

use App\User;

class UserController extends Controller
{
    public function all(){
        return User::all();
    }

    // mengambil data dari atau customer id
    
    public function showData($CustomerId)
    {
        return User::where('CustomerId',$CustomerId)->first();
    }

    // verifikasi login

    public function verify(Request $request){
        $name = $request->input('Username');
        $case = User::where('User.Username',$name)->select('Password','CustomerId','Name')->first();

        if($case){
            $password = $request->input('Password');
            if($password==$case->Password){
                $dataArr = array('CustomerId' => $case->CustomerId, 'Name' => $case->Name);
                $jsonArr = array(
                    'status' => true,
                    'data' => $dataArr
                );
            }
            else{
                $jsonArr = array(
                    'status' => false,
                    'data' => 'Wrong Password'
                );
            }
            $response = new Response(json_encode($jsonArr));
            $response->header('Content-Type', 'Application')->cookie('name1', 'value', 10);
            return $response;
        }
        else{
            $jsonArr = array(
                'status' => false,
                'data' => 'Wrong Credentials'
            );
            $response = new Response(json_encode($jsonArr));
            return $response;
        }  
    }


     // menambah data

    public function store(Request $request)
     {
         return User::create($request->all());
     }

     // ganti data

    public function update($CustomerId, Request $request)
    {
         $user = User::where('User.CustomerId',$CustomerId)->update($request->all());
         return $user;
    }

    // delete data

    public function delete($CustomerId, Request $request)
    {
        $user = User::where('User.CustomerId',$CustomerId)->delete($request->all());
        return 204;
    }
 
    public function getUserTransaction($CustomerId)
    {
        $user = User::where('CustomerId', $CustomerId)->first();
        if ($user) {
            $transaction = User::where('User.CustomerId', $CustomerId)
                ->join('Transaction', 'Transaction.CustomerId', '=', 'User.CustomerId')
                ->select('TransactionId AS trxId', 'TotalPayment AS total', 'Timestamp AS time')->get();
            $jsonArr = array(
                'status' => true,
                'data' => $transaction
            );
            return json_encode($jsonArr);
        } else {
            $jsonArr = array(
                'status' => false,
                'data' => 'User not found'
            );
            return json_encode($jsonArr);
        }

        // return User::where('User.CustomerId', $CustomerId)
        //     ->join('Transaction', 'Transaction.CustomerId', '=', 'User.CustomerId')
        //     ->select('*')->get();
        // return User::where('CustomerId', $CustomerId)->first();
    }


}
