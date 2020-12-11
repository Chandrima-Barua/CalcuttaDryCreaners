@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="card shadow">
            <div class="card-header text-center"><strong>Orders</strong></div>

            <div class="card-body">
                @include('includes.messages')
                @if(count($orders) > 0)
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Customer Address</th>
                            <th>Quantity</th>
                            <th>Tax</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Order Date</th>
                            <th>Deliver Date</th>
                            <th>Status </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                        ?>
                        @foreach($orders as $order)
                        <tr>
                            <td id="{{ $order->id }}">{{ $i++ }}</td>
                            <td>{{ $order->customername }}</td>
                            <td>{{ $order->customer_address }}</td>
                            <td>{{ $order->qty }}</td>
                            <td>{{ $order->tax }}</td>
                            <td>{{ $order->subtotal }}/- BDT</td>
                            <td>{{ $order->total }}/- BDT</td>
                            <td>{{ date('d/m/Y', strtotime($order->created_at))}}</td>

                            <td>{{ date('d/m/Y', strtotime($order->due_date))}}</td>
                            <td>
                                <label for="orderstatus">Select Status</label>

                                <select class="orderstatus" name="orderstatus" id="{{$order->id}}" name="id"
                                    notiid="{{$order->user_id}}">

                                    @foreach($orderstatus as $status)

                                    <option value="{{ $status->id }}"
                                        {{ $order->orderstatus_id == $status->id  ? 'selected' : ''}}>
                                        {{ $status->title}}</option>

                                    @endforeach
                                </select>


                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-around">
                                    <a href="{{ route('orders.show', $order->id) }}"><i
                                            class="fas text-primary fa-eye"></i></a>&nbsp;&nbsp;

                                    <a href="{{ route('orders.edit', $order->id) }}"><i
                                            class="fas text-warning fa-edit"></i></a>&nbsp;&nbsp;
                                    <a href="{{ route('orders.destroy', $order->id) }}"><i
                                            class="fas text-danger fa-trash"></i></a>&nbsp;&nbsp;
                                    <a href="{{ route('orders.invoice.create', $order->id) }}"
                                        class="iconinvoice">Invoice</a>&nbsp;

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No orders found!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
<style>
.iconinvoice {
    color: #3c7855;
    display: inline-block;
    text-decoration: none;
    font-weight: 400;
}
</style>
@section('jscript')
<!-- <script> -->

<script type="text/javascript">
$(document).ready(function() {

    $(document).on('change', '.orderstatus', function(e) {

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
        const messaging = firebase.messaging();
       
        orderid = $(this).attr('id')
        orderstatusid = $(this).val();
        user_id = $(this).attr('notiid');
        // console.log(user_id)

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'orders/orderstatus/' + orderid,
            type: "POST",
            data: {
                orderstatusid: orderstatusid
            },
            success: function(response) {
                console.log(response);
            },
            complete: function() {
                $.ajax({
                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    data: {
                        user_id: user_id,
                        orderid : orderid,
                        orderstatusid : orderstatusid,

                    },
                    url: 'orders/orderstatusPush',
                    success: function(response) {
                        console.log(response);
                      
                    }
                });
            }

        });


    });
});
</script>
@endsection