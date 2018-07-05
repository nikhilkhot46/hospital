
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

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/manage_supplier')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_ledger_report')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_sales_details_all')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details')?> </a>

            </div>
        </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left">
							<h2><?= $supplier_name ?></h2>
							<h4><?= $supplier_mobile ?></h4>
							<h5><?= $supplier_address ?></h5>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Manage Supplier -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('supplier_ledger') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('invoice_no') ?></th>
										<th><?php echo display('details') ?></th>
										<th><?php echo display('ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($purchase_info) {
										foreach ($purchase_info as $purchase) {
								?>
									<tr>
										<td><?= $purchase['final_date'] ?></td>
										<td>
											<a href="<?php echo base_url().'dashboard_pharmacist/purchase/Cpurchase/purchase_details_data/'.$purchase['purchase_id']; ?>">
												<?= $purchase['chalan_no'] ?>
											</a>
										</td>
										<td><?= $purchase['purchase_details'] ?></td>
										<td><?php echo (($position==0)?$currency." ".$purchase['grand_total_amount']:$purchase['grand_total_amount']." ".$currency) ?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" class="text-right"><b><?php echo display('grand_total')?>:</b></td>
										<td><b><?php echo (($position==0)?$currency." ".$total_amount:$total_amount." ".$currency) ?></b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>