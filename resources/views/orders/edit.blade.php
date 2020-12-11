@extends('layouts.auth')
@section('navcontent')
<div class="container">

    <legend>{{ __('Order Details') }}</legend>

    <div class="card-body">
        @include('includes.messages')
        <form method="POST" action="{{ route('orders.update', $order->id) }}">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $order->id}}" class="order_no">

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="customername">Customer Name</label>
                        <input type="text" class="form-control" id="customername" name="customername"
                            value="{{ $order->customername }}">
                    </div>

                    <div class="col">
                        <label for="customer_address">Customer Address</label>
                        <input type="text" class="form-control" id="customer_address" name="customer_address"
                            value="{{ $order->customer_address }}">
                    </div>
                    <div class="col">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="{{ $order->phone_number }}">
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
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date"
                            value="{{ $order->due_date }}">
                    </div>
                </div>
            </div>

            <!-- for searching items -->
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <h4 class="text-center"><b>Search Items</b></h4>
                    <hr>
                    <div class="form-group">
                        <label>Type a item code</label>
                        <input type="text" name="country" id="country" placeholder="Enter item code"
                            class="form-control">
                    </div>
                    <div id="country_list"></div>
                </div>
                <div class="col-lg-3"></div>
            </div>
    </div>
    <div class="form-group ajaxtable">

    </div>
    


    <div class="form-group">
        <table class="table table-hover itemtable">
            <thead>
                <tr>
                    <th>Items</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Packaging</th>
                    <th>Extra Charge</th>
                    <th>Price</th>

                </tr>
            </thead>
            <tbody>

                @foreach($orderitems as $item)

                <tr id="itemrow_{{ $item->id }}" class='itemrow'>
                    <td class="slug" name="{{ $item->item_name }}">{{ $item->item_name }}</td>

                    <td id='itemcell' class='itemcell'>
                        <span id='spanadd_{{$item->id}}' style='cursor:pointer' class='spanadd'
                            spanadd="{{$item->id}}">+</span>&nbsp;&nbsp;
                        <input id="itemadd_{{$item->id}}" type="button" class='itemadd' itemid="{{$item->id}}"
                            value='{{ $item->quantity }}'>&nbsp;&nbsp;
                        <span id="spandel_{{$item->id}}" style="cursor:pointer" class="spandel"
                            spandel="{{$item->id}}">-</span>
                    </td>

                    <br><br>
                <tr class="servicerow" style=" background:#6c757d" id="servicerow_{{$item->id}}" itemid="{{$item->id}}">
                    <td align="left" class="services" id="item_{{$item->id}}" style="color:white">

                        <select class="dropdownservice" id="dropdownservice_{{$item->id}}" multiple="multiple"
                            itemid="{{$item->id}}" name="selectedservice">

                            @php


                            $search = ",";

                            $result = array();
                            $tmp = explode(",", $item['service_id']);

                            $prefix = $fruitList = '';
                            for ($i = 0; $i < count($tmp) ; $i++) { $servicename=App\Service::where('id', $tmp[$i])->
                                first();
                                @endphp
                                <option value=" @php
                                            echo $servicename['id'];
                                            @endphp" selected>
                                    @php
                                    echo $servicename['name'];
                                    @endphp
                                </option>

                                @php
                                }
                                @endphp
                                <input type='hidden' name='orderitem[]' class='orderitem' id="orderitem_{{$item->id}}">
                        </select>
                    </td>
                    <td align="left">
                        <select class="urgency" id="urgency" urgencyid="{{$item->id}}" serviceid="{{$item->service_id}}">
                            @if ($item->urgent == 1)


                            <option class="urgent" id="urgent_1" serviceId="{{$item->id}}" itemid="{{$item->id}}"
                                value="{{$item->urgent}}">Urgent</option>
                            <option class="regular" id="regular_1" serviceId="{{$item->id}}" itemid="{{$item->id}}"
                                value="{{$item->urgent}}">Regular</option>


                            @elseif ($item->regular == 1)

                            <option class="urgent" id="urgent_1" serviceId="{{$item->id}}" itemid="{{$item->id}}"
                                value="{{$item->regular}}">Urgent</option>
                            <option class="regular" id="regular_1" serviceId="{{$item->id}}" itemid="{{$item->id}}"
                                value="{{$item->regular}}">Regular</option>
                            @endif
                        </select>

                    </td>

                    <td align="left">
                        <input id="status_{{$item->id}}" type="text" class='status' itemid="{{$item->status}}"
                            name="status[]" value="{{$item->status}}">
                    </td>

                    <td align="left">
                        <input id="package_{{$item->id}}" type="text" class='package' itemid="{{$item->id}}"
                            name="packaging[]" value="{{$item->packaging}}">
                    </td>

                    <td align="left">
                        <input id="extracharge_{{$item->id}}" type="text" class='extrachage' itemid="{{$item->id}}"
                            name="service_charge[]" value="{{$item->service_charge}}">
                    </td>
                    <td align="right" itemname="{{$item->id}}" id="slug_{{$item->slug}}" class="unitprice"
                        slug="{{$item->slug}}" style="color:white">{{$item->price}} TK</td>


                </tr>

                <input type='hidden' name='price' class="price">
                <input type='hidden' name='quantity' class="quantity">
                <input type='hidden' name='urgent' class="urgentinput">
                <input type='hidden' name='regular' class="regularinput">
                <input type='hidden' name='item_id' class="item_id">



                </tr>
                @endforeach
            </tbody>
        </table>
        <hr style="border-top:1px solid #77777778">
        </hr>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label for="tax">Tax %</label>
                <input type="text" class="form-control" id="ordertax" name="tax" value="{{$order->tax}}">
            </div>


            <div class="col">
                <label for="discountvalue">Discount Amount ( TK or %)</label>
                <input type="text" class="form-control" id="discountvalue" name="discountvalue"
                    value="{{$order->discountvalue}}">
            </div>
        </div>

    </div>


    <div class="form-group">
        <div class="row">
            <div class="col">
                <label for="qty">Quantity</label>
                <input type="text" class="form-control qty" id="qty" name="qty" readonly value="{{$order->qty}}">
            </div>

            <div class="col">
                <label for="subtotal">Subtotal</label>
                <input type="text" class="form-control" id="ordersubtotal" name="subtotal" readonly
                    value="{{$order->subtotal}}">
            </div>

            <div class="col">
                <label for="total">Total</label>
                <input type="text" class="form-control" id="ordertotal" name="total" readonly value="{{$order->total}}">
            </div>

        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    </form>
