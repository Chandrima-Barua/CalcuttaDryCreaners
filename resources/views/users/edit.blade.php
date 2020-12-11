@extends('layouts.auth')
@section('navcontent')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <legend>{{ __('Edit Roles of ')  }} {{$user->firstname}}</legend>

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
        <form method="post" action="{{ route('users.update', $user->id) }}">
            {{ csrf_field() }}
            <div class="form-group">

                <label for="name">Role Name:</label>

                <select name="roles[]" id="roles" class="roles" multiple>
                    @foreach($allroles as $allrole)
                    <option value="{{$allrole->id}}" @foreach ($roles as $role) @if ($allrole->id == $role->id)
                        selected
                        @endif
                        @endforeach>
                        {{$allrole->name}}
                    </option>

                    @endforeach
                </select>
            </div>

            <div class="form-group">

                <label for="name">Branch Name:</label>

                <select name="branches[]" id="branches" class="branches" multiple>
                    @foreach($allbranches as $allbranch)
                    <option value="{{$allbranch->id}}" @foreach ($branches as $branch) @if ($allbranch->id ==
                        $branch->id)
                        selected
                        @endif
                        @endforeach>
                        {{$allbranch->name}}
                    </option>

                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
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
    
    $('document , #roles').multiselect({

        selectAllValue: 'multiselect-all',
        includeSelectAllOption: true,
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        maxHeight: '300',
        buttonWidth: '235',
    });

    $('document , #branches').multiselect({

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
