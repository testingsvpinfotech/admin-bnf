     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
     <!-- END Head-->
     <style>
     	.input:focus {
     		outline: outline: aliceblue !important;
     		border: 2px solid red !important;
     		box-shadow: 2px #719ECE;
     	}
     </style>
     <!-- START: Body-->

     <body id="main-container" class="default">


     	<!-- END: Main Menu-->
     	<?php $this->load->view('admin/admin_shared/admin_sidebar');
			// include('admin_shared/admin_sidebar.php'); 
			?>
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
     								<h4 class="card-title">Master Menifest In Scan</h4>
     							</div>
     							<div class="card-body">
     								<?php if ($this->session->flashdata('notify') != '') { ?>
     									<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
     								<?php unset($_SESSION['class']);
											unset($_SESSION['notify']);
										} ?>
     								<div class="row">
     									<div class="col-12"> <a href="<?= base_url('admin/view-genrated-in-scan'); ?>" class="btn btn-primary">View Master Menifest In Scan</a> <br><br>
     										<form role="form" action="<?= base_url(); ?>admin/gatepass-in-scan" method="post" enctype="multipart/form-data">
     											<div class="form-group row">
     												<label class="col-sm-2 col-form-label">Master Menifest No</label>
     												<div class="col-sm-2">
     													<input type="text" name="gatepass_no" id="awb" class="form-control" />
     												</div>
     												<div class="col-sm-2">
     													<button type="submit" name="submit" class="btn btn-primary">Search</button>
     												</div>
     											</div>
     										</form> <br> 
     										<form role="form" action="<?= base_url('admin/add-gatepass-in-scan'); ?>" method="post" enctype="multipart/form-data">
     											<div class="form-group row">

     												<label class="col-sm-2 col-form-label">In Scan Date</label>
     												<div class="col-sm-2">
     													<!--<input type="datetime-local" class="form-control" name="datetime" id="col-sm-1 col-form-label" >-->

     													<?php
															$datec = date('Y-m-d H:i');

															// $tracking_data[0]['tracking_date'] = date('Y-m-d H:i',strtotime($tracking_data[0]['tracking_date']));
															$datec  = str_replace(" ", "T", $datec);


															// $datec = dateTimeValue($datec);
															// $datec = str_replace(' ', 'T', $datec);
															?>
     													<input type="datetime-local" readonly required class="form-control" name="datetime" value="<?php echo $datec; ?>"  id="mastermenifest_back" min="<?= date('Y-m-d', strtotime("-1 days")).'T'.date('H:i'); ?>" max="<?= date('Y-m-d').'T'.date('H:i'); ?>">
     												</div>
     												<label class="col-sm-2 col-form-label">Genrated By</label>
     												<div class="col-sm-2">
     													<input type="text" readonly name="username" required value="<?= $this->session->userdata("userName"); ?>" class="form-control" />
     												</div>
													 <label  class="col-sm-2 col-form-label menimaster_check" id="bkdate_meni_check" style="display:none;">Back Date Reason<span class="compulsory_fields" >*</span></label>
												<div class="col-sm-2 menimaster_check" id="bkdate_meni_check" style="display:none;">
													<textarea type="text" name="bkdate_reason" id="masterm_reason" class="form-control" value="<?php //echo $bid; ?>"></textarea>
												</div>
     											</div>
     				
											
                                                 

												 <br>

     											<div class="col-md-12">
     												<!--  col-sm-4-->
													<!-- <span style="color:red;">Note : Shipments are destination branch then check all</span> -->
     												<table class="table table-bordered table-striped">
     													<thead>
														 <tr>
     															<th>
																	<!-- <INPUT type="checkbox" id="cb"onchange="checkAll(this)" /> -->
																</th>
     															<th>Date</th>
																<th>Menifest ID </th>
     															<th>Orgin Branch</th>
     															<th>Destination Branch</th>
																 <th>Remarks</th>
     															<th>Made By</th>
     														</tr>
     													</thead>
     													<tbody>
															<?php $count = 1; if($result){  foreach ($result as $key=>$value) { ?>
																<tr>
																	<td>
																	<input type="hidden"  id="uncheckId_<?= $count ?>" class="uncheck_all" name="manifiest_uncheck[]" value="<?php echo $value->manifiest_id;?>">
																	<input type='checkbox' class='cb' id="custId_<?= $count ?>" required name='manifiest_check[]' onchange="check(<?= $count ?>)" value='<?= $value->manifiest_id;?>'>
																    </td>
																	<td><?php echo $value->date_added;?></td>
																	<td><?php echo $value->manifiest_id;?></td>
																	<td><?php echo $value->source_branch;?></td>
																	<td><?php echo $value->destination_branch;?></td>
																	<td><textarea name="remark[]" placeholder="Remarks" class="form-control"></textarea></td>
																	<td><?php echo $value->username;?></td>
																
																</tr>
															<?php $count++; }} ?>
     													</tbody>

     												</table>
     												<!--  box body-->
     												<div class="col-md-3">
     													<div class="box-footer pull right">
     														<button type="submit" name="submit" class="btn btn-primary">Submit</button>
     													</div>

     												</div>
     											</div>
     										</form>
     									</div>
     								</div>

     							</div>
     						</div>
     						<!-- END: Listing-->
     					</div>
     	</main>
     	<!-- END: Content--> <?php ini_set('display_errors', '0');
								ini_set('display_startup_errors', '0');
								error_reporting(E_ALL); ?>
     	<!-- START: Footer-->
     	<?php $this->load->view('admin/admin_shared/admin_footer');
			//include('admin_shared/admin_footer.php'); 
			?>
     	<!-- START: Footer-->
     </body>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/jQueryScannerDetectionmaster/jquery.scannerdetection.js"></script>

     <script type="text/javascript">


              function check(ele) {
				var check = $('#custId_'+ele).val();
				
				$.ajax({
					url: "<?php echo base_url() . 'Admin_gatepass_in_scan/check_destination'; ?>",
     				type: 'POST',
     				data: 'manifest='+check,
					 success: function(data) {
     					// console.log(data);
						if(data==1){
						 $("#uncheckId_"+ele).attr("disabled",true);
						 $('#custId_'+ele).attr("disabled",false);
						 $('#custId_'+ele).prop('checked', true);
						}else{
							$("#uncheckId_"+ele).attr("disabled",false);
							$('#custId_'+ele).attr("disabled",true);
							$('#custId_'+ele).prop('checked', false);
						}
					 }
				});
				// if ($('#custId_'+ele).is(":checked")){
				// 	$("#uncheckId_"+ele).attr("disabled",true);
				// }else{
				// 	$("#uncheckId_"+ele).attr("disabled",false);
				// }
			}

		function checkAll(ele) {
		document.getElementsByClassName('uncheck_all').disabled = true;
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = true;					
				}
			}
			
		} else {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
			// document.getElementsByClassName('uncheck_all').disabled = false;
		}
	}
     	$(document).scannerDetection({
     		timeBeforeScanTest: 200, // wait for the next character for upto 200ms
     		startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
     		endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
     		avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
     		onComplete: function(barcode, qty) {
     			var forwording_no = barcode;

     			var forwarderName = $("#forwarderName").val();
     			var forwarder_mode = $("#forwarder_mode").val();

     			var message = '';

     			$("input[name='pod_no[]']").map(function() {
     				var numbers = $(this).val();

     				var number = numbers.split("|");

     				if (number[0] == forwording_no) {
     					message = 'This Forwording No Already Exist In The List!';
     					// return false;
     				}
     			}).get();

     			if (message != '') {
     				alert(message);
     				return false;
     			}
     			$.ajax({
     				url: "<?php echo base_url() . 'Admin_domestic_menifiest/awbnodata'; ?>",
     				type: 'POST',
     				dataType: "html",
     				data: {
     					forwording_no: forwording_no,
     					forwarderName: forwarderName,
     					forwarder_mode: forwarder_mode
     				},
     				error: function() {
     					alert('Please Try Again Later');
     				},
     				success: function(data) {
     					console.log(data);

     					if (data != "") {
     						$("#change_status_id").prepend(data);
     						var array = [];

     						tw = 0;
     						tp = 0;

     						$("input.cb[type=checkbox]:checked").each(function() {

     							tw = tw + parseFloat($(this).attr("data-tw"));
     							tp = tp + parseFloat($(this).attr("data-tp"));

     						});

     						document.getElementById('total_weight').value = tw;
     						document.getElementById('total_pcs').value = tp;

     					} else {
     						$("#change_status_id").prepend('');
     					}
     					$("#search_data").val('');
     					$("#search_data").focus();
     					//alert("Record added successfully");  
     				},
     				error: function(response) {
     					console.log(response);
     				}
     			});
     		} // main callback function	
     	});
     </script>
     <!-- END: Body-->
     <script type="text/javascript">
     	$(document).ready(function() {
			$('#cb').click(function() {
        if ($(this).is(':checked')) {
            $('.uncheck_all').prop('disabled', true);
        } else {
			$('.uncheck_all').prop('disabled', false);   
        }
		});
			$('#bkdate_meni_check').css({"display":"none"});
	$("#mastermenifest_back").change(function(){
		let dt = $("#mastermenifest_back").val();
		var bdt = new Date(dt);
		var bmonth = bdt.getMonth()+1; var bday = bdt.getDate();
		var boutput = bdt.getFullYear() + '/' + (bmonth<10 ? '0' : '') + bmonth + '/' +  (bday<10 ? '0' : '') + bday;

		var d = new Date();
		var month = d.getMonth()+1; var day = d.getDate();

		var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' +  (day<10 ? '0' : '') + day;
		if(output == boutput){
			// $("#bkdate_reason").attr("required", "false");
			$("#masterm_reason").removeAttr("required");
			$('.menimaster_check').css({"display":"none"});
		}else{
			$("#masterm_reason").attr("required", "true");
			$('.menimaster_check').css({"display":"flex"});
		}
	});
     		$(window).keydown(function(event) {
     			if (event.keyCode == 13) {
     				//var awb_no=$(this).val();
     				var forwording_no = $("#search_data").val();
     				var forwarderName = $("#forwarderName").val();
     				var forwarder_mode = $("#forwarder_mode").val();

     				if (forwording_no != "") {


     					var message = '';

     					$("input[name='pod_no[]']").map(function() {
     						var numbers = $(this).val();

     						var number = numbers.split("|");

     						if (number[0] == forwording_no) {
     							message = 'This Forwording No Already Exist In The List!';
     							// return false;
     						}
     					}).get();

     					if (message != '') {
     						alert(message);
     						return false;
     					}
     					$.ajax({
     						url: "Admin_domestic_menifiest/awbnodata",
     						type: 'POST',
     						dataType: "html",
     						data: {
     							forwording_no: forwording_no,
     							forwarderName: forwarderName,
     							forwarder_mode: forwarder_mode
     						},
     						success: function(data) {
     							console.log(data);
     							if (data != "") {
     								$("#change_status_id").prepend(data);
     								var array = [];

     								tw = 0;
     								tp = 0;

     								$("input.cb[type=checkbox]:checked").each(function() {

     									tw = tw + parseFloat($(this).attr("data-tw"));
     									tp = tp + parseFloat($(this).attr("data-tp"));

     								});

     								document.getElementById('total_weight').value = tw.toFixed(2);
     								document.getElementById('total_pcs').value = tp;
     							} else {
     								$("#change_status_id").prepend('');
     							}
     							$("#search_data").val('');
     						}

     					});

     				} else {
     					alert("Please enter Forwording no");
     				}

     			}
     		});


     		$("#btn_search").click(function() {
     			//var awb_no=$(this).val();
     			var forwording_no = $("#search_data").val();
     			var forwarderName = $("#forwarderName").val();
     			var forwarder_mode = $("#forwarder_mode").val();



     			// console.log(all);

     			if (forwording_no != "") {

     				forwording_no = forwording_no.trim();

     				var message = '';

     				$("input[name='pod_no[]']").map(function() {
     					var numbers = $(this).val();

     					var number = numbers.split("|");

     					if (number[0] == forwording_no) {
     						message = 'This Forwording No Already Exist In The List!';
     						// return false;
     					}
     				}).get();

     				if (message != '') {
     					alert(message);
     					return false;
     				}
     				$.ajax({
     					url: "Admin_domestic_menifiest/awbnodata",
     					type: 'POST',
     					dataType: "html",
     					data: {
     						forwording_no: forwording_no,
     						forwarderName: forwarderName,
     						forwarder_mode: forwarder_mode
     					},
     					success: function(data) {
     						console.log(data);
     						if (data != "") {
     							$("#change_status_id").prepend(data);
     							var array = [];

     							tw = 0;
     							tp = 0;

     							$("input.cb[type=checkbox]:checked").each(function() {

     								tw = tw + parseFloat($(this).attr("data-tw"));
     								tp = tp + parseFloat($(this).attr("data-tp"));

     							});

     							document.getElementById('total_weight').value = tw.toFixed(2);
     							document.getElementById('total_pcs').value = tp;
     							$("#search_data").val('');
     						} else {
     							$("#change_status_id").prepend('');
     						}
     						$("#search_data").focus();

     					}

     				});

     			} else {
     				alert("Please enter Forwording no");
     			}



     		});

     		$("#podbox").change(function() {

     			var podno = $(this).val();
     			if (podno != null || podno != '') {

     				$.ajax({
     					type: 'POST',
     					url: '<?php echo base_url() ?>menifiest/getPODDetails',
     					data: 'podno=' + podno,
     					success: function(d) {
     						//alert(d);
     						var x = d.split("-");
     						//alert(x);
     						$(".consignername").val(x[0]);

     						$(".pieces").val(x[2]);
     						$(".weight").val(x[3]);
     					}
     				});
     			} else {

     			}

     		});


     		var tw;
     		var tp;

     		$(document).on("click", ".cb", function() {


     			var array = [];

     			tw = 0;
     			tp = 0;

     			$("input.cb[type=checkbox]:checked").each(function() {

     				tw = tw + parseFloat($(this).attr("data-tw"));
     				tp = tp + parseFloat($(this).attr("data-tp"));


     			});

     			document.getElementById('total_weight').value = tw;
     			document.getElementById('total_pcs').value = tp;

     		});



     		$('#example1').DataTable({
     			'paging': true,
     			'lengthChange': true,
     			'searching': true,
     			'ordering': true,
     			'info': true,
     			'autoWidth': true

     		});
     	});
     	$(document).keypress(
     		function(event) {
     			if (event.which == '13') {
     				event.preventDefault();
     			}
     		});
     </script>

     <?php

		function dateTimeValue($timeStamp)
		{
			$date = date('d-m-Y', $timeStamp);
			$time = date('H:i:s', $timeStamp);
			return $date . 'T' . $time;
		}

		?>