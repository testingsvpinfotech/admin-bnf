<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->
<style>
	.form-control {
		color: black !important;
		border: 1px solid var(--sidebarcolor) !important;
		height: 27px;
		font-size: 10px;
	}

	.select2-container--default .select2-selection--single {
		background: lavender !important;
	}

	/*.frmSearch {border: 1px solid #A8D4B1;background-color: #C6F7D0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
	/*#city-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 7;}*/
	/*#city-list li{padding: 10px; background: #F0F0F0; border-bottom: #BBB9B9 1px solid;}*/
	/*#city-list li:hover{background:#ece3d2;cursor: pointer;}*/
	/*#reciever_city{padding: 10px;border: #A8D4B1 1px solid;border-radius:4px;}*/
	form .error {
		color: #ff0000;
	}

	.compulsory_fields {
		color: #ff0000;
		font-weight: bolder;
	}

	.select2-container *:focus {
		border: 1px solid #3c8dbc !important;
		border-radius: 8px 8px !important;
		background: #ffff8f !important;
	}

	input:focus {
		background-color: #ffff8f !important;
	}

	select:focus {
		background-color: #ffff8f !important;
	}

	textarea:focus {
		background-color: #ffff8f !important;
	}

	.btn:focus {
		color: red;
		background-color: #ffff8f !important;
	}


	input,
	textarea {
		text-transform: uppercase;
	}

	::-webkit-input-placeholder {
		/* WebKit browsers */
		text-transform: none;
	}

	:-moz-placeholder {
		/* Mozilla Firefox 4 to 18 */
		text-transform: none;
	}

	::-moz-placeholder {
		/* Mozilla Firefox 19+ */
		text-transform: none;
	}

	:-ms-input-placeholder {
		/* Internet Explorer 10+ */
		text-transform: none;
	}

	::placeholder {
		/* Recent browsers */
		text-transform: none;
	}
</style>
<!-- START: Body-->

