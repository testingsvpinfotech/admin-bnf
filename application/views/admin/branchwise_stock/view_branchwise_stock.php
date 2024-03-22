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
	<main> <br><br>
		<div class="container-fluid site-width">
			<!-- START: Listing-->
			<div class="row">
				<div class="col-12  align-self-center">
					<div class="col-12 col-sm-12 mt-3">
						<div class="card">
							<div class="card-header justify-content-between align-items-center">
								<h4 class="card-title">AWB Stock In Branch </h4>
								<!--  <span style="float: right;"><a href="admin/view-add-domestic-shipment" class="fa fa-plus btn btn-primary">Add Domestic Shipment</a></span> -->
								<br><br>
							</div>

							<div class="card-body">
								<?php if ($this->session->flashdata('notify') != '') { ?>
									<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
								<?php unset($_SESSION['class']);
									unset($_SESSION['notify']);
								} ?>
								<div class="table-responsive">
									<table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
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
												<th scope="col">Booking date</th>
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
												<th scope="col">Current Status</th>

												<!-- <th scope="col">Eway Expiry date</th> -->
												
											</tr>
										</thead>
										<tbody>
											<?php
											if (!empty($allpoddata)) {
												$cnt = 1;
												$i = 1;

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
                                                          <?=  $i++;?>
															<!-- <div class="custom-control custom-checkbox custom-control-inline">
																<input type="checkbox" class="custom-control-input multiple_campings" value="<?php echo $value['booking_id']; ?>" id="customCheck<?php echo $cnt; ?>" name="multiple_delete[]">
																<label class="custom-control-label" for="customCheck<?php echo $cnt; ?>"></label>
															</div> -->
														</td>
														<td style="width: 11%;">
															<?php

															echo '<a href="' . base_url() . 'users/track_shipment?pod_no=' . $value['pod_no'] . '&submit=1" target="_blank" title="Track" class="ring-point" ><i class="ion-radio-waves"></i></a>';

															$userType = $this->session->userdata("userType");
                                                            //  echo '<pre>';print_r($Branch);
															
																echo '<br>' . $value['pod_no'];
															 ?>
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
														<?php $pod = $value['pod_no'];$track = $this->db->query("select * from tbl_domestic_tracking where pod_no ='$pod' order by id desc limit 1")->row(); ?>
														<td><?php if($track->status == 'In transit'){ echo 'In transit To  '.$track->branch_name;}else{ echo $track->status; }?></td>
														<!-- <td><?php // echo $value['eway_expiry_date'];
																	?></td> -->
														
														
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
									<!-- <div class="col-md-6">
										<?php echo $this->pagination->create_links(); ?>
									</div> -->
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