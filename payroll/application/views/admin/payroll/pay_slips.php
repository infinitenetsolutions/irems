<?php 

   // require_once("./classes-and-objects/config.php");
   // require_once("./classes-and-objects/veriables.php");
   // require_once("./classes-and-objects/authentication.php");

   // $auth = new AUTHENTICATION($databaseObj);

?>



<link href="<?=base_url()?>assets/plugins/datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css" rel="stylesheet" />
<div id="content" class="content">
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Pay Slips</a></li>
  </ol>
  <h1 class="page-header">Pay Slips</h1>
  <?php if($this->session->flashdata('msg')): ?>
  <?php echo $this->session->flashdata('msg'); ?>
  <?php endif; ?>
  <div class="row">
    <div class="col-xl-12">
      <div class="panel panel-inverse">
        <div class="panel-heading">
          <h4 class="panel-title">&nbsp;&nbsp;&nbsp;&nbsp;</h4> 
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
          <div class="row">
            <?php
            
     
            //$databaseObj->select("tbl_manage_department");
            //$databaseObj->where("`status` = '".$auth->visible()."'");
           //$getData = $databaseObj->get();
            ?>
           
            <div class="col-md-3">
              <label class="control-label mr-2"><strong>Department:</strong></label>
              <select class="form-control" name="department" id="department">
                <option value="" disabled selected> Select Department </option>
                <option value="all"> All </option>
                <?php
                foreach ($department as $depart) {  
                             
                $manage_department_info= json_decode($depart["manage_department_info"]); ?>

                <option value="<?php echo $depart['manage_department_id'];?>"> <?php echo $manage_department_info->departmentName;?> </option>
                <?php } ?>
                
                
               
              </select>
            </div>
            <div class="col-md-3">
              <label class="control-label mr-2"><strong>Designation:</strong></label>
              <select class="form-control" name="designation" id="designation">
                <option value="" disabled selected> Select Designation </option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="control-label mr-2"><strong>Employee Name:</strong></label>
              <div class="form-group">
                <select class="form-control" name="employee_id" id="employee_id">
                  <option value="" disabled selected> Select Employee </option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <label class="control-label mr-2"><strong>Year:</strong></label>
              <select class="form-control" name="year" id="year">
                <option value="" disabled selected> Select Year </option>
                <?php
                foreach ( range( date('Y') , 1950 ) as $i ) {
                ?>
                <option value="<?php echo $i;?>"> <?php echo $i;?> </option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="control-label mr-2"><strong>Month:</strong></label>
              <select class="form-control" name="month" id="month">
                <option value="" disabled selected> Select Month </option>
                <?php for ( $i = 1; $i <= 12; $i ++ ) {
                echo '<option value="' . $i . '">' . date( 'F', strtotime( "$i/12/10" ) ) . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <button class="btn btn-success btn-md mt-4" id="show_payslip">Show Pay Slips</button>
              </div>
            </div>
            <div class="col-12 table-responsive" id="attandance_report_table">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include($view_path.'admin/include/footer.php') ?>

<!-- datatable links  start-->
<script src="<?php echo base_url() ?>assets/plugins/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/pdfmake/build/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/jszip/dist/jszip.min.js" type="text/javascript"></script>

<script type="text/javascript">
function checkAll(ele) {
  var checkboxes = document.getElementsByTagName('input');
  if (ele.checked) {
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].type == 'checkbox') {
        checkboxes[i].checked = true;
      }
    }
  } else {
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].type == 'checkbox') {
        checkboxes[i].checked = false;
      }
    }
  }
}
  
      $('#incentive').keyup(function(event) { 
        alert('You released a key'); 
        //$('#empid_msg').html('You released a key');
          employee_id=$('#employee_id').val();
          //alert(employee_id);
                    $.ajax({
                          url:"<?php echo base_url();?>Payroll/employee_id_exist/",
                          method:"POST",
                          data:{"employee_id":employee_id},
                          success:function(data)
                          {
                             $('#empid_msg').html(data);
                          }
                   })
    });
  
  
  
  
  
  
  
  
  
$("#show_payslip").click(function () {
  var department_id = $('#department').val();
  var designation_id = $('#designation').val();
  var employee_id = $('#employee_id').val();
  var year = $('#year').val();
  var month = $('#month').val(); // return 2018-10-21
  if ((department_id == null) || (designation_id == null) || (employee_id == null) || (year == null) || (month == null)) {
    alert('Please Select Department, Designation, Employee, Year and Month ');
  } else {
    $.ajax({
      url: "<?php echo base_url();?>admin/Payroll/show_payslip_view/",
      method: "POST",
      data: {
        "department_id": department_id,
        "designation_id": designation_id,
        "employee_id": employee_id,
        "year": year,
        "month": month
      },
      success: function (data) {
        $("#attandance_report_table").html(data);
        $('#data-table-buttons').DataTable({
        scrollY: 300,
        scrollX: true,
        bSort:false,
          dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
          buttons: [{
            extend: 'excel',
            exportOptions: {
              columns: ':visible'
            },
            className: 'btn-sm'
          }, {
            extend: 'pdf',
            exportOptions: {
              columns: ':visible'
            },
            className: 'btn-sm'
          }, {
            extend: 'print',
            exportOptions: {
              columns: ':visible'
            },
            className: 'btn-sm'
          }, {
            extend: 'colvis',
            className: 'btn-sm'
          }],
        });
      }
    });
  }


});
// function for convert string to date formateS
function getDateYMD(strDate) {
  var date = new Date(strDate);
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  if (day < 10) {
    day = "0" + day;
  }
  if (month < 10) {
    month = "0" + month;
  }
  var date = year + "-" + month + "-" + day;
  return date;
}

$('#department').change(function () {
  var dept_id = $('#department').val();
  if (dept_id != '') {
    $.ajax({
      url: "<?php echo base_url(); ?>admin/Payroll/fetch_designation",
      method: "POST",
      data: {
        "dept_id": dept_id
      },
      success: function (data) {
        $('#designation').html(data);
      }
    });
  }
});
$('#designation').change(function () {
  var design_id = $('#designation').val();
  if (design_id != '') {
    $.ajax({
      url: "<?php echo base_url(); ?>admin/Payroll/fetch_employee_name",
      method: "POST",
      data: {
        "design_id": design_id
      },
      success: function (data) {
        $('#employee_id').html(data);
      }
    });
  } else {
    $('#employee_id').html('<option value="">Select Employees</option>');
  }
});
</script>
