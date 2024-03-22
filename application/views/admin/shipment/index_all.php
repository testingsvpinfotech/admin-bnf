<head>
    <title>Parbhat Air Express PVT. LTD.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--<link href="css-main/bootstrap.css" rel="stylesheet" type="text/css" media="all" />-->
    <!--<link href="css3/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">-->
    <!--<link rel="stylesheet" href="css3/style.css">-->
    <link href="<?php echo base_url(); ?>assets/css-main/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url(); ?>assets/css3/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css3/style.css">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid black;
            text-align: left;
            padding: 4px 2px 0 !important;
        }

        tr:nth-child(even) {
            background-color: white;
        }
		.w3layouts{
			padding: 15px 30px 5px;
		}
		table.details tr td{
			font-size: 13px;
			padding: 3px 5px !important;
		}
		td b{
			font-weight: 600;
		}
		hr {
			margin-top: 5px;
			margin-bottom: 5px;
		}
    </style>    
<script>

//window.onload= function () { 
//    window.print();
//setTimeout(function(){
//window.close();
//},500 )
//   }  
   </script>
</head>
<body>
 <?php
                    foreach ($booking as $value) {
                    ?>
<!--    <button onclick="printContent('div1')">Print Content</button>-->
    <div class="agile-its" style="border:2px solid blue;width:700px;margin: 10px auto;" >
        <img src="<?php echo base_url(); ?>assets/images/pae-logo.png" style="margin-left: 26px;" height="70px" Width="150px">	<h2 style="font-family:bold;margin-top: -73px;font-size: 25px;">Parbhat Air Express Pvt. Ltd.</h2>

        <div class="w3layouts">
            
            <div class="photos-upload-view">
                <form action="#" method="POST">
                    <div class="agileinfo">
                    </div>
                   
                    <div class="agileinfo-row" >
						<table class="details">
							<tr>
								<td colspan="2"><b>ADDRESS</b>: Parbhat Air Express Shop NO.03,Opp-Dhuri Ind.Complex No.01, Sativali Road,Valiv Phata, Vasai-Virar, Maharashtra 401208.</td>
							</tr>
							<tr>
								<td><b>EMAIL:</b> sales@prabhatairexpress.com</td>
								<td><b>WEBSITE:</b> www.prabhatairexpress.com</td>
							</tr>
							<tr>
								<td colspan="2"><b>Contact No.:</b> +91-9890397701</td>
							</tr>
							<tr>
								<td><b>BOOKING DATE:</b> <?php echo date('d-m-Y', strtotime($value['booking_date']));?></td>
								<td><b>AWB NO:</b> <?php echo $value['pod_no'];?></td>
							</tr>
							<tr>
								<td><b>MODE:</b> <?php echo $value['mode_dispatch'];?></td>
								<td><b>Method:</b> <?php echo $value['dispatch_details'];?></td>
							</tr>
							<tr>
								<td>
								<b>FROM: </b>
									<?php
										$resAct = $this->db->query("select * from city where id=".$value['sender_city']);
										$city_sender = $resAct->row()->city;
										$sender_stateid = $resAct->row()->state_id;
										echo $city_sender;
									?>	
								</td>
								<td>
								<b>DESTINATION:</b>
									<?php
										$resAct1 = $this->db->query("select * from city where id=".$value['reciever_city']);
										$city_reciever= $resAct1->row()->city;
										$reciever_stateid = $resAct1->row()->state_id;
										echo $city_reciever;
									?> 
								</td>
							</tr>
						</table>
						<hr>
						<table class="details">
							<tr>
								<td colspan="2"><b>CONSIGNOR NAME: </b> <?php echo $value['sender_name'];?></td>
							</tr>
							<tr>
								<td colspan="2"><b>ADDRESS: </b> <?php echo $value['sender_address'];?></td>
							</tr>
							<tr>
								<td><b>CITY:</b> <?php echo $city_sender;?></td>
								<td><b>STATE:</b> 
								<?php
                                        $resAct2 = $this->db->query("select * from state where id=".$sender_stateid."");
                                        echo $sender_state = $resAct2->row()->state;
                                    ?>
								</td>
							</tr>
							<tr>
								<td><b>GSTN NO:</b> <?php echo $value['sender_gstno'];?></td>
								<td><b>PINCODE:</b> <?php echo $value['sender_pincode'];?> </td>
							</tr>
							<tr>
								<td colspan="2"><b>Contact No:</b> <?php echo $value['sender_contactno'];?></td>
							</tr>
							<tr>
								<td><b>INVOICE NO:</b> <?php echo $value['invoice_no'];?></td>
								<td><b>INVOICE VALUE:</b> <?php echo $value['insurance_value'];?></td>
							</tr>
						</table>
						<hr>
						<table class="details">
							<tr>
								<td><b>CONSIGNEE NAME: </b> <?php echo $value['reciever_name'];?></td>
								<td><b>ADDRESS: </b> <?php echo $value['reciever_address'];?></td>
							</tr>
							<tr>
								<td><b>CITY:</b> <?php echo $city_reciever;?></td>
								<td><b>STATE:</b> 
								<?php
									$resAct3 = $this->db->query("select * from state where id=".$reciever_stateid."");
									echo $reciever_state = $resAct3->row()->state;
								?>
								</td>
							</tr>
							<tr>
								<td><b>GSTN NO:</b> <?php echo $value['receiver_gstno'];?></td>
								<td><b>PINCODE:</b> <?php echo $value['reciever_pincode'];?> </td>
							</tr>
							<tr>
								<td colspan="2"><b>Contact No:</b> <?php echo $value['reciever_contact'];?></td>
							</tr>
						</table>
                        <hr>
                        <table>
                            <tr>
                                <th>No. Of PKT</th>
                              
                               <!-- <th>Actual Weight</th>  -->
                                <th>Chargeable. Weight</th>
                                
                            </tr>
                          
                            <tr>
                                <td><?php echo $value['no_of_pack'];?></td>
                                
                                <!--<td><?php //echo $weight_value['actual_weight'];?></td> -->
                                <td><?php echo $value['valumetric_weight'];?></td>
                               
                            </tr>
                          


                        </table>
                        <h5 style="margin-top:11px"> We have carefully checked and verified for Parbhat Air Express Pvt. Ltd. </h5>
                        <h5 style="margin-top:10px;font-size: 12px;"> Authorised Sign </h5>
                                <input type="text" id="name" name="name" required="" style="margin-top:-0px;margin-left: 0;width:200px;color:#FF1493;padding: 0;"></h5>
                    </div>
                    
                </form>
            </div>
        </div>    
    </div>    
	<?php
                     }
                    ?>
</body>

