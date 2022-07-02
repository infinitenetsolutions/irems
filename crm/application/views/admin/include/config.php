<?php
    // Create connection
    //$con = new mysqli("localhost", "", "", "");
    $con = new mysqli("localhost", "srinathhomes_db_irmes", "n7LVzdkd7", "srinathhomes_db_irmes");
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
?>