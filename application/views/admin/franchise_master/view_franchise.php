<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
    .buttons-copy {
        display: none;
    }

    .buttons-csv {
        display: none;
    }

    /*.buttons-excel{display: none;}*/
    .buttons-pdf {
        display: none;
    }

    .buttons-print {
        display: none;
    }

    /*#example_filter{display: none;}*/
    .input-group {
        width: 60% !important;
    }
</style>
<!-- START: Body-->

<body id="main-container">

    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12 mt-3">
                    <!-- <div class="col-12 col-sm-12 mt-3"> -->
                    <div class="card">
                        <!-- bg-primary-light -->
                        <div class="card-header justify-content-between align-items-center"> <br><br>
                            <h4 class="card-title" style="color:brown">Franchise Details</h4>
                            <div class="card-header justify-content-between align-items-center">
								<span>
									<form role="form" action="admin/franchise-list" method="post" enctype="multipart/form-data">
										<div class="form-row">
											<!-- <div class="col-md-3">
												<label for="">Customer</label>
												<input class="form-control" type="text" name="customer" >
											</div> -->
											<div class="col-sm-9 mt-4">
												<!-- <input type="submit" class="btn btn-primary" name="submit" value="Filter"> -->
												<input type="submit" class="btn btn-primary" name="download_report" value="Download Report">
												<!-- <a href="admin/franchise-list" class="btn btn-info">Reset</a> -->
											</div>
										</div>
									</form>
								</span>
							</div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('notify') != '') { ?>
                                <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                            <?php unset($_SESSION['class']);
                                unset($_SESSION['notify']);
                            } ?>
                            <div class="table-responsive">
                                <table  class="display table table-bordered" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th scope="col">SrNo</th>
                                            <th scope="col">C.Code</th>
                                            <th scope="col">Franchise Name</th>
                                            <th scope="col">Master Franchise Name</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">City</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Pincode</th>
                                            <th scope="col">Gstno</th>
                                            <th scope="col">Branch Name</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Sale Person Name</th>
                                            <th scope="col">Sale Person Branch</th>
                                            <th scope="col">Franchise Created</th>
                                             <?php if ($this->session->userdata("userType") == 1) { ?>
                                                <th scope="col">Password</th>
                                           
                                            <th scope="col">Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                        // echo '<pre>';print_r($allfranchise);
                                        if (!empty($allfranchise)) {
                                            $cnt = 0;
                                            foreach ($allfranchise as $cust) {
                                                $cnt++;
//                                                 error_reporting(E_ALL);
// ini_set('display_errors', 1); 
$franchise_id = $cust['franchise_id'];
  $val =  $this->db->query("Select * from tbl_franchise where franchise_id = '$franchise_id'")->row();
                                        ?>
                                                <tr>
                                                    <td scope="row"><?php echo $cnt; ?></td>
                                                    <td><?php echo $cust['cid']; ?></td>
                                                    <td><?php echo $cust['customer_name']; ?></td>
                                                    <td><?php
                                                    if(!empty($cust['customer_id'])){
                                                        $master_franchise = $this->db->query("SELECT * FROM franchise_delivery_tbl WHERE delivery_franchise_id ='".$cust['customer_id']."'" )->ROW(); 
                                                        echo $master_franchise->master_franchise_name;
                                                    } ?></td>
                                                    <td><?php echo $cust['company_name']; ?></td>
                                                    <td><?php echo $cust['email']; ?></td>
                                                    <td><?php echo $cust['phone']; ?></td>
                                                    <?php 
                                                    $city_id = $cust['city'];
                                                    $city = $this->db->query("select city from city where id = $city_id")->row();?>
                                                    <td><?php echo $city->city; ?></td>

                                                    <?php 
                                                     $state_id = $cust['state'];
                                                     $state = $this->db->query("select state from state where id = $state_id")->row();?>
                                                    <td><?php echo $state->state ; ?></td>
                                                    <td><?php echo $cust['address']; ?></td>
                                                    <td><?php echo $cust['pincode']; ?></td>
                                                    <td><?php echo $cust['gstno']; ?></td>
                                                    <?php $branch_id = $cust['branch_id'];
                                                   //print_r($cust['branch_id']);
                                                     $branch_name =  $this->db->query("select branch_name from tbl_branch where branch_id = '$branch_id'")->row_array();
                                                       //echo $this->db->last_query();
                                                    ?>
                                                    <td><?php  echo @$branch_name['branch_name']; ?></td>
                                                    
                                                    <td><?php echo  $val->cmp_area; ?></td>
                                                     <td><?php 
                                                      if(!empty($cust['sale_person'])){
                                                          $sale_person = $this->db->query("SELECT * FROM tbl_users WHERE user_id ='".$cust['sale_person']."'" )->ROW(); 
                                                          echo $sale_person->username;
                                                      }
                                                      ?></td>
                                                     <td><?php 
                                                       if(!empty($cust['sale_person'])){
                                                        $sale_person = $this->db->query("SELECT * FROM tbl_users WHERE user_id ='".$cust['sale_person']."'" )->ROW(); 
                                                     echo  $branch_name = $this->db->query("SELECT * FROM tbl_branch WHERE branch_id ='".$sale_person->branch_id."'" )->ROW('branch_name'); 
                                                    
                                                    }?></td>
                                                    <td><?php 
                                                    $date=date_create($cust['register_date']);
                                                    echo date_format($date,"d/m/Y"); ?></td>
                                                    <?php if ($this->session->userdata("userType") == 1) { ?>
                                                    <td><?php echo $cust['password']; ?></td>
                                               
                                                   

                                                    <td>
                                                        <a href="<?= base_url('admin/update-franchise/'.$cust['customer_id']) ?>" title="view"><i class="ion-edit" ></i></a>
                                                        <!-- <a href="<?= base_url('admin/update-franchise/'.$cust['customer_id'].'/'.$cust['fid'].'/'.$cust['delivery_franchise_id']) ?>" title="view"><i class="ion-edit" style="color:#ddd;"></i></a> -->
                                                        <!-- <a href="<?= base_url('admin/update-franchise/'.$cust['customer_id']) ?>" title="view"><i class="ion-edit" style="color:#ddd;"></i></a> -->
                                                        |
                                                        <!-- <a href="<?php base_url(); ?>admin/access-control/<?php echo $cust['customer_id']; ?>" title="Edit"><i class="fa fa-ban" aria-hidden="true"></i>
                                                        </a> -->
                                                      
                                                        <!-- <span relid = "<?php echo $cust['franchise_id']; ?>" class ="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></span> -->
                                                        <a href="javascript:void(0);" relid = "<?php echo $cust['customer_id']; ?>" class ="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<p>No Data Found</p>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- </div> -->
                </div>
            </div>
            <!-- END: Listing-->
        </div>
    </main>
    <!-- END: Content-->
    <!-- START: Footer-->
    <?php $this->load->view('admin/admin_shared/admin_footer');
    //include('admin_shared/admin_footer.php'); 
    ?>
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
			   		url: baseurl+'FranchiseController/deleteFranchiseData_tem',
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