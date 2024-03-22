<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_modewise_pincode_manager extends CI_Controller  {

	var $data = array();
    function __construct() 
	{
        parent :: __construct();
        $this->load->model('basic_operation_m'); 
        $this->load->model('Rate_model');   
        $this->load->model('booking_model');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}

    }


	
	
	public function view_upload_domestic_shipment()
	{
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$this->load->view('admin/modewise_pincode/view_upload_domestic_shipment',$data);
	}
	public function add_modepincode()
	{
		if(! empty($_POST)){
			$data = array(
             'date_time'=>$_POST['date_time'],
             'mode'=>$_POST['mode_dispatch'],
             'pincode'=>$_POST['pincode'],
             'regularoda'=>$_POST['type']
			);
			$this->basic_operation_m->insert('tbl_mode_wise_pincode', $data);
			$msg   = 'Pincode Add successfully.';
			$class = 'alert alert-success alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			redirect('admin/add-modewise-pincode');
		}
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$this->load->view('admin/modewise_pincode/addmodepincode',$data);
	}

	public function modepincodelist($id = 0)
	{   
		// $data ='';
		if(! empty($id)){
			$data['pincode'] = $this->db->query("select * from tbl_mode_wise_pincode where mode = '$id'")->result();
		}
		
		$this->load->view('admin/modewise_pincode/modepincodelist',$data);
	}
	public function edit_mode_pincode($id = 0)
	{   
		if(! empty($_POST)){
			$data = array(
             'date_time'=>$_POST['date_time'],
             'mode'=>$_POST['mode_dispatch'],
             'pincode'=>$_POST['pincode'],
             'regularoda'=>$_POST['type']
			);
			$where = array('id'=>$id);
			$this->basic_operation_m->update('tbl_mode_wise_pincode', $data,$where);
			$msg   = 'Pincode Update successfully.';
			$class = 'alert alert-success alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			redirect('admin/modewise-pincode/'.$_POST['mode_dispatch']);
		}
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$data['pincode'] = $this->db->query("select * from tbl_mode_wise_pincode where id = '$id'")->row();
		$this->load->view('admin/modewise_pincode/editmodepincode',$data);
	}

	public function delete_pincode() 
	{
			$id = $this->input->post('getid');
		if ($id != "") {
			$whr = array('id' => $id);
			$res = $this->basic_operation_m->delete('tbl_mode_wise_pincode', $whr);

			 	$output['status'] = 'success';
			$output['message'] = 'Pincode deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Shipment';
		}
 
		echo json_encode($output);	
	}
	public function upload_domestic_shipment()
	{
		$data = [];			
		$username = $this->session->userdata("userName");
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");
		
		$extension = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
		if($extension!="csv")
		{	
			$msg			= 'Please uploade csv file.';
			$class			= 'alert alert-danger alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			
			
		}else{
			$mode_dispatch = $this->input->post('mode_dispatch');
			$date_time = $this->input->post('date_time');
			$file = fopen($_FILES['uploadFile']['tmp_name'],"r");
			$heading_array = array();
			$cnt = 0;
				// print_r(fgetcsv($file));die;
			while(!feof($file))
			{  $cnt++;
				$data	= fgetcsv($file);			
				if(!empty($data))
				{	 
				 	if($data[1] != "Pincode")
				  	{
						$data3 = array(
						'date_time' => $date_time,
						'mode' => $mode_dispatch,
						'pincode' => $data[1],
						'regularoda' => $data[2]
						);
					$this->basic_operation_m->insert('tbl_mode_wise_pincode', $data3);
					}
				}
				
				$msg   = 'File uploaded successfully..';
				$class = 'alert alert-success alert-dismissible';	
				$this->session->set_flashdata('notify',$msg);
				$this->session->set_flashdata('class',$class);
			}
			redirect('admin/view-upload-modewise-pincode');
		}
  	}
	
	

}

?>
