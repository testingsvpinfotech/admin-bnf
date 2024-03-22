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
                              <h4 class="card-title">All Airlines</h4><span style="float: right;"><a href="admin/add-addairlines" class="fa fa-plus btn btn-primary">Edit Airlines</a></span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                                        <div class="col-12">
                             <form role="form" action="admin/updateairlines/<?php echo $airlines_company->a_id; ?>" method="post" >
								  <div class="box-body">
								 
									 <div class="form-group row">
									  <label for="ac_name" class="col-sm-1 col-form-label">Airlines Name:</label>
								  <div class="col-sm-2">
									  <input type="text" class="form-control" name="ac_name" value="<?php echo $airlines_company->ac_name; ?>"  placeholder="Enter Airlines Name" required>
									</div>
									
								  </div>
									 <div class="form-group row">
									  <label for="ac_code"  class="col-sm-1 col-form-label">Airlines Code:</label>
								   <div class="col-md-2">
									  <input type="text" class="form-control" name="ac_code" value="<?php echo $airlines_company->ac_code; ?>"  placeholder="Enter Airlines Code" required>
									</div>
									
								  </div>
									 <div class="form-group row">
									  <label for="ac_prefix"  class="col-sm-1 col-form-label">Airlines Prefix:</label>
								   <div class="col-md-2">
									  <input type="text" class="form-control" name="ac_prefix" value="<?php echo $airlines_company->ac_prefix; ?>"  placeholder="Enter Airlines Prefix" required>
									</div>
									
								  </div>
								  <div class="col-md-2">
								  <div class="box-footer">
									<button type="submit"  class="btn btn-primary">Update Airlines</button>
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
