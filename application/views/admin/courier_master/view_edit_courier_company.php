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
                              <h4 class="card-title">Update Courier Company</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                           <div class="col-12">
                             <form role="form" action="admin/edit-courier-master/<?php echo $courier_company->c_id; ?>" method="post" >
								  <div class="box-body">								 
									 <div class="form-group row">
									  	<label for="ac_name" class="col-sm-3 col-form-label">Courier Company Name</label>
									  	<div class="col-sm-3">
										  <input type="text" class="form-control" value="<?php echo $courier_company->c_company_name; ?>"  name="c_company_name" placeholder="Enter Courier Company"required>
										</div>									
								  </div>	
                  <div class="form-group row">
                      <label for="ac_name" class="col-sm-3 col-form-label">Company Type</label>
                      <div class="col-sm-3">
                      <select name="company_type" class="form-control">
                        <option value="" >-Select Company Type-</option>
                        <option value="International" <?php if($courier_company->company_type=="International"){echo "selected";} ?>>International</option>
                        <option value="Domestic" <?php if($courier_company->company_type=="Domestic"){echo "selected";} ?>>Domestic</option>
                      </select>
                    </div>                  
                  </div>  							  
								  <div class="col-md-2">
								  	<div class="box-footer">
										<button type="submit" class="btn btn-primary">Update Company</button>
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
