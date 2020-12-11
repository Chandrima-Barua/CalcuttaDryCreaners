@extends('layouts.auth')
@section('navcontent')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <legend>{{ __('Edit Branch Name') }}</legend>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <form method="post" action="{{ route('branch.update', $branch->id) }}">
            {{ csrf_field() }}
            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">Branch Name:</label>
                <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{ $branch->name }}" />
            </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Serial Range') }}</label>

                <div class="col-md-6">
                    <input id="start_limit" type="text" class="form-control @error('start_limit') is-invalid @enderror"
                        name="start_limit" value="{{ $branch->start_limit }}" required autocomplete="start_limit"
                        autofocus placeholder="Start">
                        <input id="running_no" type="text" class="form-control @error('running_no') is-invalid @enderror"
                        name="running_no" value="{{ $branch->running_no }}" required autocomplete="running_no"
                        autofocus placeholder="Start">
                    <input id="end_limit" type="text" class="form-control @error('end_limit') is-invalid @enderror"
                        name="end_limit" value="{{ $branch->end_limit }}" required autocomplete="end_limit" autofocus
                        placeholder="End">

                
                        </div>
                        </div>    
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">{{ __('Branch Address') }}</label>

                    <div class="col-md-6">
                        <textarea class="form-control" name="address" id="mytextarea">
                                   {{ $branch->address }}
                                </textarea>
                    </div>
                </div>
                <div class="form-group row ">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection