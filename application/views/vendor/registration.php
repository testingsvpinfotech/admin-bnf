    <!-- Content -->
    <div class="page-content">

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix p-t50 p-b50">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-10">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="col-md-10">

                            <form class="p-a30 dez-form" action="<?php echo base_url('add-vendor'); ?>" method="POST" enctype="multipart/form-data">
                                <h3 class="form-title m-t0" style="color:#e95421;">Sign UP</h3>
                                <input type="hidden" class="form-control" value="<?php echo $VCI; ?>" name="vci">
                                <!-- <div class="form-group"> -->
                                <!-- <span style="margin-right: 20px;">I am</span><input type="radio" name="vendor_type" value="truck_owner" style="width:20px;height:20px;">Truck owner -->
                                <!-- <input type="radio" name="vendor_type" value="transporter" style="width:20px;height:20px;">Transporter -->
                                <!-- </div> -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input name="vendor_name" required="" class="form-control" placeholder="Enter full Name" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input name="email" required="" class="form-control" placeholder="Enter Email Id" required type="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input name="alternate_email" class="form-control" placeholder="Enter Alternate Email Id"  type="email" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input name="username" required="" autocomplete="off" class="form-control" placeholder="Enter Username" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input name="password" required="" class="form-control " autocomplete="off" placeholder="Please Enter Password" type="password" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="phone" required="" class="form-control " placeholder=" Please Enter Mobile No" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="alternate_number" class="form-control " placeholder="Enter Alternate Number" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="reference_person_name" class="form-control " placeholder="Enter Reference Person Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="address" required="" placeholder="Enter Address" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="pincode" id="pincode" required="" class="form-control " placeholder="Enter Pincode" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input class="form-control " id="state" placeholder="Enter state" type="text" readonly />
                                            <input name="state" required="" class="form-control " id="state_id" placeholder="Enter state" type="hidden" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="city" class="form-control " placeholder="Enter City" readonly />
                                            <input type="hidden" name="city" required="" id="city_id" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="pan_number" placeholder="Enter Pan Number" maxlength="10" data-parsley-error-message="Please Enter Pan Card Number" class="form-control pan">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control" name="service_provider" id="service_provider">
                                                <option value="">Select Service Provider</option>
                                                <option value="Fleet Owner">Fleet Owner</option>
                                                <option value="Broker">Broker</option>
                                                <option value="Attach Vehicle">Attach Vehicle</option>
                                                <option value="other">Other</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="credit_days" placeholder="Enter Credit Days" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="bank_name" class="form-control " placeholder=" Enter bank Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="acc_number" class="form-control" placeholder=" Enter Account Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="ifsc_code" class="form-control" placeholder=" Enter IFSC code">
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Upload Cancel cheque</label>
                                            <input type="file" name="cancel_cheque" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Registration Type</label>
                                            <select class="form-control" name="register_type" id="register_type" required>
                                                <option value="">Select registration Type</option>
                                                <option value="Registered">Registered</option>
                                                <option value="Unregistered">Unregistered</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>GST Number</label>
                                        <div class="form-group">
                                            <input type="text" name="gst_number" data-parsley-error-message="Please Enter Aadhar card Number" maxlength="15" title="Please Enter GST Number" class="form-control required_gst" placeholder=" Enter GST Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Address Proof</label>
                                            <input type="file" name="address_proof" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pan card</label>
                                            <input type="file" name="pan_card_proof" class="form-control " required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 hide_gst_certificate" style="display:none;">
                                        <div class="form-group">
                                            <label>Gst Certificate</label>
                                            <input type="file" name="gst_proof" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-left  mt-2">
                                    <button type="submit" class="site-button dz-xs-flex m-r10">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Client logo END -->
    </div>
    <!-- Content END-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        $(document).ready(function() {

            $(".pan").change(function() {
                var inputvalues = $(this).val();
                var regex = /[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                if (!regex.test(inputvalues)) {
                    $(".pan").val("");
                    
                    Swal.fire({
                    icon: 'error',
                    title: 'Invalid...',
                    text: 'Invalid PAN Number',
                    showConfirmButton: true
                                  }).then(function(){
                                      window.location.reload();
                 });
                    return regex.test(inputvalues);
                }
            });

            $("#register_type").change(function() {
                var registered = $(this).val();


                if (registered == 'Registered') {
                    $(".required_gst").attr("required", "true");
                    $(".hide_gst_certificate").show();
                } else {
                    $(".hide_gst_certificate").hide();
                }


            });

            $('#pincode').on('blur', function() {
                var pincode = $(this).val();
                if (pincode != null || pincode != '') {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>vendor/Login_controller/getCityList',
                        data: 'pincode=' + pincode,
                        dataType: "json",
                        success: function(data) {
                            $('#city').val(data.city);
                            $('#city_id').val(data.id);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>vendor/Login_controller/getState',
                        data: 'pincode=' + pincode,
                        dataType: "json",
                        success: function(data) {
                            $('#state').val(data.state);
                            $('#state_id').val(data.id);
                        }
                    });
                }
            });

        });
    </script>