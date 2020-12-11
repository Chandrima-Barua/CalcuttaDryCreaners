@extends('layouts.auth')
@section('navcontent')
<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="card shadow">
            <div class="card-header text-center"><strong>Order Details</strong></div>

            <div class="card-body">
                @include('includes.messages')
                <form>
                    <div class="form-group orders">
                        <div class="row">
                            <div class="col">
                                <label for="customername">Customer Name</label>
                                <input type="text" class="form-control" id="customername" name="customername" readonly
                                    value="{{ $order->customername }}">
                            </div>

                            <div class="col">
                                <label for="customer_address">Customer Address</label>
                                <input type="text" class="form-control" id="customer_address" readonly
                                    name="customer_address" readonly value="{{ $order->customer_address }}">
                            </div>

                            <div class="col">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" readonly name="phone_number"
                                    readonly value="{{ $order->phone_number }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="orderdate">Order Date</label>
                                <input type="text" class="form-control" id="orderdate" name="orderdate" readonly
                                    value="{{ $order->created_at }}">
                            </div>

                            <div class="col">
                                <label for="due_date">Delivery Date</label>
                                <input type="text" class="form-control" id="due_date" name="due_date" readonly
                                    value="{{ date('d/m/Y', strtotime($order->due_date))}}">
                            </div>
                        </div>
                    
                    <div class="row">
                        <div class="col">
                            <label for="branchaddress">Branch</label><br>
                            <input type="text" class="form-control" id="branch" name="branch" readonly
                                value="{{$branch->name}}">
                        </div>
                        <div class="col">
                            <label for="branchaddress">Branch Address</label>
                            <input type="text" class="form-control" id="branchaddress" name="branchaddress" readonly
                                value="{{$branch->address}}">
                        </div>
                    </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="customer_address">Order Details</label>
                    <table class="table table-responsive">
                        <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Service Type</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Status</th>
                                <th scope="col">Packaging</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Delivery Time</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Extra Service</th>
                                <th scope="col">Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                            $j = 1;
                                         ?>
                            @foreach($orderitems as $cartkey)

                            <tr>
                                <th scope="row" id="{{$cartkey['id']}}">{{ $j++ }}</th>

                                <td>{{$cartkey['item_name']}}</td>



                                <td>

                                    @php

                                    $search = ",";

                                    $result = array();
                                    $tmp = explode(",", $cartkey['service_id']);
                                    $prefix = $fruitList = '';
                                    for ($i = 0; $i < count($tmp) ; $i++) { $servicename=App\Service::where('id',
                                        $tmp[$i])->
                                        first();

                                        echo $prefix .$servicename['name'] ;
                                        $prefix = ', ';
                                        }

                                        @endphp

                                </td>

                                <td>{{$cartkey['quantity']}}</td>
                                <td>{{$cartkey['status']}}</td>
                                <td>{{$cartkey['packaging']}}</td>
                                <td>

                                    @if ( $cartkey['urgent'] == 1)

                                    Urgent
                                    @elseif ($cartkey['regular'] == 1)
                                    Regular
                                    @endif
                                </td>
                                <td>

                                    @if ( $cartkey['urgent'] == 1)

                                    {{$cartkey['urgenttime']}} Day(s)
                                    @elseif ($cartkey['regular'] == 1)
                                    {{$cartkey['regulartime']}} Day(s)
                                    @endif
                                </td>
                                <td>{{$cartkey['price']}}</td>
                                <td>
                                    @if ($cartkey['service_charge'] > 0)

                                    {{ $cartkey['service_charge'] }} TK/-
                                    @else
                                    0 TK/-
                                    @endif
                                </td>
                                <td align="center">
                                    {{ number_format($cartkey['price'] + $cartkey['service_charge'] ) }} /-
                                    BDT</td>
                            </tr>



                            @endforeach

                        </tbody>
                    </table>


                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="qty">Quantity</label><br>
                        <input type="text" class="form-control qty" id="qty" name="qty" readonly readonly
                            value="{{ $order->qty }}">
                        <input type="hidden" class="form-control" id="unitqty" name="unitqty" value="0.00">

                    </div>

                    <div class="col">
                        <label for="discountvalue">Discount</label>
                        <input type="discountvalue" class="form-control" id="discountvalue" name="discountvalue"
                            readonly readonly value="{{ $order->discountvalue }}">

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="tax">Tax</label><br>
                        <input type="text" class="form-control" id="ordertax" name="tax" readonly
                            value="{{ $order->tax }}">
                    </div>
                    <div class="col">
                        <label for="subtotal">Subtotal</label>
                        <input type="text" class="form-control" id="ordersubtotal" name="subtotal" readonly
                            value="{{ $order->subtotal }}/- BDT">
                    </div>

                    <div class="col">
                        <label for="total">Total</label><br>
                        <input type="text" class="form-control" id="ordertotal" name="total" readonly
                            value="{{ $order->total }}/- BDT">
                    </div>

                </div>
            </div>



            <div class="form-group">
                <a class="btn btn-primary" href="{{ route('orders.index') }}">Go back</a>
            </div>





            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('jscript')
<!-- <script> -->

<script type="text/javascript">
$(document).ready(function() {
    n = new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    $("#orderdate").val(d + "/" + m + "/" + y);


});
</script>
@endsection