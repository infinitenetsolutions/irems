<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller {
    public function __construct()
   {
          parent::__construct();
   // if($this->session->userdata('user_id') == ''){
      //redirect('login');
    ///}
        $this->load->library('Utilitylib');
		  $this->load->model('client_model');
	    $this->load->model('Attendance_model','attendance');
	    $this->load->model('Employee_model','employee_model');
	    $this->load->model('Branch_model','branch'); 
        $this->load->model('Department_model','dm');
        $this->load->model('Designation_model','designation');    
        $this->load->model('Store_model','Store');
        $this->data['view_path'] = $_SERVER['DOCUMENT_ROOT'] .'/irems/crm/application/views/';
   }
   public function export_attendance_report()
    {
      $filter_date = $_POST["date_report"];
      $date_org = explode("-", $filter_date);
      $date_year = $date_org[0];
      $date_month = $date_org[1];
      if($date_year%4 == 0){
        switch($date_month){
            case 01:
              $date_month_name = "January";
              $date_month_days = 31;
              break;
            case 02:
              $date_month_name = "February";
              $date_month_days = 29;
              break;
            case 03:
              $date_month_name = "March";
              $date_month_days = 31;
              break;
            case 04:
              $date_month_name = "April";
              $date_month_days = 30;
              break;
            case 05:
              $date_month_name = "May";
              $date_month_days = 31;
              break;
            case 06:
              $date_month_name = "June";
              $date_month_days = 30;
              break;
            case 07:
              $date_month_name = "July";
              $date_month_days = 31;
              break;
            // case 08:
            //   $date_month_name = "August";
            //   $date_month_days = 31;
            //   break;
            // case 09:
            //   $date_month_name = "September";
            //   $date_month_days = 30;
            //   break;
            case 10:
              $date_month_name = "October";
              $date_month_days = 31;
              break;
            case 11:
              $date_month_name = "November";
              $date_month_days = 30;
              break;
            case 12:
              $date_month_name = "December";
              $date_month_days = 31;
              break;
       }
      } else{
          switch($date_month){
            case 01:
              $date_month_name = "January";
              $date_month_days = 31;
              break;
            case 02:
              $date_month_name = "February";
              $date_month_days = 28;
              break;
            case 03:
              $date_month_name = "March";
              $date_month_days = 31;
              break;
            case 04:
              $date_month_name = "April";
              $date_month_days = 30;
              break;
            case 05:
              $date_month_name = "May";
              $date_month_days = 31;
              break;
            case 06:
              $date_month_name = "June";
              $date_month_days = 30;
              break;
            case 07:
              $date_month_name = "July";
              $date_month_days = 31;
              break;
            // case 08:
            //   $date_month_name = "August";
            //   $date_month_days = 31;
            //   break;
            // case 09:
            //   $date_month_name = "September";
            //   $date_month_days = 30;
            //   break;
            case 10:
              $date_month_name = "October";
              $date_month_days = 31;
              break;
            case 11:
              $date_month_name = "November";
              $date_month_days = 30;
              break;
            case 12:
              $date_month_name = "December";
              $date_month_days = 31;
              break;
       }
      }
      
      $this->load->library('excel');

      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      if($date_month_days == 28){
        $table_columns = array("Employees Name","Department","Emplloyment ID","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","Total Working Days","Holidays","Present","Absent","OT","Date Of Joining");
        $object->getActiveSheet()->getStyle('A1:AK1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'FFCC66'
            )
        ));
        $object->getActiveSheet()->getStyle('A2:AE2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'F0E68C'
            )
        )); 
        $object->getActiveSheet()->getStyle('AF2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'FFA500'
            )
        ));
        $object->getActiveSheet()->getStyle('AG2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'FFDD99'
            )
        ));
        $object->getActiveSheet()->getStyle('AH2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => '44CC00'
            )
        ));
        $object->getActiveSheet()->getStyle('AI2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'FFDDCC'
            )
        ));
        $object->getActiveSheet()->getStyle('AJ2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'B3D9FF'
            )
        ));
        $object->getActiveSheet()->getStyle('AK2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'FFFF4D'
            )
        ));
        $object->getActiveSheet()->getStyle('A1:AK1')->getFont()->setBold(true)->setSize(20);
        $object->getActiveSheet()->getStyle('A2:AK2')->getFont()->setBold(true)->setSize(15);
        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('E')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('F')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('G')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('H')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('I')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('J')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('K')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('L')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('M')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('N')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('O')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('P')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('Q')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('R')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('S')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('T')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('U')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('V')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('W')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('X')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('Y')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('Z')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('AA')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('AB')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('AC')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('AD')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('AE')->setWidth('4');
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('Z')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('AE')->setAutoSize(false);
        $object->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
      }
      else if($date_month_days == 29){
              $table_columns = array("Employees Name","Department","Emplloyment ID","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","Total Working Days","Holidays","Present","Absent","OT","Date Of Joining");
                $object->getActiveSheet()->getStyle('A1:AL1')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFCC66'
                    )
                ));
                $object->getActiveSheet()->getStyle('A2:AF2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'F0E68C'
                    )
                )); 
                $object->getActiveSheet()->getStyle('AG2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFA500'
                    )
                ));
                $object->getActiveSheet()->getStyle('AH2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFDD99'
                    )
                ));
                $object->getActiveSheet()->getStyle('AI2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => '44CC00'
                    )
                ));
                $object->getActiveSheet()->getStyle('AJ2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFDDCC'
                    )
                ));
                $object->getActiveSheet()->getStyle('AK2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'B3D9FF'
                    )
                ));
                $object->getActiveSheet()->getStyle('AL2')->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFFF4D'
                    )
                ));       
                $object->getActiveSheet()->getStyle('A1:AL1')->getFont()->setBold(true)->setSize(20);
                $object->getActiveSheet()->getStyle('A2:AL2')->getFont()->setBold(true)->setSize(15);
                $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('D')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('E')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('F')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('G')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('H')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('I')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('J')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('K')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('L')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('M')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('N')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('O')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('P')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('Q')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('R')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('S')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('T')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('U')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('V')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('W')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('X')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('Y')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('Z')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('AA')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('AB')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('AC')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('AD')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('AE')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('AF')->setWidth('4');
                $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('Z')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AE')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AF')->setAutoSize(false);
                $object->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
                $object->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
          
            }
           else if($date_month_days == 30){
                   $table_columns = array("Employees Name","Department","Emplloyment ID","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","Total Working Days","Holidays","Present","Absent","OT","Date Of Joining");
                        $object->getActiveSheet()->getStyle('A1:AM1')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFCC66'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('A2:AG2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'F0E68C'
                            )
                        )); 
                        $object->getActiveSheet()->getStyle('AH2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFA500'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AI2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFDD99'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AJ2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => '44CC00'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AK2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFDDCC'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AL2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'B3D9FF'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AM2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFFF4D'
                            )
                        )); 
                        $object->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true)->setSize(20);
                        $object->getActiveSheet()->getStyle('A2:AM2')->getFont()->setBold(true)->setSize(15);
                        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('D')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('E')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('F')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('G')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('H')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('I')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('J')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('K')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('L')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('M')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('N')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('O')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('P')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('Q')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('R')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('S')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('T')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('U')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('V')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('W')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('X')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('Y')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('Z')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AA')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AB')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AC')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AD')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AE')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AF')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AG')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('Z')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AE')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AF')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AG')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
               
                    }
                else if($date_month_days == 31){
                        $table_columns = array("Employees Name","Department","Emplloyment ID","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","Total Working Days","Holidays","Present","Absent","OT","Date Of Joining");
                        $object->getActiveSheet()->getStyle('A1:AN1')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFCC66'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('A2:AH2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'F0E68C'
                            )
                        )); 
                        $object->getActiveSheet()->getStyle('AI2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFA500'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AJ2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFDD99'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AK2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => '44CC00'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AL2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFDDCC'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AM2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'B3D9FF'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('AN2')->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                 'rgb' => 'FFFF4D'
                            )
                        ));
                        $object->getActiveSheet()->getStyle('A1:AN1')->getFont()->setBold(true)->setSize(20);
                        $object->getActiveSheet()->getStyle('A2:AN2')->getFont()->setBold(true)->setSize(15);
                        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('D')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('E')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('F')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('G')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('H')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('I')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('J')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('K')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('L')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('M')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('N')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('O')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('P')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('Q')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('R')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('S')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('T')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('U')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('V')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('W')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('X')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('Y')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('Z')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AA')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AB')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AC')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AD')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AE')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AF')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AG')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('AH')->setWidth('4');
                        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('W')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('X')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('Y')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('Z')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AE')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AF')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AG')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AH')->setAutoSize(false);
                        $object->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
                        $object->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
                     }
      $column = 0;
    
      foreach($table_columns as $field)
      {
          $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
          $column++;

      }

        $tbl_attendance = $this->branch->get_data_array1('tbl_attendance');
        $tbl_holidays = $this->branch->get_data_array1('tbl_holidays');
        $tbl_employee = $this->branch->get_data_array1('table_employee');
        $tbl_branch = $this->branch->get_data_array('tbl_branch');
        
        $excel_row = 3;
        $object->getActiveSheet()->setCellValue("A1", "Faiz  Facilities Management System Attendance of $date_month_name $date_year");
        $object->getActiveSheet()->getComment("A2")->getText()->createTextRun("\r\n");
        $object->getActiveSheet()->getComment("A2")->getText()->createTextRun("Testing");
        
      foreach($tbl_employee as $row)
      {
        if($date_month_days == 31){     
             $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->first_name." ".$row->last_name);
             $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->department);
             $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->employee_id);
             $incr = 0;
             $present = 0;
             $absent = 0;
             $ot = 0;
             $holidays = 0;
             $location = "";
             //"\n( Location )"
             for($i_status=3;$i_status<=33;$i_status++){
                $incr++;
                switch($incr){
                    case 1:
                        $incr = "01";
                        break;
                    case 2:
                        $incr = "02";
                        break;
                    case 3:
                        $incr = "03";
                        break;
                    case 4:
                        $incr = "04";
                        break;
                    case 5:
                        $incr = "05";
                        break;
                    case 6:
                        $incr = "06";
                        break;
                    case 7:
                        $incr = "07";
                        break;
                    case 8:
                        $incr = "08";
                        break;
                    case 9:
                        $incr = "09";
                        break;
                }
                foreach($tbl_attendance as $row_attendance){
                 if($row->id == $row_attendance->emp_id){
                     $filter = $row_attendance->attendance_date;
                     $filter_org = explode("-", $filter);
                     if($filter_date == $filter_org[0]."-".$filter_org[1]){
                        $check_sunday = $filter_org[0]."-".$filter_org[1]."-$incr";
                        if(date('l', strtotime("$check_sunday")) == 'Sunday'){ 
                            if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                if($row_attendance->status == "Overtime"){
                                    $check_status = "OT";
                                    $ot++;
                                    if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                        foreach($tbl_branch as $row_branch){
                                          if($row_branch->id == $row_attendance->client_id)
                                             $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                        }
                                    }
                                }
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                                //$object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status);
                            } else{
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, "S");
                            }
                        }   else{
                                if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                    $location = "";
                                    if($row_attendance->status == "Absent"){
                                        $check_status = "A";
                                        $absent++;
                                    }
                                    if($row_attendance->status == "Overtime"){
                                        $check_status = "OT";
                                        $ot++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($row_attendance->status == "On Leave"){
                                        $check_status = "L";
                                    }
                                    if($row_attendance->status == "Present"){
                                        $check_status = "P";
                                        $present++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($location != "")
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                                        //$object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status);
                                    else
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status);
                                }
                            } 
                         }
                     }
                }
             }
             $object->getActiveSheet()->setCellValueByColumnAndRow(34, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, $holidays);
             $object->getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row, $absent);
             $object->getActiveSheet()->setCellValueByColumnAndRow(38, $excel_row, $ot);
             $object->getActiveSheet()->setCellValueByColumnAndRow(39, $excel_row, $row->date_of_hire);
             
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AH$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AH$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AH$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AH$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AH$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AH$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AH$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AH$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AH$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AH$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
             $excel_row++;
        }
        if($date_month_days == 30){     
             $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->first_name." ".$row->last_name);
             $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->department);
             $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->employee_id);
             $incr = 0;
             $present = 0;
             $absent = 0;
             $ot = 0;
             $holidays = 0;
             for($i_status=3;$i_status<=32;$i_status++){
                $incr++;
                switch($incr){
                    case 1:
                        $incr = "01";
                        break;
                    case 2:
                        $incr = "02";
                        break;
                    case 3:
                        $incr = "03";
                        break;
                    case 4:
                        $incr = "04";
                        break;
                    case 5:
                        $incr = "05";
                        break;
                    case 6:
                        $incr = "06";
                        break;
                    case 7:
                        $incr = "07";
                        break;
                    case 8:
                        $incr = "08";
                        break;
                    case 9:
                        $incr = "09";
                        break;
                }
                foreach($tbl_attendance as $row_attendance){
                 if($row->id == $row_attendance->emp_id){
                     $filter = $row_attendance->attendance_date;
                     $filter_org = explode("-", $filter);
                     if($filter_date == $filter_org[0]."-".$filter_org[1]){
                        $check_sunday = $filter_org[0]."-".$filter_org[1]."-$incr";
                        if(date('l', strtotime("$check_sunday")) == 'Sunday'){ 
                            if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                if($row_attendance->status == "Overtime"){
                                    $check_status = "OT";
                                    $ot++;
                                    if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                        foreach($tbl_branch as $row_branch){
                                          if($row_branch->id == $row_attendance->client_id)
                                             $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                        }
                                    }
                                }
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                            } else{
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, "S");
                            }
                        }   else{
                                if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                    $location = "";
                                    if($row_attendance->status == "Absent"){
                                        $check_status = "A";
                                        $absent++;
                                    }
                                    if($row_attendance->status == "Overtime"){
                                        $check_status = "OT";
                                        $ot++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($row_attendance->status == "On Leave"){
                                        $check_status = "L";
                                    }
                                    if($row_attendance->status == "Present"){
                                        $check_status = "P";
                                        $present++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($location != "")
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                                    else
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status);
                                }
                            } 
                         }
                     }
                }
             }
             $object->getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(34, $excel_row, $holidays);
             $object->getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, $absent);
             $object->getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row, $ot);
             $object->getActiveSheet()->setCellValueByColumnAndRow(38, $excel_row, $row->date_of_hire);
             if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AG$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AG$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
             $excel_row++;
        }
        if($date_month_days == 29){     
             $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->first_name." ".$row->last_name);
             $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->department);
             $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->employee_id);
             $incr = 0;
             $present = 0;
             $absent = 0;
             $ot = 0;
             $holidays = 0;
             for($i_status=3;$i_status<=31;$i_status++){
                $incr++;
                switch($incr){
                    case 1:
                        $incr = "01";
                        break;
                    case 2:
                        $incr = "02";
                        break;
                    case 3:
                        $incr = "03";
                        break;
                    case 4:
                        $incr = "04";
                        break;
                    case 5:
                        $incr = "05";
                        break;
                    case 6:
                        $incr = "06";
                        break;
                    case 7:
                        $incr = "07";
                        break;
                    case 8:
                        $incr = "08";
                        break;
                    case 9:
                        $incr = "09";
                        break;
                }
                foreach($tbl_attendance as $row_attendance){
                 if($row->id == $row_attendance->emp_id){
                     $filter = $row_attendance->attendance_date;
                     $filter_org = explode("-", $filter);
                     if($filter_date == $filter_org[0]."-".$filter_org[1]){
                        $check_sunday = $filter_org[0]."-".$filter_org[1]."-$incr";
                        if(date('l', strtotime("$check_sunday")) == 'Sunday'){ 
                            if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                if($row_attendance->status == "Overtime"){
                                    $check_status = "OT";
                                    $ot++;
                                    if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                        foreach($tbl_branch as $row_branch){
                                          if($row_branch->id == $row_attendance->client_id)
                                             $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                        }
                                    }
                                }
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                            } else{
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, "S");
                            }
                        }   else{
                                if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                    $location = "";
                                    if($row_attendance->status == "Absent"){
                                        $check_status = "A";
                                        $absent++;
                                    }
                                    if($row_attendance->status == "Overtime"){
                                        $check_status = "OT";
                                        $ot++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($row_attendance->status == "On Leave"){
                                        $check_status = "L";
                                    }
                                    if($row_attendance->status == "Present"){
                                        $check_status = "P";
                                        $present++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($location != "")
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                                    else
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status);
                                }
                            } 
                         }
                     }
                }
             }
             $object->getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $holidays);
             $object->getActiveSheet()->setCellValueByColumnAndRow(34, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, $absent);
             $object->getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, $ot);
             $object->getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row, $row->date_of_hire);
             if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AF$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AF$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
             $excel_row++;
        }
        if($date_month_days == 28){     
             $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->first_name." ".$row->last_name);
             $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->department);
             $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->employee_id);
             $incr = 0;
             $present = 0;
             $absent = 0;
             $ot = 0;
             $holidays = 0;
             for($i_status=3;$i_status<=30;$i_status++){
                $incr++;
                switch($incr){
                    case 1:
                        $incr = "01";
                        break;
                    case 2:
                        $incr = "02";
                        break;
                    case 3:
                        $incr = "03";
                        break;
                    case 4:
                        $incr = "04";
                        break;
                    case 5:
                        $incr = "05";
                        break;
                    case 6:
                        $incr = "06";
                        break;
                    case 7:
                        $incr = "07";
                        break;
                    case 8:
                        $incr = "08";
                        break;
                    case 9:
                        $incr = "09";
                        break;
                }
                foreach($tbl_attendance as $row_attendance){
                 if($row->id == $row_attendance->emp_id){
                     $filter = $row_attendance->attendance_date;
                     $filter_org = explode("-", $filter);
                     if($filter_date == $filter_org[0]."-".$filter_org[1]){
                        $check_sunday = $filter_org[0]."-".$filter_org[1]."-$incr";
                        if(date('l', strtotime("$check_sunday")) == 'Sunday'){ 
                            if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                if($row_attendance->status == "Overtime"){
                                    $check_status = "OT";
                                    $ot++;
                                    if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                        foreach($tbl_branch as $row_branch){
                                          if($row_branch->id == $row_attendance->client_id)
                                             $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                        }
                                    }
                                }
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                            } else{
                                $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, "S");
                            }
                        }   else{
                                if($filter == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                    $location = "";
                                    if($row_attendance->status == "Absent"){
                                        $check_status = "A";
                                        $absent++;
                                    }
                                    if($row_attendance->status == "Overtime"){
                                        $check_status = "OT";
                                        $ot++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($row_attendance->status == "On Leave"){
                                        $check_status = "L";
                                    }
                                    if($row_attendance->status == "Present"){
                                        $check_status = "P";
                                        $present++;
                                        if($row_attendance->attendance_date == $filter_org[0]."-".$filter_org[1]."-$incr"){
                                            foreach($tbl_branch as $row_branch){
                                              if($row_branch->id == $row_attendance->client_id)
                                                 $location = "( ".$row_branch->client_name." - ".$row_branch->branch_name." )";
                                            }
                                        }
                                    }
                                    if($location != "")
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status." ".$location);
                                    else
                                        $object->getActiveSheet()->setCellValueByColumnAndRow($i_status, $excel_row, $check_status);
                                }
                            } 
                         }
                     }
                }
             }
             $object->getActiveSheet()->setCellValueByColumnAndRow(31, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, $holidays);
             $object->getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $present);
             $object->getActiveSheet()->setCellValueByColumnAndRow(34, $excel_row, $absent);
             $object->getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, $ot);
             $object->getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, $row->date_of_hire);
             if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("D$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("D$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("E$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("E$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("F$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("F$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("G$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("G$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("H$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("H$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("I$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("I$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("J$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("J$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("K$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("K$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("L$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("L$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("M$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("M$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("N$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("N$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("O$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("O$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("P$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("P$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Q$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Q$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("R$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("R$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("S$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("S$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("T$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("T$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("U$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("U$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("V$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("V$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("W$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("W$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("X$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("X$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Y$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Y$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("Z$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("Z$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AA$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AA$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AB$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AB$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AC$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AC$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AD$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AD$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "A"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "P"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFC300'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "OT"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'C70039'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "L"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF5733'
                    )
                ));
            }
            if($object->getActiveSheet()->getCell("AE$excel_row")->getValue() == "S"){
                $object->getActiveSheet()->getStyle("AE$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'DAF7A6'
                    )
                ));
            }
            
             $excel_row++;
        }

      }

        $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename="Monthly Attendance Report.xls"');
         $object_writer->save('php://output');

    }
    
    
    
   public function export_manage_attendance()

    {

      $this->load->library('excel');

      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);

      $table_columns = array("Attendance Date","Employees Name","Branch Location","Attendance Status");
      $column = 0;

      foreach($table_columns as $field)
      {
          $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
          $column++;

      }

        $assets=$this->branch->get_data_array1('tbl_attendance');
        $assets_name=$this->branch->get_data_array1('table_employee');
         $assets_branch=$this->branch->get_data_array('tbl_branch');
      $excel_row = 3;
      $emp_name = "";
      
        $object->getActiveSheet()->getStyle('A1:D1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'FFA500'
            )
        ));
        $object->getActiveSheet()->getStyle('A2:D2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => 'F0E68C'
            )
        ));
        $object->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true)->setSize(20);
        $object->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true)->setSize(15);
        $object->getActiveSheet()->setCellValue('A1', 'Faiz Facilities');
        $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      foreach($assets as $row)
      {
          
          $filter = $_POST["export_year"]."-".$_POST["export_month"]."-".$_POST["export_date"];
          if($filter == $row->attendance_date){
               foreach($assets_name as $row_name)
              {
                   if($row_name->id == $row->emp_id){
                      if($row->emp_id == $row_name->id)
                          $emp_name = $row_name->first_name." ".$row_name->last_name;
                       $b_location = "";    
                      foreach($assets_branch as $row_branch){
                          if($row_branch->id == $row->client_id)
                             $b_location = $row_branch->client_name." - ".$row_branch->branch_name;
                      }
    
              
             $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->attendance_date);
             $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $emp_name);
             $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $b_location);
             $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->status);
            if($row->status == "Absent"){
                $object->getActiveSheet()->getStyle("B$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FF0000'
                    )
                ));
            }
            if($row->status == "On Leave"){
                $object->getActiveSheet()->getStyle("B$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => '87CEEB'
                    )
                ));
            }
            if($row->status == "Present"){
                $object->getActiveSheet()->getStyle("B$excel_row")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => 'FFFF00'
                    )
                ));
            }
                   }
              }
             $excel_row++;
          }

      }

        $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename="Manage_Attendance.xls"');
         $object_writer->save('php://output');

    }

   
   
   public function manage_attendance()
	{
		
    $this->data['page'] = 'payroll'; 
    $this->data['sub_page']='attendance_view';
    $this->data['attendances']= $this->attendance->get_all_attendance('tbl_attendance');
    $this->data['employees']=$this->employee_model->get_all_employee('table_employee');
    $this->load->view('admin/attendance/manage_attendance',$this->data);
	}
	
	
	public function edit_attendance()
	{	
    
           $id=$this->uri->segment(4);
		   $con=array('id'=>$id);
		

		   //echo "$id"; exit;	
		  if($_POST)
	   	{      	
					$data['status']=$this->input->post('status');
					$data['client_id']=$this->input->post('client_id');
					//$data['branch_name']=$this->input->post('branch_name');
					$data['comment']=$this->input->post('comment');
		 	       $update=$this->attendance->update_data('tbl_attendance',$con,$data);

				if($update)
	 			{
					$this->session->set_flashdata('msg',"<div style='color:green;'>Attendance Updated Successfully!</div>");
					redirect(base_url().'attendance/manage_attendance');
	 			}
				
            }
			redirect(base_url().'attendance/manage_attendance');
        }
	
	
	
	public function edit_attendance_view()
	{
		 $data=array();
		$data['header']=$this->load->view('admin/include/header','$data',true);
		$data['footer']=$this->load->view('admin/include/footer','$data',true);
		$data['sidebar']=$this->load->view('admin/include/sidebar','$data',true);
		$id=$this->uri->segment(4);
		$data['attendance_item'] = $this->attendance->get_attendance_by_id($id);
    	$data['employees']=$this->employee_model->get_all_employee('table_employee');
        $data['branches']  = $this->branch->get_all_branches();
		 $this->load->view('admin/attendance/edit_attendance_view',$data);
	}
   
  
	public function attendance_view()
	{
     $this->data['page'] = 'payroll'; 
    $this->data['sub_page']='attendance_view';
    $this->data['department']= $this->employee_model->get_data_array('tbl_department');
    $this->data['employees']= $this->employee_model->get_all_employee('table_employee');
    $this->data['store']=$this->Store->getAllStores();
     $this->load->view('admin/include/header',$this->data);
    $this->load->view('admin/include/sidebar',$this->data);   
    $this->load->view('admin/attendance/add_attendance',$this->data);
	}
	
	public function attendance_report()
	{
		$data=array();
		$data['sidebar']=$this->load->view('admin/include/sidebar','',true);
		$data['footer']=$this->load->view('admin/include/footer','',true);
	    $data['header']=$this->load->view('admin/include/header','',true);
		
		$emp_id = $this->input->post('emp_id');
			//echo $emp_id; exit;

			$years = $this->input->post('years');
			$year = substr( $years, -2);

			$month = $this->input->post('month');
		
	    $data['employees'] = $this->employee_model->get_all_employee('table_employee');
         $data['attendance_report'] = $this->attendance->get_all_attendance_report();
		  //echo "<pre>"; 
		  //print_r($attendance_report); exit;
			   
		
		$this->load->view('admin/attendance/attendance_report',$data);
	}
	
	  public function show_attendance_report()
	  
	  {
		  
			$data=array();
			$data['sidebar'] = $this->load->view('admin/include/sidebar','',true);
			$data['footer'] =$this->load->view('admin/include/footer','',true);
			$data['header']=$this->load->view('admin/include/header','',true);
			
			$emp_id = $this->input->post('emp_id');
			//echo $emp_id; exit;

			$years = $this->input->post('years');
			$year = substr( $years, -2);

			$month = $this->input->post('month');

			//$attendance_report = $this->attendance->get_all_attendance_report('tbl_attendance',$year,$month);
			 $attendance_report = $this->attendance->get_all_attendance_report('tbl_attendance',$emp_id);
			    //echo "<pre>"; 
			   //print_r($attendance_report); exit;
			   
			   
			   $cnt = 1;
				if(!empty($attendance_report))
		         {
				foreach($attendance_report as $result) { 
				
				?>
				
              
				<tr>		
					<td class="text-center"><?php echo  $result['id']; ?></td>
					<td class="text-center"><?php //echo  $date; ?></td>
					<td class="text-center"><?php echo  $result['first_name']; ?> <?php echo  $result['last_name']; ?></td>
					<td class="text-center"><?php echo  $result['department']; ?></td>
					<td class="text-center">
					<center>
						<select class="form-control">
						<option value="Absent">Absent</option>
						<option value="Present">Present</option>
						<option value="On Leave">On Leave</option>

						</select>
					</center>
					</td>
					
					<td class="text-center">
					<input type="text" name="overtime">
					</td>
				</tr>

            <?php
				}
			
	        }
			
	  }		
	
	    public function export_manage_attendance_by_id($id)

        {
    
          $this->load->library('excel');
    
          $object = new PHPExcel();
          $object->setActiveSheetIndex(0);
    
          $table_columns = array("Attendance Date","Employees Name","Branch Location","Attendance Status");
          $column = 0;
    
          foreach($table_columns as $field)
          {
              $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
              $column++;
    
          }
    
            $assets=$this->branch->get_data_array1('tbl_attendance');
            $assets_name=$this->branch->get_data_array1('table_employee');
             $assets_branch=$this->branch->get_data_array();
          $excel_row = 3;
          $emp_name = "";
          
            $object->getActiveSheet()->getStyle('A1:D1')->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                     'rgb' => 'FFA500'
                )
            ));
            $object->getActiveSheet()->getStyle('A2:D2')->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                     'rgb' => 'F0E68C'
                )
            ));
            $object->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true)->setSize(20);
            $object->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true)->setSize(15);
            $object->getActiveSheet()->setCellValue('A1', 'Faiz Facilities');
            $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
          foreach($assets as $row)
          {
              
              //$filter = $_POST["export_year"]."-".$_POST["export_month"]."-".$_POST["export_date"];
              if($id == $row->attendance_date){
                  $date_today = $row->attendance_date;
                   foreach($assets_name as $row_name)
                  {
                       if($row_name->id == $row->emp_id){
                          if($row->emp_id == $row_name->id)
                              $emp_name = $row_name->first_name." ".$row_name->last_name;
                           $b_location = "";    
                          foreach($assets_branch as $row_branch){
                              if($row_branch->id == $row->client_id)
                                 $b_location = $row_branch->client_name." - ".$row_branch->branch_name;
                          }
        
                  
                 $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->attendance_date);
                 $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $emp_name);
                 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $b_location);
                 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->status);
                if($row->status == "Absent"){
                    $object->getActiveSheet()->getStyle("B$excel_row")->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => 'FF0000'
                        )
                    ));
                }
                if($row->status == "On Leave"){
                    $object->getActiveSheet()->getStyle("B$excel_row")->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => '87CEEB'
                        )
                    ));
                }
                if($row->status == "Present"){
                    $object->getActiveSheet()->getStyle("B$excel_row")->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => 'FFFF00'
                        )
                    ));
                }
                       }
                  }
                 $excel_row++;
              }
    
          }
            $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment; filename="'.$date_today.'_Manage_Attendance.xls"');
            //$object_writer->save(dirname('http://faizfms.net.in/dailyAttendanceExcelStorage/').$date_today.'_Manage_Attendance.xls');
            $object_writer->save(str_replace(__FILE__,'/home/faizfms/domains/faizfms.net.in/public_html/upload/dailyAttendanceExcelStorage/'.$date_today.'_Manage_Attendance.xls',__FILE__));
            //$object_writer->save('php://output');
            //file_put_contents('http://faizfms.net.in/dailyAttendanceExcelStorage/'.$date_today.'_Manage_Attendance.xls');
            //$name = '/path/to/dailyAttendanceExcelStorage/'.$date_today.'_Manage_Attendance.xls';
            //$objWriter->save($name);
            //$object_writer->save('/upload/dailyAttendanceExcelStorage/'.$date_today.'_Manage_Attendance.xls');
            //$objWriter->save(str_replace(__FILE__,'http://faizfms.net.in/upload/dailyAttendanceExcelStorage/'.$date_today.'_Manage_Attendance.xls',__FILE__));
            // $object_writer->saveExcel2007($object,'http://faizfms.net.in/upload/dailyAttendanceExcelStorage/'.$date_today.'_Manage_Attendance.xls'); 
            return $date_today."_Manage_Attendance.xls";
    
        }

      public function add_emp_attendence()
        {
            $data = $this->input->post();
              $i=0;
            foreach($data['emp_id'] as $emp_id){
            //$this->attendance->employee_attendence_exist($emp_id,$data['attendance_date']);
              if($this->attendance->employee_attendence_exist($emp_id,$data['attendance_date'])==false){
                    $record = array(
                  'emp_id' => $emp_id,
                  'attendance_date' => $data['attendance_date'],
                  'status' => $data['status'.$emp_id],
                  'comment' =>  $data['comment'.$emp_id]
                  );
                  $res = $this->attendance->insert($record);
                  if($res==true){
                      $this->session->set_flashdata('success'," Attendance added successfully!");
                  }else{
                     $this->session->set_flashdata('danger'," Unable to add Attendance");
                  }
              }else{
                  $this->session->set_flashdata('danger'," Attendance of employees is already marked");
              }
     
              }
            redirect(base_url().'attendance/attendance_view');   
          }   
      
      
    public function edit_emp_attendence()
    {
     $data = $this->input->post();
     foreach($data['tbl_id'] as $tbl_id){
        $record = array(
        'status' => $data['status'.$tbl_id],
        'comment' => $data['comment'.$tbl_id],
        );
        $sql=$this->db->where('id',$tbl_id)->update('tbl_attendance', $record);
      }
          if($sql){
              $error['status']=true;
              $error['msg']="Your attendance report is edited For this date Successfully";
          }else{
              $error['status']=false;
              $error['msg']="Unable to update your attendance report";
          }
          echo json_encode($error);
    }   


      public  function delete_attendance($cid)
	{
		
		$data=array();
		$this->attendance->delete_data($cid);
		$this->session->set_flashdata('msg',"<div style='color:green;'>Attendance Deleted Successfully!</div>");
		redirect(base_url().'attendance/manage_attendance');
	} 

    // public function delete_data($id)
    // {
    //   $this->db->where('id', $id);
    //   $this->db->delete('table_employee');
    // }
	
	
	public function show_data()
	
	{
		    //echo "ghgjhgjh"; exit;
			$data=array();
			$data['sidebar'] = $this->load->view('admin/include/sidebar','',true);
			$data['footer'] = $this->load->view('admin/include/footer','',true);
			$data['header'] = $this->load->view('admin/include/header','',true);

			 $date = $this->input->post('date');
			 //echo $date; 
			$employees = $this->employee_model->get_all_employee('table_employee');
			$branches = $this->branch->get_all_branches('tbl_branch');
			
			 //echo "<pre>";
		    // print_r($branches); exit;
				$cnt = 1;
				if(!empty($employees))
		         {
				foreach($employees as $result) { 
				
				?>             
				<tr>		
					<td class="text-center"><?php echo  $result['id']; ?></td>
					<td class="text-center"><?php echo  $date; ?></td>
					<td class="text-center"><?php echo  $result['first_name']; ?> <?php echo  $result['last_name']; ?></td>
					<td class="text-center"><?php echo  $result['department']; ?></td>
					<td class="text-center">
					<center>
						<select class="form-control" style="">
						<option value="Absent">Absent</option>
						<option value="Present">Present</option>
						<option value="On Leave">On Leave</option>

						</select>
					</center>
					</td>
					
					<td class="text-center">
					<input type="text" name="overtime">
					</td>
				</tr>

            <?php
				}
				
			}	else
						{
						?>
						<tr><td colspan="6">NO RECORD FOUND</td></tr>
						<?php
						}
						?>			
<?php
				echo json_encode($result);
	}
	

    public function show_attendance_data()
      {    $output='';
           $checkDate= $this->attendance->is_date_exist($_POST['attendance_date']);
              if (!empty($checkDate)) 
              {
                $data=$this->attendance->get_attendance_data($_POST['attendance_date']);
                $cnt = 1;
                  if(!empty($data))
                  {  
                      foreach($data as $row)
                       {
                        $output .= '
                      <tr>
                      <td>'.$cnt++.'</td>
                      <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                      <td><center>
                      <input type="hidden" name="tbl_id[]" id="tbl_id" value="'.$row['id'].'">
                        <input type="hidden" name="emp_id'.$row['id'].'" id="" value="'.$row['emp_id'].'">
                         <select class="form-control" name="status'.$row['id'].'" value="" >
                          <option '.($row['status'] == 'Present' ? 'selected': '').' value="Present">Present</option>
                          <option '.($row['status'] == 'Absent' ? 'selected': '').' value="Absent">Absent</option>
                          <option '.($row['status'] == 'On Leave' ? 'selected': '').' value="On Leave">On Leave</option>
                          <option '.($row['status'] == 'Overtime' ? 'selected': '').' value="Overtime">Overtime</option>
                          </select>
                      </center></td>
                      <td><input class="form-control" type="text" name="comment'.$row['id'].'" value="'.$row['comment'].'" ></td>
                      </tr>';
                       }
                  }else{
                     $output .= '<tr><td colspan="6"><center><strong>NO RECORD FOUND</strong></center></td></tr>';
                  }
             }else{
             $output .= '<tr><td colspan="6"><center><strong>NO RECORD FOUND</strong></center></td></tr>';
          } 
                $output .= '</table>';
                      echo $output;
                //echo json_encode($data);
        }

        public function attendance_report_view()
        {      $this->data['page'] = 'payroll'; 
              $this->data['sub_page']='attendance_report';
              $this->data['department']= $this->employee_model->get_data_array('tbl_department');
              $this->data['employees']= $this->employee_model->get_all_employee('table_employee');
               $this->data['store']=$this->Store->getAllStores();
              $this->load->view('admin/include/header',$this->data);
              $this->load->view('admin/include/sidebar',$this->data);   
              $this->load->view('admin/attendance/attendance_report',$this->data);
            }

      public function show_attendance_report_view()
            {   
               $output='';
                 $data=$this->attendance->get_leave_report_data($_POST['employee_id'],$_POST['start_date'],$_POST['end_date'],$_POST['status'],$_POST['storeid']);
                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                  <thead>
                  <tr>
                  <th class="text-nowrap">S No</th>
                  <th class="text-nowrap">Date</th>
                  <th class="text-nowrap">Employee Name</th>
                  <th class="text-nowrap">Comment</th>
                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                        foreach($data as $row)
                         {
                          $employee = $this->employee_model->get_employee_by_id($row['emp_id']);
                          //print_r($employee);
                          $output .= '
                        <tr>
                        <td>'.$cnt++.'</td>
                        <td>'.$row['attendance_date'].'</td>
                        <td>'.$employee['first_name'].' '.$employee['last_name'].'</td>
                        <td><p>'.$row['comment'].'</p></td>
                        </tr>';
                         }
                  $output .= '</tbody></table>';
                        echo $output;
        }


        public function academic_calendar()
        {     
              $this->data['page'] = 'payroll'; 
              $this->data['sub_page']='academic_calendar';
              $this->data['department']= $this->employee_model->get_data_array('tbl_department');
              $this->data['employees']= $this->employee_model->get_all_employee('table_employee');
              $this->load->view('admin/include/header',$this->data);
              $this->load->view('admin/include/sidebar',$this->data);   
              $this->load->view('admin/attendance/academic_calendar',$this->data);
               $this->load->view('admin/include/footer',$this->data);   
        }

 

        public function show_acedemic_calender()
            {   
              $year=$_POST['acedemic_year'];
               $showCalander=$this->attendance->show_calander_date($year);
                 $other_paid_leaves=array();
                  $total_work_days=array();
               foreach($showCalander as $row)
               {
                   array_push($other_paid_leaves,$row->other_paid_leaves);
                   array_push($total_work_days,$row->total_work_days);
               }
                $output='';
                 $output .= '<table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
                  <thead>
                  <tr>
                  <th class="text-nowrap">S NO</th>
                   <th class="text-nowrap">Month</th>
                   <th class="text-nowrap">Total Days</th>
                   <th class="text-nowrap">Paid Leaves<br><small>Sundays</small></th>
                   <th class="text-nowrap">Other Paid Leaves<br><small>Exclude sunday</small></th>
                   <th class="text-nowrap">Total Work Days</th>
                  </tr>
                  </thead>
                  <tbody>';
                  $cnt = 1;
                        for($i=1; $i<=12;$i++)
                         { $c=$i-1;
                          $t_days=cal_days_in_month(CAL_GREGORIAN,$i,$year);
                          $t_paid_leaves=  $this->sundayCount('sunday',$i,$year);
                          $month_name=date('F', mktime(0, 0, 0, $i, 10));
                           $output .= '<tr>
                          <td>'.$cnt++.'</td>
                          <td><input class="form-control month" type="hidden" name="year" id="year'.$i.'" readonly="" value="'.$year.'"><input class="form-control month" type="hidden" name="month[]" id="month_'.$i.'" readonly="" value="'.$i.'">'.$month_name.'</td>
                          <td><input class="form-control total_day" type="number" name="total_day[]" id="total_day_'.$i.'" required="true" readonly="" value="'.$t_days.'"></td>
                          <td><input class="form-control total_sunday" type="number" name="total_sunday[]" id="total_sunday_'.$i.'" required="true" readonly="" value="'.$t_paid_leaves.'"></td>
                          <td><input class="other_paid_leaves form-control" type="number" name="other_paid_leaves[]" id="other_paid_leaves_'.$i.'" onkeyup="calc_total_days('.$i.')" required="true"  value="'.@$other_paid_leaves[$c].'"></td>
                          <td><input class="form-control total_work_day" type="text" name="total_work_day[]" id="total_work_day_'.$i.'" required="true" value="'.@$total_work_days[$c].'" readonly=""></td>
                          </tr>';
                         }
                  $output .= '</tbody></table> <input type="submit" name="submit" value="Save Changes" id="save_calender_data" class="btn btn-info" style="margin-top:10px;">';
                  echo $output;
        }

       public function sundayCount($day,$month,$year){
              $totalDay=cal_days_in_month(CAL_GREGORIAN,$month,$year);
              $count=0;
              for($i=1;$totalDay>=$i;$i++){
                if( date('l', strtotime($year.'-'.$month.'-'.$i))==ucwords($day)){
                  $count++;
                  }
              }
              return $count;
      }

      public function add_calender_date(){
          $successCount=0;
          $failCount=0;
          $updateCount=0;
          $year=$_POST['year'];
          $month=$_POST['month'];
          $total_day=$_POST['total_day'];
          $total_sunday=$_POST['total_sunday'];
          $other_paid_leaves=$_POST['other_paid_leaves'];
          $total_work_days=$_POST['total_work_day'];
         for($i=0;$i<=11;$i++){
        if($this->attendance->calender_date_exist($year,$month[$i])==false)
          {
            $paid_leavs=(int)$total_sunday[$i]+(int)$other_paid_leaves[$i];
                    $record = array(
                      'year' => $year,
                      'month' => $month[$i],
                      'total_days' => $total_day[$i],
                      'total_sunday' => $total_sunday[$i],
                      'other_paid_leaves' => $other_paid_leaves[$i],
                      'paid_leavs' =>$paid_leavs,
                      'total_work_days' => $total_work_days[$i] );
                    $add=$this->attendance->insert_calander_date($record);
                      if($add)
                      {
                        $successCount++;
                         $this->session->set_flashdata('success',"Added successfully!");
                      }    
                      else
                      { $failCount++;
                         $this->session->set_flashdata('danger',"Unable to add!");
                      }
            }else{
               $paid_leavs=(int)$total_sunday[$i]+(int)$other_paid_leaves[$i];
                $update=$this->attendance->update_calander_date($year,$month[$i],$total_day[$i],$other_paid_leaves[$i],$paid_leavs,$total_work_days[$i]);
                  if($update){
                        $successCount++;
                         $this->session->set_flashdata('success',"Added successfully!");
                      }    
                      else{ $failCount++;
                         $this->session->set_flashdata('danger',"Unable to add!");
                      }
            }
        }
          redirect(base_url().'attendance/academic_calendar');      
      }


