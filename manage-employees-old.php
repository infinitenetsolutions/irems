<!-- Employee Management -->
<?php     
    $page_no = "3";    
    $page_no_inside = "3_3";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Employee Management</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>
<style>
        .select2-container--default .select2-selection--single{
            height: calc(1.8125rem + 2px);
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }
    </style>
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
    <div id="wrapper" class="wrapper">
        <!-- Navbar Section Start -->
        <?php require_once("include/navbar.php"); ?>

        <!-- Navbar Section End -->
        <!-- Main Sidebar Section Start -->
        <?php require_once("include/aside.php"); ?>

        <!-- Main Sidebar Section End -->

        <!-- All Contains Section Start -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Employee Management</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Employee Management</li>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <button id="refresh-button" type="button" class="refresh-button btn btn-sm btn-danger mt-1 mb-1" title="Refresh" disabled>
                                <i class="fas fa-sync-alt fa-sm"></i>
                            </button>
                            <button id="add-button" type="button" class="add-button btn btn-sm btn-success mt-1 mb-1" data-toggle="modal" data-target="#add-modal" title="Add New" disabled>
                                <i class="fa fa-plus fa-sm"></i> Add New
                            </button>
                            <button id="import-button" type="button" class="import-button btn btn-sm btn-info mt-1 mb-1" data-toggle="modal" data-target="#import-modal" title="Import" disabled>
                                <i class="fa fa-upload fa-sm"></i> Import
                            </button>
                            <button id="export-button" type="button" class="export-button btn btn-sm btn-warning display-none mt-1 mb-1" data-toggle="modal" data-target="#export-modal" title="Export" disabled>
                                <i class="fa fa-download fa-sm"></i> Export
                            </button>
                            <button id="delete-button" type="button" class="delete-button btn btn-sm btn-danger display-none mt-1 mb-1" data-toggle="modal" data-target="#delete-selected-modal" title="Delete" disabled>
                                <i class="fa fa-trash fa-sm"></i> Delete
                            </button>
                        </h3>
                    </div>
                    <div class="card-body table-responsive" id="view-section"></div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- Add New Section Start -->
       <div class="modal fade" id="add-modal">
            <div class="modal-dialog modal-xl">
                <form id="addForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="department">Department</label>
                                                <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" id="department" name="department">
                                                   
                                                            <option disabled selected>Select</option>
                                                                <?php 
                                                                    $databaseObj->select("tbl_manage_department");
                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                    $getData = $databaseObj->get();
                                                                    //Checking If Data Is Available
                                                                    if($getData != 0):
                                                                        $sno = 1;
                                                                        foreach($getData as $rows):
                                                                            $manage_department_info = json_decode($rows["manage_department_info"]);
                                                                            ?>
                                                                                <option value="<?= $rows["manage_department_id"] ?>"><?= $manage_department_info->departmentName ?></option>
                                                                            <?php
                                                                        endforeach;
                                                                    endif;
                                                                ?>
                                                        </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="designation">Designation</label>
                                                <select id="designation" name="designation" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                  <option value="">Select designation</option>
                                                </select>       
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="empType">Vendor/Payroll </label>
                                                <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy"name="empType">
                                                 <option value="">Select Type</option>
                                                 <option value="Vendor Employee">Vendor Employee</option>
                                                 <option value="On Payroll">On Payroll</option>

                                                 </select>
                                            </div>
                                        </div>
                                        
                                        
                                         <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="empType">Project Name</label>
                                                <select id="project" name="project" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                  <option value="">Select Project</option>
                                                <?php 
                                                    $databaseObj->select("tbl_projects");
                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                    $getData = $databaseObj->get();
                                                    //Checking If Data Is Available
                                                    if($getData != 0):
                                                    $sno = 1;
                                                    foreach($getData as $rows):
                                                    $projects_info = json_decode($rows["projects_info"]);
                                                    ?>
                                                  
                                                    <option value="<?= $rows["projects_id"] ?>"><?= $projects_info->projectName ?></option>
                                                    <?php
                                                    endforeach;
                                                    endif;
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                         <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="empType">Property</label>
                                                <select id="property" name="property" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    
                                                </select>
                                            </div>
                                        </div> -->
                                        
                                        <div class="col-md-12">
                                        <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Personal Details</h3>
                                        </div> 
                                             
                                        </div>
                                        
                                        
                                        <div class="col-md-3">     
                                            <div class="form-group form-group-smform-group-sm">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control form-control-sm form-control " id="firstName" name="firstName" placeholder="First Name">
                                            </div>
                                            </div>
                                        
                                        
                                        <div class="col-md-3">     
                                            <div class="form-group form-group-smform-group-sm">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control form-control-sm form-control " id="lastName" name="lastName" placeholder="Last Name">
                                            </div>
                                            </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="employeeId">Employee ID</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="employeeId" name="employeeId" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="mobile">Mobile</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="mobile" name="mobile" placeholder="Mobile">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="dob">Date Of Birth</label>
                                                <input type="date" class="form-control form-control-sm form-control " id="dob" name="dob" placeholder="">
