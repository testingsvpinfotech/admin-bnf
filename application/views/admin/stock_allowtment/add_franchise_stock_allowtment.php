<?php $this->load->view('admin/admin_shared/admin_header');?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">

    	 <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');?>

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
                            <div class="card-header"> <br><br>
                                <h4 class="card-title">Assign Stock To Franchise / Master Franchise</h4>
<br>
                                <?php if($this->session->flashdata('notify') != '') {?>
											<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
											<?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form  action="<?php echo base_url(); ?>admin/add-franchise-stock-allowtment" method="post" enctype="multipart/form-data">

                                                <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username"> Franchise / M - Franchise Name</label> 
                                                        <select class="form-control" name="franchise" id="Franchise" required>
                                                            <option value=""> Select F - M </option>
                                                            <?php foreach($franchise1 as $val){ ?>
                                                                <option value = "<?= $val->customer_id; ?>"><?php if($val->customer_type == '2'){ echo $val->customer_name."_".$val->cmp_area." Franchise";}else{ echo $val->customer_name."_".$val->cmp_area." M - Franchise"; }?> Franchise</option>
                                                            <?php } ?>
                                                         
                                                        </Select>
                                                    </div>
                                                    </div>
                                                    <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <!-- <label for="username">Mode</label>
                                                        <select name="mode" class="form-control" id="mode" onchange="getAvailable(this);">
                                                        <option value="" > Select Mode</option>
                                                        <?php foreach ($mode as $key => $value) {?>
                                                            <option value="<?= $value->transfer_mode_id;?>"><?=$value->mode_name;?></option>
                                                            <?php }?>
                                                        </select> -->
                                                        <br>
                                                        <input type="hidden" name="mode" id="mode" value= '18'>
                                                        <label for="username">Available Stock : </label>
                                                        <label for="username" id="value"></label>
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Series Form</label>
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1" readonly><?= franchise_id(); ?></span>
                                                        </div>
                                                        <input type="number" name="series_form" id="series_form"
                                                            class="form-control" placeholder="Series Form" required value=""  readonly aria-describedby="basic-addon1">
                                                        </div>
                                                        <span id="err" style="color:red;"></span>
                                                        <input type="hidden" id="series_to_defualt">
                                                        <input type="hidden" id="series_from_defualt">
                                                    </div>
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Series To</label>
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1" readonly><?= franchise_id(); ?></span>
                                                        </div>
                                                      
                                                            <input type="number" name="series_to" id="series_to"
                                                            class="form-control" placeholder="Series To" value="" required aria-describedby="basic-addon1" readonly>
                                                        </div>
                                                        
                                                    </div>
													<div class="col-3 mb-3">
                                                        <label for="username">Qty</label>
                                                        <input type="text" name="awb_qty" readonly class="form-control" value="" required id="qty">
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
        <!-- END: Content-->


<!-- START: Footer-->
        <?php $this->load->view('admin/admin_shared/admin_footer');
//include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
		<script type="text/javascript">
$("#qty").blur(function ()
  {
    var mode = $('#mode').val();
    var awb_qty = $('#qty').val();
    //   console.log(awb_qty);
      $.ajax({
        type: 'POST',
        url: 'Admin_stock_allowtment/stock_value',
        data: 'mode=' + mode +'&awb_qty='+ awb_qty,
        dataType: "json",
        success: function (d)
		{   
            
            if(d !== ''){
                console.log(d);
                // var output =  ' : <span>'+d.series_form+' to '+ awb_qty+'</span>';

                // $('#value').html(output);
            }
        //      var d =JSON.parse(r);ssss
        //   $('#series_from').val(d.series_form);
        //   $('#series_to').val(d.series_to);
        //   $('#mode').val(d.mode);

        }
      });
  });

  $("#series_form").blur(function () {
   var series_to_defualt = Number($('#series_from_defualt').val());
   var input = Number($(this).val());
        if(input != ''){
            if(input >= series_to_defualt){
                $(this).val();
            }else{
               alert('This seriess are assign aleady');
               $(this).val(series_to_defualt);
            }
        }
  });
  
  $('#Franchise').select2();
  $("#series_to").blur(function () {
            var series_form = Number($('#series_form').val());
            var series_to = Number($('#series_to').val());
            var series_to_defualt = Number($('#series_to_defualt').val());
            var final = series_to - series_form + 1;
        if(series_to !=''){
            if(series_form <= series_to){
                    if(final>0){
                        if(final <= series_to_defualt){
                            $('#qty').val(final);
                        }else{
                            alert("Stock Not Available Please check your Stock");
                            $('#series_to').val('');
                            $('#qty').val('');
                        }           
                    }else{
                        $('#qty').val('');
                    }
            }else{
                alert("Please assign Mini "+series_form);
                $('#series_to').val('');
                $('#qty').val('');
            }
        }else{
          $('#qty').val('');
        }
    });

// function getAvailable(obj){
    var mode = $('#mode').val();
    var awb_qty = $('#qty').val();
    if (mode) {

    
        $.ajax({
            type: 'POST',
            url: 'Admin_stock_allowtment/get_stock_value',
            data: 'mode=' + mode ,
            dataType: "json",
            success: function (d)
            {              
                // console.log(d);                   
                // console.log( d.seriess_to);                   
                    if(d.seriess_to =='Data Not Found'){
                        var a = 300502;
                    }else{ 
                        var a = d.seriess_to;
                    }
                    
                    let y = 1;
                    let series_to_defualt = parseFloat(a) + y;
                    $('#series_form').val(series_to_defualt);
                    $('#series_from_defualt').val(series_to_defualt);
                   
                    // alert(series_to_defualt);
                if(d.stock == 'Stock Not Available'){
                    var output =  '<span style="color:red;"> Stock Not Available</span>';
                    $('#value').html(output);
                    $('#series_form').prop('readonly',true);
                    $('#series_to').prop('readonly',true);
                    $('#series_to_defualt').val('');
                    $('#series_form').val('');
                }else{
                    var output =  '<span><b>'+d.stock+'</b></span>';
                    $('#value').html(output);
                    $('#series_form').prop('readonly',true);
                    $('#series_to').prop('readonly',false);
                    $('#series_to_defualt').val(d.stock);
                }

            }
        });

    }
// }
</script>
    </body>
    <!-- END: Body-->
</html>
