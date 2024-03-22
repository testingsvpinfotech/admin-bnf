<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
     <style>
    .buttons-copy{display: none;}
    .buttons-csv{display: none;}
    /*.buttons-excel{display: none;}*/
    .buttons-pdf{display: none;}
    .buttons-print{display: none;}
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
  }
  </style>     
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
                              <h4 class="card-title">Invoice List</h4>                              
                          </div>
                          <br>
                          <?php if($this->session->flashdata('notify') != '') {?>
                        <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                        <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Invoice No</th>                                              
                                              <th scope="col">Invoice Date</th>
                                              <th scope="col">Customer</th>
                                              <th scope="col">City</th>
                                              <th scope="col">GSTNo</th>
                                              <th scope="col">CID</th>
                                              <th scope="col">Period</th>
                                              <th scope="col">Total</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                        <?php
                                        if (!empty($allpoddata)) {
                                          $cnt=0;
                                            foreach ($allpoddata as $value) {
                                              $cnt++;
                                                ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $value['invoice_number']; ?></td>
                                                <td><?php if($value['invoice_date']!=""){ echo date("d-m-Y",strtotime($value['invoice_date']) ); } ?></td>
                                                <td><?php echo $value['customer_name']; ?></td>
                                                <td><?php echo $value['city']; ?></td>
                                                <td><?php echo $value['gstno']; ?></td>
                                                <td><?php echo $value['cid']; ?></td>
                                                <td><?php echo date("d-m-Y",strtotime($value['invoice_from_date']) )." To ".date("d-m-Y",strtotime($value['invoice_to_date']) ); ?></td>
                                                <td><?php echo $value['grand_total']; ?></td>
                                                <td>
                                                   <a href="<?php base_url();?>admin/show-edit-domestic-invoice/<?php echo $value['id']; ?>/<?php echo $value['customer_id']; ?>" ><i class="ion-edit" style="color:var(--primarycolor);"></i></a>|

                                                    <!--<a href="<?php base_url();?>admin/delete-domestic-invoice/<?php echo  $value['id']; ?>"  title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="ion-trash-b" style="color:var(--danger)"></i></a>-->
                                                    <a href="javascript:void(0)" onclick = "return theFunction(<?=$value['id']?>);"  title="Delete" ><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
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
    // $(document).ready(function() {
     function theFunction(int){
       var getid = int;
    //   alert(int);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "You won't be able to delete this!",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_domestic_booking/invoice_delete',
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
 
	}
       
//  });
</script>

