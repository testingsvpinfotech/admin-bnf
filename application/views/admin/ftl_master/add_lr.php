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
            <form role="form"  action="admin/add-lr-data" method="post">
                <div class="row">
                    <div class="col-md-4 col-sm-12 mt-3">
                        <!-- Shipment Info -->
                        <div class="card">
                            <div class="card-header" style="background-color: #1e3d5d; color: #fff;">
                                <h4 class="card-title">LR Info</h4>
                                
                                 <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                 <?php } ?>
                            <!--    <span style="float: right;"><a href="admin/view-domestic-shipment" class="btn btn-primary">View Domestic Shipment</a></span>-->
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
                                            $datec  = str_replace(" ", "T", $datec);
                                            if ($this->session->userdata('booking_date') != '') { ?>

                                                <input type="datetime-local" name="booking_date" value="<?php echo $this->session->userdata('booking_date'); ?>" id="booking_date" class="form-control">
                                            <?php
                                            } else { ?>
                                                <input type="datetime-local" name="booking_date" value="<?php echo $datec; ?>" id="booking_date" class="form-control">
                                            <?php } ?>
                                        </div>
                                    </div>
                               
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">LR No<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lr_number" class="form-control" value="<?php //echo $bid; ?>" required>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Order Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="order_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Lorry Number</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lorry_number" class="form-control">
                                        </div>
                                    </div>
                                 
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label ">Type Of Vehicle</label>
                                        <div class="col-sm-8">
                                           
                                           <select class="form-control" name="type_of_vehicle" required="">
                                             <option value= "">Select Vehicle Type</option>
                                             <?php if(!empty($vehicle_type)){ ?>
                                               <?php foreach($vehicle_type as $value) : ?>
                                                 
                                                  <option value="<?= $value->id ; ?> "><?php echo $value->vehicle_name ; ?></option>
                                                <?php endforeach ;?>
                                            <?php }?>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Bill Type<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="dispatch_details" id="dispatch_details">
                                                <option value="">-Select-</option>
                                                <option value="Credit">Credit</option>
                                                <option value="Cash">Cash</option>
                                                <option value="COD">COD</option>
                                                <option value="ToPay">ToPay</option>
                                            </select>
                                        </div>
                                     </div>
                                      <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Invoice Value<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="invoice_value">
                                        </div>
                                     </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Invoice Number<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="invoice_number">
                                        </div>
                                   </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Origin<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="lr_sender_address">
                                        </div>
                                   </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Destination<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="lr_receiver_address">
                                        </div>
                                   </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">GST Payable<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8 mt-2">
                                            <input type="checkbox"  value="1" name="gst_pay">Consigner
                                            <input type="checkbox"  value="2" name="gst_pay">Consignee
                                            <input type="checkbox" value="3" name="gst_pay">Company
                                            <input type="checkbox" value="4" name="gst_pay">RCM
                                        </div>
                                   </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Insurance<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8 mt-2">
                                            <input type="radio" id ="insurance_form"  name="insurance_details" value="1">Yes
                                            <input type="radio" id="noInsurance"      name="insurance_details"  value="0" >No
                                        </div>
                                   </div>
                                   
                                    <div class="form-group row" id="myModal" style="display:none;">
                                        <div class="col-sm-3">
                                             <label class="form-label">In. No</label>
                                            <input type="number" name="insurance_number" class="form-control" placeholder="Enter Insurance Number ">
                                        </div>
                                         <div class="col-sm-3">
                                             <label class="form-label">In. Company</label>
                                        <?php if(!empty($insurance_company)){?>     
                                            <select class="form-control" name="insurance_company_name">
                                                <option>Select Insurance Company</option>
                                                <?php foreach($insurance_company as $value):?>
                                                <option value="<?= $value->insurance_comapany_name;?>"><?= $value->insurance_comapany_name;?> </option>
                                                <?php endforeach ;?>
                                            </select>
                                        <?php }?>    
                                        </div>
                                        <div class="col-sm-3">
                                             <label class="form-label">In. Amount</label>
                                            <input type="number" name="insurance_charges" class="form-control" placeholder="Enter Insurance Charges">
                                        </div>
                                         <div class="col-sm-3">
                                             <label class="form-label">In.date</label>
                                            <input type="date" name="insurance_date" class="form-control">
                                        </div>
                                    </div> 
                                    
                            </div>
                        </div>
                        <!-- Shipment Info -->
                     </div>
                </div>
                    
                    
                    
                    
                    
                    <div class="col-md-4 col-sm-12 mt-3">
                        <!-- Consigner Detail -->
                        <div class="card">
                            <div class="card-header"style="background-color: #1e3d5d; color: #fff;">
                                <h4 class="card-title">Consigner Detail</h4>
                            </div>
                            <div class="card-content">
                              	<div class="card-body">
											<div class="form-group row">
												<label  class="col-sm-4 col-form-label">Customer</label>
												<div class="col-sm-8" id="credit_div">
												   
													<select class="form-control"  name="customer_account_id" id="customer_account_id">
														<option value="">Select Customer</option>
														<?php 
															if (count($customers)) {
																foreach ($customers as $rows) {	?>
													             	<option value="<?php echo $rows['customer_id']; ?>">	<?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> </option>
													        	<?php } 
															} ?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label" id="credit_div_label">Name<span class="compulsory_fields">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="sender_name"  id="sender_name" class="form-control my-colorpicker1">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Address</label>
												<div class="col-sm-8">
													<textarea name="sender_address"  id="sender_address" class="form-control"></textarea>		
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="sender_pincode"  id="sender_pincode" class="form-control">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">State<span class="compulsory_fields">*</span></label>
												<div class="col-sm-8">
													<select class="form-control" id="sender_state" name="sender_state">
														<option value="">Select State</option>													
														<?php 
															if(count($states)) {
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
												<input type="text" name="sender_contactno"  id="sender_contactno" class="form-control my-colorpicker1">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">GST Number.</label>
												<div class="col-sm-8">
													<input type="text" name="sender_gstno"  id="sender_gstno" class="form-control my-colorpicker1">
												</div>
											</div>
										</div>
                            </div>
                        </div>
                        <!--*************** Consigner Detail **********************************-->
                    </div>
                    
                    
                    
                    
                    <div class="col-md-4 col-sm-12 mt-3">
                        <!-- Consignee Detail -->
                        <div class="card">
                            <div class="card-header" style="background-color: #1e3d5d; color: #fff;">
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
                                            <select class="form-control" id="reciever_state" name="reciever_state">
                                                <option value="">Select State</option>
                                                <?php
                                                if (count($states)) {
                                                    foreach ($states as $s) { ?>
                                                        <option value="<?php echo $s['id']; ?>"><?php echo $s['state']; ?></option>
                                                    <?php  }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">City<span class="compulsory_fields">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="reciever_city" name="reciever_city">
                                                <option value="">Select City</option>
                                                <?php
                                                if (count($cities)) {
                                                    foreach ($cities as $c) { ?>
                                                        <option value="<?php echo $c['id']; ?>">
                                                            <?php echo $c['city']; ?>
                                                        </option>
                                                <?php         }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">ContactNo.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="reciever_contact" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">GST NO.</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="receiver_gstno"  class="form-control">
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
                            <div class="card-header"  style="background-color: #1e3d5d; color: #fff;">
                                <h4 class="card-title">Measurement Units</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                     <label>Product Name</label>
                                                     <input type="text" name="product_name" class="form-control"  required="required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Product Weight</label>
                                                    <input type="text" name="product_weight" class="form-control" required="required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>quantity</label>
                                                    <input type="text" name="product_qty" class="form-control" required="required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>declare Weight</label>
                                                    <input type="text" name="declare_weight" class="form-control" required="required">
                                                </div>
												<div class="col-sm-2">
												    <label>Chargeable Wt.</label>
													<input type="text" name="chargable_weight" class="form-control my-colorpicker1 chargable_weight"  data-attr="1" id="chargable_weight" required="required">
												</div>
                                                <div class="col-sm-2">
                                                 <label>Unit</label>
                                                 <?php if(!empty($product_unit_name)){?>
                                                  <select class="form-control" name="product_unit">
                                                      <option>Select Unit</option>
                                                      <?php foreach( $product_unit_name as $value ):?>
                                                         <option><?= $value->unit_name;?></option>
                                                      <?php endforeach ;?>
                                                  </select>
                                                <?php }?>  
                                                </div>
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
                            <div class="card-header"  style="background-color:  #1e3d5d; color: #fff;">
                                <h4 class="card-title">Charges</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Freight</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="frieht_charge" class="form-control" value="" id="frieht_charge" />
                                                </div>
                                                <label class="col-sm-3 col-form-label">A.O.C.</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="aso_charge" class="form-control" value="0" id="aso_charge">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Labour</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="labour_charge" class="form-control" value="0" id="labour_charge">
                                                </div>
                                                <label class="col-sm-3 col-form-label">St. Charge</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="st_charge" class="form-control" value="0" id="st_charge">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">L.C.</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="lc_charge" class="form-control" id="lc_charge">
                                                </div>
                                                <label class="col-sm-3 col-form-label">Misc.</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="misc_charge" class="form-control" value="0" id="misc_charge">
                                                </div>
                                            </div>
                                         

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Ch.Post.</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="ch_post_charge" class="form-control" value="0" id="ch_post_charge">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Total Charge</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="total_charge" class="form-control"  id="total_charge" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">GST Charge</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="gst_charge" class="form-control"  id="gst_charge">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Grand Total</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="grand_total" class="form-control text-white"  id="grand_total" readonly>
                                                </div>
                                            </div>
                                         
                                             <div class="form-group row mt-3">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">Submit</button> &nbsp;
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
        </div>
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    
    
    <!--Insurance Form-->
    
    <!-- The Modal -->
<div class="modal" >
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Insurance Form</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action =""method="POSt">
            <div class="form-group row">
              
                <div class="col-sm-12">
                     <label class="form-label">Insurance Name</label>
                    <input type="text" name="insurance_charges" class="form-control" placeholder="Enter Insurance Name ">
                </div>
                 <div class="col-sm-12">
                     <label class="form-label">Insurance Company Name</label>
                    <select class="form-control">
                        <option>Select Insurance Company</option>
                        <option>Demo</option>
                    </select>
                </div>
                <div class="col-sm-12">
                     <label class="form-label">Insurance charges</label>
                    <input type="number" name="insurance_charges" class="form-control" placeholder="Enter Insurance Charges">
                </div>
                 <div class="col-sm-12">
                     <label class="form-label">Date</label>
                    <input type="date" name="insurance_charges" class="form-control">
                </div>
            </div>  
        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>


    <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

<script src="assets/js/domestic_shipment.js"></script>
<script>
    $(document).ready(function(){
    $('#insurance_form').click(function()
    {
      $('#myModal').show();
    });
    $('#noInsurance').click(function()
    {
      $('#myModal').hide();
    });
    
    
     $('#frieht_charge, #aso_charge,#labour_charge,#st_charge,#lc_charge,#misc_charge,#ch_post_charge').keyup(function(){
               var value1 = parseFloat($('#frieht_charge').val()) || 0;
               var value2 = parseFloat($('#aso_charge').val()) || 0;
               var value3 = parseFloat($('#labour_charge').val()) || 0;
               var value4 = parseFloat($('#st_charge').val()) || 0;
               var value5 = parseFloat($('#lc_charge').val()) || 0;
               var value6 = parseFloat($('#misc_charge').val()) || 0;
               var value7 = parseFloat($('#ch_post_charge').val()) || 0;
               $('#total_charge').val(value1 + value2 + value3 + value4 + value5 + value6 + value7);
            });
            
            
             $("input[type=checkbox]").change(function() {
                var getGstPay = $(this).val();
                if( getGstPay == 1 || getGstPay == 2 || getGstPay == 4 ){
                   
                 
                    $('#gst_charge').keyup(function(){
                        
                      var  total =  parseFloat($('#total_charge').val())||0;
                      
                     var   gst_charge =  parseFloat($('#gst_charge').val())||0;
                     var   gstamount = total* gst_charge / 100;
                    
                     $('#grand_total').val( total+gstamount);
                  
                   //  alert(grandtotal);
                    });     
                }
            });
    
});
</script>
</html>