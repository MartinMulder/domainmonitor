
@extends('layouts.app')

@section('page')
	Diff between: {{$old->title}} and {{$new->title}}
@endsection

@push('style')
	{{ Jfcherng\Diff\DiffHelper::getStyleSheet() }}
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		@panel(['title' => 'Diff'])
		<div class="text-break">
				{!! $diff !!}
		</div>
		@endpanel
	</div>
</div>
@endsection