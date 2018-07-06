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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/reports/Creport/stock_report_supplier_wise')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_supplier_wise')?> </a>

                  <a href="<?php echo base_url('dashboard_pharmacist/reports/Creport')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('stock_report')?> </a>
            </div>
        </div>


		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 

						<?php echo form_open('dashboard_pharmacist/reports/Creport/stock_report_product_wise',array('class' => 'form-vertical','id' => 'stock_report_product_wise' ));?>

							<?php  $today = date('Y-m-d'); ?>

						<div class="form-group row">
                            <label for="supplier_id" class="col-sm-3 col-form-label"><?php echo display('select_supplier')?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="supplier_id" name="supplier_id" required="">
                            	<option value=""><?php echo display('select_one')?></option>
								<?php foreach ($supplier_list as $list) {
								?>
								<option value="<?= $list['supplier_id']?>"><?= $list['supplier_name']?> </option>
								<?php
								}
								?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_id" class="col-sm-3 col-form-label"><?php echo display('select_product')?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_id" name="product_id" required="">
	                            
	                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-sm-3 col-form-label"><?php echo display('from') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" id="from_date" name="from_date" value="<?php echo $today; ?>" class="form-control datepicker" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="to_date" class="col-sm-3 col-form-label"><?php echo display('to') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <input type="text" id="to_date" name="to_date" value="<?php echo $today; ?>" class="form-control datepicker" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6 text-center">
                                <button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
	                			<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
                            </div>
                        </div>
						
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
		                    <h4><?php echo display('stock_report_product_wise') ?></h4>
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
								<h4> <?php echo display('stock_date') ?> :<?= $date ?> </h4>
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>

			                <div class="table-responsive" style="margin-top: 10px;">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('date') ?></th>
											<th class="text-center"><?php echo display('product_model') ?></th>
											
											<th class="text-center"><?php echo display('in_quantity') ?></th>
											<th class="text-center"><?php echo display('out_quantity') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($stok_report) {
											foreach ($stok_report as $report) {
									?>
										<tr>
											<td><?= $report['date'] ?></td>
											<td align="center">
												<a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$report['product_id']; ?>"><?= $report['product_model'] ?></a>	
											</td>
										
											<td style="text-align: right;"><?= $report['totalPurchaseQnty'] ?></td>
											<td style="text-align: right;"><?= $report['totalSalesQnty'] ?></td>
											<td style="text-align: right;"><?= $report['SubTotalStock'] ?></td>
										</tr>
									<?php
											}
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2" align="right"><b><?php echo display('grand_total')?>:</b></td>

											<td style="text-align: right;"><b><?= $SubTotalinQnty ?></b></td>

											<td style="text-align: right;"><b><?= $SubTotaloutQnty ?></b></td>

											<td  style="text-align: right;"><b><?= $sub_total_stock ?></td>
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
	</section>
</div>
<!-- Stock List Supplier Wise End -->

<!-- Stock Product By Supplier -->
<script type="text/javascript">
    $('#supplier_id').change(function(e) {
        var supplier_id = $(this).val();
        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('dashboard_pharmacist/reports/Creport/get_product_by_supplier')?>',
            data: {supplier_id: supplier_id},
            success: function(data) {
                if (data) {
                    $("#product_id").html(data);
                }else{
                    $("#product_id").html("Product not found !");
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
</script>