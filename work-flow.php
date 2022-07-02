<!-- Work Flow -->
<?php
    $page_no = "6";
    $page_no_inside = "6_5";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Work Flow</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
    <div id="wrapper" class="wrapper" ng-app="">
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
                            <h1 class="m-0 text-dark">Work Flow</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right" id="navigation-view">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item">Work Flow Master</li>
                                <li class="breadcrumb-item active">Work Flow</li>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-center">
                            <kbd data-pre="All Projects" id="show-who" class="bg-warning btn-sm mt-1 mb-1">All Projects</kbd>
                        </h3>
                    </div>
                </div>
                <div class="card card-navy card-outline">
                    <div class="card-header">
                        <h3 class="card-title float-left">
                            <button id="back-button" type="button" class="back-button display-none btn btn-sm btn-danger mt-1 mb-1" title="Back" disabled>
                                <i class="fa fa-angle-left fa-sm"></i> Back
                            </button>
                        </h3>
                        <h3 class="card-title float-right">
                            <button id="refresh-button" type="button" class="refresh-button btn btn-sm btn-danger mt-1 mb-1" title="Refresh" disabled>
                                <i class="fas fa-sync-alt fa-sm"></i>
                            </button>
                            <button id="add-more-button" type="button" class="add-button btn btn-sm btn-warning mt-1 mb-1 display-none" data-toggle="modal" data-target="#add-more-modal" title="Add Item Type And Unit" disabled>
                                <i class="fa fa-plus fa-sm"></i>
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
            <div class="modal-dialog modal-lg">
                <form id="addMainWorkForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="projects_id" name="projects_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Main Work</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="main_work_type">Main Work Type</label>
                                                <select id="main_work_type" name="main_work_type" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_main_work_type");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if(count($getData) != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rows):
                                                                $main_work_type_info = json_decode($rows["main_work_type_info"]);
                                                                ?>
                                                                    <option value="<?= $rows["main_work_type_id"] ?>"><?= $main_work_type_info->main_work_type ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="main_work_type_add">Add Work Type</label>
                                                <div class="input-group">
                                                    <input type="text" name="" class="form-control" id="main_work_type_add" name="main_work_type_add" />
                                                    <div class="input-group-prepend">
                                                        <button id="main_work_type_add_button" type="button" class="btn btn-info"> <i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="main_work_type_starting_date">Starting Date</label>
                                                <input type="date" class="form-control" id="main_work_type_starting_date" name="main_work_type_starting_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="main_work_type_starting_time">Starting Time</label>
                                                <input type="time" class="form-control" id="main_work_type_starting_time" name="main_work_type_starting_time" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="main_work_type_expected_ending_date">Expected Ending Date</label>
                                                <input type="date" class="form-control" id="main_work_type_expected_ending_date" name="main_work_type_expected_ending_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="main_work_type_expected_ending_time">Expected Ending Time</label>
                                                <input type="time" class="form-control" id="main_work_type_expected_ending_time" name="main_work_type_expected_ending_time" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="main_work_type_ending_date">Ending Date</label>
                                                <input type="date" class="form-control" id="main_work_type_ending_date" name="main_work_type_ending_date" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="main_work_type_ending_time">Ending Time</label>
                                                <input type="time" class="form-control" id="main_work_type_ending_time" name="main_work_type_ending_time" readonly />
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
        <!-- Add New Work Section Start -->
        <div class="modal fade" id="add-work-modal">
            <div class="modal-dialog modal-xl">
                <form id="addWorkForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="work_main_work_type_id" name="work_main_work_type_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Work</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_type">Work Type</label>
                                                <select id="work_type" name="work_type" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_work_type");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if(count($getData) != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rows):
                                                                $work_type_info = json_decode($rows["work_type_info"]);
                                                                ?>
                                                                    <option value="<?= $rows["work_type_id"] ?>"><?= $work_type_info->work_type ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_type_add">Add Work Type</label>
                                                <div class="input-group">
                                                    <input type="text" name="" class="form-control" id="work_type_add" name="work_type_add" />
                                                    <div class="input-group-prepend">
                                                        <button id="work_type_add_button" type="button" class="btn btn-info"> <i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_type_starting_date">Starting Date</label>
                                                <input type="date" class="form-control" id="work_type_starting_date" name="work_type_starting_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_type_starting_time">Starting Time</label>
                                                <input type="time" class="form-control" id="work_type_starting_time" name="work_type_starting_time" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_type_expected_ending_date">Expected Ending Date</label>
                                                <input type="date" class="form-control" id="work_type_expected_ending_date" name="work_type_expected_ending_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_type_expected_ending_time">Expected Ending Time</label>
                                                <input type="time" class="form-control" id="work_type_expected_ending_time" name="work_type_expected_ending_time" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="work_type_ending_date">Ending Date</label>
                                                <input type="date" class="form-control" id="work_type_ending_date" name="work_type_ending_date" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6 display-none">
                                            <div class="form-group">
                                                <label for="work_type_ending_time">Ending Time</label>
                                                <input type="time" class="form-control" id="work_type_ending_time" name="work_type_ending_time" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Item Information</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-md-12 table-responsive">
                                                            <input type="hidden" id="totalItemInfo" name="totalItemInfo" value="1">
                                                            <table class="table table-bordered" id="dynamic_field">
                                                                <thead>
                                                                    <tr>
                                                                        <th data-field="S. No." data-sortable="true">S.No.</th>
                                                                        <th data-field="Item Type" data-sortable="true">Item Type</th>
                                                                        <th data-field="Unit" data-sortable="true">Unit</th>
                                                                        <th data-field="Quantity" data-sortable="true">Quantity</th>
                                                                        <th data-field="Rate" data-sortable="true">Rate</th>
                                                                        <th data-field="Amount" data-sortable="true">Amount</th>
                                                                        <th data-field="A (Material)" data-sortable="true">A (Material)</th>
                                                                        <th data-field="B (Labour)" data-sortable="true">B (Labour)</th>
                                                                        <th data-field="Remarks" data-sortable="true">Remarks</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="p-3 mt-2">1.</span>
                                                                        </td>
                                                                        <td>
                                                                            <select id="itemInfoItemType1" name="itemInfoItemType[]" class="form-control select2 select2-navy item-type-all" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" data-dropdown-css-class="select2-navy" style="width:200px;">
                                                                                <option disabled selected>Select</option>
                                                                                <?php 
                                                                                    $databaseObj->select("tbl_item_type");
                                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                    $getData = $databaseObj->get();
                                                                                    //Checking If Data Is Available
                                                                                    if($getData != 0):
                                                                                        $sno = 1;
                                                                                        foreach($getData as $rows):
                                                                                            $item_type_info = json_decode($rows["item_type_info"]);
                                                                                            ?>
                                                                                                <option data-ab="<?= $item_type_info->item_type_ab ?>" value="<?= $rows["item_type_id"] ?>"><?= $item_type_info->item_type ?></option>
                                                                                            <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select id="itemInfoUnitType1" name="itemInfoUnitType[]" class="form-control select2 select2-navy unit-type-all" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" data-dropdown-css-class="select2-navy" style="width:150px;">
                                                                                <option disabled selected>Select</option>
                                                                                <?php 
                                                                                    $databaseObj->select("tbl_unit_type");
                                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                    $getData = $databaseObj->get();
                                                                                    //Checking If Data Is Available
                                                                                    if($getData != 0):
                                                                                        $sno = 1;
                                                                                        foreach($getData as $rows):
                                                                                            $unit_type_info = json_decode($rows["unit_type_info"]);
                                                                                            ?>
                                                                                                <option value="<?= $rows["unit_type_id"] ?>"><?= $unit_type_info->unit_type ?></option>
                                                                                            <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input id="itemInfoQuantity1" name="itemInfoQuantity[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()"  style="width:200px;" />
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoRate1" name="itemInfoRate[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoAmount1" name="itemInfoAmount[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoMaterial1" name="itemInfoMaterial[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoLabour1" name="itemInfoLabour[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input id="itemInfoRemarks1" name="itemInfoRemarks[]" type="text" class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" style="width:200px;" />
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" name="add" id="add" class="btn btn-warning" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoTotalAmount" name="itemInfoTotalAmount" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </th>
                                                                        <th>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoTotalA" name="itemInfoTotalA" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </th>
                                                                        <th>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="itemInfoTotalB" name="itemInfoTotalB" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </th>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
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
                            <button type="submit" id="addWorkButton" class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add this</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="add-more-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Item Type And Unit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-navy card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item_type_add">Add Item Type</label>
                                            <div class="input-group">
                                                <select id="item_type_ab_add" name="item_type_ab_add" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" style="width: 130px;">
                                                    <option value="a" selected>Material</option>
                                                    <option value="b">Labour</option>
                                                </select>
                                                <input type="text" class="form-control" id="item_type_add" name="item_type_add" />
                                                <div class="input-group-prepend">
                                                    <button id="item_type_add_button" type="button" class="btn btn-info"> <i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unit_type_add">Add Unit</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="unit_type_add" name="unit_type_add" />
                                                <div class="input-group-prepend">
                                                    <button id="unit_type_add_button" type="button" class="btn btn-info"> <i class="fa fa-plus"></i></button>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Add New Work Section End -->
        <!-- Import Section Start -->
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
                                                <input type="file" class="form-control" id="importedExcel" name="importedExcel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                <small class="text-red text-sm">Before importing please check the excel format</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="importedExcel">See Format</label>
                                            <a href="assets/admin/work-flow/default.xlsx" target="_blank" class="btn btn-warning btn-md btn-work-flow"><i class="fa fa-eye fa-sm"></i> Format</a>
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
        <!-- Import Section End -->
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
            <div class="modal-dialog modal-md">
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
        <div class="modal fade" id="edit-work-modal">
            <div class="modal-dialog modal-lg">
                <form id="editWorkForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit This</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body" id="edit-work-section"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="editWorkButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
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
        <div class="modal fade" id="delete-work-modal">
            <div class="modal-dialog modal-sm">
                <form id="deleteWorkForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="delete-work-section"></div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="deleteWorkButton" class="delete-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete</button>
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
    <script src="dist/js/admin/work-flow.js"></script>
    <script>
        $(function(){
            //Multiple Rows Section Start ----------------------------------------------------------------------------------   
            var i=1;
            $('#add').click(function(){
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: false,
                  onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })
                function topEndNotification(theme, message){
                    Toast.fire({
                      icon: theme,
                      title: message
                    })
                }
                var temp_flag = 1;
                var temp_error = 1;
                for(j = 1; j <= Number($("#totalItemInfo").val()); j++){
                    if($("#itemInfoItemType"+j).val() == null){
                        $("#itemInfoItemType"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#itemInfoItemType"+j).removeClass("is-invalid");
                    if($("#itemInfoUnitType"+j).val() == null){
                        $("#itemInfoUnitType"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#itemInfoUnitType"+j).removeClass("is-invalid");
                    if($("#itemInfoQuantity"+j).val() == ""){
                        $("#itemInfoQuantity"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#itemInfoQuantity"+j).removeClass("is-invalid");
                    if($("#itemInfoRate"+j).val() == ""){
                        $("#itemInfoRate"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#itemInfoRate"+j).removeClass("is-invalid");
                    if($("#itemInfoAmount"+j).val() == ""){
                        $("#itemInfoAmount"+j).addClass("is-warning");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#itemInfoAmount"+j).removeClass("is-warning");
                    if($("#itemInfoMaterial"+j).val() == "" && $("#itemInfoLabour"+j).val() == ""){
                        $("#itemInfoMaterial"+j).addClass("is-warning");
                        $("#itemInfoLabour"+j).addClass("is-warning");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else{
                        $("#itemInfoMaterial"+j).removeClass("is-warning");
                        $("#itemInfoLabour"+j).removeClass("is-warning");
                    } 
                }
                if(temp_flag == 1){
                    i++; 
                    $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td> <td> <select id="itemInfoItemType'+i+'" name="itemInfoItemType[]" class="form-control select2 select2-navy item-type-all" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select</option> <?php  $databaseObj->select("tbl_item_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $item_type_info = json_decode($rows["item_type_info"]); ?> <option data-ab="<?= $item_type_info->item_type_ab ?>" value="<?= $rows["item_type_id"] ?>"><?= $item_type_info->item_type ?></option> <?php endforeach; endif; ?> </select> </td> <td> <select id="itemInfoUnitType'+i+'" name="itemInfoUnitType[]" class="form-control select2 select2-navy unit-type-all" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" data-dropdown-css-class="select2-navy" style="width:150px;"> <option disabled selected>Select</option> <?php  $databaseObj->select("tbl_unit_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $unit_type_info = json_decode($rows["unit_type_info"]); ?> <option value="<?= $rows["unit_type_id"] ?>"><?= $unit_type_info->unit_type ?></option> <?php endforeach; endif; ?> </select> </td> <td> <input id="itemInfoQuantity'+i+'" name="itemInfoQuantity[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()"  style="width:200px;" /> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="itemInfoRate'+i+'" name="itemInfoRate[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" /> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="itemInfoAmount'+i+'" name="itemInfoAmount[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly /> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="itemInfoMaterial'+i+'" name="itemInfoMaterial[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly /> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="itemInfoLabour'+i+'" name="itemInfoLabour[]" type="number" min="0.00" step=any class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" readonly /> </div> </div> </td> <td> <input id="itemInfoRemarks'+i+'" name="itemInfoRemarks[]" type="text" class="form-control" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()" style="width:200px;" /> </td> <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" onClick="calculateAmount()" onChange="calculateAmount()" onKeyUp="calculateAmount()" onBlur="calculateAmount()">X</button></td></tr>');
                    $('.select2').select2();
                    $("#totalItemInfo").val(i);
                } else{
                    topEndNotification("warning", temp_error);
                }
            });
            $(document).on('click', '.btn_remove', function(){  
               var button_id = $(this).attr("id");   
               $('#row'+button_id+'').remove(); 
               i--;
               $("#totalItemInfo").val(i);
            }); 
            //Multiple Rows Section End ------------------------------------------------------------------------------------ 
        });
    </script>
    <!-- Js Section End -->
</body>

</html>