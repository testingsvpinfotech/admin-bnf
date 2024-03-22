<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
defined('BASEPATH') or exit('No direct script access allowed');
use Dompdf\Dompdf;

class Admin_domestic_shipment_manager extends CI_Controller
{

	var $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Rate_model');
		$this->load->model('booking_model');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}

	public function cancel_shipment_list()
	{
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
		$data['shipment_list'] = $this->db->query("SELECT tbl_domestic_booking.*,transfer_mode.mode_name as mode_dispatch  FROM `tbl_domestic_booking`LEFT JOIN transfer_mode ON tbl_domestic_booking.mode_dispatch =transfer_mode.transfer_mode_id where pickup_in_scan = '2' and branch_in_scan = '2' order by booking_id desc")->result();
		$this->load->view('admin/franchise_cancel_shipment/cancel_shipment_list', $data);
	}

	// add by pritesh
//  insert awb backup no to stoct tablel 
public function stock_update(){
		 
	$data = array('100016485',
	'100019795',
	'100019796',
	'100019797',
	'100019798',
	'100019799',
	'100019803',
	'100019804',
	'100019805',
	'100019806',
	'100019807',
	'100019808',
	'100019811',
	'100019812',
	'100019813',
	'100019816',
	'100019817',
	'100019818',
	'100019819',
	'100019820',
	'100019824',
	'100019825',
	'100019826',
	'100019828',
	'100019829',
	'100019831',
	'100019832',
	'100019834',
	'100019835',
	'100019850',
	'100019851',
	'100019853',
	'100019854',
	'100019855',
	'100019857',
	'FBI300508',
	'FBI300510');

   $check = array();
//    echo '<pre>';print_r( $data );
//    die;
	for ( $i = 0; $i < count($data); $i++ )
	{   
		$value = $data[$i];
		if(!empty($value)){
			$tracking = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$value'order by id desc limit 1")->row();
			$stock_data = $this->db->query("select * from tbl_domestic_stock_history where pod_no = '$value'")->row();
			$del = $this->db->query("select * from tbl_users where branch_id = '$stock_data->delivery_branch' and user_type = '2'")->row();
			if (!empty($del)) {
			   $boy = $del->username;
			}else{
				 $boy = 'raju';
			}
		 //echo '<pre>';print_r($tracking);
		 if(!empty($tracking)){
			$stock = ['is_delivered'=>1,'delivery_branch'=>1];
			$book = ['is_delhivery_complete'=>1];
		   
			$data3 = array(
			 'pod_no' => $value,
			 'status' => 'Delivered',
			 'branch_name' => $tracking->branch_name,
			 'tracking_date' => $tracking->tracking_date,
			 'remarks' => 'It was directly delivered by ERP system due to data inconsistency.',
			 'forworder_name' => 'SELF',
		 );
		 // echo '<pre>';print_r($data1);die;
		 $this->db->update('tbl_domestic_stock_history', $stock, ['pod_no'=> $value]);
		 $this->db->update('tbl_domestic_booking', $book, ['pod_no'=> $value]);
		 $result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
		 $check[] =+$value;
	 }
	 }
	}	
	echo '<pre>';print_r($check);
	
die;
 }


	

	public function view_domestic_shipment($offset = 0, $searching = '')
	{
		//print_r($this->session->all_userdata());
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		} else {
			$data = [];

			if (isset($_GET['from_date'])) {
				$data['from_date'] = $_GET['from_date'];
				$from_date = $_GET['from_date'];
			}
			if (isset($_GET['to_date'])) {
				$data['to_date'] = $_GET['to_date'];
				$to_date = $_GET['to_date'];
			}
			if (isset($_GET['filter'])) {
				$filter = $_GET['filter'];
				$data['filter'] = $filter;
			}
			if (isset($_GET['courier_company'])) {
				$courier_company = $_GET['courier_company'];
				$data['courier_companyy'] = $courier_company;
			}
			if (isset($_GET['user_id'])) {
				$user_id = $_GET['user_id'];
				$data['user_id'] = $user_id;
			}
			if (isset($_GET['filter_value'])) {
				$filter_value = $_GET['filter_value'];
				$data['filter_value'] = $filter_value;
			}

			$user_id = $this->session->userdata("userId");
			$data['customer'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');

			$user_type = $this->session->userdata("userType");
			$filterCond = '';
			$all_data = $this->input->get();

			if ($all_data) {
				$filter_value = trim($_GET['filter_value']);

				foreach ($all_data as $ke => $vall) {
					if ($ke == 'filter' && !empty($vall)) {
						if ($vall == 'pod_no') {
							$filterCond .= " AND tbl_domestic_booking.pod_no = '$filter_value'";
						}
						if ($vall == 'forwording_no') {
							$filterCond .= " AND tbl_domestic_booking.forwording_no = '$filter_value'";
						}
						if ($vall == 'sender') {
							$filterCond .= " AND tbl_domestic_booking.sender_name LIKE '%$filter_value%'";
						}
						if ($vall == 'receiver') {
							$filterCond .= " AND tbl_domestic_booking.reciever_name LIKE '%$filter_value%'";
						}

						if ($vall == 'origin') {
							$city_info = $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
							$filterCond .= " AND tbl_domestic_booking.sender_city = '$city_info->id'";
						}
						if ($vall == 'destination') {
							$city_info = $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
							$filterCond .= " AND tbl_domestic_booking.reciever_city = '$city_info->id'";
						}
						if ($vall == 'pickup') {

							$filterCond .= " AND tbl_domestic_booking.pickup_pending = '1'";
						}

					} elseif ($ke == 'user_id' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.customer_id = '$vall'";
					} elseif ($ke == 'from_date' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.booking_date >= '$vall'";
					} elseif ($ke == 'to_date' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.booking_date <= '$vall'";
					} elseif ($ke == 'courier_company' && !empty($vall) && $vall != "ALL") {
						$filterCond .= " AND tbl_domestic_booking.courier_company_id = '$vall'";
					} elseif ($ke == 'mode_name' && !empty($vall) && $vall != "ALL") {
						$filterCond .= " AND tbl_domestic_booking.mode_dispatch = '$vall'";
					}

				}
			}
			if (!empty($searching)) {
				$filterCond = urldecode($searching);
			}


			if (
				$this->session->userdata("userType") == '1'
				or $this->session->userdata("userType") == '10'
				or $this->session->userdata("userType") == '11'
				or $this->session->userdata("userType") == '12'
			) {
				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 $filterCond ");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking  JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id WHERE company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",25");
                // echo $this->db->last_query();die;
				$download_query = "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method,tbl_domestic_weight_details.weight_details  FROM tbl_domestic_booking JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id WHERE company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond  GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC";

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/view-domestic-shipment';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 25;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {

					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}
			} else {

				$branch_id = $this->session->userdata("branch_id");


				// echo "heello";die;

				// branchwise shipment code 
				// and tbl_domestic_booking.branch_id = '$branch_id'
				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 and branch_id='$branch_id' $filterCond ");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method FROM tbl_domestic_booking JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  WHERE tbl_domestic_booking.branch_id = '$branch_id' $filterCond  order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",25");
				// echo $this->db->last_query();die;
				$download_query = "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method,tbl_domestic_weight_details.weight_details  FROM tbl_domestic_booking JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  WHERE tbl_domestic_booking.branch_id = '$branch_id'  $filterCond order by tbl_domestic_booking.booking_id DESC ";

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/view-domestic-shipment/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 25;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {
					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}
			}

			if (isset($_GET['download_report']) && $_GET['download_report'] == 'Download Report') {
				$resActtt = $this->db->query($download_query);
				$shipment_data = $resActtt->result_array();
				$this->domestic_shipment_report($shipment_data);
			}

			$data['viewVerified'] = 2;
			$whr_c = array('company_type' => 'Domestic');
			$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_c);
			$data['mode_details'] = $this->basic_operation_m->get_all_result("transfer_mode", '');
			$this->load->view('admin/domestic_shipment/view_domestic_shipment', $data);
		}

	}


	public function view_booking_charges($offset = 0, $searching = '')
	{
		//print_r($this->session->all_userdata());
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		} else {
			$data = [];

			if (isset($_POST['from_date'])) {
				$data['from_date'] = $_POST['from_date'];
				$from_date = $_POST['from_date'];
			}
			if (isset($_POST['to_date'])) {
				$data['to_date'] = $_POST['to_date'];
				$to_date = $_POST['to_date'];
			}

			if (isset($_POST['user_id'])) {
				$user_id = $_POST['user_id'];
				$data['user_id'] = $user_id;
			}


			$user_id = $this->session->userdata("userId");
			$data['customer'] = $this->basic_operation_m->get_query_result_array("SELECT * FROM tbl_customers WHERE isdeleted  = '0' ORDER BY customer_name ASC");

			$user_type = $this->session->userdata("userType");
			$filterCond = '';
			$all_data = $this->input->post();

			if ($all_data) {
				// $filter_value = 	$_POST['filter_value'];

				foreach ($all_data as $ke => $vall) {

					if ($ke == 'user_id' && !empty($vall)) {
						$filterCond .= "AND tbl_domestic_booking.customer_id = '$vall'";
					} elseif ($ke == 'from_date' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.booking_date >= '$vall'";
					} elseif ($ke == 'to_date' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.booking_date <= '$vall'";
					}


				}
			}
			if (!empty($searching)) {
				$filterCond = urldecode($searching);
			}


			if ($this->session->userdata("userType") == '1') {
				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 $filterCond ");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",100");
				// echo $this->db->last_query();die();
				$download_query = "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method,tbl_domestic_weight_details.weight_details  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond  GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC";

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/view-booking-charges/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 100;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {

					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}
			} else {
				//print_r($this->session->all_userdata());
				$branch_id = $this->session->userdata("branch_id");
				$where = '';
				// if($this->session->userdata("userType") == '7') 
				if ($this->session->userdata("branch_id") == $branch_id) {

					$username = $this->session->userdata("userName");

					$whr = array('username' => $username);
					// $res = $this->basic_operation_m->getAll('tbl_users', $whr);
					// $branch_id = $res->row()->branch_id;				
					$where = "and branch_id='$branch_id' ";
				}

				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 and branch_id='$branch_id' $filterCond ");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 $where $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",100");

				$download_query = "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method,tbl_domestic_weight_details.weight_details  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 $where $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC ";

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/view-booking-charges/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 100;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {
					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}
			}

			if (isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report') {
				$resActtt = $this->db->query($download_query);
				$shipment_data = $resActtt->result_array();

				$this->domestic_shipment_report($download_query);
			}

			$data['viewVerified'] = 2;
			$whr_c = array('company_type' => 'Domestic');
			$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_c);
			$data['mode_details'] = $this->basic_operation_m->get_all_result("transfer_mode", '');
			$this->load->view('admin/domestic_shipment/view_booking_charges', $data);
		}

	}



	public function domestic_shipment_report($shipment_data)
	{

		$date = date('d-m-Y');
		$filename = "SipmentDetails_" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("AWB No.", "Sender", "Receiver", "Receiver City", "Forwording No", "Forworder Name", "Booking date", "Mode", "Pay Mode", "Amount", "Weight", "NOP", "Invoice No", "Invoice Amount", "Branch Name", "User", "Eway No", "Eway Expiry date", "Per Box Pack", "L", "B", "H", "Valumetric Weight", "Actual Weight", "Chargeable Weight");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($shipment_data as $row) {
			$i++;

			$whr = array('transfer_mode_id' => $row['mode_dispatch']);
			$mode_details = $this->basic_operation_m->get_table_row_array('transfer_mode', $whr);

			$whr_u = array('branch_id' => $row['branch_id']);
			$branch_details = $this->basic_operation_m->get_table_row_array('tbl_branch', $whr_u);


			$whr_u = array('user_id' => $row['user_id']);
			$user_details = $this->basic_operation_m->get_table_row_array('tbl_users', $whr_u);
			$user_details['username'] = substr($user_details['username'], 0, 20);
			//print_r(  $user_details['username']);



			$whr = array('id' => $row['sender_city']);
			$sender_city_details = $this->basic_operation_m->get_table_row("city", $whr);
			$sender_city = @$sender_city_details->city;

			$whr_s = array('id' => $row['reciever_state']);
			$reciever_state_details = $this->basic_operation_m->get_table_row("state", $whr_s);
			$reciever_state = @$reciever_state_details->state;

			$whr_p = array('id' => $row['payment_method']);
			$payment_method_details = $this->basic_operation_m->get_table_row_array("payment_method", $whr_p);
			$payment_method = $payment_method_details['method'];


			$branch_details['branch_name'] = substr($branch_details['branch_name'], 0, 20);
			$roww = array(
				$row['pod_no'],
				$row['sender_name'],
				$row['reciever_name'],
				$row['city'],
				$row['forwording_no'],
				$row['forworder_name'],
				date('d-m-Y', strtotime($row['booking_date'])),
				$mode_details['mode_name'],
				$row['dispatch_details'],
				$row['grand_total'],
				$row['chargable_weight'],
				$row['no_of_pack'],
				$row['invoice_no'],
				$row['invoice_value'],
				$branch_details['branch_name'],
				$user_details['username']
			);


			fputcsv($fp, $roww);
			if ($row['doc_type'] == 1) {
				$weight_details = json_decode($row['weight_details']);

				if (!empty($weight_details->per_box_weight_detail)) {
					foreach ($weight_details->per_box_weight_detail as $key => $values) {
						$weight_row = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $values, $weight_details->length_detail[$key], $weight_details->breath_detail[$key], $weight_details->height_detail[$key], $weight_details->valumetric_weight_detail[$key], $weight_details->valumetric_actual_detail[$key], $weight_details->valumetric_chageable_detail[$key]);
						fputcsv($fp, $weight_row);
					}
				}
			}

		}
		exit;
	}
	public function pikali_customer()
	{
		$shipment_data = $this->db->query("SELECT tbl_domestic_weight_details.*,tbl_domestic_booking.pod_no,tbl_domestic_booking.booking_date,tbl_domestic_booking.doc_type FROM tbl_domestic_booking 
		JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id=tbl_domestic_booking.booking_id 
		WHERE tbl_domestic_booking.booking_date >= '2024-01-01' and tbl_domestic_booking.booking_date <= '2024-01-31' and  tbl_domestic_booking.branch_id='186'  ORDER BY tbl_domestic_booking.booking_id DESC ")->result_array();
		$date = date('d-m-Y');
		$filename = "North_Zone_Delhi" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("#", "LR No", "Booking Date","Total Qty" ,"Total AW", "No.of parcels", "Length(L)", "Breadth (B)", "Height(H)", "Actual Weight");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($shipment_data as $row) {
			$i++;

			// $roww = array(
			// 	$i,
			// 	$row['pod_no'],
			// 	,
			// 	$row['actual_weight'],
			// );


			// fputcsv($fp, $roww);
			if ($row['doc_type'] == 1) {
				$weight_details = json_decode($row['weight_details']);

				if (!empty($weight_details->per_box_weight_detail)) {
					foreach ($weight_details->per_box_weight_detail as $key => $values) {
						if($key==0){
                           $booking_date = date('d-m-Y', strtotime($row['booking_date']));
						   $pod_no = $row['pod_no'];
						   $actual_weight = $row['actual_weight'];
						   $no_of_pack = $row['no_of_pack'];
						   $count = $i;
						}else{
							$booking_date ='';
							$no_of_pack  ='';
							$pod_no ='';
							$actual_weight ='';
							$count = '';
						}
						$weight_row = array( $count, $pod_no,$booking_date,$no_of_pack ,$actual_weight,$weight_details->per_box_weight_detail[$key], $weight_details->length_detail[$key], $weight_details->breath_detail[$key], $weight_details->height_detail[$key], $weight_details->valumetric_actual_detail[$key]);
						fputcsv($fp, $weight_row);
					}
				}
			}

		}
		// exit;
	}

	public function view_pending_domestic_forworder()
	{
		$whr = array("forwording_no" => "");
		$data['all_pending_forworder'] = $this->basic_operation_m->get_all_result("tbl_domestic_booking", $whr);
		$this->load->view('admin/domestic_shipment/view_domestic_pending_forworder', $data);
	}
	public function view_domestic_unbill_shipment($offset = 0, $searching = '')
	{
		//print_r($this->session->all_userdata());
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		} else {
			$data = [];

			if (isset($_GET['from_date'])) {
				$data['from_date'] = $_GET['from_date'];
				$from_date = $_GET['from_date'];
			}
			if (isset($_GET['to_date'])) {
				$data['to_date'] = $_GET['to_date'];
				$to_date = $_GET['to_date'];
			}
			if (isset($_GET['filter'])) {
				$filter = $_GET['filter'];
				$data['filter'] = $filter;
			}
			if (isset($_GET['user_id'])) {
				$user_id = $_GET['user_id'];
				$data['user_id'] = $user_id;
			}
			if (isset($_GET['filter_value'])) {
				$filter_value = $_GET['filter_value'];
				$data['filter_value'] = $filter_value;
			}

			$user_id = $this->session->userdata("userId");
			$data['customer'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');

			$user_type = $this->session->userdata("userType");
			$filterCond = '';
			$all_data = $this->input->get();

			if ($all_data) {
				$filter_value = trim($_GET['filter_value']);

				foreach ($all_data as $ke => $vall) {
					if ($ke == 'filter' && !empty($vall)) {
						if ($vall == 'pod_no') {
							$filterCond .= " AND tbl_domestic_booking.pod_no = '$filter_value'";
						}

					} elseif ($ke == 'user_id' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.customer_id = '$vall'";
					} elseif ($ke == 'from_date' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.booking_date >= '$vall'";
					} elseif ($ke == 'to_date' && !empty($vall)) {
						$filterCond .= " AND tbl_domestic_booking.booking_date <= '$vall'";
					}

				}
			}
			if (!empty($searching)) {
				$filterCond = urldecode($searching);
			}


			if (
				$this->session->userdata("userType") == '1'
				or $this->session->userdata("userType") == '10'
				or $this->session->userdata("userType") == '11'
				or $this->session->userdata("userType") == '12'
			) {
				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE invoice_generated_status = 0 $filterCond ");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 AND tbl_domestic_booking.invoice_generated_status = 0 $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",50");

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/view-domestic-unbill-shipment';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 50;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {

					$data['all_unbill_shippment'] = $resAct->result_array();
				} else {
					$data['all_unbill_shippment'] = array();
				}
			}
			$data['viewVerified'] = 2;
			$whr_c = array('company_type' => 'Domestic');
			$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_c);
			$data['mode_details'] = $this->basic_operation_m->get_all_result("transfer_mode", '');
			$this->load->view('admin/domestic_shipment/view_domestic_unbill_shipment', $data);
		}

	}

	

	public function check_rate()
	{
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);

		$sub_total = 0;
		$customer_id = $this->input->post('customer_id');
		$c_courier_id = $this->input->post('c_courier_id');
		$mode_id = $this->input->post('mode_id');
		$reciver_city = $this->input->post('city');
		$reciver_state = $this->input->post('state');
		$sender_state = $this->input->post('sender_state');
		$sender_city = $this->input->post('sender_city');
		$is_appointment = $this->input->post('is_appointment');
		$packet = $this->input->post('packet');
		$actual_weight = $this->input->post('actual_weight');
		$whr1 = array('state' => $sender_state, 'city' => $sender_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);
		$sender_zone_id = $res1->row()->regionid;
		$reciver_zone_id = $this->input->post('receiver_zone_id');
		$doc_type = $this->input->post('doc_type');
		$chargable_weight = $this->input->post('chargable_weight');
		$chargable_weight1 = $this->input->post('chargable_weight');
		$receiver_gstno = $this->input->post('receiver_gstno');
		$booking_date = $this->input->post('booking_date');
		$invoice_value = $this->input->post('invoice_value');
		$dispatch_details = $this->input->post('dispatch_details');
		$current_date = date("Y-m-d", strtotime($booking_date));
		$chargable_weight = $chargable_weight * 1000;
		$fixed_perkg = 0;
		$addtional_250 = 0;
		$addtional_500 = 0;
		$addtional_1000 = 0;
		$fixed_per_kg_1000 = 0;
		$tat = 0;
		$drum_perkg = 0;
		// print_r($_POST);die;
		$where = "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

		$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
			(customer_id='$customer_id' OR  customer_id=0)
			AND from_zone_id='$sender_zone_id' AND to_zone_id='$reciver_zone_id'
			AND (from_state_id='$sender_state' OR from_state_id=0)
			AND (from_city_id='$sender_city' OR  from_city_id=0)
			AND (city_id='$reciver_city' OR  city_id=0)
			AND (state_id='$reciver_state' || state_id=0)
			AND (mode_id='$mode_id' || mode_id=0)
			AND DATE(`applicable_from`)<='$current_date'
			AND DATE(`applicable_to`)>='$current_date'
			AND fixed_perkg <> '6'
			AND ($actual_weight
			BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");
		$values = $fixed_perkg_result->row();
		// echo $this->db->last_query();die;
		if (!empty($values)) {

			if ($values->minimum_weight >= $actual_weight) {
				$weight = ceil($values->minimum_weight);
			} else {
				$weight = ceil($actual_weight);
			}
			if (!empty($weight)) {
				echo json_encode($weight);
			} else {
				echo $weight = "No Rate";
				json_encode($weight);
			}

		}

	}

	public function customerStock_Auth(){
		$pod_no = $this->input->post('LR');
		$customer_id = $this->input->post('customer_id');
		if(!empty($pod_no)&& !empty($customer_id)){
			$stock = $this->db->query("SELECT * FROM tbl_customer_assign_cnode WHERE customer_id ='$customer_id' AND (" . $pod_no . " BETWEEN seriess_from AND seriess_to)")->row();
			if(!empty($stock)){
				$data['stock']=1;
			}else{
				$data['stock'] = 2;
			}
			echo json_encode($data);
		}
        
	}

	public function get_perbox_rate()
	{
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);

		$sub_total = 0;
		$customer_id = $this->input->post('customer_id');
		$c_courier_id = $this->input->post('c_courier_id');
		$mode_id = $this->input->post('mode_id');
		$reciver_city = $this->input->post('city');
		$reciver_state = $this->input->post('state');
		$sender_state = $this->input->post('sender_state');
		$sender_city = $this->input->post('sender_city');
		$is_appointment = $this->input->post('is_appointment');
		$packet = $this->input->post('packet');
		$actual_weight = $this->input->post('actual_weight');
		$whr1 = array('state' => $sender_state, 'city' => $sender_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);
		$sender_zone_id = $res1->row()->regionid;
		$reciver_zone_id = $this->input->post('receiver_zone_id');
		$doc_type = $this->input->post('doc_type');
		$chargable_weight = $this->input->post('chargable_weight');
		$chargable_weight1 = $this->input->post('chargable_weight');
		$receiver_gstno = $this->input->post('receiver_gstno');
		$booking_date = $this->input->post('booking_date');
		$invoice_value = $this->input->post('invoice_value');
		$dispatch_details = $this->input->post('dispatch_details');
		$per_box = $this->input->post('per_box');
		$perBox_actual = $this->input->post('perBox_actual');
		$current_date = date("Y-m-d", strtotime($booking_date));
		$chargable_weight = $chargable_weight * 1000;
		$fixed_perkg = 0;
		$addtional_250 = 0;
		$addtional_500 = 0;
		$addtional_1000 = 0;
		$fixed_per_kg_1000 = 0;
		$tat = 0;
		$drum_perkg = 0;
		// print_r($_POST);die;
		$actual_weight_exp = explode(',', $perBox_actual);
		$per_box_exp = explode(',', $per_box);
		//  print_r($actual_weight_exp);die;
		$rate_all = [];
		$not_d_rate = [];


		for ($i = 0; $i <= count($actual_weight_exp); $i++) {
			if (!empty($actual_weight_exp[$i]) && !empty($per_box_exp[$i])) {
				$weight = $actual_weight_exp[$i] / $per_box_exp[$i];


				$where = "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

				$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
						(customer_id='$customer_id' OR  customer_id=0)
						AND from_zone_id='$sender_zone_id' AND to_zone_id='$reciver_zone_id'
						AND (from_state_id='$sender_state' OR from_state_id=0)
						AND (from_city_id='$sender_city' OR  from_city_id=0)
						AND (city_id='$reciver_city' OR  city_id=0)
						AND (state_id='$reciver_state' || state_id=0)
						AND (mode_id='$mode_id' || mode_id=0)
						AND DATE(`applicable_from`)<='$current_date'
						AND DATE(`applicable_to`)>='$current_date'
						AND fixed_perkg = '6'
						AND ($weight
						BETWEEN weight_range_from AND weight_range_to)  
						ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");
				$values = $fixed_perkg_result->row();
                // echo $this->db->last_query();die;
				if ($fixed_perkg_result->num_rows() == 0) {
					$not_d_rate[] = +$weight;
				}

				if (!empty($values->rate)) {
					$rate_all[] = +$values->rate;
					$min_fright[] = +$values->minimum_rate;
					$minimum_rate = $values->minimum_rate;
				}
			}
		}

		$fright = [];
		$pack = array_values(array_filter($per_box_exp));
		foreach ($pack as $key1 => $weight) {
			foreach ($rate_all as $key => $rate_val) {
				if ($key1 == $key) {
					$fright2[] = +$rate_all[$key] * $pack[$key];
				}
			}
		}



		//  echo '<pre>';print_r(array_sum($fright));
		//  echo '<pre>';print_r($rate_all);

		//  echo '<pre>';print_r($not_d_rate);
		//  die;
		$frieht1 = array_sum($fright2);
		$value = max($min_fright);
        if($frieht1>$value)
		{
			$frieht = $frieht1;
			$amount =$frieht1;
		    $rate = $frieht1;
		}
		else
		{
			$frieht = $value;
			$amount =$value;
		    $rate = $value;
		}
	
		// $frieht = $fright;
		
		
		
