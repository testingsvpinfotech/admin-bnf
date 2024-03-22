    <!-- Content -->
    <div class="page-content">

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix p-t50 p-b50">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-10 card">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>

                            <form class="p-a30 dez-form" action="<?php echo base_url('update-vendor'); ?>" method="POST">
                                <h3 class="form-title m-t0" style="color:#e95421;">User Profile </h3>
                                <!-- <input type="hidden" class="form-control" value="<?php echo $VCI; ?>" name="vci"> -->
                                <!-- <div class="form-group">
                                    <span style="margin-right: 20px;">I am</span><input type="radio" name="vendor_type" value="truck_owner" style="width:20px;height:20px;">Truck owner
                                    <input type="radio" name="vendor_type" value="transporter" style="width:20px;height:20px;">Transporter
                                </div> -->

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="vendor_name" value ="<?php echo $customer[0]['vendor_name'];?>" class="form-control" placeholder="Enter full Name" type="text" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label>Email</label>
                                            <input name="email" required="" value ="<?php echo $customer[0]['email'];?>" class="form-control" placeholder="Enter Email Id" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>Username</label>
                                            <input name="username" value ="<?php echo $customer[0]['username'];?>" autocomplete="off" class="form-control" placeholder="Enter Username" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>Password</label>
                                            <input name="password" value ="<?php echo $customer[0]['password'];?>" class="form-control " autocomplete="off" placeholder="Please Enter Password" type="password" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>Phone</label>
                                            <input type="text" name="phone" value ="<?php echo $customer[0]['mobile_no'];?>" class="form-control " placeholder="Please Enter Mobile No." >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>Refrence Person Name</label>
                                            <input type="text" name="reference_person_name" value ="<?php echo $customer[0]['reference_person_name'];?>" class="form-control " placeholder="Enter Reference Person Name" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>Address</label>
                                            <textarea name="address"  class="form-control" rows="3" cols="50"><?php echo $customer[0]['address'];?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>Pincode</label>
                                            <input type="number" name="pincode" id="pincode" value ="<?php echo $customer[0]['pincode'];?>" class="form-control " placeholder="Enter Pincode" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>State</label>
                                        <?php $state_id = $customer[0]['state']; $state_data = $this->db->query("select state from state where id = '$state_id'")->row();?>
                                            <input name="state"  class="form-control " value ="<?php echo $state_data->state ;?>"  id="state" placeholder="Enter state" type="text" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label>City</label>
                                        <?php $city_id =  $customer[0]['city']; $city_data = $this->db->query("select city from city where id = '$city_id'")->row();?>
                                            <input type="text" name="city" value ="<?php echo $city_data->city ;?>"  id="city" class="form-control " placeholder="Enter City" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                    <label>Pan Number</label>
                                        <input type="text" name="pan_number" value ="<?php echo $customer[0]['pan_number'];?>" placeholder="Enter Pan Number" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                    <label>GST Number</label>
                                        <input type="text" name="gst_number" value ="<?php echo $customer[0]['gst_number'];?>" class="form-control" placeholder=" Enter GST Number">
                                    </div>
                                    <div class="col-md-4">
                                    <label>Service Provider</label>
                                        <select class="form-control" name="service_provider" id="service_provider">
                                            <option value="">Select Service Provider</option>
                                            <option value="Fleet Owner" <?php if($customer[0]['service_provider'] == 'Fleet Owner'){?> Selected <?php } ?>>Fleet Owner</option>
                                            <option value="Broker" <?php if($customer[0]['service_provider'] == 'Broker'){?> Selected <?php } ?>>Broker</option>
                                            <option value="Attacch Vehicle" <?php if($customer[0]['service_provider'] == 'Attacch Vehicle'){?> Selected <?php } ?>>Attacch Vehicle</option>
                                            <option value="other" <?php if($customer[0]['service_provider'] == 'other'){?> Selected <?php } ?>>Other</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                   <div class="col-md-4">
                                   <label>Credit Day</label>
                                        <input type="text" name="credit_days" value ="<?php echo $customer[0]['credit_days'];?>" placeholder="Enter Credit Days"class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                    <label>Branch Name</label>
                                        <input type="text" name="branch_name" value ="<?php echo $customer[0]['branch_name'];?>" placeholder="Enter Branch Name" class="form-control">
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
    <script>
        $(document).ready(function() {

            $('#pincode').on('blur', function() {
                var pincode = $(this).val();
                if (pincode != null || pincode != '') {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>vendor/Login_controller/getCityList',
                        data: 'pincode=' + pincode,
                        dataType: "json",
                        success: function(data) {
                            $('#city').val(data);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>vendor/Login_controller/getState',
                        data: 'pincode=' + pincode,
                        dataType: "json",
                        success: function(data) {
                            $('#state').val(data);
                        }
                    });
                }
            });

        });
    </script>