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
                                <h4 class="card-title">Add Vendor</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/add-vendor" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Vendor Name</label>
                                                        <input type="text" name="vendor_name" class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Contact</label>
                                                        <input type="text" name="v_contact" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Address</label>
                                                        <input type="text" name="v_add" class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Pincode</label>
                                                        <input type="text" name="v_pincode" id="v_pincode" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">State</label>
														<input type="text" name="v_state" id="v_state" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">City</label>
														<input type="text" name="v_city" id="v_city" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Rate Per KG</label>
                                                        <input type="text" name="v_rate_perkg" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Minimum</label>
                                                        <input type="text" name="v_minimum" class="form-control" >
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
