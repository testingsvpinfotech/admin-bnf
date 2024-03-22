 <!--Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

 <!--Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<style type="text/css">
  .table{margin-bottom: 0rem!important;}
  .table:not(.table-dark) td, .table:not(.table-dark) th {
    padding-bottom: 0em!important;
    /*padding-top: 0em!important;*/
  }
  address {
    margin-bottom: 0rem!important;
  }
.card .card-body {
  font-size: 13px;
  font-weight: bold;
}
tr.border-bottom td {
        border-bottom: 2px solid black!important;
      }
address{font-size: 13px;}




.viewInoviceHeader th {  text-align: left; }
.viewInoviceHeader td,.viewInoviceHeader th{ height: 25px;  font-family: Arial, Helvetica, sans-serif;  font-size:10px;  }
.viewInoviceHeader {border-collapse: collapse;  width: 100%;}
.left{ float:left; padding-top: 6px; padding-left: 25px; }
.headingf{ margin:0 auto; text-align: center; }
table.table.table-borderless { padding: 5px !important; margin-bottom: 10px !important;}
table.table.table-borderless td { border: inherit !important;padding: 0px 10px;}
tr.border-bottom td { border-bottom: 0px solid black!important;}
.border-bottom{ border-bottom: 1px solid #000!important; border-radius: 0px;}
.card .card-body {  padding: 0px;   border: 1px solid #000;}
tr.border-bottom td.extra-border {
    border-right: 1px solid;
}


    

.card-body.table-responsive.new-design {
    padding: 15px 0px;
    margin-top: 20px;
    border: 1px solid var(--bordercolor);
    border-radius: 0px;
    border-color: #000;
}
.table-bordered td, .table-bordered th, .table td, .table th {
    border: 0px solid #dee2e6;
}

.viewInoviceHeader td, .viewInoviceHeader th {
    border: 0px solid black;}

.border {
    border: 0px solid #dee2e6!important;
}
.table:not(.table-dark) td{ padding: 0em 10px; }
  .card .card-body {
    font-size: 10px;
    font-weight: normal;
}         

b, strong {
    font-weight: bold;
}        

body{ color:#000!important; }
   
   .card-body.table-responsive.new-design {
    width: 100%;
    border: 1px solid #000;
}  

.card-body.table-responsive.new-design tr.border-bottom {
    border-bottom: 1px solid #000 !important;
    width: 100%;
    box-shadow: -1px 1px 1px rgb(0 0 0);
    text-align:center;
}
.card-body.table-responsive.new-design table.table {
    width: 100%;
}

td.extra-border p {
    padding: 0px !important;
    margin: 0px;
}

.card-body.table-responsive {
    border: 1px solid #000;
}

.extra-border{
    border:1px solid #333;
}
            
        </style>
    <!-- START: Body-->
    <body id="main-container" class="default" style="border:1px solid #000;padding: 15px;border-top:none;margin-top: -15px;">
    <div class="main-div">
        
        <div class="col-12 col-lg-12">
                             <div class="row">
                                 <div class="col-12 col-md-12">
                                     <div class="card border-0 border-top1px">
                                       
                                         <div class="card-body table-responsive">
                                             <table class="table">
                                                 <tbody>
                                                     <tr>
                                                         <td style="padding: 10px;">
                                                           <strong style="font-size: 25px;"> <?php echo $company_details->company_name;?> </strong><br>
                                                                 <p style="width: 50%;" class="fontm"><?php echo $company_details->address;?></p> 
                                                             <p style="font-size: 14px;color: black;">  
                                                             <b>Telephone:</b><?php echo $company_details->phone_no;?><br>
                                                             <b>E-Mail:</b><?php echo $company_details->email;?><br>                       
                                                             <b>Web Site:</b> www.omcourier.net<br></p>
                                                           </td>
                                                         <td style="padding: 10px;"><img class="logo-css" src="<?php echo base_url();?>./assets/company/<?php echo $company_details->logo; ?>" alt="" style="height: 155px;width: 225px;">
                                                         </td>
                                                     </tr>
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                <div class="col-12 col-md-12">
                                     <div class="card border-0">
                                   
                                         <div class="card-body table-responsive">
                                             <table class="table">
                                                 <tbody>
                                                     <tr>
                                                         <td align="center">
                                                           <strong style="font-size: 20px;" >TAX INVOICE</strong><br>
                                                         </td>
                                                       
                                                     </tr>
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-12 col-md-12">
                                     <div class="card border-0">
                                         <div class="card-body table-responsive remove-bottom-border">
                                             <table class="viewInoviceHeader">
                                               
                                                 <tbody>
                                                     <tr>
                                                         <td style="padding: 10px;"><address style="font-size:10px; padding:15px;">To,<br>
                                                                 <b style="font-size:15px!important;"><?php echo $customer->customer_name; ?></b><br> <?php echo $customer->address; ?><br><b> Gst No : </b> <?php echo $customer->gstno; ?><br>
                                                                 <b>PLACE OF SUPPLY : </b><?php 
																	if($customer->export_import_type=="Export")
																	{
																		echo '97 OTHER TERRITORY';
																	}else{
																		
																		$whr_c =array('customer_id'=>$customer->customer_id);
                                                        $cust_details = $this->basic_operation_m->get_table_row('tbl_customers', $whr_c);
																	
																	  $whr_u =array('id'=>$cust_details->state);
                                                        $state_details = $this->basic_operation_m->get_table_row('state', $whr_u);
																	echo $state_details->state; } ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <b>State Code : </b><?php if($customer->export_import_type=="Export"){echo '27';}else{echo substr($cust_details->gstno, 0, 2);} ?>
																	 </address></td>
                                                         <td style="padding: 10px;"><address  style="font-size:10px; padding-right:15px;">
                                                                 <b>Invoice No:</b>  <?php
                                                                                 $invoiceNumebr = $customer->invoice_number;
                                                                                 if(!$customer->invoice_number)
                                                                                 {
                                                                                     $invoiceNumebr = 'OMCS/'.$year.'-'.($year+1).'/'.$customer->id;
                                                                                 }
                                                                                 echo $invoiceNumebr;
                                                                             ?>                        
                                                                             <br>
                                                             <b>Invoice Date:</b> <?php
                                                                             $invoiceDate = $customer->invoice_date;
                                                                             if(!$invoiceDate)
                                                                             {
                                                                                 $invoiceDate = date('Y-m-d');
                                                                             }
                                                                             echo date('d-m-y', strtotime($invoiceDate));
                                                                         ?><br>
                                                             <b>Invoice Period:</b> <?php
                                                                             $invoice_from_date = $customer->invoice_from_date;
                                                                             if(!$invoice_from_date)
                                                                             {
                                                                                 $invoice_from_date = '';
                                                                             }
                                                                             $fromDate = date('d-m-y', strtotime($invoice_from_date));
                                                                             
                                                                             $invoice_to_date = $customer->invoice_to_date;
                                                                             if(!$invoice_to_date)
                                                                             {
                                                                                 $invoice_to_date = '';
                                                                             }
                                                                             $toDate = date('d-m-y', strtotime($invoice_to_date));
                                                                             
                                                                             echo $fromDate.' - '.$toDate;
                                                                         ?>
                                                           </address></td>
                                                     </tr>
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-12 col-md-12">
                                     <div class="card border-full1">
                                         <div class="card-body border-right">
                                             <table class="table">
                                                 <thead>
                                                     <tr class="border-1px" >
                                                       
                                                          <th style="font-size:10px;padding: 10px;border-bottom:1px solid #333;">SR.</th>
                                                          <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;">DATE</th>
                                                          <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;">AWB NO</th>
                                                          
														   <?php if($customer->export_import_type=="Export"){?>
                                                             <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;">DESTINATION</th>
															 <?php }else if($customer->export_import_type=="Import"){ ?>
															 <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;">ORIGIN</th>
															 <?php } ?>
														  
                                                          <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;margin-right:3px;">NETWORK&nbsp; </th>
                                                          														  
														   <?php if($customer->export_import_type=="Export"){?>
                                                             <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;">CONSIGNEE</th>
															 <?php }else if($customer->export_import_type=="Import"){ ?>
															 <th  class="text-center" style="font-size:10px;border-bottom:1px solid #333;">CONSIGNER</th>
															 <?php } ?>
														  
                                                          <th class="text-center" style="font-size:10px;border-bottom:1px solid #333;">PROD</th>
                                                          <th style="font-size:10px;border-bottom:1px solid #333;">WEIGHT</td>
                                                          <th colspan="2" class="text-center" style="font-size:10px;border-bottom:1px solid #333;">AMOUNT</th>
                                                     </tr>
                                                     
                                                 </thead>
                                                 <tbody style="font-size: 10px;color: black;" >
                                                     <?php
                                                         $sub_total = 0;
                                                         $fuelSubCharges = 0;
														 $my_sub_total =0;
														 $cgst=0;
														 $sgst=0;
														 $igst=0;
                                                         $cnt=0;
                                                         if(!empty($allpoddata)) {
                                                             //echo count($allpoddata);
                                     // $i = 0;
                                 foreach ($allpoddata as $value) 
                                 { 
                                                              $cnt++;  ?>
                                                            <tr class="border-bottom" style="border-bottom:1px solid #333;">
                                                         <td class="text-center" style="font-size:10px; border-bottom:1px solid #333;"><?php echo $cnt;?></td>
                                                         <td class="text-center" style="font-size:10px;border-bottom:1px solid #333;"><?php echo date('d-m-Y', strtotime($value['booking_date'])); ?></td>
                                                         <td class="text-center" style="font-size:10px; width:70px;border-bottom:1px solid #333;"><?php echo $value['pod_no']; ?></td>
                                                         <td class="text-center" style="font-size:10px; width:85px;border-bottom:1px solid #333;"><?php echo $value['reciever_country']; ?></td>
                                                         <td class="text-center" style="font-size:10px;border-bottom:1px solid #333;"><?php echo $value['forworder_name']; ?></td>
                                                         <td style="font-size:10px;border-bottom:1px solid #333;"><?php echo $value['reciever_name']; ?></td>
                                                         <td class="text-center" style="font-size:10px; width:60px;border-bottom:1px solid #333;"><?php if($value['doc_type']==0){echo "D";}else{echo "ND";} ?></td>
                                                         <td class="text-center" style="font-size:10px;border-bottom:1px solid #333;"><?php echo $value['chargable_weight']; ?></td>
                                                         <td colspan="2" class="text-right" style="font-size:10px;border-bottom:1px solid #333;">                                        
                                                            <table  class="table table-borderless">
                         <!--                                       <tr class="nodata"><td colspan="20">&nbsp;</td></tr>-->
                         <!--<tr class="nodata"><td colspan="20">&nbsp;</td></tr>-->
                         <!--<tr class="nodata"><td colspan="20">&nbsp;</td></tr>-->
                         <!--<tr class="nodata"><td colspan="20">&nbsp;</td></tr>-->
                                                             <?php  if($value['frieht']!="" && $value['frieht']!="0"){
                                                              $my_sub_total = $my_sub_total + $value['frieht']; ?>
                                                               <tr><td style="font-size:10px;">Freight:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['frieht'], 2, '.', ''); ?></td></tr>
                                                             <?php  } ?>
                                                             <?php  if($value['transportation_charges']!="" && $value['transportation_charges']!="0"){ 
                                                             $my_sub_total = $my_sub_total + $value['transportation_charges']; ?>
                                                               <tr><td style="font-size:10px;">TransCh:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['transportation_charges'], 2, '.', ''); ?></td></tr>
                                                              <?php  } ?>
                                                               <?php  if($value['destination_charges']!="" && $value['destination_charges']!="0"){
                                                               $my_sub_total = $my_sub_total + $value['destination_charges'];
                                                               ?>
                                                               <tr><td style="font-size:10px;">DestCh:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['destination_charges'], 2, '.', ''); ?></td></tr>
                                                               <?php  } ?>
                                                                 <?php  if($value['clearance_charges']!="" && $value['clearance_charges']!="0"){
                                                                 $my_sub_total = $my_sub_total + $value['clearance_charges'];
                                                                 ?>
                                                               <tr><td style="font-size:10px;">ClrCh:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['clearance_charges'], 2, '.', ''); ?></td></tr>
                                                               <?php  } ?>
                                                                 <?php  if($value['ecs']!="" && $value['ecs']!="0"){
                                                                 $my_sub_total = $my_sub_total + $value['ecs']; ?>
                                                               <tr><td style="font-size:10px;">ESS:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['ecs'], 2, '.', ''); ?></td></tr>
                                                               <?php  } ?>
                                                                 <?php  if($value['fuel_subcharges']!="" && $value['fuel_subcharges']!="0"){ 
                                                                 $my_sub_total = $my_sub_total + $value['fuel_subcharges'];
                                                                 ?>
                                                               <tr><td style="font-size:10px;">Fuel:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['fuel_subcharges'], 2, '.', '');  ?></td></tr>
                                                               <?php  } 
                                                                 if($value['other_charges']!="" && $value['other_charges']!="0"){
                                                                 $my_sub_total = $my_sub_total + $value['other_charges']; ?>
                                                               <tr><td style="font-size:10px;">Other:</td><td style="padding-right: 5px;font-size:10px;"><?php echo number_format((float)$value['other_charges'], 2, '.', '');  ?></td></tr>
                                                               <?php  } 
                                                               
                                                               $sub_total = $sub_total + $value['sub_total'];
                                                               ?>
                         
                                                           </table>

                                                         </td>
                            </tr>
                            <?php
                            
                            $totalpods = count($allpoddata); 
                                     if($cnt >= $totalpods) 
                                     {
                                     
                                     $totalblankrows = 25 - $totalpods*3;
                                     for($i = 0; $i<=$totalblankrows; $i++)
                                     {
                                                               ?>
                         <tr class="nodata"><td colspan="20" style="font-size:10px;">&nbsp;</td></tr>
                         <?php
                                     }
                                     }
                            ?>

                         <?php } 
                       }?>
                         
                         <tr class="border-bottom">
                                                          <td colspan="4" class="extra-border" style="font-size:10px;padding: 10px; border:1px solid #333">
                                                             <b>UDYAM-MH-33-0076515</b><br>
                                                             <b>GST No : </b> <?php echo $company_details->gst_no; ?><br>
                                                             <b>PAN No. : </b> <?php echo $company_details->pan; ?><br>
                                                             <b>TAXABLE SERVICES : </b> COURIER AGENCY<br>
                                                             <b>SAC No. : </b> 996812<br>
                                                         </td>
                                                         <td colspan="4" class="extra-border" style="font-size:10px;padding: 10px;border:1px solid #333">
                                                           <b>BANK DETAILS: </b><br>
                                                           <?php echo $company_details->account_name; ?><br>
                                                           <?php echo $company_details->bank_name; ?>,<?php echo $company_details->branch_name; ?><br>
                                                             <b>A/C NO : </b> <?php echo $company_details->account_number; ?><br>
                                                             <b>IFSC : </b> <?php echo $company_details->ifsc; ?><br>
                                                             <b>MICR : </b> <?php echo $company_details->mrcs; ?><br>
                                                            </td>
                                                             <td colspan="1" class=" text-right" style="font-size: 10px;padding: 10px; width:100px; border-top:1px solid #333;border-right:1px solid #333;">
                                                                 
                                                                 <b>Sub Total</b><br>
                                                                    <b>CGST <?php echo $gstCharges->cgst; ?>%</b><br>
                                                                 <b>SGST <?php echo $gstCharges->sgst; ?>%</b><br>
                                                                 <b>IGST&nbsp;<?php echo $gstCharges->igst; ?>%</b><br>
                                                                 <b>Grand Total<br>(Rounded Off)</b></br>
                                                            </td>
                                                            <td class="text-right" style="font-size: 11px;border-top:1px solid #333; width:100px; padding-right:10px;">
                                                                     <div><?php echo $my_sub_total; ?></div></br>
                                                                     <div><?php $cgst =$customer->cgst_amount;echo round($cgst,2); ?></br></br></div>
                                                                     <div><?php $sgst =$customer->sgst_amount;echo round($sgst,2); ?></br></br></div>
                                                                     <div><?php echo $igst =$customer->igst_amount;?></br></div>
                                                          <?php                                                          
                                     $tototal_amount = $my_sub_total + $sgst + $cgst + $igst;
                                     ?>
                                     <?php echo round($tototal_amount, 0).".00"; ?>
                                                                     
                                                                     </td>
                                                     </tr>
                                                     <tr class="termcond">
                                                        <td colspan="13"  style="font-size: 10px;padding: 10px;border:1px solid #333">
                                                            <b>Amount in Words:	</b><?php echo ucwords(displaywords(round($tototal_amount, 0)));	?>
                                                            </b>
                                                        </td>
                                                     </tr>
                                                    
                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                 <div style="border:1px solid #333; float:left; width:100%; font-size:10px;">
                                        
                                        <div style="float:right;width:30%;padding: 10px;">
                                            <div>For Om Courier Services</div> <br/><br/><br/><br/><br/>
                                                
                                            <div>Authorized Sign</div>
                                        </div>
                                        <div style="float:left;width:60%;border-right: 1px solid #333;padding: 1px;">
                                            <?php echo $company_details->invoice_term_condition; ?>
                                        </div>
                                </div>
                                </div>
                             </div>
                         
                       
                     </div>
 </div>
    </body>
    <!-- END: Body-->
