<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_customer_stock_allowtment extends CI_Controller {

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
		$resAct	= $this->db->query("select *,transfer_mode.mode_name,tbl_customers.customer_name,tbl_customers.customer_id from tbl_customer_assign_cnode join transfer_mode on transfer_mode.transfer_mode_id = tbl_customer_assign_cnode.mode  left join tbl_customers on tbl_customers.customer_id = tbl_customer_assign_cnode.customer_id order by id desc");		
		if($resAct->num_rows()>0)
		{
		 	$data['allvendor']=$resAct->result_array();	            
        }
        $this->load->view('admin/customer_stock_allowtment/view_stock_allowtment',$data);       
	}
	
	
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

				// echo "<pre>";
				
				// // print_r($sql);
				// print_r($data['stock_manager']);
				// print_r($all_data);//die;
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
					$result=$this->basic_operation_m->insert('tbl_customer_assign_cnode',$r); //echo $this->db->last_query()
				
				redirect('admin/stock-customer-allowtment');
		}
	}
		$data['mode'] = $this->db->query("select * from transfer_mode")->result();
		$data['franchise1'] = $this->db->query("select * from tbl_customers  where (customer_type !='1' AND customer_type !='2') ")->result();
		$this->load->view('admin/customer_stock_allowtment/add_customer_stock_allowtment',$data);
	}
	

    public function get_stock_value()
    {
		ini_set('display_errors', '0');
		ini_set('display_startup_errors', '0');
		error_reporting(E_ALL);
       $mode = $this->input->post('mode'); 
       $awb_qty = $this->input->post('awb_qty'); 
	
		$res1 = $this->db->query("select *,sum(awbs_limits) as awbs_limits from tbl_awb_stock_manager where mode = '$mode' and  isdeleted = '0'")->row();	
		$res2 = $this->db->query("select * from tbl_customer_assign_cnode order by id desc limit 1")->row();	
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

	
	
}
?>