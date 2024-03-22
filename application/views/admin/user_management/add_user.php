  <?php  $this->load->view('admin/admin_shared/admin_header'); ?>
    <body id="main-container" class="default">

  <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
  <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
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
<!-- START: Listing-->
<div class="row">
<div class="col-12 mt-3">
<div class="card">
    <div class="card-header">                               
        <h4 class="card-title">Add User</h4>                                
    </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">                                           
                    <div class="col-12">
                        <form role="form" action="<?php echo base_url();?>admin/add-user" method="post" enctype="multipart/form-data">

                        <div class="form-row">
                        <div class="col-3 mb-3">
                            <label for="username">Name</label>

                           <input type="text" class="form-control" name="full_name" id="exampleInputEmail1" required placeholder="Name">

                        </div>
                        <div class="col-3 mb-3"> 
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1"  placeholder="Enter email">
                        </div>

                        <div class="col-3 mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required placeholder="Enter Username" onchange="username_check(this);" required>
                        </div>
                        <div class="col-3 mb-3"> 
                            <label for="email">Password</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1" required placeholder="Password">
                        </div>
                        <div class="col-3 mb-3">
                          <label for="username">Branch Code</label>
                          <select class="form-control branch_code" id="jq-validation-email" name="branch_code"> 
                            <option value="">Select Branch Code</option>
                            <?php 
                               foreach ($branch as $row ) { 
                               if($row['branch_id'] !=39){
                            ?>
                            <option value="<?php echo $row['branch_id'];?>">
                                <?php echo $row['branch_code'];?> --<?php echo $row['branch_name'];?>
                            </option>
                            <?php 
                                 }  }
                            ?>
                          </select>
                        </div>

                      <div class="col-3 mb-3">
                        <label for="username">User Type</label>
                           <select class="form-control" name="user_type" id="user_type">
                             <option value="">Select User Type</option>
                           <?php foreach ($usertypes as  $value) { ?>
                            <option value="<?=$value->user_type_id?>"><?=$value->user_type_name?></option>
                            <?php } ?>
                          </select>
                      </div> 
                      <div class="col-3 mb-3">
                          <label for="username">Assign Branch</label>
                          <select class="form-control" id="assign_branch" name="assign_branch[]" multiple>
                            <option value="">Select Branch Code</option>
                            <?php foreach ($branch as $row ) { ?>
                            <option value="<?php echo $row['branch_id'];?>">
                                <?php echo $row['branch_code'];?> --<?php echo $row['branch_name'];?>
                            </option>
                            <?php } ?>
                          </select>
                        </div>
                       <div class="col-3 mb-3">
                            <label for="username">Contact No</label>
                           <input type="text" class="form-control" name="phoneno" id="exampleInputEmail1" placeholder="Enter Contact No">
                      </div> 
						          <div class="col-3 mb-3">
                        <label for="username">Menu Access</label>
					              <select name="menu_access[]" required id="menu_access" multiple>
					               <?php if(!empty($all_menu)){
						                $menu_name		 = '';
						                foreach($all_menu as $key => $values){ 
							                 if($menu_name == '' || $menu_name != $values->menu_name){
								                  $menu_name		 = $values->menu_name;
								                  echo ' <optgroup label="'.$values->menu_name.'">';
							                  } ?>
							                  <option value="<?php echo $values->am_id; ?>" ><?php echo $values->menu_subtitle; ?></option>
						                  </optgroup>
					                   <?php  if($menu_name == '' || $menu_name != $values->menu_name){
								                $menu_name		 = $values->menu_name; 
                                echo ' </optgroup>';
							                }
						                }
					                } ?>
					              </select>
                      </div>
                      <div class="col-12">
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
</div>
<!-- END: Listing-->
</div>
</main>
<?php $this->load->view('admin/admin_shared/admin_footer'); ?>

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

  $('.branch_code').select2();
  $('#user_type').select2();

  function username_check(obj){
    var username = $('#username').val();
    $.ajax({
      url : '<?php echo base_url('Admin_users/check_user_exist');?>',
      method : 'GET',
      data : {username:username},
      success : function (data){
        data= data.trim();
        if (data=='1') {
          alert('User Name Already Exist!');
          $('#username').val('');
        }
      }
    });
  }
</script>
		
		
		
		
		
		