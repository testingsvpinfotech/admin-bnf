<?php $this->load->view('admin/admin_shared/admin_header');?>
<body id="main-container" class="default">
<style>
  .buttons-copy{display: none;} .buttons-csv{display: none;}.buttons-pdf{display: none;}.buttons-print{display: none;}.input-group{width: 60%!important;}
</style>
<?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

<main>
  <div class="container-fluid site-width">
    <div class="row">
      <div class="col-12  align-self-center">
        <div class="col-12 col-sm-12 mt-3">
          <div class="card">
            <div class="card-header justify-content-between align-items-center">
              <h4 class="card-title">Accounts MIS Report</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form role="form" action="<?php echo base_url(); ?>admin/list-mis-report-accounts" method="get" enctype="multipart/form-data">
                      <div class="form-row">
                        <div class="form-row">
                          <div class="col-sm-2">
                            <label for="username">Bill Type</label>
                              <select class="form-control" name="bill_type">
                                <option value="ALL" <?php echo (isset($post_data['bill_type']) && $post_data['bill_type'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
                                <option value="Credit" <?php echo (isset($post_data['bill_type']) && $post_data['bill_type'] == 'Credit') ? 'selected' : ''; ?>>Credit</option>
                                <option value="Cash" <?php echo (isset($post_data['bill_type']) && $post_data['bill_type'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                              </select>
                            </div>
                            <div class="col-sm-2">
                              <label for="username">Customer</label>
                              <select class="form-control select" name="customer_id" id="customer_id">
                                <option value="ALL" <?php echo (isset($post_data['customer_id']) && $post_data['customer_id'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
                                <?php foreach ($customers_list as $value) {?>
                                  <option value="<?php echo $value['customer_id']; ?>" <?php echo (isset($post_data['customer_id']) && $post_data['customer_id'] == $value['customer_id']) ? 'selected' : ''; ?>><?php echo $value['customer_name']; ?></option>
                                <?php }?>
                              </select>
                            </div>
                            <div class="col-sm-2">
                              <label for="">From Date</label>
                              <input type="date" name="from_date" value="<?php echo (isset($post_data['from_date'])) ? $post_data['from_date'] : ''; ?>" id="from_date" autocomplete="off" class="form-control">
                            </div>
                            <div class="col-sm-2">
                              <label for="">To Date</label>
                              <input type="date" name="to_date" value="<?php echo (isset($post_data['to_date'])) ? $post_data['to_date'] : ''; ?>" id="to_date" autocomplete="off" class="form-control">
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <label for="">Doc/Non-Doc</label>
                                <select class="form-control" name="doc_type">
                                  <option value="ALL" <?php echo (isset($post_data['doc_type']) && $post_data['doc_type'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
                                  <option value="1" <?php echo (isset($post_data['doc_type']) && $post_data['doc_type'] == '1') ? 'selected' : ''; ?>>Non-Doc</option>
                                  <option value="0" <?php echo (isset($post_data['doc_type']) && $post_data['doc_type'] == '0') ? 'selected' : ''; ?>>Doc</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <label>Status</label>
                							<select class="form-control" name="status">
          											<option value="ALL" <?php echo (isset($post_data['status']) && $post_data['status'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
          											<option value="0" <?php echo (isset($post_data['status']) && $post_data['status'] == '0') ? 'selected' : ''; ?>>Pending</option>
          											<option value="1" <?php echo (isset($post_data['status']) && $post_data['status'] == '1') ? 'selected' : ''; ?>>Delivered</option>
          											<option value="2" <?php echo (isset($post_data['status']) && $post_data['status'] == '2') ? 'selected' : ''; ?>>RTO</option>
                							</select>
                            </div>
                            <div class="col-sm-2">
                              <label>AWB No</label>
                							<input type="text" class="form-control" value="<?php echo (isset($post_data['awb_no'])) ? $post_data['awb_no'] : ''; ?>" name="awb_no">
                            </div>
                            <div class="col-sm-2">
                              <label>Billing Status</label>
                              <select class="form-control" name="billed_status">
                                <option value="">Please select</option>
                                <option value="1" <?php echo (isset($post_data['billed_status']) && $post_data['billed_status'] == '1') ? 'selected' : ''; ?>>Billed</option>
                                <option value="0" <?php echo (isset($post_data['billed_status']) && $post_data['billed_status'] == '0') ? 'selected' : ''; ?>>Unbilled</option>
                              </select>
                            </div>
                            <div class="col-sm-3">
                              <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Search">
                              <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Download Excel">
                              <a href="<?= base_url('admin/list-mis-report-accounts'); ?>" class="btn btn-primary" style="margin-top: 25px;">Reset</a>
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
                  <table id="" class="display table table-bordered" data-sorting="true">
                    <thead>
                      <th scope='col'>Sr No.</th>
                      <th scope='col'>Booking Date</th>
                      <th scope='col'>Customer Code</th>
                      <th scope='col'>Customer Name</th>
                      <th scope='col'>AWB</th>
                      <th scope='col'>Mode</th>
                      <th scope='col'>Booking Branch</th>
                      <th scope='col'>Destination</th>
                      <th scope="col">Bkg Zone</th>
                      <th scope="col">Delivery Zone</th>
                      <!-- <th scope='col'>Consignor Origin</th> -->
                      <!-- <th scope='col'>Consignor</th> -->
                      <!-- <th scope='col'>Consignee</th> -->
                      <!-- <th scope='col'>Consignee Pincode</th> -->
                      <th scope='col'>Customer Invoice Amount</th>
                      <th scope='col'>NOP</th>
                      <th scope='col'>AW</th>
                      <th scope='col'>Volumetric weight</th>
                      <th scope='col'>CW</th>
                      <th scope='col'>Rate Per Kg</th>
                      <th scope='col'>Freight</th>
                      <th scope='col'>FOV</th>
                      <th scope='col'>Handling Charge</th> 
                      <th scope='col'>Pickup</th>  
                      <th scope='col'>ODA Charge</th>  
                      <th scope='col'>Insurance</th>
                      <th scope='col'>Appt Ch.</th>
                      <th scope='col'>COD</th>
                      <th scope='col'>Others</th>
                      <th scope='col'>Green Tax</th>
                      <th scope='col'>Warehousing</th>
                      <th scope='col'>Address Change</th>
                      <th scope='col'>Doc Charge</th>
                      <th scope='col'>Fuel Charge</th>
                      <th scope='col'>Sub Total</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <?php ini_set('display_errors', '0');ini_set('display_startup_errors', '0');error_reporting(E_ALL);
                      $i = $serial_no;
                      if (!empty($international_allpoddata)) {
                        foreach ($international_allpoddata as $value) {
                          $rto_reason = ''; $rto_date = ''; $delivery_date = '';
                          if (@$post_data['status'] == '2') {
                            $rto_reason = $value['comment']; $rto_date = $value['tracking_date']; $value['status'] = $value['o_status'];
                          }

                          if (!empty($value['delivery_date'])) {
                            $value['delivery_date'] = date('d-m-Y', strtotime($value['delivery_date']));
                          }
                          if ($value['status'] == 'shifted') { $value['status'] = 'Intransit'; }
                          if ($value['company_type'] == 'Domestic') { $value['company_type'] = 'DOM'; } else { $value['company_type'] = 'INT'; }
                    ?>
                      <td style="width:20px;"><?php echo ($i + 1); ?></td>
                      <td style="width:40px;"><?php echo date('d-m-Y', strtotime($value['booking_date'])); ?></td>
                      <td style="width:20px;"><?php echo $value['pod_no']; ?></td>
                      <td style="width:20px;"><?php echo $value['forworder_name']; ?></td>
                      <td style="width:20px;"><?php echo $value['company_type']; ?></td>
                      <td style="width:20px;"><?php echo $value['forwording_no']; ?></td>
                      <td style="width:20px;"><?php echo $value['country_name']; ?></td>
                      <td style="width:20px;"><?php echo $value['sender_name']; ?></td>
                      <td style="width:20px;"><?php echo $value['reciever_name']; ?></td>
                      <td style="width:20px;"><?php echo ''; ?></td>
                      <td style="width:20px;"><?php echo ''; ?></td>
                      <td style="width:20px;"><?php echo ''; ?></td>
                      <td style="width:20px;"><?php echo ''; ?></td>
                      <!-- <td style="width:20px;"><?php //  echo $value['doc_nondoc']; ?></td> -->
                      <td style="width:20px;"><?php echo ($value['chargable_weight']); ?></td>
                      <td style="width:20px;"><?php echo $value['dispatch_details']; ?></td>
                      <td style="width:20px;"><?php echo $value['no_of_pack']; ?></td>
                      <td style="width:20px;"><?php echo $value['status']; ?></td>
                      <td style="width:20px;"><?php echo $delivery_date; ?></td>
                      <td style="width:20px;"></td>
                      <td style="width:20px;"></td>
                      <td style="width:20px;"><?php echo $value['comment']; ?></td>
                      <td style="width:20px;"><?php echo $rto_date; ?></td>
                      <td style="width:20px;"><?php echo $rto_reason; ?></td>
                      <td style="width:20px;"><?php echo $value['branch_name']; ?></td>
                    </tr>
                    <?php $i++; } }
                    if (!empty($domestic_allpoddata)) {
                      foreach ($domestic_allpoddata as $value_d) {
                        $tat = ''; $rto_reason = ''; $rto_date = ''; $delivery_date = '';
                        if ($value_d['status'] == 'RTO' || $value_d['status'] == 'Return to Orgin' || $value_d['status'] == 'Door Close' || $value_d['status'] == 'Address ok no search person' || $value_d['status'] == 'Address not found' || $value_d['status'] == 'No service' || $value_d['status'] == 'Refuse' || $value_d['status'] == 'Shifted' || $value_d['status'] == 'Wrong address' || $value_d['status'] == 'Person expired' || $value_d['status'] == 'Lost Intransit' || $value_d['status'] == 'Not collected by consignee' || $value_d['status'] == 'Delivery not attempted') {
                          $rto_reason = $value_d['comment'];
                          $rto_date = $value_d['tracking_date'];
                          $value_d['status'] = $value_d['status'];
                        } else if ($value_d['is_delhivery_complete'] == '1') {
                          $delivery_date = date('d-m-Y H:i', strtotime($value_d['tracking_date']));
                          $value_d['status'] = 'Delivered';

                          $booking_date = $start = date('d-m-Y', strtotime($value_d['booking_date']));
                          $start = date('d-m-Y', strtotime($value_d['booking_date']));
                          $end = date('d-m-Y', strtotime($value_d['tracking_date']));
                          $tat = ceil(abs(strtotime($start) - strtotime($end)) / 86400);
                        } else {
                          if ($value_d['status'] == 'shifted') { $value_d['status'] = 'Intransit'; }
                        }
                        if ($value_d['company_type'] == 'Domestic') { $value_d['company_type'] = 'DOM'; } else { $value_d['company_type'] = 'INT'; }

                        if (!empty($value_d['delivery_date'])) { $value_d['delivery_date'] = date('d-m-Y H:i', strtotime($value_d['delivery_date'])); }
                        $pod_no = $value_d['pod_no'];
			                  $pod_check  = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->row();
			                  if(empty($pod_check)){ $pod_status = 'NO'; $date_time_pod  = ''; }
                        else{ $pod_status = 'Yes'; $date_time_pod  = $pod_check->booking_date; }

                        $booking_d = $value_d['pod_no'];
                        $id = $value_d['booking_id'];
                        $customer_id = $value_d['customer_id'];
			                  $booking_d_name = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id ASC limit 1")->row();
			                  $current = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id desc limit 1")->row();
                        
                        if(empty($customer_id)){
                          $customer123 = $this->db->query("select * from tbl_customers where customer_id = '$customer_id' ")->row();  
                        }else{
                          $customer123 = $this->db->query("select * from tbl_customers where cid = '".$value_d['cid']."' ")->row();
                        }
			                  
			                  $weight = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$id' ")->row();
                        $PickupInScan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Pickup-In-scan' order by id ASC limit 1")->row_array();

                        $bag = $this->db->query("select * from tbl_domestic_bag where pod_no = '$booking_d'  limit 1")->row();
                        $gatepass = $this->db->query("select * from tbl_gatepass where bag_no = '$bag->bag_id' limit 1")->row();
                        $outForDelivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Out For Delivery' order by id ASC limit 1")->row_array();
 
                        $delivery = array();
                        if (!empty($outForDelivery)) {
                          $delivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status like '%In-scan%' order by id DESC limit 1")->row();  }
                          $s_state = $value_d['sender_state'];
                          $s_city = $value_d['sender_city'];
                          $sender_zone_data = $this->db->query("SELECT rm.* FROM region_master rm LEFT JOIN region_master_details rt ON(rt.regionid = rm.region_id) WHERE rt.state = $s_state AND rt.city = $s_city")->row();

                          $receiver_zone_data = $this->db->get_where('region_master',['region_id' => $value_d['receiver_zone_id']])->row();
                          
                          $cust_data123 = $this->db->query("SELECT * FROM tbl_customers WHERE cid = '".$value_d['cid']."'")->row();
                          $rate_val = 0;
                          if(!empty($receiver_zone_data->region_id) && !empty($sender_zone_data->region_id) && !empty($cust_data123->customer_id)){
                            // if ($cust_data123->customer_type == 0) {
                              $rate_data = $this->db->query("SELECT * from tbl_domestic_rate_master where from_zone_id = ".$sender_zone_data->region_id." AND to_zone_id = ".$receiver_zone_data->region_id ." AND customer_id =".$cust_data123->customer_id)->row();
                              $rate_val = round($rate_data->rate);
                            // }
                            // else{
                            //   $rate_data = $this->db->query("SELECT * from tbl_franchise_rate_master 
                            //    where from_zone_id = ".$sender_zone_data->region_id." AND to_zone_id = ".$receiver_zone_data->region_id ." AND customer_id =".$cust_data123->customer_id)->row();
                            // }
                          }
                          
                          
                    ?>
                      <td style="width:20px;"><?php echo ($i + 1) ?></td>
                      <td style="width:40px;"><?php echo date('d-m-Y', strtotime($value_d['booking_date'])); ?></td>
                      <td style="width:20px;"><?php echo $cust_data123->cid; ?></td>
                      <td style="width:20px;"><?php echo $cust_data123->customer_name; ?></td>
                      <td style="width:20px;"><?php echo $value_d['pod_no']; ?></td>
                      
                      <td style="width:20px;"> <?php
                      $mode = $value_d['mode_dispatch'];
                      $mode_type = $this->db->query("select * from transfer_mode where transfer_mode_id = '$mode'")->row();
                      echo $mode_type->mode_name; ?></td>
                      <td style="width:20px;"><?php echo $booking_d_name->branch_name; ?></td>
                      <td style="width:20px;"><?php echo $value_d['reciever_city']; ?></td>
                      <td style="width:20px;"><?php echo $sender_zone_data->region_name; ?></td>
                      <td style="width:20px;"><?php echo $receiver_zone_data->region_name; ?></td>
                      <td style="width:20px;"><?php echo $value_d['invoice_value']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['no_of_pack']; ?></td>
                      <td style="width:20px;"><?php echo $weight->actual_weight; ?></td>
                      <td style="width:20px;"><?php echo $value_d['valumetric_weight']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['chargable_weight']; ?></td>
                      <td style="width:20px;"><?php echo $rate_val;  ?></td>
                      <td style="width:20px;"><?php echo $value_d['frieht']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['fov_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['transportation_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['pickup_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['delivery_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['insurance_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['appt_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['courier_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['other_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['green_tax']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['warehousing']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['address_change']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['awb_charges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['fuel_subcharges']; ?></td>
                      <td style="width:20px;"><?php echo $value_d['sub_total']; ?></td>
                      
                    </tr>
                    <?php $i++;  } } else {
                      echo "<p>No Data Found</p>"; } ?>
                  </table>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php echo $this->pagination->create_links(); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php $this->load->view('admin/admin_shared/admin_footer'); ?>
<script>
  $(document).ready(function(){
    $('.select').select2();
  });
</script>
</body>