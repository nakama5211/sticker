
<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
  else{?> 
<div class="content-wrapper">
        <div class="page-title">
          <h3 style="">Quản lý đơn hàng</h3>
          <div>
          <?php 
            $btn = '';
            $btn.= isset($button['add']) ? '<a class="btn btn-sm btn-primary btn-primary" onclick="newRow()"><i class="fa fa-lg fa-plus"></i></a> ' : '';
            echo $btn;
          ?>
          </div>
          <!-- <div class="social-icons" id="s-icons">
              <ul class="navbar-nav">
                  <li><a href="#" class="btn btn-primary btn-social "><i class="fa fa-facebook-official fa-2x"></i></a></li>
                  <li><a href="#" class="btn btn-primary btn-social "><i class="fa fa-twitter-square fa-2x"></i></a></li>
                  <li><a href="#" class="btn btn-primary btn-social "><i class="fa fa-youtube-play fa-2x"></i></a></li>
              </ul>
            <button class="btn btn-primary btn-social" id="btn-share" data-toggle="tooltip" data-placement="left" title="Tooltip on left">
                <i class="fa fa-share-alt fa-2x"></i>
            </button>
          </div> -->
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
                <div id="external_filter_container_wrapper input-group" style="margin-bottom: 30px;">
                  <label style="margin-top: 5px; margin-left: 36%">Lọc trạng thái:</label>
                  <div id="external_filter_container" style="float: right; margin-right: 37%;"></div>
                </div>
                <hr>
                <table class="stripe row-border order-column" cellspacing="0" width="100%" id="sampleTable">
                  <thead>
                    <tr class="text-center">
                      <th class="col-data-table-0-1"></th>
                      <th class="col-data-table-0-2">ID</th>
                      <th class="col-data-table-2">Thông tin khách hàng</th>
                      <th class="col-data-table-1">File thiết kế</th>
                      <th class="col-data-table-1-7">Tên sản phẩm</th>
                      <th class="col-data-table-0-8">Trạng thái</th>
                      <th class="col-data-table-0-8">Ngày tạo</th>
                      <th class="col-data-table-0-9">Số lượng</th>
                      <th class="col-data-table-1-1">Đơn giá</th>
                      <th class="col-data-table-1-2">Thành tiền</th>
                      <th class="col-data-table-0-8">Kích thước</th>
                       <th class="col-data-table-1-2">Ghi chú</th>
                      <th class="col-data-table-1-8">Opt</th>
                    </tr>
                  </thead>
                  <!-- <tfoot>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>Đơn giá</td>
                      <td>Thành tiền</td>
                      <td>Kích thước</td>
                      <td>Ghi chú</td>
                      <td>Opt</td>
                    </tr>
                  </tfoot> -->
                  <tbody>
                  	<?php foreach ($bill as $row) {
                  	?>
                  	<tr id="row<?php echo $row['id']?>" 
                      <?php 
                      if($row['status']=='b001') echo "style='background-color:rgba(236,157,157,0.5);'";
                      if($row['status']=='b002') echo "style='background-color:rgba(134,127,127,0.5);'";
                      ?>
                    >
                      <td></td>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo "".$row['customer']."</br>".$row['email']."</br>".$row['phone']."</br>".$row['address']?></td>
                      <td id="file<?php echo $row['id']?>">
                        <?php echo "<a rel = 'prettyPhoto' href = '".base_url()."upload/".$row['file']."'><img style='height: 50px; width: 50px;'src='".base_url()."upload/".$row['file']."'></a>"?></td>
                      <td><?php echo $row['typedecal'].";</br>".$row['extrusion']?></td>
                      <td id="status_<?php echo $row['id']?>"><?php echo $row['status_name']?></td>
                      <td><?php echo $row['created_at']?></td>
                      <td><?php echo $row['quantity']."(".$row['unit_name'].")"?></td>
                      <td><?php echo number_format($row['typedecal_price']+$row['extrusion_price'])."₫"?></td>
                      <td><?php echo number_format(($row['typedecal_price']+$row['extrusion_price'])*$row['quantity'])."₫"?></td>
                      <td><?php echo $row['width']."x".$row['height']." mm"?></td>
                      <td><?php echo $row['note']?></td>
                      <td id="btn_group_<?php echo $row['id']?>">
                  		<?php 
                        switch ($row['status']) {
                          case 'b001':
                            $btn = '';
                            $btn.= isset($button['confirm']) ? '<button class="btn btn-success btn-sm" style="border-radius: 10px;" onclick="confirmBill('. $row['id'] .')">Xác nhận
                              </button> ' : '';
                            $btn.= isset($button['edit']) ? '<button class="btn btn-primary btn-sm" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')">Sửa
                              </button> ' : '';
                            $btn.= isset($button['delete']) ? '<button class="btn btn-warning btn-sm " style="border-radius: 10px;" onclick="cancelRow('. $row['id'] .')">Xóa
                              </button> ' : '';
                            echo $btn;
                            break;
                          case 'b002':
                            $btn = '';
                            $btn.= isset($button['create']) ? '<button class="btn btn-info btn-sm" style="border-radius: 10px;" onclick="checkRow('. $row['id'] .')">Tạo dự án
                              </button> ' : '';
                            $btn.= isset($button['edit']) ? '<button class="btn btn-primary btn-sm " style="border-radius: 10px;" onclick="editRow('. $row['id'] .')">Sửa
                              </button> ' : '';
                            $btn.= isset($button['delete']) ? '<button class="btn btn-warning btn-sm " style="border-radius: 10px;" onclick="cancelRow('. $row['id'] .')">Xóa
                              </button> ' : '';
                            echo $btn;
                            break;
                          case 'b003':
                            $btn = '';
                            $btn.= isset($button['edit']) ? '<button class="btn btn-primary btn-sm" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')">Sửa
                              </button> ' : '';
                            $btn.= isset($button['upfile']) ? '<button class="btn btn-danger btn-sm" style="border-radius: 10px;" onclick="selectFile('. $row['id'] .')">Chọn file
                              </button> ' : '';
                            echo $btn;
                            break;
                            break;
                          default:
                            # code...
                            break;
                         } 
                        ?>
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
    <div class="modal fade" id="create-project">
           <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" style="font-size: 20px; padding: 12px;"><b>Tạo dự án từ hóa đơn:</b></h4>
              </div>
              <form method="post" id="choose-form">
              <div class="modal-body">
                 <div class="container-fluid">
                    <div class="row">
                      <div class="form-group">
                       <div><b>Dự án</b></div>
                       <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-edit"></span>
                          </div>
                          <select required="" class="form-control" name="type_project">
                            <option value="" hidden="" disabled="" selected="">Chọn loại dự án</option>
                            <?php foreach ($typeproject as $key => $value) {
                              echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                            } ?>
                          </select>
                          <div class="help-block" id="error-select-type-project"></div>
                       </div>
                      <div><b>Hạng mục</b></div>
                      <div class="col-sm-12 form-group border-radius">
                        <?php foreach ($classproject as $key => $value) {?>
                        <div class="input-group">
                          <span class="input-group-addon beautiful">
                            <input type="checkbox" name="checked_list[]" value="<?php echo $value['id']?>">
                          </span>
                          <input type="text" value="<?php echo $value['name']?>" class="form-control">
                        </div>
                        <?php }?>
                      </div>
                      <div class="form-group">
                        <div><b>Người liên hệ</b></div>
                        <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-edit"></span>
                          </div>
                          <input class="form-control" type="text" name="contact_by" value="<?php echo $this->session->userdata('username');?>">
                        </div>
                      </div> 
                      <div class="form-group">
                        <div><b>Thời hạn giao hàng</b></div>
                        <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-edit"></span>
                          </div>
                          <input class="form-control" type="date" name="dead_line" value="<?php echo date("Y-m-d");?>">
                        </div>
                      </div> 
                    </div>
                 </div>
                 <input type="hidden" name="id" id="cur-id">
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" onclick="createProject()"> Save <span class="glyphicon glyphicon-saved"></span></button>

                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
                 </div>
              </div>
              </form>
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
                        <div><b>Chọn file thiết kế</b></div>
                          <div class="input-group">
                            <input type="text" class="form-control" name="" disabled="" id="f_in" value="">
                            <div class="input-group-addon iga2">
                               <label style="margin-bottom: 0px;" class="fa"><b>Browse...</b><input onchange="file_change(this,0);" type="file" id="f" name="file" style="display: none;"></label>
                            </div>
                          </div>
                          <img src="" width="100%" height="auto" id="img0" style="margin-top: 10px;  display: none;" />
                        <div class="help-block" id="error-select-file"></div>
                      </div>
                    </div>
                 </div>
                 <input type="hidden" name="id" id="cur-id-select-file">
              </div>
              <div class="modal-footer">
                 <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" onclick="confirmSelectFile()"> Save <span class="glyphicon glyphicon-saved"></span></button>

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
function checkRow(id){
  document.getElementById("cur-id").value = id;
  $('#error-select-type-project').html('');
  $('#create-project').modal('show');
}

