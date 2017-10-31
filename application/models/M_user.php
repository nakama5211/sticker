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
            'password' => sha1($password),
        );
        
        $this->db->select()->from('users')->where($match);
        $query = $this->db->get();
        return $query->first_row('array');
    }
}
