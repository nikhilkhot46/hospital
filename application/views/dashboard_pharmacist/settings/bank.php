
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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/Csettings/index')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('add_new_bank')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/Csettings/bank_transaction')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('bank_transaction')?> </a>

            </div>
        </div>

		<!-- Bank List -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('bank_list') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('bank_name') ?></th>
										<th><?php echo display('ac_name') ?></th>
										<th><?php echo display('ac_no') ?></th>
										<th><?php echo display('branch') ?></th>
										<th><?php echo display('balance') ?></th>
										<th><?php echo display('signature_pic') ?></th>
										<th><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($bank_list) {
										foreach ($bank_list as $bank) {
								?>
									<tr>
										<td><?= $bank['sl'] ?></td>
										<td><a href="<?php echo base_url("dashboard_pharmacist/Csettings/bank_ledger/{bank_id}");?>" ><?= $bank['bank_name'] ?></a></td>
										<td><?= $bank['ac_name'] ?></td>
										<td><?= $bank['ac_number'] ?></td>
										<td><?= $bank['branch'] ?></td>
										<td><?php echo (($position==0)?$currency." ".$bank['balance']:$bank['balance']." ".$currency) ?></td>
										<td>
										<img src="<?= $bank['signature_pic'] ?>" class="img img-responsive center-block" height="80" width="100"></td>
										<td>
										<?php echo form_open()?>
											<a href="<?php echo base_url().'dashboard_pharmacist/Csettings/edit_bank/'.$bank['bank_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<?php echo form_close()?>
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