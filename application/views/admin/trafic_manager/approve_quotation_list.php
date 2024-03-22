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
                                <h4 class="card-title">Approve Requested List</h4>
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

                                <div class="table-responsive">
                                    <table class="table table-responsive table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Vendor ID</th>
                                                <th scope="col">FTL Request Id</th>
                                                <th scope="col">Pickup Location</th>
                                                <th scope="col">Drop Location</th>
                                                <th scope="col">Order Date</th>
                                                <th scope="col">Pickup Date Time</th>
                                                <th scope="col">Sales Approved Amount</th>
                                                <th scope="col">Vendor Amount</th>
                                                <th scope="col">Vehicle Number </th>
                                                <th scope="col">Driver Name</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">Trip Status</th>
                                                <th scope="col">Create Track Link</th>
                                                <th scope="col">Trip End</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (!empty($get_quotation_list)) {
                                                // print_r($get_quotation_list);
                                                $cnt = 1;
                                                foreach ($get_quotation_list as  $ct) {  ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $ct->vcode; ?></td>
                                                        <td><?php echo $ct->ftl_request_id; ?></td>
                                                        <td><?php echo $ct->pickup_address; ?></td>
                                                        <td><?php echo $ct->delivery_address; ?></td>
                                                        <td><?php echo $ct->order_date; ?></td>
                                                        <td><?php echo $ct->request_date_time; ?></td>
                                                        <td><?php echo $ct->total_amount; ?></td>
                                                        <td><?php echo $ct->vendor_amount; ?></td>
                                                        <td style="color:green"><?php echo $ct->vehicle_number; ?></td>
                                                        <td relid ="<?php echo $ct->driver_name; ?>" id ="create_trip"><?php echo $ct->driver_name; ?></td>
                                                       
                                                     

                                                        <?php $dd1 = $this->db->query("SELECT ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.id FROM `ftl_request_tbl`LEFT JOIN order_request_tabel ON ftl_request_tbl.id = order_request_tabel.ftl_request_id WHERE ftl_request_tbl.id ='$ct->id'")->row(); ?>
                                                        <td>
                                                            <?php if (!empty($ct->driver_name)) { ?>
                                                                <button class="btn btn-success">Approve</button>
                                                            <?php }else{ ?>
                                                                <button class="btn btn-danger">Pending Driver Details</button>
                                                            <?php  } ?>
                                                            <a href="<?php echo base_url('Admin_TraficManager/update_quotation_data/'.$ct->ftl_id);?>" class="btn btn-info">View</button></td>
                                                       
                                                   
                                                        <td>
                                                            <?php if ($dd1->create_trip_status == '2') { ?>
                                                                <button class="btn btn-danger">Trip Created</button>
                                                            <?php } else { ?>
                                                                       <?php if(!empty($ct->driver_name)){ ?>
                                                                       <form method="POST" action="<?php echo base_url('Track_Loication/Create_trip'); ?>">
                                                                       <input type="hidden" name="get_ftl_id" value="<?php echo $dd1->id; ?>">
                                                                       <input type="hidden" name="create_trip" value="1">
                                                                       <button class="btn btn-info">Create Trip</button>
                                                                       </form>
                                                                      <?php } else { ?>
                                                                         <button class="btn  btn-warning" id="createss_trip">Create Trip</button>
                                                                    
                                                                      <?php  } ?>   
                                                            <?php } ?>
                                                        </td>


                                                        <td>
                                                            <?php $fid = $ct->ftl_request_id; $dd = $this->db->query("select * from ftl_tracking_link_tbl where ftl_request_id = '$fid'")->row_array(); ?>
                                                            <?php if(empty($dd['tracking_link'])){?>
                                                            <button class ="btn btn-primary create_link" relid ="<?php echo $ct->ftl_request_id; ?>">Create Link</button>
                                                            <?php }else{ ?>
                                                           <a href="<?php echo $dd['tracking_link'];?>" target="_blank" class ="btn btn-danger">Open link</a>
                                                             <?php }?> 
                                                        </td>


                                                        <td>
                                                            <?php $fid = $ct->ftl_request_id; $dd = $this->db->query("select * from ftl_request_tbl where ftl_request_id = '$fid'")->row_array(); ?>
                                                            <?php if($dd['trip_end'] == '1'){?>
                                                                <button class ="btn btn-danger">Trip Ended</button>
                                                            <?php }else{ ?>
                                                                <button class ="btn btn-success trip_end" relid ="<?php echo $ct->ftl_request_id; ?>" >Trip End</button>
                                                             <?php }?> 
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
        
            .fade:not(.show) {
                opacity: 0.80;
            }
        </style>




        <div id="myModal" class="modal fade" role="dialog" style="background: #000;">
            <div class="modal-dialog" style="margin-top: 137px;">
                <div class="modal-content">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <form action="<?php echo base_url(); ?>Track_Loication/create_tracking_link" method="post">

                        <div class="modal-body">
                      
                            <input type="text" name="ftl_request_id" class="form-control" id="ftl_request_id">
                            <div class="form-group mt-2">
                               <input type="text" name='vehicle_number' placeholder="Enter Vehicle Number" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success m-2">Create</button>
                </div>
                </form>
            </div>
        </div>


        <!-- *********************************** Trip End ***************************************** -->

        <div id="myModal1" class="modal fade" role="dialog" style="background: #000;">
            <div class="modal-dialog" style="margin-top: 137px;">
                <div class="modal-content">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <h4>Trip End </h4>
                    <form action="<?php echo base_url(); ?>Track_Loication/ftl_trip_end" method="post">

                        <div class="modal-body">
                      
                            <input type="text" name="ftl_request_id" class="form-control"  id="ftl_request_id1">
                            <div class="form-group mt-2">
                               <input type="text" name='vehicle_number' placeholder="Enter Vehicle Number" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success m-2">submit</button>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <!-- START: Footer-->

    <script type="text/javascript">



$('#createss_trip').click(function() {
    var drivers_name = $("#create_trip").attr('relid');
    //alert(drivers_name)
    if(drivers_name == ''){
        Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Driver Details Mandatory For Create Trip!!',
                    showConfirmButton: true
                      }).then(function(){
                     window.location.reload();
                   });  
    }

});


        $('.create_link').click(function() {
            var id = $(this).attr('relid'); //get the attribute value
           // alert(id);

            $.ajax({
                url: "<?php echo base_url(); ?>Admin_TraficManager/get_ftl_id",
                data: {
                    id: id
                },
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    //response =  JSON.parse(response1);
                  console.log(response.ftl_request_id);
                    $('#ftl_request_id').val(response.ftl_request_id); //hold the response in id and show on popup
                    $('#myModal').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                    });
                }
            });
        });
        $('.trip_end').click(function() {
            var id = $(this).attr('relid'); //get the attribute value
            //alert(id);

            $.ajax({
                url: "<?php echo base_url(); ?>Admin_TraficManager/get_ftl_id",
                data: {
                    id: id
                },
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    //response =  JSON.parse(response1);
                  console.log(response.ftl_request_id);
                    $('#ftl_request_id1').val(response.ftl_request_id); //hold the response in id and show on popup
                    $('#myModal1').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                    });
                }
            });
        });
    </script>
</body>
<!-- END: Body-->