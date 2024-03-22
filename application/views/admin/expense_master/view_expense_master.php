 <?php  $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

    	 <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>

        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
<main>
<div class="container-fluid site-width">
<!-- START: Listing-->
<div class="row">
<div class="col-12 mt-3">
<div class="card">
    <div class="card-header">  <br><br>                           
        <h4 class="card-title">Expense Master</h4>                                
    </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">                                           
                    <div class="col-12">
                    <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                        <form role="form" action="<?php echo base_url();?>admin/view-expence-master" method="post" enctype="multipart/form-data">

                         
                          <div class="col-3 mb-3">
                            <label for="username">Expense Name</label>
                          <input type="text" name="expence" class="form-control" placeholder="Expense Name" Required>
                          </div>                      
                        <div class="col-3">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
                        </div>
                        
                      </form><br>
                      <?php } ?>
                    </div>
                </div>



                <div class="row">
                  <div class="col-12">

                    <table class="table table-bordered">
                      <tr>
                        <th>Sr No</th>
                        <th>Expense Name</th>  <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                        <th>Action</th><?php }?>
                      </tr>

                      <?php 
                       $count = 1;
                        if (!empty($usermenus)) {
                          foreach ($usermenus as $key => $value) { ?>
                          <tr>
                          <td><?= $count++; ?></td>
                          <td><?= $value->expence; ?></td>
                          <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                          <td>  
                          <a href="<?php base_url();?>admin/edit-expence/<?php echo $value->id;?>" title="Edit"><i class="ion-edit" style="color:var(--primarycolor)"></i></a>
                          |
                          <a href="javascript:void(0);" title="Delete" class="deletedata" relid = "<?php echo $value->id; ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                        </td> <?php } ?>
                        </tr>
                  <?php       }
                        }

                      ?>
                    </table>
                    
                  </div>
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
			   		url: 'Admin_expence_master/delete_expence',
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

		
		
		
		
		