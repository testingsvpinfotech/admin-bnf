<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->
<style>
	.buttons-copy {
		display: none;
	}

	.buttons-csv {
		display: none;
	}

	/*.buttons-excel{display: none;}*/
	.buttons-pdf {
		display: none;
	}

	.buttons-print {
		display: none;
	}

	/*#example_filter{display: none;}*/
	.input-group {
		width: 60% !important;
	}
</style>
<!-- START: Body-->

<body id="main-container" class="default">


	<!-- END: Main Menu-->

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
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
								<h4 class="card-title">Franchise Booking List</h4>
								<!--  <span style="float: right;"><a href="admin/view-add-domestic-shipment" class="fa fa-plus btn btn-primary">Add Domestic Shipment</a></span> -->
								<span style="float: right;">
									<!-- <a href="admin/view-add-domestic-shipment" class="btn btn-primary">Add Domestic Shipment</a> -->
									<!-- <button type="button" id="select_multiple_camp" class="btn btn-primary">Print Selected Shipment</button> -->
								</span>
							</div>

							<div class="card-header justify-content-between align-items-center">
								<span>
									<form role="form" action="admin/franchise-booking-list" method="post" enctype="multipart/form-data">
										<div class="form-row">

											<div class="col-sm-1">
												<label for="">Courier</label>
												<select class="form-control" name="courier_company" id="courier_company">
													<option value="ALL">ALL</option>
													<?php foreach ($courier_company as $cc) { ?>
														<option value="<?php echo $cc['c_id']; ?>" <?php echo (isset($courier_companyy) && $courier_companyy == $cc['c_id']) ? 'selected' : ''; ?>><?php echo $cc['c_company_name']; ?></option>
													<?php  }  ?>
												</select>
											</div>

											<div class="col-sm-1">
												<label for="">Mode</label>
												<select class="form-control" name="mode_name" id="mode_name">
													<option value="ALL">ALL</option>
													<?php foreach ($mode_details as $mn) { ?>
														<option value="<?php echo $mn['transfer_mode_id']; ?>" <?php echo (isset($transfer_mode_id) && $transfer_mode_id == $mn['transfer_mode_id']) ? 'selected' : ''; ?>><?php echo $mn['mode_name']; ?></option>
													<?php  }  ?>
												</select>
											</div>
											<div class="col-md-1">
												<label for="">Filter</label>
												<select class="form-control" name="filter">
													<option selected disabled>Select Filter</option>
													<option value="pod_no" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'pod_no') ? 'selected' : ''; ?>>Pod No</option>
													<option value="forwording_no" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'forwording_no') ? 'selected' : ''; ?>>Forwording No</option>
													<option value="sender" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'sender') ? 'selected' : ''; ?>>Sender</option>
													<option value="receiver" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'receiver') ? 'selected' : ''; ?>>Receiver</option>
													<option value="consignee" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'consignee') ? 'selected' : ''; ?>>Consignee</option>
													<option value="consigner" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'consigner') ? 'selected' : ''; ?>>Consigner</option>
													<option value="pickup" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'pickup') ? 'selected' : ''; ?>>Pickup Pending</option>
												</select>
											</div>
											<div class="col-md-1">
												<label for="">Filter Value</label>
												<input type="text" class="form-control" value="<?php echo (isset($_POST['filter_value'])) ? $_POST['filter_value'] : ''; ?>" name="filter_value" />
											</div>

											<!-- <div class="col-md-1">
												<label for="">Customer</label>
												<select class="form-control" name="user_id" id="user_id">
													<option value="">Selecte Customer</option>
													<?php if (!empty($customer)) {
														foreach ($customer as $key => $values) { ?>
															<option value="<?php echo $values['customer_id']; ?>" <?php echo (isset($user_id) && $user_id == $values['customer_id']) ? 'selected' : ''; ?>><?php echo $values['customer_name']; ?></option><?php }
																																																													} ?>
												</select>
											</div> -->

											<div class="col-sm-1">
												<label for="">From Date</label>
												<input type="date" name="from_date" value="<?php echo (isset($_POST['from_date'])) ? $_POST['from_date'] : ''; ?>" id="from_date" autocomplete="off" class="form-control">
											</div>

											<div class="col-sm-1">
												<label for="">To Date</label>
												<input type="date" name="to_date" value="<?php echo (isset($_POST['to_date'])) ? $_POST['to_date'] : ''; ?>" id="to_date" autocomplete="off" class="form-control">
											</div>
											<div class="col-sm-2">
												<input type="submit" class="btn btn-primary" name="submit" value="Filter">
												<input type="submit" class="btn btn-primary" name="download_report" value="Download Report">
												<a href="admin/franchise-booking-list" class="btn btn-info">Reset</a>
											</div>
										</div>
									</form>
								</span>
							</div>
							<div class="card-body">
								<?php if ($this->session->flashdata('notify') != '') { ?>
									<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
								<?php unset($_SESSION['class']);
									unset($_SESSION['notify']);
								} ?>
								<div class="table-responsive">
									<table class="table  table-striped table-bordered layout-primary" data-sorting="true">
										<!-- id="example"-->
										<thead>
											<tr>
												<th scope="col"><INPUT type="checkbox" onchange="checkAll(this)" name="chk[]" /> </th>
												<th scope="col">AWB.No</th>
												<th scope="col">Sender</th>
												<th scope="col">Pincode</th>
												<th scope="col">Receiver </th>
												<th scope="col">Receiver City</th>
												<th scope="col">Receiver Pincode</th>
												<th scope="col">Forwarding No</th>
												<th scope="col">Forwarder Name</th>
												<th scope="col">Registrar date</th>
												<!-- <th scope="col">Booking date</th> -->
												<th scope="col">Mode</th>

												<th scope="col">Pay Mode</th>
												<th scope="col">Amount</th>
												<th scope="col">Weight</th>
												<th scope="col">NOP</th>
												<th scope="col">Invoice No</th>
												<th scope="col">Invoice Amount</th>
												<th scope="col">Branch Name</th>
												<th scope="col">Franchise Name</th>
												<th scope="col">Master Franchise Name</th>
												<th scope="col">User</th>
												<th scope="col">Edited Date</th>
												<th scope="col">Edited By</th>
												<th scope="col">Edited Branch</th>
												<th scope="col">Eway No</th>
												<th scope="col">Freight</th>
												<th scope="col">Handling Charge</th>
												<th scope="col">Pickup</th>
												<th scope="col">ODA </th>
												<th scope="col">Insurance</th>
												<th scope="col">COD</th>
												<th scope="col">AWB Ch</th>
												<th scope="col">Other Ch.</th>
												<th scope="col">Green tax</th>
												<th scope="col">Appt Ch</th>
												<th scope="col">Fov Charges</th>
												<th scope="col">Total</th>
												<th scope="col">Fuel Surcharge</th>
											
												<!-- <th scope="col">Eway Expiry date</th> -->
												<?php if ($viewVerified == 1) {  ?>
													<th scope="col">Verifier Name</th>
												<?php } ?>
												<th scope="col">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (!empty($allpoddata)) {
												$cnt = 1;

												foreach ($allpoddata as $value) {
													// echo "<pre>";
													// print_r($value);exit();
													$cnt++;

													$whr = array('transfer_mode_id' => $value['mode_dispatch']);
													$mode_details = $this->basic_operation_m->get_table_row('transfer_mode', $whr);

											?>
													<tr class="odd gradeX" <?php if ($value['pickup_pending'] == 1) {
																				echo 'style="color: red;"';
																			} ?>>
														<td>

															<div class="custom-control custom-checkbox custom-control-inline">
																<input type="checkbox" class="custom-control-input multiple_campings" value="<?php echo $value['booking_id']; ?>" id="customCheck<?php echo $cnt; ?>" name="multiple_delete[]">
																<label class="custom-control-label" for="customCheck<?php echo $cnt; ?>"></label>
															</div>
														</td>
														<td style="width: 11%;">
															<?php

															echo '<a href="' . base_url() . 'users/track_shipment?pod_no=' . $value['pod_no'] . '&submit=1" target="_blank" title="Track" class="ring-point" ><i class="ion-radio-waves"></i></a>';

															$userType = $this->session->userdata("userType");
                                                            //  echo '<pre>';print_r($Branch);
															if ($userType == '1') {
															?>
																<a target="_blank" href="admin/view-edit-domestic-shipment/<?php echo $value['booking_id']; ?>" title="Edit" class="btn btn-primary btn-sm"><?php echo $value['pod_no']; ?></i></a>
															<?php } elseif($userType == '7') { ?>
																<a target="_blank" href="admin/view-edit-domestic-shipment/<?php echo $value['booking_id']; ?>" title="Edit" class="btn btn-primary btn-sm"><?php echo $value['pod_no']; ?></i></a>
															
															<?php } else {
																echo '<br>' . $value['pod_no'];
															} ?>
														</td>
														<td><?php echo $value['sender_name']; ?></td>
														<td><?php echo $value['sender_pincode']; ?></td>
														<td><?php echo $value['reciever_name']; ?></td>
														<td><?php echo $value['city']; ?></td>
														<td><?php echo $value['reciever_pincode']; ?></td>
														<td><?php echo $value['forwording_no']; ?></td>
														<td><?php echo $value['forworder_name']; ?></td>

														<td><?php echo date('d-m-Y', strtotime($value['booking_date'])); ?>
														<td><?php echo $mode_details->mode_name; ?></td>

														<td><?php echo $value['dispatch_details']; ?></td>
														<td><?php echo $value['grand_total']; ?></td>
														<td><?php echo $value['chargable_weight']; ?></td>
														<td><?php echo $value['no_of_pack']; ?></td>
														<td><?php echo $value['invoice_no']; ?></td>
														<td><?php echo $value['invoice_value']; ?></td>
														<?php
														$branch_id = $value['branch_id'];
													//	$whr_u = array('branch_id' => $value['branch_id']);
														$branch_details = $this->db->query("select branch_name from  tbl_branch where branch_id ='$branch_id' ")->row_array();
														//$branch_details = $this->basic_operation_m->get_table_row('tbl_branch', $whr_u);
														?>
														<td><?php  echo substr($branch_details['branch_name'], 0, 20); ?></td>
														<!-- <td><?php //echo $branch_details['branch_name']; ?></td> -->

														<?php
														$pod = $value['pod_no'];
														$customer_id = $value['customer_id'];
														 $getfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.customer_id = tbl_domestic_booking.customer_id where customer_type = 2 AND pod_no ='$pod'")->result_array(); 
														 $getMasterfranchise = $this->db->query("select tbl_customers.customer_name from tbl_domestic_booking left join tbl_customers ON tbl_customers.parent_cust_id = tbl_domestic_booking.customer_id where parent_cust_id = '$customer_id' AND pod_no ='$pod'")->result_array(); 
														 
														 ?>

														<td><?php echo @$getfranchise[0]['customer_name'] ;?></td>
														<td><?php echo @$getMasterfranchise[0]['customer_name'] ;?></td>
														<td><?php
															if($value['customer_id']==$value['user_id']){
																$user_q    = $this->db->query("select * from tbl_customers where customer_id=".$value['user_id']);
																
																$userData     = $user_q->row_array();
																echo $userData['customer_name'];
															}else{
																$user_q    = $this->db->query("select * from tbl_users where user_id=".$value['user_id']);
																
																$userData     = $user_q->row_array();
																echo $userData['username'];
															}
														
														
														?>
														</td>
														<td><?php echo $value['edited_date']; ?></td>
														<td><?php echo $value['edited_by']; ?></td>
														<td><?php echo $value['edited_branch']; ?></td>
														<td><?php echo $value['eway_no']; ?></td>
														<td><?php echo $value['frieht']; ?></td>
														<td><?php echo $value['transportation_charges']; ?></td>
														<td><?php echo $value['pickup_charges']; ?></td>
														<td><?php echo $value['delivery_charges']; ?></td>
														<td><?php echo $value['insurance_charges']; ?></td>
														<td><?php echo $value['courier_charges']; ?></td>
														<td><?php echo $value['awb_charges']; ?></td>
														<td><?php echo $value['other_charges']; ?></td>
														<td><?php echo $value['green_tax']; ?></td>
														<td><?php echo $value['appt_charges']; ?></td>
														<td><?php echo $value['fov_charges']; ?></td>
														<td><?php echo $value['total_amount']; ?></td>
														<td><?php echo $value['fuel_subcharges']; ?></td>
														<!-- <td><?php // echo $value['eway_expiry_date'];
																	?></td> -->
														<?php
														if ($value['isVerified'] == 1 && $viewVerified != 2) {  ?>
															<td><?php echo $value['verifier_name']; ?></td>
														<?php
														}
														$city_id2 = $value['sender_city'];
														$resAct = $this->db->query("select * from tbl_city where city_id='$city_id2'");
														$city_sender1 = $resAct->row_array();
                                                        $city_sender  = $city_sender1['city_name'];

														$city_id3 = $value['reciever_city'];
														$resActs = $this->db->query("select * from tbl_city where city_id='$city_id3'");
														$city_reciver1 = $resActs->row_array();
														$city_reciver = $city_reciver1['city_name'];

														//print_r($city_reciver);
														$print_string = $value['pod_no'] . '#|#' . $city_sender . '#|#' . $city_reciver . '#|#' . $value['mode_dispatch'] . '#|#' . $value['no_of_pack'] . '#|#' . $value['reciever_address'];
														$print_string = base64_encode($print_string);
														$print_string = rtrim($print_string, '=');


														?>
														<td>
															<a href="admin/domestic_printpod/<?php echo $value['booking_id']; ?>" target="_blank" title="Print"><i class="fas fa-print" style="color:var(--success)"></i></a>&nbsp;
															<a target="_blank" href="<?php echo base_url(); ?>admin/domestic_printlabel/<?php echo $print_string; ?>"><i class="ion-printer"></i></a> &nbsp;
															<?php if ($value['isVerified'] == 0 && $viewVerified != 2) {  ?>
																| <a href="generatepod/verifyPod/<?php echo $value['booking_id']; ?>" class="btn btn-primary"><i class="icon-check"></i></a>
															<?php } ?>
															<?php if ($this->session->userdata("userType") == 1) { ?>
																<!--| &nbsp; <a href="admin/delete-domestic-shipment/<?php echo $value['booking_id']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
																| &nbsp; <a href="javascript:void(0)" relid="<?php echo $value['booking_id']; ?>" title="Delete" class="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
															<?php } ?>
														</td>
													</tr>
											<?php
													$cnt++;
												}
											} else {
												echo str_repeat("<td>", 12);
											}
											?>
										</tbody>
										<input type="hidden" name="selected_campaing" id="selected_campaingss" value="">
									</table>
								</div>
								<div class="row">
									<div class="col-md-6">
										<?php echo $this->pagination->create_links(); ?>
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

	<?php include(dirname(__FILE__) . '/../admin_shared/admin_footer.php'); ?>
	<!-- START: Footer-->
