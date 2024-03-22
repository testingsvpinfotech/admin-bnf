<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_coloader extends CI_Controller {

	var $data 			= array();
	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
	
	###################### View All Airlines Start ########################
	public function all_coloader()
	{  
	   
		$data 							= $this->data;
		$user_id						= $this->session->userdata("userId");
		$data['fule_company']			= $this->basic_operation_m->get_query_result("select * from tbl_coloader");
        $this->load->view('admin/coloader_master/view_coloader',$data);
      
	}
	
	public function add_coloader()
	{  
	   
		$data 						= $this->data;	
		$user_id					= $this->session->userdata("userId");

		$data['city']			= $this->basic_operation_m->get_query_result("select * from city");
        $this->load->view('admin/coloader_master/view_add_coloader',$data);
      
	}
	
	public function insert_coloader()
	{  
	   
		$alldata 							= $this->input->post();

		// echo "<pre>";
		// print_r($alldata);exit();
		if(!empty($alldata))
		{
			$alldata2 = array(
				'coloader_name' => $alldata['coloader_name'],
				'company_name' => $alldata['company_name'],
				'company_add' => $alldata['company_add'],
				'company_contact' => $alldata['company_contact'],
				'contact_person' => $alldata['contact_person'],
				'gst_no' => $alldata['gst_no'],
				// 'min_rate' => $alldata['min_rate'],
				// 'location' => $alldata['location'],
				// 'per_kg_rate' => $alldata['per_kg_rate'],
			);
			$coloader_list		= $this->basic_operation_m->insert("tbl_coloader",$alldata2);

			$coloader_id = $this->db->insert_id();

			$datec = date('Y-m-d h:i:s');

			if (!empty(@$alldata['from_city'])) {
				foreach ($alldata['from_city'] as $key => $value) {
					$data = array(
						'coloader_id' => $coloader_id,
						'from_city' => $value,
						'to_city' => $alldata['to_city'][$key],
						'min_amt' => $alldata['min_amount'][$key],
						'per_kg_rate' => $alldata['per_kg'][$key],
						'applicable_date' => date('Y-m-d',strtotime($alldata['applicable_date'][$key])),
						'datec' => $datec,
					);

					$this->basic_operation_m->insert("coloader_rate",$data);
				}
			}

			$msg					= 'Coloader uploaded successfully';
			$class					= 'alert alert-success alert-dismissible';	
			
		}
		else
		{
			$msg			= 'Coloader not uploaded successfully';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/all-coloader');
	}

	public function add_rate($coloader_id)
	{  
	   
		$alldata 							= $this->input->post();

		echo "<pre>";
		// print_r($alldata);exit();
		if(!empty($alldata))
		{
		
			$datec = date('Y-m-d h:i:s');
			if (!empty(@$alldata['from_city'])) {
				foreach ($alldata['from_city'] as $key => $value) {
					$data = array(
						'coloader_id' => $coloader_id,
						'from_city' => $value,
						'to_city' => $alldata['to_city'][$key],
						'min_amt' => $alldata['min_amount'][$key],
						'per_kg_rate' => $alldata['per_kg'][$key],
						'applicable_date' => date('Y-m-d',strtotime($alldata['applicable_date'][$key])),
						'datec' => $datec,
					);

					$this->basic_operation_m->insert("coloader_rate",$data);

					print_r($data);
				}
			}

			$msg					= 'Coloader uploaded successfully';
			$class					= 'alert alert-success alert-dismissible';	
			
		}
		else
		{
			$msg			= 'Coloader not uploaded successfully';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/all-coloader');
	}
	
	public function delete_coloader()
	{
	    $id = $this->input->post('getid');
		$deleteColoader		= $this->db->delete("tbl_coloader", array('id' => $id));
		
		if($deleteColoader){
		    
    		$output['status'] = 'success';
			$output['message'] = 'coloader deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the coloader';
		}
 
		echo json_encode($output);	
	}
	
	
// 	public function delete_coloader($id)
// 	{
// 		$airlines_company		= $this->basic_operation_m->delete("tbl_coloader","id = '$id'");
// 		$msg					= 'Coloader deleted successfully';
// 		$class					= 'alert alert-success alert-dismissible';	
			
// 		$this->session->set_flashdata('notify',$msg);
// 		$this->session->set_flashdata('class',$class);
		
// 		redirect('admin/all-coloader');
// 	}
	
	public function edit_coloader($id)
	{  
		$data	= $this->data;
		if(!empty($id))
		{		
			$data['coloader_list']		= $this->basic_operation_m->get_query_row("select * from tbl_coloader where id = '$id'");			
			$data['city_rate_list']		= $this->basic_operation_m->get_table_result("coloader_rate","coloader_id = '$id'");

			$data['city'] = $this->basic_operation_m->get_query_result("select * from city");
		}
		$this->load->view('admin/coloader_master/view_edit_coloader',$data);
	}

	public function detail_coloader($id)
	{  
		$data	= $this->data;
		if(!empty($id))
		{		
			$data['coloader_list']		= $this->basic_operation_m->get_query_row("select * from tbl_coloader where id = '$id'");			
			$data['city_rate_list']		= $this->basic_operation_m->get_table_result("coloader_rate","coloader_id = '$id'");

			$data['city'] = $this->basic_operation_m->get_query_result("select * from city");
		}
		$this->load->view('admin/coloader_master/view_detail_coloader',$data);
	}
	
	public function update_coloader($id)
	{ 
		$alldata = $this->input->post();
		if(!empty($alldata))
		{
			$alldata2 = array(
				'coloader_name' => $alldata['coloader_name'],
				'company_name' => $alldata['company_name'],
				'company_add' => $alldata['company_add'],
				'company_contact' => $alldata['company_contact'],
				'contact_person' => $alldata['contact_person'],
				'gst_no' => $alldata['gst_no'],
				// 'min_rate' => $alldata['min_rate'],
				// 'location' => $alldata['location'],
				// 'per_kg_rate' => $alldata['per_kg_rate'],
			);
			$status= $this->basic_operation_m->update("tbl_coloader",$alldata2,"id = '$id'");


			$datec = date('Y-m-d h:i:s');

			$this->db->delete('coloader_rate',array('coloader_id'=>$id));

			if (!empty(@$alldata['from_city'])) {
				foreach ($alldata['from_city'] as $key => $value) {
					$data = array(
						'coloader_id' => $id,
						'from_city' => $value,
						'to_city' => $alldata['to_city'][$key],
						'min_amt' => $alldata['min_amount'][$key],
						'per_kg_rate' => $alldata['per_kg'][$key],
						'applicable_date' => date('Y-m-d',strtotime($alldata['applicable_date'][$key])),
						'datec' => $datec,
					);

					// $this->basic_operation_m->insert("coloader_rate",$data);
				}
			}			
			$msg							= 'Coloader updated successfully';
			$class							= 'alert alert-success alert-dismissible';	
		}
		else
		{
			$msg	= 'Coloader not updated successfully';
			$class	= 'alert alert-danger alert-dismissible';	
			
		}			
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);		
		redirect('admin/all-coloader');
	
	}



	public function update_city_rate()
	{ 
		$alldata = $this->input->post();
		if(!empty($alldata))
		{
			$datec = date('Y-m-d h:i:s');
			$clr_id = $alldata['clr_id'];
			$data = array(
				// 'coloader_id' => $id,
				'from_city' => $alldata['from_city'],
				'to_city' => $alldata['to_city'],
				'min_amt' => $alldata['min_amount'],
				'per_kg_rate' => $alldata['per_kg'],
				'applicable_date' => date('Y-m-d',strtotime($alldata['applicable_date'])),
				'last_update' => $datec,
			);
			$status= $this->basic_operation_m->update("coloader_rate",$data,"clr_id = '$clr_id'");


			

						
			$msg							= 'Coloader updated successfully';
			$class							= 'alert alert-success alert-dismissible';

			echo "1";	
		}
		else
		{
			$msg	= 'Coloader not updated successfully';
			$class	= 'alert alert-danger alert-dismissible';	
			echo "0";
			
		}			
		
				
		// redirect('admin/all-coloader');
	
	}


	
	public function CD_inscan_pending(){
		$username = $this->session->userdata("userName");
		$user_type = $this->session->userdata("userType");
		$branch_id = $this->session->userdata("branch_id");
		$whr = array('username' => $username);
		$whr1 = array('branch_id'=>$branch_id);
		$res=$this->basic_operation_m->getAll('tbl_branch',$whr1);
		$branch_name= $res->row()->branch_name;
	   if($user_type=='1'){
		$data['pod']			= $this->db->query("select * from tbl_domestic_menifiest where cd_status = '0'")->result();
	   }else{
		$data['pod']			= $this->db->query("select * from tbl_domestic_menifiest where cd_status = '0' and destination_branch='$branch_name'")->result();
	   }

		
        $this->load->view('admin/CD_no_coloader/view_CD_inscan_pending',$data);
		
	}
	public function CDno_inscan(){
		$data 						= $this->data;	
		$user_id					= $this->session->userdata("userId");


		$username = $this->session->userdata("userName");
		$user_type = $this->session->userdata("userType");
		$branch_id = $this->session->userdata("branch_id");
		$whr = array('username' => $username);
		$whr1 = array('branch_id'=>$branch_id);
		$res=$this->basic_operation_m->getAll('tbl_branch',$whr1);
		$branch_name= $res->row()->branch_name;
	   if($user_type=='1'){
		$data['pod']			= $this->db->query("select * from tbl_domestic_menifiest where cd_status = '1'")->result();
	   }else{
		$data['pod']			= $this->db->query("select * from tbl_domestic_menifiest where cd_status = '1' and destination_branch='$branch_name'")->result();
	   }

		
        $this->load->view('admin/CD_no_coloader/view_CD_inscan',$data);
		
	}





	public function incoming_cdno($id='')
	{
		$data['message']="";//for branch code
		$data['menifiest_data']="";//for branch code
		$data['manifiest_id']="";//for branch code
		
		$username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
		
	
		 $resAct=$this->db->query("select distinct manifiest_id,date_added ,cd_no from tbl_domestic_menifiest where destination_branch='$branch_name'");
        if($resAct->num_rows()>0)
        {
			$data['menifiest']=$resAct->result();
        }
		
	
       	$data['branch_name']=$branch_name;
      // echo $this->db->last_query();
	  
	  if(!empty($id))
	  {
		  $form_data 		= $this->input->post();
			
			
			 $username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
			 $date=date('y-m-d');
			 
		
			
			$mid=$id;
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' and manifiest_id='$mid' ");
			$data['menifiest_data']=$res->result();
	  }
		
		if (isset($_POST['submit']) ) 
		{
			$form_data 		= $this->input->post();
			
			
			 $username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
			 $date=date('y-m-d');
			 
		
			
			$mid=$this->input->post('manifiest_id');
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' and manifiest_id='$mid' ");
			$data['menifiest_data']=$res->result();
			
		}
	
		if(isset($_POST['receving'])) 
		{
			$all_data 		= $this->input->post();
			$date			= $this->input->post('datetime');
		
			$username	=	$this->session->userdata("userName");
			$whr 		= 	array('username'=>$username);
			$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);
			$branch_id	= 	$res->row()->branch_id;
			


			$whr		= 	array('branch_id'=>$branch_id);
			$res		=	$this->basic_operation_m->getAll('tbl_branch',$whr);
			$branch_name= 	$res->row()->branch_name;
			
			if(!empty($all_data))
			{
				$manifiest_id			= $all_data['manifiest_id'];
				$resAct		=	$this->db->query("update tbl_domestic_menifiest set cd_status = '1', cd_recived_by = '$username' ,cd_recived_date ='$date' where manifiest_id ='$manifiest_id'");
				
			}
			redirect('admin/cdno-inscan');
			
		}
		
		
		$this->load->view('admin/CD_no_coloader/addincomingcdno', $data);
	}
	
	
	###################### View All Airlines End ########################	
	
	
   
}
?>
