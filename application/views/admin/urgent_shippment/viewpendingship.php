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
                              <h4 class="card-title">Shipment Details</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-pod" class="fa fa-plus btn btn-primary">
         Add Shipment</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                              <th scope="col">ID</th>
                                               <th scope="col">Sender Name</th>
                                               <th scope="col">Receiver Name </th>
                                               <th scope="col">Receiver City</th>
                                               <th scope="col">Booking date</th>
                                               <th scope="col">Branch</th>
                                               <th scope="col">Mode of Dispatch</th>
                                               <th scope="col" style="width: 17%;">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                   <tr>                     
           <?php 
          if (!empty($allpoddata)){
          foreach ($allpoddata as  $value) {
              $city_id= $value['reciever_city'];
                     $resAct=$this->db->query("select * from tbl_city where city_id='$city_id'");
                    $city_reciever= $resAct->row()->city_name;
                    $brid=$value['branch_id'];
                    $branchid=$this->db->query("select * from tbl_branch where branch_id='$brid'");
                    $branchids= $branchid->row()->branch_name;
                  ?><!--<td><?php// echo $cd['car_id'];?></td>-->
                  <td><?php echo $value['pod_no'];?></td>
                  <td><?php echo $value['sender_name'];?></td>
                  <td><?php echo $value['reciever_name'];?></td>
                  <td><?php echo $city_reciever;?></td>
                  <td><?php echo date('d-m-Y H:i:s',strtotime($value['booking_date']));?>
                 
                  <td><?php echo $branchids;?>
                  </td>
                  <td><?php echo $value['mode_dispatch'];?></td>
          <td>
          <a href="<?php echo base_url();?>generatepod/allpod/<?php echo $value['booking_id'];?>" class="btn btn-warning"><i class="fas fa-search-plus"></i></a> |

          <a href="<?php echo base_url();?>admin/edit-pod/<?php echo $value['booking_id'];?>" class="btn btn-primary" ><i class="icon-pencil"></i></a>
                    <?php if( $this->session->userdata("userType") == 1) : ?> |

          <a href="<?php echo base_url();?>admin/delete-pod<?php echo $value['booking_id'];?>" class="btn btn-danger"><i class="icon-trash"></i></a>
                    <?php endif; ?>
         


        
           <!--  <a href="<?php base_url();?>Admin_company_manager/updatecompany/<?php echo $company['id'];?>" class="btn btn-primary"><i class="icon-pencil"></i></a>
        |
        <a href="<?php base_url();?>Admin_company_manager/deletecompany/<?php echo $company['id'];?>" class="btn btn-danger"><i class="icon-trash"></i></a> -->
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
