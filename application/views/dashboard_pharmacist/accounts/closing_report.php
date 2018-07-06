
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
                  <a href="<?php echo base_url('dashboard_pharmacist/accounts/Caccounts/closing')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('closing')?></a>
            </div>
        </div>



		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
	                	<?php echo form_open('dashboard_pharmacist/accounts/Caccounts/date_wise_closing_reports',array('class' => 'form-inline', ))?>
	                		<?php $today = date('Y-m-d'); ?>
							<label class="select"><?php echo display('search_by_date') ?>: <?php echo display('from') ?></label>
								<input type="text" name="from_date"  value="<?php echo $today; ?>" class="datepicker form-control"/>
							<label class="select"><?php echo display('to') ?></label>
								<input type="text" name="to_date"  value="<?php echo $today; ?>" class="datepicker form-control"/>
							<button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
						<?php echo form_close()?>		            
		            </div>
		        </div>
		    </div>
	    </div>

		<!-- Closing report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('closing_report') ?> </h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
			           			<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('last_day_ammount') ?></th>
										<th><?php echo display('cash_in') ?></th>
										<th><?php echo display('cash_out') ?></th>
										<th><?php echo display('cash_in_hand') ?></th>
										<th><?php echo display('adjustment') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($daily_closing_data) {
								?>
								
								<?php foreach ($daily_closing_data as  $closing) {
								 ?>
									<tr>
										<td><?php echo $closing['sl'];?></td>
										<td><?php echo $closing['final_date'];?></td>
										<td><?php echo (($position==0)?"$currency ".number_format($closing['last_day_closing'], 2, '.', ','):number_format($closing['last_day_closing'], 2, '.', ',')." $currency"); ?></td>
										<td>
											<?php echo (($position==0)?"$currency ".number_format($closing['cash_in'], 2, '.', ','):number_format($closing['cash_in'], 2, '.', ',')." $currency"); ?>
										</td>
										<td><?php echo (($position==0)?"$currency ".number_format($closing['cash_out'], 2, '.', ','):number_format($closing['cash_out'], 2, '.', ',')." $currency"); ?>
										</td>
										<td><?php echo (($position==0)?"$currency ".number_format($closing['cash_in_hand'], 2, '.', ','):number_format($closing['cash_in_hand'], 2, '.', ',')." $currency"); ?></td>
										<td><?php echo (($position==0)?"$currency ".number_format($closing['adjustment'], 2, '.', ','):number_format($closing['adjustment'], 2, '.', ',')." $currency"); ?></td>
									</tr>
								<?php } ?>
								<?php
									}
								?>
								</tbody>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>