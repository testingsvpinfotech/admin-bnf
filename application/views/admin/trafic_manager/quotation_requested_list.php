<!-- Content -->
<div class="page-content">

    <!-- Client logo -->
    <div class="section-full dez-we-find bg-img-fix m-t50 p-b50" style="margin-top: 70px;">
        <div class="container">
            <div class="section-content">
                <div class="row card">
                <h3 class="form-title m-t0" style="color: #e8501c;padding: 20px;">POST TRUCK List </h3>
                    <div class="col-md-12" style="box-shadow: 2px 3px 10px 5px rgb(0 0 0 / 9%);">
                        <table class="table table-bordered">
                            <thead>
                               
                            <tr>
                                    <th>Sr. No.</th>
                                    <th>Pickup Location</th>
                                    <th>Drop Location</th>
                                    <th>Pickup date time</th>
                                    <th>Vehicle Capacity</th>
                                    <th>Vehicle Type</th>
                                    <th>Goods Type</th>
                                    <th>Goods Weight</th>
                                    <th>GPS</th>
                                    <th>Amount</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php // echo '<pre>'; print_r($request_list_from_vendor);?>
                                <?php if (!empty($request_list_from_vendor)) { ?>
                                    <?php $i = 1;
                                  
                                    foreach ($request_list_from_vendor as $value) : ?>
                                        <tr>
                                            <td><?php echo $i++; ?> </td>
                                            <td><?php echo $value['pickup_address']; ?> </td>
                                            <td><?php echo $value['delivery_address']; ?> </td>
                                            <td><?php echo $value['request_date_time']; ?> </td>
                                            <td><?php echo $value['vehicle_capacity']; ?> </td>
                                            <?php $vehicle_name =  $value['type_of_vehicle'] ; $dd1 = $this->db->query("select vehicle_name from vehicle_type_master where id = '$vehicle_name'")->row_array(); ?>
                                            <td><?php echo $dd1['vehicle_name']; ?> </td>
                                            <?php $goods_type =  $value['goods_type'] ; $dd = $this->db->query("select goods_name from goods_type_tbl where id = '$goods_type'")->row_array(); ?>
                                            <td><?php echo $dd['goods_name'] ; ?> </td>
                                            <td><?php echo $value['goods_weight']; ?> <?php echo $value['weight_type']; ?> </td>
                                            <td><?php echo $value['vehicle_gps']; ?> </td>
                                            <td><?php echo $value['goods_weight']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="8" style="color:red; text-align:center;">No Posted Vehicle</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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