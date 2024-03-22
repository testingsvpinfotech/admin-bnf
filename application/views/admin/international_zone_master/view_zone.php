<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  #example_filter{display: none;}
  .input-group{
    width: 60%!important;
  }
</style>
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
                              
                             <!--  <span style="float: right;"><a href="admin/view-add-zone" class="fa btn btn-primary">Upload Zone</a></span> -->
                          </div>
                          <div class="card-body">
                            <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                 
                                     <table id="example" class="display table dataTable table-striped table-bordered" data-sorting="true" data-filtering="true"  >
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">Courier Name</th>
                                               <th scope="col">Country</th>     
                      											   <th scope="col">Zone</th>
                                               <th scope="col">Type</th>
                      											   <!-- <th scope="col">Action</th> -->
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
                                                <td><?php echo $value->c_company_name; ?></td> 
                                                <td><?php echo $value->country_name; ?></td>  
                                                <td><?php echo $value->zone_name; ?></td> 
                                                <td><?php echo $value->zone_type; ?></td>   
                            									  <!-- <td>
                                                <a href="admin/view-edit-zone/<?php echo $value->z_id;?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |
                            										
                                                <a href="admin/delete-zone/<?php echo $value->z_id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i></a>
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
