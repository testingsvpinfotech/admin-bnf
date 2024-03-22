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
                                         <form role="form" action="<?php echo base_url(); ?>admin/edit-franchise-rate-master/<?= $edit->id ?>" method="post" enctype="multipart/form-data">

                                             <div class="form-row">
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Rate Group</label>
                                                     <select name="rate_group" id="rate" class="form-control">
                                                         <option value="">Select rate group</option>
                                                         <?php foreach ($rate_group as $value) { ?>
                                                             <option value="<?= $value->group_name; ?>"<?php if($edit->rate_group ==$value->group_name){ echo 'Selected'; }  ?>><?= $value->group_name; ?></option>
                                                         <?php } ?>
                                                     </select>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Shipment Type</label>
                                                     <select name="shipment_type" id="doc" class="form-control">
                                                         <option value="">Select rate group</option>
                                                         <option value="Doc" <?php if($edit->shipment_type == 'Doc'){ echo 'Selected'; }?>>Doc</option>
                                                         <option value="Non Doc" <?php if($edit->shipment_type == 'Non Doc'){ echo 'Selected'; }?>>Non Doc</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">From Date</label>
                                                     <input type="datetime-local" name="from_date" class="form-control" value="<?= $edit->from_date;?>" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">From Zone</label>
                                                     <input type="text" name="from_zone" class="form-control" value="<?= $edit->from_zone;?>" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">To Zone</label>
                                                     <input type="text" name="to_zone" class="form-control" value="<?= $edit->to_zone;?>" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Weight From</label>
                                                     <input type="text" name="weight_from" class="form-control" value="<?= $edit->weight_from;?>" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Weight To</label>
                                                     <input type="text" name="weight_to" class="form-control" value="<?= $edit->weight_to;?>" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Rate</label>
                                                     <input type="text" name="rate" class="form-control" value="<?= $edit->rate;?>" required>
                                                 </div>
                                                 <div class="col-3 mb-3">
                                                     <label for="username">Rate</label>
                                                     <select class="form-control" class="form-control" name="fixed_perkg">
                                                         <option value="">-Select Type-</option>
                                                         <option value="Fixed" <?php if($edit->fixed_perkg == 'Fixed'){ echo 'Selected'; }?>>Fixed</option>
                                                         <option value="Addtion 250GM" <?php if($edit->fixed_perkg == 'Addtion 250GM'){ echo 'Selected'; }?>>Addtion 250GM</option>
                                                         <option value="Addtion 500GM" <?php if($edit->fixed_perkg == 'Addtion 500GM'){ echo 'Selected'; }?>>Addtion 500GM</option>
                                                         <option value="Addtion 1000GM" <?php if($edit->fixed_perkg == 'Addtion 1000GM'){ echo 'Selected'; }?>>Addtion 1000GM</option>
                                                         <option value="Per Kg" <?php if($edit->fixed_perkg == 'Per Kg'){ echo 'Selected'; }?>>Per Kg</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-3 mb-3"><br>
                                                     <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                 </div>
                                             </div>
                                         </form>
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
                                 url: baseurl + 'Admin_bank/delete_bank',
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