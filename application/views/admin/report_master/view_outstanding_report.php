     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
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
                              <h4 class="card-title">Outstanding Report</h4>
                          </div>
                          <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/list-outstanding-report" method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                             <div class="form-row">
                                                    
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
                                                
                                                 <!--<div class="col-sm-2">
                                                        <label>Status</label>
                										<select class="form-control" name="status">
                											<option value="ALL">ALL</option>
                											<option value="0">Pending</option>
                											<option value="1">Delivered</option>
                										</select>
                                                    </div>-->
                                                     
                                                <div class="col-sm-3">
                                                    <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Search"> 
                                                </div>
                                            </div>
                                         
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                          <div class="card-body">
                             <div class="table-responsive">
                            <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                <thead>
                                      <tr>                                                   
										  <th scope="col">SrNo</th>
										  <th scope="col">Customer</th>
										  <th scope="col">Invoice#</th>
										  <th scope="col">Date</th>
										  <th scope="col">Entry No</th>
										  <th scope="col">Ref No</th>
										  <th scope="col">Ref Date</th>                                             
										  <th scope="col">Payment Method</th>
										  <th scope="col">Ref Amount </th>
										  <th scope="col">Received Amount</th>
										  <th scope="col">Discount</th>
										  <th scope="col">TDS Amount</th>
										  <th scope="col">Total Received Amount</th>
									  </tr>
                                    </tr>
                                </thead>
                                      <tbody>                                 
                                       <tr>
                                        <?php
                                        $i=0;
                                            if (!empty($inv_list)) {
                                              
                                               foreach ($inv_list as $value) {
                                                $i++;
                                              ?>
                                                <td style="width:20px;"><?php echo $i; ?></td>
                                                 <td><?php echo $value['customer_name']; ?></td>
                                                  <td><?php echo $value['invoice_number']; ?></td>
                                                  <td><?php echo $value['invoice_date']; ?></td>  
                                                  <td><?php echo $value['entry_no']; ?></td>
                                                  <td><?php echo $value['reference_no']; ?></td> 
												  <td><?php if(!empty($value['reference_date'])){echo date('d/m/Y', strtotime(($value['reference_date'])));}else{echo "";} ?></td>
												  <td>
												  <?php 
												  if(!empty($value['payment_method'])){
												  $whr_p = array('id'=>$value['payment_method']);
												  $pay_details= $this->basic_operation_m->get_table_row('payment_method',$whr_p);
												  echo $pay_details->method;
												  }else{echo "";}
												  ?>
												  </td>
												  <td><?php echo $value['reference_amt']; ?></td>
												  <td><?php echo $value['amount_recieved']; ?></td>
												  <td><?php echo $value['discount']; ?></td>
												  <td><?php echo $value['tds_amt']; ?></td>
                                                  <td><?php echo $value['reference_mapped_amt']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        echo "<p>No Data Found</p>";
                                    }
                                  
                                    ?>
                        
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
</body>
<!-- END: Body-->

