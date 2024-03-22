<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor_controller extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('basic_operation_m');
    if (!$this->session->userdata('customer_id')) {
      redirect(base_url() . 'login');
    }
    $this->load->library('session');
  }

  //    public function truck_post(){

  //     if(isset($_POST['submit'])){

  //       $data = array(
  //         'return_tip'=>$this->input->post('return_tip'),
  //         'source_city'=>$this->input->post('source_city'),
  //         'destination_city'=>$this->input->post('destination_city'),
  //         'truck_id'=>$this->input->post('truck_id'),
  //         'truck_number'=>$this->input->post('truck_number'),
  //         'available_date'=>$this->input->post('available_date'),
  //       );

  //       $this->db->insert('post_truck_tbl',$data);
  //       redirect(base_url().'truck-post');
  //       $this->session->flashdata('msg','Data Inserted Successfully');

  //   }else{
  //   $this->load->view('vendor/include/header');
  //   $data['vehicle_name'] = $this->db->query('SELECT * FROM `vehicle_master`')->result_array();
  //   $this->load->view('vendor/post_truck',$data);
  //   $this->load->view('vendor/include/footer');
  //  }
  // } 



  public function truck_post()
  {

    if (isset($_POST['submit'])) {

      $data = array(
        'vehicle_name' => $this->input->post('vehicle_name'),
        'body_type' => $this->input->post('vehicle_body_type'),
        'capicty' => $this->input->post('vehicle_capacity'),
        'fuel_type' => $this->input->post('fuel_type'),
      );

      $this->db->insert('vehicle_type_master', $data);

      $last_id = $this->db->insert_id();
      // print_r($last_id);exit;
      $customer_id = $this->session->userdata('customer_id');
      //  if(!empty($last_id)){

      $data = array(

        'vehicle_id' => $last_id,
        'vendor_customer_id' => $customer_id,
        'vehicle_registration' => $this->input->post('vehicle_registeration'),
        'vehicle_number' => $this->input->post('truck_number'),
        'vehicle_chesis' => $this->input->post('vehicle_chesis'),
        'vehicle_model' => $this->input->post('vehicle_model'),
        'vehicle_puc_date' => $this->input->post('vehicle_puc_date'),
        'vehicle_fit_exp_date' => $this->input->post('vehicle_fitnes_expiry_date'),
        // 'vehicle_per_renw_date'=>$this->input->post('vehicle_renew_date'),
        'vehicle_prmit_date' => $this->input->post('vehicle_prmit_date'),
        'vehicle_insurance_renw' => $this->input->post('vehicle_insurance_renew'),
        // 'vehicle_per_renw_date'=>$this->input->post('vehicle_renew_date'),
      );
      //  print_r($data);exit;
      $this->db->insert('vehicle_master', $data);
      // }
      $this->session->Set_flashdata('msg', 'Data Inserted Successfully!!');
      redirect(base_url() . 'truck-post');
    } else {
      $this->load->view('vendor/include/header');
      $data['vehicle_name'] = $this->db->query('SELECT * FROM `vehicle_master`')->result_array();
      $this->load->view('vendor/post_truck', $data);
      $this->load->view('vendor/include/footer');
    }
  }

  public function calculate_freight()
  {
    //echo 'hello';exit;
    $this->load->view('vendor/include/header');
    $this->load->view('vendor/calculatefreight');
    $this->load->view('vendor/include/footer');
  }

  public function logout()
  {
    $this->session->unset_userdata('customer_id');
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('vcode');
    $this->session->sess_destroy();
    redirect(base_url() . 'login');
  }

  public function dashboard()
  {
    $this->load->view('vendor/include/header');
    $data['total_order'] = $this->db->query(" SELECT count(ftl_request_id) as total  FROM `ftl_request_tbl` WHERE status = '1'")->result_array();
    $this->load->view('vendor/vendor_dashboard', $data);
    $this->load->view('vendor/include/footer');
  }

  public function truck_posted_list()
  {
    $this->load->view('vendor/include/header');
    $id = $this->session->userdata('customer_id');
    $data['Vehicle_list'] = $this->db->query("select vehicle_type_master.*,vehicle_master.vehicle_insurance_renw,vehicle_master.vehicle_prmit_date,vehicle_master.vehicle_number,vehicle_master.vehicle_model,vehicle_master.vehicle_puc_date,vehicle_master.vehicle_per_renw_date from  vehicle_type_master INNER JOIN vehicle_master ON vehicle_type_master.id = vehicle_master.vehicle_id where vehicle_master.vendor_customer_id = '$id'")->result_array();
    //echo $this->db->last_query();exit;
    $this->load->view('vendor/truck_posted_list', $data);
    $this->load->view('vendor/include/footer');
  }

  public function ftl_request_for_vendor($id)
  {
    // echo 'hello'; exit;
    $this->load->view('vendor/include/header');
    // $id = $this->session->userdata('customer_id');
    $data['ftl_request_data'] = $this->db->query("select * from ftl_request_tbl where  id = '$id' AND status ='1'")->result_array();
    $this->load->view('vendor/truck_order', $data);
    $this->load->view('vendor/include/footer');
  }

  public function vendor_request_for_truck()
  {
    $customer_id  = $this->session->userdata('customer_id');
    $request_id = $this->input->post('request_id');
    $vehicle_number = $this->input->post('vehicle_number');
    $vendor_amount = $this->input->post('vendor_amount');
    $contact_number = $this->input->post('contact_number');
    // $customer_id = $this->input->post('customer_id');
    $advance_amount_percentage = $this->input->post('advance_amount_percentage');
    $advance_amount = $this->input->post('advance_amount');
    $remaining_amount = $this->input->post('remaining_amount');

    $data = array(
      'vendor_customer_id' => $customer_id,
      'ftl_request_id' => $request_id,
      'vendor_amount' => $vendor_amount,
      'advance_amount_percentage' => $advance_amount_percentage,
      'advance_amount' => $advance_amount,
      'remaining_amount' => $remaining_amount,
      'request_status' => 1,
    );

    // print_r($data);exit;

    $this->db->insert('order_request_tabel', $data);
    $this->session->set_flashdata('msg', 'Request Send Successfully!');
    redirect(base_url() . 'dashboard');

    //  }
    //  $this->session->set_flashdata('msg', 'Request Send Successfully!');
    //  redirect(base_url().'dashboard');
  }

  public function truck_request_list_from_vendor($offset = '0')
  {

    $this->load->view('vendor/include/header');
    $customer_id = $this->session->userdata('customer_id');
    $resAct = $this->db->query("select ftl_request_tbl.*,order_request_tabel.ftl_request_id as fid ,order_request_tabel.vendor_amount,order_request_tabel.advance_amount_percentage,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,order_request_tabel.trafic_approve_status from ftl_request_tbl inner join order_request_tabel ON ftl_request_tbl.id = order_request_tabel.ftl_request_id where order_request_tabel.vendor_customer_id = '$customer_id' order by ftl_request_id DESC limit " . $offset . ",50");
    $resActt = $this->db->query("select ftl_request_tbl.*,order_request_tabel.ftl_request_id as fid ,order_request_tabel.vendor_amount,order_request_tabel.advance_amount_percentage,order_request_tabel.advance_amount,order_request_tabel.remaining_amount,order_request_tabel.trafic_approve_status from ftl_request_tbl inner join order_request_tabel ON ftl_request_tbl.id = order_request_tabel.ftl_request_id where order_request_tabel.vendor_customer_id = '$customer_id'");

    $this->load->library('pagination');

    $data['total_count']      = $resActt->num_rows();
    $config['total_rows']       = $resActt->num_rows();
    $config['base_url']       = 'quotation-request-list/';
    //	$config['suffix'] 				= '/'.urlencode($filterCond);

    $config['per_page']          = 50;
    $config['full_tag_open']      = '<nav aria-label="..."><ul class="pagination">';
    $config['full_tag_close']     = '</ul></nav>';
    $config['first_link']         = '&laquo; First';
    $config['first_tag_open']      = '<li class="prev paginate_button page-item">';
    $config['first_tag_close']     = '</li>';
    $config['last_link']           = 'Last &raquo;';
    $config['last_tag_open']     = '<li class="next paginate_button page-item">';
    $config['last_tag_close']     = '</li>';
    $config['next_link']       = 'Next';
    $config['next_tag_open']     = '<li class="next paginate_button page-item">';
    $config['next_tag_close']     = '</li>';
    $config['prev_link']       = 'Previous';
    $config['prev_tag_open']     = '<li class="prev paginate_button page-item">';
    $config['prev_tag_close']     = '</li>';
    $config['cur_tag_open']     = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
    $config['cur_tag_close']     = '</a></li>';
    $config['num_tag_open']     = '<li class="paginate_button page-item">';
    $config['reuse_query_string']   = TRUE;
    $config['num_tag_close']     = '</li>';
    $config['attributes'] = array('class' => 'page-link');

    if ($offset == '') {
      $config['uri_segment']       = 3;
      $data['serial_no']        = 1;
    } else {
      $config['uri_segment']       = 3;
      $data['serial_no']    = $offset + 1;
    }


    $this->pagination->initialize($config);
    if ($resAct->num_rows() > 0) {
      $data['request_list_from_vendor']  = $resAct->result_array();
    } else {
      $data['request_list_from_vendor']  = array();
    }

    $this->load->view('vendor/quotation_requested_list', $data);
    $this->load->view('vendor/include/footer');
  }
  public function update_driver_details($id)
  {
    //echo 'hello';exit;
    if (isset($_POST['submit'])) {
      $customer_id  = $this->session->userdata('customer_id');

      $v = $this->input->post('rc_book');
      if (isset($_FILES) && !empty($_FILES['rc_book']['name'])) {
        $ret = $this->basic_operation_m->fileUpload($_FILES['rc_book'], 'assets/ftl_documents/vendor_rc-book/');
        if ($ret['status'] && isset($ret['image_name'])) {
          $rc_book = $ret['image_name'];
        }
      }


      $data = array(
        'driver_name' => $this->input->post('driver_name'),
        //'vc_id' =>$customer_id,
        'driver_contact_number' => $this->input->post('driver_contact_number'),
        'vehicle_number' => $this->input->post('vehicle_number'),
        //'ping_time' => $this->input->post('ping_time'),
        'driver_licence' => $this->input->post('driver_licence'),
        'rc_book' => $rc_book,
      );

      $this->db->where('ftl_request_id', $id);
      $this->db->update('ftl_request_tbl', $data);
      // echo $this->db->last_query();exit;
      $this->session->Set_flashdata('msg', "Driver details has been successfully updated.");
      redirect(base_url() . 'vendor/quotation-request-list');
    } else {
      $this->load->view('vendor/include/header');
      $data['update_driver'] = $this->db->query("select * from ftl_request_tbl where ftl_request_id ='$id'")->row_array();
      //print_r($data['update_driver']);
      $this->load->view('vendor/get_driver_details', $data);
      $this->load->view('vendor/include/footer');
    }
  }
}
