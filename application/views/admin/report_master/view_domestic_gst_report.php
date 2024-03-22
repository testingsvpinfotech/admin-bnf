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
                              <h4 class="card-title">Domestic GST Report</h4>
                          </div>
                          <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="admin/list-domestic-gst-report" method="post" enctype="multipart/form-data">
                                        <div class="form-row">                     
                                                   <div class="col-sm-3">
                                                        <label for="">From Date</label>                       
                                                        <input type="date" name="from_date" autocomplete="off" id="from_date" class="form-control">
                                                  </div>
                                                   <div class="col-sm-3">
                                                     <label for="">To Date</label>
                                                     <input type="date" name="to_date" autocomplete="off" id="to_date" class="form-control">   
                                                 </div>                          
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
                                       <th scope='col'>SN</th>
                                       <th scope='col'>Customer</th>
                                       <th scope='col'>CID</th>
                                       <th scope='col'>GST No</th>
                                       <th scope='col'>Inv&nbsp;No</th>
                                       <th scope='col'>Inv&nbsp;Date</th>
                                       <th scope='col'>Amount</th>
                                       <th scope='col'>CGST</th>
                                       <th scope='col'>SGST</th>
                                       <th scope='col'>IGST</th>
                                       <th scope='col'>Total</th>                                      
                                    </tr>
                                </thead>
                                      <tbody>                                 
                                       <tr>
                                        <?php
                                            $i=0;
                                            if (!empty($domestic_gst_data)) {
                                               foreach ($domestic_gst_data as $value) {
                                                $i++;
                                              ?>
                                                <td><?php echo $i; ?></td>   
                                                <td><?php echo $value['customer_name']; ?></td>
                                                <td><?php echo $value['cid']; ?></td>
                                                <td><?php echo $value['gstno']; ?></td>
                                                <td><?php echo $value['invoice_number']; ?></td>
                                                <td><?php echo date("d-m-Y",strtotime($value['invoice_date'])); ?></td>
                                                <td><?php echo $value['sub_total']; ?></td>
                                                <td><?php echo $value['cgst_amount'];?></td>
                                                <td><?php echo $value['sgst_amount'];?></td>
                                                <td><?php echo $value['igst_amount'];?></td>
                                                <td><?php echo round($value['grand_total']);?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                       ?>
                                       <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                       <?php
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

