<div class="section-full dez-we-find bg-img-fix m-t50 p-b50" style="margin-top: 70px;">
    <div class="container">
        <div class="section-content">
            <?php //print_r($update_driver);?>
            <form action="<?php echo base_url('update-driver-data/'.$update_driver['ftl_request_id']);?>" method="POST" enctype="multipart/form-data">
                <div class="row mt-2">

                    <div class="form-group col-md-3">
                        <div class="form-group">
                            <label class="control-label">Driver Name <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="driver_name" class="form-control" placeholder="Enter driver Name ">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Driver Phone Number <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></span></label>
                            <input type="text" name="driver_contact_number" placeholder="Enter Driver Contact Number" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Vehicle Number <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></label>
                            <input type="text" class="form-control" name="vehicle_number" placeholder="Enter Vehicle Number" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Driver Licence <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></label>
                            <input type="text" class="form-control" name="driver_licence" placeholder="Enter Vehicle Number" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">RC Book <span style="color:red;"><i class="fa fa-star" aria-hidden="true"></i></label>
                            <input type="file" class="form-control" name="rc_book" placeholder="Enter Vehicle Number" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <button type="submit" name="submit" class="btn  btn-lg btn-primary mt-2">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>