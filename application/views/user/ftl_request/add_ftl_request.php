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

    .form-control {
      height: 36px !important;
      font-size: 14px !important;
      border: 1px solid #000;
      border-radius: 0.2rem;
      -webkit-border-radius: 0.2rem;
      -moz-border-radius: 0.2rem;
      -ms-border-radius: 0.2rem;
      -o-border-radius: 0.2rem;
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
                <div class="col-md-6">
                  <div><a href="<?php echo base_url(); ?>User_panel/show_ftl_request" class="btn btn-primary">
                      View FTL Request Data </a></div>
                </div>
                <hr>

              </div>

              <div class="col-12 col-md-12 mt-3">
                <div class="card p-4">
                  <div class="card-body">



                    <form action="<?php echo base_url(); ?>User_panel/ftl_request_data" enctype="multipart/form-data" method="POST">


                      <div class="" style="margin-bottom:20px;color:#e95320;padding:10px;">
                        <h5 class="mb-0 text-uppercase font-weight-bold">FTL Request Form</h5>
                      </div>


                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Order Date & Time</label>
                            <?php $date = date('Y-m-d H:i:s'); ?>
                            <input type="hidden" name="ftl_request_id"  class="form-control" value="<?php echo $FTTLR_id; ?>" readonly>
                            <input type="text" name="order_date" value="<?php echo $date; ?>" class="form-control" readonly>
                          </div>
                        </div>

                        <div class="form-group  col-md-2">
                          <div class="form-group">
                            <label class="control-label">request Date<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <!-- <input type="datetime-local" name="request_date_time"  class="form-control" value="<?php echo set_value('request_date_time') ?>" required=""> -->
                            <input type="date" id="inputdate" name="date" class="form-control">
                          </div>
                        </div>
                        <div class="form-group  col-md-2">
                          <div class="form-group">
                            <label class="control-label">request time<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <!-- <input type="datetime-local" name="request_date_time"  class="form-control" value="<?php echo set_value('request_date_time') ?>" required=""> -->
                            <input type="time" name="time" class="form-control">
                          </div>
                        </div>

                        <h6 class="" style="margin-top: 37px;">I am </h6>
                        <div class="form-group col-md-3">
                          <select name="customer_type" id="customer" class="form-control" style="margin-top: 26px;border: 1px solid rgb(255 255 255 / 80%) !IMPORTANT;">
                            <option value="">Select Customer Type</option>
                            <option value="consinor">consignor</option>
                            <option value="consignee">consignee</option>
                          </select>
                        </div>
                      </div>

                      <div class="row consignee_details" style="display:none;">
                        <div class="form-group  col-md-4">
                          <div class="form-group">
                            <label class="control-label">Name <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="consignee_name" class="form-control" placeholder="Enter Name" value="<?php echo set_value('consignor_name') ?>">
                          </div>
                        </div>
                        <div class="form-group  col-md-4">
                          <div class="form-group">
                            <label class="control-label">Address<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="consignee_address" placeholder="Enter Address" class="form-control" value="<?php echo set_value('consignee_address') ?>">
                          </div>
                        </div>
                        <div class="form-group  col-md-4">
                          <div class="form-group">
                            <label class="control-label">Pincode<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="consignee_pincode" placeholder="Enter pincode" class="form-control" value="<?php echo set_value('consignee_pincode') ?>">
                          </div>
                        </div>
                        <div class="form-group  col-md-4">
                          <div class="form-group">
                            <label class="control-label">State<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="consignee_state" placeholder="Enter State" class="form-control" value="<?php echo set_value('consignee_state') ?>">
                          </div>
                        </div>
                        <div class="form-group  col-md-4">
                          <div class="form-group">
                            <label class="control-label">City<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="consignee_city" placeholder="Enter City" class="form-control" value="<?php echo set_value('consignee_city') ?>">
                          </div>
                        </div>
                        <div class="form-group  col-md-4">
                          <div class="form-group">
                            <label class="control-label">ContactNo<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="consignee_contact_no" placeholder="Enter Contact Number" class="form-control" value="<?php echo set_value('consignee_contact_no') ?>">
                          </div>
                        </div>
                      </div>



                      <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                        <h6 class="mb-0 text-uppercase font-weight-bold">Vehicle Details</h6>
                      </div>

                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group ">
                            <label class="control-label">Type Of vehicle</label>
                            <select class="form-control get_vehical_type" name="type_of_vehicle">
                              <?php if (!empty($vehicle_type)) { ?>
                                <option>Select Vehicle Name</option>
                                <?php foreach ($vehicle_type as $value) : ?>
                                  <option value="<?php echo $value->id; ?>"><?php echo $value->vehicle_name; ?> </option>
                                <?php endforeach; ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Vehicle wheel Type</label>
                          <select name="vehicle_wheel_type" class="form-control">
                            <option value="">Select wheeel Type</option>
                            <option value="4 wheel"> 4 wheel</option>
                            <option value="6 wheel">6 wheel</option>
                            <option value="10 wheel">10 wheel</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Vehicle Capacity</label>
                          <input type="text" class="form-control" name="vehicle_capacity" id="vehicle_capicty" required>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Vehicle body Type</label>
                          <select name="vehicle_body_type" class="form-control">
                            <option value="">Select Body Type</option>
                            <option value="Open">Open</option>
                            <option value="Close">Close</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Floor Type</label>
                          <select name="vehicle_floor_type" class="form-control">
                            <option value="">Select Floor Type</option>
                            <option value="plywood">plywood</option>
                            <option value="Rubber">Rubber</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label">GPS</label>
                          <select name="vehicle_gps" class="form-control">
                            <option value="">Select GPS</option>
                            <option value="Yes">yes</option>
                            <option value="No">No</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Goods Type <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <select class="form-control" name="goods_type" id="goods_type" required>
                            <option value="">Select Goods Type</option>
                            <?php if (!empty($goods_name)) { ?>
                              <?php foreach ($goods_name as $value) : ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->goods_name; ?></option>
                              <?php endforeach; ?>
                            <?php  } ?>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Goods Weight <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <input type="text" class="form-control" name="goods_weight" id="goods_weight" placeholder="Enter Goods Weight" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label">Weight Type <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <select class="form-control" name="weight_type" id="weight_type" required>
                            <option value="">Select Weight Type</option>
                            <option value="Ton">Ton</option>
                            <option value="KG">KG</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label">Goods Value<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <input type="text" class="form-control" name="goods_value" id="goods_value" placeholder="Enter Goods Value" required>
                        </div>


                        <div class="form-group col-md-3">
                          <label class="control-label">Target price <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <input type="text" name="amount" id="amount" value="<?php echo set_value('amount') ?>" class="form-control" placeholder="Enter Amount">
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Contact No </label>
                          <input type="text" name="contact_number" value="<?php echo set_value('contact_number') ?>" class="form-control" pattern='^\+?\d{0,10}' title="please check Contact Number" placeholder="Enter Contact Number" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label"> <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span>Select Loading</label>
                          <select class="form-control" name="loading_type" id="loading_type" required>
                            <option value="">Select Loading</option>
                            <option value="self">Self</option>
                            <option value="vendor">vendor</option>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label"> <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span>Select Unloading</label>
                          <select class="form-control" name="unloading_type" id="Unloading_type" required>
                            <option value="">Select Unloading</option>
                            <option value="self">Self</option>
                            <option value="vendor">vendor</option>
                          </select>
                        </div>
                      </div>
                      <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                        <h6 class="mb-0 text-uppercase font-weight-bold">Pickup And Delivery Details</h6>
                      </div>

                      <div class="row">
                        <div class="form-group col-md-4 required">
                          <div class="form-group">
                            <label class="control-label">Origin Pincode <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="origin_pincode" id="origin_pincode" class="form-control" value="<?php echo set_value('origin_pincode') ?>" placeholder="Enter Pincode" required="">
                          </div>
                        </div>
                        <div class="form-group col-md-4 required">
                          <div class="form-group">
                            <label class="control-label">Origin state <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="hidden" name="origin_state" id="origin_state_id" class="form-control">
                            <input type="text" class="form-control" id="origin_state" placeholder="Enter Pincode">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Origin City <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="hidden" name="origin_city" id="origin_city_id" value="<?php echo set_value('origin_city') ?>" class="form-control" required>
                            <input type="text" id="origin_city" placeholder="Enter Origin City" class="form-control">
                          </div>
                        </div>

                        <div class="form-group col-md-4 required">
                          <div class="form-group">
                            <label class="control-label">Destination Pincode <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" id="destination_pincode" name="destination_pincode" class="form-control" value="<?php echo set_value('destination_pincode') ?>" placeholder="Enter Pincode" required="">
                          </div>
                        </div>
                        <div class="form-group col-md-4 required">
                          <div class="form-group">
                            <label class="control-label">Destination state <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="hidden" id="destination_state_id" class="form-control" value="<?php echo set_value('destination_state') ?>" required="">
                            <input type="text" name="destination_state" id="destination_state" class="form-control" placeholder="Enter State">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Destination City <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="hidden" id="destination_city_id" value="<?php echo set_value('destination_city') ?>" class="form-control" required>
                            <input type="text" name="destination_city" id="destination_city" placeholder="Enter Destination City" value="<?php echo set_value('destination_city') ?>" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <hr>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-md-6">
                          <label class="control-label">Pickup Address <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <input class="controls" name="pickup_address" type="text" placeholder="Search Pickup Location">
                          <!-- <input id="pac-input" class="controls" name="pickup_address" type="text" placeholder="Search Pickup Location"> -->
                          <!-- <div id="map-canvas"></div> -->
                          <!-- <input type="text" name="pickup_address" id="pickup_address" value="<?php echo set_value('pickup_address') ?>" class="form-control" placeholder="Enter Pickup Address"> -->
                        </div>

                        <div class="form-group col-md-6">
                          <label class="control-label">Delivery Address <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <!-- <input type="text" id="pac-input1" class="controls" name="delivery_address" value="<?php echo set_value('delivery_address') ?>" placeholder="Search Delivery Address" required>
                          <div id="map-canvas1"></div> -->
                          <input type="text" class="controls" name="delivery_address" style="width: 400px;">
                          <!-- <input type="text" id="searchTextField" class="controls" name="delivery_address" style="width: 400px;"> -->
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label class="control-label">Delivery Contact No <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <input type="text" name="delivery_contact_no" value="<?php echo set_value('delivery_contact_no') ?>" class="form-control" placeholder="Enter Delivery Contact Number" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label class="control-label">Delivery Contact Person Name <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <input type="text" name="delivery_contact_person_name" value="<?php echo set_value('delivery_contact_person_name') ?>" class="form-control" placeholder="Enter delivery Contact Person Name" required>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Risk Type<span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                          <select class="form-control" name="risk_type"  id ="risk_type" required>
                            <option value="">Select Risk Type</option>
                            <option value="Customer">Customer</option>
                            <option value="Vendor">Vendor</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label class="control-label">Special Instruction </label>
                          <textarea type="text" col="100" name="descrption" row="10"></textarea>
                        </div>

                      </div>
                      <button type="submit" name="submit" class="btn  btn-lg btn-primary mt-2">Submit</button>
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
<!-- ******************************* loding Type vendor ************************************************** -->

  <div id="show_vendor_msg" class="modal fade" role="dialog" style="background: #000;">
    <div class="modal-dialog" style="margin-top: 137px;">
      <div class="modal-content">
        <div class="modal-body">
          <h4 style="margin-top: 50px;text-align: center;">Loading Charges would apply</h4>
        </div>
        <button class="btn btn-success confirmation_vendor m-2" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>


  <div id="show_vendor_confr" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin-top: 137px;">
      <div class="modal-content">
        <div class="modal-body">
          <h4 style="margin-top: 50px;text-align: center;">Please click here for your consent</h4>
          <input type="checkbox" class="form-control">
        </div>
        <button class="btn btn-success m-2" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>


  <!-- ******************************* Unloding Type vendor ************************************************** -->


  <div id="show_Unload_vendor_msg" class="modal fade" role="dialog" style="background: #000;">
    <div class="modal-dialog" style="margin-top: 137px;">
      <div class="modal-content">
        <div class="modal-body">
          <h4 style="margin-top: 50px;text-align: center;">Unloading Charges would apply</h4>
        </div>
        <button class="btn btn-success confirmation_unload_vendor m-2" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>


  <div id="show_Unload_vendor_confr" class="modal fade" role="dialog">
    <div class="modal-dialog" style="margin-top: 137px;">
      <div class="modal-content">
        <div class="modal-body">
          <h4 style="margin-top: 50px;text-align: center;">Please click here for your consent</h4>
          <input type="checkbox" class="form-control">
        </div>
        <button class="btn btn-success m-2" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>


   <!-- ******************************* Risk Type vendor ************************************************** -->

   <div id="risk" class="modal fade" role="dialog" style="background: #000;">
    <div class="modal-dialog" style="margin-top: 137px;">
      <div class="modal-content">
        <div class="modal-body">
          <h4 style="margin-top: 50px;text-align: center;">Additional Charges will apply</h4>
        </div>
        <button class="btn btn-success  m-2" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>




  <style>
    input:read-only {
      background-color: #ddd;
    }

    .form-group {
      margin-bottom: 20px !important;
    }


    #map-canvas {
      /* margin-top:80%; */
      display: none;
      height: 100%;
      margin: 0;
      padding: 0
    }

    canvas[resize] {
      width: 100%;
      height: 100%;
    }

    .controls {
      margin-top: 16px;
      border: 1px solid transparent;
      border-radius: 2px 0 0 2px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      height: 32px;
      outline: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
      bacground-color: #fff;
      font-family: Roboto;
      font-size: 15px;
      font-weight: 300;
      margin-left: 12px;
      padding: 0 11px 0 13px;
      text-overflow: ellipsis;
      width: 400px;
    }

    #pac-input:focus {
      border-color: #4d90fe;
    }

    .pac-container {
      font-family: Roboto;
    }

    #type-selector {
      color: #fff;
      background-color: #4d90fe;
      padding: 5px 11px 0px 11px;
    }

    #type-selector label {
      font-family: Roboto;
      font-size: 13px;
      font-weight: 300;
    }
  </style>

  </main>



  <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
  <!-- START: Footer-->
