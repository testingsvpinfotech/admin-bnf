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
                              <h4 class="card-title">Update GST Setting</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						              <div class="row">                                           
                           <div class="col-12">
                             <form role="form" action="admin/edit-gst/<?php echo $gst_list->id; ?>" method="post" >
            								  <div class="box-body">	
                                <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Applicatible From Date</label>
                                      <div class="col-sm-3">
                                        <input type="date" class="form-control" name="from" value="<?php echo $gst_list->from; ?>" placeholder="Enter From Date" required>
                                      </div>                  
                                  </div>
                                  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Applicable To Date</label>
                                      <div class="col-sm-3">
                                        <input type="date" class="form-control" name="to" value="<?php echo $gst_list->to; ?>" placeholder="Enter To Date" required>
                                      </div>                  
                                  </div>
                                  <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">CGST %</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cgst" value="<?php echo $gst_list->cgst; ?>" placeholder="Enter CGST Per" required>
                                      </div>                  
                                  </div>
                                   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">SGST %</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="sgst" value="<?php echo $gst_list->sgst; ?>" placeholder="Enter SGST Per" required>
                                      </div>                  
                                  </div>
                                   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">IGST %</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="igst"  value="<?php echo $gst_list->igst; ?>" placeholder="Enter IGST Per" required>
                                      </div>                  
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
