<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calcutta dry Cleaners</title>

    <style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }

    table {
        font-size: 2mm;

    }

    thead tr {
        color: black;
        text-align: center;
    }

    tfoot tr {

        font-weight: bold;
        font-size: 2mm;
    }

    .gray {
        background-color: lightgray
    }


    .maintable tr {
        border-top: 1px solid black;
    }

    .maintable thead {
        border-bottom: 1px solid #000;
    }

    .maintable tbody {
        border-bottom: 1px solid #000;
    }

    .maintable td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        /* padding: 8px; */
    }

    .maintable tr:nth-child(even) {
        background-color: #dddddd;
    }

    .taglabel {
        visibility: hidden;
    }

    td {
        vertical-align: top;
    }

    @media print {

        table.print-friendly tr td,
        table.print-friendly tr th {
            page-break-inside: avoid;
            
        }

        html, body{
            
            width: 114.3mm;
            height: 152.4mm;
        }

    }
    </style>

</head>

<body>

    <table style="table-layout: fixed; width: 100%">
        <tr>

            <td align="right">
                <span class="template"
                    style="position: fixed; top: 1mm; right:15mm; font-size:4mm;">{{$branch->name}}</span>
                <span style="position: fixed; top: 5mm; right:1mm; font-size:2mm;">{{$branch->address}}</span>
            </td>
        </tr>
        <tr>
            @foreach ($invoices as $invoice)
            <td>
                <span class="taglabel">Serial No: </span><span class="template"
                    style="position: fixed; top: 9mm; left:11mm; font-size:2mm;">{{ $invoice->invoice_no }} </span><br>
                <span class="taglabel">Customer name: </span><span class="template"
                    style="position: fixed; top: 12mm; left:17mm; font-size:2mm;">{{ $invoice->customername }}
                </span><br>
                <span class="taglabel">Customer Address: </span><span class="template"
                    style="position: fixed; top: 15mm; left:20mm; font-size:2mm;">{{ $invoice->customer_address }}</span>

            </td>
            @endforeach
            <td align="right">
                <span class="taglabel">Order No: </span><span class="template"
                style="position: fixed; top: 9mm; right:1mm; font-size:2mm;">{{$order->id}} </span><br>
                <span class="taglabel">Mobile No: </span><span class="template"
                style="position: fixed; top: 12mm; right:1mm; font-size:2mm;">{{$order->phone_number}} </span><br>
                <span class="taglabel">Receiving date: </span><span class="template"
                style="position: fixed; top: 15mm; right:1mm; font-size:2mm;">{{ date('d/m/Y', strtotime($order->created_at))}}
                </span><br>
                <span class="taglabel">Delivery Date: </span><span class="template"
                style="position: fixed; top: 18mm; right:1mm; font-size:2mm;">{{ date('d/m/Y', strtotime($order->due_date))}}
                </span>
            </td>
        </tr>
    </table>

    <table class="maintable" style="width:100%; position: fixed; top: 26mm; left:1mm; font-size:2mm;">

        <tbody>
            <?php
             $j = 1;
            ?>
            @foreach($orderitems as $cartkey)

            <tr>
                <td align="center" id="{{$cartkey['id']}}" class="geeks">{{ $j++ }}</td>
                <td align="center">{{$cartkey['item_name']}}</td>
                <td align="center">{{$cartkey['status']}}</td>
                <td align="center">
                    @php

                    $search = ",";

                    $result = array();
                    $tmp = explode(",", $cartkey['service_id']);
                    $prefix = $fruitList = '';
                    for ($i = 0; $i < count($tmp) ; $i++) { $servicename=App\Service::where('id', $tmp[$i])->
                        first();

                        echo $prefix .$servicename['name'] ;
                        $prefix = ', ';
                        }

                        @endphp
                </td>
                <td align="center">{{$cartkey['quantity']}}</td>


                <td align="center">

                    {{$cartkey['price']}} /- BDT</td>

                <td align="center">
                    @if ($cartkey['service_charge'] > 0)

                    {{ $cartkey['service_charge'] }} BDT/-
                    @else
                    0 TK/-
                    @endif
                </td>
                <td align="center">{{ number_format($cartkey['price'] + $cartkey['service_charge'] ) }} /- BDT
                </td>
            </tr>
            @endforeach


        </tbody>

        @foreach($invoices as $invoice)

        <tfoot>

            <tr>
                <td colspan="6"></td>
                <td align="right">Subtotal </td>
                <td align="right" class="tdgreen"><span class="template">{{ $invoice->subtotal }} /- BDT</span></td>
            </tr>

            <tr>
                <td colspan="6"></td>
                <td align="right">Discount </td>
                <td align="right" class="tdgreen"><span class="template">{{ $invoice->discount }}</span></td>
            </tr>

            <tr>
                <td colspan="6"></td>
                <td align="right">Tax </td>
                <td align="right" class="tdgreen"><span class="template">{{$invoice->tax}}</span></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td align="right">Total </td>
                <td align="right" class="tdgreen"><span class="template">{{$invoice->total}} /- BDT</span></td>
            </tr>
        </tfoot>
        @endforeach
    </table>
    <!-- <div align="right" style="word-wrap: break-word">
        <span >{{$branch->name}} Branch</span><br>
        <span >{{$branch->address}}</span>
    </div> -->

</body>

</html>