<!-- Customers -->
<?php 
    $page_no = 7;
    $page_no_inside = "7_1";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Customers</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
    <style>
        .select2-container--default .select2-selection--single{
            height: calc(1.8125rem + 2px);
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }
    </style>
</head>
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
                            <h1 class="m-0 text-dark">Customers</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Customers</li>
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
                                    <div class="card card-navy" id="propertyInformationDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Property Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="projectName">Project *</label>
                                                        <select id="projectName" name="projectName" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option value="" selected disabled>Select Project</option>
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phase">Phase *</label>
                                                        <select id="phase" name="phase" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" disabled>
                                                            <option value="" selected disabled>Select Phase</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="building">Block *</label>
                                                        <select id="building" name="building" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" disabled>
                                                            <option value="" selected disabled>Select Block</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="floors">Floor Number *</label>
                                                        <select id="floors" name="floors" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" disabled>
                                                            <option value="" selected disabled>Select Floor Number</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="flat_no">Flat Number *</label>
                                                        <select id="flat_no" name="flat_no" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy" disabled>
                                                            <option value="" selected disabled>Select Flat Number</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="squareFeet">Total Area Sq.ft *</label>
                                                        <input id="squareFeet" name="squareFeet" type="text" class="form-control form-control-sm" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="pricePerSquare">Price / Sq.ft *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <input id="pricePerSquare" name="pricePerSquare" type="number" min="0" class="form-control form-control-sm" readonly />
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">/ Sq.ft</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="propertyPrice">Property Price *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <input id="propertyPrice" name="propertyPrice" type="number" min="0" class="form-control form-control-sm" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="propertyPriceDeal">Dealing Price *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <input id="propertyPriceDeal" name="propertyPriceDeal" type="number" min="0.00" step=any class="form-control form-control-sm" reaonly />
                                                        </div>
                                                        <small class="text-red">Customer's dealing price. *</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="propertyCarParking">Car Parking</label>
                                                        <select id="propertyCarParkings" name="propertyCarParkings" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                            </select>
                                                    </div>
                                                </div>

                                                <div id="divCarParkingArea" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="CarParkingArea">Car Parking Area</label>
                                                        <select id="propertyCarArea" name="CarParkingArea" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option value="">Select</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="2">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                             </select>
                                                    </div>
                                                </div>



                                                <div id="divCarParkingAmount" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="CarParkingAmount">Car Parking Price</label>
                                                        <input id="CarParkingAmount" name="CarParkingAmount" type="number" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="propertyScooterParking">Scooter Parking</label>
                                                        <select id="propertyScooterParkings" name="propertyScooterParkings" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                               <div id="divScooterParkingAmount" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="ScooterParkingAmount">Scooter Parking Price</label>
                                                        <input id="ScooterParkingAmount" name="ScooterParkingAmount" type="number" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-navy" id="paymentInformationDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Booking Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="paymentAmount">Booking Amount</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                            </div>
                                                            <input id="paymentAmount" name="paymentAmount" type="number" min="0" class="form-control form-control-sm"/>
                                                        </div>
                                                        <small class="text-red">Submitted Amount</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="paymentAmountInRupees">In Words</label>
                                                        <div class="input-group">
                                                            <input id="paymentAmountInRupees" name="paymentAmountInRupees" type="text" class="form-control form-control-sm" readonly/>
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="btn btn-danger btn-sm">Only</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paymentAmountNumber">Payment Number</label>
                                                        <input id="paymentAmountNumber" name="paymentAmountNumber" type="text" class="form-control form-control-sm"/>
                                                        <small class="text-red">Like Cheque No, Online Transaction No etc.</small>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paymentAmountMode">Payment Mode</label>
                                                        <select id="paymentAmountMode" name="paymentAmountMode" class="form-control select2">
                                                            <option value="Cash" selected>Cash</option>
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="DD">DD</option>
                                                            <option value="Online">Online</option>
                                                            <option value="NEFT/IMPS/RTGS">NEFT/IMPS/RTGS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 other-mode display-none">
                                                    <div class="form-group">
                                                        <label for="paymentAmountBankName">Bank Name</label>
                                                        <input id="paymentAmountBankName" name="paymentAmountBankName" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 other-mode display-none">
                                                    <div class="form-group">
                                                        <label for="paymentAmountNumber">Cheque/DD/NEFT No</label>
                                                        <input id="paymentAmountNumber" name="paymentAmountNumber" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="paymentAmountDate">Payment Date</label>
                                                        <input id="paymentAmountDate" name="paymentAmountDate" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-navy" id="paymentStructureDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Payment Structure </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <input type="hidden" value="1" id="totalNumberOfDivision" name="totalNumberOfDivision" />
                                                    <table class="table table-bordered table-striped dataTable" id="dynamic_field">
                                                        <thead>
                                                            <th>S. No.</th>
                                                            <th>Payment Date</th>
                                                            <th>Payment Description</th>
                                                            <th>Percentage Of Amount</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span class="p-3 mt-2">1.</span></td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <input id="paymentStuctureDate1" name="paymentStuctureDate[]" type="date" class="form-control form-control-sm" data-row-id=1 readonly="" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <input id="paymentStuctureRemark1" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm" data-row-id=1 style="width:200px;" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="input-group" style="width:150px;">
                                                                            <input id="paymentStuctureCompletion1" name="paymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control form-control-sm calculate-this" data-row-id=1 />
                                                                            <div class="input-group-prepend">
                                                                                <button type="button" class="btn btn-danger btn-sm">%</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="input-group" style="width:200px;">
                                                                            <div class="input-group-prepend">
                                                                                <button type="button" class="btn btn-danger btn-sm">&#8377;</button>
                                                                            </div>
                                                                            <input id="paymentStuctureAmount1" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm calculate-this" data-row-id=1 />
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="add" id="add" class="btn btn-warning btn-sm" data-row-id=1><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-navy" id="">
                                        <div class="card-header">
                                            <h3 class="card-title">Extra Amount</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-striped dataTable" id="dynamic_field1">
                                                        <thead>
                                                            <th>S. No.</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </thead>
                                                        <tbody>
                                                            <input type="hidden" value="1" id="totalextraamount" name="totalextraamount" />
                                                            <tr>
                                                                <td><span class="p-3 mt-2">1.</span></td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <input id="ExtraAmountRemarks1" name="ExtraAmountRemarks[]" type="text" class="form-control form-control-sm " />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group mb-0">
                                                                        <div class="input-group">
                                                                            <input id="ExtraAmount1" name="ExtraAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm "/>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="extraamountadd" id="extraamountadd" class="btn btn-warning btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-navy" id="firstApplicantDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">First Applicant</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstApplicantName">Name</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <select id="firstApplicantTitle" name="firstApplicantTitle" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                                    <option selected value="Mr">Mr.</option>
                                                                    <option value="Mrs">Mrs.</option>
                                                                    <option value="Ms">Ms.</option>
                                                                </select>
                                                            </div>
                                                            <input id="firstApplicantName" name="firstApplicantName" type="text" class="form-control form-control-sm"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstApplicantParentOf">S/D/W of *</label>
                                                        <input id="firstApplicantParentOf" name="firstApplicantParentOf" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantUsername">Username *</label>
                                                        <input id="firstApplicantUsername" name="firstApplicantUsername" type="text" min="0" class="form-control form-control-sm" value="CusSrH<?= rand(100000,999999)?>" readonly/> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantPassword">Password *</label>
                                                        <div class="input-group">
                                                        <input id="logPass" name="logPass" type="password" class="form-control form-control-sm" value="<?= $databaseObj->generate_password(8); ?>" readonly/>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">          
                                                                    <span id="passShow" class="display-none fas fa-eye"></span>
                                                                    <span id="passHide" class="fas fa-eye-slash"></span>
                                                                </div>
                                                            </div>
                                                         </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantPhoneNumber">Phone Number *</label>
                                                        <input id="firstApplicantPhoneNumber" name="firstApplicantPhoneNumber" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantAlternatePhoneNumber">Alternate Phone Number</label>
                                                        <input id="firstApplicantAlternatePhoneNumber" name="firstApplicantAlternatePhoneNumber" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantAlternateFax">Fax</label>
                                                        <input id="firstApplicantAlternateFax" name="firstApplicantAlternateFax" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantEmailId">Email Id *</label>
                                                        <input id="firstApplicantEmailId" name="firstApplicantEmailId" type="email" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantDateOfBirth">Date Of Birth *</label>
                                                        <input id="firstApplicantDateOfBirth" name="firstApplicantDateOfBirth" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantAge">Age *</label>
                                                        <div class="input-group">
                                                            <input id="firstApplicantAge" name="firstApplicantAge" type="number" class="form-control form-control-sm" readonly/>
                                                            <div class="input-group-prepend">
                                                                <button type="button" id="firstApplicantCalculateAge" class="btn btn-danger btn-sm">Calculate</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantMaritalStatus">Marital Status</label>
                                                        <select id="firstApplicantMaritalStatus" name="firstApplicantMaritalStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option selected value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="divFirstApplicantDateOfAnniversary" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="firstApplicantDateOfAnniversary">Date Of Anniversary</label>
                                                        <input id="firstApplicantDateOfAnniversary" name="firstApplicantDateOfAnniversary" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div id="divFirstApplicantNoOfChild" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="firstApplicantNoOfChild">Number Of Children</label>
                                                        <input id="firstApplicantNoOfChild" name="firstApplicantNoOfChild" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantReligion">Religion</label>
                                                        <input id="firstApplicantReligion" name="firstApplicantReligion" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantCaste">Caste</label>
                                                        <input id="firstApplicantCaste" name="firstApplicantCaste" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicantResidentialStatus">Residential Status</label>
                                                        <select id="firstApplicantResidentialStatus" name="firstApplicantResidentialStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option selected value="Resident">Resident</option>
                                                            <option value="Non-Resident">Non-Resident</option>
                                                            <option value="Foreign National of Indian Origin">Foreign National of Indian Origin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicanOccupation">Occupation</label>
                                                        <input id="firstApplicanOccupation" name="firstApplicanOccupation" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicanPanNumber">PAN Number *</label>
                                                        <input id="firstApplicanPanNumber" name="firstApplicanPanNumber"  class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="firstApplicanAadharNumber">Aadhar Number *</label>
                                                        <input id="firstApplicanAadharNumber" name="firstApplicanAadharNumber"  class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="firstApplicanPermanentAddress">Permanent Address *</label>
                                                        <textarea id="firstApplicanPermanentAddress" name="firstApplicanPermanentAddress" class="form-control form-control-sm"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="firstApplicanCorrespondenceAddress">Correspondence Address</label>
                                                        <textarea id="firstApplicanCorrespondenceAddress" name="firstApplicanCorrespondenceAddress" class="form-control form-control-sm"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-navy" id="secondApplicantDiv">
                                        <div class="card-header">
                                            <h3 class="card-title">Second Applicant</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="secondApplicantName">Name</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <select id="secondApplicantTitle" name="secondApplicantTitle" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                                    <option selected value="Mr">Mr.</option>
                                                                    <option value="Mrs">Mrs.</option>
                                                                    <option value="Ms">Ms.</option>
                                                                </select>
                                                            </div>
                                                            <input id="secondApplicantName" name="secondApplicantName" type="text" class="form-control form-control-sm"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="secondApplicantParentOf">S/D/W of</label>
                                                        <input id="secondApplicantParentOf" name="secondApplicantParentOf" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantPhoneNumber">Phone Number</label>
                                                        <input id="secondApplicantPhoneNumber" name="secondApplicantPhoneNumber" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantAlternatePhoneNumber">Alternate Phone Number</label>
                                                        <input id="secondApplicantAlternatePhoneNumber" name="secondApplicantAlternatePhoneNumber" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantAlternateFax">Fax</label>
                                                        <input id="secondApplicantAlternateFax" name="secondApplicantAlternateFax" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantEmailId">Email Id</label>
                                                        <input id="secondApplicantEmailId" name="secondApplicantEmailId" type="email" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantDateOfBirth">Date Of Birth</label>
                                                        <input id="secondApplicantDateOfBirth" name="secondApplicantDateOfBirth" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantAge">Age</label>
                                                        <div class="input-group">
                                                            <input id="secondApplicantAge" name="secondApplicantAge" type="number" class="form-control form-control-sm" readonly/>
                                                            <div class="input-group-prepend">
                                                                <button type="button" id="secondApplicantCalculateAge" class="btn btn-danger btn-sm ">Calculate</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantMaritalStatus">Marital Status</label>
                                                        <select id="secondApplicantMaritalStatus" name="secondApplicantMaritalStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option selected value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="divSecondApplicantDateOfAnniversary" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="secondApplicantDateOfAnniversary">Date Of Anniversary</label>
                                                        <input id="secondApplicantDateOfAnniversary" name="secondApplicantDateOfAnniversary" type="date" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div id="divSecondApplicantNoOfChild" class="col-md-4 display-none">
                                                    <div class="form-group">
                                                        <label for="secondApplicantNoOfChild">Number Of Children</label>
                                                        <input id="secondApplicantNoOfChild" name="secondApplicantNoOfChild" type="number" min="0" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantReligion">Religion</label>
                                                        <input id="secondApplicantReligion" name="secondApplicantReligion" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantCaste">Caste</label>
                                                        <input id="secondApplicantCaste" name="secondApplicantCaste" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicantResidentialStatus">Residential Status</label>
                                                        <select id="secondApplicantResidentialStatus" name="secondApplicantResidentialStatus" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                            <option selected value="Resident">Resident</option>
                                                            <option value="Non-Resident">Non-Resident</option>
                                                            <option value="Foreign National of Indian Origin">Foreign National of Indian Origin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicanOccupation">Occupation</label>
                                                        <input id="secondApplicanOccupation" name="secondApplicanOccupation" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicanPanNumber">PAN Number</label>
                                                        <input id="secondApplicanPanNumber" name="secondApplicanPanNumber" type="text" class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="secondApplicanAadharNumber">Aadhar Number</label>
                                                        <input id="secondApplicanAadharNumber" name="secondApplicanAadharNumber" type="text"  class="form-control form-control-sm"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="secondApplicanPermanentAddress">Permanent Address</label>
                                                        <textarea id="secondApplicanPermanentAddress" name="secondApplicanPermanentAddress" class="form-control form-control-sm"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="secondApplicanCorrespondenceAddress">Correspondence Address</label>
                                                        <textarea id="secondApplicanCorrespondenceAddress" name="secondApplicanCorrespondenceAddress" class="form-control form-control-sm"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                            <div class="form-group">
                                                <label for="importedExcel">Choose An Excel</label>
                                                <input type="file" class="form-control form-control-sm" id="importedExcel" name="importedExcel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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
        <!-- Payment Structure Section Start -->
        <div class="modal fade" id="payment-structure-modal">
            <div class="modal-dialog modal-lg">
                <form id="paymentStructureForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Payment Structure</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body" id="payment-structure-section"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="paymentStructureButton" class="payment-structure-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Payment Structure Section End -->
        <!-- Payment Structure Payment Section Start -->
        <div class="modal fade" id="payment-structure-payment-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Payments Paid/Unpaid Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body" id="payment-structure-payment-section"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Payment Structure Payment Section End -->
        <!-- Edit First Applicant Section Start -->
        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog modal-lg">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Applicant Information</h4>
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
        <!-- Edit First Applicant  Section End -->
        <!-- Edit Second Applicant Section Start -->
        <div class="modal fade" id="edit-second-modal">
            <div class="modal-dialog modal-lg">
                <form id="secondeditForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Second Applicant Information</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body" id="edit-second-section"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="secondeditButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Second Applicant  Section End -->
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
    <?php require_once("include/js.php");?>
    <script src="dist/js/ajax.js"></script>
