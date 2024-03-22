<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Franchise_admin_edit_shipment extends CI_Controller {

	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}

	public function index()
	{		
		$all_data = $this->input->post();
		//print_r($all_data);exit;
		if($all_data)
		{	
			// print_r($all_data);die;
			$filter_value = 	$_POST['filter_value'];
		    $data['domestic_booking'] = $this->db->query("select * from tbl_domestic_booking where pod_no = '$filter_value'")->result_array();
			// echo $this->db->last_query();die;
		}else{
		    $data['domestic_booking'] = array();   
		}
		$data['filter_value'] = (isset($_POST['filter_value']))?$_POST['filter_value']:'';   
        $this->load->view('admin/Franchise_edit_shipment/admin_edit_shipment', $data);     
	}

	public function add_new_rate_domestic()
	{
		$sub_total 	 = 0;
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

		// echo $this->db->last_query();exit();
		// print_r($groupId);


		$whr1 			= array('state' => $sender_state, 'city' => $sender_city);
		$res1			= $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$sender_zone_id 		= $res1->row()->regionid;
		$reciver_zone_id  		= $this->input->post('receiver_zone_id');

		$doc_type 		= $this->input->post('doc_type');
		$chargable_weight  = $this->input->post('chargable_weight');
		$receiver_gstno = $this->input->post('receiver_gstno');
		$booking_date       = $this->input->post('booking_date');
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

			$fixed_perkg_result = $this->db->query("select * from tbl_franchise_rate_master where group_id='" . @$groupId->rate_group . "'  AND $where  AND mode_id='" . $mode_id . "' AND DATE(`applicable_from`)<='" . $current_date . "' AND fixed_perkg <> '0' ");
			



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

		}

		$frieht = $fixed_perkg + $addtional_250 + $addtional_500 + $addtional_1000 + $fixed_per_kg_1000;
		$amount = $frieht;

		$whr1 = array('group_id' => @$groupId->fule_group);
		$res1 = $this->basic_operation_m->get_table_row('franchise_fule_tbl', $whr1);
		// echo "kddjh";
		// echo $this->db->last_query();
		// print_r($res1);


		if ($res1) {

			$cft = 8;
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
			$cft = 8;
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

		//print_r($get_fuel_details);exit; from_date

		$current_date = date("Y-m-d", strtotime($booking_date));

		$whr1 = array('from_date <=' => $current_date, 'to_date >=' => $current_date, 'group_id' => $dd);
		$res1 = $this->db->query("select * from franchise_fule_tbl where from_date <='$current_date' AND to_date >='$current_date' AND group_id = '$dd' ")->row();
		//echo $this->db->last_query();exit;

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

		//print_r($final_fuel_charges);
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
        // print_r($data);die;
		echo json_encode($data);
	}


	public function getZone()
	{
		$reciever_state = $this->input->post('reciever_state');
		$reciever_city =  $this->input->post('reciever_city');
    //    print_r($_POST);die;
		$whr1 = array('state' => $reciever_state, 'city' => $reciever_city);
		$res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);

		$regionid = $res1->row()->regionid;

		$whr3 = array('region_id' => $regionid);
		$res3 = $this->basic_operation_m->selectRecord('region_master', $whr3);
		$result3 = $res3->row();

		echo json_encode($result3);
	}


	

	public function edit_shipment($id =0){

		$whr = array('booking_id' => $id);
		if ($id != "") 
		{
			$data['booking'] = $this->basic_operation_m->get_table_row('tbl_domestic_booking', $whr);
			
			$data['weight'] = $this->basic_operation_m->get_table_row('tbl_domestic_weight_details', $whr);
			
		}
		$data['transfer_mode']		 	= $this->basic_operation_m->get_query_result('select * from `transfer_mode`');
		$data['cities']	= $this->basic_operation_m->get_all_result('city', '');
		$data['states'] = $this->basic_operation_m->get_all_result('state', '');

		$data['customers'] = $this->basic_operation_m->get_all_result('tbl_customers','');

		$data['payment_method']  = $this->basic_operation_m->get_all_result('payment_method', '');
		$data['region_master'] = $this->basic_operation_m->get_all_result('region_master', '');
		$data['bid'] = $id;
		$whr_d = array("company_type" => "Domestic");
		$data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_d);
		$data['bid'] 					= $id;
		$this->load->view('admin/Franchise_edit_shipment/edit_shipment', $data);
	}
	
	public function update_shipment($id)
		{
			$all_data 		= $this->input->post();
			$all_data2 		= $this->input->post();
        

			if (!empty($all_data)) 
			{
				$whr = array('booking_id' => $id);
				$date = date('Y-m-d',strtotime($this->input->post('booking_date')));
					//booking details//
					
					if($this->input->post('doc_type') == 0)
					{
						$doc_nondoc			= 'Document';
					}
					else
					{
						$doc_nondoc			= 'Non Document';
					}
					
				$username = $this->session->userdata("userName");
				$user_id = $this->session->userdata("userId");
				$user_type = $this->session->userdata("userType");
				$whr_u = array('username' => $username);
				$res = $this->basic_operation_m->getAll('tbl_users', $whr_u);
				$branch_id = $res->row()->branch_id;

				$date = date('Y-m-d',strtotime( $this->input->post('booking_date')));

				$reciever_pincode= $this->input->post('reciever_pincode');
				$reciever_city= $this->input->post('reciever_city');
				$reciever_state= $this->input->post('reciever_state');

				$whr_pincode = array('pin_code'=>$reciever_pincode,'city_id'=>$reciever_city,'state_id'=>$reciever_state); 
				$check_city =$this->basic_operation_m->get_table_row('pincode',$whr_pincode);
				//echo "++++".$this->db->last_query();
				if(empty($check_city) && !empty($reciever_city))
				{	$whr_C =array('id'=>$reciever_city);
					$city_details = $this->basic_operation_m->get_table_row('city',$whr_C);
					$whr_S =array('id'=>$reciever_state);
					$state_details = $this->basic_operation_m->get_table_row('state',$whr_S);
					// print_r($this->input->post('reciever_city')); die;

					$pincode_data = array(
						'pin_code'=>$reciever_pincode,
						'city'=>$city_details->city,
						'city_id'=>$reciever_city,
						'state'=>$state_details->state,
						'state_id'=>$reciever_state);
					
					$whr_p = array('pin_code'=>$reciever_pincode);
					$qry = $this->basic_operation_m->update('pincode', $pincode_data, $whr_p);				
				}
				$is_appointment = ($this->input->post('is_appointment') == 'ON')?1:0;


					$data = array(
						'doc_type' => $this->input->post('doc_type'),
						'doc_nondoc' => $doc_nondoc,
						'courier_company_id' => $this->input->post('courier_company'),
						'company_type' => 'Domestic',
						'mode_dispatch' => $this->input->post('mode_dispatch'),
						'pod_no' => $this->input->post('awn'),
						'forworder_name' => "SELF",
						'risk_type' => $this->input->post('risk_type'),
						// 'customer_id' => $this->input->post('customer_account_id'),
						// 'customer_id' => $user_id,
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
						'transportation_charges' => $this->input->post('transportation_charges'),
						'insurance_charges' => $this->input->post('insurance_charges'),
						'pickup_charges' => $this->input->post('pickup_charges'),
						'delivery_charges' => $this->input->post('delivery_charges'),
						'courier_charges' => $this->input->post('courier_charges'),
						'awb_charges' => $this->input->post('awb_charges'),
						'other_charges' => $this->input->post('other_charges'),
						'total_amount' => $this->input->post('amount'),
						'fuel_subcharges' => $this->input->post('fuel_subcharges'),
						'sub_total' => $this->input->post('sub_total'),
						'cgst' => $this->input->post('cgst'),
						'sgst' => $this->input->post('sgst'),
						'igst' => $this->input->post('igst'),
						'green_tax' => $this->input->post('green_tax'),
						'appt_charges' => $this->input->post('appt_charges'),
						'grand_total' => $this->input->post('grand_total')
						// 'user_id' => $user_id,
						// 'user_type' => $user_type,
						// 'branch_id' => 0,
						// 'booking_type' => 1
					);
					// echo '<pre>';print_r($data);die;
					$query = $this->basic_operation_m->update('tbl_domestic_booking', $data, $whr);
									

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
							'per_box_weight_detail' =>json_encode($this->input->post('per_box_weight_detail[]')),
							'weight_details' =>$weight_details,
						);
						// echo '<pre>'; print_r($data2);
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
					$customerid= $res->row()->customer_id;
					$data3 = array(
						'tracking_date' => date('Y-m-d H:i:s',strtotime($this->input->post('booking_date')))
					);
					
					// echo '<pre>';print_r($data3);die;
					$where2 = array('status'=>'Booked','pod_no'=>$this->input->post('awn'));
				$query2 = $this->basic_operation_m->update('tbl_domestic_tracking', $data3, $where2);
			
				if ($this->db->affected_rows() > 0) 	
				{
					$data['message'] = "Shipment Updated successfull";
				}
				else 
				{
					$data['message'] = "Failed to Submit";
				}
		
			redirect('admin/franchise-edit-view-list');
			}
		}


	
	
}
?>