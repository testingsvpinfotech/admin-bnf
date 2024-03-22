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
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">    
                              <h4 class="card-title">Price master according courier compnay</h4>
                              <span style="float: right;"><a href="admin/view_add_courier_fixed_price/<?php echo $edit_country_id; ?>" class="fa fa-plus btn btn-primary">Add Price</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">Sr.</th>
                    											   <th scope="col">Company Name</th>
                                             <th scope="col">Charges Type</th>  
                                             <th scope="col">Charge Amount</th>  											  
                    											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($charge_master))
                            									{
                            										$cnt = 0;
                                                foreach ($charge_master as $value) {
                                                  $cnt++;
                                              ?>
                            									<tr class="odd gradeX">
                            										<td><?php echo $cnt; ?></td>
                            									  <td><?php echo $value->c_company_name; ?></td>	
                                                <td><?php echo $value->charge_type; ?></td>  
                                                <td><?php echo $value->charge_amount; ?></td>  
                            									  <td>
                            										
                                                <a href="admin/view-edit-courier-fixed-price/<?php echo $value->id;?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |
                            										
                                                <a href="admin/delete-courier-fixed-charge/<?php echo $value->id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i></a>
                            									  </td>
                            									  </tr>
                                              <?php 
                                            }
                                         }
                                         else{
                                        echo "<p>No Data Found</p>";
                                         }
                                      ?>
                                </tbody>
                                  </table> 
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
