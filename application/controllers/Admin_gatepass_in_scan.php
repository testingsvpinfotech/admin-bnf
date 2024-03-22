<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_gatepass_in_scan extends CI_Controller
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
		$data = array();
		$ress = $this->basic_operation_m->getAll('tbl_branch', '');
		$data['all_branch'] = $ress->result();
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		$search = trim($this->input->post('gatepass_no'));
		$search2 = trim($this->input->post('bag_scan'));
		$user_id = $this->session->userdata('userId');
		if ($search) {
			// $whrtest = array('gatepass_no' => $search, 'gatepass' => '1','line_hual_id'=>'0', 'gatepass_in_scan' => '0');
			// $result = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $whrtest);
			$result = $this->db->query("select * from tbl_domestic_menifiest where gatepass_no ='$search'and gatepass = '1'and line_access = '0' and destination_branch ='$source_branch' and line_hual_id='0' and gatepass_in_scan = '0' group by manifiest_id");

			
			if(!empty($result->result())){
				$data['result'] = $result->result(); 
			}else{
				// $whr3 = array('gatepass_no' => $search, 'gatepass' => '1','m_manifest_destination'=>$branch_id, 'gatepass_in_scan' => '0');
			    // $ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $whr3);
				$ress = $this->db->query("select * from tbl_domestic_menifiest where gatepass_no ='$search'and gatepass = '1' and line_access = '1' and m_manifest_destination='$branch_id' and gatepass_in_scan = '0' group by manifiest_id");
				$data['result'] = $ress->result(); 
				
			}
			// echo $this->db->last_query();die;
			//print_r($data['result']);die();
		} else {
			$whr3 = array('gatepass_no' => $search2, 'source_branch' => $source_branch, 'gatepass' => '1');
			$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $whr3);
			$data['result'] = $ress->result();

		}
		$this->load->view('admin/Gatepass_in_scan/gatepass_in_scan_genrate', $data);
	}


	public function check_destination()
	{
		$data = array();
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		$manifest = $this->input->post('manifest');
		$whr3 = array('manifiest_id' => $manifest);
		$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $whr3);
		$data = $ress->row();
		if($data->destination_branch == $source_branch){
          echo 1;
		}else{
		  echo 2;
		}



	}

	// public function gatepass_in_scan_genrated()
	// {
	// 	$data = array();
	// 	$ress = $this->basic_operation_m->getAll('tbl_branch', '');
	// 	$data['all_branch'] = $ress->result();
	// 	$username = $this->session->userdata("userName");
	// 	$whr = array('username' => $username);
	// 	$res = $this->basic_operation_m->getAll('tbl_users', $whr);
	// 	$branch_id = $res->row()->branch_id;
	// 	$user_id = $res->row()->user_id;
	// 	$where = array('branch_id' => $branch_id);
	// 	$where = array('branch_id' => $branch_id);
	// 	$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
	// 	$source_branch = $ress->row()->branch_name;
	// 	$where1 = array('source_branch' => $source_branch, 'genrate_bag' => '0', 'manifiest_verifed' => '1');
	// 	$ress = $this->basic_operation_m->getAll('tbl_bagmaster', $where);
	// 	$data['bag'] = $ress->result();
	// 	$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $where1);
	// 	$data['menifest'] = $ress->result();
	// 	// $search = $this->input->post('menifest');
	// 	$search2 = $this->input->post('gate_no');
	// 	$user_id = $this->session->userdata('userId');
	// 	if ($user_id == '1') {
	// 		ini_set('display_errors', '0');
	// 		ini_set('display_startup_errors', '0');
	// 		error_reporting(E_ALL);
	// 		if ($this->input->post()) {
	// 			$where3 = array('gatepass_no' => $search2);
	// 			$ress = $this->basic_operation_m->getAll('tbl_domestic_gatepass_in_scan', $where3);
	// 			$data['result'] = $ress->result();
	// 			//print_r($data['menifest']);die();
	// 		} else {

	// 			$ress = $this->basic_operation_m->getAll('tbl_domestic_gatepass_in_scan', $where2);
	// 			$data['result'] = $ress->result();
	// 		}
	// 	} else {
	// 		if ($this->input->post()) {
	// 			$where3 = array('destination_branch' => $source_branch, 'gatepass_no' => $search2);
	// 			$ress = $this->basic_operation_m->getAll('tbl_domestic_gatepass_in_scan', $where3);
	// 			$data['result'] = $ress->result();
	// 			//print_r($data['menifest']);die();
	// 		} else {
	// 			$where2 = array('destination_branch' => $source_branch);
	// 			$ress = $this->basic_operation_m->getAll('tbl_domestic_gatepass_in_scan', $where2);
	// 			$data['result'] = $ress->result();
	// 		}
	// 	}
	// 	$this->load->view('admin/Gatepass_in_scan/view_gatepass_genrated', $data);
	// }

	public function gatepass_in_scan_genrated()
	{
		$data = array();
		$ress = $this->basic_operation_m->getAll('tbl_branch', '');
		$data['all_branch'] = $ress->result();
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		$where1 = array('source_branch' => $source_branch, 'genrate_bag' => '0', 'manifiest_verifed' => '1');
		$ress = $this->basic_operation_m->getAll('tbl_bagmaster', $where);
		$data['bag'] = $ress->result();
		$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $where1);
		$data['menifest'] = $ress->result();
		// $search = $this->input->post('menifest');
		$search2 = $this->input->post('gate_no');
		$user_id = $this->session->userdata('userId');
		if ($user_id == '1') {
			// ini_set('display_errors', '0');
			// ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			if ($this->input->post()) {
				$where3 = array('gatepass_no' => $search2);
				$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $where3);
				$data['result'] = $ress->result();
				//print_r($data['menifest']);die();
			} else {

				$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $where2);
				$data['result'] = $ress->result();
			}
		} else {
			if ($this->input->post()) {
				$where3 = array('destination_branch' => $source_branch, 'gatepass_no' => $search2);
				$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $where3);
				$data['result'] = $ress->result();
				//print_r($data['menifest']);die();
			} else {
				$where2 = array('destination_branch' => $source_branch);
				$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $where2);
				$data['result'] = $ress->result();
			}
		}
		$this->load->view('admin/Gatepass_in_scan/view_gatepass_genrated', $data);
	}

	public function gatepass_genrated_in_scan()
	{
		$username = $this->session->userdata("userName");
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


		if ($this->input->post()) {

			$manifiest_check = $this->input->post('manifiest_check');
			$manifiest_uncheck = $this->input->post('manifiest_uncheck');
			$remark = $this->input->post('remark');
            //   print_r($_POST);die;
			if (!empty($manifiest_check)) {
                
				for ($i = 0; $i <= count($manifiest_check); $i++) {	
					// $this->db->trans_begin();
					$where = array('manifiest_id' => $manifiest_check[$i]);
					$manifest_details = $this->basic_operation_m->get_all_result('tbl_domestic_menifiest', $where);
					
					foreach ($manifest_details as $key => $value) {
					   
						$where = array('bag_id' => $value['bag_no']);
						$result = $this->basic_operation_m->get_all_result('tbl_domestic_bag', $where);
					
						$data = array(
							'gatepass_in_scan' => '1'
						);
						$whr4 = array('bag_no' => $value['bag_no']);
						$result5 = $this->basic_operation_m->update('tbl_domestic_menifiest', $data, $whr4);
					
						foreach ($result as $value) {
							$all_data['pod_no'] = $value['pod_no'];
							$all_data['forwording_no'] = $value['forwording_no'];
							$all_data['forworder_name'] = $value['forwarder_name'];
							$all_data['branch_name'] = $branch_name;
							$all_data['added_branch'] = $value['source_branch'];
							$all_data['status'] = 'Master Manifest in-scan';
							$all_data['remarks'] = $remark[$i];
							$all_data['tracking_date'] = $this->input->post('datetime');
							$track = $this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
							$pod_no = $value['pod_no'];
							$queue_dataa1 = "update tbl_domestic_stock_history set gatepass_inscan ='1', current_branch ='$branch_id' where pod_no = '$pod_no'";
							$status = $this->db->query($queue_dataa1);
						}
					}

					$where1 = array('manifiest_id' => $manifest);
					$resul = $this->basic_operation_m->get_all_result('tbl_domestic_menifiest', $where1);


					$valu['gatepass_no'] = $resul[0]['gatepass_no'];
					$valu['manifiest_id'] = $resul[0]['manifiest_id'];
					$valu['bag_no'] = $resul[0]['bag_no'];
					$valu['source_branch'] = $resul[0]['source_branch'];
					$valu['destination_branch'] = $resul[0]['destination_branch'];
					$valu['lorry_no'] = $resul[0]['lorry_no'];
					$valu['driver_name'] = $resul[0]['driver_name'];
					$valu['date'] = $this->input->post('datetime');
					$valu['in_scan'] = $this->input->post('username');
					$valu['bkdate_reason'] = $this->input->post('bkdate_reason');
					$track = $this->basic_operation_m->insert('tbl_domestic_gatepass_in_scan', $valu);
				}
					$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Master Menifest In-Scan', $valu);

					if ($this->db->trans_status() === FALSE) {
					// if (empty($track)) {
						$this->db->trans_rollback();
						$msg = 'Something went wrong ';
						$class = 'alert alert-success alert-dismissible';

						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
					} else {
						$this->db->trans_commit();
						$msg = 'Master Manifest In-Scan successfully';
						$class = 'alert alert-success alert-dismissible';

						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
					}				
			}
			if(!empty($manifiest_uncheck)){
                
                for ($i = 0; $i < count($manifiest_uncheck); $i++) {	
					
					$where = array('manifiest_id' => $manifiest_uncheck[$i]);
					$manifest_details = $this->basic_operation_m->get_all_result('tbl_domestic_menifiest', $where);
					
					foreach ($manifest_details as $key => $value) {
					
						$where = array('bag_id' => $value['bag_no']);
						$result = $this->basic_operation_m->get_all_result('tbl_domestic_bag', $where);
					
						$data = array(
							'gatepass' => '0',
							'gatepass_in_scan' => '0'
						);
						$whr4 = array('manifiest_id' => $value['manifiest_id']);
						$result5 = $this->basic_operation_m->update('tbl_domestic_menifiest', $data, $whr4);
						
						// print_r($manifest_details);die;
						foreach ($result as $value) {
							$all_data['pod_no'] = $value['pod_no']; 
							$all_data['booking_id'] = '0'; 
							$all_data['forworder_name'] = $value['forwarder_name'];
							$all_data['branch_name'] = $branch_name;
							$all_data['added_branch'] = $value['source_branch'];
							$all_data['status'] = 'Master Manifest in-scan';
							$all_data['remarks'] = $remark[$i];
							$all_data['tracking_date'] = $this->input->post('datetime');
							$track = $this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
							// echo $this->db->last_query();die;
						}
					}
				}
				$this->db->trans_begin();
				   $this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Master Menifest In-Scan Line Hual', $all_data);
				
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$msg = 'Something went wrong ';
						$class = 'alert alert-success alert-dismissible';

						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
					} else {
						$this->db->trans_commit();
						$msg = 'Master Manifest In-Scan successfully';
						$class = 'alert alert-success alert-dismissible';

						$this->session->set_flashdata('notify', $msg);
						$this->session->set_flashdata('class', $class);
					}
			}
			redirect('admin/gatepass-in-scan');

			// $this->load->view('admin/Bagmaster/bag_genrate', $data);
		}
	}

	// UPDATE PART B START
	public function update_partB()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://app-qa.cxipl.com/api/v2/eway-bill/291009978764/update-partb',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => '{
		"vehicleType": "R",
		"transMode": 1,
		"vehicleNo": "TS08GJ9330",
		"fromPlace": "Kannappar",
		"fromState": 33,
		"reasonRem": "Goods",
		"transDocNo": "NM1234",
		"transDocDate": "12/03/2019",
		"reasonCode": 1
		}',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'authkey: YZD7VV6JTC25XK5P3CJTC9V9Q5AZ7TB4'
			),
		)
		);

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}
	// UPDATE PART B END
}