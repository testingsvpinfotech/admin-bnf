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
                                <h4 class="card-title">Eway-bill And Invoice List</h4>
                            </div>
                        
                            <div class="card-body">
                                <?php if ($this->session->flashdata('notify') != '') { ?>
                                    <div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
                                <?php unset($_SESSION['class']);
                                    unset($_SESSION['notify']);
                                } ?>
                                <div class="table-responsive">
                                    <table class=" table table-striped table-bordered"><!-- id="example"-->
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th scope="col">Request ID</th>
                                                <th scope="col">Eway-bill No</th>
                                                <th scope="col">Invoice</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php if (!empty($get_ftl_document)) {
                                                $cnt = 1;  //print_r($get_ftl_document);
                                                foreach ($get_ftl_document as $value) : ?>
                                                    <tr>
                                                        <td><?php echo  $cnt++; ?></td>
                                                        <td><?php echo $value['ftl_id']; ?></td>
                                                        <td><a href="<?php echo base_url();?>assets/ftl_documents/eway_bill/<?php echo $value['eway_image'];?>"download><img src ="<?php echo base_url();?>assets/ftl_documents/eway_bill/<?php echo $value['eway_image'];?>"style="width:100px;height:100px;"></a></td>
                                                        <td><a href ="<?php echo base_url();?>assets/ftl_documents/invoice/<?php echo $value['invoice_image'];?>" download> <img src ="<?php echo base_url();?>assets/ftl_documents/invoice/<?php echo $value['invoice_image'];?>" style="width:100px;height:100px;"></a></td>
                                                   
                                                  </tr>
                                                  <?php  $cnt++; ?>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="10" style="color:red;">No Data Found</td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                        <input type="hidden" name="selected_campaing" id="selected_campaingss" value="">
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