<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();
		}	
	
	public function save_data($data)	 
	  {		 
		$this->db->insert('table_employee',$data);
		return true;				
	  } 
	  
	  
	 function get_all_employee($tbl)
    {  
	
        $this->db->from($tbl);
		$this->db->select('*');
	    $res=$this->db->get();
        return $res->result_array();
    }
	public function count_total_employee()
	{
	    
        $this->db->select('*');
        $this->db->from('table_employee');
        $id = $this->db->get()->num_rows();
        return $id;
	    
	}
	
		
	 public function get_data()
	{
		  $q = $this->db->get("table_employee");
            if($q->num_rows() > 0)
            {
                return $q->result();
            }
            return array();
    }

    public function get_employee_by_id($store_id=0,$employee_id=0,$department_id=0,$designation_id=0)
	    {
		       $this->db->select('*');
		       $this->db->from('table_employee');
		        if($employee_id!='all'){
		        	 $this->db->where('id',$employee_id);
		        }
		        if($store_id!='all'){
		        	 $this->db->where('emp_store_name',$store_id);
		        }
		         if($department_id!='all'){
		        	 $this->db->where('department',$department_id);
		        }
		         if($designation_id!='all'){
		        	$this->db->where('designation',$designation_id);
		        }
		   			$query = $this->db->get();
		  			 //$str = $this->db->last_query();
					// echo $str;

				    if ( $query->num_rows() > 0 )
				    {
				        $row = $query->result_array();
				        return $row;
				    }
	      }

    public function get_employee_by_id_edit($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('table_employee');
            return $query->result_array();
        }      
 
        $query = $this->db->get_where('table_employee', array('id' => $id));
        return $query->row_array();
    }

		
	public function update_data($tbl,$con,$data)
    {
        $this->db->where($con);
        $this->db->update($tbl,$data);
        return $this->db->affected_rows();
    }
	
	function get_data_array($tbl)
    {  
	
        $this->db->from($tbl);
		$this->db->select('*');
	    $res=$this->db->get();
        return $res->result_array();
    }
	
	public function delete_data($id)
    {
	$this->db->where('id', $id);
	$this->db->delete('table_employee');
	}

	 function fetch_designation_name($dept_id)
		 {
			 if(($dept_id!='all') && ($dept_id!=''))
			 {
			 	$this->db->where('dept_id', $dept_id);
			 }
		  $this->db->order_by('dept_id', 'ASC');
		  $query = $this->db->get('tbl_designation');
		  return $query;
		 }



	 function fetch_empname_by_depart($dept_id)
		 {
			 if(($dept_id!='all') && ($dept_id!=''))
			 {
			 	$this->db->where('department', $dept_id);
			 }
		  $this->db->order_by('first_name', 'ASC');
		  $query = $this->db->get('table_employee');
		  return $query;
		 }


	 function fetch_employee_name($design_id)
		 {
		 	 if(($design_id!='all') && ($design_id!=''))
			 {
			 	 $this->db->where('designation', $design_id);
			 }
			  $this->db->order_by('employee_id', 'ASC');
			  $query = $this->db->get('table_employee');
			  return $query;
		 }


	 function fetch_employee_depart_name($depart_id)
		 {
		 	 if(($depart_id!='all') && ($depart_id!=''))
			 {
			 	 $this->db->where('department', $depart_id);
			 }
			  $this->db->order_by('employee_id', 'ASC');
			  $query = $this->db->get('table_employee');
			  return $query;
		 }

		public function get_employee_data()
		 {
		  $this->db->select("*");
		  $this->db->from('table_employee');
		  // $this->db->join('tbl_department', 'tbl_department.id = table_employee.department');
		  return $this->db->get()->result_array();
		 }
		public function getEmployeeDataByStoreName($store_id,$status)
		 {
		  $this->db->select("*");
		  $this->db->from('table_employee');
		  	if($store_id!=null){
		 		 $this->db->where('emp_store_name',$store_id);
		  	}
		 	$this->db->where('emp_status',$status);
		  return $this->db->get()->result_array();
		 }


		 public function get_employee_data_by_id($empid)
		 {
		  $this->db->select("*");
		  $this->db->from('tbl_manage_employee');
		  $this->db->where('manage_employee_id',$empid);
		  return $this->db->get()->row_array();
		 }

		 public function get_employee_data_by_empid($empid)
		 {
		  $this->db->select("*");
		  $this->db->from('table_employee');
		  $this->db->where('employee_id',$empid);
		  return $this->db->get()->row_array();
		 }

		 public function is_employee_id_exist($empid)
			{
				$this->db->where('employee_id',$empid);
				$q=$this->db->get('table_employee')->row();
				return $q;
			}

		 public function get_employee_payslip_data($empid,$date)
		 {
		  $this->db->select("*");
		  $this->db->from($this->table);
		  $this->db->where();
		  if ($empid != NULL) {
			$this->db->where('emp_id',$empid);
		  }
		  $this->db->where('attendance_date BETWEEN "'.$start_date.'" and "'.$end_date.'"');
		  return $this->db->get()->result_array();
		 }

		 public function get_working_days($startdate,$enddate)
		 {
			 $this->db->select('COUNT(DISTINCT `attendance_date`) as w_day');
		  	$this->db->from('tbl_attendance');
			$this->db->where('attendance_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" and "'. date('Y-m-d', strtotime($enddate)).'"');
			return $this->db->get()->row_array();
		 }

		 public function get_present_days($empid,$startdate,$enddate)
		 {
			 $this->db->select('COUNT(DISTINCT `attendance_date`) as present_day');
		  	$this->db->from('tbl_attendance');
			$this->db->where('attendance_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" and "'. date('Y-m-d', strtotime($enddate)).'"');
			$this->db->where('emp_id',$empid);
			$this->db->where('status','Present');
			return $this->db->get()->row_array();
		 }

		 public function get_absent_days($empid,$startdate,$enddate)
		 {
			 $this->db->select('COUNT(DISTINCT `attendance_date`) as absent_day');
		  	$this->db->from('tbl_attendance');
			$this->db->where('attendance_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" and "'. date('Y-m-d', strtotime($enddate)).'"');
			$this->db->where('emp_id',$empid);
			$this->db->where('status','Absent');
			return $this->db->get()->row_array();
		 }

		 public function get_leave_days($empid,$startdate,$enddate)
		 {
			 $this->db->select('COUNT(DISTINCT `attendance_date`) as leave_day');
		  	$this->db->from('tbl_attendance');
			$this->db->where('attendance_date BETWEEN "'. date('Y-m-d', strtotime($startdate)). '" and "'. date('Y-m-d', strtotime($enddate)).'"');
			$this->db->where('emp_id',$empid);
			$this->db->where('status','On Leave');
			return $this->db->get()->row_array();
		 }



		 public function get_calender_data($month,$year)
		 {
			 $this->db->select('*');
		  	$this->db->from('tbl_calendar');
			$this->db->where('year',$year);
			$this->db->where('month',$month);
			return $this->db->get()->row_array();
		 }

		 public function get_departname_data($id)
		 {
			 $this->db->select('*');
		  	$this->db->from('tbl_department');
			$this->db->where('id ',$id);
			return $this->db->get()->row_array();
		 }

		 public function get_design_data($id)
		 {
			 $this->db->select('*');
		  	$this->db->from('tbl_designation');
			$this->db->where('id ',$id);
			return $this->db->get()->row_array();
		 }


		public function show_employee_by_id($department_id=0,$designation_id=0)
	    {
		       $this->db->select('*');
		       $this->db->from('table_employee');
		         if($department_id!='all'){
		        	 $this->db->where('department',$department_id);
		        }
		         if($designation_id!='all'){
		        	$this->db->where('designation',$designation_id);
		        }
		        	$query = $this->db->get();
				    if ( $query->num_rows() > 0 )
				    {
				        $row = $query->result_array();
				        return $row;
				    }
	      }

	      public function get_underemp_count($empid)
		 {
			 $this->db->select('*');
		  	$this->db->from('table_employee');
			$this->db->where('reporting_to',$empid);
			return $this->db->get()->num_rows();
		 }

		  public function get_underemp_data($empid)
		 {

			 $this->db->select('*');
		  	$this->db->from('table_employee');
			$this->db->where('reporting_to',$empid);
			return $this->db->get()->result_array();
			 // $str = $this->db->last_query();
		  //   echo "<pre>";
		  //   print_r($str);
		  //   exit;
		 }

		   public function is_data_exist($col_name,$data)
				{
					$this->db->where($col_name,$data);
					return $this->db->get('table_employee')->num_rows();
				}


}