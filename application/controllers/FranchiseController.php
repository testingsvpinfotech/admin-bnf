<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class FranchiseController extends CI_Controller
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
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        // print_r($this->session->all_userdata());die;
        $branch_id = $this->session->userdata('branch_id');
        $user_id = $this->session->userdata('userId');
        $userType = $this->session->userdata('userType');
     
       
        if(isset($_POST['Filter'])){
              $customer = $this->input->post('customer');
              $where = "tbl_customers.customer_name = '$customer'";
            if( $branch_id == '1' && $userType == '1' OR $user_id == '1' ){
                $data['allfranchise'] = $this->Franchise_model->get_franchise_details($where);
              }else{
                  $data['allfranchise'] = $this->Franchise_model->get_franchise_branch_wise($where); 
              }
              
              if(isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report')
              {
                  $this->domestic_shipment_report($data['allfranchise']);
              }
        }else{
            
            if( $branch_id == '1' && $userType == '1' OR $user_id == '1' ){
                $data['allfranchise'] = $this->Franchise_model->get_franchise_details();
              }else{
                  $data['allfranchise'] = $this->Franchise_model->get_franchise_branch_wise(); 
              }
            //   echo $this->db->last_query();die;
              if(isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report')
              {  
                 $allfranchise = $data['allfranchise'];
                  $this->domestic_shipment_report($allfranchise);
              }
        }
       
        // echo '<pre>';print_r($data['allfranchise']);die;
      
        $this->load->view('admin/franchise_master/view_franchise', $data);
    }

    public function domestic_shipment_report($allfranchise)
    {    
     $date=date('d-m-Y');
     $filename = "SipmentDetails_".$date.".csv";
     $fp = fopen('php://output', 'w');
         
     $header =array("Sr No.","C.Code","Franchise","Master Franchise Name","Company","Email","Phone","City","State","Address","Pincode","Gstno","Branch Name	","Area","Sale Person Name","Sale Person Branch","Franchise Created	","Password");

         
     header('Content-type: application/csv');
     header('Content-Disposition: attachment; filename='.$filename);

     fputcsv($fp, $header);
     $i =0;
    //  echo '<pre>';print_r($allfranchise);die;
     foreach($allfranchise as $row) 
     {  
        $city_id = $row['city'];
        $city = $this->db->query("select city from city where id = $city_id")->row();
        $state_id = $row['state'];
        $state = $this->db->query("select state from state where id = $state_id")->row();
        $branch_id = $row['branch_id'];
        if(!empty($row['customer_id'])){
            $master_franchise = $this->db->query("SELECT * FROM franchise_delivery_tbl WHERE delivery_franchise_id ='".$row['customer_id']."'" )->ROW(); 
        }
        if(!empty($row['sale_person'])){
            $sale_person1 = $this->db->query("SELECT * FROM tbl_users WHERE user_id ='".$row['sale_person']."'" )->ROW(); 
            $sale_person = $sale_person1->username; 
        }else{
            $sale_person = "";
        }
        if(!empty($row['sale_person'])){
           $branch_name1 = $this->db->query("SELECT * FROM tbl_branch WHERE branch_id ='".$sale_person1->branch_id."'" )->ROW(); 
           $sale_branch_name = $branch_name1->branch_name;
        }else{
            $sale_branch_name = "";
        }
        //print_r($cust['branch_id']);
          $branch_name =  $this->db->query("select branch_name from tbl_branch where branch_id = '$branch_id'")->row_array();
          $franchise_id = $row['franchise_id'];
         $val =  $this->db->query("Select * from tbl_franchise where franchise_id = '$franchise_id'")->row();
         $i++;
         if ($this->session->userdata("userType") == 1) {
            $password = $row['password'];
         }else{
            $password = '';
         }
         $row=array(
             $i,
             $row['cid'],
             $row['customer_name'],
             $master_franchise->master_franchise_name,
             $row['company_name'],
             $row['email'],
             $row['phone'],
             $city->city,
             $state->state,         
             $row['address'],
             $row['pincode'],
             $row['gstno'],
             @$branch_name['branch_name'],
             $val->cmp_area,
             $sale_person,
             $sale_branch_name,
             date('d-m-Y',strtotime($row['register_date'])),
             $password
            
         );
         
         
         fputcsv($fp, $row);
     }
     exit;
    }
    public function deleted_frainchise()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        // print_r($this->session->all_userdata());die;
        $branch_id = $this->session->userdata('branch_id');
        $user_id = $this->session->userdata('userId');
        $userType = $this->session->userdata('userType');
        if( $branch_id == '1' && $userType == '1' OR $user_id == '1' ){
          $data['allfranchise'] = $this->Franchise_model->get_franchise_details_active();
        }else{
            $data['allfranchise'] = $this->Franchise_model->get_franchise_branch_wise_active(); 
        }
        
        $this->load->view('admin/franchise_master/view_deleted_frainchise', $data);
    }


    public function add_franchise()
    {

        $query = "SELECT MAX(customer_id) as id FROM tbl_customers ";
        $result1 = $this->basic_operation_m->get_query_row($query);
        $id = $result1->id + 1;
        //print_r($id); exit;

        if (strlen($id) == 1) {
            $franchise_id = 'FI0000' . $id;
        } elseif (strlen($id) == 2) {
            $franchise_id = 'FI000' . $id;
        } elseif (strlen($id) == 3) {
            $franchise_id = 'FI00' . $id;
        } elseif (strlen($id) == 4) {
            $franchise_id = 'FI0' . $id;
        } elseif (strlen($id) == 5) {
            $franchise_id = 'FI' . $id;
        }
        $data['branch'] = $this->basic_operation_m->get_all_result('tbl_branch', '');
        $data['cities'] = $this->basic_operation_m->get_all_result('city', '');
        $data['states'] =  $this->basic_operation_m->get_all_result('state', '');
        $data['fid']    =   $franchise_id;
        $data['rate_group'] = $this->db->query("select tbl_franchise_rate_master.*, tbl_rate_group_master.group_name as group_name from tbl_franchise_rate_master left join tbl_rate_group_master on tbl_rate_group_master.id = tbl_franchise_rate_master.group_id Group By tbl_franchise_rate_master.group_id")->result();
        $data['fuel_group'] = $this->db->query("select franchise_fule_tbl.*, tbl_rate_group_master.group_name as group_name from franchise_fule_tbl left join tbl_rate_group_master on tbl_rate_group_master.id = franchise_fule_tbl.group_id Group By franchise_fule_tbl.fuel_id")->result();
        $data['delivery_rate_group'] = $this->db->query("select  franchise_delivery_rate_tbl.*, tbl_rate_group_master.group_name as group_name from franchise_delivery_rate_tbl left join tbl_rate_group_master on tbl_rate_group_master.id = franchise_delivery_rate_tbl.group_id Group By franchise_delivery_rate_tbl.delivery_rate_id")->result();

        $data['company_list'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_company WHERE 1 ORDER BY company_name ASC');
        $data['sale_person'] = $this->db->get_where('tbl_users',['user_type' => 6])->result();
        $data['commission'] = $this->db->get_where('tbl_comission_master',['is_deleted'=>0])->result();
        $this->load->view('admin/franchise_master/add_franchise', $data);
    }



    public function store_franchise_data()
    {

       
        // *********************************  pancard upload ****************
        $v = $this->input->post('pancard_photo');
        if (isset($_FILES) && !empty($_FILES['pancard_photo']['name'])) {
            $ret = $this->basic_operation_m->fileUpload($_FILES['pancard_photo'], 'assets/franchise-documents/pancard_document/');
            //file is uploaded successfully then do on thing add entry to table
            if ($ret['status'] && isset($ret['image_name'])) {
                $pancard_photo = $ret['image_name'];
            }
        }
        // ********************************* AadharCard upload ****************     
        $v = $this->input->post('aadharcard_photo');
        if (isset($_FILES) && !empty($_FILES['aadharcard_photo']['name'])) {
            $ret = $this->basic_operation_m->fileUpload($_FILES['aadharcard_photo'], 'assets/franchise-documents/aadharcard_document/');
            //file is uploaded successfully then do on thing add entry to table
            if ($ret['status'] && isset($ret['image_name'])) {
                $aadharcard_photo = $ret['image_name'];
            }
        }
        // ********************************* Cancel Check upload ****************     
        $v = $this->input->post('cancel_check');
        if (isset($_FILES) && !empty($_FILES['cancel_check']['name'])) {
            $ret = $this->basic_operation_m->fileUpload($_FILES['cancel_check'], 'assets/franchise-documents/bank_document/');
            //file is uploaded successfully then do on thing add entry to table
            if ($ret['status'] && isset($ret['image_name'])) {
                $cancel_check = $ret['image_name'];
            }
        }
        $date = date('Y-m-d');

        $data = array(
            'cid' => $this->input->post('fid'),
            'password' => $this->input->post('password'),
            'customer_name' => $this->input->post('franchise_name'), //****Personal Info
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'pincode' => $this->input->post('pincode'),
            'state' => $this->input->post('franchaise_state_id'),
            'city' => $this->input->post('franchaise_city_id'),
            'phone' => $this->input->post('contact_number'),
            'contact_person' => $this->input->post('alt_contact'),
            'company_id' => $this->input->post('companytype'),
            'branch_id' => $this->input->post('branch_id'),
            'parent_cust_id' => $this->input->post('customer_id'),
            'sale_person' => $this->input->post('sale_person'),
            'customer_type' => 2,
            'register_date' => $date,
        );

        $result = $this->db->insert('tbl_customers', $data);

        $customer_last_id = $this->db->insert_id();

        $data1 = array(

            'fid' => $customer_last_id,
            'franchise_relation' => $this->input->post('franchise_relation'),
            'age' => $this->input->post('age'),
            'pan_name' => $this->input->post('pan_name'),
            'pan_number' => $this->input->post('pan_number'),
            'pancard_photo' => $pancard_photo,
            'aadhar_number' => $this->input->post('aadhar_number'),
            'aadharin_name' => $this->input->post('aadharin_name'),
            'dob' => $this->input->post('dob'),
            'gender' => $this->input->post('gender'),
            'aadhar_address' => $this->input->post('aadhar_address'),
            'aadharcard_photo' => $aadharcard_photo,
            'company_name' => $this->input->post('company_name'), // ****company information
            'cmp_pan_number' => $this->input->post('cmp_pan_number'),
            'cmp_gstno' => $this->input->post('cmp_gstno'),
            'legal_name' => $this->input->post('legal_name'),
            'constitution_of_business' => $this->input->post('constitution_of_business'),
            'taxpayer_type' => $this->input->post('taxpayer_type'),
            'gstin_status' => $this->input->post('gstin_status'),
            'cmp_address' => $this->input->post('cmp_address'),
            'cmp_pincode' => $this->input->post('cmp_pincode'),
            'cmp_state' => $this->input->post('cmp_state'),
            'cmp_city' => $this->input->post('cmp_city'),
            'cmp_office_phone' => $this->input->post('cmp_office_phone'),
            'cmp_area' => $this->input->post('cmp_area'),
            'cmp_account_name' => $this->input->post('cmp_account_name'), //*****Bank Details
            'cmp_account_number' => $this->input->post('cmp_account_number'),
            'cancel_check' => $cancel_check,
            'cmp_bank_name' => $this->input->post('cmp_bank_name'),
            'cmp_bank_branch' => $this->input->post('cmp_bank_branch'),
            'cmp_acc_type' => $this->input->post('cmp_acc_type'),
            'cmp_ifsc_code' => $this->input->post('cmp_ifsc_code'),
            'credit_limit' => $this->input->post('credit_limit'),
            'credit_days' => $this->input->post('credit_days'),
            'sale_person' => $this->input->post('sale_person')

        );
       

        $result = $this->db->insert('tbl_franchise', $data1);

        //  print_r($result);exit;

        $delivery_pincode1 = $this->input->post('delivery_pincode[]');
        $delivery_pincode1 = implode(',', $delivery_pincode1);
        $delivery_pincode =  $delivery_pincode1;
        $delivery_city1 = $this->input->post('delivery_city[]');
        $delivery_city1 = implode(',', $delivery_city1);
        $delivery_city = $delivery_city1;

        $data2 = array(

            'delivery_franchise_id' => $customer_last_id,
            'master_franchise_name' => $this->input->post('master_franchise_name'),
            'delivery_status' => $this->input->post('delivery_status'),
            'rate_group' => $this->input->post('rate_group'),
            'delivery_pincode' => $delivery_pincode,
            'delivery_city' => $delivery_city,
            'fule_group' => $this->input->post('fule_group'),
            'delivery_rate_group' => $this->input->post('delivery_rate_group')
        );

        //    print_r($data2);exit;
        $result = $this->basic_operation_m->insert('franchise_delivery_tbl', $data2);
        if (!empty($result)) {
            $msg            = 'Franchise added successfully';
            $class            = 'alert alert-success alert-dismissible';
        } else {
            $msg            = 'Franchise not added successfully';
            $class            = 'alert alert-danger alert-dismissible';
        }
        $this->session->set_flashdata('notify', $msg);
        $this->session->set_flashdata('class', $class);

        redirect('admin/franchise-list');
    }


    public function getCityList()
    {
        $pincode = $this->input->post('pincode');
        $whr1 = array('pin_code' => $pincode);
        $res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

        $city_id = $res1->row()->city_id;

        $whr2 = array('id' => $city_id);
        $res2 = $this->basic_operation_m->selectRecord('city', $whr2);
        $result2 = $res2->row();

        echo json_encode($result2);
    }

    public function getState()
    {
        $pincode = $this->input->post('pincode');
        $whr1 = array('pin_code' => $pincode);
        $res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

        $state_id = $res1->row()->state_id;
        $whr3 = array('id' => $state_id);
        $res3 = $this->basic_operation_m->selectRecord('state', $whr3);
        $result3 = $res3->row();

        echo json_encode($result3);
    }
    public function getCityList1()
    {
        $pincode = $this->input->post('cmppincode');
        $whr1 = array('pin_code' => $pincode);
        $res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

        $city_id = $res1->row()->city_id;

        $whr2 = array('id' => $city_id);
        $res2 = $this->basic_operation_m->selectRecord('city', $whr2);
        $result2 = $res2->row();

        echo json_encode($result2);
    }

    public function getState1()
    {
        $pincode = $this->input->post('cmppincode');
        $whr1 = array('pin_code' => $pincode);
        $res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

        $state_id = $res1->row()->state_id;
        $whr3 = array('id' => $state_id);
        $res3 = $this->basic_operation_m->selectRecord('state', $whr3);
        $result3 = $res3->row();

        echo json_encode($result3);
    }


    function update_franchise_data($id)
    {
        $date = date('Y-m-d');
        $data['message'] = "";
        if ($id != "") {
            $whr1 = array('customer_id' => $id);
            $data['customer'] = $this->basic_operation_m->get_table_row('tbl_customers', $whr1);
        }
        if ($id != "") {
            $whr = array('fid' => $id);
            $data['franchise_data'] = $this->basic_operation_m->get_table_row('tbl_franchise', $whr);
        }

        if ($id != "") {
            $whr1 = array('delivery_franchise_id' => $id);
            //$whr1 = array('delivery_franchise_id' => $id);
            $data['delivery_franchise_data'] = $this->basic_operation_m->get_table_row('franchise_delivery_tbl', $whr1);
        }
        $data['branch'] = $this->basic_operation_m->get_all_result('tbl_branch', '');
        $data['cities'] = $this->basic_operation_m->get_all_result('city', '');
        $data['states'] = $this->basic_operation_m->get_all_result('state', '');
        $data['rate_group'] = $this->db->query("select tbl_franchise_rate_master.*, tbl_rate_group_master.group_name as group_name from tbl_franchise_rate_master join tbl_rate_group_master on tbl_rate_group_master.id = tbl_franchise_rate_master.group_id Group By tbl_franchise_rate_master.group_id")->result();
        $data['fuel_group'] = $this->db->query("select franchise_fule_tbl.*, tbl_rate_group_master.group_name as group_name from franchise_fule_tbl left join tbl_rate_group_master on tbl_rate_group_master.id = franchise_fule_tbl.group_id Group By franchise_fule_tbl.fuel_id")->result();
        $data['delivery_rate_group'] = $this->db->query("select  franchise_delivery_rate_tbl.*, tbl_rate_group_master.group_name as group_name from franchise_delivery_rate_tbl left join tbl_rate_group_master on tbl_rate_group_master.id = franchise_delivery_rate_tbl.group_id Group By franchise_delivery_rate_tbl.delivery_rate_id")->result();
        $data['sale_person'] = $this->db->get_where('tbl_users',['user_type' => 6])->result();
        $data['commission'] = $this->db->get_where('tbl_comission_master')->result();
        $this->load->view('admin/franchise_master/update_franchise_data', $data);
    }
  
    function update_franchise_data_in($customer_id)
    {
        if (isset($_POST['submit'])) {
            $last = $this->uri->total_segments();
            $id = $this->uri->segment($last);
            $whr1 = array('customer_id' => $customer_id);

            $data = array(
                'password' => $this->input->post('password'),
                'customer_name' => $this->input->post('franchise_name'), //****Personal Info
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'pincode' => $this->input->post('pincode'),
                'state' => $this->input->post('franchaise_state_id'),
                'city' => $this->input->post('franchaise_city_id'),
                'phone' => $this->input->post('contact_number'),
                'contact_person' => $this->input->post('alt_contact'),
                'company_id' => $this->input->post('companytype'),
                'branch_id' => $this->input->post('branch_id'),
                'parent_cust_id' => $this->input->post('customer_id'),
                'sale_person' => $this->input->post('sale_person'),
                'franchise_booking_type' => $this->input->post('franchise_booking_type')
            );
            //print_r($data);
            $franchise = $this->basic_operation_m->update('tbl_customers', $data, $whr1);
            //echo $this->db->last_query();exit;


            $v = $this->input->post('pancard_photo');
            if (!empty($_FILES['pancard_photo']['name'])) {
                if (isset($_FILES) && !empty($_FILES['pancard_photo']['name'])) {
                    $ret = $this->basic_operation_m->fileUpload($_FILES['pancard_photo'], 'assets/franchise-documents/pancard_document/');
                    //file is uploaded successfully then do on thing add entry to table
                    if ($ret['status'] && isset($ret['image_name'])) {
                        $pancard_photo = $ret['image_name'];
                        $this->db->set('pancard_photo', $pancard_photo);
                        $this->db->where('fid', $fid);
                    }
                }
            }
            // ********************************* AadharCard upload **************** 
            $v = $this->input->post('aadharcard_photo');
            if (!empty($_FILES['aadharcard_photo']['name'])) {
                if (isset($_FILES) && !empty($_FILES['aadharcard_photo']['name'])) {
                    $ret = $this->basic_operation_m->fileUpload($_FILES['aadharcard_photo'], 'assets/franchise-documents/aadharcard_document/');
                    //file is uploaded successfully then do on thing add entry to table
                    if ($ret['status'] && isset($ret['image_name'])) {
                        $aadharcard_photo = $ret['image_name'];
                        $this->db->set('aadharcard_photo', $aadharcard_photo);
                        $this->db->where('fid', $fid);
                        $this->db->update('tbl_franchise');
                    }
                }
            }
            // ********************************* Cancel Check upload ****************     
            $v = $this->input->post('cancel_check');
            //   print_r($_FILES['cancel_check']['name']);exit;
            if (!empty($_FILES['cancel_check']['name'])) {
                if (isset($_FILES) && !empty($_FILES['cancel_check']['name'])) {
                    $ret = $this->basic_operation_m->fileUpload($_FILES['cancel_check'], 'assets/franchise-documents/bank_document/');
                    //file is uploaded successfully then do on thing add entry to table
                    if ($ret['status'] && isset($ret['image_name'])) {
                        $cancel_check = $ret['image_name'];
                        $this->db->set('cancel_check', $cancel_check);
                        $this->db->where('fid', $fid);
                        $this->db->update('tbl_franchise');
                        //  echo $this->db->last_query();exit;
                    }
                }
            }
           

            $whr2 = array('fid' => $customer_id);
            $data1 = array(

                'franchise_relation' => $this->input->post('franchise_relation'),
                'age' => $this->input->post('age'),
                'pan_name' => $this->input->post('pan_name'),
                'pan_number' => $this->input->post('pan_number'),
                // 'pancard_photo' => $pancard_photo,
                'aadhar_number' => $this->input->post('aadhar_number'),
                'aadharin_name' => $this->input->post('aadharin_name'),
                'dob' => $this->input->post('dob'),
                'gender' => $this->input->post('gender'),
                'aadhar_address' => $this->input->post('aadhar_address'),

                'company_name' => $this->input->post('company_name'), // ****company information
                'cmp_pan_number' => $this->input->post('cmp_pan_number'),
                'cmp_gstno' => $this->input->post('cmp_gstno'),
                'legal_name' => $this->input->post('legal_name'),
                'constitution_of_business' => $this->input->post('constitution_of_business'),
                'taxpayer_type' => $this->input->post('taxpayer_type'),
                'gstin_status' => $this->input->post('gstin_status'),
                'cmp_address' => $this->input->post('cmp_address'),
                'cmp_pincode' => $this->input->post('cmp_pincode'),
                'cmp_state' => $this->input->post('cmp_state'),
                'cmp_city' => $this->input->post('cmp_city'),
                'cmp_office_phone' => $this->input->post('cmp_office_phone'),
                'cmp_area' => $this->input->post('cmp_area'),
                'cmp_account_name' => $this->input->post('cmp_account_name'), //*****Bank Details
                'cmp_account_number' => $this->input->post('cmp_account_number'),
                'cmp_bank_name' => $this->input->post('cmp_bank_name'),
                'cmp_bank_branch' => $this->input->post('cmp_bank_branch'),
                'cmp_acc_type' => $this->input->post('cmp_acc_type'),
                'cmp_ifsc_code' => $this->input->post('cmp_ifsc_code'),
                'sale_person' => $this->input->post('sale_person')

            );
            if($this->input->post('franchise_booking_type')==2){
                
                $data1['credit_limit'] = "0.00";
                $data1['credit_days']= "0";
                $data1['commision_id'] = "0";
            }else{
                $data1['credit_limit'] = $this->input->post('credit_limit');
                $data1['credit_days']= $this->input->post('credit_days');
                $data1['commision_id'] = $this->input->post('commision_id');
            }
         
            $franchise = $this->basic_operation_m->update('tbl_franchise', $data1, $whr2);
            //  echo $this->db->last_query();exit;
            $delivery_pincode1 = $this->input->post('frpincode[]');
            if(!empty($delivery_pincode1)){
            $delivery_pincode1 = implode(',', $delivery_pincode1);
            $delivery_pincode = $delivery_pincode1;
            $data2123['delivery_pincode'] = $delivery_pincode;
            }
            $delivery_city1 = $this->input->post('frcity_id[]');
            if(!empty($delivery_city1)){
              $delivery_city1 = implode(',', $delivery_city1);
              $delivery_city = $delivery_city1;
              $data2123['delivery_pincode'] = $delivery_city;
            }
           

            // $whr3 = array('delivery_franchise_id' => $delivery_franchise_id);
            $data2123 = array(
                'delivery_franchise_id' => $id,
                'master_franchise_name' => $this->input->post('franchise_name'),
                'delivery_status' => $this->input->post('delivery_status'),
                'rate_group' => $this->input->post('rate_group'),
                'fule_group' => $this->input->post('fule_group'),
                'delivery_rate_group' => $this->input->post('delivery_rate_group')
            );

            $franchise = $this->basic_operation_m->update('franchise_delivery_tbl', $data2123, ['delivery_franchise_id' => $id]);

            if (empty($franchise)) {
                $msg            = 'Customer updated successfully';
                $class            = 'alert alert-success alert-dismissible';
            } else {
                $msg            = 'Customer not updated successfully';
                $class            = 'alert alert-danger alert-dismissible';
            }
            $this->session->set_flashdata('notify', $msg);
            $this->session->set_flashdata('class', $class);

            redirect('admin/franchise-list');
        }
        redirect('admin/franchise-list');
    }


    public function deleteFranchiseData()
    {
        $getId = $this->input->post('getid');
        $data =  $this->db->delete('tbl_customers', array('customer_id' => $getId));
        $data =  $this->db->delete('tbl_franchise', array('franchise_id' => $getId));
        $data =  $this->db->delete('franchise_delivery_tbl', array('delivery_franchise_id' => $getId));
        $data =  $this->db->delete('franchise_assign_pincode', array('customer_id' => $getId));
        // echo $this->db->last_query();
        if ($data) {
            $output['status'] = 'success';
            $output['message'] = 'Member deleted successfully';
        } else {
            $output['status'] = 'error';
            $output['message'] = 'Something went wrong in deleting the member';
        }

        echo json_encode($output);
    }
    public function deleteFranchiseData_tem()
    {
        $getId = $this->input->post('getid');
        $data =  $this->db->query("Update tbl_customers SET isdeleted ='1' WHERE `customer_id` = '$getId'");
    //   echo $this->db->last_query();die;
        if ($data) {
            $output['status'] = 'success';
            $output['message'] = 'Member deleted successfully';
        } else {
            $output['status'] = 'error';
            $output['message'] = 'Something went wrong in deleting the member';
        }

        echo json_encode($output);
    }
    public function deleteFranchiseData_active()
    {
        $getId = $this->input->post('getid');
        $data =  $this->db->query("Update tbl_customers SET isdeleted ='0' WHERE `customer_id` = '$getId'");
    //   echo $this->db->last_query();die;
        if ($data) {
            $output['status'] = 'success';
            $output['message'] = 'Member deleted successfully';
        } else {
            $output['status'] = 'error';
            $output['message'] = 'Something went wrong in deleting the member';
        }

        echo json_encode($output);
    }

    //****************************************GetFranchise MasterName */

    public function getFranchiseMaster()
    {

        $franchaise_city = $this->input->post('franchaise_city');
        // $pincode = $this->input->post('pincode');
        //   $data = $this->db->query("SELECT customer_id,customer_name,branch_id FROM `tbl_customers` WHERE customer_type = '1' AND pincode = '$pincode'")->row_array();
        $data = $this->db->query("SELECT customer_id,customer_name,branch_id FROM `tbl_customers` WHERE customer_type = '1' AND city = '$franchaise_city'")->row_array();
        // echo $this->db->last_query();

        echo json_encode($data);
    }

    public function get_delivery_pincode_city()
    {

        $pincode = $this->input->post('delivery_pincode');
        $whr1 = array('pin_code' => $pincode);
        $res1 = $this->basic_operation_m->selectRecord('pincode', $whr1);

        $city_id = $res1->row()->city_id;

        $whr2 = array('id' => $city_id);
        $res2 = $this->basic_operation_m->selectRecord('city', $whr2);
        $result2 = $res2->row();

        echo json_encode($result2);
    }


    // ********************************* Franchise Topup Balance *********************************************

    // public function franchise_topup_balance()
    // {
    //     $date = date('Y-m-d');
    //     if (isset($_POST['submit'])) {

    //         $query = "SELECT MAX(topup_balance_id) as id FROM franchise_topup_balance_tbl ";
    //         $result1 = $this->basic_operation_m->get_query_row($query);
    //         $id = $result1->id + 1;
    //         //print_r($id); exit;

    //         if (strlen($id) == 1) {
    //             $franchise_id = 'BFT100000' . $id;
    //         } elseif (strlen($id) == 2) {
    //             $franchise_id = 'BFT10000' . $id;
    //         } elseif (strlen($id) == 3) {
    //             $franchise_id = 'BFT1000' . $id;
    //         } elseif (strlen($id) == 4) {
    //             $franchise_id = 'BFT100' . $id;
    //         } elseif (strlen($id) == 5) {
    //             $franchise_id = 'BFT1000' . $id;
    //         }


    //         //print_r($_POST);exit;

    //         $data = array(

    //             'franchise_id' => $this->input->post('franchise_id'),
    //             'customer_id' => $this->input->post('customer_id'),
    //             'transaction_id' => $franchise_id,
    //             'payment_date' => $date,
    //             'credit_amount' => $this->input->post('amount'),
    //             // 'balance_amount' => $this->input->post('amount'),
    //             'payment_mode' => $this->input->post('payment_mode'),
    //             'bank_name' => $this->input->post('bank_name'),
    //             'status' => 1,
    //             'refrence_no' => $this->input->post('Refrence_number')
    //         );
    //         // print_r($data);exit;

    //         $result =  $this->db->insert('franchise_topup_balance_tbl', $data);

    //         $dd1 =  $this->db->query("SELECT * FROM  franchise_topup_balance_tbl ORDER BY  topup_balance_id DESC LIMIT 1")->result_array();


    //         $update_id = $dd1[0]['topup_balance_id'];
    //         $customer_id3 = $dd1[0]['customer_id'];
    //         $credit = $dd1[0]['credit_amount'];
    //         $balance = $dd1[0]['balance_amount'];
    //         $debit = $dd1[0]['debit_amount'];

    //         $dd2 = $this->db->query("select * from  franchise_topup_balance_tbl where customer_id = '$customer_id3' ORDER BY topup_balance_id DESC LIMIT 2")->result_array();
    //         //echo $this->db->last_query();
    //         $cd = $dd2[0]['customer_id'];
    //         $balance2 = $dd2[1]['balance_amount'];

    //         //  print_r($dd2);exit;
    //         if (!empty($cd)) {




    //             $balance = $balance2 + $credit;
    //         } else {

    //             $balance = $credit + $balance - $debit;
    //         }

    //         //  print_r($balance);exit;

    //         $result = $this->db->query("UPDATE franchise_topup_balance_tbl SET balance_amount =  $balance  WHERE topup_balance_id = $update_id");
    //         $result = $this->db->query("UPDATE tbl_customers SET wallet =  $balance  WHERE customer_id = $customer_id3");
    //         // print_r($result3);exit;
    //         if (!empty($result)) {
		
	// 	$fdata = $this->db->get_where('tbl_customers',['customer_id' => $customer_id3])->row();
                
    //             $fname = $fdata->customer_name; $lname ='';
    //             $number = $fdata->phone; 
    //             $enmsg = "Hi $fname $lname, you have successfully topup your account wallet, your available wallet balance is $balance Have a great day ahead. Regards, Team Box And Freight.";
    //             sendsms($number,$enmsg);

    //             $msg              = 'Topup added successfully';
    //             $class            = 'alert alert-success alert-dismissible';
    //             redirect(base_url() . 'admin/view-franchise-topup-data');
    //         } else {
    //             $msg              = 'Topup not added successfully';
    //             $class            = 'alert alert-danger alert-dismissible';
    //             redirect(base_url() . 'admin/view-franchise-topup-data');
    //         }
    //         $this->session->set_flashdata('notify', $msg);
    //         $this->session->set_flashdata('class', $class);
    //     } else {

    //         $this->load->view('admin/franchise_master/add_franchise_topup_balance');
    //     }
    // }

    public function franchise_topup_balance()
    {
        $date = date('Y-m-d');
        if (isset($_POST['submit'])) {

            $query = "SELECT MAX(topup_balance_id) as id FROM franchise_topup_balance_tbl ";
            $result1 = $this->basic_operation_m->get_query_row($query);
            $id = $result1->id + 1;
            //print_r($id); exit;

            if (strlen($id) == 1) {
                $franchise_id = 'BFT100000' . $id;
            } elseif (strlen($id) == 2) {
                $franchise_id = 'BFT10000' . $id;
            } elseif (strlen($id) == 3) {
                $franchise_id = 'BFT1000' . $id;
            } elseif (strlen($id) == 4) {
                $franchise_id = 'BFT100' . $id;
            } elseif (strlen($id) == 5) {
                $franchise_id = 'BFT1000' . $id;
            }

            $fdata = $this->db->get_where('tbl_customers', ['customer_id' => $this->input->post('customer_id')])->row();
           
            if ($this->input->post('payment_mode') == 'debit') {
                if($fdata->wallet >0){
                    if($fdata->wallet > $this->input->post('amount'))
                    {
                        $balance = $fdata->wallet - $this->input->post('amount');
                    }
                    else
                    {
                        $msg = 'Reacharge the wallet';
                        $class = 'alert alert-danger alert-dismissible';
                        $this->session->set_flashdata('notify', $msg);
                        $this->session->set_flashdata('class', $class);
                        redirect(base_url() . 'admin/franchise-topup-balance');
                    }
                   
                }
                else
                {
                    $msg = 'Reacharge the wallet';
                    $class = 'alert alert-danger alert-dismissible';
                    $this->session->set_flashdata('notify', $msg);
                    $this->session->set_flashdata('class', $class);
                    redirect(base_url() . 'admin/franchise-topup-balance');
                }
               
            } else {
                    $balance = $fdata->wallet + $this->input->post('amount');
            }
            // print_r($balance);exit;
            if ($this->input->post('payment_mode') == 'debit') {
                if (empty($this->input->post('Refrence_number'))) {
                    $msg = 'Remark required';
                    $class = 'alert alert-danger alert-dismissible';
                    $this->session->set_flashdata('notify', $msg);
                    $this->session->set_flashdata('class', $class);
                    redirect(base_url() . 'admin/franchise-topup-balance');
                }
                $data = array(
                    'franchise_id' => $this->input->post('franchise_id'),
                    'customer_id' => $this->input->post('customer_id'),
                    'transaction_id' => $franchise_id,
                    'payment_date' => $date,
                    'debit_amount' => $this->input->post('amount'),
                    'balance_amount' => $balance,
                    'payment_mode' => $this->input->post('payment_mode'),
                    'bank_name' => 'Current',
                    'status' => 1,
                    'refrence_no' => $this->input->post('Refrence_number')
                );
            } else {

                $data = array(

                    'franchise_id' => $this->input->post('franchise_id'),
                    'customer_id' => $this->input->post('customer_id'),
                    'transaction_id' => $franchise_id,
                    'payment_date' => $date,
                    'credit_amount' => $this->input->post('amount'),
                    'balance_amount' => $balance,
                    'payment_mode' => $this->input->post('payment_mode'),
                    'bank_name' => $this->input->post('bank_name'),
                    'status' => 1,
                    'refrence_no' => $this->input->post('Refrence_number')
                );

            }
            // print_r($data);exit; 
            $cust_id = $this->input->post('customer_id');
            $result = $this->db->insert('franchise_topup_balance_tbl', $data);

        
            $result = $this->db->query("UPDATE tbl_customers SET wallet =  $balance  WHERE customer_id = $cust_id");
            // print_r($result3);exit;
            if (!empty($result)) {

                $fdata = $this->db->get_where('tbl_customers', ['customer_id' => $cust_id])->row();

                $fname = $fdata->customer_name;
                $lname = '';
                $number = $fdata->phone;
                $enmsg = "Hi $fname $lname, you have successfully topup your account wallet, your available wallet balance is $balance Have a great day ahead. Regards, Team Box And Freight.";
                sendsms($number, $enmsg);
                if ($this->input->post('payment_mode') == 'debit') {
                    $msg = 'Wallet Debited successfully';
                }
                else
                {
                    $msg = 'Wallet Recharge successfully';
                }
              
                $class = 'alert alert-success alert-dismissible';
                $this->session->set_flashdata('notify', $msg);
                $this->session->set_flashdata('class', $class);
                redirect(base_url() . 'admin/view-franchise-topup-data');
            } else {
                $msg = 'Something Went to Wrong';
                $class = 'alert alert-danger alert-dismissible';
                $this->session->set_flashdata('notify', $msg);
                $this->session->set_flashdata('class', $class);
                redirect(base_url() . 'admin/view-franchise-topup-data');
            }
           

        } else {

            $this->load->view('admin/franchise_master/add_franchise_topup_balance');
        }
    }

    public function view_franchise_booking_shipment($offset = 0, $searching = '')
    {
    
        if ($this->session->userdata('userId') == '') {
            redirect('admin');
        } else {
            $data = [];
            $filterCond                    = '';
            $all_data                     = $this->input->post();

            if ($all_data) {
                $filter_value =     $_POST['filter_value'];

                foreach ($all_data as $ke => $vall) {
                    if ($ke == 'filter' && !empty($vall)) {
                        if ($vall == 'pod_no') {
                            $filterCond .= " AND tbl_domestic_booking.pod_no = '$filter_value'";
                        }
                        if ($vall == 'forwording_no') {
                            $filterCond .= " AND tbl_domestic_booking.forwording_no = '$filter_value'";
                        }
                        if ($vall == 'sender') {
                            $filterCond .= " AND tbl_domestic_booking.sender_name LIKE '%$filter_value%'";
                        }
                        if ($vall == 'receiver') {
                            $filterCond .= " AND tbl_domestic_booking.reciever_name LIKE '%$filter_value%'";
                        }

                        if ($vall == 'origin') {
                            $city_info                     =  $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
                            $filterCond                 .= " AND tbl_domestic_booking.sender_city = '$city_info->id'";
                        }
                        if ($vall == 'destination') {
                            $city_info                     =  $this->basic_operation_m->get_table_row('city', "city='$filter_value'");
                            $filterCond                 .= " AND tbl_domestic_booking.reciever_city = '$city_info->id'";
                        }
                        if ($vall == 'pickup') {

                            $filterCond                 .= " AND tbl_domestic_booking.pickup_pending = '1'";
                        }
                    } elseif ($ke == 'user_id' && !empty($vall)) {
                        $filterCond .= " AND tbl_domestic_booking.customer_id = '$vall'";
                    } elseif ($ke == 'from_date' && !empty($vall)) {
                        $filterCond .= " AND tbl_domestic_booking.booking_date >= '$vall'";
                    } elseif ($ke == 'to_date' && !empty($vall)) {
                        $filterCond .= " AND tbl_domestic_booking.booking_date <= '$vall'";
                    } elseif ($ke == 'courier_company' && !empty($vall) && $vall != "ALL") {
                        $filterCond .= " AND tbl_domestic_booking.courier_company_id = '$vall'";
                    } elseif ($ke == 'mode_name' && !empty($vall) && $vall != "ALL") {
                        $filterCond .= " AND tbl_domestic_booking.mode_dispatch = '$vall'";
                    }
                }
            }
            if (!empty($searching)) {
                $filterCond = urldecode($searching);
            }


            if ($this->session->userdata("userType") == '1') {
                $resActt = $this->db->query("SELECT * FROM tbl_domestic_booking LEFT JOIN tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id WHERE booking_type = 1 AND  tbl_customers.customer_type = '1' and tbl_domestic_booking.branch_id = '0' OR tbl_customers.customer_type ='2' $filterCond");
                //echo $this->db->last_query();
                $resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND tbl_customers.customer_type = '1' OR tbl_customers.customer_type ='2' AND tbl_domestic_booking.user_type !=5 and tbl_domestic_booking.branch_id = '0' $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC LIMIT  " . $offset . ",50");

                $download_query         = "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method FROM tbl_domestic_booking LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id LEFT JOIN tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id WHERE booking_type = 1 AND tbl_customers.customer_type = '1' OR tbl_customers.customer_type ='2' AND tbl_domestic_booking.user_type !=5 and tbl_domestic_booking.branch_id = '0' $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC";

                $this->load->library('pagination');

                $data['total_count']            = $resActt->num_rows();
                $config['total_rows']             = $resActt->num_rows();
                $config['base_url']             = 'admin/franchise-booking-list';
                //	$config['suffix'] 				= '/'.urlencode($filterCond);

                $config['per_page']             = 50;
                $config['full_tag_open']         = '<nav aria-label="..."><ul class="pagination">';
                $config['full_tag_close']         = '</ul></nav>';
                $config['first_link']             = '&laquo; First';
                $config['first_tag_open']         = '<li class="prev paginate_button page-item">';
                $config['first_tag_close']         = '</li>';
                $config['last_link']             = 'Last &raquo;';
                $config['last_tag_open']         = '<li class="next paginate_button page-item">';
                $config['last_tag_close']         = '</li>';
                $config['next_link']             = 'Next';
                $config['next_tag_open']         = '<li class="next paginate_button page-item">';
                $config['next_tag_close']         = '</li>';
                $config['prev_link']             = 'Previous';
                $config['prev_tag_open']         = '<li class="prev paginate_button page-item">';
                $config['prev_tag_close']         = '</li>';
                $config['cur_tag_open']         = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
                $config['cur_tag_close']         = '</a></li>';
                $config['num_tag_open']         = '<li class="paginate_button page-item">';
                $config['reuse_query_string']     = TRUE;
                $config['num_tag_close']         = '</li>';
                $config['attributes'] = array('class' => 'page-link');

                if ($offset == '') {
                    $config['uri_segment']             = 3;
                    $data['serial_no']                = 1;
                } else {
                    $config['uri_segment']             = 3;
                    $data['serial_no']        = $offset + 1;
                }


                $this->pagination->initialize($config);
                if ($resAct->num_rows() > 0) {

                    $data['allpoddata']             = $resAct->result_array();
                } else {
                    $data['allpoddata']             = array();
                }
            }else{
                
                    //print_r($this->session->all_userdata());
                    $branch_id = $this->session->userdata("branch_id");
                    $where 		= '';
                    // if($this->session->userdata("userType") == '7') 
                    // if($this->session->userdata("branch_id") == $branch_id) 
                    // { 
    
                    //     $username = $this->session->userdata("userName");
                        
                    //     $whr = array('username' => $username);
                    //     // $res = $this->basic_operation_m->getAll('tbl_users', $whr);
                    //     // $branch_id = $res->row()->branch_id;				
                    //     $where ="and branch_id='$branch_id' ";
                    //  } 
            
                    $resActt = $this->db->query("SELECT * FROM tbl_domestic_booking JOIN tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id WHERE booking_type = 1  and tbl_customers.branch_id = '$branch_id' and tbl_domestic_booking.branch_id = '0' $filterCond ");
                    $resAct = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking Join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 and tbl_customers.branch_id = '$branch_id' and tbl_domestic_booking.branch_id = '0' $where $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit ".$offset.",50");
                    // $download_query = $this->db->query("SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking Join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 and tbl_customers.branch_id = '$branch_id' and tbl_domestic_booking.branch_id = '0' $where $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC limit ".$offset.",50");
                    
                    $download_query 		= "SELECT tbl_domestic_booking.*,city.city,tbl_domestic_weight_details.chargable_weight,tbl_domestic_weight_details.no_of_pack,payment_method  FROM tbl_domestic_booking Join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id  LEFT JOIN city ON tbl_domestic_booking.reciever_city = city.id  LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id  WHERE booking_type = 1 and tbl_customers.branch_id = '$branch_id' and tbl_domestic_booking.branch_id = '0' $where $filterCond GROUP BY tbl_domestic_booking.booking_id order by tbl_domestic_booking.booking_id DESC ";
                    
                    $this->load->library('pagination');
                
                    $data['total_count']			= $resActt->num_rows();
                    $config['total_rows'] 			= $resActt->num_rows();
                    $config['base_url'] 			= 'admin/franchise-booking-list';
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
                    if($resAct->num_rows() > 0) 
                    {
                        $data['allpoddata']= $resAct->result_array();
                    }
                    else
                    {
                        $data['allpoddata']= array();
                    }
                }
            }


            if (isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report') {
                $resActtt             = $this->db->query($download_query);
                $shipment_data        = $resActtt->result_array();
                $this->franchise_shipment_report($shipment_data);
            }

            $data['viewVerified'] = 2;
            $whr_c = array('company_type' => 'Domestic');
            $data['courier_company'] = $this->basic_operation_m->get_all_result("courier_company", $whr_c);
            $data['mode_details'] = $this->basic_operation_m->get_all_result("transfer_mode", '');
            $this->load->view('admin/franchise_master/franchise_booking_list', $data);
        
    }


	public function franchise_shipment_report($shipment_data)
   	{    
		$date=date('d-m-Y');
		$filename = "SipmentDetails_".$date.".csv";
		$fp = fopen('php://output', 'w');
			
		$header =array("AWB No.","Sender","Sender Pincode","Receiver","Receiver Pincode","Receiver City","Forwording No","Forworder Name","Booking date","Mode","Pay Mode","Amount","Weight","NOP","Invoice No","Invoice Amount","Branch Name","Franchise Name","Franchise Master name","User","Freight","Handling Charge","Pickup","ODA","Insurance","COD","AWB Ch","Other Ch.","Green tax","Appt Ch","Fov Charges","Total","Fuel Surcharge","Eway No","Eway Expiry date");

			
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		fputcsv($fp, $header);
		$i =0;
		foreach($shipment_data as $row) 
		{
			$i++;

			$whr=array('transfer_mode_id'=>$row['mode_dispatch']);
            $mode_details = $this->basic_operation_m->get_table_row_array('transfer_mode',$whr);

            $whr_u =array('branch_id'=>$row['branch_id']);
            $branch_details = $this->basic_operation_m->get_table_row_array('tbl_branch', $whr_u);


            $whr_u =array('user_id'=>$row['user_id']);
            $user_details = $this->basic_operation_m->get_table_row_array('tbl_users', $whr_u);
            $user_details['username'] = substr($user_details['username'],0,20);
			//print_r(  $user_details['username']);


			
			$whr=array('id'=>$row['sender_city']);
			$sender_city_details = $this->basic_operation_m->get_table_row("city",$whr);
			$sender_city = $sender_city_details->city;
			
			$whr_s=array('id'=>$row['reciever_state']);
			$reciever_state_details = $this->basic_operation_m->get_table_row("state",$whr_s);
			$reciever_state = $reciever_state_details->state;
			
			$whr_p=array('id'=>$row['payment_method']);
			$payment_method_details = $this->basic_operation_m->get_table_row_array("payment_method",$whr_p);
			$payment_method = $payment_method_details['method'];
            $pod = $row['pod_no'];
            $customer_id = $row['customer_id'];
             $getfranchise = $this->db->query("select tbl_customers.customer_name as franchise from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->row_array(); 
           // print_r( $getfranchise['franchise']);
             $getMasterfranchise = $this->db->query("select tbl_customers.customer_name as master_franchise from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->row_array(); 
           //  print_r( $getMasterfranchise['master_franchise']);
			$branch_details['branch_name'] = substr($branch_details['branch_name'],0,20);
			$row=array(
				$row['pod_no'],
				$row['sender_name'],
				$row['sender_pincode'],
				$row['reciever_name'],
				$row['reciever_pincode'],
				$row['city'],
				$row['forwording_no'],
				$row['forworder_name'],
				date('d-m-Y',strtotime($row['booking_date'])),
				$mode_details['mode_name'],
				$row['dispatch_details'],
				$row['grand_total'],
				$row['chargable_weight'],
				$row['no_of_pack'],
				$row['invoice_no'],
				$row['invoice_value'],
				$branch_details['branch_name'],
                $getfranchise['franchise'],
                $getMasterfranchise['master_franchise'],
				$user_details['username'], 
                $row['frieht'],
                $row['transportation_charges'],
                $row['pickup_charges'],
                $row['delivery_charges'],
                $row['insurance_charges'],
                $row['courier_charges'],
                $row['awb_charges'],
                $row['other_charges'],
                $row['green_tax'],
                $row['appt_charges'],
                $row['fov_charges'],
                $row['total_amount'],
                $row['fuel_subcharges'],
			);
			
			
			fputcsv($fp, $row);
		}
		exit;
   	}



//////////////////////////////////////////////////////////////////////////////////////////////

    public function getfranchise_details()
    {
        $franchise_id =  $this->input->post('franchise_id');
        $data = $this->db->query("SELECT tbl_customers.*,state.state, city.city FROM `tbl_customers` LEFT join state ON tbl_customers.state = state.id LEFT join city ON tbl_customers.city = city.id WHERE `cid` = '$franchise_id'")->row();
        echo json_encode($data);
    }

    public function view_franchise_topup_data()
    {

        $data['topup_details'] = $this->db->query("SELECT * FROM `franchise_topup_balance_tbl` order by topup_balance_id desc")->result_array();
        $this->load->view('admin/franchise_master/view_franchise_topup_balance', $data);
    }
    ////////////////////////////////////////////////////////////////////////

    public function franchise_credit_topup_list($offset=0,$searching=''){

        $filterCond					= '';
    		$all_data 					= $this->input->post();
    
	    	if($all_data)
			{	
				$filter_value = 	$_POST['filter_value'];
				
				foreach($all_data as $ke=> $vall)
				{
					if($ke == 'filter' && !empty($vall))
					{
						if($vall == 'pod_no')
						{
							$filterCond .= " AND franchise_topup_balance_tbl.refrence_no = '$filter_value'";
						}						
					}
					elseif($ke == 'user_id' && !empty($vall))
					{
						$filterCond .= " AND franchise_topup_balance_tbl.customer_id = '$vall'";
					}
					elseif($ke == 'from_date' && !empty($vall))
					{
						$filterCond .= " AND franchise_topup_balance_tbl.payment_date >= '$vall'";
					}
					elseif($ke == 'to_date' && !empty($vall))
					{
						$filterCond .= " AND franchise_topup_balance_tbl.payment_date <= '$vall'";
					}
					elseif($ke == 'payment_mode' && !empty($vall) && $vall !="ALL")
					{
						$filterCond .= " AND franchise_topup_balance_tbl.payment_mode = '$vall'";
					}
					
			  	}
			}
			if(!empty($searching))
			{
				$filterCond = urldecode($searching);
			}else{

                $to_date 	 = date("Y-m-d");
                $todate12 	 =  $to_date;
			
              //  $filterCond .= " AND franchise_topup_balance_tbl.payment_date = '$todate'";

            }

	    
			if ($this->session->userdata("userType") == '1') 
			{
				$resActt = $this->db->query("SELECT franchise_topup_balance_tbl.*,tbl_customers.customer_name,tbl_customers.cid,tbl_customers.phone  from franchise_topup_balance_tbl left join tbl_customers ON tbl_customers.customer_id = franchise_topup_balance_tbl.customer_id where status = 1 AND franchise_topup_balance_tbl.payment_date = '$todate12' order by franchise_topup_balance_tbl.topup_balance_id ASC");
               // echo $this->db->last_query();exit;
				$resAct = $this->db->query("SELECT * FROM  franchise_topup_balance_tbl left join tbl_customers ON tbl_customers.customer_id = franchise_topup_balance_tbl.customer_id where status = 1 $filterCond  order by franchise_topup_balance_tbl.topup_balance_id ASC limit ".$offset.",100");
				// echo $this->db->last_query();
				$download_query = "SELECT * FROM  franchise_topup_balance_tbl left join tbl_customers ON tbl_customers.customer_id = franchise_topup_balance_tbl.customer_id where status = 1 $filterCond  order by franchise_topup_balance_tbl.topup_balance_id ASC";

				$this->load->library('pagination');
			
				$data['total_count']			= $resActt->num_rows();
				$config['total_rows'] 			= $resActt->num_rows();
				$config['base_url'] 			= 'admin/view-franchise-topup-credit-list';
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
				
					$data['franchise_topup'] 			= $resAct->result_array();
				}
				else
				{
					$data['franchise_topup'] 			= array();
				}
			}
			
			if(isset($_POST['download_report']) && $_POST['download_report'] == 'Download Report')
			{
				$resActtt 			= $this->db->query($download_query);
				$credit_data		= $resActtt->result_array();
				$this->franchise_credit_report($credit_data);
			}
            $data['customer']=  $this->db->query('SELECT franchise_topup_balance_tbl.*,tbl_customers.customer_name FROM franchise_topup_balance_tbl left join tbl_customers ON tbl_customers.customer_id = franchise_topup_balance_tbl.customer_id WHERE customer_type="2"group By franchise_topup_balance_tbl.customer_id ORDER BY customer_name ASC')->result_array();
            $this->load->view('admin/franchise_master/franchise_topup_credit_list',$data); 
         
        
    }
    public function franchise_credit_report($credit_data)
    {    
     $date=date('d-m-Y');
     $filename = "SipmentDetails_".$date.".csv";
     $fp = fopen('php://output', 'w');
         
     $header =array("C.ID","Franchise Name","Refrence_no","Credit Amount","Debit Amount","Balance Amount","Payment Mode","Payment Date");

         
     header('Content-type: application/csv');
     header('Content-Disposition: attachment; filename='.$filename);

     fputcsv($fp, $header);
     $i =0;
     foreach($shipment_data as $row) 
     {
         $i++;

         $row=array(
             $row['cid'],
             $row['customer_name'],
             $row['refrence_no'],
             $row['credit_amount'],
             $row['debit_amount'],
             $row['balance_amount'],
             $row['payment_mode'],
             $row['payment_date'],
         );
         
         
         fputcsv($fp, $row);
     }
     exit;
    }


    public function franchise_credit_list($id) {
         $data['franchise_topup'] = $this->db->query("SELECT franchise_topup_balance_tbl.*,tbl_customers.customer_name,tbl_customers.email,tbl_customers.phone,tbl_customers.city,tbl_customers.state,tbl_customers.address FROM  franchise_topup_balance_tbl LEFT JOIN tbl_customers ON tbl_customers.customer_id = franchise_topup_balance_tbl.customer_id GROUP BY  franchise_topup_balance_tbl.customer_id")->result_array();    
        $this->load->view('admin/franchise_master/topup_credit_list');     
    }

    public function franchise_debit_list($id){

        $this->load->view('admin/franchise_master/topup_debit_list');
       
    }

    public function update_franchise_topup($topup_balance_id)
    {
        if (isset($_POST['submit'])) {

            $data = array(
                'credit_amount' => $this->input->post('amount'),
                'balance_amount' => $this->input->post('amount'),
                'payment_mode' => $this->input->post('payment_mode'),
                'bank_name' => $this->input->post('bank_name'),
                'refrence_no' => $this->input->post('Refrence_number')
            );

            $this->db->where('topup_balance_id', $topup_balance_id);
            $result =  $this->db->update('franchise_topup_balance_tbl', $data);

            if (!empty($result)) {
                $msg              = 'Topup Update successfully';
                $class            = 'alert alert-success alert-dismissible';
                redirect(base_url() . 'admin/view-franchise-topup-data');
            } else {
                $msg              = 'Topup not Update successfully';
                $class            = 'alert alert-danger alert-dismissible';
                redirect(base_url() . 'admin/view-franchise-topup-data');
            }
            $this->session->set_flashdata('notify', $msg);
            $this->session->set_flashdata('class', $class);
        } else {
            $data = $this->db->query("SELECT * FROM `franchise_topup_balance_tbl` WHERE `topup_balance_id` = '$topup_balance_id'")->row();
            $this->load->view('admin/franchise_master/update_franchise_topup_balance', $data);
        }
    }

    public function delete_franchise_topup()
    {
        $getId = $this->input->post('getid');
        $data =  $this->db->delete('franchise_topup_balance_tbl', array('topup_balance_id' => $getId));
        if ($data) {
            $output['status'] = 'success';
            $output['message'] = 'Member deleted successfully';
        } else {
            $output['status'] = 'error';
            $output['message'] = 'Something went wrong in deleting the member';
        }

        echo json_encode($output);
    }

    public function filter_franchise_topup($offset = 0, $searching = '')
    {

        if (!empty($_POST)) {

            $filterCond                    = '';
            $all_data                     = $this->input->post();
                    if (!empty($all_data['filter'])) {
                        $filterCond .= " 1 ";
                    }
                    if (!empty($all_data['franchise_id'])) {
                        $filterCond .= "and franchise_topup_balance_tbl.franchise_id = '".$all_data['franchise_id']."'";
                    }
                    if (!empty($all_data['payment_type'])) {
                        $filterCond .= "and franchise_topup_balance_tbl.payment_mode = '".$all_data['payment_type']."'";
                    }
                    if (!empty($all_data['from_date'])) {
                        $filterCond .= "and franchise_topup_balance_tbl.payment_date >= '".$all_data['from_date']."'";
                    }
                    if (!empty($all_data['to_date'])) {
                        $filterCond .= "and franchise_topup_balance_tbl.payment_date <= '".$all_data['to_date']."'";
                    }
            
            $data['topup_details1'] = $this->db->query("select sum(credit_amount) as total_amt From franchise_topup_balance_tbl where $filterCond ")->result_array();
            $data['debit_amount'] = $this->db->query("select sum(debit_amount) as total_amt From franchise_topup_balance_tbl where $filterCond ")->row_array();
            $data['balance_amount'] = $this->db->query("select * From tbl_customers  where cid ='".$all_data['franchise_id']."' ")->row_array();
            // echo $this->db->last_query();die;
            $data['topup_details'] = $this->db->query("select franchise_topup_balance_tbl.* From franchise_topup_balance_tbl  where $filterCond ORDER BY topup_balance_id DESC")->result_array();
          

            if (isset($_POST['download_excel']) && $_POST['download_excel'] == 'Download Excel') {
				$shipment_data = $data['topup_details'];
				$shipment_data1 = $data['topup_details1'];
            //  echo '<pre>';print_r($shipment_data);die;
				$this->franchise_topup_data($shipment_data,$shipment_data1,$data['debit_amount'],$data['balance_amount']);
			}
            $this->load->view('admin/franchise_master/filter_franchise_topup_data', $data);

        } else {
            $this->load->view('admin/franchise_master/filter_franchise_topup_data');
        }
    }

    public function franchise_topup_data($shipment_data,$shipment_data1,$debit_amount)
	{

		$date = date('d-m-Y');
		$filename = "FRANCHISE TOPUP_" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("SrNo", "F.Code", "Transaction ID", "Transaction Date", "Credit Amount","Debit Amount","Balance Amount", "Payment Mode", "Bank name", "Refrence Number");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
         $customer = $shipment_data[0]['customer_id'];
         $balance_amount = $this->db->query("select * from tbl_customers where customer_id = '$customer'")->row_array();
		foreach ($shipment_data as $row) {
			$i++;
			$roww = array(
                $i,
				$row['franchise_id'],
				$row['transaction_id'],
				date('d-m-Y', strtotime($row['payment_date'])),
				$row['credit_amount'],
                $row['debit_amount'],
                $row['balance_amount'],
				$row['payment_mode'],
				$row['bank_name'],
				$row['refrence_no']
			);
			fputcsv($fp, $roww);
		}
        foreach ($shipment_data1 as $cust1) { 
            $roww = ['','Total Credit Amount : - ',$cust1['total_amt'],'','Total Debit Amount : -',number_format((float)$debit_amount['total_amt'], 2, '.', ''),'','Wallet Amount : -',number_format((float)$balance_amount['wallet'], 2, '.', '')];
            fputcsv($fp, $roww);
        }
		exit;
	}
    

    public function franchise_mis($offset = 0, $searching = '')
    {
        $username    =    $this->session->userdata("userName");

        $usernamee    =    $this->input->post("username");
        $whr         =     array('username' => $username);
        $res        =    $this->basic_operation_m->getAll('tbl_users', $whr);

        $branch_id    =     $res->row()->branch_id;
        $filterCond = '';
        $data['domestic_allpoddata']         = array();
        $total_domestic_allpoddata              = 0;
        $whr                                  =     array('branch_id' => $branch_id);
        $res                                 =    $this->basic_operation_m->getAll('tbl_branch', $whr);
        $branch_name                         =    $res->row()->branch_name;
        $user_id                              = $this->session->userdata("userId");
        $userType                              = $this->session->userdata("userType");
        $branch_id                              = $this->session->userdata("branch_id");
        $all_data                              = $this->input->post();
        $data['post_data']                     = $all_data;


        if (!empty($all_data)) {
            $whr_d = '';
            $customer_id = $all_data['customer_id'];
            if ($this->session->userdata("userType") == '1') 
			{
                if ($customer_id != "ALL") {
                    $whr_d    .= "tbl_domestic_booking.customer_id='$customer_id'";
                }else{
                
                    $whr_d    .= "tbl_domestic_booking.branch_id = '0'";
                }
           
                $from_date     = $all_data['from_date'];
                $to_date     = $all_data['to_date'];
                if ($from_date != "" && $to_date != "") {
                    $from_date          = date("Y-m-d", strtotime($all_data['from_date']));
                    $to_date          = date("Y-m-d", strtotime($all_data['to_date']));
                    $whr_d            .= " AND date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
                }
               
           }else{
                 $branch_id = $this->session->userdata("branch_id");
                    if ($customer_id != "ALL") {
                        $whr_d    .= "tbl_domestic_booking.customer_id='$customer_id' AND tbl_customers.branch_id = '$branch_id'";
                    }else{
                    
                        $whr_d    .= "tbl_domestic_booking.branch_id = '0'  AND tbl_customers.branch_id = '$branch_id'";
                    }
            
                    $from_date     = $all_data['from_date'];
                    $to_date     = $all_data['to_date'];
                    if ($from_date != "" && $to_date != "") {
                        $from_date          = date("Y-m-d", strtotime($all_data['from_date']));
                        $to_date          = date("Y-m-d", strtotime($all_data['to_date']));
                        $whr_d            .= " AND date(booking_date) >='$from_date' AND date(booking_date) <='$to_date'";
                    }
           }
               $this->load->model('Generate_pod_model');
                $data['domestic_allpoddata']             = $this->Generate_pod_model->get_domestic_tracking_data($whr_d, "", $offset);
            // print_r($data['domestic_allpoddata']);die;
            // echo $this->db->last_query();die;
        }


        if ($this->session->userdata("userType") == '1') 
			{
        $where = "customer_type IN ('2')";
        $data['customers_list']        = $this->basic_operation_m->get_all_result("tbl_customers", $where);
       
            }else{
                $branch_id = $this->session->userdata("branch_id");
                $where = "branch_id = '$branch_id' and  customer_type IN ('2')";
           $data['customers_list']        = $this->basic_operation_m->get_all_result("tbl_customers", $where);
            }
            //  echo $this->db->last_query();die;
        $this->load->view('admin/franchise_master/view_mis_report', $data);
    }
}