</body>
<!-- END: Body-->

<script>
  // $('#dateTime').ejDateTimePicker({
  //      dateTimeFormat: "dddd, MMMM dd, yyyy hh:mm:ss tt",
  //      timePopupWidth: "150px",
  //      timeDisplayFormat: "hh:mm:ss tt",
  //      width: '300px'
  //   });

  // ***************** loding *******************************

  $("#loading_type").change(function() {
    if ($(this).val() == 'vendor') {
      $('#show_vendor_msg').modal('show');
    }
  });

  $(".confirmation_vendor").click(function() {
    $('#show_Unload_vendor_confr').modal('show');
  });


  // ***************** Unloding *******************************
  
  $("#Unloading_type").change(function() {
if ($(this).val() == 'vendor') {
  $('#show_Unload_vendor_msg').modal('show');
}
});

$(".confirmation_unload_vendor").click(function() {
$('#show_Unload_vendor_confr').modal('show');
});

 // ***************** Resktype *******************************

 $("#risk_type").change(function() {
if ($(this).val() == 'Vendor') {
  $('#risk').modal('show');
}
});


  $('.get_vehical_type').change(function() {
    base_url = '<?php echo base_url(); ?>';
    var vehicle_id = $(this).val();
    $.ajax({
      url: base_url + "User_panel/getVehicleCapicty",
      type: 'POST',
      data: {
        vehicle_id: vehicle_id
      },
      dataType: 'json',
      success: function(d) {
        //  var objectX = JSON.parse(d);
        console.log(d);
        // alert(d);
        $('#vehicle_capicty').val(d[0].capicty);
        $('#vehicle_body_type').val(d[0].body_type);

      }
    });
  });
