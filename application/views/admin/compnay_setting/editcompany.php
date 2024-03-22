 <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/tiny_mce/pluginss/js/tinymce/jquery.tinymce.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/tiny_mce/pluginss/js/tinymce/tinymce.min.js"></script>  
 <script type="text/javascript">
            tinymce.init({
              selector: '.editor1',
              theme: 'modern',
              width: '100%',
              height: 500,
              location: "assets\tiny_mce\pluginss\kcfinder",
              plugins: [
                'fullpage advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor powerpaste codesample toc imagetools colorpicker textpattern help'
              ],
            fullpage_default_doctype: "<!DOCTYPE html>",
              content_css: 'css/content.css',
              toolbar1: 'newdocument | save | paste  insertfile undo redo | styleselect | formatselect | bold italic strikethrough forecolor backcolor emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
              toolbar2: 'link image media | visualblocks visualchars | template codesample | table toc  charmap hr | pagebreak nonbre nonbreaking | searchreplace | advlist lists anchor spellchecker | wordcount | insertdatetime | contextmenu | textcolor removeformat | print preview code fullscreen help | powerpaste imagetools colorpicker textpattern',
              image_advtab: true,
              templates: [
                { title: 'Test template 1', content: 'Hello World' }, //Here Enter template Campaigning code
                { title: 'Test template 2', content: 'Test 2' }  //Here Enter template Campaigning code
              ],
              
              file_browser_callback: function(field, url, type, win) {
                tinyMCE.activeEditor.windowManager.open({
                    file: 'assets/tiny_mce/pluginss/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                    title: 'KCFinder',
                    width: 700,
                    height: 500,
                    inline: true,
                    close_previous: false
                }, {
                    window: win,
                    input: field
                });
                return false;
            }

            });
    </script>
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
                                <h4 class="card-title">Update Company</h4>                                
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form role="form" action="<?php echo base_url();?>admin/edit-company/<?php echo $row->id;?>" method="post" enctype="multipart/form-data">

                                        <form role="form" action="<?php echo base_url();?>admin/add-company" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <div class="col-sm-3">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck2" value="true" name="branch_wise" <?php if($row->branch_wise=="true"){echo "checked";}?>>
                                                        <label class="custom-control-label" for="customCheck2">Branch wise Invoice</label>
                                                    </div>
                                                </div>
												<div class="col-sm-3">
                                                    <label  class="col-sm-12 col-form-label">Company Name</label>
                                                    <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="jq-validation-email" required name="company_name" value="<?php echo $row->company_name;?>" placeholder="Company Name">
                                                    </div>
												</div>
												<div class="col-sm-3">
                                                    <label class="col-sm-12 col-form-label">Company Logo</label>
                                                     <div class="col-sm-12">
                                                        <input type="hidden" name="logo_name" value="<?php echo $row->logo; ?>" >
                                                       <input type="file" class="form-control" id="logo" name="logo" placeholder="Company Logo">
                                                    </div>
                                                    <div>
                                                        <img src="<?php echo base_url()."assets/company/".$row->logo;?>" width="100" height="50">
                                                    </div>
												</div>

                        <div class="col-sm-3">
                          <label class="col-sm-12 col-form-label">Company Stamp</label>
                           <div class="col-sm-12">
                              <input type="hidden" name="stamp_name" value="<?php echo $row->stamp; ?>" >
                             <input type="file" class="form-control" id="stamp" name="stamp" placeholder="Company stamp">
                          </div>
                          <div>
                              <img src="<?php echo base_url()."assets/company/".$row->stamp;?>" width="100" height="50">
                          </div>
                        </div>
												
                                                   
                                                </div>
                                                 <div class="form-group row">
												 <div class="col-sm-3">
                                                     <label class="col-sm-12 col-form-label">Gst No</label>
                                                     <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="gst_no" name="gst_no" required placeholder="Enter Gst Number" value="<?php echo $row->gst_no;?>">
                                                    </div>
												</div>
												<div class="col-sm-3">
                                                    <label  class="col-sm-12 col-form-label">Email Id</label>
                                                    <div class="col-sm-12">
                                                        <input type="email" class="form-control" id="jq-validation-email" name="email" placeholder="Email Id" value="<?php echo $row->email;?>">
                                                    </div>
												</div>
												<div class="col-sm-3">
                                                    <label class="col-sm-12 col-form-label">Address</label>
                                                     <div class="col-sm-12">
                                                       <textarea class="form-control" id="jq-validation-email" name="address" required placeholder="Enter Address"><?php echo $row->address;?></textarea>
                                                    </div>
												</div>
												<div class="col-sm-3">
												<label  class="col-sm-12 col-form-label">PAN</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN Id" value="<?php echo $row->pan;?>">
                                                    </div>
												</div>
                                                     
                                                </div>
                                                 <div class="form-group row">
                                                    
                                                    <div class="col-sm-3">
														<label class="col-sm-12 col-form-label">Export International Invoice Series</label>
														<div class="col-sm-12">
														<input type="text" class="form-control" id="international_invoice_series" name="international_invoice_series" value="<?php echo $row->international_invoice_series;?>" required placeholder="Enter Invoice Series">
														</div>
													</div>
													<div class="col-sm-3">
														<label class="col-sm-12 col-form-label">Import International Invoice Series</label>
														<div class="col-sm-12">
														<input type="text" class="form-control" id="import_international_invoice_series" name="import_international_invoice_series" value="<?php echo $row->import_international_invoice_series;?>" required placeholder="Enter Invoice Series">
														</div>
                                                    </div>
													<div class="col-sm-3">
														<label class="col-sm-12 col-form-label">Domestic Invoice Series</label>
														 <div class="col-sm-12">
														   <input type="text" class="form-control" id="domestic_invoice_series" name="domestic_invoice_series" value="<?php echo $row->domestic_invoice_series;?>" required placeholder="Enter Invoice Series">
														</div>
													</div>
													<div class="col-sm-3">
														 <label class="col-sm-12 col-form-label">Contact Number</label>
														 <div class="col-sm-12">
														   <input type="text" class="form-control" id="phone_no" required name="phone_no" value="<?php echo $row->phone_no;?>" placeholder="Contact Number">
													</div>
                                                    </div>
													
                                                    
                                                </div>
                                                 <div class="form-group row">
												 <div class="col-sm-3">
												  <label class="col-sm-12 col-form-label">Website</label>
                                                     <div class="col-sm-12">
                                                       <input type="text" class="form-control" id="website" required name="website" value="<?php echo $row->website;?>" placeholder="Website">
                                                    </div>
                                                    </div>
													<div class="col-sm-3">
                                                     <label class="col-sm-12 col-form-label">Company Code</label>
                                                     <div class="col-sm-12">
                                                        <input type="text" class="form-control" name="company_code" value="<?php echo $row->company_code; ?>" >
                                                    </div>
												</div>
												<div class="col-sm-3">
                                                     <label class="col-sm-12 col-form-label">UDYAM Code</label>
                                                     <div class="col-sm-12">
                                                        <input type="text" class="form-control" value="<?php echo $row->udhyam_no;?>" name="udhyam_no"  >
                                                    </div>
												</div>
												<div class="col-sm-3">
                                                     <label class="col-sm-12 col-form-label">TAXABLE SERVICES</label>
                                                     <div class="col-sm-12">
                                                        <input type="text" class="form-control" value="<?php echo $row->taxable_service;?>" name="taxable_service"  >
                                                    </div>
												</div>
													<div class="col-sm-9">
                                                    <label class="col-sm-12 col-form-label">Invoice Terms & Condition</label>
                                                    <div class="col-sm-12">
                                                     <textarea class="form-control editor1" name="invoice_term_condition" id="editor1"><?php echo $row->invoice_term_condition;?></textarea>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="card-header">                               
                                                    <h4 class="card-title">Bank Detail</h4>
                                                </div>
                                                 <div class="form-group row">
                                                    <label  class="col-sm-2 col-form-label">Account Name</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="account_name" name="account_name" value="<?php echo $row->account_name;?>" placeholder="Account Name">
                                                    </div>
                                                    <label class="col-sm-2 col-form-label">Account Number</label>
                                                     <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo $row->account_number;?>" placeholder="Account Number">
                                                    </div>
                                                     <label class="col-sm-1 col-form-label">IFSC</label>
                                                     <div class="col-sm-2">
                                                         <input type="text" class="form-control" id="ifsc" name="ifsc" value="<?php echo $row->ifsc;?>" placeholder="Enter IFSC">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label  class="col-sm-2 col-form-label">Branch Name</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Enter Branch Name" value="<?php echo $row->branch_name;?>">
                                                    </div>
                                                    <label class="col-sm-2 col-form-label">Bank Name</label>
                                                     <div class="col-sm-2">
                                                         <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name" value="<?php echo $row->bank_name;?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Terms & Condition</label>
                                                     <div class="col-sm-8">
                                                        <textarea class="form-control editor1" name="term_condition" id="editor1"><?php echo $row->term_condition;?></textarea>

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
                                                </div>
                                            </form>

                                              <!--   <div class="form-row">
                                                    <div class="col-3 mb-3">
                                                        <label for="username">Company Name</label>

                                                       <input type="text" class="form-control" id="jq-validation-email" value="<?php echo $row->company_name;?>" name="company_name" placeholder="Company Name" required>

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Company Logo</label>    
                                                        <input type="file" class="form-control" id="jq-validation-email" value="<?php echo $row->logo;?>" name="logo" placeholder="Company Logo">
                                                    </div>

                                                    <div class="col-3 mb-3">
                                                        <label for="username">Contact Number</label>
														<input type="text" class="form-control" id="jq-validation-email" value="<?php echo $row->phone_no;?>" name="phone_no" placeholder="Contact Number">

                                                    </div>
                                                    <div class="col-3 mb-3"> 
                                                        <label for="email">Email Id</label>      
                                                         <input type="email" class="form-control" id="jq-validation-email" value="<?php echo $row->email;?>" name="email" placeholder="Email Id">
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <label for="username">Address</label>

                                                       <textarea class="form-control" id="jq-validation-email" name="address" placeholder="Enter Adress"><?php echo $row->address;?></textarea>

                                                    </div> 
                                                    <div class="col-12">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  -->
                                                        <!--  <button type="submit" class="btn btn-outline-warning">Reset</button> -->
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


		
		
		
		
		