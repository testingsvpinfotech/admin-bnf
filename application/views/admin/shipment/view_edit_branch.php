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
                              <h4 class="card-title">Update Branch</h4><span style="float: right;"></span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                            <div class="col-12">
                             <form role="form" action="admin/updatebranch/<?php echo $singlebranch->branch_id?>" method="post" >
								<div class="box-body">
									<div class="form-group row">
										<label   class="col-sm-1 col-form-label">Name:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="branch_name"  placeholder="Enter Name" value="<?php echo $singlebranch->branch_name;?>" />
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
											<select class="form-control" id="state" name="state_id" >
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
										<label   class="col-sm-1 col-form-label">Contact No.:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="phoneno"  placeholder="Enter Contact No"  value="<?php echo $singlebranch->phoneno;?>"/>
										</div>
										<label   class="col-sm-1 col-form-label">Contact Person:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="contact_person"  placeholder="Enter Contact Person"  value="<?php echo $singlebranch->contact_person;?>"/>
										</div>
										</div>
										<div class="form-group row">
										<label   class="col-sm-1 col-form-label">Branch Code:</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="branch_code"  placeholder="Branch Code" value="<?=$uid?>" readonly>
										</div>
										<div class="col-md-2">
											<div class="box-footer">
												<button type="submit"  class="btn btn-primary">Update Branch</button>
											</div>
										</div>
										<!-- /.box-body -->


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
</html>
