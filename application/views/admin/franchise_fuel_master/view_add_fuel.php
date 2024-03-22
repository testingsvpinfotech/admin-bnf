<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->

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
                <div class="col-12">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Add Franchise Fuel</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form role="form" action="admin/franchise-insert_fuel" method="post">
                                                <div class="box-body">
                                                    <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">Group
                                                            Name</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="cf_id" id="group"
                                                                required>
                                                                <option value="0">Select Group</option>
                                                                <?php foreach ($all_customer as $cl) {
                                                                    if(!empty($cl['booking_bill_type'])){
                                                                        $shipment_type = $cl['group_name'].' -- '.bill_type[$cl['booking_bill_type']];
                                                                    }else{
                                                                        $shipment_type = $cl['group_name'];
                                                                    }
                                                                    
                                                                    ?>
                                                                    
                                                                    <option value="<?php echo $cl['id']; ?>"><?php echo $shipment_type; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">FOV Min Amt
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="fov_min" value="" placeholder="Enter FOV Min Amt"
                                                                required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">FOV Above Inv. Amt. (%)</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="fov_above" value="" id="above"
                                                                placeholder="Enter Fov Above" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">FOV Below Inv. Amt. (%)
                                                            </label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="fov_below" value="" id="below"
                                                                placeholder="Enter Fov Below " required>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">FOV Invoice Base Amt.</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="fov_base" value=""
                                                                placeholder="Enter FOV Invoice Base Amt" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">AWB</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="awb_rate" value="" placeholder="Enter AWB Rate"
                                                                required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">Fule
                                                            %</label>
                                                        <div class="col-sm-3">
                                                            <!-- <input type="text" class="form-control" name="cod_rate" value="" placeholder="Enter COD Rate" required> -->
                                                            <input type="number" step="any" class="form-control"
                                                                name="fule_percentage" value="" id ="fule"
                                                                placeholder="Enter Fule %" required>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="ac_name"
                                                            class="col-sm-1 col-form-label">ToPay</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="topay_rate" placeholder="Enter COD Rate" value=""
                                                                required>
                                                        </div>
                                                        <label for="ac_name" class="col-sm-1 col-form-label">COD
                                                            Min</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="cod_min" placeholder="Enter COD Min" value=""
                                                                required>
                                                        </div>
                                                        <label for="ac_name" class="col-sm-1 col-form-label">COD
                                                            %</label>
                                                        <div class="col-sm-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="cod_percentage" value="" id="cod" placeholder="Enter COD %"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">From Date
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" name="from_date"
                                                                value="" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">To
                                                            Date</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" name="to_date"
                                                                value="" required>
                                                        </div>

                                                    </div>
                                                    <br><br>
                                                    <div class="col-md-2">
                                                        <div class="box-footer">
                                                            <button type="submit" name="save"
                                                                class="btn btn-primary">Add Rate</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                            </form>
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
<script>
$('document').ready(function() {
    $('#group').select2();
    $('#fule,#below,#above,#cod').blur(function(){
       if($('#fule').val() > 100){
        $('#fule').val('');
       }
       if($('#below').val() > 100){
        $('#below').val('');
       }
       if($('#above').val() > 100){
        $('#above').val('');
       }
       if($('#cod').val() > 100){
        $('#cod').val('');
       }
    });
});
</script>
<!-- END: Body-->

</html>