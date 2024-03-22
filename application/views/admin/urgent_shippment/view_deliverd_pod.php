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
                              <h4 class="card-title">Delivered Shipment</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Id</th>
                                               <th scope="col">Sender Name</th>
                                               <th scope="col">Receiver Name </th>
                                               <th scope="col">Receiver City</th>
                                               <th scope="col">Booking date</th>
                                              <th scope="col">Mode of Dispatch</th>
                                              <th scope="col">Delivery Date</th>
                                              <th scope="col">Status</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <?php 
          if (!empty($allpoddata)){
          foreach ($allpoddata as  $value) {
                $city_id= $value['reciever_city'];
                $city_reciever=$this->Generate_pod_model->get_city_receiver($city_id);                  
                  ?>
                  <td><?php echo $value['pod_no'];?></td>
                  <td><?php echo $value['sender_name'];?></td>
                  <td><?php echo $value['reciever_name'];?></td>
                  <td><?php echo $city_reciever->city_name;?></td>
                  <td><?php echo date('d-m-Y H:i:s',strtotime($value['booking_date'])); ?></td>
                  <td><?php echo $value['mode_dispatch'];?></td>
                  <td><?php echo date('d-m-Y H:i:s',strtotime($value['tracking_date'])); ?></td>
                  <td><?php echo $value['status']; ?></td>                 
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

