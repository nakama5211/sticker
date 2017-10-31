<?php

class Users extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('m_user');
    }
    function login()
    {
        if($this->session->userdata("user_id"))//If already logged in
        {
            redirect(base_url().'admin/admin/view_admin/bill');
            //redirect to the admin page
        }
        $data['error'] = 0;
        if($this->input->post())//data inputed for login
        {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $user = $this->m_user->login($username, $password);
            if(!$user){ $data['error'] = 1;}//when user doesn't exist
            else //when user exist
            {
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('group',$user['group']);
                redirect(base_url().'admin/admin/view_admin/bill');
            }
        }
        $data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
        $this->load->view('admin/v_login',$data);
    }
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url().'admin/users/login/');
    }
    function create_user(){
    	// $data = array(
     //    'username' => "manam3",
     //    'password' => sha1('123456'),
     //    'group' => '3',
     //    );
     //    $user_id = $this->m_user->create_user($data);
     //    $this->session->set_userdata('user_id',$user_id);
     //    $this->session->set_userdata('username',$data['username']);
     //    $this->session->set_userdata('group',$data['group']);
        // redirect(base_url().'admin/admin/');
        $data['error'] = "success";

        var_dump($data);
    }
}