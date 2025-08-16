<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if (isset($_COOKIE['PHPSESSID'])){
	include_once 'php/dbh.php';


?>
<?php include 'include/head.php';?>
<body>
    <?php include 'include/preloader.php';?>
    <div id="main-wrapper">
        <?php include 'include/topbar.php';?>
        <?php include 'include/sidebar.php';?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="mdi mdi-emoticon font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Total Systems</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">5</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="mdi mdi-image font-20  text-muted"></i>
                                            <p class="font-16 m-b-5">Active Rules</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">2</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="mdi mdi-currency-eur font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Records Archived</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">58k</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 65%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="mdi mdi-poll font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Errored Records</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">1,236</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 70%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<!-- row -->
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-2 col-md-6">
                        <div class="card bg-orange">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-r-15">
                                    <i class="cc EOS text-white display-6 m-r-15" title="BTC"></i>
                                    <div class="m-t-10">
                                        <h5 class="text-white font-medium">SCHEDULER</h5>
                                        <h6 class="text-white">MicroServices</h6>
                                    </div>
                                    <div class="ml-auto m-t-15">
                                        <div class="crypto"></div>
                                    </div>
                                </div>
                                <div class="row text-center text-white m-t-30">
                                    <div class="col-4">
                                        <span class="font-10">Status</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> UP</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">CPU</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i>9.8</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">MEM</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> 32</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <div class="col-lg-2 col-md-6">
                        <div class="card bg-success">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-r-15">
                                    <i class="cc EOS text-white display-6 m-r-15" title="BTC"></i>
                                    <div class="m-t-10">
                                        <h5 class="text-white font-medium">PROCESSOR</h5>
                                        <h6 class="text-white">MicroServices</h6>
                                    </div>
                                    <div class="ml-auto m-t-15">
                                        <div class="crypto"></div>
                                    </div>
                                </div>
                                <div class="row text-center text-white m-t-30">
                                    <div class="col-4">
                                        <span class="font-10">Status</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> UP</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">CPU</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i>36.7</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">MEM</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> 65</p>
                                    </div>
                                </div>

                            </div> 
                        </div>
                    </div>
                    <!-- col -->
                    <div class="col-lg-2 col-md-6">
                        <div class="card bg-dark">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-r-15">
                                    <i class="cc EOS text-white display-6 m-r-15" title="BTC"></i>
                                    <div class="m-t-10">
                                        <h5 class="text-white font-medium">MESSENGER</h5>
                                        <h6 class="text-white">MicroServices</h6>
                                    </div>
                                    <div class="ml-auto m-t-15">
                                        <div class="crypto"></div>
                                    </div>
                                </div>
                                <div class="row text-center text-white m-t-30">
                                    <div class="col-4">
                                        <span class="font-10">Status</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> UP</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">CPU</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i>22.0</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">MEM</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> 9.2</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>                    
                    <!-- col -->
                    <div class="col-lg-2 col-md-6">
                        <div class="card bg-info">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-r-15">
                                    <i class="cc EOS text-white display-6 m-r-15" title="BTC"></i>
                                    <div class="m-t-10">
                                        <h5 class="text-white font-medium">WEBUI</h5>
                                        <h6 class="text-white">MicroServices</h6>
                                    </div>
                                    <div class="ml-auto m-t-15">
                                        <div class="crypto"></div>
                                    </div>
                                </div>
                                <div class="row text-center text-white m-t-30">
                                    <div class="col-4">
                                        <span class="font-10">Status</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> UP</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">CPU</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i> 33.5</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">MEM</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> 6.2</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> 
                    <!-- col -->
                    <div class="col-lg-2 col-md-6">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-r-15">
                                    <i class="cc EOS text-white display-6 m-r-15" title="BTC"></i>
                                    <div class="m-t-10">
                                        <h5 class="text-white font-medium">REMOVER</h5>
                                        <h6 class="text-white">MicroServices</h6>
                                    </div>
                                    <div class="ml-auto m-t-15">
                                        <div class="crypto"></div>
                                    </div>
                                </div>
                                <div class="row text-center text-white m-t-30">
                                    <div class="col-4">
                                        <span class="font-10">Status</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i> DN</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">CPU</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i>0.0</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">MEM</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i>0.0</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> 
                    <!-- col -->
                    <div class="col-lg-2 col-md-6">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center m-r-15">
                                    <i class="cc EOS text-white display-6 m-r-15" title="BTC"></i>
                                    <div class="m-t-10">
                                        <h5 class="text-white font-medium">RETRIEVER</h5>
                                        <h6 class="text-white">MicroServices</h6>
                                    </div>
                                    <div class="ml-auto m-t-15">
                                        <div class="crypto"></div>
                                    </div>
                                </div>
                                <div class="row text-center text-white m-t-30">
                                    <div class="col-4">
                                        <span class="font-10">Status</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> UP</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">CPU</span>
                                        <p class="font-small"><i class="fa fa-arrow-down"></i> 8.1</p>
                                    </div>
                                    <div class="col-4">
                                        <span class="font-10">MEM</span>
                                        <p class="font-small"><i class="fa fa-arrow-up"></i> 9.3</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>         
                </div>
                <!-- End Row -->        
        
                <!-- ============================================================== -->
                <!-- Email campaign chart -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Ravenue - page-view-bounce rate -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                  <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h4 class="card-title mb-0">Rule Id : 15</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row align-items-center">
                                    <div class="col-xs-12 col-md-12">
                                        <h3 class="m-b-0 font-light">Service Request - Closed SR - Case - FS</h3>
                                        <span class="font-14 text-muted">All Service Requests of type `Case` and are in `Closed` Status</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">NAME</th>
                                            <th class="border-top-0">STATUS</th>
                                            <th class="border-top-0">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-success label-rounded">QUALIFIED</span> </td>
                                            <td><span class="font-medium">44,957</span></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-purple label-rounded">PROCESSED</span></td>
                                            <td><span class="font-medium">9,432</span></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-success label-rounded">READY FOR DELETE</span></td>
                                            <td><span class="font-medium">33,187</span></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-red label-rounded">ERROR</span></td>
                                            <td><span class="font-medium">843</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h4 class="card-title mb-0">Rule Id : 16</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row align-items-center">
                                    <div class="col-xs-12 col-md-12">
                                        <h3 class="m-b-0 font-light">Service Request - Closed SR - Incident - Cloud</h3>
                                        <span class="font-14 text-muted">All Closed Service Request of type `Incident`</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">NAME</th>
                                            <th class="border-top-0">STATUS</th>
                                            <th class="border-top-0">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-success label-rounded">QUALIFIED</span> </td>
                                            <td><span class="font-medium">23,198</span></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-purple label-rounded">PROCESSED</span></td>
                                            <td><span class="font-medium">12,734</span></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-success label-rounded">READY FOR DELETE</span></td>
                                            <td><span class="font-medium">10,873</span></td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="txt-oflo">Service Request</td>
                                            <td><span class="label label-red label-rounded">ERROR</span></td>
                                            <td><span class="font-medium">47</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                                    
            </div>
            <?php include 'include/footer.php';?>
        </div>
    </div>
    <?php include 'include/customiser.php';?>
    
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.js"></script>
    <script src="../../dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="../../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="../../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../../assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../../assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../../dist/js/pages/dashboards/dashboard1.js"></script>
</body>
<?php 
}else{
    header('Location: index.php');
	exit;
}
?>
</html>
