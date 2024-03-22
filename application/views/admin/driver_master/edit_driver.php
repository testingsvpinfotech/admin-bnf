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
                                <h4 class="card-title">Edit Driver</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                             <form role="form" action="<?php echo base_url();?>admin/edit-driver/<?php echo $driver_info->dm_id; ?>" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Driver Name</label>
                                                        <input type="text" name="driver_name" class="form-control" value="<?php echo $driver_info->driver_name; ?>" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Driver Father Name</label>
                                                        <input type="text" name="driver_father_ame" class="form-control"  value="<?php echo $driver_info->driver_father_ame; ?>" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Driver Mother Name</label>
                                                        <input type="text" name="driver_mother_name" class="form-control"  value="<?php echo $driver_info->driver_mother_name; ?>" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Driver Mobile</label>
                                                        <input type="text" name="driver_mobile" class="form-control"   value="<?php echo $driver_info->driver_mobile; ?>">
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Driver Mobile Alt</label>
                                                        <input type="text" name="driver_mobile_alt" class="form-control"  value="<?php echo $driver_info->driver_mobile_alt; ?>">
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Address</label>
                                                        <input type="text" name="driver_address" class="form-control"  value="<?php echo $driver_info->driver_address; ?>">
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Pincode</label>
                                                        <input type="text" name="driver_pincode" id="v_pincode" class="form-control"  value="<?php echo $driver_info->driver_pincode; ?>">
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">State</label>
														<input type="text" name="driver_state" id="v_state" class="form-control"  value="<?php echo $driver_info->driver_state; ?>">
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">City</label>
														<input type="text" name="driver_city" id="v_city" class="form-control" value="<?php echo $driver_info->driver_city; ?>" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Driver Licance No</label>
                                                        <input type="text" name="driver_licanace" class="form-control" value="<?php echo $driver_info->driver_licanace; ?>" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Driver Licance Exp.</label>
                                                        <input type="date" name="driver_licance_expiry" class="form-control" value="<?php echo $driver_info->driver_licance_expiry; ?>" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Driver Salery</label>
                                                        <input type="text" name="driver_salery" class="form-control" value="<?php echo $driver_info->driver_salery; ?>" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Joining Date</label>
                                                        <input type="date" name="driver_joining_date" class="form-control" value="<?php echo $driver_info->driver_joining_date; ?>" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Leaving Date</label>
                                                        <input type="date" name="driver_leaving_date" class="form-control" value="<?php echo $driver_info->driver_leaving_date; ?>" >
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
