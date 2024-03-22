<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_domestic_branchwise_stock extends CI_Controller  {

	var $data = array();
    function __construct() 
	{
        parent :: __construct();
        $this->load->model('basic_operation_m'); 
        $this->load->model('Rate_model');   
        $this->load->model('booking_model');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}

    }
	
	
	   	public function view_branchwise_stock($offset=0,$searching='') 
	{	
		//print_r($this->session->all_userdata());
	  	if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
		else
		{
    		$data= [];
			
			if(isset($_POST['from_date']))
			{
				$data['from_date'] = $_POST['from_date'];
				$from_date = $_POST['from_date'];
			}
			if(isset($_POST['to_date']))
			{
				$data['to_date'] = $_POST['to_date'];
				$to_date = $_POST['to_date'];
			}
			if(isset($_POST['filter']))
			{
				$filter = $_POST['filter'];
				$data['filter']  = $filter;
			}
			if(isset($_POST['courier_company']))
			{
				$courier_company = $_POST['courier_company'];
				$data['courier_companyy']  = $courier_company;
			}
			if(isset($_POST['user_id']))
			{
				$user_id = $_POST['user_id'];
				$data['user_id']  = $user_id;
			}
			if(isset($_POST['filter_value']))
			{
				$filter_value = $_POST['filter_value'];
				$data['filter_value']  = $filter_value;
			}
    
    		$user_id 	= $this->session->userdata("userId");		
    		$data['customer']=  $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');
    		
    		$user_type 					= $this->session->userdata("userType");			
    		$filterCond					= '';
    		$all_data 					= $this->input->post();
    
	    	if($all_data)
			{	
				$filter_value = 	$_POST['filter_value'];
				
				foreach($all_data as $ke=> $vall)
				{
					if($ke == 'filter' && !empty($vall))
					{
						if($vall == 'pod_no')
						{
							$filterCond .= " AND tbl_domestic_booking.pod_no = '$filter_value'";
						}
						if($vall == 'forwording_no')
						{
							$filterCond .= " AND tbl_domestic_booking.forwording_no = '$filter_value'";
						}
						if($vall == 'sender')
						{
							$filterCond .= " AND tbl_domestic_booking.sender_name LIKE '%$filter_value%'";
						}
						if($vall == 'receiver')
						{
							$filterCond .= " AND tbl_domestic_booking.reciever_name LIKE '%$filter_value%'";
						}
						
						if($vall == 'origin')
						{
							$city_info					 =  $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
							$filterCond 				.= " AND tbl_domestic_booking.sender_city = '$city_info->id'";
						}
						if($vall == 'destination')
						{
							$city_info					 =  $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
							$filterCond 				.= " AND tbl_domestic_booking.reciever_city = '$city_info->id'";
						}
						if($vall == 'pickup')
						{
						
							$filterCond 				.= " AND tbl_domestic_booking.pickup_pending = '1'";
						}
						
					}
					elseif($ke == 'user_id' && !empty($vall))
					{
						$filterCond .= " AND tbl_domestic_booking.customer_id = '$vall'";
					}
					elseif($ke == 'from_date' && !empty($vall))
					{
						$filterCond .= " AND tbl_domestic_booking.booking_date >= '$vall'";
					}
					elseif($ke == 'to_date' && !empty($vall))
					{
						$filterCond .= " AND tbl_domestic_booking.booking_date <= '$vall'";
					}
					elseif($ke == 'courier_company' && !empty($vall) && $vall !="ALL")
					{
						$filterCond .= " AND tbl_domestic_booking.courier_company_id = '$vall'";
					}
					elseif($ke == 'mode_name' && !empty($vall) && $vall !="ALL")
					{
						$filterCond .= " AND tbl_domestic_booking.mode_dispatch = '$vall'";
					}
					
			  	}
			}
			if(!empty($searching))
			{
				$filterCond = urldecode($searching);
			}

	    
			if ($this->session->userdata("userType") == '1') 
			{
				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 $filterCond ");
				// $resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit ".$offset.",50");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking JOIN tbl_domestic_stock_history ON tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE tbl_domestic_booking.booking_type = 1  and tbl_domestic_stock_history.is_delivered = '0' and tbl_domestic_booking.is_delhivery_complete = '0' and tbl_domestic_stock_history.delivery_sheet = '0' order by tbl_domestic_booking.booking_id DESC ");
				
				// echo $this->db->last_query();die();
				// $download_query 		= "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method,tbl_domestic_weight_details.weight_details  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 $filterCond  GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC";

				$this->load->library('pagination');
			
				$data['total_count']			= $resActt->num_rows();
				$config['total_rows'] 			= $resActt->num_rows();
				$config['base_url'] 			= 'admin/view-domestic-shipment';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);
				
				$config['per_page'] 			= 50;
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
					$data['serial_no']				= 1;
				}
				else
				{
					$config['uri_segment'] 			= 3;
					$data['serial_no']		= $offset + 1;
				}
				
				
				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) 
				{
				
					$data['allpoddata'] 			= $resAct->result_array();
				}
				else
				{
					$data['allpoddata'] 			= array();
				}
			}
			else
			{
				//print_r($this->session->all_userdata());
				$branch_id = $this->session->userdata("branch_id");
				$where 		= '';
			    $query = $this->db->query("select branch_name from tbl_branch where branch_id = '$branch_id'")->row();
				$branch_name = $query->branch_name;
				$resActt = $this->db->query("SELECT * FROM tbl_domestic_booking  WHERE booking_type = 1 $filterCond ");
				$resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking JOIN tbl_domestic_stock_history ON tbl_domestic_stock_history.pod_no = tbl_domestic_booking.pod_no LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE tbl_domestic_booking.booking_type = 1 and tbl_domestic_stock_history.current_branch = '$branch_id' and tbl_domestic_stock_history.is_delivered = '0' and tbl_domestic_booking.is_delhivery_complete = '0' and tbl_domestic_stock_history.delivery_sheet = '0' order by tbl_domestic_booking.booking_id DESC ");
				// echo $this->db->last_query();die;
				// $download_query 		= "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method,tbl_domestic_weight_details.weight_details FROM tbl_domestic_booking JOIN tbl_domestic_booking ON tbl_domestic_tracking.pod_no = tbl_domestic_booking.pod_no LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 and tbl_domestic_tracking.status != 'In transit' and tbl_domestic_tracking.status !='Delivered' and tbl_domestic_tracking.branch_name = '$branch_name' GROUP BY tbl_domestic_tracking.pod_no order by tbl_domestic_tracking.id DESC ";
				
				$this->load->library('pagination');
			
				$data['total_count']			= $resActt->num_rows();
				$config['total_rows'] 			= $resActt->num_rows();
				$config['base_url'] 			= 'admin/view-branchwise-stock/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);
				
				$config['per_page'] 			= 50;
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
					$data['serial_no']				= 1;
				}
				else
				{
					$config['uri_segment'] 			= 3;
					$data['serial_no']		= $offset + 1;
				}
				
				
				$this->pagination->initialize($config);
				if(!empty($resAct) && $resAct->num_rows() > 0) 
				{
					$data['allpoddata']= $resAct->result_array();
				}
				else
				{
					$data['allpoddata']= array();
				}
			}
				
			if(isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report')
			{
				$resActtt 			= $this->db->query($download_query);
				$shipment_data		= $resActtt->result_array();
				$this->domestic_shipment_report($shipment_data);
			}
			
			$data['viewVerified'] = 2;
			$whr_c =array('company_type'=>'Domestic');
			$data['courier_company']= $this->basic_operation_m->get_all_result("courier_company",$whr_c);
			$data['mode_details']= $this->basic_operation_m->get_all_result("transfer_mode",'');
			$this->load->view('admin/branchwise_stock/view_branchwise_stock', $data);
		}		
        
	}


	public function domestic_shipment_report($shipment_data)
   	{    
	
		$date=date('d-m-Y');
		$filename = "SipmentDetails_".$date.".csv";
		$fp = fopen('php://output', 'w');
			
		$header =array("AWB No.","Sender","Receiver","Receiver City","Forwording No","Forworder Name","Booking date","Mode","Pay Mode","Amount","Weight","NOP","Invoice No","Invoice Amount","Branch Name","User","Eway No","Eway Expiry date","Per Box Pack","L","B","H","Valumetric Weight","Actual Weight","Chargeable Weight");

			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		fputcsv($fp, $header);
		$i =0;
		foreach($shipment_data as $row) 
		{
			$i++;

			$whr=array('transfer_mode_id'=>$row['mode_dispatch']);
            $mode_details = $this->basic_operation_m->get_table_row_array('transfer_mode',$whr);

            $whr_u =array('branch_id'=>$row['branch_id']);
            $branch_details = $this->basic_operation_m->get_table_row_array('tbl_branch', $whr_u);


            $whr_u =array('user_id'=>$row['user_id']);
            $user_details = $this->basic_operation_m->get_table_row_array('tbl_users', $whr_u);
            $user_details['username'] = substr($user_details['username'],0,20);
			//print_r(  $user_details['username']);


			
			$whr=array('id'=>$row['sender_city']);
			$sender_city_details = $this->basic_operation_m->get_table_row("city",$whr);
			$sender_city = @$sender_city_details->city;
			
			$whr_s=array('id'=>$row['reciever_state']);
			$reciever_state_details = $this->basic_operation_m->get_table_row("state",$whr_s);
			$reciever_state = @$reciever_state_details->state;
			
			$whr_p=array('id'=>$row['payment_method']);
			$payment_method_details = $this->basic_operation_m->get_table_row_array("payment_method",$whr_p);
			$payment_method = $payment_method_details['method'];


			$branch_details['branch_name'] = substr($branch_details['branch_name'],0,20);
			$roww=array(
				$row['pod_no'],
				$row['sender_name'],
				$row['reciever_name'],
				$row['city'],
				$row['forwording_no'],
				$row['forworder_name'],
				date('d-m-Y',strtotime($row['booking_date'])),
				$mode_details['mode_name'],
				$row['dispatch_details'],
				$row['grand_total'],
				$row['chargable_weight'],
				$row['no_of_pack'],
				$row['invoice_no'],
				$row['invoice_value'],
				$branch_details['branch_name'],
				$user_details['username'] 
			);
			
			
			fputcsv($fp, $roww);
			if($row['doc_type'] == 1)
			{
				$weight_details = json_decode($row['weight_details']);
				
				if(!empty($weight_details->per_box_weight_detail))
				{
					foreach($weight_details->per_box_weight_detail as $key => $values)
					{
						$weight_row = array("","","","","","","","","","","","","","","","","","",$values,$weight_details->length_detail[$key],$weight_details->breath_detail[$key],$weight_details->height_detail[$key],$weight_details->valumetric_weight_detail[$key],$weight_details->valumetric_actual_detail[$key],$weight_details->valumetric_chageable_detail[$key]);
						fputcsv($fp, $weight_row);
					}
				}
			}
			
		}
		exit;
   	}
}

?>
