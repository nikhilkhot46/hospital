<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcustomer {

	//Retrieve  Customer List	
	public function customer_list($links,$per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model('Patient');
		$CI->load->model('Setting_model');
		$customers_list = $CI->Patient->customer_list($per_page,$page);  
		$all_customer_list = $CI->Patient->all_customer_list();  
		$i=0;
		$total=0;
		if(!empty($customers_list)){	
			foreach($customers_list as $k=>$v){$i++;
			   $customers_list[$k]['sl']=$i+$CI->uri->segment(3);
			   $total+=$customers_list[$k]['customer_balance'];
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title' 	=> display('manage_customer'),
				'customers_list' => $customers_list,
				'all_customer_list' => $all_customer_list,
				'subtotal'	=>	number_format($total, 2, '.', ','),
				'links'		=>	$links,
				'currency' 	=> 	$currency_details[0]['currency'],
				'position' 	=> 	$currency_details[0]['currency_position'],
			);
		$customerList = $CI->parser->parse('customer/customer',$data,true);
		return $customerList;
	}

	//Retrieve  Credit Customer List	
	public function credit_customer_list($links,$per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model("Patient",'Customers');
		$CI->load->model('Setting_model');
		$customers_list = $CI->Customers->credit_customer_list($per_page,$page); 
		$all_credit_customer_list = $CI->Customers->all_credit_customer_list();

		//print_r($all_credit_customer_list);
		//It will get only Credit Customers
		$i=0;
		$total=0;
		if(!empty($customers_list)){	
			foreach($customers_list as $k=>$v){$i++;
			   $customers_list[$k]['sl']=$i+$page;
			   $total+=$customers_list[$k]['customer_balance'];
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title' 		 => display('credit_customer'),
				'customers_list' => $customers_list,
				'all_credit_customer_list' => $all_credit_customer_list,
				'subtotal' 		 =>number_format($total, 2, '.', ','),
				'links'          =>$links,
				'currency' 		 => $currency_details[0]['currency'],
				'position' 		 => $currency_details[0]['currency_position'],
			);
		//$customerList = $CI->parser->parse('customer/credit_customer',$data,true);
		return $data;
	}

	//##################  Paid  Customer List  ##########################	
	public function paid_customer_list($links,$per_page,$page)
	{
		$CI =& get_instance();
		//$CI->load->model('Customers');
		$CI->load->model('Setting_model');
		$customers_list = $CI->Customers->paid_customer_list($per_page,$page);
		$all_paid_customer_list = $CI->Customers->all_paid_customer_list();
	
		$i=0;
		$total=0;
		if(!empty($customers_list)){	
			foreach($customers_list as $k=>$v){$i++;
			   $customers_list[$k]['sl']=$i+$CI->uri->segment(3);
			   $total+=$customers_list[$k]['customer_balance'];
			}
		}
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data = array(
				'title' 	=> 	display('paid_customer'),
				'customers_list' => $customers_list,
				'all_paid_customer_list' => $all_paid_customer_list,
				'subtotal'	=>	number_format($total, 2, '.', ','),
				'links'		=>	$links,
				'currency' 	=> 	$currency_details[0]['currency'],
				'position' 	=> 	$currency_details[0]['currency_position'],
			);
		//$customerList = $CI->parser->parse('customer/paid_customer',$data,true);
		return $data;
	}
	
	
	//Retrieve  Customer Search List	
	public function customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$CI->load->model('Web_settings');
		$customers_list = $CI->Customers->customer_search_item($customer_id);
		$all_customer_list = $CI->Customers->all_customer_list();  
		$i=0;
		$total=0;
		if ($customers_list) {
			foreach($customers_list as $k=>$v)
			{
				$i++;
           		$customers_list[$k]['sl']=$i;
		    	$total+=$customers_list[$k]['customer_balance'];
			}
			$currency_details = $CI->Web_settings->retrieve_setting_editdata();
			$data = array(
					'title' 	=> display('manage_customer'),
					'subtotal'	=>	number_format($total, 2, '.', ','),
					'all_customer_list'=>$all_customer_list,
					'links'		=>	"",
					'customers_list' => $customers_list,
					'currency' 	=> $currency_details[0]['currency'],
					'position' 	=> $currency_details[0]['currency_position'],
				);
			$customerList = $CI->parser->parse('customer/customer',$data,true);
			return $customerList;
		}else{
			redirect('dashboard_pharmacist/patient/Cpatient//manage_customer');
		}
		
	}	

	//Retrieve  Credit Customer Search List	
	public function credit_customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Patient', 'Customers');
		$CI->load->model('Setting_model');
		$customers_list = $CI->Customers->credit_customer_search_item($customer_id);
		$all_credit_customer_list = $CI->Customers->all_credit_customer_list();

		$i=0;
		$total=0;
		if ($customers_list) {
			foreach($customers_list as $k=>$v)
			{
				$i++;
           		$customers_list[$k]['sl']=$i;
		    	$total+=$customers_list[$k]['customer_balance'];
			}
			$currency_details = $CI->Setting_model->retrieve_setting_editdata();
			$data = array(
					'title' 	=> display('manage_customer'),
					'subtotal'	=>	number_format($total, 2, '.', ','),
					'all_credit_customer_list'=>$all_credit_customer_list,
					'links'		=>	"",
					'customers_list' => $customers_list,
					'currency' => $currency_details[0]['currency'],
					'position' => $currency_details[0]['currency_position'],
				);
			//$customerList = $CI->parser->parse('customer/credit_customer',$data,true);
			return $data;
		}else{
			redirect('dashboard_pharmacist/patient/Cpatient/credit_customer');
		}
		
	}	

	//Retrieve  Paid Customer Search List	
	public function paid_customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Patient','Customers');
		$CI->load->model('Setting_model');
		$customers_list = $CI->Customers->paid_customer_search_item($customer_id);
		$all_paid_customer_list = $CI->Customers->all_paid_customer_list();
		$i=0;
		$total=0;
		if ($customers_list) {
			foreach($customers_list as $k=>$v)
			{
				$i++;
           		$customers_list[$k]['sl']=$i;
		    	$total+=$customers_list[$k]['customer_balance'];
			}
			$currency_details = $CI->Setting_model->retrieve_setting_editdata();
			$data = array(
					'title' 	=> display('manage_customer'),
					'subtotal'	=>	number_format($total, 2, '.', ','),
					'all_paid_customer_list'=>$all_paid_customer_list,
					'links'		=>	"",
					'customers_list' => $customers_list,
					'currency' 	=> $currency_details[0]['currency'],
					'position' 	=> $currency_details[0]['currency_position'],
				);
			//$customerList = $CI->parser->parse('customer/paid_customer',$data,true);
			return $data;
		}else{
			redirect('dashboard_pharmacist/patient/Cpatient/paid_customer');
		}
	}
	//Sub Category Add
	public function customer_add_form()
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$data = array(
				'title' => display('add_customer')
			);
		$customerForm = $CI->parser->parse('customer/add_customer_form',$data,true);
		return $customerForm;
	}
	public function insert_customer($data)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
        $CI->Customers->customer_entry($data);
		return true;
	}
	
	//customer Edit Data
	public function customer_edit_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$customer_detail = $CI->Customers->retrieve_customer_editdata($customer_id);
		$data=array(
			'title' 		=> display('customer_edit'),
			'customer_id' 	=> $customer_detail[0]['customer_id'],
			'customer_name' => $customer_detail[0]['customer_name'],
			'customer_address' 	=> $customer_detail[0]['customer_address'],
			'customer_mobile' 	=> $customer_detail[0]['customer_mobile'],
			'customer_email' 	=> $customer_detail[0]['customer_email'],
			'status' 		=> $customer_detail[0]['status']
			);
		$chapterList = $CI->parser->parse('customer/edit_customer_form',$data,true);
		return $chapterList;
	}

	//Customer ledger Data
	public function customer_ledger_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Patient','Customers');
		$CI->load->model('Setting_model','Web_settings');
		$CI->load->library('occational');
		$customer_detail = $CI->Customers->customer_personal_data($customer_id);
		$invoice_info 	= $CI->Customers->customer_invoice_data($customer_id);
		$invoice_amount = 0;
		if(!empty($invoice_info)){
			foreach($invoice_info as $k=>$v){
				$invoice_info[$k]['final_date'] = $CI->occational->dateConvert($invoice_info[$k]['date']);
				$invoice_amount = $invoice_amount+$invoice_info[$k]['amount'];
			}
		}
		$receipt_info 	= $CI->Customers->customer_receipt_data($customer_id);
		$receipt_amount = 0;
		if(!empty($receipt_info)){
			foreach($receipt_info as $k=>$v){
				$receipt_info[$k]['final_date'] = $CI->occational->dateConvert($receipt_info[$k]['date']);
				$receipt_amount = $receipt_amount+$receipt_info[$k]['amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$data=array(
			'title' 			=> display('customer_ledger'),
			'customer_id' 		=> $customer_detail[0]['patient_id'],
			'customer_name' 	=> $customer_detail[0]['firstname']." ".$customer_detail[0]['lastname'],
			'customer_address' 	=> $customer_detail[0]['address'],
			'customer_mobile' 	=> $customer_detail[0]['mobile'],
			'customer_email' 	=> $customer_detail[0]['email'],
			'receipt_amount' 	=> number_format($receipt_amount, 2, '.', ','),
			'invoice_amount' 	=> $invoice_amount,
			'invoice_info' 		=> $invoice_info,
			'receipt_info' 		=> $receipt_info,
			'currency' 			=> $currency_details[0]['currency'],
			'position' 			=> $currency_details[0]['currency_position'],
			
			);
		//$chapterList = $CI->parser->parse('customer/customer_details',$data,true);
		return $data;
	}
	
	//Customer ledger Data
	public function customerledger_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Patient');
		$CI->load->model('Setting_model');
		$CI->load->library('occational');
		$customer_detail = $CI->Patient->customer_personal_data($customer_id);
		$ledger 	= $CI->Patient->customerledger_tradational($customer_id);
		$summary 	= $CI->Patient->customer_transection_summary($customer_id);
	
		$balance = 0;
		if(!empty($ledger)){
			foreach($ledger as $index=>$value){
				$ledger[$index]['final_date'] = $CI->occational->dateConvert($ledger[$index]['date']);
				
				if(!empty($ledger[$index]['invoice_no'])or  $ledger[$index]['invoice_no']=="NA")
				{
					$ledger[$index]['credit']=$ledger[$index]['amount'];
					$ledger[$index]['balance']=$balance+$ledger[$index]['amount'];
					$ledger[$index]['debit']="";
					$balance=$ledger[$index]['balance'];
				}
				else
				{
					$ledger[$index]['debit']=$ledger[$index]['amount'];
					$ledger[$index]['balance']=$balance-$ledger[$index]['amount'];
					$ledger[$index]['credit']="";
					$balance=$ledger[$index]['balance'];
				}
				
			}
		}

		$company_info 	= $CI->Patient->retrieve_company();
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		$data=array(
			'title' 			=> display('customer_ledger'),
			'customer_id' 		=> $customer_detail[0]['patient_id'],
			'customer_name' 	=> $customer_detail[0]['firstname']." ".$customer_detail[0]['lastname'],
			'customer_address' 	=> $customer_detail[0]['address'],
			'customer_mobile' 	=> $customer_detail[0]['mobile'],
			'customer_email' 	=> $customer_detail[0]['email'],
			'ledger' 			=> $ledger,
			'total_credit'		=> number_format($summary[0][0]['total_credit'], 2, '.', ','),
			'total_debit'		=> number_format($summary[1][0]['total_debit'], 2, '.', ','),
			'total_balance'		=> number_format(-$summary[1][0]['total_debit']+$summary[0][0]['total_credit'], 2, '.', ','),
			'company_info'		=> $company_info,
			'currency' => $currency_details[0]['currency'],
			'position' => $currency_details[0]['currency_position'],
			);

		//$singlecustomerdetails = $CI->parser->parse('customer/customer_ledger',$data,true);
		return $data;
	}
	
	//Search customer
	public function customer_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$category_list = $CI->Customers->retrieve_category_list();
		$customers_list = $CI->Customers->customer_search_list($cat_id,$company_id);
		$data = array(
				'title' 		=> display('manage_customer'),
				'customers_list'=> $customers_list,
				'category_list' => $category_list
			);
		$customerList = $CI->parser->parse('customer/customer',$data,true);
		return $customerList;
	}
}
?>