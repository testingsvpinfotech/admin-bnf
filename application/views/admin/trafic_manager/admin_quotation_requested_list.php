<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
    .fade:not(.show) {
    opacity: 1;
}
</style>
<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <!-- END: Main Menu-->
    <style>
        .table.layout-primary tbody td:last-child {
            background-color: #ffffff;
            color: aliceblue;
        }
    </style>
    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Quotation Requested List</h4>
                            </div>
                            <div class="col-md-6">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="card-body">

                            <form role="form" action="admin/quation-requested-list" method="post" enctype="multipart/form-data">
										<div class="form-row m-3">
										
											<div class="col-md-3">
												<label for="">FTL Request No.</label>
												<input type="text" class="form-control" value="<?php echo (isset($ftl_No)) ? $ftl_No : ''; ?>" name="ftl_No" />
											</div>

                                            <div class="col-sm-3">
												<label for="">Minimum bid Amount</label>
												<input type="text" name="minimum_bid_amount" value="<?php echo (isset($minimum_bid_amount)) ? $minimum_bid_amount : ''; ?>" id="minimum_bid_amount" autocomplete="off" class="form-control">
											</div>

											<div class="col-sm-3">
												<label for=""> Max bid Amount</label>
												<input type="text" name="max_bid_amount" value="<?php echo (isset($max_bid_amount)) ? $max_bid_amount : ''; ?>" id="max_bid_amount" autocomplete="off" class="form-control">
											</div>

											
											<div class="col-sm-2">
												<input type="submit" class="btn btn-primary mt-4" name="submit" value="Filter">
												
												<a href="<?php echo base_url('admin/quation-requested-list');?>" class="btn btn-info mt-4">Reset</a>
											</div>
										</div>
									</form>

                                <div class="table-responsive">
                                    <table  class="display table  table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col">Id</th> -->
                                                <!-- <th scope="col"style="display:none">Order ID</th> -->
                                                <th scope="col">FTL Request Id</th>
                                                <th scope="col">Pickup Location</th>
                                                <th scope="col">Drop Location</th>
                                                <th scope="col">Pickup Date Time</th>
                                                <th scope="col">Sales Approved Amount</th>
                                                <th scope="col">Vendor Amount</th>
                                                <th scope="col">Advance Percentage</th>
                                                <th scope="col">Advance Amount</th>
                                                <th scope="col">Remaining Amount</th>
                                                <th scope="col">Vendor Name</th>
                                                <th scope="col">Vendor Code</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($get_quotation_list)) {
                                              
                                                $cnt = 1;
                                                foreach ($get_quotation_list as  $ct) {  ?>
                                                    <tr>
                                                        <!-- <td><?php // echo $cnt; ?></td> -->
                                                        <!-- <td style="display:none"><?php // echo $ct->id; ?></td> -->
                                                        <td><?php echo $ct->ftl_request_id; ?></td>
                                                        <td><?php echo $ct->pickup_address; ?></td>
                                                        <td><?php echo $ct->delivery_address; ?></td>
                                                        <td><?php echo $ct->request_date_time; ?></td>
                                                        <td><?php echo $ct->total_amount; ?></td>
                                                        <td><?php echo $ct->vendor_amount; ?></td>
                                                        <td><?php echo $ct->advance_amount_percentage; ?></td>
                                                        <td><?php echo $ct->advance_amount; ?></td>
                                                        <td><?php echo $ct->remaining_amount; ?></td>
                                                        <?php $vid = $ct->vendor_customer_id; $fid =$ct->ftl_request_id;?>
                                                        <?php // $dd1 = $this->db->query("SELECT ftl_request_tbl.trafic_approve_status,ftl_request_tbl.driver_name FROM `order_request_tabel`LEFT JOIN ftl_request_tbl ON ftl_request_tbl.id = order_request_tabel.ftl_request_id WHERE ftl_request_tbl.vc_id ='$vid' AND ftl_request_tbl.ftl_request_id='$fid'")->row_array(); ?>
                                                        <?php //$dd1 = $this->db->query("SELECT ftl_request_tbl.trafic_approve_status FROM `ftl_request_tbl` WHERE  ftl_request_tbl.ftl_request_id='$fid'")->row_array(); ?>
                                                        <?php $vcode = $ct->vcode; $dd3 = $this->db->query("SELECT vendor_name FROM `vendor_customer_tbl` WHERE  vcode ='$vcode'")->row_array();?>
                                                        
                                                        <td><?php echo $dd3['vendor_name']; ?></td>
                                                        <td><?php echo $ct->vcode; ?></td>
                                                        
                                                    
                                                         <td>
                                                            <?php if($ct->trafic_approve_status == '1'){?>
                                                                <button class="btn btn-success">Approve</button>

                                                            <?php } else if( $ct->trafic_approve_status  == '0'){  ?>
                                                           
                                                                <button class="btn btn-warning approve_status" relid="<?php echo $ct->id; ?>">Pending</button>
                                                            
                                                             <?php } else if( $ct->trafic_approve_status == '2') { ?>
                                                                
                                                                <button class="btn btn-danger">Cancel</button>

                                                            <?php }?>

                                                                <!-- <a href="<?php  // echo base_url('Admin_TraficManager/update_quotation_data/'.$ct->id);?>" class="btn btn-info">Update Driver Details</button> -->
                                                            
                                                        </td>
                                                      
                                                    </tr>
                                            <?php
                                                    $cnt++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php  echo $this->pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END: Listing-->
        </div>

        <div id="show_modal" class="modal fade" role="dialog" style="background: #000;">
            <div class="modal-dialog" style="margin-top: 137px;">
                <div class="modal-content">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <form action="<?php echo base_url(); ?>Admin_TraficManager/update_status" method="post">

                        <div class="modal-body">
                            <?php $approved = 1; ?>
                            <h4 style="margin-top: 50px;text-align: center;">Are you sure, do you Want to Approve the Quotation ?</h4>
                            <input type="hidden" name="ftl_request_id" id="ftl_request_id" value="">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="vendor_customer_id" id="vendor_customer" value="">
                            <input type="hidden" name='approved' value="<?php echo $approved;  ?>">

                        </div>
                        <button type="submit" name="submit" class="btn btn-success m-2">Approve</button>
                </div>
                </form>
            </div>
        </div>


    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
    //include('admin_shared/admin_footer.php'); 
    ?>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $('.approve_status').click(function() {
            var id = $(this).attr('relid'); //get the attribute value
            alert(id);

            $.ajax({
                url: "<?php echo base_url(); ?>Admin_TraficManager/get_ftl_data",
                data: {
                    id: id
                },
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    //response =  JSON.parse(response1);
                    console.log(response.vendor_customer_id);
                    $('#ftl_request_id').val(response.ftl_request_id); //hold the response in id and show on popup
                    $('#vendor_customer').val(response.vendor_customer_id);
                    $('#amount').val(response.amount);
                    $('#id').val(response.id);
                    $('#show_modal').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                    });
                }
            });
        });
    </script>
    <!-- START: Footer-->
</body>
<!-- END: Body-->