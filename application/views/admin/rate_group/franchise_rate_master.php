     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
     <!-- END Head-->

     <!-- START: Body-->

     <body id="main-container" class="default">

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
                     <div class="col-12  align-self-center">
                         <div class="col-12 col-sm-12 mt-3">
                             <div class="card">
                                 <div class="card-header justify-content-between align-items-center">
                                     <h4 class="card-title">Franchise Rate Master</h4>
                                     <!--                     <span style="float: right;"><a href="<?php base_url(); ?>admin/add-vehicle" class="fa fa-plus btn btn-primary">-->
                                     <!--Add Vehicle Type</a></span>-->
                                 </div>
                                 <div class="card-body">
                                     <div class="col-12">
                                         <form role="form" action="<?php echo base_url(); ?>admin/franchise-rate-master" method="post" enctype="multipart/form-data">

                                             <div class="form-row">
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Rate Group</label>
                                                     <select name="rate_group" id="rate" class="form-control">
                                                         <option value="">Select rate group</option>
                                                         <?php foreach ($rate_group as $value) { ?>
                                                             <option value="<?= $value->group_name; ?>"><?= $value->group_name; ?></option>
                                                         <?php } ?>
                                                     </select>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Shipment Type</label>
                                                     <select name="shipment_type" id="doc" class="form-control">
                                                         <option value="">Select rate group</option>
                                                         <option value="Doc">Doc</option>
                                                         <option value="Non Doc">Non Doc</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">From Date</label>
                                                     <input type="datetime-local" name="from_date" class="form-control" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">From Zone</label>
                                                     <input type="text" name="from_zone" class="form-control" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">To Zone</label>
                                                     <input type="text" name="to_zone" class="form-control" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Weight From</label>
                                                     <input type="text" name="weight_from" class="form-control" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Weight To</label>
                                                     <input type="text" name="weight_to" class="form-control" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Rate</label>
                                                     <input type="text" name="rate" class="form-control" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Rate</label>
                                                     <select class="form-control" class="form-control" name="fixed_perkg">
                                                         <option value="">-Select Type-</option>
                                                         <option value="Fixed">Fixed</option>
                                                         <option value="Addtion 250GM">Addtion 250GM</option>
                                                         <option value="Addtion 500GM">Addtion 500GM</option>
                                                         <option value="Addtion 1000GM">Addtion 1000GM</option>
                                                         <option value="Per Kg">Per Kg</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-3 mb-3"><br>
                                                     <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                 </div>
                                             </div>
                                         </form>
                                     </div> <br><br>
                                     <div class="card-header justify-content-between align-items-center">
                                         <h4 class="card-title">Franchise Rate Master List</h4>
                                         <?php if ($this->session->flashdata('notify') != '') { ?>
                                             <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                         <?php unset($_SESSION['class']);
                                                unset($_SESSION['notify']);
                                            } ?>
                                     </div>
                                     <div class="table-responsive">
                                         <table class="table layout-primary bordered">
                                             <thead>
                                                 <tr>
                                                     <th scope="col">ID</th>
                                                     <th scope="col">Group Name</th>
                                                     <th scope="col">Shipment Type</th>
                                                     <th scope="col">From Date</th>
                                                     <th scope="col">From Zone</th>
                                                     <th scope="col">To Zone</th>
                                                     <th scope="col">Weight From</th>
                                                     <th scope="col">Weight To</th>
                                                     <th scope="col">Rate</th>
                                                     <th scope="col">Type</th>
                                                     <th scope="col">Action</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <tr>
                                                     <?php // print_r($allvehicle);die();
                                                        if (!empty($allvehicletype)) {

                                                            $cnt = 1;
                                                            foreach ($allvehicletype as  $value) {
                                                        ?>
                                                             <td><?php echo $cnt; ?></td>
                                                             <td><?php echo $value['rate_group']; ?></td>
                                                             <td><?php echo $value['shipment_type']; ?></td>
                                                             <td><?php echo $value['from_date']; ?></td>
                                                             <td><?php echo $value['from_zone']; ?></td>
                                                             <td><?php echo $value['to_zone']; ?></td>
                                                             <td><?php echo $value['weight_from']; ?></td>
                                                             <td><?php echo $value['weight_to']; ?></td>
                                                             <td><?php echo $value['rate']; ?></td>
                                                             <td><?php echo $value['fixed_perkg']; ?></td>
                                                             <td>
                                                                 <a href="<?= base_url('admin/edit-franchise-rate-master/' . $value['id']); ?>" title="Edit"><i class="ion-edit" style="color:var(--primarycolor)"></i></a> |
                                                                 <a href="javascript:void(0);" title="Delete" class="deletedata" relid="<?= $value['id'] ?>"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                             </td>
                                                 </tr>
                                         <?php
                                                                $cnt++;
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
            //include('admin_shared/admin_footer.php'); 
            ?>
         <!-- START: Footer-->
     </body>
     <!-- END: Body-->
     <script src="assets/js/sweetalert2.all.min.js"></script>
     <script src="assets/js/customsweetalert.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
     <script>
         $(document).ready(function() {
             $('.deletedata').click(function() {
                 var getid = $(this).attr("relid");
                 // alert(getid);
                 var baseurl = '<?php echo base_url(); ?>'
                 swal({
                     title: 'Are you sure?',
                     text: "You won't be able to revert this!",
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes, delete it!',
                 }).then((result) => {
                     if (result.value) {
                         $.ajax({
                                 url: baseurl + 'Admin_rate_group_master/delete_rate',
                                 type: 'POST',
                                 data: 'getid=' + getid,
                                 dataType: 'json'
                             })
                             .done(function(response) {
                                 swal('Deleted!', response.message, response.status)

                                     .then(function() {
                                         location.reload();
                                     })

                             })
                             .fail(function() {
                                 swal('Oops...', 'Something went wrong with ajax !', 'error');
                             });
                     }

                 })

             });

         });
     </script>