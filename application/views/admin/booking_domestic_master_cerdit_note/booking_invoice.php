<?php $this->load->view('admin/admin_shared/admin_header'); ?>
    <!-- END Head-->
<style>
  	.form-control{
  		color:black!important;
  		border: 1px solid var(--sidebarcolor)!important;
  		height: 27px;
  		font-size: 10px;
  }
  .select2-container--default .select2-selection--single {
    background: lavender!important;
    }
    form .error {
	  color: #ff0000;
	}	
  </style>   
    <!-- START: Body-->
    <body id="main-container" class="default">
        
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
                      <div class="col-12 col-sm-12 mt-3">
                      <div class="card">
                          <div class="card-header justify-content-between align-items-center">                               
                              <h4 class="card-title">View Credit Note Invoice</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">                                           
                          <div class="col-12">
                              <form role="form" action="<?php echo base_url(); ?>admin/list-domestic-booking-credit-note" method="post" autocomplete="off">
                                  <div class="col-12">
                                    <div class="form-row">
											                        <div class="col-2 mb-3">
                                                <label for="username">Company</label>
                                                <select class="form-control"  name="company_id" id="company_id" required>
													                        <!-- <option value="">-Select-</option> -->
                                                  <?php 
                                                  foreach($company_list AS $cl){ ?>
                                                  <option value="<?php echo $cl['id'];?>" <?php echo ($company_id == $cl['id']) ? 'selected=""' : ''; ?>><?php echo $cl['company_name'];?></option>
                                                  <?php } ?>
                                                </select>
											                        </div>
                                              <div class="col-3 mb-3">
                                                <label for="username">Customer Name</label>
                                                <select class="form-control"  name="customer_account_id" required id="customer_account_id">
                                                  <option value="">Select Customer</option>
                                                  <?php
                                                  if (count($customers)) {
                                                      foreach ($customers as $rows) {
                                                          ?>
                                                          <option <?php echo ($customer_account_id == $rows['customer_id']) ? 'selected=""' : ''; ?> value="<?php echo $rows['customer_id']; ?>">
                                                              <?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
                                                          </option>
                                                          <?php
                                                      }
                                                  } else {
                                                      echo "<p>No Data Found</p>";
                                                  }
                                                  ?>
                                              </select>
                                            </div>
                                              <div class="col-3 mb-3">
                                                <label for="username">Invoice No</label>
                                                <select class="form-control"  name="invoice_id" id="branch_id" required>
													                        <option value=""> Select Invoice No</option>   
                                                  <?php if(!empty($_POST['invoice_id'])){
                                                     foreach($invoice_list as $key =>$value){
                                                    ?>   
                                                               <option <?php echo ($_POST['invoice_id'] == $value['id']) ? 'selected=""' : ''; ?> value="<?php echo $value['id']; ?>">
                                                              <?php echo $value['invoice_number']; ?> 
                                                          </option> 
                                                    <?php } }?>                             
                                                </select>
                                              
                                                
											                        </div>
                                            <!-- <div class="col-3 mb-3">
                                                <label for="username">Customer Name</label>
                                                <select class="form-control"  name="customer_account_id" required id="customer_account_id">
                                                  <option value="">Select Customer</option>
                                                  <?php
                                                  if (count($customers)) {
                                                      foreach ($customers as $rows) {
                                                          ?>
                                                          <option <?php echo ($customer_account_id == $rows['customer_id']) ? 'selected=""' : ''; ?> value="<?php echo $rows['customer_id']; ?>">
                                                              <?php echo $rows['customer_name']; ?>--<?php echo $rows['cid']; ?> 
                                                          </option>
                                                          <?php
                                                      }
                                                  } else {
                                                      echo "<p>No Data Found</p>";
                                                  }
                                                  ?>
                                              </select>
                                            </div> -->
                                             
                                            <div class="col-3 mb-3">
                                                 <input type="submit" name="submit" style="margin-top: 26px;" value="Search" class="btn btn-sm btn-primary">
                                                 <?php   if (!empty($_POST)) { ?>
                                                <a href="<?=base_url('admin/list-domestic-booking-credit-note');?>" style="margin-top: 26px;" class="btn btn-sm btn-success">Reset</a>
                                              <?php } ?>    
                                             </div>
                                            
                                      </div>
                                 
                                  </div>
                                <div class="col-12">
                                  <div class="form-row">                                      
                                         <b>Total Results: <?php echo count($getAllInvoices); ?></b>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-row">  
                                   <div class="col-2 mb-3">
                                        <?php   if (!empty($getAllInvoices)) { ?>
                                        <button type="submit" name="submit_print" value="print" style="margin-top: 26px;" class="btn btn-sm btn-primary">Create Invoice</button>
                            <?php } ?>    
                                  </div>
                                  <?php   if (!empty($getAllInvoices)) { ?>
                                  <!-- <label class="col-2 mb-3">Total Credit Note :</label> -->
                                   <div class="col-2 mb-3">

                                       
                                       <!-- <b id ="subtotalvisable">0.00</b> -->
                                       <input type="hidden" name="subtotal" class="form-control" readonly id="subtotal" value="0">
                            
                                  </div>
                                  <?php } ?>   
                                </div>
                                  <div class="form-row">                                      
                                        
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <?php   if (!empty($getAllInvoices)) { ?>
                                    <tr>
                                        <th colspan="8"></th>
                                        <th colspan="2">TOTAL CREDIT NOTE :</th>
                                        <th><span id ="subtotalvisable">0.00</span></th>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>AWB</th>
                                        <th>Receiver Name </th>
                                        <th>Receiver City</th>
                                        <th>Booking date</th>
                                        <th>Amount</th>
                                        <th>CN No</th>
                                        <th>CN Date</th>
                                        <th>CN Amount</th>
                                        <th>Credit Value</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                  
                                  
                                        <?php                                        
                                        if (!empty($getAllInvoices)) {
                                          // echo '<pre>';print_r($getAllInvoices);die;
                                            foreach ($getAllInvoices as $key1=> $value) {
                                                $pod = $value['pod_no'];
                                                $cndetails = $this->db->query("SELECT tbl_credit_note_invoice.*,tbl_credit_note_invoice_details.remarks as remarks ,tbl_credit_note_invoice_details.amount as amount  FROM tbl_credit_note_invoice_details JOIN tbl_credit_note_invoice ON tbl_credit_note_invoice.id = tbl_credit_note_invoice_details.credit_note_id WHERE tbl_credit_note_invoice_details.pod_no = '$pod'")->row();
                                              $key = $key1+1;  ?>
                                                <tr <?php if($value['cn_status']==1){?> style="color: #808B96;" <?php } ?>>
                                       <td> <?= $key;?>
                                     </td>
                                                <td><?php echo $value['pod_no']; ?></td>
                                                <td><?php echo $value['reciever_name']; ?></td>
                                                <td><?php echo $value['reciever_city']; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($value['booking_date'])); ?></td>
                                                <td><?php echo $value['sub_total']; ?></td>
                                                <td><?php if($value['cn_status']==1){ ?> <a href="<?= base_url('admin/invoice-domestic-view-credit-note/'.$cndetails->id); ?>" style="color:#2B9DE6;" target="_blank"><?= $cndetails->credit_note_no; ?></a><?php }?></td>
                                                <td style="width:120px;"><?php if($value['cn_status']==1){ echo date('d-m-Y', strtotime($cndetails->createDtm)); }?></td>
                                                <td><b><?php if($value['cn_status']==1){ echo $cndetails->amount; }?></b></td>
                                                <td style="width:240px; text-align:center;">
                                                
                                                 <?php if($value['cn_status']==0){?>
                                                  <input type="hidden" name="pod_no[]" id="pod_no_<?=$key;?>"value="<?php echo $value['pod_no']; ?>">
                                                <input type="number" id="cnvalue_<?=$key;?>" onchange="creditNote(<?=$key;?>)" min="1" name="cn_value[]">
                                                <span id="show_un_<?=$key;?>" style="color:cornflowerblue;cursor:pointer;margin-left:10px;"></span>
                                                <?php } ?>
                                                <td style="width:240px;">
                                                
                                                 <?php if($value['cn_status']==0){?>
                                                   <textarea name="remarks[]" class="form-control" placeholder="Remarks"></textarea>
                                                <?php }else{echo '<p?>'.$cndetails->remarks.'</p>';} ?>
                                              
                                              </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan ='10'>No Data Found</td></tr>";
                                    }
                                    ?>
                                </tbody>

                            </table>
                                  </div>
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
<script type="text/javascript">
  
  
      function creditNote(int)
      {
        var pod_no = $('#pod_no_'+int).val();
        var cn_value = $('#cnvalue_'+int).val();
        if(cn_value !='')
        {
          
          $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>Admin_domestic_booking_credit_note/Invoice_credit_lr',
                data: 'pod_no=' + pod_no+'&cn_value='+cn_value,
                dataType: "json",
                success: function (data) {
                  
                  if(data =="success")
                  {

                    var subtotal = parseFloat($('#subtotal').val());
                    var lr = parseFloat($('#cnvalue_'+int).val());
                    // alert(lr);
                    var final = subtotal + lr;
                    $('#cnvalue_'+int).prop('readonly', true);
                    $('#subtotal').val(final);
                    var undo_changes = "<span onClick='Reset("+int+")'>Remove</span>";
                    $('#subtotalvisable').html(final);
                    $('#show_un_'+int).html(undo_changes);
                  }
                  else
                  {
                    alertify.alert("Credit Note Alert!",data,
                    function(){
                      alertify.success('Ok');
                    });
                    var cn_value = $('#cnvalue_'+int).val('');
                  }
                
                }
			   });
          // alert(pod_no);
          // alert(cn_value);


        }
       
      }

      function Reset(int)
      {
        if(int!='')
        {
          var subtotal = parseInt($('#subtotal').val());
          var lr = parseInt($('#cnvalue_'+int).val());
          var final = parseInt($('#subtotal').val()) - parseInt($('#cnvalue_'+int).val());
          $('#cnvalue_'+int).prop('readonly', false);
          $('#subtotal').val(final);
          $('#subtotalvisable').html(final);
          $('#cnvalue_'+int).val('');
          $('#show_un_'+int).html('');
        }
      }

  $('.datepicker').datepicker({
      format : 'dd/mm/yyyy' 
    });
  $(".check_all").click(function(){
      if($(this).prop('checked'))
      {
        $(".row_check").prop('checked', true);
      }
      else
      {
        $(".row_check").prop('checked', false);
      }
    });

    $('#customer_account_id').select2();
    $('#company_id').select2();
    $('#branch_id').select2();
  
	$("#customer_account_id").change(function (){
        var company_id =$("#customer_account_id").val();
       //alert(bill_type) ;
         $.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>Admin_domestic_booking_credit_note/getInvoiceNO',
				data: 'customer_id=' + company_id,
				dataType: "json",
				success: function (data) {
					//console.log(d);
					var option;					
					option ='<option value="">-Select Invoice No-</option>';
					for(var i=0;i < data.customer_details.length;i++)
					{
						option += '<option value="' + data.customer_details[i].id + '" >' + data.customer_details[i].invoice_number + '</option>';
					}
					
					$('#branch_id').html(option);
				}
			});
    });
</script>