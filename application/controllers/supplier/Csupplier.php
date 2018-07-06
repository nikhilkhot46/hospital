<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csupplier extends CI_Controller {
	
	public $supplier_id;
	function __construct() {
        parent::__construct(); 
		$this->load->library('auth');
		$this->load->library('lsupplier');
		$this->load->library('session');
        $this->load->model('Suppliers');
        if ($this->session->userdata('isLogIn') == false 
			|| $this->session->userdata('user_role') != 1
		) 
		redirect('login'); 
    }

	public function index()
	{
		$data = $this->lsupplier->supplier_add_form();
		$data['content']  = $this->load->view('supplier/add_supplier_form',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

    //Insert supplier
    public function insert_supplier()
    {
        $data=array(
            'supplier_id'   => $this->auth->generator(20),
            'supplier_name' => $this->input->post('supplier_name'),
            'address'       => $this->input->post('address'),
            'mobile'        => $this->input->post('mobile'),
            'details'       => $this->input->post('details'),
            'status'        => 1
            );
        $supplier = $this->Suppliers->supplier_entry($data);
        if ($supplier == TRUE) {
            $this->session->set_userdata(array('message'=>display('successfully_added')));
            if(isset($_POST['add-supplier'])){
                redirect(base_url('supplier/Csupplier/manage_supplier'));
                exit;
            }elseif(isset($_POST['add-supplier-another'])){
                redirect(base_url('supplier/Csupplier'));
                exit;
            }
        }else{
            $this->session->set_userdata(array('error_message'=>display('already_exists')));
            if(isset($_POST['add-supplier'])){
                redirect(base_url('supplier/Csupplier/manage_supplier'));
                exit;
            }elseif(isset($_POST['add-supplier-another'])){
                redirect(base_url('supplier/Csupplier'));
                exit;
            }
        }
    }


	//Manage supplier
	public function manage_supplier()
	{
		#
        #pagination starts
        #
        $config["base_url"] = base_url('Csupplier/manage_supplier/');
        $config["total_rows"] = $this->Suppliers->supplier_list_count();
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
        $data['title'] = display('manage_suppiler');
        $data['suppliers_list'] =$this->Suppliers->supplier_list($links,$config["per_page"],$page);
        $data['content']  = $this->load->view('supplier/supplier',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}
	
	//Supplier Update Form
	public function supplier_update_form($supplier_id)
	{	
		$data = $this->lsupplier->supplier_edit_data($supplier_id);
	
		$data['content']  = $this->load->view('supplier/edit_supplier_form',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

	// Supplier Update
	public function supplier_update()
	{
		$supplier_id  = $this->input->post('supplier_id');
		$data=array(
			'supplier_name' => $this->input->post('supplier_name'),
			'address' 		=> $this->input->post('address'),
			'mobile' 		=> $this->input->post('mobile'),
			'details' 		=> $this->input->post('details')
			);
		$this->Suppliers->update_supplier($data,$supplier_id);
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('supplier/Csupplier/manage_supplier'));
		exit;
	}

    //Supplier Search Item
    public function supplier_search_item()
    {   
        $supplier_id = $this->input->post('supplier_id');           
        $content = $this->lsupplier->supplier_search_item($supplier_id);
        $this->template->full_admin_html_view($content);
    }

	// Supplier Delete from System
	public function supplier_delete()
	{	
		$supplier_id =  $_POST['supplier_id'];
		$this->Suppliers->delete_supplier($supplier_id);
        $this->Suppliers->delete_supplier_ledger($supplier_id);
        $this->Suppliers->delete_supplier_transection($supplier_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		return true;	
	}

	// Supplier details findings !!!!!!!!!!!!!! Inactive Now !!!!!!!!!!!!
	public function supplier_details($supplier_id)
	{	
		$data = $this->lsupplier->supplier_detail_data($supplier_id);
		$this->supplier_id=$supplier_id;
		$data['content']  = $this->load->view('supplier/supplier_details',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

    //Supplier Ledger Book
	public function	supplier_ledger()
	{
		$start=  $this->input->post('from_date');
        $end=  $this->input->post('to_date');

        $supplier_id=$this->input->post('supplier_id');
        $cat=$this->input->post('rep_cat');

        if($cat == "all")
        { 
            $url="supplier/Csupplier/supplier_ledger_report";
            redirect(base_url($url));
            exit;     
        }
        $sup_sale=$this->input->post('cat');


        if($sup_sale == "2")
        { 
            $url="supplier/Csupplier/supplier_sales_details".'/'.$supplier_id.'/'.$start.'/'.$end;
            redirect(base_url($url));
            exit;     
        }
        $sup_sale_summary=$this->input->post('cat');

        if($sup_sale_summary == "3")
        { 
            $url="supplier/Csupplier/supplier_sales_summary".'/'.$supplier_id.'/'.$start.'/'.$end;
            redirect(base_url($url));
            exit;     
        }
        $sup_sale_summary=$this->input->post('cat');

        if($sup_sale_summary == "4")
        { 
            $url="supplier/Csupplier/sales_payment_actual".'/'.$supplier_id.'/'.$start.'/'.$end;
            redirect(base_url($url));
            exit;     
        }

		$data = $this->lsupplier->supplier_ledger($supplier_id,$start,$end);
		
		$data['content']  = $this->load->view('supplier/supplier_ledger',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

    public function supplier_ledger_report()
	{
		$data = $this->lsupplier->supplier_ledger_report();
		$data['content']  = $this->load->view('supplier/supplier_ledger',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

	// Supplier wise sales report details
	public function supplier_sales_details()
	{	
		$start=  $this->input->post('from_date');
        $end=  $this->input->post('to_date');
        $supplier_id=$this->uri->segment(5);
      
        $data =$this->lsupplier->supplier_sales_details($supplier_id,$start,$end);
		$data['content']  = $this->load->view('supplier/supplier_sales_details',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}
	
	// Supplier wise sales report summary
	public function supplier_sales_summary()
	{	
		#
        #pagination starts
        #
        $supplier_id=$this->uri->segment(4);
        $config["base_url"] = base_url('supplier/Csupplier/supplier_sales_summary/'.$supplier_id."/");
        $config["total_rows"] = $this->Suppliers->supplier_sales_summary_count($supplier_id);
        $config["per_page"] = 10;
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
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $data =$this->lsupplier->supplier_sales_summary($supplier_id,$links,$config["per_page"],$page);

        $this->supplier_id=$supplier_id;
        $data['content']  = $this->load->view('supplier/supplier_sales_summary',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

	// Actual Ledger based on sales & deposited amount
	public function sales_payment_actual()
	{	
		#
        #pagination starts
        $supplier_id=$this->uri->segment(5);
       
        $config["base_url"] = base_url('supplier/Csupplier/sales_payment_actual/'.$supplier_id."/");
        $config["total_rows"] = $this->Suppliers->sales_payment_actual_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 6;
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
        $page = ($this->uri->segment(8)) ? $this->uri->segment(8) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $data =$this->lsupplier->sales_payment_actual($supplier_id,$links,$config["per_page"],$page);

        $this->supplier_id=$supplier_id;
        $data['content']  = $this->load->view('supplier/sales_payment_ledger',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}

	// search report 
	 public function search_supplier_report()
    {
        $start=  $this->input->post('from_date');
        $end=  $this->input->post('to_date');

        $content = $this->lpayment->result_datewise_data($start,$end);
        $this->template->full_admin_html_view($content);
    }

    //Supplier sales details all from menu
    public function supplier_sales_details_all()
    {   
        $config["base_url"] = base_url('supplier/Csupplier/supplier_sales_details_all/');
        $config["total_rows"] = $this->Suppliers->supplier_sales_details_count_all();
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
        $data =$this->lsupplier->supplier_sales_details_allm($links,$config["per_page"],$page);
        $data['content']  = $this->load->view('supplier/supplier_sales_details',$data,true);
        $this->load->view('layout/main_wrapper',$data);
        //$this->template->full_admin_html_view($content);
    }
    
    // supplier ledger for supplier information 
    public function supplier_ledger_info($supplier_id)
    {
        $data = $this->lsupplier->supplier_ledger_info($supplier_id);
        $this->supplier_id=$supplier_id;
        $data['content']  = $this->load->view('supplier/supplier_ledger',$data,true);
        $this->load->view('layout/main_wrapper',$data);
        
    }
}