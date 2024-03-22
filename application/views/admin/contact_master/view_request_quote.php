     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">Requests Enquiry</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>     
                                              <th scope="col">Id</th>
                                              <th scope="col">Name</th>
                                              <th scope="col">Email</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">Service</th>
                                              <th scope="col">Message</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <?php 
                                        if (count ($allrequest)){
                                          foreach ($allrequest as $ct) {
                                        ?>
                                        <tr class="odd gradeX">
                                          <td><?php echo $ct['id'];?></td>
                                          <td><?php  echo $ct['name'];?></td>
                                          <td><?php echo $ct['email'];?></td>
                                          <td><?php echo $ct['date'];?></td>
                                          <td><?php echo $ct['service'];?></td>
                                          <td><?php echo $ct['message'];?></td>
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
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

