<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php'; 
class Admin_customer_API_rest extends REST_Controller
{

    public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('basic_operation_m');
	}
    public function test_post(){
        $this->response([ 
            'status' => FALSE, 
            'message' => 'No users were found.' 
        ], REST_Controller::HTTP_OK); 
    }

    // public function addShipment_post()
	// {

	// 	$postdata = file_get_contents("php://input");
	// 	$postData = json_decode($postdata);
	// 	echo "<pre>"; print_r('hello'); die;
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
	// 	} elseif (strlen($id) == 5) {
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


}


?>