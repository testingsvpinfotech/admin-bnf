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
    <div class="card-header">  <br><br>                             
        <h4 class="card-title">Edit Expense Master</h4>                                
    </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">                                           
                    <div class="col-12">
                        <form role="form" action="<?php echo base_url();?>admin/edit-expence/<?= $usermenus->id; ?>" method="post" enctype="multipart/form-data">                         
                          <div class="col-3 mb-3">
                            <label for="username">Expense Name</label>
                          <input type="text" name="expence" class="form-control" placeholder="Expense Name" Required value="<?= $usermenus->expence; ?>">
                          </div>                      
                        <div class="col-3">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
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
    