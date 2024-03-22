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
                    <div class="col-12 col-sm-12" style="margin-top: 4rem;">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">Pickup Charges</h4><span style="float: right;"></span>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                                    <?php echo $this->session->flashdata('msg'); ?>
                                                <?php } ?>
                                                </div>
                                        </div>
                                       <?php //print_r($pickup_rate);?>
                                        <div class="col-12">
                                            <form role="form" action="<?= base_url(); ?>admin/update-pickup-charges-master/<?php echo $pickup_rate[0]['id'];?> " method="post">
                                                <div class="box-body">
                                                    <div class=" row">
                                                        <div class="col-sm-2">
                                                            <label>From Weight</label>
                                                            <input class="form-control" name="from_weight" value="<?php echo $pickup_rate[0]['weight_from'];?>" required placeholder="Enter From Weight"/>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label>To Weight</label>
                                                            <input class="form-control" name="to_weight" value="<?php echo $pickup_rate[0]['weight_to'];?>" required placeholder="Enter To Weight"/>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label>Rate</label>
                                                            <input class="form-control" name="pickup_rate" value="<?php echo $pickup_rate[0]['rate'];?>" required placeholder="Enter Rate"/>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label>Type</label>
                                                            <select class="form-control" name="weight_type" required>
                                                                <option value="">Please Select</option>
                                                                <option value="0" <?php if($pickup_rate[0]['weight_type'] == '0'){ echo 'selected';}?>>Fixed</option>
                                                                <!-- <option value="1">Addition 250GM</option>
                                                                <option value="2">Addition 500GM</option> -->
                                                                <option value="3" <?php if($pickup_rate[0]['weight_type'] == '3'){ echo 'selected';}?>>Addition 1000GM</option> 
                                                                <option value="4" <?php if($pickup_rate[0]['weight_type'] == '4'){ echo 'selected';}?>>Per KG</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 mt-3">
                                                            <button type="submit" name="submit" class="btn btn-primary m-2">update</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END: Listing-->
            </div>
        </div>
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->

    <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->