// print_r($rate);die; 
		//	$whr1 = array('courier_id' => $c_courier_id);
		$whr1 = array('courier_id' => $c_courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => $customer_id);
		$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

		if (empty($res1)) {
			// echo "hi";
			// $whr1 = array('courier_id' => $c_courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => '0');
			// $res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$c_courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY courier_id DESC,customer_id DESC,fuel_from   DESC limit 1");

			// echo $this->db->last_query();

			// print_r($res1);exit();
		}

		// echo $this->db->last_query();exit();
		$fovExpiry = "";
		if ($res1) {
			$fuel_per = $res1->fuel_price;
			$fov = $res1->fov_min;
			$docket_charge = $res1->docket_charge;
			$fov_base = $res1->fov_base;
			$fov_min = $res1->fov_min;

			// echo "<pre>";
			// print_r($res1);exit();

			if ($dispatch_details != 'Cash' && $dispatch_details != 'COD') {
				$res1->cod = 0;
			}
			$appt_charges = 0;
			if ($is_appointment == 1) {
				// $res1->appointment_perkg 
				$appt_charges = ($res1->appointment_perkg * $this->input->post('chargable_weight'));

				if ($res1->appointment_min > $appt_charges) {
					$appt_charges = $res1->appointment_min;
				}
			}
			

			if ($dispatch_details != 'ToPay') {
				$res1->to_pay_charges = 0;
			}

			// if ($fov_base) {
			// 	# code...
			// }

			if ($invoice_value >= $fov_base) {
				$fov = (($invoice_value / 100) * $res1->fov_above);
			} elseif ($invoice_value < $res1->fov_base) {
				$fov = (($invoice_value / 100) * $res1->fov_below);
			}

			if ($fov < $fov_min) {
				$fov = $fov_min;
			}

			if ($dispatch_details == 'COD') {
				if ($res1->cod != 0) {
					$cod_detail_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN cod_range_from and cod_range_to)");
					if (!empty($cod_detail_Range)) {
						$res1->cod = ($invoice_value * $cod_detail_Range->cod_range_rate / 100);
					}
				}

			} else {
				$res1->cod = 0;
			}

			if ($dispatch_details == 'ToPay') {

				$to_pay_charges_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN topay_range_from and topay_range_to)");
				// echo $this->db->last_query();die;
				if (!empty($to_pay_charges_Range)) {
					$res1->to_pay_charges = ($invoice_value * $to_pay_charges_Range->topay_range_rate / 100);
				}
				// print_r($res1->to_pay_charges);die;
			} else {
				$res1->to_pay_charges = 0;
			}


			$to_pay_charges = $res1->to_pay_charges;


			if ($res1->fc_type == 'freight') {
				$final_fuel_charges = ($amount * $fuel_per / 100);
				$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
			} else {
				$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
				$final_fuel_charges = ($amount * $fuel_per / 100);
			}
			$cft = $res1->cft;
			$cod = $res1->cod;



		} else {
			$fovExpiry = "VAS expired or not defined!";
			$cft = '0';
			$cod = '0';
			$fov = '0';
			$to_pay_charges = '0';
			$appt_charges = '0';
			$fuel_per = '0';
			$docket_charge = '0';
			$amount = $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
			$final_fuel_charges = ($amount * $fuel_per / 100);
		}

		//Cash


		$sub_total = ($amount + $final_fuel_charges);
		$isMinimumValue = "";
		if ($minimum_rate > $sub_total) {
			$sub_total = $minimum_rate;
			$isMinimumValue = "minimum value apply";
		}

		if ($dispatch_details == 'Cash') {
			$username = $this->session->userdata("userName");
			$whr11 = array('username' => $username);
			$res11 = $this->basic_operation_m->getAll('tbl_users', $whr11);
			$branch_id = $res11->row()->branch_id;

			$branch_info = $this->db->get_where('tbl_branch', ['branch_id' => $branch_id])->row();

			$state_info = $this->db->get_where('state', ['id' => $sender_state])->row();

			$first_two_char_branch = substr(trim($branch_info->gst_number), 0, 2);
			// print_r($first_two_char_branch);die;
			if ($first_two_char_branch == $state_info->statecode) {
				$cgst = ($sub_total * 9 / 100);
				$sgst = ($sub_total * 9 / 100);
				$igst = 0;
				$grand_total = $sub_total + $cgst + $sgst + $igst;
			} else {
				$cgst = 0;
				$sgst = 0;
				$igst = ($sub_total * 18 / 100);
				$grand_total = $sub_total + $igst;
			}
		} else {
			$first_two_char = substr($receiver_gstno, 0, 2);

			if ($receiver_gstno == "") {
				$first_two_char = 27;
			}

			$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id' and isdeleted  = '0' ");

			if ($tbl_customers_info->gst_charges == 1) {
				if ($first_two_char == 27) {
					$cgst = ($sub_total * 9 / 100);
					$sgst = ($sub_total * 9 / 100);
					$igst = 0;
					$grand_total = $sub_total + $cgst + $sgst + $igst;
				} else {
					$cgst = 0;
					$sgst = 0;
					$igst = ($sub_total * 18 / 100);
					$grand_total = $sub_total + $igst;
				}
			} else {
				$cgst = 0;
				$sgst = 0;
				$igst = 0;
				$grand_total = $sub_total + $igst;
			}
		}



		if ($tat > 0) {
			$tat_date = date('Y-m-d', strtotime($booking_date . " + $tat days"));
		} else {
			$tat_date = date('Y-m-d', strtotime($booking_date . " + 5 days"));
		}

		// print_r($rate);die;

		if (!empty($rate)) {
			$data = array(
				//'query' => $query,
				'sender_zone_id' => $sender_zone_id,
				'rate' => $rate,
				'reciver_zone_id' => $reciver_zone_id,
				'min_weight' => $minimum_rate,
				'chargable_weight' => $chargable_weight,
				'frieht' => round($frieht, 2),
				'fov' => round($fov, 2),
				'appt_charges' => round($appt_charges, 2),
				'docket_charge' => round($docket_charge, 2),
				'amount' => round($amount, 2),
				'cod' => round($cod, 2),
				'cft' => round($cft, 2),
				'to_pay_charges' => round($to_pay_charges, 2),
				'final_fuel_charges' => round($final_fuel_charges, 2),
				'sub_total' => number_format($sub_total, 2, '.', ''),
				'cgst' => number_format($cgst, 2, '.', ''),
				'sgst' => number_format($sgst, 2, '.', ''),
				'igst' => number_format($igst, 2, '.', ''),
				'grand_total' => number_format($grand_total, 2, '.', ''),
				'isMinimumValue' => $isMinimumValue,
				'fovExpiry' => $fovExpiry,
				'Message' => '',
			);

			if (!empty($not_d_rate)) {
				$rate = implode(" ", $not_d_rate);
				$data['rate_message'] = 'This Weight detials are rate not defined ' . $rate;
			} else {
				$data['rate_message'] = '';
			}
			//die;
		}
		//  else{
		// 	$data['rate_message'] = '';
		// 	$data['Message'] = 'Rate Not defined Please check Rate';
		//  }

		echo json_encode($data);
		exit;
	}
	// public function get_perbox_rate()
	// {
	// 	ini_set('display_errors', '0');
	// 	ini_set('display_startup_errors', '0');
	// 	error_reporting(E_ALL);

	// 	$sub_total = 0;
	// 	$customer_id = $this->input->post('customer_id');
	// 	$c_courier_id = $this->input->post('c_courier_id');
	// 	$mode_id = $this->input->post('mode_id');
	// 	$reciver_city = $this->input->post('city');
	// 	$reciver_state = $this->input->post('state');
	// 	$sender_state = $this->input->post('sender_state');
	// 	$sender_city = $this->input->post('sender_city');
	// 	$is_appointment = $this->input->post('is_appointment');
	// 	$packet = $this->input->post('packet');
	// 	$actual_weight = $this->input->post('actual_weight');
	// 	$whr1 = array('state' => $sender_state, 'city' => $sender_city);
	// 	$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);
	// 	$sender_zone_id = $res1->row()->regionid;
	// 	$reciver_zone_id = $this->input->post('receiver_zone_id');
	// 	$doc_type = $this->input->post('doc_type');
	// 	$chargable_weight = $this->input->post('chargable_weight');
	// 	$chargable_weight1 = $this->input->post('chargable_weight');
	// 	$receiver_gstno = $this->input->post('receiver_gstno');
	// 	$booking_date = $this->input->post('booking_date');
	// 	$invoice_value = $this->input->post('invoice_value');
	// 	$dispatch_details = $this->input->post('dispatch_details');
	// 	$per_box = $this->input->post('per_box');
	// 	$perBox_actual = $this->input->post('perBox_actual');
	// 	$current_date = date("Y-m-d", strtotime($booking_date));
	// 	$chargable_weight = $chargable_weight * 1000;
	// 	$fixed_perkg = 0;
	// 	$addtional_250 = 0;
	// 	$addtional_500 = 0;
	// 	$addtional_1000 = 0;
	// 	$fixed_per_kg_1000 = 0;
	// 	$tat = 0;
	// 	$drum_perkg = 0;
	// 	// print_r($_POST);die;
	// 	$actual_weight_exp = explode(',', $perBox_actual);
	// 	$per_box_exp = explode(',', $per_box);
	// 	//  print_r($actual_weight_exp);die;
	// 	$rate_all = [];
	// 	$not_d_rate = [];


	// 	for ($i = 0; $i <= count($actual_weight_exp); $i++) {
	// 		if (!empty($actual_weight_exp[$i]) && !empty($per_box_exp[$i])) {
	// 			$weight = $actual_weight_exp[$i] / $per_box_exp[$i];


	// 			$where = "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

	// 			$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
	// 					(customer_id='$customer_id' OR  customer_id=0)
	// 					AND from_zone_id='$sender_zone_id' AND to_zone_id='$reciver_zone_id'
	// 					AND (from_state_id='$sender_state' OR from_state_id=0)
	// 					AND (from_city_id='$sender_city' OR  from_city_id=0)
	// 					AND (city_id='$reciver_city' OR  city_id=0)
	// 					AND (state_id='$reciver_state' || state_id=0)
	// 					AND (mode_id='$mode_id' || mode_id=0)
	// 					AND DATE(`applicable_from`)<='$current_date'
	// 					AND DATE(`applicable_to`)>='$current_date'
	// 					AND fixed_perkg = '6'
	// 					AND ($weight
	// 					BETWEEN weight_range_from AND weight_range_to)  
	// 					ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");
	// 			$values = $fixed_perkg_result->row();

	// 			if ($fixed_perkg_result->num_rows() == 0) {
	// 				$not_d_rate[] = +$weight;
	// 			}

	// 			if (!empty($values->rate)) {
	// 				$rate_all[] = +$values->rate;
	// 				$minimum_rate = $values->minimum_rate;
	// 			}
	// 		}
	// 	}

	// 	$fright = [];
	// 	$pack = array_values(array_filter($per_box_exp));
	// 	foreach ($pack as $key1 => $weight) {
	// 		foreach ($rate_all as $key => $rate_val) {
	// 			if ($key1 == $key) {
	// 				$fright[] = +$rate_all[$key] * $pack[$key];
	// 			}
	// 		}
	// 	}



	// 	//  echo '<pre>';print_r(array_sum($fright));
	// 	//  echo '<pre>';print_r($rate_all);

	// 	//  echo '<pre>';print_r($not_d_rate);
	// 	//  die;

	// 	$frieht = array_sum($fright);
	// 	$amount = array_sum($fright);
	// 	$rate = array_sum($fright);


	// 	//	$whr1 = array('courier_id' => $c_courier_id);
	// 	$whr1 = array('courier_id' => $c_courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => $customer_id);
	// 	$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

	// 	if (empty($res1)) {
	// 		// echo "hi";
	// 		// $whr1 = array('courier_id' => $c_courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => '0');
	// 		// $res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$c_courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY courier_id DESC,customer_id DESC,fuel_from   DESC limit 1");

	// 		// echo $this->db->last_query();

	// 		// print_r($res1);exit();
	// 	}

	// 	// echo $this->db->last_query();exit();
	// 	$fovExpiry = "";
	// 	if ($res1) {
	// 		$fuel_per = $res1->fuel_price;
	// 		$fov = $res1->fov_min;
	// 		$docket_charge = $res1->docket_charge;
	// 		$fov_base = $res1->fov_base;
	// 		$fov_min = $res1->fov_min;

	// 		// echo "<pre>";
	// 		// print_r($res1);exit();

	// 		if ($dispatch_details != 'Cash' && $dispatch_details != 'COD') {
	// 			$res1->cod = 0;
	// 		}
	// 		$appt_charges = 0;
	// 		if ($is_appointment == 1) {
	// 			// $res1->appointment_perkg 
	// 			$appt_charges = ($res1->appointment_perkg * $this->input->post('chargable_weight'));

	// 			if ($res1->appointment_min > $appt_charges) {
	// 				$appt_charges = $res1->appointment_min;
	// 			}
	// 		}
	// 		// print_r($appt_charges);die;

	// 		if ($dispatch_details != 'ToPay') {
	// 			$res1->to_pay_charges = 0;
	// 		}

	// 		// if ($fov_base) {
	// 		// 	# code...
	// 		// }

	// 		if ($invoice_value >= $fov_base) {
	// 			$fov = (($invoice_value / 100) * $res1->fov_above);
	// 		} elseif ($invoice_value < $res1->fov_base) {
	// 			$fov = (($invoice_value / 100) * $res1->fov_below);
	// 		}

	// 		if ($fov < $fov_min) {
	// 			$fov = $fov_min;
	// 		}

	// 		if ($dispatch_details == 'COD') {
	// 			if ($res1->cod != 0) {
	// 				$cod_detail_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN cod_range_from and cod_range_to)");
	// 				if (!empty($cod_detail_Range)) {
	// 					$res1->cod = ($invoice_value * $cod_detail_Range->cod_range_rate / 100);
	// 				}
	// 			}

	// 		} else {
	// 			$res1->cod = 0;
	// 		}

	// 		if ($dispatch_details == 'ToPay') {

	// 			$to_pay_charges_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN topay_range_from and topay_range_to)");
	// 			// echo $this->db->last_query();die;
	// 			if (!empty($to_pay_charges_Range)) {
	// 				$res1->to_pay_charges = ($invoice_value * $to_pay_charges_Range->topay_range_rate / 100);
	// 			}
	// 			// print_r($res1->to_pay_charges);die;
	// 		} else {
	// 			$res1->to_pay_charges = 0;
	// 		}


	// 		$to_pay_charges = $res1->to_pay_charges;


	// 		if ($res1->fc_type == 'freight') {
	// 			$final_fuel_charges = ($amount * $fuel_per / 100);
	// 			$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
	// 		} else {
	// 			$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
	// 			$final_fuel_charges = ($amount * $fuel_per / 100);
	// 		}
	// 		$cft = $res1->cft;
	// 		$cod = $res1->cod;



	// 	} else {
	// 		$fovExpiry = "VAS expired or not defined!";
	// 		$cft = '0';
	// 		$cod = '0';
	// 		$fov = '0';
	// 		$to_pay_charges = '0';
	// 		$appt_charges = '0';
	// 		$fuel_per = '0';
	// 		$docket_charge = '0';
	// 		$amount = $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
	// 		$final_fuel_charges = ($amount * $fuel_per / 100);
	// 	}

	// 	//Cash


	// 	$sub_total = ($amount + $final_fuel_charges);
	// 	$isMinimumValue = "";
	// 	if ($minimum_rate > $sub_total) {
	// 		$sub_total = $minimum_rate;
	// 		$isMinimumValue = "minimum value apply";
	// 	}

	// 	if ($dispatch_details == 'Cash') {
	// 		$username = $this->session->userdata("userName");
	// 		$whr11 = array('username' => $username);
	// 		$res11 = $this->basic_operation_m->getAll('tbl_users', $whr11);
	// 		$branch_id = $res11->row()->branch_id;

	// 		$branch_info = $this->db->get_where('tbl_branch', ['branch_id' => $branch_id])->row();

	// 		$state_info = $this->db->get_where('state', ['id' => $sender_state])->row();

	// 		$first_two_char_branch = substr(trim($branch_info->gst_number), 0, 2);
	// 		// print_r($first_two_char_branch);die;
	// 		if ($first_two_char_branch == $state_info->statecode) {
	// 			$cgst = ($sub_total * 9 / 100);
	// 			$sgst = ($sub_total * 9 / 100);
	// 			$igst = 0;
	// 			$grand_total = $sub_total + $cgst + $sgst + $igst;
	// 		} else {
	// 			$cgst = 0;
	// 			$sgst = 0;
	// 			$igst = ($sub_total * 18 / 100);
	// 			$grand_total = $sub_total + $igst;
	// 		}
	// 	} else {
	// 		$first_two_char = substr($receiver_gstno, 0, 2);

	// 		if ($receiver_gstno == "") {
	// 			$first_two_char = 27;
	// 		}

	// 		$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id' and isdeleted  = '0' ");

	// 		if ($tbl_customers_info->gst_charges == 1) {
	// 			if ($first_two_char == 27) {
	// 				$cgst = ($sub_total * 9 / 100);
	// 				$sgst = ($sub_total * 9 / 100);
	// 				$igst = 0;
	// 				$grand_total = $sub_total + $cgst + $sgst + $igst;
	// 			} else {
	// 				$cgst = 0;
	// 				$sgst = 0;
	// 				$igst = ($sub_total * 18 / 100);
	// 				$grand_total = $sub_total + $igst;
	// 			}
	// 		} else {
	// 			$cgst = 0;
	// 			$sgst = 0;
	// 			$igst = 0;
	// 			$grand_total = $sub_total + $igst;
	// 		}
	// 	}



	// 	if ($tat > 0) {
	// 		$tat_date = date('Y-m-d', strtotime($booking_date . " + $tat days"));
	// 	} else {
	// 		$tat_date = date('Y-m-d', strtotime($booking_date . " + 5 days"));
	// 	}

	// 	if (!empty($rate)) {
	// 		$data = array(
	// 			//'query' => $query,
	// 			'sender_zone_id' => $sender_zone_id,
	// 			'rate' => $rate,
	// 			'reciver_zone_id' => $reciver_zone_id,
	// 			'min_weight' => $minimum_weight1,
	// 			'chargable_weight' => $chargable_weight,
	// 			'frieht' => round($frieht, 2),
	// 			'fov' => round($fov, 2),
	// 			'appt_charges' => round($appt_charges, 2),
	// 			'docket_charge' => round($docket_charge, 2),
	// 			'amount' => round($amount, 2),
	// 			'cod' => round($cod, 2),
	// 			'cft' => round($cft, 2),
	// 			'to_pay_charges' => round($to_pay_charges, 2),
	// 			'final_fuel_charges' => round($final_fuel_charges, 2),
	// 			'sub_total' => number_format($sub_total, 2, '.', ''),
	// 			'cgst' => number_format($cgst, 2, '.', ''),
	// 			'sgst' => number_format($sgst, 2, '.', ''),
	// 			'igst' => number_format($igst, 2, '.', ''),
	// 			'grand_total' => number_format($grand_total, 2, '.', ''),
	// 			'isMinimumValue' => $isMinimumValue,
	// 			'fovExpiry' => $fovExpiry,
	// 			'Message' => '',
	// 		);

	// 		if (!empty($not_d_rate)) {
	// 			$rate = implode(" ", $not_d_rate);
	// 			$data['rate_message'] = 'This Weight detials are rate not defined ' . $rate;
	// 		} else {
	// 			$data['rate_message'] = '';
	// 		}
	// 		//die;
	// 	}
	// 	//  else{
	// 	// 	$data['rate_message'] = '';
	// 	// 	$data['Message'] = 'Rate Not defined Please check Rate';
	// 	//  }

	// 	echo json_encode($data);
	// 	exit;
	// }
	
	// public function add_new_rate_domestic()
	// {
	// 	ini_set('display_errors', 0);
	// 	ini_set('display_startup_errors', 0);
	// 	error_reporting(E_ALL);
	// 	$sub_total = 0;
	// 	$customer_id = $this->input->post('customer_id');
	// 	$c_courier_id = $this->input->post('c_courier_id');
	// 	$mode_id = $this->input->post('mode_id');
	// 	$reciver_city = $this->input->post('city');
	// 	$reciver_state = $this->input->post('state');
	// 	$sender_state = $this->input->post('sender_state');
	// 	$sender_city = $this->input->post('sender_city');
	// 	$is_appointment = $this->input->post('is_appointment');
	// 	$packet = $this->input->post('packet');
	// 	// $invoice_value = $this->input->post('invoice_value');
	// 	// print_r($_POST);		die;

	// 	$whr1 = array('state' => $sender_state, 'city' => $sender_city);
	// 	$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

	// 	$sender_zone_id = $res1->row()->regionid;
	// 	$reciver_zone_id = $this->input->post('receiver_zone_id');

	// 	$doc_type = $this->input->post('doc_type');
	// 	$actual_weight = $this->input->post('actual_weight');
	// 	$chargable_weight = $this->input->post('chargable_weight');
	// 	$receiver_gstno = $this->input->post('receiver_gstno');
	// 	$booking_date = $this->input->post('booking_date');
	// 	$invoice_value = $this->input->post('invoice_value');
	// 	$dispatch_details = $this->input->post('dispatch_details');
	// 	$current_date = date("Y-m-d", strtotime($booking_date));
	// 	$chargable_weight = $chargable_weight * 1000;
	// 	$fixed_perkg = 0;
	// 	$addtional_250 = 0;
	// 	$addtional_500 = 0;
	// 	$addtional_1000 = 0;
	// 	$fixed_per_kg_1000 = 0;
	// 	$tat = 0;
	// 	$drum_perkg = 0;

	// 	$where = "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

	// 	$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
	// 		(customer_id=" . $customer_id . " OR  customer_id=0)
	// 		AND from_zone_id=" . $sender_zone_id . " AND to_zone_id=" . $reciver_zone_id . "
	// 		AND (from_state_id=" . $sender_state . " OR from_state_id=0)
	// 		AND (from_city_id=" . $sender_city . " OR  from_city_id=0)
	// 		AND (city_id=" . $reciver_city . " OR  city_id=0)
	// 		AND (state_id=" . $reciver_state . " OR state_id=0)
	// 		AND (mode_id=" . $mode_id . " OR mode_id=0)
	// 		AND DATE(`applicable_from`)<='" . $current_date . "'
	// 		AND DATE(`applicable_to`)>='" . $current_date . "'
	// 		AND fixed_perkg <> '6'
	// 		AND (" . $this->input->post('actual_weight') . "
	// 		BETWEEN weight_range_from AND weight_range_to)  
	// 		ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");

	// 	$frieht = 0;
	// 	$minimum_rate = 0;
	// 	$query = $this->db->last_query(); //die;
	// 	// echo $this->db->last_query(); die;
	// 	// echo "<pre>"; print_r($fixed_perkg_result->num_rows()); die;

	// 	if ($fixed_perkg_result->num_rows() > 0) {

	// 		// echo "4444uuuu<pre>";
	// 		$rate_master = $fixed_perkg_result->result();

	// 		// print_r($rate_master);exit();
	// 		$minimum_rate = $rate_master[0]->minimum_rate;

	// 		$weight_range_to = round($rate_master[0]->weight_range_to * 1000);
	// 		$left_weight = ($chargable_weight - $weight_range_to);

	// 		foreach ($rate_master as $key => $values) {
	// 			$tat = $values->tat;
	// 			$rate = $values->rate;
	// 			$minimum_weight1 = $values->minimum_weight;
	// 			if ($values->fixed_perkg == 0) // 250 gm slab
	// 			{

	// 				// $fixed_perkg = 0;
	// 				// $addtional_250 = 0;
	// 				// $addtional_500 = 0;
	// 				// $addtional_1000 = 0;
	// 				// $rate = $values->rate;
	// 				$fixed_perkg = $values->rate;
	// 			}

	// 			if ($values->fixed_perkg == 1) // 250 gm slab
	// 			{

	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = $slab_weight / 250;
	// 				$addtional_250 = $addtional_250 + $total_slab * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}

	// 			if ($values->fixed_perkg == 2) // 500 gm slab
	// 			{
	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;

	// 				if ($slab_weight < 1000) {
	// 					if ($slab_weight <= 500) {
	// 						$slab_weight = 500;
	// 					} else {
	// 						$slab_weight = 1000;
	// 					}

	// 				} else {
	// 					$diff_ceil = $slab_weight % 1000;
	// 					$slab_weight = $slab_weight - $diff_ceil;

	// 					if ($diff_ceil <= 500 && $diff_ceil != 0) {

	// 						$slab_weight = $slab_weight + 500;
	// 					} elseif ($diff_ceil <= 1000 && $diff_ceil != 0) {

	// 						$slab_weight = $slab_weight + 1000;
	// 					}


	// 				}

	// 				$total_slab = $slab_weight / 500;
	// 				$addtional_500 = $addtional_500 + $total_slab * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;

	// 			}

	// 			if ($values->fixed_perkg == 3) // 1000 gm slab
	// 			{
	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = ceil($slab_weight / 1000);

	// 				$addtional_1000 = $addtional_1000 + $total_slab * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}
	// 			// echo "hsdskjdhaskjda";exit();
	// 			if ($values->fixed_perkg == 4 && ($this->input->post('actual_weight') >= $values->weight_range_from && $this->input->post('actual_weight') <= $values->weight_range_to)) // 1000 gm slab
	// 			{
	// 				// echo "hsdskjdhaskjda";exit();
	// 				//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = ceil($chargable_weight / 1000);

	// 				$fixed_perkg = 0;
	// 				$addtional_250 = 0;
	// 				$addtional_500 = 0;
	// 				$addtional_1000 = 0;
	// 				$rate = $values->rate;
	// 				// $frieht= $values->rate;
	// 				// $fixed_per_kg_1000 = floatval($packet) * floatval($values->rate);
	// 				$fixed_per_kg_1000 = floatval($total_slab) * floatval($values->rate);

	// 				$left_weight = $left_weight - $slab_weight;
	// 			}
	// 			// else{
	// 			// 	$fixed_per_kg_1000 = floatval($packet) * floatval($values->rate);
	// 			// }
	// 			//  print_r($values->rate);exit();
	// 			if ($values->fixed_perkg == 5) // Box Fixed slab
	// 			{

	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = $slab_weight / 250;
	// 				$addtional_250 = $addtional_250 + $total_slab * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}

	// 			if ($values->fixed_perkg == 6) // Per box
	// 			{
	// 				// echo "hsdskjdhaskjda";exit();
	// 				//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = ceil($chargable_weight / 1000);

	// 				$fixed_perkg = 0;
	// 				$addtional_250 = 0;
	// 				$addtional_500 = 0;
	// 				$addtional_1000 = 0;
	// 				$rate = $values->rate;
	// 				// $frieht= $values->rate;
	// 				$fixed_per_kg_1000 = 0;
	// 				$drum_perkg = $packet * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}

	// 			if ($values->fixed_perkg == 7) // Drum fixed slab
	// 			{

	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = $slab_weight / 250;
	// 				$addtional_250 = $addtional_250 + $total_slab * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}

	// 			if ($values->fixed_perkg == 8) // 1000 gm slab
	// 			{
	// 				// echo "hsdskjdhaskjda";exit();
	// 				//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = ceil($chargable_weight / 1000);

	// 				$fixed_perkg = 0;
	// 				$addtional_250 = 0;
	// 				$addtional_500 = 0;
	// 				$addtional_1000 = 0;
	// 				$rate = $values->rate;
	// 				// $frieht= $values->rate;
	// 				$fixed_per_kg_1000 = 0;
	// 				$drum_perkg = $packet * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}
	// 		}

	// 	}
	// 	// print_r($drum_perkg);die;

	// 	$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000 + $drum_perkg;
	// 	$amount = $frieht;
	// 	// print_r($fixed_per_kg_1000);die;

	// 	//	$whr1 = array('courier_id' => $c_courier_id);
	// 	$whr1 = array('courier_id' => $c_courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => $customer_id);
	// 	$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

	// 	if (empty($res1)) {
	// 		// echo "hi";
	// 		// $whr1 = array('courier_id' => $c_courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => '0');
	// 		// $res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$c_courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY courier_id DESC,customer_id DESC,fuel_from   DESC limit 1");

	// 		// echo $this->db->last_query();

	// 		// print_r($res1);exit();
	// 	}

	// 	// echo $this->db->last_query();exit();
	// 	$fovExpiry = "";
	// 	if ($res1) {
	// 		$fuel_per = $res1->fuel_price;
	// 		$fov = $res1->fov_min;
	// 		$docket_charge = $res1->docket_charge;
	// 		$fov_base = $res1->fov_base;
	// 		$fov_min = $res1->fov_min;

	// 		// echo "<pre>";
	// 		// print_r($res1);exit();

	// 		if ($dispatch_details != 'Cash' && $dispatch_details != 'COD') {
	// 			$res1->cod = 0;
	// 		}
	// 		$appt_charges = 0;
	// 		if ($is_appointment == 1) {
	// 			// $res1->appointment_perkg 
	// 			$appt_charges = ($res1->appointment_perkg * $this->input->post('chargable_weight'));

	// 			if ($res1->appointment_min > $appt_charges) {
	// 				$appt_charges = $res1->appointment_min;
	// 			}
	// 		}
	// 		// print_r($appt_charges);die;

	// 		if ($dispatch_details != 'ToPay') {
	// 			$res1->to_pay_charges = 0;
	// 		}

	// 		// if ($fov_base) {
	// 		// 	# code...
	// 		// }

	// 		if ($invoice_value >= $fov_base) {
	// 			$fov = (($invoice_value / 100) * $res1->fov_above);
	// 		} elseif ($invoice_value < $res1->fov_base) {
	// 			$fov = (($invoice_value / 100) * $res1->fov_below);
	// 		}

	// 		if ($fov < $fov_min) {
	// 			$fov = $fov_min;
	// 		}

	// 		if ($dispatch_details == 'COD') {
	// 			if ($res1->cod != 0) {
	// 				$cod_detail_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN cod_range_from and cod_range_to)");
	// 				if (!empty($cod_detail_Range)) {
	// 					$res1->cod = ($invoice_value * $cod_detail_Range->cod_range_rate / 100);
	// 				}
	// 			}

	// 		} else {
	// 			$res1->cod = 0;
	// 		}

	// 		if ($dispatch_details == 'ToPay') {

	// 			$to_pay_charges_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN topay_range_from and topay_range_to)");
	// 			// echo $this->db->last_query();die;
	// 			if (!empty($to_pay_charges_Range)) {
	// 				$res1->to_pay_charges = ($invoice_value * $to_pay_charges_Range->topay_range_rate / 100);
	// 			}
	// 			// print_r($res1->to_pay_charges);die;
	// 		} else {
	// 			$res1->to_pay_charges = 0;
	// 		}


	// 		$to_pay_charges = $res1->to_pay_charges;


	// 		if ($res1->fc_type == 'freight') {
	// 			$final_fuel_charges = ($amount * $fuel_per / 100);
	// 			$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
	// 		} else {
	// 			$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
	// 			$final_fuel_charges = ($amount * $fuel_per / 100);
	// 		}
	// 		$cft = $res1->cft;
	// 		$cod = $res1->cod;



	// 	} else {
	// 		$fovExpiry = "VAS expired or not defined!";
	// 		$cft = '0';
	// 		$cod = '0';
	// 		$fov = '0';
	// 		$to_pay_charges = '0';
	// 		$appt_charges = '0';
	// 		$fuel_per = '0';
	// 		$docket_charge = '0';
	// 		$amount = $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
	// 		$final_fuel_charges = ($amount * $fuel_per / 100);
	// 	}

	// 	//Cash


	// 	$sub_total = ($amount + $final_fuel_charges);
	// 	$isMinimumValue = "";
	// 	if ($minimum_rate > $sub_total) {
	// 		$sub_total = $minimum_rate;
	// 		$isMinimumValue = "minimum value apply";
	// 	}

	// 	if ($dispatch_details == 'Cash') {
	// 		$username = $this->session->userdata("userName");
	// 		$whr11 = array('username' => $username);
	// 		$res11 = $this->basic_operation_m->getAll('tbl_users', $whr11);
	// 		$branch_id = $res11->row()->branch_id;

	// 		$branch_info = $this->db->get_where('tbl_branch', ['branch_id' => $branch_id])->row();

	// 		$state_info = $this->db->get_where('state', ['id' => $sender_state])->row();

	// 		$first_two_char_branch = substr(trim($branch_info->gst_number), 0, 2);
	// 		// print_r($first_two_char_branch);die;
	// 		if ($first_two_char_branch == $state_info->statecode) {
	// 			$cgst = ($sub_total * 9 / 100);
	// 			$sgst = ($sub_total * 9 / 100);
	// 			$igst = 0;
	// 			$grand_total = $sub_total + $cgst + $sgst + $igst;
	// 		} else {
	// 			$cgst = 0;
	// 			$sgst = 0;
	// 			$igst = ($sub_total * 18 / 100);
	// 			$grand_total = $sub_total + $igst;
	// 		}
	// 	} else {
	// 		$first_two_char = substr($receiver_gstno, 0, 2);

	// 		if ($receiver_gstno == "") {
	// 			$first_two_char = 27;
	// 		}

	// 		$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id' and isdeleted  = '0'");

	// 		if ($tbl_customers_info->gst_charges == 1) {
	// 			if ($first_two_char == 27) {
	// 				$cgst = ($sub_total * 9 / 100);
	// 				$sgst = ($sub_total * 9 / 100);
	// 				$igst = 0;
	// 				$grand_total = $sub_total + $cgst + $sgst + $igst;
	// 			} else {
	// 				$cgst = 0;
	// 				$sgst = 0;
	// 				$igst = ($sub_total * 18 / 100);
	// 				$grand_total = $sub_total + $igst;
	// 			}
	// 		} else {
	// 			$cgst = 0;
	// 			$sgst = 0;
	// 			$igst = 0;
	// 			$grand_total = $sub_total + $igst;
	// 		}
	// 	}



	// 	if ($tat > 0) {
	// 		$tat_date = date('Y-m-d', strtotime($booking_date . " + $tat days"));
	// 	} else {
	// 		$tat_date = date('Y-m-d', strtotime($booking_date . " + 5 days"));
	// 	}


	// 	$data = array(
	// 		//'query' => $query,
	// 		'sender_zone_id' => $sender_zone_id,
	// 		'rate' => $rate,
	// 		'reciver_zone_id' => $reciver_zone_id,
	// 		'min_weight' => $minimum_weight1,
	// 		'chargable_weight' => $chargable_weight,
	// 		'frieht' => round($frieht, 2),
	// 		'fov' => round($fov, 2),
	// 		'appt_charges' => round($appt_charges, 2),
	// 		'docket_charge' => round($docket_charge, 2),
	// 		'amount' => round($amount, 2),
	// 		'cod' => round($cod, 2),
	// 		'cft' => round($cft, 2),
	// 		'to_pay_charges' => round($to_pay_charges, 2),
	// 		'final_fuel_charges' => round($final_fuel_charges, 2),
	// 		'sub_total' => number_format($sub_total, 2, '.', ''),
	// 		'cgst' => number_format($cgst, 2, '.', ''),
	// 		'sgst' => number_format($sgst, 2, '.', ''),
	// 		'igst' => number_format($igst, 2, '.', ''),
	// 		'grand_total' => number_format($grand_total, 2, '.', ''),
	// 		'isMinimumValue' => $isMinimumValue,
	// 		'fovExpiry' => $fovExpiry,
	// 	);
	// 	echo json_encode($data);
	// 	exit;
	// }

	public function add_new_rate_domestic()
	{
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(E_ALL);
		$sub_total = 0;
		$customer_id = $this->input->post('customer_id');
		$c_courier_id = $this->input->post('c_courier_id');
		$mode_id = $this->input->post('mode_id');
		$reciver_city = $this->input->post('city');
		$reciver_state = $this->input->post('state');
		$sender_state = $this->input->post('sender_state');
		$sender_city = $this->input->post('sender_city');
		$is_appointment = $this->input->post('is_appointment');
		$packet = $this->input->post('packet');
		// $invoice_value = $this->input->post('invoice_value');
		// print_r($_POST);		die;

		$whr1 = array('state' => $sender_state, 'city' => $sender_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$sender_zone_id = $res1->row()->regionid;
		$reciver_zone_id = $this->input->post('receiver_zone_id');

		$doc_type = $this->input->post('doc_type');
		$actual_weight = $this->input->post('actual_weight');
		$chargable_weight = $this->input->post('chargable_weight');
		$receiver_gstno = $this->input->post('receiver_gstno');
		$booking_date = $this->input->post('booking_date');
		$invoice_value = $this->input->post('invoice_value');
		$dispatch_details = $this->input->post('dispatch_details');
		$current_date = date("Y-m-d", strtotime($booking_date));
		$chargable_weight = $chargable_weight * 1000;
		$fixed_perkg = 0;
		$addtional_250 = 0;
		$addtional_500 = 0;
		$addtional_1000 = 0;
		$fixed_per_kg_1000 = 0;
		$tat = 0;
		$drum_perkg = 0;

		$where = "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

		$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
			(customer_id=" . $customer_id . " OR  customer_id=0)
			AND from_zone_id=" . $sender_zone_id . " AND to_zone_id=" . $reciver_zone_id . "
			AND (from_state_id=" . $sender_state . " OR from_state_id=0)
			AND (from_city_id=" . $sender_city . " OR  from_city_id=0)
			AND (city_id=" . $reciver_city . " OR  city_id=0)
			AND (state_id=" . $reciver_state . " OR state_id=0)
			AND (mode_id=" . $mode_id . " OR mode_id=0)
			AND DATE(`applicable_from`)<='" . $current_date . "'
			AND DATE(`applicable_to`)>='" . $current_date . "'
			AND fixed_perkg <> '6'
			AND (" . $this->input->post('actual_weight') . "
			BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");

		$frieht = 0;
		$minimum_rate = 0;
		$query = $this->db->last_query(); //die;
		// echo $this->db->last_query(); die;
		// echo "<pre>"; print_r($fixed_perkg_result->num_rows()); die;

		if ($fixed_perkg_result->num_rows() > 0) {

			// echo "4444uuuu<pre>";
			$rate_master = $fixed_perkg_result->result();

			// print_r($rate_master);exit();
			$minimum_rate = $rate_master[0]->minimum_rate;

			$weight_range_to = round($rate_master[0]->weight_range_to * 1000);
			$left_weight = ($chargable_weight - $weight_range_to);

			foreach ($rate_master as $key => $values) {
				$tat = $values->tat;
				$rate = $values->rate;
				$minimum_weight1 = $values->minimum_weight;
				if ($values->fixed_perkg == 0) // 250 gm slab
				{

					// $fixed_perkg = 0;
					// $addtional_250 = 0;
					// $addtional_500 = 0;
					// $addtional_1000 = 0;
					// $rate = $values->rate;
					$fixed_perkg = $values->rate;
				}

				if ($values->fixed_perkg == 1) // 250 gm slab
				{

					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = $slab_weight / 250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if ($values->fixed_perkg == 2) // 500 gm slab
				{
					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;

					if ($slab_weight < 1000) {
						if ($slab_weight <= 500) {
							$slab_weight = 500;
						} else {
							$slab_weight = 1000;
						}

					} else {
						$diff_ceil = $slab_weight % 1000;
						$slab_weight = $slab_weight - $diff_ceil;

						if ($diff_ceil <= 500 && $diff_ceil != 0) {

							$slab_weight = $slab_weight + 500;
						} elseif ($diff_ceil <= 1000 && $diff_ceil != 0) {

							$slab_weight = $slab_weight + 1000;
						}


					}

					$total_slab = $slab_weight / 500;
					$addtional_500 = $addtional_500 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;

				}

				if ($values->fixed_perkg == 3) // 1000 gm slab
				{
					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = ceil($slab_weight / 1000);

					$addtional_1000 = $addtional_1000 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
				// echo "hsdskjdhaskjda";exit();
				if ($values->fixed_perkg == 4 && ($this->input->post('actual_weight') >= $values->weight_range_from && $this->input->post('actual_weight') <= $values->weight_range_to)) // 1000 gm slab
				{
					// echo "hsdskjdhaskjda";exit();
					//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = ceil($chargable_weight / 1000);

					$fixed_perkg = 0;
					$addtional_250 = 0;
					$addtional_500 = 0;
					$addtional_1000 = 0;
					$rate = $values->rate;
					// $frieht= $values->rate;
					// $fixed_per_kg_1000 = floatval($packet) * floatval($values->rate);
					$fixed_per_kg_1000 = floatval($total_slab) * floatval($values->rate);

					$left_weight = $left_weight - $slab_weight;
				}
				// else{
				// 	$fixed_per_kg_1000 = floatval($packet) * floatval($values->rate);
				// }
				//  print_r($values->rate);exit();
				if ($values->fixed_perkg == 5) // Box Fixed slab
				{

					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = $slab_weight / 250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if ($values->fixed_perkg == 6) // Per box
				{
					// echo "hsdskjdhaskjda";exit();
					//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = ceil($chargable_weight / 1000);

					$fixed_perkg = 0;
					$addtional_250 = 0;
					$addtional_500 = 0;
					$addtional_1000 = 0;
					$rate = $values->rate;
					// $frieht= $values->rate;
					$fixed_per_kg_1000 = 0;
					$drum_perkg = $packet * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if ($values->fixed_perkg == 7) // Drum fixed slab
				{

					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = $slab_weight / 250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if ($values->fixed_perkg == 8) // 1000 gm slab
				{
					// echo "hsdskjdhaskjda";exit();
					//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = ceil($chargable_weight / 1000);

					$fixed_perkg = 0;
					$addtional_250 = 0;
					$addtional_500 = 0;
					$addtional_1000 = 0;
					$rate = $values->rate;
					// $frieht= $values->rate;
					$fixed_per_kg_1000 = 0;
					$drum_perkg = $packet * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
			}

		}
		// print_r($drum_perkg);die;

		$frieht1 = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000 + $drum_perkg;
		if($minimum_rate>$frieht1)
		{
			$frieht = $minimum_rate;
		}else{
			$frieht = $frieht1;
		}
		$amount = $frieht;
		

		//	$whr1 = array('courier_id' => $c_courier_id);
		$whr1 = array('courier_id' => $c_courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => $customer_id);
		$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

		if (empty($res1)) {
			// echo "hi";
			// $whr1 = array('courier_id' => $c_courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => '0');
			// $res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$c_courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY courier_id DESC,customer_id DESC,fuel_from   DESC limit 1");

			// echo $this->db->last_query();

			// print_r($res1);exit();
		}

		// echo $this->db->last_query();exit();
		$fovExpiry = "";
		if ($res1) {
			$fuel_per = $res1->fuel_price;
			$fov = $res1->fov_min;
			$docket_charge = $res1->docket_charge;
			$fov_base = $res1->fov_base;
			$fov_min = $res1->fov_min;

			// echo "<pre>";
			// print_r($res1);exit();

			if ($dispatch_details != 'Cash' && $dispatch_details != 'COD') {
				$res1->cod = 0;
			}
			$appt_charges = 0;
			if ($is_appointment == 1) {
				// $res1->appointment_perkg 
				$appt_charges = ($res1->appointment_perkg * $this->input->post('chargable_weight'));

				if ($res1->appointment_min > $appt_charges) {
					$appt_charges = $res1->appointment_min;
				}
			}
			// print_r($appt_charges);die;

			if ($dispatch_details != 'ToPay') {
				$res1->to_pay_charges = 0;
			}

			// if ($fov_base) {
			// 	# code...
			// }

			if ($invoice_value >= $fov_base) {
				$fov = (($invoice_value / 100) * $res1->fov_above);
			} elseif ($invoice_value < $res1->fov_base) {
				$fov = (($invoice_value / 100) * $res1->fov_below);
			}

			if ($fov < $fov_min) {
				$fov = $fov_min;
			}

			if ($dispatch_details == 'COD') {
				if ($res1->cod != 0) {
					$cod_detail_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN cod_range_from and cod_range_to)");
					if (!empty($cod_detail_Range)) {
						$res1->cod = ($invoice_value * $cod_detail_Range->cod_range_rate / 100);
					}
				}

			} else {
				$res1->cod = 0;
			}

			if ($dispatch_details == 'ToPay') {

				$to_pay_charges_Range = $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN topay_range_from and topay_range_to)");
				// echo $this->db->last_query();die;
				if (!empty($to_pay_charges_Range)) {
					$res1->to_pay_charges = ($invoice_value * $to_pay_charges_Range->topay_range_rate / 100);
				}
				// print_r($res1->to_pay_charges);die;
			} else {
				$res1->to_pay_charges = 0;
			}


			$to_pay_charges = $res1->to_pay_charges;


			if ($res1->fc_type == 'freight') {
				$final_fuel_charges = ($amount * $fuel_per / 100);
				$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
			} else {
				$amount = $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
				$final_fuel_charges = ($amount * $fuel_per / 100);
			}
			$cft = $res1->cft;
			$cod = $res1->cod;



		} else {
			$fovExpiry = "VAS expired or not defined!";
			$cft = '0';
			$cod = '0';
			$fov = '0';
			$to_pay_charges = '0';
			$appt_charges = '0';
			$fuel_per = '0';
			$docket_charge = '0';
			$amount = $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
			$final_fuel_charges = ($amount * $fuel_per / 100);
		}

		//Cash


		$sub_total = ($amount + $final_fuel_charges);
		$isMinimumValue = "";
		if ($minimum_rate > $sub_total) {
			$sub_total = $minimum_rate;
			$isMinimumValue = "minimum value apply";
		}

		if ($dispatch_details == 'Cash') {
			$username = $this->session->userdata("userName");
			$whr11 = array('username' => $username);
			$res11 = $this->basic_operation_m->getAll('tbl_users', $whr11);
			$branch_id = $res11->row()->branch_id;

			$branch_info = $this->db->get_where('tbl_branch', ['branch_id' => $branch_id])->row();

			$state_info = $this->db->get_where('state', ['id' => $sender_state])->row();

			$first_two_char_branch = substr(trim($branch_info->gst_number), 0, 2);
			// print_r($first_two_char_branch);die;
			if ($first_two_char_branch == $state_info->statecode) {
				$cgst = ($sub_total * 9 / 100);
				$sgst = ($sub_total * 9 / 100);
				$igst = 0;
				$grand_total = $sub_total + $cgst + $sgst + $igst;
			} else {
				$cgst = 0;
				$sgst = 0;
				$igst = ($sub_total * 18 / 100);
				$grand_total = $sub_total + $igst;
			}
		} else {
			$first_two_char = substr($receiver_gstno, 0, 2);

			if ($receiver_gstno == "") {
				$first_two_char = 27;
			}

			$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id' and isdeleted  = '0'");

			if ($tbl_customers_info->gst_charges == 1) {
				if ($first_two_char == 27) {
					$cgst = ($sub_total * 9 / 100);
					$sgst = ($sub_total * 9 / 100);
					$igst = 0;
					$grand_total = $sub_total + $cgst + $sgst + $igst;
				} else {
					$cgst = 0;
					$sgst = 0;
					$igst = ($sub_total * 18 / 100);
					$grand_total = $sub_total + $igst;
				}
			} else {
				$cgst = 0;
				$sgst = 0;
				$igst = 0;
				$grand_total = $sub_total + $igst;
			}
		}



		if ($tat > 0) {
			$tat_date = date('Y-m-d', strtotime($booking_date . " + $tat days"));
		} else {
			$tat_date = date('Y-m-d', strtotime($booking_date . " + 5 days"));
		}


		$data = array(
			//'query' => $query,
			'sender_zone_id' => $sender_zone_id,
			'rate' => $rate,
			'reciver_zone_id' => $reciver_zone_id,
			'min_weight' => $minimum_weight1,
			'chargable_weight' => $chargable_weight,
			'frieht' => round($frieht, 2),
			'fov' => round($fov, 2),
			'appt_charges' => round($appt_charges, 2),
			'docket_charge' => round($docket_charge, 2),
			'amount' => round($amount, 2),
			'cod' => round($cod, 2),
			'cft' => round($cft, 2),
			'to_pay_charges' => round($to_pay_charges, 2),
			'final_fuel_charges' => round($final_fuel_charges, 2),
			'sub_total' => number_format($sub_total, 2, '.', ''),
			'cgst' => number_format($cgst, 2, '.', ''),
			'sgst' => number_format($sgst, 2, '.', ''),
			'igst' => number_format($igst, 2, '.', ''),
			'grand_total' => number_format($grand_total, 2, '.', ''),
			'isMinimumValue' => $isMinimumValue,
			'fovExpiry' => $fovExpiry,
		);
		echo json_encode($data);
		exit;
	}
	public function add_domestic_shipment()
	{
		$data = $this->data;
		$result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
		$id = $result->id + 1;

		if (strlen($id) == 2) {
			$id = 'B4L1000' . $id;
		} elseif (strlen($id) == 3) {
			$id = 'B4L100' . $id;
		} elseif (strlen($id) == 1) {
			$id = 'B4L10000' . $id;
		} elseif (strlen($id) == 4) {
			$id = 'B4L10' . $id;
		} elseif (strlen($id) == 5) {
			$id = 'B4L1' . $id;
		}

		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$data['branch_info'] = $this->basic_operation_m->get_query_row("select * from tbl_branch where branch_id = '$branch_id'");

		$data['transfer_mode'] = $this->basic_operation_m->get_query_result('select * from `transfer_mode`');

		$user_id = $this->session->userdata("userId");
		$data['cities'] = $this->basic_operation_m->get_all_result('city', '');
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');
		$user_type = $this->session->userdata("userType");
		if ($user_type == 1) {
			$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', ['isdeleted' => 0]);
		} else {
			$where = "branch_id='$branch_id' AND customer_type != '1' AND customer_type != '2' ";
			$data['customers'] = $this->db->query("select * from tbl_customers where customer_type != '1' AND customer_type != '2' AND isdeleted ='0'")->result_array();
		}
		$data['payment_method'] = $this->basic_operation_m->get_all_result('payment_method', '');
		$data['region_master'] = $this->basic_operation_m->get_all_result('region_master', '');
		$data['bid'] = $id;
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);

		$this->load->view('admin/domestic_shipment/view_add_domestic_shipment', $data);
	}

	public function add_domestic_shipment2()
	{
		$data = $this->data;
		$result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
		$id = $result->id + 1;

		if (strlen($id) == 2) {
			$id = 'B4L1000' . $id;
		} elseif (strlen($id) == 3) {
			$id = 'B4L100' . $id;
		} elseif (strlen($id) == 1) {
			$id = 'B4L10000' . $id;
		} elseif (strlen($id) == 4) {
			$id = 'B4L10' . $id;
		} elseif (strlen($id) == 5) {
			$id = 'B4L1' . $id;
		}

		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$data['branch_info'] = $this->basic_operation_m->get_query_row("select * from tbl_branch where branch_id = '$branch_id'");

		$data['transfer_mode'] = $this->basic_operation_m->get_query_result('select * from `transfer_mode`');

		$user_id = $this->session->userdata("userId");
		$data['cities'] = $this->basic_operation_m->get_all_result('city', '');
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');
		$user_type = $this->session->userdata("userType");
		if ($user_type == 1) {
			$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', ['isdeleted' => '0']);
		} else {

			//$where ="branch_id='$branch_id' ";
			$where = "branch_id='$branch_id' AND customer_type != '1' AND customer_type != '2' ";
			//$data['customers'] =$this->basic_operation_m->get_all_result('tbl_customers', "branch_id = '$branch_id'");
			$data['customers'] = $this->db->query("select * from tbl_customers where (customer_type != '1' AND customer_type != '2') and isdeleted  = '0'")->result_array();
		}
		$data['payment_method'] = $this->basic_operation_m->get_all_result('payment_method', '');
		$data['region_master'] = $this->basic_operation_m->get_all_result('region_master', '');
		$data['bid'] = $id;
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);

		$this->load->view('admin/domestic_shipment/view_add_domestic_shipment2', $data);
	}


	public function insert_domestic_shipment()
	{
		$all_Data = $this->input->post();

		// echo '<pre>';print_r($all_Data);die;
		if (!empty($all_Data)) {

			$customer_account_id = $this->input->post('customer_account_id');
			$block_status = $this->basic_operation_m->get_query_row("select * from access_control where customer_id = '$customer_account_id' and block_status = 'Booking' and current_status ='0'");
			if (!empty($block_status)) {
				$msg = 'Booking is Blocked for this customer';
				$class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/view-add-domestic-shipment');
			}
			if($this->input->post('dispatch_details') !='FOC'){
			if ($this->input->post('invoice_value') == 0) {
				$msg = 'Invoice value should be greater than 0 and less than 1 Crore. </br> If not available please enter 1 ₹';
				$class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/view-add-domestic-shipment');
			}
			if (10000000 < $this->input->post('invoice_value')) {
				$msg = 'Invoice value should be greater than 0 and less than 1 Crore. </br> If not available please enter 1 ₹';
				$class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/view-add-domestic-shipment');
			}
		  }
			$predate = date('Y-m-d', strtotime("-1 days"));
			$curret = date('Y-m-d');



			if ($predate == date('Y-m-d', strtotime($this->input->post('booking_date'))) or $curret == date('Y-m-d', strtotime($this->input->post('booking_date')))) {

				foreach ($all_Data as $key => $value) {
					if (is_array($value)) {
						# code...
					} else {
						$_POST[$key] = strtoupper($value);
					}

				}
				// echo "<hr>";
				// print_r($this->input->post());exit();
				$username = $this->session->userdata("userName");
				$user_id = $this->session->userdata("userId");
				$user_type = $this->session->userdata("userType");


				$whr = array('username' => $username);
				$res = $this->basic_operation_m->getAll('tbl_users', $whr);
				$branch_id = $res->row()->branch_id;

				$customer_info = $this->basic_operation_m->get_table_row('tbl_customers', array('customer_id' => $this->input->post('customer_account_id'), 'isdeleted' => '0'));
				$company_info = $this->basic_operation_m->get_table_row('tbl_company', array('id' => $customer_info->company_id));
				$branch_info = $this->basic_operation_m->get_table_row('tbl_branch', array('branch_id' => $branch_id));

				$date = date('Y-m-d', strtotime($this->input->post('booking_date')));
				$this->session->unset_userdata("booking_date");
				$this->session->set_userdata("booking_date", $this->input->post('booking_date'));

				$reciever_pincode = $this->input->post('reciever_pincode');
				$reciever_city = $this->input->post('reciever_city');
				$reciever_state = $this->input->post('reciever_state');

				$whr_pincode = array('pin_code' => $reciever_pincode, 'city_id' => $reciever_city, 'state_id' => $reciever_state);
				$check_city = $this->basic_operation_m->get_table_row('pincode', $whr_pincode);
				//echo "++++".$this->db->last_query();
				if (empty($check_city)) {
					$whr_C = array('id' => $reciever_city);
					$city_details = $this->basic_operation_m->get_table_row('city', $whr_C);
					$whr_S = array('id' => $reciever_state);
					$state_details = $this->basic_operation_m->get_table_row('state', $whr_S);

					$pincode_data = array(
						'pin_code' => $reciever_pincode,
						'city' => $city_details->city,
						'city_id' => $reciever_city,
						'state' => $state_details->state,
						'state_id' => $reciever_state
					);

					$whr_p = array('pin_code' => $reciever_pincode);
					$qry = $this->basic_operation_m->update('pincode', $pincode_data, $whr_p);
				}

				if ($all_Data['doc_type'] == 0) {
					$doc_nondoc = 'Document';
				} else {
					$doc_nondoc = 'Non Document';
				}
				$result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
				$id = $result->id + 1;
				$idnew = $result->id + 1;

				$bracnh_prefix = substr($branch_info->branch_code, -2);

				// if (strlen($id) == 2) 
				// {
				//           $id = $company_info->company_code.$bracnh_prefix.'1000'.$id;
				//       }
				// elseif (strlen($id) == 3) 
				// {
				//           $id = $company_info->company_code.$bracnh_prefix.'100'.$id;
				//       }
				// elseif (strlen($id) == 1) 
				// {
				//           $id = $company_info->company_code.$bracnh_prefix.'10000'.$id;
				//       }
				// elseif (strlen($id) == 4) 
				// {
				//           $id = $company_info->company_code.$bracnh_prefix.'10'.$id;
				//       }
				// elseif (strlen($id) == 5) 
				// {
				//           $id = $company_info->company_code.$bracnh_prefix.'1'.$id;
				//       }	


				$id = 500100001 + $idnew;
				$pod_no = trim($this->input->post('awn'));
				if ($pod_no != "") {
					$awb_no = $pod_no;
					$customer_id = $this->input->post('customer_account_id');
					$stock = $this->db->query("SELECT * FROM tbl_customer_assign_cnode WHERE customer_id ='$customer_id' AND (" . $awb_no . " BETWEEN seriess_from AND seriess_to)")->row();
					if(empty($stock)){
						$msg = 'This Customer Not Assign Stock Please Contact to Admin';
						$class = 'alert alert-danger alert-dismissible';
						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
						redirect('admin/view-add-domestic-shipment');
					}
				} else {
					$awb_no = $id;
				}

				$is_appointment = ($this->input->post('is_appointment') == '1') ? 1 : 0;
				//booking details//
				if ($this->input->post('payment_method') == 0) {
					$payment = 0;
				} else {
					$payment = $this->input->post('payment_method');
				}
				$data = array(
					'doc_type' => $this->input->post('doc_type'),
					'doc_nondoc' => $doc_nondoc,
					'courier_company_id' => $this->input->post('courier_company'),
					'company_type' => 'Domestic',
					'mode_dispatch' => $this->input->post('mode_dispatch'),
					'pod_no' => $awb_no,
					'forwording_no' => $this->input->post('forwording_no'),
					'forworder_name' => $this->input->post('forworder_name'),
					'risk_type' => $this->input->post('risk_type'),
					'customer_id' => $this->input->post('customer_account_id'),
					'sender_name' => $this->input->post('sender_name'),
					'sender_address' => $this->input->post('sender_address'),
					'sender_city' => $this->input->post('sender_city'),
					'sender_state' => $this->input->post('sender_state'),
					'sender_pincode' => $this->input->post('sender_pincode'),
					'sender_contactno' => $this->input->post('sender_contactno'),
					'sender_gstno' => $this->input->post('sender_gstno'),
					'reciever_name' => $this->input->post('reciever_name'),
					'contactperson_name' => $this->input->post('contactperson_name'),
					'reciever_address' => $this->input->post('reciever_address'),
					'reciever_contact' => $this->input->post('reciever_contact'),
					'reciever_pincode' => $this->input->post('reciever_pincode'),
					'reciever_city' => $this->input->post('reciever_city'),
					'reciever_state' => $this->input->post('reciever_state'),
					'receiver_zone' => $this->input->post('receiver_zone'),
					'receiver_zone_id' => $this->input->post('receiver_zone_id'),
					'receiver_gstno' => $this->input->post('receiver_gstno'),
					'is_appointment' => $is_appointment,
					'ref_no' => $this->input->post('ref_no'),
					'invoice_no' => $this->input->post('invoice_no'),
					'invoice_value' => $this->input->post('invoice_value'),
					'eway_no' => $this->input->post('eway_no'),
					'eway_expiry_date' => $this->input->post('eway_expiry_date'),
					'special_instruction' => $this->input->post('special_instruction'),
					'type_of_pack' => $this->input->post('type_of_pack'),
					'booking_date' => $date,
					'booking_time' => date('H:i:s', strtotime($this->input->post('booking_date'))),
					'dispatch_details' => $this->input->post('dispatch_details'),
					'delivery_date' => $this->input->post('delivery_date'),
					'payment_method' => $payment,
					'web_or_app' => '1',
					'frieht' => $this->input->post('frieht'),
					'transportation_charges' => $this->input->post('transportation_charges'),
					'insurance_charges' => $this->input->post('insurance_charges'),
					'pickup_charges' => $this->input->post('pickup_charges'),
					'delivery_charges' => $this->input->post('delivery_charges'),
					'courier_charges' => $this->input->post('courier_charges'),
					'awb_charges' => $this->input->post('awb_charges'),
					'other_charges' => $this->input->post('other_charges'),
					'total_amount' => $this->input->post('amount'),
					'fuel_subcharges' => $this->input->post('fuel_subcharges'),
					'fov_charges' => $this->input->post('fov_charges'),
					'e_invoice' => $this->input->post('e_invoice'),
					'type_shipment' => $this->input->post('type_shipment'),
					'sub_total' => $this->input->post('sub_total'),
					'cgst' => $this->input->post('cgst'),
					'sgst' => $this->input->post('sgst'),
					'igst' => $this->input->post('igst'),
					'green_tax' => $this->input->post('green_tax'),
					'appt_charges' => $this->input->post('appt_charges'),
					'grand_total' => $this->input->post('grand_total'),
					'user_id' => $user_id,
					'user_type' => $user_type,
					'branch_id' => $branch_id,
					'booking_type' => 1,
					'adhoc_charges' => json_encode($this->input->post('adhoc_charges')),
					'adhoc_lable' => json_encode($this->input->post('adhoc_lable')),
					'address_change' => $this->input->post('address_change'),
					'dph' => $this->input->post('dph'),
					'warehousing' => $this->input->post('warehousing'),
					'bkdate_reason' => $this->input->post('bkdate_reason')
				);

				// echo "<pre>";print_r($data);die;
				$this->db->trans_start();
				$query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);
				//   echo $this->db->last_query();die;
				$all_Data = $this->input->post();


				$lastid = $this->db->insert_id();
				if (empty($lastid)) {

					$data['error'][] = "Already Exist " . $this->input->post('awn') . '<br>';
				} else {
					$lastid = $this->db->insert_id();

					$this->basic_operation_m->addLog($user_id, 'operation', 'Add Shipment', $data);

					$invoice = array();
					if (($this->input->post('dispatch_details') == 'CASH') || ($this->input->post('dispatch_details') == 'Cash')) {

						$customer_id = $this->input->post('customer_account_id');
						$whr = array('customer_id' => $customer_id, 'isdeleted' => '0');
						$data['customer_details'] = $this->basic_operation_m->get_table_row('tbl_customers', $whr);

						if (!empty($data['customer_details'])) {
							$city_data = $this->basic_operation_m->get_table_row('city', ['id' => $data['customer_details']->city]);
						} else {
							$city_data = '';
						}

						$branch_id = $this->basic_operation_m->getAll('tbl_users', array('user_id' => $this->session->userdata("userId")))->row()->branch_id;
						$branch_info = $this->basic_operation_m->getAll('tbl_branch', array('branch_id' => $branch_id))->row();

						$code = $this->booking_model->get_invoice_max_id('tbl_domestic_invoice', 'invoice_no', substr($branch_info->branch_code, -2), $this->input->post('dispatch_details'));

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

						$edate = date('Y-m-d', strtotime($this->input->post('booking_date')));

						$invoice['inc_num'] = $inc_num;
						$invoice['invoice_date'] = !empty($edate) ? $edate : date("Y-m-d");
						$invoice['invoice_number'] = $code;
						$invoice['company_id'] = 1;
						$invoice['customer_name'] = isset($data['customer_details']) ? $data['customer_details']->customer_name : "";
						$invoice['address'] = $branch_info->address;
						$invoice['city'] = isset($city_data->city) ? $city_data->city : "";
						$invoice['gstno'] = $branch_info->gst_number;
						$invoice['cid'] = isset($data['customer_details']) ? $data['customer_details']->cid : "";
						$invoice['customer_id'] = $this->input->post('customer_account_id');
						$invoice['invoice_from_date'] = date('Y-m-d');
						$invoice['invoice_to_date'] = date('Y-m-d');
						$invoice['booking_ids'] = json_encode($lastid);
						$invoice['payment_type'] = $this->input->post('dispatch_details');
						$invoice['payment_method'] = $this->input->post('payment_method');
						$invoice['branch_id'] = $branch_id;
						$invoice['createId'] = $this->session->userdata('userId');
						$invoice['createDtm'] = date('Y-m-d H:i:s');
						$invoice['invoice_no'] = $code;
						$invoice['final_invoice'] = 1;
						$invoice['fin_year'] = $year;

						$invoice['cgst_amount'] = $this->input->post('cgst');
						$invoice['sgst_amount'] = $this->input->post('sgst');
						$invoice['igst_amount'] = $this->input->post('igst');
						$invoice['total_amount'] = $this->input->post('grand_total');
						$invoice['sub_total'] = $this->input->post('sub_total');
						$invoice['grand_total'] = $this->input->post('grand_total');

						$this->db->insert('tbl_domestic_invoice', $invoice);
						$inv_id = $this->db->insert_id();

						if (!empty($inv_id)) {
							$rec_city = $this->basic_operation_m->get_table_row('city', ['id' => $this->input->post('reciever_city')]);
							$booked_data = $this->db->get_where('tbl_domestic_booking', ['booking_id' => $insert_id])->row();

							$result1 = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row('id');
							$idnew1 = $result1 + 1;
							$id = 50100001 + $idnew;
							$pod_no = trim($this->input->post('awn'));
							if ($pod_no != "") {
								$awb_no1 = $pod_no1;
							} else {
								$awb_no1 = $id;
							}

							$invoice_detail['booking_id'] = $lastid;
							$invoice_detail['invoice_id'] = $inv_id;
							$invoice_detail['booking_date'] = date('Y-m-d');
							$invoice_detail['pod_no'] = !empty($awb_no) ? $awb_no : "";
							$invoice_detail['doc_type'] = $this->input->post('doc_type');
							$invoice_detail['reciever_name'] = $this->input->post('reciever_name');
							$invoice_detail['reciever_city'] = $rec_city->city;
							$invoice_detail['mode_dispatch'] = $this->input->post('mode_dispatch');
							// $invoice_detail['forwording_no']     	= ($this->input->post('forwording_no') !=null)?$this->input->post('forwording_no'):"";
							$invoice_detail['forworder_name'] = $this->input->post('forworder_name');
							$invoice_detail['no_of_pack'] = $this->input->post('no_of_pack');
							$invoice_detail['chargable_weight'] = $this->input->post('chargable_weight');
							$invoice_detail['transportation_charges'] = !empty($this->input->post('transportation_charges')) ? $this->input->post('transportation_charges') : 0;
							$invoice_detail['pickup_charges'] = $this->input->post('pickup_charges');
							$invoice_detail['delivery_charges'] = $this->input->post('delivery_charges');
							$invoice_detail['courier_charges'] = $this->input->post('courier_charges');
							$invoice_detail['awb_charges'] = $this->input->post('awb_charges');
							$invoice_detail['other_charges'] = $this->input->post('other_charges');
							$invoice_detail['frieht'] = $this->input->post('frieht');
							$invoice_detail['amount'] = $this->input->post('amount');
							$invoice_detail['fuel_subcharges'] = $this->input->post('fuel_subcharges');
							$invoice_detail['invoice_value'] = $this->input->post('amount');
							$invoice_detail['sub_total'] = $this->input->post('sub_total');


							// echo "<pre>"; print_r($invoice_detail); die;


							$this->db->insert('tbl_domestic_invoice_detail', $invoice_detail);
							$this->basic_operation_m->update('tbl_domestic_booking', ['invoice_generated_status' => '1'], ['booking_id' => $lastid]);
						}

						// $this->load->library('M_pdf');

						//       $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
						//       $this->m_pdf->pdf->autoMarginPadding = 'pad';
						//       $this->m_pdf->pdf->setAutoBottomMargin = 'stretch';

						// // $this->m_pdf->pdf->SetHTMLFooter('<div style="text-align: right">Page {PAGENO} out of {nbpg}</div>');
						//    $this->m_pdf->pdf->WriteHTML($html);

						//    $this->m_pdf->pdf->defaultheaderfontsize=14;
						//       $this->m_pdf->pdf->defaultheaderfontstyle='B';
						//       $this->m_pdf->pdf->defaultheaderline=1;

						//       $this->mpdf->showImageErrors = true;
						//       $this->mpdf->debug = true;

						// $type           = 'F';
						//       $filename = .'01232404_'.$inc_num.'.pdf';
						// $savefolderpath = 'assets/invoice/domestic/';

						//       $this->m_pdf->pdf->Output($savefolderpath.$filename, $type);
					}

					$weight_data = array(
						'per_box_weight_detail' => $all_Data['per_box_weight_detail'],
						'length_detail' => $all_Data['length_detail'],
						'breath_detail' => $all_Data['breath_detail'],
						'height_detail' => $all_Data['height_detail'],
						'valumetric_weight_detail' => $all_Data['valumetric_weight_detail'],
						'valumetric_actual_detail' => $all_Data['valumetric_actual_detail'],
						'valumetric_chageable_detail' => $all_Data['valumetric_chageable_detail'],
						'per_box_weight' => $all_Data['per_box_weight'],
						'length' => $all_Data['length'],
						'breath' => $all_Data['breath'],
						'height' => $all_Data['height'],
						'valumetric_weight' => $all_Data['valumetric_weight'],
						'valumetric_actual' => $all_Data['valumetric_actual'],
						'valumetric_chageable' => $all_Data['valumetric_chageable'],
					);

					$weight_details = json_encode($weight_data);


					$data2 = array(
						'booking_id' => $lastid,
						'actual_weight' => $this->input->post('actual_weight'),
						'valumetric_weight' => $this->input->post('valumetric_weight'),
						'length' => $this->input->post('length'),
						'breath' => $this->input->post('breath'),
						'height' => $this->input->post('height'),
						'rate' => $this->input->post('rate'),
						'chargable_weight' => $this->input->post('chargable_weight'),
						'per_box_weight' => $this->input->post('per_box_weight'),
						'no_of_pack' => $this->input->post('no_of_pack'),
						'actual_weight_detail' => json_encode($this->input->post('actual_weight')),
						'valumetric_weight_detail' => json_encode($this->input->post('valumetric_weight_detail[]')),
						'chargable_weight_detail' => json_encode($this->input->post('chargable_weight')),
						'length_detail' => json_encode($this->input->post('length_detail[]')),
						'breath_detail' => json_encode($this->input->post('breath_detail[]')),
						'height_detail' => json_encode($this->input->post('height_detail[]')),
						'no_pack_detail' => json_encode($this->input->post('no_of_pack')),
						'per_box_weight_detail' => json_encode($this->input->post('per_box_weight_detail[]')),
						'weight_details' => $weight_details,
					);

					//	echo "<pre>";print_r($data2);
					// 	exit();

					$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);

					$username = $this->session->userdata("userName");
					$whr = array('username' => $username);
					$res = $this->basic_operation_m->getAll('tbl_users', $whr);
					$branch_id = $res->row()->branch_id;

					$whr = array('branch_id' => $branch_id);
					$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
					$branch_name = $res->row()->branch_name;

					$whr = array('booking_id' => $lastid);
					$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
					$podno = $res->row()->pod_no;
					$customerid = $res->row()->customer_id;
					$data3 = array(
						'id' => '',
						'pod_no' => $podno,
						'status' => 'Booked',
						'branch_name' => $branch_name,
						'tracking_date' => $this->input->post('booking_date'),
						'booking_id' => $lastid,
						'remarks' => $this->input->post('special_instruction'),
						'forworder_name' => $data['forworder_name'],
						'forwording_no' => $data['forwording_no'],
						'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
						'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
						'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
					);

					$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
					if ($this->input->post('customer_account_id') != "") {
						$whr = array('customer_id' => $customer_id, 'isdeleted' => '0');
						$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
						$email = $res->row()->email;
					}

					// add stock menagemnet
					$stock = array(
						'delivery_branch' => $this->input->post('final_branch_id'),
						'destination_pincode' => $this->input->post('reciever_pincode'),
						'current_branch' => $branch_id,
						'pod_no' => $podno,
						'booking_id' => $lastid,
						'booked' => '1'
					);
					$this->db->trans_complete();
					if ($this->db->trans_status() === TRUE) {
						$this->db->trans_commit();
						$this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);
						$msg = 'Your Shipment ' . $podno . ' status:Boked  At Location: ' . $branch_name;
						$class = 'alert alert-success alert-dismissible';
						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
					}else{
						$this->db->trans_rollback();
						$msg = 'Something went wrong';
						$class	= 'alert alert-success alert-dismissible';
						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
					}
				}

				redirect('admin/view-add-domestic-shipment');

			} else {
				$msg = 'Booking Date Not Valid';
				$class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/view-add-domestic-shipment');
				// echo 'second Value';
			}
		}
	}

	public function admin_edit_shipment()
	{

		$all_data = $this->input->post();
		//print_r($all_data);exit;
		if ($all_data) {
			// print_r($all_data);die;
			$filter_value = $_POST['filter_value'];



			// $data['domestic_booking'] = $this->generate_pod_model->get_domestic_tracking_data($filterCond,"","");
			$data['domestic_booking'] = $this->db->query("select * from tbl_domestic_booking where pod_no = '$filter_value'")->result_array();
			$id = $data['domestic_booking'][0]['booking_id'];
			$this->admin_edit_domestic_shipment($id);
			// echo $this->db->last_query();die;
		} else {
			$data['domestic_booking'] = array();
			$this->load->view('admin/domestic_shipment/admin_edit_shipment', $data);
		}
		
		
	}
	public function edit_domestic_shipment($id)
	{
		$data['message'] = "";
		$data['transfer_mode'] = $this->basic_operation_m->get_query_result('SELECT * FROM transfer_mode');

		$data['cities'] = $this->basic_operation_m->get_all_result('city', '');
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');
		$user_id = $this->session->userdata("userId");
		$whr = array('booking_id' => $id);
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");
		if ($id != "") {
			$data['booking'] = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr);

			$data['weight'] = $this->basic_operation_m->get_table_row('tbl_domestic_weight_details', $whr);

			$user_type = $this->session->userdata("userType");
			if ($user_type == 1) {
				$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', "");
			} else {
				$username = $this->session->userdata("userName");
				$whr = array('username' => $username);
				$res = $this->basic_operation_m->getAll('tbl_users', $whr);
				$branch_id = $res->row()->branch_id;
				//	$where = "branch_id='$branch_id' ";
				$where = array('branch_id' => $branch_id);
				$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', $where);
			}
        //    echo '<pre>';print_r($data['customers']);die;
		}
		$data['payment_method'] = $this->basic_operation_m->get_all_result('payment_method', '');
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);
		$data['country_list'] = $this->basic_operation_m->get_all_result('zone_master');
		$data['booking_id'] = $id;
		$this->load->view('admin/domestic_shipment/view_edit_domestic_shipment', $data);
	}
	public function admin_edit_domestic_shipment($id)
	{
		$data['message'] = "";
		$data['transfer_mode'] = $this->basic_operation_m->get_query_result('SELECT * FROM transfer_mode');

		$data['cities'] = $this->basic_operation_m->get_all_result('city', '');
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');
		$user_id = $this->session->userdata("userId");
		$whr = array('booking_id' => $id);
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");
		if ($id != "") {
			$data['booking'] = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr);

			$data['weight'] = $this->basic_operation_m->get_table_row('tbl_domestic_weight_details', $whr);

			$user_type = $this->session->userdata("userType");
			if ($user_type == 1) {
				$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', "");
			} else {
				$username = $this->session->userdata("userName");
				$whr = array('username' => $username);
				$res = $this->basic_operation_m->getAll('tbl_users', $whr);
				$branch_id = $res->row()->branch_id;
				$where = array('branch_id' => $branch_id);
				$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', $where);
			}

		}
		$data['payment_method'] = $this->basic_operation_m->get_all_result('payment_method', '');
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);
		$data['country_list'] = $this->basic_operation_m->get_all_result('zone_master');
		$data['booking_id'] = $id;
		$this->load->view('admin/domestic_shipment/admin_edit_domestic_shipment', $data);
	}
	public function admin_update_domestic_shipment($id)
	{
		$all_data = $this->input->post();
		$all_data2 = $this->input->post();

    //    echo '<pre>';print_r($_POST);die;
		if (!empty($all_data)) {
			$whr = array('booking_id' => $id);
			$date = date('Y-m-d', strtotime($this->input->post('booking_date')));
			//booking details//

			if ($this->input->post('doc_type') == 0) {
				$doc_nondoc = 'Document';
			} else {
				$doc_nondoc = 'Non Document';
			}
			$bookin_data = $this->db->get_where('tbl_domestic_booking', ['booking_id' => $id])->row();
			$username = $this->session->userdata("userName");
			$user_id = $this->session->userdata("userId");
			$user_type = $this->session->userdata("userType");
			$whr_u = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr_u);
			$branch_id = $res->row()->branch_id;

			$date = date('Y-m-d', strtotime($this->input->post('booking_date')));

			$reciever_pincode = $this->input->post('reciever_pincode');
			$reciever_city = $this->input->post('reciever_city');
			$reciever_state = $this->input->post('reciever_state');

			$whr_pincode = array('pin_code' => $reciever_pincode, 'city_id' => $reciever_city, 'state_id' => $reciever_state);
			$check_city = $this->basic_operation_m->get_table_row('pincode', $whr_pincode);
			//echo "++++".$this->db->last_query();
			if (empty($check_city) && !empty($reciever_city)) {
				$whr_C = array('id' => $reciever_city);
				$city_details = $this->basic_operation_m->get_table_row('city', $whr_C);
				$whr_S = array('id' => $reciever_state);
				$state_details = $this->basic_operation_m->get_table_row('state', $whr_S);
				// print_r($this->input->post('reciever_city')); die;

				$pincode_data = array(
					'pin_code' => $reciever_pincode,
					'city' => $city_details->city,
					'city_id' => $reciever_city,
					'state' => $state_details->state,
					'state_id' => $reciever_state
				);

				$whr_p = array('pin_code' => $reciever_pincode);
				$qry = $this->basic_operation_m->update('pincode', $pincode_data, $whr_p);
			}
			$is_appointment = ($this->input->post('is_appointment') == '1') ? 1 : 0;
			//booking details//
			$data = array(
				'doc_type' => $this->input->post('doc_type'),
				'doc_nondoc' => $doc_nondoc,
				'courier_company_id' => $this->input->post('courier_company'),
				'company_type' => 'Domestic',
				'mode_dispatch' => $this->input->post('mode_dispatch'),
				'pod_no' => $this->input->post('awn'),
				'forwording_no' => $this->input->post('forwording_no'),
				'forworder_name' => $this->input->post('forworder_name'),
				'risk_type' => $this->input->post('risk_type'),
				// 'customer_id' => $this->input->post('customer_account_id'),
				'sender_name' => $this->input->post('sender_name'),
				'sender_address' => $this->input->post('sender_address'),
				'sender_city' => $this->input->post('sender_city'),
				'sender_state' => $this->input->post('sender_state'),
				'sender_pincode' => $this->input->post('sender_pincode'),
				'sender_contactno' => $this->input->post('sender_contactno'),
				'sender_gstno' => $this->input->post('sender_gstno'),
				'edited_date' => $this->input->post('edited_date'),
				'edited_by' => $this->input->post('edited_by'),
				'edited_branch' => $this->input->post('edited_branch'),

				'reciever_name' => $this->input->post('reciever_name'),
				'contactperson_name' => $this->input->post('contactperson_name'),
				'reciever_address' => $this->input->post('reciever_address'),
				'reciever_contact' => $this->input->post('reciever_contact'),
				'reciever_pincode' => $this->input->post('reciever_pincode'),
				'reciever_city' => $this->input->post('reciever_city'),
				'reciever_state' => $this->input->post('reciever_state'),
				'receiver_zone' => $this->input->post('receiver_zone'),
				'receiver_zone_id' => $this->input->post('receiver_zone_id'),
				'receiver_gstno' => $this->input->post('receiver_gstno'),
				'is_appointment' => $is_appointment,
				'ref_no' => $this->input->post('ref_no'),
				'invoice_no' => $this->input->post('invoice_no'),
				'invoice_value' => $this->input->post('invoice_value'),
				'eway_no' => $this->input->post('eway_no'),
				'eway_expiry_date' => date('Y-m-d H:i:s', strtotime($this->input->post('eway_expiry_date'))),
				'delivery_date' => $this->input->post('delivery_date'),
				'special_instruction' => $this->input->post('special_instruction'),
				'type_of_pack' => $this->input->post('type_of_pack'),
				'booking_date' => $date,
				'booking_time' => date('H:i:s', strtotime($this->input->post('booking_date'))),
				'dispatch_details' => $this->input->post('dispatch_details'),
				'payment_method' => $this->input->post('payment_method'),
				'frieht' => $this->input->post('frieht'),
				'transportation_charges' => $this->input->post('transportation_charges'),
				'insurance_charges' => $this->input->post('insurance_charges'),
				'pickup_charges' => $this->input->post('pickup_charges'),
				'delivery_charges' => $this->input->post('delivery_charges'),
				'courier_charges' => $this->input->post('courier_charges'),
				'awb_charges' => $this->input->post('awb_charges'),
				'other_charges' => $this->input->post('other_charges'),
				'fov_charges' => $this->input->post('fov_charges'),
				'green_tax' => $this->input->post('green_tax'),
				'appt_charges' => $this->input->post('appt_charges'),
				'e_invoice' => $this->input->post('e_invoice'),
				'type_shipment' => $this->input->post('type_shipment'),
				'total_amount' => $this->input->post('amount'),
				'fuel_subcharges' => $this->input->post('fuel_subcharges'),
				'sub_total' => $this->input->post('sub_total'),
				'cgst' => $this->input->post('cgst'),
				'sgst' => $this->input->post('sgst'),
				'igst' => $this->input->post('igst'),
				'grand_total' => $this->input->post('grand_total'),

				//	'user_id' =>$user_id,
				//	'user_type' =>$user_type,				
				//	'branch_id' => $branch_id,
				'booking_type' => 1,
				'adhoc_charges' => json_encode($this->input->post('adhoc_charges')),
				'adhoc_lable' => json_encode($this->input->post('adhoc_lable')),
				'address_change' => $this->input->post('address_change'),
				'dph' => $this->input->post('dph'),
				'warehousing' => $this->input->post('warehousing'),
			);
			// echo '<pre>';print_r($data);die;
			$query = $this->basic_operation_m->update('tbl_domestic_booking', $data, $whr);
			if (!empty($query)) {
				$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Update Shipment', $data, $bookin_data);
			}
			$check_invoice_pod = $this->basic_operation_m->get_table_row('tbl_domestic_invoice_detail', $whr);
			// echo $this->db->last_query();
			// print_r($check_invoice_pod->invoice_id); die;

			if (!empty($check_invoice_pod)) {
				$booking_data = $this->db->get_where('tbl_domestic_booking', $whr)->row();
				if ($booking_data->dispatch_details == 'TOPAY' || $booking_data->dispatch_details == 'CASH') {
					$invoice = $this->basic_operation_m->get_table_row('tbl_domestic_invoice', ['id' => $check_invoice_pod->invoice_id]);
					$invArray = array(
						'cgst_amount' => $this->input->post('cgst'),
						'sgst_amount' => $this->input->post('sgst'),
						'igst_amount' => $this->input->post('igst'),
						'total_amount' => $this->input->post('grand_total'),
						'sub_total' => $this->input->post('sub_total'),
						'grand_total' => $this->input->post('grand_total')
					);
					// print_r($invArray); die;

					$this->db->update('tbl_domestic_invoice', $invArray, ['id' => $check_invoice_pod->invoice_id]);
				}
				$data_invoice_details = array(
					'no_of_pack' => $this->input->post('no_of_pack'),
					'chargable_weight' => $this->input->post('chargable_weight'),
					'frieht' => $this->input->post('frieht'),
					'transportation_charges' => $this->input->post('transportation_charges'),
					'pickup_charges' => $this->input->post('pickup_charges'),
					'delivery_charges' => $this->input->post('delivery_charges'),
					'courier_charges' => $this->input->post('courier_charges'),
					'awb_charges' => $this->input->post('awb_charges'),
					'other_charges' => $this->input->post('other_charges'),
					'amount' => $this->input->post('amount'),
					'fuel_subcharges' => $this->input->post('fuel_subcharges'),
					'sub_total' => $this->input->post('sub_total'),
				);
				$query = $this->basic_operation_m->update('tbl_domestic_invoice_detail', $data_invoice_details, $whr);
			}


			$weight_data = array(
				'per_box_weight_detail' => $all_data2['per_box_weight_detail'],
				'length_detail' => $all_data2['length_detail'],
				'breath_detail' => $all_data2['breath_detail'],
				'height_detail' => $all_data2['height_detail'],
				'valumetric_weight_detail' => $all_data2['valumetric_weight_detail'],
				'valumetric_actual_detail' => $all_data2['valumetric_actual_detail'],
				'valumetric_chageable_detail' => $all_data2['valumetric_chageable_detail'],
				'per_box_weight' => $all_data2['per_box_weight'],
				'length' => $all_data2['length'],
				'breath' => $all_data2['breath'],
				'height' => $all_data2['height'],
				'valumetric_weight' => $all_data2['valumetric_weight'],
				'valumetric_actual' => $all_data2['valumetric_actual'],
				'valumetric_chageable' => $all_data2['valumetric_chageable'],
			);

			$weight_details = json_encode($weight_data);

			$data2 = array(
				'actual_weight' => $this->input->post('actual_weight'),
				'valumetric_weight' => $this->input->post('valumetric_weight'),
				'length' => $this->input->post('length'),
				'breath' => $this->input->post('breath'),
				'height' => $this->input->post('height'),
				'chargable_weight' => $this->input->post('chargable_weight'),
				'per_box_weight' => $this->input->post('per_box_weight'),
				'no_of_pack' => $this->input->post('no_of_pack'),
				'actual_weight_detail' => json_encode($this->input->post('actual_weight')),
				'valumetric_weight_detail' => json_encode($this->input->post('valumetric_weight_detail[]')),
				'chargable_weight_detail' => json_encode($this->input->post('chargable_weight')),
				'length_detail' => json_encode($this->input->post('length_detail[]')),
				'breath_detail' => json_encode($this->input->post('breath_detail[]')),
				'height_detail' => json_encode($this->input->post('height_detail[]')),
				'no_pack_detail' => json_encode($this->input->post('no_of_pack')),
				'per_box_weight_detail' => json_encode($this->input->post('per_box_weight_detail[]')),
				'weight_details' => $weight_details,
			);




			$query2 = $this->basic_operation_m->update('tbl_domestic_weight_details', $data2, $whr);



			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;

			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$whr = array('booking_id' => $id);
			$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
			$podno = $res->row()->pod_no;
			$customerid = $res->row()->customer_id;
			$data3 = array(
				'tracking_date' => date('Y-m-d H:i:s', strtotime($this->input->post('booking_date')))
			);

			// $result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
			$where2 = array('status' => 'Booked', 'pod_no' => $this->input->post('awn'));
			$query2 = $this->basic_operation_m->update('tbl_domestic_tracking', $data3, $where2);

			if ($this->db->affected_rows() > 0) {
				$data['message'] = "Data added successfull";
			} else {
				$data['message'] = "Failed to Submit";
			}

			redirect('admin/admin-edit-view-list');
		}
	}
	public function update_domestic_shipment($id)
	{
		$all_data = $this->input->post();
		$all_data2 = $this->input->post();


		if (!empty($all_data)) {
			$whr = array('booking_id' => $id);
			$date = date('Y-m-d', strtotime($this->input->post('booking_date')));
			//booking details//

			if ($this->input->post('doc_type') == 0) {
				$doc_nondoc = 'Document';
			} else {
				$doc_nondoc = 'Non Document';
			}

			$username = $this->session->userdata("userName");
			$user_id = $this->session->userdata("userId");
			$user_type = $this->session->userdata("userType");
			$whr_u = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr_u);
			$branch_id = $res->row()->branch_id;

			$date = date('Y-m-d', strtotime($this->input->post('booking_date')));

			$reciever_pincode = $this->input->post('reciever_pincode');
			$reciever_city = $this->input->post('reciever_city');
			$reciever_state = $this->input->post('reciever_state');

			$whr_pincode = array('pin_code' => $reciever_pincode, 'city_id' => $reciever_city, 'state_id' => $reciever_state);
			$check_city = $this->basic_operation_m->get_table_row('pincode', $whr_pincode);
			//echo "++++".$this->db->last_query();
			$bookin_data = $this->db->get_where('tbl_domestic_booking', ['booking_id' => $id])->row();

			if (empty($check_city) && !empty($reciever_city)) {
				$whr_C = array('id' => $reciever_city);
				$city_details = $this->basic_operation_m->get_table_row('city', $whr_C);
				$whr_S = array('id' => $reciever_state);
				$state_details = $this->basic_operation_m->get_table_row('state', $whr_S);
				// print_r($this->input->post('reciever_city')); die;

				$pincode_data = array(
					'pin_code' => $reciever_pincode,
					'city' => $city_details->city,
					'city_id' => $reciever_city,
					'state' => $state_details->state,
					'state_id' => $reciever_state
				);

				$whr_p = array('pin_code' => $reciever_pincode);
				$qry = $this->basic_operation_m->update('pincode', $pincode_data, $whr_p);
			}
			$is_appointment = ($this->input->post('is_appointment') == '1') ? 1 : 0;
			//booking details//
			$data = array(
				'doc_type' => $this->input->post('doc_type'),
				'doc_nondoc' => $doc_nondoc,
				'courier_company_id' => $this->input->post('courier_company'),
				'company_type' => 'Domestic',
				//'mode_dispatch' => $this->input->post('mode_dispatch'),
				'pod_no' => $this->input->post('awn'),
				'forwording_no' => $this->input->post('forwording_no'),
				'forworder_name' => $this->input->post('forworder_name'),
				'risk_type' => $this->input->post('risk_type'),
				// 'customer_id' => $this->input->post('customer_account_id'),
				'sender_name' => $this->input->post('sender_name'),
				'sender_address' => $this->input->post('sender_address'),
				'sender_city' => $this->input->post('sender_city'),
				'sender_state' => $this->input->post('sender_state'),
				'sender_pincode' => $this->input->post('sender_pincode'),
				'sender_contactno' => $this->input->post('sender_contactno'),
				'sender_gstno' => $this->input->post('sender_gstno'),
				'edited_date' => $this->input->post('edited_date'),
				'edited_by' => $this->input->post('edited_by'),
				'edited_branch' => $this->input->post('edited_branch'),

				'reciever_name' => $this->input->post('reciever_name'),
				'contactperson_name' => $this->input->post('contactperson_name'),
				'reciever_address' => $this->input->post('reciever_address'),
				'reciever_contact' => $this->input->post('reciever_contact'),
				//'reciever_pincode' => $this->input->post('reciever_pincode'),
				//'reciever_city' => $this->input->post('reciever_city'),
				//'reciever_state' => $this->input->post('reciever_state'),
				//'receiver_zone' => $this->input->post('receiver_zone'),
				//'receiver_zone_id' => $this->input->post('receiver_zone_id'),
				'receiver_gstno' => $this->input->post('receiver_gstno'),
				'is_appointment' => $is_appointment,
				'ref_no' => $this->input->post('ref_no'),
				'invoice_no' => $this->input->post('invoice_no'),
				'invoice_value' => $this->input->post('invoice_value'),
				'eway_no' => $this->input->post('eway_no'),
				'eway_expiry_date' => date('Y-m-d H:i:s', strtotime($this->input->post('eway_expiry_date'))),
				'delivery_date' => $this->input->post('delivery_date'),
				'special_instruction' => $this->input->post('special_instruction'),
				//'type_of_pack' => $this->input->post('type_of_pack'),
				'booking_date' => $date,
				'booking_time' => date('H:i:s', strtotime($this->input->post('booking_date'))),
				//'dispatch_details' => $this->input->post('dispatch_details'),
				'payment_method' => $this->input->post('payment_method'),
				'frieht' => $this->input->post('frieht'),
				'transportation_charges' => $this->input->post('transportation_charges'),
				'insurance_charges' => $this->input->post('insurance_charges'),
				'pickup_charges' => $this->input->post('pickup_charges'),
				'delivery_charges' => $this->input->post('delivery_charges'),
				'courier_charges' => $this->input->post('courier_charges'),
				'awb_charges' => $this->input->post('awb_charges'),
				'other_charges' => $this->input->post('other_charges'),
				'fov_charges' => $this->input->post('fov_charges'),
				'green_tax' => $this->input->post('green_tax'),
				'appt_charges' => $this->input->post('appt_charges'),
				'e_invoice' => $this->input->post('e_invoice'),
				'type_shipment' => $this->input->post('type_shipment'),
				'total_amount' => $this->input->post('amount'),
				'fuel_subcharges' => $this->input->post('fuel_subcharges'),
				'sub_total' => $this->input->post('sub_total'),
				'cgst' => $this->input->post('cgst'),
				'sgst' => $this->input->post('sgst'),
				'igst' => $this->input->post('igst'),
				'grand_total' => $this->input->post('grand_total'),

				//	'user_id' =>$user_id,
				//	'user_type' =>$user_type,				
				//	'branch_id' => $branch_id,
				'booking_type' => 1,
				'adhoc_charges' => json_encode($this->input->post('adhoc_charges')),
				'adhoc_lable' => json_encode($this->input->post('adhoc_lable')),
				'address_change' => $this->input->post('address_change'),
				'dph' => $this->input->post('dph'),
				'warehousing' => $this->input->post('warehousing'),
			);
			// echo '<pre>';print_r($data);die;
			$query = $this->basic_operation_m->update('tbl_domestic_booking', $data, $whr);

			$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Update Shipment', $data, $bookin_data);

			$check_invoice_pod = $this->basic_operation_m->get_table_row('tbl_domestic_invoice_detail', $whr);
			// echo $this->db->last_query();
			// print_r($check_invoice_pod->invoice_id); die;

			if (!empty($check_invoice_pod)) {
				$booking_data = $this->db->get_where('tbl_domestic_booking', $whr)->row();
				if ($booking_data->dispatch_details == 'TOPAY' || $booking_data->dispatch_details == 'CASH') {
					$invoice = $this->basic_operation_m->get_table_row('tbl_domestic_invoice', ['id' => $check_invoice_pod->invoice_id]);
					$invArray = array(
						'cgst_amount' => $this->input->post('cgst'),
						'sgst_amount' => $this->input->post('sgst'),
						'igst_amount' => $this->input->post('igst'),
						'total_amount' => $this->input->post('grand_total'),
						'sub_total' => $this->input->post('sub_total'),
						'grand_total' => $this->input->post('grand_total')
					);
					// print_r($invArray); die;

					$this->db->update('tbl_domestic_invoice', $invArray, ['id' => $check_invoice_pod->invoice_id]);
				}
				$data_invoice_details = array(
					'no_of_pack' => $this->input->post('no_of_pack'),
					'chargable_weight' => $this->input->post('chargable_weight'),
					'frieht' => $this->input->post('frieht'),
					'transportation_charges' => $this->input->post('transportation_charges'),
					'pickup_charges' => $this->input->post('pickup_charges'),
					'delivery_charges' => $this->input->post('delivery_charges'),
					'courier_charges' => $this->input->post('courier_charges'),
					'awb_charges' => $this->input->post('awb_charges'),
					'other_charges' => $this->input->post('other_charges'),
					'amount' => $this->input->post('amount'),
					'fuel_subcharges' => $this->input->post('fuel_subcharges'),
					'sub_total' => $this->input->post('sub_total'),
				);
				$query = $this->basic_operation_m->update('tbl_domestic_invoice_detail', $data_invoice_details, $whr);
			}


			$weight_data = array(
				'per_box_weight_detail' => $all_data2['per_box_weight_detail'],
				'length_detail' => $all_data2['length_detail'],
				'breath_detail' => $all_data2['breath_detail'],
				'height_detail' => $all_data2['height_detail'],
				'valumetric_weight_detail' => $all_data2['valumetric_weight_detail'],
				'valumetric_actual_detail' => $all_data2['valumetric_actual_detail'],
				'valumetric_chageable_detail' => $all_data2['valumetric_chageable_detail'],
				'per_box_weight' => $all_data2['per_box_weight'],
				'length' => $all_data2['length'],
				'breath' => $all_data2['breath'],
				'height' => $all_data2['height'],
				'valumetric_weight' => $all_data2['valumetric_weight'],
				'valumetric_actual' => $all_data2['valumetric_actual'],
				'valumetric_chageable' => $all_data2['valumetric_chageable'],
			);

			$weight_details = json_encode($weight_data);

			$data2 = array(
				'actual_weight' => $this->input->post('actual_weight'),
				'valumetric_weight' => $this->input->post('valumetric_weight'),
				'length' => $this->input->post('length'),
				'breath' => $this->input->post('breath'),
				'height' => $this->input->post('height'),
				'rate' => $this->input->post('rate'),
				'chargable_weight' => $this->input->post('chargable_weight'),
				'per_box_weight' => $this->input->post('per_box_weight'),
				'no_of_pack' => $this->input->post('no_of_pack'),
				'actual_weight_detail' => json_encode($this->input->post('actual_weight')),
				'valumetric_weight_detail' => json_encode($this->input->post('valumetric_weight_detail[]')),
				'chargable_weight_detail' => json_encode($this->input->post('chargable_weight')),
				'length_detail' => json_encode($this->input->post('length_detail[]')),
				'breath_detail' => json_encode($this->input->post('breath_detail[]')),
				'height_detail' => json_encode($this->input->post('height_detail[]')),
				'no_pack_detail' => json_encode($this->input->post('no_of_pack')),
				'per_box_weight_detail' => json_encode($this->input->post('per_box_weight_detail[]')),
				'weight_details' => $weight_details,
			);




			$query2 = $this->basic_operation_m->update('tbl_domestic_weight_details', $data2, $whr);



			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;

			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$whr = array('booking_id' => $id);
			$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
			$podno = $res->row()->pod_no;
			$customerid = $res->row()->customer_id;
			// $data3 = array('id' => '',
			// 	'pod_no' => $podno,
			// 	'status' => 'booked',
			// 	'branch_name' => $branch_name,
			// 	'tracking_date' => $date,
			// 	'booking_id' => $id,
			// 	'forworder_name' => $data['forworder_name'],
			// 	'forwording_no' => $data['forwording_no'],
			// 	'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
			// 	'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
			// 	'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
			// );

			// $result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);

			//$query2 = $this->basic_operation_m->update('tbl_weight_details', $data2, $whr);

			if ($this->db->affected_rows() > 0) {
				$data['message'] = "Data added successfull";
			} else {
				$data['message'] = "Failed to Submit";
			}

			redirect('admin/view-domestic-shipment');
		}
	}

	public function getsenderdetails()
	{
		$data = [];
		$customer_name = $this->input->post('customer_name');
		$whr1 = array('customer_id' => $customer_name);
		//$res1 = $this->basic_operation_m->selectRecord('tbl_customers', $whr1);

		$res1 = $this->basic_operation_m->get_customer_details($whr1);
		//$result1 = $res1->row();
		$data['user'] = $res1;
		echo json_encode($data);
		exit;
	}
	public function check_duplicate_forwording_no()
	{
		$data = [];
		$forwording_no = $this->input->post('forwording_no');
		$whr = array('forwording_no' => $forwording_no);
		$result = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr);

		$forwording_no = $result->forwording_no;
		if ($forwording_no != "") {
			$data['msg'] = "Forwording number is duplicate ";
		} else {
			$data['msg'] = "";
		}

		echo json_encode($data);
		exit;
	}


	public function getCityList()
	{
		$data = array();

		$pincode = $this->input->post('pincode');
		$booking_date = $this->input->post('booking_date');
		$mode_dispatch = $this->input->post('mode_dispatch');
		$sender_city = $this->input->post('sender_city');
		$sender_state = $this->input->post('sender_state');

		$whr1 = array('pin_code' => $pincode,'isdeleted'=>0);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);


		$pin_code = @$res1->row()->pin_code;
		$city_id = @$res1->row()->city_id;
		$state_id = @$res1->row()->state_id;
		$isODA = @$res1->row()->isODA;
		$EDD = tat_day_count($sender_state, $sender_city, $state_id, $city_id, $mode_dispatch);
		// echo $this->db->last_query();die;
		// echo $EDD; die;

		if (!empty($EDD)) {
			// print_r($EDD[0]);
			$tat_cout = $EDD + 1;
			$edd_date = date('Y-m-d', strtotime($booking_date . ' + ' . $tat_cout . ' days')); //print_r($edd_date);
			$start = new DateTime($booking_date);
			$end = new DateTime($edd_date);
			$days = $start->diff($end, true)->days;
			$sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
			if ($booking_date != $end) {
				if ($sundays > 0) {
					$EDD = $EDD + 1;
				} else {
					$EDD = " ";
				}
			} else {
				$EDD = " ";
			}
		}

		if ($state_id) {
			$whr2 = array('id' => $state_id);
			$res2 = $this->basic_operation_m->get_table_row('state', $whr2);
			$statecode = $res2->statecode;

		}

		if (!$pin_code) {
			$data['status'] = "failed";
			$data['message'] = "The pin code <b> ".$pincode." </b> is NSS (No Service Station).<br>To add this pin code in system, please contact your Admin/Manager.";
			echo json_encode($data);
			exit();
		}
		$data['status'] = "success";
		$whr2 = array('id' => $city_id);
		$res2 = $this->basic_operation_m->get_table_row('city', $whr2);
		$pincode_city = $res2->id;

		$city_list = $this->basic_operation_m->get_all_result('city', '');

		$resAct = $this->db->query("select service_pincode.*,courier_company.c_id,courier_company.c_company_name from service_pincode JOIN courier_company on courier_company.c_id=service_pincode.forweder_id where pincode='" . $pincode . "' order by serv_pin_id DESC ");


		$data['forwarder'] = array();
		if ($resAct->num_rows() > 0) {
			$data['forwarder'] = $resAct->result_array();
		}

		$option = "";
		$forwarder = "";
		foreach ($city_list as $value) {
			if ($value["id"] == $pincode_city) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$option .= '<option value="' . $value["id"] . '" ' . $selected . ' >' . $value["city"] . '</option>';
		}

		if (!empty($data['forwarder'])) {
			foreach ($data['forwarder'] as $key => $value) {
				$servicable = '';
				// if ($value['servicable']==0) {
				// 	//$servicable = 'no service';
				// }else{
				// 	$servicable = 'service';
				// }

				if ($value['oda'] == 1) {

					$servicable = ' - ODA Available';

				} else {
					// $servicable = ' ODA Available';
				}
				$forwarder .= "<option value='" . $value["c_company_name"] . "'>" . $value["c_company_name"] . "" . $servicable . "</option>";
			}
		}
		$pincode = $this->input->post('pincode');
		$final_branch = $this->db->query("select branch_id from tbl_branch_service where pincode = '$pincode'")->row();
		$branch_id = $final_branch->branch_id;
		$final_branch_name = $this->db->query("select branch_name from tbl_branch where branch_id = '$branch_id'")->row();
		$forwarder .= "<option value='SELF' selected>SELF</option>";
		unset($data['forwarder']);
		$data['message'] = "";
		$data['option'] = $option;
		if(!empty($state_id)&& !empty($city_id)){
		$data['isODA'] = 'Service Type : '.service_type[$isODA];
		}
		$data['final_branch_id'] = $final_branch->branch_id;
		$data['final_branch_name'] = $final_branch_name->branch_name;
		$data['forwarder2'] = $forwarder;
		$data['city_id'] = $city_id;
		$data['state_id'] = $state_id;
		$data['statecode'] = $statecode;
		$data['edd_date'] = isset($edd_date) ? date('d-m-Y', strtotime($edd_date)) : " ";
		// $data['edd_date'] = isset($edd_date) ? date('d-m-Y', strtotime($edd_date)) : date('d-m-Y');
		$data['edd_days'] = !empty($EDD) ? $EDD : '';

		echo json_encode($data);
	}
	public function getCustomer()
	{
		$data = array();
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$city_list = $this->db->query("select * from tbl_customers where branch_id = '$branch_id' and ( customer_type ='0' OR customer_type ='general')")->result_array();
		//  echo $this->db->last_query();die;

		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
		$data = '<option > Select Customer </option>';
		foreach ($city_list as $key => $value) {
			$data .= '<option value="' . $value["customer_id"] . '">' . $value["customer_name"] . '--' . $value["cid"] . '</option>';
		}
		// print_r($data);die;

		echo json_encode($data);
	}
	

	public function getCustomerlist()
	{
		$data = array();
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_type = $this->session->userdata("userType");
		$bill_type = $this->input->post('dispatch_details');
		if($bill_type=='FOC')
		{
			if ($user_type == 1) {
				// $data['customers'] =$this->basic_operation_m->get_all_result('tbl_customers', "");
				$city_list = $this->db->query("select * from tbl_customers where customer_type != '1' AND customer_type != '2' AND customer_id ='118' and isdeleted ='0'")->result_array();
			} else {
				$city_list = $this->db->query("select * from tbl_customers where customer_type != '1' AND customer_type != '2' AND customer_id ='118' and isdeleted ='0'")->result_array();
			}
		}
		else{
		if ($user_type == 1) {
			// $data['customers'] =$this->basic_operation_m->get_all_result('tbl_customers', "");
			$city_list = $this->db->query("select * from tbl_customers where isdeleted ='0'")->result_array();
		} else {
			$city_list = $this->db->query("select * from tbl_customers where customer_type != '1' AND customer_type != '2' and isdeleted ='0'")->result_array();
		}
	    }
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
		$data = '<option > Select Customer </option>';
		foreach ($city_list as $key => $value) {
			$data .= '<option value="' . $value["customer_id"] . '">' . $value["customer_name"] . '--' . $value["cid"] . '</option>';
		}

		echo json_encode($data);
	}

	public function getState()
	{
		$pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode,'isdeleted'=>0);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

		$state_id = $res1->row()->state_id;
		if (!empty($state_id)) {
			$whr3 = array('id' => $state_id);
			$res3 = $this->basic_operation_m->get_table_row('state', $whr3);
			$pincode_state = $res3->id;


			$state_list = $this->basic_operation_m->get_all_result('state', '');
			$option = "";
			foreach ($state_list as $value) {
				if ($value["id"] == $pincode_state) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$option .= '<option value="' . $value["id"] . '" ' . $selected . ' >' . $value["state"] . '</option>';
			}
		} else {
			$option = array();
		}


		echo json_encode($option);

	}
	// public function delete_domestic_shipment()
	// {
	// 	$id = $this->input->post('getid');
	// 	if ($id != "") {
	// 		$whr = array('booking_id' => $id);
	// 		$res = $this->basic_operation_m->delete('tbl_domestic_booking', $whr);
	// 		$res1 = $this->basic_operation_m->delete('tbl_domestic_weight_details', $whr);
	// 		$res2 = $this->basic_operation_m->delete('tbl_domestic_tracking', $whr);

	// 		$output['status'] = 'success';
	// 		$output['message'] = 'Shipment deleted successfully';
	// 	} else {
	// 		$output['status'] = 'error';
	// 		$output['message'] = 'Something went wrong in deleting the Shipment';
	// 	}

	// 	echo json_encode($output);
	// }

	public function delete_domestic_shipment()
	{
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(E_ALL);
		$id = $this->input->post('getid');
		if ($id != "") {
			$whr = array('booking_id' => $id);
			$update = $this->basic_operation_m->selectRecord('tbl_domestic_booking', $whr)->row();

			$array_data = array(
				'doc_type' => $update->doc_type,
				// 'doc_nondoc' => $doc_nondoc,
				'courier_company_id' => 35,
				'company_type' => 'Domestic',
				'mode_dispatch' => $update->mode_dispatch,
				'pod_no' => $update->pod_no,
				'forwording_no' => $update->forwording_no,
				'forworder_name' => $update->forworder_name,
				'risk_type' => $update->risk_type,
				'customer_id' => $update->customer_id,
				'sender_name' => $update->sender_name,
				'sender_address' => $update->sender_address,
				'sender_city' => $update->sender_city,
				'sender_state' => $update->sender_state,
				'sender_pincode' => $update->sender_pincode,
				'sender_contactno' => $update->sender_contactno,
				'sender_gstno' => $update->sender_gstno,
				'edited_date' => $update->edited_date,
				'edited_by' => $update->edited_by,
				'edited_branch' => $update->edited_branch,

				'reciever_name' => $update->reciever_name,
				'contactperson_name' => $update->contactperson_name,
				'reciever_address' => $update->reciever_address,
				'reciever_contact' => $update->reciever_contact,
				'receiver_gstno' => $update->receiver_gstno,
				'is_appointment' => $is_appointment,
				'ref_no' => $update->ref_no,
				'invoice_no' => $update->invoice_no,
				'invoice_value' => $update->invoice_value,
				'eway_no' => $update->eway_no,
				'eway_expiry_date' => date('Y-m-d H:i:s', strtotime($update->eway_expiry_date)),
				'delivery_date' => $update->delivery_date,
				'special_instruction' => $update->special_instruction,
				'booking_date' => $date,
				'booking_time' => date('H:i:s', strtotime($update->booking_date)),
				'payment_method' => $update->payment_method,
				'frieht' => $update->frieht,
				'transportation_charges' => $update->transportation_charges,
				'insurance_charges' => $update->insurance_charges,
				'pickup_charges' => $update->pickup_charges,
				'delivery_charges' => $update->delivery_charges,
				'courier_charges' => $update->courier_charges,
				'awb_charges' => $update->awb_charges,
				'other_charges' => $update->other_charges,
				'fov_charges' => $update->fov_charges,
				'green_tax' => $update->green_tax,
				'appt_charges' => $update->appt_charges,
				'e_invoice' => $update->e_invoice,
				'type_shipment' => $update->type_shipment,
				'total_amount' => $update->amount,
				'fuel_subcharges' => $update->fuel_subcharges,
				'sub_total' => $update->sub_total,
				'cgst' => $update->cgst,
				'sgst' => $update->sgst,
				'igst' => $update->igst,
				'grand_total' => $update->grand_total,
				'booking_type' => 1,
				'adhoc_charges' => json_encode($update->adhoc_charges),
				'adhoc_lable' => json_encode($update->adhoc_lable),
				'address_change' => $update->address_change,
				'dph' => $update->dph,
				'warehousing' => $update->warehousing,
			);
			$this->db->trans_begin();
			$this->basic_operation_m->addLog($this->session->userdata("userId"), 'Delete LR', 'Shipment deleted', $array_data);
			$res2 = $this->basic_operation_m->delete('tbl_domestic_tracking', ['pod_no' => $update->pod_no]);
			$res = $this->basic_operation_m->delete('tbl_domestic_booking', ['pod_no' => $update->pod_no]);
			$res1 = $this->basic_operation_m->delete('tbl_domestic_weight_details', $whr);
			$res3 = $this->basic_operation_m->delete('tbl_domestic_stock_history', ['pod_no' => $update->pod_no]);

			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();
				$output['status'] = 'success';
				$output['message'] = 'Shipment deleted successfully';
			} else {
				$this->db->trans_rollback();
				$output['status'] = 'error';
				$output['message'] = 'Something went wrong in deleting the Shipment Roll back';
			}



		} else {
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Shipment';
		}

		echo json_encode($output);
	}



	public function print_label($id)
	{
		// Load library
		$this->load->library('zend');
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');
		$whr = array('booking_id' => $id);
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");
		if ($id != "") {
			$data['booking'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $whr);
			$where = array('id' => 1);
			$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company', $where);
			// echo '<pre>'; print_r($data['booking']); die;
			$this->load->view('admin/domestic_shipment/print_shipment', $data);
		}
	}

	public function all_printpod($booking_id = '')
	{
		// Load library
		$this->load->library('zend');

		$data['multi'] = '1';
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');
		$post_Data = $this->input->post();
		if (!empty($post_Data)) {
			$data = array();
			$where = "customer_id = '" . $post_Data['user_id'] . "' AND (tbl_domestic_booking.booking_date >= '" . $post_Data['from_date'] . "' AND tbl_domestic_booking.booking_date <= '" . $post_Data['to_date'] . "')";

			$user_id = $this->session->userdata("userId");
			$user_type = $this->session->userdata("userType");

			$resAct = $this->db->query("select * from tbl_domestic_booking where $whr GROUP BY booking_id order by booking_date DESC ");

			if ($resAct->num_rows() > 0) {
				$data['booking'] = $resAct->result_array();
			}

			$where = array('id' => 1);
			$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company', $where);

			$this->load->view('admin/domestic_shipment/print_shipment', $data);
		} elseif ($booking_id) {
			$data['selected_lists'] = explode('-', $booking_id);
			$booking_ids = array_unique(array_filter($data['selected_lists']));

			$booking_idsa = implode("','", $booking_ids);
			$whr = "tbl_domestic_booking.booking_id IN ('$booking_idsa')";

			$user_id = $this->session->userdata("userId");
			$user_type = $this->session->userdata("userType");

			$resAct = $this->db->query("select * from tbl_domestic_booking where $whr GROUP BY booking_id order by booking_date DESC ");

			if ($resAct->num_rows() > 0) {
				$data['booking'] = $resAct->result_array();
			}
			$where = array('id' => 1);
			$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company', $where);

			$this->load->view('admin/domestic_shipment/print_shipment', $data);
		}
	}
	public function getZone()
	{
		$reciever_state = $this->input->post('reciever_state');
		$reciever_city = $this->input->post('reciever_city');

		$whr1 = array('state' => $reciever_state, 'city' => $reciever_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$regionid = @$res1->row()->regionid;

		$whr3 = array('region_id' => $regionid);
		$res3 = $this->basic_operation_m->selectRecord('region_master', $whr3);
		$result3 = $res3->row();

		echo json_encode($result3);

	}
	public function view_upload_domestic_shipment()
	{
		$this->load->view('admin/domestic_shipment/view_upload_domestic_shipment');
	}
	public function upload_domestic_shipment()
	{
		$data = [];
		$username = $this->session->userdata("userName");
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");

		$extension = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
		if ($extension != "csv") {
			$msg = 'Please uploade csv file.';
			$class = 'alert alert-danger alert-dismissible';
			$this->session->set_flashdata('notify', $msg);
			$this->session->set_flashdata('class', $class);


		} else {
			$file = fopen($_FILES['uploadFile']['tmp_name'], "r");
			$heading_array = array();
			$cnt = 0;

			while (!feof($file)) {
				$data = fgetcsv($file);
				if (!empty($data)) {
					if ($cnt > 0) {
						$username = $this->session->userdata("userName");
						$user_id = $this->session->userdata("userId");
						$user_type = $this->session->userdata("userType");

						$whr = array('username' => $username);
						$res = $this->basic_operation_m->getAll('tbl_users', $whr);
						$branch_id = $res->row()->branch_id;

						$customer_info = $this->basic_operation_m->get_table_row('tbl_customers', array('cid' => $data[0]));
						$company_info = $this->basic_operation_m->get_table_row('tbl_company', array('id' => $customer_info->company_id));
						$branch_info = $this->basic_operation_m->get_table_row('tbl_branch', array('branch_id' => $branch_id));
						$bracnh_prefix = substr($branch_info->branch_code, -2);
						$booking_date = date('Y-m-d', strtotime($data[1]));
						if ($data[5] == 0) {
							$doc_nondoc = 'Document';
						} else {
							$doc_nondoc = 'Non Document';
						}
						$result = $this->basic_operation_m->get_query_row('select max(booking_id) AS id from tbl_domestic_booking');
						$id = $result->id + 1;
						$idnew = $result->id + 1;

						// if (strlen($id) == 2) 
						// {
						// 	$id = $company_info->company_code.$bracnh_prefix.'1000'.$id;
						// }
						// elseif (strlen($id) == 3) 
						// {
						// 	$id = $company_info->company_code.$bracnh_prefix.'100'.$id;
						// }
						// elseif (strlen($id) == 1) 
						// {
						// 	$id = $company_info->company_code.$bracnh_prefix.'10000'.$id;
						// }
						// elseif (strlen($id) == 4) 
						// {
						// 	$id = $company_info->company_code.$bracnh_prefix.'10'.$id;
						// }
						// elseif (strlen($id) == 5) 
						// {
						// 	$id = $company_info->company_code.$bracnh_prefix.'1'.$id;
						// }

						$id = 50100001 + $idnew;

						$pod_no = trim($this->input->post('awn'));
						if ($pod_no != "") {
							$awb_no = $pod_no;
						} else {
							$awb_no = $id;
						}


						//============Get Customer details//
						$whr = array('cid' => $data[0]);
						$customerRes = $this->basic_operation_m->get_table_row('tbl_customers', $whr);

						$customer_id = $customerRes->customer_id;
						$sender_name = $customerRes->customer_name;
						$sender_address = $customerRes->address;
						$sender_pincode = $customerRes->pincode;
						$sender_city = $customerRes->city;
						$sender_state = $customerRes->state;
						$sender_contactno = $customerRes->phone;
						$sender_gstno = $customerRes->gstno;
						// courier id, mode id
						$modeDispatch = $data[4];
						$whr = array("mode_name" => $modeDispatch);
						$mode_dispatch_detail = $this->basic_operation_m->get_table_row("transfer_mode", $whr);
						$mode_id = $mode_dispatch_detail->transfer_mode_id;


						$forworder = $data[2];
						$whr_c = array("c_company_name" => $forworder);
						$courier_company_details = $this->basic_operation_m->get_table_row("courier_company", $whr_c);
						$c_courier_id = $courier_company_details->c_id;
						//============Fuel Gst	

						$city = $this->input->post('city');
						$state = $this->input->post('state');
						$doc_type = $this->input->post('doc_type');

						$reciever_pincode = $data[12];
						$sender_pincode = $data[20];

						$receiverCityDetails = $this->basic_operation_m->get_table_row('pincode', array('pin_code' => $reciever_pincode));
						$senderCityDetails = $this->basic_operation_m->get_table_row('pincode', array('pin_code' => $reciever_pincode));

						$reciever_state = $receiverCityDetails->state_id;
						$reciever_city = $receiverCityDetails->city_id;

						$whr1 = array('state' => $reciever_state, 'city' => $reciever_city);
						$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

						$regionid = $res1->row()->regionid;

						$whr3 = array('region_id' => $regionid);
						$res3 = $this->basic_operation_m->selectRecord('region_master', $whr3);
						$result3 = $res3->row();

						$zone_id = $result3->region_id;
						$region_name = $result3->region_name;

						$whr1 = array('state' => $senderCityDetails->state_id, 'city' => $senderCityDetails->city_id);
						$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

						$sender_zone_id = $res1->row()->regionid;

						$chargable_weight = $data[18];
						//$receiver_gstno =$this->input->post('receiver_gstno');

						$current_date = date("Y-m-d", strtotime($booking_date));
						$chargable_weight = $chargable_weight * 1000;
						$fixed_perkg = 0;
						$addtional_250 = 0;
						$addtional_500 = 0;
						$addtional_1000 = 0;

						// calculationg fixed per kg price 	
						$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where customer_id='" . $customer_id . "' AND from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $zone_id . "' AND c_courier_id='" . $c_courier_id . "' AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND (" . $data[18] . " BETWEEN weight_range_from AND weight_range_to) and fixed_perkg = '0' ORDER BY applicable_from DESC LIMIT 1");



						$frieht = 0;
						if ($fixed_perkg_result->num_rows() > 0) {
							$data['rate_master'] = $fixed_perkg_result->row();
							$rate = $data['rate_master']->rate;
							$fixed_perkg = $rate;
						} else {
							$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where customer_id='" . $customer_id . "' AND from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $zone_id . "' AND c_courier_id='" . $c_courier_id . "' AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg = '0' ORDER BY applicable_from DESC,weight_range_to desc LIMIT 1");

							if ($fixed_perkg_result->num_rows() > 0) {
								$data['rate_master'] = $fixed_perkg_result->row();
								$rate = $data['rate_master']->rate;
								$weight_range_to = round($data['rate_master']->weight_range_to * 1000);
								$fixed_perkg = $rate;
							}

							$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where customer_id='" . $customer_id . "' AND from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $zone_id . "' AND c_courier_id='" . $c_courier_id . "' AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg <> '0' ");

							if ($fixed_perkg_result->num_rows() > 0) {
								if ($weight_range_to > 1000) {
									$weight_range_to = $weight_range_to;
								} else {
									$weight_range_to = 1000;
								}
								$left_weight = ($chargable_weight - $weight_range_to);

								$rate_master = $fixed_perkg_result->result();

								foreach ($rate_master as $key => $values) {

									if ($values->fixed_perkg == 1) // 250 gm slab
									{

										$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
										$total_slab = $slab_weight / 250;
										$addtional_250 = $addtional_250 + $total_slab * $values->rate;
										$left_weight = $left_weight - $slab_weight;
									}

									if ($values->fixed_perkg == 2) // 500 gm slab
									{
										$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;

										if ($slab_weight < 1000) {
											if ($slab_weight <= 500) {
												$slab_weight = 500;
											} else {
												$slab_weight = 1000;
											}

										} else {
											$diff_ceil = $slab_weight % 1000;
											$slab_weight = $slab_weight - $diff_ceil;

											if ($diff_ceil <= 500 && $diff_ceil != 0) {

												$slab_weight = $slab_weight + 500;
											} elseif ($diff_ceil <= 1000 && $diff_ceil != 0) {

												$slab_weight = $slab_weight + 1000;
											}
										}

										$total_slab = $slab_weight / 500;
										$addtional_500 = $addtional_500 + $total_slab * $values->rate;
										$left_weight = $left_weight - $slab_weight;

									}

									if ($values->fixed_perkg == 3) // 1000 gm slab
									{
										$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
										$total_slab = ceil($slab_weight / 1000);

										$addtional_1000 = $addtional_1000 + $total_slab * $values->rate;
										$left_weight = $left_weight - $slab_weight;
									}
								}

							}

						}

						//echo $fixed_perkg ."-". $addtional_250 ."-". $addtional_500 ."-". $addtional_1000;exit;		

						$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000;
						$amount = $frieht;

						//	$whr1 = array('courier_id' => $c_courier_id);
						$whr1 = array('courier_id' => $c_courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date);
						$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

						if ($res1) {
							$fuel_per = $res1->fuel_price;
						} else {
							$fuel_per = '0';
						}
						$fuel_subcharges = ($amount * $fuel_per / 100);

						$sub_total = ($amount + $fuel_subcharges);

						$first_two_char = substr($sender_gstno, 0, 2);

						if ($sender_gstno == "") {
							$first_two_char = 27;
						}

						if ($first_two_char == 27) {
							$cgst = ($sub_total * 9 / 100);
							$sgst = ($sub_total * 9 / 100);
							$igst = 0;
							$grand_total = $sub_total + $cgst + $sgst + $igst;
						} else {
							$cgst = 0;
							$sgst = 0;
							$igst = ($sub_total * 18 / 100);
							$grand_total = $sub_total + $igst;
						}

						//==============

						//booking details//
						$data_booking = array(
							'doc_type' => $data[5],
							'doc_nondoc' => $doc_nondoc,
							'courier_company_id' => $c_courier_id,
							'company_type' => 'Domestic',
							'mode_dispatch' => $mode_id,
							'pod_no' => $awb_no,
							'forwording_no' => $data[3],
							'forworder_name' => $data[2],
							'customer_id' => $customer_id,
							'sender_name' => $sender_name,
							'sender_address' => $sender_address,
							'sender_city' => $sender_city,
							'sender_state' => $sender_state,
							'sender_pincode' => $sender_pincode,
							'sender_contactno' => $sender_contactno,
							'sender_gstno' => $sender_gstno,
							'reciever_name' => $data[9],
							'contactperson_name' => $data[10],
							'reciever_address' => $data[11],
							'reciever_pincode' => $reciever_pincode,
							'reciever_city' => $reciever_city,
							'reciever_state' => $reciever_state,
							'receiver_zone' => $region_name,
							'receiver_zone_id' => $zone_id,
							'invoice_no' => $data[7],
							'invoice_value' => $data[8],
							'special_instruction' => $data[6],
							'booking_date' => $booking_date,
							'dispatch_details' => 'Credit',
							'frieht' => $frieht,
							'transportation_charges' => '0',
							'pickup_charges' => '0',
							'delivery_charges' => '0',
							'courier_charges' => '0',
							'awb_charges' => '0',
							'other_charges' => '0',
							'total_amount' => $amount,
							'fuel_subcharges' => $fuel_subcharges,
							'sub_total' => $sub_total,
							'cgst' => $cgst,
							'sgst' => $sgst,
							'igst' => $igst,
							'grand_total' => $grand_total,
							'user_id' => $user_id,
							'user_type' => $user_type,
							'branch_id' => $branch_id,
							'booking_type' => 1,
						);

						//echo "<pre>"; print_r($data);
						$query = $this->basic_operation_m->insert('tbl_domestic_booking', $data_booking);
						$lastid = $this->db->insert_id();
						//======================
						$valumetric_weight = (($data[15] * $data[16] * $data[17]) / 5000) * $data[13];

						$data2 = array(
							'booking_id' => $lastid,
							'actual_weight' => $data[14],
							'valumetric_weight' => $valumetric_weight,
							'length' => $data[15],
							'breath' => $data[16],
							'height' => $data[17],
							'chargable_weight' => $chargable_weight,
							'per_box_weight' => $data[14],
							'no_of_pack' => $data[13],
							'actual_weight_detail' => json_encode([$data[14]]),
							'valumetric_weight_detail' => json_encode([$valumetric_weight]),
							'chargable_weight_detail' => json_encode([$chargable_weight]),
							'length_detail' => json_encode([$data[15]]),
							'breath_detail' => json_encode([$data[16]]),
							'height_detail' => json_encode([$data[17]]),
							'no_pack_detail' => json_encode([$data[13]]),
							'per_box_weight_detail' => json_encode([$data[14]]),
						);

						$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);

						$username = $this->session->userdata("userName");
						$whr = array('username' => $username);
						$res = $this->basic_operation_m->getAll('tbl_users', $whr);
						$branch_id = $res->row()->branch_id;

						$whr = array('branch_id' => $branch_id);
						$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
						$branch_name = $res->row()->branch_name;

						$whr = array('booking_id' => $lastid);
						$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
						$podno = $res->row()->pod_no;
						$customerid = $res->row()->customer_id;
						$data3 = array(
							'id' => '',
							'pod_no' => $podno,
							'status' => 'Booked',
							'branch_name' => $branch_name,
							'tracking_date' => $booking_date,
							'booking_id' => $lastid,
							'forworder_name' => $data[2],
							'forwording_no' => $data[3],
							'is_spoton' => ($data[2] == 'spoton_service') ? 1 : 0,
							'is_delhivery_b2b' => ($data[2] == 'delhivery_b2b') ? 1 : 0,
							'is_delhivery_c2c' => ($data[2] == 'delhivery_c2c') ? 1 : 0
						);

						$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);

					} //==end already exist condition
					$cnt++;
				}
				$msg = 'File uploaded successfully..';
				$class = 'alert alert-success alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/view-upload-domestic-shipment');
		}
	}

	public function check_duplicate_awb_no()
	{
		$data = [];
		$pod_no = $this->input->post('pod_no');
		$whr = array('pod_no' => $pod_no);
		$result = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr);

		$pod_no = $result->pod_no;
		if ($pod_no != "") {
			$data['msg'] = "Forwording number is duplicate ";
		} else {
			$data['msg'] = "";
		}

		echo json_encode($data);
		exit;
	}


	public function track_shipment()
	{
		$data = array();
		$resAct = $this->basic_operation_m->getAll('tbl_testimonial', '');

		if ($resAct->num_rows() > 0) {
			$data['testimonial'] = $resAct->result_array();
		} else {
			$data['testimonial'] = array();
		}
		$resAct1 = $this->db->query("select * from tbl_news limit 9 ");

		if ($resAct1->num_rows() > 0) {
			$data['homenews'] = $resAct1->result_array();
		} else {
			$data['homenews'] = array();
		}

		$data['delivery_pod'] = array();
		if (isset($_GET['pod_no'])) {
			$pod_no = $this->input->get('pod_no');
			$check_pod_international = $this->db->query("select pod_no from tbl_international_booking where pod_no like '%$pod_no%'");
			$check_result = $check_pod_international->row();

			if (isset($check_result)) {

				$reAct = $this->db->query("select tbl_international_booking.*,tbl_international_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.country_name as reciever_country_name from tbl_international_booking left join tbl_international_weight_details on tbl_international_booking.booking_id=tbl_international_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_international_booking.sender_city INNER JOIN zone_master recievercity ON recievercity.z_id = tbl_international_booking.reciever_country_id where pod_no like '%$pod_no%'");
				$data['info'] = $reAct->row();

				$courier_company_id = $data['info']->courier_company_id;

				$tracking_href_details = $this->db->query("select * from courier_company where c_id=" . $courier_company_id);
				$data['forwording_track'] = $tracking_href_details->row();


				$reAct = $this->db->query("select * from tbl_international_tracking where pod_no like '%$pod_no%' ORDER BY id DESC");
				$data['pod'] = $reAct->result();
				$data['del_status'] = $reAct->row();



			} else {

				$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where pod_no like '%$pod_no%'");
				$data['info'] = $reAct->row();

				$courier_company_id = $data['info']->courier_company_id;
				$tracking_href_details = $this->db->query("select * from courier_company where c_id=" . $courier_company_id);
				$data['forwording_track'] = $tracking_href_details->row();

				$reAct = $this->db->query("select * from tbl_domestic_tracking,tbl_branch,tbl_city where tbl_branch.`branch_name`=tbl_domestic_tracking.branch_name AND tbl_city.city_id=tbl_branch.city AND pod_no like '%$pod_no%' ORDER BY id DESC;");
				$data['pod'] = $reAct->result();
				$data['del_status'] = $reAct->row();
			}

			if (!empty($data['pod'])) {
				foreach ($data['pod'] as $k => $values) {
					if ($values->status == 'DELIVERED' || $values->status == 'Delivered') {
						$data['delivery_date'] = $values->tracking_date;
					}
				}
			}

			//$lrNum 					= $data['pod'][0]->forwording_no;
			//$podData 				= $this->deliverypod($lrNum);
			//$data['delivery_pod'] 	= json_decode($podData, true);

			$reAct = $this->db->query("select * from tbl_upload_pod where pod_no='$pod_no'");
			$data['podimg'] = $reAct->row();
			//echo $this->db->last_query($data);
		}
		// echo "<pre>";

		// print_r($data);

		// exit();
		$this->load->view('admin/track_shipment/track_shipment', $data);
	}


	public function download_pod($id)
	{
		// Load library
		$this->load->library('zend');
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');
		$whr = array('booking_id' => $id);
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");
		if ($id != "") {
			$data['booking'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $whr);
			$where = array('id' => 1);
			$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company', $where);
			// echo '<pre>'; print_r($data['booking']); die;
			$html = $this->load->view('admin/download_shipment', $data, true);
		}

		// $html = $this->load->view('admin/booking_domestic_master/booking_print', $data, true);	
		// echo $html; die;

		$this->load->library('M_pdf');

		$this->m_pdf->pdf->setAutoTopMargin = 'stretch';
		$this->m_pdf->pdf->autoMarginPadding = 'pad';
		$this->m_pdf->pdf->setAutoBottomMargin = 'stretch';

		// $this->m_pdf->pdf->SetHTMLFooter('<div style="text-align: right">Page {PAGENO} out of {nbpg}</div>');
		$this->m_pdf->pdf->WriteHTML($html);

		$this->m_pdf->pdf->defaultheaderfontsize = 14;
		$this->m_pdf->pdf->defaultheaderfontstyle = 'B';
		$this->m_pdf->pdf->defaultheaderline = 1;

		$this->mpdf->showImageErrors = true;
		$this->mpdf->debug = true;

		$type = 'I';
		$filename = $invoice_series . '_' . $inc_num . '.pdf';
		$savefolderpath = 'assets/invoice/domestic/';

		$this->m_pdf->pdf->Output($savefolderpath . $filename, $type);
	}

	public function getCashAccess()
	{
		$customer_id = $_REQUEST['customer_id'];
		$sender_gstno = $_REQUEST['sender_gstno'];
		$tbl_customers_info = $this->basic_operation_m->get_query_row("select gstno,gst_charges from tbl_customers where customer_id = '$customer_id'");
		$tbl_branch_info = $this->basic_operation_m->get_query_row("select * from tbl_branch where branch_id = " . $_SESSION['branch_id']);
		$gst = $this->db->query("SELECT * FROM tbl_gst_setting 	WHERE id='1'")->row();
		$gstno = trim($sender_gstno);
		$gst_number = trim($tbl_branch_info->gst_number);
		if (!empty($gstno) && !empty($gst_number)) {
			$branch_gst = substr($gst_number,0,2);
			$sender_gst = substr($gstno,0,2);

			if ($branch_gst == $sender_gst) {
				$cgst = $gst->cgst;
				$sgst = $gst->sgst;
				$igst = 0;
			} else {
				$cgst = 0;
				$sgst = 0;
				$igst = $gst->igst;
			}
		}else {
			$branch_gst =0;
			$sender_gst =0;
			$cgst = 0;
			$sgst = 0;
			$igst = $gst->igst;
		}

		echo json_encode(
			array(
				'cgst' => $cgst,
				'sgst' => $sgst,
				'igst' => $igst,
				'branch_gst' => $branch_gst,
				'sender_gst' => $sender_gst
			)
		);
	}

	public function available_cft() {
		$courier_id = $this->input->post('courier_id');
		$booking_date = trim($this->input->post('booking_date'));
		$customer_id = trim($this->input->post('customer_id'));

		if (!empty($booking_date)) {
			$current_date = date("Y-m-d",strtotime($booking_date));
		}else{
			$current_date = date('Y-m-d');
		}
		
		
		$whr1 = array('fuel_from <=' => $current_date,'fuel_to >=' => $current_date);
		$where = '(courier_id="'.$courier_id.'" or courier_id = "0") AND (customer_id="'.$customer_id.'" or customer_id = "0")';
		$this->db->select('*');
		$this->db->from('courier_fuel');
		$this->db->where($whr1);
		$this->db->where($where);
		$this->db->order_by('customer_id','DESC');
		// $this->db->where('customer_id',$customer_id);
		
		$query	=	$this->db->get();
		$res1 = $query->row();
		// $res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

		if($res1){$fuel_per = $res1->cft; }else{$fuel_per ='0';}
		if($res1){$fuel_per2 = $res1->air_cft; }else{$fuel_per2 ='0';}

		// echo $this->db->last_query();

		$result2= array('cft_charges'=>$fuel_per,'air_cft'=>$fuel_per2);
		echo json_encode($result2);
	}

	public function getFuelprice()
	{
		$customer_id = $this->input->post('customer_id');
		$courier_id = $this->input->post('courier_id');
		$booking_date = $this->input->post('booking_date');
		$current_date = date("Y-m-d", strtotime($booking_date));
		$whr1 = array('courier_id' => $courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => $customer_id);
		$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);
		if (empty($res1)) {
			$whr1 = array('courier_id' => $courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => '0');
			$res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY customer_id DESC");
		}
		$gst_details = $this->basic_operation_m->get_query_row('select * from tbl_gst_setting order by id desc limit 1');
		if ($res1) {
			$fuel_per = $res1->fuel_price;
		} else {
			$fuel_per = '0';
		}
		$fuel_charge = $res1->fc_type;
		$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");
		if ($tbl_customers_info->gst_charges == 1) {
			     $gst_check = 1;
				 $cgst_per = $gst_details->cgst;
				 $sgst_per = $gst_details->sgst;
				 $igst_per = 0;
			}else{
				$gst_check = 2;
				$cgst_per = 0;
				$sgst_per = 0;
				$igst_per = $gst_details->igst;

			}
			$data = [
				'custAccess'=> $gst_check,
				'fuelPrice'=>$fuel_per,
				'fuel_charge'=>$fuel_charge,
				'cgst'=>$cgst_per,
				'sgst'=>$sgst_per,
				'igst'=>$igst_per
			];
		echo json_encode($data);

	}

}

?>
