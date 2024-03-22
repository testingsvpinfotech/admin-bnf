     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
     <!-- END Head-->

     <!-- START: Body-->

     <body id="main-container" class="default">

       <!-- END: Main Menu-->
       <?php $this->load->view('admin/admin_shared/admin_sidebar');
        // include('admin_shared/admin_sidebar.php'); 
        ?>
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
                     <h4 class="card-title">Admin Edit Shipment</h4>
                   </div>
                   <div class="card-body">
                     <div class="row">
                       <div class="col-12">
                         <form role="form" action="<?php echo base_url(); ?>admin/admin-edit-view-list" method="post" autocomplete="off">
                           <div class="form-row">
                             <div class="col-md-2">
                               <input type="text" class="form-control" name="filter_value" value="<?php if(! empty($_POST['filter_value'])){ echo $_POST['filter_value']; } ?>"/>
                             </div>
                             <div class="col-md-2" style="display: none;">
                               <select class="form-control" name="filter">

                                 <option value="pod_no">Pod No</option>

                               </select>
                             </div>
                              <div class="col-sm-2">
                               <input type="submit" class="btn btn-primary" name="submit" value="Filter">
                               <a href="admin/admin-edit-view-list" class="btn btn-info">Reset</a>
                             </div>
                           </div>
                         </form>
                       </div>
                     </div>
                   </div>
                   <div class="card-body">
                     <div class="row">
                       <div class="col-12">
                         <!--<form role="form" action="<?php echo base_url(); ?>admin/list-booking" method="post" autocomplete="off">-->

                         <?php
                          $date = date('Y-m-d H:i');
                          $date = str_replace(' ', 'T', $date);
                          ?>
                         <div class="form-row">
                           <div class="row" id="div_transfer_rate" style="display:none;">


                           </div>
                         </div>
                         <!--//==============-->
                         <div class="card-body">
                           <div class="row">
                             <div class="col-12">
                               <div class="table-responsive">
                                 <table id="example1" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                   <thead>
                                     <tr>

                                       <th>AWB</th>
                                       <th>AWB date</th>
                                       <th>Type</th>
                                       <th>Sender Name</th>
                                       <th>Receiver Name</th>
                                       <th>Edit Shipment</th>
                                     </tr>
                                   </thead>
                                   <tbody>
                                    
                                     <?php
                                      if (!empty($domestic_booking)) {
                                        foreach ($domestic_booking as $value_d) {
                                          $customer_info        = $this->basic_operation_m->get_table_row('tbl_customers', array('customer_id' => $value_d['customer_id']));
                                          if (@$customer_info->access_status == 0) {
                                            $tracking_info  = $this->basic_operation_m->get_query_row("SELECT * FROM tbl_domestic_deliverysheet WHERE pod_no ='" . $value_d['pod_no'] . "'");

                                      ?>
                                           <tr>

                                             <td><?php echo $value_d['pod_no']; ?></td>
                                             <td><?php echo date('d/m/Y', strtotime($value_d['booking_date'])); ?></td>
                                             <td><input type="hidden" name="company_type[]" value="<?php echo $value_d['company_type']; ?>">
                                               <?php echo $value_d['company_type']; ?></td>
                                             <td><?php echo $value_d['sender_name']; ?></td>
                                             <td><?php echo $value_d['reciever_name']; ?></td>
                                             <td>
                                              
                                             <a href="<?= base_url('admin/admin-edit-domestic-shipment/'.$value_d['booking_id']); ?>">  <i class="ion-edit" style="color:var(--primarycolor)"></i></a></td>
                                           </tr>
                                       <?php
                                          }
                                        }
                                      } else {
                                        ?>
                                       <tr>
                                         <?php //echo str_repeat("<td></td>",12);
                                          ?>
                                       </tr>
                                     <?php
                                      }
                                      ?>
                                   </tbody>

                                 </table>
                               </div>
                               </div>
                               </form>
                             </div>
                             </form>
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
       <!-- END: Content-->
       <!-- START: Footer-->
       <?php $this->load->view('admin/admin_shared/admin_footer');
        //include('admin_shared/admin_footer.php'); 
        ?>
       <!-- START: Footer-->
     </body>
     <!-- END: Body-->
     <script type="text/javascript">
       $('.datepicker').datepicker({
         format: 'dd/mm/yyyy'
       });
       $(".check_all").click(function() {
         if ($(this).prop('checked')) {
           $(".row_check").prop('checked', true);
           show_div();
         } else {
           $(".row_check").prop('checked', false);
           hide_transfer_div();
         }
       });
       $(".row_check").click(function() {

         show_div();

       });


       function show_div() {
         // $("#transfer_customer_id").val(customer_id);

         $("#div_transfer_rate").show();
         return false;
       }

       function hide_transfer_div() {
         $("#div_transfer_rate").hide();
         return false;
       }
     </script>