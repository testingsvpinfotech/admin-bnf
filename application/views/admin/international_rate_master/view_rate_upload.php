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
                              <h4 class="card-title">Upload Rate</h4>
                              <span style="float: right;"><a href="<?php echo base_url();?>assets/upload_shipment_rate/sample_file.csv" class="btn btn-primary">Sample File</a> </span>
                          </div>
						  <div class="card-content">
                <div class="card-body">
    						   <div class="row">   
                    <div class="col-12">                            
                              <form role="form" action="admin/upload-rate" method="post"  enctype="multipart/form-data">
                                <div class="box-body">                 
                                 <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Courier</label>
                                    <label class="col-sm-3 col-form-label">Customer</label>
                                    <label class="col-sm-2 col-form-label">Type</label>
                                    <label class="col-sm-2 col-form-label">Export/Import</label>
                                    <label class="col-sm-2 col-form-label">From Date</label>
                                    <div class="col-sm-2"> 
                                         <input type="hidden" name="courier_company_name" value="<?php echo $courier_company->c_id; ?>">
                                         <input type="text" name="show_courier_company" class="form-control" value="<?php echo $courier_company->c_company_name; ?>">
                                      </div> 
                                      <div class="col-sm-3">
                                        <input type="hidden" name="customer_name" value="<?php echo $customer_list->customer_id; ?>">
                                         <input type="text" name="show_customer_name" class="form-control" value="<?php echo $customer_list->customer_name; ?>">
                                      </div>    
                                      <div class="col-sm-2">
                                        <select name="doc_type" class="form-control" >
                                              <option value="">-Select Type-</option>
                                              <option value="0" >Doc</option>
                                              <option value="1" >Non-Doc</option>
                                         </select>
                                      </div>
                                      <div class="col-sm-2">
                                        <select name="type_export_import" class="form-control" >
                                              <option value="">-Export / Import-</option>
                                              <option value="Export" >Export</option>
                                              <option value="Import" >Import</option>
                                         </select>
                                      </div>
                                      <div class="col-sm-2">                                        
                                         <input type="text" class="form-control datepicker" placeholder="Select Date" name="from_date" id="from_name">
                                      </div>          
                                  </div>       
                              </div>                           
                        </div> 
                  </div>                  
                  </div>
                  <div class="card-body"> 
                   <div class="row">   
                    <div class="col-12">                               
                     <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Select File</label>
                            <div class="col-sm-3">
                              <input type="file" name="upload_rate">
                            </div>  

                             <div class="col-md-3">                                        
                              <button type="submit" class="btn btn-primary">Upload CSV File</button>
                            </div>
      
                        </div>                                 
                        </div>            
                    </div>
                </div>
                </form> 
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
