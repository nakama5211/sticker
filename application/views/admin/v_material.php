
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
              <div class="card-body" style="overflow-x:auto;">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr style="text-align: center;">
                      <th>ID</th>
                      <th style="min-width: 100px;">Tên vật liệu</th>
                      <th>Tổng số lượng</th>
                      <th style="min-width: 100px;">Số lượng bán</th>
                      <th>Giá nhập</th>
                      <th>Giá bán</th>
                      <th>Mô tả</th>
                      <th>Ngày tạo</th>
                      <th>Ngày cập nhật</th>
                      <th>Opt</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php foreach ($material as $row) {
                  	?>
                  	<tr id="row<?php echo $row['id']?>">
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['name']?></td>
                      <td><?php echo $row['quantity']?></td>
                      <td><?php echo $row['sale_qty']?></td>
                      <td><?php echo $row['imp_price']?></td>
                      <td><?php echo $row['exp_price']?></td>
                      <td><?php echo $row['description']?></td>
                      <td><?php echo $row['created_at']?></td>
                      <td><?php echo $row['updated_at']?></td>
                      <td>
                  		<?php 
                        echo '<button class="btn btn-info btn-lg glyphicon glyphicon-hand-right" style="border-radius: 10px;" onclick=""></button>';
                        echo '<button class="btn btn-primary btn-lg glyphicon glyphicon-edit" style="border-radius: 10px;" onclick=""></button>';
                        echo '<button class="btn btn-warning btn-lg glyphicon glyphicon-trash" style="border-radius: 10px;" onclick=""></button>';
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
