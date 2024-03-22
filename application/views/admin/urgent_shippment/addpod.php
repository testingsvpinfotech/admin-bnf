<?php include 'sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Shipment</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">Add Shipment</li>
        </ol>
    </section>
    <section class="content">
		
        <div class="row">
		 <?php if(!empty($success)) { ?> 
            <div class="alert alert-success">
              <strong>Success!</strong> <?php echo is_array($success) ? implode($success, '') : $success; ?>
            </div>
            <?php  $success = ''; } ?>
            
            <?php if(!empty($error)) { ?> 
            <div class="alert alert-warning">
              <strong>Warning!</strong> <?php echo is_array($error) ? implode($error, '') : $error; ?>
            </div>
            <?php  $error = ''; } ?>
            <form role="form" id="generatePOD" action="<?php echo base_url(); ?>generatepod/addpod" method="post">
                <input type ="hidden" name="rate" id="rate" />
                <input type ="hidden" name="rate_pack" id="rate_pack" />
                <input type="hidden" name="amount_manual" id="amount_manual" value="0" />
				<input type="hidden" name="gst_rate" id="gst_rate" />
				<input type="hidden" name="roundoff_type" id="roundoff_type" />
                <div class="col-md-8">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label>Type:<br></label><br/>
                                     <label>
                                         <input onchange="tgl(this.value)" type="radio" name="doc_type" id="doc_type" value="1">Non-Doc
                                     </label>
                                     <label>
                                         <input onchange="tgl(this.value)" type="radio" name="doc_type" id="doc_type" value="0" checked>Doc
							        </label>
							        </div>
							        <br>
                                    <label>Customer Name:</label>
                                    
                                    <div class="form-group">
                                    <select class="form-control"  name="customer_account_id" id="customer_account_id">
                                        <option value="">Select Customer</option>
                                        <?php
                                            if (count($customers)) {
                                                foreach ($customers as $rows) {
                                                    ?>
                                        <option value="<?php echo $rows['customer_id']; ?>">
                                            <?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
                                        </option>
                                        <?php
                                            }
                                            } else {
                                            echo "<p>No Data Found</p>";
                                            }
                                            ?>
                                    </select>
                                </div>
                                <h3 class="box-title">Consigner</h3>
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="sender_name" id="sender" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Address:</label>
                                    <input type="text" name="sender_address" id="sender_address" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>City:</label>
                                    <select class="form-control"  name="sender_city" id="sender_city" required>
                                        <option value="">Select City</option>
                                        <?php
                                            if (count($cities)) {
                                                foreach ($cities as $rows) {
                                                    ?>
                                        <option value="<?php echo $rows['id']; ?>">
                                            <?php echo $rows['city']; ?> 
                                        </option>
                                        <?php }
                                            } else {
                                            echo "<p>No Data Found</p>";
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pincode No.:</label>
                                    <input type="text" name="sender_pincode" id="sender_pincode" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Contact No.:</label>
                                    <input type="text" name="sender_contactno" id="sender_contactno" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Sender GST NO.:</label>
                                    <span><input type="text" name="sender_gstno" id="sender_gstno" class="form-control my-colorpicker1" readonly></span>
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label>INV No.:</label>-->
                                <!--    <input type="text" name="invoice_no" id="invoice_no" class="form-control my-colorpicker1">-->
                                <!--</div>-->
                            </div>
                            <!--col-md-6-->
                            <div class="col-md-6">
                                
                                
                                <div class="form-group">
                                         <br/>
                                    <label>Mode Of Dispatch:<br></label><br/>
                                <!--
                                <label>
                                    <input type="radio" name="mode_dispatch" class="mode_dispatch" value="air">Air
                                </label>
                                <label>
                                    <input type="radio" name="mode_dispatch" class="mode_dispatch" checked="checked" value="train">Train
                                </label>
                                <label>
                                    <input type="radio" name="mode_dispatch" class="mode_dispatch" value="surface">Surface
                                </label>
                                -->
                                <?php
                                
        										$CI =& get_instance();
        										$query = $CI->db->query('SELECT * FROM `transfer_mode`');
        										$mode_dispatch = 'Train';
        										?>			
        										<select class="mode_dispatch" name="mode_dispatch">
        										<?php										
        										foreach ($query->result() as $row)
        										{
        										    if($row->mode_name==$mode_dispatch)
        										    {
        										      echo "<option selected='selected' value='".$row->mode_name."'>".$row->mode_name."</option>";  
        										    }
        										    else
        										    {
        											echo "<option value='".$row->mode_name."'>".$row->mode_name."</option>";
        										    }
        										}
        	
        										?>
        										</select>
        										
							<script>
											function tgl(val) {
												var cont = document.getElementById('cont');
												var panel1 = document.getElementById('panel1');
												//alert(val);
												if (val==1) {
													cont.style.display = 'block';
													panel1.style.display = 'block';
												//	cons.style.display = 'none';
												}
												if(val==0) {
												    //alert('kk');
												    //cont.style.removeProperty("display");
													cont.style.display = 'none';
													panel1.style.display = 'none';
												//	cons.style.display = 'block';
												}
											}
										</script>
                                <br>
                                </div>
                        
                                <div class="form-group">
                                    <label>Airway No:</label>
                                    <input type="text" name="awn" id="awn" class="form-control my-colorpicker1" value="<?php echo $bid; ?>">
                                </div>
                                <h3 class="box-title">Consignee</h3>
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="reciever_name" id="reciever" class="form-control my-colorpicker1" required>
                                </div>
                                <div class="form-group">
                                    <label>Address:</label>
                                    <input type="text" name="reciever_address" id="reciever_address" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Pincode No.:</label>
                                    <input type="text" name="reciever_pincode" id="reciever_pincode" class="form-control my-colorpicker1 reciever_pincode">
                                </div>
                                <div class="form-group">
                                    <label>City:</label>
                                    <select class="form-control"  name="reciever_city" id="reciever_city" required>
                                        <option value="">Select City</option>
                                        <?php
                                            // foreach ($cities as $rows) {
                                                ?>
                                        <option value="<?php //echo $rows['id']; ?>">
                                            <?php //echo $rows['city']; ?> 
                                        </option>
                                        <?php
                                           // }
                                            ?>
                                    </select>
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label>Pincode No.:</label>-->
                                <!--    <input type="text" name="reciever_pincode" id="reciever_pincode" class="form-control my-colorpicker1 reciever_pincode">-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label>Contact No.:</label>
                                    <input type="text" name="reciever_contact" id="reciever_contactno" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Reciever GST NO.:</label>
                                    <input type="text" name="receiver_gstno" id="reciever_gstno" class="form-control my-colorpicker1">
                                </div>
                           </div>
                            <!--col-md-6-->
                            <div id="panel1" style="display:none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>INV No.:</label>
                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Inv. Value:</label>
                                    <input type="text" name="insurance_value" id="insurance_value" class="form-control my-colorpicker1">
                                </div>
                                <!--<div class="form-group">-->
                                <!--    <label>Eway No:</label>-->
                                <!--    <input type="text" name="eway_no" id="eway_no" class="form-control">-->
                                <!--</div>-->
                                <!--<div class="form-group">-->
                                <!--    <label>Ref No:</label>-->
                                <!--    <input type="text" name="ref_no" id="ref_no" class="form-control">-->
                                <!--</div>-->
                                <!--<div class="form-group">-->
                                <!--    <label>Contact Person Name:</label>-->
                                <!--    <input type="text" name="contactperson_name" id="contactperson_name" class="form-control">-->
                                <!--</div>-->
                            </div>
                            
                            <!--col-md-6-->
                            <div class="col-md-6">
                                <!--<div class="form-group">-->
                                <!--    <label>INV No.:</label>-->
                                <!--    <input type="text" name="invoice_no" id="invoice_no" class="form-control my-colorpicker1">-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label>Eway No:</label>
                                    <input type="text" name="eway_no" id="eway_no" class="form-control">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <!--<div class="form-group">-->
                                <!--    <label>Inv. Value:</label>-->
                                <!--    <input type="text" name="insurance_value" id="insurance_value" class="form-control my-colorpicker1">-->
                                <!--</div>-->
                                <div class="form-group">
                                    <label>Ref No:</label>
                                    <input type="text" name="ref_no" id="ref_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact Person Name:</label>
                                    <input type="text" name="contactperson_name" id="contactperson_name" class="form-control">
                                </div>
                            </div>
							<div class="col-md-12 text-center">
								<section style="border: 1px solid #e0e0e0;padding: 10px;">
									<strong>Measurement Units:</strong><div class="custom-control custom-radio custom-control-inline inline" >
									  <input type="radio" class="custom-control-input" id="length_unit1" name="length_unit" value="cm" checked="checked">
									  <label for="length_unit1">CM</label>
									</div>

									<div class="custom-control custom-radio custom-control-inline inline">
									  <input type="radio" class="custom-control-input" id="length_unit2" value="inch" name="length_unit">
									  <label  for="length_unit12">INCH</label>
									</div>
								</section>
							</div>
                            <div class="col-md-12">
                                <table class="weight-table" style="border-collapse: separate;border-spacing: 13px;">
                                    <thead>
                                        <tr>
                                            <th>PKT:</th>
                                            <th>Per Box Weight :</th>
                                            <th>Actual Weight:</th>
                                            <th>Chargeable Weight:</th>
                                            <th>Valumetric Weight</th>
                                            <th>L</th>
                                            <th>B</th>
                                            <th>H</th>
                                            <th>1CFT(kg)</th>
                                        </tr>
                                    <thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="no_pack_detail[]" class="form-control my-colorpicker1 no_of_pack"  data-attr="1" id="no_of_pack1" required="required"></td>
                                            <td><input type="text" name="per_box_weight_detail[]" class="form-control my-colorpicker1 per_box_weight"  data-attr="1" id="per_box_weight1" required="required"></td>
                                            <td><input type="text" name="actual_weight_detail[]" readonly class="form-control my-colorpicker1 actual_weight"  data-attr="1" id="actual_weight1"></td>
											<td><input type="text" name="chargable_weight" class="form-control" id="chargable_weight"/></td>
                                            <td><input type="text" name="valumetric_weight_detail[]" readonly class="form-control my-colorpicker1 valumetric_weight" data-attr="1" id="valumetric_weight1"></td>
                                            <td><input type="text" name="length_detail[]" class="form-control my-colorpicker1 length" data-attr="1" id="length1" ></td>
                                            <td><input type="text" name="breath_detail[]" class="form-control my-colorpicker1 breath" data-attr="1" id="breath1" ></td>
                                            <td><input type="text" name="height_detail[]" class="form-control my-colorpicker1 height" data-attr="1" id="height1" ></td>
                                            <td><input type="text" name="one_cft_kg_detail[]" readonly class="form-control my-colorpicker1 one_cft_kg" data-attr="1" id="one_cft_kg1"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div>
                                    <table style="border-collapse: separate;border-spacing: 13px;margin-bottom:15px;">
                                        <tr>
                                            <td><input type="text" name="no_of_pack" readonly="readonly" class="form-control my-colorpicker1 no_of_pack" id="no_of_pack" required="required"></td>
                                            <td><input type="text" name="per_box_weight" readonly="readonly" class="form-control my-colorpicker1 per_box_weight" id="per_box_weight" required="required"></td>
                                            <td><input type="text" name="actual_weight" readonly="readonly" class="form-control my-colorpicker1 actual_weight" id="actual_weight"></td>
                                            <td><input type="text" name="valumetric_weight" readonly="readonly" class="form-control my-colorpicker1 valumetric_weight" id="valumetric_weight"></td>
                                            <td ><input type="text" name="length" readonly="readonly" class="form-control my-colorpicker1 length"  id="length" required="required"></td>
                                            <td><input type="text" name="breath" readonly="readonly" class="form-control my-colorpicker1 breath"  id="breath" required="required"></td>
                                            <td><input type="text" name="height" readonly="readonly" class="form-control my-colorpicker1 height" id="height" required="required"></td>
                                            <td><input type="text" name="one_cft_kg" readonly="readonly" class="form-control my-colorpicker1 one_cft_kg" id="one_cft_kg"></td>
                                        </tr>
                                    </table>
                                    <a href="javascript:void(0)" class="add-weight-row">Add Row</a>
                                    <a href="javascript:void(0)" class="remove-weight-row">Remove</a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Special Instruction:</label>
                                    <textarea name="special_instruction" class="form-control my-colorpicker1"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type of Pack:</label>
                                    <input type="text" name="type_of_pack" class="form-control my-colorpicker1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Booking Date:</label>
                                    <input type="text" name="booking_date" value="<?php echo date('d-m-Y H:i:s');?>" id="booking_date" class="form-control my-colorpicker1 datepicker">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estimate Delivery Date:</label>
                                    <input type="text" id="delivery_date" name="delivery_date" value="<?php echo date('d-m-Y');?>" id="eod" class="form-control my-colorpicker1 datepicker">
                                </div>
                            </div>
                        </div>
                        <!--box-body-->
                    </div>
                    <!-- /.box-info -->
                </div>
                <!---col-md-8-->
                <div class="col-md-4">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="pod_no" id="exampleInputEmail1" placeholder="Enter Id" value="<?= $bid ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Forwording No.:</label>
                                <input type="text" name="forwording_no" class="form-control my-colorpicker1">
                            </div>
                            <div class="form-group">
                                <label>Forworder Name:</label>
                               <select name="forworder_name" class="form-control" id="forworderName">
                                    <option value="">Select Forworder Name</option>
                                    <option value="prabhatairexpress">Prabhat Air Express</option>
                                </select>
                            </div>
                        </div>
                        <!--box-body-->
                        <div class="box-body">
                           
                            <!--
							<label>Delivery Type:<br></label><br/>
                            <label>
                            <input type="radio" name="delivery_type" value="Godown" checked>Godown
                            </label>
                            <label>
                            <input type="radio" name="delivery_type" value="Door">Door
							</label>
							-->
						
                            <br/>
                            <label>Dispatch Details:<br></label><br/>
                            
                            
                            <label>
                            <input type="radio" name="dispatch_details" value="cash" >Cash
                            </label>
                            <label>
                            <input type="radio" name="dispatch_details" checked="checked" value="credit">Credit
                            </label>
                            <label>
                            <input type="radio" name="dispatch_details" value="To Pay">To Pay
                            </label>
                            <!--<label>
                            <input type="radio" name="dispatch_details" value="daoc">DAOC
                            </label>  -->
                            <br>
                            <label>
                                <input type="checkbox" name="create_shipment" value="1">Create Shipment
                            </label>
                            <br>
                            <label>Shipment Complete:<br></label><br/>
                            <label>
                            <input type="checkbox" name="status" value="1" >Complete Shipment
                            </label>
                            <br>
                            <label>Rate Type:<br></label><br/>
                            <label>
                            <input type="radio" name="rate_type" checked="checked" value="weight" class="rate_type" >Weight
                            </label>
                            <label>
                            <input type="radio" name="rate_type" value="no_of_pack" class="rate_type">No of Pack
                            </label>
                            <br>
                        </div>
                        <!--box-body-->
                        <div class="box-body">
                            
                           <div id="cont" style="display:none">
                            <table>
                                <thead>
                                    <th>Charges</th>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <td><br>&nbsp; &nbsp;Freight</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="text" name="frieht" id="frieht"/></td>
                                    </tr>
                                    
                                
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Fov</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="fov" id="fov"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; COD</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="cod" id="cod"></td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--    <td><br>&nbsp; &nbsp; AWB</td>-->
                                    <!--    <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="awb" id="awb" ></td>-->
                                    <!--</tr>-->
                                    <tr>
                                        <td><br>&nbsp; &nbsp; TO pay</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="to_pay" id="to_pat"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Handling Charges<!-- APMT Delivery --></td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="text" name="apmt_delivery" id="apmt_delivery"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; DOC Charges</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="dod_daoc" id="dod_doac"></td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--    <td><br>&nbsp; &nbsp; Loading/unloading</td>-->
                                    <!--    <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="loading" id="loading_unloading"></td>-->
                                    <!--</tr>-->
                                    <!--<tr>-->
                                    <!--    <td><br>&nbsp; &nbsp; Packing</td>-->
                                    <!--    <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="packing" id="packing"></td>-->
                                    <!--</tr>-->
                                    <!--<tr>-->
                                    <!--    <td><br>&nbsp; &nbsp; Handling</td>-->
                                    <!--    <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="handling" id="handling"></td>-->
                                    <!--</tr>-->
                                    <tr>
                                        <td><br>&nbsp; &nbsp; ODA</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="oda" id="oda"></td>
                                    </tr>
                                   <tr>
                                        <td><br>&nbsp; &nbsp; Demurrage</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="demurrage" id="demurrage"></td>
                                    </tr>
                                   <tr>
                                        <td><br>&nbsp; &nbsp; Other charges</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="other_charges" id="other_charges"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp;Total</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="text" readonly name="amount" id="amount"/></td>
                                    </tr>
                                   
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Fuel Surcharge</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" readonly="readonly" name="fuel_subcharges" id="fuel_charges"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>    
                                    
                                <table>
                                    <tbody>
                                    
                                    <tr>
                                        <td><br>&nbsp; &nbsp;Sub Total</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="text" readonly name="sub_total" id="sub_total"/></td>
                                    </tr>
                                    <!--                                    <tr>
                                        <td><br>&nbsp; &nbsp; GST Tax</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="service_tax"></td>
                                        </tr>-->
                                    <input type="hidden" name="gst_charges" id="gst_charges" value="1">
                                    <tr class="gst_charges">
                                        <td><br>&nbsp; &nbsp; SGST Tax</td>
                                        <td>
                                            <br>&nbsp; &nbsp;&nbsp;
                                            <div class="input-group"><input value="<?php //echo $SGST; ?>" type="number" id="sgst" step="any" name="sgst" readonly> <span class="input-group-addon"><i class="fa fa-percent"></i></span></div>
                                        </td>
                                    </tr>
                                    <tr class="gst_charges">
                                        <td><br>&nbsp; &nbsp; IGST Tax</td>
                                        <td>
                                            <br>&nbsp; &nbsp;&nbsp;
                                            <div class="input-group"><input value="<?php //echo $IGST; ?>" type="number" id="igst" step="any" name="igst" readonly><span class="input-group-addon"><i class="fa fa-percent"></i></span></div>
                                        </td>
                                    </tr>
                                    <tr class="gst_charges">
                                        <td><br>&nbsp; &nbsp; CGST Tax</td>
                                        <td>
                                            <br>&nbsp; &nbsp;&nbsp;
                                            <div class="input-group"><input value="<?php //echo $CGST; ?>" type="number" id="cgst" step="any" name="cgst" readonly><span class="input-group-addon"><i class="fa fa-percent"></i></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp;Grand Total</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="text" readonly name="grand_total" id="grand_total"/></td>
                                    </tr>
                                </tbody>
                            </table>
                           
                            
                            
                            
                            
                            
                            
                        </div>
                        <!--box-body-->
                    </div>
                    <!--box-info-->
                </div>
                <!--col-md-4-->
                <div class="col-sm-3">
					<input type="hidden" name="minimum_amount" id="minimum_amount" value="">							
                    <div class="box-footer pull-right">
                        <button type="submit" name="submit" id="add-pod-btn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
var rateMasterGet = true;
$(document).ready(function () {
	weightChangeEvent();
	$(".add-weight-row").on('click', function () {
		var allTrs = $('table.weight-table tbody').find('tr');
		var lastTr = allTrs[allTrs.length - 1];
		var $clone = $(lastTr).clone();

		var countrows = $(".one_cft_kg").length;
		$clone.find('td').each(function () {
			var el = $(this).find(':first-child');
			var id = el.attr('id') || null;
			if (id) {
				var i = id.substr(id.length - 1);

				var nextElament = countrows; //parseInt(i)+1;
				//console.log('nextElament:::'+nextElament+':::'+id+':::'+countrows)
				//alert(countrows.length);
				//console.log('id.length:::'+id.length+'::::'+':::'+countrows.length+':::::'+id.length - countrows.length);
				var remove = 1;
				if (countrows > 10) {
					var remove = 2;
				}
				var removeChar = (id.length - remove);
				var prefix = id.substr(0, removeChar);
				// prefix = id.substring(0,id.length - remove);
				// console.log(id.substring(0,id.length - remove));
				console.log('prefix:::' + prefix + '::::' + id + '::::' + removeChar);
				el.attr('id', prefix + (nextElament));
				el.attr('data-attr', (nextElament));
			}
		});
		$clone.find('input:text').val('');
		$('table.weight-table tbody').append($clone);
		var totalRow = $('table.weight-table tbody').find('tr').length;
		if (totalRow > 1) {
			$('.remove-weight-row').show();
		} else {
			$('.remove-weight-row').hide();
		}
		weightChangeEvent();
	});

	$(".remove-weight-row").on('click', function () {
		var totalRow = $('table.weight-table tbody').find('tr').length;
		if (totalRow > 1) {
			$('table.weight-table tbody').find('tr:last').remove();
			totalRow--;

		}
		if (totalRow == 1) {
			$(this).hide();
		}
		calculateTotalWeight();
		calulateTotal();

	});

	$('#booking_date').datepicker({
		format: 'dd-mm-yyyy'
	});
	$("#sender_pincode").blur(function () {
		var pincode = $(this).val();
		if (pincode != null || pincode != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>generatepod/getcity',
				data: 'pincode=' + pincode + '&mode_dispatch=' + $('.mode_dispatch').val(),
				success: function (d) {
					var v = d.toLowerCase();
					var uppercaseFirstLetter = v.charAt(0).toUpperCase() + v.slice(1);
					console.log(uppercaseFirstLetter);
					selectByText($.trim(uppercaseFirstLetter));
					getForworderList();
				}
			});
		}
	});
	$('.mode_dispatch').on('change', function () {
		getForworderList();
		//alert($("input[name='doc_type']:checked").val());
		if ($("input[name='doc_type']:checked").val() == '0') {
			add_doc_rate();
		}
	});


	function add_doc_rate() {

		if ($("input[name='doc_type']:checked").val() == '0') {
			var doc = '1';
		} else {
			var doc = '0';
		}

		var weight = $("#per_box_weight1").val();
		var qty = $("#no_of_pack1").val();
		var receiverPincode = $("#reciever_pincode").val();
		var senderPincode = $("#sender_pincode").val();
		var customer_id = $('#customer_account_id').val();
		var sender_city = $('#sender_city').val();
		var receiver_city = $('#reciever_city').val();
		var mode_dispatch = $('.mode_dispatch').val();
		var customer_name = $('#customer_account_id').val();
		var actual_weight = (parseFloat($('#actual_weight').val()) > 0) ? $('#actual_weight').val() : 0;
		var valumetric_weight = parseFloat($('#valumetric_weight').val()) > 0 ? $('#valumetric_weight').val() : 0;
		var rate_type = $('.rate_type:checked').val();
		var no_of_pack = parseFloat($('#no_of_pack').val()) > 0 ? $('#no_of_pack').val() : 0;


		// alert(weight);
		// alert(receiverPincode);
		//+ '&mode_dispatch=' + mode_dispatch + '&rate_type=' + rate_type + '&no_of_pack=' + no_of_pack

		if (weight != '' && receiverPincode != '' && qty != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>generatepod/add_new_rate',
				data: 'weight=' + weight + '&senderPincode=' + senderPincode + '&receiverPincode=' + receiverPincode + '&customer_id=' + customer_id + '&qty=' + qty + '&doc=' + doc + '&mode_dispatch=' + mode_dispatch + '&rate_type=' + rate_type + '&no_of_pack=' + no_of_pack,
				dataType: "json",
				success: function (data) {

					// alert("nn");
					$('#sgst').val(data.sgst);
					$('#cgst').val(data.cgst);
					$('#igst').val(data.igst);
					$('#sub_total').val(data.sub_total);
					$('#grand_total').val(data.grand_total);
				}
			});
		}

	}


	// $("#reciever_pincode").blur(function() {
	$(".reciever_pincode").on('change', function () {
		var pincode = $(this).val();
		if (pincode != null || pincode != '') {

		
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>generatepod/getcity',
				data: 'pincode=' + pincode,
				dataType: "json",
				success: function (d) {
					var option;
					option += '<option value="' + d.id + '">' + d.city + '</option>';
					$('#reciever_city').html(option);
				
					getForworderList();
				}
			});

		}
	});


	function getForworderList() {
		var senderPincode = $("#sender_pincode").val();
		var receiverPincode = $("#reciever_pincode").val();
		if (senderPincode != '' && receiverPincode != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>generatepod/getForwaorderList',
				data: 'senderPincode=' + senderPincode + '&receiverPincode=' + receiverPincode,
				dataType: "json",
				success: function (data) {
					var mode = $('.mode_dispatch').val();
					var option = '<option value="">Select Forworder Name</option>';
					option += '<option value="prabhatairexpress">Prabhat Air Express</option>';
					if (mode == 'Air') {
						// option += (data.bluedart_air == 1) ? '<option value="bluedart_air">Bludart Air Service</option>' : '';
						option += (data.bluedart_air == 1) ? '<option value="bluedart_air">Bludart Air</option>' : '';
						option += (data.fedex == 1) ? '<option value="Fedex">Fedex</option>' : '';
						option += (data.revigo == 1) ? '<option value="revigo_regular">Revigo</option>' : '';
						option += (data.trackon == 1) ? '<option value="Trackon">Trackon</option>' : '';
						option += (data.tpc == 1) ? '<option value="Tpc">Tpc</option>' : '';
						option += (data.shreemaruti == 1) ? '<option value="ShreeMaruti">ShreeMaruti</option>' : '';
						option += (data.franch == 1) ? '<option value="franch">franch</option>' : '';
						option += (data.gms == 1) ? '<option value="gms">GMS</option>' : '';
						option += (data.spoton == 1) ? '<option value="Spoton">spoton</option>' : '';
						option += (data.Lokeshcargo == 1) ? '<option value="Lokeshcargo">Lokeshcargo</option>' : '';
						option += (data.Kamariya == 1) ? '<option value="Kamariya">Kamariya</option>' : '';
						option += (data.Royalcargo == 1) ? '<option value="Royalcargo">Royalcargo</option>' : '';
						option += (data.Frontline == 1) ? '<option value="Frontline">Frontline</option>' : '';
					} else if (mode == 'Train') {
						// option += (data.fedex_regular == 1) ? '<option value="fedex_regular">Fedex Service</option>' : '';
						// option += (data.revigo_regular == 1) ? '<option value="revigo_regular">Revigo Service</option>' : '';
						option += (data.fedex == 1) ? '<option value="Fedex">Fedex</option>' : '';
						option += (data.revigo == 1) ? '<option value="revigo_regular">Revigo</option>' : '';
						option += (data.Lokeshcargo == 1) ? '<option value="Lokeshcargo">Lokeshcargo</option>' : '';
						option += (data.Kamariya == 1) ? '<option value="Kamariya">Kamariya</option>' : '';
						option += (data.Royalcargo == 1) ? '<option value="Royalcargo">Royalcargo</option>' : '';
						option += (data.Frontline == 1) ? '<option value="Frontline">Frontline</option>' : '';
					} else if (mode == 'Surface') {
						// option += (data.bluedart_surface == 1) ? '<option value="bluedart_surface">Bludart Surface Service</option>' : '';
						// option += (data.fedex_regular == 1) ? '<option value="fedex_regular">Fedex Service</option>' : '';
						// option += (data.revigo_regular == 1) ? '<option value="revigo_regular">Revigo Service</option>' : '';
						option += (data.bluedart_surface == 1) ? '<option value="bluedart_surface">Bludart Surface</option>' : '';
						option += (data.fedex == 1) ? '<option value="Fedex">Fedex</option>' : '';
						option += (data.revigo == 1) ? '<option value="revigo_regular">Revigo</option>' : '';
						option += (data.trackon == 1) ? '<option value="Trackon">Trackon</option>' : '';
						option += (data.tpc == 1) ? '<option value="Tpc">Tpc</option>' : '';
						option += (data.shreemaruti == 1) ? '<option value="ShreeMaruti">ShreeMaruti</option>' : '';
						option += (data.franch == 1) ? '<option value="franch">franch</option>' : '';
						option += (data.gms == 1) ? '<option value="gms">GMS</option>' : '';
						option += (data.Lokeshcargo == 1) ? '<option value="Lokeshcargo">Lokeshcargo</option>' : '';
						option += (data.Kamariya == 1) ? '<option value="Kamariya">Kamariya</option>' : '';
						option += (data.Royalcargo == 1) ? '<option value="Royalcargo">Royalcargo</option>' : '';
						option += (data.Frontline == 1) ? '<option value="Frontline">Frontline</option>' : '';
					}
					if (data.spoton_service == 1) {
						option += '<option value="Spoton">Spoton Service</option>';
					}
					// if (data.delhivery ==1){
					//     option +='<option value="delhivery">DELHIVERY</option>';
					// }

					if (data.delhivery_b2b == 1) {
						option += '<option value="Delhivery">DELHIVERY</option>';
					}

					/*   if (data.delhivery_c2c ==1){
					      option +='<option value="delhivery_c2c">DELHIVERY C2C</option>';
					  } */

					if (data.delex == 1) {
						option += '<option value="delex_cargo_india">DELEX</option>';
					}


					// $('#forworderName').empty().append(option);
					$('#forworderName').empty().html(option);
				}
			});
		}

	}

	function selectByText(txt) {
		$('#sender_city option')
			.filter(function () {
				return $.trim($(this).text()) == txt;
			})
			.attr('selected', true);
	}

	function weightChangeEvent() {
		$(".no_of_pack, .per_box_weight, .actual_weight, .length, .breath, .height, .no_of_pack, .one_cft_kg").change(function () {
			var idNo = $(this).attr('data-attr');
			calculateTotalWeight();
			calulate_weight(idNo);

			if ($("input[name='doc_type']:checked").val() == '0') {
				add_doc_rate();
			}

		});

		$("#length_unit1, #length_unit2").change(function () {
			var totalRow = $('table.weight-table tbody').find('tr').length;
			for (var i = 1; i <= totalRow; i++) {
				calculateTotalWeight();
				calulate_weight(i);
			}
		});
	}

	function calculateTotalWeight() {
		var totalRow = $('table.weight-table tbody').find('tr').length;
		var totalActualWeight = 0;
		var totalValumetricWeight = 0;
		var totalLength = 0;
		var totalBreath = 0;
		var totalHeight = 0;
		var totalOneCftKg = 0;
		var totalNoOfPack = 0;
		var totalPerBoxWeight = 0;
		//one_cft_kg
		for (var i = 1; i <= totalRow; i++) {
			var noOfPackCurrent = parseFloat(($('#no_of_pack' + i).val() != '') ? $('#no_of_pack' + i).val() : 0);
			var perBoxWeightCurrent = parseFloat(($('#per_box_weight' + i).val() != '') ? $('#per_box_weight' + i).val() : 0);
			
			var currentActualWeight = noOfPackCurrent * perBoxWeightCurrent;
			console.log('currentActualWeight' + currentActualWeight);
			if (currentActualWeight > 0) {
				$('#actual_weight' + i).val(currentActualWeight);
			}
			totalNoOfPack = parseFloat(totalNoOfPack) + parseFloat(($('#no_of_pack' + i).val() != '') ? $('#no_of_pack' + i).val() : 0);
			totalPerBoxWeight = parseFloat(totalPerBoxWeight) + parseFloat(($('#per_box_weight' + i).val() != '') ? $('#per_box_weight' + i).val() : 0);
			totalActualWeight = parseFloat(totalActualWeight) + parseFloat(($('#actual_weight' + i).val() != '') ? $('#actual_weight' + i).val() : 0);
			totalValumetricWeight = parseFloat(totalValumetricWeight) + parseFloat(($('#valumetric_weight' + i).val() != '') ? $('#valumetric_weight' + i).val() : 0);
			// totalValumetricWeight = totalValumetricWeight + ($('#valumetric_weight'+i).val() != '') ? $('#valumetric_weight'+i).val() : 0;
			totalLength = parseFloat(totalLength) + parseFloat(($('#length' + i).val() != '') ? $('#length' + i).val() : 0);
			totalBreath = parseFloat(totalBreath) + parseFloat(($('#breath' + i).val() != '') ? $('#breath' + i).val() : 0);
			totalHeight = parseFloat(totalHeight) + parseFloat(($('#height' + i).val() != '') ? $('#height' + i).val() : 0);
			totalOneCftKg = parseFloat(totalOneCftKg) + parseFloat(($('#one_cft_kg' + i).val() != '') ? $('#one_cft_kg' + parseInt(i)).val() : 0);
		
		}

		if (totalNoOfPack) {
			$('#no_of_pack').val(totalNoOfPack);
		}
		if (totalPerBoxWeight) {
			$('#per_box_weight').val(totalPerBoxWeight);
		}
		if (totalActualWeight) {
			$('#actual_weight').val(Math.ceil(totalActualWeight));
		}
		if (totalValumetricWeight) {
			var roundoff_type = $("#roundoff_type").val();
			// $('#valumetric_weight').val(totalValumetricWeight); ttttttt
			if (roundoff_type == '1') {
				$('#valumetric_weight').val(Math.round(totalValumetricWeight));
			} else {
				$('#valumetric_weight').val(Math.ceil(totalValumetricWeight));
			}

		}
		if (totalLength) {
			$('#length').val(totalLength);
		}
		if (totalBreath) {
			$('#breath').val(totalBreath);

		}
		if (totalHeight) {
			$('#height').val(totalHeight);
		}


	}

	function calulate_weight(idNo) {
		console.log('idNo:::::' + idNo)
		var idNo = (typeof idNo == 'undefined') ? 1 : idNo;
		var length_unit = $("input[name='length_unit']:checked").val();

		if (length_unit != 'cm' && length_unit != 'inch') {
			alert('Invalid measuremnet');
		}

		var actual_weight = $("#actual_weight" + idNo).val();
		var length = $("#length" + idNo).val();
		var breath = $("#breath" + idNo).val();
		var height = $("#height" + idNo).val();
		var one_cft_kg = $("#one_cft_kg" + idNo).val();
		if (one_cft_kg == '') {
			one_cft_kg = $("#one_cft_kg").val() ? $("#one_cft_kg").val() : '';
		}

		var no_of_pack = $("#no_of_pack" + idNo).val();
		if (no_of_pack == '') {
			no_of_pack = '';
		}
		console.log('check:::#one_cft_kg' + idNo + '####' + one_cft_kg);
		$("#one_cft_kg" + idNo).val(one_cft_kg);
		var valumetric_weight = '';
		var total_valumetric_weight = '';

		if (length != '' && breath != '' && height != '' && no_of_pack != '' && one_cft_kg != '') {
			console.log('length' + length);
			console.log('breath' + breath);
			console.log('height' + height);
			console.log('no_of_pack' + no_of_pack);
			console.log('one_cft_kg' + one_cft_kg);
			if (length_unit == 'cm') {
				valumetric_weight = ((length * breath * height) / 27000) * one_cft_kg * no_of_pack;
			} else {
				valumetric_weight = ((length * breath * height) / 5000) * no_of_pack;
			}

			console.log('valumetric_weight' + valumetric_weight);
		
			total_valumetric_weight = valumetric_weight.toFixed(2);
			$("#valumetric_weight" + idNo).val(total_valumetric_weight);
			calculateTotalWeight();
			calulateTotal();
		} else {
			$("#valumetric_weight" + idNo).val('');
		}
	}

	$("#customer_account_id").select2();
	$("#sender_city").select2();
	$("#reciever_city").select2();
	$('#awn').change(function () {
		var awn = $('#awn').val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url() ?>generatepod/checkawn',
			data: 'awn=' + awn,
			dataType: "json",
			success: function (data) {
				if (!data.status) {
					$('#awn').val('');
					alert('Airway No exist!');
				}
			}
		});
	});

	$("#customer_account_id").change(function () {
		var customer_name = $(this).val();
		$('#generatePOD')[0].reset();
		if (customer_name != null || customer_name != '') {
			$.ajax({
				type: 'POST',
				dataType: "json",
				url: '<?php echo base_url() ?>generatepod/getsenderdetails',
				data: 'customer_name=' + customer_name,
				success: function (data) {
					$("#sender").val(data.user.customer_name);
					$("#sender_address").val(data.user.address);
					$("#sender_pincode").val(data.user.pincode);
					$("#sender_contactno").val(data.user.phone);
					$("#sender_gstno").val(data.user.gstno);
					$("#gst_charges").val(data.user.gst_charges);
					$("#sender_city").val(data.user.city);
					$("#sender_city").select2();
					$("#customer_account_id").val(customer_name);
					if (data.user.gst_charges == 0) {
						$('.gst_charges').hide();
					} else {
						$('.gst_charges').show();
					}
				}
			});
		}
	});

	$(".no_of_pack").keyup(function () {
		if ($("#insurance_value").val() == '') {

			if ($("input[name='doc_type']:checked").val() == '0') {
				add_doc_rate();
			}

			//	alert('Please enter invoice amount first');
			//	$(this).val('');
			$("#insurance_value").focus();
		}
	});

	$("#sender_city, #reciever_city, .mode_dispatch, #actual_weight, #valumetric_weight, .per_box_weight, #no_of_pack, .rate_type, #insurance_value").change(function () {

		//alert('ss');
		//	calulateTotal();
		if ($("#insurance_value").val() == '') {
			if ($("input[name='doc_type']:checked").val() == '0') {
				add_doc_rate();
			}
			//alert('Please enter invoice amount first');
		} else {
			//  alert('YY');
			calulateTotal();

			if ($("input[name='doc_type']:checked").val() == '0') {
				add_doc_rate();
			}

		}

	});

	$("#chargable_weight").change(function () {

		//alert('ss');
		//	calulateTotal();
		if ($("#insurance_value").val() == '') {
			if ($("input[name='doc_type']:checked").val() == '0') {
				add_doc_rate();
			}
			//alert('Please enter invoice amount first');
		} else {
			//  alert('YY');
			calulateTotal_chargeble();

			if ($("input[name='doc_type']:checked").val() == '0') {
				add_doc_rate();
			}

		}

	});

	$('#awb,#to_pat,#dod_doac,#loading_unloading,#packing,#handling,#oda,#fov, #apmt_delivery,#cod,#demurrage,#other_charges').change(function () {
		var chargable_weight = parseFloat($('#chargable_weight').val()) > 0 ? $('#chargable_weight').val() : 0;
		var rate = parseFloat($('#rate').val()) > 0 ? $('#rate').val() : 0;
		// var chargable_weight = $('#chargable_weight').val() > 0 ? $('#chargable_weight').val() : 0;
		// var rate = $('#rate').val() > 0 ? $('#rate').val() : 0;
		finalRate();
	});

	$('#amount').change(function () {
		$('#amount_manual').val(1);
		finalRate();
	});
});

