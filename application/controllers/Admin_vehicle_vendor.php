<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_vehicle_vendor extends CI_Controller {

	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
		public function index()
	{		
        $data= array();		
		$resAct	= $this->db->query("select * from tbl_vehicle_vendor");		
		if($resAct->num_rows()>0)
		{
		 	$data['allcustomer']=$resAct->result_array();             
        }
       		 $this->load->view('admin/vehicle_vendor_master/view_vehicle_vendor',$data);   
	}

	
	public function add_vehicle_vendor()
	{      
	    
		$data['message']				= "";
		$array['airway_no_from'] 		= array();
		$array['airway_no_to'] 			= array();
		$array['branch_code'] 			= array();
		
		if(isset($_POST['submit']))
        {
           	$all_data = array(
				'name'=>$this->input->post('name'),
				'mobile_no'=>$this->input->post('mobile_no'),
				'email'=>$this->input->post('email'),
				'r_address' => $this->input->post('r_address'),
				'current_business' => $this->input->post('current_business'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'country_id' => $this->input->post('country_id'),
				'pin_code' => $this->input->post('pin_code'),
				'service_provider'=> $this->input->post('service_provider'),
				'credit_days' => $this->input->post('credit_days'),
				'document_no' => $this->input->post('document_no'),
				'statutory' => $this->input->post('statutory'),
				'vts'=>$this->input->post('vts'),
				'type_vehicle'=>$this->input->post('type_vehicle'),
				'bank_name' => $this->input->post('bank_name'),
				'account_no' => $this->input->post('account_no'),
				'ifsc_code' => $this->input->post('ifsc_code'),
				
				);
		         $v = $this->input->post('document_file');
				if(isset($_FILES) && !empty($_FILES['document_file']['name']))
				{
					$ret = $this->basic_operation_m->fileUpload($_FILES['document_file'],'assets/vehicle_vendor_upload/');
			 	//file is uploaded successfully then do on thing add entry to table
					if($ret['status'] && isset($ret['image_name']))
					{
						$all_data['document_file'] = $ret['image_name'];
						
					}
				}
            
			unset($all_data['submit']);
			$result=$this->basic_operation_m->insert('tbl_vehicle_vendor',$all_data);
			if ($result) {
                 
				$user_id = $this->db->insert_id();
				$branch = $this->input->post('branch');
				for ($i = 0; $i < count($branch); $i++) {
					$value = [
						'v_id' => $user_id,
						'branch_name' => $branch[$i]
					];
					$query = $this->basic_operation_m->insert('tbl_vendor_branch', $value); 
				}
				
			
               }
			if($this->db->affected_rows()>0) 
			{
				$data['message']="cnode Added Sucessfully";
			}
			else
			{
                $data['message']="Error in Query";
			}
				redirect('admin/view-vehicle-vendor');
		}
		  $data['country']	= $this->basic_operation_m->get_all_result('tbl_country', '');
		  $data['vehicle']	= $this->basic_operation_m->get_all_result('vehicle_type_master', '');
		 $this->load->view('admin/vehicle_vendor_master/view_add_vehicle_vendor',$data);
	}
	
		public function edit_vehicle_vendor($vehicle_id)
	{
	
	   
		if(isset($_POST['submit'])) 
		{
			$all_data = array(
				'name'=>$this->input->post('name'),
				'mobile_no'=>$this->input->post('mobile_no'),
				'email'=>$this->input->post('email'),
				'r_address' => $this->input->post('r_address'),
				'current_business' => $this->input->post('current_business'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'country_id' => $this->input->post('country_id'),
				'pin_code' => $this->input->post('pin_code'),
				'service_provider'=> $this->input->post('service_provider'),
				'credit_days' => $this->input->post('credit_days'),
				'document_no' => $this->input->post('document_no'),
				'statutory' => $this->input->post('statutory'),
				'vts'=>$this->input->post('vts'),
				'type_vehicle'=>$this->input->post('type_vehicle'),
				'bank_name' => $this->input->post('bank_name'),
				'account_no' => $this->input->post('account_no'),
				'ifsc_code' => $this->input->post('ifsc_code'),
				
				);
		         $v = $this->input->post('document_file');
				if(isset($_FILES) && !empty($_FILES['document_file']['name']))
				{
					$ret = $this->basic_operation_m->fileUpload($_FILES['document_file'],'assets/vehicle_vendor_upload/');
			 	//file is uploaded successfully then do on thing add entry to table
					if($ret['status'] && isset($ret['image_name']))
					{
						$all_data['document_file'] = $ret['image_name'];
						
					}
				}
            $whr = array('id'=>$vehicle_id ); 
			$result=$this->basic_operation_m->update('tbl_vehicle_vendor',$all_data, $whr);
// 			echo $this->db->last_query();die();
			if ($this->db->affected_rows() > 0) 
			{
				$data['message']="Cnode Updated Sucessfully";
			}
			else
			{
                $data['message']="Error in Query";
			}
            redirect('admin/view-vehicle-vendor');
		}
		$data['value'] =$this->basic_operation_m->getAll('tbl_vehicle_vendor',"id = '$vehicle_id'")->row_array();
       $data['country']	= $this->basic_operation_m->get_all_result('tbl_country', '');
		  $data['vehicle']	= $this->basic_operation_m->get_all_result('vehicle_type_master', '');
	    $this->load->view('admin/vehicle_vendor_master/view_edit_vehicle_vendor',$data);
	}

	
	public function delete_vehicle_vendor_type()
	{
		//$data['message']="";
        $id = $this->input->post('getid');
	    
		if($id!="")
		{
		    $whr =array('id'=>$id);
			$res=$this->basic_operation_m->delete('tbl_vehicle_vendor',$whr);
			
				$output['status'] = 'success';
			    $output['message'] = 'Branch deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Branch';
		}
 
		echo json_encode($output);	
			
            // redirect('admin/view-branch');
		}		
	
	
	
	
}
?>