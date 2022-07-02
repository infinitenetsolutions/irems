<?php
if(isset($_POST["country"])){
    // Capture selected country
    $country = $_POST["country"];

    // Define country and city array
    $countryArr = array(
                    "Andhra Pradesh" => array("28"),
                    "Arunachal Pradesh" => array("12"),
                    "Assam" => array("18"),
                    "Bihar" => array("10"),
                    "Chhattisgarh" => array("22"),
                    "Goa" => array("30"),
                    "Gujarat" => array("24"),
                    "Haryana" => array("06"),
                    "Himachal Pradesh" => array("02"),
                    "Jammu & Kashmir" => array("01"),
                    "Jharkhand" => array("20"),
                    "Karnataka" => array("29"),
                    "Kerala" => array("32"),
                    "Madhya Pradesh" => array("23"),
                    "Maharashtra" => array("27"),
                    "Manipur" => array("14"),
                    "Meghalaya" => array("17"),
                    "Mizoram" => array("15"),
                    "Nagaland" => array("13"),
                    "Odisha" => array("21"),
                      "Punjab" => array("03"),
                      "Rajasthan" => array("08"),
                        "Sikkim" => array("11"),
                          "Tamil Nadu" => array("33"),
                            "Tripura" => array("16"),
                              "Uttarakhand" => array("05"),
                               "Uttar Pradesh" => array("09"),
                                "West Bengal" => array("19"),
                                 "Andaman & Nicobar" => array("35"),
                                  "Chandigarh" => array("04"),
                                   "Dadra and Nagar Haveli" => array("26"),
                                    "Daman & Diu" => array("25"),
                                     "Delhi" => array("07"),
                                      "Lakshadweep" => array("31"),
                                        "Puducherry" => array("34")

                );

    // Display city dropdown based on country name
    if($country !== 'Select'){
        echo '<label>Code</label>';
        foreach($countryArr[$country] as $value){
            echo "<input class='form-control' type='text' name='state_code' value=".$value." readonly>";
        }
    }
}
?>
