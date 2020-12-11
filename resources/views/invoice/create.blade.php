@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('invoice.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New Invoice') }}</legend>


            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="invoice_no">Invoice No</label>
                        <input type="text" class="form-control" id="invoice_no" name="invoice_no" readonly
                            value="{{ $order->order_id }}">
                            <input type="hidden" class="form-control" id="order_no" name="order_no" 
                            value="{{ $order->id }}">
                    </div>

                    <div class="col">
                        <label for="customername">Customer Name</label>
                        <input type="text" class="form-control" id="customername" name="customername" readonly
                            value="{{ $order->customername }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="invoicedate">Order Date</label>
                        <input type="text" class="form-control" id="invoicedate" name="invoicedate" readonly
                            value="{{ $order->created_at }}">


                    </div>

                    <div class="col">
                        <label for="due_date">Delivery Date</label>
                        <input type="text" class="form-control" id="due_date" name="due_date" readonly
                            value="{{ $order->due_date }}">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col">
                        <label for="customer_address">Customer Address</label><br>
                        <input type="text" class="form-control" id="customer_address" name="customer_address" readonly
                            value="{{ $order->customer_address }}">
                    </div>


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
                                    <th scope="col">Extra Service</th>
                                    <th scope="col">Price</th>
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
                                    <td>
                                        @if ($cartkey['service_charge'] > 0)

                                        {{ $cartkey['service_charge'] }} TK/-
                                        @else
                                        0 TK/-
                                        @endif
                                    </td>
                                    <td>{{$cartkey['price']}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <?php $total = 0; ?>
                        @foreach($orderitems as $cartkey )
                        <?php $total += $cartkey->quantity; ?>
                        @endforeach
                        <input type="hidden" class="form-control" id="qty" name="qty" value="{{ $total }}">
                        <div class="col">
                            <label for="discount">Discount</label>
                            <input type="discount" class="form-control" id="discount" name="discount" readonly
                                value="{{ $order->discountvalue }}">
                        </div>

                        <div class="col">
                            <label for="tax">Tax</label>
                            <input type="text" class="form-control" id="ordertax" name="tax" readonly
                                value="{{ $order->tax }}">
                        </div>
                        <div class="col">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" readonly
                                value="{{ $order->total }}">
                        </div>

                        <div class="col">
                            <label for="subtotal">Subtotal</label>
                            <input type="text" class="form-control" id="subtotal" name="subtotal" readonly
                                value="{{ $order->subtotal }}">
                        </div>

                        <div class="col">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" name="total" readonly
                                value="{{ $order->total }}">
                        </div>
                    </div>
                </div>
                <div class="form-group" style="display:none;">
                    <div class="row">
                        <div class="col">
                            <label for="amount_due">Amount Due</label>
                            <input type="hidden" class="form-control" id="amount_due" readonly name="amount_due"
                                value="{{ $order->total }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
    </form>

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
    $("#invoicedate").val(d + "/" + m + "/" + y);


});
</script>
@endsection