<?php
    //Authentication Class
    class SETTING{
        /* ------------------------------------------------------------------------ */
        /* Variables Section Start */
        /* ------------------------------------------------------------------------ */
        //Database Object
        private $databaseObj = "";
        //Columns
        public $setting_id = array();
        public $setting_soft_info = array();
        public $setting_firm_info = array();
        public $setting_function_info = array();
        public $setting_sub_function_info = array();
        public $setting_backup_info = array();
        public $setting_payment_info = array();
        public $setting_theme_info = array();
        public $setting_update_info = array();
        /* ------------------------------------------------------------------------ */
        /* Variables Section End */
        /* ------------------------------------------------------------------------ */
        // --------------------------------------------------------------------------
        // Setting Table Section Start 
        // --------------------------------------------------------------------------
        public function __construct($databaseObj){
            $this->databaseObj = $databaseObj;
            $this->databaseObj->select("tbl_setting");
            $this->databaseObj->where("`setting_id` = 1");
            $getData = $this->databaseObj->get();
            //Checking If Data Is Available
            if($getData != 0){
                foreach($getData as $rows){
                    $this->setting_id = $rows["setting_id"];
                    $this->setting_soft_info = json_decode($rows["setting_soft_info"]);
                    $this->setting_firm_info = json_decode($rows["setting_firm_info"]);
                    $this->setting_function_info = json_decode($rows["setting_function_info"]);
                    $this->setting_sub_function_info = json_decode($rows["setting_sub_function_info"]);
                    $this->setting_backup_info = json_decode($rows["setting_backup_info"]);
                    $this->setting_payment_info = json_decode($rows["setting_payment_info"]);
                    $this->setting_theme_info = json_decode($rows["setting_theme_info"]);
                    $this->setting_update_info = json_decode($rows["setting_update_info"]);
                }
            }
        }
        // --------------------------------------------------------------------------
        // Setting Table Section End 
        // --------------------------------------------------------------------------
    }
?>