     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.form-control{
  		color:black!important;
  		border: 1px solid var(--sidebarcolor)!important;
  		height: 27px;
  		font-size: 10px;
  }
  .select2-container--default .select2-selection--single {
    background: lavender!important;
    }
    form .error {
	  color: #ff0000;
	}	
	input:focus {
  background-color: #ffff8f!important;
}
select:focus {
  background-color: #ffff8f!important;
}
textarea:focus {
  background-color: #ffff8f!important;
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
                              <h4 class="card-title">Search Invoice</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">                                           
                          <div class="col-12">
                              <form role="form" action="admin/show-payment-invoice-list" method="post" autocomplete="off">
                                  <div class="col-12">
                                    <div class="form-row">
                                            <div class="col-3 mb-3">
                                                <label for="username">Customer Name</label>
                                                <select class="form-control"  name="customer_account_id" id="customer_account_id">
                                                  <option value="">Select Customer</option>
                                                  <?php
                                                  if (count($customers)) {
                                                      foreach ($customers as $rows) {
                                                          ?>
                                                          <option <?php //echo ($customer_id == $rows['customer_id']) ? 'selected=""' : ''; ?> value="<?php echo $rows['customer_id']; ?>"><?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
                                                          </option>
                                                          <?php
                                                      }
                                                  } else {
                                                      echo "<p>No Data Found</p>";
                                                  }
                                                  ?>
                                              </select>
                                            </div>										 
                                            
                                            <div class="col-3 mb-3">
                                                 <input type="submit" name="submit" style="margin-top: 26px;" value="Search" class="btn btn-sm btn-primary">
                                             </div>
                                      </div>
                                 
                                  </div>
                                 </form>
                             <form role="form" action="admin/save-adjust-payments" method="post"  enctype="multipart/form-data">
                                  <div class="form-row">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
										<tr>
										<th colspan="2">Customer </th><th colspan="3"><?php if (!empty($inv_list)) {echo $inv_list[0]['customer_name'];} ?></th>
										<th colspan="2">Received Payment</th><th><input type="text" readonly name="total_received_payment" id="total_received_payment" value="<?php if(!empty($total_recivable_amt)){echo $total_recivable_amt->total_amount;} ?>" /></th>
										<th colspan="2">Pending Payment</th><th colspan="2"><input type="text" readonly name="total_pending_payment" id="total_pending_payment" /></th>
										</tr>
										<tr id="ref_row" style="display:none;">
											<th colspan="2">Ref Date</th>
											<th colspan="2"><input type="date" class="form-control" name="db_reference_date" id="db_reference_date" placeholder="Reference Date" readonly>
											</th>
											<th>Ref Amount</th>										
											<th colspan="2"><input type="number" step="0.01" class="form-control" name="db_reference_amount" id="db_reference_amount" placeholder="Reference Amount" readonly></th>
											<th colspan="2"><input type="number" step="0.01" class="form-control" name="db_aval_reference_amount" id="db_aval_reference_amount" placeholder="Reference Amount" readonly></th>
											<th colspan="6"></th>
										</tr>									
										<tr>
										<th colspan="12">
										<span id="error" class="error" ></span>
										</th>
										</tr>
											<tr>
												<th>SrNo</th>
												 <th scope="col">Invoice#</th> 
												 <th scope="col">Date</th>
												 <th scope="col">Ref No</th>   	 
												 <th scope="col">ReceiptAvalAmt</th>
												 <th scope="col">InvoiceAmt</th>												 
												 <th scope="col">ReceivedAmt</th>                        
												 <th scope="col">Discount</th>  
												 <th scope="col">BalanceAmt</th> 
												 <th scope="col">TDSAmt</th> 					 
												 <th scope="col">Final</th> 					 
												 <th scope="col">Action</th>                     
												  
											</tr>
										</thead>
										<tbody>
												<?php   
												$cnt=0;
												if (!empty($inv_list)) {
													foreach ($inv_list as $value) {
														
														$whr = array('customer_id'=>$value['customer_id'],'invoice_number'=>$value['invoice_number']);
														$applied_inv_list = $this->basic_operation_m->get_table_row('tbl_invoice_payments',$whr);														
														$cnt++;
														?>
													<tr id="tr_text_<?php echo $cnt; ?>" style="display:none;">	
														<td><?php echo $cnt; ?></td>
														<td>
															<input type="hidden" class="form-control" name="customer_id" readonly value="<?php echo $value['customer_id']; ?>">
															<input type="hidden" class="form-control" name="invoice_id[]" readonly value="<?php echo $value['id']; ?>">
															<!--<input type="text" class="form-control" name="edit_id[]" readonly value="<?php if(!empty($applied_inv_list)){echo $applied_inv_list->id;} ?>">-->
														    <input type="hidden" class="form-control" name="edit_invoice_number[]" readonly value="<?php if(!empty($applied_inv_list)){echo $applied_inv_list->invoice_number;} ?>">
															<input type="text" class="form-control" name="invoice_number[]" readonly value="<?php echo $value['invoice_number']; ?>">
														</td>
														<td>
															<input type="text" class="form-control" name="invoice_date[]" style="width: 90%;"  readonly value="<?php echo $value['invoice_date']; ?>">
														</td>
														<td style="width: 10%;">
															<select class="form-control" name="reference_no[]" onchange="return receipt_detail(<?php echo $cnt; ?>);" id="reference_no_<?php echo $cnt; ?>"  >
																<option value="">-Select-</option>
																<?php foreach($receipt_list AS $rval){ ?>
																<option value="<?php echo $rval['id'];?>" data-id="<?php echo $rval['reference_date'];?>" data-id1="<?php echo ($rval['amount_recieved']);?>" data-id2="<?php echo ($rval['available_amount']);?>"  ><?php echo $rval['entry_no'];?></option>
																<?php } ?>
															</select>
															<input type="hidden" class="form-control" name="reference_date[]" id="reference_date_<?php echo $cnt; ?>" placeholder="Reference Date" readonly>
															<input type="hidden" step="0.01" class="form-control" name="reference_amount[]" id="reference_amount_<?php echo $cnt; ?>" placeholder="Reference Amount" readonly>

														</td>														
														<td>
														<input type="number" step="0.01" class="form-control form-control-flat" id="available_amount_<?php echo $cnt; ?>" name="available_amount[]" placeholder="Amount Available">
														</td> 
														<td>
															<input type="number" step="0.01" class="form-control" name="invoice_amount[]" id="invoice_amount_<?php echo $cnt; ?>" readonly value="<?php if(!empty($applied_inv_list) && $applied_inv_list->balance_amt > 0 ){echo $applied_inv_list->balance_amt;}else{echo $value['grand_total'];} ?>">
															
														</td>	
														
														<td>														
														<input type="number" step="0.01" class="form-control form-control-flat" id="amount_recieved_<?php echo $cnt; ?>" name="amount_recieved[]" onblur="return balance_amt_cal(<?php echo $cnt; ?>);" placeholder="Amount Recieved">
														
														
														</td>
														<td><input type="number" step="0.01" class="form-control" name="discount[]" onblur="return balance_amt_cal(<?php echo $cnt; ?>);" value='0' id="discount_<?php echo $cnt; ?>" placeholder="Discount"></td>
																												
														<td><input type="number" class="form-control" name="balance_amt[]" min="0" max="<?php echo $value['grand_total']; ?>" step="0.01" id="balance_amt_<?php echo $cnt; ?>" placeholder="Balance Amount"></td>	
														
														<td><input type="number" step="0.01" class="form-control" name="tds_amt[]" onblur="return balance_amt_cal(<?php echo $cnt; ?>);" id="tds_amt_<?php echo $cnt; ?>" placeholder="TDS Amt"></td>
														
														<td><input type="number" step="0.01" class="form-control" name="final_received_amt[]"  id="final_received_amt_<?php echo $cnt; ?>" placeholder="Final Received Amt"></td>
														
														<td>
														<button type="submit" name="submit" id="submit" class="btn btn-primary editable-submit waves-effect waves-light"><i class="icon-check"></i></button>
														
														<!--<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Apply Payment">-->
														</td>												
													</tr>
													<tr id="tr_label_<?php echo $cnt; ?>">	
														<td><?php echo $cnt; ?>
														<a onclick="return show_row(<?php echo $cnt; ?>);" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a>
														</td>
														<td>
															<input type="hidden" class="form-control" name="customer_id" readonly value="<?php echo $value['customer_id']; ?>">
															<input type="hidden" class="form-control" name="invoice_id[]" readonly value="<?php echo $value['id']; ?>">
															<input type="hidden" class="form-control" name="edit_id[]" readonly value="<?php if(!empty($applied_inv_list)){echo $applied_inv_list->id;} ?>">
															<?php echo $value['invoice_number']; ?>
														</td>
														<td>
															<?php echo $value['invoice_date']; ?>
														</td>
														<td></td>
														<td></td>
														<td>
															<?php if(!empty($applied_inv_list) && $applied_inv_list->balance_amt > 0 ){echo $applied_inv_list->balance_amt;}else{echo $value['grand_total'];} ?>
														</td>	
														<td></td>
														<td></td>
														<td></td>
														<td></td>												
														<td></td>												
														<td></td>												
														<td></td>												
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
							 </form> 
							</div>
                    </div>
               
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
<script type="text/javascript">
  
  $('.datepicker').datepicker({
      format : 'dd/mm/yyyy' 
    });
	function show_row(id)
	{
console.log("============"+id);
		$("#tr_text_"+id).show();
		$("#tr_label_"+id).hide();
	}
  function receipt_detail(id){
	  var date =  $("#reference_no_"+id+" option:selected").attr('data-id');
	  var reference_amount =  $("#reference_no_"+id+" option:selected").attr('data-id1');
	  var available_amount =  $("#reference_no_"+id+" option:selected").attr('data-id2');
	 
	  $("#db_reference_date").val(date);	  
	  $("#db_reference_amount").val(reference_amount);
	  
	  $("#reference_date_"+id).val(date);
	  $("#reference_amount_"+id).val(reference_amount);
	  
	  $("#db_aval_reference_amount").val(available_amount);
	  $("#available_amount_"+id).val(available_amount);
	  $("#ref_row").show();
  }
  function balance_amt_cal(id){
	  var invoice_amount = parseFloat(($('#invoice_amount_'+id).val() != '') ? $('#invoice_amount_'+id).val() : 0);
	  var amount_recieved = parseFloat(($('#amount_recieved_'+id).val() != '') ? $('#amount_recieved_'+id).val() : 0);
	  var discount = parseFloat(($('#discount_'+id).val() != '') ? $('#discount_'+id).val() : 0);
	  var tds_amt = parseFloat(($('#tds_amt_'+id).val() != '') ? $('#tds_amt_'+id).val() : 0);
	 
	 var available_amount = parseFloat(($('#available_amount_'+id).val() != '') ? $('#available_amount_'+id).val() : 0);
	  var total_amt_received = amount_recieved + discount + tds_amt; //+ tds_amt;
	  var balance_amt = invoice_amount - (total_amt_received);
	  var final_received_amt = total_amt_received + tds_amt;
	 
	  var total_received_payment = parseFloat(($('#total_received_payment').val() != '') ? $('#total_received_payment').val() : 0);
	  var total_pending_payment = total_received_payment - total_amt_received ;
	  
	  if(total_amt_received > available_amount)
	  {
		  $msg="Please check received amount is greater than available amount";
		  $("#error").html($msg);
		  exit;
	  }else{
		  $msg="";
		  $("#error").html($msg);
	  }
	  $('#balance_amt_'+id).val(balance_amt.toFixed(2));
	  $('#final_received_amt_'+id).val(final_received_amt.toFixed(2));
	  $('#total_pending_payment').val(total_pending_payment.toFixed(2));
	 // alert(amount_recieved);
  }
  $(".check_all").click(function(){
      if($(this).prop('checked'))
      {
        $(".row_check").prop('checked', true);
      }
      else
      {
        $(".row_check").prop('checked', false);
      }
    });
	
	$("#customer_account_id").select2();
    
</script>