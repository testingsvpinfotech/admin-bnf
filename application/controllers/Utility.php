<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->model('basic_operation_m');
    }

    // ============= SERVICE PINCODE UTILITY START ==============
    public function service_pincode_utility(){
    	$this->load->view('admin/utility/import_service_pincode');
    }

    public function import_service_pin(){
		$data = [];
		$user_id = $this->session->userdata("userId");
		
		$extension = pathinfo($_FILES['serv_pin']['name'], PATHINFO_EXTENSION);
		if($extension!="csv")
		{	
			$msg			= 'Please uploade csv file.';
			$class			= 'alert alert-danger alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
		}else{
			$file = fopen($_FILES['serv_pin']['tmp_name'],"r");
			$heading_array = array();
			$cnt = 0;
			
			while(!feof($file))
			{
				$data	= fgetcsv($file);
				if(!empty($data))
				{
				 	if($cnt>0)
				  	{
				  		$branch = $this->db->from('tbl_branch')->where(['branch_name' => $data[2]])->or_where(['branch_name' => $data[2].' VHYD'])->get()->row();
				  		$km = str_replace([' ','km'], '', $data[1]);
						$allData = array(
							'branch_id' => $branch->branch_id,
							'km' => $km
						);
						$this->db->update('tbl_branch_service',$allData, ['pincode' => $data[0]]);
					} //==end already exist condition
					$cnt++;			
				}
				
				$data123['msg']   = 'File uploaded successfully..';
				$data123['class'] = 'alert alert-success alert-dismissible';
				echo json_encode($data123);
			}		
			exit();
			redirect('admin/view-add-domestic-rate');
		}
  	}
    // ============= SERVICE PINCODE UTILITY END ==============
    
    // ============= LOG HISTORY UTILITY START ==============
    public function loghistory(){
    	$this->load->view('admin/utility/loghistory_backup');
    }

    public function download_log_backup(){
    	$data = $this->input->post();
    	$from_date = $data['from_date'];
    	$to_date = $data['to_date'];
    	$to_date = date('Y-m-d', strtotime($to_date . ' +1 day'));
    	$logData =  $this->db->query('SELECT log.*, u.username, u.full_name FROM tbl_loghistory log LEFT JOIN tbl_users u ON(u.user_id = log.userId) WHERE log.date >= "'.$from_date.'" AND log.date <= "'.$to_date.'"')->result();

    	if(isset($data['submit']) && $data['submit'] == 'download'){
    		$this->load->library('excel');
	        $objPHPExcel = new PHPExcel();
	        $objPHPExcel->setActiveSheetIndex(0);
	         	// set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'User Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Method');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Activity');
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Data');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine IP');
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Browser');
	        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Date');

	        $rows = 2;
	        foreach ($logData as $val){
	        	$full_name = !empty($val->full_name)?$val->full_name:'';
	        	$method = !empty($val->method)?$val->method:'';
	        	$sub_method = !empty($val->sub_method)?$val->sub_method:'';
	        	$updatedData = !empty($val->updatedData)?$val->updatedData:'';
	        	$machineIp = !empty($val->machineIp)?$val->machineIp:'';
	        	$userAgent = !empty($val->userAgent)?$val->userAgent:'';
	        	$date = !empty($val->date)?date('d-m-Y H:i:s', strtotime($val->date)):'';
	        	
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $full_name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $method);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $sub_method);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $updatedData);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $machineIp);
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rows, $userAgent);
		        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rows, $date);
	            
	            $rows++;
	        } 
	        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	  	
	  		header('Content-Type: application/vnd.ms-excel');
	  		header('Content-Disposition: attachment;filename="LogHistory.xls"');
	  		$object_writer->save('php://output');

		}else if(isset($data['submit']) && $data['submit'] == 'delete'){
			$this->load->library('excel');
	        $objPHPExcel = new PHPExcel();
	        $objPHPExcel->setActiveSheetIndex(0);
	         	// set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'User Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Method');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Activity');
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Data');
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Machine IP');
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Browser');
	        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Date');

	        $rows = 2;
	        foreach ($logData as $val){
	        	$full_name = !empty($val->full_name)?$val->full_name:'';
	        	$method = !empty($val->method)?$val->method:'';
	        	$sub_method = !empty($val->sub_method)?$val->sub_method:'';
	        	$updatedData = !empty($val->updatedData)?$val->updatedData:'';
	        	$machineIp = !empty($val->machineIp)?$val->machineIp:'';
	        	$userAgent = !empty($val->userAgent)?$val->userAgent:'';
	        	$date = !empty($val->date)?date('d-m-Y H:i:s', strtotime($val->date)):'';
	        	
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $full_name);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $method);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $sub_method);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $updatedData);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $machineIp);
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rows, $userAgent);
		        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rows, $date);
	            
	            $rows++;
	        }

			$object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$a = 'Log' . date("Y-m-d") . '.csv';
       		$object_writer->save(FCPATH . '/LogReport/' . $a);
       		redirect(base_url().'utility/loghistory');
		}
    }
    // ============= LOG HISTORY UTILITY END ==============
    // ============= MENU ACCESS UTILITY START ============
    public function menu_access_utility(){
		$this->load->view('admin/utility/import_menu_access');		
	}
	public function menu_access_import(){
		$data = [];

		$extension = pathinfo($_FILES['menu_file']['name'], PATHINFO_EXTENSION);
		if($extension!="csv")
		{	
			$msg			= 'Please uploade csv file.';
			$class			= 'alert alert-danger alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
		}else{
			$file = fopen($_FILES['menu_file']['tmp_name'],"r");
			$heading_array = array();
			$cnt = 0;
			
			while(!feof($file))
			{
				$data	= fgetcsv($file);
				if(!empty($data))
				{
				 	if($cnt>0)
				  	{
						$udata = $this->db->query("SELECT * FROM tbl_users WHERE username LIKE '".trim($data[0])."'")->row();
						$clone_user = $this->db->select('u.user_id,u.username,u.branch_id,u.full_name,u.user_type, ma.*')->from('tbl_users u')
    						->join('menu_allotment ma','ma.user_id = u.user_id', 'left')
    						->where(['u.username' => $data[1]])->get()->result_array();

							foreach ($clone_user as $key => $value) {
								$allData = array(
									'user_id' => $udata->user_id,
									'am_id' => $value['am_id']
								);
								$this->db->insert('menu_allotment',$allData);
							}
					} //==end already exist condition
					$cnt++;			
				}
				$data123[] = $data;
				// echo json_encode($data123);
			}
			$this->basic_operation_m->addLog($this->session->userdata("userId"),'utility','Add Bulk Menu Access', $data123);	
			exit();
			// redirect('admin/view-add-domestic-rate');
		}
    }
    // ============= MENU ACCESS UTILITY END ==============
    // =======================================

    public function docket_tracking_data(){
    	$docket = $this->db->query("SELECT * FROM tbl_domestic_tracking WHERE status = 'Delivered' ORDER BY id DESC")->result();
    	foreach ($docket as $key => $value) {
    		$id = $value->id;
    		$pod_no = $value->pod_no;
    		// $docket1 = $this->db->query("SELECT * FROM tbl_domestic_tracking WHERE pod_no = $pod_no")->result();

    		echo "<pre>"; print_r($value); 
    	}
    	die;
    }
    // =======================================
}