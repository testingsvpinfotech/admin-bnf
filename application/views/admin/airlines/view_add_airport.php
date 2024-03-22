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
                              <h4 class="card-title">All Airport</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                                        <div class="col-12">
                             <form role="form" action="admin/insertairport" method="post" >
								  <div class="box-body">
								 
									 <div class="form-group row">
									  <label for="ac_name" class="col-sm-1 col-form-label">Airport Name:</label>
								  <div class="col-sm-2">
									  <input type="text" class="form-control" name="airport_name" placeholder="Enter Airport Name"required>
									</div>
									
								  </div>
									 <div class="form-group row">
									  <label for="ac_code"  class="col-sm-1 col-form-label">Airport Code:</label>
								   <div class="col-md-2">
									  <input type="text" class="form-control"name="airport_code" placeholder="Enter Airport Code" required>
									</div>
									
								  </div>
									 <div class="form-group row">
									  <label for="ac_prefix"  class="col-sm-1 col-form-label">Airport City:</label>
								   <div class="col-md-2">
									  <input type="text" class="form-control" name="airport_city" placeholder="Enter Airport City" required>
									</div>
									
								  </div>

								  <div class="form-group row">
									  <label for="ac_prefix"  class="col-sm-1 col-form-label">Airport Country:</label>
								   <div class="col-md-2">
									  <input type="text" class="form-control"  name="airport_country" placeholder="Enter Airport Country"  required>
									</div>
									
								  </div>
								  <div class="col-md-2">
								  <div class="box-footer">
									<button type="submit"  class="btn btn-primary">Add Airport</button>
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
