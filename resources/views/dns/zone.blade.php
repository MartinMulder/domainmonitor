@extends('layouts.app')

@section('content')
<table class="table table-sm">
@foreach($zone->getResourceRecords() as $record)
	<tr>
		<td>{{$record->getName()}}</td>
		<td>{{$record->getClass()}}</td>
		<td>{{$record->getTtl()}}</td>
		<td>{{$record->getRdata()->getType()}}</td>
		<td>{{$record->getRdata()->output()}}</td>
	</tr>
@endforeach
</table>
@endsection