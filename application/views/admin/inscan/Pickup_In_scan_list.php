<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
    .input:focus {
        outline: outline: aliceblue !important;
        border: 2px solid red !important;
        box-shadow: 2px #719ECE;
    }
</style>
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
                                <h4 class="card-title">Pickup IN-Scan list</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <table id="example" class="display table dataTable table-striped table-bordered" >
                                        <thead>
                                            <tr>
                                                <th>Sr.No.</th>
                                                <th>AWB No.</th>
                                                <th>Shipper Name </th>
                                                <th>Consignee</th>
                                                <th>Mode</th>
                                                <th>Booking From</th>
                                                <th>Destination</th>
                                                <th>To Pay</th>
                                                <th>Qty/Pcs</th>
                                                <th>Actual Wt</th>
                                                <th>Charged Wt</th>
                                                <th>Status</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (!empty($pickup_In_Scan_List)) { ?>
                                                <?php $i = 1; foreach ($pickup_In_Scan_List as $value) : ?>
                                                    <tr>
                                                        <td><?php echo $i++;?></td>
                                                        <td><?php echo $value['pod_no']; ?></td>
                                                        <td><?php echo $value['sender_name']; ?></td>
                                                        <td><?php echo $value['reciever_name']; ?></td>
                                                        <td><?php echo $value['mode_dispatch']; ?></td>
                                                        <td><?php echo $value['sender_city']; ?></td>
                                                        <td><?php echo $value['reciever_address']; ?></td>
                                                        <td><?php echo $value['dispatch_details']; ?></td>
                                                        <td><?php echo $value['no_of_pack']; ?></td>
                                                        <td><?php echo $value['actual_weight']; ?></td>
                                                        <td><?php echo $value['chargable_weight']; ?></td>
                                                        <td><?php echo $value['status']; ?></td>
                                                        <td><?php echo $value['pickup_inscan_comment']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="8">Data Not Found</td>
                                                </tr>
                                            <?php } ?>


                                        </tbody>

                                    </table>
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