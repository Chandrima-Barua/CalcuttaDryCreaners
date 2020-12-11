@extends('layouts.auth')
@section('navcontent')
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row d-flex align-items-center">
                        <div class="col"><i id="editProfileToggle" class="fas mr-auto fa-edit fa-2x "
                                style="cursor:pointer"></i></div>
                        <div class="col text-center"><strong class="mr-auto">Profile</strong></div>
                        <div class="col"></div>
                    </div>
                </div>
                <form id="profileForm" action="{{ route('user.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('includes.messages')
                        <div class="card-img text-center">
                            @if (File::exists(public_path("profile_pictures/".$profile->profilePicture)))
                            <img src="{{ asset('profile_pictures/' . $profile->profilePicture) }}"
                                alt="{{ $profile->firstname }} {{ $profile->lastname }}" width="200" height="200"
                                class=" my-3 rounded-circle profilepicture" id="profilepicture" />
                            @else
                            <img src="{{ $profile->gravatarURL }}"
                                alt="{{ $profile->firstname }} {{ $profile->lastname }}" width="200" height="200"
                                class=" my-3 rounded-circle profilepicture" id="profilepicture" />
                            @endif


                            <input type='file' id="imgInp" name="profilePicture" />
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" readonly id="firstname" class="form-control"
                                        value="{{ old('firstname') ? old('firstname') : $profile->firstname }}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" readonly id="lastname" class="form-control"
                                        value="{{ old('lastname') ? old('lastname') : $profile->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <label for="email">Email address</label>
                                    <input type="email" id="email" name="email" readonly
                                        value="{{ old('email') ? old('email') : $user->email }}" class="form-control">
                                </div>
                                <div class="col-12 col-md-5">
                                    <label for="phone">Phone number</label>
                                    <input type="tel" id="phone" name="phone" readonly
                                        value="{{ old('phone') ? old('phone') : $profile->phone }}"
                                        class="form-control">
                                </div>
                                <div class="col-12 col-md-2">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="custom-select text-capitalize" readonly>
                                        @php $genders = ['male', 'female', 'not-specified']; @endphp
                                        @foreach($genders as $gender)
                                        <option value="{{ $gender }}" @if($gender==$profile->gender) selected
                                            @endif>{{ ucwords(str_replace('-', ' ', $gender)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="street">Street Address</label>
                                    <input readonly type="text" class="form-control" id="street" name="street"
                                        value="{{ old('street') ? old('street') : $profile->street }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="street1">Street Address Line 1</label>
                                    <input readonly type="text" class="form-control" id="street1" name="street1"
                                        value="{{ old('street1') ? old('street1') : $profile->street1 }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label for="area">Area</label>
                                    <input readonly type="text" class="form-control" id="area" name="area"
                                        value="{{ old('area') ? old('area') : $profile->area }}">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="city">City</label>
                                    <input readonly type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city') ? old('city') : $profile->city }}">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="zip">ZIP</label>
                                    <input readonly type="text" class="form-control" id="zip" name="zip"
                                        value="{{ old('zip') ? old('zip') : $profile->zip }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <button id="updateProfile" class="btn btn-block btn-primary d-none"
                                        type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {

    // Profile Edit Enable Disable Toggler
    let profileIsEditable = false
    $("#editProfileToggle").on("click", function() {
        if (profileIsEditable) {
            $("#profileForm input").each(function() {
                $(this).attr("readonly", true)
                $("#editProfileToggle").removeClass('fa-arrow-left').addClass('fa-edit')
                    .removeClass(
                        'text-danger').addClass('text-primary')
            })
            profileIsEditable = false
        } else {
            $("#profileForm input").removeAttr("readonly")
            $("#editProfileToggle").removeClass('fa-edit').addClass('fa-arrow-left').removeClass(
                    'text-primary')
                .addClass('text-danger')
            profileIsEditable = true
        }
        $("#updateProfile").toggleClass('d-none')
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#profilepicture').attr('src', e.target.result).css('border-radius', '50%');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });


});
</script>
@endpush