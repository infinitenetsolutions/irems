<?php
class Main_model extends CI_Model {
    
    function tbl_insert($tbl,$data)
    {
        $res=$this->db->insert($tbl,$data);
        return $this->db->insert_id();
    }
    

  
}


