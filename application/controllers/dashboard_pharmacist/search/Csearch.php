<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csearch extends CI_Controller {
	
	public $company_id;
	function __construct() {
      parent::__construct(); 
		$this->load->library('auth');
		$this->load->library('lsearch');
		$this->load->model('dashboard_pharmacist/Search');
		$this->load->model('Setting_model','Web_settings');
		
		if ($this->session->userdata('isLogIn') == false || $this->session->userdata('user_role') != 6)
		{ 
			$this->session->set_userdata(array('error_message'=>display('you_are_not_access_this_part')));
			redirect('login'); 
		}
    }
    #===========Company page load===========#
	public function index()
	{
		$data = $this->lsearch->medicine_search_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/search/medicine_search',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

    #===========Medicine page load=========#
	public function medicine()
	{
		$data = $this->lsearch->medicine_search_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/search/medicine_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	#===========Medicine search============#
	public function medicine_search()
	{
		$keyword = $this->input->post('what_you_search');
		$search_result = $this->Search->medicine_search($keyword);

		if(!empty($search_result)){
			$i=0;
			foreach($search_result as $k=>$v){
				$i++;
			   $search_result[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' => display('medicine_search'),
				'search_result' => $search_result
			);
		$data['content']  = $this->load->view('dashboard_pharmacist/search/medicine_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	#===========Customer page load=========#
	public function customer()
	{
		$data = $this->lsearch->customer_search_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/search/customer_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	#===========Customer search============#
	public function customer_search()
	{
		$keyword = $this->input->post('what_you_search');
		$search_result = $this->Search->customer_search($keyword);

		if(!empty($search_result)){
			$i=1;
			foreach($search_result as $k=>$v){$i++;
			   $search_result[$k]['sl']=$i;
			}
		}

		$data = array(
				'title' =>display('customer_search'),
				'search_result' => $search_result
			);
		$data['content']  = $this->load->view('dashboard_pharmacist/search/customer_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	#===========Inoice page load=========#
	public function invoice()
	{
		$data = $this->lsearch->invoice_search_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/search/invoice_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	#===========Invoice search============#
	public function invoice_search()
	{
		$keyword = $this->input->post('what_you_search');
		$search_result = $this->Search->invoice_search($keyword);

		if(!empty($search_result)){
			$i=1;
			foreach($search_result as $k=>$v){$i++;
			   $search_result[$k]['sl']=$i;
			}
		}
		$currency_details = $this->Web_settings->retrieve_setting_editdata();
		$data = array(
				'title' =>display('invoice_search'),
				'search_result' => $search_result,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		//$data = $this->parser->parse('search/invoice_search',$data,true);
		$data['content']  = $this->load->view('dashboard_pharmacist/search/invoice_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	

	#===========Purchase page load=========#
	public function purchase()
	{
		$data = $this->lsearch->purchase_search_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/search/purchase_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	#===========Purchase search============#
	public function purchase_search()
	{
		$keyword = $this->input->post('what_you_search');
		$search_result = $this->Search->purchase_search($keyword);

		if(!empty($search_result)){
			$i=1;
			foreach($search_result as $k=>$v){$i++;
			   $search_result[$k]['sl']=$i;
			}
		}
		$currency_details = $this->Web_settings->retrieve_setting_editdata();
		$data = array(
				'title' =>display('purchase_search'),
				'search_result' => $search_result,
				'currency' => $currency_details[0]['currency'],
				'position' => $currency_details[0]['currency_position'],
			);
		$data['content']  = $this->load->view('dashboard_pharmacist/search/purchase_search',$data,true); 		
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
}