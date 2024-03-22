<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
    .fade:not(.show) {
    opacity: 1;
}
</style>
<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <!-- END: Main Menu-->
    <style>
        .table.layout-primary tbody td:last-child {
            background-color: #ffffff;
            color: aliceblue;
        }
    </style>
    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">FTL Vendor List</h4>
                            </div>
                            
                            <div class="col-md-6">
                            <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  class="display table  table-striped table-bordered">
                                    <thead>
                                        <tr>                                           
                                                <th scope="col">Vcode</th>
                                                <th scope="col">Vendor Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Reference Person Name</th>
                                                <th scope="col">Mobile Number</th>
                                                <th scope="col">Alternate Phone Number</th>
                                                <th scope="col">Alternate Email </th>
                                                <th scope="col">Pincode</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Service Provider</th>
                                                <th scope="col">Credit Days</th>
                                                <th scope="col">Register Date</th>
                                                <th scope="col">Register Type</th>
                                                <th scope="col">Pan Number</th>
                                                <th scope="col">Gst Number</th>
                                                <th scope="col">Bank Name</th>
                                                <th scope="col">Account Number</th>
                                                <th scope="col">IFSC Code</th>
                                                <th scope="col">Pan Card Proof</th>
                                                <th scope="col">Cancel Cheque</th>
                                                <th scope="col">Address Proof</th>
                                                <th scope="col">Gst Proof</th>                                             
                                                <th scope="col">Status</th>                                             

                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php 
                                    if (!empty($ftl_customer_vendor)) {
                                              
                                        $cnt = 1; 
                                        foreach ($ftl_customer_vendor as  $ct) {  ?>
                                            <tr>
                                                <td><?php echo $ct->vcode; ?></td>
                                                <td><?php echo $ct->vendor_name; ?></td>
                                                <td><?php echo $ct->email; ?></td>
                                                <td><?php echo $ct->reference_person_name; ?></td>
                                                <td><?php echo $ct->mobile_no; ?></td>
                                                <td><?php echo $ct->alternate_phone_number; ?></td>
                                                <td><?php echo $ct->alternate_email; ?></td>
                                                <td><?php echo $ct->pincode; ?></td>
                                                <?php $origin_city = $ct->city; $dd5 = $this->db->query("select city from city where id = '$origin_city'")->row_array();?> 
                                                <td><?php echo $dd5['city']; ?></td>
                                                <?php $state = $ct->state; $dd6 = $this->db->query("select state from state where id = '$state'")->row_array();?> 
                                                <td><?php echo $dd6['state']; ?></td>
                                                <td><?php echo $ct->address; ?></td>
                                                <td><?php echo $ct->service_provider; ?></td>
                                                <td><?php echo $ct->credit_days; ?></td>
                                                <td><?php echo $ct->register_date; ?></td>
                                                <td><?php echo $ct->register_type; ?></td>
                                                <td><?php echo $ct->pan_number; ?></td>
                                                <td><?php echo $ct->gst_number; ?></td>
                                                <td><?php echo $ct->bank_name; ?></td>
                                                <td><?php echo $ct->acc_number; ?></td>
                                                <td><?php echo $ct->ifsc_code; ?></td>
                                                <td><a href="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->pan_card_proof; ?>"download><img src="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->pan_card_proof; ?>" style="width:100px; height:auto"></a></td>
                                                <td> <a href="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->cancel_cheque; ?>"download><img src="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->cancel_cheque; ?>" style="width:100px; height:auto"></a></td>
                                                <td><a href="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->address_proof; ?>"download><img src="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->address_proof; ?>" style="width:100px; height:auto"></a></td>
                                                <td><a href="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->gst_proof; ?>"download><img src="<?php echo base_url();?>/assets/ftl_documents/vendor_register_doc/<?php echo $ct->gst_proof; ?>" style="width:100px; height:auto"></a></td>

                                                <!-- <td><?php // echo $ct->payment_date; ?></td> -->
                                                <td>
                                               
                                                    <?php if($ct->status == '0'){?>
                                                      <button class = "btn btn-warning approve_status" relid ="<?php echo $ct->customer_id;?>">Pending</button>
                                                     <?php }elseif($ct->status == '1') {?>
                                                        <button class="btn btn-success">Approved</button>
                                                        <?php } elseif($ct->status == '2') { ?>
                                                            <button class="btn btn-danger">Rejected</button>
                                                         <?php }?>   
                                                </td>
                                            </tr>
                                    <?php
                                            $cnt++;
                                        }
                                    }
                                    ?>
                                    </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php  echo $this->pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END: Listing-->
        </div>
    </main>

    <div id="show_modal" class="modal fade" role="dialog" style="background: #000;">
              <div class="modal-dialog" style="margin-top: 137px;">
                <div class="modal-content">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <form action="<?php echo base_url(); ?>Admin_TraficManager/update_vendor_customer_stats" method="post">

                        <div class="modal-body">
                            
                            <h4 style="margin-top: 50px;text-align: center;">Are you sure, do you Want to Approve the Vendor?</h4>
                             <input type="hidden" class ="form-control" name ="customer_id" id ="customer_id"><br>
                             <input type="text" class ="form-control"  id ="vendor_name">

                        </div>
                    <div class="modal-footer">
                        <?php $approved = 1;
                         $cancel = 2; ?>

                    <input type="submit" name="approve" class="btn btn-success"  value = "Approve">
                    <input type="submit" name="reject" class="btn btn-danger"  value = "Reject">
                </div>
                </div>
                </form>
            </div>
            </div>


    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');?>

   
</body>
<script>
       $('.approve_status').click(function() {

           var id = $(this).attr('relid'); //get the attribute value
           // alert(id);

           $.ajax({
               url: "<?php echo base_url(); ?>Admin_TraficManager/get_id_vendor_customer",
               data: {
                   id: id
               },
               method: 'GET',
               dataType: 'json',
               success: function(response) {
                   // console.log(response);
                   $('#customer_id').val(response[0].customer_id); //hold the response in id and show on popup
                   $('#vendor_name').val(response[0].vendor_name);
                   $('#show_modal').modal({
                       backdrop: 'static',
                       keyboard: true,
                       show: true
                   });
               }
           });
       });
   </script>
<!-- END: Body-->