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
                                <h4 class="card-title">All Group Name</h4>
                                <span style="float: right;"><a href="admin/commission-master-add-group" class="fa fa-plus btn btn-primary">Add Group</a></span>
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
                                                <th scope="col">Booking Commission </th>
                                                <th scope="col">Pickup Charges</th>
                                                <th scope="col">Delivery Commission</th>
                                                <th scope="col">Door Delivery Share Amt</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           
                                            $cnt = 1;
                                            foreach ($groups as  $value) { ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $value['group_name']; ?></td>
                                                <td><?php echo $value['booking_commission']; ?></td>
                                                <td><?php echo $value['pickup_charges']; ?></td>
                                                <td><?php echo $value['booking_commission']; ?></td>
                                                <td><?php echo $value['door_delivery_share']; ?></td>
                                    
                                                <td>
                                                    <a href="<?php echo base_url(); ?>admin/commission-master-edit/<?php echo $value['group_id']; ?>" title="Edit"><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                                                    <a href="javascript:void(0);" title="Delete" class="deletedata" relid="<?php echo $value['group_id']; ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
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

    <script>
    $(document).ready(function() {
        $('.deletedata').click(function() {
            var getid = $(this).attr("relid");
             alert(getid);
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
                            url: baseurl + 'admin/commission-master-delete/' + getid,
                            type: 'POST',
                            // data: 'getid=' + getid,
                            // dataType: 'json'
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
</body>
</html>