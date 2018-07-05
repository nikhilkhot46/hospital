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

<!-- Add New Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('new_pos_invoice') ?></h1>
            <small><?php echo display('add_new_pos_invoice') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('Invoice') ?></a></li>
                <li class="active"><?php echo display('new_pos_invoice') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

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
                <div class="column">
                
                  <a href="<?php echo base_url('Cinvoice')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('new_invoice')?> </a>

                  <a href="<?php echo base_url('Cinvoice/manage_invoice')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('manage_invoice')?> </a>

                </div>
            </div>
        </div>

        <!-- POS Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('new_pos_invoice') ?></h4>
                        </div>
                    </div>
                  
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="add_item" class="col-sm-4 col-form-label"><?php echo display('barcode') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="product_name" class="form-control" placeholder='<?php echo display('barcode_qrcode_scan_here') ?>' id="add_item" autocomplete='off' tabindex="1">
                                        <input type="hidden" id="product_value" name="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo form_open_multipart('Cinvoice/insert_invoice',array('class' => 'form-vertical', 'id' => '','name' => 'insert_pos_invoice'))?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_date" class="col-sm-4 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <?php date_default_timezone_set("Asia/Dhaka"); $date = date('Y-m-d'); ?>
                                        <input class="form-control" type="text" size="50" id="invoice_date" name="invoice_date" required value="<?php echo $date; ?>" tabindex="2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="customer_name1" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                       <input type="text" size="100"  name="customer_name" class="customerSelection form-control" placeholder='<?php echo display('customer_name') ?>' id="customer_name1" value="{customer_name}" tabindex="3"/>

                                        <input id="SchoolHiddenId" class="customer_hidden_value" type="hidden" name="customer_id" value="{customer_id}">
                                        <?php
                                        if (empty($customer_name)) {
                                        ?>
                                        <small id="emailHelp" class="text-danger"><?php echo display('please_add_walking_customer_for_default_customer')?></small>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div  class="col-sm-3">
                                        <input id="myRadioButton_1" type="button" onClick="active_customer('payment_from_1')" id="myRadioButton_1" class="btn btn-success checkbox_account" name="customer_confirm" checked="checked" value="<?php echo display('new_customer') ?> " tabindex="4">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-8" id="payment_from_2">
                               <div class="form-group row">
                                    <label for="customer_name_others" class="col-sm-3 col-form-label"><?php echo display('payee_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                       <input  autofill="off" type="text"  size="100" name="customer_name_others" placeholder='<?php echo display('payee_name') ?>' id="customer_name_others" class="form-control" tabindex="5"/>
                                    </div>

                                    <div  class="col-sm-3">
                                        <input  onClick="active_customer('payment_from_2')" type="button" id="myRadioButton_2" class="btn btn-success checkbox_account" name="customer_confirm_others" value="<?php echo display('old_customer') ?> ">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="customer_name_others_address" class="col-sm-3 col-form-label"><?php echo display('address') ?></label>
                                    <div class="col-sm-6">
                                       <input type="text"  size="100" name="customer_name_others_address" class=" form-control" placeholder='<?php echo display('address') ?>' id="customer_name_others_address" tabindex="6"/>
                                    </div>
                                </div> 
                            </div>
                        </div>
                     
                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="addinvoice">
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
                                    <tr></tr>
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
                    <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- POS Invoice Report End -->

<script type="text/javascript">

    //Onload filed select
    window.onload = function(){
      var text_input = document.getElementById ('add_item');
      text_input.focus ();
      text_input.select ();
    }

    //Invoice js
    $('#add_item').keydown(function(e) {
        if (e.keyCode == 13) {
            var product_id = $(this).val();
            $.ajax({
                type: "post",
                async: false, 
                url: '<?php echo base_url('Cinvoice/insert_pos_invoice')?>',
                data: {product_id: product_id},
                success: function(data) {
                    if (data == false) {
                        alert('This Product Not Found !');
                        document.getElementById('add_item').value = '';
                        document.getElementById('add_item').focus();
                        calculateSum();
                        invoice_paidamount();
                    }else{
                        $("#hidden_tr").css("display", "none");
                        document.getElementById('add_item').value = '';
                        document.getElementById('add_item').focus();
                        $('#addinvoice tbody').append(data);
                        calculateSum();
                        invoice_paidamount();
                    }
                },
                error: function() {
                    alert('Request Failed, Please check your code and try again!');
                }
            });
        }
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
                url: base_url+"Cinvoice/retrieve_product_batchid",
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




</script>