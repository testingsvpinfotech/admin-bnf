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
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">All Franchise Fuel</h4>
                                <span style="float: right;"><a href="admin/view-franchise-add-fuel" class="fa fa-plus btn btn-primary">Add Fuel</a></span>
                            </div>
                            <div class="card-body">
                                <?php if ($this->session->flashdata('notify') != '') { ?>
                                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                <?php unset($_SESSION['class']);
                                    unset($_SESSION['notify']);
                                } ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sr.</th>
                                                <th scope="col">Group Name</th>
                                                <th scope="col">Fov Min</th>
                                                <th scope="col">Fov Above</th>
                                                <th scope="col">Fov Below</th>
                                                <th scope="col">Fov Base</th>
                                                <th scope="col">AWB Rate</th>
                                                <th scope="col">Fule Percentage</th>
                                                <th scope="col">COD Rate</th>
                                                <th scope="col">COD MIN</th>
                                                <th scope="col">COD percentage</th>
                                                <th scope="col">From Date</th>
                                                <th scope="col">To Date</th>
                                                 <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           
                                            $cnt = 1;
                                           //echo '<pre>'; print_r($fule_company);die;
                                            foreach ($fule_company as  $value) { ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $value->group_name; ?></td>
                                                <td><?php echo $value->fov_min; ?></td>
                                                <td><?php echo $value->fov_above; ?></td>
                                                <td><?php echo $value->fov_below; ?></td>
                                                <td><?php echo $value->fov_base; ?></td>
                                                <td><?php echo $value->awb_rate; ?></td>
                                                <td><?php echo $value->fule_percentage; ?></td>
                                                <td><?php echo $value->topay_rate; ?></td>
                                                <td><?php echo $value->cod_min; ?></td>
                                                <td><?php echo $value->cod_percentage; ?></td>
                                                <td><?php echo $value->from_date; ?></td>
                                                <td><?php echo $value->to_date; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>admin/view-franchise-edit-fuel/<?php echo $value->fuel_id; ?>" title="Edit"><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                                                    <a href="javascript:void(0);" title="Delete" class="deletedata" relid="<?php echo $value->fuel_id; ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                </td>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            } ?>
                                        </tbody>
                                    </table>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.deletedata').click(function() {
            var getid = $(this).attr("relid");
            // alert(getid);
            var baseurl = '<?php echo base_url(); ?>'
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                            url: baseurl + 'Admin_franchise_fuel/deletefuel',
                            type: 'POST',
                            data: 'getid=' + getid,
                            dataType: 'json'
                        })
                        .done(function(response) {
                            swal('Deleted!', response.message, response.status)

                                .then(function() {
                                    location.reload();
                                })

                        })
                        .fail(function() {
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        });
                }

            })

        });

    });
</script>

</html>