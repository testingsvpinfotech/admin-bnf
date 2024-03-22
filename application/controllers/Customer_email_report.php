<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_email_report extends CI_Controller 
{
	var $data= array();
    function __construct() 
	{
        parent:: __construct();
		$this->load->model('login_model');
        $this->load->model('basic_operation_m');
        $this->load->model('Customer_model');
        $this->load->model('Booking_model');
        $this->load->model('Generate_pod_model');
        
    }
    

    public function send_report_to_all_customer(){
    	$y = date('Y');
    	$data = array();
		$monthly = array();
		$all_customer = $this->basic_operation_m->get_table_result_mis('tbl_customers',['auto_mis'=>'1']);
		// echo '<pre>';print_r($all_customer);die;
		$today 			= date('Y-m-d');
		$previous_date 	= date('Y-m-d', strtotime('today - 30 days'));
		// print_r($all_customer);die;
		if(!empty($all_customer))
		{
			foreach($all_customer as $key => $customer_info)
			{
				$query ="SELECT booking_date,customer_id,sum(tbl_domestic_weight_details.no_of_pack) AS no_of_pack,
							sum(tbl_domestic_weight_details.chargable_weight) AS chargable_weight,count(tbl_domestic_booking.booking_id) AS total_booking	,
							SUM(if(tbl_domestic_booking.is_delhivery_complete = '1', 1, 0)) AS total_deliverd,tbl_domestic_booking.sender_city
							FROM tbl_domestic_booking
							LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id
							WHERE booking_date >= '$previous_date' and  booking_date <= '$today'
							AND customer_id = '$customer_info->customer_id'
							GROUP BY tbl_domestic_booking.booking_date";
							
				$customer_month_report = $this->basic_operation_m->get_query_result($query);
			
				$email_body 	="<p>Dear Sir,</p>";
				$email_body 	="<p>Greetings from Box N Freight!!!</p>";
				$email_body 	.="<p> Kindly find herewith enclosed updated MIS as on ".$today." for M/s ".@$customer_info->customer_name." for your ready perusal.</p>";
				$email_body 	.="<p>If you need any further details, please let us know.</p>";
				$email_body 	.="<p><b> Note: Its System generated MIS report if any query CONTACT US ON EMAIL: CUSTOMERCARE@BOXNFREIGHT.COM PHONE: +91 98195 98197</b></p>";

				// $email_body 	.="<p> Please find the daily MIS report for the booking done in last 30 days, you can find the details in the attachment. Summary of booking in last 30 days as below. <br>
				// 					Note: Its System generated MIS report if any query CONTACT US ON EMAIL:
				// 					CUSTOMERCARE@BOXNFREIGHT.COM PHONE: +91 98195 98197</p><br>";

				// $email_body 	.="<h3>Customer : ".@$customer_info->customer_name." (".@$customer_info->cid.")</h3>";
				

				// $email_body  	.= '<table><thead><tr><td>SR NO</td><td>BOOKING DATE</td><td>BOX QTY</td><td>WEIGHT</td><td>NO OF CONSIGNMENT TOTAL</td><td>BOX DEL</td><td>RTO</td><td>BAL</td></tr></thead><tbody>';
				
				if (!empty($customer_month_report)) 
				{
					// foreach ($customer_month_report as $key => $value) 
					// {
					// 	$email_body .="<tr><td>".($key + 1 )."</td>";
					// 	$email_body .="<td>".$value->booking_date."</td>";
					// 	$email_body .="<td>".$value->no_of_pack."</td>";
					// 	$email_body .="<td>".$value->chargable_weight."</td>";
					// 	$email_body .="<td>".$value->total_booking."</td>";
					// 	$email_body .="<td>".$value->total_deliverd."</td>";
					// 	$email_body .="<td>0</td>";
					// 	$email_body .="<td>".($value->total_booking - $value->total_deliverd)."</td></tr>";
					// }
					
					// $email_body .="</tbody></html>";
					
					$domestic_allpoddata 	= $this->Generate_pod_model->get_domestic_tracking_data_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and booking_date >= '$previous_date' and  booking_date <= '$today'","","");
					$booked 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Booked' and booking_date >= '$previous_date' and  booking_date <= '$today'"); 
					$Delivered 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Delivered' and tracking_date >= '$previous_date' and  tracking_date <= '$today'");
					$Undelivered 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Undelivered'  and tracking_date >= '$previous_date' and  tracking_date <= '$today'"); 
					$In_Transit 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'In Transit'  and tracking_date >= '$previous_date' and  tracking_date <= '$today'"); 
					$out_for_delivery 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Out For Delivery' and tracking_date >= '$previous_date' and  tracking_date <= '$today'"); 
					$pod_image 	= $this->Generate_pod_model->get_pod_image_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_upload_pod.booking_date >= '$previous_date' and  tbl_upload_pod.booking_date <= '$today'"); 
					
					$header =	array("SrNo","AWB" ,"Date","Origin","Destination","Mode","ForwordingNo","Bill Type","Account Name","Consignor","Consginee","Consginee Address","Consignee Pincode","Invoice No","Invoice Value","QTY","A W","CW","EDD","Status","Actual Delivery Date","TAT","Remarks","RTO Date","RTO Reason","POD_LINK");
					
					// ,"Network"
					$date=date('d-m-Y');
					$filename = "assets/Mis_report_".$customer_info->cid.'_'.$date.".csv";
					$fp = fopen($filename, 'wb');
					
					//header('Content-type: application/csv');
					//header('Content-Disposition: attachment; filename='.$filename);

					fputcsv($fp, $header);
					$i =1;
                    // echo '<pre>';print_r($domestic_allpoddata);
					foreach($domestic_allpoddata as $value_d) 
					{
						$tat 				= 0;
						$rto_reason 		= '';
						$rto_date 			= '';
						$delivery_date 		= '';
						$value_d['status'] 	= trim($value_d['status']);
						if($value_d['status'] == 'RTO')
						{
							$rto_reason 	= $value_d['comment'];
							$rto_date 		= $value_d['tracking_date'];
							$value_d['status'] = $value_d['status'];
						}

						if ($value_d['status']=='In transit' || 
							$value_d['status']=='Undelivered' || 
							$value_d['status']=='Booked' || 
							$value_d['status']=='Pending' || 
							$value_d['status']=='Door Close' || 
							$value_d['status']=='Out For Delivery' || 
							$value_d['status']=='Hold'
						){
							$value_d['status'] = "Pending";
						}

						

						if (
							$value_d['status']=='RTO' || 
							$value_d['status']=='Return' || 
							$value_d['status']=='Return to Orgin' || 
							$value_d['status']=='Door Close' || 
							$value_d['status']=='Address ok no search person' || 
							$value_d['status']=='Address not found' || 
							$value_d['status']=='No service' || 
							$value_d['status']=='No service area' ||
							$value_d['status']=='Refuse' || 
							$value_d['status']=='Wrong address' || 
							$value_d['status']=='Person expired' || 
							$value_d['status']=='Lost Intransit' || 
							$value_d['status']=='Not collected by consignee' || 
							$value_d['status']=='Not collected by consignee' || 
							$value_d['status']=='Delivery not attempted'
						) {
							$value_d['status'] = "RTO";
						}
				
						$pod_inage = '';
						if($value_d['is_delhivery_complete'] == '1')
						{
							$delivery_date 		= $value_d['tracking_date'];
							$value_d['status'] = 'Delivered';
							
							$booking_date 		= $start = date('d-m-Y', strtotime($value_d['booking_date']));
							$start 				= date('d-m-Y', strtotime($value_d['booking_date']));
							$end 				= date('d-m-Y', strtotime($value_d['tracking_date']));
							$tat 				= ceil(abs(strtotime($start)-strtotime($end))/86400);
							
							$pod_inagee			= $this->basic_operation_m->get_query_row("select * from tbl_upload_pod where pod_no='".$value_d['pod_no']."'");
							if(!empty($pod_inagee))
							{
								$pod_inage			=  base_url().'assets/pod/'.$pod_inagee->image;
							}
							
						}
						$sender_cityid = $value_d['sender_city'];
						$sender =  $this->db->query("select * from city where id = '$sender_cityid'")->row();
                        
						// $row=array($i,date('d-m-Y', strtotime($value_d['booking_date'])),$value_d['pod_no'],$value_d['forworder_name'],$value_d['company_type'],$value_d['forwording_no'],$value_d['city'],$value_d['sender_name'],$value_d['reciever_name'],$value_d['reciever_address'],$value_d['reciever_pincode'],$value_d['doc_nondoc'],($value_d['chargable_weight']),$value_d['no_of_pack'],$value_d['dispatch_details'],$value_d['status'],$delivery_date,$value_d['delivery_date'],$tat,$value_d['comment'],$rto_date,$rto_reason,"'".$value_d['ref_no']."'",$value_d['status']." : ".$value_d['comment'],$pod_inage);
						$row=array($i,$value_d['pod_no'],date('d-m-Y', strtotime($value_d['booking_date'])),$sender->city,$value_d['city'],$value_d['mode_name'],$value_d['forwording_no'],$value_d['dispatch_details'],$value_d['customer_name'],$value_d['sender_name'],$value_d['reciever_name'],$value_d['reciever_address'],$value_d['reciever_pincode'],$value_d['invoice_no'],$value_d['invoice_value'],$value_d['no_of_pack'],($value_d['chargable_weight']),($value_d['chargable_weight']),'',$value_d['status'],$delivery_date,$tat,$value_d['comment'],$rto_date,$rto_reason,$pod_inage);
						$i++;
						fputcsv($fp, $row);

					}
					fclose($fp);
					// $total_booking = $domestic_allpoddata['total_booking'];

				// 	$email_body .= '<table border="1" style="border-collapse: collapse; width:400px;">
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th colspan="2" style="padding-left:10">
				//  Booking Summary for last 30 days</th>
				//    </tr>
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th colspan="2">Customer Name :'.@$customer_info->customer_name.'</th>
				//    </tr>
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th colspan="2">Date Range Between : '.date('Y/m/d', strtotime('-30 days')).'To'.date("Y/m/d") .'</th>
				//    </tr>
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th>Status</th>
				// 	 <th>Total Count</th>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">Total Booked</td>
				// 	 <td style="text-align:center;">'.count($domestic_allpoddata).'</td>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">Booking</td>
				// 	 <td style="text-align:center;">'.$booked.'</td>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">Delivered</td>
				// 	 <td style="text-align:center;">'.$Delivered.'</td>
				//    </tr>
				// 	<tr>
				// 	 <td style="padding-left:4px;">Undelivered</td>
				// 	 <td style="text-align:center;">'.$Undelivered.'</td>
				//    </tr>
				// 	<tr>
				// 	 <td style="padding-left:4px;">In Transit</td>
				// 	 <td style="text-align:center;">'.$In_Transit.'</td>
				//    </tr>
				// 	<tr>
				// 	 <td style="padding-left:4px;">Out For Delivery</td>
				// 	 <td style="text-align:center;">'.$out_for_delivery.'</td>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">POD Updated</td>
				// 	 <td style="text-align:center;">'.$pod_image.'</td>
				//    </tr>
				   
				//  </table>';
				 $email_body .= '<br><br><br><br><b>Thanks & Regards,<br> Box N Freight Logistics Solutions Private Limited </b><br><br> <img src="https://boxnfreight.in/assets/company/company_111.jpg" width="200px">';
				// print_r($email_body);die;
				
					$this->load->library('email');
					$config = Array(
						"protocol" => "smtp",
						"smtp_host" => "ssl://smtp.gmail.com",
						"smtp_port" => 465,
						"smtp_user" => "noreply@boxnfreight.in", // change it to yours
						"smtp_pass" => "qywyjkjcuokfidhc", // change it to yours
						"smtp_timeout"=>20,
						"mailtype" => "html",
						"charset" => "iso-8859-1",
						"wordwrap" => TRUE,
					);
					
					
					$config['newline'] = "\r\n";
		
			      $destination_array = explode(';', $customer_info->mis_emailids);

				    foreach($destination_array as $email){
					$this->email->clear(TRUE);
					$subject = 'Daily Report '.date('Y-m-d');
					$this->email->initialize($config);// add this line
					$this->email->from('noreply@boxnfreight.in', 'Box N Freight Logistics Solutions Pvt. Ltd');
					$this->email->to($email); 
					// $this->email->to("mobile.svpinfotech@gmail.com"); 
					// $this->email->to('rk.svpinfotech@gmail.com'); //$customer_info->email
					// $this->email->cc('pankaj.g@boxnfreight.com'); //$customer_info->email
					$this->email->subject($subject);
					$this->email->message($email_body);  
					$this->email->attach($filename);
					if ($this->email->send()) {
						$data = [
							'cust_code'=>$customer_info->cid,
							'email'=>$email
						];
						$this->db->insert('mis_email',$data);
						echo 'its send '.$email.'<br>';
					}else{
						echo "<hr>";
						echo $this->email->print_debugger();
						echo "<hr>";
					}
					
				}
				}
			}exit;
		}


		
	
		return $data;
    }
    public function send_report_mis_customer(){
    	$y = date('Y');
    	$data = array();
		$monthly = array();
		$all_customer = $this->basic_operation_m->get_table_result('tbl_customers',['customer_id'=>'639']);
		if(!empty($all_customer))
		{
			
			foreach($all_customer as $key => $customer_info)
			{
				$query ="SELECT booking_date,customer_id,sum(tbl_domestic_weight_details.no_of_pack) AS no_of_pack,
							sum(tbl_domestic_weight_details.chargable_weight) AS chargable_weight,count(tbl_domestic_booking.booking_id) AS total_booking	,
							SUM(if(tbl_domestic_booking.is_delhivery_complete = '1', 1, 0)) AS total_deliverd,tbl_domestic_booking.sender_city
							FROM tbl_domestic_booking
							LEFT JOIN tbl_domestic_weight_details ON tbl_domestic_weight_details.booking_id = tbl_domestic_booking.booking_id
							WHERE MONTH(booking_date) = MONTH(CURRENT_DATE())
                            AND YEAR(booking_date) = YEAR(CURRENT_DATE())
							AND customer_id = '$customer_info->customer_id'
							GROUP BY tbl_domestic_booking.booking_date";
							
				$customer_month_report = $this->basic_operation_m->get_query_result($query);
				// die;
			
				$email_body 	="<p>Dear Sir,</p>";
				$email_body 	="<p>Greetings from Box N Freight!!!</p>";
				$email_body 	.="<p> Kindly find herewith enclosed updated MIS  for M/s ".@$customer_info->customer_name." for your ready perusal.</p>";
				$email_body 	.="<p>If you need any further details, please let us know.</p>";
				$email_body 	.="<p><b> Note: Its System generated MIS report if any query CONTACT US ON EMAIL: CUSTOMERCARE@BOXNFREIGHT.COM PHONE: +91 98195 98197</b></p>";

				// $email_body 	.="<p> Please find the daily MIS report for the booking done in last 30 days, you can find the details in the attachment. Summary of booking in last 30 days as below. <br>
				// 					Note: Its System generated MIS report if any query CONTACT US ON EMAIL:
				// 					CUSTOMERCARE@BOXNFREIGHT.COM PHONE: +91 98195 98197</p><br>";

				// $email_body 	.="<h3>Customer : ".@$customer_info->customer_name." (".@$customer_info->cid.")</h3>";
				

				// $email_body  	.= '<table><thead><tr><td>SR NO</td><td>BOOKING DATE</td><td>BOX QTY</td><td>WEIGHT</td><td>NO OF CONSIGNMENT TOTAL</td><td>BOX DEL</td><td>RTO</td><td>BAL</td></tr></thead><tbody>';
				
				if (!empty($customer_month_report)) 
				{
					// foreach ($customer_month_report as $key => $value) 
					// {
					// 	$email_body .="<tr><td>".($key + 1 )."</td>";
					// 	$email_body .="<td>".$value->booking_date."</td>";
					// 	$email_body .="<td>".$value->no_of_pack."</td>";
					// 	$email_body .="<td>".$value->chargable_weight."</td>";
					// 	$email_body .="<td>".$value->total_booking."</td>";
					// 	$email_body .="<td>".$value->total_deliverd."</td>";
					// 	$email_body .="<td>0</td>";
					// 	$email_body .="<td>".($value->total_booking - $value->total_deliverd)."</td></tr>";
					// }
					
					// $email_body .="</tbody></html>";
					
					$domestic_allpoddata 	= $this->Generate_pod_model->get_domestic_tracking_data_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and MONTH(booking_date) = MONTH(CURRENT_DATE()) AND YEAR(booking_date) = YEAR(CURRENT_DATE())","","");
					// $booked 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Booked' and booking_date >= '$previous_date' and  booking_date <= '$today'"); 
					// $Delivered 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Delivered' and tracking_date >= '$previous_date' and  tracking_date <= '$today'");
					// $Undelivered 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Undelivered'  and tracking_date >= '$previous_date' and  tracking_date <= '$today'"); 
					// $In_Transit 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'In Transit'  and tracking_date >= '$previous_date' and  tracking_date <= '$today'"); 
					// $out_for_delivery 	= $this->Generate_pod_model->get_count_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_domestic_tracking.status = 'Out For Delivery' and tracking_date >= '$previous_date' and  tracking_date <= '$today'"); 
					// $pod_image 	= $this->Generate_pod_model->get_pod_image_email("tbl_domestic_booking.customer_id = '$customer_info->customer_id' and tbl_upload_pod.booking_date >= '$previous_date' and  tbl_upload_pod.booking_date <= '$today'"); 
					
					$header =	array("SrNo","AWB" ,"Date","Origin","Destination","Mode","ForwordingNo","Bill Type","Account Name","Consignor","Consginee","Consginee Address","Consignee Pincode","Invoice No","Invoice Value","QTY","A W","CW","EDD","Status","Actual Delivery Date","TAT","Remarks","RTO Date","RTO Reason","POD_LINK");
					
					// ,"Network"
					$date=date('d-m-Y');
					$filename = "assets/Mis_report_".$customer_info->cid.'_'.$date.".csv";
					$fp = fopen($filename, 'wb');
					
					//header('Content-type: application/csv');
					//header('Content-Disposition: attachment; filename='.$filename);

					fputcsv($fp, $header);
					$i =1;
                    // echo '<pre>';print_r($domestic_allpoddata);
					foreach($domestic_allpoddata as $value_d) 
					{
						$tat 				= 0;
						$rto_reason 		= '';
						$rto_date 			= '';
						$delivery_date 		= '';
						$value_d['status'] 	= trim($value_d['status']);
						if($value_d['status'] == 'RTO')
						{
							$rto_reason 	= $value_d['comment'];
							$rto_date 		= $value_d['tracking_date'];
							$value_d['status'] = $value_d['status'];
						}

						if ($value_d['status']=='In transit' || 
							$value_d['status']=='Undelivered' || 
							$value_d['status']=='Booked' || 
							$value_d['status']=='Pending' || 
							$value_d['status']=='Door Close' || 
							$value_d['status']=='Out For Delivery' || 
							$value_d['status']=='Hold'
						){
							$value_d['status'] = "Pending";
						}

						

						if (
							$value_d['status']=='RTO' || 
							$value_d['status']=='Return' || 
							$value_d['status']=='Return to Orgin' || 
							$value_d['status']=='Door Close' || 
							$value_d['status']=='Address ok no search person' || 
							$value_d['status']=='Address not found' || 
							$value_d['status']=='No service' || 
							$value_d['status']=='No service area' ||
							$value_d['status']=='Refuse' || 
							$value_d['status']=='Wrong address' || 
							$value_d['status']=='Person expired' || 
							$value_d['status']=='Lost Intransit' || 
							$value_d['status']=='Not collected by consignee' || 
							$value_d['status']=='Not collected by consignee' || 
							$value_d['status']=='Delivery not attempted'
						) {
							$value_d['status'] = "RTO";
						}
				
						$pod_inage = '';
						if($value_d['is_delhivery_complete'] == '1')
						{
							$delivery_date 		= $value_d['tracking_date'];
							$value_d['status'] = 'Delivered';
							
							$booking_date 		= $start = date('d-m-Y', strtotime($value_d['booking_date']));
							$start 				= date('d-m-Y', strtotime($value_d['booking_date']));
							$end 				= date('d-m-Y', strtotime($value_d['tracking_date']));
							$tat 				= ceil(abs(strtotime($start)-strtotime($end))/86400);
							
							$pod_inagee			= $this->basic_operation_m->get_query_row("select * from tbl_upload_pod where pod_no='".$value_d['pod_no']."'");
							if(!empty($pod_inagee))
							{
								$pod_inage			=  base_url().'assets/pod/'.$pod_inagee->image;
							}
							
						}
						$sender_cityid = $value_d['sender_city'];
						$sender =  $this->db->query("select * from city where id = '$sender_cityid'")->row();
                        
						// $row=array($i,date('d-m-Y', strtotime($value_d['booking_date'])),$value_d['pod_no'],$value_d['forworder_name'],$value_d['company_type'],$value_d['forwording_no'],$value_d['city'],$value_d['sender_name'],$value_d['reciever_name'],$value_d['reciever_address'],$value_d['reciever_pincode'],$value_d['doc_nondoc'],($value_d['chargable_weight']),$value_d['no_of_pack'],$value_d['dispatch_details'],$value_d['status'],$delivery_date,$value_d['delivery_date'],$tat,$value_d['comment'],$rto_date,$rto_reason,"'".$value_d['ref_no']."'",$value_d['status']." : ".$value_d['comment'],$pod_inage);
						$row=array($i,$value_d['pod_no'],date('d-m-Y', strtotime($value_d['booking_date'])),$sender->city,$value_d['city'],$value_d['mode_name'],$value_d['forwording_no'],$value_d['dispatch_details'],$value_d['customer_name'],$value_d['sender_name'],$value_d['reciever_name'],$value_d['reciever_address'],$value_d['reciever_pincode'],$value_d['invoice_no'],$value_d['invoice_value'],$value_d['no_of_pack'],($value_d['chargable_weight']),($value_d['chargable_weight']),'',$value_d['status'],$delivery_date,$tat,$value_d['comment'],$rto_date,$rto_reason,$pod_inage);
						$i++;
						fputcsv($fp, $row);

					}
					fclose($fp);
					// $total_booking = $domestic_allpoddata['total_booking'];

				// 	$email_body .= '<table border="1" style="border-collapse: collapse; width:400px;">
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th colspan="2" style="padding-left:10">
				//  Booking Summary for last 30 days</th>
				//    </tr>
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th colspan="2">Customer Name :'.@$customer_info->customer_name.'</th>
				//    </tr>
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th colspan="2">Date Range Between : '.date('Y/m/d', strtotime('-30 days')).'To'.date("Y/m/d") .'</th>
				//    </tr>
				//    <tr style="background-color:#d3d3d3;">
				// 	 <th>Status</th>
				// 	 <th>Total Count</th>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">Total Booked</td>
				// 	 <td style="text-align:center;">'.count($domestic_allpoddata).'</td>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">Booking</td>
				// 	 <td style="text-align:center;">'.$booked.'</td>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">Delivered</td>
				// 	 <td style="text-align:center;">'.$Delivered.'</td>
				//    </tr>
				// 	<tr>
				// 	 <td style="padding-left:4px;">Undelivered</td>
				// 	 <td style="text-align:center;">'.$Undelivered.'</td>
				//    </tr>
				// 	<tr>
				// 	 <td style="padding-left:4px;">In Transit</td>
				// 	 <td style="text-align:center;">'.$In_Transit.'</td>
				//    </tr>
				// 	<tr>
				// 	 <td style="padding-left:4px;">Out For Delivery</td>
				// 	 <td style="text-align:center;">'.$out_for_delivery.'</td>
				//    </tr>
				//    <tr>
				// 	 <td style="padding-left:4px;">POD Updated</td>
				// 	 <td style="text-align:center;">'.$pod_image.'</td>
				//    </tr>
				   
				//  </table>';
				 $email_body .= '<br><br><br><br><b>Thanks & Regards,<br> Box N Freight Logistics Solutions Private Limited </b><br><br> <img src="https://boxnfreight.in/assets/company/company_111.jpg" width="200px">';
				// print_r($email_body);die;
				
					$this->load->library('email');
					$config = Array(
						"protocol" => "smtp",
						"smtp_host" => "ssl://smtp.gmail.com",
						"smtp_port" => 465,
						"smtp_user" => "noreply@boxnfreight.in", // change it to yours
						"smtp_pass" => "qywyjkjcuokfidhc", // change it to yours
						"smtp_timeout"=>20,
						"mailtype" => "html",
						"charset" => "iso-8859-1",
						"wordwrap" => TRUE,
					);
					
					
					$config['newline'] = "\r\n";
			//  echo '<pre>';	print_r($customer_info->mis_emailids);
			 $destination_array = explode(';', $customer_info->mis_emailids);
			    //  print_r($destination_array);
				    foreach($destination_array as $email){
					$this->email->clear(TRUE);
					$subject = 'Daily Report '.date('Y-m-d');
					$this->email->initialize($config);// add this line
					$this->email->from('noreply@boxnfreight.in', 'Box N Freight Logistics Solutions Pvt. Ltd');
					$this->email->to($email); 
					// $this->email->to("mobile.svpinfotech@gmail.com"); 
					// $this->email->to('rk.svpinfotech@gmail.com'); //$customer_info->email
					// $this->email->cc('pankaj.g@boxnfreight.com'); //$customer_info->email
					$this->email->subject($subject);
					$this->email->message($email_body);  
					$this->email->attach($filename);
					if ($this->email->send()) {
						echo 'its send '.$email.' <br>';
					}else{
						echo "<hr>";
						echo $this->email->print_debugger();
						echo "<hr>";
					}
					
				}
				}
			}exit;
		}


		
	
		return $data;
    }


	
}
?>
