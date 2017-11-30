<?php
class M_printer extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_data($match){
        $this->db->select('
        		printer.*,

        		project.id as id_project,

        		bill.quantity as quantity,
                bill.note as bill_note,

        		customer.name as customer,

        		material.name as material,
        		material.exc_size as exc_size,

                gia_cong.name as outsource_name,

                users.username as username,
        	')
        	->from('printer')
        	->join('project','project.id = id_project','left')
        	->join('material','material.id = id_material','left')
        	->join('bill','bill.id = project.id_bill','left')
        	->join('customer','customer.id = bill.id_customer','left')
            ->join('gia_cong','gia_cong.id = outsource','left')
            ->join('users','users.id = id_user','left')
            ->where($match)
        	->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row($match){
        $this->db->select()
            ->from('printer')
            ->where($match);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('printer', $data);
        return $this->db->insert_id();;
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('printer',$data);
    }
    function update_row($id_project,$data){
        $this->db->where('id_project',$id_project)
            ->update('printer',$data);
    }
    public function get_tong_to_in($idProject='')
    {
        $this->db->select('tong_so_giay_in_su_dung as tong_to, id_material')
            ->from('printer')
            ->where('id_project',$idProject);
        $query = $this->db->get();
        return $query->result_array();
    }
}
