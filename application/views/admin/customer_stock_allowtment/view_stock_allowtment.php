<?php $this->load->view('admin/admin_shared/admin_header'); ?>
<body id="main-container" class="default">
<?php $this->load->view('admin/admin_shared/admin_sidebar'); ?>
<main>
    <div class="container-fluid site-width">
        <div class="row">
            <div class="col-12  align-self-center">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div  class="card-header justify-content-between align-items-center">
                            <h4 class="card-title">View Customer Stock Allotment</h4>
                            <span style="float: right;">
                                <a href="<?php base_url(); ?>admin/add-customer-stock-allowtment" class="fa fa-plus btn btn-primary">Add Stock</a>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead><tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Stock Allotment Date</th>
                                        <th scope="col">Customer ID</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Series From</th>
                                        <th scope="col">Series To</th>
                                        <th scope="col">Total Allotment</th>
                                        <th>Utilizes</th>
                                        <th>Available</th>
                                        <th>Alloted By</th>
                                     
                                    </tr></thead>
                                    <tbody>
                                    <?php if (!empty($allvendor)) {
                                        $cnt = 1;
                                      
                                        foreach ($allvendor as $value) { ?>
                                    <tr>
                                        <td><?= $cnt; ?></td>
                                        <td><?= date('d-m-Y', strtotime($value['assigned_date'])); ?></td>
                                        <td><?php if(!empty($value['branch_name'])){ echo $value['branch_name'];}else{echo $value['cid'];} ?></td>
                                        <td><?php if(!empty($value['branch_name'])){ echo $value['branch_name'];}else{echo $value['customer_name'];} ?></td>
                                        <td><?php if(!empty($value['customer_name'])){ echo $value['seriess_from'];}else{ echo $value['seriess_from']; }?></td>
                                        <td><?php if(!empty($value['customer_name'])){ echo $value['seriess_to'];}else{ echo $value['seriess_to']; }?></td>
                                        <!-- <td><?= $value['seriess_to']; ?></td> -->                                       
                                        <td><?php echo $value['qty']; ?></td>
                                        <td><?php echo $value['utilizes']; ?></td>
                                        <td></td>
                                        <td><?php if(!empty($value['assigned_by'])){
                                            echo $this->db->get_where('tbl_users',['user_id' => $value['assigned_by']])->row('username'); } ?></td>
                                    </tr>
                                    <?php $cnt++; } } else {
                                        echo "<tr><td colspan='10'>No Data Found</td></tr>"; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('admin/admin_shared/admin_footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function () {
        $('.deletedata').click(function () {
            var getid = $(this).attr("relid");
            var baseurl = '<?php echo base_url(); ?>'
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: baseurl + 'Admin_vendor/delete_vendor',
                        type: 'POST',
                        data: 'getid=' + getid,
                        dataType: 'json'
                    }).done(function (response) {
                        swal('Deleted!', response.message, response.status).then(function () {
                            location.reload();
                        })
                    }).fail(function () {
                        swal('Oops...', 'Something went wrong with ajax !', 'error');
                    });
                }
            })
        });
    });
</script>
</body>