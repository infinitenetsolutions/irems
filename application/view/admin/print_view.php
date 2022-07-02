<!-- Category Management -->
<?php
   require_once("include/auth.php");
    require_once("application/classes-and-objects/config.php");
    require_once("application/classes-and-objects/veriables.php"); 
     require_once("include/auth.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if($setting->setting_firm_info->firm_nick_name != "") echo $setting->setting_firm_info->firm_nick_name; else echo $setting->setting_firm_info->firm_name; ?> | Inventory Reports</title>
    <!-- Css Section Start -->
    <?php require_once("include/css.php"); ?>
    <!-- Css Section End -->
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm accent-navy pace-red">
    <div id="wrapper" class="wrapper">
        <!-- Navbar Section Start -->
        <?php require_once("include/navbar.php"); ?>

        <!-- Navbar Section End -->
        <!-- Main Sidebar Section Start -->
        <?php require_once("include/aside.php"); ?>

        <!-- Main Sidebar Section End -->

        <!-- All Contains Section Start -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Inventory Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Reports</li>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->

              <div class="page">




<div class="page-content">
<?php
// GOODS RECEIPT VIEW PAGE START------------------------------------------------
 if ($_GET["action"] == "view_receipt"){
   $in_ordersid = $_GET["id"];



         $databaseObj->select("tbl_manage_po");
        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '$in_ordersid'");
        $databaseObj->order_by("`manage_po_id` DESC");
        $result_receipt = $databaseObj->get();


        $databaseObj->select("tbl_manage_item");
        $databaseObj->where("`status` = '".$auth->visible()."'");
         $result = $databaseObj->get();
          foreach($result_receipt as $row):
            $manage_po_info = json_decode($row["manage_po_info"]);
            $manage_receipt_info = json_decode($row["in_items_received"]);

 ?>


  <!-- Panel Mode Switch -->
  <div class="panel">
    <header class="panel-heading" style="margin-left: 9.6px;">
      <h3 class="panel-title bg-info text-white" style="background-color:#001f3f!important;">GOODS RECEIPT DETAILS</h3>
      <?php  ?>
    </header>
    <div class="panel-body">
      <div class="row row-lg">
        <div class="col-lg-12">
          <div class="vendor-wrap">
          <div class="row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-1">&nbsp;</div>
            <div class="col-sm-3 text-info">&nbsp;</div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
            <div class="row">
              <div class="col-sm-2">Ordered Date</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $manage_po_info->poDate ?></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-2">Purchase Order No</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $manage_receipt_info->order_no ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">Goods Receipt Note No</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?php echo $row["rec_note_no"]; ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">Received Date</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $manage_receipt_info->receipt_date ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">Supplier Name</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?php echo $manage_receipt_info->vendor_name ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">&nbsp;</div>
              <div class="col-sm-1">&nbsp;</div>
              <div class="col-sm-3 text-info">&nbsp;</div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
          </div>
        </div>
      </div>
      <div class="vendor table-responsive">
        <table class="table" id="" style="margin-left: 13px;">

          <thead>
            <tr class="bg-info" style="background-color: #001f3f!important;">
              <th>S.NO</th>
              <th>ITEM CODE</th>
              <th>ITEM NAME</th>
              <th>ORDERED QUANTITY</th>
              <th>RECEIVED QUANTITY</th>
              <th>PRICE</th>
              <th>AMOUNT</th>
            </tr>
          </thead>
          <tbody>
            <?php


            $cnt = 1; 

            //  foreach($result_receipt as $rows):
            //  $manage_po_info = json_decode($row["manage_po_info"]);
            // $manage_receipt_info = json_decode($row["in_items_received"]);
            foreach($manage_po_info->item_info as $res):

            foreach($manage_receipt_info->recv_item_info as $value):
            // echo "<pre>";
            // print_r($manage_po_info->item_info); 

            // print_r($manage_receipt_info->recv_item_info);  exit;
               ?>
               <tr>
            <td><?php echo $cnt++; ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemCode) {
                echo $item["itemCode"];
              }
            }
             ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemName) {
                echo $item["itemName"];
              }
            }
             ?></td>

            <td><?php echo $res->quantity; ?></td>

            <td><?php echo $value->quantity;  ?></td>

            <td><?php echo $value->rate; ?></td>
            
            <td><?php echo $value->total; ?></td>
               </tr>
               <?php
             //}
             ?>

             <?php
           endforeach;
           //}
               ?>
                <tr>
               <td colspan="5"></td>
               <td>Total : </td>
               <td><?php echo $row["total_amount"]; ?></td>
             </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- End Panel Mode Switch -->
