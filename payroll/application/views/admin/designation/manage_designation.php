<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<div id="content" class="content">

<ol class="breadcrumb float-xl-right">
<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
<li class="breadcrumb-item"><a href="javascript:;">Manage Designations</a></li>
</ol>
<h1 class="page-header">Manage Designations</h1>
<div class="row">
<div class="col-xl-12">
<div class="panel panel-inverse">
<div class="panel-heading">

<h4 class="panel-title"><button href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Add Designations</button></h4>
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
  <th class="text-nowrap">Department</th>
 <th class="text-nowrap">Designations</th>
<th class="text-nowrap">Action</th>

</tr>
</thead>
<tbody>
    <?php
    $cnt = 1;
    if(!empty($designation))
    {

    foreach($designation as $row)
    {

    ?>  
                       <tr>
                      <td><?php echo $cnt++; ?></td>
                      <td><select name="dept_id" class="form-control" id="edit_department_<?php echo $row->id; ?>">
                      <?php foreach($department as $value)
                      { ?>
                      <option value="<?php echo $value->id; ?>" <?php if($value->department_name==$row->department_name){echo "selected";} ?>><?php echo $value->department_name; ?></option>
                       <?php
                         }  ?></select></td>
                      <td> <input class="form-control" type="text" name="designation" id="edit_designation_<?php echo $row->id; ?>" value="<?php echo $row->designation; ?>" required="true"></td>

                      <td>
                      <!--<a rel="tooltip" title="View" class="btn btn-link btn-info table-action view" href="single_client_view/<?php echo $row->id;?>">
                      <i class="fa fa-image"></i>
                      </a>-->

                      <a rel="tooltip" title="Edit" class="btn btn-link btn-warning text-light table-action edit" data-id="<?php echo $row->id; ?>">
                      <i class="fa fa-edit"></i>
                      </a>

                      <a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" onClick="return confirm('Are you sure you want to delete?')" href="delete_designation/<?php echo $row->id;?>">
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
                    <tr><td colspan="6"><center><strong>NO RECORD FOUND</strong></center></td></tr>
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

<div class="modal fade" id="modal-dialog">
            <div class="modal-dialog modal-lg">
<!--                 <form id="addForm" method="POST" enctype="multipart/form-data">
 -->                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Designations</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                   <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Designation/add_designation">

                        <div class="modal-body">
                                <div class="card-body">
                                    <div class="row">
                                    	  <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dept_id"><strong>Department Name:</strong></label>
                                            <select name="dept_id" id='dept_id' class="form-control" class="selectpicker" data-title="Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
                                             <?php
											foreach($department as $value)
											{
											?>
											<option value="<?php echo $value->id; ?>"><?php echo $value->department_name; ?></option>
											 <?php
											}
											?>
                                            </select>
                                        </div>
                                            <div class="form-group">
                                                <label for="designation" class="control-label"><strong>Designations Name:</strong></label>
                                        <input class="form-control" type="text" name="designation" id="designation" required="true">
                                            </div>
                                        </div>
                                         <div class="col-md-3"></div>  
                                    </div>
                                </div>
                            
                        </div>
                    
                        <div class="modal-footer">
                         <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                       <input type="submit"  name="submit" Value="Submit"  class="btn btn-success">

                       </div>
                       </form>
                    </div>
                
            </div>
        </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
 <script> 
         $(document).ready(function(){
                     // onclick edit btn 
                $(".edit").click(function(){
                   var elmId = $(this).data("id");
                    var department_id= $("#edit_department_"+elmId).val();
                    var designation_name= $("#edit_designation_"+elmId).val();
                    //start ajax 
                      $.ajax({
                          url:"<?php echo base_url();?>Designation/edit_designation/"+elmId,
                          method:"POST",
                          data:{"dept_id":department_id,"designation":designation_name},
                          success:function(data)
                          {
                            data=JSON.parse(data);
                            console.log(data);
                            
                              if(data.status==true)
                              {
                                   $.gritter.add({
                                        title: 'Hurray!!',
                                        text: data.msg,
                                        class_name: 'bg-success'
                                    });
                                 $("#edit_department_row_"+elmId+' p').html(department_name);
                                 $("#edit_department_row_"+elmId+' p').show();
                               $("#edit_department_"+elmId).hide();
                              }
                              if(data.status==false)
                              {
                                  $.gritter.add({
                                      title: 'Something went wrong',
                                      text: data.msg,
                                      class_name: 'bg-red-darker'
                                    });
                                 $("#edit_department_row_"+elmId+' p').html(department_name);
                                 $("#edit_department_row_"+elmId+' p').show();
                               $("#edit_department_"+elmId).hide();
                              }
                          }

                   })//end ajax
                 });
                
            });           
        </script>