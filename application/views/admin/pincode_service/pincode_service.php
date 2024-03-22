
<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- START: Body-->
    <body id="main-container" class="default">
        
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content--> <br><br>
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title"> View Pincode Service</h4>
         <!--                     <span style="float: right;"><a href="<?php base_url();?>admin/add-vehicle" class="fa fa-plus btn btn-primary">-->
         <!--Add Vehicle Type</a></span>-->
                          </div>
                          <div class="card-body">
                               <div class="col-12">
                               <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                                            <form role="form" action="<?php echo base_url();?>admin/add-pincode-service" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Pincode </label>
                                                        <input type="text" name="pincode" size="6"  maxlength="6" class="form-control" id="pincodep" onkeypress="return isNumber(event)" required>
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">State</label>
                                                        <select name="state" class="form-control" id="statep" >
                                                            <option> -- Select State -- </option>
                                                            <?php foreach($state as $value){ ?>
                                                                <option value="<?=$value->id.'-'.$value->state;?>"> <?= $value->state; ?></option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
													<div class="col-3 mb-3">
                                                    <label for="username">City</label>
                                                        <select name="city" class="form-control" id="cityp">
                                                            <option> -- Select City -- </option>
                                                            <?php foreach($city as $value){ ?>
                                                                <option value="<?=$value->id.'-'.$value->city;?>"> <?= $value->city; ?></option>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
													<div class="col-3 mb-3">
                                                    <label for="username">Branch Name</label>
                                                        <select name="branch" class="form-control" id="branchp">
                                                            <option> -- Select City -- </option>
                                                            <?php foreach($branch as $value){ if($value->branch_id !=39){?>
                                                                <option value="<?=$value->branch_id.'-'.$value->branch_name;?>"> <?= $value->branch_name; ?></option>
                                                                <?php }} ?>
                                                        </select>
                                                    </div>
													 <div class="col-3 mb-3">
                                                     <label for="username">Service Type</label>
                                                        <select name="ioda" class="form-control service" >
                                                        <option> -- Select Service Type -- </option>
                                                            <?php foreach(service_type as $key =>$value){ ?>
                                                                <option value="<?= $key;?>"><?= $value;?></option>
                                                            <?php } ?>       
                                                          
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                    </div>
                                                </div>
                                            </form><?php } ?>
                                        </div> <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?><br><br><br><?php }?>
                              <div class="table-responsive">
                              <?php if($this->session->flashdata('notify') != '') {?>
											<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
											<?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>
                                            <form action="<?= base_url('admin/view-pincode-service');?>" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                <div class="col-sm-4 col-sm-offset-3">
                                                <input type="text" class="form-control" name="search" placeholder="Search.. " value="<?php if(!empty($_POST['search'])){ echo $_POST['search'];}else{ echo '';} ?>">
                                                </div>
                                                <div class="col-sm-4">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:14px;"></i></button>
                                                <a href="<?= base_url('admin/view-pincode-service');?>" class="btn btn-primary"><i class="fa fa-refresh" style="font-size:14px;"></i></a>
                                                </div>
                                            </div>
                                           </form>
                                           <br>
                                  <table  class="table bordered" >
                                  <!-- id="example" -->
                                  
                                      <thead>
                                          <tr>
                                             <th scope="col">SR No</th>
                                             <th scope="col">Pincode</th>
                                             <th scope="col">State</th>
                                             <th scope="col">City</th>
                                             <th scope="col">Zone</th>
                                             <th scope="col">Branch</th>
                                             <th scope="col">isODA</th>
                                             <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                       <tr>
                  <?php // print_r($allvehicle);die();
          if (!empty ($allvehicletype))
          {

$cnt= 1;
          foreach ($allvehicletype as  $value) {
                  ?>  
          <td><?php echo $cnt;?></td>
                  <td><?php echo $value['pin_code'];?></td>
                  <td><?php echo $value['state'];?></td>
                  <td><?php echo $value['city'];?></td>
                  <td><?php $rginid =  $value['regionid'];               
                  echo $this->db->query("select * from region_master where region_id = '$rginid'")->row('region_name');
                
                  ?></td>            
                  <td><?php $rginid =  $value['branch_id'];               
                  echo $this->db->query("select * from tbl_branch where branch_id = '$rginid'")->row('branch_name');                
                  ?></td>                   
                  <td><?php if(!empty($value['isODA'])){echo service_type[$value['isODA']]; }?></td>            
                  <td><a href="<?php echo base_url();?>admin/edit-pincode-service/<?php echo $value['id']?>"><i class="ion-edit"></i></a>
                  </td>
        </tr>
          <?php 
		  $cnt++;
            }
                     }
                    //   else{
                    //       echo "<p>No Data Found</p>";
                    //      }
            ?>
              </tbody>
                </table> 
            </div>
        </div>
      </div> 
      <div class="row">
									<div class="col-md-6">
										<?php echo $this->pagination->create_links(); ?>
									</div>
								</div>
  </div>
  </div>
</div>
<!-- END: Listing-->
</div>
    </main>
    <div class="modal fade bd-example-modal-lg booking_show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Note This Pincode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="show_booking"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade bd-example-modal-lg" id="pincode_conform" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Pincode Service Alert!</h5>
				
			</div>
			<div class="modal-body" id="mbg-color">
				<div  style="padding-left:0px; margin:25px 0;">
					<h6>This pincode are deactivated.
                </h6>
                <input type="hidden" id="pincode">
				</div>
			
			<div class="modal-footer">
			    <button type="button" onclick="return ActivePincode();" class="btn btn-primary">Active</button>
				<button type="button" class="btn btn-danger" id="cancel_model" data-dismiss="modal">Cancel</button>
			</div>
			</div>
			</div>
		</div>
		</div>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
     //include('admin_shared/admin_footer.php'); ?>
    <!-- START: Footer-->
</body>
<!-- END: Body-->

<script>
    // $(document).ready(function() {
        $('.service').select2();
        $("#branchp").select2();
        $("#cityp").select2();
        $("#statep").select2();
        $("#reginp").select2();
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
			   		url: baseurl+'Admin_bank/delete_bank',
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


   
       

  
 // });

 function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>