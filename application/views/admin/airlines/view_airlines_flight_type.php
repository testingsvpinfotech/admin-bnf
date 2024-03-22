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
                              <h4 class="card-title">All Airlines Flight Type</h4>
                              <span style="float: right;"><a href="admin/addairlinesflighttype" class="fa fa-plus btn btn-primary">Add Airlines Flight Type</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
											  <th scope="col">Sr.</th>
											  <th scope="col">Flight Type</th>
											  <th scope="col">Flight Status</th>
											  <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                    if (!empty($airlines_company))
									{
										$cnt = 1;
                                      foreach ($airlines_company as $value) {
                                    ?>
									<tr class="odd gradeX">
										   <td><?php echo $cnt; ?></td>
										  <td><?php echo $value->type_name; ?></td>
										  <td><?php echo ($value->type_status == 1)?'Active':'Deactive'; ?></td>
										  <td>
											<a href="admin/editflighttype/<?php echo $value->aft_id;?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |
											<a href="admin/deleteflighttype/<?php echo $value->aft_id;?>" class="btn btn-danger"><i class="icon-trash"></i></a>
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
