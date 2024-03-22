<?php
#echo $prntext;

list($pod_no, $city_sender, $city_reciever, $mode_dispatch, $no_of_pack,$reciever_address) = explode('#|#',$prntext);
if(!empty($pod_no)) {
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $pod_no), array());
    $store_image = imagepng($file,FCPATH."assets/barcode/label/".$pod_no.".png");
	
		$company_details = $this->basic_operation_m->get_table_row('tbl_company',array('id'=>1));
	$mode_details = $this->basic_operation_m->get_table_row('transfer_mode',array('transfer_mode_id'=>$mode_dispatch));
}
?><!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">

  <title>Print Label</title>

  <style>
	html {margin:0;padding:0;}
	body {font-family:Calibri;}
	@media print {
	.page-break { display: block; page-break-before: always; }
	.btn-print {display:none;}
	}
#invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 2.5in;
  background: #FFF;
}

 .label-field-head{
	font-size: 0.9em;
}
 .label-field-val{
	font-size: 0.6em;
}

.main-head{
font-size: 0.7em;letter-spacing: 2px;
}

 .sub-head1{
	font-size: 0.6em;
	width:2.5in;padding-left:0.4in
}

 .sub-head2{
	font-size: 0.6em;letter-spacing: 2px;
}

    </style>

  <script>
  window.console = window.console || function(t) {};
</script>



  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>


</head>

<body translate="no" >
<center style="padding-bottom:20px"><input type="button" value="Print" onclick="window.print();return false;" class="btn-print" style="font-size: 20px; "></center>
<?php
for($i=1;$i<=$no_of_pack;$i++){
?>
  <div id="invoice-POS">

	<table border=0 style="width: 2.5in">
			<tr><td style="width:2.5in;padding-left:1.2in"  colspan="2">
				<span style="margin-top: 0;" class="sub-head2"><strong><?php echo $company_details->phone_no; ?></strong></span>
				</td>
			</tr>
			
			<tr >
			<!--	<td width="10%" valign="top" style="width:0.5in">
					<img src="https://michaeltruong.ca/images/logo1.png" width="30" height="30" border="0">
				</td> -->
				<td valign="top">
					<span style="margin-top: 0;" class="main-head "><center><strong><?php echo $company_details->company_name; ?></strong></center></span>
					
				</td>
			</tr>
	</table>
	<table border=0 style="width: 2.5in">
	        <?php if(!empty($pod_no)) { ?>
	        <tr>
    	        <td colspan="3" style="text-align:center">
    	            <img src="<?php echo base_url()?>assets/barcode/label/<?php echo $pod_no ?>.png" />
    	        </td>
    	        
    	    </tr>
    	    <?php } ?>
			<tr>
					<td  style="width:25%"><span class="label-field-head"><strong>AWB No.</strong></span></td>
					<td valign="bottom" style="align:left" colspan="3">
					<div style="display: block;" class="label-field-val"><?php echo $pod_no;?></div>
					<hr style="width:100%;align:left">
				</td>
			</tr>
			<tr>
					<td  style="width:25%"><span class="label-field-head"><strong>From</strong></span></td>
					<td valign="bottom" style="align:left"  colspan="3">
					<div style="display: block;" class="label-field-val"><?php echo $city_sender;?></div>
					<hr style="width:100%;align:left">
				</td>
			</tr>
			<tr>
					<td  style="width:25%"><span class="label-field-head"><strong>Destination</strong></span></td>
					<td valign="bottom" style="align:left"  colspan="3">
					<div style="display: block;" class="label-field-val"><?php echo $city_reciever;?></div>
					<hr style="width:100%;align:left">
				</td>
			</tr>
				<tr>
					<td  style="width:25%"><span class="label-field-head"><strong>Address</strong></span></td>
					<td valign="bottom" style="align:left"  colspan="3">
					<div style="display: block;" class="label-field-val"><?php echo $reciever_address;?></div>
					<hr style="width:100%;align:left">
				</td>
			</tr>
			<tr>
						<td  style="width:10%"><span style="font-size: 0.6em;"><strong>Pkts</strong></span></td>
					<td valign="bottom" style="align:left"><div style="display: block;" class="label-field-val"><?php echo $i .'/'.$no_of_pack;?></div><hr style="width:100%;align:left"></td>
			</tr>
			<tr>
			    <td  style="width:10%"><span class="label-field-head"><strong>Mode</strong></span></td>
					<td valign="bottom" style="align:left"><div style="display: block;" class="label-field-val"><?php echo $mode_details->mode_name;?></div><hr style="width:100%;align:left"></td>
				
			</tr>
	</table>

	</div>
<?php
}
?>
<!--<center style="padding-top:20px"><input type="button" value="Print" onclick="window.print();return false;" class="btn-print" style="font-size: 20px; "></center>-->

</body>

</html>