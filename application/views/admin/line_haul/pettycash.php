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
                              <h4 class="card-title">Petty Collection</h4>
                              <span style="float: right;">
                              <?php 
                                if($this->session->userdata('userType') == '7')
                                { ?>
                                 <a href="admin/generate-petty-cash/<?php echo $branch_id; ?>" class="btn btn-primary">Genrate Petty Cash</a>
                                 <?php } ?>
                             </span>                          
                          </div>
						   <?php 
                                if($this->session->userdata('userType') == '1')
                                { ?>
							<div class="card-header justify-content-between align-items-center">
								<span>
									<form role="form" action="" method="post" enctype="multipart/form-data">
										<div class="form-row">
											<div class="col-sm-2">
												<label for="">Search Petty Code</label>
												<input type="text" class="form-control" name="petty_code" Placeholder="Search Petty Code" value="">
												</div>
												
													<div class="col-md-2">
														<label for="">All Branch</label>
														<select class="form-control" name="branch_id" id="branch_id">
															<option value="">Selecte Branch</option>
<?php	
															if(!empty($all_branch))	
															{
																foreach ($all_branch as $cc)
																{
																	?>
															<option value='<?php echo $cc->branch_id; ?>'><?php echo $cc->branch_name; ?>
															</option>
<?php 
																}
															}
														?>
														</select>
													</div>
													<div class="col-sm-1">
														<label for="">From Date</label>
														<input type="date" name="from_date" value="<?php echo (isset($from_date))?$from_date:''; ?>" id="from_date" autocomplete="off" class="form-control">
														</div>
														<div class="col-sm-1">
															<label for="">To Date</label>
															<input type="date" name="to_date" id="to_date" value="<?php echo (isset($to_date))?$to_date:''; ?>" autocomplete="off" class="form-control">
															</div>
															<div class="col-sm-2">
																<br>
																 <input type="submit" class="btn btn-primary" name="submit" value="Filter">  
																 <a href="admin/petty-cash" class="btn btn-primary" >Clear</a>  
																	<!-- <input type="submit" class="btn btn-primary" name="Search" value="Search">
																		<!-- <a href="admin/view-international-shipment" class="btn btn-info">Reset</a> -->
																	</div>
																</div>
															</form>
														</span>
													</div>
								<?php } ?>
												
                          <div class="card-body">

                          	<?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                   <table  class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>
                                              <th  scope="col">SR No.</th>
											   <th  scope="col">Date</th>
                                              <th  scope="col">Branch Name</th>
                                              <th  scope="col">Pettycash No</th>
                                              <th  scope="col">Cash Amount</th>
                                              <th  scope="col">Pending Amount</th>
                                              <th  scope="col">UPI Amount</th>
                                              <th  scope="col">Cheque Amount</th>
                                              <th  scope="col">NEFT Amount</th>
                                              <th  scope="col">Total Amount</th>
                                              <th  scope="col">Status</th>
                                              <th  scope="col">Approved By </th>
                                              <th  scope="col">Approved Date</th>
                                              <?php 
                                              if($this->session->userdata('userType') == '1')
                                              { ?>
                                              <th  scope="col">Action</th>
                                              <?php } ?>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      <?php 
                                        if (!empty ($all_petty_cash))
                                        {
                                            $cnt=0;
                                            foreach ($all_petty_cash as $rgn) 
                                            {
                                              $cnt++;
                                              ?>
                                              <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo $rgn['petty_date'];?></td>
                                                <td><?php echo $rgn['branch_name'];?></td>
                                                <td><?php echo $rgn['pc_serial'];?></td>
                                                <td>₹<?php echo $rgn['cash_amount'];?></td>
                                                <td>₹<?php echo $rgn['pending_amount'];?></td>
                                                <td>₹<?php echo $rgn['upi_amount'];?></td>
                                                <td>₹<?php echo $rgn['cheque_amount'];?></td>
                                                <td>₹<?php echo $rgn['neft_amount'];?></td>
                                                <td>₹<?php echo $rgn['total_amount'];?></td>
                                                <td><?php
														if($rgn['pc_status'] == 0)
														{
															echo 'unapproved';
														}
														else
														{
															echo 'Approved';
														}
														?></td>
                                               
												<td>
													<?php 
													  if($rgn['approved_date'] != '0000-00-00 00:00:00')
													  { ?>
														Admin
													<?php } ?>
                                               </td>
											    <td><?php echo $rgn['approved_date'];?></td>
												<td>
											<a href="admin/petty-report/<?php echo $rgn['pc_id'];?>" class="btn btn-warning"><i class="fa fa-info"></i>View</a>
												<?php 
												$userId  = $this->session->userdata('userId');
												if($userId == 1 && $rgn['approved_date'] == '0000-00-00 00:00:00')
												{ 
											//admin/petty-cash-approve/<?php echo $rgn['pc_id']; 
											?>
											<a href="javascript:void(0);" class="btn btn-success pay_amount" data-value="<?php echo $rgn['pc_serial'];?>" data-amount="<?php echo $rgn['total_amount'];?>" data-toggle="modal" data-target="#myModal" href="javascript:void(0);"><i class="fa fa-credit-card"></i> Receive</a>
										<?php 	} ?>
										</td>
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
		
			<!-- Modal -->
							<div class="modal fade" id="myModal" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Received Payment</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
												<form role="form" action="admin/received-petty-cash" method="post" enctype="multipart/form-data">
										<div class="form-row">
													<div class="col-md-6">
														<label for="">Pettycash No</label>
														<input type="text" name="pc_id" readonly class="form-control" id="pc_id" >					
													</div>
													<div class="col-md-6">
														<label for="">Amount</label>
														<input type="text" name="payment_amount" readonly class="form-control" id="payment_amount" >
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
													$('#pc_id').val($(this).attr('data-value'));
												});
												</script>
    </body>
    <!-- END: Body-->
</html>


