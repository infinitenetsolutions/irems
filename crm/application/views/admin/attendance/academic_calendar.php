         <div id="content" class="content">
             <ol class="breadcrumb float-xl-right">
                 <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                 <li class="breadcrumb-item"><a href="javascript:;">Financial Calendar</a></li>
             </ol>
             <h1 class="page-header">Financial Calendar</h1>

             <?php if($this->session->flashdata('success')): ?>
             <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
             <?php endif; ?>
             <?php if($this->session->flashdata('danger')): ?>
             <p class="alert alert-danger"><?php echo $this->session->flashdata('danger'); ?></p>
             <?php endif; ?>
             
             <div class="row">
                 <div class="col-xl-12">
                     <div class="panel panel-inverse">
                         <div class="panel-heading">
                             <h4 class="panel-title"><div class="col-md-4 form-inline">
                                         <label class="control-label mr-4"><strong>Select Year:</strong></label>
                                         <select class="form-control" name="year" id="year">
                                             <option value="" disabled selected> Select Year </option>
                                             <?php
                                                foreach ( range( date('Y') , 2015) as $i ) {
                                              ?>
                                             <option value="<?php echo $i;?>"> <?php echo $i;?> </option>
                                             <?php } ?>
                                         </select>
                                     </div></h4>
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
                          <form class="form-horizontal" id="calender_data" action="<?php echo base_url();?>admin/Attendance/add_calender_date" method="post" enctype="multipart/form-data">
                            <div id="table_body" class="table-responsive">

                            </div>
                           
                           </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
             
                $("#year").change(function() {
                    acedemic_year = $('#year').val();
                    // alert(acedemic_year);
                    $.ajax({
                        url: "<?php echo base_url();?>admin/Attendance/show_acedemic_calender/",
                        method: "POST",
                        data: {
                            "acedemic_year": acedemic_year
                        },
                        success: function(data) {
                          //alert(data);
                            $("#table_body").html(data);
                        }
                    })
                });
            });
            function calc_total_days(i) {
             var total_day=document.getElementById("total_day_"+i).value;
              var total_sunday=document.getElementById("total_sunday_"+i).value;
               var other_paid_leaves =document.getElementById("other_paid_leaves_"+i).value;             
              var total_work_day=parseInt(total_day)-(parseInt(total_sunday)+parseInt(other_paid_leaves));
              document.getElementById("total_work_day_"+i).value=(total_work_day<1)?'0':total_work_day;
            }
            function ontable_load(){
              alert('hrllo');
              for(i=1;i<=12;i++)
              {
               calc_total_days(i); 
              }
            }
             
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