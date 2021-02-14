<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class TransactionController extends Controller
{
    public function saveTransaction(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	        'bank_code' => 'required|string',
	        'account_number' => 'required|numeric',
	        'amount' => 'required|numeric',
	        'remark' => 'required|string',
	    ]);

    	if ($validator->fails())
	    {
	        return response(['status'=>'error','message'=>'Failed to create user','errors'=>$validator->errors()->all()], 422);
	    }

	    // save data 
	    $response = Transaction::saveTransaksi($request->all());
	    if($response['code'] == 200){
	    	return response($response, 200);
	    }
	    else
	    {
	    	return response($response, 422);
	    }
	    
    }

    public function checkStatus($disburseId)
    {
    	$response = TransactionDetail::checkStatus($disburseId);
	    if($response['code'] == 200){
	    	return response($response, 200);
	    }
	    else
	    {
	    	return response($response, 422);
	    }
    }

    public function test()
    {
    	$keyauth = 'HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41';
    	$data =  [
	        'bank_code' => 'mandiri',
	        'account_number' => '20129283',
	        'amount' => '20000',
	        'remark' => 'test remark',
	    ];
    	$client = new Client;
    	$request = $client->request('GET', 'https://nextar.flip.id/disburse/8094120241',[
    		'headers' => [
		        'Content-Type' => 'application/x-www-form-urlencoded',
		    ],
    		'auth'=>[$keyauth,''],
    	]);
    	return $request->getBody()->getContents();
    }
}
