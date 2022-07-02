<?php
	require_once("application/classes-and-objects/config.php");
	require_once("application/classes-and-objects/veriables.php");
	require_once("application/classes-and-objects/authentication.php");
	require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
	$auth = new AUTHENTICATION($databaseObj);
	$q = $_POST['vendor_name'];

	$databaseObj->select("tbl_manage_supplier");
	$databaseObj->where("`status` = '".$auth->visible()."'");
	$getData = $databaseObj->get();
	foreach ($getData as $rows) {
		$manage_supplier_info = json_decode($rows["manage_supplier_info"]);
		if ($manage_supplier_info->supplierName == $q) {
			?>
			<label>Address</label>
		 <div class="form-group">
			<input class="form-control" name="vendor_address" id="vendor_address" type="text" value="<?= $manage_supplier_info->supplierAddress ?>">
		 </div>


	 <label>GSTIN</label>
	 <div class="form-group">
		<input class="form-control" name="vendor_gstin" id="vendor_gstin" type="text" value="<?= $manage_supplier_info->supplierGstin ?>">
	 </div>
			<?php
	}
}
	?>
