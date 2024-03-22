<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<!-- END Head-->
<style>
    .fade:not(.show) {
    opacity: 1;
}
</style>
<!-- START: Body-->

<body id="main-container" class="default">


    <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
    // include('admin_shared/admin_sidebar.php'); 
    ?>
    <!-- END: Main Menu-->
    <style>
        .table.layout-primary tbody td:last-child {
            background-color: #ffffff;
            color: aliceblue;
        }
    </style>
    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Listing-->
            <div class="row">
                <div class="col-12  align-self-center">
                    <div class="col-12 col-sm-12 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between align-items-center">
                                <h4 class="card-title">Pickup Document Data</h4>
                            </div>
                        
                            <div class="card-body">
                           
                                <div class="table-responsive">
                                    <table class=" table table-striped table-bordered"><!-- id="example"-->
                                        <thead>
                                            <tr>
                                               
                                                <th scope="col">Request ID</th>
                                                <th scope="col">Loading Slip</th>
                                                <th scope="col">Before Seal</th>
                                                <th scope="col">After Seal</th>
                                                <th scope="col">Empty Lorry</th>
                                                <th scope="col">Loaded Lorry</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (!empty($pickup_document_data)) {
                                                $cnt = 1;  //print_r($get_ftl_document);
                                                foreach ($pickup_document_data as $value) : ?>
                                                    <tr>
                                                    
                                                        <td><?php echo $value['ftl_id']; ?></td>
                                                        <td><a href="<?php echo base_url();?>assets/ftl_documents/Loading-Slip/<?php echo $value['loading_slip'];?>"download><img src ="<?php echo base_url();?>assets/ftl_documents/Loading-Slip/<?php echo $value['loading_slip'];?>"style="width:100px;height:100px;"></a></td>
                                                        <td><a href="<?php echo base_url();?>assets/ftl_documents/Before-Seal/<?php echo $value['before_seal'];?>"download><img src ="<?php echo base_url();?>assets/ftl_documents/Before-Seal/<?php echo $value['before_seal'];?>"style="width:100px;height:100px;"></a></td>
                                                        <td><a href="<?php echo base_url();?>assets/ftl_documents/After-Seal/<?php echo $value['after_seal'];?>"download><img src ="<?php echo base_url();?>assets/ftl_documents/After-Seal/<?php echo $value['after_seal'];?>"style="width:100px;height:100px;"></a></td>
                                                        <td><a href ="<?php echo base_url();?>assets/ftl_documents/Empty-Lorry/<?php echo $value['empty_lorry'];?>" download> <img src ="<?php echo base_url();?>assets/ftl_documents/Empty-Lorry/<?php echo $value['empty_lorry'];?>" style="width:100px;height:100px;"></a></td>
                                                        <td><a href ="<?php echo base_url();?>assets/ftl_documents/Loaded-Lorry/<?php echo $value['loaded_lorry'];?>" download> <img src ="<?php echo base_url();?>assets/ftl_documents/Loaded-Lorry/<?php echo $value['loaded_lorry'];?>" style="width:100px;height:100px;"></a></td>
                                                        <td><a href="<?php echo base_url("admin/update_upload_trip_documents/".$value['ftl_id']);?>" class="btn btn-primary">Update</a></td>
                                                  </tr>
                                             
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="10" style="color:red;">No Data Found</td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                     
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php  echo $this->pagination->create_links(); ?>
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
    //include('admin_shared/admin_footer.php'); 
    ?>
<!-- END: Body-->

</html>