<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if (isset($_COOKIE['username'])){
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
                                    <li class="breadcrumb-item active" aria-current="page">Connections - Destination</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Connections - Destination</h4>
                                <h6 class="card-subtitle">Here you can configure the Destination connection details.The connections specified here will show up while creating Rules.You can refer full documentation from here <a href="https://datatables.net/">Connection Administration >> Destination Connections</a></h6>
                                <h2 class="mb-4">Connection Configuration</h2>
                                    
                                      <!-- Destination Connection Type -->

                                      <form id="destinationForm">
                                        <div class="mb-3">
                                          <label for="destinationType" class="form-label">Select Destination Type</label>
                                          <select class="form-select" id="destinationType" required>
                                            <option value="">-- Select --</option>
                                            <option value="db">Database</option>
                                            <option value="fs">File System</option>
                                            <option value="cloud">Cloud Storage (OCI)</option>
                                          </select>
                                        </div>
                                    
                                        <!-- DB Connection Fields -->
                                        <div id="dbFields" class="d-none">
                                          <div class="card card-body">
                                            <h5 class="mb-3">Database Connection</h5>
                                            <div class="mb-3">
                                              <label class="form-label">DB Host</label>
                                              <input type="text" class="form-control" id="dbHost" placeholder="e.g., localhost">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">DB Port</label>
                                              <input type="number" class="form-control" id="dbPort" placeholder="e.g., 1521">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">DB Name / SID</label>
                                              <input type="text" class="form-control" id="dbName" placeholder="e.g., ORCL">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">DB Username</label>
                                              <input type="text" class="form-control" id="dbUser" placeholder="e.g., admin">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">DB Password</label>
                                              <input type="password" class="form-control" id="dbPassword">
                                            </div>
                                          </div>
                                        </div>
                                    
                                        <!-- File System Fields -->
                                        <div id="fsFields" class="d-none">
                                          <div class="card card-body">
                                            <h5 class="mb-3">File System Configuration</h5>
                                            <div class="mb-3">
                                              <label class="form-label">Archive Path</label>
                                              <input type="text" class="form-control" id="fsPath" placeholder="/mnt/archive/data">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">Backup Frequency</label>
                                              <select class="form-select" id="fsBackupFrequency">
                                                <option>Daily</option>
                                                <option>Weekly</option>
                                                <option>Monthly</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                    
                                        <!-- Cloud Storage (OCI) Fields -->
                                        <div id="cloudFields" class="d-none">
                                          <div class="card card-body">
                                            <h5 class="mb-3">OCI Object Storage</h5>
                                            <div class="mb-3">
                                              <label class="form-label">REST Endpoint URL</label>
                                              <input type="url" class="form-control" id="ociEndpoint" placeholder="https://objectstorage.<region>.oraclecloud.com/n/namespace-string/b/bucket-name/o/">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">Auth Token</label>
                                              <input type="text" class="form-control" id="ociAuthToken" placeholder="Paste OCI auth token">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">Bucket Name</label>
                                              <input type="text" class="form-control" id="ociBucket" placeholder="e.g., archive-bucket">
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">Namespace</label>
                                              <input type="text" class="form-control" id="ociNamespace" placeholder="e.g., your-namespace-id">
                                            </div>
                                          </div>
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary mt-4">Save Connection</button>
                                      </form>
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
    <!-- start - This is for Data Tables -->
    <script src="../../assets/extra-libs/DataTables/datatables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="../../dist/js/pages/datatable/datatable-advanced.init.js"></script>    
</body>
<script>
  $(document).ready(function () {
    $('#destinationType').on('change', function () {
      const value = $(this).val();
      $('#dbFields, #fsFields, #cloudFields').addClass('d-none');

      if (value === 'db') $('#dbFields').removeClass('d-none');
      if (value === 'fs') $('#fsFields').removeClass('d-none');
      if (value === 'cloud') $('#cloudFields').removeClass('d-none');
    });

    $('#destinationForm').on('submit', function (e) {
      e.preventDefault();
      alert("Destination connection saved (this is a mock)");
      // Here, you would gather form data and send via AJAX to your backend
    });
  });
</script>
<?php 
}else{
    header('Location: index.php');
}
?>
</html>
