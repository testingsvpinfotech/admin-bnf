/* Document.ready Start */
jQuery(document).ready(function () {

     
	/* ############################# select2 library Start ##################################### */ 
		// Manifeted genrated selected 
		$('#destination_branch').select2();
		$('#route_id').select2();
		$('#vendor_id').select2();
		$('#forwarderName').select2();
		$('#coloader').select2();
		$('#forwarder_mode').select2();
		$('#supervisor').select2();
	
		//  add/edit shipment select library 
		$("#customer_account_id").select2();
		$("#sender_state").select2();
		$("#sender_city").select2();
		$("#reciever_state").select2();
		$("#reciever_city").select2();
		$("#mode_dispatch").select2();
		$("#risk_type").select2();
		$("#dispatch_details").select2();
		$("#doc_typee").select2();
		$("#doc_type").select2();
		$('#user_id').select2();
		$('#type').select2();

        // franchise filter 
		$('.filter-data').select2();
	
	/* ############################# select2 library End ##################################### */ 
	
	/*############################## Basic Validation start ################################## */
		(function ($) {
			$.fn.inputFilter = function (callback, errMsg) {
				return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function (e) {
					if (callback(this.value)) {
						// Accepted value
						if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
							$(this).removeClass("input-error");
							this.setCustomValidity("");
						}
						this.oldValue = this.value;
						this.oldSelectionStart = this.selectionStart;
						this.oldSelectionEnd = this.selectionEnd;
					} else if (this.hasOwnProperty("oldValue")) {
						// Rejected value - restore the previous one
						$(this).addClass("input-error");
						this.setCustomValidity(errMsg);
						this.reportValidity();
						this.value = this.oldValue;
						this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
					} else {
						// Rejected value - nothing to restore
						this.value = "";
					}
				});
			};
		}(jQuery));
	
		// Integer value allowed only 
		$("#sender_pincode,#sender_contactno,#reciever_pincode,#reciever_contact,#no_of_pack1,.per_box_weight,.manifest_driver_contact,.manifest_coloader_contact,#credit_days,#pincode,#cmppincode").inputFilter(function (value) {
			return /^\d*$/.test(value);    // Allow digits only, using a RegExp
		}, "Only Numbers allowed");
	
		// Decimal value allowed only 
		$('#invoice_value,#actual_weight,#chargable_weight,.length,.breath,.height,.valumetric_actual,#credit_limit').keypress(function (event) {
			if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
				$(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) || $(this).val().indexOf('.') !== -1 && event.keyCode == 190) {
				event.preventDefault();
			}
		}).on('paste', function (event) {
			event.preventDefault();
		});
	
	/*############################## Basic Validation End ################################## */
	
	/*############################## Add/Edit shipment start ############################### */
	
		// by default value matric row hide 
		$("#volumetric_table").hide();
		// focusing lr only 
		$("#awn").focus();
		//  third party shipment only 
		var length_detail = $("#length_detail").val();
		if (length_detail != '') {
			$("#volumetric_table").show();
		}
		
		var courier_company_name = $("#courier_company option:selected").attr('data-id');
		$('#forworder_name').val(courier_company_name);
	
		$("#courier_company").change(function () {
			var courier_company_name = $("#courier_company option:selected").attr('data-id');
			$('#forworder_name').val(courier_company_name);
		});
	
		// Add/Edit shipment invoice and FOC validation or Notification 	
		$('#invoice_value').blur(function () {
			var bill_type = $('#dispatch_details').val();
			if (bill_type != 'FOC') {
			var inv = $(this).val();
			if (parseInt(inv) > 0 && 10000000 > parseInt(inv)) {
	
			}
			else {
	
				alertify.alert("Invoice value Alert!", "Invoice value should be greater than 0 and less than 1 Crore. </br> If not available please enter 1 ₹",
					function () {
						alertify.success('Ok');
					});
				//$('#invoice_value').val('');
			}
			$('#invoice_value').prop('required', true);
		
			}
			else
			{
			var customer_account_id = $('#customer_account_id').val();
			if(customer_account_id=='118')
			{
				$('#frieht').prop('required', false);
			}
			$('#invoice_value').prop('required', false);
			}
		});
	
		// accordingly bill_type show charges input values 
		$("#dispatch_details").on('change', function () {
			// clean rates 
			$('#actual_weight').val('');
			$('#chargable_weight').val('');
			$('#no_of_pack1').val('');
			$('#frieht').val('');
			$('#pickup_charges').val('0');
			$('#delivery_charges').val('0');
			$('#insurance_charges').val('');
			$('#courier_charges').val('0');
			$('#awb_charges').val('0');
			$('#other_charges').val('0');
			$('#green_tax').val('0');
			$('#appt_charges').val('0');
			$('#fov_charges').val('0');
			$('#amount').val('0');
			$('#fuel_charges').val('0');
			$('#address_change').val('');
			$('#dph').val('0');
			$('#warehousing').val('');
			$('#lable').val('');
			$('#payment_method').val('');
			$('#refer_no').val('');
			$('#sub_total').val('0');
			$('#cgst').val('0');
			$('#sgst').val('0');
			$('#igst').val('0');
			$('#grand_total').val('0');
	
			var dispatch_details = $("#dispatch_details").val();
			//	alert(dispatch_details);
			if (dispatch_details == "Credit") {
				$("#customer_account_id").attr("required", "required");
			}
			else {
				$("#customer_account_id").removeAttr("required");
			}
			if (dispatch_details == "Credit") {
				$("#credit_div").show();
				$("#credit_div_label").show();
				$("#payby").hide();
				$("#Refno").hide();
	
				$("#sub_total").attr("readonly", true);
				$("#grand_total").attr("readonly", true);
			}
			else if (dispatch_details == "Cash") {
	
				$("#credit_div").show();
				$("#credit_div_label").show();
				$("#payby").show();
				$("#Refno").show();
				$("#sender_name").attr("readonly", false);
				$("#sender_address").attr("readonly", false);
				$("#sender_city").attr("readonly", false);
				$("#sender_pincode").attr("readonly", false);
				$("#sender_contactno").attr("readonly", false);
				$("#sender_gstno").attr("readonly", false);
				$("#sub_total").attr("readonly", true);
				$("#grand_total").attr("readonly", true);
			}
			if (dispatch_details == "Credit") {
				var user_type = $("#usertype").val();
				if (user_type != 1) {
					// $('#frieht').hide();
					$('#transportation_charges').hide();
					$('#pickup_charges').hide();
					$('#delivery_charges').show();
					$('#courier_charges').hide();
					$('#insurance_charges').hide();
					$('#other_charges').show();
					$('#amount').hide();
					$('#fuel_charges').hide();
					$('#sub_total').hide();
					$('#cgst').hide();
					$('#sgst').hide();
					$('#igst').hide();
					$('#awb_charges').hide();
					$('#fov_charges').hide();
					$('#grand_total').hide();
					$('#cft').hide();
				}
			}
			else {
				$('#frieht').show();
				$('#transportation_charges').show();
				$('#pickup_charges').show();
				$('#delivery_charges').show();
				$('#courier_charges').show();
				$('#insurance_charges').show();
				$('#other_charges').show();
				$('#amount').show();
				$('#fuel_charges').show();
				$('#sub_total').show();
				$('#cgst').show();
				$('#sgst').show();
				$('#igst').show();
				$('#awb_charges').show();
				$('#fov_charges').show();
				$('#grand_total').show();
				$('#cft').show();
	
			}
	
			if (dispatch_details != "Cash") {
	
				calculate_cft();
	
			}
	
		});
	
	
		// Reset all charges after change mode 
		$("#mode_dispatch").change(function () {
			// clean rates 
			$('#actual_weight').val('');
			$('#chargable_weight').val('');
			$('#no_of_pack1').val('');
			$('#frieht').val('');
			$('#pickup_charges').val('0');
			$('#delivery_charges').val('0');
			$('#insurance_charges').val('');
			$('#courier_charges').val('0');
			$('#awb_charges').val('0');
			$('#other_charges').val('0');
			$('#green_tax').val('0');
			$('#appt_charges').val('0');
			$('#fov_charges').val('0');
			$('#amount').val('0');
			$('#fuel_charges').val('0');
			$('#address_change').val('');
			$('#dph').val('0');
			$('#warehousing').val('');
			$('#lable').val('');
			$('#payment_method').val('');
			$('#refer_no').val('');
			$('#sub_total').val('0');
			$('#cgst').val('0');
			$('#sgst').val('0');
			$('#igst').val('0');
			$('#grand_total').val('0');
		});
	
		// getting customer info 
		$("#customer_account_id").change(function () {
			var customer_name = $(this).val();
			if (customer_name != null || customer_name != '') {
				$.ajax({
					type: 'POST',
					dataType: "json",
					url: 'Admin_domestic_shipment_manager/getsenderdetails',
					data: 'customer_name=' + customer_name,
					success: function (data) {
						//   console.log(data);	
						//   console.log(data.user);	
						//   console.log(data.user.customer_name);	
						$("#sender_name").val(data.user.customer_name);
						$("#sender_address").val(data.user.address);
						$("#sender_pincode").val(data.user.pincode);
						$("#sender_contactno").val(data.user.phone);
						$("#sender_gstno").val(data.user.gstno);
						$("#gst_charges").val(data.user.gst_charges);
						$("#statecode").val(data.user.statecode);				
						$("#customer_account_id").val(customer_name);
						$("#sender_name").trigger("change");
						$("#sender_address").trigger("change");
						$("#sender_pincode").trigger("change");
						$("#sender_contactno").trigger("change");
						$("#sender_gstno").trigger("change");
						$("#gst_charges").trigger("change");
						var option;
						option += '<option value="' + data.user.city_id + '">' + data.user.city_name + '</option>';
						$('#sender_city').val(data.user.city_id);
						var option1;
						option1 += '<option value="' + data.user.state_id + '">' + data.user.state_name + '</option>';
						$('#sender_state').val(data.user.state_id);
						var dispatch_details = $("#dispatch_details").val();
						if (dispatch_details != "Cash") {
						   var cft = parseFloat($("#cft").val());
						   if(isNaN(cft)){	var cft = 0;}
				           if(cft==0 || cft==''){
							  calculate_cft();
						   }
						}
						document.getElementById("reciever").focus();
						$("#sender_city").trigger("change");
						$("#sender_state").trigger("change");

						// Call Ajax required data fuel price ,gst percentage
						var fuelprice =$('#fuelprice').val();
						if(fuelprice!=0 || fuelprice !=''){
						   getGSTAccess();
						}
					}
				});
			}
		});
	    
		$('.customer_show').on('change',function(){
			customerStock_Auth();
		});
		$('#awn').on('blur',function(){
			customerStock_Auth();
		});

		function customerStock_Auth(){
			var LR = $('#awn').val();
			var customer_id = $('.customer_show').val();
			if(LR !=''&&customer_id!='')
			{
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/customerStock_Auth',
					data: {
						customer_id: customer_id,
						LR: LR
					},
					dataType: "json",
					success: function (data) {
	                  if(data.stock==1){
						$('#awn').prop('readonly', true);
					  }else{
						 $('#awn').prop('readonly', false);
						 alertify.alert('Customer Stock Alert!','This Customer Not Assign Stock Please Contact to Admin',
							function () {
								alertify.success('Ok');
							});
							$('#awn').val('');
						return false;
					  }
	
					}
				});
			}
		}

		// API 
		function getGSTAccess()
		{
			var dispatch_details = $('#dispatch_details').val();
			var customer_id = $('#customer_account_id').val();
			var sender_gstno = $('#sender_gstno').val();
			if (dispatch_details == 'Cash') {
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/getCashAccess',
					data: {
						customer_id: customer_id,
						sender_gstno: sender_gstno
					},
					dataType: "json",
					success: function (data) {
	
						$('#per_cgst').val(data.cgst);
						$('#per_sgst').val(data.sgst);
						$('#per_igst').val(data.igst);
						$('#branch_gst').val(data.branch_gst);
						$('#sender_gst').val(data.sender_gst);
	
					}
				});
			}else{
				var courier_id = parseFloat(($('#courier_company').val() != '') ? $('#courier_company').val() : 0);
				var booking_date = $('#booking_date').val();
				var customer_id = $('#customer_account_id').val();
                $.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/getFuelprice',
					data: 'courier_id=' + courier_id + '&booking_date=' + booking_date + '&customer_id=' + customer_id,
					dataType: "json",
					success: function (data) {
							$('#igst_or_other').val(data.custAccess);
							$('#fuelprice').val(data.fuelPrice);
							$('#fuel_charge').val(data.fuel_charge);
							$('#per_cgst').val(data.cgst);
							$('#per_sgst').val(data.sgst);
							$('#per_igst').val(data.igst);
					}
				}); 
			}
		}

		//   Edit Operation all here 
		// window.onload = function () {
			// for edit case required to min_weight page reloade case 
			var text = window.location.pathname;
			const edit_shipment = text.split("/", 5);
			// alert(edit_shipment);
			if(edit_shipment[2]=='view-edit-domestic-shipment' || edit_shipment[2] == 'admin-edit-view-list')
			{   
	            // call Min weight Ajax 
				var min_w = parseFloat($("#min_weight").val());
				if (min_w == 0) {
					getCharagableWeight();
				}
		       
                // In Edit shipment case cft input are empty run time cft calculate
				var dispatch_details = $("#dispatch_details").val();
				var cft = parseFloat($("#cft").val());
				if(isNaN(cft)){	var cft = 0;}
				if(cft==0){
					if (dispatch_details != "Cash") {
						calculate_cft();
					}
			    }

				// Call Ajax required data fuel price ,gst percentage
				  var fuelprice =$('#fuelprice').val();
				  if(fuelprice!=0 || fuelprice !=''){
					getGSTAccess();
				  }
				  
			}
		// }
	
		// Consignee   Pincode
		$("#sender_pincode").on('blur', function () {
			var pincode = $(this).val();
			if (pincode != '') {
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/getCityList',
					data: 'pincode=' + pincode,
					dataType: "json",
					success: function (data) {
						if (data.status == 'failed') {
							$('#sender_city').val("");
							$('#sender_state').val("");
							alertify.alert(data.message,
								function () {
									alertify.success('Ok');
								});
							return false;
						} else {
							$('#sender_city').val(data.city_id);
							$('#sender_state').val(data.state_id);
						}
						$("#sender_city").trigger("change");
						$("#sender_state").trigger("change");
					}
				});
				$("#sender_state").trigger("change");
			}
			// else
			// {
			// 	var state = '<option value="">Select State</option>';		
			// 	var city = '<option value="">Select City</option>';		
			// 	$('#sender_city').html(city);
			// 	$('#sender_state').html(state);
			// }
		});
	
		// get customer accordingly bill type 
		$("#dispatch_details").change(function () {
			var dispatch_details = $('#dispatch_details').val();
			if (dispatch_details == 'Cash') {
	
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/getCustomer',
					data: 'dispatch_details=' + dispatch_details,
					dataType: "json",
					success: function (data) {
						if (data.status == 'failed') {
							$('#sender_city').val("");
							$('#sender_state').val("");
							//alert(data.message);
							alertify.alert(data.message,
								function () {
									alertify.success('Ok');
								});
							return false;
						} else {
							$('.customer_show').html(data);
	
						}
						$("#sender_city").trigger("change");
						$("#sender_state").trigger("change");
	
	
					}
				});
			} else {
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/getCustomerlist',
					data: 'dispatch_details=' + dispatch_details,
					dataType: "json",
					success: function (data) {
						if (data.status == 'failed') {
							$('#sender_city').val("");
							$('#sender_state').val("");
							// alert(data.message);
							alertify.alert(data.message,
								function () {
									alertify.success('Ok');
								});
							return false;
						} else {
							$('.customer_show').html(data);
	
						}
						$("#sender_city").trigger("change");
						$("#sender_state").trigger("change");
					}
				});
			}
		});
	
		

		//  calcualte min weight auto 
		function ChargableWeightCalcu(){
			var data = parseFloat($("#min_weight").val());
			var chargable_weight = parseFloat($("#chargable_weight").val());
							var valumetric_chageable = parseFloat($("#valumetric_chageable").val());
							var actual_weight = parseFloat($("#actual_weight").val());
							if (isNaN(data)) {
								var data = 0;
							}
							if (isNaN(actual_weight)) {
								var actual_weight = 0;
							}
							if (isNaN(chargable_weight)) {
								var chargable_weight = 0;
							}
							if (isNaN(valumetric_chageable)) {
								var valumetric_chageable = 0;
							}
							// Admin edit shipment 
							if (valumetric_chageable != 0) {
								if (data >= actual_weight && data >= valumetric_chageable) {
									$("#chargable_weight").val(data);
								}
								else {
									if (actual_weight >= valumetric_chageable) {
										if (data <= actual_weight) {
											$("#chargable_weight").val(actual_weight);
										}
										else {
											$("#chargable_weight").val(data);
										}
									}
									else {
										if (data <= valumetric_chageable) {
											$("#chargable_weight").val(valumetric_chageable);
										}
										else {
											$("#chargable_weight").val(data);
										}
									}
								}
							}
							else {
								if (data <= actual_weight) {
									$("#chargable_weight").val(actual_weight);
								}
								else {
									$("#chargable_weight").val(data);
								}
							}
		}

		// Consignee  Pincode get city,state,zone
		$("#reciever_pincode").on('blur', function () {
			var pincode = $(this).val();
			var booking_date = $('#booking_date').val();
			var mode_dispatch = $('#mode_dispatch').val();
			var sender_state = $('#sender_state').val();
			var sender_city = $('#sender_city').val();
			if (pincode != '') {
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/getCityList',
					data: 'pincode=' + pincode + '&booking_date=' + booking_date + '&mode_dispatch=' + mode_dispatch + '&sender_city=' + sender_city + '&sender_state=' + sender_state,
					dataType: "json",
					success: function (data) {
						console.log(data.status);
						if (data.status == 'failed') {
							$('#reciever_city').val("");
							$('#reciever_state').val("");
							$('#isoda').html('');
							alertify.alert('NSS Pin Code Alert!', data.message,
								function () {
									alertify.success('Ok');
								});
							return false;
						} else {
							$('#reciever_city').val(data.city_id);
							$('#reciever_state').val(data.state_id);
							$('#delivery_date').val(data.edd_date);
							$('#isoda').html('');
							getZone();
						}
						$('#forworder_name').html(data.forwarder2);
						$('#isoda').html(data.isODA);
						$('#final_branch_id').val(data.final_branch_id);
						$('#final_branch_name').val(data.final_branch_name);
						$('#statecode').val(data.statecode);
						$("#reciever_city").trigger("change");
						$("#forworder_name").trigger("change");
						$("#isoda").trigger("change");
						$("#final_branch_id").trigger("change");
						$("#final_branch_name").trigger("change");
						$("#reciever_state").trigger("change");
					},
					error: function () {
						$('#isoda').html('<p>Service Not Available</p>');		
						$('#reciever_city').val('');
						$('#reciever_state').val('');
						$('#forworder_name').val('');
						$("#reciever_city").trigger("change");
						$("#forworder_name").trigger("change");
						$("#isoda").trigger("change");
						$("#final_branch_id").trigger("change");
						$("#final_branch_name").trigger("change");
						$("#reciever_state").trigger("change");
					}
				});
			}
			// else
			// {
			// 	var state = '<option value="">Select State</option>';		
			// 	var city = '<option value="">Select City</option>';		
			// 	$('#reciever_city').html(city);
			// 	$('#reciever_state').html(state);
			// 	$('#receiver_zone').val('');
			// 	$('#receiver_zone_id').val('');
			// 	$('#isoda').html('');
			// }
	
		});
	
		// Get Zone
		function getZone() {
			var reciever_state = $("#reciever_state").val();
			var reciever_city = $("#reciever_city").val();
			var reciever_pincode = $("#reciever_pincode").val();
			$.ajax({
				type: 'POST',
				url: 'Admin_domestic_shipment_manager/getZone',
				data: { reciever_state: reciever_state, reciever_city: reciever_city, reciever_pincode: reciever_pincode },
				dataType: "json",
				success: function (d) {
					$("#receiver_zone_id").val(0);
					$("#receiver_zone").val("");
					$("#receiver_zone_id").val(d.region_id);
					$("#receiver_zone").val(d.region_name);
					// console.log(d.region_name);	
					if ($('#receiver_zone_id').val() !== ''
						&& $('#receiver_zone').val() !== ''
						&& $('#sender_pincode').val() !== ''
						&& $('#mode_dispatch').val() !== ''
						&& $('#dispatch_details').val() !== ''
						&& $('#doc_typee').val() !== ''
						&& $('#customer_account_id').val() !== ''
					) {
						$('#no_of_pack1').prop('readonly', false);
						$('#actual_weight').prop('readonly', false);
						$('#chargable_weight').prop('readonly', true);
						$('#transportation_charges').prop('readonly', false);
						$('#pickup_charges').prop('readonly', false);
						$('#delivery_charges').prop('readonly', false);
						$('#insurance_charges').prop('readonly', false);
						$('#courier_charges').prop('readonly', false);
						$('#other_charges').prop('readonly', false);
						$('#green_tax').prop('readonly', false);
						$('#appt_charges').prop('readonly', false);
						$('.unblock_charges').prop('readonly', false);
						if ($('#dispatch_details').val() == 'Cash') {
							$('#payment_method').prop('disabled', false);
							$('#payment_method').attr('required', false);
							$('#refer_no').prop('readonly', false);
							$('#sgst').attr('required', true);
							$('#cgst').attr('required', true);
						}
					}
					// NSS Pincode allowed Zero fright booking & Foc Customer Allowed Zero Fright Booking
					var customer_id = $('#customer_account_id').val();
					var bill_type = $('#dispatch_details').val();
					var service_type = $('#isoda').html();
					if ((bill_type == 'Credit' && service_type == 'Service Type : NSS') || (bill_type == 'Credit' && customer_id == '118')) {
						$("#frieht").prop('required', false);
					}
					else {
						$("#frieht").prop('required', true);
					}
	
				}
			});
			// blocking charges without zone
			$('#receiver_zone').val('');
			$('#receiver_zone_id').val('');
			$('#no_of_pack1').prop('readonly', true);
			$('#actual_weight').prop('readonly', true);
			$('#chargable_weight').prop('readonly', true);
			$('#transportation_charges').prop('readonly', true);
			$('#pickup_charges').prop('readonly', true);
			$('#delivery_charges').prop('readonly', true);
			$('#insurance_charges').prop('readonly', true);
			$('#courier_charges').prop('readonly', true);
			$('#awb_charges').prop('readonly', true);
			$('#other_charges').prop('readonly', true);
			$('#green_tax').prop('readonly', true);
			$('#appt_charges').prop('readonly', true);
			$('#fov_charges').prop('readonly', true);
			$('#fuel_charges').prop('readonly', true);
			$('#payment_method').prop('disabled', true);
			$('#refer_no').prop('readonly', true);
			$('#grand_total').prop('readonly', true);
			$('#sub_total').prop('readonly', true);
			$('.unblock_charges').prop('readonly', true);
			$("#receiver_zone_id").trigger("change");
			$("#receiver_zone").trigger("change");
			$("#receiver_zone_id").trigger("change");
			$("#receiver_zone").trigger("change");
	
		}
	
		// Get Min accordingly Actual weight range 
		function getCharagableWeight() {
	
			if ($('#is_appointment').is(':checked')) {
				var is_appointment = 1;
			}
			else {
				var is_appointment = 0;
			}
			var customer_id = $('#customer_account_id').val();
			var c_courier_id = $('#courier_company').val();
			var mode_id = $('#mode_dispatch').val();
			var sender_state = $("#sender_state").val();
			var sender_city = $("#sender_city").val();
			var state = $("#reciever_state").val();
			var city = $("#reciever_city").val();
			var doc_type = $("#doc_typee").val();
			var actual_weight = $("#actual_weight").val();
			var receiver_zone_id = $("#receiver_zone_id").val();
			var receiver_gstno = $("#receiver_gstno").val();
			var booking_date = $('#booking_date').val();
			var dispatch_details = $('#dispatch_details').val();
			var invoice_value = $('#invoice_value').val();
			var invoice_value = parseFloat(($('#invoice_value').val() != '') ? $('#invoice_value').val() : 0);
			var chargable_weight = parseFloat($('#chargable_weight').val()) > 0 ? $('#chargable_weight').val() : 0;
			let packet = $("#no_of_pack1").val();
			if (dispatch_details == 'ToPay' && invoice_value == '') {
				alertify.alert("Invoice value required </br> Please Fillup Inv. Value*",
					function () {
						alertify.success('Ok');
					});
			}
			if (actual_weight > 0) {
				//alert(actual_weight);
				if (customer_id != '' && mode_id != '' && actual_weight != '') {
					$.ajax({
						type: 'POST',
						url: 'Admin_domestic_shipment_manager/check_rate',
						data: 'packet=' + packet + '&customer_id=' + customer_id + '&c_courier_id=' + c_courier_id + '&mode_id=' + mode_id + '&state=' + state + '&city=' + city + '&chargable_weight=' + chargable_weight + '&receiver_zone_id=' + receiver_zone_id + '&receiver_gstno=' + receiver_gstno + '&booking_date=' + booking_date + '&invoice_value=' + invoice_value + '&dispatch_details=' + dispatch_details + '&sender_state=' + sender_state + '&sender_city=' + sender_city + '&is_appointment=' + is_appointment + '&actual_weight=' + actual_weight,
						dataType: "json",
						success: function (data) {
							// console.log(data);
							// alert(data);
							$("#min_weight").val(data);
							var chargable_weight = parseFloat($("#chargable_weight").val());
							var valumetric_chageable = parseFloat($("#valumetric_chageable").val());
							var actual_weight = parseFloat($("#actual_weight").val());
							if (isNaN(actual_weight)) {
								var actual_weight = 0;
							}
							if (isNaN(chargable_weight)) {
								var chargable_weight = 0;
							}
							if (isNaN(valumetric_chageable)) {
								var valumetric_chageable = 0;
							}
							// Admin edit shipment 
							if (valumetric_chageable != 0) {
								if (data >= actual_weight && data >= valumetric_chageable) {
									$("#chargable_weight").val(data);
								}
								else {
									if (actual_weight >= valumetric_chageable) {
										if (data <= actual_weight) {
											$("#chargable_weight").val(actual_weight);
										}
										else {
											$("#chargable_weight").val(data);
										}
									}
									else {
										if (data <= valumetric_chageable) {
											$("#chargable_weight").val(valumetric_chageable);
										}
										else {
											$("#chargable_weight").val(data);
										}
									}
								}
							}
							else {
								if (data <= actual_weight) {
									$("#chargable_weight").val(actual_weight);
								}
								else {
									$("#chargable_weight").val(data);
								}
							}
	
						},
						error: function () {
							// $("#chargable_weight").val('');
						}
					});
				}
			}
			///calculateTotalWeight();
		}


		
	
		// Get normal weight means not Perbox 
		function getRate(update) {
			if ($('#is_appointment').is(':checked')) {
				var is_appointment = 1;
			}
			else {
				var is_appointment = 0;
			}
			var customer_id = $('#customer_account_id').val();
			var c_courier_id = $('#courier_company').val();
			var mode_id = $('#mode_dispatch').val();
			var sender_state = $("#sender_state").val();
			var sender_city = $("#sender_city").val();
			var state = $("#reciever_state").val();
			var city = $("#reciever_city").val();
			var doc_type = $("#doc_typee").val();
			var receiver_zone_id = $("#receiver_zone_id").val();
			var receiver_gstno = $("#receiver_gstno").val();
			var booking_date = $('#booking_date').val();
			var dispatch_details = $('#dispatch_details').val();
			var invoice_value = $('#invoice_value').val();
			var invoice_value = parseFloat(($('#invoice_value').val() != '') ? $('#invoice_value').val() : 0);
	
			var chargable_weight = parseFloat($('#chargable_weight').val()) > 0 ? $('#chargable_weight').val() : 0;
			var actual_weight = parseFloat($('#actual_weight').val()) > 0 ? $('#actual_weight').val() : 0;
			let packet = $("#no_of_pack1").val();
			if (dispatch_details == 'ToPay' && invoice_value == '') {
				alert('Please Fillup Inv. Value*');
			}
			// if (chargable_weight > 0) {
			if (customer_id != '' && mode_id != '') {
				$.ajax({
					type: 'POST',
					url: 'Admin_domestic_shipment_manager/add_new_rate_domestic',
					data: 'packet=' + packet + '&customer_id=' + customer_id + '&c_courier_id=' + c_courier_id + '&mode_id=' + mode_id + '&state=' + state + '&city=' + city + '&chargable_weight=' + chargable_weight + '&receiver_zone_id=' + receiver_zone_id + '&receiver_gstno=' + receiver_gstno + '&booking_date=' + booking_date + '&invoice_value=' + invoice_value + '&dispatch_details=' + dispatch_details + '&sender_state=' + sender_state + '&sender_city=' + sender_city + '&is_appointment=' + is_appointment + '&actual_weight=' + actual_weight,
					dataType: "json",
					success: function (data) {
	
						console.log(data);
						$('#frieht').val(data.frieht);
						if (update) {
	
						} else {
	
							// $('#transportation_charges').val(0);
							// $('#pickup_charges').val(0);
							// $('#delivery_charges').val(0);
							// $('#insurance_charges').val(0);
						}
						if (data.frieht == '0') {
							$('#frieht').val('');
							// alert(data.frieht);
							var table_row = $('#volumetric_table_row tr').length;
							getPerBox_fright(table_row);
						} else {
								var courier_charges = parseFloat($('#courier_charges').val());
								if(isNaN(courier_charges)){	var courier_charges = 0;}
								var green_tax = parseFloat($('#green_tax').val());
								if(isNaN(green_tax)){	var green_tax = 0;}
								var fuel_charges = parseFloat($('#fuel_charges').val());
								if(isNaN(fuel_charges)){	var fuel_charges = 0;}
								var awb_charges = parseFloat($('#awb_charges').val());
								if(isNaN(awb_charges)){	var awb_charges = 0;}
								var fov_charges = parseFloat($('#fov_charges').val());
								if(isNaN(fov_charges)){	var fov_charges = 0;}
								var appt_charges = parseFloat($('#appt_charges').val());
								if(isNaN(appt_charges)){	var appt_charges = 0;}
	
								if(data.cod>=courier_charges){$('#courier_charges').val(data.cod);}
								if(data.to_pay_charges>=green_tax){$('#green_tax').val(data.to_pay_charges);}
								if(data.final_fuel_charges>=fuel_charges){$('#fuel_charges').val(data.final_fuel_charges);}
								if(data.docket_charge>=awb_charges){$('#awb_charges').val(data.docket_charge);}
								if(data.fov>=fov_charges){$('#fov_charges').val(data.fov);}
								if(data.appt_charges>=appt_charges){$('#appt_charges').val(data.appt_charges);}
								shipmentGST_calcu();
	
	
							
							$('#cft').val(data.cft);
							$('#rate_new').val(data.rate);
							$('#isMinimumValue').html(data.isMinimumValue);
							if (data.fovExpiry) {
								alert(data.fovExpiry);
								// $("#desabledBTN").attr();
								$('#desabledBTN').prop('disabled', true);
	
							} else {
								// $('#desabledBTN').prop('disabled', false);
							}
	
	
						}
					},
					error: function () {
						$('#frieht').val('');
						// alert(data.frieht);
						var table_row = $('#volumetric_table_row tr').length;
						getPerBox_fright(table_row);
					}
				});
			}
			else {
				$('#frieht').val();
			}
			// } else {
			// 	$('#frieht').val('');
			// }
		}
	
		// calculate Perbox fright in ajax request
		function getPerBox_fright(update) {
			if (update > 0) {
				var non_of_pack = [];
				var actual_w = [];
	
				for (var jk = 1; jk <= update; jk++) {
	
					if ($('#valumetric_actual' + jk).val() != '' || $('#valumetric_actual' + jk).val() != null) {
						var a_w = [];
						a_w[jk] = $('#valumetric_actual' + jk).val();
						actual_w.push(a_w);
					}
					if ($('#per_box_weight' + jk).val() != '' || $('#per_box_weight' + jk).val() != null) {
						var no = [];
						no[jk] = $('#per_box_weight' + jk).val();
						non_of_pack.push(no);
					}
				}
				ChargableWeightCalcu();
				if ($('#is_appointment').is(':checked')) {
					var is_appointment = 1;
				}
				else {
					var is_appointment = 0;
				}
				var customer_id = $('#customer_account_id').val();
				var c_courier_id = $('#courier_company').val();
				var mode_id = $('#mode_dispatch').val();
				var sender_state = $("#sender_state").val();
				var sender_city = $("#sender_city").val();
				var state = $("#reciever_state").val();
				var city = $("#reciever_city").val();
				var doc_type = $("#doc_typee").val();
				var receiver_zone_id = $("#receiver_zone_id").val();
				var receiver_gstno = $("#receiver_gstno").val();
				var booking_date = $('#booking_date').val();
				var dispatch_details = $('#dispatch_details').val();
				var invoice_value = $('#invoice_value').val();
				var invoice_value = parseFloat(($('#invoice_value').val() != '') ? $('#invoice_value').val() : 0);
	
				var chargable_weight = parseFloat($('#chargable_weight').val()) > 0 ? $('#chargable_weight').val() : 0;
				var actual_weight = parseFloat($('#actual_weight').val()) > 0 ? $('#actual_weight').val() : 0;
				let packet = $("#no_of_pack1").val();
				if (dispatch_details == 'ToPay' && invoice_value == '') {
					alert('Please Fillup Inv. Value*');
				}
				// if (chargable_weight > 0) {
				if (customer_id != '' && mode_id != '') {
					$.ajax({
						type: 'POST',
						url: 'Admin_domestic_shipment_manager/get_perbox_rate',
						data: 'packet=' + packet + '&customer_id=' + customer_id + '&c_courier_id=' + c_courier_id + '&mode_id=' + mode_id + '&state=' + state + '&city=' + city + '&chargable_weight=' + chargable_weight + '&receiver_zone_id=' + receiver_zone_id + '&receiver_gstno=' + receiver_gstno + '&booking_date=' + booking_date + '&invoice_value=' + invoice_value + '&dispatch_details=' + dispatch_details + '&sender_state=' + sender_state + '&sender_city=' + sender_city + '&is_appointment=' + is_appointment + '&actual_weight=' + actual_weight + '&per_box=' + non_of_pack + '&perBox_actual=' + actual_w,
						dataType: "json",
						success: function (data) {
							if (data.rate_message != '') {
								alert(data.rate_message);
							}
							if (data.Message == 'Rate Not defined Please check Rate') {
								alert(data.Message);
							}
							else {
	
								$('#frieht').val(data.frieht);
								if (update) {
	
								} else {
									// $('#transportation_charges').val(0);
									// $('#pickup_charges').val(0);
									// $('#delivery_charges').val(0);
									// $('#insurance_charges').val(0);
								}
								if (data.frieht > 0) {
											var courier_charges = parseFloat($('#courier_charges').val());
											if(isNaN(courier_charges)){	var courier_charges = 0;}
											var green_tax = parseFloat($('#green_tax').val());
											if(isNaN(green_tax)){	var green_tax = 0;}
											var fuel_charges = parseFloat($('#fuel_charges').val());
											if(isNaN(fuel_charges)){	var fuel_charges = 0;}
											var awb_charges = parseFloat($('#awb_charges').val());
											if(isNaN(awb_charges)){	var awb_charges = 0;}
											var fov_charges = parseFloat($('#fov_charges').val());
											if(isNaN(fov_charges)){	var fov_charges = 0;}
											var appt_charges = parseFloat($('#appt_charges').val());
											if(isNaN(appt_charges)){	var appt_charges = 0;}
	
											if(data.cod>=courier_charges){$('#courier_charges').val(data.cod);}
											if(data.to_pay_charges>=green_tax){$('#green_tax').val(data.to_pay_charges);}
											if(data.final_fuel_charges>=fuel_charges){$('#fuel_charges').val(data.final_fuel_charges);}
											if(data.docket_charge>=awb_charges){$('#awb_charges').val(data.docket_charge);}
											if(data.fov>=fov_charges){$('#fov_charges').val(data.fov);}
											if(data.appt_charges>=appt_charges){$('#appt_charges').val(data.appt_charges);}
											shipmentGST_calcu();	
	
									var actual_weight = $('#actual_weight').val();
									var chargable_weight = $('#chargable_weight').val();
									var val_actual = $('#valumetric_actual').val();
									if (chargable_weight == '') {
	
										if (val_actual > actual_weight) {
											$('#chargable_weight').val(val_actual);
										}
										else if (actual_weight < data.min_weight) {
											$('#chargable_weight').val(data.min_weight);
										}
										else {
											$('#chargable_weight').val(actual_weight);
										}
	
									}
									
									if (data.fovExpiry) {
										alert(data.fovExpiry);
										// $("#desabledBTN").attr();
										$('#desabledBTN').prop('disabled', true);
	
									} else {
										// $('#desabledBTN').prop('disabled', false);
									}
									// alert(data.grand_total); 
								} else {
									$('#frieht').val('');
								}
							}
						}
					});
				}
				else {
					$('#frieht').val();
				}
				// } else {
				// 	$('#frieht').val('');
				// }
			}
		}
	
	
		// calculating fright gst grand total and all chargest 
		$("#valumetric_chageable").blur(function() {
			ChargableWeightCalcu();
			getRate(0);
			shipmentGST_calcu();
		});
		

		// block submit button 
		$("#generatePOD").keydown(function(e) {
			if (e.key === 'Enter') {
                // Prevent the default form submission behavior
                e.preventDefault();
            }
		});

		// Rate calculate on submit 
		$("#desabledBTN").click(function() {
			var text = window.location.pathname;
			const edit_shipment = text.split("/", 5);
			if(edit_shipment[3] == 'admin-edit-view-list')
			{
				if ($('#is_rate').is(':checked')) 
				{
					var bill_type = $('#dispatch_details').val();
					var frieht = $('#frieht').val();
					if(bill_type!='' && frieht !='')
					{
						$('#desabledBTN').prop('disabled', true);
						ChargableWeightCalcu();
						ValumetricRowcalcu();
						calculateTotalWeight();
						getRate(0);
						shipmentGST_calcu();
						$('#desabledBTN').prop('disabled', true);
					}
					
				}else{
					shipmentGST_calcu();
				}
            }else{
				var bill_type = $('#dispatch_details').val();
				var frieht = $('#frieht').val();
				if(bill_type!='' && frieht !='')
				{
					$('#desabledBTN').prop('disabled', true);
					ChargableWeightCalcu();
					ValumetricRowcalcu();
					calculateTotalWeight();
					getRate(0);
					shipmentGST_calcu();
					$('#desabledBTN').prop('disabled', true);
				}
			}
			
		});
		// Is appointment charges notification and apply charges
		$('#is_appointment').change(function(){
			var char = $('#chargable_weight').val();
			if(char !=''){
			if ($('#is_appointment').is(':checked')) {
				alertify.alert("Is Appointment Alert!", "You won't applied appointment charges</br> If Yes please checked checkbox <br> Else Uncheck checkbox",
				function () {
					alertify.success('Appointment charges applied successfully');
					//getRate(0);
				});
			
			}
			else {
				$('#appt_charges').val(0);
				shipmentGST_calcu();
			}
		}
		});
	
	
		// sum calculation after change charges 
		$("#frieht,#transportation_charges,#pickup_charges,#delivery_charges,#courier_charges,#awb_charges,#other_charges,#insurance_charges,#green_tax,#appt_charges,#fuel_charges,#fov_charges,#address_change,#dph,#warehousing,#lcharges1,#lcharges2,#lcharges3").change(function () {
			shipmentGST_calcu();
		});
	
		// calculate total sum or gst total grand total 
		function shipmentGST_calcu(){
			var type_of_doc = $('#type_of_doc').val();
			// console.log(type_of_doc);
			var sender_gstno = $('#sender_gstno').val();
			var frieht = parseFloat(($('#frieht').val() != '') ? $('#frieht').val() : 0);
			var transportation_charges = parseFloat(($('#transportation_charges').val() != '') ? $('#transportation_charges').val() : 0);
			var pickup_charges = parseFloat(($('#pickup_charges').val() != '') ? $('#pickup_charges').val() : 0);
			var dph = parseFloat(($('#dph').val() != '') ? $('#dph').val() : 0);
			var lcharges1 = parseFloat(($('#lcharges1').val() != '') ? $('#lcharges1').val() : 0);
			var lcharges2 = parseFloat(($('#lcharges2').val() != '') ? $('#lcharges2').val() : 0);
			var lcharges3 = parseFloat(($('#lcharges3').val() != '') ? $('#lcharges3').val() : 0);
			var warehousing = parseFloat(($('#warehousing').val() != '') ? $('#warehousing').val() : 0);
			var delivery_charges = parseFloat(($('#delivery_charges').val() != '') ? $('#delivery_charges').val() : 0);
			var courier_charges = parseFloat(($('#courier_charges').val() != '') ? $('#courier_charges').val() : 0);
			var address_change = parseFloat(($('#address_change').val() != '') ? $('#address_change').val() : 0);
			var awb_charges = parseFloat(($('#awb_charges').val() != '') ? $('#awb_charges').val() : 0);
			var other_charges = parseFloat(($('#other_charges').val() != '') ? $('#other_charges').val() : 0);
			var fov_charges = parseFloat(($('#fov_charges').val() != '') ? $('#fov_charges').val() : 0);
			var insurance_charges = parseFloat(($('#insurance_charges').val() != '') ? $('#insurance_charges').val() : 0);
			var green_tax = parseFloat(($('#green_tax').val() != '') ? $('#green_tax').val() : 0);
			var appt_charges = parseFloat(($('#appt_charges').val() != '') ? $('#appt_charges').val() : 0);
			var fuel_charges = parseFloat(($('#fuel_charges').val() != '') ? $('#fuel_charges').val() : 0);
			// alert(fov_charges);
			var totalAmount = 
				frieht + transportation_charges + pickup_charges  +delivery_charges  +courier_charges + awb_charges+ other_charges + fov_charges + insurance_charges +  green_tax + appt_charges
			;
			//alert(fov_charges);
			$('#amount').val(totalAmount);
			// Rquired Data  
			var dispatch_details = $('#dispatch_details').val();
			var per_cgst = parseFloat($('#per_cgst').val());
			var per_sgst = parseFloat($('#per_sgst').val());
			var per_igst = parseFloat($('#per_igst').val());
			var gst_Access = parseFloat($('#igst_or_other').val());
			var fuelprice = parseFloat($('#fuelprice').val());
			var fuel_charge = $('#fuel_charge').val();
			if (dispatch_details == 'Cash') {
				sub_total = totalAmount + fuel_charges +lcharges1 + lcharges2+lcharges3 + dph + address_change + warehousing;
	            var branch_gst = parseFloat($('#branch_gst').val());
				var sender_gst = parseFloat($('#sender_gst').val());
				var fuel_charge = $('#fuel_charge').val();
				if(branch_gst!=0 || sender_gst!=0){
					if(branch_gst==sender_gst){
						var cgst = (sub_total * per_cgst / 100);
						var sgst = (sub_total * per_sgst / 100);
						var igst = 0;
						var grand_total = sub_total + cgst + sgst + igst;
					}else{
						var cgst = 0;
						var sgst = 0;
						var igst =(sub_total * per_igst / 100);
						var grand_total = sub_total + cgst + sgst + igst;
					}
				}else{
					var cgst = 0;
					var sgst = 0;
					var igst =(sub_total * per_igst / 100);
					var grand_total = sub_total + cgst + sgst + igst;
				}
			} else {
				if(fuel_charge=='freight'){
					var fuel_charges = (frieht * fuelprice / 100);
				}else{
					var fuel_charges = (totalAmount * fuelprice / 100);
				}
				$('#fuel_charges').val(fuel_charges);
				var sub_total = totalAmount + fuel_charges +lcharges1 + lcharges2+lcharges3 + dph + address_change + warehousing;
				if(gst_Access==1)
				{
					var cgst = (sub_total * per_cgst / 100);
					var sgst = (sub_total * per_sgst / 100);
					var igst = 0;
					var grand_total = sub_total + cgst + sgst + igst;
				}else{
					var cgst = 0;
					var sgst = 0;
					var igst = 0;
					var grand_total = sub_total + cgst + sgst + igst;
				}

				$('#cgst').attr('readonly', true);
				$('#sgst').attr('readonly', true);
				$('#igst').attr('readonly', true);
			}
			$('#sub_total').val(sub_total.toFixed(2));
			$('#cgst').val(cgst.toFixed(2));
			$('#sgst').val(sgst.toFixed(2));
			$('#igst').val(igst.toFixed(2));
			$('#grand_total').val(grand_total.toFixed(2));
		}
	
	
		// chkceing duplicate number
		$("#awn").blur(function () {
			var text = window.location.pathname;
				const edit_shipment = text.split("/", 5);
				if(edit_shipment[2]!='view-edit-domestic-shipment' || edit_shipment[2] != 'admin-edit-view-list')
				{   
			       DuplicateLR();
				}
		});
		function DuplicateLR(){
			var pod_no = $('#awn').val();
			if (pod_no != '') {
				
				$.ajax({
					type: 'POST',
					dataType: "json",
					url: 'Admin_domestic_shipment_manager/check_duplicate_awb_no',
					data: 'pod_no=' + pod_no,
					success: function (data) {
						if (data.msg != "") {
							$('#awn').focus();
							$('#awn').val("");
							//alert(data.msg);
							alertify.alert("Duplicate LR Alert!", data.msg,
								function () {
									alertify.success('Ok');
								});
						} else {
	
						}
	
					}
				});
			}
		}
	
		// doc type change 
		$("#doc_typee").change(function () {
			var shipment = $("#doc_typee").val();
			if (shipment == 1) {
				$('#div_inv_row').show();
				$('#div_inv_row1').show();
				$(".length_td").show();
				$(".height_td").show();
				$(".breath_td").show();
				$(".volumetic_weight_td").show();
				$(".cft_th").show();
				$(".volumetric_weight_th").show();
				$(".length_th").show();
				$(".breath_th").show();
				$(".height_th").show();
			} else {
				$('#div_inv_row').hide();
				$('#div_inv_row1').hide();
				$('#invoice_no').val("");
				$('#invoice_value').val("");
				$('#eway_no').val("");
	
				$(".length_td").hide();
				$(".height_td").hide();
				$(".breath_td").hide();
				$(".volumetic_weight_td").hide();
				$(".cft_th").hide();
				$(".volumetric_weight_th").hide();
				$(".length_th").hide();
				$(".breath_th").hide();
				$(".height_th").hide();
			}
		});
	
		$("#reciever").blur(function () {
			var reciever = $(this).val();
			$('#contactperson_name').val(reciever);
			$('#contactperson_name').trigger("change");
	
		});
	
		/* Add Shipment and also edit shipment in BNF PORTAL
		it's Creadting value matric row according no_of_pack (PKT) in details =>
		1. add shipment case first entering no_of_pack and value matric details 
		2. and change no_of_pack according no_of_pack genrate and remove are working but is_valuemetric check box checked required.
		3. edit shipment check box not check that's why not working  
		*/
	
		// Remove method it's work dynamicly count and status 
		function RemoveRow(rowCount,pkt, totalRow, status) {
			/*
			if (status == 0) {
				for (var jk = 1; jk < (rowCount); jk++){
					console.log(jk);
					$('#volumetric_table_row').find('tr:last').remove();
					//totalRow--;
				}
			} else {
				for (let i = 1; i <= rowCount; i++){
					d3 = $('#per_box_weight' + i).val();
					if (!d3 || d3 == '' || d3 == '0') {
						$('#per_box_weight' + i).closest('tr').remove();
					}
	
				}
			}
			*/
			if (status == 0) {
				sum=0;
				for (var jk = 1; jk < (totalRow); jk++){
					console.log(jk);
					qty = $('#per_box_weight' + jk).val()
					if (qty<pkt){
						sum += qty;
						continue; 
					}else{
						$('#volumetric_table_row').find('tr:last').remove();
					}
					if (sum<=pkt){
						sum += qty;
						continue; 
					}else{
						$('#volumetric_table_row').find('tr:last').remove();
					}
					//totalRow--;
				}
			} else {
				for (let i = 1; i <= rowCount; i++){
					d3 = $('#per_box_weight' + i).val();
					if (!d3 || d3 == '' || d3 == '0') {
						$('#per_box_weight' + i).closest('tr').remove();
					}
	
				}
			}
		}
	
	
		//  add row dynamicly value matric row 
		function AddRow(rowCount){
			for (var i = 0; i < rowCount; i++) {
	
				var allTrs = $('table.weight-table tbody').find('tr');
	
				var lastTr = allTrs[allTrs.length - 1];
				var $clone = $(lastTr).clone();
				var countrows = $(".height").length;
				console.log(countrows);
				$clone.find('td').each(function () {
					var el = $(this).find(':first-child');
					var id = el.attr('id') || null;
					if (id) {
						var i = id.substr(id.length - 1);
	
						var nextElament = countrows; //parseInt(i)+1;
						var remove = 1;
						if (countrows > 10) {
							var remove = 2;
						}
						var removeChar = (id.length - remove);
						var prefix = id.substr(0, removeChar);
	
	
						//console.log('prefix:::' + prefix + '::::' + id + '::::' + removeChar);
						el.attr('id', prefix + (nextElament));
						el.attr('data-attr', (nextElament));
						el.attr('id', prefix + (nextElament));
						el.attr('data-attr', (nextElament));
						el.prop('required', true);
						el.val('');
	
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
			}
		}
	
		//  get blank row in value matric rows
		function row_sum(id){
			sum = $('#per_box_weight' + id).val()+ $('#length' + id).val()+ $('#breath' + id).val()+$('#height' + id).val()+ $('#valumetric_weight' + id).val()+ $('#valumetric_actual' + id).val() + $('#valumetric_chageable' + id).val()
			return parseInt(sum);
		}
	
		// Genrate value matric row accordingly 
		$("#no_of_pack1").on('blur', function () {
			var no_of_pack1 = $('#no_of_pack1').val();
			if(no_of_pack1 !=0 || no_of_pack1 !='0'){
			 $("#volumetric_table").show();
			 var totalRow = $('#volumetric_table_row').find('tr').length;
			 console.log(totalRow);
			 var sum = 0;
			 var total_blank_row = 0;
			 var checkValForEmprtyRow 
			 // this getting sum of value matric packet order by desc row 
			 for (let i = totalRow; i > 0; i--) {
				 var totalbox = parseInt($('#per_box_weight' + i).val());
				 var chk_blank = row_sum(i);
				 if (isNaN(totalbox)) { totalbox = 0; }
				 if (isNaN(chk_blank)) { total_blank_row +=1 ; }
				 sum = sum + totalbox;
			 }
			 chk_blank = null;
			 // alert(total_blank_row); 
			 var pkt = parseFloat($("#no_of_pack1").val());
			 var pktDiff = Math.abs(pkt - sum);
			 if (pktDiff >= totalRow) {
				 addRowCount = pktDiff - total_blank_row;
				 AddRow(addRowCount);
			 }
		 
			 if (pkt != '' && pkt != 0 && totalRow > pktDiff) {
				//  rowCount = totalRow - pktDiff;
				 rowCount = total_blank_row - pktDiff;
				// rowCount = (total_blank_row == pktDiff) ? 0 : total_blank_row - pktDiffs	
				 RemoveRow(rowCount,pkt,totalRow, 0);
			 }
		 }
		});

		
	
		// after check is value matric checkbox show value matric row
		$("#doc_typee").on('change', function () {
			var doc_typee = $('#doc_typee').val();
			if (doc_typee != '') {
				$("#volumetric_table").show();
			}
			else {
				$("#volumetric_table").hide();
			}
		});
	
		
		$(document).on("blur", '.valumetric_actual', function () {
	
			var idNo = $(this).attr('data-attr');
			var id = $(this).attr('id');
			var val = $(this).val();
	
			if (!val) {
				val = 0;
			}
	
			val = parseFloat(val);
	
			valumetric_weight = parseFloat($("#valumetric_weight" + idNo).val());
	
			if (valumetric_weight > val) {
				$('#valumetric_chageable' + idNo).val(valumetric_weight);
			} else {
				$('#valumetric_chageable' + idNo).val(val);
			}
	
		});
	
	
		$(document).on("blur", '.per_box_weight, .length, .breath, .height', function () {
			var idNo = $(this).attr('data-attr');
			var id = $(this).attr('id');
			// calculating value matric weight 
			
			calculateTotalWeight();
			ChargableWeightCalcu();
			if (id == 'per_box_weight' + idNo) {
				var table2 = $(this).closest('table');
				var rowCount2 = $('#volumetric_table #volumetric_table_row tr').length;
				val = parseInt($('#' + id).val());
				tot = parseInt($('#no_of_pack1').val());
				// +"  -- row "+idNo
				var sum = 0;
				// this getting sum of value matric packet order by desc row 
				for (let i = idNo; i > 0; i--) {
					sum = sum + parseInt($('#per_box_weight' + i).val());
				}
				// if sum are greater that case remove Row Last TR one by one
				if (sum >= tot) {
					dd = sum - tot;
					if (val > dd) { $(this).val(val - dd); }
					if (dd > val) { $(this).val(dd - val); }
	
					var rm_tr = tot - idNo;
					if (rm_tr) {
						for (let i = 0; i < rm_tr; i++) {
							$(this).closest('tr').next().remove();
						}
					}
				}
				else {
					var table = $(this).closest('table');
					var rowCount = $('#volumetric_table #volumetric_table_row tr').length;
					if (tot > rowCount) {
						var totalRow = $('#volumetric_table_row').find('tr').length;
						console.log(totalRow);
						var sum = 0;
						var total_blank_row = 0;
						var checkValForEmprtyRow 
						// this getting sum of value matric packet order by desc row 
						for (let i = totalRow; i > 0; i--) {
							var totalbox = parseInt($('#per_box_weight' + i).val());
							var chk_blank = row_sum(i);
							if (isNaN(totalbox)) { totalbox = 0; }
							if (isNaN(chk_blank)) { total_blank_row +=1 ; }
							sum = sum + totalbox;
						}
						chk_blank = null;
						// alert(total_blank_row); 
						var pkt = parseFloat($("#no_of_pack1").val());
						var pktDiff = Math.abs(pkt - sum);
						if (pktDiff >= total_blank_row) {
							addRowCount = pktDiff - total_blank_row;
							AddRow(addRowCount);
						}
					
						if (pkt != '' && pkt != 0 && totalRow > pktDiff) {
							rowCount = total_blank_row - pktDiff;
							// RemoveRow(rowCount, 1);
							RemoveRow(rowCount,pkt,totalRow, 1);
						}
	
					}
				}
			}
	
			$('#per_box_weight' + (idNo + 1)).trigger('blur');
		});
		function ValumetricRowcalcu() {
			var idNo = $(this).attr('data-attr');
			var id = $(this).attr('id');
			// calculating value matric weight 
			
			calculateTotalWeight();
			ChargableWeightCalcu();
			if (id == 'per_box_weight' + idNo) {
				var table2 = $(this).closest('table');
				var rowCount2 = $('#volumetric_table #volumetric_table_row tr').length;
				val = parseInt($('#' + id).val());
				tot = parseInt($('#no_of_pack1').val());
				// +"  -- row "+idNo
				var sum = 0;
				// this getting sum of value matric packet order by desc row 
				for (let i = idNo; i > 0; i--) {
					sum = sum + parseInt($('#per_box_weight' + i).val());
				}
				// if sum are greater that case remove Row Last TR one by one
				if (sum >= tot) {
					dd = sum - tot;
					if (val > dd) { $(this).val(val - dd); }
					if (dd > val) { $(this).val(dd - val); }
	
					var rm_tr = tot - idNo;
					if (rm_tr) {
						for (let i = 0; i < rm_tr; i++) {
							$(this).closest('tr').next().remove();
						}
					}
				}
				else {
					var table = $(this).closest('table');
					var rowCount = $('#volumetric_table #volumetric_table_row tr').length;
					if (tot > rowCount) {
						var totalRow = $('#volumetric_table_row').find('tr').length;
						console.log(totalRow);
						var sum = 0;
						var total_blank_row = 0;
						var checkValForEmprtyRow 
						// this getting sum of value matric packet order by desc row 
						for (let i = totalRow; i > 0; i--) {
							var totalbox = parseInt($('#per_box_weight' + i).val());
							var chk_blank = row_sum(i);
							if (isNaN(totalbox)) { totalbox = 0; }
							if (isNaN(chk_blank)) { total_blank_row +=1 ; }
							sum = sum + totalbox;
						}
						chk_blank = null;
						// alert(total_blank_row); 
						var pkt = parseFloat($("#no_of_pack1").val());
						var pktDiff = Math.abs(pkt - sum);
						if (pktDiff >= total_blank_row) {
							addRowCount = pktDiff - total_blank_row;
							AddRow(addRowCount);
						}
					
						if (pkt != '' && pkt != 0 && totalRow > pktDiff) {
							rowCount = total_blank_row - pktDiff;
							// RemoveRow(rowCount, 1);
							RemoveRow(rowCount,pkt,totalRow, 1);
						}
	
					}
				}
			}
	
			$('#per_box_weight' + (idNo + 1)).trigger('blur');
		}
	
		
	
		// check total AW or actual weight are equal or grater if is grater that case remove value matric row 
		$('#valumetric_actual,#frieht,#amount').blur(function () {
			$mean_actual_w = $('#actual_weight').val();
			$value_actual_w = $('#valumetric_actual').val();
			if ($mean_actual_w != '' && $value_actual_w != '') {
				if (parseFloat($value_actual_w) - 1 >= $mean_actual_w) {
					alert('Actual Weight is grater than Total Valumetric Actual Weight');
					$('.valumetric_actual').val('');
					$('#frieht').val('');
				}
			}
	
		});
	
		// value matric weight calculation and total weight 
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
			var valumetric_chageable = 0;
			var valumetric_actual = 0;
	
			var mode_dispatch = $('#mode_dispatch').val();
			var currentActualWeight = $('#actual_weight').val();
	
	
			for (var i = 1; i <= totalRow; i++) {
	
				var perBoxWeightCurrent = $('#per_box_weight' + i).val();
				var length = $("#length" + i).val();
				var breath = $("#breath" + i).val();
				var height = $("#height" + i).val();
	
				if (length != '' && breath != '' && height != '') {
	
					if (mode_dispatch != 1) {
						cft = $('#cft').val();
						// if (cft==0 || cft=='0') {cft=7}
						valumetric_weight = (((length * breath * height) / 27000) * cft) * perBoxWeightCurrent;
					}
					else {
						air_cft = $('#air_cft').val();
						// if (air_cft==0 || air_cft=='0') {air_cft=5000}
						valumetric_weight = ((length * breath * height) / air_cft) * perBoxWeightCurrent;
					}
	
					total_valumetric_weight = valumetric_weight.toFixed(2);
					$("#valumetric_weight" + i).val(total_valumetric_weight);
	
					dd = $("#valumetric_actual" + i).val();
	
					if (!dd) {
						// $("#valumetric_actual" + i).val(total_valumetric_weight);
					}
	
				}
				else {
					$("#valumetric_weight" + i).val('');
				}
	
	
	
				totalValumetricWeight = parseFloat(totalValumetricWeight) + parseFloat(($('#valumetric_weight' + i).val() != '') ? $('#valumetric_weight' + i).val() : 0);
				totalPerBoxWeight = parseFloat(totalPerBoxWeight) + parseFloat(($('#per_box_weight' + i).val() != '') ? $('#per_box_weight' + i).val() : 0);
				totalLength = parseFloat(totalLength) + parseFloat(($('#length' + i).val() != '') ? $('#length' + i).val() : 0);
				totalBreath = parseFloat(totalBreath) + parseFloat(($('#breath' + i).val() != '') ? $('#breath' + i).val() : 0);
				totalHeight = parseFloat(totalHeight) + parseFloat(($('#height' + i).val() != '') ? $('#height' + i).val() : 0);
				valumetric_chageable = parseFloat(valumetric_chageable) + parseFloat(($('#valumetric_chageable' + i).val() != '') ? $('#valumetric_chageable' + i).val() : 0);
				valumetric_actual = parseFloat(valumetric_actual) + parseFloat(($('#valumetric_actual' + i).val() != '') ? $('#valumetric_actual' + i).val() : 0);
			}
	
			var totalActualWeight = $('#actual_weight').val();
			var totalchargable_weight = $('#chargable_weight').val();
	
			if (totalValumetricWeight) {
				var roundoff_type = $("#roundoff_type").val();
				// $('#valumetric_weight').val(totalValumetricWeight); ttttttt
				if (roundoff_type == '1') {
					$('#valumetric_weight').val(totalValumetricWeight);
				}
				else {
					$('#valumetric_weight').val(totalValumetricWeight);
				}
			}
			var totalActualWeight = $('#actual_weight').val();
			// if (valumetric_chageable > totalActualWeight) {
				//valumetric_chageable = valumetric_chageable;
				// valumetric_chageable = Math.ceil(valumetric_chageable);
			// 	$("#chargable_weight").val(valumetric_chageable);
			// }
			ChargableWeightCalcu();
	
			// else
			// {
			// 	totalActualWeight = Math.ceil(totalActualWeight);
			// 	// totalActualWeight = Math.round(totalActualWeight);
			// 	$("#chargable_weight").val(totalActualWeight);
			// }
	
			if (totalNoOfPack) {
				$('#no_of_pack').val(totalNoOfPack);
			}
			if (totalPerBoxWeight) {
				$('#per_box_weight').val(totalPerBoxWeight);
			}
			if (totalActualWeight) {
				$('#actual_weight').val(totalActualWeight);
			}
			if (totalValumetricWeight) {
				var roundoff_type = $("#roundoff_type").val();
				if (roundoff_type == '1') {
					$('#valumetric_weight').val(totalValumetricWeight.toFixed(2));
				}
				else {
					$('#valumetric_weight').val(totalValumetricWeight.toFixed(2));
				}
			}
			$('#length').val(totalLength.toFixed(2));
			$('#breath').val(totalBreath.toFixed(2));
			$('#height').val(totalHeight.toFixed(2));
			$('#valumetric_weight').val(totalValumetricWeight.toFixed(2));
			$('#valumetric_chageable').val(Math.ceil(valumetric_chageable.toFixed(2)));
			$('#valumetric_actual').val(valumetric_actual.toFixed(2));
		}
	
		/* Add shipment Edit shipment 
		Getting Min Weight about this actual weight slab 
		1. Min weight and check which grater weight actual weight or Min weight  
		2. and new point value matric wieght or first point which grater
		*/
		$(document).on("blur", '.actual_weight', function () {
	
			getCharagableWeight();
			///calculateTotalWeight();
		});
		
		
		
	
		$("#invoice_value").blur(function () {
			var invoice_bavalue = $(this).val();
			var branch_gst = $('#branch_gst').val();
			var sender_gstno = $('#sender_gstno').val().substr(0, 2);
	
			if (branch_gst == sender_gstno) {
				//$('#eway_no').prop('required',true);
				$('#invoice_value').attr('placeholder', 'Max Invoice Allowed Value 99999');
			}
			else {
				//$('#eway_no').prop('required',false);
				$('#invoice_value').attr('placeholder', 'Max Invoice Allowed Value 49999');
			}
		});
	
		// for edit section
		var shipment = $("#doc_typee").val();
		if (shipment == 1) {
			$('#div_inv_row').show();
			$('#div_inv_row1').show();
			$(".length_td").show();
			$(".height_td").show();
			$(".breath_td").show();
			$(".volumetic_weight_td").show();
			$(".cft_th").show();
			$(".volumetric_weight_th").show();
			$(".length_th").show();
			$(".breath_th").show();
			$(".height_th").show();
		} else {
			$('#div_inv_row').hide();
			$('#div_inv_row1').hide();
			$('#invoice_no').val("");
			$('#invoice_value').val("");
			$('#eway_no').val("");
			$(".length_td").hide();
			$(".height_td").hide();
			$(".breath_td").hide();
			$(".volumetic_weight_td").hide();
			$(".cft_th").hide();
			$(".volumetric_weight_th").hide();
			$(".length_th").hide();
			$(".breath_th").hide();
			$(".height_th").hide();
		}
	
	});
	
	
	// calculating customer cft 
	function calculate_cft() {
		var courier_id = parseFloat(($('#courier_company').val() != '') ? $('#courier_company').val() : 0);
		var booking_date = $('#booking_date').val();
		var customer_account_id = $('#customer_account_id').val();
	
	
		if (!customer_account_id) {
			// $('#cft').val(7);
		} else {
			$.ajax({
				type: 'POST',
				url: 'Admin_domestic_shipment_manager/available_cft',
				data: 'courier_id=' + courier_id + '&booking_date=' + booking_date + '&customer_id=' + customer_account_id,
				dataType: "json",
				success: function (data) {
					// alert(data.cft_charges);	
					// if(data.cft_charges=="0")
					// {
	
					// }else{
					$('#cft').val(data.cft_charges);
					$('#air_cft').val(data.air_cft);
					// }
	
				}
			});
		}
	}

	// Notify bill_type code remider
	function NotifySubmission()
	{
		
		var bill_type = $('#dispatch_details').val();
		var frieht = $('#frieht').val();
		if(bill_type!='' && frieht !='')
		{
			$('#spinner').show();
			$('#desabledBTN').prop('disabled', true);
			setTimeout(
				function() 
				{
					$("#submit_notify").modal('show');
				}, 1000);

			if(bill_type=='FOC')
			{
				$("#mbg-color").css({
					'background-color': '#00FF00',
				  });
				  $('#mode_name').text('FOC');
			}else if(bill_type=='COD'){
				$("#mbg-color").css({
					'background-color': '#F70D1A',
				  });
				  $('#mode_name').text('COD');
			}else if(bill_type=='ToPay'){
				$("#mbg-color").css({
					'background-color': '#FF69B4',
				  });
				  $('#mode_name').text('TOPAY');
			}else if(bill_type=='Cash'){
				$("#mbg-color").css({
					'background-color': '#FFFF00',
				  });
				  $('#mode_name').text('CASH');
			}else if(bill_type=='Credit'){
				$("#mbg-color").css({
					'background-color': '#5cb3ff',
				  });
				$('#mode_name').text('CREDIT');
			}
		}
	}

	$('#cancel_model').click(function(){
		$('#spinner').hide();
		$('#desabledBTN').prop('disabled', false);
	});
	
	
	//  check submission validation value matric check PKT or total no of pice 
	function checkForTheCondition() {
		// if ($('#is_volumetric').is(':checked')) 
		// {
		$('volumetric_table_row').find('input').prop('required', true);
		$('volumetric_table_row').find('input').attr("required", "required");
		no_of_pack1 = $('#no_of_pack1').val();
		per_box_weight = $('#per_box_weight').val();
	
		if (per_box_weight == no_of_pack1) {
			$('#submit1').click();
		} else {
			// alert('Please enter the volumetric details of all '+no_of_pack1+' No Of Box Packets!');
			alertify.alert("Please enter the volumetric details of all " + no_of_pack1 + " No Of Box Packets!",
				function () {
					alertify.success('Ok');
				});
		}
	
		// }else{
		// 	$('volumetric_table_row').find('input').prop('required',false);
		// 	$('volumetric_table_row').find('input').attr("required","");
		// 	$('#submit1').click();
		// }
	}
	
	/*########################################################## Add/Edit shipment End ############################## */
    /*########################################################## Pincode service start ############################## */
	$("#pincodep").blur(function () {
        var pod_no = $(this).val();
        if (pod_no != '') {
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'Admin_pincode_service/check_duplicate_pincode',
                data: 'pod_no=' + pod_no,
                success: function (data) {
                    if(data.msg!=""){       
                    	// $('#pincodep').focus();
                    	// $('#pincodep').val("");
                    	if(data.status==1){
                         $("#pincode_conform").modal('show');
						 $('#pincode').val(data.pin);
						}else if(data.status==0){
							alertify.alert("Pincode Service Alert !","Pincode Are Exist In System",
							function () {
								alertify.success('Ok');
							});
						}
                      
                    }else{

                    }
                    
                }
            });
        }
    });
    
	function ActivePincode(){
		var pincode = $('#pincode').val();
		if(pincode != '')
		{
			$.ajax({
				type: 'POST',
				url: 'Admin_pincode_service/DeactiveNote',
				data: {pincode:pincode},
				dataType: "html",
				success: function (d) {     
					$("#pincode_conform").modal('hide');
					$('.booking_show').modal('show');    
					$('#show_booking').html(d);
				}
			  });
		}
	}


	$('#cancel_model').click(function(){
		$('#desabledBTN').prop('disabled', false);
	});
    /*########################################################## Pincode service End ############################## */
    /*########################################################## Customer Master Start ############################## */
	$('#franchise_customer_access').change(function() {
		var deliveryYes = $(this).val();
	//    alert(deliveryYes);
		if(deliveryYes == '1'){
			$("#show").show();
			$("#franchise_customer").prop('required',true);			
		}else{
			$("#franchise_customer").prop('required',false);			
			$("#show").hide(); 
		}
	});
    /*########################################################## Customer Master End ############################## */
	