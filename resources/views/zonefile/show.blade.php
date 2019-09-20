

@extends('layouts.app')

@section('page')
	Zonefile: {{$zonefile->title}}
@endsection

@push('menu')
	<div class="col-12">
		@panel(['title' => "Log"])
			@include('auditlog.partials.sidebar', ['auditlogs' => $zonefile->auditLogs])
		@endpanel
	</div>
	<div class="col-12">
		@panel(['title' => "Stats"])
			<table class="table">
				<tr>
					<td>
						Created
					</td>
					<td>
						{{ $zonefile->created_at}}
					</td>
				</tr>
			</table>
		@endpanel
	</div>
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		@panel(['title' => 'Content'])
		<div class="text-break">
			<pre>
				{{ $zonefile->content }}
			</pre>
		</div>
		@endpanel
	</div>
</div>
@endsection