</script>


<script>
$(function(){
    var dtToday = new Date();
 
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
     day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#inputdate').attr('min', maxDate);
});
</script>

<script src="assets/js/domestic_shipment.js"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJfzOqR9u2eyXv6OaiuExD3jzoBGGIVKY&libraries=geometry,places&v=weekly"></script>
<script>
  var overlay;

  testOverlay.prototype = new google.maps.OverlayView();

  function initialize() {
    var map = new google.maps.Map(document.getElementById("map-canvas"), {
      zoom: 15,
      center: {
        lat: 37.323,
        lng: -122.0322
      },
      mapTypeId: "terrain",
      draggableCursor: "crosshair"
    });
    map.addListener("click", (event) => {
      map.setCenter(event.latLng);
      console.log(event.latLng.toString());
    });

    overlay = new testOverlay(map);

    var input =
      /** @type {HTMLInputElement} */
      (document.getElementById("pac-input"));
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var searchBox = new google.maps.places.SearchBox(
      /** @type {HTMLInputElement} */
      (input)
    );

    google.maps.event.addListener(searchBox, "places_changed", function() {
      var places = searchBox.getPlaces();
      if (places.length == 0) {
        return;
      }
      map.setCenter(places[0].geometry.location);
    });
  }

  function testOverlay(map) {
    this.map_ = map;
    this.div_ = null;
    this.setMap(map);
  } -->

