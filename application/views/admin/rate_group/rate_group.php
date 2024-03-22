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
                          <h4 class="card-title"> Add Rate Group Master</h4>
         <!--                     <span style="float: right;"><a href="<?php base_url();?>admin/add-vehicle" class="fa fa-plus btn btn-primary">-->
         <!--Add Vehicle Type</a></span>-->
                          </div>
                          <div class="card-body">
                               <div class="col-12">
                               <?php if ($this->session->flashdata('notify') != '') { ?>
										<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored">
											<?php echo $this->session->flashdata('notify'); ?>
										</div>
										<?php unset($_SESSION['class']);
										unset($_SESSION['notify']);
									} ?> <br>
                                            <form role="form" action="<?php echo base_url();?>admin/rate-group-master" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Group Name</label>
                                                        <input type="text" name="group_name" class="form-control" required>
                                                        <input type ="hidden" name="groups_id" value="1">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <select name="booking_bill_type" class="form-control mt-4" required>
                                                            <option value=""> --Select Bill Type -- </option>
                                                                 <?php foreach(bill_type as $key =>$value){?>
                                                                    <option value="<?= $key;?>"><?= $value;?></option>
                                                            <?php }?>
                                                        </select>
                                                        <input type ="hidden" name="groups_id" value="1">
                                                    </div>             
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                    </div>
                                                </div>
                                            </form>
                                        </div> <br><br>
                              <div class="table-responsive">
                              <h6 class="card-title">View Rate Group Master</h6>
                                  <table id="example" class="table layout-primary bordered">
                                      <thead>
                                          <tr>
                                             <th scope="col">ID</th>
                                             <th scope="col">Group Name</th>
                                             <th scope="col">Bill Type</th>
                                             <th scope="col">Date</th>
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
          <td><?php echo $value['group_name'];?></td>
          <td><?php if(!empty($value['booking_bill_type'])){echo bill_type[$value['booking_bill_type']];} ?></td>
          <td><?php echo $value['created_at'];?></td>
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
       
 });
</script>