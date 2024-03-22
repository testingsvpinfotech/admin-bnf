<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
        <main>
        <!-- START: Main Content-->
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">          
                  <div class="col-12">
                      <div class="col-12 col-sm-12 mt-3">
			
                      <div class="card">
					   <?php if(!empty($success)) { ?> 
            <div class="alert alert-success">
              <strong>Success!</strong> <?php echo is_array($success) ? implode($success, '') : $success; ?>
            </div>
            <?php  $success = ''; } ?>
            
            <?php if(!empty($error)) { ?> 
            <div class="alert alert-warning">
              <strong>Warning!</strong> <?php echo is_array($error) ? implode($error, '') : $error; ?>
            </div>
            <?php  $error = ''; } ?>
                          <div class="card-header">                               
                              <h4 class="card-title">Upload Shipment</h4><span style="float: right;"><span style="float: left;"><a href="assets/bulkupload.xlsx" class="btn btn-small btn-success">Download Sample</a></span></span>
                              
							  
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                            <div class="col-12">
                             <form role="form" id="generatePOD" action="admin/upload-shipment" method="post" >
								<div class="box-body">
								 
									<div class="form-group row">
									<h5 class="col-sm-12 card-title">Bulk Upload CSV</h5>
									<label   class="col-sm-1 col-form-label">Choose a file :</label>
										<div class="col-md-6">
											<div class="form-group">
											 <label>CSV File:</label>
											
												<span class="control-fileupload">
												  <label for="file">Choose a file :</label>
												  <input type="file" id="file" name="uploadFile" value="" required>
												</span>
												<p>&nbsp;</p>
											</div>
										</div>
										</div>
												
									<div class="form-group row">
										<div class="col-md-2">
											<div class="box-footer">
												<button type="submit"  class="btn btn-primary">Upload Shipment</button>
											</div>
										</div>
										<!-- /.box-body -->
									</div>
									
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
