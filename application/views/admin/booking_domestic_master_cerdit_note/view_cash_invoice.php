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
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
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
                      <div class="col-12 col-sm-12 mt-5">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">
                              <h4 class="card-title">Cash Invoice List</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Branch</th>
                                              <th scope="col">Invoice No</th>                                     
                                              <th scope="col">Invoice Date</th>
                                              <th scope="col">Invoice Amount</th>
                                              <th scope="col">Customer</th>
                                              <!-- <th scope="col">Contact Number</th> -->
                                              <th scope="col">GSTNo</th>
                                              <th scope="col">CGST</th>
                                              <th scope="col">SGST</th>
                                              <th scope="col">IGST</th>
                                              <th scope="col">Total</th>
                                              <th scope="col">Grand Total</th>
                                              <th>Created By</th>
                                              <th>Status</th>
                                              <th>Approved By/Date</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                        <?php
                                        if (!empty($allpoddata)) {
                                          $cnt=0;
                                            foreach ($allpoddata as $value) {
                                              $cnt++;
                                                ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $value['branch_name']; ?></td>
                                                <td><?php echo $value['invoice_no']; ?></td>
                                                <td><?php if($value['invoice_date']!=""){ echo date("d-m-Y",strtotime($value['invoice_date']) ); } ?></td>
                                                <td><?php echo $value['total_amount']; ?></td>
                                                <td><?php echo $value['customer_name']; ?></td>
                                                
                                                <td><?php echo $value['gstno']; ?></td>
                                                <td><?php echo $value['cgst_amount']; ?></td>
                                                <td><?php echo $value['sgst_amount']; ?></td>
                                                <td><?php echo $value['igst_amount']; ?></td>
                                                <td><?php echo $value['total_amount']; ?></td>
                                                <td><?php echo $value['grand_total']; ?></td>
                                                <td><?php echo $value['created_by']; ?></td>
                                                <td><?= ($value['approve_status'] == 1)?'APPROVED':""; ?></td>
                                                <td><?= (!empty($value['approved_by']))?$value['approved_by'].'<br/>'.date('d-m-Y', strtotime($value['approveDtm'])):''; ?></td>
                                                <td>
                                                  <?php if($this->session->userdata('userType') == 1 || $this->session->userdata('userType') == 10){ ?>
                                                  <a href="<?php base_url();?>admin/show-edit-domestic-cash-invoice/<?php echo $value['id']; ?>/<?php echo $value['customer_id']; ?>" ><i class="ion-edit" style="color:var(--primarycolor);"></i></a> |
                                                  <?php } ?>
                                                  <a title="View" href="<?php base_url();?>admin/cash-invoice-domestic-view/<?php echo $value['id'];?>/<?php echo $value['company_id'];?>" class=""><i class="icon-eye"></i></a>
                                                  <a title="Download" href="<?php base_url();?>assets/invoice/domestic/<?php echo "01232404_". $value['inc_num'] . '.pdf'; ?>"   download="<?php echo "01232404_".$value['inc_num'] . '.pdf'; ?>" class=""><i class="ion-arrow-down-c"></i></a> 
                                                  <!-- <a href="javascript:void(0)" relid = "<?php echo  $value['id']; ?>"  title="Delete" class="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a> -->
                                                </td>
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
