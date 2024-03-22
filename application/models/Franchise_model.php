<?php
class Franchise_model extends CI_Model
{
	public function get_franchise_details()
	{
		$this->db->select('tbl_customers.*,franchise_delivery_tbl.delivery_franchise_id,tbl_franchise.fid,tbl_franchise.constitution_of_business,tbl_franchise.franchise_id,tbl_franchise.company_name,tbl_users.username as sales_person_name , tbl_branch.branch_name as sales_person_branch');
		$this->db->from('tbl_customers');
		$this->db->join('state', 'state.id = tbl_customers.state','left');	
		$this->db->join('city', 'city.id = tbl_customers.city','left');	
		$this->db->join('tbl_franchise','tbl_customers.customer_id = tbl_franchise.fid','inner');
		$this->db->join('franchise_delivery_tbl','tbl_customers.customer_id = franchise_delivery_tbl.delivery_franchise_id','left');
		$this->db->join('franchise_assign_pincode','tbl_customers.customer_id = franchise_assign_pincode.customer_id','left');
		$this->db->join('tbl_users','tbl_users.user_id = tbl_customers.sales_person_id','left');
		$this->db->join('tbl_branch','tbl_branch.branch_id = tbl_users.branch_id','left');
		$this->db->where('customer_type','2');
		$this->db->where('tbl_customers.isdeleted','0');
		$this->db->order_by("tbl_customers.cid", "desc");
		$this->db->group_by("tbl_customers.cid");
		$query	=	$this->db->get();
		// echo $this->db->last_query();die;
		return $query->result_array();
	}
	public function get_franchise_details_active()
	{
		$this->db->select('tbl_customers.*,franchise_delivery_tbl.delivery_franchise_id,tbl_franchise.fid,tbl_franchise.constitution_of_business,tbl_franchise.franchise_id,tbl_franchise.company_name');
		$this->db->from('tbl_customers');
		$this->db->join('state', 'state.id = tbl_customers.state','left');	
		$this->db->join('city', 'city.id = tbl_customers.city','left');	
		$this->db->join('tbl_franchise','tbl_customers.customer_id = tbl_franchise.fid','inner');
		$this->db->join('franchise_delivery_tbl','tbl_customers.customer_id = franchise_delivery_tbl.delivery_franchise_id','left');
		$this->db->join('franchise_assign_pincode','tbl_customers.customer_id = franchise_assign_pincode.customer_id','left');
		$this->db->where('customer_type','2');
		$this->db->where('isdeleted','1');
		$this->db->order_by("tbl_customers.cid", "desc");
		$query	=	$this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}

	public function get_franchise_branch_wise()
	{
		$branch_id = $this->session->userdata('branch_id');
		$this->db->select('tbl_customers.*,franchise_delivery_tbl.delivery_franchise_id,tbl_franchise.fid,tbl_franchise.constitution_of_business,tbl_franchise.franchise_id,tbl_franchise.company_name,tbl_users.username as sales_person_name , tbl_branch.branch_name as sales_person_branch');
		$this->db->from('tbl_customers');
		$this->db->join('state', 'state.id = tbl_customers.state','left');	
		$this->db->join('city', 'city.id = tbl_customers.city','left');	
		$this->db->join('tbl_franchise','tbl_customers.customer_id = tbl_franchise.fid','inner');
		$this->db->join('franchise_delivery_tbl','tbl_customers.customer_id = franchise_delivery_tbl.delivery_franchise_id','left');
		$this->db->join('franchise_assign_pincode','tbl_customers.customer_id = franchise_assign_pincode.customer_id','left');
		$this->db->join('tbl_users','tbl_users.user_id = tbl_customers.sales_person_id','left');
		$this->db->join('tbl_branch','tbl_branch.branch_id = tbl_users.branch_id','left');
		$this->db->where('customer_type','2');
		$this->db->where('tbl_customers.isdeleted','0');
		$this->db->where('tbl_customers.branch_id',$branch_id);
		$this->db->order_by("tbl_customers.cid", "desc");
		$this->db->group_by("tbl_customers.cid");
		$query	=	$this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
	public function get_franchise_branch_wise_active()
	{
		$branch_id = $this->session->userdata('branch_id');
		$this->db->select('tbl_customers.*,franchise_delivery_tbl.delivery_franchise_id,tbl_franchise.fid,tbl_franchise.constitution_of_business,tbl_franchise.franchise_id,tbl_franchise.company_name');
		$this->db->from('tbl_customers');
		$this->db->join('state', 'state.id = tbl_customers.state','left');	
		$this->db->join('city', 'city.id = tbl_customers.city','left');	
		$this->db->join('tbl_franchise','tbl_customers.customer_id = tbl_franchise.fid','inner');
		$this->db->join('franchise_delivery_tbl','tbl_customers.customer_id = franchise_delivery_tbl.delivery_franchise_id','left');
		$this->db->join('franchise_assign_pincode','tbl_customers.customer_id = franchise_assign_pincode.customer_id','left');
		$this->db->where('customer_type','2');
		$this->db->where('isdeleted','1');
		$this->db->where('tbl_customers.branch_id',$branch_id);
		$this->db->order_by("tbl_customers.cid", "desc");
		$query	=	$this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}

	public function get_master_franchise_details()
	{
		$this->db->select('*');
		$this->db->from('tbl_customers');
		$this->db->join('state', 'state.id = tbl_customers.state','left');	
		$this->db->join('city', 'city.id = tbl_customers.city','left');	
		$this->db->join('tbl_franchise','tbl_customers.customer_id = tbl_franchise.fid','inner');
		$this->db->where('customer_type','1');
		$query	=	$this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}

}