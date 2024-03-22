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
                              <h4 class="card-title">Update Price master according courier company</h4>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                           <div class="col-12">
                             <form role="form" action="admin/edit-courier-fixed-charge/<?php echo $courier_charge_master->id; ?>" method="post" >
              								  <div class="box-body">								 
              									 <div class="form-group row">
              									  	<label for="ac_name" class="col-sm-3 col-form-label">Courier Company Name</label>
              									  	<div class="col-sm-3">                                        
                                         <select name="country_id" class="form-control">
                                           <option>-Select-</option>
                                           <?php foreach ($courier_company as $cc) { ?>
                                          <option value="<?php echo $cc['c_id'] ?>" <?php if($courier_charge_master->country_id==$cc['c_id']){echo "selected";} ?>><?php echo $cc['c_company_name'] ?></option>
                                          
                                           <?php } ?>
                                        </select>
                                      </div> 									
              								  </div>
                                <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Charges Type</label>
                                      <div class="col-sm-3">
                                        <select name="charge_type" class="form-control">
                                          <option>-Select-</option>
                                          <option value="min_charge" <?php if($courier_charge_master->charge_type=='min_charge'){echo "selected";} ?>>Min changes</option>
                                          <option value="per_kg" <?php if($courier_charge_master->charge_type=='per_kg'){echo "selected";} ?>>Per Kg</option>
                                        </select>
                                      </div>                  
                                  </div>	
                                   <div class="form-group row">
                                      <label for="ac_name" class="col-sm-3 col-form-label">Charge</label>
                                      <div class="col-sm-3">
                                        <input type="text" class="form-control" name="charge_amount" value="<?php echo $courier_charge_master->charge_amount; ?>" placeholder="Enter charge price" required>
                                      </div>                  
                                  </div>							  
              								  <div class="col-md-2">
              								  	<div class="box-footer">
              										<button type="submit" class="btn btn-primary">Update Price</button>
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
