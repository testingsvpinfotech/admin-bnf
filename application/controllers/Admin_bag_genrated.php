<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_bag_genrated extends CI_Controller
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
		$ress					=	$this->basic_operation_m->getAll('tbl_domestic_bag_ganrate', '');
		$data['result']		= 	$ress->result();
		$this->load->view('admin/Bagmaster/view_baggenrated', $data);
	}



	public function add_bag()
	{
		//  search pod 
		if ($this->input->post('awb_no')) {
			$value = $this->input->post('awb_no');
			$where = array('pod_no' => $value);
			$ress					=	$this->basic_operation_m->getAll('tbl_domestic_booking', $where);
			$data['result']		= 	$ress->result();
		}

		if ($this->input->post('pod_no')) {
			$valu = $this->input->post('pod_no');
			$where = array('pod_no' => $valu);
			$ress					=	$this->basic_operation_m->getAll('tbl_domestic_bag_ganrate', $where);
			$val		= 	$ress->result();
			if (empty($val)) {
				$menifestid = $this->db->query('select max(id) AS id from tbl_domestic_bag_ganrate')->row();
				$bag = $menifestid->id + 1;
				if (strlen($bag) == 2) {
					$bag = 'BAG00' . $bag;
				} else if (strlen($bag) == 3) {
					$bag = 'BAG0' . $bag;
				} else if (strlen($bag) == 1) {
					$bag = 'BAG000' . $bag;
				} else if (strlen($bag) == 4) {
					$bag = 'BAG' . $bag;
				}
				$username			= $this->session->userdata("userName");
				$whr 				= array('username'=>$username);
				$res				= $this->basic_operation_m->getAll('tbl_users',$whr);
				$branch_id			= $res->row()->branch_id;
			
				$whr 				= 	array('branch_id'=>$branch_id);
				$res				=	$this->basic_operation_m->getAll('tbl_branch',$whr);
				$branch_name		= 	$res->row()->branch_name;
				$all_data = array(
					'bag_no ' => $bag,
					'origin' => $branch_name,
					'bag_genrated' => $this->input->post('datetime'),
					'bag_name' => $this->input->post('bag_name'),
					'lorry_no' => $this->input->post('lorry_no'),
					'driver_name' => $this->input->post('driver_name'),
					'destination_branch' => $this->input->post('destination_branch'),
					'forwarder_mode' => $this->input->post('forwarder_mode'),
					'route_id' => $this->input->post('route_id'),
					'genrated_by' => $this->input->post('username'),
					'pod_no' => $this->input->post('pod_no'),
					'sender_name' => $this->input->post('sender_name'),
					'mode_name' => $this->input->post('mode_name'),
					'booking_date' => $this->input->post('booking_date'),
					'forworder_name' => $this->input->post('forworder_name'),
					'forwording_no' => $this->input->post('forwording_no'),
					'dispatch_details' => $this->input->post('dispatch_details'),
				);
				$result2	=	$this->basic_operation_m->insert('tbl_domestic_bag_ganrate', $all_data);
				if ($result2) {

					$msg = 'Bag Genrated successfully';
					$class	= 'alert alert-success alert-dismissible';

					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
				} else {
					$msg = 'Something went wrong in deleting the Fule';
					$class	= 'alert alert-success alert-dismissible';

					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
				}
				redirect('admin/add-bag-genrate');
			} else {
				$msg = 'Bag already Genrated';
				$class	= 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/add-bag-genrate');
			}
		}

		$data['all_branch'] = $this->basic_operation_m->get_all_result('tbl_branch', "");
		$data['allroute'] = $this->basic_operation_m->get_all_result('route_master', "");
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', "");

		$this->load->view('admin/Bagmaster/bag_genrator', $data);
	}




	
}
