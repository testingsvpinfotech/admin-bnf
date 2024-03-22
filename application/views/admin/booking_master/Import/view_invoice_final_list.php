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
                              <h4 class="card-title">View Invoice List</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Invoice Number</th>
                                              <th scope="col">Invoice Date</th>
                                              <th scope="col">Name</th>
                                              <th scope="col">City</th>
                                              <th scope="col">GSTNo</th>
                                              <th scope="col">CID</th>
											  <th scope="col">Type</th>
                                              <th scope="col">Total</th>
                                              <th scope="col" style="width: 30%;">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>    
                                        <?php
                                        $cnt=0;										
                                        if (!empty($allpoddata)) {
                                            foreach ($allpoddata as $value) {
                                                $cnt++;
                                                 $where =array('id'=>1);
                            		             $data['company_details'] = $this->basic_operation_m->get_table_row('tbl_company',$where);
                            		             $invoice_series = $data['company_details']->international_invoice_series;
                                                ?>
                                            <tr <?php if($value['send_mail_status']=='1'){ ?> style="color:blue" <?php } ?>>    
                                                <td><?php echo $value['inc_num']; ?></td>
                                                <td><?php echo $value['invoice_number']; ?></td>
                                                <td><?php if($value['invoice_date']!=""){ echo date("d-m-Y",strtotime($value['invoice_date']) ); } ?></td>
                                                <td><?php echo $value['customer_name']; ?></td>
												<td><?php echo $value['city']; ?></td>
                                                <td><?php echo $value['gstno']; ?></td>
                                                <td><?php echo $value['cid']; ?></td>
												<td><?php echo $value['export_import_type']; ?></td>
                                                <td><?php echo $value['grand_total']; ?></td>
                                                <td>
                         
                                <a title="Edit" href="<?php base_url();?> admin/show-edit-final-invoice-import/<?php echo $value['id'];?>/<?php echo $value['customer_id'];?>" class="btn btn-primary"><i class="icon-pencil"></i></a>
                                  |
                                  <a title="View" href="<?php base_url();?>admin/invoice-view-import/<?php echo $value['id'];?>/<?php echo $value['company_id'];?>" class="btn btn-success"><i class="icon-eye"></i></a>
                                  |
                                  <a title="Download" href="<?php base_url();?>assets/invoice/international_import/<?php echo $prefix;?>_<?php echo $value['id'];?>.pdf" download="<?php echo $prefix."_".$value['id'].'.pdf'; ?>" class="btn btn-warning"><i class="ion-arrow-down-c"></i></a>
                                  |
                                  <a title="Print" target="_blank" href="<?php base_url();?>admin/invoice-pdf-import/<?php echo $value['id'];?>/<?php echo $value['company_id'];?>" class="btn btn-dark"><i class="ion-printer"></i></a>
                                   |
                                  <a title="Download Excel" href="<?php base_url(); ?>admin/international_excel_import/<?php echo $value['id'];?>/<?php echo $value['company_id'];?>" class="btn btn-success"><i class="ion-ios-grid-view"></i></a>

                                    | 
                                 <a title="Send Mail" href="<?php echo base_url('admin/send-international-import-invoice-mail/' . $value['id'] . '/' . $value['customer_id']); ?>" onclick="return confirm('Are you sure you want to Send Mail?');" class="btn btn-sm btn-primary"><i class="ion-email"></i></a> 
                        

<!--commemntedddddddddddddd -->
                        
                                      <!-- <a href="<?php echo base_url('booking/invoice_view/'.$value['id']); ?>" class="btn btn-sm btn-primary">View</a>
                              <a href="<?php echo base_url('uploads/invoice/'.$prefix . $value['id'] . '.pdf'); ?>" download="<?php echo $prefix . $value['id'] . '.pdf'; ?>" class="btn btn-sm btn-primary">Download</a>

                                      <a href="<?php echo base_url('uploads/invoice/'.$prefix . $value['id'] . '.pdf'); ?>" class="btn btn-sm btn-primary">Print</a>

                                      <a href="<?php echo base_url('booking/excel/' . $value['id']); ?>" class="btn btn-sm btn-primary">Download Excel</a> -->
                                     <!-- <a href="<?php echo base_url('booking/send_mail/' . $value['id'] . '/' . $value['customer_id']); ?>" class="btn btn-sm btn-primary">Send Mail</a> -->
                                            </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo str_repeat("<td></td>",10);
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

