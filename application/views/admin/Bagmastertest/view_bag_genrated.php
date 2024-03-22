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
     								<h4 class="card-title">Genrated Bags</h4>
     							</div>
     							<div class="card-body">
     								<?php if ($this->session->flashdata('notify') != '') { ?>
     									<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
     								<?php unset($_SESSION['class']);
											unset($_SESSION['notify']);
										} ?>
     								<div class="row">
     									<div class="col-12">
     										<form role="form" action="<?= base_url(); ?>admin/view-genrated-bag" method="post" enctype="multipart/form-data">
     											<div class="form-group row">
     												<label class="col-sm-1 col-form-label">AWB No</label>
     												<div class="col-sm-2">
     													<input type="text" name="bag_no" id="awb" class="form-control" />
     												</div>
     												<div class="col-sm-2">
     													<button type="submit" name="submit" class="btn btn-primary">Search</button>
     												</div>
     											</div>
     										</form> <br>

     											<div class="col-md-12">
     												<!--  col-sm-4-->
     												<table class="table table-bordered table-striped">
     													<thead>
     														<tr>
     															<th></th>
     															<th>Date</th>
																 <th>Menifest ID </th>
     															<th>Bag No </th>
     															<th>Bag Name </th>
     															<th>Orgin Branch</th>
     															<th>Destination Branch</th>
     															<th>Made By</th>
     															<th>Supervisor By</th>
     														</tr>
     													</thead>
     													<tbody>
															<?php $count = 1; if($result){  foreach ($result as $key=>$value) { ?>
																<tr>
																	<td><?= $count++; ?></td>
																	<td><?php echo $value->date_added;?></td>
																	<td><?php echo $value->manifiest_id;?></td>
																	<td><?php echo $value->bag_no;?></td>
																	<td><?php echo $value->bag_name;?></td>
																	<td><?php echo $value->source_branch;?></td>
																	<td><?php echo $value->destination_branch;?></td>
																	<td><?php echo $value->username;?></td>
																	<td><?php echo $value->supervisor;?> <input type="hidden" id="custId" name="pod" value="<?php echo $value->pod_no;?>">
																</tr>
															<?php }} ?>
     													</tbody>

     												</table>

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