<?php 

 endforeach;
endforeach;
}
// GOODS RECEIPT VIEW PAGE END--------------------------------------------------
// PURCHASE ORDER VIEW PAGE START-----------------------------------------------
 if ($_GET["action"] == "pur_ord"){

   //echo "working"; exit;
    $in_ordersid = $_GET["id"];

   // $sql_receipt = "SELECT * FROM `in_orders` WHERE `in_ordersid`='$in_ordersid'";
   // $result_receipt = $conn->query($sql_receipt);

   // $sql = "SELECT * FROM `in_item_master`";
   // $result = $conn->query($sql);
   // foreach ($result_receipt as $row) {

        $databaseObj->select("tbl_manage_po");
        $databaseObj->where("`status` = '".$auth->visible()."' && `manage_po_id` = '$in_ordersid'");
        $databaseObj->order_by("`manage_po_id` DESC");
        $result_receipt = $databaseObj->get();


        $databaseObj->select("tbl_manage_item");
        $databaseObj->where("`status` = '".$auth->visible()."'");
         $result = $databaseObj->get();
          foreach($result_receipt as $row):
            $manage_po_info = json_decode($row["manage_po_info"]);


 ?>


  <!-- Panel Mode Switch -->
  <div class="panel">
    <header class="panel-heading" style="margin-left: 9.8px;">
      <h3 class="panel-title bg-info text-white" style="background-color:#001f3f!important;">Purchase Order Details</h3>
    </header>
    <div class="panel-body">
      <div class="row row-lg">
        <div class="col-lg-12">
          <div class="vendor-wrap" style="margin-left:18px;">
          <div class="row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-1">&nbsp;</div>
            <div class="col-sm-3 text-info">&nbsp;</div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
          <div class="row">
            <div class="col-sm-2">Supplier Name</div>
            <div class="col-sm-1">-</div>
            <div class="col-sm-3 text-info"><?= $manage_po_info->vendor_name ?></div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
            <div class="row">
              <div class="col-sm-2">Ordered Date</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $manage_po_info->poDate ?></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-2">Purchase Order No</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $manage_po_info->orderNo ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">Status</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?php echo $row["order_status"]; ?></div>
              <div class="col-sm-6">&nbsp;</div>
            <div class="row">
              <div class="col-sm-2">&nbsp;</div>
              <div class="col-sm-1">&nbsp;</div>
              <div class="col-sm-3 text-info">&nbsp;</div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
          </div>
        </div>
      </div>
      <div class="vendor table-responsive">
        <table class="table" id="" style="margin-left: 15px;">
          <thead>
            <tr class="bg-info" style="background-color: #001f3f!important;">
              <th>S.NO</th>
              <th>ITEM CODE</th>
              <th>ITEM NAME</th>
              <th>UOM</th>
              <th>QUANTITY</th>
              <th>AMOUNT</th>
            </tr>
          </thead>
          <tbody>
            <?php

             $cnt = 1; 

             foreach($result_receipt as $rows):
            $in_items_purchased = json_decode($rows["manage_po_info"]);
           
            foreach($in_items_purchased->item_info as $value):

          //   foreach($manage_po_info->item_info as $manage_po_item_info):

          // $databaseObj->select("tbl_manage_item");
          // $databaseObj->where("`status` = '".md5("visible")."' && `manage_item_id` = '".$manage_po_item_info->itemCode."'");
          // $item_det = $databaseObj->get(); 
          // $item_details =  array();
          // foreach($item_det as $item_det_all)
          // $item_details = $item_det_all;

            // foreach ($result_receipt as $rows) {
            //  $in_items_purchased = json_decode($rows["manage_po_info"]);
            //  foreach ($in_items_purchased as $value) {
               ?>
               <tr>
            <td><?php echo $cnt++; ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemCode) {
                echo $item["itemCode"];
              }
            }
             ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemName) {
                echo $item["itemName"];
              }
            }
             ?></td>

               <td><?php echo $value->uom; ?>&nbsp;<?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->uom) {
                echo $item["Uom"];
              }
            }
             ?></td>
            <td><?php echo $value->quantity; ?>&nbsp;<?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->quantity) {
                echo $item["quantity"];
              }
            }
             ?></td>
             <td><?php echo $value->total; ?>&nbsp;<?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->total) {
                echo $item["total"];
              }
            }
             ?></td>
               </tr>
               <?php
            // }
             ?>
             <?php
           //}
           endforeach;
               ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- End Panel Mode Switch -->
