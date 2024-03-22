<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_stock_manager extends CI_Controller{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('basic_operation_m');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
	public function index()
	{ 
        $data= array();	
		$data['allcountrydata']=$this->db->query("select * from tbl_awb_stock_manager where isdeleted = '0'")->result();
         $this->load->view('admin/stock_manager/view_stock_manager',$data);
	}
	
	public function add_stock()
	{
		$data['message']="";
		if (!empty($_POST['submit'])) 
		{  
			//  print_r($_SESSION['userId']);die;
			$r= array(
				'create_date' => date('Y-m-d H:i:s'),
				'series_form' => $this->input->post('series_form'), 
				'series_to' => $this->input->post('series_to'), 
				'awbs_limits' => $this->input->post('awbs'), 
				'total_awbs' => $this->input->post('awbs'), 
				'mode' => $this->input->post('mode'), 
				'user_id' => $_SESSION['userId'], 
                 );
			
			
			if ($this->basic_operation_m->insert('tbl_awb_stock_manager',$r)) {
				
				// echo 1;
				echo json_encode(1);	
				exit();
			}else{
               
				echo json_encode(0);
				exit();
			}
			$this->session->set_userdata($r);
            
		}
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$data['series_to'] = $this->db->query("select series_to from tbl_awb_stock_manager where isdeleted = '0' order by id desc limit 1")->row();
	    $this->load->view('admin/stock_manager/view_add_stock_manager',$data);
	}
	
	public function get_stock_value()
    {
       $mode = $this->input->post('mode'); 		
		$res1 = $this->db->query("select * from tbl_awb_stock_manager where isdeleted = '0' order by id desc limit 1")->row();	
		if (!$res1) {
			$res1['awbs'] = 0;
		}
		
		echo json_encode($res1);
    }
	
	public function update_stock($id)
	{
		$data['message']="";       
		if($id!="")
		{
			$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		    $whr =array('id'=>$id);
			$data['value']= $this->basic_operation_m->get_table_row('tbl_awb_stock_manager',$whr);
			
		}
		if (isset($_POST['submit'])) {
	        $whr =array('id'=>$id);
			$r= array(
				'series_form' => $this->input->post('series_form'), 
				'series_to' => $this->input->post('series_to'), 
				'awbs_limits' => $this->input->post('awbs'), 
				'mode' => $this->input->post('mode'), 
                 );
			$result=$this->basic_operation_m->update('tbl_awb_stock_manager',$r, $whr);
			if ($this->db->affected_rows() > 0) {
				$data['message']="AWB Updated Sucessfully";
			}else{
                $data['message']="Error in Query";
			}
            redirect('admin/stock-manager');
		}
	    $this->load->view('admin/stock_manager/view_edit_stock_manager',$data);
	}

	public function download_stock_manager_report(){
		
		$date=date('d-m-Y');
		$filename = "Mis_report_".$date.".csv";
		$fp = fopen('php://output', 'w');
			$header =array(
				"SrNo",
				"Stock Entry Date",
				"Series From",
				"Series To",
				"Total Stock",
				"Mode",
				"Utilized",
				"Available"
			);
		$data = $this->db->get_where('tbl_awb_stock_manager',['isdeleted' => 0])->result();
			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
         
		fputcsv($fp, $header);
		$i =1;
		foreach($data as $v) 
		{
			$utilized = $v->total_awbs - $v->awbs_limits;
			$mode_name = $this->db->get_where('transfer_mode',['transfer_mode_id' =>$v->mode])->row();
			$row = array(
				$i,
				date('d-m-Y', strtotime($v->create_date)),
				$v->series_form,
				$v->series_to,
				$v->total_awbs,
				$mode_name->mode_name,
				$utilized,
				$v->awbs_limits,
			);
			$i++;
			fputcsv($fp, $row);
		}
		exit;
   	}

	public function delete_stock()
	{
	  $id = $this->input->post('getid');
	  
		if($id!="")
		{
		    $whr =array('id'=>$id);
            $r = array('isdeleted' =>1);
			$res=$this->basic_operation_m->update('tbl_awb_stock_manager',$r ,$whr);
			
           	$output['status'] = 'success';
			$output['message'] = 'Data deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Data';
		}
 
		echo json_encode($output);	
	  
	}
}

?>