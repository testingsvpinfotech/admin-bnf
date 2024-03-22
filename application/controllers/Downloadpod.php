<?php
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloadpod extends CI_Controller  {

	var $data = array();
    function __construct() 
	{
        parent :: __construct();
        $this->load->model('basic_operation_m'); 
       
    }
	
	public function download_pod($id) 
	{
		
	    // Load library
	    $this->load->library('zend');
		// Load in folder Zend
		$this->zend->load('Zend/Barcode');
		$whr = array('pod_no' => $id);
		
		if ($id != "") {	
			$data['booking'] = $this->basic_operation_m->get_all_result('tbl_domestic_booking', $whr);
			$where =array('id'=>1);
		    $data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company',$where);
			// echo '<pre>'; print_r($data['booking']); die;
			$html = $this->load->view('admin/download_shipment', $data, true);
		}

		// $html = $this->load->view('admin/booking_domestic_master/booking_print', $data, true);	
		// echo $html; die;
		
		$this->load->library('M_pdf');
        
        $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
        $this->m_pdf->pdf->autoMarginPadding = 'pad';
        $this->m_pdf->pdf->setAutoBottomMargin = 'stretch';

		// $this->m_pdf->pdf->SetHTMLFooter('<div style="text-align: right">Page {PAGENO} out of {nbpg}</div>');
	    $this->m_pdf->pdf->WriteHTML($html);
	    
	    $this->m_pdf->pdf->defaultheaderfontsize=14;
        $this->m_pdf->pdf->defaultheaderfontstyle='B';
        $this->m_pdf->pdf->defaultheaderline=1;
	 
        $this->mpdf->showImageErrors = true;
        $this->mpdf->debug = true;
        
		$type           = 'I';
        $filename = $invoice_series.'_'.$inc_num.'.pdf';
		$savefolderpath = 'assets/invoice/domestic/';
		
        $this->m_pdf->pdf->Output($savefolderpath.$filename, $type);
	}

}

?>

