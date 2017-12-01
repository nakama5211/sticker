<?php
class M_task extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    function load_all(){
        $this->db->select()
        		->from('task')
        		->order_by('id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_row($id){
    	$this->db->select()
        		->from('task')
        		->where('id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function load_data($match){
    	$this->db->select('
    				task.id,
    				task.status,
    				task.created_at,
    				task.done_at,
    				task.updated_at,

    				project.id as id_project,

    				typeproject.name as typeproject,

    				bill.file as file,

                    status.name as status_name,
    			')
    			->join('project','project.id = task.id_project','left')
    			->join('typeproject','typeproject.id = project.id_typeproject','left')
    			->join('bill','bill.id = project.id_bill','left')
                ->join('status','status.id = task.status')
        		->from('task')
        		->where($match);
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert($data)
    {
        $this->db->insert('task', $data);
        return $this->db->insert_id();
    }
    function update($id,$data){
        $this->db->where('id',$id)
            ->update('task',$data);
    }

    function get_task_by_match($match){
        $this->db->select('
            users.username,

            department.progress,

            project.status,
        ')
        ->from('task')
        ->join('users','users.id = task.id_user','left')
        ->join('department','department.id = users.group','left')
        ->join('project','project.id = task.id_project','left')
        ->where($match);
        $query = $this->db->get();
        return $query->result_array();
    }
}
