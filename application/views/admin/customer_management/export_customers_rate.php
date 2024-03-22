     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  /*#example_filter{display: none;}*/
  .input-group{
    width: 60%!important;
  }
</style>
    <!-- START: Body-->
    <body id="main-container" >
        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12" style="margin-top: 4rem;">
                      <!-- <div class="col-12 col-sm-12 mt-3"> -->
                      <div class="card"><!-- bg-primary-light -->
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title">Export Customer Rate Details</h4>
                          </div>
                          <div class="card-body">
                              <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <form action="<?= base_url().'admin/export-excel'; ?>" method="GET">
                              <div class="row">
                                <!-- <label class="col-2"></label> -->
                                <label class="col-1">Customer</label>
                                <div class="col-2">
                                  <select class="form-control" name="cust" id="cust">
                                    <option value="">ALL CUSTOMERS</option>
                                    <?php if(!empty($cust)): foreach ($cust as $value): ?>
                                      <option value="<?= $value->customer_id ?>"><?= $value->customer_name; ?></option>
                                    <?php endforeach; endif; ?>
                                  </select>
                                </div>
                                <div class="col-1">
                                  <button type="submit" name="submit" value="filter" class="btn btn-primary">Export in Excel</button>
                                </div>
                                <div class="col-1">
                                  <a href="<?= base_url().'admin/export-excel'; ?>" class="btn btn-danger">Reset</a>
                                </div>
                              </div>

                            </form>
                          </div>
                        </div> 

                    <!-- </div> -->
                    </div>
                </div>
                <!-- END: Listing-->
            </div>
        </main>
        <!-- END: Content-->
        <!-- START: Footer-->
        <?php $this->load->view('admin/admin_shared/admin_footer');
         //include('admin_shared/admin_footer.php'); ?>