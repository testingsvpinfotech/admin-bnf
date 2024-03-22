<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_coloder_report extends CI_Controller {

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
    public function coloader_report($offset=0,$searching='')
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
			ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
			
			if($userType !=  '1' AND $userType !=  '20'AND $userType !=  '22'AND $userType !=  '23')
			{
				$whr_d 	=	"tbl_domestic_menifiest.source_branch = '$branch_name'";
			}
			else
			{
				$whr 	=	'1';
				$whr_d 	=	'1';
			}
			
			
			
			$cd_no = $all_data['cd_no'];
			if($cd_no!="")
			{
				$whr_d	.=	" AND  tbl_domestic_menifiest.cd_no='$cd_no'";  				
			}
			
			$awb_no = $all_data['awb_no'];
			if($awb_no!="")
			{
				$whr_d	.=	" AND  tbl_domestic_menifiest.manifiest_id='$awb_no'";  				
			}		
			
			
			$from_date 	= $all_data['from_date'];
			$to_date 	= $all_data['to_date'];	
			if($from_date!="" && $to_date!="")
			{
			    $from_date	 	 = date("Y-m-d",strtotime($all_data['from_date']));
			    $to_date 		 = date("Y-m-d",strtotime($all_data['to_date']));	
				$whr			.=" AND  date(date_added) >='$from_date' AND date(date_added) <='$to_date'";
				$whr_d			.=" AND  date(date_added) >='$from_date' AND date(date_added) <='$to_date'";
			}
			
	
		
	            //  print_r($whr_d);die;
			    // $data['domestic_allpoddata'] 			= $this->Generate_pod_model->get_domestic_tracking_data($whr_d,"100",$offset);
			    $data['domestic_allpoddata'] 			= $this->db->query("select * from tbl_domestic_menifiest where $whr_d group by manifiest_id order by id desc limit 100")->result_array();
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
		$config['base_url'] 			= 'admin/list-coloader-report/';
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
		
	
		$this->load->view('admin/coloader_master/view_coloder_report',$data);
	}

	

	public function tot_cnt_d($whrAct){
		$this->db->select('count(*) as cnt');
		$this->db->from('tbl_domestic_menifiest');
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
			"Sr No",
	       	"Manifest ID",
	       	"CD No",
	       	"Coloader Name",
	       	"Coloader Contact No",
	       	"Origin",
	       	"Destination",
	       	"CD Created Date & Time",
	       	"CD Created By",
	       	"CD Status",
	       	"Driver Name",
	       	"Driver Contact No",
	       	"Vehical No",
	       	"Total Weight",
	       	"Total Packet",	       
			"Manifested Date"

		);
		
	   
		
		// $domestic_allpoddata 				= $this->Generate_pod_model->get_domestic_tracking_data($where_d,"",""); 
		$domestic_allpoddata			= $this->db->query("select * from tbl_domestic_menifiest where $where_d group by manifiest_id order by id desc")->result_array();

			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
         
		fputcsv($fp, $header);
		$i =1;
		// echo '<pre>';print_r($domestic_allpoddata);die;
		foreach($domestic_allpoddata as $value_d) 
		{

			if($value_d['cd_status']=='1'){$status =  'Received';}else{ $status = 'Pending';}
			 
			$row = array(
				$i,
				$value_d['manifiest_id'],
				$value_d['cd_no'],
				$value_d['coloader'],
				$value_d['coloder_contact'],
				$value_d['source_branch'],
				$value_d['destination_branch'],
				$value_d['cd_no_edited_date'],
				$value_d['cd_no_edited_by'],
				$status,
				$value_d['driver_name'],
				$value_d['contact_no'],
				$value_d['lorry_no'],
				$value_d['total_weight'],
				$value_d['total_pcs'],		
				
				@$value_d['date_added']
			);			  
			$i++;
			fputcsv($fp, $row);
		}
		exit;
   	}

		
	
}



?>
