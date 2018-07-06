
		<div class="row">
            <div class="col-sm-12">
                
                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/manage_supplier')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_ledger_report')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_sales_details_all')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details')?> </a>
				  
			</div>
        </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('supplier_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left">
							<?php foreach ($company_info as $company) { ?>
							<h3><?php echo $company['title'] ?></h3>
							<?php } ?>
					        <h4><?php echo display('supplier_ledger') ?></h4>
							<h4><?php echo display('supplier') ?> :<?= $info[0]['supplier_name'] ?></h4>
					        <span><?= $info[0]['address'] ?></span>
						</div>
					
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Supplier Actual Ledger -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('supplier_actual_ledger') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('date') ?></th>
										<th><?php echo display('description') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('credit') ?></th>
										<th style="text-align:right !Important;margin-right:20px"><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($ledger) {
										foreach ($ledger as $lead) {
									?>
									<tr>
										<td><?= $lead->date ?></td>
										<td><?= $lead->description ?></td>
										<td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?$currency." ".$lead->amount:$lead->amount." ".$currency) ?></td>
										<td style="text-align:right !Important;margin-right:20px"> <?php echo (($position==0)?$currency." ".$lead->total_amount:$lead->total_amount." ".$currency) ?></td>
									</tr>
									<?php
										}
								?>
								<?php
									}
								?>
								</tbody>
		                    </table>
		                </div>
		                <div class="text-right"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Supplier Payment Ledger End  -->