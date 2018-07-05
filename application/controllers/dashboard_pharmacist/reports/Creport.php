<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Creport extends CI_Controller {
	
	function __construct() {
     	parent::__construct();
      	
        $this->load->model('Setting_model','Web_settings');
        $this->load->library('lreport');
        if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 6
        ) 
        redirect('login'); 
    }
	public function index()
	{
		$today = date('Y-m-d');
		$product_id = $this->input->post('product_id')?$this->input->post('product_id'):"";	
		$date=$this->input->post('stock_date')?$this->input->post('stock_date'):$today;
		$limit=15;
		$start_record=($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		$date=($this->uri->segment(7)) ? $this->uri->segment(7) : $date;
		$link=$this->pagination($limit,"dashboard_pharmacist/reports/Creport/index/$date");	
        $data = $this->lreport->stock_report_single_item($product_id,$date,$limit,$start_record,$link);

        $data['content']  = $this->load->view('dashboard_pharmacist/reports/stock_report',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	
	public function out_of_stock(){
		$CI =& get_instance();
		
		

		$content = $CI->lreport->out_of_stock();
        
		$this->template->full_admin_html_view($content);
	}
	// Date Expire Medicine list
	public function out_of_date(){
		$CI =& get_instance();
		$content = $CI->lreport->out_of_date();
		$this->template->full_admin_html_view($content);
	}

	//Stock report supplir report
	public function stock_report_supplier_wise(){
		$CI =& get_instance();
		
			
		$CI->load->model('Reports');
		$today = date('Y-m-d');

		$product_id = $this->input->post('product_id')?$this->input->post('product_id'):"";	
		$supplier_id = $this->input->post('supplier_id')?$this->input->post('supplier_id'):"";

		$date=$this->input->post('stock_date')?$this->input->post('stock_date'):$today;
		//print_r($date);exit;

		#
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/reports/Creport/stock_report_supplier_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_supplier($supplier_id);	
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
        $data =$this->lreport->stock_report_supplier_wise($product_id,$supplier_id,$date,$links,$config["per_page"],$page);

        $data['content']  = $this->load->view('dashboard_pharmacist/reports/stock_report_supplier_wise',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
// supplier stock report supplier id wise
	public function stock_report_supplier_id_wise(){
		$CI =& get_instance();
		
			
		$CI->load->model('Reports');
		$supplier_id = $this->input->post('supplier_id');

		$date=$this->input->post('stock_date');
		//print_r($date);exit;

		#
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/reports/Creport/stock_report_supplier_id_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_supplier($supplier_id);	
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
        $data =$this->lreport->stock_report_supplier_id_wise($supplier_id,$date,$links,$config["per_page"],$page);
		$data['content']  = $this->load->view('dashboard_pharmacist/reports/stock_report_supplier_wise',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	//Stock report supplir report
	public function stock_report_product_wise(){
        
        $this->load->model('Reports');
		$today = date('Y-m-d');

		$product_id = $this->input->post('product_id')?$this->input->post('product_id'):"";	
		$supplier_id = $this->input->post('supplier_id')?$this->input->post('supplier_id'):"";
		$from_date=$this->input->post('from_date');	
		$to_date=$this->input->post('to_date')?$this->input->post('to_date'):$today;
		
		#
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/reports/Creport/stock_report_product_wise/');
        $config["total_rows"] = $this->Reports->stock_report_product_bydate_count($supplier_id,$supplier_id,$from_date,$to_date);	
       
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
        $data =$this->lreport->stock_report_product_wise($product_id,$supplier_id,$from_date,$to_date,$links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/reports/stock_report_product_wise',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
		//$this->template->full_admin_html_view($content);
	}

	//Get product by supplier
	public function get_product_by_supplier(){
		$supplier_id = $this->input->post('supplier_id');

		$product_info_by_supplier = $this->db->select('a.*,b.*')
											->from('product_information a')
											->join('supplier_product b','a.product_id=b.product_id')
											->where('b.supplier_id',$supplier_id)
											->get()
											->result();

		if ($product_info_by_supplier) {
			echo "<select class=\"form-control\" id=\"supplier_id\" name=\"supplier_id\">
	                <option value=\"\">".display('select_one')."</option>";
			foreach ($product_info_by_supplier as $product) {
				echo "<option value='".$product->product_id."'>".$product->product_name.'-('.$product->product_model.')'." </option>";
			}
			echo " </select>";
		}

	}


	#===============Report paggination=============#
	public function pagination($per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$product_id=$this->input->post('product_id');	
		
		$config = array();
		$config["base_url"] = base_url().$page;
		$config["total_rows"] = $this->Reports->product_counter($product_id);
		$config["per_page"] = $per_page;
		$config["uri_segment"] = 4;	
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



		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$limit = $config["per_page"];
	    return $links = $this->pagination->create_links();	
	}
	// stock report batch id wise
	public function stock_report_batch_wise(){
		$CI =& get_instance();
		
			
		$CI->load->model('Reports');
        $config["base_url"] = base_url('dashboard_pharmacist/reports/Creport/stock_report_batch_wise/');
        $config["total_rows"] = $this->Reports->stock_report_batch_count();	
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
        $data =$this->lreport->stock_report_batch_wise($links,$config["per_page"],$page);
        $data['content']  = $this->load->view('dashboard_pharmacist/reports/stock_report_batch_wise',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	// batch stock reoport by Medicine name
	public function product_stock_batchwise_by_name(){
		
        $product_id=$this->input->post('product_id');
		$data = $this->lreport->stock_report_batch_productname($product_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/reports/stock_report_batch_wise',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
		

	} 
	
}