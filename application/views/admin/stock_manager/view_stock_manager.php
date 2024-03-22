<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
<body id="main-container" class="default">
<?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
	<main>
		<div class="container-fluid site-width">
			<div class="row">
				<div class="col-12  align-self-center">
					<div class="col-12 col-sm-12 mt-3">
					  	<div class="card">
					
							<div class="card-header justify-content-between align-items-center">   <br><br> 
											 
							  	<h4 class="card-title">AWB Stock Manager</h4>
							  	<?php if($this->session->flashdata('notify') != '') {?>
								<div class="alert <?php echo $this->session->flashdata('class'); ?> alert-colored"><?php echo $this->session->flashdata('notify'); ?></div>
								<?php  unset($_SESSION['class']); unset($_SESSION['notify']); } ?>      
							  	<span style="float: right;margin-left: 8px"><a href="<?= base_url('admin/download-stock-report'); ?>" class="fa fa-plus btn btn-primary">Download Stock Report</a></span>

							  	<span style="float: right;"><a href="<?= base_url('admin/add-stock'); ?>" class="fa fa-plus btn btn-primary">Add Stock</a></span>
						  	</div>
						  	<div class="card-body">
							  	<div class="table-responsive">
								  	<table class="table table-bordered">
									  	<thead><tr>
										  	<th  scope="col">Sr.</th>
										  	<th  scope="col">Stock Entry Date</th>
										  	<th  scope="col">Series Form</th>
										  	<th  scope="col">Series To</th>
										  	<th  scope="col">Total Stock</th>
										  	<th  scope="col">Mode</th>
										  	<th  scope="col">Utilized</th>
										  	<th  scope="col">Available</th>
										</tr></thead>
										<tbody>
									 	<?php if (!empty($allcountrydata)){
											$cnt = 1;
										  foreach ($allcountrydata as $key => $value) {
										?>
									  	<tr class="odd gradeX">
											<td><?php echo $cnt?></td>
										  	<td><?php echo date('d-m-Y', strtotime($value->create_date));?></td>
										  	<td><?php echo $value->series_form;?></td>
										  	<td><?php echo $value->series_to;?></td>                                   
										  	<td><?php echo $value->total_awbs;?></td>
										  	<td> <?php  $id = $value->mode;
										  		$mode_name = $this->db->query("select mode_name from transfer_mode where transfer_mode_id = '$id'")->row();
										  		echo $mode_name->mode_name;?></td>
										  	<td><?php echo ($value->total_awbs - $value->awbs_limits);?></td>
										  	<td><?php echo $value->awbs_limits;?></td>
									  	</tr>
									  	<?php $cnt++; } }else{
											echo "<p>No Data Found</p>"; } ?>
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
<?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
</body>
<script>
	$(document).ready(function() {
	  $('.deletedata').click(function(){
		var getid = $(this).attr("relid");
	  // alert(getid);
	   var baseurl = '<?php echo base_url();?>'
		swal({
			title: 'Are you sure?',
			text: "You won't be able to Delete Stock",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
			if (result.value){
				$.ajax({
					url: baseurl+'Admin_stock_manager/delete_stock',
					type: 'POST',
					data: 'getid='+getid,
					dataType: 'json'
				})
				 .done(function(response){
					swal('Deleted!', response.message, response.status)
					 
				   .then(function(){ 
					location.reload();
				   })
				 
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				});
			}
 
		})
 
	});
	  $('.approve').click(function(){
		var getid = $(this).attr("relid");
	  // alert(getid);
	   var baseurl = '<?php echo base_url();?>'
		swal({
			title: 'Are you sure?',
			text: "Approve this Voucher",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Approve it!',
		}).then((result) => {
			if (result.value){
				$.ajax({
					url: baseurl+'Admin_expence_master/isapprove',
					type: 'POST',
					data: 'getid='+getid,
					dataType: 'json'
				})
				 .done(function(response){
					swal('Deleted!', response.message, response.status)
					 
				   .then(function(){ 
					location.reload();
				   })
				 
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				});
			}
 
		})
 
	});
	   
 });
</script>
  
</html>
