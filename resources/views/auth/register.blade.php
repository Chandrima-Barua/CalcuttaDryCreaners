@extends('layouts.app')

@section('content')
<div id="login">
    <h3 class="text-center text-white pt-5">Calcutta Dry Cleaners</h3>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h3 class="text-info"><i class="fas fa-user"></i> Register</h3>
                <div class="form-group">
                    <label for="firstname" class="text-info">{{ __('First Name') }}</label><br>


                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror"
                        name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus
                        placeholder="Firstname">

                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <div class="form-group">
                    <label for="lastname" class="text-info">{{ __('Last Name') }}</label>


                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"
                        name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus
                        placeholder="Lastname">

                    @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="text-info">{{ __('E-Mail Address') }}</label>


                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Enter email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phonenumber" class="text-info">{{ __('Phone Number') }}</label>


                    <input id="phonenumber" type="text" class="form-control @error('phonenumber') is-invalid @enderror"
                        name="phonenumber" value="{{ old('phonenumber') }}" required autocomplete="phonenumber"
                        id="exampleInputEmail1" aria-describedby="phonenumberHelp" placeholder="Enter phone number">

                    @error('phonenumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>



                <div class="form-group">
                    <label for="password" class="text-info">{{ __('Password') }}</label>


                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" id="exampleInputPassword1"
                        placeholder="Password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="text-info">{{ __('Confirm Password') }}</label>


                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password" placeholder="Confirm your password">

                </div>
                <div class="form-group">

                    <button type="submit" class="register">
                        {{ __('Register') }}
                    </button>

                </div>


            </form>
        </div>
    </div>

</div>
@endsection

@section('jscript')

<script type="text/javascript">
$(document).ready(function() {
//     $.ajax({
//         type: 'POST',
//         url: '/storetoken',
//         data: {
//             token: token,
//             _token: "<?php echo csrf_token(); ?>"
//         },
//         success: function(data) {
//             $("#msg").html(data);
//         }
//     });
// });
</script>
@endsection