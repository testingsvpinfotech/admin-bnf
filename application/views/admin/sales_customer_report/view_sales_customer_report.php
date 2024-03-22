<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<body id="main-container" class="default">
    <style>
        .buttons-copy { display: none; }
        .buttons-csv { display: none; }
        .buttons-pdf { display: none; }
        .buttons-print { display: none; }
        .input-group { width: 60% !important; }
    </style>
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Sales Customers Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form role="form"
                                                action="<?php echo base_url(); ?>admin/list-sales-customer-report"
                                                method="get" enctype="multipart/form-data">
                                                <div class="form-row">                                                  
                                                   
                                                    <div class="col-sm-2">
                                                        <label for="">From Date</label>
                                                        <input type="date" name="from_date"
                                                            value="<?php echo (isset($_GET['from_date'])) ? $_GET['from_date'] : ''; ?>"
                                                            id="from_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="">To Date</label>
                                                        <input type="date" name="to_date"
                                                            value="<?php echo (isset($_GET['to_date'])) ? $_GET['to_date'] : ''; ?>"
                                                            id="to_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label>Bill Status</label>
                                                        <select name="status" class="form-control" id="status">
                                                            <option value=""> All </option>
                                                            <option value="0" <?php if(isset($_GET['status'])){ if($_GET['status']=='0'){echo 'selected';}}?>> Unbilled </option>
                                                            <option value="1" <?php if(isset($_GET['status'])){ if($_GET['status']=='1'){echo 'selected';}}?>> Billed </option>
                                                        </select>
                                                     
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
                                                        <a href="<?= base_url('admin/list-sales-customer-report'); ?>"
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
                                <table  class="display table table-bordered"
                                    data-sorting="true">
                                    <thead>
                                    <tr>
                                        <th scope='col'>Sr No.</th>
                                        <th scope='col'>AWB No</th>
                                        <th scope='col'>Origin</th>
                                        <th scope='col'>Destination</th>
                                        <th scope='col'>Booking Date</th>
                                        <th scope="col">Frieht Charges</th>
                                        <th scope="col">Transportation Charges</th>
                                        <th scope="col">Pickup Charges</th>
                                        <th scope="col">Delivery Charges</th>
                                        <th scope="col">Insurance Charges</th>
                                        <th scope="col">Courier Charges</th>
                                        <th scope="col">AWB Charges</th>
                                        <th scope="col">Others Charges</th>
                                        <th scope="col">Topay Charges</th>
                                        <th scope="col">Appointment Charges</th>
                                        <th scope="col">Fov Charges</th>
                                        <th scope='col'>Actual Weight</th>
                                        <th scope='col'>Chargable Weight</th>
                                        <th scope='col'>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0; 
                                    $total_actual_weight = 0;
                                    $total_chargable_weight = 0;
                                    $total_sub_total = 0;
                                    if (!empty($booking_data)) {
                                        foreach ($booking_data as $value) {
                                        
                                        $pod_no = !empty($value->pod_no)?$value->pod_no:'';
                                        $origin = !empty($value->origin)?$value->origin:'';
                                        $destination = !empty($value->destination)?$value->destination:'';
                                        $booking_date = !empty($value->booking_date)?date('d-m-Y', strtotime($value->booking_date)):'';
                                        $actual_weight = !empty($value->actual_weight)?$value->actual_weight:'';
                                        $chargable_weight = !empty($value->chargable_weight)?$value->chargable_weight:'';
                                        $sub_total = !empty($value->sub_total)?$value->sub_total:'';
                                    ?>
                                    <tr>
                                        <td style="width:5px;"><?php echo ($i + 1); ?></td>
                                        <td><?= $pod_no; ?></td>
                                        <td><?= $origin; ?></td>
                                        <td><?= $destination; ?></td>
                                        <td><?= $booking_date; ?></td>
                                        <td><?php  echo $value->frieht; ?></td>
                                        <td><?php  echo $value->transportation_charges; ?></td>
                                        <td><?php  echo $value->pickup_charges; ?></td>
                                        <td><?php  echo $value->delivery_charges; ?></td>
                                        <td><?php  echo $value->insurance_charges; ?></td>
                                        <td><?php  echo $value->courier_charges; ?></td>
                                        <td><?php  echo $value->awb_charges; ?></td>
                                        <td><?php  echo $value->other_charges; ?></td>
                                        <td><?php  echo $value->green_tax; ?></td>
                                        <td><?php  echo $value->appt_charges; ?></td>
                                        <td><?php  echo $value->fov_charges; ?></td>
                                        <td><?= $actual_weight; ?></td>
                                        <td><?= $chargable_weight; ?></td>
                                        <td><?php echo $sub_total; ?></td>
                                    </tr>
                                    <?php $i++; 
                                        $total_actual_weight += $actual_weight;
                                        $total_chargable_weight += $chargable_weight;
                                        $total_sub_total += ($sub_total != 0)?$sub_total:0.00; 
                                     }  } ?>
                                    <tr>
                                        <th colspan="16">TOTAL</th>
                                        <th><?= $total_actual_weight; ?></th>
                                        <th><?= $total_chargable_weight; ?></th>
                                        <th><?= $total_sub_total; ?></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <?php //echo $this->pagination->create_links(); ?>
                                </div>
                            </div> -->
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

          $('#all_sub').DataTable( {
    dom: 'lBfrtip',
    buttons: [ 
        'excelHtml5', 
    ]
} );
        });

    
       // Get the <span> element that closes the modal
     </script>
<!-- END: Body-->