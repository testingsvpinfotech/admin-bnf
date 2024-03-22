<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebarphp'); 
    ?>
    <!-- END: Main Menu-->


    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row p-2">
                        <div class="col-md-6">
                            <h6 class><i class="fas fa-star mr-2"></i>Company Profile</h6>
                        </div>
                        <hr>

                    </div>

                    <div class="col-12 col-md-12 mt-3">
                        <div class="card p-4">
                            <div class="card-body">

                                <?php echo validation_errors(); ?>

                                <form name="form" action="<?php echo base_url('FranchiseController/update_franchise_data_in/' . $customer->customer_id); ?>" enctype="multipart/form-data" method="POST">

                                    <?php //print_r($assign_pincode_for_delivery);   ?>

                                    <div class style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Personal Information</h6>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Franchise ID</label>
                                                    <input type="text" value="<?php echo $customer->cid; ?>" name="fid" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Password</label>
                                                    <input type="Password" class="form-control" name="password" placeholder="Enter Password" value="<?php echo $customer->password; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" name="passconf" value="<?php echo $customer->password; ?>" placeholder="Enter Confirm Password">
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
                                                <input type="text" name="franchise_name" placeholder="Enter Name" value="<?php echo $customer->customer_name; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group  col-md-3 ">
                                            <div class="form-group">
                                                <label class="control-label">S/O or D/O</label>
                                                <input type="text" name="franchise_relation" class="form-control" value="<?php echo $franchise_data->franchise_relation; ?>" placeholder="Enter Relation Name">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 ">
                                            <div class="form-group">
                                                <label class="control-label">Age</label>
                                                <input type="text" name="age" class="form-control manifest_coloader_contact" maxlength="3"value="<?php echo $franchise_data->age; ?>" placeholder="Enter Age">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" placeholder="Enter Email-Id" value="<?php echo $customer->email; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label">Residential Address </label>
                                                <textarea class="form-control" autocomplete="nope" rows="2" name="address" placeholder="Enter Your Addres"> <?php echo $customer->address; ?> </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label class="control-label">Contact No</label>
                                            <input type="text" autocomplete="nope" name="contact_number" value="<?php echo $customer->phone; ?>" pattern='^\+?\d{0,10}' class="form-control manifest_coloader_contact" maxlength="10" minlength="10" title="please check Contact Number" placeholder="contact_number">
                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <label class="control-label">Alternate Contact No</label>
                                            <input type="text" autocomplete="nope" name="alt_contact" value="<?php echo $customer->contact_person; ?>" class="form-control manifest_coloader_contact" maxlength="10" minlength="10" pattern='^\+?\d{0,10}' title="please check Alternate Contact Number" placeholder="Enter Alt Number">
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Pin Code</label>
                                            <input type="text" name="pincode" id="pincode" maxlength="6" minlength="6" value="<?php echo $customer->pincode; ?>" class="form-control" placeholder="Enter Pincode Number">
                                            <span class="errormsg" id="errormsg" style="color: #8b0001;font-weight: bold;"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">State</label>
                                            <select class="form-control filter-data" name="franchaise_state_id" id="franchaise_state">
                                                <option value>Select State</option>
                                                <?php foreach ($states as $state) { ?>
                                                            <option value="<?= $state['id']; ?>" <?php if ($customer->state == $state['id']) { ?> Selected <?php } ?>><?= $state['state']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">City</label>
                                            <select class="form-control filter-data" name="franchaise_city_id" id="franchaise_city">
                                                <option value>Select City</option>
                                                <?php foreach ($cities as $city) { ?>
                                                            <option value="<?= $city['id']; ?>" <?php if ($customer->city == $city['id']) { ?> Selected <?php } ?>><?= $city['city']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Master Franchise Name</label>
                                            <?php $parent = $this->db->query("SELECT master_franchise_name FROM franchise_delivery_tbl where delivery_franchise_id = $customer->customer_id ")->row(); ?>
                                            <input type="text" name="master_franchise_name" value="<?php echo $parent->master_franchise_name; ?>" id="master_franchise_name" class="form-control" placeholder="Enter Master Franchise">
                                            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer->customer_id; ?>"  class="form-control" placeholder="Enter Master Franchise">
                                            <input type="hidden" name="branch_id" id="branch_id"  value="<?php echo $customer->branch_id; ?>"class="form-control" placeholder="Enter Master Franchise">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Branch Name</label>
                                            <select class="form-control filter-data" name="branch_id" id="branch_id">
                                                <option value="">Select branch</option>
                                                <?php if (!empty ($branch)) { ?>
                                                            <?php foreach ($branch as $value): ?>

                                                                        <option value="<?php echo $value['branch_id']; ?>" <?php if ($value['branch_id'] == $customer->branch_id) { ?> Selected <?php } ?>><?php echo $value['branch_name']; ?></option>
                                                            <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Sale Person</label>
                                            <select class="form-control filter-data" name="sale_person" id="sale_person">
                                                <option value="">Select Sale Person</option>
                                                <?php if (!empty ($sale_person)) { ?>
                                                            <?php foreach ($sale_person as $value): ?>

                                                                        <option value="<?php echo $value->user_id; ?>" <?php if ($value->user_id == $customer->sale_person) { ?> Selected <?php } ?>><?php echo $value->full_name; ?></option>
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
                                                                        <option value="<?php echo $key; ?>" <?php if($customer->franchise_booking_type ==$key){echo 'selected';} ?> ><?php echo $value; ?></option>
                                                            <?php  $key++;}endforeach; ?>
                                                
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row show" <?php if($customer->franchise_booking_type !=1){ ?> style="display: none;" <?php } ?>>
                                        <div class="form-group col-md-3 required">
                                            <div class="form-group">
                                                <label class="control-label">Credit Limit</label>
                                                <input type="text" name="credit_limit" id="credit_limit" class="form-control" placeholder="Enter Credit Limit" required="" value="<?php echo $franchise_data->credit_limit; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 required">
                                            <div class="form-group">
                                                <label class="control-label">Credit Days</label>
                                                <input type="text" name="credit_days" id="credit_days" class="form-control"  placeholder="Enter Credit Days" maxlength="2" required="" value="<?php echo $franchise_data->credit_days; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Commission Group</label> <br>
                                            <select class="form-control filter-data col-md-12" name="commision_id" >
                                                <option value="">Select Commission Group</option>
                                                            <?php foreach ($commission as $key=> $value):
                                                                ?>
                                                                        <option value="<?php echo $value->group_id; ?>" <?php if($franchise_data->commision_id == $value->group_id){echo 'selected';} ?>><?php echo $value->group_name; ?></option>
                                                            <?php  endforeach; ?>                                                
                                            </select>
                                        </div>
                                        </div>
                                    </div>

                                    <br>  <br>
                                    <div class style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Delivery </h6>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group col-md-4 ">
                                            <label class="control-label">delivery</label>
                                            <select class="form-control filter-data" name="delivery_status" id="is_delivery">
                                                <option>Select delivery</option>
                                                <option value="1" <?php if ($delivery_franchise_data->delivery_status == 1) {
                                                    echo 'selected';
                                                } ?>>Yes</option>
                                                <option value="0" <?php if ($delivery_franchise_data->delivery_status == 0) {
                                                    echo 'selected';
                                                } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>

                                <?php if ($delivery_franchise_data->delivery_status == 1) { ?>
                                            <div id="deliver_yes">

                                                <div class="row" id="1001" data-id="1001">
                                                    <div class="form-group col-md-4" id="dpin">
                                                        <label class="control-label">Pin Code</label>
                                                        <input type="text" name="delivery_pincode[]" data-id="1001" value="<?php echo $delivery_franchise_data->delivery_pincode; ?>" class="form-control delivery_pincode" placeholder="Enter Pincode">
                                                    </div>
                                                    <div class="form-group col-md-4" id="delivery_city">
                                                        <label class="control-label">City</label>
                                                        <select class="form-control dcity" name="delivery_city[]" data-id="1001">
                                                        <?php foreach ($cities as $city) { ?>
                                                                    <option value="<?= $city['id']; ?>" <?php if ($delivery_franchise_data->delivery_city == $city['id']) { ?> Selected <?php } ?>><?= $city['city']; ?></option>
                                                        <?php } ?>
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
                                                            <?php if (!empty ($delivery_rate_group)) { ?>
                                                                        <option>Select Delivery Rate Group</option>
                                                                        <?php foreach ($delivery_rate_group as $value): ?>
                                                                                    <option value="<?php echo $value->group_id; ?>"<?php if ($value->group_id == $delivery_franchise_data->delivery_rate_group) {
                                                                                           echo 'selected';
                                                                                       } ?>><?php echo $value->group_name; ?> </option>
                                                                        <?php endforeach; ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                <?php } ?>


                                        <!-- <div id="show_column"></div> -->


<br><br>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Rate-Group</label>
                                                <select class="form-control filter-data" name="rate_group">
                                                    <?php if (!empty ($rate_group)) { ?>
                                                                <option>Select Rate Group</option>
                                                                <?php foreach ($rate_group as $value): ?>
                                                                            <option value="<?php echo $value->group_id; ?>"  <?php if ($value->group_id == $delivery_franchise_data->rate_group) {
                                                                                   echo 'selected';
                                                                               } ?>><?php echo $value->group_name; ?> </option>
                                                                <?php endforeach; ?>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="control-label">Fuel-Group</label>
                                                <select class="form-control filter-data" name="fule_group">
                                                    <?php if (!empty ($fuel_group)) { ?>
                                                                <option>Select Fuel Group</option>
                                                                <?php foreach ($fuel_group as $value): ?>
                                                                            <option value="<?php echo $value->group_id; ?>" <?php if ($value->group_id == $delivery_franchise_data->fule_group) {
                                                                                   echo 'selected';
                                                                               } ?>><?php echo $value->group_name; ?> </option>
                                                                <?php endforeach; ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- <div class style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                            <h6 class="mb-0 text-uppercase font-weight-bold">Delivery Rate Master </h6>
                                        </div>
                                         <br> -->
                                        


<br>

                                    <div class style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">KYC</h6>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Select Type of KYC</label>
                                                    <select class="form-control filter-data" name="companytype">
                                                        <option value>Select Type</option>
                                                        <option value="Sole Proprietorship" <?php if ($franchise_data->companytype == 'Sole Proprietorship') {
                                                            echo 'selected';
                                                        } ?>>Sole Proprietorship</option>
                                                        <option value="Partnership" <?php if ($franchise_data->companytype == 'Partnership') {
                                                            echo 'selected';
                                                        } ?>>Partnership</option>
                                                        <option value="Limited Liability Partnership" <?php if ($franchise_data->companytype == 'Limited Liability Partnership') {
                                                            echo 'selected';
                                                        } ?>>Limited Liability Partnership</option>
                                                        <option value="Public Limited Company" <?php if ($franchise_data->companytype == 'Public Limited Company') {
                                                            echo 'selected';
                                                        } ?>>Public Limited Company</option>
                                                        <option value="Private Limited Company" <?php if ($franchise_data->companytype == 'Private Limited Company') {
                                                            echo 'selected';
                                                        } ?>>Private Limited Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong style="margin-left:38%; font-size:20px;color:#ea6435;">Pan Card Details</strong>
                                            <div class="form-group ">
                                                <label class="control-label">Pan Name </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="pan_name" value="<?php echo $franchise_data->pan_name; ?>" placeholder="Enter Pan Name">
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="control-label">Pan Number </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"  title="Places check Pan Number" value="<?php echo $franchise_data->pan_number; ?>" name="pan_number" maxlength="10" minlength="10" placeholder="Enter Pan Card Number">
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="control-label">Upload PANCard Photo</label>
                                                <input type="file" name="pancard_photo" id="pancard_photo">
                                                <br>
                                                <?php if (!empty($franchise_data->pancard_photo)) { 
                                                      $ext = explode('.',$franchise_data->pancard_photo);
                                                    if($ext[1] =='pdf'){?>
                                                    <a href="<?= base_url('assets/franchise-documents/pancard_document/'.$franchise_data->pancard_photo);?>" target="_blank"><i class="fa fa-link" aria-hidden="true"> View PDF</i></a>
                                                    <?php }else{?>
                                                    <a href="assets/franchise-documents/pancard_document/<?php echo $franchise_data->pancard_photo; ?>" src="assets/franchise-documents/pancard_document/<?php echo $franchise_data->pancard_photo; ?>" title="<?php echo $franchise_data->pancard_photo; ?>" onclick="show_image(this);return false;" style="color:blue;">View PANCard Image</a>
                                                    <?php } ?>

                                                <?php } ?>
                                            </div>
                                        </div>


                                        <div class="col-md-6" style="margin-top: -30px;">
                                            <strong style="margin-left:38%; font-size:20px;color:#ea6435;">Aadhar Card Details</strong>
                                            <!--<hr>-->
                                            <!--<hr style="border-bottom: 2px solid #000;">-->
                                            <div class="form-row">


                                                <div class="col-md-6 form-group ">
                                                    <label class="control-label">Aadhar Number </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" title="places check Aadhar Number" value="<?php echo $franchise_data->aadhar_number; ?>" name="aadhar_number" maxlength="12" minlength="12" placeholder="Enter Aadhar Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group ">
                                                    <label class="control-label">Full Name</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="aadharin_name" value="<?php echo $franchise_data->aadharin_name; ?>" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 form-group">
                                                    <label class="control-label">DOB<span class>*</span></label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" value="<?php echo $franchise_data->dob; ?>" name="dob">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="control-label">Gender<span class>*</span></label>
                                                    <div class="input-group">
                                                        <input type="radio" class="form-control" value="Male" <?php if ($franchise_data->gender == 'Male') {
                                                            echo 'checked="checked"';
                                                        } ?> name="gender">Male
                                                        <input type="radio" class="form-control" value="Female" <?php if ($franchise_data->gender == 'Female') {
                                                            echo 'checked="checked"';
                                                        } ?> name="gender">Female
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label">Address<span class>*</span></label>
                                                    <div class="input-group">
                                                        <textarea type="text" class="form-control" name=" aadhar_address" placeholder="Enter Address">  <?php echo $franchise_data->aadhar_address; ?> </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label">Upload AadharCard Photo</label>
                                                        <input type="file" name="aadharcard_photo" id="aadharcard_photo" formenctype="multipart/form-data">
                                                        <br>
                                                        <?php if (!empty($franchise_data->aadharcard_photo)) { 
                                                            $ext = explode('.',$franchise_data->aadharcard_photo);
                                                            if($ext[1] =='pdf'){?>
                                                            <a href="<?= base_url('assets/franchise-documents/aadharcard_document/'.$franchise_data->aadharcard_photo);?>" target="_blank"><i class="fa fa-link" aria-hidden="true"> View PDF</i></a>
                                                            <?php }else{?>
                                                            <a href="assets/franchise-documents/aadharcard_document/<?php echo $franchise_data->aadharcard_photo; ?>" src="assets/franchise-documents/pancard_document/<?php echo $franchise_data->aadharcard_photo; ?>" title="<?php echo $franchise_data->aadharcard_photo; ?>" onclick="show_image(this);return false;" style="color:blue;">View AadharCard Image</a>
                                                            <?php } ?>
                                                          <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <br>

                                    <div class style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Company Information</h6>
                                    </div>




                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label>Firm Name </label>
                                                    <input type="text" name="company_name" placeholder="Enter Company Name" class="form-control" value="<?php echo $franchise_data->company_name; ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">PAN Number</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="nope" id="pan_no" value="<?php echo $franchise_data->cmp_pan_number; ?>" name="cmp_pan_number" title="Places Check Pan Number" maxlength="10" minlength="10" placeholder="Enter Pan Number" class="form-control">
                                                        <div class="input-group-append">
                                                            <a href="javascript:void(0)" class="btn btn" style="background-color:#109693;color:#fff;">Verified</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">GST Number</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="nope" id="gst_no" value="<?php echo $franchise_data->cmp_gstno; ?>" name="cmp_gstno" title="Places Check GST Number" placeholder="GST Number" class="form-control" maxlength="15" minlength="1">
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
                                                    <input type="text" class="form-control" value="<?php echo $franchise_data->legal_name; ?>" name="legal_name" placeholder="Enter Legal Name" requird>
                                                </div>
                                                <div class="form-group col-md-3 ">
                                                    <label class="control-label">Constitution of Business</label>
                                                    <input type="text" autocomplete="nope" name="constitution_of_business" value="<?php echo $franchise_data->constitution_of_business; ?>" placeholder="Enter Constitution of Business" class="form-control" requird>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Taxpayer Type</label>
                                                    <div class="input-group">
                                                        <input type="text" id="taxpayer_type" autocomplete="nope" value="<?php echo $franchise_data->taxpayer_type; ?>" name="taxpayer_type" class="form-control" placeholder="Enter Taxpayer Type" requird>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">GST Status</label>
                                                    <div class="input-group">
                                                        <input type="text" autocomplete="nope" name="gstin_status" value="<?php echo $franchise_data->gstin_status; ?>" placeholder class="form-control" requird>
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
                                            <div class="form-group ">
                                                <label class="control-label">Office Address</label>
                                                <textarea autocomplete="nope" class="form-control" placeholder="Enter office address" rows="5" name="cmp_address"> <?php echo $franchise_data->cmp_address; ?> </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-row">
                                                <div class="form-group col-md-4 ">
                                                    <label class="control-label">Pin Code</label>
                                                    <input type="text" id="cmppincode" autocomplete="nope" value="<?php echo $franchise_data->cmp_pincode; ?>" name="cmp_pincode" class="form-control" placeholder="Enter Pincode Number" maxlength="6" minlength="6" title="Places Check Pincode Number" />
                                                    <span class="errormsg" id="officeerrormsg" style="color: #8b0001;font-weight: bold;"></span>
                                                </div>

                                                <div class="form-group col-md-4 ">
                                                    <label class="control-label">State</label>
                                                    <select class="form-control filter-data" name="cmp_state" id="cmp_state">
                                                        <?php foreach ($states as $state) { ?>
                                                                    <option value="<?= $state['id']; ?>" <?php if ($franchise_data->cmp_state == $state['id']) { ?> Selected <?php } ?>><?= $state['state']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 ">
                                                    <label class="control-label">City</label>
                                                    <select class="form-control filter-data" name="cmp_city" id="cmp_city">
                                                        <option value="">Select City</option>
                                                        <?php foreach ($cities as $city) { ?>
                                                                    <option value="<?= $city['id']; ?>" <?php if ($franchise_data->cmp_city == $city['id']) { ?> Selected <?php } ?>><?= $city['city']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 ">
                                                    <label class="control-label">Telephone No</label>
                                                    <input type="text" autocomplete="nope" value="<?php echo $franchise_data->cmp_office_phone; ?>" name="cmp_office_phone" pattern='^\+?\d{0,10}' title="please check Telephone Number" placeholder="Enter Telephone No" class="form-control">
                                                </div>

                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">Area</label>
                                                    <input type="text" autocomplete="nope" value="<?php echo $franchise_data->cmp_area; ?>" name="cmp_area"  placeholder="Enter Area" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class style="margin-bottom:20px; background-color:#e9511e;color:#fff;padding:10px;">
                                        <h6 class="mb-0 text-uppercase font-weight-bold">Bank Details</h6>
                                    </div>


                                    <div class="row">
                                        <div class="form-row">
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">Upload Cancel Cheque</label>
                                                <input type="file" name="cancel_check" id="cancel_check"  class="form-control" formenctype="multipart/form-data">
                                                 <br>
                                                <?php if (!empty($franchise_data->cancel_check)) { 
                                                    $ext = explode('.',$franchise_data->cancel_check);
                                                    if($ext[1] =='pdf'){?>
                                                    <a href="<?= base_url('assets/franchise-documents/bank_document/'.$franchise_data->cancel_check);?>" target="_blank"><i class="fa fa-link" aria-hidden="true"> View PDF</i></a>
                                                    <?php }else{?>
                                                    <a href="assets/franchise-documents/bank_document/<?php echo $franchise_data->cancel_check; ?>" src="assets/franchise-documents/bank_document/<?php echo $franchise_data->cancel_check; ?>" title="<?php echo $franchise_data->cancel_check; ?>" onclick="show_image(this);return false;" style="color:blue;">View Cancel Cheque</a>
                                                    <?php } } ?>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">A/C Name</label>
                                                <input type="text" autocomplete="nope" name="cmp_account_name" placeholder=" Enter Account Name" value="<?php echo $franchise_data->cmp_account_name; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">A/C Number</label>
                                                <input type="text" autocomplete="nope" name="cmp_account_number" class="form-control manifest_coloader_contact" value="<?php echo $franchise_data->cmp_account_number; ?>" placeholder="Enter Account Number">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">Bank Name</label>
                                                <input type="text" autocomplete="nope" name="cmp_bank_name" class="form-control" value="<?php echo $franchise_data->cmp_bank_name; ?>" placeholder="Enter Bank Name">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">Branch</label>
                                                <input type="text" autocomplete="nope" name="cmp_bank_branch" class="form-control" value="<?php echo $franchise_data->cmp_bank_branch; ?>" Placeholder="Enter Branch Name">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">Acc Type</label>
                                                <input type="text" autocomplete="nope" name="cmp_acc_type" class="form-control" value="<?php echo $franchise_data->cmp_acc_type; ?>" Placeholder="Enter Account Type">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">IFSC Code</label>
                                                <input type="text" autocomplete="nope" name="cmp_ifsc_code" value="<?php echo $franchise_data->cmp_ifsc_code; ?>" class="form-control" placeholder="Enter IFSC Code">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <button type="submit" name="submit" class="btn  btn-lg btn-success mt-2">Submit</button>
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

        form-group {
            margin-bottom: 20px !important;
        }
    </style>

<div id="myModal" class="modal">
         <span class="close-image-modal">&times;</span>
         <img class="modal-content" id="img01">
         <div id="caption"></div>
       </div>
       <style type="text/css">
         /* The Modal (background) */
         .modal {
           display: none;
           /* Hidden by default */
           position: fixed;
           /* Stay in place */
           z-index: 1;
           /* Sit on top */
           padding-top: 100px;
           /* Location of the box */
           left: 0;
           top: 0;
           width: 100%;
           /* Full width */
           height: 100%;
           /* Full height */
           overflow: auto;
           /* Enable scroll if needed */
           background-color: rgb(0, 0, 0);
           /* Fallback color */
           background-color: rgba(0, 0, 0, 0.9);
           /* Black w/ opacity */
         }

         /* Modal Content (image) */
         .modal-content {
           margin: auto;
           display: block;
           width: 50%;
           max-width: 700px;
         }

         /* Caption of Modal Image */
         #caption {
           margin: auto;
           display: block;
           width: 80%;
           max-width: 700px;
           text-align: center;
           color: #ccc;
           padding: 10px 0;
           height: 150px;
         }

         /* Add Animation */
         .modal-content,
         #caption {
           -webkit-animation-name: zoom;
           -webkit-animation-duration: 0.6s;
           animation-name: zoom;
           animation-duration: 0.6s;
         }

         @-webkit-keyframes zoom {
           from {
             -webkit-transform: scale(0)
           }

           to {
             -webkit-transform: scale(1)
           }
         }

         @keyframes zoom {
           from {
             transform: scale(0)
           }

           to {
             transform: scale(1)
           }
         }

         /* The Close Button */
         .close-image-modal {
           position: absolute;
           /*top: 15px;*/
           right: 35px;
           color: #f1f1f1;
           font-size: 40px;
           font-weight: bold;
           transition: 0.3s;
         }

         .close-image-modal:hover,
         .close-image-modal:focus {
           color: #bbb;
           text-decoration: none;
           cursor: pointer;
         }

         /* 100% Image Width on Smaller Screens */
         @media only screen and (max-width: 700px) {
           .modal-content {
             width: 100%;
           }
         }
       </style>

    <?php $this->load->view('admin/admin_shared/admin_footer'); ?>


    <script>
       // Get the modal
       var modal = document.getElementById("myModal");

       function show_image(obj) {
         var captionText = document.getElementById("caption");
         var modalImg = document.getElementById("img01");
         modal.style.display = "block";
         // alert(obj.tagName);
         if (obj.tagName == 'A') {
           modalImg.src = obj.href;
           captionText.innerHTML = obj.title;
         }
         if (obj.tagName == 'img') {
           modalImg.src = obj.src;
           captionText.innerHTML = obj.alt;
         }

         // modalImg.src = 'http://www.safedart.in/assets/pod/pod_1.jpg';

       }
       var span = document.getElementsByClassName("close-image-modal")[0];

       // When the user clicks on <span> (x), close the modal
       span.onclick = function() {
         modal.style.display = "none";
       }


       // Get the image and insert it inside the modal - use its "alt" text as a caption




       // Get the <span> element that closes the modal
     </script>  
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
            if(deliveryYes == '1'){
                $("#deliver_yes").show();
            }else{
                $("#deliver_yes").hide(); 
            }
        });


        jQuery(document).off('blur', '.delivery_pincode');
        jQuery(document).on('blur', '.delivery_pincode', function (e) {
            e.preventDefault();
            var delivery_pincode = jQuery(this).val();
            //alert(district_id);
            let delivery_pincode_random = $(this).attr('id');
            let row_id = $(this).closest('.row').attr('data-id');
        
            getCityList(delivery_pincode,row_id);
        });



             function getCityList(delivery_pincode,row_id) {
                $.ajax({
                    type: 'POST',
                    url: 'FranchiseController/get_delivery_pincode_city',
                    data: 'delivery_pincode=' + delivery_pincode,
                    dataType: "json",
                    success: function(d) {
                        var options = '';
                        // options += '<option value="">Select City</option>';
                        options += '<option value="' + d.id + '">' + d.city + '</option>';
                        jQuery("#"+row_id).find(".dcity").html(options);
                        

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



        $('#add_data').click(function(){

            let time_stamp = Date.now();
            let new_html = '';
            new_html = $html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);
            new_html = new_html.replace('#RANDOM_NO#', time_stamp);

            $('#show_column').append(new_html)
           
        });

        $(document).on('click', 'button.removebutton', function () {
           $("#remove_row").remove();
            return false;
        });



        $('#delivery_rate_master').change(function() {
            var d_rate_master = $(this).val();
            if(d_rate_master == '1'){
                $("#doc").show();
                $("#non_doc").hide(); 
            }else if(d_rate_master == '0'){
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

                // $.ajax({
                //     type: 'POST',
                //     url: 'FranchiseController/getFranchiseMaster',
                //     data: 'pincode=' + pincode,
                //     dataType: "json",
                //     success: function(d) {
                //         console.log(d);
                //         $('#customer_id').val(d.customer_id);
                //         $('#master_franchise_name').val(d.customer_name);
                //     }
                // });
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
                    success: function (d) {         
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