function calulateTotal_chargeble() {
	var sender_city = $('#sender_city').val();
	var receiver_city = $('#reciever_city').val();
	var mode_dispatch = $('.mode_dispatch').val();
	var customer_name = $('#customer_account_id').val();
	var actual_weight = (parseFloat($('#actual_weight').val()) > 0) ? $('#actual_weight').val() : 0;
	var valumetric_weight = parseFloat($('#valumetric_weight').val()) > 0 ? $('#valumetric_weight').val() : 0;
	var rate_type = $('.rate_type:checked').val();
	var no_of_pack = parseFloat($('#no_of_pack').val()) > 0 ? $('#no_of_pack').val() : 0;


	//alert(mode_dispatch);

	if ((((actual_weight > 0 || valumetric_weight > 0 || rateMasterGet) && rate_type == 'weight') || (rate_type == 'no_of_pack' && no_of_pack)) && customer_name != null && customer_name != '' && sender_city != '' && receiver_city != '' && receiver_city != 'undefined' && mode_dispatch != '') {

		//alert('step2');

		$.ajax({
			type: 'POST',
			dataType: "json",
			url: '<?php echo base_url() ?>generatepod/getRateMasterDetails',
			data: 'customer_name=' + customer_name + '&sender_city=' + sender_city + '&receiver_city=' + receiver_city + '&mode_dispatch=' + mode_dispatch + '&rate_type=' + rate_type + '&no_of_pack=' + no_of_pack,
			success: function (data) {


				var dod_doac = data.rate_master !== undefined && parseFloat(data.rate_master.dod_doac) > 0 ? parseFloat(data.rate_master.dod_doac) : 0;
				var weight_range = data.rate_master !== undefined && parseFloat(data.rate_master.weight_range) > 0 ? parseFloat(data.rate_master.weight_range) : 0;
				var packing = data.rate_master !== undefined && parseFloat(data.rate_master.packing) > 0 ? parseFloat(data.rate_master.packing) : 0;
				var handling = data.rate_master !== undefined && parseFloat(data.rate_master.handling) > 0 ? parseFloat(data.rate_master.handling) : 0;
				var fov = data.rate_master !== undefined && parseFloat(data.rate_master.fov) > 0 ? parseFloat(data.rate_master.fov) : 0;
				var min_fov = data.rate_master !== undefined && parseFloat(data.rate_master.min_fov) > 0 ? parseFloat(data.rate_master.min_fov) : 0;
				var fuel_charges = data.rate_master !== undefined && parseFloat(data.rate_master.fuel_charges) > 0 ? parseFloat(data.rate_master.fuel_charges) : 0;
				var rate = data.rate_master !== undefined && parseFloat(data.rate_master.rate) > 0 ? parseFloat(data.rate_master.rate) : 0;
				var insuranceValue = parseFloat($('#insurance_value').val()) > 0 ? parseFloat($('#insurance_value').val()) : 0;
				var rate_pack = data.rate_master !== undefined && data.rate_master_pack != undefined && parseFloat(data.rate_master_pack.rate) > 0 ? parseFloat(data.rate_master_pack.rate) : 0;
				var oda = parseFloat($('#oda').val()) > 0 ? parseFloat($('#oda').val()) : 0;
				var cft = data.rate_master !== undefined && parseFloat(data.rate_master.cft) > 0 ? parseFloat(data.rate_master.cft) : 1;
				var actual_weight = parseFloat($('#actual_weight').val()) > 0 ? parseFloat($('#actual_weight').val()) : 0;
				var chargable_weight = actual_weight;
				var eod = data.rate_master !== undefined ? data.rate_master.eod : '';
				var min_freight = data.rate_master.min_freight !== undefined && parseFloat(data.rate_master.min_freight) > 0 ? parseFloat(data.rate_master.min_freight) : 0;
				var min_amount = data.rate_master.min_amount !== undefined && parseFloat(data.rate_master.min_amount) > 0 ? parseFloat(data.rate_master.min_amount) : 0;
				//alert(min_amount);
				var fc_type = data.rate_master !== undefined && data.rate_master.fc_type !== undefined ? data.rate_master.fc_type : '';
				var gst_rate = data.rate_master !== undefined && data.rate_master.gst_rate !== undefined ? data.rate_master.gst_rate : 0;
				var roundoff_type = data.rate_master !== undefined && data.rate_master.roundoff_type !== undefined ? data.rate_master.roundoff_type : '2';
				$("#roundoff_type").val(roundoff_type);

				var cod = data.rate_master !== undefined && data.rate_master.cod !== undefined ? data.rate_master.cod : '';
				var edd = data.rate_master !== undefined && data.rate_master.edd !== undefined ? data.rate_master.edd : '';
				var to_pay_charges = data.rate_master !== undefined && data.rate_master.to_pay_charges !== undefined ? data.rate_master.to_pay_charges : '';
				//$("#roundoff_type").val(cod);
				if (edd != '') {
					var now = new Date();
					now.setDate(now.getDate() + parseInt(edd));

					var month = now.getMonth() + 1;
					var day = now.getDate();
					var year = now.getFullYear();
					var formatedDate = day + "-" + month + "-" + year;
					$("#delivery_date").val(formatedDate);
				}

				if (to_pay_charges != '') {
					$("#to_pat").val(to_pay_charges);
				}
				if (cod != '') {
					$("#cod").val(cod);
				}

				//var chargable_weight;
				$('#eod').val(eod);
				rateMasterGet = false;
				//console.log('ac Weight' + chargable_weight);
				if (parseInt(valumetric_weight) > parseInt(chargable_weight)) {
					chargable_weight = valumetric_weight;
				}
			
				if (parseInt(weight_range) > parseInt(chargable_weight)) {
					chargable_weight = weight_range;
				}

				if (fov > 0 && insuranceValue > 0) {
					fov = ((fov * insuranceValue) / 100).toFixed(2);
					// $('#fov').val(fov);
					if (min_fov > fov) {
						$('#fov').val(min_fov);
					} else {
						$('#fov').val(fov);
					}

				}
				//  $('#chargable_weight').val(chargable_weight);
				$('#rate').val(rate);
				$('#one_cft_kg').val(cft);
				$('#dod_doac').val(dod_doac);
				$('#rate_pack').val(rate_pack);
				$('#gst_rate').val(gst_rate);
				finalRate_chargeble(fuel_charges, min_freight, min_amount, fc_type);
			}
		});
	}
}

