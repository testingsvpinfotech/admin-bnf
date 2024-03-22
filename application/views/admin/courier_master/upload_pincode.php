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
                              <h4 class="card-title">Add Pincode Service</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                      <div class="col-12">
                               <form role="form" action="Admin_courier_manager/insert_pincode" method="post" enctype="multipart/form-data">
                								  <div class="box-body">                								 
                									 <div class="form-group row">
                                      <input type="text" name="c_id" value="<?php echo $c_id;?>">
                  									  <label for="ac_name" class="col-sm-3 col-form-label">Select File</label>
                  								    <div class="col-sm-3">
                    									  <input type="file" class="form-control" name="csv_file" placeholder="Enter Company Name" required>
                    									</div>									
                								  </div>
                                  
                								<div class="col-md-2">
                    								  <div class="box-footer">
                    									<button type="submit" class="btn btn-primary">Upload</button>
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
