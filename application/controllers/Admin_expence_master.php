<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_expence_master extends CI_Controller 
{
	var $data= array();
    function __construct() 
	{
        parent:: __construct();
		$this->load->model('login_model');
        $this->load->model('basic_operation_m');
        $this->load->model('Customer_model');
        $this->load->model('Booking_model');
        if($this->session->userdata('userId') == '')
		{
			redirect('admin');
		}
    }

    


	public function view_expence_master()
	{  

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);


		$data				= array();
		$username = $this->session->userdata("userName");
	

		$data["message"]="";
		$data["result"]=false;
		$data['title']="Login";
		if(isset($_POST['submit']))
		{
			$data = array('expence'=> $this->input->post('expence'),
		'gernrated_by'=>$username);
			$result=$this->basic_operation_m->insert('tbl_expense_master',$data);
			
			redirect('admin/view-expence-master');
		}

		$data['usermenus'] = $this->db->query("select * from tbl_expense_master where isdeleted = '0'")->result();
		$this->load->view('admin/expense_master/view_expense_master',$data);
	}
	public function view_voucher_entry()
	{  

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);


		$data				= array();
		$data["message"]="";
		$data["result"]=false;
		$data['title']="Login";
		$data['usermenus'] = $this->db->query("select * from tbl_expense_master where isdeleted = '0'")->result();
		$data['vendor'] = $this->db->query("select * from tbl_vendor")->result();
		$data['bank'] = $this->db->query("select * from bank_master")->result();
		$this->load->view('admin/expense_master/view_add_voucher_entry',$data);
	}
	public function view_voucher()
	{  
		$data				= array();
		$data["message"]="";
		$data["result"]=false;
		$data['title']="Login";
		$username = $this->session->userdata("userName");
		$created_at = $this->db->query("select * from tbl_users where username = '$username'")->row();
		if($created_at->full_name == 'Super Admin'){
			$data['allbranchdata'] = $this->db->query("select *,tbl_voucher_entry_master.id as id from tbl_voucher_entry_master join tbl_expense_master on tbl_expense_master.id = tbl_voucher_entry_master.expence_type where tbl_expense_master.isdeleted = '0' and tbl_voucher_entry_master.isdeleted = '0'")->result();
		}else{
			$val = $created_at->full_name;
			$data['allbranchdata'] = $this->db->query("select *,tbl_voucher_entry_master.id as id from tbl_voucher_entry_master join tbl_expense_master on tbl_expense_master.id = tbl_voucher_entry_master.expence_type where tbl_expense_master.isdeleted = '0' and tbl_voucher_entry_master.isdeleted = '0' and tbl_voucher_entry_master.created_at = '$val'")->result();
		}
		
		
		$this->load->view('admin/expense_master/view_voucher_entry',$data);
	}
	public function view_edit_voucher($id=0)
	{  

		$data				= array();
		$data["message"]="";
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(E_ALL);
	   if($_POST['submit']){
		$username = $this->session->userdata("userName");

		$created_at = $this->db->query("select * from tbl_users where username = '$username'")->row();
		$value = array(
			'expence_type' => $this->input->post('expence_type'),
			'vendor_name' => $this->input->post('vendor_name'),
			'amount' => $this->input->post('amount'),
			'bank_name' => $this->input->post('bank_name'),
			'ref_no' => $this->input->post('ref_no'),
			'description' => $this->input->post('description'),
			'edited_by' => $created_at->full_name
		  );
		  $where= array('id'=>$id);
		  $data = $this->basic_operation_m->update('tbl_voucher_entry_master',$value , $where);
			$msg='Voucher Edited succesfully';					
			$class	= 'alert alert-success alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			redirect('admin/view-voucher');
		 
	   }
	   $data['usermenus'] = $this->db->query("select * from tbl_expense_master where isdeleted = '0'")->result();
	   $data['vendor'] = $this->db->query("select * from tbl_vendor")->result();
	   $data['bank'] = $this->db->query("select * from bank_master")->result();
		$data['val'] = $this->db->query("select * from tbl_voucher_entry_master where id ='$id'")->row();
		$this->load->view('admin/expense_master/view_edit_voucher_entry',$data);
	}
	public function insert_voucher_entry()
	{  
		$username = $this->session->userdata("userName");

		$created_at = $this->db->query("select * from tbl_users where username = '$username'")->row();
		if(! empty($_POST)){
          $value = array(
			'expence_type' => $this->input->post('expence_type'),
			'vendor_name' => $this->input->post('vendor_name'),
			'amount' => $this->input->post('amount'),
			'bank_name' => $this->input->post('bank_name'),
			'ref_no' => $this->input->post('ref_no'),
			'description' => $this->input->post('description'),
			'created_at' => $created_at->full_name
		  );
		  $data = $this->basic_operation_m->insert('tbl_voucher_entry_master',$value);
			$msg='Voucher Added succesfully';					
			$class	= 'alert alert-success alert-dismissible';	
			$this->session->set_flashdata('notify',$msg);
			$this->session->set_flashdata('class',$class);
			redirect('admin/view-voucher');
		}
	}
	public function view_edit_expence_master($id=0)
	{  

		$username = $this->session->userdata("userName");
		if(isset($_POST['submit']))
		{
			$data = array('expence'=> $this->input->post('expence'),
		'gernrated_by'=>$username);
		  $where = array('id'=>$id);
			$result=$this->basic_operation_m->update('tbl_expense_master',$data , $where);
			
			redirect('admin/view-expence-master');
		}

		$data['usermenus'] = $this->db->query("select * from tbl_expense_master where id ='$id' AND isdeleted = '0'")->row();
		$this->load->view('admin/expense_master/view_expense_edit_master',$data);
	  
	}


	
	public function delete_expence()
	{
          $getId = $this->input->post('getid');
		  $where = array('id'=>$getId);
		  $val = array('isdeleted' =>'1');
		  $data = $this->basic_operation_m->update('tbl_expense_master',$val , $where);
		
          if($data){
			$output['status'] = 'success';
			$output['message'] = 'Member deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the member';
		}
 
		echo json_encode($output);	

	}
	public function voucher_delete()
	{
          $getId = $this->input->post('getid');
		  $where = array('id'=>$getId);
		  $val = array('isdeleted' =>'1');
		  $data = $this->basic_operation_m->update('tbl_voucher_entry_master',$val , $where);
		
          if($data){
			$output['status'] = 'success';
			$output['message'] = 'Member deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the member';
		}
 
		echo json_encode($output);	

	}
	public function isapprove()
	{
		$username = $this->session->userdata("userName");

		$created_at = $this->db->query("select * from tbl_users where username = '$username'")->row();
          $getId = $this->input->post('getid');
		  $where = array('id'=>$getId);
		  $val = array('is_approve' =>'1','approve_by'=>$created_at->full_name);
		  $data = $this->basic_operation_m->update('tbl_voucher_entry_master',$val , $where);
	
          if($data){
			$output['status'] = 'success';
			$output['message'] = 'Member deleted successfully';
		}
		else{
			$output['status'] = 'error';
			$output['message'] = 'Something went wrong in deleting the member';
		}
 
		echo json_encode($output);	

	}
}
?>
