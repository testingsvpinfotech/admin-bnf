 <?php echo $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
 <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
    	 <!-- END: Main Menu-->
   

        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">
                 <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">                               
                                <h4 class="card-title">Edit Vehicle Type</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/edit-bank/<?php echo $vehicle_info->id; ?>" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Bank Name</label>
                                                        <input type="text" name="bank_name" class="form-control" value="<?php echo $vehicle_info->bank_name; ?>" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Account No</label>
                                                        <input type="text" name="account_no" class="form-control" value="<?php echo $vehicle_info->account_no; ?>">
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">IFSC Code</label>
                                                        <input type="text" name="ifsc_code"   class="form-control" value="<?php echo $vehicle_info->ifsc_code; ?>">
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Branch Name</label>
                                                        <input type="text" name="branch_name"  class="form-control" value="<?php echo $vehicle_info->branch_name; ?>">
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
        <?php $this->load->view('admin/admin_shared/admin_footer'); ?>
       
        <!-- START: Footer-->
	
    </body>
    <!-- END: Body-->
</html>
