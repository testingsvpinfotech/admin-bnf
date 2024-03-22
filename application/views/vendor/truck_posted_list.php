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
                                        <th>Vehicle Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Capacity</th>
                                        <th>Fuel Type</th>
                                        <th>Vehicle Model</th>
                                        <th>Vehicle PUC Date</th>
                                        <th>Vehicle Insurance date</th>
                                        <th>Vehicle Permit Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($Vehicle_list)) { ?>
                                        <?php $i = 1;
                                        foreach ($Vehicle_list as $value) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?> </td>
                                                <td><?php echo $value['vehicle_name']; ?> </td>
                                                <td><?php echo $value['vehicle_number']; ?> </td>
                                                <td><?php echo $value['capicty']; ?> </td>
                                                <td><?php echo $value['fuel_type']; ?> </td>
                                                <td><?php echo $value['vehicle_model']; ?> </td>
                                                <td><?php echo $value['vehicle_puc_date']; ?> </td>
                                                <td><?php echo $value['vehicle_insurance_renw']; ?> </td>
                                                <td><?php echo $value['vehicle_prmit_date']; ?> </td>
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