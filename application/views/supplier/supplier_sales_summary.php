		<div class="row">
            <div class="col-sm-12">
                
                  <a href="<?php echo base_url('supplier/Csupplier')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier')?> </a>

                  <a href="<?php echo base_url('supplier/Csupplier/manage_supplier')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier')?> </a>

                  <a href="<?php echo base_url('supplier/Csupplier/supplier_ledger_report')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger')?> </a>

                  <a href="<?php echo base_url('supplier/Csupplier/supplier_sales_details_all')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details')?> </a>

            </div>
        </div>
        
		<!-- Sales Report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                   <h4><?php echo display('supplier_sales_summary') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                <?php if ($supplier_detail) { ?>
							<?= $supplier_detail ?>
							<h3> <?= $supplier_name ?> </h3>
							<h5><?php echo display('address') ?> : <?= $address ?> </h5>
							<h5 ><?php echo display('phone') ?> : <?= $mobile ?> </h5>
							
						<?php } ?>
						
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th style="text-align:left !Important"> <?php echo display('date') ?> </th>
										<th><?php echo display('product_name') ?> </th>
										<th><?php echo display('quantity') ?> </th>
										<th style="text-align:right !Important"> <?php echo display('rate') ?> </th>
										<th style="text-align:right !Important"> <?php echo display('ammount') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($sales_info) {

										foreach ($sales_info as $sales) {
									?>
									<tr>
										<td style="text-align:left !Important"> <?= $sales->date ?></td>
										<td>
											<a href="<?php echo base_url().'Cproduct/product_details/'.$sales->product_id; ?>">
											<?= $sales->product_name ?> - (<?= $sales->product_model ?>)
											</a>
										</td>
										<td style="text-align:right !Important"> <?= $sales->quantity ?></td>
										<td style="text-align:right !Important"><?php echo (($position==0)?$currency." ".$sales->supplier_rate:$sales->supplier_rate." ".$currency) ?></td>
										<td style="text-align:right !Important"><?php echo (($position==0)?$currency." ".$sales->total:$sales->total." ".$currency) ?></td>
										 
									</tr>
									<?php
										}
								?>
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3"></td>
										<td><b><?php echo display('grand_total') ?>:</b></td>
										<td style="text-align:right !Important">
											<b>
											<?php echo (($position==0)?$currency." ".$sub_total:$sub_total." ".$currency) ?>
											</b>
										</td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		                <div class="text-right"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>