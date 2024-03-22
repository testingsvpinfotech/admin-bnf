 <?php  $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
 <style>
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
  }
  .hgt-mltpl-select{
    height: 60% !important;
  }
  </style>  
    <!-- START: Body-->
    <body id="main-container" class="default">

    	 <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
<main>
<div class="container-fluid site-width">
<!-- START: Listing-->
<div class="row">
<div class="col-12 mt-3">
<div class="card">
    <div class="card-header">                               
        <h4 class="card-title">Add customer</h4>                                
           </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form role="form" action="<?php echo base_url();?>admin/add-customer" method="post" enctype="multipart/form-data">

                                <div class="form-row">
                                  <!-- <div class="col-3 mb-3">
                                        <label for="username">Customer Code</label>
                                         <input type="text" class="form-control" name="cid" value="<?php echo $cid; ?>" placeholder="Enter Code" readonly>

                                    </div> -->
                                    <div class="col-3 mb-3">
                                        <label for="username">Customer Name</label>
                                        <input type="text" class="form-control" name="customer_name" placeholder="Customer Name">
                                    </div>

                                    <div class="col-3 mb-3">
                                        <label for="username">Contact Person</label>
                                        <input type="text" class="form-control" name="contact_person" placeholder="Contact Person">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Select Parent</label>
                                        <select class="form-control filter-data"  name="parent_cust"  required="">
                                            <option selected value="0">self parent</option>
                                                    <?php
                                            foreach ($allcustomer as $row) 
                                                    {
                                                      ?>
                                         <option value="<?php echo $row['customer_id'];?>"><?php echo $row['customer_name'];?></option>
                                           <?php
                                                    }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="col-3 mb-3"> 
                                        <label for="email">Phone</label>    
                                        <input type="text" class="form-control manifest_driver_contact" name="phone" id="cust_phone" maxlength="10" minlength="10" placeholder="Enter Phone No."  >
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Enter Email ID"  >
                                    </div>                                    
                                    <div class="col-3 mb-3">
                                        <label for="username">Password</label>
										                    <input type="password" class="form-control" name="password"  placeholder="Enter Password" minlength="8" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                    </div>   
                                     <div class="col-3 mb-3"> 
                                          <label for="email">Address</label>      
                                           <textarea class="form-control" rows="3" placeholder="Enter Address" name="address" ></textarea>
                                      </div>                                 
                                     <div class="col-3 mb-3">
                                        <label for="username">Staff Allotment</label>
                                        <select class="form-control filter-data"  name="user_id"  required="">
                                            <option selected disabled>Select Staff</option>
                                                    <?php
                                            foreach ($all_staff as $row) 
                                                    {
                                                      ?>
                                         <option value="<?php echo $row['user_id'];?>"><?php echo $row['username'];?></option>
                                           <?php
                                                    }
                                          ?>
                                       </select>
                                    </div> 
                                     <!-- <div class="col-3 mb-3">
                                        <label for="username">State</label>
                                        <select class="form-control"  name="state_id" id="state" onchange="return getCityList();"  required="">
                                            <option value="">Select State</option>           
                                            <?php
                                            foreach ($states as $row) 
                                            {
                                              ?>
                                              <option value="<?php echo $row['id'];?>"><?php echo $row['state'];?></option>
                                              <?php
                                            }
                                            ?>
                                          </select>
                                    </div> -->
                                     <div class="col-3 mb-3">
                                    <label for="username">Pincode</label>
                                    <input type="text" class="form-control" name="pincode" id="pincode" maxlength="6" minlength="6" placeholder="Enter Pincode">
                                  </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">State</label>
                                        <select class="form-control filter-data"  name="state_id" id="cust_state" required="">
                                            <option value="">Select State</option>           
                                          <!--  <?php
                                           // foreach ($states as $row) 
                                            {
                                              ?>
                                              <option value="<?php echo $row['id'];?>"><?php echo $row['state'];?></option>
                                              <?php
                                            }
                                            ?>-->
                                          </select>
                                    </div>
                                    <div class="col-3 mb-3"> 
                                        <label for="username">City</label> 
                                          <select class="form-control filter-data"  name="city" id="cust_city" required="">
                                          <option value="">Select City</option>                                        
                                       </select>
                                    </div>
									<div class="col-3 mb-3"> 
                                        <label for="username">Comapany</label> 
                                          <select class="form-control select filter-data" name="company_id" id="company_id" required>
                                          <option value="">Select Company</option>  
											<?php foreach($company_list AS $val){ ?>
											<option value="<?php echo $val['id'];?>" ><?php echo $val['company_name'];?></option>
											<?php } ?>
                                       </select>
                                    </div>
                                    <!--  <div class="col-3 mb-3">
                                        <label for="username">Email</label>
                                       <input type="text" class="form-control" name="email"  placeholder="Enter Email">
                                    </div> -->
                                     <div class="col-3 mb-3">
                                        <label for="username">Gst No</label>
                                        <input type="text" class="form-control" name="gstno" maxlength="16" minlength="1" placeholder="Enter Gst No.">
                                    </div>
                                     <div class="col-3 mb-3">
                                        <label for="username">Gst file<span class="compulsory_fields" style="color:red;font-size:17px;">  *</span></label>
                                        <input type="file" class="form-control" name="gstfile" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Pan No</label>
                                        <input type="text" class="form-control" name="panno" maxlength="10" minlength="10" placeholder="Enter Pan No.">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Pan file<span class="compulsory_fields" style="color:red; font-size:17px;">  *</span></label>
                                        <input type="file" class="form-control" name="panfile" required>
                                    </div>
                                   <div class="col-3 mb-3">
                                    <label for="username">GST Charges</label> <br>
                                     <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" checked="checked" value="1" name="gst_charges" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="gst_charges" class="custom-control-input" value="0" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2">No</label>
                                    </div>
                                    </div>
                                   <div class="col-3 mb-3">
                                    <label for="username">Auto MIS</label> <br>
                                     <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="auto_mis" value="1" id="auto_mis1">
                                        <label class="custom-control-label" for="auto_mis1">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="auto_mis" class="custom-control-input" value="0" id="auto_mis2" checked>
                                        <label class="custom-control-label" for="auto_mis2">No</label>
                                    </div>
                                    </div>
                                  <div class="col-3 mb-3">
                                        <label for="username">Api Access</label>
                                         <select class="form-control filter-data" id="exampleInputEmail1" name="api_access" required="">
                                        <option value="">Select API Access</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                      </select>
                                </div>
                               
                                  <div class="col-3 mb-3">
                                    <label for="username">SAC Code</label>
                                     <input type="text" class="form-control" name="sac_code" id="sac_code" placeholder="Enter SAC Code">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Credit Days</label>
                                         <input type="text" class="form-control" maxlength="2" minlength="1" name="credit_days" id="credit_days" placeholder="Enter Credit Days">
                                    </div>
									 <div class="col-3 mb-3">
                                        <label for="username">Sales Person Allotment</label>
                                        <select class="form-control filter-data"  name="sales_person_id"  required="">
                                            <option selected disabled>Select Sales Person</option>
                                                    <?php
                                            foreach ($all_sales_person as $row) 
                                                    {
                                                      ?>
                                         <option value="<?php echo $row['user_id'];?>"><?php echo $row['username'];?></option>
                                           <?php
                                                    }
                                          ?>
                                       </select>
                                    </div> 
									 <div class="col-3 mb-3">
                                        <label for="username">Branch Name</label>
                                        <select class="form-control filter-data"  name="branch_id"  required="">
                                            <option selected disabled>Select Branch</option>
                                                    <?php
                                                    $branch = $this->db->query("select * from tbl_branch")->result();
                                            foreach ($branch as $row) 
                                                    {
                                                      ?>
                                         <option value="<?php echo $row->branch_id;?>"><?php echo $row->branch_name;?></option>
                                           <?php
                                                    }
                                          ?>
                                       </select>
                                    </div> 
                                    <div class="col-3 mb-3">
                                        <label for="username">Credit Limit</label>
                                         <input type="number" class="form-control" name="credit_limit" id="credit_limit" value="0">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Assign To Franchise</label>
                                         <select class="form-control filter-data" id="franchise_customer_access" name="franchise_customer_access" required="">
                                            <option value="">Select Assign Access</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                         </select>
                                    </div>
                                    <div class="col-6 mb-3" id="show" style="display:none;">
                                        <label for="username">Franchise Name</label> <br>
                                         <select class="form-control filter-data" id="franchise_customer" name="franchise_id" required="">
                                            <option value="">Select Assign Access</option>
                                            <?php foreach($franchise as $key => $val){ ?>
                                              <option value="<?=$val->customer_id?>"><?= $val->customer_name.' -- '.$val->cid; ?></option>
                                              <?php }?>
                                         </select>
                                    </div>
                                    <div class="col-10 mb-3">
                                        <label for="username">MIS Email Ids</label>
                                         <input type="text" class="form-control" name="mis_emailids" id="mis_emailids" placeholder="Enter Email Ids with semicolon">
                                    </div>
                  <div class="col-12 mb-3">
                     <div class="col-3 mb-3">
                        <label for="username"><b>MIS Formats</b></label>  
                      </div>
                       <div class="col-4 mb-3 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" checked="checked" name="mis_formate" value="1" id="mis_formate1">
                                <label class="custom-control-label" for="mis_formate1"></label>
                                 <div class="table-responsive">
                                   <table class="table layout-primary bordered">
                                         <thead>
                                          <tr>
                                            <?php
                                            $coulums = mis_formate_columns(1);
                                            foreach($coulums as $coulum)
                                            {
                                            ?>
                                            <th><?php echo $coulum?></th>
                                            <?php
                                             }
                                            ?>
                                        </tr>
                                      </thead>
                                    </table> 
                                </div>                          
                        </div>
                        <div class="col-4 mb-3 custom-control custom-radio custom-control-inline">
                            <input type="radio" name="mis_formate"  value="2" class="custom-control-input"  id="mis_formate2">
                            <label class="custom-control-label" for="mis_formate2"></label>
                              <div class="table-responsive">
                                   <table class="table layout-primary bordered">
                                         <thead>
                                          <tr>
                                            <?php
                                            $coulums = mis_formate_columns(2);
                                            foreach($coulums as $coulum)
                                            {
                                            ?>
                                            <th><?php echo $coulum?></th>
                                            <?php
                                             }
                                            ?>
                                        </tr>
                                      </thead>
                                    </table> 
                                </div>
                       
                        </div>
                        <div class="col-3 mb-3 custom-control custom-radio custom-control-inline" >
                            <input type="radio" name="mis_formate" value="3" class="custom-control-input" id="mis_formate3">
                            <label class="custom-control-label" for="mis_formate3"></label>
                              <div class="table-responsive">
                                   <table class="table layout-primary bordered">
                                         <thead>
                                          <tr>
                                            <?php
                                            $coulums = mis_formate_columns(3);
                                            foreach($coulums as $coulum)
                                            {
                                            ?>
                                            <th><?php echo $coulum?></th>
                                            <?php
                                             }
                                            ?>
                                        </tr>
                                      </thead>
                                    </table> 
                                </div>
                                          
                        </div>
                    </div>                         
                           <!--  <div class="col-4 mb-3">
                             <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" checked="checked" name="mis_formate" value="1" id="mis_formate1">
                                    <label class="custom-control-label" for="mis_formate1"></label>
                             </div>
                              <div class="card-body">
                              <div class="table-responsive">
                                   <table class="table layout-primary bordered">
                                         <thead>
                                          <tr>
                                            <?php
                                            $coulums = mis_formate_columns(1);
                                            foreach($coulums as $coulum)
                                            {
                                            ?>
                                            <th><?php echo $coulum?></th>
                                            <?php
                                             }
                                            ?>
                                        </tr>
                                      </thead>
                                    </table> 
                                </div>
                              </div>
                            </div> -->
                           <!--  <div class="col-4 mb-3">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="mis_formate"  value="2" class="custom-control-input"  id="mis_formate2">
                                <label class="custom-control-label" for="mis_formate2"></label>
                            </div>
                              <div class="card-body">
                              <div class="table-responsive">
                                   <table class="table layout-primary bordered">
                                         <thead>
                                          <tr>
                                            <?php
                                            $coulums = mis_formate_columns(2);
                                            foreach($coulums as $coulum)
                                            {
                                            ?>
                                            <th><?php echo $coulum?></th>
                                            <?php
                                             }
                                            ?>
                                        </tr>
                                      </thead>
                                    </table> 
                                </div>
                              </div>
                           </div> -->
                           <!-- <div class="col-4 mb-3">
                             <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="mis_formate" value="3" class="custom-control-input" id="mis_formate3">
                                <label class="custom-control-label" for="mis_formate3"></label>
                            </div>                           
                            <div class="card-body">
                              <div class="table-responsive">
                                   <table class="table layout-primary bordered">
                                         <thead>
                                          <tr>
                                            <?php
                                            $coulums = mis_formate_columns(3);
                                            foreach($coulums as $coulum)
                                            {
                                            ?>
                                            <th><?php echo $coulum?></th>
                                            <?php
                                             }
                                            ?>
                                        </tr>
                                      </thead>
                                    </table> 
                                </div>
                              </div>
                            </div> -->

                           <!-- </div> -->
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Submit"> 
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
    <!-- END: Listing-->
