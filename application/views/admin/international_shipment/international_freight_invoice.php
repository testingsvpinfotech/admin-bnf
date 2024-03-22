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
<div class="container-fluid site-width" >
  <!-- START: Listing-->
  <div class="row">                 
    <div class="col-12  align-self-center">
        <div class="col-12 col-sm-12 mt-3">
			<div class="card">
            <div class="card-header justify-content-between align-items-center">               
				<span style="float: right;">							
					<input type="button" onclick="printDiv('printableArea')" class="btn btn-info" value="print" />
				</span>
           </div>
			<div id="printableArea">
                 <div class="card-body" style="font-size: 19px;"> 
                            <div class="row">    
                                <div class="col-12"> 
                                      <center><strong style="font-size: 20px;" >TAX INVOICE</strong></center>
                                 </div>
                            </div>
                            <div class="row">                                           
                              <div class="col-12">
                                 <div class="card border-top1px table-responsive" style="margin-bottom:0px;">                                          
                                            <div class="card-body table-responsive">
                                                <table class="table" style="border:1px solid;margin-bottom: 0px;">
                                                    <tbody>
                                                        <tr style="border:1px solid;">                                                         
                                                            <td style="border-top:1px solid;">
                                                              <strong style="font-size: 35px;"> <?php echo $company_details->company_name;?> </strong><br>
																<p style="width: 50%;" class="fontm"><?php echo $company_details->address;?><br>
																	<b>GST No &nbsp;:&nbsp;</b><?php echo $company_details->gst_no;?><br>
																	<b>Telephone &nbsp;:&nbsp;</b><?php echo $company_details->phone_no;?><br>
																</p>
                                                              </td>
                                                               <td style="border-top:1px solid;"><img class="logo-css" src="<?php echo base_url();?>./assets/company/<?php echo $company_details->logo; ?>" alt="" style="height: 155px;width: 260px;">
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr style="border:1px solid;">                                                         
                                                            <td style="width: 63%;border:1px solid;">
                                                              <strong>Bill To</strong><br>
                                                                    <p  class="fontm"><?php echo $f_invoice_details->sender_name;?><br><?php echo $f_invoice_details->sender_address;?>
                                                                    <br><?php echo $f_invoice_details->sender_pincode;?>
                                                                    <br>GST IN:-<?php echo $f_invoice_details->sender_gstno;?>
                                                                </p>
                                                              </td>
                                                               <td style="border:1px solid;">
                                                                INVOICE NO &nbsp;: &nbsp;<?php echo $f_invoice_details->f_invoice_id;?><br>
                                                                INVOICE Date &nbsp;: &nbsp;<?php echo date("d-m-Y",strtotime($f_invoice_details->f_invoice_date));?><br>
                                                                SHIPMENT DATE &nbsp;: &nbsp;<?php echo date("d-m-Y",strtotime($f_invoice_details->f_shipment_date));?><br>
                                                                MAWB/MBL NO &nbsp;: &nbsp;<?php echo $f_invoice_details->mawb_no;?><br>
                                                                PORT OF ORIGIN &nbsp;: &nbsp;<?php echo $f_invoice_details->port_of_origin;?><br>
                                                                PORT OF DESTINATION &nbsp;: &nbsp;<?php echo $f_invoice_details->port_of_destination;?><br>
                                                                TOTAL WEIGHT &nbsp;: &nbsp;<?php echo $f_invoice_details->total_weight." Kg";?><br>
                                                                NO OF PACKAGES &nbsp;: &nbsp;<?php echo round($f_invoice_details->total_pcs);?><br>
                                                            </td>
                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                           <!-- </div>
                                        </div>
                              </div>
                            </div>
                            <div class="row">                                           
                              <div class="col-12"> 
                              <div class="table-responsive">-->
                                  <table style="width:100%;border:1px solid;">
                                       <thead>
                                          <tr>  
                                               <th style="border:1px solid;text-align: center;">SR.NO.</th>                                               
                                                <th style="border:1px solid;text-align: center;">PARTICULARS</th>
                                                <th style="border:1px solid;text-align: center;">HSN/SAC CODE</th>
                                                <th style="border:1px solid;text-align: center;">AMOUNT</th>
                                                <th style="border:1px solid;text-align: center;">CGST@9%</th>
                                                <th style="border:1px solid;text-align: center;">SGST@9%</th>                                              
                                                <th style="border:1px solid;text-align: center;">IGST@18%</th>                                             
                                          </tr>
                                      </thead>
                                      <tbody> 
										            <?php if(!empty($f_invoice_details)){
                                                        $heading=json_decode($f_invoice_details->heading);
                                                        $hsn_code=json_decode($f_invoice_details->hsn_code);
                                                        $amount=json_decode($f_invoice_details->amount);
                                                        $cgst=json_decode($f_invoice_details->cgst);
                                                        $sgst=json_decode($f_invoice_details->sgst);
                                                        $igst=json_decode($f_invoice_details->igst);
                                                        $cnt=0;
                                                    for($h=0;$h<count($heading);$h++)
                                                    { $cnt++;
                                                        ?>
                                                  <tr>           
                                                    <td style="border:1px solid;text-align: center;"><?php echo $cnt;?></td>
                                                    <td style="border:1px solid;text-align: center;"><?php echo $heading[$h];?></td>
                                                    <td style="border:1px solid;text-align: center;"><?php echo $hsn_code[$h];?></td>
                                                    <td style="border:1px solid;text-align: center;"><?php echo $amount[$h];?></td>
                                                    <td style="border:1px solid;text-align: center;"><?php echo $cgst[$h];?></td>
                                                    <td style="border:1px solid;text-align: center;"><?php echo $sgst[$h];?></td>
                                                    <td style="border:1px solid;text-align: center;"><?php echo $igst[$h];?></td>   
                                                  </tr>
                                              <?php                                                 
                                                }
          									 }

                             ?>
                              <tr>           
                                  <td style="border:1px solid;"></td>
                                  <td style="border:1px solid;"></td>
                                  <td style="border:1px solid;">SUB Total</td>        
                                  <td style="border:1px solid;text-align: center;"><?php echo $f_invoice_details->total_amount;?></td>
                                  <td style="border:1px solid;text-align: center;"><?php echo $f_invoice_details->total_cgst;?></td>
                                  <td style="border:1px solid;text-align: center;"><?php echo $f_invoice_details->total_sgst;?></td>
                                  <td style="border:1px solid;text-align: center;"><?php echo $f_invoice_details->total_igst;?></td>   
                                </tr>
                                <tr>           
                                  <td colspan="2" style="border:1px solid;">TOTAL AMOUNT</td>                  
                                  <td colspan="5" style="border:1px solid;"><?php echo $f_invoice_details->grand_total;?></td>
                                </tr>
                                 <tr>           
                                  <td colspan="2" style="border:1px solid;">CURRENCY</td>                  
                                  <td colspan="5" style="border:1px solid;">INR</td>
                                </tr>
                                 <tr>           
                                  <td colspan="2" style="border:1px solid;">IN FIGURES</td>                  
                                  <td colspan="5" style="border:1px solid;text-transform:capitalize;"><?php echo ucwords(displaywords(round($f_invoice_details->grand_total, 0)));    ?></td>
                              </tr>

                             <tr class="border-bottom">
                                 <td colspan="7" style="border:1px solid;">
                                    <b>NOTE:-</b><br>
1 .Payment should be made within 7 days after submission of bill in favor of Om Courier Services<br>
2 .All Disputes Subject to Thane Jurisdiction Only
<br><br>
Kindly revert back in writing or oral regarding any query pertaining to the invoice <br>
within 3 days from the date of receipt of the invoice, otherwise this invoice shall be <br>
deemed to be correct and payable by you.

                                </td>
                             
                              </tr>
                              <tr style="border:1px solid;">
                                 <td colspan="6">
                                    OM COURIER SERVICE<br>
BANK OF INDIA,<br>
PANCHPAKHADI BRANCH<br>
A/C NO-006820110000416<br>
IFSC:BKID0000068


                                </td>
                                <td>
                                  Authorised Signatory
<br><br><br><br><br>For OM COURIER SERVICE

                                </td>
                             
                              </tr>
          										</tbody>
          										</table>
                          </div>
                        </div>
                      </div>

				</div>
			</div> 
			
			
			</div> <!-- End card div-->

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
     <script type="text/javascript">  
       function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>  
    <!-- START: Footer-->
</body>
<!-- END: Body-->

