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
                              <h4 class="card-title">Company Details</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-company" class="fa fa-plus btn btn-primary">
         Add Company Details</a></span>
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
                                              <th scope="col">Company Name</th>
                                              <th scope="col">Address</th>
                                              <th scope="col">Contact No.</th>
                                              <th scope="col">Email</th>
                                              <th scope="col">Logo</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                  if (!empty ($allcompany)){
                                    $cnt=0;
                                    foreach ($allcompany as $company) {
                                      $cnt++;
                                  ?>
                                  <tr>
                                    <td scope="row"><?php echo $cnt;?></td>
                                    <td><?php echo $company['company_name'];?></td>
                                    <td><?php echo $company['address'];?></td>
                                    <td><?php echo $company['phone_no'];?></td>
                                    <td><?php echo $company['email'];?></td>
                                    <td><img src="<?php echo base_url()."assets/company/".$company['logo'];?>" width="50" height="50"></td>
                                    <td> 
        <a href="<?php base_url();?>admin/edit-company/<?php echo $company['id'];?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a>
        |
        <a href="<?php base_url();?>admin/delete-company/<?php echo $company['id'];?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--success)"></i></a>
                                      </td>
                                    </tr>
                                    <?php 
                                  }
                            }
                             else{
                            echo "<p>No Data Found</p>";
                             } ?>
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
