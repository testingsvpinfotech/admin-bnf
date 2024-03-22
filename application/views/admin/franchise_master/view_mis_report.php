     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  /*#example_filter{display: none;}*/
  .input-group{
    width: 60%!important;
  }
</style>
        
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
                      <div class="card"> <br><br>
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title">Franchise MIS Report</h4>
                          </div>
                          <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/franchise-mis" method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                             <div class="form-row">
                                                   
                                                    <div class="col-sm-3">
                                                        <label for="username">Franchise</label>
                                                        <select class="form-control" name="customer_id" id="customer_id">
                                                            <option value="ALL" <?php echo (isset($post_data['customer_id']) && $post_data['customer_id'] == 'ALL')?'selected':''; ?>>ALL</option>
                                                            <?php foreach ($customers_list as $value) { ?>   
                                                            <option value="<?php echo $value['customer_id']; ?>" <?php echo (isset($post_data['customer_id']) && $post_data['customer_id'] == $value['customer_id'])?'selected':''; ?>><?php echo $value['customer_name']; ?></option>
                                                          <?php  }  ?>
                                                        </select>
                                                    </div>
                                                     <div class="col-sm-3">
                                                          <label for="">From Date</label>                       
                                                          <input type="date" name="from_date" value="<?php echo (isset($post_data['from_date']))?$post_data['from_date']:''; ?>" id="from_date" autocomplete="off" class="form-control" required>
                                                    </div>
                                                     <div class="col-sm-3">
                                                       <label for="">To Date</label>
                                                      <input type="date" name="to_date" value="<?php echo (isset($post_data['to_date']))?$post_data['to_date']:''; ?>" id="to_date" autocomplete="off" class="form-control" required>   
                                                </div>
                                               
                                                     
                                                <div class="col-sm-3">
                                                    <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Search"> 
                                                    <a href="<?= base_url('admin/franchise-mis');?>" style="margin-top: 25px;" class="btn btn-primary">Reset</a>
                                                </div>
                                            </div>
                                         
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                          <div class="card-body">
                             <div class="table-responsive">
                            <table id="example" class="display table table-striped table-bordered layout-primary" data-sorting="true">
                                <thead>
                                       <th scope='col'>SrNo</th>
                                       <th scope='col'>Date</th>
                                       <th scope='col'>AWB</th>
                                       <th scope='col'>Network</th>
                                       <th cope='col'>Type</th>
                                       <th scope='col'>Origin</th>
                                       <th scope='col'>Sender</th>
                                       <th scope='col'>Receiver</th>
                                       <th scope='col'>Receiver Addr</th>
                                       <th scope='col'>Receiver Pincode</th>
                                       <th scope="col">Franchise Name</th>
											                	<th scope="col">Master Franchise Name</th>
                                       <th scope='col'>Weight</th>
                                       <th scope='col'>Bill Type</th>
                                       <th scope='col'>NOP</th>
                                       <th scope="col">Freight</th>
                                      <th scope="col">Handling Charge</th>
                                      <th scope="col">Pickup</th>
                                      <th scope="col">ODA </th>
                                      <th scope="col">Insurance</th>
                                      <th scope="col">COD</th>
                                      <th scope="col">AWB Ch</th>
                                      <th scope="col">Other Ch.</th>
                                      <th scope="col">Green tax</th>
                                      <th scope="col">Appt Ch</th>
                                      <th scope="col">Fov Charges</th>
                                      <th scope="col">Total</th>
                                      <th scope="col">Fuel Surcharge</th>
                                       <th scope='col'>Status</th>
                                       <th scope='col'>Delivery Date</th>
                                       <th scope='col'>EDD Date</th>
                                       <th scope='col'>TAT</th>
                                       <th scope='col'>Deliverd TO</th>
                                       <th scope='col'>RTO Date</th>
                                       <th scope='col'>RTO Reason</th>
                                       <th scope='col'>Branch</th>
                                    </tr>
                                </thead>
                                      <tbody>                                 
                                       <tr>
                                      <?php 
                                      $i =0;
										if (!empty($domestic_allpoddata)) 
										{
                                             
                                               foreach ($domestic_allpoddata as $value_d) 
											   {


												    $tat 			= '';
												    $rto_reason 	= '';
													$rto_date 		= '';
													$delivery_date 	= '';
													if($value_d['status'] == 'RTO' || $value_d['status']=='Return to Orgin' || $value_d['status']=='Door Close' || $value_d['status']=='Address ok no search person' || $value_d['status']=='Address not found' || $value_d['status']=='No service' || $value_d['status']=='Refuse' || $value_d['status']=='Shifted' || $value_d['status']=='Wrong address' || $value_d['status']=='Person expired' || $value_d['status']=='Lost Intransit' || $value_d['status']=='Not collected by consignee' || $value_d['status']=='Delivery not attempted')
                          {
                            $rto_reason     = $value_d['comment'];
                            $rto_date       = $value_d['tracking_date'];
                            $value_d['status']  = $value_d['status'];
                          }
													else if($value_d['is_delhivery_complete'] == '1')
													{
														$delivery_date 		=  date('d-m-Y',strtotime($value_d['tracking_date']));
														$value_d['status'] 	= 'Delivered';
														
														$booking_date 		= $start = date('d-m-Y', strtotime($value_d['booking_date']));
														$start 				= date('d-m-Y', strtotime($value_d['booking_date']));
														$end 				= date('d-m-Y', strtotime($value_d['tracking_date']));
														$tat 				= ceil(abs(strtotime($start)-strtotime($end))/86400);
														
													}
													else
													{
                            // echo "<pre>";
                            // print_r($value_d);exit();
                            if ($value_d['status']=='shifted') {
                              $value_d['status'] = 'Intransit';
                            }
														
													}
                          if ($value_d['company_type']=='Domestic') {
                            $value_d['company_type'] = 'DOM';
                          }else{
                            $value_d['company_type'] = 'INT';
                          }

                          if (!empty($value_d['delivery_date'])) {
                            $value_d['delivery_date'] = date('d-m-Y',strtotime($value_d['delivery_date']));
                          }                $pod = $value_d['pod_no'];
                                         $sender_city1 = $value_d['sender_city'];
                                    $branch = $this->db->query("select branch_name from tbl_domestic_tracking where pod_no = '$pod' and status = 'Booked' order by id desc limit 1")->row();
                                    // $branch = $this->db->query("select city from city where id = '$pod'")->row();
                                    $sender_city = $this->db->query("select city from city where id = '$sender_city1'")->row();
                                      // print_r($branch);die;  
                                              ?>
                                                <td style="width:20px;"><?php echo ($i+1); ?></td>
                                                <td style="width:40px;"><?php echo date('d-m-Y', strtotime($value_d['booking_date'])); ?></td>
                                                <td style="width:20px;"><?php echo $value_d['pod_no']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['forworder_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['company_type']; ?></td>
                                                <td style="width:20px;"><?php echo $sender_city->city; ?></td>  
                                                <td style="width:20px;"><?php echo $value_d['sender_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['reciever_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['city']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['reciever_pincode']; ?></td>

                                                 
                           <?php
														$pod = $value_d['pod_no'];
														$customer_id = $value_d['customer_id'];
                                                        $getfranchise= array();
            $getMasterfranchise= array();
                                                        if($value_d['user_type']==2){
    														 $getfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->result_array(); 
    														 $getMasterfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->result_array(); 
                                                        }
														 
														 ?>

														<td><?php echo @$getfranchise[0]['customer_name'] ;?></td>
														<td><?php echo @$getMasterfranchise[0]['customer_name'] ;?></td>


                                                <td style="width:20px;"><?php echo ($value_d['chargable_weight']); ?></td>
                                                <td style="width:20px;"><?php echo $value_d['dispatch_details']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['no_of_pack'];?></td>
                                                <td style="width:20px;"><?php echo $value_d['frieht']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['transportation_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['pickup_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['delivery_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['insurance_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['courier_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['awb_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['other_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['green_tax']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['appt_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['fov_charges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['total_amount']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['fuel_subcharges']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['status'];?></td>
												                        <td style="width:20px;"><?php echo $delivery_date; ?></td>
												                        <td style="width:20px;"><?php echo $value_d['delivery_date']; ?></td>
												                        <td style="width:20px;"><?php echo $tat; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['comment']; ?></td>
                                                <td style="width:20px;"><?php echo $rto_date; ?></td>
                                                <td style="width:20px;"><?php echo $rto_reason; ?></td>
                                                <td style="width:20px;"><?php echo $branch->branch_name; ?></td>
                                            </tr>
                                            <?php
											 $i++;
                                        }
                                    }
                                    // else {
                                    //     echo "<p>No Data Found</p>";
                                    // }
                                  
                                    ?>
                        
                              </table> 
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                               
                            </div>
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

