     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.input:focus {
    outline: outline: aliceblue !important;
    border:2px solid red !important;
    box-shadow: 2px #719ECE;
  }
  </style>
    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">Add Bag Generator</h4>  
                          </div>
                          <div class="card-body">
                          	 <?php if($this->session->flashdata('notify') != '') {?>
                             <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>                             
						   <div class="row">                                           
                            <div class="col-12">
							<a href="<?= base_url('admin/view-bag-genrated'); ?>" class="btn btn-primary">View Genrated Bag</a> <br><br>
     										<form role="form" action="<?= base_url('admin/add-bag-genrate'); ?>" method="post" enctype="multipart/form-data">
     											<div class="form-group row">
												
     												<label class="col-sm-1 col-form-label">AWB No</label>
     												<div class="col-sm-2">
     													<input type="text" name="awb_no" id="awb" class="form-control" />
     												</div>
     												<div class="col-sm-2">
     													<button type="submit" name="submit" class="btn btn-primary">Search</button>
     												</div>
     											</div>
     										</form> <br> 
								<form role="form" action="<?php base_url('admin/add-bag-genrate');?>" method="post" enctype="multipart/form-data">

								<div class="form-group row" >
									
									<label  class="col-sm-2 col-form-label">Bag generator Date</label>
									<div class="col-sm-2">
										<!--<input type="datetime-local" class="form-control" name="datetime" id="col-sm-1 col-form-label" >-->

										<?php 
											$datec = date('Y-m-d H:i');

											// $tracking_data[0]['tracking_date'] = date('Y-m-d H:i',strtotime($tracking_data[0]['tracking_date']));
                                      		$datec  = str_replace(" ", "T", $datec);
											

											// $datec = dateTimeValue($datec);
											// $datec = str_replace(' ', 'T', $datec);
										?>
										<input type="datetime-local" required class="form-control" name="datetime" value="<?php echo $datec;?>" id="col-sm-1 col-form-label" >
									</div>
									<label  class="col-sm-2 col-form-label">Bag Name</label>
									<div class="col-sm-2">
										<input type="text" name="bag_name" required class="form-control" />
									</div>
									
									<label  class="col-sm-2 col-form-label">Vehicle No</label>
									<div class="col-sm-2">
										<input type="text" name="lorry_no" class="form-control" />
									</div>
									
								</div>
								<div class="form-group row">
															
									<label  class="col-sm-2 col-form-label">Driver Name</label>
									<div class="col-sm-2">
										<input type="text" name="driver_name" class="form-control" />
									</div>
									<label  class="col-sm-2 col-form-label">Destination Branch</label>
									<div class="col-sm-2">
										<select name="destination_branch" class="form-control" id="destination_branch" required>
											<option>Select Branch</option>
											<?php foreach ($all_branch as $value) {
												?>
												<option value="<?php echo $value['branch_name'];?>"><?php echo $value['branch_name'];?></option>
												<?php 
											} ?>
										</select>
									</div>
									<label  class="col-sm-2 col-form-label">Mode</label>
									<div class="col-sm-2">
									<select name="forwarder_mode" class="form-control" id="forwarder_mode" required>
										<option value="">Select Forworder Mode</option>
										<option value="All">All</option>
										<?php foreach ($mode_list as $value) {
										?>
										<option value="<?php echo $value['mode_name'];?>"><?php echo $value['mode_name'];?></option>
										<?php 
									} ?>
									</select>
									</div>
									
								</div>
								<div class="form-group row">
								<label  class="col-sm-2 col-form-label">Route Name</label>
									<div class="col-sm-2">
										<select name="route_id" class="form-control" id="route_id" required>
											<option>Select Route</option>
											<?php foreach ($allroute as $value) {
												?>
												<option value="<?php echo $value['route_id'];?>"><?php echo $value['route_name'];?></option>
												<?php 
											} ?>
										</select>
									</div>	
									
									
									<label  class="col-sm-2 col-form-label">Genrated By</label>									<div class="col-sm-2">										
										<input type="text" readonly name="username" required value="<?= $this->session->userdata("userName");?>" class="form-control"/>
									</div>
 								</div> <?php $value =  $result[0];?> 
								 <input type="hidden" id="custId" name="pod_no" value="<?php echo $value->pod_no;?>">
								 <input type="hidden" id="custId" name="sender_name" value="<?php echo $value->sender_name;?>">
								 <input type="hidden" id="custId" name="mode_name" value="<?php echo $value->mode_name;?>">
								 <input type="hidden" id="custId" name="booking_date" value="<?php echo $value->booking_date;?>">
								 <input type="hidden" id="custId" name="forworder_name" value="<?php echo $value->forworder_name;?>">
								 <input type="hidden" id="custId" name="forwording_no" value="<?php echo $value->forwording_no;?>">
								 <input type="hidden" id="custId" name="dispatch_details" value="<?php echo $value->dispatch_details;?>">
								<div class="col-md-3">
								<div class="box-footer pull right">
								<button type="submit" name="submit"  class="btn btn-primary">Submit</button>
								</div>
								</form> 
								</div>
								
									<table class="table table-bordered table-striped">
										<thead>
										<tr>
											<th></th>
											<th>AWB No.</th>
											<th>Consignee</th>
											<th>Mode</th>
											<th>Booking From</th>
											<th>Forworder Name</th>
											<th>Forworder No</th>
											<th>Dispatch Details</th>
										</tr>
										</thead>
										<tbody>
										<?php $count = 1; if($result){  foreach ($result as $key=>$value) { ?>
																<tr>
																	<td><?= $count++; ?></td>
																	<td><?php echo $value->pod_no;?></td>
																	<td><?php echo $value->sender_name;?></td>
																	<td><?php $whr =array('transfer_mode_id'=> $value->mode_dispatch); 
																	$res		=	$this->basic_operation_m->getAll('transfer_mode',$whr);
		                                                              echo	$res->row()->mode_name;?></td>
																	<td><?php echo $value->booking_date;?></td>
																	<td><?php echo $value->forworder_name;?></td>
																	<td><?php echo $value->forwording_no;?></td>
																	<td><?php echo $value->dispatch_details;?></td>
																	
																</tr>
															<?php }} ?>
										</tbody>

									</table> 
								<!--  box body-->
								</div>
								
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
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>


<?php 

function dateTimeValue($timeStamp)
{
    $date = date('d-m-Y',$timeStamp);
    $time = date('H:i:s',$timeStamp);
    return $date.'T'.$time;
}

?>