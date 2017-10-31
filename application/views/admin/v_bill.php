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
              <div class="card-body" style="overflow-x:auto;">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th>ID</th>
                      <th style="min-width: 100px;">Thông tin khách hàng</th>
                      <!-- <th style="min-width: 120px;">Email</th>
                      <th>Số ĐT</th>
                      <th style="min-width: 120px;">Địa chỉ</th> -->
                      <th>Ghi chú</th>
                      <th style="min-width: 100px;">Tên sản phẩm</th>
                      <th>Kích thước</th>
                      <th>Số lượng</th>
                      <th>Đơn giá</th>
                      <th>File thiết kế</th>
                      <th>Trạng thái</th>
                      <th>Opt</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($bill as $row) {
                  	?>
                  	<tr id="row<?php echo $row['id']?>">
                      <td><?php echo $row['id']?></td>
                      <td><?php echo "".$row['customer']."</br>".$row['email']."</br>".$row['phone']."</br>".$row['address']."</br>".$row['created_at']?></td>
                      <!-- <td><?php echo $row['email']?></td>
                      <td><?php echo $row['phone']?></td>
                      <td><?php echo $row['address']?></td> -->
                      <td><?php echo $row['note']?></td>
                      <td><?php echo $row['typedecal'].";</br>".$row['extrusion']?></td>
                      <td><?php echo $row['width']."x".$row['height']." mm"?></td>
                      <td><?php echo $row['quantity']." cái"?></td>
                      <td><?php echo number_format($row['typedecal_price']+$row['extrusion_price'])."₫"?></td>
                      <td><?php echo "<img style='height: 100px; width: 100px;'src='".base_url()."upload/".$row['file']."'>"?></td>
                      <?php 
                        if($row['status']==3) echo "<td>Đã hoàn thành</td>";
                        else if($row['status']==21) echo '<td style="background-color: rgba(255, 0, 255, 0.25);"> Chưa giao hàng; Đã thanh toán</td>';
                        else if($row['status']==20) echo '<td style="background-color: rgba(0, 255, 255, 0.25);"> Chưa giao hàng; Chưa thanh toán</td>';
                        else if($row['status']==1) echo '<td style="background-color: rgba(0, 0, 0, 0.25);"> Đã xác nhận</td>';
                        else echo "<td style='background-color: rgba(255, 0, 0, 0.25);'>Chưa xác nhận</td>";
                      ?>
                      <td>
                  
                        <?php 
                        echo '<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')"></button>';
                        echo '<button class="btn btn-warning btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="cancelRow('. $row['id'] .')"></button>';
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
<?php } ?>
<script type="text/javascript">
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
        },function (result) 
            {
                if(result)
                {
                    var route="<?= base_url()?>admin/admin/cancel_bill/";

                    $.ajax({
                    url:route,
                    type:'GET',
                    data:{
                      id:id,
                    },
                    success:function() {  
                         $('#row'+id).hide();
                        ssi_modal.notify('success', {content: 'Thành công!!'});
                    }
                    });
                    
                 }
                else
                    ssi_modal.notify('error', {content: 'Thất bại: ' + result});
            }
        );
    }
  function editRow(id)
  {
    var  route="<?= base_url()?>admin/admin/edit_bill/id";
    route=route.replace('id',id);
    window.location.replace(route);
  }
</script>