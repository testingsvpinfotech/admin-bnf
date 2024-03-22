<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
 <style>
  	.form-control{
  		color:black!important;
  		border: 1px solid var(--sidebarcolor)!important;
  		height: 27px;
  		font-size: 10px;
  }
    .select2-container--default .select2-selection--single {
    background: lavender!important;
    }
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
  	background:#ffff8f!important;
}
 input:focus {
  background-color: #ffff8f!important;
}
select:focus {
  background-color: #ffff8f!important;
}
textarea:focus {
  background-color: #ffff8f!important;
}
.btn:focus {
  color:red;    
  background-color: #ffff8f!important;
}  </style>   
    <!-- START: Body-->
    <body id="main-container" class="default">
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
        	<div class="container-fluid site-width">
                           
                    <!-- START: Card Data-->
                <form role="form" name="generatePOD" id="generatePOD" action="admin/edit-international-shipment/<?php echo $booking_id; ?>" method="post" >
                <div class="row">
                    <div class="col-md-7 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header">                               
                                <h4 class="card-title">Shipment Info</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                	 <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>  
                                    <div class="row">                                           
                                        <div class="col-12">                                           
                                                <div class="form-group row">
                                                	<label  class="col-sm-2 col-form-label">Date<span class="compulsory_fields">*</span></label>
													<div class="col-sm-4">
													   <input type="date" name="booking_date" value="<?php echo $booking->booking_date;?>" id="booking_date" class="form-control">
													</div>
													<label class="col-sm-2 col-form-label">Type<span class="compulsory_fields">*</span></label>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio"  name="export_import_type" class="custom-control-input" id="export_import_type1" value="Export" <?php if($booking->export_import_type=="Export"){echo "checked";} ?> required>
														<label class="custom-control-label checkbox-primary outline" for="export_import_type1">Export</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" name="export_import_type" class="custom-control-input" id="export_import_type2" value="Import" <?php if($booking->export_import_type=="Import"){echo "checked";} ?> required>
														<label class="custom-control-label checkbox-primary outline" for="export_import_type2">Import</label>
													</div>
													</div>
													 <div class="form-group row">
													<label class="col-sm-2 col-form-label">Courier<span class="compulsory_fields">*</span></label>
														<div class="col-sm-4">
															<select class="form-control" required name="courier_company" id="courier_company" >
																<option value="">-Select Courier Company-</option>
				        										<?php	
																if(!empty($courier_company))	
																{
																	foreach ($courier_company as $cc)
																	{
																		?>
																		<option value='<?php echo $cc['c_id']; ?>' data-id="<?php echo $cc['c_company_name']; ?>" <?php if($booking->courier_company_id==$cc['c_id']){echo "selected";} ?> ><?php echo $cc['c_company_name']; ?></option>
																		<?php 
																	}
																}
																?>
															</select>	

														</div>
														<label  class="col-sm-2 col-form-label">Airway No<span class="compulsory_fields">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="awn" id="awn" class="form-control my-colorpicker1" value="<?php echo $booking->pod_no; ?>">
															</div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Mode</label>
													<div class="col-sm-4">
															<input type="text" name="mode_dispatch"  class="form-control" value="Air" readonly>
													</div>
                                                </div> -->
                                                <div class="form-group row">
                                                   <label  class="col-sm-2 col-form-label">ForwordNo</label>
													<div class="col-sm-4">
														<input type="text" name="forwording_no" class="form-control my-colorpicker1" value="<?php echo $booking->forwording_no;?>">
													</div>	
													<label  class="col-sm-2 col-form-label">Forworder<span class="compulsory_fields">*</span></label>
													<div class="col-sm-4">
													  <input type="text" name="forworder_name" class="form-control" id="forworder_name" value="<?php echo $booking->forworder_name;?>" readonly>
													</div>		
                                                </div>  
                                                <div class="form-group row">
                                               			 <label class="col-sm-2 col-form-label">Product<span class="compulsory_fields">*</span></label>
														<div class="col-sm-4">
														<select class="form-control" name="doc_type" id="doc_typee">
															<option value="">-Select-</option>
															<option value="1" <?php if($booking->doc_type==1){echo "selected";} ?>>Non-Doc</option>
															<option value="0" <?php if($booking->doc_type==0){echo "selected";} ?>>Doc</option>
														</select>
														</div>
													<!--<label class="col-sm-2 col-form-label">Currency<span class="compulsory_fields">*</span></label>
													<div class="col-sm-4">
														<select class="form-control" required name="currency" id="currency" >
														<option value="">-Select Currency-</option>
														<?php	
														if(!empty($currency_list))	
														{
															foreach ($currency_list as $cc)
															{
																?>
																<option value='<?php echo $cc['id']; ?>' <?php if($booking->currency==$cc['id']){echo "selected";} ?>><?php echo $cc['code']; ?></option>
																<?php 
															}
														}
														?>
													</select>	
													</div>  -->	
												</div>
                                                <div class="form-group row" id="div_inv_row">
													<label class="col-sm-2 col-form-label">INV No.</label>
													<div class="col-sm-2">
														<input type="text" name="invoice_no" id="invoice_no" class="form-control" value="<?php echo $booking->invoice_no;?>">
													</div>
													<label class="col-sm-1 col-form-label">Inv. Value<span class="compulsory_fields">*</span></label>
													<div class="col-sm-2">
														<select class="form-control" required name="currency" id="currency" >
														<option value="">-Currency-</option>
														<?php	
														if(!empty($currency_list))	
														{
															foreach ($currency_list as $cc)
															{
																?>
																<option value='<?php echo $cc['id']; ?>' <?php if($booking->currency==$cc['id']){echo "selected";} ?>><?php echo $cc['code']; ?></option>
																<?php 
															}
														}
														?>
												    	</select>	
													</div>
													<div class="col-sm-2">
														<input type="number" name="invoice_value" id="invoice_value" value="<?php echo $booking->invoice_value;?>" class="form-control">
													</div>
													<label class="col-sm-1 col-form-label">Eway No</label>
													<div class="col-sm-2">
														<input type="text" name="eway_no" id="eway_no" value="<?php echo $booking->eway_no;?>" class="form-control">
													</div>
												</div>                                              
                                                <div class="form-group row">
                                                    <label  class="col-sm-2 col-form-label">Desc.</label>
													<div class="col-sm-4">
														<textarea name="special_instruction" class="form-control my-colorpicker1"><?php echo $booking->special_instruction;?></textarea>
													</div>
													<label class="col-sm-2 col-form-label">Bill Type<span class="compulsory_fields">*</span></label>
													<div class="col-sm-4">
														<select class="form-control" name="dispatch_details" id="dispatch_details">
																<option value="">-Select-</option>
																<option value="Credit" <?php if($booking->dispatch_details=='Credit'){echo "selected";} ?>>Credit</option>
																<option value="Cash" <?php if($booking->dispatch_details=='Cash'){echo "selected";} ?>>Cash</option>
                                                                                                                                <option value="COD" <?php if($booking->dispatch_details=='COD'){echo "selected";} ?>>COD</option>
                                                                                                                                <option value="ToPay" <?php if($booking->dispatch_details=='ToPay'){echo "selected";} ?>>ToPay</option>
														</select>										
													</div>
                                                </div>
                                                 
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="card-header">                               
                                <h4 class="card-title"><span id="Consigner_div">Consigner</span> Detail</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">                                           
                                                <div class="form-group row">
                                               
                                                    <label  class="col-sm-2 col-form-label">Customer</label>
													<div class="col-sm-4" id="credit_div">
													 <select class="form-control"  name="customer_account_id" id="customer_account_id">
														<option value="">Select Customer</option>
														<?php
															if (count($customers)) {
																foreach ($customers as $rows) {
																	?>
														<option value="<?php echo $rows['customer_id']; ?>" <?php if($booking->customer_id==$rows['customer_id']){echo "selected";} ?>  >
															<?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
														</option>
														<?php
															}
															} else {
															echo "<p>No Data Found</p>";
															}
															?>
													</select>
													</div>
												
												<label class="col-sm-2 col-form-label" id="credit_div_label">Name<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<input type="text" name="sender_name" value="<?php echo $booking->sender_name; ?>" readonly id="sender_name" class="form-control">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Address<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<textarea name="sender_address" readonly id="sender_address" class="form-control"><?php echo $booking->sender_address; ?></textarea>		
												</div>
												<label class="col-sm-2 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<input type="text" name="sender_pincode" value="<?php echo $booking->sender_pincode; ?>" readonly id="sender_pincode" class="form-control">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">State<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<select class="form-control" id="sender_state" name="sender_state">
													<option value="">Select State</option>	
													<?php 
															if(count($states)) {
																foreach ($states as $st) {
																	?>
														<option value="<?php echo $st['id']; ?>" <?php if($booking->sender_state==$st['id']){echo "selected";} ?>>
															<?php echo $st['state']; ?> 
														</option>
														<?php }
															} 
															?>
													</select>
												</div>
												<label class="col-sm-2 col-form-label">City<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">												
													<select class="form-control" id="sender_city" name="sender_city">
														<option value="">Select City</option>
														<?php
															if (count($cities)) {
																foreach ($cities as $rows) {
																	?>
														<option value="<?php echo $rows['id']; ?>" <?php if($booking->sender_city==$rows['id']){echo "selected";} ?>>
															<?php echo $rows['city']; ?> 
														</option>
														<?php }
															}
															?>
													</select>
												</div>												
											</div>
											<div class="form-group row">
													<label class="col-sm-2 col-form-label">ContactNo.<span class="compulsory_fields">*</span></label>
													<div class="col-sm-4">
													<input type="text" name="sender_contactno" readonly id="sender_contactno" class="form-control" value="<?php echo $booking->sender_contactno; ?>">
													</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">TypeOfDoc</label>
													<div class="col-sm-4">
														<select name="type_of_doc" class="form-control" onchange="return show_doc_type(this.value);">
															<option value="GSTIN" <?php if($booking->type_of_doc=="GSTIN"){echo "selected"; } ?>>GSTIN</option>
															<option value="GSTIN(Govt.)" <?php if($booking->type_of_doc=="GSTIN(Govt.)"){echo "selected"; } ?>>GSTIN(Govt.)</option>
															<option value="GSTIN(Diplomats)" <?php if($booking->type_of_doc=="GSTIN(Diplomats)"){echo "selected"; } ?>>GSTIN(Diplomats)</option>
															<option value="PAN" <?php if($booking->type_of_doc=="PAN"){echo "selected"; } ?>>PAN</option>
															<option value="TAN" <?php if($booking->type_of_doc=="TAN"){echo "selected"; } ?>>TAN</option>
															<option value="Passport" <?php if($booking->type_of_doc=="Passport"){echo "selected"; } ?>>Passport</option>
															<option value="Aadhaar" <?php if($booking->type_of_doc=="Aadhaar"){echo "selected"; } ?>>Aadhaar</option>
															<option value="Voter Id" <?php if($booking->type_of_doc=="Voter Id"){echo "selected"; } ?>>Voter Id</option>
															<option value="IEC" <?php if($booking->type_of_doc=="IEC"){echo "selected"; } ?>>IEC</option>
														</select>
													</div>
													<div class="col-sm-4">
														<input type="text" name="sender_gstno" readonly id="sender_gstno" value="<?php echo $booking->sender_gstno;?>" class="form-control">
													</div>
											</div>

										</div>
									</div>	
								</div>
							</div>
							<div class="card-header" style="margin-top: -25px;">                               
                                <h6 class="card-title"><span id="Consignee_div">Consignee</span> Detail</h6>                                
                            </div>
                            
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">                                           
                                                <div class="form-group row">
                                                   <label class="col-sm-2 col-form-label">Name<span class="compulsory_fields">*</span></label>
													<div class="col-sm-4">
														<input type="text" name="reciever_name" id="reciever" class="form-control" value="<?php echo $booking->reciever_name;?>" required>
													</div>
													<label   class="col-sm-2 col-form-label">Company</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" name="contactperson_name" value="<?php echo $booking->contactperson_name;?>" />
													</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Address</label>
												<div class="col-sm-4">
													<textarea name="reciever_address" id="reciever_address" class="form-control"><?php echo $booking->reciever_address;?></textarea>	
												</div>
											    <label class="col-sm-2 col-form-label">City<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="reciever_city"  id="reciever_city" value="<?php echo $booking->reciever_city; ?>" />
												</div>
											</div>
												<div class="form-group row">
												    	<label class="col-sm-2 col-form-label">Zipcode<span class="compulsory_fields">*</span></label>
        												<div class="col-sm-4">
        													<input type="text" class="form-control" name="reciever_zipcode" id="reciever_zipcode" value="<?php echo $booking->reciever_zipcode;?>"  />
        												</div>	
        												
        												<label class="col-sm-2 col-form-label">Country<span class="compulsory_fields">*</span></label>
												<div class="col-sm-4">
													<select class="form-control" id="reciever_country_id" name="reciever_country_id" class="reciever_country_id">
														<option value="">Select Country</option>
														<?php foreach ($country_list as $cl) {
															?>
															<option value="<?php echo $cl['z_id'];?>" data-id="<?php echo $cl['z_id'];?>" <?php if($booking->reciever_country_id==$cl['z_id']){echo "selected";} ?>><?php echo $cl['country_name'];?></option>

															<?php
														} ?>
													</select>
													<input type="hidden" name="reciever_zone_id" id="reciever_zone_id" value="<?php echo $booking->reciever_zone_id; ?>">
												</div>	
												</div>
												<div class="form-group row">
												    <label class="col-sm-2 col-form-label">ContactNo.</label>
    												<div class="col-sm-4">
    													<input type="text" class="form-control" name="reciever_contact" value="<?php echo $booking->reciever_contact;?>"/>
    												</div>
											         <label class="col-sm-2 col-form-label">Email Id<span class="compulsory_fields">*</span></label>
    												<div class="col-sm-4">
    													<input type="text" class="form-control" name="reciever_email" id="reciever_email" value="<?php echo $booking->reciever_email; ?>" />
    												</div>
											    </div>
										</div>
									</div>	
								</div>
							</div>

                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 mt-3">
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
														<input type="number" name="frieht" class="form-control" id="frieht" value="<?php echo $booking->frieht; ?>"/>
													</div>													
													<label class="col-sm-3 col-form-label">Transport</label>
													<div class="col-sm-3">
														<input type="number" name="transportation_charges" class="form-control" id="transportation_charges" value="<?php echo $booking->transportation_charges; ?>">
													</div>
                                                </div>
                                                <div class="form-group row">
                                                    <label   class="col-sm-3 col-form-label">Destination</label>
													<div class="col-sm-3">
														<input type="number" name="destination_charges" class="form-control" id="destination_charges" value="<?php echo $booking->destination_charges; ?>">
													</div>		
													<label class="col-sm-3 col-form-label">Clearance</label>
													<div class="col-sm-3">
														<input type="number" name="clearance_charges" class="form-control" id="clearance_charges" value="<?php echo $booking->clearance_charges; ?>">
													</div>
                                                </div>
                                                 <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">ESS</label>
													<div class="col-sm-3">
														<input type="number" name="ecs" class="form-control" id="ecs" value="<?php echo $booking->ecs; ?>">
													</div>
													<label class="col-sm-3 col-form-label">OtherCh.</label>
													<div class="col-sm-3">
														<input type="number" name="other_charges" class="form-control" id="other_charges" value="<?php echo $booking->other_charges; ?>">
													</div>					
                                                </div>                    
                                                <div class="form-group row">
                                                   <label   class="col-sm-3 col-form-label">Total</label>
													<div class="col-sm-3">
														<input type="number" readonly name="amount" class="form-control" id="amount" value="<?php echo $booking->total_amount; ?>"/>
													</div>
													<label  class="col-sm-3 col-form-label">Fuel Surcharge</label>
													<div class="col-sm-3">
														<input type="number" readonly="readonly" class="form-control" name="fuel_subcharges" id="fuel_charges"  value="<?php echo $booking->fuel_subcharges; ?>">
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
                                                <div class="form-group row" id="payby" style="display:none;">
													<label class="col-sm-3 col-form-label">Pay By</label>
													<div class="col-sm-6">
														<select class="form-control" name="payment_method" id="payment_method">
																<option value="">-Select-</option>
																<?php foreach($payment_method as $pm){ ?>
																<option value="<?php echo $pm['id'];?>" <?php if($booking->payment_method==$pm['id']){echo "selected";} ?>><?php echo $pm['method'];?></option>
																<?php } ?>
														</select>											
													</div>													
                                                </div>
												<div class="form-group row" id="Refno" style="display:none;">
													<label class="col-sm-3 col-form-label">Ref No</label>
													<div class="col-sm-6">
														<input type="text" name="ref_no" class="form-control" value="<?php echo $booking->ref_no; ?>" />											
													</div>													
                                                </div>
                                               <div class="form-group row">
                                                   
                                                    <label  class="col-sm-3 col-form-label">Sub Total</label>
			                                        <div class="col-sm-6">
														<input type="number"  name="sub_total" readonly class="form-control" id="sub_total" value="<?php echo $booking->sub_total; ?>"/>
													</div>
												</div>
												<div class="form-group row">
													 <label class="col-sm-3 col-form-label">CGST Tax</label>
				                                     <div class="col-sm-6">
				                                       <div class="input-group mb-3">
				                                           <input class="form-control" type="number" id="cgst" name="cgst"  value="<?php echo $booking->cgst; ?>" readonly>
				                                        </div>
				                                     </div>
                                                </div>
                                                <div class="form-group row">
													 <label class="col-sm-3 col-form-label">SGST Tax</label>
				                                     <div class="col-sm-6">
				                                       <div class="input-group mb-3">
				                                            <input class="form-control" type="number" id="sgst" name="sgst"  value="<?php echo $booking->sgst; ?>" readonly>
				                                        </div>
				                                     </div>
                                                </div>
												<div class="form-group row">
													 <label class="col-sm-3 col-form-label">IGST Tax</label>
				                                     <div class="col-sm-6 gst_charges">
				                                       <div class="input-group mb-3">
				                                            <input type="number" value="<?php echo $booking->igst; ?>" class="form-control" id="igst" step="any" name="igst" readonly>
				                                        </div>
				                                     </div>
                                                </div>
                                                <div class="form-group row">
                                                   <label class="col-sm-3 col-form-label">Grand Total</label>
													<div class="col-sm-6">
														<div class="input-group mb-3">
			                                        		<input type="text"  class="form-control" readonly name="grand_total"  id="grand_total" value="<?php echo $booking->grand_total; ?>"/>
														</div>
													</div>
                                                </div>
                                                 <div class="form-group row">
                                                    <div class="col-sm-6">
        	                                        	<button type="submit"  class="btn btn-primary">Submit</button> &nbsp;
        	                                        	<button type="button" onclick="return open_new_page()" class="btn btn-primary">New</button>
    	                                        	</div>
    	                                        </div>
                                              
                                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
               <div class="row">
                    <div class="col-md-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header">                               
                                <h4 class="card-title">Measurement Units</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">        
												<table class="weight-table">
													<thead>
														<tr><input type="hidden" class="form-control" name="length_unit" id="length_unit" class="custom-control-input" value="cm">
															<th>PKT</th>
															<th>Per Box Weight</th>
															<th>Actual Weight</th>
															<th>Chargeable Weight</th>
															<th class="volumetric_weight_th">Valumetric Weight</th>
				                                            <th class="length_th">L</th>
				                                            <th class="breath_th">B</th>
				                                            <th class="height_th">H</th>               
															<!-- <th>1CFT(kg)</th> -->
														</tr>
													<thead>
													<tbody>
														<?php 
															$no_pack_detail =  json_decode($weight->no_pack_detail);
															$per_box_weight_detail = json_decode($weight->per_box_weight_detail);
															$actual_weight_detail =  json_decode($weight->actual_weight_detail);
															$chargable_weight_detail =  json_decode($weight->chargable_weight_detail);
															$valumetric_weight_detail =  json_decode($weight->valumetric_weight_detail);
															$length_detail =  json_decode($weight->length_detail);
															$breath_detail =  json_decode($weight->breath_detail);
															$height_detail =  json_decode($weight->height_detail);

															for($jd=0;$jd<count($no_pack_detail);$jd++){ 
														?>
<tr>
<td><input type="text" name="no_pack_detail[]" class="form-control no_of_pack" data-attr="<?php echo ($jd+1); ?>" id="no_of_pack<?php echo ($jd+1); ?>" value="<?php echo $no_pack_detail[$jd];?>" required="required"></td>

<td><input type="text" name="per_box_weight_detail[]" class="form-control per_box_weight" data-attr="<?php echo ($jd+1); ?>" id="per_box_weight<?php echo ($jd+1); ?>" value="<?php echo $per_box_weight_detail[$jd];?>" required="required"></td>

<td><input type="text" name="actual_weight_detail[]" readonly class="form-control actual_weight"  data-attr="<?php echo ($jd+1); ?>" id="actual_weight<?php echo ($jd+1); ?>" value="<?php echo $actual_weight_detail[$jd];?>" ></td>

<td><input type="text" name="chargable_weight_detail[]" class="form-control chargable_weight" id="chargable_weight<?php echo ($jd+1); ?>" value="<?php if($chargable_weight_detail!=""){echo $chargable_weight_detail[$jd]; }?>"/></td>
<td class="volumetic_weight_td"><input type="text" name="valumetric_weight_detail[]" readonly class="form-control valumetric_weight" data-attr="<?php echo ($jd+1); ?>" id="valumetric_weight<?php echo ($jd+1); ?>" value="<?php echo $valumetric_weight_detail[$jd];?>"></td>
<td class="length_td"><input type="text" name="length_detail[]" class="form-control length" data-attr="<?php echo ($jd+1); ?>" id="length<?php echo ($jd+1); ?>" value="<?php echo $length_detail[$jd];?>" ></td>
<td class="breath_td"><input type="text" name="breath_detail[]" class="form-control breath" data-attr="<?php echo ($jd+1); ?>" id="breath<?php echo ($jd+1); ?>" value="<?php echo $breath_detail[$jd];?>" ></td>
<td class="height_td"><input type="text" name="height_detail[]" class="form-control height" data-attr="<?php echo ($jd+1); ?>" id="height<?php echo ($jd+1); ?>" value="<?php echo $height_detail[$jd];?>"></td>
<!-- <td><input type="text" name="one_cft_kg_detail[]" readonly class="form-control my-colorpicker1 one_cft_kg" data-attr="1" id="one_cft_kg1"></td> -->
</tr>
													<?php } ?>
													</tbody>
													<tfoot>
													<a href="javascript:void(0)" class="btn btn-sm btn-primary add-weight-row"><i class="icon-plus"></i></a>&nbsp;<a href="javascript:void(0)" class="btn btn-sm btn-danger remove-weight-row"><i class="icon-trash"></i></a>
													</tfoot>
												</table>
												 <table>
													<tr>
														<th><input type="text" name="no_of_pack" readonly="readonly" class="form-control no_of_pack" id="no_of_pack" required="required" value="<?php echo $weight->no_of_pack; ?>" ></th>
														<th><input type="text" name="per_box_weight" readonly="readonly" class="form-control per_box_weight" id="per_box_weight" required="required" value="<?php echo round($weight->per_box_weight,2); ?>"></th>
														<th><input type="text" name="actual_weight" readonly="readonly" class="form-control actual_weight" id="actual_weight"  value="<?php echo round($weight->actual_weight,2); ?>"></th>

														<th><input type="text" name="chargable_weight" class="form-control chargable_weight" id="chargable_weight" value="<?php echo $weight->chargable_weight; ?>"/></th>

														<th class="volumetic_weight_td"><input type="text" name="valumetric_weight" readonly="readonly" class="form-control valumetric_weight" id="valumetric_weight" value="<?php echo $weight->valumetric_weight; ?>"></th>

														<th class="length_td"><input type="text" name="length" readonly="readonly" class="form-control length"  id="length" value="<?php echo $weight->length; ?>"></th>
														<th class="breath_td"><input type="text" name="breath" readonly="readonly" class="form-control breath"  id="breath"  value="<?php echo $weight->breath; ?>"></th>
														<th class="height_td"><input type="text" name="height" readonly="readonly" class="form-control height" id="height" value="<?php echo $weight->height; ?>" ></th>
														<!-- <td><input type="text" name="one_cft_kg" readonly="readonly" class="form-control my-colorpicker1 one_cft_kg" id="one_cft_kg"></td> -->
													</tr>
												</table>
										</div>
                                    </div>
                                    <!-- <div class="row">                                           -->
                                    <!--    <div class="col-12"> -->
                                    <!--    	<div class="form-group row">-->
	                                   <!--     	<button type="submit"  class="btn btn-primary">Submit</button>-->
	                                   <!--     </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                             </div>
                         </div>
                   </div>
             </div>
            
         </div>
     </div>
 </form>
</div>
</main>
        <!-- END: Content-->
        <!-- START: Footer-->        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
	<input type="hidden" id="dispatch_details" value='<?php echo $booking->dispatch_details; ?>'>
	<input type="hidden" id="export_import_type" value='<?php echo $booking->export_import_type; ?>'>	
	
	 <script src="assets/js/international_shipment.js"></script>
</html>