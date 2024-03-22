<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->

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
                    <!-- <div class="col-12">
                             <form role="form" action="admin/view-uploded-rate-data" method="post" >
                                <div class="box-body">                 
                                 <div class="form-group row">
                                    <!-- <label for="ac_name" class="col-sm-3 col-form-label">Courier Company Name</label> -->
                                    <!--<div class="col-sm-3">                                        
                                         <select name="courier_company_name" class="form-control">
                                           <option value="">-Select Company-</option>
                                           <?php foreach ($courier_company as $cc) { ?>
                                          <option value="<?php echo $cc['c_id'] ?>" ><?php echo $cc['c_company_name'] ?></option>                                          
                                           <?php } ?>
                                        </select>
                                      </div>                                    
                                      <div class="col-sm-3">
                                        <select name="customer_name" class="form-control">
                                           <option value="">-Select Customer-</option>
                                           <?php foreach ($customer_list as $cusl) { ?>
                                          <option value="<?php echo $cusl['customer_id'] ?>" ><?php echo $cusl['customer_name'] ?></option>                                          
                                           <?php } ?>
                                         </select>
                                      </div>                  
                                                                  
                                      <div class="col-sm-3">
                                        <select name="doc_type" class="form-control">
                                              <option value="">-Select Type-</option>
                                              <option value="Dox" >Dox</option>
                                              <option value="Non-Dox" >Non-Dox</option>
                                         </select>
                                      </div>    
                                      <div class="col-sm-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                      </div>                  
                                  </div>       
                              </div>
                            </form>
                        </div>  -->                                        
                              
                  </div>
                  <hr>
                  </div>
                  <div class="card-body"> 
                   <div class="row">   
                    <div class="col-12">                    
                              <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table layout-primary bordered">
                                      <!-- <thead>
                                          <tr>
                                             <th scope="col">Sr.</th>
                                             <th scope="col">Courier Company Name</th>
                                             <th scope="col">Zone</th>  
                                             <th scope="col">Country</th>                         
                                             <th scope="col">Customer</th>                                       
                                             <th scope="col">Doc Type</th>
                                             <th scope="col">Weight</th>  
                                             <th scope="col">Rate</th>  
                                          </tr>
                                      </thead> -->
                                      <tbody>
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
													
													<?php 
                           foreach ($csv_file_weight as $values) 
                           {       
												
														echo '<tr>';
														 ?> 
                             <td><?php if($values['fixed_perkg']=='0'){echo "Fixed";}else{echo "Per Kg";} ?></td>
                             <td><?php echo $values['weight_from']."-".$values['weight_to']; ?></td>
														<?php 
														$weight_range_price	= $this->basic_operation_m->get_query_result("select * from tbl_internatial_rate_master where weight_from >= '".trim($values["weight_from"])."' and  weight_to <= '".trim($values["weight_to"])."'");
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
