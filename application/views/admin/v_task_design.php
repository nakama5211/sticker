
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
                <button class="btn btn-success btn-lg" id="dropbtn" title="Lọc dự án"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i><span class="badge badge-notify" style="margin-top: -20px; margin-right: -15px; margin-left: -8px; background: red; color: white;"><?php echo isset($newtask)?count($newtask):'0'?></span></button>
                  <div class="dropdown-content" style="width: 97%; border-radius:10px;">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>admin/admin/filterProject">
                      <input type="hidden" id="statusDrop" value="0">
                      <br>
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
                    </form>
                  </div>
                  <div id="external_filter_container_wrapper input-group" style="margin-bottom: 30px;">
                  <label style="margin-top: 5px; margin-left: 36%">Lọc trạng thái:</label>
                  <div id="external_filter_container" style="float: right; margin-right: 37%;"></div>
                </div>
                  <hr>
                <table class="stripe row-border order-column" cellspacing="0" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th></th>
                      <th class="col-data-table-0-7">Mã dự án</th>
                      <th class="col-data-table-1-2">File thiết kế</th>
                      <th class="col-data-table-1-1">Ngày nhận task</th>
                      <th class="col-data-table-0-9">Ngày hoàn thành</th>
                      <!-- <th class="col-data-table-1-8">Hạng mục công việc</th> -->
                      <th class="col-data-table-1-2">Trạng thái task</th>
                      <th class="col-data-table-0-7">Dự án</th>
                      
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
                      
                      <td><?php echo "<a rel = 'prettyPhoto' href = '".$row['file_thiet_ke']."'><img style='height: 50px; width: 50px;'src='".$row['file_thiet_ke']."'></a>"?></td>
                      <td><?php echo $row['get_at'];?></td>
                      <td><?php echo $row['done_at']?></td>
                      
                      <td id="status_<?php echo $row['id']?>"><?php echo $row['status_name']?></td>
                      <td><?php echo $row['project_name']?></td>
                      
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
                         <button class="btn btn-danger btn-lg" style="border-radius: 10px;" onclick="openModalSelectFile('<?php echo $row['id'] ?>')">Chốt file
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
     <div class="modal fade" id="select-file-modal">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" style="font-size: 20px; padding: 12px;"><b>Chọn file thiết kế:</b></h4>
              </div>
              <form method="post" id="file-select-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                      <div class="form-group">
                       <div><b>Nhập link file</b></div>
                       <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-folder-open"></span>
                          </div>
                          <input type="text" class="form-control" name="file">
                       </div>
                       <div class="help-block" id="error-select-file"></div>
                    </div>
                    </div>
                 </div>
                 <input type="hidden" name="id" id="cur-id-select-file">
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" id="btn-select-file" onclick="confirmSelectFile()"> Save <span class="glyphicon glyphicon-saved"></span></button>

                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
                 </div>
              </div>
              </form>
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
          window.location.reload();
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
         window.location.reload();
        }
      }
    });
  }
function openModalSelectFile(id){
  $('#cur-id-select-file').val(id);
  $('#select-file-modal').modal('show');
}
function confirmSelectFile() {
  var route = '<?=base_url()?>admin/task/select_final_file/';
  var frm = new FormData($('form#file-select-form')[0]);
  if(frm.get('file')==''){
    $('#error-select-file').html('Vui lòng điền vào trường này.');
  }else{
    $.ajax({
      url:route,
      processData: false, 
      contentType: false,
      type:'post',
      dataType:'json',
      data:frm,
      success:function(data){
        if(data){
          window.location.reload();
        }
      }
    });
  }
}
$(document).ready(function(){
  $('#dropbtn').click(function(event) {
    var status = $('#statusDrop').val();
    if (status == 0) {
      $('.dropdown-content').show();
      $('#statusDrop').val(1);
    }else{
      $('.dropdown-content').hide();
      $('#statusDrop').val(0);
    }
  });
});
</script>