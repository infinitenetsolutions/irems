<?php
    //Variable Class
    require_once("variable-class.php");
    //Databse Class
    //All The Database Reated Queries and Operations
    class OPERATION extends VARIABLE{
        //Member Methods ----------------------------------------------------------
        public function findMax($minMaxVal){
            $this->minMaxVal = $minMaxVal;
            $this->lenght = count($minMaxVal);
            for($this->i = 0; $this->i < $this->lenght; $this->i++){
                if($this->findMax < $minMaxVal[$this->i])
                    $this->findMax = $minMaxVal[$this->i];
            }
            return $this->findMax;
            $this->findMax = 0;
        }
        public function findMin($minMaxVal){
            $this->minMaxVal = $minMaxVal;
            $this->lenght = count($minMaxVal);
            $this->findMin = $this->lenght;
            for($this->i = 0; $this->i < $this->lenght; $this->i++){
                if($this->findMin > $minMaxVal[$this->i])
                    $this->findMin = $minMaxVal[$this->i];
            }
            return $this->findMin;
            $this->findMin = 0;
        }
    }
?>