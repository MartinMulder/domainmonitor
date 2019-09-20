@extends('layouts.app')

@section('page')
	IP: {{$ip->ip}}
@endsection

@push('menu')
	<div class="col-12">
		@panel(['title' => "Log"])
			@include('auditlog.partials.sidebar', ['auditlogs' => $ip->auditLogs])
		@endpanel
	</div>
	<div class="col-12">
		@panel(['title' => "Reverse DNS"])
			<table class="table">
				<tr>
					<td>
						Reverse DNS
					</td>
					<td>
						{{ $ip->reverse_dns}}
					</td>
				</tr>
			</table>
		@endpanel
	</div>
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		@panel(['title' => "DNS records pointing to IP"])
			<table class="table table-sm">
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
		@endpanel
	</div>
</div>
@endsection