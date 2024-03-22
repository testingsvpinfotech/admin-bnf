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
                                <form name="form" action="<?php echo base_url('MasterFranchiseController/update_master_franchise_data/'.$franchise_data->fid);?>" enctype="multipart/form-data" method="POST" >
                                  <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                    <h6 class="mb-0 text-uppercase font-weight-bold">Personal Information</h6>
                                </div>
                                 
                                 <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Franchise ID</label>
                                                 <input type="text"  value="<?php echo $customer->cid ; ?>" name="fid" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Username</label>
                                                 <input type="text" class="form-control" name="username" placeholder="Enter Username" value="<?php echo $customer->customer_name ; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Name</label>
                                            <input type="text" name="franchise_name" placeholder="Enter Name" value="<?php echo $customer->customer_name ; ?>" class="form-control">
                                        </div>
                                    </div>
                                  
                                     <div class="col-md-12"> <hr></div><br>
                                </div>

                                <div class="row">
                                    

                                    <div class="form-group  col-md-3 required">
                                        <div class="form-group">
                                            <label class="control-label">S/O or D/O</label>
                                            <input type="text" name="franchise_relation" class="form-control"  value="<?php echo $franchise_data->franchise_relation ; ?>" placeholder="Enter Relation Name" required="">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 required">
                                        <div class="form-group">
                                            <label class="control-label">Age</label>
                                            <input type="text" name="age" class="form-control manifest_driver_contact" maxlength="3" minlength="2" value="<?php echo $franchise_data->age ; ?>" placeholder="Enter Age" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="email" name="email" placeholder="Enter Email-Id"  value="<?php echo $customer->email ; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"> Sale Person <?php echo $customer->sale_person; ?></label>
                                            <select name="fr_sale_person" id="fr_sale_person" class="form-control filter-data">
                                                <option>Select Sale Person</option>
                                                <?php if(!empty($sale_person)): foreach ($sale_person as $value): ?>
                                                  <option value="<?= $value->user_id ?>" <?php echo ($value->user_id == $customer->sale_person)?'selected':''; ?>><?= $value->full_name ?></option>>  
                                                <?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12"> <hr></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">Residential Address </label>
                                            <textarea class="form-control" autocomplete="nope" rows="5" name="address" placeholder ="Enter Your Addres.."> <?php echo $customer->address ; ?> </textarea>
                                        </div>
                                    </div>


                                    <div class="col-md-8">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Pin Code</label>
                                                <input type="text"  name="pincode" id="pincode" maxlength="6" minlength="6"  value="<?php echo $customer->pincode ; ?>"  class="form-control" placeholder="Enter Pincode Number">
                                                <span class="errormsg" id="errormsg" style="color: #8b0001;font-weight: bold;"></span>
                                            </div>
                                           
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">State</label>
                                                 <select class="form-control filter-data"  name="franchaise_state_id"  id="franchaise_state" required="">
                                                    <option value="">Select State</option>    
                                                     <?php foreach($states as $state){  ?>
                                                     <option value="<?=$state['id'];?>" <?php if($customer->state == $state['id']){ ?> Selected <?php } ?>><?=$state['state'];?></option> 
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                            
                                             <div class="form-group col-md-4 ">
                                                <label class="control-label">City</label>
                                                <select class="form-control filter-data"  name="franchaise_city_id" id="franchaise_city" required="">
                                                    <option value="">Select City</option>  
                                                    <?php foreach($cities as $city){  ?>
                                                     <option value="<?=$city['id'];?>" <?php if($customer->city == $city['id']){ ?> Selected <?php } ?>><?=$city['city'];?></option> 
                                                    <?php }  ?>
                                                </select>
                                              </div>

                                              <div class="form-group col-md-4 ">
                                                <label class="control-label">Branch Name</label>
                                                <select class="form-control filter-data"  name="branch_id" id="branch_id" >
                                                    <?php if(!empty($branch)){ ?>
                                                       <?php foreach($branch as $value):?> 
                                                        <option value="">Select branch</option> 
                                                        <option value="<?php echo $value['branch_id'] ;?>" <?php if( $value['branch_id'] == $customer->branch_id){ ?> Selected <?php } ?>><?php echo $value['branch_name'] ;?></option>
                                                       <?php endforeach;?>
                                                     <?php }?>          
                                                </select>
                                              </div>
                                            
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">Contact No</label>
                                                <input type="text" autocomplete="nope" name="contact_number"  value="<?php echo $customer->phone ; ?>" pattern='^\+?\d{0,10}' class="form-control manifest_driver_contact" maxlength="10" minlength="10" title ="please check Contact Number" placeholder="contact_number" required>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">Alternate Contact No</label>
                                                <input type="text" autocomplete="nope" name="alt_contact"  value="<?php echo $customer->contact_person ; ?>" class="form-control manifest_driver_contact" pattern='^\+?\d{0,10}' maxlength="10" minlength="10" title ="please check Alternate Contact Number" placeholder="Enter Alt Number">
                                            </div>
                                            <div class="form-group col-md-4">
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
                                        <div class="row show" <?php if($customer->franchise_booking_type !=1){ ?> style="display: none;" <?php } ?>>
                                        <div class="form-group col-md-4 required">
                                            <div class="form-group">
                                                <label class="control-label">Credit Limit</label>
                                                <input type="text" name="credit_limit" id="credit_limit" class="form-control" placeholder="Enter Credit Limit" required="" value="<?php echo $franchise_data->credit_limit; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <div class="form-group">
                                                <label class="control-label">Credit Days</label>
                                                <input type="text" name="credit_days" id="credit_days" class="form-control"  placeholder="Enter Credit Days" maxlength="2" required="" value="<?php echo $franchise_data->credit_days; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Commission Group</label>
                                            <select class="form-control filter-data" name="commision_id" id="sale_person">
                                                <option value="">Select Commission Group</option>
                                                <?php foreach ($commission as $key=> $value):
                                                    ?>
                                                            <option value="<?php echo $value->group_id; ?>" <?php if($franchise_data->commision_id == $value->group_id){echo 'selected';} ?>><?php echo $value->group_name; ?></option>
                                                <?php  endforeach; ?>                                                
                                            </select>
                                        </div>
                                    </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- ========== DELIVERY SECTION ============= -->

                                 <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                    <h6 class="mb-0 text-uppercase font-weight-bold">Delivery </h6>
                                </div>
                               
                                <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">delivery</label>
                                            <select class="form-control filter-data" required name="delivery_status" id="is_delivery">
                                                <option value="">Select delivery</option>
                                                <option value="1" <?= (!empty($delivery_franchise_data) && $delivery_franchise_data->delivery_status == 1)?'selected':''; ?>>Yes</option>
                                                <option value="0" <?= (!empty($delivery_franchise_data) && $delivery_franchise_data->delivery_status == 0)?'selected':''; ?>>No</option>
                                            </select>
                                        </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">Delivery rate Group</label>
                                                <select class="form-control filter-data" name="delivery_rate_group">
                                                    <?php if (!empty($delivery_rate_group)) { ?>
                                                        <option value="">Select Delivery Rate Group</option>
                                                        <?php foreach ($delivery_rate_group as $value) : ?>
                                                            <option value="<?php echo $value->group_id; ?>" <?= (!empty($delivery_franchise_data) && $delivery_franchise_data->delivery_rate_group == $value->group_id)?'selected':''; ?>><?php echo $value->group_name; ?> </option>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Rate-Group</label>
                                            <select class="form-control filter-data" required name="rate_group">
                                                <?php if (!empty($rate_group)) { ?>
                                                    <option value="">Select Rate Group</option>
                                                    <?php foreach ($rate_group as $value) : ?>
                                                        <option value="<?php echo $value->group_id; ?>"  <?= (!empty($delivery_franchise_data) && $delivery_franchise_data->rate_group == $value->group_id)?'selected':''; ?>><?php echo $value->group_name; ?> </option>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">Fuel-Group</label>
                                            <select class="form-control filter-data" required name="fule_group">
                                                <?php if (!empty($fuel_group)) { ?>
                                                    <option value="">Select Fuel Group</option>
                                                    <?php foreach ($fuel_group as $value) : ?>
                                                        <option value="<?php echo $value->group_id; ?>" <?= (!empty($delivery_franchise_data) && $delivery_franchise_data->fule_group == $value->group_id)?'selected':''; ?>><?php echo $value->group_name; ?> </option>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-8">
                                            <div class="box box-secondary p-2" id="delivery_pincode_visible" style="background: #00000012">
                                                <div class="box-body">
                                                    <table class="table table-border">
                                                        <tr>
                                                            <th>Pincode</th>
                                                            <th>City</th>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td><input class="form-control" id="pin" maxlength="6" minlength="6" placeholder="Enter Pincode"></td>
                                                            <td>
                                                                <!-- <input type="hidden" id="fcity_id" class="form-control" readonly=""> -->
                                                                <!-- <input id="fcity" class="form-control" placeholder="Enter City" readonly=""> -->
                                                                <!-- <select class="form-control" id="fcity">
                                                                    <option value="">Please Select</option>
                                                                </select> -->
                                                            </td>
                                                            <td><button type="button" class="btn btn-success" id="adddel_data"><i class="fa fa-plus"></i></button></td>
                                                        </tr>
                                                        <tbody id="show_column">
                                                            <?php $fcnt = 1; 
                                                                if(!empty($delivery_franchise_data->delivery_pincode)): 
                                                                    $pin_data = explode(',', $delivery_franchise_data->delivery_pincode);
                                                                    $city_data = explode(',', $delivery_franchise_data->delivery_city);
                                                                    for ($i=0; $i < count($pin_data); $i++) { 
                                                                        $city_name = $this->db->get_where('pincode',['city_id' => $city_data[$i]])->row('city');
                                                            ?>
                                                            <tr id="frow<?= $fcnt; ?>">
                                                                <td><input class="form-control" name="frpincode[]" id="frpincode<?= $fcnt; ?>" value="<?= $pin_data[$i]; ?>" readonly></td>
                                                                <td>
                                                                    <input class="form-control" type="hidden" name="frcity_id[]" id="frcity_id<?= $fcnt; ?>" value="<?= $city_data[$i]; ?>" readonly>
                                                                    <input class="form-control" name="frcity[]" id="frcity<?= $fcnt; ?>" value="<?= $city_name; ?>" readonly>
                                                                </td>
                                                                <td><button type="button" class="btn btn-danger" onclick="remove_delpincode(<?= $fcnt; ?>)"><i class="fa fa-minus"></i></button></td>
                                                            </tr>
                                                            <?php $fcnt++; } endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
                                <!-- ========== KYC SECTION ============= -->
                                <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                    <h6 class="mb-0 text-uppercase font-weight-bold">KYC</h6>
                                </div>

                              
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Select Type of KYC</label>
                                                <select class="form-control filter-data" name="companytype" required>
                                                    <!-- <option value="">Select Type</option> -->
                                                    <option value="Sole Proprietorship" <?php if($customer->company_id == 'Sole Proprietorship'){ echo 'selected';}?>>Sole Proprietorship</option>
                                                    <option value="Partnership" <?php if($customer->company_id == 'Partnership'){ echo 'selected';}?>>Partnership</option>
                                                    <option value="Limited Liability Partnership" <?php if($customer->company_id == 'Limited Liability Partnership'){ echo 'selected';}?>>Limited Liability Partnership</option>
                                                    <option value="Public Limited Company" <?php if($customer->company_id == 'Public Limited Company'){ echo 'selected';}?>>Public Limited Company</option>
                                                    <option value="Private Limited Company" <?php if($customer->company_id == 'Private Limited Company'){ echo 'selected';}?>>Private Limited Company</option>
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
                                                <input type="text"  class="form-control" name="pan_name" value="<?php echo $franchise_data->pan_name ; ?>"  placeholder="Enter Pan Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label class="control-label">Pan Number </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" title="Places check Pan Number" value="<?php echo $franchise_data->pan_number ; ?>"  name="pan_number" maxlength="10" minlength="10" placeholder="Enter Pan Card Number"required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-6 required">
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Upload PANCard Photo</label>
                                                <input type="file" name="pancard_photo" id="pancard_photo" value="<?php echo set_value('pancard_photo') ?>" >
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
                                    </div>


                                    <div class="col-md-6" style="margin-top: -30px;">
                                        <strong style="margin-left:38%; font-size:20px;color:#ea6435;">Aadhar Card Details</strong>
                                        <!--<hr>-->
                                        <!--<hr style="border-bottom: 2px solid #000;">-->
                                        <div class="form-row">
                                            
                                            
                                             <div class="col-md-6 form-group required">
                                                <label class="control-label">Aadhar Number </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control manifest_driver_contact" title="places check Aadhar Number" value="<?php echo $franchise_data->aadhar_number ; ?>"  name="aadhar_number" maxlength="12" minlength="12" placeholder="Enter Aadhar Number" required>
                                                </div>
                                            </div>
                                             <div class="col-md-6 form-group required">
                                                <label class="control-label">Full Name</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"  name="aadharin_name" value="<?php echo $franchise_data->aadharin_name ; ?>" placeholder="Enter Name" required>
                                                </div>
                                            </div>
                                       </div>

                                        <div class="form-row">
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">DOB<span class="required">*</span></label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" value="<?php echo $franchise_data->dob ; ?>" name="dob" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group" required>
                                                <label class="control-label">Gender<span class="required">*</span></label>
                                                <div class="input-group">
                                                    <input type="radio"  class="form-control" value="Male"<?php if($franchise_data->gender == 'Male'){ echo 'checked="checked"'; } ?> name="gender">Male
                                                    <input type="radio" class="form-control" value ="Female"<?php if($franchise_data->gender == 'Female'){ echo 'checked="checked"'; } ?> name="gender">Female
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col-md-6" required>
                                                <label class="control-label">Address<span class="required">*</span></label>
                                                <div class="input-group">
                                                    <textarea type="text" class="form-control" name=" aadhar_address" placeholder="Enter Address" required> <?php echo $franchise_data->aadhar_address ; ?> </textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 required">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label">Upload AadharCard Photo</label>
                                                    <input type="file" name="aadharcard_photo" id="aadharcard_photo" value="<?php echo set_value('aadharcard_photo') ?>" formenctype="multipart/form-data">
                                                  <br>  <?php if (!empty($franchise_data->aadharcard_photo)) { 
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


                                <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                    <h6 class="mb-0 text-uppercase font-weight-bold">Company Information</h6>
                                </div>




                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Firm Name </label>
                                                <input type="text" name="company_name" value="<?php echo $franchise_data->company_name ; ?>" placeholder="Enter Company Name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">PAN Number</label>
                                                <div class="input-group">
                                                    <input type="text"  value="<?php echo $franchise_data->cmp_pan_number ; ?>" name="cmp_pan_number" title="Places Check Pan Number" maxlength="10" minlength="10" placeholder="Enter Pan Number" class="form-control" required>
                                                    <div class="input-group-append">
                                                        <a href="javascript:void(0)" class="btn btn" style="background-color:#109693;color:#fff;">Verified</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">GST Number</label>
                                                <div class="input-group">
                                                    <input type="text" autocomplete="nope" id="gst_no" value="<?php echo $franchise_data->cmp_gstno ; ?>" name="cmp_gstno"  title="Places Check GST Number" placeholder="GST Number"class="form-control" maxlength="15" minlength="1" required>
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
                                                <input type="text" class="form-control" value="<?php echo $franchise_data->legal_name ; ?>" name="legal_name" placeholder="Enter Legal Name" requird> 
                                            </div>
                                            <div class="form-group col-md-3 required">
                                                <label class="control-label">Constitution of Business</label>
                                                <input type="text" autocomplete="nope" name="constitution_of_business" value="<?php echo $franchise_data->constitution_of_business ; ?>" placeholder="Enter Constitution of Business" class="form-control"requird>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">Taxpayer Type</label>
                                                <div class="input-group">
                                                    <input type="text" id="taxpayer_type" autocomplete="nope" value="<?php echo $franchise_data->taxpayer_type ; ?>" name="taxpayer_type" class="form-control" placeholder="Enter Taxpayer Type" requird>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">GST Status</label>
                                                <div class="input-group">
                                                    <input type="text" autocomplete="nope" name="gstin_status" value="<?php echo $franchise_data->gstin_status ; ?>" placeholder="" class="form-control" requird>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" style="padding-top:10px;"> <hr></div><br>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">Office Address</label>
                                                <textarea autocomplete="nope" class="form-control" placeholder="Enter office address"  rows="5" name="cmp_address" required=""> <?php echo $franchise_data->cmp_address ; ?> </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-row">
                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">Pin Code</label>
                                                    <input type="text" id="cmppincode" autocomplete="nope" value="<?php echo $franchise_data->cmp_pincode ; ?>" name="cmp_pincode" class="form-control" placeholder="Enter Pincode Number" title="Places Check Pincode Number" maxlength="6" minlength="6" required />
                                                    <span class="errormsg" id="officeerrormsg" style="color: #8b0001;font-weight: bold;"></span>
                                                </div>
                                                
                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">State</label>
                                                    <select class="form-control filter-data"  name="cmp_state" id="cmp_state" required="">
                                                    <?php foreach($states as $state){  ?>
                                                     <option value="<?=$state['id'];?>" <?php if($franchise_data->cmp_state == $state['id']){ ?> Selected <?php } ?>><?=$state['state'];?></option> 
                                                    <?php }  ?>           
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">City</label>
                                                     <select class="form-control filter-data"  name="cmp_city" id="cmp_city" required="">
                                                       
                                                       <?php foreach($cities as $city){  ?>
                                                         <option value="<?=$city['id'];?>" <?php if($franchise_data->cmp_city == $city['id']){ ?> Selected <?php } ?>><?=$city['city'];?></option> 
                                                       <?php }  ?>       
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 required">
                                                    <label class="control-label">Telephone No</label>
                                                    <input type="text" autocomplete="nope" value="<?php echo $franchise_data->cmp_office_phone ; ?>"  name="cmp_office_phone" pattern='^\+?\d{0,10}' title ="please check Telephone Number" placeholder="Enter Telephone No" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               


                                <div class="" style="margin-bottom:20px; background-color:#1e3d5d;color:#fff;padding:10px;">
                                    <h6 class="mb-0 text-uppercase font-weight-bold">Bank Details</h6>
                                </div>


                                <div class="row">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">Upload Cancel Check</label>
                                            <input type="file" name="cancel_check"  id="cancel_check"  class="form-control" formenctype="multipart/form-data" >
                                            <br>
                                                <?php if (!empty($franchise_data->cancel_check)) { 
                                                    $ext = explode('.',$franchise_data->cancel_check);
                                                    if($ext[1] =='pdf'){?>
                                                    <a href="<?= base_url('assets/franchise-documents/bank_document/'.$franchise_data->cancel_check);?>" target="_blank"><i class="fa fa-link" aria-hidden="true"> View PDF</i></a>
                                                    <?php }else{?>
                                                    <a href="assets/franchise-documents/bank_document/<?php echo $franchise_data->cancel_check; ?>" src="assets/franchise-documents/bank_document/<?php echo $franchise_data->cancel_check; ?>" title="<?php echo $franchise_data->cancel_check; ?>" onclick="show_image(this);return false;" style="color:blue;">View Cancel Cheque</a>
                                                    <?php } } ?>
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">A/C Name</label>
                                            <input type="text" autocomplete="nope" name="cmp_account_name" placeholder=" Enter Account Name" value="<?php echo $franchise_data->cmp_account_name ; ?>" class="form-control" required="">
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">A/C Number</label>
                                            <input type="text" autocomplete="nope" name="cmp_account_number" class="form-control manifest_driver_contact"  value="<?php echo $franchise_data->cmp_account_number ; ?>" placeholder="Enter Account Number" required="">
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">Bank Name</label>
                                            <input type="text" autocomplete="nope" name="cmp_bank_name" class="form-control" value="<?php echo $franchise_data->cmp_bank_name ; ?>" placeholder ="Enter Bank Name" required="">
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">Branch</label>
                                            <input type="text" autocomplete="nope" name="cmp_bank_branch" class="form-control" value="<?php echo $franchise_data->cmp_bank_branch ; ?>" Placeholder="Enter Branch Name" required="">
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">Acc. Type</label>
                                            <input type="text" autocomplete="nope" name="cmp_acc_type" class="form-control" value="<?php echo $franchise_data->cmp_acc_type ; ?>" Placeholder="Enter Account Type" required="">
                                        </div>
                                        <div class="form-group col-md-4 required">
                                            <label class="control-label">IFSC Code</label>
                                            <input type="text" autocomplete="nope" name="cmp_ifsc_code"  value="<?php echo $franchise_data->cmp_ifsc_code ; ?>" class="form-control" placeholder="Enter IFSC Code" required="">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn  btn-lg btn-primary mt-2">Submit</button>
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

    <?php $this->load->view('admin/admin_shared/admin_footer');?>
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
  //======================

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

// ***************franchise persnal Details use Pincode
  $("#pincode").on('blur', function () 
  {
    var pincode = $(this).val();
    if (pincode != null || pincode != '') {

    
      $.ajax({
        type: 'POST',
        url: 'MasterFranchiseController/getCityList',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) {         
          var option;         
          option += '<option value="' + d.id + '">' + d.city + '</option>';
          $('#franchaise_city').html(option);
          
        }
      });
      $.ajax({
        type: 'POST',
        url: 'MasterFranchiseController/getState',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) {         
          var option;         
          option += '<option value="' + d.id + '">' + d.state + '</option>';
          $('#franchaise_state').html(option);          
        }
      });
    }
  }); 
  
// ***************company Details use Pincode
  $("#cmppincode").on('blur', function () 
  {
    var cmppincode = $(this).val();
    if (cmppincode != null || cmppincode != '') {

    
      $.ajax({
        type: 'POST',
        url: 'MasterFranchiseController/getCityList1',
        data: 'cmppincode=' + cmppincode,
        dataType: "json",
        success: function (d) {         
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
  
   var fcnt = '<?= $fcnt; ?>';

    $("#pin").on('blur', function () 
    {
        var pin = $(this).val();
    
        $.ajax({
            type: 'POST',
            url: 'MasterFranchiseController/getCityList_for_fpincode',
            data: 'pin=' + pin,
            dataType: "json",
            success: function (d) {
            
              // $('#fcity_id').val(d.id);
              // $('#fcity').val(d.city);

              let data = '';

                data += '<tr id="frow'+fcnt+'"><td><input class="form-control" name="frpincode[]" id="frpincode'+fcnt+'" value="'+pin+'" readonly></td>';
                data += '<td><input type="hidden" name="frcity_id[]" id="frcity_id'+fcnt+'" value="'+d.id+'"><input class="form-control" name="frcity[]" id="frcity'+fcnt+'" value="'+d.city+'" readonly></td>';
                data+= '<td><button type="button" class="btn btn-danger" onclick="remove_delpincode('+fcnt+')"><i class="fa fa-minus"></i></button></td>';
                data += '</tr>';

                $('#show_column').append(data);
                fcnt++;
            }
        });

    $('#pin').val('');
    $('#fcity_id').val('');
    $('#fcity').val('');
    
  }); 

   $('#adddel_data').click(function() {
        let pin = $("#pin").val();
        let fcity = $("#fcity").val();
        let fcity_id = $("#fcity_id").val();
        if($("#pin").val() == ''){
            alert("Please select Pincode");
        }else{
            let data = '';

            data += '<tr id="frow'+fcnt+'"><td><input class="form-control" name="frpincode[]" id="frpincode'+fcnt+'" value="'+pin+'" readonly></td>';
            data += '<td><input type="hidden" name="frcity_id[]" id="frcity_id'+fcnt+'" value="'+fcity_id+'"><input class="form-control" name="frcity[]" id="frcity'+fcnt+'" value="'+fcity+'" readonly></td>';
            data+= '<td><button type="button" class="btn btn-danger" onclick="remove_delpincode('+fcnt+')"><i class="fa fa-minus"></i></button></td>';
            data += '</tr>';
            $('#show_column').prepend(data);
            fcnt++;
            $("#pin").val('');
            $("#fcity").val('');
            $("#fcity_id").val('');
        }
    });

    function remove_delpincode(cnt){
        $("#frow"+cnt).remove();
    }

     $( document ).ready(function() {
        let v = $('#is_delivery').val();
        if(v == 1){
            $("#delivery_pincode_visible").show();
        }else{
            $("#delivery_pincode_visible").hide();
            $("#show_column").empty();
        }
    });

    $("#is_delivery").on('change', function(){
        let v = $('#is_delivery').val();
        if(v == 1){
            $("#delivery_pincode_visible").show();
        }else{
            $("#delivery_pincode_visible").hide();
            $("#show_column").empty();
        }
    });
   
</script>

