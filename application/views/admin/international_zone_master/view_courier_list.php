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
                              <h4 class="card-title">International Zone</h4>
                          </div>
                          <div class="card-body">                            
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">Courier Name</th>
                                               <th scope="col">Type</th>
                      											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($courier_company))
                            									{
                            										$cnt = 0;
                                                foreach ($courier_company as $value) {
                                                  $cnt++;

                                                 $whr = array("c_courier_id"=>$value['c_id']);
                                                 $zone_type =$this->Zone_model->get_international_zone_row("zone_master",$whr);   

                                              ?>
                            									<tr>
                            										<td scope="col"><?php echo $cnt; ?></td>
                                                <td><?php echo $value['c_company_name']; ?></td> 
                                                <td><?php if($zone_type){echo $zone_type->zone_type; } ?></td>   
                            									  <td>
                            										
                                                <a href="admin/view-international-zone/<?php echo $value['c_id'];?>" class="btn btn-primary"><i class="icon-plus"></i></a>
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
