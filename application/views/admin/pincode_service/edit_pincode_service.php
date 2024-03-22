 
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
    	 <!-- END: Main Menu-->
   

        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->  
                <div class="row">
                 <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">     
                            <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>                          
                                <h4 class="card-title">Edit Pincode Service </h4>   
                                <?php }else{ ?>    
                                    <h4 class="card-title">View Pincode Service </h4>                            
                                <?php } ?>                             
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                        <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?> 
                                        <form role="form" action="<?php echo base_url('admin/update-pincode-service/'.$val->id);?>" method="post" >
<?php } ?>
                                            <div class="form-row">
                                                <div class="col-3 mb-3">
                                                    <label for="username">Pincode </label>
                                                    <input type="text" name="pincode" size="6"  maxlength="6" class="form-control" read id="pincodep" onkeypress="return isNumber(event)" required readonly value="<?= $val->pin_code;?>">
                                                </div>
                                                <div class="col-3 mb-3">
                                                    <label for="username">State</label>
                                                    <select name="state" class="form-control"  id="statep" required>
                                                    <!-- id="statep" -->
                                                        <option> -- Select State -- </option>
                                                        <?php foreach($state as $value){ ?>
                                                            <option value="<?=$value->id.'-'.$value->state;?>" <?php if($val->state_id == $value->id){ echo 'selected';} ?>> <?= $value->state; ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-3 mb-3">
                                                <label for="username">City</label>
                                                    <select name="city" class="form-control" id="cityp" required>
                                                    <!-- id="cityp" -->
                                                        <option> -- Select City -- </option>
                                                        <?php foreach($city as $value){ ?>
                                                            <option value="<?=$value->id.'-'.$value->city;?>" <?php if($val->city_id == $value->id){ echo 'selected';} ?>> <?= $value->city; ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-3 mb-3">
                                                <label for="username">Branch Name</label>
                                                    <select name="branch" class="form-control" id="branchp" required>
                                                    <!-- id="branchp" -->
                                                        <option> -- Select Branch -- </option>
                                                        <?php foreach($branch as $value){ if($value->branch_id !=39){?>
                                                            <option value="<?=$value->branch_id.'-'.$value->branch_name;?>" <?php if($val->branch_id == $value->branch_id){ echo 'selected';} ?>> <?= $value->branch_name; ?></option>
                                                            <?php } }?>
                                                    </select>
                                                </div>
                                                <div class="col-3 mb-3">
                                                <label for="username">Service Type</label>
                                                <select name="ioda" class="form-control service" required>
                                                    <option> -- Select Service Type -- </option>
                                                    <?php foreach (service_type as $key => $value) { ?>
                                                        <option value="<?= $key; ?>" <?php if ($key == $val->isODA) {
                                                             echo 'selected';
                                                         } ?>>
                                                            <?= $value; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                                <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?> 
                                                <div class="col-12">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?> 
                                            </form>
                                            <?php } ?>

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
       
        <!-- START: Footer-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
    $(document).ready(function() {
        $('.service').select2();
        $("#branchp").select2();
        $("#cityp").select2();
        $("#statep").select2();
        $("#reginp").select2();
    });
    </script>
    </body>
    <!-- END: Body-->
</html>
