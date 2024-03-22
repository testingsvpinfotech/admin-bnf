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
								<br><br><h4 class="card-title">Booking Charges</h4>
							</div>

							<div class="card-header justify-content-between align-items-center">
								<span>
									<form role="form" action="admin/view-booking-charges" method="post" enctype="multipart/form-data">
										<div class="form-row">
											<div class="col-md-3">
												<label for="">Customer</label>
												<select class="form-control" name="user_id" id="user_id">
													<option value="">Selecte Customer</option>
													<?php if (!empty($customer)) {
														foreach ($customer as $key => $values) { ?>
															<option value="<?php echo $values['customer_id']; ?>" <?php echo (isset($user_id) && $user_id == $values['customer_id']) ? 'selected' : ''; ?>><?php echo $values['customer_name']; ?></option><?php }
																																																													} ?>
												</select>
											</div>

											<div class="col-sm-2">
												<label for="">From Date</label>
												<input type="date" name="from_date" value="<?php echo (isset($from_date)) ? $from_date : ''; ?>" id="from_date" autocomplete="off" class="form-control">
											</div>

											<div class="col-sm-2">
												<label for="">To Date</label>
												<input type="date" name="to_date" value="<?php echo (isset($to_date)) ? $to_date : ''; ?>" id="to_date" autocomplete="off" class="form-control">
											</div>
											<div class="col-sm-2">
												<input type="submit" class="btn btn-primary" name="submit" value="Filter">
												<!-- <input type="submit" class="btn btn-primary" name="download_report" value="Download Report"> -->
												<a href="admin/view-booking-charges" class="btn btn-info">Reset</a>
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
									<table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
										<!-- id="example"-->
										<thead>
											<tr>
												<th scope="col">SR No </th>
												<th scope="col">AWB.No</th>
												<th scope="col">Consigner</th>
												<th scope="col">Mode</th>
												<th scope="col">Booking date</th>
												<th scope="col">Branch Name</th>
												<th scope="col">Origin</th>
												<th scope="col">Destination</th>
												<th scope="col">Frieht Charges</th>
												<th scope="col">Transportation Charges</th>
												<th scope="col">Pickup Charges</th>
												<th scope="col">Delivery Charges</th>
												<th scope="col">Insurance Charges</th>
												<th scope="col">Courier Charges</th>
												<th scope="col">AWB Charges</th>
												<th scope="col">Others Charges</th>
												<th scope="col">Topay Charges</th>
												<th scope="col">Appointment Charges</th>
												<th scope="col">Fov Charges</th>
												<th scope="col">Total </th>
												<th scope="col"> Fuel Charges </th>
												<th scope="col">Sub Total</th>

											</tr>
										</thead>
										<tbody>
											<?php
											if (!empty($allpoddata)) {
												$cnt = 0;

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
														<?php echo $cnt; ?>
														</td>
														<td style="width: 11%;">
														<?php echo $value['pod_no']; ?>
														</td>
														<td><?php echo $value['sender_name']; ?></td>
														<td><?php echo $mode_details->mode_name; ?></td>
														<td><?php echo date('d-m-Y', strtotime($value['booking_date'])); ?></td>
														<?php
														$branch_id = $value['branch_id'];
													//	$whr_u = array('branch_id' => $value['branch_id']);
														$branch_details = $this->db->query("select branch_name from  tbl_branch where branch_id ='$branch_id' ")->row_array();
														//$branch_details = $this->basic_operation_m->get_table_row('tbl_branch', $whr_u);
														?>
														<td><?php  echo substr($branch_details['branch_name'], 0, 20); ?></td>
														<?php $city_id2 = $value['sender_city'];
														$resAct = $this->db->query("select * from tbl_city where city_id='$city_id2'");
														$city_sender1 = $resAct->row_array();
                                                        $city_sender  = $city_sender1['city_name'];
														$city_id3 = $value['reciever_city'];
														$resActs = $this->db->query("select * from tbl_city where city_id='$city_id3'");
														$city_reciver1 = $resActs->row_array();
														$city_reciver = $city_reciver1['city_name'];
														?>
														<td><?php  echo $city_sender; ?></td>
														<td><?php  echo $city_reciver; ?></td>
														<td><?php  echo $value['frieht']; ?></td>
														<td><?php  echo $value['transportation_charges']; ?></td>
														<td><?php  echo $value['pickup_charges']; ?></td>
														<td><?php  echo $value['delivery_charges']; ?></td>
														<td><?php  echo $value['insurance_charges']; ?></td>
														<td><?php  echo $value['courier_charges']; ?></td>
														<td><?php  echo $value['awb_charges']; ?></td>
														<td><?php  echo $value['other_charges']; ?></td>
														<td><?php  echo $value['green_tax']; ?></td>
														<td><?php  echo $value['appt_charges']; ?></td>
														<td><?php  echo $value['fov_charges']; ?></td>
														<td ><?php  echo $value['total_amount']; ?></td>
														<td ><?php  echo $value['fuel_subcharges']; ?></td>
														<td ><?php  echo $value['sub_total']; ?></td>
														
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