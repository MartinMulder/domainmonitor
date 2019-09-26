@extends('layouts.onecolumn')

@section('page')
	Websites overview
@endsection

@section('content')
@panel
<div class="card-deck">
@foreach($websites as $website)
<div class="col-md-3">
	<div class="card mb-4">
		@if($website['image'])
		<img src="{{ $website['image'] }}" class="card-img-top" />
		@endif
		<div class="card-body">

			<p class="card-text">
				{{ $website['url'] }} 
				<a href="{{ $website['url'] }}" target="_blank" title="Open in browser">
					<i class="fas fa-external-link-alt"></i>
				</a>
				<a href="{{ route('domain.show', $website['record']->domain->id) }}" title="Goto domain">
					<i class="fas fa-link"></i>
				</a>
			</p>
		</div>
	</div>
</div>
@endforeach
</div>
@endpanel
@endsection