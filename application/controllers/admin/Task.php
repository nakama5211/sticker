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
			'status'=>'t001',
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
		if(isset($table) && $this->M_data->record_exists($task['id_project'],'id_project',$table) && !$this->M_data->null_key(array('id_project'=>$task['id_project']),'id_user',$table)){
			$data['exists'] = "Dự án này đã được phân công in";
		}else{
			if(isset($table)){
				switch ($table) {
					case 'printer':
						if(!$this->M_data->record_exists($task['id_project'],'id_project',$table)){
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
				$this->M_printer->extra_update($match_printer,$data_printer);
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
		foreach ($list_task as $key => $value) {
			$check_list[$value['progress']] = $value['username']; 
			if($value['status']=='p405') $check_list['p405'] = 'Hoàn tất.';
		}
		$progress = $this->M_status->load_status_by_type('progress');
		$data['progress'] = '';
        foreach ($progress as $key => $value) {
        	$data['progress'].= '
                          <div class="[ form-group ] disabled">
                              <input type="checkbox" name="fancy-checkbox-default" id="fancy-checkbox-default" '.(isset($check_list[$value['id']])?'checked=""':'').' disabled="" autocomplete="off"/>
                              <div class="[ btn-group ]" style="width: 100%">
                                  <label for="fancy-checkbox-default" class="[ btn btn-'.$value['class'].' ]">
                                      <span class="[ glyphicon glyphicon-ok ]"></span>
                                      <span> </span>
                                  </label>
                                  <label for="fancy-checkbox-default" class="[ btn btn-default active ]" style="width: 80%">
                                      '.$value['name'].' ('.(isset($check_list[$value['id']])?$check_list[$value['id']]:'').')
                                  </label>
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
                                      <span class="[ glyphicon glyphicon-ok ]"></span>
                                      <span> </span>
                                  </label>
                                  <label for="fancy-checkbox-default" class="[ btn btn-default active ]" style="width: 80%">
                                      '.$check_list['p405'].'
                                  </label>
                              </div>
                          </div>
            ';
        }
        echo(json_encode($data));
	}
}