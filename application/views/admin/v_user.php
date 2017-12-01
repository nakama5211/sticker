<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
  else{
                ?>
<div class="content-wrapper">
        <div class="page-title">
          <div>
            <h1>Quản lý thành viên</h1>
            <ul class="breadcrumb side">
              <li><i class="fa fa-home fa-lg"></i></li>
              <li>Tables</li>
              <li class="active"><a href="#">Quản lý thành viên</a></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body ">
                <div class="col-md-11">
                  <!-- <button class="btn btn-success btn-lg" id="dropbtn" title="Lọc dự án"><i class="fa fa-filter" aria-hidden="true"></i></button> -->
                </div>
                <div>
                  <button class="btn btn-primary btn-lg glyphicon glyphicon-plus" data-toggle="modal" data-target="#addUser" title="Thêm thành viên mới"></button>
                </div>
              </div>
            </div>
          </div>  
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class=" astripe row-border order-column" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th></th>
                      <th class="col-data-table-0-6">Ảnh đại diện</th>
                      <th class="col-data-table-1-9">Tên nhân viên</th>
                      <th class="col-data-table-0-8">Phòng ban</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($users as $row) {
                  	?>
                  	<tr id="row_<?php echo $row['id']?>">
                      <td></td>
                      <td><img src="<?php echo $row['avatar']?>" style="width: 100px;height: 100px"></td>
                      <td id="name_<?php echo $row['id']?>"><?php echo $row['username']?></td>
                      <?php foreach ($department as $depar) {
                              if($depar['id'] == $row['group'] ) { ?>
                                <td id="group_<?php echo $row['id']?>"><?php echo $depar['name']?></td>
                      <?php } } ?>
                      <td>
                        <?php 
                          echo '<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')">
                              </button>';
                        ?>
                        <button class="btn btn-danger btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="deleteRow(<?php echo $row['id'] ?>)"></button>
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



<!-- form thêm mới -->
<div class="modal fade" id="addUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;">Thêm nhân viên mới</h4>
        </div>
        <form method="post" id="add-form" enctype="multipart/form-data">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                       <div><b>Chọn ảnh đại diện</b></div>
                       <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-folder-open"></span>
                          </div>
                          <input type="text" class="form-control" name="avatar" id="i_file">
                       </div>
                       <!-- <div class="alert alert-danger hide"></div>
                       <div class="alert alert-success hide"></div> -->
                    </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                       <div><b>Tên đăng nhập</b></div>
                       <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-folder-open"></span>
                          </div>
                          <input type="text" class="form-control" name="username">
                       </div>
                    </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                       <div><b>Mật khẩu</b></div>
                       <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-folder-open"></span>
                          </div>
                          <input type="password" class="form-control" name="password">
                       </div>
                    </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                       <div><b>Chọn phòng ban</b></div>
                       <div class="input-group">
                          <div class="input-group-addon iga2">
                             <span class="glyphicon glyphicon-folder-open"></span>
                          </div>
                          <Select class=" form-control"  name="phong_ban" id="groupAdd">
                                <?php foreach ($department as $depar) { ?>
                                  <option name="<?php echo $depar['name'] ?>" value="<?php echo $depar['id'] ?>"><?php echo $depar['name'] ?></option>
                                <?php } ?>
                          </Select>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" id="add"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end form thêm -->

  <!-- form edit -->
  <div class="modal fade" id="editUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
           <h4 class="modal-title" style="font-size: 20px; padding: 12px;"> Chỉnh sửa thông tin nhân viên </h4>
        </div>
        <form method="post" id="edit-form" enctype="multipart/form-data">
        <div class="modal-body">
           <div class="container-fluid">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12" id="form-data-edit">
                 </div>
              </div>
           </div>
        </div>

        <div class="modal-footer">
           <div class="form-group">
              <button type="button" class="btn btn-sm btn-info" onclick="editFormUser()"> Save <span class="glyphicon glyphicon-saved"></span></button>
              <button type="button" data-dismiss="modal" class="btn btn-sm btn-default"> Cancel <span class="glyphicon glyphicon-remove"></span></button>
           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
<!-- end form edit -->
<?php } ?>
<script type="text/javascript">

$('#add').on('click',function(){
      var route = "<?= base_url()?>admin/Users/insertUser";
      var frm = new FormData($('form#add-form')[0]);
      var avatar = frm.get('avatar');
      var username = frm.get('username');
      var group = $('#groupAdd').find(":selected").attr('name');
      $.ajax({
        url:route,
        processData:false,
        contentType:false,
        type:'post',
        data:frm,
        success:function(data) { 
          var row = [];
              row.push('<td></td>');
              row.push('<td><img src="'+avatar+'" style="width: 100px;height: 100px"></td>');
              row.push('<td>'+username+'</td>');
              row.push('<td>'+group+'</td>');
              row.push('<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" data-toggle="modal" data-target="#editUser" data-id='+data+'></button><button class="btn btn-danger btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="deleteRow('+data+')"></button>');
              
              var rowIndex = $('#sampleTable').dataTable().fnAddData(row);
              var idrow =   $('#sampleTable').dataTable().fnGetNodes(rowIndex);
              $(idrow).attr('id','row_'+data);
              $('#addUser').modal('hide');
        }
      });
      
  });

function editRow(id_user){
  $.ajax({
    url:'<?=base_url()?>admin/users/load_data_for_edit_form_user/',
    type:'post',
    dataType:'json',
    data:{
      id:id_user
    },
    success:function(data){
      $('#form-data-edit').html(data);
      $('#editUser').modal('show');
    }
  });
}
function editFormUser(){
  var route = '<?=base_url()?>admin/users/updateUser';
  var frm = new FormData($('form#edit-form')[0]);
  var id = frm.get('id');
  var avatar = frm.get('avatar');
  var username = frm.get('username');
  var group = $('#groupEdit').find(":selected").attr('name');
  $.ajax({
    url:route,
    processData: false, 
    contentType: false,
    type:'post',
    data:frm,
    success:function(data){
      if (data === 'success') {
        $('#sampleTable').dataTable().fnDeleteRow($('#row_'+id));
          var row = [];
          row.push('<td></td>');
          row.push('<td><img src="'+avatar+'" style="width: 100px;height: 100px"></td>');
          row.push('<td>'+username+'</td>');
          row.push('<td>'+group+'</td>');
          row.push('<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" data-toggle="modal" data-target="#editUser" data-id='+id+'></button><button class="btn btn-danger btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="deleteRow('+id+')"></button>');
          
          var rowIndex = $('#sampleTable').dataTable().fnAddData(row);
          var idrow =   $('#sampleTable').dataTable().fnGetNodes(rowIndex);
          $(idrow).attr('id','row_'+id);
        $('#editUser').modal('hide');
      }
          
          
    }
  });
}

 function deleteRow(id)
    {
      
      ssi_modal.confirm({
        content: 'Bạn có muốn xóa hồ sơ này không?',
        okBtn: {
          className:'btn btn-primary'
        },
        cancelBtn:{
          className:'btn btn-danger'
        }
      },function (result)
      {
        if(result)
        {
          var route="<?php echo base_url() ?>admin/users/deleteRow";
          $.ajax({
            url:route,
            type:'post',
            data:{id:id},
            success:function(data) {
              if (data === 'success') {
                $('#sampleTable').dataTable().fnDeleteRow($('#row_'+id));
              }
            }
          });
        }
        else
          ssi_modal.notify('error', {content: "Hủy xóa"});
        }
      );
    }
</script>