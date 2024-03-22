<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_change_delivery_branch extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}

	public function index()
	{
		$data = array();
		
		$search = $this->input->post('pod_no');
		if ($search) {
			//$whr3 = array('manifiest_id'=>$search,'gatepass' => '0','source_branch'=> $source_branch);
			$ress = $this->db->query("select tbl_domestic_stock_history.*,tbl_domestic_booking.sender_city,tbl_domestic_booking.reciever_city from tbl_domestic_stock_history join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no  where tbl_domestic_stock_history.pod_no = '$search'");
			$data['result']		= 	$ress->row();
			// echo $this->db->last_query();die;
			// echo '<pre>';print_r($data);die;
		}
		$this->load->view('admin/change_delivery_branch/change_delivery_branch', $data);
	}
	public function insert_delivery()
	{
			
		$search = $this->input->post('pod_no');
		$branch_name = $this->input->post('branch_name');
		if ($search) {
			$queue_dataa1 = "update tbl_domestic_stock_history set delivery_branch ='$branch_name' where pod_no = '$search'";
			$result5	= $this->db->query($queue_dataa1);
			if ($result5) {
				$msg = 'Branch Change successfully';
				$class	= 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				
				
			} else {
				
				$msg = 'Something went wrong ';
				$class	= 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/change-delivery-branch');
		}
	}

	
}
