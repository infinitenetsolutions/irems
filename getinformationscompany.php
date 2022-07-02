<?php

	require_once("application/classes-and-objects/config.php");

	require_once("application/classes-and-objects/veriables.php");

	require_once("application/classes-and-objects/authentication.php");

	require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");

	$auth = new AUTHENTICATION($databaseObj);

	$q = $_POST['company_name'];

	$databaseObj->select("tbl_manage_company");
    $databaseObj->where("`status` = '".$auth->visible()."' && `manage_company_id` = '".$q."'");
    $getData = $databaseObj->get();

	foreach ($getData as $rows):

		$manage_company_info = json_decode($rows["manage_company_info"]);

		

			?>
			 

		 <div class="form-group">

        <label>GSTIN</label>

			<input class="form-control" name="company_gstin" id="company_gstin" type="text" value="<?= $manage_company_info->companyGSTIN ?>" readonly>

		 </div>



     <div class="form-group">

	 <label>Address</label>

		<input class="form-control" name="company_address" id="company_address" type="text" value="<?= $manage_company_info->companyAddress ?>" readonly>

	 </div>

			<?php
    endforeach;
?> 
