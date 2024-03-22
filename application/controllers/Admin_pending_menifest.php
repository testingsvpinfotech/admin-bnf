<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_pending_menifest extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		$this->load->model('generate_pod_model');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}

	public function index()
	{
		$username = $this->session->userdata("userName");
		$user_id = $this->session->userdata("userId");
		$whr	 = array('username' => $username);
		$res	=	$this->basic_operation_m->getAll('tbl_users', $whr);

		$branch_id = $res->row()->branch_id;

		$whr		= 	array('branch_id' => $branch_id);
		$res		=	$this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = 	$res->row()->branch_name;
		if ($user_id == '1') {
			// $resAct = $this->db->query("SELECT tbl_domestic_bag.* FROM tbl_domestic_menifiest INNER JOIN tbl_domestic_bag ON tbl_domestic_menifiest.bag_no=tbl_domestic_bag.bag_id WHERE tbl_domestic_bag.bag_recived='1' ORDER BY tbl_domestic_bag.id");
			$resAct = $this->db->query("SELECT tbl_domestic_bag.* FROM tbl_domestic_menifiest INNER JOIN tbl_domestic_bag ON tbl_domestic_menifiest.bag_no=tbl_domestic_bag.bag_id INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no = tbl_domestic_bag.pod_no  WHERE tbl_domestic_bag.bag_recived='1' AND tbl_domestic_booking.is_delhivery_complete = '0' ORDER BY tbl_domestic_bag.id");
		} else {
			$resAct = $this->db->query("SELECT tbl_domestic_bag.* FROM tbl_domestic_menifiest INNER JOIN tbl_domestic_bag ON tbl_domestic_menifiest.bag_no=tbl_domestic_bag.bag_id INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no = tbl_domestic_bag.pod_no WHERE tbl_domestic_menifiest.destination_branch = '$branch_name' AND tbl_domestic_bag.bag_recived='1' AND tbl_domestic_booking.is_delhivery_complete = '0' ORDER BY tbl_domestic_bag.id");
			// echo $this->db->last_query();die;
		}
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
		if ($resAct->num_rows() > 0) {
			$data['allpoddata'] = $resAct->result_array();
		}
		// echo '<pre>';print_r($data['allpoddata']);die;
		$this->load->view('admin/pending_menifest/view_pending_menifest', $data);
	}

	public function pending_for_delivery()
	{
		$username = $this->session->userdata("userName");
		$user_id = $this->session->userdata("userId");
		$whr	 = array('username' => $username);
		$res	=	$this->basic_operation_m->getAll('tbl_users', $whr);

		$branch_id = $res->row()->branch_id;

		$whr		= 	array('branch_id' => $branch_id);
		$res		=	$this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = 	$res->row()->branch_name;
		if ($user_id == '1'){
			// $resAct = $this->db->query("SELECT tbl_domestic_bag.* FROM tbl_domestic_menifiest INNER JOIN tbl_domestic_bag ON tbl_domestic_menifiest.bag_no=tbl_domestic_bag.bag_id WHERE tbl_domestic_bag.bag_recived='1' ORDER BY tbl_domestic_bag.id");
			$resAct = $this->db->query("SELECT tbl_domestic_booking.* FROM tbl_domestic_deliverysheet INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no=tbl_domestic_deliverysheet.pod_no WHERE  tbl_domestic_booking.is_delhivery_complete = '0' ORDER BY tbl_domestic_booking.booking_id DESC;");
		} else {
			$resAct = $this->db->query("SELECT tbl_domestic_booking.* FROM tbl_domestic_deliverysheet INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no=tbl_domestic_deliverysheet.pod_no WHERE tbl_domestic_deliverysheet.branch_id = '$branch_id' AND tbl_domestic_booking.is_delhivery_complete = '0' ORDER BY tbl_domestic_booking.booking_id DESC;");
			
		}
		
		if ($resAct->num_rows() > 0) {
			$data['allpoddata'] = $resAct->result_array();
			//print_r($data['allpoddata']);die;
		}
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
		$this->load->view('admin/pending_menifest/view_pending_for_delivery', $data);
	}


}
