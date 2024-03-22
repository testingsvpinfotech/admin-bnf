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
                        <h4 class="card-title">Update News</h4>                                
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">                                           
                                <div class="col-12">                                       
                                    <form role="role" action="<?php echo base_url();?>admin/edit-news/<?php echo $row->id;?>" method="post" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <div class="col-3 mb-3">
                                               <label>News Title</label>
                                             <input type="text" class="form-control" value="<?php echo $row->news_title;?>" name="news_title" placeholder="News Title">
                                            </div>
                                            <div class="col-2 mb-3">
                                               <label>News From</label>
                                               <input type="text" class="form-control datepicker" value="<?php echo $row->news_date_from;?>" name="news_date_from" placeholder="News Date From">
                                            </div>
                                             <div class="col-2 mb-3">
                                               <label>News To</label>
                                               <input type="text" class="form-control datepicker" value="<?php echo $row->news_date_to;?>" name="news_date_to" placeholder="News Date To">
                                            </div>
                                            <div class="col-2 mb-3">
                                               <label>News Image</label>
                                                <input type="file" class="form-control" value="<?php echo $row->news_image;?>" name="news_image" placeholder="News Image">
                                            </div>
                                             <div class="col-2 mb-3">                             
                                                <img src="<?php echo base_url()."assets/news/".$row->news_image;?>" width="60" height="60">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-10 mb-3">
                                               <label for="exampleInputEmail1">News Details</label>
                                              <textarea class="form-control" name="news_details" placeholder="News Details"><?php echo $row->news_details;?></textarea>
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


		
		
		
		
		