<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lreturn {
public function return_form()
	{
		$CI =& get_instance();
		
		$data = array(
				'title' => 'return'
			);
		//$returnForm = $CI->parser->parse('return/form',$data,true);
		return $data;
	}
	public function invoice_return_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$invoice_detail = $CI->Invoices->retrieve_invoice_editdata($invoice_id);

		$i=0;
		if(!empty($invoice_detail)){		
			foreach($invoice_detail as $k=>$v){
				$i++;
			   	$invoice_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data=array(
			'title'				=>	display('invoice_return'),
			'invoice_id'		=>	$invoice_detail[0]['invoice_id'],
			'customer_id'		=>	$invoice_detail[0]['customer_id'],
			'customer_name'		=>	$invoice_detail[0]['customer_name'],
			'date'				=>	$invoice_detail[0]['date'],
			'total_amount'		=>	$invoice_detail[0]['total_amount'],
			'paid_amount'		=>	$invoice_detail[0]['paid_amount'],
			'due_amount'		=>	$invoice_detail[0]['due_amount'],
			'total_discount'	=>	$invoice_detail[0]['total_discount'], 
			'tax'				=>	$invoice_detail[0]['tax'],
			'total_tax'			=>	$invoice_detail[0]['total_tax'],
			'invoice_all_data'	=>	$invoice_detail,	
			'discount_type'  	=>	$currency_details[0]['discount_type'],
			);
		//$chapterList = $CI->parser->parse('return/return_data_form',$data,true);
		return $data;
	}
////start  Supplier return form data
	public function supplier_return_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('dashboard_pharmacist/Returnse');
		$CI->load->model('Setting_model');
		$purchase_detail = $CI->Returnse->supplier_return($purchase_id);

		$i=0;
		if(!empty($purchase_detail)){		
			foreach($purchase_detail as $k=>$v){
				$i++;
			   	$purchase_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data=array(
			'title'				=>	display('supplier_return'),
			'purchase_id'		=>	$purchase_detail[0]['purchase_id'],
			'supplier_id'		=>	$purchase_detail[0]['supplier_id'],
			'supplier_name'		=>	$purchase_detail[0]['supplier_name'],
			'date'				=>	$purchase_detail[0]['purchase_date'],
			'total_amount'		=>	$purchase_detail[0]['total_amount'],
			'total_discount'	=>	$purchase_detail[0]['total_discount'], 
			'purchase_all_data'	=>	$purchase_detail,	
			'discount_type'  	=>	$currency_details[0]['discount_type'],
			);
		//$chapterList = $CI->parser->parse('return/supplier_return_form',$data,true);
		return $data;
	}

	//// start return list
	public function return_list($links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$return_list = $CI->Returnse->return_list($perpage,$page);
		if(!empty($return_list)){
			foreach($return_list as $k=>$v){
				$return_list[$k]['final_date'] = $CI->occational->dateConvert($return_list[$k]['date_return']);
			}
			$i=0;
			if(!empty($return_list)){		
				foreach($return_list as $k=>$v){
					$i++;
				   	$return_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('return_list'),
				'return_list' => $return_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$returnList = $CI->parser->parse('return/return_list',$data,true);
		return $data;
	}
	/// end return list
// supplier return list
	public function supplier_return_list($links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$return_list = $CI->Returnse->supplier_return_list($perpage,$page);
		if(!empty($return_list)){
			foreach($return_list as $k=>$v){
				$return_list[$k]['final_date'] = $CI->occational->dateConvert($return_list[$k]['date_return']);
			}
			$i=0;
			if(!empty($return_list)){		
				foreach($return_list as $k=>$v){
					$i++;
				   	$return_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('return_list'),
				'return_list' => $return_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$returnList = $CI->parser->parse('return/return_supllier_list',$data,true);
		return $data;
	}
	// wastage return list start
	public function wastage_return_list($links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$return_list = $CI->Returnse->wastage_return_list($perpage,$page);
		if(!empty($return_list)){
			foreach($return_list as $k=>$v){
				$return_list[$k]['final_date'] = $CI->occational->dateConvert($return_list[$k]['date_return']);
			}
			$i=0;
			if(!empty($return_list)){		
				foreach($return_list as $k=>$v){
					$i++;
				   	$return_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('return_list'),
				'return_list' => $return_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$returnList = $CI->parser->parse('return/return_list',$data,true);
		return $data;
	}
	//wastage return list end
	public function invoice_html_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		$invoice_detail = $CI->Returnse->retrieve_invoice_html_data($invoice_id);

	
		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;
		$subTotal_ammount = 0;
		if(!empty($invoice_detail)){
			foreach($invoice_detail as $k=>$v){
				$invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date_return']);
				$subTotal_quantity = $subTotal_quantity+$invoice_detail[$k]['ret_qty'];
				$subTotal_ammount = $subTotal_ammount+$invoice_detail[$k]['total_ret_amount'];
			}

			$i=0;
			foreach($invoice_detail as $k=>$v){$i++;
			   $invoice_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$company_info = $CI->Invoices->retrieve_company();
		$data=array(
			'title'				=>	display('invoice_return'),
			'invoice_id'		=>	$invoice_detail[0]['invoice_id'],
			'invoice_no'		=>	$invoice_detail[0]['return_id'],
			'customer_name'		=>	$invoice_detail[0]['firstname']." ".$invoice_detail[0]['lastname'],
			'customer_address'	=>	$invoice_detail[0]['address'],
			'customer_mobile'	=>	$invoice_detail[0]['mobile'],
			'customer_email'	=>	$invoice_detail[0]['email'],
			'final_date'		=>	$invoice_detail[0]['final_date'],
			 'total_amount'		=>	number_format($invoice_detail[0]['net_total_amount'], 2, '.', ','),
			'subTotal_quantity'	=>	$subTotal_quantity,
			'deduction'	=>	number_format($invoice_detail[0]['deduction'], 2, '.', ','),
			'total_deduct'	=>	number_format($invoice_detail[0]['total_deduct'], 2, '.', ','),
			'total_tax'				=>	number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
			'subTotal_ammount'	=>	number_format($subTotal_ammount, 2, '.', ','),
			'note' => $invoice_detail[0]['reason'],
			
			'invoice_all_data'	=>	$invoice_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> 	$currency_details[0]['currency'],
			'position' 			=> 	$currency_details[0]['currency_position'],
			'discount_type'  	=> $currency_details[0]['discount_type'],
		);

		//$chapterList = $CI->parser->parse('return/return_invoice_html',$data,true);
		return $data;
	}
	// supplier return html data
	public function supplier_html_data($purchase_id)
	{
		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		$return_detail = $CI->Returnse->supplier_return_html_data($purchase_id);
		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;
		$subTotal_ammount = 0;
		if(!empty($return_detail)){
			foreach($return_detail as $k=>$v){
				$return_detail[$k]['final_date'] = $CI->occational->dateConvert($return_detail[$k]['date_return']);
				$subTotal_quantity = $subTotal_quantity+$return_detail[$k]['ret_qty'];
				$subTotal_ammount = $subTotal_ammount+$return_detail[$k]['total_ret_amount'];
			}

			$i=0;
			foreach($return_detail as $k=>$v){$i++;
			   $return_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$company_info = $CI->Invoices->retrieve_company();
		$data=array(
			'title'				=>	display('invoice_return'),
			'purchase_id'		=>	$return_detail[0]['purchase_id'],
			'invoice_no'		=>	$return_detail[0]['return_id'],
			'supplier_name'		=>	$return_detail[0]['supplier_name'],
			'address'	=>	$return_detail[0]['address'],
			'mobile'	=>	$return_detail[0]['mobile'],
			'final_date'		=>	$return_detail[0]['final_date'],
			 'total_amount'		=>	number_format($return_detail[0]['net_total_amount'], 2, '.', ','),
			'subTotal_quantity'	=>	$subTotal_quantity,
			'deduction'	=>	number_format($return_detail[0]['deduction'], 2, '.', ','),
			'total_deduct'	=>	number_format($return_detail[0]['total_deduct'], 2, '.', ','),
			'subTotal_ammount'	=>	number_format($subTotal_ammount, 2, '.', ','),
			'note' => $return_detail[0]['reason'],
			
			'return_detail'  	=>	$return_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> 	$currency_details[0]['currency'],
			'position' 			=> 	$currency_details[0]['currency_position'],
			'discount_type'  	=> $currency_details[0]['discount_type'],
		);

		//$chapterList = $CI->parser->parse('return/return_supplier_html',$data,true);
		return $data;
	}
	// date wise report return list invoice4 id
	public function return_list_datebetween($from_date,$to_date,$links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$return_list = $CI->Returnse->return_dateWise_invoice($from_date,$to_date,$perpage,$page);
		if(!empty($return_list)){
			foreach($return_list as $k=>$v){
				$return_list[$k]['final_date'] = $CI->occational->dateConvert($return_list[$k]['date_return']);
			}
			$i=0;
			if(!empty($return_list)){		
				foreach($return_list as $k=>$v){
					$i++;
				   	$return_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('return_list'),
				'return_list' => $return_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$returnList = $CI->parser->parse('return/return_list',$data,true);
		return $data;
	}
	// return report date wise supplier purchase return
	public function datewise_supplier_return_list($from_date,$to_date,$links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Returnse');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$return_list = $CI->Returnse->return_dateWise_supplier($from_date,$to_date,$perpage,$page);
		if(!empty($return_list)){
			foreach($return_list as $k=>$v){
				$return_list[$k]['final_date'] = $CI->occational->dateConvert($return_list[$k]['date_return']);
			}
			$i=0;
			if(!empty($return_list)){		
				foreach($return_list as $k=>$v){
					$i++;
				   	$return_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('return_list'),
				'return_list' => $return_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$returnList = $CI->parser->parse('return/return_supllier_list',$data,true);
		return $data;
	}
}