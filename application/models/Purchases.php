<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchases extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Count purchase
	public function count_purchase()
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}
	//purchase List
	public function purchase_list($per_page,$page)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}
	public function item_purchase_list($per_page,$page)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('item_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}
//purchase info by invoice id
 	public function purchase_list_invoice_id($invoice_no)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('a.chalan_no',$invoice_no);
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function item_purchase_list_invoice_id($invoice_no)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('item_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('a.chalan_no',$invoice_no);
		$this->db->order_by('a.purchase_date','desc');
		$this->db->order_by('purchase_id','desc');
		$query = $this->db->get();
		
		$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Select All Supplier List
	public function select_all_supplier()
	{
		$query = $this->db->select('*')
					->from('supplier_information')
					->where('status','1')
					->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//purchase Search  List
	public function purchase_by_search($supplier_id)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->where('b.supplier_id',$supplier_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Count purchase
	public function purchase_entry()
	{
		$purchase_id = date('YmdHis');
		
		$p_id = $this->input->post('product_id');
		$supplier_id=$this->input->post('supplier_id');

		//supplier & product id relation ship checker.
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_id =$p_id[$i];
			$value=$this->product_supplier_check($product_id,$supplier_id);
			if($value==0){
			  	$this->session->set_userdata(array('message'=>"product_and_supplier_did_not_match"));
			  	redirect(base_url('dashboard_pharmacist/purchase/Cpurchase'));
			  	exit();
			}
		}
		
		$data=array(
			'purchase_id'			=>	$purchase_id,
			'chalan_no'				=>	$this->input->post('chalan_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'grand_total_amount'	=>	$this->input->post('grand_total_price'),
			'total_discount'		=>	$this->input->post('total_discount'),
			'purchase_date'			=>	$this->input->post('purchase_date'),
			'purchase_details'		=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);
		$this->db->insert('product_purchase',$data);
		
		$ledger=array(
			'transaction_id'		=>	$purchase_id,
			'chalan_no'				=>	$this->input->post('chalan_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'amount'				=>	$this->input->post('grand_total_price'),
			'date'					=>	$this->input->post('purchase_date'),
			'description'			=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);
		$this->db->insert('supplier_ledger',$ledger);
			
		$rate = $this->input->post('product_rate');
		$quantity = $this->input->post('product_quantity');
		$t_price = $this->input->post('total_price');
		$discount = $this->input->post('discount');
		$batch=$this->input->post('batch_id');
		$exp_date=$this->input->post('expeire_date');
		
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $t_price[$i];
			$disc = $discount[$i];
			$batch_id=$batch[$i];
			$expre_date=$exp_date[$i];
			
			$data1 = array(
				'purchase_detail_id'=>	$this->generator(15),
				'purchase_id'		=>	$purchase_id,
				'product_id'		=>	$product_id,
				'quantity'			=>	$product_quantity,
				'rate'				=>	$product_rate,
				'total_amount'		=>	$total_price,
				'discount'			=>	$disc,
				'batch_id'          =>  $batch_id,
				'expeire_date'      =>  $expre_date,
				'status'			=>	1
			);

			if(!empty($quantity))
			{
				$this->db->insert('product_purchase_details',$data1);
			}
		}
		return true;
	}


	public function item_purchase_entry()
	{
		$purchase_id = date('YmdHis');
		
		$p_id = $this->input->post('product_id');
		$supplier_id=$this->input->post('supplier_id');
		
		$data=array(
			'purchase_id'			=>	$purchase_id,
			'chalan_no'				=>	$this->input->post('chalan_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'grand_total_amount'	=>	$this->input->post('grand_total_price'),
			'total_discount'		=>	$this->input->post('total_discount'),
			'purchase_date'			=>	$this->input->post('purchase_date'),
			'purchase_details'		=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);
		$this->db->insert('item_purchase',$data);
		
		$ledger=array(
			'transaction_id'		=>	$purchase_id,
			'chalan_no'				=>	$this->input->post('chalan_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'amount'				=>	$this->input->post('grand_total_price'),
			'date'					=>	$this->input->post('purchase_date'),
			'description'			=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);
		$this->db->insert('supplier_ledger',$ledger);
			
		$rate = $this->input->post('product_rate');
		$quantity = $this->input->post('product_quantity');
		$t_price = $this->input->post('total_price');
		$discount = $this->input->post('discount');
		
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $t_price[$i];
			$disc = $discount[$i];
			
			$data1 = array(
				'purchase_detail_id'=>	$this->generator(15),
				'purchase_id'		=>	$purchase_id,
				'item_id'    		=>	$product_id,
				'quantity'			=>	$product_quantity,
				'rate'				=>	$product_rate,
				'total_amount'		=>	$total_price,
				'discount'			=>	$disc,
				'status'			=>	1
			);

			if(!empty($quantity))
			{
				$this->db->insert('item_purchase_details',$data1);
			}
		}
		return true;
	}

	//Retrieve purchase Edit Data
	public function retrieve_purchase_editdata($purchase_id)
	{
		$this->db->select('a.*,
						b.*,
						c.product_id,
						c.product_name,
						c.product_model,
						d.supplier_id,
						d.supplier_name'
						);
		$this->db->from('product_purchase a');
		$this->db->join('product_purchase_details b','b.purchase_id =a.purchase_id');
		$this->db->join('product_information c','c.product_id =b.product_id');
		$this->db->join('supplier_information d','d.supplier_id = a.supplier_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$this->db->order_by('a.purchase_details','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function retrieve_purchase_editdata_item($purchase_id)
	{
		$this->db->select('a.*,
						b.*,
						c.item_id,
						c.item_name,
						d.supplier_id,
						d.supplier_name'
						);
		$this->db->from('item_purchase a');
		$this->db->join('item_purchase_details b','b.purchase_id =a.purchase_id');
		$this->db->join('item c','c.item_id =b.item_id');
		$this->db->join('supplier_information d','d.supplier_id = a.supplier_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$this->db->order_by('a.purchase_details','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
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
	//Update Categories
public function update_purchase()
	{
		$purchase_id  = $this->input->post('purchase_id');
   
  
		$data=array(
			'purchase_id'      =>  $purchase_id,
			'chalan_no'			=>	$this->input->post('chalan_no'),
			'supplier_id'		=>	$this->input->post('supplier_id'),
			'grand_total_amount'=>	$this->input->post('grand_total_price'),
			'total_discount'	=>	$this->input->post('total_discount'),
			'purchase_date'		=>	$this->input->post('purchase_date'),
			'purchase_details'	=>	$this->input->post('purchase_details')
		);
 $ledger=array(
			'transaction_id'		=>	$purchase_id,
			'chalan_no'				=>	$this->input->post('chalan_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'amount'				=>	$this->input->post('grand_total_price'),
			'date'					=>	$this->input->post('purchase_date'),
			'description'			=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);

		if($purchase_id!='')
		{
			$this->db->where('purchase_id',$purchase_id);
			$this->db->update('product_purchase',$data); 
          //supplier ledger update
			$this->db->where('transaction_id',$purchase_id);
			$this->db->update('supplier_ledger',$ledger);
		      $this->db->where('purchase_id',$purchase_id);
				$this->db->delete('product_purchase_details');
			
		}
		
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');
	   
		$quantity = $this->input->post('product_quantity');
		$t_price = $this->input->post('total_price');
		
		$discount = $this->input->post('discount');
        $batch=$this->input->post('batch_id');
		$exp_date=$this->input->post('expeire_date');
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $t_price[$i];
			$batch_id=$batch[$i];
			$expre_date=$exp_date[$i];
			$disc = $discount[$i];
			
			$data1 = array(
				'purchase_detail_id'=> $this->generator(15),
				'purchase_id'       =>  $purchase_id,
				'product_id'		=>	$product_id,
				'quantity'			=>	$product_quantity,
				'rate'				=>	$product_rate,
				'batch_id'          =>  $batch_id,
				'expeire_date'      =>  $expre_date,
				'total_amount'		=>	$total_price,
				'discount'			=>	$disc,
			);

			
			if(($quantity))
			{
				
				$this->db->insert('product_purchase_details',$data1); 
			}
		}
		return true;
	}

	public function update_purchase_item()
	{
		$purchase_id  = $this->input->post('purchase_id');
   
  
		$data=array(
			'purchase_id'      =>  $purchase_id,
			'chalan_no'			=>	$this->input->post('chalan_no'),
			'supplier_id'		=>	$this->input->post('supplier_id'),
			'grand_total_amount'=>	$this->input->post('grand_total_price'),
			'total_discount'	=>	$this->input->post('total_discount'),
			'purchase_date'		=>	$this->input->post('purchase_date'),
			'purchase_details'	=>	$this->input->post('purchase_details')
		);
 $ledger=array(
			'transaction_id'		=>	$purchase_id,
			'chalan_no'				=>	$this->input->post('chalan_no'),
			'supplier_id'			=>	$this->input->post('supplier_id'),
			'amount'				=>	$this->input->post('grand_total_price'),
			'date'					=>	$this->input->post('purchase_date'),
			'description'			=>	$this->input->post('purchase_details'),
			'status'				=>	1
		);

		if($purchase_id!='')
		{
			$this->db->where('purchase_id',$purchase_id);
			$this->db->update('item_purchase',$data); 
          //supplier ledger update
			$this->db->where('transaction_id',$purchase_id);
			$this->db->update('supplier_ledger',$ledger);
		      $this->db->where('purchase_id',$purchase_id);
				$this->db->delete('item_purchase_details');
			
		}
		
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');
	   
		$quantity = $this->input->post('product_quantity');
		$t_price = $this->input->post('total_price');
		
		$discount = $this->input->post('discount');
        for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $t_price[$i];
			$disc = $discount[$i];
			
			$data1 = array(
				'purchase_detail_id'=> $this->generator(15),
				'purchase_id'       =>  $purchase_id,
				'item_id'		=>	$product_id,
				'quantity'			=>	$product_quantity,
				'rate'				=>	$product_rate,
				'total_amount'		=>	$total_price,
				'discount'			=>	$disc,
			);

			
			if(($quantity))
			{
				
				$this->db->insert('item_purchase_details',$data1); 
			}
		}
		return true;
	}
	// Delete purchase Item
	
	public function purchase_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('purchases a');
		$this->db->join('purchase_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('purchase_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve purchase_details_data
	public function purchase_details_data($purchase_id)
	{
	$this->db->select('a.*,b.*,c.*,e.purchase_details,d.product_id,d.product_name,d.product_model');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->join('product_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->join('product_purchase e','e.purchase_id = c.purchase_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$this->db->group_by('d.product_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	public function item_purchase_details_data($purchase_id)
	{
		$this->db->select('a.*,b.*,c.*,e.purchase_details,d.item_id,d.item_name');
		$this->db->from('item_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->join('item_purchase_details c','c.purchase_id = a.purchase_id');
		$this->db->join('item d','d.item_id = c.item_id');
		$this->db->join('item_purchase e','e.purchase_id = c.purchase_id');
		$this->db->where('a.purchase_id',$purchase_id);
		$this->db->group_by('d.item_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//This function will check the product & supplier relationship.
	public function product_supplier_check($product_id,$supplier_id)
	{
	 $this->db->select('*');
	  $this->db->from('supplier_product');
	  $this->db->where('product_id',$product_id);
	  $this->db->where('supplier_id',$supplier_id);	
	  $query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;	
		}
		return 0;
	}
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("A","B","C","D","E","F","G","H","I","J","K","L","N","M","O","P","Q","R","S","U","V","T","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,61);
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

	public function purchase_delete($purchase_id = null)
	{
			//Delete product_purchase table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase'); 
		//Delete product_purchase_details table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('product_purchase_details');
		return true;
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
}

public function purchase_delete_item($purchase_id = null)
	{
			//Delete product_purchase table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('item_purchase'); 
		//Delete product_purchase_details table
		$this->db->where('purchase_id',$purchase_id);
		$this->db->delete('item_purchase_details');
		return true;
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
}
//purchase list date to date
	public function purchase_list_date_to_date($start,$end)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
     	$this->db->where('a.purchase_date >=', $start);
        $this->db->where('a.purchase_date <=', $end);
		$query = $this->db->get();
		
		//$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}

	public function item_purchase_list_date_to_date($start,$end)
	{
		$this->db->select('a.*,b.supplier_name');
		$this->db->from('item_purchase a');
		$this->db->join('supplier_information b','b.supplier_id = a.supplier_id');
		$this->db->order_by('a.purchase_date','desc');
     	$this->db->where('a.purchase_date >=', $start);
        $this->db->where('a.purchase_date <=', $end);
		$query = $this->db->get();
		
		//$last_query =  $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}
}