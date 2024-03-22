 <?php  $this->load->view('admin/admin_shared/admin_header'); ?>
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
                                <h4 class="card-title">Edit Vendor</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
										 <form role="form" action="<?php echo base_url();?>admin/edit-vehicle/<?php echo $vehicle_info->vm_id; ?>" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Vehicle Number</label>
                                                        <input type="text" name="vehicle_number"  value="<?php echo $vehicle_info->vehicle_number; ?>" class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Vehicle Registration</label>
                                                        <input type="text" name="vehicle_registration" value="<?php echo $vehicle_info->vehicle_registration; ?>" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Vehicle Chesis</label>
                                                        <input type="text" name="vehicle_chesis" value="<?php echo $vehicle_info->vehicle_chesis; ?>" class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Vehicle  Model</label>
                                                        <input type="text" name="vehicle_model" value="<?php echo $vehicle_info->vehicle_model; ?>" id="v_pincode" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Vehicle PUC Date</label>
														<input type="date" name="vehicle_puc_date" value="<?php echo $vehicle_info->vehicle_puc_date; ?>" id="v_state" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Vehicle Fitness Exp Date</label>
														<input type="date" name="vehicle_fit_exp_date" value="<?php echo $vehicle_info->vehicle_fit_exp_date; ?>" id="v_state" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Vehicle Permit Renewal Date</label>
														<input type="date" name="vehicle_per_renw_date" value="<?php echo $vehicle_info->vehicle_per_renw_date; ?>" id="v_state" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Vehicle Insurance Renw.</label>
														<input type="date" name="vehicle_insurance_renw" value="<?php echo $vehicle_info->vehicle_insurance_renw; ?>" id="v_city" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Vehicle Capacity</label>
                                                        <input type="text" name="vehicle_capicity" value="<?php echo $vehicle_info->vehicle_capicity; ?>" class="form-control" >
                                                    </div>
													
                                                    
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
        <!-- START: Footer-->
		<script type="text/javascript">
$("#v_pincode").on('blur', function () 
  {
    var pincode = $(this).val();
    if (pincode != null || pincode != '') {

    
      $.ajax({
        type: 'POST',
        url: 'Admin_vendor/getPincodeInfo',
        data: 'pincode=' + pincode,
        dataType: "json",
        success: function (d) 
		{         
          $('#v_city').val(d.city);
          $('#v_state').val(d.state);
          
        }
      });
    
    }
  }); 
</script>		
    </body>
    <!-- END: Body-->
</html>
