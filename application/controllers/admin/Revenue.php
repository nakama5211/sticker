<?php 
class Revenue extends CI_Controller{

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('excel');
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
        $this->load->helper('date');
        $this->load->helper('string');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    function update_data_revenue(){
        $frm = $this->input->post();
        // var_dump($frm);
        $id_project = $frm['id_project'];
        unset($frm['id_project']);
        $match['project'] = array(
            'project.id'=>$id_project,
            'project.hidden'=>0
        );
        $project = $this->M_project->get_row($match['project']);
        if($project[0]['thongtin_doanhthu']){
            $list_revenue = json_decode($project[0]['thongtin_doanhthu'],true);
            foreach ($list_revenue as $key => $value) {
                if(isset($frm[$key])){
                    $list_revenue[$key] = $frm[$key];
                }
            }
        }
        $new_data['project'] = array(
            'thongtin_doanhthu'=>json_encode($list_revenue)
        );
        $this->M_data->update($match['project'],$new_data['project'],'project');
        $data['success'] = "thành công.";
        echo json_encode($data);
    }

    function update_data_cost(){
        $frm = $this->input->post();
        // var_dump($frm);
        $id_project = $frm['id_project'];
        unset($frm['id_project']);
        $match['project'] = array(
            'project.id'=>$id_project,
            'project.hidden'=>0
        );
        $project = $this->M_project->get_row($match['project']);
        if($project[0]['thongtin_chiphi']){
            $list_cost = json_decode($project[0]['thongtin_chiphi'],true);
            foreach ($list_cost as $key => $value) {
                if(isset($frm[$key])){
                    $list_cost[$key] = $frm[$key];
                }
            }
        }
        $new_data['project'] = array(
            'thongtin_chiphi'=>json_encode($list_cost)
        );
        $this->M_data->update($match['project'],$new_data['project'],'project');
        $data['success'] = "thành công.";
        echo json_encode($data);
    }

    function load_data_update_revenue(){
        $id_project = $this->input->post('id_project');
        $match['project'] = array(
            'project.id'=>$id_project,
            'project.hidden'=>0
        );
        $data['form-data'] = '';
        $data['form-data'].= '<input type="hidden" name="id_project" value="'.$id_project.'">';
        $project = $this->M_project->get_row($match['project']);
        if($project[0]['thongtin_doanhthu']){
            foreach (json_decode($project[0]['thongtin_doanhthu'],true) as $key => $value) {
                switch ($key) {
                    case 'doanhthu_thietke':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Doanh thu thiết kế</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'tam_ung':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Tạm ứng</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'ngay_tam_ung':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Ngày tạm ứng</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="date" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'status_thu_tien':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Tình trạng thu tiền</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'phieu_thu':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Phiếu thu/ Hóa đơn</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'ghi_chu':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Ghi chú</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <textarea type="text" class="form-control" name="'.$key.'">'.$value.'</textarea>
                            </div>
                        </div>
                        ';
                        break;
                    default:
                        
                        break;
                }  
            }
        }
        echo json_encode($data['form-data']);
    }

    function load_data_update_cost(){
        $id_project = $this->input->post('id_project');
        $match['project'] = array(
            'project.id'=>$id_project,
            'project.hidden'=>0
        );
        $data['form-data'] = '';
        $data['form-data'].= '<input type="hidden" name="id_project" value="'.$id_project.'">';
        $project = $this->M_project->get_row($match['project']);
        if($project[0]['thongtin_chiphi']){
            foreach (json_decode($project[0]['thongtin_chiphi'],true) as $key => $value) {
                switch ($key) {
                    case 'chiphi_giay':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Chi phí giấy</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input disabled type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'chiphi_giacong':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Chi phí gia công</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'chiphi_giaohang':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Chi phí giao hàng</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    case 'chiphi_inngoai':
                        $data['form-data'].='
                        <div class="form-group">
                            <div><b>Chi phí in ngoài</b></div>
                            <div class="input-group">
                                <div class="input-group-addon iga2">
                                    <span class="fa fa-pencil-square"></span>
                                </div>
                            <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                            </div>
                        </div>
                        ';
                        break;
                    default:
                        
                        break;
                }  
            }
        }
        echo json_encode($data['form-data']);
    }
}