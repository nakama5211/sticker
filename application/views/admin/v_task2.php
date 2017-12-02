
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
else{
                ?> 
<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1>Data Table</h1>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Tables</li>
              <li class="active"><a href="#">Data Table</a></li>
            </ul>
          </div>
        </div>
        <?php if($ms=$this->session->userdata('success')){ ?>
          <div class="alert alert-success" id="scs-msg" >
          <strong><?php echo $ms; $this->session->unset_userdata('success');?></strong>
          </div>
          <script type="text/javascript">
          $(document).ready(function() {
            $('#scs-msg').fadeOut(2000); // 5 seconds x 1000 milisec = 5000 milisec
          });
          </script>
        <?php } ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <!--main-container-part-->
                <div id="content">
                  <div class="container-fluid">
                    <div class="row-fluid">
                      <div class="span6 col-sm-6">
                        <div class="widget-box">
                          <div class="widget-title"> <span class="icon"> <i class="fa fa-file-o"></i> </span>
                            <h5>Thông báo gần đây</h5>
                          </div>
                          <div class="widget-content nopadding">
                            <ul class="recent-posts" id="new-notif">
                              <?php 
                                if (!isset($newtask)) {
                                  echo('<li>không có thông báo nào mới!</li>');
                                }else{
                                foreach ($newtask as $key => $value) { ?>
                              <li id="notif_<?php echo $value['id']?>">
                                <div class="user-thumb"> <img width="40" height="40" alt="User" src="<?php echo base_url().'upload/'.$value['file']?>"> </div>
                                <div class="article-post">
                                  <div class="fr"><a href="#" class="btn btn-success btn-sm" onclick="acceptNotif('<?php echo $value['id'] ?>','<?php echo($this->session->userdata('group'))?>')">Chấp nhận</a> <a href="#" class="btn btn-danger btn-sm" onclick="deniedNotif('<?php echo $value['id'] ?>','<?php echo($this->session->userdata('group'))?>')">Từ chối</a></div>
                                  <span class="user-info"> Dự án: <?php echo $value['id_project']?> / Ngày: <?php echo date_format(date_create($value['created_at']),'Y-m-d');?> / Lúc: <?php echo date_format(date_create($value['created_at']),'H:i:s');?> </span>
                                  <p><a href="#">Nhân viên phòng in ấn nhận được thông báo này phải nhấn 'Chấp nhận' để tham gia vào dự án.</a> </p>
                                </div>
                              </li>
                              <?php }} ?>
                              <li>
                                <button class="btn btn-warning btn-sm">Xem thêm</button>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="span6 col-sm-6">
                        <div class="widget-box">
                          <div class="widget-title"> <span class="icon"><i class="fa fa-clock-o"></i></span>
                            <h5>Danh sách công việc</h5>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-striped table-bordered" id="list-todo">
                              <thead>
                                <tr>
                                  <th>Task</th>
                                  <th>Trạng thái</th>
                                  <th>Opts</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                if (!isset($oldtask)) {
                                  echo('<li>trống!</li>');
                                }else{
                                foreach ($oldtask as $key => $value) { ?>
                                <tr id="task_<?php echo $value['id']?>">
                                  <td class="taskDesc"><i class="icon-info-sign"></i><?php echo $value['id_project']?></td>
                                  <td class="taskStatus" id="task_status_<?php echo $value['id']?>">
                                    <span class="in-progress">
                                      <?php echo($value['status_name'])?>  
                                    </span>
                                  </td>
                                  <td class="taskOptions" id="task_option_<?php echo $value['id']?>">
                                    <?php switch ($value['status']) {
                                      case 't002':
                                        ?>
                                          <a onclick="doneTask('<?php echo $value['id']?>','<?php echo($this->session->userdata('group'))?>')" class="tip-top"><i class="fa fa-check"></i></a> 
                                          <a onclick="deleteTask('<?php echo $value['id']?>')" class="tip-top"><i class="fa fa-times"></i></a>
                                        <?php
                                        break;
                                      default:
                                        echo '';
                                        break;
                                    } ?>
                                  </td>
                                </tr>
                                <?php }}?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                  </div>
                </div>
                <!--main-container-part-->
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class="stripe row-border order-column" cellspacing="0" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th></th>
                      <th class="col-data-table-0-7">Mã dự án</th>
                      <th class="col-data-table-0-7">Dự án</th>
                      <th class="col-data-table-1-2">File thiết kế</th>
                      <th class="col-data-table-1-1">Ngày nhận task</th>
                      <th class="col-data-table-0-9">Ngày hoàn thành</th>
                      <!-- <th class="col-data-table-1-8">Hạng mục công việc</th> -->
                      <th class="col-data-table-1-2">Trạng thái task</th>
                      
                      <!-- <th class="col-data-table-1-2">File đính kèm</th> -->
                      <!-- <th class="col-data-table-1-2">Người liên hệ</th> -->
                      <th class="col-data-table-1-4">Thời hạn giao hàng</th>
                      <th class="col-data-table-1">Doanh thu</th>
                      <th class="col-data-table-1-2">Chi phí</th>
                      <th class="col-data-table-1">Số lượng</th>
                      <th class="col-data-table-0-5">Đơn vị</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($project as $row) {
                      $donhang = json_decode($row['thongtin_donhang'],true);
                      // var_dump($donhang['quantity']);
                    ?>
                    <tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['project_name']?></td>
                      <td><?php echo "<a rel = 'prettyPhoto' href = '".base_url()."upload/".$row['file_thiet_ke']."'><img style='height: 50px; width: 50px;'src='".base_url()."upload/".$row['file_thiet_ke']."'></a>"?></td>
                      <td><?php echo $row['get_at'];?></td>
                      <td><?php echo $row['done_at']?></td>
                      
                      <td id="status_<?php echo $row['id']?>"><?php echo $row['status_name']?></td>
                      
                      
                      <td><?php echo $row['dead_line']?></td>
                      <td><?php echo number_format($row['tong_doanhthu'])." ₫"?></td>
                      <td><?php echo number_format($row['tong_chiphi'])." ₫"?></td>
                      <td><?php echo number_format($donhang['quantity'])?></td>
                      <td><?php echo $donhang['unit']?></td>
                      <?php 
                      if($row['status'] != 'p405' && $this->session->userdata('group')==1){ 
                      ?>
                      <td id="button_<?php echo $row['id']?>">
                        <button class="btn btn-success btn-lg" style="border-radius: 10px;" onclick="onCreateTask('<?php echo $row['id'] ?>')">Phân công việc
                        </button> 
                        <button class="btn btn-primary btn-lg" style="border-radius: 10px;" onclick="editRow('<?php echo $row['id'] ?>')">Quy cách in
                        </button>
                        <a class="btn btn-info btn-lg" style="border-radius: 10px;" href="<?php echo base_url().'editProject/'.$row['id'] ?>">Chỉnh sửa dự án
                        </a>
                        <button class="btn btn-success btn-lg" style="border-radius: 10px;" onclick="updateStatus('<?php echo $row['id'] ?>')">Hoàn tất
                        </button>
                        <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="viewProgress('<?php echo $row['id'] ?>')">Xem tiến độ
                        </button>
                      </td>
                    <?php }elseif($this->session->userdata('group')==1){ echo ''; ?>
                      <td>
                         <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="viewProgress('<?php echo $row['id'] ?>')">Xem tiến độ
                        </button>
                      </td>
                    </tr>
                    <?php
                    }else{ ?>

                    <td>
                         <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="selectFile('<?php echo $row['id'] ?>')">Chốt file
                        </button>
                      </td>
                      <?php 
                    }


                  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php } ?>
<script type="text/javascript">
  function acceptNotif(id,group){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/accept_task",
      data: {
        'id': id,
        'group': group,
      },
      dataType: 'json',
      success: function(data){
        if(data){
          ssi_modal.notify('success', {content: 'Thành công!!'});
          $('#notif_'+id).hide();
          $('#list-todo').append(data.row);
        }
      }
    });
  }
  function deniedNotif(id,group){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/denied_task",
      data: {
        'id': id,
        'group': group,
      },
      dataType: 'json',
      success: function(data){
        if(data){
          ssi_modal.notify('success', {content: data.success});
          $('#notif_'+id).hide();
          $('#list-todo').append(data.row);
          $('#task_option_'+id).html('');
        }
      }
    });
  }
  function doneTask(id,group){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/done_task",
      data: {
        'id': id,
        'group': group,
      },
      dataType: 'json',
      success: function(data){
        if(data){
          console.log(data.status_name[0]['name']);
          $('#task_status_'+id).html('<span class="in-progress">'+data.status_name[0]['name']+'</span>');
          $('#task_option_'+id).html('');
          ssi_modal.notify('success', {content: data.success});
        }
      }
    });
  }
  function deleteTask(id){
    $.ajax({
      type:'post',
      url:"<?php echo base_url(); ?>admin/task/delete_task",
      data: {
        'id': id},
      dataType: 'json',
      success: function(data){
        if(data){
          $('#task_'+id).remove();
          ssi_modal.notify('success', {content: data.success});
        }
      }
    });
  }
</script>