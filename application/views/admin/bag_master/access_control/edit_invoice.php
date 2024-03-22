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
                              <h4 class="card-title">View Invoice</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">                                           
                          <div class="col-12">
                               <form role="form" id="billing-form" name="billing-form" action="<?php echo base_url(); ?>admin/edit-invoice/<?php echo $id; ?>" method="post">                                          
                                  <div class="col-12">
                                   <div class="table-responsive">
                                  <table class="table">
                                    <tbody>
                                        <tr><td><input type="text" name="customer_name" value="<?php echo $customer->customer_name ?>" class="form-control"/>
                                           <textarea name="address" rows="3" class="form-control"/><?php echo $customer->address; ?></textarea>
                                                       <input type="text" name="city" value="<?php echo $customer->city ?>" class="form-control"/>

                                                       <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>" class="form-control"/>
                                                     </td>
                                                     <td>
                                                       <label for="invoice_date" class="col-form-label">Invoice Date</label><br>
                                                       <label for="invoice_date" class="col-form-label">Invoice Number</label><br>
                                                       <label for="invoice_date" class="col-form-label">GST No</label><br>
                                                       <label for="invoice_date" class="col-form-label">CID No</label>
                                                     </td>
                                                     <td>
                                                    <div class="col-sm-6">
                                                        <?php
                                                          $invoiceDate = $customer->invoice_date;
                                                          if(!$invoiceDate)
                                                          {
                                                            $invoiceDate = date('Y-m-d');
                                                          }
                                                        ?>
                                                    <input type="date" class="form-control" name="invoice_date" value="<?php echo $invoiceDate; ?>" />
                                                    <input type="text" class="form-control" name="invoice_number" value="<?php echo $customer->invoice_number; ?>" />
                                                     <input type="text" name="gstno" value="<?php echo $customer->gstno; ?>" class="form-control"/>
                                                      <input type="text" name="cid" value="<?php echo $customer->cid; ?>" class="form-control"/>
                                                    </div>
                                                  </td>

                                        </tr>
                                    </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-12">
                                   <div class="table-responsive">
                                   <table class="table layout-primary table-bordered">                                  
                                      <thead>
                                          <tr>  
                                              <th scope="col">NO.</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">AWB NO.</th>
                                              <th scope="col">Network</th>
											  <?php if($customer->export_import_type=='Export'){ ?>
												<th scope="col">CONSIGNEE</th>
												<th scope="col">DESTINATION</th>
											  <?php }else if($customer->export_import_type=='Import'){ ?>
												<th scope="col">CONSIGNER</th>
												<th scope="col">ORIGIN</th>											  
											  <?php } ?>
                                              <th scope="col">NO PCS</th>
                                              <th scope="col">WEIGHT</th> 
                                              <th scope="col">Freight</th>                                           
                                              <th scope="col">TransCh.</th>
                                              <th scope="col">DestCh.</th>
                                              <th scope="col">ClrCh.</th>
                                              <th scope="col">ESS</th>
                                              <th scope="col">Other</th>
                                               <th scope="col">Total</th>
                                              <th scope="col">Fuel</th>   
                                              <th scope="col">Sub Total</th>   
                                             <input type="hidden" name="total_booking" value="<?php echo count($allpoddata); ?>" class="total_booking" />
                                          </tr>
                                           </thead>
                                      <tbody>     
                                      <?php
                                          $amount = 0;
                                          $fuelSubCharges = 0;
                                          if(!empty($allpoddata)) {
                                          $i = 1;                                        
                                          foreach ($allpoddata as $value) { ?>
                                          <tr id="rowdata_<?php echo $i; ?>">
                                                <td style="width:25px;"><?php echo $i; ?></td>
                                                <td style="width:25px;"><input type="hidden" value="<?php echo $value['id']; ?>" class="form-control" id="invid_<?php echo $i; ?>" style="width:80px;"/>
                                                    <input type="text" value="<?php echo date('d-m-Y', strtotime($value['booking_date'])); ?>" id="invdate_<?php echo $i; ?>" class="form-control" / style="width:90px;"></td>

                                                <td style="width:25px;"><input type="text" id="pod_<?php echo $i; ?>" value="<?php echo $value['pod_no']; ?>" class="form-control"/ style="width:90px;"></td>
                                                <td style="width:25px;"><input type="text" id="forworder_name_<?php echo $i; ?>" value="<?php echo $value['forworder_name']; ?>" class="form-control"/ style="width:90px;"></td>
                                                <td style="width:25px;"><input type="text" id="reciever_name_<?php echo $i; ?>" value="<?php echo $value['reciever_name']; ?>" class="form-control"/></td>
                                                <td style="width:25px;">
                                                    <input type="text" id="reciever_country_<?php echo $i; ?>" value="<?php echo $value['reciever_country']; ?>" class="form-control"/>
                                                </td>
                                              
                                                <td style="width:25px;"><input type="text" id="no_of_pack_<?php echo $i; ?>" value="<?php echo $value['no_of_pack']; ?>" class="form-control" style="width:60px;"/></td>

                                                 <td style="width:25px;">
                                                    <input type="text" value="<?php echo $value['chargable_weight']; ?>" class="form-control chargable_weight" id="chargable_weight<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"/>
                                                </td>
                                             <!--    <td style="width:25px;"><input type="text" value="<?php echo $value['rate']; ?>" class="form-control rate"/ id="rate_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td> -->
                                                
                                               <!--  <td style="width:25px;"><input type="text" value="<?php echo floatval($value['to_pay']); ?>" class="form-control to_pay" id="to_pay_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td> -->
                                                  <td style="width:25px;"><input type="text" value="<?php echo $value['frieht']; ?>" class="form-control frieht" id="frieht_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>

                                                <td style="width:25px;"><input type="text" value="<?php echo $value['transportation_charges']; ?>" class="form-control transportation_charges" id="transportation_charges<_?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>

                                                <td style="width:25px;"><input type="text" value="<?php echo $value['destination_charges']; ?>" class="form-control destination_charges" id="destination_charges_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>


                                                <td style="width:25px;"><input type="text" value="<?php echo floatval($value['clearance_charges']); ?>" class="form-control clearance_charges" id="clearance_charges_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>


                                                <td style="width:25px;"><input type="text" value="<?php echo $value['ecs']; ?>" class="form-control ecs" id="ecs_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>

                                               <td style="width:25px;"><input type="text" value="<?php echo floatval($value['other_charges']); ?>" class="form-control other_charges" id="other_charges_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>    

                                               <td style="width:25px;"><input type="text" value="<?php echo floatval($value['amount']); ?>" class="form-control amount" id="amount_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>                                              
                                              
                                                <td style="width:25px;"><input type="text" value="<?php echo $value['fuel_subcharges']; ?>" class="form-control fuel" id="fuel_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:60px;"></td>

                                               <td style="text-align: right;width:25px"><input value="<?php echo floatval($value['sub_total']); ?>" class="form-control sub_total" id="sub_total_<?php echo $i; ?>" data-attr="<?php echo $i; ?>" style="width:80px;"/></td>
                                            </tr>

                                         <?php 
                                            $i++;
                                        }
                                    }
                                    ?>
                                    <!-- <tr><?php //echo str_repeat("<td></td>", 16);  ?></tr> -->
                                    <!--<tr><?php echo str_repeat("<td></td>", 14);  ?>                                      -->
                                    <!--    <td colspan="1">Bill Amount</td>-->
                                    <!--    <td style="text-align: right"><input type="text" name="total_amount" value="<?php echo $customer->total_amount; ?>" class="form-control allTotal"/></td>-->
                                    <!--</tr>-->
                                    <!-- <tr><?php echo str_repeat("<td></td>", 14);  ?>                                      -->
                                    <!--    <td colspan="1">Total Fuel Surcharges</td>-->
                                    <!--    <td style="text-align: right"><input type="text" name="fuel_subcharges" value="<?php echo $customer->fuel_subcharges; ?>" class="form-control allTotal"/></td>-->
                                    <!--</tr>-->
                                    <tr><?php echo str_repeat("<td></td>", 14);  ?> 
                                        <td colspan="2">Sub Total</td>                                        
                                        <td style="text-align: right"><input type="text" name="sub_total" value="<?php echo $customer->sub_total; ?>" class="form-control sub_total"/></td>
                                    </tr>
                                    <tr>
                                        <?php echo str_repeat("<td></td>", 14);  ?>  
                                        <td colspan="2">CGST <?php echo $gstCharges[0]['value']; ?>%</td>
                                        <td style="text-align: right">
                                            <?php $cgst =$customer->cgst_amount; ?>
                                            <input type="text" name="cgst" value="<?php echo $cgst; ?>" class="form-control cgst"  />
                                        </td>
                                    </tr>
                                    <tr>
                                       <?php echo str_repeat("<td></td>", 14);  ?>  
                                        <td colspan="2">SGST <?php echo $gstCharges[2]['value']; ?>%</td>
                                        <td style="text-align: right">
                                            <?php  $sgst =   $customer->sgst_amount;  ?>
                                            <input type="text" name="sgst" value="<?php echo $sgst; ?>" class="form-control sgst" /></td>
                                    </tr>
                                    <tr>
                                        <?php echo str_repeat("<td></td>", 14);  ?>  
                                        <td colspan="2">IGST <?php echo $gstCharges[1]['value']; ?>%</td>
                                        <td><?php  $igst =   $customer->igst_amount;   ?>
                                        <input type="text" name="igst" value="<?php echo $igst; ?>" class="form-control igst" /></td>
                                    </tr>
                                    <tr>
                                       <?php echo str_repeat("<td></td>", 14);  ?>  
                                        <td colspan="2">Total Amount</td>
                                        <td>
                                        
                                        <input type="text" name="grand_total" value="<?php echo round($customer->grand_total); ?>" class="form-control roundtotal"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="19">
                                            <button type="submit" class="btn btn-sm btn-primary">Save Invoice</button>
                                            <button type="submit" name="final_invoice" value="1" class="btn btn-sm btn-primary">Save Final Invoice</button>    
                                        </td>
                                    </tr>    

                                    </tbody>
                              </table> 
                          </div>
                        </div>
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
         //include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
