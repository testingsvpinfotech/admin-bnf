<!-- Content -->
<div class="page-content">
    <style>
        .thead1 th {
            color: #ffffff;
        }

        .thead1 {
            background-color: #f65923;
        }
    </style>
    <!-- Client logo -->
    <div class="section-full dez-we-find bg-img-fix m-t50 p-b50" style="margin-top: 70px;">
        <div class="container">
            <div class="section-content">
                <div class="row ">
                    <h3 class="form-title m-t0" style="color: #e8501c;padding: 20px;">Quotation List </h3>
                    <div class="col-md-12">

                        <?php if (!empty($this->session->flashdata('msg'))) { ?>
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">X</button>
                                <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                        <?php } ?>

                        <table class="table  table-responsive tabel-striped table-bordered" style="font-family: emoji;">
                            <thead>
                                <?php // print_r($this->session->all_userdata());
                                ?>
                                <tr class="thead1">
                                    <!-- <th>Sr. No.</th> -->
                                    <th>Order No</th>
                                    <th>Pickup Location</th>
                                    <th>Drop Location</th>
                                    <th>Pickup date time</th>
                                    <th>Vehicle Capacity</th>
                                    <th>Vehicle Type</th>
                                    <th>Goods Type</th>
                                    <th>Goods Weight</th>
                                    <th>GPS</th>
                                    <th>Amount</th>
                                    <th>Advance Amount Percentage</th>
                                    <th>Advance Amount</th>
                                    <th>Remaining Amount</th>
                                    <th>Driver Name</th>
                                    <th>Driver Contact Number</th>
                                    <th>vehicle Number</th>
                                    <th>status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php // echo '<pre>'; print_r($request_list_from_vendor);
                                ?>
                                <?php if (!empty($request_list_from_vendor)) { ?>
                                    <?php $i = 1;

                                    foreach ($request_list_from_vendor as $value) : ?>
                                        <tr>
                                            <!-- <td><?php // echo $i++; ?> </td> -->
                                            <td><?php echo $value['ftl_request_id']; ?> </td>
                                            <td><?php echo $value['pickup_address']; ?> </td>
                                            <td><?php echo $value['delivery_address']; ?> </td>
                                            <td><?php echo $value['request_date_time']; ?> </td>
                                            <td><?php echo $value['vehicle_capacity']; ?> </td>
                                            <?php $vehicle_name =  $value['type_of_vehicle'];
                                            $dd1 = $this->db->query("select vehicle_name from vehicle_type_master where id = '$vehicle_name'")->row_array(); ?>
                                            <td><?php echo $dd1['vehicle_name']; ?> </td>
                                            <?php $goods_type =  $value['goods_type'];
                                            $dd = $this->db->query("select goods_name from goods_type_tbl where id = '$goods_type'")->row_array(); ?>
                                            <td><?php echo $dd['goods_name']; ?> </td>
                                            <td><?php echo $value['goods_weight']; ?> <?php echo $value['weight_type']; ?> </td>
                                            <td><?php echo $value['vehicle_gps']; ?> </td>
                                            <td><?php echo $value['vendor_amount']; ?> </td>
                                            <td><?php echo $value['advance_amount_percentage']; ?> </td>
                                            <td><?php echo $value['advance_amount']; ?> </td>
                                            <td><?php echo $value['remaining_amount']; ?> </td>
                                            <?php $vc_id = $this->session->userdata('customer_id');
                                            $ftl_request_id = $value['ftl_request_id'];
                                            $dd = $this->db->query("select ftl_request_tbl.driver_name,ftl_request_tbl.driver_contact_number,ftl_request_tbl.vehicle_number from order_request_tabel left join ftl_request_tbl ON ftl_request_tbl.id = order_request_tabel.ftl_request_id where ftl_request_tbl.vc_id = '$vc_id' AND ftl_request_tbl.ftl_request_id = '$ftl_request_id' AND ftl_request_tbl.trafic_approve_status = '1'")->row_array(); ?>

                                            <td><?php echo $dd['driver_name']; ?> </td>
                                            <td><?php echo $dd['driver_contact_number']; ?> </td>
                                            <td><?php echo $dd['vehicle_number']; ?> </td>
                                            <td>

                                                <?php if ($value['trafic_approve_status'] == '1') { ?>
                                                    <button class="btn btn-success">Approve</button>
                                                      <?php if ($value['vehicle_number']){?>
                                                        <button class="btn btn-muted">Driver Details Updated</button>
                                                            <?php }else{?>
                                                            <a href="<?php echo base_url('update-driver-data/' . $value['ftl_request_id']); ?>" class="btn btn-info">Update Driver Details</a>
                                                        <?php }?>
                                                <?php } if ($value['trafic_approve_status'] == '2') { ?>

                                                    <button class="btn btn-danger">Cancel</button>

                                                <?php } ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="8" style="color:red; text-align:center;">No Quotation </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
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
    <!-- Client logo END -->
</div>
<!-- Content END-->
<style>
    .blink_data {
        animation: blinker 1s linear infinite;
        font-weight: normal;
        color: #e95421;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>