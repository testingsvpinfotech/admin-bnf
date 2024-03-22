<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_franchise_fuel extends CI_Controller {

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


	public function index()
    {
        if (isset($_POST['submit'])) {
            $all_data = $this->input->post();
			$resAct    = $this->db->query("select * from tbl_rate_group_master where group_name = '".$all_data['group_name']."' AND groups_id = '2'")->row();
            if($resAct->group_name == $this->input->post('group_name') ){
                $msg = "Fuel group Name Already Exists!";
                $class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/fule-group-master');
            }
            unset($all_data['submit']);
            $data = [
                'groups_id'=>'2',
				'group_name'=>$this->input->post('group_name'),
				'booking_bill_type'=>$this->input->post('booking_bill_type'),
				'created_at'=>date('Y-m-d H:i:s')
			];
			$result = $this->db->insert('tbl_rate_group_master', $data);
            if ($this->db->affected_rows() > 0) {
                $msg = "Rate group Added Sucessfully";
                $class = 'alert alert-success alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
            } else {
                $data['message'] = "Error in Query";
            }
            redirect('admin/fule-group-master');
        }
        $data = array();
        $resAct    = $this->db->query("select * from tbl_rate_group_master where groups_id ='2' ");
        if ($resAct->num_rows() > 0) {
            $data['allvehicletype'] = $resAct->result_array();
        }

        $this->load->view('admin/franchise_fuel_master/add_fuel_group_name', $data);
    }
	
	
	###################### View All Airlines Start ########################
	public function all_fuel()
	{  
	   
		$data 							= $this->data;
		$user_id						= $this->session->userdata("userId");
		$data['fule_company']			= $this->basic_operation_m->get_query_result("select franchise_fule_tbl.*, tbl_rate_group_master.group_name as group_name from franchise_fule_tbl left join tbl_rate_group_master on tbl_rate_group_master.id = franchise_fule_tbl.group_id Group By franchise_fule_tbl.fuel_id");
	
        $this->load->view('admin/franchise_fuel_master/view_fuel',$data);
      
	}
	
	public function addfuel()
	{  		
		$data['all_customer']		= $this->db->query("select * from tbl_rate_group_master where groups_id = 2 ")->result_array();
        $this->load->view('admin/franchise_fuel_master/view_add_fuel',$data);
      
	}
	
	public function insertfuel()
	{  
		// if(isset($_POST['save'])){
			//print_r($_POST);exit;
		$data = array(
			// 'fov_rate'=>$this->input->post('fov_rate'),
			'fov_min'=>$this->input->post('fov_min'),
			'fov_above'=>$this->input->post('fov_above'),
			'fov_below'=>$this->input->post('fov_below'),
			'fov_base'=>$this->input->post('fov_base'),
			'awb_rate'=>$this->input->post('awb_rate'),
			'topay_rate'=>$this->input->post('topay_rate'),
			'cod_percentage'=>$this->input->post('cod_percentage'),
			'fule_percentage'=>$this->input->post('fule_percentage'),
			'cod_min'=>$this->input->post('cod_min'),
			'group_id'=>$this->input->post('cf_id'),
			'from_date'=>$this->input->post('from_date'),
			'to_date'=>$this->input->post('to_date'),
		);

		//print_r($data);exit;
		$res = $this->db->insert('franchise_fule_tbl',$data);
		// echo $this->db->last_query();die;

		if($res){
			$msg					= 'Franchise Fuel Add successfully';
			$class					= 'alert alert-success alert-dismissible';	
			
		}
		else
		{
			$msg			= 'Fuel not Add successfully';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/all-franchise-fuel');
	// }
 }
	public function updatefuel($id)
	{  
		if(!empty($id)){
			// print_r($_POST);exit;
		$data = array(
				// 'fov_rate'=>$this->input->post('fov_rate'),
				'fov_min'=>$this->input->post('fov_min'),
				'fov_above'=>$this->input->post('fov_above'),
				'fov_below'=>$this->input->post('fov_below'),
				'fov_base'=>$this->input->post('fov_base'),
				'awb_rate'=>$this->input->post('awb_rate'),
				'topay_rate'=>$this->input->post('topay_rate'),
				'cod_percentage'=>$this->input->post('cod_percentage'),
				'fule_percentage'=>$this->input->post('fule_percentage'),
				'cod_min'=>$this->input->post('cod_min'),
				'group_id'=>$this->input->post('cf_id'),
				'from_date'=>$this->input->post('from_date'),
				'to_date'=>$this->input->post('to_date'),
		);

		//print_r($data);exit;
		// $res = $this->db->insert('franchise_fule_tbl',$data);
		$res = $this->db->update('franchise_fule_tbl',$data,['fuel_id'=>$id]);

		if($res){
			$msg					= 'Franchise Fuel Update successfully';
			$class					= 'alert alert-success alert-dismissible';	
			
		}
		else
		{
			$msg			= 'Fuel Not Update successfully';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/all-franchise-fuel');
	}
 }
	
	public function deletefuel()
	{  
	     $id = $this->input->post('getid');
		if(!empty($id))
		{
			$airlines_company		= $this->basic_operation_m->delete("franchise_fule_tbl","fuel_id = '$id'");
			//$airlines_company		= $this->basic_operation_m->delete("franchise_fuel_detail","cf_id = '$id'");

			$output['status'] = 'success';
			$output['message'] = 'Fule deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Fule';
		}
 
		echo json_encode($output);	
	}
	
	public function editfuel($id)
	{  
		$data				 				= $this->data;
		if(!empty($id))
		{
			$data['all_customer']		= $this->db->query("select * from tbl_rate_group_master where groups_id = '2' ")->result_array();
			$data['fuel']		= $this->db->query("select * from franchise_fule_tbl  where fuel_id = '$id'")->row();	
			
		}
		$this->load->view('admin/franchise_fuel_master/view_edit_fuel',$data);
	}
	
	
	
	
	###################### View All Airlines End ########################	
	
	
   
}
?>
