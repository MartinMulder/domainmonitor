@extends('layouts.app')

@section('content')
<table class="table">
	<tr>
		<th>IP</th>
		<th>Reverse DNS</th>
		<th>DNS records</th>
	</tr>
	@foreach($ips as $ip)
	<tr>
		<td>
			<a href="{{ route('ip.show', ['ip' => $ip])}}">
				{{ $ip->ip }}
			</a>
		</td>
		<td>{{ $ip->reverse_dns}}</td>
		<td>{{ $ip->dnsrecords_count }}</td>
	</tr>
	@endforeach
</table>
@endsection