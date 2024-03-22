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
  	.form-control{
  		color:black!important;
  		border: 1px solid var(--sidebarcolor)!important;
  		height: 27px;
  		font-size: 10px;
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
                              <h4 class="card-title">Payment History</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/list-history" method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                             <div class="form-row">                                                    
                                                    <div class="col-sm-4">
                                                        <label for="username">Customer</label>
                                                        <select class="form-control" name="customer_id" id="customer_id">
                                                            <option value="ALL">ALL</option><?php foreach ($customers_list as $value) { ?><option value="<?php echo $value['customer_id']; ?>"><?php echo $value['customer_name']; ?></option><?php  }  ?>
                                                        </select>
                                                    </div>
                                                     <div class="col-sm-3">
                                                          <label for="">From Date</label>                       
                                                          <input type="date" name="from_date" id="from_date" autocomplete="off" class="form-control">
                                                    </div>
                                                    <div class="col-sm-3">
                                                       <label for="">To Date</label>
                                                      <input type="date" name="to_date" id="to_date" autocomplete="off" class="form-control">   
													</div>
                                                
                                                 
                                                <div class="col-sm-2">
                                                    <input type="submit" class="btn btn-primary" style="margin-top: 25px;" name="submit" value="Search"> 
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                              <div class="table-responsive">
                                   <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>                                                   
                                              <th scope="col">Customer</th>
                                              <th scope="col">Invoice#</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">Entry No</th>
                                              <th scope="col">Ref No</th>
                                              <th scope="col">Ref Date</th>                                             
                                              <th scope="col">Payment Method</th>
                                              <th scope="col">Invoice Amount </th>
											  <th scope="col">Ref Amount </th>
                                              <th scope="col">Received Amount</th>
                                              <th scope="col">Discount</th>
                                              <th scope="col">Total Received</th>
                                              <th scope="col">TDS Amount</th>
                                              <th scope="col">Total</th>
											  <?php  if ($this->session->userdata("userType") == '1') { ?>		
												<th scope="col">Action</th>
											  <?php } ?>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                     <?php
                                      if (!empty($payment_history)) {
                                            foreach ($payment_history as $value) {
                                                ?>
                                               <tr>
                                                  <td><?php echo $value['customer_name']; ?></td>
                                                  <td><?php echo $value['invoice_number']; ?></td>
                                                  <td><?php echo date("d-m-Y",strtotime($value['invoice_date'])); ?></td>  
                                                  <td><?php echo $value['entry_no']; ?></td>
                                                  <td><?php echo $value['reference_no']; ?></td> 
												  <td><?php echo date('d/m/Y', strtotime(($value['reference_date']))); ?></td>
												  <td>
												  <?php 
												  $whr_p = array('id'=>$value['payment_method']);
												  $pay_details= $this->basic_operation_m->get_table_row('payment_method',$whr_p);
												  echo $pay_details->method;
												  ?>
												  </td>
												   <td><?php echo $value['invoice_amount']; ?></td>
												  <td><?php echo $value['reference_amt']; ?></td>
												  <td><?php echo $value['amount_recieved']; ?></td>
												  <td><?php echo $value['discount']; ?></td>
												  <td><?php echo ($value['reference_mapped_amt']); ?></td>
												  <td><?php echo $value['tds_amt']; ?></td>
                                                  <td><?php echo ($value['reference_mapped_amt']+$value['tds_amt']); ?></td>
												  <?php  if ($this->session->userdata("userType") == '1') { ?>		
                                                  <td>											  										  
												  <a href="admin/delete-payment-history/<?php echo $value['r_del_id'];?>/<?php echo $value['p_del_id'];?>" onclick="return confirm('Are you sure you want to delete this item?');" ><i class="ion-trash-b" style="color:var(--danger)"></i></a>
												</td>    
												<?php } ?>											  
                                               </tr>
                                            <?php
                                        }
                                    } else {
                                        echo str_repeat("<td></td>",13);
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
<script>
function matchStart (term, text) {
  if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
    return true;
  }
 
  return false;
}
 
$.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
  $("#customer_id").select2({
    matcher: oldMatcher(matchStart)
  })

});

</script>
