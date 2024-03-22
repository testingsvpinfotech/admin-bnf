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
    <div class="card-header">                               
        <h4 class="card-title">User Menu</h4>                                
    </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">                                           
                    <div class="col-12">
                        <form role="form" action="<?php echo base_url();?>admin_manager/manage_user_menu" method="post" enctype="multipart/form-data">

                         
                          <div class="col-3 mb-3">
                            <!-- <label for="username">User Type</label>
                            <select class="form-control" id="jq-validation-email" name="userType" required>
                              <option value="">Select User Type</option>
                              <option value="staff">Staff</option>
                              <option value="Delivery Boy">Delivery Boy</option>
                              
                            </select> -->

                            <label for="username">User Type</label>
                           <select class="form-control" name="userType">
                             <option value="">Select User Type</option>
                           <?php foreach ($usertypes as  $value) { ?>
                            <option value="<?=$value->user_type_name?>"><?=$value->user_type_name?></option>
                            <?php } ?>
                          </select>
                          </div>

                          <div class="col-3 mb-3">
                            <label for="username" >User Type</label>
                            <select class="form-control" name="menu" required>
                              <option value="">Select Menu</option>
                               <?php foreach ($menus as  $value) { ?>
                                <option value="<?=$value->menu_id?>"><?=$value->menu?></option>
                                <?php } ?>
                            </select>
                          </div> 
                       
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
                        </div>
                        
                      </form>
                    </div>
                </div>



                <div class="row">
                  <div class="col-12">

                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Menu</th>
                        <th>Action</th>
                      </tr>

                      <?php 

                        if (!empty($usermenus)) {
                          foreach ($usermenus as $key => $value) {
                            echo "<tr>";
                            echo "  <td>".($key+1)."</td>";
                            echo "  <td>".$value->userType."</td>";
                            echo "  <td>".$value->menu."</td>";
                            echo "  <td><a href='admin_manager/delete_user_menu/".$value->user_menu_id."' onclick=\"return confirm('Are you sure?')\">Delete</a></td>";
                            echo "</tr>";
                          }
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
</html>

		
		
		
		
		