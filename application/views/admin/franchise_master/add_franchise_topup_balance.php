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
            <div class="col-md-6">
              <h6 class=""><i class="fas fa-star mr-2"></i>Company Profile</h6>
            </div>
            <hr>
          </div>
          <?php // print_r($_POST);?>
          <div class="col-12 col-md-12 mt-3">
            <div class="card p-4">
              <div class="card-body">
                <form action="<?php echo base_url(); ?>admin/franchise-topup-balance" enctype="multipart/form-data"
                  method="POST">
                  <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                    <h6 class="mb-0 text-uppercase font-weight-bold">Franchise Wallet Recharge</h6>
                    <a href="<?php echo base_url('admin/view-franchise-topup-data'); ?>" class="btn float-right"
                      style="margin-top: -25px; color: #fff;background-color: #ea6335;">view Franchise Topup </a>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Franchise ID</label>
                          <input type="text" id="franchise_id" name="franchise_id" placeholder="Enter Franchise Id"
                            class="form-control" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-md-3 form-group">
                      <div id="customer_name"></div>
                    </div>
                    <div class="col-md-3 form-group">
                      <div id="email"></div>
                    </div>
                    <div class="col-md-3 form-group">
                      <div id="phone"></div>
                    </div>
                    <div class="col-md-3 form-group">
                      <div id="pincode"></div>
                    </div>

                  </div>
                  <div class="row">

                    <div class="col-md-3 form-group">
                      <div id="city"></div>
                    </div>
                    <div class="col-md-3 form-group">
                      <div id="state"></div>
                    </div>
                    <div class="col-md-3 form-group">
                      <div id="address"></div>
                    </div>

                    <div id="customer_id"></div>


                  </div>

                  <div class="row mt-2">
                    <div class="col-md-3 form-group">
                      <label>Amount</label>
                      <input type="text" class="form-control" name="amount" placeholder="Enter Amount" value=""
                        required>
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Payment Type</label>
                      <select class="form-control" name="payment_mode" id="pay_mode" required>
                        <option value="">Select Payment Type</option>
                        <option value="UPI">UPI</option>
                        <option value="NEFT">NEFT</option>
                        <option value="CASH">CASH</option>
                        <option value="Cheque">Cheque</option>
                        <option value="RTGS">RTGS</option>
                        <option value="CHARGES REVERSAL">CHARGES REVERSAL</option>
                        <?php if ($_SESSION['userType'] == 1) { ?>
                          <option value="credit">Credit</option>
                          <option value="debit">Debit</option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="col-md-3 bank_name">
                      <label>Bank Name</label>
                      <input type="text" class="form-control" name="bank_name" id="bank_name"
                        placeholder="Enter Bank Name" value="">
                    </div>

                    <div class="col-md-3">
                      <label id="reson">Refrence No.</label>
                      <input type="text" class="form-control" name="Refrence_number" id="Refrence_number"
                        placeholder="Enter Refrence Number" value="" required>
                    </div>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <?php $this->load->view('admin/admin_shared/admin_footer'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

  <script>

    $(document).ready(function () {
      $('#pay_mode').change(function () {
        var pay_mode = $('#pay_mode').val();
        if (pay_mode == 'debit') {
          $('#bank_name').prop("required", false)
          $('.bank_name').hide();
          $('#reson').html('Remark');
          $('#Refrence_number').attr("placeholder", " ");

        }
        else {
          $('.bank_name').show();
          $('#bank_name').prop("required", true)
          $('#reson').html('Refrence No.');
          $('#Refrence_number').attr("placeholder", "Enter Refrence Number");
        }
      });
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
              var customer_id = '<input type="text" class="form-control" name="customer_id"  value="' + r.customer_id + '" readonly>';
              var email = '<label>Email :</label><input type="text" class="form-control" name="email"  value="' + r.email + '" readonly>';
              var phone = '<label>Phone :</label><input type="text" class="form-control" name="phone" value="' + r.phone + '" readonly>';
              var pincode = '<label>Pincode :</label><input type="text" class="form-control" name="pincode"  value="' + r.pincode + '" readonly>';
              var city = '<label>City :</label><input type="text" class="form-control" name="city"  value="' + r.city + '" readonly>';
              var state = '<label>State :</label><input type="text" class="form-control" name="state"  value="' + r.state + '" readonly>';
              var address = '<label>Address :</label><input type="text" class="form-control" name="address"  value="' + r.address + '" readonly>';

              $('#customer_name').html(customer_name).fadeIn('slow');
              $('#email').html(email).fadeIn('slow');
              $('#customer_id').html(customer_id).fadeIn('slow');
              $('#phone').html(phone).fadeIn('slow');
              $('#pincode').html(pincode).fadeIn('slow');
              $('#city').html(city).fadeIn('slow');
              $('#state').html(state).fadeIn('slow');
              $('#address').html(address).fadeIn('slow');
            }
          });
        }
      });

    });  
  </script>