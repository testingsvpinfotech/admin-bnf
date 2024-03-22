<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_deliverysheet extends CI_Controller
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

		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$data = array();
		//$resAct1=$this->basic_operation_m->getAll('tbl_domestic_deliverysheet',$whr);
		//$where2 = array('branch_id'=>$branch_id)
		$resAct1 = $this->db->query("SELECT *, COUNT(deliverysheet_id) AS total_count
FROM tbl_domestic_deliverysheet
LEFT JOIN tbl_branch ON tbl_branch.branch_id = tbl_domestic_deliverysheet.branch_id
LEFT JOIN tbl_users ON tbl_users.username = tbl_domestic_deliverysheet.deliveryboy_name WHERE tbl_domestic_deliverysheet.branch_id = '$branch_id'
 GROUP BY deliverysheet_id ORDER BY tbl_domestic_deliverysheet.id desc");
		//$this->db->last_query();die();
		if ($resAct1->num_rows() > 0) {
			$data['allpod'] = $resAct1->result_array();
		}

		$this->load->view('admin/deliverysheet/view_deliverysheet', $data);
	}
	public function adddelivery()
	{
		$result1 = $this->db->query('select max(id) AS id from tbl_domestic_deliverysheet')->row();
		$id = $result1->id + 1;
		if (strlen($id) == 2) {
			$id = 'D00' . $id;
		} else if (strlen($id) == 3) {
			$id = 'D0' . $id;
		} else if (strlen($id) == 1) {
			$id = 'D000' . $id;
		} else if (strlen($id) == 4) {
			$id = 'D' . $id;
		}
		$data['message'] = "";

		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$data = array();

		$resAct = $this->db->query("select * from  tbl_users where tbl_users.branch_id='$branch_id' and user_type='2 '");

		//echo $this->db->last_query();
		if ($resAct->num_rows() > 0) {
			$data['users'] = $resAct->result();
		}

		//echo "<pre>"; print_r($data);exit;

		$resAct = $this->db->query("select * from  tbl_inword where branch_code='$branch_name' and status='recieved'");

		if ($resAct->num_rows() > 0) {
			$data['pod'] = $resAct->result();
		}

		$data['did'] = $id;
		$this->load->view('admin/deliverysheet/addeliverysheet', $data);
	}

	public function getPODDetails()
	{

		$pod_no = $this->input->post('podno');

		$whr = array('pod_no' => $pod_no);
		$res = $this->basic_operation_m->selectRecord('tbl_booking', $whr);
		$result = $res->row();

		$whr1 = array('booking_id' => $result->booking_id);
		$res1 = $this->basic_operation_m->selectRecord('tbl_weight_details', $whr1);
		$result1 = $res1->row();

		$str = $result->reciever_name . "-" . $result->reciever_address . "-" . $result1->no_of_pack . "-" . $result1->actual_weight;

		echo $str;
	}

	public function awbnodata()
	{
		$pod_no = trim($_REQUEST['awb_no']);

		$username = $this->session->userdata("userName");
		$user_type = $this->session->userdata("userType");
		$user_id = $this->session->userdata("userId");
		$where = '';

		$whr = array('username' => $username);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;

		$block_status = $this->basic_operation_m->get_query_row("select GROUP_CONCAT(customer_id) AS total from access_control where block_status = 'Menfiest' and current_status ='0'");
		//echo $this->db->last_query();die();
		if (!empty($block_status)) { //print_r($block_status->total);die();
			$block_statuss = str_replace(",", "','", $block_status->total);
			$where = " and menifiest_recived ='0' ";
		} else {
			$where = " and menifiest_recived ='0' ";
		}

		// $empty = $this->db->query("SELECT LAST_VALUE(status) FROM tbl_domestic_tracking WHERE pod_no= '$pod_no'");
		$empty = $this->db->query("SELECT STATUS FROM tbl_domestic_tracking WHERE pod_no = '$pod_no' ORDER BY id DESC LIMIT 1;")->row_array();

		if ($empty['STATUS'] == 'Out For Delivery') {
		} else {
			$pod_no = trim($_REQUEST['awb_no']);
			// print_r($pod_no);die;
			// $resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking where tbl_domestic_booking.pod_no='$pod_no' and is_delhivery_complete = '0'  $where limit 1");
			//$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no where tbl_domestic_booking.pod_no='$pod_no' and tbl_domestic_booking.is_delhivery_complete = '0' and tbl_domestic_stock_history.delivery_branch = '$branch_id' and tbl_domestic_stock_history.pickup_in_scan = '1' and tbl_domestic_stock_history.branch_in_scan = '1'  and tbl_domestic_stock_history.current_branch = '$branch_id' $where limit 1");
			$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no where tbl_domestic_booking.pod_no='$pod_no' and tbl_domestic_booking.is_delhivery_complete = '0' and tbl_domestic_stock_history.delivery_branch = '$branch_id' and tbl_domestic_stock_history.pickup_in_scan = '1' and tbl_domestic_stock_history.branch_in_scan = '1'and tbl_domestic_stock_history.bag_genrated = '0' and tbl_domestic_stock_history.menifest_genrate = '0' and tbl_domestic_stock_history.current_branch = '$branch_id' and tbl_domestic_stock_history.is_delivered = '0' $where limit 1");
			$data = "";
			// echo $this->db->last_query();die();
			if ($resAct5->num_rows() > 0) {

				$booking_row = $resAct5->row_array();
				// print_r($booking_row);die();
				$pod = $booking_row['pod_no'];
				$booking_id = $booking_row['booking_id'];
				$customer_id = $booking_row['customer_id'];


				$query_result = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row();

				$actual_weight = $query_result->actual_weight;
				//$no_of_pack	   = $booking_row['a_qty'];
				$no_of_pack = $query_result->no_of_pack;
				$podid = "checkbox-" . $pod;
				$dataid = 'data-val-' . $booking_id;

				$pod_no = $booking_row['pod_no'];
				$data .= '<tr><td>';
				$data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}|{$actual_weight}|{$no_of_pack}' checked><input type='hidden' name='actual_weight[]' value='" . $actual_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";

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
				$data .= $booking_row['contactperson_name'];
				$data .= "</td>";
				$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['reciever_city'] . "'");
				if ($resAct6->num_rows() > 0) {
					$citydata = $resAct6->row();
					$data .= "<td>";
					$data .= $citydata->city;
					$data .= "</td>";
				}

				$data .= "<td>";
				$data .= $booking_row['forworder_name'];
				$data .= "</td>";
				$data .= "<td>";
				$data .= $query_result->actual_weight;
				$data .= "</td>";
				$data .= "<td>";
				$data .= $no_of_pack;
				$data .= "</td>";
				$data .= "</tr>";
			}
			echo $data;
		}
	}

	public function insert_deliverysheet()
	{
		$all_data = $this->input->post();

		if (!empty($all_data)) {
			$username = $this->session->userdata("userName");
			$usernamee = $this->input->post("username");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;


			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			// print_r($data);
			$date = date("Y-m-d", strtotime($this->input->post('datetime')));

			$pod = $this->input->post('pod_no');

			$pod = array_unique($pod);

			$result1 = $this->db->query('select max(id) AS id from tbl_domestic_deliverysheet')->row();
			$id = $result1->id + 1;
			if (strlen($id) == 2) {
				$id = 'D00' . $id;
			} else if (strlen($id) == 3) {
				$id = 'D0' . $id;
			} else if (strlen($id) == 1) {
				$id = 'D000' . $id;
			} else if (strlen($id) == 4) {
				$id = 'D' . $id;
			} else if (strlen($id) == 5) {
				$id = 'D' . $id;
			} else {
				$id = 'D' . $id;
			}
			$this->db->trans_start();
			foreach ($pod as $row) {
				$rows = explode('|', $row);
				$pod_no = $rows[0];
				// check shipment alredy drs credated or not if drs created that case first drs date less than latest drs
				$undeliverd = $this->db->query("SELECT * FROM tbl_domestic_tracking	WHERE status = 'Undelivered' AND pod_no ='$pod_no' ORDER BY id DESC LIMIT 1")->row('tracking_date');
				 if(empty($undeliverd))
				 {
					$bag_date = $this->db->query("SELECT * FROM tbl_domestic_tracking	WHERE status = 'Bag In-Scan' AND pod_no ='$pod_no' ORDER BY id DESC LIMIT 1")->row('tracking_date');
					$bag_in_scan = date('Y-m-d', strtotime($bag_date));
					$predate = date('Y-m-d', strtotime("1 days"));
					$curret = date('Y-m-d');
					if($bag_in_scan <= date('Y-m-d', strtotime($this->input->post('datetime'))) &&
					     $curret >= date('Y-m-d', strtotime($this->input->post('datetime'))))
					{
						$data = array(
							// 'deliverysheet_id'=>$this->input->post('deliverysheet_id'),
							'deliverysheet_id' => $id,
							'deliveryboy_name' => $usernamee,
							'branch_id' => $branch_id,
							'pod_no' => $pod_no,
							'status' => 'recieved',
							'bkdate_reason' => $this->input->post('bkdate_reason'),
							'vehical_no' => $this->input->post('vehical_no'),
							'delivery_date' => $date,
						);
		
						$result = $this->basic_operation_m->insert('tbl_domestic_deliverysheet', $data);
		
						$booking_id = $this->basic_operation_m->get_table_row('tbl_domestic_booking', "pod_no = '$pod_no'");
						$data1 = array(
							'id' => '',
							'booking_id' => $booking_id->booking_id,
							'pod_no' => $pod_no,
							'status' => 'Out For Delivery',
							'forworder_name' => 'SELF',
							'shipment_info' => $id,
							'branch_name' => $branch_name,
							'remarks' => $this->input->post('remark'),
							'tracking_date' => $this->input->post('datetime'),
						);
		
						$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
						$queue_dataa1 = "update tbl_domestic_stock_history set delivery_sheet ='1' where pod_no = '$pod_no'";
						$status = $this->db->query($queue_dataa1);
						$shipping_data = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $pod_no])->row();
						$firstname = $shipping_data->reciever_name;
						$lastname = "";
						$number = $shipping_data->reciever_contact;
						$enmsg = "Hi $firstname $lastname, your AWB No.$pod_no is out for delivery. Track your shipment here https://boxnfreight.com/track-shipment. Regards, Team Box And Freight.";
						sendsms($number, $enmsg);
		
						$array_data[] = $data;
					}
					else
					{
						$msg = 'Booking Date Not Valid. <br>please select greater than Bag In-Scan status date otherwise Undelivered status current date';
						$class = 'alert alert-danger alert-dismissible';
						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
						redirect('admin/list-deilverysheet');
					}
					// print_r($msg);
					// die;
				 }
				 else
				 {
					$undeliverd1 = date('Y-m-d', strtotime($undeliverd));
					$predate = date('Y-m-d', strtotime("1 days"));
					$curret = date('Y-m-d');
					if($undeliverd1 <= date('Y-m-d', strtotime($this->input->post('datetime'))) &&
					     $curret >= date('Y-m-d', strtotime($this->input->post('datetime'))))
					{
						$data = array(
							// 'deliverysheet_id'=>$this->input->post('deliverysheet_id'),
							'deliverysheet_id' => $id,
							'deliveryboy_name' => $usernamee,
							'branch_id' => $branch_id,
							'pod_no' => $pod_no,
							'status' => 'recieved',
							'bkdate_reason' => $this->input->post('bkdate_reason'),
							'vehical_no' => $this->input->post('vehical_no'),
							'delivery_date' => $date,
						);
		
						$result = $this->basic_operation_m->insert('tbl_domestic_deliverysheet', $data);
		
						$booking_id = $this->basic_operation_m->get_table_row('tbl_domestic_booking', "pod_no = '$pod_no'");
						$data1 = array(
							'id' => '',
							'booking_id' => $booking_id->booking_id,
							'pod_no' => $pod_no,
							'status' => 'Out For Delivery',
							'forworder_name' => 'SELF',
							'shipment_info' => $id,
							'branch_name' => $branch_name,
							'remarks' => $this->input->post('remark'),
							'tracking_date' => $this->input->post('datetime'),
						);
		
						$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
						$queue_dataa1 = "update tbl_domestic_stock_history set delivery_sheet ='1' where pod_no = '$pod_no'";
						$status = $this->db->query($queue_dataa1);
						$shipping_data = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $pod_no])->row();
						$firstname = $shipping_data->reciever_name;
						$lastname = "";
						$number = $shipping_data->reciever_contact;
						$enmsg = "Hi $firstname $lastname, your AWB No.$pod_no is out for delivery. Track your shipment here https://boxnfreight.com/track-shipment. Regards, Team Box And Freight.";
						sendsms($number, $enmsg);
		
						$array_data[] = $data;
					}
					else
					{
						$msg = 'Booking Date Not Valid DRs. <br>please select greater than Undelivered status date otherwise Undelivered status current date';
						$class = 'alert alert-danger alert-dismissible';
						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
						redirect('admin/list-deilverysheet');
					}
				 }
			}

			$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Create DRS', $array_data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				$msg = 'DRS Generated successfully DRS No : ' . $id;
				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			} else {
				$this->db->trans_rollback();

				$msg = 'Something went wrong ';
				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/list-deilverysheet');
		}
	}

	public function deliverysheet_detail($id)
	{

		$data = array();



		//$deliverysheet_id=$this->input->post('deliverysheet_id');
		$resAct = $this->db->query("select * from tbl_domestic_booking,tbl_domestic_deliverysheet
					where tbl_domestic_booking.pod_no=tbl_domestic_deliverysheet.pod_no and tbl_domestic_deliverysheet.deliverysheet_id='$id'");

		$data['info'] = $resAct->result_array();


		$this->load->view('admin/deliverysheet/view_deliverysheet_detail', $data);
	}

	public function deliverysheet($deliverysheet_id = '')
	{


		$data = array();
		$data['message'] = "";
		$data['deliverysheet_id'] = $deliverysheet_id;
		// Load library
		$this->load->library('zend');
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');

		$data['company_setting'] = $this->basic_operation_m->get_table_row('tbl_company', "id='1'");

		if (!empty($deliverysheet_id)) {
			$resAct = $this->db->query("select * from  tbl_domestic_deliverysheet where deliverysheet_id='$deliverysheet_id'");
			// $resAct=$this->db->query("select *,tbl_domestic_deliverysheet.delivery_date from  tbl_domestic_deliverysheet,tbl_domestic_booking,tbl_users where
			// tbl_domestic_deliverysheet.pod_no=tbl_domestic_booking.pod_no and
			// tbl_domestic_deliverysheet.deliveryboy_name=tbl_users.username and
			// deliverysheet_id='$deliverysheet_id'");

			$data['deliverysheet'] = $resAct->result_array();
			//  print_r($data['deliverysheet']);die;
			$data['branch_address'] = $this->basic_operation_m->get_table_row('tbl_branch', "branch_id = " . $data['deliverysheet'][0]['branch_id']);
			$data['all_status'] = $this->basic_operation_m->get_table_result('tbl_status', "");
		} elseif (isset($_POST['submit'])) {
			$deliverysheet_id = $this->input->post('deliverysheet_id');

			$resAct = $this->db->query("select * from  tbl_domestic_deliverysheet where deliverysheet_id='$deliverysheet_id'");
			// $resAct=$this->db->query("select *,tbl_domestic_deliverysheet.delivery_date from  tbl_domestic_deliverysheet,tbl_domestic_booking,tbl_users where
			// tbl_domestic_deliverysheet.pod_no=tbl_domestic_booking.pod_no and
			// tbl_domestic_deliverysheet.deliveryboy_name=tbl_users.username and
			// deliverysheet_id='$deliverysheet_id'");

			$data['deliverysheet'] = $resAct->result_array();
			$data['branch_address'] = $this->basic_operation_m->get_table_row('tbl_branch', "branch_id = " . $data['deliverysheet'][0]['branch_id']);
			$data['all_status'] = $this->basic_operation_m->get_table_result('tbl_status', "");
		}
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(E_ALL);
		$this->load->view('admin/deliverysheet/printdelivery', $data);
	}

	public function print_deliverysheet($deliverysheet_id = '')
	{

		$data = array();
		$data['message'] = "";
		// Load library
		$this->load->library('zend');
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');
		$data['company_setting'] = $this->basic_operation_m->get_table_row('tbl_company', "id='1'");

		$user_id = $_SESSION['userId'];

		// $resAct2=$this->db->query("select * from  tbl_branch,tbl_users,city where
		// 	tbl_branch.branch_id=tbl_users.branch_id and
		// 	city.id=tbl_branch.city and
		// 	tbl_users.user_id='$userId'");


		$resAct2 = $this->db->query("select * from tbl_branch left JOIN city ON city.id=tbl_branch.city JOIN tbl_users on tbl_users.branch_id=tbl_branch. branch_id where tbl_users.user_id=" . $user_id);
		// echo $this->db->last_query();exit();

		$data['branchAddress'] = $resAct2->result_array();
		// echo "<pre>";
		// print_r($data['branchAddress']);exit();
		if (!empty($deliverysheet_id)) {


			$resAct = $this->db->query("select *,tbl_domestic_deliverysheet.delivery_date from  tbl_domestic_deliverysheet,tbl_domestic_booking,tbl_users,city where
			tbl_domestic_deliverysheet.pod_no=tbl_domestic_booking.pod_no and
			city.id=reciever_city and
			tbl_domestic_deliverysheet.deliveryboy_name=tbl_users.username and
			deliverysheet_id='$deliverysheet_id'");

			$data['deliverysheet'] = $resAct->result_array();
			$data['branch_address'] = $this->basic_operation_m->get_table_row('tbl_branch', "branch_id = " . $data['deliverysheet'][0]['branch_id']);
			$data['all_status'] = $this->basic_operation_m->get_table_result('tbl_status', "");
		} elseif (isset($_POST['submit'])) {
			$deliverysheet_id = $this->input->post('deliverysheet_id');

			$resAct = $this->db->query("select *,tbl_domestic_deliverysheet.delivery_date from  tbl_deliverysheet,tbl_booking,tbl_users,city where
			tbl_deliverysheet.pod_no=tbl_booking.pod_no and
			city.id=reciever_city and
			tbl_deliverysheet.deliveryboy_name=tbl_users.username and
			deliverysheet_id='$deliverysheet_id'");

			$data['deliverysheet'] = $resAct->result_array();
			$data['branch_address'] = $this->basic_operation_m->get_table_row('tbl_branch', "branch_id = " . $data['deliverysheet'][0]['branch_id']);
			$data['all_status'] = $this->basic_operation_m->get_table_result('tbl_status', "");
		}

		$this->load->view('admin/deliverysheet/printprintdelivery', $data);
	}

	public function update_drs()
	{
		if (isset($_POST['deliverysheet_id'])) {
			$deliverysheet_id = $this->input->post('deliverysheet_id');

			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;

			// $resAct = $this->db->query("select * from  tbl_domestic_deliverysheet where
			// branch_id='$branch_id' AND deliverysheet_id='$deliverysheet_id'");
			$resAct = $this->db->query("select * from  tbl_domestic_deliverysheet JOIN tbl_domestic_stock_history ON tbl_domestic_stock_history.pod_no = tbl_domestic_deliverysheet.pod_no where
			branch_id='$branch_id' AND deliverysheet_id='$deliverysheet_id' and tbl_domestic_stock_history.delivery_branch = '1'");

			$data['deliverysheet'] = $resAct->result_array();
		}
		if ($this->input->post('pod_no')) {

			//print_r($_POST);die;

			$pod_no = $this->input->post('pod_no');
			$status = $this->input->post('status');
			$comments = $this->input->post('comments');
			for ($i = 0; $i < count($pod_no); $i++) {
				if ($status[$i] == 'Delivered') {

					$r = array('is_delhivery_complete' => 1);
					$whr = array('pod_no' => $pod_no[$i]);
					$this->basic_operation_m->update('tbl_domestic_booking', $r, $whr);
				}
				$where = array('pod_no' => $pod_no[$i]);
				$value = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $where);
				$username = $this->session->userdata("userName");
				$whr = array('username' => $username);
				$res = $this->basic_operation_m->getAll('tbl_users', $whr);
				$branch_id = $res->row()->branch_id;
				$where = array('branch_id' => $branch_id);
				$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
				$source_branch = $ress->row()->branch_name;
				$data1 = [
					'pod_no' => $pod_no[$i],
					'status' => $status[$i],
					'booking_id' => $value->booking_id,
					'forworder_name' => $value->forworder_name,
					'branch_name' => $source_branch,
					'comment' => $comments[$i]
				];
				if ($status[$i] == 'Delivered') {
					$is_delhivery_complete = 1;
					$where = array('booking_id' => $value->booking_id);
					$updateData = [
						'is_delhivery_complete' => $is_delhivery_complete,
					];
					$this->db->update('tbl_domestic_booking', $updateData, $where);
					$is_delhivery_complete = 1;
					$where = array('booking_id' => $value->booking_id);
					$updateData1 = [
						'is_delivered' => '1',
					];
					$this->db->update('tbl_domestic_stock_history', $updateData1, $where);
					$shipping_data = $this->db->get_where('tbl_domestic_booking', ['booking_id' => $value->booking_id])->row();
					// $arr = explode(' ', $shipping_data->reciever_name);
					// $arr_congr = explode(' ', $shipping_data[0]->sender_name);

					$fname = $shipping_data->reciever_name;
					$lname = "";
					$number = $shipping_data->reciever_contact;

					$fname_congr = $shipping_data->sender_name;
					$lname_congr = "";
					$number_congr = $shipping_data->sender_contactno;

					$pod_no1 = $shipping_data->pod_no;

					if (!empty($number)) {
						$enmsg = "Hi $fname $lname, We have successfully delivered your Shipment $pod_no1 Regards, Team Box And Freight.";
						sendsms($number, $enmsg);
					}

					if (!empty($number_congr)) {
						$enmsg1 = "Hi $fname_congr $lname_congr, We have successfully delivered your Shipment $pod_no1 Regards, Team Box And Freight.";
						sendsms($number_congr, $enmsg1);
					}

					$booking_data = $this->db->get_where('tbl_domestic_booking', ['booking_id' => $this->input->post('selected_dockets')])->row();

					// echo "<pre>"; print_r($booking_data); die;

					if ($booking_data->dispatch_details == "TOPAY" || $booking_data->dispatch_details == "ToPay") {
						$branch_info = $this->basic_operation_m->getAll('tbl_branch', array('branch_id' => $booking_data->branch_id))->row();
						$code = $this->booking_model->get_invoice_max_id('tbl_domestic_invoice', 'invoice_no', substr($branch_info->branch_code, -2), $booking_data->dispatch_details);

						$date = date('Y-m-d');
						if (date('m', strtotime($date)) <= 3) {
							$year = (date('Y') - 1) . '-' . (date('Y'));
						} else {
							$year = (date('Y')) . '-' . (date('Y') + 1);
						}
						$max_number = $this->basic_operation_m->get_max_number('tbl_domestic_invoice', 'MAX(inc_num) AS id');
						if (!empty($max_number) && !empty($max_number->id)) {
							$inc_num = (($max_number->id) + 1);
						} else {
							$inc_num = 52;
						}

						$invoice['invoice_no'] = $code;
						$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company', array('id' => 1));
						$invoice_series = $branch_info->domestic_invoice_series;
						$invoice['inc_num'] = $inc_num;
						$invoice['invoice_number'] = $code;
						$invoice['invoice_date'] = date("Y-m-d");
						$invoice['consigner_name'] = $booking_data->reciever_name;
						$invoice['consigner_address'] = $booking_data->reciever_address;
						$invoice['consigner_city'] = $booking_data->reciever_city;
						$invoice['consigner_gstno'] = $booking_data->receiver_gstno;
						$invoice['consigner_phone'] = $booking_data->reciever_contact;
						$invoice['address'] = $branch_info->address;
						$invoice['city'] = isset($city_data->city) ? $city_data->city : "";
						$invoice['gstno'] = $branch_info->gst_number;

						$invoice['invoice_from_date'] = date('Y-m-d');
						$invoice['invoice_to_date'] = date('Y-m-d');
						$invoice['booking_ids'] = json_encode($booking_data->booking_id);
						// $invoice['payment_type'] = $this->input->post('pay_mode');
						$invoice['branch_id'] = $booking_data->branch_id;
						$invoice['createId'] = $this->session->userdata('userId');
						$invoice['createDtm'] = date('Y-m-d H:i:s');
						$invoice['payment_type'] = 'TOPAY';
						$invoice['final_invoice'] = 1;
						$invoice['fin_year'] = '2023-2024';
						$invoice['cgst_amount'] = $booking_data->cgst;
						$invoice['sgst_amount'] = $booking_data->sgst;
						$invoice['igst_amount'] = $booking_data->igst;
						$invoice['total_amount'] = $booking_data->grand_total;
						$invoice['sub_total'] = $booking_data->sub_total;
						$invoice['grand_total'] = $booking_data->grand_total;

						$whr_c = array('id' => $booking_data->reciever_city);
						$rec_city = $this->basic_operation_m->get_table_row('city', $whr_c);

						// echo "<pre>"; print_r($invoice); die;

						$this->db->insert('tbl_domestic_invoice', $invoice);
						$invoice_id = $this->db->insert_id();

						if (!empty($invoice_id)) {
							$weight = $this->db->get_where('tbl_domestic_weight_details', ['booking_id' => $booking_data->booking_id])->row();
							$invoice_detail['invoice_id'] = $invoice_id;
							$invoice_detail['booking_id'] = $booking_data->booking_id;
							$invoice_detail['booking_date'] = $booking_data->booking_date;
							$invoice_detail['pod_no'] = $booking_data->pod_no;
							$invoice_detail['doc_type'] = $booking_data->doc_type;
							$invoice_detail['reciever_name'] = $booking_data->reciever_name;
							$invoice_detail['reciever_city'] = $rec_city->city;
							$invoice_detail['mode_dispatch'] = $booking_data->mode_dispatch;
							$invoice_detail['forwording_no'] = !empty($booking_data->forwording_no) ? $booking_data->forwording_no : "";
							$invoice_detail['forworder_name'] = $booking_data->forworder_name;
							$invoice_detail['no_of_pack'] = !empty($weight) ? $weight->no_of_pack : '';
							$invoice_detail['chargable_weight'] = isset($weight) ? $weight->chargable_weight : "";
							$invoice_detail['transportation_charges'] = $booking_data->transportation_charges;
							$invoice_detail['pickup_charges'] = $booking_data->pickup_charges;
							$invoice_detail['delivery_charges'] = $booking_data->delivery_charges;
							$invoice_detail['courier_charges'] = $booking_data->courier_charges;
							$invoice_detail['awb_charges'] = $booking_data->awb_charges;
							$invoice_detail['other_charges'] = $booking_data->other_charges;
							$invoice_detail['frieht'] = $booking_data->frieht;
							$invoice_detail['amount'] = $booking_data->total_amount;
							$invoice_detail['fuel_subcharges'] = $booking_data->fuel_subcharges;
							$invoice_detail['invoice_value'] = $booking_data->invoice_value;
							$invoice_detail['sub_total'] = $booking_data->sub_total;

							$this->db->insert('tbl_domestic_invoice_detail', $invoice_detail);
						}
					}
				}

				if ($status[$i] == 'Undelivered') {
					$is_delhivery_complete = 0;
					$where = array('booking_id' => $value->booking_id);
					$updateData = [
						'is_delhivery_complete' => $is_delhivery_complete,
					];
					$this->db->update('tbl_domestic_booking', $updateData, $where);
					$is_delhivery_complete = 1;
					$where = array('booking_id' => $value->booking_id);
					$updateData1 = [
						'delivery_sheet' => '0',
					];
					$this->db->update('tbl_domestic_stock_history', $updateData1, $where);
					$shipping_data = $this->db->get_where('tbl_domestic_booking', ['booking_id' => $value->booking_id])->row();
				}

				$this->basic_operation_m->insert('tbl_domestic_tracking', $data1); //die();

				$array_data[] = $r;
			}
			$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Update DRS', $array_data, $data['deliverysheet']);
			if ($data) {

				$msg = 'Branch In Scanning successfully';
				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			} else {
				$msg = 'DRS Updated Scanning successfully';
				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/update-drs');
		}

		$this->load->view('admin/deliverysheet/update_drs', $data);
	}

	function out_for_delivery()
	{
		$empty = $this->db->query("SELECT * FROM tbl_domestic_tracking  GROUP BY pod_no ORDER BY id DESC ")->row_array();
		print_r($empty);
		die;
		if ($empty['STATUS'] == 'Out for Delivery') {
			$data = $this->db->query("SELECT STATUS FROM tbl_domestic_tracking  ORDER BY id DESC ")->row_array();
			$this->load->view('admin/deliverysheet/update_drs', $data);
		}


	}
}
