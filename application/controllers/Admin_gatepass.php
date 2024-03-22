<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_gatepass extends CI_Controller
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
		$search = $this->input->post('menifest');
		$search2 = $this->input->post('bag_scan');
		$user_id = $this->session->userdata('userId');
		if ($search) {
			//$whr3 = array('manifiest_id'=>$search,'gatepass' => '0','source_branch'=> $source_branch);
			$ress = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$search' AND source_branch = '$source_branch' AND gatepass= '0' ");
			$data['result'] = $ress->result();

		} else {
			$whr3 = array('bag_no' => $search2, 'gatepass' => '0', 'source_branch' => $source_branch);
			$ress = $this->basic_operation_m->getAll('tbl_domestic_menifiest', $whr3);
			$data['result'] = $ress->result();

		}

		$data['mode_list'] = $this->db->query("select * from transfer_mode")->result_array();
		$data['line_hual'] = $this->db->query("select * from tbl_line_hual_master")->result();
		$this->load->view('admin/Gatepass/add_master_menifiest', $data);
	}

	public function gatepass_upcoming()
	{
		$data = array();
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;
		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		$data['result'] = $this->db->query("select tbl_gatepass.* from tbl_domestic_menifiest Left join tbl_gatepass on tbl_domestic_menifiest.manifiest_id = tbl_gatepass.manifiest_id where tbl_domestic_menifiest.gatepass = '1' and tbl_domestic_menifiest.destination_branch = '$source_branch'order by tbl_gatepass.id desc")->result();

		$this->load->view('admin/Gatepass/view_gatepass_upcoming', $data);
	}
	public function gatepass_genrated()
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
			if ($this->input->post()) {
				$where3 = array('gatepass_no' => $search2);
				$ress = $this->basic_operation_m->getAll('tbl_gatepass', $where3);
				$ress = $this->db->query("select * from tbl_gatepass where gatepass_no = '$search2' order by id desc");
				$data['result'] = $ress->result();
				//print_r($data['menifest']);die();
			} else {

				// $ress					=	$this->basic_operation_m->getAll('tbl_gatepass', '');
				$ress = $this->db->query("select * from tbl_gatepass  order by id desc");
				$data['result'] = $ress->result();
			}
		} else {
			if ($this->input->post()) {
				// $where3 = array('gatepass_no'=>$search2,'origin' => $source_branch);
				// $ress					=	$this->basic_operation_m->getAll('tbl_gatepass', $where3);
				$ress = $this->db->query("select * from tbl_gatepass where origin = '$source_branch' and gatepass_no = '$search2' order by id desc");
				$data['result'] = $ress->result();
				//echo $this->db->last_query();die();

			} else {
				// $where2 = array('origin' => $source_branch);
				// $ress					=	$this->basic_operation_m->getAll('tbl_gatepass', $where2);
				$ress = $this->db->query("select * from tbl_gatepass where genrated_by = '$username' order by id desc");
				$data['result'] = $ress->result();

			}
			// print_r($data['result']);die();
		}

		$this->load->view('admin/Gatepass/view_gatepass_genrated', $data);
	}

	public function line_branch()
	{ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
		$line = $this->input->post('line');
		if(!empty($line)){
			$option =[];
			echo $option = "<option value='' selected>-- Select Branch --</option>";   
			$line_hual = $this->db->query("select * from tbl_line_hual_master_details where routeid = '$line'")->result();
			foreach($line_hual as $key=>$value){
				
				$branch_info = $this->db->query("select branch_id,branch_name from tbl_branch where state ='$value->state' and city = '$value->city'")->result_array();
				if(!empty($branch_info)){
				 foreach($branch_info as $key => $value){
				  echo $option = "<option value='".$value['branch_id']."'>".$value['branch_name']."</option>";
				 }
				 }

			//    $branch_info = $this->db->query("select * from tbl_branch where state ='$value->state' and city = '$value->city'")->row_array();
			//    if(!empty($branch_info)){
			//      echo $option = "<option value='".$branch_info['branch_id']."'>".$branch_info['branch_name']."</option>";
			// 	 }
			
			}
		}
		// die;
		// echo $option;
	}
	public function bagdata()
	{
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
		$bag_id = trim($_REQUEST['forwording_no']);
		$forwarderName = trim($_REQUEST['forwarderName']);
		$mode_dispatch = trim($_REQUEST['forwarder_mode']);
		$manifest_no = trim($_REQUEST['forwording_no']);
		$line_access = trim($_REQUEST['line_access']);
		$select_line = trim($_REQUEST['select_line']);
		// print_r($select_line);die;
		$username = $this->session->userdata("userName");
		$whr = array('username' => $username);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		$user_id = $res->row()->user_id;
		$where = array('branch_id' => $branch_id);
		$ress = $this->basic_operation_m->getAll('tbl_branch', $where);
		$source_branch = $ress->row()->branch_name;
		if ($line_access == '0') {
			$resAct5 = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$manifest_no' AND gatepass= '0'");
			$bag_row = $resAct5->row_array();
		} else {

			$manifest_details = $this->basic_operation_m->get_table_row('tbl_domestic_menifiest', array('manifiest_id' => $manifest_no));
			$destination_branch = $manifest_details->destination_branch;
			$branch_details = $this->basic_operation_m->get_table_row('tbl_branch', array('branch_name' => $destination_branch));
			$branch_city = $branch_details->city;
			$branch_state = $branch_details->state;

			$line_hual = $this->basic_operation_m->get_table_row('tbl_line_hual_master_details', ['state' => $branch_state, 'city' => $branch_city,'routeid'=>$select_line]);
			if (!empty($line_hual)) {
			if(!empty($manifest_details->gatepass_no)){
				$resAct5 = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$manifest_no' AND gatepass= '0'");
				$bag_row = $resAct5->row_array();
			}else{
				$resAct5 = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$manifest_no' AND source_branch = '$source_branch' AND gatepass= '0'");
				$bag_row = $resAct5->row_array();
			}
		}
		}


		$mode_info = $this->basic_operation_m->get_table_row('transfer_mode', array('mode_name' => $mode_dispatch));

		$data = "";

		if (!empty($bag_row)) {
			$bag_id = $bag_row['manifiest_id'];
			$total_weight = $bag_row['source_branch'];
			$destination = $bag_row['destination_branch'];
			$no_of_pack = $bag_row['total_pcs'];
			$dataid = 'data-val-' . $bag_id;

			$data .= '<tr><td>';
			$data .= "<input type='checkbox' class='cb'  name='manifiest_id[]'  data-tp='{$no_of_pack}' data-tw='{$total_weight}' value='{$bag_id}' checked required><input type='hidden' name='total_weight[]' value='" . $total_weight . "' required/><input type='hidden' name='pcs[]' value='" . $no_of_pack . "' required/></td>";
			$data .= "<input type='checkbox' class='cb'  name='total_weight[]' value='" . $total_weight . "' checked>";
			$data .= "<input type='checkbox' class='cb'  name='pcs[]' value='" . $no_of_pack . "' checked>";
			$data .= "<td>" . $bag_row['manifiest_id'] . "</td>";
			$data .= "<td>" . $total_weight . "</td>";
			$data .= "<td>" . $destination . "</td>";
			$data .= "<td>" . $mode_dispatch . "</td>";

			$data .= "</tr>";

		} else {
			$data .= '<tr><th colspan="5">Manifest Not Found </th></tr>';
		}
		echo $data;

	}


	public function genrate_gatepass()
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
		//print_r($branch_name);die();
		if ($this->input->post()) {
			$bag = $this->input->post('bag');
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
			} else if (strlen($bag) == 7) {
				$gatpass = 'GTP' . $bag;
			}
			$manifiests = $this->input->post('manifiest_id');
			foreach ($manifiests as $manifiest_id) {



				$result = $this->db->query("select tbl_domestic_bag.* from tbl_domestic_menifiest join tbl_domestic_bag on tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no where manifiest_id = '$manifiest_id'")->result_array();

				$menifestid = $this->db->query("select * from tbl_domestic_menifiest where manifiest_id = '$manifiest_id'")->row();
				// Tracking table entery 
				$this->db->trans_start();
				foreach ($result as $value) {
					$all_data['pod_no'] = $value['pod_no'];
					$all_data['forwording_no'] = $value['forwording_no'];
					$all_data['forworder_name'] = $value['forwarder_name'];
					$all_data['branch_name'] = $menifestid->destination_branch;
					$all_data['added_branch'] = $branch_name;
					$all_data['status'] = 'In transit';
					$all_data['shipment_info'] = $gatpass;
					$all_data['tracking_date'] = $this->input->post('datetime');
					$all_data['remarks'] = $this->input->post('remark');
					$track = $this->basic_operation_m->insert('tbl_domestic_tracking', $all_data);
					$pod_no = $value['pod_no'];
					$queue_dataa1 = "update tbl_domestic_stock_history set gatepass_genarte ='1' where pod_no = '$pod_no'";
					$status = $this->db->query($queue_dataa1);
				}

                //  Master Manifest entery 
				$data = array(
					'gatepass_no' => $gatpass,
					'manifiest_id' => $manifiest_id,
					'bag_no' => $result[0]['bag_id'],
					'total_no_bag' => count($result),
					'lock_no' => $this->input->post('cd_no'),
					'driver_name' => $menifestid->driver_name,
					'origin' => $result[0]['source_branch'],
					'destination' => $menifestid->destination_branch,
					'bkdate_reason' => $this->input->post('bkdate_reason'),
					'datetime' => $this->input->post('datetime'),
					'genrated_by' => $this->input->post('username'),
					'vehicle_no' => $menifestid->lorry_no
				);

				$result5 = $this->basic_operation_m->insert('tbl_gatepass', $data);
				// print_r($result); echo $this->db->last_query();die;
				$this->basic_operation_m->addLog($this->session->userdata("userId"), 'operation', 'Add Master Menifest', $data);
                if($this->input->post('line_hual') == '0'){
					$whr = array('manifiest_id' => $manifiest_id);
					$data1['gatepass'] = 1;
					$data1['gatepass_no'] = $gatpass;
					$data1['line_hual_id'] = $this->input->post('line_hual');
					$data1['line_access'] = '0';
					$data1['m_manifest_destination'] = '0';
					$value = $this->basic_operation_m->update('tbl_domestic_menifiest', $data1, $whr);
				}else{
				$whr = array('manifiest_id' => $manifiest_id);
				$data1['gatepass'] = 1;
				$data1['gatepass_no'] = $gatpass;
				$data1['line_hual_id'] = $this->input->post('line_hual');
				$data1['line_access'] = $this->input->post('line_access');
				$data1['m_manifest_destination'] = $this->input->post('branch_destination');
				$value = $this->basic_operation_m->update('tbl_domestic_menifiest', $data1, $whr);
				}
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
				$msg = 'Master Manifest Generated successfully M Manifest : '.$gatpass;
				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);


			} else {
				$this->db->trans_rollback();	
				$msg = 'Something went wrong Master Manifest Not Generated';
				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/gatepass');
		}
	}
}