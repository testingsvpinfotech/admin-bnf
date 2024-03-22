<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_other_branch_booking extends CI_Controller  {

	var $data = array();
    function __construct() 
	{
        parent :: __construct();
        $this->load->model('basic_operation_m'); 
        $this->load->model('Rate_model');   
        $this->load->model('booking_model');
		if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}

    }
	
	
	   	public function view_domestic_shipment() 
	{	
		        $branch_id = $_SESSION['branch_id'];
				// print_r( $branch_id);die;
				$data['allpoddata'] = $this->db->query("SELECT tbl_customers.cid,tbl_customers.customer_name,tbl_customers.branch_id as branch_name,tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking JOIN tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id Where tbl_customers.branch_id = '$branch_id' and tbl_customers.customer_type = '0' and tbl_domestic_booking.branch_id != '$branch_id'")->result_array();
				// $data['allpoddata'] = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND company_type='Domestic' AND tbl_domestic_booking.user_type !=5 GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit")->result_array();
		    $data['viewVerified'] = 2;
			$this->load->view('admin/domestic_shipment/view_domestic_other_branch_shipment', $data);
		
        
	}


}

?>
