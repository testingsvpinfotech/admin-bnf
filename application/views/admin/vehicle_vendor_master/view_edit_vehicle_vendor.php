 <?php echo $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
 <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
    	 <!-- END: Main Menu-->
   

        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">
                 <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">                               
                                <h4 class="card-title">Edit Vehicle Vendor </h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                         
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/edit-vehicle-vendor/<?= $value['id']; ?>" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Full Name</label>
                                                        <input type="text" name="name" class="form-control" value="<?= $value['name']; ?>">
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Mobile No</label>
                                                        <input type="text" name="mobile_no" class="form-control" value="<?= $value['mobile_no']; ?>">
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Email</label>
                                                        <input type="email" name="email"   class="form-control" value="<?= $value['email']; ?>">
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Registered office Address</label>
                                                        <textarea name="r_address" class="form-control" placeholder="Address"><?= $value['r_address']; ?></textarea>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Current Business</label>
                                                        <input type="text" name="current_business"   class="form-control" value="<?= $value['current_business']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">City</label>
                                                        <input type="text" name="city"   class="form-control" value="<?= $value['city']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">State</label>
                                                        <input type="text" name="state"   class="form-control" value="<?= $value['state']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Country</label>
                                                         <select class="form-control"  name="country_id" id="country_id">
														<option value="">Select Country</option>
														<?php
															if (count($country)) {
																foreach ($country as $rows) {
																	?>
														<option value="<?php echo $rows['country_id']; ?>">
															<?php echo $rows['country_name']; ?>
														</option>
														<?php
															}
															} else {
															echo "<p>No Data Found</p>";
															}
															?>
													</select>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Pincode</label>
                                                        <input type="text" name="pin_code"   class="form-control" value="<?= $value['pin_code']; ?>">
                                                    </div>
                                                    
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Service Provider</label>
                                                         <select class="form-control"  name="service_provider" id="service_provider">
														<option value="">Select Service Provider</option>
														<option value="Fleet Owner"<?php if($value['service_provider']=='Fleet Owner'){?> Selected <?php } ?> >Fleet Owner</option>
														<option value="Broker" <?php if($value['service_provider']=='Broker'){?> Selected <?php } ?>>Broker</option>
														<option value="Attacch Vehicle" <?php if($value['service_provider']=='Attacch Vehicle'){?> Selected <?php } ?>>Attacch Vehicle</option>
														<option value="other" <?php if($value['service_provider']=='other'){?> Selected <?php } ?>>Other</option>
									
													</select>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Credit Days</label>
                                                        <input type="text" name="credit_days"   class="form-control" value="<?= $value['credit_days']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Ability to invest</label>
                                                         <select class="form-control"  name="invest" id="invest">
														<option value="">Select Ability to invest</option>
														<option value="yes" <?php if($value['invest']=='yes'){?> Selected <?php } ?>>Yes</option>
														<option value="no" <?php if($value['invest']=='no'){?> Selected <?php } ?>>No</option>
													</select>
                                                    </div>
                                                    
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Document No</label>
                                                        <input type="text" name="document_no" placeholder="Pan No"  class="form-control" value="<?= $value['document_no']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Upload Document</label>
                                                        <input type="file" name="document_file"   class="form-control" >
                                                    </div>
                                                      <div class="col-3 mb-3">
                                                        <label for="username">Statutory documents</label>
                                                         <select class="form-control"  name="statutory" id="statutory">
														<option value="">Select Statutory documents</option>
														<option value="Insurance" <?php if($value['statutory']=='Insurance'){?> Selected <?php } ?>>Insurance</option>
														<option value="RC Book" <?php if($value['statutory']=='RC Book'){?> Selected <?php } ?>>RC Book</option>
														<option value="PUC" <?php if($value['statutory']=='PUC'){?> Selected <?php } ?>>PUC</option>
													</select>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">VTS</label>
                                                         <select class="form-control"  name="vts" id="vts">
														<option value="">Select VTS</option>
															<option value="yes" <?php if($value['vts']=='yes'){?> Selected <?php } ?>>Yes</option>
														<option value="no" <?php if($value['vts']=='no'){?> Selected <?php } ?>>No</option>
													</select>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Type of Vehicle</label>
                                                         <select class="form-control"  name="type_vehicle" id="vts">
														<option value="">Select Type of Vehicle</option>
														<?php
															if (count($vehicle)) {
																foreach ($vehicle as $rows) {
																	?>
														<option value="<?php echo $rows['id']; ?>" <?php if($value['type_vehicle']== $rows['id']){?> Selected <?php } ?>>
															<?php echo $rows['vehicle_name']; ?>
														</option>
														<?php
															}
															} else {
															echo "<p>No Data Found</p>";
															}
															?>
													</select>
                                                    </div>
                                                    <div class="col-3 mb-3">
													<label for="username">Bank Name</label>
                                                        <input type="text" name="bank_name"   class="form-control" value="<?= $value['bank_name']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
													<label for="username">Account No</label>
                                                        <input type="text" name="account_no"   class="form-control" value="<?= $value['account_no']; ?>">
                                                    </div>
                                                    <div class="col-3 mb-3">
													<label for="username">IFSC Code</label>
                                                        <input type="text" name="ifsc_code"   class="form-control" value="<?= $value['ifsc_code']; ?>">
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                    <div class="description">
                                                            <!--<div class="row">-->
                                                            <!--  <div class="col-3 mb-3">-->
                                                            <!--    <div class="form-group"><label for="exampleInputUsername1"> Add Branch :</label><input type="text" class="form-control des1 search" data-row="1" name="branch[]"   placeholder="Add Branch" id="search1"></div>-->
                                                            <!--  </div>-->
                                                            <!-- <div class="col-3 mb-4"><br> <samp class="btn btn-info" id="add"> Add</samp></div>-->
                                                            <!--</div>-->
                                                        </div>
                                                    </div>
                                                    <?php if($value['document_file']){ ?>
                                                    <h6>Uploaded Document : </h6>&nbsp;&nbsp;&nbsp;
                                                    <img src="<?= base_url('assets/vehicle_vendor_upload/'.$value['document_file']); ?>" alt="<?=$value['document_file']; ?>" width="200px" height="auto">
                                                    <?php } ?>
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
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
    


        <?php $this->load->view('admin/admin_shared/admin_footer'); ?>
       
    <script>
  $(function() {
    $('#add').click(function() {
      indexx = $('.description .row:last').index();
      indexx = indexx + 2;
      var d = '<div class="row"><div class="col-md-3"><div class="form-group"><label for="exampleInputUsername1" >Branch :</label><input type="text" class="form-control des1 search" name="branch[]" data-row="'+indexx+'" placeholder="Item" id="search'+indexx+'"></div></div>';
      $('.description').append(d);
      box11 = 0;
      index = $('.description .row:last').index();
      if (index >= 1) {
        $('.description .row:last input').removeAttr('placeholder');
      }
    });
    

  });
  
</script>
	
    </body>
</html>