<body id="main-container" class="default">

	<!-- END: Main Menu-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
	<!-- END: Main Menu-->

	<!-- START: Main Content-->
	<main>
		<div class="container-fluid site-width">
          <h4> Admin Edit Shipment </h4>
		  <!-- action="admin/edit-domestic-shipment/<?php echo $booking_id; ?>" -->
			<!-- START: Card Data-->
			<form role="form" name="generatePOD" action="admin/admin-update-domestic-shipment/<?php echo $booking_id; ?>" id="generatePOD"  method="post">
				<div class="row" id="pritesh">
					<div class="col-md-4 col-sm-12 mt-3">
						<!-- Shipment Info -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Shipment Info</h4>
								<!-- <span style="float: right;"><a href="admin/view-domestic-shipment" class="btn btn-primary">View Domestic Shipment</a></span> -->
							</div>
							<div class="card-content">
								<div class="card-body">
									<?php if ($this->session->flashdata('notify') != '') { ?>
										<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
									<?php unset($_SESSION['class']);
										unset($_SESSION['notify']);
									} ?>
									<div class="form-group row">
										<?php $datec = date('Y-m-d H:i');
										$datec  = str_replace(" ", "T", $datec);
										$username = $this->session->userdata("userName");
										$whr = array('username' => $username);
										$res = $this->basic_operation_m->getAll('tbl_users', $whr);
										$branch_id = $res->row()->branch_id;
										$whr = array('branch_id' => $branch_id);
										$res = $this->basic_operation_m->getAll('tbl_branch', $whr);
										$branch_name = $res->row()->branch_name;
										?>
										<label class="col-sm-4 col-form-label">Date<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="hidden" name="edited_date" value="<?php echo $datec; ?>" id="booking_date" class="form-control">
											<input type="hidden" name="edited_by" value="<?php echo $this->session->userdata("userName"); ?>" id="booking_date" class="form-control">
											<input type="hidden" name="edited_branch" value="<?php echo $branch_name; ?>" id="booking_date" class="form-control">
											<input type="datetime-local" name="booking_date" value="<?php echo date('Y-m-d\TH:i:s', strtotime($booking->booking_date . ' ' . $booking->booking_time)); ?>" id="booking_date" class="form-control">
										</div>
									</div>
									 <!-- <div class="form-group row">
										<label class="col-sm-4 col-form-label">Courier<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" required name="courier_company" id="courier_company" readonly disabled >
												<option value="">-Select Courier Company-</option>
												<option value="0" data-id="<?php echo "All" ?>">All</option>
												<?php
												if (!empty($courier_company)) {
													foreach ($courier_company as $cc) {
												?>
														<option value='<?php echo $cc['c_id']; ?>' data-id="<?php echo $cc['c_company_name']; ?>" <?php if ($booking->courier_company_id == $cc['c_id']) {
																																						echo "selected";
																																					} ?>><?php echo $cc['c_company_name']; ?></option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>  -->
									<input type="hidden" name="courier_company" id="courier_company" class="form-control" value="<?php echo $booking->courier_company_id; ?>">
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Airway No<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="awn" class="form-control" value="<?php echo $booking->pod_no; ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Mode<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control mode_dispatch" name="mode_dispatch" id="mode_dispatch" required >
												<option value="">-Select Mode-</option>
												<?php
												if (!empty($transfer_mode)) {
													foreach ($transfer_mode as $row) {
												?>
														<option value='<?php echo $row->transfer_mode_id; ?>' <?php if ($booking->mode_dispatch == $row->transfer_mode_id) {
																													echo "selected";
																												} ?>><?php echo $row->mode_name; ?></option>
												<?php
													}
												}
												?>

											</select>
										</div>
									</div>
									<div class="form-group row">
										<!--<label class="col-sm-4 col-form-label">ForwordNo</label>
										<div class="col-sm-8">
											<input type="text" name="forwording_no" id="forwording_no" value="<?php echo $booking->forwording_no; ?>" class="form-control">
										</div> -->
										<label class="col-sm-4 col-form-label">EDD</label>
										<div class="col-sm-8">
											<input type="date" id="delivery_date" name="delivery_date" value="<?php echo $booking->delivery_date; ?>" id="eod" class="form-control">
											
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Desc.</label>
										<div class="col-sm-8">
											<textarea name="special_instruction" class="form-control my-colorpicker1"><?php echo $booking->special_instruction; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
									<label class="col-sm-4 col-form-label">Risk Type<span class="risk_type">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="risk_type" id="risk_type" required disabled>
												<option value="Carrier" <?php echo ($booking->risk_type == 'CARRIER' or $booking->risk_type == 'Carrier') ? "selected" : ''; ?>>Carrier</option>
												<option value="Customer" <?php echo ($booking->risk_type == 'CUSTOMER' or $booking->risk_type == 'Customer') ? "selected" : ''; ?>>Customer</option>
											</select>
											<input type="hidden" name="risk_type" value="<?=$booking->risk_type?>">
										</div>
										<label class="col-sm-4 col-form-label">Bill Type<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="dispatch_details" id="dispatch_details">
												<option value="Credit" <?php echo ($booking->dispatch_details == 'CREDIT' || $booking->dispatch_details == 'Credit') ? "selected" : ''; ?>>Credit</option>
												<option value="Cash" <?php echo ($booking->dispatch_details == 'CASH' || $booking->dispatch_details == 'Cash') ? "selected" : ''; ?>>Cash</option>
												<option value="COD" <?php echo ($booking->dispatch_details == 'COD' || $booking->dispatch_details == 'COD') ? "selected" : ''; ?>>COD</option>
												<option value="ToPay" <?php echo ($booking->dispatch_details == 'TOPAY' || $booking->dispatch_details == 'ToPay') ? "selected" : ''; ?>>ToPay</option>
												<option value="FOC" <?php echo ($booking->dispatch_details == 'FOC' || $booking->dispatch_details == 'FOC') ? "selected" : ''; ?>>FOC</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Product<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="doc_type" id="doc_typee">
												<option value="1" <?php if ($booking->doc_type == 1) {
																		echo "selected";
																	} ?>>Non-Doc</option>
												<option value="0" <?php if ($booking->doc_type == 0) {
																		echo "selected";
																	} ?>>Doc</option>
											</select>
										</div>
									</div>
									
										
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">E Invoice<span class="compulsory_fields"></span></label>
										<div class="col-sm-8">
											<input type="text" name="e_invoice" id="awn" class="form-control" value="<?php echo $booking->e_invoice; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Type Of Parcel<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="type_shipment">
												<option value="">-Select-</option>
												<option value="Wooden Box" <?php if ($booking->type_shipment == 'Wooden Box') {echo "selected";} ?>>Wooden Box</option>
												<option value="Carton" <?php if ($booking->type_shipment == 'Carton') {
																			echo "selected";
																		} ?>>Carton</option>
												<option value="Drum" <?php if ($booking->type_shipment == 'Drum') {
																			echo "selected";
																		} ?>>Drum</option>
												<option value="Plastic Wrap" <?php if ($booking->type_shipment == 'Plastic Wrap') {
																					echo "selected";
																				} ?>>Plastic Wrap</option>
												<option value="Gunny Bag" <?php if ($booking->type_shipment == 'Gunny Bag') {
																				echo "selected";
																			} ?>>Gunny Bag</option>
											</select>
										</div>
									</div>
									<!-- <div class="form-group row">
											
												<label class="col-sm-2 col-form-label">Bill Type<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<select class="form-control" name="dispatch_details" id="dispatch_details">
															<option value="">-Select-</option>
															<option value="Credit">Credit</option>
															<option value="Cash">Cash</option>
													</select>											
												</div>													
											</div> -->
								</div>
							</div>
						</div>
						<!-- Shipment Info -->
					</div>
					<div class="col-md-4 col-sm-12 mt-3">
						<!-- Consigner Detail -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Consigner Detail</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Customer</label>
										<div class="col-sm-8" id="credit_div">
											<select class="form-control" name="customer_account_id" id="customer_account_id" readonly disabled  >
												<option value="">Select Customer</option>
												<?php
												if (count($customers)) {
													foreach ($customers as $rows) {
												?>
														<option value="<?php echo $rows['customer_id']; ?>" <?php if ($booking->customer_id == $rows['customer_id']) {
																												echo "selected";
																											} ?>>
															<?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?>
														</option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" id="credit_div_label">Name<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="sender_name" id="sender_name" value="<?php echo $booking->sender_name; ?>" class="form-control my-colorpicker1">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Address</label>
										<div class="col-sm-8">
											<textarea name="sender_address" id="sender_address" class="form-control"><?php echo $booking->sender_address; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="sender_pincode" maxlength="6" minlength="6" id="sender_pincode" value="<?php echo $booking->sender_pincode; ?>" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">State<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="sender_state" name="sender_state">
												<option value="">Select State</option>
												<?php
												if (count($states)) {
													foreach ($states as $st) {
												?>
														<option value="<?php echo $st['id']; ?>" <?php if ($booking->sender_state == $st['id']) {
																										echo "selected";
																									} ?>><?php echo $st['state']; ?>
														</option>
												<?php }
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">City<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="sender_city" name="sender_city">
												<option value="">Select City</option>
												<?php
												if (count($cities)) {
													foreach ($cities as $rows) {
												?>
														<option value="<?php echo $rows['id']; ?>" <?php if ($booking->sender_city == $rows['id']) {
																										echo "selected";
																									} ?>>
															<?php echo $rows['city']; ?>
														</option>
												<?php }
												}
												?>
											</select>
										</div>
									</div>


									<div class="form-group row">
										<label class="col-sm-4 col-form-label">ContactNo.</label>
										<div class="col-sm-8">
											<input type="text" name="sender_contactno" maxlength="10" minlength="10" id="sender_contactno" value="<?php echo $booking->sender_contactno; ?>" class="form-control my-colorpicker1">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">TypeOfDoc<span class="compulsory_fields">*</span></label>
										<div class="col-sm-4">
											<select name="type_of_doc" class="form-control">
												<option value="GSTIN" <?php if ($booking->type_of_doc == "GSTIN") {
																			echo "selected";
																		} ?>>GSTIN</option>
												<option value="GSTIN(Govt.)" <?php if ($booking->type_of_doc == "GSTIN(Govt.)") {
																					echo "selected";
																				} ?>>GSTIN(Govt.)</option>
												<option value="GSTIN(Diplomats)" <?php if ($booking->type_of_doc == "GSTIN(Diplomats)") {
																						echo "selected";
																					} ?>>GSTIN(Diplomats)</option>
												<option value="PAN" <?php if ($booking->type_of_doc == "PAN") {
																		echo "selected";
																	} ?>>PAN</option>
												<option value="TAN" <?php if ($booking->type_of_doc == "TAN") {
																		echo "selected";
																	} ?>>TAN</option>
												<option value="Passport" <?php if ($booking->type_of_doc == "Passport") {
																				echo "selected";
																			} ?>>Passport</option>
												<option value="Aadhaar" <?php if ($booking->type_of_doc == "Aadhaar") {
																			echo "selected";
																		} ?>>Aadhaar</option>
												<option value="Voter Id" <?php if ($booking->type_of_doc == "Voter Id") {
																				echo "selected";
																			} ?>>Voter Id</option>
												<option value="IEC" <?php if ($booking->type_of_doc == "IEC") {
																		echo "selected";
																	} ?>>IEC</option>
											</select>
										</div>
										<div class="col-sm-4">
											<input type="text" name="sender_gstno"  id="sender_gstno" class="form-control my-colorpicker1" value="<?php echo $booking->sender_gstno; ?>">
										</div>
									</div>
									<div id="div_inv_row1" style="display: none;">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">INV No.</label>
											<div class="col-sm-8">
												<input type="text" name="invoice_no" id="invoice_no" value="<?php echo $booking->invoice_no; ?>" class="form-control my-colorpicker1">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Inv. Value<span class="compulsory_fields">*</span></label>
											<div class="col-sm-8">
												<input type="number" step="any" required min = "0" name="invoice_value" id="invoice_value" value="<?php echo $booking->invoice_value; ?>" class="form-control my-colorpicker1">
											</div>
										</div>
									</div>
									<div id="div_inv_row" style="display: none;">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Eway No</label>
											<div class="col-sm-8">
												<input type="text" name="eway_no" minlength="12" maxlength="12" value="<?php echo $booking->eway_no; ?>" size="12" id="eway_no" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Eway Expiry date</label>
											<div class="col-sm-8">
												<input type="datetime-local" name="eway_expiry_date" value="<?php echo date('Y-m-d\TH:i:s', strtotime($booking->eway_expiry_date)); ?>" id="eway_no" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Consigner Detail -->
					</div>
					<div class="col-md-4 col-sm-12 mt-3">
						<!-- Consignee Detail -->
						<div class="card">
							<div class="card-header">
								<h6 class="card-title">Consignee Detail</h6>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Name<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="reciever_name" id="reciever" class="form-control" required value="<?php echo $booking->reciever_name; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Company<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="contactperson_name" value="<?php echo $booking->contactperson_name; ?>" id="contactperson_name" required />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Address</label>
										<div class="col-sm-8">
											<textarea name="reciever_address" id="reciever_address" class="form-control" autocomplete="off"><?php echo $booking->reciever_address; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" minlength="6" maxlength="6" name="reciever_pincode" id="reciever_pincode" value="<?php echo $booking->reciever_pincode; ?>"  autocomplete="off">
										</div>
									</div>
									<?php $pin = $booking->reciever_pincode; $dd = $this->db->query("select isODA from pincode where pin_code ='$pin'")->row_array();?>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">state</span>&nbsp;&nbsp;&nbsp;<span class="compulsory_fields"></span><span class="compulsory_fields"></span></label>
										<div class="col-sm-8">
											<select class="form-control" id="reciever_state" required name="reciever_state">
												<option value="">Select State</option>
												<?php
												if (count($states)) {
													foreach ($states as $s) { ?>
														<option value="<?php echo $s['id']; ?>" <?php if ($booking->reciever_state == $s['id']) {
																									echo "selected";
																								} ?>>
															<?php echo $s['state']; ?>
														</option>
												<?php 		}
												} ?>
											</select>
											<span class="compulsory_fields" id="isoda" style="color:red">Service Type : <?php if(!empty($dd['isODA'])){ echo service_type[$dd['isODA']];}?></span><span class="compulsory_fields" id="noservice"></span>
										</div>
									</div>
								
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">City<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="reciever_city" required name="reciever_city">
												<option value="">Select City</option>
												<?php
												if (count($cities)) {
													foreach ($cities as $c) { ?>
														<option value="<?php echo $c['id']; ?>" <?php if ($booking->reciever_city == $c['id']) {
																									echo "selected";
																								} ?>>
															<?php echo $c['city']; ?>
														</option>
												<?php 		}
												} ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Zone</label>
										<div class="col-sm-8">
											<input type="text"  name="receiver_zone" value="<?php echo $booking->receiver_zone; ?>" required  id="receiver_zone" class="form-control" >
											<input type="hidden" name="receiver_zone_id" value="<?php echo $booking->receiver_zone_id; ?>" id="receiver_zone_id" required class="form-control">
											<input type="hidden" id="gst_charges" class="form-control">
											<input type="hidden" id="cft" class="form-control" value="">
											<input type="hidden" id="air_cft" class="form-control">
										</div>
									</div>

									<div class="form-group row" style="display:none;">
										<label class="col-sm-4 col-form-label">Forworder<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" required name="forworder_name" >
											<!-- id="forworder_name" -->
												<!-- <option value="">-Select Courier Company-</option> -->
												<option value="SELF">SELF</option>

												<?php
												if (!empty($courier_company)) {
													foreach ($courier_company as $cc) {
												?>
														<option value='<?php echo $cc['c_company_name']; ?>' data-id="<?php echo $cc['c_company_name']; ?>" 
														<?php if ($booking->forworder_name == $cc['c_company_name']) { echo "selected"; } ?>><?php echo $cc['c_company_name']; ?></option>
												<?php
													}
												}
												?>
											</select>
											<!-- <input type="text" name="forworder_name" class="form-control" value="<?php //echo $booking->forworder_name;
																														?>" id="forworder_name" readonly>-->
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">ContactNo.</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" maxlength="10" minlength="10" value="<?php echo $booking->reciever_contact; ?>" id="reciever_contact" name="reciever_contact" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">GST NO.</label>
										<div class="col-sm-8">
											<input type="text" name="receiver_gstno" value="<?php echo $booking->receiver_gstno; ?>" id="receiver_gstno" class="form-control">
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Consignee Detail -->
					</div>
				</div>
				<div class="row">




					<div class="col-md-6 col-sm-12 mt-3">
						<!-- Measurement Units -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Measurement Units</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">PKT</label>
												<div class="col-sm-4">
													<input type="text" name="no_of_pack" class="form-control my-colorpicker1 no_of_pack" value="<?php echo $weight->no_of_pack; ?>" data-attr="1" id="no_of_pack1" required="required">
												</div>
												<label class="col-sm-2 col-form-label">Actual Weight</label>
												<div class="col-sm-4">
													<input type="text" step="any" min = "0" name="actual_weight" class="form-control my-colorpicker1 actual_weight" value="<?php echo $weight->actual_weight; ?>" data-attr="1" id="actual_weight" required="required">
												</div>
												<label class="col-sm-2 col-form-label">Chargeable Weight</label>
												<div class="col-sm-4">
													<input type="text" step="any" min = "0" name="chargable_weight" readonly value="<?php echo $weight->chargable_weight; ?>" class="form-control my-colorpicker1 chargable_weight" data-attr="1" id="chargable_weight" required="required">
													<!-- <input type="text" step="any" min = "0" name="chargable_weight" readonly value="<?php echo $weight->chargable_weight; ?>" class="form-control my-colorpicker1 chargable_weight" data-attr="1" id="chargable_weight" required="required"> -->
													<input type="hidden" step="any" min = "0" class="form-control my-colorpicker1 chargable_weight"  id="min_weight" value="0" required="required">
												</div>
												<label class="col-sm-2 col-form-label"><small><b>Is Appointment</b></small></label>
													<div class="col-sm-1">
														<br>
														<input type="checkbox" id="is_appointment" name="is_appointment" value="1" <?php echo ($booking->is_appointment == 1|| $booking->is_appointment =='') ? 'checked' : ''; ?>>
													</div>
													<input type="hidden"  id="branch_gst" value="0">
													<input type="hidden"  id="sender_gst" value="0">
													<input type="hidden"  id="per_cgst" value="0">
													<input type="hidden"  id="per_sgst" value="0">
													<input type="hidden"  id="per_igst" value="0">
													<!-- customer acces sgst,cgst or igst and fule price   -->
													<input type="hidden"  id="igst_or_other" value="0">
													<input type="hidden"  id="fuel_charge" value="0">
													<input type="hidden"  id="fuelprice" value="0">
											</div>
											<div id="volumetric_table">
												<table class="weight-table">
													<thead>
														<tr><input type="hidden" class="form-control" name="length_unit" id="length_unit" class="custom-control-input" value="cm">
															<th>Per Box Pack</th>
															<th class="length_th">L</th>
															<th class="breath_th">B</th>
															<th class="height_th">H</th>
															<th class="volumetric_weight_th">Valumetric Weight</th>
															<th class="volumetric_weight_th">Total AW</th>
															<th class="volumetric_weight_th">Chargeable Weight</th>

														</tr>
														<thead>
														<tbody id="volumetric_table_row">
															<?php

															$length_detail =  json_decode($weight->length_detail);
															$breath_detail =  json_decode($weight->breath_detail);
															$height_detail =  json_decode($weight->height_detail);
															$valumetric_weight_detail =  json_decode($weight->valumetric_weight_detail);
															$per_box_weight_detail =  json_decode($weight->per_box_weight_detail);
															$weight_details =  json_decode($weight->weight_details, true);

															// echo "<pre>";
															// print_r($weight_details);exit();

															for ($jd = 0; $jd < count($valumetric_weight_detail); $jd++) {
															?>
																<tr>
																	<td><input type="number" name="per_box_weight_detail[]" class="form-control per_box_weight valid" data-attr="<?php echo ($jd + 1); ?>" id="per_box_weight<?php echo ($jd + 1); ?>" aria-invalid="false" value="<?php echo $per_box_weight_detail[$jd]; ?>"></td>
																	<td class="length_td"><input type="number" step="any" min = "0" name="length_detail[]" class="form-control length" data-attr="<?php echo ($jd + 1); ?>" id="length<?php echo ($jd + 1); ?>" value="<?php echo $length_detail[$jd]; ?>"></td>
																	<td class="breath_td"><input step="any" type="number" name="breath_detail[]" class="form-control breath" data-attr="<?php echo ($jd + 1); ?>" id="breath<?php echo ($jd + 1); ?>" value="<?php echo $breath_detail[$jd]; ?>"></td>
																	<td class="height_td"><input step="any" type="number" name="height_detail[]" class="form-control height" data-attr="<?php echo ($jd + 1); ?>" id="height<?php echo ($jd + 1); ?>" value="<?php echo $height_detail[$jd]; ?>"></td>

																	<td class="volumetic_weight_td"><input type="number" step="any" name="valumetric_weight_detail[]" readonly class="form-control valumetric_weight" data-attr="<?php echo ($jd + 1); ?>" id="valumetric_weight<?php echo ($jd + 1); ?>" value="<?php echo $valumetric_weight_detail[$jd]; ?>"></td>

																	<td class="volumetic_weight_td"><input step="any" type="number" name="valumetric_actual_detail[]" class="form-control valumetric_actual" data-attr="<?php echo ($jd + 1); ?>" id="valumetric_actual<?php echo ($jd + 1); ?>" value="<?php echo $weight_details['valumetric_actual_detail'][$jd]; ?>"></td>

																	<td class="volumetic_weight_td"><input type="number" step="any" name="valumetric_chageable_detail[]" readonly class="form-control valumetric_chageable" data-attr="<?php echo ($jd + 1); ?>" id="valumetric_chageable<?php echo ($jd + 1); ?>" value="<?php echo $weight_details['valumetric_chageable_detail'][$jd]; ?>"></td>

																</tr>
															<?php } ?>
														</tbody>
													<tfoot>

													</tfoot>
												</table>
												<table>
													<tr>
														<th><input type="text" name="per_box_weight" readonly="readonly" class="form-control  per_box_weight" id="per_box_weight" required="required" value="<?php echo $weight->per_box_weight; ?>"></th>
														<th class="length_td"><input type="text" name="length" readonly="readonly" step="any" class="form-control length" id="length" value="<?php echo $weight->length; ?>"></th>
														<th class="breath_td"><input type="text" name="breath" readonly="readonly" step="any" class="form-control breath" id="breath" value="<?php echo $weight->breath; ?>"></th>
														<th class="height_td"><input type="text" name="height" readonly="readonly" step="any" class="form-control height" id="height" value="<?php echo $weight->height; ?>"></th>
														<th class="volumetic_weight_td"><input type="text" name="valumetric_weight" step="any" readonly="readonly" class="form-control valumetric_weight" id="valumetric_weight" value="<?php echo $weight->valumetric_weight; ?>"></th>

														<th class="volumetic_weight_td"><input type="text" name="valumetric_actual" step="any" readonly="readonly" class="form-control my-colorpicker1 valumetric_weight" id="valumetric_actual" value="<?php echo $weight_details['valumetric_actual']; ?>"></th>

														<th class="volumetic_weight_td"><input type="text" name="valumetric_chageable" step="any" readonly="readonly" class="form-control my-colorpicker1 valumetric_weight" id="valumetric_chageable" value="<?php echo $weight_details['valumetric_chageable']; ?>"></th>

													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Measurement Units -->
					</div>








					<div class="col-md-6 col-sm-12 mt-3">
						<!-- Charges -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Charges &nbsp;&nbsp;&nbsp;<input type="checkbox" id="is_rate" checked value="1"> Apply Rate</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Freight</label>
												<div class="col-sm-3">
													<input type="number" name="frieht" step="any" class="form-control" value="<?php echo $booking->frieht; ?>" readonly required id="frieht" />
												</div>
												<label class="col-sm-3 col-form-label">Handling Charge</label>
												<div class="col-sm-3">
													<input type="number" name="transportation_charges" class="form-control" step="any" value="<?php echo $booking->transportation_charges; ?>" id="transportation_charges">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Pickup</label>
												<div class="col-sm-3">
													<input type="number" name="pickup_charges" step="any" value="<?php echo $booking->pickup_charges; ?>" class="form-control" id="pickup_charges">
												</div>
												<label class="col-sm-3 col-form-label">ODA Charge</label>
												<div class="col-sm-3">
													<input type="number" name="delivery_charges" step="any" value="<?php echo $booking->delivery_charges; ?>" class="form-control" value="0" id="delivery_charges">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Insurance</label>
												<div class="col-sm-3">
													<input type="number" name="insurance_charges" step="any" class="form-control" value="<?php echo $booking->insurance_charges; ?>" id="insurance_charges">
												</div>
												<label class="col-sm-3 col-form-label">COD</label>
												<div class="col-sm-3">
													<input type="number" name="courier_charges" step="any" class="form-control" value="<?php echo $booking->courier_charges; ?>" id="courier_charges">
												</div>

												<!--  <div class="form-group row">
															<label   class="col-sm-3 col-form-label">Destination</label>
															<div class="col-sm-3">
																<input type="number" name="destination_charges" class="form-control" id="destination_charges">
															</div>		
															<label class="col-sm-3 col-form-label">Clearance</label>
															<div class="col-sm-3">
																<input type="number" name="clearance_charges" class="form-control" id="clearance_charges">
															</div>
														</div> -->

												<!-- <label class="col-sm-3 col-form-label">ECS</label>
															<div class="col-sm-3">
																<input type="number" name="ecs" class="form-control" id="ecs">
															</div> -->

											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">AWB Ch.</label>
												<div class="col-sm-3">
													<input type="number" name="awb_charges" step="any" class="form-control" value="<?php echo $booking->awb_charges; ?>" id="awb_charges">
												</div>
												<label class="col-sm-3 col-form-label">Other Ch.</label>
												<div class="col-sm-3">
													<input type="number" name="other_charges" step="any" class="form-control" value="<?php echo $booking->other_charges; ?>" id="other_charges">
												</div>
											</div>

											<div class="form-group row">



												<label class="col-sm-3 col-form-label">Topay</label>
												<div class="col-sm-3">
													<input type="number" name="green_tax" class="form-control" step="any" value="<?php echo $booking->green_tax; ?>" id="green_tax">
												</div>
												<label class="col-sm-3 col-form-label">Appt Ch.</label>
												<div class="col-sm-3">
													<input type="number" name="appt_charges" class="form-control" step="any" value="<?php echo $booking->appt_charges; ?>" id="appt_charges">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-3 col-form-label">Fov Charges</label>
												<div class="col-sm-3">
													<input type="number" readonly="readonly" class="form-control" step="any" name="fov_charges" id="fov_charges" value="<?php echo $booking->fov_charges; ?>">
												</div>
												<label class="col-sm-3 col-form-label">Total</label>
												<div class="col-sm-3">
													<input type="number" readonly name="amount" class="form-control" step="any" value="<?php echo $booking->total_amount; ?>" id="amount" />
												</div>

											</div>
											<div class="form-group row">

												<label class="col-sm-3 col-form-label">Fuel Surcharge</label>
												<div class="col-sm-3">
													<input type="number" readonly="readonly" class="form-control" step="any" name="fuel_subcharges" value="<?php echo $booking->fuel_subcharges; ?>" id="fuel_charges">
												</div>
												<label  class="col-sm-3 col-form-label">Address Change</label>
												<div class="col-sm-3">
													<input type="number"  class="form-control" name="address_change" step="any" value="<?php echo $booking->address_change; ?>" id="address_change">
												</div>
											</div>
											<div class="form-group row">
												<label  class="col-sm-3 col-form-label">DPH	</label>
												<div class="col-sm-3">
													<input type="number"  class="form-control" name="dph" step="any" value="<?php echo $booking->dph; ?>" id="dph">
												</div>
												<label  class="col-sm-3 col-form-label">Warehousing Change</label>
												<div class="col-sm-3">
													<input type="number"  class="form-control" name="warehousing" step="any" value="<?php echo $booking->warehousing; ?>" id="warehousing">
												</div>
											</div>
											<div class="form-group row">
												<?php
														$adhoc_lable =  json_decode($booking->adhoc_lable);  
														$adhoc_charges =  json_decode($booking->adhoc_charges);  
												?>
												<label  class="col-sm-3 col-form-label">Lable	</label>
												<div class="col-sm-3">
													<input type="text"  class="form-control txtOnly" name="adhoc_lable[]" value="<?php echo (isset($adhoc_lable[0]))?$adhoc_lable[0]:''; ?>"  id="lable">
												</div>
												<label  class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control" name="adhoc_charges[]" value="<?php echo (isset($adhoc_lable[0]))?$adhoc_lable[0]:''; ?>" id="lcharges1">
												</div>
											</div>
											<div class="form-group row">
												<label  class="col-sm-3 col-form-label">Lable	</label>
												<div class="col-sm-3">
													<input type="text"  class="form-control txtOnly" name="adhoc_lable[]" value="<?php echo (isset($adhoc_lable[1]))?$adhoc_lable[1]:''; ?>"  id="lable">
												</div>
												<label  class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control" name="adhoc_charges[]" value="<?php echo (isset($adhoc_lable[1]))?$adhoc_lable[1]:''; ?>" id="lcharges2">
												</div>
											</div>
											<div class="form-group row">
												<label  class="col-sm-3 col-form-label">Lable	</label>
												<div class="col-sm-3">
													<input type="text"  class="form-control txtOnly" name="adhoc_lable[]" value="<?php echo (isset($adhoc_lable[2]))?$adhoc_lable[2]:''; ?>"  id="lable">
												</div>
												<label  class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control" name="adhoc_charges[]" value="<?php echo (isset($adhoc_lable[2]))?$adhoc_lable[2]:''; ?>" id="lcharges3">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card-header">
								<h4 class="card-title">Final Charge</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-6">
													<div class="form-group row" id="payby" style="display:none;">
														<label class="col-sm-2 col-form-label">Pay By<span class="compulsory_fields">*</span></label>
														<div class="col-sm-4">
															<select class="form-control" name="payment_method" id="payment_method">
																<option>-Select-</option>
																<?php foreach ($payment_method as $pm) { ?>
																	<option value="<?php echo $pm['id']; ?>" <?php if ($booking->payment_method == $pm['id']) {
																													echo "selected";
																												} ?>><?php echo $pm['method']; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row" id="Refno" style="display:none;">
														<label class="col-sm-3 col-form-label">Ref No</label>
														<div class="col-sm-9">
															<input type="text" name="ref_no" value="<?php echo $booking->ref_no; ?>" class="form-control" />
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Sub Total</label>
														<div class="col-sm-9">
															<input type="number" step="any" readonly name="sub_total" class="form-control" value="<?php echo $booking->sub_total; ?>" id="sub_total" />
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">CGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control" type="number"  id="cgst" step="any" name="cgst" value="<?php echo $booking->cgst; ?>" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">SGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control" type="number" id="sgst" step="any" name="sgst" value="<?php echo $booking->sgst; ?>" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">IGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control" type="number" id="igst" step="any" name="igst" value="<?php echo $booking->igst; ?>" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Grand Total</label>
														<div class="col-sm-9">
															<input type="text" readonly class="form-control" name="grand_total" value="<?php echo $booking->grand_total; ?>" id="grand_total" />
														</div>
													</div>
												</div>
											</div>
											<div class="form-group submit_allow row mt-3" >
												<div class="col-sm-12">
													<button type="submit" class="btn btn-primary" style="display:none" id="submit1">Submit</button> &nbsp;
													<button type="button" class="btn btn-primary" id="desabledBTN" onclick="return NotifySubmission();">Submit 
													&nbsp;
														<span class="spinner-border spinner-border-sm" id="spinner" style="display:none" role="status" aria-hidden="true"></span>
												</button> &nbsp;
													<button type="button" onclick="return open_new_page()" class="btn btn-primary">New</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Charges -->


					</div>

				</div>
			</form>
		</div>
		</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="submit_notify" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog " role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Shipment Save Alert!</h5>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button> -->
			</div>
			<div class="modal-body">
				<div  style="line-height:10px;padding-left:0px; margin:25px 0;">
					<h4>Are You Sure, Want to Save?</h4>
				</div>
			
			<div class="modal-footer">
			    <button type="button" onclick="return checkForTheCondition();" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" id="cancel_model" data-dismiss="modal">Cancel</button>
			</div>
			</div>
			</div>
		</div>
		</div>
		<!-- </form> -->
		<input type="hidden" id="usertype" value="<?php echo $this->session->userdata('userType'); ?>">
		<input type="hidden" id="length_detail" value="<?php echo $length_detail[0]; ?>">
		</div>
	</main>
	<!-- END: Content-->
	<!-- START: Footer-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
	<!-- START: Footer-->
</body>
<!-- END: Body--><script>
	$(document).ready(function(){
		
		$( ".txtOnly" ).keypress(function(e) {
                    var key = e.keyCode;
                    if (key >= 48 && key <= 57) {
                        e.preventDefault();
                    }
                });
		$('#doc_typee').change(function(){
        var doc_typee = $(this).val();
		if(doc_typee == '0'){
			$("#is_volumetric").removeAttr("required");
		}else{
			$("#is_volumetric").attr("required", "true");
		}
	});
	});
</script>

<script src="<?php echo base_url();?>assets/js/domestic_shipment_1.js"></script>

</html>