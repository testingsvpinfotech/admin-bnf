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
                              <h4 class="card-title">News Master</h4>
                              <span style="float: right;"><a href="<?php base_url();?>admin/add-news" class="btn btn-primary">
         Add News</a></span>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary table-bordered">
                                      <thead>
                                          <tr>
                                              <th scope="col">Sr.No.</th>
                                              <th scope="col">News Title</th>
                                              <th scope="col">News Date From</th>
                                              <th scope="col">News Date To</th>
                                              <th scope="col">News Details</th>
                                              <th scope="col">News Image</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 
                                          if (count ($allnews)){
                                            foreach ($allnews as $news) {
                                          ?>
                                          <tr class="odd gradeX">
                                            <td><?php echo $news['id'];?></td>
                                            <td><?php  echo $news['news_title'];?></td>
                                            <td><?php echo date("d-m-Y",strtotime($news['news_date_from']) );?></td>
                                            <td><?php echo date("d-m-Y",strtotime($news['news_date_to']) );?></td>
                                            <td><?php echo $news['news_details'];?></td>
                                            <td><img src="<?php echo base_url()."assets/news/".$news['news_image'];?>" width="70" height="70"></td>
                                            <td> 
                                              <a href="<?php base_url();?>admin/edit-news/<?php echo $news['id'];?>" title="Edit" ><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                                              <!--<a href="<?php base_url();?>admin/delete-news/<?php echo $news['id'];?>" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
                                              <a href="javascript:void(0)" relid = "<?php echo $news['id'];?>" title="Delete" class="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                              <?php if ($news == 0){ ?>
                                                   <a href="<?php base_url();?>admin/active/1/<?php echo $news['id'];?>" title="Delete" style="color:#fff;">Active</a>
                                                <?php }else{ ?>
                                                  <a href="<?php base_url();?>admin/active/0/<?php echo $news['id'];?>" title="Delete" style="color:#fff;">Disable</a>
                                                  <?php } ?>
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
			   		url: baseurl+'Admin_news/delete_news',
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

