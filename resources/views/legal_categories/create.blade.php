@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('legal_categories.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create Legal Category') }}</legend>
            @include('includes.messages')
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter role name">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row ">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create') }}
                    </button>
                </div>
            </div>

</fieldset>

    </form>
</div>
@endsection