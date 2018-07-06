<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>
<!-- Add new invoice start -->
<style>
	#bank_info_hide
	{
		display:none;
	}
    #payment_from_2
    {
        display:none;
    }
</style>
<?php

function json_change_key($arr, $oldkey, $newkey) {
	$json = str_replace('"'.$oldkey.'":', '"'.$newkey.'":', json_encode($arr));
	return json_decode($json);	
}
?>
<script>


</script>
<!-- Customer type change by javascript start -->
<script type="text/javascript">
	function bank_info_show(payment_type)
	{
	    if(payment_type.value=="1"){
	        document.getElementById("bank_info_hide").style.display="none";
	    }
	    else{ 
	        document.getElementById("bank_info_hide").style.display="block";  
	    }
	}
        
    function active_customer(status)
    {
	    if(status=="payment_from_2"){
	        document.getElementById("payment_from_2").style.display="none";
	        document.getElementById("payment_from_1").style.display="block";
	        document.getElementById("myRadioButton_2").checked = false;
	        document.getElementById("myRadioButton_1").checked = true;
	    }
	    else{
	        document.getElementById("payment_from_1").style.display="none";
	        document.getElementById("payment_from_2").style.display="block";
	        document.getElementById("myRadioButton_2").checked = false;
	        document.getElementById("myRadioButton_1").checked = true;
	    }
    }
