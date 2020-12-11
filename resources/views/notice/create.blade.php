@extends('layouts.auth')
@section('navcontent')
<div class="navcontainer">
    <form method="POST" action="{{ route('notice.store') }}"  enctype="multipart/form-data">
        @csrf
        <fieldset>
            <legend>{{ __('Create Notice') }}</legend>
            @include('includes.messages')
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Notice Title') }}</label>

                <div class="col-md-6">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                        value="{{ old('title') }}" required autocomplete="title" autofocus
                        placeholder="Enter title of notice">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="file" class="col-sm-2 col-form-label">{{ __('File Upload') }}</label>
                <div class="col-md-6">
                    <input id="file_name" type="file" class="form-control @error('file_name') is-invalid @enderror"
                        name="file_name" value="">  
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Select Users</label>
                <select name="users[]" id="users" class="users" multiple>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->firstname}} {{$user->lastname}}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row">
                <label for="text" class="col-sm-2 col-form-label">{{ __('Notice in details') }}</label>

                <div class="col-md-6">
                    <textarea class="form-control" name="text" id="mytextarea">
                                    {{ old('text') }}
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
<style>
.multiselect-container>li>a>label {
    padding: 4px 20px 3px 20px;
}
</style>
@section('jscript')

<script type="text/javascript">
$(document).ready(function() {

    $('document , #users').multiselect({

        selectAllValue: 'multiselect-all',
        includeSelectAllOption: true,
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        maxHeight: '300',
        buttonWidth: '235',
    });


});
</script>
@endsection