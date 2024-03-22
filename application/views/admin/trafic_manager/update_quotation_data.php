<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJfzOqR9u2eyXv6OaiuExD3jzoBGGIVKY&libraries=geometry,places&v=weekly"></script>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
<!-- END Head-->
<style>
    .form-control {
        color: black !important;
        border: 1px solid var(--sidebarcolor) !important;
        height: 27px;
        font-size: 10px;
    }

    .select2-container--default .select2-selection--single {
        background: lavender !important;
    }

    /*.frmSearch {border: 1px solid #A8D4B1;background-color: #C6F7D0;margin: 2px 0px;padding:40px;border-radius:4px;}*/
    /*#city-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 7;}*/
    /*#city-list li{padding: 10px; background: #F0F0F0; border-bottom: #BBB9B9 1px solid;}*/
    /*#city-list li:hover{background:#ece3d2;cursor: pointer;}*/
    /*#reciever_city{padding: 10px;border: #A8D4B1 1px solid;border-radius:4px;}*/
    form .error {
        color: #ff0000;
    }

    .compulsory_fields {
        color: #ff0000;
        font-weight: bolder;
    }

    .select2-container *:focus {
        border: 1px solid #3c8dbc !important;
        border-radius: 8px 8px !important;
        background: #ffff8f !important;
    }

    input:focus {
        background-color: #ffff8f !important;
    }

    select:focus {
        background-color: #ffff8f !important;
    }

    textarea:focus {
        background-color: #ffff8f !important;
    }

    .btn:focus {
        color: red;
        background-color: #ffff8f !important;
    }


    input,
    textarea {
        text-transform: uppercase;
    }

    ::-webkit-input-placeholder {
        /* WebKit browsers */
        text-transform: none;
    }

    :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        text-transform: none;
    }

    ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        text-transform: none;
    }

    :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        text-transform: none;
    }

    ::placeholder {
        /* Recent browsers */
        text-transform: none;
    }
