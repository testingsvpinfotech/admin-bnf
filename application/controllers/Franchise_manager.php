<?php
ini_set('display_errors', 1);


defined('BASEPATH') or exit('No direct script access allowed');

class Franchise_manager extends CI_Controller
{
	var $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('basic_operation_m');
		$this->data['company_info']	= $this->basic_operation_m->get_query_row("select * from tbl_company limit 1");
		
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}





	public function getCityList()
	{
		$data = array();
		$pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

		$pin_code = @$res1->row()->pin_code;
        $city_id = @$res1->row()->city_id;
        $isODA = @$res1->row()->isODA;

        if (!$pin_code) {
            $data['status'] = "failed";
            $data['message'] = "Not A valid Pincode or not a servicable";
            echo json_encode($data);
            exit();
        }

		$whr2 = array('id' => $city_id);
		$res2 = $this->basic_operation_m->selectRecord('city', $whr2);
		$result2 = $res2->row();
		$state_id = $res2->row()->state_id;


		$whr1 = array('state' => $state_id, 'city' => $city_id);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$regionid = @$res1->row()->regionid;
		$result2->regionid = $regionid;
		$result2->regionid = $regionid;
		
		$data['status'] = "success";
		echo json_encode($result2);
	}

	public function getState()
	{
		$pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

		$state_id = $res1->row()->state_id;
		$whr3 = array('id' => $state_id);
		$res3 = $this->basic_operation_m->selectRecord('state', $whr3);
		$data['result3'] = $res3->row();
		$data['oda'] = $res1->row();

		echo json_encode($data);
	}


	public function getZone()
	{
		$reciever_state = $this->input->post('reciever_state');
		$reciever_city =  $this->input->post('reciever_city');

		$whr1 = array('state' => $reciever_state, 'city' => $reciever_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$regionid = $res1->row()->regionid;

		$whr3 = array('region_id' => $regionid);
		$res3 = $this->basic_operation_m->selectRecord('region_master', $whr3);
		$result3 = $res3->row();

		echo json_encode($result3);
	}

	public function getsenderdetails()
	{
		$data = [];
		$customer_name = $this->input->post('customer_name');
		//	print_r($customer_name);exit;
		$whr1 = array('customer_id' => $customer_name);
		//$res1 = $this->basic_operation_m->selectRecord('tbl_customers', $whr1);

		$res1 = $this->basic_operation_m->get_customer_details($whr1);
		//	echo $this->db->last_query();exit;
		//$result1 = $res1->row();
		$data['user'] = $res1;
		echo json_encode($data);
		exit;
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

	public function getFuelcharges()
	{
		$customer_id = $this->input->post('customer_id');
		$dispatch_details = $this->input->post('dispatch_details');
		$courier_id = $this->input->post('courier_id');
		$sub_amount = $this->input->post('sub_amount');
		$booking_date = $this->input->post('booking_date');

		//   print_r($_POST);die;
		//print
		//print_r($customer_id);
		$get_fuel_id = $this->db->query("select * from franchise_delivery_tbl where delivery_franchise_id = '$customer_id'")->row();
		$dd =   $get_fuel_id->fule_group;
		$get_fuel_details = $this->db->query("select * from franchise_fule_tbl where group_id = '$dd'")->row();

		// print_r($get_fuel_details);exit;

		$current_date = date("Y-m-d", strtotime($booking_date));

		$whr1 = array('from_date <=' => $current_date, 'to_date >=' => $current_date, 'group_id' => $dd);
		$res1 = $this->db->query("select * from franchise_fule_tbl where from_date <='$current_date' AND to_date >='$current_date' AND group_id = '$dd' ")->row();
		// echo $this->db->last_query();exit;

		//print_r($res1);


		if ($res1) {

			$fov_rate = $res1->fov_rate;
			$awb_rate = $res1->awb_rate;
			$topay_rate = $res1->topay_rate;
			$cod_min = $res1->cod_min;
			$cod_percentage = $res1->cod_percentage;
			$fuel_per = $res1->fule_percentage;
		} else {
			$fuel_per = '0';
		}

		$final_fuel_charges = ($sub_amount * $fuel_per / 100);

		$sub_total = ($sub_amount + $final_fuel_charges);

		// print_r($sub_total);
		$gst_details = $this->basic_operation_m->get_query_row('select * from tbl_gst_setting order by id desc limit 1');



		if ($gst_details) {
			$cgst_per = $gst_details->cgst;
			$sgst_per = $gst_details->sgst;
			$igst_per = $gst_details->igst;
		} else {
			$cgst_per = '0';
			$sgst_per = '0';
			$igst_per = '0';
		}



		$tbl_customers_info 		= $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");

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
			'fov_rate' => $fov_rate,
			'awb_rate' => $awb_rate,
			'cod_percentage' => $cod_percentage,
			'cod_min' => $cod_min,
			'fule_percentage' => $fuel_per,

		);

		echo json_encode($result2);
	}

	public function add_shipment()
	{

		$all_Data 	= $this->input->post();
		// echo "<pre>";
		// print_r($all_Data);exit();


		if (!empty($all_Data)) {


			$user_id = $this->session->userdata("customer_id");
			$gat_area = $this->db->query("select cmp_area from tbl_franchise where fid = '$user_id'")->row();
			$area = $gat_area->cmp_area;
			$cutomer = $this->session->userdata("customer_name");
			$branch = $this->session->userdata("branch_name");

			// $branch_name = $branch . " " .$area. "Franchise";
			$branch_name = $branch . "_" . $area;


			//print_r($branch_name);
			//print_r($this->session->all_userdata());
			//exit;




			$user_type = $this->session->userdata("customer_type");

			$balance = $this->db->query("Select * from tbl_customers where customer_id = '$user_id'")->row();
			$amount = $balance->wallet;
			$update_val = $amount - $this->input->post('grand_total');

			if ($update_val < 0) {
				$msg            = 'You Dont Have sufficient Balance!';
				$class            = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);


				redirect('franchise/shipment-list');
			}

			$date = date('Y-m-d', strtotime($this->input->post('booking_date')));
			$this->session->unset_userdata("booking_date");
			$this->session->set_userdata("booking_date", $this->input->post('booking_date'));

			$whr = array('customer_id' => $user_id);
			$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
			$branch_id = $res->row()->branch_id;
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

			$data = array(
				'doc_type' => $this->input->post('doc_type'),
				'doc_nondoc' => $doc_nondoc,
				'courier_company_id' => $this->input->post('courier_company'),
				'company_type' => 'Domestic',
				'mode_dispatch' => $this->input->post('mode_dispatch'),
				'pod_no' => $this->input->post('awn'),
				'forworder_name' => "SELF",
				'risk_type' => $this->input->post('risk_type'),
				//'customer_id' => $this->input->post('customer_account_id'),
				'customer_id' => $user_id,
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
				'payment_method' => $this->input->post('payment_method'),
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
				'sub_total' => $this->input->post('sub_total'),
				'cgst' => $this->input->post('cgst'),
				'sgst' => $this->input->post('sgst'),
				'igst' => $this->input->post('igst'),
				'green_tax' => $green_tax,
				'appt_charges' => $appt_charges,
				'grand_total' => $this->input->post('grand_total'),
				'user_id' => $user_id,
				'user_type' => $user_type,
				'branch_id' => 0,
				'booking_type' => 1


			);



		  //echo '<pre>'; print_r($data);exit;

			$result = $this->db->insert('tbl_domestic_booking', $data);
			echo $this->db->last_query();exit;
			 
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
					'forworder_name' => $data['forworder_name'],
					'forwording_no' => $data['forwording_no'],
					'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
					'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
					'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
				);
				// print_r($data3);
				// exit;

				$result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
					// echo $this->db->last_query();die;
				if ($this->input->post('customer_account_id') != "") {
					$whr = array('customer_id' => $customerid);
					$res = $this->basic_operation_m->getAll('tbl_customers', $whr);
					$email = $res->row()->email;
				}
			}

			if (!empty($result)) {


				$query = "SELECT MAX(topup_balance_id) as id FROM franchise_topup_balance_tbl ";
				$result1 = $this->basic_operation_m->get_query_row($query);
				$id = $result1->id + 1;
				//print_r($id); exit;

				$franchise_id1 = $balance->franchise_id;
                $payment_mode = 'Credit';
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
					$value = $this->session->userdata('customer_id');
					$g_total = $this->input->post('grand_total');
					$balance = $this->db->query("Select * from tbl_customers where customer_id = '$value'")->row();
					$amount = $balance->wallet;
					$update_val = $amount - $this->input->post('grand_total');
					$whr5 = array('customer_id' => $_SESSION['customer_id']);
					$data1 = array('wallet' => $update_val);
					$result = $this->basic_operation_m->update('tbl_customers', $data1, $whr5);
				

			
					$franchise_id1 = $balance->cid;
				//print_r($update_val);exit;

				$data9 = array(

					'franchise_id' =>$franchise_id1,
					'customer_id' =>$user_id,
					'transaction_id' =>$franchise_id,
					'payment_date' => $date,
					'debit_amount' =>$g_total,
				    'balance_amount' =>$update_val,
					'payment_mode' =>$payment_mode,
					'bank_name' =>$bank_name,
					'status' => 1,
					'refrence_no' =>$awb
				);

				//echo '<pre>'; print_r($data9);exit;

				$result =  $this->db->insert('franchise_topup_balance_tbl', $data9);

				}

				
				$msg = 'Your Shipment ' . $podno . ' status:Boked  At Location: ' . $branch_name;
				$class            = 'alert alert-success alert-dismissible';
			} else {
				$msg            = 'Shipment not added successfully';
				$class            = 'alert alert-danger alert-dismissible';
			}
			$this->session->set_flashdata('notify', $msg);
			$this->session->set_flashdata('class', $class);


			redirect('franchise/shipment-list');
		} else {




			$data			= array();

			$result 		= $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
			$id 			= $result->id + 1;
			//  print_r($id);exit;
			if (strlen($id) == 2) {
				$id = 'FBI1000' . $id;
			} elseif (strlen($id) == 3) {
				$id = 'FBI100' . $id;
			} elseif (strlen($id) == 1) {
				$id = 'FBI10000' . $id;
			} elseif (strlen($id) == 4) {
				$id = 'FBI10' . $id;
			} elseif (strlen($id) == 5) {
				$id = 'FBI1' . $id;
			}


			$data['transfer_mode']		 	= $this->basic_operation_m->get_query_result('select * from `transfer_mode`');

			$customer_id 	= $this->session->userdata("customer_id");
			$data['cities']	= $this->basic_operation_m->get_all_result('city', '');
			$data['states'] = $this->basic_operation_m->get_all_result('state', '');

			$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers', "parent_cust_id = '$customer_id'");

			$data['payment_method']  = $this->basic_operation_m->get_all_result('payment_method', '');
			$data['region_master'] = $this->basic_operation_m->get_all_result('region_master', '');
			$data['bid'] = $id;
			$whr_d = array("company_type" => "Domestic");
			$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);
			$data['bid'] 					= $id;
			$this->load->view('franchise/booking_master/add_shipment', $data);
		}
	}

	




	


	public function getCityList_rate() {
		$pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);	
		
		$city_id = $res1->row()->city_id;
		
		$whr2 = array('id' => $city_id);
		$res2 = $this->basic_operation_m->get_table_row('city', $whr2);
		$pincode_city = $res2->id;

		$city_list= $this->basic_operation_m->get_all_result('city', '');

		$resAct = $this->db->query("select service_pincode.*,courier_company.c_id,courier_company.c_company_name from service_pincode JOIN courier_company on courier_company.c_id=service_pincode.forweder_id where pincode='".$pincode."' order by serv_pin_id DESC ");

		$data = array();
		$data['forwarder'] = array();
		if ($resAct->num_rows() > 0) 
        {
            $data['forwarder'] = $resAct->result_array();
        }

		$option="";
		$forwarder="";
		foreach ($city_list as $value) { 
			if($value["id"]==$pincode_city){$selected ="selected";}else{ $selected="";}
			$option.='<option value="'. $value["id"].'" '. $selected.' >'.$value["city"].'</option>';
		}

		if (!empty($data['forwarder'])) {
			foreach ($data['forwarder'] as $key => $value) {
				$servicable = '';
				// if ($value['servicable']==0) {
				// 	//$servicable = 'no service';
				// }else{
				// 	$servicable = 'service';
				// }

				if ($value['oda']==1) {
					
					$servicable = ' - ODA Available';
					
				}else{
					// $servicable = ' ODA Available';
				}
				$forwarder.= "<option value='".$value["c_company_name"]."'>".$value["c_company_name"]."".$servicable."</option>";
			}
		}

		$forwarder.= "<option value='SELF'>SELF</option>";
		unset($data['forwarder']);
		$data['option'] = $option;
		$data['forwarder2'] = $forwarder;

		echo json_encode($data);
	}

	public function getState_rate() {
		$pincode = $this->input->post('pincode');
		$whr1 = array('pin_code' => $pincode);
		$res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);	
		
		$state_id = $res1->row()->state_id;
		if(!empty($state_id))
		{
			$whr3 = array('id' => $state_id);
			$res3 = $this->basic_operation_m->get_table_row('state', $whr3);
			$pincode_state = $res3->id;
			

			$state_list= $this->basic_operation_m->get_all_result('state', '');
			$option="";
			foreach ($state_list as $value) { 
				if($value["id"]==$pincode_state){$selected ="selected";}else{ $selected="";}
				$option.='<option value="'. $value["id"].'" '. $selected.' >'.$value["state"].'</option>';
				}
		}
		else
		{
			$option	= array();
		}


		echo json_encode($option);
		
	}



	public function add_new_rate_franchise_domestic()
	{
		$sub_total 	 = 0;
		// $customer_id = $this->session->userdata('customer_id');
		$customer_id = $this->input->post('customer_id');
		$c_courier_id = $this->input->post('c_courier_id');
		$mode_id  = $this->input->post('mode_id');
		$reciver_city	= $this->input->post('city');
		$reciver_state 	= $this->input->post('state');
		$sender_state 	= $this->input->post('sender_state');
		$sender_city 	= $this->input->post('sender_city');
		$is_appointment = $this->input->post('is_appointment');
		// $invoice_value = $this->input->post('invoice_value');

		$groupId			= $this->basic_operation_m->selectRecord('franchise_delivery_tbl', array('delivery_franchise_id' => $customer_id))->row();

		 //echo $this->db->last_query();exit();
		// print_r($groupId);
// print_r($_POST);exit;

		$whr1 			= array('state' => $sender_state, 'city' => $sender_city);
		$res1			= $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$sender_zone_id 		= $res1->row()->regionid;
		$reciver_zone_id  		= $this->input->post('receiver_zone_id');

		$doc_type 		= $this->input->post('doc_type');
		$chargable_weight  = $this->input->post('chargable_weight');
		$receiver_gstno = $this->input->post('receiver_gstno');
		$booking_date       = $this->input->post('booking_date');
		$risk_type       = $this->input->post('risk_type');
		$invoice_value       = $this->input->post('invoice_value');
		$dispatch_details       = $this->input->post('dispatch_details');
		$current_date = date("Y-m-d", strtotime($booking_date));
		$chargable_weight	= $chargable_weight * 1000;
		$fixed_perkg		= 0;
		$addtional_250		= 0;
		$addtional_500		= 0;
		$addtional_1000		= 0;
		$fixed_per_kg_1000		= 0;
		$tat					= 0;
		$chargable_weight123 = round($this->input->post('chargable_weight'));

		$fixed_pickup_charges = $this->db->query("SELECT * FROM tbl_pickup_charges WHERE  DATE(`createDtm`)<='" . $current_date . "' AND (" . $this->input->post('chargable_weight') . " BETWEEN weight_from AND weight_to) AND isDeleted = 0 ORDER BY createDtm DESC ");
		
		// if ($fixed_pickup_charges->num_rows() > 0) {
		// 	$pickup_rate_data = $fixed_pickup_charges->result_array();
		// 	foreach($pickup_rate_data as $key => $values){
		// 		if($values['weight_type'] == 0){
		// 			$pickup_rate	= $pickup_rate_data['rate'];
		// 		}
		// 		if($values['weight_type'] == 4){
        //             $per_kg_rate =      round($values['rate']);
		// 			$pr =    $chargable_weight *  $per_kg_rate;
		// 			$pickup_rate = round($pr);
		// 		}

		// 		}
		// }

		if ($fixed_pickup_charges->num_rows() > 0) {
			$pickup_rate_data = $fixed_pickup_charges->result_array();

			// print_r($pickup_rate_data);exit;

			// $weight_to_data = $fixed_pickup_charges['weight_to'];

			foreach($pickup_rate_data as $key => $values){

			//	print_r($values);

				if($values['weight_type'] == 0){
					 $fixed_rate	= $values['rate'];
					 $pickup_rate	= $fixed_rate;
					 //$weight_to_data = $values['weight_to'];

				}
				else if($values['weight_type'] == 4){
                    $per_kg_rate =      round($values['rate']);
					$pr =    $chargable_weight123 *  $per_kg_rate;
			    	$pickup_rate = round($pr);
				}

				else if($values['weight_type'] == 3){
					$weight_data = $this->db->get_where('tbl_pickup_charges',['id !=' => $values['id'], 'isDeleted' => 0, 'weight_type' => 0])->row();
					// echo "<pre>"; print_r($weight_data); die;
					$per_additional_rate =      round($values['rate']);
					$leftWt3 = ($chargable_weight123 - $weight_data->weight_to);
					$pr =    ($leftWt3 *  $per_additional_rate) +  $weight_data->rate;
					$pickup_rate = round($pr);

					
				}
			}
		}

		$where					= "from_zone_id='" . $sender_zone_id . "' AND to_zone_id='" . $reciver_zone_id . "'";

		// checking city and state rate 
		$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "' AND city_id='" . $reciver_city . "'  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND (" . $this->input->post('chargable_weight') . " BETWEEN weight_range_from AND weight_range_to) and fixed_perkg = '0' ORDER BY applicable_from DESC LIMIT 1");
		if ($fixed_perkg_result->num_rows() > 0) {
			$where					= "city_id='" . $reciver_city . "'";
		} else {
			$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "' AND city_id='" . $reciver_city . "'  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg = '0' ORDER BY applicable_from DESC,weight_range_to desc LIMIT 1");
			if ($fixed_perkg_result->num_rows() > 0) {
				$where					= "city_id='" . $reciver_city . "'";
			}
		}


		// checking city and state rate 
		$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "' AND state_id='" . $reciver_state . "' and city_id=''  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND (" . $this->input->post('chargable_weight') . " BETWEEN weight_range_from AND weight_range_to) and fixed_perkg = '0' ORDER BY applicable_from DESC LIMIT 1");
		if ($fixed_perkg_result->num_rows() > 0) {
			$where					= "state_id='" . $reciver_state . "'";
		} else {
			$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "' AND state_id='" . $reciver_state . "' and city_id=''  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg = '0' ORDER BY applicable_from DESC,weight_range_to desc LIMIT 1");
			if ($fixed_perkg_result->num_rows() > 0) {
				$where					= "state_id='" . $reciver_state . "'";
			}
		}

		// calculationg fixed per kg price 	
		$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "'  AND $where  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND (" . $this->input->post('chargable_weight') . " BETWEEN weight_range_from AND weight_range_to) and fixed_perkg = '0' ORDER BY applicable_from DESC LIMIT 1");
		$frieht = 0;
	    // echo $this->db->last_query();die;
		if ($fixed_perkg_result->num_rows() > 0) {
			$data['rate_master'] = $fixed_perkg_result->row();
			$rate	= $data['rate_master']->rate;
			$tat	= $data['rate_master']->tat;
			$fixed_perkg = $rate;
		} else {
			$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "' AND $where  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg = '0' ORDER BY applicable_from DESC,weight_range_to desc LIMIT 1");

			$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where 
			group_id='" . @$groupId->rate_group . "' 
			AND from_zone_id=" . $sender_zone_id . " AND to_zone_id=".$reciver_zone_id."			
			AND (city_id=" . $reciver_city . " OR  city_id=0)		
			AND (state_id=" . $reciver_state . " || state_id=0)
			AND (mode_id=" . $mode_id . " || mode_id=0)
			AND DATE(`applicable_from`)<='" . $current_date . "'
			AND (" . $this->input->post('chargable_weight') . " BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,applicable_from DESC LIMIT 1");
			// echo $this->db->last_query();die;
			if ($fixed_perkg_result->num_rows() > 0) {
				$data['rate_master']    = $fixed_perkg_result->row();
				$rate               	= $data['rate_master']->rate;
				$tat          	     	= $data['rate_master']->tat;
				$weight_range_to	    = round($data['rate_master']->weight_range_to * 1000);
				$fixed_perkg            = $rate;
			}

			// $fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "'  AND $where  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg <> '0' ");
			

			// echo "<pre>"; print_r($fixed_perkg_result->result()); die;


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

		}

		$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000;
		// echo $frieht ; die;

		$amount = $frieht;

		$whr1 = array('group_id' => @$groupId->fule_group);
		$res1 = $this->basic_operation_m->get_table_row('franchise_fule_tbl', $whr1);
		// echo "kddjh";
		// echo $this->db->last_query();
		// print_r($res1);


		if ($res1) {

			$cft = 7;
			$cod = '0';
			if ($doc_type == 1) {
				$fov = ($invoice_value * $res1->fov_rate / 100);
			} else {
				$fov = 0;
			}

			$to_pay_charges = '0';
			$appt_charges = '0';
			$fuel_per = '0';
			$docket_charge = $res1->awb_rate;
			$amount	= $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
			$final_fuel_charges = ($amount * $res1->fule_percentage / 100);
		} else {
			$cft = 7;
			$cod = '0';
			$fov = '0';
			$to_pay_charges = '0';
			$appt_charges = '0';
			$fuel_per = '0';
			$docket_charge = '0';
			$amount	= $amount + $fov + $docket_charge + $cod + $to_pay_charges + $appt_charges;
			$final_fuel_charges = ($amount * $fuel_per / 100);
		}

		//Cash
		$sub_total = ($amount + $final_fuel_charges);
		$first_two_char = substr($receiver_gstno, 0, 2);

		if ($receiver_gstno == "") {
			$first_two_char = 27;
		}

		$tbl_customers_info 		= $this->basic_operation_m->get_query_row("select gst_charges from tbl_customers where customer_id = '$customer_id'");

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

		if ($dispatch_details == 'Cash') {
			$cgst = 0;
			$sgst = 0;
			$igst = 0;
			$grand_total = $sub_total + $igst;
		}


		$query = "select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "' AND $where  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND (" . $chargable_weight . " BETWEEN weight_range_from AND weight_range_to)  ORDER BY applicable_from DESC LIMIT 1";

		if ($tat > 0) {
			$tat_date 		=  date('Y-m-d', strtotime($booking_date . " + $tat days"));
		} else {
			$tat_date 		=  date('Y-m-d', strtotime($booking_date . " + 5 days"));
		}

		$cft = 8;

		$data = array(
			'query' => $query,
			'sender_zone_id' => $sender_zone_id,
			'pickup_rate' => $pickup_rate,
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
		);
		echo json_encode($data);
		exit;
	}



	public function calculate_rate()
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
		
		$whr1 			= array('state' => $sender_state,'city' => $sender_city);
		$whr1 			= array('city' => $sender_city);
		$res1			= $this->basic_operation_m->selectRecord('region_master_details', $whr1);	
		
		$sender_zone_id 		= $res1->row()->regionid;


		$whr1 			= array('city' => $reciver_city);
		$res2			= $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$reciver_zone_id  		= $res2->row()->regionid;
		
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
		
		
		$where					= "from_zone_id='".$sender_zone_id."' AND to_zone_id='".$reciver_zone_id."'";

		$fixed_perkg_result = $this->db->query("select * from tbl_domestic_rate_master where 
			(customer_id=".$customer_id." OR  customer_id=0)
			AND from_zone_id=".$sender_zone_id." AND to_zone_id=".$reciver_zone_id."
			AND (city_id=".$reciver_city." OR  city_id=0)
			AND (c_courier_id=".$c_courier_id."  || c_courier_id=0 )
			AND (state_id=".$reciver_state." || state_id=0)
			AND (mode_id=".$mode_id." || mode_id=0)
			AND DATE(`applicable_from`)<='".$current_date."'
			AND (".$this->input->post('chargable_weight')."
			BETWEEN weight_range_from AND weight_range_to)  
			ORDER BY state_id DESC,city_id DESC,customer_id DESC,applicable_from DESC LIMIT 1");
		
		$frieht=0;
		// echo $this->db->last_query();exit();
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

		//print_r($res1);exit;
		
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
				if(!empty($to_pay_charges_Range))
				{
					$res1->to_pay_charges 				=($invoice_value * $to_pay_charges_Range->topay_range_rate/100);
				}
				
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
			
			if($dispatch_details == 'Cash')
			{	
				$cgst = 0;
				$sgst = 0;
				$igst = 0;
				$grand_total = $sub_total + $igst;
			}
			
			
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
		echo json_encode($data);
		exit;
	}


}