</div>

</div>
@endsection
<style>
.multiselect-container>li>a>label {
    padding: 4px 20px 3px 20px;
}
</style>
@push('scripts')

<script type="text/javascript">
$(document).ready(function() {
    n = new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    $("#orderdate").val(d + "/" + m + "/" + y);


    urgent = [];
    regularprice = [];
    mainarray = [];

    taxsum = 0;
    discountsum = 0;
    itemarray = []
    var inc = 0;


    $('.dropdownservice').multiselect({

        selectAllValue: 'multiselect-all',
        // includeSelectAllOption: true,
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        maxHeight: '300',
        buttonWidth: '235',
    });


    $('#country').on('keyup', function() {
        var query = $(this).val();

        itemcode = query
        $(".checkout").show();

        $.ajax({
            url: 'items/' + query,

            type: "GET",

            data: {
                'country': query
            },

            success: function(data) {

                // $('.ajaxtable').html(data);
                $('#country_list').html(data);

            }
        })
        // end of ajax call

        if (query == "") {
            $('.ajaxtable').html('');

        }
    });

    prevslug = "";
    itemrowarray = [];

    $(document).on('click', '.itemlist', function() {
        $(".cartitem").show();
        itemslug = $(this).attr('id');
        slug = $(this).text();


        $('document ,.cartitem .itemrow td').each(function() {
            var itemrow = $(this).text();
            itemrowarray.push(itemrow)

        });

        $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url: 'services/' + itemslug,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $("#loading-image").show();
            },

            success: function(response) {
                for (var i = 0; i < response['item'].length; i++) {


                    var option = "<tr class='itemrow' id='itemrow_" + response['item'][i][
                            'id'
                        ] +
                        "' itemrow =" + response['item'][i]['id'] +
                        "><td slug=" + response['item'][i]['slug'] +
                        ">" + response['item'][i]['name'] +
                        "</td><td><input type='button' value='+' class='addmore'>&nbsp;&nbsp;&nbsp;<input type='button' value='-' class='removemore'></td><input type='hidden' name='price' class='price'><input type='hidden' name='quantity' class='quantity'><input type='hidden' name='urgent' class='urgentinput'><input type='hidden' name='regular' class='regularinput'><input type='hidden' name='item_id' class='item_id'>";

                    // console.log($("#itemrow_" + response['item'][i]['id']).siblings().length )

                    if (jQuery.inArray(slug, itemrowarray) == -1) {

                        $(".cartitem tbody").append(option);
                    }
                }

                // rowdata = response;
            }

        });

        // prevslug = slug;

    });



    $(document).on('click', '.addmore', function() {

        headstring =
            "<tr><th>Services</th><th>Quantity</th><th>Status</th><th>Packaging</th><th>Extra Charge</th><th>Price</th></tr>";

        additemslug = $(this).parent().siblings('td').attr('slug');


        $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url: 'services/' + additemslug,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $("#loading-image").show();
            },

            success: function(response) {

                rowdata = response;


                for (i = 0; i < rowdata['item'].length; i++) {

                    firststring =
                        "<tr class='servicerow' style='background:#6c757d' id='servicerow_" +
                        rowdata['item'][i]['id'] + "'  itemid=" + rowdata['item'][i]['id'] +
                        "><td align='left' class='services'  id='item_" + rowdata['item'][i]
                        ['id'] +
                        "' style='color:white'><select class='dropdownservice' id='dropdownservice_" +
                        rowdata['item'][i]['id'] + "' itemid=" + rowdata['item'][i]['id'] +
                        " name='selectedservice' multiple='multiple'>";

                    mainsecond = [];

                    for (j = 0; j < rowdata['services'].length; j++) {


                        secondstring = "<option value=" + rowdata['services'][j]['id'] +
                            "> " +
                            rowdata[
                                'services'][j]['name'] + "</option>";

                        mainsecond.push(secondstring);

                    }

                    thirdstring =
                        "</select></td><td align='left'><select class='urgency' id='urgency' urgencyid='" +
                        rowdata['item'][i]['id'] +
                        "' disabled><option>Delivery</option><option class='regular' id='regular_1' serviceId='" +
                        rowdata['item'][i]['id'] + "' itemid='" + rowdata['item'][i]['id'] +
                        "' value=''>Regular</option><option class='urgent' id='urgent_1' serviceId='" +
                        rowdata['item'][i]['id'] + "' itemid='" + rowdata['item'][i]['id'] +
                        "' value=''>Urgent</option></select></td><td align='left' ><input id='" +
                        rowdata[
                            'item'][i]['id'] + "' type='text' class='status' itemid='" +
                        rowdata[
                            'item'][i][
                            'id'
                        ] + "' name='status[]'></td> <td align='left'><input id='" +
                        rowdata['item']
                        [i][
                            'id'
                        ] + "' type='text' class='package' itemid='" + rowdata['item'][i][
                            'id'
                        ] +
                        "' name='packaging[]'></td><td align='left'><input id='" + rowdata[
                            'item'][
                            i
                        ][
                            'id'
                        ] + "' type='text' class='extrachage' itemid='" + rowdata['item'][i]
                        ['id'] +
                        "' name='service_charge[]' value='0' disabled></td><td align='right' itemname=" +
                        rowdata['item'][i]['id'] + "  id='slug_" + rowdata['item'][i][
                            'slug'
                        ] +
                        "' class='unitprice' slug=" + rowdata['item'][i]['slug'] +
                        " style='color:white'>TK</td><input type='hidden' name='withoutextra' class='withoutextra' id='withoutextra_" +
                        rowdata['item'][i]['id'] +
                        "'><input type='hidden' name='orderitem[]' class='orderitem' id='orderitem_" +
                        rowdata['item'][i]['id'] +
                        "'></tr></tr>"


                    if ($("#itemrow_" + rowdata['item'][i]['id']).siblings("#servicerow_" +
                            rowdata['item'][
                                i
                            ][
                                'id'
                            ] + ":last")
                        .length > 0) {
                        $("#itemrow_" + rowdata['item'][i]['id']).siblings("#servicerow_" +
                                rowdata['item'][
                                    i
                                ][
                                    'id'
                                ] + ":last")
                            .after(firststring + mainsecond.join("") +
                                thirdstring);


                    } else {



                        $("#itemrow_" + rowdata['item'][i]['id']).after(headstring +
                            firststring +
                            mainsecond.join("") +
                            thirdstring);

                    }
                }


                $('.dropdownservice').multiselect('destroy')


                $('document , .cartitem .dropdownservice').multiselect({

                    selectAllValue: 'multiselect-all',
                    // includeSelectAllOption: true,
                    enableCaseInsensitiveFiltering: true,
                    enableFiltering: true,
                    maxHeight: '300',
                    buttonWidth: '235',
                });

            }

        });

        $("#qty").prop("value", $('document ,.cartitem .servicerow').length)

    });



    $(document).on('click', '.removemore', function() {

        // console.log($(this).parent().parent().attr('itemrow'))

        removeid = $(this).parent().parent().attr('itemrow');
        $(this).parent().parent().siblings("#servicerow_" + removeid + ":last")
            .remove();

        $("#qty").prop("value", $('document ,.cartitem .servicerow').length);



        var $tableBody = $('document ,.cartitem').find("tbody"),

            $trLast = $tableBody.find("#servicerow_" + removeid)


        var $dataRows = $('document ,.cartitem tr .unitprice');
        var sum = 0;
        $dataRows.each(function() {
            pricevalue = parseInt($(this).text())
            if ($(this).text() == "TK") {
                pricevalue = 0;
            }
            sum += parseInt(pricevalue);

        });

        $("#ordersubtotal").prop("value", parseFloat(sum));

        var discountsum = $("#discountvalue").val();
        var withtax = 0;
        subtotal = parseFloat($("#ordersubtotal").val());


        if ($("#ordertax").val() == "") {
            var withtax = 0 * subtotal;

        } else {
            withtax = (parseFloat($("#ordertax").val()) / 100) * subtotal;
        }



        //for deducting discount amount
        if (discountsum.indexOf("%") != -1) {

            discountsum = (parseFloat(discountsum) / 100) * subtotal;


        } else {
            discountsum = parseFloat(discountsum);

        }


        var total = parseFloat((subtotal + withtax))
        finaltotal = total

        var finaltotal = parseFloat((finaltotal - discountsum))
        $("#ordertotal").prop("value", finaltotal);



        //for sending data to backend
        newitemprice = [];

        $('document ,.cartitem .servicerow').each(function() {

            var price = parseInt($(this).find(".unitprice").text());
            newitemprice.push(price)

        });
        const newpriceArray = newitemprice.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=price]').val(newpriceArray);




        urgentarray = [];
        $('document ,.cartitem .urgency').each(function() {
            var urgent = parseInt($(this).children('.urgent').val());
            urgentarray.push(urgent);

        });

        const newurgentArray = urgentarray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=urgent]').val(newurgentArray);




        regulararray = [];
        $('document ,.cartitem .urgency').each(function() {
            var regular = parseInt($(this).children('.regular').val());
            regulararray.push(regular);

        });

        const newregularArray = regulararray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=regular]').val(regulararray);



        itemarray = [];
        $('document ,.cartitem .servicerow').each(function() {
            var itemid = parseInt($(this).attr("itemid"));
            itemarray.push(itemid);

        });
        const newitemArray = itemarray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=item_id]').val(newitemArray);



        quantityarray = [];
        $('document ,.cartitem .itemcell').each(function() {
            var unitqty = parseInt($(this).children('.itemadd').val());
            quantityarray.push(unitqty);
        });
        const newqtyArray = quantityarray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $("#qty").prop("value", newpriceArray.length)


        $('document ,.cartitem .servicerow').each(function() {
            var itemid = parseInt($(this).attr("itemid"));
            itemarray.push(itemid);

        });
        countrow = 0;

        if ($(this).is(':disabled') == false) {
            countrow += 1
        }
        countrowarray.push(countrow)

        $('[name=quantity]').val(countrowarray);


    });



    discountarray = [];
    discountTypearray = [];

    itemnumber =
        0;
    itemidarray = [];
    itemnamearray = [];
    itemrate = [];
    itemqty = [];
    newadditem = 1;
    sum = 0;



    $(document).on('click', '.multiselect ', function(e) {
        urgentsum = 0;
        regularsum = 0;
        orderitemarray = [];

    });

    servicearray = [];
    arrayid = [];
    extra_charge = 0;
    changesum = 0;


    $(document).on('keyup', '.itemtable, .extrachage', function() {

        var price = parseFloat($(this).parent().siblings(".unitprice").attr(
            'withoutextra'));

        charge = parseFloat($(this).val());


        if (Number.isNaN(charge)) {
            charge = 0;
        }

        var totalamount = charge + price;

        $(this).parent().siblings(".unitprice").text(totalamount + 'TK');

        totalprice = parseFloat($(this).parent().siblings('.unitprice').text());

        var $dataRows = $('document , .cartitem tr .unitprice');
        var total = 0;


        $dataRows.each(function() {

            pricevalue = parseInt($(this).text())
            if ($(this).text() == "TK") {
                pricevalue = 0;
            }
            total += parseInt(pricevalue);

        });


        $("#ordersubtotal").prop("value", total);
        $("#ordertotal").prop("value", total);

    });


    $(document).on('change', '.dropdownservice', function(e) {

        $(this).parent().siblings().children(".urgency").attr('disabled', false)
        serviceid = $(this).find('option:selected:last').val();

        orderitemval = $(this).find('option:selected:last').val();
        orderitemarray.push(orderitemval)

        item = $(this).attr('itemid')
        $(this).parent().siblings('.orderitem').val(orderitemarray)

        itemslug = $('#servicerow_' + item).children(".unitprice").attr('slug');

        $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url: 'items/' + serviceid + '/' + itemslug,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $("#loading-image").show();
            },

            success: function(response) {
                console.log(response)
                $("#loading-image").hide();
                mainarray = response;

                if (mainarray.length > 0) {
                    for (var i = 0; i < mainarray.length; i++) {

                        var id = mainarray[i].id;
                        var name = mainarray[i].name;
                        slug = mainarray[i].slug;
                        discount = mainarray[i].discount;
                        discountType = mainarray[i].discountType;
                        tax = mainarray[i].tax;
                        var regularPrice = mainarray[i]
                            .regularPrice;
                        var urgentPrice = mainarray[i]
                            .urgentPrice;
                        var regularDeliveryTime = mainarray[i]
                            .regularDeliveryTime;
                        var urgentDeliveryTime = mainarray[i]
                            .urgentDeliveryTime;
                        discountarray.push(discount)
                        discountTypearray.push(discountType)


                        regularsum += parseFloat(mainarray[i].regularPrice);
                        urgentsum += parseFloat(mainarray[i].urgentPrice);



                        $("#slug_" + slug).attr("urgentsum", urgentsum)
                        $("#slug_" + slug).attr("regularsum", regularsum)
                    }

                }
            }


        });



    });

    countrowarray = [];
    finaldiscount = 0;

    $(document).on('change', '.urgency', function() {
        console.log($(this).parent().siblings().children('.dropdownservice').find(":selected").val())
        urgentserviceid = $(this).parent().siblings().children('.dropdownservice').find('option:selected').val()
            // $(this).find('option:selected:last').val()
           

        console.log($(this).parent().siblings().children('.dropdownservice').find('option:selected').val())

        $(this).parent().siblings().children(".extrachage").attr('disabled', false)

        slug = $(this).parent().siblings('.unitprice').attr('slug')
        urgency_id = $(this).attr("urgencyid")
        urgentid = urgency_id

        itemslug = $('#servicerow_' + urgentid).children(".unitprice").attr('slug');

        $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url: 'items/' + serviceid + '/' + itemslug,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $("#loading-image").show();
            },

            success: function(response) {
                console.log(response)
                $("#loading-image").hide();
                mainarray = response;

                if (mainarray.length > 0) {
                    for (var i = 0; i < mainarray.length; i++) {

                        var id = mainarray[i].id;
                        var name = mainarray[i].name;
                        slug = mainarray[i].slug;
                        discount = mainarray[i].discount;
                        discountType = mainarray[i].discountType;
                        tax = mainarray[i].tax;
                        var regularPrice = mainarray[i]
                            .regularPrice;
                        var urgentPrice = mainarray[i]
                            .urgentPrice;
                        var regularDeliveryTime = mainarray[i]
                            .regularDeliveryTime;
                        var urgentDeliveryTime = mainarray[i]
                            .urgentDeliveryTime;
                        discountarray.push(discount)
                        discountTypearray.push(discountType)


                        regularsum += parseFloat(mainarray[i].regularPrice);
                        urgentsum += parseFloat(mainarray[i].urgentPrice);



                        $("#slug_" + slug).attr("urgentsum", urgentsum)
                        $("#slug_" + slug).attr("regularsum", regularsum)
                    }

                }
            }


        });
        if ($(this).children("option:selected").hasClass("urgent") == true) {

            $(this).children(".urgent").prop("value", 1)
            $(this).children(".regular").prop("value", 0)
            $(this).parent().siblings('.unitprice').text((parseInt($("#slug_" +
                    slug)
                .attr(
                    "urgentsum"))) + 'TK')


        } else {

            $(this).children(".urgent").prop("value", 0)
            $(this).children(".regular").prop("value", 1)
            $(this).parent().siblings('.unitprice').text((parseInt($("#slug_" +
                    slug)
                .attr(
                    "regularsum"))) + 'TK')

        }

        $(this).parent().siblings('.unitprice').attr('withoutextra', $(this)
            .parent()
            .siblings(
                '.unitprice').text())


        var $tableBody = $('document ,.cartitem').find("tbody"),

            $trLast = $tableBody.find("#servicerow_" + urgency_id)


        var $dataRows = $('document ,.cartitem tr .unitprice');
        var sum = 0;
        $dataRows.each(function() {
            pricevalue = parseInt($(this).text())
            if ($(this).text() == "TK") {
                pricevalue = 0;
            }
            sum += parseInt(pricevalue);

        });




        $("#ordersubtotal").prop("value", parseFloat(sum))

        var discountsum = $("#discountvalue").val();
        var withtax = 0;
        subtotal = parseFloat($("#ordersubtotal").val());


        if ($("#ordertax").val() == "") {
            var withtax = 0 * subtotal;

        } else {
            withtax = (parseFloat($("#ordertax").val()) / 100) * subtotal;
        }



        //for deducting discount amount
        if (discountsum.indexOf("%") != -1) {

            discountsum = (parseFloat(discountsum) / 100) * subtotal;


        } else {
            discountsum = parseFloat(discountsum);

        }


        var total = parseFloat((subtotal + withtax))
        finaltotal = total

        var finaltotal = parseFloat((finaltotal - discountsum))
        $("#ordertotal").prop("value", finaltotal)



        urgency = parseInt($(this).children("option:selected").val());
        $(this).parents(".servicerow").attr('urgency', urgency)


        //for sending data to backend
        newitemprice = [];

        $('document ,.cartitem .servicerow').each(function() {

            var price = parseInt($(this).find(".unitprice").text());
            newitemprice.push(price)

        });
        const newpriceArray = newitemprice.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=price]').val(newpriceArray);




        urgentarray = [];
        $('document ,.cartitem .urgency').each(function() {
            var urgent = parseInt($(this).children('.urgent').val());
            urgentarray.push(urgent);

        });

        const newurgentArray = urgentarray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=urgent]').val(newurgentArray);




        regulararray = [];
        $('document ,.cartitem .urgency').each(function() {
            var regular = parseInt($(this).children('.regular').val());
            regulararray.push(regular);

        });

        const newregularArray = regulararray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=regular]').val(regulararray);



        itemarray = [];
        $('document ,.cartitem .servicerow').each(function() {
            var itemid = parseInt($(this).attr("itemid"));
            itemarray.push(itemid);

        });
        const newitemArray = itemarray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=item_id]').val(newitemArray);



        quantityarray = [];
        $('document ,.cartitem .itemcell').each(function() {
            var unitqty = parseInt($(this).children('.itemadd').val());
            quantityarray.push(unitqty);
        });
        const newqtyArray = quantityarray.filter(function(value) {
            return !Number.isNaN(value);
        });
        $("#qty").prop("value", newpriceArray.length)


        $('document ,.cartitem .servicerow').each(function() {
            var itemid = parseInt($(this).attr("itemid"));
            itemarray.push(itemid);

        });
        countrow = 0;

        if ($(this).is(':disabled') == false) {
            countrow += 1
        }
        countrowarray.push(countrow)

        $('[name=quantity]').val(countrowarray);


    });


    $(document).on('keyup', '#discountvalue , #ordertax', function() {

        discountsum = $("#discountvalue").val();
        var withtax = 0;
        subtotal = parseFloat($("#ordersubtotal").val());


        withtax = (parseFloat($("#ordertax").val()) / 100) * subtotal;

        //for adding tax amount
        if ($("#ordertax").val() == "") {
            var withtax = 0 * subtotal;

        } else {
            withtax = (parseFloat($("#ordertax").val()) / 100) * subtotal;
        }



        //for deducting discount amount
        if (discountsum.indexOf("%") != -1) {

            discountsum = (parseFloat(discountsum) / 100) * subtotal;


        } else {
            discountsum = parseFloat(discountsum);

        }


        var total = parseFloat((subtotal + withtax))
        finaltotal = total

        var finaltotal = parseFloat((finaltotal - discountsum))
        $("#ordertotal").prop("value", finaltotal)

    });

});
</script>
@endpush