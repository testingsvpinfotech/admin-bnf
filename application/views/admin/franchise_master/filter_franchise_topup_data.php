<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <!-- END: Main Menu-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row p-2">
                        <!-- <div class="col-md-6">
                            <h6 class=""><i class="fas fa-star mr-2"></i>Company Profile</h6>
                        </div> -->
                        <hr>
                    </div>

                    <div class="col-12 col-md-12" style="margin-top: 50px;">
                        <div class="card p-4">
                            <div class="card-body">
                                <form action="<?php echo base_url(); ?>admin/filter-franchise-topup"
                                    enctype="multipart/form-data" method="POST">
                                    <div class=""
                                        style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Filter Franchise Topup</h6>
                                        <a href="<?php echo base_url('admin/view-franchise-topup-data'); ?>"
                                            class="btn float-right"
                                            style="margin-top: -25px; color: #fff;background-color: #ea6335;">view
                                            Franchise Topup </a>
                                    </div>
                                    <div class="row mt-2">

                                        <div class="col-md-2 form-group">
                                            <label>All</label>
                                            <select class="form-control" name="filter" required>
                                                <!-- <option selected disabled>Select Filter</option> -->
                                                <option value="1" <?php echo (isset($$_POST['filter']) && $$_POST['filter'] == 'ALL') ? 'selected' : ''; ?>>ALL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Franchise ID</label>
                                            <input type="text" class="form-control" name="franchise_id"
                                                placeholder="Enter Franchise ID" value="<?php if(!empty($_POST['franchise_id'])){ echo $_POST['franchise_id']; } ?>">
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label>Payment Type</label>
                                            <select class="form-control" name="payment_type" required>
                                                <option selected disabled>Select Filter</option>
                                                <option value="UPI" <?php echo (isset($_POST['payment_type']) && $_POST['payment_type'] == 'UPI') ? 'selected' : ''; ?>>UPI</option>
                                                <option value="NEFT" <?php echo (isset($_POST['payment_type']) && $_POST['payment_type'] == 'NEFT') ? 'selected' : ''; ?>>NEFT</option>
                                                <option value="CASH" <?php echo (isset($_POST['payment_type']) && $_POST['payment_type'] == 'CASH') ? 'selected' : ''; ?>>CASH</option>
                                                <option value="Cheque" <?php echo (isset($_POST['payment_type']) && $_POST['payment_type'] == 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
                                                <option value="RTGS" <?php echo (isset($_POST['payment_type']) && $_POST['payment_type'] == 'RTGS') ? 'selected' : ''; ?>>RTGS</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label>From Date</label>
                                            <input type="date" class="form-control" name="from_date" value="<?php if(!empty($_POST['from_date'])){ echo $_POST['from_date']; } ?>">
                                        </div>

                                        <div class="col-md-2">
                                            <label>To Date</label>
                                            <input type="date" class="form-control" name="to_date" value="<?php if(!empty($_POST['to_date'])){ echo $_POST['to_date']; } ?>">
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary mt-2">Submit</button>
                                    <?php if (!empty($topup_details)) { ?>
                                    <input type="submit" name="download_excel" class="btn btn-primary mt-2" value="Download Excel">
                                    <?php } ?>
                                    <a href="<?php echo base_url('admin/filter-franchise-topup'); ?>"
                                        class="btn btn-danger mt-2">Reset </a>
                                </form>


                              <br>
                                <div class="table-responsive">
                                    <table  class="display table table-bordered"
                                        data-sorting="true">
                                        <thead>
                                        <?php   if (!empty($topup_details)) { foreach ($topup_details1 as $cust1) { ?>
                                                    <tr>
                                                        <td style="color:red; background-color: #fff; text-align:text;" colspan="3">Total Credit Amount
                                                            :-
                                                            <?php echo $cust1['total_amt']; ?>
                                                        </td>
                                                        <td style="color:red; background-color: #fff; text-align:text;" colspan="3">Total Debit Amount
                                                            :-
                                                            <?php echo number_format((float)$debit_amount['total_amt'], 2, '.', ''); ?>
                                                        </td>
                                                        <td style="color:red; background-color: #fff; text-align:text;" colspan="4">Total Balance Amount
                                                            :-
                                                            <?php
                                                             
                                                            echo number_format((float)$balance_amount['wallet'], 2, '.', ''); ?>
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                            <tr>
                                                <th scope="col">SrNo</th>
                                                <th scope="col">F.Code</th>
                                                <th scope="col">Transaction ID</th>
                                                <th scope="col">Transaction Date</th>
                                                <th scope="col"> Credit Amount</th>
                                                <th scope="col"> Debit Amount</th>
                                                <th scope="col"> Balance Amount</th>
                                                <th scope="col">Payment Mode</th>
                                                <th scope="col">Bank name</th>
                                                <th scope="col">Refrence Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php
                                        
                                            if (!empty($topup_details)) {
                                                $customer = $topup_details[0]['customer_id'];
                                                $balance_amount = $this->db->query("select * from tbl_customers where customer_id = '$customer'")->row_array();

                                                $cnt = 0;
                                                foreach ($topup_details as $cust) {
                                                    $cnt++;
                                                    ?>
                                                    <tr>
                                                        <td scope="row">
                                                            <?php echo $cnt; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['franchise_id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['transaction_id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['payment_date']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['credit_amount']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['debit_amount']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['balance_amount']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['payment_mode']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['bank_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $cust['refrence_no']; ?>
                                                        </td>
                                                    </tr>

                                                <?php }
                                            } else {
                                                echo "<tr><td colspan='10' class='text-center'>No Data Found</td></tr>";
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php $this->load->view('admin/admin_shared/admin_footer'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>

        $(document).ready(function () {

            $("#franchise_id").on('blur', function () {
                baseUrl = '<?php echo base_url(); ?>';
                var franchise_id = $(this).val();
                if (franchise_id != null || franchise_id != '') {
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + 'FranchiseController/getfranchise_details',
                        data: 'franchise_id=' + franchise_id,
                        dataType: "json",
                        success: function (r) {
                            //var r = JSON.parse(data); 
                            //  var r = jQuery.parseJSON(data); 
                            console.log(r);

                            var customer_name = '<label>Customer Name :</label><input type="text" class="form-control" name="customer_name"  value="' + r.customer_name + '" readonly>';
                            var email = '<label>Email :</label><input type="text" class="form-control" name="email"  value="' + r.email + '" readonly>';
                            var phone = '<label>Phone :</label><input type="text" class="form-control" name="phone" value="' + r.phone + '" readonly>';
                            var pincode = '<label>Pincode :</label><input type="text" class="form-control" name="pincode"  value="' + r.pincode + '" readonly>';
                            var city = '<label>City :</label><input type="text" class="form-control" name="city"  value="' + r.city + '" readonly>';
                            var state = '<label>State :</label><input type="text" class="form-control" name="state"  value="' + r.state + '" readonly>';
                            var address = '<label>Address :</label><input type="text" class="form-control" name="address"  value="' + r.address + '" readonly>';

                            $('#customer_name').html(customer_name).fadeIn('slow');
                            $('#email').html(email).fadeIn('slow');
                            $('#phone').html(phone).fadeIn('slow');
                            $('#pincode').html(pincode).fadeIn('slow');
                            $('#city').html(city).fadeIn('slow');
                            $('#state').html(state).fadeIn('slow');
                            $('#address').html(address).fadeIn('slow');
                        }
                    });
                }
            });

            $('#download_data').DataTable({
               
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        });  
    </script>