</body>
<!-- END: Body-->

</html>
<script>
	$('#select_multiple_camp').click(function() {
		var pre_selected_cam = $('#selected_campaingss').val();
		if (pre_selected_cam !== null) {
			var nes = pre_selected_cam.slice(0, -1);
			var favorite = [];
			$.each($("input[name='multiple_delete[]']:checked"), function() {
				favorite.push($(this).val());
			});
			favorite = favorite.join("-");

			if (favorite != '') {
				window.location = 'Admin_domestic_shipment_manager/all_printpod/' + favorite + '-' + nes;
			} else {
				alert('Pleaese choose at least one Shipment');
			}
		} else {
			var favorite = [];
			$.each($("input[name='multiple_delete[]']:checked"), function() {
				favorite.push($(this).val());
			});
			favorite = favorite.join("-");

			if (favorite != '') {
				window.location = 'Admin_domestic_shipment_manager/all_printpod/' + favorite;
			} else {
				alert('Pleaese choose at least one Shipment');
			}
		}
	});
	// this function is use for redirecting page on preseleted campaing on schedule page  

	function checkAll(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = true;
				}
			}
		} else {
			for (var i = 0; i < checkboxes.length; i++) {
				console.log(i)
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
		}
	}

	$('.multiple_campings').click(function() {
		var new_sel_cam = $(this).val();
		var pre_selected_cam = $('#selected_campaingss').val();
		if ($(this).prop("checked") == true) {
			$('#selected_campaingss').val(new_sel_cam + '-' + pre_selected_cam);
		} else if ($(this).prop("checked") == false) {
			pre_selected_cam = pre_selected_cam.replace(new_sel_cam + '-', '');
			$('#selected_campaingss').val(pre_selected_cam);
		}

	});

	// this function is use for redirecting page on preseleted campaing on schedule page  
	$('#select_multiple_camp').click(function() {
		var pre_selected_cam = $('#selected_campaingss').val();

		if (pre_selected_cam !== null) {
			var nes = pre_selected_cam.slice(0, -1);
			var favorite = [];
			$.each($("input[name='multiple_delete[]']:checked"), function() {
				favorite.push($(this).val());
			});
			favorite = favorite.join("-");

			if (favorite != '') {
				window.location = 'Admin_domestic_shipment_manager/all_printpod/' + favorite + '-' + nes;
			} else {
				alert('Pleaese choose at least one Shipment');
			}
		} else {
			var favorite = [];
			$.each($("input[name='multiple_delete[]']:checked"), function() {
				favorite.push($(this).val());
			});
			favorite = favorite.join("-");

			if (favorite != '') {
				window.location = 'Admin_domestic_shipment_manager/all_printpod/' + favorite;
			} else {
				alert('Pleaese choose at least one Shipment');
			}
		}


	});


	/* $("#filterpod").validate({
	   rules: {
			from_date: "required",
			to_date: "required"
		},
		errorPlacement: function(error, element) {
			error.insertAfter(element);
		},
		messages: {
			 //email: "Please provide email address"       
		},      
		submitHandler: function(form)
		{
			form.submit();
		}     
	}); */
