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
                  <a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/customer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('customer_search')?></a>
                  <a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/invoice')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('invoice_search')?></a>
                  <a href="<?php echo base_url('dashboard_pharmacist/search/Csearch/purchase')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('purchase_search')?></a>
            </div>
        </div>


		<!-- Manage Product report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
						<?php echo form_open('dashboard_pharmacist/search/Csearch/medicine_search',array('class' => 'form-inline', 'id' => 'validate'));?>
							<?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
							<label class="select"><?php echo display('search') ?>:</label>
							<input type="text" name="what_you_search" class="form-control" placeholder='<?php echo display('what_you_search') ?>' id="what_you_search" required="">
							<button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
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
		                    <h4><?php echo display('medicine_search') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
						<div id="printableArea" style="margin-left:2px;">
			                <div class="table-responsive" style="margin-top: 10px;" >
			                    <table class="table table-bordered table-striped table-hover medicine_search">
			                        <thead>
										<tr>
											<th class="text-center"><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('product_name') ?></th>
											<th class="text-center"><?php echo display('product_location') ?></th>
											<th class="text-center"><?php echo display('stock') ?></th>
											<th class="text-center"><?php echo display('details') ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
										if ($search_result != null) {
											foreach ($search_result as $search) {
									?>
										<tr>
											<td><?= $search['sl'] ?></td>
											<td><?= $search['product_name'] ?></td>
											<td><?= $search['product_location'] ?></td>
											<td><?= $search['total_stock'] ?></td>
											<td align="center">
											<a href="<?php echo base_url('dashboard_pharmacist/hospital_activities/Cproduct/product_details/'.$search['product_id']);?>" target="_blank"><button class="btn btn-success"><?php echo display('details')?></button>
											</a>
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
		</div>


<!-- <script type="text/javascript">
	
    //OnKeyUp search
    $('body').on('keyup','#what_you_search',function() {

        var keyword = $('#what_you_search').val();

        $.ajax({
            url: '<?php echo base_url('Csearch/medicine_search')?>',
            data: {keyword:keyword},
            type: 'post',
            // beforeSend:function(){
            //     $(".mid-content").html('<img class="img img-responsive" src="'+baseUrl+'/assets/web_site/images/loading.gif">');
            // },
            success: function(data){
            	alert(data);
            	if (data == 1) {
            		$('.medicine_search').html('Product Not Found !');
            	}else{
            		$(".medicine_search tbody").html(data);
            		//$('.medicine_search tbody').append(data);
            	}
            },error:function(exc){
                alert('failed');
            }
        });
    });
</script> -->