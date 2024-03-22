<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_fanchise_incoming extends CI_Controller{
	
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
		$username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
		
		$resAct=$this->db->query("select  *,SUM(CASE WHEN reciving_status=1 THEN 1 ELSE 0 END)  AS total_coming, COUNT(id) AS total, COUNT(total_pcs) AS total_pcs, COUNT(total_weight) AS total_weight,tbl_domestic_menifiest.user_id from tbl_domestic_menifiest JOIN  tbl_customers on tbl_customers.customer_name = tbl_domestic_menifiest.username where tbl_domestic_menifiest.destination_branch='$branch_name' group by manifiest_id order by date_added DESC");
		//$resAct=$this->basic_operation_m->getAll('tbl_inword','');
		 if($resAct->num_rows()>0)
		 {
		 	$data['allinword']=$resAct->result_array();	            
         }
         $this->load->view('admin/fanchise_incoming/view_incoming',$data);
     
		
	}
	
	public function addincoming($id='')
	{
		$data['message']="";//for branch code
		$data['menifiest_data']="";//for branch code
		$data['manifiest_id']="";//for branch code
		
		$username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
	
		
		//for pod_no
		/* $resAct	= $this->basic_operation_m->getAll('tbl_booking','');

		if($resAct->num_rows()>0)
		 {
		 	$data['pod']=$resAct->result();	            
         } */
		
		//  $resAct=$this->db->query("select * from tbl_domestic_menifiest JOIN tbl_domestic_bag on tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id    where tbl_domestic_menifiest.destination_branch='$branch_name'and tbl_domestic_stock_history.gatepass_inscan= '1' ");
		 $resAct=$this->db->query("select * from tbl_domestic_menifiest JOIN  tbl_customers on tbl_customers.customer_name = tbl_domestic_menifiest.username where tbl_domestic_menifiest.destination_branch='$branch_name' Group by tbl_domestic_menifiest.manifiest_id");
        if($resAct->num_rows()>0)
        {
			$data['menifiest']=$resAct->result();
        }
		
	
       	$data['branch_name']=$branch_name;
    //   echo $this->db->last_query();die;
	  
	  if(!empty($id))
	  {
		  $form_data 		= $this->input->post();
			
			
			 $username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
			 $date=date('y-m-d');
			 
		
			
			$mid=$id;
			 $data['manifiest_id']=$mid;
			 
			 $res=$this->db->query("select * from tbl_domestic_menifiest where destination_branch='$branch_name' and manifiest_id='$mid' ");
			$data['menifiest_data']=$res->result();
	  }
		
		if (isset($_POST['submit']) ) 
		{
			$form_data 		= $this->input->post();
			
			
			 $username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
			 $date=date('y-m-d');
			 
		
			
			$mid=$this->input->post('manifiest_id');
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_menifiest  where destination_branch='$branch_name' and manifiest_id='$mid' ");
			$data['menifiest_data']=$res->result();
			
		}
	
		if(isset($_POST['receving'])) 
		{
			$all_data 		= $this->input->post();
			$date			= $this->input->post('datetime');
			$bag			= $this->input->post('bag_no');
			$remark			= $this->input->post('note');
		
			$username	=	$this->session->userdata("userName");
			$whr 		= 	array('username'=>$username);
			$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);
			$branch_id	= 	$res->row()->branch_id;
			


			$whr		= 	array('branch_id'=>$branch_id);
			$res		=	$this->basic_operation_m->getAll('tbl_branch',$whr);
			$branch_name= 	$res->row()->branch_name;
			if(!empty($all_data))
			{
				$this->db->trans_start();
				for( $i= 0; $i<count($bag); $i++ ){
                    $bag_no = $bag[$i];
					$resAct		=	$this->db->query("update tbl_domestic_menifiest set reciving_status = '1' where bag_no='$bag_no'");
                    
							$awb_nos = $this->db->query("select pod_no from tbl_domestic_bag where bag_id = '$bag_no'")->result();

							foreach($awb_nos as $key=>$value){
								date_default_timezone_set('Asia/Kolkata'); 
                                 $date = date("Y-m-d H:i:s"); // time in India
                                 $data = array(
									'pod_no'=>$value->pod_no,
									'branch_name'=>$branch_name,
									'added_branch'=>$branch_name,
									'status'=>'Franchise Menifiest In-Scan',
									'remarks'=>$remark[$i],
									'tracking_date'=>$date,
								 );
								 $this->basic_operation_m->insert('tbl_domestic_tracking', $data);
								 $username	=	$this->session->userdata("userName");
								 $whr 		= 	array('username'=>$username);
								 $res		=	$this->basic_operation_m->getAll('tbl_users',$whr);
								 $branch_id	= 	$res->row()->branch_id;

								$dooking = $this->db->query("select * from tbl_domestic_booking where pod_no='$value->pod_no'")->row();
								$reciver_branch = $this->db->query("select branch_id from tbl_branch_service where pincode = '$dooking->reciever_pincode'")->row();
								$stock = array(
									'pod_no'=>$value->pod_no,
									'destination_pincode'=>$dooking->reciever_pincode,
									'booking_id'=>$dooking->booking_id,
									'delivery_branch'=>$reciver_branch->branch_id,
									'current_branch'=>$branch_id,
									'booked'=>'1',
									'pickup_in_scan'=>'1',
									'branch_in_scan'=>'0'
								);
								$this->basic_operation_m->insert('tbl_domestic_stock_history', $stock);
							}
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE)
				{
					$this->db->trans_commit();
					$msg = 'Franchise Manifest In scaning successfully';
					$class = 'alert alert-success alert-dismissible';

					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
				}
				else
				{
					$this->db->trans_rollback();	
					$msg = 'Something went wrong ';
					$class = 'alert alert-success alert-dismissible';

					$this->session->set_flashdata('notify', $msg);
					$this->session->set_flashdata('class', $class);
				}

			}
			redirect('admin/view-franchise-incoming');
			
		}
		
		
		$this->load->view('admin/fanchise_incoming/addincoming', $data);
	}
	
	public function sendemail($to,$message)
	{
	    $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
	    $this->load->library('email');
	    $this->email->initialize($config);
        
        $this->email->from('info@shreelogistics.net', 'shreelogistics Admin');
        $this->email->to($to); 
        
        
        $this->email->subject('Shipment Update');
        $this->email->message($message);	
        
        $this->email->send();


	}
	
	
}




?>