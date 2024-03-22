<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<body id="main-container" class="default">

<?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
<?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
<?php $style =''; if ($_SESSION['userType']!=1) { $style ='style="display:none"'; } ?>
<style>
    .btn-group, .btn-group-vertical { display: grid; }
    .btn-default, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle, .btn-primary.disabled, .btn-primary:disabled, .btn-primary.disabled:hover, .btn-primary:disabled:hover{
      background-color: #fff !important;
      border-color: #000;
    }
    .btn-default{ color: #000; }
</style>
<main>
    <div class="container-fluid site-width">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">                               
                        <h4 class="card-title">Update User</h4>                                
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form role="form" action="<?php echo base_url();?>admin/edit-user/<?php echo $singleuser->user_id; ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-3 mb-3">
                                                <label for="username">Name</label>
                                                <input type="text" class="form-control" name="full_name" required id="exampleInputEmail1" placeholder="Enter Name" value="<?php echo $singleuser->full_name; ?>">
                                            </div>
                                            <div class="col-3 mb-3"> 
                                                <label for="email">email Address</label>    
                                                <input type="email" class="form-control" name="email"  id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $singleuser->email; ?>">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="username">Username</label>
					                           <input type="text" class="form-control" name="username" required id="exampleInputEmail1" placeholder="Enter Username" value="<?php echo $singleuser->username; ?>" readonly> 
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="email">Password</label>       
                                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" value=""><?php //echo $singleuser->password; ?>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Branch Code</label>
                                                <select class="form-control" name="branch_code" id="branch_code" <?php if($this->session->userdata("userId") != '1'){ echo 'disabled';} ?>>
                                                    <option value="">Select Branch Code</option>
                                                    <?php foreach ($branch as $row ) { ?>
                                                    <option value="<?php echo $row['branch_id'];?>"  <?php if($singleuser->branch_id==$row['branch_id']){echo "selected";} ?>><?php echo $row['branch_code'];?> -- <?php echo $row['branch_name'];?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                                <?php if($this->session->userdata("userId") != '1'){ ?> <input type="hidden" name = "branch_code" value="<?php echo $singleuser->branch_id;?>"> <?php } ?>
                                                <?php if($this->session->userdata("userId") != '1'){ ?> <input type="hidden" name = "user_type" value="<?php echo $singleuser->user_type;?>"> <?php } ?>
                                            </div>
                                            <div class="col-3 mb-3">
                  <label>User Type</label>
                  <select class="form-control" name="user_type" id="user_type" required <?php if($this->session->userdata("userId") != '1'){ echo 'disabled';} ?>>
                    <option value="">Select User Type</option>
                   <?php foreach ($usertypes as  $value) {

                    if ($_SESSION['userType']!=1 && $singleuser->user_type!=$value['user_type_id']) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo $value['user_type_id'];?>" <?php if($singleuser->user_type==$value['user_type_id']){echo "selected";} ?> ><?php echo $value['user_type_name'];?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-3 mb-3">
                          <label for="username">Assign Branch</label>
                          <select class="form-control" id="assign_branch" name="assign_branch[]" multiple>
                            <?php $abranch = !empty($singleuser->assigned_branch)?explode(',', $singleuser->assigned_branch):''; ?>
                            <!-- <option value="">Select Branch Code</option> -->
                            <?php foreach ($branch as $row ) { ?>
                            <option value="<?php echo $row['branch_id'];?>" <?php if(!empty($abranch)){ foreach ($abranch as $k1 => $v1) { if($v1 == $row['branch_id']){ echo "selected"; } } } ?>>
                                <?php echo $row['branch_code'];?> --<?php echo $row['branch_name'];?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                <div class="col-3 mb-3">
                    <label for="username">Contact No</label>
<input type="text" class="form-control" name="phoneno" id="exampleInputEmail1" placeholder="Enter Contact No" value="<?=$singleuser->phoneno?>">

                </div> 
				<div class="col-3 mb-6" <?php echo $style;?>>
                    <label for="username">Menu Access</label>
					<select name="menu_access[]" required id="menu_access" multiple>
					<?php 
					if(!empty($all_menu))
					{
						$menu_name		 = '';
						foreach($all_menu as $key => $values)
						{ 
							if($menu_name == '' || $menu_name != $values->menu_name)
							{
								$menu_name		 = $values->menu_name;
								echo ' <optgroup label="'.$values->menu_name.'">';
							}
						
						?>
						 
							<option value="<?php echo $values->am_id; ?>" <?php echo (in_Array($values->am_id,$selected_menu))?'selected':''; ?>><?php echo $values->menu_subtitle; ?></option>
						  </optgroup>
					  <?php 
							if($menu_name == '' || $menu_name != $values->menu_name)
							{
								$menu_name		 = $values->menu_name;
								echo ' </optgroup>';
							}
						}
					} ?>
					</select>

                </div> 
                <div class="col-12">
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit"  style="background: #1e3d73">  
                    <!--  <button type="submit" class="btn btn-outline-warning">Reset</button> -->
                </div>
            </div>
        </form>
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
<script type="text/javascript">
    $('#menu_access').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        maxHeight: 300,
    });
    $('#assign_branch').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        maxHeight: 300,
    });     
    $('#branch_code').select2();
    $('#user_type').select2();
</script>