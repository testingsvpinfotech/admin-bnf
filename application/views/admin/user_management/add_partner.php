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
                                <h4 class="card-title">Add New Partner</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/add-partner" method="post" enctype="multipart/form-data">
                                                 <input type="hidden" name="user_type" value="<?php echo $userType->user_type_id; ?>"/>
                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Name</label>
                                                        <input type="text" class="form-control" name="full_name" id="exampleInputEmail1" placeholder="Enter Name">

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Email Address</label>    
                                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter email">
                                                    </div>

                                                    <div class="col-3 mb-3">
                                                        <label for="username">Username</label>
														 <input type="text" class="form-control" name="username" id="exampleInputEmail1" placeholder="Enter Username" value="<?=$uid?>" readonly>

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Password</label>
                                                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Contact No</label>
                                                        <input type="text" class="form-control" name="phoneno" id="exampleInputEmail1" placeholder="Enter Contact No">
                                                    </div> 
                                                    <div class="col-3 mb-3">
                                                        <label for="username">GST No</label>
                                                         <input type="text" class="form-control" name="gstno" id="exampleInputEmail1" placeholder="Enter GST No">
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
    </body>
    <!-- END: Body-->
</html>

		
		
		
		
		