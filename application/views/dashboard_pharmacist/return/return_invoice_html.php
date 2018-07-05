<?php
    $CI =& get_instance();
    $CI->load->model('Setting_model');
    $Web_settings = $CI->Setting_model->retrieve_setting_editdata();
?>

<!-- Printable area start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	// document.body.style.marginTop="-45px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<!-- Printable area end -->

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
                <div class="panel panel-bd">
	                <div id="printableArea">
	                    <div class="panel-body">
	                        <div class="row">
	                        	
	                            <div class="col-sm-8" style="display: inline-block;width: 64%">
	                                 <img src="../../../<?php if (isset($Web_settings[0]['logo'])) {echo $Web_settings[0]['logo']; }?>" class="" alt="" style="margin-bottom:20px">
	                                <br>
	                                <span class="label label-success-outline m-r-15 p-10" ><?php echo display('billing_from') ?></span>
	                                <address style="margin-top:10px">
	                                    <strong><?= $company_info[0]['title']?></strong><br>
	                                    <?= $company_info[0]['description']?><br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr> <?= $company_info[0]['phone']?><br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr> 
	                                    <?= $company_info[0]['email']?><br>
	                                    <abbr><b><?php echo display('website') ?>:</b></abbr> 
	                                    <?= $company_info[0]['website']?>
	                                </address>
	                            </div>
	                            <div class="col-sm-4 text-left" style="display: inline-block;margin-left: 5px;">
	                                <h2 class="m-t-0"><?php echo display('return') ?></h2>
	                                <div><?php echo display('return_id') ?>: <?= $invoice_no ?></div>
	                                 <div><?php echo display('invoice_id') ?>: <?= $invoice_id ?></div>
	                                <div class="m-b-15"><?php echo display('billing_date') ?>: <?= $final_date ?></div>

	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>

	                                  <address style="margin-top:10px;width: 200px">  
	                                    <strong><?= $customer_name ?> </strong><br>
	                                    <?php if ($customer_address) { ?>
		                                <?= $customer_address ?>
		                                <?php } ?>
	                                    <br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr>
	                                    <?php if ($customer_mobile) { ?>
	                                    <?= $customer_mobile ?>
	                                    <?php }if ($customer_email) {
	                                    ?>
	                                    <br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr> 
	                                    <?= $customer_email ?>
	                                   	<?php } ?>
	                                </address>
	                            </div>
	                        </div> <hr>

	                        <div class="table-responsive m-b-20">
	                            <table class="table table-striped table-bordered">
	                                <thead>
	                                    <tr>
	                                        <th class="text-center"><?php echo display('sl') ?></th>
	                                        <th class="text-center"><?php echo display('product_name') ?></th>
	                                        <th class="text-center"><?php echo display('quantity') ?></th>
	                                        
	                                        <?php if ($discount_type == 1) { ?>
	                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
	                                        <?php }elseif($discount_type == 2){ ?>
	                                        <th class="text-center"><?php echo display('discount') ?> </th>
	                                        <?php }elseif($discount_type == 3) { ?>
	                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
	                                        <?php } ?>

	                                        <th class="text-center"><?php echo display('rate') ?></th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                    </tr>
	                                </thead>
	                                <tbody>
									<?php
									foreach ($invoice_all_data as $inv) {
									?>
										
										<tr>
	                                    	<td class="text-center"><?= $inv['sl'] ?></td>
	                                        <td class="text-center"><div><strong><?= $inv['product_name'] ?> - (<?= $inv['product_model'] ?>)</strong></div></td>
	                                        <td align="center"><?= $inv['ret_qty'] ?></td>

	                                        <?php if ($discount_type == 1) { ?>
	                                        <td align="center"><?= $inv['deduction'] ?></td>
	                                        <?php }else{ ?>
	                                        <td align="center"><?php echo (($position==0)?$currency." ".$inv['deduction']:$inv['deduction']." ".$currency) ?></td>
	                                        <?php } ?>
	                                        
	                                        <td align="center"><?php echo (($position==0)?$currency." ".$inv['product_rate']:$inv['product_rate']." ".$currency) ?></td>
	                                        <td align="center"><?php echo (($position==0)?$currency." ".$inv['total_ret_amount']:$inv['total_ret_amount']." ".$currency) ?></td>
	                                    </tr>
									<?php
									}
									?>
	                                </tbody>
	                                <tfoot>
	                                	<td align="center" colspan="1" style="border: 0px"><b><?php echo display('grand_total')?>:</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td align="center"  style="border: 0px"><b><?= $subTotal_quantity ?></b></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	
	                                	<td align="center"  style="border: 0px"><b><?php echo (($position==0)?$currency." ".$subTotal_ammount:$subTotal_ammount." ".$currency) ?></b></td>
	                                </tfoot>
	                            </table>
	                        </div>
	                        <div class="row">
		                        
		                        	<div class="col-xs-8" style="display: inline-block;width: 66%">
		                                <p><strong>Note : </strong><?= $note ?></p>
		                                
		                                <div  style="float:left;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 110px;font-weight: bold;">
												<?php echo display('received_by') ?>
										</div>
		                            </div>
		                            <div class="col-xs-4" style="display: inline-block;">

				                        <table class="table">
				                            <?php
			                                	if ($invoice_all_data[0]['total_deduct'] != 0) {
			                                ?>
				                            	<tr>
				                            		<th style="border-top: 0; border-bottom: 0;"><?php echo display('deduction') ?> : </th>
				                            		<td style="border-top: 0; border-bottom: 0;"><?php echo (($position==0)?$currency." ".$total_deduct:$total_deduct." ".$currency) ?> </td>
				                            	</tr>
				                            <?php } 
				                              	if ($invoice_all_data[0]['total_tax'] != 0) {
			                                ?>
				                            	<tr>
				                            		<th style="border-top: 0; border-bottom: 0;"><?php echo display('tax') ?> : </th>
				                            		<td style="border-top: 0; border-bottom: 0;"><?php echo (($position==0)?$currency." ".total_tax:$total_tax." ".$currency) ?> </td>
				                            	</tr>
				                            <?php } ?>
				                            	<tr>
				                            		<th class="grand_total"><?php echo display('grand_total') ?> :</th>
				                            		<td class="grand_total"><?php echo (($position==0)?$currency." ".$total_amount:$total_amount." ".$currency) ?></td>
				                            	</tr>
				                            	
			                            </table>
		                   
		                                <div  style="float:left;width:90%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
												<?php echo display('authorised_by') ?>
										</div>
		                            
		                        </div>
	                        </div>
	                    </div>
	                </div>

                     <div class="panel-footer text-left">
                     	<a  class="btn btn-danger" href="<?php echo base_url('Cretrun_m');?>"><?php echo display('cancel') ?></a>
						<button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
						
                    </div>
                </div>
            </div>
        </div>