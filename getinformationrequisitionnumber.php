 <?php

  require_once("application/classes-and-objects/config.php");
  require_once("application/classes-and-objects/veriables.php");
  require_once("application/classes-and-objects/authentication.php");
  require_once("application/classes-and-objects/PHPExcel/PHPExcel.php");
  $auth = new AUTHENTICATION($databaseObj);
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
  $q = $_POST['employee_project'];
  $indentNo =$_POST["indentNo"];
                                     
                $databaseObj->select("tbl_projects");
                $databaseObj->where("`status` = '".$auth->visible()."' && `projects_id` = '".$q."'");
                $getDataPro = $databaseObj->get();
                //Checking If Data Is Available
                if($getDataPro != 0):
                  foreach($getDataPro as $rowsPro):
                    $projects_info = json_decode($rowsPro["projects_info"]);
                    $req = explode(" ",$projects_info->projectName);
                    $reqName = "";
                    foreach($req as $reqAll):
                      if(isset($reqAll[0]))
                        $reqName .= $reqAll[0];
                        $year =  date("y");
                        // $yearnow= date("Y");
                        $yearnext=$year+1;
                        $yearcurrent = date("y")."-".$yearnext;
                      // echo "<pre>";
                      //   print_r($year);
                      //   echo "</pre>";
                        $employee_req= $reqName."/".$indentNo."/".$yearcurrent;
                        // echo "<pre>";
                        // print_r($employee_req);
                        // echo "</pre>";

endforeach;
                  endforeach;
                endif;?>
                     
                  
                    
                <div class="form-group">

                  <label>Requistion No</label>                   
                                                                                                        
                  <input class="form-control form-control-sm" name="employee_req" id="employee_req" type="text" value="<?= $employee_req ?>" readonly>
                </div>
                  
       