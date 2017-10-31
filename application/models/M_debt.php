<?php
class M_debt extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_all(){
        $this->db->select()
        		->from('debt')
        		->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('debt', $data);
        return $this->db->insert_id();;
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('debt',$data);
    }
}
