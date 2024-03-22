<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_fuel extends CI_Controller {

	var $data 			= array();
	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}

	}
	
	
	###################### View All Airlines Start ########################
	public function all_fuel()
	{  
	   
		$data 							= $this->data;
		$user_id						= $this->session->userdata("userId");
		$data['fule_company']			= $this->basic_operation_m->get_query_result("select *,courier_fuel.company_type from courier_fuel left join courier_company on courier_company.c_id = courier_fuel.courier_id left join tbl_customers on tbl_customers.customer_id = courier_fuel.customer_id");
        $this->load->view('admin/fuel_master/view_fuel',$data);
      
	}
	
	public function addfuel()
	{  
	   
		$data 						= $this->data;
		$data['courier_company']	= $this->basic_operation_m->get_all_result("courier_company","","c_company_name asc");
		
		$data['all_customer']		= $this->basic_operation_m->get_all_result("tbl_customers",['isdeleted'=>0],"customer_name asc");
		// echo $this->db->last_query();die;
	//  echo '<pre>';	print_r($data['all_customer']);die;
		$user_id					= $this->session->userdata("userId");
        $this->load->view('admin/fuel_master/view_add_fuel',$data);
      
	}
	
	public function insertfuel()
	{  
	   
		$alldata 							= $this->input->post();
		$n_data 							= $alldata;
		unset($n_data['cod_range_from']);
		unset($n_data['cod_range_to']);
		unset($n_data['cod_range_rate']);
		unset($n_data['topay_range_from']);
		unset($n_data['topay_range_to']);
		unset($n_data['topay_range_rate']);
		
		$cf_id				= $this->basic_operation_m->insert("courier_fuel",$n_data);
		$this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Add Fuel Master', $n_data);

		if(!empty($alldata))
		{
			if(!empty($alldata['cod_range_from']) )
			{
				foreach($alldata['cod_range_from'] as $key => $values)
				{
					$this->basic_operation_m->insert("courier_fuel_detail",array('cf_id'=>$cf_id,'cod_range_from'=>$alldata['cod_range_from'][$key],'cod_range_to'=>$alldata['cod_range_to'][$key],'cod_range_rate'=>$alldata['cod_range_rate'][$key]));
				}
			}
			
			if(!empty($alldata['topay_range_from']))
			{
				foreach($alldata['topay_range_from'] as $key => $values)
				{
					$this->basic_operation_m->insert("courier_fuel_detail",array('cf_id'=>$cf_id,'topay_range_from'=>$alldata['topay_range_from'][$key],'topay_range_to'=>$alldata['topay_range_to'][$key],'topay_range_rate'=>$alldata['topay_range_rate'][$key]));
				}
			}
			
			$msg					= 'Fuel uploaded successfully';
			$class					= 'alert alert-success alert-dismissible';	
			
		}
		else
		{
			$msg			= 'Fuel not uploaded successfully';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/all-fuel');
	}
	
	public function deletefuel()
	{  
	    $id = $this->input->post('getid');
	    $this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Delete Fuel Master', $id);
		if(!empty($id))
		{
			$airlines_company		= $this->basic_operation_m->delete("courier_fuel","cf_id = '$id'");
			$airlines_company		= $this->basic_operation_m->delete("courier_fuel_detail","cf_id = '$id'");

			$output['status'] = 'success';
			$output['message'] = 'Fule deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Fule';
		}
 
		echo json_encode($output);	
	}
	
// 	public function deletefuel()
// 	{  
// 	     $id = $this->input->post('getid');
// 		if(!empty($id))
// 		{
// 			$airlines_company		= $this->basic_operation_m->delete("courier_fuel","cf_id = '$id'");
// 			$airlines_company		= $this->basic_operation_m->delete("courier_fuel_detail","cf_id = '$id'");
// 			$msg					= 'Fuel deleted successfully';
// 			$class					= 'alert alert-success alert-dismissible';	
			
// 		}
// 		else
// 		{
// 			$msg			= 'Fuel not deleted successfully';
// 			$class			= 'alert alert-danger alert-dismissible';	
			
// 		}
		
// 		$this->session->set_flashdata('notify',$msg);
// 		$this->session->set_flashdata('class',$class);
		
// 		redirect('admin/all-fuel');
// 	}

	
	public function editfuel($id)
	{  
		$data				 				= $this->data;
		if(!empty($id))
		{
			$data['courier_company']	= $this->basic_operation_m->get_all_result("courier_company","");
			$data['fuel_list']		= $this->basic_operation_m->get_query_row("select * from courier_fuel  where courier_fuel.cf_id = '$id'");
			$data['fuel_detail']		= $this->basic_operation_m->get_query_result("select * from courier_fuel_detail  where cf_id = '$id'");
			$data['all_customer']		= $this->basic_operation_m->get_all_result("tbl_customers","");
			
		}
		$this->load->view('admin/fuel_master/view_edit_fuel',$data);
	}
	
	public function updatefuel($id)
	{  
		$alldata 							= $this->input->post();
		$n_data 							= $alldata;
		unset($n_data['cod_range_from']);
		unset($n_data['cod_range_to']);
		unset($n_data['cod_range_rate']);
		unset($n_data['topay_range_from']);
		unset($n_data['topay_range_to']);
		unset($n_data['topay_range_rate']);
		
		$this->basic_operation_m->addLog($this->session->userdata("userId"),'master','Update Fuel Master', $n_data);
		if(!empty($alldata))
		{
			$status							= $this->basic_operation_m->update("courier_fuel",$n_data,"cf_id = '$id'");
		
			$airlines_company				= $this->basic_operation_m->delete("courier_fuel_detail","cf_id = '$id'");
			if(!empty($alldata['cod_range_from']) )
			{
				foreach($alldata['cod_range_from'] as $key => $values)
				{
					$this->basic_operation_m->insert("courier_fuel_detail",array('cf_id'=>$id,'cod_range_from'=>$alldata['cod_range_from'][$key],'cod_range_to'=>$alldata['cod_range_to'][$key],'cod_range_rate'=>$alldata['cod_range_rate'][$key]));
				}
			}
			
			if(!empty($alldata['topay_range_from']))
			{
				foreach($alldata['topay_range_from'] as $key => $values)
				{
					$this->basic_operation_m->insert("courier_fuel_detail",array('cf_id'=>$id,'topay_range_from'=>$alldata['topay_range_from'][$key],'topay_range_to'=>$alldata['topay_range_to'][$key],'topay_range_rate'=>$alldata['topay_range_rate'][$key]));
				}
			}
			
			$msg							= 'Fuel updated successfully';
			$class							= 'alert alert-success alert-dismissible';	
			
		}
		else
		{
			$msg			= 'Fuel not updated successfully';
			$class			= 'alert alert-danger alert-dismissible';	
			
		}
		$this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/all-fuel');
	
	}
	
	###################### View All Airlines End ########################	
	// EXPORT FUEL

	public function export_fuel(){

		$data 							= $this->data;
		$user_id						= $this->session->userdata("userId");
		// $data['all_customer']		= $this->basic_operation_m->get_all_result("tbl_customers","","customer_name asc");
		$data['all_customer'] = $this->db->query("SELECT cf.customer_id, cust.cid, cust.customer_name FROM courier_fuel cf 
				LEFT JOIN tbl_customers cust ON(cust.customer_id = cf.customer_id)
				GROUP BY customer_id
			")->result_array();
		// print_r($data['all_customer']); die;

		if (!empty($_GET['customer_id']) || !empty($_GET['status'])) {
			$filter= '';
			$status = $_GET['status']; //1 : Active, 0:Expired
			$customer_id = $_GET['customer_id']; 
			if($status == 1){
				$filter .= " AND cf.fuel_to > CURDATE()";
			}else{
				$filter .= " AND cf.fuel_to < CURDATE()";
			}

			if(!empty($customer_id)){
				$filter .= " AND cf.customer_id = ".$customer_id;
			}
			$fuelData = $this->db->query("SELECT cf.*, cust.cid, cust.customer_name, cc.c_company_name FROM courier_fuel cf 
				LEFT JOIN tbl_customers cust ON(cust.customer_id = cf.customer_id)
				LEFT JOIN courier_company cc ON(cc.c_id = cf.courier_id)
				WHERE 1 $filter
			")->result();
			if(empty($fuelData)){
				$msg							= 'No Fuel Data Found';
				$class							= 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify',$msg);
				$this->session->set_flashdata('class',$class);

				redirect('admin_fuel/export_fuel');
			}else{
				$this->load->library('excel');
	        	$objPHPExcel = new PHPExcel();
	        	$objPHPExcel->setActiveSheetIndex(0);

	         	// set Header
		        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Customer Name');
		        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Customer Code');
		        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Fuel Courier');
		        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Fuel Price');
		        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Company Type');
		        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Docket Charges');
		        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Min Fov');
		        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Fov Above');
		        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Fov Below');
		        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Fov Base');
		        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Appointment Min');
		        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Appointment Per KG');
		        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'CFT');
		        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Air CFT');
		        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Fuel Charges On');
		        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'COD Fixed');
		        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'ToPay Fixed');
		        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'From Date');
		        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'To Date');

		        $rows = 2;
		        foreach ($fuelData as $val){
		        	$customer_name = !empty($val->customer_name)?$val->customer_name:'';
		        	$cid = !empty($val->cid)?$val->cid:'';
		        	$c_company_name = !empty($val->c_company_name)?$val->c_company_name:'SELF';
		        	$fuel_price = !empty($val->fuel_price)?$val->fuel_price:'';
		        	$company_type = !empty($val->company_type)?$val->company_type:'';
		        	$docket_charge = !empty($val->docket_charge)?$val->docket_charge:'';
		        	$fov_min = !empty($val->fov_min)?$val->fov_min:'';
		        	$fov_above = !empty($val->fov_above)?$val->fov_above:'';
		        	$fov_below = !empty($val->fov_below)?$val->fov_below:'';
		        	$fov_base = !empty($val->fov_base)?$val->fov_base:'';
		        	$appointment_min = !empty($val->appointment_min)?$val->appointment_min:'';
		        	$appointment_perkg = !empty($val->appointment_perkg)?$val->appointment_perkg:'';
		        	$cft = !empty($val->cft)?$val->cft:'';
		        	$air_cft = !empty($val->air_cft)?$val->air_cft:'';
		        	$fc_type = !empty($val->fc_type)?$val->fc_type:'';
		        	$cod = !empty($val->cod)?$val->cod:'';
		        	$to_pay_charges = !empty($val->to_pay_charges)?$val->to_pay_charges:'';
		        	$fuel_from = !empty($val->fuel_from)?date('d-m-Y', strtotime($val->fuel_from)):'';
		        	$fuel_to = !empty($val->fuel_to)?date('d-m-Y', strtotime($val->fuel_to)):'';

		            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $customer_name);
		            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $cid);
		            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $c_company_name);
		            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $fuel_price);
		            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $company_type);
		            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rows, $docket_charge);
			        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rows, $fov_min);
			        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rows, $fov_above);
			        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rows, $fov_below);
			        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rows, $fov_base);
			        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rows, $appointment_min);
			        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rows, $appointment_perkg);
			        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rows, $cft);
			        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rows, $air_cft);
			        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rows, $fc_type);
			        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rows, $cod);
			        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rows, $to_pay_charges);
			        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rows, $fuel_from);
			        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rows, $fuel_to);
		            
		            $rows++;
		        } 
		        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		  		header('Content-Type: application/vnd.ms-excel');
		  		header('Content-Disposition: attachment;filename="Fuel Data.xls"');
		  		$object_writer->save('php://output');

		  		redirect('admin/all-fuel');
			}
				

		}else{
			$this->load->view('admin/fuel_master/export_fuel',$data);	
		}
        
	}
	
   // ==============================================================
}
?>
