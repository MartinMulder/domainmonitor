@extends('layouts.app')

@section('page')
	Create zonefile
@endsection

@section('content')
@panel
<form method="POST" action="{{route('zonefile.store')}}">
	@csrf
	<div class="form-group row">
        <label for="title" class="col-md-2 col-form-label">{{ __('Title') }}</label>

        <div class="col-md-10">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="source" class="col-md-2 col-form-label">{{ __('Source') }}</label>

        <div class="col-md-10">
            <input id="source" type="text" class="form-control @error('source') is-invalid @enderror" name="source" value="{{ old('source') ?? 'bit_portal' }}" required autocomplete="source" autofocus>

            @error('source')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="content" class="col-md-2 col-form-label">{{ __('Content') }}</label>

        <div class="col-md-10">
            <textarea id="content" type="text" rows="20" class="form-control @error('content') is-invalid @enderror" name="content" value="{{ old('content') }}" required autocomplete="content" autofocus></textarea>

            @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-2">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </div>
</form>
@endpanel
@endsection