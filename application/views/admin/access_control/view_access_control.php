     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
     <style>
    .buttons-copy{display: none;}
    .buttons-csv{display: none;}
    /*.buttons-excel{display: none;}*/
    .buttons-pdf{display: none;}
    .buttons-print{display: none;}
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
  }
  </style>     
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
                              <h4 class="card-title">Access Block List</h4> 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;">Add Block Access</button>							  
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="display table table-bordered" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Customer</th>
											  <th scope="col">Status</th>
                                              <th scope="col">Reason</th>
                                              <th scope="col">Block Access</th>
											  <th scope="col">Date</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                        <?php
                                        if (!empty($block_info)) {
                                          $cnt=0;
                                            foreach ($block_info as $value) {
                                              $cnt++;
                                                ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $customer_info->customer_name; ?></td> 
                                                <td><?php echo $value->block_status; ?></td> 
                                                <td><?php echo $value->reasone; ?></td> 
                                               
												<td><?php if($value->current_status == '0'){
										?>
											<!-- <a href="javascript:void(0);"><span class="badge btn btn-success"></span></a>		 -->
                      <button type="button" class="btn btn-success"  >Active</button>		
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#upadeModal<?php echo $value->ac_id;?>">Unblock</button>  
										<?php 
									}else{
										?>
											<!-- <a href="javascript:void(0);"><span class="badge bg-danger">Removed</span></a>				 -->
                      <button type="button" class="btn btn-danger"  >Removed</button>									
										<?php 
									};?>
                </td>
									 <td><?php echo $value->b_date; ?>		
                  </td>
                                                <td><?php 
														if($value->current_status == 0)
														{?>
															 <!-- <a href="<?php base_url();?>admin/delete-access-block/<?php echo $value->ac_id;?>" class="btn btn-danger">Unblock</a> -->
                             	 <a href="<?php base_url();?>admin/delete-access-block/<?php echo $value->ac_id;?>/<?php echo $customer_info->customer_id; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
													<?php } ?></td>
                                              
                                            </tr>
                                            <div class="modal fade" id="upadeModal<?php echo $value->ac_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Unblock Access</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form method="post" action="<?php base_url();?>admin/delete-access-block/<?php echo $value->ac_id;?>/<?php echo $customer_info->customer_id; ?>">
                                                
                                                        <div class="col-md-12">
                                                <label>Blocking Reason</label>
                                                <input type="text" name="reasone" class="form-control" required>
                                                </div>
                                                
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<p>No Data Found</p>";
                                    }
                                    ?>
                                    </tbody>
                              </table> 
                          </div>
                      </div>
                    </div> 

                </div>
                </div>
            </div>
            <!-- END: Listing-->
        </div>
		
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Block Access</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
		  <div class="form-row">
            <div class="col-md-12">
		<label>Select Access</label>
		<select name="block_status[]" id="blockstatus" required  class="form-control" multiple>
		<option value="Booking">Booking</option>
		<option value="Menfiest">Menfiest</option>
		<option value="Deliverysheet">Deliverysheet</option>
		<option value="Deliverystatus">Deliverystatus</option>
		</select>
		</div>
             <div class="col-md-12">
		<label>Blocking Reason</label>
		<input type="text" name="reasone" class="form-control">
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
		</form>
      </div>
    </div>
  </div>
</div>

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Block Access</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
		  <div class="form-row">
            <div class="col-md-12">
		<label>Select Access</label>
		<select name="block_status[]" id="blockstatus" required  class="form-control" multiple>
		<option value="Booking">Booking</option>
		<option value="Menfiest">Menfiest</option>
		<option value="Deliverysheet">Deliverysheet</option>
		<option value="Deliverystatus">Deliverystatus</option>
		</select>
		</div>
             <div class="col-md-12">
		<label>Blocking Reason</label>
		<input type="text" name="reasone" class="form-control">
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
		</form>
      </div>
    </div>
  </div>
</div>
		


    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<script type="text/javascript">
 $('#blockstatus').multiselect({});
</script>
<!-- END: Body-->

