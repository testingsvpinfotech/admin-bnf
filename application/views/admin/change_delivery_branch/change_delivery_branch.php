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
     								<h4 class="card-title">Change Delivery Branch </h4>
     							</div>
     							<div class="card-body">
     								<?php if ($this->session->flashdata('notify') != '') { ?>
     									<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
     								<?php unset($_SESSION['class']);
											unset($_SESSION['notify']);
										} ?>
     								<div class="row">
     									<div class="col-12">
     										<form role="form" action="<?= base_url(); ?>admin/change-delivery-branch" method="post" enctype="multipart/form-data">
     											<div class="form-group row">
												 <label class="col-sm-1 col-form-label">AWB No</label>
     												<div class="col-sm-2">
     													<input type="text" name="pod_no" id="menifest" class="form-control" value="<?php if(! empty($_POST['pod_no'])){ echo $_POST['pod_no']; }?>"/>
     												</div>
     												<div class="col-sm-2">
     													<button type="submit" name="search" class="btn btn-primary">Search</button>
														<a href="<?= base_url('admin/change-delivery-branch');?>" class="btn btn-info" >Reset</a>
     												</div>
     											</div>
     										</form> <br> 
											<?php if(! empty($result)){ ?>
     										<form role="form" action="<?= base_url('admin/change-delivery-branch-update'); ?>" method="post" enctype="multipart/form-data">
     											<div class="form-group row">

     												
     												<label class="col-sm-2 col-form-label">Current Branch</label>
     												<div class="col-sm-2">
														<?php  $branch = $this->db->query("select * from tbl_branch where branch_id ='$result->current_branch'")->row(); ?>
     													<input type="text" readonly value="<?=  $branch->branch_name; ?>" class="form-control" />
     												</div>
     												<label class="col-sm-2 col-form-label">Current Status</label>
     												<div class="col-sm-2">
													 <?php  $last = $this->db->query("select * from tbl_domestic_tracking where pod_no ='$result->pod_no' order by id desc")->row(); ?>
     													<input type="text" readonly class="form-control" value="<?= $last->status; ?>"/>
     												</div>
													 <label class="col-sm-2 col-form-label">Origin</label>
     												<div class="col-sm-2">
													 <?php  $s_city = $this->db->query("select * from city where id ='$result->sender_city'")->row(); ?>
     													<input type="text" readonly class="form-control" value="<?= $s_city->city; ?>"/>
     												</div>
     											</div>
     										
												<div class="form-group row mt-3">
												<label class="col-sm-2 col-form-label">Destination Pincode</label>
     												<div class="col-sm-2">
     													<input type="text" readonly class="form-control" value="<?= $result->destination_pincode;?>"/>
     												</div>
												<label class="col-sm-2 col-form-label">Destination</label>
     												<div class="col-sm-2">
													 <?php  $r_city = $this->db->query("select * from city where id ='$result->reciever_city'")->row(); ?>
     													<input type="text" readonly class="form-control" value="<?= $r_city->city ?>"/>
     													<input type="hidden" name="pod_no" readonly class="form-control" value="<?= $result->pod_no; ?>"/>
     												</div>
												    <label class="col-sm-2 col-form-label">Delievry Brnach</label>
     												<div class="col-sm-2">
														<select class="form-control" name="branch_name" required>
															<option >-- Select Branch --</option>
															<?php 
															$branch = $this->db->query("select * from tbl_branch")->result();
															foreach($branch as $key => $value){ if($value->branch_id != 39){?>
															<option value="<?= $value->branch_id;?>"><?= $value->branch_name;?></option>
															<?php }}?>
														</select>
     												</div>
													
												  <div class="col-md-12">
     													<div class="box-footer ">
     														<button type="submit" name="submit" class="btn btn-primary">Submit</button>
     													</div>

     												</div>
     											</div>     										
     										</form>
											<?php } ?>
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