<!-- // testOverlay.prototype.onAdd = function () {
  //   var div = document.createElement("div");
  //   this.div_ = div;
  //   div.style.borderStyle = "none";
  //   div.style.borderWidth = "0px";
  //   div.style.display= "none";
  //   div.style.position = "absolute";
  //   div.style.left = -window.innerWidth / 2 + "px";
  //   div.style.top = -window.innerHeight / 2 + "px";
  //   div.width = window.innerWidth;
  //   div.height = window.innerHeight;

  //   const canvas = document.createElement("canvas");
  //   canvas.style.position = "absolute";
  //   canvas.width = window.innerWidth;
  //   canvas.height = window.innerHeight;
  //   div.appendChild(canvas);

  //   const panes = this.getPanes();
  //   panes.overlayLayer.appendChild(div);

  //   var ctx = canvas.getContext("2d");
  //   this.drawLine(ctx, 0, "rgba(0, 0, 0, 0.2)");
  //   this.drawLine(ctx, 90, "rgba(0, 0, 0, 0.2)");
  //   this.drawLine(ctx, 37.5, "rgba(255, 0, 0, 0.4)");
  //   this.drawLine(ctx, 67.5, "rgba(255, 0, 0, 0.4)");
  // };

  // testOverlay.prototype.drawLine = function (ctx, degrees, style) {
  //   const w = window.innerWidth / 2;
  //   const h = window.innerHeight / 2;
  //   const radians = ((90 - degrees) * Math.PI) / 180;
  //   const hlen = Math.min(w, h);
  //   const x = Math.cos(radians) * hlen;
  //   const y = -Math.sin(radians) * hlen;
  //   ctx.beginPath();
  //   ctx.strokeStyle = style;
  //   ctx.moveTo(w - x, h - y);
  //   ctx.lineTo(w + x, h + y);
  //   ctx.stroke();
  // };

  // testOverlay.prototype.onRemove = function () {
  //   this.div_.parentNode.removeChild(this.div_);
  //   this.div_ = null;
  // };

  google.maps.event.addDomListener(window, "load", initialize);



  // ****************************************data **************************** -->

