<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_oda_dph_matrix extends CI_Controller {

	function __construct()
	{
		 parent:: __construct();
		 $this->load->model('basic_operation_m');
		 if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
	}

	public function dph_listview(){
		$data['title'] = "DPH MATRIX";
		$data['dph_data'] = $this->db->get('tbl_dph_matrix')->result();
		$this->load->view('admin/oda_dph_matrix/dph_listview', $data);
	}

	public function addnew_dph_matrix(){
		$data['title'] = "ADD DPH MATRIX";
		$this->load->view('admin/oda_dph_matrix/dph_addnew', $data);
	}

	public function update_dph_matrix($id){
		$data['title'] = "UPDATE DPH MATRIX";
		$data['dph_data'] = $this->db->get_where('tbl_dph_matrix',['id' => $id])->row();
		$this->load->view('admin/oda_dph_matrix/dph_addnew', $data);
	}

	public function insert_dph_master($id= ''){
		$data = $this->input->post();
		if ($id == '') {
			$insertData = array(
				'start_date' => date('Y-m-d', strtotime($data['date_time'])),
				'from_ltr' => $data['from_ltr'],
				'to_ltr' => $data['to_ltr'],
				'ltr_rate_perkg' => $data['rate_perkg'],
				'create_id' => $this->session->userdata('user_id'),
				'create_date' => date('Y-m-d H:i:s')
			);
			$result = $this->db->insert('tbl_dph_matrix', $insertData);

			if(!empty($result)){
				$output['class'] = 'success';
				$output['notify'] = 'Fule deleted successfully';
				$this->session->set_flashdata($output);
			}
		}else{
			$updateData = array(
				'start_date' => date('Y-m-d', strtotime($data['date_time'])),
				'from_ltr' => $data['from_ltr'],
				'to_ltr' => $data['to_ltr'],
				'ltr_rate_perkg' => $data['rate_perkg'],
				'update_id' => $this->session->userdata('user_id'),
				'update_date' => date('Y-m-d H:i:s')
			);
			$result = $this->db->update('tbl_dph_matrix', $updateData,['id' => $id]);

			if(!empty($result)){
				$output['class'] = 'success';
				$output['notify'] = 'Fule deleted successfully';
				$this->session->set_flashdata($output);
			}
		}
		redirect(base_url().'Admin_oda_dph_matrix/dph_listview');
	}

	// ========== GLOBAL DPH MATRIX MASTER START ========== 
	public function global_dph_listview(){
		$data['title'] = "GLOBAL DPH MATRIX";
		$data['dph_data'] = $this->db->get('tbl_global_dph_matrix')->result();
		$this->load->view('admin/oda_dph_matrix/global_dph_matrix', $data);
	}

	public function addnew_global_dph_matrix(){
		$data['title'] = "ADD DPH MATRIX";
		$this->load->view('admin/oda_dph_matrix/global_dph_addnew', $data);
	}

	public function update_global_dph_matrix($id){
		$data['title'] = "UPDATE GLOBAL DPH MATRIX";
		$data['dph_data'] = $this->db->get_where('tbl_global_dph_matrix',['id' => $id])->row();
		$this->load->view('admin/oda_dph_matrix/global_dph_addnew', $data);
	}

	public function insert_global_dph_master($id= ''){
		$data = $this->input->post();
		if ($id == '') {
			$insertData = array(
				'start_date' => date('Y-m-d', strtotime($data['date_time'])),
				'from_ltr' => $data['from_ltr'],
				'to_ltr' => $data['to_ltr'],
				'rate' => $data['rate_perkg'],
				'create_id' => $this->session->userdata('user_id'),
				'create_date' => date('Y-m-d H:i:s')
			);
			$result = $this->db->insert('tbl_global_dph_matrix', $insertData);

			if(!empty($result)){
				$output['class'] = 'success';
				$output['notify'] = 'Fule deleted successfully';
				$this->session->set_flashdata($output);
			}
		}else{
			$updateData = array(
				'start_date' => date('Y-m-d', strtotime($data['date_time'])),
				'from_ltr' => $data['from_ltr'],
				'to_ltr' => $data['to_ltr'],
				'rate' => $data['rate_perkg'],
				'update_id' => $this->session->userdata('user_id'),
				'update_date' => date('Y-m-d H:i:s')
			);
			$result = $this->db->update('tbl_global_dph_matrix', $updateData,['id' => $id]);

			if(!empty($result)){
				$output['class'] = 'success';
				$output['notify'] = 'Fule deleted successfully';
				$this->session->set_flashdata($output);
			}
		}
		redirect(base_url().'Admin_oda_dph_matrix/global_dph_listview');
	}
	// ========== GLOBAL DPH MATRIX MASTER END ========== 
}

?>