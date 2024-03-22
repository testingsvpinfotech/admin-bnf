<?php  $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->



	<!-- START: Body-->
	<body id="main-container" class="default">
		<!-- END: Main Menu-->
   
<?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
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
									<h4 class="card-title">Due Report</h4>
								</span>
							</div>
							<div class="card-header justify-content-between align-items-center">
								<span>
									<form role="form" action="" method="post" enctype="multipart/form-data">
										<div class="form-row">
											
												<div class="col-md-2">
													<label for="">AWB</label>
													<input type="text" class="form-control" name="pod_no" Placeholder="ABW" value="">
													</div>
													<div class="col-md-1">
														<label for="">Contact No</label>
														<input type="text" class="form-control" name="sender_contactno" Placeholder="Contact No" value=""/>
													</div>
													<div class="col-md-2">
														<label for="">All Customer</label>
														<select class="form-control" name="customer_id" id="customer_id">
															<option value="">Selecte Customer</option>
<?php	
															if(!empty($customer))	
															{
																foreach ($customer as $cc)
																{
																	?>
															<option value='<?php echo $cc->customer_id; ?>'><?php echo $cc->customer_name; ?>
															</option>
<?php 
																}
															}
														?>
														</select>
													</div>
													<div class="col-sm-1">
														<label for="">From Date</label>
														<input type="date" name="from_date" value="" id="from_date" autocomplete="off" class="form-control">
														</div>
														<div class="col-sm-1">
															<label for="">To Date</label>
															<input type="date" name="to_date" id="to_date" value="" autocomplete="off" class="form-control">
															</div>
															<div class="col-sm-2">
																<br>
																<input type="submit" class="btn btn-primary" name="submit" value="Filter">  
																 <a href="admin/due-report" class="btn btn-primary" >Clear</a>  
																	<!--<input type="submit" class="btn btn-primary" name="download_report" value="Export Excel">
																		<!-- <a href="admin/view-international-shipment" class="btn btn-info">Reset</a> -->
																	</div>
																</div>
															</form>
														</span>
													</div>
													<div class="card-body">

<?php if($this->session->flashdata('notify') != '') {?>
														<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?>
														</div>
<?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>
														<div class="table-responsive">
															<table class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
																<thead>
																	<tr>
																		<th scope="col">SR No.</th>
																		<th scope="col">Branch</th>
																		<th scope="col">Booking Date</th>
																		<th scope="col">AWB</th>
																		<th scope="col">Origin</th>
																		<th scope="col">Destination</th>
																		<th scope="col">Customer Name</th>
																		<th scope="col">Mobile No</th>
																		<th scope="col">Amount</th>
																		<th scope="col">Status</th>
																		<?php 
												if ($this->session->userdata("userType") == '7') 
												{ ?>
																		<th scope="col">Action</th>
												<?php } ?>
																	</tr>
																</thead>
																<tbody>
<?php 
                                        if (!empty ($all_due_report))
                                        {
                                            $cnt=0;
                                            foreach ($all_due_report as $rgn) 
                                            {
                                              $cnt++;
                                              ?>
																	<tr>
																		<td><?php echo $cnt;?>
																		</td>
																		<td><?php echo $rgn['branch_name'];?>
																		</td>
																		<td><?php echo $rgn['booking_date'];?>
																		</td>
																		<td><?php echo $rgn['pod_no'];?>
																		</td>
																		<td><?php echo $rgn['sender_address'];?>
																		</td>
																		<td><?php echo $rgn['reciever_address'];?>
																		</td>
																		<td><?php echo $rgn['sender_name'];?>
																		</td>
																		<td><?php echo $rgn['sender_contactno'];?>
																		</td>
																		<td>₹<?php echo $rgn['grand_total'];?>
																		</td>
																		<td>Unpaid</td>
																			<?php 
												if ($this->session->userdata("userType") == '7') 
												{ ?>
																		<td>
																			<a class="btn btn-success pay_amount" data-value="<?php echo $rgn['booking_id'];?>" data-amount="<?php echo $rgn['grand_total'];?>" data-toggle="modal" data-target="#myModal" href="javascript:void(0);">Pay</a>
																		</td>
												<?php } ?>
																	</tr>
<?php 
                                            }
                                      }
                                      else
                                      {
                                        echo "<p>No Data Found</p>";
                                      } ?>
																</tbody>
																<input type="hidden" name="selected_campaing" id="selected_campaingss" value="">
																</table>
															</div>
															<div class="row">
																<div class="col-md-6">
<?php //echo $this->pagination->create_links(); ?>
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
<?php $this->load->view('admin/admin_shared/admin_footer');?>
							</body>
							<!-- END: Body-->
							<!-- Modal -->
							<div class="modal fade" id="myModal" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Recived Payment</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
												<form role="form" action="admin/received-domestic-payment" method="post" enctype="multipart/form-data">
										<div class="form-row">
													<div class="col-md-6">
														<label for="">Recived By</label>
														<select class="form-control" name="payment_method" id="payment_method">
															<option value="1">UPI</option>
															<option value="2">Cheque</option>
															<option value="3">Cash</option>
															<option value="4">NEFT</option>
														</select>						
													</div>
													<div class="col-md-6">
														<label for="">Amount</label>
														<input type="text" name="payment_amount" readonly class="form-control" id="payment_amount" >
														<input type="hidden" name="booking_id" readonly class="form-control" id="booking_id" >
													</div>
											</div>
											
											</div>
										<div class="modal-footer">
											<button type="Submit" class="btn btn-default">Pay</button>
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</form>
										</div>
									</div>
												</div>
												</div>
												<script>
												$('.pay_amount').click(function(){
													
													$('#payment_amount').val($(this).attr('data-amount'));
													$('#booking_id').val($(this).attr('data-value'));
												});
												</script>
											</html>
