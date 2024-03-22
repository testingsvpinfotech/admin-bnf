<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
					  
                          <div class="card-header">                               
                              <h4 class="card-title">Upload Tat File</h4>
							  <span style="float:right;">
							  <a href="<?php echo base_url();?>assets/tat_sample.csv" class="btn btn-small btn-success">Download Sample</a>
							  </span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						  <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
						<div class="row">                                           
							<div class="col-12">
                               <form role="form" action="admin/upload-tat" method="post" enctype="multipart/form-data">
								  <div class="box-body">    
                  <div class="form-group row">
												<label  class="col-sm-1 col-form-label">Date<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">


												
												<?php 
												$datec = date('Y-m-d H:i');

												// $tracking_data[0]['tracking_date'] = date('Y-m-d H:i',strtotime($tracking_data[0]['tracking_date']));
	                                      		$datec  = str_replace(" ", "T", $datec);
												if($this->session->userdata('booking_date') != '')
												{ ?>
											
												<input type="datetime-local" name="booking_date" value="<?php echo $this->session->userdata('booking_date'); ?>" id="booking_date" class="form-control">
												<?php 
												}
												else
												{ ?>
													<input type="datetime-local" name="booking_date" value="<?php echo $datec;?>" id="booking_date" class="form-control" readonly>
												<?php } ?>
												</div>
									
									  <label for="ac_name" class="col-sm-2 col-form-label">Mode</label>
									  <div class="col-sm-2">
                    <select name="mode" class="form-control" id="mode">
                      <option value=""> select Mode</option>
                      <?php $mode = $this->db->query("select * from transfer_mode")->result();
                      foreach($mode as $key =>$value){ ?>
                      <option value="<?= $value->transfer_mode_id; ?>"><?= $value->mode_name; ?></option>
                      <?php } ?>
                    </select>
									  </div>									
									  <label for="ac_name" class="col-sm-2 col-form-label">Choose a file</label>
									  <div class="col-sm-3">
										<input type="file" id="file" name="uploadFile" value="" required>
									  </div>									
									</div>
									  <div class="col-md-2">
										  <div class="box-footer">
                        <br><br>
											<button type="submit" name="submit" class="btn btn-primary">Submit</button>
										  </div>
									  </div>
								  <!-- /.box-body -->                								  
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
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
