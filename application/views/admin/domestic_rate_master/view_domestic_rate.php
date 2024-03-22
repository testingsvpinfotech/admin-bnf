<?php include(dirname(__FILE__).'/../admin_shared/admin_header.php'); ?>
    <!-- END Head-->
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
    <!-- START: Body-->
    <body id="main-container" class="default">

        
        <!-- END: Main Menu-->
   
    <?php include(dirname(__FILE__).'/../admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
    
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
           

                <!-- START: Card Data-->
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header  justify-content-between align-items-center">                               
                                <h4 class="card-title">Domestic Rate : <span class='cust_name'><?php echo $domestic_rate_list[0]['customer_name']. ' ('.$domestic_rate_list[0]['cid'].')' ?></span></h4> 
                                <input type="hidden" id="current_date" value ="<?php date_default_timezone_set('Asia/Kolkata'); echo date('d-m-Y'); ?>">
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="display table table-bordered">
                                        <thead>
                                            <tr>
												<th>Sr.</th>                                          
                                                <!-- <th>Courier</th> -->
                                                <th>From Zone</th>
                                                <th>To Zone</th>
												<th>From State</th>
                                                <th>From City</th>
												<th>To State</th>
                                                <th>To City</th>
                                                <th>Mode</th>
                                                <th>Shipment Type</th>
                                                <th>TAT</th>
                                                <th>Applicable Date</th>
                                                <th>Exp Date</th>
                                                <th>Weight From</th>
                                                <th>Weight To</th>
                                                <th>Rate</th>
                                                <th>Minimum Weight</th>
                                                <th>Minimum Freight</th>
                                                <th>Rate Type</th>
                                                <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>     
												<th>Action</th>		
                                                <?php } ?>										
                                            </tr>
                                        </thead>
                						<tbody>
                                        <?php 
										if (!empty($domestic_rate_list))
										{
                                            $cnt = 0;
											foreach ($domestic_rate_list as $value) 
											{
												$cnt++;
                                                // date_default_timezone_set('Asia/Kolkata');
                                                // $date = date('d-m-Y');
                                                // if(date("d-m-Y",strtotime($value['applicable_to'])) < date('d-m-Y',strtotime($date)))
                                                // {
                                                //     $html = "style='color:red ! important;'";
                                                // }else{$html = '';}
                                           ?>
											<tr >
												<td><?php echo $cnt; ?></td>
												<!-- <td><?php if($value['c_courier_id']==0){echo "All";}else{echo $value['c_company_name'];} ?></td>  -->
												<td><?php echo $value['from_region_name']; ?></td> 
												<td><?php echo $value['to_region_name']; ?></td>
												<td><?php 
												if(!empty($value['from_state_id']))
												{
													$res1 = $this->basic_operation_m->get_query_row("select * from state where id = '".$value['from_state_id']."'");
													echo $res1->state;
												} ?></td>
												<td><?php if(!empty($value['from_city_id']))
												{
													$res1s = $this->basic_operation_m->get_query_row("select * from city where id = '".$value['from_city_id']."'");
													echo $res1s->city;
												} ?></td> 												
												<td><?php 
												if(!empty($value['state_id']))
												{
													$res1 = $this->basic_operation_m->get_query_row("select * from state where id = '".$value['state_id']."'");
													echo $res1->state;
												} ?></td>
												<td><?php if(!empty($value['city_id']))
												{
													$res1s = $this->basic_operation_m->get_query_row("select * from city where id = '".$value['city_id']."'");
													echo $res1s->city;
												} ?></td> 												
												<td><?php echo $value['mode_name']; ?></td> 
												<td class="text-center"><?php if($value['doc_type'] == '1'){echo 'Non - Doc';}else{echo 'Doc';}; ?></td> 
												<td><?php echo $value['tat']; ?></td> 
												<td><?php echo ($value['applicable_from'] == '0000-00-00')?'':date("d-m-Y",strtotime($value['applicable_from']) ); ?></td> 
												<td><?php echo ($value['applicable_to'] == '0000-00-00')?'':date("d-m-Y",strtotime($value['applicable_to']) ); ?></td> 
												<td><?php echo $value['weight_range_from']; ?></td> 
												<td><?php echo $value['weight_range_to']; ?></td> 
												<td><?php echo $value['rate']; ?></td>
												<td><?php echo $value['minimum_weight']; ?></td>
                                                <td><?php echo $value['minimum_rate']; ?></td>
                                                <td><?php if($value['fixed_perkg']==0){
                                                    echo "Fixed";
                                                }else if($value['fixed_perkg']==1){
                                                    echo "Addtion 250GM";
                                                }else if($value['fixed_perkg']==2){
                                                    echo "Addtion 500GM";
                                                }else if($value['fixed_perkg']==3){
                                                    echo "Addtion 1000GM";
                                                }else if($value['fixed_perkg']==4){
                                                    echo "Per Kg";
                                                }else if($value['fixed_perkg']==5){
                                                    echo "Box Fixed";
                                                }else if($value['fixed_perkg']==6){
                                                    echo "Per Box";
                                                }else if($value['fixed_perkg']==7){
                                                    echo "Fixed Drum";
                                                }else{
                                                    echo "Per Drum";
                                                } ?>
												</td>

                                                <?php if($this->session->userdata("userType") == 26 or $this->session->userdata("userType") == 1){ ?>
                                          <td> 
                                            <a href="admin/view-edit-domestic-rate/<?php echo $value['rate_id'];?>/<?php echo $value['customer_id'];?>"><i class="ion-edit" style="color:var(--primarycolor);"></i></a>
                                             |   <a href="javascript:void(0)" onclick="deleteid(<?php echo $value['rate_id']; ?>)" title="Delete" class="deletedata"><i class="ion-trash-b" style="color:var(--danger)"></i></a>
                                            <!-- |
                                             <a href="admin/delete-domestic-rate/<?php echo $value['rate_id'];?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i></a> -->
                                            <?php } ?>
                                            </td>
                												</tr>
                                        <?php 
											}
										}
										else
										{
                                            ?>
											 <tr>
                                                <th></th>                                          
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>          
                                                <th></th>                                             
                                            </tr>
										<?php	}
											?>
                                        </tbody>
                                       
                                    </table>
                                </div>
                            </div>
                        </div> 

                    </div>                  
                </div>
                <!-- END: Card DATA-->
            </div>
        </main>
        <!-- END: Content-->
        <!-- START: Footer-->
        
        <?php  include(dirname(__FILE__).'/../admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
    <script>
        function deleteid(id){
         // alert('hello')
        var getid = id;
      //  alert(getid);
       var baseurl = '<?php echo base_url();?>'
       	swal({
		  	title: 'Are you sure?',
		  	text: "You won to delete this zone",
		  	icon: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: baseurl+'Admin_domestic_rate_manager/delete_domestic_rate_single',
			    	type: 'POST',
			       	data: 'getid='+getid,
			       	dataType: 'json'
			    })
			    .done(function(response){
			     	swal('Deleted!', response.message, response.status);
			     	 location.reload();
			    })
			    .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			    });
		  	}
 
		})
 
	}

//     $(document).ready(function() {

//         var customer_name = $('.cust_name').html();
//         var date = $('#current_date').val();
//         // alert(customer_name +'\n'+date);
//         $('#example1').DataTable( {
//             dom: 'Bfrtip',
//             buttons: [
//                 {
//                     extend: 'excelHtml5',
//                     title: "Rate_"+customer_name +'_'+date
//                 }
//             ]
//         } );
// } );

$(document).ready(function () {
    // Setup - add a text input to each footer cell
    var customer_name = $('.cust_name').html();
    var date = $('#current_date').val();
    $('#example1 thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#example1 thead');
 
    var table = $('#example1').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: "Rate_"+customer_name +'_'+date
                }
            ],
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    if(colIdx != '0' && colIdx != '18')
                    {
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="form-control" style="width:70px;" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        });
                    }
                });
            
        },
    });
});
    </script>
</html>
