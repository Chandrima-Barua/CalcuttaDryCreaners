@extends('layouts.auth')
@section('navcontent')
<div class="navcontainer">
    <form method="POST" action="{{ route('branch.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New Branch') }}</legend>
            @include('includes.messages')
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Branch Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus
                        placeholder="Enter branch name">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Serial Range') }}</label>

                <div class="col-md-6">
                    <input id="start_limit" type="text" class="form-control @error('start_limit') is-invalid @enderror" name="start_limit"
                        value="{{ old('start_limit') }}" required autocomplete="start_limit" autofocus placeholder="Start">
                        <input id="running_no" type="text" class="form-control @error('running_no') is-invalid @enderror" name="running_no"
                        value="{{ old('running_no') }}" required autocomplete="running_no" autofocus placeholder="Running Serial">
                    <input id="end_limit" type="text" class="form-control @error('end_limit') is-invalid @enderror" name="end_limit"
                        value="{{ old('end_limit') }}" required autocomplete="end_limit" autofocus placeholder="End">

                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">{{ __('Branch Address') }}</label>

                <div class="col-md-6">
                    <textarea class="form-control" name="address" id="mytextarea">
                                    {{ old('address') }}
                                </textarea>
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