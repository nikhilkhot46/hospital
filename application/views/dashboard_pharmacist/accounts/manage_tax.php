
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

		<!-- Manage TAX -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_tax') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('tax') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($tax_list) {
										foreach ($tax_list as $tax) {
								?>
									<tr>
										<td><?= $tax->tax_id ?></td>
										<td><?= $tax->tax ?> %</td>
						                <td>
						                    <center>
					                            <a href="<?php echo base_url().'dashboard_pharmacist/accounts/Caccounts/tax_edit/'.$tax->tax_id; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('update') ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

					                            <a href="<?php echo base_url().'dashboard_pharmacist/accounts/Caccounts/tax_delete/'.$tax->tax_id; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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