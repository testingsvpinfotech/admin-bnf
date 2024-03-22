<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_cnlife_cycle_report extends CI_Controller {

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
    public function cnlifecycle($offset=0,$searching='')
	{
		$username	=	$this->session->userdata("userName");
		$__POST = $_GET;
		
		$usernamee	=	$this->input->post("username");
		$whr 		= 	array('username'=>$username);
		$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);
		
		$branch_id	= 	$res->row()->branch_id;
		$filterCond ='';
		$data['international_allpoddata'] 	 = array();
		$data['domestic_allpoddata']		 = array();
		$total_domestic_allpoddata		 	 = 0;
		$total_international_allpoddata  	 = 0;
		$whr 								 = 	array('branch_id'=>$branch_id);
		$res								 =	$this->basic_operation_m->getAll('tbl_branch',$whr);
		$branch_name						 =	$res->row()->branch_name;
		$user_id 							 = $this->session->userdata("userId");
		$userType 							 = $this->session->userdata("userType");
		$branch_id 							 = $this->session->userdata("branch_id");
		$all_data 							 = $this->input->get();		
		$data['post_data']					 = $all_data;
		
		// print_r($all_data);exit;
		// echo "<pre>";
		// print_r($this->session->userdata());exit();
			
		if(!empty($all_data))
		{
			
			if($userType !=  '1')
			{
				$whr 	=	"tbl_international_booking.branch_id = '$branch_id'";
				$whr_d 	=	"tbl_domestic_booking.branch_id = '$branch_id'";
			}
			else
			{
				$whr 	=	'1';
				$whr_d 	=	'1';
			}
			
			
			
			$awb_no = $all_data['awb_no'];
			if($awb_no!="")
			{
			    $whr	.=	" AND tbl_international_booking.pod_no='$awb_no'";
				$whr_d	.=	" AND  tbl_domestic_booking.pod_no='$awb_no'";  				
			}
			
			$bill_type = $all_data['bill_type'];
			if($bill_type!="ALL")
			{
				$whr	.=" AND  dispatch_details='$bill_type'";
				$whr_d	.=" AND  dispatch_details='$bill_type'";
			}
			
		    $doc_type = $all_data['doc_type'];
		    if($doc_type=='1')
			{
		    	$sel_doc_type ="Non Document";
		    }
			else if($doc_type=='0')
			{
		    	$sel_doc_type ="Document";
		    }
			else
			{
		    	$sel_doc_type ="ALL";
		    }
		    
		    $courier_company = $all_data['courier_company'];		
		    if($courier_company!="ALL")
			{
    			$whr	.=" AND tbl_international_booking.courier_company_id='$courier_company'";
    			$whr_d	.=" AND tbl_domestic_booking.courier_company_id='$courier_company'";
            }
			
            $status 	= $all_data['status'];
			
		    if(($status == 1 || $status == 0) && $status != 'ALL')
			{
			
				$whr	.=" AND tbl_international_booking.is_delhivery_complete='$status'";
				$whr_d	.=" AND tbl_domestic_booking.is_delhivery_complete='$status'";
			}
			elseif($status == 2)
			{
				$whr	.=" AND (
					tbl_international_tracking.status = 'RTO' 
					OR tbl_international_tracking.status LIKE '%Return%'
					OR tbl_international_tracking.status = 'Return to Orgin' 
					OR tbl_international_tracking.status = 'Door Close' 
					OR tbl_international_tracking.status = 'Address ok no search person' 
					OR tbl_international_tracking.status = 'Address not found' 
					OR tbl_international_tracking.status = 'No service' 
					OR tbl_international_tracking.status = 'Refuse' 
					OR tbl_international_tracking.status = 'Wrong address' 
					OR tbl_international_tracking.status = 'Person expired' 
					OR tbl_international_tracking.status = 'Lost Intransit' 
					OR tbl_international_tracking.status = 'Not collected by consignee' 
					OR tbl_international_tracking.status = 'Delivery not attempted'

				)";
				
				$whr_d	.=" AND (
					tbl_domestic_tracking.status = 'RTO' 
					OR tbl_domestic_tracking.status LIKE '%Return%'
					OR tbl_domestic_tracking.status = 'Return to Orgin' 
					OR tbl_domestic_tracking.status = 'Door Close' 
					OR tbl_domestic_tracking.status = 'Address ok no search person' 
					OR tbl_domestic_tracking.status = 'Address not found' 
					OR tbl_domestic_tracking.status = 'No service' 
					OR tbl_domestic_tracking.status = 'Refuse'  
					OR tbl_domestic_tracking.status = 'Wrong address' 
					OR tbl_domestic_tracking.status = 'Person expired' 
					OR tbl_domestic_tracking.status = 'Lost Intransit' 
					OR tbl_domestic_tracking.status = 'Not collected by consignee' 
					OR tbl_domestic_tracking.status = 'Delivery not attempted'

				)";	
			}
		    
			$customer_id = $all_data['customer_id'];		
		    if($customer_id!="ALL")
			{
    			$whr	.=" AND tbl_international_booking.customer_id='$customer_id'";
    			$whr_d	.=" AND tbl_domestic_booking.customer_id='$customer_id'";
            }
			
			if($sel_doc_type!="ALL")
			{
				$whr	.=" AND doc_nondoc='$sel_doc_type'";
				$whr_d	.=" AND doc_nondoc='$sel_doc_type'";
			}
			
			$from_date 	= $all_data['from_date'];
			$to_date 	= $all_data['to_date'];	
			if($from_date!="" && $to_date!="")
			{
			    $from_date	 	 = date("Y-m-d",strtotime($all_data['from_date']));
			    $to_date 		 = date("Y-m-d",strtotime($all_data['to_date']));	
				$whr			.=" AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
				$whr_d			.=" AND  date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
			}
			
	
		    $company_type = $all_data['company_type'];
		
			if($company_type!="ALL")
			{
			    if($company_type=="International")
				{
			        $data['international_allpoddata'] = $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
			    }
				else if($company_type=="Domestic")
			    {
			        $data['domestic_allpoddata'] 		= $this->Generate_pod_model->get_domestic_tracking_data($whr_d,"100",$offset);
					
			    }
			}
			else
			{
				
		
			    $data['international_allpoddata'] 		= $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
			    // echo $this->db->last_query();
			    $data['domestic_allpoddata'] 			= $this->Generate_pod_model->get_domestic_tracking_data($whr_d,"100",$offset);

			    // echo "<br>";
			    // echo $this->db->last_query();
				
				
			}
			
			$filterCond = urldecode($whr_d);
		}
		else
		{    
	
	
			if(!empty($searching))
			{
				$filterCond 	= urldecode($searching);
				$whr			= str_replace('domestic','international',$filterCond);
				$whr_d			= $filterCond;
			}
			else
			{
				$from_date 	 = date("Y-m-d");
				$to_date	 = date("Y-m-d");
				$whr		 = "";
				$whr_d		 = "";
				
			}
		
			//	$pod = $value['pod_no'];
	      	//  $customer_id = $value['customer_id'];
	    	//$getfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left 	join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->result_array(); 
		   	// $getMasterfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->result_array(); 



			//$whr									= str_replace('1','',$whr);
			//$whr_d									= str_replace('1','',$whr_d);
	
			
		    // $data['international_allpoddata'] 		= $this->Generate_pod_model->get_international_tracking_data($whr,"100",$offset);
			// $data['domestic_allpoddata'] 			= $this->Generate_pod_model->get_domestic_tracking_data($whr_d,"100",$offset); 
			
		}
		
		$i_cnt = $this->tot_cnt_i($whr);
	    $d_cnt = $this->tot_cnt_d($whr_d); 
		
			
		$this->load->library('pagination');
		$total_count1 							= $i_cnt + $d_cnt;
		
			
		$data['total_count']			= $total_count1;
		$config['total_rows'] 			= $total_count1;
		$config['base_url'] 			= 'admin/list-mis-report/';
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
		
		$data['courier_company']	= $this->basic_operation_m->get_all_result("courier_company","");
		$data['customers_list']		= $this->basic_operation_m->get_all_result("tbl_customers","");
		$data['mode_list'] 			= $this->basic_operation_m->get_all_result('transfer_mode','');
		
		$this->load->view('admin/report_master/view_cnlifecycle',$data);
	}

	public function tot_cnt_i($whrAct){
		$this->db->select('count(*) as cnt');
		$this->db->from('tbl_international_booking');
		if($whrAct!="")	
		{
			$this->db->where($whrAct);
		}
		// $this->db->limit(100,$limit);
		$query=$this->db->get();

		$temp= $query->row_array();
		// echo $this->db->last_query();

		return $temp['cnt'];
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

		$temp= $query->row_array();

		// echo $this->db->last_query();

		return $temp['cnt'];
	}

	public function download_mis_report($where_d,$where_i)
	{    
		
		$date=date('d-m-Y');
		$filename = "Mis_report_".$date.".csv";
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
			"Last Genrated Bag",
			"Last Genrated Menifiest",
	       	"TAT",
			"EDD Date",
			"Delivery Date",
			"Deliverd TO",
			"RTO Date",
			"RTO Reason",
			"Sub Total",
			"POD Status", 
			"Franchise Code", 
	       	"Franchise Name",
		   	"Master Franchise Name",
	       	"eWay no",
	       	"Pickupinscan date & time",
	       	"pickupinscan branch",
	       	"DRS Date & time",
	       	"DRS Branch",
	       	"Booking Branch Out scan Date & Time",
	       	"Delivery branch In-scan"
		);
		
			
		// $header =array("SrNo","Date","franchise","Master Franchise","Booking Branch","AWB","Network","Type","ForwordingNo","Destination","Customer","Receiver","Receiver Addr","Receiver Pincode","Doc/Non-doc","Weight","Bill Type","Status","Delivery Date","EDD","TAT","Deliverd TO","RTO Date","RTO Reason");
		
		$international_allpoddata 		= $this->Generate_pod_model->get_international_tracking_data($where_i,"","");
		$domestic_allpoddata 				= $this->Generate_pod_model->get_domestic_tracking_data($where_d,"",""); 
			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
         
		fputcsv($fp, $header);
		$i =1;
		// print_r($domestic_allpoddata);die;
		foreach($domestic_allpoddata as $value_d) 
		{
		 	$tat 			= '';
		    $rto_reason 	= '';
			$rto_date 		= '';
			$delivery_date 	= '';
			if($value_d['status'] == 'RTO' || $value_d['status']=='Return to Orgin' || $value_d['status']=='Door Close' || $value_d['status']=='Address ok no search person' || $value_d['status']=='Address not found' || $value_d['status']=='No service' || $value_d['status']=='Refuse' || $value_d['status']=='Shifted' || $value_d['status']=='Wrong address' || $value_d['status']=='Person expired' || $value_d['status']=='Lost Intransit' || $value_d['status']=='Not collected by consignee' || $value_d['status']=='Delivery not attempted')
			{
                $rto_reason     = $value_d['comment'];
                $rto_date       = $value_d['tracking_date'];
                $value_d['status']  = $value_d['status'];
          	}else if($value_d['is_delhivery_complete'] == '1')
			{
				$delivery_date 		=  date('d-m-Y',strtotime($value_d['tracking_date']));
				$value_d['status'] 	= 'Delivered';
														
				$booking_date 		= $start = date('d-m-Y', strtotime($value_d['booking_date']));
				$start 				= date('d-m-Y', strtotime($value_d['booking_date']));
				$end 				= date('d-m-Y', strtotime($value_d['tracking_date']));
				$delivery_date 				= date('d-m-Y', strtotime($value_d['delivery_date']));
				$tat 				= ceil(abs(strtotime($start)-strtotime($end))/86400);
														
			}else{
               
                if ($value_d['status']=='shifted') {
                  	$value_d['status'] = 'Intransit';
                }
														
			}
          	if ($value_d['company_type']=='Domestic') {
                $value_d['company_type'] = 'DOM';
          	}else{
                $value_d['company_type'] = 'INT';
          	}

          	if (!empty($value_d['delivery_date'])) {
                $value_d['delivery_date'] = date('d-m-Y',strtotime($value_d['delivery_date']));
          	}

          	$pod = $value_d['pod_no'];
			$customer_id = $value_d['customer_id'];

			$getfranchise= array();
			$getMasterfranchise= array();
			 if($value_d['user_type']==2){
			 	$getfranchise = $this->db->query("select tbl_customers.customer_name ,cid,tbl_customers.customer_id ,parent_cust_id from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->row_array(); 
			 	$getMasterfranchise = $this->db->query("select tbl_customers.customer_name,cid from tbl_customers  where customer_id ='".$getfranchise['parent_cust_id']."'")->row_array();
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
			$destination = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%shifted%' order by id ASC limit 1")->row();
			$delivery = array();
			if (!empty($outForDelivery)) {
				$delivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_dt' AND status like '%In-scan%' order by id DESC limit 1")->row();
			}
			
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
			 }else{
				$pod_status = 'Yes';
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
			$row = array(
				$i,
				date('d-m-Y', strtotime($value_d['booking_date'])),
				$value_d['pod_no'],
				$mode_d_name->mode_name,
				// $value_d['branch_name'],
				$booking_d_name->branch_name,
				$value_d['city'],
				$customer->cid,
				$customer->customer_name,
				$sender_c->city,
				$value_d['sender_name'],
	            $value_d['reciever_name'],
	            $value_d['reciever_pincode'],
				$value_d['no_of_pack'],
				($actual_weight->actual_weight),
				($value_d['chargable_weight']),
				$value_d['invoice_no'],
				$value_d['invoice_value'],
				$value_d['dispatch_details'],
				$value_d['status'],
				// $booking_d_name->branch_name,
				// $booking_d_name->tracking_date,
				$last_scan->branch_name,
				$last_scan->tracking_date,
				'',
				'',
				$tat,
				"",
			
				$booking_d_tracking->tracking_date,
				$value_d['comment'],
				$rto_date,
				$rto_reason,
				$booking_table->sub_total,
				$pod_status,
				@$getfranchise['cid'],
				@$getfranchise['customer_name'] ,
				@$getMasterfranchise['customer_name'] ,
			    $booking_table->eway_no,
			    @$PickupInScan['tracking_date'],
			    @$PickupInScan['branch_name'],
			    @$outForDelivery['tracking_date'],
			    @$outForDelivery['branch_name'],
				@$destination->tracking_date,
				@$delivery->tracking_date
			);

		
			$i++;
			fputcsv($fp, $row);
		}
		
		foreach($international_allpoddata as $value_d) 
		{
			$rto_reason 	= '';
			$rto_date 	= '';
			$delivery_date 	= '';
			if(@$post_data['status'] == '2')
			{
				$rto_reason 	= $value_d['comment'];
				$rto_date 		= $value_d['tracking_date'];
				$value_d['status'] = $value_d['o_status'];
			}
			

            if (!empty($value_d['delivery_date'])) {
                $value_d['delivery_date'] = date('d-m-Y',strtotime($value_d['delivery_date']));
            }
			

        

	        if ($value_d['status']=='shifted') {
	          $value_d['status'] = 'Intransit';
	        }
	        if ($value_d['company_type']=='Domestic') {
	          $value_d['company_type'] = 'DOM';
	        }else{
	          $value_d['company_type'] = 'INT';
	        }

	        $row= array( $i
	            , date('d-m-Y', strtotime($value_d['booking_date']))
	            , $value_d['pod_no']
	            , $value_d['forworder_name']
	            , $value_d['company_type']
	            , $value_d['forwording_no']
	            , $value_d['country_name'] 
	            , $value_d['sender_name']
	            , $value_d['reciever_name']
	            , ''
	            , ''
	            , ''
	            , ''
	            , ($value_d['chargable_weight'])
	            , $value_d['dispatch_details']
	            , $value_d['no_of_pack']
	            , $value_d['status']
	            , $delivery_date
	            ,""
	            ,""
	            , $value_d['comment']
	            , $rto_date
	            , $rto_reason
	            , $value_d['branch_name']
	        );
			
			// $row=array($i,date('d-m-Y', strtotime($value_d['booking_date'])),$value_d['pod_no'],$value_d['forworder_name'],$value_d['company_type'],$value_d['forwording_no'],$value_d['country_name'],$value_d['sender_name'],$value_d['reciever_name'],$value_d['reciever_address'],$value_d['reciever_zipcode'],$value_d['doc_nondoc'],($value_d['chargable_weight']),$value_d['dispatch_details'],$value_d['status'],$delivery_date,"","",$value_d['comment'],$rto_date,$rto_reason);
			
			$i++;
			fputcsv($fp, $row);
		}
		exit;
   	}

	
	
  
   
	
	
}



?>
