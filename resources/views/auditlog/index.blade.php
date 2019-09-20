@extends('layouts.app')

@section('page')
	Auditlog overview
@endsection

@section('content')
@panel
<table class="table table-sm">
	<tr>
		<th>ID</th>
		<th>When</th>
		<th>Action</th>
		<th>Model</th>
		<th>Model ID</th>
		<th>Description</th>
		<th>Result</th>
	</tr>
	@foreach($auditlogs as $log)
	<tr>
		<td>
			{{ $log->id }}
		</td>
		<td>
			{{ $log->created_at }}
		</td>
		<td>
			{{ $log->action }}
		</td>
		<td>
			{{ $log->auditable_type }}
		</td>
		<td>
			{{ $log->auditable_id }}
		</td>
		<td>
			<span title="{{ $log->result }}">{{ $log->description }}</span>
		</td>
		<td>
		</td>
	</tr>
	@endforeach
</table>
@endpanel
@endsection