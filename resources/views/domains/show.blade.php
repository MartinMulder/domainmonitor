<a href="{{route('domain.index')}}">Back</a>
<h1>{{$domain->domain}}</h1>
<table border="1">
	<tr>
		<th>Name</th>
		<th>Type</th>
		<th>Destination</th>
		<th>Comment</th>
		<th>TTL</th>
		<th>Deletable</th>
	</tr>
	@foreach($domain->dnsRecords as $record)
	<tr>
		<td>{{ $record->name}}</td>
		<td>{{ $record->type}}</td>
		<td>{{ $record->destination}}</td>
		<td>{{ $record->comment}}</td>
		<td>{{ $record->ttl}}</td>
		<td>{{ $record->canDelete()}}</td>
	</tr>
	@endforeach
</table>