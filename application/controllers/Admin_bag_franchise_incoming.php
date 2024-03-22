<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_bag_franchise_incoming extends CI_Controller{
	
	function __construct()
	{	
		parent:: __construct();
		$this->load->model('basic_operation_m');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	
	public function incomingbag()
	{  
     

        $data= array();
		$username=$this->session->userdata("userName");
		     $whr = array('username'=>$username);
			 $res=$this->basic_operation_m->getAll('tbl_users',$whr);
			 $branch_id= $res->row()->branch_id;
			 
			 $whr = array('branch_id'=>$branch_id);
			 $res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			 $branch_name= $res->row()->branch_name;
		
		$resAct=$this->db->query("SELECT *, SUM(CASE WHEN tbl_domestic_bag.bag_recived=1 THEN 1 ELSE 0 END) AS total_coming, COUNT(tbl_domestic_bag.id) AS total,
 COUNT(tbl_domestic_bag.total_pcs) AS total_pcs, COUNT(tbl_domestic_bag.total_weight) AS total_weight
FROM tbl_domestic_menifiest
LEFT JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no
WHERE tbl_domestic_menifiest.destination_branch='$branch_name' AND reciving_status ='1'  AND tbl_domestic_bag.franchise_id != ''
GROUP BY tbl_domestic_bag.bag_id
ORDER BY tbl_domestic_bag.id DESC");
		//$resAct=$this->basic_operation_m->getAll('tbl_inword','');
		 if($resAct->num_rows()>0)
		 {
		 	$data['allinword']=$resAct->result_array();	            
			
         }
		 
         $this->load->view('admin/bag_franchise_incoming/view_incoming',$data);
     
		
	}
	

	public function domestic_bag($bag_id='')
	{
		// Load library
	    $this->load->library('zend');
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');
		$data= array();
		$data['message']="";
		$total_pcs= 0;
		$total_weight= 0;
		$sender_address	= '';

		$user_id = $_SESSION['userId'];
		$resAct2=$this->db->query("select tbl_branch.* from tbl_branch left JOIN city ON city.id=tbl_branch.city JOIN tbl_users on tbl_users.branch_id=tbl_branch. branch_id where tbl_users.user_id=".$user_id);
		 echo $this->db->last_query();
			
	 	$data['branchAddress']=$resAct2->result_array();
		
		if(!empty($bag_id))
		{
			$resAct=$this->db->query("select * from tbl_domestic_bag,tbl_domestic_booking,tbl_users,tbl_branch where 
			tbl_domestic_booking.pod_no=tbl_domestic_bag.pod_no and
			bag_id='$bag_id' group by tbl_domestic_booking.pod_no");
			$data['manifiest']=$resAct->result_array();

			//print_r($data['manifiest']);die;
			foreach($data['manifiest'] as $key =>$values)
			{
				$total_pcs			= $total_pcs + $values['total_pcs'];
				$total_weight		= $total_weight + $values['total_weight'];
				$sender_address		= $values['address'];
			}
		}
	    
		  if(isset($_POST['submit']))
          {
			
			$bag_id=$this->input->post('bag_id');
			
			$resAct=$this->db->query("select * from tbl_domestic_bag,tbl_domestic_booking,tbl_users,tbl_branch where 
			tbl_domestic_booking.pod_no=tbl_domestic_bag.pod_no and
			bag_id='$bag_id' group by tbl_domestic_booking.pod_no");
			
			$data['manifiest']=$resAct->result_array();
			foreach($data['manifiest'] as $key =>$values)
			{
				$total_pcs			= $total_pcs + $values['total_pcs'];
				$total_weight		= $total_weight + $values['total_weight'];
				$sender_address		= $values['address'];
			}
		 }
		 
		 $data['total_pcs']					= $total_pcs;
		 $data['total_weightt']				= $total_weight;
		 $data['sender_address']			= $sender_address;
		 
		 $where =array('id'=>1);
		$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company',$where);
		 
		$this->load->view('admin/bag_master/domestic_bag_track',$data);
	}

	public function addincomingbag($mid='')
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
	
		 $resAct=$this->db->query("select distinct tbl_domestic_bag.bag_id AS bag_no,tbl_domestic_bag.date_added,tbl_domestic_bag.bag_recived from tbl_domestic_menifiest
		  JOIN tbl_domestic_bag ON tbl_domestic_bag.bag_id = tbl_domestic_menifiest.bag_no
		  JOIN tbl_domestic_stock_history ON tbl_domestic_stock_history.pod_no = tbl_domestic_bag.pod_no
 where destination_branch='$branch_name' AND bag_recived = '0' and tbl_domestic_stock_history.bag_genrated = '0' and tbl_domestic_stock_history.branch_in_scan ='0' and tbl_domestic_stock_history.pickup_in_scan='1'  AND tbl_domestic_bag.franchise_id != '' GROUP BY tbl_domestic_bag.bag_id" );
		// echo $this->db->last_query();die;
        if($resAct->num_rows()>0)
        {
			$data['menifiest']=$resAct->result();
        }
		
       	$data['branch_name']=$branch_name;
      // echo $this->db->last_query();
	  
	  if(!empty($mid))
	  {
		   $date=date('y-m-d');
			 
			
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_bag where  bag_recived = '0' and bag_id='$mid' ");
			$data['menifiest_data']=$res->result();
	  }
		
		if (isset($_POST['submit'])) 
		{
			
			
			 $date=date('y-m-d');
			 
			$mid=$this->input->post('manifiest_id');
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_bag where bag_recived = '0' and bag_id='$mid' ");
			$data['menifiest_data']=$res->result();
			
		}
	//echo $_POST['receving'];exit;
		if(isset($_POST['receving'])) 
		{
			$all_data 		= $this->input->post();
			$date			= $this->input->post('datetime');
			$pod			= $this->input->post('pod_no');
			$remark			= $this->input->post('note');
		
			$username	=	$this->session->userdata("userName");
			$whr 		= 	array('username'=>$username);
			$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);
			$branch_id	= 	$res->row()->branch_id;
			


			$whr		= 	array('branch_id'=>$branch_id);
			$res		=	$this->basic_operation_m->getAll('tbl_branch',$whr);
			$branch_name= 	$res->row()->branch_name;

			// print_r($_POST);
	
			if(!empty($all_data))
			{
				$this->db->trans_start();
			   for( $i = 0; $i <= count($pod); $i++ ){
                   $pod_no = $pod[$i];
				   $booking_id		=	$this->basic_operation_m->get_table_row('tbl_domestic_booking',"pod_no = '$pod_no'");
				   $domestic_bag_no		=	$this->basic_operation_m->get_table_row('tbl_domestic_bag',"pod_no = '$pod_no' and bag_recived = '0'");
				  if(! empty($domestic_bag_no)){						
				   
				   $data1=array('id'=>'',
								'booking_id'=>$booking_id->booking_id,
								'pod_no'=>$pod_no,
								'status'=>'Bag In-Scan',
								'branch_name'=>$branch_name,
								'remarks'=>$remark[$i],
								'tracking_date'=>$date,
									 );
				  
				   $result1	=	$this->basic_operation_m->insert('tbl_domestic_tracking',$data1);
				   $resAct		=	$this->db->query("update tbl_domestic_bag set bag_recived = '1' where pod_no='$pod_no'");
				   $resAct		=	$this->db->query("update tbl_domestic_booking set menifiest_recived = '0' where pod_no='$pod_no'");
				   $queue_dataa1 = "update tbl_domestic_stock_history set branch_in_scan = '1' , bag_inscan ='1',bag_genrated ='0',menifest_genrate='0',gatepass_genarte='0',gatepass_inscan='0',menifest_Inscan='0' where pod_no = '$pod_no'";
				   $this->db->query($queue_dataa1);
				   // echo $this->db->last_query();die;
				  
			   }}
			   $this->db->trans_complete();
				
				// die;
			}
			if ($this->db->trans_status() === TRUE)
            {
				$this->db->trans_commit();
				$msg = 'Bag In scaning successfully';
				$class = 'alert alert-success alert-dismissible';
				
			}else{
				$this->db->trans_rollback();
				$msg = 'Something went wrong ';
				$class = 'alert alert-danger alert-dismissible';
			}
			$this->session->set_flashdata('notify', $msg);
			$this->session->set_flashdata('class', $class);
			redirect('admin/list-franchise-incoming-bag');
		}
		
		
		$this->load->view('admin/bag_franchise_incoming/addincoming', $data);
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