<?php 
  endforeach;
endforeach;
   }
?>

<!----PURCHASE ORDER VIEW PAGE END----------------------------------------------->

<!----GOODS ISSUE VIEW PAGE START----------------------------------------------->



<?php

if ($_GET["action"] == "issue"){

   //echo "working"; exit;
    $in_goods_issueid = $_GET["id"];

   
        $databaseObj->select("tbl_goods_issue");
        $databaseObj->where("`status` = '".$auth->visible()."' && `goods_issue_id` = '$in_goods_issueid'");
        $databaseObj->order_by("`goods_issue_id` DESC");
        $result_issue = $databaseObj->get();


        $databaseObj->select("tbl_manage_item");
        $databaseObj->where("`status` = '".$auth->visible()."'");
         $result = $databaseObj->get();
          foreach($result_issue as $row):
            $goods_issue_info = json_decode($row["goods_issue_info"]);


 ?>


  <!-- Panel Mode Switch -->
  <div class="panel">
    <header class="panel-heading" style="margin-left: 9.8px;">
      <h3 class="panel-title bg-info text-white" style="background-color:#001f3f!important;">ISSUED ITEMS</h3>
    </header>
    <div class="panel-body">
      <div class="row row-lg">
        <div class="col-lg-12">
          <div class="vendor-wrap" style="margin-left:18px;">
          <div class="row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-1">&nbsp;</div>
            <div class="col-sm-3 text-info">&nbsp;</div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
          <div class="row">
            <div class="col-sm-2">Issued To</div>
            <div class="col-sm-1">-</div>
            <div class="col-sm-3 text-info"><?= $goods_issue_info->issueTo ?></div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
            <div class="row">
              <div class="col-sm-2">Issued By</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $goods_issue_info->issueBy ?></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-2">Issued Date</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $goods_issue_info->ginDate ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">Issue Note No</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $goods_issue_info->ginNo ?></div>
              <div class="col-sm-6">&nbsp;</div>
            
          </div>

<div class="row">
              <div class="col-sm-2">Status</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?php echo $row["goods_issue_status"]; ?></div>
              <div class="col-sm-6">&nbsp;</div>
            <div class="row">
              <div class="col-sm-2">&nbsp;</div>
              <div class="col-sm-1">&nbsp;</div>
              <div class="col-sm-3 text-info">&nbsp;</div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
          </div>



        </div>
      </div>
      <div class="vendor table-responsive">
        <table class="table" id="" style="margin-left: 15px;">
          <thead>
            <tr class="bg-info" style="background-color: #001f3f!important;">
              <th>S.NO</th>
              <th>ITEM CODE</th>
              <th>ITEM NAME</th>
              <th>ISSUED QUANTITY</th>
              <th>RETURNED QUANTITY</th>
              <th>COMMENTS</th>
            </tr>
          </thead>
          <tbody>
            <?php

             $cnt = 1; 

             foreach($result_issue as $rows):
            $in_issued_items = json_decode($rows["goods_issue_info"]);
            $in_returned_items = json_decode($row["goods_issue_returned"]);

            foreach($in_issued_items->items as $value):

          
               ?>
               <tr>
            <td><?php echo $cnt++; ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemCode) {
                echo $item["itemCode"];
              }
            }
             ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemName) {
                echo $item["itemName"];
              }
            }
             ?></td>


             <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->quantity) {
                echo $item["quantity"];
              }
            }
             ?></td>

              
            <td>
            <?php
            if (!empty($in_returned_items)) {
              // foreach ($in_returned_items as $in_returned_items_all) {
              //   foreach ($in_returned_items_all->recv_item_info as $return) {
              //     print_r($return);
              //     if ($return->issue_no == $value->ginNo) {
              //       echo $return->quantity;
              //     }
              //   }
              // }
              foreach ($in_returned_items as $in_returned_items_all) {
                if ($in_issued_items->ginNo == $in_returned_items_all->issue_no) {
                  foreach ($in_returned_items_all->recv_item_info as $return) {
                    //echo $return->quantity."<br/>";

                    if ($return->issue_no == $value->ginNo) {
                     echo $return->quantity;
                   }
                  }
                }
              }


              ?>&nbsp;<?php
              foreach ($result as $item) {
                if ($item["manage_item_id"] == $value->quantity) {
                  echo $item["quantity"];
                }
              }
            } else {
              echo "0";
            }?>



              <!-- <?php echo $value->quantity; ?>&nbsp;<?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->quantity) {
                echo $item["quantity"];
              }
            }
             ?> --></td>
             <td><?php echo $value->remarks; ?></td>
               </tr>
               <?php
            // }
             ?>
             <?php
           //}
           endforeach;
               ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- End Panel Mode Switch -->
