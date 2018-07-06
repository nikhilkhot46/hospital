<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cretrun_m extends CI_Controller {
    public $menu;
    function __construct() {
      parent::__construct();
        $this->load->library('auth');
        $this->load->library('lreturn');
        $this->load->library('linvoice');
        $this->load->model('dashboard_pharmacist/Returnse');
        if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 6
        ) 
        redirect('login'); 
      
    }
    public function index(){

        $data = $this->lreturn->return_form();
        $data['content']  = $this->load->view('dashboard_pharmacist/return/form',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
    // invoice return form
    public function invoice_return_form()
    {   $invoice_id=$this->input->post('invoice_id');
       $query = $this->db->select('invoice_id')->from('invoice')->where('invoice_id',$invoice_id)->get();
    

        if ($query->num_rows() == 0) {
             $this->session->set_userdata(array('error_message'=>display('please_input_correct_invoice_id')));
               redirect('dashboard_pharmacist/return/Cretrun_m');
        }
        $CI =& get_instance();
        $data = $CI->lreturn->invoice_return_data($invoice_id);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_data_form',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
// supplier return form
     public function supplier_return_form()
    {   
        $purchase_id=$this->input->post('purchase_id');
        $query = $this->db->select('purchase_id')->from('product_purchase')->where('purchase_id',$purchase_id)->get();
    

        if ($query->num_rows() == 0) {
             $this->session->set_userdata(array('error_message'=>display('please_input_correct_purchase_id')));
               redirect('dashboard_pharmacist/return/Cretrun_m');
        }
        $CI =& get_instance();
        
        $CI->load->library('lreturn');
        $data = $CI->lreturn->supplier_return_data($purchase_id);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/supplier_return_form',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
    public function return_invoice()
    {
        $CI =& get_instance();
        $invoice_id = $CI->Returnse->return_invoice_entry();
        $this->session->set_userdata(array('message'=>display('successfully_added')));
        $this->invoice_inserted_data($invoice_id);

    }
    // return supplier insert  start
    public function return_suppliers()
    {
        $CI =& get_instance();
        $purchase_id = $CI->Returnse->return_supplier_entry();
        $this->session->set_userdata(array('message'=>display('successfully_added')));
        $this->supplier_inserted_data($purchase_id);

    }
    // supplier inserted  data
    public function supplier_inserted_data($purchase_id)
    {   
        $CI =& get_instance();
        $CI->load->library('lreturn');
        $data = $CI->lreturn->supplier_html_data($purchase_id);        
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_supplier_html',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
    // return list start
    public function return_list()
    {   
        $CI =& get_instance();
        $CI->load->library('lreturn');
        
        #
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/return/Cretrun_m/return_list/');
        $config["total_rows"] = $this->Returnse->return_list_count();
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
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $data =$this->lreturn->return_list($links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_list',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }

// date between return report list
    public function datewise_invoic_return_list(){
        $CI =& get_instance();
        $CI->load->library('lreturn');
        $CI->load->model('Returnse');
         $config["base_url"] = base_url('dashboard_pharmacist/return/Cretrun_m/return_list/');
        $config["total_rows"] = $this->Returnse->return_list_count();
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
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $links = $this->pagination->create_links();
        $from_date = $this->input->post('from_date');       
        $to_date = $this->input->post('to_date');
        $data = $CI->lreturn->return_list_datebetween($from_date,$to_date,$links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_list',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
    public function supplier_return_list()
    {   
        $CI =& get_instance();
        $CI->load->library('lreturn');
        #
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/return/Cretrun_m/supplier_return_list/');
        $config["total_rows"] = $this->Returnse->supplier_return_list_count();
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
        $data =$this->lreturn->supplier_return_list($links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_supllier_list',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
// wastage return list start
    public function wastage_return_list()
    {   
        $CI =& get_instance();
        $CI->load->library('lreturn');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/return/Cretrun_m/wastage_return_list/');
        $config["total_rows"] = $this->Returnse->wastage_return_list_count();
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
        $data =$this->lreturn->wastage_return_list($links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_list',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
    //wastage return list end
    public function invoice_inserted_data($invoice_id)
    {   
        $CI =& get_instance();
        $CI->load->library('lreturn');
        $data = $CI->lreturn->invoice_html_data($invoice_id);        
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_invoice_html',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }

// Return delete with invoice id
    public function delete_retutn_invoice($invoice_id = null) 
    { 
          $this->load->model('Returnse');
        if ($this->Returnse->returninvoice_delete($invoice_id)) {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));

        }
        redirect("Cretrun_m/return_list");
    }
    // return delete with purchase id 
     public function delete_retutn_purchase($purchase_id = null) 
    { 
          $this->load->model('Returnse');
        if ($this->Returnse->return_purchase_delete($purchase_id)) {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));

        }
        redirect("Cretrun_m/supplier_return_list");
    }
    // date wise supplier return list
     public function datebwteen_supplier_return_list()
    {   
        $CI =& get_instance();
        $CI->load->library('lreturn');
        $CI->load->model('Returnse');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/return/Cretrun_m/supplier_return_list/');
        $config["total_rows"] = $this->Returnse->supplier_return_list_count();
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
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $links = $this->pagination->create_links();
       $from_date = $this->input->post('from_date');       
        $to_date = $this->input->post('to_date');
        $data =$this->lreturn->datewise_supplier_return_list($from_date,$to_date,$links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/return/return_supllier_list',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
    }
}