@extends('layouts.app')

@section('page')
	Domain: {{ $domain->domain }}
@endsection

@push('menu')
	<div class="col-12">
		@panel(['title' => "Log"])
			@include('auditlog.partials.sidebar', ['auditlogs' => $domain->auditLogs])
		@endpanel
	</div>
	<div class="col-12">
		@panel(['title' => "Whois"])
			@include('domains.partials.whois', ['domain' => $domain])
		@endpanel
	</div>
	<div class="col-12">
		@panel(['title' => "Create record"])
			@include('dns.partials.create')
		@endpanel
	</div>
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		@panel(['title' => "DNS records" ])
		<table class="table table-sm">
			<tr>
				<th class="col-sm-1">Name</th>
				<th class="col-sm-1">Type</th>
				<th class="text-wrap col-sm-7">Destination</th>
				<th class="col-sm-2">Comment</th>
				<th class="col-sm-1">TTL</th>
			</tr>
			@foreach($domain->dnsRecords as $record)
			<tr>
				<td>{{ $record->name}}</td>
				<td>{{ $record->type}}</td>
				<td class="text-break">
					@if(filter_var($record->destination, FILTER_VALIDATE_IP) && $foo = App\Models\Ip::where('ip', '=', $record->destination)->firstOrFail())
						<a href="{{ route('ip.show', $foo->id)}}">{{ $record->destination}}</a>
					@else
						{{ $record->destination }}
					@endif
				</td>
				<td>{{ $record->comment}}</td>
				<td>{{ $record->ttl}}</td>
			</tr>
			@endforeach
		</table>
		@endpanel
	</div>
</div>
@endsection