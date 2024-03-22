     <?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
     <style>
    .buttons-copy{display: none;}
    .buttons-csv{display: none;}
    /*.buttons-excel{display: none;}*/
    .buttons-pdf{display: none;}
    .buttons-print{display: none;}
    .form-control{
      color:black!important;
      border: 1px solid var(--sidebarcolor)!important;
      height: 27px;
      font-size: 10px;
  }
  </style>     
        <!-- END: Main Menu-->
    <?php $this->load->view('admin/admin_shared/admin_sidebar');
   // include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Listing-->
                <div class="row">                 
                  <div class="col-12  align-self-center">
                      <div class="col-12 col-sm-12 mt-5">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">
                              <h4 class="card-title">ToPay Invoice List</h4>                              
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="example" class="display table dataTable table-striped table-bordered layout-primary" data-sorting="true">
                                      <thead>
                                          <tr>  
                                              <th scope="col">Sr No</th>
                                              <th scope="col">Branch</th>
                                              <th scope="col">Invoice No</th>                                     
                                              <th scope="col">Invoice Date</th>
                                              <th scope="col">Invoice Amount</th>
                                              <th scope="col">Consignee Name</th>
                                              <!-- <th scope="col">Contact Number</th> -->
                                              <!-- <th scope="col">GSTNo</th> -->
                                              <th scope="col">CGST</th>
                                              <th scope="col">SGST</th>
                                              <th scope="col">IGST</th>
                                              <th scope="col">Total</th>
                                              <th scope="col">Grand Total</th>
                                              <th>Created By</th>
                                              <th>Approved By/Date</th>
                                              <th>Reference Number</th>
                                              <th>Payment Method</th>
                                              <th>Payment By</th>
                                              <th>Update Payment By</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>                                        
                                      <tr>
                                        <?php
                                        if (!empty($allpoddata)) {
                                          $cnt=0;
                                            foreach ($allpoddata as $value) {
                                              $cnt++;
                                                ?>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $value['branch_name']; ?></td>
                                                <td><?php echo $value['invoice_no']; ?></td>
                                                <td><?php if($value['invoice_date']!=""){ echo date("d-m-Y",strtotime($value['invoice_date']) ); } ?></td>
                                                <td><?php echo $value['total_amount']; ?></td>
                                                <td><?php echo $value['consigner_name']; ?></td>
                                              
                                                <td><?php echo $value['cgst_amount']; ?></td>
                                                <td><?php echo $value['sgst_amount']; ?></td>
                                                <td><?php echo $value['igst_amount']; ?></td>
                                                <td><?php echo $value['total_amount']; ?></td>
                                                <td><?php echo $value['grand_total']; ?></td>
                                                <td><?php echo $value['created_by']; ?></td>
                                                <td><?= (!empty($value['approved_by']))?$value['approved_by'].'<br/>'.date('d-m-Y', strtotime($value['approveDtm'])):''; ?></td>
                                                <td><?= $value['ref_name'] ?></td>
                                                <td><?= $value['pay_method'] ?></td>
                                                <?php 
                                                	$pay_name = $this->db->get_where('tbl_users',['user_id' => $value['pay_by']])->row('full_name'); 
                                                	$date = ($value['pay_date'] == '0000-00-00' || $value['pay_date'] == NULL)?'':date('d-m-Y', strtotime($value['pay_date']));
                                                ?>
                                                <td><?php echo $pay_name.'<br>'.$date; ?></td>
                                                <?php 
                                                	$pay_name1 = $this->db->get_where('tbl_users',['user_id' => $value['edit_pay_by']])->row('full_name'); 
                                                	$date1 = ($value['edit_pay_date'] == '0000-00-00' || $value['edit_pay_date'] == NULL)?'':date('d-m-Y', strtotime($value['edit_pay_date']));
                                                ?>
                                                <td><?php echo $pay_name1.'<br>'.$date1; ?></td>
                                                <td>
                                                	<?php if($this->session->userdata('userType') == 1 || $this->session->userdata('userType') == 10){ ?>
                                                  <a href="<?php base_url();?>admin/show-edit-domestic-topay-invoice/<?php echo $value['id']; ?>" ><i class="ion-edit" style="color:var(--primarycolor);"></i></a> |
                                                  <?php if(empty( $value['ref_name'])){ ?>
                                                  <a type="button" data-toggle="modal" data-target="#updateModal<?php echo $value['id']; ?>">Payment</a> |
                                                  <?php }else{ ?>
                                                  <a type="button" data-toggle="modal" data-target="#updateModal1<?php echo $value['id']; ?>">Edit Payment</a> |
                                                  <?php } } ?>
                                                  <a title="View" href="<?php base_url();?>admin/topay-invoice-domestic-view/<?php echo $value['id'];?>" class=""><i class="icon-eye"></i></a> |

                                                  <a href="javascript:void(0)" relid = "<?php echo  $value['id']; ?>"  title="Delete" class="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                                </td>
                                            </tr>
<!-- Modal -->
<div class="modal fade" id="updateModal<?php echo $value['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="payment_update_form<?= $value['id']; ?>">
          <div class="row">
            <div class="col-12">
              <label>Reference Number</label>
              <input name="ref_name" id="ref_name<?= $value['id']; ?>" value="<?= (!empty($value['ref_name']))?$value['ref_name']:''; ?>" class="form-control">
            </div>
            <div class="col-12">
              <label>Pay Method</label>
              <select name="pay_method" id="pay_method<?= $value['id']; ?>" class="form-control">
              	<?php $pay1 = (!empty($value['pay_method']))?$value['pay_method']:''; ?>
              	<option value="">Please Select</option>
              	<?php if(!empty($pay_method)): foreach ($pay_method as $v): ?>
              		<option value="<?= $v->method; ?>" <?= ($v->method == $pay1)?'selected':''; ?>><?= $v->method; ?></option>
              	<?php endforeach; endif; ?>
              </select>
            </div>
            <div class="col-12">
              <label>Pay Date</label>
              <input name="pay_date" id="pay_date<?= $value['id']; ?>" value="<?= date('Y-m-d'); ?>" class="form-control" readonly>
            </div>
            <div class="col-12 mt-2">
              <button type="button" onclick="update_payment_topay_details(<?= $value['id']; ?>)" class="btn btn-primary">UPDATE</button>
            </div>
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal1<?php echo $value['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="payment_update_form1<?= $value['id']; ?>">
          <div class="row">
            <div class="col-12">
              <label>Reference Number</label>
              <input name="ref_name1" id="ref_name1<?= $value['id']; ?>" value="<?= (!empty($value['ref_name']))?$value['ref_name']:''; ?>" class="form-control">
            </div>
            <div class="col-12">
              <label>Pay Method</label>
              <select name="pay_method1" id="pay_method1<?= $value['id']; ?>" class="form-control">
              	<?php $pay1 = (!empty($value['pay_method']))?$value['pay_method']:''; ?>
              	<option value="">Please Select</option>
              	<?php if(!empty($pay_method)): foreach ($pay_method as $v): ?>
              		<option value="<?= $v->method; ?>" <?= ($v->method == $pay1)?'selected':''; ?>><?= $v->method; ?></option>
              	<?php endforeach; endif; ?>
              </select>
            </div>
            <div class="col-12">
              <label>Pay Date</label>
              <input name="pay_date1" id="pay_date1<?= $value['id']; ?>" value="<?= date('Y-m-d'); ?>" class="form-control" readonly>
            </div>
            <div class="col-12 mt-2">
              <button type="button" onclick="update_payment_topay_details1(<?= $value['id']; ?>)" class="btn btn-primary">UPDATE</button>
            </div>
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div>

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
<script type="text/javascript">
  function update_payment_topay_details(id){

    $.ajax({
      	type:'POST',
      	url:'<?php echo base_url()?>admin_domestic_booking/update_topay_payable_details/'+id,
      	data:$('#payment_update_form'+id).serialize(),
      	success:function(d)
      	{
      		if (d==1) {
      			alert("Success");
      			window.location.reload();
      		}else{
      			alert("Failed");
      		}
      	}
    });
  }

  function update_payment_topay_details1(id){

    $.ajax({
      	type:'POST',
      	url:'<?php echo base_url()?>admin_domestic_booking/update_topay_payable_details1/'+id,
      	data:$('#payment_update_form1'+id).serialize(),
      	success:function(d)
      	{
      		if (d==1) {
      			alert("Success");
      			window.location.reload();
      		}else{
      			alert("Failed");
      		}
      	}
    });
  }
</script>
