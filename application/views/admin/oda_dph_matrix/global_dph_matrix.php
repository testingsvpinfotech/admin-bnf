<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  .input-group{
    width: 60%!important;
  }
  	.form-control{
  		color:black!important;
  		border: 1px solid var(--sidebarcolor)!important;
  		height: 27px;
  		font-size: 10px;
  }
</style>
    <!-- START: Body-->
    <body id="main-container" class="default">
    <?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">
                              <h4 class="card-title"><?= $title; ?></h4>
                              <a href="<?= base_url(); ?>Admin_oda_dph_matrix/addnew_global_dph_matrix" class="btn btn-primary btn-sm">ADD NEW</a>

                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr.No.</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">Ltr Range(From-To)</th>
                                              <th scope="col">Rate(Per Kg)</th>
                                              <th scope="col" style="width: 30%;">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                     
                                      <?php
                                        $cnt=0;
                                        if (!empty($dph_data)) {
                                            foreach ($dph_data as $value) {
                                              $cnt++;
                                                ?>
                                              <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo date("d-m-Y",strtotime($value->start_date) ); ?></td>
                                                <td><?php echo $value->from_ltr.' - '.$value->to_ltr; ?></td>
                                                <td><?php echo $value->rate; ?></td>
                                                <td>
                                                  <a title="Edit" href="<?php base_url();?>Admin_oda_dph_matrix/update_global_dph_matrix/<?= $value->id; ?>" class="btn btn-primary"><i class="icon-pencil"></i></a>
                                                </td>
                                              </tr>
                                              <?php $cnt++;
                                            }
                                        }else{
                                            echo str_repeat("<td></td>",9);
                                        }
                                    ?>
                                    </tbody>
                              </table> 
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

