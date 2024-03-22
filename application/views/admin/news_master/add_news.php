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
                                <h4 class="card-title">Add News</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/add-news" method="post" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <div class="col-3 mb-3">
                                               <label for="username">News Title</label>
                                               <input type="text" class="form-control" id="jq-validation-email" name="news_title" placeholder="News Title">
                                            </div>
                                             <div class="col-2 mb-3">
                                               <label>News From</label>
                                               <input type="text" class="form-control datepicker" name="news_date_from" placeholder="News Date From">
                                            </div>
                                             <div class="col-2 mb-3">
                                               <label>News To</label>
                                               <input type="text" class="form-control datepicker" name="news_date_to" placeholder="News Date To">
                                            </div>
                                           
                                             <div class="col-2 mb-3">
                                               <label for="username">News Image</label>
                                               <input type="file" class="form-control" id="jq-validation-email" name="news_image" placeholder="News Image">
                                            </div> 
                                         </div> 
                                         <div class="form-group row">   
                                           <div class="col-10 mb-3">
                                               <label for="username">News Details</label>
                                               <textarea class="form-control" id="jq-validation-email" name="news_details" placeholder="News Details"></textarea>
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

		
		
		
		
		