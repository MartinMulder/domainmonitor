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
		<div class="card card-defaut mb-4">
			<h4 class="card-header">Reverse DNS<span class="float-md-right"><a href="{{route('retry.reversedns', ['ip' => $ip->id])}}" title="Retry reverse DNS lookup"><i class="fas fa-redo"></i></a></span></h4>
			<div class="card-body">
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
			</div>
		</div>
	</div>
	<div class="col-12">
			<div class="card card-defaut mb-4">
			<h4 class="card-header">Services<span class="float-md-right"><a href="{{route('retry.portscan', ['ip' => $ip->id])}}" title="Retry portscan"><i class="fas fa-redo"></i></a></span></h4>
			<div class="card-body">
				<table class="table table-sm">
					<tr>
						<th>Port</th>
						<th>Name</th>
						<th>Proto</th>
					</tr>
					@foreach($ip->services as $service)
						<tr>
							<td>{{$service->port}}</td>
							<td><span title="{{$service->product}} - {{$service->version}}">{{$service->service_name}}</span></td>
							<td>{{$service->protocol}}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
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