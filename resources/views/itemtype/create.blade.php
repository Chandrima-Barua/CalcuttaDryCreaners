@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('itemtype.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New Type of Item') }}</legend>
            @include('includes.messages')
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                
                </div>
            </div>

         <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
    </form>

</div>
@endsection