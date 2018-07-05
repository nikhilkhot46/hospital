<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Linvoice {
	
	//Retrieve  Invoice List
	public function invoice_list($links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$invoices_list = $CI->Invoices->invoice_list($perpage,$page);
		if(!empty($invoices_list)){
			foreach($invoices_list as $k=>$v){
				$invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
			}
			$i=0;
			if(!empty($invoices_list)){		
				foreach($invoices_list as $k=>$v){
					$i++;
				   	$invoices_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('manage_invoice'),
				'invoices_list' => $invoices_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$invoiceList = $CI->parser->parse('invoice/invoice',$data,true);
		return $data;
	}
	
	//inovie_manage search by invoice id
public function invoice_list_invoice_no($invoice_no)
	{

		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		
		$invoices_list = $CI->Invoices->invoice_list_invoice_id($invoice_no);
		if(!empty($invoices_list)){
			foreach($invoices_list as $k=>$v){
				$invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
			}
			$i=0;
			if(!empty($invoices_list)){		
				foreach($invoices_list as $k=>$v){
					$i++;
				   	$invoices_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('manage_invoice'),
				'invoices_list' => $invoices_list,
				'links'	   =>'',
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$invoiceList = $CI->parser->parse('invoice/invoice',$data,true);
		return $data;
	}
	// date to date invoice list 
	public function invoice_list_date_to_date($from_date,$to_date,$links,$perpage,$page)
	{

		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		$invoices_list = $CI->Invoices->invoice_list_date_to_date($from_date,$to_date,$perpage,$page);
		if(!empty($invoices_list)){
			foreach($invoices_list as $k=>$v){
				$invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
			}
			$i=0;
			if(!empty($invoices_list)){		
				foreach($invoices_list as $k=>$v){
					$i++;
				   	$invoices_list[$k]['sl']=$i+$CI->uri->segment(5);
				}
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title'    => display('manage_invoice'),
				'invoices_list' => $invoices_list,
				'links'	   => $links,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$invoiceList = $CI->parser->parse('invoice/invoice',$data,true);
		return $data;
	}


	//Pos invoice add form
	public function pos_invoice_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$customer_details = $CI->Invoices->pos_customer_setup();
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title' 		=> display('add_new_pos_invoice'),
				'customer_name' => $customer_details[0]['customer_name'],
				'customer_id' 	=> $customer_details[0]['customer_id'],
				'discount_type' => $currency_details[0]['discount_type'],
			);
		$invoiceForm = $CI->parser->parse('invoice/add_pos_invoice_form',$data,true);
		return $invoiceForm;
	}

	//Retrieve  Invoice List
	public function search_inovoice_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->library('occational');
		$invoices_list = $CI->Invoices->search_inovoice_item($customer_id);
		if(!empty($invoices_list)){
			foreach($invoices_list as $k=>$v){
				$invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
			}
			$i=0;
			if(!empty($invoices_list)){		
				foreach($invoices_list as $k=>$v){
					$i++;
				   	$invoices_list[$k]['sl']=$i+$CI->uri->segment(3);
				}
			}
		}
		$data = array(
				'title' 		=> display('manage_invoice'),
				'invoices_list' => $invoices_list
			);
		$invoiceList = $CI->parser->parse('invoice/invoice',$data,true);
		return $invoiceList;
	}

	//Invoice add form
	public function invoice_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title' => display('add_new_invoice'),
				'discount_type' => $currency_details[0]['discount_type'],
			);
		//$invoiceForm = $CI->parser->parse('invoice/add_invoice_form',$data,true);
		return $data;
	}

	//Insert invoice
	public function insert_invoice($data)
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
        $CI->Invoices->invoice_entry($data);
		return true;
	}

	//Invoice Edit Data
public function invoice_edit_data($invoice_id)
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
			'title'				=>	display('invoice_edit'),
			'invoice_id'		=>	$invoice_detail[0]['invoice_id'],
			'customer_id'		=>	$invoice_detail[0]['customer_id'],
			'admission_id'		=>	$invoice_detail[0]['admission_id'],
			'customer_name'		=>	$invoice_detail[0]['customer_name'],
			'date'				=>	$invoice_detail[0]['date'],
			'invoice_details'  =>   $invoice_detail[0]['invoice_details'],
			'total_amount'		=>	$invoice_detail[0]['total_amount'],
			'paid_amount'		=>	$invoice_detail[0]['paid_amount'],
			'due_amount'		=>	$invoice_detail[0]['due_amount'],
			'total_discount'	=>	$invoice_detail[0]['total_discount'], 
			'unit'              =>  $invoice_detail[0]['unit'],
			'total_tax'			=>	$invoice_detail[0]['total_tax'],
			'invoice_all_data'	=>	$invoice_detail,
			'discount_type'  	=>	$currency_details[0]['discount_type'],
			);
		//$chapterList = $CI->parser->parse('invoice/edit_invoice_form',$data,true);
		return $data;
	}

	//Invoice html Data
	public function invoice_html_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		$invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);

	
		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;
		$subTotal_ammount = 0;
		if(!empty($invoice_detail)){
			foreach($invoice_detail as $k=>$v){
				$invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity+$invoice_detail[$k]['quantity'];
				$subTotal_ammount = $subTotal_ammount+$invoice_detail[$k]['total_price'];
			}

			$i=0;
			foreach($invoice_detail as $k=>$v){$i++;
			   $invoice_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$company_info = $CI->Invoices->retrieve_company();
		$data=array(
			'title'				=>	display('invoice_details'),
			'invoice_id'		=>	$invoice_detail[0]['invoice_id'],
			'invoice_no'		=>	$invoice_detail[0]['invoice'],
			'customer_name'		=>	$invoice_detail[0]['firstname']." " .$invoice_detail[0]['lastname'],
			'customer_address'	=>	$invoice_detail[0]['address'],
			'customer_mobile'	=>	$invoice_detail[0]['mobile'],
			'customer_email'	=>	$invoice_detail[0]['email'],
			'final_date'		=>	$invoice_detail[0]['final_date'],
			'invoice_details'  =>   $invoice_detail[0]['invoice_details'],
			'total_amount'		=>	number_format($invoice_detail[0]['total_amount'], 2, '.', ','),
			'subTotal_quantity'	=>	$subTotal_quantity,
			'total_discount'	=>	number_format($invoice_detail[0]['total_discount'], 2, '.', ','),
			'total_tax'				=>	number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
			'subTotal_ammount'	=>	number_format($subTotal_ammount, 2, '.', ','),
			'paid_amount'		=>	number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),
			'due_amount'		=>	number_format($invoice_detail[0]['due_amount'], 2, '.', ','),
			'invoice_all_data'	=>	$invoice_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> 	$currency_details[0]['currency'],
			'position' 			=> 	$currency_details[0]['currency_position'],
			'discount_type'  	=> $currency_details[0]['discount_type'],
		);

		//$chapterList = $CI->parser->parse('invoice/invoice_html',$data,true);
		return $data;
	}

	//POS invoice html Data
	public function pos_invoice_html_data($invoice_id)
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		$invoice_detail = $CI->Invoices->retrieve_invoice_html_data($invoice_id);
	
		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;
		$subTotal_ammount = 0;
		if(!empty($invoice_detail)){
			foreach($invoice_detail as $k=>$v){
				$invoice_detail[$k]['final_date'] = $CI->occational->dateConvert($invoice_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity+$invoice_detail[$k]['quantity'];
				$subTotal_ammount = $subTotal_ammount+$invoice_detail[$k]['total_price'];
			}

			$i=0;
			foreach($invoice_detail as $k=>$v){$i++;
			   $invoice_detail[$k]['sl']=$i;
			}
		}

		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$company_info = $CI->Invoices->retrieve_company();
		$data=array(
			'ttile'				=>	display('invoice_details'),
			'invoice_id'		=>	$invoice_detail[0]['invoice_id'],
			'invoice_no'		=>	$invoice_detail[0]['invoice'],
			'customer_name'		=>	$invoice_detail[0]['customer_name'],
			'customer_address'	=>	$invoice_detail[0]['customer_address'],
			'customer_mobile'	=>	$invoice_detail[0]['customer_mobile'],
			'customer_email'	=>	$invoice_detail[0]['customer_email'],
			'final_date'		=>	$invoice_detail[0]['final_date'],
			'invoice_details'  =>   $invoice_detail[0]['invoice_details'],

			'total_amount'		=>	number_format($invoice_detail[0]['total_amount'], 2, '.', ','),
			'subTotal_cartoon'	=>	$subTotal_cartoon,
			'subTotal_quantity'	=>	$subTotal_quantity,
			'total_discount'	=>	number_format($invoice_detail[0]['total_discount'], 2, '.', ','),
			'total_tax'				=>	number_format($invoice_detail[0]['total_tax'], 2, '.', ','),
			'subTotal_ammount'	=>	number_format($subTotal_ammount, 2, '.', ','),
			'paid_amount'		=>	number_format($invoice_detail[0]['paid_amount'], 2, '.', ','),
			'due_amount'		=>	number_format($invoice_detail[0]['due_amount'], 2, '.', ','),
			'invoice_all_data'	=>	$invoice_detail,
			'company_info'		=>	$company_info,
			'currency' 			=> $currency_details[0]['currency'],
			'position' 			=> $currency_details[0]['currency_position'],
			);

		$chapterList = $CI->parser->parse('invoice/pos_invoice_html',$data,true);
		return $chapterList;
	}
}
?>