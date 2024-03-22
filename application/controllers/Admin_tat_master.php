<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
class Admin_tat_master extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$this->load->model('basic_operation_m');
		$this->load->model('booking_model');	
		$this->load->model('Invoice_model');
		//echo __DIR__;exit;
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}	
	}
	
	public function view_upload_tat()
	{
		$this->load->view('admin/tat_master/view_upload_tat');
	}
	public function view_tat_master($offset=0,$searching2='')
	{    $data = [];
		// print_r($_POST['key']);die;
		ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
		if(!empty($_POST['from'])){
			$filterCond = "(tbl_tat_master.tat_from = '".$_POST['from']."'
			and tbl_tat_master.tat_to ='".$_POST['to']."')";
			$resAct = $this->db->query("select tat_from,tat_to,created_at,tat,transfer_mode.mode_name as mode_name from tbl_tat_master left join transfer_mode on transfer_mode.transfer_mode_id  = tbl_tat_master.mode where $filterCond order by tbl_tat_master.t_id desc limit ".$offset.",100");
		}else{
			$filterCond = "1";
			$resAct = $this->db->query("select tat_from,tat_to,created_at,tat,transfer_mode.mode_name as mode_name from tbl_tat_master left join transfer_mode on transfer_mode.transfer_mode_id  = tbl_tat_master.mode where $filterCond order by tbl_tat_master.t_id desc limit ".$offset.",100");
		}

		          $resActt = $this->db->query("select * from tbl_tat_master left join transfer_mode on transfer_mode.transfer_mode_id  = tbl_tat_master.mode where  $filterCond ");
			
		
				
				$this->load->library('pagination');
			
				$data['total_count']			= $resActt->num_rows();
				$config['total_rows'] 			= $resActt->num_rows();
				$config['base_url'] 			= 'admin/view-tat-master/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);
				
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
				
					$data['tat_master']			= $resAct->result_array();
				}
				else
				{
					$data['tat_master']			= array();
				}


		$this->load->view('admin/tat_master/view_tat_master',$data);
	}

	public function upload_tat(){
        // print_r($_FILES);die;
		if(isset($_POST['submit'])){
			$file1 = $_FILES['uploadFile'];
	  		if(!empty($file1)){
	  			$file = fopen($_FILES['uploadFile']['tmp_name'],"r");
				$cnt = 0;
				
				while(!feof($file))
				{
					$data	= fgetcsv($file);
					
					if(!empty($data))
					{
						if ($cnt==0) {
							foreach ($data as $key => $value) {
								if ($key!=0) {
									$toData[] = $value;
								}
							}
						}
					 	if($cnt>0)
					  	{
							$fromstate = $data[0];
							foreach ($data as $key => $value) {
								if ($data[$key+1]!=0) {
										$alldata = array(
											'tat_from' => !empty($fromstate)?$fromstate:'',
											'tat_to'	=> !empty($toData[$key])?$toData[$key]:'',
											'tat' => !empty($data[$key+1])?$data[$key+1]:'',
											'created_at' => date('Y-m-d H:i:s'),
											'created_by' => $this->session->userdata('userId')
										);
									$this->db->insert('tbl_tat_master', $alldata);
									}
							}
						} //==end already exist condition
						$cnt++;			
					}
				}	
	  		}
		}
	}

	public function upload_tat_for_city(){
        // print_r($_FILES);die;
		if(isset($_POST['submit'])){
			$file1 = $_FILES['uploadFile'];
	  		if(!empty($file1)){
	  			$file = fopen($_FILES['uploadFile']['tmp_name'],"r");
				$cnt = 0;
				
				while(!feof($file))
				{
					$data	= fgetcsv($file);
					
					if(!empty($data))
					{
						if ($cnt==0) {
							foreach ($data as $key => $value) {
								if ($key!=0) {
									if(substr($value,0,7) == "REST OF"){
										$state_name = str_replace("REST OF ","",$value);
										$state_id = $this->db->get_where('state',['state' => $state_name])->row('id');
										$tostate[] = $state_id;
									}else{
										$cid = str_replace(' / ',',',$value);
										$tocity[] = $cid;
									}
								}							
							}
						}
						// echo "<pre>"; print_r($tostate);
					 	if($cnt>0)
					  	{	
							if(substr($value,0,7) == "REST OF"){
								$fstate_name = str_replace("REST OF ","",$value);
								$fstate_id = $this->db->get_where('state',['state' => $fstate_name])->row('id');
								$fromstate = $fstate_id;
							}else{
								$fcid = str_replace(' / ',',',$value);
								$fromcity = $fcid;
							}
							foreach ($data as $key => $value) {
									if($data[$key+1] != 0){
										$alldata = array(
											'from_city' => !empty($data[0])?$data[0]:'',
											'to_city'	=> !empty($tocity[$key])?$tocity[$key]:'',
											'tat' => !empty($data[$key+1])?$data[$key+1]:'',
											'created_at' => date('Y-m-d H:i:s'),
											'mode' => $_POST['mode'],
											'created_by' => $this->session->userdata('userId')
										);
									$this->db->insert('tbl_tat_master', $alldata);
									}
							}
						} //==end already exist condition
						$cnt++;			
					}
				}	
	  		}
		}
	}
}

?>
