<?php 
 	 $con = mysqli_connect('localhost','root','','srinathhomes_db_irmes');
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}
// 	function convert_number_to_words($number){
//         $no = floor($number);
//         $arr = explode(".",$number);
//         $pos = strpos($number, ".");
//         // $point = $arr[1];
//         $point = round($number - $no, 2) * 100;
//         $hundred = null;
//         $digits_1 = strlen($no);
//         $i = 0;
//         $str = array();
//         $words = array( '0' => '',
//                         '1' => 'One',
//                         '2' => 'Two',
//                         '3' => 'Three',
//                         '4' => 'Four',
//                         '5' => 'Five',
//                         '6' => 'Six',
//                         '7' => 'Seven',
//                         '8' => 'Eight',
//                         '9' => 'Nine',
//                         '10' => 'Ten',
//                         '11' => 'Eleven',
//                         '12' => 'Twelve',
//                         '13' => 'Thirteen',
//                         '14' => 'Fourteen',
//                         '15' => 'Fifteen',
//                         '16' => 'Sixteen',
//                         '17' => 'Seventeen',
//                         '18' => 'Eighteen',
//                         '19' => 'Nineteen',
//                         '20' => 'Twenty',
//                         '30' => 'Thirty',
//                         '40' => 'Forty',
//                         '50' => 'Fifty',
//                         '60' => 'Sixty',
//                         '70' => 'Seventy',
//                         '80' => 'Eighty',
//                         '90' => 'Ninety'
//                       );
//         $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
//         while ($i < $digits_1) {
//             $divider = ($i == 2) ? 10 : 100;
//             $number = floor($no % $divider);
//             $no = floor($no / $divider);
//             $i += ($divider == 10) ? 1 : 2;
//             if ($number) {
//                 $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
//                 $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
//                 $str [] = ($number < 21) ? $words[$number] .
//                 " " . $digits[$counter] . $plural . " " . $hundred
//                 :
//                 $words[floor($number / 10) * 10]
//                 . " " . $words[$number % 10] . " "
//                 . $digits[$counter] . $plural . " " . $hundred;
//             }
//             else $str[] = null;
//         }
//         $str = array_reverse($str);
//         $result = implode('', $str);
//         $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';

//         if($pos == true)
//             $completeWord = $result." And".$points ." Paise";
//         else
//             $completeWord = $result."";
//         return $completeWord;
//     }
    
    
function convert_number_to_words($number) {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    if($paise != ""){
    return ($Rupees ? '' . $Rupees : '') . $paise . " Paise";
    }
    else{
        return ($Rupees ? '' . $Rupees : '')  . "";
    }
}
	
// 	function convert_number_to_words($number) {

//     $hyphen = '-';
//     $conjunction = ' And ';
//     $separator = ', ';
//     $negative = 'negative ';
//     $decimal = ' Point ';
//     $dictionary = array(
//         0 => 'Zero',
//         1 => 'One',
//         2 => 'Two',
//         3 => 'Three',
//         4 => 'Four',
//         5 => 'Five',
//         6 => 'Six',
//         7 => 'Seven',
//         8 => 'Eight',
//         9 => 'Nine',
//         10 => 'Ten',
//         11 => 'Eleven',
//         12 => 'Twelve',
//         13 => 'Thirteen',
//         14 => 'Fourteen',
//         15 => 'Fifteen',
//         16 => 'Sixteen',
//         17 => 'Seventeen',
//         18 => 'Eighteen',
//         19 => 'Nineteen',
//         20 => 'Twenty',
//         30 => 'Thirty',
//         40 => 'Forty',
//         50 => 'Fifty',
//         60 => 'Sixty',
//         70 => 'Seventy',
//         80 => 'Eighty',
//         90 => 'Ninety',
//         100 => 'Hundred',
//         1000 => 'Thousand',
//         100000 => 'Lakhs',
//         1000000 => 'Million',
//         1000000000 => 'Billion',
//         1000000000000 => 'Trillion',
//         1000000000000000 => 'Quadrillion',
//         1000000000000000000 => 'Quintillion'
//     );

//     if (!is_numeric($number)) {
//         return false;
//     }

//     if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
//         // overflow
//         trigger_error(
//                 'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
//         );
//         return false;
//     }

//     if ($number < 0) {
//         return $negative . convert_number_to_words(abs($number));
//     }

//     $string = $fraction = null;

//     if (strpos($number, '.') !== false) {
//         list($number, $fraction) = explode('.', $number);
//     }

//     switch (true) {
//         case $number < 21:
//             $string = $dictionary[$number];
//             break;
//         case $number < 100:
//             $tens = ((int) ($number / 10)) * 10;
//             $units = $number % 10;
//             $string = $dictionary[$tens];
//             if ($units) {
//                 $string .= $hyphen . $dictionary[$units];
//             }
//             break;
//         case $number < 1000:
//             $hundreds = $number / 100;
//             $remainder = $number % 100;
//             $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
//             if ($remainder) {
//                 $string .= $conjunction . convert_number_to_words($remainder);
//             }
//             break;
            
            
            
//         default:
//             $baseUnit = pow(1000, floor(log($number, 1000)));
//             $numBaseUnits = (int) ($number / $baseUnit);
//             $remainder = $number % $baseUnit;
//             $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
//             if ($remainder) {
//                 $string .= $remainder < 100 ? $conjunction : $separator;
//                 $string .= convert_number_to_words($remainder);
//             }
//             break;
//     }

//     if (null !== $fraction && is_numeric($fraction)) {
//         $string .= $decimal;
//         $words = array();
//         foreach (str_split((string) $fraction) as $number) {
//             $words[] = $dictionary[$number];
//         }
//         $string .= implode(' ', $words);
//     }

//     return $string;
// }
	
	
	
?>