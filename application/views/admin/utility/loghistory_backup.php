
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
                              <h4 class="card-title">BACKUP LOG ACTIVITY UTILITY</h4>
                          </div>
                          <div class="card-body">
                             <form action="<?= base_url().'utility/download_log_backup'; ?>" method="post" id="loghistory_form">
                               <div class="row">
                                  <div class="col-12">
                                    <?php if($this->session->flashdata('notify') != '') {?>
                                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                    <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                                  </div>
                                 <div class="col-2">
                                   <label>From Date</label>
                                   <input name="from_date" id="from_date" class="form-control" type="date">
                                 </div>
                                 <div class="col-2">
                                   <label>To Date</label>
                                   <input name="to_date" id="to_date" class="form-control" type="date">
                                 </div>
                                 <div class="col-4">
                                   <button class="btn btn-primary mt-3" type="submit" name="submit" value="download">DOWNLOAD</button>
                                   <button class="btn btn-danger mt-3" type="submit" name="submit" value="delete">DELETE</button>
                                   <!-- <button class="btn btn-danger mt-3" onclick="download_backup(1)" >DELETE</button> -->
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
  // $('#loghistory_form').on('submit', function(event){
    function download_backup(id){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>utility/download_log_backup/"+id,
   method:"POST",
   data:$('#loghistory_form').serialize(),
   // contentType:false,
   // cache:false,
   // processData:false,
   success:function(data){
    $('#from_date').val('');
    $('#to_date').val('');
    // load_data();
    alert("FILE UPLOADED SUCCESSFULLY");
   }
  })
 }
</script>