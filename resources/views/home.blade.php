@extends('layouts.auth')
@section('announcecontent')

@php
@endphp
@if(count($notifications) > 1)
@php

function cvf_convert_object_to_array($data) {

if (is_object($data)) {
$data = get_object_vars($data);
}

if (is_array($data)) {
return array_map(__FUNCTION__, $data);
}
else {
return $data;
}
}
$notice_data = cvf_convert_object_to_array(json_decode($notifications['data']));
@endphp
<div class="announcement" id="orangeModalSubscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning document" role="document" style="height:100%">
        @php
        $creator_name = \App\User::where(['id' => $notice_data['user_id']])->first();
        @endphp
        <span class="announcer">Announced By - {{$creator_name->firstname}}</span>
        <button type="button" class="close announceclose" data-dismiss="modal" aria-label="Close"
            id="{{$notice_data['notice_id']}}">
            <span aria-hidden="true" class="white-text">&times;</span>
        </button>
        <img src="{{ asset('noticefile/'.$notice_data['file_name']) }}" width="100%" class=" my-3  noticepic"
            id="noticepic" />

    </div>
</div>

@endif
@endsection
@section('navcontent')
<div class="col main mt-3">

    <h1 class="display-4 d-none d-sm-block">
        Dashboard
    </h1>
    <input type="hidden" value="{{Auth::user()->id}}" id="authuser">
    <div id="myModal" class="modal notimodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title notititle">Modal title</h5>
                    <button type="button" class="close noticlose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="notibody">Modal body text goes here.</p>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    @foreach (Auth::user()->roles as $role )
    @if ($role['slug'] == 'ceo')
    <div class="row mb-3">
        <div class="col-xl-3 col-sm-6 py-2">
            <div class="card bg-success text-white h-100">
                <div class="card-body bg-success">
                    <div class="rotate">
                        <i class="fa fa-user fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Today's Ordered Items</h6>
                    <h1 class="display-4">{{count($orderitems)}}</h1>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 py-2">
            <div class="card bg-success text-white h-100">
                <div class="card-body bg-success">
                    <div class="rotate">
                        <i class="fa fa-user fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Deliver by branch</h6>
                    <h1 class="display-4"> {{count($branchorder)}}</h1>

                </div>
            </div>
        </div>
        @endif
        @endforeach
        <div class="col-xl-3 col-sm-6 py-2">
            <div class="card text-white bg-danger h-100">
                <div class="card-body bg-danger">
                    <div class="rotate">
                        <i class="fa fa-list fa-4x"></i></a>
                    </div>
                    <h6 class="text-uppercase">Services</h6>
                    <h1 class="display-4">{{count($services)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 py-2">
            <div class="card text-white bg-info h-100">
                <div class="card-body bg-info">
                    <div class="rotate">
                        <i class="fa fa-twitter fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Items</h6>
                    <h1 class="display-4">{{count($items)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 py-2">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <div class="rotate">
                        <i class="fa fa-share fa-4x"></i>
                    </div>
                    <h6 class="text-uppercase">Branch</h6>
                    <h1 class="display-4">{{count($branches)}}</h1>
                </div>
            </div>
        </div>
    </div>
    @foreach (Auth::user()->roles as $role )
    @if ( ($role['slug'] == 'ceo')
    || ($role['slug'] == 'accountant')
    || ($role['slug'] == 'accounts-departments'))
    <div class="table-responsive">
        <h6 class="text-uppercase">Today's Ordered Items</h6>
        @include('includes.messages')
        @if(count($orderitems) > 0)
        <table class="table table-hover table-responsive table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Barcode</th>
                    <th>Total Piece(s)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                            $i = 1;
                        ?>
                @foreach($orderitems as $orderitem)
                <tr>
                    <td id="{{ $orderitem->id }}">{{ $i++ }}</td>
                    <td>{{ $orderitem->name }}</td>
                    <td>{{ $orderitem->code }}</td>
                    <td>{{ $orderitem->quantity }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-center">No items found!</p>
        @endif
    </div>
    <br><br>
    <div class="table-responsive">
        <h6 class="text-uppercase">Branch Deliverd Orders</h6>
        @include('includes.messages')
        @if(count($branchorder) > 0)
        <table class="table table-hover table-responsive table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch Name</th>
                    <th>Total Orders</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                            $i = 1;
                        ?>
                @foreach($branchorder as $order)
                <tr>
                    <td id="{{ $order->id }}">{{ $i++ }}</td>
                    <td>{{ $order->branch }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        <label class="badge badge-success">

                            {{ $order->status }}&nbsp;

                        </label>&nbsp;
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-center">No items found!</p>
        @endif
    </div>
</div>
@endif
@endforeach
@endsection

@section('jscript')

<script type="text/javascript">
$(document).ready(function() {

    $('.document').css('pointer-events', 'auto');
    console.log($('.announcement').children().length )
    if ($('.announceback').children().length ==  0) {
        $('.announceback').css('display', 'none');
        // $('.sidediv').css('display', 'none');

    }
    $(document).on('click', '.announceclose', function(e) {
        notice_id = $(this).attr('id');
        console.log(notice_id)
      $('.sidediv').css('display', 'none');

        $('.announceback').css('display', 'none')
        $(".announcement").css('display', 'none');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/markAsRead',
            type: "get",

            success: function(response) {},
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/notices/notice_read',
            method: 'post',
            data: {
                notice_id: notice_id,
                read: 1
            },

            success: function(response) {},
        });
    });
});
</script>

@endsection