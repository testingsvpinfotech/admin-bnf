<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sales extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('basic_operation_m');
		$this->load->model('Login_model');
		// if($this->session->userdata('userId') == '')
		// {
		// 	redirect('Admin_sales');
		// }
	}




    public function index(){  
   
			$data				= $this->data;
			
			$data["message"]="";
			$data["result"]=false;
			$data['title']="Login";
	
			if($this->session->userdata('user_id') != '')
			{
				redirect(base_url().'Admin_sales/dashboard');
				exit();
			}
			 
			$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company',array('id'=>1));
			
			if(isset($_REQUEST['submit']))
			{
				if($this->input->post('username')!='' && $this->input->post('password')!='')
				{
					$usertype = '6';
	                $username = $this->input->post('username');
					$password = $this->input->post('password');
					$key = $this->config->item('encryption_key');
					$salt1 = hash('sha512', $key . $password);
					$salt2 = hash('sha512', $password . $key);
					$hashed_password = hash('sha512', $salt1 . $password . $salt2);
                   
					$res = $this->db->query("select * from  tbl_users where username = '$username' AND user_type = $usertype AND  c_password  = $password ")->row();
				
	                if(!empty($res)){
					
						$salesdata = array(

							'username'=> $res->username,
							'user_id'=> $res->user_id,
							'user_type'=> $res->user_type,
							'branch_id'=> $res->branch_id,

						);
					$d =	$this->session->set_userdata($salesdata);
				
					}
					
					if(!empty($res->user_id))
					{ 
						$this->session->set_userdata($salesdata);
						redirect(base_url().'Admin_sales/dashboard');
					}
					else
					{
						$data["message"] = "Invalid Login";
					}
				}
				else
				{
					$data["message"] = "Please Enter Username & Password";
				}
			}
        $this->load->view('sales_login',$data);
		
	}

    public function dashboard(){
		if($this->session->userdata('user_id') == ''){
			redirect('sales');
		}else{
		$data['total_ftl_request_data'] = $this->db->query('SELECT COUNT(`ftl_request_id`) as total FROM ftl_request_tbl')->row();	
		$data['total_customer'] = $this->db->query('SELECT COUNT(customer_id) as total1 FROM ftl_request_tbl')->row();	
        $this->load->view('sales_panel/view_dashboard');
    } 
  }

  

    public function customer_list() {
		if($this->session->userdata('user_id') == ''){
			redirect('sales');
		}else{
        $user_id = $this->session->userdata('user_id');
        $data['customer_data'] = $this->db->query("SELECT * FROM tbl_customers WHERE sales_person_id ='$user_id'")->result_array(); 
        $this->load->view('sales_panel/customer_list',$data);
        
    }
 }





// ***************************** FTL Data ******************************
public function ftl_request($offset='0')
{
	if ($this->session->userdata('user_id') == '') {
		redirect('sales');
	} else {
		  
		$sales_person_id = $this->session->userdata('user_id');
		$resAct = $this->db->query("SELECT ftl_request_tbl.* ,tbl_customers.sales_person_id,vehicle_type_master.vehicle_name FROM ftl_request_tbl left join tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id left join vehicle_type_master ON vehicle_type_master.id = ftl_request_tbl.type_of_vehicle where tbl_customers.sales_person_id = '$sales_person_id' order by ftl_request_id  DESC limit ".$offset.",10");
		// echo $this->db->last_query();exit;
		$resActt = $this->db->query("SELECT ftl_request_tbl.* ,tbl_customers.sales_person_id,vehicle_type_master.vehicle_name FROM ftl_request_tbl left join tbl_customers ON tbl_customers.customer_id = ftl_request_tbl.customer_id left join vehicle_type_master ON vehicle_type_master.id = ftl_request_tbl.type_of_vehicle where tbl_customers.sales_person_id = '$sales_person_id'");
		$this->load->library('pagination');
		
		$data['total_count']			= $resActt->num_rows();
		$config['total_rows'] 			= $resActt->num_rows();
		$config['base_url'] 			= 'sales/ftl-request-data-list/';
		//	$config['suffix'] 				= '/'.urlencode($filterCond);
		
		$config['per_page'] 			= 10;
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
		if($resAct->num_rows() > 0) 
		{
			$data['ftl_request_data']	= $resAct->result_array();
		}
		else
		{
			$data['ftl_request_data']	= array();
		}
		
		$this->load->view('sales_panel/ftl_request_data_list', $data);
	}
}