<!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="email" name="email" placeholder="">
<!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="gender">Gender</label>
                                             <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" name="gender">
                                                 <option value="">Select Gender</option>
                                                 <option value="Male">Male</option>
                                                 <option value="Female">Female</option>

                                                 </select>                                           
                                                  </div>
                                        </div>
                                        
                                        
                                         <div class="col-md-12">
                                        <div class="card-header" style="color:white;background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Work Details</h3>
                                        </div> 
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                         <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="date_of_joining">Date of Joining</label>
                                                <input type="date" class="form-control form-control-sm form-control " id="date_of_joining" name="date_of_joining" placeholder="">
<!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="source_of_hire">Source of Hire</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="source_of_hire" name="source_of_hire" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="reporting_to">Reporting To</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="reporting_to" name="reporting_to" placeholder="">
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="empStatus">Employee Status</label>
                                             <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" name="empStatus">
                                                 <option value="">Select Status</option>
                                                 <option value="Active">Active</option>
                                                 <option value="Inactive">Inactive</option>

                                                 </select>                                           
                                                  </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="workPhone">Work Phone</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="workPhone" name="workPhone" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="type">Employee Type</label>
                                               <select class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" name="type">
                                                 <option value="">Select Employee Type</option>
                                                 <option value="Full Time">Full Time</option>
                                                 <option value="Part Time">Part Time</option>

                                                 </select>                                               
                                                 </div>
                                        </div>
                                        <div class="col-md-3">
                                                    <div class="form-group form-group-smform-group-sm">
                                                        <label for="MaritalStatus">Marital Status</label>
                                                        <select id="MaritalStatus" name="MaritalStatus" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option selected value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="AnniversaryDiv" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="Anniversary">Date Of Anniversary</label>
                                                        <input id="Anniversary" name="Anniversary" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                        
                                        
                                        
                                         <div class="col-md-12">
                                        <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Contact Details</h3>
                                        </div> 
                                        </div>
                                        
                                        
                                        
                                         <div class="col-md-3">     
                                            <div class="form-group form-group-smform-group-sm">
                                            <label for="address1">Address 1</label>
                                            <input type="text" class="form-control form-control-sm form-control " id="address1" name="address1" placeholder="">
                                            </div>
                                            </div>
                                        
                                        
                                         <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="address2">Address 2</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="address2" name="address2" placeholder="">
