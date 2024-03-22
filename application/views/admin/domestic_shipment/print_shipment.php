
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
  
  
  input[type=text] {
 
  border: none;
  
}
  
</style>
</head>

<body style="font-family:arial; font-size: 12px;">


  <?php
  // print_r($booking);die;
      foreach ($booking as $value) 
      {

        // echo "<pre>";
        // print_r($value);exit();

        $file = Zend_Barcode::draw('code128', 'image', array('text' => $value['pod_no']), array());
            imagepng($file,FCPATH."assets/barcode/label/".$value['pod_no'].".png");


        $gst = $value['cgst'] + $value['igst'] + $value['sgst'];

        $weight_info    = $this->db->query("select * from tbl_domestic_weight_details where booking_id=".$value['booking_id']);
        $risk_type    = $this->db->query("select * from tbl_domestic_booking where booking_id=".$value['booking_id'])->row('risk_type');
      //  echo '<pre>'; print_r($value);
      
       

        // print_r($value['user_id']);die;
        $weightt_info     = $weight_info->row();
        // echo "<pre>";
        // print_r($weightt_info);exit();

        $transfer_mode_q    = $this->db->query("select * from transfer_mode where transfer_mode_id=".$value['mode_dispatch']);        
        $transfer_mode     = $transfer_mode_q->row_array(); 

        // echo "<pre>";
        

        $weight_d = json_decode($weightt_info->weight_details,true);
        // print_r($weightt_info);//exit();
        // print_r($weight_d);exit();

        $whr_c = array("id"=>$value['sender_city']);
        $city_details = $this->basic_operation_m->get_table_row("city",$whr_c);
        $senderCity = $city_details->city;  
        $pin = $value['reciever_pincode']; $dd = $this->db->query("select isODA from pincode where pin_code ='$pin'")->row_array();

        $whr_c = array("id"=>$value['reciever_city']);
        $city_details = $this->basic_operation_m->get_table_row("city",$whr_c);
        $receiverCity = $city_details->city; 
        $copy=2;

        if (isset($multi)) {
           $copy =1;
         } 

        for ($i=0; $i < $copy ; $i++) { 
                    
                    
      ?>

        <table width="1000" border="1" >
          <tbody>
            <tr>
              <td width="221"><img src="<?php echo base_url();?>/assets/company/<?php echo $company_details->logo; ?>"></td>
            <td width="416" align="center"><span style="font-size: 20px;"> <?php echo $company_details->company_name;?></span></br>
             <?php echo $company_details->address;?></br>
             <!-- 477 Mangalwar Peth, Pune - 411011, Maharashtra, India</br> -->
              Phone - <?php echo $company_details->phone_no;?> </br>
              Email - <?php echo $company_details->email;?></br>
          GST NUMBER: <?php echo $company_details->gst_no;?>, </br>PAN NUMBER: AAPFJ8510K</td>
              <td width="341" align="center" valign="top" ><strong>CONSIGNMENT NOTE NUMBER</strong><br><img src="<?php echo base_url(); ?>assets/barcode/label/<?php echo  $value['pod_no'].".png"; ?>" style="width:140px;"></td>
            </tr>
          </tbody>
        </table>
        <table width="1000" border="1" bgcolor="#e9a331">
          <tbody>
            <tr>
              <td width="500" align="center"><strong>Origin: <?php echo $senderCity;?> </strong> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Destination: <?php echo $receiverCity;?> </strong>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong>EWay No: <?php echo $value['eway_no'];?> </strong></td>
              <!-- <td width="605" align="center"><strong>TYPE OF SERVICE: <input type="text"></strong></td> -->
              <td width="500" align="center"> <strong>Product Type :<?= $value['doc_nondoc'];?></strong>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>MODE : <?php echo $transfer_mode['mode_name'];?></strong> &nbsp;&nbsp;&nbsp;<strong>Sevices : <?php if(!empty($dd['isODA'])){echo service_type[$dd['isODA']];}?></strong> 
			 
			 </td>
            </tr>
          </tbody>
        </table>

        <table width="1000" border="1" >
          <tbody>
            <tr bgcolor="#e9a331">
              <td width="401"><strong>CONSIGNOR</strong>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> Customer Id : <?php   $customer_id = $value['customer_id'];
                                             $customer_inf = $this->db->query("select * from tbl_customers where customer_id = '$customer_id'")->row();
                                             echo $customer_inf->cid; ?></strong></td>
              <td width="390" bgcolor="#e9a331"><strong>CONSIGNEE</strong>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> Parcel Type : <?php echo $value['type_shipment']; ?></strong></td>
              <td width="146"><strong>CHARGES</strong></td>
              <td width="155"><strong>AMOUNT</strong></td>
            </tr>
            <tr>
              <td>Name : <?php echo $value['sender_name'];?></td>
              <td>Name : <?php echo $value['reciever_name'];?></td>
              <td>FREIGHT</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['frieht']; }else{ echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td>Company : <?php echo $value['sender_name'];?></td>
              <td>Company : <?php echo $value['contactperson_name'];?></td>
              <td>FUEL HIKE</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['fuel_subcharges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td>Address : <?php echo $value['sender_address'];?></td>
              <td>Address : <?php echo $value['reciever_address'];?></td>
              <td>INSURANCE</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['insurance_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td><?php echo $senderCity;?></td>
              <td><?php echo $receiverCity;?></td>
              <td>CUSTOM</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['other_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
          </tbody>
        </table>
        <table width="1000"  border="1" >
          <tbody>
            <tr>
            <td width="40" height="114" bgcolor="#e9a331"  style="height:20%;" ><p><strong>Pin</strong></p></td>
               <td width="137" ><?php echo $value['sender_pincode'];?></td>
              <td width="51" bgcolor="#e9a331"><strong>Mob</strong></td>
               <td width="131" ><?php echo $value['sender_contactno'];?></td>
              <td width="53" bgcolor="#e9a331" ><p><strong>Pin
              </strong></td>
               <td width="133" ><?php echo $value['reciever_pincode'];?></td>
              <td width="52" bgcolor="#e9a331"><strong>Mob</strong></td>
               <td width="125" ><?php echo $value['reciever_contact'];?></td>
              <td width="315">
              <table width="100%">
                <tr><td width="151" style="border:1px solid black;">PICKUP</td>
                <td width="155" style="border:1px solid black;" align="right"> <?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['pickup_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
              </tr>
                <tr><td width="151" style="border:1px solid black;">  AWB</td>
                <td width="155" style="border:1px solid black;" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['awb_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
              </tr>
              </table>        
            </td>
            </tr>
          </tbody>
        </table>
        <table width="1000" border="1">
          <tbody>
            <tr>
              <td width="133" bgcolor="#e9a331" ><strong>GST No.</strong></td>
             <td width="235"><?php echo $value['sender_gstno'];?></td>
              <td width="147" bgcolor="#e9a331" ><strong>GST No.</strong></td>
             <td width="255"><?php echo $value['receiver_gstno'];?></td>
              <td width="135">WAREHOUSING</td>
              <td width="157" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['warehousing']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
          </tbody>
        </table>
        <table width="1000" border="1">
          <tbody>
            <tr>
              <td width="370" bgcolor="#e9a331" align="center"><strong>E Invoice NO: <?php echo $value['e_invoice'];?></strong>&nbsp;&nbsp;&nbsp;  |  &nbsp;&nbsp;&nbsp;<strong>DETAILS OF CARGO</strong></td>
              <td width="435" bgcolor="#e9a331"  align="center"><strong>NOP : <?php $where = array('booking_id' =>  $value['booking_id']);
		$ress					=	$this->basic_operation_m->getAll('tbl_domestic_weight_details', $where);
		       echo	$ress->row()->no_of_pack;  ?></strong>&nbsp;&nbsp;&nbsp;  |  &nbsp;&nbsp;&nbsp;  <strong>DIMENSION OF CARGO</strong></td>
              <td width="145">TOPAY</td>
              <td width="161" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['green_tax']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
          </tbody>
        </table>
        <table width="1000" border="1">
          <tbody>
            <tr>
              <td><strong>ACTUAL WEIGHT</strong></td>
              <td><strong>CHARGEABLE WEIGHT</strong></td>
              <td width="40" style="width:10px"><strong>BOXES</strong></td>
              <td width="34" style="width:10px"><strong>L</strong></td>
              <td width="34" style="width:10px"><strong>W</strong></td>
              <td width="34" style="width:10px"><strong>H</strong></td>
              <td width="34" style="width:10px"><strong>A.W</strong></td>
              <td width="38" style="width:10px"><strong>V.W</strong></td>
              <td>COD</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['courier_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr style="width: 30px">
              <?php 

                if (empty(@$weight_d['per_box_weight_detail'][0])) {
                  $weight_d['per_box_weight_detail'][0] = $weightt_info->no_of_pack;
                }
              ?>
              <td><?php echo $weightt_info->actual_weight;?></td>
              <td><?php echo $weightt_info->chargable_weight;?></td>
              <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][0];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['length_detail']); echo @$weight[0]; }else{ echo @$weight_d['length_detail'][0]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['breath_detail']); echo @$weight[0]; }else{ echo @$weight_d['breath_detail'][0]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['height_detail']); echo @$weight[0]; }else{ echo @$weight_d['height_detail'][0]; }  ?></td>
              <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][0];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['valumetric_weight_detail']); echo @$weight[0]; }else{ echo @$weight_d['valumetric_weight_detail'][0]; } ?></td>
              <td>ODA</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['delivery_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td bgcolor="#e9a331"><strong>INVOICE VALUE</strong></td>
              <td bgcolor="#e9a331"><strong>INVOICE/E-WAY NUMBER</strong></td>
             <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][1];?></td>
             <td style="width: 34px"><?php  if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['length_detail']); echo @$weight[1]; }else{ echo @$weight_d['length_detail'][1]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['breath_detail']); echo @$weight[1]; }else{ echo @$weight_d['breath_detail'][1]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['height_detail']); echo @$weight[1]; }else{ echo @$weight_d['height_detail'][1]; }  ?></td>
              <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][1];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['valumetric_weight_detail']); echo @$weight[1]; }else{ echo @$weight_d['valumetric_weight_detail'][1]; } ?></td>
              <td>HANDLING</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['transportation_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td><?php echo $value['invoice_value'];?></td>
              <td><?php echo $value['invoice_no'];?></td>
              <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][2];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['length_detail']); echo @$weight[2]; }else{ echo @$weight_d['length_detail'][2]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['breath_detail']); echo @$weight[2]; }else{ echo @$weight_d['breath_detail'][2]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['height_detail']); echo @$weight[2]; }else{ echo @$weight_d['height_detail'][2]; }  ?></td>
              <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][2];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['valumetric_weight_detail']); echo @$weight[2]; }else{ echo @$weight_d['valumetric_weight_detail'][2]; } ?></td>
              <td>APPOINTMENT</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['appt_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td bgcolor="#e9a331"><strong>OWNER CHECKS</strong></td>
              <td bgcolor="#e9a331"><strong> RISK BY : <?php if(!empty($risk_type)){ echo $risk_type; }?></php></strong></td>
              <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][3];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['length_detail']); echo @$weight[3]; }else{ echo @$weight_d['length_detail'][3]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['breath_detail']); echo @$weight[3]; }else{ echo @$weight_d['breath_detail'][3]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['height_detail']); echo @$weight[3]; }else{ echo @$weight_d['height_detail'][3]; }  ?></td>
              <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][3];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['valumetric_weight_detail']); echo @$weight[3]; }else{ echo @$weight_d['valumetric_weight_detail'][3]; } ?></td>
              <td>FOV</td>
              <td align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['fov_charges']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
            <tr>
              <td width="257"><strong>DATE OF BOOKING : <?php echo date('d-m-Y',strtotime($value['booking_date']));?></strong></td>
              <td width="279"><strong>BOOKED BY : <?php 
               if($value['customer_id']==$value['user_id']){
                $user_q    = $this->db->query("select * from tbl_customers where customer_id=".$value['user_id']);
                
                $userData     = $user_q->row_array();
                echo $userData['customer_name'];
               }else{
                $user_q    = $this->db->query("select * from tbl_users where user_id=".$value['user_id']);
                
                $userData     = $user_q->row_array();
                echo $userData['username'];
               }
             ?></strong></td>
              <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][4];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['length_detail']); echo @$weight[4]; }else{ echo @$weight_d['length_detail'][4]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['breath_detail']); echo @$weight[4]; }else{ echo @$weight_d['breath_detail'][4]; } ?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['height_detail']); echo @$weight[4]; }else{ echo @$weight_d['height_detail'][4]; }  ?></td>
              <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][4];?></td>
              <td style="width: 34px"><?php if(@$value['web_or_app'] == 2){ $weight = json_decode(@$weight_d['valumetric_weight_detail']); echo @$weight[4]; }else{ echo @$weight_d['valumetric_weight_detail'][4]; } ?></td>
              <td width="151">ADDRESS</td>
              <td width="155" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['address_change']; }else{  echo '';} }else{ echo ''; } ?></td>
            </tr>
          </tbody>
        </table>
        <table width="1000" border="1">
          <tbody>
            <tr> 
              <td width="300" height="41">  <?php echo'Description :'.$value['special_instruction']; ?></td>
              <td width="210" align="center" valign="top"><p> <?php $where = array('branch_id'=>$value['branch_id']); $branch = $this->basic_operation_m->get_table_row("tbl_branch",$where); ?>Booking Branch  <?php echo ($branch)?$branch->branch_name:''; ?> <br> Address &amp; Contact No.<?php echo ($branch)?$branch->phoneno:''; ?>
              </p></td>
              <td align="center" width="184">PAYMENT OF TYPE <br><b style="font-size:25px;"><?php echo $value['dispatch_details'];?></b></td>
              <td><table>
                <tr>
                <td width="151" style="border:1px solid black;">DHP</td>
                <td width="155" style="border:1px solid black;" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['dph']; }else{  echo '';} }else{ echo ''; } ?></td>
                </tr>
                <tr>
                <td width="151" style="border:1px solid black;">TOTAL</td>
                <td width="155" style="border:1px solid black;" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['sub_total']; }else{  echo '';} }else{ echo ''; } ?></td>
                </tr>
                <tr>
                <td width="151" style="border:1px solid black;">GST</td>
                <td width="155" style="border:1px solid black;" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $gst; }else{  echo '';} }else{ echo ''; } ?></td>
                </tr>
                <tr>
                <td width="151" style="border:1px solid black;">NET PAYABLE</td>
                <td width="155" style="border:1px solid black;" align="right"><?php if($customer_inf->customer_type != 1 || $customer_inf->customer_type != 2){ if(strtoupper($value['dispatch_details'])=='TOPAY' || strtoupper($value['dispatch_details'])=='CASH'){ echo $value['grand_total']; }else{  echo '';} }else{ echo ''; } ?></td>
                </tr>
              </table></td>
            </tr>
          </tbody>
        </table>
        <table width="1000" border="1">
          <tbody>
            <tr>
              <td width="143" height="64" bgcolor="#e9a331"><strong>  <?php if($i==1){echo'Consignee Signature';}else{echo'Consignor Signature';} ?> </strong></td>
              <td width="85"><input type="text"></td>
              <td width="144" bgcolor="#e9a331"><strong>Date: <input type="text"></strong></td>
              <td width="398">I/We hereby agree to the terms and conditions set forth on the reverse of this (shipper's) copy of this non-negotiasble consignment and warant that information contained on this consignment is true and correct.</td>
              <td width="389" align="center"><strong> <?php if($i==1){echo'POD COPY';}else{echo'SHIPPER COPY';} ?></strong></td>
            </tr>
          </tbody>
        </table>
        <hr>


<?php }
} ?>
</body>
</html>
