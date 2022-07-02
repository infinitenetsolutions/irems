<!-- Lands -->
<?php 
    $page_no = "8";
    $page_no_inside = "8_3";

?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Lands</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
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
                            <h1 class="m-0 text-dark">Lands</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Lands</li>
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
                                <i class="fas fa-sync-alt fa-sm" id="refresh-icon"></i>
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ownerName">Select Owner</label>
                                                <select id="ownerName" name="ownerName" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    <option disabled selected>Select Owner</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_owner");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rows):
                                                                $owner_info = json_decode($rows["owner_info"]);
                                                                ?>
                                                                    <option value="<?= $rows["owner_id"] ?>"><?= $owner_info->ownerName ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Owner Information</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="col-md-12" id="owner-informations">
                                                        <div class="alert alert-info alert-dismissible">
                                                          <span><i class="icon fas fa-info"></i> Please first select Owner.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Location Information</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landState">State</label>
                                                                <select class="form-control select2" id="landState" name="landState">
                                                                    <option value="">Select State</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landCity">City</label>
                                                                <select class="form-control select2" id="landCity" name="landCity">
                                                                    <option value="">Select State First</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landUnit">Unit / Area</label>
                                                                <input type="text" class="form-control" id="landUnit" name="landUnit" placeholder="Unit / Area">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landSubUnit">Sub Unit / Block</label>
                                                                <input type="text" class="form-control" id="landSubUnit" name="landSubUnit" placeholder="Sub Unit / Block">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landStreetName">Street Name</label>
                                                                <input type="text" class="form-control" id="landStreetName" name="landStreetName" placeholder="Street Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landLandMark">Land Mark</label>
                                                                <input type="text" class="form-control" id="landLandMark" name="landLandMark" placeholder="Land Mark">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landLineNo">Line No.</label>
                                                                <input type="text" class="form-control" id="landLineNo" name="landLineNo" placeholder="Line No.">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPincode">Pincode</label>
                                                                <input type="number" class="form-control" id="landPincode" name="landPincode" placeholder="Pincode">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="landAddress">Complete Address</label>
                                                                <textarea class="form-control" id="landAddress" name="landAddress" placeholder="Complete Address"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Land Information</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-md-12 table-responsive">
                                                            <input type="hidden" id="totalLandInfo" name="totalLandInfo" value="1">
                                                            <table class="table table-bordered" id="dynamic_field">
                                                                <thead>
                                                                    <tr>
                                                                        <th data-field="S. No." data-sortable="true">S.No.</th>
                                                                        <th data-field="Land Type" data-sortable="true">Land Type</th>
                                                                        <th data-field="Area" data-sortable="true">Area</th>
                                                                        <th data-field="UOM" data-sortable="true">UOM</th>
                                                                        <th data-field="Price / UOM" data-sortable="true" id="perUOMHeader">Price / UOM</th>
                                                                        <th data-field="Total Price" data-sortable="true">Total Price</th>
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
                                                                            <input id="landInfoType1" name="landInfoType[]" type="text" class="form-control" style="width:200px;" />
                                                                        </td>
                                                                        <td>
                                                                            <input id="landInfoArea1" name="landInfoArea[]" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" style="width:150px;" />
                                                                        </td>
                                                                        <td>
                                                                            <select id="landInfoUOM1" name="landInfoUOM[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" style="width:100px;">
                                                                                <option disabled selected>Select</option>
                                                                                <?php 
                                                                                    $databaseObj->select("tbl_uom");
                                                                                    $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                                    $getData = $databaseObj->get();
                                                                                    //Checking If Data Is Available
                                                                                    if($getData != 0):
                                                                                        $sno = 1;
                                                                                        foreach($getData as $rows):
                                                                                            $uom_info = json_decode($rows["uom_info"]);
                                                                                            ?>
                                                                                                <option value="<?= $rows["uom_id"] ?>"><?= $uom_info->uom ?></option>
                                                                                            <?php
                                                                                        endforeach;
                                                                                    endif;
                                                                                ?>
                                                                            </select>
                                                                        </td>

                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <input id="landInfoPricePerUOM1" name="landInfoPricePerUOM[]" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" />
                                                                                     <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger" id="landInfoPricePerUOMShow1"> / UOM</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:200px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                                    </div>
                                                                                    <input id="landInfoTotalPrice1" name="landInfoTotalPrice[]" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input id="landInfoRemarks1" name="landInfoRemarks[]" type="text" class="form-control" style="width:200px;" />
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" name="add" id="add" class="btn btn-warning" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()"><i class="fa fa-plus" aria-hidden="true"></i></button>
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
                                                                                    <input id="landInfoTotalCompletePrice" name="landInfoTotalCompletePrice" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()"  readonly />
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
                                        <div class="col-md-12">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Purchase Information</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseTotalPrice">Total Price</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control" min="0.00" step=any id="landPurchaseTotalPrice" name="landPurchaseTotalPrice" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseDealingPrice">Dealing Price</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger"> &#8377;</button>
                                                                    </div>
                                                                    <input type="number" class="form-control" min="0.00" step=any id="landPurchaseDealingPrice" name="landPurchaseDealingPrice">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="landPurchaseDealingPriceInWords">In Words</label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="landPurchaseDealingPriceInWords" name="landPurchaseDealingPriceInWords" readonly></textarea>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger"> Only</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseCondition">Condition</label>
                                                                <select id="landPurchaseCondition" name="landPurchaseCondition" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                                    <option disabled selected>Select</option>
                                                                    <?php 
                                                                        $databaseObj->select("tbl_land_purchase_condition");
                                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                                        $getData = $databaseObj->get();
                                                                        //Checking If Data Is Available
                                                                        if(count($getData) != 0):
                                                                            $sno = 1;
                                                                            foreach($getData as $rows):
                                                                                $land_purchase_condition_info = json_decode($rows["land_purchase_condition_info"]);
                                                                                ?>
                                                                                    <option value="<?= $rows["land_purchase_condition_id"] ?>"><?= $land_purchase_condition_info->landPurchaseCondition ?></option>
                                                                                <?php
                                                                            endforeach;
                                                                        endif;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseConditionAdd">Add Condition</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="" class="form-control" id="landPurchaseConditionAdd" name="landPurchaseConditionAdd" />
                                                                    <div class="input-group-prepend">
                                                                        <button id="landPurchaseConditionAddButton" type="button" class="btn btn-info"> <i class="fa fa-plus"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-navy" id="paymentStructureDiv">
                                                <div class="card-header">
                                                    <h3 class="card-title">Payment Structure</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 table-responsive">
                                                            <input type="hidden" value="1" id="totalNumberOfDivision" name="totalNumberOfDivision" />
                                                            <table class="table table-bordered table-striped dataTable" id="dynamic_field_2">
                                                                <thead>
                                                                    <th>S. No.</th>
                                                                    <th>When</th>
                                                                    <th>Date</th>
                                                                    <th>Percentage Of Amount</th>
                                                                    <th>Amount</th>
                                                                    <th>Remark</th>
                                                                    <th>Action</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><span class="p-3 mt-2">1.</span></td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureWhen1" name="landPurchasePaymentStuctureWhen[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureDate1" name="landPurchasePaymentStuctureDate[]" type="date" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:150px;">
                                                                                    <input id="landPurchasePaymentStuctureCompletion1" name="landPurchasePaymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();"/>
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger">%</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <div class="input-group" style="width:300px;">
                                                                                    <div class="input-group-prepend">
                                                                                        <button type="button" class="btn btn-danger">&#8377;</button>
                                                                                    </div>
                                                                                    <input id="landPurchasePaymentStuctureAmount1" name="landPurchasePaymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" readonly/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group mb-0">
                                                                                <input id="landPurchasePaymentStuctureRemark1" name="landPurchasePaymentStuctureRemark[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" name="add" id="add_2" class="btn btn-warning " onclick="calculateAmount();" onkeyup="calculateAmount();"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Attacments</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseAttacmentsImages">Images</label>
                                                                <div class="input-group">
                                                                    <input type="hidden" name="landPurchaseAttacmentsImagesAll" id="landPurchaseAttacmentsImagesAll">
                                                                    <input accept=".png, .jpg, .jpeg, .gif" type="file" class="form-control" min="0.00" step=any id="landPurchaseAttacmentsImages" name="landPurchaseAttacmentsImages[]" multiple>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger" id="landPurchaseAttacmentsImagesUploadButton"> <i class="fas fa-upload"></i> Upload</button>
                                                                    </div>
                                                                </div>
                                                                <small class="text-red">.png, .jpg, .jpeg and .gif format only</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseAttacmentsDocuments">Documents</label>
                                                                <div class="input-group">
                                                                    <input type="hidden" name="landPurchaseAttacmentsDocumentsAll" id="landPurchaseAttacmentsDocumentsAll">
                                                                    <input accept=".doc, .docx" type="file" class="form-control" min="0.00" step=any id="landPurchaseAttacmentsDocuments" name="landPurchaseAttacmentsDocuments[]" multiple>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger" id="landPurchaseAttacmentsDocumentsUploadButton"> <i class="fas fa-upload"></i> Upload</button>
                                                                    </div>
                                                                </div>
                                                                <small class="text-red">.doc and .docx format only</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseAttacmentsPdf">Pdf</label>
                                                                <div class="input-group">
                                                                    <input type="hidden" name="landPurchaseAttacmentsPdfAll" id="landPurchaseAttacmentsPdfAll">
                                                                    <input accept=".pdf" type="file" class="form-control" min="0.00" step=any id="landPurchaseAttacmentsPdf" name="landPurchaseAttacmentsPdf[]" multiple>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger" id="landPurchaseAttacmentsPdfUploadButton"> <i class="fas fa-upload"></i> Upload</button>
                                                                    </div>
                                                                </div>
                                                                <small class="text-red">.pdf format only</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="landPurchaseAttacmentsExcel">Other Excel</label>
                                                                <div class="input-group">
                                                                    <input type="hidden" name="landPurchaseAttacmentsExcelAll" id="landPurchaseAttacmentsExcelAll">
                                                                    <input accept=".xls, .xlsx, .csv" type="file" class="form-control" min="0.00" step=any id="landPurchaseAttacmentsExcel" name="landPurchaseAttacmentsExcel[]" multiple>
                                                                    <div class="input-group-prepend">
                                                                        <button type="button" class="btn btn-danger" id="landPurchaseAttacmentsExcelUploadButton"> <i class="fas fa-upload"></i> Upload</button>
                                                                    </div>
                                                                </div>
                                                                <small class="text-red">.xls, .xlsx and .csv format only</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 display-none" id="landPurchaseAttacmentsImagesPreview">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Images Preview</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row" id="landPurchaseAttacmentsImagesPreviewRow"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 display-none" id="landPurchaseAttacmentsDocumentsPreview">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Documents Preview</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row" id="landPurchaseAttacmentsDocumentsPreviewRow"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 display-none" id="landPurchaseAttacmentsPdfPreview">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Pdf Preview</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row" id="landPurchaseAttacmentsPdfPreviewRow"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 display-none" id="landPurchaseAttacmentsExcelPreview">
                                            <div class="card card-navy">
                                                <div class="card-header">
                                                    <h3 class="card-title">Excel Preview</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <div class="row" id="landPurchaseAttacmentsExcelPreviewRow"></div>
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
                                                <input type="file" class="form-control" id="importedExcel" name="importedExcel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                <small class="text-red text-sm">Before importing please check the excel format</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="importedExcel">See Format</label>
                                            <a href="assets/admin/land-acquisition-lands/default.xlsx" target="_blank" class="btn btn-warning btn-md btn-block"><i class="fa fa-eye fa-sm"></i> Format</a>
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
    <script src="dist/js/admin/land-acquisition-lands.js"></script>
    <script>
        $(function(){
            //Multiple Rows Section Start ------------------------------------------------------------------------------------------------------------------   
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
                for(j = 1; j <= Number($("#totalLandInfo").val()); j++){
                    if($("#landInfoType"+j).val() == ""){
                        $("#landInfoType"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#landInfoType"+j).removeClass("is-invalid");
                    if($("#landInfoArea"+j).val() == ""){
                        $("#landInfoArea"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#landInfoArea"+j).removeClass("is-invalid");
                    if($("#landInfoUOM"+j).val() == ""){
                        $("#landInfoUOM"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#landInfoUOM"+j).removeClass("is-invalid");
                    if($("#landInfoPricePerUOM"+j).val() == ""){
                        $("#landInfoPricePerUOM"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#landInfoPricePerUOM"+j).removeClass("is-invalid");
                    if($("#landInfoTotalPrice"+j).val() == ""){
                        $("#landInfoTotalPrice"+j).addClass("is-invalid");
                        temp_flag = 0;
                        temp_error = "Please complete required fields!!!";
                    }else
                        $("#landInfoTotalPrice"+j).removeClass("is-invalid");
                }
                if(temp_flag == 1){
                    i++; 
                    $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td> <td> <input id="landInfoType'+i+'" name="landInfoType[]" type="text" class="form-control" style="width:200px;" /> </td> <td> <input id="landInfoArea'+i+'" name="landInfoArea[]" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" style="width:150px;" /> </td> <td> <select id="landInfoUOM'+i+'" name="landInfoUOM[]" class="form-control select2 select2-navy" data-dropdown-css-class="select2-navy" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" style="width:100px;"> <option disabled selected>Select</option> <?php  $databaseObj->select("tbl_uom"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $uom_info = json_decode($rows["uom_info"]); ?> <option value="<?= $rows["uom_id"] ?>"><?= $uom_info->uom ?></option> <?php endforeach; endif; ?> </select> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <input id="landInfoPricePerUOM'+i+'" name="landInfoPricePerUOM[]" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" /> <div class="input-group-prepend"> <button type="button" class="btn btn-danger" id="landInfoPricePerUOMShow'+i+'"> / UOM</button> </div> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:200px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger"> &#8377;</button> </div> <input id="landInfoTotalPrice'+i+'" name="landInfoTotalPrice[]" type="number" min="0.00" step=any class="form-control" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()" readonly /> </div> </div> </td> <td> <input id="landInfoRemarks'+i+'" name="landInfoRemarks[]" type="text" class="form-control" style="width:200px;" /> </td> <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" onkeyup="calculate_amount()" onclick="calculate_amount()" onchange="calculate_amount()" onblur="calculate_amount()">X</button></td></tr>');
                    $('.select2').select2();
                    $("#totalLandInfo").val(i);
                } else{
                    topEndNotification("warning", temp_error);
                }
            });
            $(document).on('click', '.btn_remove', function(){  
               var button_id = $(this).attr("id");   
               $('#row'+button_id+'').remove(); 
               i--;
               $("#totalLandInfo").val(i);
               calculate_amount();
            }); 
            //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
        });
    </script>

    <!-- Js Section End -->
</body>

</html>