function createProject(){
  var route = '<?=base_url()?>admin/admin/create_project/';
  var frm = new FormData($('form#choose-form')[0]);
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    dataType:'json',
    data:frm,
    success:function(data){
      if(data.error){
        ssi_modal.notify('error', {content: data.error});
      }else{
        $('#create-project').modal('hide');
        var table = $('#sampleTable').DataTable();
        table.cell($('#status_'+frm.get('id'))).data(data.status).draw();
        table.cell($('#btn_group_'+frm.get('id'))).data(data.button).draw();
        ssi_modal.notify('success', {content: data.success});
      }
    }
  });
}
function cancelRow(id)
{
  ssi_modal.confirm({
    content: 'Bạn có chắc muốn hủy đơn hàng này?',
    okBtn: {
    className:'btn btn-primary'
    },
    cancelBtn:{
    className:'btn btn-danger'
    }
    },function (result) {
      if(result){
        var route="<?= base_url()?>admin/admin/cancel_bill/";
        $.ajax({
          url:route,
          type:'post',
          data:{
            id:id,
          },
          success:function() {  
            $('#row'+id).hide();
            ssi_modal.notify('success', {content: 'Thành công!!'});
          }
        }); 
      }else ssi_modal.notify('error', {content: 'Thất bại: ' + result});
    }
  );
}
function confirmBill(id)
{
  ssi_modal.confirm({
    content: 'Bạn có chắc muốn xác nhận đơn hàng này?',
    okBtn: {
    className:'btn btn-primary'
    },
    cancelBtn:{
    className:'btn btn-danger'
    }
    },function (result) {
      if(result){
        var route="<?= base_url()?>admin/admin/change_status/";
        $.ajax({
          url:route,
          type:'post',
          dataType:'json',
          data:{
            id:id,
            status:'b002',
          },
          success:function(data) {  
            var table = $('#sampleTable').DataTable();
            table.cell($('#status_'+id)).data(data.status).draw();
            table.cell($('#btn_group_'+id)).data(data.button).draw();
            ssi_modal.notify('success', {content: "Thành công!"});
          }
        }); 
      }else ssi_modal.notify('error', {content: 'Thất bại: ' + result});
    }
  );
}
function editRow(id)
{
  var  route="<?= base_url()?>admin/admin/edit_bill/id";
  route=route.replace('id',id);
  window.location.replace(route);
}
function newRow()
{
  var  route="<?= base_url()?>admin/admin/add_bill/";
  window.location.replace(route);
}

