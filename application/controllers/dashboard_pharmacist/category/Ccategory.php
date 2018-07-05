<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccategory extends CI_Controller {
	public $menu;
	function __construct() {
      parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcategory');
		//$this->load->library('session');
		$this->load->model('Categories');
		//$this->auth->check_admin_auth();
		//$this->template->current_menu = 'category';
		if ($this->session->userdata('isLogIn') == false 
		|| $this->session->userdata('user_role') != 6
	) 
	redirect('login'); 
    }
	//Default loading for Category system.
	public function index()
	{
		
		$data = $this->lcategory->category_add_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/category/add_category_form',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	//Product Add Form
	public function manage_category()
	{
		$data = $this->lcategory->category_list();
		$data['content']  = $this->load->view('dashboard_pharmacist/category/category',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	//Insert Product and upload
	public function insert_category()
	{
		$category_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'category_id' 			=> $category_id,
			'category_name' 		=> $this->input->post('category_name'),
			'status' 				=> 1
			);

		$result=$this->Categories->category_entry($data);
		if ($result == TRUE) {
			//Previous balance adding -> Sending to customer model to adjust the data.			
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			if(isset($_POST['add-customer'])){
				redirect(base_url('dashboard_pharmacist/category/Ccategory/manage_category'));
				exit;
			}elseif(isset($_POST['add-customer-another'])){
				redirect(base_url('dashboard_pharmacist/category/Ccategory'));
				exit;
			}
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_inserted')));
			redirect(base_url('dashboard_pharmacist/category/Ccategory'));
		}
	}
	//customer Update Form
	public function category_update_form($category_id)
	{	
		$data = $this->lcategory->category_edit_data($category_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/category/edit_category_form',$data,true);
		$data['title'] = display('category_edit');
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	// customer Update
	public function category_update()
	{
		$category_id  = $this->input->post('category_id');
		$data=array(
			'category_name' => $this->input->post('category_name'),
			'status' 		=> $this->input->post('status'),
			);

		$this->Categories->update_category($data,$category_id);
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('dashboard_pharmacist/category/Ccategory/manage_category'));
		exit;
	}
	// product_delete
	public function category_delete()
	{	
		$category_id =  $_POST['category_id'];
		$this->Categories->delete_category($category_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		return true;
			
	}
}