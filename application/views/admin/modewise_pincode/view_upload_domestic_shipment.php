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
                              <h4 class="card-title">Upload Mode Wise Pincode File</h4>
							  <span style="float:right;">
							  <a href="<?php echo base_url();?>assets/mode_pincode.csv" class="btn btn-small btn-success">Download Sample</a>
							  </span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						  <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
						<div class="row">                                           
							<div class="col-12">
                               <form role="form" action="admin/upload-modewise-pincode" method="post" enctype="multipart/form-data">
								  <div class="box-body">                								 
									 <div class="form-group row">
                   <label  class="col-sm-1 col-form-label">Mode<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2"> 
													<select class="form-control mode_dispatch" name="mode_dispatch" id="mode_dispatch" required>
														<option value="">-Select Mode-</option>
															<?php foreach($mode as $key=>$val){ ?>
																<option value="<?= $val->transfer_mode_id; ?>"><?= $val->mode_name; ?></option>
																<?php } ?>																													
													</select>	
												</div>	
                        <label for="ac_name" class="col-sm-1 col-form-label">Date</label>
									  <div class="col-sm-2"> <?php date_default_timezone_set('Asia/Kolkata'); 
                           $date = date("Y-m-d H:i:s"); ?>
										<input type="datetime-local"  class="form-control" name="date_time" value="<?= $date; ?>" required>
									  </div>									
									  <label for="ac_name" class="col-sm-1 col-form-label">Choose a file</label>
									  <div class="col-sm-2">
										<input type="file" id="file" name="uploadFile" value="" required>
									  </div>									
									  
									</div>
									  <div class="col-md-2">
										  <div class="box-footer">
											<button type="submit" class="btn btn-primary">Submit</button>
										  </div>
									  </div>
								  <!-- /.box-body -->                								  
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