// fetch data from db
public function fetchAllEmployeeData() {
      $department= $this->employee_model->get_data_array('tbl_department');
      $employees= $this->employee_model->getAllEmpByStoreID($_POST['store_id']);
    ?>
     <form action="<?php echo base_url(); ?>Attendance/add_emp_attendence" class="form-horizontal attendance_add_form" id="form_data" method="post" enctype="multipart/form-data" onsubmit="return dateVerification()">
   <div class="row">
      <div class="col-md-4 form-inline">
         <label class="control-label mr-2"><strong>Date:</strong></label>
         <div class="form-group">
            <input type="date" name="attendance_date" class="form-control datepicker" required value="<?= date('Y-m-d');?>">
         </div>
      </div>
      <br><br><br><br><br>
   </div>
   <style> input.largerCheckbox { width:15px; height:15px; } </style>
   <table id="data-table-buttons" class="table table-striped table-bordered table-td-valign-middle">
      <thead>
         <tr>
            <th class="text-nowrap">
               <center><input type="checkbox" name="all" class="all largerCheckbox" id="all" onchange="checkAll(this)"/> <label for='all'>All</label></center>
            </th>
            <!-- <th width="1%" data-orderable="false"></th>
               -->
            <th class="text-nowrap">Employee Name</th>
            <th class="text-nowrap">Department</th>
            <th class="text-nowrap">Designation</th>
            <th class="text-nowrap">Comment</th>
            <th class="text-nowrap" >Status</th>
         </tr>
      </thead>
      <tbody>
         <?php
            $cnt = 1;
            if(!empty($employees))
            {
            foreach($employees as $row)
            {
            if($row['emp_status'] == "Active"){
            $department = $this->dm->get_department_by_id($row['department']);
            $designation = $this->designation->get_designation_by_id($row['designation']);
            ?>  
         <tr>
            <td>
               <center><input type="checkbox" class='item largerCheckbox' name="emp_id[]" value="<?php echo  $row['id']; ?>"></center>
            </td>
            <td><?php echo  $row['first_name']; ?><?php echo  $row['last_name']; ?></td>
            <td><?php echo $department['department_name'] ?></td>
            <td><?php echo $designation['designation'] ?></td>
            <td>
               <center>
                  <input class="form-control" type="text" name="comment<?php echo $row['id']?>" >
               </center>
            </td>
            <td>
               <center>
                  <select class="form-control" name="status<?php echo $row['id'] ?>" value="" style="width:;">
                     <option value="Present">Present</option>
                     <option value="Absent">Absent</option>
                     <option value="On Leave">On Leave</option>
                     <option value="Overtime">Overtime</option>
                  </select>
               </center>
            </td>
         </tr>
         <?php
            } 
            }
            }
            else
            {
            ?>
         <tr>
            <td colspan="6">NO RECORD FOUND</td>
         </tr>
         <?php
            }
            ?>
      </tbody>
   </table>
   <input type="submit" value="Add Attendance" id="submit" class="btn btn-info" style="margin-top:10px;">
   <br><br>
</form>
  <?php }

}

?>