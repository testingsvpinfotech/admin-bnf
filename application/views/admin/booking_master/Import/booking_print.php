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
.viewInoviceHeader td,.viewInoviceHeader th{ height: 25px;  font-family: Arial, Helvetica, sans-serif;  font-size:12px;  }
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
    font-size: 12px;
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
            
        </style>
    <!-- START: Body-->
    <body id="main-container" class="default" style="border:1px solid #000;padding: 15px;border-top:none;margin-top: -15px;">
        
         <main>
           <div class="col-12 col-lg-12 mt-3 pl-lg-0">
                        <div class="card border h-100 invoice-list-section">
           <div class=""><!-- view-invoice -->
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="card border-0">
                                            <!-- <div class="card-header d-flex justify-content-between align-items-center">                               
                                               <h4 class="card-title">TAX INVOICE <span class="inv-no"></span></h4>                               
                                            </div> -->
                                            <div class="card-body table-responsive">
                                                <table class="table table-borderless border-1px">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 10px;"><address>
                                                              <strong style="font-size: 35px;"> <?php echo $company_details->company_name;?> </strong><br>
                                                                    <p style="width: 50%;"><?php echo $company_details->address;?></p> 
                                                                </address>
                                                                <b>Telephone:</b><?php echo $company_details->phone_no;?><br>
                                                                <b>E-Mail:</b><?php echo $company_details->email;?><br>                       
                                                                <b>Web Site:</b> <a href="www.omcourier.net">www.omcourier.net</a><br>
                                                              </td>
                                                            <td><img src="<?php echo base_url();?>/assets/company/<?php echo $company_details->logo; ?>" alt="" style="height: 155px;width: 225px;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="col-12 col-md-12">
                                        <div class="card border-0">
                                            <!-- <div class="card-header d-flex justify-content-between align-items-center">                               
                                               <h4 class="card-title">TAX INVOICE <span class="inv-no"></span></h4>                               
                                            </div> -->
                                            <div class="card-body table-responsive">
                                                <table class="table table-borderless">
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
                                            <div class="card-body table-responsive">
                                                <table class="viewInoviceHeader">
                                                   <!--  <thead>
                                                        <tr>
                                                            <td style="width: 50%;"><b>To</b></td>
                                                            <td style="width: 50%;"><b>Ship To (if different address)</b></td>
                                                        </tr>
                                                    </thead> -->
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding:10px;"><address>To,<br>
                                                                    <b style="font-size:15px!important;"><?php echo $customer->customer_name; ?></b><br> <?php echo $customer->address; ?><br><b> Gst No : </b> <?php echo $customer->gstno; ?><br>
                                                                    <b>PLACE OF SPPLY : </b><?php 
																	if($customer->export_import_type=="Export")
																	{
																		echo '97';
																	}else{
																		
																		$whr_c =array('customer_id'=>$customer->customer_id);
                                                        $cust_details = $this->basic_operation_m->get_table_row('tbl_customers', $whr_c);
																	
																	  $whr_u =array('id'=>$cust_details->state);
                                                        $state_details = $this->basic_operation_m->get_table_row('state', $whr_u);
																	echo $state_details->state; } ?> OTHER TERRITORY  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <b>State Code : </b>27</address></td>
                                                            <td><address>
                                                                    <b>Invoice No:</b>  <?php
                                                                                    $invoiceNumebr = $customer->invoice_number;
                                                                                    if(!$customer->invoice_number)
                                                                                    {
                                                                                        $invoiceNumebr = $invoice_series = $data['company_details']->international_invoice_series.'/'.$year.'-'.($year+1).'/'.$customer->id;
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
                                        <div class="card border-0">
                                            <div class="card-body table-responsive new-design">
                                                <table class="table">
                                                    <thead>
                                                        <tr class="border-bottom">
                                                             <td style="padding:10px;">SR NO</td>
                                                             <td class="text-center">DATE</td>
                                                             <td  class="text-center">AWB NO</td>
                                                              <?php if($customer->export_import_type=="Export"){?>
                                                             <th  class="text-center">DESTINATION</th>
															 <?php }else if($customer->export_import_type=="Import"){ ?>
															 <th  class="text-center">ORIGIN</th>
															 <?php } ?>
                                                             <td  class="text-center">NETWORK</td>
                                                              <?php if($customer->export_import_type=="Export"){?>
                                                             <th class="text-center">CONSIGNEE</th>
															  <?php }else if($customer->export_import_type=="Import"){ ?>
															  <th class="text-center">CONSIGNER</th>
															  <?php } ?>
                                                             <td class="text-center">PRODUCT</td>
                                                             <td>WEIGHT</td>
                                                             <td colspan="2" class="text-center">AMOUNT</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $amount = 0;
                                                            $fuelSubCharges = 0;
                                                            $cnt=0;
                                                            if(!empty($allpoddata)) {               
                                                            foreach ($allpoddata as $value) { 
                                                                 $cnt++;  ?>
                                                               <tr class="border-bottom">
                                                            <td class="text-center" style="width: 5%;"><?php echo $cnt;?></td>
                                                            <td class="text-center" style="width: 10%;"><?php echo date('d-m-Y', strtotime($value['booking_date'])); ?></td>
                                                            <td class="text-center"><?php echo $value['pod_no']; ?></td>
                                                            <td class="text-center"><?php echo $value['reciever_country']; ?></td>
                                                            <td class="text-center"><?php echo $value['forworder_name']; ?></td>
                                                            <td><?php echo $value['reciever_name']; ?></td>
                                                            <td class="text-center"><?php if($value['doc_type']==0){echo "D";}else{echo "ND";} ?></td>
                                                            <td class="text-center"><?php echo $value['chargable_weight']; ?></td>
                                                            <td colspan="2" class="text-right">                                        
                                                               <table  class="table table-borderless">
                                                                <?php  if($value['frieht']!="" && $value['frieht']!="0"){ ?>
                                                                  <tr><td>Frieht:</td><td><?php echo number_format((float)$value['frieht'], 2, '.', ''); ?></td></tr>
                                                                <?php  } ?>
                                                                <?php  if($value['transportation_charges']!="" && $value['transportation_charges']!="0"){ ?>
                                                                  <tr><td>TransCh:</td><td><?php echo number_format((float)$value['transportation_charges'], 2, '.', ''); ?></td></tr>
                                                                 <?php  } ?>
                                                                  <?php  if($value['destination_charges']!="" && $value['destination_charges']!="0"){ ?>
                                                                  <tr><td>DestCh:</td><td><?php echo number_format((float)$value['destination_charges'], 2, '.', ''); ?></td></tr>
                                                                  <?php  } ?>
                                                                    <?php  if($value['clearance_charges']!="" && $value['clearance_charges']!="0"){ ?>
                                                                  <tr><td>ClrCh:</td><td><?php echo number_format((float)$value['clearance_charges'], 2, '.', ''); ?></td></tr>
                                                                  <?php  } ?>
                                                                    <?php  if($value['ecs']!="" && $value['ecs']!="0"){ ?>
                                                                  <tr><td>ESS:</td><td><?php echo number_format((float)$value['ecs'], 2, '.', ''); ?></td></tr>
                                                                  <?php  } ?>
                                                                    <?php  if($value['fuel_subcharges']!="" && $value['fuel_subcharges']!="0"){ ?>
                                                                  <tr><td>Fuel:</td><td><?php echo number_format((float)$value['fuel_subcharges'], 2, '.', '');  ?></td></tr>
                                                                  <?php  } 
                                                                  
                                                                  $sub_total = $sub_total + $value['sub_total'];
                                                                  
                                                                  ?>

                                                              </table>
 
                                                            </td>
                               </tr>

                            <?php } 
                          }?>
                                                         <tr class="border-bottom">
                                                             <td colspan="4" class="extra-border">
                                                                UDYAM-MH-33-0076515<br>
                                                                <b>GST No : </b> <?php echo $company_details->gst_no; ?><br>
                                                                <b>PAN No. : </b> <?php echo $company_details->pan; ?><br>
                                                                <b>TAXABLE SERVICES : </b> COURIER AGENCY<br>
                                                                <b>SAC No. : </b> 996812<br>
                                                            </td>
                                                            <td colspan="4" class="extra-border">
                                                              BANK DETAILS: <br>
                                                              <?php echo $company_details->account_name; ?><br>
                                                              <?php echo $company_details->bank_name; ?>,<?php echo $company_details->branch_name; ?><br>
                                                                <b>A/C NO : </b> <?php echo $company_details->account_number; ?><br>
                                                                <b>IFSC : </b> <?php echo $company_details->ifsc; ?><br>
                                                                <b>MICR : </b> <?php echo $company_details->mrcs; ?><br>
                                                               </td>
                                                                <td colspan="1">
                                                                   <table class="table">
                                                                       <tbody>
                                                                    <tr>
                                                                        <td><b>SUB Total</b></td>
                                                                        <td><?php echo $sub_total; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>CGST <?php echo $gstCharges[0]['value']; ?>%</b></td>
                                                                        <td>0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>SGST <?php echo $gstCharges[2]['value']; ?>%</b></td>
                                                                        <td>0</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>IGST <?php echo $gstCharges[1]['value']; ?>%</b></td>
                                                                        <td><?php echo round(($sub_total * $gstCharges[1]['value'] )/100); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Grand Total<br>(Rounded Off)</b></td>
                                                                        <td><?php                                            
                                                                                     $tototal_amount = $sub_total + $sgst + $cgst + $igst;
                                                                                     echo round($tototal_amount, 0); ?></td>
                                                                    </tr>
                                                                    </tbody>
                                                                    </table>
                                                                  </td> 
                                                                  </tr>
                                                       
                                                        <tr class="termcond">
                                                                     <td colspan="13" >
                                                				         <b>Amount in Words:	</b><?php echo ucwords(displaywords(round($tototal_amount, 0)));	?>
                                                				    </td>
                                                		</tr>
                                                				
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="card redial-border-light redial-shadow">
                                            <div class="card-body table-responsive">
                                                <table class="table table-bordered  " style="width:100%">
                                                    <thead>
                                                        <tr class="border-bottom">
                                                            <td colspan='4' class="extra-border">
                                                             <?php echo $company_details->invoice_term_condition; ?>
                                                            </td>
                                                            <td>
                                                                For Om Courier Services<br><br><br><br>
                                                                
                                                                Authorized Sign
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
        </main>
    </body>
    <!-- END: Body-->
