<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Mobileapp extends CI_Controller
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



		// exit();



	}

	public function courier_partners()
	{
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);
		echo json_encode($data);
	}
	public function transfer_modes()
	{
		$data['transfer_modes'] = $this->basic_operation_m->get_query_result('SELECT * FROM transfer_mode');
		echo json_encode($data);
	}

	public function bill_types()
	{
		$array = [
			['id' => 'Credit', 'name' => 'Credit'],
			['id' => 'Cash', 'name' => 'Cash'],
			['COD' => 'Cash', 'name' => 'COD'],
			['ToPay' => 'Cash', 'name' => 'ToPay'],
		];

		$data['bill_types'] = $array;
		echo json_encode($data);
	}
	public function product_types()
	{
		$array = [
			['id' => '1', 'name' => 'Non-Doc'],
			['id' => '0', 'name' => 'Doc'],
		];

		$data['product_types'] = $array;
		echo json_encode($data);
	}


	public function get_podMindate()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$data = array();
		$pod = $request['pod_no'];
		$module = $request['module'];
		if($module=='update_status'){
			$drs_date = $this->db->query("SELECT * FROM tbl_domestic_tracking WHERE status = 'Out For Delivery' AND pod_no ='$pod' ORDER BY id DESC LIMIT 1")->row('tracking_date');
			if (!empty($drs_date)) {
				$predate['min_date'] = date('Y-m-d', strtotime($drs_date));
				echo json_encode($predate);
			}
	   }
	   
	   if($module=='pod_upload'){
		$status = $this->db->query("SELECT * FROM tbl_domestic_tracking WHERE status = 'Delivered' AND pod_no ='$pod' ORDER BY id DESC LIMIT 1")->row('tracking_date');
		if(!empty($status))
		{
			$predate['min_date'] = date('Y-m-d', strtotime($status));
			echo json_encode($predate);
		}
		
	   }
	}

	public function get_customers()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$data['customers'] = $this->db->query("select * from tbl_customers  where customer_type !='1' AND customer_type !='2'")->result();
		// if (!empty($branch_id)) {
		// 	$whr = array('branch_id' => $branch_id);

		//$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', $whr);

		// } else {
		// 	$data['customers'] = array();
		// }

		echo json_encode($data);
	}
	public function get_all_cities()
	{
		$data['cities'] = $this->basic_operation_m->get_all_result('city', '');
		echo json_encode($data);
	}
	public function get_all_states()
	{
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');
		echo json_encode($data);
	}

	public function getPincodeInfo()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pincode = $request->pincode;

		$res1 = $this->basic_operation_m->selectRecord('pincode', array('pin_code' => $pincode,'isdeleted'=>0));
		$branch = $this->db->query("select * from tbl_branch_service join tbl_branch on tbl_branch.branch_id = tbl_branch_service.branch_id where tbl_branch_service.pincode ='$pincode'")->row();

		$city_id = @$res1->row()->city_id;
		$isODA = @$res1->row()->isODA;
		if (!empty($branch)) {
			// $whr2 = array('id' => $city_id);
			// $res2 = $this->basic_operation_m->get_table_row('city', $whr2);
			// echo $pincode_city = $res2->id;

			$state_id = $res1->row()->state_id;
			// $whr3 = array('id' => $state_id);
			// $res3 = $this->basic_operation_m->get_table_row('state', $whr3);
			// $pincode_state = $res3->id;

			$reciever_state = $state_id;
			$reciever_city = $city_id;

			$whr1 = array('state' => $reciever_state, 'city' => $reciever_city);
			$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

			$regionid = @$res1->row()->regionid;


			if (!$regionid) {
				$array['data']['result'] = "fail";
				$array['data']['message'] = "Rate is not available in this pincode!";
				echo json_encode($array);
				exit();
			}

			$whr3 = array('region_id' => $regionid);
			$res3 = $this->basic_operation_m->selectRecord('region_master', $whr3);
			$result3 = $res3->row();

			$array['data'] = ['selected_city_id' => $city_id, 'selected_state_id' => $state_id, 'Isoda' => $isODA, 'zone' => $result3];
			$array['data']['result'] = "success";
			$array['data']['message'] = 'Success';
		} else {
			$array['data']['result'] = "fail";
			$array['data']['message'] = "Service is not available in this pincode";
		}

		echo json_encode($array);

		die;
	}

	public function type_parcel()
	{
		$data['parcel'] = array('Wooden Box', 'Carton', 'Drum', 'Plastic Wrap', 'Gunny Bag');
		echo json_encode($data);
	}
	// some iuess pritesh time zone problem
	// public function addShipment()
	// {

	// 	$postdata = file_get_contents("php://input");
	// 	$postData = json_decode($postdata);

	// 	$this->write_request_file();


	// 	// $query = $this->basic_operation_m->insert('testmobile', array('data' => $postdata));die;
	// 	$settingData = [];
	// 	$resAct = $this->db->query("select * from setting");
	// 	$setting = $resAct->result();
	// 	foreach ($setting as $value):
	// 		$settingData[$value->key] = $value->value;
	// 	endforeach;

	// 	// $username =  $postData->user_name;//LU0001
	// 	$user_id = $postData->user_id;
	// 	$whr = array('user_id' => $user_id);
	// 	$res = $this->basic_operation_m->getAll('tbl_users', $whr);
	// 	// echo $this->db->last_query();
	// 	$uerdata = $res->row();
	// 	// print_r($uerdata); 
	// 	$username = $uerdata->username;
	// 	$branch_id = $uerdata->branch_id;
	// 	$user_id = $uerdata->user_id;
	// 	$user_type = $uerdata->user_type;

	// 	$user_id = $postData->user_id;
	// 	// echo '<pre>';print_r($postData);die;
	// 	$date = date('Y-m-d H:i:s', strtotime($postData->booking_date));
	// 	// print_r($postData);die;
	// 	if ($postData->customer_id != '') {
	// 		$rateData = $this->getRateMasterDetails($postData->customer_id, $postData->sender_city, $postData->reciever_city, $postData->mode_dispatch);
	// 	}



	// 	if ($postData->doc_type == 0) {
	// 		$doc_nondoc = 'Document';
	// 	} else {
	// 		$doc_nondoc = 'Non Document';
	// 	}
	// 	$result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
	// 	$id = $result->id + 1;

	// 	if (strlen($id) == 2) {
	// 		$id = 'M000' . $id;
	// 	} elseif (strlen($id) == 3) {
	// 		$id = 'M100' . $id;
	// 	} elseif (strlen($id) == 1) {
	// 		$id = 'M10000' . $id;
	// 	} elseif (strlen($id) == 4) {
	// 		$id = 'M10' . $id;
	// 	} elseif (strlen($id) == 5) {
	// 		$id = 'M1' . $id;
	// 	}
	// 	$pod_no = trim($postData->awn);
	// 	if ($pod_no != "") {
	// 		$awb_no = $pod_no;
	// 	} else {
	// 		$awb_no = $id;
	// 	}
	// 	$eawydate = date('Y-m-d H:i:s', strtotime($postData->eway_expiry_date));
	// 	$data = array(
	// 		'doc_type' => $postData->doc_type,
	// 		'doc_nondoc' => $doc_nondoc,
	// 		'courier_company_id' => $postData->courier_company_id,
	// 		'company_type' => 'Domestic',
	// 		'mode_dispatch' => $postData->mode_dispatch,
	// 		'pod_no' => $awb_no,
	// 		'forwording_no' => $postData->forwording_no,
	// 		'forworder_name' => 'SELF',
	// 		'customer_id' => $postData->customer_id,
	// 		'sender_name' => $postData->sender_name,
	// 		'sender_address' => $postData->sender_address,
	// 		'sender_city' => $postData->sender_city,
	// 		'sender_state' => $postData->sender_state,
	// 		'sender_pincode' => $postData->sender_pincode,
	// 		'sender_contactno' => $postData->sender_contactno,
	// 		'sender_gstno' => $postData->sender_gstno,
	// 		'reciever_name' => $postData->reciever_name,
	// 		'contactperson_name' => $postData->contactperson_name,
	// 		'reciever_address' => $postData->reciever_address,
	// 		'reciever_contact' => $postData->reciever_contact,
	// 		'reciever_pincode' => $postData->reciever_pincode,
	// 		'reciever_city' => $postData->reciever_city,
	// 		'reciever_state' => $postData->reciever_state,
	// 		'receiver_zone' => $postData->receiver_zone,
	// 		'receiver_zone_id' => $postData->receiver_zone_id,
	// 		'receiver_gstno' => $postData->receiver_gstno,
	// 		'ref_no' => $postData->ref_no,
	// 		'invoice_no' => $postData->invoice_no,
	// 		'invoice_value' => $postData->invoice_value,
	// 		'eway_no' => $postData->eway_no,
	// 		'eway_expiry_date' => $eawydate,
	// 		'risk_type' => $postData->risk_type,
	// 		'special_instruction' => $postData->special_instruction,
	// 		//'type_of_pack' => $this->input->post('type_of_pack'),
	// 		'type_shipment' => $postData->type_shipment,
	// 		'booking_date' => $date,
	// 		'dispatch_details' => $postData->dispatch_details,
	// 		'payment_method' => $postData->payment_method,
	// 		'frieht' => $postData->frieht,
	// 		'transportation_charges' => $postData->transportation_charges,
	// 		'pickup_charges' => $postData->pickup_charges,
	// 		'delivery_charges' => $postData->delivery_charges,
	// 		'courier_charges' => $postData->courier_charges,
	// 		'awb_charges' => $postData->awb_charges,
	// 		'other_charges' => $postData->other_charges,
	// 		'total_amount' => $postData->amount,
	// 		'fuel_subcharges' => $postData->fuel_subcharges,
	// 		'warehousing' => $postData->warehousing_ch,
	// 		'dph' => $postData->dph_ch,
	// 		'address_change' => $postData->address_ch,
	// 		'insurance_charges' => $postData->insurance_ch,
	// 		'appt_charges' => $postData->appt_ch,
	// 		'adhoc_lable' => json_encode($postData->Lable),
	// 		'adhoc_charges' => json_encode($postData->Charges),
	// 		'sub_total' => $postData->sub_total,
	// 		'green_tax' => $postData->topay_ch,
	// 		'cgst' => $postData->cgst,
	// 		'sgst' => $postData->sgst,
	// 		'igst' => $postData->igst,
	// 		'grand_total' => $postData->grand_total,
	// 		'user_id' => $user_id,
	// 		'user_type' => $user_type,
	// 		'branch_id' => $branch_id,
	// 		'booking_type' => 1,
	// 	);
	// 	//print_r($data);die;
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
	// 		// echo $this->db->last_query();die;
	// 		$lastid = $this->db->insert_id();

	// 		if ($postData->valumetric_weight > $postData->chargable_weight) {
	// 			$postData->chargable_weight = $postData->valumetric_weight;
	// 		}

	// 		$weight_data = array(
	// 			'per_box_weight_detail' => $postData->per_box_weight_detail,
	// 			'length_detail' => $postData->length_detail,
	// 			'breath_detail' => $postData->breath_detail,
	// 			'height_detail' => $postData->height_detail,
	// 			'valumetric_weight_detail' => $postData->valumetric_weight_detail,
	// 			'valumetric_actual_detail' => $postData->valumetric_actual_detail,
	// 			'valumetric_chageable_detail' => $postData->valumetric_chageable_detail,
	// 			'per_box_weight' => $postData->per_box_weight,
	// 			'length' => $postData->length,
	// 			'breath' => $postData->breath,
	// 			'height' => $postData->height,
	// 			'valumetric_weight' => $postData->valumetric_weight,
	// 			'valumetric_actual' => $postData->actual_weight,
	// 			'valumetric_chageable' => $postData->valumetric_chageable,
	// 		);

	// 		$weight_details = json_encode($weight_data);


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
	// 			'valumetric_weight_detail' => json_encode($postData->valumetric_weight_detail),
	// 			'chargable_weight_detail' => json_encode($postData->chargable_weight),
	// 			'length_detail' => json_encode($postData->length_detail),
	// 			'breath_detail' => json_encode($postData->breath_detail),
	// 			'height_detail' => json_encode($postData->height_detail),
	// 			'no_pack_detail' => json_encode($postData->no_of_pack),
	// 			'per_box_weight_detail' => json_encode($postData->per_box_weight_detail),
	// 			'weight_details' => $weight_details
	// 		);
	// 		$whr = array('pincode' => $postData->reciever_pincode);
	// 		$res = $this->basic_operation_m->getAll('tbl_branch_service', $whr);
	// 		$delivery_branch = $res->row()->branch_id;

	// 		$stock = array(
	// 			'delivery_branch' => $delivery_branch,
	// 			'destination_pincode' => $postData->reciever_pincode,
	// 			'current_branch' => $branch_id,
	// 			'pod_no' => $awb_no,
	// 			'booking_id' => $lastid,
	// 			'booked' => '1'
	// 		);
	// 		$this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);


	// 		//  echo '<pre>'; print_r($data2);
	// 		$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);
	// 		// echo $this->db->last_query();die;


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

		$this->write_request_file();


		// $query = $this->basic_operation_m->insert('testmobile', array('data' => $postdata));die;
		$settingData = [];
		$resAct = $this->db->query("select * from setting");
		$setting = $resAct->result();
		foreach ($setting as $value):
			$settingData[$value->key] = $value->value;
		endforeach;

		// $username =  $postData->user_name;//LU0001
		$user_id = $postData->user_id;
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$uerdata = $res->row();
		// print_r($uerdata); 
		$username = $uerdata->username;
		$branch_id = $uerdata->branch_id;
		$user_id = $uerdata->user_id;
		$user_type = $uerdata->user_type;

		$user_id = $postData->user_id;
		// echo '<pre>';print_r($postData);die;
		$date = date('Y-m-d H:i:s', strtotime($postData->booking_date));
		// print_r($postData);die;
		// if ($postData->customer_id != '') {
		// 	$rateData = $this->getRateMasterDetails($postData->customer_id, $postData->sender_city, $postData->reciever_city, $postData->mode_dispatch);
		// }



		if ($postData->doc_type == 0) {
			$doc_nondoc = 'Document';
		} else {
			$doc_nondoc = 'Non Document';
		}
		$result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
		$id = $result->id + 1;

		if (strlen($id) == 2) {
			$id = 'M000' . $id;
		} elseif (strlen($id) == 3) {
			$id = 'M100' . $id;
		} elseif (strlen($id) == 1) {
			$id = 'M10000' . $id;
		} elseif (strlen($id) == 4) {
			$id = 'M10' . $id;
		} elseif (strlen($id) == 5) {
			$id = 'M1' . $id;
		}
		$pod_no = trim($postData->awn);
		if ($pod_no != "") {
			$awb_no = $pod_no;
			$exsit = $this->db->query("SELECT * FROM tbl_customer_assign_cnode WHERE customer_id ='$postData->customer_id'")->row();					
			if(!empty($exsit)){
                $stock = $this->db->query("SELECT * FROM tbl_customer_assign_cnode WHERE customer_id ='$postData->customer_id' AND (" . $awb_no . " BETWEEN seriess_from AND seriess_to)")->row();
                if(empty($stock)){
					echo json_encode([
						'status' => 'error',
						'message' => "Stock Not Exist! \n Please Assign this Customer Stock."
					]);
					exit;
                }
            }
		} else {
			$awb_no = $id;
		}
		$eawydate = date('Y-m-d H:i:s', strtotime($postData->eway_expiry_date));
		$data = array(
			'doc_type' => $postData->doc_type,
			'doc_nondoc' => $doc_nondoc,
			'courier_company_id' => $postData->courier_company_id,
			'company_type' => 'Domestic',
			'mode_dispatch' => $postData->mode_dispatch,
			'pod_no' => $awb_no,
			'forwording_no' => $postData->forwording_no,
			'forworder_name' => 'SELF',
			'customer_id' => $postData->customer_id,
			'sender_name' => $postData->sender_name,
			'sender_address' => $postData->sender_address,
			'sender_city' => $postData->sender_city,
			'sender_state' => $postData->sender_state,
			'sender_pincode' => $postData->sender_pincode,
			'sender_contactno' => $postData->sender_contactno,
			'sender_gstno' => $postData->sender_gstno,
			'reciever_name' => $postData->reciever_name,
			'contactperson_name' => $postData->contactperson_name,
			'reciever_address' => $postData->reciever_address,
			'reciever_contact' => $postData->reciever_contact,
			'reciever_pincode' => $postData->reciever_pincode,
			'reciever_city' => $postData->reciever_city,
			'reciever_state' => $postData->reciever_state,
			'receiver_zone' => $postData->receiver_zone,
			'receiver_zone_id' => $postData->receiver_zone_id,
			'receiver_gstno' => $postData->receiver_gstno,
			'ref_no' => $postData->ref_no,
			'invoice_no' => $postData->invoice_no,
			'invoice_value' => $postData->invoice_value,
			'eway_no' => $postData->eway_no,
			'eway_expiry_date' => $eawydate,
			'risk_type' => $postData->risk_type,
			'special_instruction' => $postData->special_instruction,
			//'type_of_pack' => $this->input->post('type_of_pack'),
			'type_shipment' => $postData->type_shipment,
			'booking_date' => $date,
			'dispatch_details' => $postData->dispatch_details,
			'payment_method' => $postData->payment_method,
			'frieht' => $postData->frieht,
			'transportation_charges' => $postData->transportation_charges,
			'pickup_charges' => $postData->pickup_charges,
			'delivery_charges' => $postData->delivery_charges,
			'courier_charges' => $postData->courier_charges,
			'awb_charges' => $postData->awb_charges,
			'other_charges' => $postData->other_charges,
			'total_amount' => $postData->amount,
			'fuel_subcharges' => $postData->fuel_subcharges,
			'warehousing' => $postData->warehousing_ch,
			'dph' => $postData->dph_ch,
			'address_change' => $postData->address_ch,
			'insurance_charges' => $postData->insurance_ch,
			'appt_charges' => $postData->appt_ch,
			'adhoc_lable' => json_encode($postData->Lable),
			'adhoc_charges' => json_encode($postData->Charges),
			'sub_total' => $postData->sub_total,
			'green_tax' => $postData->topay_ch,
			'cgst' => $postData->cgst,
			'sgst' => $postData->sgst,
			'igst' => $postData->igst,
			'grand_total' => $postData->grand_total,
			'user_id' => $user_id,
			'user_type' => $user_type,
			'branch_id' => $branch_id,
			'booking_type' => 1,
		);
		//print_r($data);die;
		
		$whr = array('pod_no' => $awb_no);
		$res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);

		if ($res->num_rows()) {
			echo json_encode([
				'status' => 'error',
				'message' => "Already Exist " . $awb_no . '<br>'
			]);

			exit;
		} else {
			$this->db->trans_start();
			// echo '<pre>'; print_r($data); die;
			$query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);
			// echo $this->db->last_query();die;
			$lastid = $this->db->insert_id();

			if ($postData->valumetric_weight > $postData->chargable_weight) {
				$postData->chargable_weight = $postData->valumetric_weight;
			}

			$weight_data = array(
				'per_box_weight_detail' => $postData->per_box_weight_detail,
				'length_detail' => $postData->length_detail,
				'breath_detail' => $postData->breath_detail,
				'height_detail' => $postData->height_detail,
				'valumetric_weight_detail' => $postData->valumetric_weight_detail,
				'valumetric_actual_detail' => $postData->valumetric_actual_detail,
				'valumetric_chageable_detail' => $postData->valumetric_chageable_detail,
				'per_box_weight' => $postData->per_box_weight,
				'length' => $postData->length,
				'breath' => $postData->breath,
				'height' => $postData->height,
				'valumetric_weight' => $postData->valumetric_weight,
				'valumetric_actual' => $postData->actual_weight,
				'valumetric_chageable' => $postData->valumetric_weight,
				// 'valumetric_chageable' => $postData->actual_weight,
			);

			$weight_details = json_encode($weight_data);


			$data2 = array(
				'booking_id' => $lastid,
				'actual_weight' => $postData->actual_weight,
				// 'actual_weight' => $postData->chargable_weight,
				'valumetric_weight' => $postData->valumetric_weight,
				'length' => $postData->length,
				'breath' => $postData->breath,
				'height' => $postData->height,
				'chargable_weight' => $postData->actual_weight,
				'per_box_weight' => $postData->per_box_weight,
				'no_of_pack' => $postData->no_of_pack,
				'actual_weight_detail' => $postData->actual_weight,
				'valumetric_weight_detail' => json_encode($postData->valumetric_weight_detail),
				'chargable_weight_detail' => json_encode($postData->actual_weight),
				'length_detail' => json_encode($postData->length_detail),
				'breath_detail' => json_encode($postData->breath_detail),
				'height_detail' => json_encode($postData->height_detail),
				'no_pack_detail' => json_encode($postData->no_of_pack),
				'per_box_weight_detail' => json_encode($postData->per_box_weight_detail),
				'weight_details' => $weight_details
			);
			$whr = array('pincode' => $postData->reciever_pincode);
			$res = $this->basic_operation_m->getAll('tbl_branch_service', $whr);
			$delivery_branch = $res->row()->branch_id;

			$stock = array(
				'delivery_branch' => $delivery_branch,
				'destination_pincode' => $postData->reciever_pincode,
				'current_branch' => $branch_id,
				'pod_no' => $awb_no,
				'booking_id' => $lastid,
				'booked' => '1'
			);
			$this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);


			//  echo '<pre>'; print_r($data2);
			$query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);
			// echo $this->db->last_query();die;


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
				'remarks' => $postData->special_instruction,
				'forworder_name' => $data['forworder_name'],
				'forwording_no' => $data['forwording_no'],
				'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
				'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
				'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
			);

			$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
			$this->db->trans_complete();

			if ($postData->customer_id != "") {
				$whr = array('customer_id' => $customerid);
				$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
				//$email= $res->row()->email;
			}

			$message = 'Your Shipment booked AWB No: ' . $podno . ' At Location: ' . $branch_name;
			if ($this->db->trans_status() == true) {
				$this->db->trans_commit();
				echo json_encode([
					'status' => 'success',
					'booking_id' => $lastid,
					'message' => $message,
				]);
				exit;
			} else {
				$this->db->trans_rollback();
				echo json_encode([
					'status' => 'error',
					'message' => 'Booking not created successfully',
				]);

				exit;
			}
		}
	}

	public function getFuelCharges()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$customer_id = $request->customer_id;
		$courier_id = $request->courier_id;
		$booking_date = $request->booking_date;
		$sub_amount = $request->sub_amount;
		$dispatch_details = $request->dispatch_details;

		$current_date = date("Y-m-d");

		$current_date = date("Y-m-d", strtotime($booking_date));

		$whr1 = array('courier_id' => $courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => $customer_id);
		$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);
		if (empty($res1)) {
			$whr1 = array('courier_id' => $courier_id, 'fuel_from <=' => $current_date, 'fuel_to >=' => $current_date, 'customer_id =' => '0');
			$res1 = $this->basic_operation_m->get_query_row("select * from courier_fuel where (courier_id = '$courier_id' or courier_id='0') and fuel_from <= '$current_date' and fuel_to >='$current_date' and (customer_id = '0' or customer_id = '$customer_id')");
		}

		//$whr1 = array('courier_id' => $courier_id,'fuel_from <=' => $current_date,'fuel_to >=' => $current_date);
		//$res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);
		if ($res1) {
			$fuel_per = $res1->fuel_price;
		} else {
			$fuel_per = '0';
		}

		$final_fuel_charges = ($sub_amount * $fuel_per / 100);

		$sub_total = ($sub_amount + $final_fuel_charges);


		$whr2 = array('from <=' => $current_date, 'to >=' => $current_date);
		$gst_details = $this->basic_operation_m->get_table_row('tbl_gst_setting', $whr2);

		//echo $this->db->last_query();

		if ($gst_details) {
			$cgst_per = $gst_details->cgst;
			$sgst_per = $gst_details->sgst;
			$igst_per = $gst_details->igst;
		} else {
			$cgst_per = '0';
			$sgst_per = '0';
			$igst_per = '0';
		}



		$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");

		if ($tbl_customers_info->gst_charges == 1) {
			$cgst = ($sub_total * $cgst_per / 100);
			$sgst = ($sub_total * $sgst_per / 100);
			$igst = 0;
		} else {
			$cgst = 0;
			$sgst = 0;
			$igst = 0;
		}

		if ($dispatch_details == 'Cash') {
			$cgst = 0;
			$sgst = 0;
			$igst = 0;
		}


		$grand_total = $sub_total + $cgst + $sgst + $igst;


		$result2 = array(
			'final_fuel_charges' => $final_fuel_charges,
			'sub_total' => number_format($sub_total, 2, '.', ''),
			'cgst' => number_format($cgst, 2, '.', ''),
			'sgst' => number_format($sgst, 2, '.', ''),
			'igst' => number_format($igst, 2, '.', ''),
			'grand_total' => number_format($grand_total, 2, '.', ''),
		);
		echo json_encode($result2);
	}


	public function available_cft()
	{

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$courier_id = $request->courier_id;
		$booking_date = trim($request->booking_date);
		$customer_id = trim($request->customer_id);

		if (!empty($booking_date)) {
			$current_date = date("Y-m-d", strtotime($booking_date));
		} else {
			$current_date = date('Y-m-d');
		}
		$whr1 = array('fuel_from <=' => $current_date, 'fuel_to >=' => $current_date);
		$where = '(courier_id="' . $courier_id . '" or courier_id = "0") AND (customer_id="' . $customer_id . '" or customer_id = "0")';
		$this->db->select('*');
		$this->db->from('courier_fuel');
		$this->db->where($whr1);
		$this->db->where($where);
		$this->db->order_by('customer_id', 'DESC');
		// $this->db->where('customer_id',$customer_id);

		$query = $this->db->get();
		$res1 = $query->row();
		// $res1 = $this->basic_operation_m->get_table_row('courier_fuel', $whr1);

		if ($res1) {
			$fuel_per = $res1->cft;
		} else {
			$fuel_per = '0';
		}
		if ($res1) {
			$fuel_per2 = $res1->air_cft;
		} else {
			$fuel_per2 = '0';
		}

		// echo $this->db->last_query();

		$result2 = array('cft_charges' => $fuel_per, 'air_cft' => $fuel_per2);
		echo json_encode($result2);
	}

	public function get_rate()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		date_default_timezone_set('Asia/Kolkata');
        $booking_date = date("Y-m-d H:i:s"); // time in India
        $date = date('Y-m-d H:i:s', strtotime($booking_date));

         $customerId = $request->customer_id;
         $Mode = $request->mode_dispatch;
         $pay_mode = $request->bill_types;
         $invoiceV = $request->invoice_value;
         $sender_pincode = $request->sender_pincode;
         $receiver_pincode = $request->receiver_pincode;
		 $sender = $this->basic_operation_m->selectRecord('pincode', ['pin_code'=>$sender_pincode,'isdeleted'=>0])->row();
		 $reciever = $this->basic_operation_m->selectRecord('pincode', ['pin_code'=>$receiver_pincode,'isdeleted'=>0])->row();
         $receiver_gstno = $request->receiver_gstno;
         $no_of_pack = $request->no_of_pack;
         $actual_weight = $request->actual_weight;
         $vol_actual_weight = $request->vol_actual_weight;
         $vol_no_of_pkgs = $request->vol_no_of_pkgs;


		if ($customerId != '') {
            $rate = $this->getMasterRates($customerId, $Mode, $date, $pay_mode, $no_of_pack, $actual_weight, $receiver_gstno, $invoiceV, '0', $sender->state_id, $sender->city_id, $reciever->state_id, $reciever->city_id);
            if ($rate['frieht'] == 0) {
                $rate = $this->get_perbox_rate($customerId, $Mode, $date, $pay_mode, $no_of_pack, $actual_weight, $receiver_gstno, $invoiceV, '0', $sender->state_id, $sender->city_id, $reciever->state_id, $reciever->city_id, $vol_actual_weight, $vol_no_of_pkgs);
                if (!empty($rate['Message'])) {
                    $rate = [
						'sender_zone_id' =>0,
						'tat_date' => 0,
						'reciver_zone_id' => 0,
						'chargable_weight' => 0,
						'chargable_weight_input' => 0,
						'frieht' => 0,
						'fov' => 0,
						'appt_charges' => 0,
						'docket_charge' => 0,
						'amount' => 0,
						'cod' => 0,
						'cft' => 0,
						'to_pay_charges' => 0,
						'final_fuel_charges' => 0,
						'sub_total' => 0,
						'cgst' => 0,
						'sgst' => 0,
						'igst' => 0,
						'grand_total' =>0,
						'isMinimumValue' => 0,
						'fovExpiry' => 0,
                        'Message' => 'Rate Not defined Please check Rate',
                        'data' => ''
                    ];
                }
            }
			echo json_encode($rate);
			exit();
        }

	}

	public function get_perbox_rate($customer_id, $mode_id, $booking_date, $dispatch_details, $packet, $chargable_weight, $receiver_gstno, $invoice_value, $is_appointment, $sender_state, $sender_city, $reciver_state, $reciver_city, $perBox_actual, $per_box)
    {
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', '0');
        error_reporting(E_ALL);

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

        $sub_total = 0;
        $c_courier_id = 35;


       
        $actual_weight_exp = $perBox_actual;
        //  $actual_weight_exp = explode(',',$perBox_actual);
        $per_box_exp = $per_box;
        $rate_all = [];
        $not_d_rate = [];
        foreach ($actual_weight_exp as $weight) {
            if (!empty($weight)) {
                $where = "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

                $fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
					(customer_id='$customer_id' OR  customer_id=0)
					AND from_zone_id='$sender_zone_id' AND to_zone_id='$reciver_zone_id'
					AND (from_city_id='$sender_city' OR  city_id=0)
					AND (from_state_id='$sender_state' OR from_state_id=0)
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

                if ($fixed_perkg_result->num_rows() == 0) {
                    $not_d_rate[] = +$weight;
                }

                if (!empty($values->rate)) {
                    $rate_all[] = +$values->rate;
                    $minimum_rate = $values->minimum_rate;
                }


            }

        }
        //  echo $this->db->last_query();die;
        $fright = [];
        $pack = array_values(array_filter($per_box_exp));
        foreach ($pack as $key1 => $weight) {
            foreach ($rate_all as $key => $rate_val) {
                if ($key1 == $key) {
                    $fright[] = +$rate_all[$key] * $pack[$key];
                }
            }
        }




        $frieht = array_sum($fright);
        $amount = array_sum($fright);
        $rate = array_sum($fright);


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

        if (!empty($rate)) {
            $data = array(
                //'query' => $query,
                'sender_zone_id' => $sender_zone_id,
                'rate' => $rate,
                'reciver_zone_id' => $reciver_zone_id,
                'chargable_weight' => ceil($chargable_weight),
                'chargable_weight_input' => ceil($chargable_weight_input),
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
        } else {
            $data['rate_message'] = '';
            $data['Message'] = 'Rate Not defined Please check Rate';
        }

        return $data;
        exit;
    }

	// public function getMasterRates()
	// {


	// 	$postdata = file_get_contents("php://input");
	// 	$request = json_decode($postdata);

	// 	$sub_total = 0;
	// 	$customer_id = $request->customer_id;
	// 	$c_courier_id = $request->c_courier_id;
	// 	$mode_id = $request->mode_id;
	// 	$reciver_zone_id = $request->receiver_zone_id;
	// 	$chargable_weight = $request->chargable_weight;
	// 	$receiver_gstno = $request->receiver_gstno;
	// 	$booking_date = $request->booking_date;
	// 	$invoice_value = $request->invoice_value;
	// 	$current_date = date("Y-m-d", strtotime($booking_date));
	// 	$doc_type = $request->doc_type;
	// 	$dispatch_details = $request->dispatch_details;
	// 	$reciver_city = $request->reciver_city;
	// 	$reciver_state = $request->reciver_state;
	// 	$sender_state = $request->sender_state;
	// 	$sender_city = $request->sender_city;
	// 	$is_appointment = $request->is_appointment;
	// 	$packet = $request->no_of_pack;
	// 	$whr1 = array('state' => $sender_state, 'city' => $sender_city);
	// 	$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);
	// 	$sender_zone_id = $res1->row()->regionid;
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
	// 	(customer_id=" . $customer_id . " OR  customer_id=0)
	// 	AND from_zone_id=" . $sender_zone_id . " AND to_zone_id=" . $reciver_zone_id . "
	// 	AND (city_id=" . $reciver_city . " OR  city_id=0)
	// 	AND (state_id=" . $reciver_state . " || state_id=0)
	// 	AND (mode_id=" . $mode_id . " || mode_id=0)
	// 	AND DATE(`applicable_from`)<='" . $current_date . "'
	// 	AND DATE(`applicable_to`)>='" . $current_date . "'
	// 	AND (" . $request->chargable_weight . "
	// 	BETWEEN weight_range_from AND weight_range_to)  
	// 	ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");

	// 	$frieht = 0;
	// 	$minimum_rate = 0;
	// 	// echo $this->db->last_query();die;
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
	// 			if ($values->fixed_perkg == 4 && ($request->chargable_weight >= $values->weight_range_from && $request->chargable_weight <= $values->weight_range_to)) // 1000 gm slab
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
	// 				$fixed_per_kg_1000 = floatval($total_slab) * floatval($values->rate);

	// 				$left_weight = $left_weight - $slab_weight;
	// 			}

	// 			if ($values->fixed_perkg == 5) // Box Fixed slab
	// 			{

	// 				$slab_weight = ($values->weight_slab < $left_weight) ? $values->weight_slab : $left_weight;
	// 				$total_slab = $slab_weight / 250;
	// 				$addtional_250 = $addtional_250 + $total_slab * $values->rate;
	// 				$left_weight = $left_weight - $slab_weight;
	// 			}

	// 			if ($values->fixed_perkg == 6) // 1000 gm slab
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
	// 			$appt_charges = ($res1->appointment_perkg * $request->chargable_weight);

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
	// 	$first_two_char = substr($receiver_gstno, 0, 2);

	// 	if ($receiver_gstno == "") {
	// 		$first_two_char = 27;
	// 	}

	// 	$tbl_customers_info = $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");

	// 	if ($tbl_customers_info->gst_charges == 1) {
	// 		if ($first_two_char == 27) {
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
	// 		$cgst = 0;
	// 		$sgst = 0;
	// 		$igst = 0;
	// 		$grand_total = $sub_total + $igst;
	// 	}

	// 	// if($dispatch_details == 'Cash')
	// 	// {	
	// 	// 	$cgst = 0;
	// 	// 	$sgst = 0;
	// 	// 	$igst = 0;
	// 	// 	$grand_total = $sub_total + $igst;
	// 	// }


	// 	// $query ="select * from tbl_domestic_rate_master where customer_id='".$customer_id."' AND $where  AND ( c_courier_id='".$c_courier_id."' OR c_courier_id=0) AND mode_id='".$mode_id."' AND DATE(`applicable_from`)<='".$current_date."' AND (".$chargable_weight." BETWEEN weight_range_from AND weight_range_to)  ORDER BY applicable_from DESC LIMIT 1";

	// 	if ($tat > 0) {
	// 		$tat_date = date('Y-m-d', strtotime($booking_date . " + $tat days"));
	// 	} else {
	// 		$tat_date = date('Y-m-d', strtotime($booking_date . " + 5 days"));
	// 	}


	// 	$data = array(
	// 		// 'query'=>$query,
	// 		'sender_zone_id' => $sender_zone_id,
	// 		'tat_date' => $tat_date,
	// 		'reciver_zone_id' => $reciver_zone_id,
	// 		'chargable_weight' => ceil($chargable_weight),
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

	public function getMasterRates($customer_id, $mode_id, $booking_date, $dispatch_details, $packet, $chargable_weight, $receiver_gstno, $invoice_value, $is_appointment, $sender_state, $sender_city, $reciver_state, $reciver_city)
    {
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
            AND fixed_perkg <> '6'
    		AND (" . $chargable_weight_input . "
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

            //    echo '<pre>'; print_r($chargable_weight_input);exit();
            $minimum_rate = $rate_master[0]->minimum_rate;
            $minimum_weight = $rate_master[0]->minimum_weight;
            if ($minimum_weight >= $chargable_weight_input) {
                $weight = ceil($minimum_weight);
            } else {
                $weight = ceil($chargable_weight_input);
            }

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
                if ($values->fixed_perkg == 4 && ($chargable_weight_input >= $values->weight_range_from && $chargable_weight_input <= $values->weight_range_to)) // 1000 gm slab
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
                // else {
                //     $fixed_per_kg_1000 = floatval($packet) * floatval($values->rate);
                // }

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
       

        $frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000 + $drum_perkg;
        $amount = $frieht;
        // print_r( $frieht);die;

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
                $amount = (float) $amount + (float) $fov + (float) $docket_charge + (float) $res1->cod + (float) $res1->to_pay_charges + (float) $appt_charges;
            } else {
                $amount = (float) $amount + (float) $fov + (float) $docket_charge + (float) $res1->cod + (float) $res1->to_pay_charges + (float) $appt_charges;
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
            'chargable_weight_input' => ceil($chargable_weight_input),
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
			'Message' => ''
        );
        return $data;
        exit;
    }


	public function getSliders()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$sliders = $this->db->get('tbl_homeslider')->result_array();
		$slidersArr = [];

		foreach ($sliders as $slider) {
			$url = base_url();

			$url = str_replace('https', 'http', $url);

			// echo $url;exit();
			$slider['slider_image'] = $url . 'assets/homeslider/' . $slider['slider_image'];
			// $slider['slider_image'] = base_url('assets/homeslider/'.$slider['slider_image']);
			$slidersArr[] = $slider;
		}

		$array['data'] = $slidersArr;

		echo json_encode($array);

		die;
	}

	public function getNews()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$allnews = $this->basic_operation_m->get_all_result('tbl_news', '');


		$array['data'] = $allnews;

		echo json_encode($array);

		die;
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
			$data['forwording_track'] = $tracking_href_details->row();

			$tracking_href_details2 = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'");
			$data['pod_upload'] = $tracking_href_details2->row();

			if (!empty($data['pod_upload'])) {
				$data['pod_upload'] = base_url('/assets/pod/') . $data['pod_upload']->image;
			} else {
				$data['pod_upload'] = "";
			}


			$reAct = $this->db->query("select * from tbl_international_tracking where pod_no = '$pod_no' ORDER BY id DESC");
			$data['pod'] = $reAct->result();
			$data['del_status'] = $reAct->row();
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
			$data['forwording_track'] = $tracking_href_details->row();


			$tracking_href_details2 = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'");
			$data['pod_upload'] = $tracking_href_details2->row();

			if (!empty($data['pod_upload'])) {
				$data['pod_upload'] = base_url('/assets/pod/') . $data['pod_upload']->image;
			} else {
				$data['pod_upload'] = "";
			}

			$reAct = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$pod_no' ORDER BY id DESC");
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

		if ($data['pod']) {
			$data['result'] = "success";
		} else {
			$data['result'] = "fail";
			$data['message'] = "Airway number not found";
		}
		echo json_encode($data);

		die;
	}
	public function customer_shipment_tracking()
	{
		$postdata = file_get_contents("php://input");

		// echo $postdata;
		//exit();
		$request = json_decode($postdata);
		// print_r($request);exit();
		$pod_no = $request->airway_number;
		ini_set('display_errors', 0); ini_set('display_startup_errors', 0); error_reporting(E_ALL);
			$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where pod_no = '$pod_no'");
			$info = $reAct->row();
			if (empty($info)) 
			{
				$data['result'] = "fail";
				$data['message'] = "Airway number not found";
				echo json_encode($data);

				die;
			}
			else
			{   			
			$reAct = $this->db->query("select pod_no,status,branch_name,tracking_date,added_branch from tbl_domestic_tracking where pod_no = '$pod_no' ORDER BY id DESC");
			$current_status = $reAct->row('status');
			$mode_name = $this->db->query("select mode_name from transfer_mode where transfer_mode_id= '$info->mode_dispatch'")->row('mode_name');
				$data['booking_info'] = [
					'awb'=>$info->pod_no,
					'booking_date'=>$info->booking_date,
					'customer_name'=>$info->sender_name,
					'reciever_name'=>$info->reciever_name,
					'origin'=>$info->sender_city_name,
					'destination'=>$info->reciever_country_name,
					'no_of_pack'=>$info->no_of_pack,
					'mode_name'=>$mode_name,
					'shipmet_current_status'=>$current_status,
				];
				foreach($reAct->result() as $key =>$value){
					 if($value->status == 'In transit')
					 {
						$status = 'In transit To '.$value->branch_name;
						$branch = $value->added_branch;
					 }
					 else
					 {
						$status = $value->status;
						$branch = $value->branch_name;
					 }
					$shipemt_tracking_det = [
						'awbno'=>$value->pod_no,
						'tracking_date'=>$value->tracking_date,
						'status'=>$status,
						'branch'=>$branch,
						'added_branch'=>$value->added_branch,
					 ];
					$val[] = $shipemt_tracking_det;
				}
				
			$data['shipemt_tracking_det'] =$val;
			
			$tracking_href_details2 = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'");
			$data['pod_upload'] = $tracking_href_details2->row();

			if (!empty($data['pod_upload'])) {
				$data['pod_upload'] = base_url('/assets/pod/') . $data['pod_upload']->image;
			} else {
				$data['pod_upload'] = "";
			}
		}
		if (!empty($data['shipemt_tracking_det'])) {
			foreach ($data['shipemt_tracking_det'] as $values) {
				if ($values->status == 'DELIVERED' || $values->status == 'Delivered') {
					$data['delivery_date'] = $values->tracking_date;
				}
			}
		}

		if ($data['shipemt_tracking_det']) {
			$data['result'] = "success";
		} else {
			$data['result'] = "fail";
			$data['message'] = "Airway number not found";
		}
		echo json_encode($data);

		die;
	}

	public function tracking()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pod_no = $request->airway_number;
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
		$customer_id = $request->customer_id;
		// print_r($request);die;
		$check_pod_international = $this->db->query("select pod_no from tbl_international_booking where pod_no = '$pod_no'");
		$check_result = $check_pod_international->row();

		if (isset($check_result)) {
			$reAct = $this->db->query("select tbl_international_booking.*,tbl_international_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.country_name as reciever_country_name from tbl_international_booking left join tbl_international_weight_details on tbl_international_booking.booking_id=tbl_international_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_international_booking.sender_city INNER JOIN zone_master recievercity ON recievercity.z_id = tbl_international_booking.reciever_country_id where pod_no = '$pod_no'");
			$data['info'] = $reAct->row();

			$courier_company_id = $data['info']->courier_company_id;

			$tracking_href_details = $this->db->query("select * from courier_company where c_id= '$courier_company_id'");
			$data['forwording_track'] = $tracking_href_details->row();


			$reAct = $this->db->query("select *,remarks as status,status as branch_name  from tbl_international_tracking where pod_no ='$pod_no' ORDER BY id asc");
			$data['pod'] = $reAct->result();
			$data['del_status'] = $reAct->row();
		} else {
			$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where pod_no = '$pod_no'");
			$data['info'] = $reAct->row();

			$courier_company_id = $data['info']->courier_company_id;
			$tracking_href_details = $this->db->query("select * from courier_company where c_id='$courier_company_id'");
			$data['forwording_track'] = $tracking_href_details->row();

			$reAct = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$pod_no' ORDER BY id DESC");
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

		$dataa = json_decode(json_encode($data), true);

		$modeDispach = 'Air';
		if ($dataa['info']['mode_dispatch'] == '2') {
			$modeDispach = 'Train';
		}
		if ($dataa['info']['mode_dispatch'] == '2') {
			$modeDispach = 'Surface';
		}

		// print_r($dataa);
		$trankingdata = [];
		foreach ($dataa['pod'] as $trackinfo) {
			$status = $trackinfo['status'];
			if ($trackinfo['comment']) {
				$status = $status . '-' . $trackinfo['comment'];
			}
			$trankingdata[] = array(
				'date' => $trackinfo['tracking_date'],
				'status' => $status,
				'location' => $trackinfo['branch_name']
			);
		}

		$resultarr['tracking_data'] = array(
			'pod_no' => $dataa['info']['pod_no'],
			'booking_date' => $dataa['info']['booking_date'],
			'origin' => $dataa['info']['sender_city_name'],
			'destination' => $dataa['info']['reciever_country_name'],
			'mode' => $modeDispach,
			'nop' => $dataa['info']['no_of_pack'],
			'tracking_info' => $trankingdata,
		);

		if ($resultarr) {
			$resultarr['result'] = "success";
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Airway number not found";
		}
		echo json_encode($resultarr);

		die;
	}

	public function change_delivery_status()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$tracking_date = date('Y-m-d H:i:s', strtotime($request->tracking_date));
		$selected_docket = $request->selected_docket;
		$company_type = $request->company_type;
		$status = $request->status;
		$comment = $request->comment;
		$remarks = $request->remarks;
		$user_id = $request->user_id;
		if (isset($request->image)) {
			$cust_sign = $request->image;
		} else {
			$cust_sign = '';
		}

		$pod_no = $selected_docket;

           
		//  $pod_no=$this->input->post('pod_no');
		// 	$status=$this->input->post('status');
		// 	$comment = $this->input->post('comment');

		if ($selected_docket) {
			$is_delhivery_complete = 0;


			$whr = array('user_id' => $user_id);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$date = date('y-m-d');

			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$date = date('Y-m-d H:i:s');



			if (!empty($cust_sign)) {

				if (base64_decode($cust_sign)) {
					// echo "valid";
					$cust_sign = $this->save_base64_image($cust_sign, time() . "_" . $selected_docket . "_sign", "assets/pod_sign/");
				} else {
					$data['result'] = "faild";
					$data['message'] = "Not a valid signature file";
					echo json_encode($data);
					exit();
				}
			}

			// exit();
			
			if ($company_type == "Domestic") {
				if ($status == 'Delivered') {
					// $is_delhivery_complete = 1;
					// $where = array('pod_no' => $selected_docket);
					// $updateData = [
					// 	'is_delhivery_complete' => $is_delhivery_complete,
					// ];
					// $this->db->update('tbl_domestic_booking', $updateData, $where);



					

					$is_delhivery_complete = 1;
					$where = array('booking_id' => $selected_docket);
					$updateData = [
						'is_delhivery_complete' => $is_delhivery_complete,
					];
					$this->db->update('tbl_domestic_booking', $updateData, $where);
					$is_delhivery_complete = 1;
					$where = array('pod_no' => $selected_docket);
					$updateData1 = [
						'is_delivered' => '1',
					];
					$this->db->update('tbl_domestic_stock_history', $updateData1, $where);
					// echo $this->db->last_query();
					// echo '<pre>';print_r($request);die;
					$shipping_data = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $selected_docket])->row();
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

					$booking_data = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $selected_docket])->row();

					// echo "<pre>"; print_r($booking_data); die;
					$this->load->model('booking_model');
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
				else {
					$is_delhivery_complete = 0;
					$where = array('pod_no' => $selected_docket);
					$updateData = [
						'is_delhivery_complete' => $is_delhivery_complete,
					];
					$this->db->update('tbl_domestic_booking', $updateData, $where);
					
					$is_delhivery_complete = 1;
					$where = array('pod_no' => $selected_docket);
					$updateData1 = [
						'delivery_sheet' => '0',
					];
					$this->db->update('tbl_domestic_stock_history', $updateData1, $where);
					$shipping_data = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $selected_docket])->row();
					// echo 'hello';
				}
            //   die;
				$this->db->select('pod_no, booking_id, forworder_name, forwording_no');
				$this->db->from('tbl_domestic_booking');
				$this->db->where('pod_no', $selected_docket);
				$this->db->order_by('booking_id', 'DESC');
				$result = $this->db->get();
				$resultData = $result->row();

				$pod_no = $resultData->pod_no;
				$forworder_name = $resultData->forworder_name;
				$forwording_no = $resultData->forwording_no;
				$booking_id = $resultData->booking_id;

				$data = [
					'pod_no' => $pod_no,
					'branch_name' => $branch_name,
					'booking_id' => $booking_id,
					'forworder_name' => $forworder_name,
					'forwording_no' => $forwording_no,
					'tracking_date' => $tracking_date,
					'status' => $status,
					'comment' => $comment,
					'remarks' => $remarks,
					'is_delhivery_complete' => $is_delhivery_complete,
					'cust_sign' => $cust_sign,
				];
				
				$this->db->insert('tbl_domestic_tracking', $data);
			}
			$data['result'] = "success";
			$data['message'] = "Delivery Status Changed successfully";
		}
		echo json_encode($data);

		die;
	}

	public function upload_pod()
	{
		$all_data = $this->input->post();
		// 
		$data = array();
		if (!empty($all_data)) {
			$user_id = $all_data['user_id'];
			$whr = array('user_id' => $user_id);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$username = $res->row()->username;
			$date = date('y-m-d');

			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;

			$date = date('y-m-d');
			$r = array(

				'deliveryboy_id' => $username,
				'pod_no' => $this->input->post('pod_no'),
				'image' => '',
				'booking_date' => $date
			);
			$whr = array('pod_no' => $this->input->post('pod_no'));
			$dddd = $this->basic_operation_m->getAll('tbl_upload_pod', $whr);
			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			if ($dddd->row()->id) {
				$lastid = $dddd->row()->id;
			} else {
				$result = $this->basic_operation_m->insert('tbl_upload_pod', $r);
				$lastid = $this->db->insert_id();
			}


			$config['upload_path'] = "assets/pod/";
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = 'pod_' . $lastid . '.jpg';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->set_allowed_types('*');

			$data['upload_data'] = '';
			$url_path = "";
			if (!$this->upload->do_upload('image')) {
				$data = array('msg' => $this->upload->display_errors());
			} else {
				$image_path = $this->upload->data();
			}

			$data = array('image' => $image_path['file_name']);

			$this->basic_operation_m->update('tbl_upload_pod', $data, $whr);

			if ($this->db->affected_rows() > 0) {
				$data['message'] = "Image Added Sucessfully";
			} else {
				$data['message'] = "Error in Query";
			}

			$data['result'] = "success";
			$data['message'] = "POD Upload successfully";
		}
		echo json_encode($data);
	}

	public function all_status()
	{
		// $array = [
		// 	['id'=>'Booked','name'=>'Booked'],
		// 	['id'=>'Delivered','name'=>'Delivered'],
		// 	['COD'=>'Out for delivery','name'=>'Out for delivery'],
		// 	['ToPay'=>'RTO','name'=>'RTO'],
		// 	['ToPay'=>'Intransit','name'=>'Intransit'],
		// ];

		$array = [];
		// $this->db->where_not_in('id',array(1,2,3,6,7,8,9,10,11,12));
		$this->db->where_not_in('id', array(1));
		$status = $this->db->get('tbl_status')->result_array();
		foreach ($status as $sttus) {
			$array[] = ['id' => $sttus['status'], 'name' => $sttus['status']];
		}

		$data['all_status'] = $array;
		echo json_encode($data);
	}


	public function all_coloader()
	{
		// $array = [
		// 	['id'=>'Booked','name'=>'Booked'],
		// 	['id'=>'Delivered','name'=>'Delivered'],
		// 	['COD'=>'Out for delivery','name'=>'Out for delivery'],
		// 	['ToPay'=>'RTO','name'=>'RTO'],
		// 	['ToPay'=>'Intransit','name'=>'Intransit'],
		// ];

		$array = [];
		$status = $this->db->get('tbl_coloader')->result_array();

		$data['all_coloader'] = $status;
		echo json_encode($data);
	}

	public function all_vender()
	{
		// $array = [
		// 	['id'=>'Booked','name'=>'Booked'],
		// 	['id'=>'Delivered','name'=>'Delivered'],
		// 	['COD'=>'Out for delivery','name'=>'Out for delivery'],
		// 	['ToPay'=>'RTO','name'=>'RTO'],
		// 	['ToPay'=>'Intransit','name'=>'Intransit'],
		// ];



		$array = [];
		$status = $this->db->get('tbl_vendor')->result_array();

		$data['all_vendor'] = $status;
		echo json_encode($data);
	}

	public function getShipmentStatus()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pod_no = $request->awnno;
		$user_id = $request->user_id;


		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$username = $res->row()->username;
		$date = date('y-m-d');

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$check_pod_international = $this->db->query("select pod_no from tbl_international_booking where pod_no = '$pod_no'");
		$check_result = $check_pod_international->row();

		if (isset($check_result)) {
			$reAct = $this->db->query("select tbl_international_booking.*,tbl_international_weight_details.no_of_pack,tbl_international_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.country_name as reciever_country_name from tbl_international_booking left join tbl_international_weight_details on tbl_international_booking.booking_id=tbl_international_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_international_booking.sender_city INNER JOIN zone_master recievercity ON recievercity.z_id = tbl_international_booking.reciever_country_id where pod_no = '$pod_no'");
			$data['info'] = $reAct->row();

			$courier_company_id = $data['info']->courier_company_id;

			$tracking_href_details = $this->db->query("select * from courier_company where c_id=" . $courier_company_id);
			$data['forwording_track'] = $tracking_href_details->row();


			$reAct = $this->db->query("select * from tbl_international_tracking where status='Out For Delivery' AND pod_no = '$pod_no' ORDER BY id DESC");
			$data['pod'] = $reAct->row();
			$data['del_status'] = $reAct->row();
		} else {
			$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id left join city sendercity ON sendercity.id = tbl_domestic_booking.sender_city left join city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where  pod_no = '$pod_no' ");
			// $reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where  pod_no = '$pod_no' ");
			// echo $this->db->last_query();die;
			$data['info'] = $reAct->row();

			if (!empty($data['info'])) {
				$courier_company_id = $data['info']->courier_company_id;
				$tracking_href_details = $this->db->query("select * from courier_company where c_id= '$courier_company_id'");
				$data['forwording_track'] = $tracking_href_details->row();
			} else {
				$data['forwording_track'] = array();
			}


			$resAct5 = $this->db->query("select * from tbl_domestic_tracking where  pod_no = '$pod_no' ORDER BY id DESC");
			$dd = $resAct5->row();
			$data['pod'] = array();

			// print_r($dd);
			if (!empty($dd) && $dd->status == 'Out For Delivery') {
				//$data['info'] = array();
			} else {
				$reAct = $this->db->query("select * from tbl_domestic_menifiest where pod_no = '$pod_no' ORDER BY id DESC");

				$dd1 = $reAct->row();

				if (!empty($dd) && !empty($dd1)) {
					if ($dd1->reciving_status == 1) {
						$data['pod'] = $resAct5->result();
					} else {
						$data['pod'] = array();
						//$data['info'] = array();
					}
				} else {
					$data['pod'] = $resAct5->result();
				}
			}

			$data['del_status'] = $resAct5->row();
		}

		// echo $this->db->last_query();exit();
		if (!empty($data['info'])) {
			if (!empty($data['pod'])) {
				foreach ($data['pod'] as $k => $values) {
					// print_r($values);
					if ($values->status == 'DELIVERED' || $values->status == 'Delivered') {
						$data['delivery_date'] = $values->tracking_date;
					}
				}
			}

			$dataa = json_decode(json_encode($data), true);

			$mode_info = $this->db->query("select * from transfer_mode where transfer_mode_id = '" . @$dataa['info']['mode_dispatch'] . "'");

			$mode_result = $mode_info->row();
			$modeDispach = $mode_result->mode_name;

			$trankingdata = [];
			foreach ($dataa['pod'] as $trackinfo) {
				$status = $trackinfo['status'];
				if ($trackinfo['comment']) {
					$status = $status . '-' . $trackinfo['comment'];
				}
				$trankingdata[] = array(
					'date' => $trackinfo['tracking_date'],
					'status' => $status,
					'location' => $trackinfo['branch_name']
				);
			}

			$resultarr['tracking_data'] = array(
				'del_status' => @$data['del_status'],
				'pod_no' => @$dataa['info']['pod_no'],
				'booking_date' => @$dataa['info']['booking_date'],
				'origin' => @$dataa['info']['sender_city_name'],
				'destination' => @$dataa['info']['reciever_country_name'],
				'mode' => @$modeDispach,
				'nop' => @$dataa['info']['no_of_pack'],
				'sender_name' => @$dataa['info']['sender_name'],
				'sender_address' => @$dataa['info']['sender_address'],
				'reciever_name' => @$dataa['info']['reciever_name'],
				'reciever_address' => @$dataa['info']['reciever_address'],
				'actual_weight' => @$dataa['info']['actual_weight'],
				'status' => @$dataa['del_status']['status'],
			);
			$resultarr['result'] = "success";
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Airway number not found";
		}

		echo json_encode($resultarr);
	}
	public function getbarcode()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pod_no = $request->awnno;
		$user_id = $request->user_id;


		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$username = $res->row()->username;
		$date = date('y-m-d');

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$check_pod_international = $this->db->query("select pod_no from tbl_international_booking where pod_no = '$pod_no'");
		$check_result = $check_pod_international->row();

		if (isset($check_result)) {
			$reAct = $this->db->query("select tbl_international_booking.*,tbl_international_booking.invoice_no,tbl_international_weight_details.no_of_pack,tbl_international_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.country_name as reciever_country_name from tbl_international_booking left join tbl_international_weight_details on tbl_international_booking.booking_id=tbl_international_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_international_booking.sender_city INNER JOIN zone_master recievercity ON recievercity.z_id = tbl_international_booking.reciever_country_id where pod_no = '$pod_no'");
			$data['info'] = $reAct->row();

			$courier_company_id = $data['info']->courier_company_id;

			$tracking_href_details = $this->db->query("select * from courier_company where c_id=" . $courier_company_id);
			$data['forwording_track'] = $tracking_href_details->row();


			$reAct = $this->db->query("select * from tbl_international_tracking where status='Out For Delivery' AND pod_no = '$pod_no' ORDER BY id DESC");
			$data['pod'] = $reAct->row();
			$data['del_status'] = $reAct->row();
		} else {
			$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_booking.invoice_no,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id left join city sendercity ON sendercity.id = tbl_domestic_booking.sender_city left join city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where  pod_no = '$pod_no' ");
			// $reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where  pod_no = '$pod_no' ");
			// echo $this->db->last_query();die;
			$data['info'] = $reAct->row();

			if (!empty($data['info'])) {
				$courier_company_id = $data['info']->courier_company_id;
				$tracking_href_details = $this->db->query("select * from courier_company where c_id= '$courier_company_id'");
				$data['forwording_track'] = $tracking_href_details->row();
			} else {
				$data['forwording_track'] = array();
			}


			$resAct5 = $this->db->query("select * from tbl_domestic_tracking where  pod_no = '$pod_no' ORDER BY id DESC");
			$dd = $resAct5->row();
			$data['pod'] = $resAct5->result();
			$data['del_status'] = $resAct5->row();
		}

		// echo $this->db->last_query();exit();
		if (!empty($data['info'])) {
			if (!empty($data['pod'])) {
				foreach ($data['pod'] as $k => $values) {
					// print_r($values);
					if ($values->status == 'DELIVERED' || $values->status == 'Delivered') {
						$data['delivery_date'] = $values->tracking_date;
					}
				}
			}

			$dataa = json_decode(json_encode($data), true);

			$mode_info = $this->db->query("select * from transfer_mode where transfer_mode_id = '" . @$dataa['info']['mode_dispatch'] . "'");

			$mode_result = $mode_info->row();
			$modeDispach = $mode_result->mode_name;

			$trankingdata = [];
			foreach ($dataa['pod'] as $trackinfo) {
				$status = $trackinfo['status'];
				if ($trackinfo['comment']) {
					$status = $status . '-' . $trackinfo['comment'];
				}
				$trankingdata[] = array(
					'date' => $trackinfo['tracking_date'],
					'status' => $status,
					'location' => $trackinfo['branch_name']
				);
			}

			$resultarr['tracking_data'] = array(
				'del_status' => @$data['del_status'],
				'pod_no' => @$dataa['info']['pod_no'],
				'booking_date' => @$dataa['info']['booking_date'],
				'origin' => @$dataa['info']['sender_city_name'],
				'destination' => @$dataa['info']['reciever_country_name'],
				'mode' => @$modeDispach,
				'nop' => @$dataa['info']['no_of_pack'],
				'sender_name' => @$dataa['info']['sender_name'],
				'sender_address' => @$dataa['info']['sender_address'],
				'reciever_name' => @$dataa['info']['reciever_name'],
				'reciever_address' => @$dataa['info']['reciever_address'],
				'actual_weight' => @$dataa['info']['actual_weight'],
				'status' => @$dataa['del_status']['status'],
				'invoice_no' => @$dataa['info']['invoice_no'],
			);
			$resultarr['result'] = "success";
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Airway number not found";
		}

		echo json_encode($resultarr);
	}
	public function pickup_awb_scan()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$awb = $request->awnno;
		$user_id = $request->user_id;
		$user_type = $this->session->userdata("userType");
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		//    print_r($branch_id);die;
		$resAct5 = $this->db->query("select tbl_domestic_booking.pod_no from tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no where tbl_domestic_booking.pod_no = '$awb' AND tbl_domestic_booking.pickup_in_scan = '0' AND tbl_domestic_booking.branch_in_scan = '0' and tbl_domestic_stock_history.booked = '1' and tbl_domestic_stock_history.pickup_in_scan = '0' and tbl_domestic_stock_history.branch_in_scan = '0' and tbl_domestic_stock_history.current_branch = '$branch_id'");
		// echo  $this->db->last_query();die;
		$data['result'] = $resAct5->row_array();



		if (empty($data['result'])) {
			$data['result'] = "fail";
			$data['message'] = "Airway number not found";
		} else {
			echo json_encode($data);
		}

	}
	public function branch_awb_scan()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$awb = $request->awnno;
		$user_id = $request->user_id;
		$user_type = $this->session->userdata("userType");
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		//    print_r($branch_id);die;
		$resAct5 = $this->db->query("select tbl_domestic_booking.pod_no from tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no where tbl_domestic_booking.pod_no = '$awb' AND tbl_domestic_booking.pickup_in_scan = '1' AND tbl_domestic_booking.branch_in_scan = '0' and tbl_domestic_stock_history.booked = '1' and tbl_domestic_stock_history.pickup_in_scan = '1' and tbl_domestic_stock_history.branch_in_scan = '0' and tbl_domestic_stock_history.current_branch = '$branch_id'");
		// echo  $this->db->last_query();die;
		$data['result'] = $resAct5->row_array();



		if (empty($data['result'])) {
			$data['result'] = "fail";
			$data['message'] = "Airway number not found";
		} else {
			echo json_encode($data);
		}

	}

	// bag scan 
	public function check_airways_num()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$awn_query = $this->db->query("SELECT `tbl_domestic_booking`.`pod_no` FROM `tbl_domestic_booking` WHERE pod_no='" . $request->airways_number . "'");
		// print_r($awn_query); die;
		if ($awn_query->num_rows() > 0) {
			$data['status'] = false;
			$data['result'] = 'fail';
			$data['message'] = 'Airways number already exists, please try another';
		} else {
			$data['status'] = true;
			$data['result'] = 'success';
			$data['message'] = 'Airways number not present';
		}
		echo json_encode($data);
	}
	public function bag_awb_scan()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$forwording_no = $request->awnno;
		$user_id = $request->user_id;
		$user_type = $this->session->userdata("userType");
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no where tbl_domestic_booking.pod_no = '$forwording_no' and tbl_domestic_booking.is_delhivery_complete = '0' and tbl_domestic_booking.branch_in_scan ='1' and tbl_domestic_stock_history.pickup_in_scan ='1' and tbl_domestic_stock_history.branch_in_scan = '1' and tbl_domestic_stock_history.bag_genrated = '0' and tbl_domestic_stock_history.delivery_sheet = '0' and tbl_domestic_stock_history.menifest_Inscan = '0' and tbl_domestic_stock_history.gatepass_inscan = '0'  and tbl_domestic_stock_history.current_branch = '$branch_id' limit 1");
		$data['result'] = $resAct5->row_array();

		if (empty($data['result'])) {
			$data['result'] = "fail";
			$data['message'] = "Airway number not found";
		} else {
			echo json_encode($data);
		}

	}
	public function pickup_in_scan_status_insert()
	{


		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$awb = $request->pod_no;
		$user_id = $request->user_id;

		// print_r($request);die;
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_id = $res->row()->user_id;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		date_default_timezone_set('Asia/Kolkata');
		$timestamp = date("Y-m-d H:i:s");

		if (!empty($awb)) {
			$where = array('pod_no' => $awb);
			$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $where);
			$all_data['pod_no'] = $awb;
			$all_data['booking_id'] = $data['result'][0]['booking_id'];
			$all_data['forwording_no'] = $data['result'][0]['forwording_no'];
			$all_data['forworder_name'] = $data['result'][0]['forworder_name'];
			$all_data['branch_name'] = $source_branch;
			$all_data['status'] = 'Pickup-In-scan';
			$all_data['remarks'] = $request->remarks;
			$all_data['tracking_date'] = $timestamp;
			$this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);

			$queue_dataa = "update tbl_domestic_booking set pickup_in_scan ='1' , branch_in_scan = '0'  where pod_no = '$awb'";
			$status = $this->db->query($queue_dataa);
			$queue_dataa1 = "update tbl_domestic_stock_history set pickup_in_scan ='1' , branch_in_scan = '0' where pod_no = '$awb'";
			$status = $this->db->query($queue_dataa1);

			$array_data[] = $all_data;
		}


		if ($status) {
			$resultarr['result'] = "Pickup Scanning successfully";
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Airway number not found";
		}
		echo json_encode($resultarr);
	}
	public function branch_in_scan_status_insert()
	{


		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$awb = $request->pod_no;
		$user_id = $request->user_id;

		// print_r($request);die;
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_id = $res->row()->user_id;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		date_default_timezone_set('Asia/Kolkata');
		$timestamp = date("Y-m-d H:i:s");

		if (!empty($awb)) {
			$where = array('pod_no' => $awb);
			$data['result'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $where);
			$all_data['pod_no'] = $awb;
			$all_data['booking_id'] = $data['result'][0]['booking_id'];
			$all_data['forwording_no'] = $data['result'][0]['forwording_no'];
			$all_data['forworder_name'] = $data['result'][0]['forworder_name'];
			$all_data['branch_name'] = $source_branch;
			$all_data['status'] = 'In-Scan-Branch';
			$all_data['remarks'] = $request->remarks;
			$all_data['tracking_date'] = $timestamp;
			$this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);

			$queue_dataa = "update tbl_domestic_booking set pickup_in_scan ='1' , branch_in_scan = '1'  where pod_no = '$awb'";
			$status = $this->db->query($queue_dataa);
			$queue_dataa1 = "update tbl_domestic_stock_history set pickup_in_scan ='1' , branch_in_scan = '1' where pod_no = '$awb'";
			$status = $this->db->query($queue_dataa1);

			$array_data[] = $all_data;
		}


		if ($status) {
			$resultarr['result'] = "Branch Scanning successfully";
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Airway number not found";
		}
		echo json_encode($resultarr);
	}

	public function check_shipment_for_update()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pod_no = $request->awnno;
		$user_id = $request->user_id;


		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$username = $res->row()->username;
		$date = date('y-m-d');

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$check_pod_international = $this->db->query("select pod_no from tbl_international_booking where pod_no = '$pod_no'");
		$check_result = $check_pod_international->row();

		if (isset($check_result)) {
			$reAct = $this->db->query("select tbl_international_booking.*,tbl_international_weight_details.no_of_pack,tbl_international_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.country_name as reciever_country_name from tbl_international_booking left join tbl_international_weight_details on tbl_international_booking.booking_id=tbl_international_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_international_booking.sender_city INNER JOIN zone_master recievercity ON recievercity.z_id = tbl_international_booking.reciever_country_id where pod_no = '$pod_no' AND is_delhivery_complete=0");
			$data['info'] = $reAct->row();

			$courier_company_id = $data['info']->courier_company_id;

			$tracking_href_details = $this->db->query("select * from courier_company where c_id=" . $courier_company_id);
			$data['forwording_track'] = $tracking_href_details->row();


			$reAct = $this->db->query("select * from tbl_international_tracking where status='Out For Delivery' AND pod_no = '$pod_no' AND branch_name='$branch_name' ORDER BY id DESC");
			$data['pod'] = $reAct->row();
			$data['del_status'] = $reAct->row();
		} else {
			$reAct = $this->db->query("select tbl_domestic_booking.*,tbl_domestic_weight_details.no_of_pack,tbl_domestic_weight_details.actual_weight, sendercity.city AS sender_city_name, recievercity.city as reciever_country_name from tbl_domestic_booking left join tbl_domestic_weight_details on tbl_domestic_booking.booking_id=tbl_domestic_weight_details.booking_id INNER JOIN city sendercity ON sendercity.id = tbl_domestic_booking.sender_city INNER JOIN city recievercity ON recievercity.id = tbl_domestic_booking.reciever_city where  pod_no = '$pod_no' AND is_delhivery_complete=0");
			$data['info'] = $reAct->row();

			if (!empty($data['info'])) {
				$courier_company_id = $data['info']->courier_company_id;
				$tracking_href_details = $this->db->query("select * from courier_company where c_id=" . $courier_company_id);
				$data['forwording_track'] = $tracking_href_details->row();
			} else {
				$data['forwording_track'] = array();
			}



			// $reAct=$this->db->query("select * from tbl_domestic_tracking where status='Delivered' AND pod_no = '$pod_no' ORDER BY id DESC limit 1");
			$reAct = $this->db->query("select * from tbl_domestic_tracking where status='Out for Delivery' AND pod_no = '$pod_no' AND branch_name='$branch_name' ORDER BY id DESC limit 1");
			$data['pod'] = $reAct->result();

			if (!$data['pod']) {
				// $reAct=$this->db->query("select * from tbl_domestic_tracking where pod_no = '$pod_no' ORDER BY id DESC limit 1");
				// $data['pod']	=	$reAct->result();
				// $data['pod'] = array();
			} else {
				$data['pod'] = array();
			}


			$data['del_status'] = $reAct->row();
		}

		// echo $this->db->last_query();exit();

		if (!empty($data['pod'])) {
			foreach ($data['pod'] as $k => $values) {
				// print_r($values);
				if ($values->status == 'DELIVERED' || $values->status == 'Delivered') {
					$data['delivery_date'] = $values->tracking_date;
				}
			}
		}

		$dataa = json_decode(json_encode($data), true);

		$modeDispach = 'Air';
		if ($dataa['info']['mode_dispatch'] == '2') {
			$modeDispach = 'Train';
		}
		if ($dataa['info']['mode_dispatch'] == '2') {
			$modeDispach = 'Surface';
		}

		// print_r($dataa);
		$trankingdata = [];
		foreach ($dataa['pod'] as $trackinfo) {
			$status = $trackinfo['status'];
			if ($trackinfo['comment']) {
				$status = $status . '-' . $trackinfo['comment'];
			}
			$trankingdata[] = array(
				'date' => $trackinfo['tracking_date'],
				'status' => $status,
				'location' => $trackinfo['branch_name']
			);
		}

		// echo "<pre>";
		// print_r($dataa['pod']);
		// no_of_pack
		// actual_weight


		$resultarr['tracking_data'] = array(
			'del_status' => $data['del_status'],
			'pod_no' => $dataa['info']['pod_no'],
			'booking_date' => $dataa['info']['booking_date'],
			'origin' => $dataa['info']['sender_city_name'],
			'destination' => $dataa['info']['reciever_country_name'],
			'mode' => $modeDispach,
			'nop' => $dataa['info']['no_of_pack'],
			'sender_name' => $dataa['info']['sender_name'],
			'sender_address' => $dataa['info']['sender_address'],
			'reciever_name' => $dataa['info']['reciever_name'],
			'reciever_address' => $dataa['info']['reciever_address'],
			'actual_weight' => $dataa['info']['actual_weight'],
			// 'status'=>@$dataa['pod'][0]['status'],
			'status' => @$data['del_status']->status,
		);

		if ($dataa['info']['pod_no']) {
			$resultarr['result'] = "success";
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Airway number not found";
		}
		echo json_encode($resultarr);

		die;
	}
	public function branchlocator()
	{
		$data = array();

		$reAct1 = $this->db->query("select * from tbl_branch,state,city where tbl_branch.city=city.id and tbl_branch.state=state.id");

		if ($reAct1->num_rows() > 0) {
			$data['result'] = "success";

			$data['branch'] = $reAct1->result();
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Branch Available";
		}
		echo json_encode($data);
	}









	///////////////////////////OLD APIS//////////////////////////////////

	public function index()
	{
		if ($this->session->userdata("userName") != "") {

			$data = array();
			$whrAct = array('iseleted' => 0);
			$resAct = $this->basic_operation_m->getAll('users', '');

			if ($resAct->num_rows() > 0) {
				$data['alleventsdata'] = $resAct->result_array();
			}
			$this->load->view('allusers', $data);
		} else {
			redirect(base_url() . 'login');
		}
	}


	public function counterStatus()
	{
		$date = date('Y-m-d');
		$data['cnt_delivery'] = 0;
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$data = array();
		$whrAct = array('isactive' => 1, 'isdeleted' => 0);

		$TodayresAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.branch_id='$branch_id' and date_format(booking_date, '%Y-%m-%d') = '" . date('Y-m-d') . "'");
		$data['todayshipment'] = ($TodayresAct->num_rows() > 0) ? $TodayresAct->row()->totalshipment : 0;
		$resAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.branch_id='$branch_id'");
		$data['totalshipment'] = ($resAct->num_rows() > 0) ? $resAct->row()->totalshipment : 0;
		$PendingresAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.branch_id='$branch_id' and status = 0");

		$data['pendingshipment'] = ($PendingresAct->num_rows() > 0) ? $PendingresAct->row()->totalshipment : 0;

		echo json_encode($data);
		exit;
	}

	public function counterStatusByCustomer()
	{
		$date = date('Y-m-d');
		$data['cnt_delivery'] = 0;
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$customer_id = !empty($request->customer_id) ? $request->customer_id : $this->input->post('customer_id');
		$data = array();

		$TodayresAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.customer_id='$customer_id' and date_format(booking_date, '%Y-%m-%d') = '" . date('Y-m-d') . "'");
		$data['todayshipment'] = ($TodayresAct->num_rows() > 0) ? $TodayresAct->row()->totalshipment : 0;
		$resAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.customer_id='" . $customer_id . "' ");

		$check_result = $resAct->row();

		// print_r($check_result);
		$data['totalshipment'] = ($check_result) ? $check_result->totalshipment : 0;
		$PendingresAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.customer_id='$customer_id' and status = 0");
		$data['pendingshipment'] = ($PendingresAct->num_rows() > 0) ? $PendingresAct->row()->totalshipment : 0;
		echo json_encode($data);
		exit;
	}

	public function signup()
	{

		$data = array();

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		if (!empty($request->uname) && !empty($request->email) && !empty($request->password)) {

			$query = $this->db->query("insert into users values('','$request->uname','$request->email','','$request->password','$request->sname','','','$request->gyear','0','1','')");

			if ($this->db->affected_rows() > 0) {
				$insertId = $this->db->insert_id();
				$query = $this->db->query("insert into user_notification_setting values('','$insertId','1 Day','1','0' )");
				$data['result'] = "success";
			} else {
				$data['result'] = "fail";
			}
		} else {
			$data['result'] = "fail";
		}
		echo json_encode($data);
	}

	/*public function addBooking() {
			   $postdata = file_get_contents("php://input");
			   $request = json_decode($postdata);
			   
			   $username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');
			   $whr = array('username' => $username);
			   $res = $this->basic_operation_m->getAll('tbl_users', $whr);
			   $branch_id = $res->row()->branch_id;
			  
			 $d = !empty($request->booking_date) ? $request->booking_date : $this->input->post('booking_date');
			   $date = date('Y-m-d H:i:s',strtotime($d));
			   //booking details//
			   $data = array(
				   'booking_id' => "",
				   'sender_name' => !empty($request->sender_name) ? $request->sender_name : $this->input->post('sender_name'),
				   'sender_address' => !empty($request->sender_address) ? $request->sender_address : $this->input->post('sender_address'),
				   'sender_city' => !empty($request->sender_city) ? $request->sender_city : $this->input->post('sender_city'),
				   'sender_pincode' => !empty($request->sender_pincode) ? $request->sender_pincode : $this->input->post('sender_pincode'),
				   'sender_contactno' => !empty($request->sender_contactno) ? $request->sender_contactno : $this->input->post('sender_contactno'),
				   'sender_gstno' => !empty($request->sender_contactno) ? $request->sender_contactno : $this->input->post('sender_gstno'),
				   'reciever_name' => !empty($request->reciever_name) ? $request->reciever_name : $this->input->post('reciever_name'),
				   'reciever_address' => !empty($request->reciever_address) ? $request->reciever_address : $this->input->post('reciever_address'),
				   'reciever_city' => !empty($request->reciever_city) ? $request->reciever_city : $this->input->post('reciever_city'),
				   'reciever_pincode' =>!empty($request->reciever_pincode) ? $request->reciever_pincode :  $this->input->post('reciever_pincode'),
				   'reciever_contact' =>!empty($request->reciever_contact) ? $request->reciever_contact :  $this->input->post('reciever_contact'),
				   'receiver_gstno' => !empty($request->receiver_gstno) ? $request->receiver_gstno : $this->input->post('receiver_gstno'),
				   'booking_date' =>$date,
				   'delivery_date' => !empty($request->delivery_date) ? $request->delivery_date : $this->input->post('delivery_date'),
				   'mode_dispatch' => !empty($request-mode_dispatch) ? $request->mode_dispatch : $this->input->post('mode_dispatch'),
				   'dispatch_details' => !empty($request->dispatch_details) ? $request->dispatch_details : $this->input->post('dispatch_details'),
				   'insurace_policyno' => !empty($request->insurace_policyno) ? $request->insurace_policyno : $this->input->post('insurace_policyno'),
				   'forwording_no' => !empty($request->forwording_no) ? $request->forwording_no : $this->input->post('forwording_no'),
				   'forworder_name' => !empty($request->forworder_name) ? $request->forworder_name : $this->input->post('forworder_name'),
				   'pod_no' => !empty($request->awn) ? $request->awn : $this->input->post('awn'),
				   'branch_id' => $branch_id,
				   'customer_id' =>!empty($request->customer_account_id) ? $request->customer_account_id :  $this->input->post('customer_account_id'),
				   'gst_charges' => !empty($request->gst_charges) ? $request->gst_charges: $this->input->post('gst_charges'),
				   'status' => !empty($request->status) ? $request->status : 0,
				   'booking_type' => 2
				   );
	   
			   $query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);
			   
			   $lastid = $this->db->insert_id();
			   
			   $frieht = !empty($request->frieht) ? $request->frieht : $this->input->post('frieht');
			   $awb = !empty($request->awb) ? $request->awb : $this->input->post('awb');
			   $topay = !empty($request->to_pay) ? $request->to_pay : $this->input->post('to_pay');
			   $daoc = !empty($request->dod_daoc) ? $request->dod_daoc : $this->input->post('dod_daoc');
			   $loading = !empty($request->loading) ? $request->loading : $this->input->post('loading');
			   $packing = !empty($request->packing) ? $request->packing : $this->input->post('packing');
			   $handling = !empty($request->handling) ? $request->handling : $this->input->post('handling');
			   $oda = !empty($request->oda) ? $request->oda : $this->input->post('oda');
			   $insurance = !empty($request->insurance) ? $request->insurance : $this->input->post('insurance');
			   $fuel_subcharges = !empty($request->fuel_subcharges) ? $request->fuel_subcharges :  $this->input->post('fuel_subcharges');
			   $data1 = array(
				   'payment_id' => '',
				   'booking_id' => $lastid,
				   'amount' => !empty($request->amount) ? $request->amount : $this->input->post('amount'),
				   'frieht' => !empty($request->frieht) ? $request->frieht : $this->input->post('frieht'),
				   'awb' => !empty($request->awb) ? $request->awb : $this->input->post('awb'),
				   'to_pay' => !empty($request->to_pay) ? $request->to_pay :  $this->input->post('to_pay'),
				   'dod_daoc' => !empty($request->dod_daoc) ? $request->dod_daoc :  $this->input->post('dod_daoc'),
				   'loading' => !empty($request->loading) ? $request->loading : $this->input->post('loading'),
				   'packing' => !empty($request->packing) ? $request->packing : $this->input->post('packing'),
				   'handling' => !empty($request->handling) ? $request->handling : $this->input->post('handling'),
				   'oda' => !empty($request->oda) ? $request->oda : $this->input->post('oda'),
				   'insurance' => !empty($request->insurance) ? $request->insurance : $this->input->post('insurance'),
				   'fuel_subcharges' => !empty($request->fuel_subcharges) ? $request->fuel_subcharges :  $this->input->post('fuel_subcharges'),
				   'IGST' => !empty($request->igst) ? $request->igst :  $this->input->post('igst'),
				   'CGST' => !empty($request->cgst) ? $request->cgst : $this->input->post('cgst'),
				   'SGST' => !empty($request->sgst) ? $request->sgst :  $this->input->post('sgst'),
				   'total_amount' => !empty($request->frieht) ? $request->frieht :  $this->input->post('frieht'),
				   );
			   $length = !empty($request->length) ? $request->length : $this->input->post('length');
			   $breath = !empty($request->breath) ? $request->breath : $this->input->post('breath');
			   $height = !empty($request->height) ? $request->height :  $this->input->post('height');
			   $no_of_pack = !empty($request->no_of_pack) ? $request->no_of_pack : $this->input->post('no_of_pack');
			   if($no_of_pack == ''){
				   $no_of_pack = 1;
			   }
			   
			   $one_cft_kg = !empty($request->one_cft_kg) ? $request->one_cft_kg :  $this->input->post('one_cft_kg');
			  
			   $data2 = array(
				   'weight_details_id' => '',
				   'booking_id' => $lastid,
				   'actual_weight' => !empty($request->actual_weight) ? $request->actual_weight : $this->input->post('actual_weight'),
				   'valumetric_weight' => !empty($request->valumetric_weight) ? $request->valumetric_weight : $this->input->post('valumetric_weight'),
				   'length' => !empty($request->length) ? $request->length : $this->input->post('length'),
				   'breath' => !empty($request->breath) ? $request->breath : $this->input->post('breath'),
				   'height' => !empty($request->height) ? $request->height : $this->input->post('height'),
				   'one_cft_kg' => !empty($request->one_cft_kg) ? $request->one_cft_kg : $this->input->post('one_cft_kg'),
				   'chargable_weight' => !empty($request->chargable_weight) ? $request->chargable_weight : $this->input->post('chargable_weight'),
				   'rate' => !empty($request->rate) ? $request->rate : $this->input->post('rate'),
				   'rate_type' => !empty($request->rate_type) ? $request->rate_type : $this->input->post('rate_type'),
				   'rate_pack' => !empty($request->rate_pack) ? $request->rate_pack : $this->input->post('rate_pack'),
				   'no_of_pack' => !empty($request->no_of_pack) ? $request->no_of_pack : $this->input->post('no_of_pack'),
				   'type_of_pack' => !empty($request->type_of_pack) ? $request->type_of_pack : $this->input->post('type_of_pack'),
				   'special_instruction' => !empty($request->special_instruction) ? $request->special_instruction : $this->input->post('special_instruction'),
			   );
	   
			   $query1 = $this->basic_operation_m->insert('tbl_charges', $data1);
			   
			   $query2 = $this->basic_operation_m->insert('tbl_weight_details', $data2);
		   
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
			   $data3 = array('id' => '',
				   'pod_no' => $podno,
				   'status' => 'booked',
				   'branch_name' => $branch_name,
				   'tracking_date' => $date,
				   );
		   
			   $result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
		   
		   
			   if ($this->db->affected_rows() > 0) {
				   $data['message'] = "Booking added successfull";
			   } else {
				   $data['message'] = "Failed to Submit";
			   }
			   echo json_encode($data);	 
			   exit;
		  
		   } */

	/*   public function counterStatus() {
			   $date = date('Y-m-d');
			   $data['cnt_delivery'] = 0;
			   $postdata = file_get_contents("php://input");
			   $request = json_decode($postdata);
			   
			   $username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');
			   $whr = array('username' => $username);
			   $res = $this->basic_operation_m->getAll('tbl_users', $whr);
			   $branch_id = $res->row()->branch_id;
				   $data = array();
				   $whrAct = array('isactive' => 1, 'isdeleted' => 0);

				   $TodayresAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.branch_id='$branch_id' and date_format(booking_date, '%Y-%m-%d') = '" . date('Y-m-d') . "'");
					   $data['todayshipment'] = ($TodayresAct->num_rows() > 0) ? $TodayresAct->row()->totalshipment : 0;
				   $resAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.branch_id='$branch_id'");
				  $data['totalshipment'] = ($resAct->num_rows() > 0) ? $resAct->row()->totalshipment : 0;
				   $PendingresAct = $this->db->query("select count(*) as totalshipment from tbl_domestic_booking where tbl_domestic_booking.branch_id='$branch_id' and status = 0");
		   
					   $data['pendingshipment'] = ($PendingresAct->num_rows() > 0) ? $PendingresAct->row()->totalshipment : 0;
				
					echo json_encode($data);	 
			   exit;
		   }

   */


	public function uploadpod()
	{
		$data1 = array();
		$date = date('y-m-d');
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pod_no = $request->awnno;
		$username = $request->username;
		$image = $request->imagedata;
		$image = str_replace('data:image/png;base64,', '', $image);
		$image = str_replace(' ', '+', $image);
		$data = base64_decode($image);
		$filename = 'pod_' . $pod_no . '.png';
		$filepath = 'admin/uploads/pod/' . $filename;
		$success = file_put_contents($filepath, $data);
		$r = array(
			'id' => '',
			'deliveryboy_id' => $username,
			'pod_no' => $pod_no,
			'image' => $filename,
			'delivery_date' => $date
		);

		$this->basic_operation_m->insert('tbl_upload_pod', $r);
		$lastid = $this->db->insert_id();

		if ($lastid > 0) {
			$data1['result'] = "success";
			$data1['message'] = "POD Uploaded Successfully";
		} else {
			$data1['result'] = "fail";
			$data1['message'] = "Error Try Again";
		}
		echo json_encode($data1);
	}


	public function menifiestTracking()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$menifiest_id = !empty($request->menifiest_id) ? $request->menifiest_id : $this->input->post('menifiest_id');
		$data = array();
		$resAct = $this->db->query("select tbl_domestic_menifiest.manifiest_id ,tbl_domestic_bag.bag_id as pod_no,tbl_domestic_menifiest.source_branch,tbl_domestic_menifiest.destination_branch,tbl_domestic_booking.sender_name,tbl_domestic_booking.sender_address
		,tbl_domestic_booking.reciever_name,tbl_domestic_booking.reciever_address,tbl_domestic_booking.booking_date,tbl_domestic_booking.branch_id,rec_pincode ,tbl_domestic_weight_details.no_of_pack as total_pcs,tbl_domestic_weight_details.actual_weight as total_weight
		from tbl_domestic_menifiest
		INNER JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id=tbl_domestic_menifiest.bag_no 
		INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no=tbl_domestic_bag.pod_no 
		INNER JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id
		where tbl_domestic_menifiest.manifiest_id='$menifiest_id' AND tbl_domestic_menifiest.reciving_status=0");
		$data['manifiest'] = $resAct->result_array();
		echo json_encode($data);
		exit;
	}
	public function bagTracking()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$menifiest_id = !empty($request->bag_id) ? $request->bag_id : $this->input->post('bag_id');
		$data = array();
		$resAct = $this->db->query("select tbl_domestic_menifiest.manifiest_id ,tbl_domestic_bag.pod_no as pod_no,tbl_domestic_menifiest.source_branch,tbl_domestic_menifiest.destination_branch,tbl_domestic_booking.sender_name,tbl_domestic_booking.sender_address
		,tbl_domestic_booking.reciever_name,tbl_domestic_booking.reciever_address,tbl_domestic_booking.booking_date,tbl_domestic_booking.branch_id,rec_pincode ,tbl_domestic_weight_details.no_of_pack as total_pcs,tbl_domestic_weight_details.actual_weight as total_weight
		from tbl_domestic_menifiest
		INNER JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id=tbl_domestic_menifiest.bag_no 
		INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no=tbl_domestic_bag.pod_no 
		INNER JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id
		where tbl_domestic_bag.bag_id='$menifiest_id'");
		// echo $this->db->last_query();
		// print_r($menifiest_id);die;
		$data['manifiest'] = $resAct->result_array();
		echo json_encode($data);
		exit;
	}


	public function getallbranchshipment()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$branch_id = !empty($request->branch_id) ? $request->branch_id : $this->input->post('branch_id');
		// $resAct = $this->db->query("select * from tbl_charges,tbl_domestic_booking,tbl_weight_details 
		// where tbl_charges.booking_id =tbl_domestic_booking.booking_id 
		// and tbl_weight_details.booking_id=tbl_charges.booking_id AND tbl_domestic_booking.branch_id='$branch_id'");

		$resAct = $this->db->query("select * from tbl_domestic_booking,tbl_domestic_weight_details 
			where  tbl_domestic_weight_details.booking_id=tbl_domestic_booking.booking_id AND tbl_domestic_booking.branch_id='$branch_id'");
		if ($resAct->num_rows() > 0) {
			$bookingData = [];
			$i = 0;
			foreach ($resAct->result_array() as $booking) {
				$region_query = $this->db->query("SELECT `state`.`region_id` FROM `state` join city ON `city`.`state_id` = `state`.`id` WHERE `city`.`id` = " . $booking['reciever_city']);
				$regioData = $region_query->row();
				$region_id = $regioData->region_id;
				$bookingData[$i]['pod_no'] = $booking['pod_no'];
				// 	$bookingData[$i]['booking_id'] = $booking['booking_id'];
				$bookingData[$i]['sender_name'] = $booking['sender_name'];
				// 	$bookingData[$i]['sender_address'] = $booking['sender_address'];
				$bookingData[$i]['sender_city'] = $booking['sender_city'];
				// 	$bookingData[$i]['sender_pincode'] = $booking['sender_pincode'];
				// 	$bookingData[$i]['sender_contactno'] = $booking['sender_contactno'];
				// 	$bookingData[$i]['sender_gstno'] = $booking['sender_gstno'];
				$bookingData[$i]['reciever_name'] = $booking['reciever_name'];
				// 	$bookingData[$i]['reciever_address'] = $booking['reciever_address'];
				$bookingData[$i]['reciever_city'] = $booking['reciever_city'];
				// 	$bookingData[$i]['reciever_pincode'] = $booking['reciever_pincode'];
				// 	$bookingData[$i]['reciever_contact'] = $booking['reciever_contact'];
				// 	$bookingData[$i]['receiver_gstno'] = $booking['receiver_gstno'];
				$bookingData[$i]['booking_date'] = $booking['booking_date'];
				$bookingData[$i]['mode_dispatch'] = $booking['mode_dispatch'];
				// 	$bookingData[$i]['dispatch_details'] = $booking['dispatch_details'];
				// 	$bookingData[$i]['insurace_policyno'] = $booking['insurace_policyno'];
				// 	$bookingData[$i]['forwording_no'] = $booking['forwording_no'];
				// 	$bookingData[$i]['forworder_name'] = $booking['forworder_name'];
				// 	$bookingData[$i]['weight_details_id'] = $booking['weight_details_id'];
				// 	$bookingData[$i]['payment_details_id'] = $booking['payment_details_id'];
				// 	$bookingData[$i]['branch_id'] = $booking['branch_id'];
				// 	$bookingData[$i]['customer_id'] = $booking['customer_id'];
				$bookingData[$i]['status'] = $booking['status'];
				// 	$bookingData[$i]['Box'] = $booking['type_of_pack'];
				// 	$bookingData[$i]['kg'] = $booking['actual_weight'];
				// 	$bookingData[$i]['zone'] = $region_id;
				// 	$bookingData[$i]['EDD'] = $booking['delivery_date'];
				// 	$bookingData[$i]['frieht'] = $booking['frieht'];
				$i++;
			}
			$data['result'] = "success";
			$data['data'] = $bookingData;
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Shipment Available";
		}
		echo json_encode($data);
	}


	public function getallbranchshipmentbystatus()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$branch_id = !empty($request->branch_id) ? $request->branch_id : $this->input->post('branch_id');
		$status = !empty($request->status) ? $request->status : $this->input->post('status');
		$resAct = $this->db->query("select * from tbl_domestic_booking,tbl_domestic_weight_details,tbl_domestic_tracking 
			where  
			 tbl_domestic_weight_details.booking_id=tbl_domestic_booking.booking_id AND tbl_domestic_tracking.pod_no = tbl_domestic_booking.pod_no and tbl_domestic_booking.branch_id='" . $branch_id . "' and tbl_domestic_tracking.status='" . $status . "' ORDER BY `tbl_domestic_tracking`.`id` DESC");

		// echo $this->db->last_query();exit();
		if ($resAct->num_rows() > 0) {
			$bookingData = [];
			$i = 0;
			foreach ($resAct->result_array() as $booking) {
				$region_query = $this->db->query("SELECT `state`.`region_id` FROM `state` join city ON `city`.`state_id` = `state`.`id` WHERE `city`.`id` = " . $booking['reciever_city']);
				$regioData = $region_query->row();
				$region_id = $regioData->region_id;
				$bookingData[$i]['pod_no'] = $booking['pod_no'];
				// 	$bookingData[$i]['booking_id'] = $booking['booking_id'];
				$bookingData[$i]['sender_name'] = $booking['sender_name'];
				// 	$bookingData[$i]['sender_address'] = $booking['sender_address'];
				$bookingData[$i]['sender_city'] = $booking['sender_city'];
				// 	$bookingData[$i]['sender_pincode'] = $booking['sender_pincode'];
				// 	$bookingData[$i]['sender_contactno'] = $booking['sender_contactno'];
				// 	$bookingData[$i]['sender_gstno'] = $booking['sender_gstno'];
				$bookingData[$i]['reciever_name'] = $booking['reciever_name'];
				// 	$bookingData[$i]['reciever_address'] = $booking['reciever_address'];
				$bookingData[$i]['reciever_city'] = $booking['reciever_city'];
				// 	$bookingData[$i]['reciever_pincode'] = $booking['reciever_pincode'];
				// 	$bookingData[$i]['reciever_contact'] = $booking['reciever_contact'];
				// 	$bookingData[$i]['receiver_gstno'] = $booking['receiver_gstno'];
				$bookingData[$i]['booking_date'] = $booking['booking_date'];
				$bookingData[$i]['mode_dispatch'] = $booking['mode_dispatch'];
				// 	$bookingData[$i]['dispatch_details'] = $booking['dispatch_details'];
				// 	$bookingData[$i]['insurace_policyno'] = $booking['insurace_policyno'];
				// 	$bookingData[$i]['forwording_no'] = $booking['forwording_no'];
				// 	$bookingData[$i]['forworder_name'] = $booking['forworder_name'];
				// 	$bookingData[$i]['weight_details_id'] = $booking['weight_details_id'];
				// 	$bookingData[$i]['payment_details_id'] = $booking['payment_details_id'];
				// 	$bookingData[$i]['branch_id'] = $booking['branch_id'];
				// 	$bookingData[$i]['customer_id'] = $booking['customer_id'];
				$bookingData[$i]['status'] = $booking['status'];
				// 	$bookingData[$i]['Box'] = $booking['type_of_pack'];
				// 	$bookingData[$i]['kg'] = $booking['actual_weight'];
				// 	$bookingData[$i]['zone'] = $region_id;
				// 	$bookingData[$i]['EDD'] = $booking['delivery_date'];
				// 	$bookingData[$i]['frieht'] = $booking['frieht'];
				$i++;
			}
			$data['result'] = "success";
			$data['data'] = $bookingData;
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Shipment Available";
		}
		echo json_encode($data);
	}

	public function viewIncomingShipping()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');

		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$resAct = $this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' group by manifiest_id order by date_added DESC");
		// $resAct=$this->db->query("select * from tbl_domestic_menifiest JOIN tbl_domestic_bag on tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id join tbl_domestic_stock_history on tbl_domestic_bag.pod_no = tbl_domestic_stock_history.pod_no  where tbl_domestic_menifiest.destination_branch='$branch_name' and tbl_domestic_stock_history.gatepass_inscan= '1'");

		if ($resAct->num_rows() > 0) {
			$data['menifiest'] = $resAct->result();
		} else {
			$data['menifiest'] = array();
		}
		// $data['branch_name']=$branch_name;
		echo json_encode($data);
		exit;
	}
	public function addIncomingmanifest()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');

		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		// $resAct=$this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' group by manifiest_id order by date_added DESC");
		$resAct = $this->db->query("select * from tbl_domestic_menifiest JOIN tbl_domestic_bag on tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id join tbl_domestic_stock_history on tbl_domestic_bag.pod_no = tbl_domestic_stock_history.pod_no  where tbl_domestic_menifiest.destination_branch='$branch_name' and tbl_domestic_stock_history.gatepass_inscan= '1' and tbl_domestic_stock_history.menifest_Inscan = '0'");

		if ($resAct->num_rows() > 0) {
			$data['menifiest'] = $resAct->result();
		} else {
			$data['menifiest'] = array();
		}
		// $data['branch_name']=$branch_name;
		echo json_encode($data);
		exit;
	}
	public function addIncomingbag()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');

		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		// $resAct=$this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' group by manifiest_id order by date_added DESC");
		$resAct = $this->db->query("select distinct tbl_domestic_bag.bag_id AS bag_no,tbl_domestic_bag.date_added,tbl_domestic_bag.bag_recived from tbl_domestic_menifiest
		JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no
		JOIN tbl_domestic_stock_history ON tbl_domestic_stock_history.pod_no = tbl_domestic_bag.pod_no
where destination_branch='$branch_name' AND bag_recived = '0'  and tbl_domestic_stock_history.gatepass_genarte = '1' and tbl_domestic_stock_history.gatepass_inscan ='1' and tbl_domestic_stock_history.menifest_Inscan='1' GROUP BY tbl_domestic_bag.bag_id");

		if ($resAct->num_rows() > 0) {
			$data['menifiest'] = $resAct->result();
		} else {
			$data['menifiest'] = array();
		}
		// $data['branch_name']=$branch_name;
		echo json_encode($data);
		exit;
	}




	public function getallnewshipment()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$customer_id = $request->customer_id;
		$resAct = $this->db->query("select * from tbl_charges,tbl_domestic_booking,tbl_weight_details 
			where tbl_charges.booking_id =tbl_domestic_booking.booking_id 
			and tbl_weight_details.booking_id=tbl_charges.booking_id and tbl_domestic_booking.booking_type =2 ");
		if ($resAct->num_rows() > 0) {
			$bookingData = [];
			$i = 0;
			foreach ($resAct->result_array() as $booking) {
				if (is_numeric($booking['reciever_city'])) {
					$region_query = $this->db->query("SELECT `state`.`region_id` FROM `state` join city ON `city`.`state_id` = `state`.`id` WHERE `city`.`id` = '" . $booking['reciever_city'] . "'");
					$regioData = $region_query->row();
					$region_id = $regioData->region_id;
					$bookingData[$i]['pod_no'] = $booking['pod_no'];
					$bookingData[$i]['booking_id'] = $booking['booking_id'];
					$bookingData[$i]['sender_name'] = $booking['sender_name'];
					$bookingData[$i]['sender_address'] = $booking['sender_address'];
					$bookingData[$i]['sender_city'] = $booking['sender_city'];
					$bookingData[$i]['sender_pincode'] = $booking['sender_pincode'];
					$bookingData[$i]['sender_contactno'] = $booking['sender_contactno'];
					$bookingData[$i]['sender_gstno'] = $booking['sender_gstno'];
					$bookingData[$i]['reciever_name'] = $booking['reciever_name'];
					$bookingData[$i]['reciever_address'] = $booking['reciever_address'];
					$bookingData[$i]['reciever_city'] = $booking['reciever_city'];
					$bookingData[$i]['reciever_pincode'] = $booking['reciever_pincode'];
					$bookingData[$i]['reciever_contact'] = $booking['reciever_contact'];
					$bookingData[$i]['receiver_gstno'] = $booking['receiver_gstno'];
					$bookingData[$i]['booking_date'] = $booking['booking_date'];
					$bookingData[$i]['mode_dispatch'] = $booking['mode_dispatch'];
					$bookingData[$i]['dispatch_details'] = $booking['dispatch_details'];
					$bookingData[$i]['insurace_policyno'] = $booking['insurace_policyno'];
					$bookingData[$i]['forwording_no'] = $booking['forwording_no'];
					$bookingData[$i]['forworder_name'] = $booking['forworder_name'];
					$bookingData[$i]['weight_details_id'] = $booking['weight_details_id'];
					$bookingData[$i]['payment_details_id'] = $booking['payment_details_id'];
					$bookingData[$i]['branch_id'] = $booking['branch_id'];
					$bookingData[$i]['customer_id'] = $booking['customer_id'];
					$bookingData[$i]['status'] = $booking['status'];
					$bookingData[$i]['Box'] = $booking['type_of_pack'];
					$bookingData[$i]['kg'] = $booking['actual_weight'];
					$bookingData[$i]['zone'] = $region_id;
					$bookingData[$i]['EDD'] = $booking['delivery_date'];
					$bookingData[$i]['frieht'] = $booking['frieht'];
					$i++;
				}
			}
			$data['result'] = "success";
			$data['data'] = $bookingData;
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Shipment Available";
		}
		echo json_encode($data);
	}

	public function getallshipment()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$customer_id = $request->customer_id;
		$resAct = $this->db->query("select * from tbl_domestic_booking,tbl_domestic_weight_details 
			where tbl_domestic_weight_details.booking_id=tbl_domestic_booking.booking_id AND tbl_domestic_booking.customer_id='$customer_id'");
		if ($resAct->num_rows() > 0) {
			$bookingData = [];
			$i = 0;
			foreach ($resAct->result_array() as $booking) {
				$region_query = $this->db->query("SELECT `state`.`region_id` FROM `state` join city ON `city`.`state_id` = `state`.`id` WHERE `city`.`id` = " . $booking['reciever_city']);

				foreach ($booking as $key => $value) {
					if ($value == NULL || $value == 'null') {
						$booking[$key] = '';
					}
				}
				if (!isset($booking['insurace_policyno'])) {
					$booking['insurace_policyno'] = '';
				}
				if (!isset($booking['payment_details_id'])) {
					$booking['payment_details_id'] = '';
				}
				$regioData = $region_query->row();
				$region_id = $regioData->region_id;
				$bookingData[$i]['pod_no'] = $booking['pod_no'];
				$bookingData[$i]['booking_id'] = $booking['booking_id'];
				$bookingData[$i]['sender_name'] = $booking['sender_name'];
				$bookingData[$i]['sender_address'] = $booking['sender_address'];
				$bookingData[$i]['sender_city'] = $booking['sender_city'];
				$bookingData[$i]['sender_pincode'] = $booking['sender_pincode'];
				$bookingData[$i]['sender_contactno'] = $booking['sender_contactno'];
				$bookingData[$i]['sender_gstno'] = $booking['sender_gstno'];
				$bookingData[$i]['reciever_name'] = $booking['reciever_name'];
				$bookingData[$i]['reciever_address'] = $booking['reciever_address'];
				$bookingData[$i]['reciever_city'] = $booking['reciever_city'];
				$bookingData[$i]['reciever_pincode'] = $booking['reciever_pincode'];
				$bookingData[$i]['reciever_contact'] = $booking['reciever_contact'];
				$bookingData[$i]['receiver_gstno'] = $booking['receiver_gstno'];
				$bookingData[$i]['booking_date'] = $booking['booking_date'];
				$bookingData[$i]['mode_dispatch'] = $booking['mode_dispatch'];
				$bookingData[$i]['dispatch_details'] = $booking['dispatch_details'];
				$bookingData[$i]['insurace_policyno'] = @$booking['insurace_policyno'];
				$bookingData[$i]['forwording_no'] = $booking['forwording_no'];
				$bookingData[$i]['forworder_name'] = $booking['forworder_name'];
				$bookingData[$i]['weight_details_id'] = $booking['weight_details_id'];
				$bookingData[$i]['payment_details_id'] = @$booking['payment_details_id'];
				$bookingData[$i]['branch_id'] = $booking['branch_id'];
				$bookingData[$i]['customer_id'] = $booking['customer_id'];
				$bookingData[$i]['status'] = $booking['status'];
				$bookingData[$i]['Box'] = $booking['type_of_pack'];
				$bookingData[$i]['kg'] = $booking['actual_weight'];
				$bookingData[$i]['zone'] = $region_id;
				$bookingData[$i]['EDD'] = $booking['delivery_date'];
				$bookingData[$i]['frieht'] = $booking['frieht'];
				$i++;
			}
			$data['result'] = "success";
			$data['data'] = $bookingData;
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Shipment Available";
		}
		echo json_encode($data);
	}

	public function trackshipment()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if ($request->awnno == null) {

			$pod_no = $this->input->post('awnno');
		} else {
			$pod_no = $request->awnno;
		}

		$reAct = $this->db->query("select * from tbl_domestic_booking where pod_no='$pod_no'");

		if ($reAct->num_rows() > 0) {

			$reAct1 = $this->db->query("select * from tbl_domestic_tracking where pod_no='$pod_no'");


			$reAct2 = $this->db->query("select * from tbl_upload_pod where pod_no='$pod_no'");

			$data['result'] = "success";
			$data['data'] = array("bookinginfo" => $reAct->row(), "trackinfo" => $reAct1->result(), "imageinfo" => $reAct2->row());
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Tracking  Available";
		}
		echo json_encode($data);
	}



	public function getTrackingStatus()
	{
		$data = array();

		$reAct = $this->db->query("select status FROM tbl_status");

		if ($reAct->num_rows() > 0) {
			$result = $reAct->result_array();

			$data['result'] = "success";
			$data['data'] = array_column($result, 'status');
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Status Available";
		}
		echo json_encode($data);
	}

	public function updateStatus()
	{

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$pod_no = !empty($request->awnno) ? $request->awnno : $this->input->post('awnno');
		$status = !empty($request->status) ? $request->status : $this->input->post('status');
		$branch_id = !empty($request->branch_name) ? $request->branch_name : $this->input->post('branch_name');
		if (!empty($branch_id)) {
			$query = $this->db->query("SELECT branch_name FROM tbl_branch WHERE branch_id=$branch_id");
			if ($query->num_rows() > 0) {
				$branch_data = $query->row();
				$branch_name = $branch_data->branch_name;
			}
			unset($branch_data);
		}
		if (!empty($pod_no) && !empty($status)) {
			$tracking_date = !empty($request->date) ? date('Y-m-d H:i:s', strtotime($request->date)) : date('d-m-Y H:i:s');
			$query = $this->db->query("insert into tbl_domestic_tracking (pod_no,status,branch_name,tracking_date) VALUES ('" . $pod_no . "','" . $status . "','" . $branch_name . "','" . $tracking_date . "')");

			if ($this->db->affected_rows() > 0) {
				$insertId = $this->db->insert_id();
				$data['result'] = "success";
			} else {
				$data['result'] = "fail";
			}
		} else {
			$data['result'] = "fail";
		}
		echo json_encode($data);
	}

	public function login()
	{
		$data = array();

		//  $whrAct=array('username'=>$this->input->post('username'),'password'=>$this->input->post('password'));

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$cust_id = !empty($request->cust_id) ? $request->cust_id : $this->input->post('cust_id');
		$password = !empty($request->password) ? $request->password : $this->input->post('password');

		$this->db->select('*');
		$this->db->from('tbl_customers');
		$this->db->where('cid', $cust_id);
		$this->db->where('password', $password);

		$query = $this->db->get();
		// echo $this->db->last_query();
		if ($query->num_rows() == 1) {
			$data['result'] = "success";
			$data['data'] = $query->row();
		} else {
			$data['result'] = "fail";
			$data['message'] = "Invalid Username or Password!";
		}
		echo json_encode($data);
	}

	public function deliveryboylogin()
	{
		$data = array();

		//  $whrAct=array('username'=>$this->input->post('username'),'password'=>$this->input->post('password'));
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		if ($request->username == null) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
		} else {
			$username = $request->username;
			$password = $request->password;
		}


		$key = $this->config->item('encryption_key');
		$salt1 = hash('sha512', $key . $password);
		$salt2 = hash('sha512', $password . $key);
		$hashed_password = hash('sha512', $salt1 . $password . $salt2);


		$this->db->select('tbl_users.*,tbl_user_types.user_type_name');
		$this->db->from('tbl_users');

		$this->db->join('tbl_user_types', 'tbl_user_types.user_type_id=tbl_users.user_type');
		$this->db->where('username', $username);
		$this->db->where('password', $hashed_password);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$data['result'] = "success";
			$data['data'] = $query->row();
		} else {
			$data['result'] = "fail";
			$data['message'] = "Invalid Username or Password!";
		}
		echo json_encode($data);
	}
	public function changepassword()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$query = $this->db->query("update users SET password='$request->password' where user_id='$request->user_id'");

		if ($this->db->affected_rows() > 0) {
			$data['result'] = "success";

			//$data['noti']=$res->result_array();	                
		} else {
			$data['result'] = "fail";
		}

		echo json_encode($data);
	}


	public function pickup_request()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$date = date('y-m-d');
		$r = array(
			'id' => '',
			'consigner_name' => $request->name,
			'consigner_address' => $request->address,
			'consigner_city' => '',
			'consigner_gstno' => '',
			'consigner_pincode' => $request->pincode,
			'consignee_name' => '',
			'consignee_address' => '',
			'consignee_city' => '',
			'consignee_gstno' => '',
			'consignee_pincode' => '',
			'pickup_date' => $date,
			//'isdeleted' =>'0',
		);
		$result = $this->basic_operation_m->insert('tbl_pickup_request', $r);

		if ($this->db->affected_rows() > 0) {
			$data['result'] = "success";
			$data['message'] = "Pickup Request Added Sucessfully";
		} else {
			$data['message'] = "Error in Query";
			$data['result'] = "fail";
		}

		echo json_encode($data);
	}


	public function forgotpassword()
	{

		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$whrAct = array('email' => $request->email, 'cid' => $request->customer_id);
		//  $whrAct=array('username'=>$this->input->post('username'),'password'=>$this->input->post('password'));
		$resAct = $this->basic_operation_m->selectRecord('users', $whrAct);
		if ($resAct->num_rows() > 0) {
			$data['result'] = "success";
			$data['data'] = $resAct->result_array();
			$row = $resAct->row();

			$x = "<h2>Your Event app Login Details</h2><br>Username :" . $row->username . "<br>Email: " . $row->email . "<br> Password:" . $row->password;
			$this->load->library('email');
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'mail.rajcargo.net';
			$config['smtp_user'] = 'info@rajcargo.net';
			$config['smtp_pass'] = 'HW@UJZ!CV8#5';
			$config['smtp_port'] = 26;
			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';



			$this->email->initialize($config);

			$this->email->from('info@rajcargo.net', 'Event Admin');
			$this->email->to($request->email);
			// $this->email->cc('another@another-example.com');
			// $this->email->bcc('them@their-example.com');

			$this->email->subject(' Login Details');
			$this->email->message($x);

			$this->email->send();
			$data['result'] = "success";
			$data['message'] = "Password Send on Email Successfully!";
		} else {
			$data['result'] = "fail";
			$data['message'] = "Invalid Username or Password!";
		}
		echo json_encode($data);
	}


	public function checkservice()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		if ($request->pincode == null) {
			$pincode = $this->input->post('pincode');
		} else {
			$pincode = $request->pincode;
		}

		$reAct = $this->db->query("select * from 	pincode where 	pincode.pin_code='$pincode',isdeleted='0'");

		if ($reAct->num_rows() > 0) {
			$data['result'] = "success";
			$data['pincode'] = $reAct->row()->pin_code;
			$data['message'] = "Service Available";
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Service Available";
		}
		echo json_encode($data);
	}

	public function podsearch()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		if ($request->awnno == null) {

			$pod_no = $this->input->post('awnno');
		} else {
			$pod_no = $request->awnno;
		}

		$reAct = $this->db->query("select * from tbl_domestic_booking where pod_no='$pod_no'");



		$reAct1 = $this->db->query("select * from tbl_upload_pod where pod_no='$pod_no'");



		if ($reAct1->num_rows() > 0) {
			$data['result'] = "success";
			$data['info'] = $reAct->row();
			$data['poddetails'] = $reAct1->row();
		} else {
			$data['result'] = "fail";
			$data['message'] = "No Pod Available";
		}
		echo json_encode($data);
	}



	public function getMainFiestDetail()
	{

		$result = $this->db->query('select max(id) AS id from tbl_domestic_menifiest')->row();
		$id = $result->id + 1;
		if (strlen($id) == 2) {
			$id = 'M00' . $id;
		} else if (strlen($id) == 3) {
			$id = 'M0' . $id;
		} else if (strlen($id) == 1) {
			$id = 'M000' . $id;
		} else if (strlen($id) == 4) {
			$id = 'M' . $id;
		}

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$date = date('Y-m-d');
		$data['branch_name'] = $branch_name;
		$resAct = $this->db->query("SELECT * FROM tbl_domestic_booking where branch_id='$branch_id' order by booking_date DESC");
		if ($resAct->num_rows() > 0) {
			$data['bookingData'] = $resAct->result();
		}

		if ($resAct->num_rows() > 0) {
			$data['branches'] = $resAct->result();
		}
		$data['mid'] = $id;
		echo json_encode($data);
		exit;
	}


	public function addIncomingShipping()
	{
		$data1 = [];
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');
		$mid = !empty($request->manifiest_id) ? $request->manifiest_id : $this->input->post('manifiest_id');
		$status = !empty($request->status) ? $request->status : $this->input->post('status');
		$pod_nos = !empty($request->pod_no) ? $request->pod_no : $this->input->post('pod_no');
		$datetime = !empty($request->datetime) ? $request->datetime : $this->input->post('datetime');
		$bkdate_reason = !empty($request->bkdate_reason) ? $request->bkdate_reason : $this->input->post('bkdate_reason');
		$remarks = !empty($request->remarks) ? $request->remarks : $this->input->post('remarks');


		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$date = date('Y-m-d H:i:s');

		$res = $this->db->query("select * from tbl_domestic_menifiest where destination_branch='" . $branch_name . "' and manifiest_id='" . $mid . "'");

		$d = $res->result();




		foreach ($d as $key => $row) {
			$bag_no = @$pod_nos[$key];
			$ids = $row->id;

			if (empty($bag_no)) {
				continue;
			}

			$data = [];
			$resAct		=	$this->db->query("update tbl_domestic_menifiest set reciving_status = '1', bkdate_reason_view_incoming = '$bkdate_reason' where bag_no='$bag_no'");
			$resAct = $this->db->query("select tbl_domestic_booking.* from tbl_domestic_bag join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_domestic_bag.pod_no where  bag_id='$bag_no'");
            // echo $this->db->last_query();
			// $resAct = $this->db->query("select * from tbl_domestic_booking,city where tbl_domestic_booking.sender_city=city.id and pod_no='$pod_no' and tbl_domestic_booking.booking_type = 1 ");

			$data['info'] = $resAct->result();

			if (empty($data['info'])) {
				continue;
			}
			
			foreach ($data['info'] as $key => $row) {
				$data1 = array(

					'pod_no' => $row->pod_no,
					'status' => 'Manifest in-scan',
					'branch_name' => $branch_name,
					'remarks' => $remarks,
					'booking_id' => $row->booking_id,
					'forworder_name' => '',
					'comment' => '',
					'tracking_date' => $datetime,
				);

				$queue_dataa1 = "update tbl_domestic_stock_history set menifest_Inscan ='1' where pod_no = '$row->pod_no'";
				$status	= $this->db->query($queue_dataa1);
				$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
			}

		}
		if ($result1) {
			$data3['message'] = "Menifiest In Scan sucessfully";
		} else {
			$data3['message'] = "Error in Query";
		}
		echo json_encode($data3);
		exit;

		// echo $this->db->last_query();
		
	}


	public function addIncomingbag_insert()
	{
		$data1 = [];
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$username = !empty($request->user_name) ? $request->user_name : $this->input->post('user_name');
		$mid = !empty($request->bag_id) ? $request->bag_id : $this->input->post('bag_id');
		$status = !empty($request->status) ? $request->status : $this->input->post('status');
		$pod_nos = !empty($request->pod_no) ? $request->pod_no : $this->input->post('pod_no');
		$datetime = !empty($request->datetime) ? $request->datetime : $this->input->post('datetime');
		$bkdate_reason = !empty($request->bkdate_reason) ? $request->bkdate_reason : $this->input->post('bkdate_reason');
		$remarks = !empty($request->remarks) ? $request->remarks : $this->input->post('remarks');
		// $mid = 'MD0031';
		//$mid = 'MD0031';

		// $username = 'bc0015';



		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$date = date('Y-m-d H:i:s');
		$res = $this->db->query("select * from tbl_domestic_menifiest join tbl_domestic_bag on tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no where tbl_domestic_menifiest.destination_branch='" . $branch_name . "' and tbl_domestic_bag.bag_id='" . $mid . "'");
		// echo $this->db->last_query(); die;
		$d = $res->result();




		foreach ($d as $key => $row) {
			$pod_no = @$pod_nos[$key];
			$ids = $row->id;

			if (empty($pod_no)) {
				continue;
			}

			$data = [];
			$resAct = $this->db->query("select * from tbl_domestic_booking,city where tbl_domestic_booking.sender_city=city.id and pod_no='$pod_no' and tbl_domestic_booking.booking_type = 1 ");

			$data['info'] = $resAct->row();

			if (empty($data['info'])) {
				continue;
			}


			$data1 = array(

				'pod_no' => $pod_no,
				'status' => 'Bag In-Scan',
				'branch_name' => $branch_name,
				'remarks' => $remarks,
				'booking_id' => $resAct->row()->booking_id,
				'forworder_name' => '',
				'comment' => '',
				'tracking_date' => $date,
			);
			if(! empty($bkdate_reason)){
			$domestic_bag = "update tbl_domestic_bag set bag_recived = '1' , bkdate_reason_view_incoming = '$bkdate_reason' where pod_no='$pod_no'";
			}else{
			$domestic_bag = "update tbl_domestic_bag set bag_recived = '1' where pod_no='$pod_no'";
			}
			$this->db->query($domestic_bag);
			$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
			$domestic_booking = "update tbl_domestic_booking set menifiest_recived = '0' where pod_no='$pod_no'";
			$this->db->query($domestic_booking);
			$queue_dataa1 = "update tbl_domestic_stock_history set bag_inscan ='1',bag_genrated ='0',menifest_genrate='0',gatepass_genarte='0',gatepass_inscan='0',menifest_Inscan='0' where pod_no = '$pod_no'";
			$this->db->query($queue_dataa1);
		}

		// echo $this->db->last_query();
		if ($this->db->affected_rows() > 0) {
			$data3['message'] = "Bag In-Scan sucessfully";
		} else {
			$data3['message'] = "Error in Query";
		}
		echo json_encode($data3);
		exit;
	}

	

	public function addmenifiest()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$arr = array('pop', 'uhsh', 'hgsshg');

		// echo json_encode($arr);




		$username = !empty(@$request->user_name) ? @$request->user_name : $this->input->post('user_name');
		$destination_branch = !empty($request->destination_branch) ? $request->destination_branch : $this->input->post('destination_branch');
		$dateTime = !empty($request->datetime) ? $request->datetime : $this->input->post('datetime');

		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);

		// echo $this->db->last_query();
		$branch_id = $res->row()->branch_id;
		$date = date('Y-m-d H:i:s');

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;
		$pod = !empty($request->pod_no) ? $request->pod_no : $this->input->post('pod_no');



		// $user_type 			= 	$this->session->userdata("userType");
		$user_id = $request->user_id;
		$all_data = $pod;


		// print_r($pod);
		if (!empty($all_data)) {

			// echo "pod found!";
			$pod = $all_data;

			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;


			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;
			$pod = array_unique($pod);

			$result_max = $this->db->query('select max(inc_id) AS id from tbl_domestic_menifiest')->row();
			$inc_id = $result_max->id + 1;

			$result = $this->db->query('select max(inc_id) AS id from tbl_domestic_menifiest')->row();
			$manifiest_id = $result->id + 1;
			if (strlen($manifiest_id) == 2) {
				$manifiest_id = 'MD00' . $manifiest_id;
			} else if (strlen($manifiest_id) == 3) {
				$manifiest_id = 'MD0' . $manifiest_id;
			} else if (strlen($manifiest_id) == 1) {
				$manifiest_id = 'MD000' . $manifiest_id;
			} else if (strlen($manifiest_id) == 4) {
				$manifiest_id = 'MD' . $manifiest_id;
			}

			// $this->input->post('manifiest_id') = $manifiest_id;

			if (!isset($request->destination_branch)) {
				$request->destination_branch = '';
			}
			foreach ($pod as $pdno) {
				$arr = explode("*", $pdno);
				$pdno = $arr[0];

				$pcs = @$arr[1];
				$a_w = @$arr[2];

				if (!$a_w) {
					$a_w = 0;
				}
				if (!$pcs) {
					$pcs = 0;
				}


				$whr = array('pod_no' => $pdno);
				$booking_info = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);

				// if (empty($booking_info)) {
				// 	$data['message']="POD Invalid!";
				// 	$data['status']="Failed";

				// 	echo json_encode($data);	 
				// exit;	
				// }

				// print_r($booking_info);exit();
				$dataq = array(

					'manifiest_id' => $manifiest_id,
					'pod_no' => $pdno,
					'source_branch' => $branch_name,
					'user_id' => $user_id,
					'date_added' => date('Y-m-d H:i:s', strtotime($request->datetime)),
					'lorry_no' => $request->lorry_no,
					'driver_name' => $request->driver_name,
					'coloader' => $request->coloader,
					'forwarder_name' => $request->forwarder_name,
					'forwarder_mode' => $request->mode,
					'total_weight' => $a_w,
					'total_pcs' => $pcs,
					'contact_no' => $request->contact_no,
					'vendor_id' => @$request->vendor_id,
					'destination_branch' => @$request->destination_branch,
					'inc_id' => $inc_id,
					'dimention' => '',
				);


				$result = $this->basic_operation_m->insert('tbl_domestic_menifiest', $dataq);
				// echo $this->db->last_query();exit;					

				$menifiest_branches = $booking_info->row()->menifiest_branches;
				$booking_id = $booking_info->row()->booking_id;

				if (!empty($request->datetime)) {
					$date = date('Y-m-d H:i:s', strtotime($request->datetime));
				}


				// $date = str_replace(": ", ":", $date);
				// echo $date;
				// exit();


				// echo $this->db->last_query();exit();

				$pod_no = $pdno;


				if (!empty($menifiest_branches)) {
					$braches_ids = explode(',', $menifiest_branches);
					$braches_ids[] = $branch_id;
					$braches_ids = array_unique($braches_ids);
					$menifiest_branches = implode(',', $braches_ids);
				} else {
					$menifiest_branches = $branch_id;
				}

				$queue_dataa = "update tbl_domestic_booking set menifiest_branches ='$menifiest_branches',menifiest_recived ='1' where booking_id = '$booking_id'";
				$status = $this->db->query($queue_dataa);
				if ($this->db->affected_rows() > 0) {
					$data1 = array(

						'pod_no' => $pdno,
						'status' => 'In-transit',
						'branch_name' => $request->destination_branch,
						'booking_id' => $booking_id,
						'forworder_name' => $request->forwarder_name,
						'remarks' => $request->remarks,
						'comment' => '',
						'tracking_date' => $date,
					);


					//$result2	=	$this->basic_operation_m->insert('tbl_domestic_tracking',$data2);
					$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
				}
			}

			if ($this->db->affected_rows() > 0) {
				$data['message'] = "Menifiest Added Sucessfully";
				$msg = 'Menifiest Added successfully';
				$class = 'alert alert-success alert-dismissible';
			} else {
				$data['message'] = "Menifiest not Added successfully";
				$msg = 'Menifiest not Added successfully';
				$class = 'alert alert-danger alert-dismissible';
			}

			// echo $this->db->last_query();

		} else {
			$data['message'] = "POD Not Selected!";
		}



		// if ($this->db->affected_rows()>0) {
		// 		$data['message']="Menifiest Added Sucessfully";
		// }else{
		// 		$data['message']="Error in Query";
		// }
		echo json_encode($data);
		exit;
	}


	//CMS API Start
	public function getCityList()
	{
		$data = [];
		$cityQuery = $this->db->query("SELECT * FROM `city`");
		$data['city'] = $cityQuery->result();
		echo json_encode($data);
		exit;
	}

	public function terms()
	{
		$data = [];
		$terms_query = $this->db->query("select * from tbl_terms");
		$data = $terms_query->result();
		echo json_encode($data);
		exit;
	}
	public function privacypolicy()
	{
		$data = [];
		$privacy_query = $this->db->query("select * from tbl_privacy");
		$data = $privacy_query->result();
		echo json_encode($data);
		exit;
	}

	public function contact()
	{
		$data = [];
		$data['title'] = 'contact';
		$data['phone'] = '+ 91 22 26864605, +91 - 9820993343 / 9324859622 / 9820254259 /';
		$data['email'] = 'info@shrisailogistics.com';
		$data['address'] = 'Shop No.1, Ravi Estate, opp. Satguru building, Walbhat Road,Goregaon (E), Mumbai 400063';
		$data['content'] = '<p>test</p>';
		$data['image'] = 'test.png';

		echo json_encode($data);
		exit;
	}

	//CMS API End



	public function getCustomer()
	{
		$data = array();
		$postdata = file_get_contents("php://input");
		$postdata = json_decode($postdata);
		$user_id = $postdata->user_id;

		$this->db->select('customer_id,customer_name,email,phone,city,state,address,pincode,gstno,gstno');
		$this->db->from('tbl_customers');
		$this->db->where('user_id', $user_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$result = $query->result_array();

			$data['result'] = "success";
			$data['data'] = $result;
		} else {
			$data['result'] = "fail";
			$data['message'] = "Invalid Username or Password!";
		}
		echo json_encode($data);
	}

	public function getForwaorderList()
	{

		$postdata = file_get_contents("php://input");
		$postdata = json_decode($postdata);
		$senderPincode = $postdata->senderPincode;
		$receiverPincode = $postdata->receiverPincode;
		$whr1 = array('pin_code' => $senderPincode,'isdeleted'=>0);
		$res1 = $this->basic_operation_m->selectRecord('	pincode', $whr1);
		$result1 = $res1->row();

		$whr2 = array('pin_code' => $receiverPincode,'isdeleted'=>0);
		$res2 = $this->basic_operation_m->selectRecord('	pincode', $whr1);
		$result2 = $res1->row();

		//print_r($result2);

		$whr3 = array('pin_code' => $receiverPincode,'isdeleted'=>0);
		$res3 = $this->basic_operation_m->selectRecord('pincode', $whr3);
		$result3 = $res3->row();
		//print_r($result3);


		$forwarderList = [
			'shrisailogistics' => 'Mics Logistics',
		];

		if ($result3->bluedart_surface == 1) {
			$forwarderList['bluedart_surface'] = 'Bludart Surface Service';
		}

		if ($result3->bluedart_air == 1) {
			$forwarderList['bluedart_air'] = 'Bludart Air Service';
		}

		if ($result3->fedex == 1) {
			$forwarderList['fedex_regular'] = 'Fedex Service';
		}

		if ($result3->spoton_service == 1) {
			$forwarderList['spoton_service'] = 'Spoton Service';
		}

		if ($result3->delex == 1) {
			$forwarderList['delex_cargo_india'] = 'DELEX CARGO INDIA PRIVATE LIMITED';
		}

		if ($result3->delhivery_c2c == 1) {
			$forwarderList['delhivery_c2c'] = 'DELHIVERY C2C';
		}
		if ($result3->delhivery_b2b == 1) {
			$forwarderList['delhivery_b2b'] = 'DELHIVERY B2B';
		}
		if ($result3->revigo == 1) {
			$forwarderList['revigo_regular'] = 'Revigo Service';
		}

		echo json_encode($forwarderList);
		exit;
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

	public function get_city_by_pincode($pincode)
	{
		$pincode = $_GET['pincode'];


		$whr1 = array('pin_code' => $pincode,'isdeleted'=>0);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

		$city_id = $res1->row()->city_id;
		$whr2 = array('id' => $city_id);
		$res2 = $this->basic_operation_m->selectRecord('city', $whr2);
		$result2 = $res2->row();

		if ($result2) {
			echo json_encode([
				'status' => 'success',
				'city_id' => $result2->id,
				'city_name' => $result2->city,
				'state_id' => $result2->state_id
			]);
			exit;
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'There is info based on this pincode',
			]);

			exit;
		}
	}

	public function get_ratemaster_details()
	{

		$data = [];
		$customer_name = $this->input->get('customer_id');
		$receiver_city = $this->input->get('receiver_city_id');
		$mode_dispatch = ucfirst($this->input->get('mode_dispatch'));
		// $region_query = $this->db->query("SELECT `tbl_state`.`region_id`,`tbl_state`.`state_id`,`tbl_state`.`edd_train`,`tbl_state`.`edd_air`, `tbl_state`.`edd_air` FROM `tbl_state` join tbl_city ON `tbl_city`.`state_id` = `tbl_state`.`state_id` WHERE `tbl_city`.`city_id` = ".$receiver_city);
		$region_query = $this->db->query("SELECT `state`.`region_id`,`state`.`id`,`state`.`edd_train`,`state`.`edd_air`, `state`.`edd_air` FROM `state` join city ON `city`.`state_id` = `state`.`id` WHERE `city`.`id` = " . $receiver_city);

		if ($region_query->num_rows() > 0) {
			$regionData = $region_query->row();
			$region_id = $regionData->region_id;
			// $state_id = $regionData->state_id;
			$state_id = $regionData->id;
			$eod = ($mode_dispatch == 'air') ? $regionData->edd_air : $regionData->edd_air;
			$eod = $this->addBusinessDays(date("d-m-Y"), !empty($regionData->eod) ? $regionData->eod : 4);
		}

		if (!empty($region_id)) {
			$data['rate_master'] = new \stdClass();
			$res = $this->db->query("select * from tbl_rate_master where customer_id=" . $customer_name . " AND mode_of_transport='" . $mode_dispatch . "' AND region_id=" . $region_id . " LIMIT 1");
			// $res = $this->db->query("select * from tbl_rate_master,tbl_customers.gstno where customer_id=".$customer_name." AND mode_of_transport='".$mode_dispatch."' AND region_id=".$region_id." LIMIT 1");

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
		//echo json_encode($data);

		if ($data['rate_master']) {
			echo json_encode([
				'status' => 'success',
				'rate_master' => $data['rate_master'],
			]);
			exit;
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'There is info rates available',
			]);

			exit;
		}
	}

	public function getDispatchDetail()
	{
		$data = [
			'cash' => 'Cash',
			'credit' => 'Credit',
			'To Pay' => 'To Pay',
			'daoc' => 'Daoc'
		];

		echo json_encode($data);
		exit;
	}


	public function listShipment()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$user_id = $request->user_id;
		$usertype = @$request->usertype;


		$statusbyid = [];
		$status = $this->db->get('tbl_status')->result_array();
		foreach ($status as $sttus) {
			$statusbyid[$sttus['id']] = $sttus['status'];
		}

		if ($usertype != 'partner') {
			$customer = $this->basic_operation_m->get_query_result_array("SELECT * FROM tbl_customers WHERE customer_id = $user_id ORDER BY customer_name ASC");
			$filterCond = " AND tbl_domestic_booking.customer_id = '$user_id'";
		} else {
			$filterCond = " AND tbl_domestic_booking.user_id = '$user_id'";
		}


		// $whr = array('user_id'=>$user_id);
		// $res=$this->basic_operation_m->getAll('tbl_users',$whr);

		// print_r($customer); die;

		// $user_type 					= $this->session->userdata("userType");			
		// $filterCond					= '';
		// $all_data 					= $this->input->post();


		$offset = 0;

		$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 $filterCond ");
		$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond order by tbl_domestic_booking.booking_id DESC limit " . $offset . ",50");
		// $download_query 		= "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond order by tbl_domestic_booking.booking_id DESC";

		// echo $this->db->last_query();

		$allpoddata = $resAct->result_array();

		// print_r($allpoddata);# die;

		$poddataarr = [];

		if (!empty($allpoddata)) {
			# code...

			foreach ($allpoddata as $poddata) {
				$status = $poddata['status'];
				// print_r($statusbyid);
				// print_r($poddata);
				$statusname = @$statusbyid[$poddata['status']];
				if (!$status) {
					$statusname = 'Pending';
				}
				// add by pritesh 
				// $resAct = $this->db->query("select * from transfer_mode where transfer_mode_id =".$poddata['mode_dispatch']);
				// $mode_dispatch = $resAct->row()->mode_name;
				ini_set('display_errors', '0');
				ini_set('display_startup_errors', '0');
				error_reporting(E_ALL);
				$whr_c = array("transfer_mode_id" => $poddata['mode_dispatch']);
				$city_details = $this->basic_operation_m->get_table_row("transfer_mode", $whr_c);
				$mode_dispatch = $city_details->mode_name;
				// $mode_dispatch = 'Air';
				// if($poddata['mode_dispatch'] == 2){
				// 	$mode_dispatch = 'Train';
				// }
				// if($poddata['mode_dispatch'] == 3){
				// 	$mode_dispatch = 'Surface';
				// }




				$poddataarr[] = [
					'booking_id' => $poddata['booking_id'],
					'awb_num' => $poddata['pod_no'],
					'booking_date' => $poddata['booking_date'],
					'current_status' => $statusname,
					'booking_mode' => $mode_dispatch,
					'destination' => $poddata['reciever_address'],
					'sender_name' => $poddata['sender_name'],
					'reciever_name' => $poddata['reciever_name'],
					'reciever_city' => $poddata['city'],
					'payment_method' => $poddata['payment_method'],
					'total_payment' => $poddata['grand_total'],
					'download' => 'http://boxnfreight.in/Downloadpod/download_pod/' . $poddata['pod_no']
				];
			}
		}
		if ($poddataarr) {
			$resultarr['result'] = "success";
			$resultarr['data'] = $poddataarr;
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Shipment not found";
		}
		echo json_encode($resultarr);

		die;
	}

	public function generateDeliverySheet()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;

		$user_id = $request['user_id'];
		$usernamee = $request['delivery_boy_username'];
		$date_time = trim($request['date_time']);
		$awb_nos = $request['awb_nos'];

		if (empty($date_time)) {
			$date_time = date('Y-m-d H:i:s');
		} else {
			$date_time = date('Y-m-d H:i:s', strtotime($date_time));
		}

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;


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
		} else{
			$id = 'D' . $id;
		}

		// print_r($awb_nos); die;
		// echo $this->db->database;
		$deliverysheetid = [];

		// $date=date("Y-m-d",strtotime($date_time ) );

		$pod = array_unique($awb_nos);

		// print_r($pod);

		foreach ($pod as $row) {
			$row = trim($row);
			if (empty($row)) {
				# code...
				continue;
			}
			$rows = explode('|', $row);
			$pod_no = $rows[0];
			$data = array(
				'deliverysheet_id' => $id,
				'deliveryboy_name' => $usernamee,
				'branch_id' => $branch_id,
				'pod_no' => $pod_no,
				'status' => 'recieved',
				'bkdate_reason' => $request['bkdate_reason'],
				'vehical_no' => $request['vehical_no'],
				'delivery_date' => $date_time,
			);
			$result = $this->basic_operation_m->insert('tbl_domestic_deliverysheet', $data);

			if ($result) {
				$deliverysheetid[] = $result;
			}
            $did = $id;
			$booking_id = $this->basic_operation_m->get_table_row('tbl_domestic_booking', "pod_no = '$pod_no'");
			$data1 = array(
				'id' => '',
				'booking_id' => $booking_id->booking_id,
				'pod_no' => $pod_no,
				'status' => 'Out For Delivery',
				'shipment_info' => $did,
				'branch_name' => $branch_name,
				'remarks' => $request['remarks'],
				'tracking_date' => $date_time,
			);
			$this->db->trans_start();
			$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
			$queue_dataa1 = "update tbl_domestic_stock_history set delivery_sheet ='1' where pod_no = '$pod_no'";
			$status	= $this->db->query($queue_dataa1);
			$shipping_data = $this->db->get_where('tbl_domestic_booking', ['pod_no' => $pod_no])->row();
			$firstname = $shipping_data->reciever_name;
			$lastname = "";
			$number = $shipping_data->reciever_contact;
			$enmsg = "Hi $firstname $lastname, your AWB No.$pod_no is out for delivery. Track your shipment here https://boxnfreight.com/track-shipment. Regards, Team Box And Freight.";
			sendsms($number,$enmsg);
			$this->db->trans_complete();
		}
		if ($this->db->trans_status() === FALSE)
       {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "Something is went wrong";
	   }else{
	   if ($deliverysheetid) {
			$resultarr['result'] = "success";
			$resultarr['data']['sheet_numbers'] = $deliverysheetid;
		} 
	}
		echo json_encode($resultarr);
	}

	public function listDeliverySheet()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$delivery_boy_username = @$request['delivery_boy_username'];
		$username = $request['user_name'];

		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_type = $res->row()->user_type;

		$where = "";
		switch ($user_type) {
			case '1':
				$where = "tbl_domestic_deliverysheet.branch_id=" . $branch_id;
				break;

			case '2':
				$where = "deliveryboy_name='" . $username . "'";
				break;

			case '3':
				$where = "tbl_domestic_deliverysheet.branch_id=" . $branch_id;
				break;

			default:
				# code...
				break;
		}

		if (!empty($where)) {
			$where = " WHERE " . $where;
		}

		// echo "<pre>";
		// print_r($res);exit();

		$resAct1 = $this->db->query("SELECT *, COUNT(deliverysheet_id) AS total_count
                FROM tbl_domestic_deliverysheet
                LEFT JOIN tbl_branch ON tbl_branch.branch_id = tbl_domestic_deliverysheet.branch_id
                LEFT JOIN tbl_users ON tbl_users.username = tbl_domestic_deliverysheet.deliveryboy_name " . $where . "
                GROUP BY deliverysheet_id");


		// echo $this->db->last_query();exit();

		if ($resAct1->num_rows() > 0) {
			$data['allpod'] = $resAct1->result_array();
		}

		if ($data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['sheets'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No sheets found";
		}
		echo json_encode($resultarr);
	}

	public function deliverySheetDetails()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$delivery_boy_username = $request['delivery_boy_username'];
		$delivery_sheet_id = $request['delivery_sheet_id'];

		$whr = array('username' => $delivery_boy_username);

		// print_r($whr);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT tbl_domestic_deliverysheet.*,tbl_branch.*,tbl_users.*,tbl_domestic_booking.sender_name as consigner,tbl_domestic_booking.reciever_name as consignee,tbl_domestic_booking.reciever_address as consignee_address,method as payment_method
                FROM tbl_domestic_deliverysheet
                LEFT JOIN tbl_branch ON tbl_branch.branch_id = tbl_domestic_deliverysheet.branch_id
                INNER JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no = tbl_domestic_deliverysheet.pod_no
                LEFT JOIN payment_method ON tbl_domestic_booking.payment_method=payment_method.id
                LEFT JOIN tbl_users ON tbl_users.username = tbl_domestic_deliverysheet.deliveryboy_name WHERE deliverysheet_id = '$delivery_sheet_id'
                ");

		// echo $this->db->last_query();

		if ($resAct1->num_rows() > 0) {
			$data['allpod'] = $resAct1->result_array();
		}

		if ($data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['sheet_details'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No sheets found";
		}
		echo json_encode($resultarr);
	}

	public function listAllDiliveryboy()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		// $user_id = 1;

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT * FROM tbl_users WHERE user_type = 2 AND branch_id = $branch_id");
		// echo "<pre>";
		// print_r($res->row());
		// print_r($res);exit();
		// echo $this->db->last_query();


		if ($resAct1->num_rows() > 0) {
			$data['alldeliveryboys'] = $resAct1->result_array();
		}

		if ($data['alldeliveryboys']) {
			$resultarr['result'] = "success";
			$resultarr['data']['alldeliveryboys'] = $data['alldeliveryboys'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No Delivery boy found";
		}
		echo json_encode($resultarr);
	}

	public function manefistList()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		// $user_id = 1;

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT * FROM tbl_users WHERE user_type = 2 AND branch_id = $branch_id");
		// echo "<pre>";


		$whr = array('branch_id' => $branch_id);

		$res_branch = $this->basic_operation_m->getAll('tbl_branch', $whr);


		$branch_name = $res_branch->row()->branch_name;
		$data = array();

		$resAct = $this->db->query("select *,sum(total_pcs) as total_pcs,sum(total_weight) as total_weight from tbl_domestic_menifiest where tbl_domestic_menifiest.source_branch='$branch_name' group by manifiest_id order by manifiest_id desc");
		
		if ($resAct->num_rows() > 0) {
			$data['allpod'] = $resAct->result();
		}




		if ($data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['allpod'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No manifiest list found";
		}
		echo json_encode($resultarr);
	}
	public function baggenratedList()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		// $user_id = 1;

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT * FROM tbl_users WHERE user_type = 2 AND branch_id = $branch_id");
		// echo "<pre>";


		$whr = array('branch_id' => $branch_id);

		$res_branch = $this->basic_operation_m->getAll('tbl_branch', $whr);

		$where = '';
		$user_type = $this->session->userdata("userType");
		$user_id = $this->session->userdata("userId");
		if($user_type == 5) {
		   $where = ' AND user_id ='.$user_id;     
		}
		$branch_name = $res_branch->row()->branch_name;
		$data = array();
		$resAct = $this->db->query("select *,sum(total_pcs) as total_pcs,sum(total_weight) as total_weight from tbl_domestic_bag where tbl_domestic_bag.source_branch='$branch_name' $where  group by bag_id order by bag_id desc");
		
		if ($resAct->num_rows() > 0) {
			$data['allpod'] = $resAct->result();
		}




		if ($data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['allpod'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No manifiest list found";
		}
		echo json_encode($resultarr);
	}


	public function manefistDetails()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		$manifiest_id = $request['manifiest_id'];
		// $user_id = 1;

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT * FROM tbl_users WHERE user_type = 2 AND branch_id = $branch_id");
		// echo "<pre>";


		$whr = array('branch_id' => $branch_id);
		$res_branch = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res_branch->row()->branch_name;

		$data = array();

		$resAct = $this->db->query("select *,sum(total_pcs) as total_pcs,sum(total_weight) as total_weight from tbl_domestic_menifiest where tbl_domestic_menifiest.source_branch='$branch_name' AND manifiest_id='$manifiest_id' group by manifiest_id order by manifiest_id desc");

		// echo $this->db->last_query();exit();

		if ($resAct->num_rows() > 0) {
			$data['allpod'] = $resAct->result();
		}




		if (@$data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['allpod'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No manifiest list found";
		}
		echo json_encode($resultarr);
	}

	public function master_manifest_upcoming()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		$manifiest_id = $request['manifiest_id'];
		// $user_id = 1;

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT * FROM tbl_users WHERE user_type = 2 AND branch_id = $branch_id");
		// echo "<pre>";


		$whr = array('branch_id' => $branch_id);
		$res_branch = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res_branch->row()->branch_name;

		$data = array();

		$resAct = $this->db->query("select *,sum(total_pcs) as total_pcs,sum(total_weight) as total_weight from tbl_domestic_menifiest where tbl_domestic_menifiest.source_branch='$branch_name' AND manifiest_id='$manifiest_id' group by manifiest_id order by manifiest_id desc");

		// echo $this->db->last_query();exit();

		if ($resAct->num_rows() > 0) {
			$data['allpod'] = $resAct->result();
		}




		if (@$data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['allpod'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No manifiest list found";
		}
		echo json_encode($resultarr);
	}

	public function master_manifest_genrated()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		// $user_id = 1;

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		// echo $this->db->last_query();
		$branch_id = @$res->row()->branch_id;

		$resAct1 = $this->db->query("SELECT * FROM tbl_users WHERE user_type = 2 AND branch_id = $branch_id");
		// echo "<pre>";


		$whr = array('branch_id' => $branch_id);
		$res_branch = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res_branch->row()->branch_name;

		$data = array();

		$resAct = $this->db->query("select * from tbl_gatepass where origin = '$branch_name' order by id desc");

		// echo $this->db->last_query();exit();

		if ($resAct->num_rows() > 0) {
			$data['allpod'] = $resAct->result();
		}

		if (@$data['allpod']) {
			$resultarr['result'] = "success";
			$resultarr['data']['allpod'] = $data['allpod'];
		} else {
			$resultarr['result'] = "fail";
			$resultarr['message'] = "No manifiest list found";
		}
		echo json_encode($resultarr);
	}


	public function menuMaster()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		$usertype = $request['usertype'];


		$whr = array('user_type' => $usertype);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);


		if ($usertype == 'staff') {
			# code...
			$resAct = $this->db->query("select menu_master.* from menu_master JOIN user_menu on user_menu.menu_id=menu_master.menu_id")->result_array();
		} else {
			$resAct = $this->db->query("select menu_master.* from menu_master JOIN user_menu on user_menu.menu_id=menu_master.menu_id where user_menu.userType='$usertype'")->result_array();
		}



		// echo $this->db->last_query();



		$array = array(
			'Upload POD',
			'Update Shipment',
			'List Shipment',
			'List Branch Shipment',
			'Pending Branch Shipment',
			'Delivered Branch Shipment',
			'Upcoming Shipment',
			'Incoming Shipment',
			'Outgoing Shipment',
			'Print POD',
			'Create DRS',
			'DRS',
			'Delhivey Sheet',
		);

		$arr2 = array(
			'Staff',
			'Delhivey Boy',
			'List Shipment',
			'Customer',

		);

		$final = array(
			'menus' => $resAct,
			'usertype' => $usertype,
		);



		echo json_encode(array('status' => true, 'message' => 'Menu List', 'data' => $final));
	}


	public function awbnodata()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		$awb_no = $request['pod_no'];


		$pod_no = trim($awb_no);


		$where = '';

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;

		// $where = "and menifiest_branches not like '%$branch_id%' and menifiest_recived ='0' "; 		
		$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking where tbl_domestic_booking.pod_no='$pod_no' and is_delhivery_complete = '0'  $where limit 1");
		$data = array();

		if ($resAct5->num_rows() > 0) {
			$reAct = $this->db->query("select * from tbl_domestic_tracking where status='Out For Delivery' AND pod_no = '$pod_no' ORDER BY id DESC");
			$dd = $reAct->row();

			if (!empty($dd)) {
				# code...
			} else {
				$data = $resAct5->row_array();
			}
		}

		echo json_encode($data);
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


	public function reset_manifest()
	{

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		$resAct1 = $this->db->query("UPDATE  `tbl_domestic_booking` set menifiest_recived=0 where pod_no='" . $request->pod_no . "'");
		// -- $resAct1=$this->db->query("DELETE  FROM `tbl_domestic_menifiest` where pod_no='".$request->pod_no."'");


		// UPDATE  `tbl_domestic_booking` set menifiest_recived=0 where pod_no='awb'
	}

	public function dgdgd()
	{

		$this->write_request_file();
		echo "<br>";
		echo $dd = date('Y-m-d H:i:s');
	}

	public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
	{
		//usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }      
		//
		//data is like:    data:image/png;base64,asdfasdfasdf
		$splited = explode(',', substr($base64_image_string, 5), 2);
		$mime = $splited[0];
		$data = $splited[1];

		$mime_split_without_base64 = explode(';', $mime, 2);
		$mime_split = explode('/', $mime_split_without_base64[0], 2);
		if (count($mime_split) == 2) {
			$extension = $mime_split[1];
			if ($extension == 'jpeg')
				$extension = 'jpg';
			if ($extension == 'PNG')
				$extension = 'png';
			//if($extension=='text')$extension='txt';
			$output_file_with_extension = $output_file_without_extension . '.' . $extension;
		}
		file_put_contents($path_with_end_slash . $output_file_with_extension, base64_decode($data));
		return $output_file_with_extension;
	}

	public function awbnodata_for_drs_generate()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		$awb_no = $request['pod_no'];


		$pod_no = trim($awb_no);


		$where = '';

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;

		// $where = "and menifiest_branches not like '%$branch_id%' and menifiest_recived ='0' "; 		
		$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking where tbl_domestic_booking.pod_no='$pod_no' and is_delhivery_complete = '0'  $where limit 1");
		$data = array();

		if ($resAct5->num_rows() > 0) {
				// $reAct = $this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' AND pod_no = '$pod_no' AND reciving_status=1 ORDER BY id DESC");
				$reAct = $this->db->query("SELECT * FROM tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no where tbl_domestic_booking.pod_no='$pod_no' and tbl_domestic_booking.is_delhivery_complete = '0' and tbl_domestic_stock_history.delivery_branch = '$branch_id' and tbl_domestic_stock_history.pickup_in_scan = '1' and tbl_domestic_stock_history.branch_in_scan = '1' and tbl_domestic_stock_history.current_branch = '$branch_id' and tbl_domestic_stock_history.delivery_sheet = '0' and menifiest_recived ='0' limit 1");

				$dd1 = $reAct->row();

				if (empty($dd1)) {
					# code...
				} else {
					$data = $resAct5->row_array();
				}
		}

		echo json_encode($data);
	}

	public function awbnodata_for_menifest_generate()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request); die;
		$user_id = $request['user_id'];
		$awb_no = $request['pod_no'];


		$pod_no = trim($awb_no);


		$where = '';

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;

		// $where = "and menifiest_branches not like '%$branch_id%' and menifiest_recived ='0' "; 		
		$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking where tbl_domestic_booking.pod_no='$pod_no' and is_delhivery_complete = '0'  $where limit 1");
		$data = array();

		if ($resAct5->num_rows() > 0) {
			$reAct = $this->db->query("select * from tbl_domestic_tracking where status='Out For Delivery' AND pod_no = '$pod_no' ORDER BY id DESC");
			$dd = $reAct->row();

			if (!empty($dd)) {
				# code...
			} else {
				$reAct = $this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' AND pod_no = '$pod_no' ORDER BY id DESC");

				$dd1 = $reAct->row();

				if (!empty($dd)) {
					if ($dd1->reciving_status == 1) {
						$data = $resAct5->row_array();
					}
				} else {
					$data = $resAct5->row_array();
				}
			}
		}

		echo json_encode($data);
	}

	//  add by pritesh bag module



	public function bag_search()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$value = $request['pod_no'];
		$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking where pod_no='$value' and is_delhivery_complete = '0'");
		$booking_row = $resAct5->row_array();
		$pod = $booking_row['pod_no'];
		$booking_id = $booking_row['booking_id'];

		$query_result = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row();

		$actual_weight = $query_result->actual_weight;
		//$no_of_pack	   = $booking_row['a_qty'];
		$no_of_pack = $query_result->no_of_pack;
		$podid = "checkbox-" . $pod;
		$dataid = 'data-val-' . $booking_id;

		$pod_no = $booking_row['pod_no'];
		$data = "";
		$data .= '<tr><td>';
		$data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}|{$actual_weight}|{$no_of_pack}' checked><input type='hidden' name='actual_weight[]' value='" . $actual_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";

		// // $data .= "<input type='checkbox' class='cb'  name='pod_no[]'  data-tp='{$no_of_pack}' data-tw='{$actual_weight}' value='{$pod_no}' checked>";

		// $data .= "<input type='checkbox' class='cb'  name='actual_weight[]' value='".$actual_weight."' checked>";
		// $data .= "<input type='checkbox' class='cb'  name='pcs[]' value='".$no_of_pack."' checked>";

		$data .= "<input type='hidden' name='rec_pincode' value=" . $booking_row['reciever_pincode'] . ">";
		$data .= "<td>" . $booking_row['pod_no'] . "</td>";
		$data .= "<td>" . $booking_row['sender_name'] . "</td>";
		$data .= "<td>" . $booking_row['reciever_name'] . "</td>";
		$resAct66 = $this->db->query("select * from city where id ='" . $booking_row['sender_city'] . "'");
		if ($resAct66->num_rows() > 0) {
			$citydata = $resAct66->row();
			$data .= "<td>" . $citydata->city . "</td>";
		}


		$resAct6 = $this->db->query("select * from city where id ='" . $booking_row['reciever_city'] . "'");
		if ($resAct6->num_rows() > 0) {
			$citydata = $resAct6->row();
			$data .= "<td>" . $citydata->city . "</td>";
		}

		if ($booking_row['dispatch_details'] == 'ToPay') {
			$data .= "<td>" . $booking_row['grand_total'] . "</td>";
		} else {
			$data .= "<td>0</td>";
		}

		$data .= "<input type='hidden' readonly name='forwarder_name' id='forwarder_name'  class='form-control' value='" . $booking_row['forworder_name'] . "'/>";
		$data .= "<td>" . $no_of_pack . "</td>";
		$data .= "<td>" . $query_result->actual_weight . "</td>";
		$data .= "<td>" . $query_result->chargable_weight . "</td>";
		$data .= "</tr>";

		echo json_encode($data);
	}

	public function bag_genrate()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);

		if (!empty($request)) {

			$pod = $request['pod_no'];
			$whr = array('user_id' => $request['user_id']);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$date = date('Y-m-d');

			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;


			$result = $this->db->query('select max(inc_id) AS id from tbl_domestic_bag')->row();
			$inc_id = $result->id + 1;
			$id = $result->id + 1;
			if (strlen($id) == 2) {
				$id = 'BG00' . $id;
			} else if (strlen($id) == 3) {
				$id = 'BG0' . $id;
			} else if (strlen($id) == 1) {
				$id = 'BG000' . $id;
			} else if (strlen($id) == 4) {
				$id = 'BG' . $id;
			} else if (strlen($id) == 5) {
				$id = 'BG' . $id;
			} else if (strlen($id) == 6) {
				$id = 'BG' . $id;
			}
			foreach ($pod as $pdno) {
				//print_r($pdno);

				$arr = explode(",", $pdno);
				//$pdno 	= $arr[0];
				$queue_dataa1 = "update tbl_domestic_bag set bag_recived ='2' where pod_no = '$pdno'";
				$status1 = $this->db->query($queue_dataa1);

				$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_booking where pod_no='$pdno'");
				$booking_row = $resAct5->row_array();
				$mode = $booking_row['mode_dispatch'];
				$resAct6 = $this->db->query("SELECT * FROM transfer_mode where transfer_mode_id='$mode'");
				$mode1 = $resAct6->row_array();

				$mode = $booking_row['booking_id'];
				$resAct6 = $this->db->query("SELECT * FROM tbl_domestic_weight_details where booking_id='$mode'");
				$total = $resAct6->row_array();

				$bag_data = array(
					//'id'=>'',
					'bag_id' => $id,
					'pod_no' => $pdno,
					'source_branch' => $branch_name,
					'user_id' => $booking_row['user_id'],
					'bkdate_reason' => $booking_row['bkdate_reason'],
					'date_added' => date('Y-m-d H:i:s', strtotime($request['datetime'])),
					'forwarder_name' => $booking_row['forworder_name'],
					'forwarder_mode' => $mode1['mode_name'],
					'note' => $request['note'],
					'total_weight' => $total['chargable_weight'],
					'total_pcs' => $total['no_of_pack'],
					'inc_id' => $inc_id,
					'bag_recived' => 0,
				);


				$result = $this->basic_operation_m->insert('tbl_domestic_bag', $bag_data);


				$whr = array('pod_no' => $pdno);
				$booking_info = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
				$book = $booking_info->row();
				$menifiest_branches = $book->menifiest_branches;
				$booking_id = $book->booking_id;
				ini_set('display_errors', '0');
				ini_set('display_startup_errors', '0');
				error_reporting(E_ALL);

				$date = $request['datetime'];
				$data1 = array(
					'id' => '',
					'pod_no' => $pdno,
					'status' => 'Bag genrated',
					'branch_name' => $branch_name,
					'shipment_info' => $id,
					'forworder_name' => 'SELF',
					'booking_id' => $booking_id,
					'remarks' => $request['note'],
					'added_branch' => $branch_name,
					'tracking_date' => date('Y-m-d H:i:s', strtotime($request['datetime'])),
				);

				$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);


				$queue_dataa1 = "update tbl_domestic_stock_history set bag_genrated ='1',bag_inscan = '0' where pod_no = '$pdno'";
				$status = $this->db->query($queue_dataa1);

				if (!empty($menifiest_branches)) {
					$braches_ids = explode(',', $menifiest_branches);
					$braches_ids[] = $branch_id;
					$braches_ids = array_unique($braches_ids);
					$menifiest_branches = implode(',', $braches_ids);
				} else {
					$menifiest_branches = $branch_id;
				}
				$queue_dataa = "update tbl_domestic_booking set menifiest_branches ='$menifiest_branches',menifiest_recived ='1' where booking_id = '$booking_id'";
				$status = $this->db->query($queue_dataa);

			}
			$message = 'Bag Created successfully';
			if ($status) {
				echo json_encode([
					'status' => 'success',
					'message' => $message,
					'bag_no' => $id,
				]);
				// exit;
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Something went to wrong',
				]);

				// exit;
			}
			// echo json_encode($data);
		}
		// $data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', "");

	}


	public function genrate_master_manifest()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['user_id'];

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		//print_r($branch_name);die();
		if (!empty($request)) {
			$bag = $request['bag_no'];
			$manifiest_id = $request['manifiest_id'];


			$result = $this->db->query("select tbl_domestic_bag.* from tbl_domestic_menifiest join tbl_domestic_bag on tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no where manifiest_id = '$manifiest_id'")->result_array();
			// echo '<pre>';print_r($result);die;
			$menifestid = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$manifiest_id'")->row();
			//echo '<pre>';print_r($result);die();
			$menifestidno = $this->db->query('select max(id) AS id from tbl_gatepass')->row();
			$inc_id = $menifestidno->id + 1;
			$id = $menifestidno->id + 1;
			$bag = $menifestidno->id + 1;

			if (strlen($bag) == 2) {
				$gatpass = 'GTP00' . $bag;
			} else if (strlen($bag) == 3) {
				$gatpass = 'GTP0' . $bag;
			} else if (strlen($bag) == 1) {
				$gatpass = 'GTP000' . $bag;
			} else if (strlen($bag) == 4) {
				$gatpass = 'GTP' . $bag;
			} else if (strlen($bag) == 5) {
				$gatpass = 'GTP' . $bag;
			} else if (strlen($bag) == 6) {
				$gatpass = 'GTP' . $bag;
			}
			foreach ($result as $value) {
				$all_data['pod_no'] = $value['pod_no'];
				$all_data['forwording_no'] = '';
				$all_data['forworder_name'] = $value['forwarder_name'];
				$all_data['branch_name'] = $menifestid->destination_branch;
				$all_data['added_branch'] = $branch_name;
				$all_data['status'] = 'In transit';
				$all_data['shipment_info'] = $gatpass;
				$all_data['tracking_date'] = $request['datetime'];
				$all_data['remarks'] = $request['remarks'];
				$track = $this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
				$pod_no = $value['pod_no'];
				$queue_dataa1 = "update tbl_domestic_stock_history set gatepass_genarte ='1' where pod_no = '$pod_no'";
				$status = $this->db->query($queue_dataa1);
			}

			//echo $this->db->last_query();die();
			//$pod = $this->input->post('pod'); 

			$data = array(
				'gatepass_no' => $gatpass,
				'manifiest_id' => $manifiest_id,
				'bag_no' => $result[0]['bag_id'],
				'total_no_bag' => count($result),
				'lock_no' => $request['lock_no'],
				'driver_name' => $request['driver_name'],
				'origin' => $result[0]['source_branch'],
				'destination' => $request['destination'],
				'bkdate_reason' => $request['bkdate_reason'],
				'datetime' => $request['datetime'],
				'genrated_by' => $request['username'],
				'vehicle_no' => $request['vehicle_no']
			);

			$result5 = $this->basic_operation_m->insert('tbl_gatepass', $data);
			$this->basic_operation_m->addLog($user_id, 'operation On Mobile', 'Add Master Menifest', $data);

			$whr = array('manifiest_id' => $manifiest_id, 'source_branch' => $source_branch);
			$data1['gatepass'] = 1;
			$data1['gatepass_no'] = $gatpass;
			$value = $this->basic_operation_m->update('tbl_domestic_menifiest', $data1, $whr);
			// echo  $this->db->last_query();die();
			//print_r($this->input->post('manifiest_id')); die();
			// var_dump($result5);die();
			$message = 'Master Manifest Genrated successfully';
			if ($status) {
				echo json_encode([
					'status' => 'success',
					'message' => $message,
					'bag_no' => $gatpass,
				]);
				// exit;
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Something went to wrong',
				]);
			}
		}
	}

	public function master_manifest_in_scan()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['user_id'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		$search = $request['gatepass_no'];
		if ($search) {
			$whr3 = array('gatepass_no' => $search, 'destination_branch' => $source_branch, 'gatepass' => '1', 'gatepass_in_scan' => '0');
			$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $whr3);
			$data['result'] = $ress->result();
			if (!empty($data['result'])) {
				echo json_encode($data);
			} else {
				$data['result'] = 'Master Manifest Not Found';
				echo json_encode($data);
			}

		}

	}


	public function master_manifest_genrated_in_scan()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$username = $request['userName'];
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_id = $res->row()->user_id;
		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
		$branch_name = $res->row()->branch_name;

		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		//print_r($branch_name);die();
		if ($request) {
			// $pod = $request['pod'];
			$manifiest_id = $request['manifiest_id'];
			//print_r($manifiest_id);die();
			$where1 = array('manifiest_id' => $manifiest_id);
			$resul = $this->basic_operation_m->get_all_result('tbl_domestic_menifiest', $where1);
			$val = $resul[0]['bag_no'];
			//print_r($val);die();
			$where = array('bag_id' => $val);
			$result = $this->basic_operation_m->get_all_result('tbl_domestic_bag', $where);
			// echo $this->db->last_query();
			// echo '<pre>';print_r($result);die();

			foreach ($result as $value) {
				$all_data['pod_no'] = $value['pod_no'];
				$all_data['forwording_no'] = '';
				$all_data['forworder_name'] = $value['forwarder_name'];
				$all_data['branch_name'] = $branch_name;
				$all_data['added_branch'] = $value['source_branch'];
				$all_data['status'] = 'Master Manifest in-scan';
				$all_data['tracking_date'] = $request['datetime'];
				$all_data['remarks'] = $request['remarks'];

				// echo $value['pod_no'];
				$track = $this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
				$pod_no = $value['pod_no'];
				$queue_dataa1 = "update tbl_domestic_stock_history set gatepass_inscan ='1', current_branch ='$branch_id' where pod_no = '$pod_no'";
				$status = $this->db->query($queue_dataa1);
			}
			// die;
			// $apidata = $this->update_partB();
			// if(!empty($apidata)){
			// 	$data123 = json_decode($apidata);
			// }

			$data = array(
				'gatepass_in_scan' => '1',
				// 'vehicleUpdateDate' => $data123['data']['vehicleUpdateDate'],
				// 'validUpto' => $data123['data']['validUpto']
			);

			$whr4 = array('destination_branch' => $source_branch, 'manifiest_id' => $manifiest_id);
			$result5 = $this->basic_operation_m->update('tbl_domestic_menifiest', $data, $whr4);

			$valu['gatepass_no'] = $resul[0]['gatepass_no'];
			$valu['manifiest_id'] = $resul[0]['manifiest_id'];
			$valu['bag_no'] = $resul[0]['bag_no'];
			$valu['source_branch'] = $resul[0]['source_branch'];
			$valu['destination_branch'] = $resul[0]['destination_branch'];
			$valu['lorry_no'] = $resul[0]['lorry_no'];
			$valu['driver_name'] = $resul[0]['driver_name'];
			$valu['date'] = $request['datetime'];
			$valu['in_scan'] = $request['userName'];
			$valu['bkdate_reason'] = $request['bkdate_reason'];
			$track = $this->basic_operation_m->insert('tbl_domestic_gatepass_in_scan', $valu);

			$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Mobile Master Menifest In-Scan', $valu);
			//echo $this->db->last_query();die();

			$message = 'Master Manifest in-scan';
			if ($track) {
				echo json_encode([
					'status' => 'success',
					'message' => $message
				]);
				// exit;
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Master Manifest Not Found',
				]);
			}
		}
	}


	public function bag_listing()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['user_id'];

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;
		$resActs = $this->db->query("select * from tbl_domestic_bag where source_branch='$branch_name'");

		if ($resActs->num_rows() > 0) {
			$data = $resActs->result();
			// echo '<pre>';print_r($data);die;
		}
		echo json_encode($data);
	}
	public function bag_single_bag_view()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['id'];

		$resActs = $this->db->query("select bag_id,source_branch from tbl_domestic_bag where id='$user_id'");
		$data['bag_info'] = $resActs->row();
		$bag_no = $resActs->row()->bag_id;

		$resActs1 = $this->db->query("select * from tbl_domestic_bag where bag_id='$bag_no'");

		if ($resActs->num_rows() > 0) {
			$data['bags_list'] = $resActs1->result();
		}
		echo json_encode($data);
	}


	// add by pritesh menifest

	public function bagdata_search()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['user_id'];
		$bag_id = $request['bag_no'];
		$forwarderName = $request['forwarder_name'];
		$mode_dispatch = $request['forwarder_mode'];


		$mode_info = $this->basic_operation_m->get_table_row('transfer_mode', array('mode_name' => $mode_dispatch));


		$where = '';

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;



		$resAct5 = $this->db->query("SELECT * FROM tbl_domestic_bag where bag_id='$bag_id' and bag_recived='0'  limit 1");

		$data = "";

		if ($resAct5->num_rows() > 0) {

			$bag_row = $resAct5->row_array();

			$bag_id = $bag_row['bag_id'];
			$total_weight = $bag_row['total_weight'];
			$no_of_pack = $bag_row['total_pcs'];
			$dataid = 'data-val-' . $bag_id;

			$data .= '<tr><td>';
			$data .= "<input type='checkbox' class='cb'  name='bag_id[]'  data-tp='{$no_of_pack}' data-tw='{$total_weight}' value='{$bag_id}|{$total_weight}|{$no_of_pack}' checked><input type='hidden' name='total_weight[]' value='" . $total_weight . "'/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "'/></td>";
			$data .= "<input type='checkbox' class='cb'  name='total_weight[]' value='" . $total_weight . "' checked>";
			$data .= "<input type='checkbox' class='cb'  name='pcs[]' value='" . $no_of_pack . "' checked>";
			$data .= "<td>" . $bag_row['bag_id'] . "</td>";
			$data .= "<td>" . $total_weight . "</td>";
			$data .= "<td>" . $mode_dispatch . "</td>";
			$data .= "<td>" . $no_of_pack . "</td>";

			$data .= "</tr>";
		}
		echo json_encode($data);
	}

	public function insert_menifiest()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request);die();

		$user_id = $request['user_id'];
		$bag_id = $request['bag_id'];
		$datetime = $request['datetime'];
		$lorry_no = $request['lorry_no'];
		$driver_name = $request['driver_name'];
		$coloader = $request['coloader'];
		$forwarder_name = $request['forwarder_name'];
		$forwarder_mode = $request['forwarder_mode'];
		$route_id = $request['route_id'];
		$supervisor = $request['supervisor'];
		$note = $request['note'];
		$cd_no = $request['cd_no'];
		$bkdate_reason = $request['bkdate_reason'];
		$coloder_contact = $request['coloder_contact'];
		$contact_no = $request['contact_no'];
		$vendor_id = $request['vendor_id'];
		$destination_branch = $request['destination_branch'];
		// echo '<pre>';print_r($request);die;



		if (!empty($request)) {

			$whr = array('user_id' => $user_id);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;
			$username = $res->row()->username;
			$date = date('Y-m-d');

			$whr = array('branch_id' => $branch_id);
			$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
			$branch_name = $res->row()->branch_name;
			$bag_id = array_unique($bag_id);


			$result = $this->db->query('select max(inc_id) AS id from tbl_domestic_menifiest')->row();
			$inc_id = $result->id + 1;
			$id = $result->id + 1;
			if (strlen($id) == 2) {
				$id = 'MD00' . $id;
			} else if (strlen($id) == 3) {
				$id = 'MD0' . $id;
			} else if (strlen($id) == 1) {
				$id = 'MD000' . $id;
			} else if (strlen($id) == 4) {
				$id = 'MD' . $id;
			} else if (strlen($id) == 5) {
				$id = 'MD' . $id;
			} else if (strlen($id) == 6) {
				$id = 'MD' . $id;
			}

			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			foreach ($bag_id as $bagid) {
				$arr = explode("|", $bagid);
				$bag_no = $arr[0];
				$a_w = $arr[1];
				$pcs = $arr[2];

				$data = array(
					'id' => '',
					'manifiest_id' => $id,
					'bag_no' => $bag_no,
					'source_branch' => $branch_name,
					'user_id' => $user_id,
					'date_added' => date('Y-m-d H:i:s', strtotime($datetime)),
					'lorry_no' => $lorry_no,
					'driver_name' => $driver_name,
					'coloader' => $coloader,
					'forwarder_name' => $forwarder_name,
					'forwarder_mode' => $forwarder_mode,
					'route_id' => $route_id,
					'supervisor' => $supervisor,
					'username' => $username,
					'note' => $note,
					'total_weight' => $a_w,
					'total_pcs' => $pcs,
					'coloder_contact' => $coloder_contact,
					'bkdate_reason' => $bkdate_reason,
					'cd_no' => $cd_no,
					'contact_no' => $contact_no,
					'vendor_id' => $vendor_id,
					'destination_branch' => $destination_branch,
					'inc_id' => $inc_id,
					'manifiest_verifed' => 1,
				);


				$result = $this->basic_operation_m->insert('tbl_domestic_menifiest', $data);



				$all_pod = $this->db->query("select * from tbl_domestic_bag where bag_id = '$bag_no'")->result();

				if (!empty($all_pod)) {
					foreach ($all_pod as $key => $values) {
						$whr = array('pod_no' => $values->pod_no);
						$booking_info = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
						$menifiest_branches = $booking_info->row()->menifiest_branches;
						$booking_id = $booking_info->row()->booking_id;

						$date = $datetime;
						$data1 = array(
							'id' => '',
							'pod_no' => $values->pod_no,
							'status' => 'Manifest genrated',
							'shipment_info' => $id,
							'branch_name' => $branch_name,
							'forworder_name' => $forwarder_name,
							'booking_id' => $booking_id,
							'remarks' => $request['note'],
							'added_branch' => $destination_branch,
							'tracking_date' => date('Y-m-d H:i:s', strtotime($datetime)),
						);
						$result1 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data1);
						$queue_dataa1 = "update tbl_domestic_stock_history set menifest_genrate ='1' where pod_no = '$values->pod_no'";
						$status = $this->db->query($queue_dataa1);
					}
				}
			}

			if ($result) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Manifest Added Sucessfully',
					'manifest_id' => $id,
				]);
				// exit;
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Manifest not created successfully',
				]);

				// exit;
			}
		}
	}




	public function search_master_menifest()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		//  print_r($request);die;
		// $ress					=	$this->basic_operation_m->getAll('tbl_branch', '');
		// $data['all_branch']		= 	$ress->result();

		$user_id = $request['user_id'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		$search = $request['menifest_id'];
		if ($search) {
			//$whr3 = array('manifiest_id'=>$search,'gatepass' => '0','source_branch'=> $source_branch);
			$ress = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$search' AND source_branch = '$source_branch' AND gatepass= '0' ");
			$data['result'] = $ress->result();
			if (!empty($data['result'])) {
				$data['result'] = $ress->result();
			} else {
				$data['result'] = "Manifest Id Not Found";
			}

		}

		echo json_encode($data);
	}

	public function incomingbag()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		//  print_r($request);die;
		// $ress					=	$this->basic_operation_m->getAll('tbl_branch', '');
		// $data['all_branch']		= 	$ress->result();

		$user_id = $request['user_id'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$branch_name = $ress->row()->branch_name;
	
			//$whr3 = array('manifiest_id'=>$search,'gatepass' => '0','source_branch'=> $source_branch);
			$resAct=$this->db->query("SELECT *, SUM(CASE WHEN tbl_domestic_bag.bag_recived=1 THEN 1 ELSE 0 END) AS total_coming, COUNT(tbl_domestic_bag.id) AS total,
				COUNT(tbl_domestic_bag.total_pcs) AS total_pcs, COUNT(tbl_domestic_bag.total_weight) AS total_weight
				FROM tbl_domestic_menifiest
				LEFT JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no
				WHERE tbl_domestic_menifiest.destination_branch='$branch_name' AND reciving_status ='1'
				GROUP BY tbl_domestic_bag.bag_id
				ORDER BY tbl_domestic_bag.date_added DESC");
				// echo $this->db->last_query();die;
			$data['result'] = $resAct->result();
			if (!empty($data['result'])) {
				$data['result'] = $resAct->result();
			} else {
				$data['result'] = "View Incoming Bag ID Not Found";
			}

		echo json_encode($data);
	}


	public function manifest_bag_scan()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['user_id'];
		$bag_id = $request['bag_no'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;
		$resActs = $this->db->query("SELECT *,sum(total_weight) as total_weight,sum(total_pcs) as total_pcs FROM tbl_domestic_bag JOIN tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_bag.pod_no where tbl_domestic_bag.bag_id='$bag_id' and tbl_domestic_bag.bag_recived='0' and tbl_domestic_stock_history.current_branch = '$branch_id' and tbl_domestic_stock_history.menifest_genrate = '0' and tbl_domestic_stock_history.branch_in_scan = '1' and tbl_domestic_stock_history.pickup_in_scan = '1' limit 1");
		// echo $this->db->last_query();
		$data['bag_info'] = $resActs->row();
		if (!empty($data['bag_info'])) {
			$data['bag_info'] = $resActs->row();
		} else {
			$data['bag_info'] = "Bag Id Not Found";
		}
		echo json_encode($data);
	}

	public function add_menifiest()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);

		$user_id = $request['user_id'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$wheresuper = array('user_type' => 9, 'branch_id' => $branch_id);
		$data['supervisor'] = $this->basic_operation_m->get_all_result('tbl_users', $wheresuper);
		$whr_c = array('company_type' => 'Domestic');
		$data['courier_company'] = $this->basic_operation_m->get_all_result('courier_company', $whr_c);
		$data['allroute'] = $this->basic_operation_m->get_all_result('route_master', '');
		$data['coloader_list'] = $this->basic_operation_m->get_all_result('tbl_coloader', "");
		$data['mode_list'] = $this->basic_operation_m->get_all_result('transfer_mode', "");
		$ress = $this->basic_operation_m->getAll('tbl_branch', '');
		$data['all_branch'] = $ress->result();
		$ress = $this->basic_operation_m->getAll('tbl_vendor', '');
		$data['all_vendor'] = $ress->result();
		echo json_encode($data);
	}

	public function search_change_status()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$data = array();
		$user_id = $request['user_id'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$awb = $request['awb_no'];
		$submit = "Domestic";
		if ($submit == 'Domestic') {
			$where = array('pod_no' => $awb);
			$data['result'] = $this->db->query("Select tbl_domestic_booking.* from tbl_domestic_booking join tbl_domestic_stock_history on tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no join tbl_domestic_deliverysheet ON tbl_domestic_deliverysheet.pod_no =  tbl_domestic_booking.pod_no Where tbl_domestic_booking.pod_no = '$awb' and tbl_domestic_stock_history.delivery_sheet = '1' and tbl_domestic_stock_history.is_delivered = '0' and tbl_domestic_stock_history.delivery_branch = '$branch_id' group by tbl_domestic_booking.pod_no")->result_array();
			if (!empty($data['result'])) {
				$data['result'];
				
			}else{
				$data = 'data not found';
			}
			echo json_encode($data);
		}
	}
	public function search_pod_upload()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$data = array();
		$user_id = $request['user_id'];
		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$awb = $request['awb_no'];
		
			$data['row'] = $this->db->query("select tbl_domestic_booking.* from tbl_domestic_stock_history join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no left join tbl_upload_pod on tbl_upload_pod.pod_no = tbl_domestic_stock_history.pod_no where tbl_domestic_stock_history.is_delivered = '1' and tbl_domestic_stock_history.delivery_branch = '$branch_id' and tbl_domestic_stock_history.pod_no = '$awb' and tbl_upload_pod.pod_no IS NULL")->row_array();
			if (!empty($data['row'])) {
				$data['row'];
				echo json_encode($data);
			}
	}

	public function menifest_listing()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$user_id = $request['user_id'];

		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
		$branch_id = $res->branch_id;

		$whr = array('branch_id' => $branch_id);
		$res = $this->basic_operation_m->get_table_row('tbl_branch', $whr);
		$branch_name = $res->branch_name;
		$resActs = $this->db->query("select * from tbl_domestic_menifiest where source_branch='$branch_name'GROUP BY manifiest_id");

		if ($resActs->num_rows() > 0) {
			$data = $resActs->result();
		}
		echo json_encode($data);
	}

	public function menifest_single_bag_view()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		$id = $request['id'];

		$resActs = $this->db->query("select manifiest_id,source_branch from tbl_domestic_menifiest where id='$id'");
		//echo $this->db->last_query();die();
		$data['menifest_info'] = $resActs->row();
		$bag_no = $resActs->row()->manifiest_id;

		$resActs1 = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id='$bag_no'");

		if ($resActs->num_rows() > 0) {
			$data['menifest_list'] = $resActs1->result();
		}
		echo json_encode($data);
	}

	public function order_conformation()
	{
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata, true);
		// print_r($request);die;
		$lr_no = $request['lr_no'];
		if (!empty($lr_no)) {
			$resActs = $this->db->query("select * from lr_table where lr_number='$lr_no'");
			// echo $this->db->last_query();die();
			$val = $resActs->row_array();
			$data = array(
				'lorry_no' => 'MH46CD0833',
				'lr_no' => $lr_no,
				'driver_name' => $val['reciever_name'],
				'driver_id' => $val['customer_id'],
				'driver_mobile' => $val['reciever_contact']
			);
			echo json_encode($data);
		}


		//print_r($data);die;
		//$result = $this->basic_operation_m->insert('tbl_domestic_bag', $data);
	}

}