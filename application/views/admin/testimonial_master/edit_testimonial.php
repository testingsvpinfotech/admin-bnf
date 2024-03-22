 <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
    	 <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
<!-- START: Main Content-->
<main>
    <div class="container-fluid site-width">
        <!-- START: Listing-->
        <div class="row">
         <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">                               
                        <h4 class="card-title">Update Testimonial</h4>                                
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">                                           
                                <div class="col-12">                                       
                                    <form role="role" action="<?php echo base_url();?>admin/edit-testimonial/<?php echo $row->id;?>" method="post" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-3 mb-3">
                                               <label for="exampleInputEmail1">Name</label>
                                             <input type="text" class="form-control" id="jq-validation-email" value="<?php echo $row->name;?>" name="name" placeholder="Enter Name" required>
                                            </div>
                                            <div class="col-3 mb-3">
                                               <label for="exampleInputEmail1">Message</label>
                                             <textarea class="form-control" id="jq-validation-email" name="message" placeholder="Enter Message"><?php echo $row->message;?></textarea>
                                            </div>
                                            <div class="col-3 mb-3">
                                               <label for="exampleInputEmail1">Image</label>
                                                <input type="file" class="form-control" id="jq-validation-email" value="<?php echo $row->image;?>" name="image" placeholder="Image">
                                            </div>
                                             <div class="col-3 mb-3">                             
                                                <img src="<?php echo base_url()."assets/testimonial/".$row->image;?>" width="60" height="60">
                                            </div>
                                            <div class="col-3 mb-3">
                                               <label for="exampleInputEmail1">Designation</label>
                                                <input type="text" class="form-control" id="jq-validation-email" value="<?php echo $row->designation;?>" name="designation" placeholder="Enter Designation">
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


		
		
		
		
		