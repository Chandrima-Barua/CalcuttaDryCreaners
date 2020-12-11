@extends('layouts.auth')
@section('navcontent')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <legend>{{ __('Send Legal Notification of ')  }} {{$legal->legal_categories['name']}}</legend>

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
        <form method="post" action="{{ route('legal_documents.set_deadline') }}">
            {{ csrf_field() }}
            <div class="form-group">

                <label for="name" class="col-sm-2 col-form-label">Users:</label>

                <select name="users[]" id="users" class="users" multiple>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">

                        {{$user->firstname}} {{$user->lastname}}
                    </option>

                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="deadline_date">Date</label>
                        <input type="date" class="form-control" id="deadline_date" name="deadline_date"
                            value="{{ old('deadline_date') }}">
                    </div>

                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Set Alert</button>
            </div>
        </form>
    </div>
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