<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">
    <style>
        .buttons-copy {
            display: none;
        }

        .buttons-csv {
            display: none;
        }

        /*.buttons-excel{display: none;}*/
        .buttons-pdf {
            display: none;
        }

        .buttons-print {
            display: none;
        }

        /*#example_filter{display: none;}*/
        .input-group {
            width: 60% !important;
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
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Sales Customers Shipments</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form role="form"
                                                action="<?php echo base_url(); ?>admin/sales-customer-shipments"
                                                method="get" enctype="multipart/form-data">
                                                <div class="form-row">                                                  
                                                   
                                                    <div class="col-sm-2">
                                                        <label for="">From Date</label>
                                                        <input type="date" name="from_date"
                                                            value="<?php echo (isset($post_data['from_date'])) ? $post_data['from_date'] : ''; ?>"
                                                            id="from_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="">To Date</label>
                                                        <input type="date" name="to_date"
                                                            value="<?php echo (isset($post_data['to_date'])) ? $post_data['to_date'] : ''; ?>"
                                                            id="to_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label>Customer </label>
                                                        <select name="customer_id" class="form-control" id="customer">
                                                            <option value=""> All </option>
                                                            <?php foreach($customers as $key => $value){  ?>
                                                                <option value="<?= $value->customer_id; ?>" <?php if(isset($_GET['customer_id'])){ if($_GET['customer_id'] == $value->customer_id){echo 'selected';}}?>><?= $value->customer_name.' -- '.$value->cid ?></option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="submit" class="btn btn-primary"
                                                            style="margin-top: 25px;" name="submit" value="Search">
                                                        <input type="submit" class="btn btn-primary"
                                                            style="margin-top: 25px;" name="submit"
                                                            value="Download Excel">
                                                        <a href="<?= base_url('admin/sales-customer-shipments'); ?>"
                                                            class="btn btn-primary" style="margin-top: 25px;">Reset</a>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display table table-striped table-bordered layout-primary"
                                    data-sorting="true">
                                    <thead>
                                    <th scope='col'>Sr No.</th>
                                   <th scope='col'>Booking Date</th>
                                       <th scope='col'>AWB</th>
                                       <th scope='col'>Mode</th>
                                       <th scope='col'>Booking Branch</th>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php 
                                            
                                            if (!empty($domestic_allpoddata)) {
                                                $i = 0;
                                                // echo '<pre>';print_r($domestic_allpoddata);die;
                                                foreach ($domestic_allpoddata as $value_d) {
                                                    $tat = '';
                                                    $rto_reason = '';
                                                    $rto_date = '';
                                                    $delivery_date = '';                                            
                                                    if (!empty($value_d['delivery_date'])) {
                                                        $value_d['delivery_date'] = date('d-m-Y H:i', strtotime($value_d['delivery_date']));
                                                    }
                                                    $pod_no = $value_d['pod_no'];
                                                        $pod_check  = $this->db->query("select * from tbl_upload_pod where pod_no = '$pod_no'")->row();
                                                         if(empty($pod_check)){
                                                            $pod_status = 'NO';
                                                            $date_time_pod  = '';
                                                         }else{
                                                            $pod_status = 'Yes';
                                                            $date_time_pod  = $pod_check->booking_date;
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
                                               
                                             
                                                   $delivery = array();
                                                    if (!empty($outForDelivery)) {
                                                        // echo "outForDelivery";
                                                        $delivery = $this->db->query("select * from tbl_domestic_tracking where pod_no = '$booking_d' AND status like '%In-scan%' order by id DESC limit 1")->row();
                                                        // echo $this->db->last_query();
                                                        // print_r($delivery);
                                                    }
                                            
                                                  ?>
                                                       <td style="width:20px;"><?php echo ($i + 1); ?></td>
                                                <td style="width:40px;"><?php echo date('d-m-Y', strtotime($value_d['booking_date'])); ?></td>
                                                <td style="width:20px;"><?php echo $value_d['pod_no']; ?></td>
                                                <td style="width:20px;"> <?php
                                                $mode = $value_d['mode_dispatch'];
                                                $mode_type = $this->db->query("select * from transfer_mode where transfer_mode_id = '$mode'")->row();
                                                echo $mode_type->mode_name; ?></td>
                                                <td style="width:20px;"><?php echo $booking_d_name->branch_name; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['destination']; ?></td>
                                                <td style="width:20px;"><?php echo $customer->cid; ?></td>
                                                <td style="width:20px;"><?php echo $customer->customer_name; ?></td>
                                                <td style="width:20px;"><?php echo $booking_d_name->branch_name; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['sender_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['reciever_name']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['reciever_pincode']; ?></td>
                                                <td style="width:20px;"><?php echo $weight->no_of_pack; ?></td>
                                                <td style="width:20px;"><?php echo $weight->actual_weight; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['chargable_weight']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['invoice_no']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['invoice_value']; ?></td>
                                                <td style="width:20px;"><?php echo $value_d['dispatch_details']; ?></td>                                                                                     
                                                </tr>
                                                <?php
                                                $i++;
                                                }
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
<script>
        $(document).ready(function() {
          $('#customer').select2();
          $('#status').select2();

       
        });

    
     </script>
<!-- END: Body-->