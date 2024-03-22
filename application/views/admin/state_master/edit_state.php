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
                                <h4 class="card-title">Update State</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">                                         
                                                <form role="form" action="<?php echo base_url();?>admin/edit-state/<?php echo $s->id;?>" method="post">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Country</label>

                                                      <select class="form-control" id="jq-validation-email" name="country_id">
                                                        <option value="">Select Country</option>
                                                        <?php 
                                                        foreach ($allcountry as $row ) {    

                                                            ?>
                                                            <option value="<?php echo $row['country_id'];?>" <?php if($row['country_id'] ==$s->country_id) { echo "selected='selected'"; }?>>

                                                                <?php echo $row['country_name'];?> 
                                                            </option>
                                                            <?php 
                                                        }
                                                        ?>
                                                    </select>

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Region</label>    
                                                        <select class="form-control" id="jq-validation-email" name="region_id">
                                                        <option value="">Select Region</option>
                                                        <?php 
                                                        foreach ($allregion as $rows ) {    

                                                            ?>
                                                            <option value="<?php echo $rows['region_id'];?>" <?php if($rows['region_id'] == $s->region_id) { echo "selected='selected'"; } ?>>

                                                                <?php echo $rows['region_name'];?> 
                                                            </option>
                                                            <?php 
                                                        }
                                                        ?>
                                                    </select>
                                                    </div>

                                                    <div class="col-3 mb-3">
                                                        <label for="username">State Name</label>
														<input type="text" class="form-control" id="jq-validation-email" name="state_name" value="<?php echo $s->state; ?>"  placeholder="State ">

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Eestimated Delivery Date</label>  
                                                        <input type="number" class="form-control" id="edd_train" name="edd_train" value="<?php echo $s->edd_train; ?>" />
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <label for="username">Eestimated Delivery Date For Air</label>
                                                      <input type="number" class="form-control" id="edd_air" name="edd_air" value="<?php echo $s->edd_air; ?>" />

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


		
		
		
		
		