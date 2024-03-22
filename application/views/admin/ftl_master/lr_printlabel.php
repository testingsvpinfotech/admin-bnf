<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
	
	
	input[type=text] {
 
  border: none;
  
}
	p{padding:0; margin:0;}
	
	
</style>
</head>

<body style="font-family: arial; font-size: 12px;">
   
 
    <?php
    if(!empty($printlabel)){
    foreach($printlabel as $value){
   
       $charges = $this->db->query("SELECT * FROM `lr_product_tbl` WHERE `lr_id` =".$value->lr_id)->result_array();
   
       $copy =2;
       for ($i=0; $i < $copy ; $i++) { ?>
   
<table width="1000" border="0">
  <tbody>
    <tr>
      <td><p style="text-align: center"><strong>SUBJECT TO MUMBAI JURISDICTION</strong></p></td>
    </tr>
  </tbody>
</table>
<table width="1000" border="0">
  <tbody>
    <tr>
      <td><strong>GSTIN:27AAKCB8385Q1ZM</strong></td>
		<td><p style="text-align: right"><strong>INCP NO.:U63040MH2022PTC384756</strong></p></td>
    </tr>
  </tbody>
</table>
<table width="1000" border="0">
  <tbody>
    <tr>
      <td width="109" rowspan="2"><img src="<?= base_url();?>assets/print_label_logo/logo.jpg" width="100" height="73"></td>
      <td height="61" align="center" valign="middle"><img src="<?= base_url();?>assets/print_label_logo/logo2.jpg" width="519" height="57"></td>
      <td width="146" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="731" height="34" align="center" style="font-size:14px;"><p><strong>Regd. Add. : 11th Floor, 1102, Fenkin Belleza, Ghodbunder Road,</strong></p>
      <p><strong>Thane (W), Thane - 400 615. Email: support@boxnfreight.com</strong></p></td>
    </tr>
  </tbody>
</table>

<table width="1000" border="1">
  <tbody>
    <tr>
      <td colspan="2" align="center" style="font-size:14px;"><strong>CONSIGNOR COPY</strong></td>
      <td colspan="2" align="center" style="font-size:14px;"><strong>AT OWNER'S RISK INSURANCE</strong></td>
      <td colspan="2" ><strong>TEMPO / TRUCK NO.</strong></td>
    </tr>
    <tr>
	  <td width="207" colspan="2" rowspan="5" style="font-size:14px;"><p><strong>GST payable under form 38</br> 
	  </strong></p>
	    <p><strong>Charges merchandise by </strong></p>
	    <p>CONSIGNOR<input type="checkbox" <?php if( $value->gst_pay == 1){ echo 'checked' ; }?>>
        </p>
	    <p>CONSIGNEE<input type="checkbox" <?php if( $value->gst_pay == 2){ echo 'checked' ; }?>>
        </p>
	    <p>COMPANY<input type="checkbox" <?php if( $value->gst_pay == 3){ echo 'checked' ; }?>>
      </p></td>
      <td colspan="2" style="border-bottom: none; font-size:14px;"><p><strong>The customer has stated that:</strong></p>
      <p><strong>. he has not isured the consignment of</strong><br>
      <strong>. he has insured the consignment</strong></p></td>
      <td colspan="2" align="center" style="background: #000; Color:#fff;">CONSIGNMENT NOTE:</td>
    </tr>
    <tr>
      <td colspan="2" style="border: none;"><strong>Company</strong>
      <input type="text" style="border-bottom: 1px solid #000;" value="<?php echo $value->insurance_company_name;?>"></td>
      <td width="159" align="center"><strong>No. </strong></td>
      <td width="141" align="center"><strong>Date.</strong></td>
    </tr>
    <tr>
      <td width="168" style="border: none;"><strong>Policy No.</strong><input type="text" style="width:80px; border-bottom: 1px solid #000;" value="<?php echo $value->insurance_number;?>"></td>
      <td width="178" style="border: none;"><strong>Date</strong> <input type="text" style="width:100px; border-bottom: 1px solid #000;"value="<?php echo $value->insurance_date;?>"></td>
      <td><input type="text" style="width:100px;" value="<?php echo $value->lr_number;?>"></td>
      <td><input type="text" style="width:100px;" value="<?php echo $value->booking_date;?>"></td>
    </tr>
    <tr>
      <td style="border: none;"><strong>Amount </strong><input type="text" style="width:100px; border-bottom: 1px solid #000;" value="<?php echo $value->insurance_charges;?>"></td>
      <td style="border: none;"><strong>Risk</strong> <input type="text" style="width:100px; border-bottom: 1px solid #000;"></td>
      <td colspan="2" align="center" style="background: #000; Color:#fff;">ADDRESS OF DELIVERY OFFICE:</td>
    </tr>
    <tr>
      <td colspan="2" style="border: none;">&nbsp;</td>
      <td colspan="2"><input type="text" value="<?php echo $value->sender_address; ?>"></td>
    </tr>
  </tbody>
</table>
<table width="1000" border="0">
  <tbody>
    <tr>
      <td width="682" style="border:none;"><strong>Consignee'r Name &amp; Address</strong> <input type="text" style="width:500px; border-bottom: 1px solid #000;" value="<?php echo $value->sender_name ,  $value->sender_address;?>"></td>
      <td width="65" rowspan="2" style="border:1px solid #000;"><strong>From</strong></td>
      <td width="231" rowspan="2" style="border:1px solid #000;"><input type="text" style="width:200px;"  value = "<?php echo $value->sender_city ;?>"></td>
    </tr>
    <tr>
      <td style="border:none;"><strong>GST No.</strong><input type="text" style="width:628px; border-bottom: 1px solid #000;" value = "<?php echo $value->sender_gstno ;?>"></td>
    </tr>
    <tr>
      <td style="border:none;"><strong>Consignee's Name &amp; Address</strong> <input type="text" style="width:500px; border-bottom: 1px solid #000;"value="<?php echo $value->reciever_name , $value->reciever_address;?>"></td>
      <td rowspan="2" style="border:1px solid #000;"><strong>To</strong></td>
      <td rowspan="2" style="border:1px solid #000;"><input type="text" style="width:200px;"  value = "<?php echo $value->reciever_city ;?>"></td>
    </tr>
    <tr>
      <td style="border:none;"><strong>GST No.</strong><input type="text" style="width:630px; border-bottom: 1px solid #000;" value="<?php echo $value->receiver_gstno;?>"></td>
    </tr>
  </tbody>
</table>


<table width="1000" border="1">
  <tbody>
    <tr>
      <td width="161"><strong>No. of Packages</strong></td>
      <td width="236"><strong>Descraption (Said of Contain)</strong></td>
      <td colspan="2"><strong>Weight Mesurement Declared Wt. Ch. Kg.</strong></td>
      <td width="87"><strong>Rate Per. Kg.</strong></td>
      <td width="53"><strong>Total Frieght</strong></td>
      <td width="291"><strong>Special Instruction</strong></td>
    </tr>
    <tr>
      <td rowspan="9" valign="top"><input type="text" value="<?php echo $charges[0]['product_qty'] ;?>"></td>
      <td rowspan="7"  valign="top" style="border: none;"><input type="text" value="<?php echo $charges[0]['product_name'] ;?>"></td>
      <td width="66" rowspan="9" valign="top"><input type="text" style="width: 50px;" value="<?php echo $charges[0]['declare_weight'] ;?>"></td>
      <td width="60" rowspan="9" valign="top"><input type="text" style="width: 50px;" value="<?php echo $charges[0]['chargable_weight'] ;?>"></td>
      <td><strong>Freight</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['frieht_charge'] ;?>" ></td>
      <td rowspan="4"><strong>Note: You are requested to put money in our Account No. given on the Bilty. Do not given any money to the Driver.</strong></td>
    </tr>
    <tr>
      <td><strong>A.O.C.</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['aso_charge'] ;?>"></td>
    </tr>
    <tr>
      <td><strong>Labour</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['labour_charge'] ;?>"></td>
    </tr>
    <tr>
      <td><strong>St. Charge</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['st_charge'] ;?>"></td>
    </tr>
    <tr>
      <td><strong>L.C.</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['lc_charge'] ;?>"></td>
      <td rowspan="5"><strong>Account Details:<br>
      Name: Box N Freight Logistic Solution Pvt. Ltd.<br>
      Bank Name: HDFC Bank<br>
      A/c. No. : 50200070571278<br>
      IFSC Code: HDFC0000455<br></strong>
      </td>
    </tr>
    <tr>
      <td><strong>Misc.</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['misc_charge'] ;?>"></td>
    </tr>
    <tr>
      <td><strong>Ch.Post etc.</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['ch_post_charge'] ;?>"></td>
    </tr>
    <tr>
      <td style="border:none;"><strong>Bill / CH No.</strong> <input type="text" style="border-bottom: 1px solid #000;" value="<?php echo $value->invoice_number ;?>"></td>
      <td><strong>GST</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['gst_charge'] ;?>" ></td>
    </tr>
    <tr>
      <td height="27" style="border: none;">Value as per Invoice <input type="text" style=" width:100px; border-bottom: 1px solid #000;" value = "<?php echo $value->invoice_value;?>"></td>
      <td><strong>G.Total</strong></td>
      <td><input type="text" style="width: 50px;" value="<?php echo $charges[0]['grand_total'] ;?>"></td>
    </tr>
  </tbody>
</table>
<table width="1000" border="0">
  <tbody>
    <tr>
      <td width="359"><strong>Carrier is not responsible for leakage &amp; breakage</strong></td>
      <td width="233"><strong>Driver's Singnature</strong> <input type="text" style="width: 100px;"></td>
      <td width="386"><strong>Booking Cleark/Authorised Signature</strong> <input type="text" style="width: 100px;"></td>
    </tr>
  </tbody>
</table>

<?php

      } 
    }
}    
?>


</body>
</html>
