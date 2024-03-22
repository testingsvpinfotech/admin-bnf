 <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

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
                                <h4 class="card-title">Change City</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="admin/change-pincode-city" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
													<div class="col-3 mb-3"> 
                                                       <label for="email">Pincode</label>    
                                                       <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">State</label>
                                                        <select class="form-control" name="state_id" id="state_id" required>
															<option value="">Select State</option>     
															<?php foreach ($state_list as $value) {
																?>
																<option value="<?php echo $value['id'];?>" ><?php echo $value['state'];?></option>
																<?php
															} ?>                                      
														</select>
                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">City Name</label>    
                                                       <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                                                    </div>
                                                    <div class="col-12">
                                                       <button type="submit" name="submit"class="btn btn-primary">Submit</button>
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
        <!-- START: Footer-->
		<script type="text/javascript">
	 $("#pincode").on('blur', function () 
  {
    var pincode = $(this).val();
    if (pincode != null || pincode != '') {    
      $.ajax({
        type: 'POST',        
		url: 'Admin_change_pincode/getCityList',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) {
		  $('#city').val(d.city);
        }
      });
      $.ajax({
        type: 'POST',        
		url: 'Admin_change_pincode/getState',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) {         
          var option;         
          option += '<option value="' + d.id + '">' + d.state + '</option>';
          $('#state_id').html(option);          
        }
      });
    }
  }); 
</script>
    </body>
    <!-- END: Body-->


		
		
		
		
		