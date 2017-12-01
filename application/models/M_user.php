<?php
class M_user extends CI_Model
{
    function create_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();;
    }
    function login($username, $password)
    {
        $match = array(
            'username'=>$username,
            'password' => md5($password),
        );
        
        $this->db->select()->from('users')->where($match);
        $query = $this->db->get();
        return $query->first_row('array');
    }
    function load_data($match){
        $this->db->select('id,username,group')
            ->from('users')
            ->where($match);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function select_user($match)
    {
        $this->db->select()
            ->from('users')
            ->where($match);
        $query = $this->db->get();
        return $query->result_array();
    }
    function update_user($id,$data)
    {
        $this->db->where('id',$id)->update('users', $data);
    }
}
