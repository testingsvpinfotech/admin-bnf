<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_mis_rute extends CI_Controller {

	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
		public function mis_rute()
	{	 
        $data= array();
		$awb = $this->input->post('awb_no');
		$submit = $this->input->post('awb');
	    if($awb){ 
			$where = array('pod_no'=>$awb);
			$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking',$where);
		}
	    if($submit){ 
			$where = array('pod_no'=>$submit);
			$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking',$where);
			$all_data['pod_no']= $this->input->post('awb');
			$all_data['booking_id']= $data['result'][0]['booking_id'];
			$all_data['forwording_no']= $data['result'][0]['forwording_no'];
			$all_data['forworder_name']= $data['result'][0]['forworder_name'];
			$all_data['branch_name']= $this->input->post('branch');
			$all_data['status']= 'MIS-RUTE';
			// print_r($all_data);die();
			
			if($this->basic_operation_m->insert('tbl_domestic_tracking',$all_data))
				{
					
					$msg = 'Scanning successfully';
					$class	= 'alert alert-success alert-dismissible';	
				
					$this->session->set_flashdata('notify',$msg);
					$this->session->set_flashdata('class',$class);
				}
				else{
					$msg = 'Something went wrong in deleting the Fule';
					$class	= 'alert alert-success alert-dismissible';	
				
					$this->session->set_flashdata('notify',$msg);
					$this->session->set_flashdata('class',$class);
				}
				redirect('admin/mis-rute');
		}

        $this->load->view('admin/mis_rute/mis_rute_add',$data);       
	}


	
	
}
?>