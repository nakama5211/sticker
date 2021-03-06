<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
  else{
                ?>
<div class="content-wrapper">
        <h3 style="margin-top: -15px; margin-bottom: 10px;">Quản lý doanh thu</h3>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body ">
                <div class="col-md-11">
                  <button class="btn btn-success btn-sm" id="dropbtn" title="Lọc doanh thu"><i class="fa fa-filter" aria-hidden="true"></i></button>
                  <div class="dropdown-content">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>admin/admin/filterRevenue">
                      <input type="hidden" id="statusDrop" value="0">
                      <br>
                       <div class="form-group ">
                        <label class="col-sm-4 control-label">Loại dự án</label>
                        <div class="col-sm-7">
                          <select class="form-control" name="typeProject" required="">
                            <option selected value="0">Tất cả</option>
                            <?php
                            if(!$typeproject) echo "<option value='0'>Empty</option>";
                            else{
                              foreach ($typeproject as $typePro) {
                                echo "<option value=".$typePro['id'].">".$typePro['name']."</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Tình trạng</label>
                        <div class="col-sm-7">
                          <select class="form-control" name="status" required="">
                            <option selected value="0">Tất cả</option>
                            <?php
                            if(!$status) echo "<option value='0'>Empty</option>";
                            else{
                              foreach ($status as $stt) {
                                echo "<option value=".$stt['id'].">".$stt['name']."</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Từ ngày</label>
                        <div class="col-sm-7">
                          <input type="date" class="form-control" name="start" required="" id="date-from-picker" value="">
                        </div>
                      </div>
                      <div class="form-group ">
                        <label class="col-sm-4 control-label">Đến ngày</label>
                        <div class="col-sm-7">
                          <input type="date" class="form-control" name="end" required="" id="date-to-picker" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div style="margin-left: 35%;">
                          <button type="submit" class="btn btn-success">Lọc</button> 
                          <a class="btn btn-info" href="<?php echo base_url() ?>admin/admin/view_admin/revenue">Tất cả</a> 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                  
                  <div>
                    <a class="btn btn-primary btn-sm glyphicon glyphicon-plus" href="<?php echo base_url() ?>admin/admin/pageNewProject" title="Thêm dự án mới"></a>
                  </div>
                  
              </div>
            </div>
          </div>  
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class="stripe row-border order-column" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th class="col-data-table-0-1"></th>
                      <th class="col-data-table-0-9">Mã đơn hàng</th>
                      <th class="col-data-table-0-9">Khách hàng</th>
                      <th class="col-data-table-0-9">Doanh thu (VNĐ)</th>
                      <th class="col-data-table-0-9">Chi phí (VNĐ)</th>
                      <th class="col-data-table-0-9">Ngày tạo</th>
                      <th class="col-data-table-1-1">Tên dự án</th>
                      <th class="col-data-table-0-7">Tạm ứng</th>
                      <th class="col-data-table-1-5">Thời gian tạm ứng</th>
                      <th class="col-data-table-1-7">Doanh thu thiết kế</th>
                      <th class="col-data-table-0-9">Chi phí giấy</th>
                      <th class="col-data-table-0-9">Chi phí in</th>
                      <th class="col-data-table-1-2">Chi phí gia công</th>
                      <th class="col-data-table-1-2">Chi phí giao hàng</th>
                      <th class="col-data-table-0-7">Lợi nhuận</th>
                      <th class="col-data-table-1-2">Tỉ suất lợi nhuận</th>
                      <th class="col-data-table-1-5">Tình trạng đơn hàng</th>
                      <th class="col-data-table-1-4">Tình trạng thu tiền</th>
                      <th class="col-data-table-1-4">Phiếu thu/ Hóa đơn</th>
                      <th class="col-data-table-1-6">Thời gian hoàn thành</th>
                      <th class="col-data-table-0-7">Ghi chú</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-1-9"></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-0-7"></th>
                      <th class="col-data-table-1-5"></th>
                      <th class="col-data-table-1-7"></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-0-9"></th>
                      <th class="col-data-table-1-2"></th>
                      <th class="col-data-table-1-2"></th>
                      <th class="col-data-table-0-7"></th>
                      <th class="col-data-table-1-2"></th>
                      <th class="col-data-table-1-5"></th>
                      <th class="col-data-table-1-4"></th>
                      <th class="col-data-table-1-4"></th>
                      <th class="col-data-table-1-6"></th>
                      <th class="col-data-table-0-7"></th>
                      <th class="col-data-table-1-8"></th>
                    </tr>
                  </tfoot>
                  <tbody>
                  	<?php if(isset($revenue)){ foreach ($revenue as $row) {
                  	?>
                  	<tr>
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['name']?></td>
                      <td><?php echo number_format($row['tong_doanhthu'])?></td>
                      <td><?php echo number_format($row['tong_chiphi'])?></td>
                      <td><?php echo $row['created_at']?></td>
                      <td><?php echo $row['project_name']?></td>
                      <td><?php echo number_format($row['tam_ung']).' vnđ'?></td>
                      <td><?php echo isset($row['ngay_tam_ung']) ? $row['ngay_tam_ung'] : '';?></td>
                      <td><?php echo isset($row['doanhthu_thietke']) ? number_format($row['doanhthu_thietke']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_giay']) ? number_format($row['chiphi_giay']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_inngoai']) ? number_format($row['chiphi_inngoai']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_giacong']) ? number_format($row['chiphi_giacong']).' vnđ' : '';?></td>
                      <td><?php echo isset($row['chiphi_giaohang']) ? number_format($row['chiphi_giaohang']).' vnđ' : '';?></td>
                      <td><?php echo number_format($row['tong_doanhthu']-$row['tong_chiphi']).' vnđ';?></td>
                      <td><?php echo number_format(($row['tong_doanhthu']-$row['tong_chiphi'])/$row['tong_doanhthu']*100).' %';?></td>
                      <td><?php echo isset($row['status_don_hang']) ? $row['status_don_hang'] : '';?></td>
                      <td><?php echo isset($row['status_thu_tien']) ? $row['status_thu_tien'] : '';?></td>
                      <td><?php echo isset($row['phieu_thu']) ? $row['phieu_thu'] : '';?></td>
                      <td><?php echo isset($row['ngay_hoan_thanh_don_hang']) ? $row['ngay_hoan_thanh_don_hang'] : '';?></td>
                      <td><?php echo isset($row['note']) ? $row['note'] : '';?></td>
                      <td>
                        <button class="btn btn-primary btn-sm" style="border-radius: 10px;" onclick="updateRevenue('<?php echo $row['id']?>')">Cập nhật doanh thu</button> 
                        <button class="btn btn-success btn-sm" style="border-radius: 10px;" onclick="updateCost('<?php echo $row['id']?>')">Cập nhật chi phí</button>
                  	  </td>
                    </tr>
                  	<?php
                  	}} ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="modal fade" id="update-revenue">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Cập nhật doanh thu: </h4>
        </div>
        <form method="post" id="revenue-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-update-revenue">
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="subUpdateRevenue()"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="update-cost">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Cập nhật doanh thu: </h4>
        </div>
        <form method="post" id="cost-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-update-cost">
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="subUpdateCost()"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
<script type="text/javascript">
function updateRevenue(id){
  $.ajax({
    url:'<?=base_url()?>admin/revenue/load_data_update_revenue/',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#form-update-revenue').html(data);
      $('#update-revenue').modal('show');
    }
  });
}
function updateCost(id){
  $.ajax({
    url:'<?=base_url()?>admin/revenue/load_data_update_cost/',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#form-update-cost').html(data);
      $('#update-cost').modal('show');
    }
  });
}
function subUpdateRevenue(){
  var route = '<?=base_url()?>admin/revenue/update_data_revenue/';
  var frm = new FormData($('form#revenue-form')[0]);
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.success){
        window.location.reload();
      }
    }
  });
}
function subUpdateCost(){
  var route = '<?=base_url()?>admin/revenue/update_data_cost/';
  var frm = new FormData($('form#cost-form')[0]);
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.success){
        window.location.reload();
      }
    }
  });
}
$(document).ready(function() {
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
   var date = new Date(), y = date.getFullYear(), m = date.getMonth();
var fd = new Date(y, m, 2);
var ld = new Date(y, m + 1, 1);
  document.querySelector("#date-from-picker").valueAsDate = fd;
  document.querySelector("#date-to-picker").valueAsDate = ld;
});

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
          window.location.reload();
        }
      }
    });
  }
</script>