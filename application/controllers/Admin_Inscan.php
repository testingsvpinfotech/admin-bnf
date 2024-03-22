<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Inscan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(E_ALL);
	}

	public function in_scan()
	{
		$data = '';
		if ($_POST) {
			$awb =  $this->input->post('pod_no');

			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$user_id = $res->row()->user_id;
			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$where = array('branch_id' => $branch_id);
			$ress					=	$this->basic_operation_m->getAll('tbl_branch', $where);
			$source_branch		= 	$ress->row()->branch_name;
			date_default_timezone_set('Asia/Kolkata');
			$timestamp = date("Y-m-d H:i:s");

			foreach ($awb as $value) {
				$where = array('pod_no' => $value);
				$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $where);
				$all_data['pod_no'] = $value;
				$all_data['booking_id'] = $data['result'][0]['booking_id'];
				$all_data['forwording_no'] = $data['result'][0]['forwording_no'];
				$all_data['forworder_name'] = $data['result'][0]['forworder_name'];
				$all_data['branch_name'] = $source_branch;
				$all_data['status'] = 'In-scan';
				$all_data['status'] = 'In-scan';
				$all_data['tracking_date'] = $timestamp;
				$this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);

				//echo $this->db->last_query();die();
			}
			if ($data) {

				$msg = 'Branch In Scanning successfully';
				$class	= 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			} else {
				$msg = 'Something went wrong in deleting the Fule';
				$class	= 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/inscan');
		}

		$this->load->view('admin/inscan/inscan_add', $data);
	}

	public function in_scaned_list()
	{   $data['In_Scan_List'] = $this->db->query("SELECT tbl_domestic_booking.*,tbl_domestic_tracking.status,sc.city AS sender_city ,rc.city AS receiver_city,tbl_domestic_tracking.status,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight ,tbl_domestic_weight_details.chargable_weight FROM tbl_domestic_booking LEFT JOIN city AS sc ON sc.id = tbl_domestic_booking.sender_city LEFT JOIN city AS rc ON rc.id = tbl_domestic_booking.reciever_city LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN tbl_domestic_tracking ON tbl_domestic_tracking.booking_id = tbl_domestic_booking.booking_id WHERE tbl_domestic_tracking.status = 'In-Scan' order by tbl_domestic_tracking.tracking_date DESC")->result_array();
		$this->load->view('admin/inscan/In_scaned_list',$data);
	}

	public function in_scan_pending_list()
	{

		$username=$this->session->userdata("userName");
		 $whr = array('username'=>$username);
		 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
		 $branch_id= $res->row()->branch_id;
		 
		 $whr = array('branch_id'=>$branch_id);
		 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
		 $branch_name= $res->row()->branch_name;
		// $data['In_Scan_pending_List'] = $this->db->query("SELECT tbl_domestic_booking.*,tbl_domestic_tracking.status,sc.city AS sender_city ,rc.city AS receiver_city,tbl_domestic_tracking.status,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight ,tbl_domestic_weight_details.chargable_weight FROM tbl_domestic_booking LEFT JOIN city AS sc ON sc.id = tbl_domestic_booking.sender_city LEFT JOIN city AS rc ON rc.id = tbl_domestic_booking.reciever_city LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN tbl_domestic_tracking ON tbl_domestic_tracking.booking_id = tbl_domestic_booking.booking_id WHERE tbl_domestic_tracking.status = 'Booked'  order By tbl_domestic_tracking.tracking_date DESC")->result_array();

// 		$resAct=$this->db->query("select distinct tbl_domestic_bag.bag_id AS bag_no,tbl_domestic_bag.date_added,tbl_domestic_bag.bag_recived from tbl_domestic_menifiest
// LEFT JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no
//  where destination_branch='$branch_name' AND bag_recived = '0' GROUP BY tbl_domestic_bag.bag_id" );
// 		echo "select distinct tbl_domestic_bag.bag_id AS bag_no,tbl_domestic_bag.date_added,tbl_domestic_bag.bag_recived from tbl_domestic_menifiest
// LEFT JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no
//  where destination_branch='$branch_name' AND bag_recived = '0' GROUP BY tbl_domestic_bag.bag_id";
// 		exit();
		$data['In_Scan_pending_List'] = $this->db->query("SELECT tbl_domestic_booking.*,tbl_domestic_tracking.status,sc.city AS sender_city ,rc.city AS receiver_city,tbl_domestic_tracking.status,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight ,tbl_domestic_weight_details.chargable_weight, tbl_domestic_tracking.branch_inscan_comment FROM tbl_domestic_booking LEFT JOIN city AS sc ON sc.id = tbl_domestic_booking.sender_city LEFT JOIN city AS rc ON rc.id = tbl_domestic_booking.reciever_city LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN tbl_domestic_tracking ON tbl_domestic_tracking.booking_id = tbl_domestic_booking.booking_id WHERE 
			tbl_domestic_booking.pod_no IN(select distinct tbl_domestic_bag.pod_no from tbl_domestic_menifiest 
LEFT JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no 
where destination_branch='".$branch_name."' AND bag_recived = '0' group by tbl_domestic_bag.pod_no)
		  order By tbl_domestic_tracking.tracking_date  DESC")->result_array();
		$this->load->view('admin/inscan/In_scaned_pending__list',$data);	
	}

	public function branch_in_sacn_list()
	{   $data['branch_In_Scan_List'] = $this->db->query("SELECT tbl_domestic_booking.*,tbl_domestic_tracking.status,sc.city AS sender_city ,rc.city AS receiver_city,tbl_domestic_tracking.status,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight ,tbl_domestic_weight_details.chargable_weight, tbl_domestic_tracking.branch_inscan_comment FROM tbl_domestic_booking LEFT JOIN city AS sc ON sc.id = tbl_domestic_booking.sender_city LEFT JOIN city AS rc ON rc.id = tbl_domestic_booking.reciever_city LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN tbl_domestic_tracking ON tbl_domestic_tracking.booking_id = tbl_domestic_booking.booking_id WHERE tbl_domestic_tracking.status = 'In-Scan-Branch' AND tbl_domestic_booking.pickup_in_scan = '1' order by tbl_domestic_tracking.tracking_date DESC")->result_array();
		// echo $this->db->last_query();die;
		$this->load->view('admin/inscan/branch_In_scan_list',$data);
	}

	public function Pickup_in_sacn_list()
	{   $data['pickup_In_Scan_List'] = $this->db->query("SELECT tbl_domestic_booking.*,tbl_domestic_tracking.status,sc.city AS sender_city ,rc.city AS receiver_city,tbl_domestic_tracking.status,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight ,tbl_domestic_weight_details.chargable_weight, tbl_domestic_tracking.pickup_inscan_comment FROM tbl_domestic_booking LEFT JOIN city AS sc ON sc.id = tbl_domestic_booking.sender_city LEFT JOIN city AS rc ON rc.id = tbl_domestic_booking.reciever_city LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN tbl_domestic_tracking ON tbl_domestic_tracking.booking_id = tbl_domestic_booking.booking_id WHERE tbl_domestic_tracking.status = 'Pickup-In-scan' order by tbl_domestic_tracking.tracking_date DESC")->result_array();
		$this->load->view('admin/inscan/Pickup_In_scan_list',$data);
	}



	public function branch_awb_scan()
	{
		$awb = trim($this->input->post('forwording_no'));
		$username = $this->session->userdata("userName");
		$user_type = $this->session->userdata("userType");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$resAct5 = $this->db->query("select * from tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no where tbl_domestic_booking.pod_no = '$awb' AND tbl_domestic_booking.pickup_in_scan = '1' AND tbl_domestic_booking.branch_in_scan = '0' and tbl_domestic_stock_history.booked = '1'and tbl_domestic_stock_history.pickup_in_scan = '1' and tbl_domestic_stock_history.current_branch = '$branch_id'");

		// $resAct5 = $this->db->query("select * from tbl_domestic_booking where pod_no = '$awb' AND pickup_in_scan = '1' AND branch_in_scan  = '0'");
		// echo  $this->db->last_query();die;
		$booking_row = $resAct5->row_array();

		$is_delhivery_complete =  $booking_row['is_delhivery_complete'];

		if (!empty($is_delhivery_complete)) {
			$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("Already Delivered/In-scan ");
			});
			</script>';
			echo $val;
		} else {
			// print_r($booking_row);die();
			$pod =  $booking_row['pod_no'];
			$booking_id = $booking_row['booking_id'];

			$query_result = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row_array();

			$actual_weight = $query_result['actual_weight'];
			//$no_of_pack	   = $booking_row['a_qty'];
			$no_of_pack = $query_result['no_of_pack'];
			$podid 		   = "checkbox-" . $pod;
			$dataid 	   = 'data-val-' . $booking_id;
			$data = "";
			$pod_no = $booking_row['pod_no'];
			$data .= '<tr><td>';
			$data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked><input type='hidden' name='actual_weight[]' value='" . $actual_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";

			// $data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked>";

			$data .= "<input type='checkbox' class='cb'  name='actual_weight[]' value='" . $actual_weight . "' checked>";
			$data .= "<input type='checkbox' class='cb'  name='pcs[]' value='" . $no_of_pack . "' checked>";

			$data .= "<input type='hidden' name='rec_pincode' value=" . $booking_row['reciever_pincode'] . "><td>";
			$data .= $booking_row['pod_no'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $booking_row['sender_name'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $booking_row['reciever_name'];
			$data .= "</td>";
			$data .= "<td><input type='hidden' readonly name='forwarder_name' id='forwarder_name'  class='form-control' value='" . $booking_row['forworder_name'] . "'/><input type='hidden' readonly name='branch_name' id='branch_name'  class='form-control' value='" . $branch_name . "'/>";
			$data .= $booking_row['forworder_name'];
			$data .= "</td>";
			$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['sender_city'] . "'");
			if ($resAct6->num_rows() > 0) {
				$citydata  		 = $resAct6->row();
				$data		 	.= "<td>";
				$data		 	.= $citydata->city;
				$data	 		.= "</td>";
			}
			$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['reciever_city'] . "'");
			if ($resAct6->num_rows() > 0) {
				$citydata  		 = $resAct6->row();
				$data		 	.= "<td>";
				$data		 	.= $citydata->city;
				$data	 		.= "</td>";
			}
			$data .= "<td>";
			$data .= $booking_row['dispatch_details'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $no_of_pack;
			$data .= "</td>";
			$data .= "<td>";
			$data .= $query_result['actual_weight'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $query_result['chargable_weight'];
			$data .= "</td>";
			$data .= "</tr>";
			if (empty($booking_row)) {
				$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("This Shipment Not Booked In Our Branch");
			});
			</script>';
				echo $val;
			} else {
				echo  $data;
			}
		}
	}

	public function in_scan_awb_scan()
	{

		$awb = trim($this->input->post('forwording_no'));
		$resAct5 = $this->db->query("select * from tbl_domestic_booking where pod_no = '$awb'");
		// echo  $this->db->last_query();die;
		$booking_row = $resAct5->row_array();
		// print_r($booking_row);die();
		$is_delhivery_complete =  $booking_row['is_delhivery_complete'];

		if (!empty($is_delhivery_complete)) {
			$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("Already Delivered/In-scan ");
			});
			</script>';
			echo $val;
		} else {
			$pod =  $booking_row['pod_no'];
			$booking_id = $booking_row['booking_id'];

			$query_result = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row_array();

			$actual_weight = $query_result['actual_weight'];
			//$no_of_pack	   = $booking_row['a_qty'];
			$no_of_pack = $query_result['no_of_pack'];
			$podid 		   = "checkbox-" . $pod;
			$dataid 	   = 'data-val-' . $booking_id;
			$data = "";
			$pod_no = $booking_row['pod_no'];
			$data .= '<tr><td>';
			$data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked><input type='hidden' name='actual_weight[]' value='" . $actual_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";

			// $data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked>";

			$data .= "<input type='checkbox' class='cb'  name='actual_weight[]' value='" . $actual_weight . "' checked>";
			$data .= "<input type='checkbox' class='cb'  name='pcs[]' value='" . $no_of_pack . "' checked>";

			$data .= "<input type='hidden' name='rec_pincode' value=" . $booking_row['reciever_pincode'] . "><td>";
			$data .= $booking_row['pod_no'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $booking_row['sender_name'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $booking_row['reciever_name'];
			$data .= "</td>";
			$data .= "<td><input type='hidden' readonly name='forwarder_name' id='forwarder_name'  class='form-control' value='" . $booking_row['forworder_name'] . "'/><input type='hidden' readonly name='branch_name' id='branch_name'  class='form-control' value='" . $branch_name . "'/>";
			$data .= $booking_row['forworder_name'];
			$data .= "</td>";
			$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['sender_city'] . "'");
			if ($resAct6->num_rows() > 0) {
				$citydata  		 = $resAct6->row();
				$data		 	.= "<td>";
				$data		 	.= $citydata->city;
				$data	 		.= "</td>";
			}
			$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['reciever_city'] . "'");
			if ($resAct6->num_rows() > 0) {
				$citydata  		 = $resAct6->row();
				$data		 	.= "<td>";
				$data		 	.= $citydata->city;
				$data	 		.= "</td>";
			}
			$data .= "<td>";
			$data .= $booking_row['dispatch_details'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $no_of_pack;
			$data .= "</td>";
			$data .= "<td>";
			$data .= $query_result['actual_weight'];
			$data .= "</td>";
			$data .= "<td>";
			$data .= $query_result['chargable_weight'];
			$data .= "</td>";
			$data .= "</tr>";
			if (empty($booking_row)) {
				$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("This Shipment Not Booked In Our Branch");
			});
			</script>';
				echo $val;
			} else {
				echo  $data;
			}
		}
	}

	public function pickup_awb_scan()
	{

		$awb = trim($this->input->post('forwording_no'));
		$username = $this->session->userdata("userName");
		$user_type = $this->session->userdata("userType");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$resAct5 = $this->db->query("select * from tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no where tbl_domestic_booking.pod_no = '$awb' AND tbl_domestic_booking.pickup_in_scan = '0' AND tbl_domestic_booking.branch_in_scan = '0' and tbl_domestic_stock_history.booked = '1' and tbl_domestic_stock_history.current_branch = '$branch_id'");
		// echo  $this->db->last_query();die;
		$booking_row = $resAct5->row_array();

		$is_delhivery_complete =  $booking_row['is_delhivery_complete'];

		if (!empty($is_delhivery_complete)) {
			$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("Already Delivered/In-scan ");
			});
			</script>';
			echo $val;
		}
		// print_r($booking_row);die();
		$pod =  $booking_row['pod_no'];

		$booking_id = $booking_row['booking_id'];

		$query_result = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row_array();

		$actual_weight = $query_result['actual_weight'];
		//$no_of_pack	   = $booking_row['a_qty'];
		$no_of_pack = $query_result['no_of_pack'];
		$podid 		   = "checkbox-" . $pod;
		$dataid 	   = 'data-val-' . $booking_id;
		$data = "";
		$pod_no = $booking_row['pod_no'];
		$data .= '<tr><td>';
		$data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked><input type='hidden' name='actual_weight[]' value='" . $actual_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";

		// $data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked>";

		$data .= "<input type='checkbox' class='cb'  name='actual_weight[]' value='" . $actual_weight . "' checked>";
		$data .= "<input type='checkbox' class='cb'  name='pcs[]' value='" . $no_of_pack . "' checked>";

		$data .= "<input type='hidden' name='rec_pincode' value=" . $booking_row['reciever_pincode'] . "><td>";
		$data .= $booking_row['pod_no'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $booking_row['sender_name'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $booking_row['reciever_name'];
		$data .= "</td>";
		$data .= "<td><input type='hidden' readonly name='forwarder_name' id='forwarder_name'  class='form-control' value='" . $booking_row['forworder_name'] . "'/><input type='hidden' readonly name='branch_name' id='branch_name'  class='form-control' value='" . $branch_name . "'/>";
		$data .= $booking_row['forworder_name'];
		$data .= "</td>";
		$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['sender_city'] . "'");
		if ($resAct6->num_rows() > 0) {
			$citydata  		 = $resAct6->row();
			$data		 	.= "<td>";
			$data		 	.= $citydata->city;
			$data	 		.= "</td>";
		}
		$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['reciever_city'] . "'");
		if ($resAct6->num_rows() > 0) {
			$citydata  		 = $resAct6->row();
			$data		 	.= "<td>";
			$data		 	.= $citydata->city;
			$data	 		.= "</td>";
		}
		$data .= "<td>";
		$data .= $booking_row['dispatch_details'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $no_of_pack;
		$data .= "</td>";
		$data .= "<td>";
		$data .= $query_result['actual_weight'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $query_result['chargable_weight'];
		$data .= "</td>";
		$data .= "</tr>";
		if (empty($booking_row)) {
			$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("This Shipment Not Booked In Our Branch");
			});
			</script>';
			echo $val;
		} else {
			echo  $data;
		}
	}

	public function pickup_in_scan_status_insert()
	{

		if ($_POST) {
			$awb =  $this->input->post('pod_no');

			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$user_id = $res->row()->user_id;
			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$where = array('branch_id' => $branch_id);
			$ress					=	$this->basic_operation_m->getAll('tbl_branch', $where);
			$source_branch		= 	$ress->row()->branch_name;
			date_default_timezone_set('Asia/Kolkata');
			$timestamp = date("Y-m-d H:i:s");
			$this->db->trans_start();
			foreach ($awb as $value) {
				$where = array('pod_no' => $value);
				$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $where);
				$all_data['pod_no'] = $value;
				$all_data['booking_id'] = $data['result'][0]['booking_id'];
				$all_data['forwording_no'] = $data['result'][0]['forwording_no'];
				$all_data['forworder_name'] = $data['result'][0]['forworder_name'];
				$all_data['branch_name'] = $source_branch;
				$all_data['status'] = 'Pickup-In-scan';
				$all_data['remarks'] = $this->input->post('pickup_inscan_comment');
				$all_data['tracking_date'] = $timestamp;
				$all_data['pickup_inscan_comment'] = $this->input->post('pickup_inscan_comment');
				
				$this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
				$queue_dataa		= "update tbl_domestic_booking set pickup_in_scan ='1' where pod_no = '$value'";
				$status				= $this->db->query($queue_dataa);
				$queue_dataa1		= "update tbl_domestic_stock_history set pickup_in_scan ='1' where pod_no = '$value'";
				$status				= $this->db->query($queue_dataa1);

				$array_data[] = $all_data;
			} 
			   $this->basic_operation_m->addLog($this->session->userdata("userId"),'operation','Pickup In Scan', $array_data);
			   $this->db->trans_complete();
			   if ($this->db->trans_status() === TRUE)
			   {
				$this->db->trans_commit();
				$msg = 'Pickup Scanning successfully';
				$class	= 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			} else {
				$this->db->trans_rollback();
				$msg = 'Something went wrong in deleting the Fule';
				$class	= 'alert alert-success alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/pickup-in-scan');
		}
		$this->load->view('admin/inscan/pickup_inscan_add', $data);
	}


	public function fr_direct_scan()
	{

		$awb = trim($this->input->post('forwording_no'));
		$username = $this->session->userdata("userName");
		$user_type = $this->session->userdata("userType");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$resAct5 = $this->db->query("select *,tbl_domestic_booking.pod_no as pod_no from tbl_domestic_booking left join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no where tbl_domestic_booking.pod_no = '$awb' and tbl_domestic_booking.branch_id ='0' and tbl_domestic_booking.pickup_in_scan = '0' and tbl_domestic_booking.branch_in_scan = '0' and tbl_domestic_stock_history.pod_no IS NULL");
		// echo  $this->db->last_query();die;
		$booking_row = $resAct5->row_array();

		$is_delhivery_complete =  $booking_row['is_delhivery_complete'];

		if (!empty($is_delhivery_complete)) {
			
			$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert("Already Delivered/In-scan ");
			});
			</script>';
			echo $val;
		}
		// print_r($booking_row);die();
		$pod =  $booking_row['pod_no'];
		$dom_booking = $this->db->query("select * from tbl_domestic_booking where pod_no = '$pod'")->row_array();

		$booking_id = $dom_booking['booking_id'];

		$query_result = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row_array();
		$actual_weight = $query_result['actual_weight'];
		//$no_of_pack	   = $booking_row['a_qty'];
		$no_of_pack = $query_result['no_of_pack'];
		$podid 		   = "checkbox-" . $pod;
		$dataid 	   = 'data-val-' . $booking_id;
		$data = "";
		$pod_no = $booking_row['pod_no'];
		$data .= '<tr><td>';
		$data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked><input type='hidden' name='actual_weight[]' value='" . $actual_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";

		// $data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked>";

		$data .= "<input type='checkbox' class='cb'  name='actual_weight[]' value='" . $actual_weight . "' checked>";
		$data .= "<input type='checkbox' class='cb'  name='pcs[]' value='" . $no_of_pack . "' checked>";

		$data .= "<input type='hidden' name='rec_pincode' value=" . $booking_row['reciever_pincode'] . "><td>";
		$data .= $booking_row['pod_no'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $booking_row['sender_name'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $booking_row['reciever_name'];
		$data .= "</td>";
		$data .= "<td><input type='hidden' readonly name='forwarder_name' id='forwarder_name'  class='form-control' value='" . $booking_row['forworder_name'] . "'/><input type='hidden' readonly name='branch_name' id='branch_name'  class='form-control' value='" . $branch_name . "'/>";
		$data .= $booking_row['forworder_name'];
		$data .= "</td>";
		$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['sender_city'] . "'");
		if ($resAct6->num_rows() > 0) {
			$citydata  		 = $resAct6->row();
			$data		 	.= "<td>";
			$data		 	.= $citydata->city;
			$data	 		.= "</td>";
		}
		$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['reciever_city'] . "'");
		if ($resAct6->num_rows() > 0) {
			$citydata  		 = $resAct6->row();
			$data		 	.= "<td>";
			$data		 	.= $citydata->city;
			$data	 		.= "</td>";
		}
		$data .= "<td>";
		$data .= $booking_row['dispatch_details'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $no_of_pack;
		$data .= "</td>";
		$data .= "<td>";
		$data .= $query_result['actual_weight'];
		$data .= "</td>";
		$data .= "<td>";
		$data .= $query_result['chargable_weight'];
		$data .= "</td>";
		$data .= "</tr>";
		if (empty($booking_row)) {
			$pod =  $booking_row['pod_no'];
			$check = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$awb' order by id desc limit 1")->row();
			// echo $this->db->last_query();die;
			if($check->status == 'In transit'){
				$status = $check->status.' To '. $check->branch_name;
			}else{
				$status = $check->status;
			}

			$val = '<script type="text/javascript">
			$(document).ready(function(e) {
			alert(" Current AWB Status :- '.$status.' \n please complete the first mile process");
			});
			</script>';
			echo $val;
		} else {
			echo  $data;
		}
	}

	public function franchise_direct_scan()
	{

		if ($_POST) {
			$awb =  $this->input->post('pod_no');
        //    print_r($awb);die;
			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$user_id = $res->row()->user_id;
			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;
			$where = array('branch_id' => $branch_id);
			$ress					=	$this->basic_operation_m->getAll('tbl_branch', $where);
			$source_branch		= 	$ress->row()->branch_name;
			date_default_timezone_set('Asia/Kolkata');
			$timestamp = date("Y-m-d H:i:s");
			$this->db->trans_start();
			foreach ($awb as $value) {
				$where = array('pod_no' => $value);
				$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $where);
				$all_data['pod_no'] = $value;
				$all_data['booking_id'] = $data['result'][0]['booking_id'];
				$all_data['forwording_no'] ='';
				$all_data['forworder_name'] = $data['result'][0]['forworder_name'];
				$all_data['branch_name'] = $source_branch;
				$all_data['status'] = 'In Scan '.$branch_name;
				$all_data['remarks'] = $this->input->post('remark');
				$all_data['tracking_date'] = $timestamp;				 
				$reciever_pincode = $data['result'][0]['reciever_pincode'];

               $ress1					=	$this->basic_operation_m->getAll('tbl_branch_service', ['pincode'=>$reciever_pincode]);
			   $branch_reciever		= 	$ress1->row()->branch_id;
				$stock = array(
					'delivery_branch'=>$branch_reciever,
					'destination_pincode'=>$reciever_pincode,
					'current_branch'=>$branch_id,
					'pod_no'=>$value,
					'booking_id'=>$data['result'][0]['booking_id'],
					'booked'=> '1',
					'pickup_in_scan'=> '1',
					'branch_in_scan'=> '1'
				);
				// $this->db->trans_begin();
				$this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
				
				$this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);
				
				$queue_dataa		= "update tbl_domestic_booking set pickup_in_scan ='1',branch_in_scan = '1' where pod_no = '$value'";
				$status				= $this->db->query($queue_dataa);
				// echo $this->db->last_query();
				$array_data[] = $all_data;
			
			} 
			 $this->basic_operation_m->addLog($this->session->userdata("userId"),'operation','Direct Franchise Shipments In Scan In Branch', $array_data);
			//  && $this->db->trans_status() === true
			    $this->db->trans_complete();
				if ($this->db->trans_status() === TRUE)
				{
					$this->db->trans_commit();
					$msg = 'Franchise Shipments Scanning successfully';
					$class	= 'alert alert-success alert-dismissible';
					// $this->db->trans_commit();
					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
				}
				else
				{
					$this->db->trans_rollback();
					$msg = 'Something went wrong in deleting the Fule';
					$class	= 'alert alert-success alert-dismissible';
					// $this->db->trans_rollback();
					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);	
				}
			redirect('admin/direct-fr-scan');
		}
		$this->load->view('admin/inscan/franchise_diract_scan_inbranch');
	}

	public function brnach_in_scan_insert()
	{

		if ($_POST) {
			$awb =  $this->input->post('pod_no');

			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$user_id = $res->row()->user_id;
			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$where = array('branch_id' => $branch_id);
			$ress					=	$this->basic_operation_m->getAll('tbl_branch', $where);
			$source_branch		= 	$ress->row()->branch_name;
			date_default_timezone_set('Asia/Kolkata');
			$timestamp = date("Y-m-d H:i:s");
			$this->db->trans_start();
			foreach ($awb as $value) {
				$where = array('pod_no' => $value);
				$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $where);
				$all_data['pod_no'] = $value;
				$all_data['booking_id'] = $data['result'][0]['booking_id'];
				$all_data['forwording_no'] = $data['result'][0]['forwording_no'];
				$all_data['forworder_name'] = $data['result'][0]['forworder_name'];
				$all_data['branch_name'] = $source_branch;
				$all_data['status'] = 'In-Scan-Branch';
				$all_data['remarks'] = $this->input->post('branch_inscan_comment');
				$all_data['tracking_date'] = $timestamp;
				$all_data['branch_inscan_comment'] = $this->input->post('branch_inscan_comment');
				$this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
				$queue_dataa		= "update tbl_domestic_booking set branch_in_scan ='1' where pod_no = '$value'";
				$status				= $this->db->query($queue_dataa);
				$queue_dataa1		= "update tbl_domestic_stock_history set branch_in_scan ='1' where pod_no = '$value'";
				$status				= $this->db->query($queue_dataa1);

				$array_data[] = $all_data;
			}
			$this->basic_operation_m->addLog($this->session->userdata("userId"),'operation','Branch In Scan', $array_data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
               {
				$this->db->trans_commit();
				$msg = 'Branch In Scanning successfully';
				$class	= 'alert alert-success alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				} else {
					$this->db->trans_rollback();
					$msg = 'Something went wrong';
					$class	= 'alert alert-success alert-dismissible';
					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
				}
			redirect('admin/branch-in-scan');
		}
		$this->load->view('admin/inscan/branch_in_scan', $data);
	}




	public function add_bank()
	{

		$data['message']				= "";
		$array['airway_no_from'] 		= array();
		$array['airway_no_to'] 			= array();
		$array['branch_code'] 			= array();

		if (isset($_POST['submit'])) {
			$all_data = $this->input->post();
			unset($all_data['submit']);
			$result = $this->basic_operation_m->insert('bank_master', $all_data);
			if ($this->db->affected_rows() > 0) {
				$data['message'] = "cnode Added Sucessfully";
			} else {
				$data['message'] = "Error in Query";
			}
			redirect('admin/view-bank');
		}
		$this->load->view('admin/Bank_Master/view_bank', $data);
	}

	public function edit_bank($vehicle_id)
	{
		$data['message'] = "";
		$resAct = $this->basic_operation_m->getAll('bank_master', "id = '$vehicle_id'");
		if ($resAct->num_rows() > 0) {
			$data['vehicle_info'] = $resAct->row();
		}

		if (isset($_POST['submit'])) {
			$all_data = $this->input->post();
			unset($all_data['submit']);
			$whr = array('id' => $vehicle_id);
			$result = $this->basic_operation_m->update('bank_master', $all_data, $whr);
			if ($this->db->affected_rows() > 0) {
				$data['message'] = "Cnode Updated Sucessfully";
			} else {
				$data['message'] = "Error in Query";
			}
			redirect('admin/view-bank');
		}
		$this->load->view('admin/Bank_Master/edit_bank', $data);
	}

	public function delete_bank()
	{
		$id = $this->input->post('getid');
		// 		$data['message']="";
		if ($id != "") {
			$whr = array('id' => $id);
			$res = $this->basic_operation_m->delete('bank_master', $whr);
			//	echo $this->db->last_qurey();die();
			$output['status'] = 'success';
			$output['message'] = 'Fule deleted successfully';
		} else {
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Fule';
		}

		echo json_encode($output);
	}
}
