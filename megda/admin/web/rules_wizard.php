<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if (isset($_COOKIE['PHPSESSID'])){
	include_once 'php/dbh.php';


?>
<?php include 'include/head.php';?>
<style>
    .expression-preview {
      min-height: 100px;
      background: #f8f9fa;
      padding: 10px;
      border: 1px solid #ccc;
      margin-top: 10px;
      font-family: monospace;
    }
</style> 
    <!-- This page CSS -->
    <link href="../../assets/libs/jquery-steps/jquery.steps.css" rel="stylesheet">
    <link href="../../assets/libs/jquery-steps/steps.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../dist/css/style.min.css" rel="stylesheet">
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
                                    <li class="breadcrumb-item active" aria-current="page">Rules - New</li>
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
                                <h4 class="card-title">New Rule Creation Wizard</h4>
                                <h6 class="card-subtitle">Here you will be able enter the Rule details, Criteria, Archive details, Schedule etc. You can refer full documentation from here <a href="https://datatables.net/">Data Archive Rules >> New Rule Creation</a></h6>
                                <div class="mt-5 mb-5">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body wizard-content">
                                                <h4 class="card-title">New Rule</h4>
                                                <h6 class="card-subtitle"></h6>
                                                <form class="tab-wizard wizard-circle" style="background: gainsboro;">
                                                    <!-- Step 1 -->
                                                    <h6>Rule Information</h6>
                                                    <section>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="rule_name">Rule Name: <span class="danger">*</span></label>
                                                                    <input type="text" class="form-control" id="rule_name"> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <?php
                                                                        $sql_system = "SELECT system_name FROM `system` WHERE status='active';";
                                                                        $results_system = mysqli_query($conn, $sql_system);
                                                                        $system=array();
                                                                        if ($results_system->num_rows > 0) {
                                                                            while($row_system = $results_system->fetch_assoc()) {
                                                                                array_push($system,$row_system["system_name"]);
                                                                            }
                                                                        } else {
                                                                            $system=array('');
                                                                        }
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <label for="system" >Source System: <span class="danger">*</span></label>
                                                                        <select class="custom-select form-select" id="system" onchange = "FetchEntities()">
                                                                            <option value='%%'>Select System</option>
                                                                            <?php foreach($system as $val) {?>
                                                                            <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                                                            <?php } ?>
                                                                        </select>  
                                                                        <script>
                                                                            function FetchEntities() {
                                                                                var system = $('#system').val().trim();
                                                                            	//console.log(system);
                                                                                $('#data_entity').html("");
                                                                                if(system !='') {
                                                                                    $.ajax({
                                                                                        url: 'php/ajax_rules.php',
                                                                                        type: 'post',
                                                                                        data: {request: "get_entities_for_system", system: system},
                                                                                        dataType: 'html',
                                                                                        success: function(response){  
                                                                                            console.log(response);
                                                                                            $('#data_entity').append(response);
                                                                                        }
                                                                                    });
                                                                                }else{
                                                                                    alert('Please Select Entity.');
                                                                                }                                                    
                                                                            }
                                                                        </script>                                                                        
                                                                    </div>                                                                       
                                                                </div>    
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="data_entity">Data Entity: <span class="danger">*</span></label>
                                                                    <select class="custom-select form-select" id="data_entity" required onchange = "FetchQueryFields()">
                                                                        <option value="%%">Select Entities</option>
                                                                    </select>
                                                                    <script>
                                                                        function FetchQueryFields() {
                                                                            var entity = $('#data_entity').val().trim();
                                                                            $('#fieldSelect').html("");
                                                                            if(entity !='') {
                                                                                $.ajax({
                                                                                    url: 'php/ajax_rules.php',
                                                                                    type: 'post',
                                                                                    data: {request: "get_fields_for_entities", entity: entity},
                                                                                    dataType: 'html',
                                                                                    success: function(response){  
                                                                                        console.log(response);
                                                                                        $('#fieldSelect').append(response);
                                                                                    }
                                                                                });
                                                                            }else{
                                                                                alert('Please Select Room Type First.');
                                                                            }                                                    
                                                                        }
                                                                    </script>                                                                     
                                                                </div>    
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="rule_desc">Rule Description :</label>
                                                                    <textarea class="form-control" id="rule_desc" rows="2" maxlength="500"></textarea>
                                                                </div>  
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="rule_criteria">Rule Criteria: <span class="danger">*</span></label>
                                                                    <textarea class="form-control" id="rule_criteria" rows="2" maxlength="500" readonly></textarea>
                                                                </div>    
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="rule_criteria_image">Click to Build</label>
                                                                    <img src="../../assets/images/custom/expression.png" alt="user" width="40" data-toggle="modal" data-target="#expressionBuilderModal">

                                                                </div>    
                                                            </div>                                                            
                                                        </div>
                                                        <!--div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="rule_status">Rule Status :</label>
                                                                    <select class="custom-select form-control" id="rule_status" name="rule_status">
                                                                        <option value="">Select Status</option>
                                                                        <option value="creating">CREATING</option>
                                                                        <option value="active">ACTIVE</option>
                                                                        <option value="inactive">INACTIVE</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div-->
                                                    </section>
                                                    <!-- Step 2 -->
                                                    <h6>Archive Details</h6>
                                                    <section>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="archive_type">Archive Type: <span class="danger">*</span></label>
                                                                    <select class="custom-select form-control" id="archive_type" name="archive_type">
                                                                        <option value="">Select Archive Type</option>
                                                                        <option value="archive_with_delete">Archive with Delete</option>
                                                                        <option value="archive_without_delete">Archive without Delete</option>
                                                                        <option value="direct_delete">Direct Delete</option>
                                                                    </select>                                                                     
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="archive_attachment">Archive Attachment? : <span class="danger">*</span></label>
                                                                    <select class="custom-select form-control" id="archive_attachment" name="archive_attachment">
                                                                        <option value="">Select Attachment Type</option>
                                                                        <option value="yes">YES</option>
                                                                        <option value="no">NO</option>
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="reterival_required">Retrieval Required? : <span class="danger">*</span></label>
                                                                    <select class="custom-select form-control" id="reterival_required" name="reterival_required" onchange = "ShowHideSummary()">
                                                                        <option value="">Select Retrieval Type</option>
                                                                        <option value="yes">YES</option>
                                                                        <option value="no">NO</option>
                                                                    </select> 
                                                                    <script>
                                                                        function ShowHideSummary() {
                                                                            var retrieval_required = $('#reterival_required').val().trim();
                                                                            if(retrieval_required =='yes') {
                                                                                $("#summary_req_group").show();    
                                                                            }else{
                                                                                $("#summary_req_group").hide();
                                                                                $("#summary_type_group").hide();
                                                                            }
                                                                        }
                                                                    </script>                                                                      
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group" id="summary_req_group" style="display:none;">
                                                                    <label for="summary_required">Summary Required? :</label>
                                                                    <select class="custom-select form-control" id="summary_required" name="summary_required" onchange = "ShowHideSummaryType()">
                                                                        <option value="">Select if Summary Required</option>
                                                                        <option value="yes">YES</option>
                                                                        <option value="no">NO</option>
                                                                    </select>
                                                                    <script>
                                                                        function ShowHideSummaryType() {
                                                                            var summary_required = $('#summary_required').val().trim();
                                                                            if(summary_required =='yes') {
                                                                                $("#summary_type_group").show();    
                                                                            }else{
                                                                                $("#summary_type_group").hide();
                                                                            }
                                                                        }
                                                                    </script>                                                                      
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group" id="summary_type_group" style="display:none;">
                                                                    <label for="summary_type">Summary Type? :</label>
                                                                    <select class="custom-select form-control" id="summary_type" name="summary_type">
                                                                        <option value="">Select Summary Type</option>
                                                                        <option value="field_summary">Field Based Summary</option>
                                                                        <option value="ai_summary">AI Based Summary</option>
                                                                    </select> 
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                         
                                                    </section>
                                                    <!-- Step 3 -->
                                                    <h6>Schedule Details</h6>
                                                    <section>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                  <label class="form-label">Recurrence Pattern : <span class="danger">*</span></label>
                                                                  <select class="custom-select form-select" id="recurrencePattern" name="pattern">
                                                                    <option value="daily">Daily</option>
                                                                    <option value="weekly">Weekly</option>
                                                                    <option value="monthly">Monthly</option>
                                                                    <option value="yearly">Yearly</option>
                                                                  </select>
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                  <label class="form-label">Repeat every</label>
                                                                  <div class="input-group">
                                                                    <input type="number" class="form-control" id="interval" value="1" min="1">
                                                                    <span class="input-group-text" id="intervalLabel">day(s)</span>
                                                                  </div>
                                                                </div>
                                                            
                                                                <div id="weeklySection" class="mb-3 d-none">
                                                                  <label class="form-label">Repeat on</label><br>
                                                                  <div class="btn-group" role="group">
                                                                    <input type="checkbox" class="btn-check" id="mon" value="Mon">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="mon">Mon</label>
                                                                    <input type="checkbox" class="btn-check" id="tue" value="Tue">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="tue">Tue</label>
                                                                    <input type="checkbox" class="btn-check" id="wed" value="Wed">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="wed">Wed</label>
                                                                    <input type="checkbox" class="btn-check" id="thu" value="Thu">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="thu">Thu</label>
                                                                    <input type="checkbox" class="btn-check" id="fri" value="Fri">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="fri">Fri</label>
                                                                    <input type="checkbox" class="btn-check" id="sat" value="Sat">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="sat">Sat</label>
                                                                    <input type="checkbox" class="btn-check" id="sun" value="Sun">
                                                                    <label class="btn btn-outline-primary" style="margin-left: -11pt;" for="sun">Sun</label>
                                                                  </div>
                                                                </div>
                                                            
                                                                <div id="monthlySection" class="mb-3 d-none">
                                                                  <label class="form-label">Repeat on</label>
                                                                  <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="monthlyMode" id="monthDayOption" value="day" checked>
                                                                    <label class="form-check-label" for="monthDayOption">Day
                                                                      <select id="monthDay" class="form-select d-inline w-auto">
                                                                        <!-- Days populated in script -->
                                                                      </select>
                                                                      of the month
                                                                    </label>
                                                                  </div>
                                                                  <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="monthlyMode" id="weekdayOption" value="weekday">
                                                                    <label class="form-check-label" for="weekdayOption">
                                                                      The
                                                                      <select id="weekdayOrdinal" class="custom-select form-select d-inline w-auto">
                                                                        <option value="1">First</option>
                                                                        <option value="2">Second</option>
                                                                        <option value="3">Third</option>
                                                                        <option value="4">Fourth</option>
                                                                        <option value="-1">Last</option>
                                                                      </select>
                                                                      <select id="weekdaySelect" class="custom-select form-select d-inline w-auto">
                                                                        <option value="MO">Monday</option>
                                                                        <option value="TU">Tuesday</option>
                                                                        <option value="WE">Wednesday</option>
                                                                        <option value="TH">Thursday</option>
                                                                        <option value="FR">Friday</option>
                                                                        <option value="SA">Saturday</option>
                                                                        <option value="SU">Sunday</option>
                                                                      </select>
                                                                    </label>
                                                                  </div>
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                  <label class="form-label">End</label>
                                                                  <div>
                                                                    <div class="form-check">
                                                                      <input class="form-check-input" type="radio" name="endOption" id="endNever" value="never" checked>
                                                                      <label class="form-check-label" for="endNever">Never</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                      <input class="form-check-input" type="radio" name="endOption" id="endAfter" value="after">
                                                                      <label class="form-check-label" for="endAfter">After <input type="number" id="occurrences" class="form-control d-inline w-auto ms-2" style="display:none;" min="1"></label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                      <input class="form-check-input" type="radio" name="endOption" id="endBy" value="by">
                                                                      <label class="form-check-label" for="endBy">End by <input type="date" id="endDate" class="form-control d-inline w-auto ms-2" style="display:none;"></label>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                            
                                                                <button type="button" class="btn btn-primary mt-2" id="btn_create_reccurences">Show Recurrence</button>                                                          
                                                            </div>
                                                            <div class="col-md-6">
                                                                <hr class="mt-4 mb-3">
                                                                <div class="form-group row">
                                                                    <label for="execution_start_time" class="col-6 col-form-label">Execution Start Time : <span class="danger">*</span></label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" type="time" value="20:00:00" id="execution_start_time">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="execution_end_time" class="col-6 col-form-label">Execution End Time : <span class="danger">*</span></label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" type="time" value="23:59:00" id="execution_end_time">
                                                                    </div>
                                                                </div> 
                                                                <div class="mt-4">
                                                                    <h5>Generated RRULE:</h5>
                                                                    <pre id="rruleOutput" class="bg-white border p-3"></pre>
                                                                </div>                                                                
                                                            </div>                                                            
                                                        </div>
                                                    </section>
                                                    <!-- Step 4 -->
                                                    <h6>Destination Details</h6>
                                                    <section>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="archive_destination" class="form-label">Archive Destination : <span class="danger">*</span></label>
                                                                    <select class="custom-select form-control" id="archive_destination" name="archive_destination">
                                                                        <option value="">Select Archive Destination</option>
                                                                        <option value="database">DATABASE</option>
                                                                        <option value="filesystem">LOCAL FILE SYSTEM</option>
                                                                        <option value="cloud">CLOUD STORAGE</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="retention_period" class="form-label">Retention Period : <span class="danger">*</span></label>
                                                                    <input type="number" class="form-control" id="retention_period" min="1" value="1"> Year/s
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>


                
                <!-- Modal -->
                <div class="modal fade" id="expressionBuilderModal" tabindex="-1" aria-labelledby="expressionBuilderLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Expression Builder</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-4">
                            <label for="fieldSelect" class="form-label">Field</label>
                            <select class="custom-select form-select" id="fieldSelect">
                              <option value="%%">Select System and Entity</option>

                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="operatorSelect" class="form-label">Operator</label>
                            <select class="custom-select form-select" id="operatorSelect">
                              <option value="=">EQUAL TO (=)</option>
                              <option value="!=">NOT EQUAL TO (!=)</option>
                              <option value=">">GREATER THAN (>)</option>
                              <option value="<">LESS THAN (<)</option>
                              <option value=">=">GREATER OR EQUAL TO (>=)</option>
                              <option value="<=">LESS OR EQUAL TO (<=)</option>
                              <option value="IN">IN</option>
                              <option value="NOT IN">NOT IN</option>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="valueInput" class="form-label">Value</label>
                            <input type="text" id="valueInput" class="form-control" placeholder="Enter value or comma-separated">
                          </div>
                        </div>
                
                        <div class="mt-3 d-flex gap-2">
                          <button class="btn btn-primary mr-2" id="addExpression">Add Expression</button>
                          <button class="btn btn-secondary mr-2" data-logic="AND">AND</button>
                          <button class="btn btn-secondary mr-2" data-logic="OR">OR</button>
                          <button class="btn btn-secondary mr-2" data-logic="NOT">NOT</button>
                          <button class="btn btn-danger mr-2" id="clearExpression">Clear</button>
                        </div>
                
                        <div class="expression-preview mt-3" id="expressionPreview"></div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="saveExpression" data-bs-dismiss="modal">Save</button>
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
    
    <script src="../../dist/js/custom.js"></script>
    <script src="../../assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="../../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
    <script>
    //Wizard
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Create Rule"
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (currentIndex === 0 && ($("#rule_name").val() == '' || $("#system").val() == '' || $("#data_entity").val() == '' || $("#rule_criteria").val() == '')) {
                alert('Please enter all required fields')
                return false;
            }else if(currentIndex === 1 && ($("#archive_type").val() == '' || $("#archive_attachment").val() == '' || $("#reterival_required").val() == '' )){
                alert('Please enter all required fields')
                return false;                
            }else if(currentIndex === 2 && ($("#execution_start_time").val() == '' || $("#execution_end_time").val() == '')){
                alert('Please enter all required fields')
                return false;                
            }else if(currentIndex === 3 && ($("#archive_destination").val() == '' || $("#retention_period").val() == '' )){
                alert('Please enter all required fields')
                return false;                
            }else{
                return true;                
            }
        },        
        onFinished: function(event, currentIndex) {

            //Get Field Values
            var rule_name = $('#rule_name').val().trim();
            var system = $('#system').val().trim();
            var data_entity = $('#data_entity').val().trim();
            var rule_desc = $('#rule_desc').val().trim();
            var rule_criteria = $('#rule_criteria').val().trim();
            var archive_type = $('#archive_type').val().trim();
            var archive_attachment = $('#archive_attachment').val().trim();
            var reterival_required = $('#reterival_required').val().trim();   
            var summary_required = $('#summary_required').val().trim();
            var summary_type = $('#summary_type').val().trim();
            var execution_start_time = $('#execution_start_time').val().trim();
            var execution_end_time = $('#execution_end_time').val().trim();
            var archive_destination = $('#archive_destination').val().trim();
            var retention_period = $('#retention_period').val().trim();   
 
            //generate RRule
            const days = ['mon','tue','wed','thu','fri','sat','sun'].filter(id => $('#' + id).is(':checked')).map(id => $('#' + id).val());
            const monthly_mode = $('input[name="monthlyMode"]:checked').val();
            const formData = {
                pattern: $('#recurrencePattern').val(),
                interval: parseInt($('#interval').val()),
                days_of_week: days,
                month_day: parseInt($('#monthDay').val()),
                monthly_mode: monthly_mode,
                weekday: $('#weekdaySelect').val(),
                weekday_ordinal: parseInt($('#weekdayOrdinal').val()),
                end_type: $('input[name="endOption"]:checked').val(),
                occurrence_count: parseInt($('#occurrences').val()) || null,
                end_date: $('#endDate').val() || null
            };
            
            const rrule = convertFormToRRule(formData);
            
            //call ajax to save
            if(rule_name != ''){
                $.ajax({
                    url: 'php/ajax_rules.php',
                    type: 'post',
                    data: {request: "insert", rule_name:rule_name, system:system, data_entity:data_entity, rule_desc:rule_desc, rule_criteria:rule_criteria, archive_type:archive_type, archive_attachment:archive_attachment, reterival_required:reterival_required, summary_required:summary_required, summary_type:summary_type, rrule:rrule, execution_start_time:execution_start_time, execution_end_time:execution_end_time, archive_destination:archive_destination, retention_period:retention_period},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1){
                            alert(response.message);
                            window.location.href = "rules_list.php";                           
                        }else{
                            alert(response.message);
                        }
                    }
                });
            }else{
                alert('Please fill all Required fields.');
            }            
            //navigate to list

        }
    });
    </script>
    
    <script>
        //Expression builder
        let expression = "";
        
        function updatePreview() {
            $("#expressionPreview").text(expression.trim());
        }
        
        $("#addExpression").on("click", function() {
            const field = $("#fieldSelect").val();
            const operator = $("#operatorSelect").val();
            const value = $("#valueInput").val().trim();
        
            if (!value) return alert("Please enter a value");
        
            let formattedValue = value;
            if (operator === "IN" || operator === "NOT IN") {
                formattedValue = "(" + value.split(",").map(v => `'${v.trim()}'`).join(", ") + ")";
            } else {
                formattedValue = `'${value}'`;
            }
        
            let expr = `${field} ${operator} ${formattedValue}`;
            if (expression && !expression.trim().endsWith("(")) expr = " " + expr;
                expression += expr;
                updatePreview();
                $("#valueInput").val("");
            });
        
            $("[data-logic]").on("click", function() {
                const logic = $(this).data("logic");
                if (logic === "NOT") {
                  expression += ` NOT (`;
                } else {
                  expression += ` ${logic} `;
            }
            updatePreview();
            });
        
            $("#clearExpression").on("click", function() {
                expression = "";
                updatePreview();
            });
            
            $("#saveExpression").on("click", function() {
                $("#rule_criteria").val(expression.trim());
                $('#expressionBuilderModal').modal('toggle');
            });        
        
        //        
    </script>
    
    <script>
    //Recurrences
    function convertFormToRRule(data) {
        const pattern = data.pattern.toUpperCase();
        const interval = data.interval || 1;
        let rrule = `FREQ=${pattern};INTERVAL=${interval}`;
    
        if (pattern === 'WEEKLY' && data.days_of_week.length) {
          const dayMap = { Sun: 'SU', Mon: 'MO', Tue: 'TU', Wed: 'WE', Thu: 'TH', Fri: 'FR', Sat: 'SA' };
          const byday = data.days_of_week.map(d => dayMap[d]).join(',');
          rrule += `;BYDAY=${byday}`;
        }
    
        if (pattern === 'MONTHLY') {
          if (data.monthly_mode === 'day') {
            rrule += `;BYMONTHDAY=${data.month_day}`;
          } else if (data.monthly_mode === 'weekday') {
            rrule += `;BYDAY=${data.weekday};BYSETPOS=${data.weekday_ordinal}`;
          }
        }
    
        if (data.end_type === 'after' && data.occurrence_count) {
          rrule += `;COUNT=${data.occurrence_count}`;
        } else if (data.end_type === 'by' && data.end_date) {
          const d = new Date(data.end_date);
          const formatted = d.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
          rrule += `;UNTIL=${formatted}`;
        }
    
        return rrule;
    }
    
    $(document).ready(function () {
        for (let i = 1; i <= 31; i++) {
          $('#monthDay').append(`<option value="${i}">${i}</option>`);
        }
    
        $('#recurrencePattern').on('change', function () {
          const pattern = this.value;
          const labelMap = { daily: 'day(s)', weekly: 'week(s)', monthly: 'month(s)', yearly: 'year(s)' };
          $('#intervalLabel').text(labelMap[pattern]);
          $('#weeklySection').toggleClass('d-none', pattern !== 'weekly');
          $('#monthlySection').toggleClass('d-none', pattern !== 'monthly');
        });
    
        $('input[name="endOption"]').on('change', function () {
          $('#occurrences, #endDate').hide();
          if (this.value === 'after') $('#occurrences').show();
          if (this.value === 'by') $('#endDate').show();
        });


        $('#btn_create_reccurences').on('click', function (e) {
            console.log('Occurence button clicked');
            e.preventDefault();
    
          const days = ['mon','tue','wed','thu','fri','sat','sun'].filter(id => $('#' + id).is(':checked')).map(id => $('#' + id).val());
          const monthly_mode = $('input[name="monthlyMode"]:checked').val();
          const formData = {
            pattern: $('#recurrencePattern').val(),
            interval: parseInt($('#interval').val()),
            days_of_week: days,
            month_day: parseInt($('#monthDay').val()),
            monthly_mode: monthly_mode,
            weekday: $('#weekdaySelect').val(),
            weekday_ordinal: parseInt($('#weekdayOrdinal').val()),
            end_type: $('input[name="endOption"]:checked').val(),
            occurrence_count: parseInt($('#occurrences').val()) || null,
            end_date: $('#endDate').val() || null
          };
    
          const rrule = convertFormToRRule(formData);
          $('#rruleOutput').text(rrule);

        });    

    });
    </script>
    
</body>
<?php 
}else{
    header('Location: index.php');
}
?>
</html>
