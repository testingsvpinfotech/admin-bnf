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
                              <h4 class="card-title">Outgoing</h4>  
 <span style="float: right;"><a href="admin/add-outgoing" class="fa fa-plus btn btn-primary">Add Outgoing</a></span>							  
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <thead>
                                          <tr>      
												<th scope="col">ID</th>
											    <th scope="col">Menifiest Id</th>
											    <th scope="col">Airway No</th>
											    <th scope="col">Status</th>
											    <th scope="col">Date</th>
											    <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>  

                                        <?php 
				  if (!empty ($alloutword)){
				  foreach ($alloutword as  $value) {
                  ?>  
				  <td><?php echo $value['id'];?></td>
                  <td><?php echo $value['manifiest_id'];?></td>
                  <td><?php echo $value['airway_no'];?></td>
                  <td><?php echo $value['status'];?></td>
                  <td><?php echo $value['date'];?></td>
				   <td>
                    <a href="admin/editoutgoing/<?php echo $value['manifiest_id']?>" class="btn btn-primary"><i class="icon-pencil"></i></a> |

                    <!--<a href="admin/deleteoutgoing/<?php echo $value['manifiest_id']?>" class="btn btn-danger"><i class="icon-trash"></i></a>-->
                    <a href="javascript:void(0)" relid = "<?php echo $value['manifiest_id']?>" class="btn btn-danger deletedata"><i class="icon-trash"></i></a>
                 </td>
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
			   		url: baseurl+'Admin_outgoing/deleteoutgoing',
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

