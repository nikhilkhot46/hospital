<!-- Product js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product.js.php" ></script>

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
                  <a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_product_wise')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_product_wise')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/reports/Creport')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('stock_report')?> </a>

            </div>
        </div>


		<!-- Stock report supplier wise -->
	<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
						<?php echo form_open('dashboard_pharmacist/reports/Creport/stock_report_supplier_id_wise',array('class' => 'form-inline','id' => 'stock_report_supplier_wise' ));?>

							<?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
							<label class="select"><?php echo display('select_supplier')?>:</label>
							<select class="form-control dont-select-me" id="supplier_id" name="supplier_id" required="">
                            	<option value=""><?php echo display('select_one')?></option>
								<?php
								foreach ($supplier_list as $list) {
								?>
								<option value="<?= $list['supplier_id'] ?> "><?= $list['supplier_name'] ?> </option>
								<?php
								}
								?>
                            </select>
							
		                    <label class="select"><?php echo display('date') ?></label>
							<input type="text" name="stock_date" value="<?php echo $today; ?>" class="form-control productSelection datepicker" required/>
							<button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
		                	<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
			            <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('stock_report_supplier_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" style="margin-left:2px;">

							<div class="text-center">
								<?php if ($supplier_info) { 
									foreach ($supplier_info as $info) {
									?>
										<h3><?= $info['supplier_name'] ?> </h3>
										<h4><?php echo display('address') ?> : <?= $info['address'] ?></h4>
										<h4 ><?php echo display('phone') ?> : <?= $info['mobile'] ?> </h4>
									<?php	
									}
									?>
								<?php } ?>
								<h4> <?php echo display('stock_date') ?> : <?= $date ?></h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>

			                <div class="table-responsive" style="margin-top: 10px;">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('product_model') ?></th>
											
											<th class="text-center"><?php echo display('in_qnty') ?></th>
											<th class="text-center"><?php echo display('out_qnty') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($stok_report) {
											foreach ($stok_report as $report) {
									?>
										<tr>
											<td><?= $report['sl'] ?></td>
											<td align="center">
												<a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$report['product_id']; ?>"><?= $report['product_name'] ?></a>	
											</td>
											<td align="center"><?= $report['product_model'] ?></td>
											<td align="center"><?= $report['totalPurchaseQnty'] ?></td>
											<td align="center"><?= $report['totalSalesQnty'] ?></td>
											<td align="center"><?= $report['stok_quantity_cartoon'] ?></td>
										</tr>
									<?php
											}
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="right"><b><?php echo display('grand_total')?>:</b></td>
											<td align="center"><b><?= $sub_total_in ?></b></td>
											<td align="center"><b><?= $sub_total_out?></b></td>
											<td align="center"><b><?= $sub_total_stock?></td>
											
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		                <div class="text-right"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>
		<style>
		@media print {
  a[href]:after {
    content: none !important;
  }
}
		</style>