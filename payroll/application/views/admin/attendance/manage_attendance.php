<?php include($view_path.'admin/include/header.php'); ?>
<?php include($view_path.'admin/include/sidebar.php'); ?>
<div id="content" class="content">
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Manage Attendance</a></li>
    </ol>
    <h1 class="page-header">Manage Attendance

        <?php if($this->session->flashdata('msg')): ?>
        <?php echo $this->session->flashdata('msg'); ?>
        <?php endif; ?>
    </h1>
    <div class="row">

        <div class="col-xl-12">


            <div class="panel panel-inverse">

                <div class="panel-heading">

                    <h4 class="panel-title"><a href="<?php echo base_url(); ?>admin/Attendance/attendance_view"><button class="btn btn-success btn-sm">Add Attendance</button></a></h4>
                    <!-- <a href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Demo</a>
 -->
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    <?php
    if(!empty($msg)){
      echo "<p>".$msg."</p>";
    }
  ?>
                    <div class="col-md-4 form-inline">
                        <label class="control-label mr-2"><strong>Select Date:</strong></label>
                        <div class="form-group">
                            <input type="date" name="attendance_date" id="attendance_date" class="form-control datepicker" required>
                            <button class="btn btn-success btn-md ml-3" id="show">Show Attendance</button>
                        </div>

                    </div>

                    <br>
                    <form class="form-horizontal update_attendence_form" id="form_data" method="post" enctype="multipart/form-data">
                        <table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th data-field="id" class="text-center">S.NO</th>
                                    <th data-field="Employee Name" data-sortable="true">Employee Name</th>
                                    <th data-field="Attendance Status" data-sortable="true">Attendance Status</th>
                                    <th data-field="Comment" data-sortable="true">Comment</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                                <tr>
                                    <td colspan="6">
                                        <center><strong>PLEASE SELECT DATE</strong></center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" name="submit" value="Update Attendance" id="submit" class="btn btn-info" style="margin-top:10px;">
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
<?php include($view_path.'admin/include/footer.php'); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/js/demo/table-manage-buttons.demo.js"></script>
<script>
    $(document).ready(function() {
        $("#show").click(function() {
            attendance_date = $('#attendance_date').val();
            //alert(attendance_date);
            $.ajax({
                url: "<?php echo base_url();?>admin/Attendance/show_attendance_data/",
                method: "POST",
                data: {
                    "attendance_date": attendance_date
                },
                success: function(data) {
                    $("#tbl_body").html(data);
                }
            })
        });
        $('.update_attendence_form').on('submit', function() {
            var form_data = $(this).serialize();
            $.ajax({
                url: "<?php echo base_url(); ?>admin/Attendance/edit_emp_attendence",
                method: "POST",
                data: form_data,
                success: function(data) {
                    var response = JSON.parse(data);
                    console.log(response);
                   alert(response.msg);
                }
            })
            return false;
        })
    });
</script>

<!-- datatable links  start-->
        <script src="<?php echo base_url() ?>/assets/plugins/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/build/pdfmake.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>/assets/plugins/jszip/dist/jszip.min.js" type="text/javascript"></script> 
    <!-- datatable links end -->