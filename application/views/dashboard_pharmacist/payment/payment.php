<!-- Manage Payment start -->
<script type="text/javascript">
function printDiv(divName) {
	//document.getElementById("btn").style.display="none";
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
	               <a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('payment')?> </a>
	              <a href="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/receipt_transaction')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('receipt')?> </a>
	        </div>
	    </div>
	      <!-- <div class="row">
		    	<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		             	<form action="<?php echo base_url('dashboard_pharmacist/payment/Cpayment/manage_payment_date_to_date')?>" class="form-inline" method="post" accept-charset="utf-8">
		                <?php $today = date('d-m-Y'); ?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('start_date') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="<?php echo $today?>" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('end_date') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		                  
		              </form>	
		            </div>
		        </div>
		    </div>
		    </div> -->

		<!-- Manage transaction report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_transaction')?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		            	<div class="text-right">
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
		                </div>
						<div id="printableArea" style="margin-left:2px;">
							<div class="text-center">
								<h3><?= $company_info[0]['title']?></h3>
								<h4 ><?= $company_info[0]['description']?> </h4>
								<h4 style="margin-bottom:1rem;"> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>
				
			                <div class="table-responsive" style="margin-top: 10px;">
			                    <table id="" class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th><?php echo display('sl') ?></th>
											<th class="text-center"><?php echo display('name')?></th>
											<th class="text-center"><?php echo display('account_name')?></th>
											<th class="text-center"><?php echo display('payment_type')?></th>
											<th class="text-center"><?php echo display('receipt_amount')?></th>
											<th class="text-center"><?php echo display('paid_amount')?></th>
											<th class="text-center"><?php echo display('action')?></th>
										</tr>
									</thead>

									<?php if ($ledger) { ?>
									<?php foreach ($ledger as $row){?>
									<tbody>
										<tr>
											<td><?php echo $row['sl'] ?></td>
											<td  align="left">
								                <?php echo $row['person_name'];
								                  echo $row['customer_name'];
								                  echo $row['supplier_name'];
								                  if($row['person_name']==''AND $row['customer_name']==''AND $row['supplier_name']==''){
								                  	echo $row['relation_id'];
								                  }
								                ?>
                  							</td>
											<td align="left">
				                                <?php  $tran_cat=$row['transection_category'];
				                                if($tran_cat==1){
				                                	echo "supplier";
				                                }elseif($tran_cat==2) {
				                                	echo "customer";
				                                }elseif ($tran_cat==3) {
				                                	echo "Office";
				                                }elseif ($tran_cat==5) {
				                                	echo "Salary";
				                                }else{
				                                	echo "Loan";
				                                } 
				                                ?>
											</td>
											<td>
                  								<?php
                  									if ($row['transection_mood'] == 1) {
                  										echo display('cash');
                  									}elseif ($row['transection_mood'] == 2) {
                  										echo display('cheque');
                  									}else{
                  										echo display('pay_order');
                  									}
                  								?>
                  							</td>
											<td style="text-align: right;"><?php
	                                     		$debt=$row['debit'];
												if($debt==0){
													echo '';
												}else{
													echo (($position==0)?"$currency ".number_format($debt, 2, '.', ','):number_format($debt, 2, '.', ',')." $currency");
												}
												?>
												</td>
												<td align="right">

												<?php 
												$credit=$row['credit'];
												if($credit == 0){
													echo '';
												}else{
													echo (($position==0)?"$currency ".number_format($credit, 2, '.', ','):number_format($credit, 2, '.', ',')." $currency");
												} 
												?>
											</td>
											
											<td align="center" id="btn">
												<a href="<?php echo base_url().'dashboard_pharmacist/payment/Cpayment/payment_update_form/'.$row['tranid']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="javascript:;" class="deletePayment btn btn-danger btn-sm" name="<?php echo $row['tranid']; ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
									</tbody>
									 <?php  ?>
									<?php } ?>
									<?php
										}
									?>
									<tfoot>
										<tr  align="right">
											<td colspan="4"  align="right"><b>Total:</b></td>
											<td><b><?php echo (($position==0)?$currency." ".$subtotalDebit:$subtotalDebit." ".$currency) ?></b></td>

											<td><b><?php echo (($position==0)?$currency." ".$subtotalCredit:$subtotalCredit." ".$currency) ?></b></td>
											<td></td>
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

<script type="text/javascript">
	$(".deletePayment").click(function(){	
		var transaction_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm("Are You Sure,Want to Delete ?");
		if (x==true){
		$.ajax
	   ({
			type: "POST",
			url:'<?php echo base_url('dashboard_pharmacist/payment/Cpayment/payment_delete')?>',
			data: {transaction_id:transaction_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
		}
	});
</script>