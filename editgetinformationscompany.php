<?php

	require_once("application/classes-and-objects/config.php");

	require_once("application/classes-and-objects/veriables.php");

	require_once("application/classes-and-objects/authentication.php");

	require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");

	$auth = new AUTHENTICATION($databaseObj);

	$q = $_POST['editcompany_name'];

	$databaseObj->select("tbl_manage_company");
    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$q."'");
    $getData = $databaseObj->get();

	foreach ($getData as $rows):

		$manage_company_info = json_decode($rows["manage_company_info"]);

		

			?>
		<div class="row">
         <div class="col-md-3">
		   <div class="form-group">

             <label>GSTIN</label>

		     <input class="form-control" name="editcompany_gstin" id="editcompany_gstin" type="text" value="<?= $manage_company_info->companyGSTIN ?>" readonly>

		   </div>
		 </div>
		   


         <div class="col-md-9">
           <div class="form-group">

	         <label>Address</label>

		     <input class="form-control" name="editcompany_address" id="editcompany_address" type="text" value="<?= $manage_company_info->companyAddress ?>" readonly>

	        </div>
         </div>
        </div>
			<?php
    endforeach;
?> 
