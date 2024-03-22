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
                              <h4 class="card-title">All Signed Quatation</h4>
                              <span style="float: right;"><a href="admin/view-add-signed-quatation/<?php echo $customer_id; ?>/<?php echo $c_courier_id; ?>/<?php echo $applicable_from; ?>" class="fa fa-plus btn btn-primary">Add Signed Quatation</a></span>
                          </div>
                          <div class="card-body">
                             <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                                <th scope="col">Sr.</th>
                                                <th scope="col">Contact Person</th>
                                                <th scope="col">Contact No</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Document</th>
                      							<th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                            $cnt = 1;
                                            foreach ($signed_quatation as  $value) {
                                                    
                                                  ?>
                                                  <td><?php echo $cnt; ?></td>
                                                 <td><?php echo $value->contact_person; ?></td>
                                                  <td><?php echo $value->contact_no; ?></td>
                                                  <td><?php echo $value->email; ?></td>
                                                  <td><?php echo $value->date; ?></td>
                                                  <td><a href="assets/signed_qutation/<?php echo $value->attechment; ?>"><?php echo $value->attechment; ?></td>
                                                
                                                  <td>
                                                    <a href="<?php echo base_url();?>admin/edit-signed-quotation/<?php echo $value->sq_id;?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                                                    <a href="<?php echo base_url();?>admin/delete-signed-quotation/<?php echo $value->sq_id;?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                  </td>
                                                 </tr>
                                                  <?php 
                                          $cnt++;
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
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
