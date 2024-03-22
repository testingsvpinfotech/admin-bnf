<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Authapi extends CI_Controller
{
	public function __construct()
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
		header('P3P: CP="CAO PSA OUR"'); // Makes IE to support cookies
		header("Content-Type: application/json; charset=utf-8");
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('basic_operation_m');
	}

	public function write_request_file()
	{

		$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

		$postdata = file_get_contents("php://input");
		$posr_txt = json_encode($_POST);
		$get_txt = json_encode($_GET);
		$files_txt = json_encode($_FILES);

		$datec = date('Y-m-d H:i:s');

		$method = $this->router->fetch_method();

		$txt = "\n-----------------------------------Time :  " . $datec . " : " . $method . "-----------------------------------------------\n";
		$txt .= "\n-----------------------------------INPUT JSON-----------------------------------------------\n";
		$txt .= $postdata;
		$txt .= "\n-----------------------------------POST-----------------------------------------------\n";
		$txt .= $posr_txt;
		$txt .= "\n-----------------------------------GET-----------------------------------------------\n";
		$txt .= $get_txt;
		$txt .= "\n-----------------------------------FILES-----------------------------------------------\n";
		$txt .= $files_txt;

		// fwrite($myfile, $txt);
		fwrite($myfile, $txt);
		fclose($myfile);
	}

	public function addBusinessDays($startDate, $businessDays, $holidays = [])
	{
		$date = strtotime($startDate);
		$i = 0;

		while ($i < $businessDays) {
			//get number of week day (1-7)
			$day = date('N', $date);
			//get just Y-m-d date
			$dateYmd = date("d-m-Y H:i:s", $date);

			if ($day < 6 && !in_array($dateYmd, $holidays)) {
				$i++;
			}
			$date = strtotime($dateYmd . ' +1 day');
		}

		return date('d-m-Y H:i:s', $date);
	}
	public function getRateMasterDetails($customerId, $senderCity, $receiverCity, $modeDispatch)
	{
		$data = [];
		$customer_name = $customerId;
		$sender_city = $senderCity;
		$receiver_city = $receiverCity;
		$mode_dispatch = ucfirst($modeDispatch);
		// $region_query = $this->db->query("SELECT `state`.`region_id`,`state`.`id`,`state`.`edd_train`,`state`.`edd_air`, `state`.`edd_air` FROM `state` join city ON `city`.`state_id` = `state`.`id` WHERE `city`.`id` = ".$receiver_city); 

		$region_query = $this->db->query("SELECT `tbl_state`.`region_id`,`tbl_state`.`state_id` as id,`tbl_state`.`edd_train`,`tbl_state`.`edd_air`, `tbl_state`.`edd_air` FROM `tbl_state` join city ON `city`.`state_id` = `tbl_state`.`state_id` WHERE `city`.`id` = " . $receiver_city);
		// echo $this->db->last_query();exit();
		if ($region_query->num_rows() > 0) {
			$regionData = $region_query->row();
			$region_id = $regionData->region_id;
			$state_id = $regionData->id;
			$eod = ($mode_dispatch == 'air') ? $regionData->edd_air : $regionData->edd_air;
			$eod = $this->addBusinessDays(date("d-m-Y"), !empty($regionData->eod) ? $regionData->eod : 4);
		}

		if (!empty($region_id)) {
			$data['rate_master'] = new \stdClass();
			$res = $this->db->query("select * from tbl_rate_master where customer_id=" . $customer_name . " AND mode_of_transport='" . $mode_dispatch . "' AND region_id=" . $region_id . " LIMIT 1");
			if ($res->num_rows() > 0) {

				$data['rate_master'] = $res->row();

				// check rate available for state table
				$stateMasterRes = $this->db->query("select * from tbl_rate_state where rate_master_id=" . $data['rate_master']->rate_master_id . " AND state_id =" . $state_id . " LIMIT 1");
				if ($stateMasterRes->num_rows() > 0) {
					$stateMasterData = $stateMasterRes->row();
					$data['rate_master']->rate = $stateMasterData->rate;
				}

				//check rate available for city table
				$cityMasterRes = $this->db->query("select * from tbl_rate_city where rate_master_id=" . $data['rate_master']->rate_master_id . " AND city_id =" . $receiver_city . " LIMIT 1");
				if ($cityMasterRes->num_rows() > 0) {
					$cityMasterData = $cityMasterRes->row();
					$data['rate_master']->rate = $cityMasterData->rate;
				}

				if ($this->input->post('no_of_pack') > 0 && $this->input->post('rate_type') == 'no_of_pack') {
					$rate_master_id = $data['rate_master']->rate_master_id;
					$no_of_pack = $this->input->post('no_of_pack');
					$rate_master_query = $this->db->query("SELECT * FROM `tbl_rate_pack` WHERE rate_master_id = " . $rate_master_id . " AND $no_of_pack BETWEEN `from` AND `to` LIMIT 1");

					if ($rate_master_query->num_rows() > 0) {
						$data['rate_master_pack'] = $rate_master_query->row();
					}
				}
			}
			$data['rate_master']->eod = $eod;
		}
		return $data;
		exit;
	}

	


	// public function addShipment()
	// {

	// 	$postdata = file_get_contents("php://input");
	// 	$postData = json_decode($postdata);
	// 	// echo "<pre>"; print_r($postData); die;
	// 	$this->write_request_file();


		

	// 	$settingData = [];
	// 	$resAct = $this->db->query("select * from setting");
	// 	$setting = $resAct->result();
	// 	foreach ($setting as $value) :
	// 		$settingData[$value->key] = $value->value;
	// 	endforeach;
	// 	// $username =  $postData->user_name;//LU0001
	// 	// $user_id =  $postData->user_id;
	// 	$whr = array('user_id' =>'1');
	// 	$res = $this->basic_operation_m->getAll('tbl_users', $whr);
	// 	// echo $this->db->last_query();
	// 	$uerdata = $res->row();
	// 	// print_r($uerdata); 
	// 	$username = $uerdata->username;
	// 	$branch_id = $uerdata->branch_id;
	// 	$user_id = $uerdata->user_id;
	// 	$user_type = $uerdata->user_type;

	// 	date_default_timezone_set('Asia/Kolkata'); 
	// 	 $booking_date = date("Y-m-d H:i:s"); // time in India
	// 	$date = date('Y-m-d H:i:s', strtotime($booking_date));
    //     // print_r($postData);die;
	// 	if(! empty($postData->sender_pincode)){
	// 		$sender = $this->db->query("select * from pincode where pin_code='$postData->sender_pincode'")->row();
	// 		$sender_zon_id = $this->db->query("select * from region_master_details where state ='$sender->state_id' and city = '$sender->city_id'")->row();
	// 		$sender_zon_id->regionid;
	// 	 }
	// 	 if(! empty($postData->reciever_pincode)){
	// 		$reciever = $this->db->query("select * from pincode where pin_code='$postData->reciever_pincode'")->row();
	// 		$reciever_zon_id = $this->db->query("select * from region_master_details where state ='$reciever->state_id' and city = '$reciever->city_id'")->row();
	// 		$reciever_zon_id->regionid;
	// 		$reciever_zone = $this->db->query("select * from region_master where region_id='$reciever_zon_id->regionid'")->row();
	// 	}
		
    //      if($postData->customer_id !=''){
	// 		$rateData = $this->getRateMasterDetails($postData->customer_id, $sender->city_id, $reciever->city_id, $postData->mode_dispatch);
	// 	 }
    //     //  echo '<pre>';print_r($rateData);die;
		

	// 	if ($postData->doc_type == 0) {
	// 		$doc_nondoc			= 'Document';
	// 	} else {
	// 		$doc_nondoc			= 'Non Document';
	// 	}
	// 	$result 		= $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
	// 	$id 			= $result->id + 1;

	// 	if (strlen($id) == 2) {
	// 		$id = 'C000' . $id;
	// 	} elseif (strlen($id) == 3) {
	// 		$id = 'C100' . $id;
	// 	} elseif (strlen($id) == 1) {
	// 		$id = 'C10000' . $id;
	// 	} elseif (strlen($id) == 4) {
	// 		$id = 'C10' . $id;
	// 	}else{
	// 		$id = 'C1' . $id;
	// 	}
		
		
	// 		$awb_no = $id;
	
         
	// 	$data = array(
	// 		'doc_type' => $postData->doc_type,
	// 		'doc_nondoc' => $doc_nondoc,
	// 		'courier_company_id' => '35',
	// 		'company_type' => 'Domestic',
	// 		'mode_dispatch' => 'CREDIT',
	// 		'pod_no' => $awb_no,
	// 		'forwording_no' => '',
	// 		'forworder_name' => 'SELF',
	// 		'customer_id' => $postData->customer_id,
	// 		'sender_name' => $postData->sender_name,
	// 		'sender_address' => $postData->sender_address,
	// 		'sender_city' => $sender->city_id,
	// 		'sender_state' => $sender->state_id,
	// 		'sender_pincode' => $postData->sender_pincode,
	// 		'sender_contactno' => $postData->sender_contactno,
	// 		'sender_gstno' => $postData->sender_gstno,
	// 		'reciever_name' => $postData->reciever_name,
	// 		'contactperson_name' => $postData->contactperson_name,
	// 		'reciever_address' => $postData->reciever_address,
	// 		'reciever_contact' => $postData->reciever_contact,
	// 		'reciever_pincode' => $postData->reciever_pincode,
	// 		'reciever_city' => $reciever->city_id,
	// 		'reciever_state' => $reciever->state_id,
	// 		'receiver_zone' => $reciever_zone->region_name,
	// 		'receiver_zone_id' => $reciever_zon_id->regionid,
	// 		'receiver_gstno' => $postData->receiver_gstno,
	// 		'ref_no' => '',
	// 		'invoice_no' => $postData->invoice_no,
	// 		'invoice_value' => $postData->invoice_value,
	// 		'eway_no' => $postData->eway_no,
	// 		'risk_type' => 'CUSTOMER',
	// 		'special_instruction' => $postData->special_instruction,
	// 		//'type_of_pack' => $this->input->post('type_of_pack'),
	// 		// 'type_shipment' => $postData->type_shipment,
	// 		'booking_date' => $date,
	// 		'dispatch_details' => 'CREDIT',
	// 		'payment_method' => '',
	// 		'frieht' => '',
	// 		'transportation_charges' => '',
	// 		'pickup_charges' => '',
	// 		'delivery_charges' => '',
	// 		'courier_charges' => '',
	// 		'awb_charges' => '',
	// 		'other_charges' => '',
	// 		'total_amount' => '',
	// 		'fuel_subcharges' => '',
	// 		'sub_total' => '',
	// 		'cgst' => '',
	// 		'sgst' => '',
	// 		'igst' => '',
	// 		'grand_total' => '',
	// 		'user_id' => $user_id,
	// 		'user_type' => $user_type,
	// 		'branch_id' => $branch_id,
	// 		'booking_type' => 1,
	// 	);
	// 	// echo '<pre>';print_r($data);die;
	// 	$whr = array('pod_no' => $awb_no);
	// 	$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
	// 	if ($res->num_rows()) {
	// 		echo json_encode([
	// 			'status' => 'error',
	// 			'message' => "Already Exist " . $awb_no . '<br>'
	// 		]);

	// 		exit;
	// 	} else {
	// 		// echo '<pre>'; print_r($data); die;
	// 		$query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);

	// 		$lastid = $this->db->insert_id();

	// 		if ($postData->valumetric_weight > $postData->chargable_weight) {
	// 			$postData->chargable_weight = $postData->valumetric_weight;
	// 		}

	// 		$data2 = array(
	// 			'booking_id' => $lastid,
	// 			'actual_weight' => $postData->actual_weight,
	// 			'valumetric_weight' => $postData->valumetric_weight,
	// 			'length' => $postData->length,
	// 			'breath' => $postData->breath,
	// 			'height' => $postData->height,
	// 			'chargable_weight' => $postData->chargable_weight,
	// 			'per_box_weight' => $postData->per_box_weight,
	// 			'no_of_pack' => $postData->no_of_pack,
	// 			'actual_weight_detail' => $postData->actual_weight,
	// 			'valumetric_weight_detail' => $postData->valumetric_weight_detail,
	// 			'chargable_weight_detail' => $postData->chargable_weight,
	// 			'length_detail' => $postData->length_detail,
	// 			'breath_detail' => $postData->breath_detail,
	// 			'height_detail' => $postData->height_detail,
	// 			'no_pack_detail' => $postData->no_of_pack,
	// 			'per_box_weight_detail' => $postData->per_box_weight_detail,
	// 		);


	// 		//  echo '<pre>'; print_r($data2); die;
	// 		$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);
	// 		// echo $lastidw = $this->db->insert_id();

	// 		$whr = array('branch_id' => $branch_id);
	// 		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
	// 		$branch_name = $res->row()->branch_name;

	// 		$whr = array('booking_id' => $lastid);
	// 		$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
	// 		$podno = $res->row()->pod_no;
	// 		$customerid = $res->row()->customer_id;
	// 		$data3 = array(
	// 			'id' => '',
	// 			'pod_no' => $podno,
	// 			'status' => 'Booked',
	// 			'branch_name' => $branch_name,
	// 			'tracking_date' => $date,
	// 			'booking_id' => $lastid,
	// 			'forworder_name' => $data['forworder_name'],
	// 			'forwording_no' => $data['forwording_no'],
	// 			'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
	// 			'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
	// 			'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
	// 		);

	// 		$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
	// 		if ($postData->customer_id != "") {
	// 			$whr = array('customer_id' => $customerid);
	// 			$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
	// 			//$email= $res->row()->email;
	// 		}

	// 		$message = 'Your Shipment ' . $podno . ' status:Boked  At Location: ' . $branch_name;
	// 		if ($lastid) {
	// 			echo json_encode([
	// 				'status' => 'success',
	// 				'booking_id' => $lastid,
	// 				'message' => $message,
	// 			]);
	// 			exit;
	// 		} else {
	// 			echo json_encode([
	// 				'status' => 'error',
	// 				'message' => 'Booking not created successfully',
	// 			]);

	// 			exit;
	// 		}
	// 	}
	// }
	public function addShipment()
	{

		$postdata = file_get_contents("php://input");
		$postData = json_decode($postdata);
		// echo "<pre>"; print_r($postData); die;
		$this->write_request_file();


		$settingData = [];
		$resAct = $this->db->query("select * from setting");
		$setting = $resAct->result();
		foreach ($setting as $value) :
			$settingData[$value->key] = $value->value;
		endforeach;
		// $username =  $postData->user_name;//LU0001
		// $user_id =  $postData->user_id;
		$whr = array('user_id' =>'1');
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$uerdata = $res->row();
		// print_r($uerdata); 
		$username = $uerdata->username;
		$branch_id = $uerdata->branch_id;
		$user_id = $uerdata->user_id;
		$user_type = $uerdata->user_type;

		date_default_timezone_set('Asia/Kolkata'); 
		 $booking_date = date("Y-m-d H:i:s"); // time in India
		$date = date('Y-m-d H:i:s', strtotime($booking_date));
        // print_r($postData);die;
		if(! empty($postData->sender_pincode)){
			$sender = $this->db->query("select * from pincode where pin_code='$postData->sender_pincode'")->row();
			$sender_zon_id = $this->db->query("select * from region_master_details where state ='$sender->state_id' and city = '$sender->city_id'")->row();
			$sender_zon_id->regionid;
		 }
		 if(! empty($postData->reciever_pincode)){
			$reciever = $this->db->query("select * from pincode where pin_code='$postData->reciever_pincode'")->row();
			$reciever_zon_id = $this->db->query("select * from region_master_details where state ='$reciever->state_id' and city = '$reciever->city_id'")->row();
			$reciever_zon_id->regionid;
			$reciever_zone = $this->db->query("select * from region_master where region_id='$reciever_zon_id->regionid'")->row();
		}
		$whrt = array('cid' =>$postData->customer_id);
		$rest = $this->basic_operation_m->getAll('tbl_customers', $whrt);
		$customerId = $rest->row('customer_id');
		$customerName = $rest->row('customer_name');
		$customerAddress = $rest->row('address');


         if($customerId !=''){
			$rateData = $this->getRateMasterDetails($customerId, $sender->city_id, $reciever->city_id, $postData->mode_dispatch);
		 }
         if($customerId !=''){
			$rate = $this->getMasterRates($customerId,$postData->mode_dispatch, $date,$postData->mode_dispatch,$postData->no_of_pack,$postData->chargable_weight,$postData->receiver_gstno,$postData->invoice_value,'0',$sender->state_id,$sender->city_id,$reciever->state_id,$reciever->city_id);
		 }
		//  $customer_id,$mode_id,$booking_date,$dispatch_details,$packet,$chargable_weight,$receiver_gstno,$invoice_value,$is_appointment,$sender_state,$sender_city,$reciver_state,$reciver_city
        //  echo '<pre>';print_r($rate);die;
		

		if (0 == 0) {
			$doc_nondoc			= 'Document';
		} else {
			$doc_nondoc			= 'Non Document';
		}
		$result 		= $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
		$id 			= $result->id + 1;

		// if (strlen($id) == 2) {
		// 	$id = 'C000' . $id;
		// } elseif (strlen($id) == 3) {
		// 	$id = 'C100' . $id;
		// } elseif (strlen($id) == 1) {
		// 	$id = 'C10000' . $id;
		// } elseif (strlen($id) == 4) {
		// 	$id = 'C10' . $id;
		// } elseif (strlen($id) == 5) {
		// 	$id = 'C1' . $id;
		// }
		
		
		// 	$awb_no = $id;
		  if(empty($postData->awn))
		  {
			$id = 501000001 + $id;
			$pod_no = trim($this->input->post('awn'));
			if ($pod_no != "") {
				$awb_no = $pod_no;
			} else {
				$awb_no = $id;
			}
		}
		else
		{
			$awb_no = $postData->awn;
		}
		$data = array(
			'doc_type' => 1,
			'doc_nondoc' => $doc_nondoc,
			'courier_company_id' => '35',
			'company_type' => 'Domestic',
			'mode_dispatch' => $postData->mode_dispatch,
			'pod_no' => $awb_no,
			'forwording_no' => '',
			'forworder_name' => 'SELF',
			'customer_id' => $customerId,
			'sender_name' => $customerName,
			'sender_address' => $customerAddress,
			'sender_city' => $sender->city_id,
			'sender_state' => $sender->state_id,
			'sender_pincode' => $postData->sender_pincode,
			'sender_contactno' => $postData->sender_contactno,
			'sender_gstno' => $postData->sender_gstno,
			'reciever_name' => $postData->reciever_name,
			'contactperson_name' => $postData->contactperson_name,
			'reciever_address' => $postData->reciever_address,
			'reciever_contact' => $postData->reciever_contact,
			'reciever_pincode' => $postData->reciever_pincode,
			'reciever_city' => $reciever->city_id,
			'reciever_state' => $reciever->state_id,
			'receiver_zone' => $reciever_zone->region_name,
			'receiver_zone_id' => $reciever_zon_id->regionid,
			'receiver_gstno' => $postData->receiver_gstno,
			'ref_no' => '',
			'delivery_date'=>$rate['tat_date'],
			'invoice_no' => $postData->invoice_no,
			'invoice_value' => $postData->invoice_value,
			'eway_no' => $postData->eway_no,
			'risk_type' => 'CUSTOMER',
			'special_instruction' => $postData->special_instruction,
			//'type_of_pack' => $this->input->post('type_of_pack'),
			'type_shipment' => 'Carton',
			'booking_date' => $date,
			'dispatch_details' => 'CREDIT',
			'payment_method' => '',
			'frieht' => $rate['frieht'],
			'transportation_charges' => '0',
			'pickup_charges' => '0',
			'delivery_charges' => '0',
			'courier_charges' => '0',
			'other_charges' => '0',
			'awb_charges' => $rate['docket_charge'],
			'fov_charges' => $rate['fov'],
			'total_amount' => $rate['amount'],
			'fuel_subcharges' => $rate['final_fuel_charges'],
			'sub_total' => $rate['sub_total'],
			'cgst' => $rate['cgst'],
			'sgst' => $rate['sgst'],
			'igst' => $rate['igst'],
			'grand_total' => $rate['grand_total'],
			'user_id' => $user_id,
			'user_type' => $user_type,
			'branch_id' => $branch_id,
			'booking_type' => 1,
		);
		// echo '<pre>';print_r($data);die;
		$whr = array('pod_no' => $awb_no);
		$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
		if ($res->num_rows()) {
			echo json_encode([
				'status' => 'error',
				'message' => "Already Exist " . $awb_no . '<br>'
			]);

			exit;
		} else {
			// echo '<pre>'; print_r($data); die;
			$query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);

			$lastid = $this->db->insert_id();
			$whrf = array('customer_id' =>$customerId);
			$resf = $this->basic_operation_m->getAll('courier_fuel', $whrf);
			$cft = $resf->row('cft');
			$valumetric_weight = (((0 * 0 * 0) / 27000) * $cft) * $postData->no_of_pack;
			// print_r($valumetric_weight);die;
			if ($valumetric_weight > $postData->chargable_weight) {
				$postData->chargable_weight = $postData->valumetric_weight;
			}
			
            
			$data2 = array(
				'booking_id' => $lastid,
				'actual_weight' => $postData->actual_weight,
				'valumetric_weight' => $postData->valumetric_weight,
				'length' => 0,
				'breath' => 0,
				'height' => 0,
				'chargable_weight' => $postData->chargable_weight,
				'per_box_weight' => $postData->actual_weight,
				'no_of_pack' => $postData->no_of_pack,
				'actual_weight_detail' => !empty(json_encode([$postData->actual_weight]))?json_encode([$postData->actual_weight]):'0',
				'valumetric_weight_detail' => json_encode([$valumetric_weight]),
				'chargable_weight_detail' => json_encode([$postData->chargable_weight]),
				'breath_detail' => json_encode([0]),
				'height_detail' => json_encode([0]),				
				'length_detail' => json_encode([0]),
				'no_pack_detail' => json_encode([$postData->no_of_pack]),
				'per_box_weight_detail' =>json_encode([$postData->actual_weight]),
			);

			
			//  echo '<pre>'; print_r($data2); die;
			$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);
			// echo $lastidw = $this->db->insert_id();

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
				'tracking_date' => $date,
				'booking_id' => $lastid,
				'forworder_name' => $data['forworder_name'],
				'forwording_no' => $data['forwording_no'],
				'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
				'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
				'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
			);

			$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
			if ($customerId != "") {
				$whr = array('customer_id' => $customerid);
				$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
				//$email= $res->row()->email;
			}

			$message = 'Your Shipment ' . $podno . ' status:Boked  At Location: ' . $branch_name;
			if ($lastid) {
				echo json_encode([
					'status' => 'success',
					'pod_no' => $awb_no,
					'message' => $message,
				]);
				exit;
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Booking not created successfully',
				]);

				exit;
			}
		}
	}

	public function getMasterRates($customer_id,$mode_id,$booking_date,$dispatch_details,$packet,$chargable_weight,$receiver_gstno,$invoice_value,$is_appointment,$sender_state,$sender_city,$reciver_state,$reciver_city)
	{
		// $postdata = file_get_contents("php://input");
		// $request = json_decode($postdata);

		// $dispatch_details = $request->dispatch_details;
		// $reciver_city = $request->reciver_city;
		// $reciver_state = $request->reciver_state;
		// $sender_state = $request->sender_state;
		// $sender_city = $request->sender_city;
		// $is_appointment = $request->is_appointment;
		// $packet = $request->no_of_pack;
		// $customer_id = $request->customer_id;
		// $mode_id = $request->mode_id;
		// $chargable_weight = $request->chargable_weight;
		// $receiver_gstno = $request->receiver_gstno;
		// $booking_date = $request->booking_date;
		// $invoice_value = $request->invoice_value;

		$sub_total = 0;
		
		$c_courier_id = 35;
	
		$current_date = date("Y-m-d", strtotime($booking_date));
		$doc_type = 1;
		
		$whr1 = array('state' => $sender_state, 'city' => $sender_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);
		$whr2 = array('state' => $reciver_state, 'city' => $reciver_city);
		$res2 = $this->basic_operation_m->selectRecord('region_master_details', $whr2);
	
		$sender_zone_id = $res1->row()->regionid;
		$reciver_zone_id = $res2->row()->regionid;
		// print_r($reciver_zone_id);die;
		$chargable_weight_input = $chargable_weight;
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
			AND (from_city_id=" . $sender_city . " OR  from_city_id=0)
			AND (from_state_id=" . $sender_state . " OR from_state_id=0)
			AND (city_id=" . $reciver_city . " OR  city_id=0)
			AND (state_id=" . $reciver_state . " OR state_id=0)
			AND (mode_id=" . $mode_id . " OR mode_id=0)
			AND DATE(`applicable_from`)<='" . $current_date . "'
			AND DATE(`applicable_to`)>='" . $current_date . "'
			AND (" .$chargable_weight_input . "
			BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");

		$frieht = 0;
		$minimum_rate = 0;
		$query = $this->db->last_query(); //die;
		// echo $this->db->last_query();die;
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
				if ($values->fixed_perkg == 4 && ($chargable_weight_input >= $values->weight_range_from && $chargable_weight_input<= $values->weight_range_to)) // 1000 gm slab
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
					$fixed_per_kg_1000 = floatval($total_slab) * floatval($values->rate);

					$left_weight = $left_weight - $slab_weight;
				}

				if ($values->fixed_perkg == 5) // Box Fixed slab
				{

					$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
					$total_slab = $slab_weight / 250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if ($values->fixed_perkg == 6) // 1000 gm slab
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

		$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000 + $drum_perkg;
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
			// print_r($fov);exit();

			if ($dispatch_details != 'Cash' && $dispatch_details != 'COD') {
				$res1->cod = 0;
			}
			$appt_charges = 0;
			if ($is_appointment == 1) {
				// $res1->appointment_perkg 
				$appt_charges = ($res1->appointment_perkg * $chargable_weight_input);

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
			// print_r($invoice_value);
			// print_r($fov);exit();

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
				$amount = (float)$amount + (float)$fov + (float)$docket_charge + (float)$res1->cod + (float)$res1->to_pay_charges + (float)$appt_charges;
			} else {
				$amount = (float)$amount + (float)$fov + (float)$docket_charge + (float)$res1->cod + (float)$res1->to_pay_charges + (float)$appt_charges;
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

			$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");

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
			// 'query'=>$query,
			'sender_zone_id' => $sender_zone_id,
			'tat_date' => $tat_date,
			'reciver_zone_id' => $reciver_zone_id,
			'chargable_weight' => ceil($chargable_weight),
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
		return $data;
		exit;
	}
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
		$packet = $this->input->post('packet');		
		// $invoice_value = $this->input->post('invoice_value');
		// print_r($_POST);		die;
		
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
		$fixed_perkg		= 0;
		$addtional_250		= 0;
		$addtional_500		= 0;
		$addtional_1000		= 0;
		$fixed_per_kg_1000		= 0;
		$tat					= 0;
		$drum_perkg = 0;
		
		$where					= "from_zone_id='".$sender_zone_id."' AND to_zone_id='".$reciver_zone_id."'";

		$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
			(customer_id=".$customer_id." OR  customer_id=0)
			AND from_zone_id=".$sender_zone_id." AND to_zone_id=".$reciver_zone_id."
			AND (city_id=".$reciver_city." OR  city_id=0)
			AND (state_id=".$reciver_state." || state_id=0)
			AND (mode_id=".$mode_id." || mode_id=0)
			AND DATE(`applicable_from`)<='".$current_date."'
			AND (".$this->input->post('chargable_weight')."
			BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");
		
		$frieht=0;
		// echo $this->db->last_query();die;
		// echo "<pre>"; print_r($fixed_perkg_result->num_rows()); die;

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
					
					// $fixed_perkg = 0;
					// $addtional_250 = 0;
					// $addtional_500 = 0;
					// $addtional_1000 = 0;
					// $rate = $values->rate;
					$fixed_perkg =  $values->rate;
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
					$fixed_per_kg_1000 = floatval($total_slab) * floatval($values->rate);

					$left_weight = $left_weight - $slab_weight;
				}

				if($values->fixed_perkg == 5) // Box Fixed slab
				{
					
					$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;
					$total_slab = $slab_weight/250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if($values->fixed_perkg == 6) // 1000 gm slab
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
					$fixed_per_kg_1000 = 0;
					$drum_perkg = $packet * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}

				if($values->fixed_perkg == 7) // Drum fixed slab
				{
					
					$slab_weight = ($values->weight_slab < $left_weight)?$values->weight_slab:$left_weight;
					$total_slab = $slab_weight/250;
					$addtional_250 = $addtional_250 + $total_slab * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
				
				if($values->fixed_perkg == 8) // 1000 gm slab
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
					$fixed_per_kg_1000 = 0;
					$drum_perkg = $packet * $values->rate;
					$left_weight = $left_weight - $slab_weight;
				}
			}

		}
		// print_r($drum_perkg);die;
		
		$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000 + $drum_perkg;
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
	     return $data;
		exit;
	}
	
	public function shipment_tracking()
	{
		$postdata = file_get_contents("php://input");

		// echo $postdata;
		//exit();
		$request = json_decode($postdata);
		// print_r($request);exit();
		$pod_no = $request->airway_number;

		$check_pod_international = $this->db->query("select pod_no from tbl_international_booking where pod_no = '$pod_no'");
		$check_result = $check_pod_international->row();

		if (isset($check_result)) {
			$reAct = $this->db->query("select tbl_international_booking.*,tbl_international_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.country_name as reciever_country_name from tbl_international_booking left join tbl_international_weight_details on tbl_international_booking.booking_id=tbl_international_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_international_booking.sender_city INNER JOIN zone_master recievercity ON recievercity.z_id = tbl_international_booking.reciever_country_id where pod_no = '$pod_no'");
			$data['info'] = $reAct->row();

			if (empty($data['info'])) {
				$data['result'] = "fail";
				$data['message'] = "Airway number not found";
				echo json_encode($data);

				die;
			}

			$courier_company_id = $data['info']->courier_company_id;

			$tracking_href_details = $this->db->query("select * from courier_company where c_id= '$courier_company_id'");
			$data['forwording_track']	=	$tracking_href_details->row();

			$tracking_href_details2 = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'");
			$data['pod_upload']	=	$tracking_href_details2->row();

			if (!empty($data['pod_upload'])) {
				$data['pod_upload'] = base_url('/assets/pod/') . $data['pod_upload']->image;
			} else {
				$data['pod_upload'] = "";
			}


			$reAct = $this->db->query("select * from tbl_international_tracking where pod_no = '$pod_no' ORDER BY id DESC");
			$data['pod']	=	$reAct->result();
			$data['del_status']	=	$reAct->row();
		} else {
			$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where pod_no = '$pod_no'");
			$data['info'] = $reAct->row();
			if (empty($data['info'])) {
				$data['result'] = "fail";
				$data['message'] = "Airway number not found";
				echo json_encode($data);

				die;
			}
			$courier_company_id = $data['info']->courier_company_id;
			$tracking_href_details = $this->db->query("select * from courier_company where c_id= '$courier_company_id'");
			$data['forwording_track']	=	$tracking_href_details->row();


			$tracking_href_details2 = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'");
			$data['pod_upload']	=	$tracking_href_details2->row();

			if (!empty($data['pod_upload'])) {
				$data['pod_upload'] = base_url('/assets/pod/') . $data['pod_upload']->image;
			} else {
				$data['pod_upload'] = "";
			}

			$reAct = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$pod_no' ORDER BY id DESC");
			$data['pod']	=	$reAct->result();
			$data['del_status']	=	$reAct->row();
		}

		if (!empty($data['pod'])) {
			foreach ($data['pod'] as $k => $values) {
				if ($values->status == 'DELIVERED' || $values->status == 'Delivered') {
					$data['delivery_date'] = $values->tracking_date;
				}
			}
		}

		if ($data['pod']) {
			$data['result'] = "success";
		} else {
			$data['result'] = "fail";
			$data['message'] = "Airway number not found";
		}
		echo json_encode($data);

		die;
	}


	
}