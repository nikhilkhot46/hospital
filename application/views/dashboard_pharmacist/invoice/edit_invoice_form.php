<!-- Customer js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Product invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>

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
                            <h4><?php echo display('invoice_edit') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open('dashboard_pharmacist/invoice/Cinvoice/invoice_update',array('class' => 'form-vertical','id'=>'invoice_update' ))?>
                    <div class="panel-body">
             
                        <div class="row">
                            <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                       <input type="text" name="customer_name" value="<?= $customer_name ?>" class="form-control customerSelection" placeholder='<?php echo display('customer_name') ?>' required id="customer_name" tabindex="1">

                                        <input type="hidden" class="customer_hidden_value" name="customer_id" value="<?= $customer_id?>" id="SchoolHiddenId"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control datepicker" name="invoice_date" value="<?= $date ?>"  required />
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
                                            <input <?= $admission_id!=""?"checked":""?> id="admission_id" name="admission_id" type="checkbox" >
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
                                        <th class="text-center" width="80"><?php echo display('expire_date') ?></th>
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
                                <?php
                                if ($invoice_all_data) {
                                    foreach ($invoice_all_data as $invoice) {
                                        $batch_info = $this->db->select('batch_id')
                                                        ->from('product_purchase_details')
                                                        ->where('product_id',$invoice['product_id'])
                                                        ->get()
                                                        ->result();
                                ?>
                                <?php 

                               $expire = $this->db->select('expeire_date')
                                                        ->from('product_purchase_details')
                                                        ->where('batch_id',$invoice['batch_id'])
                                                        ->group_by('batch_id')
                                                        ->get()
                                                        ->result();

                                ?>
                                    <tr>
                                        <td class="" style="width: 200px;">
                                            <input type="text" name="product_name" onclick="invoice_productList(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['product_name']?>-(<?php echo $invoice['product_model']?>)" class="form-control productSelection" required placeholder='<?php echo display('product_name') ?>' id="product_names" tabindex="3">

                                            <input type="hidden" class="product_id_<?php echo $invoice['sl']?> autocomplete_hidden_value" name="product_id[]" value="<?php echo $invoice['product_id']?>" id="SchoolHiddenId"/>
                                        </td>
                                        <td>
                                            <select name="batch_id[]" id="batch_id_<?php echo $invoice['sl']?>" class="form-control" required="" onchange="product_stock(<?php echo $invoice['sl']?>)">
                                                <?php foreach ($batch_info as $batch) {?>
                                                <option value="<?php echo $batch->batch_id; ?>" <?php if ($batch->batch_id == $invoice['batch_id']) {echo "selected"; }?>><?php echo $batch->batch_id; ?></option>
                                                <?php }?>
                                            </select>   
                                        </td>
                                        <td>
                                            <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_<?php echo $invoice['sl']?>" value="0" readonly="" id="available_quantity_<?php echo $invoice['sl']?>"/>
                                        </td>
                                        <td id="expire_date_<?php echo $invoice['sl']?>">
                                            <?php foreach ($expire as $vale) {
                                                echo $vale->expeire_date;
                                            }?>
                                        </td>
                                         <td>
                                            <input name="" id="" class="form-control text-right unit_<?php echo $invoice['sl']?> valid" value="<?php echo $invoice['unit']?>" readonly="" aria-invalid="false" type="text">
                                        </td>
                                        <td>
                                            <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['quantity']?>" class="total_qntt_<?php echo $invoice['sl']?> form-control text-right" id="total_qntt_<?php echo $invoice['sl']?>" min="0" placeholder="0.00" tabindex="4" />
                                        </td>

                                        <td>
                                            <input type="text" name="product_rate[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['rate']?>" id="price_item_<?php echo $invoice['sl']?>" class="price_item<?php echo $invoice['sl']?> form-control text-right" min="0" tabindex="5" required="" placeholder="0.00"/>
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text" name="discount[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>);"  onchange="quantity_calculate(<?php echo $invoice['sl']?>);" id="discount_<?php echo $invoice['sl']?>" class="form-control text-right" placeholder="0.00" value="<?php echo $invoice['discount']?>" min="0" tabindex="6"/>

                                            <input type="hidden" value="<?php echo $discount_type?>" name="discount_type" id="discount_type_<?php echo $invoice['sl']?>">
                                        </td>

                                        <td>
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $invoice['sl']?>" value="<?php echo $invoice['total_price']?>" readonly="readonly" />

                                            <input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="<?php echo $invoice['invoice_details_id']?>"/>
                                        </td>
                                         <td>

                                            <!-- Tax calculate start-->
                                            <input id="total_tax_<?php echo $invoice['sl']?>" class="total_tax_<?php echo $invoice['sl']?>" type="hidden" value="<?php echo $invoice['tax']?>">

                                            <input id="all_tax_<?php echo $invoice['sl']?>" class="total_tax" name="tax[]" type="hidden" value="<?php echo $invoice['t_p_tax'];?>">
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_<?php echo $invoice['sl']?>" class="" value="<?php echo $invoice['discount']?>"/>

                                            <input type="hidden" id="all_discount_<?php echo $invoice['sl']?>" class="total_discount" value="<?php echo $invoice['discount'] * $invoice['quantity']?>" />
                                            <!-- Discount calculate end -->

                                            <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="7"><i class="fa fa-trash"></i><?php //echo display('delete')?></button>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                                
                                <tfoot>
                                    
                                    <tr>
                                        <td colspan="7" rowspan="2">
                                        <center><label style="text-align:center;" for="details" class="  col-form-label"><?php echo display('invoice_details') ?></label></center>
                                        <textarea name="inva_details" class="form-control" placeholder="<?php echo display('invoice_details') ?>"><?= $invoice_details ?></textarea>
                                    </td>
                                        <td style="text-align:right;" colspan="1"><b><?php echo display('total_discount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="<?= $total_discount?>" readonly="readonly" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right;" colspan="1"><b><?php echo display('total_tax') ?>:</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_ammount" class="form-control text-right" name="total_tax" value="<?= $total_tax ?>" readonly="readonly" type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="<?= $total_amount ?>" readonly="readonly" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="2">
                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                            <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice_id?>"/>
                                             
                                           <input type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="editInputField('addinvoiceItem');" value="<?php echo display('add_new_item') ?>" tabindex="12"/>
                                           

                                        </td>
                                        <td style="text-align:right;" colspan="6"><b><?php echo display('paid_ammount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="paidAmount" 
                                            onkeyup="invoice_paidamount();" class="form-control text-right" name="paid_amount" value="<?= $paid_amount?>" tabindex="8" placeholder="0.00" />
                                        </td>
                                    </tr>
                                    <tr>

                                        <td align="center" colspan="2">
                                              <input type="button" id="full_paid_tab" class="btn btn-warning" value="<?php echo display('full_paid') ?>" tabindex="14" onClick="full_paid()"/> 

                                            <?php
                                            $this->db->select('bill_generated');
                                            $this->db->from('invoice_details');
                                            $this->db->where('invoice_id', $invoice_id);
                                            $query = $this->db->get()->row();
                                            
                                            if($query->bill_generated == 0){
                                            ?>
                                            <input type="submit" id="add-invoice" class="btn btn-success btn-large" name="add-invoice" value="<?php echo display('save_changes') ?>" tabindex="9"/>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                      
                                        <td style="text-align:right;" colspan="6"><b><?php echo display('due') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="<?= $due_amount?>" readonly="readonly"/>
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

<style type="text/css">
    .btn:focus {
      background-color: #6A5ACD;
    }
</style>

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

</script>
