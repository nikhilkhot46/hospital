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
                  <a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_supplier_wise')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_supplier_wise')?> </a>
                  <a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_product_wise')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_product_wise')?> </a>
            </div>
        </div>

		
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
						<?php echo form_open_multipart('dashboard_pharmacist/reports/Creport',array('class' => 'form-inline', 'id' => 'stock_report'))?>

							<?php $today = date('d-m-Y'); ?>
							<label class="select"><?php echo display('search_by_product') ?>:</label>
							<input type="text" name="product_name" onclick="producstList();" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>' id="product_name" required>
							<input type="hidden" class="autocomplete_hidden_value" name="product_id" id="SchoolHiddenId"/>
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
		                    <h4><?php echo display('stock_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" style="margin-left:2px;">

							<div class="text-center">
								<h3><?= $company_info[0]['title']?> </h3>
								<h4 ><?= $company_info[0]['description']?> </h4>
								<h4> <?php echo display('stock_date') ?> :<?= $date ?> </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>
							
			                <div class="table-responsive" style="margin-top: 10px;">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('product_model') ?></th>
											<th class="text-center"><?php echo display('sell_price') ?></th>
											<th class="text-center"><?php echo display('in_qnty') ?></th>
											<th class="text-center"><?php echo display('out_qnty') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
											<th class="text-center"><?php echo display('stock_sale')?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($stok_report) {
											foreach ($stok_report as $stock) {
									?>
										<tr>
											<td><?= $stock['sl']?></td>
											<td align="center">
												<a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$stock['product_id']; ?>">
												<?= $stock['product_name']?>
												</a>	
											</td>
											<td align="center"><?= $stock['product_model']?></td>
											<td style="text-align: right;"><?php echo (($position==0)?$currency." ".$stock['sales_price']:$stock['sales_price']." ".$currency) ?></td>
											
											<td align="center"><?= $stock['totalPurchaseQnty']?></td>
											<td align="center"><?= $stock['totalSalesQnty']?></td>
											<td align="center"><?= $stock['stok_quantity_cartoon']?></td>
										
											<td align="center"><?= $stock['total_sale_price']?></td>
										</tr>
									<?php
											}
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4" align="right"><b><?php echo display('grand_total')?>:</b></td>
											<td align="center"><b><?= $sub_total_in?></b></td>
											<td align="center"><b><?= $sub_total_out?></b></td>
											<td align="center"><b><?= $sub_total_stock?></td>
											<td align="center"><b><?= $stock_sale?></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
		                <div class="text-center">
		                	 <?php if (isset($link)) { echo $link ;} ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>