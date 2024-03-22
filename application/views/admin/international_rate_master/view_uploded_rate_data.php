<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
<style>
  .buttons-copy{display: none;}
  .buttons-csv{display: none;}
  /*.buttons-excel{display: none;}*/
  .buttons-pdf{display: none;}
  .buttons-print{display: none;}
  #example_filter{display: none;}
  .input-group{
    width: 60%!important;
  }
</style>
    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12">
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
					  
                          <div class="card-header">                               
                              <h4 class="card-title">View Rate</h4>
                          </div>
						  <div class="card-content">
                  <div class="card-body"> 
                   <div class="row">   
                    <div class="col-12">                    
                              <div class="card-body">
                              <div class="table-responsive">
                                 <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true"  >
                                  <span style="font-weight: bolder;font-size: 14px;"><?php echo $customer_list->customer_name; ?><br>
                                  <?php echo $courier_company->c_company_name; ?></span>                                   
                                      <thead>
                                             <?php 
                                              if (!empty($csv_file_header))
                                             {
                                                  $table_header=array();
                                                   foreach ($csv_file_header as $value) 
                                                   { 
                                                    $table_header[] = $value["zone_id"];																									
                                                   }
												   ?>
                                                   <tr>
                                                      <th scope="col">Export/Import</th>
                                                      <th scope="col">Doc/Non Doc</th>
                                                      <th scope="col">Rate Type</th>
                                                      <th scope="col">Weight</th>
                                                      <?php
                                                       for($th=0;$th < count($table_header);$th++)
                                                       { 
                                                        ?>
                                                        <th scope="col"><?php echo $table_header[$th]; ?></th>
                                                       <?php
                                                        }

                                                }
                                               ?>
                         </tr>
													</thead>
                           <tbody>
													<?php 
                           foreach ($csv_file_weight as $values) 
                           {       
                              $from_date=$value['from_date'];
												
														echo '<tr>';
														 ?> 
                             <td><?php echo $value['type_export_import'];?></td>
                              <td><?php if($values['doc_type']=='0'){echo "Doc";}else{echo "Non-Doc";}?></td>
                             <td><?php if($values['fixed_perkg']=='0'){echo "Fixed";}else{echo "Per Kg";} ?></td>
                             <td><?php echo $values['weight_from']."-".$values['weight_to']; ?></td>
						<?php 
						$weight_range_price	= $this->basic_operation_m->get_query_result("select * from tbl_international_rate_master where customer_id='".$values["customer_id"]."' AND courier_company_id='".$values["courier_company_id"]."' AND doc_type='".$values["doc_type"]."' AND from_date='".$from_date."' AND weight_from >= '".trim($values["weight_from"])."' AND  weight_to <= '".trim($values["weight_to"])."'");
														//echo  $this->db->last_query();
                            //exit;
														  foreach($weight_range_price as $j => $pll)
														  {
															  ?>
															  <td><?php echo $pll->rate; ?></td>
															  
															  <?php 
														  }
														echo '</tr>';
                                                   } ?>
                                                   
                                                    </tr>
													
                                                  </tbody>
                                                 
                                      </table> 
                              </div>
                          </div>
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
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
