<?php
class M_material extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_all(){
        $this->db->select()
        		->from('material')
        		->order_by('id','desc');
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
}
