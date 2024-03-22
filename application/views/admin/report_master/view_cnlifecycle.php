     <?php $this->load->view('admin/admin_shared/admin_header');?>
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
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center"><br><br>
                              <h4 class="card-title">CN Life Cycle</h4>
                          </div>
                          <div class="card-content">
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url(); ?>admin/cn-life-cycle" method="post" enctype="multipart/form-data">
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
                                                        <label for="username">Type</label>
                                                        <select class="form-control" name="company_type">
                                                              <option value="ALL" <?php echo (isset($post_data['company_type']) && $post_data['company_type'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
                                                              <option value="International" <?php echo (isset($post_data['company_type']) && $post_data['company_type'] == 'International') ? 'selected' : ''; ?>>International</option>
                                                              <option value="Domestic" <?php echo (isset($post_data['company_type']) && $post_data['company_type'] == 'Domestic') ? 'selected' : ''; ?>>Domestic</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="username">Customer</label>
                                                        <select class="form-control" name="customer_id" id="customer_id">
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
                                                        <label for="username">Network</label>
                                                        <select class="form-control" name="courier_company" id="courier_company">
                                                            <option value="ALL" <?php echo (isset($post_data['courier_company']) && $post_data['courier_company'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
                                                            <?php foreach ($courier_company as $cc) {?>
                                                            <option value="<?php echo $cc['c_id']; ?>" <?php echo (isset($post_data['courier_company']) && $post_data['courier_company'] == $cc['c_id']) ? 'selected' : ''; ?>><?php echo $cc['c_company_name']; ?></option>
                                                          <?php }?>
                                                        </select>
                                                    </div>
                                                <div class="col-sm-3">
                                                    <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Search">
                                                    <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Download Excel">
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
                            <table id="" class="display table table-striped table-bordered layout-primary" data-sorting="true">
                                <thead>
                                <th scope='col'>Sr No.</th>
                                <th scope='col'>Booking Date</th>
                                       <th scope='col'>AWB</th>
                                       <th scope='col'>Mode</th>
                                       <th cope='col'>Booking Branch</th>
                                       <th scope='col'>Destination</th>
                                       <th scope='col'>Customer Code</th>
                                       <th scope='col'>Customer Name</th>
                                       <th scope='col'>Consignor Origin</th>
                                       <th scope='col'>Consignor</th>
                                       <th scope='col'>Consignee</th>
                                       <th scope='col'>Consignee Pincode</th>
                                       <th scope='col'>NOP</th>
                                       <th scope='col'>AW</th>
                                       <th scope='col'>CW</th>
                                       <th scope='col'>Consignor Invoice No</th>
                                       <th scope='col'>Consignor Invoice Value</th>
                                       <th scope='col'>Bill Type</th>
                                       <th scope='col'>Pickupinscan date & time</th>
                                       <th scope='col'>pickupinscan branch</th>
                                       <th scope='col'>Booking Branch Out scan Date & Time</th>
                                       <th scope='col'>Current Status</th>
                                       <th scope='col'>Last Scan Branch</th>
                                       <th scope='col'>Last Genrated Bag</th>
                                       <th scope='col'>Last Genrated Menifiest</th>
                                       <th scope='col'>Last scan Date & time</th>
                                       <th scope='col'>Delivery branch In-scan (Date & Time)</th>
                                       <th scope='col'>DRS Date & time</th>
                                       <th scope='col'>DRS Branch</th>
                                       <th scope='col'>TAT</th>
                                       <th scope='col'>EDD Date</th>
                                       <th scope='col'>Delivery Date</th>
                                       <th scope='col'>Deliverd TO</th>
                                       <th scope='col'>RTO Date</th>
                                       <th scope='col'>RTO Reason</th>
                                       <th scope='col'>Sub Total</th>
                                       <th scope='col'>POD Status</th>
                                       <th scope='col'>Franchise Code</th>
                                       <th scope='col'>Franchise Name</th>
                                       <th scope='col'>Master Franchise Name</th>
                                       <th scope='col'>E way No</th>
                                    </tr>
                                </thead>
                                      <tbody>
                                       <tr>
                                        <?php ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
$i = $serial_no;
if (!empty($international_allpoddata)) {

    foreach ($international_allpoddata as $value) {

        $rto_reason = '';
        $rto_date = '';
        $delivery_date = '';
        if (@$post_data['status'] == '2') {
            $rto_reason = $value['comment'];
            $rto_date = $value['tracking_date'];
            $value['status'] = $value['o_status'];
        }

        if (!empty($value['delivery_date'])) {
            $value['delivery_date'] = date('d-m-Y', strtotime($value['delivery_date']));
        }

        // echo "<pre>";
        // print_r($value);exit();

        if ($value['status'] == 'shifted') {
            $value['status'] = 'Intransit';
        }
        if ($value['company_type'] == 'Domestic') {
            $value['company_type'] = 'DOM';
        } else {
            $value['company_type'] = 'INT';
        }
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
                                            <?php
$i++;
    }
}
if (!empty($domestic_allpoddata)) {

    foreach ($domestic_allpoddata as $value_d) {

        $tat = '';
        $rto_reason = '';
        $rto_date = '';
        $delivery_date = '';
        if ($value_d['status'] == 'RTO' || $value_d['status'] == 'Return to Orgin' || $value_d['status'] == 'Door Close' || $value_d['status'] == 'Address ok no search person' || $value_d['status'] == 'Address not found' || $value_d['status'] == 'No service' || $value_d['status'] == 'Refuse' || $value_d['status'] == 'Shifted' || $value_d['status'] == 'Wrong address' || $value_d['status'] == 'Person expired' || $value_d['status'] == 'Lost Intransit' || $value_d['status'] == 'Not collected by consignee' || $value_d['status'] == 'Delivery not attempted') {
            $rto_reason = $value_d['comment'];
            $rto_date = $value_d['tracking_date'];
            $value_d['status'] = $value_d['status'];
        } else if ($value_d['is_delhivery_complete'] == '1') {
            $delivery_date = date('d-m-Y', strtotime($value_d['tracking_date']));
            $value_d['status'] = 'Delivered';

            $booking_date = $start = date('d-m-Y', strtotime($value_d['booking_date']));
            $start = date('d-m-Y', strtotime($value_d['booking_date']));
            $end = date('d-m-Y', strtotime($value_d['tracking_date']));
            $tat = ceil(abs(strtotime($start) - strtotime($end)) / 86400);

        } else {
            // echo "<pre>";
            // print_r($value_d);exit();
            if ($value_d['status'] == 'shifted') {
                $value_d['status'] = 'Intransit';
            }

        }
        if ($value_d['company_type'] == 'Domestic') {
            $value_d['company_type'] = 'DOM';
        } else {
            $value_d['company_type'] = 'INT';
        }

        if (!empty($value_d['delivery_date'])) {
            $value_d['delivery_date'] = date('d-m-Y', strtotime($value_d['delivery_date']));
        }
        $pod_no = $value_d['pod_no'];
			$pod_check  = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->row();
			 if(empty($pod_check)){
				$pod_status = 'NO';
			 }else{
				$pod_status = 'Yes';
			 }
        $booking_d = $value_d['pod_no'];
        $id = $value_d['booking_id'];
        $customer_id = $value_d['customer_id'];
			$booking_d_name = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id ASC limit 1")->row();
			$current = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' order by id desc limit 1")->row();
      //  echo '<pre>'; print_r($value_d);
			$customer = $this->db->query("select * from tbl_customers where customer_id = '$customer_id' ")->row();
			$weight = $this->db->query("select * from tbl_domestic_weight_details where booking_id = '$id' ")->row();
      $PickupInScan = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Pickup-In-scan' order by id ASC limit 1")->row_array();

       $bag = $this->db->query("select * from tbl_domestic_bag where pod_no = '$booking_d'  limit 1")->row();
       $gatepass = $this->db->query("select * from tbl_gatepass where bag_no = '$bag->bag_id' limit 1")->row();
       $outForDelivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status='Out For Delivery' order by id ASC limit 1")->row_array();
      //  $menifiest = $this->db->query("select * from tbl_domestic_menifiest where bag_no = '$menifiest->manifiest_id' order by limit 1")->row();
   
 


        ?>
                                                <td style="width:20px;"><?php echo ($i + 1); ?></td>
                                                <td style="width:40px;"><?php echo date('d-m-Y', strtotime($value_d['booking_date'])); ?></td>
                                                <td style="width:20px;"><?php echo $value_d['pod_no']; ?></td>
                                                <td style="width:20px;"> <?php
                                                $mode = $value_d['mode_dispatch'];
                                                $mode_type = $this->db->query("select * from transfer_mode where transfer_mode_id = '$mode'")->row();
                                                echo $mode_type->mode_name; ?></td>
                                                <td style="width:20px;"><?php echo $booking_d_name->branch_name; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['city']; ?></td>
                                                <td style="width:20px;"><?php echo $customer->cid; ?></td>
                                                <td style="width:20px;"><?php echo $customer->customer_name; ?></td>
                                                <td style="width:20px;"><?php echo $booking_d_name->branch_name; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['sender_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['reciever_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['reciever_pincode']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['no_of_pack']; ?></td>
                                                <td style="width:20px;"><?php echo $weight->actual_weight; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['chargable_weight']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['invoice_no']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['invoice_value']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['dispatch_details']; ?></td>
                                                <td style="width:20px;"><?php echo $PickupInScan['tracking_date']; ?></td>
                                                <td style="width:20px;"><?php echo $PickupInScan['branch_name']; ?></td>
                                                <td style="width:20px;"><?php echo $gatepass->datetime; ?></td>
                                                <td style="width:20px;"><?php echo $current->status; ?></td>
                                                <td style="width:20px;"><?php echo $gatepass->origin; ?></td>
                                                <td style="width:20px;"><?php echo $gatepass->datetime; ?></td>
                                                <td style="width:20px;"><?php echo $gatepass->datetime; ?></td>
                                                <td style="width:20px;"><?= $outForDelivery['tracking_date']; ?></td>
                                                <td style="width:20px;"><?= $outForDelivery['branch_name']; ?></td>
                                                <td style="width:20px;"></td>
                                                <td style="width:20px;"></td>
                                                <td style="width:20px;"><?php echo $tat; ?></td>
                                                <td style="width:20px;"><?php echo $delivery_date; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['delivery_date']; ?></td>
                                                <td style="width:20px;"></td>
                                                <td style="width:20px;"><?php echo $rto_date; ?></td>
                                                <td style="width:20px;"><?php echo $rto_reason; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['sub_total']; ?></td>
                                                <td style="width:20px;"><?php echo $pod_status; ?></td>
                           <?php
$pod = $value_d['pod_no'];
        $customer_id = $value_d['customer_id'];
        $getfranchise = array();
        $getMasterfranchise = array();
        if ($value_d['user_type'] == 2) {
            $getfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->result_array();
            $getMasterfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->result_array();
        }

        ?>

														<td><?php echo @$getfranchise[0]['cid']; ?></td>
														<td><?php echo @$getfranchise[0]['customer_name']; ?></td>
														<td><?php echo @$getMasterfranchise[0]['customer_name']; ?></td>                                               
                                                <td style="width:20px;"><?php echo $value_d['eway_no']; ?></td>
                                            </tr>
                                            <?php
$i++;
    }
} else {
    echo "<p>No Data Found</p>";
}

?>

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

