<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class FTLController extends CI_Controller
{

    var $data = array();
    function __construct()
    {
        parent::__construct();
         $this->load->helper(array('form', 'url'));
        $this->load->model('basic_operation_m');
        $this->load->model('Franchise_model');
        if ($this->session->userdata('userId') == '') {
            redirect('admin');
        }
    }

    public function index()
    {
        $data['cities']	= $this->basic_operation_m->get_all_result('city', '');
      	$data['states'] =$this->basic_operation_m->get_all_result('state', '');
        $user_type 	= $this->session->userdata("userType");
        	if($user_type == 1)
		{
			$data['customers'] =$this->basic_operation_m->get_all_result('tbl_customers', "");
		}else{
			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);
			$res = $this->basic_operation_m->getAll('tbl_users', $whr);
			$branch_id = $res->row()->branch_id;				
			$where ="branch_id='$branch_id' ";
			$customer_type =0;
			$data['customers'] =$this->basic_operation_m->get_all_result('tbl_customers', "branch_id = '$branch_id',customer_type = $customer_type");
		}
      
        $data['vehicle_type'] = $this->db->query("SELECT * FROM `vehicle_type_master`")->result();
        $data['insurance_company'] = $this->db->query("SELECT * FROM `insurance_company_tbl`")->result();
        $data['product_unit_name'] = $this->db->query("SELECT * FROM `product_unit_tbl`")->result();
         $this->load->view('admin/ftl_master/add_lr',$data);
    }
    
    
    public function insert_lr_details(){
        
            $date = date('Y-m-d',strtotime($this->input->post('booking_date')));
			$this->session->unset_userdata("booking_date");
			$this->session->set_userdata("booking_date",$this->input->post('booking_date'));
		    $lrno =	$this->input->post('lr_number');
			$dd = $this->db->query("SELECT lr_number FROM `lr_table` WHERE `lr_number` = '$lrno'")->row();
			
			$insurance_details = $this->input->post('insurance_details');
		
 			if($insurance_details == 1){
			    $insurance_number = $this->input->post('insurance_number');
			    $insurance_company_name = $this->input->post('insurance_company_name');
			    $insurance_charges = $this->input->post('insurance_charges');
			    $insurance_date = date('y-m-d',strtotime($this->input->post('insurance_date')));
			}
			
	
		if(!empty($dd->lr_number )){
		    $msg = "Already Exist ". $this->input->post('lr_number');
			$class	= 'alert alert-danger alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
		   	redirect(base_url().'admin/add-lr');
		   	
		 }else{  	
		   	
        $data = array(
            
            'booking_date' =>$date,
            'lr_number' =>$lrno,
            'order_number' =>$this->input->post('order_number'),
            'type_of_vehicle' =>$this->input->post('type_of_vehicle'),
            'dispatch_details' => $this->input->post('dispatch_details'),   
            'invoice_value' =>$this->input->post('invoice_value'),
            'invoice_number' =>$this->input->post('invoice_number'),
            'lr_sender_address' =>$this->input->post('lr_sender_address'),
            'lr_receiver_address' =>$this->input->post('lr_receiver_address'),
           	'customer_id' => $this->input->post('customer_account_id'),
			'sender_name' => $this->input->post('sender_name'),
			'sender_address' => $this->input->post('sender_address'),
			'sender_city' => $this->input->post('sender_city'),
			'sender_state'=> $this->input->post('sender_state'),
			'sender_pincode' => $this->input->post('sender_pincode'),
			'sender_contactno' => $this->input->post('sender_contactno'),
			'sender_gstno' => $this->input->post('sender_gstno'),
			'reciever_name' => $this->input->post('reciever_name'),
			'contactperson_name' => $this->input->post('contactperson_name'),				
			'reciever_address' => $this->input->post('reciever_address'),
			'reciever_contact' => $this->input->post('reciever_contact'),
			'reciever_pincode' => $this->input->post('reciever_pincode'),
			'reciever_city' => $this->input->post('reciever_city'),
			'reciever_state' => $this->input->post('reciever_state'),
			'receiver_gstno' => $this->input->post('receiver_gstno'),
			'gst_pay' => $this->input->post('gst_pay'),
			'insurance_details'=>$insurance_details,
			'insurance_number' =>$insurance_number,
			'insurance_company_name' =>$insurance_company_name,
			'insurance_charges' =>$insurance_charges,
			'insurance_date' =>$insurance_date,
			
			);

      //  print_r($data);exit;
			$this->db->insert('lr_table', $data);
			//echo $this->db->last_query();exit;
			

	    	$lastid = $this->db->insert_id();
			$data2 = array(
			'lr_id'=>$lastid,
			'product_name'=>$this->input->post('product_name'),
			'product_weight'=>$this->input->post('product_weight'),
			'declare_weight'=>$this->input->post('declare_weight'),
			'chargable_weight'=>$this->input->post('chargable_weight'),
			'product_unit'=>$this->input->post('product_unit'),
			'product_qty'=>$this->input->post('product_qty'),
			
			'frieht_charge'=>$this->input->post('frieht_charge'),
			'aso_charge'=>$this->input->post('aso_charge'),
			'labour_charge'=>$this->input->post('labour_charge'),
			'st_charge'=>$this->input->post('st_charge'),
			'lc_charge'=>$this->input->post('lc_charge'),
			'misc_charge'=>$this->input->post('misc_charge'),
			'ch_post_charge'=>$this->input->post('ch_post_charge'),
			'total_charge'=>$this->input->post('total_charge'),
			'gst_charge'=>$this->input->post('gst_charge'),
			'grand_total'=>$this->input->post('grand_total'),

            );
          
          	 $this->db->insert('lr_product_tbl', $data2); 
          	// echo $this->db->last_query();exit;
		
          	
    	     $msg   =  'Data Inserted Successfully!!';
		   	$class	= 'alert alert-success alert-dismissible';	
		
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			redirect(base_url().'admin/add-lr');
					
        }
    } 
    
    
    public function add_unit(){
          
          $this->load->view('admin/ftl_master/add_unit'); 
    }
    
    public function view_ftl_list(){
        
         $data['ftl_list'] = $this->db->query("SELECT lr_table.*,lr_product_tbl.product_name,lr_product_tbl.product_weight,rc.city as reciever_city,vehicle_type_master.vehicle_name,sc.city as sender_city FROM lr_table INNER JOIN lr_product_tbl ON lr_table.lr_id = lr_product_tbl.lr_id LEFT JOIN city as rc ON lr_table.reciever_city = rc.id LEFT JOIN vehicle_type_master ON lr_table.type_of_vehicle = vehicle_type_master.id LEFT JOIN city as sc ON lr_table.sender_city = sc.id order by lr_id DESC")->result();
        
          $this->load->view('admin/ftl_master/ftl_list',$data);  
    }
    
    public function view_lr_printlabel($id){
          $data['printlabel'] = $this->db->query("SELECT lr_table.*,rc.city as reciever_city,vehicle_type_master.vehicle_name,sc.city as sender_city FROM lr_table LEFT JOIN city as rc ON lr_table.reciever_city = rc.id LEFT JOIN vehicle_type_master ON lr_table.type_of_vehicle = vehicle_type_master.id LEFT JOIN city as sc ON lr_table.sender_city = sc.id WHERE `lr_id`=".$id)->result();
          $this->load->view('admin/ftl_master/lr_printlabel',$data);
    }

	public function ftl_request_data()
	{
		$data['ftl_request_data'] = $this->db->query("SELECT ftl_request_tbl.* ,vehicle_type_master.vehicle_name  FROM ftl_request_tbl left join vehicle_type_master ON vehicle_type_master.id = ftl_request_tbl.type_of_vehicle ")->result_array();
		$this->load->view('admin/ftl_master/ftl_request_list',$data);
	}
}