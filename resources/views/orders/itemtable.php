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
        <?php
        $codeno = 0;

            for($i=0; $i<count($data); $i++){
               
                ?>

        <tr id='itemrow_<?php echo $data[$i]['id'] ?>' class="itemrow">

            <td class="slug"><?php echo $data[$i]['name'] ?></td>


            <td id="itemcell" class="itemcell">
                <span id='spanadd_<?php echo $data[$i]['id'] ?>' style="cursor:pointer" class="spanadd"
                    spanadd="<?php echo $data[$i]['id'] ?>">+</span>
                <input id='itemadd_<?php echo $data[$i]['id'] ?>' type="button" class="itemadd"
                    itemid=" <?php echo $data[$i]['id'] ?>" value='1'>&nbsp;&nbsp;
                <span id='spandel_<?php echo $data[$i]['id'] ?>' style="cursor:pointer" class="spandel"
                    spandel="<?php echo $data[$i]['id'] ?>">-</span>
            </td>

        <tr class="servicerow" style=" background:#6c757d" id='servicerow_<?php echo $data[$i]['id'] ?>'
            itemid="<?php echo $data[$i]['id'] ?>" code='<?php echo $data[$i]['code']; ?>'>

            <td align="left" class="services" id='item_<?php echo $data[$i]['id'] ?>' style="color:white">

                <select class="dropdownservice" id='dropdownservice_<?php echo $data[$i]['id'] ?>' multiple="multiple"
                    itemid="<?php echo $data[$i]['id'] ?>" name="selectedservice">


                    <?php

                    for($j=0; $j<count($services); $j++){
                        ?>
                    <option value="<?php echo $services[$j]['service_id'] ?>">
                        <?php echo $services[$j]['service_name']; ?>
                    </option>


                    <?php

                    }

                    ?>

                </select>
            </td>



            <td align="left">
                <select class="urgency" id="urgency" urgencyid="<?php echo $data[$i]['id'] ?>" disabled>
                    <option>Delivery</option>
                    <option class="regular" id="regular_1" serviceId="<?php echo $data[$i]['id'] ?>"
                        itemid="<?php echo $data[$i]['id'] ?>" value="">
                        Regular</option>
                    <option class="urgent" id="urgent_1" serviceId="<?php echo $data[$i]['id'] ?>"
                        itemid="<?php echo $data[$i]['id'] ?>" value="">
                        Urgent</option>

                </select>
            </td>

            <td align="left">
                <input id="<?php echo $data[$i]['id'] ?>" type="text" class="status"
                    itemid="<?php echo $data[$i]['id'] ?>" name="status[]">
            </td>

            <td align="left">
                <input id='package_<?php echo $data[$i]['id'] ?>' type="text" class='package'
                    itemid="<?php echo $data[$i]['id'] ?>" name="packaging[]">
            </td>

            <td align="left">
                <input id='extracharge_"<?php echo $data[$i]['id'] ?>"' type="text" class="extrachage"
                    itemid="<?php echo $data[$i]['id'] ?>" name="service_charge[]" value="0" disabled>
            </td>

            <td align="right" itemname="<?php echo $data[$i]['id'] ?>" id='slug_<?php echo $data[$i]['slug'] ?>'
                class="unitprice" slug="<?php echo $data[$i]['slug'] ?>" style="color:white">TK</td>

            <input type="hidden" name="withoutextra" class="withoutextra"
                id='withoutextra_<?php echo $data[$i]['id'] ?>'>
            <input type='hidden' name='orderitem[]' class='orderitem' id='orderitem_<?php echo $data[$i]['id'] ?>'>
        </tr>

        <input type='hidden' name='price' class="price">
        <input type='hidden' name='quantity' class="quantity">
        <input type='hidden' name='urgent' class="urgentinput">
        <input type='hidden' name='regular' class="regularinput">
        <input type='hidden' name='item_id' class="item_id">

        </tr>
        <?php
   }
?>

    </tbody>
</table>
<hr style="border-top:1px solid #77777778">
</hr>


<script type="text/javascript">
$(document).ready(function() {

    $('.dropdownservice').multiselect({

        selectAllValue: 'multiselect-all',
        includeSelectAllOption: true,
    });

});
</script>