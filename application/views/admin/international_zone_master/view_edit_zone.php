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
                              <h4 class="card-title">Update Zone</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                           <div class="col-12">
                             <form role="form" action="admin/edit-zone/<?php echo $zone->z_id; ?>" method="post" >
            								  <div class="box-body">	
                               <div class="form-group row">
                                  <label for="ac_name" class="col-sm-3 col-form-label">Courier Name</label>
                                  <div class="col-sm-3">
                                  <select class="form-control" name="c_courier_id">
                                      <option value="">-Select Courier Name-</option>
                                       <?php foreach ($courier_company as $cc) {
                                        ?>
                                        <option value="<?php echo $cc['c_id'];?>" <?php if($zone->c_courier_id==$cc['c_id']){echo "selected";} ?>  ><?php echo $cc['c_company_name'];?> 
                                        </option>
                                      <?php } ?>                                       
                                    </select>
                                </div>                  
                              </div>  
                               <div class="form-group row">
                                  <label for="ac_name" class="col-sm-3 col-form-label">Country Name</label>
                                  <div class="col-sm-3"> 
                                     <select class="form-control" name="country_name">
                                       <option value="">-Select Country Name-</option>
                                       <?php foreach ($country_list as $cl) {
                                        ?>
                                        <option value="<?php echo $cl['country_name'];?>" <?php if($zone->country_name==$cl['country_name']){echo "selected";} ?>  ><?php echo $cl['country_name'];?> 
                                        </option>
                                      <?php } ?>
                                       
                                    </select>
                                  </div>  
                                </div>  							 
            									 <div class="form-group row">
            									  	<label for="ac_name" class="col-sm-3 col-form-label">Zone Name</label>
            									  	<div class="col-sm-3">
            										  <input type="text" class="form-control" value="<?php echo $zone->zone_name; ?>"  name="zone_name" placeholder="Enter Zone"required>
            										</div>									
            								  </div>	
                               <div class="form-group row">
                                  <label for="ac_name" class="col-sm-3 col-form-label">Zone Type</label>
                                  <div class="col-sm-3"> 
                                     <select class="form-control" name="zone_type">
                                       <option value="">-Select Type-</option>
                                        <option value="Export" <?php if($zone->zone_type=="Export"){echo "selected";} ?>  >Export</option>
                                        <option value="Import" <?php if($zone->zone_type=="Import"){echo "selected";} ?>  >Import</option>
                                      
                                    </select>
                                  </div>  
                                </div>  	
            								  <div class="col-md-2">
            								  	<div class="box-footer">
            										<button type="submit" class="btn btn-primary">Update Zone</button>
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
