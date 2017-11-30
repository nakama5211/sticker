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
	function load_data_for_business_edit_form(){
        $match = array('hidden'=>0);
        $id = $this->input->post('id');
        $revenue = $this->M_revenue->get_row_for_business($id);
        $data['form-data'] = '';
        $data['form-data'].= '<input type="hidden" name="id" value="'.$id.'">';
        $data['form-data'].= '<input type="hidden" name="id_project" value="'.$revenue[0]['id_project'].'">';
        foreach ($revenue[0] as $key => $value) {
            switch ($key) {
                case 'revenue_design':
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
                case 'revenue_outsourcing':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Doanh thu gia công</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'revenue_molding':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Doanh thu lên khuôn</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'revenue_profit':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Lợi nhuận</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'cost_print':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Chi phí in</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'cost_delivery':
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
                case 'cost_outsourcing':
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
                case 'cost_paper':
                    $data['form-data'].='
                    <div class="form-group">
                        <div><b>Chi phí giấy</b></div>
                        <div class="input-group">
                            <div class="input-group-addon iga2">
                                <span class="fa fa-pencil-square"></span>
                            </div>
                        <input type="text" class="form-control" name="'.$key.'" value="'.$value.'">
                        </div>
                    </div>
                    ';
                    break;
                case 'note':
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
        $data['form-data'].= '
            <div class="form-group">
                <div class="help-block" id="error-quantity"></div>
            </div>
        ';
        echo json_encode($data['form-data']);
    }

    function update_data_business(){
        $frm = $this->input->post();
        $id = $frm['id'];
        $id_project = $frm['id_project'];
        $data = [];
        unset($frm['id'],$frm['id_project']);
        $revenue = array(
            'design'=>$frm['revenue_design'],
        );
        $cost = array(
            'paper'=>$frm['cost_paper'],
            'print'=>$frm['cost_print'],
            'delivery'=>$frm['cost_delivery'],
            'outsourcing'=>$frm['cost_outsourcing']
        );
        $match_cost = array('id_project'=>$id_project);
        $this->M_cost->extra_update($match_cost,$cost);
        $this->M_revenue->update($id,$revenue);
        $data['response'] = $this->M_revenue->get_row_for_business($id);
        unset(
            $data['response'][0]['id'],
            $data['response'][0]['id_project']
        );
        echo json_encode($data);
    }
}