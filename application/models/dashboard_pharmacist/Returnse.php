<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Returnse extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcustomer');
		$this->load->model('Patient','Customers');
	}

public function return_invoice_entry()
	{
		 $invoice_id = $this->input->post('invoice_id');


		
		 $tran=$this->db->select('*')->from('customer_ledger')->where('invoice_no',$invoice_id)->get()->result();
		foreach ($tran as  $value) {}
			$transection_id=$value->transaction_id;

          $total=$this->input->post('grand_total_price');
		 $customer_id=$this->input->post('customer_id');
		  $isrtn=$this->input->post('rtn'); 
		 

		$date=date('Y-m-d'); 
		$data4 = array(
			'transaction_id'	=>	$transection_id,
			'customer_id'		=>	$customer_id,
			'invoice_no'		=>	$invoice_id,
			'date'				=>	$date,
			'description'		=>	'Return',
			'amount'			=>	-$total,
			'status'			=>	1
		);

       $ads=$this->input->post('radio');

    
     	if($ads==1){
     	$this->db->insert('customer_ledger',$data4);
     	// $this->db->insert('customer_ledger',$datarcpt);
     	}
     
       
       
		$quantity = $this->input->post('product_quantity');
		$available_quantity = $this->input->post('available_quantity');
		
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');

		$total_amount = $this->input->post('total_price');
		$discount_rate = $this->input->post('discount');
		$tax_amount 	= $this->input->post('tax');
        $soldqty=$this->input->post('sold_qty');
         $batch=$this->input->post('batch_id');
       
		
		 
		if (is_array($p_id))
		 for ($i=0; $i < count($p_id); $i++) 
		{
			


				$product_quantity = $quantity[$i];
				$product_rate = $rate[$i];
				$product_id = $p_id[$i];
				//$supplier_rate=$this->supplier_rate($product_id);
				$sqty=$soldqty[$i];
				$total_price = $total_amount[$i];
				 $batch_id = $batch[$i];
				$discount = $discount_rate[$i];
				$tax = -$tax_amount[$i];


				$data1 = array(
					'invoice_details_id'	=>	$this->generator(15),
					'invoice_id'			=>	$invoice_id,
					'product_id'			=>	$product_id,
					'quantity'				=>	-$product_quantity,
					'rate'					=>	$product_rate,
					'discount'           	=>	-$discount,
					'tax'           		=>	$tax,
				 	'batch_id'              =>  $batch_id,
					'paid_amount'           =>	-$total,
					'total_price'           =>	-$total_price,
					'status'				=>	1
				);


				$returns = array(
					'return_id'   	        =>	$this->generator(15),
					'invoice_id'			=>	$invoice_id,
					'product_id'			=>	$product_id,
					'customer_id'           =>$this->input->post('customer_id'),
					'ret_qty'				=>	$product_quantity,
					'byy_qty'               =>  $sqty,
					'date_purchase'         => $this->input->post('invoice_date'),
					'date_return'           => $date,
					'product_rate'			=>	$product_rate,
					'deduction'           	=>	$discount,
					'total_deduct'          => $this->input->post('total_discount'),
					'total_tax'                   => $this->input->post('total_tax'),
					'total_ret_amount'       =>	$total_price,
					'net_total_amount'       =>$this->input->post('grand_total_price'),
					'reason'       =>$this->input->post('details'),
					'usablity'				=>	$this->input->post('radio')
				); 
               
				if($ads==1){	
					$this->db->insert('invoice_details',$data1);
				}
				$this->db->insert('product_return',$returns);
			
		}
		 
		 return $invoice_id;
	}
	///////#################### Supplier return  Entry ############///////////
	public function return_supplier_entry()
	{
		 $purchase_id = $this->input->post('purchase_id');
  
          $total=$this->input->post('grand_total_price');
		 $supplier_id=$this->input->post('supplier_id');
		  $isrtn=$this->input->post('rtn'); 	 

		$date=date('Y-m-d'); 
		$data4 = array(
			'transaction_id'	=>	$purchase_id,
			'supplier_id'		=>	$supplier_id,
			'chalan_no'		    =>	$this->auth->generator(10),
			'date'				=>	$date,
			'description'		=>	'Return',
			'amount'			=>	-$total,
			'status'			=>	1
		);

     	$this->db->insert('supplier_ledger',$data4);
       
		$quantity = $this->input->post('product_quantity');
		$available_quantity = $this->input->post('available_quantity');
		$cartoon = $this->input->post('cartoon');
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');
		$total_amount = $this->input->post('total_price');
		$discount_rate = $this->input->post('discount');
        $soldqty=$this->input->post('ret_qty');
        $batch=$this->input->post('batch_id');
        $expire_date=$this->input->post('expire_date');
		$pdid=$this->generator(15);
		 
		 
		if (is_array($p_id))
		 for ($i=0; $i < count($p_id); $i++) 
		{ 
				$cartoon_quantity = $cartoon[$i];
				$product_quantity = $quantity[$i];
				$product_rate = $rate[$i];
				$product_id = $p_id[$i];
				$batch_id= $batch[$i];
				$expire=  $expire_date[$i];
				$sqty=$soldqty[$i];
				$total_price = $total_amount[$i];
				
				$discount = $discount_rate[$i];
			
                $detais_id=$pdid[$i];

				$data1 = array(
					'purchase_detail_id'	=>	$this->generator(15),
					'purchase_id'			=>	$purchase_id,
					'product_id'			=>	$product_id,
					'batch_id'              =>  $batch_id,
					'expeire_date'           =>  $expire,
					'quantity'				=>	-$product_quantity,
					'rate'					=>	$product_rate,
					'discount'           	=>	-$discount,
					'total_amount'           =>	-$total_price,
					'status'				=>	1
				);


				$returns = array(
					'return_id'   	        =>	$this->generator(15),
					'purchase_id'			=>	$purchase_id,
					'product_id'			=>	$product_id,
					'supplier_id'           =>$this->input->post('supplier_id'),
					'ret_qty'				=>	$product_quantity,
					'byy_qty'               =>  $sqty,
					'date_purchase'         => $this->input->post('return_date'),
					'date_return'           => $date,
					'product_rate'			=>	$product_rate,
					'deduction'           	=>	$discount,
					'total_deduct'          => $this->input->post('total_discount'),
					'total_ret_amount'       =>	$total_price,
					'net_total_amount'       =>$this->input->post('grand_total_price'),
					'reason'                =>$this->input->post('details'),
					'usablity'				=>	$this->input->post('radio')
				); 

			
					$this->db->insert('product_purchase_details',$data1);
				
				$this->db->insert('product_return',$returns);
		
		}
		 
		 return $purchase_id;
	}

	// return list count
	public function return_list_count()
	{
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('product_return a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('usablity',1);
		$this->db->group_by('a.invoice_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}

///start  return list
	public function return_list($perpage,$page)
	{
		$this->db->select('a.net_total_amount,a.*,b.firstname,b.lastname');
		$this->db->from('product_return a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('usablity',1);
		$this->db->group_by('a.invoice_id','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	// date between search return list  invoice 
	public function return_dateWise_invoice($from_date,$to_date,$perpage,$page)
	{
		$from_date = date("Y-m-d", strtotime($from_date));
		$to_date = date("Y-m-d", strtotime($to_date));
		$dateRange = "a.date_return BETWEEN '$from_date' AND '$to_date'";
		
		$this->db->select('a.net_total_amount,a.*,b.firstname,b.lastname');
		$this->db->from('product_return a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('usablity',1);
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->group_by('a.invoice_id','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		return $query->result_array();
	}
// supplier return list
	public function supplier_return_list($perpage,$page)
	{
		$this->db->select('a.net_total_amount,a.*,b.supplier_name');
		$this->db->from('product_return a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('usablity',2);
		$this->db->group_by('a.purchase_id','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
// date between search return list  supplier/purchase 
	public function return_dateWise_supplier($from_date,$to_date,$perpage,$page)
	{
		$dateRange = "a.date_return BETWEEN '$from_date' AND '$to_date'";
		
		$this->db->select('a.net_total_amount,a.*,b.supplier_name');
		$this->db->from('product_return a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('usablity',2);
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->group_by('a.purchase_id','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function retrieve_invoice_html_data($invoice_id)
	{
		$this->db->select('c.total_ret_amount,
						c.*,
						b.*,
						d.product_id,
						d.product_name,
						d.product_details,
						d.product_model');
		$this->db->from('product_return c');
		$this->db->join('patient b','b.patient_id = c.customer_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('c.invoice_id',$invoice_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	// supplier return html data 
	public function supplier_return_html_data($purchase_id)
	{
		$this->db->select('c.total_ret_amount,
						c.*,
						b.*,
						d.product_id,
						d.product_name,
						d.product_details,
						d.product_model');
		$this->db->from('product_return c');
		$this->db->join('supplier_information b','b.supplier_id = c.supplier_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('c.purchase_id',$purchase_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
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
	// wastage return list bellow 
	public function wastage_return_list_count()
	{
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('product_return a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('usablity',3);
		$this->db->group_by('a.invoice_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}
// supplier list count
	public function supplier_return_list_count()
	{
		$this->db->select('a.*,b.firstname,b.lastname');
		$this->db->from('product_return a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('usablity',2);
		$this->db->group_by('a.invoice_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}
///start  return list
	public function wastage_return_list($perpage,$page)
	{
		$this->db->select('a.net_total_amount,a.*,,b.firstname,b.lastname');
		$this->db->from('product_return a');
		$this->db->join('patient b','b.patient_id = a.customer_id');
		$this->db->where('usablity',3);
		$this->db->group_by('a.invoice_id','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	/////////// supplier returns form data
		public function supplier_return($purchase_id)
	{
		$this->db->select('c.*,a.*,b.*,a.product_id,d.product_name,d.product_model,e.*');
		$this->db->from('product_purchase c');
		$this->db->join('product_purchase_details a','a.purchase_id = c.purchase_id');
		$this->db->join('product_information d','d.product_id = a.product_id');
		$this->db->join('supplier_product e','d.product_id = e.product_id');
		$this->db->join('supplier_information b','e.supplier_id = b.supplier_id');
		$this->db->where('c.purchase_id',$purchase_id);
		$this->db->group_by('d.product_id','desc');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	


// return delete with invoice id  
	public function returninvoice_delete($invoice_id = null)
	{
		$this->db->where('invoice_id',$invoice_id)
			->delete('product_return');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
}
// return delete with purchase id
public function return_purchase_delete($purchase_id = null)
	{
		$this->db->where('purchase_id',$purchase_id)
			->delete('product_return');

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
}

public function supplier_rate($product_id)
	{
		$this->db->select('supplier_price');
		$this->db->from('supplier_product');
		$this->db->where(array('product_id' => $product_id)); 
		$query = $this->db->get();
		return $query->result_array();
	
	}
}