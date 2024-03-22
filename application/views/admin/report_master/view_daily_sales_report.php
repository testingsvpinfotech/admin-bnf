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
    <body id="main-container" class="default">
      <style>
        .select2-container--default .select2-selection--single {
        background: lavender!important;
        }
      </style>
        
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
                              <h4 class="card-title">Daily Sales Report</h4>
                             <!--  <span style="float: right;"><a href="<?php base_url();?>admin/add-homeslider" class="fa fa-plus btn btn-primary">Add Home Slider</a></span> -->
                          </div>
                          <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/list-DSR" method="post" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-sm-2">
                                                <label for="username">Bill Type</label>
                                                <select class="form-control" name="bill_type">
                                                      <option value="ALL">ALL</option>                           
                                                      <option value="Credit">Credit</option>
                                                      <option value="Cash">Cash</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="username">Type</label>
                                                <select class="form-control" name="company_type">
                                                      <option value="ALL">ALL</option>                           
                                                      <option value="International">International</option>
                                                      <option value="Domestic">Domestic</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="username">Customer</label>
                                                <select class="form-control" name="customer_id" id="customer_id">
                                                    <option value="ALL">ALL</option>
                                                    <?php foreach ($customers_list as $value) { ?>   
                                                    <option value="<?php echo $value['customer_id']; ?>"><?php echo $value['customer_name']; ?></option>
                                                  <?php  }  ?>
                                                </select>
                                            </div>
                                             <div class="col-sm-2">
                                                  <label for="">From Date</label>                       
                                                  <input type="date" name="from_date" id="from_date" autocomplete="off" class="form-control">
                                            </div>
                                             <div class="col-sm-2">
                                               <label for="">To Date</label>
                                              <input type="date" name="to_date" id="to_date" autocomplete="off" class="form-control">   
                                        </div>
                                        <div class="col-sm-2">
                                             <div class="form-group">
                                                <label for="">Doc/Non-Doc</label>
                                                <select class="form-control" name="doc_type">
                                                      <option value="ALL">ALL</option>                           
                                                      <option value="1">Non-Doc</option>
                                                      <option value="0">Doc</option>
                                                </select>
                                            </div>                  
                                        </div>
                                        <div class="col-sm-2">
                                                <label>AWB No</label>
        										<input type="text" class="form-control" name="awb_no">
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="username">Network</label>
                                            <select class="form-control" name="courier_company" id="courier_company">
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($courier_company as $cc) { ?>   
                                                <option value="<?php echo $cc['c_id']; ?>"><?php echo $cc['c_company_name']; ?></option>
                                              <?php  }  ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Search"> 
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                 <thead>
                                  <th>AWB</th>
                                  <th>ForwordNo</th>
                                  <th>AWBDate</th>
                                  <th>Destination</th>
                                  <th>Customer</th> 
                                  <th>Courier</th> 
                                  <th>Mode</th> 
                                  <th>Type</th>
                                  <th>Doc/Non-Doc</th>
                                  <th>NOP</th>
                                  <th>Weight</th>
                                  <th>Total</th>
                                  <th>Receiver</th>
                                  <th>Bill Type</th>
                                  <th>Pay By</th>
                                  <th>Branch</th>
                                </thead>
                              <tbody>                                 
                                
                            <?php
                          
                            $cnt =0; 
                                if(!empty($international_daily_sales_report)){
                                foreach ($international_daily_sales_report as $key => $value) {
                                    $cnt++;
                                ?>
                                <tr>
                                    <!--<td><?php echo  $cnt;?></td>-->
                                    <td><?php echo  $value['pod_no'];?></td>
                                    <td><?php echo  $value['forwording_no'];?></td>
                                    <td><?php echo  date("d-m-Y",strtotime($value['booking_date'])); ?></td>
                                    <td><?php echo  $value['country_name'];?></td>
                                    <td><?php echo  $value['sender_name'];?></td>
                                    <td><?php echo  $value['c_company_name'];?></td>
                                    <td><?php echo  $value['mode_dispatch'];?></td> 
                                    <td><?php echo  $value['company_type'];?></td>                   
                                    <td><?php echo  $value['doc_nondoc'];?></td>
                                    <td><?php echo  $value['no_of_pack'];?></td>
                                    <td><?php echo  $value['chargable_weight'];?></td>
                                    <td><?php echo  $value['grand_total'];?></td>
                                    <td><?php echo  $value['reciever_name'];?></td>
                                    <td><?php echo $value['dispatch_details']; ?></td>
                                    <td><?php echo $value['method']; ?></td>
                                    <td><?php echo $value['branch_name']; ?></td>
                                    
                                </tr>
                           <?php } }
                           if(!empty($domestic_daily_sales_report)){
                                foreach ($domestic_daily_sales_report as $value_d) {
                                    
                                    $cnt++;
                                ?>
                                <tr>
                                    <!--<td><?php echo  $cnt;?></td>-->
                                    <td><?php echo  $value_d['pod_no'];?></td>
                                    <td><?php echo  $value_d['forwording_no'];?></td>
                                    <td><?php echo  date("d-m-Y",strtotime($value_d['booking_date'])); ?></td>
                                    <td><?php echo  $value_d['city'];?></td>
                                    <td><?php echo  $value_d['sender_name'];?></td>
                                    <td><?php echo  $value_d['c_company_name'];?></td>
                                    <td><?php echo  $value_d['mode_name'];?></td> 
                                    <td><?php echo  $value_d['company_type'];?></td>                   
                                    <td><?php echo  $value_d['doc_nondoc'];?></td>
                                    <td><?php echo  $value_d['no_of_pack'];?></td>
                                    <td><?php echo  $value_d['chargable_weight'];?></td>
                                    <td><?php echo  $value_d['grand_total'];?></td>
                                    <td><?php echo  $value_d['reciever_name'];?></td>
                                    <td><?php echo $value_d['dispatch_details']; ?></td>
                                    <td><?php echo $value_d['method']; ?></td>
                                    <td><?php echo $value_d['branch_name']; ?></td>
                                    
                                </tr>
                           <?php } 
                           }?>
                          
                           <?php if(empty($domestic_daily_sales_report) && empty($international_daily_sales_report)){?>
                           <tr>
                               <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total:</b></td><td><b>0</b></td><td><b>0</b></td><td><b>0</b></td><td></td><td></td><td></td>
                           </tr>
                           <?php }else{ ?>
                            <tr>
                               <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total:</b></td><td><b><?php echo  $total_no_of_pack;?></b></td><td><b><?php echo  $total_chargable_weight;?></b></td><td><b><?php echo  round($total_grand_total);?></b></td><td></td><td></td><td></td>
                           </tr>
                           <?php } ?>
                          
                         </tbody>
                              </table> 
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
    <script type="text/javascript">
      $("#customer_id").select2();
    </script>

</body>
<!-- END: Body-->

