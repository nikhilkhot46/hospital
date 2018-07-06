<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operation extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model(array(
            'operation/operation_model',
            'doctor_model'
        ));
        $this->load->library('auth');
        
        if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 1
        ) 
        redirect('login'); 

    }
 
    public function index()
    {
        $data['title'] = display('operation_report');
        #-------------------------------#
        $data['operations'] = $this->operation_model->read();
        $data['content'] = $this->load->view('operation/operation_view',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }

    public function add_theater()
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('name', display('ot_name') ,'required|max_length[100]');
        $this->form_validation->set_rules('description', display('ot_description'),'trim');
        $this->form_validation->set_rules('status', display('status') ,'required');

        /*-----------CHECK ID -----------*/
        if (empty($this->input->post('id',true))) {
            $data['theater'] = (object)$postData = array( 
                'ot_id'          => "OT".$this->auth->randStrGen(2,7),
                'ot_name'        => $this->input->post('name',true),
                'ot_description' => $this->input->post('description',true),
                'added_date'     => date("Y-m-d"),
                'status'      => $this->input->post('status',true)
            ); 
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->operation_model->add_theater($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/add_theater');
            } else {
                $data['title'] = display('add_operation_theater');
                $data['content'] = $this->load->view('operation/add_operation_theater_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            $data['theater'] = (object)$postData = array( 
                'ot_id'          => $this->input->post('id',true),
                'ot_name'        => $this->input->post('name',true),
                'ot_description' => $this->input->post('description',true),
                'added_date'     => date("Y-m-d"),
                'status'      => $this->input->post('status',true)
            );  
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->operation_model->update_theater($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/update_theater/'.$postData['ot_id']);
            } else {
                $data['title'] = display('ot_edit');
                $data['theater'] = $this->operation_model->read_by_ot_id($id);
                $data['content'] = $this->load->view('operation/update_theater',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        }
    }

    public function update_theater($id)
    {
        $data['title'] = display('ot_edit');
        $data['theater'] = $this->operation_model->read_by_ot_id($id);
        $data['content'] = $this->load->view('operation/update_theater',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }



    public function form($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('patient_id', display('patient_id') ,'required|max_length[20]');
        $this->form_validation->set_rules('date', display('date') ,'required|max_length[10]');
        $this->form_validation->set_rules('title', display('title') ,'required|max_length[255]');
        $this->form_validation->set_rules('description', display('description'),'trim');
        $this->form_validation->set_rules('doctor_id', display('doctor_name') ,'max_length[100]');
        $this->form_validation->set_rules('status', display('status') ,'required');

        /*-------------STORE DATA------------*/
        $date = $this->input->post('date');

        $data['operation'] = (object)$postData = array( 
            'id'          => $this->input->post('id'),
            'patient_id'  => $this->input->post('patient_id'),
            'date'        => date('Y-m-d', strtotime((!empty($date) ? $date : date('Y-m-d')))),
            'title'       => $this->input->post('title'),
            'description' => $this->input->post('description',false),
            'doctor_id'   => $this->input->post('doctor_id'),
            'status'      => $this->input->post('status')
        );  

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                $this->load->model('patient_model');
                
                $newresult = $this->patient_model->check_patient_aid($this->input->post('patient_id'));
                if(!$newresult || empty($newresult) || $newresult == null || $newresult == NULL || $newresult == ""){
                    $this->session->set_flashdata('exception',display('patient_not_admitted'));
                    redirect('operation/operation/form');
                }

                if ($this->operation_model->create($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/form');
            } else {
                $data['title'] = display('add_operation_report');
                $data['doctor_list'] = $this->doctor_model->doctor_list();
                $data['content'] = $this->load->view('operation/operation_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else { 
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                $this->load->model('patient_model');
                
                $newresult = $this->patient_model->check_patient_aid($this->input->post('patient_id'));
                if(!$newresult || empty($newresult) || $newresult == null || $newresult == NULL || $newresult == ""){
                    $this->session->set_flashdata('exception',display('patient_not_admitted'));
                    redirect('operation/operation/form/'.$postData['id']);
                }
                if ($this->operation_model->update($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/form/'.$postData['id']);
            } else {
                $data['title'] = display('operation_report_edit');
                $data['operation'] = $this->operation_model->read_by_id($id);
                $data['doctor_list'] = $this->doctor_model->doctor_list();
                $data['content'] = $this->load->view('operation/operation_form',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }
 

    public function details($id = null)
    {
        $data['title'] = display('operation_report');
        #-------------------------------#
        $data['details'] = $this->operation_model->read_by_id($id);
        $data['content'] = $this->load->view('operation/details', $data, true);
        $this->load->view('layout/main_wrapper',$data);
    }

    public function ot_list($id = null)
    {
        $data['title'] = display('ot_list');
        $data['ot'] = $this->operation_model->read_ot();
        $data['content'] = $this->load->view('operation/ot_list', $data, true);
        $this->load->view('layout/main_wrapper',$data);
    } 


    public function delete($id = null) 
    {
        if ($this->operation_model->delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('operation/operation');
    }


    public function add_equipment()
    {
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('equip_name', display('ot_name') ,'required|max_length[100]');
        $this->form_validation->set_rules('description', display('ot_description'),'trim');
        $this->form_validation->set_rules('quantity', display('quantity'), 'trim|required');
        //$this->form_validation->set_rules('status', display('status') ,'required');

        /*-----------CHECK ID -----------*/
        if (empty($this->input->post('equip_id',true))) {
            $data['equipment'] = (object)$postData = array( 
                'equip_id'          => "EQ".$this->auth->randStrGen(2,7),
                'equip_name'        => $this->input->post('equip_name',true),
                'description'       => $this->input->post('description',true),
                'qty'               => $this->input->post('quantity',true),
                'remaining'               => $this->input->post('quantity',true),
                'added_date'        => date("Y-m-d"),
                //'status'            => $this->input->post('status',true)
            ); 
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->operation_model->add_equipment($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/add_equipment');
            } else {
                $data['title'] = display('add_equipment');
                $data['content'] = $this->load->view('operation/add_equipment',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else {
            $eq = $this->operation_model->read_by_equipment_id($this->input->post('equip_id',true));
            if($eq->qty > $this->input->post('quantity',true)){
                $qty = $this->input->post('quantity',true) - $eq->qty;
            }else{
                $qty = $this->input->post('quantity',true) - $eq->qty;
            }
            echo $remain = $eq->remaining+$qty ;
            $data['equipment'] = (object)$postData = array( 
                'equip_id'          => $this->input->post('equip_id',true),
                'equip_name'        => $this->input->post('equip_name',true),
                'description'       => $this->input->post('description',true),
                'qty'               => $this->input->post('quantity',true),
                'remaining'         => $remain,
                'added_date'        => date("Y-m-d"),
                //'status'            => $this->input->post('status',true)
            );  
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                if ($this->operation_model->update_equipment($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/update_equipment/'.$postData['equip_id']);
            } else {
                $data['title'] = display('update_equipment');
                $data['equipment'] = $this->operation_model->read_by_equipment_id($id);
                $data['content'] = $this->load->view('operation/update_equipment',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        }
    }

    public function equipment_list()
    {
        $data['title'] = display('equipment_list');
        $data['equipment'] = $this->operation_model->read_equipment();
        $data['content'] = $this->load->view('operation/equipment_list', $data, true);
        $this->load->view('layout/main_wrapper',$data);
    }

    public function update_equipment($id)
    {
        $data['title'] = display('edit_equipment');
        $data['equipment'] = $this->operation_model->read_by_equipment_id($id);
        $data['content'] = $this->load->view('operation/update_equipment',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }

    public function assign_equipment()
    {
        /*----------FORM VALIDATION RULES----------*/
         $this->form_validation->set_rules('ot_name', display('ot_name') ,'required|max_length[100]');
         $this->form_validation->set_rules('equip_name', display('ot_name') ,'required|max_length[100]');
         $this->form_validation->set_rules('equip_qty', display('quantity'), 'trim|required');
         $this->form_validation->set_rules('date', display('date'), 'trim|required');
         $this->form_validation->set_rules('status', display('status') ,'required');
 
         /*-----------CHECK ID -----------*/
         if (empty($this->input->post('assign_id',true))) {
             $data['equipment'] = (object)$postData = array( 
                 'assign_id'    => "AE".$this->auth->randStrGen(2,7),
                 'ot_id'        => $this->input->post('ot_name',true),
                 'equip_id'     => $this->input->post('equip_name',true),
                 'equip_qty'    => $this->input->post('equip_qty',true),
                 'start_date'   => $this->input->post('date',true),
                 'status'       => $this->input->post('status',true)
             ); 
             /*-----------CREATE A NEW RECORD-----------*/
             if ($this->form_validation->run() === true) {

                $equip = $this->operation_model->read_by_equipment_id($this->input->post('equip_name',true));
                if($equip->remaining >= $this->input->post('equip_qty',true)){
                    if ($this->operation_model->assign_equipment($postData)) {
                        #set success message
                        $this->session->set_flashdata('message', display('save_successfully'));
                    } else {
                        #set exception message
                        $this->session->set_flashdata('exception',display('please_try_again'));
                    }
                }
                else{
                    $this->session->set_flashdata('exception',display('this_much_not_available'));
                }
                 redirect('operation/operation/assign_equipment');
             } else {
                $data['title'] = display('assign_equipment');
                $data['equipment'] = $this->operation_model->read_equipment();
                $data['ot'] = $this->operation_model->read_ot();
                $data['content'] = $this->load->view('operation/assign_equipment',$data,true);
                $this->load->view('layout/main_wrapper',$data);
             } 
 
         } else {
            $data['equipment'] = (object)$postData = array( 
                'assign_id'    => $this->input->post('assign_id',true),
                'ot_id'        => $this->input->post('ot_name',true),
                'equip_id'     => $this->input->post('equip_name',true),
                'equip_qty'    => $this->input->post('equip_qty',true),
                'start_date'   => $this->input->post('date',true),
                'status'       => $this->input->post('status',true)
            ); 
             /*-----------UPDATE A RECORD-----------*/
             if ($this->form_validation->run() === true) { 
                if ($this->operation_model->update_assign_equipment($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/update_assign_equipment/'.$postData['assign_id']);
             } else {
                redirect('operation/operation/update_assign_equipment/'.$postData['assign_id']);
             } 
         }
    }

    public function assign_equipment_list()
    {
        $data['title'] = display('assign_equipment_list');
        $data['equipment'] = $this->operation_model->read_assigned_equipment();
        $data['content'] = $this->load->view('operation/assign_equipment_list', $data, true);
        $this->load->view('layout/main_wrapper',$data);
    }

    public function update_assign_equipment($id)
    {
        $data['title'] = display('edit_equipment');
        $data['equipment'] = $this->operation_model->read_equipment();
        $data['ot'] = $this->operation_model->read_ot();
        $data['assign_equip'] = $this->operation_model->read_assigned_equipment_id($id);
        $data['content'] = $this->load->view('operation/update_assign_equipment',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }


    public function assign_ot($id = null)
    { 
        /*----------FORM VALIDATION RULES----------*/
        $this->form_validation->set_rules('patient_id', display('patient_id') ,'required|max_length[20]');
        $this->form_validation->set_rules('ot_id', display('ot_id') ,'required');
        $this->form_validation->set_rules('date', display('date') ,'required|max_length[10]');
        $this->form_validation->set_rules('start_time', display('start_time') ,'required');
        $this->form_validation->set_rules('end_time', display('end_time') ,'required');
        $this->form_validation->set_rules('description', display('description'),'trim');
        $this->form_validation->set_rules('doctor_id', display('doctor_name') ,'max_length[100]');
        $this->form_validation->set_rules('status', display('status') ,'required');

        /*-------------STORE DATA------------*/
        $date = $this->input->post('date');

        $data['operation'] = (object)$postData = array( 
            'assign_ot_id'=> $this->input->post('id'),
            'ot_id'       => $this->input->post('ot_id'),
            'patient_id'  => $this->input->post('patient_id'),
            'date'        => date('Y-m-d', strtotime((!empty($date) ? $date : date('Y-m-d')))),
            'start_time'  => $this->input->post('start_time'),
            'end_time'    => $this->input->post('end_time'),
            'description' => $this->input->post('description',false),
            'doctor_id'   => $this->input->post('doctor_id'),
            'status'      => $this->input->post('status')
        );  

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                $this->load->model('patient_model');
                $postData['assign_ot_id'] = "AOT".$this->auth->randStrGen(2,7);
                $newresult = $this->patient_model->check_patient_aid($this->input->post('patient_id'));
                if(!$newresult || empty($newresult) || $newresult == null || $newresult == NULL || $newresult == ""){
                    $this->session->set_flashdata('exception',display('patient_not_admitted'));
                    redirect('operation/operation/assign_ot');
                }
                
                $this->db->select('*');
                $this->db->from('assign_ot');
                $this->db->where('ot_id', $this->input->post('ot_id'));
                $this->db->where('date', date('Y-m-d', strtotime($this->input->post('date'))));
                $this->db->where('start_time <=', $this->input->post('end_time'));
                $this->db->where('status', 1);
                $query = $this->db->get()->result();
                if(count($query) > 0){
                    $this->session->set_flashdata('exception',display('ot_unavailable'));
                    redirect('operation/operation/assign_ot');
                }
                if ($this->operation_model->assign_ot($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/assign_ot');
            } else {
                $data['title'] = display('assign_ot');
                $data['doctor_list'] = $this->doctor_model->doctor_list();
                $data['ot_list'] = $this->operation_model->read_ot();
                $data['content'] = $this->load->view('operation/assign_ot',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 

        } else { 
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) { 
                $this->load->model('patient_model');
                
                $newresult = $this->patient_model->check_patient_aid($this->input->post('patient_id'));
                if(!$newresult || empty($newresult) || $newresult == null || $newresult == NULL || $newresult == ""){
                    $this->session->set_flashdata('exception',display('patient_not_admitted'));
                    redirect('operation/operation/assign_ot/'.$postData['assign_ot_id']);
                }
                if ($this->operation_model->update_assign_ot($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception',display('please_try_again'));
                }
                redirect('operation/operation/assign_ot/'.$postData['assign_ot_id']);
            } else {
                $data['title'] = display('update_assign_ot');
                $data['operation'] = $this->operation_model->read_by_assign_ot_id($id);
                $data['doctor_list'] = $this->doctor_model->doctor_list();
                $data['ot_list'] = $this->operation_model->read_ot();
                $data['content'] = $this->load->view('operation/assign_ot',$data,true);
                $this->load->view('layout/main_wrapper',$data);
            } 
        } 
        /*---------------------------------*/
    }

    public function assign_ot_list()
    {
        $data['title'] = display('assign_ot_list');
        #-------------------------------#
        $data['operations'] = $this->operation_model->read_assign_ot();
        $data['content'] = $this->load->view('operation/assign_ot_list',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }

    public function assign_ot_details($id = null)
    {
        $data['title'] = display('assign_ot_details');
        #-------------------------------#
        $data['details'] = $this->operation_model->read_by_assign_ot_id($id);
        $data['content'] = $this->load->view('operation/assign_ot_details', $data, true);
        $this->load->view('layout/main_wrapper',$data);
    }
}
