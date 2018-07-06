<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cproduct extends CI_Controller {
	
	public $product_id;
	function __construct() {
	  parent::__construct();
	  if ($this->session->userdata('isLogIn') == false 
            || $this->session->userdata('user_role') != 6
        ) 
        redirect('login'); 
    }

    //Index page load
	public function index()
	{	
		$CI =& get_instance();
		$CI->load->library('lproduct');
		$data = $CI->lproduct->product_add_form();
		$data['content']  = $this->load->view('dashboard_pharmacist/product/add_product_form',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}

	//Insert Product and uload
	public function insert_product()
	{
		$CI =& get_instance();
		$CI->load->library('lproduct');
		$product_id=$this->generator(8);
		$sup_price = $this->input->post('supplier_price');
		$s_id = $this->input->post('supplier_id');
		$product_model=$this->input->post('model');
		for ($i=0, $n=count($s_id); $i < $n; $i++) {
			$supplier_price = $sup_price[$i];
			$supp_id = $s_id[$i];
			
			$supp_prd = array(
				'product_id'			=>	$product_id,
				'supplier_id'			=>  $supp_id,
				'supplier_price'		=>	$supplier_price,
				'products_model'        =>  $product_model=$this->input->post('model')
				
			);
		
			$this->db->insert('supplier_product',$supp_prd);
		}

		//Supplier check
		if ($this->input->post('supplier_id') == null) {
			$this->session->set_userdata(array('error_message'=>display('please_select_supplier')));
			redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct'));
		}

		if ($_FILES['image']['name']) {
			//Chapter chapter add start
			$config['upload_path']          = './my-assets/image/product/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
	        $config['max_size']             = "*";
	        $config['max_width']            = "*";
	        $config['max_height']           = "*";
	        $config['encrypt_name'] 		= TRUE;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('image'))
	        {
	            $error = array('error' => $this->upload->display_errors());
	            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
	            redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct'));
	        }
	        else
	        {
	        	$image =$this->upload->data();
	        	$image_url = base_url()."my-assets/image/product/".$image['file_name'];
	        }
		}

		$price = $this->input->post('price');
		$tax_percentage = $this->input->post('tax');
		$tax = $tax_percentage/100;

		$data=array(
			'product_id' 			=> $product_id,
			'product_name' 			=> $this->input->post('product_name'),
			'generic_name' 			=> $this->input->post('generic_name'),
			'box_size' 				=> $this->input->post('box_size'),
			'unit' 					=> $this->input->post('unit'),
			
			'product_location' 		=> $this->input->post('product_location'),
			'category_id' 			=> $this->input->post('category_id'),
			'unit' 					=> $this->input->post('unit'),
			'tax' 					=> $tax,
			'price' 				=> $price,
			//'supplier_price' 		=> $this->input->post('supplier_price'),
			'product_model' 		=> $this->input->post('model'),
			'product_details' 		=> $this->input->post('description'),
			'image' 				=> (!empty($image_url)?$image_url:base_url('my-assets/image/product.png')),
			'status' 				=> 1
			);

		$result=$CI->lproduct->insert_product($data);


			
			
				
		if ($result == 1) {
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			if(isset($_POST['add-product'])){
				redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product'));
				exit;
			}elseif(isset($_POST['add-product-another'])){
				redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct'));
				exit;
			}
		}else{
			$this->session->set_userdata(array('error_message'=>display('product_model_already_exist')));
			redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct'));
		}
	}
	//Product Update Form
	public function product_update_form($product_id)
	{	
		$CI =& get_instance();
		
		$CI->load->library('lproduct');
		$data = $CI->lproduct->product_edit_data($product_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/product/edit_product_form',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	// Product Update
	public function product_update()
	{
		$CI =& get_instance();
		
		$CI->load->model('dashboard_pharmacist/Products');

		$product_id  = $this->input->post('product_id');
        $this->db->where('product_id',$product_id);
		$this->db->delete('supplier_product');
		$sup_price = $this->input->post('supplier_price');
		$s_id = $this->input->post('supplier_id');
		for ($i=0, $n=count($s_id); $i < $n; $i++) {
			$supplier_price = $sup_price[$i];
			$supp_id = $s_id[$i];
			
			$supp_prd = array(
				'product_id'			=>	$product_id,
				'supplier_id'			=>  $supp_id,
				'supplier_price'		=>	$supplier_price
				
			);
		
			$this->db->insert('supplier_product',$supp_prd);
		}
		if ($_FILES['image']['name']) {
			//Chapter chapter add start
			$config['upload_path']          = './my-assets/image/product/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
	        $config['max_size']             = "*";
	        $config['max_width']            = "*";
	        $config['max_height']           = "*";
	        $config['encrypt_name'] 		= TRUE;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('image'))
	        {
	            $error = array('error' => $this->upload->display_errors());
	            $this->session->set_userdata(array('error_message'=> $this->upload->display_errors()));
	            redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct'));
	        }
	        else
	        {
	        	$image =$this->upload->data();
	        	$old_image = $this->input->post('old_image');
	        	$image_url = base_url()."my-assets/image/product/".$image['file_name'];
	        }
		}

		$price = $this->input->post('price');
		$tax_percentage = $this->input->post('tax');
		$tax = $tax_percentage/100;

		$data=array(
			'product_name' 			=> $this->input->post('product_name'),
			'generic_name' 			=> $this->input->post('generic_name'),
			'box_size' 				=> $this->input->post('box_size'),
			'unit' 					=> $this->input->post('unit'),
			'product_location' 		=> $this->input->post('product_location'),
			'category_id' 			=> $this->input->post('category_id'),
			'price' 				=> $price,
			//'supplier_price' 		=> $this->input->post('supplier_price'),
			'product_model' 		=> $this->input->post('model'),
			'product_details' 		=> $this->input->post('description'),
			'unit' 					=> $this->input->post('unit'),
			'tax' 					=> $tax,
			'image' 				=> (!empty($image_url)?$image_url:base_url('my-assets/image/product.png')),
		);
		$result = $CI->Products->update_product($data,$product_id);
		if ($result == true) {
			$this->session->set_userdata(array('message'=>display('successfully_updated')));
			redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product'));
		}else{
			$this->session->set_userdata(array('error_message'=>display('product_model_already_exist')));
			redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product'));
		}
	}
	//Manage Product
	public function manage_product()
	{	
		$CI =& get_instance();
		$CI->load->library('lproduct');
		$CI->load->model('Products');

		#
        #pagination starts
        #
        $config["base_url"] = base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product/');
        $config["total_rows"] = $this->Products->product_list_count();
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
        $data =$this->lproduct->product_list($links,$config["per_page"],$page);
		$data['content']  = $this->load->view('dashboard_pharmacist/product/product',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);	
	}
	//Add Product CSV
	public function add_product_csv(){
		$CI =& get_instance();
		$data = array(
			'title' => display('add_product_csv')
		);
		$data['content']  = $this->load->view('dashboard_pharmacist/product/add_product_csv',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);	
		
	}
	//CSV Upload File
function uploadCsv()
    {
        $product_id=$this->generator(8);
        $count=0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'],'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE)
    	{
  
	        while($csv_line = fgetcsv($fp,1024))
	        {
	            //keep this if condition if you want to remove the first row
	            for($i = 0, $j = count($csv_line); $i < $j; $i++)
	            {
	               $insert_csv = array();
	                 $insert_csv['product_id'] = (!empty($csv_line[0])?$csv_line[0]:null);
	               $insert_csv['supplier_id'] = (!empty($csv_line[1])?$csv_line[1]:null);
	                $insert_csv['category_id'] = (!empty($csv_line[2])?$csv_line[2]:null);
	                $insert_csv['product_name'] = (!empty($csv_line[3])?$csv_line[3]:null);
	                 $insert_csv['generic_name'] = (!empty($csv_line[4])?$csv_line[4]:null);
	                  $insert_csv['box_size'] = (!empty($csv_line[5])?$csv_line[5]:null);
	                  $insert_csv['product_location'] = (!empty($csv_line[6])?$csv_line[6]:null);
	                $insert_csv['price'] = (!empty($csv_line[7])?$csv_line[7]:null);
	                $insert_csv['supplier_price'] = (!empty($csv_line[8])?$csv_line[8]:null);
	                $insert_csv['unit'] = (!empty($csv_line[9])?$csv_line[9]:null);
	                $insert_csv['tax'] = (!empty($csv_line[10])?$csv_line[10]:null);
	                $insert_csv['product_model'] = (!empty($csv_line[11])?$csv_line[11]:null);
	                $insert_csv['product_details'] = (!empty($csv_line[12])?$csv_line[12]:null);
	                $insert_csv['image'] = (!empty($csv_line[13])?$csv_line[13]:null);
	                $insert_csv['status'] = (!empty($csv_line[14])?$csv_line[14]:null);
	            }
	      

	            $data = array(
	                'product_id' 	=>$insert_csv['product_id'],
	                'category_id' 	=> $insert_csv['category_id'],
	                'product_name' 	=> $insert_csv['product_name'],
	                'generic_name' 	=> $insert_csv['generic_name'],
	                'box_size' 	    => $insert_csv['box_size'],
	             	'product_location' => $insert_csv['product_location'],
	                'price' 		=> $insert_csv['price'],
	                'unit' 			=> $insert_csv['unit'],
	                'tax' 			=> $insert_csv['tax'],
	                'product_model'  => $insert_csv['product_model'],
	                'product_details' => $insert_csv['product_details'],
	                'image' 		=> $insert_csv['image'],
	                'status' 		=> $insert_csv['status']
	            );
	            $supp_prd = array(
				'product_id'			=>	$insert_csv['product_id'],
				'supplier_id'			=>  $insert_csv['supplier_id'],
				'supplier_price'		=>	$insert_csv['supplier_price'],
				 'products_model'       => $insert_csv['product_model'],
				
			);

	            if ($count > 0) {
			        
			         $splprd = $this->db->select('*')
			        					->from('supplier_product')
			        						->where('supplier_id',$supp_prd['supplier_id'])
			        					->where('products_model',$supp_prd['products_model'])
			        				
			        					->get()
			        					->num_rows();
			        					
			        	if ($splprd == 0) {
			        	     	$this->db->insert('supplier_product',$supp_prd);}else {
			             $supp_prd = array(
			
				 'supplier_id'			=>  $insert_csv['supplier_id'],
				 'supplier_price'		=>	$insert_csv['supplier_price'],
				 'products_model'        => $insert_csv['product_model']
				
			);
			   $this->db->where('products_model',$supp_prd['products_model']);
			    $this->db->where('supplier_id',$supp_prd['supplier_id']);
                $this->db->update('supplier_product',$supp_prd);
			        	     	}
			        	     	 $result = $this->db->select('*')
			        					->from('product_information')
			        					->where('product_model',$data['product_model'])
			        					->get()
			        					->num_rows();
			        if ($result == 0 && !empty($data['product_model'])) {

			        	$this->db->insert('product_information',$data);
			        

			        	$this->db->select('*');
						$this->db->from('product_information');
						$this->db->where('status',1);
						$query = $this->db->get();
						foreach ($query->result() as $row) {
							$json_product[] = array('label'=>$row->product_name."-(".$row->product_model.")",'value'=>$row->product_id);
						}
						$cache_file = './my-assets/js/admin_js/json/product.json';
						$productList = json_encode($json_product);
						file_put_contents($cache_file,$productList);
			        }else {
			             
					     $data = array(
					
	                'category_id' 	=> $insert_csv['category_id'],
	                'product_name' 	=> $insert_csv['product_name'],
	                 'generic_name' 	=> $insert_csv['generic_name'],
	                'box_size' 	    => $insert_csv['box_size'],
	             	'product_location' => $insert_csv['product_location'],
	                'price' 		=> $insert_csv['price'],
	                'unit' 			=> $insert_csv['unit'],
	                'tax' 			=> $insert_csv['tax'],
	                'product_model'  => $insert_csv['product_model'],
	                'product_details' => $insert_csv['product_details'],
	                'image' 		=> (!empty($insert_csv['image'])?$insert_csv['image']:base_url('my-assets/image/product.png')),
	                'status' 		=> $insert_csv['status']
	            );
	            
	            
			    $this->db->where('product_model',$data['product_model']);
			    $this->db->update('product_information',$data);
			            
			   
                            
			 //           $this->db->select('*');
				// 		$this->db->from('product_information');
				// 		$this->db->where('status',1);
				// 		$query = $this->db->get();
				// 		foreach ($query->result() as $row) {
				// 			$json_product[] = array('label'=>$row->product_name."-(".$row->product_model.")",'value'=>$row->product_id);
				// 		}
				// 		$cache_file = './my-assets/js/admin_js/json/product.json';
				// 		$productList = json_encode($json_product);
				// 		file_put_contents($cache_file,$productList);
			        }
	            }  
	            $count++; 
	        }
        }

        fclose($fp) or die("can't close file");
    	$this->session->set_userdata(array('message'=>display('successfully_added')));
		redirect(base_url('dashboard_pharmacist/hospital_activities/Cproduct/manage_product'));
    }

    //Add supplier by ajax
	public function add_supplier(){
		$this->load->model('Suppliers');

		$data=array(
			'supplier_id' 	=> $this->auth->generator(20),
			'supplier_name' => $this->input->post('supplier_name'),
			'address' 		=> $this->input->post('address'),
			'mobile' 		=> $this->input->post('mobile'),
			'details' 		=> $this->input->post('details'),
			'status' 				=> 1
			);

		$supplier = $this->Suppliers->supplier_entry($data);

		if ($supplier == TRUE) {
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			echo TRUE;
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			echo FALSE;
		}
	}

	// Insert category by ajax
	public function insert_category()
	{
		$this->load->model('Categories');
		$category_id=$this->auth->generator(15);

	  	//Customer  basic information adding.
		$data=array(
			'category_id' 			=> $category_id,
			'category_name' 		=> $this->input->post('category_name'),
			'status' 				=> 1
			);

		$result=$this->Categories->category_entry($data);
		
		if ($result == TRUE) {
			$this->session->set_userdata(array('message'=>display('successfully_added')));
			echo TRUE;
		}else{
			$this->session->set_userdata(array('error_message'=>display('already_exists')));
			echo FALSE;
		}
	}

	// product_delete
	public function product_delete()
	{	
		$CI =& get_instance();
		$CI->load->model('Products');
		$product_id =  $_POST['product_id'];
		$result=$CI->Products->delete_product($product_id);
		return true;
			
	}
	//Retrieve Single Item  By Search
	public function product_by_search()
	{
		$CI =& get_instance();
		$CI->load->library('lproduct');
		$product_id = $this->input->post('product_id');

        $data = $CI->lproduct->product_search_list($product_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/product/product',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	//Retrieve Single Item  By Search
	public function product_details($product_id)
	{
		$this->product_id=$product_id;
		$CI =& get_instance();
		$CI->load->library('lproduct');	
		$data = $CI->lproduct->product_details($product_id);
		$data['content']  = $this->load->view('dashboard_pharmacist/product/product_details',$data,true);
        $this->load->view('dashboard_pharmacist/main_wrapper',$data);
	}
	
	//Retrieve Single Item  By Search
	public function product_sales_supplier_rate($product_id=null,$startdate=null,$enddate=null)
	{
		if($startdate==null){$startdate= date('d-m-Y',strtotime('-30 days'));}
		if($enddate==null){$enddate= date('d-m-Y');}
		$product_id_input=$this->input->post('product_id');
		if(!empty($product_id_input))
			{
				$product_id=$this->input->post('product_id');
				$startdate=$this->input->post('from_date');
				$enddate=$this->input->post('to_date');
			}
		
		$this->product_id=$product_id;
		
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lproduct');	
        $content = $CI->lproduct->product_sales_supplier_rate($product_id,$startdate,$enddate);
		$this->template->full_admin_html_view($content);
	}

	//This function is used to Generate Key
	public function generator($lenth)
	{
		$CI =& get_instance();
		$CI->load->model('Products');

		$number=array("1","2","3","4","5","6","7","8","9","0");
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
				$con="$con"."$rand_number";
			}
		}

		$result = $this->Products->product_id_check($con);

		if ($result === true) {
			$this->generator(8);
		}else{
			return $con;
		}
	}
	//Export CSV
	public function exportCSV(){ 
   // file name 
   	$this->load->model('Products');
   $filename = 'product_'.date('Ymd').'.csv'; 
   header("Content-Description: File Transfer"); 
   header("Content-Disposition: attachment; filename=$filename"); 
   header("Content-Type: application/csv; ");
   
   // get data 
   $usersData = $this->Products->product_csv_file();

   // file creation 
   $file = fopen('php://output', 'w');
 
   $header = array('product_id','supplier_id','category_id','product_name','generic_name','box_size','product_location','price','supplier_price','unit','tax','product_model','product_details',  'image','status'); 
   fputcsv($file, $header);
   foreach ($usersData as $line){ 
     fputcsv($file,$line); 
   }
   fclose($file); 
   exit; 
  }
}