
<!-- Customer js php -->

<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice_update.js" type="text/javascript"></script>
<style type="text/css">
    

.ab {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 0px;
    cursor: pointer;
   
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default radio button */
.ab input {
    position: absolute;
    opacity: 0;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.ab:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.ab input:checked ~ .checkmark {
    background-color: #008000;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.ab input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.ab .checkmark:after {
    top: 7px;
    left: 7px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: white;
}

/* second checbox  */
input[type=checkbox] {
    display: none;
}

input[type=checkbox] + label {
    display: inline-block;
    position: relative;
    padding: 8px;
    background-color: white;
    border: 1px solid green;
    border-radius: 5px;
    width:40px;
    height: 30px;
}

input[type=checkbox]:checked + label {
    background-color: green;
    color: #A4B7C6;
}

input[type=checkbox]:checked + label:after {
    position: absolute;
    left: 12px;
    top: 0px;
    color: #fff; 
    content: '\2714'; 
    font-size: 20px;
} 
</style>

         <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>
        <!-- Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('return_invoice')?></h4>
                        </div>
                    </div>
                    <?php echo form_open('dashboard_pharmacist/return/Cretrun_m/return_invoice',array('class' => 'form-vertical','id'=>'invoice_update' ))?>
                    <div class="panel-body">
             
                        <div class="row">
                            <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger"></i></label>
                                    <div class="col-sm-8">
                                       <input type="text" name="customer_name" value="<?= $customer_name?>" class="form-control customerSelection" placeholder='<?php echo display('customer_name') ?>' required id="customer_name" tabindex="1" readonly="">

                                        <input type="hidden" class="customer_hidden_value" name="customer_id" value="<?= $customer_id ?>" id="SchoolHiddenId"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('date') ?> <i class="text-danger"></i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control" name="invoice_date" value="<?= $date ?>"  required readonly="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('item_information') ?> <i class="text-danger"></i></th>
                                        <th class="text-center"><?php echo display('sold_qty') ?></th>
                                        <th class="text-center"><?php echo display('ret_quantity') ?>  <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?> <i class="text-danger"></i></th>

                                        <?php if ($discount_type == 1) { ?>
                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                        <?php }elseif($discount_type == 2){ ?>
                                        <th class="text-center"><?php echo display('deduction') ?> </th>
                                        <?php }elseif($discount_type == 3) { ?>
                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>

                                        <th class="text-center"><?php echo display('total') ?></th>
                                        <th class="text-center"><?php echo display('check_return') ?> <i class="text-danger">*</i></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                <?php 
                                    foreach ($invoice_all_data as $invoice) {      
                                ?>
                                    <tr>
                                        <td class="" style="width: 200px;">
                                            <input type="text" name="product_name" onclick="invoice_productList('<?= $invoice['sl'] ?>');" value="<?= $invoice['product_name'] ?>-(<?= $invoice['product_model']?>)" class="form-control productSelection" required placeholder='<?php echo display('product_name') ?>' id="product_names" tabindex="3" readonly="">

                                            <input type="hidden" class="product_id_<?= $invoice['sl'] ?> autocomplete_hidden_value"  value="<?= $invoice['product_id'] ?>" id="product_id_<?= $invoice['sl'] ?>"/>
                                             <input type="hidden" class="batch_id_<?= $invoice['sl'] ?>"  value="<?= $invoice['batch_id'] ?>" name="batch_id[]" id="batch_id_<?= $invoice['sl'] ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="sold_qty[]" class="form-control text-right available_quantity_1" value="<?= $invoice['quantity'] ?>" readonly="" />
                                        </td>
                                        <td>
                                            <input type="text"  onkeyup="quantity_calculate('<?= $invoice['sl'] ?>');" onchange="quantity_calculate('<?= $invoice['sl'] ?>');"  class="total_qntt_<?= $invoice['sl'] ?> form-control text-right" id="total_qntt_<?= $invoice['sl'] ?>" min="0" placeholder="0.00" tabindex="4" />
                                        </td>

                                        <td>
                                            <input type="text" name="product_rate[]" onkeyup="quantity_calculate('<?= $invoice['sl'] ?>');" onchange="quantity_calculate('<?= $invoice['sl'] ?>');" value="<?= $invoice['rate'] ?>" id="price_item_<?= $invoice['sl'] ?>" class="price_item<?= $invoice['sl'] ?> form-control text-right" min="0" tabindex="5" required="" placeholder="0.00" readonly=""/>
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text"  onkeyup="quantity_calculate('<?= $invoice['sl'] ?>');"  onchange="quantity_calculate('<?= $invoice['sl'] ?>');" id="discount_<?= $invoice['sl'] ?>" class="form-control text-right" placeholder="0.00" value="" min="0" tabindex="6"/>

                                            <input type="hidden" value="<?php echo $discount_type ?>" name="discount_type" id="discount_type_<?= $invoice['sl'] ?>">
                                        </td>

                                        <td>
                                            <input class="total_price form-control text-right" type="text"  id="total_price_<?= $invoice['sl'] ?>" value="" readonly="readonly" />

                                            <input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="<?= $invoice['invoice_details_id'] ?>"/>
                                        </td>
                                         <td>

                                            <!-- Tax calculate start-->
                                            <input id="total_tax_<?= $invoice['sl'] ?>" class="total_tax_<?= $invoice['sl'] ?>" type="hidden" value="<?= $invoice['tax'] ?>">
                                            <input id="all_tax_<?= $invoice['sl'] ?>" class="total_tax" type="hidden" value="0" name="tax[]">
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_<?= $invoice['sl'] ?>" class="" value=""/>

                                            <input type="hidden" id="all_discount_<?= $invoice['sl'] ?>" class="total_discount" value="" />
                                            <!-- Discount calculate end -->
                                            
                                            <input type="checkbox" name='rtn[]' onclick="checkboxcheck('<?= $invoice['sl'] ?>')" id="check_id_<?= $invoice['sl'] ?>" value="<?= $invoice['sl'] ?>" class="chk" >


                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                                
                                <tfoot>
                                    
                                    <tr>
                                        <td colspan="4" rowspan="3">
                                           <center><label style="text-align:center;" for="details" class="  col-form-label"><?php echo display('reason') ?></label></center>
                                             <textarea class="form-control" name="details" id="details" placeholder="<?php echo display('reason') ?>"></textarea> <br>
                                             <span style="text-align:left;font-size:15px;color: green;font-weight: bold;"><?php echo display('usablilties')?> </span><br>
                                             <label class="ab"><?php echo display('adjs_with_stck')?>
  <input type="radio" checked="checked" name="radio" value="1">
  <span class="checkmark"></span>
</label><br>
                                             
                                             <label class="ab"><?php echo display('return_to_supplier')?>
   <input type="radio"  name="radio" value="2">
  <span class="checkmark"></span>
</label><br>
                                           <label class="ab"><?php echo display('wastage')?>
   <input type="radio"  name="radio" value="3">
  <span class="checkmark"></span>
</label>

                                        </td>
                                        <td style="text-align:right;" colspan="1"><b><?php echo display('to_deduction') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="" readonly="readonly" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right;" colspan="1" ><b><?php echo display('total_tax') ?>:</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_ammount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="<?= $invoice['total_tax'] ?>" readonly="readonly" aria-invalid="false" type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1"  style="text-align:right;"><b><?php echo display('nt_return') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="" readonly="readonly" />
                                        </td>
                                         <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                            <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice['invoice_id'] ?>"/>
                                    </tr>
                                 
                                   
                                </tfoot>
                            </table>
                        </div>
                         <div class="form-group row">
                            <label for="example-text-input" class=" col-form-label"></label>
                            <div class="col-sm-12 text-right">
                                
                                           
                                            <input type="submit" id="add_invoice" class="btn btn-success btn-large" name="add-invoice" value="<?php echo display('return') ?>" tabindex="9"/>
                               
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>


<style type="text/css">
    .btn:focus {
      background-color: #6A5ACD;
    }
</style>

<script type="text/javascript">
    function checkboxcheck(sl){
        var check_id    ='check_id_'+sl;
        var total_qntt  ='total_qntt_'+sl;
        var product_id  ='product_id_'+sl;
        var total_price  ='total_price_'+sl;
        var discount  ='discount_'+sl;
            if($('#'+check_id).prop("checked") == true){
                document.getElementById(total_qntt).setAttribute("required","required");
                document.getElementById(product_id).setAttribute("name","product_id[]");
                 document.getElementById(total_qntt).setAttribute("name","product_quantity[]");
                  document.getElementById(total_price).setAttribute("name","total_price[]");
                   document.getElementById(discount).setAttribute("name","discount[]");
            }
            else if($('#'+check_id).prop("checked") == false){
                document.getElementById(total_qntt).removeAttribute("required");
                document.getElementById(product_id).removeAttribute("name","");
                document.getElementById(total_qntt).removeAttribute("name","");
                document.getElementById(total_price).setAttribute("name","total_price[]");
                  document.getElementById(discount).setAttribute("name","");
            }
        };

   
</script>
<!-- script for checkbox css -->
<script type="text/javascript">
      $(document).ready(function() {
      $('input[type=checkbox]').each(function() {
        if(this.nextSibling.nodeName != 'label') {
          $(this).after('<label for="'+this.id+'"></label>')
        }
      })
    })
</script>

<script type="text/javascript">
    $('#add_invoice').prop("disabled", true);
$('input:checkbox').click(function() {
        if ($(this).is(':checked')) {
            $('#add_invoice').prop("disabled", false);
        } else {
        if ($('.chk').filter(':checked').length < 1){
            $('#add_invoice').attr('disabled',true);}
        }
});
</script>

