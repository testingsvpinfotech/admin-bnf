<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_role_master extends CI_Controller{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Zone_model');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
	public function add_role()
	{
        $data					= array();
        if (isset($_POST['submit'])) 
		{
		    	$dd['role_name'] = $this->input->post('role_name');	
					
			$data =	$this->basic_operation_m->insert('tbl_role_master',$dd);
				// echo $this->db->last_query();die();
			    $insert_id = $this->db->insert_id();
			    	$view = $this->input->post('view');	
			    	$add = $this->input->post('add');	
			    	$edit = $this->input->post('edit');	
			    	$delete = $this->input->post('delete');	
			     for ($i=0; $i <count($view) ; $i++) { 
								 $r_detail= array(
									  'role_id' => $insert_id,   
									  'view' => $view[$i],   
									  'add_view' => $add[$i],                   
									  'edit_view' => $edit[$i],                   
									  'delete_view' => $delete[$i],                   
								  );
								  $result = $this->basic_operation_m->insert('tbl_role_master_custome',$r_detail);
						
					}
		}
		$data['menu']	= $this->basic_operation_m->get_query_result_array('select * from all_menu');  
        $this->load->view('admin/Role_master/view_add_role',$data);
	}
	

	
}

?>