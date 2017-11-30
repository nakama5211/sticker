
      <!-- Navbar-->
      <header class="main-header hidden-print"><a class="logo" href="index.html">HungMinh</a>
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button--><a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu">
            <ul class="top-nav">
              <!--Notification Menu-->
              <li class="dropdown notification-menu"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell-o fa-lg new-bill"></i></a>
                <ul class="dropdown-menu" id="notif-dropdown">
                  <li class="not-head"></li>
                  <!-- <li><a class="media" href="javascript:;"><span class="media-left media-icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                      <div class="media-body"><span class="block">Lisa sent you a mail</span><span class="text-muted block">2min ago</span></div></a></li>
                  <li><a class="media" href="javascript:;"><span class="media-left media-icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                      <div class="media-body"><span class="block">Server Not Working</span><span class="text-muted block">2min ago</span></div></a></li>
                  <li><a class="media" href="javascript:;"><span class="media-left media-icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                      <div class="media-body"><span class="block">Transaction xyz complete</span><span class="text-muted block">2min ago</span></div></a></li> -->
                 <!--  <li class="not-footer"><a href="#">See all notifications.</a></li> -->
                </ul>
              </li>
              <!-- User Menu-->
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu">
                  <li><a href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
                  <li><a href="page-user.html"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                  <li><a href="<?php echo base_url(); ?>admin/users/logout/"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image"></div>
            <div class="pull-left info">
              <?php if(!$this->session->userdata('user_id'))
                echo "<div> NULL </div>";
                else{
                ?>
              
              <p><?php echo $this->session->userdata('username');?></p>
              <p class="designation"><?php switch ($this->session->userdata('group')) {
                case '1':
                  echo('Bộ phận kinh doanh');
                  break;
                case '2':
                  echo('Bộ phận kế toán');
                  break;
                case '3':
                  echo('Bộ phận kỹ thuật');
                  break;
                case '4':
                  echo('Bộ phận thiết kế');
                  break;
                case '5':
                  echo('Gia công/ Giao hàng');
                  break;
                default:
                  echo('admin');
                  break;
              }?></p>
              <?php }?>
            </div>
          </div>
          <!-- Sidebar Menu-->
          <ul class="sidebar-menu">
            <?php if(isset($category)){
              foreach ($category as $key => $value){
                if($key=='revenue'||$key=='resource'){
                      ?>
                      <li class="treeview <?php echo isset($active[$key][0]) ? $active[$key][0] : ''; ?>"><a href="#"><i class="<?php echo $value['icon']?>"></i><span><?php echo $value['name']?></span><i class="fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                          <?php 
                            foreach ($value['content'] as $k => $v) {?>
                              <li><a href="<?php echo base_url().'admin/'.$v['link']?>"><i class="<?php echo isset($active[$key][$k]) ? $active[$key][$k] : 'fa fa-circle'; ?>"></i> <?php echo $v['name']?></a></li>
                            <?php }
                           ?>
                        </ul>
                      </li>
                    <?php 
                }else{
                ?>
                <li class="<?php echo isset($active[$key]) ? $active[$key] : ''; ?>"><a href="<?php echo base_url().'admin/'.$value['link']?>"><i class="<?php echo $value['icon'];?>"></i><span><?php echo $value['name'];?></span></a></li>
            <?php }}}?>
          </ul>
        </section>
      </aside>
      
    