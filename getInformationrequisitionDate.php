<?php

	require_once("application/classes-and-objects/config.php");

	require_once("application/classes-and-objects/veriables.php");

	require_once("application/classes-and-objects/authentication.php");

	require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");

	$auth = new AUTHENTICATION($databaseObj);

	$q = $_POST['requisition_no'];



	$databaseObj->select("tbl_manage_indent");

	$databaseObj->where("`status` = '".$auth->visible()."'");

	$getData = $databaseObj->get();

	foreach ($getData as $rows) {

		$manage_indent_info = json_decode($rows["manage_indent_info"]);

		if ($rows["manage_indent_id"] == $q) {

			?>

			<label>Requisition Date</label>

		 <div class="form-group">

			<input class="form-control" name="requisition_date" id="requisition_date" type="text" value="<?= $manage_indent_info->indentDate ?>" readonly>

		 </div>
         
		 </div>

			<?php

	}

}

	?>