public function get_ftl_request_data()
{

	$id = $this->input->get('id');
	$data =  $this->db->query("select * from ftl_request_tbl where ftl_request_id = '$id' ")->result_array();
	//echo $this->db->last_query(); 
	echo json_encode($data);
}

public function update_request_data()
{


	$ftl_request_id = $this->input->post('ftl_request_id');
	$amount = $this->input->post('amount');
	$total_amount = $this->input->post('total_amount');
	$commissinon_amount = $this->input->post('commissinon_amount');
	$date_time_limit = $this->input->post('time_limit');
	$date_request = date('Y-m-d', strtotime($date_time_limit));
	$time_limit = date('H:i:s', strtotime($date_time_limit));
	$updateStatus1 = $this->input->post('approved');
	$user_id = $this->session->userdata('user_id');
	//$updateStatus1 = $this->input->post('cancel');

	//  print_r($updateStatus1);

	$data = array(

		'amount' => $amount,
		'time_limit'=> $time_limit,
		'request_date'=> $date_request,
		'commissinon_amount' => $commissinon_amount,
		'total_amount' => $total_amount,
		'status' => $updateStatus1,
		'sales_user_id' =>$user_id
		//'status'=>$updateStatus2,

	);
	//	print_r($data);
	$this->db->where('ftl_request_id', $ftl_request_id);
	$res = $this->db->update('ftl_request_tbl', $data);

	if (!empty($res)) {

		$output['message'] = 'Status Updated SuccessFully!';
	} else {

		$output['message'] = 'Some Thing Went Wrong';
	}
	echo json_encode($output);
}

public function send_vendor_mail()
{
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	$vendor = $this->db->query("select * from vendor_customer_tbl")->result_array();
	//  echo $this->db->last_query();

	//  print_r($dd);exit;
	foreach ($vendor as  $value) {

		$custmermail_template = $this->custmermail_template($value);
		// $adminenquiry_mail_template = $this->adminenquiry_mail_template($data); 
		//print_r($value['email']) ;exit; 

		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'mail.svpinfotech.com',
			'smtp_port' =>  465,
			// 'smtp_port' =>  587,
			'smtp_user' => 'svpinfotech@gmail.com', // change it to yours
			'smtp_pass' => '7896#RRR', // change it to yours
			'charset'   => 'UTF-8',
			'mailtype' => 'html',
			'wordwrap'  => TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from($config['smtp_user']);
		$this->email->to($value['email']);
		$this->email->subject('Mail Send Successfully to Vendor');
		$this->email->message('Mail Send Successfully to Vendor');
		if (!$this->email->send()){    
		 echo $this->email->print_debugger();
		
		} else {
			echo ' Mail send successfully';
			redirect('Admin_sales/ftl_request');
		}
	}
}

public function set_time()
{
	$this->load->view('sales_panel/set_time_form');
}




