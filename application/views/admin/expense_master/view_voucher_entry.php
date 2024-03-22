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
                    
                          <div class="card-header justify-content-between align-items-center">   <br><br> 
                                             
                              <h4 class="card-title">Voucher List</h4>
                              <?php if($this->session->flashdata('notify') != '') {?>
											<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
											<?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>      
                              <span style="float: right;"><a href="<?= base_url('admin/view-voucher-entry'); ?>" class="fa fa-plus btn btn-primary">Add Voucher</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                          <th  scope="col">Sr.</th>
                                          <th  scope="col">Expence</th>
                                          <th  scope="col">Vendor Name</th>
                                          <th  scope="col">Amount</th>
                                          <th  scope="col">Bank Name</th>
                                          <th  scope="col">Description</th>
                                          <th  scope="col">Refrance No</th>
                                          <th  scope="col">Created</th>
                                          <th  scope="col">Status</th>
                                          <th  scope="col">Approved By</th>
                                          <th  scope="col">Edited By</th>
                                          <?php if($_SESSION['userType']==1){  ?>
                                          <th  scope="col">Approve</th>
                                          <th  scope="col">Action</th>
                                          <?php } ?>
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
                                      <td><?php echo $value->expence;?></td>
                                      <td><?php echo $value->vendor_name?></td>                                   
                                      <td><?php echo $value->amount?></td>
                                      <td> <?php echo $value->bank_name?></td>
                                      <td><?php echo $value->description?></td>
                                      <td><?php echo $value->ref_no?></td>
                                      <td><?php echo $value->created_at?></td>
                                      <td><?php if($value->is_approve == 0 ){echo 'Pending'; }else{echo 'Approved';}?></td>
                                      <td><?php echo $value->approve_by;?></td>
                                      <td><?php echo $value->edited_by?></td>
                                      <?php if($_SESSION['userType']==1){  ?>
                                      <td><a href="javascript:void(0)" title="Approve" relid = "<?php echo $value->id?>" class = "approve" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a></td>
                                    <td>
                                    <a href="admin/edit-voucher/<?php echo $value->id?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                                    <a href="javascript:void(0)" title="Delete" relid = "<?php echo $value->id?>" class = "deletedata" ><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                    </td>
                                    <?php } ?>
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
			   		url: baseurl+'Admin_expence_master/voucher_delete',
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
      $('.approve').click(function(){
        var getid = $(this).attr("relid");
      // alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "Approve this Voucher",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, Approve it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_expence_master/isapprove',
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
