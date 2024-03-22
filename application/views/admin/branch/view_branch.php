<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
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
                              <h4 class="card-title">All Branches</h4>
                              <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                              <span style="float: right;"><a href="admin/add-branch" class="fa fa-plus btn btn-primary">Add Branche</a></span>
                              <?php } ?>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
												<th  scope="col">Sr.</th>
												<th  scope="col">Branch Name</th>
												<th  scope="col">Branch Code</th>
												<th  scope="col">Email</th>
												<th  scope="col">Contact No</th>
												<th  scope="col">Address</th>
												<th  scope="col">City</th>
												<th  scope="col">State</th>
												<th  scope="col">Pincode</th>
												<th  scope="col">GST Number</th>
												<th  scope="col">Contact Person</th>
												<th  scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                 <?php 
                                    if (!empty($allbranchdata))
									{
										$cnt = 1;
                                      foreach ($allbranchdata as $value) {
                                    ?>
									<tr class="odd gradeX">
										<td><?php echo $cnt?></td>
									  <td><?php echo $value->branch_name?></td>
										<td><?php echo $value->branch_code?></td>
									  
									  
									  <td><?php echo $value->email?></td>
									  <td> <?php echo $value->phoneno?></td>
									  <td><?php echo $value->address?></td>
									  <td><?php echo $value->city?></td>
									  <td><?php echo $value->state?></td>
									  <td><?php echo $value->pincode?></td>
									  <td><?php echo $value->gst_number?></td>
									  <td><?php echo $value->contact_person?></td>
									  <td>
										<!-- <a href="admin/report_branch/<?php echo $value->branch_id?>" title="Edit" style="color:#fff;" >Branch Report</a> | -->
										<a href="admin/edit-branch/<?php echo $value->branch_id?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> 
										<!--<a href="admin/delete-branch/<?php echo $value->branch_id?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
										<?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>|
                    <a href="javascript:void(0)" title="Delete" relid = "<?php echo $value->branch_id?>" class = "deletedata" ><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                    <?php } ?>
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
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
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
			   		url: baseurl+'Admin_Branch_manager/deletebranch',
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
  
</html>