<?php 
  endforeach;
endforeach;
   }

?>

<!----GOODS ISSUE VIEW PAGE END----------------------------------------------->




<!----GOODS RECEIPT VIEW PAGE START----------------------------------------------->

<?php

if ($_GET["action"] == "issue"){

   //echo "working"; exit;
    $in_goods_issueid = $_GET["id"];

   
        $databaseObj->select("tbl_goods_issue");
        $databaseObj->where("`status` = '".$auth->visible()."' && `goods_issue_id` = '$in_goods_issueid'");
        $databaseObj->order_by("`goods_issue_id` DESC");
        $result_issue = $databaseObj->get();


        $databaseObj->select("tbl_manage_item");
        $databaseObj->where("`status` = '".$auth->visible()."'");
         $result = $databaseObj->get();
          foreach($result_issue as $row):
            $goods_issue_info = json_decode($row["goods_issue_info"]);


 ?>


  <!-- Panel Mode Switch -->
  <div class="panel">
    <header class="panel-heading" style="margin-left: 9.8px;">
      <h3 class="panel-title bg-info text-white" style="background-color:#001f3f!important;">ISSUED ITEMS</h3>
    </header>
    <div class="panel-body">
      <div class="row row-lg">
        <div class="col-lg-12">
          <div class="vendor-wrap" style="margin-left:18px;">
          <div class="row">
            <div class="col-sm-2">&nbsp;</div>
            <div class="col-sm-1">&nbsp;</div>
            <div class="col-sm-3 text-info">&nbsp;</div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
          <div class="row">
            <div class="col-sm-2">Issued To</div>
            <div class="col-sm-1">-</div>
            <div class="col-sm-3 text-info"><?= $goods_issue_info->issueTo ?></div>
            <div class="col-sm-6">&nbsp;</div>
          </div>
            <div class="row">
              <div class="col-sm-2">Issued By</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $goods_issue_info->issueBy ?></div>
              <div class="col-sm-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-2">Issued Date</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $goods_issue_info->ginDate ?></div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
            <div class="row">
              <div class="col-sm-2">Issue Note No</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?= $goods_issue_info->ginNo ?></div>
              <div class="col-sm-6">&nbsp;</div>
            
          </div>

<div class="row">
              <div class="col-sm-2">Status</div>
              <div class="col-sm-1">-</div>
              <div class="col-sm-3 text-info"><?php echo $row["goods_issue_status"]; ?></div>
              <div class="col-sm-6">&nbsp;</div>
            <div class="row">
              <div class="col-sm-2">&nbsp;</div>
              <div class="col-sm-1">&nbsp;</div>
              <div class="col-sm-3 text-info">&nbsp;</div>
              <div class="col-sm-6">&nbsp;</div>
            </div>
          </div>



        </div>
      </div>
      <div class="vendor table-responsive">
        <table class="table" id="" style="margin-left: 15px;">
          <thead>
            <tr class="bg-info" style="background-color: #001f3f!important;">
              <th>S.NO</th>
              <th>ITEM CODE</th>
              <th>ITEM NAME</th>
              <th>ISSUED QUANTITY</th>
              <th>RETURNED QUANTITY</th>
              <th>COMMENTS</th>
            </tr>
          </thead>
          <tbody>
            <?php

             $cnt = 1; 

             foreach($result_issue as $rows):
            $in_issued_items = json_decode($rows["goods_issue_info"]);
            $in_returned_items = json_decode($row["goods_issue_returned"]);

            foreach($in_issued_items->items as $value):

          
               ?>
               <tr>
            <td><?php echo $cnt++; ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemCode) {
                echo $item["itemCode"];
              }
            }
             ?></td>
            <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->itemName) {
                echo $item["itemName"];
              }
            }
             ?></td>


             <td><?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->quantity) {
                echo $item["quantity"];
              }
            }
             ?></td>

              
            <td>
            <?php
            if (!empty($in_returned_items)) {
              // foreach ($in_returned_items as $in_returned_items_all) {
              //   foreach ($in_returned_items_all->recv_item_info as $return) {
              //     print_r($return);
              //     if ($return->issue_no == $value->ginNo) {
              //       echo $return->quantity;
              //     }
              //   }
              // }
              foreach ($in_returned_items as $in_returned_items_all) {
                if ($in_issued_items->ginNo == $in_returned_items_all->issue_no) {
                  foreach ($in_returned_items_all->recv_item_info as $return) {
                    //echo $return->quantity."<br/>";

                    if ($return->issue_no == $value->ginNo) {
                     echo $return->quantity;
                   }
                  }
                }
              }


              ?>&nbsp;<?php
              foreach ($result as $item) {
                if ($item["manage_item_id"] == $value->quantity) {
                  echo $item["quantity"];
                }
              }
            } else {
              echo "0";
            }?>



              <!-- <?php echo $value->quantity; ?>&nbsp;<?php
            foreach ($result as $item) {
              if ($item["manage_item_id"] == $value->quantity) {
                echo $item["quantity"];
              }
            }
             ?> --></td>
             <td><?php echo $value->remarks; ?></td>
               </tr>
               <?php
            // }
             ?>
             <?php
           //}
           endforeach;
               ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- End Panel Mode Switch -->
<?php 
  endforeach;
endforeach;
   }

?>

<!----GOODS RECEIPT VIEW PAGE END----------------------------------------------->







 </div>
</div>
</div>



 










            <!-- /.content -->
        </div>
        <!-- Add New Section Start -->
      
        <!-- Add New Section End -->
        
      
         <?php require_once("include/footer.php"); ?>
       <?php require_once("include/js.php"); ?>

    <script src="dist/js/ajax.js"></script>
    <script src="dist/js/admin/print-view.js"></script>
    <!-- Js Section End -->

  

  
</body>


<!-- Mirrored from getbootstrapadmin.com/remark/material/iconbar/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 14 Mar 2020 15:25:24 GMT -->
</html>
