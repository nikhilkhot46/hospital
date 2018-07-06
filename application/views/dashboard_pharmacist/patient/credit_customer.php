
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
                  <a href="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/paid_customer')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer')?> </a>

            </div>
        </div>

	    <!-- Manage credit customer -->
	   	<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 

						<form action="<?php echo base_url('dashboard_pharmacist/patient/Cpatient/credit_customer_search_item')?>" class="form-inline" method="post" accept-charset="utf-8">
							<style>
							.select2-container {
								width: 300px !important;
							}
							</style>
		                    <label class="select"><?php echo display('customer_name')?>:</label>
							<select class="form-control" name="customer_id">
							<?php 
							
							foreach ($all_credit_customer_list as $customer) {
							?>
							<option value="<?php echo $customer['patient_id']?>"><?php echo $customer['firstname']." ".$customer['lastname'] ?></option>
							<?php
							}
							?>
                            </select>

							<button type="submit" class="btn btn-primary"><?php echo display('search')?></button>
		                	
			            </form>		            
			        </div>
		        </div>
		    </div>
	    </div>

		<!-- Manage Customer -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('credit_customer') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('customer_name') ?></th>
										<th><?php echo display('address') ?></th>
										<th><?php echo display('mobile') ?></th>
										<th style="text-align:right !Important"><?php echo display('balance') ?></th>
										<th style="text-align:center !Important"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($customers_list) {
								?><?php
								foreach($customers_list as $custlist){?>
									<tr>
										<td><?php echo $custlist['sl'];?></td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/patient/Cpatient/customerledger/'.$custlist['patient_id']; ?>"><?php echo $custlist['firstname']." ".$custlist['lastname']; ?></a>				
										</td>
										<td><?php echo $custlist['address']; ?></td>
										<td><?php echo $custlist['mobile']; ?></td>
										<td style="text-align:right !Important"> <?php echo (($position==0)?"$currency ".number_format($custlist['customer_balance'], 2, '.', ','):number_format($custlist['customer_balance'], 2, '.', ',')." $currency"); ?></td>
										<td>
											<center>
											<?php echo form_open()?>
												<a href="<?php echo base_url().'dashboard_pharmacist/patient/Cpatient/customer_update_form/'.$custlist['patient_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="" class="deleteCustomer btn btn-danger btn-sm" name="<?php echo $custlist['patient_id']?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>

											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								<?php }?>
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td style="text-align:right !Important" colspan="4"><b> <?php echo display('grand_total') ?></b></td>
										<td style="text-align:right !Important">
											<b><?php echo (($position==0)?$currency." ".$subtotal:$subtotal." ".$currency) ?></b>
										</td>
										<td></td>
									</tr>
								</tfoot>
		                    </table>
		                    <div class="text-right"><?php echo $links?></div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
<!-- Delete Customer ajax code -->
<script type="text/javascript">
	//Delete Customer 
	$(".deleteCustomer").click(function()
	{	
		var customer_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
		   ({
				type: "POST",
				url: '<?php echo base_url('dashboard_pharmacist/patient/Cpatient/customer_delete')?>',
				data: {customer_id:customer_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
				} 
			});
		}
	});
</script>