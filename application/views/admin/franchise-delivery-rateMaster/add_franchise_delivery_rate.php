<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->

    <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <style>
        .form-group {
            margin-top: 10px;
        }
    </style>
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Add Delivery Rate Master</h4>
                                <span style="float: right;"><a href="admin/view-franchise-delivery-ratemaster" class="fa fa-plus btn btn-primary">View Delivery rate</a></span>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <form role="form" action="admin/franchise-delivery-ratemaster" method="post">
                                                <div class="box-body">

                                                <div class="form-group row">
                                                    <label for="ac_name" class="col-sm-1 col-form-label">Group Name</label>
                                                    <div class="col-sm-4">
                                                    <select class="form-control" name="group_id" required>
                                                        <option value="0">Select Group</option>
                                                        <?php foreach ($all_customer as $cc) { ?>
                                                        <option value="<?php echo $cc['id']; ?>"><?php echo $cc['group_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <br>

                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <h6>Doc</h6>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">Doc Per Kg</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="doc_per_kg" value="" placeholder="Enter Doc Per KG" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">Doc Min</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="doc_min" value="" placeholder="Enter Doc for Min" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <h6>NON-Doc</h6>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">Per Kg</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="Non_doc_per_kg" value="" placeholder="Enter Non-doc Per KG" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">Non-Doc Min</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="Non_doc_min" value="" placeholder="Enter Non-Doc for min" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <h6>COD</h6>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">COD Min</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="cod_min" value="" placeholder="Enter COD Min" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label"> COD %</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="cod_percentage" value="" placeholder="Enter COD %" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <h6>To Pay</h6>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">TO Pay Min</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="to_pay_min" value="" placeholder="Enter To Pay Min" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">To Pay %</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="to_pay_percentage" value="" placeholder="Enter To Pay % " required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                            <h6>Date</h6>
                                                        </div>
                                                        <label for="ac_name" class="col-sm-1 col-form-label">From Date</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" name="from_date" value="" required>
                                                        </div>

                                                        <label for="ac_name" class="col-sm-1 col-form-label">TO date</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" name="to_date" value="" required>
                                                        </div>

                                                    </div>

                                                    </br></br>
                                                    <div class="col-md-2">
                                                        <div class="box-footer">
                                                            <button type="submit" name="save" class="btn btn-primary">Submit </button>
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
<!-- END: Body-->


</html>