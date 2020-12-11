@extends('layouts.auth')
@section('navcontent')
<div class="container">
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <fieldset>
            <legend>{{ __('Create New B2B Order') }}</legend>
            @include('includes.messages')

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="customername">Brand Name</label>
                        <input type="text" class="form-control" id="customername" name="customername"
                            value="{{ old('customername') }}" required>
                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                            value="{{Auth::user()->id }}">
                    </div>

                    <div class="col">
                        <label for="customer_address">Brand Address</label>
                        <input type="text" class="form-control" id="customer_address" name="customer_address"
                            value="{{ old('customer_address') }}" required>
                    </div>
                    <div class="col">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="{{ old('phone_number') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="orderdate">Order Date</label>
                            <input type="text" class="form-control" id="orderdate" name="orderdate" readonly value="">
                        </div>
                        <div class="col">
                            <label for="due_date">Delivery Date</label>
                            <input type="text" class="form-control" id="due_date" name="due_date" readonly
                                value="{{ old('due_date') }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="branchname">Select Type</label>
                            <select class="form-control branchname" name="branchname" id="branchname">
                                <option value='0'>Select Branch</option>
                                @foreach($branches as $branch)
                                <option value='{{ $branch->id }}'>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="branchaddress">Branch Address</label>
                            <input type="text" class="form-control" id="branchaddress" name="branchaddress" readonly
                                value="">
                        </div>
                        <div class="col">
                            <label for="order_id">Order No</label>
                            <input type="text" class="form-control" id="order_id" name="order_id" readonly value="">
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
            <br><br>


            <div class="form-group">
                <div class="row">
                    <table class="table cartitem" style="display:none">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="tax">Tax %</label>
                        <input type="text" class="form-control" id="ordertax" name="tax" value="0%">
                    </div>


                    <div class="col">
                        <label for="discountvalue">Discount Amount ( TK or %)</label>
                        <input type="text" class="form-control" id="discountvalue" name="discountvalue" value="0">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="qty">Quantity</label>
                        <input type="text" class="form-control qty" id="qty" name="qty" readonly
                            value="{{ old('quantity') }}" required>
                    </div>

                    <div class="col">
                        <label for="subtotal">Subtotal</label>
                        <input type="text" class="form-control" id="ordersubtotal" name="subtotal" readonly
                            value="{{ old('subtotal') }}" required>
                    </div>

                    <div class="col">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="ordertotal" name="total" readonly
                            value="{{ old('total') }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="advance_payment">Advance Payment</label>
                        <input type="text" class="form-control" id="advance_payment" name="advance_payment" value="0"
                            required>
                    </div>
                    <div class="col">
                        <label for="due_payment">Amount Due</label>
                        <input type="text" class="form-control" id="due_payment" name="due_payment" value="0" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
    </form>

</div>
@endsection

<style>
.multiselect-container>li>a>label {
    padding: 4px 20px 3px 20px;
}

.clicked {
    background-color: #1b1a1a42;
}

.addmore,
.removemore,
.extrachage,
.package,
.status {
    background-color: #38c172;
    color: white;
    padding: 5px 10px !important;
    text-align: center;

}
</style>

