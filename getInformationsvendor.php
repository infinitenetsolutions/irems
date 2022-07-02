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

		if ($rows["manage_supplier_id"] == $q) {

			?>
<div class="row">	
         <div class="col-sm-12">
			<label>Address</label>
		
		   <div class="form-group">

			<input class="form-control" name="vendor_address" id="vendor_address" type="text" value="<?= $manage_supplier_info->supplierAddress ?>" readonly>

		   </div>
		 </div>
		 <div class="col-sm-6">
         <label>GSTIN</label>

			 <div class="form-group">

				<input class="form-control" name="vendor_gstin" id="vendor_gstin" type="text" value="<?= $manage_supplier_info->supplierGstin ?>"readonly>

			 </div>
	     </div>	
	      <div class="col-sm-6">	 
	         <label>Contact Person</label>

		 <div class="form-group">

			<input class="form-control" name="vendor_contact_person" id="vendor_contact_person" type="text" value="<?= $manage_supplier_info->supplierConcernPersonName ?>" readonly>

		 </div>
		 </div>
		  <div class="col-sm-6">
		 <label>Contact  Phone Number</label>

		 <div class="form-group">

			<input class="form-control" name="vendor_contact_phone_no" id="vendor_contact_phone_no" type="text" value="<?= $manage_supplier_info->supplierPhone ?>" readonly>

		 </div>
		  </div>
</div>

			<?php

	}

}

	?>

