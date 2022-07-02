<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller {
    public function __construct()
   {
        parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Utilitylib');
		 $this->load->model('Ingrediants_model','im'); 
		$this->load->model('Vendor_model','vendor');
		$this->load->model('Purchase_model','purchase');
    $this->load->model('Product_model','pm');
    $this->load->model('Prod_order_model','pom'); 
    $this->load->model('Packaging_order_model','pcom'); 
   $this->load->model('Pro_process_model','ppm');

    $this->load->model('Product_costing_model','pcm'); 
    $this->load->model('Vendor_model','vendor');
    $this->load->model('Packaging_model','pacm');
    $this->load->model('Process_log_model','plm');
    $this->load->model('Pro_in_link_model','pilm');
    $this->load->model('Waste_material_model','wmm');
    $this->load->model('Inventory_model','in');
    $this->load->model('Company_model','company');
    $this->data['view_path'] = $_SERVER['DOCUMENT_ROOT'].'/ateeb-foods/application/views/';  
    date_default_timezone_set('asia/kolkata');

   }


   public function stock()

	{	

			$this->data['page'] = 'Inventory';
			$this->data['sub_page'] = 'Stock';
   		    $this->data['products'] = $this->pm->getAllProducts();

			$this->load->view('admin/include/header',$this->data);
			$this->load->view('admin/include/sidebar',$this->data);
			$this->load->view('admin/inventory/stock',$this->data);


	}


   public function packaging_attribute()

  { 

      $this->data['page'] = 'Inventory';
      $this->data['sub_page'] = 'Packaging Attribute';

     $this->data['products'] = $this->pm->getAllProducts();

     // echo "<pre>";
     // print_r($this->data['products']);

          
      $this->load->view('admin/include/header',$this->data);
      $this->load->view('admin/include/sidebar',$this->data);
      $this->load->view('admin/inventory/packaging_attribute',$this->data);


  }



  


	 public function fetch_all_rawMaterials()
    {


          $output="";
           //$postData = $this->input->post();
           // echo "<pre>";
           // print_r($postData ); exit;
            $data = $this->in->get_all_rawMaterialsItems('ingrediants');

            $output.= '<div class="panel-body table-responsive">
                         <table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                               <tr>
								<th class="text-nowrap">S No</th>
								<th class="text-nowrap">Ingredient</th>
								<th class="text-nowrap">Quantity</th>
								<th class="text-nowrap">Price</th>';

				                  $output .='</tr></thead><tbody>';
							$cnt = 1;
							foreach($data as $row)
							{
                             
                            $output .= '<tr id="viewColumn">
                                        <td>'.$cnt++.'</td>
            <td><a href="InOrder_details?IngredientId='.$row['in_id'].'" target="_blank">'.$row['in_name'].'</a></td>
                                        <td>'.$row['In_qty'].'</td>
                                        <td>'.$row['In_price'].'</td>';
                           $output .=  '</tr>';

                               }$cnt++;
									$output .= '</tbody></table></div>
									';	
			echo $output;
	}





	 public function show_order_details_view()
            {
               
             
               $output='';


          $data = $this->in->get_InOrderDetails_data($_POST['in_id'],$_POST['start_date'],$_POST['end_date'],$_POST['order_status']);

               
           // $data = $this->in->get_InOrderDetails_data($_POST['in_id'],$_POST['order_status'],$_POST['start_date'],$_POST['end_date']);
             // echo "<pre>";
             // print_r( $data); 
             //  exit;

                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
					            
                  <thead>
                  <tr>
					<th class="text-nowrap">PO No</th>
					<th class="text-nowrap">Vendor Name</th>
					<th class="text-nowrap">Quantity</th>
					<th class="text-nowrap">Rate</th>
					<th class="text-nowrap">Amount</th>
					<th class="text-nowrap">CGST</th>
					<th class="text-nowrap">SGST</th>
					<th class="text-nowrap">IGST</th>
					<th class="text-nowrap">Total</th>

                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                  $total_rate = 0;
                  $total_amount = 0;
                   $total_cgstamt = 0;
                    $total_sgstamt = 0; 
                    $total_igstamt = 0; 
                    $total_quantity = 0;
                    $grand_total = 0;
                        foreach($data as $row)
                         {

                         	$total_quantity +=  ($row['unit'] == 'Kg'?$row['quantity']:$row['quantity']/1000);
                         	$total_amount += $row['amount'];
                         	$total_cgstamt += $row['cgstamt'];
                         	$total_sgstamt += $row['sgstamt'];
                         	$total_igstamt += $row['igstamt'];
                         	$grand_total += $row['total'];

                          $vendors = $this->vendor->get_vendor_byId($row['vendor_id']);
                          //echo($vendors);
                          $output .= '
                        <tr>
                        <td>'.$row['po_no'].'</td>
                        <td>'.$row['vendor_id'].'</td>';
                  $output .= '<td>'. $row['quantity'] .' '.$row['unit'].'</td>';
                           
              $output .= '<td>₹'.$row['rate'].'</td>
                         <td>₹'.$row['amount'].'</td>
                          <td>₹'.$row['cgstamt'].'</td>
                           <td>₹'.$row['sgstamt'].'</td>
                            <td>₹'.$row['igstamt'].'</td>
                             <td>₹'.$row['total'].'</td>
                        </tr>
                        ';
                        } $cnt++;
                  $output .= '</tbody>
                  <tfoot>
                        <tr>
                        	<th></th>
							<th>Total:</th>
							<th>'.$total_quantity.' Kg</th>
							<th></th>
							<th>₹'.$total_amount.'</th>
							<th>₹'.$total_cgstamt.'</th>
							<th>₹'.$total_sgstamt.'</th>
							<th>₹'.$total_igstamt.'</th>
							<th>₹'.$grand_total.'</th>
                        </tr>


                        </tfoot></table>';
                        echo $output;
        }







	public function InOrder_details()
{


        $this->data['page'] = 'Inventory';
		$this->data['sub_page'] = 'Stock';

		  $in_id = $_GET['IngredientId'];

	     $this->data['ingredients']=$this->im->get_inById($in_id);
		//  $this->data['po_item'] = $this->purchase->get_po_item_by_po_no($po_no,'tbl_po');
	     $this->data['po_in_item'] = $this->purchase->get_po_in_item_by_Inid($in_id);
          // echo "<pre>";
          // print_r($this->data['ingredients']); exit;

        $this->load->view('admin/include/header',$this->data);
		$this->load->view('admin/include/sidebar',$this->data);
		$this->load->view('admin/inventory/ingrednt_order_details',$this->data);
	

}




	 public function Product_details()
{


        $this->data['page'] = 'Inventory';
    $this->data['sub_page'] = 'Stock';

      $product_id = $_GET['ProductId'];
      $pac_id = $_GET['PacketId'];

      
       $this->data['products']=$this->pm->getProductById($product_id);
    //  $this->data['po_item'] = $this->purchase->get_po_item_by_po_no($po_no,'tbl_po');
       $this->data['product_item'] = $this->pom->getProductsByproductandpacket($product_id, $pac_id);
          //echo "<pre>";
           // print_r($this->data['product_item']); exit;

        $this->load->view('admin/include/header',$this->data);
    $this->load->view('admin/include/sidebar',$this->data);
    $this->load->view('admin/inventory/product_order_details',$this->data);
  

}





 public function fetch_nutrifact()

 {
      
         $p_id = $_POST['p_id'];
         $pac_id = $_POST['pac_id']; 

        $nutfact = $this->in->getnutfact($p_id,$pac_id);

       $PACKETdETAILS = $this->pacm->getProductSizeBypidandpacketid($p_id,$pac_id);

       // echo "<pre>";
       // print_r($PACKETdETAILS);


        ?>

       

      <div class="modal-loader">
      <span class="spinner"></span>
    </div>
<div class="modal-header">
  <h4 class="modal-title">Nutritional Fact for <?=$PACKETdETAILS['p_name']. ' - '.$PACKETdETAILS['size'].' '.$PACKETdETAILS['unit'].''?></h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
  <form onsubmit="return submitnutrifactform(this)" autocomplete="off">
  <div class="modal-body">
    <?php foreach ($nutfact as $res) {?>
    <div class="row mb-1" id="wm_row_<?=$res['nf_id']?>">

      <div class="col-4">
        <label>Nutritional Fact Name</label>
        <input type="hidden" name="nf_id[]" value="<?=$res['nf_id']?>">
        <input type="hidden" name="p_id[]" value="<?=$res['p_id']?>">
        <input type="hidden" name="pac_id[]" value="<?=$res['pac_id']?>">


        <textarea name="nf_name[]" value="" autocomplete="" class="form-control" onkeyup="getplaceholdervalues1(this)" placeholder="Enter Nutritional Fact Name"><?=$res['nf_name']?></textarea>
        <ul class="placeholder" id="placeholder"></ul>
      </div>

       <div class="col-4">
        <label>Nutritional Fact Value</label>
        <input type="text" name="nf_value[]" value="<?=$res['nf_value']?>" class="form-control" placeholder="Enter Nutritional Fact Value"></div>
     
     
      <div class="col-4">
        <button class="btn btn-md btn-icon btn-circle btn-danger pull-right mt-3" type="button" onclick="delete_nutfact(<?=$res['nf_id']?>)"><i class="fa fa-trash"></i></button>
      </div>
    </div>
    <?php } ?>

        <div class="form-group row mb-2 file-repeater">
          
          <div class="col-12" data-repeater-list="nutrifact">
            <div class="mb-1" data-repeater-item>
              
              <div class="row">
                <div class="col-4">
                  <label>Attribute Name</label>
                   <input type="hidden" name="p_id" value="<?=$_POST['p_id']?>">
                   <input type="hidden" name="pac_id" value="<?=$_POST['pac_id']?>">
                  <textarea type="text" name="nf_name" class="form-control" placeholder="Enter Nutritional Description" onkeyup="getplaceholdervalues1(this)"></textarea>
                  <ul class="placeholder" id="placeholder"></ul>
                </div>

                <div class="col-4">
                <label>Nutritional Fact Value</label>
                <input type="text" name="nf_value" value="" class="form-control" placeholder="Enter Nutritional Fact Value"></div>
     

              
                <div class="col-4">
                  <button data-repeater-delete type="button" class="btn btn-md btn-icon btn-circle btn-danger pull-right mt-3"><i class="fa fa-trash"></i></button>
                </div>
              </div>
            </div>
          </div>
          <legend class="m-b-15 px-2"><button type="button" data-repeater-create class="btn btn-md btn-icon btn-circle btn-primary pull-right">
            <i class="fa fa-plus"></i>
          </button></legend>
        </div>


  </div>
  <div class="modal-footer">
    <a href="javascript:void(0);" class="btn btn-white" data-dismiss="modal">Close</a>
    <input type="submit" class="btn btn-success" value="Save">
  </div>
    </form>



<?php } 






 public function fetch_packagingattr()

 {
      
         $p_id = $_POST['p_id'];
         $pac_id = $_POST['pac_id']; 

        $attr = $this->in->getproductattrlist($p_id,$pac_id);
       

       $PACKETdETAILS = $this->pacm->getProductSizeBypidandpacketid($p_id,$pac_id);

       // echo "<pre>";
       // print_r($PACKETdETAILS);
       // print_r($nutfact);

        ?>

       

      <div class="modal-loader">
      <span class="spinner"></span>
    </div>
<div class="modal-header">
  <h4 class="modal-title">Configure Attribute for <?=$PACKETdETAILS['p_name']. ' - '.$PACKETdETAILS['size'].' '.$PACKETdETAILS['unit'].''?></h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
  <form onsubmit="return submitpackagingattrform(this)" autocomplete="off">
  <div class="modal-body">
    <?php foreach ($attr as $res) {?>
    <div class="row mb-1" id="wm_row_<?=$res['attr_id']?>">

      <div class="col-4">
        <label>Attribute Name</label>
        <input type="hidden" name="attr_id[]" value="<?=$res['attr_id']?>">
        <input type="hidden" name="p_id[]" value="<?=$res['p_id']?>">
        <input type="hidden" name="pac_id[]" value="<?=$res['pac_id']?>">


        <input type="text" name="attr_name[]" value="<?=$res['attr_name']?>" autocomplete="" class="form-control" onkeyup="getplaceholdervalues(this)" placeholder="Enter Attribute Name">
        <ul class="placeholder" id="placeholder"></ul>
      </div>
      <div class="col-4">
        <label>Attribute Value</label>
        <input type="text" name="attr_value[]" value="<?=$res['attr_value']?>" class="form-control" placeholder="Enter  Attribute Value"></div>
     
      <div class="col-4">
        <button class="btn btn-md btn-icon btn-circle btn-danger pull-right mt-3" type="button" onclick="delete_attr(<?=$res['attr_id']?>)"><i class="fa fa-trash"></i></button>
      </div>
    </div>
    <?php } ?>

        <div class="form-group row mb-2 file-repeater">
          
          <div class="col-12" data-repeater-list="configureAttribute">
            <div class="mb-1" data-repeater-item>
              
              <div class="row">
                <div class="col-4">
                  <label>Attribute Name</label>
                   <input type="hidden" name="p_id" value="<?=$_POST['p_id']?>">
                   <input type="hidden" name="pac_id" value="<?=$_POST['pac_id']?>">
                  <input type="text" name="attr_name" class="form-control" placeholder="Enter Attribute Name" onkeyup="getplaceholdervalues(this)">
                  <ul class="placeholder" id="placeholder"></ul>
                </div>
                <div class="col-4">
                  <label>Attribute Value</label>
                  <input type="text" name="attr_value" class="form-control" placeholder="Enter Attribute Value"></div>
                
                <div class="col-4">
                  <button data-repeater-delete type="button" class="btn btn-md btn-icon btn-circle btn-danger pull-right mt-3"><i class="fa fa-trash"></i></button>
                </div>
              </div>
            </div>
          </div>
          <legend class="m-b-15 px-2"><button type="button" data-repeater-create class="btn btn-md btn-icon btn-circle btn-primary pull-right">
            <i class="fa fa-plus"></i>
          </button></legend>
        </div>


  </div>
  <div class="modal-footer">
    <a href="javascript:void(0);" class="btn btn-white" data-dismiss="modal">Close</a>
    <input type="submit" class="btn btn-success" value="Save">
  </div>
    </form>



<?php } 




 public function submitpackagingattrform(){
      $sql = false;
      for ($i=0; $i < count(@$_POST['attr_id']); $i++){ 
        $filterarray['p_id'] = $_POST['p_id'][$i];
        $filterarray['pac_id'] = $_POST['pac_id'][$i];
        $filterarray['attr_name'] = $_POST['attr_name'][$i];
        $filterarray['attr_value'] = $_POST['attr_value'][$i];
        $checkattr = $this->in->getFilterData($filterarray);
        if(empty($checkwm)){
          $sql = $this->in->update($_POST['attr_id'][$i],$filterarray);
        }
      }
      for ($i=0; $i < count($_POST['configureAttribute']); $i++){ 
        if ($_POST['configureAttribute'][$i]['attr_name'] != '' && $_POST['configureAttribute'][$i]['attr_value'] != '') {
            $filterarray['p_id'] = $_POST['configureAttribute'][$i]['p_id'];
            $filterarray['pac_id'] = $_POST['configureAttribute'][$i]['pac_id'];
            $filterarray['attr_name'] = $_POST['configureAttribute'][$i]['attr_name'];
            $filterarray['attr_value'] = $_POST['configureAttribute'][$i]['attr_value'];
          $checkwm = $this->in->getFilterData($filterarray);

          if(empty($checkwm)){
            $sql = $this->in->insert($filterarray);
          }else{
            $updatearray['attr_value'] = $_POST['configureAttribute'][$i]['attr_value'];
            $sql = $this->in->updatebyarray($updatearray,$filterarray);
          }
        }
      }
      if ($sql) {
        $response['status'] = true;
        $response['message'] = 'Package Attribute is updated successfully';
      } else {
        $response['status'] = false;
        $response['message'] = 'something went wrong while updating Package Attribute . please try again later';
      }
      echo json_encode($response);
    }



     public function submitnutrifactform(){
      $sql = false;
      for ($i=0; $i < count(@$_POST['nf_id']); $i++){ 
        $filterarray['p_id'] = $_POST['p_id'][$i];
        $filterarray['pac_id'] = $_POST['pac_id'][$i];
        $filterarray['nf_name'] = $_POST['nf_name'][$i];
        $filterarray['nf_value'] = $_POST['nf_value'][$i];

        $checkattr = $this->in->getFilterData1($filterarray);
        if(empty($checkwm)){
          $sql = $this->in->update1($_POST['nf_id'][$i],$filterarray);
        }
      }
      for ($i=0; $i < count($_POST['nutrifact']); $i++){ 
        if ($_POST['nutrifact'][$i]['nf_name'] != '' && $_POST['nutrifact'][$i]['nf_value'] != '') {
            $filterarray['p_id'] = $_POST['nutrifact'][$i]['p_id'];
            $filterarray['pac_id'] = $_POST['nutrifact'][$i]['pac_id'];
            $filterarray['nf_name'] = $_POST['nutrifact'][$i]['nf_name'];
            $filterarray['nf_value'] = $_POST['nutrifact'][$i]['nf_value'];

          $checkwm = $this->in->getFilterData1($filterarray);

          if(empty($checkwm)){
            $sql = $this->in->insert1($filterarray);
          }else{
            $updatearray['nf_value'] = $_POST['nutrifact'][$i]['nf_value'];
            $sql = $this->in->updatebyarray1($updatearray,$filterarray);
          }
        }
      }
      if ($sql) {
        $response['status'] = true;
        $response['message'] = 'Package Attribute is updated successfully';
      } else {
        $response['status'] = false;
        $response['message'] = 'something went wrong while updating Package Attribute . please try again later';
      }
      echo json_encode($response);
    }




     public function getplaceholdervalues()
    {
      $key = $_POST['key'];
      $result = $this->in->getplaceholdervalues($key);
      foreach ($result as $val) {
        echo '<li onclick="getthisvalue(this)">'.$val['attr_name'].'</li>';
      }
    }


     public function getplaceholdervalues1()
    {
      $key = $_POST['key'];
      $result = $this->in->getplaceholdervalues1($key);
      foreach ($result as $val) {
        echo '<li onclick="getthisvalue1(this)">'.$val['nf_name'].'</li>';
      }
    }



    public function delete_nutfact()
    {
      $sql = $this->db->where('nf_id',$_POST['nf_id'])->delete('nutritional_facts');
       if ($sql) {
        $response['status'] = true;
        $response['message'] = 'Nutritional Facts is deleted successfully';
      } else {
        $response['status'] = false;
        $response['message'] = 'something went wrong while deleted Nutritional Facts. please try again later';
      }
      echo json_encode($response);
    }



// Delete Attribute 

public function delete_attr()
    {
      $sql = $this->db->where('attr_id',$_POST['attr_id'])->delete('packaging_attribute');
       if ($sql) {
        $response['status'] = true;
        $response['message'] = 'Packaging Attribute is deleted successfully';
      } else {
        $response['status'] = false;
        $response['message'] = 'something went wrong while deleted Packaging Attribute. please try again later';
      }
      echo json_encode($response);
    }
// Delete Attribute 


   
// PROCESS LOG 

 public function fetch_processlog_details()
    
  {
         $p_id = $_POST['p_id'];
         $pac_id = $_POST['pac_id'];
         $batch_no = $_POST['batch_no'];
         $processlog_details = $this->plm->fetch_processlog_details($p_id,$pac_id,$batch_no);
        
         $productSize = $this->pacm->getProductSizeBypidandpacketid($p_id,$pac_id);

         ?> 


      <div class="modal-header">
  <h4 class="modal-title">Process log Details of <?=$productSize['p_name']?> (<?=$productSize['size']?> <?=$productSize['unit']?>) </h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-0">
<div class="widget-list widget-list-rounded" data-id="widget">
  <?php $i=1; foreach ($processlog_details as $row) {
  $earlier = new DateTime($row['start_time']);
  $later = new DateTime($row['end_time']);
  $diff = $later->diff($earlier)->format("%a day %h hour %i min %s sec");
  //echo $diff;
  
        
    ?>
  <div class="widget-list-item">
    <div class="widget-list-media">
      <p>Step : <?=$i?></p>
    </div>
    <div class="widget-list-content">
      <h4 class="widget-list-title"><?=$row['process_title'].' ('.$diff.')'?></h4>
      <h4 class="widget-list-title">Start Time : <?=$row['start_time']?></h4>
      <h4 class="widget-list-title">End Time : <?=$row['end_time']?></h4>

    </div>
  </div>
  <?php  $i++;} ?>
</div>
  
</div>


<div class="modal-footer">
<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
</div> 

   <?php }

   //  END PROCESS LOG 



   // WASTE MATERIAL

 public function fetch_wastematerial_details()
    
   {
        
        $order_items = $this->pom->getAllActiveordersByBatchnpacketid($_POST['batch_no'],$_POST['pac_id']);
        $package_wastage = $this->wmm->getwastemateriallist($_POST['batch_no'],$_POST['order_status']);

        // echo "<pre>"; 
        // print_r($order_items); 

    
          ?>

      <div class="modal-header">
  <h4 class="modal-title">Waste Materials of <?=$_POST['batch_no']?></h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<form>
  <div class="modal-body">
    <h4>Production Wastage</h4>
    <table id="data-table-combine" class="table table-bordered table-td-valign-middle">
      <thead>
        <tr>
          <th class="text-nowrap" data-searchable="true">Packet Name</th>
          <th class="text-nowrap" data-searchable="false">Ingrediant Name</th>
          <th class="text-nowrap" data-searchable="false">Ingrediant Qty (acc. packets)</th>
          <th class="text-nowrap" data-searchable="false">Wastage Qty</th>
        </tr>
      </thead>
      <tbody>
        <?php $count = 1; foreach ($order_items as $item) {
       $ingrediants = $this->pilm->getActivepiByPidandpackIdWithinName($item['p_id'],$item['pac_id']);
          // echo "<pre>";
          // print_r($ingrediants);  
       ?>


        <tr>
          <td colspan="4"><?=$item['p_name']. ' - '.$item['size'].' '.$item['unit'].' ( '.$item['order_qty'].' Packets )'?></td>
        </tr>
        <?php $i=1;
        foreach ($ingrediants as $ingrediant) {

        $filterarray['batch_no'] = $_POST['batch_no'];
        $filterarray['in_id'] = $ingrediant['in_id'];
        $filterarray['p_id'] = $item['p_id'];
        $checkwm = $this->wmm->getFilterData($filterarray);

        ?>
        <tr>
          <td><?=$i;?></td>
          <td><?=$ingrediant['in_name']?></td>
          <td><?=$ingrediant['in_qty'].' '.$ingrediant['in_unit']?></td>
           <td><?=@$checkwm->w_qty.' '.@$checkwm->w_unit?></td>


        </tr>
        <?php $i++; }$count++;} ?>
      </tbody>
    </table>
  </div>

   
  <?php if(!empty($package_wastage)){  ?>
   <div class="modal-body">
    <h4>Packaging Wastage</h4>
    <table id="data-table-combine" class="table table-bordered table-td-valign-middle">
      <thead>
        <tr>
          <th class="text-nowrap" data-searchable="true">Waste Material Name</th>
          <th class="text-nowrap" data-searchable="false">Wastage Qty</th>
          <th class="text-nowrap" data-searchable="false">Comments</th>
        </tr>
      </thead>
      <tbody>
        <?php $count = 1; 
        foreach ($package_wastage as $res) {
        $i=1;
        ?>
        <tr>
          <td><?=$res['w_name']?></td>
          <td><?=$res['w_qty'].' '.$res['w_unit']?></td>
          <td><?=$res['comment']?></td>
        </tr>
        <?php $i++; 
        $count++; } ?>
      </tbody>
    </table>
  </div>
   <?php } ?>
</form>
    <?php } 

   //  END WASTE MATERIAL



    // START COST MATERIAL

 public function fetch_costing_details()
    
   {  
      //echo $_POST['order_status'];
        $order_items = $this->pom->getAllActiveordersByBatchnproductidpacketid($_POST['p_id'],$_POST['pac_id'],$_POST['batch_no'],$_POST['order_status']);
        $package_order = $this->pcom->getAllproductcostingByBatchnproductidpacketid($_POST['p_id'],$_POST['pac_id'],$_POST['batch_no']);
         // echo "<pre>"; 
         // print_r($order_items);

    
          ?>

      <div class="modal-header">
  <h4 class="modal-title">Costing Details of <?=$_POST['batch_no']?></h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<form>
  <div class="modal-body">
    <h4>Production Costing</h4>
    <table id="data-table-combine" class="table table-bordered table-td-valign-middle">
      <thead>
        <tr>
          <th class="text-nowrap" data-searchable="true">Packet Name</th>
          <th class="text-nowrap" data-searchable="false">Costing Name</th>
          <th class="text-nowrap" data-searchable="false">Price</th>
          <th class="text-nowrap" data-searchable="false">Remarks</th>

        </tr>
      </thead>
      <tbody>
        <?php $count = 1;
         foreach ($order_items as $item) {
          $production_costing = $this->pcm->getcostinglist($item['pol_id'],$item['batch_no'],$item['po_status']);

          // echo "<pre>";
          // print_r($production_costing);  
       ?>


        <tr>
          <td colspan="4"><?=$item['p_name']. ' - '.$item['size'].' '.$item['unit'].' ( '.$item['order_qty'].' Packets )'?><span class="badge badge-pill badge-warning" style="margin-left:25px; font-size:10px;">Initial Quantity: <?=$item['initial_qty']?> <span class="badge badge-pill badge-warning" style="margin-left:25px; font-size:10px;">Final Quantity: <?=$item['final_qty']?></span></td>
        </tr>
        <?php $i=1;
       
     foreach ($production_costing as $pc) {
       
        ?>
        <tr>
          <td><?=$i;?></td>
          <td><?=$pc['pc_title']?></td>
          <td><?=$pc['price']?></td>
           <td><?=$pc['remarks']?></td>
        </tr>
        <?php $i++; }
        $count++;} ?>
      </tbody>
    </table>


      <?php if(!empty($package_order)){  ?>
    <h4>Packaging Costing</h4>
    <table id="data-table-combine" class="table table-bordered table-td-valign-middle">
      <thead>
        <tr>
          <th class="text-nowrap" data-searchable="true">Packet Name</th>
          <th class="text-nowrap" data-searchable="false">Packet Order Qty</th>
          <th class="text-nowrap" data-searchable="false">Status</th>

        </tr>
      </thead>
      <tbody>
        <?php $count = 1; foreach ($order_items as $item) {
          //$production_costing = $this->pcm->getcostinglist($item['pol_id'],$item['batch_no'],'PRODUCTION');

          // echo "<pre>";
          // print_r($production_costing);  
       ?>


        <tr>
          <td colspan="4"><?=$item['p_name']. ' - '.$item['size'].' '.$item['unit'].' ( '.$item['order_qty'].' Packets )'?></td>
        </tr>
        <?php $i=1;
       
     foreach ($package_order as $po) {
       
        ?>
        <tr>
          <td><?=$i;?></td>
          <td><?=$po['pac_order_qty']?></td>
          <td><?=$po['pac_order_status']?></td>
        </tr>
        <?php $i++; }
        $count++;} ?>
      </tbody>
    </table>
  </div>
   <?php } ?>
</form>

     <?php } 
    
//END COST MATERIAL





       // PRODUCT MATERIALS

 public function fetch_product_details()
    
   {  
      // echo $_POST;
        $order_items = $this->pom->getAllActiveordersByBatchnproductidpacketid($_POST['p_id'],$_POST['pac_id'],$_POST['batch_no'],$_POST['pro_status']);
        if ($_POST['pac_status'] != '') {
      $package_orderItems = $this->pcom->getAllproductdetailsByBatchnproductidpacketid($_POST['p_id'],$_POST['pac_id'],$_POST['batch_no'],$_POST['pac_status']);
          
        } else {
          $package_orderItems = [];
        }
        

      // echo "<pre>"; 
      //    print_r($_POST);
      //    print_r($order_items);
      //    echo "<pre>"; 
      //    print_r($package_orderItems);

    
          ?>

      <div class="modal-header">
  <h4 class="modal-title">Product Details of <?=$_POST['batch_no']?></h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>





  <div class="modal-body">
 <?php if(!empty($order_items)){  ?>
    <h4>Production Order Detail</h4>
    <table id="data-table-combine" class="table table-bordered table-td-valign-middle">
      <thead>
        <tr>
         <th class="text-nowrap" data-searchable="true" colspan="2">Packet Name</th>
<!--             <th class="text-nowrap" data-searchable="false"></th>
 -->            <th class="text-nowrap" data-searchable="false">Initial Qty</th>
             <th class="text-nowrap" data-searchable="false">Final Qty</th>
            <th class="text-nowrap" data-searchable="false">Current Process</th>

        </tr>
      </thead>
      
        <tbody>
          <?php $count = 1; foreach ($order_items as $item) {
            $processes = $this->ppm->getAllProcessByProcessIdSortByDOCASC($item['p_id']);
            $process_details = $this->ppm->getAllProcessByProcessId($item['process_id']);
          
           ?>
            <tr>
              <td colspan="2"><?=$item['p_name']. ' - '.$item['size'].' '.$item['unit'].' ( '.$item['order_qty'].' Packets )'?></td>
              <td><?=$item['initial_qty']?></td><td><?=$item['final_qty']?></td>
              <td>

          
              
              <?php $newtimestamp = 0; if (@$item['process_id'] == NULL) {?>
                  Production not started for this product
                <?php  }else{
                  $newtimestamp = strtotime($item['start_time'].' + '.$item['estimated_end_time'].' minute');
                  // echo  $newtimestamp."<br/>";
                  // echo  strtotime(date('Y-m-d H:i:s'));
                  if(strtotime(date('Y-m-d H:i:s')) <= $newtimestamp){
                      $process = $this->ppm->getProcessByProcessId($item['process_id']);
                      //  echo "<pre>";
                      // print_r($process);
                  ?>
                      <p class="badge badge-success" style="font-size:12px;"><?=$process_details['process_title']?></p>
                      <p class="triggerTimer" data-endtime="<?=date('M d, Y H:i:s',$newtimestamp)?>" data-targetid="clock<?=$count?>">This Process Will Stopped In : <span class="badge badge-warning" style="font-size:12px;" id="clock<?=$count?>"></span></p>
                      <!-- <script type="text/javascript">
                        createTimer("<?=date('M d, Y H:i:s',$newtimestamp)?>","<?='clock'.$count?>");
                        // Aug 25, 2020 15:37:25
                      </script> -->
                 <?php }else{
                 $lastindex = count($processes)-1; 
                  echo '<p class="text text-success">This Process is completed</p>';
                
                  } 
                }?></td>

            </tr>
            <?php $i=1;
           $count++;}  ?>
        </tbody>
     
    </table>

     <?php }  ?>
<!----------------- Under Packaging ------------->


   <?php if(!empty($package_orderItems)){  ?>


    <h4>Packaging Order Detail</h4>
    <table id="data-table-combine" class="table table-bordered table-td-valign-middle">
      <thead>
        <tr>
         <th class="text-nowrap" data-searchable="true" colspan="2">Packet Name</th>
           <th class="text-nowrap" data-searchable="false">Packet Order Qty</th>
          

        </tr>
      </thead>
      
        <tbody>
          <?php $count = 1; foreach ($package_orderItems as $package){
          
           ?>
            <tr>
            <td colspan="2"><?=$package['p_name']. ' - '.$package['size'].' '.$package['unit'].' ( '.$package['pac_order_qty'].' Packets )'?></td>
              <td><?=$package['pac_order_qty']?></td>
              
            <tr>
            <?php $i=1;
           $count++;}  ?>
        </tbody>
     
    </table>
<?php }?>
</div>

<!--------------------- Under Packaging ------------------------------>
     <?php 
   } 
    
//END PRODUCT MATERIALS




    public function show_product_order_details_view()
            {
               
             
               $output='';


           if($_POST['order_status'] == 'PRODUCTION') 
            {

          $data = $this->in->get_ProductOrderDetails_data($_POST['p_id'],$_POST['pac_id'],$_POST['start_date'],$_POST['end_date'],$_POST['order_status']);


                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                      
                  <thead>
                  <tr>
          <th class="text-nowrap">Batch No</th>
          <th class="text-nowrap">Order Date</th>
          <th class="text-nowrap">Status</th>        
                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                
                        foreach($data as $row)
                         {

                          $output .= '
                        <tr>
                        <td>'.$row['batch_no'].'</td>
                        <td>'.$row['order_doc'].'</td> 
                  <td><button onclick="getprocesslogdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`)" class="btn btn-primary btn-sm">Process Log</button>

                 <button onclick="getwastematerialdetails('.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['po_status'].'`)" class="btn btn-warning btn-sm">Waste Material</button>


                 <button onclick="getcostingdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['po_status'].'`)" class="btn btn-success btn-sm">Costing</button>

                 <button onclick="getproductdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`PRODUCTION`,``)" class="btn btn-info btn-sm">View Product Details</button>

                  </td>         
                        </tr>
                        ';
                        } $cnt++;
                  $output .= '</tbody>
                 </table>';
                  } 
                  elseif($_POST['order_status'] == 'PACKAGING') 

                  {
              

                    $data = $this->in->getAllActiveProductordersForPackaging($_POST['p_id'],$_POST['pac_id'],$_POST['start_date'],$_POST['end_date'],$_POST['order_status']);

                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                      
                  <thead>
                  <tr>
          <th class="text-nowrap">Batch No</th>
          <th class="text-nowrap">Order Date</th>
          <th class="text-nowrap">Status</th>        
                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                
                        foreach($data as $row)
                         {

                          $output .= '
                        <tr>
                        <td>'.$row['batch_no'].'</td>
                        <td>'.$row['order_doc'].'</td> 

               <td><button onclick="getprocesslogdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`)" class="btn btn-primary btn-sm">Process Log</button>

               <button onclick="getwastematerialdetails('.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['po_status'].'`)" class="btn btn-warning btn-sm">Waste Material</button>

               <button onclick="getcostingdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['po_status'].'`)" class="btn btn-success btn-sm">Costing</button>

                 <button onclick="getproductdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`PACKAGING`,``)" class="btn btn-info btn-sm">View Product Details</button></td> 


 

                        </tr>
                        ';
                        } $cnt++;
                  $output .= '</tbody>
                 </table>';


                  }


                elseif($_POST['order_status'] == 'PENDING') 

                  {
               

                    $data = $this->in->getAllActiveProductordersForPackaged($_POST['p_id'],$_POST['pac_id'],$_POST['start_date'],$_POST['end_date'],$_POST['order_status']);
                    

                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                      
                  <thead>
                  <tr>
          <th class="text-nowrap">Batch No</th>
          <th class="text-nowrap">Order Date</th>
          <th class="text-nowrap">Status</th>        
                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                
                        foreach($data as $row)
                         {

                          $output .= '
                        <tr>
                        <td>'.$row['batch_no'].'</td>
                        <td>'.$row['pac_order_doc'].'</td> 

                  <td><button onclick="getprocesslogdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`)" class="btn btn-primary btn-sm">Process Log</button>


                  <button onclick="getwastematerialdetails('.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['pac_order_status'].'`)" class="btn btn-warning btn-sm">Waste Material</button>

                  <button onclick="getcostingdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['pac_order_status'].'`)" class="btn btn-success btn-sm">Costing</button>


                    <button onclick="getproductdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`PROCESSED`,`PENDING`)" class="btn btn-info btn-sm">View Product Details</button></td> 


                        </tr>
                        ';
                        } $cnt++;
                  $output .= '</tbody>
                 </table>';


                    }

                    elseif($_POST['order_status'] == 'PACKED') 

                    {


                    $data = $this->in->getAllActiveCompletedProductorders($_POST['p_id'],$_POST['pac_id'],$_POST['start_date'],$_POST['end_date'],$_POST['order_status']);

                    $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">

                    <thead>
                    <tr>
                    <th class="text-nowrap">Batch No</th>
                    <th class="text-nowrap">Order Date</th>
                    <th class="text-nowrap">Status</th>        
                    </tr>
                    </thead>
                    <tbody>';
                    $cnt = 1;

                    foreach($data as $row)
                    {

                    $output .= '
                    <tr>
                    <td>'.$row['batch_no'].'</td>
                    <td>'.$row['pac_order_doc'].'</td> 
                  <td><button onclick="getprocesslogdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`)" class="btn btn-primary btn-sm">Process Log</button>

                    <button onclick="getwastematerialdetails('.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['pac_order_status'].'`)" class="btn btn-warning btn-sm">Waste Material</button>

                    <button onclick="getcostingdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`'.$row['pac_order_status'].'`)" class="btn btn-success btn-sm">Costing</button>


                      <button onclick="getproductdetails('.$row['p_id'].','.$row['pac_id'].',`'.$row['batch_no'].'`,`PROCESSED`,`PACKED`)" class="btn btn-info btn-sm">View Product Details</button></td> 



                    </td>
 
                    </tr>
                    ';
                    } $cnt++;
                    $output .= '</tbody>
                    </table>';


                    }




                        echo $output;
        }










	 public function fetch_all_processedFood()
    {


          $output="";
          
            //$data = $this->in->get_all_processedFoodItems('product');
            $products = $this->pm->getAllProducts();
           

            $output.= '<table id="data-table-combine" class="table table-responsive table-bordered table-td-valign-middle" style="width:100%!important"><thead style="width: 100%!important;">
					<tr style="width: 100%!important;">
						<th width="50%" class="text-nowrap" data-searchable="true">Product Name</th>
						<th width="50%" class="text-nowrap" data-searchable="true">Product Name</th>
						<th width="50%" class="text-nowrap" data-searchable="false">Packet Size</th>
						<th width="50%" class="text-nowrap" data-searchable="false">Stock Qty (acc. packets)</th>
					</tr>
				</thead>
				<tbody style="width: 100%!important;">';
								
					foreach($products as $product){
					$packets = $this->pacm->getPacketbypidSortASC($product['p_id']);
          
					foreach ($packets as $packet) {

                            $output .= '<tr style="width: 100%!important;">
                                       <td width="50%"></td>
                                       <td width="50%"><a href="InProduct_details?ProductId='.$product['p_id'].'" target="_blank">'.$product['p_name'].'</a></td>
                                         <td width="50%">'.$packet['size'].' '.$packet['unit'].'</td>
                                         <td width="50%">'.$packet['processed_qty'].'<br><br>
                                          <a href="Product_details?ProductId='.$product['p_id'].'&PacketId='.$packet['pac_id'].'" title="View Product Details"  target="_blank" ><button type="button" class="btn btn-primary btn-sm">View Product Details</button></a></td>' ;
                                          
                                      
                           $output .=  '</tr>';

                               }

                            }   
									$output .= '</tbody></table></div>
									';	
			echo $output;
	}






	


}