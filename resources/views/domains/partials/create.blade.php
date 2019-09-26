<form method="POST" action="{{route('domain.store')}}">
	@csrf
	<div class="form-group row">
        <label for="domain" class="col-md-3 col-form-label">{{ __('Domainname') }}</label>

        <div class="col-md-9">
            <input id="domain" type="text" class="form-control @error('domain') is-invalid @enderror" name="domain" value="{{ old('domain') }}" required autocomplete="domain" autofocus>

            @error('domain')
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