<!-- Supplier Management -->
<?php
    $page_no = "4";
    $page_no_inside = "4_5";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | New Supplier</title>
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
                            <h1 class="m-0 text-dark">New Vendors/Suppliers</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Item Vendors/Suppliers</li>
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
                           <!--  <button id="add-button" type="button" class="add-button btn btn-sm btn-success mt-1 mb-1" data-toggle="modal" data-target="#add-modal" title="Add New" disabled>
                                <i class="fa fa-plus fa-sm"></i> Add New
                            </button> -->
                           <!--  <button id="import-button" type="button" class="import-button btn btn-sm btn-info mt-1 mb-1" data-toggle="modal" data-target="#import-modal" title="Import" disabled>
                                <i class="fa fa-upload fa-sm"></i> Import
                            </button> -->
                            <button id="export-button" type="button" class="export-button btn btn-sm btn-warning display-none mt-1 mb-1" data-toggle="modal" data-target="#export-modal" title="Export" disabled>
                                <i class="fa fa-download fa-sm"></i> Export
                            </button>
                            <button id="delete-button" type="button" class="delete-button btn btn-sm btn-danger display-none mt-1 mb-1" data-toggle="modal" data-target="#delete-selected-modal" title="Delete" disabled>
                                <i class="fa fa-trash fa-sm"></i> Delete
                            </button>
                        </h3>
                    </div>
                    <!-- Start table View  -->
                    <div class="card-body table-responsive" id="view-section"></div>
                    <!-- end table View -->
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierName">Supplier/Vendor Name</label>
                                                <input type="text" class="form-control" id="supplierName" name="supplierName" placeholder="Supplier Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierCity">City</label>
                                                <input type="text" class="form-control" id="supplierCity" name="supplierCity" placeholder="Supplier City">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierState">State</label>
                                                <input type="text" class="form-control" id="supplierState" name="supplierState" placeholder="Supplier State">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierCountry">Country</label>
                                                <input type="text" class="form-control" id="supplierCountry" name="supplierCountry" placeholder="Supplier Country">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="supplierAddress">Supplier Address</label>
                                                <textarea class="form-control" id="supplierAddress" name="supplierAddress" placeholder="Supplier Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierConcernPersonName">Concern Person Name</label>
                                                <input type="text" class="form-control" id="supplierConcernPersonName" name="supplierConcernPersonName" placeholder="Concern Person Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierOfficePhone">Office Number</label>
                                                <input type="number" class="form-control" id="supplierOfficePhone" name="supplierOfficePhone" placeholder="Supplier Office Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierPhone">Phone</label>
                                                <input type="number" class="form-control" id="supplierPhone" name="supplierPhone" placeholder="Supplier Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierAlternatePhone">Alternate Phone</label>
                                                <input type="number" class="form-control" id="supplierAlternatePhone" name="supplierAlternatePhone" placeholder="Supplier Alternate Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierEmail">Email</label>
                                                <input type="email" class="form-control" id="supplierEmail" name="supplierEmail" placeholder="Supplier Email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplierGstin">GSTIN</label>
                                                <input type="text" class="form-control" id="supplierGstin" name="supplierGstin" placeholder="Supplier Gstin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="addButton" class="add-button btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add Item</button>
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
                                            <a href="assets/admin/manage-items/defaultSupplier.xlsx" target="_blank" class="btn btn-warning btn-md btn-block"><i class="fa fa-eye fa-sm"></i> Format</a>
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
    <script src="dist/js/admin/new-supplier.js"></script>
    <!-- Js Section End -->
</body>

</html>