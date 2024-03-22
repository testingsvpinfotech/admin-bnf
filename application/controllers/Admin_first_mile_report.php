<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_first_mile_report extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('basic_operation_m');
        $this->load->model('Booking_model');
        $this->load->model('Generate_pod_model');
		if($this->session->userdata('userId') == '')
		{
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
		$filterCond ='';
		$data['domestic_allpoddata']		 = array();
		$total_domestic_allpoddata		 	 = 0;
		$total_international_allpoddata  	 = 0;
		$whr 								 = 	array('branch_id'=>$branch_id);
		$res								 =	$this->basic_operation_m->getAll('tbl_branch',$whr);
		$branch_name						 =	$res->row()->branch_name;
		$userType 							 = $this->session->userdata("userType");
		$branch_id 							 = $this->session->userdata("branch_id");
		$all_data 							 = $this->input->get();		
		$data['post_data']					 = $all_data;
		
			
		if(!empty($all_data))
		{
			ini_set('display_errors', '1');
			ini_set('display_startup_errors', '1');
			error_reporting(E_ALL);
			
			if($userType !=  '1' AND $userType !=  '20'AND $userType !=  '22'AND $userType !=  '23')
			{
				$whr_d 	=	"AND tbl_domestic_booking.branch_id = '$branch_id'";
			}
			else
			{
				$whr 	=	'1';
				$whr_d 	=	'1';
			}
				
			
			
			$from_date 	= $all_data['from_date'];
			$to_date 	= $all_data['to_date'];	
			if($from_date!="" && $to_date!="")
			{
			    $from_date	 	 = date("Y-m-d",strtotime($all_data['from_date']));
			    $to_date 		 = date("Y-m-d",strtotime($all_data['to_date']));	
				$whr			.=" AND  date(tbl_domestic_booking.booking_date) >='$from_date' AND date(tbl_domestic_booking.booking_date) <='$to_date'";
				$whr_d			.=" AND  date(tbl_domestic_booking.booking_date) >='$from_date' AND date(tbl_domestic_booking.booking_date) <='$to_date'";
			}
			
			
	           
			    $data['domestic_allpoddata'] 			= $this->db->query("select tbl_domestic_booking.branch_id as branch_id,tbl_domestic_booking.pod_no ,tbl_domestic_booking.booking_date ,tbl_domestic_booking.booking_time,city from tbl_domestic_booking join city on city.id = tbl_domestic_booking.reciever_city where tbl_domestic_booking.branch_id != '0' and $whr_d  order by tbl_domestic_booking.booking_id desc limit 100")->result_array();
                // echo $this->db->last_query();die;
	        	
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
		
	
		$this->load->view('admin/first_mile_report/view_first_mile_report',$data);
	}

	
	
	public function tot_cnt_d($whrAct){
		$this->db->select('count(*) as cnt');
		$this->db->from('tbl_domestic_booking');
		if($whrAct!="")	
		{
			$this->db->where($whrAct);
		}
		// $this->db->limit(100,$limit);
		$query=$this->db->get();
		// echo $this->db->last_query();die;
		$temp= $query->row_array();

		

		return $temp['cnt'];
	}

	public function download_mis_report($where_d,$where_i)
	{    
		
		$date=date('d-m-Y');
		$filename = "First_Mile_report_".$date.".csv";
		$fp = fopen('php://output', 'w');
		$tat = '';
	
		$header =array(
			"Sr No",
			"AWB No",
			"Origion",
			"Destination",
	       	"Booking Date",
	       	"Pickup-In-Scan",
	       	"Branch-In-Scan	",
	       	"Bag Genrate",
	       	"Manifest Genrate",
	       	"Master Manifest Genrate"
		);
		
	   
		
		$domestic_allpoddata			= $this->db->query("select tbl_domestic_booking.branch_id as branch_id,tbl_domestic_booking.pod_no ,tbl_domestic_booking.booking_date ,tbl_domestic_booking.booking_time,city  from tbl_domestic_booking join city on city.id = tbl_domestic_booking.reciever_city where tbl_domestic_booking.branch_id != '0' and $where_d order by tbl_domestic_booking.booking_id desc limit 100")->result_array();
				
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
         
		fputcsv($fp, $header);
		$i =1;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		foreach($domestic_allpoddata as $value_d) 
		{

			$pod_no = $value_d['pod_no'];
			$branch_id = $value_d['branch_id'];
			$origin = $this->db->query("select branch_name from tbl_branch where branch_id = '$branch_id'")->row();
			$pickup_in_scan = $this->db->query("select tracking_date from tbl_domestic_tracking where status = 'Pickup-In-scan' order by id ASC")->row();
			$branch_in_scan = $this->db->query("select tracking_date from tbl_domestic_tracking where status = 'In-Scan-Branch' order by id ASC")->row();
			$bag_genrate = $this->db->query("select tracking_date from tbl_domestic_tracking where status = 'Bag genrated' order by id ASC")->row();
			$manifest_in_scan = $this->db->query("select tracking_date from tbl_domestic_tracking where status = 'Manifest genrated' order by id ASC")->row();
			$master_manifest_in_scan = $this->db->query("select tracking_date from tbl_domestic_tracking where status = 'In transit' order by id ASC")->row();
		
			$row = array(
				$i,
				$value_d['pod_no'],
				$origin->branch_name,
				$value_d['city'],
				$value_d['booking_date'].' '.$value_d['booking_time'],
				$pickup_in_scan->tracking_date,
				$branch_in_scan->tracking_date,
				$bag_genrate->tracking_date,
				$manifest_in_scan->tracking_date,
				$master_manifest_in_scan->tracking_date
			);			  
			$i++;
			fputcsv($fp, $row);
		}
		exit;
   	}

		
	
}



?>
