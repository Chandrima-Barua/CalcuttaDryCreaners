<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=11" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
    <script src="{{asset('js/sidenav.js')}}"></script>

    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/sidenav.css') }}" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-notifications.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script>
    tinymce.init({

        selector: '#mytextarea',
        force_br_newlines: false,
        force_p_newlines: false,
        forced_root_block: '',

    });
    </script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-messaging.js"></script>
   
    <style>
    .notifications {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 30px;
        box-sizing: border-box;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .2);
    }

    .notifications:hover .fa {
        color: #fff;
    }

    .notifications .fa {
        color: #cecece;
        line-height: 40px;
        font-size: 20px;
    }

    .notifications .num {
        position: absolute;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #ff2c74;
        color: #fff;
        line-height: 25px;
        font-family: sans-serif;
        text-align: center;
    }


    .ulnoti {

        position: absolute;
        right: 0;
        top: 50px;
        margin: 0;
        background: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
        padding: 20px;
        box-sizing: border-box;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        display: none;
        z-index: 1;
    }

    .notifications:hover .ulnoti {
        display: block;
    }

    .ulnoti li {
        list-style: none;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
        padding: 8px 0;
        display: flex;
    }

    .ulnoti li:last-child {
        border-bottom: none;
    }

    .ulnoti li .icon {
        width: 24px;
        height: 24px;
        background: #ccc;
        border-radius: 50%;
        text-align: center;
        line-height: 24px;
        margin-right: 15px;
    }

    .ulnoti li .icon .fa {
        color: #fff;
        font-size: 16px;
        line-height: 24px;
    }

    .ulnoti li .text {
        position: relative;
        font-family: sans-serif;
        top: 3px;
        cursor: pointer;
    }

    .ulnoti li:hover .text {
        font-weight: bold;
        color: #ff2c74;
    }


    .fade {
        opacity: 1;
    }

    body {
        margin: 0;
        padding: 0;
        /* background-color: #41efbb; */
        height: 100vh;
    }

    #login .container #login-row #login-column #login-box {
        margin-top: 120px;
        max-width: 600px;
        height: 320px;
        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
    }

    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }

    #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -85px;
    }

    .btn-info {

        background-color: #2fa661;
    }

    .text-info {
        color: black !important;
        margin-top: 10px;
    }

    .text-center {
        color: #2fa661 !important
    }


    #wrapper {
        padding-left: 0;
    }

    #page-wrapper {
        width: 100%;
        padding: 0;
        background-color: #fff;
    }

    @media(min-width:768px) {
        #wrapper {
            padding-left: 225px;
        }

        #page-wrapper {
            padding: 22px 10px;
        }
    }

    /* Top Navigation */

    .top-nav {
        padding: 0 15px;
    }

    .top-nav>li {
        display: inline-block;
        float: left;
    }

    .top-nav>li>a {
        padding-top: 20px;
        padding-bottom: 20px;
        line-height: 20px;
        color: #fff;
    }

    .top-nav>li>a:hover,
    .top-nav>li>a:focus,
    .top-nav>.open>a,
    .top-nav>.open>a:hover,
    .top-nav>.open>a:focus {
        color: #fff;
        background-color: #3c7855;
    }

    .top-nav>.open>.dropdown-menu {
        float: left;
        position: absolute;
        margin-top: 0;
        /*border: 1px solid rgba(0,0,0,.15);*/
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        background-color: #fff;
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    }

    .top-nav>.open>.dropdown-menu>li>a {
        white-space: normal;
    }

    /* Side Navigation */

    /* @media(min-width:768px) { */
    .side-nav {
        position: fixed;
        top: 71px;
        left: 225px;
        width: 225px;
        margin-left: -225px;
        border: none;
        border-radius: 0;
        border-top: 1px #3c7855 solid;
        overflow-y: auto;
        background-color: #3c7855;
        /* background-color: #5A6B7D; */
        bottom: 0;
        overflow-x: hidden;
        padding-bottom: 40px;
    }

    /* } */

    .side-nav>li>a {
        width: 225px;
        border-bottom: 1px rgba(0, 0, 0, .3) solid;
    }

    .side-nav li a:hover,
    .side-nav li a:focus {
        outline: none;
        background-color: #3c7855 !important;
    }
    }

    .side-nav>li>ul {
        padding: 0;
        border-bottom: 1px rgba(0, 0, 0, .3) solid;
    }

    .side-nav>li>ul>li>a {
        display: block;
        padding: 10px 15px 10px 38px;
        text-decoration: none;
        /*color: #999;*/
        color: #fff;
    }

    .side-nav>li>ul>li>a:hover {
        color: #fff;
    }

    .navbar .nav>li>a>.label {
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        position: absolute;
        top: 14px;
        right: 6px;
        font-size: 10px;
        font-weight: normal;
        min-width: 15px;
        min-height: 15px;
        line-height: 1.0em;
        text-align: center;
        padding: 2px;
    }

    .navbar .nav>li>a:hover>.label {
        top: 10px;
    }

    /* .navbar-brand {
        padding: 5px 15px;
    } */

    .navbar-nav {
        float: left !important;
        margin: 0;
    }



    body {
        font-family: "Poppins", sans-serif;
        /* height: 100vh; */
    }

    a {
        color: white;
        display: inline-block;
        text-decoration: none;
        font-weight: 400;
    }

    h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        margin: 40px 8px 10px 8px;
        color: #cccccc;
    }



    /* STRUCTURE */

    .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
    }

    #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
    }



    /* TABS */

    h2.inactive {
        color: #cccccc;
    }

    h2.active {
        color: #0d0d0d;
        border-bottom: 2px solid #5fbae9;
    }



    /* FORM TYPOGRAPHY*/

    /* input[type=button], */
    input[type=submit],
    input[type=reset] {
        background-color: #38c172;
        border: none;
        color: white;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
        box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        margin: 5px 20px 40px 20px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    input[type=button]:hover,
    input[type=submit]:hover,
    input[type=reset]:hover {
        background-color: #38c172;
    }

    input[type=button]:active,
    input[type=submit]:active,
    input[type=reset]:active {
        -moz-transform: scale(0.95);
        -webkit-transform: scale(0.95);
        -o-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
    }

    input[type=email],
    input[type=password],
    input[type=text] {
        background-color: #f6f6f6;
        border: none;
        color: #0d0d0d;
        /* padding: 15px 32px; */
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 5px;
        width: 85%;
        border: 2px solid #f6f6f6;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
    }

    input[type=email]:focus,
    input[type=password]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
    }

    input[type=email]:placeholder,
    input[type=password]:placeholder {
        color: #cccccc;
    }

    .register {
        background-color: #38c172;
        color: #fff;
        border: none;
        /* border-color: #38c172; */
    }



    /* ANIMATIONS */

    /* Simple CSS3 Fade-in-down Animation */
    .fadeInDown {
        -webkit-animation-name: fadeInDown;
        animation-name: fadeInDown;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    @-webkit-keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }

        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }

        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    /* Simple CSS3 Fade-in Animation */
    @-webkit-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .fadeIn {
        opacity: 0;
        -webkit-animation: fadeIn ease-in 1;
        -moz-animation: fadeIn ease-in 1;
        animation: fadeIn ease-in 1;

        -webkit-animation-fill-mode: forwards;
        -moz-animation-fill-mode: forwards;
        animation-fill-mode: forwards;

        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        animation-duration: 1s;
    }

    .fadeIn.first {
        -webkit-animation-delay: 0.4s;
        -moz-animation-delay: 0.4s;
        animation-delay: 0.4s;
    }

    .fadeIn.second {
        -webkit-animation-delay: 0.6s;
        -moz-animation-delay: 0.6s;
        animation-delay: 0.6s;
    }

    .fadeIn.third {
        -webkit-animation-delay: 0.8s;
        -moz-animation-delay: 0.8s;
        animation-delay: 0.8s;
    }

    .fadeIn.fourth {
        -webkit-animation-delay: 1s;
        -moz-animation-delay: 1s;
        animation-delay: 1s;
    }

    /* Simple CSS3 Fade-in Animation */
    .underlineHover {
        color: #38c172;
    }

    .underlineHover:after {
        display: block;
        left: 0;
        bottom: -10px;
        width: 0;
        height: 2px;
        background-color: #38c172;
        content: "";
        transition: width 0.2s;
    }

    .underlineHover:hover {
        color: #38c172;
    }

    .underlineHover:hover:after {
        width: 100%;
    }



    /* OTHERS */

    *:focus {
        outline: none;
    }

    #icon {
        width: 60%;
    }

    html,
    body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links>a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }

    .navbar {
        position: relative;
        min-height: 50px;
        /* margin-bottom: 20px; */
        border: 1px solid transparent;
    }

    @media (min-width: 768px) {
        .navbar {
            border-radius: 0px !important;
        }
    }

    .topnav,
    #sidebar {
        background-color: #3c7855;
    }


    /*
 * Off Canvas sidebar at medium breakpoint
 * --------------------------------------------------
 */
    @media screen and (max-width: 992px) {

        .row-offcanvas {
            position: relative;
            -webkit-transition: all 0.25s ease-out;
            -moz-transition: all 0.25s ease-out;
            transition: all 0.25s ease-out;

        }

        .row-offcanvas-left .sidebar-offcanvas {
            left: -33%;
        }

        .row-offcanvas-left.active {
            left: 33%;
            margin-left: -6px;
        }

        .sidebar-offcanvas {
            position: absolute;
            top: 0;
            width: 33%;
            height: 100%;
        }
    }

    /*
 * Off Canvas wider at sm breakpoint
 * --------------------------------------------------
 */
    @media screen and (max-width: 34em) {
        .row-offcanvas-left .sidebar-offcanvas {
            left: -45%;

        }

        .row-offcanvas-left.active {
            left: 45%;
            margin-left: -6px;
        }

        .sidebar-offcanvas {
            width: 45%;
        }
    }

    .card {
        overflow: hidden;
    }

    .card-body .rotate {
        z-index: 8;
        float: right;
        height: 100%;
    }

    .card-body .rotate i {
        color: rgba(20, 20, 20, 0.15);
        position: absolute;
        left: 0;
        left: auto;
        right: -10px;
        bottom: 0;
        display: block;
        -webkit-transform: rotate(-44deg);
        -moz-transform: rotate(-44deg);
        -o-transform: rotate(-44deg);
        -ms-transform: rotate(-44deg);
        transform: rotate(-44deg);
    }

    #serviceDropdown:hover {
        color: black;

    }

    .cd-side-nav {
        position: absolute;
        z-index: var(--zindex-header);
        left: 0;
        top: var(--cd-header-height);
        width: var(--cd-sidebar-width);
        transition: .2s;
        visibility: hidden;
        opacity: 0;
    }

    .cd-side-nav--is-visible {
        opacity: 1;
        visibility: visible;
    }

    .sidenav .nav-link {
        color: #ffffffba;
        white-space: nowrap;
        transition: .3s;
    }

    .sidenav .nav-link:hover {
        background-color: #a7a7a766;
        color: #fff;
    }

    .modal-notify .modal-header {
        border-radius: 3px 3px 0 0;
    }

    .modal-notify .modal-content {
        border-radius: 3px;
    }

    .announce {
        color: red !important;
    }

    .announcement {
        height: 100%;
        position: relative;
    }

    .announceback {
        height: 100%;
        width: 100%;
        /* position: absolute;
        background: #21252991;
        z-index: 100; */
    }

    .noticepic {
        height: calc(100% - 150px);
    }

    .announcer {
        color: white;
    }

    .sidediv {
        position: absolute;
        background: #1b1e219c;
        width: 100%;
        height: 100%;
        top: 0;
        right: 0;
        z-index: 2;
        display:none;
    }
    #main, .topnav{
        position: relative;
    }
    .topnav{
        z-index: 1;
    }
    </style>


</head>

<body>
    <div class="mainparent">

        <div class="main">
            @yield('content')
        </div>
        <div class="sidediv">
        @yield('announcecontent')
        </div>

    </div>
    @yield('jscript')
    @stack('jscript')
</body>


</html>