<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
					  
                          <div class="card-header">                               
                              <h4 class="card-title">Add Branch</h4><span style="float: right;"></span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                            <div class="col-12">
                             <form role="form" action="admin/insertbranch" method="post" >
								<div class="box-body">
									<div class="form-group row">
										<label   class="col-sm-1 col-form-label">Name:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="branch_name" required placeholder="Enter Name" />
										</div>
										<label   class="col-sm-1 col-form-label">Email: </label>
										<div class="col-sm-2">
											<input type="email" class="form-control" name="email"  placeholder="Enter Email" />
										</div>
										<label   class="col-sm-1 col-form-label">Address:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="address"  placeholder="Enter Address" />
										</div>
										<label   class="col-sm-1 col-form-label">State:</label>
										<div class="col-sm-2">
											<select class="form-control" id="state" name="state_id" onchange="return getCityList();">
												<option value="">Select State</option>
												<?php
												foreach ($states as $row) 
												{
												?>
												<option value="<?php echo $row['id'];?>"><?php echo $row['state'];?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label   class="col-sm-1 col-form-label">City Name:</label>
										<div class="col-sm-2">
											<select class="form-control" id="city" name="city_id">
												<option value="">Select City</option>												
											</select>
										</div>
										<label   class="col-sm-1 col-form-label">Pincode: </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode" />
										</div>
										<label   class="col-sm-1 col-form-label">GST Number: </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="gst_number" id="gst_number" placeholder="Enter GST No" />
										</div>
										<label   class="col-sm-1 col-form-label">Contact No.:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="phoneno"  placeholder="Enter Contact No" />
										</div>
										<label   class="col-sm-1 col-form-label">Contact Person:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="contact_person"  placeholder="Enter Contact Person" />
										</div>
										<label   class="col-sm-1 col-form-label">Branch Code:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="branch_code"  placeholder="Branch Code" value="<?=$uid?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										
										<!-- <label   class="col-sm-1 col-form-label">Branch GST No.:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="branch_code"  placeholder="Branch GST No." >
										</div> -->
										<label class="col-sm-1 col-form-label">Account Name</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="account_name" name="account_name" value="" placeholder="Account Name">
										</div>
										
										<label class="col-sm-1 col-form-label">Account Number</label>
										 <div class="col-sm-2">
											<input type="text" class="form-control" id="account_number" name="account_number" value="" placeholder="Account Number">
										</div>
										 <label class="col-sm-1 col-form-label">IFSC</label>
										 <div class="col-sm-2">
											 <input type="text" class="form-control" id="ifsc" name="ifsc" value="" placeholder="Enter IFSC">
										</div>
										<label class="col-sm-1 col-form-label">Branch Name</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="acc_branch_name" name="acc_branch_name" placeholder="Enter Branch Name" value="">
										</div>
									</div>
									<div class="form-group row">
										
										
										<label class="col-sm-1 col-form-label">Account Bank Name</label>
										 <div class="col-sm-2">
											 <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name" value="">
										</div>
											
										<label class="col-sm-1 col-form-label">PAN</label>
											<div class="col-sm-2">
												<input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN Id" value="">
											</div>
												
									</div>
									<div class="form-group row">
                                                    
									
										<label class="col-sm-1 col-form-label">Export International Invoice Series</label>
										<div class="col-sm-2">
										<input type="text" class="form-control" id="international_invoice_series" name="international_invoice_series" value="" required="" placeholder="Enter Invoice Series">
										</div>
									
										<label class="col-sm-1 col-form-label">Import International Invoice Series</label>
										<div class="col-sm-2">
										<input type="text" class="form-control" id="import_international_invoice_series" name="import_international_invoice_series" value="" required="" placeholder="Enter Invoice Series">
										</div>
									
										<label class="col-sm-1 col-form-label">Domestic Invoice Series</label>
										 <div class="col-sm-2">
										   <input type="text" class="form-control" id="domestic_invoice_series" name="domestic_invoice_series" value="" required="" placeholder="Enter Invoice Series">
										</div>
									
										
									</div>
									
									
								</div>
									<div class="form-group row">
										<div class="col-md-12">
											<div class="box-footer">
												<button type="submit"  class="btn btn-primary">Add Branch</button>
											</div>
										</div>
									</div>
								</div>
							</form>
                        </div> 
                        </div> 
                        </div> 
                        </div> 

                    </div>
                    </div>
                </div>
                <!-- END: Listing-->
            </div>
        </main>
        <!-- END: Content-->
        <!-- START: Footer-->
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
<script type="text/javascript">
  //======================
   function getCityList()
        {
            var state = $('#state').val();           
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>Admin_ratemaster/getCityList',
                data: 'state=' + state,
                dataType: "json",
                success: function(data) {
                    var option = '';
                    $.each(data, function(i, city) {                       
                        option += '<option value="'+city.id+'">'+city.city+'</option>';
                    });
                    $('#city').html(option);
                    
                }
            });  
        }
        
</script>
