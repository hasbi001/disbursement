<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use DataTables;

class TransactionController extends Controller
{
    public function index()
    {
    	return view('transaksi');
    }

    public function ajaxLoad(Request $request)
    {
    	$model = TransactionDetail::orderBy('id','DESC');

    	return DataTables::of($model)->addColumn('action', function($row)
            {
                $action = '<a href="'.route('assign_senderid.change.is_active',['id' => $row->disburse_id]).'"> view </a>'
                $action .= '</div>';

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function view($id)
    {
    	$response = TransactionDetail::checkStatus($id);
    	$data = $response['data'];
	    return view('view',compact('data'));
    }
}
