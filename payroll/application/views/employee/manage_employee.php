
<div id="content" class="content">

<ol class="breadcrumb float-xl-right">
<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
<li class="breadcrumb-item"><a href="javascript:;">Managed Employees</a></li>
</ol>


<h1 class="page-header">&nbsp;&nbsp;&nbsp; <!-- Managed Employees --></h1>

<div class="row">
<div class="col-xl-12">


<div class="panel panel-inverse">

<div class="panel-heading">

<h4 class="panel-title">Managed Employees</h4>
<!-- <a href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Demo</a>
 --><div class="panel-heading-btn">
<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
</div>
</div>



<div class="panel-body">
<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
<thead>
<tr>
<th class="text-nowrap">S NO</th>
<!-- <th width="1%" data-orderable="false"></th>
 -->
 <th class="text-nowrap">Full Name</th>
<th class="text-nowrap">Employee ID</th>
<th class="text-nowrap">Email</th>
<th class="text-nowrap">Department</th>
<th class="text-nowrap">Date of Hire</th>
<th class="text-nowrap">City</th>
<th class="text-nowrap">Status</th>
<th class="text-nowrap">Image</th>
<th class="text-nowrap">Action</th>


</tr>
</thead>
<tbody>
    <?php
   
    $sno = 1;
    if(!empty($employee))
    {

    foreach($employee as $row)
    {

    ?>  

<tr>
                      <td><?php echo $sno++; ?></td>
                      <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                      <td><?php echo $row->employee_id; ?></td>
                      <td><?php echo $row->email; ?></td>
                      <td><?php echo $row->department; ?></td>
                      <td><?php echo $row->date_of_hire; ?></td>
                      <td><?php echo $row->city; ?></td>
                      <td><?php echo $row->emp_status; ?></td>
                     <td><img src="<?php echo base_url(); ?>upload/employee/<?php echo $row->image; ?>" height="120px" width="120px"/></td>

                      

                      <td>
                      <!--<a rel="tooltip" title="View" class="btn btn-link btn-info table-action view" href="single_client_view/<?php echo $row->id;?>">
                      <i class="fa fa-image"></i>
                      </a>-->

                      <a rel="tooltip" title="Edit" class="btn btn-link btn-warning table-action edit" href="edit_employee/<?php echo $row->id;?>">
                      <i class="fa fa-edit"></i>
                      </a>


                      <a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" onClick="return confirm('Are you sure you want to delete?')" href="delete_employee/<?php echo $row->id;?>">
                                             <i class="fa fa-trash"></i>            
                       </a>
                      </td>
                  
                      </tr>

                      <?php
                        } 
                    }
                    else
                    {
                    ?>
                    <tr><td colspan="10"><center><strong>NO RECORD FOUND</strong></center></td></tr>
                    <?php
                    }
                    ?>

          </tbody>
          </table>
          </div>

          </div>

          </div>

          </div>

          </div>


<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

</div>


<script>


$(function() {

  $("#modal-dialog").validate({
    rules: {
      company_name: {
        required: true,
        
      },
      action: "required"
    },
    
      address: {
      
        required: true,
      },
     action: "required"
   
  });
});


function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<div class="modal fade" id="modal-dialog">
            <div class="modal-dialog modal-lg">
<!--                 <form id="addForm" method="POST" enctype="multipart/form-data">
 -->                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Company</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                   <form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Company/add_company">

                        <div class="modal-body">
                            <div class="card card-navy card-outline">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Company Name"><strong>Company Name</strong></label>
                                                <input type="text" class="form-control" id="itemCode" name="company_name" placeholder="Company Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Address"><strong>Address</strong></label>
                                             
                                            <textarea  class="form-control" id="address" name="address"></textarea>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="GSTIN"><strong>GSTIN</strong></label>
                                                <input type="text" class="form-control" id="itemCode" name="gstin" placeholder="Company Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="itemName"><strong>Mobile No.</strong></label>
                                                <input type="text" class="form-control" id="address" name="contact_no" placeholder="Mobile No" required>
                                            </div>
                                        </div>



                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="GSTIN"><strong>Bank Name</strong></label>
                                                <input type="text" class="form-control" id="Bank Name" name="bank_name" placeholder="Bank Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="itemName"><strong>Branch</strong></label>
                                                <input type="text" class="form-control" id="branch" name="branch" placeholder="Branch">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="GSTIN"><strong>IFC Code</strong></label>
                                                <input type="text" class="form-control" id="Bank Name" name="ifc_code" placeholder="Bank Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="itemName"><strong>Account No.</strong></label>
                                                <input type="text" class="form-control" id="branch" name="account_no" placeholder="Account No">
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                         <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                       <input type="submit"  name="submit" Value="submit"  class="btn btn-success">

                       </div>
                       </form>
                    </div>
                
            </div>
        </div>