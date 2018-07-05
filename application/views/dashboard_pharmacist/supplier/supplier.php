
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
                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_ledger_report')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_sales_details_all')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details')?> </a>

            </div>
        </div>

		<!-- Manage Supplier -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_suppiler') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('supplier_id') ?></th>
										<th><?php echo display('supplier_name') ?></th>
										<th><?php echo display('address') ?></th>
										<th><?php echo display('mobile') ?></th>
										<th><?php echo display('details') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($suppliers_list) {
								
										foreach ($suppliers_list as $supplier) {
											?>
											<tr>
										<td><?= $supplier->supplier_id ?></td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/supplier/Csupplier/supplier_ledger_info/'.$supplier->supplier_id ?>">
											<?= $supplier->supplier_name ?>
											</a>
										</td>
										<td><?= $supplier->address ?></td>
										<td><?= $supplier->mobile ?></td>
										<td><?= $supplier->details ?></td>
										<td>
											<center>
												<a href="<?php echo base_url().'dashboard_pharmacist/supplier/Csupplier/supplier_update_form/'.$supplier->supplier_id; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="" class="deleteSupplier btn btn-danger btn-sm" name="<?= $supplier->supplier_id ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>

											</center>
										</td>
									</tr>
											<?php
										}
									}
								?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

<!-- Delete Product ajax code -->
<script type="text/javascript">
	//Delete Supplier 
	$(".deleteSupplier").click(function()
	{	
		var supplier_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url: '<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_delete')?>',
			data: {supplier_id:supplier_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				
			} 
		});
		}
	});
</script>