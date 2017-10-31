<?php
class M_customer extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function insert_customer($data)
    {
        $this->db->insert('customer', $data);
        return $this->db->insert_id();;
    }
    function update_customer($id,$data){
        $this->db->where('id',$id)
            ->update('customer',$data);
    }
}
