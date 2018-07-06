<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {

    public function create_item($data = [])
    {
        $result = $this->db->insert('item', $data);
        if($result){
            return $this->item_json();
        }else{
            return false;
        }
	}

    public function read_item()
    {
        return $this->db->select("*")
			->from('item')
			->get()
			->result();
	}

    public function read_by_item_id($id = null)
	{
		return $this->db->select("*")
			->from('item')
			->where('item_id',$id)
			->get()
			->row();
    }
    
    public function update_item($data = [])
	{
        $result = $this->db->where('item_id',$data['item_id'])->update('item',$data); 
        if($result){
            return $this->item_json();
        }else{
            return false;
        }            
    }

    public function item_json()
    {
        $this->db->select('*');
		$this->db->from('item');
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_product[] = array('label'=>$row->item_name,'value'=>$row->item_id);
		}
		$cache_file = './my-assets/js/admin_js/json/item.json';
		$productList = json_encode($json_product);
        file_put_contents($cache_file,$productList);
        return true;
    }

    public function item_details_info($product_id)
	{
		$this->db->select('*');
		$this->db->from('item');
		$this->db->where('item_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Product Purchase Report
	public function item_purchase_info($product_id)
	{
		$this->db->select('a.*,b.*,sum(b.quantity) as quantity,sum(b.total_amount) as total_amount,c.supplier_name');
		$this->db->from('item_purchase a');
		$this->db->join('item_purchase_details b','b.purchase_id = a.purchase_id');
		$this->db->join('supplier_information c','c.supplier_id = a.supplier_id');
		$this->db->where('b.item_id',$product_id);
		$this->db->order_by('a.purchase_id','asc');
		$this->db->group_by('a.purchase_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
    }
    
    public function invoice_data($product_id)
	{
		$this->db->select('a.*,b.*,c.firstname,c.lastname');
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');
		$this->db->join('patient c','c.patient_id = a.customer_id');
		$this->db->where('b.product_id',$product_id);
		$this->db->order_by('a.invoice_id','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();;
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

}

/* End of file Item_model.php */
