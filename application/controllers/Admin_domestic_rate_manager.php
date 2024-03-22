<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_domestic_rate_manager extends CI_Controller {

	var $data = array();
	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 $this->load->model('Rate_model');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
	public function get_customer_rate(){
		$packet = $this->input->post('packet');
		$customer_id = $this->input->post('customer_id');

		$data = $this->db->query("SELECT * FROM tbl_domestic_rate_master r WHERE r.customer_id = $customer_id")->row();
		echo "<pre>"; print_r($data); die;

	}
	
	###################### View All Airlines Start ########################
	public function view_domestic_rate($customer_id,$courier_id,$applicable_from)
	{ 
		// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
		$data 		= $this->data;
		$user_id	= $this->session->userdata("userId");		
		$data['domestic_rate_list']	= $this->Rate_model->get_domestic_rate_result($customer_id,$courier_id,$applicable_from);	
        // echo $this->db->last_query();die;
		//$data['edit_cust_id']	=$customer_id;
        $this->load->view('admin/domestic_rate_master/view_domestic_rate',$data);
      
	}	

	public function domestic_shipment_rate()
	{

		$date = date('d-m-Y');
		$filename = "Utility Bulk Rate Download_" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("SR.No","Zone", "sales Persan Name", "Customer Code", "Customer Name", "Mode", "Shipment Type", "Rate Type", "Minimum Rate", "Minimun Weight", "Fule Price", "Docket Charge", "Appointment Min", "Appointment Per Kg", "Fov Min", "Fov Above", "Fov Below", "Fov Base", "COD", "CFT", "Air Cft", "Topay Charges", "Fule From", "Fule to");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
          $rate = $this->db->query("CALL `Get_bulk_domestic_rate`()")->result_array();
		fputcsv($fp, $header);
		$i = 1;
		foreach ($rate as $key => $row) {
					
			$roww = array(
				$i,
				$row['ZONE'],
				$row['sales_Person'],
				$row['cid'],
				$row['customer_name'],
				$row['mode_name'],				
				$row['name'],
				$row['type_name'],
				$row['minimum_rate'],
				$row['minimum_weight'],
				$row['fuel_price'],
				$row['docket_charge'],
				$row['appointment_min'],
				$row['appointment_perkg'],
				$row['fov_min'],
				$row['fov_above'],
				$row['fov_below'],
				$row['fov_base'],
				$row['cod'],
				$row['cft'],
				$row['air_cft'],
				$row['to_pay_charges'],
				date('d-m-Y', strtotime($row['fuel_from'])),
				date('d-m-Y', strtotime($row['fuel_to']))
			);
			fputcsv($fp, $roww);
			$i++;
		}
		
		exit;
	}


	public function view_domestic_customer()
	{  
	   
		$data 		= $this->data;
		$user_id	= $this->session->userdata("userId");	
		$data['customer_list']	 = $this->basic_operation_m->get_all_result("tbl_customers",['isdeleted'=>0]);	
        $this->load->view('admin/domestic_rate_master/view_domestic_customer',$data);
      
	}	
	public function add_domestic_rate()
	{   
		$data 		= $this->data;
		$user_id	= $this->session->userdata("userId");

		//$whr = array('customer_id'=>$customer_id);
		$data['customer_list']	 = $this->basic_operation_m->get_all_result('tbl_customers',['isdeleted'=>0]);
		$whr_c = array('company_type'=>'Domestic');
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company",$whr_c);
		$data['mode_list']		 = $this->basic_operation_m->get_all_result("transfer_mode","");
		$data['zone_list']		 = $this->basic_operation_m->get_all_result("region_master","");
		$data['states']=$this->basic_operation_m->get_all_result('state','');	

		$data['added_customer_list']= $this->Rate_model->get_added_domestic_customer("");

		
		$this->load->view('admin/domestic_rate_master/view_add_domestic_rate',$data);      
	}
	
	// Start rate upload
	public function upload_domestic_rate(){
		$data 		= $this->data;
		$user_id	= $this->session->userdata("userId");
		$data['customer_list']	 = $this->basic_operation_m->get_all_result('tbl_customers','');
		
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company",['company_type'=>'Domestic']);
		$data['mode_list']		 = $this->basic_operation_m->get_all_result("transfer_mode","");
		$data['zone_list']		 = $this->basic_operation_m->get_all_result("region_master","");
		$data['states']=$this->basic_operation_m->get_all_result('state','');	

		$data['added_customer_list']= $this->Rate_model->get_added_domestic_customer("");
		$this->load->view('admin/domestic_rate_master/upload_domestic_rate',$data);
	}

	public function upload_domestic_rate_insert(){
		$data = [];			
		$username = $this->session->userdata("userName");
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");

		$date = date('Y-m-d',strtotime($_POST['applicable_from']));
		
		$extension = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
		if($extension!="csv")
		{	
			$msg			= 'Please uploade csv file.';
			$class			= 'alert alert-danger alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			
			
		}else{
			$file = fopen($_FILES['uploadFile']['tmp_name'],"r");
			$heading_array = array();
			$cnt = 0;
			
			$toZone = array();
			while(!feof($file))
			{
				$data	= fgetcsv($file);
				if(!empty($data))
				{	
					// print_r($data); 
					// echo "<pre>";print_r($data);exit();
					if ($cnt==0) {
						
						foreach ($data as $key => $value) {
							if ($key!=0) {
								$whr =array('region_name'=>$value);
								$region_data=$this->basic_operation_m->get_table_row('region_master',$whr);
								if(empty($region_data)){
									echo "Not a Valid To zone Name : ".$value;exit();
								}else{
									$toZone[] = $region_data->region_id;
								}
							}else{
								$toZone[] = 0;
							}	
						}
					}
				 	if($cnt>0)
				  	{

						$whr =array('region_name'=>$data[0]);
						$region_data=$this->basic_operation_m->get_table_row('region_master',$whr);

						if(empty($region_data)){
							echo "Not a Valid From zone Name : ".$data[0];exit();
						}
						$fromZone_id = $region_data->region_id;
						
						foreach ($data as $key => $value) {
							if ($key!=0) {

								$customer_ids = $_POST['customer_id'];

							

								foreach ($customer_ids as $key2 => $value2) {
								
									$alldata = array(

										'customer_id' => $value2,
										'c_courier_id' => $_POST['c_courier_id'],
										'mode_id' => $_POST['mode_id'],
										'from_zone_id' => $fromZone_id,
										'to_zone_id' => $toZone[$key],
										'state_id' => 0,
										'city_id' => 0,
										'doc_type' => $_POST['doc_type'],
										'applicable_from' => $date,
										'weight_range_from' => 0.1,
										'weight_range_to' => 15000,
										'weight_slab' => 0,
										'rate' => $value,
										'tat' => 0,
										'fixed_perkg' => $_POST['fixed_perkg'],
										'minimum_rate' => $_POST['minimum_rate'],
										'minimum_weight' => $_POST['minimum_weight'],
										'applicable_to' => $_POST['exp_date']
									);

									$this->db->insert('tbl_domestic_rate_master', $alldata);

									$array_data[] = $alldata;
								}
								// $d_data		= $this->basic_operation_m->insert_domestic_rate("tbl_domestic_rate_master",$alldata);	
								// echo $this->db->last_query();
								// echo "<br>";
							}
							// echo "key error";
							
						}
						// echo "region error";
						
					} //==end already exist condition
					$cnt++;			
				}
				$this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Upload Domastic Rate Master', $array_data);
				$msg   = 'File uploaded successfully..';
				$class = 'alert alert-success alert-dismissible';	
				$this->session->set_flashdata('notify',$msg);
				$this->session->set_flashdata('class',$class);
			}		
			redirect('admin/view-add-domestic-rate');
			// redirect('admin_domestic_rate_manager/view_upload_domestic_rate');
		}
  	}
  	// End rate upload

	public function getStatewiseCity()
	{
		$state_id 	= $this->input->post('state_id');

		// print_r($state_id);exit();

		$state_id = array_filter($state_id);
		$html 		= '<option>Select City</option>';
		if(!empty($state_id))
		{
			// print_r($state_id);exit();
			$whr 	=	'state_id IN ('.implode(',', $state_id).')';
			$res	=	$this->basic_operation_m->get_all_result('city',$whr);
			if(!empty($res))
			{
				foreach($res as $key => $values)
				{
					if(isset($_POST['city_id']) && !empty($_POST['city_id']) && $_POST['city_id'] == $values['id'] )
					{
						$html  .= '<option value="'.$values['id'].'" selected  >'.$values['city'].'</option>';
					}
					else					
					{
						$html  .= '<option value="'.$values['id'].'"   >'.$values['city'].'</option>';
					}
				}
			}
      	}		
      	echo json_encode($html);
	}
	
	public function getStatewiseCity_foredit()
	{
		$state_id 	= $this->input->post('state_id');

		// print_r($state_id);exit();

		
		$html 		= '<option>Select City</option>';
		if(!empty($state_id))
		{
			// print_r($state_id);exit();
			$whr 	=	"state_id = '$state_id'";
			$res	=	$this->basic_operation_m->get_all_result('city',$whr);
		
			if(!empty($res))
			{
				foreach($res as $key => $values)
				{
					if(isset($_POST['city_id']) && !empty($_POST['city_id']) && $_POST['city_id'] == $values['id'] )
					{
						$html  .= '<option value="'.$values['id'].'" selected  >'.$values['city'].'</option>';
					}
					else					
					{
						$html  .= '<option value="'.$values['id'].'"   >'.$values['city'].'</option>';
					}
				}
			}
      	}		
      	echo json_encode($html);
	}
	public function get_inserted_courier() {
		$customer_id = $this->input->post('customer_id');
		$whr = array('tbl_domestic_rate_master.customer_id' => $customer_id);
		$res = $this->Rate_model->get_added_domestic_customer($whr);
		echo json_encode($res);
	}	
	public function insert_domestic_rate()
	{  	   
		$alldata 	= $this->input->post();	
		if($alldata['fixed_perkg']>0)
		{
			//$alldata['weight_slab'] = ((round($alldata['weight_range_to']) *1000) - (round($alldata['weight_range_from']) *1000));
			$alldata['weight_slab'] = ((round((float)$alldata['weight_range_to']) *1000) - (round((float)$alldata['weight_range_from']) *1000));
		}
	
		if(!empty($alldata))
		{  
			// echo '<pre>';print_r($alldata);die;

			$d_data		= $this->basic_operation_m->insert_domestic_rate("tbl_domestic_rate_master",$alldata);
        //    echo $this->db->last_query();die;
			$this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Add Domastic Rate Master', $alldata);

			$msg			= 'Rate Inserted successfully';
			$class			= 'alert alert-success alert-dismissible';				
		}
		else
		{
			$msg			= 'Rate not Inserted';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/view-add-domestic-rate');
	}
	
	
	
	public function view_edit_domestic_rate($id,$customer_id)
	{  
		$data = $this->data;
		if(!empty($id))
		{
			$data['customer_list']	 = $this->basic_operation_m->get_all_result("tbl_customers",['isdeleted'=>0]);
			$whr_c = array('company_type'=>'Domestic');
		    $data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company",$whr_c);
			$data['mode_list']	= $this->basic_operation_m->get_all_result("transfer_mode","");
			$data['zone_list']	 = $this->basic_operation_m->get_all_result("region_master","");
			$data['states']=$this->basic_operation_m->get_all_result('state','');	
			$data['city']=$this->basic_operation_m->get_all_result('city','');	
			$data['edit_cust_id']	=$customer_id;
			$whr =array('rate_id'=>$id);
			$data['domestic_rate']=$this->basic_operation_m->get_table_row('tbl_domestic_rate_master',$whr);
		}
		
		$this->load->view('admin/domestic_rate_master/view_edit_domestic_rate',$data);
	}
	public function delete_domestic_rate_single()
	{
// 		$data['message']="";     
		
		 $id = $this->input->post('getid');
		if($id!="")
		{
		    $row = $this->db->query("SELECT * FROM tbl_domestic_rate_master WHERE rate_id = '$id'")->row();
			$this->basic_operation_m->addLog($this->session->userdata("userId"),'Master Domestic Rate','Delete Single Domastic Rate Master',$row);
			$this->basic_operation_m->delete("tbl_domestic_rate_master",['rate_id'=>$id]);
		
			
           	$output['status'] = 'success';
			$output['message'] = 'Data deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Data';
		}
 
		echo json_encode($output);	
	}		
	public function update_domestic_rate($id,$customer_id)
	{  
		$alldata 	= $this->input->post();	
		$c_courier_id =$this->input->post('c_courier_id');
		$alldata['applicable_from']=date("Y-m-d",strtotime($alldata['applicable_from']) );	
		$applicable_from=date("Y-m-d",strtotime($alldata['applicable_from']) );

		$alldata['applicable_to']=date("Y-m-d",strtotime($alldata['applicable_to']) );
		
		if($alldata['fixed_perkg']>0)
		{
			$alldata['weight_slab'] = ((round($alldata['weight_range_to']) *1000) - (round($alldata['weight_range_from']) *1000));
		}

		// echo "<pre>";print_r($alldata);exit;
		if(!empty($alldata))
		{
			
			$delete = $this->db->delete('tbl_domestic_rate_master',['rate_id'=>$id]);  
			if($delete){
				$d_data		= $this->basic_operation_m->update_domestic_rate("tbl_domestic_rate_master",$alldata);
			}
		
			    // $this->basic_operation_m->update("tbl_domestic_rate_master",$alldata,"rate_id = '$id'");
			
			
			$this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Update Domastic Rate Master', $alldata);

			$msg	= 'Mode updated successfully';
			$class	= 'alert alert-success alert-dismissible';	
		}
		else
		{
			$msg	= 'Mode not updated successfully';
			$class	= 'alert alert-danger alert-dismissible';	
			
		}
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/view-domestic-rate/'.$customer_id.'/'.$c_courier_id.'/'.$applicable_from);
	
	}	
	public function delete_domestic_rate($customer_id,$courier_company_id,$db_applicable_from)
	{  
		$where =array('customer_id'=>$customer_id,'c_courier_id'=>$courier_company_id,'applicable_from'=>$db_applicable_from); 
		$this->basic_operation_m->delete("tbl_domestic_rate_master",$where);

		$this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Delete Domastic Rate Master', $where);
		$msg  = 'Mode deleted successfully';
		$class = 'alert alert-success alert-dismissible';	
			
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/view-add-domestic-rate');
	}
	//==========================state wise rate
	public function view_domestic_state_rate($z_id)
	{  
	   
		$data 		= $this->data;
		$user_id	= $this->session->userdata("userId");		
		$data['states']=$this->basic_operation_m->get_all_result('state','');
		$data['domestic_rate_list']	= $this->Rate_model->get_domestic_rate_list($z_id);	
		$data['domestic_state_rate_list'] = $this->Rate_model->get_domestic_state_rate_list($z_id);	
		$data['domestic_city_rate_list'] = $this->Rate_model->get_domestic_city_rate_list($z_id);	
			
		$data['z_id'] = $z_id;
        $this->load->view('admin/domestic_rate_master/view_domestic_state_rate',$data);
      
	}
	public function insert_domestic_state_rate()
	{  	   
		$alldata 	= $this->input->post();
		if(!empty($alldata))
		{
			$d_data		= $this->basic_operation_m->insert("tbl_domestic_state_rate",$alldata);			
			$msg		= 'Rate Inserted successfully';
			$class		= 'alert alert-success alert-dismissible';				
		}
		else
		{
			$msg			= 'Rate not Inserted';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/view-domestic-rate');
	}	
	public function insert_domestic_city_rate()
	{  	   
		$alldata 	= $this->input->post();	
		if(!empty($alldata))
		{
			$d_data		= $this->basic_operation_m->insert("tbl_domestic_city_rate",$alldata);			
			$msg			= 'Rate Inserted successfully';
			$class			= 'alert alert-success alert-dismissible';				
		}
		else
		{
			$msg			= 'Rate not Inserted';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/view-domestic-rate');
	}	
	public function getDomesticStateDetails()
	{ 
		$edit_id 	= $this->input->post('edit_id');	
		$data['d_state_rate_row'] = $this->basic_operation_m->get_all_result('tbl_domestic_state_rate',$edit_id);	

	}
	public function insert_transfer_rate()
	{  
		$sel_courier_id = $this->input->post('sel_courier_id');
		$db_applicable_from = $this->input->post('db_applicable_from');
		
		$customer_id = $this->input->post('transfer_customer_id');
	    $to_customer_id = $this->input->post('to_customer_id');
	    $user_id	= $this->session->userdata("userId");

	    $transfer_date = date("Y-m-d",strtotime($this->input->post('transfer_date') ) );
		//$whr = array('c_courier_id'=>$courier_id,'customer_id'=>$customer_id);
		//$whr = 'rate_master_id IN (1,2)';
		// print_r($_POST);die;
	    if($sel_courier_id[0]!="ALL"){

			$courier_id ="'".implode("','", $sel_courier_id)."'";
			//$whr = array('customer_id'=>$customer_id,'c_courier_id IN'=>$courier_id);
			$whr =" customer_id='$customer_id' AND c_courier_id IN ($courier_id) AND DATE(`applicable_from`)='$db_applicable_from' ";
		}else{
			//$whr = array('customer_id'=>$customer_id);
			$whr =" customer_id='$customer_id' ";
		}
		$rate_master = $this->basic_operation_m->get_all_result("tbl_domestic_rate_master",$whr);
		
		// echo "<pre>";print_r($to_customer_id);die;

		$this->Rate_model->insert_domestic_rate("tbl_domestic_rate_master",$rate_master,$to_customer_id,$transfer_date);
		// echo $this->db->last_query();die;
				
		$alldata = array(
			'customer_id'=>$customer_id,
			'to_customer_id'=>implode(",",$to_customer_id),
			'transfer_date'=>$transfer_date,
			'transfer_by'=>$user_id,
		);
		// echo "<pre>";print_r($alldata);
	    $this->basic_operation_m->insert("tbl_domestic_transfer_rate_history",$alldata);
	    $this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Add Domastic Transfer Rate Master', $alldata);

		$data['customer_list']	 = $this->basic_operation_m->get_all_result("tbl_customers",['isdeleted'=>0]);
		$data['edit_customer_id'] = $customer_id;

		if(!empty($alldata))
		{		
			$msg			= 'Rate Transfer successfully';
			$class			= 'alert alert-success alert-dismissible';		
		}else{
			$msg			= 'Rate not Transfer successfully';
			$class			= 'alert alert-danger alert-dismissible';	
		}	
		redirect('admin/view-add-domestic-rate');

	}
	/*public function show_my_weight_slab()
	{  
		//http://localhost/omcourier/Admin_domestic_rate_manager/show_my_weight_slab 
		
		$alldata 	= $this->basic_operation_m->get_all_result('tbl_domestic_rate_master','');			
		//echo "<pre>";print_r($alldata);		
		foreach($alldata AS $w)
		{
			if($w['fixed_perkg'] >0){
				echo "<br>----".$w['rate_id']."==".$w['fixed_perkg']."==".$weight_range_to = round((float)$w['weight_range_to']);
				echo "+++".$weight_range_from = round((float)$w['weight_range_from']);
				echo "***".$weight_slab = $w['weight_slab'];
				
				echo "#####".$calculated_weight_slab = ($weight_range_to - $weight_range_from)* 1000;
				
				$data=array('weight_slab'=>$calculated_weight_slab);
				$whr=array('rate_id'=>$w['rate_id']);
				$quer = $this->basic_operation_m->update('tbl_domestic_rate_master',$data,$whr);
				echo $this->db->last_query();
				//exit;
			}
		}
		//if($alldata['fixed_perkg']>0)
		//{
		//	$alldata['weight_slab'] = ((round((float)$alldata['weight_range_to']) *1000) - (round((float)$alldata['weight_range_from']) *1000));
		//}
	} */
	
   
}
?>
