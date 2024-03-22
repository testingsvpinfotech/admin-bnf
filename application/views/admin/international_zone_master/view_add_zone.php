<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  .buttons-excel{display: none;}
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
                              <h4 class="card-title">Upload Zone</h4>
                               <span style="float: right;">

                               <!--  <a href="admin/view-international-zone" class="btn btn-primary">View Uploaded Data</a> -->

                                <a href="<?php echo base_url();?>assets/upload_shipment_rate/sample_file_zone.csv" class="btn btn-primary">Sample File</a>
                                 </span>
                          </div>
						    <div class="card-content">
                          <div class="card-body">
						   <div class="row">                                           
                      <div class="col-12">
                               <form role="form" action="admin/insert_zone" method="post" enctype="multipart/form-data" >
							  <div class="box-body">                								 
								 <div class="form-group row">
									  <label for="ac_name" class="col-sm-2 col-form-label">Courier Name</label>
                  					<div class="col-sm-2">
                                        <select class="form-control"  name="c_courier_id" required>
                                           <option value="">-Select Courier-</option>
                                          <?php foreach ($courier_company as $val) { ?>
                                          <option value="<?php echo $val['c_id'];?>"><?php echo $val['c_company_name'];?></option>
                                        <?php } ?>
                                        </select>
                    				</div>									
                								  
                                      <label for="ac_name" class="col-sm-1 col-form-label">Type</label>
                                      <div class="col-sm-2">  
                                             <select class="form-control" name="zone_type" required>
                                               <option value="">-Select Type-</option>   
                                                <option value="Export">Export</option>
                                                 <option value="Import">Import</option>
                                            </select>                                         
                                      </div> 
                                        <label for="ac_name" class="col-sm-2 col-form-label">Select File</label>
                                        <div class="col-sm-2">
                                          <input type="file" name="upload_zone" required>
                                        </div>           
                                    </div>     
                					<div class="form-group row">
      								  <div class="col-sm-12">
          								  <div class="box-footer" >
          									<button type="submit"  class="btn btn-primary">Upload zone</button>
          								  </div>
      								  </div>
                                    </div>
                								  <!-- /.box-body -->                								  
                								</div>
                							</form>
                        </div> 
                           <div class="card-body">
                            <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                 <!--  <table class="table layout-primary bordered"> -->
                                     <table id="example" class="display table dataTable table-striped table-bordered" data-filtering="true" >
                                      <thead>
                                         <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">Courier Name</th>
                                               <th scope="col">Type</th>
                                               <th scope="col">Date</th>
                                         </tr>
                                      </thead>
                                     <tbody>
                                            <?php 
                                            if (!empty($courier_zone_list))
        									{
        										$cnt = 0;
                                                foreach ($courier_zone_list as $value) {
                                                  $cnt++;
                                             ?>
											 <tr>
												<td scope="col"><?php echo $cnt; ?></td>
		                                        <td><a href="admin/view-international-zone/<?php echo $value['c_courier_id']; ?>/<?php echo $value['zone_type']; ?>/<?php echo $value['uploaded_date']; ?>" ><b><?php echo $value['c_company_name']; ?></b></a></td> 
		                                        <td><?php echo $value['zone_type']; ?></td> 
		                                        <td><?php echo date("d-m-Y",strtotime($value['uploaded_date']) ); ?></td>
											  </tr>
                                              <?php 
                                            }
                                         }
                                         else{
                                        echo "<p>No Data Found</p>";
                                         }
                                      ?>
                                </tbody>
                                  </table> 
                              </div>
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
