<?php
    //Authentication Class
    class AUTHENTICATION{
        /* ------------------------------------------------------------------------ */
        /* Variables Section Start */
        /* ------------------------------------------------------------------------ */
        //Database Object
        private $databaseObj = "";
        //Columns
        public $customer_id = array();
        public $customer_log = array();
        public $customer_info = array();
        public $customer_log_info = array();
        public $customer_ajax = array();
        public $customer_theme = array();
        public $customer_create = array();
        //Other Variables
        public $cookieStatus = false;
        public $sessionStatus = false;
        public $logUser = "";
        public $logTime = "";
        public $logIp = "";
        public $logLocation = "";
        public $logStatus = "";
        public $logType = "";
        public $logDp = "";
        /* ------------------------------------------------------------------------ */
        /* Variables Section End */
        /* ------------------------------------------------------------------------ */
        // --------------------------------------------------------------------------
        // Authentication Section Start 
        // --------------------------------------------------------------------------
        public function __construct($databaseObj){
            if(isset($_COOKIE["logInfoCustomer"])){
                $this->cookieStatus = true;
                if(isset($_SESSION["logInfoCustomer"])){
                    $_SESSION["storeTempLogOut"] = time();
                    $this->sessionStatus = true;
                    $logInfoCustomer = json_decode($_SESSION["logInfoCustomer"]);
                    $this->logUser = $logInfoCustomer->logUser;
                    $this->logTime = str_replace("-", ":", $logInfoCustomer->logTime);
                    $this->logIp = $logInfoCustomer->logIp;
                    $this->logLocation = $logInfoCustomer->logLocation;
                    $this->logStatus = $logInfoCustomer->logStatus;
                    $this->logType = $logInfoCustomer->logType;
                    $this->databaseObj = $databaseObj;
                    //Fetching Admin Informations
                    $this->databaseObj->select("tbl_customer");
                    $this->databaseObj->where("`status` = '".self::visible()."'");
                    $getData = $this->databaseObj->get();
                    //Checking If Data Is Available
                    if($getData != 0){
                        foreach($getData as $rows){
                            $this->customer_log = json_decode($rows["customer_log"]);
                            if($this->customer_log->user == $this->logUser){
                                $this->customer_id = $rows["customer_id"];
                                $this->customer_log = json_decode($rows["customer_log"]);
                                $this->customer_info = json_decode($rows["customer_info"]);
                                $this->customer_log_info = json_decode($rows["customer_log_info"]);
                                $this->customer_ajax = json_decode($rows["customer_ajax"]);
                                $this->customer_theme = json_decode($rows["customer_theme"]);
                                $this->customer_create = json_decode($rows["customer_create"]);
                                if($this->customer_info->dp != "")
                                    $this->logDp = "../assets/customer/profile/".$this->customer_info->dp;
                                else
                                    if($this->customer_info->gender == "male")
                                        $this->logDp = "../assets/customer/profile/men-Icon.png";
                                    else
                                        $this->logDp = "../assets/customer/profile/women-Icon.png";
                                break;
                            }
                        }
                    }
                } else{
                    echo "
                         <script>
                            location.replace('index');
                         </script>
                         ";
                    exit;
                }
            } else{
                echo "
                     <script>
                        location.replace('index');
                     </script>
                     ";
                exit;
            }
        }
        // --------------------------------------------------------------------------
        // Authentication Section End 
        // --------------------------------------------------------------------------
        // --------------------------------------------------------------------------
        // Extra Veriable's Function Section Start 
        // --------------------------------------------------------------------------
        public function visible(){
            return md5("visible");
        }
        public function trash(){
            return md5("trash");
        }
        public function randFour(){
            return rand(1111,9999);
        }
        public function randSix(){
            return rand(111111,999999);
        }
        public function randEight(){
            return rand(11111111,99999999);
        }
        public function unique(){
            return uniqid();
        }
        // --------------------------------------------------------------------------
        // Extra Veriable's Function Section End 
        // --------------------------------------------------------------------------
        // --------------------------------------------------------------------------
        // Date Time Section Start 
        // --------------------------------------------------------------------------
        
        // --------------------------------------------------------------------------
        // Date Time Section End 
        // --------------------------------------------------------------------------
    }
?>