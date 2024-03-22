<?php include 'sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Shipment</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">Edit Shipment</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <form role="form" action="<?php echo base_url(); ?>generatepod/updatepodnew/<?php echo $booking[0]['booking_id']; ?>" method="post">
                <input type ="hidden" name="rate" id="rate" value="<?php echo $weight[0]['rate']; ?>" />
                <input type="hidden" name="chargable_weight" id="chargable_weight" value="<?php echo $weight[0]['chargable_weight']; ?>" />
                 <input type ="hidden" name="rate_pack" value="<?php $weight[0]['rate_pack']; ?>" id="rate_pack" />
                 <input type="hidden" name="amount_manual" id="amount_manual" value="0" />
             
                <div class="col-md-8">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="col-md-6">
                                <h3 class="box-title">Consigner</h3>
                                <div class="form-group">
                                    <label>Address:</label>
                                    <input type="text" name="sender_address" id="sender_address" value="<?php echo $booking[0]['sender_address']; ?>" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>City:</label>
                                    <select class="form-control"  name="sender_city" id="sender_city" required>
                                        <option value="">Select City</option>
                                        <?php
                                        if (count($cities)) {
                                            foreach ($cities as $rows) {
                                                ?>
                                                <option value="<?php echo $rows['city_id']; ?>" <?php if($booking[0]['sender_city'] == $rows['city_id']) { echo 'selected="selected"';} ?>>
                                                    <?php echo $rows['city_name']; ?> 
                                                </option>
                                                <?php
                                            }
                                        } else {
                                            echo "<p>No Data Found</p>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pincode No.:</label>
                                    <input type="text" name="sender_pincode" id="sender_pincode" value="<?php echo $booking[0]['sender_pincode']; ?>" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Contact No.:</label>
                                    <input type="text" name="sender_contactno" id="sender_contactno" value="<?php echo $booking[0]['sender_contactno']; ?>" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Sender GST NO.:</label>
                                    <span><input type="text" name="sender_gstno" id="sender_gstno" value="<?php echo $booking[0]['sender_gstno'] ?>" class="form-control my-colorpicker1"></span>
                                </div>
                            </div><!--col-md-6-->
                            <div class="col-md-6">
                                <h3 class="box-title">Consignee</h3>
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="reciever_name" id="reciever"  value="<?php echo $booking[0]['reciever_name']; ?>" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Address:</label>
                                    <input type="text" name="reciever_address" id="reciever_address" value="<?php echo $booking[0]['reciever_address']; ?>" class="form-control my-colorpicker1">
                                </div>
                                <!-- <div class="form-group">
                                    <label>City:</label>
                                    <select class="form-control"  name="reciever_city" id="reciever_city" required>
                                        <option value="">Select City</option>
                                        <?php
                                        foreach ($cities as $rows) {
                                            ?>
                                            <option value="<?php echo $rows['city_id']; ?>" <?php if($booking[0]['reciever_city'] == $rows['city_id']) { echo 'selected="selected"';} ?>>
                                                <?php echo $rows['city_name']; ?> 
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label>Pincode No.:</label>
                                    <input type="text" name="reciever_pincode" id="reciever_pincode" value="<?php echo $booking[0]['reciever_pincode']; ?>" class="form-control my-colorpicker1 reciever_pincode">
								</div>
								<div class="form-group">
									<label>City:</label>
									<select class="form-control" name="reciever_city" id="reciever_city" required>
										<option value="">Select City</option>
										<?php
										foreach ($cities as $rows) {
										?>
											<option value="<?php echo $rows['city_id']; ?>" <?php if($booking[0]['reciever_city'] == $rows['city_id']) { echo 'selected="selected"';} ?>>
                                                <?php echo $rows['city_name']; ?> 
                                            </option>
										<?php
										}
										?>
									</select>
								</div>
                                <div class="form-group">
                                    <label>Contact No.:</label>
                                    <input type="text" name="reciever_contact" id="reciever_contactno" value="<?php echo $booking[0]['reciever_contact']; ?>" class="form-control my-colorpicker1">
                                </div>
                                <div class="form-group">
                                    <label>Reciever GST NO.:</label>
                                    <input type="text" name="receiver_gstno" id="reciever_gstno" value="<?php echo $booking[0]['receiver_gstno']; ?>" class="form-control my-colorpicker1">
                                </div>
                            </div><!--col-md-6-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>INV No.:</label>
                                    <input type="text" name="inv_no" class="form-control my-colorpicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ins. Value:</label>
                                    <input type="text" name="insurance_value" value="<?php echo $booking[0]['insurance_value']; ?>" class="form-control my-colorpicker1">
                                </div>
                            </div>
                            <!--<div class="col-md-4">
                            <div class="form-group">
                              <label>Declared Invoice Value Rs.:</label>
                              <input type="text" class="form-control my-colorpicker1">
                            </div>
                            </div>-->
                            <div class="col-md-12">
                                <table>
                                    <thead>
                                    <th>Actual Weight:</th>
                                    <th>Valumetric Weight</th>
                                    <th>L</th>
                                    <th>B</th>
                                    <th>H</th>
                                    <th>1CFT(kg)</th>
                                    <th>Inch L</th>
                                    <th>B</th>
                                    <th>H</th>
                                    <th>1CFT(kg)</th>
                                    <th>ChargeableWeight</th>
                                    <thead>
                                    <tbody>
                                    <td><input type="text" name="actual_weight" value="<?php echo $weight[0]['actual_weight']; ?>" class="form-control my-colorpicker1" id="actual_weight"></td>
                                    <td><input type="text" name="valumetric_weight" value="<?php echo $weight[0]['valumetric_weight']; ?>" class="form-control my-colorpicker1" id="valumetric_weight"></td>
                                    <td><input type="text" name="length" value="<?php echo $weight[0]['length']; ?>" class="form-control my-colorpicker1" id="length"></td>
                                    <td><input type="text" name="breath" value="<?php echo $weight[0]['breath']; ?>" class="form-control my-colorpicker1" id="breath"></td>
                                    <td><input type="text" name="height" value="<?php echo $weight[0]['height']; ?>" class="form-control my-colorpicker1" id="height"></td>
                                    <td><input type="text" name="one_cft_kg" value="<?php echo $weight[0]['one_cft_kg']; ?>" class="form-control my-colorpicker1" id="one_cft_kg"></td>
                                    <td><input type="text" name="inch_l" value="<?php echo $weight[0]['length']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="breath" value="<?php echo $weight[0]['breath']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="height" value="<?php echo $weight[0]['height']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="one_cft_kg" value="<?php echo $weight[0]['one_cft_kg']; ?>" class="form-control my-colorpicker1" readonly="readonly"></td>
                                    <td><input type="text" name="chargable_weight1" value="<?php echo $weight[0]['chargable_weight']; ?>" readonly="readonly" class="form-control my-colorpicker1"></td>
                                    </tbody>
                                </table>
                                <br><br>			  
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Special Instruction:</label>
                                    <textarea name="special_instruction" value="<?php echo $weight[0]['special_instruction']; ?>" class="form-control my-colorpicker1"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. of Pack:</label>
                                    <input type="text" name="no_of_pack" value="<?php echo $weight[0]['no_of_pack']; ?>" class="form-control my-colorpicker1" id="no_of_pack">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type of Pack:</label>
                                    <input type="text" name="type_of_pack" value="<?php echo $weight[0]['type_of_pack']; ?>" class="form-control my-colorpicker1">
                                </div>
                            </div>
                             <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Booking Date:</label>
                                        <input type="text" name="booking_date" value="<?php echo date('d/m/Y',strtotime( $booking[0]['booking_date']));?>" id="booking_date" class="form-control my-colorpicker1 datepicker">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Delivery Date:</label>
                                        <input type="text" name="delivery_date" value="<?php echo $booking[0]['delivery_date'];?>" id="eod" class="form-control my-colorpicker1 datepicker">
                                    </div>
                                </div>
                            <!--<div class="col-md-8">
                             <br><br>
                            <table>
                              <thead>
                                <th rowspan="2">Pickup Details</th>
                              <thead>
                              <tbody>
                               <tr>
                                <th>No. Of Pack</th>
                                <th>Type Of Pack</th>
                               </tr>
                               <tr>
                                <td><input type="text" name="no_of_pack" class="form-control my-colorpicker1"></td>
                                <td><input type="text" name="type_of_pack" class="form-control my-colorpicker1"></td>
                              </tr>
                             </tbody>
                            </table> 
                          </div>-->

                        </div><!--box-body-->
                    </div><!-- /.box-info -->
                </div><!---col-md-8-->
                <div class="col-md-4">
                    <div class="box box-info">
                        <div class="box-body">
                            <!--<div class="form-group">
                              <input type="hidden" class="form-control" name="pod_no" id="exampleInputEmail1" placeholder="Enter Id"  readonly>
                            </div>-->
                            <div class="form-group">
                                <label>Forwording No.:</label>
                                <input type="text" name="forwording_no" value="<?php echo $booking[0]['forwording_no']; ?>" class="form-control my-colorpicker1">
                            </div>
                            <!-- <div class="form-group">
                                <label>Forworder Name:</label>
                                <input type="text" name="forworder_name" value="<?php echo $booking[0]['forworder_name']; ?>" class="form-control my-colorpicker1">
							</div> -->
							<div class="form-group">
								<label>Forworder Name:</label>
								<select name="forworder_name" class="form-control" id="forworderName">
									<option value="">Select Forworder Name</option>
									<option value="shrisailogistics">Shri Sai Logistics</option>
								</select>
								<!--<input type="text" name="forworder_name" value="<?php echo $booking[0]['forworder_name']; ?>" class="form-control my-colorpicker1">-->
							</div>
                        </div><!--box-body-->
                        <div class="box-body">
                            <label>Mode Of Dispatch:<br></label><br/>
                            <?php
                            $air = '';
                            $train = '';
                            $surface = '';
                            $mode_dispatch = $booking[0]['mode_dispatch'];
                            if($mode_dispatch == 'air'){
                                $air = "checked";
                            }else if($mode_dispatch == 'train'){
                                $train = "checked";
                            }else if($mode_dispatch == 'surface'){
                                $surface = "checked";
                            }
                            ?>
                            <label>Air
                                <input type="radio" name="mode_dispatch" class="mode_dispatch" value="air" <?php echo $air;?>>
                            </label>
                            <label>Train
                                <input type="radio" name="mode_dispatch" class="mode_dispatch" value="train" <?php echo $train;?>>
                            </label>
                            <label>Surface
                                <input type="radio" name="mode_dispatch" class="mode_dispatch" value="surface" <?php echo $surface;?>>
                            </label>
                            <br>
                            <br/>
                            <label>Dispatch Details:<br></label><br/>
                            <?php
                            $cash = '';
                            $credit = '';
                            $to_pay = '';
                            $daoc = '';
                            $dispatch_details = $booking[0]['dispatch_details'];
                            if($dispatch_details == 'cash'){
                                $cash = 'checked';
                            }else if($dispatch_details == 'credit'){
                                $credit = 'checked';
                            }else if($dispatch_details == 'To Pay'){
                                $to_pay = 'checked';
                            }else if($dispatch_details == 'daoc'){
                                $daoc = 'checked';
                            }
                            ?>
                            
                            <label>Cash
                                <input type="radio" name="dispatch_details" value="cash" <?php echo $cash;?> >
                            </label>
                            <label>Credit
                                <input type="radio" name="dispatch_details" value="credit" <?php echo $credit;?>>
                            </label>
                            <label>To Pay
                                <input type="radio" name="dispatch_details" value="To Pay" <?php echo $to_pay;?>>
                            </label>
                            <!--<label>DAOC
                                <input type="radio" name="dispatch_details" value="daoc" <?php echo $daoc;?>>
                            </label>  -->
                            <br>
                            <label>Shipment Complete:<br></label><br/>
                            <label>
                                <input <?php echo ($booking[0]['status']) ? 'checked=""' : ''; ?> type="checkbox" name="status" value="1" >Complete Shipment
                            </label>
                            <br>
                            <label>Rate Type:<br></label><br/>
                            <label>
                                <input type="radio" name="rate_type" <?php if($weight[0]['rate_type'] == 'weight') { echo 'checked="checked"'; } ?> value="weight" class="rate_type"  >Weight
                            </label>
                            <label>
                                <input type="radio" name="rate_type" value="no_of_pack" <?php if($weight[0]['rate_type'] == 'no_of_pack') { echo 'checked="checked"'; } ?>  class="rate_type">No of Pack
                            </label>
                            <br>
                        </div><!--box-body-->
                        <div class="box-body">
                            <table>
                                <thead>
                                <th>Charges</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><br>&nbsp; &nbsp;Freight:</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="text" name="frieht" readonly="readonly" value="<?php echo $charges[0]['frieht']; ?>" id="frieht"/></td>
                                    </tr>
                                     <tr>
                                    <td><br>&nbsp; &nbsp;Amount:</td>
                                    <td><br>&nbsp; &nbsp;&nbsp;<input type="text" name="amount" id="amount" value="<?php echo $charges[0]['amount']; ?>"/></td>
                                </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; AWB</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="awb" value="<?php echo $charges[0]['awb']; ?>" id="awb"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; TO pay</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="to_pay" value="<?php echo $charges[0]['to_pay']; ?>" id="to_pat"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; DOC</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="dod_daoc" value="<?php echo $charges[0]['dod_daoc']; ?>" id="dod_doac"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Loading/unloading</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="loading" value="<?php echo $charges[0]['loading']; ?>" id="loading_unloading"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Packing</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="packing" value="<?php echo $charges[0]['packing']; ?>" id="packing"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Handling</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="handling" value="<?php echo $charges[0]['handling']; ?>" id="handling"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; ODA</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="oda" value="<?php echo $charges[0]['oda']; ?>" id="oda"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Insurance</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="insurance" value="<?php echo $charges[0]['insurance']; ?>" id="insurance"></td>
                                    </tr>
                                    <tr>
                                        <td><br>&nbsp; &nbsp; Fuel Surcharge</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="fuel_subcharges" value="<?php echo $charges[0]['fuel_subcharges']; ?>" id="fuel_charges"></td>
                                    </tr>
<!--                                    <tr>
                                        <td><br>&nbsp; &nbsp; Service Tax</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<input type="number" name="service_tax" value="<?php // echo $charges[0]['service_tax']; ?>"></td>
                                    </tr>-->
                                     <input type="hidden" name="gst_charges" id="gst_charges" value="<?php echo $booking[0]['gst_charges']; ?>">
                                    <tr class="gst_charges" <?php if($booking[0]['gst_charges'] == 0) { echo 'style="display:none;"'; }?>>
                                        <td><br>&nbsp; &nbsp; SGST Tax</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<div class="input-group"><input type="number" step="any" value="<?php echo $charges[0]['SGST']; ?>" id="sgst" name="sgst"> <span class="input-group-addon"><i class="fa fa-percent"></i></span></div></td>
                                    </tr>
                                    <tr class="gst_charges" <?php if($booking[0]['gst_charges'] == 0) { echo 'style="display:none;"'; }?>>
                                        <td><br>&nbsp; &nbsp; IGST Tax</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<div class="input-group"><input type="number" step="any" value="<?php echo $charges[0]['IGST']; ?>" id="igst" name="igst"><span class="input-group-addon"><i class="fa fa-percent"></i></span></div></td>
                                    </tr>
                                    <tr class="gst_charges" <?php if($booking[0]['gst_charges'] == 0) { echo 'style="display:none;"'; }?>>
                                        <td><br>&nbsp; &nbsp; CGST Tax</td>
                                        <td><br>&nbsp; &nbsp;&nbsp;<div class="input-group"><input step="any" value="<?php echo $charges[0]['CGST']; ?>" type="number" id="cgst" name="cgst"><span class="input-group-addon"><i class="fa fa-percent"></i></span></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--box-body-->
                    </div><!--box-info-->
                </div><!--col-md-4-->
                <div class="col-sm-3">
                    <div class="box-footer pull-right">
                        <button type="submit" name="submit" id="edit-pod-btn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>	

<?php include 'footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function () {
		getForworderList();
		var forwarderName = "<?php echo $booking[0]['forworder_name']; ?>";
		var selectForwardName = true;
		
        $('#booking_date').datepicker();
        $("#sender_pincode").blur(function () {
            var pincode = $(this).val();
            if (pincode != null || pincode != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>generatepod/getcity',
                    data: 'pincode=' + pincode,
                    success: function (d) {
                        var v = d.toLowerCase();
                        var uppercaseFirstLetter = v.charAt(0).toUpperCase() + v.slice(1);
                        console.log(uppercaseFirstLetter);
                        selectByText($.trim(uppercaseFirstLetter));
                    }
                });
            }
        });

		$(".reciever_pincode").on('change', function() {
			var pincode = $(this).val();
			if (pincode != null || pincode != '') {

				$.ajax({
					type: 'POST',
					url: '<?php echo base_url() ?>generatepod/getcity',
					data: 'pincode=' + pincode,
					dataType: "json",
					success: function(d) {
						var option;
						option += '<option value="' + d.id + '">' + d.city + '</option>';
						$('#reciever_city').html(option);;
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
					success: function(data) {
						
						// $('#forworderName').empty().append(option);
						var mode = $('.mode_dispatch:checked').val();
						var option = '<option value="">Select Forworder Name</option>';
						option += '<option value="micslogistics">MICS Logistics</option>';
						if (mode == 'Air') {
							// option += (data.bluedart_air == 1) ? '<option value="bluedart_air">Bludart Air Service</option>' : '';
							option += (data.bluedart_air == 1) ? '<option value="bluedart_air">Bludart Air Service</option>' : '';
						} else if (mode == 'Train') {
							// option += (data.fedex_regular == 1) ? '<option value="fedex_regular">Fedex Service</option>' : '';
							// option += (data.revigo_regular == 1) ? '<option value="revigo_regular">Revigo Service</option>' : '';
							option += (data.fedex == 1) ? '<option value="fedex_regular">Fedex Service</option>' : '';
							option += (data.revigo == 1) ? '<option value="revigo_regular">Revigo Service</option>' : '';
						} else if (mode == 'Surface') {
							// option += (data.bluedart_surface == 1) ? '<option value="bluedart_surface">Bludart Surface Service</option>' : '';
							// option += (data.fedex_regular == 1) ? '<option value="fedex_regular">Fedex Service</option>' : '';
							// option += (data.revigo_regular == 1) ? '<option value="revigo_regular">Revigo Service</option>' : '';
							option += (data.bluedart_surface == 1) ? '<option value="bluedart_surface">Bludart Surface Service</option>' : '';
							option += (data.fedex == 1) ? '<option value="fedex_regular">Fedex Service</option>' : '';
							option += (data.revigo == 1) ? '<option value="revigo_regular">Revigo Service</option>' : '';
						}
						if (data.spoton_service == 1) {
							option += '<option value="spoton_service">Spoton Service</option>';
						}
						// if (data.delhivery ==1){
						//     option +='<option value="delhivery">DELHIVERY</option>';
						// }

						if (data.delhivery_b2b == 1) {
							option += '<option value="delhivery_b2b">DELHIVERY B2B</option>';
						}

						if (data.delhivery_c2c == 1) {
							option += '<option value="delhivery_c2c">DELHIVERY C2C</option>';
						}

						if (data.delex == 1) {
							option += '<option value="delex_cargo_india">DELEX CARGO INDIA PRIVATE LIMITED</option>';
						}

						// $('#forworderName').empty().append(option);
						$('#forworderName').empty().html(option);
						if (selectForwardName) {
							selectForwardName = false;
							if (forwarderName != '') {
								$('#forworderName').val(forwarderName);

							}
						}
					}
				});
			}

		}
        // $("#reciever_pincode").blur(function () {

        //     var pincode = $(this).val();
        //     if (pincode != null || pincode != '') {

        //         $.ajax({
        //             type: 'POST',
        //             url: '<?php echo base_url() ?>generatepod/getcity',
        //             data: 'pincode=' + pincode,
        //             success: function (d) {

        //                 // alert(d);
        //                 var v = d.toLowerCase();
        //                 var uppercaseFirstLetter = v.charAt(0).toUpperCase() + v.slice(1);
        //                 console.log(uppercaseFirstLetter);
        //                 $('#reciever_city option')
        //                 .filter(function () {
        //                     return $.trim($(this).text()) == uppercaseFirstLetter;
        //                 })
        //                 .attr('selected', true);

        //             }
        //         });
        //     }
        // });


        function selectByText(txt) {
            $('#sender_city option')
            .filter(function () {
                return $.trim($(this).text()) == txt;
            })
            .attr('selected', true);
        }

        // $("#actual_weight, #length, #breath, #height, #no_of_pack, #one_cft_kg").change(function(){
        //     calulate_weight();
        // });
        function calulate_weight(){
            var actual_weight = jQuery("#actual_weight").val();
            var length = jQuery("#length").val();
            var breath = jQuery("#breath").val();
            var height = jQuery("#height").val();
            var one_cft_kg = jQuery("#one_cft_kg").val();
            if(one_cft_kg == ''){
                one_cft_kg = 1;
            }

            var no_of_pack = jQuery("#no_of_pack").val();
            if(no_of_pack == ''){
                no_of_pack = 1;
            }
            
            var valumetric_weight = '';
            var total_valumetric_weight = '';
            if(length !='' && breath !='' && height !='' && no_of_pack !='' && one_cft_kg != '' ){
                valumetric_weight = ((length * breath * height) / 27000) * one_cft_kg * no_of_pack;
                total_valumetric_weight = Math.round(valumetric_weight);
                jQuery("#valumetric_weight").val(total_valumetric_weight);
                calulateTotal();
            }else{
                jQuery("#valumetric_weight").val('');
            }
        }
        // $('#edit-pod-btn').on('click', function() {
        //     if($('#actual_weight').val() == '' && $('#valumetric_weight').val() == '') {
        //         alert('Please add weight detail');
        //         return false;
        //     }
        // });
        $("#sender_city").select2();
        $("#reciever_city").select2();
        $("#customer_account_id").change(function () {
            var customer_name = $(this).val();
            $('#generatePOD')[0].reset();
            if (customer_name != null || customer_name != '') {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>generatepod/getsenderdetails',
                    data: 'customer_name=' + customer_name,
                    success: function (d) {
                        var x = d.split("-");
                        $("#sender").val(x[0]);
                        $("#sender_address").val(x[1]);
                        $("#sender_pincode").val(x[2]);
                        $("#sender_contactno").val(x[3]);
                        $("#sender_gstno").val(x[4]);
                        $("#gst_charges").val(x[5]);
                        $("#customer_account_id").val(customer_name);
                        if(x[5] == 0) {
                            $('.gst_charges').hide();       
                        } else {
                            $('.gst_charges').show();
                        }
                    }
                });
            }
        });
    $("#sender_city, #reciever_city,.mode_dispatch, #actual_weight, #valumetric_weight,#no_of_pack, .rate_type").change(function () {
        calulateTotal();  
    });
    $('#awb,#to_pat,#dod_doac,#loading_unloading,#packing,#handling,#oda,#insurance').change(function(){
        var chargable_weight = parseInt($('#chargable_weight').val()) > 0 ? $('#chargable_weight').val() : 0;
        var rate = parseInt($('#rate').val()) > 0 ? $('#rate').val() : 0;
       // if(rate > 0 && chargable_weight > 0) {
            finalRate();
       // }
    });
    $('#amount').change(function() {
        $('#amount_manual').val(1);
        finalRate();
    });
});

