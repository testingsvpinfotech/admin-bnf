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
                                <h4 class="card-title">Add Home Slider</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/add-homeslider" method="post" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-3 mb-3">
                                               <label for="username">Slider Title</label>
                                               <input type="text" class="form-control" id="jq-validation-email" name="slider_title" placeholder="Slider Title">
                                            </div>
                                             <div class="col-3 mb-3">
                                               <label for="username">Slider Caption</label>
                                               <input type="text" class="form-control" id="jq-validation-email" name="slider_caption" placeholder="Slider Caption">
                                            </div>
                                             <div class="col-3 mb-3">
                                               <label for="username">Slider Image</label>
                                               <input type="file" class="form-control" id="jq-validation-email" name="slider_image" placeholder="Slider Image">
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

		
		
		
		
		