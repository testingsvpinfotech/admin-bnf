<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_bag_incoming extends CI_Controller{
	
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
WHERE tbl_domestic_menifiest.destination_branch='$branch_name' AND reciving_status ='1'
GROUP BY tbl_domestic_bag.bag_id
ORDER BY tbl_domestic_bag.id DESC");
		//$resAct=$this->basic_operation_m->getAll('tbl_inword','');
		 if($resAct->num_rows()>0)
		 {
		 	$data['allinword']=$resAct->result_array();	            
			
         }
		 
         $this->load->view('admin/bag_incoming/view_incoming',$data);
     
		
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
 where destination_branch='$branch_name' AND bag_recived = '0'  and tbl_domestic_stock_history.gatepass_genarte = '1' and tbl_domestic_stock_history.gatepass_inscan ='1' and tbl_domestic_stock_history.menifest_Inscan='1' GROUP BY tbl_domestic_bag.bag_id" );
		
        if($resAct->num_rows()>0)
        {
			$data['menifiest']=$resAct->result();
        }
		
       	$data['branch_name']=$branch_name;
    //   echo $this->db->last_query();die;
	  
	  if(!empty($mid))
	  {
		   $date=date('y-m-d');			
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_bag where bag_recived ='0' and bag_id='$mid' ");
			$data['menifiest_data']=$res->result();
	  }
		
		if (isset($_POST['submit'])) 
		{
			
			
			 $date=date('y-m-d');
			 
			$mid=$this->input->post('manifiest_id');
			 $data['manifiest_id']=$mid;
			 $res=$this->db->query("select * from tbl_domestic_bag where bag_recived ='0' and bag_id='$mid' ");
			$data['menifiest_data']=$res->result();
			
		}
	
		if(isset($_POST['receving'])) 
		{
			$all_data 		= $this->input->post();
			$date			= $this->input->post('datetime');
			$remark			= $this->input->post('note');
			$pod			= $this->input->post('pod_no');
		
			$username	=	$this->session->userdata("userName");
			$whr 		= 	array('username'=>$username);
			$res		=	$this->basic_operation_m->getAll('tbl_users',$whr);
			$branch_id	= 	$res->row()->branch_id;
			


			$whr		= 	array('branch_id'=>$branch_id);
			$res		=	$this->basic_operation_m->getAll('tbl_branch',$whr);
			$branch_name= 	$res->row()->branch_name;

			// print_r($_POST);
	        //  echo '<pre>';print_r($all_data);die;
			if(!empty($all_data))
			{    $this->db->trans_start();
			     for($i= 0;$i<count($pod);$i++){
					 $pod_no = $pod[$i];
					$booking_id		=	$this->basic_operation_m->get_table_row('tbl_domestic_booking',"pod_no = '$pod_no'");
					$domestic_bag_no		=	$this->basic_operation_m->get_table_row('tbl_domestic_bag',"pod_no = '$pod_no' and bag_recived = '0'");
				   if(! empty($domestic_bag_no)){
					
					$data1=array('id'=>'',
								 'booking_id'=>$booking_id->booking_id,
								 'pod_no'=>$pod_no,
								 'status'=>'Bag In-Scan',
								 'forworder_name'=> 'SELF',
								 'branch_name'=>$branch_name,
								 'remarks'=>$remark[$i],
								 'tracking_date'=>$date,
									  );
					
					$bkdate_reason = $this->input->post('bkdate_reason');
					$result1	=	$this->basic_operation_m->insert('tbl_domestic_tracking',$data1);

					// $resAct		=	$this->db->query("update tbl_domestic_bag set bag_recived = '1' , bkdate_reason_view_incoming = '$bkdate_reason' where pod_no='$pod_no'");
					// $resAct		=	$this->db->query("update tbl_domestic_booking set menifiest_recived = '0' where pod_no='$pod_no'");
					if(! empty($bkdate_reason = $this->input->post('bkdate_reason'))){
					$domestic_bag = "update tbl_domestic_bag set bag_recived = '1' , bkdate_reason_view_incoming = '$bkdate_reason' where pod_no='$pod_no'";
					}else{
					$domestic_bag = "update tbl_domestic_bag set bag_recived = '1' where pod_no='$pod_no'";
					}
					$this->db->query($domestic_bag);
					// echo $this->db->last_query();exit();
					$domestic_booking = "update tbl_domestic_booking set menifiest_recived = '0' where pod_no='$pod_no'";
					$this->db->query($domestic_booking);
					$queue_dataa1 = "update tbl_domestic_stock_history set bag_inscan ='1',bag_genrated ='0',menifest_genrate='0',gatepass_genarte='0',gatepass_inscan='0',menifest_Inscan='0' where pod_no = '$pod_no'";
					$this->db->query($queue_dataa1);
					
					
					$array_data[] = $data1;
				 }
				}
				$this->basic_operation_m->addLog($this->session->userdata("userId"),'Master','Bag In-Scan', $array_data);
				$this->db->trans_complete();
			}
			if ($this->db->trans_status() === TRUE)
            {
				$this->db->trans_commit();
				$msg = 'Bag In Scan successfully';
				$class = 'alert alert-success alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);			  
            }else{
				$this->db->trans_rollback();
				$msg = 'Something went wrong ';
				$class = 'alert alert-success alert-dismissible';
				// echo $this->db->last_query();
// die;
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
			}
			redirect('admin/list-incoming-bag');
		}
		
		
		$this->load->view('admin/bag_incoming/addincoming', $data);
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