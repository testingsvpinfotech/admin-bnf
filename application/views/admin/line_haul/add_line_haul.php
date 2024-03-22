 <?php  $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

<style>
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
  }
  </style>  
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
                            <h4 class="card-title">Add Line Haul</h4>  
                             <span style="float: right;"><a href="<?php base_url();?>admin/line-haul" class="btn btn-primary">
         View Line haul</a></span>                              
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                 <?php if($this->session->flashdata('notify') != '') {?>
  <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
  <?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?> 
                            <div class="row">                                           
                                <div class="col-12">
                                <form role="form" action="<?php echo base_url();?>admin/add-line-haul" method="post" enctype="multipart/form-data">

                                    <div class="form-row">
                                        <div class="col-3 mb-3">
                                            <label for="username">Zone</label>
                                           <input type="text" class="form-control" name="route_name" id="exampleInputEmail1" placeholder="Zone" required>
                                        </div>     
                                        <div class="col-4 mb-3">
                                           <label for="username">State</label>
                                           <select name="state_id[]" id="state_id"  onchange="return select_city(this.value)" class="form-control multiselect-container multiple_state" multiple>
                                             <?php 
                                                if (!empty($state_list))
                                                {                                   
                                                    foreach ($state_list as $st_value) 
                                                    {
                                                         ?>
                                            <option value="<?php echo $st_value['id']; ?>"><?php echo $st_value['state']; ?></option>
                                          <?php } } ?>
                                          </select>
                                         </div>
                                         <div class="col-4 mb-3">
                                           <label for="username">City</label>
                                           <select name="city_id[]" id="city_id" class="form-control" multiple>
                                                                                           
                                          </select>
                                         </div>
                                         <?php if(!empty($city_array))
                                         { ?>
                    <input type="hidden" value="<?php echo implode(",",$city_array); ?>"  id="already_user_city">
<?php                                         }
else{ ?>
    <input type="hidden" value=""  id="already_user_city">

<?php } ?>
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
<!-- END: Content-->
    

<!-- START: Footer-->
        <?php $this->load->view('admin/admin_shared/admin_footer');
         //include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
<script type="text/javascript">
    function select_city(state_id)
    {
       var state_id= $('#state_id').val(); 
       var already_user_city= $('#already_user_city').val(); 
       
     
        $.ajax({
                type: 'POST',
                url: 'Admin_route_planner/getStatewiseCity',
                data:{state_id:state_id,already_user_city:already_user_city},
                dataType: "json",
                success: function (d) { 
                    $('#city_id').html(d);
                    $('#city_id').multiselect({
                      includeSelectAllOption: true,
                      enableFiltering: true,
                     maxHeight: 150
                    });
                    
                     $('#city_id'). multiselect('rebuild');
                }
            });

    }

     function checkAll(ele) {
    // var checkboxes = document.getElementsByTagName('input');
      var checkboxes = document.getElementsByName('multiple_select_city[]');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
  function checkAll_state(ele) {
//      var checkboxes = document.getElementsByTagName('input');
// alert(checkboxes);
     var checkboxes = document.getElementsByName('multiple_select_state[]');
    
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }


   $('#state_id').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                maxHeight: 150
              });


   $('#city_id').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
               maxHeight: 150
              });
  
</script>
		
		
		
		
		