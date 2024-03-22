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
                              <h4 class="card-title">All Mode</h4>
                              <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                              <span style="float: right;"><a href="admin/view-add-mode" class="btn btn-primary">Add Mode</a></span>
                              <?php } ?>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                                               <th scope="col">Mode Name</th>    
                                               <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>      
                      											   <th scope="col">Action</th>
                                                                   <?php } ?>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($mode_list))
                            									{
                            										$cnt = 0;
                                                foreach ($mode_list as $value) {
                                                  $cnt++;
                                              ?>
                            									<tr>
                            										<td scope="col"><?php echo $cnt; ?></td>
                                                <td> <a href ="<?=base_url('admin/modewise-pincode/'.$value['transfer_mode_id']) ?>"><?php echo $value['mode_name']; ?></a></td> 
                                                <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>  <td>       
                                                                                         										
                                                <a href="admin/view-edit-mode/<?php echo $value['transfer_mode_id'];?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                            										
                                                <!--<a href="admin/delete-mode/<?php echo $value['transfer_mode_id'];?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
                                                <a href="javascript:void(0)" title="Delete" class="deletedata" relid="<?php echo $value['transfer_mode_id'];?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                            									  </td><?php } ?>
                            									  </tr>
                                              <?php 
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
			   		url: baseurl+'Admin_mode_manager/delete_mode',
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
