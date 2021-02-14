<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use GuzzleHttp\Client;

class TransactionDetail extends Model
{
    protected $table = "transaction_detail";
    protected $fillable = ['id','transaction_id','disburse_id','amount','timestamp','account_number','beneficiary_name','remark','receipt','time_served','fee','created_at','updated_at','status'];

    public static function checkStatus($disburseId)
    {
        $keyauth = 'HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41';
        DB::beginTransaction();
        try {
            $model = TransactionDetail::where('disburse_id',$disburseId)->first();
            if (empty($model)) {
                $response = [ 'code'=>422,'status'=>'error','message'=>'Data is not found', 'errors' =>[],'data'=>[] ];
                DB::rollback();
            }
            else
            {
                $client = new Client;
                $request = $client->request('GET', 'https://nextar.flip.id/disburse/'.$disburseId,[
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'auth'=>[$keyauth,''],
                ]);
                $dataReq = json_decode($request->getBody()->getContents());
                $dataUpdate = [
                    'status' => $dataReq->status,
                    'receipt' => $dataReq->receipt,
                    'time_served' => $dataReq->time_served,
                ];

                $update = TransactionDetail::where('disburse_id',$disburseId)->update($dataUpdate);
                if ($update) {
                    $response = [ 'code'=>200,'status'=>'success','message'=>'success to update data detail transaction', 'errors' =>[],'data'=>$model->toArray() ];    
                    DB::commit();
                }
                else
                {
                    $response = [ 'code'=>422,'status'=>'error','message'=>'Failed to update data detail transaksi', 'errors' =>[],'data'=>[] ];
                    DB::rollback();
                }                    
            }       

            return $response;
        } catch (\Exception $e) {
            $response = [ 'code'=>422,'status'=>'error','message'=> $e->getMessage(), 'errors' =>[],'data'=>[] ];
            DB::rollback();
            return $response;
        }
    }
}
