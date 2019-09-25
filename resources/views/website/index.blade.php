@extends('layouts.app')

@section('page')
	Websites overview
@endsection

@section('content')
@panel
<div class="card-deck">
@foreach($websites as $website)
<div class="col-md-4">
	<div class="card mb-4">
		@if($website['image'])
		<img src="{{ $website['image'] }}" class="card-img-top" />
		@endif
		<div class="card-body">

			<p class="card-text"><a href="{{ $website['url'] }}" target="_blank">{{ $website['url'] }}</a></p>
		</div>
	</div>
</div>
@endforeach
</div>
@endpanel
@endsection