<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">


  <!-- END: Main Menu-->

  <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
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
                <h4 class="card-title">Upload Status File</h4>
                <span style="float:right;">
                  <a href="<?php echo base_url(); ?>assets/rate_sample.csv" class="btn btn-small btn-success">Download Sample</a>
                </span>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <?php if ($this->session->flashdata('notify') != '') { ?>
                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                  <?php unset($_SESSION['class']);
                    unset($_SESSION['notify']);
                  } ?>
                  <div class="row">
                    <div class="col-12">
                      <form role="form" action="admin/upload-domestic-rate-insert" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                          
                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Customer</label>
                            <div class="col-sm-3">
                              <select name="customer_id[]" class="form-control" id="customer_id" multiple required>
                                          
                                <?php 
                                foreach ($customer_list as $cl) 
                                { 
                                ?>
                                    <option value="<?php echo $cl['customer_id'];?>" ><?php echo $cl['customer_name']." - ".$cl['cid'];?> 
                                    </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Courier Company</label>
                            <div class="col-sm-3">
                              <select class="form-control" name="c_courier_id" required>
                                  <option value="">-Select Courier Company-</option>
                                  <!-- <option value="0">All</option> -->
                                 <?php foreach ($courier_company as $cc) {
                                  ?>
                                  <option value="<?php echo $cc['c_id'];?>" selected><?php echo $cc['c_company_name'];?> 
                                  </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Mode Name</label>
                            <div class="col-sm-3">
                               <select class="form-control" name="mode_id" required>
                                      <option value="">-Select Mode-</option>
                                   <?php foreach ($mode_list as $ml) {
                                    ?>
                                    <option value="<?php echo $ml['transfer_mode_id'];?>"><?php echo $ml['mode_name'];?> 
                                    </option>
                                  <?php } ?>
                                </select>
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Shipment</label>
                            <div class="col-sm-3">
                              <select class="form-control" name="doc_type" id="doc_type" required>
                                  <option value="">-Select-</option>
                                  <option value="1">Non-Doc</option>
                                  <option value="0">Doc</option>
                                </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">From Date</label>
                            <div class="col-sm-3">
                              <input type="date" name="applicable_from" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Applicable From" required>
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-3">
                              <select class="form-control" name="fixed_perkg" required>
                                
                                <option value="0">Fixed</option>
                                <option value="1">Addtion 250GM</option>
                                <option value="2">Addtion 500GM</option>
                                <option value="3">Addtion 1000GM</option>
                                <option value="4">Per Kg</option>                                               
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Minimum Weight</label>
                            <div class="col-sm-3">
                               <input type="number" name="minimum_weight" value="0" class="form-control" placeholder="minimum weight" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Minimum Freight</label>
                            <div class="col-sm-3">
                               <input type="number" name="minimum_rate" value="0" class="form-control" placeholder="minimum rate" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Expiry Date</label>
                            <div class="col-sm-3">
                               <input type="date" name="exp_date" class="form-control" placeholder="Expiry date" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Choose a file</label>
                            <div class="col-sm-3">
                              <input type="file" id="file" name="uploadFile" value="" required>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
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

  <?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
  <!-- START: Footer-->
</body>
<!-- END: Body-->
<script type="text/javascript">
  $('#customer_id').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                maxHeight: 150
              }); 
</script>
</html>