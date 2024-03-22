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
                              <h4 class="card-title">View Driver</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-driver" class="fa fa-plus btn btn-primary">
         Add Driver</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary table bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Name</th>
                                             <th scope="col">Dob</th>
                                             <th scope="col">Salery</th>
                                             <th scope="col">Date Of Joining</th>
                                             <th scope="col">Date Of Leaving</th>
                                             <th scope="col">Father Name </th>
                                             <th scope="col">Mother Name </th>
                                             <th scope="col">Mobile </th>
                                             <th scope="col">Mobile Alt. </th>
                                             <th scope="col">Licance No. </th>
                                             <th scope="col">Licance Exp. </th>
                                             <th scope="col">Adress </th>
                                             <th scope="col">Pincode </th>
                                             <th scope="col">State </th>
                                             <th scope="col">City </th>
                                             <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                  <?php 
          if (!empty ($alldriver))
          {

$cnt= 1;
          foreach ($alldriver as  $value) {
                  ?>  
          <td><?php echo $cnt;?></td>
                  <td><?php echo $value['driver_name'];?></td>
                  <td><?php echo $value['driver_dob'];?></td>
                  <td><?php echo $value['driver_salery'];?></td>
                  <td><?php echo $value['driver_joining_date'];?></td>
                  <td><?php echo $value['driver_leaving_date'];?></td>
                  <td><?php echo $value['driver_father_ame'];?></td>
                  <td><?php echo $value['driver_mother_name'];?></td>
                  <td><?php echo $value['driver_mobile'];?></td>
                  <td><?php echo $value['driver_mobile_alt'];?></td>
                  <td><?php echo $value['driver_licanace'];?></td>
                  <td><?php echo $value['driver_licance_expiry'];?></td>
                  <td><?php echo $value['driver_address'];?></td>
                  <td><?php echo $value['driver_pincode'];?></td>
                  <td><?php echo $value['driver_state'];?></td>
                  <td><?php echo $value['driver_city'];?></td>
                  <td><a href="<?php echo base_url();?>admin/edit-driver/<?php echo $value['dm_id']?>" class="btn btn-success"><i class="ion-edit"></i></a>
                  <!--<a href="<?php echo base_url();?>admin/delete-driver/<?php echo $value['dm_id']?>" class="btn btn-danger"><i class="icon-trash"></i></a>-->
                  <a href="javascript:void(0)" relid = "<?php echo $value['dm_id']?>" class="btn btn-danger deletedata"><i class="icon-trash"></i></a>
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
			   		url: baseurl+'Admin_driver/delete_driver',
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
