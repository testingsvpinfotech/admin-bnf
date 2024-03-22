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
                              <h4 class="card-title">All Fuel</h4>
                              <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                              <span style="float: right;"><a href="admin_fuel/export_fuel" class="fa fa-plus btn btn-primary">Export Fuel</a> 
                              <a href="admin/view-add-fuel" class="fa fa-plus btn btn-primary">Add Fuel</a></span> 
                              <?php } ?>
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
                                                <th scope="col">Courier</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Fuel Price</th>
                                                <th scope="col">Fuel From</th>
                                                <th scope="col">Fuel To</th>
                                                <th scope="col">Fuel Status</th>
                  
                      											   <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                            $cnt = 1;
                                            foreach ($fule_company as  $value) {
                                                    
                                                  ?>
                                                  <td><?php echo $cnt; ?></td>
                                                  <td><?php if($value->courier_id==0){echo "All";}else{echo $value->c_company_name; ?>-<?php echo $value->company_type; }?></td>
                                                  <td><?php echo $value->customer_name; ?></td>
                                                  <td><?php echo $value->fuel_price; ?></td>
                                                  <td><?php echo $value->fuel_from; ?></td>
                                                  <td><?php echo $value->fuel_to; ?></td>
                                                  <td><?php echo ($value->fuel_status == 1)?'Active':'Deactive'; ?></td>
                                                  <td>
                                                    <a href="<?php echo base_url();?>admin/view-edit-fuel/<?php echo $value->cf_id;?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>|
                                                     <a href="javascript:void(0);" title="Delete" class="deletedata" relid = "<?php echo $value->cf_id; ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a> <?php }?>
                                                    <!--<a href="<?php echo base_url();?>admin/delete-fuel/<?php echo $value->cf_id;?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
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
			   		url: baseurl+'Admin_fuel/deletefuel',
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