function calulateTotal() {
	var sender_city = $('#sender_city').val();
	var receiver_city = $('#reciever_city').val();
	var mode_dispatch = $('.mode_dispatch').val();
	var customer_name = $('#customer_account_id').val();
	var actual_weight = (parseFloat($('#actual_weight').val()) > 0) ? $('#actual_weight').val() : 0;
	var valumetric_weight = parseFloat($('#valumetric_weight').val()) > 0 ? $('#valumetric_weight').val() : 0;
	var rate_type = $('.rate_type:checked').val();
	var no_of_pack = parseFloat($('#no_of_pack').val()) > 0 ? $('#no_of_pack').val() : 0;


	//alert(mode_dispatch);

	if ((((actual_weight > 0 || valumetric_weight > 0 || rateMasterGet) && rate_type == 'weight') || (rate_type == 'no_of_pack' && no_of_pack)) && customer_name != null && customer_name != '' && sender_city != '' && receiver_city != '' && receiver_city != 'undefined' && mode_dispatch != '') {

		//alert('step2');

		$.ajax({
			type: 'POST',
			dataType: "json",
			url: '<?php echo base_url() ?>generatepod/getRateMasterDetails',
			data: 'customer_name=' + customer_name + '&sender_city=' + sender_city + '&receiver_city=' + receiver_city + '&mode_dispatch=' + mode_dispatch + '&rate_type=' + rate_type + '&no_of_pack=' + no_of_pack,
			success: function (data) {


				var dod_doac = data.rate_master !== undefined && parseFloat(data.rate_master.dod_doac) > 0 ? parseFloat(data.rate_master.dod_doac) : 0;
				var weight_range = data.rate_master !== undefined && parseFloat(data.rate_master.weight_range) > 0 ? parseFloat(data.rate_master.weight_range) : 0;
				var packing = data.rate_master !== undefined && parseFloat(data.rate_master.packing) > 0 ? parseFloat(data.rate_master.packing) : 0;
				var handling = data.rate_master !== undefined && parseFloat(data.rate_master.handling) > 0 ? parseFloat(data.rate_master.handling) : 0;
				var fov = data.rate_master !== undefined && parseFloat(data.rate_master.fov) > 0 ? parseFloat(data.rate_master.fov) : 0;
				var min_fov = data.rate_master !== undefined && parseFloat(data.rate_master.min_fov) > 0 ? parseFloat(data.rate_master.min_fov) : 0;
				var fuel_charges = data.rate_master !== undefined && parseFloat(data.rate_master.fuel_charges) > 0 ? parseFloat(data.rate_master.fuel_charges) : 0;
				var rate = data.rate_master !== undefined && parseFloat(data.rate_master.rate) > 0 ? parseFloat(data.rate_master.rate) : 0;
				var insuranceValue = parseFloat($('#insurance_value').val()) > 0 ? parseFloat($('#insurance_value').val()) : 0;
				var rate_pack = data.rate_master !== undefined && data.rate_master_pack != undefined && parseFloat(data.rate_master_pack.rate) > 0 ? parseFloat(data.rate_master_pack.rate) : 0;
				var oda = parseFloat($('#oda').val()) > 0 ? parseFloat($('#oda').val()) : 0;
				var cft = data.rate_master !== undefined && parseFloat(data.rate_master.cft) > 0 ? parseFloat(data.rate_master.cft) : 1;
				var actual_weight = parseFloat($('#actual_weight').val()) > 0 ? parseFloat($('#actual_weight').val()) : 0;
				var chargable_weight = actual_weight;
				var eod = data.rate_master !== undefined ? data.rate_master.eod : '';
				var min_freight = data.rate_master.min_freight !== undefined && parseFloat(data.rate_master.min_freight) > 0 ? parseFloat(data.rate_master.min_freight) : 0;
				var min_amount = data.rate_master.min_amount !== undefined && parseFloat(data.rate_master.min_amount) > 0 ? parseFloat(data.rate_master.min_amount) : 0;
				//alert(min_amount);
				var fc_type = data.rate_master !== undefined && data.rate_master.fc_type !== undefined ? data.rate_master.fc_type : '';
				var gst_rate = data.rate_master !== undefined && data.rate_master.gst_rate !== undefined ? data.rate_master.gst_rate : 0;
				var roundoff_type = data.rate_master !== undefined && data.rate_master.roundoff_type !== undefined ? data.rate_master.roundoff_type : '2';
				$("#roundoff_type").val(roundoff_type);

				var cod = data.rate_master !== undefined && data.rate_master.cod !== undefined ? data.rate_master.cod : '';
				var edd = data.rate_master !== undefined && data.rate_master.edd !== undefined ? data.rate_master.edd : '';
				var to_pay_charges = data.rate_master !== undefined && data.rate_master.to_pay_charges !== undefined ? data.rate_master.to_pay_charges : '';
				//$("#roundoff_type").val(cod);
				if (edd != '') {
					var now = new Date();
					now.setDate(now.getDate() + parseInt(edd));

					var month = now.getMonth() + 1;
					var day = now.getDate();
					var year = now.getFullYear();
					var formatedDate = day + "-" + month + "-" + year;
					$("#delivery_date").val(formatedDate);
				}

				if (to_pay_charges != '') {
					$("#to_pat").val(to_pay_charges);
				}
				if (cod != '') {
					$("#cod").val(cod);
				}

				//var chargable_weight;
				$('#eod').val(eod);
				rateMasterGet = false;
				//console.log('ac Weight' + chargable_weight);
				if (parseInt(valumetric_weight) > parseInt(chargable_weight)) {
					chargable_weight = valumetric_weight;
				}
				
				if (parseInt(weight_range) > parseInt(chargable_weight)) {
					chargable_weight = weight_range;
				}

			

				if (fov > 0 && insuranceValue > 0) {
					fov = ((fov * insuranceValue) / 100).toFixed(2);
					// $('#fov').val(fov);
					if (min_fov > fov) {
						$('#fov').val(min_fov);
					} else {
						$('#fov').val(fov);
					}

				}
				$('#chargable_weight').val(chargable_weight);
				$('#rate').val(rate);
				$('#one_cft_kg').val(cft);
				$('#dod_doac').val(dod_doac);
				$('#rate_pack').val(rate_pack);
				$('#gst_rate').val(gst_rate);
				finalRate(fuel_charges, min_freight, min_amount, fc_type);
			}
		});
	}
}

