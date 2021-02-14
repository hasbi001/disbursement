@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}">Back</a>
<ul>
	@foreach($data as $key => $value)
		<li>
			@if(!empty($value) && $key == 'receipt')
				<img src="{{ $value }}">
			@else
				{{ $value }}
			@endif
		</li>
	@endforeach
</ul>
@stop