<?php

class Users extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_bill'));
        $this->load->model(array('M_data'));
        $this->load->model('M_department');
        $this->load->model('M_customer');
        $this->load->model('M_material');
        $this->load->model('M_cost');
        $this->load->model('M_debt');
        $this->load->model('M_receipt');
        $this->load->model('M_project');
        $this->load->model('M_revenue');
        $this->load->model('M_printer');
        $this->load->model('M_user');
        $this->load->model('M_task');
        $this->load->model('M_status');
        $this->load->model('M_resource');
        $this->load->helper('date');
        $this->load->helper('string');
        $this->load->helper('My_helper');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $category['category'] = array(
            'dashboard'=>array(
                'name'=>'Bảng tổng quan',
                'link'=>'admin/view_admin/dashboard',
                'icon'=>'fa fa-tachometer'
            ),
            'bill'=> array(
                'name'=>'Đơn hàng',
                'link'=>'admin/view_admin/bill',
                'icon'=>'fa fa-object-group'
            ),
            'project'=> array(
                'name'=>'Quản lý Dự án',
                'link'=>'admin/view_admin/project',
                'icon'=>'fa fa-archive'
            ),
            'revenue'=>array(
                'name'=>'Quản lý Doanh thu',
                'link'=>'admin/view_admin/revenue',
                'icon'=>'fa fa-briefcase'
            ),
            'material'=>array(
                'name'=>'Quản lý Giấy',
                'link'=>'admin/view_admin/material',
                'icon'=>'fa fa-database'
            ),
            'print'=>array(
                'name'=>'Quản lý In',
                'link'=>'admin/view_admin/print',
                'icon'=>'fa fa-print'
            ),
            'resource'=>array(
                'type'=>'tree',
                'name'=>'Quản lý Dữ liệu',
                'content'=>array(
                    'outsouce'=>array(
                        'name'=>'Gia Công',
                        'link'=>'admin/view_admin/outsouce'
                    ),
                    'status'=>array(
                        'name'=>'Trạng thái',
                        'link'=>'admin/view_admin/status'
                    ),
                ),
                'icon'=>'fa fa-table'
            ),
            'user'=>array(
                'name'=>'Quản lý User',
                'link'=>'admin/view_admin/user',
                'icon'=>'fa fa-user'
            ),
        ); 
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
            $user = $this->M_user->login($username, $password);
            if(!$user){ $data['error'] = 1;}//when user doesn't exist
            else //when user exist
            {
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('avatar',$user['avatar']);
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('group',$user['group']);
                redirect(base_url().'admin/admin/view_admin/');
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
     //    $user_id = $this->M_user->create_user($data);
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
        $id_user = $this->M_user->create_user($data);
        echo $id_user; 
    }

    function load_data_for_edit_forM_user(){
        if($this->input->post('id')){
            $match_user = array('id'=>$this->input->post('id'),'hidden' =>0);
        }
        
        $user = $this->M_user->select_user($match_user);
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
        $user = $this->M_user->select_user($match_user);
        if ($post['password'] === '') {
            $data['password'] = $user[0]['password'];
        }else{
            $data['password']   = md5($post['password']);
        }
        $data['avatar']     = $post['avatar'];
        $data['username']   = $post['username'];
        $data['group']      = $post['group'];
        $id_user = $this->M_user->update_user($id,$data);
        echo('success');
    }

    public function deleteRow()
    {
        $id     =   $this->input->post('id');
        $data   =   array('hidden' => 1);
        $this->M_user->update_user($id,$data);
        echo('success');
    }

    public function view_user($id_user){
        $match_user = array(
            'id'=>$id_user,
            'hidden'=>0
        );
        $user_info = $this->M_user->select_user($match_user);
        switch ($user_info[0]['group']) {
            case '3':
                $this->load_view_for_user_printer($id_user);
                break;
            case '4':
                $this->load_view_for_user_designer($id_user);
                break;
            case '2':
                $this->load_view_for_user_counter($id_user);
                break;
            case '5':
                $this->load_view_for_user_delivery($id_user);
                break;
            default:
                redirect(base_url().'admin/admin/view_admin/');
                break;
        }
    }

    public function load_view_for_user_printer($id_user){
        $match['newtask'] = array(
            'task.hidden'=>0,
            'task.status'=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['oldtask'] = array(
            'task.hidden'=>0,
            'task.status!='=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['printer'] = array(
            'task.hidden'=>0,
            'task.id_user'=>$id_user,
            'task.status!='=>'t004',
            'task.status!='=>'t001',
        );
        $category['active']['user'] = 'active';
        // $data['newtask'] = $this->M_task->load_data($match['newtask']);
        $data['oldtask'] = $this->M_task->load_data($match['oldtask']);
        $data['print'] = $this->M_printer->load_data_for_task_printer($match['printer']);
        for($i=0;$i<count($data['print']);$i++){
            foreach (json_decode($data['print'][$i]['thongtin_khachhang'],true) as $key => $value) {
                if ($key=='name') {
                    $data['print'][$i]['customer'] = $value;
                }
            }
            foreach ($data['print'][$i] as $key => $value) {
                if ($key=='id') {
                    $match['print_detail'] = array(
                        'print_detail.id_printer'=>$value,
                        'print_detail.hidden'=>0
                    );
                    $data['print'][$i]['material_name'] = '';
                    $data['print'][$i]['giacong_name'] = '';
                    $data['print'][$i]['name'] = '';
                    $data['print'][$i]['big_size'] = '';
                    $data['print'][$i]['num_print'] = 0;
                    $data['print'][$i]['num_face'] = '';
                    $data['print'][$i]['num_test'] = 0;
                    $data['print'][$i]['num_bad'] = 0;
                    $data['print'][$i]['num_jam'] = 0;
                    $data['print'][$i]['num_reprint'] = 0;
                    $print_detail = $this->M_printer->load_print_detail($match['print_detail']);
                    if(count($print_detail)>0){
                        for ($j=0; $j < count($print_detail); $j++) { 
                            foreach ($print_detail[$j] as $k => $v) {
                                switch ($k) {
                                    case 'material_name':
                                        $data['print'][$i]['material_name'].= $v.';';
                                        break;
                                    case 'name':
                                        $data['print'][$i]['name'].= $v.';';
                                        break;
                                    case 'big_size':
                                        $data['print'][$i]['big_size'].= $v.';';
                                        break;
                                    case 'giacong_name':
                                        $data['print'][$i]['giacong_name'].= $v.';';
                                        break;
                                    case 'num_print':
                                        $data['print'][$i]['num_print']+= $v;
                                        break;
                                    case 'num_face':
                                        $data['print'][$i]['num_face'].= $v.';';
                                        break;
                                    case 'num_test':
                                        $data['print'][$i]['num_test']+= $v;
                                        break;
                                    case 'num_bad':
                                        $data['print'][$i]['num_bad']+= $v;
                                        break;
                                    case 'num_jam':
                                        $data['print'][$i]['num_jam']+= $v;
                                        break;
                                    case 'num_reprint':
                                        $data['print'][$i]['num_reprint']+= $v;
                                        break;
                                    default:
                                        # code...
                                        break;
                                } 
                            }
                        }
                    }
                }
            }
        }
        $this->_data['html_body'] = $this->load->view('admin/v_task_printer',$data, TRUE);
        // Load view header        
        $this->_data['html_header'] = $this->load->view('admin/header', $this->category, TRUE);
        // Load  footer       
        $this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
        // Load view method_one_view        
        $this->load->view('admin/master', $this->_data);
    }

    public function load_view_for_user_designer($id_user){
        $match['newtask'] = array(
            'task.hidden'=>0,
            'task.status'=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['oldtask'] = array(
            'task.hidden'=>0,
            'task.status!='=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['project'] = array(
            'task.hidden'=>0,
            'task.id_user'=>$id_user,
            'task.status!='=>'t004',
            'task.status!='=>'t001',
        );
        $category['active']['user'] = 'active';
        // $data['newtask'] = $this->M_task->load_data($match['newtask']);
        $data['oldtask'] = $this->M_task->load_data($match['oldtask']);
        $data['project'] = $this->M_project->load_my_task_project_bill($match['project']);
        $this->_data['html_body'] = $this->load->view('admin/v_task_design',$data, TRUE);
        // Load view header        
        $this->_data['html_header'] = $this->load->view('admin/header', $this->category, TRUE);
        // Load  footer       
        $this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
        // Load view method_one_view        
        $this->load->view('admin/master', $this->_data);
    }

    public function load_view_for_user_counter($id_user){
        $category['category'] = array(
            'bill'=> array(
                'name'=>'Đơn hàng',
                'link'=>'admin/view_admin/bill',
                'icon'=>'fa fa-object-group'
            ),
            'project'=> array(
                'name'=>'Quản lý Dự án',
                'link'=>'admin/view_admin/project',
                'icon'=>'fa fa-archive'
            ),
            'revenue'=>array(
                'name'=>'Quản lý Doanh thu',
                'link'=>'admin/view_admin/revenue',
                'icon'=>'fa fa-briefcase'
            ),
            'material'=>array(
                'name'=>'Quản lý Giấy',
                'link'=>'admin/view_admin/material',
                'icon'=>'fa fa-database'
            ),
            'print'=>array(
                'name'=>'Quản lý In',
                'link'=>'admin/view_admin/print',
                'icon'=>'fa fa-print'
            ),
            'resource'=>array(
                'type'=>'tree',
                'name'=>'Quản lý Dữ liệu',
                'content'=>array(
                    'outsouce'=>array(
                        'name'=>'Gia Công',
                        'link'=>'admin/view_admin/outsouce'
                    ),
                    'status'=>array(
                        'name'=>'Trạng thái',
                        'link'=>'admin/view_admin/status'
                    ),
                ),
                'icon'=>'fa fa-table'
            ),
            'user'=>array(
                'name'=>'Quản lý User',
                'link'=>'admin/view_admin/user',
                'icon'=>'fa fa-user'
            ),
        );
        $match['newtask'] = array(
            'task.hidden'=>0,
            'task.status'=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['oldtask'] = array(
            'task.hidden'=>0,
            'task.status!='=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['project'] = array(
            'task.hidden'=>0,
            'task.id_user'=>$id_user,
            'task.status!='=>'t004',
            'task.status!='=>'t001',
        );
        $category['active']['user'] = 'active';
        $data['department'] = $this->M_department->load_all_department();
        // $data['newtask'] = $this->M_task->load_data($match['newtask']);
        $data['oldtask'] = $this->M_task->load_data($match['oldtask']);
        $data['revenue'] = [];
        $revenue = $this->M_project->load_my_task_project_revenue($match['project']);
        for($i=0; $i<count($revenue);$i++){
            $data['revenue'][$i]['task_status'] = $revenue[$i]['task_status'];
            $data['revenue'][$i]['get_at'] = $revenue[$i]['get_at'];
            $data['revenue'][$i]['done_at'] = $revenue[$i]['done_at'];
            $data['revenue'][$i]['status_name'] = $revenue[$i]['status_name'];
            $data['revenue'][$i]['tong_chiphi'] = $revenue[$i]['tong_chiphi'];
            $data['revenue'][$i]['id'] = $revenue[$i]['id'];
            $data['revenue'][$i]['project_name'] = $revenue[$i]['project_name'];
            $data['revenue'][$i]['created_at'] = $revenue[$i]['created_at'];
            $data['revenue'][$i]['tong_doanhthu'] = $revenue[$i]['tong_doanhthu'];
            foreach (json_decode($revenue[$i]['thongtin_chiphi'],true) as $key => $value) {
                $data['revenue'][$i][$key] = $value;
            }
            foreach (json_decode($revenue[$i]['thongtin_doanhthu'],true) as $key => $value) {
                $data['revenue'][$i][$key] = $value;
            }
            foreach (json_decode($revenue[$i]['thongtin_khachhang'],true) as $key => $value) {
                $data['revenue'][$i][$key] = $value;
            }
            foreach (json_decode($revenue[$i]['thongtin_donhang'],true) as $key => $value) {
                $data['revenue'][$i][$key] = $value;
            }
        }
        $this->_data['html_body'] = $this->load->view('admin/v_task_revenue',$data, TRUE);
        // Load view header        
        $this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);
        // Load  footer       
        $this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
        // Load view method_one_view        
        $this->load->view('admin/master', $this->_data);
    }

    public function load_view_for_user_delivery($id_user){
        $category['category'] = array(
            'bill'=> array(
                'name'=>'Đơn hàng',
                'link'=>'admin/view_admin/bill',
                'icon'=>'fa fa-object-group'
            ),
            'project'=> array(
                'name'=>'Quản lý Dự án',
                'link'=>'admin/view_admin/project',
                'icon'=>'fa fa-archive'
            ),
            'revenue'=>array(
                'name'=>'Quản lý Doanh thu',
                'link'=>'admin/view_admin/revenue',
                'icon'=>'fa fa-briefcase'
            ),
            'material'=>array(
                'name'=>'Quản lý Giấy',
                'link'=>'admin/view_admin/material',
                'icon'=>'fa fa-database'
            ),
            'print'=>array(
                'name'=>'Quản lý In',
                'link'=>'admin/view_admin/print',
                'icon'=>'fa fa-print'
            ),
            'resource'=>array(
                'type'=>'tree',
                'name'=>'Quản lý Dữ liệu',
                'content'=>array(
                    'outsouce'=>array(
                        'name'=>'Gia Công',
                        'link'=>'admin/view_admin/outsouce'
                    ),
                    'status'=>array(
                        'name'=>'Trạng thái',
                        'link'=>'admin/view_admin/status'
                    ),
                ),
                'icon'=>'fa fa-table'
            ),
            'user'=>array(
                'name'=>'Quản lý User',
                'link'=>'admin/view_admin/user',
                'icon'=>'fa fa-user'
            ),
        );
        $match['newtask'] = array(
            'task.hidden'=>0,
            'task.status'=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['oldtask'] = array(
            'task.hidden'=>0,
            'task.status!='=>'t001',
            'task.id_user'=>$id_user,
        );
        $match['project'] = array(
            'task.hidden'=>0,
            'task.id_user'=>$id_user,
            'task.status!='=>'t004',
            'task.status!='=>'t001',
        );
        $category['active']['user'] = 'active';
        $data['department'] = $this->M_department->load_all_department();
        // $data['newtask'] = $this->M_task->load_data($match['newtask']);
        $data['oldtask'] = $this->M_task->load_data($match['oldtask']);
        $data['project'] = [];
        $project = $this->M_project->load_my_task_project_delivery($match['project']);
        for($i=0; $i<count($project);$i++){
            $data['project'][$i]['task_status'] = $project[$i]['task_status'];
            $data['project'][$i]['get_at'] = $project[$i]['get_at'];
            $data['project'][$i]['done_at'] = $project[$i]['done_at'];
            $data['project'][$i]['status_name'] = $project[$i]['status_name'];
            
            $data['project'][$i]['id'] = $project[$i]['id'];
            $data['project'][$i]['project_name'] = $project[$i]['project_name'];
            $data['project'][$i]['created_at'] = $project[$i]['created_at'];
            
            foreach (json_decode($project[$i]['thongtin_khachhang'],true) as $key => $value) {
                $data['project'][$i][$key] = $value;
            }
            foreach (json_decode($project[$i]['thongtin_donhang'],true) as $key => $value) {
                $data['project'][$i][$key] = $value;
            }
        }
        $this->_data['html_body'] = $this->load->view('admin/v_task_delivery',$data, TRUE);
        // Load view header        
        $this->_data['html_header'] = $this->load->view('admin/header', $category, TRUE);
        // Load  footer       
        $this->_data['html_footer'] = $this->load->view('admin/footer', NULL, TRUE);
        // Load view method_one_view        
        $this->load->view('admin/master', $this->_data);
    }
}