<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_sales_customer_report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Booking_model');
		$this->load->model('Generate_pod_model');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}
	public function branch_report($offset=0,$searching='')
	{
		$username	=	$this->session->userdata("userName");
		$__POST = $_GET;

		$usernamee	=	$this->input->post("username");
		$whr 		= 	array('username'=>$username);
		$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);

		$branch_id	= 	$res->row()->branch_id;
		$user_id	= 	$res->row()->user_id;
		$filterCond ='';
		$data['domestic_allpoddata']		 = array();
		$whr 								 = 	array('branch_id'=>$branch_id);
		$res								 =	$this->basic_operation_m->getAll('tbl_branch',$whr);
		$branch_name						 =	$res->row()->branch_name;
		$userType 							 = $this->session->userdata("userType");
		$branch_id 							 = $this->session->userdata("branch_id");
		$all_data 							 = $this->input->get();		
		$data['post_data']					 = $all_data;
		$whr_d = '';

		if(!empty($all_data))
		{
				if ($_GET['customer_id'] != 0) {
					$whr_d .= " AND cm.customer_id =" . $_GET['customer_id'];
				}
				if (is_numeric($_GET['status'])) {
					$whr_d .= " AND b.invoice_generated_status =" . $_GET['status'];
				}
				if ($_GET['from_date'] != '' && $_GET['to_date'] != '') {
					$whr_d .= " AND b.booking_date BETWEEN '" . $_GET['from_date'] . "' AND '" . $_GET['to_date'] . "'";
				}
	

			$data['booking_data'] = $this->db->query("SELECT b.*, c.city as origin, c1.city as destination, wt.actual_weight, wt.chargable_weight FROM tbl_domestic_booking b 
			left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
			LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
			LEFT JOIN city c ON(c.id = b.sender_city)
			LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
			WHERE cm.sales_person_id = $user_id  $whr_d")->result();
			// echo $this->db->last_query();die;

				// ini_set('display_errors', '1');
				// ini_set('display_startup_errors', '1');
				// error_reporting(E_ALL);
			$filterCond = urldecode($whr_d);
		}
		else
		{    


			if(!empty($searching))
			{
				$filterCond 	= urldecode($searching);
				$whr			= str_replace($filterCond);
				$whr_d			= $filterCond;
			}
			else
			{
				$from_date 	 = date("Y-m-d");
				$to_date	 = date("Y-m-d");
				$whr		 = "";
				$whr_d		 = "";

			}


		}

		// $i_cnt = $this->tot_cnt_i($whr);
	    $d_cnt = $this->tot_cnt_d($whr_d); 


		$this->load->library('pagination');
		$total_count1 							= $d_cnt;


		$data['total_count']			= $total_count1;
		$config['total_rows'] 			= $total_count1;
		$config['base_url'] 			= 'admin/list-delivery-branch-report/';
		// $config['suffix'] 				= '/'.urlencode($filterCond);

		$config['per_page'] 			= 100;
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

		if($offset == '')
		{
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= 0;
		}
		else
		{
			$config['uri_segment'] 			= 3;
			$data['serial_no']				= $offset + 1;
		}



		if(isset($_GET['submit']) && $_GET['submit'] == 'Download Excel')
		{
			// echo "Exist";exit();
			$this->download_mis_report($whr_d,$whr);
		}

		$this->pagination->initialize($config);


		$data['customers'] = $this->db->query("select * from tbl_customers where sales_person_id = '$user_id' and sales_person_id != '0'")->result();
		// echo $this->db->last_query();die;
		// $this->load->view('admin/sales_customer_report/view_sales_customer_report',$data);
		$this->load->view('admin/sales_customer_report/view_sales_customer_report', $data);
	}

	// public function branch_report($offset = 0, $searching = '')
	// {
	// 	$username = $this->session->userdata("userName");
	// 	$usernamee = $this->input->post("username");
	// 	$user_id = $this->db->get_where('tbl_users', ['username' => $username])->row('user_id');
	// 	$data['customers'] = $this->db->query("select * from tbl_customers where sales_person_id = '$user_id' and sales_person_id != '0'")->result();
	
	// 	$get_where = '';
	// 	$get_status = '';
	// 	$get_date123 = '';
	// 	if (isset($_GET['submit']) && $_GET['submit'] == 'Search') {
	// 		if ($_GET['customer_id'] != 0) {
	// 			$get_where .= " AND cm.customer_id =" . $_GET['customer_id'];
	// 		}
	// 		if (is_numeric($_GET['status'])) {
	// 			$get_status .= " AND b.invoice_generated_status =" . $_GET['status'];
	// 		}
	// 		if ($_GET['from_date'] != '' && $_GET['to_date'] != '') {
	// 			$get_date123 .= " AND b.booking_date BETWEEN '" . $_GET['from_date'] . "' AND '" . $_GET['to_date'] . "'";
	// 		}

	// 		$data['booking_data'] = $this->db->query("SELECT b.*, c.city as origin, c1.city as destination, wt.actual_weight, wt.chargable_weight FROM tbl_domestic_booking b 
	// 				left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
	// 				LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
	// 				LEFT JOIN city c ON(c.id = b.sender_city)
	// 				LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
	// 				WHERE cm.sales_person_id = $user_id  $get_where $get_status $get_date123")->result();
		
	// 	}
		
	// 	$this->load->view('admin/sales_customer_report/view_sales_customer_report', $data);
	// }



	public function tot_cnt_d($whrAct)
	{
		$username	=	$this->session->userdata("userName");
		$__POST = $_GET;
		$whr 		= 	array('username'=>$username);
		$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);

		$branch_id	= 	$res->row()->branch_id;
		$user_id	= 	$res->row()->user_id;
	
		$query = $this->db->query("SELECT count(*) as cnt FROM tbl_domestic_booking b 
			left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
			LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
			LEFT JOIN city c ON(c.id = b.sender_city)
			LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
			WHERE cm.sales_person_id = $user_id  $whrAct");
		// echo $this->db->last_query();die;
		$temp = $query->row_array();



		return $temp['cnt'];
	}

	public function download_mis_report($where_d, $where_i)
	{

		$date = date('d-m-Y');
		$filename = "Sales_Customers_Report" . $date . ".csv";
		$fp = fopen('php://output', 'w');
		$tat = '';

		$header = array(
			"Sr No",
			"AWB No",
			"Origin",
			"Destination",
			"Booking Date",
			"Frieht Charges	",
			"Transportation Charges	",
			"Pickup Charges	",
			"Delivery Charges",
			"Insurance Charges",
			"Courier Charges",
			"AWB Charges",
			"Others Charges",
			"Topay Charges",
			"Appointment Charges",
			"Fov Charges",
			"Actual Weight",
			"Chargable Weight",
			"Subtotal"
		);
		$username	=	$this->session->userdata("userName");
		$__POST = $_GET;
		$whr 		= 	array('username'=>$username);
		$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);

		$branch_id	= 	$res->row()->branch_id;
		$user_id	= 	$res->row()->user_id;
	
		
		$domestic_allpoddata = $this->db->query("SELECT b.*, c.city as origin, c1.city as destination, wt.actual_weight, wt.chargable_weight FROM tbl_domestic_booking b 
		left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
		LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
		LEFT JOIN city c ON(c.id = b.sender_city)
		LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
		WHERE cm.sales_person_id = $user_id $where_d")->result_array();

	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 1;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
		foreach ($domestic_allpoddata as $value_d) {

			$actual_weight = !empty($value_d['actual_weight'])?$value_d['actual_weight']:'';
			$chargable_weight = !empty($value_d['chargable_weight'])?$value_d['chargable_weight']:'';
			$sub_total = !empty($value_d['sub_total'])?$value_d['sub_total']:'';
			$row = array(
				$i,
				$value_d['pod_no'],
				$value_d['origin'],
				$value_d['destination'],
				$value_d['booking_date'],
				$value_d['frieht'],
				$value_d['transportation_charges'],
				$value_d['pickup_charges'],
				$value_d['delivery_charges'],
				$value_d['insurance_charges'],
				$value_d['courier_charges'],
				$value_d['awb_charges'],
				$value_d['other_charges'],
				$value_d['green_tax'],
				$value_d['appt_charges'],
				$value_d['fov_charges'],
				$actual_weight,
				$chargable_weight,
				$sub_total,
				
			);
			$i++;
			fputcsv($fp, $row);
			$actual_weightp+= $actual_weight;
			$chargable_weightp+= $chargable_weight;
			// $sub_total+= $value_d['sub_total'];
			$sub_totalp+=($sub_total != 0)?$sub_total:0.00;
		}
		
		$row = array('Total',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		$actual_weightp,
		$chargable_weightp,
		$sub_totalp,
	);
		fputcsv($fp, $row);
		exit;
	}



}



?>