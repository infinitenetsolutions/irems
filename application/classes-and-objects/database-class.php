<?php
    //Variable Class
    require_once("variable-class.php");
    //Databse Class
    //All The Database Reated Queries and Operations
    class DATABASE extends VARIABLE{
        //Member Methods ----------------------------------------------------------
        // -------------------------------------------------- Connectivity Related Queries Start ------------------------------------------ //
        //Constructor (For Databse Connectivity)
        public function __construct($hostname, $username, $password, $dbName){
            $this->hostname = $hostname;
            $this->username = $username;
            $this->password = $password;
            $this->dbName = $dbName;
            try{
                $this->con = new PDO("mysql:host=$this->hostname;dbname=$this->dbName", $this->username, $this->password);
                //Set the PDO error mode to exception
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $error){
                echo "Connection Failed : ". $error->getMessage();
            }
            
        }
        //New Database Connection Function
        public function new_db($hostname, $username, $password, $dbName){
            $this->hostname = $hostname;
            $this->username = $username;
            $this->password = $password;
            $this->dbName = $dbName;
            try{
                $this->con = new PDO("mysql:host=$this->hostname;dbname=$this->dbName", $this->username, $this->password);
                //Set the PDO error mode to exception
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $error){
                echo "Connection Failed : ". $error->getMessage();
            }
            
        }
        // -------------------------------------------------- Connectivity Related Queries End -------------------------------------------- //
        // -------------------------------------------------- Database Related Queries Start ---------------------------------------------- //
        //Create Database Function
        public function create_db($dbName){
            $this->dbName = $dbName;
            try{
                $this->sql = "CREATE DATABASE `$this->dbName`;";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
            
        }
        //Delete Database Function
        public function delete_db($dbName){
            $this->dbName = $dbName;
            try{
                $this->sql = "DROP DATABASE `$this->dbName`;";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
            
        }
        // -------------------------------------------------- Database Related Queries Start --------------------------------------------- //
        // -------------------------------------------------- Table Related Queries Start ------------------------------------------------ //
        //Create Table Function
        public function create_tbl($tblName, $colNames){
            $this->tblName = $tblName;
            $this->data = $colNames;
            $this->colNames = implode(",", $this->data);
            try{
                $this->sql = "CREATE TABLE `$this->tblName`
                              ($this->colNames);";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
        //Drop Table Function
        public function drop_tbl($tblName){
            $this->tblName = $tblName;
            try{
                $this->sql = "DROP TABLE `$this->tblName`;";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
        //Alter Table Function
        public function alter_tbl($tblName, $colName, $instruction){
            $this->tblName = $tblName;
            if(strtolower($instruction) == "add"){
                $this->colName = $colName;
                $this->sql = "ALTER TABLE `$this->tblName`
                              ADD $this->colName;";
            } else if(strtolower($instruction) == "drop"){
                        $this->colName = $colName;
                        $this->sql = "ALTER TABLE `$this->tblName`
                                      DROP COLUMN $this->colName;";
                   } else if(strtolower($instruction) == "alter"){
                                $this->colName = $colName;
                                $this->sql = "ALTER TABLE `$this->tblName`
                                              MODIFY COLUMN $this->colName;";
                          }
            try{
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
        // -------------------------------------------------- Table Related Queries End -------------------------------------------------- //
        // -------------------------------------------------- Main Queries Start --------------------------------------------------------- //
        //Select All Function
        public function select($tblName){
            $this->tblName = $tblName;
            $this->sql = "SELECT * FROM `$this->tblName`";
        }
        //Select Min Function
        public function select_min($tblName, $colName, $asVal){
            $this->tblName = $tblName;
            $this->colName = $colName;
            $this->sql = "SELECT MIN($this->colName) AS $asVal FROM `$this->tblName`";
        }
        //Select Max Function
        public function select_max($tblName, $colName, $asVal){
            $this->tblName = $tblName;
            $this->colName = $colName;
            $this->sql = "SELECT MAX($this->colName) AS $asVal FROM `$this->tblName`";
        }
        //Select Column Only Function
        public function select_cols($tblName, $colNames){
            $this->tblName = $tblName;
            $this->colNames = "`";
            $this->colNames .= implode("`, `", $colNames);
            $this->colNames .= "`";
            $this->sql = "SELECT $this->colNames FROM `$this->tblName`";
        }
        //Select Distinct Column Function
        public function select_distinct($tblName, $colName){
            $this->tblName = $tblName;
            $this->colName = $colName;
            $this->sql = "SELECT DISTINCT(`$this->colName`) FROM `$this->tblName`";
        }
        //Select Distinct Column With Function
        public function select_distinct_with($tblName, $distinctColName, $colNames){
            $this->tblName = $tblName;
            $this->colName = $distinctColName;
            $this->colNames = "`";
            $this->colNames .= implode("`, `", $colNames);
            $this->colNames .= "`";
            $this->sql = "SELECT DISTINCT(`$this->colName`), $this->colNames FROM `$this->tblName`";
        }
        //Select Distinct Columns Function
        public function select_distincts($tblName, $colNames){
            $this->tblName = $tblName;
            $this->colNames = "`";
            $this->colNames .= implode("`, `", $colNames);
            $this->colNames .= "`";
            $this->sql = "SELECT DISTINCT $this->colNames FROM `$this->tblName`";
        }
        // select inner join
        public function select_inner_join($tblName1,$tblName2,$joinCondition){
            $this->tblName1 = $tblName1;
            $this->tblName2 = $tblName2;
            $this->joinCond = $joinCondition;
            $this->sql = "SELECT * FROM `$this->tblName1`";
            $this->sql .= "INNER JOIN `$this->tblName1`";
            $this->sql .= "ON";
            $this->sql .= $this->joinCond;
        }
        // select row count
         public function select_count_row($tblName,$colName){
            $this->tblName = $tblName;
            $this->sql = "SELECT COUNT($colName) as countnum FROM `$this->tblName`";
        }
        //Where Function
        public function where($passedCondition){
              $this->sql .= " WHERE $passedCondition";
        }
        //Limit Function
        public function limit($passedCondition){
            $this->sql .= " LIMIT $passedCondition";
        }
        //Order By Function
        public function order_by($passedCondition){
            $this->sql .= " ORDER BY $passedCondition";
        }
        //Get All Data Function
        public function get(){
            try{
                $this->statement = $this->con->prepare($this->sql);
                $this->statement->execute();
                $this->statement->setFetchMode(PDO::FETCH_ASSOC);
                return $this->statement->fetchAll();
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
         //Run direct sql Into Function
        public function sqlCmdRun($sqlCmd){
            // try{
            //     $this->sql = $sqlCmd;
            //     $this->con->exec($this->sql);
            //     return 1;
            // } catch(PDOException $error){
            //     $this->error = $this->sql ."<br/>". $error->getMessage();
            //     // return 0;
            //     return $this->error;
            // }

             try{
                $this->sql = $sqlCmd;
                $this->statement = $this->con->prepare($this->sql);
                $this->statement->execute();
                $this->statement->setFetchMode(PDO::FETCH_ASSOC);
                return $this->statement->fetchAll();
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }



        }
        //Insert Into Function
        public function insert($tblName, $data){
            $this->tblName = $tblName;
            $this->colNames = "`";
            $this->colNames .= implode("`, `", array_keys($data));
            $this->colNames .= "`";
            $this->dataVal = "'";
            $this->dataVal .= implode("', '", $data);
            $this->dataVal .= "'";
            try{
                $this->sql = "INSERT INTO `$this->tblName`
                              ($this->colNames)
                              VALUES
                              ($this->dataVal)";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
        //Update Function
        public function update($tblName, $data, $passedCondition){
            $this->tblName = $tblName;
                $this->data = [];
            foreach($data as $key => $value)
                $this->data[] = "`".$key."` = '".$value."'";
                $this->dataVal .= implode(", ", $this->data);
            try{
                $this->sql = "UPDATE `$this->tblName`
                              SET $this->dataVal
                              WHERE $passedCondition;";
                $this->con->exec($this->sql);
                // echo $this->sql;
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }

        public function updateTbl($tblName, $data, $passedCondition){
            $this->tblName = $tblName;
            foreach($data as $key=>$value)
                $this->data[] = "`".$key."` = '".$value."'";
            $this->dataVal .= implode(", ", $this->data);
            try{
                $this->sql = "UPDATE `$this->tblName`
                              SET $this->dataVal
                              WHERE $passedCondition";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
        //  public function update_table($tblName, $data){
        //     $this->tblName = $tblName;
        //     foreach($data as $key=>$value)
        //         $this->data[] = "`".$key."` = '".$value."'";
        //     $this->dataVal .= implode(", ", $this->data);
        //     try{
        //         $this->sql = "UPDATE `$this->tblName`
        //                       SET $this->dataVal
        //                       WHERE $passedCondition";
        //         $this->con->exec($this->sql);
        //         return 1;
        //     } catch(PDOException $error){
        //         $this->error = $this->sql ."<br/>". $error->getMessage();
        //         return 0;
        //     }
        // }
         
        //Update Function
        public function delete($tblName, $passedCondition){
            $this->tblName = $tblName;
            try{
                $this->sql = "DELETE FROM `$this->tblName`
                              WHERE $passedCondition";
                $this->con->exec($this->sql);
                return 1;
            } catch(PDOException $error){
                $this->error = $this->sql ."<br/>". $error->getMessage();
                return 0;
            }
        }
        //Inserted Id
        public function last_inserted_id(){
            return $this->con->lastInsertId();
        }
        
        // -----------------------------------------------------------------------
        // --------------------- Direct Execute sql start --------------------------------
        // -----------------------------------------------------------------------
                // get data from database
             public function selectDataSqlCmd($sqlCmd){
                    try{
                        $this->statement = $this->con->prepare($sqlCmd);
                        $this->statement->execute();
                        $this->statement->setFetchMode(PDO::FETCH_ASSOC);
                        return $this->statement->fetchAll();
                    } catch(PDOException $error){
                        $this->error = $this->sql ."<br/>". $error->getMessage();
                        return 0;
                    }
                }
                // insert data in database
              public function insertSqlCmd($sqlCmd){
                     try{
                            $this->sql = $sqlCmd;
                            $this->con->exec($this->sql);
                            return 1;
                        } catch(PDOException $error){
                            $this->error = $this->sql ."<br/>". $error->getMessage();
                            return 0;
                        }
                }
             // update data in database
              public function updateSqlCmd($sqlCmd){
                    try{
                        $this->sql = $sqlCmd;
                        $this->con->exec($this->sql);
                        return 1;
                    } catch(PDOException $error){
                        $this->error = $this->sql ."<br/>". $error->getMessage();
                        return 0;
                    }
                }
             // update data in database
              public function deleteSqlCmd($sqlCmd){
                    try{
                        $this->sql = $sqlCmd;
                        $this->con->exec($this->sql);
                        return 1;
                    } catch(PDOException $error){
                        $this->error = $this->sql ."<br/>". $error->getMessage();
                        return 0;
                    }
                }

        // -----------------------------------------------------------------------
        // --------------------- Direct Execute sql End --------------------------------
        // -----------------------------------------------------------------------
        
        // -------------------------------------------------- Main Queries End ----------------------------------------------------------- //
        // -------------------------------------------------- Extra Queries Start -------------------------------------------------------- //
        public function send_to_phone($phone, $message){
            $senderId="INSSRV";
            $serverUrl="msg.msgclub.net";
            $authKey="6a4743a8355fb97aa42dc2452185a1cd";
            $routeId="1";
            $postData = array(
                            "mobileNumbers"     =>  $phone,
                            "smsContent"        =>  $message,
                            "senderId"          =>  $senderId,
                            "routeId"           =>  $routeId,
                            "smsContentType"    =>  "english"
                        );
            $data_json = json_encode($postData);
            $url="http://".$serverUrl."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey;
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($data_json)),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ));
            curl_exec($ch);
        }
        // Generate Password Start
        public function generate_password($chars){
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($data), 0, $chars);
        }
        // Generate Password End
        //Error Funstion
        public function error(){
            echo $this->error;
        }
        // -------------------------------------------------- Extra Queries End ---------------------------------------------------------- //
    }
?>