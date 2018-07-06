<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'dashboard_patient/home_model', 
            'dashboard_patient/prescription/prescription_model' 
        )); 
 
        
        if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 10
        ) 
        redirect('login'); 
    }
 
    public function index()
    {
        $data['title'] = display('home');
        #-------------------------------#
        $data['prescription'] = $this->prescription_model->read(); 
        $data['content'] = $this->load->view('dashboard_patient/home/dashboard',$data,true);
        $this->load->view('dashboard_patient/main_wrapper',$data);
    }

    public function profile()
    {  
        $data['title'] = display('profile');
        #------------------------------# 
        $user_id = $this->session->userdata('user_id');
        $data['user']    = $this->home_model->profile($user_id);
        $data['content'] = $this->load->view('dashboard_patient/home/profile', $data, true);
        $this->load->view('dashboard_patient/main_wrapper',$data);
    } 



    public function email_check($email, $user_id)
    { 
        $emailExists = $this->db->select('email')
            ->where('email',$email) 
            ->where_not_in('user_id',$user_id) 
            ->get('user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }

 
    public function form()
    {
        $data['title'] = display('edit_profile');
        $user_id = $this->session->userdata('user_id');
        #-------------------------------#
        $this->form_validation->set_rules('firstname', display('first_name') ,'required|max_length[50]');
        $this->form_validation->set_rules('lastname', display('last_name'),'required|max_length[50]');

        $this->form_validation->set_rules('email',display('email'), "required|max_length[50]|valid_email|callback_email_check[$user_id]");

        $this->form_validation->set_rules('password', display('password'),'required|max_length[32]|md5');

        $this->form_validation->set_rules('phone', display('phone') ,'max_length[20]');
        $this->form_validation->set_rules('mobile', display('mobile'),'required|max_length[20]');
        $this->form_validation->set_rules('blood_group', display('blood_group'),'max_length[10]');
        $this->form_validation->set_rules('sex', display('sex'),'required|max_length[10]');
        $this->form_validation->set_rules('date_of_birth', display('date_of_birth'),'max_length[10]');
        $this->form_validation->set_rules('address',display('address'),'required|max_length[255]');
        $this->form_validation->set_rules('status',display('status'),'required');
        #-------------------------------#
        //picture upload
        $picture = $this->fileupload->do_upload(
            'assets/images/doctor/',
            'picture'
        );
        // if picture is uploaded then resize the picture
        if ($picture !== false && $picture != null) {
            $this->fileupload->do_resize(
                $picture, 293, 350
            );
        }
        //if picture is not uploaded
        if ($picture === false) {
            $this->session->set_flashdata('exception', display('invalid_picture'));
        }
        #-------------------------------# 
        $data['patient'] = (object)$postData = [
            'id'           => $this->input->post('id'),
            'firstname'    => $this->input->post('firstname'),
            'lastname'     => $this->input->post('lastname'),
            'email'        => $this->input->post('email'),
            'password'     => md5($this->input->post('password')),
            'phone'        => $this->input->post('phone'),
            'mobile'       => $this->input->post('mobile'),
            'blood_group'  => $this->input->post('blood_group'),
            'sex'          => $this->input->post('sex'),
            'date_of_birth' => date('Y-m-d', strtotime($this->input->post('date_of_birth'))),
            'address'      => $this->input->post('address'),
            'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture')),
            'affliate'     => null, 
            'created_by'   => $this->session->userdata('user_id'),
            'status'       => $this->input->post('status'),
        ]; 

        #-------------------------------#
        if ($this->form_validation->run()) {

            if ($this->home_model->update($postData)) {
                //update profile picture
                $this->session->set_userdata([
                    'picture'   => $postData['picture'],
                    'fullname'  => $postData['firstname'].' '.$postData['lastname']
                ]); 
                #set success message
                $this->session->set_flashdata('message',display('update_successfully'));
            } else {
                #set exception message
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
 
            redirect('dashboard_patient/home/form/');

        } else {
            $user_id = $this->session->userdata('user_id');
            $data['department_list'] = $this->home_model->department_list(); 
            $data['patient'] = $this->home_model->profile($user_id); 
            $data['content'] = $this->load->view('dashboard_patient/home/profile_form',$data,true);
            $this->load->view('dashboard_patient/main_wrapper',$data);
        } 
    }
 

    public function logout()
    {  
        $this->session->sess_destroy(); 
        redirect('login');
    } 
 

}
