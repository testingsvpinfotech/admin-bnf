
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
                              <h4 class="card-title">SERVICE PINCODE UTILITY</h4>
                          </div>
                          <div class="card-body">
                             <form id="import_form">
                               <div class="row">
                                  <div class="col-12">
                                    <?php if($this->session->flashdata('notify') != '') {?>
                                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                    <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                                  </div>
                                 <div class="col-2">
                                   <label>Import</label>
                                   <input name="serv_pin" id="serv_pin" class="form-control" type="file" required accept=".csv, .xls, .xlsx">
                                 </div>
                                 <div class="col-1">
                                   <button class="btn btn-primary mt-3" type="submit" name="import" value="Import">IMPORT</button>
                                 </div>
                                 <div class="col-1">
                                   <a href="<?= base_url().'utility/service_pincode_utility' ?>" class="btn btn-danger mt-3">RESET</a>
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
  $('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>utility/import_service_pin",
   method:"POST",
   data:new FormData(this),
   contentType:false,
   cache:false,
   processData:false,
   success:function(data){
    $('#serv_pin').val('');
    // load_data();
    alert("FILE UPLOADED SUCCESSFULLY");
   }
  })
 });
</script>