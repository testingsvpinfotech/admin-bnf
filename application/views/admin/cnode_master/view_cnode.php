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
                              <h4 class="card-title">View Cnode</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-cnode" class="fa fa-plus btn btn-primary">
         Assign Cnode</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Branch Code</th>
                                             <th scope="col">Airway No. Range </th>
                                             <th scope="col">Date.</th>
                                             <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                  <?php 
          if (!empty ($allcnode))
          {

          foreach ($allcnode as  $value) {
                  ?>  
          <td><?php echo $value['id'];?></td>
                  <td><?php echo $value['branch_code'];?> (<?php echo $value['branch_name'];?>)</td>
                  <td><?php echo $value['airway_no_from'];?>-<?php echo $value['airway_no_to'];?></td>
                  <td><?php echo $value['date'];?></td>
                  <td>
                    <!--<a href="<?php // echo base_url();?>cnode/updatecnode/<?php //echo $value['id']?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> | -->

                    <a href="<?php echo base_url();?>admin/delete-cnode/<?php echo $value['id']?>" class="btn btn-danger"><i class="icon-trash"></i></a>
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

