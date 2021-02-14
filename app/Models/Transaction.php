<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\TransactionDetail;
use GuzzleHttp\Client;

class Transaction extends Model
{
    protected $table = "transaction";
    protected $fillable = ['id','bank_code','account_number','amount','remark','created_at','updated_at'];

    public static function saveTransaksi($data=[])
    {
    	$keyauth = 'HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41';
    	DB::beginTransaction();
    	try {
    		$transaction = new Transaction;
    		$transaction->bank_code = $data['bank_code'];
    		$transaction->account_number = $data['account_number'];
    		$transaction->amount = $data['amount'];
    		$transaction->remark = $data['remark'];

    		if ($transaction->save()) {
    			$client = new Client;
    			$request = $client->request('POST', 'https://nextar.flip.id/disburse',[
    				'headers' => [
				        'Content-Type' => 'application/x-www-form-urlencoded',
				    ],
		    		'form_params'=> $data,
		    		'auth'=>[$keyauth,''],
    			]);
    			if($request->getStatusCode() == 200){
    				$dataDetail = json_decode($request->getBody()->getContents());
    				$detail = new TransactionDetail;
    				$detail->transaction_id = $transaction->id;
    				$detail->disburse_id = $dataDetail->id;
                    $detail->status = $dataDetail->status;
    				$detail->amount = $dataDetail->amount;
    				$detail->timestamp =  $dataDetail->timestamp;
    				$detail->account_number = $dataDetail->account_number;
    				$detail->beneficiary_name = $dataDetail->beneficiary_name;
    				$detail->remark = $dataDetail->remark;
    				$detail->receipt = $dataDetail->receipt;
    				if ($dataDetail->time_served != '0000-00-00 00:00:00') {
    					$detail->time_served = $dataDetail->time_served; 
    				}
    				else
    				{
    					$detail->time_served =  NULL ;
    				}
    				// $detail->time_served = $dataDetail->time_served;
    				$detail->fee = $dataDetail->fee;

    				if ($detail->save()) {
    					$response = [ 'code'=>200,'status'=>'success','message'=>'success to create data transaksi and detail transaction', 'errors' =>[],'data'=> $detail->toArray() ];	
    					DB::commit();
    				}
    				else
    				{
    					$response = [ 'code'=>422,'status'=>'error','message'=>'Failed to create data detail transaksi', 'errors' =>[],'data'=>[] ];
    					DB::rollback();
    				}
    			}
    			
    		}
    		else
    		{
    			$response = [ 'code'=>422,'status'=>'error','message'=>'Failed to create data transaksi', 'errors' =>[],'data'=>[] ];
    			DB::rollback();
    		}

    		return $response;
    	} catch (\Exception $e) {
    		$response = [ 'code'=>422,'status'=>'error','message'=> $e->getMessage(), 'errors' =>[],'data'=>[] ];
    		DB::rollback();
    		return $response;
    	}
    }
}
