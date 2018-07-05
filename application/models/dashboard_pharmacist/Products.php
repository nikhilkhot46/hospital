<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//Count Product
	public function count_product()
	{
		return $this->db->count_all("product_information");
	}
	//Product List
	public function product_list($per_page='',$page='')
	{
		$query=$this->db->select('supplier_information.*,product_information.*,product_category.*,supplier_product.*')
				->from('product_information')
				->join('supplier_product', 'product_information.product_id = supplier_product.product_id','left')
				->join('supplier_information', 'supplier_product.supplier_id = supplier_information.supplier_id','left')
				->join('product_category','product_category.category_id=product_information.category_id')
				->order_by('supplier_product.supplier_id','desc')
				->order_by('product_information.product_id','desc')
				//->limit($per_page,$page)
				->get();
		if ($query->num_rows() > 0) {
		 	return $query->result_array();	
		}
		return false;

	}
	//All Product List
	public function all_product_list()
	{
		$query=$this->db->select('supplier_information.*,product_information.*,supplier_product.*,product_category.*')
				->from('product_information')
				->join('supplier_product', 'product_information.product_id = supplier_product.product_id','left')
				->join('supplier_information', 'supplier_information.supplier_id = supplier_product.supplier_id','left')
				->join('product_category', 'product_category.category_id = product_information.category_id')
				->group_by('product_information.product_id')
				->order_by('product_information.product_id','desc')
				->get();
		if ($query->num_rows() > 0) {
		 	return $query->result_array();	
		}
		return false;
	}	
	//Product List
	public function product_list_count()
	{
		$query=$this->db->select('supplier_information.*,product_information.*,supplier_product.*')
				->from('product_information')
				->join('supplier_product', 'product_information.product_id = supplier_product.product_id','left')
				->join('supplier_information', 'supplier_information.supplier_id = supplier_product.supplier_id','left')
				->order_by('product_information.product_id','desc')
				->get();
		if ($query->num_rows() > 0) {
		 	return $query->num_rows();	
		}
		return false;

	}
	//Product tax list
	public function retrieve_product_tax(){
		$result = $this->db->select('*')
                    ->from('tax_information')
                    ->get()
                    ->result();

        return $result;
	}
	//Tax selected item
	public function tax_selected_item($tax_id){
		$result = $this->db->select('*')
                    ->from('tax_information')
                    ->where('tax_id',$tax_id)
                    ->get()
                    ->result();

        return $result;
	}

	//Product generator id check 
	public function product_id_check($product_id){
		$query=$this->db->select('*')
				->from('product_information')
				->where('product_id',$product_id)
				->get();
		if ($query->num_rows() > 0) {
		 	return true;	
		}else{
			return false;
		}
	}
	//Count Product
	public function product_entry($data)
	{
		
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('status',1);
		$this->db->where('product_model',$data['product_model']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
			$this->db->insert('product_information',$data);
			$this->db->select('*');
			$this->db->from('product_information');
			$this->db->where('status',1);
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_product[] = array('label'=>$row->product_name."-(".$row->product_model.")",'value'=>$row->product_id);
			}
			$cache_file = './my-assets/js/admin_js/json/product.json';
			$productList = json_encode($json_product);
			file_put_contents($cache_file,$productList);
			return TRUE;
		}
	}
	//Retrieve Product Edit Data
	public function retrieve_product_editdata($product_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	// Supplier product information
	public function supplier_product_editdata($product_id)
	{
		$this->db->select('a.*,b.*');
		$this->db->from('supplier_product a');
		$this->db->join('supplier_information b','a.supplier_id=b.supplier_id');
		$this->db->where('a.product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
//selected supplier product
	public function supplier_selected($product_id)
	{
		$this->db->select('*');
		$this->db->from('supplier_product');
		$this->db->where('product_id',$product_id);
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
		$this->db->from('company_information');
		$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Update Categories
	public function update_product($data,$product_id)
	{
    
    	$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('status',1);
		$this->db->where('product_id !=',$product_id);
		$this->db->where('product_model',$data['product_model']);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return FALSE;
		}else{
		$this->db->where('product_id',$product_id);
		$this->db->update('product_information',$data); 

	

		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('status',1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->product_name."-(".$row->product_model.")",'value'=>$row->product_id);
		}
		$cache_file = './my-assets/js/admin_js/json/product.json';
		$productList = json_encode($json_product);
		file_put_contents($cache_file,$productList);
		return true;
	}
	}
	// Delete Product Item
	public function delete_product($product_id)
	{

		#### Check product is using on system or not##########
		# If this product is used any calculation you can't delete this product.
		# but if not used you can delete it from the system.
		$this->db->select('product_id');
		$this->db->from('product_purchase_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		$affected_row=$this->db->affected_rows();

		if($affected_row == 0) {
			$this->db->where('product_id',$product_id);
			$this->db->delete('product_information'); 
			$this->db->where('product_id',$product_id);
			$this->db->delete('supplier_product'); 
			$this->session->set_userdata(array('message'=>display('successfully_delete')));

			$this->db->select('*');
			$this->db->from('product_information');
			$this->db->where('status',1);
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_product[] = array('label'=>$row->product_name."-(".$row->product_model.")",'value'=>$row->product_id);
			}
			$cache_file = './my-assets/js/admin_js/json/product.json';
			$productList = json_encode($json_product);
			file_put_contents($cache_file,$productList);
			return true;
		}else{
			$this->session->set_userdata(array('error_message'=>display('you_cant_delete_this_product')));
			return false;
		}	
	}
	//Product By Search 
	public function product_search_item($product_id)
	{

		$query=$this->db->select('supplier_information.*,product_information.*,supplier_product.*,product_category.*')
				->from('product_information')
				->join('supplier_product', 'product_information.product_id = supplier_product.product_id','left')
				->join('supplier_information', 'supplier_product.supplier_id = supplier_information.supplier_id','left')
				->join('product_category', 'product_category.category_id = product_information.category_id')
				->order_by('product_information.product_id','desc')
				->where('product_information.product_id',$product_id)
				->get();

		if ($query->num_rows() > 0) {
		 	return $query->result_array();	
		}
		return false;


	}	
	
	//Duplicate Entry Checking 
	public function product_model_search($product_model)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_model',$product_model);
		$query = $this->db->get();
		return $this->db->affected_rows();
	}	
	//Product Details
	public function product_details_info($product_id)
	{
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Product Purchase Report
	public function product_purchase_info($product_id)
	{
		$this->db->select('a.*,b.*,sum(b.quantity) as quantity,sum(b.total_amount) as total_amount,c.supplier_name');
		$this->db->from('product_purchase a');
		$this->db->join('product_purchase_details b','b.purchase_id = a.purchase_id');
		$this->db->join('supplier_information c','c.supplier_id = a.supplier_id');
		$this->db->where('b.product_id',$product_id);
		$this->db->order_by('a.purchase_id','asc');
		$this->db->group_by('a.purchase_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Invoice Data for specific data
	public function invoice_data($product_id)
	{
		$this->db->select('a.*,b.*,c.customer_name');
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');
		$this->db->join('customer_information c','c.customer_id = a.customer_id');
		$this->db->where('b.product_id',$product_id);
		$this->db->order_by('a.invoice_id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function previous_stock_data($product_id,$startdate)
	{
		
		$this->db->select('date,sum(quantity) as quantity');
		$this->db->from('product_report');
		$this->db->where('product_id',$product_id);
		$this->db->where('date <=',$startdate);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	
	}
// Invoice Data for specific data
	public function invoice_data_supplier_rate($product_id,$startdate,$enddate)
	{
		
		$this->db->select('
					date,
					sum(quantity) as quantity,
					rate,
					-rate*sum(quantity) as total_price,
					account
				');

		$this->db->from('product_report');
		$this->db->where('product_id',$product_id);

		$this->db->where('date >=',$startdate);
		$this->db->where('date <=',$enddate);

		$this->db->group_by('account');
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
	
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// csv export info
	public function product_csv_file()
	{
		$query=$this->db->select('a.product_id,b.supplier_id,a.category_id,a.product_name,a.generic_name,a.box_size,a.product_location,a.price,b.supplier_price,a.unit,a.tax,a.product_model,a.product_details,a.image,a.status')
				->from('product_information a')
				->join('supplier_product b', 'a.product_id = b.product_id','left')
				->get();
		if ($query->num_rows() > 0) {
		 	return $query->result_array();	
		}
		return false;
		
	}	

	// product batch id  total_batch_stock
	public function batch_search_item($product_id){
		$this->db->select('*');
		$this->db->from('total_batch_stock');
		$this->db->where('product_id',$product_id);
		$this->db->where('stock >',0);
		$this->db->group_by('batch_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
}