// function finalRate(fuel_charges) {
function finalRate_chargeble(fuel_charges, min_freight, min_amount, fc_type) {

	var total_charge = 0;
	var total_pay = 0;
	var total = 0;

	var chargable_weight = parseFloat($('#chargable_weight').val()) > 0 ? parseFloat($('#chargable_weight').val()) : 0;
	var rate = parseFloat($('#rate').val()) > 0 ? parseFloat($('#rate').val()) : 0;
	var dod_doac = parseFloat($('#dod_doac').val()) > 0 ? parseFloat($('#dod_doac').val()) : 0;
	var apmt_delivery = parseFloat($('#apmt_delivery').val()) > 0 ? parseFloat($('#apmt_delivery').val()) : 0;
	var fov = parseFloat($('#fov').val()) > 0 ? parseFloat($('#fov').val()) : 0;
	var gst_charges = parseFloat($('#gst_charges').val()) > 0 ? parseFloat($('#gst_charges').val()) : 0;
	var oda = parseFloat($('#oda').val()) > 0 ? parseFloat($('#oda').val()) : 0;
	var to_pat = parseFloat($('#to_pat').val()) > 0 ? parseFloat($('#to_pat').val()) : 0;
	var rate_type = $('.rate_type:checked').val();
	var no_of_pack = parseFloat($('#no_of_pack').val()) > 0 ? parseFloat($('#no_of_pack').val()) : 0;
	var cod = parseFloat($('#cod').val()) > 0 ? parseFloat($('#cod').val()) : 0;
	var demurrage = parseFloat($('#demurrage').val()) > 0 ? parseFloat($('#demurrage').val()) : 0;
	var other_charges = parseFloat($('#other_charges').val()) > 0 ? parseFloat($('#other_charges').val()) : 0;
	var gst_rate = $("#gst_rate").val() > 0 ? $("#gst_rate").val() : 0;
	var gst = gst_rate / 2;

	if (rate_type == 'weight' || rate_type == 'no_of_pack') {
		if ($('#amount_manual').val() == 1 && $('#frieht').val() > 0) {
			total_pay = $('#frieht').val() ? $('#frieht').val() : 0;
		} else {
			total_pay = (rate_type == 'weight') ? (parseFloat(rate) * parseFloat(chargable_weight)) : $('#rate_pack').val();
			var frieght = total_pay;
			$('#frieht').val(frieght.toFixed(2));
		}

		console.log('Total Pay' + total_pay);
		console.log('chargable Weight' + chargable_weight);

		total = (total_pay + dod_doac + fov + oda + to_pat + apmt_delivery + cod + demurrage + other_charges).toFixed(2);
		$('#amount').val(total);
		if (fuel_charges != 'undefind' && fuel_charges > 0) {
			if (fc_type == 'freight') {

				fuel_charges = parseFloat(($('#frieht').val() * fuel_charges) / 100).toFixed(2);
			} else if (fc_type == 'total') {

				fuel_charges = parseFloat((total * fuel_charges) / 100).toFixed(2);
			} else {
				fuel_charges = 0;
			}
			$('#fuel_charges').val(fuel_charges);
		} else {
			fuel_charges = parseFloat($('#fuel_charges').val() > 0 ? $('#fuel_charges').val() : 0);
		}


		var total_charges = parseFloat(total) + parseFloat(fuel_charges);
		if (min_freight > total_charges || total_charges == '') {
			total_charge = min_freight;
		} else {
			total_charge = Math.round(total) + Math.round(fuel_charges);
		}
		var totgst = 0;

		var sender_gstno = $('#sender_gstno').val();
		var first_two_gst_no = sender_gstno.substring(0, 2);
		if (first_two_gst_no == '27') {
			console.log("gst_charges::::" + gst_charges);
			var igst = 0;
			var sgst = 0;
			var cgst = 0;
			if (gst_charges == 1) {

				var sgst = total_charge * gst / 100;
				var cgst = total_charge * gst / 100;
				$('#sgst').val(sgst.toFixed(2));
				$('#cgst').val(cgst.toFixed(2));
				$('#igst').val(igst.toFixed(2));

			}
			totgst = sgst + cgst;

		} else {
			var igst = 0;
			var sgst = 0;
			var cgst = 0;
			if (gst_charges == 1) {
				igst = total_charge * gst / 100;
				$('#sgst').val(sgst.toFixed(2));
				$('#cgst').val(cgst.toFixed(2));
				$('#igst').val(igst.toFixed(2));
			}
			totgst = igst;
		}
		console.log('Total Chargeable Pay' + total_charge);

		if (total_charge < min_amount) {
			total_charge = min_amount;
		}

		var subtototal = parseFloat(total_charge).toFixed(2);
		$('#sub_total').val(subtototal);

		console.log('Gst:::' + totgst);
		var grand_total = parseFloat(total_charge) + parseFloat(totgst);
		$('#grand_total').val(grand_total.toFixed(2));
		$('#minimum_amount').val(min_amount);
		console.log('grand_total' + grand_total);

	} else {
		return false;
	}
}

