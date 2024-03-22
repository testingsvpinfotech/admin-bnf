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
			<!-- START: Card Data-->
			<form role="form" name="generatePOD" id="generatePOD" action="admin/add-domestic-shipment" method="post">
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
										<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored">
											<?php echo $this->session->flashdata('notify'); ?>
										</div>
										<?php unset($_SESSION['class']);
										unset($_SESSION['notify']);
									} ?>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Date<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">



											<?php
											$datec = date('Y-m-d H:i');

											// $tracking_data[0]['tracking_date'] = date('Y-m-d H:i',strtotime($tracking_data[0]['tracking_date']));
											$datec = str_replace(" ", "T", $datec);
											if ($this->session->userdata('booking_date') != '') { ?>

												<input type="datetime-local" name="booking_date"
													value="<?php echo $this->session->userdata('booking_date'); ?>"
													id="booking_date" class="form-control">
											<?php
											} else { ?>
												<input type="datetime-local" name="booking_date"
													value="<?php echo $datec; ?>" id="booking_date" class="form-control"
													min="<?= date('Y-m-d', strtotime("-1 days")) . 'T' . date('H:i'); ?>"
													max="<?= date('Y-m-d') . 'T' . date('H:i'); ?>">
											<?php } ?>
										</div>
									</div>
									<!-- <div class="form-group row"> 
												<label class="col-sm-4 col-form-label">Courier<span class="compulsory_fields">*</span></label>
												<div class="col-sm-8">
													<select class="form-control" required name="courier_company" id="courier_company" readonly disabled >
														<option value="">-Select Courier Company-</option>
														<option value="0" data-id="<?php echo "All" ?>" >All</option>
														<?php
														if (!empty($courier_company)) {
															foreach ($courier_company as $cc) {
																?>
																<option value='<?php echo $cc['c_id']; ?>' <?php echo ($cc['c_company_name'] == 'SELF') ? 'selected' : ''; ?> data-id="<?php echo $cc['c_company_name']; ?>"><?php echo $cc['c_company_name']; ?></option>
																<?php
															}
														}
														?>
													</select>	

												</div>
												
											</div> -->
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Reason</label>
										<div class="col-sm-8">
											<textarea type="text" name="bkdate_reason" id="bkdate_reason"
												class="form-control" value="<?php //echo $bid; ?>"></textarea>
										</div>
									</div>
									<input type="hidden" name="courier_company" id="courier_company"
										class="form-control" value="35">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Airway No<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="awn" id="awn" maxlength="9" minlength="9"
												class="form-control" value="<?php //echo $bid; ?>">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Mode<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control mode_dispatch" name="mode_dispatch"
												id="mode_dispatch" required>
												<option value="">-Select Mode-</option>
												<?php
												if (!empty($transfer_mode)) {
													foreach ($transfer_mode as $row) {
														?>
														<option value='<?php echo $row->transfer_mode_id; ?>'>
															<?php echo $row->mode_name; ?>
														</option>
													<?php
													}
												}
												?>

											</select>
										</div>
									</div>
									<div class="form-group row">
										<!--<label  class="col-sm-4 col-form-label">ForwordNo</label>
												<div class="col-sm-8">
													<input type="text" name="forwording_no" id="forwording_no" class="form-control">
												</div>	-->
										<label class="col-sm-4 col-form-label">EDD</label>
										<div class="col-sm-8">
											<input type="text" id="delivery_date" name="delivery_date" value="" readonly
												class="form-control">
											<input type="hidden" id="rate_new" name="rate" value=""
												class="form-control">
										</div>
									</div>
									<!-- <div class="form-group row">
												<label  class="col-sm-4 col-form-label">Forworder<span class="compulsory_fields">*</span></label>
												<div class="col-sm-8">
												<input type="text" name="forworder_name" class="form-control" id="forworder_name" readonly>
												</div>
											</div> -->
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Desc.</label>
										<div class="col-sm-8">
											<textarea name="special_instruction"
												class="form-control my-colorpicker1"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Risk Type<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="risk_type" id="risk_type" disabled>
												<option value="Customer">Customer</option>
												<option value="Carrier">Carrier</option>
											</select>
											<input type="hidden" name="risk_type" value="Customer">		
										</div>
										<label class="col-sm-4 col-form-label">Bill Type<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="dispatch_details" id="dispatch_details"
												required>
												<option value="">-Select-</option>
												<option value="Credit">Credit</option>
												<option value="Cash">Cash</option>
												<option value="COD">COD</option>
												<option value="ToPay">ToPay</option>
												<option value="FOC">FOC</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Product<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="doc_type" id="doc_typee" required>
												<option value="">-Select-</option>
												<option value="1">Non-Doc</option>
												<option value="0">Doc</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">E Invoice<span
												class="compulsory_fields"></span></label>
										<div class="col-sm-8">
											<input type="text" name="e_invoice" id="awn" class="form-control"
												value="<?php //echo $bid; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Type Of Parcel<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="type_shipment" id="doc_type">
												<option value="">-Select-</option>
												<option value="Wooden Box">Wooden Box</option>
												<option value="Carton">Carton</option>
												<option value="Drum">Drum</option>
												<option value="Plastic Wrap">Plastic Wrap</option>
												<option value="Gunny Bag">Gunny Bag</option>
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
											<select class="form-control customer_show" name="customer_account_id"
												id="customer_account_id">
												<option value="">Select Customer</option>
												<?php
												if (count($customers)) {
													foreach ($customers as $rows) {
														?>
														<option value="<?php echo $rows['customer_id']; ?>">
															<?php echo $rows['customer_name']; ?>--
															<?php echo $rows['cid']; ?>
														</option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" id="credit_div_label">Name<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="sender_name" id="sender_name"
												class="form-control my-colorpicker1" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Address</label>
										<div class="col-sm-8">
											<textarea name="sender_address" id="sender_address"
												class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Pincode<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="sender_pincode" maxlength="6" minlength="6"
												id="sender_pincode" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">State<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="sender_state" name="sender_state">
												<option value="">Select State</option>
												<?php

												if (count($states)) {
													foreach ($states as $st) {
														?>
														<option value="<?php echo $st['id']; ?>">
															<?php echo $st['state']; ?>
														</option>
													<?php }
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">City<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="sender_city" name="sender_city">
												<option value="">Select City</option>
												<?php
												if (count($cities)) {
													foreach ($cities as $rows) {
														?>
														<option value="<?php echo $rows['id']; ?>">
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
											<input type="text" name="sender_contactno" maxlength="10" minlength="10"
												id="sender_contactno" class="form-control my-colorpicker1">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">TypeOfDoc<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-4">
											<select name="type_of_doc" class="form-control">
												<option value="GSTIN">GSTIN</option>
												<option value="GSTIN(Govt.)">GSTIN(Govt.)</option>
												<option value="GSTIN(Diplomats)">GSTIN(Diplomats)</option>
												<option value="PAN">PAN</option>
												<option value="TAN">TAN</option>
												<option value="Passport">Passport</option>
												<option value="Aadhaar">Aadhaar</option>
												<option value="Voter Id">Voter Id</option>
												<option value="IEC">IEC</option>
											</select>
											</select>
										</div>
										<div class="col-sm-4">
											<input type="text" name="sender_gstno" id="sender_gstno"
												class="form-control my-colorpicker1">

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
										<label class="col-sm-4 col-form-label">Name<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="reciever_name" id="reciever" class="form-control"
												required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Company<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="contactperson_name"
												id="contactperson_name" required />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Address</label>
										<div class="col-sm-8">
											<textarea name="reciever_address" id="reciever_address" class="form-control"
												autocomplete="off"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Pincode<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" maxlength="6" minlength="6" class="form-control"
												name="reciever_pincode" id="reciever_pincode" autocomplete="off">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">state<span
												class="compulsory_fields">*</span>&nbsp;&nbsp;&nbsp;</label>
										<div class="col-sm-8">
											<select class="form-control" id="reciever_state" name="reciever_state">
												<option value="">Select State</option>
												<?php
												if (count($states)) {
													foreach ($states as $s) { ?>
														<option value="<?php echo $s['id']; ?>">
															<?php echo $s['state']; ?>
														</option>
													<?php }
												} ?>
											</select>
											<span class="compulsory_fields" id="isoda"></span><span
												class="compulsory_fields" id="noservice"></span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">City<span
												class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="reciever_city" name="reciever_city">
												<option value="">Select City</option>
												<?php
												if (count($cities)) {
													foreach ($cities as $c) { ?>
														<option value="<?php echo $c['id']; ?>">
															<?php echo $c['city']; ?>
														</option>
													<?php }
												} ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Zone</label>
										<div class="col-sm-8">
											<input type="hidden" name="statecode" id="statecode"
												class="form-control my-colorpicker1">
											<input type="text" name="receiver_zone" id="receiver_zone"
												class="form-control" required>
											<input type="hidden" name="receiver_zone_id" id="receiver_zone_id"
												class="form-control">
											<input type="hidden" id="gst_charges" class="form-control">
											<input type="hidden" id="cft" class="form-control">
											<input type="hidden" id="air_cft" class="form-control">
											<input type="hidden" name="final_branch_id" id="final_branch_id"
												class="form-control" required>
											<input type="hidden" name="branch_name" id="final_branch_name"
												class="form-control" required readonly>
										</div>
									</div>

									<div class="form-group row">
										<!--<label class="col-sm-4 col-form-label">Forwarder<span class="compulsory_fields">*</span></label>  -->
										<div class="col-sm-8">
											<input type="hidden" name="forworder_name" value="SELF">

											<!-- <select class="form-control" id="forworder_name"  name="forworder_name">
														<option value="">Select Forwarder</option>			
														
													</select> -->
										</div>
									</div>



									<div class="form-group row">
										<label class="col-sm-4 col-form-label">ContactNo.</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" maxlength="10" minlength="10"
												required id="reciever_contact" name="reciever_contact" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">GST NO.</label>
										<div class="col-sm-8">
											<input type="text" name="receiver_gstno" id="receiver_gstno"
												class="form-control">
										</div>
									</div>

									<div id="div_inv_row1" style="display: none;">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">INV No.</label>
											<div class="col-sm-8">
												<input type="text" name="invoice_no" id="invoice_no"
													class="form-control my-colorpicker1">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Inv. Value<span
													class="compulsory_fields">*</span></label>
											<div class="col-sm-8">
												<input type="text" step="any"  name="invoice_value"
													id="invoice_value" class="form-control my-colorpicker1"
													placeholder="" required>
											</div>
										</div>
									</div>
									<div id="div_inv_row" style="display: none;">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Eway No</label>
											<div class="col-sm-8">
												<input type="text" name="eway_no" id="eway_no"
													class="form-control eway_no1">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Eway Expiry date</label>
											<div class="col-sm-8">
												<input type="datetime-local" name="eway_expiry_date" id="eway_no"
													class="form-control eway_expiry">
											</div>
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
													<input type="text" name="no_of_pack"
														class="form-control my-colorpicker1 no_of_pack"
														autocomplete="off" readonly data-attr="1" id="no_of_pack1"
														required="required" onchange="check_customers_rate()">
												</div>
												<label class="col-sm-2 col-form-label">Actual Weight</label>
												<div class="col-sm-4">
													<input type="text" step="any" min="0" name="actual_weight"
														autocomplete="off" readonly
														class="form-control my-colorpicker1 actual_weight" data-attr="1"
														id="actual_weight" required="required">
												</div>
												<label class="col-sm-2 col-form-label">Chargeable Weight</label>
												<div class="col-sm-4">
													<input type="text" step="any" min="0" name="chargable_weight"
														autocomplete="off" readonly
														class="form-control my-colorpicker1 chargable_weight"
														data-attr="1" id="chargable_weight" required="required">
													<input type="hidden" step="any" min="0"
														class="form-control my-colorpicker1 chargable_weight"
														id="min_weight" value="0" required="required">
												</div>
												<label class="col-sm-2 col-form-label"><small><b>Is
															Appointment</b></small></label>
												<div class="col-sm-1">
													<br>
													<input type="checkbox" id="is_appointment" name="is_appointment" value="1">

												</div>
												<!-- <label class="col-sm-2 col-form-label">Is Volumetric</label>
														<div class="col-sm-1">
															  <br>
															<input type="checkbox" id="is_volumetric" name="fav_language" required value="">

														</div> -->
												<!-- Local calulation Required details  -->
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
														<tr><input type="hidden" class="form-control" name="length_unit"
																id="length_unit" class="custom-control-input"
																value="cm">
															<th>No.of box</th>
															<th class="length_th">L (cm)</th>
															<th class="breath_th">B (cm)</th>
															<th class="height_th">H (cm)</th>
															<th class="volumetric_weight_th">Valumetric Weight</th>
															<th class="volumetric_weight_th">Total AW</th>
															<th class="volumetric_weight_th">Chargeable Weight</th>

														</tr>
														<thead>
														<tbody id="volumetric_table_row">
															<tr>
																<td><input type="number" name="per_box_weight_detail[]"
																		autocomplete="off"
																		class="form-control per_box_weight valid"
																		data-attr="1" id="per_box_weight1" min="1"
																		aria-invalid="false" required></td>
																<td class="length_td"><input type="number" step="any"
																		autocomplete="off" min="0"
																		name="length_detail[]" step="any"
																		class="form-control length" data-attr="1"
																		id="length1" required></td>
																<td class="breath_td"><input required type="number"
																		autocomplete="off" name="breath_detail[]"
																		step="any" class="form-control breath"
																		data-attr="1" id="breath1"></td>
																<td class="height_td"><input required type="number"
																		autocomplete="off" name="height_detail[]"
																		step="any" class="form-control height"
																		data-attr="1" id="height1"></td>
																<td class="volumetic_weight_td"><input required
																		type="number" autocomplete="off"
																		name="valumetric_weight_detail[]" step="any"
																		readonly class="form-control valumetric_weight"
																		data-attr="1" id="valumetric_weight1"></td>

																<td class="volumetic_weight_td"><input required
																		type="number" autocomplete="off" step="any"
																		name="valumetric_actual_detail[]"
																		class="form-control valumetric_actual"
																		data-attr="1" id="valumetric_actual1"></td>

																<td class="volumetic_weight_td"><input required
																		type="number" autocomplete="off"
																		name="valumetric_chageable_detail[]" step="any"
																		readonly
																		class="form-control valumetric_chageable"
																		data-attr="1" id="valumetric_chageable1"></td>
															</tr>
														</tbody>
													<tfoot>

													</tfoot>
												</table>
												<table>
													<tr>

														<th><input type="text" name="per_box_weight" readonly="readonly"
																class="form-control  per_box_weight" id="per_box_weight"
																required="required"></th>
														<th class="length_td"><input type="text" name="length"
																step="any" readonly="readonly"
																class="form-control length" id="length"></th>
														<th class="breath_td"><input type="text" name="breath"
																readonly="readonly" class="form-control breath"
																step="any" id="breath"></th>
														<th class="height_td"><input type="text" name="height"
																readonly="readonly" class="form-control height"
																id="height" step="any"></th>
														<th class="volumetic_weight_td"><input type="text"
																name="valumetric_weight" step="any" readonly="readonly"
																class="form-control my-colorpicker1 valumetric_weight"
																id="valumetric_weight"></th>

														<th class="volumetic_weight_td"><input type="text"
																name="valumetric_actual" step="any" readonly="readonly"
																class="form-control my-colorpicker1 valumetric_weight"
																id="valumetric_actual"></th>

														<th class="volumetic_weight_td"><input type="text"
																name="valumetric_chageable" step="any"
																readonly="readonly"
																class="form-control my-colorpicker1 valumetric_weight"
																id="valumetric_chageable"></th>
														<!-- <td><input type="text" name="one_cft_kg" readonly="readonly" class="form-control my-colorpicker1 one_cft_kg" id="one_cft_kg"></td> -->
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
								<h4 class="card-title">Charges</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Freight</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="frieht" class="form-control"
														value="" readonly required id="frieht" />
												</div>
												<label class="col-sm-3 col-form-label">Handling Charge</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="transportation_charges"
														class="form-control" readonly value="0"
														id="transportation_charges">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Pickup</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="pickup_charges"
														class="form-control" readonly value="0" id="pickup_charges">
												</div>
												<label class="col-sm-3 col-form-label">ODA Charge</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="delivery_charges"
														class="form-control" readonly value="0" id="delivery_charges">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Insurance</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="insurance_charges"
														class="form-control" readonly id="insurance_charges">
												</div>
												<label class="col-sm-3 col-form-label">COD</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="courier_charges"
														class="form-control" readonly value="0" id="courier_charges">
												</div>
											</div>
											<div class="form-group row">



												<label class="col-sm-3 col-form-label">AWB Ch.</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="awb_charges"
														class="form-control" readonly value="0" id="awb_charges">
												</div>
												<label class="col-sm-3 col-form-label">Other Ch.</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="other_charges"
														class="form-control" readonly value="0" id="other_charges">
												</div>
											</div>

											<div class="form-group row">



												<label class="col-sm-3 col-form-label">Topay.</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="green_tax"
														class="form-control" readonly value="0" id="green_tax">
												</div>
												<label class="col-sm-3 col-form-label">Appt Ch.</label>
												<div class="col-sm-3">
													<input type="number" step="any" name="appt_charges"
														class="form-control" readonly value="0" id="appt_charges">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-3 col-form-label">Fov Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control"
														name="fov_charges" readonly id="fov_charges" value="0">
												</div>
												<label class="col-sm-3 col-form-label">Total</label>
												<div class="col-sm-3">
													<input type="number" step="any" readonly name="amount"
														class="form-control" value="0" id="amount" />
												</div>

											</div>
											<div class="form-group row">

												<label class="col-sm-3 col-form-label">Fuel Surcharge</label>
												<div class="col-sm-3">
													<input type="text" step="any" class="form-control" readonly
														name="fuel_subcharges" value="0" id="fuel_charges">
												</div>
												<label class="col-sm-3 col-form-label">Address Change</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control" readonly
														name="address_change" value="" id="address_change">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">DPH </label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control" readonly
														name="dph" value="0" id="dph">
												</div>
												<label class="col-sm-3 col-form-label">Warehousing Change</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control unblock_charges"
														readonly name="warehousing" value="" id="warehousing">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Lable </label>
												<div class="col-sm-3">
													<input type="text" class="form-control unblock_charges txtOnly"
														readonly name="adhoc_lable[]" id="lable">
												</div>
												<label class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control unblock_charges"
														readonly name="adhoc_charges[]" value="" id="lcharges1">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Lable </label>
												<div class="col-sm-3">
													<input type="text" class="form-control unblock_charges txtOnly"
														readonly name="adhoc_lable[]" id="lable">
												</div>
												<label class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" step="any"
														class="form-control unblock_charges " readonly
														name="adhoc_charges[]" value="" id="lcharges2">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Lable </label>
												<div class="col-sm-3">
													<input type="text" class="form-control unblock_charges txtOnly"
														readonly name="adhoc_lable[]" id="lable">
												</div>
												<label class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" step="any" class="form-control unblock_charges"
														readonly name="adhoc_charges[]" value="" id="lcharges3">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card-header">
								<h4 class="card-title">Final Charge <span style="color:red" id="isMinimumValue"></span>
								</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-6">
													<div class="form-group row" id="payby" style="display:none;">
														<label class="col-sm-2 col-form-label">Pay By<span
																class="compulsory_fields">*</span></label>
														<div class="col-sm-4">
															<select class="form-control" disabled name="payment_method"
																id="payment_method">
																<option>-Select-</option>
																<?php foreach ($payment_method as $pm) { ?>
																	<option value="<?php echo $pm['id']; ?>">
																		<?php echo $pm['method']; ?>
																	</option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row" id="Refno" style="display:none;">
														<label class="col-sm-3 col-form-label">Ref No</label>
														<div class="col-sm-9">
															<input type="text" name="ref_no" readonly
																class="form-control" id="refer_no" />
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Sub Total</label>
														<div class="col-sm-9">
															<input type="number" step="any" readonly name="sub_total"
																class="form-control" value="0" id="sub_total" />
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">CGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control" type="number" id="cgst"
																step="any" name="cgst" value="0" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">SGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control" type="number" id="sgst"
																step="any" name="sgst" value="0" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">IGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control" type="number" id="igst"
																step="any" name="igst" value="0" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Grand Total</label>
														<div class="col-sm-9">
															<input type="text" readonly class="form-control"
																name="grand_total" value="0" id="grand_total" />
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row mt-3">
												<div class="col-sm-12">
													<button type="submit" class="btn btn-primary" style="display:none"
														id="submit1">Submit</button> &nbsp;
													<button type="button" class="btn btn-primary"
														onclick="return NotifySubmission();"
														id="desabledBTN">Submit &nbsp;
														<span class="spinner-border spinner-border-sm" id="spinner" style="display:none" role="status" aria-hidden="true"></span>
													</button> &nbsp;
													<button type="button" onclick="return open_new_page()"
														class="btn btn-primary">New</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Charges -->


					</div>
					<!-- <div class="col-md-6 col-sm-12 mt-3"></div>
							<div class="col-md-6 col-sm-12 mt-3">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<label>Comment</label>
												<textarea class="form-control" name="" id="comment"></textarea>
											</div>
											<div class="col-sm-12 mt-3">
												<button type="submit"  class="btn btn-primary" style="display:none" id="submit1">Submit</button> &nbsp;
												<button type="button"  class="btn btn-primary" onclick="return checkForTheCondition();" id="desabledBTN">Submit</button> &nbsp;
												<button type="button" onclick="return open_new_page()" class="btn btn-primary">New</button>
											</div>
										</div>
									</div>
								</div>
							</div> -->
				</div>
			</form>
		</div>
		</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="submit_notify" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Payment Mode Alert!</h5>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button> -->
			</div>
			<div class="modal-body" id="mbg-color">
				<div  style="line-height:10px;padding-left:0px; margin:25px 0;">
					<h4>Are You Sure You Want to <br> book the Shipment in <span id="mode_name" style="font-size:30px;"></span> mode ?</h4>
				</div>
			
			<div class="modal-footer">
			    <button type="button" onclick="return checkForTheCondition();" class="btn btn-primary">Book</button>
				<button type="button" class="btn btn-danger" id="cancel_model" data-dismiss="modal">Cancel</button>
			</div>
			</div>
			</div>
		</div>
		</div>
		<!-- </form> -->
		<input type="hidden" id="usertype" value="<?php echo $this->session->userdata('userType'); ?>">
		<input type="hidden" id="length_detail" value="">
		<input type="hidden" id="branch_gst" value="<?php echo substr(trim($branch_info->gst_number), 0, 2);
		; ?>">
		</div>
	</main>
	<!-- END: Content-->
	<!-- START: Footer-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
	<!-- START: Footer-->
</body>
<!-- END: Body-->

 <script src="<?php echo base_url();?>assets/js/domestic_shipment_1.js"></script>
<script type="text/javascript">
	// 		(function($) {
	//   $.fn.inputFilter = function(callback, errMsg) {
	//     return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
	//       if (callback(this.value)) {
	//         // Accepted value
	//         if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
	//           $(this).removeClass("input-error");
	//           this.setCustomValidity("");
	//         }
	//         this.oldValue = this.value;
	//         this.oldSelectionStart = this.selectionStart;
	//         this.oldSelectionEnd = this.selectionEnd;
	//       } else if (this.hasOwnProperty("oldValue")) {
	//         // Rejected value - restore the previous one
	//         $(this).addClass("input-error");
	//         this.setCustomValidity(errMsg);
	//         this.reportValidity();
	//         this.value = this.oldValue;
	//         this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
	//       } else {
	//         // Rejected value - nothing to restore
	//         this.value = "";
	//       }
	//     });
	//   };
	// }(jQuery));
	$(document).ready(function () {

		// $("#awn").inputFilter(function(value) {
		//   return /^-?\d*$/.test(value); }, "Must be an integer");

		$("input#awn").on({
			keydown: function (e) {
				if (e.which === 32)
					return false;
			},
			change: function () {
				this.value = this.value.replace(/\s/g, "");
			},
			blur: function () {
				var x = document.getElementById("awn").value.toUpperCase();
				if (x != '' && x != null) {
					var pattern = /[F\d][B\d][I\d]\d{6}/;
					var result = pattern.test(x);
					if (result == false) {
						alert('Wrong or invalid AWB No. Please check AWB No. and try again.');
						document.getElementById("awn").value = '';
					}
				}
			}
		});
		$(".txtOnly").keypress(function (e) {
			var key = e.keyCode;
			if (key >= 48 && key <= 57) {
				e.preventDefault();
			}
		});
		$(function () {
			$("form[name='generatePOD']").validate({
				rules: {
					booking_date: "required",
					courier_company: "required",
					payment_method: "required",
					forworder_name: "required",
					courier_company: "required",
					invoice_value: "required",
					mode_dispatch: "required",
					doc_type: "required",
					dispatch_details: "required",
					sender_pincode: "required",
					reciever_name: "required",
					reciever_pincode: "required",
					sender_name: "required",
					contactperson_name: "required",
					frieht: {
						required: true,
						min: 1
					},
					transportation_charges: "required",
					pickup_charges: "required",
					delivery_charges: "required",
					courier_charges: "required",
					awb_charges: "required",
					other_charges: "required",
					amount: {
						required: true,
						min: 1
					},
					sub_total: {
						required: true,
						min: 1
					},
					grand_total: {
						required: true,
						min: 1
					},
					sender_gstno: "required",
				},
				minimumField: {
					min: function (element) {
						return $("#frieht").val() != "";
					}
				},
				// Specify validation error messages
				messages: {
					courier_company: "required",
					payment_method: "required",
					booking_date: "Required",
					forworder_name: "Required",
					courier_company: "Required",
					mode_dispatch: "Required",
					invoice_value: "Required",
					doc_type: "Required",
					dispatch_details: "Required",
					sender_pincode: "Required",
					reciever_name: "Required",
					sender_name: "Required",
					contactperson_name: "Required",
					reciever_pincode: "Required",
					frieht: "Required",
					transportation_charges: "Required",
					pickup_charges: "Required",
					delivery_charges: "Required",
					courier_charges: "Required",
					awb_charges: "Required",
					other_charges: "Required",
					amount: "Required",
					sub_total: "Required",
					igst: "Required",
					grand_total: "Required",
					sender_gstno: "Required",
				},
				errorPlacement: function (error, element) {
					if (element.attr("type") == "radio") {
						error.insertBefore(element);
					} else {
						error.insertAfter(element);
					}
				},
				submitHandler: function (form) {
					form.submit();
				}
			});
		});

		$("form[name='generatePOD']").validate();
	});


	$("#sender_gstno,#statecode,#invoice_value").blur(function () {
		var sender_gstno = $("#sender_gstno").val();
		var statecode = $("#statecode").val();
		var invoice_value = $("#invoice_value").val();
		// alert(statecode);
		var gst2digit = sender_gstno.slice(0, 2);
		if ((gst2digit == statecode) && (invoice_value > 99999)) {
			$("#eway_no").attr("required", "true");
		} else if ((gst2digit != statecode) && (invoice_value > 49999)) {
			$("#eway_no").attr("required", "true");
		} else {
			$("#eway_no").removeAttr("required");
		}
	});

	$(".eway_no1").blur(function () {
		var ewayno = $(this).val();
		if (ewayno) {
			$(".eway_expiry").attr("required", "true");
			$("#receiver_gstno").attr("required", "true");
			$("#sender_gstno").attr("required", "true");
		} else {
			$(".eway_expiry").removeAttr("required");
			$("#receiver_gstno").removeAttr("required");
			$("#sender_gstno").removeAttr("required");
		}
	});

	$('#doc_typee').change(function () {
		var doc_typee = $(this).val();
		if (doc_typee == '0') {
			$("#is_volumetric").removeAttr("required");
		} else {
			$("#is_volumetric").attr("required", "true");
		}
	});

	// $('#bkdate_check').css({"display":"none"});
	//  $("#booking_date").change(function(){
	// 	let dt = $("#booking_date").val();
	// 	var bdt = new Date(dt);
	// 	var bmonth = bdt.getMonth()+1; var bday = bdt.getDate();
	// 	var boutput = bdt.getFullYear() + '/' + (bmonth<10 ? '0' : '') + bmonth + '/' +  (bday<10 ? '0' : '') + bday;

	// 	var d = new Date();
	// 	var month = d.getMonth()+1; var day = d.getDate();

	// 	var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' +  (day<10 ? '0' : '') + day;
	// 	if(output == boutput){
	// 		// $("#bkdate_reason").attr("required", "false");
	// 		$("#bkdate_reason").removeAttr("required");
	// 		$('#bkdate_check').css({"display":"none"});
	// 	}else{
	// 		$("#bkdate_reason").attr("required", "true");
	// 		$('#bkdate_check').css({"display":"flex"});
	// 	}
	// });

	function check_customers_rate() {
		let customer_id = $("#customer_account_id").val();
		let packet = $("#no_of_pack1").val();
		console.log(packet);
		console.log(customer_id);
		$.ajax({
			url: "<?php echo base_url() . 'Admin_domestic_rate_manager/get_customer_rate'; ?>",
			type: 'POST',
			dataType: "json",
			data: { packet: packet, customer_id: customer_id },
			// error: function() {
			// alert('Please Try Again Later');
			// },
			success: function (data) {
				console.log(data);
			},
			error: function (response) {
				console.log(response);
			}
		});

	}
</script>

</html>