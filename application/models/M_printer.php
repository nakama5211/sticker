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

                users.username as username,

                project.thongtin_khachhang,
        	')
            ->from('printer')
            ->join('users','users.id = printer.id_user')
            ->join('project','project.id = printer.id_project','left')
            ->where($match)
        	->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function load_data_for_task_printer($match){
        $this->db->select('
                printer.*,

                users.username as username,

                task.id as id_task,
                task.status as task_status,
                task.get_at,
                task.done_at, 

                status.name as status_name,

                project.thongtin_khachhang,
            ')
            ->from('printer')
            ->join('task','task.id_project = printer.id_project')
            ->join('users','users.id = task.id_user')
            ->join('status','status.id = task.status')
            ->join('project','project.id = printer.id_project','left')
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
    function extra_update($match,$data,$table){
        $this->db->where($match)
            ->update($table,$data);
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

    function load_print_detail($match){
        $this->db->select('
                print_detail.*,

                material.name as material_name,
                material.price as material_price,
                material.big_size, 

                gia_cong.name as giacong_name,
            ')
            ->from('print_detail')
            ->join('material','material.id = print_detail.id_material','left')
            ->join('gia_cong','gia_cong.id = print_detail.id_outsource','left')
            ->where($match)
            ->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sum_qty($id_project){
        $this->db->select('sum(sum_qty) as sum')
            ->from('print_detail')
            ->where('hidden',0)
            ->where('id_printer',$id_project);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_cost_print($id_project){
        $this->db->select('material.price, print_detail.sum_qty')
            ->from('print_detail')
            ->join('material','material.id = print_detail.id_material')
            ->where('print_detail.hidden',0)
            ->where('print_detail.id_printer',$id_project);
        $query = $this->db->get();
        return $query->result_array();
    }
}
