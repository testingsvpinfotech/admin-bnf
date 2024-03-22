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

                    <div class="col-12 col-md-12 mt-3">
                        <div class="card p-4">
                            <div class="card-body">

                                <?php // echo validation_errors(); ?>

                                <form  action="<?php echo base_url(); ?>FranchiseController/store_franchise_data" enctype="multipart/form-data" method="post">



                                    <div class="" style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Personal Information</h6>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Franchise ID</label>
                                                    <input type="text" value="<?php echo $fid; ?>" name="fid" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-3">-->
                                        <!--    <div class="form-row">-->
                                        <!--        <div class="form-group col-md-12">-->
                                        <!--            <label>Username</label>-->
                                        <!--             <input type="text" class="form-control" name="username" placeholder="Enter Username" value="" >-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-md-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control"  name="password" placeholder="Enter Password" value="<?php echo set_value('password') ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Confirm Password</label>
                                                    <input type="text" class="form-control" name="passconf" value="<?php echo set_value('passconf') ?>" placeholder="Enter Confirm Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div><br>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label"> Name</label>
                                                <input type="text" name="franchise_name" required placeholder="Enter Name" value="<?php echo set_value('franchise_name') ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group  col-md-3 required">
                                            <div class="form-group">
                                                <label class="control-label">S/O or D/O</label>
                                                <input type="text" name="franchise_relation" required class="form-control" value="<?php echo set_value('franchise_relation') ?>" placeholder="Enter Relation Name" required="">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 required">
                                            <div class="form-group">
                                                <label class="control-label">Age</label>
                                                <input type="text" name="age" class="form-control manifest_coloader_contact" maxlength="3" required value="<?php echo set_value('age') ?>" placeholder="Enter Age" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" placeholder="Enter Email-Id" required value="<?php echo set_value('email') ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label">Residential Address </label>
                                                <textarea class="form-control" autocomplete="nope" rows="2" required name="address" placeholder="Enter Your Addres.."> </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label class="control-label">Contact No</label>
                                            <input type="text" autocomplete="nope" name="contact_number" maxlength="10" minlength="10" required value="<?php echo set_value('contact_number') ?>" pattern='^\+?\d{0,10}' class="form-control manifest_driver_contact" title="please check Contact Number" placeholder="contact_number" required>
                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <label class="control-label">Alternate Contact No</label>
                                            <input type="text" autocomplete="nope" name="alt_contact" maxlength="10" minlength="10" required value="<?php echo set_value('alt_contact') ?>" class="form-control manifest_driver_contact" pattern='^\+?\d{0,10}' title="please check Alternate Contact Number" placeholder="Enter Alt Number">
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Pin Code</label>
                                            <input type="text" name="pincode" id="pincode" required value="<?php echo set_value('pincode') ?>" maxlength="6" minlength="6" class="form-control" placeholder="Enter Pincode Number">
                                            <span class="errormsg" id="errormsg" style="color: #8b0001;font-weight: bold;"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label" >State</label>
                                            <select class="form-control filter-data" required name="franchaise_state_id" id="franchaise_state">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">City</label>
                                            <select class="form-control franchaise_city_id filter-data" required name="franchaise_city_id" id="franchaise_city">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                       
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Master Franchise Name</label>
                                            <input type="text" name="master_franchise_name" id="master_franchise_name" required class="form-control" placeholder="Enter Master Franchise">
                                            <input type="hidden" name="customer_id" id="customer_id" class="form-control" placeholder="Enter Master Franchise">
                                            <input type="hidden" name="branch_id" id="branch_id" class="form-control" placeholder="Enter Master Franchise">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Branch Name</label>
                                            <select class="form-control filter-data" required name="branch_id" id="branch_id">
                                                <option value="">Select branch</option>
                                                <?php if (!empty($branch)) { ?>
                                                    <?php foreach ($branch as $value) : ?>

                                                        <option value="<?php echo $value['branch_id']; ?>"><?php echo $value['branch_name']; ?></option>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Sale Person</label>
                                            <select class="form-control filter-data" name="sale_person" id="sale_person">
                                                <option value="">Select Sale Person</option>
                                                <?php if (!empty($sale_person)) { ?>
                                                    <?php foreach ($sale_person as $value) : ?>

                                                        <option value="<?php echo $value->user_id;?>" ><?php echo $value->full_name; ?></option>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Franchise Booking Type</label>
                                            <select class="form-control filter-data" name="franchise_booking_type" id="franchise_type">
                                                <option value="">Franchise Booking Type</option>
                                                            <?php $key =1; foreach (bill_type as $value):
                                                                  if($key !=3){
                                                                ?>
                                                                        <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                                            <?php  $key++;}endforeach; ?>
                                                
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row show"  style="display: none;">
                                        <div class="form-group col-md-3 required">
                                            <div class="form-group">
                                                <label class="control-label">Credit Limit</label>
                                                <input type="text" name="credit_limit" id="credit_limit" class="form-control" placeholder="Enter Credit Limit" required="" value="">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 required">
                                            <div class="form-group">
                                                <label class="control-label">Credit Days</label>
                                                <input type="text" name="credit_days" id="credit_days" class="form-control"  placeholder="Enter Credit Days" maxlength="2" required="" value="">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Commission Group</label>
                                            <select class="form-control filter-data" name="commision_id" id="sale_person">
                                                <option value="">Select Commission Group</option>
                                                <?php foreach ($commission as $key=> $value):
                                                    ?>
                                                            <option value="<?php echo $key; ?>" ><?php echo $value->group_name; ?></option>
                                                <?php  endforeach; ?>                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="" style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Delivery </h6>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 ">
                                            <label class="control-label">delivery</label>
                                            <select class="form-control filter-data" required name="delivery_status" id="is_delivery">
                                                <option>Select delivery</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="deliver_yes" style="display:none;">
                                        <div class="row" id="1001" data-id="1001">
                                            <div class="form-group col-md-4" id="dpin">
                                                <label class="control-label">Pin Code</label>
                                                <input type="text" name="delivery_pincode[]" data-id="1001"  class="form-control delivery_pincode" placeholder="Enter Pincode">
                                            </div>
                                            <div class="form-group col-md-4" id="delivery_city">
                                                <label class="control-label">City</label>
                                                <select class="form-control dcity filter-data" name="delivery_city[]"  data-id="1001">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 mt-4">
                                                <button type="button" class="btn btn-success" id="add_data">Add</button>
                                            </div>
                                        </div>


                                        <div id="show_column"></div>


                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Delivery rate Group</label>
                                                <select class="form-control filter-data" name="delivery_rate_group">
                                                    <?php if (!empty($delivery_rate_group)) { ?>
                                                        <option>Select Delivery Rate Group</option>
                                                        <?php foreach ($delivery_rate_group as $value) : ?>
                                                            <option value="<?php echo $value->group_id; ?>"><?php echo $value->group_name; ?> </option>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Rate-Group</label>
                                            <select class="form-control filter-data" required name="rate_group">
                                                <?php if (!empty($rate_group)) { ?>
                                                    <option>Select Rate Group</option>
                                                    <?php foreach ($rate_group as $value) : ?>
                                                        <option value="<?php echo $value->group_id; ?>"><?php echo $value->group_name; ?> </option>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="control-label">Fuel-Group</label>
                                            <select class="form-control filter-data" required name="fule_group">
                                                <?php if (!empty($fuel_group)) { ?>
                                                    <option>Select Fuel Group</option>
                                                    <?php foreach ($fuel_group as $value) : ?>
                                                        <option value="<?php echo $value->group_id; ?>"><?php echo $value->group_name; ?> </option>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- <div class="" style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Delivery Rate Master </h6>
                                    </div> -->









                                    <div class="" style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">KYC</h6>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Select Type of KYC</label>
                                                    <select class="form-control filter-data" name="companytype" required>
                                                        <option value="">Select Type</option>
                                                        <option value="Sole Proprietorship" selected="selected">Sole Proprietorship</option>
                                                        <option value="Partnership">Partnership</option>
                                                        <option value="Limited Liability Partnership">Limited Liability Partnership</option>
                                                        <option value="Public Limited Company">Public Limited Company</option>
                                                        <option value="Private Limited Company">Private Limited Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong style="margin-left:38%; font-size:20px;color:#ea6435;">Pan Card Details</strong>
                                            <div class="form-group required">
                                                <label class="control-label">Pan Name </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="pan_name" value="<?php echo set_value('pan_name') ?>" placeholder="Enter Pan Name" required>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label class="control-label">Pan Number </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" title="Places check Pan Number" value="<?php echo set_value('pan_number') ?>" name="pan_number" maxlength="10" minlength="10" placeholder="Enter Pan Card Number" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 required">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label">Upload PANCard Photo</label>
                                                    <input type="file" name="pancard_photo" id="pancard_photo" value="<?php echo set_value('pancard_photo') ?>" formenctype="multipart/form-data">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6" style="margin-top: -30px;">
                                            <strong style="margin-left:38%; font-size:20px;color:#ea6435;">Aadhar Card Details</strong>
                                            <!--<hr>-->
                                            <!--<hr style="border-bottom: 2px solid #000;">-->
                                            <div class="form-row">


                                                <div class="col-md-6 form-group required">
                                                    <label class="control-label">Aadhar Number </label>
                                                    <div class="input-group">
                                                        <input type="text" required class="form-control manifest_driver_contact" maxlength="12" minlength="12" title="places check Aadhar Number" value="<?php echo set_value('aadhar_number') ?>" name="aadhar_number" maxlength="12" minlength="12" placeholder="Enter Aadhar Number" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group required">
                                                    <label class="control-label">Full Name</label>
                                                    <div class="input-group">
                                                        <input type="text" required class="form-control" name="aadharin_name" value="<?php echo set_value('aadharin_name') ?>" placeholder="Enter Name" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="control-label">DOB<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" required value="<?php echo set_value('dob') ?>" name="dob" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group" required>
                                                    <label class="control-label ">Gender<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <input type="radio" class="form-control" value="Male" name="gender">Male
                                                        <input type="radio" class="form-control" value="Female" name="gender">Female
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-row">
                                                <div class="form-group col-md-6" required>
                                                    <label class="control-label">Address<span class="required">*</span></label>
                                                    <div class="input-group">
                                                        <textarea type="text" class="form-control" value="<?php echo set_value('aadhar_address') ?>" name=" aadhar_address" placeholder="Enter Address" required> </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 required">
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label">Upload AadharCard Photo</label>
                                                        <input type="file" name="aadharcard_photo" id="aadharcard_photo" value="<?php echo set_value('aadharcard_photo') ?>" formenctype="multipart/form-data">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="" style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Company Information</h6>
                                    </div>




                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label>Firm Name </label>
                                                    <input type="text" name="company_name" required placeholder="Enter Company Name" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">PAN Number</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="nope" required id="pan_no" value="<?php echo set_value('pan_no') ?>" name="cmp_pan_number" title="Places Check Pan Number" maxlength="10" minlength="10" placeholder="Enter Pan Number" class="form-control" required>
                                                        <div class="input-group-append">
                                                            <a href="javascript:void(0)" class="btn btn" style="background-color:#109693;color:#fff;">Verified</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">GST Number</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="nope" required id="gst_no" value="<?php echo set_value('gst_no') ?>" name="cmp_gstno" title="Places Check GST Number" placeholder="GST Number" class="form-control" maxlength="15" minlength="1" required>
                                                        <div class="input-group-append">
                                                            <a href="javascript:void(0)" class="btn btn" style="background-color:#109693;color:#fff;">Verified</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label>Legal Name</label>
                                                    <input type="text" class="form-control" required value="<?php echo set_value('legal_name') ?>" name="legal_name" placeholder="Enter Legal Name" requird>
                                                </div>
                                                <div class="form-group col-md-3 required">
                                                    <label class="control-label">Constitution of Business</label>
                                                    <input type="text" autocomplete="nope" required name="constitution_of_business" value="<?php echo set_value('constitution_of_business') ?>" placeholder="Enter Constitution of Business" class="form-control" requird>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Taxpayer Type</label>
                                                    <div class="input-group">
                                                        <input type="text" id="taxpayer_type" required autocomplete="nope" value="<?php echo set_value('taxpayer_type') ?>" name="taxpayer_type" class="form-control" placeholder="Enter Taxpayer Type" requird>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">GST Status</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="nope" required name="gstin_status" value="<?php echo set_value('gstin_status') ?>" placeholder="" class="form-control" requird>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" style="padding-top:10px;">
                                            <hr>
                                        </div><br>

                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">Office Address</label>
                                                <textarea autocomplete="nope" class="form-control" placeholder="Enter office address" rows="5" name="cmp_address" required> <?php echo set_value('cmp_address') ?> </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-row">
                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">Pin Code</label>
                                                    <input type="text" id="cmppincode" autocomplete="nope" value="<?php echo set_value('cmp_pincode') ?>" maxlength="6" minlength="6" name="cmp_pincode" class="form-control" placeholder="Enter Pincode Number" title="Places Check Pincode Number" required />
                                                    <span class="errormsg" id="officeerrormsg" style="color: #8b0001;font-weight: bold;"></span>
                                                </div>

                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">State</label>
                                                    <select class="form-control filter-data" name="cmp_state" id="cmp_state" required>
                                                        <option value="">Select State</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">City</label>
                                                    <select class="form-control filter-data" name="cmp_city" id="cmp_city" required>
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">Telephone No</label>
                                                    <input type="text" autocomplete="nope" value="<?php echo set_value('cmp_office_phone') ?>" name="cmp_office_phone" pattern='^\+?\d{0,10}' title="please check Telephone Number" placeholder="Enter Telephone No" class="form-control" required>
                                                </div>

                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">Area</label>
                                                    <input type="text" autocomplete="nope" value="<?php echo set_value('cmp_area') ?>" name="cmp_area" placeholder="Enter Area" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="" style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Bank Details</h6>
                                    </div>


                                    <div class="row">
                                        <div class="form-row">
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">Upload Cancel Cheque</label>
                                                <input type="file" name="cancel_check" required id="cancel_check" class="form-control" formenctype="multipart/form-data">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">A/C Name</label>
                                                <input type="text" autocomplete="nope" required name="cmp_account_name" placeholder=" Enter Account Name" value="<?php echo set_value('cmp_account_name') ?>" class="form-control" required="">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">A/C Number</label>
                                                <input type="text" autocomplete="nope" required name="cmp_account_number" class="form-control manifest_driver_contact" value="<?php echo set_value('cmp_account_number') ?>" placeholder="Enter Account Number" required="">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">Bank Name</label>
                                                <input type="text" autocomplete="nope" required name="cmp_bank_name" class="form-control" value="<?php echo set_value('cmp_bank_name') ?>" placeholder="Enter Bank Name" required="">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">Branch</label>
                                                <input type="text" autocomplete="nope" required name="cmp_bank_branch" class="form-control" value="<?php echo set_value('cmp_bank_branch') ?>" Placeholder="Enter Branch Name" required="">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">Acc. Type</label>
                                                <input type="text" autocomplete="nope" name="cmp_acc_type" class="form-control" value="<?php echo set_value('cmp_acc_type') ?>" Placeholder="Enter Account Type" required="">
                                            </div>
                                            <div class="form-group col-md-4 required">
                                                <label class="control-label">IFSC Code</label>
                                                <input type="text" autocomplete="nope" required name="cmp_ifsc_code" value="<?php echo set_value('cmp_ifsc_code') ?>" class="form-control" placeholder="Enter IFSC Code" required="">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <input type="submit"  class="btn btn-primary" value="Submit">
                            <!-- <button type="submit"  class="btn  btn-lg btn-success mt-2">Submit</button> -->
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    </div>
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
    </style>



    <?php $this->load->view('admin/admin_shared/admin_footer'); ?>

    <script type="text/javascript">
        //====================== Is Select Delivery
        $('#franchise_type').change(function() {
            var deliveryYes = $(this).val();
        //    alert(deliveryYes);
            if(deliveryYes == '1'){
                $(".show").show();
                $("#credit_limit").prop('required',true);
                $("#credit_days").prop('required',true);
                $("#commision_id").prop('required',true);
            }else{
                $("#credit_limit").prop('required',false);
                $("#credit_days").prop('required',false);
                $("#commision_id").prop('required',false);
                $(".show").hide(); 
            }
        });
        $('#is_delivery').change(function() {
            var deliveryYes = $(this).val();
            //  alert(deliveryYes);
            if (deliveryYes == '1') {
                $("#deliver_yes").show();
            } else {
                $("#deliver_yes").hide();
            }
        });


        jQuery(document).off('blur', '.delivery_pincode');
        jQuery(document).on('blur', '.delivery_pincode', function(e) {
            e.preventDefault();
            var delivery_pincode = jQuery(this).val();
            //alert(district_id);
            let delivery_pincode_random = $(this).attr('id');
            let row_id = $(this).closest('.row').attr('data-id');

            getCityList(delivery_pincode, row_id);
        });



        function getCityList(delivery_pincode, row_id) {
            $.ajax({
                type: 'POST',
                url: 'FranchiseController/get_delivery_pincode_city',
                data: 'delivery_pincode=' + delivery_pincode,
                dataType: "json",
                success: function(d) {
                    var options = '';
                    // options += '<option value="">Select City</option>';
                    options += '<option value="' + d.id + '">' + d.city + '</option>';
                    jQuery("#" + row_id).find(".dcity").html(options);


                }
            });

        }




        var $html = '<div class="row" id="#RANDOM_NO#" data-id="#RANDOM_NO#"><div class="form-group col-md-4">\
                                            <label class="control-label">Pin Code</label>\
                                            <input type="text" name="delivery_pincode[]" data-id="#RANDOM_NO#" class="form-control delivery_pincode" placeholder="Enter Pincode">\
                                        </div>\
                                        <div class="form-group col-md-4"  id="delivery_city">\
                                            <label class="control-label">City</label>\
                                            <select class="form-control dcity "name="delivery_city[]"  data-id="#RANDOM_NO#">\
                                                <option value="">Select City</option>\
                                            </select></div>\
                                        <div class="form-group col-md-4 mt-4"><button type="button" class="btn btn-danger removebutton" id="delete_row">Delete</button></div></div>'



        $('#add_data').click(function() {

            let time_stamp = Date.now();
            let new_html = '';
            new_html = $html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);

            $('#show_column').append(new_html)

        });

        $(document).on('click', 'button.removebutton', function() {
            $("#remove_row").remove();
            return false;
        });



        $('#delivery_rate_master').change(function() {
            var d_rate_master = $(this).val();
            if (d_rate_master == '1') {
                $("#doc").show();
                $("#non_doc").hide();
            } else if (d_rate_master == '0') {
                $("#non_doc").show();
                $("#doc").hide();
            }
        });



        // ***************franchise persnal Details use Pincode
        $("#cpincode").on('blur', function() {
            var pincode = $(this).val();
            if (pincode != null || pincode != '') {


                $.ajax({
                    type: 'POST',
                    url: 'FranchiseController/getCityList',
                    data: 'pincode=' + pincode,
                    dataType: "json",
                    success: function(d) {
                        var option;
                        option += '<option value="' + d.id + '">' + d.city + '</option>';
                        $('#cityp').html(option);

                    }
                });
            }
        });
        $("#pincode").on('blur', function() {
            var pincode = $(this).val();
            if (pincode != null || pincode != '') {


                $.ajax({
                    type: 'POST',
                    url: 'FranchiseController/getCityList',
                    data: 'pincode=' + pincode,
                    dataType: "json",
                    success: function(d) {
                        var option;
                        option += '<option value="' + d.id + '">' + d.city + '</option>';
                        $('#franchaise_city').html(option);

                    }
                });
                $.ajax({
                    type: 'POST',
                    url: 'FranchiseController/getState',
                    data: 'pincode=' + pincode,
                    dataType: "json",
                    success: function(d) {
                        var option;
                        option += '<option value="' + d.id + '">' + d.state + '</option>';
                        $('#franchaise_state').html(option);
                    }
                });

            }
        });

        $(".franchaise_city_id").on('blur', function() {
            var franchaise_city = $(this).val();
           // alert(franchaise_city);
            if (franchaise_city != null || franchaise_city != '') {
                $.ajax({
                    type: 'POST',
                    url: 'FranchiseController/getFranchiseMaster',
                   // data: 'pincode=' + pincode,
                    data: 'franchaise_city=' + franchaise_city,
                    dataType: "json",
                    success: function(d) {
                        console.log(d);
                        $('#customer_id').val(d.customer_id);
                        $('#master_franchise_name').val(d.customer_name);
                        $('#branch_id').val(d.branch_id);
                    }
                });

            }
        });       
          
        // ***************company Details use Pincode

        $("#cmppincode").on('blur', function() {
            var cmppincode = $(this).val();
            if (cmppincode != null || cmppincode != '') {


                $.ajax({
                    type: 'POST',
                    url: 'FranchiseController/getCityList1',
                    data: 'cmppincode=' + cmppincode,
                    dataType: "json",
                    success: function(d) {
                        var option;
                        option += '<option value="' + d.id + '">' + d.city + '</option>';
                        $('#cmp_city').html(option);

                    }
                });

                $.ajax({
                    type: 'POST',
                    url: 'MasterFranchiseController/getState1',
                    data: 'cmppincode=' + cmppincode,
                    dataType: "json",
                    success: function(d) {
                        var option;
                        option += '<option value="' + d.id + '">' + d.state + '</option>';
                        $('#cmp_state').html(option);
                    }
                });

            }
        });


        //********************************** Delivery City And Pincode */




        // $(".delivery_pincode").on('blur', function() {
        //     var delivery_pincode = $(this).val();
        //     if (delivery_pincode != null || delivery_pincode != '') {


        //         $.ajax({
        //             type: 'POST',
        //             url: 'FranchiseController/get_delivery_pincode_city',
        //             data: 'delivery_pincode=' + delivery_pincode,
        //             dataType: "json",
        //             success: function(d) {
        //                 var option;
        //                 option += '<option value="' + d.id + '">' + d.city + '</option>';
        //                 $('.dcity').html(option);

        //             }
        //         });

        //     }
        // });
    </script>