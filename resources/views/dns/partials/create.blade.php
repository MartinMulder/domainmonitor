<form method="POST" action="{{route('dnsrecord.store', ['domain' => $domain])}}">
	@csrf
	<div class="form-group row">
        <label for="name" class="col-md-3 col-form-label">{{ __('Record') }}</label>

        <div class="col-md-9">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="type" class="col-md-3 col-form-label">{{ __('Type') }}</label>

        <div class="col-md-9">
            <select id="type" class="form-control @error('type') is-invalid @enderror custom-select" name="type" required="required">
                <option value="" selected disabled hidden >{{ __('Please select') }}</option>
                <option value='TXT'>TXT</option>
                <option value='A'>A</option>
                <option value='AAAA'>AAAA</option>
                <option value='CNAME'>CNAME</option>
                <option value="SOA">SOA</option>
                <option value="NS">NS</option>
                <option value="MX">MX</option>
                <option value="CAA">CAA</option>
                <option value="SRV">SRV</option>
            </select>                

            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="destination" class="col-md-3 col-form-label">{{ __('Destination') }}</label>

        <div class="col-md-9">
            <input id="destination" type="text" class="form-control @error('destination') is-invalid @enderror" name="destination" value="{{ old('destination') }}" required autocomplete="destination" autofocus>

            @error('destination')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="ttl" class="col-md-3 col-form-label">{{ __('ttl') }}</label>

        <div class="col-md-9">
            <input id="ttl" type="text" class="form-control @error('ttl') is-invalid @enderror" name="ttl" value="{{ old('ttl') }}" required autocomplete="ttl" autofocus>

            @error('ttl')
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