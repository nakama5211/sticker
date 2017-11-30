<?php
class M_status extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function get_row($id){
        $this->db->select()
            ->from('status')
            ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function load_status_by_type($type)
    {
        $this->db->select()
            ->from('status')
            ->where('type',$type);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('status', $data);
        return $this->db->insert_id();;
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('status',$data);
    }
    function get_status_name($id){
        $this->db->select('name')
            ->from('status')
            ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
