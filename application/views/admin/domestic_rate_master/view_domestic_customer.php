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
                              <h4 class="card-title">Domestic Rate</h4>
                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">Customer Name</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($customer_list))
                            									{
                            										$cnt = 0;
                                                foreach ($customer_list as $value) {
                                                  $cnt++;
                                              ?>
                            									<tr>
                              										<td scope="col"><?php echo $cnt; ?></td>
                                                  <td><a href="admin/view-domestic-rate/<?php echo $value['customer_id']; ?>" ><?php echo $value['customer_name']; ?></a></td> 
                              									  <!-- <td>                            										
                                                      <a href="admin/view-domestic-rate/<?php echo $value['customer_id']; ?>" class="fa fa-plus btn btn-primary">Add Domestic Rate</a>
                              									  </td> -->
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
