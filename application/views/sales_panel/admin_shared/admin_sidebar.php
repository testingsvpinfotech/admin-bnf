<!-- START: Pre Loader
        <div class="se-pre-con">
            <div class="loader"></div>
        </div>
        START: Header-->
<div id="header-fix" class="header fixed-top ">
	<div class="site-width">
		<nav class="navbar navbar-expand-lg  p-0">
			<div class="navbar-header  h-100 h4 mb-0 align-self-center logo-bar text-left">
				<a href="javascript:void(0);" class="horizontal-logo text-left">
					<?php $company_details = $this->basic_operation_m->get_table_row('tbl_company',array('id'=>1)); ?>
					<img src="assets/company/<?php echo $company_details->logo; ?>" class="portfolioImage img-fluid">
					</a>
				</div>
				<div class="navbar-right">
                        <!-- START: Main Menu-->
                        <div class="sidebar">
                            <div class="site-width">
                                <!-- START: Menu-->
                                 <!-- START: Menu-->
                                <ul id="side-menu" class="sidebar-menu">
									<li class="dropdown active">                  
                                     <ul>
										<li class="active"><a href="Admin_sales/dashboard"><i class="icon-home mr-1"></i> Dashboard</a></li>
										
										<li class="dropdown"><a href="javascript:void(0);">Customer</a>
											<ul class="sub-menu">
												<li>
													<li><a href="Admin_sales/customer_list"><i class="fa fa-eye"></i>Customer List</a></li>
												</li>
											</ul>
										</li>
										<li class="dropdown"><a href="javascript:void(0);">FTL</a>
											<ul class="sub-menu">
												<li>
													<li><a href="Admin_sales/ftl_request"><i class="fa fa-eye"></i>View FTL Request</a></li>
												</li>
											</ul>
										</li>
										<li class="dropdown"><a href="javascript:void(0);">Report</a>
											<ul class="sub-menu">
												<li>
													<li><a href="Admin_sales/ftl_request"><i class="fa fa-eye"></i>daily Sales Report</a></li>
												</li>
											</ul>
										</li>


										<li class="dropdown"><a href="javascript:void(0);">PTL List</a>
											<ul class="sub-menu">
												<li>
													<li class="active"><a href="<?php echo base_url();?>Admin_sales/ptl_list"><i class="icon-fire"></i>PTL List</a></li>
												
												</li>
											</ul>
										</li>
                                     </ul>
                                    </li>
								
                                </ul>
								
								
                                
                            </li></ul></div>
                        </div>
                        <!-- END: Main Menu-->
                        
                       <ul id="top-menu" class="top-menu">   
                        
                            <li class="dropdown user-profile align-self-center d-inline-block">
                                <a href="#" class="nav-link py-0" data-toggle="dropdown" aria-expanded="false"> 
                                    <div class="media">                                   
                                        <img src="assets/image/avtar.png" alt="" title="LU0001" class="d-flex img-fluid rounded-circle" width="29">
                                    </div>
                                </a>
                                <center><b><?php echo $this->session->userdata('username');?></b></center>                                                                  
                                <div class="dropdown-menu border dropdown-menu-right p-0">
                                    <a href="Login/logout" class="dropdown-item px-2 text-danger align-self-center d-flex">
                                        <span class="icon-logout mr-2 h6  mb-0"></span> Sign Out</a>
                                </div>

                            </li>

                        </ul>
                    </div>
				</nav>
			</div>
		</div>
		<!-- END: Header-->
		