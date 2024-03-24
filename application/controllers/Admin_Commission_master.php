<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Admin_Commission_master extends CI_Controller {
    function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
         $this->load->model('Commission_master_model');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}

	}
    public function view_all(){
        $data = $this->data;
		$user_id = $this->session->userdata("userId");
		$data['groups'] = $this->db
                                ->select('group_id, group_name, booking_commission, pickup_charges, delivery_commission, door_delivery_share')
                                ->where('is_deleted', false)
                                ->get('tbl_comission_master')
                                ->result_array();
        $this->load->view('admin/commission_master/view_group_name',$data);
    }
    public function index() {
        $this->load->view('admin/commission_master/add_group');
    }
    public function add($id) {
        // ini_set('display_errors', 1);
        // error_reporting(E_ALL ^ E_NOTICE);
        if($id>=1){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $data = array(
                    'booking_commission' => $this->input->post('booking_commission'),
                    'pickup_charges' => $this->input->post('pickup_charges'),
                    'delivery_commission' => $this->input->post('booking_commission'),
                    'door_delivery_share' => $this->input->post('door_delivery'),
                );
    
                $this->form_validation->set_rules('booking_commission', 'Booking_commission', 'required');
                $this->form_validation->set_rules('pickup_charges', 'Pickup_charges', 'required');
                $this->form_validation->set_rules('delivery_commission', 'Delivery_commission', 'required');
                $this->form_validation->set_rules('door_delivery', 'Door_delivery', 'required|min_length[2]');
    
                //var_dump($data);die();
                if ($this->form_validation->run() == FALSE) {
                    $response = array(
                        'success' => false,
                        'error_no' => 1, 
                        'msg' => 'Please Fill All Fields', 
                    );
                }else{
                    $allValuesLessThan30 = true;
                    foreach ($data as $key => $value) {
                        if ($key !== 'group_name' && $key !== 'pickup_charges' && $key !== 'door_delivery_share' && $value >= 30) {
                            $allValuesLessThan30 = false;
                            break;
                        }
                    }
                    if ($allValuesLessThan30) {
                        $this->db->where('group_id', $id); // Providing the condition for the record to be updated
                        $this->db->update('tbl_comission_master', $data); 

                        $response = array(
                            'success' => true,
                            'msg' => 'Group Updated successfully', 
                        );
                    } else {
                        $response = array(
                            'success' => false,
                            'error_no' => 3, 
                            'msg' => "Commission percentages should be less than 30", 
                        );
                    }
                }
                echo json_encode($response);
            } else {
                $response = array(
                    'success' => false,
                );
                echo json_encode($response);
            }
        }else{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = array(
                    'group_name' => $this->input->post('group_name'),
                    'booking_commission' => $this->input->post('booking_commission'),
                    'pickup_charges' => $this->input->post('pickup_charges'),
                    'delivery_commission' => $this->input->post('booking_commission'),
                    'door_delivery_share' => $this->input->post('door_delivery'),
                );
    
                $this->form_validation->set_rules('group_name', 'group_Name', 'required');
                $this->form_validation->set_rules('booking_commission', 'Booking_commission', 'required');
                $this->form_validation->set_rules('pickup_charges', 'Pickup_charges', 'required');
                $this->form_validation->set_rules('delivery_commission', 'Delivery_commission', 'required');
                $this->form_validation->set_rules('door_delivery', 'Door_delivery', 'required|min_length[2]');
    
                if ($this->form_validation->run() == FALSE) {
                    $response = array(
                        'success' => false,
                        'error_no' => 1, 
                        'msg' => 'Please Fill All Fields', 
                    );
                }else{
                    $check_group_name_exist = $this->db->get_where('tbl_comission_master', array('group_name' => $this->input->post('group_name')))->row_array();
                    if(!empty($check_group_name_exist)) {
                        $response = array(
                            'success' => false,
                            'error_no' => 2, 
                            'msg' => "Group Name Already Exist", 
                        );
                    }else{
                        $allValuesLessThan30 = true;
                        foreach ($data as $key => $value) {
                            if ($key !== 'group_name' && $key !== 'pickup_charges' && $value >= 30) {
                                $allValuesLessThan30 = false;
                                break;
                            }
                        }
                        if ($allValuesLessThan30) {
                            $this->db->insert('tbl_comission_master', $data);
                            //echo $this->db->last_query(); // Debugging purposes
    
                            $response = array(
                                'success' => true,
                                'msg' => 'Data inserted successfully', 
                            );
                        } else {
                            $response = array(
                                'success' => false,
                                'error_no' => 3, 
                                'msg' => "Percentage should be less than 30", 
                            );
                        }
                    }
                }
                echo json_encode($response);
            } else {
                $response = array(
                    'success' => false,
                );
                echo json_encode($response);
            }
        }
    }
    public function edit($id) {
        if ($id) {
            $data['group']	  = $this->db->get_where('tbl_comission_master', array('group_id' => $id))->result();
            $this->load->view('admin\commission_master\edit_group',$data);
        }else {
            $this->load->view('');
        }
    }
    public function delete($id) {
        if ($id) {
            $this->db->where('group_id', $id);
            $this->db->update('tbl_comission_master', array("is_deleted" => 1));
            //echo $this->db->last_query();
        }else {
            $this->load->view('');
        }
    }
}