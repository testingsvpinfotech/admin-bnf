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
                              <h4 class="card-title">All Courier Company</h4>
                              <span style="float: right;"><a href="admin/add-courier-master" class="fa fa-plus btn btn-primary">Add Courier Company</a></span>
                          </div>
                          <div class="card-body">
                             <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                               <th scope="col">Sr.</th>
                      											   <th scope="col">Company Name</th>	
                                               <th scope="col">Company Type</th>										  
                      											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                              <?php 
                                              if (!empty($courier_company))
                            									{
                            										$cnt = 0;
                                                foreach ($courier_company as $value) {
                                                  $cnt++;
                                              ?>
                            									<tr class="odd gradeX">
                            										<td><?php echo $cnt; ?></td>
                            									  <td><?php echo $value->c_company_name; ?></td>
                                                <td><?php echo $value->company_type;
                                                  if ($value->company_type=='Domestic') {

                                                    echo " <a class='btn btn-info' href='".base_url('Admin_courier_manager/upload_pincode').'/'.$value->c_id."'>Upload</a>";
                                                  }
                                                ?>
                                                  
                                                </td>  	
                                               <!-- <td>                                                
                                                   <a href="admin/view-courier-fixed-price/<?php echo $value->c_id;?>" class="btn btn-warning" target="_blank"><i class="ion-plus"></i></a> 
                                                </td> -->
                            									  <td>                            										
                                                <a href="admin/view-edit-courier-master/<?php echo $value->c_id;?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a>|
                            										
                                                <!--<a href="admin/delete-courier-master/<?php echo $value->c_id;?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
                                                <a href="javascript:void(0)" class="deletedata" title="Delete" relid="<?php echo $value->c_id;?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
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
			   		url: baseurl+'Admin_courier_manager/delete_courier_company',
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
