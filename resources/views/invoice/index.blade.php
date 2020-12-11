@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="card shadow">
            <div class="card-header text-center"><strong>Invoices</strong></div>
            
            <div class="card-body">
                @include('includes.messages')
                @if(count($invoices) > 0)
                <p>
                <a href="{{ route('invoice.template') }}" class="btn" style="background-color: green">Template</a>


            </p>
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Customer Address</th>
                            <th>Qty</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Amount</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Amount Due</th>
                            <th>Deliver Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                        ?>
                        @foreach($invoices as $invoice)
                        
                        <tr>
                            <td id="{{ $invoice->order_id }}">{{ $i++}}</td>
                            <td id="{{ $invoice->invoice_no }}">{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->customername }}</td>
                            <td>{{ $invoice->customer_address }}</td>
                            <td>{{ $invoice->qty }}</td>
                            <td>{{ $invoice->discount }}</td>
                            <td>{{ $invoice->tax }}</td>
                            <td>{{ $invoice->amount }}/- BDT</td>
                            <td>{{ $invoice->subtotal }}/- BDT</td>
                            <td>{{ $invoice->total }}/- BDT</td>

                            <td>{{ $invoice->amount_due }}/- BDT</td>

                            <td>{{ date('d/m/Y', strtotime($invoice->due_date))}}</td>


                            <td>
                                <div class="d-flex align-invoices-center justify-content-around">

                                    <a href="{{ route('invoice.destroy', $invoice->id) }}"><i
                                            class="fas text-danger fa-trash"></i></a>&nbsp;&nbsp;
                                    <a href="{{ route('invoice.pdf', $invoice->order_no, ['download'=>'pdf']) }}"
                                        class="iconpdf"></i>Pdf</a>&nbsp;&nbsp;
                                        <a href="{{ route('invoice.pdfdata', $invoice->order_no, ['download'=>'pdf']) }}"
                                        class="iconpdf"></i>Pdf Data</a>&nbsp;&nbsp;
                                    <a href="{{ route('invoice.csv') }}" class="iconcsv">CSV</a>&nbsp;

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No invoice found!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
<style>
.iconpdf,
.iconcsv {
    color: #3c7855;
    display: inline-block;
    text-decoration: none;
    font-weight: 400;
}
</style>