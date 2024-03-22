<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_customer extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Customer_model');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}

	public function index()
	{
		$data= array();
		if($this->session->userdata("userType")!="1") 
		{
     
		    $userId = $this->session->userdata("userId");
			$username = $this->session->userdata("userName");
             $whr = array('username' => $username);
             $res = $this->basic_operation_m->getAll('tbl_users', $whr);
             $branch_id = $res->row()->branch_id;				
		    $where ="tbl_customers.branch_id='$branch_id' AND tbl_customers.isdeleted = 0 ";
			$data['allcustomer']= $this->Customer_model->get_customer_details($where);
		 
		} else {
				$where = 'tbl_customers.customer_type = 0 AND tbl_customers.isdeleted = 0 ';
				$data['allcustomer']= $this->Customer_model->get_customer_details($where);
		}
		//	print_r($data['allcustomer']);die();
				
		$this->load->view('admin/customer_management/view_customer',$data);
	}
	public function deleted_customer_list()
	{
		$data= array();
		if($this->session->userdata("userType")!="1") 
		{
     
		    $userId = $this->session->userdata("userId");
			$username = $this->session->userdata("userName");
             $whr = array('username' => $username);
             $res = $this->basic_operation_m->getAll('tbl_users', $whr);
             $branch_id = $res->row()->branch_id;				
		    $where ="tbl_customers.branch_id='$branch_id' AND tbl_customers.isdeleted = 1 ";
			$data['allcustomer']= $this->Customer_model->get_customer_details($where);
		 
		} else {
				$where = 'tbl_customers.customer_type = 0 AND tbl_customers.isdeleted = 1 ';
				$data['allcustomer']= $this->Customer_model->get_customer_details($where);
		}
		//	print_r($data['allcustomer']);die();
				
		$this->load->view('admin/customer_management/view_deleted_customer',$data);
	}
	
	public function delete_active_customer(){
	    
	    $id = $this->input->post('getid');
		if($id!=""){
		    
		    $whr =array('customer_id'=>$id);
			$data =array('isdeleted'=>'0');
			$result=$this->basic_operation_m->update('tbl_customers',$data, $whr );
			
			$output['status'] = 'success';
			$output['message'] = 'User deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the User';
		}
 
		echo json_encode($output);	
            
		}		
	  
		
	
	public function delete_permanently_customer()
	{
		$id = $this->input->post('getid');
	
				if($id!=""){
					
					$whr =array('customer_id'=>$id);
		            $res=$this->basic_operation_m->delete('tbl_customers',$whr);
					
					$output['status'] = 'success';
					$output['message'] = 'User deleted successfully';
				}
				else{
					$output['status'] = 'error';
					$output['message'] = 'Something went wrong in deleting the User';
				}
		 
				echo json_encode($output);	
	  
	}

	
	public function add_customer()
	{
		$query ="select max(customer_id) AS id from  tbl_customers"; 
		$result1= $this->basic_operation_m->get_query_row($query);
		$where = array('isdeleted'=>'0');
		$data['allcustomer']= $this->Customer_model->get_customer_details('');
		
		$id= $result1->id+1;
		if(strlen($id)==2)
		{
			$customer_id='API00'.$id;
		}else if(strlen($id)==3)
		{
			$customer_id='API0'.$id;
		}else if(strlen($id)==1)
		{
			$customer_id='API000'.$id;
		}else if(strlen($id)==4)
		{
			$customer_id='API'.$id;
		}

		$data['message']="";

         $data['all_staff']= $this->basic_operation_m->get_all_result('tbl_users');
         $data['all_sales_person']= $this->basic_operation_m->get_all_result('tbl_users',array('user_type'=>6));
		 $data['cities']= $this->basic_operation_m->get_all_result('city','');
         $data['states']=$this->basic_operation_m->get_all_result('state','');		

		if(isset($_POST['submit']))
		{
			//print_r($_POST); DIE;

			$date=date('Y-m-d');
            $user_type = '0';
		    $user_id = $this->session->userdata("userId");
            if($this->session->userdata("userType")=="5") {
			    $user_type = 'b2b';
			} 
            
			$creditDays = $this->input->post('credit_days');
			if(!$this->input->post('credit_days')){
				$creditDays = '';
			}
			
			$username = $this->session->userdata("userName");
			 $whr = array('username' => $username);
			 $res = $this->basic_operation_m->getAll('tbl_users', $whr);
			 $branch_id = $res->row()->branch_id;	

			 $v = $this->input->post('gstfile');
			 if(isset($_FILES) && !empty($_FILES['gstfile']['name']))
			 {
				 $ret = $this->basic_operation_m->fileUpload($_FILES['gstfile'],'assets/customer/');
			  //file is uploaded successfully then do on thing add entry to table
				 if($ret['status'] && isset($ret['image_name']))
				 {
					 $gstfile = $ret['image_name'];
					 
				 }
			 }
			 $p = $this->input->post('panfile');
			 if(isset($_FILES) && !empty($_FILES['panfile']['name']))
			 {
				 $ret = $this->basic_operation_m->fileUpload($_FILES['panfile'],'assets/customer/');
			  //file is uploaded successfully then do on thing add entry to table
				 if($ret['status'] && isset($ret['image_name']))
				 {
					 $panfile = $ret['image_name'];
					 
				 }
			 }
			 $query ="select max(customer_id) AS id from  tbl_customers"; 
		$result1= $this->basic_operation_m->get_query_row($query);
		$data['allcustomer']= $this->Customer_model->get_customer_details('');
		$id= $result1->id+1;
		if(strlen($id)==2)
		{
			$customer_id='API00'.$id;
		}else if(strlen($id)==3)
		{
			$customer_id='API0'.$id;
		}else if(strlen($id)==1)
		{
			$customer_id='API000'.$id;
		}else if(strlen($id)==4)
		{
			$customer_id='API'.$id;
		}
			if($this->input->post('api_access')=='Yes'){
				$apiHash = sha1($customer_id);
			}
			else
			{
				$apiHash = '';
			}
			$data=array(//'customer_id'=>'',
				'cid'=>$customer_id,
				'customer_name'=>$this->input->post('customer_name'),
				'contact_person'=>$this->input->post('contact_person'),
				'phone'=>$this->input->post('phone'),
				'email'=>$this->input->post('email'),
				'password'=>$this->input->post('password'),
				'address'=>$this->input->post('address'),							
				'state'=>$this->input->post('state_id'),
				'city'=>$this->input->post('city'),
				'company_id'=>$this->input->post('company_id'),
				'pincode'=>$this->input->post('pincode'),
				'gstno'=>$this->input->post('gstno'),
				'gstfile'=>$gstfile,
				'panno'=>$this->input->post('panno'),
				'panfile'=>$panfile,
				'gst_charges'=>$this->input->post('gst_charges'),
				'policy_no'=>$this->input->post('policy_no'),
				'register_date'=>$date,
				'api_access'=>$this->input->post('api_access'),
				'api_key'=>$apiHash,
				'mis_emailids'=>$this->input->post('mis_emailids'),
				'sac_code'=>$this->input->post('sac_code'),
				'mis_formate'=>$this->input->post('mis_formate'),
				'auto_mis'=>$this->input->post('auto_mis'),
				'customer_type' => $user_type,
				'user_id' => $this->input->post('user_id'),
				'credit_days'=>$creditDays,
				'parent_cust_id' => $this->input->post('parent_cust'),
				'sales_person_id' => $this->input->post('sales_person_id'),
				'credit_limit' => $this->input->post('credit_limit'),
				'branch_id' => $this->input->post('branch_id'),
				'franchise_customer_access' => $this->input->post('franchise_customer_access'),
				// 'branch_id'=>$branch_id
				);
				if($this->input->post('franchise_customer_access')==1){
                   $data['franchise_id'] = $this->input->post('franchise_id');
				}else{
					$data['franchise_id'] = '0';
				}
			$result=$this->basic_operation_m->insert('tbl_customers',$data);
			// echo $this->db->last_query();die();
			// var_dump($result);die();
			$this->basic_operation_m->addLog($this->session->userdata("userId"),'Master','Add Customer', $data);
			if(!empty($result))
			{						
				$msg			= 'Customer added successfully';
				$class			= 'alert alert-success alert-dismissible';		
			}else{
				$msg			= 'Customer not added successfully';
				$class			= 'alert alert-danger alert-dismissible';	
			}	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);

			redirect('admin/list-customer');
		}	
		$data['cid']=$customer_id;
        $data['franchise'] = $this->db->query("SELECT * FROM tbl_customers WHERE customer_type IN (1,2) AND isdeleted = '0' GROUP BY cid ORDER BY customer_id DESC")->result();
		$data['company_list'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_company WHERE 1 ORDER BY company_name ASC');
		$this->load->view('admin/customer_management/add_customer', $data);
	}

	public function update_customer($id)
	{
			$data['message']="";	
			if($id!="")
			{
				// $whr =array('customer_id'=>136);
				$whr =array('customer_id'=>$id);
				$data['customer']=$this->basic_operation_m->get_table_row('tbl_customers',$whr);				
			}

			$data['all_staff']= $this->basic_operation_m->get_all_result('tbl_users','');
	        $data['cities']= $this->basic_operation_m->get_all_result('city','');
         	$data['states']= $this->basic_operation_m->get_all_result('state','');	
			$data['allcustomer']= $this->Customer_model->get_customer_details('');
			$data['all_sales_person']= $this->basic_operation_m->get_all_result('tbl_users',array('user_type'=>6));
         
			if (isset($_POST['submit'])) 
			{
					$last = $this->uri->total_segments();
					$id= $this->uri->segment($last);
					$whr =array('customer_id'=>$id);
					$user_type = '0';
					$user_id = $this->session->userdata("userId");
		            if($this->session->userdata("userType")=="5") {
					    $user_type = 'b2b';
					}

					$creditDays = $this->input->post('credit_days');
					if(!$this->input->post('credit_days')){
						$creditDays = '';
					}
					if($this->input->post('api_access')=='Yes'){
						$apiHash = sha1($this->input->post('cid'));
					}
					else
					{
						$apiHash = '';
					}

					$r= array(
						'customer_name'=>$this->input->post('customer_name'),
						'contact_person'=>$this->input->post('contact_person'),
						
						'phone'=>$this->input->post('phone'),
						'email'=>$this->input->post('email'),
						'password'=>$this->input->post('password'),
						'address'=>$this->input->post('address'),							
						'state'=>$this->input->post('state_id'),
						'city'=>$this->input->post('city'),							 
						'company_id'=>$this->input->post('company_id'),							
						'pincode'=>$this->input->post('pincode'),
						'gstno'=>$this->input->post('gstno'),
						'panno'=>$this->input->post('panno'),
						'gst_charges'=>$this->input->post('gst_charges'),
						'api_access'=>$this->input->post('api_access'),
						'api_key'=>$apiHash,
						'mis_emailids'=>$this->input->post('mis_emailids'),
						'sac_code'=>$this->input->post('sac_code'),
						'mis_formate'=>$this->input->post('mis_formate'),
						'auto_mis'=>$this->input->post('auto_mis'),
						'customer_type' => $user_type,
						'user_id' => $this->input->post('user_id'),
						'parent_cust_id' => $this->input->post('parent_cust'),
						'sales_person_id' => $this->input->post('sales_person_id'),
						'credit_limit' => $this->input->post('credit_limit'),
						'credit_days'=>$creditDays,
						'franchise_customer_access' => $this->input->post('franchise_customer_access'),
						'branch_id' => $this->input->post('branch_id')
						);
						$v = $this->input->post('gstfile');
						if(isset($_FILES) && !empty($_FILES['gstfile']['name']))
						{
							$ret = $this->basic_operation_m->fileUpload($_FILES['gstfile'],'assets/customer/');
						 //file is uploaded successfully then do on thing add entry to table
							if($ret['status'] && isset($ret['image_name']))
							{
								$r['gstfile'] = $ret['image_name'];
								
							}
						}
						$p = $this->input->post('panfile');
						if(isset($_FILES) && !empty($_FILES['panfile']['name']))
						{
							$ret = $this->basic_operation_m->fileUpload($_FILES['panfile'],'assets/customer/');
						 //file is uploaded successfully then do on thing add entry to table
							if($ret['status'] && isset($ret['image_name']))
							{
								$r['panfile'] = $ret['image_name'];
							}
						}
						if($this->input->post('franchise_customer_access')==1){
							$r['franchise_id'] = $this->input->post('franchise_id');
						 }else{
							 $r['franchise_id'] = '0';
						 }
						//print_r($r);die();
					$result=$this->basic_operation_m->update('tbl_customers',$r, $whr);

					$this->basic_operation_m->addLog($this->session->userdata("userId"),'Master','Update Customer', $r, $data['customer']);

					if ($this->db->affected_rows() > 0) {
						$data['message']="data Updated Sucessfully";
					}else{
						$data['message']="Error in Query";
					}
					if(!empty($data))
					{						
						$msg			= 'Customer updated successfully';
						$class			= 'alert alert-success alert-dismissible';		
					}else{
						$msg			= 'Customer not updated successfully';
						$class			= 'alert alert-danger alert-dismissible';	
					}	
					$this->session->set_flashdata('notify',$msg);
					$this->session->set_flashdata('class',$class);

					redirect('admin/list-customer');
			}
	
		// echo "<pre>"; print_r($data['customer']); die;	
		$data['franchise'] = $this->db->query("SELECT * FROM tbl_customers WHERE customer_type IN (1,2) AND isdeleted = '0' GROUP BY cid ORDER BY customer_id DESC")->result();	
		$data['company_list'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_company WHERE 1 ORDER BY company_name ASC');		
		$this->load->view('admin/customer_management/edit_customer',$data);
	}

// 	public function delete_customer()
// 	{
// 		$data['message']="";
// 		$last = $this->uri->total_segments();
// 		$id	= $this->uri->segment($last);
// 		if($id!="")
// 		{
// 			$whr =array('customer_id'=>$id);
// 			$res=$this->basic_operation_m->delete('tbl_customers',$whr);

// 			$msg	= 'Customer Deleted successfully';
// 			$class	= 'alert alert-success alert-dismissible';		
// 			$this->session->set_flashdata('notify',$msg);
// 			$this->session->set_flashdata('class',$class);	
			
// 			redirect('admin/list-customer');
// 		}		

// 	}


   public function delete_customer()
	{
          $getId = $this->input->post('getid');
        //   $data =  $this->db->delete('tbl_customers',array('customer_id'=>$getId));
		  $r= array('isdeleted'=>'1'); 		
		  $data=$this->basic_operation_m->update('tbl_customers',$r, array('customer_id'=>$getId));
         // echo $this->db->last_query();
		  $this->basic_operation_m->addLog($this->session->userdata("userId"),'Master','Delete Customer', $r);
          if($data){
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the member';
			
		}
		else{
			$output['status'] = 'success';
			$output['message'] = 'Member deleted successfully';
		}
 
		echo json_encode($output);	

	}
	
	public function change_customer_status($customer_id,$status)
	{
		$status  = ($status == '0')?'1':'0';
		$r= array('access_status'=>$status);
		$result=$this->basic_operation_m->update('tbl_customers',$r, array('customer_id'=>$customer_id));
		redirect('admin/list-customer');	

	}
	public function getcity()
	{
		$pincode=$this->input->post('pincode');
		
		$whr1 =array('POSTCODE'=>$pincode);
		$res1=$this->basic_operation_m->selectRecord('tbl_pincode',$whr1);	
		$result1 = $res1->row();

		$str= $result1->TOWN."-".$result1->PROVINCE;

		echo $str;
	}
	 public function getCityList()
    {
       $pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode,'isdeleted'=>0);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);	
		
		$city_id = $res1->row()->city_id;
		
		$whr2 = array('id' => $city_id);
		$res2 = $this->basic_operation_m->selectRecord('city', $whr2);
		$result2 = $res2->row();

		echo json_encode($result2);
    }	
    public function getState() {
		$pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode,'isdeleted'=>0);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);	
		
		$state_id = $res1->row()->state_id;
		$whr3 = array('id' => $state_id);
		$res3 = $this->basic_operation_m->selectRecord('state', $whr3);
		$result3 = $res3->row();

		echo json_encode($result3);
	}

	// =======================================================
	// EXPORT CUSTOMERS

     public function getFranchise(){
		
		$pincode = $this->input->post('pincode');
		$state = $this->input->post('cust_state');
		$city = $this->input->post('cust_city');

		$franchise = $this->db->query("SELECT * FROM tbl_customers WHERE customer_type IN (1,2) AND pincode ='$pincode' ORDER BY customer_id DESC")->result();
		$option = '<option value="">Select Assign Access</option>';
		foreach($franchise as $key=> $val){
			$option .= "<option value ='$val->customer_id'>$val->customer_name--$val->cid</option>";
		}
		echo $option;
	 }
	public function export_customers(){
		$data['cust'] = $this->db->get_where('tbl_customers',['isdeleted' => 0, 'customer_type' => 0])->result();

		if(isset($_GET['submit']) && ($_GET['submit'] == 'filter')){
			$customer_id = $_GET['cust'];
			if(!empty($customer_id)){
				$append = ' AND cust.customer_id ='.$customer_id; 
			}else{
				$append = '';
			}

			$data['customer_data'] = $this->db->query("SELECT cust.customer_id, cust.cid, cust.customer_name, 
				cf.cf_id, cf.fuel_price, cf.docket_charge, cf.appointment_min, cf.appointment_perkg, cf.fov_min, cf.fov_above, cf.fov_below, cf.fov_base, cf.company_type, cf.fc_type, cf.cod, cf.cft, cf.air_cft, cf.to_pay_charges, cf.fuel_from, cf.fuel_to, 
				rate.*,s.state, c.city, tm.mode_name, rm.region_name as from_zone_name, rm1.region_name as to_zone_name FROM tbl_customers cust 
			LEFT JOIN courier_fuel cf ON(cf.customer_id = cust.customer_id)
			LEFT JOIN tbl_domestic_rate_master rate ON(rate.customer_id = cust.customer_id)
			LEFT JOIN state s ON(s.id = rate.state_id)
			LEFT JOIN city c ON(c.id = rate.city_id)
			LEFT JOIN transfer_mode tm ON(tm.transfer_mode_id = rate.mode_id)
			LEFT JOIN region_master rm ON(rm.region_id = rate.from_zone_id)
			LEFT JOIN region_master rm1 ON(rm1.region_id = rate.to_zone_id)
			WHERE (cust.isdeleted = 0  AND cust.customer_type = 0 $append )"
			)->result();

			$this->load->library('excel'); 
			$fileName = 'data-'.time().'.xls';  
			$fp = fopen('php://output', 'w');

			$objPHPExcel = new PHPExcel();
	        $objPHPExcel->setActiveSheetIndex(0);

	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CID');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Customer Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Fuel Price');
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Docket Charge');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'FOV MIN');
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'FOV ABOVE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'FOV BELOW');
	        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'FOV BASE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'APPOINTMENT MIN');
	        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'APPOINTMENT PER KG');
	        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Fuel From Date');
	        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Fuel To Date');
	        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'CFT');
	        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'AIR CFT');
	        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'COD FIXED');
	        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'TOPAY FIXED');

	        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'FROM ZONE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'TO ZONE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'MODE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'TAT');
	        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'APPLICABLE FROM DATE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'EXP DATE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'WEIGHT FROM');
	        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'WEIGHT TO');
	        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'RATE');
	        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'RATE TYPE');

	        $rowCount = 2;
	        foreach ($data['customer_data'] as $list) {

	        	$cid = !empty($list->cid)?$list->cid:'';
	        	$customer_name = !empty($list->customer_name)?$list->customer_name:'';
	        	$fuel_price = !empty($list->fuel_price)?$list->fuel_price:'';
	        	$docket_charge = !empty($list->docket_charge)?$list->docket_charge:'';
	        	$fov_min = !empty($list->fov_min)?$list->fov_min:'';
	        	$fov_above = !empty($list->fov_above)?$list->fov_above:'';
	        	$fov_below = !empty($list->fov_below)?$list->fov_below:'';
	        	$fov_base = !empty($list->fov_base)?$list->fov_base:'';
	        	$appointment_min = !empty($list->appointment_min)?$list->appointment_min:'';
	        	$appointment_perkg = !empty($list->appointment_perkg)?$list->appointment_perkg:'';
	        	$fuel_from = !empty($list->fuel_from)?date('d-m-Y', strtotime($list->fuel_from)):'';
	        	$fuel_to = !empty($list->fuel_to)?date('d-m-Y', strtotime($list->fuel_to)):'';
	        	$cft = !empty($list->cft)?$list->cft:'';
	        	$air_cft = !empty($list->air_cft)?$list->air_cft:'';
	        	$cod = !empty($list->cod)?$list->cod:'';
	        	$to_pay_charges = !empty($list->to_pay_charges)?$list->to_pay_charges:'';
	        	$from_zone_name = !empty($list->from_zone_name)?$list->from_zone_name:'';
	        	$to_zone_name = !empty($list->to_zone_name)?$list->to_zone_name:'';
	        	$mode_name = !empty($list->mode_name)?$list->mode_name:'';
	        	$tat = !empty($list->tat)?$list->tat:'';
	        	$applicable_from = !empty($list->applicable_from)?date('d-m-Y', strtotime($list->applicable_from)):'';
	        	$applicable_to = !empty($list->applicable_to)?date('d-m-Y', strtotime($list->applicable_to)):'';
	        	$weight_range_from = !empty($list->weight_range_from)?$list->weight_range_from:'';
	        	$weight_range_to = !empty($list->weight_range_to)?$list->weight_range_to:'';
	        	$rate = !empty($list->rate)?$list->rate:'';
	        	$fixed_perkg = !empty($list->fixed_perkg)?$list->fixed_perkg:'';
	        	if($fixed_perkg == 0){
	        		$fixed = 'Fixed';
	        	}else if($fixed_perkg == 1){
	        		$fixed = 'Addition 250 GM';
	        	}else if($fixed_perkg == 2){
	        		$fixed = 'Addition 500 GM';
	        	}else if($fixed_perkg == 3){
	        		$fixed = 'Addition 1000 GM';
	        	}else if($fixed_perkg == 4){
	        		$fixed = 'Per KG';
	        	}else{ $fixed = ''; }

	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $cid);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $customer_name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $fuel_price);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $docket_charge);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $fov_min);
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $fov_above);
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $fov_below);
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $fov_base);
	            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $appointment_min);
	            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $appointment_perkg);
	            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $fuel_from);
	            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $fuel_to);
	            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $cft);
	            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $air_cft);
	            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $cod);
	            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $to_pay_charges);
	            
	            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $from_zone_name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $to_zone_name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $mode_name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $tat);
	            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $applicable_from);
	            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $applicable_to);
	            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $weight_range_from);
	            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $weight_range_to);
	            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $rate);
	            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $fixed);
	            $rowCount++;
	        }
	        $filename = "CUSTOMERS_DATA". date("Y-m-d-H-i-s").".csv";
	        header('Content-Type: application/vnd.ms-excel'); 
	        header('Content-Disposition: attachment;filename="'.$filename.'"');
	        header('Cache-Control: max-age=0'); 
	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
	        $objWriter->save('php://output'); 
		}else{
			$this->load->view('admin/customer_management/export_customers_rate', $data);
		}

		
	}


	public function awb_available_stock($offset = 0, $searching = '')
	{
		error_reporting(E_ALL);
        ini_set('display_errors', 0);
		$user_id = $_GET['customer_id'];
		if(!empty($user_id)){
		$stock = $this->db->query("select * from tbl_customer_assign_cnode where customer_id = '$user_id'")->result();
        foreach($stock as $key => $value){
		  $number1 = range($value->seriess_from, $value->seriess_to);
		  $available_stock = [];
			foreach ($number1 as $number) {
				$pod_no = $number;
				$booking_info = $this->db->query("select * from tbl_domestic_booking where pod_no = '$pod_no' order by booking_id desc limit 1")->row();
				if ($pod_no != $booking_info->pod_no) {
					$available_stock1[] = [$pod_no, 'u' => '0'];
				} else {
					$Utilize[] = [$booking_info->pod_no, 'u' => '1'];
				}
			}
		}
		if (!empty($stock)) {
			
			if (!empty($Utilize)) {
				$available_stock = array_merge($Utilize, $available_stock1);
			} else {
				$available_stock = $available_stock1;
			}
			if (!empty($_GET['search'])) {
				if (in_array(strtoupper($_GET['search']), array_column($available_stock, '0'))) {
					$data['search_data'] = strtoupper($_GET['search']);
				} else {
					$data['available_stock'] = array();
				}
			} else {

				$stock_result = array_slice($available_stock, $offset, 300);

				$this->load->library('pagination');
				$data['total_count'] = count($available_stock);
				$config['total_rows'] = count($available_stock);
				$config['base_url'] = base_url() . 'admin/stock-customer';
				$config['per_page'] = 300;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';

				$config['attributes'] = array('class' => 'page-link');
				$this->pagination->initialize($config);
				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				if (!empty($stock_result)) {
					if (!empty($Utilize)) {
						$data['available_stock_count'] = count($available_stock) - count($Utilize);
						$data['Utilize'] = $Utilize;
						$data['Utilize_count'] = count($Utilize);
					} else {
						$data['available_stock_count'] = count($available_stock);
						$data['Utilize'] = 0;
						$data['Utilize_count'] = 0;
					}
					$data['available_stock'] = $stock_result;
				} else {
					$data['available_stock'] = array();
					$data['Utilize'] = '0';
				}
			}
		} else {
			$this->load->library('pagination');
			$data['total_count'] = 0;
			$config['total_rows'] = 0;
			$config['base_url'] = base_url() . 'admin/stock-customer';
			$config['per_page'] = 100;
			$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
			$config['full_tag_close'] = '</ul></nav>';
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next paginate_button page-item">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li class="next paginate_button page-item">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = 'Previous';
			$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="paginate_button page-item">';
			$config['reuse_query_string'] = TRUE;
			$config['num_tag_close'] = '</li>';

			$config['attributes'] = array('class' => 'page-link');
			$this->pagination->initialize($config);
			if ($offset == '') {
				$config['uri_segment'] = 3;
				$data['serial_no'] = 1;
			} else {
				$config['uri_segment'] = 3;
				$data['serial_no'] = $offset + 1;
			}
			$data['available_stock'] = array();
			$data['Utilize'] = '0';
		}
	}else{
		$this->load->library('pagination');
			$data['total_count'] = 0;
			$config['total_rows'] = 0;
			$config['base_url'] = base_url() . 'admin/stock-customer';
			$config['per_page'] = 100;
			$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
			$config['full_tag_close'] = '</ul></nav>';
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next paginate_button page-item">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li class="next paginate_button page-item">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = 'Previous';
			$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="paginate_button page-item">';
			$config['reuse_query_string'] = TRUE;
			$config['num_tag_close'] = '</li>';

			$config['attributes'] = array('class' => 'page-link');
			$this->pagination->initialize($config);
			if ($offset == '') {
				$config['uri_segment'] = 3;
				$data['serial_no'] = 1;
			} else {
				$config['uri_segment'] = 3;
				$data['serial_no'] = $offset + 1;
			}
			$data['available_stock'] = array();
			$data['Utilize'] = '0';
	}
		//print_r($data);//die;
		$this->load->view('admin/domestic_shipment/awb_available_stock', $data);
	}

	public function get_booking_info()
	{
		$pod_no = $this->input->post('pod_no');
		$booking_info = $this->db->query("SELECT *  FROM `tbl_domestic_booking` where pod_no = '$pod_no'")->row();
		if (!empty($booking_info)) {
			$option = '<table id="myTable" class="display table table-bordered text-center">
		 <thead>
		 <tr>                 
			 <th>SR.No</th>
			 <th>Booking Date</th>
			 <th>AWB.No</th>
			 <th>Sender Name</th>
			 <th>Receiver Name</th>
			 <th>Receiver Pincode</th>
		 </tr>
		 </thead>
		 <tbody>
            <tr>
			<td>1</td>
			<th>' . $booking_info->booking_date . '</th>
			<th>' . $booking_info->pod_no . '</th>
			<th>' . $booking_info->sender_name . '</th>
			<th>' . $booking_info->reciever_name . '</th>
			<th>' . $booking_info->reciever_pincode . '</th>
            </tr>
			</tbody>
			</table>
			';
			echo $option;
		}
	}
	// =======================================================
}
