<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use DataTables;

class TransactionController extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function ajaxLoad()
    {
    	$model = TransactionDetail::orderBy('id','DESC');

    	return DataTables::of($model)->addColumn('action', function($row)
            {
                $action = '<a href="'.route('view',['id' => $row->disburse_id]).'"> view </a>';

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
