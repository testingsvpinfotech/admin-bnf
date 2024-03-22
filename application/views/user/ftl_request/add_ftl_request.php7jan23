<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
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
  <main>
    <div class="container-fluid site-width">


      <!-- START: Card Data-->
      <div class="row" style="margin-top: 100px;">
        <div class="col-12 mt-3">
          <div class="card">
            <div class="card-body">
              <div class="row p-2">
                <div class="col-md-6">
                  <div><a href="<?php echo base_url();?>User_panel/show_ftl_request" class="btn btn-primary">
                      View FTL Request Data </a></div>
                </div>
                <hr>

              </div>

              <div class="col-12 col-md-12 mt-3">
                <div class="card p-4">
                  <div class="card-body">

                   

                    <form  action="<?php echo base_url();?>User_panel/ftl_request_data" enctype="multipart/form-data" method="POST">


                      <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                        <h6 class="mb-0 text-uppercase font-weight-bold">FTL Request Form</h6>
                      </div>


                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="control-label">Order Date & Time</label>
                            <?php $date = date('Y-m-d H:i:s');?>
                            <input type="text" name="order_date" placeholder="Enter Name" value="<?php echo $date;?>" class="form-control" readonly>
                          </div>
                        </div>

                        <div class="form-group  col-md-3">
                          <div class="form-group">
                            <label class="control-label">request Date & Time</label>
                            <input type="date" name="request_date_time" class="form-control" value="<?php echo set_value('request_date_time') ?>" required="">
                          </div>
                        </div>

                        <div class="form-group  col-md-3">
                          <div class="form-group">
                            <label class="control-label"></label>
                            <input type="text" name="ftl_request_id" class="form-control" value="<?php echo $FTTLR_id; ?>" readonly>
                          </div>
                        </div>
                        

                      </div>

                      <div class="row">
                        <div class="form-group col-md-3 required">
                          <div class="form-group">
                            <label class="control-label">Pincode</label>
                            <input type="text" name="origin_pincode" class="form-control" value="<?php echo set_value('origin_pincode') ?>" placeholder="Enter Pincode" required="">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="control-label">Origin City</label>
                            <input type="text" name="origin_city" placeholder="Enter Origin City" value="<?php echo set_value('origin_city') ?>" class="form-control">
                          </div>
                        </div>

                        <div class="form-group col-md-3 required">
                          <div class="form-group">
                            <label class="control-label">Pincode</label>
                            <input type="text" name="destination_pincode" class="form-control" value="<?php echo set_value('destination_pincode') ?>" placeholder="Enter Pincode" required="">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="control-label">Destination City</label>
                            <input type="text" name="destination_city" placeholder="Enter Destination City" value="<?php echo set_value('destination_city') ?>" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <hr>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group ">
                            <label class="control-label">Type Of vehicle</label>
                           <select class="form-control get_vehical_type" name="type_of_vehicle">
                            <?php if(!empty($vehicle_type)){ ?>
                              <option>Select Vehicle Name</option>
                              <?php foreach($vehicle_type as $value):?>
                                <option value="<?php echo $value->id;?>"><?php echo $value->vehicle_name;?> </option>
                              <?php endforeach ;?>
                            <?php } ?>
                           </select>
                          </div>
                        </div>

                        <div class="form-group col-md-4">
                          <label class="control-label">Vehicle Capacity</label>
                          <input type="text" class="form-control" name="vehicle_capacity" id="vehicle_capicty">
                        </div>

                        <div class="form-group col-md-4">
                          <label class="control-label">Amount</label>
                          <input type="text" name="amount" id="amount" value="<?php echo set_value('amount') ?>" class="form-control" placeholder="Enter Amount">
                        </div>

                        <div class="form-group col-md-4">
                          <label class="control-label">Pickup Address</label>
                          <input type="text" name="pickup_address" id="pickup_address" value="<?php echo set_value('pickup_address') ?>" class="form-control" placeholder="Enter Pickup Address">
                        </div>
                        <div class="form-group col-md-4">
                          <label class="control-label">Contact No</label>
                          <input type="text"  name="contact_number" value="<?php echo set_value('contact_number') ?>" class="form-control" pattern='^\+?\d{0,10}' title="please check Contact Number" placeholder="Enter Contact Number">
                        </div>
                        <div class="form-group col-md-4">
                          <label class="control-label">Delivery Address</label>
                          <input type="text"  name="delivery_address" value="<?php echo set_value('delivery_address') ?>" class="form-control"  placeholder="Enter Delivery Address" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label class="control-label">Delivery Contact No</label>
                          <input type="text"  name="delivery_contact_no" value="<?php echo set_value('delivery_contact_no') ?>" class="form-control"  placeholder="Enter Delivery Contact Number">
                        </div>
                        <div class="form-group col-md-4">
                          <label class="control-label">Delivery Contact Person Name</label>
                          <input type="text"  name="delivery_contact_person_name" value="<?php echo set_value('delivery_contact_person_name') ?>" class="form-control" placeholder="Enter delivery Contact Person Name">
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
  <style>
    input:read-only {
      background-color: #ddd;
    }

    .form-group {
      margin-bottom: 20px !important;
    }
  </style>
  </main>
  <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
  <!-- START: Footer-->
</body>
<!-- END: Body-->

<script>
   $('.get_vehical_type').change(function() {
          base_url ='<?php echo base_url();?>';
            var vehicle_id = $(this).val();
            $.ajax({
              url: base_url+"User_panel/getVehicleCapicty",
              type: 'POST',
              data: {vehicle_id : vehicle_id},
              dataType: 'json',
              success: function (d) {
              //  var objectX = JSON.parse(d);
                console.log(d);
                alert(d);
                  $('#vehicle_capicty').val(d[0].capicty); 
                 
              }
            }); 
        });
</script>
<script src="assets/js/domestic_shipment.js"></script>

</html>