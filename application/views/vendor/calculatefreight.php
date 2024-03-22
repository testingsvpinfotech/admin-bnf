    <!-- Content -->
    <div class="page-content">

        <!-- Client logo -->
        <div class="section-full dez-we-find bg-img-fix p-t50 p-b50">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-8">
                        <h3 class="form-title m-t0" style="color:#e95421;">CALCULATE YOUR FREIGHT ONLINE</h3>
                                <?php if (!empty($this->session->flashdata('msg'))) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                <?php } ?>
                            <form class="p-a30 dez-form" action="" method="POST">
                               
                                <div class="form-group">
                                    <label>Enter Source City</label>
                                    <input name="username" required="" class="form-control" placeholder="Enter Source City" type="text" />
                                </div>
                                <div class="form-group">
                                <label>Enter Destination City</label>
                                    <input name="password" required="" class="form-control " placeholder="Enter Destination City" type="text" />
                                </div>
                                <div class="form-group">
                                <label>Select Truck Type</label>
                                  <select class="form-control">
                                    <option>MDFG</option>
                                    <option>SFXC</option>
                                  </select>
                                </div>
                             
                                <div class="form-group text-left m-0">
                                    <button type="submit" name="submit" class="site-button dz-xs-flex m-r10">Calculate</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Client logo END -->
    </div>
    <!-- Content END-->