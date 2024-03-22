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
                          <div class="card-header justify-content-between align-items-center">     <br><br>                          
                              <h4 class="card-title">Edit AWB Stock</h4>
         
                          </div>
                          <div class="card-body">
                               <div class="col-12">
                                            <form role="form" action="<?php echo base_url('admin/edit-stock/'.$value->id);?>" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
													 <div class="col-3 mb-3">
                                                        <label for="username">Series Form</label>
                                                        <input type="number" name="series_form" id="series_form" class="form-control" value="<?= $value->series_form; ?>" readonly>
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Series To</label>
                                                        <input type="number" name="series_to" id="series_to" class="form-control" value="<?= $value->series_to; ?>" readonly>
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">AWBS </label>
                                                        <input type="text" name="awbs" id="awbs"  class="form-control" value="<?= $value->awbs_limits; ?>" readonly>
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Mode</label>
                                                        <select name="mode" class="form-control" id="" readonly>
                                                        <option value="" > Select Mode</option>
                                                        <?php foreach ($mode as $key => $val) { ?>
                                                            <option value="<?=$val->transfer_mode_id;?>" <?php if($value->mode==$val->transfer_mode_id){echo 'selected';} ?>><?=$val->mode_name;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                 
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                    </div>
                                                </div>
                                            </form>
                                        </div> <br><br>
                           
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
    
        $("#series_to").keyup(function () 
        {
           var series_form = $('#series_form').val();
           var series_to = $('#series_to').val();
           var final = series_to - series_form;
           $('#awbs').val(final);
        });	
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