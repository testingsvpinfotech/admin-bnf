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
                              <h4 class="card-title">All Airport</h4>
                              <span style="float: right;"><a href="admin/add-airport" class="fa fa-plus btn btn-primary">Add Airport</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
											  <th scope="col">Sr.</th>
											  <th scope="col">Airport Name</th>
											  <th scope="col">Airport Code</th>
											  <th scope="col">Airport City</th>
											  <th scope="col">Airport Status</th>
											  <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                    if (!empty($all_airport))
									{
										$cnt = 1;
                                      foreach ($all_airport as $value) {
                                    ?>
									<tr class="odd gradeX">
										 <td><?php echo $cnt; ?></td>
										  <td><?php echo $value->airport_name; ?></td>
										  <td><?php echo $value->airport_code; ?></td>
										  <td><?php echo $value->airport_city; ?></td>
										  <td><?php echo ($value->airport_status == 1)?'Active':'Deactive'; ?></td>
										  <td>
											<a href="admin/editairport/<?php echo $value->aa_id;?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |
											<a href="admin/deleteairport/<?php echo $value->aa_id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i></a>
										  </td>
										 </tr>
                  <?php 
				  $cnt++;
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