</style>
<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->

    <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->

    <style>
        span .fa {
            color: red;
            font-size: 8px;
            position: relative;
            top: -5px;
            margin-top: 16px;
        }
    </style>
    <main>
        <div class="container-fluid site-width">


            <!-- START: Card Data-->
            <div class="row" style="margin-top: 100px;">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row p-2">


                                <div class="col-12 col-md-12 mt-3">
                                    <div class="card p-4">
                                        <div class="card-body">



                                            <form action="<?php echo base_url('Admin_TraficManager/update_quotation_data/' . $quotation_data['ftlId']); ?>" enctype="multipart/form-data" method="POST">

                                                <?php // echo base_url('Admin_TraficManager/update_quotation_data/'.$quotation_data['ftl_id']);
                                                ?>
                                                <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                                    <h6 class="mb-0 text-uppercase font-weight-bold">Update Quotation List</h6>
                                                </div>
                                                <input type="hidden" name="ftl_id" class="form-control" value="<?php echo $quotation_data['ftl_id']; ?>" placeholder="Enter Pincode">
                                                <input type="hidden" name="vendor_customer_id" class="form-control" value="<?php echo $quotation_data['vendor_customer_id']; ?>" placeholder="Enter Pincode">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>

                                                                <tr>
                                                                    <th scope="col">Vendor ID</th>
                                                                    <td><?php echo $quotation_data['vcode']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">FTL Request Id</th>
                                                                    <td><?php echo $quotation_data['ftl_request_id']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Pickup Location</th>
                                                                    <td><?php echo $quotation_data['pickup_address']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Drop Location</th>
                                                                    <td><?php echo $quotation_data['delivery_address']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Order Date</th>
                                                                    <td><?php echo $quotation_data['order_date']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Pickup Date Time</th>
                                                                    <td><?php echo $quotation_data['request_date_time']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">GPS</th>
                                                                    <td><?php echo $quotation_data['vehicle_gps']; ?></td>
                                                                </tr>
                                                                <?php $vehical_id = $quotation_data['type_of_vehicle'];
                                                                $vehical_name = $this->db->query("select vehicle_name from vehicle_type_master  where id = '$vehical_id'")->row_array(); ?>
                                                                <tr>
                                                                    <th scope="col">Vehicle Type</th>
                                                                    <td><?php echo $vehical_name['vehicle_name']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Vehicle Capacity</th>
                                                                    <td><?php echo $quotation_data['vehicle_capacity']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Vehicle Floor Type</th>
                                                                    <td><?php echo $quotation_data['vehicle_floor_type']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Vehicle Body Type</th>
                                                                    <td><?php echo $quotation_data['vehicle_body_type']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Loding Type</th>
                                                                    <td><?php echo $quotation_data['loading_type']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Unloading Type</th>
                                                                    <td><?php echo $quotation_data['unloading_type']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">loding Charges</th>
                                                                    <td><?php echo $quotation_data['loding_charges']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Unloading Charges</th>
                                                                    <td><?php echo $quotation_data['Unloding_charges']; ?></td>
                                                                </tr>


                                                                </tbody>
                                                        </table>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Vehicle Wheel Type</th>
                                                                    <td><?php echo $quotation_data['vehicle_wheel_type']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Goods Type</th>
                                                                    <?php $goods_id = $quotation_data['goods_type'];
                                                                    $goods_name = $this->db->query("select goods_name from goods_type_tbl where id ='$goods_id'")->row_array(); ?>
                                                                    <td><?php echo $goods_name['goods_name']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Goods Weight</th>
                                                                    <td><?php echo $quotation_data['goods_weight']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Sales Approved Amount</th>
                                                                    <td><?php echo $quotation_data['total_amount']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Vendor Amount</th>
                                                                    <td><?php echo $quotation_data['vendor_amount']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Advance Percentage</th>
                                                                    <td><?php echo $quotation_data['advance_amount_percentage']; ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Advance Amount</th>
                                                                    <td><?php echo $quotation_data['advance_amount']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Remaining Amount</th>
                                                                    <td><?php echo $quotation_data['remaining_amount']; ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="col">Vehicle Number</th>
                                                                    <td><?php echo $quotation_data['vehicle_number']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Driver Name</th>
                                                                    <td><?php echo $quotation_data['driver_name']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Driver Contact Number</th>
                                                                    <td><?php echo $quotation_data['driver_contact_number']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Driver Licence</th>
                                                                    <td><?php echo $quotation_data['driver_licence']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col"> RC book</th>
                                                                    <td><a href="assets/ftl_documents/vendor_rc-book/<?php echo $quotation_data['rc_book']; ?>" download><img src ="assets/ftl_documents/vendor_rc-book/<?php echo $quotation_data['rc_book']; ?>" style="width:100px;"></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Ending Trip Date Time</th>
                                                                    <td><?php echo $quotation_data['ending_time']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col">Ping Time </th>
                                                                    <td><?php echo $quotation_data['ping_time']; ?></td>
                                                                </tr>

                                                                <?php $qid = $quotation_data['id'];
                                                                $dd1 = $this->db->query("SELECT ftl_request_tbl.trafic_approve_status,ftl_request_tbl.create_trip_status,ftl_request_tbl.id FROM `ftl_request_tbl`LEFT JOIN order_request_tabel ON ftl_request_tbl.id = order_request_tabel.ftl_request_id WHERE ftl_request_tbl.id = '$qid'")->row(); ?>

                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                        </div>

                                        <?php if (empty($quotation_data['ping_time'])) { ?>

                                            <hr>
                                            <div class="row mt-2">

                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Driver Name <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                        <input type="text" name="driver_name" class="form-control" value ="<?php echo $quotation_data['driver_name']; ?>" placeholder="Enter driver Name ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Driver Phone Number <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                        <input type="text" name="driver_contact_number" value ="<?php echo $quotation_data['driver_contact_number']; ?>" placeholder="Enter Driver Contact Number" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Vehicle Number <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></label>
                                                        <input type="text" class="form-control" name="vehicle_number" value ="<?php echo $quotation_data['vehicle_number']; ?>" placeholder="Enter Vehicle Number" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Driver Licence <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></label>
                                                        <input type="text" class="form-control" name="driver_licence" value ="<?php echo $quotation_data['driver_licence']; ?>" placeholder="Enter Driver Licence Number" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">RC Book <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></label>
                                                        <input type="file" class="form-control" name="rc_book">
                                                        <p><?php echo $quotation_data['rc_book']; ?></p>
                                                    </div>
                                                </div>
                                           

                                              
                                                </div>

                                             <div class= "row mt-2">
                                                <?php if (empty($quotation_data['ending_time'])) { ?>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Ending Trip Date Time <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="datetime-local" name="ending_time" class="form-control" required>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Ping Time <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <!-- <input type="time" name="ping_time" placeholder="3:20:00" class="form-control" required> -->
                                                    <select name="ping_time" class="form-control" required>
                                                        <option value="">Select Ping Time</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                   
                                                </div>
                                                <?php } ?>
                                            </div>


                                            <div class="row mt-2">
                                                <?php if ($quotation_data['loading_type']=='vendor') { ?>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Loding Charges<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="loding_charges" class="form-control" >
                                                </div>
                                             <?php }?>
                                             <?php if ($quotation_data['unloading_type']=='vendor') { ?>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Unoding Charges<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="unloding_charges" class="form-control" >
                                                </div>
                                                <?php } ?>
                                           </div>     

                                               
                                            
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <button type="submit" name="submit" class="btn  btn-lg btn-primary mt-2">Submit</button>
                                                </div>
                                            </div>
                                            <?php }?>
                                       
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
        </div>

    </main>

    </main>
    <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

<script src="assets/js/domestic_shipment.js"></script>


</html>