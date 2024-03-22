<?php
//echo $prntext;
list($pod_no, $city_sender, $city_reciever, $mode_dispatch, $no_of_pack, $forwardingnumber) = explode('#|#',$prntext);

if(!empty($forwardingnumber)) {
    $file = Zend_Barcode::draw('code128', 'image', array('text' => $forwardingnumber), array());
    $store_image = imagepng($file,FCPATH."assets/barcode/forwarderlabel/".$forwardingnumber.".png");
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
			<tr>
			</tr>
	</table>
	<table border=0 style="width: 2.5in">
			<?php if(!empty($forwardingnumber)) { ?>
	        <tr>
    	        <td colspan="3" style="text-align:center">
    	            <img src="<?php echo base_url()?>assets/barcode/forwarderlabel/<?php echo $forwardingnumber ?>.png" />
    	        </td>
    	    </tr>
    	    <?php } ?>
			<tr>
					<td  style="width:25%"><span class="label-field-head"><strong>C.N.</strong></span></td>
					<td valign="bottom" style="align:left" colspan="3">
					<div style="display: block;" class="label-field-val"><?php echo $forwardingnumber;?></div>
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
					<td valign="bottom" style="align:left"><div style="display: block;" class="label-field-val"><?php echo $mode_dispatch;?></div><hr style="width:100%;align:left"></td>
				
			</tr>
	</table>

	</div>
<?php
}
?>
<!--<center style="padding-top:20px"><input type="button" value="Print" onclick="window.print();return false;" class="btn-print" style="font-size: 20px; "></center>-->

</body>

</html>
