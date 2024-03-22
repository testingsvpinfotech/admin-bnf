<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_stock_allowtment extends CI_Controller {

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
		// print_r($this->session->userdata()); die;	
        $data= array();		
		$resAct	= $this->db->query("select *,transfer_mode.mode_name,tbl_branch.branch_name ,tbl_customers.customer_name,tbl_customers.customer_id from tbl_branch_assign_cnode join transfer_mode on transfer_mode.transfer_mode_id = tbl_branch_assign_cnode.mode left join tbl_branch on tbl_branch.branch_id = tbl_branch_assign_cnode.branch_id left join tbl_customers on tbl_customers.customer_id = tbl_branch_assign_cnode.customer_id order by id desc");		
		if($resAct->num_rows()>0)
		{
		 	$data['allvendor']=$resAct->result_array();	            
        }
        $this->load->view('admin/stock_allowtment/view_stock_allowtment',$data);       
	}
	
	public function add_stock_allowtment()
	{
		$data['message']				= "";
		$array['airway_no_from'] 		= array();
		$array['airway_no_to'] 			= array();
		$array['branch_code'] 			= array();
		$userid = $this->session->userdata('userId');
		
		if(isset($_POST['submit']))
        {
            $all_data = $this->input->post();
			// print_r($all_data);die;
			$this->load->library('form_validation');
            $this->form_validation->set_rules('mode', 'mode', 'required');
            $this->form_validation->set_rules('series_form', 'Series Form', 'required');
            $this->form_validation->set_rules('series_to', 'Series To', 'required');
            $this->form_validation->set_rules('awb_qty', 'Qty', 'required');
				// unset($all_data['submit']);
				if ($this->form_validation->run() == FALSE)
                {
					$msg = 'Mode Series Qty are Required';
					$class = 'alert alert-danger alert-dismissible';
					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
					redirect('admin/add-stock-allowtment');
				}else{
          		if(!empty($all_data)){
					$r = array(
	                'franchise_id'=>$this->input->post('franchise'),
	                'stock_manager'=>$this->input->post('stock_manager'),
	                'series_from'=>$this->input->post('series_from'),
	                'series_to'=>$this->input->post('series_to'),
					);
			 	}

			 	$stock_manager = $this->input->post('awb_qty');
			
				$whr = array('id'=>$this->input->post('stock_manager'));
				$whr2 = array('customer_id'=>$this->input->post('franchise'));

				$upval = array('to_assign'=>$this->input->post('franchise'),'status'=>'1');
				$mode = $this->input->post('mode');
				$data['stock_manager'] = $this->db->query("select * from tbl_awb_stock_manager  where mode = '$mode' and isdeleted = '0'")->result_array();

				$mode = $this->input->post('mode');
				$r = array(
					'assigned_date' => date('Y-m-d H:i:s'),
					'assigned_by' => $userid,
					'branch_id'=>$this->input->post('franchise'),
					'mode'=>$mode,
					'seriess_from'=>$this->input->post('series_form'),
					'seriess_to'=>$this->input->post('series_to'),
					'stock_manager'=>'',
					'qty'=>$this->input->post('awb_qty')
					);
				$result=$this->basic_operation_m->insert('tbl_branch_assign_cnode',$r); //echo $this->db->last_query()

				foreach($data['stock_manager'] as $key => $value){
					
					if ($stock_manager > 0) {
						$updateValue =$value['awbs_limits'];
					
						if($value['awbs_limits'] > $stock_manager){
							$updateValue = $value['awbs_limits'] - $stock_manager;
						
							$r = array(
			                'branch_id'=>$this->input->post('franchise'),
			                'stock_manager'=>$value['id'],
			                'qty'=>$stock_manager,
							);
							$stock_manager = 0;
						
						}else{
							$stock_manager =   $stock_manager - $value['awbs_limits'];
							$updateValue = 0;
						} 
						
						$this->basic_operation_m->update('tbl_awb_stock_manager',array('awbs_limits'=>$updateValue),array('id'=> $value['id']));
				
					}
			}
				// exit();
				// $this->basic_operation_m->update('tbl_awb_stock_manager',$upval,$whr);
				// $upval2 = array('cnode_allotment'=>'1');
				// $this->basic_operation_m->update('tbl_customers',$upval2,$whr2);
				redirect('admin/stock-allowtment');
		}
	}
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$data['branch'] = $this->db->query("select * from tbl_branch")->result();
		
		$this->load->view('admin/stock_allowtment/add_stock_allowtment',$data);
	}

	// public function download_stock_alloted_report(){
		
	// 	$date=date('d-m-Y');
	// 	$filename = "Mis_report_".$date.".csv";
	// 	$fp = fopen('php://output', 'w');
	// 		$header =array(
	// 			"SrNo",
	// 			"Stock Allotment Date",
	// 			"Series From",
	// 			"Series To",
	// 			"Total Stock",
	// 			"Branch or Franchisee"
	// 			"Mode",
	// 			"Utilized",
	// 			"Available",
	// 			"Alloted By"
	// 		);
	// 	$data = $this->db->get('tbl_branch_assign_cnode')->result();
	// 	header('Content-type: application/csv');
	// 	header('Content-Disposition: attachment; filename='.$filename);
         
	// 	fputcsv($fp, $header);
	// 	$i =1;
	// 	foreach($data as $v) 
	// 	{

	// 		$utilized = 0;
	// 		$available = 0;
	// 		$mode_name = $this->db->get_where('transfer_mode',['transfer_mode_id' =>$v->mode])->row();
	// 		$uname = '';
	// 		if(!empty($value['assigned_by'])){ $uname = $this->db->get_where('tbl_users',['user_id' => $v->assigned_by])->row('username'); }
	// 		$row = array(
	// 			$i,
	// 			date('d-m-Y', strtotime($v->assigned_date)),
	// 			$v->seriess_from,
	// 			$v->seriess_to,
	// 			$v->qty,
	// 			'',
	// 			$mode_name->mode_name,
	// 			$utilized,
	// 			$available,
	// 			$uname,
	// 		);
	// 		$i++;
	// 		fputcsv($fp, $row);
	// 	}
	// 	exit;
 //   	}

	public function add_franchise_stock_allowtment()
	{      
       
		$data['message']				= "";
		$array['airway_no_from'] 		= array();
		$array['airway_no_to'] 			= array();
		$array['branch_code'] 			= array();

		
		if(isset($_POST['submit']))
        {
            $all_data = $this->input->post();
			// print_r($all_data);die;
			$this->load->library('form_validation');
            $this->form_validation->set_rules('mode', 'mode', 'required');
            $this->form_validation->set_rules('series_form', 'Series Form', 'required');
            $this->form_validation->set_rules('series_to', 'Series To', 'required');
            $this->form_validation->set_rules('awb_qty', 'Qty', 'required');
				// unset($all_data['submit']);
				if ($this->form_validation->run() == FALSE)
                {
					$msg = 'Mode Series Qty are Required';
					$class = 'alert alert-danger alert-dismissible';
					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
					redirect('admin/add-franchise-stock-allowtment');
				}else{
          	if(!empty($all_data)){
					$r = array(
	                'franchise_id'=>$this->input->post('franchise'),
	                'stock_manager'=>$this->input->post('stock_manager'),
	                'series_from'=>$this->input->post('series_from'),
	                'series_to'=>$this->input->post('series_to'),
					);
			 	}

			 	$stock_manager = $this->input->post('awb_qty');
			
				$whr = array('id'=>$this->input->post('stock_manager'));
				$whr2 = array('customer_id'=>$this->input->post('franchise'));

				$upval = array('to_assign'=>$this->input->post('franchise'),'status'=>'1');
				$mode = $this->input->post('mode');
				$data['stock_manager'] = $this->db->query("select * from tbl_awb_stock_manager  where mode = '$mode' and isdeleted = '0'")->result_array();

				echo "<pre>";
				
				// print_r($sql);
				print_r($data['stock_manager']);
				print_r($all_data);//die;
				$userid = $this->session->userdata('userId');
				$mode = $this->input->post('mode');
				$r = array(
					'assigned_date' => date('Y-m-d H:i:s'),
					'assigned_by' => $userid,
					'customer_id'=>$this->input->post('franchise'),
					'mode'=>$mode,
					'seriess_from'=>$this->input->post('series_form'),
					'seriess_to'=>$this->input->post('series_to'),
					'stock_manager'=>'',
					'qty'=>$this->input->post('awb_qty')
					);
					$result=$this->basic_operation_m->insert('tbl_branch_assign_cnode',$r); //echo $this->db->last_query()
				foreach($data['stock_manager'] as $key => $value){
					
					if ($stock_manager > 0) {
						$updateValue =$value['awbs_limits'];
					
						if($value['awbs_limits'] > $stock_manager){
							$updateValue = $value['awbs_limits'] - $stock_manager;
						
							$r = array(
			                'customer_id'=>$this->input->post('franchise'),
			                'stock_manager'=>$value['id'],
			                'qty'=>$stock_manager,
							);
							$stock_manager = 0;
						
						}else{
							$stock_manager =   $stock_manager - $value['awbs_limits'];
							$updateValue = 0;
						} 
						
						$this->basic_operation_m->update('tbl_awb_stock_manager',array('awbs_limits'=>$updateValue),array('id'=> $value['id']));
				
					}
			}
				redirect('admin/stock-allowtment');
		}
	}
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$data['franchise1'] = $this->db->query("select *,tbl_franchise.cmp_area as cmp_area from tbl_customers join tbl_franchise on tbl_franchise.fid = tbl_customers.customer_id where (customer_type ='1' OR customer_type ='2') ")->result();
		$this->load->view('admin/stock_allowtment/add_franchise_stock_allowtment',$data);
	}
	
	public function stock_value()
    {
       $mode = $this->input->post('mode'); 
       $awb_qty = $this->input->post('awb_qty'); 
		//    print_r($_POST);die;
		
		$res1 = $this->db->query("select * from tbl_awb_stock_manager where mode = '$mode' and awbs_limits > $awb_qty and  isdeleted = '0'")->row();	
		
		echo json_encode($res1);
    }

    public function get_stock_value()
    {
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
       $mode = $this->input->post('mode'); 
       $awb_qty = $this->input->post('awb_qty'); 
	
		$res1 = $this->db->query("select *,sum(awbs_limits) as awbs_limits from tbl_awb_stock_manager where mode = '$mode' and  isdeleted = '0'")->row();	
		$res2 = $this->db->query("select * from tbl_branch_assign_cnode where branch_id IS NULL order by id desc limit 1")->row();	
		// echo $this->db->last_query();die;
		if (!$res1) {
			$res1['awbs_limits'] = 0;
		}
		$data = [];
		
		if(!empty($res1->awbs_limits)){
			$data['stock'] = $res1->awbs_limits;
		}else{
			$data['stock'] = "Stock Not Available";
		}
		
		if(!empty($res2->seriess_to)){
		    $data['seriess_to'] = $res2->seriess_to;
		}else{
			$data['seriess_to'] = "Data Not Found";
		}
		// echo '<pre>';print_r($res1); print_r($data);die;
		echo json_encode($data);
    }
	
    public function get_stock_value_branch()
    {
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
       $mode = $this->input->post('mode'); 
       $awb_qty = $this->input->post('awb_qty'); 
	
		$res1 = $this->db->query("select *,sum(awbs_limits) as awbs_limits from tbl_awb_stock_manager where mode = '$mode' and  isdeleted = '0'")->row();	
		$res2 = $this->db->query("select * from tbl_branch_assign_cnode where customer_id IS NULL order by id desc limit 1")->row();	
		// echo $this->db->last_query();die;
		if (!$res1) {
			$res1['awbs_limits'] = 0;
		}
		$data = [];
		
		if(!empty($res1->awbs_limits)){
			$data['stock'] = $res1->awbs_limits;
		}else{
			$data['stock'] = "Stock Not Available";
		}
		
		if(!empty($res2->seriess_to)){
		    $data['seriess_to'] = $res2->seriess_to;
		}else{
			$data['seriess_to'] = "Data Not Found";
		}
		// echo '<pre>';print_r($res1); print_r($data);die;
		echo json_encode($data);
    }
	
	
	
	public function delete_vendor()
	{
	    $id = $this->input->post('getid');
	//	$data['message']="";
		if($id!="")
		{
		    $whr =array('tv_id'=>$id);
			$res=$this->basic_operation_m->delete('tbl_vendor',$whr);
			
			$output['status'] = 'success';
	     	$output['message'] = 'Vendor deleted successfully';
			
		}else{ 
		    $output['status'] = 'error';
		    $output['message'] = 'Something went wrong in deleting the Vendor';
			
           // redirect('admin/list-vendor');
		}
			echo json_encode($output);
	  
	}
	
	
	
	
}
?>