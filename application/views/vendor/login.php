    <!-- Content -->
    <div class="page-content">

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix p-t50 p-b50">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-8">
                        <h3 class="form-title m-t0" style="color:#e95421;">Sign In</h3>
                                <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                <?php } ?>
                            <form class="p-a30 dez-form" action="login" method="POST">
                                <p style="color:#e95421;">Enter your e-mail address and your password.</p>
                                <div class="form-group">
                                    <input name="username" required="" class="form-control" placeholder="User Name" type="text" />
                                </div>
                                <div class="form-group">
                                    <input name="password" required="" class="form-control " placeholder="Type Password" type="password" />
                                </div>
                                <div class="form-group text-left m-0">
                                    <button type="submit" name="submit" class="site-button dz-xs-flex m-r10">login</button>
                                </div>
                            </form>
                            <div class="p-a10">
                            <a href="<?php echo base_url('add-vendor');?>" class="text-primary float-left" style="color:#e95421;">Create an account</a>
                            <a class="text-primary float-right" style="color:#e95421;"><i class="fa fa-unlock-alt"></i> Forgot Password</a>
                         </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Client logo END -->
    </div>
    <!-- Content END-->