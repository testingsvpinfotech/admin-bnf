<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url(); ?>">
    <title>Om Courier Services - Courier & Cargo Services</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <!-- TODO Let's include stylesheet files -->
    <link rel="shortcut icon" 	href="assets/pod_assets/media/logo/favicon.png" type="image/x-icon" />
    <link rel="stylesheet"		href="assets/pod_assets/scss/bootstrap.min.css" />
    <link rel="stylesheet"		href="assets/pod_assets/scss/owl.carousel.min.css" />
    <link rel="stylesheet"		href="assets/pod_assets/scss/main.css" />
  </head>
  <body>
   
    <section class="table-list">
      <div class="container">
        <div class="row">
		<?php
			foreach ($booking as $value) 
			{
			    echo '<per>';
			    print_R( $value);exit;
				
				$chatge_info 		= 		$this->db->query("select * from tbl_charges where booking_id=".$value['booking_id']);
				$charges_info 		= $chatge_info->row();

				$weight_info 		= $this->db->query("select * from tbl_weight_details where booking_id=".$value['booking_id']);
				$weightt_info 		= $weight_info->row();
				
										
			?>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pd0">
             <table class="table table-bordered table-one">
                 <thead>
                  <tr>
                    <th scope="col" colspan="3">
                      <img src="assets/images/OCSLOGO (3).jpg" alt="" class="logo">
                      <h4>Om Courier Services - Courier & Cargo Services</h4>
                      <small>
                        Address : Shop NO.01,Om Deep Sai Pooja CHS,<br>Near almeida Signal,Charai Naka,<br>THANE (W).
                        Tel no. +91-9867140072, Email - <span>salesomcourier@gmail.com, Website - <span>www.omcourier.net</span>
                        Gstin : 35aabce7441f1zv, CIN No. : U64120mh2007ptc169691
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
										$resAct1 = $this->db->query("select * from city where id=".$value['reciever_city']);
										$city_reciever= $resAct1->row()->city;
										$reciever_stateid = $resAct1->row()->state_id;
										echo $city_reciever;
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
                    <td class="blank-box"><?php echo $value['mode_dispatch'];?></td>
                    <td class="blank-box"></td>
                    <td class="blank-box"><?php echo $value['dispatch_details'];?></td>
                  </tr>
                  <tr>
                    <td class="text-center">Invoice No.</td>
                    <td class="text-center">Declared value (Rs)</td>
                    <td class="text-center">Eway bill no.</td>
                  </tr>
                  <tr>
                    <td class="blank-box"><?php echo $value['invoice_no'];?></td>
                    <td class="blank-box"><?php echo $value['insurance_value'];?></td>
                    <td class="blank-box"></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-center">Description</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="blank-box"></td>
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
                    <td><?php echo $charges_info->frieht;?></td>
                  </tr>
                  <tr>
                    <td>Awb fees</td>
                    <td><?php echo $charges_info->dod_daoc;?></td>
                  </tr>
                 
                  <tr>
                    <td>Delivery charges</td>
                    <td><?php echo $charges_info->to_pay;?></td>
                  </tr>
                  <tr>
                    <td>Others charges</td>
                    <td><?php echo (int)$charges_info->other_charges + (int)$charges_info->apmt + (int)$charges_info->fov  + (int)$charges_info->fuel_subcharges  + (int)$charges_info->oda;?></td>
                  </tr>
                  <tr>
                    <td>Goods & services tax</td>
                    <td><?php echo ($charges_info->CGST > 0)?$charges_info->SGST + $charges_info->CGST:$charges_info->IGST;?></td>
                  </tr>
                  <tr>
                    <td>Total freight charges</td>
                    <td><?php echo $charges_info->total_amount;?></td>
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
                      <small>1) <strong>Express freight system (i) pvt. ltd.</strong> shall not be responsible for any claim / inquiry regarding this shipment after 30 days form the date ogf booking.</small>
                      <small>2) Maximum sum of rs. 1000/- may be paid to the shipper for any claim if the shipments is lost or damaged during the transit.</small>
                      <small>3) We do not accept any item Expressly prohibited by government or any other competent authorities.</small>
                      <small>4) <strong>Shipment accepted on owner's rist.</strong></small>
                      <small>5) We are not responsible for delayed due to fire, accidents, riots, strike, fight delay etc.</small>
                      <small>6) Shipments accepted on said to contain basis. shipper will be solely responsible for any false declaration.</small>
                      <small>7) In case of anny discrepancy subject to mumbai jurisdiction.</small>
                    </td>
                    <td style="padding: 0 !important;">
                      <p class="vc text-center">For Express freight system (i) pvt. ltd.</p>
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