function calulateTotal() {
   var sender_city = $('#sender_city').val();
   var receiver_city = $('#reciever_city').val();
   var mode_dispatch = ($('.mode_dispatch:checked').val() != undefined) ? $('.mode_dispatch:checked').val() : '';
   var customer_name = $('#customer_account_id').val();
   var actual_weight = (parseInt($('#actual_weight').val()) > 0) ? $('#actual_weight').val() : 0;
   var valumetric_weight = parseInt($('#valumetric_weight').val()) > 0 ? $('#valumetric_weight').val() : 0;
   var rate_type = $('.rate_type:checked').val();
   var no_of_pack = parseInt($('#no_of_pack').val()) > 0 ? $('#no_of_pack').val() : 0;
    console.log('sender_city = '+sender_city);
    console.log('receiver_city = '+receiver_city);
    console.log('mode_dispatch =' +mode_dispatch);
    console.log('actual_weight =' + actual_weight);
    console.log('valumetric_weight = '+valumetric_weight);
    console.log('customer_name ='+customer_name);
                    
   if ((((actual_weight > 0 || valumetric_weight > 0 ) && rate_type == 'weight') || (rate_type == 'no_of_pack' && no_of_pack)) && customer_name != null && customer_name != '' && sender_city !='' && receiver_city != '' && receiver_city !='undefined' && mode_dispatch !='') {
       $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?php echo base_url() ?>generatepod/getRateMasterDetails',
            data: 'customer_name='+customer_name+'&sender_city='+ sender_city+'&receiver_city='+receiver_city+'&mode_dispatch='+mode_dispatch+'&rate_type='+rate_type+'&no_of_pack='+no_of_pack,
            success: function (data) {
                var dod_doac = data.rate_master!==undefined && parseInt(data.rate_master.dod_doac) > 0 ? parseInt(data.rate_master.dod_doac) : 0;
                var weight_range = data.rate_master!==undefined && parseInt(data.rate_master.weight_range) > 0 ?  parseInt(data.rate_master.weight_range) : 0;
                var loading_unloading = data.rate_master!==undefined && parseInt(data.rate_master.loading_unloading) > 0 ? data.rate_master.loading_unloading : 0 ;
                var packing = data.rate_master!==undefined && (parseInt(data.rate_master.packing) > 0 ) ? parseInt(data.rate_master.packing) : 0;
                var handling = data.rate_master!==undefined && (parseInt(data.rate_master.handling) > 0 )? parseInt(data.rate_master.handling) :0;
                var insurance  = data.rate_master!==undefined && (parseInt(data.rate_master.insurance) > 0 ) ? parseInt(data.rate_master.insurance) : 0;
                var fuel_charges = data.rate_master!==undefined && (parseInt(data.rate_master.fuel_charges) > 0) ? parseInt(data.rate_master.fuel_charges) : 0;
                var rate = data.rate_master!==undefined &&  (parseInt(data.rate_master.rate) > 0) ? parseInt(data.rate_master.rate) : 0;
                var rate_pack = (data.rate_master_pack !=undefined && parseInt(data.rate_master_pack.rate) > 0) ? parseInt(data.rate_master_pack.rate) : 0;
                var awb = parseInt($('#awb').val()) > 0 ? $('#awb').val() : 0;
                var oda = parseInt($('#oda').val()) > 0 ? $('#oda').val() : 0;
                var cft = data.rate_master!==undefined &&  (parseInt(data.rate_master.cft) > 0) ? parseInt(data.rate_master.cft) : 1;
                var actual_weight = parseInt($('#actual_weight').val()) > 0 ? $('#actual_weight').val() : 0;
                var chargable_weight = actual_weight;
                var eod = data.rate_master!==undefined ?  data.rate_master.eod : '';
                $('#eod').val(eod);  
                console.log('ac Weight'+chargable_weight);
                if(parseInt(valumetric_weight) > parseInt(chargable_weight)) {
                    chargable_weight = valumetric_weight;
                } 
                console.log('weight_range'+weight_range);
                if(parseInt(weight_range) > parseInt(chargable_weight)) {
                   chargable_weight = weight_range; 
                } 
                console.log('cw'+chargable_weight);
                $('#chargable_weight').val(chargable_weight);
                $('#rate').val(rate);
                $('#one_cft_kg').val(cft);
                $('#dod_doac').val(dod_doac);
                $('#loading_unloading').val(loading_unloading);
                $('#packing').val(packing);
                $('#handling').val(handling);
                $('#insurance').val(insurance);
                $('#rate_pack').val(rate_pack);
                finalRate(fuel_charges);
            }
        });
    }   
}

