<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Pincode Service</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <form role="form" action="<?php echo base_url(); ?>admin/pincode-service-status"
                                            method="post" autocomplete="off">
                                            <div class="form-row">
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control"
                                                        value="<?php echo (!empty($_POST))?$_POST['filter_value']:''; ?>" name="filter_value" />
                                                </div>

                                                <div class="col-sm-2">
                                                    <input type="submit" class="btn btn-primary btn-sm" name="submit"
                                                        value="Search">
                                                    <a href="<?= base_url('admin/pincode-service-status'); ?>"
                                                        class="btn btn-info btn-sm">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                   
                                        <!--//==============-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                   
                                                    <div class="table-responsive">
                                                        <table id="example1"
                                                            class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Pincode</th>
                                                                    <th>State</th>
                                                                    <th>City</th>
                                                                    <th>Service Type</th>
                                                                    <th>Zone</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php                              
                                                                if (!empty($pincode_service)) {    ?>
                                                                            <tr>

                                                                                <td>
                                                                                    <?php echo $pincode_service['pincode']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $pincode_service['state']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $pincode_service['city']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $pincode_service['service_type']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $pincode_service['zone']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $pincode_service['branch']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if($pincode_service['status']==1){ ?>
                                                                                        <button type="button" class="btn-sm btn btn-danger">Deactivated</button>
                                                                                    <?php }else{?>
                                                                                        <button type="button" class="btn-sm btn btn-primary">Active</button>
                                                                                    <?php }?>
                                                                                </td>
                                                                               
                                                                            </tr>
                                                                            <?php
                                                                        
                                                                    }
                                                                else {
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="7"class="text-center">Data Not Found</td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                    </form>
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