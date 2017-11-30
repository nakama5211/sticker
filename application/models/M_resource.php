<?php
class M_resource extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    
    function load_data($match,$table){
        $this->db->select()
        		->from($table)
                ->where($match)
        		->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row($id,$table){
        $this->db->select()
            ->from($table)
            ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data,$table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    function update($id,$data,$table){
        $this->db->where('id',$id)
            ->update($table,$data);
    }
    function extra_update($match,$data,$table){
        $this->db->where($match)
            ->update($table,$data);
    }
    function get_last_row($table){
    	$this->db->select()
            ->from($table)
            ->order_by('created_at','desc')
            ->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }
}
