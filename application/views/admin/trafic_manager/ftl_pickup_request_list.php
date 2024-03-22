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
                                <h4 class="card-title">Pickup request List</h4>
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
                                                <th scope="col">Id</th>
                                                <th scope="col">FTL Request No</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Vendor Customer Name</th>
                                                <th scope="col">Pickup Pincode</th>
                                                <th scope="col">Destination Pincode</th>
                                                <th scope="col">Pickup Location</th>
                                                <th scope="col">Destination Location</th>
                                                <th scope="col">Pickup Date Time</th>
                                                <th scope="col">Driver Name</th>
                                                <th scope="col">Driver Contact Number</th>
                                                <th scope="col">Vehicle No</th>
                                                <th scope="col">status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($get_pickup_request_list)) {
                                              
                                                $cnt = 1;
                                                foreach ($get_pickup_request_list as  $ct) {  ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $ct->ftl_request_id; ?></td>
                                                        <td><?php echo $ct->customer_name; ?></td>
                                                        <td><?php echo $ct->vendor_name; ?></td>
                                                        <td><?php echo $ct->origin_pincode; ?></td>
                                                        <td><?php echo $ct->destination_pincode; ?></td>
                                                        <td><?php echo $ct->pickup_address; ?></td>
                                                        <td><?php echo $ct->delivery_address; ?></td>
                                                        <td><?php echo $ct->request_date_time; ?></td>
                                                        <td><?php echo $ct->driver_name; ?></td>
                                                        <td><?php echo $ct->driver_contact_number; ?></td>
                                                        <td><?php echo $ct->vehicle_number; ?></td>
                                                        <td><?php if($ct->status == '1'){ ?><button class = "btn btn-success">Approve</button> <?php }?></td>
                                                        <td><a href="<?php echo base_url("admin/upload-trip-documents/".$ct->id);?>"class="btn btn-info">Update Pickup Documents</a></td>
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
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
    //include('admin_shared/admin_footer.php'); 
    ?>
   
</body>
<!-- END: Body-->