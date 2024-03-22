<?php include(dirname(__FILE__) . '/../admin_shared/admin_header.php'); ?>
<!-- END Head-->
<style>
  .buttons-copy {
    display: none;
  }

  .buttons-csv {
    display: none;
  }

  .buttons-excel {
    display: none;
  }

  .buttons-pdf {
    display: none;
  }

  .buttons-print {
    display: none;
  }

  .form-control {
    color: black !important;
    border: 1px solid var(--sidebarcolor) !important;
    height: 27px;
    font-size: 10px;
  }

  .form-control select2-hidden-accessible {
    background: lavender !important;
  }
</style>
<!-- START: Body-->

<body id="main-container" class="default">


  <!-- END: Main Menu-->

  <?php include(dirname(__FILE__) . '/../admin_shared/admin_sidebar.php'); ?>
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
                <h4 class="card-title">Add Franchise Rate</h4>
                <!--  <span style="float: right;"> <a href="admin/view-domestic-customer" class="fa fa-plus btn btn-primary">View  Domestic Rate</a></span> -->
              </div>
              <div class="card-content">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <form role="form" action="admin/franchise-rate-insert" method="post">
                        <div class="box-body">
                          <div class="form-group row">
                            <label for="ac_name" class="col-sm-3 col-form-label">Group Name</label>
                            <div class="col-sm-3">
                              <!-- <select name="customer_id" class="form-control" require> -->
                              <select name="group_id" class="form-control filter-data" required>
                                  <option>Select Group</option>
                                  <?php foreach ($customer_list as $cl) {
                                      if(!empty($cl['booking_bill_type'])){
                                        $shipment_type = $cl['group_name'].' -- '.bill_type[$cl['booking_bill_type']];
                                      }else{
                                        $shipment_type = $cl['group_name'];
                                      }
                                      
                                    ?>
                                     
                                      <option value="<?php echo $cl['id']; ?>"><?php echo $shipment_type; ?></option>
                                  <?php } ?>
                              </select>

                              </select>
                            </div>
                            <label for="ac_name" class="col-sm-3 col-form-label">Applicable From</label>
                            <div class="col-sm-3">
                              <input type="date" name="applicable_from" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Applicable From">
                            </div>

                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="ac_name" class="col-sm-3 col-form-label">From Zone Name</label>
                          <div class="col-sm-3">
                            <select class="form-control filter-data" name="from_zone_id">
                              <option value="">-Select Zone-</option>
                              <?php foreach ($zone_list as $zl) {
                              ?>
                                <option value="<?php echo $zl['region_id']; ?>"><?php echo $zl['region_name']; ?>
                                </option>
                              <?php } ?>
                            </select>
                          </div>
                          <label for="ac_name" class="col-sm-3 col-form-label">To Zone Name</label>
                          <div class="col-sm-3">
                            <select class="form-control filter-data" name="to_zone_id">
                              <option value="">-Select Zone-</option>
                              <?php foreach ($zone_list as $zl) {
                              ?>
                                <option value="<?php echo $zl['region_id']; ?>"><?php echo $zl['region_name']; ?>
                                </option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="ac_name" class="col-sm-3 col-form-label">State Wise</label>
                          <div class="col-sm-3">
                            <select class="form-control" id="state_id" onchange="return select_city(this.value)" name="state_id[]" multiple>
                              <option value="">-Select State-</option>
                              <?php foreach ($states as $sl) {
                              ?>
                                <option value="<?php echo $sl['id']; ?>"><?php echo $sl['state']; ?>
                                </option>
                              <?php } ?>
                            </select>
                          </div>
                          <label for="ac_name" class="col-sm-3 col-form-label">City Wise</label>
                          <div class="col-sm-3">
                            <select class="form-control" id="city_id" name="city_id[]" multiple>
                              <option value="">-Select City-</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="ac_name" class="col-sm-3 col-form-label">Mode Name</label>
                          <div class="col-sm-3">
                            <select class="form-control filter-data" name="mode_id">
                              <option value="">-Select Mode-</option>
                              <?php foreach ($mode_list as $ml) {
                              ?>
                                <option value="<?php echo $ml['transfer_mode_id']; ?>"><?php echo $ml['mode_name']; ?>
                                </option>
                              <?php } ?>
                            </select>
                          </div>
                          <label for="ac_name" class="col-sm-3 col-form-label">TAT</label>
                          <div class="col-sm-3">
                            <input type="text" name="tat" class="form-control" id="tat">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Shipment</label>
                          <div class="col-sm-3">
                            <select class="form-control filter-data" name="doc_type" id="doc_type">
                              <option value="">-Select-</option>
                              <option value="1">Non-Doc</option>
                              <option value="0">Doc</option>
                            </select>
                          </div>

                        </div>
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <div class="table-responsive">
                              <table class="table layout-primary bordered weight-table">
                                <thead>
                                  <tr>
                                    <th>Weight Range-From</th>
                                    <th>Weight Range-To</th>
                                    <th>Rate</th>
                                    <th>Rate Type</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><input type="text" name="weight_range_from[]" class="form-control" placeholder="From"></td>
                                    <td><input type="text" name="weight_range_to[]" class="form-control" placeholder="To"></td>
                                    <td><input type="text" name="rate[]" class="form-control rate" placeholder="Enter Rate"></td>
                                    <td style="background-color: #fff ! important;">
                                      <select class="form-control"  name="fixed_perkg[]">
                                        <option value="">-Select Type-</option>
                                        <option value="0">Fixed</option>
                                        <option value="1">Addtion 250GM</option>
                                        <option value="2">Addtion 500GM</option>
                                        <option value="3">Addtion 1000GM</option>
                                        <option value="4">Per Kg</option>
                                      </select>
                                    </td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <a href="javascript:void(0)" class="btn btn-sm btn-primary add-weight-row" style="margin-bottom: 5px;"><i class="icon-plus"></i></a>&nbsp;<a href="javascript:void(0)" class="btn btn-sm btn-danger remove-weight-row" style="margin-bottom: 5px;"><i class="icon-trash"></i></a>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-2">
                            <div class="box-footer">
                              <button type="submit" class="btn btn-primary">Add Rate</button>
                            </div>
                          </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row" id="div_transfer_rate" style="display: none;">
                  <!-- style="display: none;" -->
                  <div class="col-12">
                    <form role="form" action="admin/insert-domestic-transfer-rate" method="post" enctype="multipart/form-data">
                      <div class="box-body border">
                        <h6><b>Transfer Rate</b><a href="" onclick="return hide_transfer_div()"><i class="ion-close-circled"></i></a></h6>
                        <div class="form-group row">
                          <!--  <label class="col-sm-1">Courier</label> -->
                          <!--  <div class="col-sm-2">-->
                          <!--   <input type="hidden" name="courier_id" id="courier_id">-->
                          <!--   <input type="hidden" name="transfer_customer_id" id="transfer_customer_id">-->
                          <!--   <input type="text" name="c_company_name" id="c_company_name" class="form-control">-->
                          <!--</div> -->

                          <label class="col-sm-1">Courier</label>
                          <div class="col-sm-2">
                            <select name="sel_courier_id[]" id="sel_courier_id" class="form-control" multiple>
                            </select>
                          </div>
                          <!-- <label class="col-sm-1">To</label> -->
                          <div class="col-sm-4">
                            To<input type="hidden" name="transfer_customer_id" id="transfer_customer_id">
                            <input type="hidden" name="db_applicable_from" id="db_applicable_from">
                            <select name="to_customer_id[]" id="to_customer" style="width: 150px;" class="form-control" multiple size=8>
                              <?php foreach ($customer_list as $custl) { ?>
                                <option value="<?php echo $custl['customer_id'] ?>"><?php echo $custl['customer_name'] . " - " . $custl['cid']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <label class="col-sm-1">Transfer Date</label>
                          <div class="col-sm-2">
                            <input type="date" class="form-control" name="transfer_date" id="transfer_date">
                          </div>

                          <div class="col-sm-1">
                            <input type="submit" class="btn btn-primary" name="submit" id="submit_transfer">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!--   <hr>  -->
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table  class="display table dataTable table-striped table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">Sr.</th>
                            <th scope="col">Group Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (!empty($added_customer_list)) {
                            $cnt = 0;
                            foreach ($added_customer_list as $value) {

                              $cnt++;
                          ?>
                              <tr>
                                <td scope="col"><?php echo $cnt; ?></td>
                                <td scope="col"> <a href="<?=base_url('admin/view-franchise-rate/'.$value['group_id']);?>"> <?php echo $value['group_name']; ?></a></td>                              
                                <td><?php echo date("d-m-Y", strtotime($value['created_at'])); ?></td>
                                <td> <a href="javascript:void(0)" relid="<?php echo $value['group_id']; ?>" title="Delete" class="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a></td>
                              </tr>
                          <?php
                            }
                          } else {
                            echo "<p>No Data Found</p>";
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
  <!-- START: Footer-->
</body>
<!-- END: Body-->

<style type="text/css">
  .btn-group.show {
    width: 100%;
  }
</style>

</html>
<script type="text/javascript">
  // this is use for adding the new row for in Measurement Units
  $(".add-weight-row").on('click', function() {

    var allTrs = $('table.weight-table tbody').find('tr');
    var lastTr = allTrs[allTrs.length - 1];
    var $clone = $(lastTr).clone();

    var countrows = $(".rate").length;
    $clone.find('td').each(function() {
      var el = $(this).find(':first-child');
      var id = el.attr('id') || null;
      if (id) {
        var i = id.substr(id.length - 1);

        var nextElament = countrows; //parseInt(i)+1;
        var remove = 1;
        if (countrows > 10) {
          var remove = 2;
        }
        var removeChar = (id.length - remove);
        var prefix = id.substr(0, removeChar);


        //console.log('prefix:::' + prefix + '::::' + id + '::::' + removeChar);
        el.attr('id', prefix + (nextElament));
        el.attr('data-attr', (nextElament));
      }
    });
    $clone.find('input:text').val('');
    $('table.weight-table tbody').append($clone);
    var totalRow = $('table.weight-table tbody').find('tr').length;

    if (totalRow > 1) {
      $('.remove-weight-row').show();
    } else {
      $('.remove-weight-row').hide();
    }

  });
  // this fucntion is use for removing the row from table 
  $(".remove-weight-row").on('click', function() {
    var totalRow = $('table.weight-table tbody').find('tr').length;
    if (totalRow > 1) {
      $('table.weight-table tbody').find('tr:last').remove();
      totalRow--;

    }
    if (totalRow == 1) {
      $(this).hide();
    }

  });

  function show_div(courier_id, c_company_name, customer_id, db_applicable_from) {
    //$("#courier_id").val(courier_id);
    $("#c_company_name").val(c_company_name);
    $("#transfer_customer_id").val(customer_id);
    $("#db_applicable_from").val(db_applicable_from);

    $.ajax({
      type: 'POST',
      // url: 'Admin_domestic_shipment_manager/getcity',
      url: 'Admin_domestic_rate_manager/get_inserted_courier',
      data: 'customer_id=' + customer_id,
      dataType: "json",
      success: function(d) {
        var option;
        option = '<option value="ALL">ALL</option>';
        for (var i = 0; i < d.length; i++) {
          option += '<option value="' + d[i].c_courier_id + '" >' + d[i].c_company_name + '</option>';
        }

        $("#sel_courier_id").select2();
        $('#sel_courier_id').html(option);
        //$("#to_customer").select2();

        //  $("#sel_courier_id").multiselect('rebuild');
      }
    });


    $("#div_transfer_rate").show();

    return false;
  }
  //   $('#to_customer').multiselect({
  //                 includeSelectAllOption: true,
  //                 enableFiltering: true,
  //                 maxHeight: 150
  //               });
  //   $('#customer_id').multiselect({
  //                 includeSelectAllOption: true,
  //                 enableFiltering: true,
  //                 maxHeight: 150
  //               });


  //$("#customer_id").select2();
  //$("#to_customer").select2();
  //   $("#sel_courier_id").select2();

  $('#customer_id').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    maxHeight: 150
  });
  $('#to_customer').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    maxHeight: 150
  });

  $('#state_id').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    maxHeight: 150
  });
  $('#city_id').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    maxHeight: 150
  });

  function select_city(state_id) {
    var state_id = $('#state_id').val();
    $.ajax({
      type: 'POST',
      url: 'Admin_domestic_rate_manager/getStatewiseCity',
      data: {
        state_id: state_id
      },
      dataType: "json",
      success: function(d) {
        $('#city_id').html(d);

        $('#city_id').multiselect('rebuild');
      }
    });

  }

  // $('#sel_courier_id').multiselect({
  //                 includeSelectAllOption: true,
  //                 enableFiltering: true,
  //                 maxHeight: 150
  //               }); 
</script>
<script>
	$(document).ready(function() {
		$('.deletedata').click(function() {
			var getid = $(this).attr("relid");
			// alert(getid);
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
							url: baseurl + 'Admin_rate_group_master/delete_rate',
							type: 'POST',
							data: 'getid=' + getid,
							dataType: 'json'
						})
						.done(function(response) {
							swal('Deleted!', response.message, response.status)

								.then(function() {
									location.reload();
								})

						})
						.fail(function() {
							swal('Oops...', 'Something went wrong with ajax !', 'error');
						});
				}

			})

		});

	});
</script>