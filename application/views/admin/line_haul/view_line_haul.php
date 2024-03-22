     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
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
                              <h4 class="card-title">Line Haul Master</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-line-haul" class="btn btn-primary">
         Add Line Haul</a></span>
                          </div>
                          <div class="card-body">
                             <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered" data-filtering="true" data-paging="true" >
                                      <thead>
                                          <tr>
                                              <th scope="col">Id</th>
                                              <th scope="col">Route</th>                                             
                                              <th scope="col">State</th>                                             
                                              <th scope="col">City</th>                                             
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                  if (!empty ($allroutedata)){
                                    $cnt=0;
                                    foreach ($allroutedata as $rgn) {
                                      $cnt++;
                                  ?>
                                  <tr>
                                    <td><?php echo $cnt;?></td>
                                    <td><?php echo $rgn['route_name'];?></td>
									<?php
									
										
										$route_id = $rgn['route_id'];
										$data['rgn_detail']=$this->basic_operation_m->get_query_result("select * from tbl_line_hual_master_details left join city on city.id=tbl_line_hual_master_details.city LEFT JOIN state ON state.id=tbl_line_hual_master_details.state where routeid='$route_id'");
?>

											<td><?php
										foreach ($data['rgn_detail'] as $key => $value) 
										{ 
											echo $value->state;
											
											echo '<br>';
										}
										?></td>
										<?php 	

										?>
											
											<td><?php
										foreach ($data['rgn_detail'] as $key => $value) 
										{
											echo $value->city;
											echo '<br>';
										}
										?></td>
<?php 
									?>
                                    <td> 
        <a href="<?php base_url();?>admin/edit-line-haul/<?php echo $rgn['route_id'];?>" title="Edit"><i class="ion-edit" style="color:var(--primarycolor)"></i></a>
        |
        <a href="<?php base_url();?>admin/delete-line-haul/<?php echo $rgn['route_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
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
