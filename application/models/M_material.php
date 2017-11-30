<?php
class M_material extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    
    function load_data($match){
        $this->db->select()
        		->from('material')
                ->where($match)
        		->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row($id){
        $this->db->select()
            ->from('material')
            ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('material', $data);
        return $this->db->insert_id();;
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('material',$data);
    }
    function get_quantity($id){
        $this->db->select('quantity')
            ->from('material')
            ->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
