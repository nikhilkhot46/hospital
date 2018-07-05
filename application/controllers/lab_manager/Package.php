<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model('lab_manager/lab_model');
        if ($this->session->userdata('isLogIn') == false 
			|| $this->session->userdata('user_role') != 1
		) 
		redirect('login'); 
    }
    
    public function index()
    {
        $data['title'] = display('package_list');
        #-------------------------------#
        $data['package'] = $this->lab_model->read_package();
        $data['tests_data'] = $this->lab_model->read_test();
        $data['content'] = $this->load->view('lab_manager/package_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function form($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        if(empty($id)){
            $this->form_validation->set_rules('package_name', display('package_name'), 'required|max_length[100]|is_unique[lab_packages.package_name]');
        }
        $this->form_validation->set_rules('tests[]', display('tests'), 'trim|required');
        $this->form_validation->set_rules('actual_price', display('actual_price'), 'required');
        $this->form_validation->set_rules('discount', display('discount'), 'required');
        $this->form_validation->set_rules('final_price', display('final_price'), 'required');
        $this->form_validation->set_rules('status', display('status'), 'required');
        
        /*-------------STORE DATA------------*/
        $data['package'] = (object) $postData = array(
            'package_id' => $this->input->post('package_id', true),
            'package_name' => $this->input->post('package_name', true),
            'package_description' => $this->input->post('package_description', true),
            'actual_price' => $this->input->post('actual_price', true),
            'discount' => $this->input->post('discount', true),
            'final_price' => $this->input->post('final_price', true),
            'status' => $this->input->post('status', true),
            'package_tests'=>'',
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['package_tests'] = implode(",", $this->input->post('tests', true));
                $postData['package_id'] = "LTP".$this->auth->randStrGen(1,7);
                if ($this->lab_model->create_package($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('lab_manager/package/form');
            } else {
                $data['title'] = display('add_package');
                $data['tests_data'] = $this->lab_model->read_active_test();
                $data['content'] = $this->load->view('lab_manager/package_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['package_tests'] = implode(",", $this->input->post('tests', true));
                if ($this->lab_model->update_package($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('lab_manager/package/form/' . $postData['package_id']);
            } else {
                $data['title'] = display('package_edit');
                $data['tests'] = [];
                $data['tests_data'] = $this->lab_model->read_test();
                $data['package'] = $this->lab_model->read_by_package_id($id);
                $data['content'] = $this->load->view('lab_manager/package_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }

    public function getPackagePrice()
    {
        if($this->input->is_ajax_request()){
            $result = array('status' => 'FAIL', 'mes' => '', 'test_price' => 0.00, 'final_price' => 0.00);
            if($this->input->post('package_id')){
                $details = $this->lab_model->read_by_package_id($this->input->post('package_id'));
                if(!empty($details)){
                    $result['status'] = 'SUCCESS';
                    $result['package_actual_price'] = $details->actual_price;
                    $result['package_final_price'] = $details->final_price;
                }
            }
            echo json_encode($result); return;
        }
    }

}

/* End of file Package.php */
