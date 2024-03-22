<?php $this->load->view('user/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->
    <?php $this->load->view('user/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12">
                    <div class="box-body">
                        <div class="form-group row">

                            <div class="col-12  align-self-center">
                                <div class="col-12 col-sm-12 mt-3">
                                    <div class="card">
                                        <div class="card-header justify-content-between align-items-center">
                                            <h4 class="card-title">Download Multiple POD</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form role="form"
                                                        action="<?php echo base_url('User_panel/view_multipale_pod_download'); ?>"
                                                        method="post" autocomplete="off">
                                                        <div class="form-row">
                                                            <!-- <div class="col-md-2">
                                                                <input type="text" class="form-control"
                                                                    name="filter_value" />
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select class="form-control" name="filter">
                                                                    <option value="pod_no">Pod
                                                                        No</option>
                                                                </select>
                                                            </div> -->

                                                            <div class="col-sm-2">
                                                                <input type="date" name="from_date" id="from_date"
                                                                    autocomplete="off" class="form-control" value="<?php if(! empty($_POST['from_date'])){echo $_POST['from_date']; } ?>">
                                                            </div>



                                                            <div class="col-sm-2">
                                                                <input type="date" name="to_date" id="to_date"
                                                                    autocomplete="off" class="form-control" value="<?php if(! empty($_POST['to_date'])){echo $_POST['to_date']; } ?>">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="submit" class="btn btn-primary"
                                                                    name="submit" value="Filter">
                                                                <a href="<?php echo base_url('User_panel/view_multipale_pod_download'); ?>"
                                                                    class="btn btn-info">Reset</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-lg-12">
                                            <h6> View Pod</h6>
                                           
                                            <table id="example1"
                                                class="display table dataTable table-striped table-bordered layout-primary"
                                                data-sorting="true">
                                                <thead>
                                                    <tr>
                                                        <th>SR No</th>
                                                        <th>AWB No</th>
                                                        <th>Deliveryboy Id</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 0;
                                                    if (!empty($pod)) {
                                                        foreach ($pod as $value) {
                                                            $count++
                                                                ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $count; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $value->pod_no; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $value->deliveryboy_id; ?>
                                                                </td>
                                                                <td><a
                                                                        href="<?= base_url('users/pod_download/' . $value->image); ?>" style="color:#fff;">Download</a>
                                                                </td>
                                                            </tr>

                                                        <?php }
                                                    }else{ ?>
                                                    <tr> <td colspan="4"> No Record Found</td></tr>
                                                    <?php }?>
                                                </tbody>
                                                
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('user/admin_shared/admin_footer');
    //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->