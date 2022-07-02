<?php

class Admin_model extends CI_Model
{
	public function check_login($data)
	{
	    $this->db->where('username',$data['username']);
		$this->db->where('password',$data['password']);
		$q = $this->db->get('admin');

		if($q->num_rows()>0)
		{
			$row = $q->row();
			$arr['admin_id'] = $row->id;
			$arr['admin_username'] = $row->username;
			//$arr['user_type'] = $row->user_type;
			$this->session->set_userdata($arr);
			return TRUE;
		}
		else
		{
			//echo "abcd";die();
			return FALSE;
		}
	}
	
	
	
	
	public function change_pass($tbl,$data,$username)
	{
	    $this->db->where('username',$username);
        $this->db->update($tbl,$data);
        return $this->db->affected_rows();
	}
	public function check_login_user($data)
	{
		$this->db->where('email',$data['username']);
		$this->db->where('password',$data['password']);
		$this->db->where('status',1);
		$q = $this->db->get('users');
		echo $this->db->last_query(); die();
		if($q->num_rows()>0)
		{
			$arr['username'] = $data['username'];
			$row = $q->row();
			$arr['uid'] = $row->user_id;
			$arr['name'] = $row->fname;
			$arr['type'] = $row->calendar_id;
			if($arr['type']==1)
			{
				$arr['is_admin'] = TRUE;
			}
			else if($arr['type']==2)
			{
				$arr['is_sub_admin'] = TRUE;
			}
			else if($arr['type']==3)
			{
				$arr['is_sales'] = TRUE;
			}
			else
			{
				$arr['is_customer'] = TRUE;
			}
			//print_r ($arr);die();
			//$this->session->sess_destroy();
			$this->session->set_userdata($arr);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	public function save($tbl,$data)

		{

			$res=$this->db->insert($tbl,$data);

			return $this->db->insert_id();

		}
		
	
	
	
		public function get_all_feedbacks($tbl)
	   {
		 	
		$q = $this->db->get($tbl);
		if($q->num_rows() > 0)
		{
		return $q->result();
		}
		return array();
        }
	
	public function get_all_permission_list($tbl)
	   {
		 $this->db->where('admin_type','superadmin');
         $this->db->or_where('admin_type','subadmin');		
		$q = $this->db->get($tbl);
		if($q->num_rows() > 0)
		{
		return $q->result();
		}
		return array();
        }
	
	public function get_all_permission_list_by_id($id = 0)
    
	{
		if ($id === 0)
		{
		$query = $this->db->get('tbl_users');
		return $query->result_array();
		}

		$query = $this->db->get_where('tbl_users', array('user_id' => $id));
		return $query->row_array();
    }
	
	
	public function update_data($tbl,$con,$data)
    {
        $this->db->where($con);
        $this->db->update($tbl,$data);
        return $this->db->affected_rows();
    }	
	
	
	public function delete_data($id)
	   {
	
		$this->db->where('id', $id);
		$this->db->delete('tbl_users');
		}
		
		
		public function delete_feedback($id)
	   
	   {
	
		$this->db->where('id', $id);
		$this->db->delete('tbl_feedback');
		}
		
		
		public function delete_admin_list($id)
	   {
	
		$this->db->where('user_id', $id);
		$this->db->delete('tbl_users');
		}
	
	
	
	
	 function isLoggedIn()
    {   if(!$this->session->userdata('u_type'))
            return false;
        else
            return true;
    }
	
	
	
	
	
}