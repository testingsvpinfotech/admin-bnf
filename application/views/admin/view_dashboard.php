   <?php include('admin_shared/admin_header.php'); ?>
    <!-- END Head-->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);

  var d = '<?php echo $status; ?>';

  console.log(d);
  // alert(d);

  function drawChart() {
    // google.visualization.arrayToDataTable($.parseJSON(chartData));
    var data = google.visualization.arrayToDataTable($.parseJSON(d));

    // var data = google.visualization.arrayToDataTable([
    //   ['Year', 'Sales', 'Expenses', 'Profit'],
    //   ['2014', 1000, 400, 200],
    //   ['2015', 1170, 460, 250],
    //   ['2016', 660, 1120, 300],
    //   ['2017', 0, 540, 350]
    // ]);

    var options = {
        vAxis: {minValue: 0},
        chart: {
            title: 'Monthly Reports <?php echo date('Y')?> ',
            subtitle: 'Status wise reports',
        }
    };

    var chart = new google.charts.Bar(document.getElementById('Monthly_reports'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>


<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart2);

  var d2 = '<?php echo $weekly; ?>';

  console.log(d);
  // alert(d);

  function drawChart2() {
    // google.visualization.arrayToDataTable($.parseJSON(chartData));
    var data2 = google.visualization.arrayToDataTable($.parseJSON(d2));

    // var data = google.visualization.arrayToDataTable([
    //   ['Year', 'Sales', 'Expenses', 'Profit'],
    //   ['2014', 1000, 400, 200],
    //   ['2015', 1170, 460, 250],
    //   ['2016', 660, 1120, 300],
    //   ['2017', 0, 540, 350]
    // ]);

    var options2 = {
        vAxis: {minValue: 0},
        chart: {
            title: 'Weekly Reports ',
            subtitle: 'Status wise reports',
        }
    };

    var chart2 = new google.charts.Bar(document.getElementById('weekly_reports'));

    chart2.draw(data2, google.charts.Bar.convertOptions(options2));
  }
</script>


<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart3);

  var d3 = '<?php echo $complaint; ?>';

  console.log(d3);
  // alert(d);

  function drawChart3() {
    // google.visualization.arrayToDataTable($.parseJSON(chartData));
    var data3 = google.visualization.arrayToDataTable($.parseJSON(d3));

    // var data = google.visualization.arrayToDataTable([
    //   ['Year', 'Sales', 'Expenses', 'Profit'],
    //   ['2014', 1000, 400, 200],
    //   ['2015', 1170, 460, 250],
    //   ['2016', 660, 1120, 300],
    //   ['2017', 0, 540, 350]
    // ]);

    var options3 = {
        vAxis: {minValue: 0},
        chart: {
            title: 'Complaint Reports ',
            subtitle: 'Complaint reports',
        }
    };

    var chart3 = new google.charts.Bar(document.getElementById('complaint_reports'));

    chart3.draw(data3, google.charts.Bar.convertOptions(options3));
  }
</script>

    <!-- START: Body-->
    <body id="main-container" class="default">
       
        <!-- END: Main Menu-->
		<?php include('admin_shared/admin_sidebar.php'); ?>
        <!-- END: Main Menu-->
		
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Breadcrumbs-->
                <div class="row">
                    <div class="col-12  align-self-center">
                        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Dashboard</h4> <p>Welcome to admin panel</p></div>
                            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END: Breadcrumbs-->
<?php ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL); ?>
                <!-- START: Card Data-->
                <div class="row">
                    <div class="col-12 col-lg-12  mt-3">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="row">
                                    <div class="col-3 col-sm-3 mt-3">
                                        <div class="card bg-primary">
                                            <div class="card-body">
                                                <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                                                    <i class="icon-basket icons card-liner-icon mt-2 text-white"></i>
                                                    <div class='card-liner-content'>
                                                        <h2 class="card-liner-title text-white"><?php echo count($allcompany); ?></h2>
                                                        <h6 class="card-liner-subtitle text-white">Total Company</h6>                                       
                                                    </div>                                
                                                </div>
                                                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3 mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                                                    <i class="icon-user icons card-liner-icon mt-2"></i>
                                                    <div class='card-liner-content'>
                                                        <h2 class="card-liner-title"><?php echo count($all_users); ?></h2>
                                                        <h6 class="card-liner-subtitle">Total User</h6> 
                                                    </div>                                
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3  mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                                                    <i class="ion-ios-people icons card-liner-icon mt-2"></i>
                                                    <div class='card-liner-content'>
                                                        <h2 class="card-liner-title"><?php echo count($allcustomer); ?></h2>
                                                        <h6 class="card-liner-subtitle">Total Customer</h6> 
                                                    </div>                                
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3 mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                                                    <i class="ion-folder icons card-liner-icon mt-2"></i>
                                                    <div class='card-liner-content'>
                                                        <h2 class="card-liner-title"><?php echo count($allbranchdata); ?></h2>
                                                        <h6 class="card-liner-subtitle">Total Branch</h6> 
                                                    </div>                                
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 mt-12">
                                <a target='_blank' href='<?php echo base_url('admin_manager/generate_reports'); ?>' class="btn btn-danger">Refresh Data</a>
                            </div>
                            <div class="col-12 col-lg-6 mt-3">

                                <div class="card">                           

                                    <div class="card-content">

                                        <div class="card-body">



                                            <div id="Monthly_reports" class="height-500"></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-12 col-lg-6 mt-3">

                                <div class="card">                           

                                    <div class="card-content">

                                        <div class="card-body">



                                            <div id="weekly_reports" class="height-500"></div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="col-12 col-lg-6 mt-3">

                                <div class="card">                           

                                    <div class="card-content">

                                        <div class="card-body">



                                            <div id="complaint_reports" class="height-500"></div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>   

                    
                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                        <div class="card">                            
                            <div class="card-content">
                                <div class="card-body"> 
                                    <div class="d-flex"> 
                                        <div class="media-body align-self-center ">
                                            <span class="mb-0 h5 font-w-600">Cash Report</span><br>
                                           <!--  <p class="mb-0 font-w-500 tx-s-12">San Francisco, California, USA</p> -->                                                    
                                        </div>                                       
                                    </div>
                                    <div class="d-flex mt-4">
                                        <div class="border-0 outline-badge-info w-50 p-3 rounded text-center"><span class="h5 mb-0">International Monthly Cash</span><br/>                                        
                                            <?php echo '$ '.number_format($inter_current_month_cash->total_cash); ?>
                                        </div>
                                        <div class="border-0 outline-badge-success w-50 p-3 rounded ml-2 text-center"><span class="h5 mb-0"> International Today Cash</span><br/>                                        
                                            <?php echo '$ '.number_format($inter_current_date_cash->total_cash); ?>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-3">
                                        <div class="border-0 outline-badge-dark w-50 p-3 rounded text-center"><span class="h5 mb-0">Domestic Monthly Cash</span><br/>                                        
                                            <?php echo 'Rs '.number_format($domestic_current_month_cash->total_cash); ?>
                                        </div>
                                        <div class="border-0 outline-badge-danger w-50 p-3 rounded ml-2 text-center"><span class="h5 mb-0">Domestic Today Cash</span><br/>                                        
                                            <?php echo 'Rs '.number_format($domestic_current_date_cash->total_cash); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                        <div class="card">                            
                            <div class="card-content">
                                <div class="card-body">  
                                    <div class="height-235">
										<input type="hidden" id="first" value="<?php echo $count_international_pod->int_cnt; ?>">
										<input type="hidden" id="second" value="<?php echo $count_delivered_international_pod->int_cnt; ?>">
										<input type="hidden" id="third" value="<?php echo $count_domestic_pod->int_cnt; ?>">
                                        <input type="hidden" id="fourth" value="<?php echo $count_delivered_domestic_pod->int_cnt; ?>">
										
										<input type="hidden" id="label_first" value="International : <?php echo $count_international_pod->int_cnt; ?>">
										<input type="hidden" id="label_second" value="Delivered International : <?php echo $count_delivered_international_pod->int_cnt; ?>">
										<input type="hidden" id="label_third" value="Domestic : <?php echo $count_domestic_pod->int_cnt; ?>">
                                        <input type="hidden" id="label_fourth" value="Delivered Domestic : <?php echo $count_delivered_domestic_pod->int_cnt; ?>">

                                        <canvas id="chartjs-other-pie"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-header  justify-content-between align-items-center">                               
                                <h6 class="card-title">Latest International Shippment</h6> 
                            </div>
                            <div class="card-body table-responsive p-0">                         

                                <table class="table font-w-600 mb-0">
                                    <thead>
                                        <tr>                                           
                                            <th>DOC No</th>
                                            <th>Sender</th>
                                            <th>Receiver</th>
                                            <th>Country</th>  
                                            <th>ForwordNo</th>
                                            <th>Forworder</th>
                                            <th>Date</th>
                                            <th>Amount</th>                                               

                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php 
                                    if (!empty($latest_international_shippment))
                                    {
                                        $cnt = 1;
                                        foreach ($latest_international_shippment as $value) 
                                        {
                                    ?>
                                        <tr class="zoom">    
                                                 <td>
                                                    <!--<a href="admin/view_edit_international_shipment/<?php echo $value['booking_id'];?>"><?php echo $value['pod_no'];?></a>-->
                                                    <?php echo '<a href="'.base_url().'users/track_shipment?pod_no='.$value['pod_no'].'&submit=1" target="_blank" title="Track" class="ring-point" >'.$value['pod_no'].'</a>';?>
                                                </td>
                                                <td><?php echo $value['sender_name'];?></td>
                                                <td><?php echo $value['contactperson_name'];?></td>
                                                <td><?php echo $value['country_name'];?></td>                                       
                                                <td><?php 
                                                    echo $value['forwording_no'];
                                                    if($value['forworder_name'] == 'delhivery_c2c')
                                                    {
                                                        $serviceType = 'b2c';
                                                        $number = $value['forwording_no'];
                                                    }
                                                    else
                                                    {
                                                        $serviceType = 'b2b';
                                                        $number = $value['booking_id'];
                                                    }
                                                    ?>                                                        
                                                </td>
                                                <td><?php echo ucfirst($value['forworder_name']);?></td>
                                                <td style="width: 11%;"><?php echo date('d-m-Y',strtotime($value['booking_date']));?>
                                                <td class="text-success"><?php echo round($value['grand_total'],2);?></td>

                                            <!-- <td class="text-success">2,51,520 <i class="ion ion-arrow-graph-up-right"></i></td>
                                            <td class="text-danger">3,23,55,479 <i class="ion ion-arrow-graph-down-right"></i></td>
                                            <td class="text-info">23,27,346</td> -->

                                        </tr>  
                                     <?php } } ?>

                                       <!--  <tr  class="zoom">                                           
                                            <td>United States</td>
                                            <td class="text-success">1,40,000 <i class="ion ion-arrow-graph-up-right"></i></td>
                                            <td class="text-danger">3,23,55,479 <i class="ion ion-arrow-graph-down-right"></i></td>
                                            <td class="text-info">23,27,346</td>                                           
                                        </tr> 
                                        <tr  class="zoom">                                           
                                            <td>China</td>
                                            <td class="text-success">2,70,000 <i class="ion ion-arrow-graph-up-right"></i></td>
                                            <td class="text-danger">3,23,55,479 <i class="ion ion-arrow-graph-down-right"></i></td>
                                            <td class="text-info">23,27,346</td>                                         
                                        </tr> 
                                        <tr  class="zoom">                                           
                                            <td>Spain</td>
                                            <td class="text-success">7,60,000 <i class="ion ion-arrow-graph-up-right"></i></td>
                                            <td class="text-danger">3,23,55,479 <i class="ion ion-arrow-graph-down-right"></i></td>
                                            <td class="text-info">23,27,346</td>                                         
                                        </tr> 
                                        <tr  class="zoom">                                           
                                            <td>Italy</td>
                                            <td class="text-success">6,70,000 <i class="ion ion-arrow-graph-up-right"></i></td>
                                            <td class="text-danger">3,23,55,479 <i class="ion ion-arrow-graph-down-right"></i></td>
                                            <td class="text-info">23,27,346</td>                                          
                                        </tr>       -->                                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-header  justify-content-between align-items-center">                               
                                <h6 class="card-title">Latest Domestic Shippment</h6> 
                            </div>
                            <div class="card-body table-responsive p-0">                         

                                <table class="table font-w-600 mb-0">
                                    <thead>
                                        <tr>                                           
                                            <th>DOC No</th>
                                            <th>Sender</th>
                                            <th>Receiver</th>
                                            <th>City</th>  
                                            <th>ForwordNo</th>
                                            <th>Forworder</th>
                                            <th>Date</th>
                                            <th>Amount</th>                                               

                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php 
                                    if (!empty($latest_domestic_shippment))
                                    {
                                        $cnt = 1;
                                        foreach ($latest_domestic_shippment as $value) 
                                        {
                                    ?>
                                        <tr class="zoom">    
                                                 <td>
                                                    <?php echo '<a href="'.base_url().'users/track_shipment?pod_no='.$value['pod_no'].'&submit=1" target="_blank" title="Track" class="ring-point" >'.$value['pod_no'].'</a>';?>
                                                </td>
                                                <td><?php echo $value['sender_name'];?></td>
                                                <td><?php echo $value['reciever_name'];?></td>
                                                <td><?php echo $value['city'];?></td>                                       
                                                <td><?php 
                                                    echo $value['forwording_no'];
                                                    if($value['forworder_name'] == 'delhivery_c2c')
                                                    {
                                                        $serviceType = 'b2c';
                                                        $number = $value['forwording_no'];
                                                    }
                                                    else
                                                    {
                                                        $serviceType = 'b2b';
                                                        $number = $value['booking_id'];
                                                    }
                                                    ?>                                                        
                                                </td>
                                                <td><?php echo ucfirst($value['forworder_name']);?></td>
                                                <td style="width: 11%;"><?php echo date('d-m-Y',strtotime($value['booking_date']));?>
                                                <td class="text-success"><?php echo round($value['grand_total'],2);?></td>

                                            <!-- <td class="text-success">2,51,520 <i class="ion ion-arrow-graph-up-right"></i></td>
                                            <td class="text-danger">3,23,55,479 <i class="ion ion-arrow-graph-down-right"></i></td>
                                            <td class="text-info">23,27,346</td> -->

                                        </tr>  
                                     <?php } } ?>                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12  col-md-6 col-lg-4 mt-3">
                        <div class="card overflow-hidden">
                            <div class="card-header d-flex justify-content-between align-items-center">                               
                                <h6 class="card-title">Todo List</h6>

                            </div>
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <ul class="tasks">
                                                <li class="outline-badge-success border-0 d-flex py-3 px-2 zoom">
                                                    <label class="chkbox d-flex">
                                                        <input type="checkbox" checked="checked">                                                      
                                                        <img src="assets/admin_assets/dist/images/author.jpg" alt="author" width="30" height="30" class="rounded-circle"/>
                                                        <img src="assets/admin_assets/dist/images/author2.jpg" alt="author" width="30"  height="30" class="rounded-circle"/>
                                                        <span class="mb-0 ml-2 my-auto font-w-600">Aenean ligula porttitor consequat vitae eleifend enim.</span>

                                                        <span class="checkmark mt-1"></span>
                                                    </label>
                                                    <div class="ml-auto d-flex my-auto"><a href="#"><i class="ion ion-edit"></i></a> <a href="#" class="ml-2"><i class="ion ion-trash-a"></i></a></div>
                                                </li>
                                                <li class="outline-badge-warning border-0 d-flex py-3 px-2 zoom">
                                                    <label class="chkbox d-flex">
                                                        <input type="checkbox">                                                      
                                                        <img src="assets/admin_assets/dist/images/author2.jpg" alt="author" width="30" height="30" class="rounded-circle "/>
                                                        <img src="assets/admin_assets/dist/images/author3.jpg" alt="author" width="30" height="30" class="rounded-circle"/>
                                                        <span class="mb-0 ml-2 my-auto font-w-600">In enim justo, rhoncus ut imperdiet a, venenatis vitae justo.</span>

                                                        <span class="checkmark mt-1"></span>
                                                    </label>
                                                    <div class="ml-auto d-flex my-auto"><a href="#"><i class="ion ion-edit"></i></a> <a href="#" class="ml-2"><i class="ion ion-trash-a"></i></a></div>
                                                </li>

                                                <li class="outline-badge-info border-0 d-flex py-3 px-2 zoom">
                                                    <label class="chkbox d-flex">
                                                        <input type="checkbox">                                                      
                                                        <img src="assets/admin_assets/dist/images/author3.jpg" alt="author" width="30" height="30" class="rounded-circle "/>
                                                        <img src="assets/admin_assets/dist/images/author7.jpg" alt="author" width="30" height="30" class="rounded-circle"/>
                                                        <span class="mb-0 ml-2 my-auto font-w-600">Cras dapibus vivamus elementum semper nisi.</span>

                                                        <span class="checkmark mt-1"></span>
                                                    </label>
                                                    <div class="ml-auto d-flex my-auto"><a href="#"><i class="ion ion-edit"></i></a> <a href="#" class="ml-2"><i class="ion ion-trash-a"></i></a></div>
                                                </li>
                                                <li class="outline-badge-secondary border-0 d-flex py-3 px-2 zoom">
                                                    <label class="chkbox d-flex">
                                                        <input type="checkbox">                                                      
                                                        <img src="assets/admin_assets/dist/images/author6.jpg" alt="author" width="30" height="30" class="rounded-circle "/>
                                                        <img src="assets/admin_assets/dist/images/author8.jpg" alt="author" width="30" height="30" class="rounded-circle"/>
                                                        <span class="mb-0 ml-2 my-auto font-w-600">Donec quam felis ultricies nec, pellentesque eu pretium quis.</span>

                                                        <span class="checkmark mt-1"></span>
                                                    </label>
                                                    <div class="ml-auto d-flex my-auto"><a href="#"><i class="ion ion-edit"></i></a> <a href="#" class="ml-2"><i class="ion ion-trash-a"></i></a></div>
                                                </li>
                                                <li class="outline-badge-primary border-0 d-flex py-3 px-2 zoom">
                                                    <label class="chkbox d-flex">
                                                        <input type="checkbox">                                                      
                                                        <img src="assets/admin_assets/dist/images/author.jpg" alt="author" width="30" height="30" class="rounded-circle "/>
                                                        <img src="assets/admin_assets/dist/images/author8.jpg" alt="author" width="30" height="30" class="rounded-circle"/>
                                                        <span class="mb-0 ml-2 my-auto font-w-600">Donec quam felis ultricies nec, pellentesque eu pretium quis.</span>

                                                        <span class="checkmark mt-1"></span>
                                                    </label>
                                                    <div class="ml-auto d-flex my-auto"><a href="#"><i class="ion ion-edit"></i></a> <a href="#" class="ml-2"><i class="ion ion-trash-a"></i></a></div>
                                                </li>
                                            </ul>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                   

                </div>
                <!-- END: Card DATA-->                 
            </div>
        </main>
        <!-- END: Content-->
        <!-- START: Footer-->
        <?php include('admin_shared/admin_footer.php'); ?>
        <!-- START: Footer-->
    </body>
    <!-- END: Body-->
</html>
