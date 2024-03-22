<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
    .fade:not(.show) {
    opacity: 1;
}
</style>
<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <!-- END: Main Menu-->
    <style>
        .table.layout-primary tbody td:last-child {
            background-color: #ffffff;
            color: aliceblue;
        }
    </style>
    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Pending Transfer Payment List</h4>
                            </div>
                            
                            <div class="col-md-6">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  class="display table  table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col">Id</th> -->
                                                <th scope="col">FTL Request No</th>
                                                <th scope="col">FTL Request Date</th>
                                                <th scope="col">sales Person</th>
                                                <th scope="col">sales Branch</th>
                                                <th scope="col">Traffic Manager</th>
                                                <!-- <th scope="col">Approve Date Time</th> -->
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Origin </th>
                                                <th scope="col">Destination</th>
                                                <th scope="col">Vehicle Type</th>
                                                <th scope="col">Vendor Name</th>
                                                <th scope="col">vendor Code</th>
                                                <th scope="col">Total Bid Amount</th>
                                                <th scope="col">Advance</th>
                                                <th scope="col">Balance</th>
                                                <th scope="col">Approved By</th>
                                                <th scope="col">Approved Date</th>
                                                <th scope="col">UTR No</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                            <?php
                                            if (!empty($pending_transfer_payment)) {
                                              
                                                $cnt = 1; 
                                                foreach ($pending_transfer_payment as  $ct) {  ?>
                                                    <tr>
                                                        <!-- <td><?php // echo $cnt; ?></td> -->
                                                        <td><?php echo $ct->ftl_request_id; ?></td>
                                                        <td><?php echo $ct->request_date_time; ?></td>
                                                        <td><?php echo $ct->sales_name; ?></td>
                                                        <?php $sales_branch_id = $ct->sales_branch_id; $dd4 = $this->db->query("select branch_name  from tbl_branch where branch_id = '$sales_branch_id'")->row_array();?>
                                                        <td style="color: green;"><?php echo $dd4['branch_name']; ?></td>
                                                        <td><?php echo $ct->traffic_manager_name; ?></td>
                                                        <!-- <td><?php echo $ct->tm_approve_date; ?></td> -->
                                                        <td><?php echo $ct->customer_name; ?></td>
                                                        <?php $origin_city = $ct->origin_city; $dd5 = $this->db->query("select city from city where id = '$origin_city'")->row_array();?> 
                                                        <td><?php echo $dd5['city']; ?></td>
                                                        <td><?php echo $ct->destination_city; ?></td>
                                                        <?php $vehicle_name =  $ct->type_of_vehicle ; $dd1 = $this->db->query("select vehicle_name from vehicle_type_master where id = '$vehicle_name'")->row_array(); ?>
                                                         <td><?php echo $dd1['vehicle_name']; ?> </td>
                                                        <td><?php echo $ct->vendor_name; ?></td>
                                                        <td><?php echo $ct->vcode; ?></td>
                                                        <td><?php echo $ct->vendor_amount; ?></td>
                                                        <td><?php echo $ct->advance_amount; ?></td>
                                                        <td><?php echo $ct->remaining_amount; ?></td>
                                                        <?php $approvedby = $ct->payment_approved_by; $dd3 = $this->db->query("select full_name  from tbl_users where user_id = '$approvedby'")->row_array();?>
                                                        <td style="color: green;"><?php echo $dd3['full_name']; ?></td>
                                                        <td><?php echo $ct->payment_approved_date; ?></td>
                                                        <td><?php echo $ct->utr_no; ?></td>
                                                        <td>
                                                            <?php if($ct->payment_approve_status == '1'){?>
                                                              <button class = "btn btn-success">Approved</button>
                                                           <?php }else{?>
                                                              <button class = "btn btn-warning approve_status" relid ="<?php echo $ct->ftl_request_id;?>">Pending</button></td>
                                                          <?php  } ?>
                                                    </tr>
                                            <?php
                                                    $cnt++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php  echo $this->pagination->create_links(); ?>
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


    <div id="show_modal" class="modal fade" role="dialog" style="background: #000;">
            <div class="modal-dialog" style="margin-top: 137px;">
                <div class="modal-content">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <form action="<?php echo base_url(); ?>Admin_TraficManager/store_payment_status" method="post">

                        <div class="modal-body">
                            <?php $approved = 1; ?>
                            <h4 style="margin-top: 50px;text-align: center;">Approve Payment Status</h4>
                            <input type="text" name="ftl_request_id" id="ftl_request_id" class="form-control" value="">
                            <br><br><label>Payment</label>
                            <input type="radio"  name="payment_status" value="Yes">Yes
                            <input type="radio"  name="payment_status" value="No">No
                            <input type="hidden" name='approved' value="<?php echo $approved;  ?>">

                        </div>
                        <button type="submit" name="submit" class="btn btn-success m-2">Approve</button>
                </div>
                </form>
            </div>
        </div>










    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');?>
   
   
</body>
<!-- END: Body-->