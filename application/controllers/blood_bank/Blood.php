<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blood extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'blood_bank/blood_model','patient_model'
        ));

        $this->load->library('auth');
        

        if ($this->session->userdata('isLogIn') == false
            || $this->session->userdata('user_role') != 1
        ) {
            redirect('login');
        }

    }

    public function index()
    {
        $data['title'] = display('blood_stock');
        #-------------------------------#
        $data['blood'] = $this->blood_model->read();
        $data['content'] = $this->load->view('blood_bank/blood_stock_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function form($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('blood_type', display('blood_group'), 'required|max_length[100]');
        $this->form_validation->set_rules('blood_qty', display('blood_qty'), 'trim|required|numeric');
        $this->form_validation->set_rules('donar_id', display('donar_name'), 'required|max_length[100]');
        $this->form_validation->set_rules('price', display('price'), 'required|max_length[100]');

        /*-------------STORE DATA------------*/
        $data['purchase'] = (object) $postData = array(
            'purchse_id' => $this->input->post('purchse_id', true),
            'blood_type' => $this->input->post('blood_type', true),
            'blood_qty' => $this->input->post('blood_qty', true),
            'donar_id' => $this->input->post('donar_id', true),
            'price' => $this->input->post('price', true),
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['purchse_id'] = "BB".$this->auth->randStrGen(2,8);
                if ($this->blood_model->create($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/form');
            } else {
                $data['title'] = display('add_bed');
                $data['content'] = $this->load->view('blood_bank/blood_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if ($this->bed_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/form/' . $postData['purchse_id']);
            } else {
                $data['title'] = display('bed_edit');
                $data['bed'] = $this->bed_model->read_by_id($id);
                $data['content'] = $this->load->view('blood_bank/blood_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }

    public function getDonors($id = null)
    {
        $result = $this->db->where("blood_type",$id)->get("blood_donars")->result();
        echo json_encode($result);
    }

    public function delete($id = null)
    {
        if ($this->bed_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('bed_manager/bed');
    }

    public function blood_doners($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('donar_name', display('donar_name'), 'required|max_length[100]');
        $this->form_validation->set_rules('blood_type', display('blood_type'), 'trim');
        $this->form_validation->set_rules('email', display('email'), 'required|max_length[100]|valid_email');
        $this->form_validation->set_rules('mobile', display('mobile'), 'required');

        /*-------------STORE DATA------------*/
        $data['blood_doner'] = (object) $postData = array(
            'donor_id' => $this->input->post('donor_id', true),
            'donar_name' => $this->input->post('donar_name', true),
            'blood_type' => $this->input->post('blood_type', true),
            'email' => $this->input->post('email', true),
            'mobile' => $this->input->post('mobile', true),
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['donor_id'] = "BD".$this->auth->randStrGen(2,8);
                if ($this->blood_model->create_donor($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/blood_doners');
            } else {
                $data['title'] = display('add_doner');
                $data['content'] = $this->load->view('blood_bank/doner_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if ($this->blood_model->update_donor($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/blood_doners/' . $postData['donor_id']);
            } else {
                $data['title'] = display('donor_edit');
                $data['blood_doner'] = $this->blood_model->read_by_donor_id($id);
                $data['content'] = $this->load->view('blood_bank/doner_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }

    public function donor_list()
    {
        $data['title'] = display('donor_list');
        #-------------------------------#
        $data['donor_list'] = $this->blood_model->read_donors();
        $data['content'] = $this->load->view('blood_bank/donor_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }


    public function report()
    {
        $data['title'] = display('sell_report');
        #-------------------------------#
        $data['sell'] = $this->blood_model->read_sell_blood();
        $data['content'] = $this->load->view('blood_bank/blood_sell_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function sell_blood($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('patient_id', display('patient_id'), 'required|max_length[100]');
        $this->form_validation->set_rules('blood_type', display('blood_group'), 'trim|required');
        $this->form_validation->set_rules('quantity', display('quantity'), 'required');
        $this->form_validation->set_rules('charge', display('charge'), 'required|max_length[100]');
        $this->form_validation->set_rules('total', display('total'), 'required');

        /*-------------STORE DATA------------*/
        $data['sell'] = (object) $postData = array(
            'sell_id' => $this->input->post('sell_id', true),
            'patient_id' => $this->input->post('patient_id', true),
            'admission_id' => $this->input->post('admission_id', true),
            'blood_type' => $this->input->post('blood_type', true),
            'qty' => $this->input->post('quantity', true),
            'charge' => $this->input->post('charge', true),
            'discount' => $this->input->post('discount', true),
            'tax' => $this->input->post('tax', true),
            'total' => $this->input->post('total', true),
            'status' => $this->input->post('status', true),
            'bill_generated' => $this->input->post('bill_generated')
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if($this->input->post('admission_id', true) == "on"){
                    echo $this->input->post('patient_id', true);
                    $aid = $this->patient_model->check_patient_aid($this->input->post('patient_id', true));
                    if(empty($aid)){
                        $this->session->set_flashdata('exception', display('patient_not_admitted'));
                        redirect('blood_bank/blood/sell_blood');
                    }
                    $postData['admission_id'] =  $aid->admission_id;
                }
                else{
                    $postData['admission_id'] ="";
                }
                $postData['sell_id'] = "BS".$this->auth->randStrGen(2,8);
                if($this->patient_model->read_by_patient_id($this->input->post('patient_id', true))){
                    if ($this->blood_model->sell_blood($postData)) {
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
                redirect('blood_bank/blood/sell_blood');
            } else {
                $data['title'] = display('sell_blood');
                $data['content'] = $this->load->view('blood_bank/blood_sell_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if($this->input->post('admission_id', true) == "on"){
                    echo $this->input->post('patient_id', true);
                    $aid = $this->patient_model->check_patient_aid($this->input->post('patient_id', true));
                    if(empty($aid)){
                        $this->session->set_flashdata('exception', display('patient_not_admitted'));
                        redirect('blood_bank/blood/sell_blood');
                    }
                    $postData['admission_id'] =  $aid->admission_id;
                }
                else{
                    $postData['admission_id'] ="";
                }
                if ($this->blood_model->update_sell_blood($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/sell_blood/' . $postData['sell_id']);
            } else {
                $data['title'] = display('sell_edit');
                $data['sell'] = $this->blood_model->read_by_sell_id($id);
                $data['content'] = $this->load->view('blood_bank/blood_sell_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }


    public function wastage()
    {
        $data['title'] = display('wastage_list');
        #-------------------------------#
        $data['wastage'] = $this->blood_model->read_waste_blood();
        $data['content'] = $this->load->view('blood_bank/waste_blood_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }
    
    public function wastage_report($type = null)
    {
        $data['title'] = display('wastage_list');
        #-------------------------------#
        $data['wastage'] = $this->blood_model->read_signle_waste_blood($type);
        $data['content'] = $this->load->view('blood_bank/single_waste_blood_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    public function add_wastage($id = null)
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('blood_type', display('blood_group'), 'trim|required');
        $this->form_validation->set_rules('quantity', display('quantity'), 'required');

        /*-------------STORE DATA------------*/
        $data['wastage'] = (object) $postData = array(
            'wastage_id' => $this->input->post('wastage_id', true),
            'blood_type' => $this->input->post('blood_type', true),
            'qty' => $this->input->post('quantity', true),
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['wastage_id'] = "WB".$this->auth->randStrGen(2,8);
                if ($this->blood_model->wastage_blood($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/add_wastage');
            } else {
                $data['title'] = display('add_wastage');
                $data['content'] = $this->load->view('blood_bank/add_waste_blood', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }

        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if ($this->blood_model->update_wastage_blood($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('blood_bank/blood/add_wastage/' . $postData['wastage_id']);
            } else {
                $data['title'] = display('edit_wastage');
                $data['wastage'] = $this->blood_model->read_by_wastage_id($id);
                $data['content'] = $this->load->view('blood_bank/add_waste_blood', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        }
        /*---------------------------------*/
    }

    public function bloodStock()
    {
        $blood_group = $this->input->post('blood_group');
        $this->db->select('remaining');
        $this->db->where('blood_type', $blood_group);
        $query = $this->db->get('blood_stock')->row(); 
        if($query){
            if($query->remaining == 0){
                echo display('no_blood_available');
            }else{
                echo $query->remaining;
            }
        }else{
            echo display('no_blood_available');
        }
    }

}