function selectFile(id) {
  document.getElementById("cur-id-select-file").value = id;
  $('#error-select-file').html('');
  $('#select-file-modal').modal('show');
}

function file_change(f,i){
  var reader = new FileReader();
  reader.onload = function (e) {
    $("#img0").show();
    var img = document.getElementById("img"+i);
    img.src = e.target.result;
    img.style.display = "block-inline";
  };
  var ftype =f.files[0].type;
  switch(ftype)
  {
    case 'image/png':
    case 'image/gif':
    case 'image/jpeg':
    case 'image/pjpeg':
      reader.readAsDataURL(f.files[0]);
      $('#f_in').val(f.files[0].name);
      break;
    default:
      alert('Tập tin này không được hỗ trợ! Bạn chỉ được chọn file ảnh.');
      $("#f").val(null);
      $('#f_in').val(null);
      $("#img0").hide();
  }
}

function confirmSelectFile() {
  var route = '<?=base_url()?>admin/admin/select_final_file/';
  var frm = new FormData($('form#file-select-form')[0]);
  if(frm.get('file').name==''){
    $('#error-select-file').html('Vui lòng chọn một file.');
  }else{
    $.ajax({
      url:route,
      processData: false, 
      contentType: false,
      type:'post',
      dataType:'json',
      data:frm,
      success:function(data){
        if(data.error){
          ssi_modal.notify('error', {content: data.error});
        }
        if(data.success){
          console.log(data.file_res[0]['file']);
          var table = $('#sampleTable').DataTable();
          $('#select-file-modal').modal('hide');
          table.cell($('#file'+frm.get('id'))).data("<a rel = 'prettyPhoto' href = '<?=base_url()?>upload/"+data.file_res[0]['file']+"'><img style='height: 50px; width: 50px;'src='<?=base_url()?>upload/"+data.file_res[0]['file']+"'></a>").draw();
          ssi_modal.notify('success', {content: data.success});
        }
      }
    });
  }
}
</script>
