<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cinvoice extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
            'dashboard_pharmacist/Invoices',
            'Setting_model','patient_model','dashboard_pharmacist/Products'
            
		));
        
        if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 6
        ) 
        redirect('login'); 
    }
    public function index()
	{
		$CI =& get_instance();
		$CI->load->library('linvoice');
		$data = $CI->linvoice->invoice_add_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/invoice/add_invoice_form',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	//Insert invoice
	public function insert_invoice()
	{
		$CI =& get_instance();
		$invoice_id = $this->Invoices->invoice_entry();
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		$this->invoice_inserted_data($invoice_id);
	}

	//invoice Update Form
public function invoice_update_form($invoice_id)
	{	
		$CI =& get_instance();
		$CI->load->library('linvoice');
		$data = $CI->linvoice->invoice_edit_data($invoice_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/invoice/edit_invoice_form',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	
	// invoice Update
	public function invoice_update()
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$invoice_id = $CI->Invoices->update_invoice();
		$this->session->set_userdata(array('message'=>display('successfully_updated')));
		$this->invoice_inserted_data($invoice_id);
	}
	//Search Inovoice Item
	public function search_inovoice_item()
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('linvoice');
		
		$customer_id = $this->input->post('customer_id');
        $content = $CI->linvoice->search_inovoice_item($customer_id);
		$this->template->full_admin_html_view($content);
	}
	//Manage invoice list
	public function manage_invoice()
	{	
		$CI =& get_instance();
		$CI->load->library('linvoice');
		
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/invoice/Cinvoice/manage_invoice/');
        $config["total_rows"] = $this->Invoices->invoice_list_count();
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
		$data =$this->linvoice->invoice_list($links,$config["per_page"],$page);
		$data['content']  = $this->load->view('dashboard_pharmacist/invoice/invoice',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
		//$this->template->full_admin_html_view($content);
	}
	// search invoice by invoice id
		public function manage_invoice_invoice_id()
	{	
		$CI =& get_instance();
		$CI->load->library('linvoice');
        $invoice_no = $this->input->post('invoice_no');
        $data =$this->linvoice->invoice_list_invoice_no($invoice_no);
		$data['content']  = $this->load->view('dashboard_pharmacist/invoice/invoice',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	// invoice list date to date 
	public function date_to_date_invoice()
	{	
		$CI =& get_instance();
		$CI->load->library('linvoice');
		$CI->load->model('dashboard_pharmacist/Invoices');

		#
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/invoice/Cinvoice/date_to_date_invoice/');
        $config["total_rows"] = $this->Invoices->invoice_list_count();
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
        $from_date = $this->input->post('from_date');       
		$to_date = $this->input->post('to_date');
		//echo date('Y-m-d', strtotime($from_date))." and ".date('Y-m-d', strtotime($to_date));
        $data =$this->linvoice->invoice_list_date_to_date(date('Y-m-d', strtotime($from_date)),date('Y-m-d', strtotime($to_date)),$links,$config["per_page"],$page);
		$data['content']  = $this->load->view('dashboard_pharmacist/invoice/invoice',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	//POS invoice page load
	public function pos_invoice(){
		
		redirect('dashboard_pharmacist/invoice/Cinvoice');
		
		$CI =& get_instance();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->pos_invoice_add_form();
		$this->template->full_admin_html_view($content);
	}

	//Insert pos invoice
public function insert_pos_invoice()
	{
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$CI->load->model('Setting_model');
		$CI->load->model('Products');
		$product_id = $this->input->post('product_id');
		
		$product_details = $CI->Invoices->pos_invoice_setup($product_id);
		$batch = $CI->Products->batch_search_item($product_id);
		$currency_details = $CI->Setting_model->retrieve_setting_editdata();

		$tr = " ";
		if (!empty($product_details)){
			$product_id = $this->generator(5);

			//Batch id retrive from database
			$html = "";
	        if (empty($batch)) {
	        	$html .="No Product Found !";
		    }else{
		    	// Select option created for product
		        $html .="<select name=\"batch_id[]\"   class=\"batch_id_".$product_id." form-control\" id=\"batch_id_".$product_id."\" required=\"required\" onchange=\"product_stock(".$product_id.")\">";
		        	$html .= "<option>".display('select_one')."</option>";
		        	foreach ($batch as $product) {
		    			$html .="<option value=".$product['batch_id'].">".$product['batch_id']."</option>";
		        	}	
		        $html .="</select>";
		    }

			$tr .= "<tr id=\"row_".$product_id."\">
						<td class=\"\" style=\"width:220px\">
							
							<input type=\"text\" name=\"product_name\" onkeypress=\"invoice_productList(".$product_id.");\" class=\"form-control productSelection \" value='".$product_details->product_name."- (".$product_details->product_model.")"."' placeholder='".display('product_name')."' required=\"\" id=\"product_name\" tabindex=\"\" >

							<input type=\"hidden\" class=\"form-control autocomplete_hidden_value product_id_".$product_id."\" name=\"product_id[]\" id=\"SchoolHiddenId\" value = \"$product_details->product_id\" id=\"product_id\"/>
						</td>
						<td>$html</td>
						<td>
                            <input type=\"text\" name=\"available_quantity[]\" class=\"form-control text-right available_quantity_".$product_id."\" value=\"0\" readonly=\"\" id=\"available_quantity_".$product_id."\"/>
                        </td>

                        <td  id=\"expire_date_".$product_id."\"> </td>
                    
                        <td>
                         <input class=\"form-control text-right unit_".$product_id."\" valid\" value='".$product_details->unit."' aria-invalid=\"false\" type=\"text\" readonly=\"readonly\">
                        </td>

						<td style=\"width:85px\">
							<input type=\"text\" name=\"product_quantity[]\" onkeyup=\"quantity_calculate(".$product_id.");\" onchange=\"quantity_calculate(".$product_id.");\" class=\"total_qntt_".$product_id." form-control text-right\" id=\"total_qntt_".$product_id."\" placeholder=\"0.00\" min=\"0\" tabindex=\"8\" />
						</td>

						<td>
							 <input type=\"text\" name=\"product_rate[]\" id=\"price_item_".$product_id."\" class=\"price_item1 price_item form-control text-right\" tabindex=\"9\" required=\"\" onkeyup=\"quantity_calculate(".$product_id.");\" onchange=\"quantity_calculate(".$product_id.");\" value='".$product_details->price."' placeholder=\"0.00\" min=\"0\" />
						</td>

						<td>
						 	<input type=\"text\" name=\"discount[]\" onkeyup=\"quantity_calculate(".$product_id.");\"  onchange=\"quantity_calculate(".$product_id.");\" id=\"discount_".$product_id."\" class=\"form-control text-right\" min=\"0\" tabindex=\"10\" placeholder=\"0.00\"/>

                               <input type=\"hidden\" value=\"".$currency_details[0]['discount_type']."\" name=\"discount_type\" id=\"discount_type_".$product_id."\">
						</td>
						<td class=\"text-right\" style=\"width:100px\">
							 <input class=\"total_price form-control text-right\" type=\"text\" name=\"total_price[]\" id=\"total_price_".$product_id."\" value=\"0.00\" readonly=\"readonly\" />
						</td>

						<td>
                           <input type=\"hidden\" id=\"total_tax_".$product_id."\" class=\"total_tax_1\" value='".$product_details->tax."'/>
                            <input type=\"hidden\" id=\"all_tax_".$product_id."\" class=\" total_tax\" value=\"\" name=\"tax[]\"/>
                            
                            <input type=\"hidden\" id=\"total_discount_".$product_id."\" class=\"\" />
                            <input type=\"hidden\" id=\"all_discount_".$product_id."\" class=\"total_discount\"/>

                            <button style=\"text-align: right;\" class=\"btn btn-danger\" type=\"button\" value='".display('delete')."' onclick=\"deleteRow(this)\">".display('delete')."</button>
						</td>
					</tr>";
			echo $tr;

		}else{
			return false;
		}
	}

	//Retrive right now inserted data to cretae html
	public function invoice_inserted_data($invoice_id)
	{	
		$CI =& get_instance();
		$CI->load->library('linvoice');
		$data = $CI->linvoice->invoice_html_data($invoice_id);		
		$data['content']  = $this->load->view('dashboard_pharmacist/invoice/invoice_html',$data,true);
		$this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	//Retrive right now inserted data to cretae html
	public function pos_invoice_inserted_data($invoice_id)
	{	
		$CI =& get_instance();
		$CI->auth->check_admin_auth();
		$CI->load->library('linvoice');
		$content = $CI->linvoice->pos_invoice_html_data($invoice_id);		
		$this->template->full_admin_html_view($content);
	}

	// Retrieve_product_data
	public function retrieve_product_data()
	{	
		$CI =& get_instance();
		$CI->load->model('Invoices');
		$product_id = $this->input->post('product_id');
		$supplier_id= $this->input->post('supplier_id');
        //$product_id= "21199635";
        //$supplier_id = "TH8OE5ZIAARA4MVH2I51";
		$product_info = $CI->Invoices->get_total_product($product_id,$supplier_id);

		echo json_encode($product_info);
	}
	//available qty by batch id
	public function retrieve_product_batchid()
	{	
		$CI =& get_instance();
		$batch_id = $this->input->post('batch_id');
		$product_info = $CI->Invoices->get_total_product_batch($batch_id);
		echo json_encode($product_info);
	}
	//product info retrive by product id for invoice
	public function retrieve_product_data_inv()
	{	
		$CI =& get_instance();
		$product_id = $this->input->post('product_id');
		$product_info = $CI->Invoices->get_total_product_invoic($product_id);
		echo json_encode($product_info);
	}
	// Invoice delete
	public function invoice_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');
		$invoice_id =  $_POST['invoice_id'];
		$result = $CI->Invoices->delete_invoice($invoice_id);
		if ($result) {
			$this->session->set_userdata(array('message'=>display('successfully_delete')));
			return true;
		}	
	}
	
	//AJAX INVOICE STOCKs
	public function product_stock_check($product_id)
	{
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('Invoices');
		//$product_id =  $this->input->post('product_id');

		$purchase_stocks = $CI->Invoices->get_total_purchase_item($product_id);	
		$total_purchase = 0;		
		if(!empty($purchase_stocks)){	
			foreach($purchase_stocks as $k=>$v){
				$total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
			}
		}
		$sales_stocks = $CI->Invoices->get_total_sales_item($product_id);
		$total_sales = 0;	
		if(!empty($sales_stocks)){	
			foreach($sales_stocks as $k=>$v){
				$total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
			}
		}
		
		$final_total = ($total_purchase - $total_sales);
		return $final_total ;
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("1","2","3","4","5","6","7","8","9");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,8);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}
}