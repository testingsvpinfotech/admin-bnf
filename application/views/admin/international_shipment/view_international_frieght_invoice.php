     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
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
                              <h4 class="card-title">Add Frieght Invoice</h4>  
                          </div>
                          <div class="card-body">
                          	 <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>                             
						   <div class="row">                                           
                            <div class="col-12">
								<form role="form" action="admin/insert-international-freight_invoice" method="post" enctype="multipart/form-data">
								<div class="form-group row">
									<label  class="col-sm-2 col-form-label">Invoice No</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="f_invoice_id" placeholder="Enter Id" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->f_invoice_id;}else{echo $fid;} ?>" >										
										<input type="hidden" class="form-control" name="edit_id" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->id;} ?>" >										
									</div>
									<label  class="col-sm-2 col-form-label">Invoice Date</label>
									<div class="col-sm-2">
										<input type="date" class="form-control" name="f_invoice_date" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->f_invoice_date;} ?>" required >
									</div>
									<label  class="col-sm-2 col-form-label">Shipment Date</label>
									<div class="col-sm-2">
										<input type="date" class="form-control" name="f_shipment_date" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->f_shipment_date;} ?>" required >
									</div>
									
								</div>
								<div class="form-group row">									
									<label  class="col-sm-2 col-form-label">MAWB/MBL NO</label>
									<div class="col-sm-2">
										<input type="text" name="mawb_no" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->mawb_no;} ?>" class="form-control" />
									</div>								
									<label  class="col-sm-2 col-form-label">Port Of Origin</label>
									<div class="col-sm-2">
										<input type="text" name="port_of_origin" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->port_of_origin;} ?>" class="form-control" />
									</div>
									<label  class="col-sm-2 col-form-label">Port Of Destination</label>
									<div class="col-sm-2">
										<input type="text" name="port_of_destination" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->port_of_destination;} ?>" class="form-control" />
									</div>
								</div>
								<div class="form-group row">
									<label  class="col-sm-2 col-form-label">Total Weight</label>
									<div class="col-sm-2">
										<input type="text" name="total_weight" id="total_weight" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->total_weight;} ?>" required class="form-control"/>
									</div>
									<label  class="col-sm-2 col-form-label">No of Packages</label>
									<div class="col-sm-2">
										<input type="text" name="total_pcs" id="total_pcs" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->total_pcs;} ?>" required class="form-control"/>
									</div>
								</div>
							<div class="card-header">                               
								<h4 class="card-title">Consigner Detail</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">                                           
                                                <div class="form-group row">
                                                    <label  class="col-sm-2 col-form-label">Customer</label>
													<div class="col-sm-2" id="credit_div">
													 <select class="form-control"  name="customer_account_id" id="customer_account_id">
														<option value="">Select Customer</option>
														<?php
															if (count($customers)) {
																foreach ($customers as $rows) {
																	?>
														<option value="<?php echo $rows['customer_id']; ?>" <?php  if(!empty($f_invoice_details)){if($f_invoice_details->customer_account_id==$rows['customer_id']){echo "selected";} } ?>>
															<?php echo $rows['customer_name']; ?>-<?php echo $rows['cid']; ?> 
														</option>
														<?php
																}
															}
															?>
													</select>
												</div>
												<label class="col-sm-2 col-form-label" id="credit_div_label">Name<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<input type="text" name="sender_name" readonly id="sender_name" value="<?php if(!empty($f_invoice_details)){ echo $f_invoice_details->sender_name;} ?>" class="form-control">
												</div>
												<label class="col-sm-2 col-form-label">Address</label>
												<div class="col-sm-2">
													<textarea name="sender_address" readonly id="sender_address" class="form-control"><?php if(!empty($f_invoice_details)){ echo $f_invoice_details->sender_address;} ?></textarea>		
												</div>
											</div>
											<div class="form-group row">												
												<label class="col-sm-2 col-form-label">Pincode<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<input type="text" name="sender_pincode" readonly id="sender_pincode" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->sender_pincode;} ?>" class="form-control">
												</div>
												<label class="col-sm-2 col-form-label">State<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<select class="form-control" id="sender_state" name="sender_state">
													<option value="">Select State</option>	
													<?php 
															if(count($states)) {
																foreach ($states as $st) {
																	?>
														<option value="<?php echo $st['id']; ?>" <?php if(!empty($f_invoice_details)){if($f_invoice_details->sender_state==$st['id']){echo "selected";}} ?>>
															<?php echo $st['state']; ?> 
														</option>
														<?php }
															} 
															?>
													</select>
												</div>
												<label class="col-sm-2 col-form-label">City<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<select class="form-control" id="sender_city" name="sender_city">
														<option value="">Select City</option>
														<?php
															if (count($cities)) {
																foreach ($cities as $rows) {
																	?>
														<option value="<?php echo $rows['id']; ?>" <?php if(!empty($f_invoice_details)){if($f_invoice_details->sender_city==$rows['id']){echo "selected";}} ?>>
															<?php echo $rows['city']; ?> 
														</option>
														<?php }
															}
															?>
													</select>
												</div>
											</div>											
											<div class="form-group row">
													<label class="col-sm-2 col-form-label">ContactNo.</label>
													<div class="col-sm-2">
													<input type="text" name="sender_contactno" readonly id="sender_contactno" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->sender_contactno; } ?>" class="form-control">
													</div>											
												<label class="col-sm-2 col-form-label">TypeOfDoc<span class="compulsory_fields">*</span></label>
													<div class="col-sm-2">
														<select name="type_of_doc" class="form-control">
															<option value="GSTIN" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="GSTIN"){echo "selected"; } } ?>>GSTIN</option>
															<option value="GSTIN(Govt.)" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="GSTIN(Govt.)"){echo "selected"; }} ?>>GSTIN(Govt.)</option>
															<option value="GSTIN(Diplomats)" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="GSTIN(Diplomats)"){echo "selected"; }} ?>>GSTIN(Diplomats)</option>
															<option value="PAN" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="PAN"){echo "selected"; } } ?>>PAN</option>
															<option value="TAN" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="TAN"){echo "selected"; }} ?>>TAN</option>
															<option value="Passport" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="Passport"){echo "selected"; }} ?>>Passport</option>
															<option value="Aadhaar" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="Aadhaar"){echo "selected"; }} ?>>Aadhaar</option>
															<option value="Voter Id" <?php if(!empty($f_invoice_details)){if($f_invoice_details->type_of_doc=="Voter Id"){echo "selected"; }} ?>>Voter Id</option>
															<option value="IEC" <?php if(!empty($f_invoice_details)){ if($f_invoice_details->type_of_doc=="IEC"){echo "selected"; }} ?>>IEC</option>
														</select>
													</div>
													<div class="col-sm-2">
														<input type="text" name="sender_gstno" readonly value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->sender_gstno;}?>" id="sender_gstno" class="form-control">
													</div>
											</div>

										</div>
									</div>	
								</div>
							</div>
							<div class="card-header" style="margin-top: -25px;">                               
                                <h6 class="card-title">Consignee Detail</h6>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">                                           
                                                <div class="form-group row">
                                                   <label class="col-sm-2 col-form-label">Name<span class="compulsory_fields">*</span></label>
													<div class="col-sm-2">
														<input type="text" name="reciever_name" id="reciever" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->reciever_name;}?>" class="form-control" required>
													</div>
													<label   class="col-sm-2 col-form-label">Company</label>
													<div class="col-sm-2">
														<input type="text" class="form-control" name="contactperson_name" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->contactperson_name;} ?>" />
													</div>
													<label class="col-sm-2 col-form-label">Address</label>
													<div class="col-sm-2">
														<textarea name="reciever_address" id="reciever_address" class="form-control"><?php if(!empty($f_invoice_details)){echo $f_invoice_details->reciever_address;} ?></textarea>	
													</div>
											</div>
											<div class="form-group row">
												 <label class="col-sm-2 col-form-label">City<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" name="reciever_city"  value="<?php if(!empty($f_invoice_details)){ echo $f_invoice_details->reciever_city;} ?>"  id="reciever_city"  />
												</div>
												<label class="col-sm-2 col-form-label">Zipcode<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" name="reciever_zipcode"  value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->reciever_zipcode;} ?>"  id="reciever_zipcode"  />
												</div>
												<label class="col-sm-2 col-form-label">Country<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<select class="form-control" id="reciever_country_id" name="reciever_country_id" class="reciever_country_id">														
														<option value="">Select Country</option>
														<?php foreach ($country_list as $cl) {
															?>
															<option value="<?php echo $cl['z_id'];?>" data-id="<?php echo $cl['z_id'];?>" <?php if(!empty($f_invoice_details)){if($f_invoice_details->reciever_country_id==$cl['z_id']){echo "selected";}} ?>><?php echo $cl['country_name'];?></option>

															<?php
														} ?>
													</select>													
													<input type="hidden" name="reciever_zone_id" id="reciever_zone_id" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->reciever_zone_id;} ?>">
												</div>
													
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">ContactNo.</label>
												<div class="col-sm-2">
													<input type="text" class="form-control" name="reciever_contact" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->reciever_contact;} ?>"/>
												</div>
												<label class="col-sm-2 col-form-label">Email Id<span class="compulsory_fields">*</span></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" name="reciever_email" id="reciever_email" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->reciever_email;} ?>"/>
												</div>								
											</div>  
										</div>
									</div>	
								</div>
							</div>
							<div class="form-group row">											
							<div class="col-md-12">
									<table class="table table-bordered table-striped weight-table">
										<thead>
										<tr>
											<th>PARTICULARS</th>
											<th>HSN/SAC CODE</th>											
											<th>AMOUNT</th>
											<th>CGST</th>	
											<th>SGST</th>	
											<th>IGST</th>											
										</tr>										
										</thead>
										<tbody class='tbody'>
											<?php if(!empty($f_invoice_details)){
												$heading=json_decode($f_invoice_details->heading);
												$hsn_code=json_decode($f_invoice_details->hsn_code);
												$amount=json_decode($f_invoice_details->amount);
												$cgst=json_decode($f_invoice_details->cgst);
												$sgst=json_decode($f_invoice_details->sgst);
												$igst=json_decode($f_invoice_details->igst);
												$cnt=0;
										for($h=0;$h<count($heading);$h++)
										{	$cnt++;
												?>
										<tr class="my_tr">
											<th><input type="text" name="heading[]" value="<?php echo $heading[$h];?>" id="heading<?php echo $cnt;?>" class="form-control heading"/></th>
											<td><input type="text" name="hsn_code[]" id="hsn_code<?php echo $cnt;?>" value="<?php echo $hsn_code[$h];?>" required class="form-control hsn_code"/></td>
											<td><input type="text" name="amount[]" id="amount<?php echo $cnt;?>" value="<?php echo $amount[$h];?>" required class="form-control amount"/></td>
											<td><input type="text" name="cgst[]" id="cgst<?php echo $cnt;?>" required value="<?php echo $cgst[$h];?>" class="form-control cgst"/></td>	
											<td><input type="text" name="sgst[]" id="sgst<?php echo $cnt;?>" required value="<?php echo $sgst[$h];?>" class="form-control sgst"/></td>
											<td><input type="text" name="igst[]" id="igst<?php echo $cnt;?>" required value="<?php echo $igst[$h];?>" class="form-control igst"/></td>
										</tr>
										<?php } ?>
												<?php	
											}else{ ?>
										<tr class="my_tr">
											<td><input type="text" name="heading[]" id="heading1" class="form-control heading"/></td>
											<td><input type="text" name="hsn_code[]" id="hsn_code1" required class="form-control hsn_code"/></td>
											<td><input type="text" name="amount[]" id="amount1" required class="form-control amount"/></td>
											<td><input type="text" name="cgst[]" id="cgst1" required class="form-control cgst"/></td>	
											<td><input type="text" name="sgst[]" id="sgst1" required class="form-control sgst"/></td>
											<td><input type="text" name="igst[]" id="igst1" required class="form-control igst"/></td>
										</tr>										
									<?php } ?>
										</tbody>

						<tfoot>
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary add-weight-row" style="margin-bottom: 5px;"><i class="icon-plus"></i></a>&nbsp;<a href="javascript:void(0)" class="btn btn-sm btn-danger remove-weight-row" style="margin-bottom: 5px;"><i class="icon-trash"></i></a>
                          </tfoot>		
                          				<tr>
											<th>Sub Total</th>
											<td>										
											<td><input type="text" readonly name="total_amount" id="total_amount" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->total_amount;} ?>" required class="form-control total_amount"/></td>
											<td><input type="text" readonly name="total_cgst" id="total_cgst" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->total_cgst;} ?>" required class="form-control total_cgst"/></td>	
											<td><input type="text" readonly name="total_sgst" id="total_sgst" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->total_sgst;} ?>" required class="form-control total_sgst"/></td>
											<td><input type="text" readonly name="total_igst" id="total_igst" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->total_igst;} ?>"  required class="form-control total_igst"/></td>
										</tr>
										<tr>
											<th colspan="5">Total</th>											
											<td><input type="text" readonly name="grand_total" id="grand_total" value="<?php if(!empty($f_invoice_details)){echo $f_invoice_details->grand_total;} ?>"   required class="form-control grand_total"/></td>											
										</tr>							
									</table> 
									<!--  box body-->
									</div>
								</div>
								<div class="col-md-3">
									<div class="box-footer pull right">
										<button type="submit" name="submit"  class="btn btn-primary">Submit</button>
									</div>
								</div>
							</form>
							</div>	
						</div>	
                      </div>
                      </div> 
					</div>
				</div>            
			</div>        <!-- END Row-->
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
$( document ).ready(function() {
   $(".add-weight-row").on('click', function () 
  {  	
    var cntRows = $(".hsn_code").length + 1;
    //console.log(cntRows);

      $('.my_tr:last').after('<tr class="my_tr"><td><input type="text" name="heading[]" id="heading'+cntRows+'" class="form-control heading"/></td><td><input type="text" name="hsn_code[]" id="hsn_code'+cntRows+'" required class="form-control hsn_code"/></td><td><input type="text" name="amount[]" id="amount'+cntRows+'" required class="form-control amount"/></td><td><input type="text" name="cgst[]" id="cgst'+cntRows+'" required class="form-control cgst"/></td><td><input type="text" name="sgst[]" id="sgst'+cntRows+'" required class="form-control sgst"/></td><td><input type="text" name="igst[]" id="igst'+cntRows+'" required class="form-control igst"/></td></tr>');

      calculateTotalWeight();

  });
    // this fucntion is use for removing the row from table 
  $(".remove-weight-row").on('click', function () 
  {
    var totalRow = $('table.weight-table tbody').find('tr').length;
    if (totalRow > 1) {
      $('table.weight-table tbody').find('tr:last').remove();
      totalRow--;

    }
    if (totalRow == 1) {
      $(this).hide();
    }
   
  });

});	

 
$(document).on('blur', ".hsn_code,.amount,.cgst,.sgst,.igst", function() 
{	
	calculateTotalWeight();
});
function calculateTotalWeight() 
{
		var cntRows = $(".amount").length
		//console.log("hhhhh=="+cntRows);	
		console.log(cntRows);
		var amount=0;
		var cgst=0;
		var sgst=0;
		var igst=0;
		for (var i = 1; i <= cntRows; i++) {
			//console.log('#amount'+i);
			var amount= parseFloat(amount) + parseFloat(($('#amount' + i).val() != '') ? $('#amount' + i).val() : 0);
			//console.log('amount='+amount);
			var cgst= parseFloat(cgst) + parseFloat(($('#cgst'+i).val() != '') ? $('#cgst'+i).val() : 0);
			var sgst= parseFloat(sgst) + parseFloat(($('#sgst'+i).val() != '') ? $('#sgst'+i).val() : 0);
			var igst= parseFloat(igst) + parseFloat(($('#igst'+i).val() != '') ? $('#igst'+i).val() : 0);
		}	

			var grand_total = (amount + cgst + sgst + igst);
			//alert(amount);
			$('#total_amount').val(amount);
			$('#total_cgst').val(cgst);
			$('#total_sgst').val(sgst);
			$('#total_igst').val(igst);

 			$('#grand_total').val(grand_total);

}
$("#customer_account_id").change(function () 
	{
		var customer_name = $(this).val();
		if (customer_name != null || customer_name != '') {
			$.ajax({
				type: 'POST',
				dataType: "json",
				url: 'Admin_international_shipment_manager/getsenderdetails',
				data: 'customer_name=' + customer_name,
				success: function (data) {
					$("#sender_name").val(data.user.customer_name);
					$("#sender_address").val(data.user.address);
					$("#sender_pincode").val(data.user.pincode);
					$("#sender_contactno").val(data.user.phone);
					$("#sender_gstno").val(data.user.gstno);
					$("#gst_charges").val(data.user.gst_charges);
					$("#sender_city").val(data.user.city);
					$("#sender_state").val(data.user.state);					
					$("#customer_account_id").val(customer_name);	
					 document.getElementById("reciever").focus();				
				}
			});
		}
	});
</script>

      