0     <!--<script>
        $(function(){
            //Multiple Rows Section Start ------------------------------------------------------------------------------------------------------------------   
            var k=1;  
            $('#extraamountadd').click(function(){
            var addedExtraAmount = (0).toFixed(2);
            var checkAmt = "";
            var totalRow = $("#totalextraamount").val();
             for(l = 1; l <= totalRow; l++){
            if($("#ExtraAmount"+l).val() == ""){
                $("#ExtraAmount"+l).addClass("is-invalid");
                checkAmt = "emptyRows";
            }else
                $("#ExtraAmount"+l).removeClass("is-invalid");
            if($("#ExtraAmountRemarks"+l).val() == ""){
                $("#ExtraAmountRemarks"+l).addClass("is-invalid");
                checkAmt = "emptyRows";
            }else
                $("#ExtraAmountRemarks"+l).removeClass("is-invalid");           
        }
            if(checkAmt != "emptyRows"){
            k++; 
            console.log("K="+k);
            $('#dynamic_field1').append('<tr id="extraAmtRow'+k+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+k+'.</span></td><td><input id="ExtraAmount'+k+'" name="ExtraAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm" style="width:200px;" /></td><td><input id="ExtraAmountRemarks'+k+'" name="ExtraAmountRemarks[]" type="number" class="form-control form-control-sm"  style="width:200px;" /></td><td><button type="button" name="remove'+k+'" id="'+k+'" class="btn btn-danger btn_removeExt">X</button></td></tr>');
            $("#totalextraamount").val(k);
        } else {
            //topEndNotification("warning", "Please first complete existing rows");
        }
             
      });
            $("#ExtraAmount"+k).addClass("calculate-amount");
            $("#ExtraAmountRemarks"+k).addClass("calculate-amount");
                  
            });
            $(document).on('click', '.btn_removeExt', function(){  
               var button_id1 = $(this).attr("id");   
               $('#extraAmtRow'+button_id1+'').remove(); 
               k--;
               $("#totalextraamount").val(k);
            }); 
            //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
        //});
    </script>-->
    <!-- Js Section End -->
</body>

</html>