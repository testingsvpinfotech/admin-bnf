 <?php $this->load->view('admin/admin_shared/admin_header'); ?>
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
    <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>                            
        <h4 class="card-title">Update Customer</h4>           
        <?php }else{?>     
          <h4 class="card-title">Customer Details</h4>                   
        <?php }?>                     
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">                                           
                <div class="col-12">
                <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>      
                 <form role="form" action="<?php echo base_url();?>admin/edit-customer/<?php echo $customer->customer_id?>" method="post" enctype="multipart/form-data"> 
                 <?php } ?>
                        <div class="form-row">
                            <div class="col-3 mb-3">
                                <label for="username">Customer Code</label>
                                <input type="text" class="form-control" name="cid" value="<?php echo $customer->cid;?>" placeholder="Enter Name" readonly>

                            </div>
                            <div class="col-3 mb-3"> 
                                <label for="email">Customer Name</label>    
                                <input type="text" class="form-control" name="customer_name" value="<?php echo $customer->customer_name;?>">
                            </div>
                            <div class="col-3 mb-3">
                                <label for="username">Contact Person</label>
                                <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="<?php echo $customer->contact_person;?>" >
                            </div>
                            <div class="col-3 mb-3">
                                        <label for="username">Select Parent</label>
                                        <select class="form-control filter-data"  name="parent_cust"  required="">
                                            <option selected disabled>self parent</option>
                                                    <?php
                                            foreach ($allcustomer as $row) 
                                                    {
                                                      ?>
                                         <option value="<?php echo $row['customer_id'];?>" <?php if($row['customer_id'] == $customer->parent_cust_id) { echo 'selected'; } ?>><?php echo $row['customer_name'];?></option>
                                           <?php
                                                    }
                                          ?>
                                       </select>
                                    </div>
                            <div class="col-3 mb-3"> 
                                        <label for="email">Phone</label>    
                                        <input type="text" class="form-control manifest_driver_contact" name="phone" id="cust_phone" maxlength="10" minlength="10" value="<?php echo $customer->phone;?>" >
                                    </div>
                            <div class="col-3 mb-3">
                                <label for="username">Email</label>
								            <input type="text" class="form-control" name="email"  value="<?php echo $customer->email;?>">
                            </div>                 
                            <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>                
                            <div class="col-3 mb-3">
                                <label for="username">Password</label>
                                <input type="password" class="form-control" name="password"  value="<?php echo $customer->password;?>"  >
                            </div> 
                            <?php } ?>
                             <div class="col-3 mb-3"> 
                                <label for="email">Address</label>      
                                 <textarea class="form-control" rows="3" placeholder="Enter Address" name="address" ><?php echo $customer->address;?></textarea>
                            </div>
                            
                            <div class="col-3 mb-3">
                                <label for="username">Staff Allotment</label>
                                 <select class="form-control filter-data"  name="user_id"  required="" >
                                    <option selected disabled>Select Staff</option>
                                    <?php
                                    
                                    //print_r($selected_staff);die;
                                    $sel='';
                                    foreach ($all_staff as $staff_row) 
                                    {
                                        
                                        // foreach ($selected_staff as $selected_staff_var){
                                             if($staff_row['user_id'] == $customer->user_id) { 
                                                $sel="selected='selected'"; 
                                         }
                                     	// }

                                      ?>
                                        <option value="<?php echo $staff_row['user_id'];?>" <?php echo $sel; ?>  ><?php echo $staff_row['username'];?></option> 
                                      <?php
                                        
                                    }
                                    ?>
                                  </select>
                            </div> 
                             <div class="col-3 mb-3">
                                <label for="username">Pincode</label>
                                <input type="text" class="form-control" name="pincode" id="pincode" maxlength="6" minlength="6" value="<?php echo $customer->pincode;?>">
                            </div> 
                             <div class="col-3 mb-3"> 
                                <label for="email">State</label>      
                                 <select class="form-control filter-data" id="state" name="state_id" required>
                                    <option value="">Select State</option>
                                    <?php
                                    foreach ($states as $state_row) 
                                    {
                                      ?>
                                      <option value="<?php echo $state_row['id'];?>" <?php if($state_row['id'] == $customer->state) { echo 'selected'; } ?>>
                                        <?php echo $state_row['state'];?>
                                      </option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                            </div>
                             <div class="col-3 mb-3"> 
                                <label for="email">City</label>      
                                 <select class="form-control filter-data" name="city" id="city" required>
                                    <option value="">Select City</option>
                                    <?php 
                                    foreach ($cities as $city_rows ) 
                                    { 
                                    ?>
                                      <option value="<?php echo $city_rows['id'];?>" <?php if($city_rows['id'] == $customer->city) { echo 'selected'; } ?>>
                                        <?php echo $city_rows['city'];?> 
                                      </option>
                                    <?php 
                                    }
                                    ?>
                                  </select>
                            </div>
							<div class="col-3 mb-3"> 
								<label for="username">Comapany</label> 
								  <select class="form-control select filter-data" name="company_id" id="company_id" required>
								    <option value="">Select Company</option>
									<?php foreach($company_list AS $val){ ?>
									<option value="<?php echo $val['id'];?>" <?php if($val['id'] == $customer->company_id) { echo 'selected'; } ?> ><?php echo $val['company_name'];?></option>
									<?php } ?>
							   </select>
							</div>
                           
                            <div class="col-3 mb-3">
                                <label for="username">Gst No</label>
                                <input type="text" class="form-control" name="gstno" maxlength="16" minlength="1" value="<?php echo $customer->gstno;?>">
                            </div> 
                            <div class="col-3 mb-3">
                                        <label for="username">Gst file</label>
                                        <input type="file" class="form-control" name="gstfile">
                                        <br>
                                        <?php if (!empty($customer->gstfile)) { 
                                            $ext = explode('.',$customer->gstfile);
                                            if($ext[1] =='pdf'){?>
                                            <a href="<?= base_url('assets/customer/'.$customer->gstfile);?>" target="_blank"><i class="fa fa-link" aria-hidden="true"> View GST PDF</i></a>
                                            <?php }else{?>
                                            <a href="assets/customer/<?php echo $customer->gstfile; ?>" src="assets/customer/<?php echo $customer->gstfile; ?>" title="<?php echo $customer->gstfile; ?>" onclick="show_image(this);return false;" style="color:blue;">View GST Image</a>
                                            <?php } ?>
                                          <?php } ?>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Pan No</label>
                                        <input type="text" class="form-control" name="panno" maxlength="10" minlength="10" placeholder="Enter Pan No." value="<?php echo $customer->panno;?>">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="username">Pan file</label>
                                        <input type="file" class="form-control" name="panfile">
                                        <?php if (!empty($customer->panfile)) { 
                                            $ext = explode('.',$customer->panfile);
                                            if($ext[1] =='pdf'){?>
                                            <a href="<?= base_url('assets/customer/'.$customer->panfile);?>" target="_blank"><i class="fa fa-link" aria-hidden="true"> View GST PDF</i></a>
                                            <?php }else{?>
                                            <a href="assets/customer/<?php echo $customer->panfile; ?>" src="assets/customer/<?php echo $customer->panfile; ?>" title="<?php echo $customer->panfile; ?>" onclick="show_image(this);return false;" style="color:blue;">View PanCard Image</a>
                                            <?php } ?>
                                          <?php } ?>
                                    </div>
                            <div class="col-3 mb-3">
                                <label for="username">GST Charges</label> <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input"  value="1"  <?php if($customer->gst_charges == 1) { echo 'checked="checked"';} ?> name="gst_charges" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="gst_charges" class="custom-control-input" value ="0" <?php if($customer->gst_charges == 0) { echo 'checked="checked"';} ?>  id="customCheck2">
                                    <label class="custom-control-label" for="customCheck2">No</label>
                                </div>
                            </div>                            
                              <div class="col-3 mb-3">
                                      <label for="username">Auto MIS</label> <br>
                                      <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" name="auto_mis" id="auto_mis1" value="1"  <?php if($customer->auto_mis == 1) { echo 'checked="checked"';} ?>>
                                          <label class="custom-control-label" for="auto_mis1">Yes</label>
                                      </div>
                                      <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" name="auto_mis" class="custom-control-input" id="auto_mis2" value ="0" <?php if($customer->auto_mis == 0) { echo 'checked="checked"';} ?>>
                                          <label class="custom-control-label" for="auto_mis2">No</label>
                                      </div>
                              </div>              
                            <div class="col-3 mb-3">
                                <label for="username">Api Access</label>
                                <select class="form-control filter-data" id="exampleInputEmail1" name="api_access" >
                                <option value="">Select Access</option>
                                <option value="Yes" <?php if($customer->api_access == 'Yes'){ echo 'selected';} ?>>Yes</option>
                                <option value="No" <?php if($customer->api_access == 'No'){ echo 'selected';} ?>>No</option>
                              </select>
                              <?php if($customer->api_access == 'Yes'){ ?>
                              <span><b>API KEY :</b> <?= $customer->api_key;?></span>
                              <?php } ?>
                            </div> 
                             <div class="col-3 mb-3">
                                <label for="username">SAC Code</label>
                               <input type="text" class="form-control" name="sac_code" id="sac_code" placeholder="Enter SAC Code" value="<?php echo $customer->sac_code;?>">
                            </div> 
                             <div class="col-3 mb-3">
                                <label for="username">Credit Days</label>
                                <input type="text" class="form-control manifest_driver_contact" maxlength="2" minlength="1" name="credit_days" id="credit_days" placeholder="Enter Credit Days" value="<?php echo $customer->credit_days;?>">
                            </div> 
                              <div class="col-3 mb-3">
                                  <label for="username">Sales Person Allotment</label>
                                  <select class="form-control filter-data"  name="sales_person_id" required="">
                                      	<option selected disabled>Select Sales Person</option>
                                        <?php foreach ($all_sales_person as $row){ ?>
                                    		<option value="<?php echo $row['user_id'];?>" <?php if($row['user_id'] == $customer->sales_person_id){ echo 'selected'; } ?>><?php echo $row['username'];?></option>
                                      <?php } ?>
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
                                         <option value="<?php echo $row->branch_id;?>" <?php if($row->branch_id == $customer->branch_id){ echo 'selected'; } ?>><?php echo $row->branch_name;?></option>
                                           <?php
                                                    }
                                          ?>
                                       </select>
                                    </div> 
                              <div class="col-3 mb-3">
                                <label for="username">Credit Limit</label>
                                  <input type="text" class="form-control" name="credit_limit" id="credit_limit" value="<?php echo $customer->credit_limit;?>">
                                </div>
                                <div class="col-3 mb-3">
                                        <label for="username">Assign To Franchise</label>
                                         <select class="form-control filter-data" id="franchise_customer_access" name="franchise_customer_access" required="">
                                            <option value="">Select Assign Access</option>
                                            <option value="1" <?php if($customer->franchise_customer_access==1){echo 'selected';} ?>>Yes</option>
                                            <option value="0" <?php if($customer->franchise_customer_access==0){echo 'selected';} ?>>No</option>
                                         </select>
                                    </div>
                                    <div class="col-3 mb-3" id="show" <?php if($customer->franchise_customer_access!=1){ ?> style="display:none;" <?php }?>>
                                        <label for="username">Franchise Name</label> <br>
                                         <select class="form-control filter-data" id="franchise_customer" name="franchise_id" required="">
                                            <option value="">Select Assign Access</option>
                                            <?php foreach($franchise as $key => $val){ ?>
                                              <option value="<?=$val->customer_id?>"<?php if($customer->franchise_id ==$val->customer_id){echo 'selected';} ?>><?= $val->customer_name.' -- '.$val->cid; ?></option>
                                              <?php }?>
                                         </select>
                                    </div>
                            <div class="col-10 mb-3">
                                <label for="username">MIS Email Ids</label>
                                <input type="text" class="form-control" name="mis_emailids" id="mis_emailids" placeholder="Enter Email Ids with semicolon" value="<?php echo $customer->mis_emailids;?>">
                            </div> 
                <div class="col-12 mb-3">
                     <div class="col-3 mb-3">
                        <label for="username"><b>MIS Formats</b></label>  
                      </div>
                       <div class="col-4 mb-3 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" checked="checked" name="mis_formate" value="1" <?php //if($customer->mis_formate == '1'){ echo 'checked'; } ?> id="mis_formate1">
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
                            <input type="radio" name="mis_formate"  value="2" class="custom-control-input" value="2" <?php if($customer->mis_formate == '2'){ echo 'checked'; } ?> id="mis_formate2">
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
                            <input type="radio" name="mis_formate" value="3" class="custom-control-input" value="3" <?php if($customer->mis_formate == '3'){ echo 'checked'; } ?> id="mis_formate3">
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


                    <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>      
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                            </div>
                            <?php } ?>
                        </div>
                        <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>      
                    </form>
                    <?php } ?>
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
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
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
		
		