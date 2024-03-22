<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_pincode_service extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		// ini_set('max_execution_time', 4800);

		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}

	public function index($offset = 0, $searching = '')
	{
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
		if(!empty($_POST['search'])){
			$filterCond = "(pincode.pin_code = '".$_POST['search']."'
				OR pincode.isODA ='".$_POST['search']."'
				OR pincode.state ='".$_POST['search']."'
				OR pincode.city ='".$_POST['search']."'
				)";
		}else{
		$filterCond = '1';
		}
		// $data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod");
		// $resActt123 = $this->db->query("SELECT pincode.pin_code,region_master_details.regionid as regionid,tbl_branch_service.branch_id as branch_id from pincode 
		// LEFT JOIN service_pincode ON service_pincode.pincode = pincode.pin_code 
		// LEFT JOIN tbl_branch_service ON tbl_branch_service.pincode =  pincode.pin_code
		// LEFT JOIN region_master_details ON (region_master_details.state = pincode.state_id AND region_master_details.city =  pincode.city_id) where  $filterCond group by pincode.pin_code ")->num_rows();

		$resActt = $this->db->query("SELECT pincode.*,region_master_details.regionid as regionid,tbl_branch_service.branch_id as branch_id from pincode 
		-- LEFT JOIN service_pincode ON service_pincode.pincode = pincode.pin_code 
		LEFT JOIN tbl_branch_service ON tbl_branch_service.pincode =  pincode.pin_code
		LEFT JOIN region_master_details ON (region_master_details.state = pincode.state_id AND region_master_details.city =  pincode.city_id) where  $filterCond and isdeleted ='0' group by pincode.pin_code");
// group by pincode.pin_code
		$resAct = $this->db->query("SELECT pincode.*,region_master_details.regionid as regionid,tbl_branch_service.branch_id as branch_id from pincode 
		LEFT JOIN tbl_branch_service ON tbl_branch_service.pincode =  pincode.pin_code
		LEFT JOIN region_master_details ON (region_master_details.state = pincode.state_id AND region_master_details.city =  pincode.city_id) where  $filterCond and isdeleted ='0' group by pincode.pin_code order by id desc limit " . $offset . ",100");
		// echo $this->db->last_query();die;
		$this->load->library('pagination');

		$data['total_count'] = $resActt->num_rows();
		$config['total_rows'] = $resActt->num_rows();
		$config['base_url'] = 'admin/view-pincode-service/';
		$config['per_page'] = 100;
		$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next paginate_button page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="next paginate_button page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="paginate_button page-item">';
		$config['reuse_query_string'] = TRUE;
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] = 3;
			$data['serial_no'] = 1;
		} else {
			$config['uri_segment'] = 3;
			$data['serial_no'] = $offset + 1;
		}


		$this->pagination->initialize($config);
		if (!empty($resAct) && $resAct->num_rows() > 0) {

			$data['allvehicletype'] = $resAct->result_array();
		} else {
			$data['allvehicletype'] = array();
		}
		$data['state'] = $this->db->query("select * from state")->result();
		$data['city'] = $this->db->query("select * from city")->result();
		$data['region_master'] = $this->db->query("select * from region_master")->result();
		$data['branch'] = $this->db->query("select * from tbl_branch")->result();
		$this->load->view('admin/pincode_service/pincode_service', $data);
	}

	// public function index($offset = 0, $searching = '')
	// {
	// 	//print_r($this->session->all_userdata());

	// 	$data = [];
	// 	if (isset($_POST['filter'])) {
	// 		$filter = $_POST['filter'];
	// 		$data['filter'] = $filter;
	// 	}

	// 	if (isset($_POST['filter_value'])) {
	// 		$filter_value = $_POST['filter_value'];
	// 		$data['filter_value'] = $filter_value;
	// 	}

	// 	$user_id = $this->session->userdata("userId");
	// 	$data['customer'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');

	// 	$user_type = $this->session->userdata("userType");
	// 	$filterCond = '';
	// 	$all_data = $this->input->post();

	// 	if ($all_data) {
	// 		$filter_value = $_POST['filter_value'];

	// 		foreach ($all_data as $ke => $vall) {
	// 			if ($ke == 'filter' && !empty($vall)) {
	// 				if ($vall == 'pincode') {
	// 					$filterCond .= " AND tbl_domestic_booking.pod_no = '$filter_value'";
	// 				}
	// 			}
	// 		}
	// 	}
	// 	if (!empty($searching)) {
	// 		$filterCond = urldecode($searching);
	// 	}


	// 	$resAct = $this->db->query("select pincode.*,region_master_details.regionid as regionid,tbl_branch_service.branch_id as branch_id from pincode 
	// 			JOIN service_pincode ON service_pincode.pincode = pincode.pin_code 
	// 			JOIN tbl_branch_service ON tbl_branch_service.pincode =  pincode.pin_code
	// 			JOIN region_master_details ON (region_master_details.state = pincode.state_id AND region_master_details.city =  pincode.city_id) $filterCond group by pincode.pin_code order by pincode.id desc
	// 			");

	// 	$this->load->library('pagination');

	// 	$data['total_count'] = $resAct->num_rows();
	// 	$config['total_rows'] = $resAct->num_rows();
	// 	$config['base_url'] = 'admin/view-pincode-service';
	// 	//	$config['suffix'] 				= '/'.urlencode($filterCond);

	// 	$config['per_page'] = 50;
	// 	$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
	// 	$config['full_tag_close'] = '</ul></nav>';
	// 	$config['first_link'] = '&laquo; First';
	// 	$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
	// 	$config['first_tag_close'] = '</li>';
	// 	$config['last_link'] = 'Last &raquo;';
	// 	$config['last_tag_open'] = '<li class="next paginate_button page-item">';
	// 	$config['last_tag_close'] = '</li>';
	// 	$config['next_link'] = 'Next';
	// 	$config['next_tag_open'] = '<li class="next paginate_button page-item">';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_link'] = 'Previous';
	// 	$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
	// 	$config['prev_tag_close'] = '</li>';
	// 	$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
	// 	$config['cur_tag_close'] = '</a></li>';
	// 	$config['num_tag_open'] = '<li class="paginate_button page-item">';
	// 	$config['reuse_query_string'] = TRUE;
	// 	$config['num_tag_close'] = '</li>';
	// 	$config['attributes'] = array('class' => 'page-link');

	// 	if ($offset == '') {
	// 		$config['uri_segment'] = 3;
	// 		$data['serial_no'] = 1;
	// 	} else {
	// 		$config['uri_segment'] = 3;
	// 		$data['serial_no'] = $offset + 1;
	// 	}


	// 	$this->pagination->initialize($config);
	// 	if ($resAct->num_rows() > 0) {

	// 		$data['allvehicletype'] = $resAct->result_array();
	// 	} else {
	// 		$data['allvehicletype'] = array();
	// 	}

	// 	$data['state'] = $this->db->query("select * from state")->result();
	// 	$data['city'] = $this->db->query("select * from city")->result();
	// 	$data['region_master'] = $this->db->query("select * from region_master")->result();
	// 	$data['branch'] = $this->db->query("select * from tbl_branch")->result();
	// 	$this->load->view('admin/pincode_service/pincode_service', $data);
	// }

	public function edit_pincode($id = 0)
	{
		$resAct = $this->db->query("select pincode.*,tbl_branch_service.branch_id as branch_id from pincode 
		JOIN service_pincode ON service_pincode.pincode = pincode.pin_code 
		JOIN tbl_branch_service ON tbl_branch_service.pincode =  pincode.pin_code
		where pincode.id = '$id' group by pincode.pin_code order by pincode.id desc
		");
		// echo $this->db->last_query();die;
		$data['val'] = $resAct->row();
		// print_r($data['val']);die;
		$data['state'] = $this->db->query("select * from state")->result();
		$data['city'] = $this->db->query("select * from city")->result();
		$data['region_master'] = $this->db->query("select * from region_master")->result();
		$data['branch'] = $this->db->query("select * from tbl_branch")->result();
		$this->load->view('admin/admin_shared/admin_header');
		$this->load->view('admin/admin_shared/admin_sidebar');
		$this->load->view('admin/pincode_service/edit_pincode_service', $data);
		$this->load->view('admin/admin_shared/admin_footer');
	}


	public function check_duplicate_pincode()
	{
		$data = [];
		$pod_no = $this->input->post('pod_no');

		$result = $this->db->query("SELECT * From pincode WHERE pin_code = '$pod_no'")->row();
		$pod_no = $result->pin_code;
		if($result->isdeleted ==1)
		{
            $data['status'] ="1";
			$data['pin']=$pod_no;
		}else{
			$data['status'] ="0";
		}
		
		echo json_encode($data);
		exit;
	}

	public function DeactiveNote(){
		$pincode = $this->input->post('pincode');
		if($this->db->update('pincode',['isdeleted'=>0],['pin_code'=>$pincode])){
		$pincode_info = $this->db->query("SELECT *  FROM `pincode` where pin_code = '$pincode'")->row();
		$zone_id = $this->db->query("SELECT *  FROM `region_master_details` where state = '$pincode_info->state_id'AND city = '$pincode_info->city_id'")->row();
		$branch = $this->db->query("SELECT *  FROM `tbl_branch_service` where pincode = '$pincode'")->row();
		if(!empty($branch)){$branch_name = $this->db->query("SELECT * FROM tbl_branch WHERE branch_id = '$branch->branch_id'")->row('branch_name'); }else{$branch_name='';}
		if(!empty($zone_id)){$zone = $this->db->query("SELECT * FROM region_master WHERE region_id = '$zone_id->regionid'")->row('region_name'); }else{$zone='';}
		if (!empty($pincode_info)) {
			$service_type = ($pincode_info->isODA !=0)? service_type[$pincode_info->isODA]:'';
			$option = '<table id="myTable" class="display table table-bordered text-center">
		 <thead>
		 <tr>                 
			 <th>Pincode</th>
			 <th>State</th>
			 <th>City</th>
			 <th>Service Type</th>
			 <th>Zone</th>
			 <th>Branch Name</th>
		 </tr>
		 </thead>
		 <tbody>
            <tr>
			<th>' . $pincode_info->pin_code . '</th>
			<th>' . $pincode_info->state . '</th>
			<th>' . $pincode_info->city . '</th>
			<th>' .$service_type. '</th>
			<th>' . $zone . '</th>
			<th>' . $branch_name . '</th>
            </tr>
			</tbody>
			</table>';
			echo $option;
		}
	}
	}

	public function pincode_service_status()
	{   
		$data = [];
		$pincode = $this->input->post('filter_value');
	    if(!empty($_POST)){
		$pincode_info = $this->db->query("SELECT *  FROM `pincode` where pin_code = '$pincode'")->row();
		$zone_id = $this->db->query("SELECT *  FROM `region_master_details` where state = '$pincode_info->state_id'AND city = '$pincode_info->city_id'")->row();
		$branch = $this->db->query("SELECT *  FROM `tbl_branch_service` where pincode = '$pincode'")->row();
		if(!empty($branch)){$branch_name = $this->db->query("SELECT * FROM tbl_branch WHERE branch_id = '$branch->branch_id'")->row('branch_name'); }else{$branch_name='';}
		if(!empty($zone_id)){$zone = $this->db->query("SELECT * FROM region_master WHERE region_id = '$zone_id->regionid'")->row('region_name'); }else{$zone='';}
		$service_type = ($pincode_info->isODA !=0)? service_type[$pincode_info->isODA]:'';
		$data['pincode_service'] = [
			'pincode'=>$pincode_info->pin_code,
			'state'=>$pincode_info->state,
			'city'=>$pincode_info->city,
			'service_type'=>$service_type,
			'zone'=>$zone,
			'branch'=>$branch_name,
			'status'=>$pincode_info->isdeleted
		];
		// print_r($_POST);die;
	    }else{
          $data = [];
		}
		$this->load->view('admin/pincode_service/pincode_service_status', $data);
    }
	public function add_pincode()
	{

		$data['message'] = "";
		if (isset($_POST['submit'])) {
			$all_data = $this->input->post();

			// echo '<pre>'; print_r($all_data);

			if (!empty($all_data)) {

				$state_ex = explode('-', $all_data['state']);
				$state_id = $state_ex[0];
				$state = $state_ex[1];
				$city_ex = explode('-', $all_data['city']);
				$city_id = $city_ex[0];
				$city = $city_ex[1];
				$branch_ex = explode('-', $all_data['branch']);
				$branch_id = $branch_ex[0];
				$branch = $branch_ex[1];
				$zone_ex = explode('-', $all_data['zone']);
				$zone_id = $zone_ex[0];
				$zone = $zone_ex[1];

				$pincode = array(
					'pin_code' => $all_data['pincode'],
					'city' => $city,
					'city_id' => $city_id,
					'state' => $state,
					'state_id' => $state_id,
					'isODA' => $all_data['ioda']
				);
				$service_pincode = array(
					'pincode' => $all_data['pincode'],
					'forweder_id' => '35',
					'cityid' => $city_id,
					'city_name' => $city,
					'state_name' => '0',
					'statid' => '1',
					'servicable' => '',
					'oda' => '0',
					'regionid' => $zone_id
				);
				$branch_service = array(
					'pincode' => $all_data['pincode'],
					'branch_id' => $branch_id,
					'km' => '0'
				);

				$pincodep = $this->basic_operation_m->insert('pincode', $pincode);
				$service_pincodep = $this->basic_operation_m->insert('service_pincode', $service_pincode);

				$branch_servicep = $this->basic_operation_m->insert('tbl_branch_service', $branch_service);
				// echo $this->db->last_query();die;
				if ($pincodep && $service_pincodep && $branch_servicep) {
					$msg = 'Pincode Added Suessfully';


					$class = 'alert alert-success alert-dismissible';

					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
					redirect('admin/view-pincode-service');
				}
				//    die;

			}

		}
		$data['state'] = $this->db->query("select * from state")->result();
		$data['city'] = $this->db->query("select * from city")->result();
		$data['region_master'] = $this->db->query("select * from region_master")->result();
		$data['branch'] = $this->db->query("select * from tbl_branch")->result();
		$this->load->view('admin/pincode_service/pincode_service', $data);
	}

	public function update_pincode($id = 0)
	{

		$data['message'] = "";
		$all_data = $this->input->post();


		if (isset($all_data['submit']) && $all_data['submit'] == "Submit") {
            
			// echo '<pre>';print_r($_POST);die;
			$state_ex = explode('-', $all_data['state']);
			$state_id = $state_ex[0];
			$state = $state_ex[1];
			$city_ex = explode('-', $all_data['city']);
			$city_id = $city_ex[0];
			$city = $city_ex[1];
			$branch_ex = explode('-', $all_data['branch']);
			$branch_id = $branch_ex[0];
			$branch = $branch_ex[1];
		

			$branch_service_table = $this->db->get_where('tbl_branch_service', array('pincode' => $all_data['pincode']))->row();
			$service_pincode_table = $this->db->get_where('service_pincode', array('pincode' => $all_data['pincode']))->row();
			$pincode_table = $this->db->get_where('pincode', array('pin_code' => $all_data['pincode']))->row();
			//    print_r($region_data->rgm_id); die;

			$pincode = array(
				'pin_code' => $all_data['pincode'],
				'city' => $city,
				'city_id' => $city_id,
				'state' => $state,
				'state_id' => $state_id,
				'isODA' => $all_data['ioda']
			);


			$service_pincode = array(
				'pincode' => $all_data['pincode'],
				'forweder_id' => '35',
				'cityid' => $city_id,
				'city_name' => $city,
				'state_name' => '0',
				'statid' => '1',
				'servicable' => '',
				'oda' => '0',
			);

			$branch_service = array(
				'pincode' => $all_data['pincode'],
				'branch_id' => $branch_id,
				'km' => '0'
			);

			// echo '<pre>';print_r($pincode);
			// echo '<pre>';print_r($service_pincode);
			// echo '<pre>';print_r($branch_service);
			// echo '<pre>';print_r($region_master_details);die;

			$this->db->trans_start();
			// pincode table 
			if(!empty($pincode_table)){
				$whr_p = array('id' => $id);
				$pincodep = $this->basic_operation_m->update('pincode', $pincode, $whr_p);
			}
			else
			{
				$this->basic_operation_m->insert('pincode', $pincode);
			}
			//  service table 
            if(!empty($service_pincode_table)){
				$whr_p1 = array('pincode' => $all_data['pincode']);
				$service_pincodep = $this->basic_operation_m->update('service_pincode', $service_pincode, $whr_p1);
			}
			else
			{
				$this->basic_operation_m->insert('service_pincode', $service_pincode);
			}
            // branch service 
			if(!empty($branch_service_table)){
				$whr_p2 = array('pincode' => $all_data['pincode']);
				$branch_servicep = $this->basic_operation_m->update('tbl_branch_service', $branch_service, $whr_p2);
			}
			else
			{
				$this->basic_operation_m->insert('tbl_branch_service', $branch_service);
			}
			
			$this->db->trans_complete();

			if ($this->db->trans_status() === True) {
				$msg = 'Pincode Update Suessfully';

				$class = 'alert alert-success alert-dismissible';

				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);

				redirect('admin/view-pincode-service');
			}

		}
	}





}
?>