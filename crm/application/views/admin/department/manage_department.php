<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<div id="content" class="content">

<ol class="breadcrumb float-xl-right">
<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
<li class="breadcrumb-item"><a href="javascript:;">Manage Department</a></li>
</ol>


<h5 class="page-header">Manage Department 

<?php if($this->session->flashdata('msg')): ?>
    <?php echo $this->session->flashdata('msg'); ?>
<?php endif; ?>
</h5>


<div class="row">

<div class="col-xl-12">


<div class="panel panel-inverse">

<div class="panel-heading">

<h4 class="panel-title"><button href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Add Department</button></h4>
<!-- <a href="#modal-dialog" class="btn btn-success btn-sm" data-toggle="modal">Demo</a>
 --><div class="panel-heading-btn">
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
<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
<thead>
<tr>
<th class="text-nowrap">S NO</th>
<!-- <th width="1%" data-orderable="false"></th>
 -->
 <th class="text-nowrap">Department Name</th>
<th class="text-nowrap">Action</th>


</tr>
</thead>
<tbody>
    <?php
    $cnt = 1;
    if(!empty($department))
    {

    foreach($department as $row)
    {

    ?>  
                       <tr>
                      <td><?php echo $cnt++; ?></td>
                      <td> 
                        <div id="edit_department_row_<?php echo $row->id; ?>">
                          <p><?php echo $row->department_name; ?></p>
                          <div class="form-inline" id="edit_department_<?php echo $row->id; ?>" style="display:none"><input class="form-control " type="text" name="department_name"  value="<?php echo $row->department_name; ?>" required="true" > <a rel="tooltip" title="Edit" class="btn btn-primary text-light table-action save" id="<?php echo $row->id; ?>">Save</a></div>
                        </div>
                        </td>
                      <td>
                      <!--<a rel="tooltip" title="View" class="btn btn-link btn-info table-action view" href="single_client_view/<?php echo $row->id;?>">
                      <i class="fa fa-image"></i>
                      </a>-->

                      <a rel="tooltip" title="Edit" class="btn btn-link btn-sm btn-warning text-light table-action edit" data-id="<?php echo $row->id; ?>">
                      <i class="fa fa-edit"></i>
                      </a>

                      <a rel="tooltip" title="Remove" class="btn btn-link btn-sm btn-danger table-action remove" onClick="return confirm('Are you sure you want to delete?')" href="delete_department/<?php echo $row->id;?>">
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
                            <h4 class="modal-title">Add Department</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                   <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Department/add_department">

                        <div class="modal-body">
                                <div class="card-body">
                                    <div class="row">
                                    	  <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department_name" class="control-label"><strong>Department Name:</strong></label>
                                        <input class="form-control" type="text" name="department_name" id="department_name" required="true">
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
                     $("#edit_department_row_"+elmId+' p').hide();
                      $("#edit_department_"+elmId).show();
                 });
                // onclick save btn 
                $(".save").click(function(){
                   var elmId = $(this).attr("id");
                    var department_name = $("#edit_department_"+elmId+' input').val();
                   // start ajax 
                      $.ajax({
                          url:"<?php echo base_url();?>Department/edit_department/"+elmId,
                          method:"POST",
                          data:{"department_name":department_name},
                          success:function(data)
                          {
                            data=JSON.parse(data);
                            
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