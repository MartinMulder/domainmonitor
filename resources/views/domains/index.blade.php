@extends('layouts.app')

@section('page')
	Domain overview
@endsection

@push('menu')
@panel(['title' => 'Create new domain'])
@include('domains.partials.create')
@endpanel
@endpush

@section('content')
@panel
<table class="table table-sm">
	<tr>
		<th>Domain</th>
		<th>In BIT portal</th>
		<th>Record count</th>
		<th>Registrar</th>
		<th>Last whois date</th>
	</tr>
	@foreach($domains as $domain)
	<tr>
		<td>
			<a href="{{ route('domain.show', ['domain' => $domain])}}">
			@if($domain->last_whois_date)
				<span title="{{$domain->whoisData->rawData}}">{{$domain->domain}}</span>
			@else
				{{$domain->domain}}
			@endif
			</a>
		</td>
		<td>{{ $domain->in_bitportal}}</td>
		<td>{{ count($domain->dnsRecords)}}</td>
		@if(isset($domain->whoisData))
			<td>{{ $domain->whoisData->registrar}}</td>
		@else
			<td></td>
		@endif
		<td>{{ $domain->last_whois_date}}</td>
	</tr>
	@endforeach
</table>
@endpanel
@endsection