public function ptl_list()
{ 
	if($this->session->userdata('user_id') == ''){
		redirect('sales');
	}else{  
		$user_id = $this->session->userdata('user_id');
		$data['get_customer_shipment'] = $this->db->query("SELECT tbl_domestic_booking.*,tbl_customers.cid,tbl_customers.customer_name
		FROM `tbl_domestic_booking`
		JOIN tbl_customers ON tbl_domestic_booking.customer_id = tbl_customers.customer_id
		WHERE tbl_customers.sales_person_id = $user_id ")->result_array();
		$this->load->view('sales_panel/ptl_list',$data);
	}	
}
	
	public function logout()
	{
		$this->session->unset_userdata("userName");
		$this->session->unset_userdata("userId");
		$this->session->unset_userdata("userType");
		$this->session->unset_userdata("userPic");
		$this->session->unset_userdata("customer_name");
		$this->session->unset_userdata("customer_id");
		$this->session->set_userdata("loggedin",false);
		
		$this->session->sess_destroy();
		redirect('sales');
	}

	public function ptl_createExcel()
    {
		$user_id = $this->session->userdata('user_id');
        $filename = 'application_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        /* get data */
		$get_customer_shipment = $this->db->query("SELECT tbl_domestic_booking.*,s.city as sender_city, r.city as reciever_city, tbl_customers.cid,tbl_customers.customer_name
		FROM `tbl_domestic_booking`
		JOIN tbl_customers ON tbl_domestic_booking.customer_id = tbl_customers.customer_id
		left join city as s ON s.id = tbl_domestic_booking.sender_city
		left join city as r ON r.id = tbl_domestic_booking.reciever_city
		WHERE tbl_customers.sales_person_id = $user_id ")->result_array();

        $file = fopen('php://output', 'w');
        $header = array("AWB NO", "Customer Name","Customer ID","Booking Date", "Sender Pincode", "Sender City","Reciever Pincode","Reciever City", "Rate", "Amount");
        fputcsv($file, $header);
        foreach ($get_customer_shipment as $key => $line) {

            $data = array(

                $line['pod_no'],
                $line['customer_name'],
                $line['customer_id'],              
                $line['booking_date'],
                $line['sender_pincode'],
                $line['sender_city'],
                $line['reciever_pincode'],
                $line['reciever_city'],
                $line['rate'],
                $line['sub_total'],
            );


            fputcsv($file, $data);
        }
        fclose($file);
        exit;
    }
   

	function custmermail_template($value)
	{
		$custmermail_template = '<!DOCTYPE html><html><head><title>parvatiheritage.com</title>
   <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
   <style>
	   body{ font-family: "Poppins", sans-serif; font-weight: 400; font-size: 15px;line-height: 1.8;color: rgba(0,0,0,.7); background: white;max-width:600px; margin:10px auto 0;}
	   .text-author{ border: 1px solid rgba(0,0,0,.05); padding: 2.2em;line-height: 2;}
   </style></head>
   <body>
	 <div style="width:600px;">
	   <table  cellspacing="0" width="100%">
		   <div>
			   <div style="text-align: center; border-bottom:4px solid  #e83b3e;"><a href="#"> <img src="https://parvatiheritage.com/assets/parvati logo.png" style="margin-top: 8px; margin-bottom: 4px; height: 54px;width:auto;"></a>                
			   </div>
			   </div>
		   
	   </table>
	<table width="100%" >
		   <tr>
			   <td style="text-align: left;">
			   
				<div class="text-author">
				<p style="float: left;"><h3 style="text-align: center; color: #212121;">Hii<br> ' . $value['email'] . '</h3>
				   <p style="text-align: left;">Thank You for Your Enquiry</p>
				   <strong>Name : ' . $value['email'] . '
					   <br>Email : ' . $value['email'] . '
					   <br>Contact No : ' . $value['email'] . '
					   <br>Message : ' . $value['email'] . '
					  
				   </strong></p>
			   
					<p >We Have Received your request.Our Customer service Executive will contact to You Soon!</p>
			   
				</div>
				
			   <p style=" background:#e83b3e; padding: 4px;color:white; margin: 0; text-align: center;">@2021<span style="color:#f05a2a;">parvatiheritage.com <span></p>
		   </td></tr></table></div>

	   </body></html>';
		return $custmermail_template;
	}

} 