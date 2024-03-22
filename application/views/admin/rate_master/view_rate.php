     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

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
                              <h4 class="card-title">Customerwise Rate Details</h4>
                        <?php  if (!empty ($cust)){ ?>
                               <span style="float: right;">
                                 <a href="<?php base_url();?>admin/add-regionwise-rate/<?php echo $cust[0]['customer_id'];?>" class="btn btn-warning"><i class="ion-plus"></i>&nbsp;Add Regionwise Rate</a>
                              </span>
                        <?php } ?>
                          </div>
                          <div class="card-body">
                             <div class="row">                                           
                        <div class="col-12">
                            <form role="form" action="<?php echo base_url();?>admin/list-rate" method="post" enctype="multipart/form-data">

                                <div class="form-row">
                                  <div class="col-3 mb-3">
                                        <label for="username">View Rate</label>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <select class="form-control" name="customer_id"  id="customer_account_id">
                                        <option value="">Customer</option>
                                        <?php 
                                           foreach ($customer as $row1 ) {  
                                           ?>
                                          <option value="<?php echo $row1['customer_id'];?>"> (<?php echo $row1['cid'];?>) <?php echo $row1['customer_name'];?> </option>
                                          <?php 
                                            }
                                          ?>
                                        </select>
                                    </div>
                                        <label for="username">&nbsp;</label>
                                        <div class="col-3 mb-3">
                                          <button type="submit" name="submit"class="btn btn-primary">View </button>
                                        </div>
  
                                  </div>
                                </form>
                              </div>
                            </div>
                            <?php 
          if (!empty ($cust)){
            ?>
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                                 <th scope="col">ID</th>
                                                 <th scope="col">Customer Name</th>
                                                 <th scope="col">Weight Range</th>
                                                 <th scope="col">Mode of Transport</th>
                                                 <th scope="col">Region Wise Rate</th>
                                                 <th scope="col">State Wise Rate</th>
                                                 <th scope="col">City Wise Rate</th>
                                                 <th scope="col">Action</th>
												  </tr>
                                      </thead>
                                      <tbody> 
                    <?php
							foreach ($cust as $key =>  $value) 
								{
								$customer_id = $value['customer_id']; 
								$rate_master_id = $value['rate_master_id'];   

								$state_rates = $this->Rate_model->select_state_rate($customer_id,$rate_master_id);
								$city_rates  = $this->Rate_model->select_city_rate($customer_id,$rate_master_id);              
								?>  
                               <tr>
									<td><?php echo $value['rate_master_id'];?></td>
									<td><?php echo $value['customer_name'];?></td>                     
									<td><?php echo $value['weight_range'];?></td>
									<td><?php echo $value['mode_of_transport'];?></td>                 
									<td><?php echo $value['region_name'];?> <br>Rate : <?php echo $value['rate'];?>  </td>
									<td>
									<a title="Add state wise rate" style="float: right;" href="<?php base_url();?>admin/show_state_city_wise_rate/<?php echo $value['rate_master_id'];?>" ><i class="ion-plus" style="color:green;"></i></a>
										<?php   
										if(!empty($state_rates) )
										{                  
											foreach ($state_rates as $state) 
											{
												echo $state['state'].'<br>Rate : '.$state['rate'].' '.'<b>TAT :</b>'. $state['edd'].'<br>'; 
											?>

												<a title="Edit state wise rate" style="float: right;" href="<?php base_url();?>admin/show_edit_state_city_wise_rate/<?php echo $value['rate_master_id'];?>/<?php echo $state['tbl_rate_state_id']; ?>"><i class="ion-edit" style="color:blue;"></i></a>
											<?php
											}
										}
										
										?>
											
										
									</td>
									<td>
									<a title="Add city wise rate" style="float: right;" href="<?php base_url();?>admin/show_state_city_wise_rate/<?php echo $value['rate_master_id'];?>" ><i class="ion-plus" style="color:green;"></i></a>
										<?php
										if(!empty($city_rates) )
										{ 
											foreach ($city_rates as $city) 
											{
												echo $city['city'].'<br> Rate :'.$city['rate'].' '.'<b>TAT :</b>'. $city['edd'].'<br>';
											
											?>
											<a title="Edit city wise rate" style="float: right;" href="<?php base_url();?>admin/show_edit_state_city_wise_rate/<?php echo $value['rate_master_id'];?>/<?php echo $city['tbl_rate_city_id']; ?>"><i class="ion-edit" style="color:blue;"></i></a>
											<?php 
											} ?>

										<?php
										}
										             
										?>
									</td>
									<td>
									<a href="<?php base_url();?>admin/show_regionwise_rate/<?php echo $value['rate_master_id'];?>" class="btn btn-primary"><i class="icon-pencil"></i></a>
									| 
									<a href="<?php base_url();?>admin/delete-rate/<?php echo $value['rate_master_id'];?>" class="btn btn-danger"><i class="icon-trash"></i></a>
									</td>
								</tr>
								<?php 
							}
                   
                      ?>
                                </tbody>
                                  </table> 
                              </div>
                            <?php } ?>
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
        <?php $this->load->view('admin/admin_shared/admin_footer');
         //include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
