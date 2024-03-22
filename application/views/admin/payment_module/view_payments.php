     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

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
                              <h4 class="card-title">Payment list</h4>                              
                          </div>
                           <div class="card-body border" id="div_transaction" style="display:none"; >
                             <h6><b>Transaction</b><a href="" onclick="return hide_transaction_div()" ><i class="ion-close-circled"></i></a></h6>              
                             <div class="row" >   
                              <div class="col-12"> 
                                 <form role="form" action="admin/save-international-payments" method="post"  enctype="multipart/form-data">
                                <div class="box-body">                 
                                 <div class="form-group row">                                   
                                      <div class="col-sm-3">
                                        <input type="hidden" name="invoice_id" id="invoice_id" value="" />
                                        <label>Amount Recieved</label>
                                        <input type="number" class="form-control" name="amount_recieved" placeholder="Amount Recieved">
                                      </div> 
                                      <div class="col-sm-3">
                                        <label>Payment Date</label>
                                        <input type="date" class="form-control" name="payment_date" placeholder="">
                                      </div> 
                                      <div class="col-sm-3">
                                        <label>Payment Mode</label>
                                        <input type="text" class="form-control" name="payment_mode" placeholder="Payment Mode">
                                      </div> 
                                       <div class="col-sm-3">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control"></textarea>
                                      </div> 
                                      <div class="col-sm-3">                                        
                                         <input type="submit" class="btn btn-primary" name="submit" id="submit">
                                      </div>          
                                  </div>       
                              </div>    
                             </form>     
                              </div>
                            </div>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>   
                                              <th scope="col">Invoice #</th>                                              
                                              <th scope="col">Amount</th>
                                              <th scope="col">Total Tax</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">Customer</th>
                                              <th scope="col">Due Date</th>
                                              <th scope="col">Status</th>                        
                                              <th scope="col">GSTNO</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                         <?php
                                          if (!empty($allpoddata)) {
                                          foreach ($allpoddata as $value) {
                                              ?>
                                              <td>
                                                <!-- <a href="<?php echo base_url('booking/view_payment/'.$value['id'])?>"> -->
                                                <a href="" onclick="return show_transaction('<?php echo $value['id']; ?>')">
                                                <?php echo $value['invoice_number']; ?>
                                                </a>
                                              </td>
                                             
                                              <td><?php echo $value['amount']; ?></td>
                                              <td><?php echo $value['igst_amount']; ?></td>
                                              <td><?php echo date('d/m/Y', strtotime(($value['invoice_date']))); ?></td>
                                              <td><?php echo $value['customer_name']; ?></td>
                                              <td><?php echo date('d/m/Y',strtotime('+30 days',strtotime($value['invoice_date']))); ?></td>
                                              <td>Pending</td>
                                              <td><?php echo $value['gstno']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
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
<script type="text/javascript">
   function hide_transaction_div()
  {
      $("#div_transaction").hide();  
      return false; 
  }
  function show_transaction(id){
      $("#div_transaction").show();  
      $("#invoice_id").val(id);
      return false; 
  }
</script>
