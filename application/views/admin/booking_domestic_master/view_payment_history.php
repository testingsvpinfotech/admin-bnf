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
                              <h4 class="card-title">Payment History</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>                                                   
                                              <th scope="col">Payment #</th>
                                              <th scope="col">Invoice #</th>
                                             <!--  <th scope="col">Performa No #</th> -->
                                              <th scope="col">Payment Mode</th>
                                              <th scope="col">Transaction Id</th>
                                              <th scope="col">Customer</th>
                                              <th scope="col">Amount </th>
                                              <th scope="col">Date</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                     <?php
                                      if (!empty($payment_history)) {
                                        $cnt =0;
                                            foreach ($payment_history as $value) {
                                              $cnt++;
                                                ?>
                                               <tr>
                                                  <td>
                                                    <?php echo $cnt; ?>
                                                  </td>
                                                  <td><?php echo $value['invoice_number']; ?></td>
                                                  <!-- <td><?php //echo $value['performa_invoice_number']; ?></td> -->
                                                  <td><?php echo $value['payment_mode']; ?></td>
                                                  <td></td>
                                                  <td><?php echo $value['customer_name']; ?></td>
                                                  <td><?php echo $value['amount_recieved']; ?></td>
                                                  <td><?php echo date('d/m/Y', strtotime(($value['payment_date']))); ?></td>                                           
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

