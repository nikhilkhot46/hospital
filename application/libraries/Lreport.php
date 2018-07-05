<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lreport {
	
	// Retrieve All Stock Report
	public function stock_report($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report($limit,$page);
	
		if(!empty($stok_report)){
			$i=$page;
			foreach($stok_report as $k=>$v){$i++;
			   $stok_report[$k]['sl']=$i;
			}
			foreach($stok_report as $k=>$v){$i++;
			   $stok_report[$k]['stok_quantity'] = $stok_report[$k]['totalBuyQnty']-$stok_report[$k]['totalSalesQnty'];
			   $stok_report[$k]['totalSalesCtn'] = $stok_report[$k]['totalSalesQnty']/$stok_report[$k]['cartoon_quantity'];
			   $stok_report[$k]['totalPrhcsCtn'] = $stok_report[$k]['totalBuyQnty']/$stok_report[$k]['cartoon_quantity'];

			$stok_report[$k]['stok_quantity_cartoon'] = $stok_report[$k]['stok_quantity']/$stok_report[$k]['cartoon_quantity'];

			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$data = array(
				'title'    => display('stock_list'),
				'stok_report' => $stok_report,
				'links'    => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
				
			);
		$reportList = $CI->parser->parse('report/stock_report',$data,true);
		return $reportList;
	}

	//Out of stock
	public function out_of_stock(){
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');

		$out_of_stock = $CI->Reports->out_of_stock();

		if(!empty($out_of_stock)){
			$i=0;
			foreach($out_of_stock as $k=>$v){$i++;
			   $out_of_stock[$k]['sl']=$i;
			}
		}
	
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$data = array(
				'title' 	=> display('out_of_stock'),
				'out_of_stock' => $out_of_stock,
				'currency' 	=> $currency_details[0]['currency'],
				'position' 	=> $currency_details[0]['currency_position'],
			);

		$reportList = $CI->parser->parse('report/out_of_stock',$data,true);
		return $reportList;
	}
// Date expire Medicine list
	public function out_of_date(){
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');

		$out_of_date = $CI->Reports->out_of_date();

		if(!empty($out_of_date)){
			$i=0;
			foreach($out_of_date as $k=>$v){$i++;
			   $out_of_date[$k]['sl']=$i;
			}
		}
	
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$data = array(
				'title' 	=> display('out_of_date'),
				'out_of_date' => $out_of_date,
				'currency' 	=> $currency_details[0]['currency'],
				'position' 	=> $currency_details[0]['currency_position'],
			);

		$reportList = $CI->parser->parse('report/out_of_date',$data,true);
		return $reportList;
	}
	// Retrieve Single Item Stock Stock Report
	public function stock_report_single_item($product_id = null,$date=null,$limit=null,$page=null,$link=null)
	{  
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report_bydate($product_id,$date,$limit,$page);
		$sub_total_in=0;
		$sub_total_out=0;
		$sub_total_stock=0;
		$sub_total_stokpurchase=0;
		$sub_total_stoksale=0;
		if(!empty($stok_report)){
			$i=$page;
			foreach($stok_report as $k=>$v){$i++;
			   $stok_report[$k]['sl']=$i;
			}

			foreach($stok_report as $k=>$v){$i++;
			    $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty']-$stok_report[$k]['totalSalesQnty']);
			    $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
			    $sub_total_out = $stok_report[$k]['SubTotalOut'];
			    $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
			    $sub_total_in = $stok_report[$k]['SubTotalIn'];
			    $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
			    $sub_total_stock = $stok_report[$k]['SubTotalStock'];
			   
			     $stok_report[$k]['total_sale_price']=$stok_report[$k]['stok_quantity_cartoon']*$stok_report[$k]['price'];
             
              $stok_report[$k]['sales_price']=$stok_report[$k]['price'];
           
              $sub_total_stoksale+=$stok_report[$k]['total_sale_price'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> 	display('stock_report'),
				'stok_report' 	=> 	$stok_report,
				'product_model' => 	$stok_report[0]['product_model'],
				'link'			=>	$link,
				'date'			=>	$date,
				'sub_total_in'	=>	$sub_total_in,
				'sub_total_out'	=>	$sub_total_out,
				'sub_total_stock'=>	$sub_total_stock,
				'company_info' 	=> 	$company_info,
				'stock_purchase'=> $sub_total_stokpurchase,
				'stock_sale'    => $sub_total_stoksale,
				'currency' 		=> 	$currency_details[0]['currency'],
				'position' 		=> 	$currency_details[0]['currency_position'],
			);

	
		//$reportList = $CI->parser->parse('report/stock_report',$data,true);
		return $data;
	}

	// Retrieve Single Item Stock Stock Report
	public function stock_report_supplier_wise($product_id,$supplier_id,$date,$links,$per_page,$page)
	{   
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Suppliers');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report_supplier_bydate($product_id,$supplier_id,$date,$per_page,$page);

		$supplier_list = $CI->Suppliers->supplier_list_report();
		$supplier_info = $CI->Suppliers->retrieve_supplier_editdata($supplier_id);

		$sub_total_in=0;
		$sub_total_out=0;
		$sub_total_stock=0;

		if(!empty($stok_report)){
			$i=$page;
			

			foreach($stok_report as $k=>$v){$i++;
				 $stok_report[$k]['sl']=$i;

			    $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty']-$stok_report[$k]['totalSalesQnty']);

			    $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
			    $sub_total_out = $stok_report[$k]['SubTotalOut'];

			    $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
			    $sub_total_in = $stok_report[$k]['SubTotalIn'];

			    $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
			    $sub_total_stock = $stok_report[$k]['SubTotalStock'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> 	display('stock_report_supplier_wise'),
				'stok_report' 	=> 	$stok_report,
				'product_model' => 	$stok_report[0]['product_model'],
				'links'			=>	$links,
				'date'			=>	$date,
				'sub_total_in'	=>	$sub_total_in,
				'sub_total_out'	=>	$sub_total_out,
				'sub_total_stock'=>	$sub_total_stock,
				'supplier_list'	=>	$supplier_list,
				'supplier_info'	=>	$supplier_info,
				'company_info' 	=> 	$company_info,
				'currency' 		=> 	$currency_details[0]['currency'],
				'position' 		=> 	$currency_details[0]['currency_position'],
			);
	
		//$reportList = $CI->parser->parse('report/stock_report_supplier_wise',$data,true);
		return $data;
	}
	// supplier stock report supplier id wise
	public function stock_report_supplier_id_wise($supplier_id,$date,$links,$per_page,$page)
	{   
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Suppliers');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report_supplier_byid($supplier_id,$date,$per_page,$page);

		$supplier_list = $CI->Suppliers->supplier_list_report();
		$supplier_info = $CI->Suppliers->retrieve_supplier_editdata($supplier_id);

		$sub_total_in=0;
		$sub_total_out=0;
		$sub_total_stock=0;

		if(!empty($stok_report)){
			$i=$page;
			

			foreach($stok_report as $k=>$v){$i++;
				 $stok_report[$k]['sl']=$i;

			    $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty']-$stok_report[$k]['totalSalesQnty']);

			    $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
			    $sub_total_out = $stok_report[$k]['SubTotalOut'];

			    $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
			    $sub_total_in = $stok_report[$k]['SubTotalIn'];

			    $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
			    $sub_total_stock = $stok_report[$k]['SubTotalStock'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> 	display('stock_report_supplier_wise'),
				'stok_report' 	=> 	$stok_report,
				'product_model' => 	$stok_report[0]['product_model'],
				'links'			=>	$links,
				'date'			=>	$date,
				'sub_total_in'	=>	$sub_total_in,
				'sub_total_out'	=>	$sub_total_out,
				'sub_total_stock'=>	$sub_total_stock,
				'supplier_list'	=>	$supplier_list,
				'supplier_info'	=>	$supplier_info,
				'company_info' 	=> 	$company_info,
				'currency' 		=> 	$currency_details[0]['currency'],
				'position' 		=> 	$currency_details[0]['currency_position'],
			);
	
		//$reportList = $CI->parser->parse('report/stock_report_supplier_wise',$data,true);
		return $data;
	}

	// Retrieve Single Item Stock Stock Report
	public function stock_report_product_wise($product_id=null,$supplier_id=null,$from_date=null,$to_date=null,$links=null,$per_page=null,$page=null)
	{   

		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Suppliers');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report_product_bydate($product_id,$supplier_id,$from_date,$to_date,$per_page,$page);

		
		$supplier_list = $CI->Suppliers->supplier_list_report();
		$supplier_info = $CI->Suppliers->retrieve_supplier_editdata($supplier_id);


		$sub_total_in=0;
		$sub_total_out=0;
		$sub_total_stock=0;
		$sub_total_in_qnty=0;
		$sub_total_out_qnty=0;
		$stok_quantity_cartoon=0;

	
		if (!empty($stok_report)){

			$i=$page;
			foreach($stok_report as $k=>$v){
				$i++;
			   $stok_report[$k]['sl']=$i;
			}

			foreach($stok_report as $k=>$v){$i++;

		  $stok_report[$k]['totalSalesCtn'] = $stok_report[$k]['totalSalesQnty'];

			   $stok_report[$k]['totalPrhcsCtn'] = $stok_report[$k]['totalPurchaseQnty'];

			    $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPrhcsCtn']-$stok_report[$k]['totalSalesCtn']);

			    $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesCtn']);
			    $sub_total_out = $stok_report[$k]['SubTotalOut'];


			    $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPrhcsCtn']);
			    $sub_total_in =$stok_report[$k]['totalPrhcsCtn'];
                 $sub_total_in_qnty += $sub_total_in;

			 
       $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);


			  

			    

			    $stok_report[$k]['SubTotaloutQnty'] = ($sub_total_out_qnty + $stok_report[$k]['totalSalesQnty']);
			    $sub_total_out_qnty = $stok_report[$k]['SubTotaloutQnty'];


			   
			  
			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> display('stock_report_product_wise'),
				'stok_report' 	=> $stok_report,
				'product_model' => $stok_report[0]['product_model'],
				'links'			=>$links,
				'date'			=>$to_date,
				'sub_total_in'	=>$sub_total_in,
				'sub_total_out'	=>$sub_total_out,
				'sub_total_stock'=>$sub_total_in_qnty-$sub_total_out_qnty,
				'SubTotalinQnty'=>$sub_total_in_qnty,
				'SubTotaloutQnty'=>$sub_total_out_qnty,
				'supplier_list'	=>$supplier_list,
				'supplier_info'	=>$supplier_info,
				'company_info' 	=> $company_info,
				'currency' 		=> $currency_details[0]['currency'],
				'position' 		=> $currency_details[0]['currency_position'],
			);
	
		//$reportList = $CI->parser->parse('report/stock_report_product_wise',$data,true);
		return $data;
	}

	// Retrieve daily Report
	public function retrieve_all_reports($per_page=null,$page=null)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		
		$CI->load->library('occational');

		$sales_report = $CI->Reports->todays_sales_report($per_page,$page);
		$sales_amount = 0;
		if(!empty($sales_report)){
			$i=0;
			foreach($sales_report as $k=>$v){$i++;
			   $sales_report[$k]['sl']=$i;
			   $sales_report[$k]['sales_date'] = $CI->occational->dateConvert($sales_report[$k]['date']);
			   $sales_amount = $sales_amount+$sales_report[$k]['total_amount'];
			}
		}

		$purchase_report = $CI->Reports->todays_purchase_report($per_page,$page);		
		$purchase_amount = 0;
		if(!empty($purchase_report)){
			$i=0;
			foreach($purchase_report as $k=>$v){$i++;
			    $purchase_report[$k]['sl']=$i;
			    $purchase_report[$k]['prchse_date'] = $CI->occational->dateConvert($purchase_report[$k]['purchase_date']);
				$purchase_amount = $purchase_amount+$purchase_report[$k]['grand_total_amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> display('todays_report'),
				'sales_report' 	=> $sales_report,
				'sales_amount' 	=> number_format($sales_amount, 2, '.', ','),
				'purchase_amount' => number_format($purchase_amount, 2, '.', ','),
				'purchase_report' => $purchase_report,
				'date'			=> $today = date('d-m-Y'),
				'company_info' 	=> $company_info,
				'currency' 		=> $currency_details[0]['currency'],
				'position' 		=> $currency_details[0]['currency_position'],
			);

		// report/all_report
		//$reportList = $CI->parser->parse('report/all_report',$data,true);
		return $data;
	}

	// Retrieve todays_sales_report
	public function todays_sales_report($links=null,$per_page=null,$page=null)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		//$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$sales_report = $CI->Reports->todays_sales_report($per_page,$page);
		$sales_amount = 0;
		if(!empty($sales_report)){
			$i=0;
			foreach($sales_report as $k=>$v){$i++;
			   $sales_report[$k]['sl']=$i;
			   $sales_report[$k]['sales_date'] = $CI->occational->dateConvert($sales_report[$k]['date']);
			   $sales_amount = $sales_amount+$sales_report[$k]['total_amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> display('todays_sales_report'),
				'sales_amount' 	=> number_format($sales_amount, 2, '.', ','),
				'sales_report' 	=> $sales_report,
				'company_info' 	=> $company_info,
				'currency' 		=> $currency_details[0]['currency'],
				'position' 		=> $currency_details[0]['currency_position'],
				'links' 		=> $links,
			);
		//$reportList = $CI->parser->parse('report/sales_report',$data,true);
		return $data;
	}

	public function retrieve_dateWise_SalesReports($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->library('occational');
		$sales_report = $CI->Reports->retrieve_dateWise_SalesReports($start_date,$end_date);
		$sales_amount = 0;
		if(!empty($sales_report)){
			$i=0;
			foreach($sales_report as $k=>$v){$i++;
			   $sales_report[$k]['sl']=$i;
			   $sales_report[$k]['sales_date'] = $CI->occational->dateConvert($sales_report[$k]['date']);
			   $sales_amount = $sales_amount+$sales_report[$k]['total_amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> display('sales_report'),
				'sales_amount' 	=>  $sales_amount,
				'sales_report' 	=> $sales_report,
				'company_info' 	=> $company_info,
				'currency' 		=> $currency_details[0]['currency'],
				'position' 		=> $currency_details[0]['currency_position'],
				'links' 		=> '',
			);
		//$reportList = $CI->parser->parse('report/sales_report',$data,true);
		return $data;
	}
	// Retrieve todays_purchase_report
	public function todays_purchase_report($links=null,$per_page=null,$page=null)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->library('occational');
		$purchase_report = $CI->Reports->todays_purchase_report($per_page,$page);		
		$purchase_amount = 0;

		if(!empty($purchase_report)){
			$i=0;
			foreach($purchase_report as $k=>$v){$i++;
			    $purchase_report[$k]['sl']=$i;
			    $purchase_report[$k]['prchse_date'] = $CI->occational->dateConvert($purchase_report[$k]['purchase_date']);
				$purchase_amount = $purchase_amount+$purchase_report[$k]['grand_total_amount'];
			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> display('todays_purchase_report'),
				'purchase_amount' =>  number_format($purchase_amount, 2, '.', ','),
				'purchase_report' => $purchase_report,
				'company_info' 	=> $company_info,
				'currency' 		=> $currency_details[0]['currency'],
				'position' 		=> $currency_details[0]['currency_position'],
				'links' 		=> $links,
			);
		//$reportList = $CI->parser->parse('report/purchase_report',$data,true);
		return $data;
	}

	//Retrive date wise purchase report
	public function retrieve_dateWise_PurchaseReports($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->library('occational');
		$purchase_report = $CI->Reports->retrieve_dateWise_PurchaseReports($start_date,$end_date);
		$purchase_amount = 0;
		if(!empty($purchase_report)){
			$i=0;
			foreach($purchase_report as $k=>$v){$i++;
			    $purchase_report[$k]['sl']=$i;
			    $purchase_report[$k]['prchse_date'] = $CI->occational->dateConvert($purchase_report[$k]['purchase_date']);
				$purchase_amount = $purchase_amount+$purchase_report[$k]['grand_total_amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> display('purchase_report'),
				'purchase_amount'=>  $purchase_amount,
				'purchase_report'=> $purchase_report,
				'company_info' 	=> $company_info,
				'currency' 		=> $currency_details[0]['currency'],
				'position' 		=> $currency_details[0]['currency_position'],
				'links' 		=> '',

			);
		//$reportList = $CI->parser->parse('report/purchase_report',$data,true);
		return $data;
	}
	//Product report sales wise
	public function get_products_report_sales_view($links,$per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->library('occational');
		$product_report = $CI->Reports->retrieve_product_sales_report($per_page,$page);
	
		if(!empty($product_report)){
			$i=0;
			foreach($product_report as $k=>$v){$i++;
			    $product_report[$k]['sl']=$i;
			}
		}
		$sub_total = 0;
		if(!empty($product_report)){
			foreach($product_report as $k=>$v){
			    $product_report[$k]['sales_date'] = $CI->occational->dateConvert($product_report[$k]['date']);
				$sub_total = $sub_total+$product_report[$k]['total_amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 	=> display('sales_report_product_wise'),
				'sub_total' =>  number_format($sub_total, 2, '.', ','),
				'product_report' => $product_report,
				'links' 	=> $links,
				'company_info' => $company_info,
				'currency' 	=> $currency_details[0]['currency'],
				'position' 	=> $currency_details[0]['currency_position'],
			);
		//$reportList = $CI->parser->parse('report/product_report',$data,true);
		return $data;
	}
	//Get Product Report Search
	public function get_products_search_report( $from_date,$to_date )
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->library('occational');
		$product_report = $CI->Reports->retrieve_product_search_sales_report( $from_date,$to_date );

		if(!empty($product_report)){
			$i=0;
			foreach($product_report as $k=>$v){$i++;
			    $product_report[$k]['sl']=$i;
			}
		}
		$sub_total = 0;
		if(!empty($product_report)){
			foreach($product_report as $k=>$v){
			    $product_report[$k]['sales_date'] = $CI->occational->dateConvert($product_report[$k]['date']);
				$sub_total = $sub_total+$product_report[$k]['total_price'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 	=> display('sales_report_product_wise'),
				'sub_total' =>  number_format($sub_total, 2, '.', ','),
				'product_report' => $product_report,
				'links' 	=> '',
				'company_info' => $company_info,
				'currency' 	=> $currency_details[0]['currency'],
				'position' 	=> $currency_details[0]['currency_position'],
			);
		//$reportList = $CI->parser->parse('report/product_report',$data,true);
		return $data;
	}
	//Total profit report
	public function total_profit_report($links,$per_page,$page){
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$total_profit_report = $CI->Reports->total_profit_report($per_page,$page);	

	
		$profit_ammount = 0;
		$SubTotalSupAmnt = 0;
		$SubTotalSaleAmnt = 0;
		if(!empty($total_profit_report)){
			$i=0;
			foreach($total_profit_report as $k=>$v){
				$total_profit_report[$k]['sl']=$i;
			    $total_profit_report[$k]['prchse_date'] = $CI->occational->dateConvert($total_profit_report[$k]['date']);

				$profit_ammount = $profit_ammount+$total_profit_report[$k]['total_profit'];

				$SubTotalSupAmnt = $SubTotalSupAmnt+$total_profit_report[$k]['total_supplier_rate'];

				$SubTotalSaleAmnt = $SubTotalSaleAmnt+$total_profit_report[$k]['total_sale'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 			=> display('profit_report'),
				'profit_ammount' 	=>  number_format($profit_ammount, 2, '.', ','),
				'total_profit_report' => $total_profit_report,
				'SubTotalSupAmnt' 	=> number_format($SubTotalSupAmnt, 2, '.', ','),
				'SubTotalSaleAmnt' 	=> number_format($SubTotalSaleAmnt, 2, '.', ','),
				'links' 			=> $links,
				'company_info' 		=> $company_info,
				'currency' 			=> $currency_details[0]['currency'],
				'position' 			=> $currency_details[0]['currency_position'],
			);
		$reportList = $CI->parser->parse('report/profit_report',$data,true);
		return $reportList;
	}
	
	//Retrive date wise total profit report
	public function retrieve_dateWise_profit_report($start_date,$end_date,$links,$per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$total_profit_report = $CI->Reports->retrieve_dateWise_profit_report($start_date,$end_date,$per_page,$page);

		$profit_ammount = 0;
		$SubTotalSupAmnt = 0;
		$SubTotalSaleAmnt = 0;
		if(!empty($total_profit_report)){
			$i=0;
			foreach($total_profit_report as $k=>$v){
				$total_profit_report[$k]['sl']=$i;
			    $total_profit_report[$k]['prchse_date'] = $CI->occational->dateConvert($total_profit_report[$k]['date']);

				$profit_ammount = $profit_ammount+$total_profit_report[$k]['total_profit'];

				$SubTotalSupAmnt = $SubTotalSupAmnt+$total_profit_report[$k]['total_supplier_rate'];

				$SubTotalSaleAmnt = $SubTotalSaleAmnt+$total_profit_report[$k]['total_sale'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 			=> display('profit_report'),
				'profit_ammount' 	=>  number_format($profit_ammount, 2, '.', ','),
				'total_profit_report' => $total_profit_report,
				'SubTotalSupAmnt' 	=> number_format($SubTotalSupAmnt, 2, '.', ','),
				'SubTotalSaleAmnt' 	=> number_format($SubTotalSaleAmnt, 2, '.', ','),
				'links' 			=> $links,
				'company_info' 		=> $company_info,
				'currency' 			=> $currency_details[0]['currency'],
				'position' 			=> $currency_details[0]['currency_position'],
			);
		$reportList = $CI->parser->parse('report/profit_report',$data,true);
		return $reportList;
	}
	// stock report batch wise
	public function stock_report_batch_wise($links,$per_page,$page)
	{   
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Suppliers');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report_batch_bydate($per_page,$page);
       $company_info = $CI->Reports->retrieve_company();
		$sub_total_in=0;
		$sub_total_out=0;
		$sub_total_stock=0;

		if(!empty($stok_report)){
			$i=$page;
			

			foreach($stok_report as $k=>$v){$i++;
				 $stok_report[$k]['sl']=$i;

			    $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty']-$stok_report[$k]['totalSalesQnty']);

			    $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
			    $sub_total_out = $stok_report[$k]['SubTotalOut'];

			    $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
			    $sub_total_in = $stok_report[$k]['SubTotalIn'];

			    $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
			    $sub_total_stock = $stok_report[$k]['SubTotalStock'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> 	display('stock_report_batch_wise'),
				'stok_report' 	=> 	$stok_report,
				'links'			=>	$links,
				'sub_total_in'	=>	$sub_total_in,
				'sub_total_out'	=>	$sub_total_out,
				'sub_total_stock'=>	$sub_total_stock,
				'company_info' 	=> 	$company_info,
				'currency' 		=> 	$currency_details[0]['currency'],
				'position' 		=> 	$currency_details[0]['currency_position'],
			);
	
		//$reportList = $CI->parser->parse('report/stock_report_batch_wise',$data,true);
		return $data;
	}
	// product batch stock report product name 
	public function stock_report_batch_productname($product_id)
	{   
		$CI =& get_instance();
		$CI->load->model('Reports');
		$CI->load->model('Suppliers');
		$CI->load->library('occational');
		$stok_report = $CI->Reports->stock_report_batch_productname($product_id);
       $company_info = $CI->Reports->retrieve_company();
		$sub_total_in=0;
		$sub_total_out=0;
		$sub_total_stock=0;

		if(!empty($stok_report)){
			$i=0;
			

			foreach($stok_report as $k=>$v){$i++;
				 $stok_report[$k]['sl']=$i;

			    $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty']-$stok_report[$k]['totalSalesQnty']);

			    $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
			    $sub_total_out = $stok_report[$k]['SubTotalOut'];

			    $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
			    $sub_total_in = $stok_report[$k]['SubTotalIn'];

			    $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
			    $sub_total_stock = $stok_report[$k]['SubTotalStock'];

			}
		}

		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$company_info = $CI->Reports->retrieve_company();
		$data = array(
				'title' 		=> 	display('stock_report_batch_wise'),
				'stok_report' 	=> 	$stok_report,
				'product_model' => 	$stok_report[0]['product_model'],
				'links'			=>	'',
				'sub_total_in'	=>	$sub_total_in,
				'sub_total_out'	=>	$sub_total_out,
				'sub_total_stock'=>	$sub_total_stock,
				'company_info' 	=> 	$company_info,
				'currency' 		=> 	$currency_details[0]['currency'],
				'position' 		=> 	$currency_details[0]['currency_position'],
			);
	
		//$reportList = $CI->parser->parse('report/stock_report_batch_wise',$data,true);
		return $data;
	}
}
?>