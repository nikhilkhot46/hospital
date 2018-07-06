<!-- Stock List Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('out_of_date') ?></h1>
	        <small><?php echo display('out_of_date') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('stock') ?></a></li>
	            <li class="active"><?php echo display('out_of_date') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">

		<div class="row">
            <div class="col-sm-12">
                <div class="column">
                  <a href="<?php echo base_url('Creport/stock_report_supplier_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_supplier_wise')?></a>  

                  <a href="<?php echo base_url('Creport/stock_report_product_wise')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"></i> <?php echo display('stock_report_product_wise')?></a>  
                </div>
            </div>
        </div>


		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('out_of_date') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive" style="margin-top: 10px;">
		                    <table id="" class="table table-bordered table-striped table-hover">
		                        <thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('batch_id') ?></th>
										<th class="text-center"><?php echo display('expeire_date') ?></th>
										
									</tr>
								</thead>
								<tbody>
								<?php
									if ($out_of_date) {
								?>
								{out_of_date}
									<tr>
										<td class="text-center">{sl}</td>
										<td class="text-center">
											<a href="<?php echo base_url().'Cproduct/product_details/{product_id}'; ?>">
											{product_name}
											</a>	
										</td>
										<td class="text-center">{batch_id}</td>
										<td class="text-center">{expeire_date}</td>
										
									</tr>
								{/out_of_date}
								<?php
									}
								?>
								</tbody>
		                    </table>
		                </div>
			            
		                <div class="text-center">
		                	 <?php if (isset($link)) { echo $link ;} ?>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Stock List End -->