<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * @author    : bdtask 
 * @created at: 25.11.2017
 */

class Bill extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'billing/bill_model',
			'billing/service_model',
		));

		if ($this->session->userdata('isLogIn') == false
			|| $this->session->userdata('user_role') != 1)
			redirect('login');
	}

	public function index()
	{
		$data['title'] = display('bill_list');
        #-------------------------------#
        #
        #pagination starts
        #
		$config["base_url"] = base_url('billing/bill/index');
		$config["total_rows"] = $this->db->count_all('bill');
		$config["per_page"] = 25;
		$config["uri_segment"] = 4;
		$config["last_link"] = "Last";
		$config["first_link"] = "First";
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
		$config['full_tag_close'] = "</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['bills'] = $this->bill_model->read($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
        #
        #pagination ends
        #    
		$data['content'] = $this->load->view('billing/bill/list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}



	public function form()
	{
		$data['title'] = display('add_bill');
		#-------------------------------#
		$this->form_validation->set_rules(
			'admission_id',
			display('admission_id'),
			array(
				'required',
				array(
					'admission_callable',
					function ($value) {
						$rows = $this->db->select("admission_id")
							->from("bill_admission")
							->where("admission_id", $value)
							->get()
							->num_rows();

						if ($rows > 0) {
							return true;
						} else {
							$this->form_validation->set_message('admission_callable', 'The {field} is not valid!');

							return false;
						}
					}
				)
			)
		);

		$this->form_validation->set_rules('bill_date', display('bill_date'), 'required|max_length[10]');
		$this->form_validation->set_rules('total', display('total'), 'required|max_length[11]');
		$this->form_validation->set_rules('payment_method', display('payment_method'), 'required|max_length[255]');
		$this->form_validation->set_rules('note', display('note'), 'max_length[1024]');

		#-------------------------------#
		$bill_id = 'BL' . $this->randStrGen(2, 7);
		$admission_id = $this->input->post('admission_id');
		$package_id = $this->input->post('package_id');
		#-------------------------------#
		$data['bill'] = (object)$postData = array(
			'bill_id' => $bill_id,
			'bill_type' => 'ipd',
			'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
			'admission_id' => $admission_id,
			'discount' => $this->input->post('discount'),
			'tax' => $this->input->post('tax'),
			'total' => $this->input->post('total'),
			'payment_method' => $this->input->post('payment_method'),
			'card_cheque_no' => $this->input->post('card_cheque_no'),
			'receipt_no' => $this->input->post('receipt_no'),
			'note' => $this->input->post('note'),
			'date' => date('Y-m-d H:i:s'),
			'status' => $this->input->post('status'),
		);  

		#-------------------------------#
		if ($this->form_validation->run()) {
			$alreadybill = $this->db->select('*')->from('bill')->where('admission_id', $admission_id)->get();
			if ($alreadybill->num_rows() > 0) {
				$this->session->set_flashdata('exception', display('bill_already_generated'));
				redirect('billing/bill/form/');

			}
			if ($this->bill_model->create($postData)) {


				#------------bill details--------------#
				$sID = $this->input->post('service_id');
				$sName = $this->input->post('service_name');
				$sQty = $this->input->post('quantity');
				$sAmt = $this->input->post('amount');
				$services = array();
				for ($i = 0; $i < sizeof($sID); $i++) {
					if (!empty($sID[$i]))
						$this->db->insert('bill_details', array(
						'bill_id' => $bill_id,
						'admission_id' => $admission_id,
						'package_id' => $package_id,
						'service_id' => $sID[$i],
						'quantity' => $sQty[$i],
						'amount' => $sAmt[$i],
						'date' => date('Y-m-d')
					));
				} 
				#-------------------------------#

				$this->session->set_flashdata('message', display('save_successfully'));

				if ($postData['status'] == 1) {
					redirect("billing/bill/view/" . $postData['bill_id']);
				}

			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect('billing/bill/form/');
		} else {
			$data['service_list'] = $this->service_model->readList();
			$data['content'] = $this->load->view('billing/bill/form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}



	public function view($bill_id = null)
	{
		$data['title'] = display('bill_details');
		$data['bill'] = $this->bill_model->bill_by_id($bill_id);
		$data['services'] = $this->bill_model->services_by_id($bill_id);
		$data['advance'] = $this->bill_model->advance_payment($bill_id);
		$data['website'] = $this->bill_model->website();
		$data['content'] = $this->load->view('billing/bill/view', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}




	public function edit($bill_id = null)
	{
		#-------------------------------#
		$this->form_validation->set_rules(
			'admission_id',
			display('admission_id'),
			array(
				'required',
				array(
					'admission_callable',
					function ($value) {
						$rows = $this->db->select("admission_id")
							->from("bill_admission")
							->where("admission_id", $value)
							->get()
							->num_rows();

						if ($rows > 0) {
							return true;
						} else {
							$this->form_validation->set_message('admission_callable', 'The {field} is not valid!');

							return false;
						}
					}
				)
			)
		);

		$this->form_validation->set_rules('bill_date', display('bill_date'), 'required|max_length[10]');
		$this->form_validation->set_rules('total', display('total'), 'required|max_length[11]');
		$this->form_validation->set_rules('payment_method', display('payment_method'), 'required|max_length[255]');
		$this->form_validation->set_rules('note', display('note'), 'max_length[1024]');

		#-------------------------------#
		$admission_id = $this->input->post('bill_id');
		$admission_id = $this->input->post('admission_id');
		$package_id = $this->input->post('package_id');
		#-------------------------------#
		$data['bill'] = (object)$postData = array(
			'bill_id' => $bill_id,
			'bill_type' => 'ipd',
			'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
			'admission_id' => $admission_id,
			'discount' => $this->input->post('discount'),
			'tax' => $this->input->post('tax'),
			'total' => $this->input->post('total'),
			'payment_method' => $this->input->post('payment_method'),
			'card_cheque_no' => $this->input->post('card_cheque_no'),
			'receipt_no' => $this->input->post('receipt_no'),
			'note' => $this->input->post('note'),
			'date' => date('Y-m-d H:i:s'),
			'status' => $this->input->post('status'),
		);  

		#-------------------------------#
		if ($this->form_validation->run()) {


			if ($this->bill_model->delete($bill_id)) {
				if ($this->bill_model->create($postData)) {
					#------------bill details--------------#
					$sID = $this->input->post('service_id');
					$sName = $this->input->post('service_name');
					$sQty = $this->input->post('quantity');
					$sAmt = $this->input->post('amount');
					$services = array();
					for ($i = 0; $i < sizeof($sID); $i++) {
						if (!empty($sID[$i]))
							$this->db->insert('bill_details', array(
							'bill_id' => $bill_id,
							'admission_id' => $admission_id,
							'package_id' => $package_id,
							'service_id' => $sID[$i],
							'quantity' => $sQty[$i],
							'amount' => $sAmt[$i],
							'date' => date('Y-m-d')
						));
					} 
					#-------------------------------#

					$this->session->set_flashdata('message', display('save_successfully'));

					if ($postData['status'] == 1) {
						redirect("billing/bill/view/" . $postData['bill_id']);
					}
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));

			}

			redirect('billing/bill/edit/' . $postData['bill_id']);
		} else {
			$data['title'] = display('update_bill');
			$data['bill'] = $this->bill_model->bill_by_id($bill_id);
			$data['services'] = $this->bill_model->services_by_id($bill_id);
			$data['advance'] = $this->bill_model->advance_payment($bill_id);
			$data['service_list'] = $this->service_model->readList();
			$data['content'] = $this->load->view('billing/bill/edit', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}



	public function delete($id = null)
	{
		if ($this->bill_model->delete($id)) {
            #set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
            #set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('billing/bill/index');
	}




    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
	 */
	public function randStrGen($mode = null, $len = null)
	{
		$result = "";
		if ($mode == 1) :
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 2) :
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		elseif ($mode == 3) :
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		elseif ($mode == 4) :
			$chars = "0123456789";
		endif;

		$charArray = str_split($chars);
		for ($i = 0; $i < $len; $i++) {
			$randItem = array_rand($charArray);
			$result .= "" . $charArray[$randItem];
		}
		return $result;
	}
    /*
    |----------------------------------------------
    |         Ends of id genaretor
    |----------------------------------------------
	 */

	/*
	 *------------------------------------------------------------
	 * 
	 *  BILL AJAX REQUEST 
	 *
	 *------------------------------------------------------------
	 */

	public function getInformation()
	{
		$aid = $this->input->post('admission_id');
		$data = array();

		/*--------------patient informatoin-----------------*/
		$info = $this->db->select("
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
				bp.discount as discount,
				bp.services as services
			")
			->from("bill_admission AS ba")
			->join("patient AS pa", "pa.patient_id = ba.patient_id", "left")
			->join("user AS dr", "dr.user_id = ba.doctor_id", "left")
			->join("inc_insurance AS in", "in.id = ba.insurance_id", "left")
			->join("bill_package AS bp", "bp.id = ba.package_id", "left")
			->where("ba.admission_id", $aid)
			->get();

		if ($info->num_rows() > 0) {
			$data['status'] = true;
			$data['result'] = $info->row();
			$alreadybill = $this->db->select('*')->from('bill')->where('admission_id', $aid)->get();

			if ($alreadybill->num_rows() > 0) {
				$data['status'] = false;
				$data['status1'] = false;
				$data['result'] = "Bill Already Generated!";
				echo json_encode($data);
				exit;
			}
		} else {
			$data['status'] = false;
			$data['result'] = "Invalid AID!";
			echo json_encode($data);
			exit;
		}
		/*--------------patient informatoin-----------------*/
		/*--------------Blood Information-------------------*/
		$this->load->helper('array');
		$this->load->model('blood_bank/blood_model');
		$bloodDetails = $this->blood_model->get_blood_sell($aid);
		$bdcharge = 0;
		$result = '<table id="fixTable" class="table table-bordered table-striped">
					<thead>
                            <tr>
                                <th>' . display("blood_group") . '</th>
                                <th>' . display("quantity") . '</th>
								<th>' . display("rate") . '</th>
								<th>' . display("discount") . '</th>
								<th>' . display("tax") . '</th>
                                <th style="width: 151px;">' . display("subtotal") . '</th>
                            </tr>
                    </thead>
                <tbody>';
		foreach ($bloodDetails as $bd) {
			$result .= "<tr>";
			$result .= "<td>" . element($bd->blood_type, $this->config->item('blood_group')) . "</td>";
			$result .= "<td>$bd->qty</td>";
			$result .= "<td>$bd->charge</td>";
			$result .= "<td>" . number_format((float)$bd->discount, 2, '.', '') . "</td>";
			$result .= "<td>" . number_format((float)$bd->tax, 2, '.', '') . "</td>";
			$result .= "<td>" . number_format((float)$bd->total, 2, '.', '') . "</td>";
			$result .= "</tr>";
			$bdcharge = $bdcharge + number_format((float)$bd->total, 2, '.', '');
		}
		$result .= "<tr><td colspan='5'></td><td><b>" . number_format((float)$bdcharge, 2, '.', '') . "</b></td></tr></tbody></table>";
		$data['bd_service_charges'] = $bdcharge;
		$data['bd_service'] = $result;
		/*--------------blood information---------------*/

		/*--------------bed information---------------*/
		$this->load->model('bed_manager/bed_assign_model');
		$this->load->model('billing/admission_model');
		$patient_details = $this->admission_model->read_by_id($aid);
		$pid = $patient_details->patient_id;
		$bedDetails = $this->bed_assign_model->get_assigned_bed($pid);
		$bedcharge = 0;
		$result = '<table id="fixTable" class="table table-bordered table-striped">
					<thead>
                            <tr>
                                <th>' . display("bed_type") . '</th>
                                <th>' . display("days") . '</th>
                                <th>' . display("rate") . '</th>
                                <th style="width: 151px;">' . display("subtotal") . '</th>
                            </tr>
                    </thead>
                <tbody>';
		foreach ($bedDetails as $bedd) {
			$result .= "<tr>";
			$result .= "<td>" . $bedd->type . "</td>";
			$result .= "<td>" . $bedd->days . "</td>";
			$result .= "<td>" . $bedd->charge . "</td>";
			$result .= "<td>" . $bedd->days * $bedd->charge . "</td>";
			$result .= "</tr>";
			$bedcharge = $bedcharge + $bedd->days * $bedd->charge;
		}
		$result .= "<tr><td colspan='3'></td><td><b>" . number_format((float)$bedcharge, 2, '.', '') . "</b></td></tr></tbody></table>";
		$data['bed_service_charges'] = $bedcharge;
		$data['bed_service'] = $result;
		/*--------------bed information---------------*/

		/*--------------lab information---------------*/
		$this->load->model('lab_manager/lab_model');
		$lab_details = $this->lab_model->read_by_aid($aid);
		$labcharge = 0;
		$result = '<table id="fixTable" class="table table-bordered table-striped">
					<thead>
                            <tr>
                                <th>' . display("test") . '</th>
                                <th>' . display("quantity") . '</th>
								<th>' . display("charge") . '</th>
								<th>' . display("discount") . '</th>
								<th>' . display("tax") . '</th>
                                <th style="width: 151px;">' . display("subtotal") . '</th>
                            </tr>
                    </thead>
                <tbody>';
		foreach ($lab_details as $lab) {

			$name = $lab->test_name ? $lab->test_name : $lab->package_name;
			$result .= "<tr>";
			$result .= "<td>" . $name . "</td>";
			$result .= "<td>1</td>";
			$result .= "<td>" . $lab->test_price . "</td>";
			$result .= "<td>" . $lab->discount . "</td>";
			$result .= "<td>" . $lab->tax . "</td>";
			$result .= "<td>" . $lab->total_price . "</td>";
			$result .= "</tr>";
			$labcharge = $labcharge + $lab->total_price;
		}
		$result .= "<tr><td colspan='5'></td><td><b>" . number_format((float)$labcharge, 2, '.', '') . "</b></td></tr></tbody></table>";
		$data['lab_service_charges'] = $labcharge;
		$data['lab_service'] = $result;
		/*--------------lab information-----------------*/

		/*--------------medicine information-----------------*/
		$this->load->model('invoices');
		$invoice_details = $this->invoices->invoice_by_aid($aid);
		$invcharge = 0;
		$result = '<table id="fixTable" class="table table-bordered table-striped">
					<thead>
                            <tr>
                                <th>' . display("product_name") . '</th>
                                <th>' . display("quantity") . '</th>
								<th>' . display("rate") . '</th>
								<th>' . display("total") . '</th>
								<th>' . display("discount") . '</th>
								<th>' . display("tax") . '</th>
								<th>' . display("paid") . '</th>
                                <th style="width: 151px;">' . display("subtotal") . '</th>
                            </tr>
                    </thead>
                <tbody>';
		foreach ($invoice_details as $value) {
			$result .= "<tr>";
			$result .= "<td>" . $value->product_name . "</td>";
			$result .= "<td>" . $value->quantity . "</td>";
			$result .= "<td>" . $value->rate . "</td>";
			$result .= "<td>" . $value->total_price . "</td>";
			$result .= "<td>" . $value->total_discount . "</td>";
			$result .= "<td>" . $value->total_tax . "</td>";
			$result .= "<td>" . $value->paid_amount . "</td>";
			$result .= "<td>" . $value->due_amount . "</td>";
			$result .= "</tr>";
			$invcharge = $invcharge + $value->due_amount;
		}
		$result .= "<tr><td colspan='7'></td><td><b>" . number_format((float)$invcharge, 2, '.', '') . "</b></td></tr></tbody></table>";
		$data['med_service_charges'] = $invcharge;
		$data['med_service'] = $result;
		/*--------------medicine information-----------------*/

		/*--------------patient service information-----------------*/
		$this->load->model('patient_model');
		$patient_services = $this->patient_model->patient_service($aid);
		$patientcharge = 0;
		$result = '<table id="fixTable" class="table table-bordered table-striped">
					<thead>
                            <tr>
                                <th>' . display("service_name") . '</th>
                                <th>' . display("quantity") . '</th>
								<th>' . display("rate") . '</th>
								<th style="width: 151px;">' . display("subtotal") . '</th>
                            </tr>
                    </thead>
                <tbody>';
		foreach ($patient_services as $value) {
			$result .= "<tr>";
			$result .= "<td>" . $value->name . "</td>";
			$result .= "<td>" . $value->quantity . "</td>";
			$result .= "<td>" . $value->amount . "</td>";
			$result .= "<td>" . $value->amount . "</td>";
			$result .= "</tr>";
			$patientcharge = $patientcharge + $value->amount;
		}
		$result .= "<tr><td colspan='3'></td><td><b>" . number_format((float)$patientcharge, 2, '.', '') . "</b></td></tr></tbody></table>";
		$data['patient_service_charges'] = $patientcharge;
		$data['patient_service'] = $result;
		/*--------------patient service information-----------------*/

		/*--------------pre-services-total-charge------------*/
		$data['pre_service_charge'] = number_format((float)($bdcharge + $bedcharge + $labcharge + $invcharge + $patientcharge), 2, '.', '');
		/*--------------pre-services-total-charge------------*/

		/*--------------advance payment-----------------*/
		$advance = $this->db->select("
			DATE(date) AS date, 
			receipt_no, 
			amount
			")
			->from("bill_advanced")
			->where("admission_id", $aid)
			->get();


		$pay_advance = 0;
		if ($advance->num_rows() > 0) {
			$result = "";
			foreach ($advance->result() as $adv) {
				$result .= "<tr>";
				$result .= "<td>$adv->date</td>";
				$result .= "<td>$adv->receipt_no</td>";
				$result .= "<td>$adv->amount</td>";
				$result .= "</tr>";
				$pay_advance = $pay_advance + $adv->amount;
			}
			$data['pay_advance'] = $pay_advance;
			$data['advance_data'] = $result;
		} else {
			$data['pay_advance'] = $pay_advance;
			$data['advance_data'] = "<tr><td colspan=\"3\" align=\"center\">No record found!</td></tr>";
		}
		/*--------------advance payment-----------------*/

		echo json_encode($data);
	}

	public function getAllService()
	{
		$aid = "URPGMMRL";

		$this->load->model('patient_model');
		$patient_services = $this->patient_model->patient_service($aid);
		$patientcharge = 0;
		$result = '<table id="fixTable" class="table table-bordered table-striped">
					<thead>
                            <tr>
                                <th>' . display("name") . '</th>
                                <th>' . display("quantity") . '</th>
								<th>' . display("rate") . '</th>
								<th>' . display("subtotal") . '</th>
                            </tr>
                    </thead>
                <tbody>';
		foreach ($patient_services as $value) {
			$result .= "<tr>";
			$result .= "<td>" . $value->name . "</td>";
			$result .= "<td>" . $value->quantity . "</td>";
			$result .= "<td>" . $value->amount . "</td>";
			$result .= "<td>" . $value->amount . "</td>";
			$result .= "</tr>";
			$patientcharge = $patientcharge + $value->amount;
		}
		echo $result;

	}

	public function opd_list()
	{
		$data['title'] = display('opd_list');
        #-------------------------------#
        #
        #pagination starts
        #
		$config["base_url"] = base_url('billing/bill/opd_list');
		$config["total_rows"] = $this->db->count_all('pr_prescription');
		$config["per_page"] = 25;
		$config["uri_segment"] = 4;
		$config["last_link"] = "Last";
		$config["first_link"] = "First";
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['full_tag_open'] = "<ul class='pagination col-xs pull-right'>";
		$config['full_tag_close'] = "</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['opd_list'] = $this->bill_model->read_opd_list($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
        #
        #pagination ends
		#		
		$data['content'] = $this->load->view('billing/bill/opd_list', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function add_opd_bill($patient_id = null, $appointment_id = null)
	{
		$data['title'] = display('add_opd_bill');
		$data['patient_id'] = $patient_id;
		$data['appointment_id'] = $appointment_id;
		#-------------------------------#
		$this->form_validation->set_rules('bill_date', display('bill_date'), 'required|max_length[10]');
		$this->form_validation->set_rules('total', display('total'), 'required|max_length[11]');
		$this->form_validation->set_rules('payment_method', display('payment_method'), 'required|max_length[255]');
		$this->form_validation->set_rules('note', display('note'), 'max_length[1024]');

		#-------------------------------#
		$bill_id = 'BL' . $this->randStrGen(2, 7);
		#-------------------------------#
		$data['bill'] = (object)$postData = array(
			'bill_id' => $bill_id,
			'bill_type' => 'opd',
			'patient_id' => $patient_id,
			'bill_date' => date('Y-m-d', strtotime($this->input->post('bill_date'))),
			'discount' => $this->input->post('discount'),
			'tax' => $this->input->post('tax'),
			'total' => $this->input->post('total'),
			'payment_method' => $this->input->post('payment_method'),
			'card_cheque_no' => $this->input->post('card_cheque_no'),
			'receipt_no' => $this->input->post('receipt_no'),
			'note' => $this->input->post('note'),
			'date' => date('Y-m-d H:i:s'),
			'status' => $this->input->post('status'),
		);  

		#-------------------------------#
		if ($this->form_validation->run()) {

			if ($this->bill_model->create($postData)) {
				#------------bill details--------------#
				$sID = $this->input->post('service_id');
				$sName = $this->input->post('service_name');
				$sQty = $this->input->post('quantity');
				$sAmt = $this->input->post('amount');
				$services = array();
				for ($i = 0; $i < sizeof($sID); $i++) {
					if (!empty($sID[$i]))
						$this->db->insert('bill_details', array(
						'bill_id' => $bill_id,
						'service_id' => $sID[$i],
						'quantity' => $sQty[$i],
						'amount' => $sAmt[$i],
						'date' => date('Y-m-d')
					));
				} 
				#-------------------------------#

				$this->session->set_flashdata('message', display('save_successfully'));

				if ($postData['status'] == 1) {
					redirect("billing/bill/view/" . $postData['bill_id']);
				}
			} else {
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect("billing/bill/add_opd_bill/$patient_id/$appointment_id");
		} else {
			$data['service_list'] = $this->service_model->readList();
			$data['content'] = $this->load->view('billing/bill/add_opd_bill', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function getInformationForOpd()
	{
		$pid = $this->input->post('patient_id');
		$apid = $this->input->post('appointment_id');
		$data = array();

		/*--------------patient informatoin-----------------*/
		$info = $this->db->select("
				pa.patient_id AS patient_id,
				CONCAT_WS(' ', pa.firstname, pa.lastname) AS patient_name,
				pa.address AS address,
				pa.date_of_birth AS date_of_birth,
				pa.sex AS sex,
				pa.picture AS picture,
				CONCAT_WS(' ', dr.firstname, dr.lastname) AS doctor_name,
			")
			->from("pr_prescription pr")
			->join("patient AS pa", "pa.patient_id = pr.patient_id", "left")
			->join("user AS dr", "dr.user_id = pr.doctor_id", "left")
			->where("pa.patient_id", $pid)
			->get();

		if ($info->num_rows() > 0) {
			$data['status'] = true;
			$data['result'] = $info->row();
			$alreadybill = $this->db->select('*')->from('pr_prescription')->where('status', 0)->where('appointment_id', $apid)->get();

			if ($alreadybill->num_rows() > 0) {
				$data['status'] = false;
				$data['status1'] = false;
				$data['result'] = "Bill Already Generated!";
				echo json_encode($data);
				exit;
			}
		} else {
			$data['status'] = false;
			$data['result'] = "Invalid Patient ID!";
			echo json_encode($data);
			exit;
		}
		/*--------------Blood Information-------------------*/
		$this->load->helper('array');
		$presc = $this->db->select('*')->from('pr_prescription')->where('status', 1)->where('appointment_id', $apid)->get()->row();
		$visiting_fees = $presc->visiting_fees;
		$bdcharge = 0;
		$result = "<div class='alert bg-primary'><div class='text-center'>" . display('visiting_fees') . " : " . $visiting_fees . "</div></div>";
		$bdcharge = $bdcharge + number_format((float)$visiting_fees, 2, '.', '');
		$data['bd_service_charges'] = $bdcharge;
		$data['bd_service'] = $result;
		/*--------------patient service information-----------------*/

		/*--------------pre-services-total-charge------------*/
		$data['pre_service_charge'] = number_format((float)($bdcharge), 2, '.', '');
		$data['result']->discount = 0;
		/*--------------pre-services-total-charge------------*/

		echo json_encode($data);
	}


}
