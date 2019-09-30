@extends('layouts.app')

@section('page')
	Zonefiles overview
@endsection

@push('style')
	{{ Jfcherng\Diff\DiffHelper::getStyleSheet() }}
@endpush

@push('menu')
@panel(['title' => 'Diff ' . $latestTwo->first()->title . ' - ' . $latestTwo->last()->title ])
	<div class="text-break" style="white-space: pre-line;">
			{!! $diff !!}
	</div>
@endpanel
@endpush

@section('content')
@panel
<table class="table table-sm">
	<tr>
		<th>Title</th>
		<th>Source</th>
		<th>Created</th>
	</tr>
	@foreach($zonefiles as $zonefile)
	<tr>
		<td>
			<a href="{{ route('zonefile.show', ['zonefile' => $zonefile])}}">
				{{$zonefile->title}}
			</a>
		</td>
		<td>{{ $zonefile->source}}</td>
		<td>{{ $zonefile->created_at}}</td>
	</tr>
	@endforeach
</table>
@endpanel
@endsection