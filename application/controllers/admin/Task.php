<?php 
class Task extends CI_Controller{

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
        $this->load->model('M_status');
        $this->load->helper('date');
        $this->load->helper('string');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
	function create_task(){
		$frm = $this->input->post();
		$task = array(
			'id_project'=>$frm['id_project'],
			'id_class'=>$frm['id_depart'],
			'id_user'=>$frm['id_user'],
			'status'=>'t001'
		);
		$project = [];
		switch ($frm['id_depart']) {
			case '4':
				$project['status'] = 'p400';
				break;
			case '3':
				$table = 'printer';
				$project['status'] = 'p300';
				break;
			default:
				$project['status'] = 'p001';
				break;
		}
		$record = array(
			'id_project'=>$task['id_project'],
			'id_user'=>$task['id_user'],
			'status!='=>'t004',
			'hidden'=>'0'
		);
		if($this->M_data->record_exists($record,'task')){
			$data['exists'] = "Dự án này đã được phân công";
		}else{
			if(isset($table)){
				switch ($table) {
					case 'printer':
						if(!$this->M_data->record_exists(array('id_project'=>$task['id_project']),'task')){
							$new_printer = array(
		                    'id_project'=>$task['id_project'],
			                );
							$this->M_printer->insert($new_printer);
						}
						break;
					default:
						# code...
						break;
				}
			}
			if($this->M_task->insert($task)!=0){
				$data['success'] = "Thành công";
				$this->M_project->update_row($frm['id_project'],$project);
				$status = $this->M_status->get_status_name($project["status"]);
				$data['status'] = $status[0]['name'];
			}else{
				$data['error'] = "Thất bại";
			}
		}
		echo json_encode($data);
	}
	function accept_task(){
		$id = $this->input->post('id');
		$group = $this->input->post('group');
		$match['task'] = array(
			'status'=>'t002',
			'get_at'=>date('Y-m-d H:i:s'),
		);
		$this->M_task->update($id,$match['task']);
		$task = $this->M_task->get_row($id);
		$project = [];
		switch ($group) {
			case '4':
				$project['status'] = 'p401';
				break;
			case '3':
				$match_printer = array(
					'id_project'=>$task[0]['id_project'],
				);
				$data_printer = array(
					'id_user'=>$this->session->userdata('user_id')
				);
				$this->M_printer->extra_update($match_printer,$data_printer,'printer');
				$project['status'] = 'p301';
				break;
			default:
				$project['status'] = '';
				break;
		}
		$status = $this->M_status->get_status_name('t002');
		$data['row'] = '<tr><td class="taskDesc"><i class="icon-info-sign"></i>'.$task[0]['id_project'].'</td><td id="task_status_'.$task[0]['id'].'" class="taskStatus"><span class="in-progress">'.$status[0]['name'].'</span></td><td class="taskOptions" id="task_option_'.$task[0]['id'].'"><a onclick="doneTask('.$task[0]['id'].',4)" class="tip-top"><i class="fa fa-check"></i></a> <a onclick="deleteTask('.$task[0]['id'].')" class="tip-top"><i class="fa fa-times"></i></a></td></tr>';
		$this->M_project->update_row($task[0]['id_project'],$project);
		echo json_encode($data);
	}
	function denied_task(){
		$id = $this->input->post('id');
		$group = $this->input->post('group');
		$match['task'] = array(
			'status'=>'t004',
		);
		$this->M_task->update($id,$match['task']);
		$task = $this->M_task->get_row($id);
		$project = [];
		switch ($group) {
			case '4':
				$project['status'] = 'p404';
				break;
			case '3':
				$project['status'] = 'p304';
				break;
			default:
				# code...
				break;
		}
		$status = $this->M_status->get_status_name('t004');
		$data['row'] = '<tr><td class="taskDesc"><i class="icon-info-sign"></i>'.$task[0]['id_project'].'</td><td class="taskStatus"><span class="in-progress">'.$status[0]['name'].'</span></td><td class="taskOptions"><a class="tip-top" data-original-title="Update"><i class="fa fa-check"></i></a> <a class="tip-top" data-original-title="Delete"><i class="fa fa-times"></i></a></td></tr>';
		$this->M_project->update_row($task[0]['id_project'],$project);
		$data['success']="Hủy task thành công!";
		echo json_encode($data);
	}

	function done_task(){
		$id = $this->input->post('id');
		$group = $this->input->post('group');
		$match['task'] = array(
			'status'=>'t003',
			'done_at'=>date('Y-m-d H:i:s'),
		);
		$this->M_task->update($id,$match['task']);
		$task = $this->M_task->get_row($id);
		$project = [];
		switch ($group) {
			case '4':
				$project['status'] = 'p402';
				break;
			case '3':
				$project['status'] = 'p302';
				$this->update_cost_print_for_project($task[0]['id_project']);
				break;
			default:
				# code...
				break;
		}
		$data['status_name'] = $this->M_status->get_status_name('t003');
		$this->M_project->update_row($task[0]['id_project'],$project);
		$data['success']="Thành công";
		echo json_encode($data);
	}

	function delete_task(){
		$id = $this->input->post('id');
		$match['task'] = array(
			'hidden'=>1,
		);
		$this->M_task->update($id,$match['task']);
		$data['success']="Hủy task thành công!";
		echo json_encode($data);
	}

