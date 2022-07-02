<!-- Projects -->
<?php 
    $page_no = "2";
    $page_no_inside = "2_5";
?>
<?php require_once("include/auth.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Projects</title>
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
                            <h1 class="m-0 text-dark">Projects</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Projects</li>
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
                                        <input type="hidden" value="1" id="totalProperty" name="totalProperty" />
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="firmName">Firm Name</label>
                                                <select id="firmName" name="firmName" class="form-control form-control-sm select2 select2-navy" data-dropdown-css-class="select2-navy">
                                                    <option disabled selected>Select</option>
                                                    <?php 
                                                        $databaseObj->select("tbl_manage_company");
                                                        $databaseObj->where("`status` = '".$auth->visible()."'");
                                                        $getData = $databaseObj->get();
                                                        //Checking If Data Is Available
                                                        if($getData != 0):
                                                            $sno = 1;
                                                            foreach($getData as $rows):
                                                                $manage_company_info = json_decode($rows["manage_company_info"]);
                                                                ?>
                                                                    <option value="<?= $rows["manage_company_id"] ?>"><?= $manage_company_info->companyName ?></option>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                  </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectName">Project Name</label>
                                                <input type="text" class="form-control form-control-sm" id="projectName" name="projectName" placeholder="Project Name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectLocation">Project Location</label>
                                                <input type="text" class="form-control form-control-sm" id="projectLocation" name="projectLocation" placeholder="Project Location">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="projectLocationMapUrl">Project Location Map URL</label>
                                                <input type="text" class="form-control form-control-sm" id="projectLocationMapUrl" name="projectLocationMapUrl" placeholder="Project Location Map URL">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectStartingDate">Project Starting Date</label>
                                                <input type="date" class="form-control form-control-sm" id="projectStartingDate" name="projectStartingDate" placeholder="Project Starting Date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectExpectedEndingDate">Project Expected Ending Date</label>
                                                <input type="date" class="form-control form-control-sm" id="projectExpectedEndingDate" name="projectExpectedEndingDate" placeholder="Project Expected Ending Date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectEndingDate">Project Ending Date</label>
                                                <input type="date" class="form-control form-control-sm" id="projectEndingDate" name="projectEndingDate" placeholder="Project Ending Date" readonly>
                                                <small class="text-red">Define this date after the completion of project</small>
                                            </div>
                                        </div>
                                      
                                      <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Project Status</label>
                                              <select name="projectstatus" class="form-control form-control-sm">
                                                <option value="">Select Project Status</option>
                                                 <option value="On Going">On Going</option>
                                                <option value="Completed">Completed</option>
                                                </select>
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
                                            <a href="assets/admin/projects/default.xlsx" target="_blank" class="btn btn-warning btn-md btn-block"><i class="fa fa-eye fa-sm"></i> Format</a>
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
            <div class="modal-dialog modal-xl">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit This</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-section"></div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="editButton" class="edit-button btn btn-warning btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Section End -->
        <!-- Add Property Section Start -->
        <div class="modal fade" id="add-properties-modal">
            <div class="modal-dialog modal-xl">
                <form id="addPropertiesForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="properties_project_id" id="properties_project_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Property | <span id="show-project-name"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="add-properties-section"></div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="addPropertiesButton" class="btn btn-success btn-sm"><i class="fa fa-plus fa-sm"></i> Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add Property Section End -->
        <!-- Edit Property Section Start -->
        <div class="modal fade" id="properties-modal">
            <div class="modal-dialog modal-xl">
                <form id="editPropertiesForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Property | <span id="edit-show-project-name"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="properties-section"></div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" id="delete-property-button" class="delete-property-button btn btn-danger btn-sm" data-properties-id=""><i class="fas fa-trash fa-sm"></i> Delete This</button>
                            <button type="submit" id="editPropertiesButton" class="btn btn-success btn-sm"><i class="fa fa-upload fa-sm"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Property Section End -->
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
        <!-- Delete Property Section Start -->
        <div class="modal fade" id="delete-properties-modal">
            <div class="modal-dialog modal-sm">
                <form id="deletePropertiesForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="delete-properties-section"></div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="close-button btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times fa-sm"></i> Close</button>
                            <button type="submit" id="deletePropertiesButton" class="delete-properties-button btn btn-warning btn-sm"><i class="fas fa-trash fa-sm"></i> Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Delete Property Section End -->
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
    <script src="dist/js/admin/projects.js"></script>
    <script>
        $(function(){
            //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
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
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //

            // Auto Add Floors Section Start -----------------------------------------------------------------------------------------------------------------
            $(document).on("click change blur", ".dynamic-floor", function(){
                var total_floor = $("#main_row").attr("data-total-sub-row");
                if(Number($("#floor").val()) == 0)
                   $("#floor").val(" ");
                if($("#phase").val() != null && $("#building").val() != null){
                    if(Number($(this).val()) != Number(total_floor)) {
                        if(Number($(this).val()) > Number(total_floor))
                            for (var x = (Number(total_floor) + 1); x <= Number($(this).val()); x++){
                                $("#main_row_body").append('<div class="col-md-12" id="floor_row_'+ x +'"  data-floor-row-id="'+ x +'"> <div class="card card-navy"> <div class="card-header"> <h3 class="card-title" id="floor_row_sno_'+ x +'">Floor | '+ x +'  </h3> <div class="card-tools"> <button type="button" class="btn btn-tool" data-card-widget="collapse"  data-floor-row-id="'+ x +'"><i class="fas fa-minus"></i></button> </div> </div> <div class="card-body" id="floor_row_body_'+ x +'"> <div class="row"> <div class="table-responsive" id="floor_row_table_'+ x +'"> <table class="table table-bordered table-striped border-radius"> <thead> <tr> <th>S.No.</th> <th>Flat Number</th> <th>Property Type</th> <th>Accommodation Type</th> <th>Total Area Sq.ft<br/>(S.B. Area)</th> <th>Price / Sq.ft</th> <th>Total Price</th> <th>Carpet Area Sq.ft</th> <th>Starting Date</th> <th>Expected Ending Date</th> <th>Ending Date</th> <th>% Of Completion</th> <th>Action</th> </tr>  </thead> <tbody id="flat_row_'+ x +'"  data-floor-row-id="'+ x +'" data-total-flat-row="1"> <tr id="row_id_'+ x +'_1"> <td class="text-bold" id="flat_sno_'+ x +'_1"> 1. </td> <td> <input  id="flat_no_'+ x +'_1" name="flat_no_'+ x +'[]" type="text"  class="form-control form-control-sm main-rows flat-nos"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:100px;" /> </td> <td> <select id="property_type_'+ x +'_1" name="property_type_'+ x +'[]" class="form-control form-control-sm main-rows select2 select2-navy"  data-floor-row-id="'+ x +'" data-flat-row-id="1" data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Property</option> <?php  $databaseObj->select("tbl_property_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $property_type_info = json_decode($rows["property_type_info"]); ?> <option value="<?= $rows["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option> <?php endforeach; endif; ?> </select> </td> <td> <select id="accommodation_type_'+ x +'_1" name="accommodation_type_'+ x +'[]" class="form-control form-control-sm main-rows select2 select2-navy"  data-floor-row-id="'+ x +'" data-flat-row-id="1"  data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Accommodation</option> <?php  $databaseObj->select("tbl_accommodation_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $accommodation_type_info = json_decode($rows["accommodation_type_info"]); ?> <option value="<?= $rows["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option> <?php endforeach; endif; ?> </select> </td> <td> <input id="square_feet_'+ x +'_1" name="square_feet_'+ x +'[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" /> </td> <td> <input id="price_per_square_'+ x +'_1" name="price_per_square_'+ x +'[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" /> </td> <td> <input id="price_total_'+ x +'_1" name="price_total_'+ x +'[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" readonly /> </td> <td> <input id="carpet_area_'+ x +'_1" name="carpet_area_'+ x +'[]" type="number" min="0" class="form-control form-control-sm"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;" /> </td> <td> <input id="starting_date_'+ x +'_1" name="starting_date_'+ x +'[]" type="date" class="form-control form-control-sm main-rows"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:180px;" /> </td> <td> <input id="expected_ending_date_'+ x +'_1" name="expected_ending_date_'+ x +'[]" type="date" class="form-control form-control-sm main-rows"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:180px;" /> <small class="text-red">Tentative date to complete </small> </td> <td> <input id="ending_date_'+ x +'_1" name="ending_date_'+ x +'[]" type="date" class="form-control form-control-sm"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:180px;"  /> <small class="text-red">When this property will completed</small> </td> <td> <input id="percent_completed_'+ x +'_1" name="percent_completed_'+ x +'[]" type="number" min="0.00" max="100.00" step=any class="form-control form-control-sm main-rows input-percentage"  data-floor-row-id="'+ x +'" data-flat-row-id="1" style="width:150px;"  /> <small class="text-red">Percantage of completion </small> </td> <td> <button  data-floor-row-id="'+ x +'" data-flat-row-id="1" type="button" class="btn btn-sm btn-warning add-flat-row"> <i class="fa fa-plus"></i> </button> </td> </tr> </tbody> </table> </div> </div> </div> </div> </div>');
                                $(".select2").select2();
                            }
                        else
                            for (var x = (Number($(this).val()) + 1); x <= Number(total_floor); x++)
                                $("#floor_row_"+ x).remove();
                            // floor_row_1_1
                        $("#main_row").attr("data-total-sub-row", Number($(this).val()));
                    }
                } else{
                    $(this).val("");
                    topEndNotification("warning", "Please complete the rest fields...");
                }
            });
            // Auto Add Floors Section End -----------------------------------------------------------------------------------------------------------------

            // Add More Flat Section Start -----------------------------------------------------------------------------------------------------------------
            // var i = 1;
            $(document).on("click", ".add-flat-row", function(){
                var flag = 1;
                var floor_row_id = $(this).attr("data-floor-row-id");
                var total_flat = $("#flat_row_"+ floor_row_id).attr("data-total-flat-row");
                $(".main-rows").each(function(){
                    if($(this).val() == "" || $(this).val() == null){
                        flag = 0;
                        $(this).addClass("is-invalid");
                    } else
                        $(this).removeClass("is-invalid");
                });
                if(flag == 1){
                    total_flat++;
                    $("#flat_row_"+ floor_row_id).append('<tr id="row_id_'+ floor_row_id +'_'+ total_flat +'"> <td class="text-bold" id="flat_sno_'+ floor_row_id +'_'+ total_flat +'"> '+ total_flat +'. </td> <td> <input  id="flat_no_'+ floor_row_id +'_'+ total_flat +'" name="flat_no_'+ floor_row_id +'[]" type="text"  class="form-control form-control-sm main-rows flat-nos" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:100px;" /> </td> <td> <select id="property_type_'+ floor_row_id +'_'+ total_flat +'" name="property_type_'+ floor_row_id +'[]" class="form-control form-control-sm main-rows select2 select2-navy" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Property</option> <?php  $databaseObj->select("tbl_property_type"); $databaseObj->where("`status` = '".$auth->visible()."'");  $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $property_type_info = json_decode($rows["property_type_info"]); ?> <option value="<?= $rows["property_type_id"] ?>"><?= $property_type_info->propertyType ?></option> <?php endforeach;  endif; ?> </select> </td> <td> <select id="accommodation_type_'+ floor_row_id +'_'+ total_flat +'" name="accommodation_type_'+ floor_row_id +'[]" class="form-control form-control-sm main-rows select2 select2-navy" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'"  data-dropdown-css-class="select2-navy" style="width:200px;"> <option disabled selected>Select Accommodation</option> <?php  $databaseObj->select("tbl_accommodation_type"); $databaseObj->where("`status` = '".$auth->visible()."'"); $getData = $databaseObj->get(); if($getData != 0): $sno = 1; foreach($getData as $rows): $accommodation_type_info = json_decode($rows["accommodation_type_info"]); ?> <option value="<?= $rows["accommodation_type_id"] ?>"><?= $accommodation_type_info->accommodationType ?></option> <?php endforeach; endif; ?> </select> </td> <td> <input id="square_feet_'+ floor_row_id +'_'+ total_flat +'" name="square_feet_'+ floor_row_id +'[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" /> </td> <td> <input id="price_per_square_'+ floor_row_id +'_'+ total_flat +'" name="price_per_square_'+ floor_row_id +'[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" /> </td> <td> <input id="price_total_'+ floor_row_id +'_'+ total_flat +'" name="price_total_'+ floor_row_id +'[]" type="number" min="0.00" step=any class="form-control form-control-sm main-rows calculate-amount-now" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" readonly /> </td> <td> <input id="carpet_area_'+ floor_row_id +'_'+ total_flat +'" name="carpet_area_'+ floor_row_id +'[]" type="number" min="0" class="form-control form-control-sm" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;" /> </td> <td> <input id="starting_date_'+ floor_row_id +'_'+ total_flat +'" name="starting_date_'+ floor_row_id +'[]" type="date" class="form-control form-control-sm main-rows" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:180px;" /> </td> <td>  <input id="expected_ending_date_'+ floor_row_id +'_'+ total_flat +'" name="expected_ending_date_'+ floor_row_id +'[]" type="date" class="form-control form-control-sm main-rows" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:180px;" /> <small class="text-red">Tentative date to complete </small>  </td> <td> <input id="ending_date_'+ floor_row_id +'_'+ total_flat +'" name="ending_date_'+ floor_row_id +'[]" type="date" class="form-control form-control-sm" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:180px;"  /> <small class="text-red">When this property will completed</small> </td> <td> <input id="percent_completed_'+ floor_row_id +'_'+ total_flat +'" name="percent_completed_'+ floor_row_id +'[]" type="number" min="0.00" max="100.00" step=any class="form-control form-control-sm main-rows input-percentage" data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" style="width:150px;"  /> <small class="text-red">Percantage of completion </small> </td> <td> <button data-floor-row-id="'+ floor_row_id +'" data-flat-row-id="'+ total_flat +'" type="button" class="btn btn-sm btn-danger remove-flat-row"> <i class="fa fa-times"></i> </button> </td> </tr>');
                    $(".select2").select2();
                    $("#flat_row_"+ floor_row_id).attr("data-total-flat-row", total_flat);
                } else
                    topEndNotification("warning", "Please complete the rest fields...");
            }); 
            $(document).on("click", ".remove-flat-row", function(){
                var row_id = $(this).attr("data-flat-row-id");
                var main_row_id = $(this).attr("data-main-row-id");
                var floor_row_id = $(this).attr("data-floor-row-id");
                var total_flat = $("#flat_row_"+ floor_row_id).attr("data-total-flat-row");
                $("#row_id_"+ floor_row_id +"_"+ row_id).remove();
                if(Number(row_id) == Number(total_flat)){
                    total_flat--;
                    $("#flat_row_"+ floor_row_id).attr("data-total-flat-row", total_flat);
                }
                else{
                    for (var j = Number(row_id); j <= Number(total_flat); j++){
                        $("#flat_sno_"+ floor_row_id +"_"+ (j + 1)).attr("id", "flat_sno_"+ floor_row_id +"_"+ j)
                            .html(j + ". ");
                        $("#row_id_"+ floor_row_id +"_"+ (j + 1)).attr("id", "row_id_"+ floor_row_id +"_"+ j)
                            .find("*")
                            .attr("data-flat-row-id", j);
                        $("#flat_sno_"+ floor_row_id +"_"+ (j + 1)).attr("id", "flat_sno_"+ floor_row_id +"_"+ j);
                        $("#flat_no_"+ floor_row_id +"_"+ (j + 1)).attr("id", "flat_no_"+ floor_row_id +"_"+ j);
                        $("#property_type_"+ floor_row_id +"_"+ (j + 1)).attr("id", "property_type_"+ floor_row_id +"_"+ j);
                        $("#accommodation_type_"+ floor_row_id +"_"+ (j + 1)).attr("id", "accommodation_type_"+ floor_row_id +"_"+ j);
                        $("#square_feet_"+ floor_row_id +"_"+ (j + 1)).attr("id", "square_feet_"+ floor_row_id +"_"+ j);
                        $("#price_per_square_"+ floor_row_id +"_"+ (j + 1)).attr("id", "price_per_square_"+ floor_row_id +"_"+ j);
                        $("#price_total_"+ floor_row_id +"_"+ (j + 1)).attr("id", "price_total_"+ floor_row_id +"_"+ j);
                        $("#carpet_area_"+ floor_row_id +"_"+ (j + 1)).attr("id", "carpet_area_"+ floor_row_id +"_"+ j);
                        $("#starting_date_"+ floor_row_id +"_"+ (j + 1)).attr("id", "starting_date_"+ floor_row_id +"_"+ j);
                        $("#expected_ending_date_"+ floor_row_id +"_"+ (j + 1)).attr("id", "expected_ending_date_"+ floor_row_id +"_"+ j);
                        $("#ending_date_"+ floor_row_id +"_"+ (j + 1)).attr("id", "ending_date_"+ floor_row_id +"_"+ j);
                        $("#percent_completed_"+ floor_row_id +"_"+ (j + 1)).attr("id", "percent_completed_"+ floor_row_id +"_"+ j);
                    }
                    total_flat--;
                    $("#flat_row_"+ floor_row_id).attr("data-total-flat-row", total_flat);
                }
            });
            // Add More Flat Section End -----------------------------------------------------------------------------------------------------------------


            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
            // *********************************************************************************************************** //
        });                                               
    </script>
    <!-- Js Section End -->
</body>

</html>