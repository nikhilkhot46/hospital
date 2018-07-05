<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('doctor_model');
        $this->load->model('dashboard_laboratorist/lab_manager/lab_model');
        $this->load->model('patient_model');
        
        $this->load->library('auth');
        if ($this->session->userdata('isLogIn') == false 
			|| $this->session->userdata('user_role') != 4
		) 
		redirect('login'); 
    }

    public function index()
    {
        $data['title'] = display('appointment_list');
        #-------------------------------#
        $data['appointment'] = $this->lab_model->read_appointment();
        $data['test_options'] = $this->lab_model->read_test();
        $data['package_options'] = $this->lab_model->read_package();
        $data['doctor_list'] = $this->doctor_model->doctor_list();
        $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/appointment_view', $data, true);
        $this->load->view('dashboard_laboratorist/main_wrapper', $data);
    }
    
    public function form($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('patient_id', display('patient_id'), 'required|max_length[100]');
        $this->form_validation->set_rules('appointment_type', display('appointment_type'), 'required|trim');
        $this->form_validation->set_rules('discount', display('discount'), 'trim');
        $this->form_validation->set_rules('test_price', display('test_price'), 'required|max_length[100]');
        if($this->input->post('appointment_type', true) == "t"){
            $this->form_validation->set_rules('test', display('test'), 'trim');
        }
        else{
            $this->form_validation->set_rules('package', display('package'), 'trim');
        }
        $this->form_validation->set_rules('appointment_date', display('appointment_date'), 'required');
        $this->form_validation->set_rules('payment_status', display('payment_status'), 'required');
        $this->form_validation->set_rules('status', display('status'), 'required');

        /*-------------STORE DATA------------*/
        $data['appointment'] = (object) $postData = array(
            'appointment_id' => $this->input->post('appointment_id', true),
            'patient_id' => $this->input->post('patient_id', true),
            'doctor_id' => $this->input->post('doctor_id', true),
            'doctor_name' => $this->input->post('doctor_name', true),
            'test' => $this->input->post('test', true),
            'package' => $this->input->post('package', true),
            'appointment_date' => date("Y-m-d",strtotime($this->input->post('appointment_date', true))),
            'appointment_type' => $this->input->post('appointment_type', true),
            'test_price' => $this->input->post('test_price', true),
            'discount' => $this->input->post('discount', true),
            'total_price' => $this->input->post('total_price', true),
            'blood_group' => $this->input->post('blood_group', true),
            'sample_collection_time' => $this->input->post('sample_collection_time', true),
            'status' => $this->input->post('status', true),
            'admission_id' => $this->input->post('admission_id', true),
            'payment_status' => $this->input->post('payment_status', true),
        );
        
        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if($this->input->post('admission_id', true) == "on"){
                    $aid = $this->patient_model->check_patient_aid($this->input->post('patient_id', true));
                    if(empty($aid)){
                        $this->session->set_flashdata('exception', display('patient_not_admitted'));
                        redirect('dashboard_laboratorist/lab_manager/appointment/form');
                    }
                    $postData['admission_id'] =  $aid->admission_id;
                }
                else{
                    $postData['admission_id'] ="";
                }
                
                $postData['appointment_id'] = "LA".$this->auth->randStrGen(1,8);
                
                if($this->patient_model->read_by_patient_id($this->input->post('patient_id', true))){
                    if ($this->lab_model->create_appointment($postData)) {
                        #set success message
                        $this->session->set_flashdata('message', display('save_successfully'));
                    } else {
                        #set exception message
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }
                }
                else{
                    $this->session->set_flashdata('exception', display('patient_id_not_available'));
                }
                redirect('dashboard_laboratorist/lab_manager/appointment/form');
            } else {
                $data['title'] = display('add_test');
                $data['appointment']->appointment_type = "t";
                $data['appointment']->appointment_date = date("Y-m-d");
                $data['doctor_list'] = $this->doctor_model->doctor_list();
                $data['test_options'] = $this->lab_model->read_test();
                $data['package_options'] = $this->lab_model->read_package();
                $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/appointment_form', $data, true);
                $this->load->view('dashboard_laboratorist/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if($this->input->post('admission_id', true) == "on"){
                    $aid = $this->patient_model->check_patient_aid($this->input->post('patient_id', true));
                    if(empty($aid)){
                        $this->session->set_flashdata('exception', display('patient_not_admitted'));
                        redirect('dashboard_laboratorist/lab_manager/appointment/form');
                    }
                    $postData['admission_id'] =  $aid->admission_id;
                }
                else{
                    $postData['admission_id'] ="";
                }
                if($this->patient_model->read_by_patient_id($this->input->post('patient_id', true))){
                    if ($this->lab_model->update_appointment($postData)) {
                        #set success message
                        $this->session->set_flashdata('message', display('update_successfully'));
                    } else {
                        #set exception message
                        $this->session->set_flashdata('exception', display('please_try_again'));
                    }
                }
                else{
                    $this->session->set_flashdata('exception', display('patient_id_not_available'));
                }
                redirect('dashboard_laboratorist/lab_manager/appointment/form/' . $postData['appointment_id']);
            } else {
                $data['title'] = display('appointment_edit');
                $data['doctor_list'] = $this->doctor_model->doctor_list();
                $data['test_options'] = $this->lab_model->read_test();
                $data['package_options'] = $this->lab_model->read_package();
                $data['appointment'] = $this->lab_model->read_by_appointment_id($id);
                $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/appointment_form', $data, true);
                $this->load->view('dashboard_laboratorist/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }

    public function report()
    {
        $this->form_validation->set_rules('appointment_id', display('appointment_id'), 'required|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            //$this->session->set_flashdata('exception', display('please_try_again'));
        } else {
            if($this->input->post('status') == 1){
                $config['upload_path'] = './assets/reports/';
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $this->input->post('appointment_id')."-".$_FILES['report']['name'];
                
                $this->load->library('upload', $config);
                if(!file_exists($config['upload_path'].$config['file_name'])){
                    if ( ! $this->upload->do_upload('report')){
                        $this->session->set_flashdata('exception', $this->upload->display_errors());
                    }
                    else{
                        $data = array('upload_data' => $this->upload->data());
                        $this->db->where('appointment_id', $this->input->post('appointment_id'));
                        $this->db->update('lab_appointments', array("report_doc"=>$config['file_name'],"status"=>3));//status 3 for report generated
                        
                        $this->session->set_flashdata('message', display('upload_successfully'));
                    }
                }
                else{
                    $this->session->set_flashdata('exception',display('report')." ".display('already_exists'));
                }
            }
            else{
                $this->session->set_flashdata('exception',"Reports can only be uploaded for paid appointments.");
            }            
        }
        redirect('dashboard_laboratorist/lab_manager/appointment');
    }

    public function todays_appointments()
    {
        $data['title'] = display('todays_appointment');
        #-------------------------------#
        $data['appointment'] = $this->lab_model->read_todays_appointment();
        $data['test_options'] = $this->lab_model->read_test();
        $data['package_options'] = $this->lab_model->read_package();
        $data['doctor_list'] = $this->doctor_model->doctor_list();
        $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/appointment_view', $data, true);
        $this->load->view('dashboard_laboratorist/main_wrapper', $data);
    }

}

/* End of file Appointment.php */