function finalRate(fuel_charges) {
    var total_charge = 0;
    var total_pay = 0;
    var dod_doac =parseInt($('#dod_doac').val()) > 0 ?  $('#dod_doac').val() : 0;
    var packing = parseInt($('#packing').val()) > 0 ? $('#packing').val() : 0;
    var loading_unloading =parseInt($('#loading_unloading').val()) ? $('#loading_unloading').val() : 0;
    var handling = parseInt($('#handling').val()) > 0 ? $('#handling').val() : 0;
    var insurance = parseInt($('#insurance').val()) > 0 ? $('#insurance').val() : 0;
    var gst_charges = $('#gst_charges').val();
    var awb = parseInt($('#awb').val()) > 0 ? $('#awb').val() : 0;
    var oda = parseInt($('#oda').val()) > 0 ? $('#oda').val() : 0;
    var to_pat = parseInt($('#to_pat').val()) > 0 ? $('#to_pat').val() : 0;
    var rate_type = $('.rate_type:checked').val();
    var no_of_pack = parseInt($('#no_of_pack').val()) > 0 ? $('#no_of_pack').val() : 0;
    var fuel_charges = parseInt($('#fuel_charges').val()) > 0 ? $('#fuel_charges').val() : 0; 
        total_pay = $('#amount').val() ? $('#amount').val() : 0;
        // console.log('Total Pay' + total_pay);
        // console.log('chargable Weight' + chargable_weight);
  
        // console.log('Chargable Weight' + chargable_weight);
        // console.log('Fuel Charges' + fuel_charges);
        // console.log('Dod Doac' +dod_doac);
        // console.log('Loading Unloading' +loading_unloading);
        // console.log('Packing' +packing);
        // console.log('Handling' +handling);
        // console.log('Insurance' +insurance);
        // console.log('AWB' + awb);
        // console.log('ODA' + oda);                    
        // console.log('To pay' + total_pay);                    
        
        total_charge = parseInt(total_pay) + parseInt(fuel_charges) + parseInt(dod_doac) + parseInt(loading_unloading) + parseInt(packing) + parseInt(handling) + parseInt(insurance) + parseInt(oda)+ parseInt(awb) + parseInt(to_pat);
        // console.log('total_pay' + total_pay);
        // console.log('Fuel Charges' + fuel_charges);
        // console.log('Dod Doac' +dod_doac);
        // console.log('Loading Unloading' +loading_unloading);
        // console.log('Packing' +packing);
        // console.log('Handling' +handling);
        // console.log('Insurance' +insurance);
        // console.log('AWB' + awb);
        // console.log('ODA' + oda);                    
        // console.log('To pay' + to_pat);  
        var igst = 0;
		var sgst = Math.round(total_charge * 9)/100;
		var cgst = Math.round(total_charge * 9)/100;
		igst = Math.round(sgst + cgst);
		$('#sgst').val(sgst);
		$('#cgst').val(cgst);
		$('#igst').val(igst);
        
    //    console.log('Total Chargeable Pay' + total_charge);
        var frieht = parseInt(total_charge) + parseInt(igst);
        $('#frieht').val(frieht);
//Success!
      //  console.log('Frieht' + frieht);
    
}
</script>
