<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Calcutta Dry Cleaners</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

</head>

<body>
    @extends('layouts.app')

    @section('content')
    <div id="login">
        <h3 class="text-center text-white pt-5">Calcutta Dry Cleaners</h3>
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <h3 class="text-info"><i class="fas fa-user"></i> Login</h3>
                    <div class="form-group">
                        <label for="email" class="text-info">E-Mail Addres:</label><br>
                        <input type="email" id="email"
                            class="form-control @error('email') is-invalid @enderror fadeIn second" name="email"
                            id="login" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-info">Password:</label><br>
                        <input type="password" name="password" id="password" class="fadeIn third">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="remember-me" class="text-info"><span>Remember me</span> <span><input
                                    id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                        <input type="submit" name="submit" class="fadeIn fourth" value="submit">

                    </div>
                    <div id="formFooter">

                        <a class="underlineHover" href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <div id="register-link">

                        <a href="{{ route('register') }}" class="underlineHover">Register here</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @endsection
</body>

</html>