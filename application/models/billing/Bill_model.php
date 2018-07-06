<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_model extends CI_Model {

	private $table = "bill";
 
	public function create($data = [])
	{	 
		if($data['status'] == 1){
			if($data['admission_id']){
				$this->load->model('patient_model');
				$pid = $this->patient_model->read_by_patient_aid($data['admission_id']);
				$ptid = $pid->patient_id;
				$this->db->where('patient_id', $ptid);
				$this->db->update('bm_bed_assign', array("status"=>0,"bill_generated"=>1));

				$this->db->where('admission_id', $data['admission_id']);
				$this->db->update('lab_appointments', array("payment_status"=>1,"bill_generated"=>1));

				$this->db->where('admission_id', $data['admission_id']);
				$this->db->update('lab_appointments', array("status"=>0,"bill_generated"=>1));

				$this->load->model('invoices');
				$invoice_details = $this->invoices->invoice_by_aid($data['admission_id']);
				foreach ($invoice_details as $value) {
					$this->db->where('invoice_id', $value->invoice_id);
					$this->db->update('invoice_details', array("paid_amount"=>$value->paid_amount+$value->due_amount,"due_amount"=>0,"status"=>0,"old_due"=>$value->due_amount,"bill_generated"=>1));
				}

				$this->db->where('admission_id', $data['admission_id']);
				$this->db->update('blood_sell', array("status"=>1,"bill_generated"=>1));
			}else{
				$this->db->where('patient_id', $data['patient_id']);
				$this->db->update('pr_prescription', array("status"=>0));
			}
		}
		return $this->db->insert($this->table, $data);
	}
 
	public function read($limit, $offset)
	{ 
		return $this->db->select("bi.*, ba.patient_id, CONCAT_WS(' ', pa.firstname, pa.lastname) AS patient_name")
		->from("bill as bi")
		->join("bill_admission AS ba", "ba.admission_id = bi.admission_id", "left")
		->join("patient AS pa", "pa.patient_id = ba.patient_id", "left")
		->where('bill_type','ipd')
		->limit($limit, $offset)
		->order_by('id','desc')
		->get()
		->result();
	}  
 
	public function bill_by_id($bill_id = null)
	{ 
		return $this->db->select("
				bi.id AS id,
				bi.bill_id AS bill_id,
				bi.admission_id AS admission_id,
				bi.bill_date AS bill_date,
				bi.payment_method AS payment_method,
				bi.card_cheque_no AS card_cheque_no,
				bi.receipt_no AS receipt_no,
				bi.discount AS discount,
				bi.tax AS tax,
				bi.note AS note,
				bi.status AS status,

				ba.patient_id AS patient_id,
				ba.admission_date AS admission_date,
				ba.discharge_date AS discharge_date, 
				DATEDIFF(ba.discharge_date, ba.admission_date) as total_days,
				ba.patient_id AS doctor_id,
				ba.insurance_id AS insurance_id,
				ba.policy_no AS policy_no,

				CONCAT_WS(' ', pa.firstname, pa.lastname) AS patient_name,
				pa.address AS address,
				pa.date_of_birth AS date_of_birth,
				pa.sex AS sex,
				pa.picture AS picture,

				CONCAT_WS(' ', dr.firstname, dr.lastname) AS doctor_name,

				in.insurance_name AS insurance_name,

				bp.id as package_id,
				bp.name as package_name, 
				bp.services as services
			")
			->from("bill AS bi")
			->join("bill_admission AS ba", "ba.admission_id = bi.admission_id", "left")
			->join("patient AS pa", "pa.patient_id = ba.patient_id", "left")
			->join("user AS dr", "dr.user_id = ba.doctor_id", "left")
			->join("inc_insurance AS in", "in.id = ba.insurance_id", "left")
			->join("bill_package AS bp", "bp.id = ba.package_id", "left")
			->where("bi.bill_id", $bill_id)
			->get()
			->row();
	}  
 

	public function services_by_id($bill_id = null)
	{
		return $this->db->select("
				bill_details.*, 
				bill_service.id AS id, 
				bill_service.name AS name
			")->from("bill_details")
			->join("bill_service", "bill_service.id = bill_details.service_id","left")
			->where("bill_details.bill_id", $bill_id)
			->get()
			->result();
	}


	public function update($data = [])
	{
		return $this->db->where('bill_id',$data['bill_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($bill_id = null)
	{ 
		$this->db->select('admission_id');
		$this->db->from('bill');
		$qry = $this->db->where('bill_id', $bill_id)->get()->row();
		$aid = $qry->admission_id;
		$this->db->where('bill_id',$bill_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			
			$this->load->model('patient_model');
			$pid = $this->patient_model->read_by_patient_aid($aid);
			$ptid = $pid->patient_id;
			$this->db->where('patient_id', $ptid);
			$this->db->update('bm_bed_assign', array("status"=>1,"bill_generated"=>0));

			$this->db->where('admission_id', $aid);
			$this->db->update('lab_appointments', array("payment_status"=>0,"bill_generated"=>0));
			
			$this->db->select('id.*,i.total_discount,i.total_tax,pi.product_name');
			$this->db->from('invoice i');
			$this->db->where('i.admission_id', "URPGMMRL");
			$this->db->join('invoice_details id', 'id.invoice_id = i.invoice_id', 'left');
			$this->db->join('product_information pi', 'pi.product_id = id.product_id', 'left');
			
			$invoice_details = $this->db->get()->result();
			foreach ($invoice_details as $value) {
				$this->db->where('invoice_id', $value->invoice_id);
				$this->db->update('invoice_details', array("paid_amount"=>$value->paid_amount-$value->old_due,"status"=>1,"due_amount"=>$value->old_due,"old_due"=>0,"bill_generated"=>0));
			}

			$this->db->where('admission_id', $aid);
			$this->db->update('blood_sell', array("status"=>0,"bill_generated"=>0));
			return true;
		} else {
			return false;
		}
	} 
 

	public function advance_payment($bill_id = null)
	{
		return $this->db->select("DATE(ba.date) AS date, ba.receipt_no, ba.amount")
			->from("bill AS b")
			->join("bill_advanced AS ba","ba.admission_id = b.admission_id")
			->where("b.bill_id", $bill_id)
			->get()
			->result();
	}


	public function website()
	{
		return $this->db->select('title, description, email, phone,logo')
			->from('setting')
			->get()
			->row();
	}

	public function read_opd_list($limit, $offset)
	{ 
		return $this->db->select("pr.*,CONCAT_WS(' ', u.firstname, u.lastname) AS doctor_name, pa.patient_id, CONCAT_WS(' ', pa.firstname, pa.lastname) AS patient_name")
		->from("pr_prescription as pr")
		->join("patient AS pa", "pa.patient_id = pr.patient_id", "left")
		->join("user AS u", "u.user_id = pr.doctor_id", "left")
		->limit($limit, $offset)
		->order_by('pr.status desc')
		->order_by('pr.id desc')
		->get()
		->result();
	}
}
