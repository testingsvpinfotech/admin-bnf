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
                              <h4 class="card-title">Upload File</h4>
							  <span style="float:right;">
							  <a href="<?php echo base_url();?>assets/domestic_sample_upload.csv" class="btn btn-small btn-success">Download Sample</a>
							  </span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						  <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
						<div class="row">                                           
							<div class="col-12">
                               <form role="form" action="admin/upload-domestic-shipment" method="post" enctype="multipart/form-data">
								  <div class="box-body">                								 
									 <div class="form-group row">
									  <label for="ac_name" class="col-sm-3 col-form-label">Choose a file</label>
									  <div class="col-sm-3">
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
