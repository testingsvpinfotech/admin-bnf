<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">
    <script> var baseURL = '<?= base_url(); ?>';</script>
    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center"> <br><br>
                                <h4 class="card-title">Add AWB Branch Stock</h4>

                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <form role="form" id="form_submition">

                                        <div class="form-row">
                                            <div class="col-3 mb-3">
                                                <label for="username">Mode</label>
                                                <select name="mode" class="form-control" id="mode">
                                                    <option value=""> Select Mode</option>
                                                    <?php foreach ($mode as $key => $value) { ?>
                                                        <option value="<?= $value->transfer_mode_id; ?>">
                                                            <?= $value->mode_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="username">Series Form</label>
                                                <input type="number" name="series_form" id="series_form"
                                                    class="form-control" placeholder="Series Form">
                                                <span id="err" style="color:red;"></span>
                                                <input type="hidden" id="series_to_defualt">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="username">Series To</label>
                                                <input type="number" name="series_to" id="series_to"
                                                    class="form-control" placeholder="Series To">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="username">AWBS </label>
                                                <input type="text" name="awbs" id="awbs" class="form-control"
                                                    placeholder="AWBS" readonly>
                                            </div>

                                            <div class="col-12">
                                                <input type="submit" class="btn btn-primary" name="submit"
                                                    value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div> <br><br>

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
    //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

<script>
    $(document).ready(function () {

        $("#form_submition").validate({


            rules: {
                series_form: { required: true },
                series_to: { required: true },
                awbs: { required: true },
                mode: { required: true }
            },
            messages: {
                series_form: { required: "Enter Series Form" },
                series_to: { required: "Enter Series To" },
                awbs: { required: "Enter AWB NO" },
                mode: { required: "Enter Mode" }
            },
            submitHandler: function (form) {
                var series_to_defualt = $('#series_to_defualt').val();
                var series_to = $('#series_form').val();
                if (series_to_defualt < series_to) {
                    $.ajax({
                        url: baseURL + 'admin/add-stock',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function (response) {
                            console.log(response);
                            if (JSON.parse(response) == 1) {
                                window.location.href = baseURL + 'admin/stock-manager';
                            }
                        }
                    });
                } else {
                    alert('Please Add valid Series');

                    $('#series_form').val('');
                    $('#series_to').val('');
                    $('#awbs').val('');
                }
            }

        });

        $("#series_to").keyup(function () {
            var series_form = $('#series_form').val();
            var series_to = $('#series_to').val();
            var final = series_to - series_form + 1;
            if(final>0){
            $('#awbs').val(final);
            }else{
                $('#awbs').val(0);
            }
        });

        $('#mode').change(function () {
            var mode = $('#mode').val();
            console.log(mode);
            if (mode) {
                $.ajax({
                    type: 'POST',
                    url: 'Admin_stock_manager/get_stock_value',
                    data: 'mode=' + mode,
                    dataType: "json",
                    success: function (d) {
                        if (d.series_to != '') {
                            let y = 1;
                            let series_to_defualt = parseFloat(d.series_to) + y;
                            $('#series_to_defualt').val(d.series_to);
                            $('#series_form').val(series_to_defualt);
                        } else {
                           
                            $('#series_to_defualt').val(1);
                            $('#series_form').val(1);
                        }
                    }
                });

            }
        });
    });


</script>