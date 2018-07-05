
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
                  <a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('add_product')?></a>

                  <a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/add_product_csv')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('import_product_csv')?></a>

            </div>
        </div>
 <div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 

						<form action="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/product_by_search')?>" class="form-inline" method="post" accept-charset="utf-8">
							
		                    <label class="select"><?php echo display('product_name')?>:</label>
							<style>
							.select2-container{
								max-width:360px
							}
							</style>
							<select class="form-control" name="product_id" >
	                        <?php
							foreach ($all_product_list as $prod) {							
							?>
	                            	<option value="<?= $prod['product_id'] ?>"><?= $prod['product_name'] ?> - ( <?= $prod['product_model'] ?> )</option>
							<?php } ?>
                            </select>

							<button type="submit" class="btn btn-primary"><?php echo display('search')?></button>
		                	
			            </form>		            
			        </div>
		        </div>
		    </div>
	    </div>

		<!-- Manage Product report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_product') ?>
							<p  style="float: right;"><a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/exportCSV'; ?>" class="btn btn-success">Export CSV </a></p>
							</h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('product_name') ?></th>
										<th><?php echo display('model') ?></th>
										<th><?php echo display('supplier') ?></th>	
										<th><?php echo display('sale_price') ?></th>
										<th><?php echo display('supplier_price') ?></th>
									    <th><?php echo display('tax') ?></th>
										<th><?php echo display('unit') ?></th>
										<th><?php echo display('category') ?></th>
										<th><?php echo display('box_size') ?></th>
										<th><?php echo display('shelf') ?></th>
										<th><?php echo display('image') ?>s</th>
										<th style="width : 130px"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
							<?php
									if ($products_list) {
								?>
								<?php $sl = 1; ?>
									<?php foreach ($products_list as $row){?>
									


										<tr>
							<td><?php echo $sl; ?></td>

							<td>
							<a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$row['product_id']; ?>">
							<?php echo $row['product_name']; ?>
							</a>			
							</td>
							<td><a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$row['product_id']; ?>"><?php echo $row['product_model']; ?> </a></td>
							<td><?php echo $row['supplier_name']; ?></td>

							<td style="text-align: right;">

							<?php echo (($position==0)?"$currency":$row['price']);echo $row['price']; ?>
							</td>
							<td style="text-align: right;">

							<?php echo (($position==0)?"$currency":$row['price']);echo $row['supplier_price']; ?>
							</td>
							<td><?php  
							    $tx=$row['tax'];
							    $txvl=$tx*100;
							    echo $txvl;

							    ?> %</td>
							<td><?php echo $row['unit']; ?></td>
							<td><?php echo $row['category_name']; ?></td>
							<td style="text-align: right;"><?php echo $row['box_size']; ?></td>
							<td><?php echo $row['product_location']; ?></td>

							<td class="text-center">
							<img src="<?php echo $row['image']; ?>" class="img img-responsive" height="50" width="50">
							</td>
							<td>
											<center>
											<?php echo form_open()?>

												<a href="<?php echo base_url().'dashboard_pharmacist/Cqrcode/qrgenerator/'.$row['product_id']; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="<?php echo display('qr_code') ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

												<a href="<?php echo base_url().'dashboard_pharmacist/Cbarcode/barcode_print/'.$row['product_id']; ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left" title="<?php echo display('barcode') ?>"><i class="fa fa-barcode" aria-hidden="true"></i></a>

												<a href="<?php echo base_url().'dashboard_pharmacist/hospital_activities/Cproduct/product_update_form/'.$row['product_id']; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="javascript:;" class="deleteProduct btn btn-danger btn-xs" name="<?php echo $row['product_id']; ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>

											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								 <?php $sl++; ?>
									<?php } ?>
									<?php
										}
									?>
								</tbody>
		                    </table>
		                     <div class="text-right"><?php echo $links?></div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

<!-- Delete Product ajax code -->
<script type="text/javascript">
	$(".deleteProduct").click(function()
	{	
		var product_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm("<?php echo display('are_you_sure_to_delete')?>");
		if (x==true){
		$.ajax
		   ({
				type: "POST",
				url:'<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/product_delete')?>',
				data: {product_id:product_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
					location.reload();
				} 
			});
		}
	});
</script>