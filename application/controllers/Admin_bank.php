<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_bank extends CI_Controller {

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
		$resAct	= $this->db->query("select * from bank_master");		
		if($resAct->num_rows()>0)
		{
		 	$data['allvehicletype']=$resAct->result_array();             
        }
        $this->load->view('admin/Bank_Master/view_bank',$data);       
	}

	
	public function add_bank()
	{      
       
		$data['message']				= "";
		$array['airway_no_from'] 		= array();
		$array['airway_no_to'] 			= array();
		$array['branch_code'] 			= array();
		
		if(isset($_POST['submit']))
        {
            $all_data = $this->input->post();
			unset($all_data['submit']);
			$result=$this->basic_operation_m->insert('bank_master',$all_data);
			if($this->db->affected_rows()>0) 
			{
				$data['message']="cnode Added Sucessfully";
			}
			else
			{
                $data['message']="Error in Query";
			}
				redirect('admin/view-bank');
		}
		 $this->load->view('admin/Bank_Master/view_bank',$data);
	}
	
		public function edit_bank($vehicle_id)
	{
		$data['message']="";
		$resAct=$this->basic_operation_m->getAll('bank_master',"id = '$vehicle_id'");
		if($resAct->num_rows()>0)
		{
			$data['vehicle_info']=$resAct->row();
		} 
	   
		if(isset($_POST['submit'])) 
		{
			$all_data = $this->input->post();
			unset($all_data['submit']);
			$whr =array('id'=>$vehicle_id);
			$result=$this->basic_operation_m->update('bank_master',$all_data, $whr);
			if ($this->db->affected_rows() > 0) 
			{
				$data['message']="Cnode Updated Sucessfully";
			}
			else
			{
                $data['message']="Error in Query";
			}
            redirect('admin/view-bank');
		}
	    $this->load->view('admin/Bank_Master/edit_bank',$data);
	}

	public function delete_bank()
	{
	    $id = $this->input->post('getid');
// 		$data['message']="";
		if($id!="")
		{
		    $whr =array('id'=>$id);
			$res=$this->basic_operation_m->delete('bank_master',$whr);
		//	echo $this->db->last_qurey();die();
			$output['status'] = 'success';
			$output['message'] = 'Fule deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Fule';
		}
 
		echo json_encode($output);		
	  
	}
	
	
	
	
}
?>