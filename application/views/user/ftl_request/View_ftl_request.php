<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->
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
<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->

    <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
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
                                <h4 class="card-title">FTL Request List</h4>
                                <!--  <span style="float: right;"><a href="admin/view-add-domestic-shipment" class="fa fa-plus btn btn-primary">Add Domestic Shipment</a></span> -->
                                <span style="float: right;">
                                    <a href="User_panel/ftl_request_data" class="btn btn-primary">Add FTL Request</a>
                                </span>
                            </div>
                            <div class="col-md-10 card">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class=" table  table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th scope="col">Request ID</th>
                                                <th scope="col">Order Date</th>
                                                <th scope="col">Request Date</th>
                                                <th scope="col">Origin Pincode</th>
                                                <th scope="col">Origin City</th>
                                                <th scope="col">Destination City </th>
                                                <th scope="col">Destination Pincode</th>
                                                <th scope="col">Vehicle Name</th>
                                                <th scope="col">Vehicle Capacity</th>
                                                <th scope="col">Pickup Address</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Delivery Address</th>
                                                <th scope="col">Loading</th>
                                                <th scope="col">UnLoading</th>
                                                <th scope="col">Delivery Contact Person Name</th>
                                                <th scope="col">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (!empty($ftl_request_data)) {
                                                $cnt = 1; 
                                                foreach ($ftl_request_data as $value) : ?>
                                                    <tr>
                                                        <td><?php echo  $cnt++; ?></td>
                                                        <td><?php echo $value['ftl_request_id']; ?>
                                                        <td><?php echo $value['order_date']; ?></td>
                                                        <td><?php echo $value['request_date_time']; ?></td>
                                                        <td><?php echo $value['origin_pincode']; ?></td>
                                                        <?php $origin_city = $value['origin_city'] ; $dd5 = $this->db->query("select city from city where id = '$origin_city'")->row_array();?> 
                                                        <td><?php echo $dd5['city']; ?></td>
                                                        <td><?php echo $value['destination_city']; ?></td>
                                                        <td><?php echo $value['destination_pincode']; ?></td>
                                                        <td><?php echo $value['vehicle_name']; ?></td>
                                                        <td><?php echo $value['vehicle_capacity']; ?></td>
                                                        <td><?php echo $value['pickup_address']; ?></td>
                                                        <td><?php echo $value['contact_number']; ?></td>
                                                        <td><?php echo $value['delivery_address']; ?></td>
                                                        <td><?php echo $value['loading_type']; ?></td>
                                                        <td><?php echo $value['unloading_type']; ?></td>
                                                        <td><?php echo $value['delivery_contact_person_name']; ?></td>
                                                        <td>
                                                            <?php if ($value['trafic_approve_status'] == 0) { ?>
                                                                <button class="btn btn-warning">Pending</button> 
                                                            <?php } if ($value['trafic_approve_status'] == 1 ) { ?>
                                                                   <button class="btn btn-success">Approved</button>
                                                                   <?php  if ($value['eway_image']) { ?>
                                                                      <button class="btn btn-danger">Ewaybill/Invoice</button>
                                                                     <?php } else { ?>
                                                                      <a href="<?php echo base_url("User_panel/upload_ewaybill/".$value['id']);?>" class="btn btn-info">Ewaybill/invoice</a> 
                                                                    <?php } ?>
                                                           <?php } else { ?>
                                                            <button class="btn btn-danger">Cancel</button> 
                                                            <?php } ?>
                                                        </td>
                                                        <td>

                                                        </td>


                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="10" style="color:red;">No Data Found</td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                        <input type="hidden" name="selected_campaing" id="selected_campaingss" value="">
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

    <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

</html>