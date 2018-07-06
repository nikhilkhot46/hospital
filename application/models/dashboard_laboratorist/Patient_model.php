<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

	private $table = "patient";
 
	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->order_by('id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->get()
			->row();
	} 
 
	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data); 
	} 
 
	public function delete($id = null)
	{
		$this->db->where('id',$id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function previous_balance_add($balance,$customer_id)
	  {
	  	$this->load->library('auth');
	  	$transaction_id=$this->auth->generator(10);
		$data=array(
					'transaction_id' => $transaction_id,
					'customer_id' 	=> $customer_id,
					'invoice_no' => "NA",
					'receipt_no' 		=> NULL,
					'amount' 		=> $balance,
					'description' 		=> "Previous adjustment with software",
					'payment_type' 		=> "NA",
					'cheque_no' 		=> "NA",
					'date' 		=> date("Y-m-d"),
					'status' 				=> 1
					);
					
		$this->db->insert('customer_ledger',$data);
	  }
	
	public function read_by_patient_id($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('patient_id',$id)
			->get()
			->row();
	}

	public function check_patient_aid($id = null)
	{
		return $this->db->select("admission_id")
			->from('bill_admission')
			->where('patient_id',$id)
			->where('status',1)
			->get()
			->row();
	}
  
}