	function get_progress_by_task(){
		$id = $this->input->post('id_project');
		$match = array(
			'task.id_project'=>$id,
			'task.status'=>'t003',
			'task.hidden'=>0
		);
		$list_task = $this->M_task->get_task_by_match($match);
		$check_list = [];
		$user_list = [];
		foreach ($list_task as $key => $value) {
			$check_list[$value['progress']] = $value['id']; 
			$user_list[$value['progress']][$value['id']]['username'] = $value['username'];
			$user_list[$value['progress']][$value['id']]['avatar'] = $value['avatar'];
			if($value['status']=='p405') $check_list['p405'] = 'Hoàn tất.';
		}
		$progress = $this->M_status->load_status_by_type('progress');
		$data['progress'] = '';
        foreach ($progress as $key => $value) {
        	if($value['id']=="pg001" ){
        		$checked = "checked";
        	}else $checked = "";
        	$data['progress'].= '
                          <div class="[ form-group ] disabled">
                              <input type="checkbox" name="fancy-checkbox-default" id="fancy-checkbox-default" '.(isset($check_list[$value['id']])?'checked=""':'').$checked.' disabled="" autocomplete="off"/>
                              <div class="[ btn-group ]" style="width: 100%">
                                  <label for="fancy-checkbox-default" class="[ btn btn-'.$value['class'].' ]">
                                      <span style="font-size:16px;" class="[ glyphicon glyphicon-lg glyphicon-ok-circle ]"></span>
                                      <span> </span>
                                  </label>
                                  <label for="fancy-checkbox-default" class="[ btn btn-default active ]" style="width: 70%">
                                      '.$value['name'].'
                                  </label>';
                                  if (isset($user_list[$value['id']])) {
                                  	foreach ($user_list[$value['id']] as $k => $v) {
                                  		$data['progress'].= '
                                  			<a onclick="viewUserTask('.$k.')"><img width="34" height="34" src="'.$v['avatar'].'" title="'.$v['avatar'].'" style="border-radius:3px;"></a>
                                  		';
                                  	}
                                  }
        $data['progress'].= '                      
                              </div>
                          </div>
            ';
        }
        if(isset($check_list['p405'])){
        	$data['progress'].= '
                          <div class="[ form-group ] disabled">
                              <input type="checkbox" name="fancy-checkbox-default" id="fancy-checkbox-default" checked="" disabled="" autocomplete="off"/>
                              <div class="[ btn-group ]" style="width: 100%">
                                  <label for="fancy-checkbox-default" class="[ btn btn-default ]">
                                      <span style="font-size:16px;" class="[ glyphicon glyphicon-ok-circle ]"></span>
                                      <span> </span>
                                  </label>
                                  <label for="fancy-checkbox-default" class="[ btn btn-default active ]" style="width: 70%">
                                      '.$check_list['p405'].'
                                  </label>
                              </div>
                          </div>
            ';
        }
        echo(json_encode($data));
	}
	function select_final_file(){
		$id = $this->input->post('id');
		$file_name = $this->input->post('file');
      	$file_req = array('file_thiet_ke'=>$file_name);
      	$this->M_project->update_row($id,$file_req);
      	$data['success'] = "Thành công!!";
      	echo(json_encode($data));
	}

	function update_cost_print_for_project($id_project){
		$match['project'] = array(
			'project.id'=>$id_project,
			'project.hidden'=>0
		);
		$match['printer'] = array(
			'printer.id_project'=>$id_project,
			'printer.hidden'=>0
		);
		$project = $this->M_project->get_row($match['project']);
		if($project[0]['thongtin_chiphi']){
			$list_cost = json_decode($project[0]['thongtin_chiphi'],true);
			if (isset($list_cost['chiphi_giay'])) {
				$printer = $this->M_printer->get_row($match['printer']);
				$list_cost['chiphi_giay'] = $printer[0]['cost_print'];
			}
		}
		$new_data['project'] = array(
			'thongtin_chiphi'=>json_encode($list_cost)
		);
		$this->M_data->update($match['project'],$new_data['project'],'project');
	}

	function view_user_task(){
		$id_user = $this->input->post('id_user');
		$match['task'] = array(
			'task.hidden'=>0,
			'task.id_user'=>$id_user
		);
		$list_task = $this->M_task->get_task_for_user($match['task']);
		$data['list_task'] = '';
		$data['list_task'].= '
		<div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="fa fa-clock-o"></i></span>
            <h5>Nhân viên: '.$list_task[0]['username'].' - Phòng: '.$list_task[0]['depart_name'].'</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Task</th>
                  <th>Ngày nhận</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
        ';
		foreach ($list_task as $key => $value) {
			$data['list_task'].= '
				<tr>
                  <td class="taskDesc"><i class="icon-info-sign"></i>'.$value['id_project'].'</td>
                  <td class="taskStatus"><span class="in-progress">'.$value['get_at'].'</span></td>
                  <td class="taskStatus"><span class="in-progress">'.$value['status_name'].'</span></td>
                </tr>
			';
		}
                
        $data['list_task'].= '
              </tbody>
            </table>
          </div>
        </div>
        ';
        echo json_encode($data);
	}
}