@extends('layouts.app')

@section('page')
	Websites overview
@endsection

@section('content')
@panel
<table class="table table-sm">
@foreach($websites as $website)
<tr>
	<td><a href="{{ $website['url'] }}" target="_blank">{{ $website['url'] }}</a></td>	
</tr>
@endforeach
</table>
@endpanel
@endsection