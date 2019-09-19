@extends('layouts.app')

@section('content')
<table class="table">
	<tr>
		<th>ID</th>
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
			{{ $log->action }}
		</td>
		<td>
			{{ $log->auditable_type }}
		</td>
		<td>
			{{ $log->auditable_id }}
		</td>
		<td>
			{{ $log->description }}
		</td>
		<td>
			{{ $log->result }}
		</td>
	</tr>
	@endforeach
</table>
@endsection