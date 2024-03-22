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
                              <h4 class="card-title">View Vehicle</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-vehicle" class="fa fa-plus btn btn-primary">
         Add Vehicle</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Vehicle Number</th>
                                             <th scope="col">Vehicle Registartion</th>
                                             <th scope="col">Vehicle Chesis</th>
                                             <th scope="col">Vehicle Model</th>
                                             <th scope="col">Vehicle PUC Date</th>
                                             <th scope="col">Vehicle Fitness Exp Date</th>
                                             <th scope="col">Vehicle Permit Renewa Date</th>
                                             <th scope="col">Vehicle Insurance Renw. Date</th>
                                             <th scope="col">Vehicle Capacity</th>
                                            
                                             <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                  <?php 
          if (!empty ($allvehicle))
          {

$cnt= 1;
          foreach ($allvehicle as  $value) {
                  ?>  
          <td><?php echo $cnt;?></td>
                  <td><?php echo $value['vehicle_number'];?></td>
                  <td><?php echo $value['vehicle_registration'];?></td>
                  <td><?php echo $value['vehicle_chesis'];?></td>
                  <td><?php echo $value['vehicle_model'];?></td>
                  <td><?php echo $value['vehicle_puc_date'];?></td>
                  <td><?php echo $value['vehicle_fit_exp_date'];?></td>
                  <td><?php echo $value['vehicle_per_renw_date'];?></td>
                  <td><?php echo $value['vehicle_insurance_renw'];?></td>
                  <td><?php echo $value['vehicle_capicity'];?></td>
                  <td><a href="<?php echo base_url();?>admin/edit-vehicle/<?php echo $value['vm_id']?>" class="btn btn-success"><i class="ion-edit"></i></a>
                  <!--<a href="<?php echo base_url();?>admin/delete-vehicle/<?php echo $value['vm_id']?>" class="btn btn-danger"><i class="icon-trash"></i></a></td>-->
                  <a href="javascript:void(0)" relid = "<?php echo $value['vm_id']?>" class="btn  btn-danger deletedata"><i class="icon-trash"></i></a></td>
        </tr>
          <?php 
		  $cnt++;
            }
                     }
                      else{
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
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

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
			   		url: baseurl+'Admin_vehicle/delete_vehicle',
			    	type: 'POST',
			       	data: 'getid='+getid,
			       	dataType: 'json'
			    })
			    .done(function(response){
			     	swal('Deleted!', response.message, response.status)
			     	 
                   .then(function(){ 
                    location.reload();
                   })
			     
			    })
			    .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			    });
		  	}
 
		})
 
	});
       
 });
</script>

