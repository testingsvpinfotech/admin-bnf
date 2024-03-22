<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Booking_model');
		$this->load->model('Generate_pod_model');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}
	public function mis_report($offset = 0, $searching = '')
	{
		$username = $this->session->userdata("userName");
		$__POST = $_GET;

		$usernamee = $this->input->post("username");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);

		$branch_id = $res->row()->branch_id;
		$filterCond = '';
		$data['international_allpoddata'] = array();
		$data['domestic_allpoddata'] = array();
		$total_domestic_allpoddata = 0;
		$total_international_allpoddata = 0;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$user_id = $this->session->userdata("userId");
		$userType = $this->session->userdata("userType");
		$branch_id = $this->session->userdata("branch_id");
		$all_data = $this->input->get();
		$data['post_data'] = $all_data;

		if (!empty($all_data)) {

			if ($userType != '1' and $userType != '10' and $userType != '20' and $userType != '22' and $userType != '23' and $userType != '11' and $userType != '15') {
				$whr = "tbl_international_booking.branch_id = '$branch_id'";
				$whr_d = "tbl_domestic_booking.branch_id = '$branch_id'";
			} else {
				$whr = '1';
				$whr_d = '1';
			}



			$awb_no = trim($all_data['awb_no']);
			if ($awb_no != "") {
				$whr .= " AND tbl_international_booking.pod_no='$awb_no'";
				$whr_d .= " AND  tbl_domestic_booking.pod_no='$awb_no'";
			}

			$bill_type = $all_data['bill_type'];
			if ($bill_type != "ALL") {
				$whr .= " AND  dispatch_details='$bill_type'";
				$whr_d .= " AND  dispatch_details='$bill_type'";
			}

			$doc_type = $all_data['doc_type'];
			if ($doc_type == '1') {
				$sel_doc_type = "Non Document";
			} else if ($doc_type == '0') {
				$sel_doc_type = "Document";
			} else {
				$sel_doc_type = "ALL";
			}

			$courier_company = $all_data['courier_company'];
			if ($courier_company != "ALL") {
				$whr .= " AND tbl_international_booking.courier_company_id='$courier_company'";
				$whr_d .= " AND tbl_domestic_booking.courier_company_id='$courier_company'";
			}

			$status = $all_data['status'];

			if (($status == 1 || $status == 0) && $status != 'ALL') {

				$whr .= " AND tbl_international_booking.is_delhivery_complete='$status'";
				$whr_d .= " AND tbl_domestic_booking.is_delhivery_complete='$status'";
			} elseif ($status == 2) {
				$whr .= " AND (
					tbl_international_tracking.status = 'RTO' 
					OR tbl_international_tracking.status LIKE '%Return%'
					OR tbl_international_tracking.status = 'Return to Orgin' 
					OR tbl_international_tracking.status = 'Door Close' 
					OR tbl_international_tracking.status = 'Address ok no search person' 
					OR tbl_international_tracking.status = 'Address not found' 
					OR tbl_international_tracking.status = 'No service' 
					OR tbl_international_tracking.status = 'Refuse' 
					OR tbl_international_tracking.status = 'Wrong address' 
					OR tbl_international_tracking.status = 'Person expired' 
					OR tbl_international_tracking.status = 'Lost Intransit' 
					OR tbl_international_tracking.status = 'Not collected by consignee' 
					OR tbl_international_tracking.status = 'Delivery not attempted'

				)";

				$whr_d .= " AND (
					tbl_domestic_tracking.status = 'RTO' 
					OR tbl_domestic_tracking.status LIKE '%Return%'
					OR tbl_domestic_tracking.status = 'Return to Orgin' 
					OR tbl_domestic_tracking.status = 'Door Close' 
					OR tbl_domestic_tracking.status = 'Address ok no search person' 
					OR tbl_domestic_tracking.status = 'Address not found' 
					OR tbl_domestic_tracking.status = 'No service' 
					OR tbl_domestic_tracking.status = 'Refuse'  
					OR tbl_domestic_tracking.status = 'Wrong address' 
					OR tbl_domestic_tracking.status = 'Person expired' 
					OR tbl_domestic_tracking.status = 'Lost Intransit' 
					OR tbl_domestic_tracking.status = 'Not collected by consignee' 
					OR tbl_domestic_tracking.status = 'Delivery not attempted'

				)";
			}

			$customer_id = $all_data['customer_id'];
			if ($customer_id != "ALL") {
				$whr .= " AND tbl_international_booking.customer_id='$customer_id'";
				$whr_d .= " AND tbl_domestic_booking.customer_id='$customer_id'";
			}

			if ($sel_doc_type != "ALL") {
				$whr .= " AND doc_nondoc='$sel_doc_type'";
				$whr_d .= " AND doc_nondoc='$sel_doc_type'";
			}

			$from_date = $all_data['from_date'];
			$to_date = $all_data['to_date'];
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($all_data['from_date']));
				$to_date = date("Y-m-d", strtotime($all_data['to_date']));
				$whr .= " AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
				$whr_d .= " AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
			}


			$company_type = $all_data['company_type'];

			if ($company_type != "ALL") {
				if ($company_type == "International") {
					// $data['international_allpoddata'] = $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
				} else if ($company_type == "Domestic") {
					$data['domestic_allpoddata'] = $this->Generate_pod_model->get_domestic_tracking_data($whr_d, "100", $offset);

				}
			} else {


				// $data['international_allpoddata'] 		= $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
				// echo $this->db->last_query();
				$data['domestic_allpoddata'] = $this->Generate_pod_model->get_domestic_tracking_data($whr_d, "100", $offset);

				// echo "<br>";
				// echo $this->db->last_query();die;


			}

			$filterCond = urldecode($whr_d);
		} else {


			if (!empty($searching)) {
				$filterCond = urldecode($searching);
				$whr = str_replace('domestic', 'international', $filterCond);
				$whr_d = $filterCond;
			} else {
				$from_date = date("Y-m-d");
				$to_date = date("Y-m-d");
				$whr = "";
				$whr_d = "";

			}

			//	$pod = $value['pod_no'];
			//  $customer_id = $value['customer_id'];
			//$getfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left 	join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->result_array(); 
			// $getMasterfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->result_array(); 



			//$whr									= str_replace('1','',$whr);
			//$whr_d									= str_replace('1','',$whr_d);


			// $data['international_allpoddata'] 		= $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
			// $data['domestic_allpoddata'] 			= $this->Generate_pod_model->get_domestic_tracking_data($whr_d,"100",$offset); 

		}

		$d_cnt = $this->tot_cnt_d($whr_d);
		$this->load->library('pagination');
		$total_count1 = $d_cnt;


		$data['total_count'] = $total_count1;
		$config['total_rows'] = $total_count1;
		$config['base_url'] = 'admin/list-mis-report/';
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
			$data['serial_no'] = 0;
		} else {
			$config['uri_segment'] = 3;
			$data['serial_no'] = $offset + 1;
		}



		if (isset($_GET['submit']) && $_GET['submit'] == 'Download Excel') {
			// echo "Exist";exit();
			$this->download_mis_report($whr_d, $whr);
		}

		$this->pagination->initialize($config);

		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", "");
		$data['customers_list'] = $this->db->query("SELECT * FROM tbl_customers ORDER BY  customer_name ASC")->result_array();
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', '');

		$this->load->view('admin/report_master/view_mis_report', $data);
	}

	public function mis_report2($offset = 0, $searching = '')
	{
		$username = $this->session->userdata("userName");
		$__POST = $_GET;

		$usernamee = $this->input->post("username");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);

		$branch_id = $res->row()->branch_id;
		$filterCond = '';
		$data['international_allpoddata'] = array();
		$data['domestic_allpoddata'] = array();
		$total_domestic_allpoddata = 0;
		$total_international_allpoddata = 0;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$user_id = $this->session->userdata("userId");
		$userType = $this->session->userdata("userType");
		$branch_id = $this->session->userdata("branch_id");
		$all_data = $this->input->get();
		$data['post_data'] = $all_data;

		// print_r($all_data);exit;
		// echo "<pre>";
		// print_r($this->session->userdata());exit();

		if (!empty($all_data)) {

			if ($userType != '1') {
				$whr = "tbl_international_booking.branch_id = '$branch_id'";
				$whr_d = "tbl_domestic_booking.branch_id = '$branch_id'";
			} else {
				$whr = '1';
				$whr_d = '1';
			}



			$awb_no = $all_data['awb_no'];
			if ($awb_no != "") {
				$whr .= " AND tbl_international_booking.pod_no='$awb_no'";
				$whr_d .= " AND  tbl_domestic_booking.pod_no='$awb_no'";
			}

			$bill_type = $all_data['bill_type'];
			if ($bill_type != "ALL") {
				$whr .= " AND  dispatch_details='$bill_type'";
				$whr_d .= " AND  dispatch_details='$bill_type'";
			}

			$doc_type = $all_data['doc_type'];
			if ($doc_type == '1') {
				$sel_doc_type = "Non Document";
			} else if ($doc_type == '0') {
				$sel_doc_type = "Document";
			} else {
				$sel_doc_type = "ALL";
			}

			$courier_company = $all_data['courier_company'];
			if ($courier_company != "ALL") {
				$whr .= " AND tbl_international_booking.courier_company_id='$courier_company'";
				$whr_d .= " AND tbl_domestic_booking.courier_company_id='$courier_company'";
			}

			$status = $all_data['status'];

			if (($status == 1 || $status == 0) && $status != 'ALL') {

				$whr .= " AND tbl_international_booking.is_delhivery_complete='$status'";
				$whr_d .= " AND tbl_domestic_booking.is_delhivery_complete='$status'";
			} elseif ($status == 2) {
				$whr .= " AND (
					tbl_international_tracking.status = 'RTO' 
					OR tbl_international_tracking.status LIKE '%Return%'
					OR tbl_international_tracking.status = 'Return to Orgin' 
					OR tbl_international_tracking.status = 'Door Close' 
					OR tbl_international_tracking.status = 'Address ok no search person' 
					OR tbl_international_tracking.status = 'Address not found' 
					OR tbl_international_tracking.status = 'No service' 
					OR tbl_international_tracking.status = 'Refuse' 
					OR tbl_international_tracking.status = 'Wrong address' 
					OR tbl_international_tracking.status = 'Person expired' 
					OR tbl_international_tracking.status = 'Lost Intransit' 
					OR tbl_international_tracking.status = 'Not collected by consignee' 
					OR tbl_international_tracking.status = 'Delivery not attempted'

				)";

				$whr_d .= " AND (
					tbl_domestic_tracking.status = 'RTO' 
					OR tbl_domestic_tracking.status LIKE '%Return%'
					OR tbl_domestic_tracking.status = 'Return to Orgin' 
					OR tbl_domestic_tracking.status = 'Door Close' 
					OR tbl_domestic_tracking.status = 'Address ok no search person' 
					OR tbl_domestic_tracking.status = 'Address not found' 
					OR tbl_domestic_tracking.status = 'No service' 
					OR tbl_domestic_tracking.status = 'Refuse'  
					OR tbl_domestic_tracking.status = 'Wrong address' 
					OR tbl_domestic_tracking.status = 'Person expired' 
					OR tbl_domestic_tracking.status = 'Lost Intransit' 
					OR tbl_domestic_tracking.status = 'Not collected by consignee' 
					OR tbl_domestic_tracking.status = 'Delivery not attempted'

				)";
			}

			$customer_id = $all_data['customer_id'];
			if ($customer_id != "ALL") {
				$whr .= " AND tbl_international_booking.customer_id='$customer_id'";
				$whr_d .= " AND tbl_domestic_booking.customer_id='$customer_id'";
			}

			if ($sel_doc_type != "ALL") {
				$whr .= " AND doc_nondoc='$sel_doc_type'";
				$whr_d .= " AND doc_nondoc='$sel_doc_type'";
			}

			$from_date = $all_data['from_date'];
			$to_date = $all_data['to_date'];
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($all_data['from_date']));
				$to_date = date("Y-m-d", strtotime($all_data['to_date']));
				$whr .= " AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
				$whr_d .= " AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
			}


			$company_type = $all_data['company_type'];

			if ($company_type != "ALL") {
				if ($company_type == "International") {
					$data['international_allpoddata'] = $this->Generate_pod_model->get_international_tracking_data2($whr, "100", $offset);
					echo $this->db->last_query();
				} else if ($company_type == "Domestic") {
					$data['domestic_allpoddata'] = $this->Generate_pod_model->get_domestic_tracking_data2($whr_d, "100", $offset);
					echo $this->db->last_query();
				}
			} else {


				$data['international_allpoddata'] = $this->Generate_pod_model->get_international_tracking_data2($whr, "100", $offset);
				echo $this->db->last_query();
				$data['domestic_allpoddata'] = $this->Generate_pod_model->get_domestic_tracking_data2($whr_d, "100", $offset);

				// echo "<br>";
				echo $this->db->last_query();
				die;


			}

			$filterCond = urldecode($whr_d);
		} else {


			if (!empty($searching)) {
				$filterCond = urldecode($searching);
				$whr = str_replace('domestic', 'international', $filterCond);
				$whr_d = $filterCond;
			} else {
				$from_date = date("Y-m-d");
				$to_date = date("Y-m-d");
				$whr = "";
				$whr_d = "";

			}

			//	$pod = $value['pod_no'];
			//  $customer_id = $value['customer_id'];
			//$getfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left 	join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->result_array(); 
			// $getMasterfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->result_array(); 



			//$whr									= str_replace('1','',$whr);
			//$whr_d									= str_replace('1','',$whr_d);


			// $data['international_allpoddata'] 		= $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
			// $data['domestic_allpoddata'] 			= $this->Generate_pod_model->get_domestic_tracking_data($whr_d,"100",$offset); 

		}

		$i_cnt = $this->tot_cnt_i($whr);
		$d_cnt = $this->tot_cnt_d($whr_d);


		$this->load->library('pagination');
		$total_count1 = $i_cnt + $d_cnt;


		$data['total_count'] = $total_count1;
		$config['total_rows'] = $total_count1;
		$config['base_url'] = 'admin/list-mis-report/';
		// $config['suffix'] 				= '/'.urlencode($filterCond);

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
			$data['serial_no'] = 0;
		} else {
			$config['uri_segment'] = 3;
			$data['serial_no'] = $offset + 1;
		}



		if (isset($_GET['submit']) && $_GET['submit'] == 'Download Excel') {
			// echo "Exist";exit();
			$this->download_mis_report($whr_d, $whr);
		}

		$this->pagination->initialize($config);

		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", "");
		$data['customers_list'] = $this->basic_operation_m->get_all_result("tbl_customers", "");
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', '');

		$this->load->view('admin/report_master/view_mis_report', $data);
	}

	public function tot_cnt_i($whrAct)
	{
		$this->db->select('count(*) as cnt');
		$this->db->from('tbl_international_booking');
		if ($whrAct != "") {
			$this->db->where($whrAct);
		}
		// $this->db->limit(100,$limit);
		$query = $this->db->get();

		$temp = $query->row_array();
		// echo $this->db->last_query();

		return $temp['cnt'];
	}

	public function tot_cnt_d($whrAct)
	{
		$this->db->select('count(*) as cnt');
		$this->db->from('tbl_domestic_booking');
		if ($whrAct != "") {
			$this->db->where($whrAct);
		}
		// $this->db->limit(100,$limit);
		$query = $this->db->get();

		$temp = $query->row_array();

		// echo $this->db->last_query();

		return $temp['cnt'];
	}

	public function download_mis_report($where_d, $where_i)
	{

		$date = date('d-m-Y');
		$filename = "Mis_report_" . $date . ".csv";
		$fp = fopen('php://output', 'w');
		$tat = '';
		if ($this->session->userdata("userType") == 22 or $this->session->userdata("userType") == 10 or $this->session->userdata("userType") == 11 or $this->session->userdata("userType") == 15) {
			$header = array(
				"SrNo",
				"Booking Date",
				"AWB",
				"Mode",
				"Risk Type",
				"Booking Branch",
				"Destination",
				"Customer code",
				"Customer Name",
				"Sales Person Name",
				"Sales Person Branch",
				"Consignor Origin",
				"Consignor",
				"Consignee",
				"Consignee Pincode",
				"NOP",
				"AW",
				"CW",
				"Consignor Invoice No",
				"Consignor Invoice Value",
				"Bill Type",
				"Current Status",
				"Last Scan Branch",
				"Last scan Date & time",
				"TAT",
				"EDD Date",
				"Delivery Date",
				"Deliverd TO",
				"RTO Date",
				"RTO Reason",
				// "Sub Total",
				"POD Status",
				"POD Uploaded Date & Time",
				"Franchise Code",
				"Franchise Name",
				"Master Franchise Name",
				"eWay no",
				"Eway Expiry date",
				"Pickupinscan date & time",
				"pickupinscan branch",
				"Booking Branch Out scan Date & Time",
				"Delivery branch In-scan Date & Time",
				"DRS Date & time",
				"DRS Branch",
				"Regular/ODA",
				// "Freight",
				// "Handling",
				// "Pickup",
				// "ODA",
				// "Insurance",
				// "COD",
				// "AWB",
				// "Other",
				// "Topay",
				// "Appoint",
				// "FOV",
				// "Total",
				// "Fuel",
				// "Subtotal",
				"PRQ No",
				"Pickup Genarte Date",
				"Pickup Requested Date",
				"PRQ Closed Date",
				"PRQ Comment",
				"Cash Invoice No",
				"Invoice Date",
				"PayBy",
				"Payment Ref No",
				"Coloader Name",
				"CD No",
				"CD Outscan",
				"CD Inscan",
				"Product Desc",
				"Type Of Package"

			);
		} else {
			$header = array(
				"SrNo",
				"Booking Date",
				"AWB",
				"Mode",
				"Risk Type",
				"Booking Branch",
				"Destination",
				"Customer code",
				"Customer Name",
				"Sales Person Name",
				"Sales Person Branch",
				"Consignor Origin",
				"Consignor",
				"Consignee",
				"Consignee Pincode",
				"NOP",
				"AW",
				"CW",
				"Consignor Invoice No",
				"Consignor Invoice Value",
				"Bill Type",
				"Current Status",
				"Last Scan Branch",
				"Last scan Date & time",
				"TAT",
				"EDD Date",
				"Delivery Date",
				"Deliverd TO",
				"RTO Date",
				"RTO Reason",
				"Sub Total",
				"POD Status",
				"POD Uploaded Date & Time",
				"Franchise Code",
				"Franchise Name",
				"Master Franchise Name",
				"eWay no",
				"Eway Expiry date",
				"Pickupinscan date & time",
				"pickupinscan branch",
				"Booking Branch Out scan Date & Time",
				"Delivery branch In-scan Date & Time",
				"DRS Date & time",
				"DRS Branch",
				"Regular/ODA",
				"Freight",
				"Handling",
				"Pickup",
				"ODA",
				"Insurance",
				"COD",
				"AWB",
				"Other",
				"Topay",
				"Appoint",
				"FOV",
				"Total",
				"Fuel",
				"Subtotal",
				"PRQ No",
				"Pickup Genarte Date",
				"Pickup Requested Date",
				"PRQ Closed Date",
				"PRQ Comment",
				"Cash Invoice No",
				"Invoice Date",
				"PayBy",
				"Payment Ref No",
				"Coloader Name",
				"CD No",
				"CD Outscan",
				"CD Inscan",
				"Product Desc",
				"Type Of Package"

			);
		}
		//$international_allpoddata 		= $this->Generate_pod_model->get_international_tracking_data($where_i,"","");
		$domestic_allpoddata = $this->Generate_pod_model->get_domestic_tracking_data($where_d, "", "");

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 1;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		foreach ($domestic_allpoddata as $value_d) {
			$tat = '';
			$rto_reason = '';
			$rto_date = '';
			$delivery_date = '';
			if ($value_d['status'] == 'RTO' || $value_d['status'] == 'Return to Orgin' || $value_d['status'] == 'Door Close' || $value_d['status'] == 'Address ok no search person' || $value_d['status'] == 'Address not found' || $value_d['status'] == 'No service' || $value_d['status'] == 'Refuse' || $value_d['status'] == 'Shifted' || $value_d['status'] == 'Wrong address' || $value_d['status'] == 'Person expired' || $value_d['status'] == 'Lost Intransit' || $value_d['status'] == 'Not collected by consignee' || $value_d['status'] == 'Delivery not attempted') {
				$rto_reason = $value_d['comment'];
				$rto_date = $value_d['tracking_date'];
				$value_d['status'] = $value_d['status'];
			} else if ($value_d['is_delhivery_complete'] == '1') {
				$delivery_date = date('d-m-Y', strtotime($value_d['tracking_date']));
				$value_d['status'] = 'Delivered';

				$booking_date = $start = date('d-m-Y', strtotime($value_d['booking_date']));
				$start = date('d-m-Y', strtotime($value_d['booking_date']));
				$end = date('d-m-Y', strtotime($value_d['tracking_date']));
				$delivery_date = date('d-m-Y', strtotime($value_d['delivery_date']));
				$tat = ceil(abs(strtotime($start) - strtotime($end)) / 86400);
			} else {
				if ($value_d['status'] == 'shifted') {
					$value_d['status'] = 'Intransit';
				}
			}

			if (!empty($value_d['delivery_date'])) {
				$diff = abs(strtotime($value_d['delivery_date']) - strtotime($value_d['booking_date']));
				$years = floor($diff / (365 * 60 * 60 * 24));
				$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
				$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
				if ($days > 0) {
					$tat = $days;

				} else {
					$tat = ' ';
				}
				if ($value_d['booking_date'] == $value_d['delivery_date']) {
					// $delivery_date1 = ' ';
				} else {
					// $delivery_date1 = $value_d['delivery_date'];
				}
			} else {
				$tat = ' ';
			}

			if ($value_d['company_type'] == 'Domestic') {
				$value_d['company_type'] = 'DOM';
			} else {
				$value_d['company_type'] = 'INT';
			}

			if (!empty($value_d['delivery_date'])) {
				$value_d['delivery_date'] = date('d-m-Y', strtotime($value_d['delivery_date']));
			}

			$pod = $value_d['pod_no'];
			$customer_id = $value_d['customer_id'];

			$getfranchise = array();
			$getMasterfranchise = array();
			if ($value_d['user_type'] == 2) {
				$getfranchise = $this->db->query("select tbl_customers.customer_name ,cid,tbl_customers.customer_id ,parent_cust_id from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->row_array();
				$getMasterfranchise = $this->db->query("select tbl_customers.customer_name,cid from tbl_customers  where customer_type = '1' and customer_id ='" . $getfranchise['parent_cust_id'] . "'")->row_array();
			}
			if ($value_d['c_type'] == '1' || $value_d['c_type'] == '2') {
				if (!empty($value_d['fsp_id'])) {
					$sale_person = $this->db->query("SELECT * FROM tbl_users WHERE user_id ='" . $value_d['fsp_id'] . "'")->ROW();
					$sale_person_name = $sale_person->username;
					$sales_branch_name = $this->db->query("SELECT * FROM tbl_branch WHERE branch_id ='" . $sale_person->branch_id . "'")->ROW('branch_name');
				} else {
					$sale_person_name = "";
					$sales_branch_name = "";
				}

			} else {
				if (!empty($value_d['csp_id'])) {
					$sale_person = $this->db->query("SELECT * FROM tbl_users WHERE user_id ='" . $value_d['csp_id'] . "'")->ROW();
					$sale_person_name = $sale_person->username;
					$sales_branch_name = $this->db->query("SELECT * FROM tbl_branch WHERE branch_id ='" . $sale_person->branch_id . "'")->ROW('branch_name');
				} else {
					$sale_person_name = "";
					$sales_branch_name = "";
				}
			}

			//  mode get 
			$mode_d = $value_d['mode_dispatch'];
			$mode_d_name = $this->db->query("select * from transfer_mode where transfer_mode_id = '$mode_d'")->row();
			//  booking branch 
			$booking_d = $value_d['pod_no'];
			$booking_d_name = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id ASC limit 1")->row();
			$booking_dt = $value_d['pod_no'];

			$PickupInScan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Pickup-In-scan' order by id ASC limit 1")->row_array();
			if (!empty($PickupInScan)) {
				$trakingp = $PickupInScan['tracking_date'];
				$branch_pickup = $PickupInScan['branch_name'];
			} else {
				$PickupInScan1 = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status LIKE '%In Scan%' order by id ASC limit 1")->row_array();
				$trakingp = $PickupInScan1['tracking_date'];
				$branch_pickup = $PickupInScan1['branch_name'];
			}

			$outForDelivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Out For Delivery' order by id ASC limit 1")->row_array();


			$booking_d_tracking = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' and status = 'Delivered' order by id DESC limit 1")->row();
			$last_scan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' order by id DESC limit 1")->row();
			if ($last_scan->status == 'In transit') {
				$last = $this->db->query("select tbl_domestic_menifiest.source_branch from tbl_domestic_bag JOIN tbl_domestic_menifiest ON tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id where tbl_domestic_bag.pod_no = '$booking_dt' order by tbl_domestic_bag.id desc limit 1")->row();
				$last_branch = $last->source_branch;
			} else {
				$last_branch = $last_scan->branch_name;
			}
			$destination = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%shifted%' order by id ASC limit 1")->row();
			$delivery = array();
			if (!empty($outForDelivery)) {
				$delivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%In-scan%' order by id DESC limit 1")->row();
			}
			$transit = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%In transit%' order by id ASC limit 1")->row();

			//  print_r($destination->tracking_date);die;
			// echo '<pre>';print_r($booking_d_tracking->tracking_date);die;//  customer code 
			$customer = $this->db->query("select * from tbl_customers where customer_id = '$customer_id'")->row();
			// actual_weight 
			$booking_id = $value_d['booking_id'];
			$actual_weight = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row();
			// booking 
			$booking_id = $value_d['booking_id'];
			$booking_table = $this->db->query("select * from tbl_domestic_booking where booking_id = '$booking_id'")->row();

			$cid = $booking_table->sender_city;
			;
			$sender_c = $this->db->query("select * from city where id = '$cid'")->row();
			// pod 
			$pod_no = $value_d['pod_no'];
			$pod_check = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->row();
			if (empty($pod_check)) {
				$pod_status = 'NO';
				$date_time_pod = '';
			} else {
				$pod_status = 'Yes';
				$date_time_pod = $pod_check->booking_date;
			}
			$delivery_date1 = date('d-m-Y', strtotime($booking_d_name->tracking_date));
			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			if ($value_d['is_delhivery_complete'] == '1') {
				$val = $delivery_date1;
			} else {
				$val = '';
			}
			$pin = $value_d['reciever_pincode'];
			if(!empty($pin)){
				$pincode = $this->db->query("select * from pincode where pin_code = '$pin'")->row();
				$regular_oda = service_type[$pincode->isODA];
			}
			if (!empty(@$value_d['prq_no'])) {
				$close = date('d-m-Y', strtotime($value_d['booking_date']));
			} else {
				$close = '';
			}
			$awb = $value_d['pod_no'];
			$value = $this->db->query("select tbl_domestic_invoice_detail.*,tbl_domestic_invoice.* from tbl_domestic_booking join tbl_domestic_invoice_detail on tbl_domestic_invoice_detail.pod_no = tbl_domestic_booking.pod_no join tbl_domestic_invoice on tbl_domestic_invoice.id = tbl_domestic_invoice_detail.invoice_id  where tbl_domestic_booking.pod_no = '$awb' and tbl_domestic_booking.dispatch_details='CASH'")->row();
			$menifest_coloader = $this->db->query("select tbl_domestic_menifiest.* from tbl_domestic_bag  join tbl_domestic_menifiest on tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id where pod_no = '$awb' order by id desc")->row();


			if ($this->session->userdata("userType") == 22 or $this->session->userdata("userType") == 10 or $this->session->userdata("userType") == 11 or $this->session->userdata("userType") == 15) {

				$row = array(
					$i,

					date('d-m-Y', strtotime($value_d['booking_date'])),
					$value_d['pod_no'],
					$mode_d_name->mode_name,
					$value_d['risk_type'],
					$booking_d_name->branch_name,
					$value_d['reciever_city'],
					$value_d['cid'],
					$value_d['customer_name'],
					$sale_person_name,
					$sales_branch_name,
					$sender_c->city,
					$value_d['sender_name'],
					$value_d['reciever_name'],
					$value_d['reciever_pincode'],
					$value_d['no_of_pack'],
					($actual_weight->actual_weight),
					($value_d['chargable_weight']),
					$value_d['invoice_no'],
					$value_d['invoice_value'],
					$value_d['dispatch_details'],
					$value_d['status'],
					// $booking_d_name->branch_name,
					// $booking_d_name->tracking_date,
					$last_branch,
					$last_scan->tracking_date,
					$tat,
					// $delivery_date1,
					$value_d['delivery_date'],

					$booking_d_tracking->tracking_date,
					$value_d['comment'],
					$rto_date,
					$rto_reason,
					// $booking_table->sub_total,
					$pod_status,
					$date_time_pod,
					@$getfranchise['cid'],
					@$getfranchise['customer_name'],
					@$getMasterfranchise['customer_name'],
					$booking_table->eway_no,
					$booking_table->eway_expiry_date,
					$trakingp,
					$branch_pickup,
					@$transit->tracking_date,
					@$delivery->tracking_date,
					@$outForDelivery['tracking_date'],
					@$outForDelivery['branch_name'],
					@$regular_oda,
					// @$value_d['frieht'],
					// @$value_d['transportation_charges'],
					// @$value_d['pickup_charges'],
					// @$value_d['delivery_charges'],
					// @$value_d['insurance_charges'],
					// @$value_d['courier_charges'],
					// @$value_d['awb_charges'],
					// @$value_d['other_charges'],
					// @$value_d['green_tax'],
					// @$value_d['appt_charges'],
					// @$value_d['fov_charges'],
					// @$value_d['total_amount'],
					// @$value_d['fuel_subcharges'],
					// @$value_d['sub_total'],
					@$value_d['prq_no'],
					@$value_d['create_date'],
					@$value_d['pickup_date'],
					$close,
					@$value_d['instruction'],
					$value->invoice_number,
					$value->invoice_date,
					$value->payment_type,
					@$value_d['ref_no'],
					$menifest_coloader->coloader,
					$menifest_coloader->cd_no,
					$menifest_coloader->cd_no_edited_date,
					$menifest_coloader->cd_recived_date,
					@$value_d['special_instruction'],
					@$value_d['type_shipment']
				);
			} else {
				$row = array(
					$i,

					date('d-m-Y', strtotime($value_d['booking_date'])),
					$value_d['pod_no'],
					$mode_d_name->mode_name,
					$value_d['risk_type'],
					$booking_d_name->branch_name,
					$value_d['reciever_city'],
					$value_d['cid'],
					$value_d['customer_name'],
					$sale_person_name,
					$sales_branch_name,
					$sender_c->city,
					$value_d['sender_name'],
					$value_d['reciever_name'],
					$value_d['reciever_pincode'],
					$value_d['no_of_pack'],
					($actual_weight->actual_weight),
					($value_d['chargable_weight']),
					$value_d['invoice_no'],
					$value_d['invoice_value'],
					$value_d['dispatch_details'],
					$value_d['status'],
					// $booking_d_name->branch_name,
					// $booking_d_name->tracking_date,
					$last_branch,
					$last_scan->tracking_date,
					$tat,
					// $delivery_date1,
					$value_d['delivery_date'],
					// "",

					$booking_d_tracking->tracking_date,
					$value_d['comment'],
					$rto_date,
					$rto_reason,
					$booking_table->sub_total,
					$pod_status,
					$date_time_pod,
					@$getfranchise['cid'],
					@$getfranchise['customer_name'],
					@$getMasterfranchise['customer_name'],
					$booking_table->eway_no,
					$booking_table->eway_expiry_date,
					$trakingp,
					$branch_pickup,
					@$transit->tracking_date,
					@$delivery->tracking_date,
					@$outForDelivery['tracking_date'],
					@$outForDelivery['branch_name'],
					@$regular_oda,
					@$value_d['frieht'],
					@$value_d['transportation_charges'],
					@$value_d['pickup_charges'],
					@$value_d['delivery_charges'],
					@$value_d['insurance_charges'],
					@$value_d['courier_charges'],
					@$value_d['awb_charges'],
					@$value_d['other_charges'],
					@$value_d['green_tax'],
					@$value_d['appt_charges'],
					@$value_d['fov_charges'],
					@$value_d['total_amount'],
					@$value_d['fuel_subcharges'],
					@$value_d['sub_total'],
					@$value_d['prq_no'],
					@$value_d['create_date'],
					@$value_d['pickup_date'],
					$close,
					@$value_d['instruction'],
					$value->invoice_number,
					$value->invoice_date,
					$value->payment_type,
					@$value_d['ref_no'],
					$menifest_coloader->coloader,
					$menifest_coloader->cd_no,
					$menifest_coloader->cd_no_edited_date,
					$menifest_coloader->cd_recived_date,
					@$value_d['special_instruction'],
					@$value_d['type_shipment']
				);

			}
			$i++;
			fputcsv($fp, $row);
		}
		exit;
	}

	public function download_mis_report03may2022($where_d, $where_i)
	{

		$date = date('d-m-Y');
		$filename = "Mis_report_" . $date . ".csv";
		$fp = fopen('php://output', 'w');
		$tat = '';


		$header = array("SrNo", "Date", "AWB", "Network", "Type", "ForwordingNo", "Destination", "Customer", "Receiver", "Receiver Addr", "Receiver Pincode", "Weight", "Bill Type", "NOP", "Status", "Delivery Date", "EDD", "TAT", "Deliverd TO", "RTO Date", "RTO Reason", "Branch");

		$international_allpoddata = $this->Generate_pod_model->get_international_tracking_data($where_i, "", "");
		$domestic_allpoddata = $this->Generate_pod_model->get_domestic_tracking_data($where_d, "", "");

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($domestic_allpoddata as $value_d) {
			$tat = 0;
			$rto_reason = '';
			$rto_date = '';
			$delivery_date = '';
			if ($value_d['status'] == 'RTO') {
				$rto_reason = $value_d['comment'];
				$rto_date = $value_d['tracking_date'];
				$value_d['status'] = $value_d['status'];
			}

			if ($value_d['is_delhivery_complete'] == '1') {
				$delivery_date = $value_d['tracking_date'];
				$value_d['status'] = 'Delivered';

				$booking_date = $start = date('d-m-Y', strtotime($value_d['booking_date']));
				$start = date('d-m-Y', strtotime($value_d['booking_date']));
				$end = date('d-m-Y', strtotime($value_d['tracking_date']));
				$tat = ceil(abs(strtotime($start) - strtotime($end)) / 86400);
			}

			if ($value_d['status'] == 'shifted') {
				$value_d['status'] = 'Intransit';
			}

			$row = array($i, date('d-m-Y', strtotime($value_d['booking_date'])), $value_d['pod_no'], $value_d['forworder_name'], $value_d['company_type'], $value_d['forwording_no'], $value_d['city'], $value_d['sender_name'], $value_d['reciever_name'], $value_d['reciever_address'], $value_d['reciever_pincode'], ($value_d['chargable_weight']), $value_d['dispatch_details'], $value_d['no_of_pack'], $value_d['status'], $delivery_date, $value_d['delivery_date'], $tat, $value_d['comment'], $rto_date, $rto_reason, $value_d['branch_name']);

			$i++;
			fputcsv($fp, $row);
		}

		foreach ($international_allpoddata as $value_d) {
			$rto_reason = '';
			$rto_date = '';
			$delivery_date = '';
			if ($value_d['status'] == 'RTO') {
				$rto_reason = $value_d['comment'];
				$rto_date = $value_d['tracking_date'];
				$value_d['status'] = $value_d['status'];
			}

			if ($value_d['is_delhivery_complete'] == '1') {
				$delivery_date = $value_d['tracking_date'];
				$value_d['status'] = 'Delivered';
			}

			if ($value_d['status'] == 'shifted') {
				$value_d['status'] = 'Intransit';
			}

			$row = array($i, date('d-m-Y', strtotime($value_d['booking_date'])), $value_d['pod_no'], $value_d['forworder_name'], $value_d['company_type'], $value_d['forwording_no'], $value_d['country_name'], $value_d['sender_name'], $value_d['reciever_name'], $value_d['reciever_address'], $value_d['reciever_zipcode'], ($value_d['chargable_weight']), $value_d['dispatch_details'], $value_d['no_of_pack'], $value_d['status'], $delivery_date, "", "", $value_d['comment'], $rto_date, $rto_reason, $value_d['branch_name']);

			$i++;
			fputcsv($fp, $row);
		}
		exit;
	}

	public function daily_sales_report()
	{
		$all_data = $this->input->post();
		if (!empty($all_data)) {
			$whr = "1=1";
			$whr_d = "1=1";

			$awb_no = $this->input->post('awb_no');
			if ($awb_no != "") {
				$whr .= " AND tbl_international_booking.pod_no='$awb_no'";
				$whr_d .= " AND tbl_domestic_booking.pod_no='$awb_no'";

			}
			$courier_company = $this->input->post('courier_company');
			if ($courier_company != "ALL") {
				$whr .= " AND tbl_international_booking.courier_company_id='$courier_company'";
				$whr_d .= " AND tbl_domestic_booking.courier_company_id='$courier_company'";
			}
			$bill_type = $this->input->post('bill_type');
			if ($bill_type != "ALL") {
				$whr .= " AND dispatch_details='$bill_type'";
				$whr_d .= " AND dispatch_details='$bill_type'";
			}
			$doc_type = $this->input->post('doc_type');
			if ($doc_type == '1') {
				$sel_doc_type = "Non Document";
			} else if ($doc_type == '0') {
				$sel_doc_type = "Document";
			} else {
				$sel_doc_type = "ALL";
			}

			$customer_id = $this->input->post('customer_id');
			if ($customer_id != "ALL") {
				$whr .= " AND tbl_international_booking.customer_id='$customer_id'";
				$whr_d .= " AND tbl_domestic_booking.customer_id='$customer_id'";
			}

			if ($sel_doc_type != "ALL") {
				$whr .= " AND doc_nondoc='$sel_doc_type'";
				$whr_d .= " AND doc_nondoc='$sel_doc_type'";
			}
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
				$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
				$whr .= " AND booking_date >='$from_date' AND booking_date <='$to_date'";
				$whr_d .= " AND booking_date >='$from_date' AND booking_date <='$to_date'";
			}

			$company_type = $this->input->post('company_type');
			if ($company_type != "ALL") {
				if ($company_type == "International") {

					$data['international_daily_sales_report'] = $this->Booking_model->get_daily_international_sales($whr);
					$data['total_no_of_pack'] = 0;
					$data['total_chargable_weight'] = 0;
					$data['total_grand_total'] = 0;
					foreach ($data['international_daily_sales_report'] as $value) {
						$data['total_no_of_pack'] += $value['no_of_pack'];
						$data['total_chargable_weight'] += $value['chargable_weight'];
						$data['total_grand_total'] += $value['grand_total'];
					}

				} else if ($company_type == "Domestic") {
					$data['domestic_daily_sales_report'] = $this->Booking_model->get_daily_domestic_sales($whr_d);
					$data['total_no_of_pack'] = 0;
					$data['total_chargable_weight'] = 0;
					$data['total_grand_total'] = 0;

					foreach ($data['domestic_daily_sales_report'] as $value_d) {
						$data['total_no_of_pack'] += $value_d['no_of_pack'];
						$data['total_chargable_weight'] += $value_d['chargable_weight'];
						$data['total_grand_total'] += $value_d['grand_total'];
					}
				}
			} else {
				$data['international_daily_sales_report'] = $this->Booking_model->get_daily_international_sales($whr);
				$data['domestic_daily_sales_report'] = $this->Booking_model->get_daily_domestic_sales($whr_d);
				//   echo $this->db->last_query();
				//   exit;
				$data['total_no_of_pack'] = 0;
				$data['total_chargable_weight'] = 0;
				$data['total_grand_total'] = 0;
				foreach ($data['international_daily_sales_report'] as $value) {
					$data['total_no_of_pack'] += $value['no_of_pack'];
					$data['total_chargable_weight'] += $value['chargable_weight'];
					$data['total_grand_total'] += $value['grand_total'];
				}
				foreach ($data['domestic_daily_sales_report'] as $value_d) {
					$data['total_no_of_pack'] += $value_d['no_of_pack'];
					$data['total_chargable_weight'] += $value_d['chargable_weight'];
					$data['total_grand_total'] += $value_d['grand_total'];
				}
			}
		} else {
			//$from_date = "2021-05-05";
			$from_date = date("Y-m-d");
			$to_date = date("Y-m-d");

			$whr = array('booking_date >=' => $from_date, 'booking_date <=' => $to_date);
			$data['international_daily_sales_report'] = $this->Booking_model->get_daily_international_sales($whr);
			$data['domestic_daily_sales_report'] = $this->Booking_model->get_daily_domestic_sales($whr);

			//echo "<pre>";print_r($data['daily_sales_report']);exit;
			$data['total_no_of_pack'] = 0;
			$data['total_chargable_weight'] = 0;
			$data['total_grand_total'] = 0;
			foreach ($data['international_daily_sales_report'] as $key => $value) {
				$data['total_no_of_pack'] += $value['no_of_pack'];
				$data['total_chargable_weight'] += $value['chargable_weight'];
				$data['total_grand_total'] += $value['grand_total'];
			}
			foreach ($data['domestic_daily_sales_report'] as $value_d) {
				$data['total_no_of_pack'] += $value_d['no_of_pack'];
				$data['total_chargable_weight'] += $value_d['chargable_weight'];
				$data['total_grand_total'] += $value_d['grand_total'];
			}
		}
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", "");
		$data['customers_list'] = $this->basic_operation_m->get_all_result("tbl_customers", "");
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', '');
		$this->load->view('admin/report_master/view_daily_sales_report', $data);
	}
	public function international_gst_report()
	{
		$all_data = $this->input->post();
		if (!empty($all_data)) {
			$whr = "";

			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
				$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
				$whr = " invoice_date >='$from_date' AND invoice_date <='$to_date'";
				//$whr_d.=" booking_date >='$from_date' AND booking_date <='$to_date'";
			}
			// 	$company_type = $this->input->post('company_type');
			// 	if($company_type!="ALL")
			// 	{
			// 	    if($company_type=="International"){
			// 	    	$data['international_gst_data'] = $this->Booking_model->get_international_gst_details($whr);	
			// 	    }else if($company_type=="Domestic")
			// 	    {
			// 	    	$data['domestic_gst_data'] = $this->Booking_model->get_domestic_gst_details($whr);	
			// 	    }

			// 	}else{
			$data['international_gst_data'] = $this->Booking_model->get_international_gst_details($whr);
			$data['domestic_gst_data'] = $this->Booking_model->get_domestic_gst_details($whr);
			//   		}

		} else {
			$from_date = date('Y-m-01');
			$to_date = date('Y-m-t');
			$whr = " invoice_date >='$from_date' AND invoice_date <='$to_date'";
			$data['international_gst_data'] = $this->Booking_model->get_international_gst_details($whr);
			//$data['domestic_gst_data'] = $this->Booking_model->get_domestic_gst_details($whr);		
		}
		$data['customers_list'] = $this->basic_operation_m->get_all_result("tbl_customers", "");
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', '');
		$this->load->view('admin/report_master/view_international_gst_report', $data);
	}
	public function domestic_gst_report()
	{
		$all_data = $this->input->post();
		if (!empty($all_data)) {
			$whr = "";

			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
				$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
				$whr = " invoice_date >='$from_date' AND invoice_date <='$to_date'";
				//$whr_d.=" booking_date >='$from_date' AND booking_date <='$to_date'";
			}
			//$data['international_gst_data'] = $this->Booking_model->get_international_gst_details($whr);			
			$data['domestic_gst_data'] = $this->Booking_model->get_domestic_gst_details($whr);


		} else {
			$from_date = date('Y-m-01');
			$to_date = date('Y-m-t');
			$whr = " invoice_date >='$from_date' AND invoice_date <='$to_date'";
			$data['international_gst_data'] = $this->Booking_model->get_international_gst_details($whr);
			$data['domestic_gst_data'] = $this->Booking_model->get_domestic_gst_details($whr);
		}
		$data['customers_list'] = $this->basic_operation_m->get_all_result("tbl_customers", "");
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', '');
		$this->load->view('admin/report_master/view_domestic_gst_report', $data);
	}


	public function international_shipment_report()
	{
		$date = date('d-m-Y');
		$filename = "SipmentDetails_" . $date . ".csv";
		$fp = fopen('php://output', 'w');
		$header = array(
			"SrNo.",
			"Booking Date",
			"ABW No",
			"Sender name",
			"Return Address",
			"Return Pin",
			"Receiver Name",
			"Address",
			"Country",
			"Zipcode",
			"Receiver Contact",
			"Mode",
			"Waybill",
			"ForwordingNo",
			"Forworder",
			"Payment Mode",
			"Package Amount",
			"Product to be Shipped",
			"Chargable Weight",
			"Freight",
			"Transport",
			"Destination",
			"Clearance",
			"ESS",
			"OtherCh",
			"Total",
			"Fuel Surcharge",
			"Sub Total",
			"CGST Tax",
			"SGST Tax",
			"IGST Tax",
			"Grand Total"
		);

		$all_data = $this->input->post();
		if (!empty($all_data)) {
			$whr = "1=1";
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
				$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
				$whr .= " AND booking_date >='$from_date' AND booking_date <='$to_date'";
			}
			$courier_company = $this->input->post('courier_company');
			if ($courier_company != "ALL") {
				$whr .= " AND tbl_international_booking.courier_company_id='$courier_company'";

			}
		} else {
			$whr = "";
		}
		$shipment_data = $this->Booking_model->get_all_pod_data($whr, '');

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;

		foreach ($shipment_data as $row) {
			$i++;

			$whr = array('id' => $row['sender_city']);
			$sender_city_details = $this->basic_operation_m->get_table_row("city", $whr);
			$sender_city = $sender_city_details->city;

			$whr_p = array('id' => $row['payment_method']);
			$payment_method_details = $this->basic_operation_m->get_table_row("payment_method", $whr_p);
			$payment_method = $payment_method_details->method;


			$row = array($i, $row['booking_date'], $row['pod_no'], $row['sender_name'], $row['sender_address'], $row['sender_pincode'], $row['reciever_name'], $row['reciever_address'], $row['country_name'], $row['reciever_zipcode'], $row['reciever_contact'], $row['mode_dispatch'], $row['eway_no'], $row['forwording_no'], $row['forworder_name'], $payment_method, $row['invoice_value'], $row['special_instruction'], $row['chargable_weight'], $row['frieht'], $row['transportation_charges'], $row['destination_charges'], $row['clearance_charges'], $row['ecs'], $row['other_charges'], $row['total_amount'], $row['fuel_subcharges'], $row['sub_total'], $row['cgst'], $row['sgst'], $row['igst'], $row['grand_total']);
			fputcsv($fp, $row);
		}
		exit;
	}
	public function domestic_shipment_report()
	{
		$date = date('d-m-Y');
		$filename = "SipmentDetails_" . $date . ".csv";
		$fp = fopen('php://output', 'w');
		/*$header =array(
					 "SrNo.","Booking Date","ABW No","Sender name","Return Address","Return Pin","Receiver Name","Address","City","State","Country","Pincode","Receiver Contact","Mode","Waybill","ForwordingNo","Forworder","Payment Mode","Package Amount","Product to be Shipped",
					 "Chargable Weight","Freight","Transport","Pickup","RemoteArea","COD","AWB Ch.","OtherCh","Total","Fuel Surcharge","Sub Total","CGST Tax","SGST Tax","IGST Tax","Grand Total"); */

		$header = array("Waybill", "SHIPPER NAME", "Consignee Name", "City", "State", "Country", "Address", "Pincode", "Phone", "Mobile", "Weight", "Payment Mode", "Package Amount", "Cod Amount", "Product to be Shipped", "Shipping Mode", "Return Address", "Return Pin", "fragile_shipment");

		$all_data = $this->input->post();
		if (!empty($all_data)) {
			$whr = "1=1";
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
				$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
				$whr .= " AND booking_date >='$from_date' AND booking_date <='$to_date'";
			}
			$courier_company = $this->input->post('courier_company');
			if ($courier_company != "ALL") {
				$whr .= " AND tbl_domestic_booking.courier_company_id='$courier_company'";
			}
			$mode_name = $this->input->post('mode_name');
			if ($mode_name != "ALL") {
				$whr .= " AND tbl_domestic_booking.mode_dispatch='$mode_name'";
			}
		} else {
			$whr = "";
		}
		$shipment_data = $this->Booking_model->get_all_pod_data_domestic($whr, '');

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($shipment_data as $row) {
			$i++;

			$whr = array('id' => $row['sender_city']);
			$sender_city_details = $this->basic_operation_m->get_table_row("city", $whr);
			$sender_city = $sender_city_details->city;

			$whr_s = array('id' => $row['reciever_state']);
			$reciever_state_details = $this->basic_operation_m->get_table_row("state", $whr_s);
			$reciever_state = $reciever_state_details->state;

			$whr_p = array('id' => $row['payment_method']);
			$payment_method_details = $this->basic_operation_m->get_table_row("payment_method", $whr_p);
			$payment_method = $payment_method_details->method;
			/*$row=array($i,$row['booking_date'],$row['pod_no'],$row['sender_name'],$row['sender_address'],$row['sender_pincode'],$row['reciever_name'],$row['reciever_address'],$row['city'],$reciever_state,'India',$row['reciever_pincode'],$row['reciever_contact'],$row['mode_name'],$row['eway_no'],$row['forwording_no'],$row['forworder_name'],$payment_method,$row['invoice_value'],$row['special_instruction'],$row['chargable_weight'],$row['frieht'],$row['transportation_charges'],$row['pickup_charges'],$row['delivery_charges'],$row['courier_charges'],$row['awb_charges'],$row['other_charges'],$row['total_amount'],$row['fuel_subcharges'],$row['sub_total'],$row['cgst'],$row['sgst'],$row['igst'],$row['grand_total']); */

			$row = array($row['forwording_no'], $row['sender_name'], $row['reciever_name'], $row['city'], $reciever_state, 'India', $row['reciever_address'], $row['reciever_pincode'], " ", $row['reciever_contact'], $row['chargable_weight'], $payment_method, $row['invoice_value'], $row['courier_charges'], $row['special_instruction'], $row['mode_name'], $row['sender_address'], $row['sender_pincode'], " ", $row['pod_no']);


			fputcsv($fp, $row);
		}
		exit;
	}
	public function outstanding_report()
	{
		$all_data = $this->input->post();
		if (!empty($all_data)) {

			$whr = "1=1";
			$whr_d = "1=1";


			$customer_id = $this->input->post('customer_id');
			if ($customer_id != "ALL") {
				$whr .= " AND tbl_international_invoice.customer_id='$customer_id'";
				$whr_d .= " AND tbl_domestic_invoice.customer_id='$customer_id'";
			}
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
				$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
				$whr .= " AND  tbl_international_invoice.invoice_date >='$from_date' AND tbl_international_invoice.invoice_date <='$to_date'";
				$whr_d .= " AND  tbl_domestic_invoice.invoice_date >='$from_date' AND tbl_domestic_invoice.invoice_date <='$to_date'";
			}

			$query_int = "SELECT tbl_international_invoice.invoice_number,tbl_international_invoice.invoice_date,tbl_international_invoice.grand_total,customer_name,gstno,tbl_invoice_receipt.entry_no,tbl_invoice_receipt.reference_no,tbl_invoice_receipt.reference_date,tbl_invoice_receipt.payment_method,reference_amt,tbl_invoice_payments.amount_recieved,discount,tds_amt,reference_mapped_amt FROM tbl_international_invoice LEFT JOIN  tbl_invoice_payments ON  tbl_international_invoice.invoice_number=tbl_invoice_payments.invoice_number LEFT JOIN tbl_invoice_receipt ON tbl_invoice_payments.reference_no=tbl_invoice_receipt.id  WHERE $whr ";

			$data['inv_list_int'] = $this->basic_operation_m->get_query_result_array($query_int);

			$query_dom = "SELECT tbl_domestic_invoice.invoice_number,tbl_domestic_invoice.invoice_date,grand_total,customer_name,gstno,tbl_invoice_receipt.entry_no,tbl_invoice_receipt.reference_no,tbl_invoice_receipt.reference_date,tbl_invoice_receipt.payment_method,reference_amt,tbl_invoice_payments.amount_recieved,discount,tds_amt,reference_mapped_amt FROM tbl_domestic_invoice LEFT JOIN  tbl_invoice_payments ON  tbl_domestic_invoice.invoice_number=tbl_invoice_payments.invoice_number LEFT JOIN tbl_invoice_receipt ON tbl_invoice_payments.reference_no=tbl_invoice_receipt.id  WHERE $whr_d ";
			$data['inv_list_dom'] = $this->basic_operation_m->get_query_result_array($query_dom);

			if (!empty($query_int)) {
				$data['inv_list'] = $data['inv_list_int'];
			}
			if (!empty($query_dom)) {
				$data['inv_list'] = $data['inv_list_dom'];
			}
			if (!empty($query_int) && !empty($query_dom)) {
				$data['inv_list'] = array_merge($data['inv_list_int'], $data['inv_list_dom']);
			}
			//echo "<pre>";
			//print_R($data['inv_list']);
			//exit;
		} else {

		}
		$data['customers_list'] = $this->basic_operation_m->get_all_result("tbl_customers", "");
		$this->load->view('admin/report_master/view_outstanding_report', $data);
	}


	// ===================================================
	// ACCOUNTING MIS REPORT
	public function mis_report_accounting($offset = 0, $searching = '')
	{
		$username = $this->session->userdata("userName");
		$__POST = $_GET;

		$usernamee = $this->input->post("username");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);

		$branch_id = $res->row()->branch_id;
		$filterCond = '';
		$data['international_allpoddata'] = array();
		$data['domestic_allpoddata'] = array();
		$total_domestic_allpoddata = 0;
		$total_international_allpoddata = 0;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$user_id = $this->session->userdata("userId");
		$userType = $this->session->userdata("userType");
		$branch_id = $this->session->userdata("branch_id");
		$all_data = $this->input->get();
		$data['post_data'] = $all_data;

		if (!empty($all_data)) {
			if ($userType != '1' and $userType != '20' and $userType != '22' and $userType != '23') {
				$whr = "tbl_international_booking.branch_id = '$branch_id'";
				$whr_d = "tbl_domestic_booking.branch_id = '$branch_id'";
			} else {
				$whr = '1';
				$whr_d = '1';
			}

			$awb_no = $all_data['awb_no'];
			if ($awb_no != "") {
				$whr .= " AND tbl_international_booking.pod_no='$awb_no'";
				$whr_d .= " AND  tbl_domestic_booking.pod_no='$awb_no'";
			}

			$bill_type = $all_data['bill_type'];
			if ($bill_type != "ALL") {
				$whr .= " AND  dispatch_details='$bill_type'";
				$whr_d .= " AND  dispatch_details='$bill_type'";
			}

			$doc_type = $all_data['doc_type'];
			if ($doc_type == '1') {
				$sel_doc_type = "Non Document";
			} else if ($doc_type == '0') {
				$sel_doc_type = "Document";
			} else {
				$sel_doc_type = "ALL";
			}

			//    $courier_company = $all_data['courier_company'];		
			//    if($courier_company!="ALL")
			// {
			//  			$whr	.=" AND tbl_international_booking.courier_company_id='$courier_company'";
			//  			$whr_d	.=" AND tbl_domestic_booking.courier_company_id='$courier_company'";
			//          }

			$status = $all_data['status'];

			if (($status == 1 || $status == 0) && $status != 'ALL') {

				$whr .= " AND tbl_international_booking.is_delhivery_complete='$status'";
				$whr_d .= " AND tbl_domestic_booking.is_delhivery_complete='$status'";
			} elseif ($status == 2) {
				$whr .= " AND (
					tbl_international_tracking.status = 'RTO' 
					OR tbl_international_tracking.status LIKE '%Return%'
					OR tbl_international_tracking.status = 'Return to Orgin' 
					OR tbl_international_tracking.status = 'Door Close' 
					OR tbl_international_tracking.status = 'Address ok no search person' 
					OR tbl_international_tracking.status = 'Address not found' 
					OR tbl_international_tracking.status = 'No service' 
					OR tbl_international_tracking.status = 'Refuse' 
					OR tbl_international_tracking.status = 'Wrong address' 
					OR tbl_international_tracking.status = 'Person expired' 
					OR tbl_international_tracking.status = 'Lost Intransit' 
					OR tbl_international_tracking.status = 'Not collected by consignee' 
					OR tbl_international_tracking.status = 'Delivery not attempted'

				)";

				$whr_d .= " AND (
					tbl_domestic_tracking.status = 'RTO' 
					OR tbl_domestic_tracking.status LIKE '%Return%'
					OR tbl_domestic_tracking.status = 'Return to Orgin' 
					OR tbl_domestic_tracking.status = 'Door Close' 
					OR tbl_domestic_tracking.status = 'Address ok no search person' 
					OR tbl_domestic_tracking.status = 'Address not found' 
					OR tbl_domestic_tracking.status = 'No service' 
					OR tbl_domestic_tracking.status = 'Refuse'  
					OR tbl_domestic_tracking.status = 'Wrong address' 
					OR tbl_domestic_tracking.status = 'Person expired' 
					OR tbl_domestic_tracking.status = 'Lost Intransit' 
					OR tbl_domestic_tracking.status = 'Not collected by consignee' 
					OR tbl_domestic_tracking.status = 'Delivery not attempted'

				)";
			}

			$customer_id = $all_data['customer_id'];
			if ($customer_id != "ALL") {
				$whr .= " AND tbl_international_booking.customer_id='$customer_id'";
				$whr_d .= " AND tbl_domestic_booking.customer_id='$customer_id'";
			}
			$billed_status = $all_data['billed_status'];
			if ($all_data['billed_status'] !== '') {
				$whr_d .= " AND tbl_domestic_booking.invoice_generated_status='$billed_status'";
			}

			if ($sel_doc_type != "ALL") {
				$whr .= " AND doc_nondoc='$sel_doc_type'";
				$whr_d .= " AND doc_nondoc='$sel_doc_type'";
			}

			$from_date = $all_data['from_date'];
			$to_date = $all_data['to_date'];
			if ($from_date != "" && $to_date != "") {
				$from_date = date("Y-m-d", strtotime($all_data['from_date']));
				$to_date = date("Y-m-d", strtotime($all_data['to_date']));
				$whr .= " AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
				$whr_d .= " AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
			}

			$data['domestic_allpoddata'] = $this->Generate_pod_model->get_domestic_tracking_data($whr_d, "100", $offset);
			// echo $this->db->last_query();die;
			// echo '<pre>';print_r($data['domestic_allpoddata']);
			$filterCond = urldecode($whr_d);
		} else {
			if (!empty($searching)) {
				$filterCond = urldecode($searching);
				$whr = str_replace('domestic', 'international', $filterCond);
				$whr_d = $filterCond;
			} else {
				$from_date = date("Y-m-d");
				$to_date = date("Y-m-d");
				$whr = "";
				$whr_d = "";
			}
		}

		$d_cnt = $this->Generate_pod_model->get_domestic_tracking_data_cnt($whr_d);
		// $d_cnt = $this->tot_cnt_d($whr_d); 
		$this->load->library('pagination');
		$total_count1 = $d_cnt;

		// echo $total_count1;die;


		$data['total_count'] = $total_count1;
		$config['total_rows'] = $total_count1;
		$config['base_url'] = 'admin/list-mis-report-accounts/';
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
			$data['serial_no'] = 0;
		} else {
			$config['uri_segment'] = 3;
			$data['serial_no'] = $offset + 1;
		}

		if (isset($_GET['submit']) && $_GET['submit'] == 'Download Excel') {
			// echo "Exist";exit();

			$this->download_mis_report_accounts($whr_d);
		}

		$this->pagination->initialize($config);
		// echo "<pre>"; print_r($data); die;

		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", "");
		// $data['customers_list']		= $this->basic_operation_m->get_all_result("tbl_customers","");
		$data['customers_list'] = $this->db->query("SELECT * FROM tbl_customers ORDER BY  customer_name ASC")->result_array();
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', '');

		$this->load->view('admin/report_master/view_mis_report_accounting', $data);
	}


	public function cn_gst_report()
	{
		$all_data = $this->input->get();		
		if(!empty($all_data)){
			$whr ="";
			$user_id = $this->input->get('user_id');
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');	
			if($user_id !="")
			{
				$whr=" AND tbl_credit_note_invoice.customer_id ='$user_id'";
			}
			if($from_date!="" && $to_date!="")
			{
			    $from_date = date("Y-m-d",strtotime($this->input->get('from_date')));
			    $to_date = date("Y-m-d",strtotime($this->input->get('to_date')));	
				$whr.=" AND tbl_credit_note_invoice.createDtm >='$from_date' AND tbl_credit_note_invoice.createDtm <='$to_date'";
				//$whr_d.=" booking_date >='$from_date' AND booking_date <='$to_date'";
			}
			
				//$data['international_gst_data'] = $this->Booking_model->get_international_gst_details($whr);			
				$data['gtotal'] =    $resAct = $this->db->query("SELECT SUM(tbl_credit_note_invoice.grand_total) as final_total ,SUM(sub_total) as total, SUM(cgst) as cgst, SUM(sgst) AS sgst,SUM(igst) AS igst  FROM tbl_credit_note_invoice JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE 1 $whr ORDER BY tbl_credit_note_invoice.id DESC")->row_array();	
				$data['domestic_gst_data'] =    $resAct = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_customers.customer_name,tbl_customers.cid,tbl_customers.gstno,tbl_customers.state,state.state as supply , state.statecode as statecode,tbl_domestic_invoice.invoice_number as in_no ,tbl_domestic_invoice.invoice_date as in_date
				 FROM tbl_credit_note_invoice
				 JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id
				 JOIN state ON state.id = tbl_customers.state 
				 JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id 
				  WHERE 1 AND tbl_credit_note_invoice.isdeleted ='0' $whr ORDER BY tbl_credit_note_invoice.id DESC")->result_array();	
    		
			// echo '<pre>';print_r($data['domestic_gst_data']);die;
		}

		if (isset($_GET['download_report']) && $_GET['download_report'] == 'Download Excel') {
			
			$this->download_data($data['domestic_gst_data'],$data['gtotal']);
		}

		$data['customer']= $this->basic_operation_m->get_all_result("tbl_customers","");
		$this->load->view('admin/report_master/view_cn_gst_report',$data);
	}

	public function download_data($shipment_data,$total)
	{

		$date = date('d-m-Y');
		$filename = "Credit_Note_Invoice_Report_" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("SR NO","CN Date", "Credit Note No", "Customer ID", "Customer Name","Customer GST No","Place Of Supply","State Code","Invoice No","Invoice Date", "Total", "CGST", "SGST", "IGST", "Final Amount");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($shipment_data as $row) {
			$i++;
			$roww = array(
				$i,
				date("d-m-Y",strtotime($row['createDtm'])),
				$row['credit_note_no'],
				$row['cid'],
				$row['customer_name'],
				$row['gstno'],
				$row['supply'],
				$row['statecode'],
				$row['in_no'],
				date('d-m-Y',strtotime($row['in_date'])),
				$row['sub_total'],
				$row['cgst'],
				$row['sgst'],
				$row['igst'],
				$row['grand_total']
			);


			fputcsv($fp, $roww);
		}
		  $total = ['Total','','','','','','','','','',$total['total'],$total['cgst'],$total['sgst'],$total['igst'],$total['final_total']];
		  fputcsv($fp, $total);
		exit;
	}

	public function download_mis_report_accounts($where_d)
	{
		// public function download_mis_report_accounts($where_d,$where_i)
		// {  
		$date = date('d-m-Y');
		$filename = "Mis_report_" . $date . ".csv";
		$fp = fopen('php://output', 'w');
		$tat = '';
		if ($this->session->userdata("userType") == 22 or $this->session->userdata("userType") == 10 or $this->session->userdata("userType") == 23) {
			$header = array(
				"SrNo",
				"Booking Date",
				"Customer code",
				"Customer Name",
				"AWB",
				"Mode",
				"Legal Name of Franchise",
				"Consignor Name",
				"Consignee Name",
				"Billing Type",
				"Last Scan Branch",
				"Origin Pincode",
				"Origin City",
				"Origin Branch",
				"Destination Pincode",
				"Destination",
				"Bkg Zone",
				"Delivery Zone",
				"Invoice No",
				"Invoice Date",
				"CN No",
				"CN Date",
				"CN Remarks",
				"CN Amount",
				"Customer Invoice Amount",
				"NOP",
				"AW",
				"Volumnetric weight",
				"CW",
				"Rate Per Kg",
				"Freight",
				"FOV",
				"Handling Charge",
				"Pickup",
				"ODA Charge",
				"Insurance",
				"Appt Ch.",
				"COD",
				"Others",
				"Green Tax",
				"Warehousing",
				"Address Change",
				"Doc Charge",
				"Green Tax",
				"Fuel Charges",
				"Sub Total"
			);
		} else {
			$header = array(
				"SrNo",
				"Booking Date",
				"Customer code",
				"Customer Name",
				"AWB",
				"Mode",
				"Legal Name of Franchise",
				"Consignor Name",
				"Consignee Name",
				"Billing Type",
				"Last Scan Branch",
				"Origin Pincode",
				"Origin City",
				"Origin Branch",
				"Destination Pincode",
				"Destination",
				"Bkg Zone",
				"Delivery Zone",
				"Invoice No",
				"Invoice Date",
				"CN No",
				"CN Date",
				"CN Remarks",
				"CN Amount",
				"Customer Invoice Amount",
				"NOP",
				"AW",
				"Volumnetric weight",
				"CW",
				"Rate Per Kg",
				"Freight",
				"FOV",
				"Handling Charge",
				"Pickup",
				"ODA Charge",
				"Insurance",
				"Appt Ch.",
				"COD",
				"Others",
				"Green Tax",
				"Warehousing",
				"Address Change",
				"Doc Charge",
				"Fuel Charges",
				"Sub Total"
			);
		}
		$domestic_allpoddata = $this->Generate_pod_model->get_domestic_tracking_data($where_d, "", "");
		// echo $this->db->last_query();die;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 1;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		$sup_sub_total = [];
		$sup_fuel_subcharges = [];
		$sup_awb_charges = [];
		$sup_address_change = [];
		$sup_warehousing = [];
		$sup_green_tax = [];
		$sup_other_charges = [];
		$sup_courier_charges = [];
		$sup_other_charges = [];
		$sup_appt_charges = [];
		$sup_insurance_charges = [];
		$sup_delivery_charges = [];
		$sup_pickup_charges = [];
		$sup_transportation_charges = [];
		$sup_fov_charges = [];
		$sup_frieht = [];
		$sup_rate_val = [];
		$sup_chargable_weight = [];
		$sup_valumetric_weight = [];
		$sup_actual_weight = [];
		$sup_invoice_value = [];
		$sup_cn_amount = [];
		$sup_no_of_pack = [];
		foreach ($domestic_allpoddata as $value_d) {
			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');

			$pod = $value_d['pod_no'];
			$customer_id = $value_d['customer_id'];

			$getfranchise = array();
			$getMasterfranchise = array();
			if ($value_d['user_type'] == 2) {
				$getfranchise = $this->db->query("select tbl_customers.customer_name ,cid,tbl_customers.customer_id ,parent_cust_id from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->row_array();
				$getMasterfranchise = $this->db->query("select tbl_customers.customer_name,cid from tbl_customers  where customer_type = '1' and customer_id ='" . $getfranchise['parent_cust_id'] . "'")->row_array();
			}


			//  mode get 
			$mode_d = $value_d['mode_dispatch'];
			$mode_d_name = $this->db->query("select * from transfer_mode where transfer_mode_id = '$mode_d'")->row();
			// //  booking branch 
			$booking_d = $value_d['pod_no'];
			$booking_d_name = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id ASC limit 1")->row();


			$last_scan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id DESC limit 1")->row();
			if ($last_scan->status == 'In transit') {
				$last = $this->db->query("select tbl_domestic_menifiest.source_branch from tbl_domestic_bag JOIN tbl_domestic_menifiest ON tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id where tbl_domestic_bag.pod_no = '$booking_d' order by tbl_domestic_bag.id desc limit 1")->row();
				$last_branch = $last->source_branch;
			} else {
				$last_branch = $last_scan->branch_name;
			}
			//actual_weight 
			$booking_id = $value_d['booking_id'];
			$actual_weight = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row();
			$s_state = $value_d['sender_state'];
			$s_city = $value_d['sender_city'];
			$sender_city  = $this->db->query("select * from city where id = '$s_city'")->row('city');
			if (!empty($s_state) && !empty($s_city)) {

				$sender_zone_data = $this->db->query("SELECT rm.*,rt.* FROM region_master rm LEFT JOIN region_master_details rt ON(rt.regionid = rm.region_id) WHERE rt.state = $s_state AND rt.city = $s_city")->row();
				$sender_zone1 = $this->db->query("SELECT * FROM region_master_details WHERE state = $s_state AND city = $s_city")->row();
				$sender_zone2 = $this->db->query("SELECT * FROM region_master WHERE region_id=' $sender_zone1->regionid'")->row();
				//   echo $this->db->last_query();
				$receiver_zone_id = $this->db->query("SELECT * FROM region_master WHERE region_name = '" . $value_d['receiver_zone'] . "'")->row();

				$cust_data123 = $this->db->query("SELECT * FROM tbl_customers WHERE cid = '" . $value_d['cid'] . "'")->row();
				//   get Invoice and CN data 
				$cn_no = "";
				$cn_date = "";
				$cn_amount = "";
				$cn_remark = "";
				$invoice_no = "";
				$invoice_date = "";
				if($value_d['invoice_generated_status']=='1'){
				//  get CN data
				$invoice = $this->db->query("SELECT * FROM tbl_domestic_invoice_detail JOIN tbl_domestic_invoice  ON tbl_domestic_invoice.id = tbl_domestic_invoice_detail.invoice_id WHERE tbl_domestic_invoice_detail.pod_no = '".$value_d['pod_no']."' AND tbl_domestic_invoice_detail.cn_status = 1")->row();
				
				$invoice_no = $invoice->invoice_number;
				$invoice_date = date('Y-m-d',strtotime($invoice->invoice_date));
				if(!empty($invoice))
				{
				$cn = $this->db->query("SELECT * FROM tbl_credit_note_invoice_details JOIN tbl_credit_note_invoice ON tbl_credit_note_invoice.id = tbl_credit_note_invoice_details.credit_note_id  WHERE tbl_credit_note_invoice_details.pod_no = '".$value_d['pod_no']."' AND tbl_credit_note_invoice_details.isdeleted ='0'")->row();
				$cn_no = $cn->credit_note_no;
				$cn_date = date('Y-m-d',strtotime($cn->createDtm));
				$cn_amount = $cn->amount;
				$cn_remark = $cn->remarks;
				}
				}
				// echo $this->db->last_query();die;
				if (!empty($receiver_zone_id->region_id) && !empty($sender_zone_data->region_id) && !empty($cust_data123->customer_id)) {
					$rate_data = $this->db->query("SELECT * from tbl_domestic_rate_master where from_zone_id = " . $sender_zone_data->region_id . " AND to_zone_id = " . $receiver_zone_id->region_id . " AND customer_id =" . $cust_data123->customer_id)->row();
					$rate_val = round($rate_data->rate);
				} else {
					$rate_val = 0;
				}
				$sender_zone = $sender_zone2->region_name;
			} else {
				$sender_zone = '';
				$rate_val = 0;
			}
			// die;
			if ($this->session->userdata("userType") == 22 or $this->session->userdata("userType") == 10 or $this->session->userdata("userType") == 23) {

				$row = array(
					$i,
					date('d-m-Y', strtotime($value_d['booking_date'])),
					$value_d['cid'],
					$value_d['customer_name'],
					$value_d['pod_no'],
					$mode_d_name->mode_name,
					!empty($getfranchise['customer_name']) ? $getfranchise['customer_name'] : '',
					$value_d['sender_name'],
					$value_d['reciever_name'],
					$value_d['dispatch_details'],
					$last_branch,
					$value_d['sender_pincode'],
					$sender_city,
					$booking_d_name->branch_name,
					$value_d['reciever_pincode'],
					$value_d['reciever_city'],
					$sender_zone,

					$value_d['receiver_zone'],
					$invoice_no,
					$invoice_date,
					$cn_no,
					$cn_date,
					$cn_remark,
					$cn_amount,
					$value_d['invoice_value'],
					$value_d['no_of_pack'],
					($actual_weight->actual_weight),
					$value_d['valumetric_weight'],
					$value_d['chargable_weight'],
					$rate_val,
					$value_d['frieht'],
					$value_d['fov_charges'],
					$value_d['transportation_charges'],
					$value_d['pickup_charges'],
					$value_d['delivery_charges'],
					$value_d['insurance_charges'],
					$value_d['appt_charges'],
					$value_d['courier_charges'],
					$value_d['other_charges'],
					$value_d['green_tax'],
					$value_d['warehousing'],
					$value_d['address_change'],
					$value_d['awb_charges'],
					$value_d['fuel_subcharges'],
					$value_d['sub_total']
				);
				$sup_no_of_pack[] =+ $value_d['no_of_pack'];
				$sup_cn_amount[] =+ $cn_amount;
				$sup_sub_total[] = +$value_d['sub_total'];
				$sup_fuel_subcharges[] = +$value_d['fuel_subcharges'];
				$sup_awb_charges[] = +$value_d['awb_charges'];
				$sup_address_change[] = +$value_d['address_change'];
				$sup_warehousing[] = +$value_d['warehousing'];
				$sup_green_tax[] = +$value_d['green_tax'];
				$sup_courier_charges[] = +$value_d['courier_charges'];
				$sup_other_charges[] = +$value_d['other_charges'];
				$sup_appt_charges[] = +$value_d['appt_charges'];
				$sup_frieht[] = +$value_d['frieht'];
				$sup_insurance_charges[] = +$value_d['insurance_charges'];
				$sup_delivery_charges[] = +$value_d['delivery_charges'];
				$sup_pickup_charges[] = +$value_d['pickup_charges'];
				$sup_transportation_charges[] = +$value_d['transportation_charges'];
				$sup_fov_charges[] = +$value_d['fov_charges'];
				$sup_rate_val[] = +$rate_val;
				$sup_chargable_weight[] = +$value_d['chargable_weight'];
				$sup_valumetric_weight[] = +$value_d['valumetric_weight'];
				$sup_actual_weight[] = +($actual_weight->actual_weight);
				$sup_invoice_value[] = +$value_d['invoice_value'];
			} else {
				$row = array(
					$i,
					date('d-m-Y', strtotime($value_d['booking_date'])),
					$value_d['cid'],
					$value_d['customer_name'],
					$value_d['pod_no'],
					$mode_d_name->mode_name,
					!empty($getfranchise['customer_name']) ? $getfranchise['customer_name'] : '',
					$value_d['sender_name'],
					$value_d['reciever_name'],
					$value_d['dispatch_details'],
					$last_branch,
					$value_d['sender_pincode'],
					$sender_city,
					$booking_d_name->branch_name,
					$value_d['reciever_pincode'],
					$value_d['reciever_city'],
					$sender_zone,
					$value_d['receiver_zone'],
					$invoice_no,
					$invoice_date,
					$cn_no,
					$cn_date,
					$cn_remark,
					$cn_amount,
					$value_d['invoice_value'],
					$value_d['no_of_pack'],
					($actual_weight->actual_weight),
					$value_d['valumetric_weight'],
					$value_d['chargable_weight'],
					round($rate_data->rate),
					$value_d['frieht'],
					$value_d['fov_charges'],
					$value_d['transportation_charges'],
					$value_d['pickup_charges'],
					$value_d['delivery_charges'],
					$value_d['insurance_charges'],
					$value_d['appt_charges'],
					$value_d['courier_charges'],
					$value_d['other_charges'],
					$value_d['green_tax'],
					$value_d['warehousing'],
					$value_d['address_change'],
					$value_d['awb_charges'],
					$value_d['fuel_subcharges'],
					$value_d['sub_total']
				);
				$sup_no_of_pack[] =+ $value_d['no_of_pack'];
				$sup_cn_amount[] =+ $cn_amount;
				$sup_sub_total[] = +$value_d['sub_total'];
				$sup_fuel_subcharges[] = +$value_d['fuel_subcharges'];
				$sup_awb_charges[] = +$value_d['awb_charges'];
				$sup_address_change[] = +$value_d['address_change'];
				$sup_warehousing[] = +$value_d['warehousing'];
				$sup_green_tax[] = +$value_d['green_tax'];
				$sup_courier_charges[] = +$value_d['courier_charges'];
				$sup_other_charges[] = +$value_d['other_charges'];
				$sup_appt_charges[] = +$value_d['appt_charges'];
				$sup_frieht[] = +$value_d['frieht'];
				$sup_insurance_charges[] = +$value_d['insurance_charges'];
				$sup_delivery_charges[] = +$value_d['delivery_charges'];
				$sup_pickup_charges[] = +$value_d['pickup_charges'];
				$sup_transportation_charges[] = +$value_d['transportation_charges'];
				$sup_fov_charges[] = +$value_d['fov_charges'];
				$sup_rate_val[] = +$rate_val;
				$sup_chargable_weight[] = +$value_d['chargable_weight'];
				$sup_valumetric_weight[] = +$value_d['valumetric_weight'];
				$sup_actual_weight[] = +($actual_weight->actual_weight);
				$sup_invoice_value[] = +$value_d['invoice_value'];
			}
			$i++;
			fputcsv($fp, $row);
		}

		if ($this->session->userdata("userType") == 22 or $this->session->userdata("userType") == 10 or $this->session->userdata("userType") == 23) {
			$row = array('Total', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '','','','','',array_sum($sup_cn_amount),array_sum($sup_invoice_value),array_sum($sup_no_of_pack), array_sum($sup_actual_weight), array_sum($sup_chargable_weight), array_sum($sup_valumetric_weight), array_sum($sup_chargable_weight), array_sum($sup_rate_val), array_sum($sup_frieht), array_sum($sup_fov_charges), array_sum($sup_transportation_charges), array_sum($sup_pickup_charges), array_sum($sup_delivery_charges), array_sum($sup_insurance_charges), array_sum($sup_appt_charges), array_sum($sup_courier_charges), array_sum($sup_other_charges), array_sum($sup_green_tax), array_sum($sup_warehousing), array_sum($sup_address_change), array_sum($sup_awb_charges), array_sum($sup_fuel_subcharges), array_sum($sup_sub_total));
			fputcsv($fp, $row);
		} else {
			$row = array('Total', '', '', '', '', '', '', '', '', '', '','', '', '', '', '', '', '','','','','','',array_sum($sup_cn_amount), array_sum($sup_invoice_value),array_sum($sup_no_of_pack), array_sum($sup_actual_weight), array_sum($sup_chargable_weight), array_sum($sup_valumetric_weight), array_sum($sup_chargable_weight), array_sum($sup_rate_val), array_sum($sup_frieht), array_sum($sup_fov_charges), array_sum($sup_transportation_charges), array_sum($sup_pickup_charges), array_sum($sup_delivery_charges), array_sum($sup_insurance_charges), array_sum($sup_appt_charges), array_sum($sup_courier_charges), array_sum($sup_other_charges), array_sum($sup_green_tax), array_sum($sup_warehousing), array_sum($sup_address_change), array_sum($sup_awb_charges), array_sum($sup_fuel_subcharges), array_sum($sup_sub_total));
			fputcsv($fp, $row);
		}
		exit;
	}
	// ===================================================
}



?>