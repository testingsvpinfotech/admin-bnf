<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_rate_group_master extends CI_Controller
{
    private $data = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model('basic_operation_m');
        if ($this->session->userdata('userId') == '') {
            redirect('admin');
        }
    }

    public function index()
    {
        if (isset($_POST['submit'])) {
            $all_data = $this->input->post();
            $resAct    = $this->db->query("select * from tbl_rate_group_master where group_name = '".$all_data['group_name']."' AND groups_id = '1'")->row();
        
            if($resAct->group_name == $this->input->post('group_name') ){
                $msg = "Rate group Name Already Exists!";
                $class = 'alert alert-danger alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
               redirect('admin/rate-group-master');
            }
            unset($all_data['submit']);
            $data = [
                'groups_id'=>'1',
				'group_name'=>$this->input->post('group_name'),
				'booking_bill_type'=>$this->input->post('booking_bill_type'),
				'created_at'=>date('Y-m-d H:i:s')
			];
			$result = $this->db->insert('tbl_rate_group_master', $data);
            if ($this->db->affected_rows() > 0) {
                $msg = "Rate group Added Sucessfully";
                $class = 'alert alert-success alert-dismissible';
				$this->session->set_flashdata('notify', $msg);
				$this->session->set_flashdata('class', $class);
            } else {
                $data['message'] = "Error in Query";
            }
            redirect('admin/rate-group-master');
        }
        $data = array();
        $resAct    = $this->db->query("select * from tbl_rate_group_master where groups_id = 1");
        if ($resAct->num_rows() > 0) {
            $data['allvehicletype'] = $resAct->result_array();
        }

        $this->load->view('admin/rate_group/rate_group', $data);
    }

    public function add_franchise_rate()
    {
        $data         = $this->data;
        $user_id    = $this->session->userdata("userId");
        $where = array('groups_id' => '1');
        $whr_c = array('company_type' => 'Domestic');
        $data['mode_list']         = $this->basic_operation_m->get_all_result("transfer_mode", "");
        $data['customer_list']     = $this->basic_operation_m->get_all_result("tbl_rate_group_master",$where);
        $data['zone_list']         = $this->basic_operation_m->get_all_result("region_master", "");
        $data['states']          = $this->basic_operation_m->get_all_result('state', '');
        $data['added_customer_list'] = $this->db->query("SELECT * FROM tbl_rate_group_master INNER JOIN tbl_franchise_rate_master ON tbl_rate_group_master.id = tbl_franchise_rate_master.group_id GROUP BY tbl_rate_group_master.id ORDER BY tbl_rate_group_master.id")->result_array();
        $this->load->view('admin/rate_group/rate_group_master', $data);
    }

    public function view_franchise_rate($id)
    {
        $data['domestic_rate_list'] = $this->db->query("SELECT tbl_franchise_rate_master.*,tbl_rate_group_master.group_name FROM tbl_franchise_rate_master JOIN tbl_rate_group_master ON tbl_rate_group_master.id=tbl_franchise_rate_master.group_id Where group_id = '$id' ")->result_array();
        $this->load->view('admin/rate_group/view_rate', $data);
    }

    public function insert_franchise_rate()
    {
        $alldata     = $this->input->post();
        if ($alldata['fixed_perkg'] > 0) {
            //$alldata['weight_slab'] = ((round($alldata['weight_range_to']) *1000) - (round($alldata['weight_range_from']) *1000));
            $alldata['weight_slab'] = ((round((float)$alldata['weight_range_to']) * 1000) - (round((float)$alldata['weight_range_from']) * 1000));
        }

        if (!empty($alldata)) {
           // print_r($alldata);die;
            // echo $this->db->last_query();die;
            $d_data        = $this->basic_operation_m->insert_franchise_rate("tbl_franchise_rate_master", $alldata);
           
            $msg            = 'Rate Inserted successfully';
            $class            = 'alert alert-success alert-dismissible';
        } else {
            $msg            = 'Rate not Inserted';
            $class            = 'alert alert-danger alert-dismissible';
        }

        $this->session->set_flashdata('notify', $msg);
        $this->session->set_flashdata('class', $class);

        redirect('admin/franchise-rate-master');
    }




    public function edit_franchise_rate($id)
    {
        if (isset($_POST['submit'])) {
            $data1['group_id'] = $this->input->post('customer_id');
            $data1['applicable_from'] = $this->input->post('applicable_from');
            $data1['from_zone_id'] = $this->input->post('from_zone_id');
            $data1['to_zone_id'] = $this->input->post('to_zone_id');
            $data1['state_id'] = $this->input->post('state_id');
            $data1['city_id'] = $this->input->post('city_id');
            $data1['mode_id'] = $this->input->post('mode_id');
            $data1['tat'] = $this->input->post('tat');
            $data1['doc_type'] = $this->input->post('doc_type');
            $data1['weight_range_from'] = $this->input->post('weight_range_from');
            $data1['weight_range_to'] = $this->input->post('weight_range_to');
            $data1['rate'] = $this->input->post('rate');
            $data1['fixed_perkg'] = $this->input->post('fixed_perkg');
            // echo "<pre>id : ";
            // echo $id;
            // print_r($data1);
            // exit();
           if($this->basic_operation_m->update("tbl_franchise_rate_master", $data1, "rate_id = '$id'")){
            $msg  = 'Rate not Inserted';
            $class			= 'alert alert-danger alert-dismissible';	
           }else{
            $msg = "Rate Update Successfully";
            $class			= 'alert alert-success alert-dismissible';
          
           }
           $this->session->set_flashdata('notify',$msg);
		$this->session->set_flashdata('class',$class);
		
		redirect('admin/view-franchise-rate/'.$data1['group_id']);
       
        }
        $data['mode_list']    = $this->basic_operation_m->get_all_result("transfer_mode", "");
        $data['zone_list']     = $this->basic_operation_m->get_all_result("region_master", "");
        $data['customer_list']     = $this->basic_operation_m->get_all_result("tbl_rate_group_master", "");
        $data['states'] = $this->basic_operation_m->get_all_result('state', '');
        $data['domestic_rate'] = $this->db->query("SELECT * FROM tbl_franchise_rate_master Where rate_id = '$id'")->row();
        $this->load->view('admin/rate_group/view_edit_rate', $data);
    }

    public function delete_rate()
    {
        $getId = $this->input->post('getid');
        // $data =  $this->db->delete('tbl_rate_group_master', array('id' => $getId));
        // $data =  $this->db->delete('tbl_franchise_rate_master', array('rate_id' => $getId));
        // echo $this->db->last_query();
        if ($this->db->delete('tbl_franchise_rate_master', array('group_id' => $getId))) {
            $output['status'] = 'success';
            $output['message'] = 'Rate deleted successfully';
        } else {
            $output['status'] = 'error';
            $output['message'] = 'Something went wrong in deleting the member';
        }

        echo json_encode($output);
    }
}
