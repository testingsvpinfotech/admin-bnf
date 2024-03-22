<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class Pickup_Request_Charges extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}


	public function pickup_charges_list()
	{
		//print_r($_POST);exit;
		if (isset($_POST['submit'])) {
			$fweight = $this->input->post('from_weight');
			$tweight = $this->input->post('to_weight');
			$rate = $this->input->post('pickup_rate');
			$cnt = $this->db->get_where('tbl_pickup_charges',['weight_from' => $fweight, 'weight_to' => $tweight, 'rate' => $rate])->num_rows();
			$data = array(
				'weight_from' => $fweight,
				'weight_to' => $tweight,
				'rate' => $rate,
				'weight_type' => $this->input->post('weight_type'),
				'createDtm' => date('Y-m-d')
			);
			//print_r($data);exit;
			$res = $this->db->insert('tbl_pickup_charges', $data);
			if($res){
			$this->session->set_flashdata('msg', 'Pickup charge Added');
			}
			redirect(base_url() . 'admin/pickup-charges-master');
		}
		$data['rate'] = $this->db->get_where('tbl_pickup_charges', ['isDeleted' => 0])->result();
		$this->load->view('admin/pickup/pickup_charges_list', $data);
	}

	public function delete_pickup_charge($id)
	{
		$result = $this->db->update('tbl_pickup_charges', ['isDeleted' => 1], ['id' => $id]);
		if(!empty($result)){
			$this->session->set_flashdata('msg', 'Data Deleted Successfully!!');	
		}else{
			$this->session->set_flashdata('msg', 'Something went wrong');
		}
		redirect(base_url() . 'admin/pickup-charges-master');
	}

	public function update_pickup_charge($id)
	{
		if (isset($_POST['submit'])) {
			$fweight = $this->input->post('from_weight');
			$tweight = $this->input->post('to_weight');
			$rate = $this->input->post('pickup_rate');
			$cnt = $this->db->get_where('tbl_pickup_charges',['weight_from' => $fweight, 'weight_to' => $tweight, 'rate' => $rate])->num_rows();
			$data = array(
				'weight_from' => $fweight,
				'weight_to' => $tweight,
				'rate' => $rate,
				'weight_type' => $this->input->post('weight_type'),
				'createDtm' => date('Y-m-d')
			);
			//print_r($data);exit;
			$this->db->where('id',$id);
			$res =  $this->db->update('tbl_pickup_charges', $data);
			if($res){
			$this->session->set_flashdata('msg', 'Pickup charge Updated');
			}
			redirect(base_url() . 'admin/pickup-charges-master');
		}
		$data['pickup_rate'] = $this->db->get_where('tbl_pickup_charges', array('id' => $id))->result_array();
		$this->load->view('admin/pickup/edit_pickup_charges', $data);
		
	}

	
}
