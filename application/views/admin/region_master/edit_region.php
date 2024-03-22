<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<style>
    .form-control {
        color: black !important;
        border: 1px solid var(--sidebarcolor) !important;
        height: 27px;
        font-size: 10px;
    }
</style>
<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <?php if ($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1) { ?>
                                <h4 class="card-title">Edit Domestic Zone</h4>
                            <?php } else { ?>
                                <h4 class="card-title">Domestic Zone</h4>
                            <?php } ?>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                <?php if ($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1) { ?>
                                    <div class="col-12">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>admin/edit-region/<?php echo $rgn->region_id; ?>"
                                            method="post" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <div class="col-4 mb-3">
                                                    <label for="username">Zone</label>
                                                    <input type="text" class="form-control" name="region_name"
                                                        placeholder="Zone" value="<?php echo $rgn->region_name; ?>"
                                                        required>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <label>State</label>
                                                    <select name="state_id[]" id="state_id"
                                                        onchange="return select_city(this.value)"
                                                        class="form-control multiselect-container multiple_state"
                                                        multiple>
                                                        <?php
                                                        if (!empty($state_list)) {
                                                            foreach ($state_list as $st_value) {
                                                                ?>
                                                                <option value="<?php echo $st_value['id']; ?>" <?php echo (in_array($st_value['id'], $state_array)) ? 'selected' : ''; ?>>
                                                                    <?php echo $st_value['state']; ?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-4 mb-3">
                                                    <label>City</label>
                                                    <select name="city_id[]" id="city_id" class="form-control city_change" multiple>
                                                        <?php
                                                        if (!empty($city_array)) {
                                                            foreach ($city_array as $key => $st_value) {
                                                                ?>
                                                                <option value="<?php echo $key; ?>" selected><?php echo $st_value; ?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <input type="submit" class="btn btn-primary" name="submit"
                                                    value="Submit">
                                            </div>
                                            </form> <?php } ?>
                                    </div>
                                   
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Zone</th>
                                                        <th scope="col">State</th>
                                                        <th scope="col">City</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $rgn_detail = $this->basic_operation_m->get_query_result('select * from region_master_details left join city on city.id=region_master_details.city where regionid=' . $rgn->region_id . ' ');
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $rgn->region_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php


                                                            foreach ($rgn_detail as $key => $value) {
                                                                $whr = array('id' => $value->state_id);
                                                                $state_name = $this->basic_operation_m->get_table_row('state', $whr);
                                                                echo "<br>" . $state_name->state;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($rgn_detail as $key => $value) {
                                                                echo "<br>" . $value->city;
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

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
    //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

</html>
<script type="text/javascript">
    function select_city(state_id) {
        var val = $('#state_id').val();
        // if(val==''){
        //     $('#city_id'). html('');
        // }
        $.ajax({
            type: 'POST',
            url: 'Admin_region/getStatewiseCityedit',
            data: 'state_id=' + val,
            dataType: "json",
            success: function (d) {
              //  $('#city_id'). html('');
                $('#city_id').append(d);
                $('#city_id').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    maxHeight: 150
                });

                $('#city_id').multiselect('rebuild');
            }
        });

    }

    function checkAll(ele) {
        // var checkboxes = document.getElementsByTagName('input');
        var checkboxes = document.getElementsByName('multiple_select_city[]');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }
    function checkAll_state(ele) {
        //      var checkboxes = document.getElementsByTagName('input');
        // alert(checkboxes);
        var checkboxes = document.getElementsByName('multiple_select_state[]');

        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }


    $('#state_id').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        maxHeight: 150
    });


    $('#city_id').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        maxHeight: 150
    });

</script>