<!-- function initialize_data() {
    var input = document.getElementById('searchTextField');
    new google.maps.places.Autocomplete(input);
  }

  google.maps.event.addDomListener(window, 'load', initialize_data); -->

<!-- // ******************************************** show consinee data***************************** -->
<script>
  $(document).ready(function() {
    $("#customer").change(function() {
      $("select option:selected").each(function() {
        if ($(this).attr("value") == "consignee") {
          $(".consignee_details").show();
        }
        if ($(this).attr("value") == "consinor") {
          $(".consignee_details").hide();
        }
      });
    });
  });

  // *********************************************** *ORIGIN **************************
  $(document).ready(function() {

    $('#origin_pincode').on('blur', function() {
      var pincode = $(this).val();
      if (pincode != null || pincode != '') {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>User_panel/getOriginCityList',
          data: 'pincode=' + pincode,
          dataType: "json",
          success: function(data) {
            $('#origin_city').val(data.city);
            $('#origin_city_id').val(data.id);
          }
        });
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>User_panel/getOriginState',
          data: 'pincode=' + pincode,
          dataType: "json",
          success: function(data) {
            $('#origin_state').val(data.state);
            $('#origin_state_id').val(data.id);
          }
        });
      }
    });




    // *********************************************** *Destination **************************

    $('#destination_pincode').on('blur', function() {
      var pincode = $(this).val();
      if (pincode != null || pincode != '') {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>User_panel/getDestinationCityList',
          data: 'pincode=' + pincode,
          dataType: "json",
          success: function(data) {
            $('#destination_city').val(data.city);
            $('#destination_city_id').val(data.id);
          }
        });
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>User_panel/getDestinationState',
          data: 'pincode=' + pincode,
          dataType: "json",
          success: function(data) {
            $('#destination_state').val(data.state);
            $('#destination_state_id').val(data.id);
          }
        });
      }
    });

  });
</script>



</html>