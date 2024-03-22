<?php

defined('BASEPATH') or exit('No direct script access allowed');
use Dompdf\Dompdf;

class Admin_domestic_booking_credit_note extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('basic_operation_m');
		$this->load->model('booking_model');
		$this->load->model('Invoice_model');
		//echo __DIR__;exit;
		if ($this->session->userdata('userId') == '') {
			redirect('admin');
		}
	}
	public function index()
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$data = array();
		$this->load->helper('form_helper');

		$data['getAllInvoices'] = array();
		$data['customer_account_id'] = '';
		$data['company_id'] = '';

		$username = $this->session->userdata("userName");
		$user_id = $this->session->userdata("userId");
		$user_type = $this->session->userdata("userType");


		$whr = array('user_id' => $user_id);
		$res = $this->basic_operation_m->getAll('tbl_users', $whr);
		$branch_id = $res->row()->branch_id;

		if (isset($_POST['submit'])) {
			$fromDate = date("Y-m-d", strtotime($this->input->post('from')));
			$toDate = date("Y-m-d", strtotime($this->input->post('to')));

			$data['customer_account_id'] = $this->input->post('customer_account_id');
			$data['branch_id'] = $this->input->post('branch_id');
			$data['company_id'] = $this->input->post('company_id');

			if ($_SESSION['userType']==1 ||$_SESSION['userType']==10) {
				$id = $this->input->post('invoice_id');
				$data['getAllInvoices'] = $this->db->query("select * from tbl_domestic_invoice_detail where invoice_id ='$id'")->result_array();
			} else {
				$id = $this->input->post('invoice_id');
				$data['getAllInvoices'] = $this->db->query("select * from tbl_domestic_invoice_detail where invoice_id ='$id'")->result_array();
			}
		}
		//if ($this->input->post('submit') == 'print') {
		if (isset($_POST['submit_print'])) {


			$pod = $this->input->post('pod_no');
			$cn_value = $this->input->post('cn_value');
			$id = $this->input->post('invoice_id');
			$credit_value = array_sum($cn_value);
			$this->db->trans_start();
			$invoice_info = $booking = $this->basic_operation_m->getAll('tbl_domestic_invoice', ['id' => $id])->row();
			$max_id = $this->db->query("select MAX(id) as id from tbl_credit_note_invoice")->row('id');
			//   echo $this->db->last_query();die;
			$db_id = $max_id + 1;

			$id = 'CN0500' . $db_id;

			$branch_details = $this->basic_operation_m->get_table_row('tbl_branch', ['branch_id' => $branch_id]);
			$branch_gst = substr(trim($branch_details->gst_number), 0, 2);
			$customer_details = $this->basic_operation_m->get_table_row('tbl_customers', ['customer_id' => $this->input->post('customer_account_id')]);
			$customer_gst = substr(trim($customer_details->gstno), 0, 2);
			$gstCharges = $this->db->query("select * From tbl_gst_setting where id ='1'")->row();

			if ($branch_gst == $customer_gst) {
				// calculation about gst 
				$cgst = ($this->input->post('subtotal') / 100) * $gstCharges->cgst;
				$sgst = ($this->input->post('subtotal') / 100) * $gstCharges->sgst;
				$igst = 0;

				$grand_total1 = $this->input->post('subtotal') + $cgst + $sgst;

			} else {

				$cgst = 0;
				$sgst = 0;
				$igst = ($this->input->post('subtotal') / 100) * $gstCharges->igst;
				$grand_total1 = $this->input->post('subtotal') + $igst;
			}
			date_default_timezone_set('Asia/Kolkata');
			$date = date('Y-m-d');
			$invoice = [
				'credit_note_no' => $id,
				'customer_id' => $invoice_info->invoice_number,
				'invoice_number' => $invoice_info->invoice_number,
				'customer_id' => $this->input->post('customer_account_id'),
				'inc_id' => $this->input->post('invoice_id'),
				'company_id' => $this->input->post('company_id'),
				'sub_total' => $this->input->post('subtotal'),
				'cgst' => $cgst,
				'sgst' => $sgst,
				'igst' => $igst,
				'grand_total' => $grand_total1,
				'created_id' => $user_id,
				'createDtm' => $date,

			];
			$this->db->insert('tbl_credit_note_invoice', $invoice);
			$insert_id = $this->db->insert_id();
			
             $remark = $this->input->post('remarks');
			for ($i = 0; $i < count($pod); $i++) {

				if (!empty($cn_value[$i])) {
					$amount = $cn_value[$i];
					$remarks = $remark[$i];

					$invoice_details = $booking = $this->basic_operation_m->getAll('tbl_domestic_invoice_detail', ['pod_no' => $pod[$i]])->row();
					$data = [
						'credit_note_id' => $insert_id,
						'invoice_id' => $invoice_details->invoice_id,
						'booking_id' => $invoice_details->booking_id,
						'pod_no' => $pod[$i],
						'reciever_name' => $invoice_details->reciever_name,
						'reciever_city' => $invoice_details->reciever_city,
						'mode_dispatch' => $invoice_details->mode_dispatch,
						'booking_date' => $invoice_details->booking_date,
						'amount' => $amount,
						'remarks' => $remarks,
					];
					$this->db->insert('tbl_credit_note_invoice_details', $data);
					$this->db->update('tbl_domestic_invoice_detail', ['cn_status' => 1], ['pod_no' => $pod[$i]]);
				}
			}

			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				$msg = 'Credit Note generated successfully ';
				$class = 'alert alert-success alert-dismissible';
			} else {
				$this->db->trans_rollback();
				$msg = 'Something went to wrong';
				$class = 'alert alert-danger alert-dismissible';
			}
			$this->session->set_flashdata('notify', $msg);
			$this->session->set_flashdata('class', $class);
			redirect("admin/list-domestic-invoice-credit-note");

		}

		if ($_SESSION['userType']==1 ||$_SESSION['userType']==10) {
			$data['customers'] = $this->basic_operation_m->get_query_result_array("SELECT * FROM tbl_customers ORDER BY customer_name ASC");
			$data['branch_id'] = '';
		} else {
			$res = $this->basic_operation_m->getAll('tbl_users', array('user_id' => $user_id));
			$branch = $this->basic_operation_m->getAll('tbl_branch', ['branch_id' => $branch_id]);
			$data['branch_id'] = $res->row()->branch_id;
			$data['branch_name'] = $branch->row()->branch_name;
			$data['customers'] = $this->basic_operation_m->get_query_result_array("SELECT * FROM tbl_customers WHERE branch_id = '$branch_id' ORDER BY customer_name ASC");
		}

		if (!empty($this->input->post('customer_account_id'))) {
			$id = $this->input->post('customer_account_id');
			$data['invoice_list'] = $this->basic_operation_m->get_query_result_array("SELECT tbl_domestic_invoice.* FROM tbl_domestic_invoice JOIN tbl_domestic_invoice_detail ON tbl_domestic_invoice_detail.invoice_id = tbl_domestic_invoice.id WHERE tbl_domestic_invoice.customer_id = '$id' and tbl_domestic_invoice.final_invoice = 1 and (tbl_domestic_invoice_detail.cn_status = 0 OR tbl_domestic_invoice_detail.cn_status IS NULL) GROUP BY tbl_domestic_invoice.invoice_number ORDER BY tbl_domestic_invoice.id DESC");
			//echo $this->db->last_query();die;
		}
		$data['company_list'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_company WHERE 1 ORDER BY company_name ASC');
		//$data['invoice_list']  = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_domestic_invoice WHERE final_invoice = 1 ORDER BY id DESC');
		$this->load->view('admin/booking_domestic_master_cerdit_note/booking_invoice', $data);


	}

	public function getInvoiceNO()
	{
		$customer_id = $this->input->post('customer_id');
		// print_r($customer_id);die;
		$customer_details = $this->db->query("SELECT tbl_domestic_invoice.* FROM tbl_domestic_invoice JOIN tbl_domestic_invoice_detail ON tbl_domestic_invoice_detail.invoice_id = tbl_domestic_invoice.id WHERE tbl_domestic_invoice.customer_id = '$customer_id' and tbl_domestic_invoice.final_invoice = 1 and ( tbl_domestic_invoice_detail.cn_status = 0 OR tbl_domestic_invoice_detail.cn_status IS NULL ) GROUP BY tbl_domestic_invoice.invoice_number ORDER BY tbl_domestic_invoice.id DESC")->result();
		// echo $this->db->last_query();
		// die;
		$data['customer_details'] = $customer_details;
		echo json_encode($data);
	}

	public function delete_credit_note($id=0)
	{
		$this->db->trans_start();
		$booking = $this->basic_operation_m->getAll('tbl_credit_note_invoice', ['id' => $id])->row();
		$updation = $this->basic_operation_m->getAll('tbl_credit_note_invoice_details',['credit_note_id'=>$id])->result();
		foreach($updation as $key =>$value){
			$this->db->update('tbl_domestic_invoice_detail',['cn_status'=>'0'],['pod_no'=>$value->pod_no]);
		}
		$this->db->update('tbl_credit_note_invoice',['isdeleted'=>'1'],['id'=>$id]);
		$this->db->update('tbl_credit_note_invoice_details',['isdeleted'=>'1'],['credit_note_id'=>$id]);
		// $this->db->delete('tbl_credit_note_invoice_details',['credit_note_id'=>$id]);
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$msg = 'Credit Note Deleted successfully ';
			$class = 'alert alert-success alert-dismissible';
		} else {
			$this->db->trans_rollback();
			$msg = 'Something went to wrong';
			$class = 'alert alert-danger alert-dismissible';
		}
		$this->session->set_flashdata('notify', $msg);
		$this->session->set_flashdata('class', $class);
		redirect("admin/list-domestic-invoice-credit-note");
	}
	public function Invoice_credit_lr()
	{
		$pod_no = $this->input->post('pod_no');
		$value = $this->input->post('cn_value');
		$booking = $this->basic_operation_m->getAll('tbl_domestic_booking', ['pod_no' => $pod_no]);
		$booking_amount = $booking->row('sub_total');
		// print_r($_POST);die;
		if ($value > 1) {
			if ($value < $booking_amount) {
				$data = "success";
			} else {
				$data = 'Credit Note Value should be greater than 0 and less than ' . $booking_amount;
			}
		} else {
			$data = 'Credit Note Value should be greater than 0 and less than ' . $booking_amount;
		}
		echo json_encode($data);
	}

	public function invoice_view($id)
	{
		$data['id'] = $id;
		$in = $this->db->query("select tbl_domestic_invoice.*,tbl_credit_note_invoice.cgst as cgst, tbl_credit_note_invoice.sgst as sgst , tbl_credit_note_invoice.sub_total as sub_total ,tbl_credit_note_invoice.igst as igst,tbl_credit_note_invoice.grand_total as grand_total,tbl_credit_note_invoice.credit_note_no, tbl_credit_note_invoice.createDtm as createDtmcredit from tbl_credit_note_invoice join tbl_domestic_invoice on tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id where tbl_credit_note_invoice.id = " . $id . "");
		$data['customer'] = $in->row();
		$branch_id = $in->row('branch_id');
		$data['branch'] = $this->basic_operation_m->get_table_row('tbl_branch', ['branch_id' => $branch_id, 'isdeleted' => 0]);
		$in_de = $this->db->query("select tbl_domestic_invoice_detail.*,tbl_credit_note_invoice_details.amount as amount from tbl_credit_note_invoice_details join tbl_domestic_invoice_detail on tbl_domestic_invoice_detail.pod_no = tbl_credit_note_invoice_details.pod_no where tbl_credit_note_invoice_details.credit_note_id = " . $id);
		$data['allpoddata'] = $in_de->result_array();
		$where = array('id' => 1);
		$data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company', $where);

		// echo "<pre>"; print_r($data); die;

		$this->load->view('admin/booking_domestic_master_cerdit_note/billing_invoice_view', $data);
	}



	public function invoice($offset = 0, $searching = '')
	{
		$data = [];
		if (isset($_GET['from_date'])) {
			$data['from_date'] = $_GET['from_date'];
			$from_date = $_GET['from_date'];
		}
		if (isset($_GET['to_date'])) {
			$data['to_date'] = $_GET['to_date'];
			$to_date = $_GET['to_date'];
		}
		if (isset($_GET['filter'])) {
			$filter = $_GET['filter'];
			$data['filter'] = $filter;
		}
		if (isset($_GET['filter_value'])) {
			$filter_value = $_GET['filter_value'];
			$data['filter_value'] = $filter_value;
		}

		$user_id = $this->session->userdata("userId");
		$data['customer'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');

		$user_type = $this->session->userdata("userType");
		$filterCond = '';
        $all_data = $this->input->get();

			if ($all_data) {
				$filter_value = trim($_GET['filter_value']);

				foreach ($all_data as $ke => $vall) {
					if ($ke == 'filter' && !empty($vall)) {
						if ($vall == 'cn_no') {
							$filterCond .= " AND tbl_credit_note_invoice.credit_note_no = '$filter_value'";
						}
						if ($vall == 'invoice_no') {
							$filterCond .= " AND tbl_credit_note_invoice.invoice_number = '$filter_value'";
						}
						// user_id means customer id
					} elseif ($ke == 'user_id' && !empty($vall)) {
						$filterCond .= " AND tbl_credit_note_invoice.customer_id = '$vall'";
					} elseif ($ke == 'from_date' && !empty($vall)) {
						$filterCond .= " AND tbl_credit_note_invoice.createDtm >= '$vall'";
					} elseif ($ke == 'to_date' && !empty($vall)) {
						$filterCond .= " AND tbl_credit_note_invoice.createDtm <= '$vall'";
					}
				}
			}
			if (!empty($searching)) {
				$filterCond = urldecode($searching);
			}
		if ($_SESSION['userType']==1 ||$_SESSION['userType']==10) {

			    $resActt = $this->db->query("SELECT * FROM tbl_credit_note_invoice  WHERE 1 AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ");
			    $resAct = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_customers.customer_name,tbl_customers.cid,tbl_credit_note_invoice.createDtm as tbl_credit_note_invoice FROM tbl_credit_note_invoice JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE 1 AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ORDER BY tbl_credit_note_invoice.id DESC LIMIT " . $offset . ",50");
				// echo $this->db->query();die;
				$download_query = "SELECT tbl_credit_note_invoice.*,tbl_customers.customer_name,tbl_customers.cid,tbl_credit_note_invoice.createDtm as tbl_credit_note_invoice FROM tbl_credit_note_invoice JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE 1 AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ORDER BY tbl_credit_note_invoice.id DESC";

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/list-domestic-invoice-credit-note';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 50;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {

					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}

		} else {
			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);

			$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
			$branch_id = $res->branch_id;

			$resActt = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice.id as id FROM tbl_credit_note_invoice JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id  WHERE tbl_domestic_invoice.branch_id='$branch_id' AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ");
			$resAct = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice.id as id,tbl_customers.customer_name,tbl_customers.cid FROM tbl_credit_note_invoice JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id  JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE tbl_domestic_invoice.branch_id='$branch_id' AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ORDER BY tbl_credit_note_invoice.id DESC limit " . $offset . ",50");
			$download_query = "SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice.id as id ,tbl_customers.customer_name,tbl_customers.cid FROM tbl_credit_note_invoice JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id  JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE tbl_domestic_invoice.branch_id='$branch_id' AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ORDER BY tbl_credit_note_invoice.id DESC";

			$this->load->library('pagination');

			$data['total_count'] = $resActt->num_rows();
			$config['total_rows'] = $resActt->num_rows();
			$config['base_url'] = 'admin/list-domestic-invoice-credit-note';
			//	$config['suffix'] 				= '/'.urlencode($filterCond);

			$config['per_page'] = 50;
			$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
			$config['full_tag_close'] = '</ul></nav>';
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next paginate_button page-item">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li class="next paginate_button page-item">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = 'Previous';
			$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="paginate_button page-item">';
			$config['reuse_query_string'] = TRUE;
			$config['num_tag_close'] = '</li>';
			$config['attributes'] = array('class' => 'page-link');

			if ($offset == '') {
				$config['uri_segment'] = 3;
				$data['serial_no'] = 1;
			} else {
				$config['uri_segment'] = 3;
				$data['serial_no'] = $offset + 1;
			}


			$this->pagination->initialize($config);
			if ($resAct->num_rows() > 0) {
				$data['allpoddata'] = $resAct->result_array();
			} else {
				$data['allpoddata'] = array();
			}			
		}

		if (isset($_GET['download_report']) && $_GET['download_report'] == 'Download Excel') {
			$resActtt = $this->db->query($download_query);
			$shipment_data = $resActtt->result_array();
			$this->download_data($shipment_data);
		}

		$this->load->view('admin/booking_domestic_master_cerdit_note/view_invoice', $data);

	}
	public function cancel_cn_invoice($offset = 0, $searching = '')
	{
		$data = [];
		if (isset($_GET['from_date'])) {
			$data['from_date'] = $_GET['from_date'];
			$from_date = $_GET['from_date'];
		}
		if (isset($_GET['to_date'])) {
			$data['to_date'] = $_GET['to_date'];
			$to_date = $_GET['to_date'];
		}
		if (isset($_GET['filter'])) {
			$filter = $_GET['filter'];
			$data['filter'] = $filter;
		}
		if (isset($_GET['filter_value'])) {
			$filter_value = $_GET['filter_value'];
			$data['filter_value'] = $filter_value;
		}

		$user_id = $this->session->userdata("userId");
		$data['customer'] = $this->basic_operation_m->get_query_result_array('SELECT * FROM tbl_customers WHERE 1 ORDER BY customer_name ASC');

		$user_type = $this->session->userdata("userType");
		$filterCond = '';
        $all_data = $this->input->get();

			if ($all_data) {
				$filter_value = trim($_GET['filter_value']);

				foreach ($all_data as $ke => $vall) {
					if ($ke == 'filter' && !empty($vall)) {
						if ($vall == 'cn_no') {
							$filterCond .= " AND tbl_credit_note_invoice.credit_note_no = '$filter_value'";
						}
						if ($vall == 'invoice_no') {
							$filterCond .= " AND tbl_credit_note_invoice.invoice_number = '$filter_value'";
						}
						// user_id means customer id
					} elseif ($ke == 'user_id' && !empty($vall)) {
						$filterCond .= " AND tbl_credit_note_invoice.customer_id = '$vall'";
					} elseif ($ke == 'from_date' && !empty($vall)) {
						$filterCond .= " AND tbl_credit_note_invoice.createDtm >= '$vall'";
					} elseif ($ke == 'to_date' && !empty($vall)) {
						$filterCond .= " AND tbl_credit_note_invoice.createDtm <= '$vall'";
					}
				}
			}
			if (!empty($searching)) {
				$filterCond = urldecode($searching);
			}
		if ($_SESSION['userType']==1 ||$_SESSION['userType']==10) {

			    $resActt = $this->db->query("SELECT * FROM tbl_credit_note_invoice  WHERE 1 AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ");
			    $resAct = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_customers.customer_name,tbl_customers.cid,tbl_credit_note_invoice.createDtm as tbl_credit_note_invoice FROM tbl_credit_note_invoice JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE 1 AND tbl_credit_note_invoice.isdeleted ='1' $filterCond ORDER BY tbl_credit_note_invoice.id DESC LIMIT " . $offset . ",50");
				// echo $this->db->query();die;
				$download_query = "SELECT tbl_credit_note_invoice.*,tbl_customers.customer_name,tbl_customers.cid,tbl_credit_note_invoice.createDtm as tbl_credit_note_invoice FROM tbl_credit_note_invoice JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE 1 AND tbl_credit_note_invoice.isdeleted ='1' $filterCond ORDER BY tbl_credit_note_invoice.id DESC";

				$this->load->library('pagination');

				$data['total_count'] = $resActt->num_rows();
				$config['total_rows'] = $resActt->num_rows();
				$config['base_url'] = 'admin/list-domestic-invoice-credit-note';
				//	$config['suffix'] 				= '/'.urlencode($filterCond);

				$config['per_page'] = 50;
				$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
				$config['full_tag_close'] = '</ul></nav>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next paginate_button page-item">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li class="next paginate_button page-item">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = 'Previous';
				$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="paginate_button page-item">';
				$config['reuse_query_string'] = TRUE;
				$config['num_tag_close'] = '</li>';
				$config['attributes'] = array('class' => 'page-link');

				if ($offset == '') {
					$config['uri_segment'] = 3;
					$data['serial_no'] = 1;
				} else {
					$config['uri_segment'] = 3;
					$data['serial_no'] = $offset + 1;
				}


				$this->pagination->initialize($config);
				if ($resAct->num_rows() > 0) {

					$data['allpoddata'] = $resAct->result_array();
				} else {
					$data['allpoddata'] = array();
				}

		} else {
			$username = $this->session->userdata("userName");
			$whr = array('username' => $username);

			$res = $this->basic_operation_m->get_table_row('tbl_users', $whr);
			$branch_id = $res->branch_id;

			$resActt = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice.id as id FROM tbl_credit_note_invoice JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id  WHERE tbl_domestic_invoice.branch_id='$branch_id' AND tbl_credit_note_invoice.isdeleted ='0' $filterCond ");
			$resAct = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice.id as id,tbl_customers.customer_name,tbl_customers.cid FROM tbl_credit_note_invoice JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id  JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE tbl_domestic_invoice.branch_id='$branch_id' AND tbl_credit_note_invoice.isdeleted ='1' $filterCond ORDER BY tbl_credit_note_invoice.id DESC limit " . $offset . ",50");
			$download_query = "SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice.id as id ,tbl_customers.customer_name,tbl_customers.cid FROM tbl_credit_note_invoice JOIN tbl_domestic_invoice ON tbl_domestic_invoice.id = tbl_credit_note_invoice.inc_id  JOIN tbl_customers ON tbl_customers.customer_id = tbl_credit_note_invoice.customer_id WHERE tbl_domestic_invoice.branch_id='$branch_id' AND tbl_credit_note_invoice.isdeleted ='1' $filterCond ORDER BY tbl_credit_note_invoice.id DESC";

			$this->load->library('pagination');

			$data['total_count'] = $resActt->num_rows();
			$config['total_rows'] = $resActt->num_rows();
			$config['base_url'] = 'admin/list-domestic-invoice-credit-note';
			//	$config['suffix'] 				= '/'.urlencode($filterCond);

			$config['per_page'] = 50;
			$config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination">';
			$config['full_tag_close'] = '</ul></nav>';
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next paginate_button page-item">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li class="next paginate_button page-item">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = 'Previous';
			$config['prev_tag_open'] = '<li class="prev paginate_button page-item">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="paginate_button page-item">';
			$config['reuse_query_string'] = TRUE;
			$config['num_tag_close'] = '</li>';
			$config['attributes'] = array('class' => 'page-link');

			if ($offset == '') {
				$config['uri_segment'] = 3;
				$data['serial_no'] = 1;
			} else {
				$config['uri_segment'] = 3;
				$data['serial_no'] = $offset + 1;
			}


			$this->pagination->initialize($config);
			if ($resAct->num_rows() > 0) {
				$data['allpoddata'] = $resAct->result_array();
			} else {
				$data['allpoddata'] = array();
			}			
		}

		if (isset($_GET['download_report']) && $_GET['download_report'] == 'Download Excel') {
			$resActtt = $this->db->query($download_query);
			$shipment_data = $resActtt->result_array();
			$this->download_data($shipment_data);
		}

		$this->load->view('admin/booking_domestic_master_cerdit_note/view_cancel_cn_invoice', $data);

	}

	

	public function download_data($shipment_data)
	{

		$date = date('d-m-Y');
		$filename = "Credit_Note_Invoice_" . $date . ".csv";
		$fp = fopen('php://output', 'w');

		$header = array("Date", "Credit Note No", "Invoice No", "Customer ID", "Customer Name", "Total", "CGST", "SGST", "IGST", "Final Amount");


		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);

		fputcsv($fp, $header);
		$i = 0;
		foreach ($shipment_data as $row) {
			$i++;
			$roww = array(
				date("d-m-Y",strtotime($row['createDtm'])),
				$row['credit_note_no'],
				$row['invoice_number'],
				$row['cid'],
				$row['customer_name'],
				$row['sub_total'],
				$row['cgst'],
				$row['sgst'],
				$row['igst'],
				$row['grand_total']
			);


			fputcsv($fp, $roww);
			// if ($row['doc_type'] == 1) {
			// 	$weight_details = json_decode($row['weight_details']);

			// 	if (!empty($weight_details->per_box_weight_detail)) {
			// 		foreach ($weight_details->per_box_weight_detail as $key => $values) {
			// 			$weight_row = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $values, $weight_details->length_detail[$key], $weight_details->breath_detail[$key], $weight_details->height_detail[$key], $weight_details->valumetric_weight_detail[$key], $weight_details->valumetric_actual_detail[$key], $weight_details->valumetric_chageable_detail[$key]);
			// 			fputcsv($fp, $weight_row);
			// 		}
			// 	}
			// }

		}
		exit;
	}





	public function numberTowords($num)
	{
		error_reporting(0);
		$ones = array(
			1 => "one",
			2 => "two",
			3 => "three",
			4 => "four",
			5 => "five",
			6 => "six",
			7 => "seven",
			8 => "eight",
			9 => "nine",
			10 => "ten",
			11 => "eleven",
			12 => "twelve",
			13 => "thirteen",
			14 => "fourteen",
			15 => "fifteen",
			16 => "sixteen",
			17 => "seventeen",
			18 => "eighteen",
			19 => "nineteen"
		);
		$tens = array(
			1 => "ten",
			2 => "twenty",
			3 => "thirty",
			4 => "forty",
			5 => "fifty",
			6 => "sixty",
			7 => "seventy",
			8 => "eighty",
			9 => "ninety"
		);
		$hundreds = array(
			"hundred",
			"thousand",
			"million",
			"billion",
			"trillion",
			"quadrillion"
		); //limit t quadrillion 
		$num = number_format($num, 2, ".", ",");
		$num_arr = explode(".", $num);
		$wholenum = $num_arr[0];
		$decnum = $num_arr[1];
		$whole_arr = array_reverse(explode(",", $wholenum));
		krsort($whole_arr);
		$rettxt = "";
		foreach ($whole_arr as $key => $i) {
			if ($i < 20) {
				$rettxt .= $ones[$i];
			} elseif ($i < 100) {
				$rettxt .= $tens[substr($i, 0, 1)];
				$rettxt .= " " . $ones[substr($i, 1, 1)];
			} else {
				$rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
				$rettxt .= " " . $tens[substr($i, 1, 1)];
				$rettxt .= " " . $ones[substr($i, 2, 1)];
			}
			if ($key > 0) {
				$rettxt .= " " . $hundreds[$key] . " ";
			}
		}
		if ($decnum > 0) {
			$rettxt .= " and ";
			if ($decnum < 20) {
				$rettxt .= $ones[$decnum];
			} elseif ($decnum < 100) {
				$rettxt .= $tens[substr($decnum, 0, 1)];
				$rettxt .= " " . $ones[substr($decnum, 1, 1)];
			}
		}
		return $rettxt;
	}


}

?>