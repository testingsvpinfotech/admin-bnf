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
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">
                              <h4 class="card-title">International Rate</h4>
                              <span style="float: right;"></span>
                          </div>
                 <div class="card-body">
                   <div class="row">   
                    <div class="col-12">                            
                              <form role="form" action="admin/show_international_courier" method="post"  enctype="multipart/form-data">
                                <div class="box-body">                 
                                 <div class="form-group row">                                   
                                      <div class="col-sm-3">
                                        <select name="customer_name" class="form-control" >
                                           <option value="">-Select Customer-</option>
                                           <?php foreach ($customer_list as $cusl) { ?>
                                          <option value="<?php echo $cusl['customer_id'] ?>" <?php if(isset($edit_customer_id)){
                                            if($cusl['customer_id']==$edit_customer_id){echo "selected";}
                                          } ?> ><?php echo $cusl['customer_name'] ?></option>                                          
                                           <?php } ?>
                                         </select>
                                      </div> 
                                      <div class="col-sm-3">                                        
                                         <input type="submit" class="btn btn-primary" name="submit" id="submit">
                                      </div>          
                                  </div>       
                              </div>    
                             </form>                       
                        </div> 
                  </div>

                  <!-- <hr> -->
                  </div>
                <div class="card-body">
                   <div class="row" id="div_transfer_rate" style="display: none;">   
                    <div class="col-12">                            
                              <form role="form" action="admin/insert-transfer-rate" method="post" enctype="multipart/form-data">
                                <div class="box-body border">   
                                <h6><b>Transfer Rate</b><a href="" onclick="return hide_transfer_div()"  ><i class="ion-close-circled"></i></a></h6>              
                                 <div class="form-group row">  
                                        <label class="col-sm-1">Courier</label> 
                                        <div class="col-sm-2">
                                         <input type="hidden" name="courier_id" id="courier_id">
                                         <input type="hidden" name="transfer_customer_id" id="transfer_customer_id">
                                         <input type="text" name="c_company_name" id="c_company_name" readonly class="form-control">
                                      </div>                                       
                                        <label class="col-sm-1">To</label>
                                        <div class="col-sm-3">
                                        <select name="to_customer_id[]" id="to_customer" class="form-control" multiple size = 8 >
                                           <?php foreach ($customer_list as $custl) { ?>
                                          <option value="<?php echo $custl['customer_id'] ?>" ><?php echo $custl['customer_name'] ?></option>                                          
                                           <?php } ?>
                                         </select>
                                      </div>                                    
                                      <label class="col-sm-1">Transfer Date</label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control datepicker" name="transfer_date" id="transfer_date">
                                       </div>
                                       
                                      <div class="col-sm-1">                                        
                                         <input type="submit" class="btn btn-primary" name="submit" id="submit_transfer">
                                      </div>          
                                  </div>       
                              </div> 
                              </form>                          
                        </div>
                       <!--   <hr>  -->
                  </div>
                 
                  </div>
                    <div class="card-body">
                   <div class="row" id="div_upload_rate"  style="display: none;">   
                    <div class="col-12">                            
                          <form role="form" action="admin/upload-rate" method="post" enctype="multipart/form-data">
                            <div class="box-body border">   
                                  <input type="hidden" name="courier_company_name" id="courier_company_name">
                                  <input type="hidden" name="customer_name"  id="customer_name">
                                 <h6><b>Upload Rate</b><a href="" onclick="return hide_upload_div()"  ><i class="ion-close-circled"></i></a>

                                 <!--  <span style="float: right;"><a href="<?php echo base_url();?>assets/upload_shipment_rate/sample_file.csv" class="btn btn-primary">Sample File</a> 
                                  </span> -->
                                </h6>              
                                 <div class="form-group row">                                   
                                      <div class="col-sm-2">
                                        <label>Type</label> 
                                         <select name="doc_type" class="form-control" >
                                              <option value="">-Select Type-</option>
                                              <option value="0" >Doc</option>
                                              <option value="1" >Non-Doc</option>
                                         </select>
                                      </div> 
                                      <div class="col-sm-2">
                                        <label>Export/Import</label>
                                       <select name="type_export_import" class="form-control" >
                                              <option value="">-Export/Import-</option>
                                              <option value="Export" >Export</option>
                                              <option value="Import" >Import</option>
                                         </select>
                                      </div> 
                                       <div class="col-sm-2">
                                        <label>From Date</label>
                                        <input type="text" class="form-control datepicker" placeholder="Select Date" name="from_date" id="from_name">
                                       </div>
                                       <div class="col-sm-3">
                                        <label>Upload File</label>
                                       <div class="col-sm-2">
                                        <input type="file" name="upload_rate">
                                      </div>  

                                       </div>
                                      <div class="col-sm-3">                                        
                                         <input type="submit" class="btn btn-primary" name="submit" id="submit_transfer">
                                         <a href="<?php echo base_url();?>assets/upload_shipment_rate/sample_file.csv" class="btn btn-primary">Sample File</a> 
                                      </div>          
                                  </div>       
                              </div> 
                              </form>                          
                        </div>
                       <!--   <hr>  -->
                  </div>
                 
                  </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                    <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true"  >
                                      <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
  <b><?php if(isset($cust_data)){echo $cust_data->customer_name;} ?></b>
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <!-- <th scope="col">Customer</th> -->
                                               <th scope="col">Courier</th>
                                               <th scope="col">Date</th>
                                               <th scope="col">Export/Import</th>
                                               <!-- <th scope="col">View</th> -->
                                               <th scope="col">Upload</th>
                                               <th scope="col">Rate Transfer</th>          
                      											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php
                                              if (!empty($courierwise_rate_data))
                            				{
                            					$cnt = 0;
                                                foreach ($courierwise_rate_data as $value) {
                                                  $cnt++;
                                                 // $whr = array('courier_company_id'=>$value['c_id'],'customer_id'=>$cust_data->customer_id);

                                                 // $courierwise_rate_data = $this->Rate_model->get_international_table_row('tbl_international_rate_master',$whr);
                                                  //echo "<pre>";
                                                  //print_r($courierwise_rate_data);exit;
                                              ?>
        									<tr>
          										<td scope="col"><?php echo $cnt; ?></td>
                                                 <!--  <td><?php echo $cust_data->customer_name; ?></td> -->
                                                  <td><?php echo $value['c_company_name']; ?></td>
                                                  <td><?php if($value['from_date']!=""){echo date("d-m-Y",strtotime($value['from_date']) );} ?></td>
                                                  
                                                  <td>
                                                    <?php echo $value['type_export_import']; ?>

                                                  </td> 
                                                  <td> 
                                                    <a target="_blank" href="" onclick="return show_upload_div(<?php echo $value['c_id']; ?>,<?php echo "'".$cust_data->customer_id."'"; ?>)" class="btn btn-primary btn-small"><i class="ion-ios-upload"></i></a>
                                                  </td>
                                                  
                                                  <td>
                                                     <?php if($courierwise_rate_data){ ?>  
                                                      <a href="" onclick="return show_div(<?php echo $value['c_id']; ?>,<?php echo "'".$value['c_company_name']."'"; ?>,<?php echo "'".$cust_data->customer_id."'"; ?>)" class="btn btn-primary btn-small">Rate Transfer</a>

                                                    <?php } ?> </td>
                                                  <td>
                                                     <?php if($courierwise_rate_data){ ?>  
                                                   <a href="admin/view-uploded-international-rate/<?php echo $edit_customer_id; ?>/<?php echo $value['c_id']; ?>/<?php if($value['from_date']!=""){echo date("d-m-Y",strtotime($value['from_date']) );} ?>" title="View" class="btn" ><i class="ion-forward" style="color:var(--primarycolor)"></i></a>  |  

                                                    <a href="<?php echo base_url();?>admin/delete-international-rate/<?php echo $cust_data->customer_id;?>/<?php echo $value['c_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');" class="btn"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                    <?php } ?> 
                                                  </td>
                            									</tr>
                                              <?php 
                                            }
                                         }
                                         else{ ?>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>                                         
                                      <?php } ?>
                                </tbody>
                                  </table> 
                              </div>
                          </div>

                   <!--        <div class="card-body">
                              <div class="table-responsive">
                                   <table id="example" class="display table dataTable table-striped table-bordered layout-primary" >
                                        <thead>
                                            <tr>
                                                <th scope="col">Sr.</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Courier</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Export/Import</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php 
                                              if (!empty($added_customer_list))
                                              {
                                                $cnt = 0;
                                                foreach ($added_customer_list as $value) {
                                                  $cnt++;
                                              ?>
                                              <tr>
                                                  <td scope="col"><?php echo $cnt; ?></td>
                                                  <td><a href="admin/view-uploded-international-rate/<?php echo $value['customer_id']; ?>/<?php echo $value['c_id']; ?>" ><?php echo $value['customer_name']; ?></a></td> 
                                                  <td><?php echo $value['c_company_name']; ?></td> 
                                                  <td><?php if($value['from_date']){echo date("d-m-Y",strtotime($value['from_date']) );} ?></td>
                                                  <td><?php echo $value['type_export_import'];?></td>
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
                            </div> -->


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
<script type="text/javascript">  
   function show_upload_div(courier_id,customer_id)
  {
      $("#courier_company_name").val(courier_id);
      $("#customer_name").val(customer_id);
      $("#div_upload_rate").show();  
      return false; 
  }
  function show_div(courier_id,c_company_name,customer_id)
  {
      $("#courier_id").val(courier_id);
      $("#c_company_name").val(c_company_name);
      $("#transfer_customer_id").val(customer_id);
      

      $("#div_transfer_rate").show();  
     // $("#to_customer").select2();
      return false; 
  }
   function hide_upload_div(courier_id,customer_id)
  {
      $("#div_upload_rate").hide();  
      return false; 
  }
  function hide_transfer_div(courier_id,c_company_name)
  {
      $("#div_transfer_rate").hide();  
      return false; 
  }
 $('#to_customer').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                maxHeight: 150
              }); 

 
  
</script>

