<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab_model extends CI_Model {

    public function create_test($data = [])
    {
        return $this->db->insert('lab_tests', $data);
	}

    public function read_test()
    {
        return $this->db->select("*")
			->from('lab_tests')
			->get()
			->result();
	}
	
	public function read_active_test()
    {
        return $this->db->select("*")
			->from('lab_tests')
			->where("status",1)
			->get()
			->result();
    }

    public function read_by_test_id($id = null)
	{
		return $this->db->select("*")
			->from('lab_tests')
			->where('test_id',$id)
			->get()
			->row();
    }
    
    public function update_test($data = [])
	{
		return $this->db->where('test_id',$data['test_id'])
			->update('lab_tests',$data); 
    }
    

    public function create_package($data = [])
    {
        return $this->db->insert('lab_packages', $data);
    }

    public function read_package()
    {
        return $this->db->select("*")
			->from('lab_packages')
			->get()
			->result();
    }

    public function read_by_package_id($id = null)
	{
		return $this->db->select("*")
			->from('lab_packages')
			->where('package_id',$id)
			->get()
			->row();
    }
    
    public function update_package($data = [])
	{
		return $this->db->where('package_id',$data['package_id'])
			->update('lab_packages',$data); 
	}

	public function create_appointment($data = [])
	{
		return $this->db->insert('lab_appointments', $data);
	}

	public function read_appointment()
	{
		return $this->db->select("*")
			->from('lab_appointments')
			->order_by("id desc")
			->get()
			->result();
	}

	public function read_by_appointment_id($id = null)
	{
		return $this->db->select("*")
			->from('lab_appointments')
			->where('appointment_id',$id)
			->get()
			->row();
	}
	
	public function update_appointment($data = [])
	{
		return $this->db->where('appointment_id',$data['appointment_id'])
			->update('lab_appointments',$data); 
	}

	public function read_todays_appointment()
	{
		return $this->db->select("*")
			->from('lab_appointments')
			->where('appointment_date',date("Y-m-d"))
			->get()
			->result();
	}

}

/* End of file Lab_model.php */
?>