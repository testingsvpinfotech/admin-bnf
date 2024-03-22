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
                              <h4 class="card-title">Domestic Credit Note GST Report</h4>
                          </div>
                          <div class="card-content">
                                <div class="card-body">
                                <div class="row">                                           
                                    <div class="col-12">
                                    <form role="form" action="<?= base_url('admin/list-cn-gst-report');?>" method="GET" enctype="multipart/form-data">
                                        <div class="form-row">    
                                                  <div class="col-md-2">
                                                        <label for="">Customer</label>
                                                        <select class="form-control" name="user_id" id="user_id">
                                                            <option value="">Selecte Customer</option>
                                                            <?php if (!empty($customer)) {
                                                                foreach ($customer as $key => $values) { ?>
                                                                    <option value="<?php echo $values['customer_id']; ?>" <?php echo (isset($_GET['user_id']) && $_GET['user_id'] == $values['customer_id']) ? 'selected' : ''; ?>><?php echo $values['customer_name']; ?></option><?php }
                                                                                                                                                                                                                                                            } ?>
                                                        </select>
                                                  </div>                 
                                                  <div class="col-sm-2">
                                                        <label for="">From Date</label>                       
                                                        <input type="date" name="from_date" autocomplete="off" id="from_date" value="<?php echo (isset($_GET['from_date'])) ? $_GET['from_date'] : ''; ?>" class="form-control">
                                                  </div>
                                                   <div class="col-sm-2">
                                                     <label for="">To Date</label>
                                                     <input type="date" name="to_date" autocomplete="off" id="to_date" value="<?php echo (isset($_GET['to_date'])) ? $_GET['to_date'] : ''; ?>" class="form-control">   
                                                 </div>                          
                                                  <div class="col-sm-3">
                                                    <br>
                                                      <input type="submit" class="btn btn-primary btn-sm mt-2" style="margin-top: 25px;" name="submit" value="Search"> 
                                                      <a href="<?= base_url('admin/list-cn-gst-report')?>" class="btn btn-info btn-sm mt-2">Reset</a>
                                                      <input type="submit" class="btn btn-success btn-sm mt-2" name="download_report" value="Download Excel">
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
                            <table  class="table table-bordered" data-sorting="true">
                                  <?php if(!empty($gtotal)){ ?>
                                   <thead>
                                       
                                       <th scope='col' colspan="10"></th>
                                       <th scope='col'>Total Amount : <?= number_format((float)$gtotal['total'], 2, '.', '');?></th>
                                       <th scope='col'>CGST : <?= number_format((float)$gtotal['cgst'], 2, '.', '');?></th>
                                       <th scope='col'>SGST : <?= number_format((float)$gtotal['sgst'], 2, '.', '');?></th>
                                       <th scope='col'>IGST : <?= number_format((float)$gtotal['igst'], 2, '.', '');?></th>
                                       <th scope='col'>Final Amount : <?= number_format((float)$gtotal['final_total'], 2, '.', '');?></th>                            
                                </thead>
                                <?php } ?>
                                <thead>
                                       <th scope='col'>Sr No</th>
                                       <th scope='col'>CN&nbsp;Date</th>
                                       <th scope='col'>Credit Note No</th>
                                       <th scope='col'>Customer ID</th>
                                       <th scope='col'>Customer Name</th>
                                       <th scope='col'>Customer GST No</th>
                                       <th scope='col'>Place of Supply</th>
                                       <th scope='col'>State Code</th>
                                       <th scope='col'>Ref Invoice No</th>
                                       <th scope='col'>Invoice Date</th>
                                       <th scope='col'>Amount</th>
                                       <th scope='col'>CGST</th>
                                       <th scope='col'>SGST</th>
                                       <th scope='col'>IGST</th>
                                       <th scope='col'>Amount Grand Total</th>                                      
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
                                                <td><?php echo date("d-m-Y",strtotime($value['createDtm'])); ?></td> 
                                                <td><a href="<?php base_url();?>admin/invoice-domestic-view-credit-note/<?php echo $value['id']; ?>" style="color:#2B9DE6;" target="_blank"><?php echo $value['credit_note_no']; ?></a></td>
                                                <td><?php echo $value['cid']; ?></td>
                                                <td><?php echo $value['customer_name']; ?></td>
                                                <td><?php echo $value['gstno']; ?></td>
                                                <td><?php echo $value['supply']; ?></td>
                                                <td><?php echo $value['statecode']; ?></td>
                                                <td><?php echo $value['in_no']; ?></td>
                                                <td><?php echo date('d-m-Y',strtotime($value['in_date'])); ?></td>
                                                <td><?php echo number_format((float)$value['sub_total'], 2, '.', ''); ?></td>
                                                <td><?php echo number_format((float)$value['cgst'], 2, '.', '');?></td>
                                                <td><?php echo number_format((float)$value['sgst'], 2, '.', '');?></td>
                                                <td><?php echo number_format((float)$value['igst'], 2, '.', ''); ?></td>
                                                <td><?php echo number_format((float)$value['grand_total'], 2, '.', '');?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                       ?>
                                       <tr><td colspan="15"> Data Not Found</td></tr>
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
<script src="assets/js/domestic_shipment.js"></script>
<!-- END: Body-->

