<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sales_mis_report extends CI_Controller {

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
		
		$user_id = $this->db->get_where('tbl_users', ['username' => $username])->row('user_id');
		if(!empty($all_data))
		{
			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			
			if($userType !=  '1' AND $userType !=  '20'AND $userType !=  '22'AND $userType !=  '23')
			{
				$whr_d 	=	"cm.sales_person_id = '$user_id'";
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
				// $whr			.=" AND  date(tbl_domestic_booking.booking_date) >='$from_date' AND date(tbl_domestic_booking.booking_date) <='$to_date'";
				$whr_d			.=" AND  date(b.booking_date) >='$from_date' AND date(b.booking_date) <='$to_date'";
			}
			
			$awb_no = $all_data['status'];
			if($awb_no!="")
			{   
				if($awb_no == 'Deliverd'){
				$whr_d	.=	" AND b.is_delhivery_complete='1' or tbl_domestic_stock_history.is_delivered = '1'";  
				}elseif($awb_no == 'Undeliverd'){
					$whr_d	.=	" AND tbl_domestic_stock_history.delivery_sheet='0'";  
				}		
			}		
			$customer_id = $all_data['customer_id'];
			if($customer_id!="")
			{   
				$whr_d	.=	" AND cm.customer_id='$customer_id'";  
			}		
	           
			    $data['domestic_allpoddata'] 			= $this->db->query("SELECT b.*, c.city as origin, c1.city as destination, wt.actual_weight, wt.chargable_weight FROM tbl_domestic_booking b 
				left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
				LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
				LEFT JOIN city c ON(c.id = b.sender_city)
				LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
				LEFT JOIN tbl_domestic_stock_history ON(tbl_domestic_stock_history.pod_no = b.pod_no)					
				WHERE $whr_d ")->result_array();
                // echo $this->db->last_query();die;
	        		    
				// ini_set('display_errors', '1');
				// ini_set('display_startup_errors', '1');
				// error_reporting(E_ALL);
			$filterCond = urldecode($whr_d);
			$d_cnt = $this->tot_cnt_d($whr_d); 
		}
		else
		{    
	
	
			if(!empty($searching))
			{
				$filterCond 	= urldecode($searching);
				
				$whr_d			= $filterCond;
			}
			else
			{
				$from_date 	 = date("Y-m-d");
				$to_date	 = date("Y-m-d");
				$whr_d		 = "";
				
			}
		
			$d_cnt = $this->tot_cnt_d($whr_d); 
		}
		
		// $i_cnt = $this->tot_cnt_i($whr);
	    
		
			
		$this->load->library('pagination');
		$total_count1 							= $d_cnt;
		
			
		$data['total_count']			= $total_count1;
		$config['total_rows'] 			= $total_count1;
		$config['base_url'] 			= 'admin/sales-customer-mis-report/';
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
		$this->load->view('admin/sales_mis_report/view_sales_mis_report',$data);
	}

	

	public function tot_cnt_d($whrAct){
		if(! empty($whrAct)){
			$whare = $whrAct;
		
		$query			= $this->db->query("SELECT b.*,count(*) as cnt, c.city as origin, c1.city as destination, wt.actual_weight, wt.chargable_weight, wt.no_of_pack FROM tbl_domestic_booking b 
		left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
		LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
		LEFT JOIN city c ON(c.id = b.sender_city)
		LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
		LEFT JOIN tbl_domestic_stock_history ON(tbl_domestic_stock_history.pod_no = b.pod_no)					
		WHERE $whrAct");
		// echo $this->db->last_query();die;
		$temp= $query->row_array();

		

		return $temp['cnt'];
	}
	}

	public function download_mis_report($where_d)
	{    
		
		$date=date('d-m-Y');
		$filename = "Sales_Mis_report_".$date.".csv";
		$fp = fopen('php://output', 'w');
		$tat = '';
	
		$header =array(
			"SrNo",
	       	"Booking Date",
	       	"AWB",
	       	"Mode",
	       	"Booking Branch",
	       	"Destination",
	       	"Customer code",
	       	"Customer Name",
			"Consignor Origin",
	       	"Consignor",
	       	"Consignee",
	       	"Consignee Pincode",
	       	"NOP",
	       	"AW",
	       	"CW",
	       	"Consignor Invoice No",
	       	"Consignor Invoice Value",
	       	"Bill Type",
	       	"Current Status",
	       	"Last Scan Branch",
	       	"Last scan Date & time",
	       	"TAT",
			"EDD Date",
			"Delivery Date",
			"Deliverd TO",
			"RTO Date",
			"RTO Reason",
			"Sub Total",
			"POD Status", 
			"POD Uploaded Date & Time", 
			"Franchise Code", 
	       	"Franchise Name",
		   	"Master Franchise Name",
	       	"eWay no",
	       	"Eway Expiry date",
	       	"Pickupinscan date & time",
	       	"pickupinscan branch",
	       	"Booking Branch Out scan Date & Time",
	       	"Delivery branch In-scan Date & Time",
			"DRS Date & time",
	       	"DRS Branch",
			"Regular/ODA",
			"Freight",
			"Handling",
			"Pickup",
			"ODA",
			"Insurance",
			"COD",
			"AWB",
			"Other",
			"Topay",
			"Appoint",
			"FOV",
			"Total",
			"Fuel",
			"Subtotal",
			"PRQ No",
			"Pickup Genarte Date",
			"Pickup Requested Date",
			"PRQ Closed Date",
			"PRQ Comment",
			"Cash Invoice No",
			"Invoice Date",
			"PayBy",
			"Payment Ref No",
			"Coloader Name",
			"CD No",
			"CD Outscan",
			"CD Inscan",
			"Product Desc",
			"Type Of Package"

		);
		
		$usernamee	=	$this->input->post("username");
		$user_id = $this->db->get_where('tbl_users', ['username' => $usernamee])->row('user_id');
		// $domestic_allpoddata 				= $this->Generate_pod_model->get_domestic_tracking_data($where_d,"",""); 
		$domestic_allpoddata			= $this->db->query("SELECT b.*, c.city as origin, c1.city as destination, wt.actual_weight, wt.chargable_weight ,cm.* FROM tbl_domestic_booking b 
		left JOIN tbl_customers cm ON(cm.customer_id = b.customer_id)
		LEFT JOIN tbl_domestic_weight_details wt ON(wt.booking_id = b.booking_id)
		LEFT JOIN city c ON(c.id = b.sender_city)
		LEFT JOIN city c1 ON(c1.id = b.reciever_city)					
		LEFT JOIN tbl_domestic_stock_history ON(tbl_domestic_stock_history.pod_no = b.pod_no)								
		WHERE $where_d")->result_array();
    //    echo $this->db->last_query();die;
		// $domestic_allpoddata			= $this->db->query("select tbl_domestic_deliverysheet.* , tbl_upload_pod.booking_date as date, tbl_upload_pod.image as img from tbl_domestic_stock_history JOIN tbl_domestic_booking ON tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no JOIN tbl_domestic_deliverysheet ON tbl_domestic_deliverysheet.pod_no = tbl_domestic_stock_history.pod_no LEFT JOIN tbl_upload_pod on tbl_upload_pod.pod_no = tbl_domestic_stock_history.pod_no where $where_d order by tbl_domestic_stock_history.id desc")->result_array();

			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
         
		fputcsv($fp, $header);
		$i =1;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		foreach($domestic_allpoddata as $value_d) 
		{

			$tat 			= '';
		    $rto_reason 	= '';
			$rto_date 		= '';
			$delivery_date 	= '';
			$pod = $value_d['pod_no'];
			$customer_id = $value_d['customer_id'];

			$getfranchise= array();
			$getMasterfranchise= array();
			 if($value_d['user_type']==2){
			 	$getfranchise = $this->db->query("select tbl_customers.customer_name ,cid,tbl_customers.customer_id ,parent_cust_id from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->row_array(); 
			 	$getMasterfranchise = $this->db->query("select tbl_customers.customer_name,cid from tbl_customers  where customer_type = '1' and customer_id ='".$getfranchise['parent_cust_id']."'")->row_array();
			 }


			//  mode get 
			$mode_d = $value_d['mode_dispatch'];
			$mode_d_name = $this->db->query("select * from transfer_mode where transfer_mode_id = '$mode_d'")->row();
			//  booking branch 
			$booking_d = $value_d['pod_no'];
			$booking_d_name = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id ASC limit 1")->row();
			$booking_dt = $value_d['pod_no'];

			$PickupInScan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Pickup-In-scan' order by id ASC limit 1")->row_array();

			$outForDelivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Out For Delivery' order by id ASC limit 1")->row_array();


			$booking_d_tracking = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' and status = 'Delivered' order by id DESC limit 1")->row();
			$last_scan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' order by id DESC limit 1")->row();
			if($last_scan->status == 'In transit'){
			   $last = $this->db->query("select tbl_domestic_menifiest.source_branch from tbl_domestic_bag JOIN tbl_domestic_menifiest ON tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id where tbl_domestic_bag.pod_no = '$booking_dt' order by tbl_domestic_bag.id desc limit 1")->row();
               $last_branch = $last->source_branch;
			}else{
				$last_branch = $last_scan->branch_name;
			}
			$destination = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%shifted%' order by id ASC limit 1")->row();
			$delivery = array();
			if (!empty($outForDelivery)) 
			{
				$delivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%In-scan%' order by id DESC limit 1")->row();
			}
				$transit  = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%In transit%' order by id ASC limit 1")->row();
			
		    //  print_r($destination->tracking_date);die;
			// echo '<pre>';print_r($booking_d_tracking->tracking_date);die;//  customer code 
			$customer = $this->db->query("select * from tbl_customers where customer_id = '$customer_id'")->row();
			// actual_weight 
			$booking_id = $value_d['booking_id'];
			$actual_weight  = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$booking_id'")->row();
			// booking 
			$booking_id = $value_d['booking_id'];
			$booking_table  = $this->db->query("select * from tbl_domestic_booking where booking_id = '$booking_id'")->row();
		
			$cid = $booking_table->sender_city;;
			$sender_c  = $this->db->query("select * from city where id = '$cid'")->row();
			// pod 
			$pod_no = $value_d['pod_no'];
			$pod_check  = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->row();
			 if(empty($pod_check)){
				$pod_status = 'NO';
				$date_time_pod = '';
			 }else{
				$pod_status = 'Yes';
				$date_time_pod  = $pod_check->booking_date;
			 }
			 $delivery_date1 		=  date('d-m-Y',strtotime($booking_d_name->tracking_date));
			ini_set('display_errors', '0');
			ini_set('display_startup_errors', '0');
			error_reporting(E_ALL);
			if($value_d['is_delhivery_complete'] == '1'){
				$val= $delivery_date1;
			}else{
				$val='';
			}
			if($value_d['delivery_charges'] > 0)
			{
				$regular_oda = 'ODA';
			}
			else
			{
				$regular_oda = 'Regular';
			}
			if(! empty(@$value_d['prq_no'])){
				$close = date('d-m-Y', strtotime($value_d['booking_date']));
			}else{
				$close = '';
			}
              $awb = $value_d['pod_no'];
			  $value = $this->db->query("select tbl_domestic_invoice_detail.*,tbl_domestic_invoice.* from tbl_domestic_booking join tbl_domestic_invoice_detail on tbl_domestic_invoice_detail.pod_no = tbl_domestic_booking.pod_no join tbl_domestic_invoice on tbl_domestic_invoice.id = tbl_domestic_invoice_detail.invoice_id  where tbl_domestic_booking.pod_no = '$awb' and tbl_domestic_booking.dispatch_details='CASH'")->row();
			  $menifest_coloader = $this->db->query("select tbl_domestic_menifiest.* from tbl_domestic_bag  join tbl_domestic_menifiest on tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id where pod_no = '$awb' order by id desc")->row();

			 
			 $row = array(
				$i,
				
				date('d-m-Y', strtotime($value_d['booking_date'])),
				$value_d['pod_no'],
				$mode_d_name->mode_name,
				// $value_d['branch_name'],
				$booking_d_name->branch_name,
				$value_d['destination'],
				$value_d['cid'],
				$value_d['customer_name'],
				$sender_c->city,
				$value_d['sender_name'],
	            $value_d['reciever_name'],
	            $value_d['reciever_pincode'],
				// $value_d['no_of_pack'],
				($actual_weight->no_of_pack),
				($actual_weight->actual_weight),
				($value_d['chargable_weight']),
				$value_d['invoice_no'],
				$value_d['invoice_value'],
				$value_d['dispatch_details'],
				$value_d['status'],
				// $booking_d_name->branch_name,
				// $booking_d_name->tracking_date,
				$last_branch,
				$last_scan->tracking_date,
				$tat,
				"",
			
				$booking_d_tracking->tracking_date,
				$value_d['comment'],
				$rto_date,
				$rto_reason,
				$booking_table->sub_total,
				$pod_status,
				$date_time_pod,
				@$getfranchise['cid'],
				@$getfranchise['customer_name'] ,
				@$getMasterfranchise['customer_name'] ,
			    $booking_table->eway_no,
			    $booking_table->eway_expiry_date,
			    @$PickupInScan['tracking_date'],
			    @$PickupInScan['branch_name'],
				@$transit->tracking_date,
				@$delivery->tracking_date,
			    @$outForDelivery['tracking_date'],
			    @$outForDelivery['branch_name'],
				@$regular_oda,
				@$value_d['frieht'],
				@$value_d['transportation_charges'],
				@$value_d['pickup_charges'],
				@$value_d['delivery_charges'],
				@$value_d['insurance_charges'],
				@$value_d['courier_charges'],
				@$value_d['awb_charges'],
				@$value_d['other_charges'],
				@$value_d['green_tax'],
				@$value_d['appt_charges'],
				@$value_d['fov_charges'],
				@$value_d['total_amount'],
				@$value_d['fuel_subcharges'],
				@$value_d['sub_total'],
				@$value_d['prq_no'],
				@$value_d['create_date'],
				@$value_d['pickup_date'],
				$close,
				@$value_d['instruction'],
				$value->invoice_number,
				$value->invoice_date,
				$value->payment_type,
				@$value_d['ref_no'],
				$menifest_coloader->coloader,
				$menifest_coloader->cd_no,
				$menifest_coloader->cd_no_edited_date,
				$menifest_coloader->cd_recived_date,
				@$value_d['special_instruction'],
				@$value_d['type_shipment']
			);
			$i++;
			fputcsv($fp, $row);
		}
		exit;
   	}

		
	
}



?>
