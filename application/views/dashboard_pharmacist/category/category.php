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
                
                  <a href="<?php echo base_url('dashboard_pharmacist/category/Ccategory')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_category')?></a>

            </div>
        </div>

		<!-- Manage Category -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_category') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('category_id') ?></th>
										<th class="text-center"><?php echo display('category_name') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($category_list) {
									foreach ($category_list as $category) {
									?>
									<tr>
										<td class="text-center"><?php echo $category['category_id'] ?></td>
										<td class="text-center"><?php echo $category['category_name'] ?></td>
										<td>
											<center>
											<?php echo form_open()?>
												<a href="<?php echo base_url().'dashboard_pharmacist/category/Ccategory/category_update_form/'.$category["category_id"] ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
												<a href="javascript:;" class="DeleteCategory btn btn-danger btn-sm" name="<?php echo $category['category_id'] ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php echo form_close()?>
											</center>
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

<!-- Delete Category ajax code -->
<script type="text/javascript">
	//Delete Category 
	$(".DeleteCategory").click(function()
	{	
		var category_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm("<?php echo display('are_you_sure_to_delete')?>");
		if (x==true){
		$.ajax
		   ({
				type: "POST",
				url: '<?php echo base_url('dashboard_pharmacist/category/Ccategory/category_delete')?>',
				data: {category_id:category_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
					location.reload();
				} 
			});
		}
	});
</script>



