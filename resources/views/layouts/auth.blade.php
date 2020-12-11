@extends('layouts.app')
@section('content')
<nav class="navbar navbar-expand-md topnav">
    <input type="hidden" value="{{Auth::user()->id}}" id="navuser">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand" href="{{ url('/home') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
    <!-- <div> -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if (Auth::check())
                {{ Auth::user()->firstname }}
                @else
                User
                @endif
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fa fa-fw fa-user"></i>Edit
                    Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                        class="fa fa-fw fa-power-off"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        <li>
            <div class="notifications">
                <i class="fa fa-bell"></i>
                <span class="num">{{ auth()->user()->unreadNotifications->count() }}</span>
                <ul class="ulnoti">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                    <li class="icon">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        @if ($notification->type == 'App\Notifications\LegalExpire')
                        <span class="text notifi"><b> {{ $notification->data['days_left'] }} </b> day(s) left for your
                            legal
                            documents
                        </span>
                        @elseif($notification->type == 'App\Notifications\MyNotification')
                        <span class="text notifi"><b> {{ $notification->data['role'] }} </b> has changed the status of
                            Order
                            No. <b> {{$notification->data['order_id']}} </b> to
                            <b>{{$notification->data['orderstatus']}}</b></span>
                        @else
                        <span class="text">
                            <a class="announce" href="{{ route('home') }}" id="serviceDropdown">
                                There is an announcement!
                            </a>
                            @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
    </ul>
</nav>
<div class="container-fluid" id="main">
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="collapse in show topnav pl-0 " id="navbarContent" role="navigation">
            <ul class="nav flex-column sticky-top pl-0 mt-3 ">
                @php
                $rolearray = [];
                $tmp = Auth::user()->roles->toArray();
                @endphp

                <li class="nav-item ">
                    <a href="{{ route('home') }}" id="serviceDropdown"> &nbsp;<i class="fas fa-home"></i>&nbsp; Home
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-industry"></i>
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('services.index') }}">All Services</a>
                        <a class="dropdown-item" href="{{ route('services.create') }}">Add Service</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tasks"></i>
                        Item Type
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('itemtype.index') }}">All ItemTypes</a>
                        <a class="dropdown-item" href="{{ route('itemtype.create') }}">Add ItemType</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tasks"></i>
                        Items
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('items.index') }}">All Items</a>
                        <a class="dropdown-item" href="{{ route('items.create') }}">Add Item</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i>
                        Order Status
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('orderstatus.index') }}">All Ordertatus</a>
                        <a class="dropdown-item" href="{{ route('orderstatus.create') }}">Add Ordertatus</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i>
                        Orders
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('orders.index') }}">All Orders</a>
                        <a class="dropdown-item" href="{{ route('orders.create') }}">Add B2C Order</a>
                        <a class="dropdown-item" href="{{ route('corporateCreate') }}">Add B2B Order</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route('invoice.index') }}" id="serviceDropdown"><i
                            class="fa fa-book"></i>
                        Invoice
                    </a>
                </li>

                @foreach ( Auth::user()->roles as $role )
                @if ( ($role['slug'] = 'ceo') )
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route('users.index') }}" id="serviceDropdown"><i
                            class="fa fa-users"></i>
                        Manage Users
                    </a>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route('attendance') }}" id="serviceDropdown"><i class="fa fa-book"></i>
                        Attendances
                    </a>

                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i>
                        Manage Roles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('roles.index') }}">All Roles</a>
                        <a class="dropdown-item" href="{{ route('roles.create') }}">Add Role</a>
                    </div>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="fa fa-fw fa-cog"></i>
                        Manage Branch
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('branch.index') }}">All Branches</a>
                        <a class="dropdown-item" href="{{ route('branch.create') }}">Add Branch</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-money"></i>
                        Expense Management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('expense_categories.index') }}"><i
                                class="fa fa-list"></i>&nbsp;<span>Expense Categories</span></a>
                        <a class="dropdown-item" href="{{ route('expense.index') }}"><i
                                class="fa fa-arrow-circle-left"></i>&nbsp;<span>Staff Expenses</span></a>
                        <a class="dropdown-item" href="{{ route('staffexpense.report') }}"><i
                                class="fa fa-line-chart"></i>&nbsp;<span>Staff Expense Report</span></a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-money"></i>
                        Legal
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('legal_categories.create') }}"><i
                                class="fa fa-list"></i>&nbsp;<span>Add Categories</span></a>
                        <a class="dropdown-item" href="{{ route('legal_categories.index') }}"><i
                                class="fa fa-line-chart"></i>&nbsp;<span>All Categories</span></a>
                        <a class="dropdown-item" href="{{ route('legal_documents.create') }}"><i
                                class="fa fa-arrow-circle-left"></i>&nbsp;<span>Create Documents</span></a>
                        <a class="dropdown-item" href="{{ route('legal_documents.index') }}"><i
                                class="fa fa-line-chart"></i>&nbsp;<span>All Douments</span></a>
                    </div>
                </li>
                @if ( ($role['slug'] = 'ceo') || ($role['slug'] = 'accountsdepaaccounts-departmentsrtments'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i>
                        Notice
                    </a>
                    <div class="dropdown-menu" aria-labelledby="serviceDropdown">
                        <a class="dropdown-item" href="{{ route('notice.create') }}"><i
                                class="far fa-file-alt"></i>&nbsp;<span>Create Notice</span></a>
                        <a class="dropdown-item" href="{{ route('notice.index') }}"><i
                                class="fa fa-bars"></i>&nbsp;<span>All Notice</span></a>

                    </div>
                </li>
                @endif
                @endif
                @endforeach
            </ul>
        </div>

        <div class="col main mt-3">
            @yield('navcontent')
        </div>

    </div>

    @endsection
    @push('jscript')

    <script type="text/javascript">
    $(document).ready(function() {
        $('.document').css('pointer-events', 'auto');

        if ($('.announcement').children().length > 0) {
            $('.sidediv').css('display', 'block')
            $('body').css('overflow', 'hidden');
        }
        $(".notifications").on({
            mouseenter: function() {
                $(".ulnoti").css('display', 'block');
            },

        });
        $(".ulnoti").on({
            mouseleave: function() {
                $(".ulnoti").css('display', 'none');
            }

        });
        $(".ulnoti li").on('click', '.notifi', function(e) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/markAsRead',
                type: "get",

                success: function(response) {},
            });
        });

        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyBpFxSa4BJKOaexvHM8I-VuU5DhlrzfhYo",
            authDomain: "cdcleaners-669c5.firebaseapp.com",
            databaseURL: "https://cdcleaners-669c5.firebaseio.com",
            projectId: "cdcleaners-669c5",
            storageBucket: "cdcleaners-669c5.appspot.com",
            messagingSenderId: "679581830144",
            appId: "1:679581830144:web:a6c9d316af46a51605dce5",
            measurementId: "G-1XSDHJ822T"
        };
        // Initialize Firebase
        if (!firebase.apps.length) {
            firebase.initializeApp(firebaseConfig);
        }
        messaging = firebase.messaging.isSupported() ? firebase.messaging() : null
        // messaging = firebase.messaging();
        messaging.requestPermission()
            .then(function() {
                console.log('Notification permission granted.');
                return messaging.getToken();

            })
            .then(function(token) {
                console.log(token); // Display user token
                // if (isTokenSentToServer()) {
                //     console.log('Token already saved');
                // } else {
                getRegToken(token);
                // }
            })
            .catch(function(err) { // Happen if user deney permission
                console.log('Unable to get permission to notify.', err);
            });


        function getRegToken(argument) {
            console.log(argument);
            messaging.getToken()
                .then(function(token) {
                    if (token) {
                        saveToken(token);
                        console.log(token);
                        setTokenSentToServer(true);
                    } else {
                        console.log(
                            'No Instance ID token available. Request permission to generate one.');
                        setTokenSentToServer(false);
                    }
                })
                .catch(function(err) {
                    console.log('An error occurred while retrieving token. ', err);
                    setTokenSentToServer(false);
                });
        }
        messaging.onMessage(function(payload) {
            console.log('onMessage', payload);
            // $(".notifications").css('position', 'relative');
            // $(".notititle").text(payload['notification']['title']);
            // $(".notibody").text(payload['notification']['body']);
            // $(".notif-count").text($(".notifications").children().length);
            // var newCount = $(".notifications").children().length;
            // $(".count").attr('data-count', newCount);
        })

        mesaging.setBackgroundMessageHandler(function(payload) {
            console.log(payload)
            return self.registration.showNotification(title, options)
        });

        function setTokenSentToServer(sent) {
            window.localStorage.setItem('sentToServer', sent ? 1 : 0);
        }

        function isTokenSentToServer() {
            return window.localStorage.getItem('sentToServer') == 1;
            console.log(window.localStorage.getItem('sentToServer'))
        }

        function saveToken(token) {

            user_id = $("#navuser").val();
            $.ajax({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'save-device-token',
                method: 'post',
                data: {
                    user_id: user_id,
                    token: token
                },
            }).done(function(result) {
                console.log(result);
            })
        }

    });
    </script>

    @endpush