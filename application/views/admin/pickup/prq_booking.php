<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
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

	.card .card-header {
		background-color: transparent;
		border-color: var(--bordercolor);
		padding: 15px;
		background-color: #ea5a2a;
		color: #fff;
	}
</style>
<!-- START: Body-->

<body id="main-container" class="default">

	<!-- END: Main Menu-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
	<!-- END: Main Menu-->

	<!-- START: Main Content-->
	<main> <br><br>
		<div class="container-fluid site-width">
			<!-- START: Card Data-->
			<form role="form" name="generatePOD" id="generatePOD" action="<?php echo base_url();?>Admin_PRQ_booking/insert_franchise_shipment" method="post">
				<div class="row">
					<div class="col-md-4 col-sm-12 mt-3">
						<!-- Shipment Info -->
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Franchise Shipment Info</h4>
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
										<label class="col-sm-4 col-form-label">Date<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">



											<?php
											$datec = date('Y-m-d H:i');

											// $tracking_data[0]['tracking_date'] = date('Y-m-d H:i',strtotime($tracking_data[0]['tracking_date']));
											$datec  = str_replace(" ", "T", $datec);
											if ($this->session->userdata('booking_date') != '') { ?>

												<input type="datetime-local" name="booking_date" value="<?php echo $this->session->userdata('booking_date'); ?>" id="booking_date" class="form-control">
											<?php
											} else { ?>
												<input type="datetime-local" name="booking_date" value="<?php echo $datec; ?>" id="booking_date" class="form-control" readonly>
											<?php } ?>
										</div>
									</div>


									<div class="form-group row">
										<label class="col-sm-4 col-form-label">PRQ<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control pickup_request_no" name="pickup_request_no" id="pickup_request_no">
												<option value="">-Select PRQ-</option>
												<?php
												if (!empty($prq_ref_no)) {
													foreach ($prq_ref_no as $row) {
												?>
														<option value='<?php echo $row->pickup_request_id; ?>'><?php echo $row->pickup_request_id; ?>--<?php echo $row->customer_name; ?></option>
												<?php
													}
												}
												?>

											</select>
										</div>
									</div>

                                    <input type="hidden" name="customer_account_id"  class="form-control" id ="customer_account_id">
                                    <input type="hidden" name="customer_type"  class="form-control" id ="customer_type">
									<input type="hidden"   class="form-control customer_name12">
									<input type="hidden" name="awn" id="awn" class="form-control" value="<?php echo $bid; ?>">
									<input type="hidden" name="courier_company" id="courier_company" class="form-control" value="35">


									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Mode<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control mode_dispatch" name="mode_dispatch" id="mode_dispatch" required>
												<option value="">-Select Mode-</option>
												<?php
												if (!empty($transfer_mode)) {
													foreach ($transfer_mode as $row) {
												?>
														<option value='<?php echo $row->transfer_mode_id; ?>'><?php echo $row->mode_name; ?></option>
												<?php
													}
												}
												?>

											</select>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Desc.</label>
										<div class="col-sm-8">
											<textarea name="special_instruction"  class="form-control my-colorpicker1"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Risk Type<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="risk_type" disabled id="risk_type">
												<option value="Customer">Customer</option>
												<option value="Carrier">Carrier</option>
											</select>
											<input type="hidden" name="risk_type" value="Customer">
										</div>
									</div>

									<!-- <div class="form-group row">
										<label class="col-sm-4 col-form-label">Bill Type<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="dispatch_details" id="dispatch_details">
												<option value="PrePaid">Pre-Paid</option>
											</select>											
										</div>	
							        </div> -->

									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Bill Type<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control dispatch_details pre_paid" name = "dispatch_details" id="dispatch_details" required>
												<option value="">-Select-</option>
												<option value="Credit">Credit</option>
												<option value="Cash">Cash</option>
												<option value="COD">COD</option>
												<option value="ToPay">ToPay</option>
												<option value="FOC">FOC</option>
												<option value="PrePaid">Pre-Paid</option>
											</select>											
										</div>
										
							        </div>
									<div id="pre_paid">	</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Product<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" name="doc_type" id="doc_typee" required>
												<option value="">-Select-</option>
												<option value="1">Non-Doc</option>
												<option value="0">Doc</option>
											</select>
										</div>
									</div>
									<div id="div_inv_row" style="display: none;">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">INV No.</label>
											<div class="col-sm-8">
												<input type="text" name="invoice_no" id="invoice_no" class="form-control my-colorpicker1">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Inv. Value<span class="compulsory_fields">*</span></label>
											<div class="col-sm-8">
												<input type="number" name="invoice_value" id="invoice_value" class="form-control my-colorpicker1">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Eway No</label>
											<div class="col-sm-8">
												<input type="text" name="eway_no" minlength="12" maxlength="12" size="12" id="eway_no" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Eway Expiry date</label>
											<div class="col-sm-8">
												<input type="datetime-local" name="eway_expiry_date" id="eway_no" class="form-control">
											</div>
										</div>
									</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Type Of Parcel<span class="compulsory_fields">*</span></label>
											<div class="col-sm-8">
												<select class="form-control" name="type_shipment" id="type_of_package">
													<option value="">-Select-</option>
													<option value="Wooden Box">Wooden Box</option>
													<option value="Carton">Carton</option>
													<option value="Drum">Drum</option>
													<option value="Plastic Wrap">Plastic Wrap</option>
													<option value="Gunny Bag">Gunny Bag</option>
												</select>
											</div>  													
										</div> 
									</div>

								
								<!-- Shipment Info -->
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 mt-3">
						<!-- Consigner Detail -->
						<div class="card">
							<div class="card-header">
								<div class="card-title">
									<span style="float:left;font-size: 17px;">Consigner Detail </span>
									<span style="float:right;font-size: 17px;">Wallet Amount : <small id="wallet" class="no_amount"></small></span>
								</div>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Customer</label>
										<div class="col-sm-8" >
										  <select class="form-control" id="getcid" readonly >
												<option value="">Select Customer</option>
											</select>
											<!-- <select class="form-control" disabled id="getcid">
												<option value="">Select Customer</option>
												<?php
												
												// if (count($franchise_customers)) {

												// 	foreach ($franchise_customers as $rows) {?>
												// 		<option value="<?php // echo $rows['customer_id']; ?>"><?php //echo $rows['customer_name']; ?>--<?php //echo $rows['cid']; ?></option>
												// <?php
												// 	}
												// }
												 ?>
											</select> -->
										</div>
									</div>

									

									<!-- <div class="form-group row">
										<label class="col-sm-4 col-form-label" id="credit_div_label">Name<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text"  class="form-control customer_name12  my-colorpicker1" id="cid" readonly><input
										</div>
									</div> -->

									<div class="form-group row">
										<label class="col-sm-4 col-form-label" id="credit_div_label">Name<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="sender_name" id="sender_name" class="form-control my-colorpicker1" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Address</label>
										<div class="col-sm-8">
											<textarea name="sender_address" id="sender_address" class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" name="sender_pincode" id="sender_pincode" class="form-control pickup_pincode12">
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
										<label class="col-sm-4 col-form-label">City<span class="compulsory_fields">*</span></label>
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
											<input type="text" name="sender_contactno" id="sender_contactno" class="form-control my-colorpicker1">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">TypeOfDoc<span class="compulsory_fields">*</span></label>
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
											<input type="text" name="sender_gstno" id="sender_gstno" class="form-control my-colorpicker1">

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
											<input type="text" name="reciever_name" id="reciever" class="form-control" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Company<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="contactperson_name" id="contactperson_name" required />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Address</label>
										<div class="col-sm-8">
											<textarea name="reciever_address" id="reciever_address" class="form-control" autocomplete="off"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<input type="number" class="form-control" name="reciever_pincode" id="reciever_pincode" autocomplete="off">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">state<span class="compulsory_fields">*</span></label>
										<div class="col-sm-8">
											<select class="form-control" id="reciever_state" readonly name="reciever_state">

												<option value="">Select State</option>

											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">City<span class="compulsory_fields">*</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="oda"></span></label>
										<div class="col-sm-8">
											<select class="form-control" id="reciever_city" readonly name="reciever_city">
												<option value="">Select State</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Zone</label>
										<div class="col-sm-8">
											<input type="hidden" name="statecode" id="statecode" class="form-control my-colorpicker1">
											<input type="text" name="receiver_zone" id="receiver_zone" class="form-control" required>
											<input type="hidden" name="receiver_zone_id" id="receiver_zone_id" class="form-control">
											<input type="hidden" id="gst_charges" class="form-control">
											<input type="hidden" id="cft" class="form-control">
											<input type="hidden" id="air_cft" class="form-control">
											<input type="hidden" name="final_branch_id" id="final_branch_id" class="form-control" required>
											<input type="hidden" name="branch_name" id="final_branch_name" class="form-control" required readonly>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-4 col-form-label">ContactNo.</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="reciever_contact" name="reciever_contact" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">GST NO.</label>
										<div class="col-sm-8">
											<input type="text" name="receiver_gstno" id="receiver_gstno" class="form-control">
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
								<a id="calculator" style="color: #007bff; cursor:pointer; float:left;">Centimeter Calculator</a>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">PKT</label>
												<div class="col-sm-4">
													<input type="text" name="no_of_pack" class="form-control my-colorpicker1 no_of_pack no_of_pack2" data-attr="1" id="no_of_pack1" required="required">
												</div>
												<label class="col-sm-2 col-form-label">Actual Weight</label>
												<div class="col-sm-4">
													<input type="text" name="actual_weight" class="form-control my-colorpicker1 actual_weight actual_weight2" data-attr="1" id="actual_weight"  required="required">
												</div>
												<label class="col-sm-2 col-form-label">Chargeable Weight</label>
												<div class="col-sm-4">
													<input type="text" name="chargable_weight" class="form-control my-colorpicker1 chargable_weight" data-attr="1" id="chargable_weight" required="required">
												</div>
												<label class="col-sm-2 col-form-label">Is Volumetric</label>
												<div class="col-sm-4">

													<input type="checkbox" id="is_volumetric" name="fav_language" value="">

												</div>
											</div>
											<div id="volumetric_table" style="display:none ! important;">
												<table class="weight-table">
													<thead>
														<tr><input type="hidden" class="form-control" name="length_unit" id="length_unit" class="custom-control-input" value="cm">
															<th>Per Box Pack</th>
															<th class="length_th">L ( Cm )</th>
															<th class="breath_th">B ( Cm )</th>
															<th class="height_th">H ( Cm )</th>
															<th class="volumetric_weight_th">Valumetric Weight</th>
															<th class="volumetric_weight_th">Actual Weight</th>
															<th class="volumetric_weight_th">Chargeable Weight</th>

														</tr>
														<thead>
														<tbody id="volumetric_table_row">
															<tr>
																<td><input type="text" name="per_box_weight_detail[]" class="form-control per_box_weight valid" data-attr="1" id="per_box_weight1" aria-invalid="false"></td>
																<td class="length_td"><input type="text" name="length_detail[]" class="form-control length" data-attr="1" id="length1"></td>
																<td class="breath_td"><input type="text" name="breath_detail[]" class="form-control breath" data-attr="1" id="breath1"></td>
																<td class="height_td"><input type="text" name="height_detail[]" class="form-control height" data-attr="1" id="height1"></td>
																<td class="volumetic_weight_td"><input type="text" name="valumetric_weight_detail[]" readonly class="form-control valumetric_weight" data-attr="1" id="valumetric_weight1"></td>

																<td class="volumetic_weight_td"><input type="text" name="valumetric_actual_detail[]" class="form-control valumetric_actual" data-attr="1" id="valumetric_actual1"></td>

																<td class="volumetic_weight_td"><input type="text" name="valumetric_chageable_detail[]" readonly class="form-control valumetric_chageable" data-attr="1" id="valumetric_chageable1"></td>
															</tr>
														</tbody>
													<tfoot>

													</tfoot>
												</table>
												<table>
													<tr>

														<th><input type="text" name="per_box_weight" readonly="readonly" class="form-control  per_box_weight" id="per_box_weight" required="required"></th>
														<th class="length_td"><input type="text" name="length" readonly="readonly" class="form-control length" id="length"></th>
														<th class="breath_td"><input type="text" name="breath" readonly="readonly" class="form-control breath" id="breath"></th>
														<th class="height_td"><input type="text" name="height" readonly="readonly" class="form-control height" id="height"></th>
														<th class="volumetic_weight_td"><input type="text" name="valumetric_weight" readonly="readonly" class="form-control my-colorpicker1 valumetric_weight" id="valumetric_weight"></th>

														<th class="volumetic_weight_td"><input type="text" name="valumetric_actual" readonly="readonly" class="form-control my-colorpicker1 valumetric_weight" id="valumetric_actual"></th>

														<th class="volumetic_weight_td"><input type="text" name="valumetric_chageable" readonly="readonly" class="form-control my-colorpicker1 valumetric_weight" id="valumetric_chageable"></th>
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
													<input type="number" name="frieht" class="form-control frieht" value="" readonly required id="frieht" />
												</div>
												<label class="col-sm-3 col-form-label">Handling Charge</label>
												<div class="col-sm-3">
													<input type="number" name="transportation_charges" class="form-control transportation_charges" readonly value="0" id="transportation_charges">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Pickup</label>
												<div class="col-sm-3">
													<input type="number" name="pickup_charges" class="form-control"  value="0" id="pickup_charges">
												</div>
												<label class="col-sm-3 col-form-label">ODA Charge</label>
												<div class="col-sm-3">
													<input type="number" name="delivery_charges" class="form-control delivery_charges" readonly value="0" id="delivery_charges">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Insurance</label>
												<div class="col-sm-3">
													<input type="number" name="insurance_charges" class="form-control insurance_charges" readonly id="insurance_charges">
												</div>
												<label class="col-sm-3 col-form-label">COD</label>
												<div class="col-sm-3">
													<input type="number" name="courier_charges" class="form-control courier_charges" readonly value="0" id="courier_charges">
												</div>
											</div>
											<div class="form-group row">



												<label class="col-sm-3 col-form-label">AWB Ch.</label>
												<div class="col-sm-3">
													<input type="number" name="awb_charges" class="form-control" readonly value="0" id="awb_charges">
												</div>
												<label class="col-sm-3 col-form-label">Other Ch.</label>
												<div class="col-sm-3">
													<input type="number" name="other_charges" class="form-control " readonly value="0" id="other_charges">
												</div>
											</div>

											<div class="form-group row">



												<label class="col-sm-3 col-form-label">Topay.</label>
												<div class="col-sm-3">
													<input type="number" name="green_tax" class="form-control " readonly value="0" id="green_tax">
												</div>
												<label class="col-sm-3 col-form-label">Appt Ch.</label>
												<div class="col-sm-3">
													<input type="number" name="appt_charges" class="form-control " readonly value="0" id="appt_charges">
												</div>
											</div>
											<div class="form-group row">

												<label class="col-sm-3 col-form-label">Fov Charges</label>
												<div class="col-sm-3">
													<input type="number" class="form-control " name="fov_charges" readonly id="fov_charges" value="0">
												</div>
												<label class="col-sm-3 col-form-label">Total</label>
												<div class="col-sm-3">
													<input type="number" readonly name="amount" class="form-control" value="0" id="amount" />
												</div>

											</div>
											<div class="form-group row">

												<label class="col-sm-3 col-form-label">Fuel Surcharge</label>
												<div class="col-sm-3">
													<input type="number" class="form-control fuel_charges" readonly name="fuel_subcharges" value="0" id="fuel_charges">
												</div>
												<label class="col-sm-3 col-form-label">Address Change</label>
												<div class="col-sm-3">
													<input type="number" class="form-control address_change" readonly name="address_change" value="" id="address_change">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">DPH </label>
												<div class="col-sm-3">
													<input type="number" class="form-control" readonly name="dph" value="0" id="dph">
												</div>
												<label class="col-sm-3 col-form-label">Warehousing Change</label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="warehousing" value="" id="warehousing">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Lable </label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="adhoc_lable[]" id="lable">
												</div>
												<label class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="adhoc_charges[]" value="" id="warehousing">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Lable </label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="adhoc_lable[]" id="lable">
												</div>
												<label class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="adhoc_charges[]" value="" id="warehousing">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Lable </label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="adhoc_lable[]" id="lable">
												</div>
												<label class="col-sm-3 col-form-label">Charges</label>
												<div class="col-sm-3">
													<input type="number" class="form-control unblock_charges" readonly name="adhoc_charges[]" value="" id="warehousing">
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
													<div class="form-group row" id="payby" >
														<label class="col-sm-2 col-form-label">Pay By<span class="compulsory_fields">*</span></label>
														<div class="col-sm-4">
															<select class="form-control"  name="payment_method" id="payment_method">
																<option>-Select-</option>
																<?php foreach ($payment_method as $pm) { ?>
																	<option value="<?php echo $pm['id']; ?>"><?php echo $pm['method']; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row" id="Refno" style="display:none;">
														<label class="col-sm-3 col-form-label">Ref No</label>
														<div class="col-sm-9">
															<input type="text" name="ref_no" readonly class="form-control" id="refer_no" />
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Sub Total</label>
														<div class="col-sm-9">
															<input type="number" readonly name="sub_total" class="form-control sub_total" value="0" id="sub_total" />
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">CGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control cgst" type="number" id="cgst" step="any" name="cgst" value="0" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">SGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control sgst" type="number" id="sgst" step="any" name="sgst" value="0" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">IGST Tax</label>
														<div class="col-sm-9">
															<input class="form-control igst" type="number" id="igst" step="any" name="igst" value="0" readonly>
														</div>
													</div>
												</div>
												<div class="col-6">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Grand Total</label>
														<div class="col-sm-9">
															<input type="text" readonly class="form-control grand_total" name="grand_total" value="0" id="grand_total" />
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row mt-3">
												<div class="col-sm-12">
													<button type="submit" class="btn btn-primary" style="display:none" id="submit1">Submit</button> &nbsp;
													<button type="button" class="btn btn-primary" onclick="return checkForTheCondition();">Submit</button> &nbsp;
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
		<!-- </form> -->
		<input type="hidden" id="usertype" value="<?php echo $this->session->userdata('userType'); ?>">
		<input type="hidden" id="length_detail" value="">
		<input type="hidden" id="branch_gst" value="<?php echo substr(trim($branch_info->gst_number), 0, 2); ?>">
		</div>
	</main>
	<!-- END: Content-->
	<!-- START: Footer-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
	<!-- START: Footer-->
</body>
<!-- END: Body-->

<script src="<?php echo base_url(); ?>assets/js/prq_franchise.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_prq.js"></script>

<script>
	$('#pickup_request_no').change(function() {
				var pickup_request_no = $('#pickup_request_no').val();
				//alert(pickup_request_no);

				$.ajax({
							url: "<?php echo base_url(); ?>Pickup_Request_Controller/fetch_consigner",
							method: "POST",
							data: {
								pickup_request_no: pickup_request_no
							},
							success: function(json) {
								data = JSON.parse(json);
								// console.log(data)
								$('#customer_account_id').val(data.customer_id);
								$('.customer_name12').val(data.customer_name);
								$('#cid').val(data.cid);
								$('.customer_type').val(data.customer_type);

							  	if(data.customer_type == '2'){
									$('.pre_paid').val("PrePaid");
									$('#pre_paid').html("<input type='hidden' name='dispatch_details' value ='PrePaid' class='form-control'>");
									$('.pre_paid').attr('disabled', true);
								
									$("#pickup_charges").attr('required', true);

								}else{
									//$('.pre_paid').attr('enable', true);
									$("#pickup_charges").removeAttr("required");
								}

								var option;
								option += '<option value="'+data.customer_id +'">' + data.customer_name +"--" + data.cid+ '</option>';
								$('#getcid').html(option);

							  	





								if (data.pickup_request_id != null || data.pickup_request_id != '') {
									$.ajax({
										type: 'POST',
										dataType: 'json',
										url: 'Admin_PRQ_booking/getpickupconsineeDetails',
										data: 'pickup_request_id=' + data.pickup_request_id,
										success: function(data) {
											console.log(data);
											$("#reciever").val(data[0].consigner_name);
											$("#contactperson_name").val(data[0].consigner_name);
											$("#reciever_address").val(data[0].consigner_address1);
											$("#reciever_pincode").val(data[0].destination_pincode);
											$("#reciever_state").val(data[0].consigner_name);
											$("#reciever_city").val(data[0].consigner_name);
											$("#reciever_contact").val(data[0].consigner_contact);
											$(".actual_weight2").val(data[0].actual_weight);
											$(".no_of_pack2").val(data[0].no_of_pack);
											$("#type_of_package").val(data[0].type_of_package);
											$("#mode_dispatch").val(data[0].mode_id);
											$("#special_instruction").val(data[0].instruction);
											$("#sender_pincode").val(data[0].pickup_pincode);




											if (data[0].destination_pincode != null || data[0].destination_pincode != '') {

												$.ajax({
													type: 'POST',
													url: 'Franchise_manager/getCityList',
													data: 'pincode=' + data[0].destination_pincode,
													dataType: "json",
													success: function(d) {
														// console.log(d.result2.city);     
														var option;
														option += '<option value="' + d.id + '">' + d.city + '</option>';
														$('#reciever_city').html(option);

													}
												});
												$.ajax({
													type: 'POST',
													url: 'Franchise_manager/getState',
													data: 'pincode=' + data[0].destination_pincode,
													dataType: "json",
													success: function(d) {
														var option;
														option += '<option value="' + d.result3.id + '">' + d.result3.state + '</option>';
														$('#reciever_state').html(option);
														var oda = '';
														oda += '<span style="color:red;">' + d.oda.isODA + '</span>';
														$('#oda').html(oda);
													},
													error: function() {
														$('#oda').html('<p>Service Not Available</p>');
													}
												});

											}




											if (data[0].customer_id != null || data[0].customer_id != '') {
												$.ajax({
													type: 'POST',
													dataType: "json",
													url: 'Admin_domestic_shipment_manager/getsenderdetails',
													data: 'customer_name=' + data[0].customer_id,
													success: function(data) {


														$("#sender_name").val(data.user.customer_name);
														$("#sender_address").val(data.user.address);
														//$("#sender_pincode").val(data.user.pincode);
														$("#sender_contactno").val(data.user.phone);
														$("#sender_gstno").val(data.user.gstno);
														$("#gst_charges").val(data.user.gst_charges);
														// $("#sender_city").val(data.user.city);
														// $("#sender_state").val(data.user.state);					
														$("#customer_account_id").val(data.user.customer_id);

														var option;
														option += '<option value="' + data.user.city_id + '">' + data.user.city_name + '</option>';
														$('#sender_city').html(option);

														var option1;
														option1 += '<option value="' + data.user.state_id + '">' + data.user.state_name + '</option>';
														$('#sender_state').html(option1);
														var dispatch_details = $("#dispatch_details").val();
														if (dispatch_details != "Cash" ) {

															calculate_cft();			

														}
														document.getElementById("reciever").focus();


														if (data.user.customer_id != null || data.user.customer_id != '') {
															$.ajax({
																type: 'POST',
																dataType: 'json',
																url: 'Admin_PRQ_booking/getwaletamount',
																data: 'customer_name=' + data.user.customer_id,
																success: function(data) {
																	// alert(data.wallet);
																	if ((data.wallet == '') || (data.wallet == null)) {
																		$('#wallet').html('0');
																	} else {
																		$("#wallet").html(data.wallet);

																	}

																}
															})
														}

													}
												});
											}


										}

									});

								}
							}

							});
						});
</script>



</html>