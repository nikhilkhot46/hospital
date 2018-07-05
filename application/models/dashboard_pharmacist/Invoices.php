<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoices extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('patient_model');
		$this->load->library('auth');
	}
	//Count invoice
	public function count_invoice()
	{
		return $this->db->count_all("invoice");
	}
	//invoice List
	public function invoice_list($perpage,$page)
	{
		$this->db->select('a.*,concat(b.firstname, " ", b.lastname) as firstname');
		$this->db->from('invoice a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	
	// invoice search by invoice id
		public function invoice_list_invoice_id($invoice_no)
	{
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('invoice a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
	
		$this->db->where('invoice',$invoice_no);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	// date to date invoice list
	public function invoice_list_date_to_date($from_date,$to_date,$perpage,$page)
	{
		$dateRange = "a.date BETWEEN '$from_date' AND '$to_date'";
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('invoice a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->order_by('a.invoice','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//invoice List
	public function invoice_list_count()
	{
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('invoice a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}

	//invoice Search Item
	public function search_inovoice_item($customer_id)
	{
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('invoice a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('b.patient_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//POS invoice entry
public function pos_invoice_setup($product_id){
		$product_information = $this->db->select('a.*,b.*,c.*')
						->from('product_information a')
						->join('supplier_product b','b.product_id=b.product_id')
						->join('product_purchase_details c','a.product_id=c.product_id')
						->where('a.product_id',$product_id)
						->get()
						->row();

		if ($product_information != null) {

			$this->db->select('SUM(a.quantity) as total_purchase');
			$this->db->from('product_purchase_details a');
			$this->db->where('a.product_id',$product_id);
			$total_purchase = $this->db->get()->row();

			$this->db->select('SUM(b.quantity) as total_sale');
			$this->db->from('invoice_details b');
			$this->db->where('b.product_id',$product_id);
			$total_sale = $this->db->get()->row();

			$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

			$data2 = (object)array(
				'total_product' 	=> $available_quantity,
				'supplier_price' 	=> $product_information->supplier_price, 
				'price' 			=> $product_information->price, 
				'batch_id'          => $product_information->batch_id,
				'expeire_date'      => $product_information->expeire_date,
				'supplier_id' 		=> $product_information->supplier_id, 
				'product_id' 		=> $product_information->product_id, 
				'discount' 		    => $product_information->product_id,
				'product_name' 		=> $product_information->product_name, 
				'product_model' 	=> $product_information->product_model,
				'unit' 				=> $product_information->unit,
				'tax' 				=> $product_information->tax,
				);

			return $data2;
		}else{
			return false;
		}
	}
	//POS customer setup
	public function pos_customer_setup(){
		$query= $this->db->select('*')
						->from('customer_information')
						->where('customer_name','Walking Customer')
						->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Count invoice
	public function invoice_entry()
	{
		$invoice_id = $this->generator(10);
		$invoice_id = strtoupper($invoice_id);

		$quantity = $this->input->post('product_quantity');
		$available_quantity = $this->input->post('available_quantity');
		$cartoon = $this->input->post('cartoon');
		$transection_id=$this->auth->generator(15);
		$result = array();
		foreach($available_quantity as $k => $v)
		{
		    if($v < $quantity[$k])
		    {
		       $this->session->set_userdata(array('error_message'=>display('you_can_not_buy_greater_than_available_qnty')));
		       redirect('dashboard_pharmacist/invoice/Cinvoice');
		    }
		}

		
		$product_id = $this->input->post('product_id');
		if ($product_id == null) {
			$this->session->set_userdata(array('error_message'=>display('please_select_product')));
			redirect('dashboard_pharmacist/invoice/Cinvoice/pos_invoice');
		}

		if (($this->input->post('customer_name_others') == null) && ($this->input->post('customer_id') == null ) && ($this->input->post('customer_name') == null )) {
			$this->session->set_userdata(array('error_message'=>display('please_select_customer')));
			redirect(base_url().'dashboard_pharmacist/invoice/Cinvoice');
		}

		
		if(($this->input->post('customer_id') == null ) && ($this->input->post('customer_name') == null ))
		{
			$customer_id="P".$this->auth->randStrGen(2,7);
		  	//Customer  basic information adding.
			$data=array(
				'patient_id' 		=> 	$customer_id,
				'firstname' 	=> 	$this->input->post('customer_name_others'),
				'address' 	=>	$this->input->post('customer_name_others_address'),
				'phone' 	=> "",
				'email' 	=> "",
				"created_by" =>$this->session->userdata('user_role'),
				'status' 			=> 2
				);
		
			
			$this->db->insert('patient',$data);
			$this->db->select('*');
			$this->db->from('patient');
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_customer[] = array('label'=>$row->firstname." ".$row->lastname,'value'=>$row->patient_id);
			}
			$cache_file ='./my-assets/js/admin_js/json/customer.json';
			$customerList = json_encode($json_customer);
			file_put_contents($cache_file,$customerList);
			
		  	//Previous balance adding -> Sending to customer model to adjust the data.
			//$this->Customers->previous_balance_add(0,$customer_id);
			$this->patient_model->previous_balance_add(0,$customer_id);
		}
		else{
			$customer_id=$this->input->post('customer_id');
		}

		if($this->input->post('admission_id', true) == "on"){
			$aid = $this->patient_model->check_patient_aid($customer_id);
			if(empty($aid)){
				$this->session->set_flashdata('exception', display('patient_not_admitted'));
				redirect('dashboard_pharmacist/invoice/Cinvoice');
			}
			$admission_id =  $aid->admission_id;
		}
		else{
			$admission_id ="";
		}


		//Full or partial Payment record.
		$paid_amount=$this->input->post('paid_amount');
		if($this->input->post('paid_amount') > 0)
		{

			// $this->db->set('status', '1');
			// $this->db->where('customer_id', $customer_id);
			
			// $this->db->update('customer_information');

          

			//Insert to customer_ledger Table 
			$data2 = array(
				'transaction_id'	=>	$transection_id,
				'customer_id'		=>	$customer_id,
				'receipt_no'		=>	$this->auth->generator(10),
				'date'				=>	$this->input->post('invoice_date'),
				'amount'			=>	$this->input->post('paid_amount'),
				'payment_type'		=>	1,
				'description'		=>	'ITP',
				'status'			=>	1
			);
			$this->db->insert('customer_ledger',$data2);
			  //$transection_id=$this->auth->generator(15);
			//Account table info
			$datat = array(
				'transaction_id'	    =>	$transection_id,
				'relation_id'		    =>	$customer_id,
				'transection_type'	    =>	2,
				'date_of_transection'	=>	$this->input->post('invoice_date'),
				'transection_category'  =>2,
				'amount'			    =>	$this->input->post('paid_amount'),
				'transection_mood'	    =>	1,
				'description'		    =>	'ITP'
				
			);
		
			 $this->db->insert('transection',$datat);
		
			// Inserting for Accounts adjustment.
			############ default table :: customer_payment :: inflow_92mizdldrv #################
		
		}

		//Data inserting into invoice table
		$datainv=array(
			'invoice_id'		=>	$invoice_id,
			'customer_id'		=>	$customer_id,
			'admission_id'		=>	$admission_id,
			'date'				=>	$this->input->post('invoice_date'),
			'total_amount'		=>	$this->input->post('grand_total_price'),
			'total_tax'			=>	$this->input->post('total_tax'),
			'invoice'			=>	$this->number_generator(),
			'invoice_details'   =>  $this->input->post('inva_details'),
			'total_discount' 	=> 	$this->input->post('total_discount'),
			'status'			=>	1
		);
		$this->db->insert('invoice',$datainv);
		
		// Insert to customer_ledger Table 
		$data4 = array(
			'transaction_id'	=>	$transection_id,
			'customer_id'		=>	$customer_id,
			'invoice_no'		=>	$invoice_id,
			'date'				=>	$this->input->post('invoice_date'),
			'amount'			=>	$this->input->post('grand_total_price'),
			'status'			=>	1
		);
		$this->db->insert('customer_ledger',$data4);

		
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');
		$total_amount   = $this->input->post('total_price');
		$discount_rate  = $this->input->post('discount');
		$tax_amount 	= $this->input->post('tax');
		$batch_id 	    = $this->input->post('batch_id');

		for ($i=0, $n=count($quantity); $i < $n; $i++) {
			$cartoon_quantity = $cartoon[$i];
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $total_amount[$i];
			$supplier_rate=$this->supplier_rate($product_id);
			$discount = $discount_rate[$i];
			$tax = $tax_amount[$i];
			$batch= $batch_id[$i];
			
			

			$data1 = array(
				'invoice_details_id'	=>	$this->generator(15),
				'invoice_id'			=>	$invoice_id,
				'product_id'			=>	$product_id,
				'batch_id'              =>  $batch,
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'discount'           	=>	$discount,
				'tax'           		=>	$tax,
				'paid_amount'           =>	$this->input->post('paid_amount'),
				'due_amount'           	=>	$this->input->post('due_amount'),
				'supplier_rate'         =>	$supplier_rate[0]['supplier_price'],
				'total_price'           =>	$total_price,
				'status'				=>	1
			);
			
			
			if(!empty($quantity))
			{
				$this->db->insert('invoice_details',$data1);
			}
		}
		return $invoice_id;
	}
	//Get Supplier rate of a product
	public function supplier_rate($product_id)
	{
		$this->db->select('supplier_price');
		$this->db->from('supplier_product');
		$this->db->where(array('product_id' => $product_id)); 
		$query = $this->db->get();
		return $query->result_array();
	
	}
	//Retrieve invoice Edit Data
public function retrieve_invoice_editdata($invoice_id)
	{
		$this->db->select("
			a.*,
			c.*,
			a.total_tax,
			CONCAT(b.firstname,' ' ,b.lastname) as customer_name,
			c.batch_id,
			c.tax as t_p_tax,
			c.product_id,
			d.product_name,
			d.product_model,
			d.tax,
			d.unit
			");
		$this->db->from('invoice a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.invoice_id',$invoice_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//invoice wise prouduct list
	
	//update_invoice
	public function update_invoice()
	{
		$invoice_id = $this->input->post('invoice_id');
		

		$ab=$this->db->select('transaction_id')->from('customer_ledger')->where('invoice_no',$invoice_id)->get()->result();
		foreach ($ab as $ab) {
			$tran=$ab->transaction_id;
		}
	
		
		$this->db->where('transaction_id',$tran);
		$this->db->delete('customer_ledger'); 
				
        $this->db->where('transaction_id',$tran);
		$this->db->delete('transection');
		
		if($this->input->post('admission_id', true) == "on"){
			$aid = $this->patient_model->check_patient_aid($this->input->post('customer_id'));
			if(empty($aid)){
				$this->session->set_flashdata('exception', display('patient_not_admitted'));
				redirect('dashboard_pharmacist/invoice/Cinvoice/invoice_update_form/'.$invoice_id);
			}
			$admission_id =  $aid->admission_id;
		}
		else{
			$admission_id ="";
		}

		$datarcpt = array(
			'transaction_id'	=>	$tran,
			'customer_id'		=>	$this->input->post('customer_id'),
			'receipt_no'		=>	$this->auth->generator(10),
			'date'				=>	$this->input->post('invoice_date'),
			'amount'			=>	$this->input->post('paid_amount'),
			'payment_type'		=>	1,
			'description'		=>	'ITP',
			'status'			=>	1
		);
		

	
		$data=array(
		    'invoice_id'        =>  $invoice_id,
			'customer_id'		=>	$this->input->post('customer_id'),
			'admission_id'		=>	$admission_id,
			'date'				=>	$this->input->post('invoice_date'),
			'total_amount'		=>	$this->input->post('grand_total_price'),
			'total_tax'			=>	$this->input->post('total_tax'),
			'invoice_details'   =>  $this->input->post('inva_details'),
			'total_discount' 	=> 	$this->input->post('total_discount'),
		);
		$data2 = array(
			'transaction_id'	=>	$tran,
			'customer_id'		=>	$this->input->post('customer_id'),
			'invoice_no'		=>	$invoice_id,
			'date'				=>	$this->input->post('invoice_date'),
			'amount'			=>	$this->input->post('grand_total_price'),
			'payment_type'		=>	1,
			'description'		=>	'ITP',
			'status'			=>	1
		);

		$data3 = array(
			'transaction_id'	=>  $tran,
			'relation_id'		=>	$this->input->post('customer_id'),
			'transection_type'	=>	2,
			'date_of_transection'	=>	$this->input->post('invoice_date'),
			'transection_category'  =>2,
			'amount'			=>	$this->input->post('paid_amount'),
			'transection_mood'	=>	1,
			'description'		=>	'ITP'
			
		);
		
		if($invoice_id!='')
		{
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('invoice',$data); 
			
			//Update Another table
			$this->db->insert('customer_ledger',$data2); 
			$this->db->insert('customer_ledger',$datarcpt);
			$this->db->insert('transection',$data3);
		}

		// Inserting for Accounts adjustment.
		############ default table :: customer_payment :: inflow_92mizdldrv #################
		//Insert to customer_ledger Table 

		//$this->db->insert($account_table,$account_adjustment);

        $invoice_d_id 	= $this->input->post('invoice_details_id');
        $cartoon 		= $this->input->post('cartoon');
        $quantity 		= $this->input->post('product_quantity');
		$rate 			= $this->input->post('product_rate');
		$p_id 			= $this->input->post('product_id');
		$total_amount 	= $this->input->post('total_price');
		$discount_rate 	= $this->input->post('discount');
		$batch_id 	    = $this->input->post('batch_id');
		$tax_amount 	= $this->input->post('tax');

        $this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice_details'); 
	
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$cartoon_quantity = $cartoon[$i];
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$total_price 	  = $total_amount[$i];
			$supplier_rate 	  = $this->supplier_rate($product_id);
			$discount 		  = $discount_rate[$i];
			$batch 			  = $batch_id[$i];
			$tax 			  = $tax_amount[$i];
			
			$data1 = array(
				'invoice_details_id'=>$this->generator(15),
				'invoice_id'	=>	$invoice_id,
				'product_id'	=>	$product_id,
				'batch_id'      =>  $batch,
				'quantity'		=>	$product_quantity,
				'rate'			=>	$product_rate,
				'discount'		=>	$discount,
				'total_price'	=>	$total_price,
				'tax'   		=>	$tax,
				'paid_amount'   =>	$this->input->post('paid_amount'),
				'due_amount'    =>	$this->input->post('due_amount'),
				'supplier_rate' =>	$supplier_rate[0]['supplier_price'],
				'total_price'   =>	$total_price,
				'status'		=>	1
			);
			$this->db->insert('invoice_details',$data1);

	 	
		}
	
		return $invoice_id;
	}
	//Retrieve invoice_html_data
	public function retrieve_invoice_html_data($invoice_id)
	{
		$this->db->select('a.total_tax,
						a.*,
						b.*,
						c.*,
						d.product_id,
						d.product_name,
						d.product_details,
						d.product_model');
		$this->db->from('invoice a');
		
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.invoice_id',$invoice_id);
		$this->db->where('c.quantity >',0);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete invoice Item
	public function retrieve_product_data($product_id)
	{
		$this->db->select('supplier_price,price,supplier_id,tax');
		$this->db->from('product_information a');
		$this->db->join('supplier_product b','a.product_id=b.product.id');
		$this->db->where(array('a.product_id' => $product_id,'a.status' => 1)); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	//Retrieve company Edit Data
	public function retrieve_company()
	{
		$this->db->select('*');
		$this->db->from('setting');
		$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete invoice Item
	public function delete_invoice($invoice_id)
	{	
		//Delete Invoice table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice'); 
		//Delete invoice_details table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice_details'); 
		return true;
	}
	public function invoice_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('invoices a');
		$this->db->join('invoice_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('invoice_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL PURCHASE PRODUCT
	public function get_total_purchase_item($product_id)
	{
		$this->db->select('SUM(quantity) as total_purchase');
		$this->db->from('product_purchase_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL SALES PRODUCT
	public function get_total_sales_item($product_id)
	{
		$this->db->select('SUM(quantity) as total_sale');
		$this->db->from('invoice_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Get total product
	public function get_total_product($product_id,$supplier_id){
		$this->db->select('SUM(a.quantity) as total_purchase,b.*');
		$this->db->from('product_purchase_details a');
		$this->db->join('supplier_product b','a.product_id=b.product_id');
		$this->db->where('a.product_id',$product_id);
		$this->db->where('b.supplier_id',$supplier_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.product_id',$product_id);
		$total_sale = $this->db->get()->row();

		$this->db->select('a.*,b.*');
		$this->db->from('product_information a');
        $this->db->join('supplier_product b','a.product_id=b.product_id');
		$this->db->where(array('a.product_id' => $product_id,'a.status' => 1)); 
		$this->db->where('b.supplier_id',$supplier_id);
		$product_information = $this->db->get()->row();

		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

		$CI =& get_instance();
		$CI->load->model('Setting_model');
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		
		$data2 = array(
			'total_product'  => $available_quantity, 
			'supplier_price' => $product_information->supplier_price, 
			'price' 	     => $product_information->price, 
			'supplier_id' 	 => $product_information->supplier_id,
			'unit' 	 		 => $product_information->unit,
			'tax' 	 		 => $product_information->tax,
			'discount_type'  => $currency_details[0]['discount_type'],
			);

		return $data2;
	}
// product information retrieve by product id
	public function get_total_product_invoic($product_id){
		$this->db->select('SUM(a.quantity) as total_purchase');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.product_id',$product_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.product_id',$product_id);
		$total_sale = $this->db->get()->row();

		$this->db->select('a.*,b.*');
		$this->db->from('product_information a');
        $this->db->join('supplier_product b','a.product_id=b.product_id');
		$this->db->where(array('a.product_id' => $product_id,'a.status' => 1)); 
		$product_information = $this->db->get()->row();

		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

		$CI =& get_instance();
		$CI->load->model('Setting_model');
		$CI->load->model('Products');
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
        $content = $CI->Products->batch_search_item($product_id);


        $html = "";
        if (empty($content)) {
        	$html .="No Product Found !";
	    }else{
	    	// Select option created for product
	        $html .="<select name=\"batch_id[]\"   class=\"batch_id_1 form-control\" id=\"batch_id_1\" required=\"required\">";
	        	$html .= "<option>".display('select_one')."</option>";
	        	foreach ($content as $product) {
	    			$html .="<option value=".$product['batch_id'].">".$product['batch_id']."</option>";
	        	}	
	        $html .="</select>";
	    }

		$data2 = array(
			'total_product'  => $available_quantity, 
			'supplier_price' => $product_information->supplier_price, 
			'price' 	     => $product_information->price, 
			'supplier_id' 	 => $product_information->supplier_id,
			'unit' 	 		 => $product_information->unit,
			'tax' 	 		 => $product_information->tax,
			'batch' 	 	 => $html,
			'discount_type'  => $currency_details[0]['discount_type'],
			);

		return $data2;
	}
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("1","2","3","4","5","6","7","8","9");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,8);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}
	//NUMBER GENERATOR
	public function number_generator()
	{
		$this->db->select_max('invoice', 'invoice_no');
		$query = $this->db->get('invoice');	
		$result = $query->result_array();	
		$invoice_no = $result[0]['invoice_no'];
		if ($invoice_no !='') {
			$invoice_no = $invoice_no + 1;	
		}else{
			$invoice_no = 1000;
		}
		return $invoice_no;		
	}
	// stock availavel by batch id
	public function get_total_product_batch($batch_id){

		$CI =& get_instance();
		$CI->load->model('Setting_model');

		$this->db->select('SUM(a.quantity) as total_purchase,a.expeire_date');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.batch_id',$batch_id);
		$this->db->group_by('a.batch_id');
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.batch_id',$batch_id);
		$total_sale = $this->db->get()->row();
		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
		
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		
		$data2 = array(
			'total_product'  => $available_quantity,
			'expire_date' => $total_purchase->expeire_date,
			);

		return $data2;
	}
	

}