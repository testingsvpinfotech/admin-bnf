<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_franchise_delivery_rate extends CI_Controller {

	var $data 			= array();
	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}

	}

    public function delivery_group_master()
    {
        if (isset($_POST['submit'])) {
            $all_data = $this->input->post();
            unset($all_data['submit']);
            $result = $this->basic_operation_m->insert('tbl_rate_group_master', $all_data);
            if ($this->db->affected_rows() > 0) {
                $data['message'] = "Delivery Group Name Added Sucessfully";
            } else {
                $data['message'] = "Error in Query";
            }
            redirect('admin/delivery-group-master');
        }
        $data = array();
        $resAct    = $this->db->query("select * from tbl_rate_group_master where groups_id ='3'");
        if ($resAct->num_rows() > 0) {
            $data['allvehicletype'] = $resAct->result_array();
        }

        $this->load->view('admin/franchise-delivery-rateMaster/add_delivery_group_name', $data);
    }
	

    public function index()
    {   $data['delivery_rate_list'] = $this->db->query("select franchise_delivery_rate_tbl.*, tbl_rate_group_master.group_name as group_name from franchise_delivery_rate_tbl left join tbl_rate_group_master on tbl_rate_group_master.id = franchise_delivery_rate_tbl.group_id Group By franchise_delivery_rate_tbl.delivery_rate_id")->result();
        $this->load->view('admin/franchise-delivery-rateMaster/delivery_rate_list',$data);  
    }



    public function add_delivery_rate()
    {
            if(isset($_POST['save'])){  
                //print_r($_POST) ;exit;

            $data = array(

                'doc_per_kg'=>$this->input->post('doc_per_kg'),
                'doc_min'=>$this->input->post('doc_min'),
                'Non_doc_per_kg'=>$this->input->post('Non_doc_per_kg'),
                'Non_doc_min'=>$this->input->post('Non_doc_min'),
                'cod_min'=>$this->input->post('cod_min'),
                'cod_percentage'=>$this->input->post('cod_percentage'),
                'to_pay_min'=>$this->input->post('to_pay_min'),
                'to_pay_percentage'=>$this->input->post('to_pay_percentage'),
                'from_date'=>$this->input->post('from_date'),
                'to_date'=>$this->input->post('to_date'),
                'group_id'=>$this->input->post('group_id'),

            );  
            // print_r($data);exit;
                $res =  $this->db->insert('franchise_delivery_rate_tbl',$data);
                    if($res){
                        $msg					= 'Delivery Rate Added Successfully!!!';
                        $class					= 'alert alert-success alert-dismissible';	

                    }else{
                            $msg			= 'Delivery Rate Not Added !!!';
                            $class			= 'alert alert-danger alert-dismissible';	
                        }
                        $this->session->set_flashdata('notify',$msg);
                        $this->session->set_flashdata('class',$class);
                        redirect('admin/view-franchise-delivery-ratemaster');

        }else{
            $data['all_customer']		= $this->db->query("select * from tbl_rate_group_master where groups_id = 3 ")->result_array();
           $this->load->view('admin/franchise-delivery-rateMaster/add_franchise_delivery_rate',$data);

        }  
    }


    public function deletedeliveryRate()
	{  
	     $id = $this->input->post('getid');
		if(!empty($id))
		{
			$airlines_company		= $this->basic_operation_m->delete("franchise_delivery_rate_tbl","delivery_rate_id = '$id'");
			//$airlines_company		= $this->basic_operation_m->delete("franchise_fuel_detail","cf_id = '$id'");

			$output['status'] = 'success';
			$output['message'] = 'Fule deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the Fule';
		}
 
		echo json_encode($output);	
	}
}