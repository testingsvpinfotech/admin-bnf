<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class Pickup_Request_Controller extends CI_Controller
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
		$userType	=	$this->session->userdata("userType");
		$branch_id =	$this->session->userdata('branch_id');

		$data = array();
		$data['message'] = "";
		//	$customer_id					=	$this->session->userdata("customer_id");
		if (!empty($userType == '1')) {
		$data['all_request']    = $this->db->query("select tbl_pickup_request_data.*,transfer_mode.mode_name,pickup_weight_tbl.destination_pincode,pickup_weight_tbl.actual_weight,pickup_weight_tbl.type_of_package,pickup_weight_tbl.no_of_pack from  tbl_pickup_request_data left join pickup_weight_tbl on pickup_weight_tbl.pickup_id =  tbl_pickup_request_data.id left join transfer_mode on transfer_mode.transfer_mode_id=tbl_pickup_request_data.mode_id order by tbl_pickup_request_data.pickup_request_id desc")->result();
		}else{
		$data['all_request']    = $this->db->query("select tbl_pickup_request_data.*,transfer_mode.mode_name,pickup_weight_tbl.destination_pincode,pickup_weight_tbl.actual_weight,pickup_weight_tbl.type_of_package,pickup_weight_tbl.no_of_pack from  tbl_pickup_request_data left join pickup_weight_tbl on pickup_weight_tbl.pickup_id =  tbl_pickup_request_data.id left join transfer_mode on transfer_mode.transfer_mode_id=tbl_pickup_request_data.mode_id  where tbl_pickup_request_data.branch_id ='$branch_id' order by tbl_pickup_request_data.pickup_request_id desc")->result();
		}
		$download_query 		="select tbl_pickup_request_data.*,transfer_mode.mode_name,pickup_weight_tbl.destination_pincode,pickup_weight_tbl.actual_weight,pickup_weight_tbl.type_of_package,pickup_weight_tbl.no_of_pack from  tbl_pickup_request_data left join pickup_weight_tbl on pickup_weight_tbl.pickup_id =  tbl_pickup_request_data.id left join transfer_mode on transfer_mode.transfer_mode_id=tbl_pickup_request_data.mode_id order by tbl_pickup_request_data.pickup_request_id desc";
		if(isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report')
			{
				$resActtt 			= $this->db->query($download_query);
				$prq_data		= $resActtt->result_array();
				$this->download_prq_list($prq_data);
			}
		
		$this->load->view('admin/pickup/admin_view_pickup_request', $data);
	}

	public function download_prq_list($prq_data)
	{    
	
		$date=date('d-m-Y');
		$filename = "PrqList_".$date.".csv";
		$fp = fopen('php://output', 'w');
			
		$header =array("Consignee Name.","Pickup Request_id","Consignee Contact","Consignee Address1","Consignee Address2","Consignee Address3","Consignee Email","Pickup Pincode","Destination Pincode","Pickup Location","Pickup Date","Destination City","Instruction","Mode","Weight","Type Of Package","NOP");

			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		fputcsv($fp, $header);
		$i =0;
		foreach($prq_data as $row) 
		{
			$i++;

			$whr=array('transfer_mode_id'=>$row['mode_id']);
            $mode_details = $this->basic_operation_m->get_table_row_array('transfer_mode',$whr);

            // $whr_u =array('branch_id'=>$row['branch_id']);
            // $branch_details = $this->basic_operation_m->get_table_row_array('tbl_branch', $whr_u);


            // $whr_u =array('user_id'=>$row['user_id']);
            // $user_details = $this->basic_operation_m->get_table_row_array('tbl_users', $whr_u);
            // $user_details['username'] = substr($user_details['username'],0,20);
			//print_r(  $user_details['username']);


			
			// $whr=array('id'=>$row['sender_city']);
			// $sender_city_details = $this->basic_operation_m->get_table_row("city",$whr);
			// $sender_city = @$sender_city_details->city;
			
			// $whr_s=array('id'=>$row['reciever_state']);
			// $reciever_state_details = $this->basic_operation_m->get_table_row("state",$whr_s);
			// $reciever_state = @$reciever_state_details->state;
			
			
			$roww=array(
				$row['consigner_name'],
				$row['pickup_request_id'],
				$row['consigner_contact'],
				$row['consigner_address1'],
				$row['consigner_address2'],
				$row['consigner_address3'],
				$row['consigner_email'],
				$row['pickup_pincode'],
				$row['destination_pincode'],
				$row['pickup_location'],
				$row['pickup_date'],
				$row['city'],
				$row['instruction'],
				$mode_details['mode_name'],
				$row['actual_weight'],
				$row['type_of_package'],
				$row['no_of_pack'],
				
			);
			
			
			fputcsv($fp, $roww);
			
			
		}
		exit;
   	}

	public function fetch_consigner()
	{
		ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
		$pickup_request_no = $this->input->post('pickup_request_no');
		$dd = $this->db->query("select tbl_pickup_request_data.*,tbl_customers.customer_name,tbl_customers.customer_type,tbl_customers.cid from tbl_pickup_request_data left join tbl_customers  ON tbl_customers.customer_id = tbl_pickup_request_data.customer_id  where pickup_request_id ='$pickup_request_no'")->row();
		//	echo $this->db->last_query();
		echo  json_encode($dd);
	}


	public function get_pickup_id()
	{
		$get_pickup_no = $this->input->get('id');
		$dd2 = $this->db->query("select pickup_request_id from  tbl_pickup_request_data where pickup_request_id = '$get_pickup_no '")->row();
		echo json_encode($dd2);
	}
	public function status_change_pickup()
	{
		$pickup_request_id = $this->input->post('pickup_request_id');
		$status_closed_by = $this->input->post('status_closed_by');
		$status_closed_reason = $this->input->post('status_closed_reason');
		$status = $this->input->post('status');
		$this->db->query("update tbl_pickup_request_data set pickup_status = '$status',status_closed_by  = '$status_closed_by',status_closed_reason = '$status_closed_reason' where pickup_request_id ='$pickup_request_id '");
		//	echo $this->db->last_query();exit;
		$this->session->set_flashdata('msg', 'PRQ Close Successfully!!');
		redirect(base_url() . 'admin/all-pickup-request-list');
	}

	public function reschedul_prq()
	{
		//echo 'hello';exit;
		$pickup_request_id = $this->input->post('pickup_request_id');
		$branch_id = $this->input->post('branch_id');
		$this->db->query("update tbl_pickup_request_data set branch_id = '$branch_id' where pickup_request_id ='$pickup_request_id'");
		//	echo $this->db->last_query();exit;
		$this->session->set_flashdata('msg', 'Rescheduled PRQ');
		redirect(base_url() . 'admin/all-pickup-request-list');

	}





	public function add_prq_for_cs()
	{
		$userId	=	$this->session->userdata("userId");
		$data			= array();
		$result 		= $this->db->query('select max(id) AS id from tbl_pickup_request_data')->row();
		$id 			= $result->id + 1;
		$date = date('ym');
		if (strlen($id) == 2) {
			$id = 'BNF/' . $date . '/000' . $id;
		} elseif (strlen($id) == 3) {
			$id = 'BNF/' . $date . '/000' . $id;
		} elseif (strlen($id) == 1) {
			$id = 'BNF/' . $date . '/000' . $id;
		} elseif (strlen($id) == 4) {
			$id = 'BNF/' . $date . '/000' . $id;
		} elseif (strlen($id) == 5) {
			$id = 'BNF/' . $date . '/000' . $id;
		}
		$data['request_id'] = $id;

		$data['cs_prq_list'] = $this->db->query("select * from tbl_pickup_request_data where user_id ='$userId'order by pickup_request_id DESC limit 7")->result();
		$data['type_of_package'] = $this->db->query("select * from partial_type_tbl")->result();
		$data['time'] = $this->db->query("select * from pickup_time_slot_tbl")->result();
		$data['transfer_mode'] = $this->db->query("select * from transfer_mode")->result();
		$data['customers'] = $this->db->query("select * from tbl_customers")->result_array();
		$this->load->view('admin/pickup/add_prq', $data);
	}



	public function store_prq_for_cs()
	{
		if (isset($_POST['submit'])) {

			$r1 = array();
			$user_type =   $this->session->userdata('userType');
			$userId	=	$this->session->userdata("userId");
			$recurring_data1  = $_POST['recurring_data'];
			$recurring_data = implode(",", $recurring_data1);

			$pickup_date = $this->input->post('pickup_date');

			$pickup_time = $this->input->post('pickup_time');
			$pickup_pincode = $this->input->post('pickup_pincode');

			$pickup_date_time = $pickup_date . "  " . $pickup_time;
			$c_date = $date = date('Y-m-d H:i:s');

			//	print_r($pickup_date_time);exit;
			$r = array(
				'id' => '',
				'user_id' => $userId,
				'recurring_data' => $recurring_data,
				'customer_type' => $user_type,
				'customer_id' => $this->input->post('customer_id'),
				'consigner_name' => $this->input->post('consigner_name'),
				'pickup_request_id' => $this->input->post('pickup_request_id'),
				'consigner_contact' => $this->input->post('consigner_contact'),
				'consigner_address1' => $this->input->post('consigner_address1'),
				'consigner_address2' => $this->input->post('consigner_address2'),
				'consigner_address3' => $this->input->post('consigner_address3'),
				'consigner_email' => $this->input->post('consigner_email'),
				'pickup_pincode' => $this->input->post('pickup_pincode'),
				'pickup_location' => $this->input->post('pickup_location'),
				'pickup_date' => $pickup_date_time,
				'city' => $this->input->post('city'),
				'instruction' => $this->input->post('instruction'),
				'mode_id' => $this->input->post('mode_id'),
				'create_date'=>$c_date


			);
			//print_r($r);exit;

			$result = $this->basic_operation_m->insert('tbl_pickup_request_data', $r);

			$destination_pincode = $this->input->post('destination_pincode[]');
			$count = count($this->input->post('destination_pincode[]'));
			//$destination_location = '';
			$actual_weight = $this->input->post('actual_weight[]');
			$type_of_package = $this->input->post('type_of_package[]');
			$no_of_pack = $this->input->post('no_of_pack[]');
			$lastid = $this->db->insert_id();

			//  print_r($count);exit;
			for ($i = 0; $i < $count; $i++) {
				$r1 = array(
					'pickup_id' => $lastid,
					'destination_pincode' => $destination_pincode[$i],
					//  'destination_location' =>$destination_location[$i],
					'actual_weight' => $actual_weight[$i],
					'type_of_package' => $type_of_package[$i],
					'no_of_pack' => $no_of_pack[$i],
				);
				// print_r($r1);

				$result = $this->db->insert('pickup_weight_tbl', $r1);
				//  echo $this->db->last_query();exit;
			}
			
            
			if(!empty($pickup_pincode)){

				$pickup_pincode_data = $this->db->query("select pickup_pincode from tbl_pickup_request_data where id = '$lastid'")->row_array();
				$pin_code = $pickup_pincode_data['pickup_pincode'];
				$branch_pincode = $this->db->query("select * from tbl_branch_service where pincode = '$pin_code'")->row_array();
				$get_branch_id = $branch_pincode['branch_id'];

				$this->db->set('branch_id', $get_branch_id);
		        $this->db->where('id', $lastid);
	         	$this->db->update('tbl_pickup_request_data');
			}
           


			if (!empty($result)) {
				$this->session->set_flashdata('flash_message', "Data Inserted Successfully!!");
			}
			redirect('admin/add_prq_data');
		}
	}

	public function all_pickup_request_list()
	{
		$userType	=	$this->session->userdata("userType");
		$branch_id =	$this->session->userdata('branch_id');
		if (!empty($userType == '1')) {
			$data['pickup_boy'] = $this->db->query("SELECT * FROM tbl_users WHERE user_type = '3'")->result_array();
		} else {
			$data['pickup_boy'] = $this->db->query("SELECT * FROM tbl_users WHERE branch_id ='$branch_id' AND user_type = '3'")->result_array();
		}
		$data['branch_name'] = $this->db->query("select * from tbl_branch")->result_array();
		// $data['show_prq_list'] =  $this->db->query("select * from tbl_pickup_request_data where  branch_id ='0' AND customer_type ='10' OR customer_type ='0' order by pickup_request_id DESC")->result_array();
		if (!empty($userType == '1'  ||  $userType == '16')) {
			$data['show_prq_list'] =  $this->db->query("select * from tbl_pickup_request_data order by pickup_request_id DESC")->result_array();
		} else {
			$data['show_prq_list'] =  $this->db->query("select * from tbl_pickup_request_data where branch_id ='$branch_id' order by pickup_request_id DESC")->result_array();
		}
		$this->load->view('admin/pickup/all_pickup_request_list', $data);
	}


	//   public function request_quote(){
	// 	   $userType	=	$this->session->userdata("userType");
	// 	  // print_r($this->session->all_userdata());
	//        $data['show_prq_list'] = $this->db->query("select * from tbl_pickup_request_data where branch_id !='0' AND customer_type ='10' OR customer_type ='1'  order by pickup_request_id DESC ")->result_array();
	//        $this->load->view("admin/pickup/view_prq_list",$data);

	//    } 

	public function branch_assigned_prq_list()
	{
		$branch_id =	$this->session->userdata('branch_id');
		$userType	=	$this->session->userdata("userType");
		if (!empty($userType == '1')) {
			$data['pickup_boy'] = $this->db->query("SELECT * FROM tbl_users WHERE user_type = '3'")->result_array();
		} else {
			$data['pickup_boy'] = $this->db->query("SELECT * FROM tbl_users WHERE branch_id ='$branch_id' AND user_type = '3'")->result_array();
		}
		if (!empty($userType == '1'  ||  $userType == '16')) {
			$data['show_prq_list'] =  $this->db->query("select * from tbl_pickup_request_data where branch_id !='0' order by pickup_request_id DESC ")->result_array();
			$this->load->view("admin/pickup/branch_wise_prq_list", $data);
		} else {
			$data['show_prq_list'] =  $this->db->query("select * from tbl_pickup_request_data where branch_id ='$branch_id'order by pickup_request_id DESC ")->result_array();
			$this->load->view("admin/pickup/branch_wise_prq_list", $data);
		}
	}

	public function prq_assign_pickupboy()
	{
		$id = $this->input->post('id');
		$pickup_boy_assigned_date = $this->input->post('pickup_boy_assigned_date');
		$username = $this->input->post('username');


		$result = $this->db->query("update tbl_pickup_request_data set pickup_boy ='$username', pickup_status = '2', pickup_boy_date_assigned ='$pickup_boy_assigned_date' where id='$id' ");
		//echo $this->db->last_query();exit;
		echo json_encode(['success' => "Item Update successfully."]);
	}

	public function prq_list()
	{
		$prq_id = $this->input->get('id');
		$data = $this->db->query("select tbl_pickup_request_data.*,transfer_mode.mode_name,pickup_weight_tbl.destination_pincode,pickup_weight_tbl.actual_weight,pickup_weight_tbl.type_of_package,pickup_weight_tbl.no_of_pack from  tbl_pickup_request_data left join pickup_weight_tbl on pickup_weight_tbl.pickup_id =  tbl_pickup_request_data.id left join transfer_mode on transfer_mode.transfer_mode_id=tbl_pickup_request_data.mode_id where id = '$prq_id'")->result_array();
		echo json_encode($data);
	}



	public function get_pickup_request()
	{

		$prq_id = $this->input->get('prq_no');
		$dd5 = $this->db->query("Select tbl_domestic_booking.*,tbl_domestic_weight_details.actual_weight from  tbl_domestic_booking left join tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id where prq_no = '$prq_id'")->result();
		echo json_encode($dd5);
	}



	public function assign_branch()
	{

		$result 		= $this->db->query('select max(id) AS id from tbl_pickup_request_data')->row();
		$id = $result->id + 1;

		if (strlen($id) == 2) {
			$id = 'PRQ00000' . $id;
		} elseif (strlen($id) == 3) {
			$id = 'PRQ0000' . $id;
		} elseif (strlen($id) == 1) {
			$id = 'PRQ000000' . $id;
		} elseif (strlen($id) == 4) {
			$id = 'PRQ000' . $id;
		} elseif (strlen($id) == 5) {
			$id = 'PRQ00' . $id;
		}
		$sub_docket = $id;

		$get_branch_id = $this->input->post('branch_id');
		$id = $this->input->post('id');
		// print_r($id);
		// print_r($get_branch_id );

		$this->db->set('branch_id', $get_branch_id, 'par_docket', $sub_docket);
		$this->db->where_in('id', explode(",", $id));
		$this->db->update('tbl_pickup_request_data');
		//echo $this->db->last_query();

		echo json_encode(['success' => "Item Update successfully."]);
	}

	public function add_pickup_time()
	{
		if (isset($_POST['submit'])) {
			$data = array(
				'time' => $this->input->post('time_sloat'),
			);
			$this->db->insert('pickup_time_slot_tbl', $data);
			$this->session->set_flashdata('msg', 'Time Added');
			redirect(base_url() . 'admin/add_pickup_time');
		}
		$data['time_data'] = $this->db->query("select * from pickup_time_slot_tbl")->result();
		$this->load->view('admin/pickup/add_sloat_time', $data);
	}

	public function delete_time($id)
	{
		$this->db->query("delete from pickup_time_slot_tbl where id='$id'");
		$this->session->set_flashdata('msg', 'Data Deleted Successfully!!');
		redirect(base_url() . 'admin/add_pickup_time');
	}
}
