<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blood_model extends CI_Model {

    public function create($data = [])
    {
        $result = $this->db->insert('blood_bank', $data);
        
        $this->db->where('blood_type', $data['blood_type']);
        $stock = $this->db->get('blood_stock')->row();
        if($stock){
            $this->db->where("blood_type",$data['blood_type']);
            $result = $this->db->update('blood_stock', array("qty"=>$stock->qty + $data['blood_qty'],"remaining"=>$stock->remaining + $data['blood_qty']));
        }
        else{
            $result = $this->db->insert('blood_stock', array("blood_type"=>$data['blood_type'],"qty"=>$data['blood_qty'],"remaining"=>$data['blood_qty']));
        }  
        return $result;      
    }

    public function read()
    {
        return $this->db->select("*")
			->from('blood_stock')
			->get()
			->result();
    }

    public function create_donor($data = [])
    {
        return $this->db->insert('blood_donars', $data);
    }

    public function read_donors()
    {
        return $this->db->select("*")
			->from('blood_donars')
			//->order_by('type','asc')
			->get()
			->result();
    }

    public function read_by_donor_id($id = null)
    {
        return $this->db->select("*")
			->from('blood_donars')
			->where('donor_id',$id)
			->get()
			->row();
    }

    public function update_donor($data = [])
	{
		return $this->db->where('donor_id',$data['donor_id'])
			->update('blood_donars',$data); 
    } 
    
    public function sell_blood($data = [])
    {
        $this->db->select('remaining');
        $this->db->where('blood_type', $data['blood_type']);
        $stock = $this->db->get('blood_stock')->row();
        if($stock->remaining >= $data['qty']){
            $this->db->where('blood_type', $data['blood_type']);
            $this->db->update('blood_stock', array("remaining"=>$stock->remaining-$data['qty']));
            $result = $this->db->insert('blood_sell', $data);
        }
        else{
            $this->session->set_flashdata('exception', display('this_much_not_available'));
            redirect('blood_bank/blood/sell_blood');
        }
        return $result;
    }

    public function read_sell_blood()
    {
        return $this->db->select("*")
			->from('blood_sell')
			//->where('donor_id',$id)
			->get()
			->result();
    }

    public function read_by_sell_id($id=null)
    {
        return $this->db->select("*")
			->from('blood_sell')
		    ->where('sell_id',$id)
			->get()
			->row();
    }

    public function update_sell_blood($data = [])
    {
        $this->db->select('qty');
        $this->db->where('sell_id', $data['sell_id']);
        $oldsell = $this->db->get('blood_sell')->row();
        $this->db->select('remaining');
        $this->db->where('blood_type', $data['blood_type']);
        $stock = $this->db->get('blood_stock')->row();
        $old = $oldsell->qty;
        $total = $old + $stock->remaining;

        $diff = $total - $data['qty'];
        
        if($diff < 0)
        {
            $this->session->set_flashdata('exception', display('this_much_not_available'));
            redirect('blood_bank/blood/sell_blood/'.$data['sell_id']);
        }
        $this->db->where('blood_type', $data['blood_type']);
        $result = $this->db->update('blood_stock', array("remaining"=>$diff));
        $this->db->where('sell_id', $data['sell_id']);
        $this->db->update('blood_sell', $data);
        return $result;
    }

    public function read_waste_blood()
    {
        return $this->db->select("sum(qty) as qty, blood_type")
            ->from('blood_wastage')
            ->group_by("blood_type")
			->get()
			->result();
    }

    public function read_signle_waste_blood($type)
    {
        return $this->db->select("*")
            ->from('blood_wastage')
            ->where("blood_type",$type)
            ->order_by("added_date desc")
			->get()
			->result();
    }

    public function wastage_blood($data = [])
    {
        $this->db->select('remaining');
        $this->db->where('blood_type', $data['blood_type']);
        $stock = $this->db->get('blood_stock')->row();
        if($stock->remaining >= $data['qty']){
            $this->db->where('blood_type', $data['blood_type']);
            $this->db->update('blood_stock', array("remaining"=>$stock->remaining - $data['qty']));
            $this->db->insert('blood_wastage', $data);
            return true;
        }else{
            $this->session->set_flashdata('exception', display('this_much_not_available'));
            redirect('blood_bank/blood/add_wastage');
        }
        
    }

    public function read_by_wastage_id($id = null)
    {
        return $this->db->select("*")
            ->from('blood_wastage')
            ->where("wastage_id",$id)
			->get()
			->row();
    }

    public function update_wastage_blood($data = [])
    {
        $this->db->select('qty');
        $this->db->where('wastage_id', $data['wastage_id']);
        $oldsell = $this->db->get('blood_wastage')->row();
        $this->db->select('remaining');
        $this->db->where('blood_type', $data['blood_type']);
        $stock = $this->db->get('blood_stock')->row();
        $old = $oldsell->qty;
        $total = $old + $stock->remaining;

        $diff = $total - $data['qty'];
        
        if($diff < 0)
        {
            $this->session->set_flashdata('exception', display('this_much_not_available'));
            redirect('blood_bank/blood/add_wastage/'.$data['wastage_id']);
        }
        $this->db->where('blood_type', $data['blood_type']);
        $result = $this->db->update('blood_stock', array("remaining"=>$diff));
        $this->db->where('wastage_id', $data['wastage_id']);
        $this->db->update('blood_wastage', $data);
        return $result;
    }

    public function get_blood_sell($aid,$view='')
    {
        $this->db->select('*');
        $this->db->from('blood_sell');
        $this->db->where('admission_id', $aid);
        if(!$view){
            $this->db->where('status', 0);
        }
        return $this->db->get()->result();
        
    }
}

/* End of file Blood_model.php */
