<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->

<!-- START: Body-->

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        .error {
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: #dc3545;
        }
    </style>
</head>

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
                                <h4 class="card-title">Add Group</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form id="commission_master" method="post" action="">
                                                <div class="box-body">
                                                <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">Group
                                                            Name</label>
                                                        <div class="col-sm-4">        
                                                            <input type="text" id="group_name" class="form-control" <?php echo set_value('group_name'); ?> name="group_name">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">Booking Commission (%)</label>
                                                        <div class="col-sm-3">
                                                        <input class="form-control" type="text" id="booking_commission" <?php echo set_value('booking_commission'); ?> name="booking_commission">
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">Pickup Charges </label>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="pickup_charges" class="form-control" <?php echo set_value('pickup_charges'); ?> name="pickup_charges">
                                                        </div>

                                                        <label  for="ac_name" class="col-sm-1 col-form-label">Delivery Commission (%)</label>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="delivery_commission" class="form-control" <?php echo set_value('delivery_commission'); ?> name="delivery_commission">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="ac_name" class="col-sm-1 col-form-label">Door Delivery Share Amt </label>
                                                        <div class="col-sm-3">
                                                        <input type="text" id="door_delivery" class="form-control"  <?php echo set_value('door_delivery'); ?> name="door_delivery">
                                                        </div>
                                                        </div>
                                                    <br><br>
                                                    <div class="col-md-2">
                                                        <div class="box-footer">
                                                            <button type="submit" name="save"
                                                                class="btn btn-primary">Add Group</button>
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
<!-- <script>
    $('document').ready(function () {
        $('#group').select2();
        $('#fule,#below,#above,#cod').blur(function () {
            if ($('#fule').val() > 100) {
                $('#fule').val('');
            }
            if ($('#below').val() > 100) {
                $('#below').val('');
            }
            if ($('#above').val() > 100) {
                $('#above').val('');
            }
            if ($('#cod').val() > 100) {
                $('#cod').val('');
            }
        });
    });
</script> -->
<!-- END: Body-->

</html>