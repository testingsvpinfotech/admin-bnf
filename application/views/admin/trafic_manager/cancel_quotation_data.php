<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

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
                                <h4 class="card-title">Cancel Requested List</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table  table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Vendor ID</th>
                                                <th scope="col">FTL Request Id</th>
                                                <th scope="col">Vendor Amount</th>
                                                <th scope="col">Advance Percentage</th>
                                                <th scope="col">Advance Amount</th>
                                                <th scope="col">Remaining Amount</th>
                                                <th scope="col">status</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($get_cancel_quotation)) {
                                                // print_r($get_quotation_list);
                                                $cnt = 1;
                                                foreach ($get_cancel_quotation as  $ct) {  ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $ct->vcode; ?></td>
                                                        <?php $ftid = $ct->ftl_request_id; $dd = $this->db->query("select * from ftl_request_tbl where id = '$ftid'")->row_array();?>
                                                        <td><?php echo $dd['ftl_request_id']; ?></td>
                                                        <td><?php echo $ct->vendor_amount; ?></td>
                                                        <td><?php echo $ct->advance_amount_percentage; ?></td>
                                                        <td><?php echo $ct->advance_amount; ?></td>
                                                        <td><?php echo $ct->remaining_amount; ?></td>

                                                        <?php $dd1 = $this->db->query("SELECT ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.id FROM `ftl_request_tbl`LEFT JOIN order_request_tabel ON ftl_request_tbl.id = order_request_tabel.ftl_request_id WHERE ftl_request_tbl.id ='$ct->id'")->row(); ?>
                                                        <td>
                                                            <?php if ($ct->trafic_approve_status == '2') { ?>
                                                                <button class="btn btn-danger">Cancel</button>
                                                            <?php } ?>
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
            </div>
            <!-- END: Listing-->
        </div>
        <style>
            /* .modal-open{overflow:hidden}
.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:hidden;-webkit-overflow-scrolling:touch;outline:0}
.modal.fade .modal-dialog{-webkit-transform:translate(0,-25%);-ms-transform:translate(0,-25%);-o-transform:translate(0,-25%);transform:translate(0,-25%);-webkit-transition:-webkit-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:-webkit-transform .3s ease-out;transition:transform .3s ease-out;transition:transform .3s ease-out,-webkit-transform .3s ease-out,-o-transform .3s ease-out}
.modal.in .modal-dialog{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);-o-transform:translate(0,0);transform:translate(0,0)}
.modal-open .modal{overflow-x:hidden;overflow-y:auto}
.modal-dialog{position:relative;width:auto;margin:10px}
.modal-content{position:relative;background-color:#fff;background-clip:padding-box;border:1px solid #999;border:1px solid rgba(0,0,0,.2);border-radius:6px;-webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);box-shadow:0 3px 9px rgba(0,0,0,.5);outline:0}
.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}
.modal-backdrop.fade{filter:alpha(opacity=0);opacity:0}
.modal-backdrop.in{filter:alpha(opacity=50);opacity:.5}
.modal-header{padding:15px;border-bottom:1px solid #e5e5e5}
.modal-header .close{margin-top:-2px}
.modal-title{margin:0;line-height:1.42857143}
.modal-body{position:relative;padding:15px}
.modal-footer{padding:15px;text-align:right;border-top:1px solid #e5e5e5}
.modal-footer .btn+.btn{margin-bottom:0;margin-left:5px}
.modal-footer .btn-group .btn+.btn{margin-left:-1px}
.modal-footer .btn-block+.btn-block{margin-left:0}
.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{-webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);box-shadow:0 5px 15px rgba(0,0,0,.5)}.modal-sm{width:300px}}@media (min-width:992px){.modal-lg{width:900px}} */
            .fade:not(.show) {
                opacity: 0.80;
            }
        </style>




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
                    // console.log(response);
                    $('#ftl_request_id').val(response.ftl_request_id); //hold the response in id and show on popup
                    $('#customer_name').val(response.customer_name);
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