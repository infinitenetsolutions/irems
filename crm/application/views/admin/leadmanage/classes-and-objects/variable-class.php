<?php
    //Variable Class
    class VARIABLE{
        //Member Variables -------------------------------------------------------
        //Database Connectivity Variables
        protected $hostname = "";
        protected $username = "";
        protected $password = "";
        protected $dbName = "";
        //Connection Veriable
        protected $con = "";
        //Statement Veriable
        protected $statement = "";
        //SQL varialbe
        public $sql = "";
        //Error Veriable
        protected $error = "";
        //Table Veriable
        public $tblName = "";
        //Column Veriables
        public $colName = "";
        public $colNames = "";
        //Row Veriables
        public $row = "";
        public $rows = "";
        //Data Array
        public $data = array();
        //Data Val
        public $dataVal = "";
        //Extra Variables --------------------------------------------------------
        //Lenght Variable
        public $lenght = 0;
        //Outer Loop Variable
        public $i = 0;
        //Inner Loop Variable
        public $j = 0;
        //Sperator Variable
        public $sperate = "";
        //Dynamic Path
        public $path = "";
        //Integer Maximum Value Varialbe
        public $findMax = 0;
        //Integer Minimum Value Varialbe
        public $findMin = 0;
        //Integer Value Variable
        public $minMaxVal = 0;
        //Visible Veriable
        public $visible = "visible";
        //Trash Veriable
        public $trash = "trash";
    }
?>