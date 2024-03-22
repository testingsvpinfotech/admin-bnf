<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  #example_filter{display: none;}
  .input-group{
    width: 60%!important;
  }
</style>
    <!-- START: Body-->
    <body id="main-container" class="default">
        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title" style="float:left;">Tat Master</h4>
                              <a href="<?= base_url('admin/view-upload-tat'); ?>" class="btn btn-primary" style="float:right;">Upload Tat</a>
                          </div>
                          <div class="card-body">
                             <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                              <!-- id="example" -->
                                <form action="<?= base_url('admin/view-tat-master');?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                <div class="col-sm-2 col-sm-offset-3">
                                 <input type="text" class="form-control" name="from" placeholder="From " value="<?php if(!empty($_POST['from'])){ echo $_POST['from'];}else{ echo '';} ?>">
                                 </div>
                                <div class="col-sm-2 col-sm-offset-3">
                                 <input type="text" class="form-control" name="to" placeholder="To" value="<?php if(!empty($_POST['to'])){ echo $_POST['to'];}else{ echo '';} ?>">
                                 </div>
                                 <div class="col-sm-4">
                                 <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:14px;"></i></button>
                                 <a href="<?= base_url('admin/view-tat-master');?>" class="btn btn-primary"><i class="fa fa-refresh" style="font-size:14px;"></i></a>
                                 </div>
                               </div>
                                </form>
                                  <table  class="display table table-bordered" data-filtering="true" data-paging="true" >
                                      <thead>
                                          <tr>
                                              <th scope="col">Id</th>
                                              <th scope="col">From</th>                                             
                                              <th scope="col">To</th>                                             
                                              <th scope="col">Tat</th>                                             
                                              <th scope="col">Mode</th>                                             
                                              <th scope="col">Add Date</th>                                             
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                  if (!empty ($tat_master)){
                                    $cnt = $serial_no;
                                    foreach ($tat_master as $rgn) {
                                  ?>
                                  <tr>
                                    <td><?php echo $cnt;?></td>
                                    <td><?php echo $rgn['tat_from'];?></td>
                                    <td><?php echo $rgn['tat_to'];?></td>
                                    <td><?php echo $rgn['tat'];?></td>
                                    <td><?php echo $rgn['mode_name'];?></td>
                                    <td><?php echo $rgn['created_at'];?></td>
                                    </tr>
                                    <?php  $cnt++;
                                  }
                            }
                             else{
                            echo "<p>No Data Found</p>";
                             } ?>
                                </tbody>
                                  </table> 
                              </div>
                          </div>
                          <div class="row">
									<div class="col-md-6">
										<?php echo $this->pagination->create_links(); ?>
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