</script>
<!-- Customer type change by javascript end -->

  
        <!-- Alert Message -->
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
        <div class="row">
            <div class="col-sm-12">
                  <a href="<?php echo base_url('dashboard_pharmacist/invoice/Cinvoice/manage_invoice')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_invoice')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/invoice/Cinvoice/pos_invoice')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('pos_invoice')?> </a>

                
            </div>
        </div>


        <!--Add Invoice -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('new_invoice') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('dashboard_pharmacist/invoice/Cinvoice/insert_invoice',array('class' => 'form-vertical', 'id' => '','name' => ''))?>
                    <div class="panel-body">
                        <div class="row">

                        	<div class="col-sm-8" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input type="text" size="100"  name="customer_name" class="customerSelection form-control" placeholder='<?php echo display('customer_name') ?>' id="customer_name" tabindex="1" />

                                        <input id="SchoolHiddenId" class="customer_hidden_value abc" type="hidden" name="customer_id">
                                    </div>
                                    <div  class=" col-sm-3">
                                        <input id="myRadioButton_1" type="button" onClick="active_customer('payment_from_1')" id="myRadioButton_1" class="btn btn-success checkbox_account ac" name="customer_confirm" checked="checked" value="<?php echo display('add_customer') ?>" tabindex="2">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8" id="payment_from_2">
                               <div class="form-group row">
                                    <label for="customer_name_others" class="col-sm-3 col-form-label"><?php echo display('payee_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input  autofill="off" type="text"  size="100" name="customer_name_others" placeholder='<?php echo display('payee_name') ?>' id="customer_name_others" class="form-control" />
                                    </div>

                                    <div  class="col-sm-3">
                                        <input  onClick="active_customer('payment_from_2')" type="button" id="myRadioButton_2" class="checkbox_account btn btn-success" name="customer_confirm_others" value="<?php echo display('old_customer') ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="customer_name_others_address" class="col-sm-3 col-form-label"><?php echo display('address') ?> </label>
                                    <div class="col-sm-6">
                                       <input type="text"  size="100" name="customer_name_others_address" class=" form-control" placeholder='<?php echo display('address') ?>' id="customer_name_others_address" />
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                        	<div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <?php $date = date('Y-m-d'); ?>
                                        <input class="datepicker form-control" type="text" size="50" name="invoice_date" id="date" required value="<?php echo $date; ?>" tabindex="6" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4"><?php echo display('onaid') ?></label>
                                <div class="col-xs-8">
                                    <div class="checkbox checkbox-success">
                                            <input id="admission_id" name="admission_id" type="checkbox" >
                                            <label for="admission_id"><?php echo display("onaid") ?></label>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 220px"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="130"><?php echo display('batch_id') ?></th>
                                        <th class="text-center"><?php echo display('available_qnty') ?></th>
                                        <th class="text-center" width="120"><?php echo display('expire_date') ?></th>
                                        <th class="text-center"><?php echo display('unit') ?></th>
                                        <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>

                                        <?php if ($discount_type == 1) { ?>
                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                        <?php }elseif($discount_type == 2){ ?>
                                        <th class="text-center"><?php echo display('discount') ?> </th>
                                        <?php }elseif($discount_type == 3) { ?>
                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>

                                        <th class="text-center"><?php echo display('total') ?> 
                                        </th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    <tr>
                                        <td style="width: 220px">
                                            <input type="text" name="product_name" onkeyup="invoice_productList(1);" class="form-control productSelection" placeholder='<?php echo display('medicine_name') ?>' required="" id="product_name" tabindex="7"  >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId" />

                                            <input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
                                        </td>
                                        <td>
                                            <select class="form-control dont-select-me" id="batch_id_1" name="batch_id[]" required onchange="product_stock(1)">
                                                <option></option>
                                            </select>     
                                        </td>
                                        <td>
                                            <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_1" value="0" readonly="" id="available_quantity_1"/>
                                        </td>
                                        <td id="expire_date_1">
                                           
                                        </td>
                                        <td>
                                            <input name="" id="" class="form-control text-right unit_1 valid" value="None" readonly="" aria-invalid="false" type="text">
                                        </td>
                                        <td>
                                            <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" class="total_qntt_1 form-control text-right" id="total_qntt_1" placeholder="0.00" min="0" tabindex="8" />
                                        </td>
                                        <td>
                                            <input type="text" name="product_rate[]" id="price_item_1" class="price_item1 price_item form-control text-right" tabindex="9" required="" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" placeholder="0.00" min="0" />
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text" name="discount[]" onkeyup="quantity_calculate(1);"  onchange="quantity_calculate(1);" id="discount_1" class="form-control text-right" min="0" tabindex="10" placeholder="0.00"/>

                                            <input type="hidden" value="" name="discount_type" id="discount_type_1">
                                        </td>

                                       
                                        <td style="width: 100px">
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                        </td>

                                        <td>
                                            <!-- Tax calculate start-->
                                            <input id="total_tax_1" class="total_tax_1" type="hidden">
                                            <input id="all_tax_1" class="total_tax" type="hidden" name="tax[]">
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_1" class="" />
                                            <input type="hidden" id="all_discount_1" class="total_discount"/>
                                            <!-- Discount calculate end -->

                                            <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="11"><?php //echo display('delete')?><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr><td colspan="7" rowspan="2">
                                        <center><label style="text-align:center;" for="details" class="  col-form-label"><?php echo display('invoice_details') ?></label></center>
                                        <textarea name="inva_details" class="form-control" placeholder="<?php echo display('invoice_details') ?>"></textarea>
                                    </td>
                                        <td style="text-align:right;" colspan="1"><b><?php echo display('total_tax') ?>:</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_ammount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="0.00" readonly="readonly" aria-invalid="false" type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right;" colspan="1"><b><?php echo display('total_discount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addInputField('addinvoiceItem');" value="<?php echo display('add_new_item') ?>" tabindex="12"/>

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                        <td style="text-align:right;" colspan="7"><b><?php echo display('paid_ammount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="paidAmount" 
                                            onkeyup="invoice_paidamount();" class="form-control text-right" name="paid_amount" placeholder="0.00" tabindex="13"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="button" id="full_paid_tab" class="btn btn-warning" value="<?php echo display('full_paid') ?>" tabindex="14" onClick="full_paid()"/>

                                            <input type="submit" id="add_invoice" class="btn btn-success" name="add-invoice" value="<?php echo display('submit') ?>" tabindex="15"/>
                                        </td>

                                        <td style="text-align:right;" colspan="7"><b><?php echo display('due') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="0.00" readonly="readonly"/>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>

<script type="text/javascript">
    $('.ac').click(function () { 
     $('.customer_hidden_value').val('');
 });
$('#myRadioButton_1').click(function () {
     $('#customer_name').val('');
 });

$('#myRadioButton_2').click(function () {
     $('#customer_name_others').val('');
 });
$('#myRadioButton_2').click(function () {
     $('#customer_name_others_address').val('');
 });

</script>
<script type="text/javascript">

function product_stock(sl) {
          
            var  batch_id=$('#batch_id_'+sl).val();
            var dataString = 'batch_id='+ batch_id;
            var base_url    = $('.baseUrl').val();
            var available_quantity    = 'available_quantity_'+sl;
            var product_rate    = 'product_rate_'+sl;
            var expire_date    = 'expire_date_'+sl;
             $.ajax({
                type: "POST",
                url: base_url+"dashboard_pharmacist/invoice/Cinvoice/retrieve_product_batchid",
                data: dataString,
                cache: false,
                success: function(data)
                {
                    obj = JSON.parse(data);

                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();

                    if(dd<10){
                        dd='0'+dd;
                    } 
                    if(mm<10){
                        mm='0'+mm;
                    }
                    var today = yyyy+'-'+mm+'-'+dd;

                    aj = new Date(today);
                    exp = new Date(obj.expire_date);

                    // alert(today);

                    if (aj >= exp) {
                        

                        $('#'+expire_date).html('<p style="color:red;align:center">'+obj.expire_date+'</p>');
                          
                    }else{
                       $('#'+expire_date).html('<p style="color:green;align:center">'+obj.expire_date+'</p>');
                    }
                    $('#'+available_quantity).val(obj.total_product);
                   
                } 
             });

            $(this).unbind("change");
            return false;
     
  

}
$('#customer_name').blur(function(){
        var pid = $(this);
        var p = $(this).val();
        var x = p.substr(p.length - 9).replace(")","")
        $.ajax({
            url  : '<?= base_url('dashboard_pharmacist/patient/Cpatient/check_patient/') ?>',
            type : 'post',
            dataType : 'JSON',
            data : {
                '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                patient_id : x
            },
            success : function(data) 
            {
                // if (data.status == true) {
                //     pid.next().text(data.message).addClass('text-success').removeClass('text-danger');
                // } else if (data.status == false) {
                //     pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                // } else {
                //     pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                // }
                if(data.admission_id == true){
                    $('#admission_id').prop('checked', true)
                }else{
                    $('#admission_id').prop('checked', false);
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });
</script>
