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
                              <h4 class="card-title">Add Vehicle Type</h4>
         <!--                     <span style="float: right;"><a href="<?php base_url();?>admin/add-vehicle" class="fa fa-plus btn btn-primary">-->
         <!--Add Vehicle Type</a></span>-->
                          </div>
                          <div class="card-body">
                               <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/add-vehicle-type" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Vehicle Name</label>
                                                        <input type="text" name="vehicle_name" class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Body Type</label>
                                                        <input type="text" name="body_type" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Capicty</label>
                                                        <input type="number" name="capicty"   class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Fuel</label>
                                                        <input type="text" name="fuel_type"  class="form-control" >
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                    </div>
                                                </div>
                                            </form>
                                        </div> <br><br>
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Vehicle Name</th>
                                             <th scope="col">Vehicle Body Type</th>
                                             <th scope="col">Vehicle Capicty</th>
                                             <th scope="col">Vehicle Fuel Type</th>
                                             <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                  <?php // print_r($allvehicle);die();
          if (!empty ($allvehicletype))
          {

$cnt= 1;
          foreach ($allvehicletype as  $value) {
                  ?>  
          <td><?php echo $cnt;?></td>
                  <td><?php echo $value['vehicle_name'];?></td>
                  <td><?php echo $value['body_type'];?></td>
                  <td><?php echo $value['capicty'];?></td>
                  <td><?php echo $value['fuel_type'];?></td>
                  <td><a href="<?php echo base_url();?>admin/edit-vehicle-type/<?php echo $value['id']?>" class="btn btn-success"><i class="ion-edit"></i></a>
                  <!--<a href="<?php echo base_url();?>admin/delete-vehicle-type/<?php echo $value['id']?>" class="btn btn-danger"><i class="icon-trash"></i></a>-->
                  <a href="javascript:void(0)" relid = "<?php echo $value['id']?>" class="btn btn-danger deletedata"><i class="icon-trash"></i></a>
                  </td>
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
			   		url: baseurl+'Admin_vehicle_Type/delete_vehicle_type',
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