<?php
	require_once("application/classes-and-objects/config.php");
	require_once("application/classes-and-objects/veriables.php");
	require_once("application/classes-and-objects/authentication.php");
	require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
	$auth = new AUTHENTICATION($databaseObj);
	$q = $_POST['company_name'];

	$databaseObj->select("tbl_manage_company");
	$databaseObj->where("`status` = '".$auth->visible()."'");
	$getData = $databaseObj->get();
	foreach ($getData as $rows) {
		$manage_company_info = json_decode($rows["manage_company_info"]);
		if ($manage_company_info->companyName == $q) {
			?>
			<label>GSTIN</label>
		 <div class="form-group">
			<input class="form-control" name="company_gstin" id="company_gstin" type="text" value="<?= $manage_company_info->companyGSTIN ?>">
		 </div>
			<?php
	}
}
	?>
