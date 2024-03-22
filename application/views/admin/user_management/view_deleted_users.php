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
                              <h4 class="card-title">Deleted Users List</h4>
                          </div>
                          <div class="card-body">
                            <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                  <table  class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                                <th scope="col">Username</th>
                                                <!-- <th scope="col">Password</th> -->
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Contact No</th>
                                                <th scope="col">UserType</th>
                                                <th scope="col">Branch Code</th>
                                                <th scope="col " class="text-center">Active Deleted User</th>
                                                <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                  <tbody>
                                  <?php 
                                    if (count($all_users)){
                                      foreach ($all_users as $au) {
                                        // $dd = $au['password'] ;
                                        // $decrypted_string = $this->encrypt->decode($au['password']);
                                        // print_r($decrypted_string);
                                    ?>
                                    <tr class="odd gradeX">                                      
                                      <td scope="row"><?php echo $au['username'];?></td>
                                      <!-- <td><?php echo $au['password'];?></td> -->
                                      <td><?php echo $au['full_name'];?></td>
                                      <td><?php echo $au['user_email_id'];?></td>
                                      <td><?php echo $au['user_phoneno'];?></td>
                                      <td><?php echo $au['user_type_name'];?></td>
                                      <td><?php echo $au['branch_code'];?>--<?php echo $au['branch_name'];?></td>
                                      <td class="text-center">   <a href="javascript:void(0)" title="Delete" class = "deletedata1" relid ="<?php echo $au['user_id'];?>"><i class="ion-edit" style="color:var(--primarycolor)"></i></a></td>
                                      <td> 
                                       <a href="javascript:void(0)" title="Delete" class = "deletedata" relid ="<?php echo $au['user_id'];?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                      </td>
                                      </tr>
                                      <?php 
                                    }
                                 }
                                 else{
                                echo "<p>No Data Found</p>";
                                 }
                              ?>
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
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>   
    <script>
    $(document).ready(function() {
      $('.deletedata').click(function(){
        var getid = $(this).attr("relid");
      // alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "You want to permanently delete this User",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_users/delete_permanently_user',
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
    <script>
    $(document).ready(function() {
      $('.deletedata1').click(function(){
        var getid = $(this).attr("relid");
      // alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "Active Deleted User",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_users/delete_active_user',
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