</div>
</main>
        <!-- END: Content-->
    

<!-- START: Footer-->
        <?php $this->load->view('admin/admin_shared/admin_footer');
         //include('admin_shared/admin_footer.php'); ?>
         <script src="<?= base_url('assets/js/domestic_shipment_1.js');?>"></script>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
<script type="text/javascript">
  //======================
   function getCityList()
        {
            var state = $('#state').val();           
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>Admin_ratemaster/getCityList',
                data: 'state=' + state,
                dataType: "json",
                success: function(data) {
                    var option = '';
                    $.each(data, function(i, city) {                       
                        option += '<option value="'+city.id+'">'+city.city+'</option>';
                    });
                    $('#city').html(option);
                    
                }
            });  
        }

  $("#pincode").on('blur', function () 
  {
    var pincode = $(this).val();
    if (pincode != null || pincode != '') {

    
      $.ajax({
        type: 'POST',
        url: 'Admin_customer/getCityList',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) {         
          var option;         
          option += '<option value="' + d.id + '">' + d.city + '</option>';
          $('#cust_city').html(option);
          
        }
      });
      $.ajax({
        type: 'POST',
        url: 'Admin_customer/getState',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) {         
          var option;         
          option += '<option value="' + d.id + '">' + d.state + '</option>';
          $('#cust_state').html(option);          
        }
      });
    }
  }); 
  
  
</script>


		
		
		
		
		