<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>

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
                
                  <a href="<?php echo base_url('Creport/stock_report_product_wise')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_product_wise')?> </a>

                  <a href="<?php echo base_url('Creport')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('stock_report')?> </a>

            </div>
        </div>


		<!-- Stock report supplier wise -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
            			<form action="<?php echo base_url('dashboard_pharmacist/reports/Creport/product_stock_batchwise_by_name')?>" class="form-inline" method="post" accept-charset="utf-8">
							
		                    <label class="select"><?php echo display('product_name')?>:</label>
							 <input type="text" name="product_name" onkeyup="invoice_productList(1);" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>' required="" id="product_name" tabindex="7"  >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id" id="SchoolHiddenId" />

                                            <input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
							<button type="submit" class="btn btn-primary"><?php echo display('search')?></button>
							<a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
			            </form>		   
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('stock_report_batch_wise') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" style="margin-left:2px;">
			                <div class="table-responsive" style="margin-top: 10px;">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('product_model') ?></th>
											<th class="text-center"><?php echo display('batch_id') ?></th>
											<th class="text-center"><?php echo display('expire_date') ?></th>
											<th class="text-center"><?php echo display('in_qnty') ?></th>
											<th class="text-center"><?php echo display('out_qnty') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($stok_report) {
									?>
									
									<?php foreach ($stok_report as $stok_report) {
									 $productname=$this->db->select('*')
                                                        ->from('product_information')
                                                        ->where('product_id',$stok_report['product_id'])
                                                        ->get()
                                                        ->result();

                                  $batchexpire=$this->db->select('*')
                                            ->from('product_purchase_details')
                                            ->where('batch_id',$stok_report['batch_id'])
                                            ->group_by('batch_id')
                                            ->get()
                                            ->result();
									?>
										<tr>
											<td><?php echo $stok_report['sl'];?></td>
											<td align="center">
												<a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$stok_report['product_id']; ?>">
													
                                                 <?php foreach ($productname as $vale) {
                                                echo $vale->product_name;
                                            }?>
													
												</a>	
											</td>
											<td align="center"> <?php foreach ($productname as $vale2) {
                                                echo $vale2->product_model;
                                            }?></td>
											<td align="center"><?php echo $stok_report['batch_id'];?></td>
												<td align="center"><?php foreach ($batchexpire as $expire) {
                                                echo $expire->expeire_date;
                                            }?></td>
											<td align="center"><?php echo $stok_report['totalPurchaseQnty'];?></td>
											<td align="center"><?php echo $stok_report['totalSalesQnty'];?></td>
											<td align="center"><?php echo $stok_report['stok_quantity_cartoon'];?></td>
										</tr>
									<?php } ?>
									<?php
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5" align="right"><b><?php echo display('grand_total')?>:</b></td>
											<td align="center"><b><?= $sub_total_in ?></b></td>
											<td align="center"><b><?= $sub_total_out ?></b></td>
											<td align="center"><b><?= $sub_total_stock ?></td>
											
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