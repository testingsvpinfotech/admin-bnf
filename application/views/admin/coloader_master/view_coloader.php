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
                              <h4 class="card-title">All Coloader</h4>
                              <span style="float: right;"><a href="admin/view-add-coloader" class="btn btn-primary">Add Coloader</a></span>
                          </div>
                          <div class="card-body">
                             <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                              <div class="table-responsive">
                                  <table id="example" class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                                <th scope="col">Sr.</th>
                                                <th scope="col">Coloader Name</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Company Address</th>
                                                <th scope="col">Contact No</th>
                                                <th scope="col">Contact Person</th>
                                                <th scope="col">GST No</th>
                                                                                               
                      											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                            $cnt = 1;
                                            foreach ($fule_company as  $value) {
                                                    
                                                  ?>
                                                  <td><?php echo $cnt; ?></td>                                                 
                                                  <td><?php echo $value->coloader_name; ?></td>
                                                  <td><?php echo $value->company_name; ?></td>
                                                  <td><?php echo $value->company_add; ?></td>
                                                  <td><?php echo $value->company_contact; ?></td>
                                                  <td><?php echo $value->contact_person; ?></td>
                                                  <td><?php echo $value->gst_no; ?></td>
                                                  
                                                  <td>
                                                    <a href="<?php echo base_url();?>admin/view-edit-coloader/<?php echo $value->id;?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |<a href="<?php echo base_url();?>admin/view-details-coloader/<?php echo $value->id;?>" title="Edit" ><i class="ion-eye" style="color:var(--primarycolor)"></i></a> |
                                                    <!--<a href="<?php echo base_url();?>admin/delete-coloader/<?php echo $value->id;?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
                                                    <a href="javascript:void(0)" title="Delete"  class = "deletedata" relid = "<?php echo $value->id;?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                  </td>
                                                 </tr>
                                                  <?php 
                                          $cnt++;
                                          } ?>                                
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
			   		url: baseurl+'Admin_coloader/delete_coloader',
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
