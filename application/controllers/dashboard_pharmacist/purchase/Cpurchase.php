<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cpurchase extends CI_Controller {
	
	function __construct() {
		  parent::__construct();
		  if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 6
        ) 
        redirect('login'); 
    }

	public function index()
	{	
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$data = $CI->lpurchase->purchase_add_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/purchase/add_purchase_form',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	//Manage purchase
	public function manage_purchase()
	{
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$CI->load->model('Purchases');

		#
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/purchase/Cpurchase/manage_purchase/');
        $config["total_rows"] = $this->Purchases->count_purchase();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
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
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $data =$this->lpurchase->purchase_list($links,$config["per_page"],$page);
		$data['content']  = $this->load->view('dashboard_pharmacist/purchase/purchase',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
//purchase list by invoice no
    public function purchase_info_id(){
        $CI =& get_instance();
		$CI->load->library('lpurchase');
		$CI->load->model('Purchases');
	    $invoice_no = $this->input->post('invoice_no');
	    $data = $this->lpurchase->purchase_list_invoice_no($invoice_no);
		$data['content']  = $this->load->view('dashboard_pharmacist/purchase/purchase',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	//Insert purchase
	public function insert_purchase()
	{
		$CI =& get_instance();
		$CI->load->model('Purchases');
		$CI->Purchases->purchase_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-purchase'])){
			redirect(base_url('dashboard_pharmacist/purchase/Cpurchase/manage_purchase'));
			exit;
		}elseif(isset($_POST['add-purchase-another'])){
			redirect(base_url('dashboard_pharmacist/purchase/Cpurchase'));
			exit;
		}
	}

	//purchase Update Form
	public function purchase_update_form($purchase_id)
	{	
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$data = $CI->lpurchase->purchase_edit_data($purchase_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/purchase/edit_purchase_form',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	// purchase Update
	public function purchase_update()
	{
	
		$CI =& get_instance();
		$CI->load->model('Purchases');
		$CI->Purchases->update_purchase();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('dashboard_pharmacist/purchase/Cpurchase/manage_purchase'));
		exit;
	}

	
	//Purchase item by search
	public function purchase_item_by_search()
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$supplier_id = $this->input->post('supplier_id');			
        $content = $CI->lpurchase->purchase_by_search($supplier_id);
		$this->template->full_admin_html_view($content);
	}
	
	//Product search by supplier id
public function product_search_by_supplier(){


		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$CI->load->model('Suppliers');
		$supplier_id 	= $this->input->post('supplier_id');
		$product_name 	= $this->input->post('product_name');
        $product_info 	= $CI->Suppliers->product_search_item($supplier_id,$product_name);

		$list[''] = '';
		foreach ($product_info as $value) {
			$json_product[] = array('label'=>$value['product_name'].'('.$value['product_model'].')','value'=>$value['product_id']);
		} 
        echo json_encode($json_product);
	}

	//Retrive right now inserted data to cretae html
	public function purchase_details_data($purchase_id)
	{	
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$data = $CI->lpurchase->purchase_details_data($purchase_id);	
		$data['content']  = $this->load->view($data['view'],$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	public function delete_purchase($purchase_id = null) 
    { 
          $this->load->model('Purchases');
        if ($this->Purchases->purchase_delete($purchase_id)) {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));

        }
        redirect(base_url('dashboard_pharmacist/purchase/Cpurchase/manage_purchase'));
    }
    // purchase info date to date
    public function manage_purchase_date_to_date()
	{
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$CI->load->model('Purchases');
        $start=  $this->input->post('from_date');
        $end=  $this->input->post('to_date');

        $data =$this->lpurchase->purchase_list_date_to_date($start,$end);
		$data['content']  = $this->load->view('dashboard_pharmacist/purchase/purchase',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	// search batch id 
	public function batch_search_by_product(){

		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lpurchase');
		$CI->load->model('Products');
		$product_id = $this->input->post('product_id');	
		
        $content = $CI->Products->batch_search_item($product_id);

        if (empty($content)) {
        	echo "No Product Found !";
	    }else{
	    	// Select option created for product
	        echo "<select name=\"batch_id[]\"   class=\"batch_id_1 form-control\" id=\"batch_id_1\">";
	        	echo "<option value=\"0\">".display('select_one')."</option>";
	        	foreach ($content as $product) {
	    			echo "<option value=".$product['batch_id'].">";
	    			echo $product['batch_id'];
	    			echo "</option>"; 
	        	}	
	        echo "</select>";
	    }
	}
}