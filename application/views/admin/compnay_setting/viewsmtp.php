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
                              <h4 class="card-title">SMTP Details</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-smtp" class="fa fa-plus btn btn-primary">
         Add SMTP Details</a></span>
                          </div>
                          <div class="card-body">
                            <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                              <th scope="col">Sr.No.</th>
                                              <th scope="col">Port Number</th>
                                              <th scope="col">Host</th>
                                              <th scope="col">Username</th>
                                              <th scope="col">Password</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                    if (count($allsmtp)){
                                      $cnt=0;
                                      foreach ($allsmtp as $smtp) {
                                        $cnt++;
                                    ?>
                                    <tr class="odd gradeX">
                                      <td scope="row"><?php echo $cnt;?></td>
                                      <td><?php echo $smtp['port_no'];?></td>
                                      <td><?php echo $smtp['host'];?></td>
                                      <td><?php echo $smtp['username'];?></td>
                                      <td><?php echo $smtp['password'];?></td>
                                      <td> 
                                  <a href="<?php base_url();?>admin/edit-smtp/<?php echo $smtp['id'];?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a>
                                  |
                                  <a href="<?php base_url();?>admin/delete-smtp/<?php echo $smtp['id'];?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i>
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
        <?php $this->load->view('admin/admin_shared/admin_footer');
         //include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
