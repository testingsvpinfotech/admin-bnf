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
                                <h4 class="card-title">Add Company</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>Admin_company_manager/addcompany" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-6 mb-3">
                                                        <label for="username">Company Name</label>

                                                        <input type="text" class="form-control" id="jq-validation-email" name="name" placeholder="Company Name">

                                                    </div>
                                                    <div class="col-6 mb-3"> 
                                                        <label for="email">Company Logo</label>    
                                                        <input type="file" class="form-control" id="jq-validation-email" name="logo" placeholder="Company Logo">
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label for="username">Contact Number</label>
														<input type="text" class="form-control" id="jq-validation-email" name="phone_no" placeholder="Contact Number">

                                                    </div>
                                                    <div class="col-6 mb-3"> 
                                                        <label for="email">Email Id</label>       <input type="email" class="form-control" id="jq-validation-email" name="email" placeholder="Email Id">
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <label for="username">Address</label>

                                                        <textarea class="form-control" id="jq-validation-email" name="address" placeholder="Enter Address"></textarea>

                                                    </div> 
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
                                                        <!--  <button type="submit" class="btn btn-outline-warning">Reset</button> -->
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
    </body>
    <!-- END: Body-->
</html>

		
		
		
		
		