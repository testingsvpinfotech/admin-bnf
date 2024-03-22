<?php include('admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
       
        <!-- END: Main Menu-->
		<?php include('admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">FTL Request List</h4>
                          </div>

						   <div class="card-header justify-content-between align-items-center">                             
							  <span>
									
							  </span>
                          </div>
                          <div class="card-body">
                          	<?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                              <table class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true"><!-- id="example"-->
                                      <thead>
                                          <tr>
                                                <th>Sr. No.</th>
											    <th  scope="col">Customer Name</th>
											    <th  scope="col">Customer ID</th>
											    <th  scope="col">Contact Person</th>
											    <th  scope="col">Pincode</th>
											    <th  scope="col">Address</th>											   
                                          </tr>
                                      </thead>
                                      <tbody>
                                
                                      <?php  if (!empty($customer_data)){
										$cnt = 1;
										foreach ($customer_data as $value) :?>
											<tr>
                                                <td><?php echo  $cnt++ ;?></td>
												<td><?php echo $value['customer_name'];?></td>
												<td><?php echo $value['customer_id'];?></td>
												<td><?php echo $value['contact_person']; ?></td>
												<td><?php echo $value['pincode'];?></td>
												<td><?php echo $value['address'];?></td>
											 </tr>
                                        <?php endforeach; ?>     
                                       <?php } else { ?>  
                                        <tr><td colspan="10"style="color:red;">No Data Found</td></tr>    
                                        <?php }?>
									
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
        <?php include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>

