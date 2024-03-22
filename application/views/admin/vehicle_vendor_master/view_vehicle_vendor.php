<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  /*#example_filter{display: none;}*/
  .input-group{
    width: 60%!important;
  }
</style>
    <!-- START: Body-->
    <body id="main-container" >
        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12 mt-3">
                      <!-- <div class="col-12 col-sm-12 mt-3"> -->
                      <div class="card"><!-- bg-primary-light -->
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title">View Vehicle Vendor</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-vehicle-vendor" class="btn btn-primary">
         Add Vehicle Vendor</a></span>
                          </div>
                          <div class="card-body">
                              <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                   <table  class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>
                                               <th scope="col">SrNo</th>
                                               <th scope="col">Name</th>
											    <th scope="col">Mobile No</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Registered office Address</th>
                                                <th scope="col">Current Business</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Service Provider</th>
                                                <th scope="col">Statutory</th>
                                                <th scope="col">Type Vehicle</th>
                                                <th scope="col">Bank Name</th>
                                                <th scope="col">Account No</th>
                                                <th scope="col">IFSC Code</th>
                                                <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                  if (!empty ($allcustomer)){
                                    $cnt=0;
                                    foreach ($allcustomer as $cust) {
                                      $cnt++;
                                  ?>
                                  <tr>
                                    <td scope="row"><?php echo $cnt;?></td>
                                    <td><?php echo $cust['name'];?></td>
									  <td><?php echo $cust['mobile_no'];?></td>
                                    <td><?php echo $cust['email'];?></td>
                                    <td><?php echo $cust['r_address'];?></td>
                                    <td><?php echo $cust['current_business'];?></td>
                                    <td><?php echo $cust['city'];?></td>
                                    <td><?php echo $cust['state'];?></td>
                                    <td><?php echo $cust['service_provider'];?></td>
                                    <td><?php echo $cust['statutory'];?></td>
                                    <td><?php echo $cust['type_vehicle'];?></td>
                                    <td><?php echo $cust['bank_name'];?></td>
                                    <td><?php echo $cust['account_no'];?></td>
                                    <td><?php echo $cust['ifsc_code'];?></td>
                              
                                    <td> 
        <a href="<?php base_url();?>admin/edit-vehicle-vendor/<?php echo $cust['id'];?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a>
        |
        <a href="<?php base_url();?>admin/access-control/<?php echo $cust['customer_id'];?>" title="Edit" ><i class="fa fa-ban" aria-hidden="true"></i>
</a>
        |
        <!--<a href="<?php base_url();?>admin/delete-customer/<?php echo $cust['customer_id'];?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
        <a href="javascript:void(0);" title="Delete" class="deletedata" relid = "<?php echo $cust['id']; ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                      </td>
                                    </tr>
                                    <?php 
                                  }
                            }
                             else{
                            echo "<p>No Data Found</p>";
                             } ?>
                                </tbody>
                                  </table> 
                              </div>
                          </div>
                        </div> 

                    <!-- </div> -->
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
      $('.deletedata').click(function(){
        var getid = $(this).attr("relid");
      // alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "You won't be able to revert this!",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_vehicle_vendor/delete_vehicle_vendor_type',
			    	type: 'POST',
			       	data: 'getid='+getid,
			       	dataType: 'json'
			    })
			    .done(function(response){
			     	swal('Deleted!', response.message, response.status);
			     	 location.reload();
			    })
			    .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			    });
		  	}
 
		})
 
	});
       
 });
</script>
  
    
    
</html>
