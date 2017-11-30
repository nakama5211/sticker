<?php
class M_cost extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_all(){
        $this->db->select()
        		->from('cost')
        		->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('cost', $data);
        return $this->db->insert_id();;
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('cost',$data);
    }

    function extra_update($match,$data){
        $this->db->where($match)
            ->update('cost',$data);
    }
}
