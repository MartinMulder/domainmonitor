@extends('layouts.app')

@section('content')
<a href="{{route('ip.index')}}">Back</a>
<h1>{{$ip->ip}}</h1>
<table class="table">
	<tr>
		<th>Name</th>
		<th>Domain</th>
		<th>Type</th>
		<th>Destination</th>
		<th>Comment</th>
		<th>TTL</th>
		<th>Deletable</th>
	</tr>
	@foreach($ip->dnsRecords as $record)
	<tr>
		<td>{{ $record->name}}</td>
		<td><a href="{{route('domain.show', $record->domain)}}">{{ $record->domain->domain}}</a></td>
		<td>{{ $record->type}}</td>
		<td>{{ $record->destination}}</td>
		<td>{{ $record->comment}}</td>
		<td>{{ $record->ttl}}</td>
		<td>{{ $record->canDelete()}}</td>
	</tr>
	@endforeach
</table>
@endsection