<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_PRQ_booking  extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}
	
	public function getwaletamount()
	{
		$waletamount = $this->input->post('customer_name');
		$dd = $this->db->query("select wallet,customer_id  from tbl_customers where customer_id ='$waletamount' AND customer_type = '2'")->row_array();
		//echo $this->db->last_query();
	// print_r($dd);
		echo json_encode($dd);
	}

	public function getpickupconsineeDetails()
	{
		$getpickup_request_id = $this->input->post('pickup_request_id');

		$getPickupdata = $this->db->query("select tbl_pickup_request_data.*,transfer_mode.mode_name,pickup_weight_tbl.destination_pincode,pickup_weight_tbl.actual_weight,pickup_weight_tbl.type_of_package,pickup_weight_tbl.no_of_pack from tbl_pickup_request_data left join pickup_weight_tbl on pickup_weight_tbl.pickup_id = tbl_pickup_request_data.id left join transfer_mode on transfer_mode.transfer_mode_id=tbl_pickup_request_data.mode_id where pickup_request_id = '$getpickup_request_id'")->result();

		echo json_encode($getPickupdata);
	}


    public function prq_booking_list($offset = 0, $searching = '')
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
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
			if (isset($_POST['filter'])) {
				$filter = $_POST['filter'];
				$data['filter']  = $filter;
			}
			if (isset($_POST['courier_company'])) {
				$courier_company = $_POST['courier_company'];
				$data['courier_companyy']  = $courier_company;
			}
			if (isset($_POST['user_id'])) {
				$user_id = $_POST['user_id'];
				$data['user_id']  = $user_id;
			}
			if (isset($_POST['filter_value'])) {
				$filter_value = $_POST['filter_value'];
				$data['filter_value']  = $filter_value;
			}

			$user_id 	= $this->session->userdata("userId");
			$data['customer'] =  $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');

			$user_type 					= $this->session->userdata("userType");
			$filterCond					= '';
			$all_data 					= $this->input->post();

			if ($all_data) {
				$filter_value = 	$_POST['filter_value'];

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
							$city_info					 =  $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
							$filterCond 				.= " AND tbl_domestic_booking.sender_city = '$city_info->id'";
						}
						if ($vall == 'destination') {
							$city_info					 =  $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
							$filterCond 				.= " AND tbl_domestic_booking.reciever_city = '$city_info->id'";
						}
						if ($vall == 'pickup') {

							$filterCond 				.= " AND tbl_domestic_booking.pickup_pending = '1'";
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


			if ($this->session->userdata("userType") == '1') {
				$resActt = $this->db->query("SELECT count(tbl_domestic_booking.booking_id) as cnt FROM tbl_domestic_booking  INNER JOIN tbl_pickup_request_data ON tbl_pickup_request_data.pickup_request_id = tbl_domestic_booking.prq_no WHERE  booking_type = 1 $filterCond ");
				$dd = $resActt->row_array();

				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,tbl_pickup_request_data.pickup_request_id,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking   INNER JOIN tbl_pickup_request_data ON tbl_pickup_request_data.pickup_request_id = tbl_domestic_booking.prq_no JOIN city ON tbl_domestic_booking.reciever_city = city.id  JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",50");
				// echo $this->db->last_query();die();
				$download_query 		= "SELECT tbl_domestic_booking.*,tbl_pickup_request_data.pickup_request_id,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking   INNER JOIN tbl_pickup_request_data ON tbl_pickup_request_data.pickup_request_id = tbl_domestic_booking.prq_no JOIN city ON tbl_domestic_booking.reciever_city = city.id  JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond  GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC";

				$this->load->library('pagination');

				$data['total_count']			= $dd['cnt'];
				$config['total_rows'] 			= $dd['cnt'];
				$config['base_url'] 			= 'admin/prq-booking-list/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] 			= 50;
				$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] 		= '</ul></nav>';
				$config['first_link'] 			= '&laquo; First';
				$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] 		= '</li>';
				$config['last_link'] 			= 'Last &raquo;';
				$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
				$config['last_tag_close'] 		= '</li>';
				$config['next_link'] 			= 'Next';
				$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
				$config['next_tag_close'] 		= '</li>';
				$config['prev_link'] 			= 'Previous';
				$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] 		= '</li>';
				$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] 		= '</a></li>';
				$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
				$config['reuse_query_string'] 	= TRUE;
				$config['num_tag_close'] 		= '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] 			= 3;
					$data['serial_no']				= 1;
				} else {
					$config['uri_segment'] 			= 3;
					$data['serial_no']		= $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {

					$data['allpoddata'] 			= $resAct->result_array();
				} else {
					$data['allpoddata'] 			= array();
				}
			} else {
				//print_r($this->session->all_userdata());
				$branch_id = $this->session->userdata("branch_id");
				$where 		= '';
				// if($this->session->userdata("userType") == '7') 
				if ($this->session->userdata("branch_id") == $branch_id) {

					$username = $this->session->userdata("userName");

					$whr = array('username' => $username);
					// $res = $this->basic_operation_m->getAll('tbl_users', $whr);
					// $branch_id = $res->row()->branch_id;				
					$where = "and tbl_domestic_booking.branch_id='$branch_id' ";
				}

				$resActt = $this->db->query("SELECT count(tbl_domestic_booking.booking_id) as cnt FROM tbl_domestic_booking  inner join tbl_pickup_request_data on tbl_pickup_request_data.pickup_request_id = tbl_domestic_booking.prq_no WHERE booking_type = 1 and tbl_domestic_booking.branch_id='$branch_id' $filterCond ");
				$dd = $resActt->row_array();


				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,tbl_pickup_request_data.pickup_request_id,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking  inner join tbl_pickup_request_data on tbl_pickup_request_data.pickup_request_id = tbl_domestic_booking.prq_no JOIN  city ON tbl_domestic_booking.reciever_city = city.id   JOIN  tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 $where $filterCond  order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",50");
				//echo $this->db->last_query();exit;

				$download_query 		= "SELECT tbl_domestic_booking.*,tbl_pickup_request_data.pickup_request_id,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking JOIN city ON tbl_domestic_booking.reciever_city = city.id inner join tbl_pickup_request_data on tbl_pickup_request_data.pickup_request_id = tbl_domestic_booking.prq_no  JOIN  tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 $where $filterCond  order by tbl_domestic_booking.booking_id DESC ";

				$this->load->library('pagination');

				$data['total_count']			= $dd['cnt'];
				$config['total_rows'] 			= $dd['cnt'];
				$config['base_url'] 			= 'admin/prq-booking-list/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] 			= 50;
				$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] 		= '</ul></nav>';
				$config['first_link'] 			= '&laquo; First';
				$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] 		= '</li>';
				$config['last_link'] 			= 'Last &raquo;';
				$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
				$config['last_tag_close'] 		= '</li>';
				$config['next_link'] 			= 'Next';
				$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
				$config['next_tag_close'] 		= '</li>';
				$config['prev_link'] 			= 'Previous';
				$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] 		= '</li>';
				$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] 		= '</a></li>';
				$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
				$config['reuse_query_string'] 	= TRUE;
				$config['num_tag_close'] 		= '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] 			= 3;
					$data['serial_no']				= 1;
				} else {
					$config['uri_segment'] 			= 3;
					$data['serial_no']		= $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {
					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}
			}

			if (isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report') {
				$resActtt 			= $this->db->query($download_query);
				$shipment_data		= $resActtt->result_array();
				$this->domestic_shipment_report($shipment_data);
			}

			$data['viewVerified'] = 2;
			$whr_c = array('company_type' => 'Domestic');
			$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_c);
			$data['mode_details'] = $this->basic_operation_m->get_all_result("transfer_mode", '');
			$this->load->view('admin/pickup/prq_booking_shipment_list', $data);
		}
	}

	public function domestic_shipment_report($shipment_data)
	{
		$date = date('d-m-Y');
		$filename = "SipmentDetails_" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("PRQ No.", "AWB No.", "Sender", "Receiver", "Receiver City", "Forwording No", "Forworder Name", "Booking date", "Mode", "Pay Mode", "Amount", "Weight", "NOP", "Invoice No", "Invoice Amount", "Branch Name", "User", "Eway No", "Eway Expiry date");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($shipment_data as $row) {
			$i++;
			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			$whr = array('transfer_mode_id' => $row['mode_dispatch']);
			$mode_details = $this->basic_operation_m->get_table_row('transfer_mode', $whr);

			$whr_u = array('branch_id' => $row['branch_id']);
			$branch_details = $this->basic_operation_m->get_table_row('tbl_branch', $whr_u);


			$whr_u = array('user_id' => $row['user_id']);
			$user_details = $this->basic_operation_m->get_table_row('tbl_users', $whr_u);
			$user_details->username = substr($user_details->username, 0, 20);



			$whr = array('id' => $row['sender_city']);
			$sender_city_details = $this->basic_operation_m->get_table_row("city", $whr);
			$sender_city = $sender_city_details->city;

			$whr_s = array('id' => $row['reciever_state']);
			$reciever_state_details = $this->basic_operation_m->get_table_row("state", $whr_s);
			$reciever_state = $reciever_state_details->state;

			$whr_p = array('id' => $row['payment_method']);
			$payment_method_details = $this->basic_operation_m->get_table_row("payment_method", $whr_p);
			$payment_method = $payment_method_details->method;


			$branch_details->branch_name = substr($branch_details->branch_name, 0, 20);
			$row = array(
				$row['pickup_request_id'],
				$row['pod_no'],
				$row['sender_name'],
				$row['reciever_name'],
				$row['city'],
				$row['forwording_no'],
				$row['forworder_name'],
				date('d-m-Y', strtotime($row['booking_date'])),
				$mode_details->mode_name,
				$row['dispatch_details'],
				$row['grand_total'],
				$row['chargable_weight'],
				$row['no_of_pack'],
				$row['invoice_no'],
				$row['invoice_value'],
				$branch_details->branch_name,
				$user_details->username
			);


			fputcsv($fp, $row);
		}
		exit;
	}



	public function booking_prq_data()
	{
		// $data			= $this->data;
		$result 		= $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
		$id 			= $result->id + 1;

		if (strlen($id) == 2) {
			$id = 'BPRQ1000' . $id;
		} elseif (strlen($id) == 3) {
			$id = 'BPRQ100' . $id;
		} elseif (strlen($id) == 1) {
			$id = 'BPRQ10000' . $id;
		} elseif (strlen($id) == 4) {
			$id = 'BPRQ10' . $id;
		} elseif (strlen($id) == 5) {
			$id = 'BPRQ1' . $id;
		}
		$user_type 	= $this->session->userdata("userType");
		$branch_id 	= $this->session->userdata("branch_id");
		if ($user_type == '1') {
			$data['prq_ref_no'] = $this->db->query("Select tbl_pickup_request_data.pickup_request_id,tbl_customers.customer_name from  tbl_pickup_request_data left join tbl_customers on tbl_customers.customer_id = tbl_pickup_request_data.customer_id where pickup_status ='0' OR pickup_status ='2'")->result();
		} else {
			$data['prq_ref_no'] = $this->db->query("Select tbl_pickup_request_data.pickup_request_id,tbl_customers.customer_name from  tbl_pickup_request_data left join tbl_customers on tbl_customers.customer_id = tbl_pickup_request_data.customer_id where tbl_pickup_request_data.branch_id ='$branch_id' AND pickup_status !='1'")->result();
			//echo $this->db->last_query();exit;	
		}
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$data['branch_info']	= $this->basic_operation_m->get_query_row("select * from tbl_branch where branch_id = '$branch_id'");

		$data['transfer_mode']		 	= $this->basic_operation_m->get_query_result('select * from `transfer_mode`');

		$user_id 	= $this->session->userdata("userId");
		$data['cities']	= $this->basic_operation_m->get_all_result('city', '');
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');

		$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', "");
		//$data['payment_method']  = $this->basic_operation_m->get_all_result('payment_method', '');
		$data['region_master'] = $this->basic_operation_m->get_all_result('region_master', '');
		$data['payment_method']  = $this->basic_operation_m->get_all_result('payment_method', '');
		$data['bid'] = $id;
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);
		// $data['content_master'] = $this->basic_operation_m->get_all_result("content_master", array());
		$data['partial_type_tbl'] = $this->basic_operation_m->get_all_result("partial_type_tbl", array());
		$this->load->view('admin/pickup/prq_booking', $data);
	}





	//******************************************************************** Get rate data

	   public function add_new_rate_domestic()
    {
		
        $sub_total 	 = 0;		
		$customer_id = $this->input->post('customer_id');
		$c_courier_id= $this->input->post('c_courier_id');
		$mode_id  = $this->input->post('mode_id');
		$reciver_city	= $this->input->post('city');
		$reciver_state 	= $this->input->post('state');		
		$sender_state 	= $this->input->post('sender_state');		
		$sender_city 	= $this->input->post('sender_city');		
		$is_appointment = $this->input->post('is_appointment');		
		// $invoice_value = $this->input->post('invoice_value');
		// print_r($_POST);		
		
		$whr1 			= array('state' => $sender_state,'city' => $sender_city);
		$res1			= $this->basic_operation_m->selectRecord('region_master_details', $whr1);	
		
		$sender_zone_id 		= $res1->row()->regionid;
		$reciver_zone_id  		= $this->input->post('receiver_zone_id');
		
		$doc_type 		= $this->input->post('doc_type'); 
		$chargable_weight  = $this->input->post('chargable_weight');
		$receiver_gstno =$this->input->post('receiver_gstno');
		$booking_date       = $this->input->post('booking_date');
		$invoice_value       = $this->input->post('invoice_value');
		$dispatch_details       = $this->input->post('dispatch_details');
		$current_date = date("Y-m-d",strtotime($booking_date));
		$chargable_weight	= $chargable_weight * 1000;
		$chargable_weight_data1	= $this->input->post('chargable_weight');
		$fixed_perkg		= 0;
		$addtional_250		= 0;
		$addtional_500		= 0;
		$addtional_1000		= 0;
		$fixed_per_kg_1000		= 0;
		$tat					= 0;
		

		// $fixed_pickup_charges = $this->db->query("SELECT * FROM tbl_pickup_charges WHERE  DATE(`createDtm`)<='" . $current_date . "' AND (" . $this->input->post('chargable_weight') . " BETWEEN weight_from AND weight_to)  ORDER BY createDtm DESC limit 1 ");
		// echo $this->db->last_query();
		// if ($fixed_pickup_charges->num_rows() > 0) {
		// 	$pickup_rate_data = $fixed_pickup_charges->result_array();
			
		// 	foreach($pickup_rate_data as $key => $values){

		// 		 //print_r($values['weight_type']);exit;

		// 		if($values['weight_type'] == 0){

		// 			 $pickup_rate	= $values['rate'];
					
		// 		}
		// 		if($values['weight_type'] == 4){
        //             $per_kg_rate =      round($values['rate']);
		// 			$pr =    $chargable_weight_data1 *  $per_kg_rate;
		// 			$pickup_rate = round($pr);
			
		// 		}

		// 		}
		// }





		
		$where	= "from_zone_id='".$sender_zone_id."' AND to_zone_id='".$reciver_zone_id."'";

		$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
			(customer_id=".$customer_id." OR  customer_id=0)
			AND from_zone_id=".$sender_zone_id." AND to_zone_id=".$reciver_zone_id."
			AND (city_id=".$reciver_city." OR  city_id=0)
			AND (c_courier_id='$c_courier_id.'  || c_courier_id=0 )
			AND (state_id=".$reciver_state." || state_id=0)
			AND (mode_id=".$mode_id." || mode_id=0)
			AND DATE(`applicable_from`)<='".$current_date."'
			AND (".$this->input->post('chargable_weight')."
			BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");
		
		$frieht=0;
		// echo "<pre>"; print_r($fixed_perkg_result->result()); die;
		// echo $this->db->last_query();exit;
		if ($fixed_perkg_result->num_rows() > 0) 
		{
		    
			// echo "4444uuuu<pre>";
			$rate_master  = $fixed_perkg_result->result();
			// print_r($rate_master);exit();
			$weight_range_to	    = round($rate_master[0]->weight_range_to * 1000);
			$left_weight  = ($chargable_weight - $weight_range_to);
			
			foreach($rate_master as $key => $values)
			{
				$tat	= $values->tat;
				if($values->fixed_perkg == 0) // 250 gm slab
				{
					
					$fixed_perkg = $values->rate;
				}
				if($values->fixed_perkg == 1) // 250 gm slab
				{
					
					$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;
					$total_slab = $slab_weight/250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
				
				if($values->fixed_perkg == 2)// 500 gm slab
				{
					$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;
				
					if($slab_weight < 1000)
					{
					    if($slab_weight <= 500)
					    {
					        $slab_weight = 500;
					    }
					    else
					    {
					        $slab_weight = 1000;
					    }
					    
					}
					else
					{
					    $diff_ceil = $slab_weight%1000;
					    $slab_weight = $slab_weight - $diff_ceil;
					
					    if($diff_ceil <= 500 && $diff_ceil != 0)
					    {
					       
					        $slab_weight = $slab_weight + 500;
					    }
					    elseif($diff_ceil <= 1000 && $diff_ceil != 0)
					    {
					       
					        $slab_weight = $slab_weight + 1000;
					    }
					    
					  
					}
			
					$total_slab = $slab_weight/500;
					$addtional_500 = $addtional_500 +$total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				
				}
				
				if($values->fixed_perkg == 3) // 1000 gm slab
				{
					$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
					$total_slab = ceil($slab_weight/1000);
					
					$addtional_1000 = $addtional_1000+ $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
				// echo "hsdskjdhaskjda";exit();
				if($values->fixed_perkg == 4 && ($this->input->post('chargable_weight') >=  $values->weight_range_from && $this->input->post('chargable_weight') <=  $values->weight_range_to)) // 1000 gm slab
				{
					// echo "hsdskjdhaskjda";exit();
					//$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
					$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;	
					$total_slab = ceil($chargable_weight/1000);
					
					$fixed_perkg = 0;
					$addtional_250 = 0;
					$addtional_500 = 0;
					$addtional_1000 = 0;
					$rate= $values->rate;
					// $frieht= $values->rate;
					$fixed_per_kg_1000 = $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
			}
			
		}
		
		
		$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000;
		$amount = $frieht;
		

		//	$whr1 = array('courier_id' => $c_courier_id);
		$whr1 = array('courier_id' => $c_courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => $customer_id);
		$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);
		
		if(empty($res1))
		{
			// echo "hi";
			$whr1 = array('courier_id' => $c_courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => '0');
			$res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$c_courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY courier_id DESC,customer_id DESC,fuel_from   DESC limit 1");

			// echo $this->db->last_query();

			// print_r($res1);exit();
		}

		// echo $this->db->last_query();exit();
		
		if($res1)
		{
			$fuel_per 		= $res1->fuel_price;
			$fov 			= $res1->fov_min;
			$docket_charge 	= $res1->docket_charge;
			$fov_base 	= $res1->fov_base;
			$fov_min 	= $res1->fov_min;

			// echo "<pre>";
			// print_r($res1);exit();
			
			if($dispatch_details != 'Cash' && $dispatch_details != 'COD')
			{
				$res1->cod	= 0;
			}
		    $appt_charges = 0;
			if($is_appointment == 1)
			{
				// $res1->appointment_perkg 
				$appt_charges =  ($res1->appointment_perkg * $this->input->post('chargable_weight'));
				
				if($res1->appointment_min > $appt_charges)
				{
					$appt_charges = $res1->appointment_min;
				}
			}
			// print_r($appt_charges);die;
			
			if($dispatch_details != 'ToPay')
			{
				$res1->to_pay_charges	= 0;
			}

			// if ($fov_base) {
			// 	# code...
			// }
			
			if($invoice_value >= $fov_base )
			{
				$fov = (($invoice_value/100)* $res1->fov_above);
			}
			elseif($invoice_value < $res1->fov_base)
			{
				$fov = (($invoice_value/100)*$res1->fov_below);
			}

			if ($fov < $fov_min) {
				$fov = $fov_min;
			}
			
			if($dispatch_details == 'COD')
			{
				if($res1->cod	!= 0)
				{
					$cod_detail_Range  	= $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN cod_range_from and cod_range_to)");
					//echo $this->db->last_query();exit;
					if(!empty($cod_detail_Range))
					{
						$res1->cod 				=($invoice_value * $cod_detail_Range->cod_range_rate/100);
					}
				}
				
			}
			else
			{
				$res1->cod				= 0;
			}
		
			if($dispatch_details == 'ToPay')
			{
				
				$to_pay_charges_Range  	= $this->basic_operation_m->get_query_row("select * from courier_fuel_detail  where cf_id = '$res1->cf_id' and ('$invoice_value' BETWEEN topay_range_from and topay_range_to)");
				// echo $this->db->last_query();die;
				if(!empty($to_pay_charges_Range))
				{
					$res1->to_pay_charges 				=($invoice_value * $to_pay_charges_Range->topay_range_rate/100);
				}
				// print_r($res1->to_pay_charges);die;
			}
			else
			{
				$res1->to_pay_charges				= 0;
			}

			
			$to_pay_charges = $res1->to_pay_charges;
			
			
			if($res1->fc_type == 'freight')
			{
				$final_fuel_charges =($amount * $fuel_per/100);
				$amount	= $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
			}
			else
			{
				$amount	= $amount + $fov + $docket_charge + $res1->cod + $res1->to_pay_charges + $appt_charges;
				$final_fuel_charges =($amount * $fuel_per/100);
			}
			$cft 			= $res1->cft;
			$cod			= $res1->cod;

			
			
		}
		else
		{
			$cft = '0';
			$cod = '0';
			$fov = '0';
			$to_pay_charges ='0';
			$appt_charges ='0';
			$fuel_per ='0';
			$docket_charge ='0';
			$amount	= $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
			$final_fuel_charges =($amount * $fuel_per/100);
		}
		
		//Cash
		
    
		$sub_total =($amount + $final_fuel_charges);

		$first_two_char = substr($receiver_gstno,0,2);
		
		if($receiver_gstno=="")
		{
		    $first_two_char=27;
		}
		
			$tbl_customers_info 		= $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");
			
			if($tbl_customers_info->gst_charges == 1)
			{
				if($first_two_char==27)
				{
					$cgst = ($sub_total*9/100);
					$sgst = ($sub_total*9/100);
					$igst = 0;
					$grand_total = $sub_total + $cgst + $sgst + $igst;
				}else{
					$cgst = 0;
					$sgst = 0;
					$igst = ($sub_total*18/100);
					$grand_total = $sub_total + $igst;
				}		
			}
			else
			{
				$cgst = 0;
				$sgst = 0;
				$igst = 0;
				$grand_total = $sub_total + $igst;
			}
			
			// if($dispatch_details == 'Cash')
			// {	
			// 	$cgst = 0;
			// 	$sgst = 0;
			// 	$igst = 0;
			// 	$grand_total = $sub_total + $igst;
			// }
			
			
		$query ="select * from tbl_domestic_rate_master where customer_id='".$customer_id."' AND $where  AND ( c_courier_id='".$c_courier_id."' OR c_courier_id=0) AND mode_id='".$mode_id."' AND DATE(`applicable_from`)<='".$current_date."' AND (".$chargable_weight." BETWEEN weight_range_from AND weight_range_to)  ORDER BY applicable_from DESC LIMIT 1";
		
		if($tat > 0)
		{
			$tat_date 		=  date('Y-m-d', strtotime($booking_date. " + $tat days"));
		}
		else
		{
			$tat_date 		=  date('Y-m-d', strtotime($booking_date. " + 5 days"));
		}
		

		$data = array(
			'query'=>$query,
			'sender_zone_id'=>$sender_zone_id,			
			'pickup_rate'=>$pickup_rate,			
			'tat_date'=>$tat_date,			
			'reciver_zone_id'=>$reciver_zone_id,			
			'chargable_weight'=>ceil($chargable_weight),			 	
			'frieht' => round($frieht,2),
			'fov'=>round($fov,2),
			'appt_charges'=>round($appt_charges,2),
			'docket_charge'=>round($docket_charge,2),
			'amount' => round($amount,2),
			'cod' => round($cod,2),
			'cft' => round($cft,2),
			'to_pay_charges' => round($to_pay_charges,2),
			'final_fuel_charges'=>round($final_fuel_charges,2),
			'sub_total'=>number_format($sub_total, 2, '.', ''),
			'cgst'=>number_format($cgst, 2, '.', ''),
			'sgst'=>number_format($sgst, 2, '.', ''),
			'igst'=>number_format($igst, 2, '.', ''),
			'grand_total'=>number_format($grand_total, 2, '.', ''),
		);
		echo json_encode($data);
		exit;
	}


	public function getZone() {
		$reciever_state = $this->input->post('reciever_state');
		$reciever_city =  $this->input->post('reciever_city');

		$whr1 = array('state' => $reciever_state,'city' => $reciever_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);	
		
		$regionid = @$res1->row()->regionid;

		$whr3 = array('region_id' => $regionid);
		$res3 = $this->basic_operation_m->selectRecord('region_master', $whr3);
		$result3 = $res3->row();

		echo json_encode($result3);
		
	}

	public function cashGstCalc(){

		$customer_id = $_REQUEST['customer_id'];
		// $type_of_doc = $_REQUEST['type_of_doc'];
		$sender_gstno = $_REQUEST['sender_gstno'];
		$tbl_customers_info 		= $this->basic_operation_m->get_query_row("select gstno,gst_charges from tbl_customers where customer_id = '$customer_id'");
		$tbl_branch_info 		= $this->basic_operation_m->get_query_row("select * from tbl_branch where branch_id = ".$_SESSION['branch_id']);

		$cgst =0;
		$sgst =0;
		$igst =0;
		$grand_total = $_REQUEST['totalAmount'];

		// if ($type_of_doc=='GSTIN') {
			$gstno = $sender_gstno;
		// }else{
		// 	$gstno = trim($tbl_customers_info->gstno);
		// }
		
		$gst_number = trim($tbl_branch_info->gst_number);

		if (!empty($gstno) && !empty($gst_number)) {
			$arr1 = str_split($gst_number);
			$arr2 = str_split($gstno);

			if ($arr2[0]==$arr1[0] && @$arr2[1]==@$arr1[1]) {
				$cgst = ($sub_total*9/100);
				$sgst = ($sub_total*9/100);
				$igst = 0;
				$grand_total = number_format($grand_total + $cgst + $sgst + $igst , 2, '.', '');
			}else{
				$cgst = 0;
				$sgst = 0;
				$igst = number_format(($grand_total*18/100),2, '.', '');
				
				$grand_total = number_format($grand_total + $igst,2, '.', '');
				// print_r($grand_total);die;
			}
		}else{
			$cgst = 0;
			$sgst = 0;
			$igst = number_format(($grand_total*18/100),2, '.', '');
			// echo "grand_total : ".$grand_total;
			$grand_total = number_format($grand_total + $igst,2, '.', '');
		}
			
		

		echo json_encode(
			array(
				'cgst'=>$cgst,
				'sgst'=>$sgst,
				'igst'=>$igst,
				'grand_total'=>$grand_total
			)
		);
	}



	public function getFuelcharges() 
	{
		$customer_id = $this->input->post('customer_id');
		$dispatch_details = $this->input->post('dispatch_details');
		$courier_id = $this->input->post('courier_id');
		$sub_amount = $this->input->post('sub_amount');
		$booking_date = $this->input->post('booking_date');
		$frieht = $this->input->post('frieht');
		// $amount = $this->input->post('amount');
       

	    $current_date = date("Y-m-d",strtotime($booking_date));
		
		$whr1 = array('courier_id' => $courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => $customer_id);
		$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);
		if(empty($res1))
		{
			$whr1 = array('courier_id' => $courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date,'customer_id =' => '0');
			$res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id') ORDER BY customer_id DESC");
		}
		
		//$whr1 = array('courier_id' => $courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date);
		//$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);
		if($res1){$fuel_per = $res1->fuel_price; }else{$fuel_per ='0';}
		if($res1->fc_type == 'freight')
		{

			$final_fuel_charges =($frieht * $fuel_per/100);
			
		}
		else
		{
			$final_fuel_charges =($sub_amount * $fuel_per/100);
		}

		// $final_fuel_charges =($sub_amount * $fuel_per/100);
	    // print_r($res1->fuel_price);die;
		$sub_total =($sub_amount + $final_fuel_charges);
		 
        
		$gst_details =$this->basic_operation_m->get_query_row('select * from tbl_gst_setting order by id desc limit 1');

            //echo $this->db->last_query();

		if($gst_details){
			$cgst_per = $gst_details->cgst; 
			$sgst_per = $gst_details->sgst; 
			$igst_per = $gst_details->igst; 
		}else{
			$cgst_per = '0'; 
			$sgst_per = '0'; 
			$igst_per = '0'; 
		}    
		
	  
	   
	   $tbl_customers_info 		= $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");
	   ini_set('display_errors', '0');
	   ini_set('display_startup_errors', '0');
	   error_reporting(E_ALL);
		if($tbl_customers_info->gst_charges == 1)
		{
			$cgst = ($sub_total*$cgst_per/100);
			$sgst = ($sub_total*$sgst_per/100);
			$igst = 0;	
		}
		else
		{
			$cgst = 0;
			$sgst = 0;
			$igst = 0;
		}
	
		
		if($dispatch_details == 'Cash' OR $dispatch_details == 'ToPay')
		{	
			$cgst = ($sub_total*$cgst_per/100);
			$sgst = ($sub_total*$sgst_per/100);
			$igst = 0;
		}
	   
	   
	   $grand_total1 = $sub_total + $cgst + $sgst + $igst;
		
       $grand_total = round($grand_total1);
		$result2= array('final_fuel_charges'=>$final_fuel_charges,
						'sub_total'=>number_format($sub_total, 2, '.', ''),
                        'cgst'=>number_format($cgst, 2, '.', ''),
                        'sgst'=>number_format($sgst, 2, '.', ''),
						'igst'=>number_format($igst, 2, '.', ''),
						'grand_total'=>number_format($grand_total, 2, '.', ''),
					);
		echo json_encode($result2);
		
		
	}


	 public function insert_franchise_shipment()
	{
		ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

		$all_Data 	= $this->input->post();
	//	 echo "<pre>";
		//print_r($all_Data);exit();


		if (!empty($all_Data)) {

            $customer_type = $this->input->post("customer_type");
			$customer_id = $this->input->post('customer_account_id');

			$gat_area = $this->db->query("select cmp_area from tbl_franchise where fid = '$customer_id'")->row();
			// $area = $gat_area->cmp_area;
			// $branch_name = $branch . "_" . $area;


			$user_id = $this->session->userdata("userId");
			$user_type = $this->session->userdata("userType");
			$username = $this->session->userdata("userName");
			$branch = $this->session->userdata("branch_name");

			    $balance = $this->db->query("Select * from tbl_customers where customer_id = '$customer_id'")->row();
				$amount = $balance->wallet;
				$update_val = $amount - $this->input->post('grand_total');

			if($customer_type == '2'){

				$balance = $this->db->query("Select * from tbl_customers where customer_id = '$customer_id'")->row();
				$amount = $balance->wallet;
				$update_val = $amount - $this->input->post('grand_total');

				if ($update_val < 0) {
					$msg            = 'You Dont Have sufficient Balance!';
					$class            = 'alert alert-danger alert-dismissible';
					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);


					redirect('admin/view-domestic-shipment');
				}
		    }

			$date = date('Y-m-d', strtotime($this->input->post('booking_date')));
			$this->session->unset_userdata("booking_date");
			$this->session->set_userdata("booking_date", $this->input->post('booking_date'));

			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			;
            $awb = $this->input->post('awn');


			// $branch_id =23;

			if ($all_Data['doc_type'] == 0) {
				$doc_nondoc			= 'Document';
			} else {
				$doc_nondoc			= 'Non Document';
			}


			$pickup_charges =  $this->input->post('pickup_charges');
			if (empty($pickup_charges)) {
				$pickup_charges = 0;
			}
			$green_tax =  $this->input->post('green_tax');
			if (empty($green_tax)) {
				$green_tax = 0;
			}
			$appt_charges =  $this->input->post('appt_charges');
			if (empty($appt_charges)) {
				$appt_charges = 0;
			}
			$insurance_charges =  $this->input->post('insurance_charges');
			if (empty($insurance_charges)) {
				$insurance_charges = 0;
			}
			$transportation_charges =  $this->input->post('transportation_charges');
			if (empty($transportation_charges)) {
				$transportation_charges = 0;
			}
			$other_charges =  $this->input->post('other_charges');
			if (empty($other_charges)) {
				$other_charges = 0;
			}

			if($this->input->post('payment_method') == 0){
				$payment = 0;
			}else{
				$payment =$this->input->post('payment_method');
			}

			$data = array(
				'doc_type' => $this->input->post('doc_type'),
				'doc_nondoc' => $doc_nondoc,
				'courier_company_id' => $this->input->post('courier_company'),
				'company_type' => 'Domestic',
				'mode_dispatch' => $this->input->post('mode_dispatch'),
				'pod_no' => $this->input->post('awn'),
				'prq_no' => $this->input->post('pickup_request_no'),
				'forworder_name' => "SELF",
				'risk_type' => $this->input->post('risk_type'),
				//'customer_id' => $this->input->post('customer_account_id'),
				'customer_id' => $customer_id,
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
				'ref_no' => $this->input->post('ref_no'),
				'invoice_no' => $this->input->post('invoice_no'),
				'invoice_value' => $this->input->post('invoice_value'),
				'eway_no' => $this->input->post('eway_no'),
				'eway_expiry_date' => $this->input->post('eway_expiry_date'),
				'special_instruction' => $this->input->post('special_instruction'),

				'booking_date' => $date,
				'booking_time' => date('H:i:s', strtotime($this->input->post('booking_date'))),
				'dispatch_details' => $this->input->post('dispatch_details'),
				// 'delivery_date' => $this->input->post('delivery_date'),
				'payment_method' => $payment,
				'frieht' => $this->input->post('frieht'),
				'transportation_charges' => $transportation_charges,
				'insurance_charges' => $insurance_charges,
				'pickup_charges' => $pickup_charges,
				'delivery_charges' => $this->input->post('delivery_charges'),
				'courier_charges' => $this->input->post('courier_charges'),
				'awb_charges' => $this->input->post('awb_charges'),
				'other_charges' => $other_charges,
				'total_amount' => $this->input->post('amount'),
				'fuel_subcharges' => $this->input->post('fuel_subcharges'),
				'fov_charges' => $this->input->post('fov_charges'),
				'e_invoice' => $this->input->post('e_invoice'),
				'type_shipment' => $this->input->post('type_shipment'),
				'sub_total' => $this->input->post('sub_total'),
				'cgst' => $this->input->post('cgst'),
				'sgst' => $this->input->post('sgst'),
				'igst' => $this->input->post('igst'),
				'green_tax' => $green_tax,
				'appt_charges' => $appt_charges,
				'grand_total' => $this->input->post('grand_total'),
				'branch_id' => $branch_id,
				'user_id' => $user_id,
				'user_type' => $user_type,
				'booking_type' => 1,
				'adhoc_charges' => json_encode($this->input->post('adhoc_charges')),
				'adhoc_lable' => json_encode($this->input->post('adhoc_lable')),
				'address_change' => $this->input->post('address_change'),
				'dph' => $this->input->post('dph'),
				'warehousing' => $this->input->post('warehousing'),			


			);



		 // echo '<pre>'; print_r($data);exit;

			$result = $this->db->insert('tbl_domestic_booking', $data);
			//echo $this->db->last_query();exit;
			 
			$all_Data = $this->input->post();


			$lastid = $this->db->insert_id();
			if (empty($lastid)) {

				$data['error'][] = "Already Exist " . $this->input->post('awn') . '<br>';
			} else {
				$lastid = $this->db->insert_id();


				// echo "<pre>";

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

				 	// echo "<pre>";print_r($data2);
				// 	exit();

				$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);
				// echo $this->db->last_query();exit;
				$username = $this->session->userdata("customer_id");
				// $whr = array('customer_id' => $username);
				// $res = $this->basic_operation_m->getAll('tbl_customers', $whr);
				// $branch_id = $res->row()->city;

				// $whr = array('id' => $branch_id);
				// $res = $this->basic_operation_m->getAll('city', $whr);
				// $branch_name = $res->row()->city;
				//	print_r($branch_id);die;



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
					$customerid= $res->row()->customer_id;


				$data3 = array(
					'id' => '',
					'pod_no' => $podno,
					'status' => 'Booked',
					'branch_name' => $branch_name,
					'tracking_date' => $this->input->post('booking_date'),
					'booking_id' => $lastid,
					'forworder_name' => $data['forworder_name'],
					'forwording_no' => $data['forwording_no'],
					'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
					'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
					'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
				);
				
				$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
					// echo $this->db->last_query();die;
				if ($this->input->post('customer_account_id') != "") {
					$whr = array('customer_id' => $customerid);
					$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
					$email = $res->row()->email;
				}

				// add stock menagemnet
				$stock = array(
					'delivery_branch'=>$this->input->post('final_branch_id'),
					'destination_pincode'=>$this->input->post('reciever_pincode'),
					'current_branch'=>$branch_id,
					'pod_no'=>$podno,
					'booking_id'=>$lastid,
					'booked'=> '1'
				);
				$this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);
				// $msg='Your Shipment '.$podno.' status:Boked  At Location: '.$branch_name;
			}

			if (!empty($stock)) {

				$whr = array('booking_id' => $lastid);
				$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
					$podno = $res->row()->pod_no;


				$query = "SELECT MAX(topup_balance_id) as id FROM franchise_topup_balance_tbl ";
				$result1 = $this->basic_operation_m->get_query_row($query);
				$id = $result1->id + 1;
				//print_r($id); exit;

				$franchise_id1 = $balance->franchise_id;
                $payment_mode = 'Debit';
				$bank_name = 'Current';

				if (strlen($id) == 1) {
					$franchise_id = 'BFT100000' . $id;
				} elseif (strlen($id) == 2) {
					$franchise_id = 'BFT10000' . $id;
				} elseif (strlen($id) == 3) {
					$franchise_id = 'BFT1000' . $id;
				} elseif (strlen($id) == 4) {
					$franchise_id = 'BFT100' . $id;
				} elseif (strlen($id) == 5) {
					$franchise_id = 'BFT1000' . $id;
				}

				
				if ($this->input->post('grand_total') != '') {
					//$value = $_SESSION['customer_id'];
					$value = $this->input->post('customer_account_id');
					$g_total = $this->input->post('grand_total');

					$balance = $this->db->query("Select * from tbl_customers where customer_id = '$value'")->row();
					$amount = $balance->wallet;
					$update_val = $amount - $g_total;
					$whr5 = array('customer_id' => $value);
					$data1 = array('wallet' => $update_val);
					$result = $this->basic_operation_m->update('tbl_customers', $data1, $whr5);
				

			
					$franchise_id1 = $balance->cid;

				$data9 = array(

					'franchise_id' =>$franchise_id1,
					'refrence_no'=>$podno,
					'customer_id' =>$value,
					'transaction_id' =>$franchise_id,
					'payment_date' => $date,
					'debit_amount' =>$g_total,
				    'balance_amount' =>$update_val,
					'payment_mode' =>$payment_mode,
					'bank_name' =>$bank_name,
					'status' => 1,
					'debit_by' =>$user_id
				);

				$result =  $this->db->insert('franchise_topup_balance_tbl', $data9);
				// echo $this->db->last_query(); exit;

				}

				
				$msg = 'Your Shipment ' . $podno . ' status:Boked  At Location: ' . $branch_name;
				$class            = 'alert alert-success alert-dismissible';
			} else {
				$msg            = 'Shipment not added successfully';
				$class            = 'alert alert-danger alert-dismissible';
			}
			$this->session->set_flashdata('notify', $msg);
			$this->session->set_flashdata('class', $class);


			redirect('admin/view-domestic-shipment');
		} 
		redirect('admin/view-domestic-shipment');
	}

}	
