<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.input:focus {
    outline: outline: aliceblue !important;
    border:2px solid red !important;
    box-shadow: 2px #719ECE;
  }
  </style>
    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
 <!-- START: Card Data-->
 <main>
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card" style="margin: 0 25px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="">Franchise Cancel Shipment </h5>
                    </div>
                </div>
                <br><br>
                <hr>
                <?php if ($this->session->flashdata('notify') != '') { ?>
                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                <?php unset($_SESSION['class']);
                    unset($_SESSION['notify']);
                } ?>
           
             
                    <div class="table-responsive">
                        <table  id="example" class="display table  table-responsive table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>SR No</th>                               
                                <th>AWB.No</th>
                                <th>Franchise Code</th>
                                <th>Sender</th>
                                <th>Pincode	Receiver</th>
                                <th>Receiver City</th>
                                <th>Booking date</th>
                                <th>Mode</th>
                                <th>Pay Mode</th>
                                <th>Amount</th>
                                <th>Weight</th>
                                <th>NOP</th>
                                <th>Invoice No</th>
                                <th>Invoice Amount</th>
                                <th>Branch Name </th>
                                <th>Sender City</th>
                                <th>Eway No</th>
                                <th>Cancel Shipment Resion </th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                               
                                <?php if(!empty($shipment_list)){?>
                                <?php $count = 1; foreach( $shipment_list as $value ):?>
                                 <?php $dd = $this->db->query("SELECT branch_name FROM `tbl_branch` WHERE branch_id =".$value->branch_id)->row_array(); ?>
                                 <?php $dd1 = $this->db->query("SELECT * FROM `city` WHERE id =".$value->reciever_city)->row_array(); ?>
                                 <?php $dd2 = $this->db->query("SELECT * FROM `city` WHERE id =".$value->sender_city)->row_array(); ?>
                            <tr>
                                <td><?= $count++;?></td>
                                <td><?= $value->pod_no ;?></td>
                                <td><?php echo $this->db->query("select * from tbl_customers where customer_id = '$value->customer_id'")->row('cid');?></td>
                                <td><?= $value->sender_name ;?></td>
                                <td><?= $value->reciever_pincode ;?></td>
                                <td><?= $dd1['city'];?></td>
                                <td><?= $value->booking_date ;?></td>
                                <td><?= $value->mode_dispatch ;?></td>
                                <td><?= $value->dispatch_details ;?></td>
                                <td><?= $value->total_amount ;?></td>
                                <td><?= $value->actual_weight ;?> </td>
                                <td><?= $value->nop ;?></td>
                                <td><?= $value->invoice_no;?></td>
                                <td><?= $value->invoice_value;?></td>
                                <td><?= $dd['branch_name'];?></td>
                                <td><?= $dd2['city'] ;?></td>
                                <td><?= $value->eway_no ;?></td>
                                <td><?= $value->booking_cancel_reason ;?></td>
                                <?php if($value->booking_type == 0){?>
                               <td><button type="button"   class="btn btn-danger view_shipment btn-sm mt-1">Cancel</button></td>
                                <?php }?>
                              
                                </tr>
                                <?php endforeach; ?>
                                 <?php }else { ?> <tr><td>Data Not Found</td></tr> <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Card DATA-->
</div>
</main>
<?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>


