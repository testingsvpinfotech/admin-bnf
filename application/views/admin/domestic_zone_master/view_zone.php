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
                              <h4 class="card-title">Domestic Zone</h4>
                              <span style="float: right;"><a href="admin/view-domestic-add-zone" class="fa fa-plus btn btn-primary">Add Zone</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">Country</th>     
                      											   <th scope="col">Zone</th>
                      											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($zone))
                            									{
                            										$cnt = 0;
                                                foreach ($zone as $value) {
                                                  $cnt++;
                                              ?>
                            									<tr>
                            										<td scope="col"><?php echo $cnt; ?></td>      
                                                <td><?php echo $value['country_name']; ?></td>  
                                                <td><?php echo $value['zone_name']; ?></td>  
                            									  <td>
                            										
                                                <a href="admin/view-domestic-edit-zone/<?php echo $value['z_id'];?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |
                            										
                                                <a href="admin/delete-domestic-zone/<?php echo $value['z_id'];?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i></a>
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
