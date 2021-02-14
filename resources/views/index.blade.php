@extends('layouts.app')

@section('content')
<center>
	<table class="table table-responsive" id="list" style="width:100%;">
		<thead>
			<tr>
				<td>Disburse ID</td>
				<td>Status</td>
				<td>Amount</td>
				<td>Timestamp</td>
				<td>Account Number</td>
				<td>Beneficiary Name</td>
				<td>Remark</td>
				<td>Time Served</td>
				<td>Fee</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</center>

<script type="text/javascript">
  $(function () {
    
    var table = $('#list').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('transaksi.list') }}",
        columns: [
            {data: 'disburse_id', name: 'disburse_id'},
            {data: 'status', name: 'status'},
            {data: 'amount', name: 'amount'},
            {data: 'timestamp', name: 'timestamp'},
            {data: 'account_number', name: 'account_number'},
            {data: 'beneficiary_name', name: 'beneficiary_name'},
            {data: 'remark', name: 'remark'},
            {data: 'time_served', name: 'time_served'},
            {data: 'fee', name: 'fee'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@stop