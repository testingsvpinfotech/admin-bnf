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
                                <h4 class="card-title">Update SMTP</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/edit-smtp/<?php echo $smtp->id;?>" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Port No</label>

                                                        <input type="number" class="form-control" name="port_no" id="exampleInputEmail1" value="<?php echo $smtp->port_no;?>" placeholder="Port Number" required>

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Host</label>    
                                                        <input type="text" class="form-control" name="host" id="exampleInputEmail1" value="<?php echo $smtp->host;?>" placeholder="Host" required>
                                                    </div>

                                                    <div class="col-3 mb-3">
                                                        <label for="username">Username</label>
														<input type="text" class="form-control" name="username" id="exampleInputEmail1" value="<?php echo $smtp->username;?>" placeholder="Username">

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Password</label>       
                                                        <input type="text" class="form-control" name="password" id="exampleInputEmail1" value="<?php echo $smtp->password;?>" placeholder="Password">
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


		
		
		
		
		