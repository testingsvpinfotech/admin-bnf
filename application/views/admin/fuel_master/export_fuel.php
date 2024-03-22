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
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title">Export Fuel</h4>
                              <span style="float: right;"><a href="<?= base_url() ?>admin/all-fuel" class="fa fa-plus btn btn-primary">FUEL LIST</a></span>
                          </div>
                          <div class="card-body">
                             <form method="get" action="<?= base_url().'admin_fuel/export_fuel'; ?>">
                               <div class="row">
                                  <div class="col-12">
                                    <?php if($this->session->flashdata('notify') != '') {?>
                                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                    <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                                  </div>
                                 <div class="col-2">
                                   <label>Customer</label>
                                   <select class="form-control js-example-basic-single" name="customer_id" id="customer_id">
                                     <option value="">Please select</option>
                                     <?php if(!empty($all_customer)){ foreach ($all_customer as $key => $value) {
                                       echo '<option value="'.$value['customer_id'].'">'.$value['customer_name'].'-'.$value['cid'].'</option>';
                                     } } ?>
                                   </select>
                                 </div>
                                 <div class="col-2">
                                   <label>Status</label>
                                   <select class="form-control" name="status" id="status">
                                     <option value="">Please select</option>
                                     <option value="1">ACTIVE</option>
                                     <option value="2">EXPIRED</option>
                                   </select>
                                 </div>
                                 <div class="col-1">
                                   <button class="btn btn-primary mt-3" type="submit">EXPORT</button>
                                 </div>
                                 <div class="col-1">
                                   <a href="<?= base_url().'admin_fuel/export_fuel' ?>" class="btn btn-danger mt-3">RESET</a>
                                 </div>
                               </div>
                             </form>
                          </div>
                        </div> 
                    </div>
                    </div>
                </div>
                <!-- END: Listing-->
            </div>
        </main>
<?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });
</script>