<!--                                                <small class="text-red">Define this date after the completion of project</small>-->
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="city" name="city" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="country" name="country" placeholder="">
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="state" name="state" placeholder="">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                          <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nationality">Nationality</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="nationality" name="nationality" placeholder="">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="postalCode">Postal Code</label>
                                                <input type="text" class="form-control form-control-sm form-control " id="postalCode" name="postalCode" placeholder="">
                                            </div>
                                        </div>
                                       
                                       
                                        
                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="maritalStatus">Marital Status</label>
                                             <select class="form-control form-control-sm form-control " name="maritalStatus">
                                                 <option value="">Select Status</option>
                                                 <option value="Single">Single</option>
                                                 <option value="Married">Married</option>

                                                 </select>                                           
                                                  </div>
                                        </div> -->
                                        
                                        
                                        
                                        <div class="col-md-12">
                                            <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                                <h3 class="card-title">Salaries</h3>
                                            </div> 
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="basicSalary">Basic Salary</label>
                                                <input type="number" class="form-control form-control-sm salary" id="basicSalary" name="basicSalary" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="hra">HRA</label>
                                                <input type="number" class="form-control form-control-sm salary" id="hra" name="hra" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="da">DA</label>
                                                <input type="number" class="form-control form-control-sm salary" id="da" name="da" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="ca">CA</label>
                                                <input type="number" class="form-control form-control-sm salary" id="ca" name="ca" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="lta">LTA</label>
                                                <input type="number" class="form-control form-control-sm salary" id="lta" name="lta" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="sa">SA</label>
                                                <input type="number" class="form-control form-control-sm salary" id="sa" name="sa" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="ma">MA</label>
                                                <input type="number" class="form-control form-control-sm salary" id="ma" name="ma" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="ot">OT</label>
                                                <input type="number" class="form-control form-control-sm salary" id="ot" name="ot" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="pb">PB</label>
                                                <input type="number" class="form-control form-control-sm salary" id="pb" name="pb" />
                                            </div>
                                        </div>




                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="totalSalary">Total Salary</label>
                                                <input type="number" class="form-control form-control-sm" id="totalSalary" name="totalSalary" readonly />
                                            </div>
                                        </div>





                                        <div class="col-md-12">
                                            <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                                <h3 class="card-title">Deductions</h3>
                                            </div> 
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="epf">EPF (Provident Fund)</label>
                                                <input type="number" class="form-control form-control-sm deduction" id="epf" name="epf" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="esi">ESI</label>
                                                <input type="number" class="form-control form-control-sm deduction" id="esi" name="esi" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="loan">Loan</label>
                                                <input type="number" class="form-control form-control-sm deduction" id="loan" name="loan" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group">
                                                <label for="totalDeduction">Total Deduction</label>
                                                <input type="number" class="form-control form-control-sm" id="totalDeduction" name="totalDeduction" readonly />
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                                <h3 class="card-title">Totals</h3>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">     
                                            <div class="form-group">
                                                <label for="grossSalary">Gross Salary</label>
                                                <input type="number" class="form-control form-control-sm" id="grossSalary" name="grossSalary" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">     
                                            <div class="form-group">
                                                <label for="netSalary">Net Salary</label>
                                                <input type="number" class="form-control form-control-sm" id="netSalary" name="netSalary" readonly />
                                            </div>
                                        </div>








                                         <div class="col-md-12">
                                        <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Bank Account Details</h3>
                                        </div> 
                                        </div>
                                        
                                          <div class="col-md-3">     
                                            <div class="form-group">
                                            <label for="account_holder_name">Account Holder Name</label>
                                            <input type="text" class="form-control form-control-sm" id="account_holder_name" name="account_holder_name" placeholder="">
                                            </div>
                                            </div>
                                        
                                          <div class="col-md-3">     
                                            <div class="form-group">
                                            <label for="bankName">Bank Name</label>
                                            <input type="text" class="form-control form-control-sm form-control " id="bankName" name="bankName" placeholder="">
                                            </div>
                                            </div>
                                            
                                            
                                             <div class="col-md-3">     
                                            <div class="form-group">
                                            <label for="acc_no">Account No</label>
                                            <input type="text" class="form-control form-control-sm form-control " id="acc_no" name="acc_no" placeholder="">
                                            </div>
                                            </div>
                                            
                                            
                                             <div class="col-md-3">     
                                            <div class="form-group">
                                            <label for="branch">Branch</label>
                                            <input type="text" class="form-control form-control-sm form-control " id="branch" name="branch" placeholder="">
                                            </div>
                                            </div>
                                            
                                            
                                        <div class="col-md-12">
                                        <div class="card-header" style="color:white; background-color: #001f3f; padding:8px;">
                                        <h3 class="card-title">Image</h3>
                                        </div> 
                                        </div>
                                        
                                            <div class="col-md-3">     
                                            <div class="form-group form-group-smform-group-sm">
                                        <label for="img">Image Upload</label>
                                        <input type="file" class="form-control form-control-sm form-control " id="img" name="img" accept="image/*">
                                                </div>
                                        </div>
                                       <!--  <div class="col-md-3">     
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="aadharimage">Aadhar Card  Upload</label>
                                                <input type="file" class="form-control form-control-sm form-control " id="aadharimage" name="aadharimage" accept="pdf/*">
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group form-group-sm">
                                                <label for="panimage">Pan Card  Upload</label>
                                                <input type="file" class="form-control form-control-sm form-control " id="panimage" name="panimage" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-3">     
                                            <div class="form-group form-group-sm">
                                                <label for="addressProofimage">Address Proof  Upload</label>
                                                <input type="file" class="form-control form-control-sm form-control " id="addressProofimage" name="addressProofimage" accept="pdf/*">
                                            </div>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="addButton" class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Section End -->
        <!-- Add New Section Start -->
        <div class="modal fade" id="import-modal">
            <div class="modal-dialog modal-md">
                <form id="importForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Import Excel</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group form-group-smform-group-sm">
                                                <label for="importedExcel">Choose An Excel</label>
                                                <input type="file" class="form-control" id="importedExcel" name="importedExcel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                <small class="text-red text-sm">Before importing please check the excel format</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="importedExcel">See Format</label>
                                            <a href="assets/admin/manage-company/default.xlsx" target="_blank" class="btn btn-warning btn-md btn-block"><i class="fa fa-eye fa-sm"></i> Format</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="importButton" class="import-button btn btn-info btn-sm"><i class="fa fa-upload fa-sm"></i> Import this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Section End -->
        <!-- Information Section Start -->
        <div class="modal fade" id="information-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Information</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="information-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Information Section End -->
        <!-- See Section Start -->
        <div class="modal fade" id="see-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Complete Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="see-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- See Section End -->
        <!-- Edit Section Start -->
        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog modal-lg">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit This</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body" id="edit-section"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="editButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Section End -->
        <!-- Export Selected Section Start -->
        <div class="modal fade" id="export-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Are you sure?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning alert-dismissible">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Confirm!</h5>
                            Do you really wanna Export selected data in excel???
                        </div>
                        <div id="export-section"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                        <button type="submit" id="exportSelectedButton" class="export-button btn btn-info btn-sm"><i class="fas fa-download fa-sm"></i> Export Selected</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Export Selected Section End -->
        <!-- Delete Section Start -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-sm">
                <form id="deleteForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="delete-section"></div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="deleteButton" class="delete-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Delete Section End -->
        <!-- Delete Selected Section Start -->
        <div class="modal fade" id="delete-selected-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Are you sure?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            Do you really wanna delete selected data???
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                        <button type="submit" id="deleteSelectedButton" class="delete-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete Selected</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Selected Section End -->
        <!-- Footer Section Start -->
        <?php require_once("include/footer.php"); ?>
        <!-- Footer Section End -->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Js Section Start -->
    <?php require_once("include/js.php"); ?>
    
    <script src="dist/js/ajax.js"></script>
    
    <script src="dist/js/admin/manage-employees.js"></script>
    <!-- Js Section End -->
</body>

</html>  