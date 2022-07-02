<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends CI_Model {

	public function __construct()
		{
		parent::__construct();

		$this->table= 'tbl_attendance';
		$this->primary_key='id';

		}	
	
	public function save_data($data)	 
	  {		 
		$this->db->insert('table_employee',$data);
		return true;				
	  } 

	 
	  
	   public function get_attendance_by_id($id = 0)
    
	{
		if ($id === 0)
		{
		$query = $this->db->get($this->table);
		return $query->result_array();
		}

		$query = $this->db->get_where($this->table, array('id' => $id));
		return $query->row_array();
    }
    
    
    
	  
	   public function get_all_attendance($tbl)
		{
			
			
			$this->db->select ('table_employee.*,tbl_attendance.*'); 
			$this->db->from($tbl);
			$this->db->join('table_employee', 'tbl_attendance.emp_id = table_employee.id');
			$query = $this->db->get();

			if($query->num_rows() != 0)
			{
			return $query->result();
			}
			else
			{
			return false;
			}
		
		}
	  
	  
	  
	  
	  public function insert($data)
	  {			
			return $this->db->insert($this->table, $data);		
	  } 
	  

	  public function employee_attendence_exist($emp_id,$attendance_date)
		{
			$this->db->where('emp_id',$emp_id);
			$this->db->where('attendance_date',$attendance_date);
			$q= $this->db->get($this->table)->row();
			return $q;
		}

	
	  // update date of attendence
	 public function update_attendence($data)
	  {
		     $i=0;
				
			return $record;		
	  	} 

		public function get_all_attendance_report()
		
		{
		    
		    $this->db->select ( 'table_employee.*,tbl_attendance.*'); 
			$this->db->from($this->table);
			$this->db->join('table_employee', 'tbl_attendance.emp_id = table_employee.id');
			$query = $this->db->get();

			if($query->num_rows() != 0)
			{
			return $query->result();
			}
			else
			{
			return false;
			}
		
		    
		
			//$this->db->from($tbl);
			//$this->db->select('*');
		//	$this->db->where('emp_id', $emp_id);
			//$this->db->where('attendance_date',$month);
		//	$res=$this->db->get();
		//	return $res->result_array();

		}
		
	 public function get_data($tbl,$department,$data)
	{
		$this->db->from($tbl);
		$this->db->select('*');
		$this->db->where('department', $department);
		$res=$this->db->get();
		return $res->result_array();
    }

    public function get_employee_by_id($id = 0)
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
	$this->db->delete($this->table);
	}

public function is_date_exist($attendance_date)
	{
		$this->db->where('attendance_date',$attendance_date);
		$q= $this->db->get($this->table)->row();
		return $q;

	}


public function filter_attendance($data)
	{
		$this->db->where($data);
		$q= $this->db->get($this->table)->row();
		return $q;

	}

public function is_employeeid_exist($emp_id)
	{
		$this->db->where('emp_id',$emp_id);
		$q= $this->db->get($this->table)->row();
		return $q;
	}




public function get_attendance_data($attendance_date)
		 {
		  $this->db->select("*");
		  $this->db->from($this->table);
		  $this->db->join('table_employee', 'tbl_attendance.emp_id = table_employee.id');
		  $this->db->where('tbl_attendance.attendance_date',$attendance_date);
		  return $this->db->get()->result_array();
		 }

		 public function get_leave_report_data($empid,$start_date,$end_date,$status,$storeid)
		 {
		  $this->db->select("*");
		  $this->db->from($this->table);
		  $this->db->join('table_employee', $this->table.'.emp_id = table_employee.id', 'LEFT');
		  $this->db->where('status',$status);
		  if ($empid != NULL) {
			$this->db->where('emp_id',$empid);
		  } 
		  if ($storeid != 'all') {
			$this->db->where('emp_store_name',$storeid);
		  }
		  	$this->db->where('attendance_date BETWEEN "'.$start_date.'" and "'.$end_date.'"');
		   	return $this->db->get()->result_array();
		 }

		 // calender date insert 
		public function insert_calander_date($data)	 
			  {		 
				$this->db->insert('tbl_calendar',$data);
				return true;				
			  } 
		public function update_calander_date($year,$month,$total_days,$other_paid_leaves,$paid_leavs,$total_work_days)	 
			  {		 
				$this->db->set('total_days', $total_days);
				$this->db->set('paid_leavs', $paid_leavs);
				$this->db->set('total_work_days', $total_work_days);
				$this->db->set('other_paid_leaves', $other_paid_leaves);
				$this->db->where('year', $year);
				$this->db->where('month', $month);
				$this->db->update('tbl_calendar');
				return true;				
			  }
		public function show_calander_date($year)	 
			  {		
			  	$this->db->select('other_paid_leaves,total_work_days'); 
					$this->db->from('tbl_calendar');
					$this->db->where('year', $year);
					$query = $this->db->get();
					return $query->result();
			  } 
		public function calender_date_exist($year,$month)
			{
				$this->db->where('year',$year);
				$this->db->where('month',$month);
				$q= $this->db->get('tbl_calendar')->row();
				return $q;
			}
}