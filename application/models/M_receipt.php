<?php
class M_receipt extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_all(){
        $this->db->select()
        		->from('receipt')
        		->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row($id){
    	$this->db->select()
        		->from('receipt')
        		->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('receipt', $data);
        return $this->db->insert_id();;
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('receipt',$data);
    }
}
