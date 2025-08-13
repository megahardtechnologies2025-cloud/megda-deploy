<!DOCTYPE html>
<html dir="web" lang="en">
<?php
session_start();
if($_SESSION['valid']=="VALIDATED")
{
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
                                <h4 class="card-title">New Rule Creation</h4>
                                <h6 class="card-subtitle">Exporting data from a table can often be a key part of a complex application. The Buttons extension for DataTables provides three plug-ins that provide overlapping functionality for data export.  You can refer full documentation from here <a href="https://datatables.net/">Datatables</a></h6>

                                  <div class="mt-5 mb-5">
                                    <form id="ruleForm">
                                      <div class="row g-3">
                                        <div class="col-md-6">
                                          <label for="ruleName" class="form-label">Rule Name</label>
                                          <input type="text" class="form-control" id="ruleName" maxlength="200" required>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="siebelObject" class="form-label">Siebel Object</label>
                                          <select class="form-select" id="siebelObject" required>
                                            <option value="">Select</option>
                                            <option>Account</option>
                                            <option>Contact</option>
                                            <option>Service Requests</option>
                                            <option>Order</option>
                                            <option>Activities</option>
                                          </select>
                                        </div>
                                        <div class="col-12">
                                          <label for="ruleDescription" class="form-label">Rule Description</label>
                                          <textarea class="form-control" id="ruleDescription" rows="2" maxlength="500"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                          <label for="ruleCriteria" class="form-label">Rule Criteria</label>
                                          <input type="text" id="ruleCriteria" class="form-control" readonly data-bs-toggle="modal" data-bs-target="#expressionBuilderModal">
                                        </div>
                                        <div class="col-md-4">
                                          <label for="archiveAttachment" class="form-label">Archive Attachment?</label>
                                          <select class="form-select" id="archiveAttachment" required>
                                            <option value="">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                          </select>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="retentionPeriod" class="form-label">Retention Period (Days)</label>
                                          <input type="number" class="form-control" id="retentionPeriod" maxlength="50" required>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="status" class="form-label">Status</label>
                                          <select class="form-select" id="status" required>
                                            <option value="">Select</option>
                                            <option>Creating</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                          </select>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="frequency" class="form-label">Archival Frequency</label>
                                          <input type="text" class="form-control" id="frequency" placeholder="Click to set..." readonly data-bs-toggle="modal" data-bs-target="#recurrenceModal">
                                        </div>
                                        <div class="col-md-4">
                                          <label for="startTime" class="form-label">Archive Start Time</label>
                                          <input type="time" class="form-control" id="startTime" required>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="endTime" class="form-label">Archive End Time</label>
                                          <input type="time" class="form-control" id="endTime" required>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="archiveTarget" class="form-label">Archive Target</label>
                                          <select class="form-select" id="archiveTarget" required>
                                            <option value="">Select</option>
                                            <option>Database</option>
                                            <option>File System</option>
                                            <option>Cloud Storage</option>
                                          </select>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="archiveType" class="form-label">Archive Type</label>
                                          <select class="form-select" id="archiveType" required>
                                            <option value="">Select</option>
                                            <option>Archive with Delete</option>
                                            <option>Archive without Delete</option>
                                            <option>Direct Delete</option>
                                          </select>
                                        </div>
                                        <div class="col-md-4">
                                          <label for="retrievalRequired" class="form-label">Retrieval Required</label>
                                          <select class="form-select" id="retrievalRequired" required>
                                            <option value="">Select</option>
                                            <option>Yes with Summary</option>
                                            <option>Yes without Summary</option>
                                            <option>No</option>
                                          </select>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="activationDate" class="form-label">Activation Date</label>
                                          <input type="datetime-local" class="form-control" id="activationDate" required>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="expirationDate" class="form-label">Expiration Date</label>
                                          <input type="datetime-local" class="form-control" id="expirationDate" required>
                                        </div>
                                        <div class="col-12 mt-4">
                                          <button type="submit" class="btn btn-primary">Create Rule</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recurrence Modal -->
                <div class="modal fade" id="recurrenceModal" tabindex="-1" aria-labelledby="recurrenceModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="recurrenceModalLabel">Recurrence Pattern</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form id="recurrenceForm">
                        <div class="modal-body">
                          <!-- All recurrence form content starts here -->
                          <div class="mb-3">
                            <label for="recurrenceFrequency" class="form-label">Recurrence Frequency</label>
                            <select class="form-select" id="recurrenceFrequency" required>
                              <option value="Daily">Daily</option>
                              <option value="Weekly">Weekly</option>
                              <option value="Monthly">Monthly</option>
                              <option value="Yearly">Yearly</option>
                            </select>
                          </div>
                
                          <div id="dailyOptions" class="recurrence-section">
                            <label class="form-label">Recur every:</label>
                            <input type="number" class="form-control" id="dailyInterval" min="1" value="1">
                            <small class="text-muted">day(s)</small>
                          </div>
                
                          <div id="weeklyOptions" class="recurrence-section d-none mt-3">
                            <label class="form-label">Recur every:</label>
                            <input type="number" class="form-control" id="weeklyInterval" min="1" value="1">
                            <small class="text-muted">week(s) on:</small>
                            <div class="form-check form-check-inline mt-2">
                              <label><input type="checkbox" class="form-check-input" value="Mon"> Mon</label>
                              <label><input type="checkbox" class="form-check-input" value="Tue"> Tue</label>
                              <label><input type="checkbox" class="form-check-input" value="Wed"> Wed</label>
                              <label><input type="checkbox" class="form-check-input" value="Thu"> Thu</label>
                              <label><input type="checkbox" class="form-check-input" value="Fri"> Fri</label>
                              <label><input type="checkbox" class="form-check-input" value="Sat"> Sat</label>
                              <label><input type="checkbox" class="form-check-input" value="Sun"> Sun</label>
                            </div>
                          </div>
                
                          <div id="monthlyOptions" class="recurrence-section d-none mt-3">
                            <label class="form-label">Recur every:</label>
                            <input type="number" class="form-control" id="monthlyInterval" min="1" value="1">
                            <small class="text-muted">month(s)</small>
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="radio" name="monthlyOption" id="monthlyDay" checked>
                              <label class="form-check-label" for="monthlyDay">
                                On day <input type="number" class="form-control d-inline-block w-auto" id="monthlyDayNum" min="1" max="31" value="1">
                              </label>
                            </div>
                            <div class="form-check mt-2">
                              <input class="form-check-input" type="radio" name="monthlyOption" id="monthlyWeekday">
                              <label class="form-check-label" for="monthlyWeekday">
                                On the 
                                <select class="form-select d-inline-block w-auto" id="monthlyWeekNum">
                                  <option value="1">First</option>
                                  <option value="2">Second</option>
                                  <option value="3">Third</option>
                                  <option value="4">Fourth</option>
                                  <option value="5">Last</option>
                                </select>
                                <select class="form-select d-inline-block w-auto" id="monthlyWeekdayType">
                                  <option value="Mon">Monday</option>
                                  <option value="Tue">Tuesday</option>
                                  <option value="Wed">Wednesday</option>
                                  <option value="Thu">Thursday</option>
                                  <option value="Fri">Friday</option>
                                  <option value="Sat">Saturday</option>
                                  <option value="Sun">Sunday</option>
                                </select>
                              </label>
                            </div>
                          </div>
                
                          <div id="yearlyOptions" class="recurrence-section d-none mt-3">
                            <label class="form-label">Recur every:</label>
                            <input type="number" class="form-control" id="yearlyInterval" min="1" value="1">
                            <small class="text-muted">year(s)</small>
                          </div>
                
                          <hr class="mt-4 mb-3">
                          <h5>Range of Recurrence</h5>
                          <label for="startDate" class="form-label">Start Date</label>
                          <input type="date" class="form-control" id="startDate" required>
                          <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="endOption" id="noEndDate" checked>
                            <label class="form-check-label" for="noEndDate">No end date</label>
                          </div>
                          <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="endOption" id="endAfter">
                            <label class="form-check-label" for="endAfter">
                              End after <input type="number" class="form-control d-inline-block w-auto" id="occurrenceCount" min="1" value="10"> occurrences
                            </label>
                          </div>
                          <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="endOption" id="endBy">
                            <label class="form-check-label" for="endBy">
                              End by <input type="date" class="form-control d-inline-block w-auto" id="endByDate">
                            </label>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Save Recurrence</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="expressionBuilderModal" tabindex="-1" aria-labelledby="expressionBuilderLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Expression Builder</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-4">
                            <label for="fieldSelect" class="form-label">Field</label>
                            <select class="form-select" id="fieldSelect">
                              <option value="[Created]">Created</option>
                              <option value="[Status]">Status</option>
                              <option value="[Priority]">Priority</option>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="operatorSelect" class="form-label">Operator</label>
                            <select class="form-select" id="operatorSelect">
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
                          <button class="btn btn-primary" id="addExpression">Add Expression</button>
                          <button class="btn btn-secondary" data-logic="AND">AND</button>
                          <button class="btn btn-secondary" data-logic="OR">OR</button>
                          <button class="btn btn-secondary" data-logic="NOT">NOT</button>
                          <button class="btn btn-danger" id="clearExpression">Clear</button>
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
    <script>
      $(document).ready(function () {
        function toggleRecurrenceSections() {
          const freq = $('#recurrenceFrequency').val();
          $('.recurrence-section').addClass('d-none');
          if (freq === 'Daily') $('#dailyOptions').removeClass('d-none');
          if (freq === 'Weekly') $('#weeklyOptions').removeClass('d-none');
          if (freq === 'Monthly') $('#monthlyOptions').removeClass('d-none');
          if (freq === 'Yearly') $('#yearlyOptions').removeClass('d-none');
        }
    
        $('#recurrenceFrequency').on('change', toggleRecurrenceSections);
        toggleRecurrenceSections();
    
        $('#recurrenceForm').on('submit', function (e) {
          e.preventDefault();
          // For demo, just populate the frequency field with selected option
          const freq = $('#recurrenceFrequency').val();
          $('#frequency').val(freq);
          $('#recurrenceModal').modal('close');
        });
        
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
        $("#ruleCriteria").val(expression.trim());
        });        
        
        //
        
      });
    </script>      
</body>
<?php 
}else{
    header('Location: index.php');
}
?>
</html>