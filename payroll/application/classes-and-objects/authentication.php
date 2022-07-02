<?php
    //Authentication Class
    class AUTHENTICATION{
        /* ------------------------------------------------------------------------ */
        /* Variables Section Start */
        /* ------------------------------------------------------------------------ */
        //Database Object
        private $databaseObj = "";
        //Columns
        public $admin_id = array();
        public $admin_log = array();
        public $admin_info = array();
        public $admin_log_info = array();
        public $admin_ajax = array();
        public $admin_theme = array();
        public $admin_create = array();
        public $admin_auth = array();
        public $page_no = array();
        public $page_no_inside = array();
        public $page_check = false;
        //Other Variables
        public $cookieStatus = false;
        public $sessionStatus = false;
        public $logUser = "";
        public $logTime = "";
        public $logIp = "";
        public $logLocation = "";
        public $logStatus = "";
        public $logType = "";
        public $logProject = "";
        public $logDp = "";
        /* ------------------------------------------------------------------------ */
        /* Variables Section End */
        /* ------------------------------------------------------------------------ */
        // --------------------------------------------------------------------------
        // Authentication Section Start 
        // --------------------------------------------------------------------------
        public function __construct($databaseObj){
            if(isset($_COOKIE["logInfo"])){
                $this->cookieStatus = true;
                if(isset($_SESSION["logInfo"])){
                    $_SESSION["storeTempLogOut"] = time();
                    $this->sessionStatus = true;
                    $logInfo = json_decode($_SESSION["logInfo"]);
                    $this->logUser = $logInfo->logUser;
                    $this->logTime = str_replace("-", ":", $logInfo->logTime);
                    $this->logIp = $logInfo->logIp;
                    $this->logLocation = $logInfo->logLocation;
                    $this->logStatus = $logInfo->logStatus;
                    $this->logType = $logInfo->logType;
                    $this->databaseObj = $databaseObj;
                    //Fetching Admin Informations
                    $this->databaseObj->select("tbl_admin");
                    $this->databaseObj->where("`status` = '".self::visible()."'");
                    $getData = $this->databaseObj->get();
                    //Checking If Data Is Available
                    if($getData != 0){
                        foreach($getData as $rows){
                            $this->admin_log = json_decode($rows["admin_log"]);
                            if($this->admin_log->user == $this->logUser){
                                $this->admin_id = $rows["admin_id"];
                                $this->admin_log = json_decode($rows["admin_log"]);
                                $this->admin_auth = $this->admin_log->auth;
                                $this->admin_info = json_decode($rows["admin_info"]);
                                $this->admin_log_info = json_decode($rows["admin_log_info"]);
                                $this->admin_ajax = json_decode($rows["admin_ajax"]);
                                $this->admin_theme = json_decode($rows["admin_theme"]);
                                $this->admin_create = json_decode($rows["admin_create"]);
                                
                                // $this->logProject = $this->admin_info->project;
                                if($this->admin_info->dp != "")
                                    $this->logDp = $this->admin_info->dp;
                                else
                                    if($this->admin_info->gender == "male")
                                        $this->logDp = "men-Icon.png";
                                    else
                                        $this->logDp = "women-Icon.png";
                                break;
                            }
                        }
                    }
                } else{
                    header("Location: index");
                    exit;
                }
            } else{
                header("Location: index");
                exit;
            }
        }
        public function checkAuth($page_no, $page_no_inside){
            if($this->admin_auth != "all"):
                if (array_key_exists("page_no_". $page_no, $this->admin_auth)):
                    $menu = "page_no_". $page_no;
                    if(array_key_exists("page_no_inside_". $page_no_inside, $this->admin_auth->$menu)):
                        $submenu = "page_no_inside_". $page_no_inside;
                        $this->page_no = $this->admin_auth->$menu;
                        $this->page_no_inside = $this->admin_auth->$menu->$submenu;
                        $this->page_check = true;
                    else:
                        header("Location: dashboard");
                        exit;
                    endif;
                else:
                    header("Location: dashboard");
                    exit;
                endif;
            endif;
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