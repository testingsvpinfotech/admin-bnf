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
                              <h4 class="card-title">Print Labels</h4>
                             <!--  <span style="float: right;"><a href="<?php base_url();?>admin/add-homeslider" class="fa fa-plus btn btn-primary">
         Add Home Slider</a></span> -->
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                            <th scope="col">ID</th>
                                             <th scope="col">Sender Name</th>
                                             <th scope="col">Sender City</th>
                                             <th scope="col">Receiver Name </th>
                                             <th scope="col">Receiver Address</th>
                                             <th scope="col">#Pkts</th>
                                             <th scope="col">Booking date</th>
                                             <th scope="col">Mode of Dispatch</th>
                                             <th scope="col">Print</th>
                                             <!-- <th scope="col">Forwarder</th> -->
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
          
          if (!empty($allpoddata)){          
          foreach ($allpoddata as  $value) {

            $city_id2= $value['sender_city'];
                    $resAct=$this->db->query("select * from tbl_city where city_id='$city_id2'");
                    $city_sender= $resAct->row()->city_name;
					
					 $city_id3= $value['reciever_city'];
                    $resActs=$this->db->query("select * from tbl_city where city_id='$city_id3'");
                    $city_reciver= $resActs->row()->city_name;

            $print_string = $value['pod_no'] .'#|#' . $city_sender . '#|#' . $city_reciver . '#|#' . $value['mode_dispatch'] . '#|#' . $value['no_of_pack']. '#|#' . $value['reciever_address'];
          $print_string = base64_encode($print_string);
          $print_string = rtrim($print_string, '=');

                  ?>
                  <td><?php echo $value['pod_no'];?></td>
                  <td><?php echo $value['sender_name'];?></td>
                  <td><?php echo $city_sender;?></td>
                  <td><?php echo $value['reciever_name'];?></td>
                  <td><?php echo $city_reciver;?></td>
                  <td><?php echo $value['no_of_pack'];?></td>
                  <td><?php echo date('d-m-Y',strtotime($value['booking_date']));?>
                 
                  <td><?php echo $value['mode_dispatch'];?></td>

                  <td>
                    <a target="_blank" href="<?php echo base_url();?>admin/domestic_printlabel/<?php echo $print_string;?>" class="btn btn-primary"><i class="ion-printer"></i></a> 
                    
                  </td>
                <!--   <td>
                  <?php
                  $print_string1 = $value['pod_no'] .'#|#' . $city_sender . '#|#' .  $city_country . '#|#' . $value['mode_dispatch'] . '#|#' . $value['no_of_pack'] . '#|#' . $value['forwording_no'];
                    echo '<br/>';
                    $print_string1 = base64_encode($print_string1);
                    $print_string1 = rtrim($print_string1, '=');
                  ?>

                    <a target="_blank" href="<?php echo base_url();?>admin/forwarder_printlabel/<?php echo $print_string1;?>" class="btn btn-primary"><i class="ion-printer"></i></a> 
                  </td> -->
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

