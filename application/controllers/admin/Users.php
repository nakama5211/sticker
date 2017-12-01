<?php

class Users extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('m_user');
        $this->load->model('M_department');
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
    public function insertUser()
    {
        $post = $this->input->post();
        $data['avatar']     = $post['avatar'];
        $data['username']   = $post['username'];
        $data['password']   = md5($post['password']);
        $data['group']      = $post['phong_ban'];
        $id_user = $this->m_user->create_user($data);
        echo $id_user; 
    }

    function load_data_for_edit_form_user(){
        if($this->input->post('id')){
            $match_user = array('id'=>$this->input->post('id'),'hidden' =>0);
        }
        
        $user = $this->m_user->select_user($match_user);
        $department = $this->M_department->load_all_department();
        $data['form-data'] = '';
        $data['form-data'].= '<input type="hidden" name="id" value="'.$user[0]['id'].'">';
        unset(
            $user[0]['id'],
            $user[0]['hidden']
        );
        foreach ($user[0] as $key => $value) {
            switch ($key) {
                case 'avatar':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Ảnh đại diện</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'username':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Tên đăng nhập</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'password':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Mật khẩu</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="password" class="form-control" name="'.$key.'" value="">
                        </div>
                    </div>
                    ';
                    break;
                case 'group':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Phòng ban</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                            <select class="form-control" name="'.$key.'" id="groupEdit">';
                            foreach ($department as $depar) {
                                if($value == $depar['id']){
                                    $data['form-data'].='<option selected="" name="'.$depar['name'].'" value="'.$depar['id'].'" >'.$depar['name'].'</option>';
                                }else
                                $data['form-data'].='<option value="'.$depar['id'].'" name="'.$depar['name'].'" >'.$depar['name'].'</option>';
                            }
                    $data['form-data'].='</select></div>
                    </div>
                    ';
                    break; 
                
                default:
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>'.$key.'</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
            }
        }
        $data['form-data'].= '
            <div class="form-group">
                <div class="help-block" id="error-quantity"></div>
            </div>
        ';
        echo json_encode($data['form-data']);
    }
    public function updateUser()
    {
        $post = $this->input->post();
        $id                 = $post['id'];
        $match_user = array('id'=>$id,'hidden' =>0);
        $user = $this->m_user->select_user($match_user);
        if ($post['password'] === '') {
            $data['password'] = $user[0]['password'];
        }else{
            $data['password']   = md5($post['password']);
        }
        $data['avatar']     = $post['avatar'];
        $data['username']   = $post['username'];
        $data['group']      = $post['group'];
        $id_user = $this->m_user->update_user($id,$data);
        echo('success');
    }

    public function deleteRow()
    {
        $id     =   $this->input->post('id');
        $data   =   array('hidden' => 1);
        $this->m_user->update_user($id,$data);
        echo('success');
    }
}