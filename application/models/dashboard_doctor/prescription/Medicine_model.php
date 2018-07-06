<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Medicine_model extends CI_Model {

	private $table = 'product_information';

	public function medicine_list()
	{
		$result = $this->db->select("*")
			->from($this->table)
			->where('status',1)
			->get()
			->result();
 
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[] = $value->product_name." - ($value->product_id)"; 
			}
			return $list;
		} else {
			return false;
		}
	}
	
 }