</script>
<div class="modal fade in" id="modal-default" style="padding-right: 17px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Print Bulk Shipment</h4>
			</div>
			<form name="filterpod" id="filterpod" action="Admin_domestic_shipment_manager/all_printpod" method="POST">
				<div class="modal-body">
					<div class="col-md-4">
						<label>Customer</label>
						<select class="form-control" name="user_id">
							<?php if (!empty($customer)) {
								foreach ($customer as $key => $values) { ?>
									<option value="<?php echo $values->customer_id; ?>"><?php echo $values->customer_name; ?></option>
							<?php
								}
							} ?>
						</select>

					</div>
					<div class="col-md-4">
						<label>From Date</label>
						<input type="date" class="form-control" name="from_date" value="<?php echo $_GET['from_date']; ?>" />
					</div>
					<div class="col-md-4">
						<label>To Date</label>
						<input type="date" class="form-control" name="to_date" value="<?php echo $_GET['to_date']; ?>" />
					</div>
					<div class="col-md-4">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Print</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
<script>
	function matchStart(term, text) {
		if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
			return true;
		}

		return false;
	}

	$.fn.select2.amd.require(['select2/compat/matcher'], function(oldMatcher) {
		$("#user_id").select2({
			matcher: oldMatcher(matchStart)
		})

	});
</script>

<script>
	$(document).ready(function() {
		$('.deletedata').click(function() {
			var getid = $(this).attr("relid");
			// alert(getid);
			var baseurl = '<?php echo base_url(); ?>'
			swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
			}).then((result) => {
				if (result.value) {
					$.ajax({
							url: baseurl + 'Admin_domestic_shipment_manager/delete_domestic_shipment',
							type: 'POST',
							data: 'getid=' + getid,
							dataType: 'json'
						})
						.done(function(response) {
							swal('Deleted!', response.message, response.status)

								.then(function() {
									location.reload();
								})

						})
						.fail(function() {
							swal('Oops...', 'Something went wrong with ajax !', 'error');
						});
				}

			})

		});

	});
</script>