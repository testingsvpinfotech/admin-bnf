     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
     <!-- END Head-->

     <!-- START: Body-->

     <body id="main-container" class="default">

       <!-- END: Main Menu-->
       <?php $this->load->view('admin/admin_shared/admin_sidebar');
        // include('admin_shared/admin_sidebar.php'); 
        ?>
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
                     <h4 class="card-title">Internal Tracking</h4>
                   </div>
                   <div class="card-body">
                     <div class="row"> 
                       <div class="col-12">
                         <form role="form" action="<?php echo base_url(); ?>admin/view-internal-status" method="post" autocomplete="off">
                           <div class="form-row">
                             <div class="col-md-2">
                               <input type="text" class="form-control" value="<?php echo $filter_value; ?>" name="filter_value" />
                             </div>
                             <!-- <div class="col-md-2" style="display: none;">
                               <select class="form-control" name="filter">

                                 <option value="pod_no">Pod No</option>

                               </select>
                             </div> -->
                             <!--  <div class="col-md-2">
                          <select class="form-control" name="user_id" id="user_id">
                          <option value="" >Selecte Customer</option><?php //if(!empty($customers_list)){foreach($customers_list as $key => $values){ 
                                                                      ?><option value="<?php //echo $values['customer_id']; 
                                                                                                                                                                        ?>" ><?php // echo $values['customer_name']; 
                                                                                                                                                                                                                  ?></option><?php // } } 
                                                                                                                                                                                                                                                                    ?></select>
                        </div>  --->




                             <div class="col-sm-2">
                               <input type="submit" class="btn btn-primary" name="submit" value="Filter">
                               <a href="admin/view-domestic-shipment" class="btn btn-info">Reset</a>
                             </div>
                           </div>
                         </form>
                       </div>
                     </div>
                   </div>
                   <div class="card-body">
                     <div class="row">
                       <div class="col-12">
                         <!--<form role="form" action="<?php echo base_url(); ?>admin/list-booking" method="post" autocomplete="off">-->

                         <?php
                          $date = date('Y-m-d H:i');
                          $date = str_replace(' ', 'T', $date);
                          ?>
                         <div class="form-row">
                           <div class="row" id="div_transfer_rate" style="display:none;">


                           </div>
                         </div>
                         <!--//==============-->
                         <div class="card-body">
                           <div class="row">
                             <div class="col-12">
							  <div class="table-responsive">
							             
                                <?php $last_bag_info = $this->basic_operation_m->get_query_row("SELECT *,tbl_domestic_bag.user_id as user_id_bag FROM tbl_domestic_bag join tbl_domestic_deliverysheet On tbl_domestic_deliverysheet.pod_no = tbl_domestic_bag.pod_no left join tbl_domestic_menifiest on tbl_domestic_menifiest.bag_no = tbl_domestic_bag.bag_id WHERE tbl_domestic_bag.pod_no ='" . $filter_value. "' order by tbl_domestic_bag.id desc limit 1"); 
                                if(!empty($last_bag_info))
                                {
                                ?>
                                 <h3>Last Mile Details</h3>
                                </br><br>
                                <div class="table-responsive">
                                <table id="example1" class="table table-responsive table table-bordered ">
                                   <thead>
                                     <tr>
                                       <th> Bag No</th>
                                       <th> Bag Genrated By</th>
                                       <th> Bag Branch Name </th>
                                       <th> Bag Date & Time </th>
                                       <th> Menifest No </th>
                                       <th> Manifested By </th>
                                       <th> Menifested Branch </th>
                                       <th> Menifest Date & Time </th>
                                       <th> DRS No </th>
                                       <th> DRS Deliveryboy Name </th>
                                       <th> DRS Date & Time </th>
                                     </tr>
                                   </thead>
                                   <tbody>
                                    <tr>
                                      <td><?php echo $last_bag_info->bag_id; ?></td>
                                      <td><?php 
                              
                                      if($last_bag_info->user_id_bag =='0')
                                      {
                                       echo  $last_bag_info->source_branch;
                                      }
                                      else
                                      {
                                      $user = $this->db->query("select username from tbl_users where user_id = '$last_bag_info->user_id_bag'")->row();
                                      echo $user->username; } ?></td>
                                      <td><?php echo $last_bag_info->source_branch; ?></td>
                                      <td><?php echo $last_bag_info->date_added; ?></td>
                                      <td><?php echo $last_bag_info->manifiest_id; ?></td>
                                      <td><?php echo $last_bag_info->username; ?></td>
                                      <td><?php echo $last_bag_info->source_branch; ?></td>
                                      <td><?php echo $last_bag_info->date_added; ?></td>
                                      <td><?php echo $last_bag_info->deliverysheet_id; ?></td>
                                      <td><?php echo $last_bag_info->deliveryboy_name; ?></td>
                                      <td><?php echo $last_bag_info->delivery_date; ?></td>
                                    </tr>
                                   </tbody>
                                </table>
                                </div>


                                <?php } ?>
                                <br>
                               </div>
                               <h3>Shipments Details</h3>
							                 <br><br>
                               <div class="table-responsive">
                                 <table id="example1" class="table table-responsive table table-bordered">
                                   <thead>
                                     <tr>

                                       <th>AWB</th>
                                       <th>PRQ NO</th>
                                       <th>AWB date</th>
                                       <th>Type</th>
                                       <th>EWay No</th>
                                       <th>Invoice No.</th>
                                       <th>Invoice Value</th>
                                       <th>Bill Type</th>
                                       <th>Sender Name</th>
                                       <th>Receiver Name</th>
                                       <th>Receiver Address</th>
                                       <th>Destination</th>
                                       <th>Destination Service</th>
                                       <th>Customer Code</th>
                                       <th>Customer Name</th>
                                       <th>Booking Branch</th>
                                       <th>Mode</th>
                                       <th>TDate</th>
                                       <th>Status</th>
                                       <th>Comment</th>
                                       <th>Person</th>
                                       <!--<th>Remark</th>-->
                                     </tr>
                                   </thead>
                                   <tbody>
                                     
                                     <?php
                                    // print_r($domestic_booking);die;                                    
                                      if (!empty($domestic_booking)) {
                                        foreach ($domestic_booking as $value_d) {
                                          $customer_info        = $this->basic_operation_m->get_table_row('tbl_customers', array('customer_id' => $value_d['customer_id']));
                                          if (@$customer_info->access_status == 0) {
                                            $tracking_info = $this->basic_operation_m->get_query_row("SELECT * FROM tbl_domestic_deliverysheet WHERE pod_no ='" . $value_d['pod_no'] . "'");

                                      ?>
                                           <tr>

                                             <td><?php echo $value_d['pod_no']; ?></td> 
                                             <td><?php echo $value_d['prq_no']; ?></td> 
                                             <td><?php echo date('d/m/Y', strtotime($value_d['booking_date'])); ?></td>
                                             <!-- <td><input type="hidden" name="company_type[]"  value="<?php echo $value_d['company_type']; ?>"></td> -->
                                             <td><?php echo $value_d['company_type']; ?></td>
                                             <td><?php echo $value_d['eway_no']; ?></td>

                                             <td><?php echo $value_d['invoice_no']; ?></td>
                                             <td><?php echo $value_d['invoice_value']; ?></td>
                                             <td><?php echo $value_d['dispatch_details']; ?></td>



                                             <td><?php echo $value_d['sender_name']; ?></td>
                                             <td><?php echo $value_d['reciever_name']; ?></td>
                                             <td><?php echo $value_d['reciever_address']; ?></td>

                                             <td><?php echo $value_d['reciever_city']; ?></td>
                                             <td><?php 
                                             $rpincode = $value_d['reciever_pincode'];
                                             $pincode = $this->db->query("select * from pincode where pin_code = '$rpincode'")->row();
                                             if(!empty($pincode->isODA) && $pincode->isODA !=0){ echo service_type[$pincode->isODA];} ?></td>

                                             <td><?php 
                                             $customer_id = $value_d['customer_id'];
                                             $customer_inf = $this->db->query("select * from tbl_customers where customer_id = '$customer_id'")->row_array();
                                             echo $value_d['cid'];
                                              ?></td>
                                             <td><?php echo $value_d['customer_name']; ?></td>
                                             <td><?php $branch_id = $value_d['branch_name'];
                                             if(empty($branch_id)){
                                              $pod_no = $value_d['pod_no'];
                                              $tracking_inf = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$pod_no' order by id asc limit 1")->row();
                                              echo $tracking_inf->branch_name;
                                             }else{
                                                 echo $branch_id;
                                             }
                                            //  $branch_inf = $this->db->query("select * from tbl_branch where branch_id = '$branch_id'")->row();
                                            //  echo $branch_inf->branch_name; ?></td>
                                             <td><?php 
                                              $rpincode = $value_d['mode_dispatch'];
                                              $pincode = $this->db->query("select * from transfer_mode where transfer_mode_id = '$rpincode'")->row();
                                              echo $pincode->mode_name;
                                             ?></td>
                                             <td><?php echo date("d-m-Y", strtotime($value_d['tracking_date'])); ?></td>
                                             <td><?php echo $value_d['status']; ?></td>
                                             <td><?php echo $value_d['comment']; ?></td>
                                             <td><?php echo (isset($tracking_info->deliveryboy_name)) ? $tracking_info->deliveryboy_name : ''; ?></td>
                                             <!--<td><?php //echo $value_d['remarks']; 
                                                      ?></td>-->
                                           </tr>
                                       <?php
                                          }
                                        }
                                      } else {
                                        ?>
                                       <tr>
                                         <?php //echo str_repeat("<td></td>",12);
                                          ?>
                                       </tr>
                                     <?php
                                      }
                                      ?>
                                   </tbody>

                                 </table>
                               </div>
                               <?php 
                               ini_set('display_errors', '0');
                               ini_set('display_startup_errors', '0');
                               error_reporting(E_ALL);
                               $awb =  $value_d['prq_no'];
                               $pod =  $value_d['pod_no'];
                               $user_id =  $value_d['user_id'];
                              //  echo '<pre>';print_r($value_d);
                               $pod_d = $this->db->query("select * from tbl_domestic_booking where pod_no = '$pod'")->row();
                               $username = $this->db->query("select * from tbl_users where user_id = '$pod_d->user_id'")->row();
                              //  echo $this->db->last_query();die;
                               if(! empty($awb)){
                                $prq_val = $this->db->query("select * from tbl_pickup_request_data where pickup_request_id = '$awb'")->result();
                               
                               ?>
                               <br>
                               <div class="table-responsive">
                                <h3>PRQ Shipments Details</h3>
                                 <table id="example1" class="table table-responsive table table-bordered">
                                   <thead>
                                     <tr>
                                       <th>AWB NO</th>
                                       <th>PRQ NO</th>
                                       <th>Pickup Genarte Date</th>
                                       <th>Pickup Requested Date</th>
                                       <th>Pickup Requested Close Date</th>
                                       <th>Pickup Close By</th>
                                   
                                     </tr>
                                   </thead>
                                   <tbody>
                                    <?php if(! empty($prq_val)){
                                        foreach($prq_val as $key=> $val){
                                    ?>
                                     <tr>
                                      <td><?=  $pod;?></td>
                                      <td><?= $val->pickup_request_id;?></td>
                                      <td><?= $val->create_date;?></td>
                                      <td><?= $val->pickup_date;?></td>
                                      <td><?=  date('d/m/Y', strtotime($value_d['booking_date']));?></td>
                                      <td><?= $username->username;?></td>

                                     </tr>
                                    
                                      
                                   <?php  } }?>
                                   </tbody>

                                 </table>
                               </div>
                                 <?php } ?>

                               <div class="table-responsive">
                                 <br><br>
                                 <h3>Weight Details</h3>
                                 <table class="table table table-bordered">
                                 <thead>
                                   <tr>
                                     <th>Sr. No.</th>
                                     <th>NOP</th>
                                     <th>Actual Weight</th>
                                     <th>Chargable Weight</th>
                                     <th>Box</th>
                                     <th>Length</th>
                                     <th>Width</th>
                                     <th>Height</th>
                                     <th>A.W</th>
                                     <th>V.W</th>
                                   </tr>
                                 </thead>
                                   <?php if (!empty($weight_details)) { ?>
                                     <?php $i = 1;
                                      foreach ($weight_details as $value) : ?>

                                       <tr>
                                         <td><?= $i++; ?></td>
                                         <td><?= $value['no_of_pack']; ?></td>
                                         <td><?= $value['actual_weight']; ?></td>


                                         <td><?= $value['chargable_weight']; ?></td>

                                         <?php $weight_info    = $this->db->query("select * from tbl_domestic_weight_details where booking_id=" . $value['booking_id']);
                                          $weightt_info     = $weight_info->row();
                                          $weight_d = json_decode($weightt_info->weight_details, true);
                                          //print_r($weight_d);
                                          ?>

                                         <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][0]; ?></td>
                                         <td style="width: 34px"><?php echo @$weight_d['length_detail'][0]; ?></td>
                                         <td style="width: 34px"><?php echo @$weight_d['breath_detail'][0]; ?></td>
                                         <td style="width: 34px"><?php echo @$weight_d['height_detail'][0]; ?></td>
                                         <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][0]; ?></td>
                                         <td style="width: 34px"><?php echo @$weight_d['valumetric_weight_detail'][0]; ?></td>

                                       </tr>
                                     <?php endforeach; ?>
                                     <?php $weight_info    = $this->db->query("select * from tbl_domestic_weight_details where booking_id=" . $value['booking_id']);
                                      $weightt_info     = $weight_info->row();
                                      $weight_d = json_decode($weightt_info->weight_details, true);
                                      //print_r($weight_d);
                                      ?>
                                     <tr>
                                       <td colspan="4"></td>
                                       <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][1]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['length_detail'][1]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['breath_detail'][1]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['height_detail'][1]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][1]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_weight_detail'][1]; ?></td>
                                     </tr>

                                     <?php $weight_info    = $this->db->query("select * from tbl_domestic_weight_details where booking_id=" . $value['booking_id']);
                                      $weightt_info     = $weight_info->row();
                                      $weight_d = json_decode($weightt_info->weight_details, true);
                                      //print_r($weight_d);
                                      ?>
                                     <tr>
                                       <td colspan="4"></td>
                                       <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][2]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['length_detail'][2]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['breath_detail'][2]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['height_detail'][2]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][2]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_weight_detail'][2]; ?></td>
                                     </tr>

                                     <?php $weight_info    = $this->db->query("select * from tbl_domestic_weight_details where booking_id=" . $value['booking_id']);
                                      $weightt_info     = $weight_info->row();
                                      $weight_d = json_decode($weightt_info->weight_details, true);
                                      //print_r($weight_d);
                                      ?>
                                     <tr>
                                       <td colspan="4"></td>
                                       <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][3]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['length_detail'][3]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['breath_detail'][3]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['height_detail'][3]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][3]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_weight_detail'][3]; ?></td>
                                     </tr>

                                     <?php $weight_info    = $this->db->query("select * from tbl_domestic_weight_details where booking_id=" . $value['booking_id']);
                                      $weightt_info     = $weight_info->row();
                                      $weight_d = json_decode($weightt_info->weight_details, true);
                                      //print_r($weight_d);
                                      ?>
                                     <tr>
                                       <td colspan="4"></td>
                                       <td style="width: 34px"><?php echo @$weight_d['per_box_weight_detail'][4]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['length_detail'][4]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['breath_detail'][4]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['height_detail'][4]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_actual_detail'][4]; ?></td>
                                       <td style="width: 34px"><?php echo @$weight_d['valumetric_weight_detail'][4]; ?></td>
                                     </tr>

                                   <?php } else { ?>
                                     <tr>
                                       <td>No Record Found</td>
                                     </tr>
                                   <?php } ?>
                                 </table>
                               </div>

                               <div class="table-responsive ">
                                 <br>
                                 <br>
                                 <h3>Tracking Details</h3>
                                 <table class="table table table-bordered">
                                 <thead>
                                   <tr>
                                     <th>#</th>
                                     <th>Date</th>
                                     <th>Location</th>
                                     <th>Forworder</th>
                                     <th>comment</th>
                                     <th>Remarks</th>
                                     <th>Status</th>
                                   </tr>
                                 </thead>
                                   <?php
                                    if (!empty($history)) {

                                      foreach ($history as $key => $value) {

                                        $pod_no = $value['pod_no'];
                                        $booking_id = $value['booking_id'];
                                        $drs = $this->db->query("select * from tbl_domestic_deliverysheet where pod_no = '$pod_no'")->row();
                                        if(!empty($drs)){
                                          $drsno = $drs->deliverysheet_id;
                                        }else{
                                          $drsno = '';
                                        }
                                        echo "<tr>";
                                        echo "  <td>" . ($key + 1) . "</td>";
                                        echo "  <td>" . date('d-m-Y', strtotime($value['tracking_date'])) .'  '.date('h:i A', strtotime($value['tracking_date'])). "</td>";
                                        if($value['status'] == 'In transit'){
                                          echo "  <td>" . $value['added_branch'] . "</td>";
                                         }else{
                                        echo "  <td>" . $value['branch_name'] . "</td>";
                                         }
                                        echo "  <td>" . $value['forworder_name'] . "</td>";
                                        echo "  <td>" . $value['comment'] . "</td>";
                                        echo "  <td>" . $value['remarks'] . "</td>";
                                        if($value['status'] == 'In transit'){
                                          echo "  <td>".$value['status'].' To '.$value['branch_name']."<b>  Master Manifest No : ".$value['shipment_info']."</b></td>";
                                         }elseif($value['status'] == 'Manifest genrated'){
                                          echo "  <td>".$value['status']."<b>  Manifest No : ".$value['shipment_info']."</b></td>";
                                         }elseif($value['status'] == 'Bag genrated'){
                                          echo "  <td>".$value['status']."<b>  Bag No : ".$value['shipment_info']."</b></td>";
                                        }elseif($value['status'] == 'Out For Delivery'){
                                          echo "  <td>" . $value['status'] . "<b>  DRS No : ".$value['shipment_info']."</b></td>";
                                        }elseif($value['status'] == 'Booked'){
                                            echo "  <td>" . $value['status'].
                                            "<a href='".base_url()."admin/domestic_printpod/".$booking_id."' target='_blank' title='Print'> <i class='fas fa-print ml-2' style='color:var(--success)'></i></a>";
                                            "</td>";
                                        }else{
                                          echo "  <td>" . $value['status']."</td>";
                                        } ?>
            
                                        <!-- <td></td> -->
                                        <?php
                                       
                                        echo "</tr>";
                                      }
                                    } else {
                                      echo "<tr><td colspan='7'>No result Found!</td></tr>";
                                    }

                                    ?>
                                 </table>

                               </div>
                               </form>
                             </div>
                             </form>
                           </div>
                         </div>


                         <div class="table-responsive ">
                           <br>
                           <br>
                           <h3>Tracking Manifest Details</h3>
                           <table class="table  table table-bordered">
                           <thead>
                             <tr>
                               <th>#</th>
                               <th>Date</th>
                               <th>Menifested By</th>
                               <th>Superviser</th>
                               <!-- <td>Receiver By</td> -->
                               <th>Received Date</th>
                               <th>Manifest No.</th>
                               <th>From</th>
                               <th>To</th>
                               <th>Lorry No</th>
                               <th>Driver Name</th>
                               <th>Driver Contact No</th>
                               <th>Coloader</th>
                               <th>Forwarder Name</th>
                               <th>Received</th>
                             </tr>
                           </thead>
                             <?php
                              if (!empty($menifest)) {

                                foreach ($menifest as $key => $value) {

                                  // echo "<pre>";
                                  // print_r($value);
                                  // echo "</pre>";
                                  if ($value['reciving_status'] == '1') {
                                    $value['reciving_status'] = 'Yes';
                                  } else {
                                    $value['reciving_status'] = 'No';
                                  }
                                  echo "<tr>";
                                  echo "  <td>" . ($key + 1) . "</td>";

                                  echo "  <td>" . date('Y-m-d', strtotime($value['date_added'])) . "</td>";
                                  echo "  <td>" . $value['username'] . "</td>";
                                  echo "  <td>" . $value['supervisor'] . "</td>";
                                  // echo "  <td>".$value['username']."</td>";
                                  echo "  <td>" . $value['date_added'] . "</td>";
                                  echo "  <td>" . $value['manifiest_id'] . "</td>";
                                  echo "  <td>" . $value['source_branch'] . "</td>";
                                  echo "  <td>" . $value['destination_branch'] . "</td>";
                                  echo "  <td>" . $value['lorry_no'] . "</td>";
                                  echo "  <td>" . $value['driver_name'] . "</td>";
                                  echo "  <td>" . $value['contact_no'] . "</td>";
                                  echo "  <td>" . $value['coloader'] . "</td>";
                                  echo "  <td>" . $value['coloder_contact'] . "</td>";
                                  echo "  <td>" . $value['reciving_status'] . "</td>";
                                  echo "</tr>";
                                }
                              } else {
                                echo "<tr><td colspan='11'>No result Found!</td></tr>";
                              }

                              ?>
                           </table>

                         </div>

                         
                         <?php    if (!empty($menifest)) { ?>

                         <div class="table-responsive">
                           <br>
                           <br>
                           <h3>CD NO Details</h3>
                           <table class="table table table-bordered">
                           <thead>
                             <tr>
                               <th>#</th>
                               <th>CD No</th>
                               <th>CD Outscan Date & Time</th>
                               <th>CD Outscan By</th>
                               <th>CD Inscan Date & Time</th>
                               <th>CD Inscan By</th>
                             </tr>
                           </thead>
                             <?php
                            
                                foreach ($menifest as $key => $value) {

                                  // echo "<pre>";
                                  // print_r($value);
                                  // echo "</pre>";
                                  if ($value['reciving_status'] == '1') {
                                    $value['reciving_status'] = 'Yes';
                                  } else {
                                    $value['reciving_status'] = 'No';
                                  }
                                  echo "<tr>";
                                  echo "  <td>" . ($key + 1) . "</td>";

                                  echo "  <td>" . $value['cd_no'] . "</td>";
                                  echo "  <td>" . $value['cd_no_edited_date'] . "</td>";
                                  echo "  <td>" . $value['cd_no_edited_by'] . "</td>";
                                  echo "  <td>" . $value['cd_recived_date'] . "</td>";
                                  echo "  <td>" . $value['cd_recived_by'] . "</td>";
                                }
                             

                              ?>
                           </table>

                         </div>

                         <?php 
                         }
                           if (!empty($_POST['filter_value'])) {

                            $pod_no = $_POST['filter_value'];
                            $pod = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->result_array();
                            if(! empty($pod)){
                            ?>
                         <div class="table-responsive">
                           <br>
                           <br>
                           <h3>POD Uploaded Details</h3>
                           <table class="table">
                             <tr>
                               <td>#</td>
                               <td>Date & Time</td>
                               <td>Delivery Boy</td>
                               <td>Action</td>
                             </tr>

                             <?php
                             $pod_no = $_POST['filter_value'];
                             $pod = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->result_array();
                              if (!empty($pod)) {

                               
                                foreach ($pod as $key => $value) {

                                 $img = $value['image'];
                                  echo "<tr>";
                                  echo "  <td>" . ($key + 1) . "</td>";

                                  echo "  <td>" . date('d/m/Y H:i:s', strtotime($value['booking_date'])) . "</td>";
                                  echo "  <td>" . $value['deliveryboy_id'] . "</td>";
                                  $ext = explode('.',$img);
                                  if($ext[1] =='pdf'){
                                  echo "<td> <a href='".base_url('assets/pod/'.$img)."' target='_blank'><i class='fa fa-link' aria-hidden='true'> View Pod</i></a></td>";
                                  }else{
                                    echo "<td> <a href='assets/pod/".$img."' src='assets/pod/.".$img."'onclick='show_image(this);return false;'>View Pod Image</a></td>";
                                  }
                                  echo "</tr>";
                                }
                              } else {
                                echo "<tr><td colspan='4'>No result Found!</td></tr>";
                              }

                              ?>
                           </table>
                           <!-- <a href="assets/pod/<?php echo $row->image; ?>" src="assets/pod/<?php echo $row->image; ?>" title="<?php echo $row->pod_no; ?>" onclick="show_image(this);return false;">View Pod Image</a> -->
                         </div>
                         <?php } }?>
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
        //include('admin_shared/admin_footer.php'); 
        ?>
       <!-- START: Footer-->
     </body>
     <!-- END: Body-->
     <script type="text/javascript">
       $('.datepicker').datepicker({
         format: 'dd/mm/yyyy'
       });
       $(".check_all").click(function() {
         if ($(this).prop('checked')) {
           $(".row_check").prop('checked', true);
           show_div();
         } else {
           $(".row_check").prop('checked', false);
           hide_transfer_div();
         }
       });
       $(".row_check").click(function() {

         show_div();

       });


       function show_div() {
         // $("#transfer_customer_id").val(customer_id);

         $("#div_transfer_rate").show();
         return false;
       }

       function hide_transfer_div() {
         $("#div_transfer_rate").hide();
         return false;
       }
     </script>
      <div id="myModal" class="modal">
         <span class="close-image-modal">&times;</span>
         <img class="modal-content" id="img01">
         <div id="caption"></div>
       </div>
       <style type="text/css">
         /* The Modal (background) */
         .modal {
           display: none;
           /* Hidden by default */
           position: fixed;
           /* Stay in place */
           z-index: 1;
           /* Sit on top */
           padding-top: 100px;
           /* Location of the box */
           left: 0;
           top: 0;
           width: 100%;
           /* Full width */
           height: 100%;
           /* Full height */
           overflow: auto;
           /* Enable scroll if needed */
           background-color: rgb(0, 0, 0);
           /* Fallback color */
           background-color: rgba(0, 0, 0, 0.9);
           /* Black w/ opacity */
         }

         /* Modal Content (image) */
         .modal-content {
           margin: auto;
           display: block;
           width: 50%;
           max-width: 700px;
         }

         /* Caption of Modal Image */
         #caption {
           margin: auto;
           display: block;
           width: 80%;
           max-width: 700px;
           text-align: center;
           color: #ccc;
           padding: 10px 0;
           height: 150px;
         }

         /* Add Animation */
         .modal-content,
         #caption {
           -webkit-animation-name: zoom;
           -webkit-animation-duration: 0.6s;
           animation-name: zoom;
           animation-duration: 0.6s;
         }

         @-webkit-keyframes zoom {
           from {
             -webkit-transform: scale(0)
           }

           to {
             -webkit-transform: scale(1)
           }
         }

         @keyframes zoom {
           from {
             transform: scale(0)
           }

           to {
             transform: scale(1)
           }
         }

         /* The Close Button */
         .close-image-modal {
           position: absolute;
           /*top: 15px;*/
           right: 35px;
           color: #f1f1f1;
           font-size: 40px;
           font-weight: bold;
           transition: 0.3s;
         }

         .close-image-modal:hover,
         .close-image-modal:focus {
           color: #bbb;
           text-decoration: none;
           cursor: pointer;
         }

         /* 100% Image Width on Smaller Screens */
         @media only screen and (max-width: 700px) {
           .modal-content {
             width: 100%;
           }
         }
       </style>
     </body>

     <script>
       // Get the modal
       var modal = document.getElementById("myModal");

       function show_image(obj) {
         var captionText = document.getElementById("caption");
         var modalImg = document.getElementById("img01");
         modal.style.display = "block";
         // alert(obj.tagName);
         if (obj.tagName == 'A') {
           modalImg.src = obj.href;
           captionText.innerHTML = obj.title;
         }
         if (obj.tagName == 'img') {
           modalImg.src = obj.src;
           captionText.innerHTML = obj.alt;
         }

         // modalImg.src = 'http://www.safedart.in/assets/pod/pod_1.jpg';

       }
       var span = document.getElementsByClassName("close-image-modal")[0];

       // When the user clicks on <span> (x), close the modal
       span.onclick = function() {
         modal.style.display = "none";
       }


       // Get the image and insert it inside the modal - use its "alt" text as a caption




       // Get the <span> element that closes the modal
     </script>
     <script>
      function getPod123(getid) {
        // alert(id);
        var baseurl = '<?php echo base_url(); ?>'
			swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
			}).then((result) => {
				if (result.value) {
					$.ajax({
							url: baseurl + 'Admin_pod/pod_delete',
							type: 'POST',
							data: 'getid=' + getid,
							dataType: 'json'
						})
						.done(function(response) {
							swal('Deleted!', response.message, response.status)

								.then(function() {
									location.reload();
								})

						})
						.fail(function() {
							swal('Oops...', 'Something went wrong with ajax !', 'error');
						});
				}
      });
    }
	// $(document).ready(function() {
	// 	$('.deletepod').click(function() {
	// 		var getid = $(this).attr("relid");
	// 		alert(getid);
			

	// 		})

	// 	});

	// });
</script>
     <!-- END: Body-->