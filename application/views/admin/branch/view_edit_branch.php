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
						  <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>                        
                              <h4 class="card-title">Update Branch</h4><span style="float: right;"></span>
							  <?php }else{?>
								<h4 class="card-title">Branch Details</h4><span style="float: right;"></span>
							  <?php }?>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                            <div class="col-12">
							<?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                             <form role="form" action="admin/updatebranch/<?php echo $singlebranch->branch_id?>" method="post" >
							 <?php } ?>
								<div class="box-body">
									<div class="form-group row">
										<label   class="col-sm-1 col-form-label">Name:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="branch_name" required placeholder="Enter Name" value="<?php echo $singlebranch->branch_name;?>" />
										</div>
										<label   class="col-sm-1 col-form-label">Email: </label>
										<div class="col-sm-2">
											<input type="email" class="form-control" name="email"  placeholder="Enter Email"  value="<?php echo $singlebranch->email;?>" />
										</div>
										<label   class="col-sm-1 col-form-label">Address:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="address"  placeholder="Enter Address"  value="<?php echo $singlebranch->address;?>" />
										</div>
										<label   class="col-sm-1 col-form-label">State:</label>
										<div class="col-sm-2">
											<select class="form-control" id="state" name="state_id" onchange="return getCityList();" >
												<option value="">Select State</option>
												<?php
												foreach ($states as $row) 
												{
												?>
												<option value="<?php echo $row['id'];?>"  <?php echo ($row['id'] == $singlebranch->state)?'selected':'';?>><?php echo $row['state'];?></option>
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
												<?php 
												foreach ($cities as $rows ) { 
												?>
												<option value="<?php echo $rows['id'];?>" <?php echo ($rows['id'] == $singlebranch->city)?'selected':'';?>>
												<?php
												echo $rows['city'];?> 
												</option>
												<?php 
												}
												?>
											</select>
										</div>
										<label   class="col-sm-1 col-form-label">Pincode: </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode"  value="<?php echo $singlebranch->pincode;?>"/>
										</div>
										<label   class="col-sm-1 col-form-label">GST Number: </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="gst_number" id="gst_number" placeholder="Enter GST No" value="<?php echo $singlebranch->gst_number;?>"/>
										</div>
										<label   class="col-sm-1 col-form-label">Contact No.:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="phoneno"  placeholder="Enter Contact No"  value="<?php echo $singlebranch->phoneno;?>"/>
										</div>
										<label   class="col-sm-1 col-form-label">Contact Person:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="contact_person"  placeholder="Enter Contact Person"  value="<?php echo $singlebranch->contact_person;?>"/>
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
											<input type="text" class="form-control" id="account_name" name="account_name" value="<?php echo $singlebranch->account_name;?>" placeholder="Account Name">
										</div>
										
										<label class="col-sm-1 col-form-label">Account Number</label>
										 <div class="col-sm-2">
											<input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo $singlebranch->account_number;?>" placeholder="Account Number">
										</div>
										 <label class="col-sm-1 col-form-label">IFSC</label>
										 <div class="col-sm-2">
											 <input type="text" class="form-control" id="ifsc" name="ifsc" value="<?php echo $singlebranch->ifsc;?>" placeholder="Enter IFSC">
										</div>
										<label class="col-sm-1 col-form-label">Branch Name</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="acc_branch_name" name="acc_branch_name" placeholder="Enter Branch Name" value="<?php echo $singlebranch->acc_branch_name;?>">
										</div>
									</div>
									<div class="form-group row">
										
										
										<label class="col-sm-1 col-form-label">Account Bank Name</label>
										 <div class="col-sm-2">
											 <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name" value="<?php echo $singlebranch->bank_name;?>">
										</div>
							
										
										
										<label class="col-sm-1 col-form-label">PAN</label>
											<div class="col-sm-2">
												<input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN Id" value="<?php echo $singlebranch->pan;?>">
											</div>
												
									</div>
									
									<div class="form-group row">
                                                    
										
											<label class="col-sm-1 col-form-label">Export International Invoice Series</label>
											<div class="col-sm-2">
											<input type="text" class="form-control" id="international_invoice_series" name="international_invoice_series" value="<?php echo $singlebranch->international_invoice_series;?>" required="" placeholder="Enter Invoice Series">
											</div>
										
										
											<label class="col-sm-1 col-form-label">Import International Invoice Series</label>
											<div class="col-sm-2">
											<input type="text" class="form-control" id="import_international_invoice_series" name="import_international_invoice_series" value="<?php echo $singlebranch->import_international_invoice_series;?>" required="" placeholder="Enter Invoice Series">
											</div>
										
										
											<label class="col-sm-1 col-form-label">Domestic Invoice Series</label>
											 <div class="col-sm-2">
											   <input type="text" class="form-control" id="domestic_invoice_series" name="domestic_invoice_series" value="<?php echo $singlebranch->domestic_invoice_series;?>" required="" placeholder="Enter Invoice Series">
											</div>
										</div>
										</div>
										
										
									</div>
									<div class="form-group row">
										<div class="col-md-12">
										<?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
											<div class="box-footer">
												<button type="submit"  class="btn btn-primary">Update Branch</button>
											</div><?php }?>
										</div>

									</div>
								</div>
								<?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
							</form>
							<?php } ?>
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
