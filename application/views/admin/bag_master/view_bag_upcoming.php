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
                              <h4 class="card-title">Upcoming Bag</h4>  
               							  
                          </div>
                          <div class="card-body">
						  
                               <div class="table-responsive">
                            <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>      
                                               <th scope="col">Sr No</th>
                                                <th scope="col">GT NO</th>         
                                                <th scope="col">Menifest ID</th>         
                                                <th scope="col">Bag ID</th>         
                                                <th scope="col">Source Origin</th>
                                                <th scope="col">Destination</th>
                                                <th scope="col">NOP</th>
												<th scope="col">Weight</th>
                                                <th scope="col">Bag Date</th>
                                          </tr>
                                      </thead>
                                      <tbody>  

                                       <?php 
					if (!empty($allpod))
					{
						$cnt = 1;
                    foreach ($allpod as  $ct) {
                                              
                                               ?>
                      <tr>
                        <td><?php echo $cnt;?></td>
                        <td><?php if (empty($ct->gatepass_no)) {
                            echo 'NA';}?></td>
                        <td><?php echo $ct->manifiest_id;?></td>
                        <td> <a target="_blank" href="<?= base_url('admin/tracking-domestic-reciever-bag/'.$ct->bag_no);?>"><?php echo $ct->bag_no;?></a></td>
                        <td><?php echo $ct->source_branch;?></td>
                        <td><?php echo $ct->destination_branch;?></td> 						
                        <td><?php echo $ct->total_pcs;?></td>  
						<td><?php echo $ct->total_weight;?></td>						
                        <td><?php echo date("d-m-Y",strtotime($ct->date_added) );?></td>
                    </tr>
                  <?php 
				  $cnt++;
				  } 
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
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

