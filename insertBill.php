<?php 
	$con = mysqli_connect('localhost','root','','srinathhomes_db_irmes');
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}
	
	echo "<pre>";
	print_r(explode('|',$_POST['customer_name'])[4]); exit;
 	
    $insert_variable = 0;
	$invoiceNo = $_POST["invoiceNo"];
	//$invoiceNo=str_replace("'","&#39;", $invoiceNo); 
	$serviceName = $_POST["service_name"];

	 $invoice_date = $_POST["invoiceDate"];
     $billDuedate = $_POST["billDuedate"];
	$paymentTerms = $_POST["paymentTerms"];
	//$supplierRef = $_POST["supplierRef"];
	 $otherRef = $_POST["otherRef"];
     $otherRef=str_replace("'","&#39;", $otherRef); 

	// $buyerOrderNo = $_POST["buyerOrderNo"];
	// $buyerOrderDate = $_POST["buyerOrderDate"];

	// $dspatchNo = $_POST["dspatchNo"];

	// $deliveryNoteDate = $_POST["deliveryNoteDate"];
	// $despatchedThrough = $_POST["despatchedThrough"];
	// $destination = $_POST["destination"];
	$termofdelivery = $_POST["termofdelivery"];
	
	$customer_name = $_POST["customer_name"];	
	$project_id = $_POST["project_name"];

	$total_amount = 0;
	$final_amount = 0;
	$cgstamt_total = 0;
	$sgstamt_total = 0;
	$igstamt_total = 0;
	$grand_total = 0;
	
	
	if(!empty($invoiceNo) && !empty($invoice_date)){
		for($i=0; $i<count($_POST["unit"]); $i++) {
			$service_name = $_POST["service"][$i];
			$unit = $_POST["unit"][$i];
			$quantity = $_POST["quantity"][$i];
			$rate = $_POST["rate"][$i];
			$amount = $_POST["amount"][$i];
			$total_amount = floatval($rate) * floatval($quantity);
			$final_amount = floatval($final_amount) + floatval($total_amount);
			$cgstrate = $_POST["cgstrate"][$i];
			$cgstamt = $_POST["cgstamt"][$i];
			$cgstamt_total = floatval($cgstamt_total) + floatval($cgstamt);
			$sgstrate = $_POST["sgstrate"][$i];
			$sgstamt = $_POST["sgstamt"][$i];
			$sgstamt_total = floatval($sgstamt_total) + floatval($sgstamt);
			$igstrate = $_POST["igstrate"][$i];
			$igstamt = $_POST["igstamt"][$i];
			$igstamt_total = floatval($igstamt_total) + floatval($igstamt);
			$total = $_POST["total"][$i];
			$grand_total = floatval($grand_total) + floatval($total);
			
			
			
			$sql="INSERT INTO `tbl_maintenance`
				(`m_id`, `invoice_no`, `invoice_date`,`bill_due_date`, `payment_terms`, `other_ref`,`terms_of_delivery`,`project_id`,`customer_id`,`service`,`unit`,`quantity`,`rate`,`amount`,`cgstrate`,`sgstrate`,`igstrate`,`cgstamt`,`sgstamt`,`igstamt`,`total`)
				VALUES
				('','$invoiceNo','$invoice_date','$billDuedate','$paymentTerms','$otherRef','$termofdelivery','$project_id','$customer_name','$service_name','$unit','$quantity','$rate','$amount','$cgstrate','$sgstrate','$igstrate','$cgstamt','$sgstamt','$igstamt','$total')
				";
			$con->query($sql);
			$insert_variable++;
		}
		// INSERT INTO tbl_bills_payment
		//$sql = "INSERT INTO `tbl_bills_payment`(`id`, `invoice_no`, `invoice_date`, `client_name`, `cgstamt`, `sgstamt`, `igstamt`, `total`, `grand_total`, `due`, `description`)
						//VALUES
						//('','$invoice_no','$invoice_date','$client_name','$cgstamt_total','$sgstamt_total','$igstamt_total','$final_amount','$grand_total','$grand_total','$description') ";
		//$con->query($sql);
		//mail 
		//$to = "jatinsahu234@gmail.com";
       // $subject = "Bill Generated Successfully!!! Invoice No - $invoice_no";
        //$message = "
            //<a href='http://faizfms.net.in/print_bill_view.php?invoice_no=$invoice_no'>View Bill</a>
        //";
        
        // Always set content-type when sending HTML email
    //     $headers = "MIME-Version: 1.0" . "\r\n";
    //     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    //     $headers .= 'From: <info@faizfms.in>' . "\r\n";
        
        //mail($to,$subject,$message,$headers);
		//href - http://faizfms.net.in/print_bill_view.php?invoice_no=$invoice_no;
		echo "Your Bill has been generated click Print For Bill !!! <br/>";
		?>
	    <a href="./print_bill_view.php?invoice_no=<?php echo $invoiceNo; ?>" target="_blank" class="btn btn-primary"> Print </a>

		<a href="http://localhost/irems/maintainance"  class="btn btn-success"> New Bill </a>

		
		<?php
	} else{
		echo "Please fill out all required fields!!!";
	}
?>