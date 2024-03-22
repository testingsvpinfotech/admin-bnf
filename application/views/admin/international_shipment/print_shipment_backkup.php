<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url(); ?>">
    <title>Om Courier Services</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <!-- TODO Let's include stylesheet files -->
    <link rel="shortcut icon" 	href="assets/pod_assets/media/logo/favicon.png" type="image/x-icon" />
    <link rel="stylesheet"		href="assets/pod_assets/scss/bootstrap.min.css" />
    <link rel="stylesheet"		href="assets/pod_assets/scss/owl.carousel.min.css" />
    <link rel="stylesheet"		href="assets/pod_assets/scss/main.css" />
    <style>
        .logo{
            width: 20%!important;
        }
body {
    color: #535c68;
    font-size: 12px;
    text-transform: none;
    padding-top:0px;
}  
  .container {
    padding: 10px 40px;}      
        
.table td, .table th { padding: 4px !important;}     
 .table-list {
    margin-bottom: 0px;
}    

h3.num {
    padding: 0px;
    margin: 0px;
}
        
        
    </style>
  </head>
  <body>   
    <section class="table-list">
      <div class="container">
        <div class="row">
		<?php
			foreach ($booking as $value) 
			{
				$weight_info 		= $this->db->query("select * from tbl_international_weight_details where booking_id=".$value['booking_id']);
				$weightt_info 		= $weight_info->row();				
										
			?>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pd0">
             <table class="table table-bordered table-one">
                 <thead>
                  <tr>
                    <th scope="col" colspan="3">
                      <img src="<?php echo base_url();?>./assets/images/final_logo/omcourier_logo.png" alt="" class="logo" height="110px" width="500 px">
                      <h4>Om Courier Services</h4>
                       <small>
                        Address : Shop No. 1, om deep sai pooja chs, Charai Naka,<br>Dr, Lazarus Rd, near Almeida Signal,Thane West,  Maharashtra 400601. Tel no. +91-9867140072,<br> Email - salesomcourier@gmail.com,&nbsp;&nbsp;&nbsp; Website - <span>www.omcourier.net</span>
                        <br>GST NO. : 27ADAPN6620J1ZJ, &nbsp;&nbsp;PAN : ADAPN6620J   
                      </small>
                    </th>
                  </tr>
                 </thead>
                 <tbody>
                   <tr><td colspan="2" class="pd"><p >Shippper :  </p></td>
                   <td colspan="1"><?php echo $value['sender_name']; 
							echo $value['sender_address'];
						$resAct = $this->db->query("select * from city where id=".$value['sender_city']);
										$city_sender = $resAct->row()->city;
										$sender_stateid = $resAct->row()->state_id;
					  echo $city_sender;
					 
						$resAct2 = $this->db->query("select * from state where id=".$sender_stateid."");
						echo $sender_state = $resAct2->row()->state; ?></td></tr>
                   <tr>
                    <td colspan="2" class="pd"><p >consignee : </p></td>
					<td> <?php echo $value['reciever_name'];?> <?php echo $value['reciever_address'];?> <?php echo $city_sender;?> <?php
                                        $resAct2 = $this->db->query("select * from state where id=".$sender_stateid."");
                                        echo $sender_state = $resAct2->row()->state;
                                    ?></td>
                  </tr>
                  <tr>
                    <td class="text-center">No. of pieces</td>
                    <td class="text-center">Actual weight (Kg)</td>
                    <td class="text-center">Chargeable weight (Kg)</td>
                  </tr>
                  <tr>
				   <?php
				   $cnt = 1;
                                foreach ($weight as $weight_value) {
                                                                    
                             ?>
							
                                <td class="blank-box"> &nbsp;<?php echo $cnt;?></td>
                                <td class="blank-box"> &nbsp;<?php echo $weight_value['no_of_pack'];?></td>
                                
                                <!--<td><?php echo $weight_value['actual_weight'];?></td> -->
                                <td class="blank-box"> &nbsp;<?php echo $weight_value['valumetric_weight'];?></td>
                               
                          
                            <?php
							$cnt++;
                            }
                            ?>
                   
                    <td class="blank-box"></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-center">Dimensions / Special instructions</td>
					 </tr>
					 <tr>
                    <td colspan="3" class="blank-center"><?php echo $weightt_info->length;?> X <?php echo $weightt_info->breath;?> X <?php echo $weightt_info->height;?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="blank-box"></td>
                  </tr>
                 </tbody>
             </table>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pd0">
            <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td class="black">Origin</td>
                    <td><?php
										$resAct = $this->db->query("select * from city where id=".$value['sender_city']);
										$city_sender = $resAct->row()->city;
										$sender_stateid = $resAct->row()->state_id;
										echo $city_sender;
									?>	</td>
                    <td class="text-center">Docket no.</td>
                  </tr>
                  <tr>
                    <td class="black">Destination</td>
                    <td><?php
										$resAct1 = $this->db->query("select * from zone_master where z_id=".$value['reciever_country_id']);
										$country_name= $resAct1->row()->country_name;										
										echo $country_name;
									?></td>
                    <td rowspan="2"><h3 class="num"><?php echo $value['pod_no'];?></h3></td>
                  </tr>
                  <tr>
                    <td class="black">Date</td>
                    <td><?php echo date('d-m-Y', strtotime($value['booking_date']));?></td>
                  </tr>
                  <tr>
                    <td class="text-center">Mode</td>
                    <td class="text-center">Flight no.</td>
                    <td class="text-center">Payment mode</td>
                  </tr>
                  <tr>
                    <td><?php echo $value['mode_dispatch'];?></td>
                    <td></td>
                    <td><?php echo $value['dispatch_details'];?></td>
                  </tr>
                  <!--<tr>-->
                  <!--  <td class="text-center">Invoice No.</td>-->
                  <!--  <td class="text-center">Declared value (Rs)</td>-->
                  <!--  <td class="text-center">Eway bill no.</td>-->
                  <!--</tr>-->
                  <!--<tr>-->
                  <!--  <td class="blank-box"><?php echo $value['invoice_no'];?></td>-->
                  <!--  <td class="blank-box"><?php echo $value['invoice_value'];?></td>-->
                  <!--  <td class="blank-box"></td>-->
                  <!--</tr>-->
                  <tr>
                    <td colspan="3" class="text-center">Description</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="blank-box"> <?php echo $value['special_instruction'];?></td>
                  </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead>
                  <tr>
                    <td class="text-center">Charges</td>
                    <td class="text-center">Amount (rs)</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Weight charges @</td>
                    <td><?php echo $value['frieht'];?></td>
                  </tr>
                  <tr>
                     <td>Transportation Charges</td>
                    <td><?php echo $value['transportation_charges'];?></td>
                  </tr>
                 <tr>
                    <td>Destination Charges</td>
                    <td><?php echo $value['destination_charges'];?></td>
                  </tr>
                   <tr>
                    <td>Clearance Charges</td>
                    <td><?php echo $value['clearance_charges'];?></td>
                  </tr>
                   <tr>
                    <td>ESS</td>
                    <td><?php echo $value['ecs'];?></td>
                  </tr>
                  <tr>
                    <td>Other charges</td>
                    <td><?php echo $value['other_charges'];?></td>
                  </tr>
                  <tr>
                    <td>Total charges</td>
                    <td><?php echo $value['total_amount'];?></td>
                  </tr>
                  <tr>
                    <td>Fuel Surcharge</td>
                    <td><?php echo $value['fuel_subcharges'];?></td>
                  </tr>
                  <tr>
                    <td>Sub Total</td>
                    <td><?php echo $value['sub_total'];?></td>
                  </tr>
                  <tr>
                    <td>IGST Tax</td>
                    <td><?php echo $value['igst'];?></td>
                  </tr>
                  <tr>
                    <td>Grand Total</td>
                    <td><?php echo $value['grand_total']; ?></td>
                  </tr>
                </tbody>
            </table>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pd0">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <td class="text-center">Terms & conditions</td>
                    <td class="text-center">Shipper's signature</td>
                    <td class="text-center">Received in good condition</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td rowspan="3" style="width: 45%;">
                      <small>1) <strong>Om Courier Services</strong> shall not be responsible for any claim / inquiry regarding this shipment after 30 days form the date ogf booking.</small>
                      <small>2) Maximum sum of rs. 1000/- may be paid to the shipper for any claim if the shipments is lost or damaged during the transit.</small>
                      <small>3) We do not accept any item Expressly prohibited by government or any other competent authorities.</small>
                      <small>4) <strong>Shipment accepted on owner's rist.</strong></small>
                      <small>5) We are not responsible for delayed due to fire, accidents, riots, strike, fight delay etc.</small>
                      <small>6) Shipments accepted on said to contain basis. shipper will be solely responsible for any false declaration.</small>
                      <small>7) In case of anny discrepancy subject to mumbai jurisdiction.</small>
                    </td>
                    <td style="padding: 0 !important;">
                      <p class="vc text-center">For Om Courier Services</p>
                      <p>&nbsp;&nbsp; Sign</p>
                      <p>&nbsp;&nbsp; Name</p>
                    </td>
                    <td style="padding: 0 !important;">
                      <p style="margin-top: 10px;">&nbsp;&nbsp; Sign</p>
                      <p>&nbsp;&nbsp; Name</p>
                      <p>&nbsp;&nbsp; Date / Time</p>
                      <p class="text-center" style="border-bottom:1px solid #dee2e6;">Receiver's Signature with stamp</p>
                      <h4 style="text-align: center; color: #b6b6b6;font-size: 20px;">Shipper</h4>
                    </td>
                  </tr>
                </tbody>
            </table>
          </div>
			<?php } ?>
        </div>
      </div>
    </section>

    <!-- TODO Let's include scripts files -->
    <script src="assets/pod_assets/js/jquery-3.4.0.min.js"></script>
    <script src="assets/pod_assets/js/popper.min.js"></script>
    <script src="assets/pod_assets/js/bootstrap.min.js"></script>
    <script src="assets/pod_assets/js/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/parallax.js/1.4.2/parallax.min.js"></script>
    <script src="assets/pod_assets/js/scripts.js"></script>
  </body>
</html>
