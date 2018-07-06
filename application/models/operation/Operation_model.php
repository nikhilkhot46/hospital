<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Operation_model extends CI_Model {

	private $table = 'ha_operation';

	public function create($data = [])
	{	 
		return $this->db->insert($this->table,$data);
	}

	public function add_theater($data = [])
	{	 
		return $this->db->insert('ot',$data);
	}

	public function add_equipment($data = [])
	{
		return $this->db->insert('ot_equipment',$data);
	}
 
	public function read()
	{
		return $this->db->select("ha_operation.*, CONCAT_WS(' ', user.firstname, user.lastname) AS doctor_name ")
			->from("ha_operation")
			->join('user', 'user.user_id = ha_operation.doctor_id', 'left')
			->order_by('id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($id = null)
	{
		return $this->db->select("ha_operation.*, CONCAT_WS(' ', user.firstname, user.lastname) AS doctor_name ")
			->from("ha_operation")
			->join('user', 'user.user_id = ha_operation.doctor_id', 'left')
			->where('ha_operation.id',$id)
			->order_by('id','desc')
			->get()
			->row();
	}
	
	public function read_by_ot_id($id = null)
	{
		return $this->db->select("*")
			->from("ot")
			->where('ot_id',$id)
			->get()
			->row();
	}

	public function read_by_equipment_id($id = null)
	{
		return $this->db->select("*")
			->from("ot_equipment")
			->where('equip_id',$id)
			->get()
			->row();
	}

	public function read_ot()
	{
		return $this->db->select("*")
			->from("ot")
			->get()
			->result();
	}

	public function read_equipment()
	{
		return $this->db->select("*")
			->from("ot_equipment")
			->get()
			->result();
	}
 
	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data); 
	}
	
	public function update_theater($data = [])
	{
		return $this->db->where('ot_id',$data['ot_id'])
			->update('ot',$data); 
	}

	public function update_equipment($data = [])
	{
		return $this->db->where('equip_id',$data['equip_id'])
			->update('ot_equipment',$data); 
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


	public function assign_equipment($data = [])
	{
		$result =  $this->db->insert('assign_equipment',$data);
		if($result){
			$equip = $this->read_by_equipment_id($data['equip_id']);
			$remqty = $equip->remaining - $data['equip_qty'];
			$this->db->where('equip_id', $data['equip_id']);
			//exit;
			return $this->db->update('ot_equipment', array("remaining"=>$remqty));
		}
		else{
			return false;
		}
	}

	public function read_assigned_equipment()
	{
		return $this->db->select("a.assign_id,b.equip_name,c.ot_name,a.equip_qty,a.start_date as date,a.status")
			->from("assign_equipment a")
			->join("ot_equipment b","b.equip_id = a.equip_id")
			->join("ot c","c.ot_id = a.ot_id")
			->order_by('assign_id desc')
			->get()
			->result();
	}

	public function read_assigned_equipment_id($id = null)
	{
		return $this->db->select("*")
			->from("assign_equipment")
			->where('assign_id',$id)
			->get()
			->row();
	}

	public function update_assign_equipment($data = [])
	{
		$this->db->trans_start();

		$equip = $this->read_by_equipment_id($data['equip_id']);
		$eq = $this->operation_model->read_assigned_equipment_id($data['assign_id']);

		if($data['status'] == 1 && $eq->status == 0){
			$diff = $eq->equip_qty;
		}
		else{
			$diff = $this->input->post('equip_qty',true) - $eq->equip_qty;
		}
			if($diff < 0) {
				$newrem = $equip->remaining + abs($diff);
				$newremain = $equip->remaining - $newrem;
			}
			else{
				$newrem = $equip->remaining - $diff;
				//$newremain = $newrem;
			}
		
		if($newrem < 0){
			$this->session->set_flashdata('exception',display('this_much_not_available'));
			redirect('operation/operation/update_assign_equipment/'.$data['assign_id']);
		}
		if($data['status'] == 0){
			$newrem = $eq->equip_qty;
		}
		//$newresult = $this->db->where('equip_id',$data['equip_id'])->update('ot_equipment',array("remaining"=>$newremain)); 
		$result = $this->db->where('assign_id',$data['assign_id'])->update('assign_equipment',$data); 

		$this->db->select('sum(equip_qty) as equip_qty');
		$this->db->where('equip_id', $data['equip_id']);
		$this->db->where('status', 1);
		$query = $this->db->get('assign_equipment')->result();
		$rem = $equip->qty - $query[0]->equip_qty;
		$newresult1 = $this->db->where('equip_id',$data['equip_id'])->update('ot_equipment',array("remaining"=>$rem)); 
		
		
		$this->db->trans_complete();
		return $result;
	}

	public function assign_ot($data = [])
	{	 
		return $this->db->insert('assign_ot',$data);
	}

	public function update_assign_ot($data = [])
	{
		return $this->db->where('assign_ot_id',$data['assign_ot_id'])
			->update('assign_ot',$data); 
	}

	public function read_by_assign_ot_id($id)
	{
		return $this->db->select("d.ot_name,assign_ot.*, CONCAT_WS(' ', user.firstname, user.lastname) AS doctor_name,CONCAT_WS(' ', c.firstname, c.lastname) AS patient_name ")
			->from("assign_ot")
			->where('assign_ot_id',$id)
			->join('user', 'user.user_id = assign_ot.doctor_id', 'left')
			->join('patient c', 'c.patient_id = assign_ot.patient_id', 'left')
			->join('ot d', 'd.ot_id = assign_ot.ot_id', 'left')
			->order_by('id','desc')
			->get()
			->row();
		// return $this->db->select("*")
		// 	->from("assign_ot")
			
		// 	->get()
		// 	->row();
	}

	public function read_assign_ot()
	{
		return $this->db->select("d.ot_name,assign_ot.*, CONCAT_WS(' ', user.firstname, user.lastname) AS doctor_name,CONCAT_WS(' ', c.firstname, c.lastname) AS patient_name ")
			->from("assign_ot")
			->join('user', 'user.user_id = assign_ot.doctor_id', 'left')
			->join('patient c', 'c.patient_id = assign_ot.patient_id', 'left')
			->join('ot d', 'd.ot_id = assign_ot.ot_id', 'left')
			->order_by('id','desc')
			->get()
			->result();
	}
}
