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
                              <h4 class="card-title">View Vendor</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-vendor" class="fa fa-plus btn btn-primary">
         Add Vendor</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Name</th>
                                             <th scope="col">Contact </th>
                                             <th scope="col">Adress </th>
                                             <th scope="col">Pincode </th>
                                             <th scope="col">City </th>
                                             <th scope="col">State </th>
                                             <th scope="col">Rate PerKg </th>
                                             <th scope="col">Minimum </th>
                                             <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                  <?php 
          if (!empty ($allvendor))
          {

$cnt= 1;
          foreach ($allvendor as  $value) {
                  ?>  
          <td><?php echo $cnt;?></td>
                  <td><?php echo $value['vendor_name'];?></td>
                  <td><?php echo $value['v_contact'];?></td>
                  <td><?php echo $value['v_add'];?></td>
                  <td><?php echo $value['v_pincode'];?></td>
                  <td><?php echo $value['v_city'];?></td>
                  <td><?php echo $value['v_state'];?></td>
                  <td><?php echo $value['v_rate_perkg'];?></td>
                  <td><?php echo $value['v_minimum'];?></td>
                  <td><a href="<?php echo base_url();?>admin/edit-vendor/<?php echo $value['tv_id']?>" class="btn btn-success"><i class="ion-edit"></i></a>
                  <!--<a href="<?php echo base_url();?>admin/delete-vendor/<?php echo $value['tv_id']?>" class="btn btn-danger"><i class="icon-trash"></i></a>-->
                   <a href="javascript:void(0);" title="Delete" class="deletedata" relid = "<?php echo $value['tv_id']; ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                  
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
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
			   		url: baseurl+'Admin_vendor/delete_vendor',
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
  
    
</body>
<!-- END: Body-->

