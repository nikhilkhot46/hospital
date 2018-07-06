<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model('dashboard_laboratorist/lab_manager/lab_model');
        if ($this->session->userdata('isLogIn') == false 
			|| $this->session->userdata('user_role') != 4
		) 
		redirect('login'); 
    }
    
    public function index()
    {
        $data['title'] = display('test_list');
        #-------------------------------#
        $data['tests'] = $this->lab_model->read_test();
        $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/test_view', $data, true);
        $this->load->view('dashboard_laboratorist/main_wrapper', $data);
    }

    public function form($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        if(empty($id)){
            $this->form_validation->set_rules('test_name', display('test_name'), 'required|max_length[100]|is_unique[lab_tests.test_name]');
            $this->form_validation->set_rules('test_short_name', display('test_short_name'), 'required|trim|is_unique[lab_tests.test_short_name]');
        }
        $this->form_validation->set_rules('test_description', display('test_description'), 'trim');
        $this->form_validation->set_rules('test_price', display('test_price'), 'required|max_length[100]');
        $this->form_validation->set_rules('status', display('status'), 'required');

        /*-------------STORE DATA------------*/
        $data['bed'] = (object) $postData = array(
            'test_id' => $this->input->post('test_id', true),
            'test_name' => $this->input->post('test_name', true),
            'test_short_name' => $this->input->post('test_short_name', true),
            'test_description' => $this->input->post('test_description', true),
            'test_price' => $this->input->post('test_price', true),
            'status' => $this->input->post('status', true),
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['test_id'] = "LT".$this->auth->randStrGen(1,8);
                if ($this->lab_model->create_test($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('dashboard_laboratorist/lab_manager/test/form');
            } else {
                $data['title'] = display('add_test');
                $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/test_form', $data, true);
                $this->load->view('dashboard_laboratorist/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if ($this->lab_model->update_test($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('dashboard_laboratorist/lab_manager/test/form/' . $postData['test_id']);
            } else {
                $data['title'] = display('test_edit');
                $data['bed'] = $this->lab_model->read_by_test_id($id);
                $data['content'] = $this->load->view('dashboard_laboratorist/lab_manager/test_form', $data, true);
                $this->load->view('dashboard_laboratorist/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }

    public function getTestPrice()
    {
        if($this->input->is_ajax_request()){
            $result = array('status' => 'FAIL', 'mes' => '', 'test_price' => 0.00, 'final_price' => 0.00);
            if($this->input->post('test_id')){
                $details = $this->lab_model->read_by_test_id($this->input->post('test_id'));
                if(!empty($details)){
                    $result['status'] = 'SUCCESS';
                    $result['test_price'] = $details->test_price;
                    $result['final_price'] = $details->test_price;
                }
            }
            echo json_encode($result); return;
        }
    }

}

/* End of file Test.php */
