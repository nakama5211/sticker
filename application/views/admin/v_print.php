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
          <!-- <div><a class="btn btn-primary btn-flat" href="#"><i class="fa fa-lg fa-plus"></i></a><a class="btn btn-info btn-flat" href="#"><i class="fa fa-lg fa-refresh"></i></a><a class="btn btn-warning btn-flat" href="#"><i class="fa fa-lg fa-trash"></i></a></div> -->
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class="stripe row-border order-column" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th></th>
                      <th class="col-data-table-0-6">Ngày</th>
                      <th class="col-data-table-0-7">Mã bài in</th>
                      <th class="col-data-table-0-8">Máy in</th>
                      <th class="col-data-table-1">NV in</th>
                      <th class="col-data-table-1-9">Khách hàng</th>
                      <th class="col-data-table-0-8">Mô tả</th>
                      <th class="col-data-table-0-7">Số lượng</th>
                      <th class="col-data-table-0-9">Giấy in</th>
                      <th class="col-data-table-0-7">Khổ giấy</th>
                      <th class="col-data-table-0-8">Số mặt in</th>
                      <th class="col-data-table-0-8">Số tờ in</th>
                      <th class="col-data-table-0-8">Gia công</th>
                      <th class="col-data-table-0-8">Ghi chú</th>
                      <th class="col-data-table-0-8">Số tờ test</th>
                      <th class="col-data-table-1">Số tờ in hư</th>
                      <th class="col-data-table-1-2">Số tờ kẹt giấy</th>
                      <th class="col-data-table-1-4">Số tờ hư - in lại</th>
                      <th class="col-data-table-1-3">Tổng số trang in</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($print as $row) {
                  	?>
                  	<tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td id="created_at<?php echo $row['id']?>"><?php echo $row['created_at']?></td>
                      <td><?php echo $row['id_project']?></td>
                      <td id="name<?php echo $row['id']?>"><?php echo $row['name']?></td>
                      <td><?php echo isset($row['username'])?$row['username']:'';?></td>
                      <td><?php echo isset($row['customer'])?$row['customer']:'';?></td>
                      <td><?php echo isset($row['note'])?$row['note']:''?></td>
                      <td><?php echo number_format($row['tong_so_giay_in_su_dung'])?> (tờ)</td>
                      <td><?php echo $row['material_name']?></td>
                      <td><?php echo isset($row['big_size'])?$row['big_size']:'';?></td>
                      <td><?php echo $row['num_face']?></td>
                      <td><?php echo number_format($row['num_print'])?> (tờ)</td>
                      <td><?php echo $row['giacong_name']?></td>
                      <td><?php echo $row['note']?></td>
                      <td><?php echo $row['num_test']?> (tờ)</td>
                      <td><?php echo $row['num_bad']?> (tờ)</td>
                      <td><?php echo $row['num_jam']?> (tờ)</td>
                      <td><?php echo $row['num_reprint']?> (tờ)</td>
                      <td><?php echo number_format($row['tong_so_giay_in_su_dung']*$row['num_face'])?> (trang)</td>
                      <td>
                        <button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('<?php echo $row['id_project'] ?>')">
                        </button>
                  	  </td>
                    </tr>
                  	<?php
                  	} ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Chỉnh sửa thông tin: </h4>
        </div>
        <form method="post" id="edit-form">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-data-edit">
                 </div>
              </div>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="select-paper-modal">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" style="font-size: 20px; padding: 12px;"><b>Cập nhật loại giấy:</b></h4>
              </div>
              <form method="post" id="paper-select-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12" id="form-select-more-paper">
                       </div>
                    </div>
                 </div>
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" onclick="ConfirmPaper()"> Ok <span class="glyphicon glyphicon-saved"></span></button>

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
function editRow(id){
  $.ajax({
    url:'<?=base_url()?>admin/printer/load_data_for_edit_form/',
    type:'post',
    dataType:'json',
    data:{
      id_project:id
    },
    success:function(data){
      $('#form-data-edit').html(data);
      $('#edit-modal').modal('show');
    }
  });
}
function ConfirmPaper(){
  var frm = new FormData($('form#paper-select-form')[0]);
  if(frm.get('id_paper')!=null){
    var route = '<?=base_url()?>admin/printer/confirm_edit_paper';
  }else{
    var route = '<?=base_url()?>admin/printer/confirm_add_paper';
  }
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
      if(data.error){
        ssi_modal.notify('error', {content: data.error});
      }
    }
  });
}
function selectPaper(id){
  $.ajax({
    url:'<?=base_url()?>admin/printer/load_more_paper',
    type:'post',
    dataType:'json',
    data:{
      id_printer:id,
    },
    success:function(data){
      $('#form-select-more-paper').html(data);
      $('#select-paper-modal').modal('show');
    }
  });
}

function editPaper(id,id_printer){
  $.ajax({
    url:'<?=base_url()?>admin/printer/edit_paper',
    type:'post',
    dataType:'json',
    data:{
      id_paper:id,
      id_printer:id_printer
    },
    success:function(data){
      $('#form-select-more-paper').html(data);
      $('#select-paper-modal').modal('show');
    }
  });
}
function delPaper(id,id_printer){
  $.ajax({
    url:'<?=base_url()?>admin/printer/delete_paper',
    type:'post',
    dataType:'json',
    data:{
      id_paper:id,
      id_printer:id_printer
    },
    success:function(data){
      window.location.reload();
    }
  });
}
</script>