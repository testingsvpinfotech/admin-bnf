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
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-cnodemaster" class="fa fa-plus btn btn-primary">
         Add Cnode</a></span>
                          </div>
                 <div class="card-body">
                    <div class="table-responsive">
                        <table class="table layout-primary bordered">
                            <thead>
                                <tr>                                           
                                  <th scope="col">Cnode Sr.</th>
                                  <th scope="col">Airway Range From</th>
                                  <th scope="col">Airway Range To</th>
                                  <th scope="col">Total Airway Docket</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                    <?php 
                                        if (count ($allcnode)){
                                        foreach ($allcnode as  $value) {
                                                ?>  
                                        
                                                <td><?php echo $value['cnode_id'];?></td>
                                                <td><?php echo $value['airway_no'];?></td>
                                                <td><?php echo $value['airway_to'];?></td>
                                                <td><?php echo $value['airway_to']-$value['airway_no'];?></td>
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

