<!-- Stock report start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>


		<div class="row">
            <div class="col-sm-12">
                
                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/manage_supplier')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('manage_supplier')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/supplier/Csupplier/supplier_ledger_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger')?> </a>

            </div>
        </div>

		<!-- Sales Details -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('supplier_sales_details') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		            	<div class="text-right">
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
		                </div>
		            	<div id="printableArea" style="margin-left:2px;">

		            		<?php if ($supplier_name) { ?>

		            		<div class="text-center">
								<h3> <?= $supplier_name ?> </h3>
								<h4><?php echo display('address') ?> : <?= $supplier_address ?> </h4>
								<h4 style="margin: calc(2rem - .14285em) 0 1rem;"> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>

							<?php } ?>

			                <div class="table-responsive">
			                    <table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th><?php echo display('date') ?></th>
											<th><?php echo display('product_name') ?></th>
											<th><?php echo display('quantity') ?></th>
											<th><?php echo display('rate') ?></th>
											<th><?php echo display('ammount')?></th>
										</tr>
									</thead>
									<tbody>
									<?php
									if ($sales_info) {
										foreach ($sales_info as $sales) {
									?>
									<tr>
											
											<td><?= $sales->date ?></td>
											<td>
												<a href="<?php echo base_url().'Cproduct/product_details/'.$sales->product_id; ?>">
												<?= $sales->product_name ?> - <?= $sales->product_model ?>
												</a>
											</td>
											<td align="right"><?= $sales->quantity ?></td>
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
											<td>
												<b><?php echo display('grand_total') ?></b> :
											</td>
											<td style="text-align:right"><b>
											<?php echo (($position==0)?$currency." ".$sub_total:$sub_total."".$currency) ?></b></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		            </div>
		        </div>
		    </div>
		</div>