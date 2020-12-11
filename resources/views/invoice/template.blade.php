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
        /* text-align: center; */
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


    .template {
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
/* 
    @page {
        size: 114.3mm 152.4mm;

    } */
    </style>

</head>

<body>
    <?php
$data = '';
?>
    <table style="table-layout: fixed; width: 100%">
        <tr>
            <!-- <td class="title" style="word-wrap: break-word"> -->
            <td class="title">
                <span style="position: fixed; top: 1mm; left:1mm; font-size:4mm;">Calcutta dry Cleaners</span>
            </td>

            <!-- <td align="right" style="word-wrap: break-word;vertical-align:top"> -->
            <td align="right">
                <span style="position: fixed; top: 1mm; left:90mm; font-size:4mm;"> Branch</span></span><br>

            </td>
        </tr>
        <tr>

            <!-- <td style="word-wrap: break-word"> -->
            <td>
                <span style="position: fixed; top: 9mm; left:1mm; font-size:2mm;">Serial No: </span><span
                    class="template">{{ $data }} </span><br>
                <span style="position: fixed; top: 12mm; left:1mm; font-size:2mm;">Customer name: </span><span
                    class="template">{{ $data}} </span><br>
                <span style="position: fixed; top: 15mm; left:1mm; font-size:2mm;">Customer Address: </span><span
                    class="template">{{ $data }}</span>
            </td>
            <!-- <td style="word-wrap: break-word"> -->
            <td align="right">
                <span style="position: fixed; top: 9mm; right:3mm; font-size:2mm;">Order No: </span><span
                    class="template">{{$data}} </span><br>
                <span style="position: fixed; top: 12mm; right:14mm; font-size:2mm;">Mobile No: </span><span
                    class="template">{{$data}} </span><br>
                <span style="position: fixed; top: 15mm; right:13mm; font-size:2mm;">Receiving date: </span><span
                    class="template">{{$data}} </span><br>
                <span style="position: fixed; top: 18mm; right:13mm; font-size:2mm;">Delivery Date: </span><span
                    class="template">{{ $data}}</span>
        </tr>
    </table>


    <table class="maintable" style="width:100%; position: fixed; top: 21mm; left:1mm; font-size:2mm;">
        <thead>
            <tr>
                <th>#</th>
                <th>Items</th>
                <th>Status</th>
                <th>Service Type</th>
                <th>Quantity</th>
                <th>Unit Price </th>
                <th>Extra Service</th>
                <th>Amount</th>
            </tr>
        </thead>
    </table>



</body>

</html>