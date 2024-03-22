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
                                <h4 class="card-title">Add Cnode</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/add-cnode" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Branch Code</label>
                                                        <select class="form-control" id="jq-validation-email" name="branch_code">
                                                                <option value="">Select Branch Code</option>
                                                                <?php 

                                                                   foreach ($branch as $row ) { 
                                                                   
                                                                ?>
                                                                <option value="<?php echo $row['branch_code'];?>"><?php echo $row['branch_code'];?> (<?php echo $row['branch_name']; ?>)</option>
                                                                <?php 
                                                                     }
                                                                ?>
                                                            </select>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Airway Number From</label>
                                                        <select class="form-control" id="jq-validation-email" name="airway_no_from">
                                                            <option value="">Airway No. From:</option>
                                                            <?php 
                                                               foreach ($cnode as $rows ) { 
                                                               
                                                            ?>
                                                            <option value="<?php echo $rows['airway_no'];?>">
                                                                
                                                                           <?php echo $rows['airway_no'];?> 
                                                            </option>
                                                            <?php 
                                                                 }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Airway Number To</label>    
                                                       <select class="form-control" id="jq-validation-email" name="airway_no_to">
                                                            <option value="">Airway No. To</option>
                                                            <?php 
                                                               foreach ($cnode as $rows ) { 
                                                               
                                                            ?>
                                                            <option value="<?php echo $rows['airway_to'];?>">
                                                                
                                                                           <?php echo $rows['airway_to'];?> 
                                                            </option>
                                                            <?php 
                                                                 }
                                                            ?>
                                                       </select>
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

		
		
		
		
		