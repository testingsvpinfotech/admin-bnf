<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class RestAPI extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('basic_operation_m');
    }

    public function domestic_booking_get()
    {

        $result = $this->db->query("select count(*) from tbl_domestic_booking order by booking_id desc limit 10")->result();
        echo $this->response($result, REST_Controller::HTTP_OK);
    }

    public function view_customer_post()
    {

        if (!empty($this->post('customer_id'))) {
            $cid = $this->post('customer_id');
            $customer_exist = $this->db->query("SELECT * FROM tbl_customers WHERE cid ='$cid' AND isdeleted = '0'")->row();
            //  echo $this->db->last_query();die;
            if (!empty($customer_exist)) {
                $result = $this->db->query("SELECT transfer_mode_id as mode_dispatch , mode_name FROM transfer_mode ")->result();
                $res = [
                    'status' => 'True',
                    'msg' => "Customer Status active",
                    'data' => $result
                ];
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Customer Not Found Or not active",
                    'data' => ''
                ];
            }
        } else {
            $res = [
                'status' => 'False',
                'msg' => "Customer Id required",
                'data' => ''
            ];
        }
        echo $this->response($res, REST_Controller::HTTP_OK);
    }

    public function addShipment_post()
    {
        $settingData = [];
        $resAct = $this->db->query("select * from setting");
        $setting = $resAct->result();
        foreach ($setting as $value):
            $settingData[$value->key] = $value->value;
        endforeach;
        if (!empty($this->post('customer_id'))) {
            $cid = $this->post('customer_id');
            $customer_exist = $this->db->query("SELECT * FROM tbl_customers WHERE api_key ='$cid' AND api_access = 'Yes' AND isdeleted = '0'")->row();
            //  echo $this->db->last_query();die;
            if (!empty($customer_exist)) {
            
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Customer Not Found Or not active",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        } else {
            $res = [
                'status' => 'False',
                'msg' => "Customer Id required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        //  get customer branch person 
        $cid = $this->post('customer_id');
        $customer_branch_id = $this->basic_operation_m->getAll('tbl_customers', ['api_key' => $cid,'api_access' => 'Yes', 'isdeleted' => 0])->row('branch_id');
        $users_detilas = $this->db->query("SELECT * FROM tbl_users WHERE branch_id = '$customer_branch_id' AND user_type IN ('4','7','1') AND isdeleted = '0' ORDER BY user_id DESC LIMIT 1")->row();
        if (empty($users_detilas)) {
            $res = [
                'status' => 'False',
                'msg' => "User In Branch Not Found Or not active Contact To branch",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }

        

        $username = $users_detilas->username;
        $branch_id = $users_detilas->branch_id;
        $user_id = $users_detilas->user_id;
        $user_type = $users_detilas->user_type;

        date_default_timezone_set('Asia/Kolkata');
        $booking_date = date("Y-m-d H:i:s"); // time in India
        $date = date('Y-m-d H:i:s', strtotime($booking_date));

        // SERVER SIDE VALIDATION START
        // invoice value 
        if(!empty($this->post('invoice_value')))
        {
        if (is_numeric($this->post('invoice_value')) == 1) {
            $invoice_value = $this->post('invoice_value');
        } else {
            $res = [
                'status' => 'False',
                'msg' => "Invoice Amount Not Allowed char",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        }
        else
        {
            $res = [
                'status' => 'False',
                'msg' => "Invoice Amount Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // no of packet 
        if (!empty($this->post('no_of_pack'))) {

            if (is_numeric($this->post('no_of_pack')) == 1) {
                $no_of_pack = $this->post('no_of_pack');
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "No Of Packet Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        } else {
            $res = [
                'status' => 'False',
                'msg' => "No Of Packet Weight Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // actual weight 
        if (!empty($this->post('actual_weight'))) {

            if (is_numeric($this->post('actual_weight')) == 1) {
                $actual_weight = $this->post('actual_weight');
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Actual Weight Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        } else {
            $res = [
                'status' => 'False',
                'msg' => "Actual Weight Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // actual weight 
        if (!empty($this->post('mode_dispatch'))) {

            if (is_numeric($this->post('mode_dispatch')) == 1) {
                $this->post('mode_dispatch');
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Shipment Mode Name Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        } else {
            $res = [
                'status' => 'False',
                'msg' => "Shipment Mode are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // actual weight 
        if (empty($this->post('reciever_name'))) {
            $res = [
                'status' => 'False',
                'msg' => "Consignee Name are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }

        if (empty($this->post('reciever_address'))) {
            $res = [
                'status' => 'False',
                'msg' => "Consignee Address are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }

        // geting Sender contact No ALLOWED Only 10 DIGIT
        if (!empty($this->post('sender_contactno'))) {

            if (is_numeric($this->post('sender_contactno')) == 1) {
                if (strlen($this->post('sender_contactno')) == 10) {
                    $sender_contactno = $this->post('sender_contactno');
                } else {
                    $res = [
                        'status' => 'False',
                        'msg' => "Sender Contact NO Not Valid Mini 10 digit Required",
                        'data' => ''
                    ];
                    echo $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Sender Contact NO Not Valid Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        }
        else
        {
            $res = [
                'status' => 'False',
                'msg' => "Consigner Contact No are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // geting reciever contact No ALLOWED Only 10 DIGIT
        if (!empty($this->post('reciever_contact'))) {

            if (is_numeric($this->post('reciever_contact')) == 1) {
                if (strlen($this->post('reciever_contact')) == 10) {
                    $sender_contactno = $this->post('reciever_contact');
                } else {
                    $res = [
                        'status' => 'False',
                        'msg' => "Reciever Contact NO Not Valid Mini 10 digit Required",
                        'data' => ''
                    ];
                    echo $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Reciever Contact NO Not Valid Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        }
         else 
        {
            $res = [
                'status' => 'False',
                'msg' => "Consignee Contact No are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // geting Sender pincode city state and zone
        if (!empty($this->post('sender_pincode'))) {

            if (is_numeric($this->post('sender_pincode')) == 1) {
                if (strlen($this->post('sender_pincode')) == 6) {
                    $sender = $this->db->query("select * from pincode where pin_code='" . $this->post('sender_pincode') . "' and isdeleted ='0'")->row();
                    $sender_zon_id = $this->db->query("select * from region_master_details where state ='$sender->state_id' and city = '$sender->city_id'")->row();
                    $sender_zon_id->regionid;
                } else {
                    $res = [
                        'status' => 'False',
                        'msg' => "Sender Pincode Not Valid Mini 6 digit Required",
                        'data' => ''
                    ];
                    echo $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Sender Pincode Not Valid Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        }
        else
        {
            $res = [
                'status' => 'False',
                'msg' => "Consigner Pincode are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }
        // geting reciever pincode city state and zone

        if (!empty($this->post('reciever_pincode'))) {

            if (is_numeric($this->post('reciever_pincode')) == 1) {
                if (strlen($this->post('reciever_pincode')) == 6) {
                    $reciever = $this->db->query("select * from pincode where pin_code='" . $this->post('reciever_pincode') . "' and isdeleted ='0'")->row();
                    $reciever_zon_id = $this->db->query("select * from region_master_details where state ='$reciever->state_id' and city = '$reciever->city_id'")->row();
                    $reciever_zon_id->regionid;
                    $reciever_zone = $this->db->query("select * from region_master where region_id='$reciever_zon_id->regionid'")->row();
                } else {
                    $res = [
                        'status' => 'False',
                        'msg' => "Reciever Pincode Not Valid Mini 6 digit Required",
                        'data' => ''
                    ];
                    echo $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
            } else {
                $res = [
                    'status' => 'False',
                    'msg' => "Reciever Pincode Not Valid Not Allowed char",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
        }
        else
        {
            $res = [
                'status' => 'False',
                'msg' => "Consignee Pincode are Required",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }


        // END 

        // VALUE MATRIC RATE CALCULATION 

        if (array_sum(json_decode($this->post('vol_no_of_pkgs'))) == $this->post('no_of_pack')) {
            $vol_no_of_pkgs = json_decode($this->post('vol_no_of_pkgs'));
            $vol_length = json_decode($this->post('vol_length'));
            $vol_breath = json_decode($this->post('vol_breath'));
            $vol_height = json_decode($this->post('vol_height'));
            $vol_actual_weight = json_decode($this->post('vol_actual_weight'));
            $valuematric_w = [];
            $cid = $this->post('customer_id');
            $customer_id_cft = $this->basic_operation_m->getAll('tbl_customers', ['api_key' => $cid, 'api_access' => 'Yes' ,'isdeleted' => 0])->row('customer_id');
            $cft = $this->basic_operation_m->getAll('courier_fuel', ['customer_id' => $customer_id_cft])->row('cft');
            for ($i = 0; $i <= count(json_decode($this->post('vol_no_of_pkgs'))); $i++) {
             

                if (is_numeric($vol_no_of_pkgs[$i]) == 1 && is_numeric($vol_length[$i]) == 1 && is_numeric($vol_breath[$i]) == 1 && is_numeric($vol_height[$i]) == 1 && is_numeric($vol_actual_weight[$i]) == 1) {
                    $valuematric_w[] = +round(($vol_length[$i] * $vol_breath[$i] * $vol_height[$i] / 27000 * $cft) * $vol_no_of_pkgs[$i], 2);
                }

            
            }
            if(empty($valuematric_w)){
                $res = [
                    'status' => 'False',
                    'msg' => "Length , Breath and Height Are Required",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit();
            }
            $total_lenght = array_sum($vol_length);
            $total_perbox = array_sum($vol_no_of_pkgs);
            $total_lenght = array_sum($vol_length);
            $total_breath = array_sum($vol_breath);
            $total_height = array_sum($vol_height);
            $total_valueM = array_sum($valuematric_w);
            $total_vol_actual_weight = array_sum($vol_actual_weight);
            $total_vol_charagable_weight = array_sum($vol_actual_weight);
            $actual_weight = $this->post('actual_weight');

            $c_weight = $actual_weight;
           
            if(!empty($total_vol_actual_weight) && !empty($this->post('actual_weight')))
            {
                
                if( $total_vol_actual_weight - 1 >= $this->post('actual_weight'))
                {
                    $res = [
                        'status' => 'False',
                        'msg' => "Actual Weight is grater than Total Valumetric Actual Weight",
                        'data' => ''
                    ];
                    echo $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
            }     
            // print_r($total_vol_actual_weight);die;
        } else {
            $res = [
                'status' => 'False',
                'msg' => "Please Enter Valid Value Matric No Of Packets",
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        }


        $rest = $this->basic_operation_m->getAll('tbl_customers', ['api_key' => $cid, 'api_access' => 'Yes' ,'isdeleted' => 0]);
        $customerId = $rest->row('customer_id');
        $customerName = $rest->row('customer_name');
        $customerAddress = $rest->row('address');

        if ($customerId != '') {
            $rate = $this->getMasterRates($customerId, $this->post('mode_dispatch'), $date, 'Credit', $this->post('no_of_pack'), $c_weight, $this->post('receiver_gstno'), $this->post('invoice_value'), '0', $sender->state_id, $sender->city_id, $reciever->state_id, $reciever->city_id);
            if ($rate['frieht'] == 0) {
                $rate = $this->get_perbox_rate($customerId, $this->post('mode_dispatch'), $date, 'Credit', $this->post('no_of_pack'), $c_weight, $this->post('receiver_gstno'), $this->post('invoice_value'), '0', $sender->state_id, $sender->city_id, $reciever->state_id, $reciever->city_id, $vol_actual_weight, $vol_no_of_pkgs);
                if (!empty($rate['Message'])) {
                    $res = [
                        'status' => 'False',
                        'msg' => $rate['Message'],
                        'data' => ''
                    ];
                    echo $this->response($res, REST_Controller::HTTP_OK);
                    exit();
                }
            }
        }

        //    print_r($rate);die;
        if (0 == 0) {
            $doc_nondoc = 'Document';
        } else {
            $doc_nondoc = 'Non Document';
        }
        $result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
        $id = $result->id + 1;

        $id = 701000001 + $id;
        $pod_no = trim($this->post('awn'));
        if ($pod_no != "") {
            $awb_no = $pod_no;
            $customer_id = $customerId;
            $exsit = $this->db->query("SELECT * FROM tbl_customer_assign_cnode WHERE customer_id ='$customer_id'")->row();					
			if(!empty($exsit)){
					$stock = $this->db->query("SELECT * FROM tbl_customer_assign_cnode WHERE customer_id ='$customer_id' AND (" . $awb_no . " BETWEEN seriess_from AND seriess_to)")->row();
					if(empty($stock)){
                        $res = [
                            'status' => 'False',
                            'msg' => "This Customer Not Assign Stock Please Contact to Admin",
                            'data' => ''
                        ];
                        echo $this->response($res, REST_Controller::HTTP_OK);
                        exit();
					}
			}
        } else {
            $awb_no = $id;
        }
        $data = array(
            'doc_type' => 1,
            'doc_nondoc' => $doc_nondoc,
            'courier_company_id' => '35',
            'company_type' => 'Domestic',
            'mode_dispatch' => $this->post('mode_dispatch'),
            'pod_no' => $awb_no,
            'forwording_no' => '',
            'forworder_name' => 'SELF',
            'customer_id' => $customerId,
            'sender_name' => $customerName,
            'sender_address' => $customerAddress,
            'sender_city' => $sender->city_id,
            'sender_state' => $sender->state_id,
            'sender_pincode' => $this->post('sender_pincode'),
            'sender_contactno' => $this->post('sender_contactno'),
            'sender_gstno' => $this->post('sender_gstno'),
            'reciever_name' => $this->post('reciever_name'),
            'contactperson_name' => $this->post('reciever_name'),
            'reciever_address' => $this->post('reciever_address'),
            'reciever_contact' => $this->post('reciever_contact'),
            'reciever_pincode' => $this->post('reciever_pincode'),
            'reciever_city' => $reciever->city_id,
            'reciever_state' => $reciever->state_id,
            'receiver_zone' => $reciever_zone->region_name,
            'receiver_zone_id' => $reciever_zon_id->regionid,
            'receiver_gstno' => $this->post('receiver_gstno'),
            'ref_no' => '',
            'delivery_date' => $rate['tat_date'],
            'invoice_no' => $this->post('invoice_no'),
            'invoice_value' => $this->post('invoice_value'),
            'eway_no' => $this->post('eway_no'),
            'risk_type' => 'CUSTOMER',
            'special_instruction' => $this->post('special_instruction'),
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
            'web_or_app' => '2',
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
            $res = [
                'status' => 'False',
                'msg' => "Already Exist " . $awb_no . '<br>',
                'data' => ''
            ];
            echo $this->response($res, REST_Controller::HTTP_OK);
            exit();
        } else {
            // echo '<pre>'; print_r($data); die;
            $query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);

            $lastid = $this->db->insert_id();

            // foreach($vol_actual_weight as $value) 
            // {
            //     $items[] = $value;
            // }
            // print_r($items);die;
            if($rate['minimum_weight'] >= $total_vol_actual_weight)
            {
                  $c_w = $rate['minimum_weight'];
            }
            else 
            {
                $c_w = $total_vol_actual_weight;
            }
            $weight_data = array(
                'per_box_weight_detail' => array_values($vol_no_of_pkgs),
                'length_detail' => $this->post('vol_length'),
                'breath_detail' => $this->post('vol_breath'),
                'height_detail' => $this->post('vol_height'),
                'valumetric_weight_detail' => json_encode($valuematric_w),
                'valumetric_actual_detail' => $vol_actual_weight,
                'valumetric_chageable_detail' => $vol_actual_weight,
                'per_box_weight' => $total_perbox,
                'length' => $total_lenght,
                'breath' => $total_breath,
                'height' => $total_height,
                'valumetric_weight' => $total_valueM,
                'valumetric_actual' => $total_vol_actual_weight,
                'valumetric_chageable' => $total_vol_actual_weight,
            );

            $weight_details = json_encode($weight_data);
            //  $p = array_values($vol_no_of_pkgs);
            // echo '<pre>'; print_r($weight_details); die;


            $data2 = array(
                'booking_id' => $lastid,
                'actual_weight' => $this->post('actual_weight'),
                'length' => $total_lenght,
                'breath' => $total_breath,
                'height' => $total_height,
                'valumetric_weight' => $total_valueM,
                'chargable_weight' => $c_w,
                'per_box_weight' => $total_perbox,
                'no_of_pack' => $this->post('no_of_pack'),
                'actual_weight_detail' => json_encode($vol_actual_weight, JSON_FORCE_OBJECT),
                'valumetric_weight_detail' => json_encode($valuematric_w),
                'chargable_weight_detail' => json_encode($c_w, JSON_FORCE_OBJECT),
                'length_detail' => $this->post('vol_length'),
                'breath_detail' => $this->post('vol_breath'),
                'height_detail' => $this->post('vol_height'),
                'no_pack_detail' => json_encode($this->post('no_of_pack')),
                'per_box_weight_detail' => $this->post('vol_no_of_pkgs'),
                'weight_details' => $weight_details,
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
    
            $destination = $this->basic_operation_m->getAll('tbl_branch_service', ['pincode'=>$this->post('reciever_pincode')])->row('branch_id');
            $stock = array(
                'delivery_branch' => $destination,
                'destination_pincode' => $this->post('reciever_pincode'),
                'current_branch' => $branch_id,
                'pod_no' => $podno,
                'booking_id' => $lastid,
                'booked' => '1'
            );
            $this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);

            if ($customerId != "") {
                $whr = array('customer_id' => $customerid);
                $res = $this->basic_operation_m->getAll('tbl_customers', $whr);
                //$email= $res->row()->email;
            }

            $message = 'Your Shipment booked AWB : ' . $podno . ' At Location: ' . $branch_name;
            if ($lastid) {
                $res = [
                    'status' => 'success',
                    'msg' => $message,
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit;
            } else {

                $res = [
                    'status' => 'Error',
                    'msg' => "Something went to wrong please check sending data",
                    'data' => ''
                ];
                echo $this->response($res, REST_Controller::HTTP_OK);
                exit;
            }


        }
    }

    // public function addShipment_post()
    // {
    //     $settingData = [];
    //     $resAct = $this->db->query("select * from setting");
    //     $setting = $resAct->result();
    //     foreach ($setting as $value):
    //         $settingData[$value->key] = $value->value;
    //     endforeach;
    //     if (!empty($this->post('customer_id'))) {
    //         $cid = $this->post('customer_id');
    //         $customer_exist = $this->db->query("SELECT * FROM tbl_customers WHERE cid ='$cid' AND isdeleted = '0'")->row();
    //         //  echo $this->db->last_query();die;
    //         if (!empty($customer_exist)) {
            
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Customer Not Found Or not active",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     } else {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Customer Id required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     //  get customer branch person 
    //     $cid = $this->post('customer_id');
    //     $customer_branch_id = $this->basic_operation_m->getAll('tbl_customers', ['cid' => $cid, 'isdeleted' => 0])->row('branch_id');
    //     $users_detilas = $this->db->query("SELECT * FROM tbl_users WHERE branch_id = '$customer_branch_id' AND user_type IN ('4','7','1') AND isdeleted = '0' ORDER BY user_id DESC LIMIT 1")->row();
    //     if (empty($users_detilas)) {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "User In Branch Not Found Or not active Contact To branch",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }

        

    //     $username = $users_detilas->username;
    //     $branch_id = $users_detilas->branch_id;
    //     $user_id = $users_detilas->user_id;
    //     $user_type = $users_detilas->user_type;

    //     date_default_timezone_set('Asia/Kolkata');
    //     $booking_date = date("Y-m-d H:i:s"); // time in India
    //     $date = date('Y-m-d H:i:s', strtotime($booking_date));

    //     // SERVER SIDE VALIDATION START
    //     // invoice value 
    //     if(!empty($this->post('invoice_value')))
    //     {
    //     if (is_numeric($this->post('invoice_value')) == 1) {
    //         $invoice_value = $this->post('invoice_value');
    //     } else {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Invoice Amount Not Allowed char",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     }
    //     else
    //     {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Invoice Amount Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // no of packet 
    //     if (!empty($this->post('no_of_pack'))) {

    //         if (is_numeric($this->post('no_of_pack')) == 1) {
    //             $no_of_pack = $this->post('no_of_pack');
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "No Of Packet Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     } else {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "No Of Packet Weight Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // actual weight 
    //     if (!empty($this->post('actual_weight'))) {

    //         if (is_numeric($this->post('actual_weight')) == 1) {
    //             $actual_weight = $this->post('actual_weight');
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Actual Weight Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     } else {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Actual Weight Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // actual weight 
    //     if (!empty($this->post('mode_dispatch'))) {

    //         if (is_numeric($this->post('mode_dispatch')) == 1) {
    //             $this->post('mode_dispatch');
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Shipment Mode Name Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     } else {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Shipment Mode are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // actual weight 
    //     if (empty($this->post('reciever_name'))) {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Consignee Name are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }

    //     if (empty($this->post('reciever_address'))) {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Consignee Address are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }

    //     // geting Sender contact No ALLOWED Only 10 DIGIT
    //     if (!empty($this->post('sender_contactno'))) {

    //         if (is_numeric($this->post('sender_contactno')) == 1) {
    //             if (strlen($this->post('sender_contactno')) == 10) {
    //                 $sender_contactno = $this->post('sender_contactno');
    //             } else {
    //                 $res = [
    //                     'status' => 'False',
    //                     'msg' => "Sender Contact NO Not Valid Mini 10 digit Required",
    //                     'data' => ''
    //                 ];
    //                 echo $this->response($res, REST_Controller::HTTP_OK);
    //                 exit();
    //             }
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Sender Contact NO Not Valid Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     }
    //     else
    //     {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Consigner Contact No are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // geting reciever contact No ALLOWED Only 10 DIGIT
    //     if (!empty($this->post('reciever_contact'))) {

    //         if (is_numeric($this->post('reciever_contact')) == 1) {
    //             if (strlen($this->post('reciever_contact')) == 10) {
    //                 $sender_contactno = $this->post('reciever_contact');
    //             } else {
    //                 $res = [
    //                     'status' => 'False',
    //                     'msg' => "Reciever Contact NO Not Valid Mini 10 digit Required",
    //                     'data' => ''
    //                 ];
    //                 echo $this->response($res, REST_Controller::HTTP_OK);
    //                 exit();
    //             }
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Reciever Contact NO Not Valid Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     }
    //      else 
    //     {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Consignee Contact No are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // geting Sender pincode city state and zone
    //     if (!empty($this->post('sender_pincode'))) {

    //         if (is_numeric($this->post('sender_pincode')) == 1) {
    //             if (strlen($this->post('sender_pincode')) == 6) {
    //                 $sender = $this->db->query("select * from pincode where pin_code='" . $this->post('sender_pincode') . "'")->row();
    //                 $sender_zon_id = $this->db->query("select * from region_master_details where state ='$sender->state_id' and city = '$sender->city_id'")->row();
    //                 $sender_zon_id->regionid;
    //             } else {
    //                 $res = [
    //                     'status' => 'False',
    //                     'msg' => "Sender Pincode Not Valid Mini 6 digit Required",
    //                     'data' => ''
    //                 ];
    //                 echo $this->response($res, REST_Controller::HTTP_OK);
    //                 exit();
    //             }
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Sender Pincode Not Valid Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     }
    //     else
    //     {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Consigner Pincode are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }
    //     // geting reciever pincode city state and zone

    //     if (!empty($this->post('reciever_pincode'))) {

    //         if (is_numeric($this->post('reciever_pincode')) == 1) {
    //             if (strlen($this->post('reciever_pincode')) == 6) {
    //                 $reciever = $this->db->query("select * from pincode where pin_code='" . $this->post('reciever_pincode') . "'")->row();
    //                 $reciever_zon_id = $this->db->query("select * from region_master_details where state ='$reciever->state_id' and city = '$reciever->city_id'")->row();
    //                 $reciever_zon_id->regionid;
    //                 $reciever_zone = $this->db->query("select * from region_master where region_id='$reciever_zon_id->regionid'")->row();
    //             } else {
    //                 $res = [
    //                     'status' => 'False',
    //                     'msg' => "Reciever Pincode Not Valid Mini 6 digit Required",
    //                     'data' => ''
    //                 ];
    //                 echo $this->response($res, REST_Controller::HTTP_OK);
    //                 exit();
    //             }
    //         } else {
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Reciever Pincode Not Valid Not Allowed char",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //     }
    //     else
    //     {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Consignee Pincode are Required",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }


    //     // END 

    //     // VALUE MATRIC RATE CALCULATION 

    //     if (array_sum(json_decode($this->post('vol_no_of_pkgs'))) == $this->post('no_of_pack')) {
    //         $vol_no_of_pkgs = json_decode($this->post('vol_no_of_pkgs'));
    //         $vol_length = json_decode($this->post('vol_length'));
    //         $vol_breath = json_decode($this->post('vol_breath'));
    //         $vol_height = json_decode($this->post('vol_height'));
    //         $vol_actual_weight = json_decode($this->post('vol_actual_weight'));
    //         $valuematric_w = [];
    //         $cid = $this->post('customer_id');
    //         $customer_id_cft = $this->basic_operation_m->getAll('tbl_customers', ['cid' => $cid, 'isdeleted' => 0])->row('customer_id');
    //         $cft = $this->basic_operation_m->getAll('courier_fuel', ['customer_id' => $customer_id_cft])->row('cft');
    //         for ($i = 0; $i <= count(json_decode($this->post('vol_no_of_pkgs'))); $i++) {
             

    //             if (is_numeric($vol_no_of_pkgs[$i]) == 1 && is_numeric($vol_length[$i]) == 1 && is_numeric($vol_breath[$i]) == 1 && is_numeric($vol_height[$i]) == 1 && is_numeric($vol_actual_weight[$i]) == 1) {
    //                 $valuematric_w[] = +round(($vol_length[$i] * $vol_breath[$i] * $vol_height[$i] / 27000 * $cft) * $vol_no_of_pkgs[$i], 2);
    //             }

            
    //         }
    //         if(empty($valuematric_w)){
    //             $res = [
    //                 'status' => 'False',
    //                 'msg' => "Length , Breath and Height Are Required",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit();
    //         }
    //         $total_lenght = array_sum($vol_length);
    //         $total_perbox = array_sum($vol_no_of_pkgs);
    //         $total_lenght = array_sum($vol_length);
    //         $total_breath = array_sum($vol_breath);
    //         $total_height = array_sum($vol_height);
    //         $total_valueM = array_sum($valuematric_w);
    //         $total_vol_actual_weight = array_sum($vol_actual_weight);
    //         $total_vol_charagable_weight = array_sum($vol_actual_weight);
    //         $actual_weight = $this->post('actual_weight');

    //         $c_weight = $actual_weight;
           
    //         if(!empty($total_vol_actual_weight) && !empty($this->post('actual_weight')))
    //         {
                
    //             if( $total_vol_actual_weight - 1 >= $this->post('actual_weight'))
    //             {
    //                 $res = [
    //                     'status' => 'False',
    //                     'msg' => "Actual Weight is grater than Total Valumetric Actual Weight",
    //                     'data' => ''
    //                 ];
    //                 echo $this->response($res, REST_Controller::HTTP_OK);
    //                 exit();
    //             }
    //         }     
    //         // print_r($total_vol_actual_weight);die;
    //     } else {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Please Enter Valid Value Matric No Of Packets",
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     }


    //     $rest = $this->basic_operation_m->getAll('tbl_customers', ['cid' => $cid, 'isdeleted' => 0]);
    //     $customerId = $rest->row('customer_id');
    //     $customerName = $rest->row('customer_name');
    //     $customerAddress = $rest->row('address');

    //     if ($customerId != '') {
    //         $rate = $this->getMasterRates($customerId, $this->post('mode_dispatch'), $date, 'Credit', $this->post('no_of_pack'), $c_weight, $this->post('receiver_gstno'), $this->post('invoice_value'), '0', $sender->state_id, $sender->city_id, $reciever->state_id, $reciever->city_id);
    //         if ($rate['frieht'] == 0) {
    //             $rate = $this->get_perbox_rate($customerId, $this->post('mode_dispatch'), $date, 'Credit', $this->post('no_of_pack'), $c_weight, $this->post('receiver_gstno'), $this->post('invoice_value'), '0', $sender->state_id, $sender->city_id, $reciever->state_id, $reciever->city_id, $vol_actual_weight, $vol_no_of_pkgs);
    //             if (!empty($rate['Message'])) {
    //                 $res = [
    //                     'status' => 'False',
    //                     'msg' => $rate['Message'],
    //                     'data' => ''
    //                 ];
    //                 echo $this->response($res, REST_Controller::HTTP_OK);
    //                 exit();
    //             }
    //         }
    //     }

    //     //    print_r($rate);die;
    //     if (0 == 0) {
    //         $doc_nondoc = 'Document';
    //     } else {
    //         $doc_nondoc = 'Non Document';
    //     }
    //     $result = $this->db->query('select max(booking_id) AS id from tbl_domestic_booking')->row();
    //     $id = $result->id + 1;

    //     $id = 701000001 + $id;
    //     $pod_no = trim($this->input->post('awn'));
    //     if ($pod_no != "") {
    //         $awb_no = $pod_no;
    //     } else {
    //         $awb_no = $id;
    //     }
    //     $data = array(
    //         'doc_type' => 1,
    //         'doc_nondoc' => $doc_nondoc,
    //         'courier_company_id' => '35',
    //         'company_type' => 'Domestic',
    //         'mode_dispatch' => $this->post('mode_dispatch'),
    //         'pod_no' => $awb_no,
    //         'forwording_no' => '',
    //         'forworder_name' => 'SELF',
    //         'customer_id' => $customerId,
    //         'sender_name' => $customerName,
    //         'sender_address' => $customerAddress,
    //         'sender_city' => $sender->city_id,
    //         'sender_state' => $sender->state_id,
    //         'sender_pincode' => $this->post('sender_pincode'),
    //         'sender_contactno' => $this->post('sender_contactno'),
    //         'sender_gstno' => $this->post('sender_gstno'),
    //         'reciever_name' => $this->post('reciever_name'),
    //         'contactperson_name' => $this->post('reciever_name'),
    //         'reciever_address' => $this->post('reciever_address'),
    //         'reciever_contact' => $this->post('reciever_contact'),
    //         'reciever_pincode' => $this->post('reciever_pincode'),
    //         'reciever_city' => $reciever->city_id,
    //         'reciever_state' => $reciever->state_id,
    //         'receiver_zone' => $reciever_zone->region_name,
    //         'receiver_zone_id' => $reciever_zon_id->regionid,
    //         'receiver_gstno' => $this->post('receiver_gstno'),
    //         'ref_no' => '',
    //         'delivery_date' => $rate['tat_date'],
    //         'invoice_no' => $this->post('invoice_no'),
    //         'invoice_value' => $this->post('invoice_value'),
    //         'eway_no' => $this->post('eway_no'),
    //         'risk_type' => 'CUSTOMER',
    //         'special_instruction' => $this->post('special_instruction'),
    //         //'type_of_pack' => $this->input->post('type_of_pack'),
    //         'type_shipment' => 'Carton',
    //         'booking_date' => $date,
    //         'dispatch_details' => 'CREDIT',
    //         'payment_method' => '',
    //         'frieht' => $rate['frieht'],
    //         'transportation_charges' => '0',
    //         'pickup_charges' => '0',
    //         'delivery_charges' => '0',
    //         'courier_charges' => '0',
    //         'other_charges' => '0',
    //         'web_or_app' => '2',
    //         'awb_charges' => $rate['docket_charge'],
    //         'fov_charges' => $rate['fov'],
    //         'total_amount' => $rate['amount'],
    //         'fuel_subcharges' => $rate['final_fuel_charges'],
    //         'sub_total' => $rate['sub_total'],
    //         'cgst' => $rate['cgst'],
    //         'sgst' => $rate['sgst'],
    //         'igst' => $rate['igst'],
    //         'grand_total' => $rate['grand_total'],
    //         'user_id' => $user_id,
    //         'user_type' => $user_type,
    //         'branch_id' => $branch_id,
    //         'booking_type' => 1,
    //     );
    //     // echo '<pre>';print_r($data);die;
    //     $whr = array('pod_no' => $awb_no);
    //     $res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
    //     if ($res->num_rows()) {
    //         $res = [
    //             'status' => 'False',
    //             'msg' => "Already Exist " . $awb_no . '<br>',
    //             'data' => ''
    //         ];
    //         echo $this->response($res, REST_Controller::HTTP_OK);
    //         exit();
    //     } else {
    //         // echo '<pre>'; print_r($data); die;
    //         $query = $this->basic_operation_m->insert('tbl_domestic_booking', $data);

    //         $lastid = $this->db->insert_id();

    //         // foreach($vol_actual_weight as $value) 
    //         // {
    //         //     $items[] = $value;
    //         // }
    //         // print_r($items);die;
    //         if($rate['minimum_weight'] >= $total_vol_actual_weight)
    //         {
    //               $c_w = $rate['minimum_weight'];
    //         }
    //         else 
    //         {
    //             $c_w = $total_vol_actual_weight;
    //         }
    //         $weight_data = array(
    //             'per_box_weight_detail' => array_values($vol_no_of_pkgs),
    //             'length_detail' => $this->post('vol_length'),
    //             'breath_detail' => $this->post('vol_breath'),
    //             'height_detail' => $this->post('vol_height'),
    //             'valumetric_weight_detail' => json_encode($valuematric_w),
    //             'valumetric_actual_detail' => $vol_actual_weight,
    //             'valumetric_chageable_detail' => $vol_actual_weight,
    //             'per_box_weight' => $total_perbox,
    //             'length' => $total_lenght,
    //             'breath' => $total_breath,
    //             'height' => $total_height,
    //             'valumetric_weight' => $total_valueM,
    //             'valumetric_actual' => $total_vol_actual_weight,
    //             'valumetric_chageable' => $total_vol_actual_weight,
    //         );

    //         $weight_details = json_encode($weight_data);
    //         //  $p = array_values($vol_no_of_pkgs);
    //         // echo '<pre>'; print_r($weight_details); die;


    //         $data2 = array(
    //             'booking_id' => $lastid,
    //             'actual_weight' => $this->post('actual_weight'),
    //             'length' => $total_lenght,
    //             'breath' => $total_breath,
    //             'height' => $total_height,
    //             'valumetric_weight' => $total_valueM,
    //             'chargable_weight' => $c_w,
    //             'per_box_weight' => $total_perbox,
    //             'no_of_pack' => $this->post('no_of_pack'),
    //             'actual_weight_detail' => json_encode($vol_actual_weight, JSON_FORCE_OBJECT),
    //             'valumetric_weight_detail' => json_encode($valuematric_w),
    //             'chargable_weight_detail' => json_encode($c_w, JSON_FORCE_OBJECT),
    //             'length_detail' => $this->post('vol_length'),
    //             'breath_detail' => $this->post('vol_breath'),
    //             'height_detail' => $this->post('vol_height'),
    //             'no_pack_detail' => json_encode($this->post('no_of_pack')),
    //             'per_box_weight_detail' => $this->post('vol_no_of_pkgs'),
    //             'weight_details' => $weight_details,
    //         );
    //         //  echo '<pre>'; print_r($data2); die;
    //         $query2 = $this->basic_operation_m->insert('tbl_domestic_weight_details', $data2);
    //         // echo $lastidw = $this->db->insert_id();

    //         $whr = array('branch_id' => $branch_id);
    //         $res = $this->basic_operation_m->getAll('tbl_branch', $whr);
    //         $branch_name = $res->row()->branch_name;

    //         $whr = array('booking_id' => $lastid);
    //         $res = $this->basic_operation_m->getAll('tbl_domestic_booking', $whr);
    //         $podno = $res->row()->pod_no;
    //         $customerid = $res->row()->customer_id;
    //         $data3 = array(
    //             'id' => '',
    //             'pod_no' => $podno,
    //             'status' => 'Booked',
    //             'branch_name' => $branch_name,
    //             'tracking_date' => $date,
    //             'booking_id' => $lastid,
    //             'forworder_name' => $data['forworder_name'],
    //             'forwording_no' => $data['forwording_no'],
    //             'is_spoton' => ($data['forworder_name'] == 'spoton_service') ? 1 : 0,
    //             'is_delhivery_b2b' => ($data['forworder_name'] == 'delhivery_b2b') ? 1 : 0,
    //             'is_delhivery_c2c' => ($data['forworder_name'] == 'delhivery_c2c') ? 1 : 0
    //         );

    //         $result3 = $this->basic_operation_m->insert('tbl_domestic_tracking', $data3);
    
    //         $destination = $this->basic_operation_m->getAll('tbl_branch_service', ['pincode'=>$this->post('reciever_pincode')])->row('branch_id');
    //         $stock = array(
    //             'delivery_branch' => $destination,
    //             'destination_pincode' => $this->post('reciever_pincode'),
    //             'current_branch' => $branch_id,
    //             'pod_no' => $podno,
    //             'booking_id' => $lastid,
    //             'booked' => '1'
    //         );
    //         $this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);

    //         if ($customerId != "") {
    //             $whr = array('customer_id' => $customerid);
    //             $res = $this->basic_operation_m->getAll('tbl_customers', $whr);
    //             //$email= $res->row()->email;
    //         }

    //         $message = 'Your Shipment booked AWB : ' . $podno . ' At Location: ' . $branch_name;
    //         if ($lastid) {
    //             $res = [
    //                 'status' => 'success',
    //                 'msg' => $message,
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit;
    //         } else {

    //             $res = [
    //                 'status' => 'Error',
    //                 'msg' => "Something went to wrong please check sending data",
    //                 'data' => ''
    //             ];
    //             echo $this->response($res, REST_Controller::HTTP_OK);
    //             exit;
    //         }


    //     }
    // }

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


        // $is_appointment = $this->input->post('is_appointment');
        // $packet = $this->input->post('packet');
        // $actual_weight = $this->input->post('actual_weight');
        // $whr1 = array('state' => $sender_state, 'city' => $sender_city);
        // $res1 = $this->basic_operation_m->selectRecord('region_master_details', $whr1);
        // $sender_zone_id = $res1->row()->regionid;
        // $reciver_zone_id = $this->input->post('receiver_zone_id');
        // $doc_type = $this->input->post('doc_type');
        // $chargable_weight = $this->input->post('chargable_weight');
        // $chargable_weight1 = $this->input->post('chargable_weight');
        // $receiver_gstno = $this->input->post('receiver_gstno');
        // $booking_date = $this->input->post('booking_date');
        // $invoice_value = $this->input->post('invoice_value');
        // $dispatch_details = $this->input->post('dispatch_details');
        // $per_box = $this->input->post('per_box');
        // $perBox_actual = $this->input->post('perBox_actual');
        // $current_date = date("Y-m-d", strtotime($booking_date));
        // $chargable_weight = $chargable_weight * 1000;
        // $fixed_perkg = 0;
        // $addtional_250 = 0;
        // $addtional_500 = 0;
        // $addtional_1000 = 0;
        // $fixed_per_kg_1000 = 0;
        // $tat = 0;
        // $drum_perkg = 0;
        // print_r($_POST);die;
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
                    $minimum_weight = $values->minimum_weight;
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
                'minimum_weight' => $minimum_weight,
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
            'minimum_weight' => $minimum_weight,
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












}
?>