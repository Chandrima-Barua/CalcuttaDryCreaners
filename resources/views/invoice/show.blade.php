@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form>
        @csrf
        <fieldset>
            <legend>{{ __('Edit Invoice') }}</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="invoice_no">Invoice No</label>
                        <input type="text" class="form-control" id="invoice_no" name="invoice_no" readonly
                            value="{{ $invoice->invoice_no }}">
                    </div>
                    <!-- </div>
                                    <div class="row"> -->
                    <div class="col">
                        <label for="customername">Customer Name</label>
                        <input type="text" class="form-control" id="customername" name="customername" readonly
                            value="{{ $invoice->customername }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="customer_address">Customer Address</label>
                        <input type="text" class="form-control" id="customer_address" name="customer_address" readonly
                            value="{{ $invoice->customer_address }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="qty">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty" readonly
                            value="{{ $invoice->qty }}">
                    </div>
                    <!-- </div>
                                    <div class="row"> -->
                    <div class="col">
                        <label for="rate">Rate</label>
                        <input type="text" class="form-control" id="rate" name="rate" readonly
                            value="{{ $invoice->rate }}">
                    </div>
                    <!-- </div>
                                    <div class="row"> -->
                    <div class="col">
                        <label for="tax">Tax</label>
                        <input type="text" class="form-control" id="tax" name="tax" readonly
                            value="{{ $invoice->tax }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" readonly
                            value="{{ $invoice->amount }}">
                    </div>
                    <!-- </div>
                                    <div class="row"> -->
                    <div class="col">
                        <label for="subtotal">Subtotal</label>
                        <input type="text" class="form-control" id="subtotal" name="subtotal" readonly
                            value="{{ $invoice->subtotal }}">
                    </div>
                    <!-- </div>
                                    <div class="row"> -->
                    <div class="col">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="total" name="total" readonly
                            value="{{ $invoice->total }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="amount_due">Amount Due</label>
                        <input type="text" class="form-control" id="amount_due" name="amount_due" readonly
                            value="{{ $invoice->amount_due }}">
                    </div>

                    <!-- <div class="row"> -->
                    <div class="col">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" readonly
                            value="{{ $invoice->due_date }}">
                    </div>
                    <!-- </div> -->
                    <!-- </div>
            </div> -->
                    <div class="col">
                        <div class="form-group">
                            <label for="services">Services</label>

                            <select class="custom-select" multiple="services" name="services[]" id="services">
                                @foreach($services as $service)

                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="items">Item</label>

                            <select class="custom-select" multiple="items" name="items[]" id="items">
                                @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a class="btn btn-primary" href="{{ route('invoice.index') }}">Go back</a>
                </div>
    </form>

</div>
@endsection