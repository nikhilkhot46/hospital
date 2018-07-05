<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->library('auth');
        $this->load->model('purchase_manager/item_model');
        if ($this->session->userdata('isLogIn') == false
            || $this->session->userdata('user_role') != 1
        ) {
            redirect('login');
        }
    }

    // List all your items
    public function index( $offset = 0 )
    {
        $data['title'] = display('test_list');
        #-------------------------------#
        $data['items'] = $this->item_model->read_item();
        $data['content'] = $this->load->view('purchase_manager/item_view', $data, true);
        $this->load->view('layout/main_wrapper', $data);
    }

    // Add a new item
    public function add($id = null)
    {
        $this->form_validation->set_rules('item_name', display('item_name'), 'required|max_length[100]');
        $this->form_validation->set_rules('item_desc', display('item_desc'), 'required|trim|max_length[250]');
        /*-------------STORE DATA------------*/
        $data['item'] = (object) $postData = array(
            'item_id' => $this->input->post('item_id', true),
            'item_name' => $this->input->post('item_name', true),
            'item_desc' => $this->input->post('item_desc', true)
        );

        /*-----------CHECK ID -----------*/
        if (empty($id)) {
            /*-----------CREATE A NEW RECORD-----------*/
            if ($this->form_validation->run() === true) {
                $postData['item_id'] = "II".$this->auth->randStrGen(1,8);
                if ($this->item_model->create_item($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('purchase_manager/item/add');
            } else {
                $data['title'] = display('add_item');
                $data['content'] = $this->load->view('purchase_manager/item_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        } else {
            /*-----------UPDATE A RECORD-----------*/
            if ($this->form_validation->run() === true) {
                if ($this->item_model->update_item($postData)) {
                    #set success message
                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }
                redirect('purchase_manager/item/add/' . $postData['item_id']);
            } else {
                $data['title'] = display('item_edit');
                $data['item'] = $this->item_model->read_by_item_id($id);
                $data['content'] = $this->load->view('purchase_manager/item_form', $data, true);
                $this->load->view('layout/main_wrapper', $data);
            }
        }
    }

    public function purchase()
	{	
		$this->load->library('lpurchase');
        $data = $this->lpurchase->purchase_add_form();
		$data['content']  = $this->load->view('purchase_manager/add_purchase_form',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }
    
    public function product_search()
    {
        $item_name = $this->input->post('item_name');
        $query=$this->db->select('*')
				->from('item')
				->like('item_name', $item_name, 'both')
				->get();
		if ($query->num_rows() > 0) {
            $product_info = $query->result_array();	
            $list[''] = '';
            foreach ($product_info as $value) {
                $json_product[] = array('label'=>$value['item_name'],'value'=>$value['item_id']);
            } 
            echo json_encode($json_product);
		}
		return false;
    }

    public function get_total_product(){
        
        $product_id = $this->input->post('product_id');
        $supplier_id= $this->input->post('supplier_id');
        
		$this->db->select('SUM(a.quantity) as total_purchase');
		$this->db->from('item_purchase_details a');
		$this->db->where('a.item_id',$product_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.product_id',$product_id);
		$total_sale = $this->db->get()->row();

		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

		$CI =& get_instance();
		$CI->load->model('Setting_model');
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();
		
		$data2 = array(
			'total_product'  => $available_quantity, 
			'supplier_price' => 0//$product_information->supplier_price
			);

            echo json_encode( $data2);
    }
    
    public function insert_purchase()
	{
		$CI =& get_instance();
		$CI->load->model('Purchases');
		$CI->Purchases->item_purchase_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-purchase'])){
			redirect(base_url('purchase_manager/item/manage_purchase'));
			exit;
		}elseif(isset($_POST['add-purchase-another'])){
			redirect(base_url('purchase/item/purchase'));
			exit;
		}
    }
    
    public function manage_purchase()
	{
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$CI->load->model('Purchases');

		#
        #pagination starts
        #
        $config["base_url"] = base_url('purchase_manager/item/manage_purchase/');
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
        $data =$this->lpurchase->item_purchase_list($links,$config["per_page"],$page);
		$data['content']  = $this->load->view('purchase_manager/purchase',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }
    
    public function purchase_details_data($purchase_id)
	{	
		$CI =& get_instance();
		$CI->load->library('lpurchase');
        $data = $CI->lpurchase->item_purchase_details_data($purchase_id);
		$data['content']  = $this->load->view('purchase_manager/purchase_detail',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }
    
    public function item_details($product_id)
	{
		$this->load->library('lproduct');	
		$data = $this->lproduct->item_details($product_id);
		$data['content']  = $this->load->view('purchase_manager/item_details',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }
    
    public function purchase_update_form($purchase_id)
	{	
		$CI =& get_instance();
		$CI->load->library('lpurchase');
		$data = $CI->lpurchase->item_purchase_edit_data($purchase_id);
		$data['content']  = $this->load->view('purchase_manager/edit_purchase_form',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }
    
    public function purchase_update()
	{
		$this->load->model('Purchases');
		$this->Purchases->update_purchase_item();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		redirect(base_url('purchase_manager/item/manage_purchase'));
		exit;
    }
    public function delete_purchase($purchase_id = null) 
    { 
          $this->load->model('Purchases');
        if ($this->Purchases->purchase_delete_item($purchase_id)) {
            #set success message
            $this->session->set_flashdata('message',display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception',display('please_try_again'));

        }
        redirect(base_url('purchase_manager/item/manage_purchase'));
    }

    public function manage_purchase_date_to_date()
	{
		$this->load->library('lpurchase');
		$this->load->model('Purchases');
        $start=  $this->input->post('from_date');
        $end=  $this->input->post('to_date');

        $data =$this->lpurchase->item_purchase_list_date_to_date($start,$end);
		$data['content']  = $this->load->view('purchase_manager/purchase',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }
    
    public function purchase_info_id(){
        $this->load->library('lpurchase');
		$this->load->model('Purchases');
	    $invoice_no = $this->input->post('invoice_no');
	    $data = $this->lpurchase->item_purchase_list_invoice_no($invoice_no);
		$data['content']  = $this->load->view('purchase_manager/purchase',$data,true);
        $this->load->view('layout/main_wrapper',$data);
	}
}
/* End of file Item.php */