<table class="table table-sm">
	<tr>
		<th>When</th>
		<th>Action</th>
	</tr>
	@foreach($auditlogs as $log)
	<tr>
		<td>
			{{ $log->created_at }}
		</td>
		<td>
			<span title="{{ $log->result }}">{{ $log->action }}</span>
		</td>
	</tr>
	@endforeach
</table>