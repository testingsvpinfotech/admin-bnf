<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_TraficManager extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Login_model');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}

	public function quotation_requested_list($offset = '0', $searching = '')
	{

		$all_data 					= $this->input->post();
		$filterCond = '';
		if ($all_data) {
			//$filter_value = 	$_POST['filter_value'];

			foreach ($all_data as $ke => $vall) {

				if ($ke == 'ftl_No' && !empty($vall)) {
					$filterCond .= " AND ftl_request_tbl.ftl_request_id = '$vall'";
				} elseif ($ke == 'minimum_bid_amount' && !empty($vall)) {
					$filterCond .= " AND ftl_request_tbl.total_amount >= '$vall'";
				} elseif ($ke == 'max_bid_amount' && !empty($vall)) {
					$filterCond .= " AND ftl_request_tbl.total_amount <= '$vall'";
				}
			}
		}
		if (!empty($searching)) {
			$filterCond = urldecode($searching);
		}

		$branch_id = $this->session->userdata('branch_id');
		$traffic_manager = $this->db->query("select b.state,b.city from tbl_users as u left join tbl_branch as b ON b.branch_id = u.branch_id where b.branch_id = '$branch_id' AND `user_type` = '10'")->row_array();
		$get_traficmanager_state = $traffic_manager['city'];
		$getquotion = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.ending_time,ftl_request_tbl.driver_name,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where ftl_request_tbl.origin_city = '$get_traficmanager_state' $filterCond  ORDER BY order_request_tabel.ftl_request_id DESC limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.ending_time,ftl_request_tbl.driver_name,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where ftl_request_tbl.origin_city = '$get_traficmanager_state'  $filterCond ORDER BY order_request_tabel.ftl_request_id DESC");
		//  $data['get_quotation_list'] = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where vendor_customer_tbl.state = '$get_traficmanager_state'  ORDER BY order_request_tabel.advance_amount ASC")->result();
		//   echo $this->db->last_query();exit;



		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/quation-requested-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($getquotion->num_rows() > 0) {
			$data['get_quotation_list'] 	= 	$getquotion->result();
		} else {
			$data['get_quotation_list']	= array();
		}


		$this->load->view('admin/trafic_manager/admin_quotation_requested_list', $data);
	}



	public function cancel_quotation_requested_list($offset = '0')
	{
		$date = date('Y-m-d');
		$branch_id = $this->session->userdata('branch_id');

		// $data['get_quotation_list'] = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.driver_name,ftl_request_tbl.vehicle_number,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.id,ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id WHERE ftl_request_tbl.trafic_approve_status ='1' AND order_request_tabel.trafic_approve_status ='1'  ORDER BY order_request_tabel.advance_amount ASC")->result();
		$get_cancel_quotation = $this->db->query("SELECT order_request_tabel.* ,vendor_customer_tbl.vcode FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id  WHERE  order_request_tabel.trafic_approve_status ='2' limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT order_request_tabel.* ,vendor_customer_tbl.vcode FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id  WHERE  order_request_tabel.trafic_approve_status ='2'");
		//  $data['get_quotation_list'] = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where vendor_customer_tbl.state = '$get_traficmanager_state'  ORDER BY order_request_tabel.advance_amount ASC")->result();
		//   echo $this->db->last_query();exit;



		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/quation-cancel-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($get_cancel_quotation->num_rows() > 0) {
			$data['get_cancel_quotation'] 	= 	$get_cancel_quotation->result();
		} else {
			$data['get_cancel_quotation']	= array();
		}


		$this->load->view('admin/trafic_manager/cancel_quotation_data', $data);
	}


	public function get_ftl_id()
	{
		$ftlId = $this->input->post('id');
		$data =  $this->db->query("select ftl_request_id from ftl_request_tbl where ftl_request_id ='$ftlId'")->row();
		echo json_encode($data);
	}















	public function update_quotation_data($id)
	{
		if (isset($_POST['submit'])) {

			$v = $this->input->post('rc_book');
			if (isset($_FILES) && !empty($_FILES['rc_book']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['rc_book'], 'assets/ftl_documents/vendor_rc-book/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$rc_book = $ret['image_name'];
				}
			}
			//  $hourse = $this->input->post('hourse');
			//  $minit = $this->input->post('minit');
			// $ping_time = $hourse.':'.$minit;

			$data = array(
				'driver_name' => $this->input->post('driver_name'),
				'vc_id' => $this->input->post('vendor_customer_id'),
				'driver_contact_number' => $this->input->post('driver_contact_number'),
				'vehicle_number' => $this->input->post('vehicle_number'),
				'loding_charges' => $this->input->post('loding_charges'),
				'Unloding_charges' => $this->input->post('unloding_charges'),
				'ping_time' => $this->input->post('ping_time'),
				'driver_licence' => $this->input->post('driver_licence'),
				//'rc_book' =>$rc_book,
				'ending_time' => $this->input->post('ending_time'),
			);

			// print_r($data);exit;

			$this->db->where('id', $id);
			$this->db->update('ftl_request_tbl', $data);
			// echo $this->db->last_query();exit;
			$this->session->Set_flashdata('msg', "Driver details has been successfully updated. Now You can proceed to create Trip.");
			redirect(base_url() . 'admin/quation-approve-list');
		} else {
			// $data['quotation_data'] = $this->db->query("SELECT order_request_tabel.*,ftl_request_tbl.id as ftl_id, ftl_request_tbl.customer_name,ftl_request_tbl.ftl_request_id,ftl_request_tbl.goods_type,ftl_request_tbl.pickup_address,ftl_request_tbl.delivery_address from order_request_tabel left join  ftl_request_tbl ON ftl_request_tbl.id = order_request_tabel.ftl_request_id  where order_request_tabel.id = '$id' ")->row_array();
			$data['quotation_data'] = $this->db->query("SELECT order_request_tabel.*,ftl_request_tbl.id as ftlId,ftl_request_tbl.ping_time,ftl_request_tbl.vehicle_number,ftl_request_tbl.driver_licence,ftl_request_tbl.rc_book,ftl_request_tbl.driver_contact_number,ftl_request_tbl.ending_time,ftl_request_tbl.driver_name,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.Unloding_charges,ftl_request_tbl.loding_charges,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount,ftl_request_tbl.unloading_type,ftl_request_tbl.loading_type FROM  order_request_tabel left JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where ftl_request_tbl.ftl_request_id = '$id' ")->row_array();
			// echo $this->db->last_query();exit;
			$this->load->view('admin/trafic_manager/update_quotation_data', $data);
		}
	}


	public function approve_quotation_requested_list($offset = '0')
	{


		$date = date('Y-m-d');
		$branch_id = $this->session->userdata('branch_id');
		$traffic_manager = $this->db->query("select b.state from tbl_users as u left join tbl_branch as b ON b.branch_id = u.branch_id where b.branch_id = '$branch_id' AND `user_type` = '10'")->row_array();
		$get_traficmanager_state = $traffic_manager['state'];
		// $data['get_quotation_list'] = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.driver_name,ftl_request_tbl.vehicle_number,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.id,ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id WHERE ftl_request_tbl.trafic_approve_status ='1' AND order_request_tabel.trafic_approve_status ='1'  ORDER BY order_request_tabel.advance_amount ASC")->result();
		$getres = $this->db->query("SELECT order_request_tabel.*,ftl_request_tbl.ftl_request_id as ftl_id,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.driver_name,ftl_request_tbl.vehicle_number,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.id,ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id WHERE ftl_request_tbl.trafic_approve_status ='1' AND order_request_tabel.trafic_approve_status ='1'  ORDER BY order_request_tabel.ftl_request_id DESC limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT order_request_tabel.*,ftl_request_tbl.ftl_request_id as ftl_id,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.driver_name,ftl_request_tbl.vehicle_number,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.id,ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id WHERE ftl_request_tbl.trafic_approve_status ='1' AND order_request_tabel.trafic_approve_status ='1'  ORDER BY order_request_tabel.ftl_request_id DESC ");
		//  $data['get_quotation_list'] = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where vendor_customer_tbl.state = '$get_traficmanager_state'  ORDER BY order_request_tabel.advance_amount ASC")->result();
		//   echo $this->db->last_query();exit;


		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/quation-approve-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($getres->num_rows() > 0) {
			$data['get_quotation_list'] 	= $getres->result();
		} else {
			$data['get_quotation_list'] 	= array();
		}



		$this->load->view('admin/trafic_manager/approve_quotation_list', $data);
	}



	public function update_status()
	{

		$branch_id = $this->session->userdata('branch_id');
		$user_id = $this->session->userdata('userId');
		$date_time = date('d-m-y H:i:s');
		$id = $this->input->post('id');
		$vendor_customer_id = $this->input->post('vendor_customer_id');
		$ftl_request_id = $this->input->post('ftl_request_id');
		$approved = $this->input->post('approved');
		$this->db->query("update order_request_tabel set trafic_approve_status ='$approved' ,branch_id ='$branch_id' where id ='$id'");

		$this->db->query("update ftl_request_tbl set trafic_approve_status ='$approved', vc_id='$vendor_customer_id' ,branch_id ='$branch_id',tm_user_id = '$user_id',tm_approve_date = '$date_time' where id ='$ftl_request_id'");

		$this->db->query("update order_request_tabel set trafic_approve_status ='2' where trafic_approve_status!= '1' AND ftl_request_id ='$ftl_request_id'");
		// echo $this->db->last_query();exit;
		redirect(base_url() . 'admin/quation-requested-list');
	}

	public function get_ftl_data()
	{
		$order_id = $this->input->get('id');
		$dd = $this->db->query("select * from order_request_tabel where id = '$order_id' ")->row_array();
		echo json_encode($dd);
	}


	public function view_ewaybill_list($offset = '0')
	{
		$resActt   = $this->db->query("select * from ftl_document_image_tbl");
		$resAct   = $this->db->query("select * from ftl_document_image_tbl  limit " . $offset . ",10");
		//	echo $this->db->last_query();exit;
		// $data['get_ftl_document']	   = $this->db->query("select * from ftl_document_image_tbl DESC limit ".$offset.",2")->result_array();
		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/ftl-documents-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			= 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($resAct->num_rows() > 0) {
			$data['get_ftl_document']	= $resAct->result_array();
		} else {
			$data['get_ftl_document']	= array();
		}

		$this->load->view('admin/trafic_manager/admin_eway_bill_list', $data);
	}


	public function pickup_request_list($offset = '0', $searching = '')
	{

		$all_data 					= $this->input->post();
		$filterCond = '';
		if ($all_data) {
			$filter_value = 	$_POST['filter_value'];

			foreach ($all_data as $ke => $vall) {

				if ($ke == 'user_id' && !empty($vall)) {
					$filterCond .= " AND tbl_domestic_booking.customer_id = '$vall'";
				} elseif ($ke == 'from_date' && !empty($vall)) {
					$filterCond .= " AND tbl_domestic_booking.booking_date >= '$vall'";
				} elseif ($ke == 'to_date' && !empty($vall)) {
					$filterCond .= " AND tbl_domestic_booking.booking_date <= '$vall'";
				} elseif ($ke == 'courier_company' && !empty($vall) && $vall != "ALL") {
					$filterCond .= " AND tbl_domestic_booking.courier_company_id = '$vall'";
				} elseif ($ke == 'mode_name' && !empty($vall) && $vall != "ALL") {
					$filterCond .= " AND tbl_domestic_booking.mode_dispatch = '$vall'";
				}
			}
		}
		if (!empty($searching)) {
			$filterCond = urldecode($searching);
		}
		$branch_id = $this->session->userdata('branch_id');
		$traffic_manager = $this->db->query("select b.state,b.city from tbl_users as u left join tbl_branch as b ON b.branch_id = u.branch_id where b.branch_id = '$branch_id' AND `user_type` = '10'")->row_array();
		$get_traficmanager_state = $traffic_manager['city'];
		$pickup_request_list = $this->db->query("SELECT ftl_request_tbl.*,vendor_customer_tbl.vendor_name,tbl_customers.customer_name  from  ftl_request_tbl left JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id LEFT JOIN  tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id where ftl_request_tbl.origin_city = '$get_traficmanager_state' AND  ftl_request_tbl.trafic_approve_status ='1' limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT ftl_request_tbl.*,vendor_customer_tbl.vendor_name,tbl_customers.customer_name from  ftl_request_tbl left JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id LEFT JOIN  tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id where ftl_request_tbl.origin_city = '$get_traficmanager_state' AND  ftl_request_tbl.trafic_approve_status ='1' ");
		//echo $this->db->last_query();exit;
		//  $data['get_quotation_list'] = $this->db->query("SELECT order_request_tabel.*,vendor_customer_tbl.vcode,ftl_request_tbl.ftl_request_id,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.pickup_address,ftl_request_tbl.order_date,ftl_request_tbl.delivery_address,ftl_request_tbl.type_of_vehicle,ftl_request_tbl.vehicle_capacity,ftl_request_tbl.vehicle_body_type,ftl_request_tbl.vehicle_floor_type,ftl_request_tbl.vehicle_wheel_type,ftl_request_tbl.vehicle_gps,ftl_request_tbl.request_date_time,ftl_request_tbl.goods_type,ftl_request_tbl.goods_weight,ftl_request_tbl.total_amount FROM order_request_tabel INNER JOIN vendor_customer_tbl ON order_request_tabel.vendor_customer_id = vendor_customer_tbl.customer_id INNER JOIN ftl_request_tbl ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where vendor_customer_tbl.state = '$get_traficmanager_state'  ORDER BY order_request_tabel.advance_amount ASC")->result();
		//   echo $this->db->last_query();exit;


		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/pickup-request-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($pickup_request_list->num_rows() > 0) {
			$data['get_pickup_request_list'] 	= 	$pickup_request_list->result();
		} else {
			$data['get_pickup_request_list']	= array();
		}


		$this->load->view('admin/trafic_manager/ftl_pickup_request_list', $data);
	}

	public function upload_trip_documents($id)
	{
		if (isset($_POST['submit'])) {

			$v = $this->input->post('loding_slip_upload');
			if (isset($_FILES) && !empty($_FILES['loding_slip_upload']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['loding_slip_upload'], 'assets/ftl_documents/Loading-Slip/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$loding_slip_upload = $ret['image_name'];
				}
			}
			// ********************************* before_seal_photo upload ****************     
			$v = $this->input->post('before_seal_photo');
			if (isset($_FILES) && !empty($_FILES['before_seal_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['before_seal_photo'], 'assets/ftl_documents/Before-Seal/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$before_seal_photo = $ret['image_name'];
				}
			}

			// ********************************* after_seal_photo upload ****************     
			$v = $this->input->post('after_seal_photo');
			if (isset($_FILES) && !empty($_FILES['after_seal_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['after_seal_photo'], 'assets/ftl_documents/After-Seal/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$after_seal_photo = $ret['image_name'];
				}
			}

			// ********************************* empty_lorry_photo upload ****************     
			$v = $this->input->post('empty_lorry_photo');
			if (isset($_FILES) && !empty($_FILES['empty_lorry_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['empty_lorry_photo'], 'assets/ftl_documents/Empty-Lorry/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$empty_lorry_photo = $ret['image_name'];
				}
			}

			// ********************************* empty_lorry_photo upload ****************     
			$v = $this->input->post('loaded_lorry_photo');
			if (isset($_FILES) && !empty($_FILES['loaded_lorry_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['loaded_lorry_photo'], 'assets/ftl_documents/Loaded-Lorry/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$loaded_lorry_photo = $ret['image_name'];
				}
			}

			$data = array(
				'ftl_id' => $this->input->post('ftl_id'),
				'loading_slip' => $loding_slip_upload,
				'before_seal' => $before_seal_photo,
				'after_seal' => $after_seal_photo,
				'empty_lorry' => $empty_lorry_photo,
				'loaded_lorry' => $loaded_lorry_photo,
			);
			//print_r($data);exit;
			$this->db->insert('ftl_trip_document_tbl', $data);
			//	echo $this->db->last_query();exit;
			$this->session->Set_flashdata('msg', 'Images Uploaded Successfully!!');
			redirect(base_url() . 'admin/pickup-request-list');
		} else {
			$data['ftl_id'] = $this->db->query("select * from ftl_request_tbl  where id ='$id'")->row_array();
			$this->load->view('admin/trafic_manager/add_pickup_documentation', $data);
		}
	}

	public function upload_trip_documents_list($offset = '0')
	{

		$resActt   = $this->db->query("select * from ftl_trip_document_tbl");
		$resAct   = $this->db->query("select * from ftl_trip_document_tbl  limit " . $offset . ",10");
		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/upload-trip-documents-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			= 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($resAct->num_rows() > 0) {
			$data['pickup_document_data']	= $resAct->result_array();
		} else {
			$data['pickup_document_data']	= array();
		}
		$this->load->view('admin/trafic_manager/pickup_document_list', $data);
	}

	public function update_upload_trip_documents($ftl_id)
	{

		if (isset($_POST['submit'])) {

			$v = $this->input->post('loding_slip_upload');
			if (isset($_FILES) && !empty($_FILES['loding_slip_upload']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['loding_slip_upload'], 'assets/ftl_documents/Loading-Slip/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$loding_slip_upload = $ret['image_name'];
				}
			}
			// ********************************* before_seal_photo upload ****************     
			$v = $this->input->post('before_seal_photo');
			if (isset($_FILES) && !empty($_FILES['before_seal_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['before_seal_photo'], 'assets/ftl_documents/Before-Seal/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$before_seal_photo = $ret['image_name'];
				}
			}

			// ********************************* after_seal_photo upload ****************     
			$v = $this->input->post('after_seal_photo');
			if (isset($_FILES) && !empty($_FILES['after_seal_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['after_seal_photo'], 'assets/ftl_documents/After-Seal/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$after_seal_photo = $ret['image_name'];
				}
			}

			// ********************************* empty_lorry_photo upload ****************     
			$v = $this->input->post('empty_lorry_photo');
			if (isset($_FILES) && !empty($_FILES['empty_lorry_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['empty_lorry_photo'], 'assets/ftl_documents/Empty-Lorry/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$empty_lorry_photo = $ret['image_name'];
				}
			}

			// ********************************* empty_lorry_photo upload ****************     
			$v = $this->input->post('loaded_lorry_photo');
			if (isset($_FILES) && !empty($_FILES['loaded_lorry_photo']['name'])) {
				$ret = $this->basic_operation_m->fileUpload($_FILES['loaded_lorry_photo'], 'assets/ftl_documents/Loaded-Lorry/');
				//file is uploaded successfully then do on thing add entry to table
				if ($ret['status'] && isset($ret['image_name'])) {
					$loaded_lorry_photo = $ret['image_name'];
				}
			}

			$data = array(

				'loading_slip' => $loding_slip_upload,
				'before_seal' => $before_seal_photo,
				'after_seal' => $after_seal_photo,
				'empty_lorry' => $empty_lorry_photo,
				'loaded_lorry' => $loaded_lorry_photo,
			);
			//print_r($data);exit;
			$this->db->where('id', $ftl_id);
			$this->db->update('ftl_trip_document_tbl', $data);

			$this->session->Set_flashdata('msg', 'Images Updated Successfully!!');
			redirect(base_url() . 'admin/pickup-request-list');
		} else {
			$data['update_document'] = $this->db->query("select * from ftl_trip_document_tbl where ftl_id ='$ftl_id'")->row_array();
			// echo $this->db->last_query();
			// exit;
			$this->load->view("admin/trafic_manager/update_pickup_documentation", $data);
		}
	}


	// ***************************************** FTL Account ********************************


	public function pending_payment_approve($offset = '0')
	{

		$pending_payment_approve_list = $this->db->query("SELECT ftl_request_tbl.*,ftl_account_tbl.status as payment_approve_status , order_request_tabel.vendor_amount,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,vendor_customer_tbl.vcode,vendor_customer_tbl.vendor_name,tbl_customers.customer_name,su.full_name as sales_name,su.branch_id as sales_branch_id,tu.full_name as traffic_manager_name,tbl_branch.branch_name as trafic_manager_branch 
				from ftl_request_tbl LEFT JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id 
				LEFT JOIN tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id LEFT JOIN tbl_users as su ON su.user_id = ftl_request_tbl.sales_user_id LEFT JOIN tbl_users as tu ON tu.user_id = ftl_request_tbl.tm_user_id 
				LEFT JOIN tbl_branch ON tbl_branch.branch_id = ftl_request_tbl.branch_id LEFT JOIN order_request_tabel ON order_request_tabel.ftl_request_id = ftl_request_tbl.id 
				LEFT JOIN ftl_account_tbl ON ftl_account_tbl.ftl_request_id = ftl_request_tbl.ftl_request_id  where ftl_request_tbl.trafic_approve_status ='1'GROUP BY ftl_request_tbl.ftl_request_id limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT ftl_request_tbl.*,order_request_tabel.vendor_amount,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,vendor_customer_tbl.vcode,vendor_customer_tbl.vendor_name,tbl_customers.customer_name,su.full_name as sales_name,su.branch_id as sales_branch_id,tu.full_name as traffic_manager_name,tbl_branch.branch_name as trafic_manager_branch from ftl_request_tbl LEFT JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id LEFT JOIN tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id LEFT JOIN tbl_users as su ON su.user_id = ftl_request_tbl.sales_user_id LEFT JOIN tbl_users as tu ON tu.user_id = ftl_request_tbl.tm_user_id LEFT JOIN tbl_branch ON tbl_branch.branch_id = ftl_request_tbl.branch_id LEFT JOIN order_request_tabel ON order_request_tabel.ftl_request_id = ftl_request_tbl.id where ftl_request_tbl.trafic_approve_status ='1'GROUP BY ftl_request_tbl.ftl_request_id ");

		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/pending-payment-approval/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($pending_payment_approve_list->num_rows() > 0) {
			$data['pending_payment_approve'] 	= 	$pending_payment_approve_list->result();
		} else {
			$data['pending_payment_approve']	= array();
		}

		$this->load->view('admin/trafic_manager/pending_payment_approve', $data);
	}

	public function store_payment_status()
	{

		$payment_status =	$this->input->post('payment_status');
		$approved =	$this->input->post('approved');
		$ftl_request_id	= $this->input->post('ftl_request_id');
		$payment_approved_by = $this->session->userdata('userId');

		$data = array(
			'payment_status' => $payment_status,
			'status' => $approved,
			'ftl_request_id' => $ftl_request_id,
			'payment_approved_by' => $payment_approved_by,
		);

		//print_r($data);exit;
		$resdata =	$this->db->insert('ftl_account_tbl', $data);
		//echo $this->db->last_query();exit;
		if (!empty($resdata)) {
			$this->session->Set_userdata('msg', 'Payment Status Updated Successfully!!');
			redirect(base_url() . 'admin/pending-payment-approval');
		}
	}


	public function pending_transfer_payment($offset  = '0')
	{

		$pending_transfer_payment = $this->db->query("SELECT ftl_request_tbl.*,ftl_account_tbl.status as payment_approve_status ,ftl_account_tbl.payment_approved_by,ftl_account_tbl.payment_approved_date, order_request_tabel.vendor_amount,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,vendor_customer_tbl.vcode,vendor_customer_tbl.vendor_name,tbl_customers.customer_name,su.full_name as sales_name,su.branch_id as sales_branch_id,tu.full_name as traffic_manager_name,tbl_branch.branch_name as trafic_manager_branch 
		from ftl_request_tbl LEFT JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id 
		LEFT JOIN tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id LEFT JOIN tbl_users as su ON su.user_id = ftl_request_tbl.sales_user_id LEFT JOIN tbl_users as tu ON tu.user_id = ftl_request_tbl.tm_user_id 
		LEFT JOIN tbl_branch ON tbl_branch.branch_id = ftl_request_tbl.branch_id LEFT JOIN order_request_tabel ON order_request_tabel.ftl_request_id = ftl_request_tbl.id 
		LEFT JOIN ftl_account_tbl ON ftl_account_tbl.ftl_request_id = ftl_request_tbl.ftl_request_id  where ftl_request_tbl.trafic_approve_status ='1' AND ftl_account_tbl.status ='1' GROUP BY ftl_request_tbl.ftl_request_id limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT ftl_request_tbl.*,ftl_account_tbl.payment_approved_by,ftl_account_tbl.payment_approved_date,order_request_tabel.vendor_amount,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,vendor_customer_tbl.vcode,vendor_customer_tbl.vendor_name,tbl_customers.customer_name,su.full_name as sales_name,su.branch_id as sales_branch_id,tu.full_name as traffic_manager_name,tbl_branch.branch_name as trafic_manager_branch from ftl_request_tbl LEFT JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id LEFT JOIN tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id LEFT JOIN tbl_users as su ON su.user_id = ftl_request_tbl.sales_user_id LEFT JOIN tbl_users as tu ON tu.user_id = ftl_request_tbl.tm_user_id LEFT JOIN tbl_branch ON tbl_branch.branch_id = ftl_request_tbl.branch_id LEFT JOIN order_request_tabel ON order_request_tabel.ftl_request_id = ftl_request_tbl.id LEFT JOIN ftl_account_tbl ON ftl_account_tbl.ftl_request_id = ftl_request_tbl.ftl_request_id where ftl_request_tbl.trafic_approve_status ='1' AND ftl_account_tbl.status='1' GROUP BY ftl_request_tbl.ftl_request_id ");

		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/pending-transfer-payment/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($pending_transfer_payment->num_rows() > 0) {
			$data['pending_transfer_payment'] 	= 	$pending_transfer_payment->result();
		} else {
			$data['pending_transfer_payment']	= array();
		}

		$this->load->view('admin/trafic_manager/pending_transfer_payment_list', $data);
	}





	public function ftl_payment($offset = '0')
	{
		$ftl_payment = $this->db->query("SELECT ftl_request_tbl.*,ftl_account_tbl.utr_no ,ftl_account_tbl.status as payment_approve_status ,ftl_account_tbl.payment_approved_by,ftl_account_tbl.payment_approved_date, order_request_tabel.vendor_amount,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,vendor_customer_tbl.vcode,vendor_customer_tbl.vendor_name,tbl_customers.customer_name,su.full_name as sales_name,su.branch_id as sales_branch_id,tu.full_name as traffic_manager_name,tbl_branch.branch_name as trafic_manager_branch 
		from ftl_request_tbl LEFT JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id 
		LEFT JOIN tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id LEFT JOIN tbl_users as su ON su.user_id = ftl_request_tbl.sales_user_id LEFT JOIN tbl_users as tu ON tu.user_id = ftl_request_tbl.tm_user_id 
		LEFT JOIN tbl_branch ON tbl_branch.branch_id = ftl_request_tbl.branch_id LEFT JOIN order_request_tabel ON order_request_tabel.ftl_request_id = ftl_request_tbl.id 
		LEFT JOIN ftl_account_tbl ON ftl_account_tbl.ftl_request_id = ftl_request_tbl.ftl_request_id  where ftl_request_tbl.trafic_approve_status ='1' AND ftl_account_tbl.status ='1' GROUP BY ftl_request_tbl.ftl_request_id limit " . $offset . ",10");
		$resActt = $this->db->query("SELECT ftl_request_tbl.*,ftl_account_tbl.utr_no,ftl_account_tbl.payment_approved_by,ftl_account_tbl.payment_approved_date,order_request_tabel.vendor_amount,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,vendor_customer_tbl.vcode,vendor_customer_tbl.vendor_name,tbl_customers.customer_name,su.full_name as sales_name,su.branch_id as sales_branch_id,tu.full_name as traffic_manager_name,tbl_branch.branch_name as trafic_manager_branch from ftl_request_tbl LEFT JOIN vendor_customer_tbl ON vendor_customer_tbl.customer_id = ftl_request_tbl.vc_id LEFT JOIN tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id LEFT JOIN tbl_users as su ON su.user_id = ftl_request_tbl.sales_user_id LEFT JOIN tbl_users as tu ON tu.user_id = ftl_request_tbl.tm_user_id LEFT JOIN tbl_branch ON tbl_branch.branch_id = ftl_request_tbl.branch_id LEFT JOIN order_request_tabel ON order_request_tabel.ftl_request_id = ftl_request_tbl.id LEFT JOIN ftl_account_tbl ON ftl_account_tbl.ftl_request_id = ftl_request_tbl.ftl_request_id where ftl_request_tbl.trafic_approve_status ='1' AND ftl_account_tbl.status='1' GROUP BY ftl_request_tbl.ftl_request_id ");

		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/ftl-payment/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($ftl_payment->num_rows() > 0) {
			$data['ftl_payment'] 	= 	$ftl_payment->result();
		} else {
			$data['ftl_payment']	= array();
		}

		$this->load->view('admin/trafic_manager/ftl_payment_list', $data);
	}

	public function update_ftl_payment_data()
	{


		$payment_date =	$this->input->post('payment_date');
		$utr_no =	$this->input->post('utr_no');
		$ftl_request_id	= $this->input->post('ftl_request_id');


		$data = array(
			'payment_date' => $payment_date,
			'utr_no' => $utr_no,
		);

		$this->db->set('ftl_request_id', $ftl_request_id);
		$res =	$this->db->update('ftl_account_tbl', $data);
		if (!empty($res)) {
			$this->session->set_userdata('msg', 'Payment Status Updated Successfully!!');
			redirect(base_url() . 'admin/ftl-payment');
		}
	}

	public function ftl_vendor_list($offset = '0')
	{
		$vendor_list = $this->db->query("select * from vendor_customer_tbl  ORDER BY customer_id  DESC limit " . $offset . ",10");

		$resActt = $this->db->query("select * from vendor_customer_tbl");

		$this->load->library('pagination');

		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'admin/ftl-payment/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			    = 10;
		$config['full_tag_open'] 		= '<nav aria-label="..."><ul class="pagination">';
		$config['full_tag_close'] 		= '</ul></nav>';
		$config['first_link'] 			= '&laquo; First';
		$config['first_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['first_tag_close'] 		= '</li>';
		$config['last_link'] 			= 'Last &raquo;';
		$config['last_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['last_tag_close'] 		= '</li>';
		$config['next_link'] 			= 'Next';
		$config['next_tag_open'] 		= '<li class="next paginate_button page-item">';
		$config['next_tag_close'] 		= '</li>';
		$config['prev_link'] 			= 'Previous';
		$config['prev_tag_open'] 		= '<li class="prev paginate_button page-item">';
		$config['prev_tag_close'] 		= '</li>';
		$config['cur_tag_open'] 		= '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 		= '</a></li>';
		$config['num_tag_open'] 		= '<li class="paginate_button page-item">';
		$config['reuse_query_string'] 	= TRUE;
		$config['num_tag_close'] 		= '</li>';
		$config['attributes'] = array('class' => 'page-link');

		if ($offset == '') {
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 1;
		} else {
			$config['uri_segment'] 			= 3;
			$data['serial_no']		= $offset + 1;
		}


		$this->pagination->initialize($config);
		if ($vendor_list->num_rows() > 0) {
			$data['ftl_customer_vendor'] 	= 	$vendor_list->result();
		} else {
			$data['ftl_customer_vendor']	= array();
		}

		$this->load->view('admin/trafic_manager/ftl_customer_vendor', $data);
	}

	public function get_id_vendor_customer()
	{
		$id = $this->input->get('id');
		$data = $this->db->query("select * from  vendor_customer_tbl where customer_id = '$id'")->result_array();
		echo json_encode($data);
	}
	public function update_vendor_customer_stats(){
		print_r($_POST);

		    $approve = $this->input->post('approve'); 
		    $reject = $this->input->post('reject'); 
			if($approve == 'Approve'){
				$p = 1;
			}
			if($reject == 'Reject'){
				$p = 2;
			}

			$id = $this->input->post('customer_id');
			$this->db->query("update vendor_customer_tbl set status ='$p' where customer_id = '$id'");
			//echo $this->db->last_query();exit;
			redirect(base_url() . 'admin/dashboard');
		
	}
}
