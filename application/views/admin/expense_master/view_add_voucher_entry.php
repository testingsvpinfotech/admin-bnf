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
                              <h4 class="card-title">Voucher Entry</h4>
         
                          </div>
                          <div class="card-body">
                               <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/voucher-entry" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username"> Expence Type</label>
                                                        <select name="expence_type" class="form-control" id="">
                                                            <option value=""> select Expence Type</option>
                                                        <?php foreach ($usermenus as $key => $value) { ?>
                                                            <option value="<?=$value->id;?>"><?=$value->expence;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Vendor Name</label>
                                                        <input type="text" name="vendor_name" class="form-control" >
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Amount</label>
                                                        <input type="text" name="amount"   class="form-control" >
                                                    </div>
													 <div class="col-3 mb-3">
                                                        <label for="username">Bank Name</label>
                                                        <select name="bank_name" class="form-control" id="">
                                                        <option value="" > select Bank</option>
                                                        <?php foreach ($bank as $key => $value) { ?>
                                                            <option value="<?=$value->bank_name;?>"><?=$value->bank_name;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Ref No</label>
                                                        <input type="text" name="ref_no"   class="form-control" >
                                                    </div>
                                                    <div class="col-9 mb-3">
                                                        <label for="username">Description</label>
                                                        <textarea name="description" class="form-control" ></textarea>
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