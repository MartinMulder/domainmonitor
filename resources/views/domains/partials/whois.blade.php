<table class="table table-sm">
	<tr>
		<td>
			Registrar
		</td>
		<td>
			{{ $domain->whoisData->registrar }}
		</td>
	</tr>
	<tr>
		<td>
			Dnsservers
		</td>
		<td>
			<ul class="list-unstyled">
			@foreach(explode(',', $domain->whoisData->dnsservers) as $server)
				<li>{{ $server }}</li>
			@endforeach
			</ul>
		</td>
	</tr>
</table>
