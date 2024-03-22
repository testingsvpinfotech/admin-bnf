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
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Route Planner</h></span>
                        </div>
                    
                        <div class="card-content">
                            <button class="btn btn-primary float-right"><a href="<?php echo base_url('admin/route-planner');?>">Back</a></button>
                            <div class="card-body">
                           <?php if (!empty($this->session->flashdata('msg'))) {?>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                    <?php } ?>
                                <div class="row">
                                    <div class="col-12">
                                        <form role="form" action="<?php echo base_url('Route_planner/update_route_planner_data/'.$show_data['id']);?>" method="post">

                                            <div class="form-row">
                                                <div class="col-3 mb-3">
                                                    <label for="username">Route Name</label>
                                                    <input type="text" class="form-control" name="route_name" placeholder="Route Name" value="<?php echo $show_data['route_name'] ;?>" required>
                                                </div>

                                                <div class="col-2 mb-3">
                                                    <label for="username">City </label> <br>
                                                    <?php echo $show_data['city_id'];?>
                                                    <select name="city_id[]" id="state_id" onchange="return select_city(this.value)" class="form-control multiselect-container multiple_state" multiple>
                                                        <?php
                                                        if (!empty($city)) {
                                                            foreach ($city as $st_value) {
                                                        ?>
                                                        <option <?php if($st_value['city'] == $show_data['city_id'] ){ echo 'selected="selected"'; } ?> value="<?php echo $st_value['city'] ?>"><?php echo $st_value['city'];?> </option>
                                                              
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="" id="showcity"></label>
                                                    <!-- <input type="text" id="showcity"> -->
                                                </div>

                                                <div class="col-12">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                </div>
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
    <?php $this->load->view('admin/admin_shared/admin_footer');
    //include('admin_shared/admin_footer.php'); 
    ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

</html>
<script type="text/javascript">
    function select_city(state_id) {
        var state_id = $('#state_id').val();
        //    $('#showcity').val(state_id);
        $('#showcity').text(state_id);
        $.ajax({
            type: 'POST',
            url: 'Admin_region/getStatewiseCity',
            data: {
                state_id: state_id
            },
            dataType: "json",
            success: function(d) {
                $('#city_id').html(d);
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
        maxHeight: 250
    });
</script>

<script>