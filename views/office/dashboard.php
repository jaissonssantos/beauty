<?php
    if (!isset(
        $_SESSION['eventos_uid'],
        $_SESSION['eventos_nome'],
        $_SESSION['eventos_email'],
        $_SESSION['eventos_empresa']
    )) {
        header('Location: /login');
    }
?>
<!-- Bootstrap Core CSS -->
<link href="assets/template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/template/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
<!-- animation CSS -->
<link href="assets/template/css/animate.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="assets/template/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- Page plugins css -->
<link href="assets/template/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="assets/template/css/style.min.css" rel="stylesheet">
<!-- color CSS -->
<link href="assets/template/css/colors/red.css" id="theme" rel="stylesheet">
<!-- fullcalendar CSS -->
<link href="assets/css/fullcalendar.min.css" rel="stylesheet">
<link href="assets/css/scheduler.min.css" rel="stylesheet">
<link href="assets/css/calendar.css" rel="stylesheet">
<!-- Autocomplete CSS -->
<link href="assets/css/autocomplete.min.css" rel="stylesheet">

<?php require_once 'views/template/header.php'; ?>
<?php require_once 'views/template/left.php'; ?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="#"></a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats"> <i class="ti-user bg-megna"></i>
                                <div class="bodystate">
                                    <h4>370</h4> <span class="text-muted">New Patient</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats"> <i class="ti-shopping-cart bg-info"></i>
                                <div class="bodystate">
                                    <h4>342</h4> <span class="text-muted">OPD Patient</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats"> <i class="ti-wallet bg-success"></i>
                                <div class="bodystate">
                                    <h4>13</h4> <span class="text-muted">Today's Ops.</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats"> <i class="ti-wallet bg-inverse"></i>
                                <div class="bodystate">
                                    <h4>$34650</h4> <span class="text-muted">Hospital Earning</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-sm-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0">New Patient List</h3>
                    <p class="text-muted">this is the sample data here for crm</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>Diseases</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Deshmukh</td>
                                    <td>Prohaska</td>
                                    <td>@Genelia</td>
                                    <td><span class="label label-danger">Fever</span> </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Deshmukh</td>
                                    <td>Gaylord</td>
                                    <td>@Ritesh</td>
                                    <td><span class="label label-info">Cancer</span> </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Sanghani</td>
                                    <td>Gusikowski</td>
                                    <td>@Govinda</td>
                                    <td><span class="label label-warning">Lakva</span> </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Roshan</td>
                                    <td>Rogahn</td>
                                    <td>@Hritik</td>
                                    <td><span class="label label-success">Dental</span> </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Joshi</td>
                                    <td>Hickle</td>
                                    <td>@Maruti</td>
                                    <td><span class="label label-info">Cancer</span> </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Nigam</td>
                                    <td>Eichmann</td>
                                    <td>@Sonu</td>
                                    <td><span class="label label-success">Dental</span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Laboratory Test</h3>
                    <p class="text-muted">this is the sample data here for crm</p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>ECG</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Genelia Deshmukh</td>
                                    <td><span class="peity-line" data-width="120" data-peity="{ &quot;fill&quot;: [&quot;#01c0c8&quot;], &quot;stroke&quot;:[&quot;#01c0c8&quot;]}" data-height="40" style="display: none;">0,-3,-2,-4,-5,-4,-3,-2,-5,-1</span><svg class="peity" height="40" width="120"><polygon fill="#01c0c8" points="0 0.5 0 0.5 13.333333333333334 23.9 26.666666666666668 16.1 40 31.7 53.333333333333336 39.5 66.66666666666667 31.7 80 23.9 93.33333333333334 16.1 106.66666666666667 39.5 120 8.299999999999997 120 0.5"></polygon><polyline fill="none" points="0 0.5 13.333333333333334 23.9 26.666666666666668 16.1 40 31.7 53.333333333333336 39.5 66.66666666666667 31.7 80 23.9 93.33333333333334 16.1 106.66666666666667 39.5 120 8.299999999999997" stroke="#01c0c8" stroke-width="1" stroke-linecap="square"></polyline></svg> </td>
                                    <td><span class="text-danger text-semibold"><i class="fa fa-level-down" aria-hidden="true"></i> 28.76%</span> </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Ajay Devgan</td>
                                    <td><span class="peity-line" data-width="120" data-peity="{ &quot;fill&quot;: [&quot;#01c0c8&quot;], &quot;stroke&quot;:[&quot;#01c0c8&quot;]}" data-height="40" style="display: none;">0,-1,-1,-2,-3,-1,-2,-3,-1,-2</span><svg class="peity" height="40" width="120"><polygon fill="#01c0c8" points="0 0.5 0 0.5 13.333333333333334 13.5 26.666666666666668 13.5 40 26.5 53.333333333333336 39.5 66.66666666666667 13.5 80 26.5 93.33333333333334 39.5 106.66666666666667 13.5 120 26.5 120 0.5"></polygon><polyline fill="none" points="0 0.5 13.333333333333334 13.5 26.666666666666668 13.5 40 26.5 53.333333333333336 39.5 66.66666666666667 13.5 80 26.5 93.33333333333334 39.5 106.66666666666667 13.5 120 26.5" stroke="#01c0c8" stroke-width="1" stroke-linecap="square"></polyline></svg> </td>
                                    <td><span class="text-warning text-semibold"><i class="fa fa-level-down" aria-hidden="true"></i> 8.55%</span> </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Hrithik Roshan</td>
                                    <td><span class="peity-line" data-width="120" data-peity="{ &quot;fill&quot;: [&quot;#01c0c8&quot;], &quot;stroke&quot;:[&quot;#01c0c8&quot;]}" data-height="40" style="display: none;">0,3,6,1,2,4,6,3,2,1</span><svg class="peity" height="40" width="120"><polygon fill="#01c0c8" points="0 39.5 0 39.5 13.333333333333334 20 26.666666666666668 0.5 40 33 53.333333333333336 26.5 66.66666666666667 13.5 80 0.5 93.33333333333334 20 106.66666666666667 26.5 120 33 120 39.5"></polygon><polyline fill="none" points="0 39.5 13.333333333333334 20 26.666666666666668 0.5 40 33 53.333333333333336 26.5 66.66666666666667 13.5 80 0.5 93.33333333333334 20 106.66666666666667 26.5 120 33" stroke="#01c0c8" stroke-width="1" stroke-linecap="square"></polyline></svg> </td>
                                    <td><span class="text-success text-semibold"><i class="fa fa-level-up" aria-hidden="true"></i> 58.56%</span> </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Steve Gection</td>
                                    <td><span class="peity-line" data-width="120" data-peity="{ &quot;fill&quot;: [&quot;#01c0c8&quot;], &quot;stroke&quot;:[&quot;#01c0c8&quot;]}" data-height="40" style="display: none;">0,3,6,4,5,4,7,3,4,2</span><svg class="peity" height="40" width="120"><polygon fill="#01c0c8" points="0 39.5 0 39.5 13.333333333333334 22.78571428571429 26.666666666666668 6.0714285714285765 40 17.214285714285715 53.333333333333336 11.642857142857142 66.66666666666667 17.214285714285715 80 0.5 93.33333333333334 22.78571428571429 106.66666666666667 17.214285714285715 120 28.357142857142858 120 39.5"></polygon><polyline fill="none" points="0 39.5 13.333333333333334 22.78571428571429 26.666666666666668 6.0714285714285765 40 17.214285714285715 53.333333333333336 11.642857142857142 66.66666666666667 17.214285714285715 80 0.5 93.33333333333334 22.78571428571429 106.66666666666667 17.214285714285715 120 28.357142857142858" stroke="#01c0c8" stroke-width="1" stroke-linecap="square"></polyline></svg> </td>
                                    <td><span class="text-info text-semibold"><i class="fa fa-level-up" aria-hidden="true"></i> 35.76%</span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end col -->
</div><!-- /.row -->

<?php require_once 'views/template/rigth.php'; ?>
<?php require_once 'views/template/footer.php'; ?>

<!-- javascripts -->
<script type="text/javascript" src="javascripts/office/dashboard.js"></script>
<script type="text/javascript" src="javascripts/office/global.js"></script>
<script type="text/javascript" src="javascripts/functions.js"></script>

<!-- Clock Plugin JavaScript -->
<script src="assets/template/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>

<!-- Javascript Fullcalendar -->
<script type="text/javascript" src="assets/javascript/moment.min.js"></script>
<script type="text/javascript" src="assets/javascript/moment-timezone-with-data.js"></script>
<script type="text/javascript" src="assets/javascript/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="assets/javascript/fullcalendar/scheduler.min.js"></script>
<script type="text/javascript" src="assets/javascript/fullcalendar/pt-br.js"></script>
