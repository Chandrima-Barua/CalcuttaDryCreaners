@extends('layouts.auth')
@section('navcontent')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
    <legend>{{ __('Create New Service') }}</legend>

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
        <form method="post" action="{{ route('services.update', $service->id) }}">
        {{ csrf_field() }}
            <div class="form-group">

                <label for="name">Service Name:</label>
                <input type="text" class="form-control" name="name" value="{{ $service->name }}" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection