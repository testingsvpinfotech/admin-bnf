<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pod extends CI_Controller 
{

	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}
	public function index($offset=0,$searching='')
	{
		
		$username=$this->session->userdata("userName");			
		$userId=$this->session->userdata("userId");			
		
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		
		$data= array();
		
		
		
		if($userId == '1')
		{ 
			$filterCond = '1';
			// $data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod");
			$resActt = $this->db->query("select * from tbl_upload_pod where  $filterCond ");
			// echo $this->db->last_query();die;
			$resAct = $this->db->query("select tbl_domestic_booking.pod_no ,tbl_domestic_booking.sender_name , tbl_domestic_booking.sender_city , tbl_upload_pod.* ,tbl_upload_pod.booking_date,tbl_domestic_deliverysheet.branch_id ,city.city,tbl_branch.branch_name  from tbl_upload_pod 
			 join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no
			 join tbl_domestic_deliverysheet on tbl_domestic_deliverysheet.pod_no = tbl_upload_pod.pod_no 
			 join tbl_branch on tbl_branch.branch_id = tbl_domestic_deliverysheet.branch_id
			 join city on city.id = tbl_domestic_booking.sender_city
			 where $filterCond order by id desc limit ".$offset.",50");
			// echo $this->db->last_query();die;
				
				$this->load->library('pagination');
			
				$data['total_count']			= $resActt->num_rows();
				$config['total_rows'] 			= $resActt->num_rows();
				$config['base_url'] 			= 'admin/upload-pod/';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);
				
				$config['per_page'] 			= 50;
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
				
					$data['pod']			= $resAct->result();
				}
				else
				{
					$data['pod']			= array();
				}
		}
		else
		{
			
			$where = '';
			$all_user	= $this->basic_operation_m->get_query_result("select * from tbl_users where branch_id = '$branch_id'");
			foreach($all_user as $key => $values)
			{
				$where .= "'".$values->username."'";
			}
			$filterCond = '1';
			$where 	= str_replace("''","','",$where);
			// $data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no  where tbl_domestic_booking.branch_id = '$branch_id' or deliveryboy_id IN($where)");
			// echo $this->db->last_query();die;
			$resActt = $this->db->query("select * from tbl_upload_pod where  $filterCond ");
			// echo $this->db->last_query();die;
			$resAct = $this->db->query("select tbl_domestic_booking.pod_no ,tbl_domestic_booking.sender_name , tbl_domestic_booking.sender_city , tbl_upload_pod.* ,tbl_upload_pod.booking_date,tbl_domestic_deliverysheet.branch_id ,city.city,tbl_branch.branch_name  from tbl_upload_pod 
			 join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no
			 join tbl_domestic_deliverysheet on tbl_domestic_deliverysheet.pod_no = tbl_upload_pod.pod_no 
			 join tbl_branch on tbl_branch.branch_id = tbl_domestic_deliverysheet.branch_id
			 join city on city.id = tbl_domestic_booking.sender_city
			 where $filterCond and tbl_domestic_booking.branch_id = '$branch_id' or deliveryboy_id IN($where) order by id desc limit ".$offset.",50");
			
			$this->load->library('pagination');
			
			$data['total_count']			= $resActt->num_rows();
			$config['total_rows'] 			= $resActt->num_rows();
			$config['base_url'] 			= 'admin/upload-pod/';
			//	$config['suffix'] 				= '/'.urlencode($filterCond);
			
			$config['per_page'] 			= 50;
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
			
				$data['pod']			= $resAct->result();
			}
			else
			{
				$data['pod']			= array();
			}
		}
        $this->load->view('admin/pod/view_pod',$data);
      
	}
	
	public function outscan_POD_Uploaded()
	{
		
		$username=$this->session->userdata("userName");			
		$userId=$this->session->userdata("userId");			
		
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		
		
		$data= array();
		
		
		
		if($userId == '1')
		{
			$data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no order by tbl_upload_pod.id desc");
		}
		else
		{
			
			$where = '';
			$all_user	= $this->basic_operation_m->get_query_result("select * from tbl_users where branch_id = '$branch_id'");
			foreach($all_user as $key => $values)
			{
				$where .= "'".$values->username."'";
			}
			
			$where 	= str_replace("''","','",$where);
			$data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no  where tbl_domestic_booking.branch_id = '$branch_id' order by tbl_upload_pod.id desc");
			// echo $this->db->last_query();die;
			
		}
        $this->load->view('admin/pod/view_outscan_POD_Uploaded',$data);
      
	}
	public function Outscan_POD_Pending()
	{
		
		$username=$this->session->userdata("userName");			
		$userId=$this->session->userdata("userId");			
		
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		
		$data= array();
		
		
		
		if($userId == '1')
		{
			$data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no order by tbl_upload_pod.id desc");
		}
		else
		{
			
			$where = '';
			$all_user	= $this->basic_operation_m->get_query_result("select * from tbl_users where branch_id = '$branch_id'");
			foreach($all_user as $key => $values)
			{
				$where .= "'".$values->username."'";
			}
			
			$where 	= str_replace("''","','",$where);
			$data['pod']	= $this->basic_operation_m->get_query_result("select tbl_domestic_booking.* from tbl_domestic_booking LEFT JOIN tbl_upload_pod on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no  where tbl_domestic_booking.branch_id = '$branch_id' and tbl_upload_pod.pod_no IS NULL order by tbl_domestic_booking.booking_id desc");
			//  echo $this->db->last_query();die;
			// echo '<pre>';print_r($data);die;
		}
        $this->load->view('admin/pod/view_Outscan_POD_Pending',$data);
      
	}
	public function Inscan_POD_Uploaded()
	{
		
		$username=$this->session->userdata("userName");			
		$userId=$this->session->userdata("userId");			
		
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		
		$data= array();
		
		
		
		if($userId == '1')
		{
			$data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no order by tbl_upload_pod.id desc");
		}
		else
		{
			
			$where = '';
			$all_user	= $this->basic_operation_m->get_query_result("select * from tbl_users where branch_id = '$branch_id'");
			foreach($all_user as $key => $values)
			{
				$where .= "'".$values->username."'";
			}
			
			$where 	= str_replace("''","','",$where);
			$data['pod']	= $this->basic_operation_m->get_query_result("select tbl_domestic_booking.*,tbl_upload_pod.* from tbl_domestic_booking JOIN tbl_upload_pod on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no  where tbl_domestic_booking.branch_id = '$branch_id' and tbl_upload_pod.deliveryboy_id = ( select username from tbl_users where branch_id ='$branch_id' LIMIT 1) order by tbl_domestic_booking.booking_id desc");
			//  echo $this->db->last_query();die;
			// echo '<pre>';print_r($data);die;
		}
        $this->load->view('admin/pod/view_Inscan_POD_Uploaded',$data);
      
	}
	public function Inscan_POD_Pending()
	{
		
		$username=$this->session->userdata("userName");			
		$userId=$this->session->userdata("userId");			
		
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		$whr1 = array('branch_id'=>$branch_id);
		$res1=$this->basic_operation_m->getAll('tbl_branch',$whr1);
		$branch_name= $res1->row()->branch_name;
		$data= array();
		
		
		
		if($userId == '1')
		{
			$data['pod']	= $this->basic_operation_m->get_query_result("select * from tbl_upload_pod join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no order by tbl_upload_pod.id desc");
		}
		else
		{
			
			$where = '';
			$all_user	= $this->basic_operation_m->get_query_result("select * from tbl_users where branch_id = '$branch_id'");
			foreach($all_user as $key => $values)
			{
				$where .= "'".$values->username."'";
			}
			
			$where 	= str_replace("''","','",$where);
			$data['pod']	= $this->basic_operation_m->get_query_result("select tbl_domestic_booking.* from tbl_domestic_booking JOIN tbl_domestic_tracking on tbl_domestic_booking.pod_no = tbl_domestic_tracking.pod_no LEFT JOIN tbl_upload_pod on tbl_domestic_booking.pod_no = tbl_upload_pod.pod_no  where tbl_domestic_booking.branch_id = '$branch_id' and tbl_domestic_tracking.status = 'Delivered' and tbl_domestic_tracking.branch_name = '$branch_name' and tbl_upload_pod.pod_no IS NULL order by tbl_domestic_booking.booking_id desc");
			//  echo $this->db->last_query();die;
			// echo '<pre>';print_r($data);die;
		}
        $this->load->view('admin/pod/view_Inscan_POD_Pending',$data);
      
	}
	public function addpod()
	{
		$where = array('is_delhivery_complete'=>'1');
		// $resAct	= $this->basic_operation_m->getAll('tbl_domestic_booking',$where);
		$username=$this->session->userdata("userName");			
		$userId=$this->session->userdata("userId");			
		
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		if($userId == '1')
		{
		$resAct	= $this->db->query("select tbl_domestic_booking.* from tbl_domestic_stock_history join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no left join tbl_upload_pod on tbl_upload_pod.pod_no = tbl_domestic_stock_history.pod_no where tbl_domestic_stock_history.is_delivered = '1' and tbl_upload_pod.pod_no IS NULL");
		}else{
			$resAct	= $this->db->query("select tbl_domestic_booking.* from tbl_domestic_stock_history join tbl_domestic_booking on tbl_domestic_booking.pod_no = tbl_domestic_stock_history.pod_no left join tbl_upload_pod on tbl_upload_pod.pod_no = tbl_domestic_stock_history.pod_no where tbl_domestic_stock_history.is_delivered = '1' and tbl_domestic_stock_history.delivery_branch = '$branch_id' and tbl_upload_pod.pod_no IS NULL");
		}
		// echo $this->db->last_query();die;
		  if($resAct->num_rows()>0)
		 {
		 	$data['deliverysheet']=$resAct->result_array();	            
         }
		//print_r($data['deliverysheet']);exit;
		$data['message']="";
	    $this->load->view('admin/pod/addpod',$data);
	}
	public function insertpod()
	{
		$all_data 		= $this->input->post();
		if (!empty($all_data)) 
		{
			$username=$this->session->userdata("userName");
			$whr = array('username'=>$username);
			$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		    $branch_id= $res->row()->branch_id;
			$date=date('y-m-d');
			 
			$whr = array('branch_id'=>$branch_id);
			$res=$this->basic_operation_m->getAll('tbl_branch',$whr);
			$branch_name= $res->row()->branch_name;
			
			$date=date('y-m-d');
			  
				$lastid = $this->input->post('pod_no');
				$drs_date = $this->db->query("SELECT * FROM tbl_domestic_tracking WHERE status = 'Delivered' AND pod_no ='$lastid' ORDER BY id DESC LIMIT 1")->row('tracking_date');
			$predate = date('Y-m-d', strtotime($drs_date));
			$curret = date('Y-m-d');
			if (
				$predate <= date('Y-m-d', strtotime($this->input->post('booking_date'))) &&
				$curret >= date('Y-m-d', strtotime($this->input->post('booking_date')))
			) {

					
				$config['upload_path'] = "assets/pod/";
				$config['allowed_types'] = 'gif|jpg|png|pdf';
				
			    $imageExtention = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
		
				$config['file_name'] = 'pod_'.$lastid.'.'.$imageExtention;
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				$this->upload->set_allowed_types('*');

				$data['upload_data'] = '';
				$url_path="";
				if (!$this->upload->do_upload('image'))
				{ 
					$data = array('msg' => $this->upload->display_errors());
				}
				else 
				{ 
					$image_path = $this->upload->data();
					$r= array('id'=>'',
					'deliveryboy_id'=>$username,
					'pod_no'=>$this->input->post('pod_no'),
					'booking_date'=>$this->input->post('booking_date'),
					'delivery_date'=>$this->input->post('delivery_date'),
					'remarks' => $this->input->post('remark'),
					'image'=>$image_path['file_name']
				   );
	//   print_r($r);die;
	             $result=$this->basic_operation_m->insert('tbl_upload_pod',$r);
				}
					
				// $data =array('image'=>$image_path['file_name']);
				// $whr=array('id'=>$lastid);
				// $this->basic_operation_m->update('tbl_upload_pod',$data,$whr);

				if ($this->db->affected_rows()>0) {
					$msg = 'Pod Uploaded Successfully';
				$class = 'alert alert-success alert-dismissible';
				}else{
					$msg = 'Something went to wrong!';
				    $class = 'alert alert-danger alert-dismissible';
				}

			} else {
				$msg = 'Please select date In between Delivered Date to Current date';
				$class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
				redirect('admin/add-pod');
			}
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);		
                redirect('admin/upload-pod');
		}
	}
	
	public function update_uploaded_pod(){
		$all_data 		= $this->input->post();
		if(!empty($all_data)){
		
		$pod_no = $this->input->post('pod_no');
		$image = $this->input->post('image');
		$get_id  = $this->db->query("select id from tbl_upload_pod where pod_no ='$pod_no'")->row();
		$lastid = $get_id->id ;
		$config['upload_path'] = "assets/pod/";
		$config['allowed_types'] = 'gif|jpg|png';$config['file_name'] = 'pod_'.$lastid.'.jpg';
			
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		$this->upload->set_allowed_types('*');

		$data['upload_data'] = '';
		$url_path="";
		
		if (!$this->upload->do_upload('image'))
		{ 
			$data = array('msg' => $this->upload->display_errors());
		}
		else 
		{ 
			$image_path = $this->upload->data();
		}
	        	$data =array('image'=>$image_path['file_name']);
				$whr=array('pod_no'=>$all_data['pod_no']);
				$this->basic_operation_m->update('tbl_upload_pod',$data,$whr);

		if ($this->db->affected_rows()>0) {
			$data['message']="Image Added Sucessfully";
		}else{
			$data['message']="Error in Query";
		}
			
		redirect('admin/upload-pod');
		}else{
			$this->load->view('admin/pod/update_pod');
		}
	}


	public function view_bulkpod()
	{
		$data['message']="";
	    $this->load->view('admin/pod/uploadbulkpod',$data);
	}
	
	
	public function insert_bulkupload()
	{
		$all_data 		= $this->input->post();
		if (!empty($all_data)) 
		{
			$username=$this->session->userdata("userName");
			
			if(isset($_FILES['csv_zip']))
		    {
    		 	$ext = pathinfo($_FILES['csv_zip']['name'], PATHINFO_EXTENSION);
    		 	$date=date('y-m-d');
    		
    			$file				= $_FILES["csv_zip"];
    			$filename 			= $file["name"];
    			$tmp_name 	 		= $file["tmp_name"];
    			$type 		 		= $file["type"];
    			$name 				= explode(".", $filename);
    		
    			$continue 			= strtolower($name[1]) == 'zip' ? true : false; //Checking the file Extension
    			if(!$continue)
    			{
    				$message 		= "The file you are trying to upload is not a .zip file. Please try again.";
    			}       
    			$targetdir 			= "assets/pod/";
    			$targetzip 			= "assets/pod/".$filename;
    			
    			if(move_uploaded_file($tmp_name, $targetzip))
    			{
    				$zip 	= new ZipArchive();
    				$x 		= $zip->open($targetzip);  // open the zip file to extract
    				if($x === true)
    				{
    					
    					for ($i = 0; $i < $zip->numFiles; $i++)
    					{
    						$filename = $zip->getNameIndex($i);
    						$filenamee = explode('.',$filename);
    						
    						
            			    $r= array('id'=>'',
            						  'deliveryboy_id'=>$username,
            						  'pod_no'=>$filenamee[0],
            		                  'image'=>$filename,
            						  'delivery_date'=>$date
            						 );
            			
            		    	$result=$this->basic_operation_m->insert('tbl_upload_pod',$r);
            			
            				
    					//	echo $filename;
    					//	echo '<br>';
    				
    					}
    			 
    					$zip->extractTo($targetdir); // place in the directory with same name  
    					$zip->close();
    					unlink($targetzip); 
    				}
    				$data['message'] = "Your <strong>zip</strong> file was uploaded and unpacked.";
    			}
    			else
    			{    
    				$data['message'] = "There was a problem with the upload. Please try again.";
    			}
		
			
		     } 
		  
               redirect('admin/upload-pod');
		}
	}

	public function pod_delete()
	{
          $getId = $this->input->post('getid');
        //   $data =  $this->db->delete('tbl_customers',array('customer_id'=>$getId));
		  	
		//   $data=$this->basic_operation_m->update('tbl_upload_pod',$r, array('id'=>$getId));
		  $data=$this->basic_operation_m->delete('tbl_upload_pod',array('id'=>$getId));
         // echo $this->db->last_query();
          if($data){
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the member';
			
		}
		else{
			$output['status'] = 'success';
			$output['message'] = 'Member deleted successfully';
		}
 
		echo json_encode($output);	

	}
	function pending_pod()
	{
        // $this->db->query("SELECT *  from tbl_domestic_tracking where status = ''")

		$data['pod'] = $this->db->query("SELECT * , tbl_domestic_booking.pod_no as pod  FROM tbl_domestic_booking JOIN tbl_domestic_tracking ON tbl_domestic_booking.pod_no=tbl_domestic_tracking.pod_no LEFT JOIN tbl_domestic_deliverysheet ON tbl_domestic_booking.pod_no=tbl_domestic_deliverysheet.pod_no WHERE  tbl_domestic_tracking.status = 'Delivered' AND tbl_domestic_deliverysheet.pod_no IS NULL ORDER BY tbl_domestic_booking.booking_id DESC;")->result_array();
		// $data['pod'] = $this->db->query("SELECT * , tbl_domestic_booking.pod_no as pod  FROM tbl_domestic_booking LEFT JOIN tbl_domestic_deliverysheet ON tbl_domestic_booking.pod_no=tbl_domestic_deliverysheet.pod_no WHERE tbl_domestic_deliverysheet.pod_no IS NULL ORDER BY id DESC;")->result_array();
		$this->load->view('admin/pod/view_pendingpod', $data);
	}
	function pending_hard_copy_pod()
	{
		$username=$this->session->userdata("userName");
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		$userId=$this->session->userdata("userId");		
		if($userId=='1'){
			$data['pod'] = $this->db->query("SELECT * FROM tbl_upload_pod where hc_status = '0'")->result_array();
		}else{
		$data['pod'] = $this->db->query("SELECT tbl_upload_pod.* FROM tbl_domestic_deliverysheet join tbl_upload_pod ON tbl_upload_pod.pod_no = tbl_domestic_deliverysheet.pod_no where tbl_domestic_deliverysheet.branch_id = '$branch_id' and tbl_upload_pod.hc_status = '0' order by tbl_upload_pod.id desc")->result_array();
		}
		$this->load->view('admin/pod/view_hard_copypendingpod', $data);
	}
	function view_hard_copy_pod()
	{
		$username=$this->session->userdata("userName");
		$whr = array('username'=>$username);
		$res=$this->basic_operation_m->getAll('tbl_users',$whr);
		$branch_id= $res->row()->branch_id;
		$userId=$this->session->userdata("userId");		
		if($userId=='1'){
			$data['pod'] = $this->db->query("SELECT * FROM tbl_upload_pod where hc_status = '1' order by id desc")->result_array();
		}else{
		$data['pod'] = $this->db->query("SELECT tbl_upload_pod.* FROM tbl_domestic_deliverysheet join tbl_upload_pod ON tbl_upload_pod.pod_no = tbl_domestic_deliverysheet.pod_no where tbl_domestic_deliverysheet.branch_id = '$branch_id' and tbl_upload_pod.hc_status = '1' order by tbl_upload_pod.id desc")->result_array();
		}
		$this->load->view('admin/pod/view_hard_copy', $data);
	}

	public function hard_copy_pod()
	{
		$where = array('hc_status'=>'0');
		$resAct	= $this->basic_operation_m->getAll('tbl_upload_pod',$where);
		  if($resAct->num_rows()>0)
		 {
		 	$data['deliverysheet']=$resAct->result_array();	            
         }
		 $vallpost = $this->input->post();
		 if(! empty($vallpost)){
			$pod_no = $this->input->post('pod_no');

			$value = array(
                'hc_recived_by'=>$_SESSION['userName'],
                'hc_recived_date_time'=>$this->input->post('booking_date'),
                'hc_status'=> '1'
			);
			$whr=array('pod_no'=>$pod_no);
				$this->basic_operation_m->update('tbl_upload_pod',$value,$whr);
				redirect('admin/hard-copy-pod-pending');
		 }
		  
		$data['message']="";
	    $this->load->view('admin/pod/add_hard_copy_pod',$data);
	}
	
}