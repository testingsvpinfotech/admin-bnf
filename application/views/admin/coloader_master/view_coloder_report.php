<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">
    <style>
        .buttons-copy {
            display: none;
        }

        .buttons-csv {
            display: none;
        }

        /*.buttons-excel{display: none;}*/
        .buttons-pdf {
            display: none;
        }

        .buttons-print {
            display: none;
        }

        /*#example_filter{display: none;}*/
        .input-group {
            width: 60% !important;
        }
    </style>

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
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Coloder Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form role="form"
                                                action="<?php echo base_url(); ?>admin/list-coloader-report"
                                                method="get" enctype="multipart/form-data">
                                                <div class="form-row">

                                                    <div class="col-sm-2">
                                                        <label>CD No</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo (isset($post_data['cd_no'])) ? $post_data['cd_no'] : ''; ?>"
                                                            name="cd_no">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label>Manifest No</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo (isset($post_data['awb_no'])) ? $post_data['awb_no'] : ''; ?>"
                                                            name="awb_no">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="">From Date</label>
                                                        <input type="date" name="from_date"
                                                            value="<?php echo (isset($post_data['from_date'])) ? $post_data['from_date'] : ''; ?>"
                                                            id="from_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="">To Date</label>
                                                        <input type="date" name="to_date"
                                                            value="<?php echo (isset($post_data['to_date'])) ? $post_data['to_date'] : ''; ?>"
                                                            id="to_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="submit" class="btn btn-primary"
                                                            style="margin-top: 25px;" name="submit" value="Search">
                                                        <input type="submit" class="btn btn-primary"
                                                            style="margin-top: 25px;" name="submit"
                                                            value="Download Excel">
                                                        <a href="<?= base_url('admin/list-coloader-report'); ?>"
                                                            class="btn btn-primary" style="margin-top: 25px;">Reset</a>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="display table table-striped table-bordered layout-primary"
                                    data-sorting="true">
                                    <thead>
                                    <th scope='col'>Sr No.</th>
                                    <th scope='col'>Manifest ID</th>
                                    <th scope='col'>CD No</th>
                                    <th scope='col'>Coloader Name</th>
                                    <th scope='col'>Colodeer Contact No</th>
                                    <th scope='col'>Origin</th>
                                    <th scope='col'>Destination</th>
                                    <th scope='col'>CD crated Date & time</th>
                                    <th scope='col'>CD crated By</th>
                                    <th scope='col'>CD Status</th>
                                    <th scope='col'>Driver Name</th>
                                    <th scope='col'>Driver Contact</th>
                                    <th scope='col'>Vehical NO</th>
                                    <th scope='col'>Total Weight</th>
                                    <th scope='col'>Total Packet</th>
                                    <th scope='col'>Manifested Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php 
                                            
                                            if (!empty($domestic_allpoddata)) {
                                                $i = 0;
                                                foreach ($domestic_allpoddata as $value_d) {

                                                  ?>
                                                <td style="width:20px;">
                                                    <?php echo ($i + 1); ?>
                                                </td>
                                                <!-- <td style="width:40px;">
                                                    <?php echo date('d-m-Y', strtotime($value_d['booking_date'])); ?>
                                                </td> -->
                                                <td style="width:20px;">
                                                    <?php echo $value_d['manifiest_id']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['cd_no']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['coloader']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['coloder_contact']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['source_branch']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['destination_branch']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['cd_no_edited_date']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php echo $value_d['cd_no_edited_by']; ?>
                                                </td>                                                
                                                <td style="width:20px;">
                                                    <?php if($value_d['cd_status']=='1'){echo 'Received';}else{echo 'Pending';} ?>
                                                </td>
                                                <td style="width:20px;">
                                                    <?php echo $value_d['driver_name']; ?>
                                                </td>                                                   
                                                <td style="width:20px;">
                                                    <?php echo $value_d['contact_no']; ?>
                                                </td>                                                   
                                                <td style="width:20px;">
                                                    <?php echo $value_d['lorry_no']; ?>
                                                </td>                                                   
                                                <td style="width:20px;">
                                                    <?php echo $value_d['total_weight']; ?>
                                                </td>                                                   
                                                <td style="width:20px;">
                                                    <?php echo $value_d['total_pcs']; ?>
                                                </td>                                                   
                                                <td style="width:20px;">
                                                    <?php echo $value_d['date_added']; ?>
                                                </td>                                                   
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                            }

                                            ?>

                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $this->pagination->create_links(); ?>
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