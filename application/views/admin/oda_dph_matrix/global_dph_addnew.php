<?php include dirname(__FILE__) . '/../admin_shared/admin_header.php';?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">


        <!-- END: Main Menu-->

    <?php include dirname(__FILE__) . '/../admin_shared/admin_sidebar.php';?>
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
                              <h4 class="card-title"><?= $title; ?></h4>
							 
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						  <?php if ($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php unset($_SESSION['class']);unset($_SESSION['notify']);}?>
						<div class="row">
							<div class="col-12">
                <?php 
                  $url = !empty($dph_data)?'admin_oda_dph_matrix/insert_global_dph_master/'.$dph_data->id:'admin_oda_dph_matrix/insert_global_dph_master';
                ?>
                <form role="form" action="<?php echo base_url().$url; ?>" method="post" enctype="multipart/form-data">
								  <div class="box-body">
									 <div class="form-group row">
                   <label class="col-sm-1 col-form-label">Date</label>
									  <div class="col-sm-2"> <?php date_default_timezone_set('Asia/Kolkata');
                               $date = date("Y-m-d H:i:s");?>
										<input type="date"  class="form-control" name="date_time" value="<?= !empty($dph_data)?$dph_data->start_date:''; ?>" required>
									  </div>
                
                      
									  <label class="col-sm-1 col-form-label">From Ltr</label>
									  <div class="col-sm-2">
										  <input class="form-control" name="from_ltr" id="from_ltr" value="<?= !empty($dph_data)?$dph_data->from_ltr:''; ?>" required>
									  </div>
                    <label class="col-sm-1 col-form-label">To Ltr</label>
                    <div class="col-sm-2">
                      <input class="form-control" name="to_ltr" id="to_ltr" value="<?= !empty($dph_data)?$dph_data->to_ltr:''; ?>" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Rate Per Kg</label>
                    <div class="col-sm-2">
                      <input class="form-control" name="rate_perkg" id="rate_perkg" value="<?= !empty($dph_data)?$dph_data->rate:''; ?>" required>
                    </div>
									</div>
									  <div class="col-md-2">
                      <br><br>
										  <div class="box-footer">
											<button type="submit" class="btn btn-primary"><?= !empty($dph_data)?'UPDATE':'SUBMIT'; ?></button>
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

        <?php include dirname(__FILE__) . '/../admin_shared/admin_footer.php';?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