function finalRate(fuel_charges, min_freight, min_amount, fc_type) {

	var total_charge = 0;
	var total_pay = 0;
	var total = 0;
	

	var chargable_weight = parseFloat($('#chargable_weight').val()) > 0 ? parseFloat($('#chargable_weight').val()) : 0;
	var rate = parseFloat($('#rate').val()) > 0 ? parseFloat($('#rate').val()) : 0;
	var dod_doac = parseFloat($('#dod_doac').val()) > 0 ? parseFloat($('#dod_doac').val()) : 0;
	var apmt_delivery = parseFloat($('#apmt_delivery').val()) > 0 ? parseFloat($('#apmt_delivery').val()) : 0;
	var fov = parseFloat($('#fov').val()) > 0 ? parseFloat($('#fov').val()) : 0;
	var gst_charges = parseFloat($('#gst_charges').val()) > 0 ? parseFloat($('#gst_charges').val()) : 0;
	var oda = parseFloat($('#oda').val()) > 0 ? parseFloat($('#oda').val()) : 0;
	var to_pat = parseFloat($('#to_pat').val()) > 0 ? parseFloat($('#to_pat').val()) : 0;
	var rate_type = $('.rate_type:checked').val();
	var no_of_pack = parseFloat($('#no_of_pack').val()) > 0 ? parseFloat($('#no_of_pack').val()) : 0;
	var cod = parseFloat($('#cod').val()) > 0 ? parseFloat($('#cod').val()) : 0;
	var demurrage = parseFloat($('#demurrage').val()) > 0 ? parseFloat($('#demurrage').val()) : 0;
	var other_charges = parseFloat($('#other_charges').val()) > 0 ? parseFloat($('#other_charges').val()) : 0;
	var gst_rate = $("#gst_rate").val() > 0 ? $("#gst_rate").val() : 0;
	var gst = gst_rate / 2;
	if (rate_type == 'weight' || rate_type == 'no_of_pack') {
		if ($('#amount_manual').val() == 1 && $('#frieht').val() > 0) {
			total_pay = $('#frieht').val() ? $('#frieht').val() : 0;
		} else {
			total_pay = (rate_type == 'weight') ? (parseFloat(rate) * parseFloat(chargable_weight)) : $('#rate_pack').val();
			//lert(total_pay+':::'+rate_type+':::'+rate+'::::'+chargable_weight+':::::'+$('#rate_pack').val())
			var frieght = total_pay;
			
			$('#frieht').val(frieght.toFixed(2));
			
		}
		console.log('Total Pay' + total_pay);
		console.log('chargable Weight' + chargable_weight);
		
		total = (total_pay + dod_doac + fov + oda + to_pat + apmt_delivery + cod + demurrage + other_charges).toFixed(2);
		$('#amount').val(total);
		if (fuel_charges != 'undefind' && fuel_charges > 0) {
			if (fc_type == 'freight') {
				
				fuel_charges = parseFloat(($('#frieht').val() * fuel_charges) / 100).toFixed(2);
			} else if (fc_type == 'total') {
				
				fuel_charges = parseFloat((total * fuel_charges) / 100).toFixed(2);
			} else {
				fuel_charges = 0;
			}
			$('#fuel_charges').val(fuel_charges);
		} else {
			// fuel_charges = parseInt($('#fuel_charges').val()) > 0 ? $('#fuel_charges').val() : 0;
			// fuel_charges = Math.round($('#fuel_charges').val()) > 0 ? $('#fuel_charges').val() : 0;
			fuel_charges = parseFloat($('#fuel_charges').val() > 0 ? $('#fuel_charges').val() : 0);
		}

		var total_charges = parseFloat(total) + parseFloat(fuel_charges);
		if (min_freight > total_charges || total_charges == '') {
			total_charge = min_freight;
		} else {
			total_charge = Math.round(total) + Math.round(fuel_charges);
		}
		var totgst = 0;
		// var first_two_gst_no = 0;
		// $("#reciever_gstno").change(function(){
		var sender_gstno = $('#sender_gstno').val();
		var first_two_gst_no = sender_gstno.substring(0, 2);
		if (first_two_gst_no == '27') {
			console.log("gst_charges::::" + gst_charges);
			var igst = 0;
			var sgst = 0;
			var cgst = 0;
			if (gst_charges == 1) {
				
				var sgst = total_charge * gst / 100;
				var cgst = total_charge * gst / 100;
				$('#sgst').val(sgst.toFixed(2));
				$('#cgst').val(cgst.toFixed(2));
				$('#igst').val(igst.toFixed(2));
				
			}
			totgst = sgst + cgst;
			// totgst =  Math.round(sgst) + Math.round(cgst);
		} else {
			var igst = 0;
			var sgst = 0;
			var cgst = 0;
			if (gst_charges == 1) {
			
				igst = total_charge * gst / 100;
				$('#sgst').val(sgst.toFixed(2));
				$('#cgst').val(cgst.toFixed(2));
				$('#igst').val(igst.toFixed(2));
				

			}
			//   totgst =  Math.round(igst);
			totgst = igst;
		}
		console.log('Total Chargeable Pay' + total_charge);

		if (total_charge < min_amount) {
			total_charge = min_amount;
		}

		var subtototal = parseFloat(total_charge).toFixed(2);
		$('#sub_total').val(subtototal);
		// var grand_total = parseInt(total_charge) + parseInt(igst);
		// var grand_total = Math.round(total_charge) + Math.round(totgst);
		console.log('Gst:::' + totgst);
		var grand_total = parseFloat(total_charge) + parseFloat(totgst);
		$('#grand_total').val(grand_total.toFixed(2));
		$('#minimum_amount').val(min_amount);
		console.log('grand_total' + grand_total);
		
	} else {
		return false;
	}
}
</script>
<style>
.add-weight-row {
    padding: 7px 5px;
    background: #ccc;
    margin-bottom: 10px;
    color: #000;
    border: 1px solid;
    float:left;
}

.remove-weight-row {
   margin-left:15px;
    padding: 7px 5px;
    background: #ccc;
    margin-bottom: 10px;
    color: #000;
    border: 1px solid;
    float:left;
    display:none;
}
</style>
