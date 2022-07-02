<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advertisement extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
       //  if (@$_SESSION['logUser'] == '')
       // {
       //    redirect('https://srinathhomes.in/irems/');
       //    // header("Location: https://srinathhomes.in/irems/");
       //    //   die();
       // }
        $this->load->library('upload');
//        $this->load->model('Payroll_model');
        $this->load->model('Advertisement_model', 'Advertisement');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->data['view_path'] = $_SERVER['DOCUMENT_ROOT'] .'/irems/crm/application/views/';
//        $this->load->model('Department_model','dm');
        $this->load->model('Leadmanage_model','Leadmanage');
//		$this->load->model('Designation_model','designation');
    }

    public function create_advertisement()
    {
        $this->data['page'] = 'advertisement';
        $this->data['sub_page'] = 'manage_advrtisment';

        $this
            ->load
            ->view('admin/include/header', $this->data);
        $this
            ->load
            ->view('admin/include/sidebar', $this->data);
        $this
            ->load
            ->view('admin/advertisement/create_advertisement', $this->data);
        // $this->load->view('admin/include/footer',$this->data);
        
    }


    // view page for singe advertisment 
     public function advertisment_view()
    {
        $this->data['page'] = 'advertisement';
        $this->data['sub_page'] = 'manage_advrtisment';
        $adv_id = $_GET['i'];
        $adv_category = $_GET['t'];
        $this->data['advertisement'] = $this->Advertisement->get_single_adv_data($adv_id);
//        $this->data['employee'] = $this->Payroll_model->get_employee_data();
//        $this->data['department'] = $this->Payroll_model->get_data_array('tbl_department');
        $this->load->view('admin/include/header', $this->data);
        $this->load->view('admin/include/sidebar', $this->data);
        $this->load->view('admin/advertisement/advertisment_view', $this->data);
        // $this->load->view('admin/include/footer',$this->data);
        
    }

    public function manage_advertisement()
    {
        $this->data['page'] = 'advertisement';
        $this->data['sub_page'] = 'manage_advrtisment';
        $this->load->view('admin/include/header', $this->data);
        $this->load->view('admin/include/sidebar', $this->data);
        $this->load->view('admin/advertisement/manage_advertisement', $this->data);
        // $this->load->view('admin/include/footer',$this->data);
        
    }
    
    function fetch_employee_name()
    {
        $output = '';
        if ($this
            ->input
            ->post('depart_id') == '')
        {
            $output .= '<option value="" disabled selected>Select Employee</option>';
        }
        else
        {
            $q = $this
                ->Payroll_model
                ->fetch_employee_depart_name($this
                ->input
                ->post('depart_id'));

            if ($q->num_rows() > 0)
            {
                $output .= '<option value="" disabled selected>Select Employee</option>';
                foreach ($q->result() as $row)
                {
                    $output .= '<option value="' . $row->id . '">' . $row->first_name . ' ' . $row->last_name . '</option>';
                }
            }
            else
            {
                $output .= '<option value="" disabled selected>No Employee</option>';
            }
        }
        echo $output;
    }

    public function input_form_creator()
    {
        $output = '';
        $ad_type = $_POST['ad_type'];
//        $employee = $this->Payroll_model->get_employee_data(); 
//        $department = $this->Payroll_model->get_data_array('tbl_department');
        if ($ad_type == 'online')
        {
            $output = '<div class="panel-heading">
         <h4 class="panel-title">Online Advertisement</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="online_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="POST" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Title : </strong></label>
                     <input class="form-control" type="hidden" name="adv_category" id="adv_category" value="ONLINE">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Online Advertisement Type : </strong></label>
                     <input class="form-control" type="text" name="adv_type" id="adv_type" required="true" placeholder="E.g Image, Vidoe, Audio">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Platform :<span id="empid_msg"></span></strong></label>
                     <input class="form-control" type="text" name="adv_platform" id="adv_platform" required="true" placeholder="E.g Facebook, Instagram, Youtube etc">
                  </div>
               </div>
                   <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" >
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Pay Type :</strong></label>
                     <input type="text" class="form-control" id="ad_chargetype" name="ad_chargetype"  required="true" placeholder="E.g Pay-per-click etc">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file">
                  </div>
               </div>
               <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Advertisement Links:</strong></label>
                     <input type="text" id="adv_link" name="adv_link" value="" data-role="tagsinput" />
                  </div>
               </div>
               <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Advertisement Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
                     <button type="submit" class="btn btn-warning ml-3">Save</button>
            </div>
            </form></div></div>';
        }
        if ($ad_type == 'offline')
        {
            $output = '<div class="panel-heading">
         <h4 class="panel-title">Offline Advertisement</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="offline_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Title : </strong></label>
                     <input class="form-control" type="hidden" name="adv_category" id="adv_category"  value="OFFLINE">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Offline Advertisement Type : </strong></label>
                     <input class="form-control" type="text" name="adv_type" id="adv_type" required="true" placeholder="E.g Posters, Hoardings, Ad Vehicles">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Name :</strong></label>
                     <input class="form-control" type="text" name="adv_area" id="adv_area" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Pincode :</strong></label>
                     <input class="form-control" type="number" name="adv_areapin" id="adv_areapin" required="true" >
                  </div>
               </div>
                 <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>No. Of Posters/Hoadings/Leaflet :</strong></label>
                     <input class="form-control" type="number" name="poster_no" id="poster_no" required="true" >
                  </div>
               </div>
              <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" >
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" >
                  </div>
               </div>
               
                <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Advertisement Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
               <button type="submit" class="btn btn-warning ml-3">Save</button>
            </div>
            </form></div></div>';
        }
        if ($ad_type == 'seminars')
        {
            $output .= '<div class="panel-heading">
         <h4 class="panel-title">Seminars</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="seminar_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Title : </strong></label>
                     <input class="form-control" type="hidden" name="adv_category" id="adv_category" value="SEMINARS">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Name :</strong></label>
                     <input class="form-control" type="text" name="adv_area" id="adv_area" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Pincode :</strong></label>
                     <input class="form-control" type="number" name="adv_areapin" id="adv_areapin" required="true" >
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Topics :</strong></label>
                     <input type="text" class="form-control" id="seminar_topic" name="seminar_topic" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Guest Names :</strong></label>
                     <input type="text" class="form-control" id="guest_name" name="guest_name" required="true">
                  </div>
               </div>
                 <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Seminar End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" >
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" >
                  </div>
               </div>
                 <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Seminar Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
               <button type="submit" class="btn btn-warning ml-3">Save</button>
            </div>
        </form></div></div>';
        }
        if ($ad_type == 'exhibition')
        {
            $output .= '<div class="panel-heading">
         <h4 class="panel-title">Exhibition</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body"><form id="exhibition_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition Title : </strong></label>
                      <input class="form-control" type="hidden" name="adv_category" id="adv_category" value="EXHIBITION">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Name :</strong></label>
                     <input class="form-control" type="text" name="adv_area" id="adv_area" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Area Pincode :</strong></label>
                     <input class="form-control" type="number" name="adv_areapin" id="adv_areapin" required="true" >
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition Product Names :</strong></label>
                     <input type="text" class="form-control" id="prd_name" name="prd_name" required="true">
                  </div>
               </div>
             <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Exhibition End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" >
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file"  >
                  </div>
               </div>
               <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Exhibition Description:</strong></label>
                     <textarea class="form-control m-b-2"  rows="3" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
               <button type="submit" class="btn btn-warning ml-3">Save</button>
            </div>
            </form></div></div>';
        }
        if ($ad_type == 'commercial')
        {
            $output .= '<div class="panel-heading">
         <h4 class="panel-title">Commercial Advertisement</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="commercial_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Title : </strong></label>                     
                      <input class="form-control" type="hidden" name="adv_category" id="adv_category" value="ELECTRONIC">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Type : </strong></label>      
                     <input class="form-control" type="text" name="adv_type" id="adv_type" required="true" placeholder="Tv Ads, Radio Ads etc">
                  </div>
               </div>
                 <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement Start Date & Time:</strong></label>
                      <div class="input-group date startDateTime">
                           <input type="text" class="form-control" id="adv_startdate" name="adv_startdate"  required="true">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Advertisement End Date & Time:</strong></label>
                     <div class="input-group date endDateTime">
                           <input type="text" class="form-control" id="adv_enddate" name="adv_enddate"  required="true" >
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Budget Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_budget" name="adv_budget"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Actual Expenses Amount :</strong></label>
                     <input type="number" class="form-control" id="adv_amt" name="adv_amt"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Image:</strong></label>
                     <input class="form-control" name="adv_img" id="adv_img" type="file" >
                  </div>
               </div>
                <div class="col-md-12">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Advertisement Description:</strong></label>
                     <textarea class="form-control m-b-2" rows="3" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
               <button type="submit" class="btn btn-warning ml-3">Save</button>
            </div>
        </form></div></div>';
        }
      if ($ad_type == 'agentBroker')
        {
            $output .= '<div class="panel-heading">
         <h4 class="panel-title">Agent And Broker</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="agentBroker_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Agent Name : </strong></label>                     
                      <input class="form-control" type="hidden" name="adv_category" id="adv_category" value="AGENTBROKER">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Mobile Number : </strong></label>      
                     <input class="form-control" type="number" maxlength="12"  name="adv_mno" id="adv_mno" required="true" >
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Alternate Mobile Number : </strong></label>      
                     <input class="form-control" type="number"  maxlength="12"  name="adv_a_mno" id="adv_a_mno" >
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Agent Email ID:</strong></label>
                     <input type="email" class="form-control" id="adv_mail" name="adv_mail"  required="true">
                  </div>
               </div>
               <div class="col-md-8">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Agent Address :</strong></label>
                     <input type="text" class="form-control" id="adv_adrs" name="adv_adrs"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Bank Name:</strong></label>
                     <input type="text" class="form-control" id="adv_bank_name" name="adv_bank_name"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>A/c Holder Name:</strong></label>
                     <input type="text" class="form-control" id="adv_ac_name" name="adv_ac_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>A/c No:</strong></label>
                     <input type="text" class="form-control" id="adv_acno" name="adv_acno"  required="true">
                  </div>
               </div>
                  <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>IFSC No:</strong></label>
                     <input type="text" class="form-control" id="adv_ifsc" name="adv_ifsc"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Agent Image:</strong></label>
                     <input class="form-control" name="adv_agent_img" id="adv_agent_img" type="file" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Aadhar Image:</strong></label>
                     <input class="form-control" name="adv_aadhar_img" id="adv_aadhar_img" type="file" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Pan Image:</strong></label>
                     <input class="form-control" name="adv_pan_img" id="adv_pan_img" type="file" required="true">
                  </div>
               </div>

                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Comment :</strong></label>
                     <textarea class="form-control m-b-2" rows="3" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
               <div class="col-md-4 mt-5">
                     <button type="submit" class="btn btn-warning col-3">Save</button>
               </div>
            </div>
        </form></div></div>';
        }
        if ($ad_type == 'salesMarketing')
        {
            $output .= '<div class="panel-heading">
         <h4 class="panel-title">Sales And Marketing Companies</h4>
      </div>
      <div class="panel-body panel-form">
         <div class="card-body" ><form id="salesMarketing_ad_form" class="form-horizontal" onsubmit="return insert_advertisement(this)" method="post" enctype="multipart/form-data">
            <div class="row">
             <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Company Name :</strong></label>                     
                     <input class="form-control" type="text" name="adv_cmp_name" id="adv_cmp_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Company Representative Name :</strong></label>                     
                      <input class="form-control" type="hidden" name="adv_category" id="adv_category" value="SALESMARKETING">
                     <input class="form-control" type="text" name="adv_name" id="adv_name" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Company Mobile Number : </strong></label>      
                     <input class="form-control" type="number" maxlength="12"  name="adv_mno" id="adv_mno" required="true" >
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Alternate Mobile Number : </strong></label>      
                     <input class="form-control" type="number"  maxlength="12"  name="adv_a_mno" id="adv_a_mno" >
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Company Email ID:</strong></label>
                     <input type="email" class="form-control" id="adv_mail" name="adv_mail"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Company Address :</strong></label>
                      <textarea class="form-control m-b-2" rows="2" id="adv_adrs" name="adv_adrs" required="true"></textarea>
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>Bank Name:</strong></label>
                     <input type="text" class="form-control" id="adv_bank_name" name="adv_bank_name"  required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>A/c Holder Name:</strong></label>
                     <input type="text" class="form-control" id="adv_ac_name" name="adv_ac_name" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>A/c No:</strong></label>
                     <input type="text" class="form-control" id="adv_acno" name="adv_acno" required="true">
                  </div>
               </div>
                  <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label class="control-label"><strong>IFSC No:</strong></label>
                     <input type="text" class="form-control" id="adv_ifsc" name="adv_ifsc" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Agent Image:</strong></label>
                     <input class="form-control" name="adv_agent_img" id="adv_agent_img" type="file" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Aadhar Image:</strong></label>
                     <input class="form-control" name="adv_aadhar_img" id="adv_aadhar_img" type="file" required="true">
                  </div>
               </div>
               <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Pan Image:</strong></label>
                     <input class="form-control" name="adv_pan_img" id="adv_pan_img" type="file" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>GST No:</strong></label>
                     <input class="form-control" name="adv_cmp_gst" id="adv_cmp_gst" type="text" required="true">
                  </div>
               </div>
                <div class="col-md-4">
                  <div id="response" class="form-group">
                     <label for="image"><strong>Comment :</strong></label>
                     <textarea class="form-control m-b-2" rows="2" id="adv_desc" name="adv_desc"></textarea>
                  </div>
               </div>
               <div class="col-md-4 mt-5">
                     <button type="submit" class="btn btn-warning col-3">Save</button>
               </div>
            </div>
        </form></div></div>';
        }
        $output .= '<script>
	    $("#manage_depart").change(function () {
	        var depart_id = $("#manage_depart").val();
	        if (depart_id != "") {
          $.ajax({
            url: "' . base_url() . 'admin/Advertisement/fetch_employee_name",
            method: "POST",
            data: {
              "depart_id": depart_id
            },
            success: function (data) {
              $("#adv_empid").html(data);
            }
          });
        } 
	      });';

        $output .= '$("#manage_depart").change(function () {
             var depart_name = $("#manage_depart option:selected").text();
           var depart_id = $("#manage_depart").val();
           if (depart_name == "Other (Third Parties)") {
               $("#third_party").show();
               $("#emp_input").hide();
         }
         if (depart_name != "Other (Third Parties)"){
          $.ajax({
            url: "'.base_url().'admin/Advertisement/fetch_employee_name",
            method: "POST",
            data: {
              "depart_id": depart_id
            },
            success: function (data) {
               $("#adv_empid").html(data);
               $("#emp_input").show();
               $("#third_party").hide();
            }
          });
        } 
   });
   $(".startDateTime").datetimepicker({
                                format: "YYYY-MM-DD HH:mm:ss"                                
                            });
                           $(".endDateTime").datetimepicker({
                                format: "YYYY-MM-DD HH:mm:ss"
                            });
   </script>';
        echo $output;
    }

    function insert_advertisement()
    {
      // echo"<pre>";
      // print_r($_POST);
      // print_r($_FILES);
      // exit();
    	$postData = $this->input->post();
      if(!empty($postData['adv_link']))
      {
        $adv_link = json_encode(explode(',',$postData['adv_link']));
        $postData['adv_link'] = $adv_link;
      }

        if (isset($_FILES['adv_agent_img']) && $_FILES['adv_agent_img']['name'] != ''){
                $postData['adv_agent_img'] = $this->upload_file('adv_agent_img');
           }
       if (isset($_FILES['adv_aadhar_img']) && $_FILES['adv_aadhar_img']['name'] != ''){
                $postData['adv_aadhar_img'] = $this->upload_file('adv_aadhar_img');
           } 
        if (isset($_FILES['adv_pan_img']) && $_FILES['adv_pan_img']['name'] != ''){
                $postData['adv_pan_img'] = $this->upload_file('adv_pan_img');
           }

        if (!empty($_FILES['adv_img']))
        {	
            $config['file_name'] = $_FILES['adv_img']['name'];
            $config['upload_path'] = 'upload/advertisement/';
            $config['overwrite'] = true;
            $config['allowed_types'] = '*';
            $config['max_size'] = '20000';
            $config['remove_spaces'] = true;
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if($this->upload->do_upload('adv_img'))
            {
            	$filedata = $this->upload->data();
            	$postData['adv_img'] = $filedata['file_name'];
            }
            // else{
            // 	echo $this->upload->display_errors();
            // }
        }
          $insert_data = $this->Advertisement->insert_data($postData);
            if($insert_data)
			 			{
							$data['status']=true;
							$data['msg']='Advertisement information added successfully!';
							$data['adv_id']=$insert_data;
							$data['adv_type']= $postData['adv_category'];
			 			}
			 			else{
			 				$data['status']=false;
							$data['msg']='Unable to added advertisement information!';
			 			}	
			 			echo json_encode($data);
    }

     function update_advertisement()
    {
      $postData = $this->input->post();
      $adv_id=$postData['adv_id'];
      unset($postData['adv_id']);
        if(!empty($postData['adv_link']))
        {
          $adv_link = json_encode(explode(',',$postData['adv_link']));
          $postData['adv_link'] = $adv_link;
        }
        if (!empty($_FILES['adv_img']))
        {	
            $config['file_name'] = $_FILES['adv_img']['name'];
            $config['upload_path'] = 'upload/advertisement/';
            $config['overwrite'] = true;
            $config['allowed_types'] = '*';
            $config['max_size'] = '20000';
            $config['remove_spaces'] = true;
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if($this->upload->do_upload('adv_img'))
            {
            	$filedata = $this->upload->data();
            	$postData['adv_img'] = $filedata['file_name'];
            }
            // else{
            // 	echo $this->upload->display_errors();
            // }
        }
          $update_data = $this->Advertisement->update_data($postData,$adv_id);
            if($update_data)
			 			{
							$data['status']=true;
							$data['msg']='Advertisement information update successfully!';
			 			}
			 			else{
			 				$data['status']=false;
							$data['msg']='Unable to update advertisement information!';
			 			}	
			 			echo json_encode($data);
    }



    public function fetch_all_OrdersByOrderStatus()
    {
        $output = "";
        $adv_status = $this->input->post('adv_status');
        $adv_category = $this->input->post('adv_category');
        $data = $this->Advertisement->get_all_adv_by_status($adv_status, $adv_category);
      if(($this->input->post('adv_category')=='AGENTBROKER') || ($this->input->post('adv_category')=='SALESMARKETING')){

              $output .= '<div class="panel-body">
                         <table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                             <th class="text-nowrap">S No</th>
                          <th class="text-nowrap">Name</th>
                          <th class="text-nowrap">Mobile</th>
                          <th class="text-nowrap">Email</th>';
                        if($adv_status=='PENDING' || $adv_status=='RUNNING' || $adv_status=='PAUSE' || $adv_status=='CANCELED'){
                          $output .= '<th class="text-nowrap">Status</th><th class="text-nowrap">Action</th>';
                          }
                          if( $adv_status=='RUNNING' || $adv_status=='PAUSE' || $adv_status=='CANCELED' || $adv_status=='COMPLETED'){
                          $output .= '<th class="text-nowrap">Follow up</th>';
                            }
                           $output .= '</tr></thead><tbody>
                          ';
                  $cnt = 1;
                  foreach ($data as $row)
                  {
                   $leadno = $this->Leadmanage->get_lead_count($row['adv_id']);
                 $output .= '
                  <tr>
                   <td>'.$cnt.'</td>
                   <td>'.$row['adv_name'].'</td>
                   <td>'.$row['adv_mno'].', '.$row['adv_a_mno'].'</td>
                   <td>'.$row['adv_mail'].'</td>';
                   if($row['adv_status']=='PENDING'){           
                   $output .= '
                   <td>
                      <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                         <option value="" selected="" disabled="">Pending</option>
                         <option value="RUNNING">Running</option>
                         <option value="CANCELED">Cancel</option>
                      </select>
                   </td>
                   <td><a href="'.base_url().'admin/advertisement/advertisment_view?t='.$row['adv_category'].'&i='.$row['adv_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>          
                      <button type="button" class="btn btn-sm btn-danger" onclick="deleteAdv('.$row['adv_id'].');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                   </td>';
             }if($row['adv_status']=='RUNNING'){           
             $output .= '
             <td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Running</option>
                   <option value="COMPLETED">Completed</option>
                   <option value="PAUSE">Pause</option>
                   <option value="CANCELED">Cancel</option>
                </select>
             </td>
             <td>          
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteAdv('.$row['adv_id'].');"><i class="fa fa-trash" aria-hidden="true"></i></button>
             </td>
             <td><a href="'.base_url().'admin/leadmanage/manage_lead?i='.$row['adv_id'].'" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a>
                <a href="'.base_url().'admin/leadmanage/add_lead?i='.$row['adv_id'].'" class="btn btn-sm btn-inverse" Title="Add More Leads.."><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
             </td>
             ';
             }if($row['adv_status']=='PAUSE'){           
             $output .= '<td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Pause</option>
                   <option value="RUNNING">Running</option>
                </select>
             </td>
             <td><a href="'.base_url().'admin/advertisement/advertisment_view?t='.$row['adv_category'].'&i='.$row['adv_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>          
             </td>
             <td><a href="'.base_url().'admin/leadmanage/manage_lead" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a></td>
             ';
             }if($row['adv_status']=='CANCELED'){           
             $output .= '<td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Cancel</option>
                   <option value="PENDING" >Pending</option>
                   <option value="RUNNING" >Running</option>
                </select>
             </td>
             <td><a href="'.base_url().'admin/advertisement/advertisment_view?t='.$row['adv_category'].'&i='.$row['adv_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
             <td><a href="'.base_url().'admin/leadmanage/manage_lead" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a></td>';
             }
             if($row['adv_status']=='COMPLETED'){           
             $output .= '
             <td><a href="'.base_url().'admin/leadmanage/manage_lead" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a></td>';
             }
             $output .= '</tr>';
             $cnt++;
          }
          $output .= '</tbody></table></div>';
      }
      else{

              $output .= '<div class="panel-body">
                         <table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                             <th class="text-nowrap">S No</th>
                          <th class="text-nowrap">Title</th>
                          <th class="text-nowrap">Type</th>
                          <th class="text-nowrap">Start Date</th>
                          <th class="text-nowrap">End Date</th>
                          <th class="text-nowrap">Budget</th>';
                        if($adv_status=='PENDING' || $adv_status=='RUNNING' || $adv_status=='PAUSE' || $adv_status=='CANCELED'){
                          $output .= '<th class="text-nowrap">Status</th><th class="text-nowrap">Action</th>';
                          }
                          if( $adv_status=='RUNNING' || $adv_status=='PAUSE' || $adv_status=='CANCELED' || $adv_status=='COMPLETED'){
                          $output .= '<th class="text-nowrap">Follow up</th>';
                            }
                           $output .= '</tr></thead><tbody>
                          ';
                  $cnt = 1;
                  foreach ($data as $row)
                  {
                   $leadno = $this->Leadmanage->get_lead_count($row['adv_id']);
                 $output .= '
            <tr>
             <td>'.$cnt.'</td>
             <td>'.$row['adv_name'].'</td>
             <td>'.$row['adv_type'].'</td>
             <td>'.$row['adv_startdate'].'</td>
             <td>'.$row['adv_enddate'].'</td>
             <td>₹&nbsp;'.$row['adv_budget'].'</td>
             ';
             if($row['adv_status']=='PENDING'){           
             $output .= '
             <td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Pending</option>
                   <option value="RUNNING">Running</option>
                   <option value="CANCELED">Cancel</option>
                </select>
             </td>
             <td><a href="'.base_url().'admin/advertisement/advertisment_view?t='.$row['adv_category'].'&i='.$row['adv_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>          
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteAdv('.$row['adv_id'].');"><i class="fa fa-trash" aria-hidden="true"></i></button>
             </td>
             ';
             }if($row['adv_status']=='RUNNING'){           
             $output .= '
             <td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Running</option>
                   <option value="COMPLETED">Completed</option>
                   <option value="PAUSE">Pause</option>
                   <option value="CANCELED">Cancel</option>
                </select>
             </td>
             <td>          
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteAdv('.$row['adv_id'].');"><i class="fa fa-trash" aria-hidden="true"></i></button>
             </td>
             <td><a href="'.base_url().'admin/leadmanage/manage_lead?i='.$row['adv_id'].'" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a>
                <a href="'.base_url().'admin/leadmanage/add_lead?i='.$row['adv_id'].'" class="btn btn-sm btn-inverse" Title="Add More Leads.."><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
             </td>
             ';
             }if($row['adv_status']=='PAUSE'){           
             $output .= '<td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Pause</option>
                   <option value="RUNNING">Running</option>
                </select>
             </td>
             <td><a href="'.base_url().'admin/advertisement/advertisment_view?t='.$row['adv_category'].'&i='.$row['adv_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>          
             </td>
             <td><a href="'.base_url().'admin/leadmanage/manage_lead" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a></td>
             ';
             }if($row['adv_status']=='CANCELED'){           
             $output .= '<td>
                <select class="form-control" name="adv_status" data-adv_id="'.$row['adv_id'].'" onchange="update_adv_sts(this)">
                   <option value="" selected="" disabled="">Cancel</option>
                   <option value="PENDING" >Pending</option>
                   <option value="RUNNING" >Running</option>
                </select>
             </td>
             <td><a href="'.base_url().'admin/advertisement/advertisment_view?t='.$row['adv_category'].'&i='.$row['adv_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
             <td><a href="'.base_url().'admin/leadmanage/manage_lead" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a></td>';
             }
             if($row['adv_status']=='COMPLETED'){           
             $output .= '
             <td><a href="'.base_url().'admin/leadmanage/manage_lead" type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true" style="font-size:14px;"></i> &nbsp;<span class="label label-default">'.$leadno.'</span></a></td>';
             }
             $output .= '</tr>';
             $cnt++;
          }
          $output .= '</tbody></table></div>';
      }
       
        
        echo $output;
    }


    public function delete_advertisment()
    {
        $adv_id = $_POST['adv_id'];
        $advertisement=$this->Advertisement->get_single_adv_data($adv_id);
        $data['adv_status']='CANCELED';
               
        if($this->Advertisement->update_data($data,$adv_id))
            {
               // if(file_exists("./upload/advertisement/".$advertisement['adv_img'])){ 
               //  unlink("./upload/advertisement/".$advertisement['adv_img']);
               //  }
              $data['status']=true;
              $data['msg']='Advertisement information delete successfully!';
            }
            else{
              $data['status']=false;
              $data['msg']='Unable to delete advertisement information!';
            } 
            echo json_encode($data);	
    }


    public function update_adv_status()
    {
      $adv_id = $this->input->post('adv_id');
      $adv_status = $this->input->post('adv_status');
      $update=$this->Advertisement->update_adv_status($adv_id,$adv_status);
       if($update){ 
              $data['status']=true;
              $data['msg']='Advertisement information update successfully!';
        }else{
              $data['status']=false;
              $data['msg']='Unable to update advertisement information!';
        } 
        echo json_encode($data);  
    }

    public function upload_file($filename)
      {         
              $config['file_name'] = $_FILES[$filename]['name'];
                    $config['upload_path'] = 'upload/customer/';
                    $config['overwrite'] = true;
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '20000';
                    $config['remove_spaces'] = true;
                    $config['encrypt_name'] = true;
                    $this->upload->initialize($config);
                    if($this->upload->do_upload($filename))
                    {
                      $filedata = $this->upload->data();
                      return $filedata['file_name'];
                    }
                    else{
                      echo $this->upload->display_errors();
                    }
      }
}