@section('jscript')

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

    $(document).on('change', '.branchname', function(e) {

        branchid = $(this).val();

        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'branch/' + branchid,

            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#branchaddress').html("<p>Loading...</p>");
            },

            success: function(response) {
                console.log(response['lastorderno']);
                $('#branchaddress').val(response['branch']['address']);
                if (response['lastorderno'] == null) {
                    startlimit = response['branch']['start_limit'];
                    endlimit = response['branch']['end_limit'];
                    running = response['branch']['running_no'];

                    if (running != startlimit) {
                        $('#order_id').val(running);
                    } else {
                        $('#order_id').val(response['branch']['start_limit']);
                    }


                } else {

                    prev_id = response['lastorderno']['order_id'];
                    endlimit = response['branch']['end_limit'];

                    if (prev_id < endlimit) {

                        prev_id = prev_id + 1;
                        $('#order_id').val(prev_id);
                    } else {
                        $('#order_id').val(response['branch']['start_limit']);
                    }

                }



            }
        })

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
            beforeSend: function() {
                $('#country_list').html("<p>Loading...</p>");
            },
            success: function(data) {
                $('#country_list').html(data);

            }
        })
        // end of ajax call

        if (query == "") {
            $('#country_list').html('');
            $('.ajaxtable').html('');

        }
    });

    prevslug = "";
    itemrowarray = [];
    regulartime = [];
    urgenttime = [];

    $(document).on('click', '.itemlist', function(event) {
        $(this).css('background-color', '#1b1a1a42');
        $(this).siblings().css('background-color', '');
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
                        "</td><td><input type='button' value='+' class='addmore'>&nbsp;&nbsp;&nbsp;<input type='button' value='-' class='removemore'></td><input type='hidden' name='price' class='price'><input type='hidden' name='quantity' class='quantity'><input type='hidden' name='urgent' class='urgentinput'><input type='hidden' name='regular' class='regularinput'><input type='hidden' name='item_id' class='item_id' value='' multiple>";

                    if (jQuery.inArray(slug, itemrowarray) == -1) {

                        $(".cartitem tbody").append(option);
                    }

                    
                }

            }

        });



    });

    qty = 0;

    $(document).on('click', '.addmore', function() {

        headstring =
            "<tr><th>Services</th><th>Delivery</th><th>Status</th><th>Packaging</th><th>Price</th><th>Extra Charge</th><th>Action </th></tr>";

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
                console.log(rowdata);

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
                        ] + "' name='status[]'></td><td align='left'><input id='" +
                        rowdata['item']
                        [i][
                            'id'
                        ] + "' type='text' class='package' itemid='" + rowdata['item'][i][
                            'id'
                        ] +
                        "' name='packaging[]'></td><td align='right' itemname=" +
                        rowdata['item'][i]['id'] + "  id='slug_" + rowdata['item'][i][
                            'slug'
                        ] +
                        "' class='corporate_price' slug=" + rowdata['item'][i]['slug'] +
                        " style='color:white'> <input id='" +
                        rowdata[
                            'item'][i]['id'] + "' type='text' class='unitprice' itemid='" +
                        rowdata[
                            'item'][i][
                            'id'
                        ] +
                        "' name='unitprice[]' value='0'></td><td align='left' class='dataextra'></td><td align='left'><input type='button'class='addcharge'></td><input type='hidden' name='servicecharge[]' class='servicecharge' id='servicecharge_" +
                        rowdata['item'][i]['id'] +
                        "'><input type='hidden' name='orderitem[]' class='orderitem' id='orderitem_" +
                        rowdata['item'][i]['id'] +
                        "'><input type='hidden' name='deliveryday[]' class='deliveryday' id='deliveryday_" +
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
                    regulartime.push(rowdata['item'][i]['regularDeliveryTime']);
                    urgenttime.push(rowdata['item'][i]['urgentDeliveryTime']);
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
        qty = qty + 1;
        $("#qty").prop("value", qty)
        
    });



    $(document).on('click', '.removemore', function() {
        qty = $('document ,.cartitem .servicerow').length;
        if (qty > 0) {
            qty = qty - 1;
        }

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
        $("#qty").prop("value", qty)


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
    itemnumber = 0;
    itemidarray = [];
    itemnamearray = [];
    itemrate = [];
    itemqty = [];
    newadditem = 1;
    sum = 0;

    $(document).on('click', '.multiselect ', function(e) {
        urgentsum = 0;
        regularsum = 0;
        orderitemval = [];
    });

    servicearray = [];
    arrayid = [];
    extra_charge = 0;
    changesum = 0;
    prevcharge = 0;

    $(document).on('keyup', '.itemtable,  .unitprice', function() {

        newprice = parseInt($(this).val());
        console.log(newprice);
        $extrarow = $('document , .cartitem tr .extrachage');
        var total_extra = 0;

        $extrarow.each(function() {
            extravalue = parseInt($(this).val())
            total_extra += parseInt(extravalue);

        });
         //for sending data to backend
        newitemprice = [];
        $('document ,.cartitem .servicerow').each(function() {
            var price = parseInt($(this).find(".unitprice").val());
            console.log($(this).find(".unitprice"))
            newitemprice.push(price)
        });
        const newpriceArray = newitemprice.filter(function(value) {
            return !Number.isNaN(value);
        });
        $('[name=price]').val(newpriceArray);
      
        if (Number.isNaN(total_extra)) {
            total_extra = 0;
        }
       
        var $dataRows = $('document , .cartitem tr .unitprice');
        var total = 0;

        $dataRows.each(function() {
            pricevalue = parseInt($(this).val());
            console.log(pricevalue)
            if ($(this).text() == "TK") {
                pricevalue = 0;
            }
            total += parseInt(pricevalue);

        });

        $("#ordersubtotal").prop("value", total + total_extra);
        $("#ordertotal").prop("value", total + total_extra);

    });

    
    $(document).on('keyup', '.itemtable,  .extrachage', function() {

        $extrarow = $('document , .cartitem tr .extrachage');
        var total_extra = 0;
        $extrarow.each(function() {
            extravalue = parseInt($(this).val())
            total_extra += parseInt(extravalue);

        });
       

        $(this).parents('.dataextra').siblings('.servicecharge').val(total_extra);

        if (Number.isNaN(total_extra)) {
            total_extra = 0;
        }
       
        var $dataRows = $('document , .cartitem tr .unitprice');
        var total = 0;

        $dataRows.each(function() {
            pricevalue = parseInt($(this).val())
            if ($(this).text() == "TK") {
                pricevalue = 0;
            }
            total += parseInt(pricevalue);

        });


        $("#ordersubtotal").prop("value", total_extra + total);
        $("#ordertotal").prop("value", total_extra + total);

    });

    $(document).on('change', '.dropdownservice', function(e) {

        if (($(this).parents('.services').siblings('.dataextra').children().length) < ($(this).find(
                'option:selected').length)) {
            console.log("first if")

            if ($(this).parents('.services').siblings('.dataextra').children().length > 0) {
                console.log($(this).parents('.services').siblings('.dataextra').children())

                $(this).parents('.services').siblings().children('.extrachage:last').after(
                    "<input type='text' value='0' class='extrachage' disabled>")

            } else

            {
                console.log("else")
                $(this).parents('.services').siblings('.dataextra').html(
                    "<input type='text' class='extrachage'  value='0' disabled>")

            }
        }
        if ($(this).find('option:selected').length == 0) {
            $(this).parents('.services').siblings().children('.extrachage').html('');

        }

        $(this).parents('.services').siblings().children(".urgency").attr('disabled', false)
        serviceid = $(this).children("option:selected").val();

        orderitemval = [];

        $.each($(this).children("option:selected"), function() {
            orderitemval.push($(this).val());
        });
        console.log(orderitemval)

        $(this).parents('.services').siblings('.orderitem').val(orderitemval);

        item = $(this).attr('itemid')
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
    maxurgent = 0;
    maxregular = 0;

    
    $(document).on('change', '.urgency', function() {

        slug = $(this).parent().siblings('.unitprice').attr('slug')
        urgency_id = $(this).attr("urgencyid")
        urgentid = urgency_id

        $(this).parent().siblings().children(".extrachage").attr('disabled', false)
        if ($(this).children("option:selected").hasClass("urgent") == true) {
            maxurgent = Math.max.apply(Math, urgenttime)
            $(this).children(".urgent").prop("value", 1)
            $(this).children(".regular").prop("value", 0)
            $(this).parent().siblings('.unitprice').text((parseInt($("#slug_" + slug)
                .attr("urgentsum"))) + 'TK')


        } else {
            maxregular = Math.max.apply(Math, regulartime)
            $(this).children(".urgent").prop("value", 0)
            $(this).children(".regular").prop("value", 1)
            $(this).parent().siblings('.unitprice').text((parseInt($("#slug_" + slug)
                .attr(
                    "regularsum"))) + 'TK')

        }

        var deliveryday = Math.max(maxurgent, maxregular);

        date = new Date();
        y = date.getFullYear();
        m = date.getMonth() + 1;
        d = date.getDate();

        date.setDate(date.getDate() + (+deliveryday));
        var dd = date.getDate();
        var mm = date.getMonth() + 1;
        var y = date.getFullYear();
        var someFormattedDate = dd + '-' + mm + '-' + y;
        $("#due_date").val(someFormattedDate)


        $(this).parent().siblings('.unitprice').attr('withoutextra', $(this).parent()
            .siblings('.unitprice').text())


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

        // $("#ordersubtotal").prop("value", parseFloat(sum))

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
        // $("#ordertotal").prop("value", finaltotal)

        urgency = parseInt($(this).children("option:selected").val());
        $(this).parents(".servicerow").attr('urgency', urgency)

        urgentarray = [];
        $('document ,.cartitem .urgency').each(function() {
            var urgent = parseInt($(this).children('.urgent').val());
            console.log($(this).children('.urgent'))
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
        // $("#qty").prop("value", newpriceArray.length)


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
    
    $(document).on('keyup', '#advance_payment', function() {
        var advance = parseFloat($(this).val());
        var total = parseFloat($("#ordertotal").val());

        if(advance < total){
             due_amount = total - advance;
        }
        $("#due_payment").val(due_amount);
        
    });
});
</script>
@endsection