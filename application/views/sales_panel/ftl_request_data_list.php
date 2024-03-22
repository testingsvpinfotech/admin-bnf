<?php include('admin_shared/admin_header.php'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->
    <?php include('admin_shared/admin_sidebar.php'); ?>
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
                                <h4 class="card-title">FTL Request List</h4>
                            </div>
                            <?php // print_r($this->session->all_userdata());?>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <!-- id="example"-->
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th scope="col">Request ID</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Customer ID</th>
                                                <th scope="col">Order Date</th>
                                                <th scope="col">Request Date</th>
                                                <th scope="col">Origin Pincode</th>
                                                <th scope="col">Origin City</th>
                                                <th scope="col">Destination City </th>
                                                <th scope="col">Destination Pincode</th>
                                                <th scope="col">Vehicle Name</th>
                                                <th scope="col">Vehicle Capacity</th>
                                                <th scope="col">Vehicle body Type</th>
                                                <th scope="col">Goods Name</th>
                                                <th scope="col">Goods Weight</th>
                                                <th scope="col">Weight Type</th>
                                                <th scope="col">Pickup Address</th>
                                                <th scope="col">Contact Number</th>
                                                <th scope="col">Delivery Address</th>
                                                <th scope="col">Delivery Contact Number</th>
                                                <th scope="col">Delivery Contact Person Name</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Commission Amount</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Loading</th>
                                                <th scope="col">UnLoading</th>
                                                <th scope="col">Time Limit</th>
                                                <th scope="col">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (!empty($ftl_request_data)) {
                                                $cnt = 1;
                                                foreach ($ftl_request_data as $value) : ?>
                                                    <tr>
                                                        <td><?php echo  $cnt++; ?></td>
                                                        <td><?php echo $value['ftl_request_id']; ?></td>
                                                        <td><?php echo $value['customer_name']; ?></td>
                                                        <td><?php echo $value['customer_id']; ?></td>
                                                        <td><?php echo $value['order_date']; ?></td>
                                                        <td><?php echo $value['request_date_time']; ?></td>
                                                        <td><?php echo $value['origin_pincode']; ?></td>
                                                        <?php $origin_city = $value['origin_city'] ; $dd5 = $this->db->query("select city from city where id = '$origin_city'")->row_array();?> 
                                                        <td><?php echo $dd5['city']; ?></td>
                                                        <td><?php echo $value['destination_city']; ?></td>
                                                        <td><?php echo $value['destination_pincode']; ?></td>
                                                        <td><?php echo $value['vehicle_name']; ?></td>
                                                        <td><?php echo $value['vehicle_capacity']; ?></td>
                                                        <td><?php echo $value['vehicle_body_type']; ?></td>
                                                        <td><?php $goods_id = $value['goods_type']; ?>
                                                            <?php $dd = $this->db->query("select goods_name from goods_type_tbl where id ='$goods_id'")->row();
                                                            echo  $dd->goods_name; ?></td>
                                                        <td><?php echo $value['goods_weight']; ?></td>
                                                        <td><?php echo $value['weight_type']; ?></td>
                                                        <td><?php echo $value['pickup_address']; ?></td>
                                                        <td><?php echo $value['contact_number']; ?></td>
                                                        <td><?php echo $value['delivery_address']; ?></td>
                                                        <td><?php echo $value['delivery_contact_no']; ?></td>
                                                        <td><?php echo $value['delivery_contact_person_name']; ?></td>
                                                        <td style="color:blue"><?php echo $value['amount']; ?></td>
                                                        <td><?php echo $value['commissinon_amount']; ?></td>
                                                        <td><?php echo $value['total_amount']; ?></td>
                                                        <td><?php echo $value['loading_type']; ?></td>
                                                        <td><?php echo $value['unloading_type']; ?></td>
                                                        <td style="color:red";><?php echo $value['time_limit']; ?></td>
                                                        <td>
                                                            <?php if ($value['status'] == 0) { ?><button class="btn btn-warning getamount" relid="<?php echo $value['ftl_request_id']; ?>">Pending</button> <?php } elseif ($value['status'] == 1) { ?>
                                                                <button class="btn btn-success">Approved </button>
                                                                <!-- <a href="<?php echo base_url(); ?>Admin_sales/send_vendor_mail" class="btn btn-danger">Send Mail</a> -->
                                                            <?php } else { ?> <button class="btn btn-danger"> Cancel </button> <?php } ?>
                                                        </td>


                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="10" style="color:red;">No Data Found</td>
                                                </tr>
                                            <?php } ?>

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
    </main>

<style>
    .fade:not(.show) {
    opacity: 0.80;
}
</style>
   
    <div id="show_modal" class="modal fade" role="dialog" style="background: #000;">
        <div class="modal-dialog" style="margin-top:110px;">
            <div class="modal-content">
                <div class="modal-header">

                    <h3 style="font-size: 24px; color: #17919e; text-shadow: 1px 1px #ccc;"><i class="fa fa-folder"></i>FTL Request data</h3>
                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>FTL Request Id</label>
                                    <input type="text" name="ftl_request_id" id="ftl_request_id" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input type="text" id="customer_name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Enter Time Limit</label>
                                    <?php  $date = date('Y-m-d H:i:s', time()); ?>       
                                    <input  id ="time_limit" type="text"  name="time_limit" value="<?php echo $date; ?>" readonly>
                                    <!-- <input type="date" name="time_limit"  id ="time_limit" placeholder="Enter Time Limit For Posted Truck Order" class="form-control"> -->
                                </div>
                                <!-- <div class="col-md-4"> -->
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control">
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Commission</label>
                                    <select class="form-control" id="select_amount">
                                        <option>Select Commission Type</option>
                                        <!-- <option value="1">Amount</option> -->
                                        <option value="2">Percentage</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" id="c_amount" style="display:none">
                                <div class="form-group">
                                    <label>Commission Amount </label>
                                    <input type="text" name="commissinon_amount"  id="comm_amount" class="form-control commissinon_amount " placeholder="Enter Amount">
                                </div>
                            </div>

                            <div class="col-md-4" id="p_amount" style="display:none">
                                <div class="form-group">
                                    <label>Commission Amount </label>
                                    <input type="text" name="commissinon_amount" class="form-control commissinon_amount" id="per_amount" placeholder="Enter Percentage Amount">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Amount </label>
                                    <input type="text" name="total_amount" id="total" class="form-control total_amount">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <?php $approved = 1;
                   // $cancel = 2; ?>

                    <button type="submit" class="btn btn-success" id="approved" relid="<?php echo $approved;  ?>">Approved</button>
                    <!-- <button type="submit" class="btn btn-warning" id="cancel" relid="<?php echo $cancel;  ?>">Cancel</button> -->
                </div>
            </div>
        </div>
    </div>

    <style>
        label {
            display: inline-block;
            margin-top: 14px;
            margin-bottom: 0.5rem;
        }
    </style>



    <?php include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>

<!-- END: Body-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(document).ready(function() {

        $('#datatable').DataTable({
            "aLengthMenu": [
                [2, 4, 8, -1],
                [2, 4, 8, "All"]
            ],
            "iDisplayLength": 10,
        });

        $('.getamount').click(function() {

            var id = $(this).attr('relid'); //get the attribute value
            // alert(id);

            $.ajax({
                url: "<?php echo base_url(); ?>Admin_sales/get_ftl_request_data",
                data: {
                    id: id
                },
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#ftl_request_id').val(response[0].ftl_request_id); //hold the response in id and show on popup
                    $('#customer_name').val(response[0].customer_name);
                    $('#amount').val(response[0].amount);
                    $('#show_modal').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                    });
                }
            });
        });


        $('#approved,#cancel').click(function() {

            var approved = $(this).attr('relid');
            var cancel = $(this).attr('relid');
           // alert(approved);


            $.ajax({
                url: "<?php echo base_url(); ?>Admin_sales/update_request_data",
                method: 'POST',
                dataType: 'json',
                data: {
                    time_limit : $('#time_limit').val(),
                    ftl_request_id: $('#ftl_request_id').val(),
                    amount: $('#amount').val(),
                    commissinon_amount: $('.commissinon_amount').val(),
                    total_amount: $('.total_amount').val(),
                    approved: approved,
                  //  cancel: cancel,


                },
                success: function(response) {
                    $('message').val(response.message)
                    location.reload();
                   // window.location.href = "<?php echo base_url();?>Admin_sales/set_time_for_ftl";
                }
            });
        });



        $('#select_amount').on('change', function() {

            var select_a = $(this).val();
            // alert(select_a);
            if (select_a == 1) {
                $('#c_amount').show();
                $('#p_amount').hide();


                //    var cm =  $('#comm_amount').val();
                //    var a =  $('#amount').val();
                //     var s  = cm + a;
                //     alert(s);
                // $('#total').val(s);

            } else if (select_a == 2) {
                $('#p_amount').show();
                $('#c_amount').hide();

                //   var pa =  $('#per_amount').val();
                //   var a =  $('#amount').val();
                //   var per =  (a/100)*pa;
                //   alert(per);

                //    $('#total').val(per);
            }

            $('#comm_amount, #amount').on('blur',function() {
                var value1 = parseFloat($('#comm_amount').val()) || 0;
                var value2 = parseFloat($('#amount').val()) || 0;
                var value4 = value2 - value1;
                   value3  = (value2*10)/100;
                   value5  = (value4)/100;
                   alert(value5);
                if(value3 >= value5){
                //var d = value3 / 100 * value2
                $('#total').val(value2 - value1);

            }else{
                // alert ('Max advance Amount 90%');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Entered Amount should be more than 10%',
                    showConfirmButton: true
                                  }).then(function(){
                                      window.location.reload();
                 });
            }
            });

            $('#per_amount, #amount').on('blur',function() {
                var value1 = parseFloat($('#amount').val()) || 0;
                var value2 = parseFloat($('#per_amount').val()) || 0;
                if( value2 >= '10'){
                var d = value1 / 100 * value2
                $('#total').val(value1 - d);

            }else{
                // alert ('Max advance Amount 90%');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Entered Amount should be more than 10%',
                    showConfirmButton: true
                                  }).then(function(){
                                      window.location.reload();
                 });
                
              
            }
            });

        });



    });
</script>