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
              <div class="card-body ">
                <div class="col-md-11">
                  <button class="btn btn-success btn-sm" id="dropbtn" title="Lọc dự án"><i class="fa fa-filter" aria-hidden="true"></i></button>
                  <div class="dropdown-content">
                    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>admin/admin/filterRevenue">
                      <input type="hidden" id="statusDrop" value="0">
                      <input type="hidden" name="typeProject" value="2">
                      <br>
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
                          <a class="btn btn-info" href="<?php echo base_url() ?>admin/admin/view_admin/business">Tất cả</a> 
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
                      <th class="col-data-table-0-7">Ngày/Tháng/Năm</th>
                      <th class="col-data-table-2">Tên CR-CD</th>
                      <th class="col-data-table-1">Ngày đặt hàng</th>
                      <th class="col-data-table-0-9">NV phụ trách</th>
                      <th class="col-data-table-0-8">Số lượng</th>
                      <th class="col-data-table-0-6">Đơn giá</th>
                      <th class="col-data-table-1-5">Doanh thu LK+TK+GC</th>
                      <th class="col-data-table-1-2">Tạm ứng</th>
                      <th class="col-data-table-1-3">Thời gian tạm ứng</th>
                      <th class="col-data-table-1-2">Giảm giá</th>
                      <th class="col-data-table-1-2">Chi phí giao hàng</th>
                      <th class="col-data-table-0-9">Doanh thu</th>
                      <th class="col-data-table-1-4">Tình trạng đơn hàng</th>
                      <th class="col-data-table-1-4">Tình trạng thu tiền</th>
                      <th class="col-data-table-1-5">Thời gian hoàn thành</th>
                      <th class="col-data-table-0-9">Ghi chú</th>
                      <th class="col-data-table-1-8">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($revenue as $row) {
                    ?>
                    <tr id="row<?php echo $row['id']?>">
                      <td></td>
                      <td><?php echo isset($row['id']) ? $row['id'] : '';?></td>
                      <td><?php echo isset($row['ngay_thang_nam']) ? $row['ngay_thang_nam'] : '';?></td>
                      <td><?php echo isset($row['name']) ? $row['name'] : '';?></td>
                      <td><?php echo isset($row['ngay_dat']) ? $row['ngay_dat'] : '';?></td>
                      <td><?php echo isset($row['nv_phu_trach']) ? $row['nv_phu_trach'] : '';?></td>
                      <td><?php echo isset($row['quantity']) ? number_format($row['quantity']) : '';?></td>
                      <td><?php echo isset($row['don_gia']) ? number_format($row['don_gia']) : '';?></td>
                      <td><?php echo isset($row['doanh_thu_lk_tk_gc']) ? number_format($row['doanh_thu_lk_tk_gc']) : '';?></td>
                      <td><?php echo isset($row['tam_ung']) ? number_format($row['tam_ung']) : '';?></td>
                      <td><?php echo isset($row['tg_tam_ung']) ? $row['tg_tam_ung'] : '';?></td>
                      <td><?php echo isset($row['giam_gia']) ? number_format($row['giam_gia']) : '';?></td>
                      <td><?php echo isset($row['chiphi_giaohang']) ? number_format($row['chiphi_giaohang']) : '';?></td>
                      <td><?php echo isset($row['tong_doanhthu']) ? number_format($row['tong_doanhthu']) : '';?></td>
                      <td><?php echo isset($row['tt_don_hang']) ? $row['tt_don_hang'] : '';?></td>
                      <td><?php echo isset($row['tt_thu_tien']) ? $row['tt_thu_tien'] : '';?></td>
                      <td><?php echo isset($row['tg_hoan_thanh']) ? $row['tg_hoan_thanh'] : '';?></td>
                      <td><?php echo isset($row['note']) ? $row['note'] : '';?></td>
                      <td>
                  
                        <?php 
                        echo '<button class="btn btn-primary btn-sm glyphicon glyphicon-edit" style="border-radius: 10px;" onclick="editRow('. $row['id'] .')"></button>';
                        echo '<button class="btn btn-warning btn-sm glyphicon glyphicon-trash" style="border-radius: 10px;" onclick="cancelRow('. $row['id'] .')"></button>';
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
</script>